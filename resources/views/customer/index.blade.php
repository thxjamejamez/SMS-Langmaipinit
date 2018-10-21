@extends('admin')
@section('content')
@section('css')
<meta name="csrf-token" content="{{ csrf_token() }}">
@stop
<div class="container-fluid col-12">
    <div class="row">
        <div class="col-sm-12">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">ข้อมูลสมาชิก</h3>
            </div>
            <!-- /.card-header -->
            <div class="card-body">
                <table id="user-table" class="table table-hover table-bordered dt-responsive nowrap" style="width:100%">
                    <thead>
                        <tr>
                            <th>รหัสผู้ใช้</th>
                            <th>ชื่อผู้ใช้</th>
                            <th>ชื่อ</th>
                            <th>นามสกุล</th>
                            <th>อีเมล์</th>
                            <th>สิทธิ์ในการเข้าถึง</th>
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
        var usertable = $('#user-table').DataTable({
            processing: true,
            ajax: {
                    type: 'GET',
                    url: '/getcustlist',
                },
            columns:    [
                            {data: 'id', render: function(data, type ,row, meta){
                                if(type === 'display'){
                                    data = 'U'+numeral(data).format('0000');
                                }
                                return data
                            }},
                            {data: 'username', name: 'username'},
                            {data: 'first_name', name: 'first_name'},
                            {data: 'last_name', name: 'last_name'},
                            {data: 'email', name: 'email'},
                            {data: 'permission_name', name: 'permission_name'},
                            {data: 'id', render: function(data, type ,row, meta){
                                    if(type === 'display'){
                                        if(row.permission_id < 6){
                                            data = '<a href=employee/'+ data +'/edit class="btn btn-block btn-info btn-sm"><i class="fa fa-search" aria-hidden="true"></i> เรียกดู</a>';
                                        }else{
                                            data = '<a href=user/'+ data +'/edit class="btn btn-block btn-info btn-sm"><i class="fa fa-search" aria-hidden="true"></i> เรียกดู</a>';
                                        }
                                    }
                                    return data;
                                }}
                        ],
        });
    });

</script>
@stop