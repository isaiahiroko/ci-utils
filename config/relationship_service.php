<?php defined('BASEPATH') OR exit('No direct script access allowed');

$config['map'] = array(
    'activities' => array(
        'has' => array(
            'one' => array(),
            'many' => array(),
        ), 
        'belongs_to' => array(
            'one' => array('pages'),
            'many' => array(),
        ), 
    ), 
    'business_units' => array(
        'has' => array(
            'one' => array(),
            'many' => array('orders'),
        ), 
        'belongs_to' => array(
            'one' => array(),
            'many' => array(),
        ), 
    ),
    'staffs' => array(
        'has' => array(
            'one' => array(),
            'many' => array('surveys', 'certifications', 'invoices', 'installations', 'meters',
                'notifications'),
        ), 
        'belongs_to' => array(
            'one' => array(),
            'many' => array(),
        ), 
    ),
    'msps' => array(
        'has' => array(
            'one' => array(),
            'many' => array('surveys', 'certifications', 'invoices', 'installations', 'meters',
                'notifications', 'reviews', 'sbcs', 'lecs'),
        ), 
        'belongs_to' => array(
            'one' => array(),
            'many' => array(),
        ), 
    ),
    'sbcs' => array(
        'has' => array(
            'one' => array(),
            'many' => array('surveys', 'certifications', 'invoices', 'installations', 'meters',
                'notifications', 'reviews', 'teams'),
        ), 
        'belongs_to' => array(
            'one' => array('msps'),
            'many' => array(),
        ), 
    ),
    'lecs' => array(
        'has' => array(
            'one' => array(),
            'many' => array('surveys', 'certifications', 'invoices', 'installations', 'meters',
                'notifications', 'reviews', 'teams'),
        ), 
        'belongs_to' => array(
            'one' => array('msps'),
            'many' => array(),
        ), 
    ),
    'teams' => array(
        'has' => array(
            'one' => array(),
            'many' => array('surveys', 'certifications', 'invoices', 'installations', 'meters',
                'notifications', 'agents'),
        ), 
        'belongs_to' => array(
            'one' => array('sbcs', 'lecs'),
            'many' => array(),
        ), 
    ),
    'agents' => array(
        'has' => array(
            'one' => array(),
            'many' => array(),
        ), 
        'belongs_to' => array(
            'one' => array('teams'),
            'many' => array(),
        ), 
    ),
    'customers' => array(
        'has' => array(
            'one' => array(),
            'many' => array('orders', 'notifications', 'reviews'),
        ), 
        'belongs_to' => array(
            'one' => array(),
            'many' => array(),
        ), 
    ),
    'feedbacks' => array(
        'has' => array(
            'one' => array(),
            'many' => array(),
        ), 
        'belongs_to' => array(
            'one' => array(),
            'many' => array(),
        ), 
    ),
    'feeders' => array(
        'has' => array(
            'one' => array(),
            'many' => array('orders'),
        ), 
        'belongs_to' => array(
            'one' => array(),
            'many' => array(),
        ), 
    ),
    'installations' => array(
        'has' => array(
            'one' => array(),
            'many' => array(),
        ), 
        'belongs_to' => array(
            'one' => array('orders', 'msps', 'sbcs', 'lecs', 'teams', 'agents', 'staffs'),
            'many' => array(),
        ), 
    ),
    'invoices' => array(
        'has' => array(
            'one' => array(),
            'many' => array(),
        ), 
        'belongs_to' => array(
            'one' => array('orders', 'msps', 'sbcs', 'lecs', 'teams', 'agents', 'staffs'),
            'many' => array(),
        ), 
    ),
    'meters' => array(
        'has' => array(
            'one' => array(),
            'many' => array(),
        ), 
        'belongs_to' => array(
            'one' => array('orders', 'msps', 'sbcs', 'lecs', 'teams', 'agents', 'staffs'),
            'many' => array(),
        ), 
    ),
    'orders' => array(
        'has' => array(
            'one' => array('surveys', 'certifications', 'invoices', 'installations', 'meters'),
            'many' => array(),
        ), 
        'belongs_to' => array(
            'one' => array('customers', 'business_units', 'undertakings', 'feeders', 'transformers'),
            'many' => array(),
        ), 
    ),
    'pages' => array(
        'has' => array(
            'one' => array(),
            'many' => array('activities'),
        ), 
        'belongs_to' => array(
            'one' => array('sessions'),
            'many' => array(),
        ), 
    ),
    'reviews' => array(
        'has' => array(
            'one' => array(),
            'many' => array(),
        ), 
        'belongs_to' => array(
            'one' => array('customers', 'msps', 'sbcs', 'lecs'),
            'many' => array(),
        ), 
    ),
    'certifications' => array(
        'has' => array(
            'one' => array(),
            'many' => array(),
        ), 
        'belongs_to' => array(
            'one' => array('orders', 'msps', 'sbcs', 'lecs', 'teams', 'agents', 'staffs'),
            'many' => array(),
        ), 
    ),
    'sessions' => array(
        'has' => array(
            'one' => array(),
            'many' => array('pages'),
        ), 
        'belongs_to' => array(
            'one' => array(),
            'many' => array(),
        ), 
    ),
    'surveys' => array(
        'has' => array(
            'one' => array(),
            'many' => array(),
        ), 
        'belongs_to' => array(
            'one' => array('orders', 'msps', 'sbcs', 'lecs', 'teams', 'agents', 'staffs'),
            'many' => array(),
        ), 
    ),
    'undertakings' => array(
        'has' => array(
            'one' => array(),
            'many' => array('orders'),
        ), 
        'belongs_to' => array(
            'one' => array(),
            'many' => array(),
        ), 
    ),
    'verification_tokens' => array(
        'has' => array(
            'one' => array(),
            'many' => array(),
        ), 
        'belongs_to' => array(
            'one' => array(),
            'many' => array(),
        ), 
    ),
    'transformers' => array(
        'has' => array(
            'one' => array(),
            'many' => array('orders'),
        ), 
        'belongs_to' => array(
            'one' => array(),
            'many' => array(),
        ), 
    ),
    'notifications' => array(
        'has' => array(
            'one' => array(),
            'many' => array(),
        ), 
        'belongs_to' => array(
            'one' => array('customers', 'staffs', 'msps', 'sbcs', 'lecs', 'teams', 'agents'),
            'many' => array(),
        ), 
    ),
);