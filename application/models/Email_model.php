<?php
defined('BASEPATH') OR exit('No direct script access allowed');

//define('RK_ROOT', dirname(__FILE__));
        //require RK_ROOT . "/Mailer/PHPMailer.php";
        //require RK_ROOT . "/Mailer/Exception.php";
        //require RK_ROOT . "/Mailer/OAuth.php";
        //require RK_ROOT . "/Mailer/POP3.php";
        //require RK_ROOT . "/Mailer/SMTP.php";
        
        //use PHPMailer\PHPMailer\PHPMailer;
        //use PHPMailer\PHPMailer\Exception;

class Email_model extends CI_Model {

	public function xss_html_filter($input){
		return $this->security->xss_clean(html_escape($input));
	}
	
	//Send Email
	public function send_emails($mobile,$subject,$message){
                
                $this->load->library('email');
                $config = array();
                $config['protocol'] = 'smtp';
                $config['smtp_host'] = 'mail.privateemail.com';
                $config['smtp_user'] = 'support@vnac.vn';
                $config['smtp_pass'] = 'Vn@c123support';
                $config['smtp_port'] = 465;
                $config['smtp_crypto'] = 'ssl';
                $config['mailtype'] = 'html';
                $config['smtp_timeout'] = '4';
                $config['charset'] = 'utf-8';
                $config['wordwrap'] = TRUE;
                $this->email->initialize($config);
                
                
                $from = 'support@vnac.vn';
                
                $this->email->set_newline("\r\n");
                $this->email->from($from);
                $this->email->to($mobile);
                $this->email->subject($subject);
                $this->email->message($message);
                
                
                if ($this->email->send()) {
                    return 'success';
                } else {
                    return 'failed';
                }
        
	}

}

/* End of file Sms_model.php */
/* Location: ./application/models/Sms_model.php */