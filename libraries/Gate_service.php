<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Gate_service{

    private $CI;

    private $policies;
    private $static_policies;
    private $staff_policies;

    private $user; //must have policies and type keys

    private $entity;

    public function __construct($params = [])
    {
        $this->policies = $params['policies'];
        $this->static_policies = $params['static_policies'];
        $this->staff_policies = $params['staff_policies'];
        $this->CI =& get_instance();
    }

    public function check($user, $entity, $ability)
    {
        return $this->of($user)->on($entity)->can($ability)
            && $this->of($user)->on($entity)->able($ability);
    }

    public function of($user)
    {
        if(isset($user['type']) && in_array($user['type'], array_keys($this->static_policies))){
            $user['policies'] = $this->static_policies[$user['type']];
        }
        elseif(isset($user['policies'])){
            $user['policies'] = (array) json_decode($user['policies']);
        }
        else{
            $user['policies'] = array();
        }

        $this->user = $user;

        return $this;
    }

    public function on($entity)
    {
        $this->entity = $entity;

        return $this;
    }

    public function can($ability)
    {
        $ability = in_array($ability, array('sync', 'scheduler', 'batch-create')) ? 'create' : $ability;
        $ability = in_array($ability, array('collection', 'index')) ? 'read' : $ability;
        $ability = in_array($ability, array('edit')) ? 'update' : $ability;
        $ability = in_array($ability, array()) ? 'delete' : $ability;
        
        return isset($this->policies[$this->entity]) 
            && in_array($ability, $this->policies[$this->entity]);
    }

    public function able($ability)
    {
        $ability = in_array($ability, array('sync', 'scheduler', 'batch-create')) ? 'create' : $ability;
        $ability = in_array($ability, array('collection', 'index')) ? 'read' : $ability;
        $ability = in_array($ability, array('edit')) ? 'update' : $ability;
        $ability = in_array($ability, array()) ? 'delete' : $ability;

        return isset($this->user['policies'][$this->entity]) 
            && in_array($ability, $this->user['policies'][$this->entity]);
    }


    public function createable()
    {
        return $this->can('create') && $this->able('create');
    }

    public function readable()
    {
        return $this->can('read') && $this->able('read');
    }

    public function updateable()
    {
        return $this->can('update') && $this->able('update');
    }

    public function deleteable()
    {
        return $this->can('delete') && $this->able('delete');
    }

    public function only($user_types)
    {
        $types = is_array($user_types) ? $user_types : array($user_types);
        $type = $this->CI->auth->type();
        return in_array($type, $types);
    }

    public function secure($user_types = NULL)
    {
        return (isset($user_types)) ? only($user_types) : $this->CI->auth->check();
    }

    public function get_staff_policies($user_type = NULL)
    {
        return (isset($user_type)) ? $this->staff_policies[$user_type] : $this->staff_policies;
    }
}