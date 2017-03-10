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
    window.location.href="/single-club.html?id=" + id;
}

function back() {
    $("#msg-stats").css("display", "none");
    $("#club-list").css("display", "block");
    $("#right-part").css("display", "none");
}