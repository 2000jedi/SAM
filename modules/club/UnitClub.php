<?php

/**
 * Created by PhpStorm.
 * User: 2000jedi
 * Date: 2017/2/21
 * Time: 21:59
 */

class UnitClub {
    var $id;
    var $name;
    var $introduction;
    var $organizer;
    var $nameOfOrganizer;
    var $activities;
    var $members;

    function construct($id, $name, $introduction, $organizer, $activities, $members){
        $this->id = $id;
        $this->name = $name;
        $this->introduction = $introduction;
        $this->organizer = $organizer;
        $this->nameOfOrganizer = $this->nameOfPerson($organizer);
        $this->activities = $this->processFromDBStringToArray($activities);
        $this->members = $this->processFromDBStringToArray($members);
    }

    function constructFromDBRow($row){
        $this->construct($row["ID"], $row["name"], $row["introduction"],$row["organizer"], $row["activities"], $row["members"]);
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
