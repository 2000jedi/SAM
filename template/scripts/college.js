/**
 * Created by sam on 2/17/16.
 */
function ManipulateCollege() {
    this.loadColleges = function (func) {
        this.loadPersonalScores();
        $.get("/modules/college/loadColleges.php", function (data) {
            func();

            data = JSON.parse(data);
            for (var i = 0; i < data.length; i++) {
                var row = data[i];
                var college = new College(row.id, row.name, row.description, row.totalNumberOfEDEAChoice, row.totalNumberOfRDRAChoice, row.numberOfEDEACompetitor, row.numberOfRDRACompetitor);
                $('#college-list').append(college.getHTML());
            }
        });
    };
    this.loadPersonalScores = function () {
        $.get("/modules/college/loadPersonalScores.php", function (data) {
            data = JSON.parse(data);
            $('#personal-info-ibScore').val(data.ibScore);
            $('#personal-info-satScore').val(data.satScore);
            $('#personal-info-actScore').val(data.actScore);
            $('#personal-info-toeflScore').val(data.toeflScore);
            $('#personal-info-ieltsScore').val(data.ieltsScore);
            $('#personal-info-numberOfAwards').val(data.numberOfAwards);
        });
    };

    this.updateScores = function(){

        try{
            var ibScore = parseInt($('#personal-info-ibScore').val());
            var satScore = parseInt($('#personal-info-satScore').val());
            var actScore = parseInt($('#personal-info-actScore').val());
            var toeflScore = parseInt($('#personal-info-toeflScore').val());
            var ieltsScore = parseInt($('#personal-info-ieltsScore').val());
            var numberOfAwards = parseInt($('#personal-info-numberOfAwards').val());

            if (ibScore < 0 || ibScore > 42 || isNaN(ibScore)){
                alert("Not a valid IB Score!");
                return;
            }else if (satScore < 0 || satScore > 2400 || isNaN(satScore)){
                alert("Not a valid SAT Score!");
                return;
            }else if (actScore < 0 || actScore > 36 || isNaN(actScore)){
                alert("Not a valid ACT Score!");
                return;
            }else if (toeflScore < 0 || toeflScore > 2400 || isNaN(toeflScore)){
                alert("Not a valid TOEFL Score!");
                return;
            }else if (ieltsScore < 0 || ieltsScore > 2400 || isNaN(ieltsScore)){
                alert("Not a valid IELTS Score!");
                return;
            }else if (numberOfAwards < 0 || numberOfAwards > 100 || isNaN(numberOfAwards)){
                alert("Not a valid number!");
                return;
            }

            $.post("/modules/college/updateScore.php", {
                ibScore: ibScore,
                satScore: satScore,
                actScore: actScore,
                toeflScore: toeflScore,
                ieltsScore: ieltsScore,
                numberOfAwards: numberOfAwards
            }, function(data){
                alert(data);
            })
        }catch (e){
            alert("Not a valid number");
        }
    }
}

function College(id, name, description, totalNumberOfEDEAChoice, totalNumberOfRDRAChoice, numberOfEDEACompetitor, numberOfRDRACompetitor){

    this.id = id;
    this.name = name;
    this.description = description;
    this.totalNumberOfEDEAChoice = totalNumberOfEDEAChoice;
    this.totalNumberOfRDRAChoice = totalNumberOfRDRAChoice;
    this.numberOfEDEACompetitor = numberOfEDEACompetitor;
    this.numberOfRDRACompetitor = numberOfRDRACompetitor;

    this.getHTML = function () {
        var html = "";
        html += "<div id='college-list-" + this.id + "' class='demo-cards mdl-cell mdl-grid mdl-grid--no-spacing' style='width: calc(100% - 32px);width: -webkit-calc(100% - 32px); width:-moz-calc(100% - 32px);'>";
        html += "   <div class='demo-updates mdl-card mdl-shadow--2dp mdl-cell mdl-cell--4-col mdl-cell--4-phone mdl-cell--8-col-tablet mdl-cell--12-col-desktop'>";
        html += "       <div class='mdl-card__title mdl-card--expand mdl-color--teal-300' style='position: relative'>";
        html += "           <h2 class='mdl-card__title-text'><span class='material-icons'>school</span> " + this.name + "</h2>";
        html += "       </div>";
        html += "       <div class='mdl-card__supporting-text mdl-color-text--grey-600' style='border-bottom: 1px solid #CCC'>";
        html += "           <div>Number of ED/EA Choice: " + this.totalNumberOfEDEAChoice + "</div>";
        html += "       </div>";
        html += "       <div class='mdl-card__supporting-text mdl-color-text--grey-600' style='border-bottom: 1px solid #CCC'>";
        html += "           <div>Number of students better than you (ED/EA): " + this.numberOfEDEACompetitor + "</div>";
        html += "       </div>";
        html += "       <div class='mdl-card__supporting-text mdl-color-text--grey-600' style='border-bottom: 1px solid #CCC'>";
        html += "           <div>Number of RD/RA Choice: " + this.totalNumberOfRDRAChoice + "</div>";
        html += "       </div>";
        html += "       <div class='mdl-card__supporting-text mdl-color-text--grey-600' style='border-bottom: 1px solid #CCC'>";
        html += "           <div>Number of students better than you (RD/RA): " + this.numberOfRDRACompetitor + "</div>";
        html += "       </div>";
        html += "       <div class='mdl-card__supporting-text mdl-color-text--grey-600' style='overflow: visible'>";
        html += "           <div style='line-height: 1.5;'>";
        html += "               <div align='justify'>" + this.description + "</div>";
        html += "           </div>";
        html += "       </div>";
        html += "       <div class='mdl-card__actions mdl-card--border' style='text-align: center'>";
        html += "           <a href='#' class='mdl-button mdl-js-button mdl-js-ripple-effect' style='color: #3f51b5; padding: 0 3px' onclick=''>EA/ED Choice</a>";
        html += "           <a href='#' class='mdl-button mdl-js-button mdl-js-ripple-effect' style='color: #3f51b5; padding: 0 3px' onclick=''>RA/RD Choice</a>";
        html += "           <a href='#' class='mdl-button mdl-js-button mdl-js-ripple-effect' style='color: #3f51b5; padding: 0 3px' onclick=''>Give up</a>";
        html += "       </div>";
        html += "   </div>";
        html += "</div>";

        return html;
    }
}
