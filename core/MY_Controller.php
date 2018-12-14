<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

use Ramsey\Uuid\Uuid;

class MY_Controller extends CI_Controller {

    protected $controller = NULL;
    protected $method = NULL;

    protected $per_page = 12;
    
    function __construct()
    {
        parent::__construct();
        $this->controller = strtolower(get_class($this));
        
        ini_set('memory_limit', '-1');
        ini_set('max_execution_time', 36000);

        //send mail
        // $this->alert->to('isaiahiroko@outlook.com', '+2348134583602', Uuid::uuid4()->toString(), 'customer')->dispatch('001');
        $this->output->set_header('Cache-Control: max-age=86400');
    }

    protected function view($path = NULL, $data = array())
    {
        if(isset($path)){
            return $this->view->display($path, array_merge(array(
                'controller' => $this->controller,
            ), $data));
        }

        list(, $method) = debug_backtrace(false);
        $this->method = $method['function'];
        return $this->view->display(strtolower($this->controller).'/'.strtolower($this->method), array_merge(array(
            'controller' => $this->controller,
        ), $data));
    }

    protected function fillable($data, $fillable = array(), $not_fillable = array(), $pre_and_post = TRUE)
    {
        return array_filter($data, function ($v, $k) use ($data, $fillable, $not_fillable) {
            return in_array($k, ((!empty($fillable)) ? $fillable : $this->{$this->controller}->fillable())) && !in_array($k, $not_fillable);
        }, ARRAY_FILTER_USE_BOTH);
    }
   
	public function table()
	{        
        return $this->view->display('layouts/web/primary/collection', array(
            'table' => array(
                'cards' => array(),
                'tabs' => $this->{$this->controller}->datatable()['tabs'],
                'actions' => array(),
                'columns' => array(),
                'rows' => array(),
            ),
            'model' => $this->{$this->controller},
        ));
    }
 
    public function create($pre_callback = NULL, $post_callback = NULL)
    {
        if(
            $this->input->method() == 'post'
			// && !($this->form_validation->run($this->controller) == FALSE)
        ){
            // dd([$this->input->post(), json_encode($this->input->post()), json_decode(json_encode($this->input->post()))]);
            
            $data = array();
                
            $data = array_merge(
                $data, 
                $this->input->post(),
                array('status' => 'new')
            );

            // create password if required
            if(NULL !== $this->input->post('password')){
                $data = array_merge(
                    $data,
                    array('password' => password_hash($this->input->post('password'), PASSWORD_DEFAULT))
                );
            }

            $parents = array_filter($this->{$this->controller}->parent(), function($v){
                return !in_array($v, array('business_units', 'undertakings', 'feeders', 'transformers', 'msps', 'sbcs', 'teams', 'agents'));
            });

            foreach ($parents as $parent) {    
                $this->load->model($parent.'_model', $parent);
                $parent_item = $this->{$parent}->create($this->fillable(
                    array_merge(
                        $this->{$parent}->pre_create($data)
                    ),
                    $this->{$parent}->fillable()
                ));

                $data = array_merge($data, $parent_item);

            }

            $main_item = $this->{$this->controller}->create($this->fillable(
                array_merge(
                    $this->{$this->controller}->pre_create($data)
                ),
                $this->{$this->controller}->fillable()
            ));

            $data = array_merge($data, $main_item);

            $childs = $this->{$this->controller}->child();
            $child_ids = array();
            foreach ($childs as $child) {
                $this->load->model($child.'_model', $child);
                $child_item = $this->{$child}->create($this->fillable(
                    array_merge(
                        $this->{$child}->pre_create($data)
                    ),
                    $this->{$child}->fillable()
                ));

                $data = array_merge($data, $child_item);

            }

            $this->notif->set_flash(array(
                'notice' => array(
                    'message' => ucwords($this->inflector->singularize($this->controller)).' saved succesfully.',
                    'type' => 'success'
                )
            ));
            
            return redirect($this->auth->prev_url());
			
        }
    }
	
    public function edit($id)
    {
        if(
            $this->input->method() == 'post'
			// && !($this->form_validation->run($this->controller) == FALSE)
        ){
            
            $data = $this->input->post();

            $parents = array_filter($this->{$this->controller}->parent(), function($v){
                return !in_array($v, array('business_units', 'undertakings', 'feeders', 'transformers', 'msps', 'sbcs', 'teams', 'agents'));
            });

            $main = $this->{$this->controller}->read_one(array(
                $this->{$this->controller}->primary_key() => $id
            ));
            
            // update password if required
            $password_changed = array();
            if(NULL !== $this->input->post('update-password') && NULL !== $this->input->post('password')){
                $password_changed = array('password' => password_hash($this->input->post('password'), PASSWORD_DEFAULT));
            }

            $data = array_merge(
                $data,
                $password_changed
            );

            foreach ($parents as $parent) {  
                $this->load->model($parent.'_model', $parent);
                $parent_item = $this->{$parent}->update(array(
                    $this->{$parent}->primary_key() => $main[$this->{$parent}->primary_key()]
                ), $this->fillable(
                    $data,
                    $this->{$parent}->fillable()
                ));

                $data = array_merge($data, $parent_item);

            }

            $data = array_merge($data, $main, $this->input->post(), $password_changed);

            $main_item = $this->{$this->controller}->update(array(
                $this->{$this->controller}->primary_key() => $id
            ), $this->fillable(
                $data,
                $this->{$this->controller}->fillable()
            ));

            $data = array_merge($data, $main_item, $password_changed);

            $childs = $this->{$this->controller}->child();
            $child_ids = array();
            foreach ($childs as $child) {
                $this->load->model($child.'_model', $child);
                $child_item = $this->{$child}->update(array(
                    $this->{$this->controller}->primary_key() => $id
                ), $this->fillable(
                    $data,
                    $this->{$child}->fillable()
                ));

                $data = array_merge($data, $child_item);

            }
            
            $this->notif->set_flash(array(
                'notice' => array(
                    'message' => ucwords($this->inflector->singularize($this->controller)).' updated succesfully.'.((!empty($password_changed)) ? ' Password was updated.' : ''),
                    'type' => 'success'
                )
            ));

            return redirect($this->auth->prev_url());
			
        }
    }
	
    public function batch_create()
    {
        if($this->input->method() == 'post'){
            
            $columns = array();
            
            try{
                $path = APPPATH.'..'.DIRECTORY_SEPARATOR.'public'.DIRECTORY_SEPARATOR.'uploads'.DIRECTORY_SEPARATOR;
                $ss = $this->spreadsheet->open($path, $this->input->post('batch_file_src'));
                $columns = $ss->columns();
            }
            catch(Exception $e){
                $this->notif->set_flash(array(
                    'notice' => array(
                        'message' => 'There is an issue with the file you uploaded. Ensure it is an excel file.',
                        'type' => 'danger'
                    )
                ));

                return redirect($this->auth->prev_url());
            }

            //check for columns
            $columns_err = array();
            foreach ($columns as $column) {
                if(!in_array($column, $this->{$this->controller}->import_user_columns())){
                    $columns_err[] = $column;
                }
            }
            if(!empty($columns_err)){
                
                $this->notif->set_flash(array(
                    'notice' => array(
                        'message' => 'The file you provided is not well formated. Double check the following column names: '.implode(', ', $columns_err).'.',
                        'type' => 'danger'
                    )
                ));

                return redirect($this->auth->prev_url());
            }
            
            //save to db
            $succeed = array();
            $fail = array();
            $duplicate = 0;
            $batch_id = NULL !== $this->input->get('batch_id') ? $this->input->get('batch_id') : random_string('alnum', 5);

            $data = $this->input->post();
            $rows = $ss->rows(function ($row) use ($columns, &$succeed, &$fail, $batch_id) {
                
                $data = array();
                
                // $data = array_merge($data, $this->input->post());

                //update data with columns id values
                foreach($row as $key => $value){
                    foreach ($this->{$this->controller}->import_edit_columns() as $to_edit_key => $to_edit) {
                        if(is_array($to_edit) && !empty($to_edit) && $columns[$key] == $to_edit_key){
                            $this->load->model($to_edit[0].'_model', $to_edit[0]);
                            ${$to_edit[0]} = $this->{$to_edit[0]}->read_one(array(
                                $to_edit[1].' LIKE' => '%'.$value.'%'
                            ));
                            $data[$to_edit[2]] = ${$to_edit[0]}[$to_edit[2]];
                        }
                        else{
                            $data[$columns[$key]] = $value;
                        }
                    }
                }

                //start with batch upload form post data
                $data = array_merge(
                    $data, 
                    $this->input->post(),
                    array('status' => 'new')
                );

                try{
                    //check for uniqueness
                    //save to db if unique
                    foreach ($this->{$this->controller}->save_primary_columns() as $column => $value) {
                        if($value && $this->{$this->controller}->exist(array(
                            $column => $data[$column]
                        ))){
                            throw new Exception("duplicate entry");
                        }
                    }

                    $parents = array_filter($this->{$this->controller}->parent(), function($v){
                        return !in_array($v, array('business_units', 'undertakings', 'feeders', 'transformers', 'msps', 'sbcs', 'teams', 'agents'));
                    });

                    foreach ($parents as $parent) {    
                        $this->load->model($parent.'_model', $parent);
                        $parent_item = $this->{$parent}->create($this->fillable(
                            array_merge(
                                $this->{$parent}->pre_create($data)
                            ),
                            $this->{$parent}->fillable()
                        ));

                        $data = array_merge($data, $parent_item);

                    }


                    $main_item = $this->{$this->controller}->create($this->fillable(
                        array_merge(
                            $this->{$this->controller}->pre_create($data)
                        ),
                        $this->{$this->controller}->fillable()
                    ));

                    $data = array_merge($data, $main_item);

                    $childs = $this->{$this->controller}->child();
                    foreach ($childs as $child) {
                        $this->load->model($child.'_model', $child);
                        $child_item = $this->{$child}->create($this->fillable(
                            array_merge(
                                $this->{$child}->pre_create($data)
                            ),
                            $this->{$child}->fillable()
                        ));

                        $data = array_merge($data, $child_item);
                    
                    }

                    $succeed[] = $data;
                }
                catch(Exception $e){
                    $fail[] = $data;
                }
            });
            
            $message = "Batch upload process completed. ";
            $message = (count($succeed) > 0) ? $message.count($succeed).' '.$this->controller.'  saved succesfully. ' : $message.' ';
            $message = (count($fail) > 0) ? $message.count($fail).' '.$this->controller.' could not be saved (duplicate account number).' : $message.' ';
            $this->notif->set_flash(array(
                'notice' => array(
                    'message' => $message,
                    'type' => 'success'
                )
            ));
            
            return redirect($this->auth->prev_url());
        }
    }

    public function delete($id)
    {
        if($this->input->method() == 'post'){

			$item = $this->{$this->controller}->soft_delete_in(array(
                $this->{$this->controller}->primary_key() => $id
            ));    

            $this->notif->set_flash(array(
                'notice' => array(
                    'message' => $this->inflector->singularize(prettify($this->controller)).' item deleted succesfully.',
                    'type' => 'success'
                )
            ));

            redirect($this->auth->prev_url());
			
        }
    }

    public function batch_export()
    {
        if($this->input->method() == 'post'){
            $export_ids = json_decode($this->input->post('ids'));
            $action = $this->input->post('action');
            $entity = $this->input->post('entity');
            $type = $this->input->post('type');
            $where_in = array();
            foreach ($export_ids as $ids) {
                foreach ($ids as $id) {
                    $where_in[] = $id;
                }
            }
            
            $where_in = (empty($where_in)) ? array('nothing') : $where_in;

            $columns = array_merge(
                array('work_order_id', 'account_number', 'customer_name', 'address_description', 
                    'purpose', 'type_of_residence', 'order_quantity', 'approved_meter_type',
                    'business_unit_name', 'undertaking_name', 'feeder_name', 'transformer_name'),
                $this->{$this->controller}->export_user_columns()
            );
            $rows = $this->table->name('customer_orders')
                ->add_select($columns)
                // ->add_where($where)
                ->add_where_in(array(
                    'order_id' => $where_in
                ))
                // ->add_columns_to_edit($columns_to_edit)
                // ->add_columns_to_add($columns_to_add)
                // ->add_joins($joins)
                // ->add_user_filter()
                // ->add_date_range_filters($from, $to)
                // ->add_location_filters($locations)
                ->raw_rows();
                
            $path = APPPATH.'..'.DIRECTORY_SEPARATOR.'public'.DIRECTORY_SEPARATOR.'uploads'.DIRECTORY_SEPARATOR;
            $ss = $this->spreadsheet->open($path, random_string().'.xlsx', TRUE, FALSE);
            $ss->close(array_merge(
                $columns, 
                $this->{$this->controller}->export_user_columns()
            ), $rows);
        }
    }

    public function batch_import()
    {
        if($this->input->method() == 'post'){
            
            $columns = array();
            
            try{
                $path = APPPATH.'..'.DIRECTORY_SEPARATOR.'public'.DIRECTORY_SEPARATOR.'uploads'.DIRECTORY_SEPARATOR;
                $ss = $this->spreadsheet->open($path, $this->input->post('batch_file_src'));
                $columns = $ss->columns();
            }
            catch(Exception $e){
                $this->notif->set_flash(array(
                    'notice' => array(
                        'message' => 'There is an issue with the file you uploaded. Ensure it is an excel file.',
                        'type' => 'danger'
                    )
                ));

                return redirect($this->auth->prev_url());
            }

            //check for columns
            $columns_err = array();
            foreach ($columns as $column) {
                if(!in_array($column, array_merge(
                    array('work_order_id', 'account_number', 'customer_name', 'address_description', 
                        'purpose', 'type_of_residence', 'order_quantity', 'approved_meter_type',
                        'business_unit_name', 'undertaking_name', 'feeder_name', 'transformer_name'),
                    $this->{$this->controller}->export_user_columns()
                ))){
                    $columns_err[] = $column;
                }
            }
            if(!empty($columns_err)){
                
                $this->notif->set_flash(array(
                    'notice' => array(
                        'message' => 'The file you provided is not well formated. Double check the following column names: '.implode(', ', $columns_err).'.',
                        'type' => 'danger'
                    )
                ));

                return redirect($this->auth->prev_url());
            }
            
            //save to db
            $succeed = array();
            $fail = array();
            $duplicate = 0;

            $rows = $ss->rows(function ($row) use ($columns, &$succeed, &$fail) {
                try{

                    $data = array();

                    foreach ($row as $key => $value) {
                        $data[$columns[$key]] = $value;
                    }

                    //update data with columns id values
                    foreach($row as $key => $value){
                        foreach ($this->{$this->controller}->export_edit_columns() as $to_edit_key => $to_edit) {
                            if(is_array($to_edit) && !empty($to_edit) && $columns[$key] == $to_edit_key){
                                $this->load->model($to_edit[0].'_model', $to_edit[0]);
                                ${$to_edit[0]} = $this->{$to_edit[0]}->read_one(array(
                                    $to_edit[1].' LIKE' => '%'.$value.'%'
                                ));
                                $data[$to_edit[2]] = ${$to_edit[0]}[$to_edit[2]];
                            }
                            else{
                                $data[$columns[$key]] = $value;
                            }
                        }
                    }
                    //get order id
                    $this->load->model('orders_model', 'orders');
                    $order = $this->orders->read_one(array(
                        'work_order_id' => $data['work_order_id']
                    ));

                    if(isset($order)){
                        $order_id = $order['order_id'];
                        if($this->controller == 'invoices'){
                            $this->{$this->controller}->update(array(
                                'order_id' => $order_id
                            ), $this->fillable(
                                array_merge(
                                    $data,
                                    array(
                                        'status' => 'confirmed'
                                    )
                                ),
                                $this->{$this->controller}->fillable()
                            ));
        
                            $this->orders->update(array(
                                'order_id' => $order_id
                            ), $this->fillable(
                                array_merge(
                                    array(
                                        'status' => 'payment/confirmed'
                                    )
                                ),
                                $this->orders->fillable()
                            ));
                        }
                        if($this->controller == 'installations'){
                            $x = $this->{$this->controller}->update(array(
                                'order_id' => $order_id
                            ), $this->fillable(
                                array_merge(
                                    $data,
                                    array(
                                        'status' => 'pending'
                                    )
                                ),
                                $this->{$this->controller}->fillable()
                            ));
        
                            $y = $this->orders->update(array(
                                'order_id' => $order_id
                            ), $this->fillable(
                                array_merge(
                                    array(
                                        'status' => 'assigned/installation'
                                    )
                                ),
                                $this->orders->fillable()
                            ));
                        }
                        
                        if($this->controller == 'meters'){
                            $x = $this->{$this->controller}->update(array(
                                'order_id' => $order_id
                            ), $this->fillable(
                                $data,
                                $this->{$this->controller}->fillable()
                            ));
                            
                            $y = $this->orders->update(array(
                                'order_id' => $order_id
                            ), $this->fillable(
                                $data,
                                $this->orders->fillable()
                            ));
                        }

                        $succeed[] = $data;
                    }
                    else{
                        throw new Exception("'work_order_id' not found.");
                    }

                }
                catch(Exception $e){
                    $fail[] = $data;
                }
            });
        
            $message = "Batch upload process completed. ";
            $message = (count($succeed) > 0) ? $message.count($succeed).' '.$this->controller.' updated succesfully. ' : "";
            $message = (count($fail) > 0) ? $message.count($fail).' '.$this->controller.' could not be updated (work order ID not found).' : "";
            $this->notif->set_flash(array(
                'notice' => array(
                    'message' => $message,
                    'type' => 'success'
                )
            ));
            
            return redirect($this->auth->prev_url());
        }
    }

	public function schedule()
	{
		$this->model->table('installations')->upsert(array(
			'order_id' => $this->input->post('order_id')
		), array(
			'sbc_id' => $this->input->post('sbc_id'),
			'order_id' => $this->input->post('order_id'),
			'status' => 'inactive',
		));
		
		$this->notif->set_flash(array(
			'notice' => array(
				'message' => 'Order sechdule for installation successfully.',
                'type' => 'success'
			)
		));
		
		return redirect($this->auth->prev_url());
	}
	
	public function submit_report()
	{
		$this->model->table('installations')->update(array(
			'order_id' => $this->input->post('order_id')
		), $this->fillable($this->input->post(), array(), array(
			'sbc_id',
			'lec_id',
			'agent_id',
			'team_id',
			'staff_id',
		)));
		
		$this->notif->set_flash(array(
			'notice' => array(
				'message' => 'Installation report was successfully.',
                'type' => 'success'
			)
		));
		
		return redirect($this->auth->prev_url());
	}
	
	public function review()
	{
		$this->model->table('installations')->update(array(
			'order_id' => $this->input->post('order_id')
		), array(
			'feedback' => $this->input->post('feedback'),
			'status' => NULL !== $this->input->post('approve-installation') 
				&& $this->input->post('approve-installation') == 'approve-installation' 
				? 'active' : 'inactive',
			'revision' => TRUE,
			'staff_id' => $this->auth->id(),
		));
		
		$this->notif->set_flash(array(
			'notice' => array(
				'message' => 'Installation review submitted successfully.',
                'type' => 'success'
			)
		));
		
		return redirect($this->auth->prev_url());
	}
}