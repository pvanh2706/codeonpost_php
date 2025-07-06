<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Import extends MY_Controller {
	public function __construct(){
		parent::__construct();
		$this->load_global();
		$this->load->model('country_model','country');
	}

	public function customers(){
		$this->permission_check('import_customers');
		$data=$this->data;
		$data['page_title']=$this->lang->line('import_customers');
		$this->load->view('import/import_customers', $data);
	}

    public function xss_html_filter($input){
        return $this->security->xss_clean(html_escape($input));
    }

	public function import_customers_csv_old() {
                extract($this->xss_html_filter(array_merge($this->data)));
                $filename = $_FILES["import_file"]["name"];
                
                if($_FILES['import_file']['size'] > 0)
                {   
                    
                	$config['upload_path']          = './uploads/csv/customers';
	                $config['allowed_types']        = 'csv';
	                $this->load->library('upload', $config);

	                if ( ! $this->upload->do_upload('import_file')){
			                $error = array('error' => $this->upload->display_errors());
			                print($error['error']);
			                exit();
			        }
			        else{
			        	    $file_name=$this->upload->data('file_name');
			        }
			        
			      

                    $file = fopen('uploads/csv/customers/'.$file_name,"r");
                    
                    //Save flag
                    $flag='true';
                    $this->db->trans_begin();
                    $i=1;
                    while(($importdata = fgetcsv($file, NULL, ",")) !== FALSE){
                        if($i++==1){ continue; }
                        
                        //Customers name should not be empty
                        if(empty($importdata[0])){
                          continue;
                        }

                        $importdata=$this->xss_html_filter($importdata);

                        $qs5="select customer_init from db_company";
                        $q5=$this->db->query($qs5);
                        $customer_init=$q5->row()->customer_init;

                        //Create customers unique Number
                        $qs4="select coalesce(max(id),0)+1 as maxid from db_customers";
                        $q1=$this->db->query($qs4);
                        $maxid=$q1->row()->maxid;
                        $customer_code=$customer_init.str_pad($maxid, 4, '0', STR_PAD_LEFT);
                        //end

                        $customer_name=$importdata[0];
                        $mobile=$importdata[1];
                        //Validate This customers already exist or not
                        /*$query=$this->db->query("select * from db_customers where upper(customer_name)=upper('$customer_name')");
                        if($query->num_rows()>0){
                            echo "Import Failed!<br>'".$customer_name."'' Customer Name already Exist.<br>Row Number:".$i++;
                            exit();
                        }*/
                        $query2=$this->db->query("select * from db_customers where mobile='$mobile'");
                        if($query2->num_rows()>0 && !empty($mobile)){
                            echo "Import Failed!<br>'".$mobile."' Mobile Number already Exist.<br>Row Number:".$i++;
                            exit();
                        }

                        $country_name=trim($importdata[6]);
                        $state_name=trim($importdata[7]);
                        //if not exist country create it and return id, else just return id if exist
                    	$country_id=(!empty($country_name)) ? $this->get_country_id($country_name) : null;

                        //if not exist state create it and return id, else just return id if exist
                        $state_id=(!empty($state_name)) ? $this->get_state_id($state_name,$country_name,$country_id) : null;

                        
                        $row = array(
                            'customer_code'    	=>  $customer_code,
                            'customer_name'     =>  $customer_name,
                            'mobile'     		=>  !empty($mobile)?$mobile:'',
                            'email'         	=>  !empty($importdata[2])?$importdata[2]:'',
                            'phone'       	 	=>  !empty($importdata[3])?$importdata[3]:'',
                            'gstin'       		=>  !empty($importdata[4])?$importdata[4]:'',
                            'tax_number'       	=>  !empty($importdata[5])?$importdata[5]:'',
                            'country_id'       	=>  $country_id,
                            'state_id'       	=>  $state_id,
                            'city'              =>  !empty($importdata[8])?$importdata[8]:'',
                            'postcode'          =>  !empty($importdata[9])?$importdata[9]:'',
                            'address'           =>  !empty($importdata[10])?$importdata[10]:'',
                            'opening_balance'   =>  !empty($importdata[11])?$importdata[11]:'',
                            /*System Info*/
                            'created_date'              => $CUR_DATE,
                            'created_time'              => $CUR_TIME,
                            'created_by'                => $CUR_USERNAME,
                            'system_ip'                 => $SYSTEM_IP,
                            'system_name'               => $SYSTEM_NAME,
                            'status'                    => 1,
                        );
                        
                        //If any record failed to save flag will be set false,then all records rolled back
                        if(!$this->db->insert('db_customers',$row)){
                            $flag='false';
                        }
                        
                        //Compulsary records
                        if(empty($importdata[0])){
                          $flag='false';   
                        }


                        
                    }
                    
                    
                    if(!$flag){
                        $this->db->trans_rollback();
                        echo 'failed';
                    }else{
                        $this->db->trans_commit();
                        echo "success";
                        $this->session->set_flashdata('success', 'Success!! Customers Data Imported Successfully!');
                    }
                    fclose($file);
                }
            
 			//unlink('uploads/csv/customers/'.$file_name);
        }
    public function import_customers_csv() {
                extract($this->xss_html_filter(array_merge($this->data)));
                $filename = $_FILES["import_file"]["name"];
                
                if($_FILES['import_file']['size'] > 0)
                {   
                    
                	$config['upload_path']          = './uploads/csv/customers';
	                $config['allowed_types']        = 'csv';
	                $this->load->library('upload', $config);

	                if ( ! $this->upload->do_upload('import_file')){
			                $error = array('error' => $this->upload->display_errors());
			                print($error['error']);
			                exit();
			        }
			        else{
			        	    $file_name=$this->upload->data('file_name');
			        }
			        
			      

                    $file = fopen('uploads/csv/customers/'.$file_name,"r");
                    
                    //Save flag
                    $flag='true';
                    $this->db->trans_begin();
                    $i=1;
                    while(($importdata = fgetcsv($file, NULL, ",")) !== FALSE){
                        if($i++==1){ continue; }
                        
                        //Customers name should not be empty
                        if(empty($importdata[0])){
                          continue;
                        }

                        $importdata=$this->xss_html_filter($importdata);

                        $qs5="select customer_init from db_company";
                        $q5=$this->db->query($qs5);
                        $customer_init=$q5->row()->customer_init;

                        //Create customers unique Number
                        $qs4="select coalesce(max(id),0)+1 as maxid from db_customers";
                        $q1=$this->db->query($qs4);
                        $maxid=$q1->row()->maxid;
                        $customer_code=$customer_init.str_pad($maxid, 4, '0', STR_PAD_LEFT);
                        //end

                        $customer_name=$importdata[0];
                        $mobile=$importdata[5];
                        //Validate This customers already exist or not
                        /*$query=$this->db->query("select * from db_customers where upper(customer_name)=upper('$customer_name')");
                        if($query->num_rows()>0){
                            echo "Import Failed!<br>'".$customer_name."'' Customer Name already Exist.<br>Row Number:".$i++;
                            exit();
                        }*/
                        $query2=$this->db->query("select * from db_customers where mobile='$mobile'");
                        if($query2->num_rows()>0 && !empty($mobile)){
                            echo "Import Failed!<br>'".$mobile."' Mobile Number already Exist.<br>Row Number:".$i++;
                            exit();
                        }
                        
                        $customer_level = '';
                        
                        switch ($importdata[2]) {
                            case 'BANLE' :
                                $customer_level = -1;
                                break;
                            case 'CAP0' :
                                $customer_level = 0;
                                break;
                            case 'CAP1' :
                                $customer_level = 1;
                                break;
                            case 'CAP2' :
                                $customer_level = 2;
                                break;
                            case 'CAP3' :
                                $customer_level = 3;
                                break;
                        }
                        
                        
                        $country_name= '1';
                        $state_name= '1';
                        //if not exist country create it and return id, else just return id if exist
                    	$country_id=(!empty($country_name)) ? $this->get_country_id($country_name) : null;

                        //if not exist state create it and return id, else just return id if exist
                        $state_id=(!empty($state_name)) ? $this->get_state_id($state_name,$country_name,$country_id) : null;

                        
                        $row = array(
                            'customer_code'    	=>  $customer_code,
                            'customer_name'     =>  $customer_name,
                            'mobile'     		=>  !empty($mobile)?$mobile:'',
                            'email'         	=>  !empty($importdata[4])?$importdata[4]:'',
                            'phone'       	 	=>  !empty($importdata[5])?$importdata[5]:'',
                            'gstin'       		=>  '0',
                            'tax_number'       	=>  '0',
                            'country_id'       	=>  '1',
                            'state_id'       	=>  '1',
                            'city'              =>  '0',
                            'postcode'          =>  '0',
                            'address'           =>  !empty($importdata[11])?$importdata[11]:'',
                            'opening_balance'   =>  '0',
                            /*System Info*/
                            'created_date'              => $CUR_DATE,
                            'created_time'              => $CUR_TIME,
                            'created_by'                => $CUR_USERNAME,
                            'system_ip'                 => $SYSTEM_IP,
                            'system_name'               => $SYSTEM_NAME,
                            'status'                    => 1,
                            'customer_level'            => $customer_level,
                        );
                        
                        //If any record failed to save flag will be set false,then all records rolled back
                        if(!$this->db->insert('db_customers',$row)){
                            $flag='false';
                        }
                        
                        //Compulsary records
                        if(empty($importdata[0])){
                          $flag='false';   
                        }


                        
                    }
                    
                    
                    if(!$flag){
                        $this->db->trans_rollback();
                        echo 'failed';
                    }else{
                        $this->db->trans_commit();
                        echo "success";
                        $this->session->set_flashdata('success', 'Success!! Customers Data Imported Successfully!');
                    }
                    fclose($file);
                }
            
 			//unlink('uploads/csv/customers/'.$file_name);
        }  
    
    public function get_country_id($country_name=''){
        $q2=$this->db->query("select id from db_country where upper(country)=upper('$country_name')");
        if($q2->num_rows()>0){
            return $q2->row()->id;
        }
        else{
            $q2=$this->db->query("insert into db_country(country,status) values('$country_name',1)");
            if($q2){
                return $this->db->insert_id();
            }
            return false;
        }
    }
    public function get_state_id($state_name='',$country_name='',$country_id=''){
        $q2=$this->db->query("select id from db_states where upper(state)=upper('$state_name')");
        if($q2->num_rows()>0){
            return $q2->row()->id;
        }
        else{
            $q2=$this->db->query("insert into db_states(state,country,country_id,status) values('$state_name','$country_name',$country_id,1)");
            if($q2){
                return $this->db->insert_id();
            }
            return false;
        }
    }
    public function suppliers(){
        $this->permission_check('import_suppliers');
        $data=$this->data;
        $data['page_title']=$this->lang->line('import_suppliers');
        $this->load->view('import/import_suppliers', $data);
    }
    public function import_suppliers_csv() {
                extract($this->xss_html_filter(array_merge($this->data)));
                $filename = $_FILES["import_file"]["name"];
                
                if($_FILES['import_file']['size'] > 0)
                {   
                    
                    $config['upload_path']          = './uploads/csv/suppliers';
                    $config['allowed_types']        = 'csv';
                    $this->load->library('upload', $config);

                    if ( ! $this->upload->do_upload('import_file')){
                            $error = array('error' => $this->upload->display_errors());
                            print($error['error']);
                            exit();
                    }
                    else{
                            $file_name=$this->upload->data('file_name');
                    }
                    
                  

                    $file = fopen('uploads/csv/suppliers/'.$file_name,"r");
                    
                    //Save flag
                    $flag='true';
                    $this->db->trans_begin();
                    $i=1;
                    while(($importdata = fgetcsv($file, NULL, ",")) !== FALSE){
                        if($i++==1){ continue; }
                        //suppliers name should not be empty
                        if(empty($importdata[0])){
                          continue;
                        }

                        $importdata=$this->xss_html_filter($importdata);

                        $qs5="select supplier_init from db_company";
                        $q5=$this->db->query($qs5);
                        $supplier_init=$q5->row()->supplier_init;

                        //Create suppliers unique Number
                        $qs4="select coalesce(max(id),0)+1 as maxid from db_suppliers";
                        $q1=$this->db->query($qs4);
                        $maxid=$q1->row()->maxid;
                        $supplier_code=$supplier_init.str_pad($maxid, 4, '0', STR_PAD_LEFT);
                        //end

                        $supplier_name=$importdata[0];
                        $mobile=$importdata[1];
                        //Validate This suppliers already exist or not
                        /*$query=$this->db->query("select * from db_suppliers where upper(supplier_name)=upper('$supplier_name')");
                        if($query->num_rows()>0){
                            echo "Import Failed!<br>'".$supplier_name."'' supplier Name already Exist.<br>Row Number:".$i++;
                            exit();
                        }*/
                        $query2=$this->db->query("select * from db_suppliers where mobile='$mobile'");
                        if($query2->num_rows()>0 && !empty($mobile)){
                            echo "Import Failed!<br>'".$mobile."' Mobile Number already Exist.<br>Row Number:".$i++;
                            exit();
                        }

                        $country_name=trim($importdata[6]);
                        $state_name=trim($importdata[7]);
                        //if not exist country create it and return id, else just return id if exist
                        $country_id=(!empty($country_name)) ? $this->get_country_id($country_name) : null;

                        //if not exist state create it and return id, else just return id if exist
                        $state_id=(!empty($state_name)) ? $this->get_state_id($state_name,$country_name,$country_id) : null;

                        
                        $row = array(
                            'supplier_code'     =>  $supplier_code,
                            'supplier_name'     =>  $supplier_name,
                            'mobile'            =>  !empty($mobile)?$mobile:'',
                            'email'             =>  !empty($importdata[2])?$importdata[2]:'',
                            'phone'             =>  !empty($importdata[3])?$importdata[3]:'',
                            'gstin'             =>  !empty($importdata[4])?$importdata[4]:'',
                            'tax_number'        =>  !empty($importdata[5])?$importdata[5]:'',
                            'country_id'        =>  $country_id,
                            'state_id'          =>  $state_id,
                            'city'              =>  !empty($importdata[8])?$importdata[8]:'',
                            'postcode'          =>  !empty($importdata[9])?$importdata[9]:'',
                            'address'           =>  !empty($importdata[10])?$importdata[10]:'',
                            'opening_balance'   =>  !empty($importdata[11])?$importdata[11]:'',
                            /*System Info*/
                            'created_date'              => $CUR_DATE,
                            'created_time'              => $CUR_TIME,
                            'created_by'                => $CUR_USERNAME,
                            'system_ip'                 => $SYSTEM_IP,
                            'system_name'               => $SYSTEM_NAME,
                            'status'                    => 1,
                        );
                        
                        //If any record failed to save flag will be set false,then all records rolled back
                        if(!$this->db->insert('db_suppliers',$row)){
                            $flag='false';
                        }
                        
                        //Compulsary records
                        if(empty($importdata[0])){
                          $flag='false';   
                        }


                        
                    }
                    
                    
                    if(!$flag){
                        $this->db->trans_rollback();
                        echo 'failed';
                    }else{
                        $this->db->trans_commit();
                        echo "success";
                        $this->session->set_flashdata('success', 'Success!! suppliers Data Imported Successfully!');
                    }
                    fclose($file);
                }
            
            //unlink('uploads/csv/suppliers/'.$file_name);
        }


    public function items(){
        $this->permission_check('import_items');
        $data=$this->data;
        $data['page_title']=$this->lang->line('import_items');
        $this->load->view('import/import_items', $data);
    }
    public function import_items_csv_old() {
        
                extract($this->xss_html_filter(array_merge($this->data)));
               
                $filename = $_FILES["import_file"]["name"];
                $this->load->model('pos_model');      
                $this->load->model('items_model');      

                
                if($_FILES['import_file']['size'] > 0)
                {   
                    
                    $config['upload_path']          = './uploads/csv/items';
                    $config['allowed_types']        = 'csv';
                    $this->load->library('upload', $config);

                    if ( ! $this->upload->do_upload('import_file')){
                            $error = array('error' => $this->upload->display_errors());
                            print($error['error']);
                            exit();
                    }
                    else{
                            $file_name=$this->upload->data('file_name');
                    }
                    
                  
                    $file = fopen('uploads/csv/items/'.$file_name,"r");
                    
                    //Save flag
                    $flag=true;
                    $this->db->trans_begin();
                    $i=1;
                    while(($importdata = fgetcsv($file, NULL, ",")) !== FALSE){
                        if($i++==1){ continue; }

                        //Item name should not be empty
                        if(empty($importdata[0])){
                          continue;
                        }
                        
                        
                        $ItemName = $importdata[0];
                        
                        $qs5="select item_init from db_company";
                        $q5=$this->db->query($qs5);
                        $item_init=$q5->row()->item_init;

                        //Create items unique Number
                        $this->db->query("ALTER TABLE db_items AUTO_INCREMENT = 1");
                        $qs4="select coalesce(max(id),0)+1 as maxid from db_items";
                        $q1=$this->db->query($qs4);
                        $maxid=$q1->row()->maxid;
                        
                        $codecreate=time();
                        $item_code=$item_init.'-'.str_pad($maxid, 4, '0', STR_PAD_LEFT).'-'.$codecreate;
                        $item_sku_code='SKU-'.str_pad($maxid, 4, '0', STR_PAD_LEFT).'-'.substr($codecreate, 0, 5);
                        $item_hsn_code='HSN-'.str_pad($maxid, 4, '0', STR_PAD_LEFT).'-'.substr($codecreate, -5);
                        $item_barcode=$codecreate.str_pad($maxid, 4, '0', STR_PAD_LEFT);
                        
                        $CategoryName = $importdata[1];
                        $category_id=(!empty($CategoryName)) ? $this->get_category_id($CategoryName) : null;
                        
                        $ImagesName = $importdata[2];
                        if ($ImagesName){
                            $ImageContent = file_get_contents($ImagesName);
                            $ImagePatch = 'uploads/items/'.$item_code.'.jpg';
                            file_put_contents($ImagePatch, $ImageContent);
                            
                            $imagethumb = imagecreatefromjpeg($ImagePatch);
                            $imgResized = imagescale($imagethumb , 75, 50); // width=500 and height = 400
                            imagejpeg($imgResized, 'uploads/items/'.$item_code.'_thumb.jpg');
                            
                            
                            //$ImagePatchThumb = 'uploads/items/'.$item_code.'_thumb.jpg';
                            //file_put_contents($ImagePatchThumb, $ImageContent);
                            
                        } else {
                            $ImagePatch = 'uploads/items/no_img.png';
                        }
                        
                        
                        $UnitName = $importdata[3];
                        $unit_id=(!empty($UnitName)) ? $this->get_unit_id($UnitName) : null;
                        $BrandName = $importdata[4];
                        $brand_id=(!empty($BrandName)) ? $this->get_brand_id($BrandName) : null;
                        $GiaNhapHang = str_replace(',','',$importdata[5]);
                        $GiaBanLe = str_replace(',','',$importdata[6]);
                        $GiaCap0 = str_replace(',','',$importdata[7]);
                        $GiaCap1 = str_replace(',','',$importdata[8]);
                        $GiaCap2 = str_replace(',','',$importdata[9]);
                        $GiaCap3 = str_replace(',','',$importdata[10]);
                        
                        
                        
                        
                        
                        
                        
                        //$importdata = $this->xss_html_filter($importdata);
                        //$item_name = $importdata[0];
                        //Validate This items already exist or not
                        /*$item_count=$this->db->query("select count(*) as item_count from db_items where upper(item_name)=upper('$item_name')")->row()->item_count;
                        
                        if($item_count>0){
                            echo "Import Failed!<br>'".$item_name."'' Item Name already Exist.<br>Row Number:".$i++;
                            exit();
                        }*/
                       
                    
                        /*$category_name =$importdata[1];
                        $unit_name =$importdata[4];
                        $brand_name =$importdata[6];
                        $tax_name =$importdata[9];
                        $tax_per =$importdata[10];
                        $category_id=(!empty($category_name)) ? $this->get_category_id($category_name) : null;
                        $unit_id=(!empty($unit_name)) ? $this->get_unit_id($unit_name) : null;
                        $brand_id=(!empty($brand_name)) ? $this->get_brand_id($brand_name) : null;
                        $tax_id=(!empty($tax_name)) ? $this->get_tax_id($tax_name,$tax_per) : null;

                        $qs5="select item_init from db_company";
                        $q5=$this->db->query($qs5);
                        $item_init=$q5->row()->item_init;

                        //Create items unique Number
                        $this->db->query("ALTER TABLE db_items AUTO_INCREMENT = 1");
                        $qs4="select coalesce(max(id),0)+1 as maxid from db_items";
                        $q1=$this->db->query($qs4);
                        $maxid=$q1->row()->maxid;
                        $item_code=$item_init.str_pad($maxid, 4, '0', STR_PAD_LEFT);
                        //end

                        $purchase_price = !empty(trim($importdata[8]))?trim($importdata[8]):0;
                        if($importdata[11]=='Exclusive'){
                            $purchase_price += ($purchase_price*$tax_per)/100;
                        }

                        $final_price = (strtoupper(trim($importdata[11]))==strtoupper('Inclusive')) ? 0 : calculate_exclusive(trim($importdata[12]),$tax_per);
                        $final_price +=trim($importdata[12]);

                        $sales_price = !empty($importdata[12])?$importdata[12]:0;
                        $price = !empty($importdata[8])?$importdata[8]:0;
                        $profit_margin = ($sales_price-$price);
                        $profit_margin = ($price>0) ? ($profit_margin/$price)*100 : $profit_margin;*/

                        $row = array(
                            'item_code'         =>  $item_code, 
                            'sku'               =>  $item_sku_code,
                            'hsn'               =>  $item_hsn_code,
                            'item_name'         =>  $ItemName,
                            'category_id'       =>  $category_id,
                            'custom_barcode'    =>  $item_barcode,
                            'unit_id'           =>  $unit_id,
                            'brand_id'          =>  $brand_id,
                            'item_image'        =>  $ImagePatch,
                            
                            'tax_id'            =>  1,
                            'price'             =>  $GiaNhapHang,
                            'purchase_price'    =>  $GiaNhapHang,
                            'sales_price'       =>  $GiaBanLe,
                            'final_price'       =>  $GiaBanLe,
                            'final_price0'       =>  $GiaCap0,
                            'final_price1'       =>  $GiaCap1,
                            'final_price2'       =>  $GiaCap2,
                            'final_price3'       =>  $GiaCap3,

                            /*System Info*/
                            'created_date'              => $CUR_DATE,
                            'created_time'              => $CUR_TIME,
                            'created_by'                => $CUR_USERNAME,
                            'system_ip'                 => $SYSTEM_IP,
                            'system_name'               => $SYSTEM_NAME,
                            'status'                    => 1,
                        );
                        
                        //$row = array_map('utf8_encode', $row);

                        //If any record failed to save flag will be set false,then all records rolled back
                        $this->db->query('set names utf8');
                        if(!$this->db->insert('db_items',$row)){
                            $flag=false;
                        }
                        
                        //Compulsary records
                        if(empty($importdata[0])){
                          $flag=false;   
                        }
                        $item_id = $this->db->insert_id();
                        
                        /*if(!empty($importdata[13]) && $importdata[13]>0){
                            $info = array(
                                        'entry_date'            => $CUR_DATE, 
                                        'item_id'               => $item_id,
                                        'qty'                   => $importdata[13],
                                        'status'                => 1,
                                    );

                            $q1 = $this->db->insert('db_stockentry', $info);
                            if(!$q1){
                                $flag=false;   
                            }
                        }*/

                        $q1=$this->items_model->stock_entry($CUR_DATE,$item_id);
                        if(!$q1){
                            $flag=false; //new
                            return "failed";
                        }

                        

                        //UPDATE itemS QUANTITY IN itemS TABLE
                        $q6=$this->pos_model->update_items_quantity($item_id);
                        if(!$q6){
                            $flag=false; //new
                            return "failed";
                        }
                        
                    }
                    
                    
                    
                    if(!$flag){
                        $this->db->trans_rollback();
                        echo 'failed';
                    }else{
                        $this->db->query("update db_items set expire_date=null where expire_date='0000-00-00'");
                        $this->db->trans_commit();
                        echo "success";
                        $this->session->set_flashdata('success', 'Thêm dữ liệu sản phẩm thành công!');
                    }
                    fclose($file);
                }
            
            //unlink('uploads/csv/items/'.$file_name);
        }
    public function import_items_csv() {
        
                extract($this->xss_html_filter(array_merge($this->data)));
               
                $filename = $_FILES["import_file"]["name"];
                $this->load->model('pos_model');      
                $this->load->model('items_model');      

                
                if($_FILES['import_file']['size'] > 0)
                {   
                    
                    $config['upload_path']          = './uploads/csv/items';
                    $config['allowed_types']        = 'csv';
                    $this->load->library('upload', $config);

                    if ( ! $this->upload->do_upload('import_file')){
                            $error = array('error' => $this->upload->display_errors());
                            print($error['error']);
                            exit();
                    }
                    else{
                            $file_name=$this->upload->data('file_name');
                    }
                    
                  
                    $file = fopen('uploads/csv/items/'.$file_name,"r");
                    
                    //Save flag
                    $flag=true;
                    $this->db->trans_begin();
                    $i=1;
                    while(($importdata = fgetcsv($file, NULL, ",")) !== FALSE){
                        if($i++==1){ continue; }

                        //Item name should not be empty
                        if(empty($importdata[12])){
                          continue;
                        }
                        
                        $ItemName = $importdata[12];//Tên sản phẩm
                        
                        $qs5="select item_init from db_company";
                        $q5=$this->db->query($qs5);
                        $item_init=$q5->row()->item_init;

                        //Create items unique Number
                        $this->db->query("ALTER TABLE db_items AUTO_INCREMENT = 1");
                        $qs4="select coalesce(max(id),0)+1 as maxid from db_items";
                        $q1=$this->db->query($qs4);
                        $maxid=$q1->row()->maxid;
                        
                        $codecreate=time();
                        $item_code=$item_init.'-'.str_pad($maxid, 4, '0', STR_PAD_LEFT).'-'.$codecreate;
                        
                        $item_sku_code='SKU-'.str_pad($maxid, 4, '0', STR_PAD_LEFT).'-'.substr($codecreate, 0, 5);
                        $item_hsn_code='HSN-'.str_pad($maxid, 4, '0', STR_PAD_LEFT).'-'.substr($codecreate, -5);
                        $item_barcode=$codecreate.str_pad($maxid, 4, '0', STR_PAD_LEFT);
                        
                        $CategoryName = $importdata[2]; // Danh mục
                        $category_id=(!empty($CategoryName)) ? $this->get_category_id($CategoryName) : $this->get_category_id("Chưa có danh mục");
                        
                        $ImagesName = $importdata[17];//Hình ảnh
                        if ($ImagesName){
                            $ImageContent = file_get_contents($ImagesName);
                            $ImagePatch = 'uploads/items/'.$item_code.'.jpg';
                            file_put_contents($ImagePatch, $ImageContent);
                            
                            $imagethumb = imagecreatefromjpeg($ImagePatch);
                            $imgResized = imagescale($imagethumb , 75, 50); // width=500 and height = 400
                            imagejpeg($imgResized, 'uploads/items/'.$item_code.'_thumb.jpg');
                        } else {
                            $ImagePatch = '';
                        }
                        
                        $UnitName = $importdata[18];//Đơn vị tính
                        $unit_id=(!empty($UnitName)) ? $this->get_unit_id($UnitName) : $this->get_unit_id("None");
                        $BrandName = $importdata[4];//Brandname
                        $brand_id=(!empty($BrandName)) ? $this->get_brand_id($BrandName) : $this->get_brand_id("NoName");
                        $GiaNhapHang = str_replace(',','',$importdata[33]);
                        $GiaBanLe = str_replace(',','',$importdata[31]);
                        $GiaCap0 = str_replace(',','',$importdata[34]);
                        $GiaCap1 = str_replace(',','',$importdata[35]);
                        $GiaCap2 = str_replace(',','',$importdata[32]);
                        $GiaCap3 = str_replace(',','',$importdata[36]);
                        $TonKho =  str_replace(',','',$importdata[26]);

                        $row = array(
                            'item_code'         =>  $item_code, 
                            'sku'               =>  $item_sku_code,
                            'hsn'               =>  $item_hsn_code,
                            'item_name'         =>  $ItemName,
                            'category_id'       =>  $category_id,
                            'custom_barcode'    =>  $item_barcode,
                            'unit_id'           =>  $unit_id,
                            'brand_id'          =>  $brand_id,
                            'item_image'        =>  $ImagePatch,
                            
                            'tax_id'            =>  1,
                            'price'             =>  $GiaNhapHang,
                            'purchase_price'    =>  $GiaNhapHang,
                            'sales_price'       =>  $GiaBanLe,
                            'final_price'       =>  $GiaBanLe,
                            'final_price0'       =>  $GiaCap0,
                            'final_price1'       =>  $GiaCap1,
                            'final_price2'       =>  $GiaCap2,
                            'final_price3'       =>  $GiaCap3,
                            //'stock'             =>  $TonKho,
                            /*System Info*/
                            'created_date'              => $CUR_DATE,
                            'created_time'              => $CUR_TIME,
                            'created_by'                => $CUR_USERNAME,
                            'system_ip'                 => $SYSTEM_IP,
                            'system_name'               => $SYSTEM_NAME,
                            'status'                    => 1,
                        );
                        
                        //$row = array_map('utf8_encode', $row);

                        //If any record failed to save flag will be set false,then all records rolled back
                        $this->db->query('set names utf8');
                        if(!$this->db->insert('db_items',$row)){
                            $flag=false;
                        }
                        
                        //Compulsary records
                        if(empty($importdata[12])){
                          $flag=false;   
                        }
                        $item_id = $this->db->insert_id();
                        
                        if(!empty($importdata[26]) && $importdata[26]>0){
                            $info = array(
                                        'entry_date'            => $CUR_DATE, 
                                        'item_id'               => $item_id,
                                        'qty'                   => str_replace(',','',$importdata[26]),
                                        'status'                => 1,
                                    );

                            $q1 = $this->db->insert('db_stockentry', $info);
                            if(!$q1){
                                $flag=false;   
                            }
                        }

                        $q1=$this->items_model->stock_entry($CUR_DATE,$item_id);
                        if(!$q1){
                            $flag=false; //new
                            return "failed";
                        }

                        //UPDATE itemS QUANTITY IN itemS TABLE
                        $q6=$this->pos_model->update_items_quantity($item_id);
                        if(!$q6){
                            $flag=false; //new
                            return "failed";
                        }
                        
                    }
                    
                    if(!$flag){
                        $this->db->trans_rollback();
                        echo 'failed';
                    }else{
                        $this->db->query("update db_items set expire_date=null where expire_date='0000-00-00'");
                        $this->db->trans_commit();
                        echo "success";
                        $this->session->set_flashdata('success', 'Thêm dữ liệu sản phẩm thành công!');
                    }
                    fclose($file);
                }
            
            //unlink('uploads/csv/items/'.$file_name);
        }
        
        public function get_category_id($category_name=''){

            $q2=$this->db->query("select id from db_category where upper(category_name)=upper('$category_name') ");
            if($q2->num_rows()>0){
                return $q2->row()->id;
            }
            else{   
                    //Create category unique Number
                    $qs4="select coalesce(max(id),0)+1 as maxid from db_category";
                    $q1=$this->db->query($qs4);
                    $maxid=$q1->row()->maxid;
                    $cat_code='CT'.str_pad($maxid, 4, '0', STR_PAD_LEFT);
                    //end
                    //If category name not found in destination, then create category
                    $info = array(
                        'category_code'             => $cat_code, 
                        'category_name'             => $category_name, 
                        'description'               => '',
                        'status'                    => 1,
                    );
                    $q1 = $this->db->insert('db_category', $info);
                    return $this->db->insert_id();                    
            }
        }
        public function get_unit_id($unit_name=''){
            $q2=$this->db->query("select id from db_units where upper(unit_name)=upper('$unit_name') ");
            if($q2->num_rows()>0){
                return $q2->row()->id;
            }
            else{
                    //If category name not found in destination, then create category
                    $info = array(
                            
                            'unit_name'                 => $unit_name, 
                            'description'               => '',
                            'status'                    => 1,
                        );
                    $q1 = $this->db->insert('db_units', $info);
                    return $this->db->insert_id();                   
            }
        }
        public function get_brand_id($brand_name=''){
            $q2=$this->db->query("select id from db_brands where upper(brand_name)=upper('$brand_name') ");
            if($q2->num_rows()>0){
                return $q2->row()->id;
            }
            else{
                    //If category name not found in destination, then create category
                    $info = array(
                            
                            'brand_name'                 => $brand_name, 
                            'description'               => '',
                            'status'                    => 1,
                        );
                    $q1 = $this->db->insert('db_brands', $info);
                    return $this->db->insert_id();                   
            }
        }
        public function get_tax_id($tax_name='',$tax_per=0){
            $q2=$this->db->query("select id from db_tax where upper(tax_name)=upper('$tax_name') ");
            if($q2->num_rows()>0){
                return $q2->row()->id;
            }
            else{
                    //If category name not found in destination, then create category
                    $info = array(
                            
                            'tax_name'                  => $tax_name, 
                            'tax'                       => $tax_per, 
                            'status'                    => 1,
                        );
                    $q1 = $this->db->insert('db_tax', $info);
                    return $this->db->insert_id();                   
            }
        }

}

