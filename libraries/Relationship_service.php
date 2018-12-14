<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Relationship_service{
    
    public $CI;
    
    public $model_name;
    public $model;
    public $model_id;

    public $map;

    public $fields;

    public function __construct($params = [])
    {
        $this->CI =& get_instance();
        $this->map = $params['map'];
    }

    public function with($model_name, $model = NULL)
    {
        $primary_key = $this->CI->inflector->singularize($this->model_name).'_id';
        $this->model_name = $model_name;
        $this->model = $model;
        $this->model_id = isset($model[$primary_key]) ? $model[$primary_key] : NULL;

        return $this;
    }

    public function has()
    {
        return array_merge(
            $this->has_one(),
            $this->has_many()
        );
    }

    public function belongs_to()
    {
        return array_merge(
            $this->belongs_to_one(),
            $this->belongs_to_many()
        );
    }

    public function has_one()
    {
        return $this->map[$this->model_name]['has']['one'];
    }

    public function has_many()
    {
        return $this->map[$this->model_name]['has']['many'];
    }

    public function belongs_to_one()
    {
        return $this->map[$this->model_name]['belongs_to']['one'];
    }

    public function belongs_to_many()
    {
        return $this->map[$this->model_name]['belongs_to']['many'];
    }

    
    public function select($fields = NULL)
    {
        $this->fields = $fields;
        return clone $this;
    }

    public function parent($parent_name = NULL)
    {
        $output = [];

        if(isset($parent_name)){
            $output[$parent_name] = $this->CI->db->where(array(
                $this->CI->inflector->singularize($parent_name).'_id' 
                    => $this->model[$this->CI->inflector->singularize($parent_name).'_id']
            ))->get($parent_name)->row_array();
        }
        else{
            foreach ($this->belongs_to_one() as $parent_name) {
                $output[$parent_name] = $this->CI->db->where(array(
                    $this->CI->inflector->singularize($parent_name).'_id' 
                        => $this->model[$this->CI->inflector->singularize($parent_name).'_id']
                ))->get($parent_name)->row_array();
            }
        }

        return $output;
    }

    public function parents($parents_name = NULL)
    {
        $output = [];

        if(isset($parents_name)){
            $output[$parents_name] = $this->CI->db->where(array(
                $this->CI->inflector->singularize($parents_name).'_id' 
                    => $this->model[$this->CI->inflector->singularize($parents_name).'_id']
            ))->get($parents_name)->result_array();
        }
        else{
            foreach ($this->belongs_to_many() as $parents_name) {
                $output[$parents_name] = $this->CI->db->where(array(
                    $this->CI->inflector->singularize($parents_name).'_id' 
                        => $this->model[$this->CI->inflector->singularize($parents_name).'_id']
                ))->get($parents_name)->result_array();
            }
        }

        return $output;
    }
    
    public function child($child_name = NULL)
    {
        $output = [];

        if(isset($child_name)){
            $output[$child_name] = $this->CI->db->where(array(
                $this->CI->inflector->singularize($this->model_name).'_id' 
                    => $this->model[$this->CI->inflector->singularize($this->model_name).'_id']
            ))->get($child_name)->row_array();
        }
        else{
            foreach ($this->has_one() as $child_name) {
                $output[$child_name] = $this->CI->db->where(array(
                    $this->CI->inflector->singularize($this->model_name).'_id' 
                        => $this->model[$this->CI->inflector->singularize($this->model_name).'_id']
                ))->get($child_name)->row_array();
            }
        }

        return $output;
    }

    public function children($children_name = NULL)
    {
        $output = [];

        if(isset($children_name)){
            $output[$children_name] = $this->CI->db->where(array(
                $this->CI->inflector->singularize($this->model_name).'_id' 
                    => $this->model[$this->CI->inflector->singularize($this->model_name).'_id']
            ))->get($children_name)->result_array();
        }
        else{
            foreach ($this->has_many() as $children_name) {
                $output[$children_name] = $this->CI->db->where(array(
                    $this->CI->inflector->singularize($this->model_name).'_id' 
                        => $this->model[$this->CI->inflector->singularize($this->model_name).'_id']
                ))->get($children_name)->result_array();
            }
        }

        return $output;
    }

    public function family($merge = FALSE)
    {
        return ($merge) ? array_merge(
            $this->child(),
            $this->children(),
            $this->parent(),
            $this->parents()
        ) : array(
            'child' => $this->child(),
            'children' => $this->children(),
            'parent' => $this->parent(),
            'parents' => $this->parents()
        );
    }

    
    /**
     * auto join
     */
    public function read_one_with($where, $child = NULL, $children = NULL, $parent = NULL, $parents = NULL){

        $child = (isset($child)) ? $child : $this->has_one();
        $children = (isset($children)) ? $children : $this->has_many();
        $parent = (isset($parent)) ? $parent : $this->belongs_to_one();
        $parents = (isset($parents)) ? $parents : $this->belongs_to_many();
        
        $all = array_merge(
            $child,
            // $children,
            $parent
            // $parents
        );

        // $fields = (!empty($all)) ? implode('.*, ', $all).'.*, '.$this->model_name.'.*' : $this->model_name.'.*';
        $fields = array();
        foreach ($all as $key => $sub_table) {
            $this->CI->load->model($sub_table.'_model', $sub_table);
            foreach ($this->CI->{$sub_table}->fillable() as $key => $sub_column) {
                $fields[] = $sub_table.'.'.$sub_column.' as '.$this->CI->inflector->singularize($sub_table).'_'.$sub_column;
            }
        }
        $fields = (!empty($fields)) ? implode(', ', $fields).', '.$this->model_name.'.*' : $this->model_name.'.*';
        
        $query = $this->CI->db->where(array_merge(
            $where,
            array(
                $this->model_name.'.deleted_at' => NULL
            )
        ))->select((isset($this->fields)) ? $this->fields : $fields)->from($this->model_name);

        foreach ($child as $key => $table) {
            $query->join(
                $table, 
                $this->model_name.'.'.$this->CI->inflector->singularize($this->model_name).'_id 
                    = '.$table.'.'.$this->CI->inflector->singularize($this->model_name).'_id', 
                'left'
            );
        }

        foreach ($parent as $key => $table) {
            $query->join(
                $table, 
                $this->model_name.'.'.$this->CI->inflector->singularize($table).'_id 
                    = '.$table.'.'.$this->CI->inflector->singularize($table).'_id',
                'left'
            );
        }

        $after = $query->get()->row_array();

        $this->CI->activities->stamp('read one (join)', $this->model_name, array(), $after);

        return $after;
    }

    public function read_many_with($where, $limit = 12, $offset = 0, $orderBy = 'created_at', $direction = 'DESC', $child = NULL, $children = NULL, $parent = NULL, $parents = NULL){
     
        $child = (isset($child)) ? $child : $this->has_one();
        $children = (isset($children)) ? $children : $this->has_many();
        $parent = (isset($parent)) ? $parent : $this->belongs_to_one();
        $parents = (isset($parents)) ? $parents : $this->belongs_to_many();

        $all = array_merge(
            $child,
            // $children,
            $parent
            // $parents
        );

        $fields = (!empty($all)) ? implode('.*, ', $all).'.*, '.$this->model_name.'.*' : $this->model_name.'.*';
        
        $query = $this->CI->db->where(array_merge(
            $where,
            array(
                $this->model_name.'.deleted_at' => NULL
            )
        ))->select($fields)->from($this->model_name);

        foreach ($child as $key => $table) {
            $query->join(
                $table, 
                $this->model_name.'.'.$this->CI->inflector->singularize($this->model_name).'_id 
                    = '.$table.'.'.$this->CI->inflector->singularize($this->model_name).'_id', 
                'left'
            );
        }
        foreach ($parent as $key => $table) {
            $query->join(
                $table, 
                $this->model_name.'.'.$this->CI->inflector->singularize($table).'_id 
                    = '.$table.'.'.$this->CI->inflector->singularize($table).'_id', 
                'left'
            );
        }
        
        $after = $query->order_by($this->model_name.'.'.$orderBy, $direction)->limit($limit, $offset)->get()->result_array();

        $this->CI->activities->stamp('read many (join)', $this->model_name, array(), array());

        return $after;
    }

    public function read_all_with($where, $child = NULL, $children = NULL, $parent = NULL, $parents = NULL){
     
        $child = (isset($child)) ? $child : $this->has_one();
        $children = (isset($children)) ? $children : $this->has_many();
        $parent = (isset($parent)) ? $parent : $this->belongs_to_one();
        $parents = (isset($parents)) ? $parents : $this->belongs_to_many();

        $all = array_merge(
            $child,
            // $children,
            $parent
            // $parents
        );

        $fields = (!empty($all)) ? implode('.*, ', $all).'.*, '.$this->model_name.'.*' : $this->model_name.'.*';

        $query = $this->CI->db->where(array_merge(
            $where,
            array(
                $this->model_name.'.deleted_at' => NULL
            )
        ))->select($fields)->from($this->model_name);

        foreach ($child as $key => $table) {
            $query->join(
                $table, 
                $this->model_name.'.'.$this->CI->inflector->singularize($this->model_name).'_id 
                    = '.$table.'.'.$this->CI->inflector->singularize($this->model_name).'_id', 
                'left'
            );
        }
        foreach ($parent as $key => $table) {
            $query->join(
                $table, 
                $this->model_name.'.'.$this->CI->inflector->singularize($table).'_id 
                    = '.$table.'.'.$this->CI->inflector->singularize($table).'_id', 
                'left'
            );
        }

        $after = $query->get()->result_array();

        $this->CI->activities->stamp('read many (join)', $this->model_name, array(), array());

        return $after;
    }
}