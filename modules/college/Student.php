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

    var $ibScoreScaling = 42;
    var $satScoreScaling = 2400;
    var $actScoreScaling = 36;
    var $toeflScoreScaling = 120;
    var $ieltsScoreScaling = 9;

    var $ibScoreCoefficient = 4;
    var $satScoreCoefficient = 4;
    var $actScoreCoefficient = 4;
    var $toeflScoreCoefficient = 2;
    var $ieltsScoreCoefficient = 2;
    var $numberOfAwardsCoefficient = 6;


    function __construct($id){
        global $conn;

        $sql = "SELECT * FROM student WHERE id = '$id'";
        $result = $conn->query($sql);

        $this->id = $id;

        while($row = $result->fetch_assoc()) {
            $this->constructFromRow($row);
        }
    }

    function constructFromRow($row){
        $this->ibScore = $row["ibScore"];
        $this->satScore = $row["satScore"];
        $this->actScore = $row["actScore"];
        $this->toeflScore = $row["toeflScore"];
        $this->ieltsScore = $row["ieltsScore"];
        $this->numberOfAwards = $row["numberOfAwards"];
    }

    function updateScore($ibScore, $satScore, $actScore, $toeflScore, $ieltsScore, $numberOfAwards){
        global $conn;

        $sql = "UPDATE student SET ibScore = '$ibScore', satScore = '$satScore', actScore = '$actScore', toeflScore = '$toeflScore', ieltsScore = '$ieltsScore', numberOfAwards = '$numberOfAwards' WHERE id = '$this->id'";

        if ($conn->query($sql) === TRUE) {
            echo "Success!";
        } else {
            echo "Unexpected error.";
        }
    }

    function calculateScore(){
        $score = 0;
        $score += $this->ibScore / $this->ibScoreScaling * $this->ibScoreCoefficient;
        $score += $this->satScore / $this->satScoreScaling * $this->satScoreCoefficient;
        $score += $this->actScore / $this->actScoreScaling * $this->actScoreCoefficient;
        $score += $this->toeflScore / $this->toeflScoreScaling * $this->toeflScoreCoefficient;
        $score += $this->ieltsScore / $this->ieltsScoreScaling * $this->ieltsScoreCoefficient;
        $score += $this->numberOfAwards * $this->numberOfAwardsCoefficient;
        return $score;
    }

    function toUnitStudent(){
        $uStd = new UnitStudent($this->id, $this->ibScore, $this->satScore, $this->actScore, $this->toeflScore, $this->ieltsScore, $this->numberOfAwards);
        return $uStd;
    }
}