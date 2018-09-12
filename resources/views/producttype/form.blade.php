@extends('admin')
@section('content')
@section('css')
    <link href="/plugins/dropzone/dropzone.min.css" rel="stylesheet" type="text/css" />
    <style>
        .select2-container--default .select2-selection--single {
            height: 38px;
            padding: 9px 12px;
            background-color: #fff;
            border: 1px solid #aaa;
            border-radius: 4px; 
        }
    </style>

@stop

<div class="container-fluid">
    <form action="/producttype" method="POST" accept-charset="utf-8">
        {{ csrf_field() }}
        <div class="card card-default">
            <div class="card-header">
                <h3 class="card-title">จัดการข้อมูลประเภทสินค้า</h3>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="form-group col-2">
                        <label for="producttype_name">ชื่อประเภทสินค้า</label>
                        <input id="producttype_name" type="text" class="form-control" name="producttype_name" required>
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

    <div ></div>

    <form action="/file-upload" class="dropzone" id="jj">
        <div class="fallback">
          <input name="file" type="file" multiple />
        </div>
      </form>
</div>


@stop


@section('script')
<script src="/plugins/dropzone/dropzone.min.js"></script>
<script type="text/javascript">
$( document ).ready(function() {
    $("#jj").dropzone({ url: "/file/post" });
});
    
</script>
@stop