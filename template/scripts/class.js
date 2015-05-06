function ClassTeacher(id, teacher, name){
    this.id = id;
    this.teacher = teacher;
    this.name = name;

    this.getHTML = function(){
        var html = "";
        html += "<div id='class-list-"+ this.id +"' class='card2'>";
        html += "   <div class='card2-title' style='background: #00cc00'>Class (ID = " + this.id + ")</div>";
        html += "   <div class='card2-content'>";
        html += "       <div style='margin-bottom: 0.5em'>" + name + "</div>";
        html += "       <div>";
        html += "           <button class='pure-button pure-button-primary' style='display: inline-block' onclick='openManageClassPanel(\""+this.id+"\", \""+this.name+"\")'>Manage</button>";
        html += "           <button class='pure-button pure-button-primary' style='display: inline-block' onclick='openAddCardBox(\""+this.id+"\", \""+this.name+"\")'>Add New</button>";
        html += "       </div>";
        html += "   </div>";
        html += "</div>";
        return html;
    }
}

function ClassStudent(id, teacher, name){
    this.id = id;
    this.teacher = teacher;
    this.name = name;

    this.getHTML = function(){
        var html = "";
        html += "<div id='class-list-"+ this.id +"' class='card2'>";
        html += "   <div class='card2-title' style='background: #00cc00'>Class</div>";
        html += "   <div class='card2-content'>";
        html += "       <div style='margin-bottom: 0.5em'>" + name + "</div>";
        html += "       <div>";
        html += "           <button class='pure-button pure-button-primary' style='display: inline-block' onclick='openViewClassPanel(\""+this.id+"\", \""+this.name+"\")'>View</button>";
        html += "           <button class='pure-button pure-button-primary' style='display: inline-block' onclick='quitClass(\""+this.id+"\")'>Quit</button>";
        html += "       </div>";
        html += "   </div>";
        html += "</div>";
        return html;
    }
}