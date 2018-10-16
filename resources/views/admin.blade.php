<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta name="csrf-token" content="{{ csrf_token() }}">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>AdminLTE 3 | Dashboard</title>
  <!-- Tell the browser to be responsive to screen width -->
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <!-- Font Thaisarabun -->
  {{-- <link rel="stylesheet" href="/fonts/thsarabunnew.css" /> --}}
  <!-- Font Awesome -->
  <link rel="stylesheet" href="/plugins/font-awesome/css/font-awesome.min.css">
  <!-- Ionicons -->
  <link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
  <!-- Theme style -->
  <link rel="stylesheet" href="/admin/css/adminlte.min.css">
  <!-- iCheck -->
  <link rel="stylesheet" href="/plugins/iCheck/flat/blue.css">
  <!-- Morris chart -->
  <link rel="stylesheet" href="/plugins/morris/morris.css">
  <!-- jvectormap -->
  <link rel="stylesheet" href="/plugins/jvectormap/jquery-jvectormap-1.2.2.css">
  <!-- Date Picker -->

  <link rel="stylesheet" href="/plugins/iCheck/all.css">
  <link rel="stylesheet" href="/plugins/sweetalert/sweetalert2.css">
  <link rel="stylesheet" href="/plugins/sweetalert/animate.css">
  <!-- Daterange picker -->
  {{-- <link rel="stylesheet" href="/plugins/daterangepicker/daterangepicker-bs3.css"> --}}
  <!-- bootstrap wysihtml5 - text editor -->
  <link rel="stylesheet" href="/plugins/bootstrap-wysihtml5/bootstrap3-wysihtml5.min.css">
  <link rel="stylesheet" href="/admin/css/master.css">
  <link rel="stylesheet" href="/plugins/selectpicker/bootstrap-select.min.css">
  <link rel="stylesheet" href="/plugins/select2/select2.css">
  <link rel="stylesheet" href="/plugins/datatables/dataTables.bootstrap4.css">
  <link rel="stylesheet" href="https://cdn.datatables.net/buttons/1.5.2/css/buttons.dataTables.min.css">


  <!-- Google Font: Source Sans Pro -->
  <link href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700" rel="stylesheet">

  <link href="/plugins/Smartwidzard4/css/smart_wizard.css" rel="stylesheet" type="text/css" />
  <link href="/plugins/Smartwidzard4/css/smart_wizard_theme_dots.css" rel="stylesheet" type="text/css" />
  <link href="/plugins/Smartwidzard4/css/smart_wizard_theme_arrows.css" rel="stylesheet" type="text/css" />
  <style>
        img {
        border: 1px solid #ddd;
        border-radius: 4px;
        padding: 5px;
        width: 150px;
    }
    
    img:hover {
        box-shadow: 0 0 2px 1px rgba(0, 140, 186, 0.5);
    }
    
    </style>
  @yield('css')
  <?php
        function array_col(array $input, $columnKey, $indexKey = null) {
            $array = array();
            foreach ($input as $value) {
                if ( ! isset($value[$columnKey])) {
                    trigger_error("Key \"$columnKey\" does not exist in array");
                    return false;
                }
                if (is_null($indexKey)) {
                    $array[] = $value[$columnKey];
                }
                else {
                    if ( ! isset($value[$indexKey])) {
                        trigger_error("Key \"$indexKey\" does not exist in array");
                        return false;
                    }
                    if ( ! is_scalar($value[$indexKey])) {
                        trigger_error("Key \"$indexKey\" does not contain scalar value");
                        return false;
                    }
                    $array[$value[$indexKey]] = $value[$columnKey];
                }
            }
            return $array;
        }
        $n = array();
        foreach($permission->page as $page){
          array_push($n,$page);
        }
        $view = array_col($n, 'view', 'menu_id');
  ?>
</head>
<body class="hold-transition sidebar-mini">
<div class="wrapper">
  <!-- Navbar -->
  @if($permission->permission_id == 1)
    <nav class="main-header navbar navbar-expand border-bottom navbar-dark bg-primary">
  @elseif ($permission->permission_id == 2)
    <nav class="main-header navbar navbar-expand border-bottom navbar-dark bg-info">
  @elseif ($permission->permission_id == 3)
    <nav class="main-header navbar navbar-expand border-bottom navbar-light bg-brown">
  @elseif ($permission->permission_id == 4)
    <nav class="main-header navbar navbar-expand border-bottom navbar-dark bg-success">
  @elseif ($permission->permission_id == 5)
    <nav class="main-header navbar navbar-expand border-bottom navbar-light bg-warning">
  @else
    <nav class="main-header navbar navbar-expand border-bottom navbar-dark bg-danger">
  @endif
    <!-- Left navbar links -->
    <ul class="navbar-nav">
      <li class="nav-item">
        <a class="nav-link" data-widget="pushmenu" href="#"><i class="fa fa-bars"></i></a>
      </li>
      <li class="nav-item d-none d-sm-inline-block">
        <a href="index3.html" class="nav-link">Home</a>
      </li>
      <li class="nav-item d-none d-sm-inline-block">
        <a href="#" class="nav-link">Contact</a>
      </li>
    </ul>

    <!-- SEARCH FORM -->
    <form class="form-inline ml-3">
      <div class="input-group input-group-sm">
        <input class="form-control form-control-navbar" type="search" placeholder="Search" aria-label="Search">
        <div class="input-group-append">
          <button class="btn btn-navbar" type="submit">
            <i class="fa fa-search"></i>
          </button>
        </div>
      </div>
    </form>

    <!-- Right navbar links -->
    <ul class="navbar-nav ml-auto">
      <!-- Messages Dropdown Menu -->
      <!-- Notifications Dropdown Menu -->
      {{-- <li class="nav-item dropdown">
        <a class="nav-link" data-toggle="dropdown" href="#">
          <i class="fa fa-bell-o"></i>
          <span class="badge badge-warning navbar-badge">15</span>
        </a>
        <div class="dropdown-menu dropdown-menu-lg dropdown-menu-right">
          <span class="dropdown-item dropdown-header">15 Notifications</span>
          <div class="dropdown-divider"></div>
          <a href="#" class="dropdown-item">
            <i class="fa fa-envelope mr-2"></i> 4 new messages
            <span class="float-right text-muted text-sm">3 mins</span>
          </a>
          <div class="dropdown-divider"></div>
          <a href="#" class="dropdown-item">
            <i class="fa fa-users mr-2"></i> 8 friend requests
            <span class="float-right text-muted text-sm">12 hours</span>
          </a>
          <div class="dropdown-divider"></div>
          <a href="#" class="dropdown-item">
            <i class="fa fa-file mr-2"></i> 3 new reports
            <span class="float-right text-muted text-sm">2 days</span>
          </a>
          <div class="dropdown-divider"></div>
          <a href="#" class="dropdown-item dropdown-footer">See All Notifications</a>
        </div>
      </li> --}}
      <li class="nav-item">
        <a class="nav-link" href="/logout">
        <i class="fa fa-unlock-alt"></i></a>
      </li>
    </ul>
  </nav>
  <!-- /.navbar -->

  <!-- Main Sidebar Container -->
  <aside class="main-sidebar elevation-4 sidebar-light-warning">
    <!-- Brand Logo -->
    @if($permission->permission_id == 1)
      <a href="/apanel" class="brand-link bg-primary">
    @elseif ($permission->permission_id == 2)
      <a href="/apanel" class="brand-link bg-info">
    @elseif ($permission->permission_id == 3)
      <a href="/apanel" class="brand-link bg-brown">
    @elseif ($permission->permission_id == 4)
      <a href="/apanel" class="brand-link bg-success">
    @elseif ($permission->permission_id == 5)
      <a href="/apanel" class="brand-link bg-warning">
    @else
      <a href="/apanel" class="brand-link bg-danger">
    @endif
    {{-- <a href="/apanel" class="brand-link bg-brown"> --}}
      <img src="/admin/img/AdminLTELogo.png" alt="AdminLTE Logo" class="brand-image img-circle elevation-3"
           style="opacity: .8">
      <span class="brand-text font-weight-light">Langmai Pinit</span>
    </a>

    <!-- Sidebar -->
    <div class="sidebar">
      <!-- Sidebar user panel (optional) -->
      <div class="user-panel mt-3 pb-3 mb-3 d-flex">
        <div class="image">
          <img src="/admin/img/user2-160x160.jpg" class="img-circle elevation-2" alt="User Image">
        </div>
        <div class="info">
          <a href="#" class="d-block">{{ $user->nickname }}</a>
        </div>
      </div>

      <!-- Sidebar Menu -->
      <nav class="mt-2">
        <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
        <li class="nav-header">Menu</li>
        <?php $menu_type = 'menu';?>
          @foreach($items as $item)
            @if($menu_type != $item->menu_type)
              <li class="nav-header">{{$item->menu_type}}</li>
              <?php $menu_type = $item->menu_type;?>
            @endif
            @if( (isset($view[$item->menu_id]) && $view[$item->menu_id] == '1' ) || $user->id == 1 )
              <li id="{{ $item->menu_name }}" class="nav-item has-treeview">
                <a href="{{ $item->menu_link }}" class="nav-link">
                  <i class="nav-icon fa {{ $item->menu_icon }}"></i>
                  <p>
                    {{ $item->menu_name }}
                    @if(count($item['children']) > 0)
                      <i class="right fa fa-angle-left"></i>
                    @endif
                  </p>
                </a>
                @if(count($item['children']) > 0)
                  <ul class="nav nav-treeview" id="{{ $item->menu_id }}-child">
                  @foreach($item['children'] as $child)
                    @if( (isset($view[$child->menu_id]) && $view[$child->menu_id] == '1') || $user->id == 1 )
                      <li id="{{ $child->menu_name }}" class="nav-item">
                        <a href="{{ $child->menu_link }}" class="nav-link">
                          <i class="fa {{ $item->menu_icon }} nav-icon"></i>
                            {{ $child->menu_name }}
                        </a>
                      </li>
                    @endif
                  @endforeach
                  </ul>
              </li>
            @else
              </li>
              
            @endif
            @endif
          @endforeach
          <li id="ช่วยเหลือ" class="nav-item has-treeview">
              <a href="javascript:;" class="nav-link" onclick="$('#helpmodal').modal('show')">
                <i class="nav-icon fa fa-question-circle"></i>
                <p>
                  ช่วยเหลือ
                </p>
              </a>
          </li>
          </ul>

      </nav>
      <!-- /.sidebar-menu -->
    </div>
    <!-- /.sidebar -->
  </aside>

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0 text-dark"></h1>
          </div><!-- /.col -->
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="#">Home</a></li>
              <li class="breadcrumb-item active">Dashboard v2</li>
            </ol>
          </div><!-- /.col -->
        </div><!-- /.row -->
      </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->

    <!-- Main content -->
    <section class="content">
     @yield('content')
     <div class="modal fade bd-example-modal-lg" id="helpmodal" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
          <div class="modal-content">
            <div class="modal-header">
              <h5 class="modal-title" id="exampleModalLabel">เริ่มต้นการใช้งาน</h5>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>
            <div class="modal-body">
                <div class="container">
                    <div id="smartwizard">
                        <ul>
                            <li><a href="#step-1">ขั้นตอนที่ 1<br /><small>สร้างคำขอใบเสนอราคา</small></a></li>
                            <li><a href="#step-2">ขั้นตอนที่ 2<br /><small>รอการตอบรับคำขอ และตกลงราคา</small></a></li>
                            <li><a href="#step-3">ขั้นตอนที่ 3<br /><small>เลือกสั่งซื้อสินค้าและบริการที่ต้องการ</small></a></li>
                            <li><a href="#step-4">ขั้นตอนที่ 4<br /><small>ยืนยันการชำระเงิน</small></a></li>
                        </ul>
            
                        <div>
                            <div id="step-1" class="">
                                <h3 class="border-bottom border-gray pb-2">สร้างคำขอเสนอราคา</h3>
                                วิธีสร้างคำขอใบเสนอราคานั้น เริ่มต้นจากการไปที่เมนู "ใบเสนอราคา" -> "ร้องขอใบเสนอราคา" ลูกค้าจะสามารถดูข้อมูลคำขอใบเสนอราคาได้หากเคยยื่นคำขอใบเสนอราคาไปแล้ว  หากยังไม่มีข้อมูลใบเสนอราคา ให้ทำการคลิกที่ปุ่ม "เพิ่มคำขอใบเสนอราคา" จากนั้น กรอกรายละเอียดให้ครบถ้วน  หากท่านไม่ทราบประเภทสินค้าที่ต้องการ กรุณาเลือก อื่นๆ จากนั้นรอการตอบรับจากพนักงาน
                            </div>
                            <div id="step-2" class="">
                                <h3 class="border-bottom border-gray pb-2">รอการตอบรับคำขอและตกลงราคา</h3>
                                <div>
                                    <center>
                                    <a href="/help/requo1.JPG" target="_blank">
                                        <img src="/help/requo1.JPG">
                                    </a>
                                    <a href="/help/requo2.JPG" target="_blank">
                                        <img src="/help/requo2.JPG">
                                    </a>
                                    <a href="/help/requo3.JPG" target="_blank">
                                        <img src="/help/requo3.JPG">
                                    </a>
                                    </center>
                                    <p>หากได้รับการตอบรับแล้วจะสามารถเรียกดูข้อมูลการเสนอราคาของคำร้องขอใบเสนอราคาได้ เมื่อคุณตกลงราคาสินค้าที่ได้มา กรุณาคลิกที่เครื่องหมาย <i class="fa fa-check"></i> สินค้าจะถูกเพิ่มไปยัง "สินค้าของฉัน" ทันที จากนั้นคุณจะสามารถสั่งซื้อสินค้าได้ตามความต้องการของคุณ</p>
 
                                </div>
                            </div>
                            <div id="step-3" class="">
                                <h3 class="border-bottom border-gray pb-2">เลือกสั่งซื้อสินค้าและบริการที่ต้องการ</h3>
                                <center>
                                    <a href="/help/step3-01.PNG" target="_blank">
                                        <img src="/help/step3-01.PNG">
                                    </a>
                                    <a href="/help/step3-02.PNG" target="_blank">
                                        <img src="/help/step3-02.PNG">
                                    </a>
                                    <a href="/help/step3-03.PNG" target="_blank">
                                        <img src="/help/step3-03.PNG">
                                    </a>
                                    <a href="/help/step3-04.PNG" target="_blank">
                                        <img src="/help/step3-04.PNG">
                                    </a>
                                 </center>
                                 <p>เมื่อสามารถตกลงราคาสินค้าที่คุณต้องการได้แล้ว สามารถเลือกเมนู การสั่งซื้อ -> เพิ่มการสั่งซื้อ เพื่อทำการสั่งซื้อสินค้า พร้อมระบุวันที่ต้องการให้จัดส่งสินค้า จากนั้นรอรับการตอบรับจากพนักงาน เมื่อมีการตอบรับแล้วสามารถดูรายละเอียดการตอบรับและติดตามสถานะของการสั่งซื้อนั้น ๆ ได้</p>
                            </div>
                            <div id="step-4" class="">
                                <h3 class="border-bottom border-gray pb-2">ยืนยันการชำระเงิน</h3>
                                <center>
                                    <a href="/help/step4-01.PNG" target="_blank">
                                        <img src="/help/step4-01.PNG">
                                    </a>
                                    <a href="/help/step4-02.PNG" target="_blank">
                                        <img src="/help/step4-02.PNG">
                                    </a>
                                    <a href="/help/step4-03.PNG" target="_blank">
                                        <img src="/help/step4-03.PNG">
                                    </a>
                                    <a href="/help/step4-04.PNG" target="_blank">
                                        <img src="/help/step4-04.PNG">
                                    </a>
                                    </center>
                                    <p>หลังจากเกิดการสั่งซื้อสินค้า เมื่อถึงครบกำหนดวันตัดรอบของบริษัท บริษัทจะทำการออกใบวางบิลเพื่อแจ้งการชำระให้กับลูกค้า โดยสามารถดูรายละเอียดของใบวางบิลได้จากเมนู ใบวางบิล -> ใบวางบิลของฉัน -> รายละเอียด โดยกำหนดการชำระเงินจะขึ้นอยู่กับเครดิตที่ลูกค้าได้รับ จากนั้นลูกค้าสามารถแจ้งการชำระเงินได้โดยสามารถเลือกอัพโหลดสลิป หรือ กรอกข้อมูลจากหน้าฟอร์มได้</p>
                            </div>
                        </div>
                    </div>
            
            
                </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            </div>
        </div>
        </div>
      </div>
    </section>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->
  <footer class="main-footer">
    <strong>Copyright &copy; 2014-2018 <a href="http://adminlte.io">AdminLTE.io</a>.</strong>
    All rights reserved.
    <div class="float-right d-none d-sm-inline-block">
      <b>Version</b> 3.0.0-alpha
    </div>
  </footer>

  <!-- Control Sidebar -->
  <!-- /.control-sidebar -->
</div>
<!-- ./wrapper -->

<!-- jQuery -->
<script src="/plugins/jquery/jquery.min.js"></script>
<script src="//cdnjs.cloudflare.com/ajax/libs/numeral.js/2.0.6/numeral.min.js"></script>
<!-- jQuery UI 1.11.4 -->
<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.min.js"></script>
<!-- Resolve conflict in jQuery UI tooltip with Bootstrap tooltip -->
<script>
  $.ajaxSetup({
    headers: {
      'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    }
  });
  $.widget.bridge('uibutton', $.ui.button)
</script>
<!-- Bootstrap 4 -->
<script src="/plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
<script src="/plugins/sweetalert/sweetalert2.js"></script>
<!-- Morris.js charts -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/raphael/2.1.0/raphael-min.js"></script>
<script src="/plugins/morris/morris.min.js"></script>
<script src="/plugins/datatables/jquery.dataTables.js"></script>
<script src="/plugins/datatables/dataTables.bootstrap4.js"></script>
<script src="https://cdn.datatables.net/buttons/1.5.2/js/dataTables.buttons.min.js"></script>
<script src="https://cdn.datatables.net/buttons/1.5.2/js/buttons.print.min.js"></script>


{{-- select 2 --}}
<script src="/plugins/select2/select2.full.min.js"></script>
<script src="/plugins/selectpicker/bootstrap-select.min.js"></script>
<!-- Sparkline -->
<script src="/plugins/sparkline/jquery.sparkline.min.js"></script>
<!-- jvectormap -->
<script src="/plugins/jvectormap/jquery-jvectormap-1.2.2.min.js"></script>
<script src="/plugins/jvectormap/jquery-jvectormap-world-mill-en.js"></script>
<!-- jQuery Knob Chart -->
<script src="/plugins/knob/jquery.knob.js"></script>
<!-- daterangepicker -->
{{-- <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.10.2/moment.min.js"></script> --}}
<script src="/plugins/moment/moment.min.js"></script>
{{-- <script src="/plugins/daterangepicker/daterangepicker.js"></script> --}}
<!-- datepicker -->
<script src="/plugins/datepicker/bootstrap-datepicker.js"></script>
{{-- <script src="/plugins/datetimepicker/js/bootstrap-datetimepicker.js"></script> --}}
<!-- Bootstrap WYSIHTML5 -->
<script src="/plugins/bootstrap-wysihtml5/bootstrap3-wysihtml5.all.min.js"></script>
<!-- Slimscroll -->
<script src="/plugins/slimScroll/jquery.slimscroll.min.js"></script>
<!-- FastClick -->
<script src="/plugins/fastclick/fastclick.js"></script>
<!-- AdminLTE App -->
<script src="/admin/js/adminlte.js"></script>
<script src="/plugins/input-mask/jquery.inputmask.js"></script>
<script src="/plugins/iCheck/icheck.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/lodash@4.17.10/lodash.min.js"></script>
<script src="/js/accounting.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/vue@2.5.17/dist/vue.js"></script>
<!-- AdminLTE dashboard demo (This is only for demo purposes) -->
<!-- <script src="/admin/js/pages/dashboard.js"></script> -->
<!-- AdminLTE for demo purposes -->
<script src="/admin/js/demo.js"></script>
<script src="/plugins/Smartwidzard4/js/jquery.smartWizard.js"></script>

<script type="text/javascript">
    $(document).ready(function () {
        $("#smartwizard").on("showStep", function(e, anchorObject, stepNumber, stepDirection, stepPosition) {
                if(stepPosition === 'first'){
                    $("#prev-btn").addClass('disabled');
                }else if(stepPosition === 'final'){
                    $("#next-btn").addClass('disabled');
                }else{
                    $("#prev-btn").removeClass('disabled');
                    $("#next-btn").removeClass('disabled');
                }
            });
            $('#smartwizard').smartWizard({
                    selected: 0,
                    theme: 'dots',
                    transitionEffect:'fade',
                    showStepURLhash: true,
                    toolbarSettings: {
                    toolbarButtonPosition: 'end',
                    }
            });
            $("#reset-btn").on("click", function() {
                $('#smartwizard').smartWizard("reset");
                return true;
            });

            $("#prev-btn").on("click", function() {
                $('#smartwizard').smartWizard("prev");
                return true;
            });

            $("#next-btn").on("click", function() {
                $('#smartwizard').smartWizard("next");
                return true;
            });

            $("#theme_selector").on("change", function() {
                $('#smartwizard').smartWizard("theme", $(this).val());
                return true;
            });
            $("#theme_selector").change();
    });
</script>
@yield('script')
</body>
</html>
