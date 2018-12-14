<?php defined('BASEPATH') OR exit('No direct script access allowed');

class App_service{
    
    protected $global;

    public function __construct($params = [])
    {
        $this->global = $params['global'];
    }
    
    public function global()
    {
        return $this->global;
    }
    
    public function state()
    {
        return $this->global();
    }
}