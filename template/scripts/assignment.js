/*

    Part I: Manipulate Assignment
    - It provides API for Assignment() to create UI
    - It also provides API for button to process a specific assignment

 */
function ManipulateAssignment(id){
    this.id = id;

    this.contentExpanding = function(){
        var cssText1 = "3em", cssText2 = "hidden", cssText3 = "inset 0px -10px 5px #DDD";
        if ( $('#assignment-list-content-'+this.id).css("overflow") == "hidden"){
            cssText1 = "";
            cssText2 = "";
            cssText3 = "";
        }
        $('#assignment-list-content-'+this.id).css("height", cssText1).css("overflow", cssText2).css("box-shadow", cssText3);
    };

    this.deleteAssignment = function(){
        var conf = confirm("DO YOU REALLY want to delete the assignment?");
        if (conf == true) {
            var HWID = this.id;
            $.get("/modules/assignment/deleteAssignment.php",{assignment: HWID},function(data){
                $('#assignment-list-'+HWID).remove();
            });
        }
    };

    this.updateAssignment = function(){
        var idS = this.id.split("-");
        var assignmentID = idS[idS.length-1];

        var content = $("#"+this.id).html().replace(/<br.*?>/g, "\n");
        $('#update-card-content-id').html(assignmentID);
        $('#update-card-content-ta').val(content);

        new Class('','').openUpdateCardBox();
    };

    this.sendUpdateAssignment = function(){
        var id = $('#update-card-content-id').html();
        var content = $('#update-card-content-ta').val();
        $.post("/modules/assignment/updateAssignment.php",{id: id, content: content}, function(data){
            alert(data);
            $('#update-card-content-id').html("");
            $('#update-card-content-ta').val("");
            $('#shadow').hide();

            new Class($('#right-part-class-id').html(),'').loadAssignment(1, function(){
                $('#assignment-list').html("");
            });
        })
    };

     this.markCompletion = function(){
        var actual = prompt("You may tell us how much time you actually spent on the assignment (in minutes). (You can leave it blank.)");
        if (actual == null){
            return;
        }
        $.post("/modules/assignment/markCompletion.php",{id: this.id, actual: actual}, function(data){
            loadAssignment(function(){
                $('#assignment-list').html("");
            });
        });
    };

    this.markInfoAsRead = function(){
        var conf = confirm("DO YOU REALLY read the information?");
        if (conf == true) {
            $.post("/modules/assignment/markCompletion.php", {id: this.id, actual: 0}, function (data) {
                loadAssignment(function () {
                    $('#assignment-list').html("");
                });
            });
        }
    };
    this.markUnCompletion = function(){
        $.post("/modules/assignment/markUnCompletion.php",{id: this.id}, function(data){
            loadAssignment(function(){
                $('#assignment-list').html("");
            });
        });
    };

    this.updateScoresPopUp = function(){
        $('#floatBox-update-scores-dynamic-inputs').html("");
        var assignmentID = this.id;
        $.get("/modules/assignment/loadPersonalScores.php",{assignment: assignmentID}, function(data){
            data = JSON.parse(data);

            var num = data.length/3;
            $('#floatBox-update-scores-assignment-id').html(assignmentID);
            $('#floatBox-update-scores-assignment-num').html(num);

            var html = "<div>";
            html += "   <span style='width: 80px; display: inline-block'>IDs</span>";
            html += "   <span style='width: 80px; display: inline-block'>Names(C)</span>";
            html += "   <span style='width: 80px; display: inline-block'>Names(E)</span>";            
            html += "   <span style='width: 80px; margin-left: 1em'>Scores (0-100)</span>";
            html += "</div>"
            for (var i = 0; i < (data.length/3); i++){
                var uid = data[i*3];
                var username = data[i*3+1];
                var score = data[i*3+2];
                var ChineseName = data[i*3+1];
                var EnglishName = data[i*3+1];
                //[2015/10/18]Pelin to Sam: Please set the correct data for "Chinese Name" and "English Name", I am just using the student ID as spaceholders.

                html += "<div>";
                html += "   <span id='floatBox-update-scores-dynamic-inputs-uid-"+i+"' style='display:none'>" + uid + "</span>";
                html += "   <span id='floatBox-update-scores-dynamic-inputs-username-"+i+"' style='width:80px'>" + username + "</span>";
                html += "   <span id='floatBox-update-scores-dynamic-inputs-username-"+i+"' style='width:80px'>" + ChineseName + "</span>";
                html += "   <span id='floatBox-update-scores-dynamic-inputs-username-"+i+"' style='width:80px'>" + EnglishName + "</span>";
                html += "   <input id='floatBox-update-scores-dynamic-inputs-score-"+i+"' type='number' style='width:80px; display:inline; margin-left: 1em' value='" + score + "' />";
                html += "</div>"
            }

            $('#floatBox-update-scores-dynamic-inputs').append(html);

            $('#floatBox-update-card').hide();
            $('#floatBox-view-members').hide();
            $('#floatBox-add-card').hide();
            $('#floatBox-update-scores').show();
            $('#floatBox-title').html("Update Score");
            $('#add-card-class-id').val(this.id);
            $('#add-card-class-id-2').val(this.id);
            $('#shadow').css("display","table");
        });
    };

    this.updateScores = function(num){

        var uidParameter = "", scoreParameter = "";
        for (var i = 0; i < num; i++){
            var uid = ";" + $('#floatBox-update-scores-dynamic-inputs-uid-' + i).html();
            var score = ";" + $('#floatBox-update-scores-dynamic-inputs-score-' + i).val();
            uidParameter += uid;
            scoreParameter += score;
        }

        $.post("/modules/assignment/updatePersonalScore.php",{assignment: this.id, students: uidParameter, scores: scoreParameter}, function(data){
            alert("Success!");
            $('#shadow').hide();
        });
    }

}
// Part I ends


/*

    Part II: Assignment UI
    - It creates the assignment card UI in different conditions


    Parameter app:
        'student' - Student Stream View
        'student in class' - Student Class View
        'teacher' - Teacher Class View
 */
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
                var hrefText = "/modules/common/downloader.php?path=" + encodeURIComponent(url) + "&name=" + encodeURIComponent(name);
                html += " <a target=_blank style='display:block' href='" + hrefText +"'>" + arr[i+1] + "</a>";
            }
            return html;
        }
    }

    function typeColorBackground(type){
        type = type - 1;
        var color = new Array("#F44336", "#4CAF50", "#F57C00", "rgba(71,71,71,1)");
        return color[type];
    }
    function typeColorBox(type){
        return "rgba(255, 255,255,0.2);";
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


    this.whetherExpandCSS = function() {
        if (this.content.length > 200){
            return "height: 3em; overflow: hidden; box-shadow: inset 0px -10px 5px #DDD";
        }else{
            return "";
        }
    };
    this.whetherExpandHTML = function(){
        if (this.content.length > 200){
            return "           <div style='margin:0.5em' onclick='new ManipulateAssignment("+this.id+").contentExpanding()'><a href='#'>Click to display/hide.</a></div>";
        }else{
            return "           ";
        }
    };

    this.diff = function(where){
        var assignment = this;
        if (where == "prefix-id"){
            if (assignment.app == "teacher"){
                return "assignment-list-" + assignment.id;
            }else if (assignment.app == "student"){
                return "assignment-list-" + assignment.id;
            }else if (assignment.app == "student-in-class"){
                return "assignment-list-class-" + assignment.id;
            }
        }else if (where == "prefix-content-id"){
            if (assignment.app == "teacher"){
                return "assignment-list-content-" + assignment.id;
            }else if (assignment.app == "student"){
                return "assignment-list-content-" + assignment.id;
            }else if (assignment.app == "student-in-class"){
                return "assignment-list-content-2-" + assignment.id;
            }
        }else if (where == "expand-content"){
            if (assignment.app == "teacher"){
                return this.whetherExpandHTML();
            }else if (assignment.app == "student"){
                return this.whetherExpandHTML();
            }else if (assignment.app == "student-in-class"){
                return this.whetherExpandHTML();
            }
        }else if (where == "additional-button"){
            if (assignment.app == "teacher"){
                var html = "";
                html += "       <div>";
                html += "           <button class='pure-button pure-button-primary' style='display: inline-block' onclick='new ManipulateAssignment(\"" + this.diff("prefix-content-id", assignment) + "\").updateAssignment()'> Update Content </button>";
                if (assignment.type != 2){
                    html += "           <button class='pure-button pure-button-primary' style='display: inline-block' onclick='new ManipulateAssignment(\"" + assignment.id + "\").updateScoresPopUp()'> Update Scores </button>";
                }
                html += "       </div>";
                return html;
            }else if (assignment.app == "student"){
                return "";
            }else if (assignment.app == "student-in-class"){
                return "";
            }
        }else if (where == "iconButton"){
            var html = "";
            if (assignment.app == "student") {
                if (assignment.type != 2 && !assignment.finished) {
                    // html += "<img src='/files/icons/finished.png' width='50px' height='50px' onclick='new ManipulateAssignment(\"" + assignment.id + "\").markCompletion()' />";
                    html += "<img src='/files/icons/finished.jpg' width='50px' height='50px' onclick='new ManipulateAssignment(\"" + assignment.id + "\").markCompletion()' />";
                }
                if (assignment.type != 2 && assignment.finished) {
                    // html += "<img src='/files/icons/unfinished.png' width='50px' height='50px' onclick='new ManipulateAssignment(\"" + assignment.id + "\").markUnCompletion()'/>";
                    html += "<img src='/files/icons/unfinished.jpg' width='50px' height='50px' onclick='new ManipulateAssignment(\"" + assignment.id + "\").markUnCompletion()'/>";
                }
                if (assignment.type == 2 && !assignment.finished) {
                    // html += "<img src='/files/icons/finished.png' width='50px' height='50px' onclick='new ManipulateAssignment(\"" + assignment.id + "\").markInfoAsRead()'/>";
                    html += "<img src='/files/icons/finished.jpg' width='50px' height='50px' onclick='new ManipulateAssignment(\"" + assignment.id + "\").markInfoAsRead()'/>";
                }
            }else if ( assignment.app == "teacher"){
                // html += "<img src='/files/icons/delete.png' width='50px' height='50px' onclick='new ManipulateAssignment(\"" + assignment.id + "\").deleteAssignment()'/>";
                html += "<img src='/files/icons/delete.jpg' width='50px' height='50px' onclick='new ManipulateAssignment(\"" + assignment.id + "\").deleteAssignment()'/>";
            }
            return html;
        }
    };

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

        html += "<div id='" + this.diff("prefix-id", this) + "' class='card2 card-limit'" + finishedCSS + " style='position: relative; border-radius: 5px'>";
        html += "   <div style='height: 70px; padding:1.5em 0 0 1.0em; color: white; border-top-left-radius: 4px; border-top-right-radius: 4px; background: " + typeColorBackground(this.type) + "'>";
        if ( this.type == 2 && daysLeft > 1000 ) {
            html += "       <div style='margin-bottom: 0.5em; margin-top: 0.5em'><span style='font-size: 1.2em'><b>" + this.subject + "</b></span></div>";
        }else{
            html += "       <div style='margin-bottom: 0.5em'><span style='font-size: 1.2em'><b>" + this.subject + "</b></span></div>";
        }
        if (app == "teacher") {
            html += "           <div style='margin-bottom: 0.5em; font-size: 0.8em'><span>Pub: " + this.publish + "</span></div>";
        }
        if ( !( this.type == 2 && daysLeft > 1000) ) {
            var dueDayLabel = new Array("Due", "Expire");
            html += "           <div style='font-size: 0.8em'><span><span class='blockSpanForSmallScreen'>" + dueDayLabel[parseInt(type) - 1] + ": </span><span class='blockSpanForSmallScreen'>" + this.dueday + "</span></span></div>";
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
        html += "       <div style='margin:0.5em 0; border: 2px solid #EEE; padding:0.5em; border-bottom: 3px solid #DDD;"+this.whetherExpandCSS()+"' id='" + this.diff("prefix-content-id", this) + "'>" + Utils.string.formattedPostContent(this.content) + "</div>";
        html += this.diff("expand-content", this);
        html += this.diff("additional-button", this);
        html += "       <div style='display: table; width: 100%; margin: 0.5em 0; vertical-align: top'>";
        // html += "           <div style='display: table-cell; width: 50px; height: 50px'><a href='#'><img src='/files/icons/attachment.png' width='50px' height='50px' /></a></div>";
        html += "           <div style='display: table-cell; width: 50px; height: 50px'><img src='/files/icons/attachment.jpg' width='50px' height='50px' /></div>";
        html += "           <div style='display: table-cell; vertical-align: top; text-align: left; padding: 10px'>" + this.attachment + "</div>";
        html += "           <div style='display: table-cell; width: 50px; height: 50px'><a href='#'>" + this.diff("iconButton", this) + "</a></div>";
        html += "       </div>";
        html += "   </div>";
        html += "</div>";
        return html;
    }
}
// Part II ends

