<footer class="main-footer">
    <div class="pull-right hidden-xs">
      <b>Copyright &copy; <?=date("Y")?> All rights reserved. </b> 
      
      <!--div id="MyClockDisplay" class="clock" onload="showTime()"></div-->
    </div>
    <strong>D4Teams - <?php echo $SITE_TITLE;?> - v1.0.0<?//= $VERSION;?> - <span id="MyClockDisplay" class="" onload="showTime()"></span> - Hạn sử dụng đến <span style="color: red;"><?php echo(date("d-m-Y H:i:s",$this->session->userdata('validate'))); ?></span></strong>
  </footer>

  <!-- Control Sidebar -->
  <aside class="control-sidebar control-sidebar-dark">
    <!-- Create the tabs -->
    <ul class="nav nav-tabs nav-justified control-sidebar-tabs">
      <li>
      </li>
    </ul>
    <!-- Tab panes -->
    <div class="tab-content">
      <div class="tab-pane" id="control-sidebar-home-tab">
        
      </div>
      <!-- /.tab-pane -->
    </div>
  </aside>
  
  <style>
      .clock {
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translateX(-50%) translateY(-50%);
            color: #17D4FE;
            font-size: 60px;
            font-family: Orbitron;
            letter-spacing: 7px;
        }
  </style>

<script>
    function showTime(){
        var date = new Date();
        var h = date.getHours(); // 0 - 23
        var m = date.getMinutes(); // 0 - 59
        var s = date.getSeconds(); // 0 - 59
        var session = "AM";
        
        if(h == 0){
            h = 12;
        }
        
        if(h > 12){
            h = h - 12;
            session = "PM";
        }
        
        h = (h < 10) ? "0" + h : h;
        m = (m < 10) ? "0" + m : m;
        s = (s < 10) ? "0" + s : s;
        
        var time = h + ":" + m + ":" + s + " " + session;
        document.getElementById("MyClockDisplay").innerText = time;
        document.getElementById("MyClockDisplay").textContent = time;
        
        setTimeout(showTime, 1000);
        
    }
    
    showTime();
</script>
