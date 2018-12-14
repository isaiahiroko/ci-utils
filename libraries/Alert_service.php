<?php defined('BASEPATH') OR exit('No direct script access allowed');

// CRON Jobs Setup
// Send pending emails each 2 minutes.
// */2 * * * * php /var/www/index.php queue_email/send_queue
// Send failed emails each 5 minutes.
// */5 * * * * php /var/www/index.php queue_email/retry_queue

class Alert_service{
    
    protected $CI;

    protected $messages;
    protected $inhibit_all;
    protected $inhibit_email;
    protected $inhibit_sms;
    protected $inhibit_notif;

    protected $user;

    public function __construct($params = [])
    {
        $this->CI =& get_instance();
        $this->messages = $params['messages'];
        $this->inhibit_all = $params['inhibit_all'];
        $this->inhibit_email = $params['inhibit_email'];
        $this->inhibit_sms = $params['inhibit_sms'];
        $this->inhibit_notif = $params['inhibit_notif'];
    }

    public function to($email, $telephone = NULL, $id = NULL, $user_type = NULL)
    {
        $this->user['email'] = $email;
        $this->user['telephone'] = $telephone; 
        $this->user['id'] = $id;
        $this->user['type'] = $user_type;

        return $this;
    }

    private function setup_mail()
    {
        $this->CI->load->library('email');
        $this->CI->email->set_newline("\r\n");
    }

    private function setup_sms()
    {
        $this->CI->load->library('Ebulksms_service', 'ebulksms');
    }

    private function setup_notif()
    {
        $this->CI->load->library('Notif_service', 'notif');
    }

    public function mail($subject, $message, $to, $from_email = "isaiahiroko@gmail.com", $from_name = "MMS", $cc = NULL, $bcc = NULL)
    {
        $this->setup_mail();

        $this->CI->load->library('email');
        $this->CI->email->set_newline("\r\n");
        
        $this->CI->email->from($from_email, $from_name);
        $this->CI->email->to($to);

        if($cc){
            $this->CI->email->cc($cc);
        }

        if($bcc){
            $this->CI->email->bcc($bcc);
        }

        $this->CI->email->subject($subject);
        $this->CI->email->message($message);
        $this->CI->email->send();
    }

    public function html_mail($view, $data, $to, $from_email = "isaiahiroko@gmail.com", $from_name = "MMS", $cc = NULL, $bcc = NULL)
    {
        $this->setup_mail();
        
        $this->CI->email->from($from_email, $from_name);
        $this->CI->email->to($to);

        if($cc){
            $this->CI->email->cc($cc);
        }

        if($bcc){
            $this->CI->email->bcc($bcc);
        }

        $this->CI->email->subject($data['title']);
        $this->CI->email->message($this->CI->view->render($view, $data, array(), array()));

        $this->CI->email->set_mailtype('html');

        $this->CI->email->send();
    }

    public function sms($message, $recipients)
    {
        $this->setup_sms();

        $this->CI->ebulksms->send($message, $recipients);
        
        // array(
        //     array('msidn' => '', 'msgid' => ''),
        //     array('msidn' => '', 'msgid' => ''),
        //     array('msidn' => '', 'msgid' => ''),
        // )
    }
    
    public function notify($user_id, $user_type, $message)
    {
        $this->setup_notif();
        $this->CI->notif->for($user_id, $user_type)->send($message['content'], $message['title'], $message['type']);
    }

    public function message($type, $code)
    {
        return $this->messages[$code][$type];
    }

    public function email_message($code)
    {
        return $this->message('email', $code);
    }

    public function sms_message($code)
    {
        return $this->message('sms', $code);
    }

    public function notif_message($code)
    {
        return $this->message('notif', $code);
    }

    public function dispatch($code, $additional = array())
    {
        // die(var_dump($code, $this->inhibit_all));
        if(!$this->inhibit_all){

            // send mail
            if(!$this->inhibit_email){
                $this->html_mail(
                    'layouts/email', 
                    array_merge($this->email_message($code), $additional),
                    $this->user['email']
                );
            }

            // send sms
            if(!$this->inhibit_sms){
                $this->sms(
                    array_merge($this->sms_message($code), $additional),
                    $this->user['telephone']
                );
            }

            // send notification
            if(!$this->inhibit_notif){
                $this->notify(
                    $this->user['id'], 
                    $this->user['type'], 
                    array_merge($this->notif_message($code), $additional)
                );
            }
        }
    }
}