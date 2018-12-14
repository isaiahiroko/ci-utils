<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Gate
{
    public function __construct()
    {
        $this->CI =& get_instance();
    }
    
    public function check()
    {  
        $user = $this->CI->auth->user();
        $entity = $this->CI->uri->segment(1);
        $ability = $this->CI->uri->segment(2);
        
        if (!$this->CI->auth->isAPIRoute()) {
            if(
                $this->CI->auth->check()
                && isset($entity) && isset($ability)
                && !$this->CI->gate->check($user, $entity,  $ability)
            ){
                $this->CI->notif->set_flash(array(
                    'notice' => array(
                        'message' => 'Access denied. You do not have permission to access this resource.',
                        'type' => 'danger'
                    )
                ));
                return redirect($this->CI->auth->auth_url());
            }
        }
    }
    
}
