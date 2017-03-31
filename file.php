<?php
header("Content-Type:text/html; charset=utf-8");
if(isset($_FILES['file'])){
	$upfiles = new Upload();
	$msg = $upfiles->upload_file();
	echo $msg;
} else {
	echo "No Files.";
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
	// SHA-512 for "Make Computerization Great Again"
	public $authentication_key = "cd30d21199b0cf0fda01047e8608081fcb2fd227836fd6fcf282f7f93d406c143da365df48014310ac049a754af3cea04dd24d4596797995fd7a724d4e830dd4";
	public $user_key;
	public $allow_uploaded_maxsize=100000000;

	public function __construct()
	{
		$this->user_key = $_POST['auth_key'];
		$this->upload_file = $_FILES["file"];
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

		if(!($this->checkSubmissionValid($this->upload_file,$this->user_key))){
			return "Authentication Failed.";
		}

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

			      $fileinfo = array('path' => $this->upload_target_path, 'filename' => $this->upload_final_name, 'ext' => $this->getFileExt($this->upload_name), 'is_img' => $this->getFilePath($this->upload_name));
						return json_encode($fileinfo);
        }else{
          return "Failed.";
        }

			}
			else{
				return "Size limitation exceed.";
			}
		}
		else{
			return "File Type not supported";
		}
	}

	public function checkSubmissionValid($upload_file,$user_key){

		// further check file
		// return false if failed.

		if ($user_key == $this->authentication_key) {
			return true;
		}

		return false;

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
