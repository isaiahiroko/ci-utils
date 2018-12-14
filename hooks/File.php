<?php

use Ramsey\Uuid\Uuid;

class File
{
    protected $CI;

    public function __construct()
    {
        $this->CI =& get_instance();
    }
    
    public function upload()
    {
        foreach ($_FILES as $key => $value) {
            if(file_exists($value['tmp_name']) && is_uploaded_file($value['tmp_name'])){
                $_POST[$key] = $this->CI->upload->quick($key);
            }
        }
    }
}
