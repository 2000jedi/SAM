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
    var $attachment;
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
    function constructForAddAndProcessActivity($organizer, $name, $description, $attachment, $deal){
        $this->organizer = $organizer;
        $this->name = $name;
        $this->description = $description;
        $this->attachment = $attachment;
        $this->deal = $deal;
    }
    function constructByID($id){
        global $conn;

        $sql = "SELECT * FROM activity WHERE id = '$id'";
        $result = $conn->query($sql);

        $this->id = $id;

        while($row = $result->fetch_assoc()) {
            $this->constructForAddAndProcessActivity($row["organizer"], $row["name"], $row["description"], $row["attachment"], $row["deal"]);
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

        $sql = "SELECT * FROM activity ORDER BY id ASC";
        // $sql = "SELECT * FROM activity WHERE members LIKE '%;$this->user;%' OR members LIKE '%;$this->user' ORDER BY id ASC";
        $result = $conn->query($sql);

        $activities = array();
        $counter = 0;
        while($row = $result->fetch_assoc()) {
            $uA = new UnitActivity();
            $uA->constructFromDBRow($row);
            $activities[$counter] = $uA;
            $counter++;
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
            $uAC = new UnitActivityComment();
            $uAC->constructFromDBRow($row);
            $comments[$counter] = $uAC;
            $counter++;
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
        global $conn;

        $organizer = $this->organizer;
        $name = $this->name;
        $description = $this->description;
        $attachment = $this->attachment;
        $deal = $this->deal;
        $sql = "INSERT INTO activity (organizer, name, time, description, attachment, deal, members,likes) VALUES ('$organizer', '$name', now(), '$description', '$attachment', '$deal', ';$organizer', '')";
        $conn->query($sql);
        echo "Success";
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
        global $conn;

        $sql = "SELECT * FROM activity WHERE id = '$this->id'";
        $result = $conn->query($sql);

        while($row = $result->fetch_assoc()) {
            $membersStr = $row['members'];
            $membersIDs = explode(";", $membersStr);

            if (count($membersIDs) > 0) {
                for ($i = 1; $i < count($membersIDs); $i++) {
                    if ($membersIDs[$i] == $participant) {
                        return "the student is already in this class";
                    }
                }
            }

            $membersStr .= ";" . $participant;

            $sql1 = "UPDATE activity SET members = '$membersStr' WHERE id = '$this->id'";
            if ($conn->query($sql1) === TRUE){
                return "Success!";
            }else{
                return "Unexpected error.";
            }
        }
    }

    function leaveActivity($participant){
        global $conn;
        $sql = "SELECT * FROM activity WHERE id = '$this->id'";
        $result = $conn->query($sql);

        while($row = $result->fetch_assoc()) {
            $membersStr = $row['members'];
            $membersIDs = explode(";", $membersStr);
            $membersStr = "";

            if (count($membersIDs) > 0){
                for ($i = 1; $i < count($membersIDs); $i++){
                    if ($membersIDs[$i] != $participant){
                        $membersStr .= ";" . $membersIDs[$i];
                    }
                }
            }

            $sql1 = "UPDATE activity SET members = '$membersStr' WHERE id = '$this->id'";
            if ($conn->query($sql1) === TRUE){
                return "Success!";
            }else{
                return "Unexpected error.";
            }
        }
    }

    function deleteActivity($operator){
        global $conn;

        $sql0 = "SELECT * FROM activity WHERE id = '$this->id'";
        $result0 = $conn->query($sql0);

        while($row = $result0->fetch_assoc()) {
            $organizer = $row['organizer'];
            if($operator == $organizer){
                $sql1 = "DELETE FROM activity WHERE id = '$this->id'";

                if ($conn->query($sql1) === TRUE){
                    $sql2 = "DELETE FROM activityComments WHERE aid = '$this->id'";
                    if ($conn->query($sql2) === TRUE){
                        return "Success";
                    }else{
                        return "Unexpected error 2.";
                    }
                }else{
                    return "Unexpected error 1.";
                }
            }else{
                return "You are not the organizer of this activity.";
            }
        }
    }

    function nameOfPerson($uid){
        global $conn;
        $sql = "SELECT * FROM userInfo WHERE uid = '$uid'";
        $result = $conn->query($sql);

        $name = "";

        while($row = $result->fetch_assoc()) {
            $ChineseName = $row["ChineseName"];
            $EnglishName = $row["EnglishName"];
            $name = "$ChineseName ($EnglishName)";
        }

        return $name;
    }

    function loadMembersName(){
        $members = $this->members;
        $arr = array();
        for ($i = 0; $i < count($members); $i++) {
            $name = $this->nameOfPerson($members[$i]);
            $arr[$i] = $name;
        }
        return json_encode($arr);
    }

    function sendInvitation($participants){

    }

    function removeParticipant($operator, $participant){
        global $conn;
        $sql = "SELECT * FROM activity WHERE id = '$this->id'";
        $result = $conn->query($sql);

        while($row = $result->fetch_assoc()) {
            $organizer = $row['organizer'];

            if ($operator != $organizer){
                return "You are not the organizer. ";
            }

            $this->leaveActivity($participant);
        }
    }

    function addComment($comment, $attachment){
        global $conn;

        $members = $this->members;

        $bool = false;
        for ($i = 0; $i < count($members); $i++) {
            if ($members[$i] == $this->user ){
                $bool = true;
            }
        }

        if ($bool){
            $sql = "INSERT INTO activityComments (aid, uid, time, comment, attachment) VALUES ('$this->id', '$this->user', now(), '$comment', '$attachment')";
            if ($conn->query($sql) === TRUE){
                return "Success! Comment added.";
            }else{
                return "Unexpected error.";
            }
        }else{
            return "Permission Denied.";
        }
    }

    function like(){
        global $conn;

        $sql = "SELECT * FROM activity WHERE id = '$this->id'";
        $result = $conn->query($sql);

        while($row = $result->fetch_assoc()) {
            $likesStr = $row['likes'];

            $likesIDs = explode(";", $likesStr);


            if (count($likesIDs) > 0) {
                for ($i = 1; $i < count($likesIDs); $i++) {
                    $likeID = $likesIDs[$i];
                    if ($likeID == $this->user) {
                        return "$this->user has already liked this $this->id";
                    }
                }
            }

            $newLikes = $likesStr . ";" . $this->user;
            $sql1 = "UPDATE activity SET likes = '$newLikes' WHERE id = '$this->id'";
            if ($conn->query($sql1) === TRUE) {
                return "Success!";
            } else {
                return "Unexpected error.";
            }
        }
    }

    function unLike(){
        global $conn;

        $sql1 = "SELECT * FROM activity WHERE id = '$this->id'";
        $result1 = $conn->query($sql1);

        while($row = $result1->fetch_assoc()) {
            $likesIDs = explode(";", $row['likes']);
            $newLikesList = "";

            if (count($likesIDs) > 0) {
                for ($i = 1; $i < count($likesIDs); $i++) {
                    $likeID = $likesIDs[$i];
                    if ($likeID == $this->user) {

                    } else {
                        $newLikesList .= ";" . $likeID;
                    }
                }
            }

            $sql2 = "UPDATE activity SET likes = '$newLikesList' WHERE id = '$this->id'";
            if ($conn->query($sql2) === TRUE) {
                return "Success!";
            } else {
                return "Unexpected error.";
            }
        }
    }
    // Part IV Ends.

}