/**
 * Created by sam on 7/13/16.
 */

function ManipulatePresentation(){
    this.removePresentation = function(pID){
        var conf = confirm("DO YOU REALLY want to delete the presentation?");
        if (conf == true) {
            $.get("/modules/presentation/removePresentation.php",{id: pID},function(data){
                alert(data);
            })
        }
    };

    this.loadPresentations = function(type){
        $.get("/modules/presentation/loadPresentation.php",function(data) {
            data = JSON.parse(data);
            var html = "";
            for (var i = 0; i < data.length; i++){
                var presentation = new Presentation(data[i].id, data[i].name, data[i].attachment);
                html += presentation.getHTML(type);
            }
            $("#presentationList").append(html);
        });
    }
}

function Presentation(id, name, attachment){
    function dealWithAttachment(attachment) {
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

    this.id = id;
    this.name = name;
    this.attachment = dealWithAttachment(attachment);

    this.getHTML = function(type){
        var html = "";

        /*

        Type 1 == Public Display
        Type 2 == Admin

        */

        html += "<div class='demo-cards mdl-cell mdl-grid mdl-grid--no-spacing' style='width: 55%; margin: 1em auto'>";
        html += "   <div class='demo-updates mdl-card mdl-shadow--2dp mdl-cell mdl-cell--4-col mdl-cell--4-phone mdl-cell--8-col-tablet mdl-cell--12-col-desktop'>";
        html += "       <div class='mdl-card__title mdl-card--expand mdl-color--green-300' style='position: relative'>";
        html += "           <h2 class='mdl-card__title-text'>" + this.name + "</h2>";
        html += "       </div>";
        html += "       <div class='mdl-card__supporting-text mdl-color-text--grey-600' style='overflow: visible'>";
        html += "           <div style='line-height: 1.5;'>";
        html += this.attachment;
        html += "           </div>";
        html += "       </div>";
        if (type == 2){
            html += "       <div class='mdl-card__actions mdl-card--border'>";
            html += "           <a href='#' class='mdl-button mdl-js-button mdl-js-ripple-effect' style='color: #3f51b5; padding: 0 3px' onclick='new ManipulatePresentation().removePresentation(" + this.id + ")'>Remove</a>";
            html += "       </div>";
        }
        html += "   </div>";
        html += "</div>";
        return html;
    }

}