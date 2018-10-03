@extends('admin')
@section('content')
@section('css')
@stop
<html>
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>AdminLTE 3 | Invoice</title>
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <!-- Bootstrap 4 -->

  <!-- Font Awesome -->
  {{-- <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.4.0/css/font-awesome.min.css">
  <!-- Ionicons -->
  <link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
  <!-- Theme style -->
  <link rel="stylesheet" href="../../dist/css/adminlte.min.css"> --}}

  <!-- Google Font: Source Sans Pro -->
  <link href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700" rel="stylesheet">
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
</head>
<body onload="window.print();">
    <div class="wrapper">
        <!-- Main content -->
        <section class="invoice">
          <!-- title row -->
          <div class="row">
            <div class="col-12">
              <h2 class="page-header">
                <i class="ion-cube"></i> PINIT988 WOOD BOX LIMITED PARTNERSHIP
              </h2>
            </div>
            <!-- /.col -->
          </div>
          <!-- info row -->
          <div class="row invoice-info">
            <div class="col-sm-4 invoice-col">
              จาก
              <address>
                <strong>หจก. ลังไม้พินิจ 988</strong><br>
                88 ม.4 ต.หนองหนาม<br>
                อ.เมือง จ.ลำพูน, 51000<br>
                โทร: (081) 960-2512 (คุณ พินิจ)<br>
                อีเมลล์: bchom88@hotmail.com
              </address>
            </div>
            <!-- /.col -->
            <div class="col-sm-4 invoice-col">
              ถึง
              @if(!isset($invinfo->customer_address))
              <address>
                  <strong>{{$invinfo->company_name}}</strong><br>
                  {{$invinfo->company_address}}<br>
                  อ.{{$invinfo->city_cus}} จ.{{$invinfo->pro_cus}}<br>
                  โทร: {{$invinfo->tel}}<br>
                  อีเมลล์: {{$invinfo->email}}
                </address>
              @else
              <address>
                  <strong>John Doe2</strong><br>
                  795 Folsom Ave, Suite 600<br>
                  San Francisco, CA 94107<br>
                  Phone: (555) 539-1037<br>
                  Email: john.doe@example.com
                </address>
              @endif
            </div>
            <!-- /.col -->
            <div class="col-sm-4 invoice-col">
              <b>หมายเลขใบแจ้งหนี้  INV{{sprintf("%06d", $invinfo->invoice_number)}}</b><br>
            </div>
            <!-- /.col -->
          </div>
          <!-- /.row -->
      
          <!-- Table row -->
          <div class="row">
            <div class="col-12 table-responsive">
              <table class="table table-striped">
                <thead>
                  <tr>
                    <th class="text-center">ลำดับ</th>
                    <th class="text-center">หมายเลขการสั่งซื้อ</th>
                    <th class="text-center">วันที่ส่งสินค้า</th>
                    <th class="text-center">มูลค่าสินค้า</th>
                    <th class="text-center">ภาษีมูลค่าเพิ่ม</th>
                    <th class="text-center">จำนวนเงินรวม</th>
                </tr>
                </thead>
                <tbody>
                  @foreach($invdetail as $key => $value)
                  <?php $allsum += $value->sum ?>
                  <tr>
                      <td class="text-center">{{ $key+1 }}</td>
                      <td class="text-center">PO{{ sprintf("%06d", $value->order_no) }}</td>
                      <td class="text-center">{{ DateThai(Date($value->send_date), 'd M Y') }}</td>
                      <td class="text-right">{{ number_format($value->sum, 2) }}</td>
                      <td class="text-right">{{ number_format(($value->sum * 7) / 100, 2) }}</td>
                      <td class="text-right">{{ number_format((($value->sum * 7) / 100)+$value->sum, 2) }}</td>
                  </tr>
                  @endforeach
                </tbody>
              </table>
            </div>
            <!-- /.col -->
          </div>
          <!-- /.row -->
      
          <div class="row">
            <!-- accepted payments column -->
            <div class="col-6">
              
            </div>
            <!-- /.col -->
            <div class="col-6">
              <p class="lead">กำหนดชำระ {{ DateThai(Date($invinfo->due_date), 'd M Y') }}</p>
      
              <div class="table-responsive">
                <table class="table">
                  <tr>
                    <th style="width:50%">รวมมูลค่าสินค้า:</th>
                    <td class="text-right">{{ number_format($allsum, 2) }}</td>
                    <th class="text-right">บาท</th>
                </tr>
                <tr>
                    <th>ภาษี (7%)</th>
                    <td class="text-right">{{ number_format(($allsum*7)/100, 2) }}</td>
                    <th class="text-right">บาท</th>
                </tr>
                <tr>
                <tr>
                    <th>รวมทั้งสิ้น:</th>
                    <td class="text-right">{{ number_format((($allsum*7)/100) + $allsum, 2) }}</td>
                    <th class="text-right">บาท</th>
                </tr>
                </table>
              </div>
            </div>
            <!-- /.col -->
          </div>
          <!-- /.row -->
        </section>
        <!-- /.content -->
      </div>
      <!-- ./wrapper -->
      </body>
      </html>
      @stop