<?php

include('Clickatell.php'); //sms getway

// Import PHPMailer classes into the global namespace
// These must be at the top of your script, not inside a function
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

// Load Composer's autoloader
require(__DIR__.'/phpmailer/vendor/autoload.php');

class ams_helper {
	
	/** @Language default value */
	protected $_lang_code = "English";
	
	/** @currency default value */
	protected $_currency = "$";
	
	/** @currency position default value */
	protected $_currency_position = "left";
	
	/** @currency seperate default value */
	protected $_currency_seperate = ".";
	
	/** @currency decimal default value */
	protected $_currency_decimal = 2;
	
	/*
	* @param number value
	* @param localization object
	*/
	public function currency($localization, $value=0) {
		$_return = '';
		if(!empty($localization)){
			if(isset($localization['currency_position'])){
				$this->_currency_position = $localization['currency_position'];
			}
			if(isset($localization['currency'])){
				$this->_currency = $localization['currency'];
			}
			if(isset($localization['currency_seperator'])){
				$this->_currency_seperate = $localization['currency_seperator'];
			}
			if(isset($localization['currency_decimal'])){
				$this->_currency_decimal = $localization['currency_decimal'];
			}
		}
		if($this->_currency_position=="left"){
			return $this->_currency.number_format($value+0, $this->_currency_decimal, $this->_currency_seperate, '');
		} else if($this->_currency_position=="right"){
			return number_format($value, $this->_currency_decimal, $this->_currency_seperate, '').$this->_currency;
		}
		return $this->_currency.number_format($value, $this->_currency_decimal, $this->_currency_seperate, '');
	}
	
	/*
	* @datepicker to mysql date conversion
	*/
	public function datepickerDateToMySqlDate($date) {
		$cdate = '0000-00-00';
		if(!empty($date)) {
			$x =  explode('/',$date);
			$cdate = $x[2].'-'.$x[1].'-'.$x[0];
		}
		return $cdate;
	}
	
	/*
	* @mysql to datepicker conversion
	*/
	public function mySqlToDatePicker($date) {
		$cdate = '';
		if(!empty($date)) {
			$x =  explode('-',$date);
			$cdate = $x[2].'/'.$x[1].'/'.$x[0];
		}
		return $cdate;
	}
	
	/*
	* @days calculate from and to days
	*/
	public function daysBetween($dt1, $dt2) {
		return date_diff(
			date_create($dt2),  
			date_create($dt1)
		)->format('%a');
	}
	
	/*
	* @get page url
	*/
	public function curPageUrlInfo($type) {
		$pageURL = 'http';
	 	if (isset($_SERVER["HTTPS"]) && $_SERVER["HTTPS"] == "on") {$pageURL .= "s";}
	 	$pageURL .= "://";
	 	if ($_SERVER["SERVER_PORT"] != "80") {
	  		$pageURL .= $_SERVER["SERVER_NAME"].":".$_SERVER["SERVER_PORT"].$_SERVER["REQUEST_URI"];
	 	} else {
	  		$pageURL .= $_SERVER["SERVER_NAME"].$_SERVER["REQUEST_URI"];
	 	}
		$page_name = pathinfo($pageURL, PATHINFO_FILENAME);
	 	if($type=='url'){
			return $pageURL;
		} else {
			return $page_name;	
		}
	}
	/*
	* @send email
	*/
	public function sendEmail($localization, $to, $subject, $msg) {
		$image_building = '';
		if(!empty($_SESSION['objLogin']['building_image'])){
			$image_building = WEB_URL . 'img/upload/'.$_SESSION['objLogin']['building_image'];
		}
		$variables = array(
			'logo'		=> $image_building,
			'name'		=> $_SESSION['objLogin']['branch_name'],
			'subject'	=> $subject,
			'message'	=> $msg,
			'site_url'	=> WEB_URL
		);
		$msg = $this->loadEmailTemplate('tmp_common.html', $variables);
		if($localization['mail_protocol']=='mail'){
			$headers = "From: " . strip_tags($_SESSION['objLogin']['b_email']) . "\r\n";
			$headers .= "Reply-To: ". strip_tags($_SESSION['objLogin']['b_email']) . "\r\n";
			//$headers .= "CC: susan@example.com\r\n";
			$headers .= "MIME-Version: 1.0\r\n";
			$headers .= "Content-Type: text/html; charset=ISO-8859-1\r\n";
			$message = $msg;
			mail($to, $subject, $message, $headers);
		} else {
			$this->sendEmailByPhpMailer($localization, $to, $subject, $msg);
		}
	}
	
	/**
	 * ClickATel SMS only
	 *
	 * @param  phone no string  $phone_no
	 * @param  message string  $message
	 * @return message Response
	 */
	public function sendSMS($localization, $phone_no, $message) {
		if(!empty($phone_no) && !empty($localization['cat_apikey'])){
			$username = $localization['cat_username'];
			$password = $localization['cat_password'];
			$apiID = $localization['cat_apikey'];
			$params = array('apiToken' => $apiID);
			$clickatell = new Clickatell($params);
			$response = $clickatell->sendMessage(['to' => [$phone_no],'content' => $message]);
			foreach ($response as $message) { 
				 return $message[0];
				 break;
			}
		} else {
			return -1;
		}
	}
	
	/**
	 * PHP Mailer
	 */
	 public function sendEmailByPhpMailer($localization, $to, $subject, $msg){
		
		if(!empty($localization['smtp_hostname']) && !empty($localization['smtp_username']) && !empty($localization['smtp_password'])){
			// Instantiation and passing `true` enables exceptions
			
			$mail = new PHPMailer(true);
			
			try {
				//Server settings
				//$mail->SMTPDebug = 2;                                       // Enable verbose debug output
				$mail->isSMTP();                                            // Set mailer to use SMTP
				$mail->Host       = $localization['smtp_hostname'];  		// Specify main and backup SMTP servers
				$mail->SMTPAuth   = true;                                   // Enable SMTP authentication
				$mail->Username   = $localization['smtp_username'];                     // SMTP username
				$mail->Password   = $localization['smtp_password'];                               // SMTP password
				$mail->SMTPSecure = $localization['smtp_secure'];                                  // Enable TLS encryption, `ssl` also accepted
				$mail->Port       = $localization['smtp_port'];                                    // TCP port to connect to
			
				//Recipients
				$mail->setFrom($_SESSION['objLogin']['b_email'], $_SESSION['objLogin']['branch_name']);
				$mail->addAddress($to, '');     // Add a recipient
				//$mail->addAddress('ellen@example.com');               // Name is optional
				$mail->addReplyTo($_SESSION['objLogin']['b_email'], $_SESSION['objLogin']['branch_name']);
				//$mail->addCC('cc@example.com');
				//$mail->addBCC('bcc@example.com');
			
				// Attachments
				//$mail->addAttachment('/var/tmp/file.tar.gz');         // Add attachments
				//$mail->addAttachment('/tmp/image.jpg', 'new.jpg');    // Optional name
			
				// Content
				$mail->isHTML(true);                                  // Set email format to HTML
				$mail->Subject = $subject;
				$mail->Body = $msg;
				//$mail->AltBody = 'This is the body in plain text for non-HTML mail clients';
				
				$mail->SMTPOptions = array(
					'ssl' => array(
						'verify_peer' => false,
						'verify_peer_name' => false,
						'allow_self_signed' => true
					)
				);
			
				$mail->send();
				//echo 'Message has been sent';
			} catch (Exception $e) {
				echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
				die();
			}
		}
	 }
	 
	 //email body builder
	 public function loadEmailTemplate($temp_name, $variables = array()) {
		$template = file_get_contents(ROOT_PATH."partial/email_templates/".$temp_name);
		foreach($variables as $key => $value){
			$template = str_replace('{{ '.$key.' }}', $value, $template);
		}
		return $template;
	}
	
	//remove install folder
	public function removeInstallFolder($dir) {
		foreach (glob($dir) as $file) {
			if (is_dir($file)) { 
				self::removeInstallFolder("$file/*");
				rmdir($file);
			} else {
				unlink($file);
			}
		}
	}	
}

?>