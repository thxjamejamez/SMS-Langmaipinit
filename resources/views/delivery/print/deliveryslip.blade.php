<html>
    <head>
        <title>ใบส่งสินค้า</title>
        <style>
            body {
                font-family: 'examplefont';
                font-size: 14px;
            }
        </style>
    </head>
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
    <body>
        <table style="margin-bottom: 30px; width: 100%">
            <tr>
                <td>
                    <h3>PINIT988 WOOD BOX LIMITED PARTNERSHIP</h3>
                </td>
                <td align="right">
                    <h4>เลขที่การสั่งซื้อ: PO{{ sprintf('%06d', $order->order_no) }}</h4>
                </td>
            </tr>
            <tr>
                <td colspan="2">
                    <h4>88 ม.4 ต.หนองหนาม อ.เมือง จ.ลำพูน 51000</h4>
                </td>
            </tr>
            <tr>
                <td colspan="2">
                    <h4>Tel. 053-598167 Fax. 053-598052, 081-9602512 (K.พินิจ)</h4>
                </td>
            </tr>
            <tr>
                <td colspan="2">
                    <h4>เลขประจำตัวผู้เสียภาษีอากร 3 5101 00325 21 5 (สำนักงานใหญ่)</h4>
                </td>
            </tr>
        </table>
        
        <table style="margin-bottom: 20px; background-color: #b3a57e; width:100%">
            <tr>
                <td align="center" height="40px"><h3>ใบส่งสินค้า</h3></td>
            </tr>
        </table>
        <table style="margin-bottom: 20px; width:100%">
            <tr>
                <td align="right"><b>วันที่: </b>{{DateThai(Date($order->send_date), 'd M Y')}}</td>
            </tr>
            <tr>
                @if(isset($order->company_name))
                    <td><b>นามลูกค้า: </b> {{$order->company_name}}</td>
                @else
                    <td><b>นามลูกค้า: </b> {{$order->first_name}}  {{$order->last_name}}</td>
                @endif
            </tr>
            <tr>
                @if(isset($order->company_address))
                    <td><b>ที่อยู่: </b> {{$order->company_address}} {{$order->city_com}} {{$order->pro_com}}</td>
                @else
                    <td><b>ที่อยู่: </b> {{$order->address}} {{$order->city_cus}} {{$order->pro_cus}}</td>
                @endif
            </tr>
        </table>

        <table border="1" style="margin-bottom: 40px; width:100%; border-collapse: collapse;">
            <tr>
                <th height="40px" width="100px" style="background-color:#b3a57e">ประเภทสินค้า</th>
                <th style="background-color:#b3a57e">ชื่อสินค้า</th>
                <th style="background-color:#b3a57e">ขนาดสินค้า</th>
                <th width="60px" style="background-color:#b3a57e">จำนวน</th>
                <th width="100px" style="background-color:#b3a57e">ราคาต่อหน่วย</th>
                <th style="background-color:#b3a57e">จำนวนเงิน</th>
            </tr>
            @foreach($orderdetail as $key => $value)
            <?php $allsum += ($value->price * $value->qty) ?>
            <tr>
                <td align="center" height="30px">{{ $value->type_name }}</td>
                <td align="center">{{ $value->product_name }}</td>
                <td align="center">{{ $value->product_size }}</td>
                <td align="center">{{ $value->qty }}</td>
                <td align="right">{{ number_format($value->price, 2) }}</td>
                <td align="right">{{ number_format($value->price * $value->qty, 2) }}</td>
            </tr>
            @endforeach
            <tr>
                <td colspan="5" height="30px" align="right" style="background-color:#d1c9b2"><b>รวมทั้งสิ้น</b></td>
                <td align="right" style="background-color:#d1c9b2"><b>{{ number_format($allsum, 2) }}</b></td>
            </tr>
        </table>

        <table style="width: 100%">
            <tr>
                <td><b>ผู้รับสินค้า:</b> ...................................................</td>
                <td align="right"><b>ผู้ส่งสินค้า:</b> ...................................................</td>
            </tr>
        </table>
    </body>
</html>