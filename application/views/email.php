<!DOCTYPE html>
<html>
<head>
<!-- FORM CSS CODE -->
<?php include"comman/code_css_form.php"; ?>
<!-- </copy> -->  
</head>
<body class="hold-transition skin-blue sidebar-mini">
<div class="wrapper">

 <?php include"sidebar.php"; ?>


  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
       Gửi Email
      </h1>
      <ol class="breadcrumb">
        <li><a href="<?php echo $base_url; ?>dashboard"><i class="fa fa-dashboard"></i> Home</a></li>
        <li class="active">Gửi Email</li>
      </ol>
    </section>

    <!-- Main content -->
    <section class="content">
      <div class="row">
        <!-- right column -->
        <div class="col-md-12">
          <!-- Horizontal Form -->
          <div class="col-md-12">
         <div class="box box-primary">
           
            <!-- /.box-header -->
            <!-- form start -->
            <form role="form" id="email-form" onkeypress="return event.keyCode != 13;">
              <input type="hidden" name="<?php echo $this->security->get_csrf_token_name();?>" value="<?php echo $this->security->get_csrf_hash();?>">
              <input type="hidden" id="base_url" value="<?php echo $base_url;; ?>">
              <div class="box-body">
                <div class="form-group">
                  <label for="mobile">Địa chỉ Email <span class="text-danger">*</span></label>
                  <input type="text" class="form-control" id="mobile" name="mobile" placeholder="">
                  <span id="mobile_msg" style="display:none" class="text-danger"></span>
                </div>
                <div class="form-group">
                  <label for="message">Tiêu đề Email <span class="text-danger">*</span></label>
                  <input type="text" class="form-control" id="subject" name="subject" placeholder="">
                  <span id="subject_msg" style="display:none" class="text-danger"></span>
                </div>
                <div class="form-group">
                  <label for="message">Nội dung Email <span class="text-danger">*</span></label>
                  <textarea type="text" class="form-control" id="message" name="message" placeholder="" row="10"></textarea>
                  <span id="message_msg" style="display:none" class="text-danger"></span>
                </div>
              
              </div>
              <!-- /.box-body -->

              <div class="box-footer"> <!--button type="button" class="btn bg-orange" title="Back to List" onclick="history.back();">Quay lại</button-->
            
              <button type="button" id="sendemail" class="btn btn-success" title="Send Email">Xác nhận gửi</button>
            
            <a href='<?php echo $base_url; ?>dashboard'><button type="button" class="btn btn-danger" title="Go Dashboard">Đóng</button></a>
              </div>
            </form>
          </div>
          <!-- /.box -->
        </div>
     

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

<script src="<?php echo $theme_link; ?>js/email.js?v=<?php echo time(); ?>"></script>
<!-- Make sidebar menu hughlighter/selector -->
<script>$(".<?php echo basename(__FILE__,'.php');?>-active-li").addClass("active");</script>

</body>
</html>
