@extends('admin')
@section('content')
@section('css')
@stop
<div class="container-fluid col-12">
    <div class="row">
        <div class="form-group">
            <a href="/requirequotation/create" style="margin-left: 20px;"><i class="fa fa-cart-plus"></i> เพิ่มคำขอใบเสนอราคา</a>
        </div>
    </div>
    <div class="row">
        <div class="col-12">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">คำขอใบเสนอราคา</h3>
            </div>
            <!-- /.card-header -->
            <div class="card-body">
                <table id="producttype-table" class="table table-bordered table-hover">
                    <thead>
                        <tr>
                            <th>รหัสคำขอใบเสนอราคา</th>
                            <th>สถานะคำขอ</th>
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
        $(".text-dark").append('ประเภทสินค้า');
        var usertable = $('#producttype-table').DataTable({
            processing: true,
            ajax: {
                    type: 'GET',
                    url: '{{ url("/getproducttypelist") }}',
                },
            columns:    [
                            {data: 'type_no', name: 'type_no'},
                            {data: 'type_name', name: 'type_name'},
                            {data: 'active', name: 'active'}
                        ]
        });
    });

</script>
@stop