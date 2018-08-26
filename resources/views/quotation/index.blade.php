@extends('admin')
@section('content')
@section('css')
@stop
<div class="container-fluid col-12">
    <div class="row">
        <div class="form-group">
            <a href="/requirequotation/create" style="margin-left: 20px;"><i class="fa fa-file-o"></i> เพิ่มคำขอใบเสนอราคา</a>
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
                            <th>รหัสคำขอใบเสนอราคา</th>
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
        $(".text-dark").append('คำขอใบเสนอราคา');
        var usertable = $('#requotataion-table').DataTable({
            processing: true,
            ajax: {
                    type: 'GET',
                    url: '{{ url("/getrequirequotationlist") }}',
                },
            columns:    [
                            {data: 'require_no', name: 'require_no'},
                            {data: 'sts_name', name: 'sts_name'},
                            {data: 'require_no', render: function(data, type ,row, meta){
                                    if(type === 'display'){
                                        if(row.sts_id == 2){
                                            data = '<a class="btn btn-block btn-warning btn-sm" href=requirequotation/'+ data +'/edit><i class="fa fa-search"></i> เรียกดู</a>';
                                        }else{
                                            data = '<button class="btn btn-block btn-warning btn-sm" disabled><i class="fa fa-search"></i> เรียกดู</button>' ;
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