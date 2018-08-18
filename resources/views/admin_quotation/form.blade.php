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
<div class="container-fluid col-12">
    <form action="/quotation/{{ $id }}" method="POST" accept-charset="utf-8">
        <input type="hidden" name="_method" value="PUT">
        {{ csrf_field() }}
        <div class="card card-default">
            <div class="card-header">
                <h3 class="card-title">จัดการใบเสนอราคา</h3>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-6">
                        <div class="card card-info">
                            <div class="card-header">
                                <h3 class="card-title">รายละเอียดคำขอ</h3>
                            </div>
                            <div class="card-body">
                                <div class="form-group">
                                    <label>ข้อมูลคำขอ</label>
                                    <textarea class="form-control" rows="3" placeholder="Enter ..." disabled="">{{ $detail->require_detail }}</textarea>
                                </div>
                                @if($detail->file)
                                    <a href="/file_quotation/{{ $detail->file }}" target="_blank">
                                        <img src="/file_quotation/{{ $detail->file }}">
                                    </a>
                                @endif
                            </div>
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="card card-primary">
                            <div class="card-header">
                                <h3 class="card-title">ข้อมูลการเสนอราคา</h3>
                            </div>
                            <div class="card-body">
                                <div class="row">
                                    <div class="form-group col-5">
                                        <label>สินค้า</label>
                                    </div>
                                    <div class="form-group col-5">
                                        <label>ราคา</label>
                                    </div>
                                    <div class="form-group col-2">
                                        <div class="btn btn-block btn-outline-primary btn-sm" id="addproduct">+ เพิ่มสินค้า</div>
                                    </div>
                                </div>
                                <div class="detail">
                                    <div class="row">
                                        <div class="form-group col-5">
                                            <select class="form-control" name="product[]">
                                                @foreach($product as $products)
                                                <option value="{{ $products->product_no }}">{{ $products->product_name }}, {{ $products->product_size }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <div class="form-group col-5">
                                            <div class="input-group">
                                                <div class="input-group-prepend">
                                                    <span class="input-group-text">$</span>
                                                </div>
                                                <input type="text" class="form-control" name="product_price[]" required>
                                                <div class="input-group-append">
                                                    <span class="input-group-text">.00</span>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="form-group col-1">
                                            <div class="btn btn-block btn-outline-danger btn-sm remove"><i class="fa fa-remove"></i></div>
                                        </div>
                                    </div>

                                </div>
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
    $(document).ready(function () {
        $(".text-dark").append('จัดการใบเสนอราคา');
    });
    $('#addproduct').on('click', function(){
        $('div.detail:last').append(`<div class="row">
                                        <div class="form-group col-5">
                                            <select class="form-control" name="product[]">
                                                @foreach($product as $products)
                                                <option value="{{ $products->product_no }}">{{ $products->product_name }}, {{ $products->product_size }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <div class="form-group col-5">
                                            <div class="input-group">
                                                <div class="input-group-prepend">
                                                    <span class="input-group-text">$</span>
                                                </div>
                                                <input type="text" class="form-control" name="product_price[]" required>
                                                <div class="input-group-append">
                                                    <span class="input-group-text">.00</span>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="form-group col-1">
                                            <div class="btn btn-block btn-outline-danger btn-sm remove"><i class="fa fa-remove"></i></div>
                                        </div>
                                    </div>`)
        
    });

   
    $(document).on('click','.remove', function(){
        $(this).closest('.row').remove();
    });

</script>
@stop