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
        $this->activities = $this->processPosts($activities);
        $this->members = $this->processMembers($members);
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

    function processMembers($dbStringMembers){
        $membersIDStr = explode(";", $dbStringMembers);

        $members = array();
        for ($i = 1; $i < count($membersIDStr) ; $i++){
            $member = $membersIDStr[$i];
            $members[$i-1] = $this->nameOfPerson($member);
        }

        return $members;
    }

    function getPosts($post_id){
        global $conn;
        $sql = "SELECT * FROM club_post WHERE ID = '$post_id'";
        $result = $conn->query($sql);

        $row = $result->fetch_assoc();
        $post = new UnitPost();
        $post->construct($row['ID'], $row['club'], $row['publisher'], $row['information'],$row['photo'], $row['attachment'], $row['publish']);
        return $post;
    }

    function processPosts($dbStringMembers){
        $membersIDStr = explode(";", $dbStringMembers);

        $members = array();
        for ($i = 1; $i < count($membersIDStr) ; $i++){
            $member = $membersIDStr[$i];
            $members[$i-1] = $this->getPosts($member);
        }

        return $members;
    }
}
