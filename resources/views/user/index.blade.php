@extends('admin')
@section('content')
@section('css')
@stop
<div class="container-fluid col-12">
    <div class="row">
        <div class="form-group">
            <a href="/employee/create" style="margin-left: 20px;"><i class="fa fa-user-plus"></i> เพิ่มผู้ใช้ (พนักงาน)</a>
        </div>
        <div class="form-group">
            <a href="/user/create" style="margin-left: 20px;"><i class="fa fa-user-plus"></i> เพิ่มผู้ใช้ (ผู้ใช้ทั่วไป)</a>
        </div>
    </div>
    <div class="row">
        <div class="col-12">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">ข้อมูลผู้ใช้</h3>
            </div>
            <!-- /.card-header -->
            <div class="card-body">
                <table id="user-table" class="table table-bordered table-hover">
                    <thead>
                        <tr>
                            <th>รหัสผู้ใช้</th>
                            <th>ชื่อผู้ใช้</th>
                            <th>ชื่อ</th>
                            <th>นามสกุล</th>
                            <th>อีเมล์</th>
                            <th>สิทธิ์ในการเข้าถึง</th>
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
        $(".text-dark").append('ข้อมูลผู้ใช้');
        var usertable = $('#user-table').DataTable({
            processing: true,
            ajax: {
                    type: 'GET',
                    url: '{{ url("/getuserlist") }}',
                    // success: function(data){
                    //     console.log(data)
                    // },
                    // data: function(d){
                    //     // d.showinactive= $('#showinactive').val();
                    // },
                },
            columns:    [
                            {data: 'id', name: 'id'},
                            {data: 'username', name: 'username'},
                            {data: 'first_name', name: 'first_name'},
                            {data: 'last_name', name: 'last_name'},
                            {data: 'email', name: 'email'},
                            {data: 'permission_name', name: 'permission_name'},
                        ]
        });
    });

</script>
@stop