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
                var activity = new Activity(row.id, row.name, row.description, row.time, row.deal, row.members, row.likes);
                $('#activity-list').append(activity.getHTML()).masonry().masonry('appended', $("#activity-list-"+row.id));
            }
            updateMasonry('activity-list');
        });
    };

    this.loadInvitation = function(){

    };

    this.addActivity = function(){

    };
}

function Activity(id, name, description, time, deal, members, likes){
    this.id = id;
    this.name = name;
    this.description = description;
    this.time = time;
    this.deal = deal;
    this.members = members;
    this.likes = likes;

    function count(arr){
        return arr.length;
    }

    this.getHTML = function(){
        var html = "";
        html += "<div id='activity-list-"+ this.id +"' class='activity-list demo-cards mdl-cell mdl-grid mdl-grid--no-spacing'>";
        html += "   <div class='demo-updates mdl-card mdl-shadow--2dp mdl-cell mdl-cell--4-col mdl-cell--4-phone mdl-cell--8-col-tablet mdl-cell--12-col-desktop'>"
        html += "       <div class='mdl-card__title mdl-card--expand mdl-color--indigo-300' style='position: relative'>";
        html += "           <h2 class='mdl-card__title-text'><span class='material-icons'>people</span> " + this.name + "</h2>";
        html += "           <div style='position: absolute; right: 0; top: 0; width: 150px; height: 83px; color: white'>";
        html += "               <div style='line-height: 50px; position: absolute; width:50px; top:10px; right: 70px; font-size: 1.1em; text-align: center; background: rgba(255, 255,255,0.2)'>" + count(members) + "</div>";
        html += "               <div style='line-height: 50px; position: absolute; width:50px; top:10px; right: 10px; font-size: 1.1em; background: rgba(255, 255,255,0.2); text-align: center;'>" + count(likes)+ "</div>";
        html += "               <div style='right: 73px; top: 49px; font-size: 10px; position: absolute'>members</div>";
        html += "               <div style='right: 13px; top: 49px; font-size: 10px; position: absolute'>likes</div>";
        html += "           </div>";
        html += "       </div>";
        html += "       <div class='mdl-card__supporting-text mdl-color-text--grey-600' style='border-bottom: 1px solid #CCC'>";
        html += "           <div>Published: " + this.time + "</div>";
        html += "       </div>";
        html += "       <div class='mdl-card__supporting-text mdl-color-text--grey-600' style='border-bottom: 1px solid #CCC'>";
        html += "           <div style='display: inline-block; width: 100%; overflow: hidden'>Deal: " + this.deal+ "</div>";
        html += "       </div>";
        html += "       <div class='mdl-card__supporting-text mdl-color-text--grey-600'>";
        html += "           <div>" + this.description+ "</div>";
        html += "       </div>";
        html += "       <div class='mdl-card__actions mdl-card--border'>";
        html += "           <a href='#' class='mdl-button mdl-js-button mdl-js-ripple-effect' style='color: #3f51b5; padding: 0 3px' onclick=''>Join</a>";
        html += "           <a href='#' class='mdl-button mdl-js-button mdl-js-ripple-effect' style='color: #3f51b5; padding: 0 3px' onclick=''>Like</a>";
        html += "           <a href='#' class='mdl-button mdl-js-button mdl-js-ripple-effect' style='color: #3f51b5; padding: 0 3px' onclick=''>View</a>";
        html += "       </div>";
        html += "   </div>";
        html += "</div>";
        return html;
    }
}