<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

use Ramsey\Uuid\Uuid;

class MY_Model extends CI_Model {

    protected $table = "";

    protected $primary_key = "";
    
    protected $title_key = "";

    protected $columns = array(); //for Datatable

    protected $fillable = array();

    protected $hidden = array();
    
    protected $id_name_map = array();

    protected $imports = array();

    protected $parent = array();

    protected $parents = array();
    
    protected $child = array();

    protected $children = array();

    protected $solo_actions = array(
        array(
            "title" => "View",
            "action" => "datatableAction",
            "args" => "read, entity",
            "type" => "single-selection-only",
            'entity' => 'orders',
            'ability' => 'read',
            'user' => array('admin'),
            'icon' => 'eye',
        ),
        array(
            "title" => "Edit",
            "action" => "datatableAction",
            "args" => "update, entity",
            "type" => "single-selection-only",
            'entity' => 'orders',
            'ability' => 'update',
            'user' => array('admin'),
            'icon' => 'edit',
        ),					
        array(
            "title" => "Delete",
            "action" => "datatableAction",
            "args" => "delete, entity",
            "type" => "single-selection-only",
            'entity' => 'orders',
            'ability' => 'delete',
            'user' => array('admin'),
            'icon' => 'times',
        )
    );

    protected $datatable = array();

    protected $fields = array();

    function __construct()
    {
        parent::__construct();
    }

    public function pre_create($pre_data)
    {
        return $pre_data;
    }

    public function post_create($post_data)
    {
        return $post_data;
    }

    public function table_name()
    {
        return $this->table;
    }

    public function columns_map()
    {
        return $this->columns;
    }

    public function fillable()
    {
        return array_keys($this->columns_map());
    }

    public function hidden()
    {
        return $this->hidden;
    }

    public function show()
    {
        return array_diff($this->fillable(), $this->hidden());
    }    

	public function to_select()
	{
		return $this->show();
    }
    
    public function imports()
    {
        return $this->imports;
    }    

    public function exports($type = 'default')
    {
        return $this->exports[$type];
    }    

    public function export_app_columns()
    {
        return array_map(function ($v){
            return $v['app'];
        }, $this->exports());
    }

    public function export_user_columns()
    {
        return array_map(function ($v){
            return $v['user'];
        }, $this->exports());
    }

    public function export_title_columns()
    {        
        return array_map(function ($v){
            return $v['title'];
        }, $this->exports());
    }

    public function export_edit_columns()
    {        
        return array_map(function ($v){
            return $v['edit'];
        }, $this->exports());
    }

    public function datatable()
    {
        return $this->datatable;
    }    

    public function primary_key()
    {
        return $this->primary_key;
    }
    
    public function title_key()
    {
        return $this->primary_key;
    }
    
    public function id_name_map()
    {
        return $this->id_name_map;
    }

    public function show_app_columns()
    {
        $columns = $this->columns_map();
        return array_map(function ($v) use ($columns) {
            return $columns[$v]['app'];
        }, $this->show());
    }

    public function show_user_columns()
    {
        $columns = $this->columns_map();
        return array_map(function ($v) use ($columns) {
            return $columns[$v]['user'];
        }, $this->show());
    }

    public function show_title_columns()
    {
        $columns = $this->columns_map();
        return array_map(function ($v) use ($columns) {
            return $columns[$v]['title'];
        }, $this->show());
    }

    public function show_edit_columns()
    {
        $columns = $this->columns_map();
        return array_map(function ($v) use ($columns) {
            return $columns[$v]['edit'];
        }, $this->show());
    }

    public function save_primary_columns()
    {
        $columns = $this->columns_map();
        return array_reduce($this->show(), function ($prev, $curr) use ($columns) {
            return array_merge($prev, array($columns[$curr]['app'] => $columns[$curr]['primary']));
        }, array());
    }

    public function import_app_columns()
    {
        return array_map(function ($v){
            return $v['app'];
        }, $this->imports());
    }

    public function import_user_columns()
    {
        return array_map(function ($v){
            return $v['user'];
        }, $this->imports());
    }

    public function import_title_columns()
    {        
        return array_map(function ($v){
            return $v['title'];
        }, $this->imports());
    }

    public function import_edit_columns()
    {        
        return array_map(function ($v){
            return $v['edit'];
        }, $this->imports());
    }

    public function import_save_primary_columns()
    {        
        return array_reduce($this->imports(), function ($prev, $curr){
            return array_merge($prev, array($columns[$curr]['app'] => $columns[$curr]['primary']));
        }, array());
    }

    public function parent(){
        return $this->parent;
    }

    public function child(){
        return $this->child;
    }

    public function parents(){
        return $this->parents;
    }

    public function children(){
        return $this->children;
    }

    public function table($table, $primary_key = NULL)
    {
        $this->table = $table;
        $this->primary_key = isset($primary_key) ? $primary_key : $this->inflector->singularize($table).'_id';
        return clone $this;
    }

    public function select($fields)
    {

        $this->fields = $fields;
        return clone $this;
    }

    public function uuid(){
        return Uuid::uuid4()->toString();
    }

    public function create($data, $is_batch = FALSE){

        if($is_batch){

            $this->activities->stamp('batch-create', $this->table, array(), array());

            return $this->db->insert_batch($this->table, $data); 
        }

        $id = Uuid::uuid4()->toString();
        $this->db->insert($this->table, array_merge(
            $data,
            array(
                $this->primary_key => $id,
                'updated_at' => date("Y-m-d H:i:s"),
                'created_at' => date("Y-m-d H:i:s"),
            )
        ));
        
        $after = $this->read_one(array($this->primary_key =>  $id));

        $this->activities->stamp('create', $this->table, array(), $after);

        return $after;
    }

    public function update($where, $data, $is_batch = FALSE){

        if($is_batch){

            $this->activities->stamp('batch-update', $this->table, array(), array());

            return $this->db->where($where)->update_batch($this->table, $data); 
        }

        $before = $this->read_one($where);

        $this->db->where($where)->update($this->table, array_merge(
            $data,
            array(
                'updated_at' => date("Y-m-d H:i:s"),
            )
        ));
        
        $after = $this->read_one($where);

        $this->activities->stamp('update', $this->table, $before, $after);

        return $after;
    }

    public function upsert($where, $data, $is_batch = FALSE){
        
        if($this->count($where) > 0){
            $this->update($where, $data, $is_batch);
        }
        else{
            $this->create($data, $is_batch);
        }

        return $this->read_one($where);
    }

    public function read_one($where){
        
        if(!empty($this->fields)){
            $this->db->select($this->fields);
        }
        
        $after = $this->db->where(array_merge(
            $where,
            array(
                'deleted_at' => NULL
            )
        ))->get($this->table)->row_array();

        $this->activities->stamp('read one', $this->table, array(), $after);

        return $after;

    }
    
    public function read_many($where, $limit = 12, $offset = 0, $orderBy = 'updated_at', $direction = 'DESC'){
        
        $this->activities->stamp('read many', $this->table, array(), array());

        return $this->db->where(array_merge(
            $where,
            array(
                'deleted_at' => NULL
            )
        ))->order_by($orderBy, $direction)->get($this->table)->result_array();
        // return $this->db->where($where)->order_by($orderBy, $direction)->limit($limit, $offset)->get($this->table)->result_array();
    } 
    
    public function read_many_in($column, $in, $where = array(), $limit = 12, $offset = 0, $orderBy = 'updated_at', $direction = 'DESC'){
        
        $this->activities->stamp('read many', $this->table, array(), array());
        
        return $this->db->where_in($column, $in)->where(array_merge(
            $where,
            array(
                'deleted_at' => NULL
            )
        ))->order_by($orderBy, $direction)->get($this->table)->result_array();
    }
    
    public function read_all($where = array()){
        $this->activities->stamp('read many', $this->table, array(), array());
        return $this->db->where(array_merge(
            $where,
            array(
                'deleted_at' => NULL
            )
        ))->get($this->table)->result_array();
    }

    public function paginate($where, $page = 1, $per_page = 12, $appends_url = 'collection'){
        
        $total = $this->count($where);
        $limit  = $per_page;
        $offset  = ($per_page) * ($page - 1);

        $this->pagination->initialize(array(
            'total_rows' => $total,
            'per_page' => $limit ,
            'base_url' => '/'.$this->table.'/'.$appends_url,
        ));
        
        return array(
            'items' => $this->read_many($where, $limit, $offset),
            'total' => $total,
            'links' => $this->pagination->create_links(),
        );
    }

    public function soft_delete($where){
        $before = $this->db->where($where)->update($this->table, array_merge(
            array(
                'deleted_at' => date("Y-m-d H:i:s"),
            )
        ));

        $this->activities->stamp('delete', $this->table, $before, array());

        return $before;
    }

    public function soft_delete_in($where){

        $deleted = $this->read_one($where);
        
        $childs = $this->relationship->with($this->table)->has_one();

        foreach ($childs as $child) {
            $this->load->model($child.'_model', $child);
            $this->{$child}->soft_delete_in(array(
                $this->{$this->table}->primary_key => $deleted[$this->{$this->table}->primary_key]
            ));    
        }

        $before = $this->db->where($where)->update($this->table, array_merge(
            array(
                'deleted_at' => date("Y-m-d H:i:s"),
            )
        ));

        $this->activities->stamp('delete', $this->table, $before, array());

        return $deleted;
    }

    public function delete($where){
        $deleted = $this->read_one($where);
        $this->db->where($where)->delete($this->table);
        $this->activities->stamp('delete (hard)', $this->table, $deleted, array());
        return $deleted;
    }

    public function delete_in($where){
        
        $deleted = $this->read_one($where);
        
        $childs = $this->relationship->with($this->table)->has_one();

        foreach ($childs as $child) {
            $this->load->model($child.'_model', $child);
            $this->{$child}->delete_in(array(
                $this->{$this->table}->primary_key => $deleted[$this->{$this->table}->primary_key]
            ));    
        }

        $this->db->where($where)->delete($this->table);

        $this->activities->stamp('delete (hard)', $this->table, $deleted, array());

        return $deleted;
    }

    public function exist($where){
        return $this->count(array_merge(
            $where,
            array(
                'deleted_at' => NULL
            )
        )) > 0;
    }

    public function count($where){
        return $this->db->where(array_merge(
            $where,
            array(
                'deleted_at' => NULL
            )
        ))->from($this->table)->count_all_results();
    }

    public function count_all(){
        return  $this->db->count_all($this->table);
    }

    /**
    * The following data is available for if $only_names is FALSE:
    * name - column name
    * max_length - maximum length of the column
    * primary_key - 1 if the column is a fieldsy key
    * type - the type of the column
    */
    public function columns($only_names = TRUE)
    {
        return ($only_names) ? $this->db->list_fields($this->table) : $this->db->field_data($this->table);
    }

    public function at_columns()
    {
        return array_filter($this->columns(), function ($column){
            return ends_with($column, '_at');
        });
    }

    public function id_columns()
    {
        return array_filter($this->columns(), function ($column){
            return ends_with($column, '_id');
        });
    }

    public function type_columns()
    {
        return array_filter($this->columns(), function ($column){
            return ends_with($column, 'type');
        });
    }

    public function numeric_columns()
    {
        return array_map(function ($column){
            return ((array) $column)['name'];
        }, array_filter($this->columns(FALSE), function ($column){
            return ((array) $column)['type'] == 'int';
        }));
    }

    public function boolean_columns()
    {
        return array_map(function ($column){
            return ((array) $column)['name'];
        }, array_filter($this->columns(FALSE), function ($column){
            return ((array) $column)['type'] == 'tinyint';
        }));
    }

    public function money_columns()
    {
        return array_filter($this->columns(), function ($column){
            return in_array($column, array(
                'amount'
            ));
        });
    }

	public function swap_columns()
	{
		return array(
			'sbc_id' => 'SBC',
            'amount' => 'amount (#)',
            'voltage' => 'voltage (V)',
            'wattage' => 'wattage (kW)',
            'longitude' => 'Long',
            'latitude' => 'Lat',
            'revision' => 'edited',
		);
    }
    
    public function types_values()
    {
        $output = array();
        foreach ($this->type_columns() as $key => $type_column) {
            $type_values = $this->db->query(
                "SELECT ".$type_column." FROM "
                .$this->table
                ." WHERE deleted_at IS NULL GROUP BY "
                .$type_column
                ." ORDER BY updated_at DESC WHERE deleted_at IS NULL"
            )->result_array();
            $output = array_merge($output, array_map(function ($v) use ($type_column) {
                return $v[$type_column];
            },$type_values));
        }
        return $output;
    }

    public function types_to_actions()
    {
        return array_map(function ($column){
            return array(
                'title' => $column, 
                'url' => '%controller%/filter/types:'.$column,
                'entity' => $this->table, 
                'ability' => 'read'
            );
        }, $this->types_values());
    }

    public function src_columns()
    {
        return array_filter($this->columns(), function ($column){
            return ends_with($column, '_src');
        });
    }    

	public function relative_columns()
	{
		return array();
    }
    
    public function family($model)
    {
        return $this->relationship->with($this->table, $model)->family();
    }

    public function read_one_with($value, $key = NULL, $operator = '=')
    {
        if(!isset($key)){
            $key = $this->primary_key;
        }

        if($operator != '='){
            $operator = ' '.$operator;
        }
        
        return $this->relationship->select(!empty($this->fields) ? $this->fields : NULL)->with($this->table)->read_one_with(array(
            $this->table.'.'.$key.$operator => $value
        ));
    }

    public function read_many_with($valueOrWhere, $key = NULL, $operator = '=')
    {
        if(!isset($key)){
            $key = $this->primary_key;
        }
        if(is_array($valueOrWhere)){
            return $this->relationship->with($this->table)->read_many_with($valueOrWhere);            
        }
        if($operator != '='){
            $operator = ' '.$operator;
        }
        return $this->relationship->with($this->table)->read_many_with(array(
            $this->table.'.'.$key.$operator => $valueOrWhere
        ));
    }

    public function paginate_with($where, $page = 1, $per_page = 12, $appends_url = 'collection'){
        
        $total = $this->count($where);
        $limit  = $per_page;
        $offset  = ($per_page) * ($page - 1);

        $this->pagination->initialize(array(
            'total_rows' => $total,
            'per_page' => $limit ,
            'base_url' => site_url().'/'.$this->table.'/'.$appends_url,
        ));
        
        return array(
            'items' => $this->read_many_with($where, $limit, $offset),
            'total' => $total,
            'links' => $this->pagination->create_links(),
        );
    }

    public function view_query($method, $parameters){
        return $this->{$method}(...$parameters);
    }
    
    public function special_count($table, $where = array()){
        return $this->db->where(array_merge(
            $where,
            array(
                'deleted_at' => NULL
            )
        ))->from($this->table)->count_all_results();
    }

    // $curr = 'AZ9999';
    // $value = 9999;
    
    public function apha_num_id($value)
    {        
        $letter1 = substr($value,0,1);
        $letter2 = substr($value,1,1);
        $num = substr($value,2,4);
        if ($num == 9999){
            if($letter2 == 'Z'){
                if($letter1 == 'Z'){
                    return 'out ot scope';
                }
                else{
                    ++$letter1;
                }
                $letter2 = 'A';
            }
            else{
                ++$letter2;
            }
            $num = 0000;
        }
        else{
            $num++;
        }
    
        $fin = $letter1.$letter2.str_pad($num, 4, '0', STR_PAD_LEFT);
    
        return $fin; 
    }
}