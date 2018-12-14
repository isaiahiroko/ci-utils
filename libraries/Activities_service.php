<?php defined('BASEPATH') OR exit('No direct script access allowed');

use Ramsey\Uuid\Uuid;

class Activities_service{
    
    protected $CI;
    protected $table = 'user_logs';
    protected $user_id, $user_type;

    public function __construct()
    {
        $this->CI =& get_instance();
        $this->init();
    }

    public function init()
    {
        $this->CI->load->model($this->table.'_model', $this->table);        
    }

    public function stamp($activity, $entity, $before, $after) // ‘error’, ‘debug’ or ‘info’
    {
        if(in_array($entity, array('customer_orders'))){
            $entity = 'orders';
        }
        if(in_array($entity, array('admin', 'nmd', 'cs', 'ns', 'qaqc'. 'finance'))){
            $entity = 'staffs';
        }

        $user_table =  $this->CI->auth->type();
        if(in_array($user_table, array('admin', 'nmd', 'cs', 'ns', 'qaqc'. 'finance'))){
            $user_table = 'staffs';
        }
        
        $entity_id = isset($after[$this->CI->inflector->singularize($entity).'_id']) ? $after[$this->CI->inflector->singularize($entity).'_id'] : NULL;
        $this->CI->db->insert($this->table, array(
            'user_log_id' => Uuid::uuid4()->toString(),
            'user_table' => $user_table,
            'user_id' => $this->CI->auth->id(),
            'activity' => $activity,
            'entity' => $entity,
            'entity_id' => $entity_id,
            'before' => json_encode($before),
            'after' => json_encode($after),
            'updated_at' => date("Y-m-d H:i:s"),
            'created_at' => date("Y-m-d H:i:s"),
        ));
    }

    public function logs($date = NULL, $time = NULL, $users = NULL)
    {
        $q = $this->CI->db->select(array(
            'HOUR(created_at) as hour', 
            'user_log_id', 
            'user_table',
            'user_id',
            'activity',
            'entity',
            'entity_id',
            'before',
            'after',
            'status',
            'updated_at',
            'created_at',
        ));

        $date = (isset($date)) ? $date : date('Y-m-d');
        $time = str_pad((isset($time)) ? $time : date('H'), 2, "0", STR_PAD_LEFT);
        $users = (isset($users)) ? $users : array();

        $q->where(array(
            'DATE(created_at) >=' => $date,
            'DATE(created_at) <=' => $date,
            'HOUR(created_at) >=' => $time,
            'HOUR(created_at) <=' => $time,
            'deleted_at' => NULL,            
        ));

        $user_ids = array();
        $user_tables = array();
        $user_columns = array();
        foreach ($users as $table => $ids) {
            if(in_array($table, array('entities', 'activities')) && !in_array('all', $ids)){
                $user_columns[$this->CI->inflector->singularize($table)] = $ids;
            }
            elseif(in_array('all', $ids)){
                $user_tables[] = $table;
            }
            else{
                $user_ids = array_merge($user_ids, $ids);
            }
        }

        if(!empty($user_ids)){
            $q->where_in('user_id', $user_ids);
        }

        if(!empty($user_tables)){
            $q->where_in('user_table', $user_tables);
        }

        if(!empty($user_columns)){
            $q->group_start();
            foreach ($user_columns as $column => $values) {
                foreach ($values as $key => $value) {
                    $q->or_where(array($column.' LIKE' => '%'.$value.'%'));
                }
            }
            $q->group_end();
        }
    
        $logs = $q->order_by('created_at', 'DESC')->get($this->table)->result_array();

        $output = array();
        foreach($logs as $log){
            if(isset($log['user_table'])){
                if(in_array($log['user_table'], array('business', 'individual'))){
                    $log['user_table'] = 'customers';
                }
                $this->CI->load->model($log['user_table'].'_model', $log['user_table']);
                $user = $this->CI->db->where(array(
                    $this->CI->inflector->singularize($log['user_table']).'_id' => $log['user_id']
                ))->get($log['user_table'])->row_array();
                            
                $output[] = array_merge(
                    $log,
                    array(
                        'name' => (isset($this->CI->{$log['user_table']}->title_key) && isset($user[$this->CI->{$log['user_table']}->title_key])) ? $user[$this->CI->{$log['user_table']}->title_key] : NULL
                    )
                );
            }
            else{   
                $output[] = array_merge(
                    $log,
                    array(
                        'name' => 'Anonymouse'
                    )
                );
            }

        }
        
        return $output;
        
    }

}