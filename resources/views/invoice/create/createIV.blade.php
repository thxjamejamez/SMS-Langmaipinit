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
                    <h3 class="card-title">รายการการสั่งซื้อที่ค้างจ่าย</h3>
                </div>
                <div class="card-body">
                    <table id="ordercust-table" class="table table-hover table-bordered dt-responsive nowrap" style="width:100%">
                        <thead>
                            <tr>
                                <th><input type="checkbox" name="checkall"></th>
                                <th>เลขที่การสั่งซื้อ</th>
                                <th>วันที่สั่งซื้อ</th>
                                <th>วันที่จัดส่งสินค้า</th>
                                <th>สถานะการสั่งซื้อ</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($order as $o)
                                <tr>
                                    <td><input type="checkbox" name="choose" onchange="disabledbt()" value="{{ $o->order_no }}"></td>
                                    <td>{{ $o->order_no }}</td>
                                    <td>{{ $o->order_date }}</td>
                                    <td>{{ $o->send_date }}</td>
                                    <td>{{ $o->sts_name }}</td>
                                </tr>
                            @endforeach    
                        </tbody>
                    </table>
                </div>
                <input type="hidden" id="UC_id" value={{ $order[0]->users_id }}>
                <div class="card-footer">
                    <div class="row">
                        <div class="col-2">
                            <button class="btn btn-block btn-outline-primary btn-sm" id="openmodal" onclick="openmodal()">สร้างใบวางบิล</button>
                        </div>
                        <div class="col-2">
                            <button class="btn btn-block btn-outline-danger btn-sm">ยกเลิก</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- modal --}}
    <div class="modal fade bd-example-modal-sm" id="dateIVmodal" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog modal-sm">
            <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="headmaterial">วันที่สร้างใบวางบิล</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="form-group name">
                            <label for="invoicedate">วันที่</label>
                            <input id="invoicedate" type="text" class="form-control" name="invoicedate">
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-primary" onclick="save()">บันทึก</button>
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">ยกเลิก</button>
                    </div>
            </div>
        </div>
    </div>
</div>
@stop
@section('script')
    <script type="text/javascript">
        $(document).ready(function () {
            disabledbt()
            $('#invoicedate').datepicker({
                format: 'dd-mm-yyyy',
                todayHighlight: true,
                autoclose: true
            })  
        });
        var materialtable = $('#ordercust-table').DataTable({
            "columnDefs": [
                    { 
                        "orderable": false,
                        "targets": 0
                    },
                    {
                        "targets": 1,
                        "orderable": true,
                        "render": function (data, type ,row) {
                            if(type === 'display'){
                                data = 'PO'+numeral(data).format('000000');
                            }
                            return data;
                        },
                    },
                    {
                        "targets": 2,
                        "render": function (data, type ,row) {
                            if(type === 'display'){
                                data = moment(data).format('DD-MM-YYYY');
                            }
                            return data;
                        },
                    },
                    {
                        "targets": 3,
                        "render": function (data, type ,row) {
                            if(type === 'display'){
                                data = moment(data).format('DD-MM-YYYY');
                            }
                            return data;
                        },
                    }
                ]
            });

        $("input[name=checkall]").on( "click", function() {
            if($('input[name=checkall]:checked').length == 1){
                $('input[name=choose]').prop("checked", true)
                $('#openmodal').attr("disabled", false)
            }else{
                $('input[name=choose]').prop("checked", false)
                $('#openmodal').attr("disabled", true)

            }  
        });

        function openmodal() {
            $('#dateIVmodal').modal('show')
        }

        function disabledbt (){
            if($('input[name=choose]:checked').length > 0){
                $('#openmodal').attr("disabled", false)
            }else{
                $('#openmodal').attr("disabled", true)
            }
        }

        function save() {
            let arr = []
            $('input[name=choose]:checked').each(function (k, v){
                arr.push(v.value)
            })
            $.ajax({
            type: 'POST',
            url: '/saveIv',
            data: {
                'invoice_date': $('#invoicedate').val(),
                'users_id': $('#UC_id').val(),
                'choose_order': arr
            }
            }).done(function(data){
                if(data == 'success'){
                    swal(
                        'เรียบร้อย!',
                        'สร้างใบวางบิลเรียบร้อยแล้ว',
                        'success'
                    )
                    $('#dateIVmodal').modal('hide')
                    window.location.href = '/admininvoice'
                }
            })
        }
    </script>

@stop