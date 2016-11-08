/**
 * Created by sam on 2/17/16.
 */
function ManipulateCollege() {
    this.togglePersonalInfoPanel = function () {
        $('#personalInfoPanel').toggle();
        if ($('#personalInfoPanelTogglerButton').html() == "add"){
            $('#personalInfoPanelTogglerButton').html("clear");
        }else{
            $('#personalInfoPanelTogglerButton').html("add");
        }
    };

    this.loadColleges = function (func) {
        this.loadPersonalScores();
        $.get("/modules/college/loadColleges.php", function (data) {
            func();

            data = JSON.parse(data);
            for (var i = 0; i < data.length; i++) {
                var row = data[i];
                var college = new College(row.id, row.name, row.description, row.studentStatus, row.totalNumberOfEDEAChoice, row.totalNumberOfRDRAChoice, row.numberOfEDEACompetitor, row.numberOfRDRACompetitor);
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

function College(id, name, description, studentStatus, totalNumberOfEDEAChoice, totalNumberOfRDRAChoice, numberOfEDEACompetitor, numberOfRDRACompetitor){

    this.id = id;
    this.name = name;
    this.description = description;
    this.studentStatus = studentStatus;
    this.totalNumberOfEDEAChoice = totalNumberOfEDEAChoice;
    this.totalNumberOfRDRAChoice = totalNumberOfRDRAChoice;
    this.numberOfEDEACompetitor = numberOfEDEACompetitor;
    this.numberOfRDRACompetitor = numberOfRDRACompetitor;

    this.calculateRank = function (type) {
        var number = 0;

        if ( this.studentStatus == "N/A" ) {
            return 0;
        }else{
            if ( type == "EDEA" ) {
                if (this.totalNumberOfEDEAChoice == 0) {
                    return 0;
                }else if (this.studentStatus == "RDRA") {
                    return 0;
                } else {
                    number = numberOfEDEACompetitor + 1;
                }
            }else{
                if (this.totalNumberOfRDRAChoice == 0) {
                    return 0;
                }else if (this.studentStatus == "EDEA") {
                    return 0;
                } else {
                    number = numberOfRDRACompetitor + 1;
                }
            }

            if ( number % 10 == 1) {
                return number + "<sup style='font-size: 12px'>st</sup>";
            }else if (number % 10 == 2) {
                return number + "<sup style='font-size: 12px'>nd</sup>";
            }else if (number % 10 == 3) {
                return number + "<sup style='font-size: 12px'>rd</sup>";
            }else{
                return number + "<sup style='font-size: 12px'>th</sup>";
            }
        }

    };


    this.switchChoice = function(newChoice){
        $.post("/modules/college/updateCollegeChoice.php", {id: this.id, newChoice: newChoice}, function(data){
            alert(data);
            new ManipulateCollege().loadColleges(function(){
                $('#college-list').html("");
            })
        });
    };

    this.toggleCard = function(){
        if ( $('#college-list-' + this.id + '-content-part').css("display") == "none") {
            $('#college-list-' + this.id + '-content-part').show();
            $('#college-list-' + this.id + '-arrow-btn').html("keyboard_arrow_up");
        }else{
            $('#college-list-' + this.id + '-content-part').hide();
            $('#college-list-' + this.id + '-arrow-btn').html("keyboard_arrow_down");
        }
    };

    this.getHTML = function () {
        var html = "";
        html += "<div id='college-list-" + this.id + "' class='demo-cards mdl-cell mdl-grid mdl-grid--no-spacing' style='width: 100%; margin:0em auto'>";
        html += "   <div class='demo-updates mdl-card mdl-shadow--2dp mdl-cell mdl-cell--4-col mdl-cell--4-phone mdl-cell--8-col-tablet mdl-cell--12-col-desktop' style='min-height:100px'>";
        html += "       <div class='mdl-card__title mdl-card--expand mdl-color--teal-300' style='position: relative; max-height:100px; cursor:pointer' onclick=\"new College('"+this.id+"','','','','','','').toggleCard()\">";
        html += "           <h2 class='mdl-card__title-text' style='width: 100%'><span class='material-icons' style='font-size: 48px;' id='college-list-" + this.id + "-arrow-btn'>keyboard_arrow_down</span> <span style='width: calc(100% - 190px); white-space: nowrap; overflow: hidden; text-overflow: ellipsis'>" + this.name + "</span></h2>";
        html += "           <div style='line-height: 70px; position: absolute; width:70px; bottom:12px; right: 90px; font-size: 1em; text-align: center; background: rgba(255, 255,255,0.2)'>" + this.calculateRank("EDEA") + "<span style='font-size: 12px'>/" + this.totalNumberOfEDEAChoice + "</span></div>";
        html += "           <div style='line-height: 70px; position: absolute; width:70px; bottom:12px; right: 10px; font-size: 1em; background: rgba(255, 255,255,0.2); text-align: center;'>" + this.calculateRank("RDRA") + "<span style='font-size: 12px'>/" + this.totalNumberOfRDRAChoice + "</span></div>";
        html += "           <div style='right: 93px; bottom: 13px; font-size: 11px; position: absolute'>in ED/EA list</div>";
        html += "           <div style='right: 13px; bottom: 13px; font-size: 11px; position: absolute'>in RD/RA list</div>";
        html += "       </div>";
        html += "       <div id='college-list-" + this.id + "-content-part' style='display:none'>";
        html += "           <div class='mdl-card__supporting-text mdl-color-text--grey-600' style='overflow: visible'>";
        html += "               <div style='line-height: 1.5;'>";
        html += "                   <div align='justify' style='font-size: 1.2em'>" + this.description + "</div>";
        html += "               </div>";
        html += "           </div>";
        html += "           <div class='mdl-card__actions mdl-card--border' style='text-align: center; font-size: 1.2em'>";
        if (this.studentStatus != "EDEA"){
            html += "               <a href='#' class='mdl-button mdl-js-button mdl-js-ripple-effect' style='color: #3f51b5; padding: 0 3px' onclick=\"new College('"+this.id+"','','','','','','').switchChoice('EDEA')\">EA/ED Choice</a>";
        }
        if (this.studentStatus != "RDRA"){
            html += "               <a href='#' class='mdl-button mdl-js-button mdl-js-ripple-effect' style='color: #3f51b5; padding: 0 3px' onclick=\"new College('"+this.id+"','','','','','','').switchChoice('RDRA')\">RA/RD Choice</a>";
        }
        if (this.studentStatus != "N/A"){
            html += "               <a href='#' class='mdl-button mdl-js-button mdl-js-ripple-effect' style='color: #3f51b5; padding: 0 3px' onclick=\"new College('"+this.id+"','','','','','','').switchChoice('N/A')\">Give up</a>";
        }
        html += "           </div>";
        html += "       </div>";
        html += "   </div>";
        html += "</div>";

        return html;
    }
}
