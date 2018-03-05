<?php

function fn_IPAYMENTPROM_config() {


	if (isset($_POST['update'])) {
		delete_option('_iPAYMENT_PROMP_FLAG');		
		delete_option('_iPAYMENT_PROMP_ID');		
		delete_option('_iPAYMENT_MAIL_SENDER');
		delete_option('_iPAYMENT_MAIL_NOTI');		
		delete_option('_iPAYMENT_CAPTCHA_FLAG');		
		delete_option('_iPAYMENT_CAPTCHA_KEY');		
		delete_option('_iPAYMENT_CAPTCHA_SECRET');		
		add_option( '_iPAYMENT_PROMP_FLAG', $_POST["ipayment_promp_flag"] );
		add_option( '_iPAYMENT_PROMP_ID', $_POST["ipayment_promp_id"] );
		add_option( '_iPAYMENT_MAIL_SENDER', $_POST["ipayment_mail_sender"] );
		add_option( '_iPAYMENT_MAIL_NOTI', $_POST["ipayment_mail_noti"] );
		add_option( '_iPAYMENT_CAPTCHA_FLAG', $_POST["ipayment_captcha_flag"] );
		add_option( '_iPAYMENT_CAPTCHA_KEY', $_POST["ipayment_captcha_key"] );
		add_option( '_iPAYMENT_CAPTCHA_SECRET', $_POST["ipayment_captcha_secret"] );
		$message.="Update Complete";
	} else if (isset($_POST['reset'])) {
		if (Truncate_table_log_payment()) {
			$message = "Truncate table success";
		} else {
			$message = "Error!!!";
		}
	}


  ?>
    <link type="text/css" href="<?php echo WP_PLUGIN_URL; ?>/<?php echo IPAYMENTPROM::PLUGIN_FOLDER_NAME;?>/css/style-admin.css" rel="stylesheet" />
    <div class="wrap">

		<?php if (isset($message)): ?><div class="updated"><p><?php echo $message; ?></p></div><?php endif; ?>
        <h2>Config Omise</h2>        		
		<?php
		$ipayment_promp_flag =  get_option( '_iPAYMENT_PROMP_FLAG' ,'1');
			//$check1 = ""; $check2 = "";
			($ipayment_promp_flag=="1")? $check1 = "selected" : $check2 = "selected";			
		$ipayment_promp_id =  get_option( '_iPAYMENT_PROMP_ID' ,'');	
		$ipayment_mail_sender =  get_option( '_iPAYMENT_MAIL_SENDER' ,'');
		$ipayment_mail_noti =  get_option( '_iPAYMENT_MAIL_NOTI' ,'1');		
		$ipayment_captcha_flag =  get_option( '_iPAYMENT_CAPTCHA_FLAG' ,'true');		
		$ipayment_captcha_key =  get_option( '_iPAYMENT_CAPTCHA_KEY' ,'');		
		$ipayment_captcha_secret =  get_option( '_iPAYMENT_CAPTCHA_SECRET' ,'');
		?>
		
			<form method="post" action="<?php echo $_SERVER['REQUEST_URI']; ?>">
                <table class='wp-list-table widefat fixed'>
					<tr><th>Prompay Flag</th><td>
					<select name="ipayment_promp_flag">
						<option value="1" <?php echo $check1;?> >Mobile Phone</option> 
						<option value="2" <?php echo $check2;?> >Id Card</option>
					</td></tr>
					<tr><th>Prompay Phone number</th><td><input size='50' type="text" name="ipayment_promp_id" value="<?php echo $ipayment_promp_id; ?>"/></td></tr>
					<tr><td colspan='2'><hr></td></tr>
					<tr><th>Mail Service</th><td><input type="checkbox" value='1' name="ipayment_mail_noti" <?=($ipayment_mail_noti==1)?"checked":""?>/>on (checked)</td></tr>
					<tr><th>Mail Sender</th><td><input size='50' type="text" name="ipayment_mail_sender" value="<?php echo $ipayment_mail_sender; ?>"/></td></tr>
					<tr><td colspan='2'><hr></td></tr>
  					<tr><th>Google Captcha</th><td><input type="checkbox" value='true' name="ipayment_captcha_flag" <?=($ipayment_captcha_flag==true)?"checked":""?>/>on (checked)</td></tr>
					<tr><th>KEY</th><td><input size='50' type="text" name="ipayment_captcha_key" value="<?php echo $ipayment_captcha_key; ?>"/></td></tr>
					<tr><th>Secret</th><td><input size='50' type="text" name="ipayment_captcha_secret" value="<?php echo $ipayment_captcha_secret; ?>"/></td></tr>
					<tr>
						<td colspan="2"><input type='submit' name="update" value='Save' class='button'> 
						</td>
					</tr>
				</table>            
            </form>

		<h2>Reset All Order</h2>
			<form method="post" action="<?php echo $_SERVER['REQUEST_URI']; ?>">
			<table class='wp-list-table widefat fixed'><tr><td>
			<input type='submit' name="reset" value='reset' class='button' onclick="return confirm(' Reset All Order ? ')">
			</td></tr></table>
            </form>

    </div>
    <?php

}