<?php defined('BASEPATH') OR exit('No direct script access allowed');

$config['activities_update'] = array();

$config['activities'] = array(
    array(
        'field' => 'page_id',
        'rules' => 'trim|required',
    ),
    array(
        'field' => 'element',
        'rules' => 'trim|required',
    ),
    array(
        'field' => 'event',
        'rules' => 'trim|required',
    ),
    array(
        'field' => 'value',
        'rules' => 'trim|required',
    ),
);

$config['business_units'] = array(
    array(
        'field' => 'name',
        'rules' => 'trim|required',
    ),
    array(
        'field' => 'code_name',
        'rules' => 'trim',
    ),
);


$config['sbcs'] = array(
    array(
        'field' => 'name',
        'rules' => 'trim|required',
    ),
    array(
        'field' => 'cac_number',
        'rules' => 'trim|required',
    ),
    array(
        'field' => 'date_of_incorporation',
        'rules' => 'trim',
    ),
    array(
        'field' => 'cac_certificate_src',
        'label' => 'cac certificate',
        'rules' => '',
    ),
    array(
        'field' => 'representative_name',
        'rules' => 'trim|required',
    ),
    array(
        'field' => 'email',
        'rules' => 'trim|valid_email|is_unique[sbcs.email]',
    ),
    array(
        'field' => 'password',
        'rules' => 'required|min_length[7]|max_length[26]',
    ),
    array(
        'field' => 'telephone',
        'rules' => 'trim|required|is_unique[sbcs.telephone]',
    ),
    array(
        'field' => 'secondary_telephone',
        'rules' => 'trim',
    ),
    array(
        'field' => 'type',
        'rules' => 'trim|required|in_list[owner, occupant]',
    ),
    array(
        'field' => 'group',
        'rules' => 'trim|required|in_list[SBC, LEC]',
    ),
    array(
        'field' => 'date_of_property_possession',
        'rules' => 'trim|required',
    ),
    array(
        'field' => 'logo_src',
        'label' => 'logo',
        'rules' => '',
    ),
    array(
        'field' => 'address',
        'rules' => 'trim|required',
    ),    
    array(
        'field' => 'login_at',
        'rules' => 'trim|required',
    ),
    array(
        'field' => 'logout_at',
        'rules' => 'trim|required',
    ),
);

$config['agents'] = array(
    array(
        'field' => 'name',
        'rules' => 'trim|required',
    ),
    array(
        'field' => 'representative_name',
        'rules' => 'trim|required',
    ),
    array(
        'field' => 'email',
        'rules' => 'trim|valid_email|is_unique[sbcs.email]',
    ),
    array(
        'field' => 'password',
        'rules' => 'required|min_length[7]|max_length[26]',
    ),
    array(
        'field' => 'telephone',
        'rules' => 'trim|required|is_unique[sbcs.telephone]',
    ),
    array(
        'field' => 'secondary_telephone',
        'rules' => 'trim',
    ),
    array(
        'field' => 'type',
        'rules' => 'trim|required|in_list[owner, occupant]',
    ),
    array(
        'field' => 'address',
        'rules' => 'trim|required',
    ),    
    array(
        'field' => 'login_at',
        'rules' => 'trim|required',
    ),
    array(
        'field' => 'logout_at',
        'rules' => 'trim|required',
    ),
);

$config['lecs'] = array(
    array(
        'field' => 'name',
        'rules' => 'trim|required',
    ),
    array(
        'field' => 'cac_number',
        'rules' => 'trim|required',
    ),
    array(
        'field' => 'date_of_incorporation',
        'rules' => 'trim',
    ),
    array(
        'field' => 'cac_certificate_src',
        'label' => 'cac certificate',
        'rules' => '',
    ),
    array(
        'field' => 'representative_name',
        'rules' => 'trim|required',
    ),
    array(
        'field' => 'email',
        'rules' => 'trim|valid_email|is_unique[lecs.email]',
    ),
    array(
        'field' => 'password',
        'rules' => 'required|min_length[7]|max_length[26]',
    ),
    array(
        'field' => 'telephone',
        'rules' => 'trim|required|is_unique[lecs.telephone]',
    ),
    array(
        'field' => 'secondary_telephone',
        'rules' => 'trim',
    ),
    array(
        'field' => 'type',
        'rules' => 'trim|required|in_list[owner, occupant]',
    ),
    array(
        'field' => 'group',
        'rules' => 'trim|required|in_list[SBC, LEC]',
    ),
    array(
        'field' => 'date_of_property_possession',
        'rules' => 'trim|required',
    ),
    array(
        'field' => 'logo_src',
        'label' => 'logo',
        'rules' => '',
    ),
    array(
        'field' => 'address',
        'rules' => 'trim|required',
    ), 
    array(
        'field' => 'login_at',
        'rules' => 'trim|required',
    ),
    array(
        'field' => 'logout_at',
        'rules' => 'trim|required',
    ),
);

$config['msps'] = array(
    array(
        'field' => 'name',
        'rules' => 'trim|required',
    ),
    array(
        'field' => 'cac_number',
        'rules' => 'trim|required',
    ),
    array(
        'field' => 'date_of_incorporation',
        'rules' => 'trim',
    ),
    array(
        'field' => 'cac_certificate_src',
        'label' => 'cac certificate',
        'rules' => '',
    ),
    array(
        'field' => 'representative_name',
        'rules' => 'trim|required',
    ),
    array(
        'field' => 'email',
        'rules' => 'trim|valid_email|is_unique[msps.email]',
    ),
    array(
        'field' => 'password',
        'rules' => 'required|min_length[7]|max_length[26]',
    ),
    array(
        'field' => 'telephone',
        'rules' => 'trim|required|is_unique[msps.telephone]',
    ),
    array(
        'field' => 'secondary_telephone',
        'rules' => 'trim',
    ),
    array(
        'field' => 'type',
        'rules' => 'trim|required|in_list[owner, occupant]',
    ),
    array(
        'field' => 'group',
        'rules' => 'trim|required|in_list[SBC, LEC]',
    ),
    array(
        'field' => 'date_of_property_possession',
        'rules' => 'trim|required',
    ),
    array(
        'field' => 'date_of_property_possession',
        'rules' => 'trim|required',
    ),
    array(
        'field' => 'date_of_property_possession',
        'rules' => 'trim|required',
    ),
    array(
        'field' => 'logo_src',
        'label' => 'logo',
        'rules' => '',
    ),
    array(
        'field' => 'address',
        'rules' => 'trim|required',
    ), 
    array(
        'field' => 'login_at',
        'rules' => 'trim|required',
    ),
    array(
        'field' => 'logout_at',
        'rules' => 'trim|required',
    ),
);

// $config['customers'] = array();

$config['common_reset_password'] = array(
    array(
        'field' => 'pin',
        'rules' => 'trim|required|numeric',
    ),
    array(
        'field' => 'password',
        'rules' => 'required',
    ),
    array(
        'field' => 'confirm_password',
        'rules' => 'required|match[password]',
    ),
);

$config['change_password'] = array(
    array(
        'field' => 'old_password',
        'rules' => 'required',
    ),
    array(
        'field' => 'password',
        'rules' => 'required|match[confirm_password]',
    ),
);

$config['common_generate_token'] = array(
    array(
        'field' => 'email',
        'rules' => 'trim|valid_email',
    ),
    array(
        'field' => 'telephone',
        'rules' => 'trim',
    ),
);

$config['common_sign_in'] = array(
    array(
        'field' => 'id',
        'rules' => 'trim|required',
    ),
    array(
        'field' => 'password',
        'rules' => 'required',
    )
);

$config['common_sign_up'] = array(
    array(
        'field' => 'email',
        'rules' => 'trim|valid_email|is_unique[customers.email]',
    ),
    array(
        'field' => 'password',
        'rules' => 'required|min_length[7]|max_length[26]',
    ),
    array(
        'field' => 'type',
        'rules' => 'trim',
    ),
    array(
        'field' => 'telephone',
        'rules' => 'trim|required|is_unique[customers.telephone]',
    ),
    array(
        'field' => 'house_number',
        'rules' => 'trim|required',
    ),
    array(
        'field' => 'street',
        'rules' => 'trim|required',
    ),
    array(
        'field' => 'city',
        'rules' => 'trim|required',
    ),
    array(
        'field' => 'state',
        'rules' => 'trim|required',
    ),
    array(
        'field' => 'country',
        'rules' => 'trim|required',
    ),
    array(
        'field' => 'postcode',
        'rules' => 'trim|required',
    ),
    array(
        'field' => 'address_description',
        'rules' => 'trim',
    ),
    array(
        'field' => 'id_type',
        'rules' => 'trim',
    ),
    array(
        'field' => 'id_number',
        'rules' => 'trim',
    ),
    array(
        'field' => 'id_src',
        'label' => 'ID card',
        'rules' => '',
    ),
);

$config['common_profile'] = array(
    array(
        'field' => 'name',
        'rules' => 'trim|required',
    ),
    array(
        'field' => 'dob',
        'rules' => 'trim|required',
    ),
    array(
        'field' => 'email',
        'rules' => 'trim|valid_email',
    ),
    array(
        'field' => 'avatar_src',
        'label' => 'profile photo (avatar)',
        'rules' => '',
    ),
    array(
        'field' => 'ownership',
        'rules' => 'trim|required|in_list[tenant,owner]',
    ),
    array(
        'field' => 'telephone',
        'rules' => 'trim',
    ),
    array(
        'field' => 'house_number',
        'rules' => 'trim|required',
    ),
    array(
        'field' => 'street',
        'rules' => 'trim|required',
    ),
    array(
        'field' => 'city',
        'rules' => 'trim|required',
    ),
    array(
        'field' => 'state',
        'rules' => 'trim|required',
    ),
    array(
        'field' => 'country',
        'rules' => 'trim|required',
    ),
    array(
        'field' => 'postcode',
        'rules' => 'trim|required',
    ),
    array(
        'field' => 'address_description',
        'rules' => 'trim',
    ),
    array(
        'field' => 'id_type',
        'rules' => 'trim|required',
    ),
    array(
        'field' => 'id_number',
        'rules' => 'trim|required',
    ),
    array(
        'field' => 'id_src',
        'label' => 'ID card',
        'rules' => '',
    ),
);

$config['feedbacks'] = array(
    array(
        'field' => 'name',
        'rules' => 'trim',
    ),
    array(
        'field' => 'email',
        'rules' => 'trim|valid_email',
    ),
    array(
        'field' => 'telephone',
        'rules' => 'trim',
    ),
    array(
        'field' => 'url',
        'rules' => 'trim',
    ),
    array(
        'field' => 'message',
        'rules' => 'trim|required',
    ),
);

$config['feeders'] = array(
    array(
        'field' => 'name',
        'rules' => 'trim|required',
    ),
    array(
        'field' => 'number',
        'rules' => 'trim',
    ),
);

$config['installations'] = array(
    array(
        'field' => 'order_id',
        'rules' => 'trim|required',
    ),
    array(
        'field' => 'energy_recovery',
        'rules' => 'trim|required',
    ),
    array(
        'field' => 'feedback',
        'rules' => 'trim',
    ),
    array(
        'field' => 'comment',
        'rules' => 'trim',
    ),
    array(
        'field' => 'geo_address',
        'rules' => 'trim',
    ),
    array(
        'field' => 'longitude',
        'rules' => 'trim',
    ),
    array(
        'field' => 'latitude',
        'rules' => 'trim',
    ),
    array(
        'field' => 'kyc',
        'rules' => 'trim',
    ),
    array(
        'field' => 'debt_migration',
        'rules' => 'trim',
    ),
    array(
        'field' => 'gps_location_src',
        'label' => 'GPS location',
        'rules' => '',
    ),
);

$config['invoices'] = array(
    array(
        'field' => 'order_id',
        'rules' => 'trim|required',
    ),
    array(
        'field' => 'paid',
        'rules' => 'trim',
    ),
    array(
        'field' => 'type',
        'rules' => 'trim|required|in_list[cash,bank,online]',
    ),
    array(
        'field' => 'amount',
        'rules' => 'trim|required|numeric',
    ),
    array(
        'field' => 'reference',
        'rules' => 'trim',
    ),
    array(
        'field' => 'request',
        'rules' => 'trim',
    ),
    array(
        'field' => 'response',
        'rules' => 'trim',
    ),
);

$config['meters'] = array(
    array(
        'field' => 'order_id',
        'rules' => 'trim|required',
    ),
    array(
        'field' => 'meter_number',
        'rules' => 'trim|required',
    ),
    array(
        'field' => 'manufacturer',
        'rules' => 'trim|required',
    ),
    array(
        'field' => 'type',
        'rules' => 'trim|required',
    ),
    array(
        'field' => 'box_type',
        'rules' => 'trim|required',
    ),
    array(
        'field' => 'energy',
        'rules' => 'trim|required|numeric',
    ),
    array(
        'field' => 'reading_at',
        'rules' => 'trim|required|numeric',
    ),
    array(
        'field' => 'meter_condition',
        'rules' => 'trim|required',
    ),
    array(
        'field' => 'meter_nameplate_src',
        'label' => 'meter nameplate',
        'rules' => '',
    ),
    array(
        'field' => 'meter_card_src',
        'label' => 'meter card',
        'rules' => '',
    ),
    array(
        'field' => 'account_number',
        'rules' => 'trim|required',
    ),
    array(
        'field' => 'old_account_number',
        'rules' => 'trim',
    ),
    array(
        'field' => 'current_meter_status',
        'rules' => 'trim',
    ),
    array(
        'field' => 'tube',
        'rules' => 'trim|required',
    ),
    array(
        'field' => 'mcb',
        'rules' => 'trim|required',
    ),
    array(
        'field' => 'new_seal',
        'rules' => 'trim|required',
    ),
    array(
        'field' => 'old_seal',
        'rules' => 'trim',
    ),
    array(
        'field' => 'debts',
        'rules' => 'trim|required',
    ),
    array(
        'field' => 'debt_settled',
        'rules' => 'trim|required',
    ),
);

$config['orders'] = array(
    array(
        'field' => 'customer_id',
        'rules' => 'trim',
    ),
    array(
        'field' => 'type',
        'rules' => 'trim|required|in_list[new,replacement,additional]',
    ),
    array(
        'field' => 'house_number',
        'rules' => 'trim|required',
    ),
    array(
        'field' => 'street',
        'rules' => 'trim|required',
    ),
    array(
        'field' => 'city',
        'rules' => 'trim|required',
    ),
    array(
        'field' => 'state',
        'rules' => 'trim|required',
    ),
    array(
        'field' => 'country',
        'rules' => 'trim|required',
    ),
    array(
        'field' => 'postcode',
        'rules' => 'trim|required',
    ),
    array(
        'field' => 'address_description',
        'rules' => 'trim',
    ),
    array(
        'field' => 'is_new_building',
        'rules' => 'trim',
    ),
    array(
        'field' => 'business_unit_id',
        'rules' => 'trim',
    ),
    array(
        'field' => 'undertaking_id',
        'rules' => 'trim',
    ),
    array(
        'field' => 'feeder_id',
        'rules' => 'trim',
    ),
    array(
        'field' => 'transformer_id',
        'rules' => 'trim|required',
    ),
);

$config['pages'] = array(
    array(
        'field' => 'session_id',
        'rules' => 'trim|required',
    ),
    array(
        'field' => 'url',
        'rules' => 'trim|required',
    ),
    array(
        'field' => 'start_at',
        'rules' => 'trim|required',
    ),
    array(
        'field' => 'end_at',
        'rules' => 'trim|required',
    ),
);

$config['reviews'] = array(
    array(
        'field' => 'customer_id',
        'rules' => 'trim|required',
    ),
    array(
        'field' => 'sbc_id',
        'rules' => 'trim|required',
    ),
    array(
        'field' => 'lec_id',
        'rules' => 'trim|required',
    ),
    array(
        'field' => 'rating',
        'rules' => 'trim|required',
    ),
    array(
        'field' => 'comment',
        'rules' => 'trim',
    ),
);

$config['certifications'] = array(
    array(
        'field' => 'lec_id',
        'rules' => 'trim|required',
    ),
    array(
        'field' => 'agent_id',
        'rules' => 'trim|required',
    ),
    array(
        'field' => 'team_id',
        'rules' => 'trim|required',
    ),
    array(
        'field' => 'order_id',
        'rules' => 'trim|required',
    ),
    array(
        'field' => 'revision',
        'rules' => 'trim|required',
    ),
    array(
        'field' => 'feedback',
        'rules' => 'trim',
    ),
    array(
        'field' => 'comment',
        'rules' => 'trim',
    ),
    array(
        'field' => 'certificate_src',
        'label' => 'Certificate',
        'rules' => '',
    
    ),
);

$config['sessions'] = array(
    array(
        'field' => 'hash',
        'rules' => 'trim|required',
    ),
    array(
        'field' => 'detail',
        'rules' => 'trim|required',
    ),
);

$config['staffs'] = array(
    array(
        'field' => 'name',
        'rules' => 'trim|required',
    ),
    array(
        'field' => 'email',
        'rules' => 'trim|required|valid_email|is_unique[staffs.email]',
    ),
    array(
        'field' => 'password',
        'rules' => 'required|min_length[7]|max_length[26]',
    ),    
    array(
        'field' => 'type',
        'rules' => 'trim|required|in_list[NMD, New Service, Customer Service, Finance, QAQC]',
    ),
    array(
        'field' => 'location',
        'rules' => 'trim|required',
    ), 
    array(
        'field' => 'policies',
        'rules' => 'trim|required',
    ), 
    array(
        'field' => 'login_at',
        'rules' => 'trim|required',
    ),
    array(
        'field' => 'logout_at',
        'rules' => 'trim|required',
    ),
);

$config['surveys'] = array(
    array(
        'field' => 'order_id',
        'rules' => 'trim|required',
    ),
    array(
        'field' => 'voltage',
        'rules' => 'trim|required',
    ),
    array(
        'field' => 'wattage',
        'rules' => 'trim|required',
    ),
    array(
        'field' => 'longitude',
        'rules' => 'trim|required',
    ),
    array(
        'field' => 'latitude',
        'rules' => 'trim|required',
    ),
    array(
        'field' => 'existing_tariff_type',
        'rules' => 'trim|required',
    ),
    array(
        'field' => 'recommended_tariff_type',
        'rules' => 'trim|required',
    ),
    array(
        'field' => 'existing_meter_type',
        'rules' => 'trim|required|in_list[analogue,digital]',
    ),
    array(
        'field' => 'condition_of_service_wire',
        'rules' => 'trim|required',
    ),
    array(
        'field' => 'cable_distance',
        'rules' => 'trim|required',
    ),
    array(
        'field' => 'cable_size',
        'rules' => 'trim|required',
    ),
    array(
        'field' => 'responsible_party_for_wire_replacement',
        'rules' => 'trim|required|in_list[customer,business]',
    ),
    array(
        'field' => 'length_of_service_wires',
        'rules' => 'trim|required',
    ),
    array(
        'field' => 'service_wire_traceable_to_metering_point',
        'rules' => 'trim|required',
    ),
    array(
        'field' => 'meter_point_wire_distribution',
        'rules' => 'trim|required|in_list[tidy,untidy]',
    ),
    array(
        'field' => 'space_for_installation',
        'rules' => 'trim|required',
    ),
    array(
        'field' => 'meter_recommendation',
        'rules' => 'trim|required',
    ),
    array(
        'field' => 'reason_for_replacement',
        'rules' => 'trim|required|in_list[1-phase,3-phase]',
    ),
    array(
        'field' => 'correction_required_by_customer',
        'rules' => 'trim|required',
    ),
    array(
        'field' => 'justification_for_load_rating',
        'rules' => 'trim|required',
    ),
    array(
        'field' => 'feedback',
        'rules' => 'trim|required',
    ),
    array(
        'field' => 'comment',
        'rules' => 'trim|required',
    ),
    array(
        'field' => 'gps_location_src',
        'label' => 'GPS location',
        'rules' => '',
    ),
    array(
        'field' => 'load_assessment',
        'rules' => 'trim|required',
    ),
);

$config['undertakings'] = array(
    array(
        'field' => 'name',
        'rules' => 'trim|required',
    ),
    array(
        'field' => 'code_name',
        'rules' => 'trim',
    ),
);

$config['verification_tokens'] = array(
    array(
        'field' => 'email',
        'rules' => 'trim|valid_email',
    ),
    array(
        'field' => 'telephone',
        'rules' => 'trim|required',
    ),
    array(
        'field' => 'token',
        'rules' => 'trim|required',
    ),
    array(
        'field' => 'pin',
        'rules' => 'trim|required|max[4]',
    ),
);

$config['transformers'] = array(
    array(
        'field' => 'name',
        'rules' => 'trim|required',
    ),
    array(
        'field' => 'number',
        'rules' => 'trim|required',
    ),
    array(
        'field' => 'capacity',
        'rules' => 'trim|required|numeric',
    ),
);
