<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/*
| -------------------------------------------------------------------------
| Hooks
| -------------------------------------------------------------------------
| This file lets you define "hooks" to extend CI without hacking the core
| files.  Please see the user guide for info:
|
|	http://codeigniter.com/user_guide/general/hooks.html
|
*/

$hook['post_controller_constructor'][] = array(
    'class'    => 'Log',
    'function' => 'session',
    'filename' => 'Log.php',
    'filepath' => 'hooks',
);

$hook['post_controller_constructor'][] = array(
    'class'    => 'Log',
    'function' => 'page_start',
    'filename' => 'Log.php',
    'filepath' => 'hooks',   
);

$hook['post_controller_constructor'][] = array(
    'class'    => 'Log',
    'function' => 'activity',
    'filename' => 'Log.php',
    'filepath' => 'hooks',
);

$hook['post_controller_constructor'][] = array(
    'class'    => 'Auth',
    'function' => 'check',
    'filename' => 'Auth.php',
    'filepath' => 'hooks',
);

$hook['post_controller_constructor'][] = array(
    'class'    => 'File',
    'function' => 'upload',
    'filename' => 'File.php',
    'filepath' => 'hooks',
);

$hook['post_controller_constructor'][] = array(
    'class'    => 'JSONify',
    'function' => 'jsonify',
    'filename' => 'JSONify.php',
    'filepath' => 'hooks',
);

// $hook['post_controller_constructor'][] = array(
//     'class'    => 'Gate',
//     'function' => 'check',
//     'filename' => 'Gate.php',
//     'filepath' => 'hooks',
// );

// $hook['display_override'][] = array(
// 	'class'  	=> 'Compressor',
//     'function' 	=> 'compress',
//     'filename' 	=> 'Compressor.php',
//     'filepath' 	=> 'hooks'
// );

// For Dev only
// $hook['display_override'][] = array(
// 	'class'  	=> 'Develbar',
//     'function' 	=> 'debug',
//     'filename' 	=> 'Develbar.php',
//     'filepath' 	=> 'third_party/DevelBar/hooks'
// );

$hook['post_system'][] = array(
    'class'    => 'Log',
    'function' => 'page_end',
    'filename' => 'Log.php',
    'filepath' => 'hooks',
);

/* End of file hooks.php */
/* Location: ./application/config/hooks.php */