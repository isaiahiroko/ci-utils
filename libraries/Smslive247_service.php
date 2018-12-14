<?php defined('BASEPATH') OR exit('No direct script access allowed');

use GuzzleHttp\Client;
use Psr\Http\Message\ResponseInterface;
use GuzzleHttp\Exception\RequestException;

class Smslive247_service{
    
    protected $CI;
    protected $http;

    public const TEXT = 0;
    public const FLASH = 1;

    private $email, $subaccount, $password;

    public function __construct($params = [])
    {
        $this->CI =& get_instance();
        $this->email = $params['email'];
        $this->subaccount = $params['subaccount'];
        $this->password = $params['password'];
        
        $this->CI->load->library('http_service', NULL, 'http');

        $this->http = $this->CI->http->client(array(
            'base_uri' => $params['base_uri'],
            'headers' => array(
                'content-type' => 'application/json'
            ),
        ));
    }

    // http://www.smslive247.com/http/index.aspx?cmd=login&owneremail=me@demo.com&subacct=family&subacctpwd=secret
    // OK: [SESSIONID] -or- ERR: [ERROR NUMBER]: [ERROR DESCRIPTION]
    public function login($email, $subaccount, $password)
    {
        return $this->http->request('GET', 'index.aspx?cmd=login&owneremail='.$email.'&subacct='.$subaccount.'&subacctpwd='.$params);
    }

    // http://www.smslive247.com/http/index.aspx?cmd=sendmsg&sessionid=e74dee1bbed22ee3a39f9aeab606ccf9&message=my+first+message&sender=ME&sendto=080202222222&msgtype=0
    // http://www.smslive247.com/http/index.aspx?cmd=sendmsg&sessionid=e74dee1bbed22ee3a39f9aeab606ccf9&message=my+first+message&sender=ME&sendto=http://yourserver.com/bulk/myfriends.text&msgtype=0
    // http://www.smslive247.com/http/index.aspx?cmd=sendmsg&sessionid=e74dee1bbed22ee3a39f9aeab606ccf9&message=my+first+message&sender=ME&sendto=080202222222&msgtype=1
    // OK: [MESSAGEID] -or- ERR: [ERROR NUMBER]: [ERROR DESCRIPTION]
    public function send($message, $send_to, $sender, $message_type)
    {
        $session_id = $this->login($this->email, $this->subaccount, $this->password);
        return $this->http->request('GET', 'index.aspx?cmd=sendmsg&sessionid='.$session_id.'&message='.$message.'&sender='.$send_to.'&sendto='.$sender.'&msgtype='.$message_type.'');
    }

    // http://www.smslive247.com/http/index.aspx?cmd=sendquickmsg&owneremail=you@demo.com&subacct=family&subacctpwd=secret&message=my+first+message&sender=ME&sendto=08057071234&msgtype=0
    // OK: [MESSAGEID] -or- ERR: [ERROR NUMBER]: [ERROR DESCRIPTION]
    public function quick($email, $subaccount, $password, $session_id, $message, $send_to, $sender, $message_type)
    {
        return $this->http->request('GET', 'index.aspx?cmd=sendquickmsg&owneremail='.$email.'&subacct='.$subaccount.'&subacctpwd='.$password.'&message='.$session_id.'&sender='.$message.'&sendto='.$send_to.'&msgtype='.$message_type);
    }

    // http://www.smslive247.com/http/index.aspx?cmd=querybalance&sessionid=xxx
    // OK: [CREDIT BALANCE] -or- ERR: [ERROR NUMBER]: [ERROR DESCRIPTION]
    public function balance($session_id)
    {
        return $this->http->request('GET', 'index.aspx?cmd=querybalance&sessionid='.$session_id);
    }

    // http://www.smslive247.com/http/index.aspx?cmd=querymsgstatus&sessionid=e74dee1bbed22ee3a39f9aeab606ccf9
    // OK: [CHARGE] -or- ERR: [ERROR NUMBER]: [ERROR DESCRIPTION]
    public function charge($session_id, $message_id)
    {
        return $this->http->request('GET', 'index.aspx?cmd=querymsgcharge&sessionid='.$session_id.'&messageid='.$message_id);
    }

    // http://www.smslive247.com/http/index.aspx?cmd=querymsgstaus&sessionid=xxx &messageid=xxx
    // OK: [MESSAGE STATUS] -or- ERR: [ERROR NUMBER]: [ERROR DESCRIPTION]
    public function status($session_id)
    {
        return $this->http->request('GET', 'index.aspx?cmd=querymsgstatus&sessionid='.$session_id);
    }

    // http://www.smslive247.com/http/index.aspx?cmd=querycoverage&sessionid=xxx&msisdn=xxx
    // OK: [TRUE/FALSE] -or- ERR: [ERROR NUMBER]: [ERROR DESCRIPTION]
    public function coverage($session_id, $msisdn)
    {
        return $this->http->request('GET', 'index.aspx?cmd=querycoverage&sessionid='.$session_id.'&msisdn='.$msisdn);
    }

    // http://www.smslive247.com/http/index.aspx?cmd=recharge&sessionid=xxx&rcode=xxx
    // OK: [NEW BALANCE] -or- ERR: [ERROR NUMBER]: [ERROR DESCRIPTION]
    public function recharge($session_id, $code)
    {
        return $this->http->request('GET', 'index.aspx?cmd=recharge&sessionid='.$session_id.'&rcode='.$code);
    }

    // http://www.smslive247.com/http/index.aspx?cmd=stopmsg&sessionid=xxx&messageid=xxx
    // OK: [TRUE/FALSE] -or- ERR: [ERROR NUMBER]: [ERROR DESCRIPTION]
    public function stop($session_id, $message_id)
    {
        return $this->http->request('GET', 'index.aspx?cmd=stopmsg&sessionid='.$session_id.'&messageid='.$message_id);
    }

    // http://www.smslive247.com/http/index.aspx?cmd=getsentmsgs&sessionid=xxx&pagesize=xxx&pagenumber=xxx&begindate=xxx&enddate=xxx&sender=xxx&contains=xxx
    // OK: [TOTALROWS] [RAW DATA RETURNED AS XML/XLS/CSV] -or- ERR: [ERROR NUMBER]: [ERROR DESCRIPTION]
    public function history($session_id, $page_size, $page_number, $start_date, $end_date, $sender, $contains)
    {
        return $this->http->request('GET', 'index.aspx?cmd=getsentmsgs&sessionid='.$session_id.'&pagesize='.$page_size.'&pagenumber='.$page_number.'&begindate='.$start_date.'&enddate='.$end_date.'&sender='.$sender.'&contains='.$contains);
    }

    // HTTP GET)
    //     MessageID
    // The Message identifier for the batch message. Numeric value.
    // 23456
    // TotalSent
    // Total messages delivered to mobile subscribers.
    // 100
    // TotalFailed
    // Total messages failed.
    // 3
    // TotalCharged
    // Total credits charged for the bulk messages sent. This value may be greater than TotalSent since some networks charge more than others.
    // 126
    // Balance
    // The remaining credit balance on the Sub-Account.
    // 550
    // Status
    // The batch message status.
    // COMPLETED, PAUSED, ABORTED
    public function callback()
    {
        // code...
    }
}