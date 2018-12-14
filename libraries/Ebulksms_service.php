<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Ebulksms_service{
    
    protected $CI;
    protected $http;

    public const TEXT = 0;
    public const FLASH = 1;
    public const ENABLE_DELIVERY = 1; // enable delivery to MTN DND numbers at (2 units each by default)
    public const DISABLE_DELIVERY = 0; // to disable delivery to MTN DND numbers (1 unit)

    private $email, $password, $api_key, $sender;

    public function __construct($params = [])
    {
        $this->CI =& get_instance();
        $this->email = $params['email'];
        $this->password = $params['password'];
        $this->api_key = $params['api_key'];
        $this->sender = $params['sender'];
        
        $this->CI->load->library('http_service', NULL, 'http');

        $this->http = $this->CI->http->client(array(
            'base_uri' => $params['base_uri'],
            'headers' => array(
                'content-type' => 'application/json'
            ),
        ));
    }

    public function send($message, $recipients, $type = self::TEXT, $report = self::DISABLE_DELIVERY)
    {
        $request = $this->http->request(
            'POST', 
            'sendsms.json',
            array(
                'json' => array(
                    'SMS' => array(
                        'auth' => array(
                            'username' => $this->email,
                            'apikey' => $this->api_key,
                        ),
                        'message' => array(
                            'sender' => $this->sender,
                            'messagetext' => $message,
                            'flash' => $type,
                        ),
                        'recipients' => array(
                            'gsm' => $recipients,
                        ),
                        'dndsender' => $report,
                    )
                )
            )
        );
        $response = $request['response'];
        $status = $response['status'];
        $totalsent = $response['totalsent'];
        $cost = $response['cost'];
        return ($status == 'SUCCESS') ? $totalsent : $status;
    }
    
    public function report($id = NULL)
    {
        $request = $this->http->request(
            'POST', 
            'getdlr.json?username='.$this->email.'&apikey='.$this->api_key.((isset($id) ? '&uniqueid='.$id : ''))
        );
        return is_array($request) && isset($request['drl']) ? $request['drl'] : $request;
    }

    public function balance()
    {
        // $request = $this->http->request(
        //     'POST', 
        //     'getdlr.json?username='.$this->email.'&apikey='.$this->api_key.((isset($id) ? '&uniqueid='.$id : ''))
        // );
        // return is_array($request) && isset($request['drl']) ? $request['drl'] : $request;
    }

    public function api_key()
    {
        $request = $this->http->request(
            'POST', 
            'getapikey.json',
            array(
                'json' => array(
                    'auth' => array(
                        'username' => $this->email,
                        'password' => $this->password,
                    )
                )
            )
        );
        return is_array($request) && isset($request['response']['status'])  ? $request['response']['status'] : $request;
    }
}