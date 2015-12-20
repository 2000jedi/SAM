<?php
/**
 * Created by IntelliJ IDEA.
 * User: Sam
 * Date: 3/15/15
 * Time: 12:30
 */

function Redirect($url, $permanent = false)
{
    header('Location: ' . $url, true, $permanent ? 301 : 302);

    exit();
}
function equalFloat($a, $b){
    if (abs(($a-$b)/$b) < 0.00001) {
        return true;
    }else{
        return false;
    }
}
function processAttachment(){
    global $mode;

    $target_dir = "/files/attachments/";

    $attachment = "";

    for ($i = 0; $i < count($_FILES["attachment"]['name']); $i++ ){
        $originalName = $_FILES["attachment"]['name'][$i];
        $realNameArr = explode(".",$originalName);
        $realName = "";
        for ($ii = 0; $ii < count($realNameArr)-1; $ii++){
            $realName .= $realNameArr[$ii];
        }
        $fileType = pathinfo($originalName, PATHINFO_EXTENSION);
        $final_filename = $realName."_".time().".".$fileType;
        if ($mode == "local"){
            $target_file = $_SERVER['DOCUMENT_ROOT'].$target_dir .$final_filename;

            $attachment .= ";".$target_dir.$final_filename.";".$originalName;

            move_uploaded_file($_FILES["attachment"]["tmp_name"][$i], $target_file);
        }else if ($mode == "SAE"){
            $fileContent=file_get_contents($_FILES["attachment"]["tmp_name"][$i]);
            $temp=new SaeStorage();
            $temp->write("wflmssam",$final_filename,$fileContent);
            $url=$temp->getUrl($domain,$final_filename);

            $attachment .= ";".$url.";".$originalName;
        }
    }
    return $attachment;
}

?>