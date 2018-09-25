@extends('admin')
@section('content')
@section('css')
@stop
<div class="container-fluid col-12">
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
                                }
                            },
                        ]
        });
    });

</script>
@stop