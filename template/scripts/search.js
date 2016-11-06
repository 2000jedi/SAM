/**
 * Created by sam on 4/12/16.
 */

function Search(searchTerm){
    this.searchTerm = searchTerm;

    this.loadResultFromTeacherSide = function () {
        $.post("/modules/search/searchFromTeacherSide.php", {query: searchTerm}, function(data){
            $("#search-result-list").html("");

            if (data == "[]"){
                $("#search-result-list").append("<div class='card' style='text-align: center'>No relevant result.</div>")
            }else{
                data = JSON.parse(data);

                var idList = "";
                for (var i = 0; i < data.length; i++){
                    var row = data[i];
                    idList += ";" + row.id;
                    var assignment = new Assignment("teacher",row.id, row.type, row.content, row.attachment, row.publish, row.dueday, convertSubject(row.subject), row.duration, row.finished);
                    $("#search-result-list").append(assignment.getHTML(false));
                }
            }
            $("#mSearch").show();
            $("#mClasses").hide();
        });
    };

    this.hideSearchResult = function(){
        $("#mSearch").hide();
        $("#mClasses").show();
    }
}