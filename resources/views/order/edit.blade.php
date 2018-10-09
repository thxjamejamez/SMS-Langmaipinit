@extends('admin')
@section('content')
@section('css')
    {{-- <link rel="stylesheet" href="/css/requireorder/app.css"> --}}
@stop
<?php
        $allsum = 0;
        function DateThai($strDate,$format = false)
            {
                $D = date('N', strtotime($strDate));
                $strYear = date("Y",strtotime($strDate))+543;
                $strMonth= date("n",strtotime($strDate));
                $strDay= date("d",strtotime($strDate));
                $strDayFull = Array("","จันทร์","อังคาร","พุธ","พฤหัสบดี","ศุกร์","เสาร์","อาทิตย์");
                $strHour= date("H",strtotime($strDate));
                $strMinute= date("i",strtotime($strDate));
                $strSeconds= date("s",strtotime($strDate));
                $strMonthCut = Array("","ม.ค.","ก.พ.","มี.ค.","เม.ย.","พ.ค.","มิ.ย.","ก.ค.","ส.ค.","ก.ย.","ต.ค.","พ.ย.","ธ.ค.");
                $strMonthThai=$strMonthCut[$strMonth];
                $strDayThai=$strDayFull[$D];
                if($format == 'd/M'){
                    return "$strDay/$strMonthThai";
                }else if($format == 'D, d M Y'){
                    return "$strDayThai, $strDay $strMonthThai $strYear";
                }else{
                    return "$strDay $strMonthThai $strYear";
                }
            }
    ?>
<div class="container-fluid" id="app">
    <div class="row">
        <div class="col-lg-12">
            @if($order->status == 6)
                <div class="callout callout-danger">
                    <h5>ไม่อนุมัติ</h5>
                    <hr>
                    @if(isset($order->reason_id))<p><b>เนื่องจาก:</b> {{$order->reason_name}}@endif</p>
                    @if(isset($order->change_senddate) && $order->change_senddate != '0000-00-00')
                        <p><b>สามารถส่งสินค้าได้ในวันที่:</b> {{DateThai(Date($order->change_senddate), 'd M Y')}}</p>
                        <p><b>**หมายเหตุ: </b> หากต้องการ</p>                    
                    @endif
                </div>
            @endif
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title"><i class="fa fa-cart-arrow-down"></i>&nbsp;&nbsp;สินค้าที่สั่งซื้อ</h3>
                </div>
                <div class="card-body">
                    <div class="card-body p-0">
                        <table class="table table-condensed">
                            <tr>
                                <th style="width: 10px">#</th>
                                <th>ประเภทสินค้า</th>
                                <th>ชื่อสินค้า</th>
                                <th>ขนาดสินค้า</th>
                                <th class="text-right">ราคาต่อหน่วย</th>
                                <th class="text-center">จำนวนที่สั่งซื้อ</th>
                                <th class="text-right">ราคารวม</th>
                            </tr>
                            <?php $sum = 0 ?>
                            @foreach ($orderdetail as $key => $detail)
                            <tr>
                                <?php $sum += ($detail->price * $detail->qty); ?>
                                    <td>{{ $key+1 }}</td>
                                    <td>{{ $detail->type_name }}</td>
                                    <td>{{ $detail->product_name }}</td>
                                    <td>{{ $detail->product_size }}</td>
                                    <td class="text-right">{{ number_format($detail->price, 2) }}</td>
                                    <td class="text-center">{{ $detail->qty }}</td>
                                    <td class="text-right">{{ number_format($detail->price * $detail->qty, 2) }}</td> 
                                </tr>
                                @endforeach
                            <tr style="background-color: #E0E0E0">
                                <td colspan="5"><b>รวมทั้งสิ้น</b></td>
                                <td class="text-right"><b>{{ number_format($sum, 2) }}</b></td>
                                <td class="text-right"><b>บาท</b></td>
                            </tr>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title"><i class="fa fa-info-circle"></i>&nbsp;&nbsp;รายละเอียดการสั่งซื้อ</h3>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="form-group col-6">
                            <label>หมายเหตุ</label>
                            <textarea class="form-control" name="re_detail" rows="3" placeholder="" disabled>{{ $order->remark }}</textarea>
                        </div>
                        
                        <div class="form-group col-2">
                            <label>วันที่ส่งสินค้า</label>
                            <div class="input-group">
                                <div class="input-group-prepend">
                                    <span class="input-group-text"><i class="fa fa-calendar"></i></span>
                                </div>
                                <input id="senddate" type="text" name="senddate" class="form-control" disabled value="{{ $order->send_date }}">
                            </div>
                        </div>
                        @if($order->file)
                        <a href="/file_order/{{ $order->file }}" target="_blank">
                            <img src="/file_order/{{ $order->file }}">
                        </a>
                    @endif
                    </div>
                </div>
                {{-- <div class="card-footer">
                    <div class="row">
                        <div class="col-1">
                            <button @click="onSave()" class="btn btn-block btn-outline-primary btn-sm">บันทึก</button>
                        </div>
                        <div class="col-1">
                            <button type="reset" class="btn btn-block btn-outline-danger btn-sm">ยกเลิก</button>
                        </div>
                    </div>
                </div> --}}
            </div>
        </div>
    </div>
</div>
@stop
@section('script')
{{-- <script src="/js/requireorder/app.js?v=<?php echo filemtime('js/requireorder/app.js')?>"></script> --}}
@stop