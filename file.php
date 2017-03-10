<?php

function _post($str){
    $val = !empty($_POST[$str]) ? $_POST[$str] : null;
    return $val;
}

header("Content-Type:text/html; charset=utf-8");
if(_post('submit')){
	$upfiles = new Upload();
	$upfiles->upload_file();
}
class Upload{

	public $upload_name;
	public $upload_tmp_name;
	public $upload_final_name;
	public $upload_target_dir;
	public $upload_target_path;
	public $upload_filetype ;
	public $allow_uploadedfile_type;
	public $upload_file_size;
	public $allow_uploaded_maxsize=10000000;

	public function __construct()
	{
		$this->upload_name = $_FILES["file"]["name"];
		$this->upload_filetype = $_FILES["file"]["type"];
		$this->upload_tmp_name = $_FILES["file"]["tmp_name"];
		$this->allow_uploadedfile_type = array('jpeg','jpg','png','gif','bmp','zip','rar','txt','doc','ppt','docx','pptx','xls','xlsx','pdf');
		$this->upload_file_size = $_FILES["file"]["size"];
		$this->upload_target_image_dir="./upload_img";
    $this->upload_target_file_dir="./upload_file";
	}

	public function upload_file()
	{
		$upload_filetype = $this->getFileExt($this->upload_name);

		if(in_array($upload_filetype,$this->allow_uploadedfile_type)){

			if($this->upload_file_size < $this->allow_uploaded_maxsize){

				if(!is_dir($this->upload_target_image_dir))	{
					mkdir($this->upload_target_image_dir);
					chmod($this->upload_target_image_dir,0777);
				}
        if(!is_dir($this->upload_target_file_dir))	{
					mkdir($this->upload_target_file_dir);
					chmod($this->upload_target_file_dir,0777);
				}

				$this->upload_final_name = date("YmdHis").rand(0,100).'.'.$upload_filetype;
        if ($this->getFilePath($this->upload_name)) {
          $this->upload_target_path = $this->upload_target_image_dir."/".$this->upload_final_name;
        }else {
          $this->upload_target_path = $this->upload_target_file_dir."/".$this->upload_final_name;
        }

				if(move_uploaded_file($this->upload_tmp_name,$this->upload_target_path)){
          echo $this->upload_target_path;
        }else{
          echo "failed.";
        }

			}
			else{
				echo("Size limitation exceed.");
			}
		}
		else{
			echo("File Type not supported");
		}
	}

   public function getFileExt($filename){
   		$info = pathinfo($filename);
   		return $info["extension"];
   }

   public function getFilePath($filename){
     $allow_uploadedimage_type = array('jpeg','jpg','png','gif','bmp');
 		 $info = pathinfo($filename);
     if(in_array($info["extension"],$allow_uploadedimage_type)){
       return true;
     }else {
       return false;
     }
   }

}
?>

<form enctype="multipart/form-data" method="POST" action="">
<input type="file" name="file"><input type="submit" name="submit" value="上传">
</form>