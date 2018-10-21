@extends('admin')
@section('content')
@section('css')
@stop
<div class="container-fluid col-12">
    <div class="row">
        <div class="col-sm-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">จัดการวัตถุดิบ</h3>
                </div>
                <div class="card-body">
                    <table id="materialmn-table" class="table table-hover table-bordered dt-responsive nowrap" style="width:100%">
                        <thead>
                            <tr>
                                <th>รหัสวัตถุดิบ</th>
                                <th>ชื่อวัตถุดิบ</th>
                                <th>ประเภทวัตถุดิบ</th>
                                <th>จำนวนคงเหลือ</th>
                                <th style="width: 10px"></th>
                                <th style="width: 10px"></th>
                                <th style="width: 10px"></th>
                            </tr>
                        </thead>
                    </table>
                </div>
            </div>
        </div>
    </div>

    {{-- modal add --}}
    <div class="modal fade" id="add_modal" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="headmaterial"></h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="form-group type">
                        <label>ผู้ขายวัตถุดิบ</label>
                        <select class="form-control" id="sup"></select>
                    </div>
                    <div class="form-group name">
                        <label for="qty">จำนวนวัตถุดิบ</label>
                        <input id="qty" type="number" class="form-control" name="qty" onchange="sum()">
                    </div>
                    <div class="form-group name">
                        <label for="unitprice">ราคาต่อหน่วย</label>
                        <input id="unitprice" type="number" class="form-control" name="unitprice" onchange="sum()">
                    </div>
                    <div class="form-group name">
                        <label for="price">รวมทั้งสิ้น</label>
                        <input id="price" type="text" class="form-control" name="price" disabled>
                    </div>
                </div>
                <div class="modal-footer">
                </div>
            </div>
        </div>
    </div>


    {{-- modal use --}}
    <div class="modal fade" id="use_modal" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="headmaterial"></h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="form-group name">
                        <label for="useunit">จำนวนที่ใช้</label>
                        <input id="useunit" type="number" class="form-control" name="useunit" onchange="chk()">
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
<script  type="text/javascript">
    $(document).ready(function () {
        var pmid = '{{$pmedit->permission_id}}'
        
        var materialtable = $('#materialmn-table').DataTable({
            processing: true,
            ajax: {
                    type: 'GET',
                    url: '/getmaterial',
                },
            columns:    [
                            {data: 'material_no', render: function(data, type ,row, meta){
                                if(type === 'display'){
                                    if(row.sts_ordering == 1){
                                        data = 'M'+numeral(data).format('000000')+' <i class="fa fa-exclamation-circle" style="color: red"></i>';

                                    }else{
                                        data = 'M'+numeral(data).format('000000');
                                    }
                                }
                                return data
                            }},
                            {data: 'material_name', name: 'material_name'},
                            {data: 'type_name', name: 'type_name'},
                            {data: 'balance', name: 'balance'},
                            {sClass: "hide_column", data: 'material_no', render: function(data, type ,row, meta){
                                if(type === 'display'){
                                    data = "<a class='btn btn-block btn-success btn-sm' href='javascript:;' onclick='add("+data+")'><i class='fa fa-plus' aria-hidden='true'></i> เพิ่มวัตถุดิบ</a>";
                                }
                                return data
                            }},
                            {sClass: "hide_column", data: 'material_no', render: function(data, type ,row, meta){
                                if(type === 'display'){
                                    if(row.balance == 0){
                                        data = ""
                                    }else{
                                        data = "<a class='btn btn-block btn-warning btn-sm' href='javascript:;' onclick='use("+data+", "+row.balance+")'><i class='fa fa-minus' aria-hidden='true'></i> ใช้วัตถุดิบ</a>";
                                    }
                                }
                                return data
                            }},
                            {sClass: "hide_column", data: 'material_no', render: function(data, type ,row, meta){
                                if(type === 'display'){
                                    if(row.sts_ordering == 1){
                                        data = "<a class='btn btn-block btn-danger btn-sm disabled' href='javascript:;' onclick='changests_ordering("+data+")'><i class='fa fa-exclamation' aria-hidden='true'></i> แจ้งสั่งซื้อ</a>";
                                    }else{
                                        data = "<a class='btn btn-block btn-danger btn-sm' href='javascript:;' onclick='changests_ordering("+data+")'><i class='fa fa-exclamation' aria-hidden='true'></i> แจ้งสั่งซื้อ</a>";
                                    }
                                }
                                return data
                            }},
                        ],
                initComplete: function () {
                    if(pmid == 4){
                        materialtable.column(4).visible(false);
                    }else if(pmid == 3){
                        materialtable.column(5).visible(false);
                        materialtable.column(6).visible(false);
                    }
                }
        });
    });

    function add (material_no) {
        let option = ''
        $.ajax({
            type: 'get',
            url: 'getdetailforaddmt/'+ material_no
        }).done(function (data){
            $('#add_modal').modal('show')            
            $.each(data, function (k, v){
                option += '<option value='+ v.sup_no + '>' +v.sup_name+'</option>'
            })
            $('#add_modal #headmaterial').empty()
            $('#add_modal .modal-footer').empty()
            $('#add_modal #sup').empty()
            $('#add_modal #qty').val('')
            $('#add_modal #unitprice').val('')
            $('#add_modal #price').val('')
            $('#add_modal #headmaterial').append('เพิ่มวัตถุดิบ')
            $('#add_modal .modal-footer').append(`<button type="button" class="btn btn-primary" onclick="saveadd(`+material_no+`)">บันทึก</button>
                                    <button type="button" class="btn btn-secondary" data-dismiss="modal">ยกเลิก</button>`)
            $('#add_modal #sup').append(option)
        })
    }

    function sum () {
        let qty, unitprice, sum
        qty = $('#add_modal #qty').val()
        unitprice = $('#add_modal #unitprice').val()
        sum = unitprice * qty
        $('#add_modal #price').val(accounting.formatNumber(sum, 2))
    }

    function saveadd(material_no) {
        $.ajax({
            type: 'POST',
            url: 'managematerial',
            data: {
                'material_no': material_no,
                'sup_no': $('#add_modal #sup').val(),
                'unitprice': $('#add_modal #unitprice').val(),
                'qty': $('#add_modal #qty').val(),
            }
        }).done(function(data){
            if(data == 'success') 
                swal({
                    position: 'top-end',
                    type: 'success',
                    title: 'บันทึกข้อมูลสำเร็จ',
                    showConfirmButton: false,
                    timer: 1000
                })
            $('#add_modal').modal('hide')
            $('#materialmn-table').DataTable().ajax.reload()
        }); 
    }

    function use (material_no, max) {
        $('#use_modal').modal('show')            
        $('#use_modal #headmaterial').empty()
        $('#use_modal .modal-footer').empty()
        $('#use_modal #useunit').val('')
        $('#use_modal #useunit').attr('max', max)
        $('#use_modal #headmaterial').append('ใข้วัตถุดิบ')
        $('#use_modal .modal-footer').append(`<button type="button" class="btn btn-primary" onclick="saveuse(`+material_no+`)">บันทึก</button>
                                <button type="button" class="btn btn-secondary" data-dismiss="modal">ยกเลิก</button>`)
    }

    function chk () {
        let val, max
        val = $('#use_modal #useunit').val()
        max = document.getElementById("useunit").max;
        if (parseInt(val) > parseInt(max)){
            swal({
                type: 'error',
                title: 'ผิดพลาด..',
                text: 'คุณไม่สามารถใช้วัตถุดิบเกินจำนวนที่มีได้',
            })
            $('#use_modal #useunit').val(max)
        }
    }

    function saveuse (material_no){
        $.ajax({
            type: 'POST',
            url: 'managematerialuse',
            data: {
                'material_no': material_no,
                'use_qty': $('#use_modal #useunit').val(),
            }
        }).done(function (data) {
            if(data == 'success') 
                swal({
                    position: 'top-end',
                    type: 'success',
                    title: 'บันทึกข้อมูลสำเร็จ',
                    showConfirmButton: false,
                    timer: 1000
                })
            $('#use_modal').modal('hide')
            $('#materialmn-table').DataTable().ajax.reload()
        })
    }

    function changests_ordering (material_no) {
        swal({
            title: 'คุณต้องการแจ้งการสั่งซื้อวัตถุดิบไปยังพนักงานขาย ?',
            type: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'ใช่',
            cancelButtonText: 'ยกเลิก'
        }).then((result) => {
            if (result.value) {
                $.ajax({
                    type: 'get',
                    url: 'changestsordetm/'+ material_no
                }).done(function (data){
                    if(data == 'success'){
                        swal(
                        'เรียบร้อย!',
                        'ทำการแจ้งการสั่งซื้อวัตถุดิบเรียบร้อยแล้ว',
                        'success'
                        )
                        $('#materialmn-table').DataTable().ajax.reload()
                    }
                })
            }
        })
        
    }
</script>
@stop