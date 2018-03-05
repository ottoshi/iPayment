<?php


function IPAYMENTPROM_options_install() {
    global $wpdb;
	$table_name = $wpdb->prefix . IPAYMENTPROM::TABLE_MASTER_PAYMENT_LOG;
	$charset_collate = $wpdb->get_charset_collate();
    $sql = "CREATE TABLE $table_name  (
			  i_id int(11) NOT NULL AUTO_INCREMENT,PRIMARY KEY (i_id),
			  i_refence varchar(12) NOT NULL,
			  i_amount varchar(50) NOT NULL,
			  i_name varchar(50) NOT NULL,
			  i_email  varchar(50) NOT NULL,
			  i_phone  varchar(50) NOT NULL,
			  i_noties  text NOT NULL,
			  i_sysdate timestamp NULL ,
			  r_sysdate timestamp NULL ,  			  
			  i_status varchar(10) NOT NULL,
			  i_flag int(1) NULL DEFAULT 1   
			)  $charset_collate; ";
	// i_flag = 0-delete , 1-show  

    require_once( ABSPATH . 'wp-admin/includes/upgrade.php' );
    dbDelta($sql);
}

function IPAYMENTPROM_options_uninstall() {
	global $wpdb;
     $table_name =  $wpdb->prefix . IPAYMENTPROM::TABLE_MASTER_PAYMENT_LOG ;
	 $sql = "DROP TABLE IF EXISTS $table_name";
	 echo $sql;
     $wpdb->query($sql);

}

function display_iPaymnetPrommenu() {
	
	//this is the main item for the menu
	add_menu_page('_iOrderPay', //page title
	'IPAYMENTPROM', //menu title
	'manage_options', //capabilities
	'fn_IPAYMENTPROM_order_list', //menu slug
	'fn_IPAYMENTPROM_order_list' //function
	);

	//this is a submenu
	add_submenu_page('fn_IPAYMENTPROM_order_list', //parent slug
	'Config', //page title
	'Config', //menu title
	'manage_options', //capability
	'fn_IPAYMENTPROM_config', //menu slug
	'fn_IPAYMENTPROM_config'); //function
}
// run the install scripts upon plugin activation
register_activation_hook(PLUGIN_FILE_URL, 'IPAYMENTPROM_options_install'); 
// Deactive 
register_deactivation_hook(PLUGIN_FILE_URL, 'IPAYMENTPROM_options_uninstall' );
// Uninstall 
register_uninstall_hook( PLUGIN_FILE_URL, 'IPAYMENTPROM_options_uninstall');


//menu items
add_action('admin_menu','display_iPaymnetPrommenu');

define('iPAYROOTDIR', plugin_dir_path(PLUGIN_FILE_URL));

require_once(iPAYROOTDIR . 'order-list.php');
require_once(iPAYROOTDIR . 'config.php');


?>