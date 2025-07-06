<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Site extends MY_Controller {
    public function __construct(){
		parent::__construct();
		$this->load_global();
		$this->load->model('site_model');
	}
	public function index(){
		$this->permission_check('site_edit');
        $data=$this->site_model->get_details();
        $data['page_title']=$this->lang->line('site_settings');
		$this->load->view('site-settings', $data);
	}

	public function update_site(){
		$this->form_validation->set_rules('site_name', 'Site Name', 'trim|required');
		if ($this->form_validation->run() == TRUE) {
			$result=$this->site_model->update_site();
			echo $result;
		} else {
			echo "Please Enter Compulsary(* marked) fields!";
		}
	}
	
	public function reset_all_point(){
	    $result=$this->site_model->reset_all_point();
	    echo $result;
	}
	public function reset_all_data($items, $sales, $return, $logs){
	    $result=$this->site_model->reset_all_data($items, $sales, $return, $logs);
	    echo $result;
	}
	public function remap_all_data(){
	    $result=$this->site_model->remap_all_data();
	    echo $result;
	}
	public function order_ok($orderid){
	    $result=$this->site_model->order_ok($orderid);
	    echo $result;
	}
	public function langauge($id){
		$this->load->model('language_model');
        $this->language_model->set($id);
        redirect($_SERVER['HTTP_REFERER']);
	}
}
