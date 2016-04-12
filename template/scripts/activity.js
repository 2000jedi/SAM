/**
 * Created by Sam on 12/12/15.
 */
function ManipulateActivity(){
    this.loadActivities = function(func){
        $.get("/modules/activity/loadActivity.php", function(data){
            func();

            data = JSON.parse(data);
            for (var i = 0; i < data.length; i++){
                var row = data[i];
                var activity = new Activity(row.id, row.name, row.organizer, row.nameOfOrganizer, row.description, row.attachment, row.time, row.deal, row.members, row.likes);
                $('#activity-list').append(activity.getHTML());
            }
        });
    };

    this.loadInvitation = function(){

    };
    // postponed due to the absence of lazy Tim

    this.addActivityButtonClick = function(){
        floatBox.showFeature("Create a new activity", "add-activity", function(){});
    };

    this.addActivityCommentButtonClick = function(){
        floatBox.showFeature("Add a comment", "add-activity-comment", function(){});
    };
}
function dealWithAttachment(attachment) {
    if (attachment == "null"){
        return "";
    }else{
        var arr = attachment.split(";"), html = "<div style='margin-top: 1em; border-top: 1px solid #CCC; padding-top: .5em'>";
        for (var i = 1; i < arr.length-1; i = i+2){
            var url = arr[i];
            var name = arr[i+1];
            var hrefText = "/modules/common/downloader.php?path=" + encodeURIComponent(url) + "&name=" + encodeURIComponent(name);
            html += "<div style='display: flex; flex-direction: row;'><span class='material-icons'>attachment</span><a target=_blank style='text-indent: 5px' href='" + hrefText +"'>" + name + "</a></div>";
        }
        html += "</div>";
        return html;
    }
}

function Activity(id, name, organizer, nameOfOrganizer, description, attachment, time, deal, members, likes){
    this.id = id;
    this.name = name;
    this.organizer = organizer;
    this.nameOfOrganizer = nameOfOrganizer;
    this.description = description;
    this.attachment = dealWithAttachment(attachment);
    this.time = time;
    this.deal = deal;
    this.members = members;
    this.likes = likes;

    function count(arr){
        return arr.length;
    }

    function isInArray(arr){
        for (var i = 0; i < arr.length; i++){
            if (arr[i] == UID){
                return true;
            }
        }
        return false;
    }

    this.status = {
        stateOfMember: isInArray(this.members),
        stateOfLike: isInArray(this.likes),
        textOfJoinLeaveDeleteButton: "Join",
        textOfLikeUnlikeButton: "Like"
    };

    this.updateStatus = function(){
        if (this.status.stateOfMember) {
            this.status.textOfJoinLeaveDeleteButton = "Leave";
            if (this.organizer == UID){
                this.status.textOfJoinLeaveDeleteButton = "Delete";
            }
        }
        if (this.status.stateOfLike) {
            this.status.textOfLikeUnlikeButton = "UnLike";
        }
    };

    this.updateStatus();

    this.loadComments = function(func){
        $.get("/modules/activity/loadActivityComments.php", {id: this.id}, function(data){
            func();
            data = JSON.parse(data);
            for (var i = 0; i < data.length; i++) {
                var row = data[i];
                var activityComment = new ActivityComment(row.id, row.uid, row.username, row.time, row.comment, row.attachment);
                $('#activity-comment-list').append(activityComment.getHTML());
            }
            updateMasonry('activity-comment-list');
        });
    };

    this.openViewActivityPanel = function(){
        new Activity(id, "", "", "", "", "", "", "", [], []).loadComments(function(){
            $('#activity-comment-list').html("");
        });
        if (this.status.stateOfMember){
            $("#add-activity-comment-button").show();
        }else{
            $("#add-activity-comment-button").hide();
        }
        $('#right-part-view-activity-id').html(this.id);
        $('#add-activityComment-form-id').val(this.id);
        $('#right-part-view-class').hide();
        $('#right-part-view-activity').show();
        $('#right-part').show();
    };

    this.join = function(){
        $.get("/modules/activity/joinActivity.php", {id: this.id}, function(data){
            new ManipulateActivity().loadActivities(function(){
                $('#activity-list').html("");
            });
            alert(data);
        });
    };

    this.leave = function(){
        $.get("/modules/activity/leaveActivity.php", {id: this.id}, function(data){
            new ManipulateActivity().loadActivities(function(){
                $('#activity-list').html("");
            });
            alert(data);
        });
    };

    this.deleteActivity = function(){
        var conf = confirm("DO YOU REALLY want to delete the activity?");
        if (conf == true) {
            $.get("/modules/activity/deleteActivity.php", {id: this.id}, function (data) {
                new ManipulateActivity().loadActivities(function () {
                    $('#activity-list').html("");
                });
                alert(data);
            });
        }
    };

    this.toggleJoinLeaveDelete = function(){
        if (this.status.textOfJoinLeaveDeleteButton == "Join") {
            this.join();
        } else if (this.status.textOfJoinLeaveDeleteButton == "Leave") {
            this.leave();
        } else{
            this.deleteActivity();
        }
    };

    this.viewMembers = function(){
        var usedID = this.id;
        $.get('/modules/activity/loadMembers.php', {id: usedID}, function (data) {
            data = JSON.parse(data);
            var html = "<div class='card' style='width: calc(100%);box-sizing: border-box;'>Total Number: " + data.length + "</div>";
            for (var i = 0; i < data.length; i++) {
                var userInfo = data[i];
                html += "<div class='card' style='display:table; width: calc(100%);box-sizing: border-box;'>" + userInfo +"</div>";
            }
            floatBox.showFeature("Members in the activity", "view-activity-members", function () {
                $('#floatBox-view-activity-members-list').html(html);
            });
        });
    };

    this.sendInvitation = function(user){

    };

    this.removeParticipant = function(user){

    };

    this.addComment = function(content){

    };

    this.like = function(){
        $.get("/modules/activity/like.php", {id: this.id}, function(data){
            new ManipulateActivity().loadActivities(function(){
                $('#activity-list').html("");
            });
            alert(data);
        });
    };

    this.unLike = function(){
        $.get("/modules/activity/unlike.php", {id: this.id}, function(data){
            new ManipulateActivity().loadActivities(function(){
                $('#activity-list').html("");
            });
            alert(data);
        });
    };

    this.toggleLikeUnlike = function(){
        if (this.status.textOfLikeUnlikeButton == "Like") {
            this.like();
        } else if (this.status.textOfLikeUnlikeButton == "UnLike") {
            this.unLike();
        } else{
            // ...
        }
    };

    this.getHTML = function(){
        var html = "";
        html += "<div id='activity-list-"+ this.id +"' class='activity-list demo-cards mdl-cell mdl-grid mdl-grid--no-spacing' style='width: 70%; margin: 1em auto'>";
        html += "   <div class='demo-updates mdl-card mdl-shadow--2dp mdl-cell mdl-cell--4-col mdl-cell--4-phone mdl-cell--8-col-tablet mdl-cell--12-col-desktop'>"
        html += "       <div class='mdl-card__title mdl-card--expand mdl-color--indigo-300' style='position: relative'>";
        html += "           <h2 class='mdl-card__title-text' style='width: 100%'><span class='material-icons'>people</span>&nbsp;<span style='width: calc(100% - 100px); white-space: nowrap; overflow: hidden; text-overflow: ellipsis'>" + this.name + "</span></h2>";
        html += "           <div style='position: absolute; right: 0; top: 0; width: 150px; height: 83px; color: white'>";
        html += "               <div style='line-height: 50px; position: absolute; width:50px; top:0; right: 0; font-size: 1.1em; text-align: center; background: rgba(255, 255,255,0.2)'>" + count(members) + "</div>";
        html += "               <div style='line-height: 50px; position: absolute; width:50px; top:50px; right: 0; font-size: 1.1em; text-align: center; background: rgba(255, 255,255,0.2); border-top:1px solid rgba(255,255,255,0.5)'>" + count(likes)+ "</div>";
        html += "               <div style='right: 3px; top: 39px; font-size: 10px; position: absolute'>members</div>";
        html += "               <div style='right: 3px; top: 89px; font-size: 10px; position: absolute'>likes</div>";
        html += "           </div>";
        html += "       </div>";
        html += "       <div class='mdl-card__supporting-text mdl-color-text--grey-600' style='border-bottom: 1px solid #CCC'>";
        html += "           <div>Organizer: " + this.nameOfOrganizer + "</div>";
        html += "       </div>";
        html += "       <div class='mdl-card__supporting-text mdl-color-text--grey-600' style='border-bottom: 1px solid #CCC'>";
        html += "           <div>Published: " + this.time + "</div>";
        html += "       </div>";
        html += "       <div class='mdl-card__supporting-text mdl-color-text--grey-600' style='border-bottom: 1px solid #CCC'>";
        html += "           <div style='display: inline-block; width: 100%; overflow: hidden'>Benefit: " + this.deal+ "</div>";
        html += "       </div>";
        html += "       <div class='mdl-card__supporting-text mdl-color-text--grey-600'>";
        html += "           <div>" + Utils.string.formattedPostContent(this.description) + "</div>" + this.attachment;
        html += "       </div>";
        html += "       <div class='mdl-card__actions mdl-card--border'>";
        html += "           <a id='activity-list-" + this.id + "-join-leave-delete-button' href='#' class='mdl-button mdl-js-button mdl-js-ripple-effect' style='color: #3f51b5; padding: 0; min-width: 100px' onclick='new Activity(\"" + this.id + "\", \"" + this.name + "\", \"" + this.organizer + "\", \"" + this.nameOfOrganizer + "\", \"" + this.description + "\", \"" + attachment + "\", \"" + this.time + "\", \"" + this.deal + "\", [" + this.members + "], [" + this.likes + "]).toggleJoinLeaveDelete()'>"+this.status.textOfJoinLeaveDeleteButton+"</a>";
        html += "           <a id='activity-list-" + this.id + "-like-unlike-button' href='#' class='mdl-button mdl-js-button mdl-js-ripple-effect' style='color: #3f51b5; padding: 0; min-width: 100px' onclick='new Activity(\"" + this.id + "\", \"" + this.name + "\", \"" + this.organizer + "\", \"" + this.nameOfOrganizer + "\", \"" + this.description + "\", \"" + attachment + "\", \"" + this.time + "\", \"" + this.deal + "\", [" + this.members + "], [" + this.likes + "]).toggleLikeUnlike()'>"+this.status.textOfLikeUnlikeButton+"</a>";
        html += "           <a href='#' class='mdl-button mdl-js-button mdl-js-ripple-effect' style='color: #3f51b5; padding: 0; min-width: 100px' onclick='new Activity(\"" + this.id + "\", \"" + this.name + "\", \"" + this.organizer + "\", \"" + this.nameOfOrganizer + "\", \"" + this.description + "\", \"" + attachment + "\", \"" + this.time + "\", \"" + this.deal + "\", [" + this.members + "], [" + this.likes + "]).viewMembers()'>Members</a>";
        html += "           <a href='#' class='mdl-button mdl-js-button mdl-js-ripple-effect' style='color: #3f51b5; padding: 0; min-width: 100px' onclick='new Activity(\"" + this.id + "\", \"" + this.name + "\", \"" + this.organizer + "\", \"" + this.nameOfOrganizer + "\", \"" + this.description + "\", \"" + attachment + "\", \"" + this.time + "\", \"" + this.deal + "\", [" + this.members + "], [" + this.likes + "]).openViewActivityPanel()'>Discuss</a>";
        html += "       </div>";
        html += "   </div>";
        html += "</div>";
        return html;
    }
}

function ActivityComment(id, uid, username, time, comment, attachment){
    this.id = id;
    this.uid = uid;
    this.username = username;
    this.time = time;
    this.comment = comment;
    this.attachment = dealWithAttachment(attachment);

    this.delete = function(){
        var conf = confirm("DO YOU REALLY want to delete the comment?");
        if (conf == true) {
            var id = $('#right-part-view-activity-id').html();
            var cid = this.id;
            $('#activity-comment-list').masonry().masonry("remove", $('#activity-comment-list-' + cid));
            $.get("/modules/activity/deleteActivityComment.php", {id: this.id}, function (data) {
            });
        }
    };
    this.getHTML = function(){
        var html = "";
        html += "<div id='activity-comment-list-"+ this.id +"' class='activity-comment-list demo-cards mdl-cell mdl-grid mdl-grid--no-spacing' style='width: 70%; margin: 1em auto'>";
        html += "   <div class='demo-updates mdl-card mdl-shadow--2dp mdl-cell mdl-cell--4-col mdl-cell--4-phone mdl-cell--8-col-tablet mdl-cell--12-col-desktop'>";
        html += "       <div class='mdl-card__title mdl-card--expand mdl-color--indigo-300' style='position: relative'>";
        html += "           <h2 class='mdl-card__title-text'><span class='material-icons'>assignment</span> Comment</h2>";
        html += "       </div>";
        html += "       <div class='mdl-card__supporting-text mdl-color-text--grey-600' style='border-bottom: 1px solid #CCC'>";
        html += "           <div>Author: " + this.username + "</div>";
        html += "       </div>";
        html += "       <div class='mdl-card__supporting-text mdl-color-text--grey-600' style='border-bottom: 1px solid #CCC'>";
        html += "           <div>Published: " + this.time + "</div>";
        html += "       </div>";
        html += "       <div class='mdl-card__supporting-text mdl-color-text--grey-600'>";
        html += "           <div>" + Utils.string.formattedPostContent(this.comment) + "</div>" + this.attachment;
        html += "       </div>";
        if (this.uid == UID) {
            html += "       <div class='mdl-card__actions mdl-card--border'>";
            html += "           <a href='#' class='mdl-button mdl-js-button mdl-js-ripple-effect' style='color: #3f51b5; padding: 0; min-width: 100px' onclick='new ActivityComment(\"" + this.id + "\", \"" + this.uid + "\", \"" + this.user + "\", \"" + this.time + "\", \"" + this.comment + "\", \"" + attachment + "\").delete()'>Delete</a>";
            html += "       </div>";
        }
        html += "   </div>";
        html += "</div>";
        return html;
    }
}
