<?php
/**
 * Created by IntelliJ IDEA.
 * User: sam
 * Date: 7/13/16
 * Time: 2:33 PM
 */

class UnitPresentation {
    var $id;
    var $name;
    var $attachment;

    function __construct($row){
        $this->id = $row['id'];
        $this->name = $row['name'];
        $this->attachment = $row['attachment'];
    }
}