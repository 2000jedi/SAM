<?php
/**
 * Created by IntelliJ IDEA.
 * User: sam
 * Date: 7/13/16
 * Time: 2:33 PM
 */

class UnitPersonalInfo {
	var $class;
    var $ChineseName;
    var $EnglishName;
    var $info;

    function __construct($anotherClass, $anotherChineseName, $anotherEnglishName, $anotherInfo){
        $this->class = $anotherClass;
        $this->ChineseName = $anotherChineseName;
        $this->EnglishName = $anotherEnglishName;
        $this->info = $anotherInfo;
    }
}

?>