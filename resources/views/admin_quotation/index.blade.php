@extends('admin')
@section('content')
@section('css')
@stop
<div class="container-fluid col-12">
    <div class="row">
        <div class="col-12">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">ใบเสนอราคา</h3>
            </div>
            <!-- /.card-header -->
            <div class="card-body">
                <table id="requotataion-table" class="table table-bordered table-hover">
                    <thead>
                        <tr>
                            <th>รหัสคำขอใบเสนอราคา</th>
                            <th>รหัสลูกค้า</th>
                            <th>สถานะคำขอ</th>
                            <th style="width: 10px;"></th>
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
        $(".text-dark").append('ใบเสนอราคา');
        var usertable = $('#requotataion-table').DataTable({
            processing: true,
            ajax: {
                    type: 'GET',
                    url: '{{ url("/getquotationlist") }}',
                },
            columns:    [
                            {data: 'require_no', name: 'require_no'},
                            {data: 'users_id', name: 'users_id'},
                            {data: 'sts_name', name: 'sts_name'},
                            {data: 'require_no', render: function(data, type ,row, meta){
                                    if(type === 'display'){
                                        data = '<a class="btn btn-block btn-info btn-sm" href=quotation/'+ data +'/edit><i class="fa fa-check-square-o"> จัดการใบเสนอราคา </a>';
                                    }
                                    return data;
                                }
                            },
                        ]
        });
    });

</script>
@stop