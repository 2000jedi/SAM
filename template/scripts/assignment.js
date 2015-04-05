/* Click to expand module start */
function typeHTML(type, subject){
    type = type - 1;
    var color = new Array("black", "#0C0", "#F33", "#F93");
    var typeText = new Array("Assignment ONE DAY LEFT", "Information", "Assignment TWO DAYS LEFT", "Assignment");
    return "   <div class='card2-title' style='background:"+ color[type] +"'>"+subject+" "+typeText[type]+"</div>";
}
function whetherExpandHTML(id, content){
    if (content.length > 200){
        return "           <div style='margin:0.5em' onclick='contentExpanding("+id+")'><a href='#'>Click to display/hide.</a></div>";
    }else{
        return "           ";
    }
}
function whetherExpandCSS(content) {
    if (content.length > 200){
        return "height: 3em; overflow: hidden; box-shadow: inset 0px -10px 5px #DDD";
    }else{
        return "";
    }
}
function contentExpanding(id){
    var cssText1 = "3em", cssText2 = "hidden", cssText3 = "inset 0px -10px 5px #DDD";
    if ( $('#assignment-list-content-'+id).css("overflow") == "hidden"){
        cssText1 = "";
        cssText2 = "";
        cssText3 = "";
    }
    $('#assignment-list-content-'+id).css("height", cssText1).css("overflow", cssText2).css("box-shadow", cssText3);
}
/* Click to expand module end */

/* Delete Assignment Start */
function deleteAssignment(id){
    var conf = confirm("DO YOU REALLY want to delete the assignment?\nData will be permanently removed from server.\n\nTips: You should copy the content if you merely want to edit the assignment/information.");
    if (conf == true) {
        $.get("/modules/assignment/deleteAssignment.php",{assignment: id},function(data){
            $('#assignment-list-'+id).remove();
            alert(data);
        });
    }
}
/* Delete Assignment End */

/* Mark Completion Start */
function markCompletion(id){
    var actual = prompt("You may tell us how much time you actually spent on the assignment. The data will be used to predict your actual completion time based on the estimation by your teacher. (You can leave it blank or input non-numeric values. It will not be recorded.)\n\nDO YOU REALLY want to mark the assignment as completed?\nIt will not be counted into recommendation any more.");
    if (actual == null){
        return;
    }
    $.post("/modules/assignment/markCompletion.php",{id: id, actual: actual}, function(data){
        loadAssignment(function(){
            $('#assignment-list').html("");
        });
        alert(data);
    });
}
/* Mark Completion End */

function diff(where, app, assignment){
    if (where == "prefix-id"){
        if (app == "teacher"){
            return "assignment-list-" + assignment.id;
        }else if (app == "student"){
            return "assignment-list-" + assignment.id;
        }else if (app == "student-in-class"){
            return "assignment-list-class-" + assignment.id;
        }
    }else if (where == "prefix-content-id"){
        if (app == "teacher"){
            return "assignment-list-content-" + assignment.id;
        }else if (app == "student"){
            return "assignment-list-content-" + assignment.id;
        }else if (app == "student-in-class"){
            return "assignment-list-content-2-" + assignment.id;
        }
    }else if (where == "expand-content"){
        if (app == "teacher"){
            return whetherExpandHTML("\""+assignment.id+"\"", "\""+assignment.content+"\"");
        }else if (app == "student"){
            return whetherExpandHTML("\""+assignment.id+"\"", "\""+assignment.content+"\"");
        }else if (app == "student-in-class"){
            return whetherExpandHTML("\"2-"+assignment.id+"\"", "\""+assignment.content+"\"");
        }
    }else if (where == "additional-button"){
        if (app == "teacher"){
            var html = "";
            html += "       <div>";
            html += "           <button class='pure-button pure-button-primary' style='display: inline-block' onclick='deleteAssignment(\"" + assignment.id + "\")'> Delete </button>";
            html += "       </div>";
            return html;
        }else if (app == "student"){
            var html = "";
            if (assignment.type != 2) {
                html += "       <div>";
                html += "           <button class='pure-button pure-button-primary' style='display: inline-block' onclick='markCompletion(\"" + assignment.id + "\")'> Mark As Completed </button>";
                html += "       </div>";
            }
            return html;
        }else if (app == "student-in-class"){
            return "";
        }
    }
}
function Assignment(app, id, type, content, attachment, publish, dueday, subject, duration){
    function dealWithType(type, dueday){
        var daysLeft = DateDiff.inDays(new Date(), new Date(dueday));
        if (type == "2"){
            return 2;
        }
        if (daysLeft == 1){
            return 1;
        }else if (daysLeft == 2){
            return 3;
        }else if (daysLeft > 2 || daysLeft <= 0){
            return 4;
        }
    }
    function dealWithAttachment(attachment) {
        if (attachment == "null"){
            return "No attachment.";
        }else{
            return "<a target=_blank href='" + attachment +"'>Attachment</a>";
        }
    }
    this.app = app;

    this.id = id;
    this.type = dealWithType(type, dueday);
    this.content = content;
    this.attachment = dealWithAttachment(attachment);
    this.publish = publish;
    this.dueday = dueday;
    this.subject = subject.substr(0,1).toUpperCase() + subject.substr(1).toLowerCase();
    this.duration = duration + " hours";

    this.getHTML = function() {
        var html = "";
        html += "<div id='" + diff("prefix-id", this.app, this) + "' class='card2 card-limit'>";
        html += typeHTML(this.type, this.subject);
        html += "   <div class='card2-content'>";
        html += "       <div style='margin-bottom: 0.5em'>";
        html += "           <div style='margin:0.5em'>Subject: " + this.subject + "</div>";
        html += "           <div style='margin:0.5em;display:table;width:100%;text-align:left'>"
        html += "               <div style='display:table-cell'>Published: " + this.publish + "</div>";

        var dueDayLabel = new Array("Due: ", "Expire: ");
        html += "               <div style='display:table-cell'>"+ dueDayLabel[parseInt(type)-1] + this.dueday + "</div>";
        html += "           </div>";
        if (parseInt(type) == 1){
            html += "       <div style='margin:0.5em'>Estimated duration: " + this.duration + "</div>";
        }
        html += "           <div style='margin: 0.5em; border: 1px solid #EEE; padding:0.5em; border-bottom: 2px solid #DDD;"+whetherExpandCSS(this.content)+"' id='" + diff("prefix-content-id", this.app, this) + "'>" + Utils.string.formattedPostContent(this.content) + "</div>";
        html += diff("expand-content", this.app, this);
        html += "           <div style='margin:0.5em'>Attachment: " + this.attachment + "</div>";
        html += "       </div>";
        html += diff("additional-button", this.app, this);
        html += "   </div>";
        html += "</div>";
        return html;
    }
}