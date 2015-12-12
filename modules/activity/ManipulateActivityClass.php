<?php
/**
 * Created by IntelliJ IDEA.
 * User: Sam
 * Date: 11/28/15
 * Time: 18:47
 */

class ManipulateActivityClass {

    var $user;

    var $id;
    var $organizer;
    var $name;
    var $time;
    var $description;
    var $deal;
    var $members;
    var $likes;

    /*
     *
     * Part I: Construction the class for adding and processing activity
     * Author: Sam Chou
     *
     * constructInLoad($user) adds the user property into the class.
     *
     * constructForAddAndProcessActivity($organizer, $name, $description, $deal) adds
     *  - the ID of the organizer
     *  - the name of the activity
     *  - the description of the activity
     *  - the deal for the participants
     *
     * constructForAddAndProcessActivity($id) constructs the activity class by the id of the activity
     *
     */
    function constructInLoad($user){
        $this->user = $user;
    }
    function constructForAddAndProcessActivity($organizer, $name, $description, $deal){
        $this->organizer = $organizer;
        $this->name = $name;
        $this->description = $description;
        $this->deal = $deal;
    }
    function constructByID($id){
        global $conn;

        $sql = "SELECT * FROM activity WHERE id = '$id'";
        $result = $conn->query($sql);

        $this->id = $id;

        while($row = $result->fetch_assoc()) {
            $this->constructForAddAndProcessActivity($row["organizer"], $row["name"], $row["description"], $row["deal"]);
            $this->time = $row["time"];
            $this->members = $this->processMembersFromDBStringToArray($row["members"]);
            $this->likes = $this->processLikesFromDBString($row["likes"]);
        }
    }
    // Part I ends.


    /*
     *
     * Part II: Load
     * This part is used to load information.
     * Author: Sam Chou, Tim
     *
     */
    function loadAllActivities(){
        global $conn;

        $sql = "SELECT * FROM activity WHERE members LIKE '%;$this->user;%' OR class LIKE '%;$this->user' ORDER BY id ASC";
        $result = $conn->query($sql);

        $activities = array();
        $counter = 0;
        while($row = $result->fetch_assoc()) {
            $uA = new UnitActivity();
            $uA->constructFromDBRow($row);
            $activities[$counter] = $uA;
        }

        return json_encode($activities);
    }

    function loadComments(){
        global $conn;

        $sql = "SELECT * FROM activityComments WHERE aid = '$this->id'";
        $result = $conn->query($sql);

        $comments = array();
        $counter = 0;
        while($row = $result->fetch_assoc()) {
            $uAC = new UnitActivityComment($row);
            $uAC->constructFromDBRow($row);
            $comments[$counter] = $uAC;
        }

        return json_encode($comments);
    }


    function loadInvitation(){

    }
    // Part II ends

    /*
     *
     * Part III: Add Activity
     * This part is used to add activity.
     * Author: Jedi
     *
     */
    function addActivity(){
        $organizer = $this->organizer;
        $name = $this->name;
        $description = $this->description;
        $deal = $this->deal;

        // @Jedi, add your code here.
    }
    // Part III ends

    /*
     *
     * Part IV: Deal with a specific activity with known id
     *
     *
     */
    function processMembersFromDBStringToArray($dbStringMembers){
        $membersIDStr = explode(";", $dbStringMembers);

        $members = array();
        for ($i = 1; $i < count($membersIDStr) ; $i++){
            $member = $membersIDStr[$i];
            $members[$i-1] = $member;
        }

        return $members;
    }

    function processLikesFromDBString($dbStringLikes){
        $likesIDStr = explode(";", $dbStringLikes);

        $likes = array();
        for ($i = 1; $i < count($likesIDStr) ; $i++){
            $like = $likesIDStr[$i];
            $likes[$i-1] = $like;
        }

        return $likes;
    }

    function joinActivity($participant){

    }

    function leaveActivity($participant){

    }

    function deleteActivity(){

    }

    function sendInvitation($participants){

    }

    function removeParticipant($operator, $participant){

    }

    function addComment($participant, $user){

    }

    function like($user){

    }

    function unLike($user){

    }
    // Part IV Ends.


}