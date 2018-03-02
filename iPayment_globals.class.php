<?php

	class IPAYMENTPROM{

		
		const TABLE_MASTER_PAYMENT_LOG = "payment_master_prom_log";

		const PLUGIN_FOLDER_NAME = "ipayment";
		
		//const STATUS_0 = 'Wait';
	    //const STATUS_1 = 'successful';
		//const STATUS_2 = 'Unsuccessful';

		
		const MAIL_SENDER_DEFAULT = "weeraphan@csloxinfo.net";

		const LIST_ORDER_PER_PAGE = 10; /// กำหนดจำนวน order 
		

		///// CAPTCHA CONFIG

		//const CAPTCHAFLAG = true ; // true Enable / false Disabled 
		//const CAPTCHAKEY = "6Lf47ykTAAAAAKKFbC_adQhEo0MXwV8zh4uffaVm";
		//const CAPTCHASECRETKEY = "6Lf47ykTAAAAAI17dcc2qR8PD9RsCM3liYQ_HC8N";
		
		const CAPTCHA_CAPTION_EMPTY = "Please check the the captcha form.";
		const CAPTCHA_CAPTION_WRONG = "You are spammer!!! ";

		}

?>