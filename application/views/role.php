<?php 
/*$q1 = $this->db->select('permissions')->get('db_permissions');
echo "<pre>";
              print_r($q1->result_array());
              exit();*/
?>
<!DOCTYPE html>
<html>
   <head>
      <!-- TABLES CSS CODE -->
      <?php include"comman/code_css_form.php"; ?>
      <!-- </copy> -->  
   </head>
   <body class="hold-transition skin-blue sidebar-mini">
      <div class="wrapper">
         <?php include"sidebar.php"; ?>
         <?php
            if(!isset($role_name)){
                 $role_name=$description="";
            }
            
            ?>
         <!-- Content Wrapper. Contains page content -->
         <div class="content-wrapper">
            <!-- Content Header (Page header) -->
            <?php
               $page_title = isset($role_id) ? 'Cập nhật quyền hạn' : 'Thêm quyền hạn';
               $base_url = base_url();
               ?>
            <section class="content-header">
               <h1>
                  <?=$page_title;?>
                  <small>Thêm mới/Cập nhật quyền hạn</small>
               </h1>
               <ol class="breadcrumb">
                  <li><a href="<?php echo $base_url; ?>dashboard"><i class="fa fa-dashboard"></i> Home</a></li>
                  <li><a href="<?php echo $base_url; ?>roles/view"><?= $this->lang->line('roles_list'); ?></a></li>
                  <li class="active"><?=$page_title;?></li>
               </ol>
            </section>
            <!-- Main content -->
            <section class="content">
               <div class="row">
                  <!-- right column -->
                  <div class="col-md-12">
                     <!-- Horizontal Form -->
                     <div class="box box-info ">
                        <div class="box-header with-border">
                           <h3 class="box-title">Vui lòng nhập dữ liệu</h3>
                        </div>
                        <!-- /.box-header -->
                        <!-- form start -->
                        <form class="form-horizontal" id="roles-form" onkeypress="return event.keyCode != 13;">
                           <input type="hidden" name="<?php echo $this->security->get_csrf_token_name();?>" value="<?php echo $this->security->get_csrf_hash();?>">
                           <input type="hidden" id="base_url" value="<?php echo $base_url;; ?>">
                           <div class="box-body">
                              <div class="form-group">
                                 <label for="role_name" class="col-sm-2 control-label"><?= $this->lang->line('role_name'); ?><label class="text-danger">*</label></label>
                                 <div class="col-sm-4">
                                    <input type="text" class="form-control input-sm" id="role_name" name="role_name" placeholder="" onkeyup="shift_cursor(event,'description')" value="<?php print $role_name; ?>" autofocus >
                                    <span id="role_name_msg" style="display:none" class="text-danger"></span>
                                 </div>
                              </div>
                              <div class="form-group">
                                 <label for="description" class="col-sm-2 control-label"><?= $this->lang->line('description'); ?></label>
                                 <div class="col-sm-4">
                                    <textarea type="text" class="form-control" id="description" name="description" placeholder=""><?php print $description; ?></textarea>
                                    <span id="description_msg" style="display:none" class="text-danger"></span>
                                 </div>
                              </div>
                              <div class="form-group">
                                 <div class="col-sm-12">
                                    <table class="table table-bordered">
                                      <thead class="bg-primary">
                                          <tr>
                                            <th>#</th>
                                            <th><?= $this->lang->line('modules'); ?></th>
                                            <th>CHỌN TẤT CẢ</th>
                                            <th><?= $this->lang->line('specific_permissions'); ?></th>
                                          </tr>
                                      </thead>
                                      <tbody>
                                        <?php $i=1; ?>
                                        <!-- USERS -->
                                        <tr>
                                          <td><?= $i++;?></td>
                                          <td><?= $this->lang->line('users'); ?></td>
                                          <td>
                                              <div class="checkbox icheck"><label>
                                                <input type="checkbox" class="change_me" id="users" > CHỌN TẤT CẢ
                                              </label></div>
                                          </td>
                                          <td>
                                              <input type="hidden" name="module[users]" value="on">
                                              <div class="checkbox icheck"><label>
                                                <input type="checkbox" class="users_all" id='users_add' name="permission[users_add]" > THÊM
                                              </label></div>
                                              <div class="checkbox icheck"><label>
                                                <input type="checkbox" class="users_all" id='users_edit' name="permission[users_edit]"> SỬA
                                              </label></div>
                                              <div class="checkbox icheck"><label>
                                                <input type="checkbox" class="users_all" id='users_delete' name="permission[users_delete]"> XÓA
                                              </label></div>
                                              <div class="checkbox icheck"><label>
                                                <input type="checkbox" class="users_all" id='users_view' name="permission[users_view]"> XEM
                                              </label></div>
                                          </td>
                                        </tr>
                                        <!-- Roles -->

                                        <tr>
                                          <td><?= $i++;?></td>
                                          <td><?= $this->lang->line('roles'); ?></td>
                                          <td>
                                              <div class="checkbox icheck"><label>
                                                <input type="checkbox" class="change_me" id="roles" > CHỌN TẤT CẢ
                                              </label></div>
                                          </td>
                                          <td>
                                              <input type="hidden" name="module[roles]" value="on">
                                              <div class="checkbox icheck"><label>
                                                <input type="checkbox" class="roles_all" id='roles_add' name="permission[roles_add]" > THÊM
                                              </label></div>
                                              <div class="checkbox icheck"><label>
                                                <input type="checkbox" class="roles_all" id='roles_edit' name="permission[roles_edit]"> SỬA
                                              </label></div>
                                              <div class="checkbox icheck"><label>
                                                <input type="checkbox" class="roles_all" id='roles_delete' name="permission[roles_delete]"> XÓA
                                              </label></div>
                                              <div class="checkbox icheck"><label>
                                                <input type="checkbox" class="roles_all" id='roles_view' name="permission[roles_view]"> XEM
                                              </label></div>
                                          </td>
                                        </tr>
                                        <!-- TAX -->
                                        <tr>
                                          <td><?= $i++;?></td>
                                          <td><?= $this->lang->line('tax'); ?></td>
                                          <td>
                                              <div class="checkbox icheck"><label>
                                                <input type="checkbox" class="change_me" id="tax"> CHỌN TẤT CẢ
                                              </label></div>
                                          </td>
                                          <td>
                                              <input type="hidden" name="module[tax]" value="on">
                                              <div class="checkbox icheck"><label>
                                                <input type="checkbox" class="tax_all" id='tax_add' name="permission[tax_add]"> THÊM
                                              </label></div>
                                              <div class="checkbox icheck"><label>
                                                <input type="checkbox" class="tax_all" id='tax_edit' name="permission[tax_edit]"> SỬA
                                              </label></div>
                                              <div class="checkbox icheck"><label>
                                                <input type="checkbox" class="tax_all" id='tax_delete' name="permission[tax_delete]"> XÓA
                                              </label></div>
                                              <div class="checkbox icheck"><label>
                                                <input type="checkbox" class="tax_all" id='tax_view' name="permission[tax_view]"> XEM
                                              </label></div>
                                          </td>
                                        </tr>
                                        <!-- CURRENCY -->
                                        <tr>
                                          <td><?= $i++;?></td>
                                          <td><?= $this->lang->line('currency'); ?></td>
                                          <td>
                                              <div class="checkbox icheck"><label>
                                                <input type="checkbox" class="change_me" id="currency"> CHỌN TẤT CẢ
                                              </label></div>
                                          </td>
                                          <td>
                                              <input type="hidden" name="module[currency]" value="on">
                                              <div class="checkbox icheck"><label>
                                                <input type="checkbox" class="currency_all" id='currency_add' name="permission[currency_add]"> THÊM
                                              </label></div>
                                              <div class="checkbox icheck"><label>
                                                <input type="checkbox" class="currency_all" id='currency_edit' name="permission[currency_edit]"> SỬA
                                              </label></div>
                                              <div class="checkbox icheck"><label>
                                                <input type="checkbox" class="currency_all" id='currency_delete' name="permission[currency_delete]"> XÓA
                                              </label></div>
                                              <div class="checkbox icheck"><label>
                                                <input type="checkbox" class="currency_all" id='currency_view' name="permission[currency_view]"> XEM
                                              </label></div>
                                          </td>
                                        </tr>
                                       <!-- UNITS -->
                                       <tr>
                                          <td><?= $i++;?></td>
                                          <td><?= $this->lang->line('units'); ?></td>
                                          <td>
                                              <div class="checkbox icheck"><label>
                                                <input type="checkbox" class="change_me" id="units"> CHỌN TẤT CẢ
                                              </label></div>
                                          </td>
                                          <td>
                                              <input type="hidden" name="module[units]" value="on">
                                              <div class="checkbox icheck"><label>
                                                <input type="checkbox" class="units_all" id='units_add' name="permission[units_add]"> THÊM
                                              </label></div>
                                              <div class="checkbox icheck"><label>
                                                <input type="checkbox" class="units_all" id='units_edit' name="permission[units_edit]"> SỬA
                                              </label></div>
                                              <div class="checkbox icheck"><label>
                                                <input type="checkbox" class="units_all" id='units_delete' name="permission[units_delete]"> XÓA
                                              </label></div>
                                              <div class="checkbox icheck"><label>
                                                <input type="checkbox" class="units_all" id='units_view' name="permission[units_view]"> XEM
                                              </label></div>
                                          </td>
                                        </tr>
                                        <!-- PAYMENT TYPES -->
                                       <tr>
                                          <td><?= $i++;?></td>
                                          <td><?= $this->lang->line('payment_types'); ?></td>
                                          <td>
                                              <div class="checkbox icheck"><label>
                                                <input type="checkbox" class="change_me" id="payment_types"> CHỌN TẤT CẢ
                                              </label></div>
                                          </td>
                                          <td>
                                              <input type="hidden" name="module[payment_types]" value="on">
                                              <div class="checkbox icheck"><label>
                                                <input type="checkbox" class="payment_types_all" id='payment_types_add' name="permission[payment_types_add]"> THÊM
                                              </label></div>
                                              <div class="checkbox icheck"><label>
                                                <input type="checkbox" class="payment_types_all" id='payment_types_edit' name="permission[payment_types_edit]"> SỬA
                                              </label></div>
                                              <div class="checkbox icheck"><label>
                                                <input type="checkbox" class="payment_types_all" id='payment_types_delete' name="permission[payment_types_delete]"> XÓA
                                              </label></div>
                                              <div class="checkbox icheck"><label>
                                                <input type="checkbox" class="payment_types_all" id='payment_types_view' name="permission[payment_types_view]"> XEM
                                              </label></div>
                                          </td>
                                        </tr>
                                        <!-- SITE SETTINGS -->
                                        <tr>
                                          <td><?= $i++;?></td>
                                          <td><?= $this->lang->line('site_settings'); ?></td>
                                          <td>
                                              <div class="checkbox icheck"><label>
                                                <input type="checkbox" class="change_me" id="site"> CHỌN TẤT CẢ
                                              </label></div>
                                          </td>
                                          <td>
                                              <input type="hidden" name="module[site]" value="on">
                                              <div class="checkbox icheck"><label>
                                                <input type="checkbox" class="site_all" id='site_edit' name="permission[site_edit]"> SỬA
                                              </label></div>
                                          </td>
                                        </tr>
                                        <!--COMPANY PROFILE  -->
                                        <tr>
                                          <td><?= $i++;?></td>
                                          <td><?= $this->lang->line('company_profile'); ?></td>
                                          <td>
                                              <div class="checkbox icheck"><label>
                                                <input type="checkbox" class="change_me" id="company"> CHỌN TẤT CẢ
                                              </label></div>
                                          </td>
                                          <td>
                                              <input type="hidden" name="module[company]" value="on">
                                              <div class="checkbox icheck"><label>
                                                <input type="checkbox" class="company_all" id='company_edit' name="permission[company_edit]"> SỬA
                                              </label></div>
                                          </td>
                                        </tr>
                                        <!--DASHBOARD  -->
                                        <tr>
                                          <td><?= $i++;?></td>
                                          <td><?= $this->lang->line('dashboard'); ?></td>
                                          <td>
                                              <div class="checkbox icheck"><label>
                                                <input type="checkbox" class="change_me" id="dashboard"> CHỌN TẤT CẢ
                                              </label></div>
                                          </td>
                                          <td>
                                              <input type="hidden" name="module[dashboard]" value="on">
                                              <div class="checkbox icheck"><label>
                                                <input type="checkbox" class="dashboard_all" id='dashboard_view' name="permission[dashboard_view]"> <?= $this->lang->line('view_dashboard_data'); ?>
                                              </label></div>
                                          </td>
                                        </tr>
                                        <!-- Places -->
                                        <tr>
                                          <td><?= $i++;?></td>
                                          <td><?= $this->lang->line('places'); ?></td>
                                          <td>
                                              <div class="checkbox icheck"><label>
                                                <input type="checkbox" class="change_me" id="places" > CHỌN TẤT CẢ
                                              </label></div>
                                          </td>
                                          <td>
                                              <input type="hidden" name="module[places]" value="on">
                                              <div class="checkbox icheck"><label>
                                                <input type="checkbox" class="places_all" id='places_add' name="permission[places_add]" > THÊM
                                              </label></div>
                                              <div class="checkbox icheck"><label>
                                                <input type="checkbox" class="places_all" id='places_edit' name="permission[places_edit]"> SỬA
                                              </label></div>
                                              <div class="checkbox icheck"><label>
                                                <input type="checkbox" class="places_all" id='places_delete' name="permission[places_delete]"> XÓA
                                              </label></div>
                                              <div class="checkbox icheck"><label>
                                                <input type="checkbox" class="places_all" id='places_view' name="permission[places_view]"> XEM
                                              </label></div>
                                          </td>
                                        </tr>
                                        <!-- EXPENSES -->
                                        <tr>
                                          <td><?= $i++;?></td>
                                          <td><?= $this->lang->line('expense'); ?></td>
                                          <td>
                                              <div class="checkbox icheck"><label>
                                                <input type="checkbox" class="change_me" id="expense" > CHỌN TẤT CẢ
                                              </label></div>
                                          </td>
                                          <td>
                                              <input type="hidden" name="module[expense]" value="on">
                                              <div class="checkbox icheck"><label>
                                                <input type="checkbox" class="expense_all" id='expense_add' name="permission[expense_add]" > THÊM
                                              </label></div>
                                              <div class="checkbox icheck"><label>
                                                <input type="checkbox" class="expense_all" id='expense_edit' name="permission[expense_edit]"> SỬA
                                              </label></div>
                                              <div class="checkbox icheck"><label>
                                                <input type="checkbox" class="expense_all" id='expense_delete' name="permission[expense_delete]"> XÓA
                                              </label></div>
                                              <div class="checkbox icheck"><label>
                                                <input type="checkbox" class="expense_all" id='expense_view' name="permission[expense_view]"> XEM
                                              </label></div>
                                              <div class="checkbox icheck"><label>
                                                <input type="checkbox" class="expense_all" id='expense_category_add' name="permission[expense_category_add]" > <?= $this->lang->line('category_add'); ?>
                                              </label></div>
                                              <div class="checkbox icheck"><label>
                                                <input type="checkbox" class="expense_all" id='expense_category_edit' name="permission[expense_category_edit]"> <?= $this->lang->line('category_edit'); ?>
                                              </label></div>
                                              <div class="checkbox icheck"><label>
                                                <input type="checkbox" class="expense_all" id='expense_category_delete' name="permission[expense_category_delete]"> <?= $this->lang->line('category_delete'); ?>
                                              </label></div>
                                              <div class="checkbox icheck"><label>
                                                <input type="checkbox" class="expense_all" id='expense_category_view' name="permission[expense_category_view]"> <?= $this->lang->line('category_view'); ?>
                                              </label></div>
                                          </td>
                                        </tr>
                                        <!-- ITEMS -->
                                        <tr>
                                          <td><?= $i++;?></td>
                                          <td><?= $this->lang->line('items'); ?></td>
                                          <td>
                                              <div class="checkbox icheck"><label>
                                                <input type="checkbox" class="change_me" id="items" > CHỌN TẤT CẢ
                                              </label></div>
                                          </td>
                                          <td>
                                              <input type="hidden" name="module[items]" value="on">
                                              <div class="checkbox icheck"><label>
                                                <input type="checkbox" class="items_all" id='items_add' name="permission[items_add]" > THÊM
                                              </label></div>
                                              <div class="checkbox icheck"><label>
                                                <input type="checkbox" class="items_all" id='items_edit' name="permission[items_edit]"> SỬA
                                              </label></div>
                                              <div class="checkbox icheck"><label>
                                                <input type="checkbox" class="items_all" id='items_delete' name="permission[items_delete]"> XÓA
                                              </label></div>
                                              <div class="checkbox icheck"><label>
                                                <input type="checkbox" class="items_all" id='items_view' name="permission[items_view]"> XEM
                                              </label></div>
                                              <div class="checkbox icheck"><label>
                                                <input type="checkbox" class="items_all" id='items_category_add' name="permission[items_category_add]" > <?= $this->lang->line('category_add'); ?>
                                              </label></div>
                                              <div class="checkbox icheck"><label>
                                                <input type="checkbox" class="items_all" id='items_category_edit' name="permission[items_category_edit]"> <?= $this->lang->line('category_edit'); ?>
                                              </label></div>
                                              <div class="checkbox icheck"><label>
                                                <input type="checkbox" class="items_all" id='items_category_delete' name="permission[items_category_delete]"> <?= $this->lang->line('category_delete'); ?>
                                              </label></div>
                                              <div class="checkbox icheck"><label>
                                                <input type="checkbox" class="items_all" id='items_category_view' name="permission[items_category_view]"> <?= $this->lang->line('category_view'); ?>
                                              </label></div>
                                              <div class="checkbox icheck"><label>
                                                <input type="checkbox" class="items_all" id='print_labels' name="permission[print_labels]"> <?= $this->lang->line('print_labels'); ?>
                                              </label></div>
                                              <div class="checkbox icheck"><label>
                                                <input type="checkbox" class="items_all" id='import_items' name="permission[import_items]"> <?= $this->lang->line('import_items'); ?>
                                              </label></div>
                                              <div class="checkbox icheck"><label>
                                                <input type="checkbox" class="items_all" id='print_item_labels' name="permission[print_item_labels]"> IN TEM SẢN PHẨM
                                              </label></div>
                                              <div class="checkbox icheck"><label>
                                                <input type="checkbox" class="items_all" id='items_stock_view' name="permission[items_stock_view]"> XEM TỒN KHO
                                              </label></div>
                                          </td>
                                        </tr>
                                        <!-- Brands -->
                                        <tr>
                                          <td><?= $i++;?></td>
                                          <td><?= $this->lang->line('brand'); ?></td>
                                          <td>
                                              <div class="checkbox icheck"><label>
                                                <input type="checkbox" class="change_me" id="brand"> CHỌN TẤT CẢ
                                              </label></div>
                                          </td>
                                          <td>
                                              <input type="hidden" name="module[brand]" value="on">
                                              <div class="checkbox icheck"><label>
                                                <input type="checkbox" class="brand_all" id='brand_add' name="permission[brand_add]"> THÊM
                                              </label></div>
                                              <div class="checkbox icheck"><label>
                                                <input type="checkbox" class="brand_all" id='brand_edit' name="permission[brand_edit]"> SỬA
                                              </label></div>
                                              <div class="checkbox icheck"><label>
                                                <input type="checkbox" class="brand_all" id='brand_delete' name="permission[brand_delete]"> XÓA
                                              </label></div>
                                              <div class="checkbox icheck"><label>
                                                <input type="checkbox" class="brand_all" id='brand_view' name="permission[brand_view]"> XEM
                                              </label></div>
                                          </td>
                                        </tr>
                                        <!-- Suppliers -->
                                        <tr>
                                          <td><?= $i++;?></td>
                                          <td><?= $this->lang->line('suppliers'); ?></td>
                                          <td>
                                              <div class="checkbox icheck"><label>
                                                <input type="checkbox" class="change_me" id="suppliers" > CHỌN TẤT CẢ
                                              </label></div>
                                          </td>
                                          <td>
                                              <input type="hidden" name="module[suppliers]" value="on">
                                              <div class="checkbox icheck"><label>
                                                <input type="checkbox" class="suppliers_all" id='suppliers_add' name="permission[suppliers_add]" > THÊM
                                              </label></div>
                                              <div class="checkbox icheck"><label>
                                                <input type="checkbox" class="suppliers_all" id='suppliers_edit' name="permission[suppliers_edit]"> SỬA
                                              </label></div>
                                              <div class="checkbox icheck"><label>
                                                <input type="checkbox" class="suppliers_all" id='suppliers_delete' name="permission[suppliers_delete]"> XÓA
                                              </label></div>
                                              <div class="checkbox icheck"><label>
                                                <input type="checkbox" class="suppliers_all" id='suppliers_view' name="permission[suppliers_view]"> XEM
                                              </label></div>
                                              <div class="checkbox icheck"><label>
                                                <input type="checkbox" class="suppliers_all" id='import_suppliers' name="permission[import_suppliers]"> <?= $this->lang->line('import_suppliers'); ?>
                                              </label></div>
                                          </td>
                                        </tr>
                                        <!-- Customers -->
                                        <tr>
                                          <td><?= $i++;?></td>
                                          <td><?= $this->lang->line('customers'); ?></td>
                                          <td>
                                              <div class="checkbox icheck"><label>
                                                <input type="checkbox" class="change_me" id="customers" > CHỌN TẤT CẢ
                                              </label></div>
                                          </td>
                                          <td>
                                              <input type="hidden" name="module[customers]" value="on">
                                              <div class="checkbox icheck"><label>
                                                <input type="checkbox" class="customers_all" id='customers_add' name="permission[customers_add]" > THÊM
                                              </label></div>
                                              <div class="checkbox icheck"><label>
                                                <input type="checkbox" class="customers_all" id='customers_edit' name="permission[customers_edit]"> SỬA
                                              </label></div>
                                              <div class="checkbox icheck"><label>
                                                <input type="checkbox" class="customers_all" id='customers_delete' name="permission[customers_delete]"> XÓA
                                              </label></div>
                                              <div class="checkbox icheck"><label>
                                                <input type="checkbox" class="customers_all" id='customers_view' name="permission[customers_view]"> XEM
                                              </label></div>
                                              <div class="checkbox icheck"><label>
                                                <input type="checkbox" class="customers_all" id='import_customers' name="permission[import_customers]"> <?= $this->lang->line('import_customers'); ?>
                                              </label></div>
                                              <div class="checkbox icheck"><label>
                                                <input type="checkbox" class="customers_all" id='import_customers_bulk' name="permission[import_customers_bulk]"> THÊM NHIỀU THEO DANH SÁCH
                                              </label></div>
                                          </td>
                                        </tr>
                                        <!-- Purchase -->
                                        <tr>
                                          <td><?= $i++;?></td>
                                          <td><?= $this->lang->line('purchase'); ?></td>
                                          <td>
                                              <div class="checkbox icheck"><label>
                                                <input type="checkbox" class="change_me" id="purchase" > CHỌN TẤT CẢ
                                              </label></div>
                                          </td>
                                          <td>
                                              <input type="hidden" name="module[purchase]" value="on">
                                              <div class="checkbox icheck"><label>
                                                <input type="checkbox" class="purchase_all" id='purchase_add' name="permission[purchase_add]" > THÊM
                                              </label></div>
                                              <div class="checkbox icheck"><label>
                                                <input type="checkbox" class="purchase_all" id='purchase_edit' name="permission[purchase_edit]"> SỬA
                                              </label></div>
                                              <div class="checkbox icheck"><label>
                                                <input type="checkbox" class="purchase_all" id='purchase_delete' name="permission[purchase_delete]"> XÓA
                                              </label></div>
                                              <div class="checkbox icheck"><label>
                                                <input type="checkbox" class="purchase_all" id='purchase_view' name="permission[purchase_view]"> XEM
                                              </label></div>

                                              <div class="checkbox icheck"><label>
                                                <input type="checkbox" class="purchase_all" id='view_all_users_purchase_invoices' name="permission[view_all_users_purchase_invoices]"> <?= $this->lang->line('view_all_users_purchase_invoices'); ?>
                                              </label></div>


                                              <div class="checkbox icheck"><label>
                                                <input type="checkbox" class="purchase_all" id='purchase_payment_view' name="permission[purchase_payment_view]"> <?= $this->lang->line('purchase_payments_view'); ?>
                                              </label></div>
                                              <div class="checkbox icheck"><label>
                                                <input type="checkbox" class="purchase_all" id='purchase_payment_add' name="permission[purchase_payment_add]"> <?= $this->lang->line('purchase_payments_add'); ?>
                                              </label></div>
                                              <div class="checkbox icheck"><label>
                                                <input type="checkbox" class="purchase_all" id='purchase_payment_delete' name="permission[purchase_payment_delete]"> <?= $this->lang->line('purchase_payments_delete'); ?>
                                              </label></div>
                                              <div class="checkbox icheck"><label>
                                                <input type="checkbox" class="purchase_all" id='purchase_list_view' name="permission[purchase_list_view]"> XEM DANH SÁCH ĐƠN NHẬP HÀNG
                                              </label></div>
                                          </td>
                                        </tr>
                                        <!-- Purchase Return-->
                                        <tr>
                                          <td><?= $i++;?></td>
                                          <td><?= $this->lang->line('purchase_return'); ?></td>
                                          <td>
                                              <div class="checkbox icheck"><label>
                                                <input type="checkbox" class="change_me" id="purchase_return" > CHỌN TẤT CẢ
                                              </label></div>
                                          </td>
                                          <td>
                                              <input type="hidden" name="module[purchase_return]" value="on">
                                              <div class="checkbox icheck"><label>
                                                <input type="checkbox" class="purchase_return_all" id='purchase_return_add' name="permission[purchase_return_add]" > THÊM
                                              </label></div>
                                              <div class="checkbox icheck"><label>
                                                <input type="checkbox" class="purchase_return_all" id='purchase_return_edit' name="permission[purchase_return_edit]"> SỬA
                                              </label></div>
                                              <div class="checkbox icheck"><label>
                                                <input type="checkbox" class="purchase_return_all" id='purchase_delete' name="permission[purchase_return_delete]"> XÓA
                                              </label></div>
                                              <div class="checkbox icheck"><label>
                                                <input type="checkbox" class="purchase_return_all" id='purchase_view' name="permission[purchase_return_view]"> XEM
                                              </label></div>


                                              <div class="checkbox icheck"><label>
                                                <input type="checkbox" class="purchase_return_all" id='view_all_users_purchase_return_invoices' name="permission[view_all_users_purchase_return_invoices]"> <?= $this->lang->line('view_all_users_purchase_return_invoices'); ?>
                                              </label></div>
                                              
                                              <div class="checkbox icheck"><label>
                                                <input type="checkbox" class="purchase_return_all" id='purchase_return_payment_view' name="permission[purchase_return_payment_view]"> <?= $this->lang->line('purchase_return_payments_view'); ?>
                                              </label></div>
                                              <div class="checkbox icheck"><label>
                                                <input type="checkbox" class="purchase_return_all" id='purchase_return_payment_add' name="permission[purchase_return_payment_add]"> <?= $this->lang->line('purchase_return_payments_add'); ?>
                                              </label></div>
                                              <div class="checkbox icheck"><label>
                                                <input type="checkbox" class="purchase_return_all" id='purchase_return_payment_delete' name="permission[purchase_return_payment_delete]"> <?= $this->lang->line('purchase_return_payments_delete'); ?>
                                              </label></div>
                                              <div class="checkbox icheck"><label>
                                                <input type="checkbox" class="purchase_return_all" id='purchase_return_list_view' name="permission[purchase_return_list_view]"> XEM DANH SÁCH ĐƠN TRẢ NHẬP HÀNG
                                              </label></div>
                                          </td>
                                        </tr>
                                        <!-- Sales -->
                                        <tr>
                                          <td><?= $i++;?></td>
                                          <td><?= $this->lang->line('sales'); ?> (Including POS)</td>
                                          <td>
                                              <div class="checkbox icheck"><label>
                                                <input type="checkbox" class="change_me" id="sales" > CHỌN TẤT CẢ
                                              </label></div>
                                          </td>
                                          <td>
                                              <input type="hidden" name="module[sales]" value="on">

                                              <div class="checkbox icheck"><label>
                                                <input type="checkbox" class="sales_all" id='pos' name="permission[pos]" > <?= $this->lang->line('pos'); ?>
                                              </label></div>

                                              <div class="checkbox icheck"><label>
                                                <input type="checkbox" class="sales_all" id='sales_add' name="permission[sales_add]" > THÊM
                                              </label></div>
                                              <div class="checkbox icheck"><label>
                                                <input type="checkbox" class="sales_all" id='sales_edit' name="permission[sales_edit]"> SỬA
                                              </label></div>
                                              <div class="checkbox icheck"><label>
                                                <input type="checkbox" class="sales_all" id='sales_delete' name="permission[sales_delete]"> XÓA
                                              </label></div>
                                              <div class="checkbox icheck"><label>
                                                <input type="checkbox" class="sales_all" id='sales_view' name="permission[sales_view]"> XEM
                                              </label></div>

                                              <div class="checkbox icheck"><label>
                                                <input type="checkbox" class="sales_all" id='view_all_users_sales_invoices' name="permission[view_all_users_sales_invoices]"> <?= $this->lang->line('view_all_users_sales_invoices'); ?>
                                              </label></div>


                                              <div class="checkbox icheck"><label>
                                                <input type="checkbox" class="sales_all" id='sales_payment_view' name="permission[sales_payment_view]"> <?= $this->lang->line('sales_payments_view'); ?>
                                              </label></div>
                                              <div class="checkbox icheck"><label>
                                                <input type="checkbox" class="sales_all" id='sales_payment_add' name="permission[sales_payment_add]"> <?= $this->lang->line('sales_payments_add'); ?>
                                              </label></div>
                                              <div class="checkbox icheck"><label>
                                                <input type="checkbox" class="sales_all" id='sales_payment_delete' name="permission[sales_payment_delete]"> <?= $this->lang->line('sales_payments_delete'); ?>
                                              </label></div>
                                              <div class="checkbox icheck"><label>
                                                <input type="checkbox" class="sales_all" id='sales_list_view' name="permission[sales_list_view]"> XEM DANH SÁCH ĐƠN BÁN HÀNG
                                              </label></div>
                                          </td>
                                        </tr>
                                        <!-- Sales Return-->
                                        <tr>
                                          <td><?= $i++;?></td>
                                          <td><?= $this->lang->line('sales_return'); ?></td>
                                          <td>
                                              <div class="checkbox icheck"><label>
                                                <input type="checkbox" class="change_me" id="sales_return" > CHỌN TẤT CẢ
                                              </label></div>
                                          </td>
                                          <td>
                                              <input type="hidden" name="module[sales_return]" value="on">
                                              <div class="checkbox icheck"><label>
                                                <input type="checkbox" class="sales_return_all" id='sales_return_add' name="permission[sales_return_add]" > THÊM
                                              </label></div>
                                              <div class="checkbox icheck"><label>
                                                <input type="checkbox" class="sales_return_all" id='sales_return_edit' name="permission[sales_return_edit]"> SỬA
                                              </label></div>
                                              <div class="checkbox icheck"><label>
                                                <input type="checkbox" class="sales_return_all" id='sales_delete' name="permission[sales_return_delete]"> XÓA
                                              </label></div>
                                              <div class="checkbox icheck"><label>
                                                <input type="checkbox" class="sales_return_all" id='sales_view' name="permission[sales_return_view]"> XEM
                                              </label></div>

                                              <div class="checkbox icheck"><label>
                                                <input type="checkbox" class="sales_return_all" id='view_all_users_sales_return_invoices' name="permission[view_all_users_sales_return_invoices]"> <?= $this->lang->line('view_all_users_sales_return_invoices'); ?>
                                              </label></div>

                                              <div class="checkbox icheck"><label>
                                                <input type="checkbox" class="sales_return_all" id='sales_return_payment_view' name="permission[sales_return_payment_view]"> <?= $this->lang->line('sales_return_payments_view'); ?>
                                              </label></div>
                                              <div class="checkbox icheck"><label>
                                                <input type="checkbox" class="sales_return_all" id='sales_return_payment_add' name="permission[sales_return_payment_add]"> <?= $this->lang->line('sales_return_payments_add'); ?>
                                              </label></div>
                                              <div class="checkbox icheck"><label>
                                                <input type="checkbox" class="sales_return_all" id='sales_return_payment_delete' name="permission[sales_return_payment_delete]"> <?= $this->lang->line('sales_return_payments_delete'); ?>
                                              </label></div>
                                          </td>
                                        </tr>
                                        <!-- SMS -->
                                        <tr>
                                          <td><?= $i++;?></td>
                                          <td><?= $this->lang->line('sms'); ?></td>
                                          <td>
                                              <div class="checkbox icheck"><label>
                                                <input type="checkbox" class="change_me" id="sms" > CHỌN TẤT CẢ
                                              </label></div>
                                          </td>
                                          <td>
                                              <input type="hidden" name="module[sms]" value="on">
                                              <div class="checkbox icheck"><label>
                                                <input type="checkbox" class="sms_all" id='send_sms' name="permission[send_sms]" > <?= $this->lang->line('send_sms'); ?>
                                              </label></div>
                                              <div class="checkbox icheck"><label>
                                                <input type="checkbox" class="sms_all" id='sms_template_edit' name="permission[sms_template_edit]"> <?= $this->lang->line('sms_template_edit'); ?>
                                              </label></div>
                                              
                                              <div class="checkbox icheck"><label>
                                                <input type="checkbox" class="sms_all" id='sms_template_view' name="permission[sms_template_view]"> <?= $this->lang->line('sms_template_view'); ?>
                                              </label></div>
                                              <div class="checkbox icheck"><label>
                                                <input type="checkbox" class="sms_all" id='sms_api_view' name="permission[sms_api_view]"> <?= $this->lang->line('sms_api_view'); ?>
                                              </label></div>
                                              <div class="checkbox icheck"><label>
                                                <input type="checkbox" class="sms_all" id='sms_api_edit' name="permission[sms_api_edit]"> <?= $this->lang->line('sms_api_edit'); ?>
                                              </label></div>
                                          </td>
                                        </tr>
                                        <!-- Reports -->
                                        <tr>
                                          <td><?= $i++;?></td>
                                          <td><?= $this->lang->line('reports'); ?></td>
                                          <td>
                                              <div class="checkbox icheck"><label>
                                                <input type="checkbox" class="change_me" id="reports" > CHỌN TẤT CẢ
                                              </label></div>
                                          </td>
                                          <td>
                                              <input type="hidden" name="module[reports]" value="on">
                                              <div class="checkbox icheck"><label>
                                                <input type="checkbox" class="reports_all" id='sales_report' name="permission[sales_report]" > <?= $this->lang->line('sales_report'); ?>
                                              </label></div>
                                              <div class="checkbox icheck"><label>
                                                <input type="checkbox" class="reports_all" id='sales_return_report' name="permission[sales_return_report]"> <?= $this->lang->line('sales_return_report'); ?>
                                              </label></div>
                                              <div class="checkbox icheck"><label>
                                                <input type="checkbox" class="reports_all" id='purchase_report' name="permission[purchase_report]"> <?= $this->lang->line('purchase_report'); ?>
                                              </label></div>
                                              <div class="checkbox icheck"><label>
                                                <input type="checkbox" class="reports_all" id='purchase_return_report' name="permission[purchase_return_report]"> <?= $this->lang->line('purchase_return_report'); ?>
                                              </label></div>
                                              <div class="checkbox icheck"><label>
                                                <input type="checkbox" class="reports_all" id='expense_report' name="permission[expense_report]"> <?= $this->lang->line('expense_report'); ?>
                                              </label></div>
                                              <div class="checkbox icheck"><label>
                                                <input type="checkbox" class="reports_all" id='profit_report' name="permission[profit_report]"> <?= $this->lang->line('profit_report'); ?>
                                              </label></div>
                                              <div class="checkbox icheck"><label>
                                                <input type="checkbox" class="reports_all" id='stock_report' name="permission[stock_report]"> <?= $this->lang->line('stock_report'); ?>
                                              </label></div>
                                              <div class="checkbox icheck"><label>
                                                <input type="checkbox" class="reports_all" id='item_sales_report' name="permission[item_sales_report]"> <?= $this->lang->line('item_sales_report'); ?>
                                              </label></div>
                                              <div class="checkbox icheck"><label>
                                                <input type="checkbox" class="reports_all" id='item_purchase_report' name="permission[item_purchase_report]"> <?= $this->lang->line('item_purchase_report'); ?>
                                              </label></div>
                                              <div class="checkbox icheck"><label>
                                                <input type="checkbox" class="reports_all" id='purchase_payments_report' name="permission[purchase_payments_report]"> <?= $this->lang->line('purchase_payments_report'); ?>
                                              </label></div>
                                              <div class="checkbox icheck"><label>
                                                <input type="checkbox" class="reports_all" id='sales_payments_report' name="permission[sales_payments_report]"> <?= $this->lang->line('sales_payments_report'); ?>
                                              </label></div>
                                              <div class="checkbox icheck"><label>
                                                <input type="checkbox" class="reports_all" id='expired_items_report' name="permission[expired_items_report]"> <?= $this->lang->line('expired_items_report'); ?>
                                              </label></div>
                                              <div class="checkbox icheck"><label>
                                                <input type="checkbox" class="reports_all" id='sales_return_report_extended' name="permission[sales_return_report_extended]"> BÁO CÁO TRẢ HÀNG CHI TIẾT
                                              </label></div>
                                              <div class="checkbox icheck"><label>
                                                <input type="checkbox" class="reports_all" id='product_sales_detailed_report' name="permission[product_sales_detailed_report]"> BÁO CÁO SẢN PHẨM BÁN CHI TIẾT
                                              </label></div>
                                              <div class="checkbox icheck"><label>
                                                <input type="checkbox" class="reports_all" id='product_purchase_detailed_report' name="permission[product_purchase_detailed_report]"> BÁO CÁO SẢN PHẨM NHẬP CHI TIẾT
                                              </label></div>
                                              <div class="checkbox icheck"><label>
                                                <input type="checkbox" class="reports_all" id='expired_products_detailed_report' name="permission[expired_products_detailed_report]"> BÁO CÁO SẢN PHẨM HẾT HẠN CHI TIẾT
                                              </label></div>
                                          </td>
                                        </tr>

                                        <!-- TAX GROUP -->
                                        <tr>
                                          <td><?= $i++;?></td>
                                          <td>Tax Group</td>
                                          <td>
                                              <div class="checkbox icheck"><label>
                                                <input type="checkbox" class="change_me" id="tax_group"> CHỌN TẤT CẢ
                                              </label></div>
                                          </td>
                                          <td>
                                              <input type="hidden" name="module[tax_group]" value="on">
                                              <div class="checkbox icheck"><label>
                                                <input type="checkbox" class="tax_group_all" id='tax_group_add' name="permission[tax_group_add]"> THÊM
                                              </label></div>
                                              <div class="checkbox icheck"><label>
                                                <input type="checkbox" class="tax_group_all" id='tax_group_edit' name="permission[tax_group_edit]"> SỬA
                                              </label></div>
                                              <div class="checkbox icheck"><label>
                                                <input type="checkbox" class="tax_group_all" id='tax_group_delete' name="permission[tax_group_delete]"> XÓA
                                              </label></div>
                                              <div class="checkbox icheck"><label>
                                                <input type="checkbox" class="tax_group_all" id='tax_group_view' name="permission[tax_group_view]"> XEM
                                              </label></div>
                                          </td>
                                        </tr>
                                        <!-- WAREHOUSE -->
                                        <tr>
                                          <td><?= $i++;?></td>
                                          <td>Warehouse</td>
                                          <td>
                                              <div class="checkbox icheck"><label>
                                                <input type="checkbox" class="change_me" id="warehouse"> CHỌN TẤT CẢ
                                              </label></div>
                                          </td>
                                          <td>
                                              <input type="hidden" name="module[warehouse]" value="on">
                                              <div class="checkbox icheck"><label>
                                                <input type="checkbox" class="warehouse_all" id='warehouse_add' name="permission[warehouse_add]"> THÊM
                                              </label></div>
                                              <div class="checkbox icheck"><label>
                                                <input type="checkbox" class="warehouse_all" id='warehouse_edit' name="permission[warehouse_edit]"> SỬA
                                              </label></div>
                                              <div class="checkbox icheck"><label>
                                                <input type="checkbox" class="warehouse_all" id='warehouse_delete' name="permission[warehouse_delete]"> XÓA
                                              </label></div>
                                              <div class="checkbox icheck"><label>
                                                <input type="checkbox" class="warehouse_all" id='warehouse_view' name="permission[warehouse_view]"> XEM
                                              </label></div>
                                          </td>
                                        </tr>
                                        <!-- ORDERS -->
                                        <tr>
                                          <td><?= $i++;?></td>
                                          <td>Orders</td>
                                          <td>
                                              <div class="checkbox icheck"><label>
                                                <input type="checkbox" class="change_me" id="orders"> CHỌN TẤT CẢ
                                              </label></div>
                                          </td>
                                          <td>
                                              <input type="hidden" name="module[orders]" value="on">
                                              <div class="checkbox icheck"><label>
                                                <input type="checkbox" class="orders_all" id='orders_add' name="permission[orders_add]"> THÊM
                                              </label></div>
                                              <div class="checkbox icheck"><label>
                                                <input type="checkbox" class="orders_all" id='orders_edit' name="permission[orders_edit]"> SỬA
                                              </label></div>
                                              <div class="checkbox icheck"><label>
                                                <input type="checkbox" class="orders_all" id='orders_delete' name="permission[orders_delete]"> XÓA
                                              </label></div>
                                              <div class="checkbox icheck"><label>
                                                <input type="checkbox" class="orders_all" id='orders_view' name="permission[orders_view]"> XEM
                                              </label></div>
                                          </td>
                                        </tr>
                                        <!-- EMAIL -->
                                        <tr>
                                          <td><?= $i++;?></td>
                                          <td>Email</td>
                                          <td>
                                              <div class="checkbox icheck"><label>
                                                <input type="checkbox" class="change_me" id="email"> CHỌN TẤT CẢ
                                              </label></div>
                                          </td>
                                          <td>
                                              <input type="hidden" name="module[email]" value="on">
                                              <div class="checkbox icheck"><label>
                                                <input type="checkbox" class="email_all" id='send_email' name="permission[send_email]"> GỬI EMAIL
                                              </label></div>
                                              <div class="checkbox icheck"><label>
                                                <input type="checkbox" class="email_all" id='email_template_edit' name="permission[email_template_edit]"> SỬA MẪU EMAIL
                                              </label></div>
                                              <div class="checkbox icheck"><label>
                                                <input type="checkbox" class="email_all" id='email_template_view' name="permission[email_template_view]"> XEM MẪU EMAIL
                                              </label></div>
                                          </td>
                                        </tr>
                                        <!-- IMPORT -->
                                        <tr>
                                          <td><?= $i++;?></td>
                                          <td>Import Data</td>
                                          <td>
                                              <div class="checkbox icheck"><label>
                                                <input type="checkbox" class="change_me" id="import"> CHỌN TẤT CẢ
                                              </label></div>
                                          </td>
                                          <td>
                                              <input type="hidden" name="module[import]" value="on">
                                              <div class="checkbox icheck"><label>
                                                <input type="checkbox" class="import_all" id='import_data' name="permission[import_data]"> NHẬP DỮ LIỆU
                                              </label></div>
                                              <div class="checkbox icheck"><label>
                                                <input type="checkbox" class="import_all" id='import_excel' name="permission[import_excel]"> NHẬP TỪ EXCEL
                                              </label></div>
                                              <div class="checkbox icheck"><label>
                                                <input type="checkbox" class="import_all" id='import_csv' name="permission[import_csv]"> NHẬP TỪ CSV
                                              </label></div>
                                          </td>
                                        </tr>
                                        <!-- TEMPLATES -->
                                        <tr>
                                          <td><?= $i++;?></td>
                                          <td>Templates</td>
                                          <td>
                                              <div class="checkbox icheck"><label>
                                                <input type="checkbox" class="change_me" id="templates"> CHỌN TẤT CẢ
                                              </label></div>
                                          </td>
                                          <td>
                                              <input type="hidden" name="module[templates]" value="on">
                                              <div class="checkbox icheck"><label>
                                                <input type="checkbox" class="templates_all" id='templates_add' name="permission[templates_add]"> THÊM
                                              </label></div>
                                              <div class="checkbox icheck"><label>
                                                <input type="checkbox" class="templates_all" id='templates_edit' name="permission[templates_edit]"> SỬA
                                              </label></div>
                                              <div class="checkbox icheck"><label>
                                                <input type="checkbox" class="templates_all" id='templates_delete' name="permission[templates_delete]"> XÓA
                                              </label></div>
                                              <div class="checkbox icheck"><label>
                                                <input type="checkbox" class="templates_all" id='templates_view' name="permission[templates_view]"> XEM
                                              </label></div>
                                          </td>
                                        </tr>
                                        <!-- BARCODE & QR CODE -->
                                        <tr>
                                          <td><?= $i++;?></td>
                                          <td>Barcode & QR Code</td>
                                          <td>
                                              <div class="checkbox icheck"><label>
                                                <input type="checkbox" class="change_me" id="barcode"> CHỌN TẤT CẢ
                                              </label></div>
                                          </td>
                                          <td>
                                              <input type="hidden" name="module[barcode]" value="on">
                                              <div class="checkbox icheck"><label>
                                                <input type="checkbox" class="barcode_all" id='generate_barcode' name="permission[generate_barcode]"> TẠO MÃ VẠCH
                                              </label></div>
                                              <div class="checkbox icheck"><label>
                                                <input type="checkbox" class="barcode_all" id='generate_qrcode' name="permission[generate_qrcode]"> TẠO MÃ QR
                                              </label></div>
                                              <div class="checkbox icheck"><label>
                                                <input type="checkbox" class="barcode_all" id='print_barcode' name="permission[print_barcode]"> IN MÃ VẠCH
                                              </label></div>
                                          </td>
                                        </tr>
                                        <!-- SALES STOCK -->
                                        <tr>
                                          <td><?= $i++;?></td>
                                          <td>Sales Stock</td>
                                          <td>
                                              <div class="checkbox icheck"><label>
                                                <input type="checkbox" class="change_me" id="sales_stock"> CHỌN TẤT CẢ
                                              </label></div>
                                          </td>
                                          <td>
                                              <input type="hidden" name="module[sales_stock]" value="on">
                                              <div class="checkbox icheck"><label>
                                                <input type="checkbox" class="sales_stock_all" id='sales_stock_view' name="permission[sales_stock_view]"> XEM TỒN KHO BÁN HÀNG
                                              </label></div>
                                              <div class="checkbox icheck"><label>
                                                <input type="checkbox" class="sales_stock_all" id='sales_stock_report' name="permission[sales_stock_report]"> BÁO CÁO TỒN KHO
                                              </label></div>
                                          </td>
                                        </tr>
                                        <!-- POINTS MANAGEMENT -->
                                        <tr>
                                          <td><?= $i++;?></td>
                                          <td>Points Management</td>
                                          <td>
                                              <div class="checkbox icheck"><label>
                                                <input type="checkbox" class="change_me" id="points"> CHỌN TẤT CẢ
                                              </label></div>
                                          </td>
                                          <td>
                                              <input type="hidden" name="module[points]" value="on">
                                              <div class="checkbox icheck"><label>
                                                <input type="checkbox" class="points_all" id='points_add' name="permission[points_add]"> THÊM ĐIỂM
                                              </label></div>
                                              <div class="checkbox icheck"><label>
                                                <input type="checkbox" class="points_all" id='points_edit' name="permission[points_edit]"> SỬA ĐIỂM
                                              </label></div>
                                              <div class="checkbox icheck"><label>
                                                <input type="checkbox" class="points_all" id='points_delete' name="permission[points_delete]"> XÓA ĐIỂM
                                              </label></div>
                                              <div class="checkbox icheck"><label>
                                                <input type="checkbox" class="points_all" id='points_view' name="permission[points_view]"> XEM ĐIỂM
                                              </label></div>
                                              <div class="checkbox icheck"><label>
                                                <input type="checkbox" class="points_all" id='customer_point' name="permission[customer_point]"> ĐIỂM TÍCH LŨY KHÁCH HÀNG
                                              </label></div>
                                          </td>
                                        </tr>
                                        <!-- SYSTEM UPDATES -->
                                        <tr>
                                          <td><?= $i++;?></td>
                                          <td>System Updates</td>
                                          <td>
                                              <div class="checkbox icheck"><label>
                                                <input type="checkbox" class="change_me" id="updates"> CHỌN TẤT CẢ
                                              </label></div>
                                          </td>
                                          <td>
                                              <input type="hidden" name="module[updates]" value="on">
                                              <div class="checkbox icheck"><label>
                                                <input type="checkbox" class="updates_all" id='system_update' name="permission[system_update]"> CẬP NHẬT HỆ THỐNG
                                              </label></div>
                                              <div class="checkbox icheck"><label>
                                                <input type="checkbox" class="updates_all" id='database_update' name="permission[database_update]"> CẬP NHẬT CSDL
                                              </label></div>
                                              <div class="checkbox icheck"><label>
                                                <input type="checkbox" class="updates_all" id='backup_restore' name="permission[backup_restore]"> SAO LƯU & PHỤC HỒI
                                              </label></div>
                                          </td>
                                        </tr>
                                        <!--HELP & DOCUMENTATION  -->
                                        <tr>
                                          <td><?= $i++;?></td>
                                          <td><?= $this->lang->line('help_documentation'); ?></td>
                                          <td>
                                              <div class="checkbox icheck"><label>
                                                <input type="checkbox" class="change_me" id="help"> CHỌN TẤT CẢ
                                              </label></div>
                                          </td>
                                          <td>
                                              <input type="hidden" name="module[help]" value="on">
                                              <div class="checkbox icheck"><label>
                                                <input type="checkbox" class="help_all" id='help' name="permission[help]"> <?= $this->lang->line('help_documentation'); ?>
                                              </label></div>
                                          </td>
                                        </tr>
                                        <!--SYSTEM ROOT  -->
                                        <tr>
                                          <td><?= $i++;?></td>
                                          <td>Hệ thống chính</td>
                                          <td>
                                              <div class="checkbox icheck"><label>
                                                <input type="checkbox" class="change_me" id="system_root"> CHỌN TẤT CẢ
                                              </label></div>
                                          </td>
                                          <td>
                                              <input type="hidden" name="module[system_root]" value="on">
                                              <div class="checkbox icheck"><label>
                                                <input type="checkbox" class="system_root_all" id='root_access' name="permission[root_access]"> ĐẶC QUYỀN ROOT
                                              </label></div>
                                              <div class="checkbox icheck"><label>
                                                <input type="checkbox" class="system_root_all" id='system_settings_full' name="permission[system_settings_full]"> CÀI ĐẶT HỆ THỐNG TOÀN QUYỀN
                                              </label></div>
                                              <div class="checkbox icheck"><label>
                                                <input type="checkbox" class="system_root_all" id='database_management' name="permission[database_management]"> QUẢN LÝ CSDL TOÀN QUYỀN
                                              </label></div>
                                          </td>
                                        </tr>
                                        
                                        


                                      </tbody>
                                      
                                    </table>
                                 </div>
                              </div>

                           </div>
                           <!-- /.box-footer -->
                           <div class="box-footer">
                              <div class="col-sm-8 col-sm-offset-2 text-center">
                                 <!-- <div class="col-sm-4"></div> -->
                                 <?php
                                    if($role_name!=""){
                                         $btn_name="Cập nhật";
                                         $btn_id="update";
                                        ?>
                                 <input type="hidden" name="q_id" id="q_id" value="<?php echo $q_id;?>"/>
                                 <?php
                                    }
                                              else{
                                                  $btn_name="Lưu";
                                                  $btn_id="save";
                                              }
                                    
                                              ?>
                                 <div class="col-md-3 col-md-offset-3">
                                    <button type="button" id="<?php echo $btn_id;?>" class=" btn btn-block btn-success" title="Save Data"><?php echo $btn_name;?></button>
                                 </div>
                                 <div class="col-sm-3">
                                    <a href="<?=base_url('dashboard');?>">
                                    <button type="button" class="col-sm-3 btn btn-block btn-warning close_btn" title="Go Dashboard">Đóng</button>
                                    </a>
                                 </div>
                              </div>
                           </div>
                           <!-- /.box-footer -->
                        </form>
                     </div>
                     <!-- /.box -->
                  </div>
                  <!--/.col (right) -->
               </div>
               <!-- /.row -->
            </section>
            <!-- /.content -->
         </div>
         <!-- /.content-wrapper -->
         <?php include"footer.php"; ?>
         <!-- Add the sidebar's background. This div must be placed
            immediately after the control sidebar -->
         <div class="control-sidebar-bg"></div>
      </div>
      <!-- ./wrapper -->
      <!-- SOUND CODE -->
      <?php include"comman/code_js_sound.php"; ?>
      <!-- TABLES CODE -->
      <?php include"comman/code_js_form.php"; ?>
      <script src="<?php echo $theme_link; ?>js/roles.js"></script>
      <!-- SELECT THE CHECKBOX'S -->
      <script type="text/javascript">
        <?php 
        $str='';
        if(isset($q_id) && !empty($q_id)){
          $q1=$this->db->query("select permissions from db_permissions where role_id=".$q_id);
          if($q1->num_rows()>0){
            foreach ($q1->result() as $res1) {
              if(empty($str)){
                $str=' #'.$res1->permissions;
              }
              else{
                $str=$str.', #'.$res1->permissions;
              }
          } 
        }
      }
        ?>
        $('<?php echo $str;?>').prop("checked",true).iCheck('update');

      </script>
      <!-- Make sidebar menu hughlighter/selector -->
      <script>$(".<?php echo basename(__FILE__,'.php');?>-active-li").addClass("active");</script>
   </body>
</html>

