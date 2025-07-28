<!DOCTYPE html>
<html>
<title><?= $page_title;?>- Default Format</title>
<head>
  <?php include"comman/code_css_form.php"; ?>
<link rel='shortcut icon' href='<?php echo $theme_link; ?>images/favicon.ico' />

<style>
table, th, td {
    border: 1px solid black;
    border-collapse: collapse;
    font-family: 'Open Sans', 'Martel Sans', sans-serif;
}
th, td {
    padding: 5px;
    text-align: left;   
    vertical-align:top 
}
body{
  word-wrap: break-word;
}
</style>

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
<body onload="window.print();"><!--  -->
<?php

    $q1=$this->db->query("select * from db_company where id=1 and status=1");
    $res1=$q1->row();
    $company_name=$res1->company_name;
    $company_mobile=$res1->mobile;
    $company_phone=$res1->phone;
    $company_email=$res1->email;
    $company_country=$res1->country;
    $company_state=$res1->state;
    $company_city=$res1->city;
    $company_address=$res1->address;
    $company_gst_no=$res1->gst_no;
    $company_vat_no=$res1->vat_no;

    $q4=$this->db->query("select sales_invoice_footer_text from db_sitesettings where id=1");
    $res4=$q4->row();
    $sales_invoice_footer_text=$res4->sales_invoice_footer_text;
    
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

<table align="center" width="100%" height='100%'>
    <thead>
      
      <tr>
          <th colspan="5" rowspan="2" style="padding-left: 15px;">
            <b><?php echo $company_name; ?></b><br/>
            <?php echo "Địa chỉ : ".$company_address; ?><br/>
            <?php echo $company_country; ?><br/>
            <?php echo "Điện thoại:".$company_mobile; ?><br/>
            <?php echo (!empty(trim($company_email))) ? "Email: ".$company_email."<br>" : '';?>
            <?php echo (!empty(trim($company_gst_no))) ? "Mã số thuế: ".$company_gst_no."<br>" : '';?>
            <?php echo (!empty(trim($company_vat_no))) ? "Mã VAT: ".$company_vat_no."<br>" : '';?>
          </th>
          <th colspan="5" rowspan="1"><b style="text-transform: capitalize;">HÓA ĐƠN TRẢ HÀNG</b> (<?=$return_status;?>)</th>
            
      </tr>
      <tr>
          <th colspan="3" rowspan="1">
              Số hóa đơn : <?php echo "$return_code"; ?><br>
              Số tham chiếu : <?php echo "$reference_no"; ?>
          </th>  
          <th colspan="2" rowspan="1">Ngày lập : <?php echo show_date($return_date)." ".$created_time; ?></th>
      </tr>
    


      <tr>
    <td colspan="5" style="padding-left: 15px;">
    <b>Địa chỉ khách hàng</b><br/>
    <?php echo "Tên: ".$customer_name; ?><br/>
      <?php echo "Điện thoại: ".$customer_mobile; ?>
      <?php 
              if(!empty($customer_address)){
                echo $customer_address;
              }
              if(!empty($customer_country)){
                echo $customer_country;
              }
              if(!empty($customer_state)){
                echo ",".$customer_state;
              }
              if(!empty($customer_city)){
                echo ",".$customer_city;
              }
              if(!empty($customer_postcode)){
                echo "-".$customer_postcode;
              }
            ?>
            <br>
      <?php echo (!empty(trim($customer_email))) ? "Email: ".$customer_email."<br>" : '';?>
      <?php echo (!empty(trim($customer_gst_no))) ? "Mã số thuế: ".$customer_gst_no."<br>" : '';?>
      <?php echo (!empty(trim($customer_tax_number))) ? "Mã thuế: ".$customer_tax_number."<br>" : '';?>
  </td>
    
    <td colspan="5" style="padding-left: 15px;">
    <b>Địa chỉ giao hàng</b><br/>
   <?php echo "Tên: ".$customer_name; ?><br/>
      <?php echo "Điện thoại: ".$customer_mobile; ?>
      <?php 
              if(!empty($customer_address)){
                echo $customer_address;
              }
              if(!empty($customer_country)){
                echo $customer_country;
              }
              if(!empty($customer_state)){
                echo ",".$customer_state;
              }
              if(!empty($customer_city)){
                echo ",".$customer_city;
              }
              if(!empty($customer_postcode)){
                echo "-".$customer_postcode;
              }
            ?>
            <br>
      <?php echo (!empty(trim($customer_email))) ? "Email: ".$customer_email."<br>" : '';?>
      <?php echo (!empty(trim($customer_gst_no))) ? "Mã số thuế: ".$customer_gst_no."<br>" : '';?>
      <?php echo (!empty(trim($customer_tax_number))) ? "Mã thuế: ".$customer_tax_number."<br>" : '';?>
  </td>
  </tr>
  
    
  <tr>
    <?php $colspan_1 = (!is_tax_disabled()) ? 1 : 2; ?>
    <?php $colspan_2 = (!is_tax_disabled()) ? 0 : 1; ?>
    <th >#</th>
    <th  colspan="<?=$colspan_1?>">Tên sản phẩm</th>
    <th >Đơn giá</th>
    <th >Số lượng</th>
    <?php if(!is_tax_disabled()) { ?>
    <th >Thuế</th>
    <th >Tiền thuế</th>
    <?php } ?>
    <th >Chiết khấu</th>
    <th >Tiền chiết khấu</th>
    <th >Đơn giá</th>
    <th  colspan="<?=$colspan_1?>">Tổng tiền</th>
  </tr>
  </thead>
<tbody>
  
 <?php
              $i=0;
              $tot_qty=0;
              $tot_sales_price=0;
              $tot_tax_amt=0;
              $tot_discount_amt=0;
              $tot_unit_total_cost=0;
              $tot_total_cost=0;
              $calculated_subtotal=0; // Tổng tạm tính được tính từ items
              $q2=$this->db->query("SELECT c.item_name, a.return_qty,
                                  a.price_per_unit, b.tax,b.tax_name,a.tax_amt,
                                  a.discount_input,a.discount_amt, a.unit_total_cost,
                                  a.total_cost 
                                  FROM 
                                  db_salesitemsreturn AS a,db_tax AS b,db_items AS c 
                                  WHERE 
                                  c.id=a.item_id AND b.id=a.tax_id AND a.return_id='$return_id'");
              foreach ($q2->result() as $res2) {
                  $discount = (empty($res2->discount_input)||$res2->discount_input==0)? '-':$res2->discount_input."%";
                  $discount_amt = (empty($res2->discount_amt)||$res2->discount_input==0)? '-':formatCurrency($res2->discount_amt);
                  
                  // Tính tổng tạm tính = số lượng × đơn giá (trước chiết khấu và thuế)
                  $line_subtotal = $res2->return_qty * $res2->price_per_unit;
                  $calculated_subtotal += $line_subtotal;
                  
                  echo "<tr>";  
                  echo "<td>".++$i."</td>";
                  echo "<td colspan='".($colspan_2+1)."'>".$res2->item_name."</td>";
                  echo "<td>".formatCurrency($res2->price_per_unit)."</td>";
                  echo "<td>".$res2->return_qty."</td>";
                  if(!is_tax_disabled()) {
                    echo "<td>".$res2->tax."%<br>".$res2->tax_name."</td>";
                    echo "<td style='text-align: right;'>".formatCurrency($res2->tax_amt)."</td>";
                  }
                  echo "<td style='text-align: right;'>".$discount."</td>";
                  echo "<td style='text-align: right;'>".$discount_amt."</td>";
                  echo "<td style='text-align: right;'>".formatCurrency($res2->unit_total_cost)."</td>";
                  echo "<td style='text-align: right;' colspan='".($colspan_2+1)."'>".formatCurrency($res2->total_cost)."</td>";
                  echo "</tr>";  
                  $tot_qty +=$res2->return_qty;
                  $tot_sales_price +=$res2->price_per_unit;
                  $tot_tax_amt +=$res2->tax_amt;
                  $tot_discount_amt +=$res2->discount_amt;
                  $tot_unit_total_cost +=$res2->unit_total_cost;
                  $tot_total_cost +=$res2->total_cost;
              }
              ?>
  
  </tbody>
<tfoot>
  <tr>
    <td colspan="<?=$colspan_2+3?>" style="text-align: center;font-weight: bold;">Tổng cộng</td>
    <td colspan="1" style="font-weight: bold;"><?=$tot_qty; ?></td>
    <?php if(!is_tax_disabled()) { ?>
    <td colspan="1" style="">-</td>
    <td colspan="1" style="text-align: right;" ><b><?php echo formatCurrency($tot_tax_amt); ?></b></td>
    <?php } ?>
    <td colspan="1" style="">-</td>
    <td colspan="1" style="text-align: right;" ><b><?php echo formatCurrency($tot_discount_amt); ?></b></td>
    <td colspan="1" style="text-align: right;" ><b><?php echo formatCurrency($tot_unit_total_cost); ?></b></td>
    <td colspan="<?=$colspan_2+1?>" style="text-align: right;" ><b><?php echo formatCurrency($tot_total_cost); ?></b></td>
  </tr>
  <tr>
    <td colspan="<?=9-$colspan_2?>" style="text-align: right;"><b>Tổng tạm tính</b> <small>(Qty × Đơn giá)</small></td>
    <td colspan="<?=$colspan_2+1?>" style="text-align: right;" ><b><?php echo formatCurrency($calculated_subtotal); ?></b></td>
  </tr>
  <?php if(!is_tax_disabled()) { ?>
  <tr>
    <td colspan="<?=9-$colspan_2?>" style="text-align: right;"><b>Tổng chiết khấu sản phẩm</b></td>
    <td colspan="<?=$colspan_2+1?>" style="text-align: right;" ><b><?php echo formatCurrency($tot_discount_amt); ?></b></td>
  </tr>
  <tr>
    <td colspan="<?=9-$colspan_2?>" style="text-align: right;"><b>Tổng trước thuế</b> <small>(Sau CK sản phẩm)</small></td>
    <td colspan="<?=$colspan_2+1?>" style="text-align: right;" ><b><?php echo formatCurrency($calculated_subtotal - $tot_discount_amt); ?></b></td>
  </tr>
  <tr>
    <td colspan="<?=9-$colspan_2?>" style="text-align: right;"><b>Tổng tiền thuế</b></td>
    <td colspan="<?=$colspan_2+1?>" style="text-align: right;" ><b><?php echo formatCurrency($tot_tax_amt); ?></b></td>
  </tr>
  <tr>
    <td colspan="<?=9-$colspan_2?>" style="text-align: right;"><b>Tổng sau thuế</b> <small>(Trước thuế + Thuế)</small></td>
    <td colspan="<?=$colspan_2+1?>" style="text-align: right;" ><b><?php echo formatCurrency($calculated_subtotal - $tot_discount_amt + $tot_tax_amt); ?></b></td>
  </tr>
  <?php } ?>
  <tr>
    <td colspan="<?=9-$colspan_2?>" style="text-align: right;"><b>Phụ phí khác</b></td>
    <td colspan="<?=$colspan_2+1?>" style="text-align: right;" ><b><?php echo formatCurrency($other_charges_amt); ?></b></td>
  </tr>
  <tr>
    <td colspan="<?=9-$colspan_2?>" style="text-align: right;"><b>Chiết khấu tổng(<?= $discount_to_all_input." ".$discount_to_all_type; ?>)</b></td>
    <td colspan="<?=$colspan_2+1?>" style="text-align: right;" ><b><?php echo formatCurrency($tot_discount_to_all_amt); ?></b></td>
  </tr>
  <tr>
    <td colspan="<?=9-$colspan_2?>" style="text-align: right;"><b>Tổng thanh toán</b> <?php if(!is_tax_disabled()) { ?><small>(Sau thuế + Phụ phí - CK tổng)</small><?php } ?></td>
    <td colspan="<?=$colspan_2+1?>" style="text-align: right;" ><b><?php echo formatCurrency($grand_total); ?></b></td>
  </tr>
  <tr>
    <td colspan="10">
<?php
     
      echo "<span class='amt-in-word'>Số tiền bằng chữ: <i style='font-weight:bold;'>".NumberToWords(round($grand_total))." đồng</i></span>";

      ?>
  
</td>
  </tr>

  <tr>
    <td colspan="5" style="height:100px;">
      <b>Chữ ký khách hàng</b><br/>&nbsp;<br/>&nbsp;<br/>&nbsp;<br/>&nbsp;<br/>
    </td>
    <td colspan="5">
      <b>Chữ ký người bán</b><br/><br/><br/><br/><br/>
    </td>
  </tr>
  <?php if(!empty($sales_invoice_footer_text)) {?>
  <tr style="border-top: 1px solid;">
    <td colspan="10" style="text-align: center;">
      <b><?= $sales_invoice_footer_text; ?></b>
    </td>
  </tr>
  <?php } ?>
</tfoot>
</table>



</body>
</html>
