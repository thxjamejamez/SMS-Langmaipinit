@extends('admin')
@section('content')
@section('css')
<style>
.select2-container--default .select2-selection--single {
    height: 38px;
    padding: 9px 12px;
    background-color: #fff;
    border: 1px solid #aaa;
    border-radius: 4px; }
</style>
@stop
<div class="container-fluid">
    @if(isset($editproduct))
        <form action="/product/{{$editproduct->product_no}}" method="POST" accept-charset="utf-8">
            <input type="hidden" name="_method" value="PUT">   
    @else
        <form action="/product" method="POST" accept-charset="utf-8">
    @endif
        {{ csrf_field() }}
        <div class="card card-default">
            <div class="card-header">
                <h3 class="card-title">จัดการข้อมูลสินค้า</h3>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="form-group col-2">
                        <label for="product_name">ชื่อสินค้า</label>
                        <input id="product_name" type="text" class="form-control" name="product_name" required @if(isset($editproduct->product_name)) value="{{$editproduct->product_name}} @endif">
                    </div>
                    <div class="form-group col-2">
                        <label>ประเภทสินค้า</label>
                        <select class="form-control" name="product_type">
                            @foreach($producttype as $producttypes)
                            <option value="{{ $producttypes->type_no }}" @if(isset($editproduct->type_no) && ($producttypes->type_no == $editproduct->type_no)) selected @endif>{{ $producttypes->type_name }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="row">
                    <div class="form-group col-3">
                        <label for="product_size">ขนาดสินค้า</label>
                    <input id="product_size" type="text" class="form-control" name="product_size" placeholder="XXX*XXXX*XXX" @if(isset($editproduct->product_size)) value="{{$editproduct->product_size}}" @endif>
                    </div>
                    <div class="form-group col-2">
                        <label>ราคาสินค้า</label>
                        <div class="input-group">
                            <div class="input-group-prepend">
                                <span class="input-group-text">$</span>
                            </div>
                        <input type="text" class="form-control" name="product_price" @if(isset($editproduct->product_price)) value="{{$editproduct->product_price}}" @endif>
                            <div class="input-group-append">
                                <span class="input-group-text">.00</span>
                            </div>
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

</script>
@stop