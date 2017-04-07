/**
 * Created by 2000jedi on 2017/2/26.
 */

Vue.component('club', {
    props: ['json'],
    template: "<div class='class-list' @click='loadClubDetail(json.id)'>\
        <h2>{{json.name}}</h2>\
        <div>Organizer: {{json.nameOfOrganizer}}</div>\
    </div>"
});

axios.get('modules/club/loadClub.php', {params:{id:-1}}).then(function(json){
    new Vue({
        el: "#club",
        data: {
            clubs: json.data
        }
    });
}).catch(function(error){
    console.log(error);
    alert("Network Unreachable");
});

function loadClubDetail(id) {
    window.location.href="/single-club.html?id=" + id;
}
