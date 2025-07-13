<?php 

defined('BASEPATH') OR exit('No direct script access allowed');

class Site_model extends CI_Model {
    public function get_details(){
		$data=$this->data;

		//Validate This suppliers already exist or not
		$query=$this->db->query("select * from db_sitesettings order by id asc limit 1");
		$query1=$this->db->query("select * from db_company order by id asc limit 1");
		if($query->num_rows()==0){
			show_404();exit;
		}
		else{
			/* QUERY 1*/
			$query=$query->row();
			$data['q_id']=$query->id;
            $data['site_name']=$query->site_name;
            $data['logo']=$query->logo;
            $data['currency_id']=$query->currency_id;			
            $data['currency_placement']=$query->currency_placement;			
            $data['language_id']=$query->language_id;			
            $data['timezone']=$query->timezone;			
            $data['date_format']=$query->date_format;			
            $data['time_format']=$query->time_format;			
            $data['sales_discount']=$query->sales_discount;/* Default sales discount */
            $data['change_return']=$query->change_return;
            $data['sales_invoice_format_id']=$query->sales_invoice_format_id;
            $data['sales_invoice_footer_text']=$query->sales_invoice_footer_text;
            $data['round_off']=$query->round_off;
            $data['disable_tax']=$query->disable_tax;
            $data['show_upi_code']=$query->show_upi_code;
            $data['number_to_words']=$query->number_to_words;
            $data['point_system']=$query->point_system;
            $data['minpaid_get_point']=$query->minpaid_get_point;
            $data['point_get_per_minpaid']=$query->point_get_per_minpaid;
            $data['show_due']=$query->show_due;
            $data['show_invoice_barcode']=$query->show_invoice_barcode;
            $data['show_payment_qrcode']=$query->show_payment_qrcode;
            $data['bank_name_qrcode']=$query->bank_name_qrcode;
            $data['bank_number_qrcode']=$query->bank_number_qrcode;
            $data['bank_account_qrcode']=$query->bank_account_qrcode;
            $data['pos_pass_price']=$query->pos_pass_price;
            
            /* QUERY 2*/
			$query1=$query1->row();
            $data['category_init']=$query1->category_init;
            $data['item_init']=$query1->item_init;
            $data['supplier_init']=$query1->supplier_init;
            $data['purchase_init']=$query1->purchase_init;
            $data['purchase_return_init']=$query1->purchase_return_init;
            $data['customer_init']=$query1->customer_init;
            $data['sales_init']=$query1->sales_init;
            $data['sales_return_init']=$query1->sales_return_init;
            $data['expense_init']=$query1->expense_init;
            $data['sales_terms_and_conditions']=$query1->sales_terms_and_conditions;

			return $data;
		}
	}
	public function reset_all_point(){
	    if ($this->db->simple_query("update db_customers set customer_point = 0")) {
	        log_customer_point(0, 0, 0, 0, 'Reset toàn bộ tích điểm của tất cả khách hàng');
	        return "success";
	    } else {
	        return "failed";
	    }
	}
	
	public function reset_all_data($items, $sales, $return, $logs){
	    //$this->db->trans_begin();
	    
	    if ($items == 1){
	        $this->db->query("delete from db_stockentry");
	        $this->db->query("delete from db_items");
	        unlink_image();
	    }
	    if ($sales == 1){
	        $this->db->query("delete from db_salespayments");
	        $this->db->query("delete from db_salesitems");
	        $this->db->query("delete from db_sales");
	        $this->db->query("delete from db_customer_payments");
	    }
	    if ($return == 1){
	        $this->db->query("delete from db_salespaymentsreturn");
            $this->db->query("delete from db_salesitemsreturn");
            $this->db->query("delete from db_salesreturn");
            $this->db->query("delete from db_purchasepayments");
            $this->db->query("delete from db_purchaseitems");
            $this->db->query("delete from db_purchase");
            $this->db->query("delete from db_purchasepaymentsreturn");
            $this->db->query("delete from db_purchaseitemsreturn");
            $this->db->query("delete from db_purchasereturn");
            $this->db->query("delete from db_customer_payments");
	    }
	    if ($logs == 1){
	        $this->db->query("delete from db_customer_point_logs");
	    }
        
            $this->db->query("delete from db_stockentry");
	        $this->db->query("delete from db_items");
	        unlink_image();
	        $this->db->query("delete from db_salespayments");
	        $this->db->query("delete from db_salesitems");
	        $this->db->query("delete from db_sales");
	        $this->db->query("delete from db_customer_payments");
	        $this->db->query("delete from db_salespaymentsreturn");
            $this->db->query("delete from db_salesitemsreturn");
            $this->db->query("delete from db_salesreturn");
            $this->db->query("delete from db_purchasepayments");
            $this->db->query("delete from db_purchaseitems");
            $this->db->query("delete from db_purchase");
            $this->db->query("delete from db_purchasepaymentsreturn");
            $this->db->query("delete from db_purchaseitemsreturn");
            $this->db->query("delete from db_purchasereturn");
            $this->db->query("delete from db_customer_payments");
            $this->db->query("delete from db_customer_point_logs");
            $this->db->query("delete from db_customer_point_logs");
	        
        /*if ($this->db->trans_status() === FALSE) {
            $this->db->trans_rollback();
            log_customer_point(0, 0, 0, 0, 'Ali BaBa và 40 tên cướp đã trốn thoát!');
            return "failed";
        } else {
            $this->db->trans_commit();
            log_customer_point(0, 0, 0, 0, 'Ali BaBa và 40 tên cướp đã bị bắt vào rọ!');
            
            return "success";
        }*/
        log_customer_point(0, 0, 0, 0, 'Ali BaBa và 40 tên cướp đã bị bắt vào rọ!');
        return "success";
	    
	}
	
	public function remap_all_data(){
	    $this->db->query("update db_items set search_for = vi_to_en(item_name), item_slug = slug_name(item_name)");
	    $this->db->query("update db_brands set brand_slug = slug_name(brand_name)");
	    $this->db->query("update db_category set category_slug = slug_name(category_name)");
	    $this->db->query("update db_customers set customer_name_en = vi_to_en(customer_name)");
	    $this->db->query("update db_suppliers set supplier_name_en = vi_to_en(supplier_name)");
        log_customer_point(0, 0, 0, 0, 'Remap dữ liệu hệ thống!');
        return "success";
	    
	}
	public function order_ok($orderid){
	    $this->load->database('default2', TRUE);
        $this->db2 = $this->load->database('default2', true);
        $this->db2->query("update transaction set status = 1 where id = $orderid");
        return "success";
	}
	
	public function update_site(){
		//Filtering XSS and html escape from user inputs 
		extract($this->security->xss_clean(html_escape(array_merge($this->data,$_POST))));
		//echo "<pre>";print_r($this->security->xss_clean(html_escape(array_merge($this->data,$_POST))));exit();
				
		
		$logo='';
		if(!empty($_FILES['logo']['name'])){
			$config['upload_path']          = './uploads/';
	        $config['allowed_types']        = 'gif|jpg|png';
	        $config['max_size']             = 300;
	        $config['max_width']            = 300;
	        $config['max_height']           = 300;

	        $this->load->library('upload', $config);

	        if ( ! $this->upload->do_upload('logo'))
	        {
	                $error = array('error' => $this->upload->display_errors());
	                print($error['error']);
	                exit();
	        }
	        else
	        {
	        	   $logo_name=$this->upload->data('file_name');
	        		$logo=" ,logo='$logo_name' ";
	        }
		}
        
		$change_return = (isset($change_return)) ? 1 : 0;
		$show_upi_code = (isset($show_upi_code)) ? 1 : 0;
		$round_off = (isset($round_off)) ? 1 : 0;
		$disable_tax = (isset($disable_tax)) ? 1 : 0;
        $query1="update db_sitesettings set language_id='$language_id',site_name='$site_name',currency_placement='$currency_placement',show_due='$show_due',show_invoice_barcode='$show_invoice_barcode',show_payment_qrcode='$show_payment_qrcode',
        bank_name_qrcode='$bank_name_qrcode',bank_number_qrcode='$bank_number_qrcode',bank_account_qrcode='$bank_account_qrcode',pos_pass_price='$pos_pass_price',
        currency_id='$currency',timezone='$timezone',date_format='$date_format',time_format='$time_format',
        sales_discount='$sales_discount',change_return=$change_return,show_upi_code=$show_upi_code, 
        round_off=$round_off,
        disable_tax=$disable_tax,
        number_to_words='$number_to_words',
        sales_invoice_format_id=$sales_invoice_format_id ,sales_invoice_footer_text='$sales_invoice_footer_text',point_system='$point_system',minpaid_get_point='$minpaid_get_point',point_get_per_minpaid='$point_get_per_minpaid'
         $logo where id=$q_id";
        $query1= $this->db->simple_query($query1);
      
        $query2="update db_company set category_init='$category_init',item_init='$item_init',
        supplier_init='$supplier_init',
        purchase_init='$purchase_init',
        purchase_return_init='$purchase_return_init',
        customer_init='$customer_init',
        sales_init='$sales_init',
        sales_return_init='$sales_return_init',
        sales_terms_and_conditions='$sales_terms_and_conditions',
        expense_init='$expense_init' where id=1";
        $query2= $this->db->simple_query($query2);
        $this->session->unset_userdata('currency');

		if (!$query1 || $query2){
		    return "success";
		}
		else{
		    return "failed";
		}
	}
	
	public function get_einvoice_config()
	{
		$query = $this->db->query("SELECT * FROM db_einvoice_config WHERE id = 1");
		
		if ($query->num_rows() > 0) {
			return $query->row_array();
		}
		
		return array();
	}
	
	public function save_einvoice_config($api_url, $username, $password, $provider_code)
	{
		$data = array(
			'api_url' => $api_url,
			'username' => $username,
			'password' => $password, // Trong thực tế nên mã hóa mật khẩu
			'provider_code' => $provider_code,
			'updated_at' => date('Y-m-d H:i:s')
		);
		
		// Kiểm tra xem có bản ghi nào chưa
		$query = $this->db->query("SELECT id FROM db_einvoice_config WHERE id = 1");
		
		if ($query->num_rows() > 0) {
			// Cập nhật
			$this->db->where('id', 1);
			$result = $this->db->update('db_einvoice_config', $data);
		} else {
			// Tạo mới
			$data['id'] = 1;
			$data['created_at'] = date('Y-m-d H:i:s');
			$result = $this->db->insert('db_einvoice_config', $data);
		}
		
		return $result;
	}
	
	public function create_einvoice_config_table()
	{
		// Tạo bảng cấu hình hóa đơn điện tử nếu chưa tồn tại
		$sql = "CREATE TABLE IF NOT EXISTS `db_einvoice_config` (
			`id` int(11) NOT NULL AUTO_INCREMENT,
			`api_url` varchar(255) NOT NULL,
			`username` varchar(100) NOT NULL,
			`password` varchar(255) NOT NULL,
			`provider_code` varchar(50) NOT NULL,
			`status` tinyint(1) DEFAULT '1',
			`created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
			`updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
			PRIMARY KEY (`id`)
		) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;";
		
		return $this->db->simple_query($sql);
	}
}

/* End of file Site_model.php */
