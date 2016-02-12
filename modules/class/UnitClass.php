<?php
/**
 * Created by IntelliJ IDEA.
 * User: Sam
 * Date: 3/21/15
 * Time: 16:06
 */

class UnitClass {

    var $id;
    var $teacher;
    var $name;
    var $subject;

    function __construct($id,$teacher,$name,$subject){
        $this->id = $id;
        $this->teacher = $teacher;
        $this->name = $name;
        $this->subject = $subject;
    }

}