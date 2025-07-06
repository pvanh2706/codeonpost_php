<style>
    .modalActiveRow {
        background-color: yellow;
    } 
</style>
<div class="modal fade" id="item_salepriceall" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header"> <button type="button" class="close" data-dismiss="modal" aria-label="Close"> <span aria-hidden="true">&times;</span> </button> </div>
                <div class="modal-body p-0 row">
                    <div class="col-12 col-lg-5 ad p-0"> <img id="imgs"  width="100%" height="100%"/> </div>
                    <div class="details col-12 col-lg-7">
                        <h2 id="prname" style="white-space: nowrap; text-overflow: ellipsis; overflow: hidden; ">STAY TUNED</h2>
                        <div class="form-group mt-3 pt-3 mb-5 border-3" style="font-family: Tahoma; font-size: 1.1em;">
                            <div class="row" id="cusLvPts" style="padding: 8px; border-bottom: 1px dashed;">
                                <div class="col-md-6">Giá bán lẻ</div>
                                <div class="col-md-6"><span style="font-weight: bold; color: red; " id="pr"></span></div>
                            </div>
                            <div class="row" id="cusLvPts0" style="padding: 8px; border-bottom: 1px dashed;">
                                <div class="col-md-6">Giá Đại lý cấp 0</div>
                                <div class="col-md-6"><span style="font-weight: bold; color: blue; " id="pr0"></span></div>
                            </div>
                            <div class="row" id="cusLvPts1" style="padding: 8px; border-bottom: 1px dashed;">
                                <div class="col-md-6">Giá Đại lý cấp 1</div>
                                <div class="col-md-6"><span style="font-weight: bold; color: blue; "id="pr1"></span></div>
                            </div>
                            <div class="row" id="cusLvPts2" style="padding: 8px; border-bottom: 1px dashed;">
                                <div class="col-md-6">Giá Đại lý cấp 2</div>
                                <div class="col-md-6"><span style="font-weight: bold; color: blue; " id="pr2"></span></div>
                            </div>
                            <div class="row" id="cusLvPts3" style="padding: 8px; border-bottom: 1px dashed;">
                                <div class="col-md-6">Giá Đại lý cấp 3</div>
                                <div class="col-md-6"><span style="font-weight: bold; color: blue; " id="pr3"></span></div>
                            </div>
                    	</div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
    
    function viewAllPrice(id) {
        $('#item_salepriceall').modal('show');
        var cusLVs = $("#customerLVP").attr('data-lv');
        switch (cusLVs) {
            case '0':
                $("#cusLvPts").removeClass("modalActiveRow");
                $("#cusLvPts0").addClass("modalActiveRow");
                $("#cusLvPts1").removeClass("modalActiveRow");
                $("#cusLvPts2").removeClass("modalActiveRow");
                $("#cusLvPts3").removeClass("modalActiveRow");
                break;
            case '1':
                $("#cusLvPts").removeClass("modalActiveRow");
                $("#cusLvPts0").removeClass("modalActiveRow");
                $("#cusLvPts1").addClass("modalActiveRow");
                $("#cusLvPts2").removeClass("modalActiveRow");
                $("#cusLvPts3").removeClass("modalActiveRow");
                break;
            case '2':
                $("#cusLvPts").removeClass("modalActiveRow");
                $("#cusLvPts0").removeClass("modalActiveRow");
                $("#cusLvPts1").removeClass("modalActiveRow");
                $("#cusLvPts2").addClass("modalActiveRow");
                $("#cusLvPts3").removeClass("modalActiveRow");
                break;
            case '3':
                $("#cusLvPts").removeClass("modalActiveRow");
                $("#cusLvPts0").removeClass("modalActiveRow");
                $("#cusLvPts1").removeClass("modalActiveRow");
                $("#cusLvPts2").removeClass("modalActiveRow");
                $("#cusLvPts3").addClass("modalActiveRow");
                break;
            default:
                $("#cusLvPts").addClass("modalActiveRow");
                $("#cusLvPts0").removeClass("modalActiveRow");
                $("#cusLvPts1").removeClass("modalActiveRow");
                $("#cusLvPts2").removeClass("modalActiveRow");
                $("#cusLvPts3").removeClass("modalActiveRow");
        }
        
        console.log(cusLVs);
        var prname = $("#item_parent_"+id).find("div")[0].getAttribute('data-item-name');
        
        var pr = $("#item_parent_"+id).find("div")[0].getAttribute('data-x-final-price').replace(/\B(?=(\d{3})+(?!\d))/g, ',');
        var pr0 = $("#item_parent_"+id).find("div")[0].getAttribute('data-x-sales-price0').replace(/\B(?=(\d{3})+(?!\d))/g, ',');
        var pr1 = $("#item_parent_"+id).find("div")[0].getAttribute('data-x-sales-price1').replace(/\B(?=(\d{3})+(?!\d))/g, ',');
        var pr2 = $("#item_parent_"+id).find("div")[0].getAttribute('data-x-sales-price2').replace(/\B(?=(\d{3})+(?!\d))/g, ',');
        var pr3 = $("#item_parent_"+id).find("div")[0].getAttribute('data-x-sales-price3').replace(/\B(?=(\d{3})+(?!\d))/g, ',');
        var img = $("#item_parent_"+id).find("div")[0].getAttribute('data-x-images');
        
        
        $("#imgs").attr('src',img.replace('_thumb', ''));
        $(".modal-body #prname").html( prname );
        $(".modal-body #pr").html( pr );
        $(".modal-body #pr0").html( pr0 );
        $(".modal-body #pr1").html( pr1 );
        $(".modal-body #pr2").html( pr2 );
        $(".modal-body #pr3").html( pr3 );
        
        
        
        
        
    }
        
        
    </script>

<div class="sales_item_modal">
   <div class="modal fade in" id="sales_item2" tabindex='-1'>
      <div class="modal-dialog ">
         <div class="modal-content">
            <div class="modal-header header-custom">
               <button type="button" class="close" data-dismiss="modal" aria-label="Close">
               <span aria-hidden="true">×</span></button>
               <h4 class="modal-title text-center" id='popup_item_name'>Thêm giá trị chiết khấu</h4>
            </div>
            <div class="modal-body" style="font-weight: bold;">
               <div class="row">
                  <div class="col-md-12">
                     <div class="row invoice-info">
                        <div class="col-sm-12 invoice-col form-group">
                           <span style="font-weight: bold;">Các mức giá niêm yết sản phẩm tương ứng<span>
                        </div>
                     </div>
                  </div>
               </div>
               <div class="row">
                   <div class="btn btn-success btn-flat" style="text-align: left; padding-left: 10%; margin-left: 10%; width: 80%;">Giá bán lẻ | <span id="sales_item2_finalprice"></span></div>
               </div>
               <div class="row">
                   <div class="btn btn-success btn-flat" style="text-align: left; padding-left: 10%; margin-left: 10%; width: 80%;">Giá Đại lý Cấp 0 | <span id="sales_item2_finalprice0"></span></div>
               </div>
               <div class="row">
                   <div class="btn btn-success btn-flat" style="text-align: left; padding-left: 10%; margin-left: 10%; width: 80%;">Giá Đại lý Cấp 1 | <span id="sales_item2_finalprice1"></span></div>
               </div>
               <div class="row">
                   <div class="btn btn-success btn-flat" style="text-align: left; padding-left: 10%; margin-left: 10%; width: 80%;">Giá Đại lý Cấp 2 | <span id="sales_item2_finalprice2"></span></div>
               </div>
               <div class="row">
                   <div class="btn btn-success btn-flat" style="text-align: left; padding-left: 10%; margin-left: 10%; width: 80%;">Giá Đại lý Cấp 3 | <span id="sales_item2_finalprice3"></span></div>
               </div>
               
            </div>
            <!--div class="modal-footer">
              <input type="hidden" id="popup_row_id">
               <button type="button" class="btn btn-default btn-lg" data-dismiss="modal">Đóng</button>
               <button type="button" onclick="set_info()" class="btn bg-green btn-lg place_order btn-lg">Xác nhận<i class="fa  fa-check "></i></button>
            </div-->
         </div>
         <!-- /.modal-content -->
      </div>
      <!-- /.modal-dialog -->
   </div>
</div>


<div class="sales_item_modal">
   <div class="modal fade in" id="sales_item" tabindex='-1'>
      <div class="modal-dialog ">
         <div class="modal-content">
            <div class="modal-header header-custom">
               <button type="button" class="close" data-dismiss="modal" aria-label="Close">
               <span aria-hidden="true">×</span></button>
               <h4 class="modal-title text-center" id='popup_item_name'>Thêm giá trị chiết khấu</h4>
            </div>
            <div class="modal-body">
               <div class="row">
                  <div class="col-md-12">
                     <div class="row invoice-info">
                        <div class="col-sm-12 invoice-col form-group">
                           <span style="font-weight: bold;">Điều chỉnh giá trị chiết khấu sản phẩm<span>
                        </div>
                        <!-- /.col -->
                     </div>
                     <!-- /.row -->
                  </div>
                  <div class="col-md-12">
                     <div>
                        
                        <div class="col-md-12 ">
                           <div class="box box-solid bg-gray">
                              <div class="box-body">
                                 <div class="row">
                                    
                                    <div class="col-md-6 <?=tax_disable_class()?>">
                                        <div class="form-group">
                                          <label for="popup_tax_type">Loại thuế</label>
                                         <select class="form-control" id="popup_tax_type" name="popup_tax_id"  style="width: 100%;" >
                                          <option value="Exclusive">Loại trừ</option>
                                           <option value="Inclusive">Bao gồm</option>
                                          </select>
                                        </div>
                                   
                                    </div>

                                    <div class="col-md-6 <?=tax_disable_class()?>">
                                        <div class="form-group">
                                          <label for="popup_tax_id"><?= $this->lang->line('tax'); ?></label>
                                         <select class="form-control" id="popup_tax_id" name="popup_tax_id"  style="width: 100%;" >
                                            <?php
                                            $query2="select * from db_tax where status=1";
                                            $q2=$this->db->query($query2);
                                            if($q2->num_rows()>0)
                                             {
                                              echo '<option value="">-Select-</option>'; 
                                              foreach($q2->result() as $res1)
                                               {
                                                 echo "<option data-tax='".$res1->tax."' data-tax-value='".$res1->tax_name."' value='".$res1->id."'>".$res1->tax_name."</option>";
                                               }
                                             }
                                             else
                                             {
                                                ?>
                                                <option value="">No Records Found</option>
                                                <?php
                                             }
                                            ?>
                                                  </select>
                                        </div>
                                   
                                    </div>

                                    <div class="col-md-6">
                                        <div class="form-group">
                                          <label for="item_discount_type">Loại chiết khấu</label>
                                         <select class="form-control" id="item_discount_type" name="item_discount_type"  style="width: 100%;" >
                                          <option value='Fixed'>Cố định (<?= $CI->currency() ?>)</option>
                                          <option value='Percentage'>Phần trăm (%)</option>
                                          </select>
                                        </div>
                                   
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                          <label for="item_discount_input">Chiếc khấu</label>
                                        <input type="text" class="form-control only_currency" id="item_discount_input" name="item_discount_input" placeholder="" value="0">
                                        </div>
                                   
                                    </div>
                                   

                                    <div class="col-md-12">
                                        <div class="form-group">
                                          <label for="popup_tax_type">Ghi chú</label>
                                         <textarea type="text" class="form-control" id="popup_description" placeholder=""></textarea>
                                        </div>
                                   
                                    </div>

                                    <!-- <div class="col-md-6">
                                       <div class="">
                                          <label for="popup_tax_amt">Tax Amount</label>
                                          <input type="text" class="form-control text-right paid_amt" id="popup_tax_amt" name="popup_tax_amt" readonly>
                                          <span id="popup_tax_amt_msg"  style="display:none" class="text-danger"></span>
                                       </div>
                                    </div> -->

                                    <div class="clearfix"></div>
                                 </div>
                              </div>
                           </div>
                        </div>
                        <!-- col-md-12 -->
                     </div>
                  </div>
                  <!-- col-md-9 -->
                  <!-- RIGHT HAND -->
               </div>
            </div>
            <div class="modal-footer">
              <input type="hidden" id="popup_row_id">
               <button type="button" class="btn btn-default btn-lg" data-dismiss="modal">Đóng</button>
               <button type="button" onclick="set_info()" class="btn bg-green btn-lg place_order btn-lg">Xác nhận<i class="fa  fa-check "></i></button>
            </div>
         </div>
         <!-- /.modal-content -->
      </div>
      <!-- /.modal-dialog -->
   </div>
</div>
