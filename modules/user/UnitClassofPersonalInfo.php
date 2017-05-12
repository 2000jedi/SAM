<?php
/**
 * Created by IntelliJ IDEA.
 * User: sam
 * Date: 7/13/16
 * Time: 2:33 PM
 */

class UnitClassofPersonalInfo {
	var $class;
    var $personalInfoArr;

    function __construct($anotherClass){
        $this->class = $anotherClass;
        $this->personalInfoArr = array();
    }

    /*
     *
     * Return true if addition is valid, false otherwise
     *
     */
    function addPersonalInfo($personalInfo){
    	if ($personalInfo->class == $this->class) {
    		$this->personalInfoArr[count($this->personalInfoArr)] = $personalInfo;
    		return true;
    	}
        return false;
    }
}

?>