<!DOCTYPE html>
<html>
<head>
<!-- TABLES CSS CODE -->
<?php include"comman/code_css_form.php"; ?>
<?php include"comman/code_css_datatable.php"; ?>
<?php include"comman/code_js_datatable.php"; ?>
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
        <?=$page_title;?>
        <small></small>
      </h1>
      <ol class="breadcrumb">
        <li><a href="<?php echo $base_url; ?>dashboard"><i class="fa fa-dashboard"></i> Trang chủ</a></li>
        <li class="active"><?=$page_title;?></li>
      </ol>
    </section>

    <!-- /.content -->
    <section class="content">
      <div class="row">
                    <div class="col-md-12">
                     <div class="box box-info ">
                        <form class="form-horizontal" id="report-form" onkeypress="return event.keyCode != 13;">
                           <input type="hidden" name="<?php echo $this->security->get_csrf_token_name();?>" value="<?php echo $this->security->get_csrf_hash();?>">

                           <input type="hidden" id="base_url" value="<?php echo $base_url;; ?>">

                           <div class="box-body">
                              <div class="form-group">
                                 <label for="brand_id" class="col-sm-2 control-label">Thương hiệu</label>
                                 <div class="col-sm-3">
                                    <select class="form-control select2 " id="brand_id" name="brand_id"  style="width: 100%;">
                                       <option value="">-- Tất cả thương hiệu --</option>
                                       <?php
                                          $q1=$this->db->query("select * from db_brands where status=1");
                                          if($q1->num_rows()>0)
                                                 {
                                                     foreach($q1->result() as $res1)
                                             {
                                               echo "<option value='".$res1->id."'>".$res1->brand_name."</option>";
                                             }
                                           }
                                           else
                                           {
                                              ?>
                                       <option value="">Không có dữ liệu</option>
                                       <?php
                                          }
                                          ?>
                                    </select>
                                    <span id="brand_id_msg" style="display:none" class="text-danger"></span>
                                 </div>

                                 <label for="category_id" class="col-sm-2 control-label">Danh mục</label>
                                 <div class="col-sm-3">
                                    <select class="form-control select2 " id="category_id" name="category_id"  style="width: 100%;">
                                       <option value="">-- Tất cả danh mục --</option>
                                       <?php
                                          $q1=$this->db->query("select * from db_category where status=1");
                                          if($q1->num_rows()>0)
                                                 {
                                                     foreach($q1->result() as $res1)
                                             {
                                               echo "<option value='".$res1->id."'>".$res1->category_name."</option>";
                                             }
                                           }
                                           else
                                           {
                                              ?>
                                       <option value="">Không có dữ liệu</option>
                                       <?php
                                          }
                                          ?>
                                    </select>
                                    <span id="category_id_msg" style="display:none" class="text-danger"></span>
                                 </div>
                                 
                              </div>

                              

                           </div>
                           <div class="box-footer">
                              <div class="col-sm-8 col-sm-offset-2 text-center">
                                 <div class="col-md-3 col-md-offset-3">
                                    <button type="button" id="view" class=" btn btn-block btn-success" title="Save Data">Tra cứu</button>
                                 </div>
                                 <div class="col-sm-3">
                                    <a href="<?=base_url('dashboard');?>">
                                    <button type="button" class="col-sm-3 btn btn-block btn-warning close_btn" title="Go Dashboard">Đóng</button>
                                    </a>
                                 </div>
                              </div>
                           </div>
                        </form>
                     </div>
                  </div>
                    <div class="col-md-12">
                            
                     <!-- Custom Tabs -->
                     <div class="nav-tabs-custom">
                        <?php $tot_von = $this->db->query("select sum(stock * purchase_price) as totalvon from db_items where stock > 0 and id > 0")->row()->totalvon; ?>
                        <ul class="nav nav-tabs">
                           <li class="active"><a href="#tab_1" data-toggle="tab">Tổng vốn hàng tồn kho: <span style="font-weight: bold; color: blue;"><?= number_format($tot_von) ?></span></a></li>
                           <!--li><a href="#tab_2" data-toggle="tab">Thương hiệu</a></li>
                           <li><a href="#tab_3" data-toggle="tab">Danh mục</a></li-->
                        </ul>
                        <div class="tab-content">
                           <div class="tab-pane active" id="tab_1">
                               <!--div class="row">
                                    <div class="col-md-2">
                                        <div class="form-group">
                                            <label for="item_id" class=" control-label text-right">Tìm theo tên sản phẩm</label>
                                        </div>
                                    </div>
                                    <div class="col-md-10">
                                        <div class="form-group">
                                            <select class="form-control select2 " id="item_id" name="item_id"  style="width: 100%;"></select>
                                            <span id="item_id_msg" style="display:none" class="text-danger"></span>
                                        </div>
                                    </div>
                                </div-->
                              <div class="row">
                                
                                 <!-- right column -->
                                 <div class="col-md-12">
                                    <!-- form start -->
                                       <input type="hidden" id="base_url" value="<?php echo $base_url; ?>">
                                            <div class="table-responsive">
                                                <table class="table table-bordered table-hover " id="report-data" >
                                                    <thead>
                                                        <tr class="bg-blue">
                                                          <th style="">#</th>
                                                          <!--th style="">Mã sản phẩm</th-->
                                                          <th style="">Tên sản phẩm</th>
                                                          <th style="">Tồn kho</th>
                                                          
                                                          <th style="">Có thể bán</th>
                                                          <th style="">Vốn tồn kho</th>
                                                          <!--th style="">Thương hiệu</th-->
                                                          <!--th style="">Danh mục</th-->
                                                          <th style="">Giá nhập</th>
                                                          <!--th style=""><?= $this->lang->line('tax'); ?></th-->
                                                          <th style="">Giá bán lẻ</th>
                                                          <th style="">Giá ĐL C0</th>
                                                          <th style="">Giá ĐL C1</th>
                                                          <th style="">Giá ĐL C2</th>
                                                          <th style="">Giá ĐL C3</th>
                                                          <th>Hệ thống</th>
                                                          <!--th style=""><?= $this->lang->line('stock_value'); ?></th-->
                                                        </tr>
                                                    </thead>
                                                    <tbody id="tbodyid"></tbody>
                                                </table>
                                            </div>
                                       <!-- /.box-body -->
                                 </div>
                                 <!--/.col (right) -->
                              </div>
                              <!-- /.row -->
                           </div>
                           <!-- /.tab-pane -->
                          <script>
                              $(document).ready( function () {
                                  load_reports();
                                });
                            </script>
                           

                           
                      
                        </div>
                        <!-- /.tab-content -->
                     </div>
                     <!-- nav-tabs-custom -->
                  </div>
                  <!-- /.col -->
     
      
      </div>
    </section>
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
<!-- TABLE EXPORT CODE -->
<?php include"comman/code_js_export.php"; ?>


<script src="<?php echo $theme_link; ?>js/ajaxselect/item_select_ajax.js?v=<?php echo time(); ?>"></script>  
<script>
   //Item Selection Box Search
   function getItemSelectionId() {
     return '#item_id';
   }
   //Item Selection Box Search - END


   $("#item_id").on("change", function(){
         load_reports();
   });
</script>

<script type="text/javascript">

  function load_reports(){
    //$('#report-data').DataTable({lengthMenu: [100, 200, 500],});
    var brand_id=document.getElementById("brand_id").value.trim();
    var category_id=document.getElementById("category_id").value.trim();


   $(".box").append('<div class="overlay"><i class="fa fa-refresh fa-spin"></i></div>');

        $.post("get_stock_report",{brand_id:brand_id,category_id:category_id,item_id:$("#item_id").val()},function(result){
            result = $.parseJSON(result);

              $.each( result, function( key, val ) {
                if(key=='item_wise_report'){
                    $('#report-data').DataTable().clear().destroy();
                    $("#tbodyid").empty().append(val);
                    
                    $('#report-data').DataTable({"pageLength": 100});
                }
                /*if(key=='brand_wise_stock'){
                    $("#brand_wise_stock tbody").empty().append(val);     
                }
                if(key=='category_wise_stock'){
                    $("#category_wise_stock tbody").empty().append(val);     
                }*/

              });
              $(".overlay").remove();
           });

    }//function end
</script>
<script>
    $("#view,#view_all").on("click",function(){
        load_reports();
    });
</script>


<!-- Make sidebar menu hughlighter/selector -->
<script>$(".<?php echo basename(__FILE__,'.php');?>-active-li").addClass("active");</script>
    
    
</body>
</html>
