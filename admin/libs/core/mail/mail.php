<?php
defined('APP_EXEC') or die ('Restricted Access');

require_once(LIB_PATH . "/phpMailer/class.phpmailer.php");
require_once(LIB_PATH . "/phpMailer/class.pop3.php");
require_once(LIB_PATH . "/phpMailer/class.smtp.php");
	

//$mail = new PHPMailer();
class Mail extends PHPMailer{
	private $_site_name = '';
	private $_host = '';
	private $_port = 25;
	private $_username = '';
	private $_password = '';
	private $_from = '';
	private $_from_name = '';
	private $_to = '';
	private $_to_name= '';
	private $_reply = '';
	private $_reply_name= '';
	private $_subject = '';
	private $_body = '';
	
	public function __construct(){
		$settings = new Settings();
		$options = $settings->get();
		$this->_site_name = $options->site_name;
		$this->_username = $options->mail_username;
		$this->_password = $options->mail_password;
		$this->_port = $options->mail_port;
		$this->_host = $options->mail_host;
		
		parent::__construct(true);
	}
	
	public function host($host='', $port=false, $user='', $password=''){
		if($host){
			$this->_host = $host;
		}
		if($port){
			$this->_port = $port;
		}
		if($user){
			$this->_username = $user;
		}
		if($password){
			$this->_password = $password;
		}
	}
	
	public function subject($subject){
		$this->_subject = $subject;
	}
	
	public function body($body){
		$this->_body = "<html><head><title>{$this->_subject}</title></head><body>{$body}</body></html>";
	}
	
	public function to($mail, $name){
		$this->_to = $mail;
		$this->_to_name = $name;
	}
	
	public function from($mail, $name){
		$this->_from = $mail;
		$this->_from_name = $name;
	}
	
	public function reply($mail, $name){
		$this->_reply = $mail;
		$this->_reply_name = $name;
	}
	
	public function send(){
		//$mail = new PHPMailer(true); 
		//$this->IsSMTP();      
		$this->Host     = $this->_host;
		$this->Port     = $this->_port;
		$this->SMTPAuth = true;
		$this->Username = $this->_username;
		$this->Password = $this->_password;

		try {
			$this->AddAddress($this->_to, $this->_to_name);
			if(!empty($this->_from)){
				$this->SetFrom($this->_from, $this->_from_name);
			}else{
				$admin_title = "Admin {$this->_site_name}";
				$this->SetFrom($this->_username, $admin_title);
			}
			if($this->_reply){
				$this->AddReplyTo($this->_reply, $this->_reply_name);
			}
			$this->Subject = $this->_subject;
			$this->AltBody = 'To view the message, please use an HTML compatible email viewer!'; // optional - MsgHTML will create an alternate automatically
			//$this->MsgHTML(file_get_contents('index.htm'));
			//$this->AddAttachment('images/phpmailer.gif');      // attachment
			//$this->AddAttachment('images/phpmailer_mini.gif'); // attachment

			$this->MsgHTML($this->_body);
			$this->IsHTML(true); // send as HTML
			parent::Send();
			$message = '<span class="message">Message Sent OK</span>';
			Session::setMessages($message );
			return true;
		} catch (phpmailerException $e) {
			$message = '<span class="message">' . $e->errorMessage() .  '</span>'; //Pretty error messages from PHPMailer
			Session::setMessages($message );
			return false;
		} catch (Exception $e) {
			$message = '<span class="message">' . $e->getMessage() .  '</span>'; //Boring error messages from anything else!
			Session::setMessages($message );
			return false;	
		}
			
	}

}

?>