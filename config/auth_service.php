<?php defined('BASEPATH') OR exit('No direct script access allowed');

$config = array(
    'routes' => array(
        'unauth' => array(
            '*' => array('*'),
            'sign-in' => array('*'),
            'sign-up' => array('*'),
            'generate-token' => array('*'),
            'reset-password' => array('*'),
            'verify-email' => array('*'),
        ),
        'auth' => array(
            'dashboard' => array('*'),
        ),
        'api' => array(
            'api' => array('*'),
            'email-queue' => array('*'),
        )
    ),
    'urls' => array(
        'unauth' => '/sign-in',
        'auth' => 'dashboard',
    )
);