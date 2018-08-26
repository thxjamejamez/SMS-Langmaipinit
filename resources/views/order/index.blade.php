@extends('admin')
@section('content')
@section('css')
@stop
<div class="container-fluid col-12">
    <div class="row">
        <div class="form-group">
            <a href="/requireorder/create" style="margin-left: 20px;"><i class="fa fa-file-o"></i> เพิ่มการสั่งซื้อ</a>
        </div>
    </div>
    <div class="row">
        <div class="col-sm-12">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">คำขอใบเสนอราคา</h3>
            </div>
            <!-- /.card-header -->
            <div class="card-body">
                <table id="requotataion-table" class="table table-hover table-bordered dt-responsive nowrap" style="width:100%">
                    <thead>
                        <tr>
                            <th>เลขที่การสั่งซื้อ</th>
                            <th>วันที่สั่งซื้อ</th>
                            <th>สถานะการสั่งซื้อ</th>
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
        $(".text-dark").append('การสั่งซื้อ');
        var usertable = $('#reorder-table').DataTable({
            processing: true,
            ajax: {
                    type: 'GET',
                    url: '{{ url("/getrequirorderlist") }}',
                },
            columns:    [
                            {data: 'require_no', name: 'require_no'},
                            {data: 'sts_name', name: 'sts_name'},
                            {data: 'require_no', render: function(data, type ,row, meta){
                                    if(type === 'display'){
                                        if(row.sts_id == 2){
                                            data = '<a href=requirequotation/'+ data +'/edit><i class="fa fa-search"> เรียกดู</a>';
                                        }else{
                                            data = '<i class="fa fa-search"> เรียกดู';
                                        }
                                    }
                                    return data;
                                }
                            },
                        ]
        });
    });

</script>
@stop