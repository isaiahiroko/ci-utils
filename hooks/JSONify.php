<?php

use Ramsey\Uuid\Uuid;

class JSONify
{
    protected $CI;

    protected $fields = array(
        'policies',
        'location',
    );

    public function __construct()
    {
        $this->CI =& get_instance();
    }
    
    public function jsonify()
    {
        foreach ($_POST as $key => $value) {
            if(in_array($key, $this->fields)){
                $_POST[$key] = json_encode($value);
            }
        }
    }
}
