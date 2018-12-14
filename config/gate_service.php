<?php defined('BASEPATH') OR exit('No direct script access allowed');

//model policies
$config['policies'] = array(
    'activities' => array(
        'create', 
        'read', 
        'update', 
        'delete'
    ), 
    'business_units' => array(
        'create', 
        'read', 
        'update', 
        'delete'
    ),
    'msps' => array(
        'create', 
        'read', 
        'update', 
        'delete'
    ),
    'sbcs' => array(
        'create', 
        'read', 
        'update', 
        'delete'
    ),
    'lecs' => array(
        'create', 
        'read', 
        'update', 
        'delete'
    ),
    'customers' => array(
        'create', 
        'read', 
        'update', 
        'delete'
    ),
    'teams' => array(
        'create', 
        'read', 
        'update', 
        'delete'
    ),
    'agents' => array(
        'create', 
        'read', 
        'update', 
        'delete'
    ),
    'feeders' => array(
        'create', 
        'read', 
        'update', 
        'delete'
    ),
    'feedbacks' => array(
        'create', 
        'read', 
        'update', 
        'delete'
    ),
    'installations' => array(
        'create', 
        'read', 
        'update', 
        'delete'
    ),
    'invoices' => array(
        'create', 
        'read', 
        'update', 
        'delete'
    ),
    'meters' => array(
        'create', 
        'read', 
        'update', 
        'delete'
    ),
    'orders' => array(
        'create', 
        'read', 
        'update', 
        'delete'
    ),
    'pages' => array(
        'create', 
        'read', 
        'update', 
        'delete'
    ),
    'reviews' => array(
        'create', 
        'read', 
        'update', 
        'delete'
    ),
    'certifications' => array(
        'create', 
        'read', 
        'update', 
        'delete'
    ),
    'notifications' => array(
        'create', 
        'read', 
        'update', 
        'delete'
    ),
    'sessions' => array(
        'create', 
        'read', 
        'update', 
        'delete'
    ),
    'staffs' => array(
        'create', 
        'read', 
        'update', 
        'delete'
    ),
    'surveys' => array(
        'create', 
        'read', 
        'update', 
        'delete'
    ),
    'undertakings' => array(
        'create', 
        'read', 
        'update', 
        'delete'
    ),
    'verification_tokens' => array(
        'create', 
        'read', 
        'update', 
        'delete'
    ),
    'transformers' => array(
        'create', 
        'read', 
        'update', 
        'delete'
    ),
    'kycs' => array(
        'create', 
        'read', 
        'update', 
        'delete'
    ),
    'debt_migrations' => array(
        'create', 
        'read', 
        'update', 
        'delete'
    ),
    // non model
    'settings' => array(
        'read', 
        'update', 
    ),
    'entities' => array(
        'read', 
        'update', 
    ),
    'settings-app' => array(
        'read', 
        'update', 
    ),
    'settings-user' => array(
        'read', 
        'update', 
    ),
    'admin-only' => array(
        'create', 'read', 'update', 'delete'
    ),
    'cs-only' => array(
        'create', 'read', 'update', 'delete'
    ),
    'ns-only' => array(
        'create', 'read', 'update', 'delete'
    ),
    'qaqc-only' => array(
        'create', 'read', 'update', 'delete'
    ),
    'nmd-only' => array(
        'create', 'read', 'update', 'delete'
    ),
    'finance-only' => array(
        'create', 'read', 'update', 'delete'
    ),
    'msp-only' => array(
        'create', 'read', 'update', 'delete'
    ),
    'sbc-only' => array(
        'create', 'read', 'update', 'delete'
    ),
    'lec-only' => array(
        'create', 'read', 'update', 'delete'
    ),
    'team-only' => array(
        'create', 'read', 'update', 'delete'
    ),
    'agent-only' => array(
        'create', 'read', 'update', 'delete'
    ),
    'individual-only' => array(
        'create', 'read', 'update', 'delete'
    ),
    'business-only' => array(
        'create', 'read', 'update', 'delete'
    ),
    'customer-only' => array(
        'create', 'read', 'update', 'delete'
    ),
    'cs-frontend-only' => array(
        'create', 'read', 'update', 'delete'
    ),
    'cs-backend-only' => array(
        'create', 'read', 'update', 'delete'
    ),
    'cs-bu-lead-only' => array(
        'create', 'read', 'update', 'delete'
    ),
    'finance-bu-lead-only' => array(
        'create', 'read', 'update', 'delete'
    ),
);

//non admin users
$config['static_policies'] = array(
    'individual' => array(
        'orders' => array(
            'create', 'read', 
        ),
		'individual-only' => array(
			'create', 'read', 'update', 'delete'
		),
        'customer-only' => array(
            'create', 'read', 'update', 'delete'
        ),
    ),
    'business' => array(
        'orders' => array(
            'create', 'read', 
        ),
		'business-only' => array(
			'create', 'read', 'update', 'delete'
		),
        'customer-only' => array(
            'create', 'read', 'update', 'delete'
        ),
    ),
    'msp' => array(
        'surveys' => array(
            'create', 'read', 
        ),
        'installations' => array(
            'create', 'read', 
        ),
		'msp-only' => array(
			'create', 'read', 'update', 'delete'
		),
    ),
    'sbc' => array(
        'surveys' => array(
            'create', 'read', 
        ),
        'installations' => array(
            'create', 'read', 
        ),
		'sbc-only' => array(
			'create', 'read', 'update', 'delete'
		),
    ),
    'lec' => array(
        'certifications' => array(
            'create', 'read', 
        ),
		'lec-only' => array(
			'create', 'read', 'update', 'delete'
		),
    ),
    'agent' => array(
        'surveys' => array(
            'create', 'read', 
        ),
        'installations' => array(
            'create', 'read', 
        ),
		'agent-only' => array(
			'create', 'read', 'update', 'delete'
		),
    ),
);

//staff policies

$config['staff_policies'] = array(
    'admin' => array(
        //model policies
        'activities' => array(
            'create', 
            'read', 
            'update', 
            'delete'
        ), 
        'business_units' => array(
            'create', 
            'read', 
            'update', 
            'delete'
        ),
        'msps' => array(
            'create', 
            'read', 
            'update', 
            'delete'
        ),
        'sbcs' => array(
            'create', 
            'read', 
            'update', 
            'delete'
        ),
        'lecs' => array(
            'create', 
            'read', 
            'update', 
            'delete'
        ),
        'customers' => array(
            'create', 
            'read', 
            'update', 
            'delete'
        ),
        'teams' => array(
            'create', 
            'read', 
            'update', 
            'delete'
        ),
        'agents' => array(
            'create', 
            'read', 
            'update', 
            'delete'
        ),
        'feedbacks' => array(
            'create', 
            'read', 
            'update', 
            'delete'
        ),
        'feeders' => array(
            'create', 
            'read', 
            'update', 
            'delete'
        ),
        'transformers' => array(
            'create', 
            'read', 
            'update', 
            'delete'
        ),
        'installations' => array(
            'create', 
            'read', 
            'update', 
            'delete'
        ),
        'invoices' => array(
            'create', 
            'read', 
            'update', 
            'delete'
        ),
        'meters' => array(
            'create', 
            'read', 
            'update', 
            'delete'
        ),
        'orders' => array(
            'create', 
            'read', 
            'update', 
            'delete'
        ),
        'pages' => array(
            'create', 
            'read', 
            'update', 
            'delete'
        ),
        'reviews' => array(
            'create', 
            'read', 
            'update', 
            'delete'
        ),
        'certifications' => array(
            'create', 
            'read', 
            'update', 
            'delete'
        ),
        'sessions' => array(
            'create', 
            'read', 
            'update', 
            'delete'
        ),
        'staffs' => array(
            'create', 
            'read', 
            'update', 
            'delete'
        ),
        'surveys' => array(
            'create', 
            'read', 
            'update', 
            'delete'
        ),
        'undertakings' => array(
            'create', 
            'read', 
            'update', 
            'delete'
        ),
        'verification_tokens' => array(
            'create', 
            'read', 
            'update', 
            'delete'
        ),
        'notifications' => array(
            'create', 
            'read', 
            'update', 
            'delete'
        ),
        'kycs' => array(
            'create', 
            'read', 
            'update', 
            'delete'
        ),
        'debt_migrations' => array(
            'create', 
            'read', 
            'update', 
            'delete'
        ),
        // non model
        'settings' => array(
            'read', 
            'update', 
        ),
        'entities' => array(
            'read', 
        ),
        'admin-only' => array(
            'create', 'read', 'update', 'delete'
        ),
        'cs-only' => array(
            'create', 'read', 'update', 'delete'
        ),
        'ns-only' => array(
            'create', 'read', 'update', 'delete'
        ),
        'qaqc-only' => array(
            'create', 'read', 'update', 'delete'
        ),
        'nmd-only' => array(
            'create', 'read', 'update', 'delete'
        ),
        'finance-only' => array(
            'create', 'read', 'update', 'delete'
        ),
        'msp-only' => array(
            'create', 'read', 'update', 'delete'
        ),
        'sbc-only' => array(
            'create', 'read', 'update', 'delete'
        ),
        'lec-only' => array(
            'create', 'read', 'update', 'delete'
        ),
        'team-only' => array(
            'create', 'read', 'update', 'delete'
        ),
        'agent-only' => array(
            'create', 'read', 'update', 'delete'
        ),
        'individual-only' => array(
            'create', 'read', 'update', 'delete'
        ),
        'business-only' => array(
            'create', 'read', 'update', 'delete'
        ),
        'customer-only' => array(
            'create', 'read', 'update', 'delete'
        ),
        'cs-frontend-only' => array(
            'create', 'read', 'update', 'delete'
        ),
        'cs-backend-only' => array(
            'create', 'read', 'update', 'delete'
        ),
        'cs-bu-lead-only' => array(
            'create', 'read', 'update', 'delete'
        ),
        'finance-bu-lead-only' => array(
            'create', 'read', 'update', 'delete'
        ),
    ),	
    'cs' => array(
        //model policies
        'customers' => array(
            'create', 
            'read', 
            'update', 
            'delete'
        ),
        'installations' => array(
            'create', 
            'read', 
            'update', 
            'delete'
        ),
        'meters' => array(
            'create', 
            'read', 
            'update', 
            'delete'
        ),
        'kycs' => array(
            'create', 
            'read', 
            'update', 
            'delete'
        ),
        'debt_migrations' => array(
            'create', 
            'read', 
            'update',
        ),
        // non model
        'entities' => array(
            'read', 
            'update', 
        ),
        'cs-only' => array(
            'create', 'read', 'update', 'delete'
        ),
    ),
    'ns' => array(
        //model policies
        'meters' => array(
            'create', 
            'read', 
            'update', 
            'delete'
        ),
        // non model
        'entities' => array(
            'read', 
            'update', 
        ),
        'ns-only' => array(
            'create', 'read', 'update', 'delete'
        ),
    ),
    'finance' => array(
        //model policies
        'invoices' => array(
            'create', 
            'read', 
            'update', 
            'delete'
        ),
        // non model
        'entities' => array(
            'read', 
            'update', 
        ),
        'finance-only' => array(
            'create', 'read', 'update', 'delete'
        ),
    ),
    'qaqc' => array(
        //model policies
        'installations' => array(
            'create', 
            'read', 
            'update', 
            'delete'
        ),
        'surveys' => array(
            'create', 
            'read', 
            'update', 
            'delete'
        ),
        // non model
        'entities' => array(
            'read', 
            'update', 
        ),
        'qaqc-only' => array(
            'create', 'read', 'update', 'delete'
        ),
    ),	
    'nmd' => array(
        //model policies
        'business_units' => array(
            'create', 
            'read', 
            'update', 
            'delete'
        ),
        'msps' => array(
            'create', 
            'read', 
            'update', 
            'delete'
        ),
        'sbcs' => array(
            'create', 
            'read', 
            'update', 
            'delete'
        ),
        'lecs' => array(
            'create', 
            'read', 
            'update', 
            'delete'
        ),
        'customers' => array(
            'create', 
            'read', 
            'update', 
            'delete'
        ),
        'teams' => array(
            'create', 
            'read', 
            'update', 
            'delete'
        ),
        'agents' => array(
            'create', 
            'read', 
            'update', 
            'delete'
        ),
        'feedbacks' => array(
            'create', 
            'read', 
            'update', 
            'delete'
        ),
        'feeders' => array(
            'create', 
            'read', 
            'update', 
            'delete'
        ),
        'transformers' => array(
            'create', 
            'read', 
            'update', 
            'delete'
        ),
        'installations' => array(
            'create', 
            'read', 
            'update', 
            'delete'
        ),
        'meters' => array(
            'create', 
            'read', 
            'update', 
            'delete'
        ),
        'orders' => array(
            'create', 
            'read', 
            'update', 
            'delete'
        ),
        'certifications' => array(
            'create', 
            'read', 
            'update', 
            'delete'
        ),
        'invoices' => array(
            'create', 
            'read', 
            'update', 
            'delete'
        ),
        'surveys' => array(
            'create', 
            'read', 
            'update', 
            'delete'
        ),
        'undertakings' => array(
            'create', 
            'read', 
            'update', 
            'delete'
        ),
        // non model
        'settings' => array(
            'read', 
            'update', 
        ),
        'entities' => array(
            'read', 
        ),
        'nmd-only' => array(
            'create', 'read', 'update', 'delete'
        ),
    ),    
    'cs-frontend' => array(
        'meters' => array(
            'create', 'read', 
        ),
		'cs-frontend-only' => array(
			'create', 'read', 'update', 'delete'
		),
    ),	    
    'cs-backend' => array(
        //model policies
        'customers' => array(
            'read', 
        ),
        'installations' => array(
            'read', 
        ),
        'invoices' => array(
            'read', 
        ),
        'meters' => array(
            'read', 
        ),
        'orders' => array(
            'read', 
        ),
        'pages' => array(
            'read', 
        ),
        'certifications' => array(
            'read', 
        ),
        'staffs' => array(
            'read', 
        ),
        'surveys' => array(
            'read', 
        ),
        'kycs' => array(
            'create', 
            'read', 
            'update', 
            'delete'
        ),
        'debt_migrations' => array(
            'create', 
            'read', 
            'update', 
            'delete'
        ),
        // non model
        'settings' => array(
            'read', 
            'update', 
        ),
        'entities' => array(
            'read', 
        ),
        'cs-backend-only' => array(
            'create', 'read', 'update', 'delete'
        ),
    ),
    'cs-bu-lead' => array(
        //model policies
        'customers' => array(
            'read', 
        ),
        'installations' => array(
            'read', 
        ),
        'invoices' => array(
            'read', 
        ),
        'meters' => array(
            'read', 
        ),
        'orders' => array(
            'read', 
        ),
        'pages' => array(
            'read', 
        ),
        'certifications' => array(
            'read', 
        ),
        'staffs' => array(
            'read', 
        ),
        'surveys' => array(
            'read', 
        ),
        'kycs' => array(
            'read', 
            'update', 
        ),
        'debt_migrations' => array(
            'read', 
            'update', 
        ),
        // non model
        'settings' => array(
            'read', 
            'update', 
        ),
        'entities' => array(
            'read', 
        ),
        'cs-bu-lead-only' => array(
            'create', 'read', 'update', 'delete'
        ),
    ),
    'finance-bu-lead' => array(
        //model policies
        'customers' => array(
            'read', 
        ),
        'installations' => array(
            'read', 
        ),
        'invoices' => array(
            'read', 
        ),
        'meters' => array(
            'read', 
        ),
        'orders' => array(
            'read', 
        ),
        'pages' => array(
            'read', 
        ),
        'certifications' => array(
            'read', 
        ),
        'staffs' => array(
            'read', 
        ),
        'surveys' => array(
            'read', 
        ),
        'kycs' => array(
            'read', 
            'update', 
        ),
        'debt_migrations' => array(
            'read', 
            'update', 
        ),
        // non model
        'settings' => array(
            'read', 
            'update', 
        ),
        'entities' => array(
            'read', 
        ),
        'finance-bu-lead-only' => array(
            'create', 'read', 'update', 'delete'
        ),
    ),
);