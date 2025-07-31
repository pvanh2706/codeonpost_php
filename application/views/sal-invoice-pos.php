<!DOCTYPE html>
<html>
<head>
<!-- TABLES CSS CODE -->
<title><?= $page_title;?></title>
<!-- Bootstrap 3.3.6 -->
<?php include"comman/code_css_form.php"; ?>
<?php include"comman/PrintSend.php"; ?>
<?php include"comman/PrintSendLPR.php"; ?>
<link rel="stylesheet" href="<?php echo $theme_link; ?>bootstrap/css/bootstrap.min.css">
<style type="text/css">
	body{
		font-family: Arial, monospace;
		font-size: 12px;
		/*font-weight: bold;*/
		padding-top:15px;
	}

	@media print {
        .no-print { display: none; }
    }
</style>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.2/jquery.min.js"></script>
<script src="https://html2canvas.hertzen.com/dist/html2canvas.js"></script>
</head>
<!-- body onload="window.print();" -->
    <body  ><!--   -->
	<?php
	$CI =& get_instance();
	
    $q1=$this->db->query("select * from db_company where id=1 and status=1");
    $res1=$q1->row();
    $company_logo       =$res1->company_logo;
    $company_name		=$res1->company_name;
    $company_mobile		=$res1->mobile;
    $company_phone		=$res1->phone;
    $company_email		=$res1->email;
    $company_country	=$res1->country;
    $company_state		=$res1->state;
    $company_city		=$res1->city;
    $company_address	=$res1->address;
    $company_postcode	=$res1->postcode;
    $company_gst_no		=$res1->gst_no;//Goods and Service Tax Number (issued by govt.)
    $company_vat_number		=$res1->vat_no;//Goods and Service Tax Number (issued by govt.)


    $q4=$this->db->query("select sales_invoice_footer_text from db_sitesettings where id=1");
    $res4=$q4->row();
    $sales_invoice_footer_text=$res4->sales_invoice_footer_text;


  	$q3=$this->db->query("SELECT a.sales_due,a.customer_name,a.mobile,a.phone,a.gstin,a.tax_number,a.email,a.customer_point,
                           a.opening_balance,a.country_id,a.state_id,
                           a.postcode,a.address,b.sales_date,b.sales_status,b.created_time,b.reference_no,
                           b.sales_code,b.sales_note,b.tot_discount_to_all_amt,
                           coalesce(b.grand_total,0) as grand_total,
                           coalesce(b.subtotal,0) as subtotal,
                           coalesce(b.paid_amount,0) as paid_amount,
                           coalesce(b.other_charges_input,0) as other_charges_input,
                           other_charges_tax_id,
                           coalesce(b.other_charges_amt,0) as other_charges_amt,
                           discount_to_all_input,
                           b.discount_to_all_type,
                           coalesce(b.tot_discount_to_all_amt,0) as tot_discount_to_all_amt,
                           coalesce(b.round_off,0) as round_off,
                           b.payment_status,
                           b.created_by

                           FROM db_customers a,
                           db_sales b 
                           WHERE 
                           a.`id`=b.`customer_id` AND 
                           b.`id`='$sales_id' 
                           ");
                          
    
    $res3=$q3->row();
    $customer_name=$res3->customer_name;
    $customer_point=$res3->customer_point;
    $customer_mobile=$res3->mobile;
    $customer_phone=$res3->phone;
    $customer_email=$res3->email;
    $customer_country=get_country($res3->country_id);
    $customer_state=get_state($res3->state_id);
    $customer_address=$res3->address;
    $customer_postcode=$res3->postcode;
    $customer_gst_no=$res3->gstin;
    $customer_tax_number=$res3->tax_number;
    $customer_opening_balance=$res3->opening_balance;
    $sales_date=show_date($res3->sales_date);
    $reference_no=$res3->reference_no;
    $created_time=show_time($res3->created_time);
    $sales_code=$res3->sales_code;
    $sales_note=$res3->sales_note;
    $seller_name=$res3->created_by;
    $customer_due=$res3->sales_due;
    $total_discount=$res3->tot_discount_to_all_amt;
    $sales_status=$res3->sales_status;

    $previous_due=$res3->sales_due-($res3->grand_total-$res3->paid_amount);//$res3->customer_previous_due;
    $previous_due = ($previous_due>0) ? $previous_due : 0;


    
    $subtotal=$res3->subtotal;
    $grand_total=$res3->grand_total;
    $other_charges_input=$res3->other_charges_input;
    $other_charges_tax_id=$res3->other_charges_tax_id;
    $other_charges_amt=$res3->other_charges_amt;
    $paid_amount=$res3->paid_amount;
    $discount_to_all_input=$res3->discount_to_all_input;
    $discount_to_all_type=$res3->discount_to_all_type;
    //$discount_to_all_type = ($discount_to_all_type=='in_percentage') ? '%' : 'Fixed';
    $tot_discount_to_all_amt=$res3->tot_discount_to_all_amt;
    $round_off=$res3->round_off;
    $payment_status=$res3->payment_status;
    
    if($discount_to_all_input>0){
    	$str="($discount_to_all_input%)";
    }else{
    	$str="(Fixed)";
    }

    if(!empty($customer_country)){
    	$Query1 = $this->db->query("select country from db_country where id='$customer_country'");
    	if($Query1->num_rows()>0){
      	$customer_country = $Query1->get()->row()->country;  
    	}
    	else{
    		$customer_country = '';
    	}
    }
    if(!empty($customer_state)){
    	$Query1 = $this->db->query("select state from db_states where id='$customer_state'");
    	if($Query1->num_rows()>0){
      	$customer_state = $Query1->get()->row()->state;  
    	}
    	else{
    		$customer_state = '';
    	}

       
    }

    
    ?>
    <div class="row no-print btncenter">
        <div class="col-md-4" >
            <button type="button" id="" class="btn btn-block btn-success btn-xs" onclick="window.print();" title="Print"><?= ($sales_status != "Quotation") ? 'In hóa đơn' : 'In phiếu' ?></button>
        </div>
        <div class="col-md-4">
            <?php $fakeid0 = bin2hex($sales_id); $fakeid1 = bin2hex('longdeptrai'); $fakeid2 = bin2hex($fakeid0.$fakeid1); ?>
            <!--button type="button" id="" class="btn btn-block btn-success btn-xs" onclick="window.navigator.clipboard.writeText(window.location.href.replace('print_invoice_pos', 'print_invoice_pos_public'));" title="Print">Chia sẻ hóa đơn điện tử</button-->
            <!--button type="button" id="" class="btn btn-block btn-success btn-xs" onclick="window.navigator.clipboard.writeText('<?= $base_url; ?>pos/public_invoice_aqua_home/<?= bin2hex(bin2hex(bin2hex(bin2hex(bin2hex($sales_id))))); ?>');" title="Print"><?= ($sales_status != "Quotation") ? 'Chia sẻ hóa đơn điện tử' : 'Chia sẻ phiếu tạm tính' ?></button-->
            <button type="button" id="" class="btn btn-block btn-success btn-xs" onclick="copyImage();" title="Print"><?= ($sales_status != "Quotation") ? 'Chia sẻ hóa đơn điện tử (Image)' : 'Chia sẻ phiếu tạm tính (Image)' ?></button>
           
            
        </div>
    </div>
    
    
    
    
<div class="invoices" id="invoices_image">
    <style>
        .btncenter {
          display: flex;
          justify-content: center;
          align-items: center;
          height: auto;
          padding-bottom: 30px;
        }
        .invoices {
            padding: 5px;
        }
    </style>
    
    
    
    <div class="row">
        <div class="col-12 text-center">
            <img width="100px" src="<?= base_url().'uploads/company/'.$company_logo;?>" />
            <?php $pieces = explode(",", $company_address); ?>
            <div style="padding-top: 2px; text-align: center; margin-left: 20px; margin-right: 20px;"><?php echo (!empty(trim($company_address))) ? $pieces[0].'<br>'.$pieces[1].', '.$pieces[2] : '';?></div>
            <div><?php echo (!empty(trim($company_mobile))) ? "Thông tin liên hệ: ".$company_mobile : '';?></div>
        </div>
    </div>
    
    <?php if (get_site_settings_config('show_invoice_barcode') == 1) { ?>
    <div class="row">
        <div class="col-12 text-center">
            
                <img class="center-block" style="max-height: 0.35in !important; width: 70%; opacity: 1.0" src="<?php echo base_url();?>barcode/<?php echo $sales_code."/".rand();?>">
            
        </div>
    </div>
    <?php } ?>
    
    <div class="row">
        <div class="col-12 text-center">
            <?php if ($sales_status == "Quotation") { ?>
                <div style="font-size: 1.4em;  padding-top: 2px; font-weight: bold; text-align: center;">PHIẾU BÁO GIÁ</div>
            <?php } else { ?>
                <div style="font-size: 1.4em;  padding-top: 2px; font-weight: bold; text-align: center;">HÓA ĐƠN BÁN HÀNG</div>
            <?php } ?>
            <div style="padding-bottom: 18px; font-weight: bold; text-align: center;"><?= $sales_date . ' ' . $created_time; ?></div>
        </div>
    </div>
    

	<table width="100%" align="center" >
		<tr>
			<td>
				<table width="100%" style="font-size: 0.9em;">
				    <tr>
                        <td>Mã hóa đơn: </td>
                        <td style="text-align: right;"><?= $sales_code; ?></td>
                    </tr>
				    <tr>
						<td>Khách hàng:</td>
						<td style="text-align: right;"><?= $customer_name; ?></td>
					</tr>
					<?php if ($customer_mobile != '0000000000') :?>
					<tr>
						<td>Liên hệ:</td>
						<td style="text-align: right; font-weight: bold;"><?= $customer_mobile; ?></td>
					</tr>
					<?php endif; ?>
					
				    <?php if ($POINT_SYSTEM == 1 && $customer_name != 'Khách Lẻ') { ?>
				    <tr>
						<td>Tích điểm:</td>
						<td style="text-align: right; font-weight: bold;"><?= number_format($customer_point); ?> điểm</td>
					</tr>
					<?php } ?>
					<?php if ($customer_address != '') { ?>
					<tr>
					    <td>Địa chỉ:</td>
					    <td style="text-align: right;"><?= $customer_address; ?></td>
					</tr>
				    <?php } ?>
				</table>
				
			</td>
		</tr>
		<tr><td colspan="3"><hr></td></tr>
		<tr>
			<td >
				<table width="100%" cellpadding="0" cellspacing="0"  >
					<thead>
    					<tr style="border-top-style: dashed;border-bottom-style: dashed;border-width: 0.1px; font-size: 1em; background: #e5dede; text-transform: uppercase;">
                            <th style="font-weight: bold; text-align:left;">Sản phẩm</th>
    					    <th style="font-weight: bold; text-align:left;">Số lượng</th>
    					    <th style="font-weight: bold; text-align:center;">Đơn giá</th>
    					    <th style="font-weight: bold; text-align:right;">Thành tiền</th>
    					</tr>
					</thead>
					<tbody style="border-bottom-style: dashed;border-width: 0.1px; font-size: 1em;">
						<?php
    			              $i=0;
    			              $tot_qty=0;
    			              $subtotal=0;
    			              $tax_amt=0;
    			              $total_discount=0; // Khởi tạo biến tổng chiết khấu
    			              $calculated_subtotal=0; // Tổng tạm tính thực tế (qty × price)
    			              $tax_details = array(); // Mảng lưu chi tiết thuế theo từng loại
    			              
    			              $q2=$this->db->query(" select b.sales_price, a.description, a.discount_type,a.discount_input,a.discount_amt, b.sku, b.id, b.item_name,a.sales_qty,a.unit_total_cost,a.price_per_unit,a.tax_amt,c.tax,c.tax_name,a.total_cost from db_salesitems a,db_items b,db_tax c where c.id=a.tax_id and b.id=a.item_id and a.sales_id='$sales_id'");
foreach ($q2->result() as $res2) {
    echo "<tr style='border-bottom-style: dashed;border-width: 0.1px;'>";  
        if ($res2->description) {
            if ($res2->id == -1) {
                echo "<td style='text-align:left; font-size: 0.9em'>".$res2->item_name." - [".$res2->description."]</td>";
            } else {
                echo "<td style='text-align:left; font-size: 0.9em'>".$res2->item_name."<br><span style='font-style: italic; font-size: 0.8em'>[".$res2->description."]</span></td>";
            }
        } else {
            echo "<td style='text-align:left; font-size: 0.9em'>".$res2->item_name."</td>";
        }
        echo "<td style='text-align:center; padding-left: 2px; padding-right: 2px; font-size: 0.8em;'>".number_format($res2->sales_qty)."</td>";
        echo "<td style='text-align:center; padding-right: 2px; font-size: 0.8em;'>".number_format($res2->price_per_unit)."₫</td>";
        
        // Debug: So sánh total_cost từ DB vs tính toán thực tế
        $calculated_line_total = $res2->sales_qty * $res2->price_per_unit;
        $db_total_cost = $res2->total_cost;
        $discount = $res2->discount_amt;
        $tax = $res2->tax_amt;
        
        // Hiển thị thành tiền (sử dụng total_cost từ database)
        echo "<td style='text-align:right;padding-left: 2px; padding-right: 2px; font-size: 0.8em;' >".number_format($res2->total_cost)."₫";
        echo "</td>";
    echo "</tr>";  
    
    // Tính tổng tạm tính = số lượng × đơn giá (trước chiết khấu và thuế)
    $line_subtotal = $res2->sales_qty * $res2->price_per_unit;
    $calculated_subtotal += $line_subtotal;
    
    // Phân tích cách tính total_cost
    $qty_x_price = $res2->sales_qty * $res2->price_per_unit;
    $discount = $res2->discount_amt;
    $tax = $res2->tax_amt;
    $total_from_db = $res2->total_cost;
    
    // Kiểm tra và sửa lỗi thuế nếu cần thiết
    $expected_tax = ($qty_x_price - $discount) * ($res2->tax / 100);
    $corrected_tax = $tax;
    
    // Nếu thuế trong DB sai (chỉ tính cho 1 sản phẩm), tính lại
    if (abs($expected_tax - $tax) > 0.01) {
        $corrected_tax = $expected_tax;
        // Có thể log lỗi ở đây
    }
    
    // Có thể total_cost = (qty × price) - discount + tax
    // hoặc total_cost = (qty × price) + tax - discount
    $calculated_total_1 = $qty_x_price - $discount + $corrected_tax; // Công thức 1
    $calculated_total_2 = $qty_x_price + $corrected_tax - $discount; // Công thức 2 (tương tự)
    
    $subtotal+=($res2->total_cost);
    $tax_amt+=$corrected_tax; // Sử dụng thuế đã sửa
    $total_discount+=$res2->discount_amt;
    
    // Thu thập chi tiết thuế theo từng loại - tính theo số lượng
    if ($corrected_tax > 0) {
        $tax_key = $res2->tax . '%';
        $tax_name = $res2->tax_name ? $res2->tax_name : 'Thuế ' . $res2->tax . '%';
        
        if (!isset($tax_details[$tax_key])) {
            $tax_details[$tax_key] = array(
                'name' => $tax_name,
                'rate' => $res2->tax,
                'amount' => 0,
                'quantity' => 0, // Thêm theo dõi số lượng
                'items' => array() // Thêm danh sách sản phẩm
            );
        }
        $tax_details[$tax_key]['amount'] += $corrected_tax;
        $tax_details[$tax_key]['quantity'] += $res2->sales_qty;
        
        // Debug info - hiển thị chi tiết tính toán
        $unit_tax = $corrected_tax / $res2->sales_qty; // Thuế trên 1 đơn vị
        $tax_details[$tax_key]['items'][] = $res2->item_name . ' (SL: ' . $res2->sales_qty . ', Thuế/sp: ' . number_format($unit_tax) . '₫)';
    }
}
$before_tax = $calculated_subtotal - $total_discount; // Trước thuế = tạm tính - chiết khấu
$after_tax = $before_tax + $tax_amt; // Sau thuế = trước thuế + thuế
			              ?>
					
				    </tbody>
					<tfoot>
					<tr><td colspan="4"><hr></td></tr>
					<tr>
    <td style=" padding-left: 2px; padding-right: 2px;" colspan="3" align="left">Tổng tạm tính <small>(trước thuế)</small></td>
    <td style=" padding-left: 2px; padding-right: 2px;" align="right"><?= number_format($calculated_subtotal);?>₫</td>
</tr>

<tr>
    <td style=" padding-left: 2px; padding-right: 2px;" colspan="3" align="left">Tổng chiết khấu sản phẩm</td>
    <td style=" padding-left: 2px; padding-right: 2px;" align="right"><?= number_format($total_discount); ?>₫</td>
</tr>

<tr>
    <td style=" padding-left: 2px; padding-right: 2px;" colspan="3" align="left">Tổng trước thuế <small>(Sau CK sản phẩm)</small></td>
    <td style=" padding-left: 2px; padding-right: 2px;" align="right"><?= number_format($before_tax);?>₫</td>
</tr>

<?php if (!empty($tax_details)) { ?>
<!-- Chi tiết thuế theo từng loại -->
<?php foreach ($tax_details as $tax_key => $tax_info) { ?>
<tr>
    <td style=" padding-left: 2px; padding-right: 2px; font-size: 0.85em; font-style: italic;" colspan="3" align="left">
        - <?= $tax_info['name']; ?> (<?= $tax_info['rate']; ?>%) - Tổng SL: <?= number_format($tax_info['quantity']); ?>
        <br><small style="font-size: 0.75em; color: #666; line-height: 1.2;">
            <?= implode('<br>', $tax_info['items']); ?>
        </small>
    </td>
    <td style=" padding-left: 2px; padding-right: 2px; font-size: 0.85em;" align="right"><?= number_format($tax_info['amount']);?>₫</td>
</tr>
<?php } ?>
<?php } ?>

<tr>
    <td style=" padding-left: 2px; padding-right: 2px; font-weight: bold; border-top: 1px solid #ddd;" colspan="3" align="left">Tổng thuế (Tất cả sản phẩm)</td>
    <td style=" padding-left: 2px; padding-right: 2px; font-weight: bold; border-top: 1px solid #ddd;" align="right"><?= number_format($tax_amt);?>₫</td>
</tr>

<tr>
    <td style=" padding-left: 2px; padding-right: 2px; font-weight: bold;" colspan="3" align="left">Tổng sau thuế <small>(Trước thuế + Thuế)</small></td>
    <td style=" padding-left: 2px; padding-right: 2px; font-weight: bold;" align="right"><?= number_format($after_tax);?>₫</td>
</tr>

<tr>
    <td style=" padding-left: 2px; padding-right: 2px;" colspan="3" align="left">
        Phụ phí khác 
        <?php if($other_charges_tax_id && $other_charges_tax_id != '' && $other_charges_input > 0) { 
            // Lấy thông tin thuế cho phụ phí
            $other_charges_tax_info = $this->db->query("SELECT tax, tax_name FROM db_tax WHERE id = '$other_charges_tax_id'")->row();
            if($other_charges_tax_info) {
                echo '<small>(có thuế ' . $other_charges_tax_info->tax . '%)</small>';
            }
        } ?>
    </td>
    <td style=" padding-left: 2px; padding-right: 2px;" align="right"><?= number_format($other_charges_amt); ?>₫</td>
</tr>
<?php if(!empty($tot_discount_to_all_amt) && $tot_discount_to_all_amt!=0) {?>
<tr>
    <td style=" padding-left: 2px; padding-right: 2px;" colspan="3" align="left"><?= $this->lang->line('discount_on_all'); ?></td>
    <td style=" padding-left: 2px; padding-right: 2px;" align="right"><?= number_format($tot_discount_to_all_amt); ?>₫</td>
</tr>
<?php } ?>

<tr style="border-bottom-style: solid;border-top-style: solid;border-width: 0.1px;">
    <td style=" padding-left: 2px; padding-right: 2px;font-weight: bold;" colspan="3" align="left">Tổng cần thanh toán</td>
    <td style=" padding-left: 2px; padding-right: 2px;font-weight: bold;" align="right"><?= number_format($grand_total); ?>₫</td>
</tr>

<?php if ($tax_amt > 0) { ?>
<tr style="border-bottom-style: dashed;border-width: 0.1px;">
    <td style=" padding-left: 2px; padding-right: 2px; font-size: 0.85em; font-style: italic;" colspan="3" align="left">
        <em>Tổng thuế đã bao gồm: <?= number_format($tax_amt); ?>₫</em>
    </td>
    <td style=" padding-left: 2px; padding-right: 2px;" align="right"></td>
</tr>
<?php } ?>
					
					<!-- change_return_status -->
					<?php if(change_return_status()) {
						$change_return_amount = get_change_return_amount($sales_id); ?>
						<!--tr>
							<td style=" padding-left: 2px; padding-right: 2px;" colspan="2" align="left">Nhận thanh toán</td>
							<td style=" padding-left: 2px; padding-right: 2px;" align="right"><?= number_format($paid_amount+$change_return_amount); ?>₫</td>
						</tr>
						<tr>
							<td style=" padding-left: 2px; padding-right: 2px;" colspan="2" align="left">Trả lại khách</td>
							<td style=" padding-left: 2px; padding-right: 2px;" align="right"><?= number_format($change_return_amount); ?>₫</td>
						</tr-->
					<?php }
					else{ ?>
						<!--tr>
						<td style=" padding-left: 2px; padding-right: 2px;" colspan="2" align="left"><?= $this->lang->line('paid_amount'); ?></td>
						<td style=" padding-left: 2px; padding-right: 2px;" align="right"><?= number_format($paid_amount); ?>₫</td>
					</tr-->
					
					<?php } ?>


<?php if (get_site_settings_config('show_due') == 1) { ?>
<tr>
    <td style=" padding-left: 2px; padding-right: 2px;" colspan="3" align="left">Công nợ trước</td>
    <td style=" padding-left: 2px; padding-right: 2px;" align="right"><?= number_format($previous_due); ?>₫</td>
</tr>

<tr>
    <td style=" padding-left: 2px; padding-right: 2px;" colspan="3" align="left">Tổng công nợ còn lại</td>
    <td style=" padding-left: 2px; padding-right: 2px;font-weight:bold;" align="right"><?= number_format($customer_due); ?>₫</td>
</tr>
<?php } ?>

</tfoot>
				</table>
			</td>
		</tr>
	</table>

<?php if ($sales_note != ''){ ?>
    <hr>
    <div class="row">
        <div class="col-12" style="padding-left: 18px;">
            <span style="font-weight: bold;">Ghi chú: <?php echo $sales_note ?></span>
        </div>
    </div>
<?php } ?>
    



    <?php if ($sales_status != "Quotation") { ?>
    <!--hr>
    <div class="row">
        <div class="col-12 text-center">
            <span style="font-weight: bold;">Vui lòng kiểm tra kỹ trước khi thanh toán!<br>Cám ơn Quý khách & hẹn gặp lại</span>
        </div>
    </div-->
    <?php } else { ?>
    <!--hr>
    <div class="row">
        <div class="col-12 text-center">
            <span style="font-weight: bold;">Phiếu tạm tính chỉ dùng để soạn hàng & báo giá sản phẩm!<br>Phiếu này không có giá trị thanh toán!</span>
        </div>
    </div-->
    <?php } ?>
    
    <hr>
    <div class="row">
        <div class="col-12 text-center">
            <span style="font-weight: bold;">Vui lòng kiểm tra kỹ trước khi thanh toán!<br>Cám ơn Quý khách & hẹn gặp lại!</span>
        </div>
    </div>

<?php if(!empty($sales_invoice_footer_text)) {?>
    <hr>
    <div class="row">
        <div class="col-12 text-center">
            <span style="font-weight: bold;"><?= $sales_invoice_footer_text; ?></span>
        </div>
    </div>
<?php } ?>

<?php if(get_site_settings_config('show_payment_qrcode') == 1) {?>
    <hr>
    <div class="row">
        <div class="col-12 text-center">
            <?php 
                $bankcode = (get_site_settings_config("bank_name_qrcode")) ? get_site_settings_config("bank_name_qrcode") : '970436'; 
                $bankno = (get_site_settings_config("bank_number_qrcode")) ? get_site_settings_config("bank_number_qrcode") : '0421000404796'; ?>
            <img class="center-block" style="width: 150px;  opacity: 1.0" src="https://img.vietqr.io/image/<?= $bankcode . '-' . $bankno ?>-qr_only.png?amount=<?= $grand_total ?>&addInfo=Thanh toán hóa đơn <?= $sales_code ?>">
            <p>Mã QR thanh toán</p>       
        </div>
    </div>
<?php } ?>   

</div>


<script>
        function copyImage() {
            html2canvas($("#invoices_image")[0]).then((canvas) => {
                canvas.toBlob(blob => navigator.clipboard.write([new ClipboardItem({'image/png': blob})]))
            });
            

        }
        
    </script>
</body>
</html>