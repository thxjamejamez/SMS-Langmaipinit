@extends('admin')
@section('content')
@section('css')
<link rel="stylesheet" href="/plugins/datepicker/datepicker3.css">
@stop
<div class="container-fluid col-12">
    <div class="row">
        <div class="col-sm-12">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">รายการคำสั่งซื้อ</h3>
            </div>
            <div class="card-body">
                <select class="selectpicker" data-live-search="true" multiple data-actions-box="true" id="orsts" name="orsts[]">
                    @foreach($orstses as $r)
                    <option value="{{ $r->id }}" >{{ $r->sts_name }}</option>
                    @endforeach
                </select>
                <table id="reorder-table" class="table table-hover table-bordered dt-responsive nowrap" style="width:100%">
                    <thead>
                        <tr>
                            <th>เลขที่การสั่งซื้อ</th>
                            <th>วันที่สั่งซื้อ</th>
                            <th class="ordersts-filter">สถานะการสั่งซื้อ</th>
                            <th style="width: 10px"></th>
                        </tr>
                    </thead>
                </table>
            </div>
        </div>
        </div>
    </div>

    <!-- Modal -->
    <div class="modal fade bd-example-modal-lg" id="detail" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">ตรวจสอบข้อมูล</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="alert alert-danger alert-dismissible">
                        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                        <h6 class="reason_show"></h6>
                        
                    </div>
                    <div class="row">
                        <div class="col-lg-12">
                            <div class="card">
                                <div class="card-header">
                                    <h3 class="card-title"><i class="fa fa-cart-arrow-down"></i>&nbsp;&nbsp;สินค้าที่สั่งซื้อ</h3>
                                </div>
                                <div class="card-body">
                                    <div class="card-body p-0">
                                        <table name="orderdetail" class="table table-condensed">
                                            <thead>
                                                <tr style="background-color: #c3c3c3;">
                                                    <th style="width: 10px">#</th>
                                                    <th>ประเภทสินค้า</th>
                                                    <th>ชื่อสินค้า</th>
                                                    <th>ขนาดสินค้า</th>
                                                    <th class="text-right">ราคาต่อหน่วย</th>
                                                    <th class="text-center">จำนวนที่สั่งซื้อ</th>
                                                    <th class="text-right">ราคารวม</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-lg-12">
                            <div class="card">
                                <div class="card-header">
                                    <h3 class="card-title"><i class="fa fa-info-circle"></i>&nbsp;&nbsp;รายละเอียดการสั่งซื้อ</h3>
                                </div>
                                <div class="card-body">
                                    <div class="row">
                                        <div class="form-group col-6">
                                            <label>หมายเหตุ</label>
                                            <textarea class="form-control" name="re_detail" rows="3" placeholder="" disabled></textarea>
                                        </div>
                                        
                                        <div class="form-group col-4">
                                            <label>วันที่ส่งสินค้า</label>
                                            <div class="input-group">
                                                <div class="input-group-prepend">
                                                    <span class="input-group-text"><i class="fa fa-calendar"></i></span>
                                                </div>
                                                <input id="senddate" type="text" name="senddate" class="form-control" disabled>
                                            </div>
                                        </div>
                                        <div class="form-group col-2" id="file">
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="reason" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog modal-sm">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">เหตุผล</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="form-group type">
                        <label>
                            <input type="radio" name="rs" class="minimal-red" value=1>
                             ข้อมูลคำสั่งซื้อไม่ถูกต้อง
                        </label>
                        <label>
                            <input type="radio" name="rs" class="minimal-red" value=2>
                             ไม่สามารถผลิตได้ตามคำสั่งซื้อ
                        </label>
                        <label>
                            <input type="radio" name="rs" class="minimal-red" value=3>
                             อื่น ๆ
                        </label>
                        {{-- <label>เนื่องจาก</label> --}}
                        {{-- <select class="form-control" id="reason_type"></select> --}}
                    </div>
                    <div class="form-group inputtype">
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
<script type="text/javascript">
    $(document).ready(function () {
        
        var usertable = $('#reorder-table').DataTable({
            processing: true,
            ajax: {
                    type: 'GET',
                    url: '{{ url("/getorderlist") }}',
                },
            columns:    [
                            {data: 'order_no', render: function(data, type ,row, meta){
                                if(type === 'display'){
                                    data = 'PO'+numeral(data).format('000000');
                                }
                                return data;
                            }},
                            {data: 'order_date', render: function(data,type,row,meta){
                                if(type==='display'){
                                    data = moment(data).locale('th').format('LL');
                                }
                                return data;
                            }},
                            {data: 'sts_name', name: 'sts_name'},
                            {data: 'order_no', render: function(data, type ,row, meta){
                                if(type === 'display'){
                                    if(row.id == 1){
                                        data = "<a class='btn btn-block btn-primary btn-sm' href='javascript:;' onclick='opendetail("+data+")' data-toggle='modal' data-target='.bd-example-modal-lg'><i class='fa fa-pencil-square-o' aria-hidden='true'></i> ตรวจสอบ</a>";
                                    }else if(row.id == 6){
                                        data = "<a class='btn btn-block btn-danger btn-sm' href='javascript:;' onclick='opendetail("+data+")' data-toggle='modal' data-target='.bd-example-modal-lg'><i class='fa fa-search' aria-hidden='true'></i> เรียกดู</a>";
                                    }else{
                                        data = "<a class='btn btn-block btn-warning btn-sm' href='javascript:;' onclick='opendetail("+data+")' data-toggle='modal' data-target='.bd-example-modal-lg'><i class='fa fa-search' aria-hidden='true'></i> เรียกดู</a>";
                                    }
                                }
                                return data;
                            }},
                        ],
                initComplete: function(){
                this.api().columns('.ordersts-filter').every( function() {
                    var column = this
                    @if($orsts)
                    var srests = '{{ $orsts }}';
                    var scarray = srests.split(",");
                    $('#orsts').selectpicker('val', scarray);
                    @else
                    $('#orsts').selectpicker('selectAll');
                    @endif
                    $('#orsts').on('hide.bs.select', function(e){
                        var Totaloption = $('#orsts').find('option').length;
                        var TotaloptionSelected = $('#orsts').find('option:selected').length;
                        var val ='';
                        $('#orsts option:selected').each(function () {
                        if (Totaloption != TotaloptionSelected){
                            $('#orsts option:selected').each(function () {
                                if(val){
                                    val += '|';
                                }
                                val += '^' + $(this).text() + '$';
                            });
                        }
                        $("#reorder-table").DataTable().search( '' )
                                .columns('.ordersts-filter').search( '' )
                                .draw();
                        column
                            .search( val ? val : '', true, false )
                            .draw();
                        });
                    });
                })
            }
        });
    });

    function opendetail($order_id) {
        $.ajax({
            type: 'get',
            url: '/getorderdetail/'+$order_id+'/admin'
        }).done(function(data){
            let sum = 0;
            $('#detail table[name=orderdetail] tbody').empty();
            $('#detail textarea[name=re_detail]').empty();
            $('#detail .modal-footer').empty();
            $('#detail #file').empty();
            data.orderdetail.forEach((v, k) => {
                sum += (v.price * v.qty);
                $tr = $('#detail table[name=orderdetail] tbody').append('<tr></tr>');
                $tr.append('<td>'+(k+1)+'</td>');
                $tr.append('<td>'+v.type_name+'</td>');
                $tr.append('<td>'+v.product_name+'</td>');
                $tr.append('<td>'+v.product_size+'</td>');
                $tr.append('<td class="text-right">'+accounting.formatNumber(v.price, 2)+'</td>');
                $tr.append('<td class="text-center">'+v.qty+'</td>');
                $tr.append('<td class="text-right">'+accounting.formatNumber(v.price * v.qty, 2)+'</td>');
            });
            $trfooter = $('#detail table[name=orderdetail] tbody').append('<tr></tr>');
            $trfooter.append('<td colspan="5" style="background-color: #E0E0E0"><b>รวมทั้งสิ้น</b></td>');
            $trfooter.append('<td class="text-right" style="background-color: #E0E0E0"><b>'+accounting.formatNumber(sum, 2)+'</b></td>');  
            $trfooter.append('<td class="text-right" style="background-color: #E0E0E0"><b>บาท</b></td>');   

            $('#detail textarea[name=re_detail]').append(data.order.remark);
            $('#detail #senddate').val(moment(data.order.send_date).locale('th').format('LL'));
            if(data.order.file){
                $file = $('#detail #file').append('<label>ไฟล์แนบ</label><div class="input-group"><div class="input-group-prepend"></div></div>');
                $file.append('<a href="/file_order/'+data.order.file+'" target="_blank" class="btn btn-block btn-info btn-sm"><i class="fa fa-file" aria-hidden="true"></i> เรียกดู</a>');
            }
            if(data.order.status != 1){
                $('#detail .modal-footer').append('<button type="button" class="btn btn-block btn-success btn-sm" style="margin-top: .5rem;" onclick="changests(2, '+data.order.order_no+')" disabled>อนุมัติ</button>');
                $('#detail .modal-footer').append('<button type="button" class="btn btn-block btn-danger btn-sm" onclick="openreason('+data.order.order_no+')" disabled>ไม่อนุมัติ</button>');
                $('#detail .modal-footer').append('<button type="button" class="btn btn-block btn-secondary btn-sm" data-dismiss="modal">ปิด</button>');      
            }else{
                $('#detail .modal-footer').append('<button type="button" class="btn btn-block btn-success btn-sm" style="margin-top: .5rem;" onclick="changests(2, '+data.order.order_no+')">อนุมัติ</button>');
                $('#detail .modal-footer').append('<button type="button" class="btn btn-block btn-danger btn-sm" onclick="openreason('+data.order.order_no+')">ไม่อนุมัติ</button>');
                $('#detail .modal-footer').append('<button type="button" class="btn btn-block btn-secondary btn-sm" data-dismiss="modal">ปิด</button>');      
            }

            if(data.order.status == 6){
                $('#detail .modal-body .alert-danger .reason_show').empty()
                $('#detail .modal-body .alert-danger .reason_show').append(`<i class="icon fa fa-ban"></i> รายการคำสั่งซื้อนี้ไม่ได้รับการอนุมัติ 
                    <br>เนื่องจาก: `+data.order.reason_name+``)
                $('#detail .modal-body .alert-danger').show();
            }else{
                $('#detail .modal-body .alert-danger').hide();
            }
        });
    }

    function changests ($sts_id, $order_no){
        $.ajax({
            url: '/changests/'+$order_no+'/'+$sts_id,
            type: 'get'
        }).done(function (data) {
            if(data=='success'){
                swal({
                    type: 'success',
                    title: 'บันทึกสำเร็จ',
                    showConfirmButton: false,
                    timer: 1000
                });
                $('.bd-example-modal-lg').modal('toggle');
                $('#reorder-table').DataTable().ajax.reload();
            }
        }) 
    }

    function openreason (id) {
        $('#reason').modal('show')
        $('.change_date').empty()
        $('#reason .modal-footer').empty()
        $.ajax({
            type: 'get',
            url: '/reason'
        }).done(function (data){
            let option = '<option value=0>--- เลือก ---</option>'
            $.each(data, function (k, v){
                option += '<option value='+ v.id +'>' +v.reason_name+'</option>'
            })
            $('#reason_type').empty()
            $('#reason_type').append(option)   
        })

        $('#reason .modal-footer').append(`<button type="button" style="margin-top: .5rem;" class="btn btn-block btn-danger btn-sm" onclick="savereason(`+id+`)">บันทึก</button>
        <button type="button" class="btn btn-block btn-secondary btn-sm" data-dismiss="modal">ปิด</button>`)
    }

    $('input[name=rs]').on('change', function (){
        if($(this).val() == 2){
            $('.inputtype').empty()
            $('.inputtype').append(`<label>กำหนดส่งสินค้าที่ต้องการ</label>
                <div class="input-group">
                    <div class="input-group-prepend">
                    <span class="input-group-text"><i class="fa fa-calendar"></i></span>
                    </div>
                    <input id="changedate" type="text" name="changedate" class="form-control">
                </div>
            `)
            $('#changedate').datepicker({
                format: 'dd-mm-yyyy',
                autoclose: true,
            });
        }else if($(this).val() == 3){
            $('.inputtype').empty()
            $('.inputtype').append(`<label>หมายเหตุ</label>
                <div class="input-group">
                    <input id="textreason" type="text" name="reason" class="form-control">
                </div>
            `)
        }else{
            $('.inputtype').empty()
        }
    })

    function savereason(id) {
        if($('input[name=rs]:checked').val() == null){
            swal({
                type: 'error',
                title: 'ผิดพลาด!',
                text: 'กรุณาเลือกเหตุผล'
            })
        }else if (($('input[name=rs]:checked').val() == 2) && ($('#changedate').val() == '')) {
            swal({
                type: 'error',
                title: 'ผิดพลาด!',
                text: 'กรุณากรอกวันที่ที่ต้องการจัดส่ง'
            })
        }else if (($('input[name=rs]:checked').val() == 3) && ($('#textreason').val() == '')){
            swal({
                type: 'error',
                title: 'ผิดพลาด!',
                text: 'กรุณากรอกเหตุผล'
            })
        }else{
            let changedate = ''
            let reason = ''
            let reason_type = $('input[name=rs]:checked').val()
            if($('#changedate').val()){
                changedate = $('#changedate').val()
            }
            if($('#textreason').val()){
                reason = $('#textreason').val()
            }
            $.ajax({
                type: 'post',
                url: '/savereason',
                data: {
                    order_no: id,
                    order_sts: 6,
                    reason_type: reason_type,
                    changedate: changedate,
                    reason: reason
                }
            }).done(function (data) {
                if(data == 'success'){
                    swal({
                        position: 'top-end',
                        type: 'success',
                        title: 'บันทึกข้อมูลสำเร็จ',
                        showConfirmButton: false,
                        timer: 1000
                    })
                    $('#reason').modal('hide')
                    $('#detail').modal('hide')
                    $('#reorder-table').DataTable().ajax.reload();

                }
            })
        }
        
    }


</script>
@stop