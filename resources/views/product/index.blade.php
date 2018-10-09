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
            <a href="/product/create" style="margin-left: 20px;"><i class="fa fa-cart-plus"></i> เพิ่มสินค้า</a>
        </div>
    </div>
    <div class="row">
        <div class="col-sm-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">สินค้า</h3>
                </div>
                <!-- /.card-header -->
                <div class="card-body">
                    <table id="product-table" class="table table-hover table-bordered dt-responsive nowrap" style="width:100%">
                        <thead>
                            <tr>
                                <th>รหัสสินค้า</th>
                                <th>ประเภทสินค้า</th>
                                <th>ชื่อสินค้า</th>
                                <th>ขนาดสินค้า</th>
                                <th>ราคาสินค้า</th>
                                <th></th>
                                <th></th>
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
        $(".text-dark").append('สินค้า');
        var usertable = $('#product-table').DataTable({
            processing: true,
            ajax: {
                    type: 'GET',
                    url: '{{ url("/getproductlist") }}',
                },
            columnDefs: [
                            { className: "text-right", "targets": [4] }
                        ],
            columns:    [
                            {data: 'product_no', render: function(data, type ,row, meta){
                                if(type === 'display'){
                                    data = 'PD'+numeral(data).format('000000');
                                }
                                return data
                            }},
                            {data: 'type_name', name: 'type_name'},
                            {data: 'product_name', name: 'product_name'},
                            {data: 'product_size', name: 'product_size'},
                            {data: 'product_price', render: function(data, type ,row, meta){
                                if(type === 'display'){
                                    data = accounting.formatNumber(data, 2);
                                }
                                return data;
                            }},
                            {data: 'product_no', render: function(data, type ,row, meta){
                                if(type === 'display'){
                                    data = "<a class='btn btn-block btn-primary btn-sm' href='/product/"+data+"/edit'><i class='fa fa-pencil' aria-hidden='true'></i> แก้ไข</a>";
                                }
                                return data;
                            }},
                            {data: 'product_no', render: function(data, type ,row, meta){
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
            text: "คุณต้องการลบข้อมูลประเภทสินค้า",
            type: 'warning',
            showCancelButton: true,
            confirmButtonText: 'ใช่',
            cancelButtonText: 'ไม่ใช่',
            reverseButtons: true
        }).then((result) => {
            if (result.value) {
                $.ajax({
                    type: 'DELETE',
                    url: '/product/'+type_no
                }).done(function (data){
                    if(data == 'success'){
                        swalWithBootstrapButtons(
                            'ลบประเภทสินค้าเรียบร้อยแล้ว',
                            '',
                            'success'
                        )
                        $('#product-table').DataTable().ajax.reload();
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