<!-- Change the theme color if it is set -->
   <script type="text/javascript">
    if(theme_skin!='skin-blue'){
      $("body").addClass(theme_skin);
      $("body").removeClass('skin-blue');
    }
    if(sidebar_collapse=='true'){
      $("body").addClass('sidebar-collapse');
    }
  </script> 
  <!-- end -->

<?php 
    $CI =& get_instance();
  ?>
<header class="main-header">
<style>
    .skin-blue .sidebar-menu>li:hover>a, .skin-blue .sidebar-menu>li.active>a {
        background-color: #3c8dbc;
    }
    .skin-blue .treeview-menu>li.active>a, .skin-blue .treeview-menu>li>a:hover {
        /*background-color: #5b6469;*/
        font-weight: bold;
    }
    /* Fix cho menu text quá dài */
    .sidebar-menu .treeview-menu li a span {
        white-space: nowrap;
        overflow: hidden;
        text-overflow: ellipsis;
        max-width: 180px;
        display: inline-block;
    }
    .sidebar-menu .treeview-menu li a {
        padding-right: 5px;
    }
</style>
    <!-- Logo -->
    <a href="<?php echo $base_url; ?>dashboard" class="logo">
      <span class="logo-mini"><b>POS</b></span>
      <span class="logo-lg"><b><?php  echo $SITE_TITLE;?></b></span>
    </a>

    <!-- Header Navbar: style can be found in header.less -->
    <nav class="navbar navbar-static-top">
      <!-- Sidebar toggle button-->
      <a href="#" class="sidebar-toggle" data-toggle="offcanvas" role="button">
        <span class="sr-only">Toggle navigation</span>
      </a>
      <!-- Navbar Right Menu -->
      <div class="navbar-custom-menu">
       
        <ul class="nav navbar-nav">
          
          <li class="dropdown user user-menu">
            <a href="#" class="dropdown-toggle" data-toggle="dropdown">
              <img src="<?php echo get_profile_picture(); ?>" class="user-image" alt="User Image">
              <span class="hidden-xs"><?php print ucfirst($this->session->userdata('inv_username')); ?></span>
            </a>

            <ul class="dropdown-menu">
              <!-- User image -->
              <li class="user-header">
                <img src="<?php echo get_profile_picture(); ?>" class="img-circle" alt="User Image">

                <p>
                 <?php print ucfirst($this->session->userdata('inv_username')); ?>
                  <small>Năm <?=date("Y");?></small>
                </p>
              </li>
              <!-- Menu Body -->
              <!-- Menu Footer-->
              <li class="user-footer">
                <div class="pull-left">
                  <a href="<?php echo $base_url; ?>users/edit/<?= $this->session->userdata('inv_userid'); ?>" class="btn btn-default btn-flat">Chỉnh sửa</a>
                </div>
                <div class="pull-right">
                  <a href="<?php echo $base_url; ?>logout" class="btn btn-default btn-flat">Thoát</a>
                </div>
              </li>
            </ul>
          </li>
          <li class="hidden-xs">
            <a href="#" data-toggle="control-sidebar"><i class="fa fa-gears"></i></a>
          </li>
        </ul>
      </div>

    </nav>
  </header>
 
  <!-- Left side column. contains the logo and sidebar -->
  <aside class="main-sidebar">
    <!-- sidebar: style can be found in sidebar.less -->
    <section class="sidebar">
      <div class="user-panel">
        <div class="pull-left image">
          <img src="<?php echo get_profile_picture(); ?>" class="img-circle" alt="User Image">
        </div>
        <div class="pull-left info">
          <p><?php print ucfirst($this->session->userdata('inv_username')); ?><i class="fa fa-fw fa-check-circle text-aqua"></i></p>
          <a href="#"><i class="fa fa-circle text-success"></i> Online</a>
        </div>
      </div>
      <!-- sidebar menu: : style can be found in sidebar.less -->
      <ul class="sidebar-menu">
        <!--<li class="header">MAIN NAVIGATION</li>-->
        
        
        
        
        <?php if($CI->permissions('dashboard')) { ?>
		<li class="dashboard-active-li "><a href="<?php echo $base_url; ?>dashboard"><i class="fa fa-dashboard text-aqua"></i> <span>Tóm lượt 123</span></a></li>
		<?php } ?>
		
        <?php if($CI->permissions('duelist')) { ?>
        <li class="dues-list-active-li "><a href="<?php echo $base_url; ?>duelist"><i class="fa fa-shopping-cart text-aqua"></i> <span>Công nợ</span></a></li>
        <?php } ?>
        
        
		
		<?php if($CI->permissions('sales_add')  || $CI->permissions('sales_view')) { ?>
    		<li class="pos-active-li sales-list-active-li sales-active-li treeview">
              <a href="#">
                <i class=" fa fa-shopping-cart text-aqua"></i> <span>BÁN HÀNG</span>
                <span class="pull-right-container">
                  <i class="fa fa-angle-left pull-right"></i>
                </span>
              </a>
              <ul class="treeview-menu">
                <?php if($CI->permissions('sales_add')) { ?>
        		    <li class="sales-active-li"><a href="<?php echo $base_url; ?>sales/add"><i class="fa fa-plus-square-o "></i> <span>Tạo đơn hàng mới</span></a></li>
                <?php } ?>
                
                <?php if($CI->permissions('sales_view')) { ?>
                <li class="sales-list-active-li"><a href="<?php echo $base_url; ?>sales"><i class="fa fa-list "></i> <span>Thống kê đơn hàng</span></a></li>
                <?php } ?>
              </ul>
            </li>
        <?php } ?>
        
        
    <?php if ($this->session->userdata('inv_userid') == '1') { ?>
    <?php if($CI->permissions('sales_return_view') || $CI->permissions('sales_return_add')) { ?>
		<li class="sales-return-active-li sales-return-list-active-li treeview">
          <a href="#">
            <i class=" fa fa-shopping-cart text-aqua"></i> <span>TRẢ HÀNG</span>
            <span class="pull-right-container">
              <i class="fa fa-angle-left pull-right"></i>
            </span>
          </a>
          <ul class="treeview-menu">
        <?php if($CI->permissions('sales_return_add')) { ?>
        <li class="sales-return-active-li"><a href="<?php echo $base_url; ?>sales_return/create"><i class="fa fa-list "></i> <span>Tạo đơn trả hàng</span></a></li>
        <?php } ?>
        <?php if($CI->permissions('sales_return_view')) { ?>
        <li class="sales-return-list-active-li"><a href="<?php echo $base_url; ?>sales_return"><i class="fa fa-list "></i> <span>Danh sách trả hàng</span></a></li>
        <?php } ?>
        
          </ul>
        </li>
    <?php } ?>
    <?php } ?>
    
        <?php if($CI->permissions('purchase_view') || $CI->permissions('purchase_add')) { ?>
    		<li class="purchase-active-li purchase-list-active-li treeview">
              <a href="#">
                <i class=" fa fa-shopping-cart text-aqua"></i> <span>NHẬP HÀNG</span>
                <span class="pull-right-container">
                  <i class="fa fa-angle-left pull-right"></i>
                </span>
              </a>
              <ul class="treeview-menu">
            <?php if($CI->permissions('purchase_add')) { ?>
                <li class="purchase-active-li"><a href="<?php echo $base_url; ?>purchase/add"><i class="fa fa-list "></i> <span>Kê đơn nhập hàng</span></a></li>
            <?php } ?>
            
            <?php if($CI->permissions('purchase_view')) { ?>
                <li class="purchase-list-active-li"><a href="<?php echo $base_url; ?>purchase"><i class="fa fa-list "></i> <span>Danh sách nhập hàng</span></a></li>
            <?php } ?>
    
              </ul>
            </li>
        <?php } ?>
		

    
    <?php if($CI->permissions('brand_view') || $CI->permissions('items_category_view') || $CI->permissions('stock_report') || $CI->permissions('import_items') || $CI->permissions('items_add') || $CI->permissions('items_view') || $CI->permissions('print_labels') || $CI->permissions('items_stock')) { ?>
        <li class="items-list-active-li items-active-li items-stock-active-li labels-active-li import_items-active-li treeview report-stock-active-li category-view-active-li brand-view-active-li">
          <a href="#">
            <i class="fa fa-cubes text-aqua"></i> <span>Sản phẩm</span>
            <span class="pull-right-container">
              <i class="fa fa-angle-left pull-right"></i>
            </span>
          </a>
          <ul class="treeview-menu">
            <?php if($CI->permissions('stock_report')) { ?>
                <li class="report-stock-active-li"><a href="<?php echo $base_url; ?>reports/stock" ><i class="fa fa-archive"></i> <span>Tồn kho</span></a></li>
            <?php } ?>
            <?php if($CI->permissions('items_stock')) { ?>
                <li class="items-stock-active-li"><a href="<?php echo $base_url; ?>sales/stock"><i class="fa fa-list "></i> <span>Kiểm hàng</span></a></li>
            <?php } ?>
            <?php if($CI->permissions('items_add')) { ?>
                <li class="items-active-li"><a href="<?php echo $base_url; ?>items/add"><i class="fa fa-plus-square-o "></i> <span>Thêm mới sản phẩm</span></a></li>
            <?php } ?>
            <?php if($CI->permissions('items_view')) { ?>
                <li class="items-list-active-li"><a href="<?php echo $base_url; ?>items"><i class="fa fa-list "></i> <span>Liệt kê sản phẩm</span></a></li>
            <?php } ?>
            <?php if($CI->permissions('print_labels')) { ?>
                <li class="labels-active-li"><a href="<?php echo $base_url; ?>items/labels"><i class="fa fa-barcode "></i> <span>In tem sản phẩm</span></a></li>
            <?php } ?>
            <?php if($CI->permissions('items_category_view')) { ?>
                <li class="category-view-active-li"><a href="<?php echo $base_url; ?>category/view"><i class="fa fa-list "></i> <span>Danh mục sản phẩm</span></a></li>
            <?php } ?>
            <?php if($CI->permissions('brand_view')) { ?>
                <li class="brand-view-active-li"><a href="<?php echo $base_url; ?>brands/view"><i class="fa fa-list "></i> <span>Thương hiệu sản phẩm</span></a></li>
            <?php } ?>
            <?php if($CI->permissions('import_items')) { ?>
                <li class="import_items-active-li"><a href="<?php echo $base_url; ?>import/items"><i class="fa fa-arrow-circle-o-left "></i> <span>Thêm nhiều sản phẩm</span></a></li>
            <?php } ?>
          </ul>
        </li>
    <?php } ?>
		
    
    

    <?php if($CI->permissions('customers_point') || $CI->permissions('customers_add') || $CI->permissions('customers_view') || $CI->permissions('import_customers')) { ?>
        <li class="customers-view-active-li customers-point-active-li customers-active-li import_customers-active-li treeview">
          <a href="#">
            <i class="fa fa-group text-aqua"></i> <span>Khách hàng</span>
            <span class="pull-right-container">
              <i class="fa fa-angle-left pull-right"></i>
            </span>
          </a>
          <ul class="treeview-menu">
         <?php if($CI->permissions('customers_add')) { ?>
        <li class="customers-active-li"><a href="<?php echo $base_url; ?>customers/add"><i class="fa fa-plus-square-o "></i> <span>Thêm khách hàng</span></a></li>
        <?php } ?>
        <?php if($CI->permissions('customers_view')) { ?>
         <li class="customers-view-active-li"><a href="<?php echo $base_url; ?>customers"><i class="fa fa-list "></i> <span>Danh sách khách hàng</span></a></li>
         <?php } ?>
         <?php if($CI->permissions('customers_point')) { ?>
         <li class="customers-point-active-li"><a href="<?php echo $base_url; ?>points"><i class="fa fa-list "></i> <span>Lịch sử điểm tích lũy</span></a></li>
         <?php } ?>

         <?php if($CI->permissions('import_customers') && $this->session->userdata('inv_userid') == '1') { ?>
         <li class="import_customers-active-li"><a href="<?php echo $base_url; ?>import/customers"><i class="fa fa-arrow-circle-o-left "></i> <span><?= $this->lang->line('import_customers'); ?> Admin</span></a></li>
         <?php } ?>

          </ul>
        </li>    
    <?php } ?>

    
    
    
    <?php if($CI->permissions('suppliers_add') || $CI->permissions('suppliers_view') || $CI->permissions('import_suppliers') ) { ?>
        <li class="suppliers-list-active-li suppliers-active-li import_suppliers-active-li treeview">
          <a href="#">
            <i class="fa fa-user-plus text-aqua"></i> <span>Nhà cung cấp</span>
            <span class="pull-right-container">
              <i class="fa fa-angle-left pull-right"></i>
            </span>
          </a>
          <ul class="treeview-menu">
              <?php if($CI->permissions('suppliers_add')) { ?>
              <li class="suppliers-active-li"><a href="<?php echo $base_url; ?>suppliers/add"><i class="fa fa-plus-square-o "></i> <span>Thêm nhà cung cấp</span></a></li>
              <?php } ?>
              <?php if($CI->permissions('suppliers_view')) { ?>
              <li class="suppliers-list-active-li"><a href="<?php echo $base_url; ?>suppliers"><i class="fa fa-list "></i> <span>Danh sách nhà cung cấp</span></a></li>
              <?php } ?>

              <?php if($CI->permissions('import_suppliers') && $this->session->userdata('inv_userid') == '1') { ?>
               <li class="import_suppliers-active-li"><a href="<?php echo $base_url; ?>import/suppliers"><i class="fa fa-arrow-circle-o-left "></i> <span><?= $this->lang->line('import_suppliers'); ?> Admin</span></a></li>
               <?php } ?>
         
          </ul>
        </li>
    <?php } ?>
        
 

    
    <?php if($CI->permissions('expense_add') || $CI->permissions('expense_view') || $CI->permissions('expense_category_add') || $CI->permissions('expense_category_view')) { ?>
        <li class="expense-list-active-li expense-active-li expense-category-active-li expense-category-list-active-li treeview">
          <a href="#">
            <i class="fa fa-minus-circle text-aqua"></i> <span>Chi phí vận hành</span>
            <span class="pull-right-container">
              <i class="fa fa-angle-left pull-right"></i>
            </span>
          </a>
          <ul class="treeview-menu">
            <?php if($CI->permissions('expense_add')) { ?>
            <li class="expense-active-li"><a href="<?php echo $base_url; ?>expense/add"><i class="fa fa-plus-square-o "></i> <span>Thêm chi phí</span></a></li>
            <?php } ?>
            <?php if($CI->permissions('expense_view')) { ?>
            <li class="expense-list-active-li"><a href="<?php echo $base_url; ?>expense"><i class="fa fa-list "></i> <span>Thống kê chi phí</span></a></li>
            <?php } ?>
            <?php if($CI->permissions('expense_category_view')) { ?>
            <li class="expense-category-list-active-li "><a href="<?php echo $base_url; ?>expense/category"><i class="fa fa-list "></i> <span>Danh mục chi phí</span></a></li>
            <?php } ?>

          </ul>
        </li>
    <?php  } ?>
		

        
		
    <?php if ($this->session->userdata('inv_userid') == '1') { ?>
		<?php if($CI->permissions('places_add') || $CI->permissions('places_view')) { ?>
		<li class="country-active-li city-list-active-li country-list-active-li state-active-li state-list-active-li city-active-li treeview">
            <a href="#">
                <i class="fa fa-paper-plane-o text-aqua"></i> <span>Định vị Admin</span>
                <span class="pull-right-container">
                    <i class="fa fa-angle-left pull-right"></i>
                </span>
            </a>
            <ul class="treeview-menu">
                <?php if($CI->permissions('places_add')) { ?>
                <li class="country-active-li"><a href="<?php echo $base_url; ?>country/add"><i class="fa fa-plus-square-o "></i> <span><?= $this->lang->line('new_country'); ?></span></a></li>
                <?php } ?>
                <?php if($CI->permissions('places_view')) { ?>
                <li class="country-list-active-li "><a href="<?php echo $base_url; ?>country"><i class="fa fa-list "></i> <span><?= $this->lang->line('countries_list'); ?></span></a></li>
                <?php } ?>
                <?php if($CI->permissions('places_add')) { ?>
                <li class="state-active-li"><a href="<?php echo $base_url; ?>state/add"><i class="fa fa-plus-square-o "></i> <span><?= $this->lang->line('new_state'); ?></span></a></li>
                <?php } ?>
                <?php if($CI->permissions('places_view')) { ?>
                <li class="state-list-active-li "><a href="<?php echo $base_url; ?>state"><i class="fa fa-list "></i> <span><?= $this->lang->line('states_list'); ?></span></a></li>
                <?php } ?>
            </ul>
        </li>
    <?php } } ?>

   
		<!--<li class="header">REPORTS</li>-->
    <?php if($CI->permissions('item_purchase_report') ||$CI->permissions('sales_report') || $CI->permissions('item_sales_report') || $CI->permissions('purchase_report') || $CI->permissions('purchase_return_report') || $CI->permissions('expense_report') || $CI->permissions('profit_report') || $CI->permissions('stock_report') || $CI->permissions('purchase_payments_report') || $CI->permissions('sales_payments_report') || $CI->permissions('expired_items_report')) { ?>
		<!--li class="report-sales-active-li report-sales-return-active-li report-purchase-active-li report-purchase-return-active-li report-expense-active-li report-profit-loss-active-li report-stock-active-li report-purchase-payments-active-li report-sales-item-active-li report-sales-payments-active-li report-expired-items-active-li report-purchase-item-active-li treeview">
          <a href="#">
            <i class="fa fa-bar-chart text-aqua"></i> <span>Báo cáo</span>
            <span class="pull-right-container">
              <i class="fa fa-angle-left pull-right"></i>
            </span>
          </a>
          <ul class="treeview-menu">
            <?php if($CI->permissions('expense_report')) { ?>
            <li class="report-expense-active-li"><a href="<?php echo $base_url; ?>reports/expense" ><i class="fa fa-files-o "></i> <span>Báo cáo chi phí</span></a></li>
            <?php } ?>

            <?php if($CI->permissions('profit_report')) { ?>
            <li class="report-profit-loss-active-li"><a href="<?php echo $base_url; ?>reports/profit_loss" ><i class="fa fa-files-o "></i> <span>Báo cáo lợi nhuận</span></a></li>
            <?php } ?>

            <?php if($CI->permissions('purchase_report')) { ?>
            <li class="report-purchase-active-li"><a href="<?php echo $base_url; ?>reports/purchase" ><i class="fa fa-files-o "></i> <span>Báo cáo nhập hàng</span></a></li>
            <?php } ?>
            <?php if($CI->permissions('purchase_return_report')) { ?>
            <li class="report-purchase-return-active-li"><a href="<?php echo $base_url; ?>reports/purchase_return" ><i class="fa fa-files-o "></i> <span>Báo cáo trả hàng</span></a></li>
            <?php } ?>

            <?php if($CI->permissions('purchase_payments_report')) { ?>
            <li class="report-purchase-payments-active-li"><a href="<?php echo $base_url; ?>reports/purchase_payments" ><i class="fa fa-files-o "></i> <span>Báo cáo thanh toán</span></a></li>
            <?php } ?>

            <?php if($CI->permissions('item_sales_report')) { ?>
            <li class="report-sales-item-active-li"><a href="<?php echo $base_url; ?>reports/item_sales" ><i class="fa fa-files-o "></i> <span>Báo cáo doanh số sản phẩm</span></a></li>
            <?php } ?>
            <?php if($CI->permissions('item_purchase_report') && $this->session->userdata('inv_userid') == '1') { ?>
            <li class="report-purchase-item-active-li"><a href="<?php echo $base_url; ?>reports/item_purchase" ><i class="fa fa-files-o "></i> <span><?= $this->lang->line('item_purchase_report'); ?></span><span class="pull-right-container">
              <span class="label label-success pull-right">New</span>
            </span></a></li>
            <?php } ?>
            <?php if($CI->permissions('sales_report')) { ?>
            <li class="report-sales-active-li"><a href="<?php echo $base_url; ?>reports/sales" ><i class="fa fa-files-o "></i> <span>Báo cáo doanh số bán hàng</span></a></li>
            <?php } ?>
            <?php if($CI->permissions('sales_return_report') && $this->session->userdata('inv_userid') == '1') { ?>
            <li class="report-sales-return-active-li"><a href="<?php echo $base_url; ?>reports/sales_return" ><i class="fa fa-files-o "></i> <span><?= $this->lang->line('sales_return_report'); ?></span></a></li>
            <?php } ?>
            
            <?php if($CI->permissions('sales_payments_report') && $this->session->userdata('inv_userid') == '1') { ?>
            <li class="report-sales-payments-active-li"><a href="<?php echo $base_url; ?>reports/sales_payments" ><i class="fa fa-files-o "></i> <span><?= $this->lang->line('sales_payments_report'); ?></span></a></li>  
            <?php } ?>


            <?php if($CI->permissions('stock_report')) { ?>
            <li class="report-stock-active-li"><a href="<?php echo $base_url; ?>reports/stock" ><i class="fa fa-files-o "></i> <span>Báo cáo tồn kho</span>
              </a></li>
            <?php } ?>
            <?php if($CI->permissions('expired_items_report') && $this->session->userdata('inv_userid') == '1') { ?>
            <li class="report-expired-items-active-li"><a href="<?php echo $base_url; ?>reports/expired_items" ><i class="fa fa-files-o "></i> <span><?= $this->lang->line('expired_items_report'); ?></span></a></li>  
            <?php } ?>
	       </ul>
      </li>
    <?php } ?>

    <!-- Users -->
    <?php if ($this->session->userdata('inv_userid') == '1') { ?>
    <?php if($CI->permissions('users_add') || $CI->permissions('users_view') || $CI->permissions('roles_view')) { ?>
    <li class="users-view-active-li users-active-li roles-list-active-li role-active-li treeview">
      <a href="#">
        <i class="fa fa-users text-aqua"></i> <span>Người dùng Admin</span>
        <span class="pull-right-container">
          <i class="fa fa-angle-left pull-right"></i>
        </span>
      </a>
      <ul class="treeview-menu">
        <?php if($CI->permissions('users_add')) { ?>
        <li class="users-active-li">
          <a href="<?php echo $base_url; ?>users/add">
         <i class="fa fa-plus-square-o"></i> <span>Thêm mới</span>
          </a>
        </li>
        <?php } ?>
        <?php if($CI->permissions('users_view')) { ?>
        <li class="users-view-active-li">
          <a href="<?php echo $base_url; ?>users/view">
         <i class="fa fa-list"></i> <span>Danh sách</span>
          </a>
        </li>
        <?php } ?>
        <?php if($CI->permissions('roles_view')) { ?>
        <li class="roles-list-active-li role-active-li">
          <a href="<?php echo $base_url; ?>roles/view">
         <i class="fa fa-list"></i> <span>Bảng quyền hạn</span>
          </a>
        </li>
        <?php } ?>
      </ul>
       </li>
    <?php } } ?>
    <!-- SMS -->
    <?php if ($this->session->userdata('inv_userid') == '1') { ?>
     <?php if($CI->permissions('send_sms') || $CI->permissions('sms_template_view') || $CI->permissions('sms_api_view')) { ?>
     <li class="sms-active-li sms-api-active-li sms-template-active-li sms-templates-list-active-li treeview">
          <a href="#">
            <i class="fa fa-envelope text-aqua"></i> <span><?= $this->lang->line('sms'); ?> Admin</span>
            <span class="pull-right-container">
              <i class="fa fa-angle-left pull-right"></i>
            </span>
          </a>
          <ul class="treeview-menu">
            <?php if($CI->permissions('send_sms')) { ?>
            <li class="sms-active-li"><a href="<?php echo $base_url; ?>sms"><i class="fa fa-envelope-o "></i> <span><?= $this->lang->line('send_sms'); ?></span></a></li>
            <?php } ?>
            <?php if($CI->permissions('sms_template_view')) { ?>
            <li class="sms-templates-list-active-li sms-template-active-li"><a href="<?php echo $base_url; ?>templates/sms"><i class="fa fa-list "></i> <span><?= $this->lang->line('sms_templates'); ?></span></a></li>
            <?php } ?>
            <?php if($CI->permissions('sms_api_view')) { ?>
            <li class="sms-api-active-li"><a href="<?php echo $base_url; ?>sms/api"><i class="fa fa-cube "></i> <span><?= $this->lang->line('sms_api'); ?></span></a></li>
            <?php } ?>
          </ul>
        </li>
    <?php }} ?>
    
    
    
    <?php if($CI->permissions('send_email') || $CI->permissions('email_api')) : ?>
        <li class="email-active-li email-api-active-li treeview">
          <a href="#">
            <i class="fa fa-envelope text-aqua"></i> <span>Email VNAC <?= $this->session->userdata('inv_userid'); ?></span>
            <span class="pull-right-container">
              <i class="fa fa-angle-left pull-right"></i>
            </span>
          </a>
          <ul class="treeview-menu">
            <?php if($CI->permissions('send_email')) { ?>
            <li class="email-active-li"><a href="<?php echo $base_url; ?>email"><i class="fa fa-envelope-o "></i> <span>Gửi Email</span></a></li>
            <?php } ?>
          </ul>
        </li>
    <?php endif; ?>
    
    
    
		<!--<li class="header">SETTINGS</li>-->
    <?php if($change_password=true && $CI->permissions('dashboard')) { ?>
		<li class=" company-profile-active-li site-settings-active-li  change-pass-active-li dbbackup-active-li warehouse-active-li warehouse-list-active-li tax-active-li currency-view-active-li currency-active-li  database_updater-active-li tax-list-active-li units-list-active-li unit-active-li payment_types_list-active-li payment_types-active-li einvoice-config-active-li einvoice-template-active-li einvoice-payment-active-li treeview">
          <a href="#">
            <i class="fa fa-gears text-aqua"></i> <span>Cài đặt chung</span>
            <span class="pull-right-container">
              <i class="fa fa-angle-left pull-right"></i>
            </span>
          </a>
          <ul class="treeview-menu">
            <?php if($CI->permissions('company_edit')) { ?>
            <li class="company-profile-active-li"><a href="<?php echo $base_url; ?>company"><i class="fa fa-suitcase "></i> <span>Doanh nghiệp</span></a></li>
            <?php } ?>
            <?php if($CI->permissions('site_edit')) { ?>
            <li class="site-settings-active-li"><a href="<?php echo $base_url; ?>site"><i class="fa fa-shield  "></i> <span>Cài đặt POS</span></a></li>
            <?php } ?>

            
            <?php if($CI->permissions('tax_view') && $this->session->userdata('inv_userid') == '1') { ?>
            <li class="tax-active-li  tax-list-active-li"><a href="<?php echo $base_url; ?>tax"><i class="fa fa-percent  "></i> <span>Danh sách thuế Admin</span></a></li>
            <?php } ?>
            <?php if($CI->permissions('units_view')) { ?>
            <li class="units-list-active-li unit-active-li"><a href="<?php echo $base_url; ?>units/"><i class="fa fa-list "></i> <span>Đơn vị tính</span></a></li>
            <?php } ?>

            <?php if($CI->permissions('payment_types_view') && $this->session->userdata('inv_userid') == '1') { ?>
            <li class="payment_types_list-active-li payment_types-active-li"><a href="<?php echo $base_url; ?>payment_types/"><i class="fa fa-list "></i> <span>Kiểu thanh toán Admin</span></a></li>
            <?php } ?>

            <?php if($CI->permissions('currency_view') && $this->session->userdata('inv_userid') == '1') { ?>
            <li class="currency-view-active-li currency-active-li"><a href="<?php echo $base_url; ?>currency/view"><i class="fa fa-gg "></i> <span>Loại tiền tệ Admin</span></a></li>
            <?php } ?>
            
            <?php if($CI->permissions('site_edit')) { ?>
            <li class="einvoice-config-active-li"><a href="<?php echo $base_url; ?>sales/einvoice_config"><i class="fa fa-file-text-o "></i> <span>Cấu hình hóa đơn điện tử</span></a></li>
            <li class="einvoice-template-active-li"><a href="<?php echo $base_url; ?>sales/einvoice_template"><i class="fa fa-file-code-o "></i> <span>Cấu hình Mẫu số, Ký hiệu HDDT</span></a></li>
            <li class="einvoice-payment-active-li"><a href="<?php echo $base_url; ?>sales/einvoice_payment"><i class="fa fa-credit-card "></i> <span>Cấu hình phương thức thanh toán HDDT</span></a></li>
            <?php } ?>
            
            <!--li class="change-pass-active-li"><a href="<?php echo $base_url; ?>users/password_reset"><i class="fa fa-lock "></i> <span>Đổi mật khẩu</span></a></li-->


            <?php if($CI->permissions('database_backup')) { ?>
            <li class="dbbackup-active-li"><a href="<?php echo $base_url; ?>users/dbbackup"><i class="fa fa-database "></i> <span>Sao lưu cơ sở dữ liệu</span></a></li>
            <?php } ?>
            
		   </ul>
        </li>
        <?php } ?>
        <?php if($CI->permissions('help') && $this->session->userdata('inv_userid') == '3') { ?>
            <li><a href="<?php echo $base_url; ?>help/" target="_blank"  ><i class="fa fa-book "></i> <span><?= $this->lang->line('help'); ?></span></a></li>
            
        <?php } ?>
        <?php if($CI->permissions('profit_report')) { ?>
            <li class="report-profit-loss-active-li"><a href="<?php echo $base_url; ?>reports/profit_loss" ><i class="fa fa-files-o text-aqua"></i> <span>Báo cáo lợi nhuận</span></a></li>
        <?php } ?>
        
        <?php //if($CI->permissions('is_adminview')) { ?>
            <!--li class="web-shopping-active-li"><a target="_blank" href="<?php //echo $base_url; ?>reports/webshopping" ><i class="fa fa-shopping-cart text-aqua"></i> <span>Đặt hàng Lẻ từ Webshop <sup style="color: yellow; font-weight: bold;"><?//=count_order_web() ?></sup></span></a></li-->
        <?php //} ?>
        
        
        <?php if($CI->permissions('pos')) { ?>
            <li class="" style="background-color: green; font-weight: bold;" onclick="OpenPos('<?php echo $base_url; ?>pos');"><a ><i class="fa fa-calculator text-aqua"></i> <span>Máy POS bán hàng <?= get_rolefake($this->session->userdata('role_id')); ?></span></a></li>
        <?php } ?>
        
        <script>
            function OpenPos(url){
                window.open(url, '_unfencedTop', 'height=' + screen.height + ', width=' + screen.width + ', resizable=no, scrollbars=no, toolbar=no, menubar=no, location=no, directories=no, titlebar=no, status=no, fullscreen=yes, dialog=yes');
            }
        </script>
        <hr>
        <!-- <?php //if($CI->permissions('is_adminview')) { ?>
            <li  class="" style="background-color: #d9d8b3; font-weight: bold;"><a style="color: blue;" data-toggle="modal" data-target="#bugsModal" style=""><i class="fa fa-bug text-blue"></i> <span>Nhật ký cập nhật POS <sup style="color: RED; font-weight: bold;">NEW</sup></span></a></li>
        <?php //} ?> -->
      </ul>
    </section>
    <!-- /.sidebar -->
  </aside>
  
  <div class="modal fade" id="bugsModal" tabindex="-1" role="dialog" aria-labelledby="bugsModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Nhật ký cập nhật POS - Bản thương mại Desktop V1.0 (12M VND).</h5>
      </div>
      <div class="modal-body">
        <table class="table">
          <thead>
            <tr>
              <th scope="col">Thời gian</th>
              <th scope="col">Nội dung cập nhật</th>
              <th scope="col">Trạng thái</th>
            </tr>
          </thead>
          <tbody>
            <tr>
              <td>03/03/2025</td>
              <td>[V1.0] Chỉnh sửa tồn kho.</td>
              <td class="text-center"><i class="fa fa-check text-green" aria-hidden="true"></i></td>
            </tr>
            <tr>
              <td>13/02/2025</td>
              <td>[V1.0] Chỉnh sửa báo cáo lợi nhuận.</td>
              <td class="text-center"><i class="fa fa-check text-green" aria-hidden="true"></i></td>
            </tr>
            <tr>
              <td>26/01/2025</td>
              <td>[Phát sinh] Thêm hiển thị đơn hàng từ webshop .vn.</td>
              <td class="text-center"><i class="fa fa-check text-green" aria-hidden="true"></i></td>
            </tr>
            <tr>
              <td>15/01/2025</td>
              <td>[V1.0] Thêm thống kê tổng vốn hàng tồn kho ở danh sách tồn kho.</td>
              <td class="text-center"><i class="fa fa-check text-green" aria-hidden="true"></i></td>
            </tr>
            <tr>
              <td>14/01/2025</td>
              <td>[V1.0] Sửa lỗi thanh toán nợ ở danh sách nhập hàng.</td>
              <td class="text-center"><i class="fa fa-check text-green" aria-hidden="true"></i></td>
            </tr>
            <tr>
              <td>10/01/2025</td>
              <td>[V1.0] Thêm thanh toán nợ trong hóa đơn nhập hàng.</td>
              <td class="text-center"><i class="fa fa-check text-green" aria-hidden="true"></i></td>
            </tr>
            <tr>
              <td>10/01/2025</td>
              <td>
                  <p>[Phát sinh] Thêm tính năng và giao diện cho máy POS cảm ứng.</p>
                  <ul>
                      <li>Tính năng cơ bản <i class="fa fa-check text-green" aria-hidden="true"></i></li>
                      <li>Treo giữ đơn hàng <i class="fa fa-check text-green" aria-hidden="true"></i></li>
                      <li>In hóa đơn tạm tính <i class="fa fa-check text-green" aria-hidden="true"></i></li>
                      <li>Mật khẩu chỉnh giá tham chiếu <i class="fa fa-check text-green" aria-hidden="true"></i></li>
                  </ul>
              
              
              </td>
              <td class="text-center"><i class="fa fa-check text-green" aria-hidden="true"></i></td>
            </tr>
          </tbody>
        </table>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Đóng</button>
      </div>
    </div>
  </div>
</div>
