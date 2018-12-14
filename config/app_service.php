<?php defined('BASEPATH') OR exit('No direct script access allowed');

$meter_request_reasons = array(
    'Damaged old meter',
    'For a newly built house',
);

$house_uses = array(
    'Residential',
    'Commercial',
    'Social',
    'Industrial',
    'School',
    'Mosque',
    'Church',
    'Filling Station',
    'Office',
    'Hotel',
);

$house_types = array(
    'Tenement House',
    '2 Bed Room Flat',
    '3 Bed Room Flat',
    'Duplex',
    'Single Room',
    'Shop/Boys Qtrs',
    'Blocks of FLat',
);
$reading_types = array(
    'R - Read',
    'E - Estimated',
    'D – Coded',
);
$activity_types = array(
    'Surveys',
    'Installations',
    'Certifications',
    'Invoices',
);
$unit_types = array(
    'Business Units',
    'Undertakings',
    'Feeders',
    'Transformers',
);
$vendors = array(
    'MSPs',
    'SBCs',
    'LECs',
);

$third_parties = array(
    'ie force',
    'cis',
    'conlog',
);

$customer_types = array(
    'nmd',
    'non-nmd',
);

$account_types = array(
    'prepaid',
    'postpaid',
);

$customer_status = array(
    'active',
    'suspend',
);

$status = array(
    'new', 
    'assigned/survey', 
    'reassigned/survey', 
    'pending/survey', 
    'submitted/survey', 
    'resubmitted/survey', 
    'incomplete/survey', 
    'approved/survey', 
    'excalated/survey', 
    'rejected/survey', 
    'completed/survey', 
    // 'assigned/certification', 
    // 'reassigned/certification', 
    // 'pending//certification', 
    // 'submitted/certification', 
    // 'resubmitted/certification', 
    // 'incomplete/certification', 
    // 'approved/certification', 
    // 'excalated/certification', 
    // 'rejected/certification', 
    // 'completed/certification', 
    'assigned/installation', 
    'reassigned/installation', 
    'pending//installation', 
    'submitted/installation', 
    'resubmitted/installation', 
    'incomplete/installation', 
    'completed/installation', 
    'approved/installation', 
    'excalated/installation', 
    'rejected/installation', 
    'activated/meter', 
    'payment/assigned',
    'payment/pending',
    'payment/confirmed',
    'kyc/pending',
    'kyc/submitted',
    'kyc/confirmed',
    'migration/pending',
    'migration/submitted',
    'migration/confirmed',
    'migration/cs',
    'activated/meter',
);

$config['global'] = array(
    'name' => 'MMS',
    'slogan' => '...',
    'desc' => 'meter management system',
    'fav' => '/imgs/ie.ico',
    'logo' => '/imgs/ie.png',
    'styles' => array(
        '/bootstrap-4.0.0-dist/css/bootstrap.min.css',
        '/coreui/dist/css/coreui-standalone.min.css',
        '/fontawesome-free-5.2.0-web/css/all.min.css',
        '/DataTables/datatables.min.css',
        '/chosen_v1.8.7/chosen.min.css',
        '/daterangepicker/daterangepicker.css',
        '/mos/style.css',
    ),
    'scripts' => array(
        '/pace/pace.min.js',
        '/jquery/jquery-3.3.1.min.js',
        '/popper.js-1.14.3/dist/umd/popper.min.js',
        '/bootstrap-4.0.0-dist/js/bootstrap.min.js',
        '/coreui/dist/js/coreui.min.js',
        '/DataTables/datatables.min.js',
        '/moment/moment.js',
        '/Chart.js/Chart.min.js',
        '/chosen_v1.8.7/chosen.jquery.min.js',
        '/notify/notify.min.js',
        '/daterangepicker/daterangepicker.js',
        '/mos/script.js',
    ),
    'title' => 'MMS - Meter Management System',
    'menu' => array(
        'primary' => array(
            array('title' => 'Home', 'url' => '/', 'icon' => 'home'),
            array('title' => 'Login', 'url' => 'sign-in', 'icon' => 'sign-in-alt'),
            array('title' => 'Create Account', 'url' => 'sign-up', 'type' => 'primary', 'icon' => 'user-plus'),
        ),
        'secondary' => array(
            array(
                'title' => 'Customer Registration', 
                'desc' => 'Create an account with Ikeja Electric to start enjoy lots of benefits', 
                'button' => array(
                    'title' => 'Sign Up',
                    'url' => 'sign-up',
                ),
                'image' => '/imgs/customers-sign-up.jpg',
            ),
            array(
                'title' => 'Customers', 
                'desc' => 'Login to your dashboard if you already have an account with us', 
                'button' => array(
                    'title' => 'Sign In',
                    'url' => 'sign-in/customers',
                ),
                'image' => '/imgs/customer-sign-in.jpeg',
            ),
            array(
                'title' => 'Meter Service Provider', 
                'desc' => 'For Ikeja Electric registered contractors (SBCs and LECs)', 
                'button' => array(
                    'title' => 'Sign In',
                    'url' => 'sign-in/msps',
                ),
                'image' => '/imgs/contractors-sing-in.jpeg',
            ),
            array(
                'title' => 'SubContractors', 
                'desc' => 'For Ikeja Electric registered contractors (SBCs and LECs)', 
                'button' => array(
                    'title' => 'Sign In',
                    'url' => 'sign-in/sbcs',
                ),
                'image' => '/imgs/contractors-sing-in.jpeg',
            ),
            array(
                'title' => 'Licenced Electrical Contractors', 
                'desc' => 'For Ikeja Electric registered contractors (SBCs and LECs)', 
                'button' => array(
                    'title' => 'Sign In',
                    'url' => 'sign-in/lecs',
                ),
                'image' => '/imgs/contractors-sing-in.jpeg',
            ),
            array(
                'title' => 'Customer Service', 
                'desc' => 'Report an issue to one of our agent.', 
                'button' => array(
                    'title' => 'Submit Feedback',
                    'url' => 'feedbacks',
                ),
                'image' => '/imgs/customer-service.jpeg',
            ),
            array(
                'title' => 'Staff and Admins', 
                'desc' => 'Manage users and meter requests.', 
                'button' => array(
                    'title' => 'Sign In',
                    'url' => 'sign-in/staffs',
                ),
                'image' => '/imgs/staff-sign-in.png',
            ),
        ),
        'tertiary' => array(),
    ),     
    'nigerian_states' => array(
        "Abia",
        "Adamawa",
        "Anambra",
        "Akwa Ibom",
        "Bauchi",
        "Bayelsa",
        "Benue",
        "Borno",
        "Cross River",
        "Delta",
        "Ebonyi",
        "Enugu",
        "Edo",
        "Ekiti",
        "FCT - Abuja",
        "Gombe",
        "Imo",
        "Jigawa",
        "Kaduna",
        "Kano",
        "Katsina",
        "Kebbi",
        "Kogi",
        "Kwara",
        "Lagos",
        "Nasarawa",
        "Niger",
        "Ogun",
        "Ondo",
        "Osun",
        "Oyo",
        "Plateau",
        "Rivers",
        "Sokoto",
        "Taraba",
        "Yobe",
        "Zamfara"
    ),
    'entities' => array(
        'activities',
        'business_units',
        'msps',
        'sbcs',
        'lecs',
        'agents',
        'customers',
        'feedbacks',
        'feeders',
        'installations',
        'invoices',
        'meters',
        'orders',
        'pages',
        'reviews',
        'certifications',
        'sessions',
        'staffs',
        'surveys',
        'undertakings',
        'user_logs',
        'verification_tokens',
    ),
    'icons' => array(
        'activities' => 'align-justify',
        'business_units' => 'building',
        'msps' => 'user-tie',
        'sbcs' => 'user-tie',
        'lecs' => 'user-tie',
        'customers' => 'users',
        'feedbacks' => 'comments',
        'feeders' => 'bolt',
        'installations' => 'wrench',
        'invoices' => 'file-invoice',
        'meters' => 'tachometer-alt',
        'orders' => 'shopping-cart',
        'pages' => 'file-alt',
        'reviews' => 'edit',
        'certifications' => 'file-signature',
        'sessions' => 'sync-alt',
        'staffs' => 'users-cog',
        'surveys' => 'chart-bar',
        'transformers' => 'bolt',
        'undertakings' => 'warehouse',
        'verification_tokens' => 'key',
        'sign_in' => 'unlock-alt',
        'sign_up' => 'plus-square',
        'settings' => 'sliders-h',
        'generate_token' => 'qrcode',
        'profile' => 'user-circle',
        'resources' => 'ellipsis-h',
        'scheduler' => 'clock',
        'sync' => 'sync-alt',
        'password' => 'key',
        'agents' => 'wrench',
        'teams' => 'people-carry',
        'people' => 'people-carry',
    ),
    'view' => array(
        'collection' => array(
            'orders' => array(
                'individual' => array(
                    'filter' => 'mine',
                    'column' => 'customer_id',
                ),
                'business' => array(
                    'filter' => 'mine',
                    'column' => 'customer_id',
                ),
            ),
            'surveys' => array(
                'sbc' => array(
                    'filter' => 'mine',
                    'column' => 'sbc_id',
                ),
                'agent' => array(
                    'filter' => 'mine',
                    'column' => 'agent_id',
                ),
            ),
            'installations' => array(
                'sbc' => array(
                    'filter' => 'mine',
                    'column'    => 'sbc_id',
                ),
                'agent' => array(
                    'filter' => 'mine',
                    'column' => 'agent_id',
                ),
            ),
            'certifications' => array(
                'lec' => array(
                    'filter' => 'mine',
                    'column' => 'lec_id',
                ),
            )
        )
    ),
    'types' => array(
        'house_types' => $house_types,
        'house_types_options' => array_map(function ($v){
            return array('title' => $v, 'value' => $v, 'selected' => FALSE);
        }, $house_types),
        'house_uses' => $house_uses,
        'house_uses_options' => array_map(function ($v){
            return array('title' => $v, 'value' => $v, 'selected' => FALSE);
        }, $house_uses),
        'reading_types' => $reading_types,
        'reading_types_options' => array_map(function ($v){
            return array('title' => $v, 'value' => $v, 'selected' => FALSE);
        }, $reading_types),
        'activity_types' => $activity_types,
        'activity_types_options' => array_map(function ($v){
            return array('title' => $v, 'value' => $v, 'selected' => FALSE);
        }, $activity_types),
        'unit_types' => $unit_types,
        'unit_types_options' => array_map(function ($v){
            return array('title' => $v, 'value' => $v, 'selected' => FALSE);
        }, $unit_types),
        'vendors' => $vendors,
        'vendors_options' => array_map(function ($v){
            return array('title' => $v, 'value' => $v, 'selected' => FALSE);
        }, $vendors),
        'third_parties' => $third_parties,
        'third_parties_options' => array_map(function ($v){
            return array('title' => $v, 'value' => $v, 'selected' => FALSE);
        }, $third_parties),
        'customer_types' => $customer_types,
        'customer_types_options' => array_map(function ($v){
            return array('title' => $v, 'value' => $v, 'selected' => FALSE);
        }, $customer_types),
        'customer_status' => $customer_status,
        'customer_status_options' => array_map(function ($v){
            return array('title' => $v, 'value' => $v, 'selected' => FALSE);
        }, $customer_status),
        'account_types' => $account_types,
        'account_types_options' => array_map(function ($v){
            return array('title' => $v, 'value' => $v, 'selected' => FALSE);
        }, $account_types),
        'meter_request_reasons' => $meter_request_reasons,
        'meter_request_reasons_options' => array_map(function ($v){
            return array('title' => $v, 'value' => $v, 'selected' => FALSE);
        }, $meter_request_reasons),
        'status' => $status,
        'status_options' => array_map(function ($v){
            return array('title' => ucwords(implode(' ', explode('/', $v))), 'value' => $v, 'selected' => FALSE);
        }, $status),
    )
);