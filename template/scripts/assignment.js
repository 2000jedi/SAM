/* Click to expand module start */
function typeColorBackground(type){
    type = type - 1;
    var color = new Array("rgba(255,52,25,1)", "rgba(21, 199, 2, 1)", "rgba(255,153,33,1)", "rgba(71,71,71,1)");
    return color[type];
}
function typeColorBox(type){
    type = type - 1;
    var color = new Array("rgba(255,101,80,1)", "rgba(77, 212, 63, 1)", "rgba(255,177,86,1)", "rgba(115,115,115,1)");
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
    var actual = prompt("You may tell us how much time you actually spent on the assignment (in minutes). (You can leave it blank.)");
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
            html += "           <button class='pure-button pure-button-primary' style='display: inline-block' onclick='updateAssignment(\"" + diff("prefix-content-id", assignment.app, assignment) + "\")'> Update Content </button>";
            html += "       </div>";
            return html;
        }else if (app == "student"){
            return "";
        }else if (app == "student-in-class"){
            return "";
        }
    }else if (where == "iconButton"){
        var html = "";
        if (app == "student") {
            if (assignment.type != 2 && !assignment.finished) {
                html += "<img src='/files/icons/finished.png' width='50px' height='50px' onclick='markCompletion(\"" + assignment.id + "\")' />";
            }
            if (assignment.type != 2 && assignment.finished) {
                html += "<img src='/files/icons/unfinished.png' width='50px' height='50px' onclick='markUnCompletion(\"" + assignment.id + "\")'/>";
            }
            if (assignment.type == 2 && !assignment.finished) {
                html += "<img src='/files/icons/finished.png' width='50px' height='50px' onclick='markInfoAsRead(\"" + assignment.id + "\")'/>";
            }
        }else if ( app == "teacher"){
            html += "<img src='/files/icons/delete.png' width='50px' height='50px' onclick='deleteAssignment(\"" + assignment.id + "\")'/>";
        }
        return html;
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
                html += " <a target=_blank style='display:block' href='" + hrefText +"'>" + arr[i+1] + "</a>";
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
        function calculateDaysLeft(dueday) {
            var daysLeft = DateDiff.inDays(new Date(), new Date(dueday));
            if (daysLeft < 0) {
                daysLeft = 0;
            }
            return daysLeft;
        }
        var daysLeft = calculateDaysLeft(this.dueday);

        html += "<div id='" + diff("prefix-id", this.app, this) + "' class='card2 card-limit'" + finishedCSS + " style='position: relative'>";
        if ( this.type == 2 && daysLeft > 1000 ) {
            html += "   <div style='height: 70px; padding:1.5em 0 0 1.0em; color: white; background: " + typeColorBackground(this.type) + "'>";
            html += "       <div style='margin-bottom: 0.5em; margin-top: 0.5em'><span style='font-size: 1.2em'><b>" + this.subject + "</b></span></div>";
        }else{
            html += "   <div style='height: 70px; padding:1.5em 0 0 1.0em; color: white; background: " + typeColorBackground(this.type) + "'>";
            html += "       <div style='margin-bottom: 0.5em'><span style='font-size: 1.2em'><b>" + this.subject + "</b></span></div>";
        }
        if (app == "teacher") {
            // html += "           <div style='margin-bottom: 0.5em'><span>Published: " + this.publish + "</span></div>";
        }
        if ( !( this.type == 2 && daysLeft > 1000) ) {
            var dueDayLabel = new Array("Due", "Expire");
            html += "           <div><span><span class='blockSpanForSmallScreen'>" + dueDayLabel[parseInt(type) - 1] + ": </span><span class='blockSpanForSmallScreen'>" + this.dueday + "</span></span></div>";
        }
        html += "       </div>";
        html += "   <div style='position: absolute; right: 0; top: 0; width: 150px; height: 83px; color: white'>";
        if (this.type != 2) {
            html += "       <div style='line-height: 70px; position: absolute; width:70px; top:13px; right: 90px; font-size: 1.5em; text-align: center; background: " + typeColorBox(this.type) + "'>" + daysLeft + "</div>";
        }
        if (this.type != 2) {
            html += "       <div style='line-height: 70px; position: absolute; width:70px; top:13px; right: 10px; font-size: 1.1em; background: " + typeColorBox(this.type) + "; text-align: center;'>" + this.duration + " min</div>";
        } else {
            html += "       <div style='line-height: 70px; position: absolute; width:70px; top:13px; right: 10px; font-size: 1.2em; background: " + typeColorBox(this.type) + "; text-align: center;'>Info</div>";
        }
        if ( this.type != 2 ) {
            html += "       <div style='right: 93px; bottom: 0px; font-size: 0.8em; position: absolute'>days left</div>";
        }
        if (this.type != 2){
            html += "       <div style='right: 13px; bottom: 0px; font-size: 0.8em; position: absolute'>needed</div>";
        }
        html += "   </div>";
        html += "   <div class='card2-content'>";
        html += "       <div style='margin:0.5em 0; border: 2px solid #EEE; padding:0.5em; border-bottom: 3px solid #DDD;"+whetherExpandCSS(this.content)+"' id='" + diff("prefix-content-id", this.app, this) + "'>" + Utils.string.formattedPostContent(this.content) + "</div>";
        html += diff("expand-content", this.app, this);
        html += diff("additional-button", this.app, this);
        html += "       <div style='display: table; width: 100%; margin: 0.5em 0; vertical-align: top'>";
        html += "           <div style='display: table-cell; width: 50px; height: 50px'><img src='/files/icons/attachment.png' width='50px' height='50px' /></div>";
        html += "           <div style='display: table-cell; vertical-align: top; text-align: left; padding: 10px'>" + this.attachment + "</div>";
        html += "           <div style='display: table-cell; width: 50px; height: 50px'>" + diff("iconButton", this.app, this) + "</div>";
        html += "       </div>";
        html += "   </div>";
        html += "</div>";
        return html;
    }
}