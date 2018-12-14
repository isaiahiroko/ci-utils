<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Auth
{
    protected $CI;

    public function __construct()
    {
        $this->CI =& get_instance();
    }
    
    public function check()
    {  
        if (!$this->CI->auth->isAPIRoute()) {
            
            // if($this->CI->auth->check() && $this->CI->auth->isAuthRoute()){
            //     return;
            // }
            
            // if(!$this->CI->auth->check() && $this->CI->auth->isGuestRoute()){
            //     return;
            // }

            if($this->CI->auth->check() && $this->CI->auth->isAuthRoute() && $this->CI->auth->isGuestRoute()){
                redirect(site_url($this->CI->auth->auth_url()));
            }

            if(!$this->CI->auth->check() && !$this->CI->auth->isGuestRoute()){
                
                $current_url = $_SERVER['QUERY_STRING'] ? current_url().'?'.$_SERVER['QUERY_STRING'] : current_url();
                $this->CI->session->set_userdata(array(
                    'after_login_redirect_url' => $current_url
                ));
                
                $this->CI->notif->set_flash(array(
                    'notice' => array(
                        'message' => 'You need an account to access the requested information. Login to continue.',
                        'type' => 'danger'
                    )
                ));
                redirect(site_url($this->CI->auth->unauth_url()));
            }

        }

    }
    
}
