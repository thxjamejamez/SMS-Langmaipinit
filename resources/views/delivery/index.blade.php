@extends('admin')
@section('content')
@section('css')
@stop
<div class="container-fluid col-12">
    <div class="row">
        <div class="col-sm-12">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">การจัดส่งสินค้า</h3>
            </div>
            <div class="card-body">
                <div class="col-lg-2 col-md-4 col-sm-12 col-xs-12" style="margin:5px 0px 5px 0px;min-width: 200px;max-width: 220px;">
                    <select class="selectpicker" data-live-search="true" multiple data-actions-box="true" id="ordersts" name="ordersts[]" onchange="getVal('#ordersts','#sordersts');">
                        @foreach($orderstses as $w)
                        <option value="{{ $w->id }}" >{{ $w->sts_name }}</option>
                        @endforeach
                    </select>
                    <input type="hidden" id="sordersts" name="sordersts" value="{{ $ordersts }}">
                </div>
                <table id="deorder-table" class="table table-hover table-bordered dt-responsive nowrap" style="width:100%">
                    <thead>
                        <tr>
                            <th>เลขที่การสั่งซื้อ</th>
                            <th>วันที่สั่งซื้อ</th>
                            <th>วันที่ส่งสินค้า</th>
                            <th class="worksts-filter">สถานะการทำงาน</th>
                            <th style="width: 10px"></th>
                        </tr>
                    </thead>
                </table>
            </div>
        </div>
        </div>
    </div>

    <div class="modal fade bd-example-modal-lg" tabindex="-1" role="dialog" aria-labelledby="productforwork" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">ข้อมูลผู้สั่งซื้อ</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="callout callout-info">
                        <h5 class="name"></h5>
                        <h5 class="address"></h5>
                        <h5 class="senddate"></h5>
                    </div>
                    <div class="row">
                        <div class="col-lg-12">
                            <div class="card">
                                <div class="card-header">
                                    <h3 class="card-title"><i class="ion-cube"></i>&nbsp;&nbsp;รายการสินค้า</h3>
                                </div>
                                <div class="card-body">
                                    <div class="card-body p-0">
                                        <table id="pd" class="table table-hover table-dark">
                                            <thead>
                                                <tr>
                                                <th scope="col" class="text-center">#</th>
                                                <th scope="col" class="text-center">ประเภทสินค้า</th>
                                                <th scope="col" class="text-center">ชื่อสินค้า</th>
                                                <th scope="col" class="text-center">ขนาดสินค้า</th>
                                                <th scope="col" class="text-center">จำนวนสินค้า</th>
                                                <th scope="col" class="text-center">สถานะ</th>
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
        var usertable = $('#deorder-table').DataTable({
            processing: true,
            ajax: {
                    type: 'GET',
                    url: '{{ url("/getdoneorder") }}',
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
                            {data: 'send_date', render: function(data,type,row,meta){
                                if(type==='display'){
                                    data = moment(data).locale('th').format('LL');
                                }
                                return data;
                            }},
                            {data: 'sts_name', name: 'sts_name'},
                            {data: 'order_no', render: function(data, type ,row, meta){
                                if(type === 'display'){
                                    data = "<a class='btn btn-block btn-warning btn-sm' href='javascript:;' onclick='orderdetail("+data+")' data-toggle='modal' data-target='.bd-example-modal-lg'><i class='fa fa-pencil' aria-hidden='true'></i> จัดการ</a>";
                                }
                                return data;
                            }},
                        ],
            initComplete: function(){
                this.api().columns('.worksts-filter').every( function() {
                    var column = this
                    @if($ordersts)
                    var sordersts = '{{ $ordersts }}';
                    var scarray = sordersts.split(",");
                    $('#ordersts').selectpicker('val', scarray);
                    @else
                    $('#ordersts').selectpicker('selectAll');
                    @endif
                    $('#ordersts').on('hide.bs.select', function(e){
                        var Totaloption = $('#ordersts').find('option').length;
                        var TotaloptionSelected = $('#ordersts').find('option:selected').length;
                        var val ='';
                        $('#ordersts option:selected').each(function () {
                        if (Totaloption != TotaloptionSelected){
                            $('#ordersts option:selected').each(function () {
                                if(val){
                                    val += '|';
                                }
                                val += '^' + $(this).text() + '$';
                            });
                        }
                        $("#deorder-table").DataTable().search( '' )
                                .columns('.worksts-filter').search( '' )
                                .draw();
                        column
                            .search( val ? val : '', true, false )
                            .draw();
                        });
                    });
                })
            }
        });
        $('#ordersts').selectpicker({
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

    function getVal(sobj,obj){
        if( ($(sobj+" :selected").length == $(sobj+" option").length) || ($(sobj+" :selected").length == 0) ){
            $(obj).val('');
        }else{ $(obj).val($(sobj).val()); }
    }

    function orderdetail (id) {
        $.ajax({
            type: 'get',
            url: '/getorderdetailsend/'+id
        }).done(function(data){
            $('h5.name').empty();
            $('h5.address').empty();
            $('h5.senddate').empty();
            $('#pd tbody').empty();
            $('.modal-footer').empty();
            (data.order.company_name) ?
                $('h5.name').append('<b>ชื่อบริษัท: </b>'+data.order.company_name):
                $('h5.name').append('<b>ชื่อลูกค้า: </b>'+data.order.first_name+'  '+data.order.last_name);

            (data.order.company_address) ?
                $('h5.address').append('<b>ที่อยู่บริษัท: </b>'+data.order.company_address+' '+data.order.city_com+' '+data.order.pro_com):
                $('h5.address').append('<b>ที่อยู่: </b>'+data.order.address+' '+data.order.city_cus+' '+data.order.pro_cus);
            $('h5.senddate').append('<b>กำหนดวันส่งสินค้า: </b>'+moment(data.order.send_date).locale('th').format('LL'));
            if(data.orderdetail.length > 0){
                $.each(data.orderdetail, function( key, value ) {
                    tr = $('#pd tbody').append('<tr></tr>')
                    tr.append('<td>' + (key + 1) + '</td>')
                    tr.append('<td>' + value.type_name + '</td>')
                    tr.append('<td>' + value.product_name + '</td>')
                    tr.append('<td class="text-center">' + value.product_size + '</td>')
                    tr.append('<td class="text-center">' + value.qty + '</td>')
                    tr.append('<td class="text-center">'+ value.sts_name +'</td>')
                });
            } 
            $('.modal-footer').append('<a class="btn btn-block btn-primary btn-sm" style="margin-top: .5rem;" href="deliveryslip/'+data.order.order_no+'/pdf" target="_blank" ><i class="fa fa-print" aria-hidden="true"></i> พิมพ์ใบส่งสินค้า</a>');
            (data.order.status == 5) ?
                $('.modal-footer').append('<button class="btn btn-block btn-success btn-sm" onclick="changests(5, '+data.order.order_no+')" disabled><i class="fa fa-truck" aria-hidden="true"></i> ยืนยันการจัดส่งสินค้า</button>'):
                $('.modal-footer').append('<button class="btn btn-block btn-success btn-sm" onclick="changests(5, '+data.order.order_no+')"><i class="fa fa-truck" aria-hidden="true"></i> ยืนยันการจัดส่งสินค้า</button>');
  
        })
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
                $('#deorder-table').DataTable().ajax.reload();
            }
        }) 
    }

</script>
@stop