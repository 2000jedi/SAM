<?php
/**
 * Created by IntelliJ IDEA.
 * User: sam
 * Date: 2/12/16
 * Time: 6:55 PM
 */

class Student {
    var $id;
    var $ibScore;
    var $satScore;
    var $actScore;
    var $toeflScore;
    var $ieltsScore;
    var $numberOfAwards;

    function __construct($id){
        global $conn;

        $sql = "SELECT * FROM student WHERE id = '$id'";
        $result = $conn->query($sql);

        $this->id = $id;

        while($row = $result->fetch_assoc()) {
            $this->constructForAddAndProcessActivity($row["organizer"], $row["name"], $row["description"], $row["attachment"], $row["deal"]);
            $this->time = $row["time"];
            $this->members = $this->processMembersFromDBStringToArray($row["members"]);
            $this->likes = $this->processLikesFromDBString($row["likes"]);
        }
    }
}