<!DOCTYPE html>
<html>
<head>
<!-- TABLES CSS CODE -->
<title><?= $page_title;?></title>
<!-- Bootstrap 3.3.6 -->
<?php include"comman/code_css_form.php"; ?>
<link rel="stylesheet" href="<?php echo $theme_link; ?>bootstrap/css/bootstrap.min.css">
<style type="text/css">
	body{
		font-family: monospace;
		font-size: 12px;
		/*font-weight: bold;*/
		padding-top:15px;
	}

	@media print {
        .no-print { display: none; }
    }
</style>

</head>
<!-- body onload="window.print();" -->
    <body  ><!--   -->
	<?php
	$CI =& get_instance();
	
	//console_log($sales_id);
	$sales_id = hex2bin(hex2bin(hex2bin(hex2bin(hex2bin($sales_id)))));
	//console_log($sales_id);
	
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
<div class="invoices">
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
            <img width="250px" src="<?= base_url().'uploads/company/'.$company_logo;?>" />
            <div style="padding-top: 10px; text-align: center; margin-left: 20px; margin-right: 20px;"><?php echo (!empty(trim($company_address))) ? $company_address : '';?></div>
            <div><?php echo (!empty(trim($company_mobile))) ? "Thông tin liên hệ: ".$company_mobile : '';?></div>
            <hr>
        </div>
    </div>
    
    <div class="row">
        <div class="col-12 text-center">
            <?php if (get_site_settings_config('show_invoice_barcode') == 1 && $sales_status != "Quotation") { ?>
                <img class="center-block" style="max-height: 0.35in !important; width: 70%; opacity: 1.0" src="<?php echo base_url();?>barcode/<?php echo $sales_code."/".rand();?>">
            <?php } ?>
        </div>
    </div>
    
    <div class="row">
        <div class="col-12 text-center">
            <?php if ($sales_status == "Quotation") { ?>
                <div style="font-size: 1.6em; padding-bottom: 18px; padding-top: 10px; font-weight: bold; text-align: center;">Phiếu tạm tính không có giá trị thanh toán</div>
            <?php } else { ?>
                <div style="font-size: 1.8em; padding-bottom: 18px; padding-top: 10px; font-weight: bold; text-align: center;">HÓA ĐƠN BÁN HÀNG</div>
            <?php } ?>
        </div>
    </div>
    
    
    
    
    
    
    
	<table width="100%" align="center" >
        <tr>
            <td>
                <table width="100%">
                    <tr>
                        <td>Số hóa đơn: <?= ($sales_status != "Quotation") ? $sales_code : 'N/A'; ?></td>
                        <td style="text-align: right;">Ngày: <?= $sales_date . ' ' . $created_time; ?></td>
                    </tr>
                    <tr>
                        <td>Điểm tích lũy khi hoàn thành: </td>
                        <td style="text-align: right;">
                            <?= ($POINT_SYSTEM == 1) ? "+" . number_format(floor($grand_total/1000)) . " điểm" : "N/A"; ?>
                        </td>
                    </tr>
                </table>
            </td>
        </tr>
        <tr><td colspan="3"><hr></td></tr>
		<tr>
			<td>
				<table width="100%">
				    <tr>
						<td>Khách hàng:</td>
						<td style="text-align: right;"><?= $customer_name; ?></td>
					</tr>
					<tr>
						<td>Liên hệ:</td>
						<td style="text-align: right; font-weight: bold;"><?= $customer_mobile; ?></td>
					</tr>
					<?php if ($POINT_SYSTEM == 1) { ?>
				    <tr>
						<td>Điểm tích lũy:</td>
						<td style="text-align: right; font-weight: bold;"><?= number_format($customer_popint); ?> điểm</td>
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
    					    <th style="font-weight: bold; text-align:left;">Số lượng</th>
    					    <th style="font-weight: bold; text-align:center;">Đơn giá</th>
    					    <th style="font-weight: bold; text-align:right;">Thành tiền</th>
    					</tr>
					</thead>
					<tbody style="border-bottom-style: dashed;border-width: 0.1px; font-size: 1.3em;">
						<?php
    			              $i=0;
    			              $tot_qty=0;
    			              $subtotal=0;
    			              $tax_amt=0;
    			              $q2=$this->db->query("select a.description, b.sales_price, a.discount_type,a.discount_input,a.discount_amt, b.sku, b.item_name,a.sales_qty,a.unit_total_cost,a.price_per_unit,a.tax_amt,c.tax,a.total_cost from db_salesitems a,db_items b,db_tax c where c.id=a.tax_id and b.id=a.item_id and a.sales_id='$sales_id'");
    			              foreach ($q2->result() as $res2) {
    			                    echo "<tr ><td colspan='3' style='text-align:left; font-size: 0.9em'>#".++$i.". ".$res2->item_name."</td></tr>";
    			                    if ($res2->description) {
    			                        echo "<tr ><td colspan='3' style='text-align:left; font-size: 0.9em'>**** ".$res2->description."</td></tr>";
    			                    }
    			                    echo "<tr style='border-bottom-style: dashed;border-width: 0.1px;'>";  
    			                        //echo "<td colspan='2' style='padding-right: 2px; font-size: 0.8em;'>".$res2->sku."</td>";
    			                        echo "<td style='text-align:left; padding-left: 2px; padding-right: 2px; font-size: 0.8em;'>".number_format($res2->sales_qty)."</td>";
    			                        echo "<td style='text-align:center; padding-right: 2px; font-size: 0.8em;'>".number_format($res2->price_per_unit)."₫</td>";
    			                        //echo "<td style='text-align:center; padding-left: 2px; padding-right: 2px; font-size: 0.8em;'>".number_format($res2->discount_amt)."₫</td>";
    			                        echo "<td style='float: right;padding-left: 2px; padding-right: 2px; font-size: 0.8em;' >".number_format($res2->total_cost)."₫</td>";
    			                    echo "</tr>";  
    			                  //$tot_qty+=$res2->sales_qty;
    			                  $subtotal+=($res2->total_cost);
    			                  $tax_amt+=$res2->tax_amt;
    			                  $total_discount+=$res2->discount_amt;
    			              }
    			              $before_tax = $subtotal-$tax_amt;
			              ?>
					
				    </tbody>
					<tfoot>
					<tr><td colspan="3"><hr></td></tr>
					<tr >
						<td style=" padding-left: 2px; padding-right: 2px;" colspan="2" align="left">
							<?= (is_tax_disabled()) ? "Tổng tạm tính" : "Tổng trước thuế"; ?>
						</td>
						<td style=" padding-left: 2px; padding-right: 2px;" align="right"><?= number_format($before_tax);?>₫</td>
					</tr>
					
					<tr class="<?=tax_disable_class()?>">
						<td style=" padding-left: 2px; padding-right: 2px;" colspan="2" align="left">Tổng thuế</td>
						<td style=" padding-left: 2px; padding-right: 2px;" align="right"><?= number_format($tax_amt);?>₫</td>
					</tr>
					
					<tr>
						<td style=" padding-left: 2px; padding-right: 2px;" colspan="2" align="left">Tổng chiếc khấu</td>
						<td style=" padding-left: 2px; padding-right: 2px;" align="right"><?= number_format($total_discount); ?>₫</td>
					</tr>
					
	                <tr>
						<td style=" padding-left: 2px; padding-right: 2px;" colspan="2" align="left">Các phụ phí khác</td>
						<td style=" padding-left: 2px; padding-right: 2px;" align="right"><?= number_format($other_charges_amt); ?>₫</td>
					</tr>
	                <?php if(!empty($tot_discount_to_all_amt) && $tot_discount_to_all_amt!=0) {?>
					<tr>
						<td style=" padding-left: 2px; padding-right: 2px;" colspan="2" align="left"><?= $this->lang->line('discount_on_all'); ?> <?= ($discount_to_all_type=='in_percentage') ? $discount_to_all_input .'%' : $discount_to_all_input.'[Fixed]' ;?></td>
						<td style=" padding-left: 2px; padding-right: 2px;" align="right"><?= number_format($tot_discount_to_all_amt); ?>₫</td>
					</tr>
					<?php } ?>
					

					

					
					<tr style="border-bottom-style: solid;border-top-style: solid;border-width: 0.1px;">
						<td style=" padding-left: 2px; padding-right: 2px;font-weight: bold;" colspan="2" align="left">Tổng cần thanh toán</td>
						<td style=" padding-left: 2px; padding-right: 2px;font-weight: bold;" align="right"><?= number_format($grand_total); ?>₫</td>
					</tr>
					
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
						<td style=" padding-left: 2px; padding-right: 2px;" colspan="2" align="left">Công nợ trước</td>
						<td style=" padding-left: 2px; padding-right: 2px;" align="right"><?= number_format($previous_due); ?>₫</td>
					</tr>

					<tr>
						<td style=" padding-left: 2px; padding-right: 2px;" colspan="2" align="left">Tổng công nợ còn lại</td>
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
    <hr>
    <div class="row">
        <div class="col-12 text-center">
            <span style="font-weight: bold;">Vui lòng kiểm tra kỹ trước khi thanh toán!<br>Cám ơn Quý khách & hẹn gặp lại</span>
        </div>
    </div>
    <?php } else { ?>
    <hr>
    <div class="row">
        <div class="col-12 text-center">
            <span style="font-weight: bold;">Phiếu tạm tính chỉ dùng để soạn hàng & báo giá sản phẩm!<br>Phiếu này không có giá trị thanh toán!</span>
        </div>
    </div>
    <?php } ?>

<?php if(!empty($sales_invoice_footer_text) && $sales_status != "Quotation") {?>
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
            <img class="center-block" style="width: 150px;  opacity: 1.0" src="https://img.vietqr.io/image/<?= $bankcode . '-' . $bankno ?>-qr_only.png">
                 <p>Mã QR thanh toán</p>       
        </div>
    </div>
<?php } ?>   

</div>
</body>
</html>