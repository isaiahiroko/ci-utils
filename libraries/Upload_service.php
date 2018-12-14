<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Upload_service{
    
    protected $CI;
    protected $path;

    public function __construct($params = array())
    {
        $this->CI =& get_instance();
        $this->path = $params['path'];
    }

    public function file($file_input_name, $allowed_file_types = '*'){
        $new_name = random_string().'.'.explode('.', $_FILES[$file_input_name]['name'])[1];
        return (move_uploaded_file($_FILES[$file_input_name]['tmp_name'], $this->path.$new_name))
            ? array(
                'name' => $new_name
            )
            : $_FILES[$file_input_name]['error'];
    }

    public function quick($file_input_name, $redirect_to = NULL, $required = TRUE, $allowed_file_types = '*'){
        $file = $this->file($file_input_name, $allowed_file_types);
        if(is_array($file)){
            return $file['name'];
        }
        else{
            
            if($required){
                return '';
            }

            $this->CI->notif->set_flash(array(
                'notice' => array(
                    'message' => $file,
                    'type' => 'success'
                )
            ));
            return redirect(site_url(isset($redirect_to) ? $redirect_to : uri_string()));
        }
    }
    
}

 /**
     * success return data array
     * failure return error string
     * 
     */
    
    // Array
    // (
    //         [file_name]     => mypic.jpg
    //         [file_type]     => image/jpeg
    //         [file_path]     => /path/to/your/upload/
    //         [full_path]     => /path/to/your/upload/jpg.jpg
    //         [raw_name]      => mypic
    //         [orig_name]     => mypic.jpg
    //         [client_name]   => mypic.jpg
    //         [file_ext]      => .jpg
    //         [file_size]     => 22.2
    //         [is_image]      => 1
    //         [image_width]   => 800
    //         [image_height]  => 600
    //         [image_type]    => jpeg
    //         [image_size_str] => width="800" height="200"
    // )
