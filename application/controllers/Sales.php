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
	
	public function save_stt_invoice($stt){
		$this->permission_check_with_msg('sales_add');
		//echo $this->sales->save_stt();
	}
	
	
	public function view_payments_modal(){
		$this->permission_check_with_msg('sales_view');
		$sales_id=$this->input->post('sales_id');
		echo $this->sales->view_payments_modal($sales_id);
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
								'discount_percent' => isset($item->discount_percent) ? $item->discount_percent : 0,
								'discount_amount' => isset($item->discount_amount) ? $item->discount_amount : 0,
								'tax_percent' => isset($item->tax_percent) ? $item->tax_percent : 0,
								'tax_amount' => isset($item->tax_amount) ? $item->tax_amount : 0,
								'total_cost' => $item->total_cost
							);
						}
					}
					
					// Tạo array cho đơn hàng
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
						'items' => $items
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
}
