<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Auth_service{
    
    protected $CI;
    
    protected $controller;
    protected $method;

    protected $routes;
    protected $urls;

    public function __construct($params = [])
    {
        $this->CI =& get_instance();

        $this->routes = $params['routes'];
        $this->urls = $params['urls'];

        $this->controller = $this->CI->uri->segment(1, '*');
        $this->method = $this->CI->uri->segment(2, '*');
    }

    public function check()
    {
        return !!$this->CI->session->userdata('auth') && !!$this->CI->session->userdata('user_id');
    }

    public function user()
    {
        return (array) $this->CI->session->userdata('user');
    }

	public function login($user)
	{
        $this->CI->session->set_userdata(array(
            'user' => $user,
            'auth' => TRUE,
            'user_id' => $user['user_id']
        ));
        
        $this->CI->activities->stamp('login', $this->type(), array(), array());

        $this->CI->model->table($this->user_table())->update(array(
            $this->primary_key() => $this->id()
        ), array(
            'login_at' => date("Y-m-d H:i:s")
        ));

        redirect(
            $this->CI->session->userdata('after_login_redirect_url') ? 
                $this->CI->session->userdata('after_login_redirect_url') : site_url($this->urls['auth'])
        );
	}

	public function logout()
	{
        $this->CI->activities->stamp('logout', $this->type(), array(), array());

        $this->CI->model->table($this->user_table())->update(array(
            $this->primary_key() => $this->id()
        ), array(
            'logout_at' => date("Y-m-d H:i:s")
        ));
        
		$this->CI->session->sess_destroy();

		redirect(site_url($this->urls['unauth']));
	}

    public function role()
    {
        return isset($this->user()['role']) ? $this->user()['role'] : NULL;
    }
    
    public function type()
    {
        return isset($this->user()['type']) ? $this->user()['type'] : NULL;
    }
    
    public function id()
    {
        return isset($this->user()['user_id']) ? $this->user()['user_id'] : NULL;
    }
    
    public function user_table()
    {
        return isset($this->user()['user_table']) ? $this->user()['user_table'] : NULL;
    }
    
    public function primary_key()
    {
        return isset($this->user()['primary_key']) ? $this->user()['primary_key'] : NULL;
    }
    
    public function isGuestRoute()
    {
        return array_key_exists($this->controller, $this->routes['unauth'])
            && (
                in_array($this->method, $this->routes['unauth'][$this->controller]) 
                || in_array('*', $this->routes['unauth'][$this->controller])
            );
    }

    public function isAuthRoute()
    {
        return array_key_exists($this->controller, $this->routes['auth'])
            && (
                in_array($this->method, $this->routes['auth'][$this->controller]) 
                || in_array('*', $this->routes['auth'][$this->controller])
            );
    }

    public function isAPIRoute()
    {
        return array_key_exists($this->controller, $this->routes['api'])
            && (
                in_array($this->method, $this->routes['api'][$this->controller]) 
                || in_array('*', $this->routes['api'][$this->controller])
            );
    }

    public function unauth_url()
    {
        return $this->urls['unauth'];
    }

    public function auth_url()
    {
        return $this->urls['auth'];
    }
    
    public function prev_url($url_or_index = NULL){
        return $_SERVER['HTTP_REFERER'];
    }
    
}