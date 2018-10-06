@extends('admin')
@section('content')
@section('css')
<meta name="csrf-token" content="{{ csrf_token() }}">
@stop
<div class="container-fluid col-12">
    <div class="row">
        {{-- <div class="form-group">
            <a href="/employee/create" style="margin-left: 20px;"><i class="fa fa-user-plus"></i> เพิ่มผู้ใช้ (พนักงาน)</a>
        </div> --}}
    </div>
    <div class="row">
        <div class="col-sm-12">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">สิทธิ์ในการเข้าถึง</h3>
            </div>
            <!-- /.card-header -->
            <div class="card-body">
                <table id="permissions-table" class="table table-hover table-bordered dt-responsive nowrap" style="width:100%">
                    <thead>
                        <tr>
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
        var permissionstable = $('#permissions-table').DataTable({
            processing: true,
            ajax: {
                    type: 'GET',
                    url: '/getpermissionslist',
                },
            columns:    [
                            {data: 'permission_name', name: 'permission_name'},
                            {data: 'id', render: function (data, type ,row, meta){
                                if(type === 'display'){
                                    data = '<a href=permissions/'+ data +'/edit class="btn btn-block btn-info btn-sm"><i class="fa fa-pencil" aria-hidden="true"></i> จัดการ</a>';
                                }
                                return data
                            }},
                            // {data: 'id', render: function(data, type ,row, meta){
                            //         if(type === 'display'){
                            //             if(row.permissions_id < 6){
                            //                 data = '<a href=employee/'+ data +'/edit class="btn btn-block btn-info btn-sm"><i class="fa fa-pencil" aria-hidden="true"></i> แก้ไข</a>';
                            //             }else{
                            //                 data = '<a href=user/'+ data +'/edit class="btn btn-block btn-info btn-sm"><i class="fa fa-pencil" aria-hidden="true"></i> แก้ไข</a>';
                            //             }
                            //         }
                            //         return data;
                            //     }
                            // },
                            // {data: 'id', render: function(data, type ,row, meta){
                            //         if(type === 'display'){
                            //              data = '<button class="btn btn-block btn-danger btn-sm" onclick="del_user('+data+', '+row.permissions_id+')"><i class="fa fa-trash" aria-hidden="true"></i> ลบ</button>';
                            //         }
                            //         return data;
                            //     }
                            // },
                        ],
        });
    });

    function del_user(user_id, pm){
        swal({
            title: 'คุณต้องการลบข้อมูลผู้ใช้นี้ ?',
            type: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'ใช่',
            cancelButtonText: 'ยกเลิก'
            }).then((result) => {
            if (result) {
                $.ajax({
                    url: '/user/'+user_id,
                    type: 'DELETE',
                    headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
                    data: {
                        'pm': pm
                    },
                    success: function(data){
                        if(data=='success'){
                            swal(
                            'ลบข้อมูลเรียบร้อยแล้ว !',
                            'Your file has been deleted.',
                            'success'
                            );
                            $('#user-table').DataTable().ajax.reload();
                        }
                    }
                });
            }
        })
    }

</script>
@stop