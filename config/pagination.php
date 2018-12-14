<?php defined('BASEPATH') OR exit('No direct script access allowed');

$config['per_page'] = 20;
$config["uri_segment"] = 3;
$config["num_links"] = 2;
$config["use_page_numbers"] = TRUE;
// $config["page_query_string"] = FALSE;
// $config["reuse_query_string"] = FALSE;
$config["prefix"] = "";
$config["suffix"] = "";
$config["full_tag_open"] = '<nav><ul class="pagination justify-content-end">';
$config["full_tag_close"] = '</ul></nav>';
$config['display_pages'] = TRUE;
$config['attributes'] = array('class' => 'page-link');

$config["first_link"] = '<i class="fa fa-angle-double-left"></i>';
$config["first_tag_open"] = '<li class="page-item">';
$config["first_tag_close"] = '</li>';

$config["last_link"] = '<i class="fa fa-angle-double-right"></i>';
$config["last_tag_open"] = '<li class="page-item">';
$config["last_tag_close"] = '</li>';

$config["next_link"] = '<i class="fa fa-angle-right"></i>';
$config["next_tag_open"] = '<li class="page-item">';
$config["next_tag_close"] = '</li>';

$config["prev_link"] = '<i class="fa fa-angle-left"></i>';
$config["prev_tag_open"] = '<li class="page-item">';
$config["prev_tag_close"] = '</li>';

$config["curr_tag_open"] = '<li class="page-item active">';
$config["curr_tag_close"] = '</li>';

$config["num_tag_open"] = '<li class="page-item">';
$config["num_tag_close"] = '</li>';