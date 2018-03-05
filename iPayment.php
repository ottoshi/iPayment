<?php

function ipayment_shortcode($atts = [], $content = null, $tag = '')
{	 
	
		if($_POST['submitpayment']!=null)   {

	
				if (get_option( '_iPAYMENT_CAPTCHA_FLAG' ,'true')) {

				 if(isset($_POST['g-recaptcha-response']))
						 $captcha=$_POST['g-recaptcha-response'];

						if(!$captcha){  echo '<h3>'.IPAYMENTPROM::CAPTCHA_CAPTION_EMPTY.'</h3>'; exit;
						}

						$omise_captcha_secret =  get_option( '_iPAYMENT_CAPTCHA_SECRET' ,'');		

						$response=json_decode(file_get_contents("https://www.google.com/recaptcha/api/siteverify?secret=".$omise_captcha_secret."&response=".$captcha."&remoteip=".$_SERVER['REMOTE_ADDR']), true);
						if($response['success'] == false)
						{ echo '<h3>'.IPAYMENTPROM::CAPTCHA_CAPTION_WRONG.'</h3>';exit; }

				}

			$myPostArgs = filter_input_array(INPUT_POST);
			if (Stamp_log_payment($myPostArgs)=="1") { // Success
				$includeHTML = fn_display_qrcode();
			} else {
				$includeHTML = file_get_contents(plugins_url('/template/_tmp_error.html',PLUGIN_FILE_URL ));
			}
			$FormLayout .=$includeHTML;
				

		} else {
		
			
			$includeHTML = file_get_contents(plugins_url('/template/_tmp_form.html',PLUGIN_FILE_URL ));
		
			$FormLayout .="<div class=\"form\">";
			$FormLayout .="<form id='new_order' action='' method='post'>";

			if (get_option( '_iPAYMENT_CAPTCHA_FLAG' ,'true')) {
				$FormLayout .="<script src='https://www.google.com/recaptcha/api.js'></script>";	
				$omise_captcha_key =  get_option( '_iPAYMENT_CAPTCHA_KEY' ,'');		
				$omise_public_key =  get_option( '_iPAYMENT_CAPTCHA_SECRET' ,'');		

					// Replace DIV
					$DIV_CAPTCHA ="<div id=\"recaptcha\"><div class=\"g-recaptcha\" data-sitekey='$omise_captcha_key'></div></div><p>";
					$includeHTML = str_replace("{CAPTCHA}", $DIV_CAPTCHA, $includeHTML);				
					$includeHTML = str_replace("{PUBLICKEY}", $omise_public_key , $includeHTML);				
			} else {
				$includeHTML = str_replace("{CAPTCHA}", "<div class='column one-third'>&nbsp;</div>", $includeHTML); // ปิด Captcha
			}
			
			$FormLayout .=$includeHTML;
			$FormLayout .="</form></div>";

			$newUniqid = Generate_UNIQID();
			$addon = "<script>jQuery(\"input[name*='".IPAYMENTPROM::KEY_REFID."']\").val(\"$newUniqid\");jQuery(\"input[name*='".IPAYMENTPROM::KEY_REFID."']\").attr('readonly', true);</script>";
			$FormLayout = $FormLayout.$addon;		
		}

	  return $FormLayout; 
}

function ipayment_shortcodes_init()
{
	add_shortcode('ipayment_form', 'ipayment_shortcode');
	
}
 
add_action('init', 'ipayment_shortcodes_init');


//phpinfo();
?>