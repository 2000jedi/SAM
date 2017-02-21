<?php

/**
 * Created by PhpStorm.
 * User: 2000jedi
 * Date: 2017/2/19
 * Time: 22:47
 */
class ManipulateClubClass {

    function loadAllClubs(){
        global $conn;

        $sql = "SELECT * FROM club ORDER BY id ASC";
        $result = $conn->query($sql);

        $clubs = array();
        $counter = 0;
        while($row = $result->fetch_assoc()) {
            $uC = new UnitClub();
            $uC->constructFromDBRow($row);
            $clubs[$counter] = $uC;
            $counter++;
        }

        return json_encode($clubs);
    }

    function loadWatchClubs($cid){
        global $conn;

        $sql = "SELECT watchclubs FROM student WHERE id='$cid'";
        $result = $conn->query($sql);
        $row = $result->fetch_assoc();

        $clubs = $this->processFromDBStringToArray($row['watchclubs']);
        $clubs_processed = array();
        for ($i = 0; $i < count($clubs) - 1; $i++){
            $sql = "SELECT * FROM club WHERE id='$clubs[$i]'";
            $result = $conn->query($sql);
            $clubs_processed[$i] = $result->fetch_assoc();
        }

        return json_encode($clubs_processed);
    }

    function loadClub($cid){
        global $conn;

        $sql = "SELECT * FROM club WHERE id='$cid'";
        $result = $conn->query($sql);

        $row = $result->fetch_assoc();
        $uC = new UnitClub();
        $uC->constructFromDBRow($row);
        $club = $uC;

        return json_encode($club);
    }

    function addClub($name, $organizer){
        global $conn;

        $sql = "INSERT INTO club (name, organizer, activities, members) VALUES ('$name', '$organizer',;,;)";
        $conn->query($sql);
        echo "Success";
    }

    function addPost($club, $publisher, $information, $photo, $attachment) {
        $publish = time();
    }

    function processFromDBStringToArray($dbStringMembers){
        $membersIDStr = explode(";", $dbStringMembers);
        $members = array();
        for ($i = 1; $i < count($membersIDStr) ; $i++){
            $member = $membersIDStr[$i];
            $members[$i-1] = $member;
        }

        return $members;
    }
}
