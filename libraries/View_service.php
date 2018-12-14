<?php defined('BASEPATH') OR exit('No direct script access allowed');

class View_service{
    
    protected $CI;

    public function __construct()
    {
        $this->CI =& get_instance();
        
        $controller = str_replace('-', '_', $this->CI->uri->segment(1));
        $method = str_replace('-', '_', $this->CI->uri->segment(2));

        if(in_array($method, array('create', 'edit'))){
            $method = 'form';
        }

        $this->CI->state->set('controller', $controller);
        $this->CI->state->set('method', $method);

        $this->CI->load->model('my_model', 'model');

        $metrics = array(
            array(
                'name' => 'orders',
                'title' => 'new orders',
                'length' => '0',
                'url' => '/orders/collection',
            ),
            array(
                'name' => 'surveys',
                'title' => 'pending surveys',
                'length' => '0',
                'url' => '/orders/collection',
            ),
            array(
                'name' => 'installations',
                'title' => 'installations',
                'length' => '0',
                'url' => '/orders/collection',
            )
        );
        $session = $this->CI->session->userdata();
        
        $cis_local = $this->CI->load->database('cis_local', TRUE);

        $billing = $cis_local->order_by('billing_template_autoid', 'DESC')->limit(1)->get('billing_template')->row_array();
        $tariff_types = explode(',', $billing['billing_template_tariff']);
        $tariff_charges = explode(',', $billing['billing_template_charges']);
        $tariff_types_charges = array_combine($tariff_types, $tariff_charges);

        $this->CI->twig->addGlobal('state', array_merge( 
            is_array($session) ? $session : array(), 
            array( 
                'controller' => $controller,      
                'method' => $method,      
                'current' => $this->CI->state,
                'app' => $this->CI->app->state(),
                'flash' => $this->CI->session->flashdata(),
                'class' => array(
                    'table' => $this->CI->table,
                    'actions' => $this->CI->actions,
                    'auth' => $this->CI->auth,
                    'gate' => $this->CI->gate,
                    'inflector' => $this->CI->inflector,
                    'model' => $this->CI->model,
                    'db' => $this->CI->db,
                    'CI' => $this->CI,
                ),
                'metrics' => $metrics,
                'lec' => array_map(function ($value){
                    return array('value' => $value['lec_id'], 'title' =>  $value['name'], 'selected' => FALSE);
                }, $this->CI->model->table('lecs')->read_all()),
                'sbc' => array_map(function ($value){
                    return array('value' => $value['sbc_id'], 'title' =>  $value['name'], 'selected' => FALSE);
                }, $this->CI->model->table('sbcs')->read_all()),
                'staff' => array_map(function ($value){
                    return array('value' => $value['staff_id'], 'title' =>  $value['name'], 'selected' => FALSE);
                }, $this->CI->model->table('staffs')->read_all()),
                'qaqc' => array_map(function ($value){
                    return array('value' => $value['staff_id'], 'title' =>  $value['name'], 'selected' => FALSE);
                }, $this->CI->model->table('staffs')->read_all(array('type' => 'qaqc'))),
                'nmd' => array_map(function ($value){
                    return array('value' => $value['staff_id'], 'title' =>  $value['name'], 'selected' => FALSE);
                }, $this->CI->model->table('staffs')->read_all(array('type' => 'nmd'))),
                'cs-frontend' => array_map(function ($value){
                    return array('value' => $value['staff_id'], 'title' =>  $value['name'], 'selected' => FALSE);
                }, $this->CI->model->table('staffs')->read_all(array('type' => 'cs-frontend'))),
                'cs-backend' => array_map(function ($value){
                    return array('value' => $value['staff_id'], 'title' =>  $value['name'], 'selected' => FALSE);
                }, $this->CI->model->table('staffs')->read_all(array('type' => 'cs-backend'))),
                'cs-bu-lead' => array_map(function ($value){
                    return array('value' => $value['staff_id'], 'title' =>  $value['name'], 'selected' => FALSE);
                }, $this->CI->model->table('staffs')->read_all(array('type' => 'cs-bu-lead'))),
                'finance-bu-lead' => array_map(function ($value){
                    return array('value' => $value['staff_id'], 'title' =>  $value['name'], 'selected' => FALSE);
                }, $this->CI->model->table('staffs')->read_all(array('type' => 'finance-bu-lead'))),
                'msp' => array_map(function ($value){
                    return array('value' => $value['msp_id'], 'title' =>  $value['name'], 'selected' => FALSE);
                }, $this->CI->model->table('msps')->read_all()),
                'team' => array_map(function ($value){
                    return array('value' => $value['team_id'], 'title' =>  $value['name'], 'selected' => FALSE);
                }, $this->CI->model->table('teams')->read_all()),
                'agents' => array_map(function ($value){
                    return array('value' => $value['agent_id'], 'title' =>  $value['name'], 'selected' => FALSE);
                }, $this->CI->model->table('agents')->read_all(array())),
                'business_units' => array_map(function ($value){
                    return array('value' => $value['business_unit_id'], 'title' =>  $value['name'], 'selected' => FALSE);
                }, $this->CI->model->table('business_units')->read_all(array())),
                'undertakings' => array_map(function ($value){
                    return array('value' => $value['undertaking_id'], 'title' =>  $value['name'], 'selected' => FALSE);
                }, $this->CI->model->table('undertakings')->read_all(array())),
                'feeders' => array_map(function ($value){
                    return array('value' => $value['feeder_id'], 'title' =>  $value['name'], 'selected' => FALSE);
                }, $this->CI->model->table('feeders')->read_all(array())),
                'transformers' => array_map(function ($value){
                    return array('value' => $value['transformer_id'], 'title' =>  $value['name'], 'selected' => FALSE);
                }, $this->CI->model->table('transformers')->read_all(array())),
                'tariff_types' => array_map(function ($value){
                    return array('value' => $value, 'title' =>  $value, 'selected' => FALSE);
                }, $tariff_types),
                'notifications' => $this->CI->model->table('notifications')->read_all(array()),
            )
        ));
    }
    
    public function display($view_path, $data = array())
    {
        return $this->CI->twig->display($view_path, $data);
    }

    public function render($view_path, $data = array())
    {
        return $this->CI->twig->render($view_path, $data);
    }
}