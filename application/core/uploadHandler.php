<?php 
error_reporting(E_ALL); //Will help you debug a [server/path/permission] issue
Class uploadHandler{
    
    const UPLOAD_SUCCESS="Upload success!";
    
    public $upload_path;
    public $full_path;
    public $name;
    public $size;
    public $ext;
    public $output;
    public $input;
    public $prefix;
    private $allowed;

    function upload(){
        if($_SERVER['REQUEST_METHOD'] == 'POST'){
            if(isset($_FILES[$this->input]['error'])){
                if($_FILES[$this->input]['error'] == 0){
                    $this->name      = basename($_FILES[$this->input]['name']);
                    $file_p          = explode('.',$this->name);
                    $this->ext       = end($file_p);
                    $this->full_path = rtrim($this->upload_path,'/').'/'.preg_replace('/[^a-zA-Z0-9.-]/s', '_', $this->prefix.'_'.$file_p[0]).'.'.$this->ext;
                    $info            = getimagesize($_FILES[$this->input]['tmp_name']);
                    $this->size      = filesize($_FILES[$this->input]['tmp_name']);

                    if($info[0]>$this->allowed['dimensions']['width'] || $info[1] > $this->allowed['dimensions']['height']){
                        $this->output = 'File dimensions too large!';
                    }else{
                        if($info[0] > 0 && $info[1] > 0 && in_array($info['mime'],$this->allowed['types'])){
                            move_uploaded_file($_FILES[$this->input]['tmp_name'],$this->full_path);
                            $this->output = 'Upload success!';
                        }else{
                            $this->output = 'File not supported!';
                        }
                    }
                }else{
                    if($_FILES[$this->input]['error']==1){$this->output = 'The uploaded file exceeds the upload_max_filesize directive!';}
                    if($_FILES[$this->input]['error']==2){$this->output = 'The uploaded file exceeds the MAX_FILE_SIZE directive that was specified in our HTML form!';}
                    if($_FILES[$this->input]['error']==3){$this->output = 'The uploaded file was only partially uploaded!';}
                    if($_FILES[$this->input]['error']==4){$this->output = 'No file was uploaded!';}
                    if($_FILES[$this->input]['error']==6){$this->output = 'Missing a temporary folder!';}
                    if($_FILES[$this->input]['error']==7){$this->output = 'Failed to write uploaded file to disk!';}
                    if($_FILES[$this->input]['error']==8){$this->output = 'A PHP extension stopped the file upload!';}
                }
            }
        }
    }

    function setPath($var){
        $this->upload_path = $var;
    }
    function setAllowed($var=array()){
        $this->allowed = $var;
    }
    function setFilePrefix($var){
        $this->prefix = preg_replace('/[^a-zA-Z0-9.-]/s', '_', $var);
    }
    function setInput($var){
        $this->input = $var;
    }
    
    function getFileUrl(){
        return $this->full_path;
    }

}