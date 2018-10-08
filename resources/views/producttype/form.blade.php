@extends('admin')
@section('content')
@section('css')
<style>
    img {
        border: 1px solid #ddd;
        border-radius: 4px;
        padding: 5px;
        width: 150px;
    }

    img:hover {
        box-shadow: 0 0 2px 1px rgba(0, 140, 186, 0.5);
    }

</style>

@stop

<div class="container-fluid">
    @if(isset($pdtype))
        <form action="/producttype/{{$pdtype->type_no}}" method="POST" accept-charset="utf-8" enctype="multipart/form-data">
        <input type="hidden" name="_method" value="PUT">
    @else
        <form action="/producttype" method="POST" accept-charset="utf-8" enctype="multipart/form-data">
    @endif
        {{ csrf_field() }}
        <div class="card card-default">
            <div class="card-header">
                <h3 class="card-title">ข้อมูลประเภทสินค้า</h3>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="form-group col-2">
                        <label for="producttype_name">ชื่อประเภทสินค้า</label>
                    <input id="producttype_name" type="text" class="form-control" name="producttype_name" required @if(isset($pdtype->type_name)) value="{{$pdtype->type_name}} @endif">
                    </div>
                    <div class="form-group col-4">
                        <label for="file">รูปภาพประเภทสินค้า</label>
                            <div class="input-group">
                                @if(isset($pdtype->type_file) && $pdtype->type_file != '')
                                    <a href="/file_producttype/{{$pdtype->type_file}}" target="_blank">
                                        <img src="/file_producttype/{{$pdtype->type_file}}">
                                    </a>
                                    <div class="form-group col-2">
                                        <a href="javascript:;" onclick="del_pic({{$pdtype->type_no}})" class="btn btn-block btn-danger btn-sm"><i class="fa fa-trash" aria-hidden="true"></i></a>
                                    </div>
                                @else
                                    <input type="file" class="form-control-file" name="pdtypefile">
                                @endif
                            </div> 
                    </div>
                </div>
            </div>
            <div class="card-footer">
                <div class="row">
                    <div class="col-1">
                        <button type="submit" class="btn btn-block btn-outline-primary btn-sm">บันทึก</button>
                    </div>
                    <div class="col-1">
                        <button type="reset" class="btn btn-block btn-outline-danger btn-sm">ยกเลิก</button>
                    </div>
                </div>
            </div>
        </div>
    </form> 
</div>


@stop


@section('script')
<script type="text/javascript">
$( document ).ready(function() {
    
});

function del_pic(type_no) {
    const swalWithBootstrapButtons = swal.mixin({
    confirmButtonClass: 'btn btn-success',
    cancelButtonClass: 'btn btn-danger',
    buttonsStyling: false,
    })

swalWithBootstrapButtons({
    title: 'แน่ใจหรือ?',
    text: "คุณต้องการจะลบรูปภาพ",
    type: 'warning',
    showCancelButton: true,
    confirmButtonText: 'ใช่',
    cancelButtonText: 'ไม่ใช่',
    reverseButtons: true
    }).then((result) => {
    if (result.value) {
        console.log('555');
        
        $.ajax({
            type: 'GET',
            url: '/delpictype/'+type_no
        }).done(function (data){
            if(data == 'success'){
                swalWithBootstrapButtons(
                    'ลบรูปภาพเรียบร้อยแล้ว',
                    '',
                    'success'
                )
                window.location.reload();
            }
        })
    } else if (
        result.dismiss === swal.DismissReason.cancel
    ) {
        swalWithBootstrapButtons(
        'ยกเลิก',
        'ยกเลิกการลบรูปภาพแล้ว',
        'error'
        )
    }
    })
}
    
</script>
@stop