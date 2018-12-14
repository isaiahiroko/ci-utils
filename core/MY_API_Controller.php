<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class MY_API_Controller extends REST_Controller {

    protected $controller = NULL;
    protected $method = NULL;

    protected $per_page = 12;
    
    function __construct()
    {
        parent::__construct();
        
        $this->controller = $this->uri->segment(4, NULL);
        $this->method = $this->uri->segment(3, NULL);
    }

    protected function fillable($data, $fillable = array(), $not_fillable = array(), $pre_and_post = TRUE)
    {
        return array_filter($data, function ($v, $k) use ($data, $fillable, $not_fillable) {
            return in_array($k, ((!empty($fillable)) ? $fillable : $this->{$this->controller}->fillable())) && !in_array($k, $not_fillable);
        }, ARRAY_FILTER_USE_BOTH);
    }

    public function jsonify($status, $data = NULL, $message = NULL, $code = NULL){
        return $this->response(array(
            'status' => $status, //success|fail|error
            'data' => $data,
            'message' => $message,
            'code' => $code,
        ));
    }

    public function html($html, $data = NULL, $status = 'success', $code = NULL){
        return $this->response(array(
            'status' => $status,
            'html' => $html,
            'data' => $data,
            'message' => NULL,
            'code' => $code,
        ));
    }

    // All went well, and (usually) some data was returned.
    public function success($data, $message = NULL){
        return $this->jsonify(
            'success',
            $data,
            $message,
            200
        );
    }

    // There was a problem with the data submitted, or some pre-condition of the API call wasn't satisfied
    public function fail($message, $data = NULL){
        return $this->jsonify(
            'fail',
            $data,
            $message,
            200
        );
    }

    // An error occurred in processing the request, i.e. an exception was thrown
    public function error($message = NULL, $code = NULL, $data = NULL){
        return $this->jsonify(
            'error',
            $data,
            $message,
            $code
        );
    }
}