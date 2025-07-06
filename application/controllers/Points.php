<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Points extends MY_Controller {
	public function __construct(){
		parent::__construct();
		$this->load_global();
		$this->load->model('points_model','points');
	}

	public function index()
	{
		$this->permission_check('customers_point');
		$data=$this->data;
		$data['page_title']='Lịch sử hệ thống';
		$this->load->view('point',$data);
	}

	public function ajax_list()
	{
		$list = $this->points->get_datatables();
		
		$data = array();
		$no = $_POST['start'];
		foreach ($list as $customers) {
			$no++;
			$row = array();
			$row[] = $customers->id;
			$row[] = ($customers->customer_id == 0) ? 'Admin' : get_customer_name_by_customer_id($customers->customer_id);
			$row[] = $customers->point_last;
			$row[] = $customers->point_value;
			$row[] = (substr($customers->point_info, 0,1) == '*') ? '----' : $customers->point_last + $customers->point_value;
			$row[] = date('d/m/Y h:m:s', $customers->point_date);;
			$row[] = $customers->point_info;
			$data[] = $row;
		}

		$output = array(
						"draw" => $_POST['draw'],
						"recordsTotal" => $this->points->count_all(),
						"recordsFiltered" => $this->points->count_filtered(),
						"data" => $data
				);
		echo json_encode($output);
	}
	
	public function ajax_point_list()
	{
		//$list = $this->customers->get_datatables_point();
		echo 'hello';
		/*
		$data = array();
		$no = $_POST['start'];
		foreach ($list as $customers) {
			$no++;
			$row = array();
			
			$row[] = $no;
			$row[] = $customers->customer_id;
			$row[] = $customers->point_last;
			$row[] = $customers->point_value;
			$row[] = $customers->point_date;
			$row[] = $customers->point_info;

			$data[] = $row;
		}

		$output = array(
						"draw" => $_POST['draw'],
						"recordsTotal" => $this->customers->count_all(),
						"recordsFiltered" => $this->customers->count_filtered(),
						"data" => $data,
				);
		//output to json format
		echo json_encode($output);*/
	}


}
