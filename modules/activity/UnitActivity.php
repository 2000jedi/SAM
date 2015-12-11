<?php
/**
 * Created by IntelliJ IDEA.
 * User: Sam
 * Date: 12/11/15
 * Time: 20:25
 */

class UnitActivity {

    var $id;
    var $name;
    var $description;
    var $time;
    var $deal;
    var $members;
    var $likes;

    function __construct(){}

    function construct($id, $name, $description, $time, $deal, $members, $likes){
        $this->id = $id;
        $this->name = $name;
        $this->description = $description;
        $this->time = $time;
        $this->deal = $deal;
        $this->members = $members;
        $this->likes = $likes;
    }

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

    function constructFromDBRow($row){
        $members = $this->processMembersFromDBStringToArray($row["members"]);
        $likes = $this->processLikesFromDBString($row["likes"]);

        $this->construct($row["id"], $row["name"], $row["description"], $row["time"], $row["deal"], $members, $likes);

    }
}