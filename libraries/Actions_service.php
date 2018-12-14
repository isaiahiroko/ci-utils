<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Actions_service{

    private $CI;

    private $entity;
    private $primary;
    private $secondary;
    private $tertiary;
    private $auxiliary;
    private $toolbar;
    private $cards;

    public function __construct($params = [])
    {
        $this->entity = $params['entity'];
        $this->primary = $params['primary'];
        $this->secondary = $params['secondary'];
        $this->tertiary = $params['tertiary'];
        $this->auxiliary = $params['auxiliary'];
        $this->toolbar = $params['toolbar'];
        $this->cards = $params['cards'];
        
        $this->CI =& get_instance();
    }

    public function entity($group)
    {
        return $this->entity[$group];
    }
    
    public function collection()
    {
        $actions = array();
        if($this->CI->gate->of($this->CI->auth->user())->on($this->CI->state->get('controller'))->createable()){
            $actions[] = $this->entity('create');
            $actions[] = $this->entity('batch-create');
        }
        return $actions;
    }

    public function form()
    {
        $actions = array();
        if($this->CI->gate->of($this->CI->auth->user())->on($this->CI->state->get('controller'))->readable()){
            $actions[] = $this->entity('back');
        }
        return $actions;
    }

    public function solo()
    {
        $actions = array();
        if($this->CI->gate->of($this->CI->auth->user())->on($this->CI->state->get('controller'))->readable()){
            $actions[] = $this->entity('back');
        }
        if($this->CI->gate->of($this->CI->auth->user())->on($this->CI->state->get('controller'))->updateable()){
            $actions[] = $this->entity('edit');
        }
        if($this->CI->gate->of($this->CI->auth->user())->on($this->CI->state->get('controller'))->deleteable()){
            $actions[] = $this->entity('delete');
        }
        return $actions;
    }

    public function collection_solo()
    {
        $actions = array();
        if($this->CI->gate->of($this->CI->auth->user())->on($this->CI->state->get('controller'))->readable()){
            $actions[] = $this->entity('view');
        }
        if($this->CI->gate->of($this->CI->auth->user())->on($this->CI->state->get('controller'))->updateable()){
            $actions[] = $this->entity('edit');
        }
        if($this->CI->gate->of($this->CI->auth->user())->on($this->CI->state->get('controller'))->deleteable()){
            $actions[] = $this->entity('delete');
        }
        return $actions;
    }

    protected function process_actions($actions_to_process)
    {
        $actions = array();

        foreach ($actions_to_process as $action) {
            if(isset($action['entity']) && isset($action['ability'])){
                if(
                    ($action['entity'] == '*' OR $action['ability'] == '*') 
                    OR (
                        $this->CI->gate->of($this->CI->auth->user())->on($action['entity'])->can($action['ability'])
                        && $this->CI->gate->of($this->CI->auth->user())->on($action['entity'])->able($action['ability'])
                    )
                ){
                    if(isset($action['sub'])){
                        $action['sub'] = $this->process_actions($action['sub']);
                    }

                    $actions[] = $action;
                }

            }
        }

        return $actions;
    }

    public function primary($controller = NULL)
    {
        $controller = (isset($controller)) ? $controller : $this->CI->state->get('controller');
        return (isset($this->primary[$controller]))
            ? $this->process_actions($this->primary[$controller])
            : array();
    }

    public function secondary($controller = NULL)
    {
        $controller = (isset($controller)) ? $controller : $this->CI->state->get('controller');
        return (isset($this->secondary[$controller]))
            ? $this->process_actions($this->secondary[$controller])
            : array();
    }

    public function tertiary($controller = NULL)
    {
        $controller = (isset($controller)) ? $controller : $this->CI->state->get('controller');
        return (isset($this->tertiary[$controller]))
            ? $this->process_actions($this->tertiary[$controller])
            : array();
    }

    public function auxiliary($controller = NULL)
    {
        $controller = (isset($controller)) ? $controller : $this->CI->state->get('controller');
        return (isset($this->auxiliary[$controller]))
            ? $this->process_actions($this->auxiliary[$controller])
            : array();
    }

    public function toolbar($controller = NULL)
    {
        $controller = (isset($controller)) ? $controller : $this->CI->state->get('controller');
        return (isset($this->toolbar[$controller]))
            ? $this->process_actions($this->toolbar[$controller])
            : array();
    }

    public function cards($type = NULL)
    {
        $type = (isset($type)) ? $type : 'default';
        return (isset($this->cards[$type]))
            ? $this->process_actions($this->cards[$type])
            : array();
        
    }

    public function check($actions)
    {
        return $this->process_actions($actions);
    }

    public function actions($merge = FALSE)
    {
        return ($merge) ? array_merge(
            $this->collection(),
            $this->collection_solo(),
            $this->form(),
            $this->solo()
        ) : array(
            'collection' => $this->collection(),
            'collection_solo' => $this->collection_solo(),
            'form' => $this->form(),
            'solo' => $this->solo(),
        );
    }

    public function menu($merge = FALSE)
    {
        return ($merge) ? array_merge(
            $this->primary(),
            $this->secondary(),
            $this->tertiary(),
            $this->auxiliary(),
            $this->toolbar()
        ) : array(
            'primary' => $this->primary(),
            'secondary' => $this->secondary(),
            'tertiary' => $this->tertiary(),
            'auxiliary' => $this->auxiliary(),
            'toolbar' => $this->toolbar(),
        );
    }

    public function state($merge = FALSE)
    {
        return array_merge(
            $this->actions($merge),
            $this->menu($merge)
        );
    }
}