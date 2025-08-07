<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Pos_model extends CI_Model {

	public function inclusive($price='',$tax_per){
		return ($tax_per!=0) ? $price/(($tax_per/100)+1)/10 : $tax_per;
	}
	public function get_item_details($item_id)
	{
		  $this->db->select("b.id as tax_id, a.*,b.tax,b.tax_name");
	      $this->db->from("db_items a");
	      $this->db->join("db_tax b","b.id=a.tax_id","left");
	      $this->db->where("a.status=1");
	      $this->db->where("a.id",$item_id);
		  //echo $this->db->get_compiled_select();exit();
		  $res1=$this->db->get()->row();

	      $item_tax_amt = ($res1->tax_type=='Inclusive') ? calculate_inclusive($res1->sales_price,$res1->tax) :calculate_exclusive($res1->sales_price,$res1->tax);

	      $item_array = array(
	      				'id' 					=> $res1->id,
	      				'item_name' 			=> $res1->item_name,
	      				'stock' 				=> $res1->stock,
	      				'sales_price' 			=> $res1->sales_price,
	      				'sales_price0' 			=> $res1->final_price0,
	      				'sales_price1' 			=> $res1->final_price1,
	      				'sales_price2' 			=> $res1->final_price2,
	      				'sales_price3' 			=> $res1->final_price3,
	      				'purchase_price' 		=> $res1->purchase_price,
	      				'tax_id' 				=> $res1->tax_id,
	      				'tax_type' 				=> $res1->tax_type,
	      				'tax' 					=> $res1->tax,
	      				'tax_name' 				=> $res1->tax_name,
	      				'item_tax_amt' 			=> $item_tax_amt,
	      				'discount_type' 		=> $res1->discount_type,
	      				'discount' 				=> $res1->discount,
	      );

	      return json_encode($item_array);

	}
    public function get_details_lv($lv){
		$CI =& get_instance();
		$data=$this->data;
		extract($data);
		extract($_POST);
		  $i=0;
		  $str='';

		  $table='';

	      $this->db->select("b.id as tax_id, a.*,b.tax,b.tax_name");
	      $this->db->from("db_items a");
	      $this->db->join("db_tax b","b.id=a.tax_id","left");
	      $this->db->where("a.status=1 and a.id <> -1");
	      //$this->db->order_by("a.stock","DESC");
	      if(!empty($id)){
		  	$this->db->where("a.category_id",$id);
		  }
		  if($brand_id!=''){
		  	$this->db->where(" a.brand_id=$brand_id");
		  }
		  if(isset($last_id) && !empty($last_id)){
		  	$this->db->where("a.id>".$last_id);
		  }
		  if(!empty($item_name)){
		  	$this->db->where("upper(a.item_name) like upper('%".$item_name."%')");
		  }
		  //$this->db->limit(30);
		  //echo $this->db->get_compiled_select();exit();
		  $q2=$this->db->get();

		  $last_id = '';
	      if($q2->num_rows()>0){
	        foreach($q2->result() as $res2){
	        	$item_tax_type = $res2->tax_type;
	        	$item_tax_id = $res2->tax_id;
	        	
	        	switch ($lv){
	        	    case 0:
	        	        $item_sales_price = $res2->final_price0;break;
	        	    case 1:
	        	        $item_sales_price = $res2->final_price1;break;
	        	    case 2:
	        	        $item_sales_price = $res2->final_price2;break;
	        	    case 3:
	        	        $item_sales_price = $res2->final_price3;break;
	        	    default:
	        	        $item_sales_price = $res2->final_price;break;
	        	}
	        	
	        	$item_final_price = $res2->final_price;
	        	$item_sales_price0 = $res2->final_price0;
	        	$item_sales_price1 = $res2->final_price1;
	        	$item_sales_price2 = $res2->final_price2;
	        	$item_sales_price3 = $res2->final_price3;
	        	$item_cost = $res2->purchase_price;
	        	$item_tax = $res2->tax;
	        	$item_tax_name = $res2->tax_name;
	        	$purchase_price = $res2->purchase_price;
	        	$discount_type = $res2->discount_type;
	        	$discount = $res2->discount;
	        	$item_sales_qty = 1;

	        	//Check Exculsive or Inclusive
	        	if($item_tax_type=='Exclusive'){
					//$single_unit_price = $item_sales_price;
					//$item_sales_price=$item_sales_price+ (($item_sales_price*$item_tax)/100);
					//$item_tax_amt = (($single_unit_price * $item_sales_qty)*$item_tax)/100;
				}
				else{//Inclusive	
					//$item_tax_amt=number_format($this->inclusive($item_sales_price,$item_tax),2,'.','');
					//$single_unit_price = $item_sales_price;
				}

				$item_tax_amt = ($item_tax_type=='Inclusive') ? calculate_inclusive($item_sales_price,$item_tax) :calculate_exclusive($item_sales_price,$item_tax);

				//$item_amount = ($item_sales_price * $item_sales_qty) + $item_tax_amt;
				//end 

	        	if($res2->stock <=0){
	        		//$str="zero_stock()";
	        		//$disabled='';
	        		$bg_label="danger";
	        		$bg_color="background-color:#c8c8c8";
	        	}
	        	else{
	        		//$str="addrow($res2->id)";
	        		//$disabled="disabled";
	        		$bg_label="info";
	        		$bg_color="background-color:#a1db75";
	        	}
	        	$str="addrow($res2->id)";
	        	$disabled="disabled=disabled";
	        	
	        	$count_pendding_item_to_sales = count_sales_item_pendding($res2->id);
	        	$count_pendding_item_to_sales = $res2->stock - $count_pendding_item_to_sales;

	        	$img_src = (!empty($res2->item_image) && file_exists($res2->item_image)) ? base_url(return_item_image_thumb($res2->item_image)) : base_url('theme/images/no_image.png');
                
	        	$table .= '<div class="col-md-2 col-xs-3 " id="item_parent_'.$i.'" '.$disabled.' data-toggle="tooltip" title="'.$res2->item_name.'" style="padding-left:5px;padding-right:5px;">
	        	    
        	          <div class="box box-default item_box" id="div_'.$res2->id.'" onclick="'.$str.'"
        	          				data-item-id="'.$res2->id.'"
        	          				data-item-name="'.$res2->item_name.'"
        	          				data-item-available-qty="'.$res2->stock.'"
        	          				data-item-sales-price="'.$item_sales_price.'"
        	          				data-item-sales-price0="'.$item_sales_price0.'"
        	          				data-item-sales-price1="'.$item_sales_price1.'"
        	          				data-item-sales-price2="'.$item_sales_price2.'"
        	          				data-item-sales-price3="'.$item_sales_price3.'"
        	          				data-item-sales-price-gift=0
        	          				
        	          				data-x-images="'.$img_src.'"
        	          				data-x-pendding-to-sales="'.$count_pendding_item_to_sales.'" 
        	          				
        	          				data-x-final-price="'.number_format($item_final_price).'₫"
        	          				data-x-sales-price="'.number_format($item_sales_price).'₫"
        	          				data-x-sales-price0="'.number_format($item_sales_price0).'₫"
        	          				data-x-sales-price1="'.number_format($item_sales_price1).'₫"
        	          				data-x-sales-price2="'.number_format($item_sales_price2).'₫"
        	          				data-x-sales-price3="'.number_format($item_sales_price3).'₫"
        	          				
        	          				data-item-cost="'.$item_cost.'"
        	          				data-item-tax-id="'.$item_tax_id.'"
        	          				data-item-tax-type="'.$item_tax_type.'"
        	          				data-item-tax-value="'.$item_tax.'"
        	          				data-item-tax-name="'.$item_tax_name.'"
        	          				data-item-tax-amt="'.$item_tax_amt.'"
        	          				data-purchase_price="'.$purchase_price.'"
        	          				data-discount_type="'.$discount_type.'"
        	          				data-discount="'.$discount.'"
        	           				style="margin-bottom: 3px; max-height: 150px;min-height: 150px;cursor: pointer;'.$bg_color.'">
        	           	<span class="label label-'.$bg_label.' push-right" style="font-weight: bold;font-family: sans-serif;" data-toggle="tooltip" title="'.$res2->stock.' Quantity in Stock">Kho: '.number_format($res2->stock).'</span>
        	           	<span id="pendding_items_to_sales" class="label label-success push-left" style="font-weight: bold;font-family: sans-serif;" data-toggle="tooltip" title="'.$res2->stock.' Quantity in Stock">Có thể bán: '.$count_pendding_item_to_sales.'</span>
        	            <div class="box-body box-profile">
        	                <center><img class=" img-responsive item_image" style="border: 1px solid gray;"  src="'.$img_src.'" alt="Item picture"></center>
        	                <lable class="text-center search_item" style="font-weight: bold;font-family: sans-serif; white-space: nowrap; text-overflow: ellipsis; overflow: hidden; " id="item_'.$i.'">'.substr($res2->item_name,0,25).'</label>
        	                <div id="LongPrice" class="" style="font-family: sans-serif;font-size:150%; " title="'.number_format($item_final_price).'₫ | '.number_format($item_sales_price0).'₫ | '.number_format($item_sales_price1).'₫ | '.number_format($item_sales_price2).'₫ | '.number_format($item_sales_price3).'₫">'.number_format($item_sales_price).'₫</div>
        	                
        	            </div>
        	            
        	          </div>
        	          <!--div style="text-align: center;"><button style="width: 100%;" type="button" class="btn btn-primary" onClick="viewAllPrice('.$i.')" >Xem chính sách giá</button></div-->
        	        </div>';
        	   
	          $i++;//

	          $last_id = $res2->id;
	          }//for end
	          $table.='<input type="hidden" class="last_id" id="'.$last_id.'" />';
	          return $table;
	      }//if num_rows() end
	     
	}
	public function get_details(){
		$CI =& get_instance();
		$data=$this->data;
		extract($data);
		extract($_POST);
		  $i=0;
		  $str='';

		  $table='';

	      $this->db->select("b.id as tax_id, a.*,b.tax,b.tax_name");
	      $this->db->from("db_items a");
	      $this->db->join("db_tax b","b.id=a.tax_id","left");
	      $this->db->where("a.status=1 and a.id <> -1");
	      //$this->db->order_by("a.stock","DESC");
	      if(!empty($id)){
		  	$this->db->where("a.category_id",$id);
		  }
		  if($brand_id!=''){
		  	$this->db->where(" a.brand_id=$brand_id");
		  }
		  if(isset($last_id) && !empty($last_id)){
		  	$this->db->where("a.id>".$last_id);
		  }
		  if(!empty($item_name)){
		  	$this->db->where("upper(a.item_name) like upper('%".$item_name."%')");
		  }
		  //$this->db->limit(5);
		  //echo $this->db->get_compiled_select();exit();
		  $q2=$this->db->get();

		  $last_id = '';
	      if($q2->num_rows()>0){
	        foreach($q2->result() as $res2){
	        	$item_tax_type = $res2->tax_type;
	        	$item_tax_id = $res2->tax_id;
	        	$item_sales_price = $res2->sales_price;
	        	$item_sales_price0 = $res2->final_price0;
	        	$item_sales_price1 = $res2->final_price1;
	        	$item_sales_price2 = $res2->final_price2;
	        	$item_sales_price3 = $res2->final_price3;
	        	$item_cost = $res2->purchase_price;
	        	$item_tax = $res2->tax;
	        	$item_tax_name = $res2->tax_name;
	        	$purchase_price = $res2->purchase_price;
	        	$discount_type = $res2->discount_type;
	        	$discount = $res2->discount;
	        	$item_sales_qty = 1;

	        	//Check Exculsive or Inclusive
	        	if($item_tax_type=='Exclusive'){
					//$single_unit_price = $item_sales_price;
					//$item_sales_price=$item_sales_price+ (($item_sales_price*$item_tax)/100);
					//$item_tax_amt = (($single_unit_price * $item_sales_qty)*$item_tax)/100;
				}
				else{//Inclusive	
					//$item_tax_amt=number_format($this->inclusive($item_sales_price,$item_tax),2,'.','');
					//$single_unit_price = $item_sales_price;
				}

				$item_tax_amt = ($item_tax_type=='Inclusive') ? calculate_inclusive($item_sales_price,$item_tax) :calculate_exclusive($item_sales_price,$item_tax);

				//$item_amount = ($item_sales_price * $item_sales_qty) + $item_tax_amt;
				//end 

	        	if($res2->stock <=0){
	        		//$str="zero_stock()";
	        		//$disabled='';
	        		$bg_label="danger";
	        		$bg_color="background-color:#c8c8c8";
	        	}
	        	else{
	        		//$str="addrow($res2->id)";
	        		//$disabled="disabled";
	        		$bg_label="info";
	        		$bg_color="background-color:#a1db75";
	        	}
	        	$str="addrow($res2->id)";
	        	$disabled="disabled=disabled";
	        	
	        	
	        	
	        	//$count_pendding_item_to_sales = count_sales_item_pendding($res2->id);
	        	//$count_pendding_item_to_sales = $res2->stock - $count_pendding_item_to_sales;
	        	
	        	$count_pendding_item_to_sales = cansold($res2->id);

	        	$img_src = (!empty($res2->item_image) && file_exists($res2->item_image)) ? base_url(return_item_image_thumb($res2->item_image)) : base_url('theme/images/no_image.png');
                
	        	$table .= '<div class="col-md-2 col-xs-3 " id="item_parent_'.$i.'" '.$disabled.' data-toggle="tooltip" title="'.$res2->item_name.'" style="padding-left:5px;padding-right:5px;padding-bottom: 5px;">
	        	    
        	          <div class="box box-default item_box" id="div_'.$res2->id.'" onclick="'.$str.'"
        	          				data-item-id="'.$res2->id.'"
        	          				data-item-name="'.$res2->item_name.'"
        	          				data-item-available-qty="'.$res2->stock.'"
        	          				data-item-sales-price="'.$item_sales_price.'"
        	          				data-item-sales-price0="'.$item_sales_price0.'"
        	          				data-item-sales-price1="'.$item_sales_price1.'"
        	          				data-item-sales-price2="'.$item_sales_price2.'"
        	          				data-item-sales-price3="'.$item_sales_price3.'"
        	          				data-item-sales-price-gift=0
        	          				
        	          				data-x-images="'.$img_src.'"
        	          				data-x-pendding-to-sales="'.$count_pendding_item_to_sales.'" 
        	          				
        	          				data-x-sales-price="'.number_format($item_sales_price).'₫"
        	          				data-x-sales-price0="'.number_format($item_sales_price0).'₫"
        	          				data-x-sales-price1="'.number_format($item_sales_price1).'₫"
        	          				data-x-sales-price2="'.number_format($item_sales_price2).'₫"
        	          				data-x-sales-price3="'.number_format($item_sales_price3).'₫"
        	          				
        	          				data-item-cost="'.$item_cost.'"
        	          				data-item-tax-id="'.$item_tax_id.'"
        	          				data-item-tax-type="'.$item_tax_type.'"
        	          				data-item-tax-value="'.$item_tax.'"
        	          				data-item-tax-name="'.$item_tax_name.'"
        	          				data-item-tax-amt="'.$item_tax_amt.'"
        	          				data-purchase_price="'.$purchase_price.'"
        	          				data-discount_type="'.$discount_type.'"
        	          				data-discount="'.$discount.'"
        	           				style="margin-bottom: 3px; max-height: 150px;min-height: 150px;cursor: pointer;'.$bg_color.'">
        	           	<span class="label label-'.$bg_label.' push-right" style="font-weight: bold;font-family: sans-serif;" data-toggle="tooltip" title="'.$res2->stock.' Quantity in Stock">Kho: '.number_format($res2->stock).'</span>
        	           	<span id="pendding_items_to_sales" class="label label-success push-left" style="font-weight: bold;font-family: sans-serif;" data-toggle="tooltip" title="">Có thể bán: '.$count_pendding_item_to_sales.'</span>
        	            <div class="box-body box-profile">
        	                <center><img class=" img-responsive item_image" style="border: 1px solid gray;"  src="'.$img_src.'" alt="Item picture"></center>
        	                <lable class="text-center search_item" style="font-weight: bold;font-family: sans-serif; white-space: nowrap; text-overflow: ellipsis; overflow: hidden; " id="item_'.$i.'">'.substr($res2->item_name,0,25).'</label>
        	                <div id="LongPrice" class="" style="font-family: sans-serif;font-size:130%; " title="'.number_format($item_sales_price0).'₫ | '.number_format($item_sales_price1).'₫ | '.number_format($item_sales_price2).'₫ | '.number_format($item_sales_price3).'₫">'.number_format($item_sales_price).'₫</div>
        	                
        	            </div>
        	            
        	          </div>
        	          <!--div style="text-align: center;"><button style="width: 100%;" type="button" class="btn btn-primary" onClick="viewAllPrice('.$i.')" >Xem chính sách giá</button></div-->
        	        </div>';
        	   
	          $i++;//

	          $last_id = $res2->id;
	          }//for end
	          $table.='<input type="hidden" class="last_id" id="'.$last_id.'" />';
	          return $table;
	      }//if num_rows() end
	     
	}
	//CROSS SITE FILTER
	public function xss_html_filter($input){
		return $this->security->xss_clean(html_escape($input));
	}
	
	//Save Sales
	public function pos_save_update(){//Save or update sales /pos_save_update?command=save&tot_qty=6&tot_amt=460000&tot_disc=0&tot_grand=460000&paid_amt=60,000&balance=400&pay_all=false
		$this->db->trans_begin();
		extract($this->xss_html_filter(array_merge($this->data,$_POST,$_GET)));
		//echo "<pre>";print_r($this->xss_html_filter(array_merge($this->data,$_POST,$_GET)));exit();
        //echo "<pre>";print_r($paid_amt);
		$rowcount 			=$hidden_rowcount;
		$sales_date 		= (isset($sales_date)) ?  $sales_date : $CUR_DATE;
		$sales_date			= date('Y-m-d',strtotime($sales_date));

		//$points 			= (empty($points_use)) ? 'NULL' : $points_use;
		$discount_input 	= (empty($discount_input)) ? 'NULL' : $discount_input;
		$tot_disc 		= (empty($tot_disc) || $tot_disc==0) ? 'NULL' : $tot_disc;
		$tot_grand 		= (empty($tot_grand)) ? 'NULL' : $tot_grand;
		//$tot_grand		=round($tot_amt);
		$round_off = number_format($tot_grand-$tot_amt,2,'.','');
		//($in_tam ==  1) ? $inn = "Temps" : $inn = "Final";
		$in_tam 		= (empty($in_tam)) ? 'Quotation' : $in_tam;
		
		

		//FIND CUSTOMER INFORMATION BY ITS ID
		$q1=$this->db->query("select customer_name,mobile,customer_point from db_customers where id=$customer_id");
		$customer_name 	= $q1->row()->customer_name;
		$mobile 		= $q1->row()->mobile;
		$customer_point = $q1->row()->customer_point;
		

        
        
		
		if($command=='update'){
				$sales_entry = array(
		    				'sales_date' 				=> $sales_date,
		    				'sales_status' 				=> $in_tam,
		    				'customer_id' 				=> $customer_id,
		    				/*'warehouse_id' 				=> $warehouse_id,*/
		    				/*Discount*/
		    				'discount_to_all_input' 	=> $discount_input,
		    				'discount_to_all_type' 		=> $discount_type,
		    				'tot_discount_to_all_amt' 	=> $tot_disc,
		    				/*Other Charges*/
		    				'other_charges_input' 		=> $other_charges,
		    				'other_charges_amt' 		=> $other_charges,
		    				/*Subtotal & Total */
		    				'subtotal' 					=> $tot_amt,
		    				'round_off' 				=> $round_off,
		    				'grand_total' 				=> $tot_grand,
		    			);
					
				$q3 = $this->db->where('id',$sales_id)->update('db_sales', $sales_entry);

				$q6 = $this->db->select("item_id")->from("db_salesitems")->where("sales_id in ($sales_id)")->get();

				$q11=$this->db->query("delete from db_salesitems where sales_id='$sales_id'");
				$q12=$this->db->query("delete from db_salespayments where sales_id='$sales_id'");
				if(!$q11 || !$q12){
					return "failed";
				}


				if($q6->num_rows()>0){
					$this->load->model('pos_model');				
					foreach ($q6->result() as $res6) {
						$q6=$this->pos_model->update_items_quantity($res6->item_id);
						if(!$q6){
							return "failed";
						}
					}
					
				}
		}
		else{
			//GET SALES INITIAL
			$q5=$this->db->query("select sales_init from db_company where id=1");
			$init=$q5->row()->sales_init;	
			

			//ORDER SALES CREATION
			$maxid=$this->db->query("SELECT COALESCE(MAX(id),0)+1 AS maxid FROM db_sales")->row()->maxid;
			$sales_code=$init.time().str_pad($maxid, 6, '0', STR_PAD_LEFT);

			$sales_entry = array(
		    				'sales_code' 				=> $sales_code, 
		    				'sales_date' 				=> $sales_date,
		    				'sales_status' 				=> $in_tam,
		    				'customer_id' 				=> $customer_id,
		    				/*'warehouse_id' 				=> $warehouse_id,*/
		    				/*Discount*/
		    				'discount_to_all_input' 	=> $discount_input,
		    				'discount_to_all_type' 		=> $discount_type,
		    				'tot_discount_to_all_amt' 	=> $tot_disc,
		    				/*Other Charges*/
		    				'other_charges_input' 		=> $other_charges,
		    				'other_charges_amt' 		=> $other_charges,
		    				/*Subtotal & Total */
		    				'subtotal' 					=> $tot_amt,
		    				'round_off' 				=> $round_off,
		    				'grand_total' 				=> $tot_grand,
		    				/*System Info*/
		    				'created_date' 				=> $CUR_DATE,
		    				'created_time' 				=> $CUR_TIME,
		    				'created_by' 				=> $CUR_USERNAME,
		    				'system_ip' 				=> $SYSTEM_IP,
		    				'system_name' 				=> $SYSTEM_NAME,
		    				'pos' 						=> 1,
		    				'status' 					=> 1,
		    			);

			$q3 = $this->db->insert('db_sales', $sales_entry);
			$sales_id = $this->db->insert_id();
			
			
			 
			
		}

		
		
		//Import post data from form
		for($i=0;$i<$rowcount;$i++){
		
			if(isset($_REQUEST['tr_item_id_'.$i]) && trim($_REQUEST['tr_item_id_'.$i])!=''){
			
				//RECEIVE VALUES FROM FORM
				$item_id 	=$this->xss_html_filter(trim($_REQUEST['tr_item_id_'.$i]));
				$sales_qty 	=$this->xss_html_filter(trim($_REQUEST['item_qty_'.$i.'_'.$item_id]));
				$price_per_unit =$this->xss_html_filter(trim($_REQUEST['sales_price_'.$i]));
				$tax_amt =$this->xss_html_filter(trim($_REQUEST['td_data_'.$i.'_11']));
				$tax_type =$this->xss_html_filter(trim($_REQUEST['tr_tax_type_'.$i]));
				$tax_id =$this->xss_html_filter(trim($_REQUEST['tr_tax_id_'.$i]));
				$tax_value =$this->xss_html_filter(trim($_REQUEST['tr_tax_value_'.$i]));//%
				$total_cost =$this->xss_html_filter(trim($_REQUEST['td_data_'.$i.'_4']));
				$description =$this->xss_html_filter(trim($_REQUEST['td_description_'.$i]));
				$purchase_price =$this->xss_html_filter(trim($_REQUEST['purchase_price_'.$i]));
				
				$item_name = trim($_REQUEST['td_data_'.$i.'_0']);

				$discount_type =$this->xss_html_filter(trim($_REQUEST['item_discount_type_'.$i]));
				$discount_input =$this->xss_html_filter(trim($_REQUEST['item_discount_input_'.$i]));
				$discount_amt =$this->xss_html_filter(trim($_REQUEST['item_discount_'.$i]));
				$discount_amt = (empty($discount_amt)) ? 0 : $discount_amt;
				
				$discount_amt_per_unit = $discount_amt/$sales_qty;

				if($tax_type=='Exclusive'){
					$single_unit_total_cost = $price_per_unit + ($tax_value * $price_per_unit / 100);
				}
				else{//Inclusive
					$single_unit_total_cost =$price_per_unit;
				}
				$single_unit_total_cost-=$discount_amt_per_unit;


				
				if($tax_id=='' || $tax_id==0){$tax_id=null;}
				if($tax_amt=='' || $tax_amt==0){$tax_amt=null;}
				if($total_cost=='' || $total_cost==0){$total_cost=null;}
				
				/*if(!empty($discount_to_all_input) && $discount_to_all_input!=0){
					$discount_amt =null;
				}*/
				/* ******************************** */

				/*$item_details = get_item_details($item_id);
				$current_stock_of_item = $item_details->stock;
				if($current_stock_of_item<$sales_qty){
					return $item_details->item_name." has only ".$current_stock_of_item." in Stock!!";exit;
				}*/
				
				$salesitems_entry = array(
				            'item_name' => $item_name,
		    				'sales_id' 			=> $sales_id, 
		    				'sales_status'		=> $in_tam, 
		    				'item_id' 			=> $item_id, 
		    				'description' 		=> $description, 
		    				'sales_qty' 		=> $sales_qty,
		    				'price_per_unit' 	=> $price_per_unit,
		    				'tax_id' 			=> $tax_id,
		    				'tax_amt' 			=> $tax_amt,
		    				'tax_type' 			=> $tax_type,
		    				'discount_type' 	=> $discount_type,
		    				'discount_input' 	=> $discount_input,
		    				'discount_amt' 		=> $discount_amt,
		    				'unit_total_cost' 	=> $single_unit_total_cost,
		    				'total_cost' 		=> $total_cost,
		    				'purchase_price' 		=> $purchase_price,
		    				'status'	 		=> 1,
		    			);
				$q4 = $this->db->insert('db_salesitems', $salesitems_entry);

				$q11=$this->update_items_quantity($item_id);
				if(!$q11){
					return "failed";
				}

			}
		
		}//for end
		
		if($pay_all=='true'){
			$by_cash=true;
			$payment_row_count=1;
		}
		else{
			$by_cash=false;
		}
		
		//UPDATE CUSTMER MULTPLE PAYMENTS
		for($i=1;$i<=$payment_row_count;$i++){
		
			if((isset($_REQUEST['amount_'.$i]) && trim($_REQUEST['amount_'.$i])!='') || ($by_cash==true)){

				if($by_cash==true){
					//RECEIVE VALUES FROM FORM
					$amount 		=$tot_grand;
					$payment_type 	='Cash';
					$payment_note 	='Paid By Cash';
				}
				else{
					//RECEIVE VALUES FROM FORM
					$amount 		=$this->xss_html_filter(trim($_REQUEST['amount_'.$i]));
					$payment_type 	=$this->xss_html_filter(trim($_REQUEST['payment_type_'.$i]));
					$payment_note 	=$this->xss_html_filter(trim($_REQUEST['payment_note_'.$i]));
				}

				//If amount is greater than paid amount
				$change_return=0;
				if($amount>$tot_grand){
					$change_return =$amount-$tot_grand;
					$amount =$tot_grand;
				}
				//end
				
				$salespayments_entry = array(
					'sales_id' 		=> $sales_id, 
					'payment_date'		=> $sales_date,//Current Payment with sales entry
					'payment_type' 		=> $payment_type,
					'payment' 			=> $amount,
					'payment_note' 		=> $payment_note,
					'created_date' 		=> $CUR_DATE,
    				'created_time' 		=> $CUR_TIME,
    				'created_by' 		=> $CUR_USERNAME,
    				'system_ip' 		=> $SYSTEM_IP,
    				'system_name' 		=> $SYSTEM_NAME,
    				'change_return' 	=> $change_return,
    				'status' 			=> 1,
				);

			  $q7 = $this->db->insert('db_salespayments', $salespayments_entry);
			  
			    

			    if(!$q7)
				{
					//echo "q7\n";	
					return "failed";
				} else {
				    $point_system = get_site_settings_config('point_system');
                    $minpaid_get_point = get_site_settings_config('minpaid_get_point');
                    $point_get_per_minpaid = get_site_settings_config('point_get_per_minpaid');
                    $sales_code = get_sales_code($sales_id);
                    
                    $getPoint = floor(($amount / $minpaid_get_point) * $point_get_per_minpaid);
                    $point_add = $customer_point + $getPoint;
                    $sales_point = array('customer_point' => $point_add);
				    
				    
				    if($point_system == 1) {
				        add_customer_point($customer_id,$sales_point);
                        log_customer_point($customer_id,'Pos_model: '.$command.' | Sales Code: '.$sales_code,$customer_point,$getPoint,'Tăng mới '.number_format($getPoint).' điểm tích lũy cho hóa đơn: '. $sales_code); 
				    }
				    
				}
				
			}//if()
		
		}//for end

	
		//UPDATE itemS QUANTITY IN itemS TABLE
		$this->load->model('sales_model');				
		$q6=$this->sales_model->update_sales_payment_status($sales_id,$customer_id);
		if(!$q6){
			return "failed";
		}

		if(isset($hidden_invoice_id) && !empty($hidden_invoice_id)){
			$q13=$this->hold_invoice_delete($hidden_invoice_id);
			if(!$q13){
				return "failed";
			}
		}
		//COMMIT RECORD
		$this->db->trans_commit();
		
		$sms_info='';
		if(isset($send_sms) && $customer_id!=1){
			if(send_sms_using_template($sales_id,1)==true){
				$sms_info = 'SMS Has been Sent!';
			}else{
				$sms_info = 'Failed to Send SMS';
			}
		}

		$this->session->set_flashdata('success', 'Success!! Sales Created Successfully!'.$sms_info);
        return "success<<<###>>>$sales_id";


	}

	public function update_items_quantity($item_id){
		//UPDATE itemS QUANTITY IN itemS TABLE
		$q7=$this->db->query("select COALESCE(SUM(qty),0) as stock_qty from db_stockentry where item_id='$item_id'");
		$stock_qty=$q7->row()->stock_qty;

		$q8=$this->db->query("select COALESCE(SUM(purchase_qty),0) as pu_tot_qty from db_purchaseitems where item_id='$item_id' and purchase_status='Received'");
		$pu_tot_qty=$q8->row()->pu_tot_qty;
		
		$q9=$this->db->query("select coalesce(SUM(sales_qty),0) as sl_tot_qty from db_salesitems where item_id='$item_id' and sales_status in ('Final','Shipping')");
		$sl_tot_qty=$q9->row()->sl_tot_qty;

		/*Fid Return Items Count*/
		$q6=$this->db->query("select COALESCE(SUM(return_qty),0) as pu_return_tot_qty from db_purchaseitemsreturn where item_id='$item_id' ");/*and purchase_id is null */
		$pu_return_tot_qty=$q6->row()->pu_return_tot_qty;

		/*Fid Return Items Count*/
		$q6=$this->db->query("select COALESCE(SUM(return_qty),0) as sl_return_tot_qty from db_salesitemsreturn where item_id='$item_id' ");/*and sales_id is null */
		$sl_return_tot_qty=$q6->row()->sl_return_tot_qty;

		$stock=((($stock_qty+$pu_tot_qty)-$sl_tot_qty)+$sl_return_tot_qty)-$pu_return_tot_qty;
		$q7=$this->db->query("update db_items set stock=$stock where id='$item_id'");
		if($q7){
			return true;
		}
		else{
			return false;
		}
	}	
	

	public function edit_pos($sales_id){
		$data=$this->data;
		extract($data);
	     $q2=$this->db->query("select * from db_sales where id='$sales_id'");
	    if($q2->num_rows()>0){
	      $res2=$q2->row();
	      $sales_date=show_date($res2->sales_date);
	      $customer_id=$res2->customer_id;
	      $discount_input=$res2->discount_to_all_input;
	      $discount_type=$res2->discount_to_all_type;
	      $grand_total=$res2->grand_total;
	      $other_charges=$res2->other_charges_amt;
	      
	      $q3=$this->db->query("SELECT * FROM db_salesitems WHERE sales_id='$sales_id'");
		  $rows=$q3->num_rows();
		  if($rows>0){
		  	$i=0;
		  	
		  	foreach ($q3->result() as $res3) { 
		  		$q5=$this->db->query("select a.item_name,a.purchase_price,a.stock from db_items a where a.id=".$res3->item_id);
		  		$price_per_unit = $res3->price_per_unit;
		  		$description = $res3->description;
		  		$stock=$q5->row()->stock + $res3->sales_qty;

		  		$item_discount = $res3->discount_amt;
		  		$item_discount_type = $res3->discount_type;
		  		$item_discount_input = $res3->discount_input;

		  		$q6=$this->db->query("select * from db_tax where id=".$res3->tax_id)->row();

		  		//$item_tax_type = $q5->row()->tax_type;
	        	/*if($item_tax_type=='Exclusive'){
	        		$per_item_price_inc_tax=$price_per_unit+(($price_per_unit*$q5->row()->tax)/100);
				}
				else{//Inclusive	
					$per_item_price_inc_tax=$price_per_unit;
				}*/
				$per_item_price_inc_tax=$price_per_unit;
				$per_item_price_display = number_format($per_item_price_inc_tax,0,'.', ',');
				$per_item_price_value = number_format($per_item_price_inc_tax,2,'.','');	

				$tax_amt = $res3->tax_amt;
				$tax_type = $res3->tax_type;
				$tax_id = $res3->tax_id;
				$tax_value = $q6->tax;

		  		$quantity        ='<div class="input-group input-group-sm"><span class="input-group-btn"><button onclick="decrement_qty('.$res3->item_id.','.$i.')" type="button" class="btn btn-default btn-flat"><i class="fa fa-minus text-danger"></i></button></span>';
			    $quantity       .='<input type="text" value="'.$res3->sales_qty.'" class="form-control text-center" style="background-color: white !important; color: black !important; font-weight: bold !important; min-width: 60px !important;" onkeyup="item_qty_input('.$res3->item_id.','.$i.')" id="item_qty_'.$i.'_'.$res3->item_id.'" name="item_qty_'.$i.'_'.$res3->item_id.'">';
			    $quantity       .='<span class="input-group-btn"><button onclick="increment_qty('.$res3->item_id.','.$i.')" type="button" class="btn btn-default btn-flat"><i class="fa fa-plus text-success"></i></button></span></div>';
			    //$sub_total       =$per_item_price_inc_tax * $res3->sales_qty;
			    $sub_total = $res3->total_cost;
			    $sub_total_display = number_format($sub_total,0,'.', ',');
			    $remove_btn      ='<a class="fa fa-fw fa-trash-o text-red" style="cursor: pointer;font-size: 20px;" onclick="removerow('.$i.')" title="Delete Item?"></a>';
			    
		  		echo '<tr id="row_'.$i.'" data-row="0" data-item-id="'.$res3->item_id.'" class="itemrows" data-rowcount="'.$i.'">'; /*item id */
		  		echo '<td id="td_'.$i.'_0">
		  		<a data-toggle="tooltip" title="Click to Change Tax" class="pointer" id="td_data_'.$i.'_0" onclick="show_sales_item_modal('.$i.')">'.$q5->row()->item_name.'<i onclick="" class="fa fa-edit pointer"></i></a>
		  		</td>';  /*td_0_0 item name*/
		  		
		  		echo '<td id="td_'.$i.'_2">'.$quantity.'</td>';    /*td_0_2 item quantity */

		  		$info = '<input id="sales_price_'.$i.'" onblur="set_to_original('.$i.','.$res3->purchase_price.')" onkeyup="update_price('.$i.','.$res3->purchase_price.')" name="sales_price_'.$i.'" type="text" class="form-control text-left no-padding" value="'.$per_item_price_display.'" data-raw-value="'.$per_item_price_value.'">';

		  		echo '<td id="td_'.$i.'_3" class="text-right" >'.$info.'</td>';    /*td_0_3 item sales price */

		  		/*Discount*/
		  		$item_discount_display = ($item_discount > 0) ? number_format($item_discount,0,'.', ',') : $item_discount;
		  		$info = '<input data-toggle="tooltip" title="Click to Change" onclick="show_sales_item_modal('.$i.')" id="item_discount_'.$i.'" readonly name="item_discount_'.$i.'" type="text" class="form-control text-left no-padding" value="'.$item_discount_display.'">';

		  		echo '<td id="td_'.$i.'_6" class="text-right" >'.$info.'</td>';    /*td_0_6 item discount */

		  		echo '<td id="td_'.$i.'_11" class="'.tax_disable_class().'"><input data-toggle="tooltip" title="Click to Change" id="td_data_'.$i.'_11" onclick="show_sales_item_modal('.$i.')" name="td_data_'.$i.'_11" type="text" class="form-control no-padding pointer" readonly value="'.$tax_amt.'"></td>';    /*td_0_11 item tax */

		  		echo '<td id="td_'.$i.'_4" class="text-right" >
		  		<input data-toggle="tooltip" title="Total" id="td_data_'.$i.'_4" name="td_data_'.$i.'_4" type="text" class="form-control no-padding pointer" readonly value="'.$sub_total_display.'" data-raw-value="'.$sub_total.'"></td>';    /*td_0_4 item sub_total */
		  		echo '<td id="td_'.$i.'_5">'.$remove_btn.'</td>';    /* td_0_5 remove button */

		  		echo '<input type="hidden" name="tr_item_id_'.$i.'" id="tr_item_id_'.$i.'" value="'.$res3->item_id.'">'; 
		  		echo '<input type="hidden" id="tr_item_per_'.$i.'" name="tr_item_per_'.$i.'" value="'.$q6->tax.'">';
		  		echo '<input type="hidden" id="tr_sales_price_temp_'.$i.'" name="tr_sales_price_temp_'.$i.'" value="'.$per_item_price_value.'">';
		  		echo '<input type="hidden" id="tr_stock_'.$i.'" name="tr_stock_'.$i.'" value="'.$stock.'">';
		  		echo '</tr>';
		  		echo '<input type="hidden" id="tr_tax_type_'.$i.'" name="tr_tax_type_'.$i.'" value="'.$tax_type.'">';
        		echo '<input type="hidden" id="tr_tax_id_'.$i.'" name="tr_tax_id_'.$i.'" value="'.$tax_id.'">';
        		echo '<input type="hidden" id="tr_tax_value_'.$i.'" name="tr_tax_value_'.$i.'" value="'.$tax_value.'">';
        		echo '<input type="hidden" id="description_'.$i.'" name="description_'.$i.'" value="'.$description.'">';
        		echo '<input type="hidden" id="item_discount_type_'.$i.'" name="item_discount_type_'.$i.'" value="'.$item_discount_type.'">';
        		echo '<input type="hidden" id="item_discount_input_'.$i.'" name="item_discount_input_'.$i.'" value="'.$item_discount_input.'">';
        		echo '<input type="hidden" id="purchase_price_'.$i.'" name="purchase_price_'.$i.'" value="'.$res3->purchase_price.'">';
		  		
		  		$i++;
		  	}//foreach() end

		  	echo "<<<###>>>".$discount_input."<<<###>>>".$discount_type."<<<###>>>".$customer_id."<<<###>>>".$other_charges."<<<###>>>".show_date($sales_date);

		  }//if ()
		 
	    }
	    else{
	      print "Record Not Available";
	    }
	     
	}//edit_pos()

	
	/* ######################################## HOLD INVOICE ############################# */
	
	public function hold_invoice_list(){
		$data=$this->data;
		extract($data);
		extract($_POST);
		  $i=0;
		  $str ='';
	      $q2=$this->db->query("select * from db_hold order by id desc");
	      if($q2->num_rows()>0){
	        foreach($q2->result() as $res2){
	     
                  $str =$str."<tr>";
                  $str =$str."<td width='10%'>".$res2->id."</td>";
                  $str =$str."<td width='10%'>".show_date($res2->sales_date)."</td>";
                  $str =$str."<td width='60%' style='text-align: left;'>".$res2->reference_id."</td>";
                  $str =$str."<td width='20%'>";
                    $str =$str.'<a class="fa fa-fw fa-print text-success" style="cursor: pointer;font-size: 20px;" onclick="print_invoice('.$res2->id.')" title="In tạm tính"></a>';
                  	$str =$str.'<a class="fa fa-fw fa-trash-o text-red" style="cursor: pointer;font-size: 20px;" onclick="hold_invoice_delete('.$res2->id.')" title="Xóa"></a>';
                  	$str =$str.'<a class="fa fa-fw fa-edit text-success" style="cursor: pointer;font-size: 20px;" onclick="hold_invoice_edit('.$res2->id.')" title="Sửa"></a>';
                  $str =$str."</td>";
                $str =$str."</tr>";
	     
	          $i++;
	          }//for end
	      }//if num_rows() end
	      else{
	      	
	      	$str =$str."<tr>";
	      		$str =$str.'<td colspan="4" class="text-danger text-center">Không treo giữ đơn hàng nào cả</td>';
	      	$str =$str.'</tr>';
	      	
	      }
		return $str;
	}
	public function hold_invoice_delete($id){
		$this->db->trans_begin();
		$q1=$this->db->query("DELETE from db_hold where id='$id'");
		if(!$q1){
			return "failed";
		}
		//COMMIT RECORD
		$this->db->trans_commit();
        return "success";

	}

	
	public function hold_invoice_edit(){
		$data=$this->data;
		extract($this->xss_html_filter(array_merge($this->data,$_POST,$_GET)));
	     $q2=$this->db->query("select * from db_hold where id='$hold_id'");
	    if($q2->num_rows()>0){
	      $res2=$q2->row();
	      $sales_date=show_date($res2->sales_date);
	      $customer_id=$res2->customer_id;
	      $discount_input=$res2->discount_to_all_input;
	      $discount_type=$res2->discount_to_all_type;
	      $grand_total=$res2->grand_total;
	      $sales_note=$res2->sales_note;
	      $other_charges=$res2->other_charges_amt;

	      $q3=$this->db->query("SELECT * FROM db_holditems WHERE hold_id='$hold_id'");
		  $rows=$q3->num_rows();
		  if($rows>0){
		  	$i=0;
		  	
		  	$q599=$this->db->query("select sum(sales_qty) as subtotalsp from db_holditems where hold_id='$hold_id'");
		  	$sumtotalsp = $q599->row()->subtotalsp;
		  	
		  	
		  	foreach ($q3->result() as $res3) { 
		  		$q5=$this->db->query("select a.item_name,a.final_price,a.purchase_price,a.stock from db_items a where a.id=".$res3->item_id);
		  		$price_per_unit = $res3->price_per_unit;
		  		$description = $res3->description;
		  		$stock=$q5->row()->stock + $res3->sales_qty;

		  		$item_discount = $res3->discount_amt;
		  		$item_discount_type = $res3->discount_type;
		  		$item_discount_input = $res3->discount_input;

		  		$q6=$this->db->query("select * from db_tax where id=".$res3->tax_id)->row();

		  		//$item_tax_type = $q5->row()->tax_type;
	        	/*if($item_tax_type=='Exclusive'){
	        		$per_item_price_inc_tax=$price_per_unit+(($price_per_unit*$q5->row()->tax)/100);
				}
				else{//Inclusive	
					$per_item_price_inc_tax=$price_per_unit;
				}*/
				$per_item_price_inc_tax=$price_per_unit;
				$per_item_price_inc_tax=number_format($per_item_price_inc_tax,0,'.','');	

				$tax_amt = $res3->tax_amt;
				$tax_type = $res3->tax_type;
				$tax_id = $res3->tax_id;
				$tax_value = $q6->tax;

		  		$quantity        ='<div class="input-group input-group-sm"><span class="input-group-btn"><button onclick="decrement_qty('.$res3->item_id.','.$i.')" type="button" class="btn btn-default btn-flat"><i class="fa fa-minus text-danger"></i></button></span>';
			    $quantity       .='<input typ="text" value="'.$res3->sales_qty.'" class="form-control text-center" onchange="item_qty_input('.$res3->item_id.','.$i.')" id="item_qty_'.$i.'_'.$res3->item_id.'" name="item_qty_'.$i.'_'.$res3->item_id.'">';
			    $quantity       .='<span class="input-group-btn"><button onclick="increment_qty('.$res3->item_id.','.$i.')" type="button" class="btn btn-default btn-flat"><i class="fa fa-plus text-success"></i></button></span></div>';
			    //$sub_total       =$per_item_price_inc_tax * $res3->sales_qty;
			    $sub_total = $res3->sales_qty * $res3->price_per_unit;
			    $remove_btn      ='<a class="fa fa-fw fa-trash-o text-red" style="cursor: pointer;font-size: 20px;" onclick="removerow('.$i.')" title="Xóa SP?"></a>';
			    
			    
			    
			    echo '<tr id="tr_items_name_'.$i.'"><td colspan="5" id="td_'.$i.'_0"><span id="td_data_'.$i.'_0" style="white-space: break-spaces; text-overflow: ellipsis; overflow: hidden;"><i class="fa fa-plus-square" onclick="addrow_gift('.$res3->item_id.');"></i> '.$q5->row()->item_name.'</span></td></tr>';
			    echo '<tr id="tr_items_desc_'.$i.'"><td colspan="5" ><input type="text" class="form-control" name="td_description_'.$i.'" id="td_description_'.$i.'" placeholder="Ghi chú thêm cho sản phẩm '.$q5->row()->item_name.' (Nếu có)" /></td></tr>';
                echo '<tr class="itemrows" data-rowcount="'.$i.'" id="row_'.$i.'" data-price-lv="" data-row="0" data-item-id='.$res3->item_id.'>';/*item id*/
			    echo '<td id="td_'.$i.'_2">'.$quantity.'</td>';/* td_0_2 item available qty*/
			    $info1='<input id="sales_price_'.$i.'" onblur="set_to_original('.$i.','.$res3->price_per_unit.')" onkeyup="update_price('.$i.','.$q5->row()->final_price.')" name="sales_price_'.$i.'" type="text" class="form-control no-padding min_width priceset" value="'.$res3->price_per_unit.'">';
            
            
            
            
            
            
                echo '<td id="td_'.$i.'_3" class="text-right">'. $info1   .'</td>';/* td_0_3 item sales price*/
        
                /*Discount*/
                 $info2='<input data-toggle="tooltip" title="" id="item_discount_'.$i.'" readonly name="item_discount_'.$i.'" type="text" class="form-control no-padding min_width pointer" value="0">';
                 
                echo '<td id="td_'.$i.'_6" class="text-right">'. $info2   .'</td>';
        
                /*Tax amt*/
                echo '<td id="td_'.$i.'_11" class="'.tax_disable_class().'"><input data-toggle="tooltip" title="Click to Change" id="td_data_'.$i.'_11" onclick="show_sales_item_modal('.$i.')" name="td_data_'.$i.'_11" type="text" class="form-control no-padding pointer min_width" readonly value="'.$tax_amt.'"></td>';
        
                echo '<td id="td_'.$i.'_4" class="text-right"><input data-toggle="tooltip" title="" id="td_data_'.$i.'_4" name="td_data_'.$i.'_4" type="text" class="form-control no-padding pointer" readonly value="'.$sub_total.'"></td>';/* td_0_4 item sub_total */
                echo '<td id="td_'.$i.'_5">'. $remove_btn    .'</td>';/* td_0_5 item gst_amt */
        
                echo '<input type="hidden" name="tr_item_id_'.$i.'" id="tr_item_id_'.$i.'" value="'.$res3->item_id.'">';
                echo '<input type="hidden" id="tr_sales_price_temp_'.$i.'" name="tr_sales_price_temp_'.$i.'" value="'.$per_item_price_inc_tax.'">';
                echo '<input type="hidden" id="tr_tax_type_'.$i.'" name="tr_tax_type_'.$i.'" value="'.$tax_type.'">';
                echo '<input type="hidden" id="tr_tax_id_'.$i.'" name="tr_tax_id_'.$i.'" value="'.$tax_id.'">';
                echo '<input type="hidden" id="tr_tax_value_'.$i.'" name="tr_tax_value_'.$i.'" value="'.$tax_value.'">';
                echo '<input type="hidden" id="description_'.$i.'" name="description_'.$i.'" value="'.$description.'">';
                echo '<input id="item_discount_type_'.$i.'" name="item_discount_type_'.$i.'" type="hidden" value="'.$item_discount_type.'">';
                 echo '<input id="item_discount_input_'.$i.'" name="item_discount_input_'.$i.'" type="hidden" value="'.$item_discount_input.'">';
                 echo '<input type="hidden" id="purchase_price_'.$i.'" name="purchase_price_'.$i.'" value="'.$q5->row()->purchase_price.'">';
        
                echo '</tr>'; 
			   // echo '<script>make_subtotal('.$res3->item_id.','.$i.')</script>';
			    
			    
			    
			    
			    
		  		//echo '<tr id="row_'.$i.'" data-row="0" data-item-id="'.$res3->item_id.'" >'; /*item id */
		  		//echo '<td id="td_'.$i.'_0"><a data-toggle="tooltip" title="Click to Change Tax" class="pointer" id="td_data_'.$i.'_0" onclick="show_sales_item_modal('.$i.')">'.$q5->row()->item_name.'<i onclick="" class="fa fa-edit pointer"></i></a></td>';  /*td_0_0 item name*/
		  		//echo '<td id="td_'.$i.'_1">'.$stock.'</td>';  /*td_0_1 item available qty*/
		  		//echo '<td id="td_'.$i.'_2">'.$quantity.'</td>';    /*td_0_2 item available qty */

		  		//$info = '<input id="sales_price_'.$i.'" onblur="set_to_original('.$i.','.$q5->row()->purchase_price.')" onkeyup="update_price('.$i.','.$q5->row()->purchase_price.')" name="sales_price_'.$i.'" type="text" class="form-control text-left no-padding" value="'.$per_item_price_inc_tax.'">';

		  		//echo '<td id="td_'.$i.'_3" class="text-right" >'.$info.'</td>';    /*td_0_3 item sales price */

		  		/*Discount*/
		  		//$info = '<input data-toggle="tooltip" title="Click to Change" onclick="show_sales_item_modal('.$i.')" id="item_discount_'.$i.'" readonly name="item_discount_'.$i.'" type="text" class="form-control text-left no-padding" value="'.$item_discount.'">';

		  		//echo '<td id="td_'.$i.'_6" class="text-right" >'.$info.'</td>';


		  		//echo '<td id="td_'.$i.'_11" class="'.tax_disable_class().'"><input data-toggle="tooltip" title="Click to Change" id="td_data_'.$i.'_11" onclick="show_sales_item_modal('.$i.')" name="td_data_'.$i.'_11" type="text" class="form-control no-padding pointer" readonly value="'.$tax_amt.'"></td>';

		  		//echo '<td id="td_'.$i.'_4" class="text-right" ><input data-toggle="tooltip" title="Total" id="td_data_'.$i.'_4" name="td_data_'.$i.'_4" type="text" class="form-control no-padding pointer" readonly value="'.number_format($sub_total,2,'.','').'"></td>';    /*td_0_4 item sub_total */
		  		//echo '<td id="td_'.$i.'_5">'.$remove_btn.'</td>';    /* td_0_5 item gst_amt  */

		  		//echo '<input type="hidden" name="tr_item_id_'.$i.'" id="tr_item_id_'.$i.'" value="'.$res3->item_id.'">'; 
		  		//echo '<input type="hidden" id="tr_item_per_'.$i.'" name="tr_item_per_'.$i.'" value="'.$q6->tax.'">';
		  		//echo '<input type="hidden" id="tr_sales_price_temp_'.$i.'" name="tr_sales_price_temp_'.$i.'" value="'.$per_item_price_inc_tax.'">';
		  		//echo '</tr>';
		  		//echo '<input type="hidden" id="tr_tax_type_'.$i.'" name="tr_tax_type_'.$i.'" value="'.$tax_type.'">';
        		//echo '<input type="hidden" id="tr_tax_id_'.$i.'" name="tr_tax_id_'.$i.'" value="'.$tax_id.'">';
        		//echo '<input type="hidden" id="tr_tax_value_'.$i.'" name="tr_tax_value_'.$i.'" value="'.$tax_value.'">';
        		//echo '<input type="hidden" id="description_'.$i.'" name="description_'.$i.'" value="'.$description.'">';
        		//echo '<input type="hidden" id="item_discount_type_'.$i.'" name="item_discount_type_'.$i.'" value="'.$item_discount_type.'">';
        		//echo '<input type="hidden" id="item_discount_input_'.$i.'" name="item_discount_input_'.$i.'" value="'.$item_discount_input.'">';
        		//echo '<input type="hidden" id="purchase_price_'.$i.'" name="purchase_price_'.$i.'" value="'.$q5->row()->purchase_price.'">';
        		
        		//echo '<script>make_subtotal(item_id,rowcount);</script>';
                //echo '<script>calculate_payments();</script>';
		  		
		  		$i++;

		  	}//foreach() end

		  	echo "<<<###>>>".$discount_input."<<<###>>>".$discount_type."<<<###>>>".$customer_id."<<<###>>>".$other_charges."<<<###>>>".$hold_id."<<<###>>>".$sumtotalsp;
		  }//if ()
		 
	    }
	    else{
	      print "Dữ liệu không tồn tại";
	    }
	     
	}//edit_pos()

	public function hold_list_save_update(){//Save or update sales
		$this->db->trans_begin();
		extract($this->xss_html_filter(array_merge($this->data,$_POST,$_GET)));
		//print_r($this->xss_html_filter(array_merge($this->data,$_POST,$_GET)));exit();

		$rowcount 			=$hidden_rowcount;
		$sales_date 		=date("Y-m-d",strtotime($CUR_DATE));
		//$points 			= (empty($points_use)) ? 'NULL' : $points_use;
		$discount_input 	= (empty($discount_input)) ? 'NULL' : $discount_input;
		$tot_disc 		= (empty($tot_disc) || $tot_disc==0) ? 'NULL' : $tot_disc;
		$tot_grand 		= (empty($tot_grand)) ? 'NULL' : $tot_grand;
		//$tot_grand		=round($tot_amt);
		$round_off = number_format($tot_grand-$tot_amt,2,'.','');
		

		$prev_item_ids = array();


		$tot = $this->db->select("count(*) as tot")->where("reference_id",$reference_id)->get("db_hold")->row()->tot;
		if($tot>0){
			$q11=$this->db->query("delete from db_hold where reference_id='$reference_id' ");
			if(!$q11){
				return "failed";
			}
		}
		

		$sales_entry = array(
						'reference_id' 				=> $reference_id,
	    				'sales_date' 				=> $sales_date,
	    				'sales_status' 				=> 'Quotation',
	    				'customer_id' 				=> $customer_id,
	    				/*Discount*/
	    				'discount_to_all_input' 	=> $discount_input,
	    				'discount_to_all_type' 		=> $discount_type,
	    				'tot_discount_to_all_amt' 	=> $tot_disc,
	    				/*Subtotal & Total */
	    				'subtotal' 					=> $tot_amt,
	    				'round_off' 				=> $round_off,
	    				'grand_total' 				=> $tot_grand,
	    				'pos' 						=> 1,
	    				'sales_note' 				=> '',
	    				'other_charges_amt'			=> $other_charges,
	    			);
		$q3 = $this->db->insert('db_hold', $sales_entry);
		$hold_id = $this->db->insert_id();
		
		//Import post data from form
		for($i=0;$i<$rowcount;$i++){
		
			if(isset($_REQUEST['tr_item_id_'.$i]) && trim($_REQUEST['tr_item_id_'.$i])!=''){
				
				//RECEIVE VALUES FROM FORM
				$item_id 	=$this->xss_html_filter(trim($_REQUEST['tr_item_id_'.$i]));
				$sales_qty 	=$this->xss_html_filter(trim($_REQUEST['item_qty_'.$i.'_'.$item_id]));
				$price_per_unit =$this->xss_html_filter(trim($_REQUEST['sales_price_'.$i]));
				$tax_amt =$this->xss_html_filter(trim($_REQUEST['td_data_'.$i.'_11']));
				$tax_type =$this->xss_html_filter(trim($_REQUEST['tr_tax_type_'.$i]));
				$tax_id =$this->xss_html_filter(trim($_REQUEST['tr_tax_id_'.$i]));
				$tax_value =$this->xss_html_filter(trim($_REQUEST['tr_tax_value_'.$i]));//%
				$total_cost =$this->xss_html_filter(trim($_REQUEST['td_data_'.$i.'_4']));
				$description =$this->xss_html_filter(trim($_REQUEST['td_description_'.$i]));
				
				$discount_type =$this->xss_html_filter(trim($_REQUEST['item_discount_type_'.$i]));
				$discount_input =$this->xss_html_filter(trim($_REQUEST['item_discount_input_'.$i]));
				$discount_amt =$this->xss_html_filter(trim($_REQUEST['item_discount_'.$i]));

				if($tax_type=='Exclusive'){
					$single_unit_total_cost = $price_per_unit + ($tax_value * $price_per_unit / 100);
				}
				else{//Inclusive
					$single_unit_total_cost =$price_per_unit;
				}

				
				if($tax_id=='' || $tax_id==0){$tax_id=null;}
				if($tax_amt=='' || $tax_amt==0){$tax_amt=null;}
				if($total_cost=='' || $total_cost==0){$total_cost=null;}
				
				
				/* ******************************** */
				
				$salesitems_entry = array(
		    				'hold_id' 			=> $hold_id, 
		    				'item_id' 			=> $item_id, 
		    				'description' 		=> $description, 
		    				'sales_qty' 		=> $sales_qty,
		    				'price_per_unit' 	=> $price_per_unit,
		    				'tax_id' 			=> $tax_id,
		    				'tax_amt' 			=> $tax_amt,
		    				'tax_type' 			=> $tax_type,
		    				'discount_type' 	=> $discount_type,
		    				'discount_input' 	=> $discount_input,
		    				'discount_amt' 		=> $discount_amt,
		    				'unit_total_cost' 	=> $single_unit_total_cost,
		    				'total_cost' 		=> $total_cost,
		    			);
				$q4 = $this->db->insert('db_holditems', $salesitems_entry);

				$q11=$this->update_items_quantity($item_id);
				if(!$q11){
					return "failed";
				}

			}
		
		}//for end
		

		//COMMIT RECORD
		$this->db->trans_commit();
		
		$this->session->set_flashdata('success', 'Success!! Sales Created Successfully!');
        return "success";


	}
}
