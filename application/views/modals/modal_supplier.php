<div class="modal fade " id="supplier-modal" tabindex='-1'>
  <?= form_open('#', array('class' => '', 'id' => 'supplier-form')); ?>
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header header-custom">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title text-center">Thêm nhà cung cấp hàng hóa</h4>
      </div>
      <div class="modal-body">
          <div class="row">
            <div class="col-md-4">
              <div class="box-body">
                <div class="form-group">
                  <label for="supplier_name">Tên nhà cung cấp *</label>
                  <span id="supplier_name_msg" class="text-danger text-right pull-right"></span>
                  <input type="text" class="form-control" id="supplier_name" name="supplier_name" placeholder="" >
                </div>
              </div>
            </div>
            <div class="col-md-4">
              <div class="box-body">
                <div class="form-group">
                  <label for="mobile">Điện thoại liên hệ *</label>
                  <span id="mobile_msg" class="text-danger text-right pull-right"></span>
                  <input type="tel"  class="form-control no_special_char_no_space " id="mobile" name="mobile" placeholder=""  >
                </div>
              </div>
            </div>

            <div class="col-md-4">
              <div class="box-body">
                <div class="form-group">
                  <label for="email"><?= $this->lang->line('email'); ?></label>
                  <span id="email_msg" class="text-danger text-right pull-right"></span>
                  <input type="email" class="form-control " id="email" name="email" placeholder=""  >
                </div>
              </div>
            </div>
            
            <!--div class="col-md-4">
                <div class="box-body">
                  <div class="form-group">
                    <label for="opening_balance"><?= $this->lang->line('opening_balance'); ?></label>
                    <span id="opening_balance_msg" class="text-danger text-right pull-right"></span>
                    <input type="text" class="form-control" id="opening_balance" name="opening_balance" placeholder="" >
                  </div>
                </div>
              </div-->
            <!--div class="col-md-4">
              <div class="box-body">
                <div class="form-group">
                  <label for="gstin_msg"><?= $this->lang->line('gst_number'); ?></label>
                  <span id="gstin_msg" class="text-danger text-right pull-right"></span>
                  <input type="text" class="form-control maxlength  " id="gstin" name="gstin" placeholder=""  >
                </div>
              </div>
            </div-->

            <!--div class="col-md-4">
              <div class="box-body">
                <div class="form-group">
                  <label for="tax_number"><?= $this->lang->line('tax_number'); ?></label>
                  <span id="tax_number_msg" class="text-danger text-right pull-right"></span>
                  <input type="text"  class="form-control maxlength  " id="tax_number" name="tax_number" placeholder=""  >
                </div>
              </div>
            </div-->
            <!--div class="col-md-3">
              <div class="box-body">
                <div class="form-group">
                  <label for="country">Quốc gia</label>
                  <span id="country_msg" class="text-danger text-right pull-right"></span>
                 <select class="form-control select2" id="country" name="country"  style="width: 100%;" onkeyup="shift_cursor(event,'state')" value="">
                    <?php
                    $query1="select * from db_country where status=1";
                    $q1=$this->db->query($query1);
                    if($q1->num_rows($q1)>0)
                     {
                         foreach($q1->result() as $res1)
                       {
                         echo "<option value='".$res1->id."'>".$res1->country."</option>";
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
            </div-->
            <!--div class="col-md-3">
              <div class="box-body">
                <div class="form-group">
                  <label for="state">Tỉnh thành</label>
                  <span id="state_msg" class="text-danger text-right pull-right"></span>
                 <select class="form-control select2" id="state" name="state"  style="width: 100%;" onkeyup="shift_cursor(event,'state_code')">
                    <?php
                    $query2="select * from db_states where status=1";
                    $q2=$this->db->query($query2);
                    if($q2->num_rows()>0)
                     {
                      echo '<option value="">- Lựa chọn-</option>'; 
                      foreach($q2->result() as $res1)
                       {
                         echo "<option value='".$res1->id."'>".$res1->state."</option>";
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
            </div-->
           <!--div class="col-md-4">
              <div class="box-body">
                <div class="form-group">
                  <label for="city">Khu vực</label>
                  <span id="city_msg" class="text-danger text-right pull-right"></span>
                  <input type="text" class="form-control" id="city" name="city" placeholder="" >
                </div>
              </div>
            </div-->
            <!--div class="col-md-4">
              <div class="box-body">
                <div class="form-group">
                  <label for="postcode"><?= $this->lang->line('postcode'); ?></label>
                  <span id="postcode_msg" class="text-danger text-right pull-right"></span>
                  <input type="text" class="form-control" id="postcode" name="postcode" placeholder="" >
                </div>
              </div>
            </div-->
            <div class="col-md-12">
              <div class="box-body">
                <div class="form-group">
                  <label for="address">Địa chỉ Nhà cung cấp</label>
                  <span id="address_msg" class="text-danger text-right pull-right"></span>
                  
                  <input type="text" class="form-control" id="address" name="address" placeholder="" >
                </div>
              </div>
            </div>

          </div>
         
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-warning" data-dismiss="modal">Close</button>
        <button type="button" class="btn btn-primary add_supplier">Save</button>
      </div>
    </div>
    <!-- /.modal-content -->
  </div>
  <!-- /.modal-dialog -->
 <?= form_close();?>
</div>
<!-- /.modal -->