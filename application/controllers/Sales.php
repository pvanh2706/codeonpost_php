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
		
		$api_url = $this->input->post('api_url');
		$username = $this->input->post('username');
		$password = $this->input->post('password');
		$provider_code = $this->input->post('provider_code');
		
		$this->load->model('site_model', 'site');
		$result = $this->site->save_einvoice_config($api_url, $username, $password, $provider_code);
		
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
		
		$api_url = $this->input->post('api_url');
		$username = $this->input->post('username');
		$password = $this->input->post('password');
		$provider_code = $this->input->post('provider_code');
		
		// Cấu trúc API theo yêu cầu
		$data = array(
			'SiteConfigInfo' => array(
				'Site' => array(
					'Partner' => 2,
					'PartnerUrl' => $api_url,
					'Username' => $username,
					'Password' => $password
				),
				'ExtraDataMap' => array()
			)
		);
		
		// Thực hiện gọi API Health Check
		$ch = curl_init();
		
		// URL Health Check endpoint
		// $health_check_url = rtrim($api_url, '/') . '/api/ezInvoice/HealthCheck';
		$health_check_url = rtrim('https://ms-api-test.ezinvoice.vn', '/') . '/api/ezInvoice/HealthCheck';
		
		curl_setopt($ch, CURLOPT_URL, $health_check_url);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		curl_setopt($ch, CURLOPT_TIMEOUT, 30);
		curl_setopt($ch, CURLOPT_POST, true);
		curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));
		curl_setopt($ch, CURLOPT_HTTPHEADER, array(
			'Content-Type: application/json',
			'Authorization: Bearer 3DE164B5-0E9D-43DC-9FF1-976C823497FC'
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
			$result = array(
				'success' => true,
				'message' => 'Kiểm tra kết nối thành công',
				'http_code' => $http_code,
				'response' => $response_data
			);
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
		
		// Cấu trúc API theo yêu cầu
		$data = array(
			'SiteConfigInfo' => array(
				'Site' => array(
					'Partner' => 2,
					'PartnerUrl' => $api_url,
					'Username' => $username,
					'Password' => $password
				),
				'ExtraDataMap' => array()
			)
		);
		
		// Thực hiện gọi API Health Check
		$ch = curl_init();
		
		// URL Health Check endpoint
		// $health_check_url = rtrim($api_url, '/') . '/api/ezInvoice/HealthCheck';
		$health_check_url = rtrim('https://ms-api-test.ezinvoice.vn', '/') . '/api/ezInvoice/HealthCheck';
		
		curl_setopt($ch, CURLOPT_URL, $health_check_url);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		curl_setopt($ch, CURLOPT_TIMEOUT, 30);
		curl_setopt($ch, CURLOPT_POST, true);
		curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));
		curl_setopt($ch, CURLOPT_HTTPHEADER, array(
			'Content-Type: application/json',
			'Authorization: Bearer 3DE164B5-0E9D-43DC-9FF1-976C823497FC'
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
			$result = array(
				'success' => true,
				'message' => 'Kiểm tra kết nối thành công',
				'http_code' => $http_code,
				'response' => $response_data
			);
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
