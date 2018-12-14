<?php defined('BASEPATH') OR exit('No direct script access allowed');

$config['inhibit_all'] = FALSE;
$config['inhibit_email'] = FALSE;
$config['inhibit_sms'] = TRUE;
$config['inhibit_notif'] = TRUE;

$config['messages']['001'] = array(
    'email' => array(
        'title' => 'hello world',
        'summary' => 'hello world',
        'greeting' => 'hello world',
        'pre_content' => 'hello world',
        'views' => array(
            'name' => '',
            'data' => array(),
        ),
        'post_content' => 'hello world',
        'actions' => array(
            array('title' => 'Login', 'url' => site_url('/')),
        ),
    ),
    'sms' => 'hello world',
    'notif' => array(
        'title' => 'hello world',
        'content' => 'hi',
        'type' => 'status',
    ),
);

$config['messages']['002'] = array(
    'email' => array(
        'content' => 'hello world',
        'actions' => array(
            array('title' => 'Login', 'url' => site_url('/')),
        ),
    ),
    'sms' => 'hello world',
    'notif' => 'hello world',
);