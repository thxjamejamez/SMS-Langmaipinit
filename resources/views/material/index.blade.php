@extends('admin')
@section('content')
@section('css')
@stop
<div class="container-fluid col-12">
    <div class="row">
        <div class="form-group col-3">
            <button type="button" class="btn btn-primary" onclick="add()"><i class="fa fa-codepen"></i> เพิ่มวัตถุดิบ</button>
        </div>
    </div>
    <div class="row">
        <div class="col-sm-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">วัตถุดิบ</h3>
                </div>
                <div class="card-body">
                    <table id="material-table" class="table table-hover table-bordered dt-responsive nowrap" style="width:100%">
                        <thead>
                            <tr>
                                <th>รหัสวัตถุดิบ</th>
                                <th>ชื่อวัตถุดิบ</th>
                                <th>ประเภทวัตถุดิบ</th>
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
    <div class="modal fade" id="material_modal" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="headmaterial"></h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="form-group name">
                        <label for="material_N">ชื่อวัตถุดิบ</label>
                        <input id="material_N" type="text" class="form-control" name="material_N">
                    </div>
                    <div class="form-group type">
                        <label>ประเภทวัตถุดิบ</label>
                        <select class="form-control" id="material_type"></select>
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
        var materialtable = $('#material-table').DataTable({
            processing: true,
            ajax: {
                    type: 'GET',
                    url: '{{ url("/getmaterial") }}',
                },
            columns:    [
                            {data: 'material_no', render: function(data, type ,row, meta){
                                if(type === 'display'){
                                    data = 'M'+numeral(data).format('000000');
                                }
                                return data
                            }},
                            {data: 'material_name', name: 'material_name'},
                            {data: 'type_name', name: 'type_name'},
                            {data: 'material_no', render: function(data, type ,row, meta){
                                if(type === 'display'){
                                    data = "<a class='btn btn-block btn-info btn-sm' href='javascript:;' onclick='edit("+data+")'><i class='fa fa-pencil-square-o' aria-hidden='true'></i> แก้ไข</a>";
                                }
                                return data
                            }},
                            {data: 'material_no', render: function(data, type ,row, meta){
                                if(type === 'display'){
                                    data = "<a class='btn btn-block btn-danger btn-sm' href='javascript:;' onclick='del("+data+")'><i class='fa fa-trash' aria-hidden='true'></i> ลบ</a>";
                                }
                                return data
                            }},
                        ],
        });
    });

    function add () {
        let option = ''
        $.ajax({
            type: 'get',
            url: 'getmaterialtype'
        }).done(function (data){
            $.each(data.data, function (k, v){
                option += '<option value='+ v.type_no + '>' +v.type_name+'</option>'
            })
            $('#material_modal').modal('show')
            $('#headmaterial').empty()
            $('.modal-footer').empty()
            $('#material_type').empty()
            $('#material_N').val('')
            $('#headmaterial').append('เพิ่มข้อมูลวัตถุดิบ')
            $('.modal-footer').append(`<button type="button" class="btn btn-primary" onclick="save()">บันทึก</button>
                                    <button type="button" class="btn btn-secondary" data-dismiss="modal">ยกเลิก</button>`)
            $('#material_type').append(option)
        })
    }

    function save () {
        $.ajax({
            type: 'POST',
            url: 'material',
            data: {
                'material_name': $('#material_N').val(),
                'material_type': $('#material_type').val(),
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
            $('#material_modal').modal('hide')
            $('#material-table').DataTable().ajax.reload()
        }); 
    }

    function edit (material_no){
        $('#material_modal').modal('show')      
        $.ajax({
            type: 'GET',
            url: '/material/' + material_no,
        }).done(function (data){
            let option, selected = ''
            $.each(data.type, function (k, v){
                selected = (data.detail.type_no == v.type_no)? 'selected':'' 
                option += '<option value='+ v.type_no +' ' + selected + '>' +v.type_name+'</option>'
            })
            $('.modal-footer').empty()
            $('#headmaterial').empty()
            $('#material_N').empty()
            $('#material_type').empty()
            $('#headmaterial').append('แก้ไขข้อมูลวัตถุดิบ')
            $('.modal-footer').append(`<button type="button" class="btn btn-primary" onclick="update(`+ data.detail.material_no +`)">บันทึก</button>
                                <button type="button" class="btn btn-secondary" data-dismiss="modal">ยกเลิก</button>`)
            $('#material_N').val(data.detail.material_name)
            $('#material_type').append(option)
        })
    }

    function update (material_no) {
        $.ajax({
            type: 'PUT',
            url: 'material/' + material_no,
            data: {
                'material_name': $('#material_N').val(),
                'material_type': $('#material_type').val(),
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
            $('#material_modal').modal('hide')
            $('#material-table').DataTable().ajax.reload()
        })
    }

    function del (material_no) {
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
                    url: 'material/' + material_no
                }).done(function (data){
                    if(data == 'success')
                        swal(
                        'ลบข้อมูลเรียบร้อยแล้ว!',
                        '',
                        'success'
                        )
                    $('#material-table').DataTable().ajax.reload();
                })
            }
        })
    }

</script>
@stop