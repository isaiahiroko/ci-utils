<?php defined('BASEPATH') OR exit('No direct script access allowed');

use Ramsey\Uuid\Uuid;

class Notif_service{
    
    protected $CI;
    protected $table = 'notifications';
    protected $user_id, $user_type;

    public function __construct()
    {
        $this->CI =& get_instance();
    }

    public function dd($dump)
    {
        die(var_dump($dump));
    }

    public function log($message, $level = 'info') // ‘error’, ‘debug’ or ‘info’
    {
        log_message($level, $message);
    }

    public function err($message, $status_code = '404', $heading = 'An Error Was Encountered')
    {
        show_error($message, $status_code, $heading);
    }

    public function err_404($page = '')
    {
        show_404($page = '', $log_error = TRUE);
    }

    public function set_flash($data = NULL)
    {
        $this->CI->session->set_flashdata($data);
    }

    public function get_flash($key)
    {
        return $this->CI->session->flashdata($key);
    }

    public function for($user_id, $user_type)
    {
        $this->user_id = $user_id;
        $this->user_type = $user_type;

        return $this;
    }

    public function send($message, $title = NULL, $type = NULL)
    {
        return $this->CI->db->insert($this->table, array(
            'notification_id' => Uuid::uuid4()->toString(),
            'message' => $message,
            'title' => $title,
            'type' => $type,
            $this->CI->inflector->singularize($this->user_type).'_id' => $this->user_id
        ));
    }

    public function get($where = array(), $time_where = array())
    {
        return $this->CI->db->where(array_merge(
            $where,
            $time_where
        ))->where($where)->order_by('created_at', 'DESC')->get($this->table)->result_array();
    }

    public function today($where)
    {
        return $this->get($where, array(
            'created_at >' => date('Y-m-d H:i:s', strtotime("yesterday midnight")),
            'created_at <' => date('Y-m-d H:i:s', strtotime("today midnight"))
        ));
    }

    public function this_week($where)
    {
        return $this->get($where, array(
            'created_at >' => date('Y-m-d H:i:s', strtotime("last week")),
            'created_at <' => date('Y-m-d H:i:s', strtotime("this week"))
        ));
    }

    public function this_month($where)
    {
        return $this->get($where, array(
            'created_at >' => date('Y-m-d H:i:s', strtotime("last month")),
            'created_at <' => date('Y-m-d H:i:s', strtotime("this month"))
        ));
    }

    public function this_year($where)
    {
        return $this->get($where, array(
            'created_at >' => date('Y-m-d H:i:s', strtotime("last year")),
            'created_at <' => date('Y-m-d H:i:s', strtotime("this year"))
        ));
    }

    public function all()
    {
        return $this->get();
    }
}