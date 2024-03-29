@extends('admin')
@section('content')
@section('css')
<link rel="stylesheet" href="/plugins/datetimepicker/css/bootstrap-datetimepicker.min.css">

@stop
<div class="container-fluid col-12">
    <div class="row">
        <div class="col-sm-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">ใบวางบิลของฉัน</h3>
                </div>
                <div class="card-body">
                    <div class="col-lg-2 col-md-4 col-sm-12 col-xs-12" style="margin:5px 0px 5px 0px;min-width: 200px;max-width: 220px;">
                        <select class="selectpicker" data-live-search="true" multiple data-actions-box="true" id="invsts" name="invsts[]">
                            @foreach($invstses as $i)
                            <option value="{{ $i->id }}" >{{ $i->sts_name }}</option>
                            @endforeach
                        </select>
                        <input type="hidden" id="sinvsts" name="sinvsts" value="{{ $invsts }}">
                    </div>
                    <table id="myinvoice-table" class="table table-hover table-bordered dt-responsive nowrap" style="width:100%">
                        <thead>
                            <tr>
                                <th>เลขหมายใบวางบิล</th>
                                <th>กำหนดจ่าย</th>
                                <th class="invsts-filter">สถานะใบวางบิล</th>
                                <th style="width: 10px"></th>
                                <th style="width: 10px"></th>
                            </tr>
                        </thead>
                    </table>
                </div>
            </div>
        </div>
    </div>

    {{-- modal --}}
    <div class="modal fade" id="pay" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">เพิ่มข้อมูลการชำระเงิน</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="form-group type">
                    <label>
                        <input type="radio" name="ivchoose" value=1>
                        อัพโหลดไฟล์
                    </label>
                    <label style="padding-left: 26px;">
                        <input type="radio" name="ivchoose" value=2>
                        กรอกข้อมูล
                    </label>
                </div>
                <div class="form-group inputtype">
                </div>
                <div class="form-group">
                    <label>วัน - เวลาที่โอนเงิน</label>
                    <div class="form-group">
                        <input type="text" class="form-control" id="datetimepicker1">
                    </div>
                </div>
            </div>
            <div class="modal-footer">
            </div>
            </div>
        </div>
    </div>

</div>
@stop
@section('script')
<script src="/plugins/datetimepicker/js/bootstrap-datetimepicker.min.js"></script>

<script type="text/javascript">
    $(document).ready(function () {
        $('#datetimepicker1').datetimepicker({
            locale: moment.locale(),

        });

        var usertable = $('#myinvoice-table').DataTable({
            processing: true,
            ajax: {
                    type: 'GET',
                    url: '{{ url("/getmyinvoice") }}',
                },
            columns:    [
                            {data: 'invoice_number', render: function(data, type ,row, meta){
                                if(type === 'display'){
                                    data = 'INV'+numeral(data).format('000000');
                                }
                                return data;
                            }},
                            {data: 'due_date', render: function(data,type,row,meta){
                                if(type==='display'){
                                    data = moment(data).format('DD-MM-YYYY');
                                }
                                return data;
                            }},
                            {data: 'sts_name', name: 'sts_name'},
                            {data: 'invoice_no', render: function(data, type ,row, meta){
                                if(type === 'display'){
                                    data = "<a class='btn btn-block btn-primary btn-sm' href='/invoicedetail/"+data+"'><i class='fa fa-search' aria-hidden='true'></i> รายละเอียด</a>"
                                }
                                return data;
                            }},
                            {data: 'invoice_no', render: function(data, type ,row, meta){
                                if(type === 'display'){
                                    if(row.id === 2 || row.id === 3){
                                        data = "<a class='btn btn-block btn-warning btn-sm disabled' href='javascript:;' onclick='payfor("+data+")'><i class='fa fa-money' aria-hidden='true'></i> แจ้งการชำระเงิน</a>"
                                    }else{
                                        data = "<a class='btn btn-block btn-warning btn-sm' href='javascript:;' onclick='payfor("+data+")'><i class='fa fa-money' aria-hidden='true'></i> แจ้งการชำระเงิน</a>"
                                    }
                                }
                                return data;
                            }},
                        ],
                initComplete: function(){
                this.api().columns('.invsts-filter').every( function() {
                    var column = this
                    @if($invsts)
                    var sinvsts = '{{ $invsts }}';
                    var scarray = sinvsts.split(",");
                    $('#invsts').selectpicker('val', scarray);
                    @else
                    $('#invsts').selectpicker('selectAll');
                    @endif
                    $('#invsts').on('hide.bs.select', function(e){
                        var Totaloption = $('#invsts').find('option').length;
                        var TotaloptionSelected = $('#invsts').find('option:selected').length;
                        var val ='';
                        $('#invsts option:selected').each(function () {
                        if (Totaloption != TotaloptionSelected){
                            $('#invsts option:selected').each(function () {
                                if(val){
                                    val += '|';
                                }
                                val += '^' + $(this).text() + '$';
                            });
                        }
                        $("#myinvoice-table").DataTable().search( '' )
                                .columns('.invsts-filter').search( '' )
                                .draw();
                        column
                            .search( val ? val : '', true, false )
                            .draw();
                        });
                    });
                })
            }
        });
        $('#invsts').selectpicker({
            selectedTextFormat: 'count > 2',
            countSelectedText: function (numSelected, numTotal) {
                if (numSelected == 1) {
                    return "{0} ที่เลือก";
                } else if (numSelected === numTotal) {
                    return "-- สถานะทั้งหมด --";
                } else {
                    return "{0} ที่เลือก";
                }
            },
            noneSelectedText: '-- ไม่มีสถานะที่เลือก --',
            selectAllText: 'เลือกทั้งหมด',
            deselectAllText: 'ไม่เลือกทั้งหมด',
        });
    });


    function payfor (id) {
        $('#pay').modal('show')
        $('.modal-footer').empty();
        $('.modal-footer').append(`<button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-primary" onclick="save(`+id+`)">Save changes</button>`)
    }

    function save(id){
        chk_text = $("#textmoney").val()
        if($('input[name=ivchoose]:checked').val() == null){
            swal({
                type: 'error',
                title: 'ผิดพลาด...',
                text: 'กรุณาเลือกวิธีการเพิ่มข้อมูลชำระเงิน',
            })
        }else{
            if(($('input[name=ivchoose]:checked').val() == 1) && (($("#payfile").val() == '') || $('#datetimepicker1').val() == '')){
                swal({
                    type: 'error',
                    title: 'ผิดพลาด...',
                    text: 'กรุณากรอกข้อมูลให้ครบถ้วน',
                })
            }else if(($('input[name=ivchoose]:checked').val() == 2) && (($("#textmoney").val() == '') || $('#datetimepicker1').val() == '')){
                swal({
                    type: 'error',
                    title: 'ผิดพลาด...',
                    text: 'กรุณากรอกข้อมูลให้ครบถ้วน',
                })
            }else {
                var form_data = new FormData()
                var file_data = ''
                if($('input[name=ivchoose]:checked').val() == 1){
                    file_data = $("#payfile").prop("files")[0];
                    form_data.append("file", file_data)
                }else if($('input[name=ivchoose]:checked').val() == 2){
                    form_data.append("textmoney", $("#textmoney").val())
                }
                form_data.append("invoice_no", id)
                form_data.append("typeupload", $('input[name=ivchoose]:checked').val())
                form_data.append("pay_datetime", $('#datetimepicker1').val())
                $.ajax({ 
                    url: '/updateslip',  
                    method: 'POST', 
                    cache: false,
                    contentType: false,
                    processData: false,
                    data: form_data,
                    success: function(data){
                        if(data=='success'){
                            swal({
                            type: 'success',
                            title: 'บันทึกสำเร็จ',
                            showConfirmButton: false,
                            timer: 1000
                            });
                            $('#pay').modal('hide')
                            $('#myinvoice-table').DataTable().ajax.reload();
                        }
                    }
                })
            }
            
        }
    }

    $('input[name=ivchoose]').on('change', function (){
        if($(this).val() == 1){
            $('.inputtype').empty()
            $('.inputtype').append(`<label for="file">ไฟล์แนบ</label>
                    <div class="input-group">
                        <input id="payfile" type="file" class="form-control-file" name="payfile">
                    </div>
            `)
            $('#changedate').datepicker({
                startDate: 'today',
                todayHighlight: true,
                format: 'dd-mm-yyyy',
                autoclose: true,
            });
        }else if($(this).val() == 2){
            $('.inputtype').empty()
            $('.inputtype').append(`<label>จำนวนเงิน</label>
                <div class="input-group">
                    <div class="input-group-prepend">
                        <span class="input-group-text">$</span>
                    </div>
                    <input id="textmoney" type="text" name="textmoney" class="form-control">
                    <div class="input-group-append text-right">
                        <span class="input-group-text">.00</span>
                    </div>
                </div>
            `)
        }else{
            $('.inputtype').empty()
        }
    })





</script>
@stop