<?php
/**
 * Created by IntelliJ IDEA.
 * User: sam
 * Date: 2/17/16
 * Time: 5:27 PM
 */

class ManipulateCollegeClass {

    function loadColleges($student){
        global $conn;

        $sql = "SELECT * FROM college by name";
        $result = $conn->query($sql);

        $colleges = array();
        $counter = 0;
        while($row = $result->fetch_assoc()) {
            $college = new College();
            $uCollege = $college->convertIntoUnitCollege($student);
            $colleges[$counter] = $uCollege;
            $counter++;
        }

        return json_encode($colleges);
    }
}