@extends('admin')
@section('content')
@section('css')
@stop
<div class="container-fluid col-12">
    <div class="row">
        <div class="form-group col-3">
            <button type="button" class="btn btn-primary" onclick="add()"><i class="fa fa-codepen"></i> เพิ่มประเภทวัตถุดิบ</button>
        </div>
    </div>
    <div class="row">
        <div class="col-sm-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">ประเภทวัตถุดิบ</h3>
                </div>
                <div class="card-body">
                    <table id="materialtype-table" class="table table-hover table-bordered dt-responsive nowrap" style="width:100%">
                        <thead>
                            <tr>
                                <th>รหัสประเภทวัตถุดิบ</th>
                                <th>ชื่อประเภทวัตถุดิบ</th>
                                <th style="width: 10px"></th>
                                <th style="width: 10px"></th>
                            </tr>
                        </thead>
                    </table>
                </div>
            </div>
        </div>
    </div>

    {{-- modal --}}
    <div class="modal fade" id="materialtype_modal" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-sm">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="headmaterialtype">เพิ่มข้อมูลประเภทวัตถุดิบ</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <label for="materialtype_N">ชื่อประเภทวัตถุดิบ</label>
                        <input id="materialtype_N" type="text" class="form-control" name="materialtype_N" value="555">
                    </div>
                </div>
                <div class="modal-footer">
                </div>
            </div>
        </div>
    </div>
</div>
@stop
@section('script')
<script type="text/javascript">
    $(document).ready(function () {
        var materialtypetable = $('#materialtype-table').DataTable({
            processing: true,
            ajax: {
                    type: 'GET',
                    url: '{{ url("/getmaterialtype") }}',
                },
            columns:    [
                            {data: 'type_no', render: function(data, type ,row, meta){
                                if(type === 'display'){
                                    data = 'MT'+numeral(data).format('000000');
                                }
                                return data
                            }},
                            {data: 'type_name', name: 'type_name'},
                            {data: 'type_no', render: function(data, type ,row, meta){
                                if(type === 'display'){
                                    data = "<a class='btn btn-block btn-info btn-sm' href='javascript:;' onclick='edit("+data+")'><i class='fa fa-pencil-square-o' aria-hidden='true'></i> แก้ไข</a>";
                                }
                                return data
                            }},
                            {data: 'type_no', render: function(data, type ,row, meta){
                                if(type === 'display'){
                                    data = "<a class='btn btn-block btn-danger btn-sm' href='javascript:;' onclick='del("+data+")'><i class='fa fa-trash' aria-hidden='true'></i> ลบ</a>";
                                }
                                return data
                            }},
                        ],
        });
    });

    function add () {
        $('#materialtype_modal').modal('show')
        $('#headmaterialtype').empty()
        $('.modal-footer').empty()
        $('#materialtype_N').val('')
        $('#headmaterialtype').append('เพิ่มข้อมูลประเภทวัตถุดิบ')
        $('.modal-footer').append(`<button type="button" class="btn btn-primary" onclick="save()">บันทึก</button>
                                <button type="button" class="btn btn-secondary" data-dismiss="modal">ยกเลิก</button>`)
    }

    function save () {
        $.ajax({
            type: 'POST',
            url: '/materialtype',
            data: {
                'type_name': $('#materialtype_N').val(),
            }
        }).done(function(data){
            if(data == 'success') 
                swal({
                    position: 'top-end',
                    type: 'success',
                    title: 'บันทึกข้อมูลสำเร็จ',
                    showConfirmButton: false,
                    timer: 1000
                })
            $('#materialtype_modal').modal('hide')
            $('#materialtype-table').DataTable().ajax.reload()
        }); 
    }

    function edit (type_no){
        $('#materialtype_modal').modal('show')      
        $.ajax({
            type: 'GET',
            url: '/materialtype/' + type_no,
        }).done(function (data){
            $('.modal-footer').empty()
            $('#headmaterialtype').empty()
            $('#materialtype_N').empty()
            $('#headmaterialtype').append('แก้ไขข้อมูลประเภทวัตถุดิบ')
            $('.modal-footer').append(`<button type="button" class="btn btn-primary" onclick="update(`+ data.type_no +`)">บันทึก</button>
                                <button type="button" class="btn btn-secondary" data-dismiss="modal">ยกเลิก</button>`)
            $('#materialtype_N').val(data.type_name)
        })
    }

    function update (type_no) {
        $.ajax({
            type: 'PUT',
            url: 'materialtype/' + type_no,
            data: {
                'type_name': $('#materialtype_N').val(),
            }
        }).done(function (data){
            if(data == 'success') 
                swal({
                    position: 'top-end',
                    type: 'success',
                    title: 'บันทึกข้อมูลสำเร็จ',
                    showConfirmButton: false,
                    timer: 1000
                })
            $('#materialtype_modal').modal('hide')
            $('#materialtype-table').DataTable().ajax.reload()
        })
    }

    function del (type_no) {
        swal({
            title: 'คุณต้องการลบข้อมูลนี้ ?',
            text: "หากคุณลบข้อมูลนี้ คุณจะไม่สามารถกู้คืนได้",
            type: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'ตกลง',
            cancelButtonText: 'ยกเลิก'
        }).then((result) => {
            if (result.value) {
                $.ajax({
                    type: 'DELETE',
                    url: 'materialtype/' + type_no
                }).done(function (data){
                    if(data == 'success')
                        swal(
                        'ลบข้อมูลเรียบร้อยแล้ว!',
                        '',
                        'success'
                        )
                    $('#materialtype-table').DataTable().ajax.reload();
                })
            }
        })
    }

</script>
@stop