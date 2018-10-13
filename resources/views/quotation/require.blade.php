@extends('admin')
@section('content')
@section('css')
@stop
<div class="container-fluid col-12">
    <form action="/requirequotation" method="POST" accept-charset="utf-8" enctype="multipart/form-data">
        {{ csrf_field() }}
        <div class="card card-default">
            <div class="card-header">
                <h3 class="card-title">เพิ่มคำขอใบเสนอราคา</h3>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="form-group col-10">
                        <label>รายละเอียด</label>
                        <textarea class="form-control" name="re_detail" rows="3" placeholder="" required></textarea>
                    </div>
                </div>
                <div class="row">
                    <div class="form-group col-4">
                        <label for="file">อัพโหลดไฟล์</label>
                        <div class="input-group">
                            <input type="file" class="form-control-file" name="requofile">
                        </div>
                    </div>
                </div>
                @if(count($errors) > 0)
                <div class="alert alert-danger">
                    Upload Validation Error <br><br>
                    <ul>
                        @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
                @endif
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label>เลือกประเภทสินค้าที่ต้องการ</label>
                            <select class="form-control select2" id="re_type" multiple="multiple"
                                    style="width: 100%;" name="re_type[]">
                                @foreach ($type as $t)
                                    <option value={{ $t->type_no }} > {{ $t->type_name }} </option>
                                @endforeach
                            </select>
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
    $(document).ready(function () {
        $('.select2').select2()
        $(".text-dark").append('คำขอใบเสนอราคา');
    });

</script>
@stop