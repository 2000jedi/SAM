<?php

class UnitFile {
    var $cid;
    var $path;
    var $filename;
    var $ext;
    var $is_img;
    var $description;
    var $date_time;

    function construct($id, $name, $introduction, $organizer, $activities, $members){
      $this->$cid = $cid;
      $this->$path = $path;
      $this->$filename = $filename;
      $this->$ext = $ext;
      $this->$is_img = $is_img;
      $this->$description = $description;
      $this->$date_time = $date_time;
    }

    function constructFromDBRow($row){
        $this->construct($row["ID"], $row["name"], $row["introduction"],$row["organizer"], $row["activities"], $row["members"]);
    }

}
