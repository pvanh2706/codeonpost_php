<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Items extends MY_Controller {
	public function __construct(){
		parent::__construct();
		$this->load_global();
		$this->load->model('items_model','items');
	}
	
	public function index()
	{
		$this->permission_check('items_view');
		$data=$this->data;
		$data['page_title']=$this->lang->line('items_list');
		$this->load->view('items-list',$data);
	}
	public function getitemprice($itemid='',$plevel=''){
		echo $this->items->getItemsPriceJson($itemid,$plevel);
	}
	public function add()
	{
		$this->permission_check('items_add');
		$data=$this->data;
		$data['page_title']=$this->lang->line('items');
		$this->load->view('items',$data);
	}

	public function newitems(){
		$this->form_validation->set_rules('item_name', 'Item Name', 'trim|required');
		$this->form_validation->set_rules('category_id', 'Category Name', 'trim|required');
		$this->form_validation->set_rules('unit_id', 'Unit', 'trim|required');
		$this->form_validation->set_rules('price', 'Item Price', 'trim|required');
		$this->form_validation->set_rules('tax_id', 'Tax', 'trim|required');
		$this->form_validation->set_rules('purchase_price', 'Purchase Price', 'trim|required');
		//$this->form_validation->set_rules('profit_margin', 'Profit Margin', 'trim|required');
		$this->form_validation->set_rules('sales_price', 'Sales Price', 'trim|required');

		
		if ($this->form_validation->run() == TRUE) {
			$result=$this->items->verify_and_save();
			echo $result;
		} else {
			echo "Please Fill Compulsory(* marked) Fields.";
		}
	}
	public function update($id){
		$this->permission_check('items_edit');
		$data=$this->data;
		$this->load->model('items_model');
		$result=$this->items_model->get_details($id,$data);
		$data=array_merge($data,$result);
		$data['page_title']=$this->lang->line('items');
		$this->load->view('items', $data);
	}
	
	public function updatestock($id,$sl){
	    $this->permission_check('items_edit');
	    //$result=$this->items_model->up_stock($id,$sl);
	    //echo $result;
	    $result = '';
	    if($sl > 0) { $sls = '+'; } else {$sls = '-';}
	    
	    $info = array(  'entry_date'            => date("Y-m-d"), 
                        'item_id'               => $id,
                        'qty'                   => $sl,
                        'note'                  => 'Admin Cập nhật số lượng ['. $sls . number_format($sl) .'] sản phẩm ['. get_items_name_by_id($id) .'] tồn kho',
                        'status'                => 1);
        if($this->db->insert('db_stockentry', $info)) {
            
            $this->load->model('pos_model');				
		    $q6=$this->pos_model->update_items_quantity($id);
		    if($q6){
			    $result =  "success";
		    } else {
                $result =  "failed";
		    }
        } else {
            $result =  "faileds";
        }
	    echo $result;
	    
	    
	    
	    //if ($this->db->simple_query("update db_items set stock = ".$sl." where id =".$id)) {
	    //    log_customer_point(0, 0, 0, 0, 'Admin Cập nhật số lượng ['. $sls . number_format($sl) .'] sản phẩm ['. get_items_name_by_id($id) .'] tồn kho');
	    //    $result =  "success";
	    //} else {
	    //    $result =  "failed";
	    //}
	    //echo $result;
	}
	
	
	public function update_items(){
		$this->form_validation->set_rules('item_name', 'Item Name', 'trim|required');
		$this->form_validation->set_rules('category_id', 'Category Name', 'trim|required');
		$this->form_validation->set_rules('unit_id', 'Unit', 'trim|required');
		$this->form_validation->set_rules('price', 'Item Price', 'trim|required');
		$this->form_validation->set_rules('tax_id', 'Tax', 'trim|required');
		$this->form_validation->set_rules('purchase_price', 'Purchase Price', 'trim|required');
		//$this->form_validation->set_rules('profit_margin', 'Profit Margin', 'trim|required');
		$this->form_validation->set_rules('sales_price', 'Sales Price', 'trim|required');

		if ($this->form_validation->run() == TRUE) {
			$result=$this->items->update_items();
			echo $result;
		} else {
			echo "Please Fill Compulsory(* marked) Fields.";
		}
	}

	public function get_brand_name($brand_id=''){
		if($brand_id==NULL || $brand_id=='' || $brand_id ==0){
			return;
		}
		return $this->db->query('select brand_name from db_brands where id="'.$brand_id.'"')->row()->brand_name;
	}
	public function ajax_list()
	{
		$list = $this->items->get_datatables();
		
		$data = array();
		$no = $_POST['start'];
		$tax_disabled = (is_tax_disabled()) ? true : false;
		foreach ($list as $items) {
			
			$no++;
			$row = array();
			$row[] = '<input type="checkbox" name="checkbox[]" value='.$items->id.' class="checkbox column_checkbox" >';
						

			$row[] = (!empty($items->item_image) && file_exists($items->item_image)) ? "
						<a title='Click for Bigger!' href='".base_url($items->item_image)."' data-toggle='lightbox'>
						<image style='border:1px #72afd2 solid;' src='".base_url(return_item_image_thumb($items->item_image))."' width='75%' height='50%'> </a>" : "
						<image style='border:1px #72afd2 solid;' src='".base_url()."theme/images/no_image.png' title='No Image!' width='75%' height='50%' >";
			$row[] = $items->item_code;
			$row[] = "<label class='text-blue'>".$items->item_name."</label><br><small style='display: none;'>". $items->search_for ."</small><br><span style='font-size: 0.9em;'>".$items->hsn."</span> - <span style='font-size: 0.9em;'>".$items->sku."</span>";
			$row[] = $items->brand_name;//$this->get_brand_name($items->brand_id);
			$row[] = $items->category_name;
			
			$row[] = app_number_format($items->purchase_price);
			$row[] = app_number_format($items->final_price);
			$row[] = app_number_format($items->final_price0);
			$row[] = app_number_format($items->final_price1);
			$row[] = app_number_format($items->final_price2);
			$row[] = app_number_format($items->final_price3);
			
			
			
			//$row[] = $items->unit_name;
			//$row[] = $items->stock;
			//$row[] = $items->alert_qty;
			//$row[] = app_number_format($items->purchase_price);
			//$row[] = app_number_format($items->final_price);
			//$row[] = ($tax_disabled)? '<p class="text-yellow text-bold">Disabled</p>' :$items->tax_name."<br>(".$items->tax_type.")";

			 		if($items->status==1){ 
			 			$str= "<span onclick='update_status(".$items->id.",0)' id='span_".$items->id."'  class='label label-success' style='cursor:pointer'>Kích hoạt </span>";}
					else{ 
						$str = "<span onclick='update_status(".$items->id.",1)' id='span_".$items->id."'  class='label label-danger' style='cursor:pointer'>Vô hiệu hóa </span>";
					}
			$row[] = $str;		

			 		$str2 = '<div class="btn-group" title="View Account">
										<a class="btn btn-primary btn-o dropdown-toggle" data-toggle="dropdown" href="#">
											Action <span class="caret"></span>
										</a>
										<ul role="menu" class="dropdown-menu dropdown-light pull-right">';

											if($this->permissions('items_edit'))
											$str2.='<li>
												<a title="Edit Record ?" href="'.base_url('items/update/'.$items->id).'">
													<i class="fa fa-fw fa-edit text-blue"></i>Điều chỉnh
												</a>
											</li>';

											if($this->permissions('items_delete'))
											$str2.='<li>
												<a style="cursor:pointer" title="Delete Record ?" onclick="delete_items('.$items->id.')">
													<i class="fa fa-fw fa-trash text-red"></i>Xóa bỏ SP
												</a>
											</li>
											
										</ul>
									</div>';			
			$row[] = $str2;

			$data[] = $row;
		}

		$output = array(
						"draw" => $_POST['draw'],
						"recordsTotal" => $this->items->count_all(),
						"recordsFiltered" => $this->items->count_filtered(),
						"data" => $data,
				);
		//output to json format
		echo json_encode($output);
	}
	public function update_status(){
		$this->permission_check_with_msg('items_edit');
		$id=$this->input->post('id');
		$status=$this->input->post('status');

		$this->load->model('items_model');
		$result=$this->items_model->update_status($id,$status);
		return $result;
	}

	public function delete_items(){
		$this->permission_check_with_msg('items_delete');
		$id=$this->input->post('q_id');
		return $this->items->delete_items_from_table($id);
	}
	public function multi_delete(){
		$this->permission_check_with_msg('items_delete');
		$ids=implode (",",$_POST['checkbox']);
		return $this->items->delete_items_from_table($ids);
	}

	//Used in Purchase and sales Forms
	public function get_json_items_details(){
		$data = array();
		$display_json = array();
		//if (!empty($_GET['name'])) {
			$name = strtolower(trim($_GET['name']));
			$name = str_replace(' ', '%', $name);
			//$sql =$this->db->query("SELECT id,item_name,item_code,stock FROM db_items where  status=1 and  (LOWER(item_name) LIKE '%$name%' or LOWER(item_code) LIKE '%$name%')");// or LOWER(custom_barcode) LIKE '%$name%')");
			
			//$sql =$this->db->query("SELECT id,item_name,item_code,stock FROM db_items where status=1 and (MATCH (item_name) AGAINST('$name') or LOWER(item_code) LIKE '%$name%')");// or LOWER(custom_barcode) LIKE '%$name%')");
			
			//$this->db->where('MATCH (table_name.title) AGAINST("'.$slug.'")');
			
			$sql =$this->db->query("SELECT id,item_name,item_code,stock,final_price,final_price0,final_price1,final_price2,final_price3 FROM db_items where  status=1 and  (LOWER(item_name) LIKE '%$name%' or LOWER(search_for) LIKE '%$name%')");// or LOWER(custom_barcode) LIKE '%$name%')");
			
			foreach ($sql->result() as $res) {
			      $json_arr["id"] = $res->id;
				  $json_arr["value"] = $res->item_name;
				  $json_arr["label"] = $res->item_name;
				  $json_arr["item_code"] = $res->item_code;
				  $json_arr["stock"] = $res->stock;
				  $json_arr["cansold"] = cansold($res->id);
				  $json_arr["final_price"] = number_format($res->final_price);
				  $json_arr["final_price0"] = number_format($res->final_price0);
				  $json_arr["final_price1"] = number_format($res->final_price1);
				  $json_arr["final_price2"] = number_format($res->final_price2);
				  $json_arr["final_price3"] = number_format($res->final_price3);
				  array_push($display_json, $json_arr);
				 /* $display_json[] =$res->id;
				  $display_json[] =$res->item_name;
				  $display_json[] =$res->item_code;*/
			}
		//}
		//echo json_encode($data);exit;
		echo json_encode($display_json);exit;
	}
	
	//Used in Purchase and sales Forms
	public function get_json_items_details_stock(){
		$data = array();
		$display_json = array();
		//if (!empty($_GET['name'])) {
			$name = strtolower(trim($_GET['name']));
			$name = str_replace(' ', '%', $name);
			$sql =$this->db->query("SELECT id,item_name,item_code,stock,final_price,final_price0,final_price1,final_price2,final_price3 FROM db_items where  status=1 and  (LOWER(item_name) LIKE '%$name%' or LOWER(search_for) LIKE '%$name%' )");//or LOWER(custom_barcode) LIKE '%$name%')   limit 10");
			
			foreach ($sql->result() as $res) {
			      $json_arr["id"] = $res->id;
				  $json_arr["value"] = $res->item_name;
				  $json_arr["label"] = $res->item_name;
				  $json_arr["item_code"] = $res->item_code;
				  $json_arr["stock"] = $res->stock;
				  $json_arr["cansold"] = cansold($res->id);
				  $json_arr["final_price"] = number_format($res->final_price);
				  $json_arr["final_price0"] = number_format($res->final_price0);
				  $json_arr["final_price1"] = number_format($res->final_price1);
				  $json_arr["final_price2"] = number_format($res->final_price2);
				  $json_arr["final_price3"] = number_format($res->final_price3);
				  array_push($display_json, $json_arr);
				 /* $display_json[] =$res->id;
				  $display_json[] =$res->item_name;
				  $display_json[] =$res->item_code;*/
			}
		//}
		//echo json_encode($data);exit;
		echo json_encode($display_json);exit;
	}

	public function labels($purchase_id=''){
		$this->permission_check('print_labels');
		$data=$this->data;
		$data['page_title']=$this->lang->line('print_labels');
		$data['purchase_id']=$purchase_id;
		$this->load->view('labels',$data);
	}

	/*Labels Print request*/
	public function return_row_with_data($rowcount,$item_id){
		echo $this->items->get_items_info($rowcount,$item_id);
	}

	public function preview_labels(){
		echo $this->items->preview_labels();
	}

	//GET Labels from Purchase Invoice
	public function show_labels($purchase_id=''){
		$i=1;
		$result='';
		$q2=$this->db->query("select item_id,purchase_qty from db_purchaseitems where purchase_id='$purchase_id'");
		if($q2->num_rows()>0){
			
			foreach ($q2 -> result() as $res2) {
				$result.= $this->items->get_purchase_items_info($i++,$res2->item_id,$res2->purchase_qty);
			}
		}
		echo $result;
	}
	public function delete_stock_entry(){
		$this->permission_check_with_msg('items_delete');
		$entry_id = $this->input->post('entry_id');
		echo $this->items->delete_stock_entry($entry_id);
	}
	public function getItems($id=''){
		echo $this->items->getItemsJson($id);
	}
}
