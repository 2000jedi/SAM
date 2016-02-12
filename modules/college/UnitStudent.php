<?php
/**
 * Created by IntelliJ IDEA.
 * User: sam
 * Date: 2/12/16
 * Time: 6:55 PM
 */

class UnitStudent {
    var $id;
    var $ibScore;
    var $satScore;
    var $actScore;
    var $toeflScore;
    var $ieltsScore;
    var $numberOfAwards;

    function __construct($id, $ibScore, $satScore, $actScore, $toeflScore, $ieltsScore, $numberOfAwards){
        $this->id = $id;
        $this->ibScore = $ibScore;
        $this->satScore = $satScore;
        $this->actScore = $actScore;
        $this->toeflScore = $toeflScore;
        $this->ieltsScore = $ieltsScore;
        $this->numberOfAwards = $numberOfAwards;
    }
}