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
<meta name="csrf-token" content="{{ csrf_token() }}">
@stop
<div class="container-fluid col-12">
    {{-- <form action="/quotation/{{ $id }}" method="POST" accept-charset="utf-8"> --}}
        <input type="hidden" name="_method" value="PUT">
        <div class="card card-default">
            <div class="card-header">
                <h3 class="card-title">รายละเอียด</h3>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-6">
                        <div class="card card-info">
                            <div class="card-header bg-brown">
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
                            <div class="card-header bg-brown">
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
                                </div>
                                <div class="detail">
                                    @foreach($detail_quotation as $dr)
                                        <div class="row">
                                            <div class="form-group col-5">
                                                <select class="form-control" name="product[]" disabled>
                                                    <option value="{{ $dr->product_no }}">({{ $dr->type_name }}) {{ $dr->product_name }}, {{ $dr->product_size }}</option>
                                                </select>
                                            </div>
                                            <div class="form-group col-5">
                                                <div class="input-group">
                                                    <div class="input-group-prepend">
                                                        <span class="input-group-text">$</span>
                                                    </div>
                                                    <input type="text" class="form-control" name="product_price[]" value="{{ $dr->price }}" disabled>
                                                    <div class="input-group-append">
                                                        <span class="input-group-text">.00</span>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="form-group col-1">
                                                <button id="chk-{{ $dr->product_no }}" class="btn btn-block btn-success btn-sm" onclick="update_priceforcust({{ $id }}, {{ $dr->product_no }}, {{ $dr->price }})" @if($dr->confirm_status == 2) disabled @endif><i class="fa fa-check"></i></button>
                                            </div>
                                        </div>
                                    @endforeach
                                    

                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    {{-- </form> --}}
</div>
@stop

@section('script')
<script type="text/javascript">
    $(document).ready(function () {
        $(".text-dark").append('ข้อมูลใบเสนอราคา');
    });
    function update_priceforcust(re_id ,id_pd, price) {
       $.ajax({
           url: '{{ url("/updatepdcust") }}',
           type: "POST",
           headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
           data: {  'product_no': id_pd,
                    'price': price,
                    'require_no': re_id
                },
            success: function(data){
                if(data=='success'){
                    swal({
                    type: 'success',
                    title: 'Your work has been saved',
                    showConfirmButton: false,
                    timer: 1000
                    });

                    $('#chk-'+id_pd).prop( "disabled", true );
                }
            }
       });
        
    }

</script>
@stop