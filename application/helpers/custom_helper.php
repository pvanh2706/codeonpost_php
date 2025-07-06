<?php

function get_rolefake($id) {
    if ($id == 1) {
        echo "<small>QTV</small>";
    } else if ($id == 2) {
        echo "<small>Boss</small>";
    } else {
        echo "<small>Culi</small>";
    }
}

function getCompanyID() {
    $CI =& get_instance();
    $userID = $CI->session->userdata('inv_userid');
    $gCI = $CI->db->query("select company_id from db_users where id = $userID")->row()->company_id;
	return $gCI;
}



function get_itemsname_from_id($id) {
    $CI =& get_instance();
    $item_name = $CI->db->select('item_name')->where('id', $id)->get('db_items')->row(); 
    return $item_name->item_name;  
}
function count_order_web() {
    $CI =& get_instance();
    $CI->load->database('default2', TRUE);
                $CI->db2 = $CI->load->database('default2', true);
                $transaction = $CI->db2->select('count(*) as orders')->where('status', 0)->get('transaction')->row(); 
             
                
                if ($transaction->orders > 0 && $transaction->orders < 10) {
                    return '0'.$transaction->orders;
                } else {
                    return $transaction->orders;
                }
}

function show_last_week($data=''){
   $CI =& get_instance();
    if ($CI->session->userdata('view_date')=='dd/mm/yyyy') {
      $check = date('d/m/Y',strtotime(str_replace('/', '-', $date)));
      return date($check, strtotime('-7 days'));
    }
    elseif($CI->session->userdata('view_date')=='mm/dd/yyyy'){
      $check =  date("m/d/Y",strtotime($date));
      return date($check, strtotime('-7 days'));
    }
    else{
      $check =  date("d-m-Y",strtotime($date));
      return date($check, strtotime('-7 days'));
    }
  }
function howmanydaysinmonth($month, $year){
    $number = cal_days_in_month(CAL_GREGORIAN, $month, $year);
    return $number;
}
function numberofmonth($month,$year){
    $days = array();
    $number = cal_days_in_month(CAL_GREGORIAN, $month, $year);
    for ($i=1; $i<=$number; $i++) {
        $days[] = 'Ngày ' . $i ;
    }
    return json_encode($days);
}
function loadDataSalesChart($month) {
    $CI =& get_instance();
    $q1=$CI->db->query("SELECT DAY(sales_date) as day, sum(subtotal) as sales FROM `db_sales` WHERE MONTH(sales_date) = $month group BY sales_date ORDER BY sales_date");
    $rows = [];
    $sales = array();
    //$year = date("Y");
    //$number = cal_days_in_month(CAL_GREGORIAN, $month, $year);
    
    //for ($i=1; $i<=$number-$q1->num_rows(); $i++){
    //    $sales[] = 0;
    //}
        if($q1->num_rows() >0){
          foreach($q1->result() as $res1){
              //$rows[] = array(
                  //'date' => $res1->day,
                  //'sales' => number_format($res1->sales)
                  //number_format($res1->sales)
                 // );
                 
                 $sales[] = $res1->sales;
          }
        }
        return json_encode($sales);
}
function loadDataDaysChart($month) {
    $CI =& get_instance();
    $q1=$CI->db->query("SELECT DAY(sales_date) as day, sum(subtotal) as sales FROM `db_sales` WHERE MONTH(sales_date) = $month group BY sales_date ORDER BY sales_date");
    $rows = [];
    $sales = array();

        if($q1->num_rows() >0){
          foreach($q1->result() as $res1){
                 $sales[] = 'Ngày ' . $res1->day;
          }
        }
        return json_encode($sales);
}


function count_sales_item_pendding($itemid) {
    $CI =& get_instance();
    return $CI->db->query('SELECT sum(sales_qty) as count_pendding FROM db_salesitems where item_id='.$itemid.' and sales_status= "Quotation"')->row()->count_pendding;
    //echo $count_pendding_items;
}

function cv2img($url){
    require "pdfcrowd.php";
    
    try
    {
        // create the API client instance
        $client = new \Pdfcrowd\HtmlToImageClient("demo", "ce544b6ea52a5621fb9d55f8b542d14d");
    
        // configure the conversion
        $client->setOutputFormat("jpg");
        $client->setScreenshotWidth(600);
        $client->setUseMobileUserAgent(true);
    
        // run the conversion and write the result to a file
        $image = $client->convertUrlToFile($url, "result.jpg");
        echo $image;
    }
    catch(\Pdfcrowd\Error $why)
    {
        error_log("Pdfcrowd Error: {$why}\n");
        throw $why;
    }
}
function cansold($itemid) {
    $CI =& get_instance();
    $sold = 0;
    $stock = $CI->db->query("select stock from db_items where id = $itemid")->row();
    $checksold = $CI->db->query("select sum(sales_qty) as sumsold from db_salesitems where item_id = $itemid and sales_status in ('Quotation')")->row(); 
    
    $resultcheck = $stock->stock - $checksold->sumsold;
    
    /*if ($stock->stock < 0) {
        return 0;
    } else {
        return $resultcheck;
    }*/
    
    return $resultcheck;
    /*if ($resultcheck > 0) {
        return $resultcheck;
    } else {
        return 0;
    }*/
    
    
    
    //return $stock->stock - $checksold->sumsold;
}

function getCustomerAddress($cusID) {
    $CI =& get_instance();
    $sold = 0;
    $stock = $CI->db->query("select address from db_customers where id = $cusID")->row();
    return $stock->address;
}


function console_log($data, $context = 'Debug Objects LongHQ') {

    // Buffering to solve problems frameworks, like header() in this and not a solid return.
    ob_start();

    $output  = 'console.info(\'' . $context . ':\');';
    $output .= 'console.log(' . json_encode($data) . ');';
    $output  = sprintf('<script>%s</script>', $output);

    echo $output;
}

  function demo_app(){
    return false;
  }
  
  function unlink_image(){
        $query = $this->db->query("select item_image from db_items");

        foreach ($query->result() as $row)
        {
            unlink($row->item_image);
        }
      
  }
  
  function app_version(){
    return '2.4';
  }
  
    function getPrice_by_lv($lv, $itemid){
        $CI =& get_instance();
        $price = 0;
        switch ($lv){
            case 0:
                $price = $CI->db->select('final_price0')->where('id',$itemid)->get('db_items')->row()->final_price0;break;
            case 1:
                $price = $CI->db->select('final_price0')->where('id',$itemid)->get('db_items')->row()->final_price1;break;
            case 2:
                $price = $CI->db->select('final_price0')->where('id',$itemid)->get('db_items')->row()->final_price2;break;
            case 3:
                $price = $CI->db->select('final_price0')->where('id',$itemid)->get('db_items')->row()->final_price3;break;
            default:
                $price = $CI->db->select('final_price')->where('id',$itemid)->get('db_items')->row()->final_price;
        }
        return $price;
    }
  
  function permalink($string) {
        $str = $string;
        $str = preg_replace("/(à|á|ạ|ả|ã|â|ầ|ấ|ậ|ẩ|ẫ|ă|ằ|ắ|ặ|ẳ|ẵ)/", 'a', $str);
		$str = preg_replace("/(è|é|ẹ|ẻ|ẽ|ê|ề|ế|ệ|ể|ễ)/", 'e', $str);
		$str = preg_replace("/(ì|í|ị|ỉ|ĩ)/", 'i', $str);
		$str = preg_replace("/(ò|ó|ọ|ỏ|õ|ô|ồ|ố|ộ|ổ|ỗ|ơ|ờ|ớ|ợ|ở|ỡ)/", 'o', $str);
		$str = preg_replace("/(ù|ú|ụ|ủ|ũ|ư|ừ|ứ|ự|ử|ữ)/", 'u', $str);
		$str = preg_replace("/(ỳ|ý|ỵ|ỷ|ỹ)/", 'y', $str);
		$str = preg_replace("/(đ)/", 'd', $str);
		$str = preg_replace("/(À|Á|Ạ|Ả|Ã|Â|Ầ|Ấ|Ậ|Ẩ|Ẫ|Ă|Ằ|Ắ|Ặ|Ẳ|Ẵ)/", 'A', $str);
		$str = preg_replace("/(È|É|Ẹ|Ẻ|Ẽ|Ê|Ề|Ế|Ệ|Ể|Ễ)/", 'E', $str);
		$str = preg_replace("/(Ì|Í|Ị|Ỉ|Ĩ)/", 'I', $str);
		$str = preg_replace("/(Ò|Ó|Ọ|Ỏ|Õ|Ô|Ồ|Ố|Ộ|Ổ|Ỗ|Ơ|Ờ|Ớ|Ợ|Ở|Ỡ)/", 'O', $str);
		$str = preg_replace("/(Ù|Ú|Ụ|Ủ|Ũ|Ư|Ừ|Ứ|Ự|Ử|Ữ)/", 'U', $str);
		$str = preg_replace("/(Ỳ|Ý|Ỵ|Ỷ|Ỹ)/", 'Y', $str);
		$str = preg_replace("/(Đ)/", 'D', $str);
		$str = preg_replace("/(\“|\”|\‘|\’|\,|\!|\&|\;|\@|\#|\%|\~|\`|\=|\_|\'|\]|\[|\}|\{|\)|\(|\+|\^)/", '-', $str);
		$str = preg_replace("/( )/", '-', $str);
		echo $str;
    }
    
    function get_site_settings_config($string){
         $CI =& get_instance();
            return $CI->db->select($string)->get('db_sitesettings')->row()->$string;
    }
    function get_customer_point($customer_id){
        $CI =& get_instance();
        return $CI->db->select('customer_point')->where('id',$customer_id)->get('db_customers')->row()->customer_point;
    }
    function get_customer_id_by_sales($sales_id){
        $CI =& get_instance();
        return $CI->db->select('customer_id')->where('id',$sales_id)->get('db_sales')->row()->customer_id;
    }
    function get_customer_name_by_customer_id($customer_id){
        $CI =& get_instance();
        return $CI->db->select('customer_name')->where('id',$customer_id)->get('db_customers')->row()->customer_name;
    }
    function get_sales_code($sales_id){
        $CI =& get_instance();
        return $CI->db->select('sales_code')->where('id',$sales_id)->get('db_sales')->row()->sales_code;
    }
    function get_items_name_by_id($item_id){
        $CI =& get_instance();
        return $CI->db->select('item_name')->where('id',$item_id)->get('db_items')->row()->item_name;
    }
  
  function sql_mode(){
    $CI =& get_instance();
    $q1 = $CI->db->query("SELECT @@sql_mode AS sql_mode")->row();
    return $q1->sql_mode;
  }
  function is_sql_full_group_by_enabled(){
    $sql_mode = sql_mode();
    $sql_mode = strtoupper($sql_mode);

    $mode = 'ONLY_FULL_GROUP_BY';
    return (strpos($sql_mode, $mode) !== false) ? show_sql_mode_page() : false;
  }

  function show_sql_mode_page(){
    $CI =& get_instance();
    if(!$CI->db->query(" SET GLOBAL sql_mode=(SELECT REPLACE(@@sql_mode,'ONLY_FULL_GROUP_BY',''))")){
      show_error("Please make sure your database should not be enabled with SQL_FULL_GROUP_BY, For More information Click on Given link: <a href='".base_url()."/help/#full_group_by' target='_blank'>Click here to check!</a>(Full Group By Check)", 403, $heading = "SQL_FULL_GROUP_BY ENABLED!!");
    }else{
      return true;
    }
  }
  function system_fromatted_date($date=''){
  $CI =& get_instance();
    if ($CI->session->userdata('view_date')=='dd/mm/yyyy') {
      return date('Y-m-d',strtotime(str_replace('/', '-', $date)));
    }
    elseif($CI->session->userdata('view_date')=='mm/dd/yyyy'){
      return date("Y-m-d",strtotime($date));
    }
    else{
      return date("Y-m-d",strtotime($date));
    }
  }
	function show_date($date=''){
	$CI =& get_instance();
    if ($CI->session->userdata('view_date')=='dd/mm/yyyy') {
      return date('d/m/Y',strtotime(str_replace('/', '-', $date)));
    }
    elseif($CI->session->userdata('view_date')=='mm/dd/yyyy'){
      return date("m/d/Y",strtotime($date));
    }
    else{
      return date("d-m-Y",strtotime($date));
    }
  }
  function show_time($time=''){
    if(empty($time)){
      return $time;
    }
    $CI =& get_instance();
    if($CI->session->userdata('view_time')=='24') {
      return date('h:i',strtotime($time));
    }
    else{
      return date('h:i a',strtotime($time));
    }
  }

  function return_item_image_thumb($path=''){
    //return str_replace(".", "_thumb.", $path);
    return $path;
  }

  /*Find the change return show in pos or not*/
  function change_return_status(){
    $CI =& get_instance();
    return $CI->db->select('change_return')->get('db_sitesettings')->row()->change_return;
  }

  function get_change_return_amount($sales_id){
    $CI =& get_instance();
    return $CI->db->select('coalesce(sum(change_return),0) as change_return_amount')->where('sales_id',$sales_id)->get('db_salespayments')->row()->change_return_amount;
  }

  function get_invoice_format_id(){
    $CI =& get_instance();
    return $CI->db->select('sales_invoice_format_id')->where('id',1)->get('db_sitesettings')->row()->sales_invoice_format_id;
  }
  function is_enabled_round_off(){
    $CI =& get_instance();
    $round_off=$CI->db->select('round_off')->where('id',1)->get('db_sitesettings')->row()->round_off;
    if($round_off==1){
      return true;
    }
    return false;
  }
  function get_profile_picture(){
    $CI =& get_instance();
    $profile_picture = $CI->db->select('profile_picture')->where("id",$CI->session->userdata('inv_userid'))->get('db_users')->row()->profile_picture;
    if(!empty($profile_picture)){
      $profile_picture = base_url($profile_picture);
    }
    else{
      $profile_picture = base_url("theme/dist/img/avatar5.png");
    }
    return $profile_picture;
  }
  function record_customer_payment($customer_id=null){
    $CI =& get_instance();
    $customer_id_str='';
    if(empty($customer_id)){
      $CI->db->query("delete from db_customer_payments"); 
    }
    else{
      $CI->db->query("delete from db_customer_payments where customer_id=$customer_id");
      $customer_id_str = " and b.customer_id=$customer_id ";
    }
    
    
    $q1 = $CI->db->query("INSERT INTO db_customer_payments (salespayment_id,customer_id,payment_date,payment_type, 
      payment,payment_note,
      system_ip,system_name,created_date,
      created_time,created_by, STATUS ) 
      SELECT a.id,b.customer_id,a.payment_date,a.payment_type, 
           COALESCE(SUM(a.payment)),a.payment_note,
           a.system_ip,a.system_name,a.created_date,a.created_time,a.created_by,1 FROM db_salespayments AS a, db_sales AS b WHERE b.id=a.sales_id $customer_id_str GROUP BY b.customer_id,a.payment_type,a.payment_date,a.created_time,a.created_date");
    if(!$q1){
      return false;
    }
    return true;
  }
 function record_supplier_payment($supplier_id=null){
    $CI =& get_instance();
    $supplier_id_str='';
    if(empty($supplier_id)){
      $CI->db->query("delete from db_supplier_payments"); 
    }
    else{
      $CI->db->query("delete from db_supplier_payments where supplier_id=$supplier_id");
      $supplier_id_str = " and b.supplier_id=$supplier_id ";
    }

    $q1 = $CI->db->query("INSERT INTO db_supplier_payments ( purchasepayment_id,supplier_id,payment_date,payment_type, payment,payment_note,system_ip,system_name,created_date,created_time,created_by, STATUS ) SELECT a.id,b.supplier_id,a.payment_date,a.payment_type, COALESCE(SUM(a.payment)),a.payment_note,a.system_ip,a.system_name,a.created_date,a.created_time,a.created_by,1 FROM db_purchasepayments AS a, db_purchase AS b 
      WHERE b.id=a.purchase_id $supplier_id_str GROUP BY b.supplier_id,a.payment_type,a.payment_date,a.created_time,a.created_date");
    if(!$q1){
      return false;
    }
    return true;
  }
  function calculate_inclusive($amount,$tax){
  $tot = ($amount/(($tax/100)+1)/10);
    return number_format($tot,2,".","");
  }
  function calculate_exclusive($amount,$tax){
    $tot = (($amount*$tax)/(100));
    return number_format($tot,2,".","");
  }
  function app_number_format($value=''){
    return (empty($value)) ? number_format($value,0) : number_format($value,0);
  }
  function show_upi_code(){
    $CI =& get_instance();
    return $CI->db->select('show_upi_code')->get('db_sitesettings')->row()->show_upi_code;
  }
  function get_customer_details($customer_id){
    $CI =& get_instance();
    return $CI->db->select('*')->from('db_customers')->where('id',$customer_id)->get()->row();
  }
  function get_supplier_details($supplier_id){
    $CI =& get_instance();
    return $CI->db->select('*')->from('db_suppliers')->where('id',$supplier_id)->get()->row();
  }
  function get_site_details(){
    $CI =& get_instance();
    return $CI->db->select('*')->from('db_sitesettings')->where('id',1)->get()->row();
  }
  function is_tax_disabled(){
    return (get_site_details()->disable_tax==1) ? true : false;
  }
  function tax_disable_class(){
    return (is_tax_disabled()) ? 'hide' : 'block';
  }
  function log_customer_point($customer_id, $sales_id, $point_last, $getPoint, $point_info){
     $CI =& get_instance();
     $point_log_entry = array(
                            'customer_id' => $customer_id,
                            'sales_code' => $sales_id,
                            'point_last' => $point_last,
                            'point_value' => $getPoint,
                            'point_date' => time(),
                            'point_info' => $point_info
                        );
                        $CI->db->insert('db_customer_point_logs', $point_log_entry);
  }
  function add_customer_point($customer_id,$sales_point){
     $CI =& get_instance();
     $CI->db->where('id',$customer_id)->update('db_customers', $sales_point);

  }
  function date_difference($start_date,$end_date){
    // Declare two dates 
    $start_date = strtotime(date("Y-m-d",strtotime($start_date))); 
    $end_date = strtotime(date("Y-m-d",strtotime($end_date)));   
    // Get the difference and divide into  
    // total no. seconds 60/60/24 to get  
    // number of days 
    return ($end_date - $start_date)/60/60/24; 
  }
  function get_item_details($item_id){
    $CI =& get_instance();
    return $CI->db->select("*")
            ->from("db_items")
            ->where("id=",$item_id)->get()->row();
  }

  function get_country($country_id=''){
    $CI =& get_instance();
    if(trim($country_id) == '') { return null; }
    $Q1 = $CI->db->select("*")
            ->from("db_country")
            ->where("id=",$country_id)->get();
    if($Q1->num_rows()>0){
      return $Q1->row()->country;
    }
    return null;
  }

  function get_state($state_id=''){
    $CI =& get_instance();
    if(trim($state_id) == '') { return null; }
    $Q1 = $CI->db->select("*")
            ->from("db_states")
            ->where("id=",$state_id)->get();
    if($Q1->num_rows()>0){
      return $Q1->row()->country;
    }
    return null;
  }
  function get_sales_details($sales_id){
    $CI =& get_instance();
    return $CI->db->select('*')->from('db_sales')->where('id',$sales_id)->get()->row();
  }

  function permissions($permissions=''){
    $CI =& get_instance();
    //If he the Admin
    if($CI->session->userdata('inv_userid')==1){
      return true;
    }

    $tot=$CI->db->query('SELECT count(*) as tot FROM db_permissions where permissions="'.$permissions.'" and role_id='.$CI->session->userdata('role_id'))->row()->tot;
    if($tot==1){
      return true;
    }
     return false;
  }