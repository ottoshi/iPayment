<?php

function fn_display_qrcode() {

	$includeHTML = file_get_contents(plugins_url('/template/_tmp_qr_form.html',PLUGIN_FILE_URL ));							

	$QRCODE = plugins_url("/lib/promptpay-qr-l.php?type=0".get_option( '_iPAYMENT_PROMP_FLAG' ,'1')."&promptpay_id=".get_option( '_iPAYMENT_PROMP_ID' ,'')."&price=".$_POST[IPAYMENTPROM::KEY_AMOUNT]."&p=1",PLUGIN_FILE_URL);
	$includeHTML = str_replace("{QRCODE}", $QRCODE, $includeHTML);

	$includeHTML = str_replace("{REFFER}", $_POST[IPAYMENTPROM::KEY_REFID], $includeHTML);
	$includeHTML = str_replace("{NAME}", $_POST[IPAYMENTPROM::KEY_NAME], $includeHTML);
	$includeHTML = str_replace("{AMOUNT}", $_POST[IPAYMENTPROM::KEY_AMOUNT], $includeHTML);
	$includeHTML = str_replace("{EMAIL}", $_POST[IPAYMENTPROM::KEY_EMAIL], $includeHTML);
	$includeHTML = str_replace("{PHONE}", $_POST[IPAYMENTPROM::KEY_PHONE], $includeHTML);
	$includeHTML = str_replace("{NOTIES}", $_POST[IPAYMENTPROM::KEY_NOTIES], $includeHTML);

	return $includeHTML;
}


function fn_mail($status){

	$includeHTML = file_get_contents(plugins_url('/template/_tmp_mail.html',PLUGIN_FILE_URL ));	
	$mail_sender = get_option( '_iPAYMENT_MAIL_SENDER',IPAYMENT::MAIL_SENDER_DEFAULT);

	// parameter mail
	$mail_to = $_POST[IPAYMENTPROM::KEY_EMAIL];

	$includeHTML = str_replace("{refid}", $_POST[IPAYMENTPROM::KEY_REFID], $includeHTML);
	$includeHTML = str_replace("{name}", $_POST[IPAYMENTPROM::KEY_NAME], $includeHTML);
	$includeHTML = str_replace("{amount}", $_POST[IPAYMENTPROM::KEY_AMOUNT], $includeHTML);
	$includeHTML = str_replace("{serviceorder}", $_POST[IPAYMENTPROM::KEY_SERIVCEORDER], $includeHTML);
	$includeHTML = str_replace("{serviceother}", $_POST[IPAYMENTPROM::KEY_SERIVCEOTHER], $includeHTML);
	$includeHTML = str_replace("{status}", $status, $includeHTML);

		$subject = "IPAYMENT :: Payment status ";
		$headers  = "From: $mail_sender\r\n"; 
	    $headers .= "Content-type: text/html; charset=utf-8\r\n";

		return wp_mail($mail_to,$subject,$includeHTML,$headers);

}

function fn_convert_log($array_data = null,$data_type) {
	
	$search = $_REQUEST["search"];
	$data = "";

return $data;	
}


function Generate_UNIQID() {

	$microtimestamp  = microtime(true); /// format XXXXXXXXXX.XXXX
	$return_value = substr(floor($microtimestamp*100),-12); // Format  XXXXXXXXXXXX 
	return $return_value;
}

function Stamp_log_payment($LOG,$status = null) {
	global $wpdb;

    $table_name =  $wpdb->prefix . IPAYMENTPROM::TABLE_MASTER_PAYMENT_LOG;

	$AMOUNT = sprintf('%0.2f', $_POST[IPAYMENTPROM::KEY_AMOUNT]); 


	$update_date = date("Y-m-d H:i:s");

	$datum = $wpdb->get_results("SELECT * FROM $table_name WHERE i_refence= '".$_POST[IPAYMENTPROM::KEY_REFID]."'");
	if($wpdb->num_rows == 0) {
	
		$flag_return =  $wpdb->insert(
		$table_name,
		array('i_refence' =>  $_POST[IPAYMENTPROM::KEY_REFID] ,
				'i_amount' =>  $AMOUNT , 
				'i_name' =>  $_POST[IPAYMENTPROM::KEY_NAME] , 
				'i_email' =>  $_POST[IPAYMENTPROM::KEY_EMAIL] , 
				'i_phone' =>  $_POST[IPAYMENTPROM::KEY_PHONE] , 
				'i_noties' =>  $_POST[IPAYMENTPROM::KEY_NOTIES] , 
				'i_sysdate'=> $update_date ,
				'i_status' => 0  ), 
		array('%s', '%s','%s','%s','%s','%s','%s')
		);		
	} else {
		$flag_return = 1;		
	}

	return $flag_return;	
}

function Truncate_table_log_payment() {
	global $wpdb;
	$table_name =  $wpdb->prefix . IPAYMENTPROM::TABLE_MASTER_PAYMENT_LOG;

	return $wpdb->query("TRUNCATE TABLE $table_name");

}

?>