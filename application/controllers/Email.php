<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Email extends MY_Controller {
	public function __construct(){
		parent::__construct();
		$this->load_global();
	}
	
	//Open SMS Form 
	public function index(){
		$this->permission_check('send_email');
		$data=$this->data;
		$data['page_title']='Gửi Email';
		$this->load->view('email', $data);
	}


	//Create Message
	public function send_email(){
		$this->permission_check('send_email');
		$data=$this->data;
		$this->load->model('email_model');
		extract($this->security->xss_clean(html_escape($_POST)));
		$result= $this->email_model->send_emails($mobile,$subject,$message);
		echo $result;
	}
}

