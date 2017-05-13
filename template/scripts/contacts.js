function changeInfo(){
    var info = $('#change-personal-info').val();
    $.post("/modules/user/changeInfo.php", {info: info}, function(data){
        if (data == "success") {
            alert("You have successfully changed your personal info.");
        }else{
            alert(data);
        }
    })
}

function loadInfo(){
    $.get("/modules/user/loadInfo.php", function(content){
        content = content.replace(/<br.*?>/g, "\n");
        $('#change-personal-info').val(content);
    })
    
}

function loadAllPersonalInfo(){
	$.get("/modules/user/loadAllInfo.php", function(data){
		data = JSON.parse(data);
		var html = "";
		for (var i = 0; i < data.length; i++) {
			var oneClass = data[i];
			var className = oneClass.class;
			var classPersonalInfoArray = oneClass.personalInfoArr;
			html += "<div class='card'>";
        	html += "	<h2 class=''>" + className +"</h2>";
        	html += "   <div><a class='a-button' onclick='ExpandORCollaseClass("+className+")'>Expand/Collase</a></div>";
        	html += "</div>";
			html += "<div id='info-list-container-"+className+"' style='padding: 0 5px; position: relative; display: none;background-color: #edeff1;'>"
			for (var j = 0; j < classPersonalInfoArray.length; j++) {
				var onePerson = classPersonalInfoArray[j];
				var cName = onePerson.ChineseName;
				var eName = onePerson.EnglishName;
				var info = Utils.string.formattedPostContent(onePerson.info);
				html += "<div class='card info-list-" + className + "'>";
        		html += "	<h4 class=''>" + cName + " ("  + eName + ")</h2>";
        		html += "   <div>" + info +"</div>";
        		html += "</div>";
			}
			html += "</div>"
		}
		$('#contactsList').html(html);
	})
}

function ExpandORCollaseClass(classID){
	$("#info-list-container-"+classID).slideToggle();
}