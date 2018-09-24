@extends('admin')
@section('content')
@section('css')
@stop
<div class="container-fluid col-12">
    <div class="row">
        <div class="col-sm-12">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">ตารางการทำงาน</h3>
            </div>
            <div class="card-body">
                <div class="col-lg-2 col-md-4 col-sm-12 col-xs-12" style="margin:5px 0px 5px 0px;min-width: 200px;max-width: 220px;">
                    <select class="selectpicker" data-live-search="true" multiple data-actions-box="true" id="worksts" name="worksts[]" onchange="getVal('#worksts','#sworksts');">
                        @foreach($workstses as $w)
                        <option value="{{ $w->id }}" >{{ $w->sts_name }}</option>
                        @endforeach
                    </select>
                    <input type="hidden" id="sworksts" name="sworksts" value="{{ $worksts }}">
                </div>
                <table id="work-table" class="table table-hover table-bordered dt-responsive nowrap" style="width:100%">
                    <thead>
                        <tr>
                            <th>เลขที่การสั่งซื้อ</th>
                            <th>วันที่สั่งซื้อ</th>
                            <th>วันที่ส่งสินค้า</th>
                            <th class="worksts-filter">สถานะการทำงาน</th>
                            <th class="text-center">การประมวลผล</th>
                            <th class="text-center">เปอร์เซ็นต์</th>
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
                    <h5 class="modal-title">รายการสินค้าที่ต้องทำ</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="callout callout-info">
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
        var usertable = $('#work-table').DataTable({
            processing: true,
            ajax: {
                    type: 'GET',
                    url: '{{ url("/getorderforwork") }}',
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
                            {data: 'count_fpd', render: function(data, type, row, meta){
                                if(type==='display'){
                                    if(data){
                                        percent = (data/row.count_pd) * 100                      
                                    }else{
                                        percent = 0
                                    }
                                    if(percent < 80){
                                        data = `<div class="progress progress-xs progress-striped active">
                                                    <div class="progress-bar bg-warning" style="width: `+accounting.formatNumber(percent, 2)+`%"></div>
                                                </div>`
                                    }else{
                                        data = `<div class="progress progress-xs progress-striped active">
                                                    <div class="progress-bar bg-success" style="width: `+accounting.formatNumber(percent, 2)+`%"></div>
                                                </div>`
                                    }
                                }
                                return data
                            }},
                            {data: 'count_fpd', render: function(data, type, row, meta){
                                if(type==='display'){
                                    if(data){
                                        percent = (data/row.count_pd) * 100                      
                                    }else{
                                        percent = 0
                                    }
                                    if(percent < 80){
                                        data = `<span class="badge bg-warning">`+accounting.formatNumber(percent, 2)+`%</span>`
                                    }else{
                                        data = `<span class="badge bg-success">`+accounting.formatNumber(percent, 2)+`%</span>`
                                    } 
                                }
                                return data
                            }},
                            {data: 'order_no', render: function(data, type ,row, meta){
                                if(type === 'display'){
                                    if(row.id <= 2){
                                        data = "<a class='btn btn-block btn-info btn-sm' href='javascript:;' onclick='doproduct("+data+")' data-toggle='modal' data-target='.bd-example-modal-lg'><i class='fa fa-pencil-square-o' aria-hidden='true'></i> จัดการ</a>";
                                    }else{
                                        data = "<a class='btn btn-block btn-warning btn-sm' href='javascript:;' onclick='doproduct("+data+")' data-toggle='modal' data-target='.bd-example-modal-lg'><i class='fa fa-search' aria-hidden='true'></i> เรียกดู</a>";
                                    }
                                }
                                return data;
                            }},
                        ],
            initComplete: function(){
                this.api().columns('.worksts-filter').every( function() {
                    var column = this
                    @if($worksts)
                    var sworksts = '{{ $worksts }}';
                    var scarray = sworksts.split(",");
                    $('#worksts').selectpicker('val', scarray);
                    @else
                    $('#worksts').selectpicker('selectAll');
                    @endif
                    $('#worksts').on('hide.bs.select', function(e){
                        var Totaloption = $('#worksts').find('option').length;
                        var TotaloptionSelected = $('#worksts').find('option:selected').length;
                        var val ='';
                        $('#worksts option:selected').each(function () {
                        if (Totaloption != TotaloptionSelected){
                            $('#worksts option:selected').each(function () {
                                if(val){
                                    val += '|';
                                }
                                val += '^' + $(this).text() + '$';
                            });
                        }
                        $("#work-table").DataTable().search( '' )
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
        $('#worksts').selectpicker({
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

    function doproduct (id) {
        $.ajax({
            type: 'get',
            url: '/getworkdetail/'+id
        }).done(function(data){
            $('h5.senddate').empty();
            $('#pd tbody').empty();
            $('h5.senddate').append('<b>กำหนดวันส่งสินค้า: </b>'+moment(data.order.send_date).locale('th').format('LL'));
            if(data.orderdetail.length > 0){
                $.each(data.orderdetail, function( key, value ) {
                    let option = ''
                    $.each(data.pdsts, function ( k, v){
                        selected = (v.id == value.pd_sts_id)? 'selected':'' 
                        option += '<option value='+ v.id +' ' + selected + '>' +v.sts_name+'</option>'
                    })
                    tr = $('#pd tbody').append('<tr></tr>')
                    tr.append('<td>' + (key + 1) + '</td>')
                    tr.append('<td>' + value.type_name + '</td>')
                    tr.append('<td>' + value.product_name + '</td>')
                    tr.append('<td class="text-center">' + value.product_size + '</td>')
                    tr.append('<td class="text-center">' + value.qty + '</td>')
                    tr.append(`<td><select class="form-control" onchange="updatedata(this, `+data.order.order_no+`, `+value.product_no+`)">`+ option +`</select></td>`)
                    
                });
            }   
        })
    }

    function updatedata(vm, order_no, pd_no){
        value = $(vm).val(); 
        $.ajax({
            type: 'POST',
            url: '/updateworksts',
            data: {
                'order_no': order_no,
                'pd_no': pd_no,
                'sts': value
            }
        }).done(function(data){
            const toast = swal.mixin({
                toast: true,
                position: 'top-end',
                showConfirmButton: false,
                timer: 3000
            });

            toast({
                type: 'success',
                title: 'เปลี่ยนสถานะเรียบร้อยแล้ว'
            })
            $('#work-table').DataTable().ajax.reload();
        })
    }
</script>
@stop