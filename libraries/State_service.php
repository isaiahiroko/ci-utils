<?php defined('BASEPATH') OR exit('No direct script access allowed');

class State_service{

    protected $CI;

    public function __construct()
    {
        $this->CI =& get_instance();
    }

    public function set($key, $value)
    {   
        $this->CI->cache->file->save($key, json_encode($value), 60*5);

        return $this;
    }

    public function get($key)
    {
        return json_decode($this->CI->cache->file->get($key));
    }
}