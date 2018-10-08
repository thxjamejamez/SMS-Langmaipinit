@extends('admin')
@section('content')
@section('css')
@stop
<div class="container-fluid col-12">
    @if(Session::has('massage'))
        <input class="alert" type="hidden" value="{{ Session::get('massage') }}">
    @endif
    <div class="row">
        <div class="form-group">
            <a href="/producttype/create" style="margin-left: 20px;"><i class="fa fa-cart-plus"></i> เพิ่มประเภทสินค้า</a>
        </div>
    </div>
    <div class="row">
        <div class="col-sm-12">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">ประเภทสินค้า</h3>
            </div>
            <!-- /.card-header -->
            <div class="card-body">
                <table id="producttype-table" class="table table-hover table-bordered dt-responsive nowrap" style="width:100%">
                    <thead>
                        <tr>
                            <th>รหัสประเภทสินค้า</th>
                            <th>ชื่อประเภทสินค้า</th>
                            <th style="width: 10px"></th>
                            <th style="width: 10px"></th>                            
                        </tr>
                    </thead>
                </table>
            </div>
            <!-- /.card-body -->
        </div>
        </div>
    </div>
</div>
@stop

@section('script')
<script type="text/javascript">
    $(document).ready(function () {
        if($('.alert').val() == 'Inserted'){
            swal({
                position: 'top-end',
                type: 'success',
                title: 'บันทึกข้อมูลสำเร็จ',
                showConfirmButton: false,
                timer: 1500
            })
        }else if($('.alert').val() == 'Updated'){
            swal({
                position: 'top-end',
                type: 'success',
                title: 'เปลี่ยนแปลงข้อมูลสำเร็จ',
                showConfirmButton: false,
                timer: 1500
            })
        }
        $(".text-dark").append('ประเภทสินค้า');
        var usertable = $('#producttype-table').DataTable({
            processing: true,
            ajax: {
                    type: 'GET',
                    url: '{{ url("/getproducttypelist") }}',
                },
            columns:    [
                            {data: 'type_no', render: function(data, type ,row, meta){
                                if(type === 'display'){
                                    data = 'PT'+numeral(data).format('000000');
                                }
                                return data;
                            }},
                            {data: 'type_name', name: 'type_name'},
                            {data: 'type_no', render: function(data, type ,row, meta){
                                if(type === 'display'){
                                    data = "<a class='btn btn-block btn-primary btn-sm' href='/producttype/"+data+"/edit'><i class='fa fa-pencil' aria-hidden='true'></i> แก้ไข</a>";
                                }
                                return data;
                            }},
                            {data: 'type_no', render: function(data, type ,row, meta){
                                if(type === 'display'){
                                        data = '<button class="btn btn-block btn-danger btn-sm" onclick="del('+data+')"><i class="fa fa-trash" aria-hidden="true"></i> ลบ</button>';
                                }
                                return data;
                            }},
                        ]
        });
    });

    function del (type_no){
        const swalWithBootstrapButtons = swal.mixin({
            confirmButtonClass: 'btn btn-success',
            cancelButtonClass: 'btn btn-danger',
            buttonsStyling: false,
            })

        swalWithBootstrapButtons({
            title: 'แน่ใจหรือ?',
            text: "คุณต้องการลบข้อมูลประเภทสินค้าฟ",
            type: 'warning',
            showCancelButton: true,
            confirmButtonText: 'ใช่',
            cancelButtonText: 'ไม่ใช่',
            reverseButtons: true
        }).then((result) => {
            if (result.value) {
                $.ajax({
                    type: 'DELETE',
                    url: '/producttype/'+type_no
                }).done(function (data){
                    if(data == 'success'){
                        swalWithBootstrapButtons(
                            'ลบประเภทสินค้าเรียบร้อยแล้ว',
                            '',
                            'success'
                        )
                        $('#producttype-table').DataTable().ajax.reload();
                    }
                })
            } else if (
                result.dismiss === swal.DismissReason.cancel
            ) {
                swalWithBootstrapButtons(
                'ยกเลิก',
                'ยกเลิกการลบประเภทสินค้าแล้ว',
                'error'
                )
            }
        })
    }

</script>
@stop