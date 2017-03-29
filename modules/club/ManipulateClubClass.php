<?php

/**
 * Created by PhpStorm.
 * User: 2000jedi
 * Date: 2017/2/19
 * Time: 22:47
 */
class ManipulateClubClass {

    function loadAllClubs(){
        global $conn;

        $sql = "SELECT * FROM club ORDER BY id ASC";
        $result = $conn->query($sql);

        $clubs = array();
        $counter = 0;
        while($row = $result->fetch_assoc()) {
            $uC = new UnitClub();
            $uC->constructFromDBRow($row);
            $clubs[$counter] = $uC;
            $counter++;
        }

        return json_encode($clubs);
    }

    function loadWatchClubs($cid){
        global $conn;

        $sql = "SELECT watchclubs FROM student WHERE id='$cid'";
        $result = $conn->query($sql);
        $row = $result->fetch_assoc();

        $clubs = $this->processFromDBStringToArray($row['watchclubs']);
        $clubs_processed = array();
        for ($i = 0; $i < count($clubs) - 1; $i++){
            $sql = "SELECT * FROM club WHERE id='$clubs[$i]'";
            $result = $conn->query($sql);
            $clubs_processed[$i] = $result->fetch_assoc();
        }

        return json_encode($clubs_processed);
    }

    function loadClub($cid){
        global $conn;

        $sql = "SELECT * FROM club WHERE id='$cid'";
        $result = $conn->query($sql);

        $row = $result->fetch_assoc();
        $uC = new UnitClub();
        $uC->constructFromDBRow($row);
        $club = $uC;

        return json_encode($club);
    }

    function addClub($name, $organizer){
        global $conn;

        $sql = "INSERT INTO club (name, organizer, activities, members) VALUES ('$name', '$organizer',;,;)";
        $conn->query($sql);
        return "Success";
    }

    function addPost($cid, $publisher, $title, $information, $attachment) {
        $publish = time();
        global $conn;

        $sql = "INSERT INTO club_post (club, publisher, title, information, attachment, publish) VALUES ('$cid', '$publisher', '$title', '$information', '$attachment', '$publish')";
        $conn->query($sql);
        return "Success";
    }

    function deletePost($cid, $postid, $uid){
        global $conn;

        $sql0 = "SELECT * FROM club_post WHERE id = '$postid'";
        $result0 = $conn->query($sql0);

        $row = $result0->fetch_assoc();
        $author = $row['publisher'];
        if($uid == $author){
            $sql1 = "DELETE FROM club_post WHERE id = '$postid'";

            if ($conn->query($sql1) === TRUE){
                return "Success";
            }else{
                return "Unexpected error.";
            }
        }else{
            return "You are not the author of this activity comment.";
        }
    }

    function loadPost($pid){
        global $conn;

        $sql = "SELECT * FROM club_post WHERE id = '$pid'";
        $result = $conn->query($sql);

        $row = $result->fetch_assoc();
        $post = new UnitPost();
        $post->construct($row['ID'], $row['club'], $row['title'], $row['publisher'], $row['information'],$row['attachment'], $row['publish'] );
        return json_encode($post);
    }

    function loadPosts($cid){
        global $conn;

        $sql = "SELECT * FROM club_post WHERE club = '$cid'";
        $result = $conn->query($sql);

        $posts = array();
        $count = 0;
        while ($row = $result->fetch_assoc()) {
            $post = new UnitPost();
            $post->construct($row['ID'], $row['club'], $row['title'], $row['publisher'], $row['information'],$row['attachment'], $row['publish'] );
            $posts[$count++] = $post;
        }

        return json_encode($posts);
    }

    function joinClub($cid, $uid){
        global $conn;

        $sql = "SELECT * FROM club WHERE id = '$cid'";
        $result = $conn->query($sql);

        $row = $result->fetch_assoc();
        $membersStr = $row['members'];
        $membersIDs = explode(";", $membersStr);

        if (count($membersIDs) > 0) {
            for ($i = 1; $i < count($membersIDs); $i++) {
                if ($membersIDs[$i] == $uid) {
                    return "the student is already in this class";
                }
            }
        }

        $membersStr .= ";" . $uid;

        $sql = "UPDATE club SET members = '$membersStr' WHERE id = '$cid'";
        if ($conn->query($sql) !== TRUE){
            return "Unexpected error.";
        }

        $sql = "SELECT watchClubs FROM student WHERE id='$cid'";

        $membersStr = $row['watchclubs'];
        $membersStr .= ";" . $cid;

        $sql = "UPDATE student SET watchClubs = '$membersStr' WHERE id= '$uid'";
        if ($conn->query($sql) !== TRUE){
            return "Unexpected error.";
        }

        return "Success";
    }

    function leaveClub($cid, $uid){
        global $conn;
        $sql = "SELECT members FROM club WHERE id = '$cid'";
        $result = $conn->query($sql);

        $row = $result->fetch_assoc();
        $membersStr = $row['members'];
        $membersIDs = explode(";", $membersStr);
        $membersStr = "";

        if (count($membersIDs) > 0){
            for ($i = 1; $i < count($membersIDs); $i++){
                if ($membersIDs[$i] != $uid){
                    $membersStr .= ";" . $membersIDs[$i];
                }
            }
        }

        $sql = "UPDATE club SET members = '$membersStr' WHERE id = '$cid'";
        if ($conn->query($sql) !== TRUE){
            return "Unexpected error.";
        }
        
        $sql = "SELECT watchClubs FROM student WHERE id='$cid'";
        $row = $result->fetch_assoc();
        $membersStr = $row['watchClubs'];
        $membersIDs = explode(";", $membersStr);
        $membersStr = "";

        if (count($membersIDs) > 0){
            for ($i = 1; $i < count($membersIDs); $i++){
                if ($membersIDs[$i] != $uid){
                    $membersStr .= ";" . $membersIDs[$i];
                }
            }
        }
        $sql = "UPDATE student SET watchClubs='$membersStr' WHERE id='$cid'";
        if ($conn->query($sql) !== TRUE){
            return "Unexpected error.";
        }
        return "Success";
    }

    function processFromDBStringToArray($dbStringMembers){
        $membersIDStr = explode(";", $dbStringMembers);
        $members = array();
        for ($i = 1; $i < count($membersIDStr) ; $i++){
            $member = $membersIDStr[$i];
            $members[$i-1] = $member;
        }

        return $members;
    }
}
