/* Click to expand module start */
function typeColor(type){
    type = type - 1;
    var color = new Array("#FF9999", "#E0FFE0", "#FFBBAA", "#FFEEBB");
    return color[type];
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
        });
    }
}
/* Delete Assignment End */
/* Update Assignment Start */
function updateAssignment(id){
    var idS = id.split("-");
    var assignmentID = idS[idS.length-1];

    var content = $("#"+id).html().replace(/<br.*?>/g, "\n");
    $('#update-card-content-id').html(assignmentID);
    $('#update-card-content-ta').val(content);

    openUpdateCardBox();
}
function sendUpdateAssignment(){
    var id = $('#update-card-content-id').html();
    var content = $('#update-card-content-ta').val();
    $.post("/modules/assignment/updateAssignment.php",{id: id, content: content}, function(data){
        alert(data);
        $('#update-card-content-id').html("");
        $('#update-card-content-ta').val("");
        $('#shadow').hide();

        loadAssignment($('#right-part-class-id').html(), function(){
            $('#assignment-list').html("");
        });
    })
}
/* Update Assignment End */


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
    });
}
function markInfoAsRead(id){
    var conf = confirm("DO YOU REALLY read the information?");
    if (conf == true) {
        $.post("/modules/assignment/markCompletion.php", {id: id, actual: 0}, function (data) {
            loadAssignment(function () {
                $('#assignment-list').html("");
            });
        });
    }
}
function markUnCompletion(id){
    $.post("/modules/assignment/markUnCompletion.php",{id: id}, function(data){
        loadAssignment(function(){
            $('#assignment-list').html("");
        });
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
            html += "           <button class='pure-button pure-button-primary' style='display: inline-block' onclick='updateAssignment(\"" + diff("prefix-content-id", assignment.app, assignment) + "\")'> Update Content </button>";
            html += "       </div>";
            return html;
        }else if (app == "student"){
            var html = "";
            if (assignment.type != 2 && !assignment.finished) {
                html += "       <div>";
                html += "           <button class='pure-button pure-button-primary' style='display: inline-block' onclick='markCompletion(\"" + assignment.id + "\")'> Mark As Completed </button>";
                html += "       </div>";
            }
            if (assignment.type != 2 && assignment.finished) {
                html += "       <div>";
                html += "           <button class='pure-button pure-button-primary' style='display: inline-block' onclick='markUnCompletion(\"" + assignment.id + "\")'> Mark As Uncompleted </button>";
                html += "       </div>";
            }
            if (assignment.type == 2 && !assignment.finished) {
                html += "       <div>";
                html += "           <button class='pure-button pure-button-primary' style='display: inline-block' onclick='markInfoAsRead(\"" + assignment.id + "\")'> Mark As Read </button>";
                html += "       </div>";
            }
            return html;
        }else if (app == "student-in-class"){
            return "";
        }
    }
}
function Assignment(app, id, type, content, attachment, publish, dueday, subject, duration, finished){
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
            var arr = attachment.split(";"), html = "";
            for (var i = 1; i < arr.length-1; i = i+2){
                var url = arr[i];
                var name = arr[i+1];
                var hrefText = "/modules/common/downloader.php?path=" + url + "&name=" + name;
                html += " <a target=_blank href='" + hrefText +"'>" + arr[i+1] + "</a>";
            }
            return html;
        }
    }
    this.app = app;

    this.id = id;
    this.type = dealWithType(type, dueday);
    this.content = content;
    this.attachment = dealWithAttachment(attachment);
    this.publish = publish;
    this.dueday = dueday;
    this.subject = subject;
    this.duration = duration;
    this.finished = finished;

    this.getHTML = function() {
        var html = "";
        var finishedCSS = "";
        if (this.finished) {
            finishedCSS = " style='opacity:0.6'"
        }
        html += "<div id='" + diff("prefix-id", this.app, this) + "' class='card2 card-limit'" + finishedCSS + " style='position: relative'>";
        html += "   <div style='position: absolute; right: 0; top: 0; width: 140px; height: 70px; color: grey'>";
        function calculateDaysLeft(dueday) {
            var daysLeft = DateDiff.inDays(new Date(), new Date(dueday));
            if (daysLeft < 0) {
                daysLeft = 0;
            }
            return daysLeft;
        }

        var daysLeft = calculateDaysLeft(this.dueday);
        if (this.type != 2) {
            html += "       <div style='line-height: 70px; position: absolute; width:70px; top:0; right: 70px; font-size: 1.5em; text-align: center; background: " + typeColor(this.type) + "'>" + daysLeft + "</div>";
        }
        if (this.type != 2) {
            html += "       <div style='line-height: 70px; position: absolute; width:70px; top:0; right: 0px; font-size: 1.1em; background: #E0F3FD; text-align: center;'>" + this.duration + " min</div>";
        } else {
            html += "       <div style='line-height: 70px; position: absolute; width:70px; top:0; right: 0px; font-size: 1.2em; background: #e0ffe0; text-align: center;'>Info</div>";
        }
        if ( this.type != 2 ) {
            html += "       <div style='right: 73px; bottom: 0px; font-size: 0.8em; position: absolute'>days left</div>";
        }
        if (this.type != 2){
            html += "       <div style='right: 3px; bottom: 0px; font-size: 0.8em; position: absolute'>needed</div>";
        }
        html += "   </div>";
        html += "   <div class='card2-content'>";
        if ( this.type == 2 && daysLeft > 1000 ) {
            html += "       <div style='height: 50px; margin-left: 0.5em'>";
            html += "           <div style='margin-bottom: 0.5em; margin-top: 0.5em'><span style='border-bottom: 1px #BBB dotted; font-size: 1.2em'><b>" + this.subject + "</b></span></div>";
        }else{
            html += "       <div style='height: 70px; margin-left: 0.5em'>";
            html += "           <div style='margin-bottom: 0.5em'><span style='border-bottom: 1px #BBB dotted; font-size: 1.2em'><b>" + this.subject + "</b></span></div>";
        }
        if (app == "teacher") {
            html += "           <div style='margin-bottom: 0.5em'><span style='border-bottom: 1px #BBB dotted'>Published: " + this.publish + "</span></div>";
        }
        if ( !( this.type == 2 && daysLeft > 1000) ) {
            var dueDayLabel = new Array("Due", "Expire");
            html += "           <div><span style='border-bottom: 1px #BBB dotted'><span class='blockSpanForSmallScreen'>" + dueDayLabel[parseInt(type) - 1] + ": </span><span class='blockSpanForSmallScreen'>" + this.dueday + "</span></span></div>";
        }
        html += "       </div>";
        html += "       <div style='margin: 0.5em; border: 2px solid #EEE; padding:0.5em; border-bottom: 3px solid #DDD;"+whetherExpandCSS(this.content)+"' id='" + diff("prefix-content-id", this.app, this) + "'>" + Utils.string.formattedPostContent(this.content) + "</div>";
        html += diff("expand-content", this.app, this);
        html += "       <div style='margin:0.5em'>Attachment: <span>" + this.attachment + "</span></div>";
        html += diff("additional-button", this.app, this);
        html += "   </div>";
        html += "</div>";
        return html;
    }
}