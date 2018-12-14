<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Paystack_service{

    private $CI;
    private $params;

    private $user = NULL;
    private $user_type = NULL;
    private $user_role = NULL;

    private $entity_name;

    public function __construct($params = [])
    {
        $this->params = $params;
        $this->CI =& get_instance();
    }

}