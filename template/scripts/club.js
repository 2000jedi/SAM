/**
 * Created by 2000jedi on 2017/2/26.
 */
$(document).ready(function() {

    //Load Club List when Page opened.
    $.ajax({
        url: 'modules/club/loadClub.php?id=-1',
        type: 'GET',
        dataType: 'json',
        timeout: 1000,
        cache: false,
        beforeSend: LoadFunction, //加载执行方法
        error: errFunction, //错误执行方法
        success: succFunction //成功执行方法
    });

    function LoadFunction() {
        $("#msg-stats").css("display", "block").html('Loading Club List...');
        $("#club-list").css("display", "none");
        $("#right-part").css("display", "none");
    }

    function errFunction() {
        $("#msg-stats").css("display", "block").html('Error During Loading, Please Refresh');
        $("#club-list").css("display", "none");
        $("#right-part").css("display", "none");
    }

    function succFunction(data) {
        var json = eval(data);
        $.each(json, function(index, item) {
            var id = json[index].id;
            var name = json[index].name;
            var introduction = json[index].introduction;
            var dom = "<div class='class-list' onclick=loadClubDetail(" + id + ")><h2>" + name + "</h2><div>" + introduction + " (ID:" + id + ")</div></div>"
            $("#club-list").append(dom);
        });
        $("#msg-stats").css("display", "none");
        $("#club-list").css("display", "block");
        $("#right-part").css("display", "none");
    }


});


//Load Club Detail
function loadClubDetail(id) {
    $.ajax({
        url: 'modules/club/loadClub.php?id=' + id,
        type: 'GET',
        dataType: 'json',
        timeout: 1000,
        cache: false,
        beforeSend: notice("Loading Club List..."), //加载执行方法
        error: notice("Error Loading Club Detail"), //错误执行方法
        success: function(data) {
            var json = eval(data);
            var id = json.id;
            var name = json.name;
            var introduction = json.introduction;
            $("#club-header").html(name);
            $("#club-secondary").html(introduction);
            $("#club-list").css("display", "none");
            $("#club-back-arrow").css("display", "");
            $("#club-detail").css("display", "");
        }
    });

    function notice(info) {
        $("#msg-stats").css("display", "block").html(info);
        $("#club-list").css("display", "none");
        $("#right-part").css("display", "none");
    }


    $.ajax({
        url: 'modules/club/loadPosts.php?cid=' + id,
        type: 'GET',
        dataType: 'json',
        timeout: 1000,
        cache: false,
        beforeSend: notice("Loading Posts..."), //加载执行方法
        error: notice("Error Loading Posts."), //错误执行方法
        success: function(data) {
            var json = eval(data);
            $("#debug").html(json);
            // json = [{
            //     "id": 1,
            //     "pname": "sam",
            //     "information": "yosfdihauofusahifuaf",
            //     "publish": "2015-2-20"
            // }, {
            //     "id": 1,
            //     "pname": "sam",
            //     "information": "yosfdihauofusahifuaf",
            //     "publish": "2015-2-20"
            // }];
            // $("#msg").html(json);
            $.each(json, function(index, item) {
                var id = json[index].id;
                var cname = json[index].cname;
                var pname = json[index].pname;
                var information = json[index].information;
                var publish = json[index].publish;
                var dom = "<div class='assignment-list-class'>" +
                    "<div class='title'>" +
                    "<div class='title-text'>" + cname + "</div>" + "<hr>" +
                    "<div class='assignment-info'>Publisher</div>" +
                    "<h2 class='subject'> " + pname + "</h2></div>" +
                    "<div class='content'>" + information + "</div><div class='footer'></div></div>";

                $("#assignment-list-class-pile").append(dom);
            });
            $("#msg-stats").css("display", "none");
            $("#club-list").css("display", "none");
            $("#right-part").css("display", "block");
        } //成功执行方法
    });

}

function back() {
    $("#msg-stats").css("display", "none");
    $("#club-list").css("display", "block");
    $("#right-part").css("display", "none");
}