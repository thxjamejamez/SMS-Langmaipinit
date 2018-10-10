@extends('admin')
@section('css')
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
@stop
@section('content')

<div class="modal fade bd-example-modal-lg" @if(!$chk && $chkpm->permission_id == 6) id="exampleModal" @endif tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
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
                                
                            </div>
                            <div id="step-4" class="">
                                <h3 class="border-bottom border-gray pb-2">Step 4 Content</h3>
                                <div class="card">
                                    <div class="card-header">My Details</div>
                                    <div class="card-block p-0">
                                      <table class="table">
                                          <tbody>
                                              <tr> <th>Name:</th> <td>Tim Smith</td> </tr>
                                              <tr> <th>Email:</th> <td>example@example.com</td> </tr>
                                          </tbody>
                                      </table>
                                    </div>
                                </div>
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
@stop

@section('script')
<script src="/plugins/Smartwidzard4/js/jquery.smartWizard.js"></script>

<script type="text/javascript">
    $(document).ready(function () {
        $('#exampleModal').modal('show');
        $("#smartwizard").on("showStep", function(e, anchorObject, stepNumber, stepDirection, stepPosition) {
               //alert("You are on step "+stepNumber+" now");
               if(stepPosition === 'first'){
                   $("#prev-btn").addClass('disabled');
               }else if(stepPosition === 'final'){
                   $("#next-btn").addClass('disabled');
               }else{
                   $("#prev-btn").removeClass('disabled');
                   $("#next-btn").removeClass('disabled');
               }
            });
            // var btnFinish = $('<button></button>').text('Finish')
            //                                  .addClass('btn btn-info')
            //                                  .on('click', function(){ alert('Finish Clicked'); });
            // var btnCancel = $('<button></button>').text('Cancel')
            //                                  .addClass('btn btn-danger')
            //                                  .on('click', function(){ $('#smartwizard').smartWizard("reset"); });
            $('#smartwizard').smartWizard({
                    selected: 0,
                    theme: 'dots',
                    transitionEffect:'fade',
                    showStepURLhash: true,
                    toolbarSettings: {
                                      toolbarButtonPosition: 'end',
                                    //   toolbarExtraButtons: [btnFinish, btnCancel]
                                    }
            });
            $("#reset-btn").on("click", function() {
                // Reset wizard
                $('#smartwizard').smartWizard("reset");
                return true;
            });

            $("#prev-btn").on("click", function() {
                // Navigate previous
                $('#smartwizard').smartWizard("prev");
                return true;
            });

            $("#next-btn").on("click", function() {
                // Navigate next
                $('#smartwizard').smartWizard("next");
                return true;
            });

            $("#theme_selector").on("change", function() {
                // Change theme
                $('#smartwizard').smartWizard("theme", $(this).val());
                return true;
            });

            // Set selected theme on page refresh
            $("#theme_selector").change();
    });

    
</script>
@stop