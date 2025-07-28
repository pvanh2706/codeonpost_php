<?php
defined('BASEPATH') OR exit('No direct script access allowed');

use Dompdf\Dompdf;
use Dompdf\Options;

class Sales extends MY_Controller {
	public function __construct(){
		parent::__construct();
		$this->load_global();
		$this->load->model('sales_model','sales');
		$this->load->helper('sms_template_helper');
	}

	public function is_sms_enabled(){
		return is_sms_enabled();
	}

	public function index()
	{
		$this->permission_check('sales_view');
		$data=$this->data;
		$data['page_title']=$this->lang->line('sales_list');
		$this->load->view('sales-list',$data);
	}
	public function add()
	{	
		$this->permission_check('sales_add');
		$data=$this->data;
		$data['page_title']=$this->lang->line('sales');
		$this->load->view('sales',$data);
	}
	
	public function stock()
	{	
		$this->permission_check('items_stock');
		$data=$this->data;
		$data['page_title']='Kiểm đếm sản phẩm';
		$this->load->view('items-stock',$data);
	}
	

	public function sales_save_and_update(){
		$this->form_validation->set_rules('sales_date', 'Sales Date', 'trim|required');
		$this->form_validation->set_rules('customer_id', 'Customer Name', 'trim|required');
		
		if ($this->form_validation->run() == TRUE) {
	    	$result = $this->sales->verify_save_and_update();
	    	echo $result;
		} else {
			echo "Please Fill Compulsory(* marked) Fields.";
		}
	}
	
	
	public function update($id){
		$this->permission_check('sales_edit');
		$data=$this->data;
		$data=array_merge($data,array('sales_id'=>$id));
		$data['page_title']=$this->lang->line('sales');
		$this->load->view('sales', $data);
		//debug_to_console($data);
	}
	

	public function ajax_list()
	{
		$list = $this->sales->get_datatables();
		
		$data = array();
		$no = $_POST['start'];
		foreach ($list as $sales) {
			
			$no++;
			$row = array();
			$row[] = '<input type="checkbox" name="checkbox[]" value='.$sales->id.' class="checkbox column_checkbox" >';
			

			//$info = (!empty($sales->return_bit)) ? "\n<span class='label label-danger' style='cursor:pointer'><i class='fa fa-fw fa-undo'></i>Trả hàng</span>" : '';
			$info = (!empty($sales->return_bit)) ? ' | <a style="color: red;" href="sales_return/invoice/' . $sales->return_bit . '" target="_Blank"><i class="fa fa-fw fa-undo"></i>Trả hàng - Hoàn tiền</a>' : '';

            

			        $stt='';
			        $invoicelink ='';
			        $order_price_levels = '';
			        $isPos = '';
			        ($sales->pos == 1) ? $isPos = 'POS - ' : $isPos = '';
			        
			        if ($sales->sales_status == 'Final') {
			            $stt = "<span class='label label-success' style='cursor:pointer'>" . $isPos . "Đã giao hàng</span>";
			            $invoicelink = '<a href="sales/invoice/'.$sales->id.'" target="_Blank">'.$sales->sales_code.'</a>';
			        } elseif($sales->sales_status == 'Quotation') {
			            //$stt = $sales->sales_status;
			            $stt = "<span class='label label-warning' style='cursor:pointer'>" . $isPos . "Đang giao dịch</span>";
			            $invoicelink = '<a href="sales/update/'.$sales->id.'" target="_Blank">'.$sales->sales_code.'</a>';
			        } elseif($sales->sales_status == 'Shipping') {
			                $stt = "<span class='label label-info' style='cursor:pointer'>" . $isPos . "Đã xuất kho - Đang giao hàng</span>";
			                $invoicelink = '<a href="sales/invoice/'.$sales->id.'" target="_Blank">'.$sales->sales_code.'</a>';
			            
			            //$stt = $sales->sales_status;
			            
			        } else {
			            $stt = "<span class='label label-info' style='cursor:pointer'>" . $isPos . "Đang xử lý</span>";
			            $invoicelink = '<a href="sales/invoice/'.$sales->id.'" target="_Blank">'.$sales->sales_code.'</a>';
			        }
			//$row[] = $sales->sales_code.$info;
			        switch ($sales->order_price_level) {
			            case '0':
			                $order_price_levels = 'Chính sách giá Cấp 0'; break;
			                case '1':
			                $order_price_levels = 'Chính sách giá Cấp 1'; break;
			                case '2':
			                $order_price_levels = 'Chính sách giá Cấp 2'; break;
			                case '3':
			                $order_price_levels = 'Chính sách giá Cấp 3'; break;
			                default:
			                $order_price_levels = 'Chính sách giá lẻ'; break;
			         
			        }
			
		
			
			$row[] = 'Ngày ' . show_date($sales->sales_date) . '<br>Người bán: <span style="color: blue;">' . ucfirst($sales->created_by) . '</span>'   ;
			$row[] =  $isPos . $invoicelink . $info . '<br>' . $order_price_levels;
			//$row[] = ($sales->reference_no != null) ? $sales->reference_no : 'N/A';
			$row[] = $sales->customer_name . '<br><small style="display: none;">'. $sales->customer_name_en .'</small>';
			//$row[] = $sales->warehouse_name;
			$row[] = app_number_format($sales->grand_total);
			$row[] = app_number_format($sales->paid_amount);
			$row[] = app_number_format($sales->sales_due);
					$str='';
					if($sales->payment_status=='Unpaid')
			          $str= "<span class='label label-danger' style='cursor:pointer'>Ghi công nợ </span>";
			        if($sales->payment_status=='Partial')
			          $str="<span class='label label-warning' style='cursor:pointer'>Chỉ trả 1 phần </span>";
			        if($sales->payment_status=='Paid')
			          $str="<span class='label label-success' style='cursor:pointer'>Đã thanh toán </span>";
            $row[] = $stt;
			$row[] = $str;
			//$row[] = ucfirst($sales->created_by);

					 /*if($sales->pos ==1):
					 	$str1='pos/edit/';
					 else:
					 	$str1='sales/update/';
					 endif;*/
                    $str1='sales/update/';
					$str2 = '<div class="btn-group" title="View Account">
										<a class="btn btn-primary btn-o dropdown-toggle" data-toggle="dropdown" href="#">
											Thao tác <span class="caret"></span>
										</a>
										<ul role="menu" class="dropdown-menu dropdown-light pull-right">';
											

											if($this->permissions('sales_edit') && $sales->sales_status == 'Quotation')
											$str2.='<li>
												<a title="Update Record ?" href="'.$str1.$sales->id.'">
													<i class="fa fa-fw fa-edit text-blue"></i>Sửa hóa đơn
												</a>
											</li>';
											
											if($this->permissions('sales_view'))
											$str2.='<li>
												<a title="View Invoice" href="sales/invoice/'.$sales->id.'" >
													<i class="fa fa-fw fa-eye text-blue"></i>Xem chi tiết
												</a>
											</li>';

											if($this->permissions('sales_payment_view') && $sales->sales_status != 'Quotation')
											$str2.='<li>
												<a title="Pay" class="pointer" onclick="view_payments('.$sales->id.')" >
													<i class="fa fa-fw fa-money text-blue"></i>Xem thanh toán
												</a>
											</li>';

                                            if ($sales->payment_status != 'Paid') {
                                                if($this->permissions('sales_payment_add'))
    											$str2.='<li>
    												<a title="Thanh toán" class="pointer" onclick="pay_now('.$sales->id.')" >
    													<i class="fa fa-fw fa-hourglass-half text-blue"></i>Nhận thanh toán
    												</a>
    											</li>';

                                            } else { 
                                                if ($sales->sales_status != 'Final') {
                                                    $str2.='<li>
        												<a title="Trạng thái" class="pointer" onclick="stt_now('.$sales->id.')" >
        													<i class="fa fa-fw fa-hourglass-half text-blue"></i>Hoàn thành đơn hàng
        												</a>
        											</li>';
                                                }
                                                
                                            }
											
											/*if($this->permissions('sales_add') || $this->permissions('sales_edit'))
											$str2.='<li>
												<a title="Update Record ?" target="_blank" href="sales/print_invoice/'.$sales->id.'">
													<i class="fa fa-fw fa-print text-blue"></i>In hóa đơn A4
												</a>
											</li>*/

											if($this->permissions('sales_add') || $this->permissions('sales_edit'))
											$str2.='<li>
												<a style="cursor:pointer" title="Print POS Invoice ?" onclick="print_invoice('.$sales->id.')">
													<i class="fa fa-fw fa-file-text text-blue"></i>In hóa đơn POS
												</a>
											</li>
											<!--li>
												<a title="Update Record ?" target="_blank" href="sales/pdf/'.$sales->id.'">
													<i class="fa fa-fw fa-file-pdf-o text-blue"></i>Xuất dạng PDF
												</a>
											</li-->';

											if($sales->sales_status=='Final' && $this->permissions('sales_return') && $this->session->userdata('inv_userid') == '1')
											$str2.='<li>
												<a title="Sales Return" href="sales_return/add/'.$sales->id.'">
													<i class="fa fa-fw fa-undo text-blue"></i>Khách trả hàng
												</a>
											</li>';

											if($this->permissions('sales_delete'))
											$str2.='<li>
												<a style="cursor:pointer" title="Delete Record ?" onclick="delete_sales(\''.$sales->id.'\')">
													<i class="fa fa-fw fa-trash text-red"></i>Xóa đơn bán
												</a>
											</li>
											
										</ul>
									</div>';			

			$row[] = $str2;

			$data[] = $row;
		}

		$output = array(
						"draw" => $_POST['draw'],
						"recordsTotal" => $this->sales->count_all(),
						"recordsFiltered" => $this->sales->count_filtered(),
						"data" => $data,
				);
		//output to json format
		echo json_encode($output);
	}
	public function update_status(){
		$this->permission_check('sales_edit');
		$id=$this->input->post('id');
		$status=$this->input->post('status');

		
		$result=$this->sales->update_status($id,$status);
		return $result;
	}
	public function delete_sales(){
		$this->permission_check_with_msg('sales_delete');
		$id=$this->input->post('q_id');
		echo $this->sales->delete_sales($id);
	}
	public function multi_delete(){
		$this->permission_check_with_msg('sales_delete');
		$ids=implode (",",$_POST['checkbox']);
		echo $this->sales->delete_sales($ids);
	}
	public function multi_paid(){
		$this->permission_check_with_msg('sales_delete');
		$ids=implode (",",$_POST['checkbox']);
		echo $this->sales->paid_sales($ids);
	}


	//Table ajax code
	public function search_item(){
		$q=$this->input->get('q');
		$result=$this->sales->search_item($q);
		echo $result;
	}
	public function find_item_details(){
		$id=$this->input->post('id');
		
		$result=$this->sales->find_item_details($id);
		echo $result;
	}

	//sales invoice form
	public function invoice($id)
	{	
		if(!$this->permissions('sales_add') && !$this->permissions('sales_edit')){
			$this->show_access_denied_page();
		}
		$data=$this->data;
		$data=array_merge($data,array('sales_id'=>$id));
		$data['page_title']=$this->lang->line('sales_invoice');
		$this->load->view('sal-invoice',$data);
	}
	
	//Print sales invoice 
	public function print_invoice($sales_id)
	{
		if(!$this->permissions('sales_add') && !$this->permissions('sales_edit')){
			$this->show_access_denied_page();
		}
		$data=$this->data;
		$data=array_merge($data,array('sales_id'=>$sales_id));
		$data['page_title']=$this->lang->line('sales_invoice');
		if(get_invoice_format_id()==3){
			$this->load->view('print-sales-invoice-3',$data);
		}
		else if(get_invoice_format_id()==2){
			$this->load->view('print-sales-invoice-2',$data);
		}
		else{
			$this->load->view('print-sales-invoice',$data);
		}
	}

	//Print sales POS invoice 
	public function print_invoice_pos($sales_id)
	{
		if(!$this->permissions('sales_add') && !$this->permissions('sales_edit')){
			$this->show_access_denied_page();
		}
		$data=$this->data;
		$data=array_merge($data,array('sales_id'=>$sales_id));
		$data['page_title']=$this->lang->line('sales_invoice');
		$this->load->view('sal-invoice-pos',$data);
	}
	

	public function pdf($sales_id){
		if(!$this->permissions('sales_add') && !$this->permissions('sales_edit')){
			$this->show_access_denied_page();
		}
		$this->load->model('pdf_model');

		$data=$this->data;
		$data['page_title']=$this->lang->line('sales_invoice');
        $data=array_merge($data,array('sales_id'=>$sales_id));
        if(get_invoice_format_id()==3){
			$this->load->view('print-sales-invoice-3',$data);
		}
		else if(get_invoice_format_id()==2){
			$this->load->view('print-sales-invoice-2',$data);
		}
		else{
			$this->load->view('print-sales-invoice',$data);
		}

        // Get output html
        $html = $this->output->get_output();

        $this->pdf_model->render($html,'Sales Invoice - '.$sales_id);
	}
	
	

	
	/*v1.1*/
	public function return_row_with_data($rowcount,$item_id){
		echo $this->sales->get_items_info($rowcount,$item_id);
	}
	public function return_row_with_data2($cusLvs,$rowcount,$item_id){
		echo $this->sales->get_items_info2($cusLvs,$rowcount,$item_id);
	}
	public function return_row_with_data3($rowcount,$item_id){
		echo $this->sales->get_items_info3($rowcount,$item_id);
	}
	public function return_sales_list($sales_id){
		echo $this->sales->return_sales_list($sales_id);
	}
	public function delete_payment(){
		$this->permission_check_with_msg('sales_payment_delete');
		$payment_id = $this->input->post('payment_id');
		echo $this->sales->delete_payment($payment_id);
	}
	public function show_pay_now_modal(){
		$this->permission_check_with_msg('sales_view');
		$sales_id=$this->input->post('sales_id');
		echo $this->sales->show_pay_now_modal($sales_id);
	}
	public function show_stt_now_modal(){
		$this->permission_check_with_msg('sales_view');
		$sales_id=$this->input->post('sales_id');
		echo $this->sales->show_stt_now_modal($sales_id);
	}
	public function show_stt_final_now_modal(){
		$this->permission_check_with_msg('sales_view');
		$sales_id=$this->input->post('sales_id');
		echo $this->sales->show_stt_final_now_modal($sales_id);
	}
	public function show_stt_shipping_now_modal(){
		$this->permission_check_with_msg('sales_view');
		$sales_id=$this->input->post('sales_id');
		echo $this->sales->show_stt_shipping_now_modal($sales_id);
	}
	public function save_payment(){
		$this->permission_check_with_msg('sales_add');
		echo $this->sales->save_payment();
	}
	public function save_stt(){
		$this->permission_check_with_msg('sales_add');
		echo $this->sales->save_stt();
	}
	public function save_stt_final(){
		$this->permission_check_with_msg('sales_add');
		echo $this->sales->save_stt_final();
	}
	public function save_stt_shipping(){
		$this->permission_check_with_msg('sales_add');
		echo $this->sales->save_stt_shipping();
	}
	
	// Method để lấy thông tin thanh toán cập nhật
	public function get_payment_info(){
		$this->permission_check_with_msg('sales_view');
		$sales_id = $this->input->post('sales_id');
		
		if(!$sales_id) {
			echo json_encode(['success' => false, 'message' => 'Invalid sales ID']);
			return;
		}
		
		// Lấy thông tin thanh toán
		$q3 = $this->db->query("select * from db_salespayments where sales_id=$sales_id");
		$payment_rows = '';
		
		if($q3->num_rows()>0){
			$i=1;
			$total_paid = 0;
			foreach ($q3->result() as $res3) {
				$payment_rows .= "<tr class='text-center text-bold' id='payment_row_".$res3->id."'>";
				$payment_rows .= "<td>".$i++."</td>";
				$payment_rows .= "<td>".show_date($res3->payment_date)."</td>";
				$payment_rows .= "<td class='text-right'>".number_format($res3->payment, 0, ',', '.') . ' ₫'."</td>";
				$payment_rows .= "<td>".$res3->payment_type."</td>";
				$payment_rows .= "<td>".$res3->payment_note."</td>";
				$payment_rows .= "</tr>";
				$total_paid +=$res3->payment;
			}
			$payment_rows .= "<tr class='text-right text-bold'><td colspan='4' >Tổng thanh toán </td><td>".number_format($total_paid, 0, ',', '.') . ' ₫'."</td></tr>";
		}
		else{
			$payment_rows = "<tr><td colspan='5' class='text-center text-bold'>Chưa có thanh toán nào cho hóa đơn này!!</td></tr>";
		}
		
		echo json_encode(['success' => true, 'payment_rows' => $payment_rows]);
	}
	
	// Method để kiểm tra trạng thái thanh toán
	public function check_payment_status(){
		$this->permission_check_with_msg('sales_view');
		$sales_id = $this->input->post('sales_id');
		
		if(!$sales_id) {
			echo json_encode(['success' => false, 'message' => 'Invalid sales ID']);
			return;
		}
		
		// Lấy thông tin hóa đơn
		$q = $this->db->query("SELECT payment_status, grand_total, paid_amount FROM db_sales WHERE id=$sales_id");
		if($q->num_rows() > 0) {
			$res = $q->row();
			
			echo json_encode([
				'success' => true, 
				'payment_status' => $res->payment_status,
				'grand_total' => $res->grand_total,
				'grand_total_formatted' => number_format($res->grand_total, 0, ',', '.') . ' ₫',
				'paid_amount' => $res->paid_amount
			]);
		} else {
			echo json_encode(['success' => false, 'message' => 'Sales not found']);
		}
	}
	
	public function get_order_details() {
		$this->permission_check('sales_view');
		
		$order_ids = $this->input->post('order_ids');
		
		if (!$order_ids || !is_array($order_ids)) {
			$response = array(
				'success' => false,
				'message' => 'Không có đơn hàng nào được chọn'
			);
			echo json_encode($response);
			return;
		}
		
		try {
			// Load site model để lấy cấu hình hóa đơn điện tử
			$this->load->model('site_model', 'site');
			
			// Thêm các cột E-invoice vào bảng db_sales nếu chưa có
			$this->site->add_einvoice_fields_to_sales_table();
			
			// Lấy cấu hình hóa đơn điện tử
			$einvoice_config = $this->site->get_einvoice_config();

			// Lấy thông tin hóa đơn điện tử
			$einvoice_data = $this->site->get_einvoice_data($order_ids);

			// Khởi tạo và lấy danh sách mẫu số và ký hiệu
			$this->site->init_default_einvoice_templates();
			$einvoice_templates = $this->site->get_einvoice_templates();
			
			// Khởi tạo và lấy danh sách phương thức thanh toán
			$this->site->init_default_einvoice_payments();
			$einvoice_payments = $this->site->get_einvoice_payments();
			
			$orders = array();
			
			foreach ($order_ids as $order_id) {
				// Lấy thông tin đơn hàng
				$order_query = $this->db->query("
					SELECT s.*, c.customer_name, c.mobile, c.address, c.sales_due as due_amount, u.username as created_by
					FROM db_sales s
					LEFT JOIN db_customers c ON s.customer_id = c.id
					LEFT JOIN db_users u ON s.created_by = u.id
					WHERE s.id = ?
				", array($order_id));
				
				if ($order_query->num_rows() > 0) {
					$order = $order_query->row();
					
					// Lấy chi tiết sản phẩm
					$items_query = $this->db->query("
						SELECT si.*, i.item_code, i.item_name
						FROM db_salesitems si
						LEFT JOIN db_items i ON si.item_id = i.id
						WHERE si.sales_id = ?
					", array($order_id));
					
					$items = array();
					if ($items_query->num_rows() > 0) {
						foreach ($items_query->result() as $item) {
							$items[] = array(
								'item_id' => $item->item_id,
								'item_code' => $item->item_code,
								'item_name' => $item->item_name,
								'sales_qty' => $item->sales_qty,
								'price_per_unit' => $item->price_per_unit,
								'discount_type' => isset($item->discount_type) ? $item->discount_type : 'percent',
								'discount_percent' => isset($item->discount_input) ? $item->discount_input : 0,
								'discount_amount' => isset($item->discount_amt) ? $item->discount_amt : 0,
								'tax_percent' => isset($item->tax_percent) ? $item->tax_percent : 0,
								'tax_amount' => isset($item->tax_amount) ? $item->tax_amount : 0,
								'total_cost' => $item->total_cost
							);
						}
					}
					
					// Tạo array cho đơn hàng với thông tin bổ sung về hóa đơn điện tử
					$order_data = array(
						'id' => $order->id,
						'sales_code' => $order->sales_code,
						'sales_date' => $order->sales_date,
						'customer_name' => $order->customer_name,
						'mobile' => $order->mobile,
						'address' => $order->address,
						'grand_total' => $order->grand_total,
						'paid_amount' => $order->paid_amount,
						'due_amount' => $order->due_amount,
						'sales_status' => $order->sales_status,
						'sales_note' => $order->sales_note,
						'created_by' => $order->created_by,
						'subtotal_amount' => isset($order->subtotal_amount) ? $order->subtotal_amount : 0,
						'bill_discount_percent' => isset($order->bill_discount_percent) ? $order->bill_discount_percent : 0,
						'bill_discount_amount' => isset($order->bill_discount_amount) ? $order->bill_discount_amount : 0,
						'discount_all_bill_percent' => isset($order->discount_to_all_input) ? $order->discount_to_all_input : 0,
						'discount_all_bill_amount' => isset($order->tot_discount_to_all_amt) ? $order->tot_discount_to_all_amt : 0,
						// Thông tin hóa đơn điện tử
						'template_number' => isset($order->template_number) ? $order->template_number : '1',
						'symbol' => isset($order->symbol) ? $order->symbol : 'C24',
						'payment_method' => isset($order->payment_method) ? $order->payment_method : 'TM',
						'tax_code' => isset($order->tax_code) ? $order->tax_code : '',
						'items' => $items,
						// Cấu hình hóa đơn điện tử
						'einvoice_config' => $einvoice_config,
						'einvoice_templates' => $einvoice_templates,
						'einvoice_payments' => $einvoice_payments,
						// Dữ liệu hóa đơn điện tử
						'einvoice_data' => $einvoice_data,
					);
					
					$orders[] = $order_data;
				}
			}
			
			$response = array(
				'success' => true,
				'data' => $orders
			);
			
		} catch (Exception $e) {
			$response = array(
				'success' => false,
				'message' => 'Có lỗi xảy ra: ' . $e->getMessage()
			);
		}
		
		echo json_encode($response);
	}
	
	public function get_einvoice_config() {
		$this->permission_check('sales_view');
		
		try {
			$this->load->model('site_model', 'site');
			$config = $this->site->get_einvoice_config();
			
			$response = array(
				'success' => true,
				'data' => $config
			);
		} catch (Exception $e) {
			$response = array(
				'success' => false,
				'message' => 'Có lỗi xảy ra: ' . $e->getMessage()
			);
		}
		
		echo json_encode($response);
	}
	
	public function update_order_details() {
		$this->permission_check('sales_edit');
		
		$order_data = $this->input->post('order_data');
		
		if (!$order_data || !isset($order_data['id'])) {
			$response = array(
				'success' => false,
				'message' => 'Dữ liệu đơn hàng không hợp lệ'
			);
			echo json_encode($response);
			return;
		}
		
		$this->db->trans_start();
		
		try {
			$order_id = $order_data['id'];
			
			// Update sales table
			$sales_update = array(
				'sales_status' => $order_data['sales_status'],
				'sales_note' => $order_data['sales_note']
			);
			
			// Thêm các trường E-invoice nếu có
			if (isset($order_data['template_number'])) {
				$sales_update['template_number'] = $order_data['template_number'];
			}
			if (isset($order_data['symbol'])) {
				$sales_update['symbol'] = $order_data['symbol'];
			}
			if (isset($order_data['payment_method'])) {
				$sales_update['payment_method'] = $order_data['payment_method'];
			}
			if (isset($order_data['tax_code'])) {
				$sales_update['tax_code'] = $order_data['tax_code'];
			}
			
			$this->db->where('id', $order_id);
			$this->db->update('db_sales', $sales_update);
			
			// Update customer information
			$customer_id_query = $this->db->select('customer_id')->where('id', $order_id)->get('db_sales');
			if ($customer_id_query->num_rows() > 0) {
				$customer_id = $customer_id_query->row()->customer_id;
				
				$customer_update = array(
					'customer_name' => $order_data['customer_name'],
					'mobile' => $order_data['mobile'],
					'address' => $order_data['address']
				);
				
				$this->db->where('id', $customer_id);
				$this->db->update('db_customers', $customer_update);
			}
			
			// Update sales items
			$grand_total = 0;
			$subtotal_amount = 0;
			if (isset($order_data['items']) && is_array($order_data['items'])) {
				foreach ($order_data['items'] as $item) {
					$item_update = array(
						'sales_qty' => $item['sales_qty'],
						'price_per_unit' => $item['price_per_unit'],
						'discount_percent' => isset($item['discount_percent']) ? $item['discount_percent'] : 0,
						'discount_amount' => isset($item['discount_amount']) ? $item['discount_amount'] : 0,
						'tax_percent' => isset($item['tax_percent']) ? $item['tax_percent'] : 0,
						'tax_amount' => isset($item['tax_amount']) ? $item['tax_amount'] : 0,
						'total_cost' => $item['total_cost']
					);
					
					$this->db->where('sales_id', $order_id);
					$this->db->where('item_id', $item['item_id']);
					$this->db->update('db_salesitems', $item_update);
					
					// Update item name if provided
					if (isset($item['item_name']) && !empty($item['item_name'])) {
						$this->db->where('id', $item['item_id']);
						$this->db->update('db_items', array('item_name' => $item['item_name']));
					}
					
					$subtotal_amount += $item['total_cost'];
				}
			}
			
			// Calculate grand total with bill discount
			$bill_discount_amount = isset($order_data['bill_discount_amount']) ? $order_data['bill_discount_amount'] : 0;
			$grand_total = $subtotal_amount - $bill_discount_amount;
			
			// Update sales table with totals and bill discount
			$sales_totals_update = array(
				'grand_total' => $grand_total,
				'subtotal_amount' => $subtotal_amount,
				'bill_discount_percent' => isset($order_data['bill_discount_percent']) ? $order_data['bill_discount_percent'] : 0,
				'bill_discount_amount' => $bill_discount_amount
			);
			
			$this->db->where('id', $order_id);
			$this->db->update('db_sales', $sales_totals_update);
			
			$this->db->trans_complete();
			
			if ($this->db->trans_status() === FALSE) {
				throw new Exception('Lỗi cập nhật cơ sở dữ liệu');
			}
			
			// Get updated order data
			$updated_order_query = $this->db->query("
				SELECT s.*, c.customer_name, c.mobile, c.address, c.sales_due as due_amount, u.username as created_by
				FROM db_sales s
				LEFT JOIN db_customers c ON s.customer_id = c.id
				LEFT JOIN db_users u ON s.created_by = u.id
				WHERE s.id = ?
			", array($order_id));
			
			$updated_order = $updated_order_query->row();
			
			// Get updated items
			$items_query = $this->db->query("
				SELECT si.*, i.item_code, i.item_name
				FROM db_salesitems si
				LEFT JOIN db_items i ON si.item_id = i.id
				WHERE si.sales_id = ?
			", array($order_id));
			
			$items = array();
			if ($items_query->num_rows() > 0) {
				foreach ($items_query->result() as $item) {
					$items[] = array(
						'item_id' => $item->item_id,
						'item_code' => $item->item_code,
						'item_name' => $item->item_name,
						'sales_qty' => $item->sales_qty,
						'price_per_unit' => $item->price_per_unit,
						'discount_percent' => isset($item->discount_percent) ? $item->discount_percent : 0,
						'discount_amount' => isset($item->discount_amount) ? $item->discount_amount : 0,
						'tax_percent' => isset($item->tax_percent) ? $item->tax_percent : 0,
						'tax_amount' => isset($item->tax_amount) ? $item->tax_amount : 0,
						'total_cost' => $item->total_cost
					);
				}
			}
			
			$updated_order_data = array(
				'id' => $updated_order->id,
				'sales_code' => $updated_order->sales_code,
				'sales_date' => $updated_order->sales_date,
				'customer_name' => $updated_order->customer_name,
				'mobile' => $updated_order->mobile,
				'address' => $updated_order->address,
				'grand_total' => $updated_order->grand_total,
				'paid_amount' => $updated_order->paid_amount,
				'due_amount' => $updated_order->due_amount,
				'sales_status' => $updated_order->sales_status,
				'sales_note' => $updated_order->sales_note,
				'created_by' => $updated_order->created_by,
				'subtotal_amount' => isset($updated_order->subtotal_amount) ? $updated_order->subtotal_amount : 0,
				'bill_discount_percent' => isset($updated_order->bill_discount_percent) ? $updated_order->bill_discount_percent : 0,
				'bill_discount_amount' => isset($updated_order->bill_discount_amount) ? $updated_order->bill_discount_amount : 0,
				// Thêm các trường E-invoice
				'template_number' => isset($updated_order->template_number) ? $updated_order->template_number : '1',
				'symbol' => isset($updated_order->symbol) ? $updated_order->symbol : 'C24',
				'payment_method' => isset($updated_order->payment_method) ? $updated_order->payment_method : 'TM',
				'tax_code' => isset($updated_order->tax_code) ? $updated_order->tax_code : '',
				'items' => $items
			);
			
			$response = array(
				'success' => true,
				'message' => 'Cập nhật thành công',
				'data' => $updated_order_data
			);
			
		} catch (Exception $e) {
			$this->db->trans_rollback();
			$response = array(
				'success' => false,
				'message' => 'Có lỗi xảy ra: ' . $e->getMessage()
			);
		}
		
		echo json_encode($response);
	}
	
	public function einvoice_config()
	{
		$this->permission_check('site_edit');
		$data = $this->data;
		$data['page_title'] = 'Cấu hình hóa đơn điện tử';
		
		// Lấy cấu hình hiện tại từ database (nếu có)
		$this->load->model('site_model', 'site');
		
		// Tạo bảng cấu hình nếu chưa tồn tại
		$this->site->create_einvoice_config_table();
		
		$config = $this->site->get_einvoice_config();
		$data['einvoice_config'] = $config;
		
		$this->load->view('einvoice-config', $data);
	}
	
	public function save_einvoice_config()
	{
		$this->permission_check('site_edit');
		
		// var formData = {
        //     api_url_einvoice: $('#api_url_einvoice').val().trim(),
        //     api_url: $('#api_url').val().trim(),
        //     username: $('#username').val().trim(),
        //     password: $('#password').val().trim(),
        //     provider_code: $('#provider_code').val().trim(),
        //     tax_code: $('#tax_code').val().trim()
        // };

		$api_url_einvoice = $this->input->post('api_url_einvoice');
		$api_url = $this->input->post('api_url');
		$username = $this->input->post('username');
		$password = $this->input->post('password');
		$provider_code = $this->input->post('provider_code');
		$tax_code = $this->input->post('tax_code');
		
		$this->load->model('site_model', 'site');
		$result = $this->site->save_einvoice_config($api_url_einvoice, $api_url, $username, $password, $provider_code, $tax_code);

		if ($result) {
			$response = array(
				'success' => true,
				'message' => 'Lưu cấu hình thành công'
			);
		} else {
			$response = array(
				'success' => false,
				'message' => 'Có lỗi xảy ra khi lưu cấu hình'
			);
		}
		
		echo json_encode($response);
	}
	
	public function test_einvoice_connection()
	{
		$this->permission_check('site_edit');
		
		$api_url = $this->input->post('api_url');
		$username = $this->input->post('username');
		$password = $this->input->post('password');
		$provider_code = $this->input->post('provider_code');
		
		// Thực hiện test kết nối API
		$ch = curl_init();
		curl_setopt($ch, CURLOPT_URL, $api_url);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		curl_setopt($ch, CURLOPT_TIMEOUT, 30);
		curl_setopt($ch, CURLOPT_POST, true);
		curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode(array(
			'username' => $username,
			'password' => $password,
			'provider_code' => $provider_code,
			'action' => 'test_connection'
		)));
		curl_setopt($ch, CURLOPT_HTTPHEADER, array(
			'Content-Type: application/json',
			'Accept: application/json'
		));
		
		$response = curl_exec($ch);
		$http_code = curl_getinfo($ch, CURLINFO_HTTP_CODE);
		$error = curl_error($ch);
		curl_close($ch);
		
		if ($error) {
			$result = array(
				'success' => false,
				'message' => 'Lỗi kết nối: ' . $error
			);
		} else if ($http_code == 200) {
			$result = array(
				'success' => true,
				'message' => 'Kết nối thành công',
				'data' => json_decode($response, true)
			);
		} else {
			$result = array(
				'success' => false,
				'message' => 'Kết nối thất bại. HTTP Code: ' . $http_code
			);
		}
		
		echo json_encode($result);
	}
	
	public function health_check_einvoice()
	{
		$this->permission_check('site_edit');
		
		$api_url_einvoice = $this->input->post('api_url_einvoice');
		$api_url = $this->input->post('api_url');
		$username = $this->input->post('username');
		$password = $this->input->post('password');
		$provider_code = $this->input->post('provider_code');
		$tax_code = $this->input->post('tax_code');
		
		// Cấu trúc API theo yêu cầu
		$data = array(
			'SiteConfigInfo' => array(
				'Site' => array(
					'Partner' => $provider_code,
					'PartnerUrl' => $api_url,
					'Username' => $username,
					'Password' => $password,
					'TaxNumber' => $tax_code,
				),
				'ExtraDataMap' => array()
			)
		);
		
		// Thực hiện gọi API Health Check
		$ch = curl_init();
		
		// URL Health Check endpoint
		$health_check_url = rtrim($api_url_einvoice, '/') . '/api/ezInvoice/HealthCheck';
		// $health_check_url = rtrim('https://ms-api-test.ezinvoice.vn', '/') . '/api/ezInvoice/HealthCheck';
		
		curl_setopt($ch, CURLOPT_URL, $health_check_url);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		curl_setopt($ch, CURLOPT_TIMEOUT, 30);
		curl_setopt($ch, CURLOPT_POST, true);
		curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));
		curl_setopt($ch, CURLOPT_HTTPHEADER, array(
			'Content-Type: application/json',
			// 'Authorization: Bearer 3DE164B5-0E9D-43DC-9FF1-976C823497FC'
		));
		curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
		curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
		
		$response = curl_exec($ch);
		$http_code = curl_getinfo($ch, CURLINFO_HTTP_CODE);
		$error = curl_error($ch);
		curl_close($ch);
		
		if ($error) {
			$result = array(
				'success' => false,
				'message' => 'Lỗi kết nối: ' . $error,
				'error_details' => $error
			);
		} else if ($http_code == 200) {
			$response_data = json_decode($response, true);
			if ($response_data['Status'] == 200) {
				// Kết nối thành công
				$result = array(
					'success' => true,
					'message' => 'Kiểm tra kết nối thành công11',
					'http_code' => $http_code,
					'response' => $response_data
				);
			} else {
				// Kết nối thất bại
				$result = array(
					'success' => false,
					'message' => 'Kiểm tra kết nối thất bại: Nội dung lỗi ' . $response_data['Message'],
					'http_code' => $response_data['Status'],
					'response' => $response_data
				);
			}
			
		} else {
			$result = array(
				'success' => false,
				'message' => 'Kiểm tra kết nối thất bại. HTTP Code: ' . $http_code,
				'http_code' => $http_code,
				'response' => $response
			);
		}
		
		echo json_encode($result);
	}

	public function create_and_publish_einvoice()
	{
		$this->permission_check('site_edit');
		
		$api_url = $this->input->post('api_url');
		$username = $this->input->post('username');
		$password = $this->input->post('password');
		$provider_code = $this->input->post('provider_code');

		$invoice_data = $this->input->post('invoice_data');
		$einvoiceConfig = $this->input->post('einvoice_config');
		// Dữ liệu mẫu để gửi đến API
		$formNo = $invoice_data['formNo']; // Mẫu số
		$serial = $invoice_data['serial']; // Ký hiệu
		$invoiceDate = $invoice_data['invoice_date']; // Ngày hóa đơn
		// Chuyển đổi từ yyyy-mm-dd thành dd/mm/yyyy
		if ($invoiceDate) {
			$invoiceDate = date('d/m/Y', strtotime($invoiceDate));
		}
		$customerName = $invoice_data['customer_name']; // Tên người mua hàng
		$customerPhone = $invoice_data['customer_phone']; // Số điện thoại người mua hàng
		$customerTax = $invoice_data['customer_tax_code']; // Mã số thuế người mua hàng
		$customerAddress = $invoice_data['customer_address']; // Địa chỉ người mua hàng
		$customerEmail = ''; // Email người mua hàng
		$customerCompanyName = ''; // Tên công ty người mua hàng
		$note = $invoice_data['note']; // Ghi chú cho hóa đơn
		$subAmount = $invoice_data['subtotal_amount']; // Tổng tiền trước thuế phí
		$serviceRate = 0; // Phần trăm phí
		$serviceCharge = 0; // Tổng tiền phí
		$beforeTaxAmount = $subAmount; // Tổng tiền trước thuế
		$taxRate = 0; // Phần trăm thuế
		$taxAmount = 0; // Tổng tiền thuế
		$afterTaxAmount = $invoice_data['grand_total']; // Tổng tiền sau thuế phí	
		$paymentMethod = $invoice_data['payment_method']; // Tên phương thức thanh toán
		// Thông tin chi tiết hóa đơn
		$listDetails = [];
		$details = $invoice_data['items']; // Danh sách sản phẩm chi tiết
		foreach ($details as $item) {
			$listDetails[] = array(
				// 'transdate' => date('d/m/Y', strtotime($item['transdate'])), // Ngày trên bảng sản phẩm
				'ItemName' => $item['item_name'], // Tên sản phẩm
				'UnitName' => '', // Tên đơn vị
				'Quantity' => $item['quantity'], // Số lượng
				'Price' => $item['unit_price'], // Giá sản phẩm 
				'DiscountAmount' => $item['discount_amount'], // Số tiền giảm giá sản phẩm
				'DiscountPercent' => $item['discount_percent'], // % Giảm giá
				'SubAmount' => $item['quantity'] * $item['unit_price'] - $item['discount_amount'], // Tiền sau giảm giá
				'ServiceRate' => 0, // % phí
				'ServiceCharge' => 0, // Tiền phí
				'BeforeTaxAmount' => $item['quantity'] * $item['unit_price'] - $item['discount_amount'], // Tiền trước thuế
				'TaxRate' => $item['tax_percent'], // % Thuế 
				'TAXAmount' => $item['tax_amount'], // Tiền thuế
				'AfterTaxAmount' => $item['total_amount'], // Tiền sau thuế phí
				// Những trường dưới tạm thời không dùng
				'Note' => '', 
				// 'ExciseTaxRate' => null,
				// 'ExciseTaxCharge' => null,
				// 'TaxReduction43Amount' => null,
				// 'TaxReduction43AmountOC' => null
			);
		}

		// Cấu trúc API theo yêu cầu
		$data = array(
			'Invoice' => array(
				'ezInvoiceId' => null, // Mã định danh cho hóa đơn
				'FormNo' => $formNo, // Mẫu số - Nhà cung cấp sẽ gửi thông tin này
				'Serial' => $serial, // Ký hiệu - Nhà cung cấp sẽ gửi thông tin này VD: 1C25MOC, Minvoice: 1C25TAV
				'InvoiceNo' => null, // Số hóa đơn - Giá trị trả ra khi phát hành hóa đơn thành công (trường ThirdPartyInvoiceNumber) - Dùng khi điểu chỉnh hóa đơn đã phát hành
				'InvoiceDate' => $invoiceDate, // Ngày hóa đơn
				'CustomerName' => $customerName, // Tên người mua hàng
				'CustomerPhone' => $customerPhone, // Số điện thoại người mua hàng
				'CustomerTax' => $customerTax, // Mã số thuế người mua hàng
				'CustomerAddress' => $customerAddress, // Địa chỉ người mua hàng
				'CustomerEmail' => $customerEmail, // Email người mua hàng
				'CompanyName' => $customerCompanyName, // Tên công ty người mua hàng
				'BankAccount' => '', // Số tài khoản người mua hàng
				'BankName' => '', // Tên tài khoàn người mua hàng
				'CurrencyCode' => 'VND', // Fix 
				'ExchangeRate' => 1.0, // Fix
				'PaymentMethod' => $paymentMethod, // Tên phương thưc thanh toán - Thường dùng tên viết tắt của phương thức. VD: Tiền mặt ~ TM, Chuyển khoản - CK,....
				'PaymentBankAccount' => '',  // Số tài khoản thanh toán
				'PaymentBankName' => '', // Tên tài khoản thanh toán
				'Notice' => $note, // Ghi chú cho hóa đơn
				'SubAmount' => $subAmount, // Tổng tiền trước thuế phí
				'ServiceRate' => $serviceRate, // Phần trăm phí
				'ServiceCharge' => $serviceCharge, // Tổng tiền phí
				'BeforeTaxAmount' => $beforeTaxAmount, // Tổng tiền trước thuế
				'TaxRate' => $taxRate, // Phần trăm thuế - Nếu trong danh sách sản phẩm có nhiều mức thuế thì không cần truyền - Lúc này dùng đến TaxSummarys
				'TaxAmount' => $taxAmount, // Tổng tiền thuế
				'AfterTaxAmount' => $afterTaxAmount, // Tổng tiền sau thuế phí
				// Những trường dưới đây cứ khai báo nhưng tạm thời chưa dùng
				'HotelExtra' => null, 
				'sid' => null,
				'RefID' => '',
				'InvoiceType' => 0,
				'SearchCode' => null,
				'XmlContent' => null,
				'BuyerNotGetInvoice' => null,
				'PricePrecision' => 2,
				'QuantityPrecision' => 0,
				'IsMultiVATRate' => true,
				'Validation' => null,
				'IsTaxReduction43' => null,
				'TaxReductionType' => null
			),
			// Thông tin sản phẩm
			// 'Details' => array(
			// 	array(
			// 		// 'transdate' => date('d/m/Y'), // Cột ngày trên bảng sản phẩm
			// 		'transdate' => '19/04/2025', // Cột ngày trên bảng sản phẩm
			// 		'ItemName' => 'Sản phẩm 1', // Tên sản phẩm
			// 		'UnitName' => 'cái', // Tên đơn vị
			// 		'Quantity' => 1.0, // Số lượng
			// 		'Price' => 10.0, // Giá sản phẩm 
			// 		'DiscountAmount' => 0.0, // Số tiền giảm giá sản phẩm
			// 		'DiscountPercent' => 0.0, // % Giảm giá
			// 		'SubAmount' => 10.0, // Tiền sau giảm giá 
			// 		'ServiceRate' => 5.0, // % phí
			// 		'ServiceCharge' => 0.0, // Tiền phí
			// 		'BeforeTaxAmount' => 10.0, // Tiền trước thuế
			// 		'TaxRate' => 10.0, // % Thuế 
			// 		'TaxAmount' => 1.0, // Tiền thuế
			// 		'AfterTaxAmount' => 11.0, // Tiền sau thuế phí
			// 		'Note' => null, // Ghi chú cho sản phẩm
			// 		// Những trường dưới tạm thời không dùng
			// 		'ExciseTaxRate' => null,
			// 		'ExciseTaxCharge' => null,
			// 		'TaxReduction43Amount' => null,
			// 		'TaxReduction43AmountOC' => null
			// 	)
			// ),
			'Details' => $listDetails, // Danh sách sản phẩm chi tiết
			// Tổng hợp tiền thuế
			'TaxSummarys' => array(
				array(
					'BeforeTaxAmount' => 0,
					'TaxRate' => 0,
					'TaxAmount' => 0
				)
			),
			'SiteConfigInfo' => array(
				// 'Site' => array(
				// 	"TaxNumber" => "0101243150-339", // Mã số thuế khách hàng
				// 	"Partner" => 6,
				// 	"PartnerUrl" => "https://testapi.meinvoice.vn/api/v3/", // API nhà cung cấp
				// 	"Username" => "testmisa@yahoo.com", // Tài khoản api
				// 	"Password" => "123456Aa", // Mật khẩu api
				// 	"Username2" => "string", // Tài khoản thử 2, nhà cung cấp VNPT sẽ cấp thông tin này
				// 	"Password2" => "string" // Mật khẩu api thứ 2, nhà cung cấp VNPT sẽ cấp thông tin này
				// ),
				// 'Site' => array(
				// 	"TaxNumber" => "0106026495-999", // Mã số thuế khách hàng
				// 	"Partner" => 2,
				// 	"PartnerUrl" => "https://0106026495-999.minvoice.app/", // API nhà cung cấp
				// 	"Username" => "EZTEST", // Tài khoản api
				// 	"Password" => "R#k6#76Zd!S@!t", // Mật khẩu api
				// 	"Username2" => "string", // Tài khoản thử 2, nhà cung cấp VNPT sẽ cấp thông tin này
				// 	"Password2" => "string" // Mật khẩu api thứ 2, nhà cung cấp VNPT sẽ cấp thông tin này
				// ),
				'Site' => array(
					"TaxNumber" => $einvoiceConfig['tax_code'], // Mã số thuế khách hàng
					"Partner" => $einvoiceConfig['provider_code'], // Mã đối tác - Nhà cung cấp sẽ gửi thông tin này
					"PartnerUrl" => $einvoiceConfig['api_url'], // API nhà cung cấp
					"Username" => $einvoiceConfig['username'], // Tài khoản api
					"Password" => $einvoiceConfig['password'], // Mật khẩu api
					"Username2" => $einvoiceConfig['username2'], // Tài khoản thử 2, nhà cung cấp VNPT sẽ cấp thông tin này
					"Password2" => $einvoiceConfig['password2'] // Mật khẩu api thứ 2, nhà cung cấp VNPT sẽ cấp thông tin này
				),
				'ExtraDataMap' => array()
			)
		);
		
		// Thực hiện gọi API Health Check
		$ch = curl_init();
		
		// URL Health Check endpoint
		// $health_check_url = rtrim($api_url, '/') . '/api/ezInvoice/HealthCheck';
		// $health_check_url = rtrim($einvoiceConfig['api_url_einvoice'], '/') . '/api/ezInvoice/HealthCheck';
		$health_check_url = rtrim('https://ms-api-test.ezinvoice.vn', '/') . '/api/ezInvoice/CreateAndPublishInvoice';
		
		curl_setopt($ch, CURLOPT_URL, $health_check_url);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		curl_setopt($ch, CURLOPT_TIMEOUT, 30);
		curl_setopt($ch, CURLOPT_POST, true);
		curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));
		curl_setopt($ch, CURLOPT_HTTPHEADER, array(
			'Content-Type: application/json',
			// 'Authorization: Bearer 3DE164B5-0E9D-43DC-9FF1-976C823497FC'
		));
		curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
		curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
		
		$response = curl_exec($ch);
		$http_code = curl_getinfo($ch, CURLINFO_HTTP_CODE);
		$error = curl_error($ch);
		curl_close($ch);
		
		if ($error) {
			$result = array(
				'success' => false,
				'message' => 'Lỗi kết nối: ' . $error,
				'error_details' => $error
			);
		} else if ($http_code == 200) {
			$response_data = json_decode($response, true);
			// Lấy thông tin Data trong $response_data
			$response_data_thirdPartyInvoiceNumber = isset($response_data['Data']['ThirdPartyInvoiceNumber']) ? $response_data['Data']['ThirdPartyInvoiceNumber'] : null;
			$response_data_invoiceID = isset($response_data['Data']['ezInvoiceId']) ? $response_data['Data']['ezInvoiceId'] : null;
			$response_data_searchCode = isset($response_data['Data']['SearchCode']) ? $response_data['Data']['SearchCode'] : null;
			$response_data_MaCQT = isset($response_data['Data']['MaCQT']) ? $response_data['Data']['MaCQT'] : null;
			$invoice_data_einvoice = array(
				'ThirdPartyInvoiceNumber' => $response_data_thirdPartyInvoiceNumber, // Số hóa đơn trả về
				'ezInvoiceId' => $response_data_invoiceID, // Mã định danh cho hóa đơn
				'SearchCode' => $response_data_searchCode, // Mã tra cứu
				'MaCQT' => $response_data_MaCQT // Mã cơ quan thuế
			);
			// Update lại thông tin vào bảng
			$this->update_invoice_data($invoice_data['order_id'], $invoice_data_einvoice);
			$result = array(
				'success' => true,
				'message' => 'Phát hành hóa đơn thành công',
				'http_code' => $http_code,
				'response' => $response_data,
				'thirdPartyInvoiceNumber' => $response_data_einvoice, // Số hóa đơn trả về
			);
		} else {
			$result = array(
				'success' => false,
				'message' => 'Phát hành hóa đơn thất bại. HTTP Code: ' . $http_code,
				'http_code' => $http_code,
				'response' => $response
			);
		}
		
		echo json_encode($result);
	}

	public function view_pdf_invoice() {
		$this->permission_check('sales_view');
		// Dữ liệu mẫu để gửi đến API
		// {
		// 	"ezInvoiceId": "6fa8e7a4-4f3b-49c5-aac7-72644a05c81e", // Mã đinh danh cho hóa đon 
		// 	"ThirdPartyInvoiceNumber": "00000038", // Key trả ra khi phát hành hóa đơn thành công
		// 	"ThirdPartyInvoiceCode": "",
		// 	"TransactionId": "E4HNH643B2", // Key trả ra khi phát hanh hoa đon thành công
		// 	"InvoiceType": 0, // Enum: 0: HDDT thường, 1: Vé điện tử, 2: Biên lai điện tử (HDDT - Hóa đơn điện tử)
		// 	"searchCode": "XWH2HDG4BQ", // Key trả ra khi phát hanh hoa đon thành công
		// 	"invtmp": 0,
		// 	"FormNo": "1", // Mẫu số 
		// 	"TypeEinvoice": 1,
		// 	"TypeFileDownload": null,
		// 	"Serial": "1C25MOC", // Ký hiệu
		// 	"SiteConfigInfo": {
		// 		"Site": {
		// 			"TaxNumber": "0101243150-339",
		// 			"Partner": 6,
		// 			"PartnerUrl": "https://testapi.meinvoice.vn/api/v3/", 
		// 			"PartnerUrl2": "string",
		// 			"Username": "testmisa@yahoo.com",
		// 			"Password": "123456Aa",
		// 			"Username2": "string",
		// 			"Password2": "string"
		// 		},
		// 		"ExtraDataMap": []
		// 	}
		// }

		$einvoice_data = $this->input->post('einvoice_data');
		$einvoice_config = $this->input->post('einvoice_config');
		// Get parameters from POST request
		$ezInvoiceId = $einvoice_data['partner_invoice_id'];
		$thirdPartyInvoiceNumber = $einvoice_data['partner_invoice_number'];
		$thirdPartyInvoiceCode = $einvoice_data['thirdPartyInvoiceCode'];
		$transactionId = $einvoice_data['partner_invoice_search_code'];
		$searchCode = $einvoice_data['partner_invoice_search_code'];
		$formNo = $einvoice_data['formNo']; // Mẫu số
		$serial = $einvoice_data['serial']; // Ký hiệu

		// Fix giá trị mẫu để test
		// $ezInvoiceId = '6fa8e7a4-4f3b-49c5-aac7-72644a05c81e';
		// $thirdPartyInvoiceNumber = '00000038';
		// $thirdPartyInvoiceCode = '';
		// $transactionId = 'E4HNH643B2';
		// $searchCode = 'XWH2HDG4BQ';
		// $formNo = '1';
		// $serial = '1C25TAV';

		// Load einvoice config
		$this->load->model('site_model', 'site');
		$einvoice_config = $this->site->get_einvoice_config();
		
		// Prepare API data
		$data = array(
			'ezInvoiceId' => $ezInvoiceId,
			'ThirdPartyInvoiceNumber' => $thirdPartyInvoiceNumber,
			'ThirdPartyInvoiceCode' => $thirdPartyInvoiceCode,
			'TransactionId' => $transactionId,
			'InvoiceType' => 0,
			'searchCode' => $searchCode,
			'invtmp' => 0,
			'FormNo' => $formNo,
			'TypeEinvoice' => 1,
			'TypeFileDownload' => null,
			'Serial' => $serial,
			'SiteConfigInfo' => array(
				'Site' => array(
					'TaxNumber' => $einvoice_config['tax_code'],
					'Partner' => $einvoice_config['provider_code'],
					'PartnerUrl' => $einvoice_config['api_url'],
					'PartnerUrl2' => 'string',
					'Username' => $einvoice_config['username'],
					'Password' => $einvoice_config['password'],
					'Username2' => 'string',
					'Password2' => 'string'
					// "TaxNumber" => "0106026495-999", // Mã số thuế khách hàng
					// "Partner" => 2,
					// "PartnerUrl" => "https://0106026495-999.minvoice.app/", // API nhà cung cấp
					// "Username" => "EZTEST", // Tài khoản api
					// "Password" => "R#k6#76Zd!S@!t", // Mật khẩu api
					// "Username2" => "string", // Tài khoản thử 2, nhà cung cấp VNPT sẽ cấp thông tin này
					// "Password2" => "string" // Mật khẩu api thứ 2, nhà cung cấp VNPT sẽ cấp thông tin này
				),
				'ExtraDataMap' => array()
			)
		);
		
		// Initialize cURL
		$ch = curl_init();
		
		// API URL for downloading PDF
		// $api_url = rtrim($einvoice_config['api_url_einvoice'], '/') . '/api/ezInvoice/DownloadPDF';
		$api_url = rtrim('https://ms-api-test.ezinvoice.vn', '/') . '/api/ezInvoice/DownloadPDF';
		
		// Set cURL options
		curl_setopt($ch, CURLOPT_URL, $api_url);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		curl_setopt($ch, CURLOPT_TIMEOUT, 60);
		curl_setopt($ch, CURLOPT_POST, true);
		curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));
		curl_setopt($ch, CURLOPT_HTTPHEADER, array(
			'Content-Type: application/json',
			//'Authorization: Bearer ' . (isset($einvoice_config['token']) ? $einvoice_config['token'] : '')
		));
		curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
		curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
		
		// Execute cURL request
		$response = curl_exec($ch);
		$http_code = curl_getinfo($ch, CURLINFO_HTTP_CODE);
		$content_type = curl_getinfo($ch, CURLINFO_CONTENT_TYPE);
		$error = curl_error($ch);
		curl_close($ch);
		
		// Handle response
		if ($error) {
			$result = array(
				'success' => false,
				'message' => 'Lỗi kết nối: ' . $error
			);
			echo json_encode($result);
		} else if ($http_code == 200) {
			// Check if response is PDF
			if (strpos($content_type, 'application/pdf') !== false) {
				// Set headers for PDF download
				header('Content-Type: application/pdf');
				header('Content-Disposition: inline; filename="invoice_' . $thirdPartyInvoiceNumber . '.pdf"');
				header('Content-Length: ' . strlen($response));
				
				// Output PDF content
				echo $response;
			} else {
				// Response is JSON (error or success message)
				$response_data = json_decode($response, true);
				if ($response_data && isset($response_data['Status']) && $response_data['Status'] == 200) {
					$result = array(
						'success' => true,
						'message' => 'Tải PDF thành công',
						'data' => $response_data,
						'pdf_base64' => isset($response_data['Data']['InvoicePDF']) ? $response_data['Data']['InvoicePDF'] : null
					);
				} else {
					$result = array(
						'success' => false,
						'message' => 'Tải PDF thất bại: ' . (isset($response_data['Message']) ? $response_data['Message'] : 'Unknown error'),
						'response' => $response_data
					);
				}
				echo json_encode($result);
			}
		} else {
			$result = array(
				'success' => false,
				'message' => 'Tải PDF thất bại. HTTP Code: ' . $http_code,
				'http_code' => $http_code,
				'response' => $response
			);
			echo json_encode($result);
		}
	}

	public function update_invoice_data($order_id, $invoice_data_einvoice) {
		// Lấy thông tin dòng dữ liệu trong bảng db_einvoice_header theo order_id
		$existing_invoice = $this->db->where('order_id', $order_id)
									->get('db_einvoice_header')
									->row();
		
		// Nếu có thông tin thì cập nhật các trường liên quan đến hóa đơn điện tử
		if ($existing_invoice) {
			$update_data = array();
			
			// Cập nhật các trường với tên đúng theo cấu trúc database
			if (isset($invoice_data_einvoice['ezInvoiceId'])) {
				$update_data['partner_invoice_id'] = $invoice_data_einvoice['ezInvoiceId'];
			}
			
			if (isset($invoice_data_einvoice['ThirdPartyInvoiceNumber'])) {
				$update_data['partner_invoice_number'] = $invoice_data_einvoice['ThirdPartyInvoiceNumber'];
			}
			
			if (isset($invoice_data_einvoice['SearchCode'])) {
				$update_data['partner_invoice_search_code'] = $invoice_data_einvoice['SearchCode'];
			}
			
			if (isset($invoice_data_einvoice['MaCQT'])) {
				$update_data['partner_invoice_tax_code'] = $invoice_data_einvoice['MaCQT'];
			}
			
			// Cập nhật thời gian modified
			$update_data['updated_at'] = date('Y-m-d H:i:s');
			$update_data['updated_by'] = $this->session->userdata('user_id');
			
			// Thực hiện cập nhật nếu có dữ liệu để update
			if (!empty($update_data)) {
				$this->db->where('id', $existing_invoice->id);
				$this->db->update('db_einvoice_header', $update_data);
				
				// Kiểm tra kết quả update
				if ($this->db->affected_rows() > 0) {
					log_message('info', 'Updated einvoice data for order_id: ' . $order_id);
					return true;
				} else {
					log_message('error', 'Failed to update einvoice data for order_id: ' . $order_id);
					return false;
				}
			}
		} else {
			log_message('error', 'No existing invoice found for order_id: ' . $order_id);
			return false;
		}
		
		return true;
	}

	public function save_einvoice_data() {
		$this->permission_check('sales_edit');
		
		$invoice_data = $this->input->post('invoice_data');
		
		if (!$invoice_data) {
			echo json_encode(array(
				'success' => false,
				'message' => 'Không có dữ liệu hóa đơn'
			));
			return;
		}
		
		try {
			// Check and create tables if not exist
			$tables_created = $this->create_einvoice_tables_if_not_exist();
			
			// Save invoice header
			$invoice_header_data = array(
				'order_id' => $invoice_data['order_id'],
				'sales_code' => $invoice_data['sales_code'],
				'invoice_date' => $invoice_data['invoice_date'],
				'template_number' => $invoice_data['template_number'],
				'symbol' => $invoice_data['symbol'],
				'customer_name' => $invoice_data['customer_name'],
				'customer_phone' => $invoice_data['customer_phone'],
				'customer_address' => $invoice_data['customer_address'],
				'customer_tax_code' => $invoice_data['customer_tax_code'],
				'payment_method' => $invoice_data['payment_method'],
				'sales_note' => $invoice_data['sales_note'],
				'subtotal_amount' => $invoice_data['subtotal_amount'],
				'bill_discount_amount' => $invoice_data['bill_discount_amount'],
				'grand_total' => $invoice_data['grand_total'],
				'created_at' => date('Y-m-d H:i:s'),
				'created_by' => $this->session->userdata('user_id')
			);
			
			// Check if invoice already exists for this order
			$existing_invoice = $this->db->where('order_id', $invoice_data['order_id'])
									   ->get('db_einvoice_header')
									   ->row();
			
			if ($existing_invoice) {
				// Update existing invoice
				$invoice_header_data['updated_at'] = date('Y-m-d H:i:s');
				$invoice_header_data['updated_by'] = $this->session->userdata('user_id');
				
				$this->db->where('id', $existing_invoice->id);
				$this->db->update('db_einvoice_header', $invoice_header_data);
				$invoice_header_id = $existing_invoice->id;
				
				// Delete existing items
				$this->db->where('einvoice_header_id', $invoice_header_id);
				$this->db->delete('db_einvoice_items');
			} else {
				// Insert new invoice
				$this->db->insert('db_einvoice_header', $invoice_header_data);
				$invoice_header_id = $this->db->insert_id();
			}
			
			// Save invoice items
			if (!empty($invoice_data['items'])) {
				foreach ($invoice_data['items'] as $item) {
					$item_data = array(
						'einvoice_header_id' => $invoice_header_id,
						'item_id' => $item['item_id'],
						'item_name' => $item['item_name'],
						'quantity' => $item['quantity'],
						'unit_price' => $item['unit_price'],
						'discount_percent' => $item['discount_percent'],
						'discount_amount' => $item['discount_amount'],
						'tax_percent' => $item['tax_percent'],
						'tax_amount' => $item['tax_amount'],
						'total_amount' => $item['total_amount'],
						'created_at' => date('Y-m-d H:i:s')
					);
					
					$this->db->insert('db_einvoice_items', $item_data);
				}
			}
			
			echo json_encode(array(
				'success' => true,
				'message' => 'Lưu thông tin hóa đơn điện tử thành công',
				'tables_created' => $tables_created,
				'invoice_id' => $invoice_header_id
			));
			
		} catch (Exception $e) {
			echo json_encode(array(
				'success' => false,
				'message' => 'Có lỗi xảy ra: ' . $e->getMessage()
			));
		}
	}
	
	private function create_einvoice_tables_if_not_exist() {
		$tables_created = false;
		
		// Check if einvoice_header table exists
		$header_table_exists = $this->db->query("SHOW TABLES LIKE 'db_einvoice_header'")->num_rows() > 0;
		
		if (!$header_table_exists) {
			// Create einvoice_header table
			$sql_header = "
				CREATE TABLE `db_einvoice_header` (
					`id` int(11) NOT NULL AUTO_INCREMENT,
					`order_id` int(11) NOT NULL,
					`sales_code` varchar(50) NOT NULL,
					`invoice_date` date NOT NULL,
					`template_number` varchar(10) DEFAULT '1',
					`symbol` varchar(10) DEFAULT 'C24',
					`customer_name` varchar(255) NOT NULL,
					`customer_phone` varchar(20) DEFAULT NULL,
					`customer_address` text DEFAULT NULL,
					`customer_tax_code` varchar(50) DEFAULT NULL,
					`payment_method` varchar(10) DEFAULT 'TM',
					`sales_note` text DEFAULT NULL,
					`subtotal_amount` decimal(10,2) DEFAULT 0.00,
					`bill_discount_amount` decimal(10,2) DEFAULT 0.00,
					`grand_total` decimal(10,2) DEFAULT 0.00,
					`status` varchar(20) DEFAULT 'draft',
					`created_at` datetime NOT NULL,
					`created_by` int(11) DEFAULT NULL,
					`updated_at` datetime DEFAULT NULL,
					`updated_by` int(11) DEFAULT NULL,
					`partner_invoice_id` varchar(150) DEFAULT NULL,
					`partner_invoice_number` varchar(50) DEFAULT NULL,
					`partner_invoice_search_code` varchar(150) DEFAULT NULL,
					`partner_invoice_tax_code` varchar(150) DEFAULT NULL,
					PRIMARY KEY (`id`),
					UNIQUE KEY `order_id` (`order_id`),
					KEY `sales_code` (`sales_code`),
					KEY `invoice_date` (`invoice_date`)
				) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;
			";
			
			$this->db->query($sql_header);
			$tables_created = true;
		}
		
		// Check if einvoice_items table exists
		$items_table_exists = $this->db->query("SHOW TABLES LIKE 'db_einvoice_items'")->num_rows() > 0;
		
		if (!$items_table_exists) {
			// Create einvoice_items table
			$sql_items = "
				CREATE TABLE `db_einvoice_items` (
					`id` int(11) NOT NULL AUTO_INCREMENT,
					`einvoice_header_id` int(11) NOT NULL,
					`item_id` int(11) NOT NULL,
					`item_name` varchar(255) NOT NULL,
					`quantity` decimal(10,3) NOT NULL DEFAULT 1.000,
					`unit_price` decimal(10,2) NOT NULL DEFAULT 0.00,
					`discount_percent` decimal(5,2) DEFAULT 0.00,
					`discount_amount` decimal(10,2) DEFAULT 0.00,
					`tax_percent` decimal(5,2) DEFAULT 0.00,
					`tax_amount` decimal(10,2) DEFAULT 0.00,
					`total_amount` decimal(10,2) NOT NULL DEFAULT 0.00,
					`created_at` datetime NOT NULL,
					PRIMARY KEY (`id`),
					KEY `einvoice_header_id` (`einvoice_header_id`),
					KEY `item_id` (`item_id`),
					CONSTRAINT `fk_einvoice_items_header` FOREIGN KEY (`einvoice_header_id`) REFERENCES `db_einvoice_header` (`id`) ON DELETE CASCADE
				) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;
			";
			
			$this->db->query($sql_items);
			$tables_created = true;
		}
		
		return $tables_created;
	}
	
	public function get_einvoice_json() {
		$this->permission_check('sales_view');
		
		$order_id = $this->input->post('order_id');
		
		if (!$order_id) {
			echo json_encode(array(
				'success' => false,
				'message' => 'Không có ID đơn hàng'
			));
			return;
		}
		
		try {
			// Get invoice header
			$header = $this->db->where('order_id', $order_id)
							   ->get('db_einvoice_header')
							   ->row_array();
			
			if (!$header) {
				echo json_encode(array(
					'success' => false,
					'message' => 'Không tìm thấy hóa đơn điện tử cho đơn hàng này'
				));
				return;
			}
			
			// Get invoice items
			$items = $this->db->where('einvoice_header_id', $header['id'])
							  ->get('db_einvoice_items')
							  ->result_array();
			
			// Format the response data as JSON structure
			$json_data = array(
				'header' => array(
					'id' => $header['id'],
					'order_id' => $header['order_id'],
					'sales_code' => $header['sales_code'],
					'invoice_date' => $header['invoice_date'],
					'template_number' => $header['template_number'],
					'symbol' => $header['symbol'],
					'customer_name' => $header['customer_name'],
					'customer_phone' => $header['customer_phone'],
					'customer_address' => $header['customer_address'],
					'customer_tax_code' => $header['customer_tax_code'],
					'payment_method' => $header['payment_method'],
					'sales_note' => $header['sales_note'],
					'subtotal_amount' => floatval($header['subtotal_amount']),
					'bill_discount_amount' => floatval($header['bill_discount_amount']),
					'grand_total' => floatval($header['grand_total']),
					'status' => $header['status'],
					'created_at' => $header['created_at'],
					'created_by' => $header['created_by'],
					'updated_at' => $header['updated_at'],
					'updated_by' => $header['updated_by']
				),
				'items' => array()
			);
			
			// Format items data
			foreach ($items as $item) {
				$json_data['items'][] = array(
					'item_id' => $item['item_id'],
					'item_name' => $item['item_name'],
					'quantity' => floatval($item['quantity']),
					'unit_price' => floatval($item['unit_price']),
					'discount_percent' => floatval($item['discount_percent']),
					'discount_amount' => floatval($item['discount_amount']),
					'tax_percent' => floatval($item['tax_percent']),
					'tax_amount' => floatval($item['tax_amount']),
					'total_amount' => floatval($item['total_amount']),
					'created_at' => $item['created_at']
				);
			}
			
			// Calculate summary
			$json_data['summary'] = array(
				'total_items' => count($items),
				'total_quantity' => array_sum(array_column($items, 'quantity')),
				'subtotal' => $json_data['header']['subtotal_amount'],
				'total_discount' => $json_data['header']['bill_discount_amount'],
				'grand_total' => $json_data['header']['grand_total'],
				'currency' => 'VND'
			);
			
			// Add metadata
			$json_data['metadata'] = array(
				'generated_at' => date('Y-m-d H:i:s'),
				'generated_by' => $this->session->userdata('user_id'),
				'version' => '1.0',
				'format' => 'einvoice_json'
			);
			
			echo json_encode(array(
				'success' => true,
				'message' => 'Lấy dữ liệu JSON thành công',
				'data' => $json_data
			));
			
		} catch (Exception $e) {
			echo json_encode(array(
				'success' => false,
				'message' => 'Có lỗi xảy ra: ' . $e->getMessage()
			));
		}
	}

	// Methods for E-invoice Template Configuration
	public function einvoice_template()
	{
		$this->permission_check('site_edit');
		$data = $this->data;
		$data['page_title'] = 'Cấu hình Mẫu số, Ký hiệu HDDT';
		
		$this->load->model('site_model', 'site');
		
		// Tạo bảng mẫu số ký hiệu nếu chưa tồn tại
		$this->site->create_einvoice_template_table();
		
		$this->load->view('einvoice-template', $data);
	}

	public function get_einvoice_templates()
	{
		$this->permission_check('site_edit');
		$this->load->model('site_model', 'site');
		
		$templates = $this->site->get_einvoice_templates();
		echo json_encode(array('data' => $templates));
	}

	public function save_einvoice_template()
	{
		// Add debugging
		error_log("save_einvoice_template method called");
		
		// Check if user is logged in
		if($this->session->userdata('logged_in') != 1) {
			echo json_encode(array(
				'success' => false,
				'message' => 'Bạn cần đăng nhập để thực hiện chức năng này'
			));
			return;
		}
		
		// Check permission (uncomment when testing is done)
		$this->permission_check('site_edit');
		
		$id = $this->input->post('id');
		$template_number = $this->input->post('template_number');
		$symbol = $this->input->post('symbol');
		$description = $this->input->post('description');
		
		// Validate required fields
		if(empty($template_number) || empty($symbol)) {
			echo json_encode(array(
				'success' => false,
				'message' => 'Mẫu số và ký hiệu là bắt buộc'
			));
			return;
		}
		
		$this->load->model('site_model', 'site');
		
		try {
			if ($id) {
				// Update existing template
				$result = $this->site->update_einvoice_template($id, $template_number, $symbol, $description);
			} else {
				// Create new template
				$result = $this->site->create_einvoice_template($template_number, $symbol, $description);
			}
			
			if ($result) {
				echo json_encode(array(
					'success' => true,
					'message' => 'Lưu mẫu số ký hiệu thành công'
				));
			} else {
				echo json_encode(array(
					'success' => false,
					'message' => 'Có lỗi xảy ra khi lưu mẫu số ký hiệu'
				));
			}
		} catch(Exception $e) {
			echo json_encode(array(
				'success' => false,
				'message' => 'Lỗi: ' . $e->getMessage()
			));
		}
	}

	public function delete_einvoice_template()
	{
		$this->permission_check('site_edit');
		
		$id = $this->input->post('id');
		$this->load->model('site_model', 'site');
		
		$result = $this->site->delete_einvoice_template($id);
		
		if ($result) {
			echo json_encode(array(
				'success' => true,
				'message' => 'Xóa mẫu số ký hiệu thành công'
			));
		} else {
			echo json_encode(array(
				'success' => false,
				'message' => 'Có lỗi xảy ra khi xóa mẫu số ký hiệu'
			));
		}
	}

	// Methods for E-invoice Payment Configuration
	public function einvoice_payment()
	{
		$this->permission_check('site_edit');
		$data = $this->data;
		$data['page_title'] = 'Cấu hình phương thức thanh toán HDDT';
		
		$this->load->model('site_model', 'site');
		
		// Tạo bảng phương thức thanh toán nếu chưa tồn tại
		$this->site->create_einvoice_payment_table();
		
		$this->load->view('einvoice-payment', $data);
	}

	public function get_einvoice_payments()
	{
		$this->permission_check('site_edit');
		$this->load->model('site_model', 'site');
		
		$payments = $this->site->get_einvoice_payments();
		echo json_encode(array('data' => $payments));
	}

	public function save_einvoice_payment()
	{
		$this->permission_check('site_edit');
		
		$id = $this->input->post('id');
		$payment_code = $this->input->post('payment_code');
		$payment_name = $this->input->post('payment_name');
		$description = $this->input->post('description');
		
		$this->load->model('site_model', 'site');
		
		if ($id) {
			// Update existing payment method
			$result = $this->site->update_einvoice_payment($id, $payment_code, $payment_name, $description);
		} else {
			// Create new payment method
			$result = $this->site->create_einvoice_payment($payment_code, $payment_name, $description);
		}
		
		if ($result) {
			echo json_encode(array(
				'success' => true,
				'message' => 'Lưu phương thức thanh toán thành công'
			));
		} else {
			echo json_encode(array(
				'success' => false,
				'message' => 'Có lỗi xảy ra khi lưu phương thức thanh toán'
			));
		}
	}

	public function delete_einvoice_payment()
	{
		$this->permission_check('site_edit');
		
		$id = $this->input->post('id');
		$this->load->model('site_model', 'site');
		
		$result = $this->site->delete_einvoice_payment($id);
		
		if ($result) {
			echo json_encode(array(
				'success' => true,
				'message' => 'Xóa phương thức thanh toán thành công'
			));
		} else {
			echo json_encode(array(
				'success' => false,
				'message' => 'Có lỗi xảy ra khi xóa phương thức thanh toán'
			));
		}
	}

	// Test method để debug
}
