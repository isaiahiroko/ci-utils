<?php defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Datatables
 * Tables
 * Scheduler
 */
class Table_service{
    
    protected $CI;
    
    protected $table = NULL;
    protected $select = array();
    protected $where = array();
    protected $user_filter = array();
    protected $or_where = array();
    protected $where_in = array();
    protected $columns_to_edit = array();
    protected $columns_to_add = array();
    protected $joins = array();
    protected $date_range_filters = array();
    protected $location_filters = array();

    protected $entity, $type, $sub_type, $bu_id;
    protected $action, $activity, $order_ids;


    protected $matrix, $user_type_table_name_map, $user_type_filter_map,  
        $tabs, $action_status_map, $action_types, $entity_types, $opposite_entity_types;

    public function __construct($params = [])
    {
        $this->CI =& get_instance();

        $this->matrix = $params['matrix'];
        $this->user_type_table_name_map = $params['user_type_table_name_map'];
        $this->user_type_filter_map = $params['user_type_filter_map'];
        $this->action_status_map = $params['action_status_map'];
        $this->action_types = $params['action_types'];

        $this->CI->load->library('datatables'); 
    }

    public function name($table_name)
    {
        $this->table = $table_name;
        return clone $this;
    }

    public function add_select($columns = array('*'))
    {
        $this->select = array_merge($this->select, $columns);
        return $this;
    }

    public function add_where($where)
    {
        $this->where = array_merge($this->where, $where);
        return $this;
    }

    public function add_or_where($or_where)
    {
        $this->or_where = array_merge($this->or_where, $or_where);
        return $this;
    }

    public function add_where_in($where_in)
    {
        $this->where_in = array_merge($this->where_in, $where_in);
        return $this;
    }

    public function add_columns_to_edit($columns)
    {
        $this->columns_to_edit = array_merge($this->columns_to_edit, $columns);
        return $this;
    }

    public function add_columns_to_add($columns)
    {
        $this->columns_to_add = array_merge($this->columns_to_add, $columns);
        return $this;
    }

    public function add_joins($joins)
    {
        $this->joins = array_merge($this->joins, $joins);
        return $this;
    }

    public function add_user_filter($type = 'surveys'){
        
        $user_id = $this->CI->auth->id();
        $user_type = $this->CI->auth->type();

        $where = array();
        
        if(!is_null($this->user_type_table_name_map[$user_type])){
            $where[] = array(
                'survey_'.$this->CI->inflector->singularize($this->user_type_table_name_map[$user_type]).'_id' => $user_id
            );
            $where[] = array(
                'installation_'.$this->CI->inflector->singularize($this->user_type_table_name_map[$user_type]).'_id' => $user_id
            );
        }

        if(!empty($this->user_type_filter_map[$user_type])){
            $where[] = $this->user_type_filter_map[$user_type];
        }

        //specials
        //agent
        if($user_type == 'agent'){
            $this->CI->load->model('agents_model', 'agents');
            $agent = $this->CI->agents->read_one(array(
                'agent_id' => $user_id
            ));            
            if(isset($agent['sbc_id']) && in_array($type, array('surveys', 'installations'))){
                $where[] = array(
                    $this->CI->inflector->singularize($type).'_sbc_id' => $agent['sbc_id']
                );
            }
        }
        
        //qaqc
        if($user_type == 'qaqc'){
            $this->CI->load->model('staffs_model', 'staffs');
            $qaqc = $this->CI->staffs->read_one(array(
                'staff_id' => $user_id
            )); 
                 
            if(isset($qaqc['staff_id']) && in_array($type, array('surveys', 'installations'))){
                $where[] = array(
                    $this->CI->inflector->singularize($type).'_qaqc_id' => $qaqc['staff_id']
                );
            }
        }

        //customer
        if(in_array($user_type, array('individual', 'business'))){
            $where[] = array(
                'customer_id'    => $user_id
            );
        }

        $this->user_filter = $where;

        return $this;
    }

    public function add_date_range_filters($from, $to)
    {
        if(isset($from) && is_array($from) && !empty($from)
            && isset($to) && is_array($to) && !empty($to)){

            $this->from = $from;
            $this->to = $to;

            $this->date_range_filters = array_merge(
                $this->date_range_filters,
                array(
                    'DATE(created_at) >=' => $from,
                    'DATE(created_at) <=' => $to,
                    'deleted_at' => NULL,
                )
            );
        }

        return $this;
    }

    public function add_location_filters($locations = array())
    {
        if(is_array($locations) && count($locations) > 0){
            foreach ($locations as $name => $ids) {
                $this->location_filters[$name] = $ids;
            }
        }

        return $this;

    }

    public function count()
    {
         //apply user filter
        if(!empty($this->user_filter)){
            $this->CI->db->group_start();
            foreach ($this->user_filter as $index => $where) {
                $where = (array) $where;
                if($index == 0){
                    $this->CI->db->group_start();
                    $this->CI->db->where($where);
                    $this->CI->db->group_end();
                }
                else{
                    $this->CI->db->or_group_start();
                    $this->CI->db->where($where);
                    $this->CI->db->group_end();
                }
            }
            $this->CI->db->group_end();
        }
        
        if(!empty($this->where)){
            $this->CI->db->group_start();
            foreach ($this->where as $index => $where) {
                $where = (array) $where;
                if($index == 0){
                    $this->CI->db->group_start();
                    $this->CI->db->where($where);
                    $this->CI->db->group_end();
                }
                else{
                    $this->CI->db->or_group_start();
                    $this->CI->db->where($where);
                    $this->CI->db->group_end();
                }
            }
            $this->CI->db->group_end();
        }

        foreach ($this->where_in as $in => $where) {
            $where = (array) $where;
            $this->CI->db->where_in($in, $where);
        }

        foreach ($this->joins as $join) {
            $join = (array) $join;
            $this->CI->db->join(
                $join[0], 
                $join[1], 
                $join[2]
            );
        }

        foreach ($this->columns_to_edit as $value) {
            $value = (array) $value;
            $this->CI->datatables->edit_column(
                $value[0], 
                $value[1], 
                $value[2]
            );
        }

        foreach ($this->columns_to_add as $value) {
            $value = (array) $value;
            $this->CI->datatables->edit_column(
                $value[0], 
                $value[1], 
                $value[2]
            );
        }
        
        if(!empty($this->date_range_filters)){
            $this->CI->db->group_start();
            foreach ($this->date_range_filters as $where) {
                $where = (array) $where;
                if($index == 0){
                    $this->CI->db->group_start();
                    $this->CI->db->where($where);
                    $this->CI->db->group_end();
                }
                else{
                    $this->CI->db->or_group_start();
                    $this->CI->db->where($where);
                    $this->CI->db->group_end();
                }
            }
            $this->CI->db->group_end();
        }
        
        if(!empty($this->location_filters)){
            $this->CI->db->group_start();
            foreach ($this->location_filters as $in => $where) {
                $where = (array) $where;
                if($index == 0){
                    $this->CI->db->group_start();
                    $this->CI->db->where_in($in, $where);
                    $this->CI->db->group_end();
                }
                else{
                    $this->CI->db->or_group_start();
                    $this->CI->db->where_in($in, $where);
                    $this->CI->db->group_end();
                }
            }
            $this->CI->db->group_end();
        }
        
        $this->CI->db->select((in_array('*', $this->select) || count($this->select) < 1) ? '*' : implode(',', $this->columns()));
                    
        return $this->CI->db->from($this->table)->count_all_results();
    }

    public function raw_rows()
    {
         //apply user filter
        if(!empty($this->user_filter)){
            $this->CI->db->group_start();
            foreach ($this->user_filter as $index => $where) {
                $where = (array) $where;
                if($index == 0){
                    $this->CI->db->group_start();
                    $this->CI->db->where($where);
                    $this->CI->db->group_end();
                }
                else{
                    $this->CI->db->or_group_start();
                    $this->CI->db->where($where);
                    $this->CI->db->group_end();
                }
            }
            $this->CI->db->group_end();
        }
        
        if(!empty($this->where)){
            $this->CI->db->group_start();
            foreach ($this->where as $index => $where) {
                $where = (array) $where;
                if($index == 0){
                    $this->CI->db->group_start();
                    $this->CI->db->where($where);
                    $this->CI->db->group_end();
                }
                else{
                    $this->CI->db->or_group_start();
                    $this->CI->db->where($where);
                    $this->CI->db->group_end();
                }
            }
            $this->CI->db->group_end();
        }

        foreach ($this->where_in as $in => $where) {
            $where = (array) $where;
            $this->CI->db->where_in($in, $where);
        }

        foreach ($this->joins as $join) {
            $join = (array) $join;
            $this->CI->db->join(
                $join[0], 
                $join[1], 
                $join[2]
            );
        }

        foreach ($this->columns_to_edit as $value) {
            $value = (array) $value;
            $this->CI->datatables->edit_column(
                $value[0], 
                $value[1], 
                $value[2]
            );
        }

        foreach ($this->columns_to_add as $value) {
            $value = (array) $value;
            $this->CI->datatables->edit_column(
                $value[0], 
                $value[1], 
                $value[2]
            );
        }

        if(!empty($this->date_range_filters)){
            $this->CI->db->group_start();
            foreach ($this->date_range_filters as $where) {
                $where = (array) $where;
                if($index == 0){
                    $this->CI->db->group_start();
                    $this->CI->db->where($where);
                    $this->CI->db->group_end();
                }
                else{
                    $this->CI->db->or_group_start();
                    $this->CI->db->where($where);
                    $this->CI->db->group_end();
                }
            }
            $this->CI->db->group_end();
        }
        
        if(!empty($this->location_filters)){
            $this->CI->db->group_start();
            foreach ($this->location_filters as $in => $where) {
                $where = (array) $where;
                if($index == 0){
                    $this->CI->db->group_start();
                    $this->CI->db->where_in($in, $where);
                    $this->CI->db->group_end();
                }
                else{
                    $this->CI->db->or_group_start();
                    $this->CI->db->where_in($in, $where);
                    $this->CI->db->group_end();
                }
            }
            $this->CI->db->group_end();
        }

        $this->CI->db->select((in_array('*', $this->select) || count($this->select) < 1) ? '*' : implode(',', $this->columns()));
                    
        $after = $this->CI->db->get($this->table)->result_array();

        $this->CI->activities->stamp('read many (table)', $this->table, array(), array());

        return $after;
    }

    public function rows()
    {
         //apply user filter
        if(!empty($this->user_filter)){
            $this->CI->datatables->group_start();
            foreach ($this->user_filter as $index => $where) {
                $where = (array) $where;
                if($index == 0){
                    $this->CI->datatables->group_start();
                    $this->CI->datatables->where($where);
                    $this->CI->datatables->group_end();
                }
                else{
                    $this->CI->datatables->or_group_start();
                    $this->CI->datatables->where($where);
                    $this->CI->datatables->group_end();
                }
            }
            $this->CI->datatables->group_end();
        }
        
        if(!empty($this->where)){
            $this->CI->datatables->group_start();
            foreach ($this->where as $index => $where) {
                $where = (array) $where;
                if($index == 0){
                    $this->CI->datatables->group_start();
                    $this->CI->datatables->where($where);
                    $this->CI->datatables->group_end();
                }
                else{
                    $this->CI->datatables->or_group_start();
                    $this->CI->datatables->where($where);
                    $this->CI->datatables->group_end();
                }
            }
            $this->CI->datatables->group_end();
        }
        foreach ($this->where_in as $in => $where) {
            $where = (array) $where;
            $this->CI->datatables->where_in($in, $where);
        }

        foreach ($this->joins as $join) {
            $join = (array) $join;
            $this->CI->datatables->join(
                $join[0], 
                $join[1], 
                $join[2]
            );
        }

        foreach ($this->columns_to_edit as $value) {
            $value = (array) $value;
            $this->CI->datatables->edit_column(
                $value[0], 
                $value[1], 
                $value[2]
            );
        }

        foreach ($this->columns_to_add as $value) {
            $value = (array) $value;
            $this->CI->datatables->edit_column(
                $value[0], 
                $value[1], 
                $value[2]
            );
        }
        
        if(!empty($this->date_range_filters)){
            $this->CI->datatables->group_start();
            foreach ($this->date_range_filters as $where) {
                $where = (array) $where;
                if($index == 0){
                    $this->CI->datatables->group_start();
                    $this->CI->datatables->where($where);
                    $this->CI->datatables->group_end();
                }
                else{
                    $this->CI->datatables->or_group_start();
                    $this->CI->datatables->where($where);
                    $this->CI->datatables->group_end();
                }
            }
            $this->CI->datatables->group_end();
        }
        
        if(!empty($this->location_filters)){
            $this->CI->datatables->group_start();
            foreach ($this->location_filters as $in => $where) {
                $where = (array) $where;
                if($index == 0){
                    $this->CI->datatables->group_start();
                    $this->CI->datatables->where_in($in, $where);
                    $this->CI->datatables->group_end();
                }
                else{
                    $this->CI->datatables->or_group_start();
                    $this->CI->datatables->where_in($in, $where);
                    $this->CI->datatables->group_end();
                }
            }
            $this->CI->datatables->group_end();
        }

        // var_dump([$this->date_range_filters, $this->location_filters]);

        $this->CI->datatables->select((in_array('*', $this->select) || count($this->select) < 1) ? '*' : implode(',', $this->columns()));
        
        $this->CI->datatables->from($this->table);
            
        $after = $this->CI->datatables->generate();

        $this->CI->activities->stamp('read many (datatable)', $this->table, array(), array());

        return $after;
    }

    public function columns()
    {
        return (in_array('*', $this->select)) ? $this->db->list_fields($this->table) : $this->select;
    }
    
    public function cards($merged = FALSE)
    {
        return ($merged) ? array_merge(
            $this->matrix['optional'],
            $this->matrix['default']
        ) : array(
            $this->matrix['default'],
            $this->matrix['optional'],
        );
    }
    
    public function make($type = NULL, $sub_type = NULL, $entity = NULL, $bu_id = NULL, $action = NULL, $activity = NULL, $order_ids = NULL)
    {
        return array(
            'cards' => $this->cards(),
            'tabs' => $this->cards(TRUE)[$type]['tabs'],
            'actions' => $this->cards(TRUE)[$type]['actions'],
            'columns' => $this->columns(),
            'rows' => $this->rows(),
        );
    }
    
}