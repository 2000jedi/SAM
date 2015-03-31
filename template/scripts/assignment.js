function typeHTML(type){
    type = type - 1;
    var color = new Array("#f33", "#0C0");
    var typeText = new Array("Assignment", "Information");
    return "   <div class='card2-title' style='background:"+ color[type] +"'>"+typeText[type]+"</div>";
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
        return ";display:none";
    }else{
        return "";
    }
}
function contentExpanding(id){
    $('#assignment-list-content-'+id).toggle();
}

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
            return "";
        }else if (app == "student"){
            return "";
        }else if (app == "student-in-class"){
            var html = "";
            html += "       <div>";
            html += "           <button class='pure-button pure-button-primary' style='display: inline-block' onclick='openManageClassPanel(\"" + this.id + "\", \"" + this.name + "\")'>Delete</button>";
            html += "       </div>";
            return html;
        }
    }
}
function Assignment(app, id, type, content, attachment, dueday, duration){
    function dealWithAttachment(attachment) {
        if (attachment == "null"){
            return "No attachment.";
        }else{
            return "<a target=_blank href='" + attachment +"'>Attachment</a>";
        }
    }
    this.app = app;

    this.id = id;
    this.type = parseInt(type);
    this.content = content;
    this.attachment = dealWithAttachment(attachment);
    this.dueday = dueday;
    this.duration = duration + " hours";

    this.getHTML = function() {
        var html = "";
        html += "<div id='" + diff("prefix-id", this.app, this) + "' class='card2 card-limit'>";
        html += typeHTML(this.type);
        html += "   <div class='card2-content'>";
        html += "       <div style='margin-bottom: 0.5em'>";
        html += "           <div style='margin:0.5em'>Content:</div>";
        html += diff("expand-content", this.app, this);
        html += "           <div style='margin:0.5em"+whetherExpandCSS(this.content)+"' id='" + diff("prefix-content-id", this.app, this) + "'>" + this.content + "</div>";

        var dueDayLabel = new Array("Due day: ", "Expire day: ");
        html += "           <div style='margin:0.5em'>"+ dueDayLabel[this.type-1] + this.dueday + "</div>";
        if (this.type == 1){
            html += "           <div style='margin:0.5em'>Estimated duration: " + this.duration + "</div>";
        }
        html += "           <div style='margin:0.5em'>Attachment: " + this.attachment + "</div>";
        html += "       </div>";
        html += diff("additional-button", this.app, this);
        html += "   </div>";
        html += "</div>";
        return html;
    }
}