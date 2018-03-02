<?php
/*
Plugin Name: iPayment_PROMP
Description: 
Version: 0001
Author: ottoshi
Author URI: Fighter!!! 
*/

// ini_set('display_errors','Off');

//ini_set('error_reporting', E_ALL );
//define('WP_DEBUG', true);
//define('WP_DEBUG_DISPLAY', true);

// Define at Main file 
 define( PLUGIN_FILE_URL , __FILE__); 
// We need to add this part all the time

require_once('iPayment_globals.class.php');

if( is_admin() ) {
	require_once('init.php');
}
//echo phpinfo();
//require_once('iPayment.php');
//require_once('iPaymnet_function.php');
?>