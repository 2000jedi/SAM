function ClassTeacher(id, teacher, name, subject){
    this.id = id;
    this.teacher = teacher;
    this.name = name;
    this.subject = subject;

    this.getHTML = function(){
        var html = "";
        html += "<div id='class-list-"+ this.id +"' class='card2'>";
        html += "   <div class='card2-title' style='background: #4CAF50'>"+this.subject+" (ID = " + this.id + ")</div>";
        html += "   <div class='card2-content'>";
        html += "       <div style='margin-bottom: 0.5em'>" + this.name + "</div>";
        html += "       <div style='line-height: 40px'>";
        html += "           <button class='pure-button pure-button-primary' style='display: inline-block; padding: .5em .9em' onclick='openManageClassPanel(\""+this.id+"\", \""+this.name+"\")'>Manage</button>";
        html += "           <button class='pure-button pure-button-primary' style='display: inline-block; padding: .5em .9em' onclick='openAddCardBox(\""+this.id+"\", \""+this.name+"\")'>New</button>";
        html += "           <button class='pure-button pure-button-primary' style='display: inline-block; padding: .5em .9em' onclick='viewMembers(\""+this.id+"\")'>Students</button>";
        html += "       </div>";
        html += "   </div>";
        html += "</div>";
        return html;
    }
}

function ClassStudent(id, teacher, name, subject){
    this.id = id;
    this.teacher = teacher;
    this.name = name;
    this.subject = subject;

    this.getHTML = function(){
        var html = "";
        html += "<div id='class-list-"+ this.id +"' class='card2'>";
        html += "   <div class='card2-title' style='background: #4CAF50'>"+this.subject+" (ID = " + this.id + ")</div>";
        html += "   <div class='card2-content'>";
        html += "       <div style='margin-bottom: 0.5em'>" + this.name + "</div>";
        html += "       <div>";
        html += "           <button class='pure-button pure-button-primary' style='display: inline-block' onclick='openViewClassPanel(\""+this.id+"\", \""+this.name+"\")'>View</button>";
        html += "           <button class='pure-button pure-button-primary' style='display: inline-block' onclick='quitClass(\""+this.id+"\")'>Quit</button>";
        html += "       </div>";
        html += "   </div>";
        html += "</div>";
        return html;
    }
}