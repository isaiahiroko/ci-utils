<?php

use Ramsey\Uuid\Uuid;

class Log
{
    protected $CI;

    public function __construct()
    {
        $this->CI =& get_instance();
    }
    
    public function session()
    {
        if(!$this->CI->session->userdata('log_session_id')){
            $this->CI->db->insert('sessions', array(
                'session_id' => Uuid::uuid4()->toString(),
                'hash' => session_id(),
                'detail' => json_encode(array_merge(
                    (array) $this->CI->input->cookie(),
                    (array) $_SERVER
                )),
            ));
            $this->CI->session->set_userdata(array(
                'log_session_id' => $this->CI->db->insert_id(),
            ));
        }
    }
    
    public function page_start()
    {
        $this->CI->db->insert('pages', array(
            'page_id' => Uuid::uuid4()->toString(),
            'session_id' => $this->CI->session->userdata('log_session_id'),
            'url' => $this->CI->uri->uri_string(),
            'start_at' => date("Y-m-d H:i:s"),
        ));
        $this->CI->session->set_userdata(array(
            'log_page_id' => $this->CI->db->insert_id(),
        ));
    }
    
    public function page_end()
    {
        $this->CI->db->where('page_id', $this->CI->session->userdata('log_page_id'))->update('pages', array(
            'end_at' => date("Y-m-d H:i:s"),
        ));
    }
    
    public function activity()
    {
        $this->CI->db->insert('activities', array(
            'activity_id' => Uuid::uuid4()->toString(),
            'page_id' => $this->CI->session->userdata('log_page_id'),
            'element' => $this->CI->uri->segment(1, 0),
            'event' => $this->CI->uri->segment(2, 0),
            'value' => json_encode(array_merge(
                (array) $this->CI->input->cookie(),
                (array) $_SERVER 
            )),
        ));
    }
    
}
