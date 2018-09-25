@extends('admin')
@section('content')
@section('css')
@stop
<div class="container-fluid">

    <form action=@if(isset($editsupplier)) "/materialseller/{{$editsupplier->sup_no}}" @else "/materialseller" @endif method="POST" accept-charset="utf-8">
    @if(isset($editsupplier))
        <input name="_method" type="hidden" value="PUT">
    @endif
    {{ csrf_field() }}
    <div class="card card-default">
        <div class="card-header">
            <h3 class="card-title">จัดการข้อมูลผู้ขายวัตถุดิบ</h3>
        </div>
            <div class="card-body">
                <div class="row">
                    <div class="form-group col-3">
                        <label for="sup_name">ชื่อบริษัท</label>
                        <input id="sup_name" type="text" class="form-control" name="sup_name" value="@if(isset($editsupplier->sup_name)) {{ $editsupplier->sup_name }} @endif">
                    </div>
                </div>
                <div class="row">
                    <div class="form-group col-5">
                        <label>ที่อยู่</label>
                        <textarea class="form-control" rows="1" name="address">@if(isset($editsupplier->address)) {{ $editsupplier->address }} @endif</textarea>
                    </div>
                </div>
                <div class="row">
                    <div class="form-group col-2">
                        <label>เบอร์โทรศัพท์</label>
                            <div class="input-group">
                            <div class="input-group-prepend">
                                <span class="input-group-text"><i class="fa fa-phone"></i></span>
                            </div>
                            <input type="text" name="tel" class="form-control" data-inputmask='"mask": "(999) 999-9999"' data-mask value="@if(isset($editsupplier->tel)) {{ $editsupplier->tel }} @endif">
                        </div>
                    </div>
                    <div class="form-group col-3">
                        <label>อีเมล์</label>
                        <div class="input-group mb-3">
                            <div class="input-group-prepend">
                                <span class="input-group-text"><i class="fa fa-envelope"></i></span>
                            </div>
                            <input type="email" name="email" class="form-control" placeholder="example@hotmail.com" value="@if(isset($editsupplier->email)) {{ $editsupplier->email }} @endif" required>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label>ประเภทสินค้าที่ขาย</label>
                            <select class="form-control select2" id="mt_type" multiple="multiple"
                                    style="width: 100%;" name="mt_type[]">
                                @foreach ($type as $t)
                                    <option value={{ $t->type_no }} @if(isset($editsuppliertype)) @if(in_array($t->type_no, explode(',', $editsuppliertype->type_no))) selected @endif @endif > {{ $t->type_name }} </option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                </div>
            <div class="card-footer">
                <div class="row">
                    <div class="col-1">
                        <button type="submit" class="btn btn-block btn-outline-primary btn-sm">บันทึก</button>
                    </div>
                    <div class="col-1">
                        <button type="reset" onclick="window.history.go(-1)" class="btn btn-block btn-outline-danger btn-sm">ยกเลิก</button>
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
        $('[data-mask]').inputmask()

    })
</script>
@stop