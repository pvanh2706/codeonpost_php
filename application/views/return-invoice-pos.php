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

<?php 
// Hàm format tiền tệ Việt Nam
function formatCurrency($amount) {
    if ($amount == 0) return '0₫';
    return number_format($amount, 0, ',', '.') . '₫';
}

function formatNumber($number) {
    if ($number == 0) return '0';
    return number_format($number, 0, ',', '.');
}
?>

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

    // Lấy thông tin trả hàng
    $q3=$this->db->query("SELECT a.customer_name,a.mobile,a.phone,a.gstin,a.tax_number,a.email,
                           a.opening_balance,a.country_id,a.state_id,a.city,
                           a.postcode,a.address,b.return_date,b.created_time,b.reference_no,
                           b.return_code,b.return_note,b.return_status,
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
                           b.payment_status

                           FROM db_customers a,
                           db_salesreturn b 
                           WHERE 
                           a.`id`=b.`customer_id` AND 
                           b.`id`='$return_id' 
                           ");
                          
    
    $res3=$q3->row();
    $customer_name=$res3->customer_name;
    $customer_mobile=$res3->mobile;
    $customer_phone=$res3->phone;
    $customer_email=$res3->email;
    $customer_country=$res3->country_id;
    $customer_state=$res3->state_id;
    $customer_city=$res3->city;
    $customer_address=$res3->address;
    $customer_postcode=$res3->postcode;
    $customer_gst_no=$res3->gstin;
    $customer_tax_number=$res3->tax_number;
    $customer_opening_balance=$res3->opening_balance;
    $return_date=$res3->return_date;
    $created_time=$res3->created_time;
    $reference_no=$res3->reference_no;
    $return_code=$res3->return_code;
    $return_note=$res3->return_note;
    $return_status=$res3->return_status;

    
    $subtotal=$res3->subtotal;
    $grand_total=$res3->grand_total;
    $other_charges_input=$res3->other_charges_input;
    $other_charges_tax_id=$res3->other_charges_tax_id;
    $other_charges_amt=$res3->other_charges_amt;
    $paid_amount=$res3->paid_amount;
    $discount_to_all_input=$res3->discount_to_all_input;
    $discount_to_all_type=$res3->discount_to_all_type;
    $discount_to_all_type = ($discount_to_all_type=='in_percentage') ? '%' : 'Fixed';
    $tot_discount_to_all_amt=$res3->tot_discount_to_all_amt;
    $round_off=$res3->round_off;
    $payment_status=$res3->payment_status;

    ?>
    <div class="container-fluid">
        <div class="row">
            <div class="col-xs-12">
                <div class="text-center">
                    <h3 style="margin-bottom:5px;"><?php echo $company_name; ?></h3>
                    <p style="margin-bottom:5px;"><?php echo $company_address; ?></p>
                    <p style="margin-bottom:5px;">Tel: <?php echo $company_mobile; ?></p>
                    <p style="margin-bottom:5px;">Email: <?php echo $company_email; ?></p>
                    <h4 style="margin-bottom:5px; margin-top:15px;">HÓA ĐƠN TRẢ HÀNG</h4>
                </div>
            </div>
        </div>
        
        <div class="row">
            <div class="col-xs-12">
                <p style="margin-bottom:2px;"><strong>Số hóa đơn:</strong> <?php echo $return_code; ?></p>
                <p style="margin-bottom:2px;"><strong>Ngày lập:</strong> <?php echo $return_date; ?></p>
                <p style="margin-bottom:2px;"><strong>Khách hàng:</strong> <?php echo $customer_name; ?></p>
                <p style="margin-bottom:2px;"><strong>Điện thoại:</strong> <?php echo $customer_mobile; ?></p>
                <p style="margin-bottom:2px;"><strong>Trạng thái:</strong> <?php echo $return_status; ?></p>
                <hr style="margin:10px 0;">
            </div>
        </div>
        
        <div class="row">
            <div class="col-xs-12">
                <table class="table table-condensed" style="margin-bottom:5px;">
                    <thead>
                        <tr>
                            <th style="width:40%;">Tên sản phẩm</th>
                            <th style="width:15%; text-align:center;">SL</th>
                            <th style="width:20%; text-align:right;">Đơn giá</th>
                            <th style="width:25%; text-align:right;">Thành tiền</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $i=0;
                        $tot_qty=0;
                        $tot_total_cost=0;
                        $q2=$this->db->query("SELECT c.item_name, a.return_qty,
                                              a.price_per_unit, a.total_cost 
                                              FROM 
                                              db_salesitemsreturn AS a,db_items AS c 
                                              WHERE 
                                              c.id=a.item_id AND a.return_id='$return_id'");
                        foreach ($q2->result() as $res2) {
                            echo "<tr>";  
                            echo "<td>".$res2->item_name."</td>";
                            echo "<td style='text-align:center;'>".$res2->return_qty."</td>";
                            echo "<td style='text-align:right;'>".formatCurrency($res2->price_per_unit)."</td>";
                            echo "<td style='text-align:right;'>".formatCurrency($res2->total_cost)."</td>";
                            echo "</tr>";  
                            $tot_qty +=$res2->return_qty;
                            $tot_total_cost +=$res2->total_cost;
                        }
                        ?>
                    </tbody>
                </table>
                
                <hr style="margin:10px 0;">
                
                <table class="table table-condensed" style="margin-bottom:5px;">
                    <tr>
                        <td style="width:70%; text-align:right;"><strong>Tổng số lượng:</strong></td>
                        <td style="width:30%; text-align:right;"><strong><?php echo $tot_qty; ?></strong></td>
                    </tr>
                    <tr>
                        <td style="text-align:right;"><strong>Tổng tạm tính:</strong></td>
                        <td style="text-align:right;"><strong><?php echo formatCurrency($subtotal); ?></strong></td>
                    </tr>
                    <?php if($other_charges_amt > 0) { ?>
                    <tr>
                        <td style="text-align:right;"><strong>Phụ phí khác:</strong></td>
                        <td style="text-align:right;"><strong><?php echo formatCurrency($other_charges_amt); ?></strong></td>
                    </tr>
                    <?php } ?>
                    <?php if($tot_discount_to_all_amt > 0) { ?>
                    <tr>
                        <td style="text-align:right;"><strong>Chiết khấu:</strong></td>
                        <td style="text-align:right;"><strong><?php echo formatCurrency($tot_discount_to_all_amt); ?></strong></td>
                    </tr>
                    <?php } ?>
                    <tr>
                        <td style="text-align:right;"><strong>Tổng thanh toán:</strong></td>
                        <td style="text-align:right;"><strong><?php echo formatCurrency($grand_total); ?></strong></td>
                    </tr>
                </table>
                
                <hr style="margin:10px 0;">
                
                <?php if(!empty($return_note)) { ?>
                <p style="margin-bottom:5px;"><strong>Ghi chú:</strong> <?php echo $return_note; ?></p>
                <?php } ?>
                
                <div class="text-center" style="margin-top:20px;">
                    <p style="margin-bottom:5px;">Cảm ơn quý khách!</p>
                    <p style="margin-bottom:5px;"><?php echo $sales_invoice_footer_text; ?></p>
                </div>
            </div>
        </div>
    </div>
    
    <div class="text-center no-print" style="margin-top:20px;">
        <button type="button" class="btn btn-primary" onclick="window.print();">In hóa đơn</button>
        <button type="button" class="btn btn-default" onclick="window.close();">Đóng</button>
    </div>
    
    <script>
        // Tự động in khi trang load
        window.onload = function() {
            window.print();
        };
    </script>
</body>
</html>
