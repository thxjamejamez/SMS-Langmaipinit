@extends('admin')
@section('content')
@section('css')
@stop
<div class="container-fluid col-12">
    <div class="row">
        <div class="form-group">
            <a href="/materialseller/create" style="margin-left: 20px;"><i class="fa fa-user-plus"></i> เพิ่มข้อมูลผู้ขายวัตถุดิบ</a>
        </div>
    </div>
    <div class="row">
        <div class="col-sm-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">ข้อมูลผู้ขายวัตถุดิบ</h3>
                </div>
                <div class="card-body">
                    <table id="supplier-table" class="table table-hover table-bordered dt-responsive nowrap" style="width:100%">
                        <thead>
                            <tr>
                                <th>รหัสผู้ขาย</th>
                                <th>ชื่อผู้ขาย</th>
                                <th>อีเมล์</th>
                                <th>เบอร์โทร</th>
                                <th style="width: 10px"></th>
                                <th style="width: 10px"></th>
                            </tr>
                        </thead>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
@stop

@section('script')
<script type="text/javascript">
    $(document).ready(function () {
        var suppliertable = $('#supplier-table').DataTable({
            processing: true,
            ajax: {
                    type: 'GET',
                    url: '/getsupplier',
                },
            columns:    [
                            {data: 'sup_no', render: function(data, type ,row, meta){
                                if(type === 'display'){
                                    data = 'SP'+numeral(data).format('000000');
                                }
                                return data
                            }},
                            {data: 'sup_name', name: 'sup_name'},
                            {data: 'email', name: 'email'},
                            {data: 'tel', name: 'tel'},
                            {data: 'sup_no', render: function(data, type ,row, meta){
                                if(type === 'display'){
                                    data = "<a class='btn btn-block btn-info btn-sm' href='materialseller/"+data+"'><i class='fa fa-pencil-square-o' aria-hidden='true'></i> แก้ไข</a>";
                                }
                                return data
                            }},
                            {data: 'sup_no', render: function(data, type ,row, meta){
                                if(type === 'display'){
                                    data = "<a class='btn btn-block btn-danger btn-sm' href='javascript:;' onclick='del("+data+")'><i class='fa fa-trash' aria-hidden='true'></i> ลบ</a>";
                                }
                                return data
                            }},
                        ],
        });
    })

    function del (material_no) {
        swal({
            title: 'คุณต้องการลบข้อมูลนี้ ?',
            text: "หากคุณลบข้อมูลนี้ คุณจะไม่สามารถกู้คืนได้",
            type: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'ตกลง',
            cancelButtonText: 'ยกเลิก'
        }).then((result) => {
            if (result.value) {
                $.ajax({
                    type: 'DELETE',
                    url: 'materialseller/' + material_no
                }).done(function (data){
                    if(data == 'success')
                        swal(
                        'ลบข้อมูลเรียบร้อยแล้ว!',
                        '',
                        'success'
                        )
                    $('#supplier-table').DataTable().ajax.reload();
                })
            }
        })
    }

</script>
@stop