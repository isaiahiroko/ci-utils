<?php defined('BASEPATH') OR exit('No direct script access allowed');

$config['entities'] = array(
    // 'activities',
    // 'customers',
    'staffs',
    'msps',
    'sbcs',
    'lecs',
    'teams',
    'agents',
    // 'business_units',
    // 'feeders',
    // 'transformers',
    // 'installations',
    // 'invoices',
    // 'meters',
    // 'orders',
    // 'pages',
    // 'reviews',
    // 'certifications',
    // 'sessions',
    // 'surveys',
    // 'undertakings',
    // 'user_logs',
    // 'verification_tokens',
    // 'feedbacks',
);

$config['people'] = array(
    // 'customers',
    'staffs',
    'msps',
    'sbcs',
    'teams',
    'agents',
);

$config['entity'] = array(
    'create' => array('title' => 'Add', 'url' => '%controller%/create', 'id' => 'create-action'),
    'batch-create' => array('title' => 'Create Batch', 'url' => '%controller%/batch-create', 'id' => 'batch-create-action'),
    'view' => array('title' => 'View', 'url' => '%controller%/collection/%id%'),
    'edit' => array('title' => 'Edit', 'url' => '%controller%/edit/%id%'),
    'delete' => array('title' => 'Delete', 'url' => '%controller%/delete/%id%', 'id' => 'delete-action'),
    'back' => array('title' => 'Back to Collection', 'url' => '%controller%/table'),
);

$config['primary'] = array(
    'default' => array(
        array('title' => 'account', 'url' => 'account', 'entity' => '*', 'ability' => '*', 'icon' => 'user-cog'),
        array('title' => 'settings', 'url' => 'settings', 'entity' => '*', 'ability' => '*', 'icon' => 'sliders-h'),
        array('title' => 'help', 'url' => 'help', 'entity' => '*', 'ability' => '*', 'icon' => 'info'),
        array('title' => 'submit feedback', 'url' => 'feedback', 'entity' => '*', 'ability' => '*', 'icon' => 'comment-alt'),
        array('title' => 'logout', 'url' => 'sign-out', 'entity' => '*', 'ability' => '*',  'icon' => 'sign-out-alt'),
    ),
    'orders' => array()
);

$config['secondary'] = array( 
    'default' => array(
        array('title' => 'orders', 'url' => 'dashboard', 'icon' => '', 'entity' => '*', 'ability' => '*'),
        array(
            'title' => 'people', 
            'url' => 'entities',
            'entity' => 'entities', 
            'ability' => 'read',
            'sub' => array_map(function($value){
                return array('title' => $value, 'url' => $value.'/table', 'entity' => $value, 'ability' => 'read');
            }, $config['people'])
        ),
    ),
    'orders' => array()   
);

//for collection page
$config['tertiary'] = array(
    'default' => array(),
    'orders' => array()
);

//for solo pages
$config['auxiliary'] = array(
    'default' => array(),
    'orders' => array(),
);

//for page toolbar
$config['toolbar'] = array(
    'default' => array(
        array('title' => 'reports', 'url' => 'reports', 'entity' => 'orders', 'ability' => 'update', 'icon' => 'chart-pie'),
        array('title' => 'activity log', 'url' => 'activities', 'entity' => 'orders', 'ability' => 'update', 'icon' => 'bicycle'),
        array('title' => 'feedback', 'url' => 'feedbacks/table', 'entity' => 'admin-only', 'ability' => 'read', 'icon' => 'comments'),
    ),
    'orders' => array(),
);

$config['cards'] = array(
    'default' => array(),
    'optional' => array(),
);
