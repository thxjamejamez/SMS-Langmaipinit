@extends('admin')
@section('css')
  <link href="/plugins/Smartwidzard4/css/smart_wizard.css" rel="stylesheet" type="text/css" />
  <link href="/plugins/Smartwidzard4/css/smart_wizard_theme_dots.css" rel="stylesheet" type="text/css" />
  <link href="/plugins/Smartwidzard4/css/smart_wizard_theme_arrows.css" rel="stylesheet" type="text/css" />
@stop
@section('content')

<div class="modal fade bd-example-modal-lg" @if(!$chk) id="exampleModal" @endif tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
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
                                Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum.
                            </div>
                            <div id="step-2" class="">
                                <h3 class="border-bottom border-gray pb-2">Step 2 Content</h3>
                                <div>Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum. </div>
                            </div>
                            <div id="step-3" class="">
                                Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum.
                                Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum.
                                Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum.
                                Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum.
                                Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum.
                                Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum.
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
              {{-- <div class="container">
                <div class="row form-group">
                      <div class="col-xs-12">
                          <ul class="nav nav-pills nav-justified thumbnail setup-panel">
                              <li class="active"><a href="#step-1">
                                  <h4 class="list-group-item-heading">Step 1</h4>
                                  <p class="list-group-item-text">First step description</p>
                              </a></li>
                              <li class="disabled"><a href="#step-2">
                                  <h4 class="list-group-item-heading">Step 2</h4>
                                  <p class="list-group-item-text">Second step description</p>
                              </a></li>
                              <li class="disabled"><a href="#step-3">
                                  <h4 class="list-group-item-heading">Step 3</h4>
                                  <p class="list-group-item-text">Third step description</p>
                              </a></li>
                          </ul>
                      </div>
                </div>
                  <div class="row setup-content" id="step-1">
                      <div class="col-xs-12">
                          <div class="col-md-12 well text-center">
                              <h1> STEP 1</h1>
                              <button id="activate-step-2" class="btn btn-primary btn-lg">Activate Step 2</button>
                          </div>
                      </div>
                  </div>
                  <div class="row setup-content" id="step-2">
                      <div class="col-xs-12">
                          <div class="col-md-12 well">
                              <h1 class="text-center"> STEP 2</h1>
                          </div>
                      </div>
                  </div>
                  <div class="row setup-content" id="step-3">
                      <div class="col-xs-12">
                          <div class="col-md-12 well">
                              <h1 class="text-center"> STEP 3</h1>
                          </div>
                      </div>
                  </div>
              </div>
            </div> --}}
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
            var btnFinish = $('<button></button>').text('Finish')
                                             .addClass('btn btn-info')
                                             .on('click', function(){ alert('Finish Clicked'); });
            var btnCancel = $('<button></button>').text('Cancel')
                                             .addClass('btn btn-danger')
                                             .on('click', function(){ $('#smartwizard').smartWizard("reset"); });
                                             $('#smartwizard').smartWizard({
                    selected: 0,
                    theme: 'dots',
                    transitionEffect:'fade',
                    showStepURLhash: true,
                    toolbarSettings: {
                                      toolbarButtonPosition: 'end',
                                      toolbarExtraButtons: [btnFinish, btnCancel]
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