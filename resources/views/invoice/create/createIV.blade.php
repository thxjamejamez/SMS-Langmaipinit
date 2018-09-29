@extends('admin')
@section('content')
@section('css')
@stop
<div class="container-fluid col-12">
    <div class="row">
        <div class="col-sm-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">รายการการสั่งซื้อที่ค้างจ่าย</h3>
                </div>
                <div class="card-body">
                    <table id="ordercust-table" class="table table-hover table-bordered dt-responsive nowrap" style="width:100%">
                        <thead>
                            <tr>
                                <th></th>
                                <th>เลขที่การสั่งซื้อ</th>
                                <th>วันที่สั่งซื้อ</th>
                                <th>วันที่จัดส่งสินค้า</th>
                                <th>สถานะการสั่งซื้อ</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($order as $o)
                                <tr>
                                    <td>1</td>
                                    <td>{{ $o->order_no }}</td>
                                    <td>{{ $o->order_date }}</td>
                                    <td>{{ $o->send_date }}</td>
                                    <td>{{ $o->sts_name }}</td>
                                </tr>
                            @endforeach    
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
    {{ $order }}
</div>
@stop
@section('script')
    <script type="text/javascript">
        $(document).ready(function () {
        var materialtable = $('#ordercust-table').DataTable({
            "columnDefs": [ {
                "targets": 1,
                "render": function (data, type ,row) {
                    if(type === 'display'){
                        data = 'PO'+numeral(data).format('000000');
                    }
                    return data;
                }
            }]
            // processing: true,
            // ajax: {
            //         type: 'GET',
            //         url: '{{ url("/getuserforcreInvoice") }}',
            //     },
            // columns:    [
            //                 {data: 'users_id', render: function(data, type ,row, meta){
            //                     if(type === 'display'){
            //                         data = 'U'+numeral(data).format('000000');
            //                     }
            //                     return data
            //                 }},
            //                 {data: 'first_name', render: function(data, type ,row, meta){
            //                     if(type === 'display'){
            //                         data = data + '&nbsp;&nbsp;' + row.last_name
            //                     }
            //                     return data
            //                 }},
            //                 {data: 'company_name', name: 'company_name'},
            //                 {data: 'users_id', render: function(data, type ,row, meta){
            //                     if(type === 'display'){
            //                         data = "<a class='btn btn-block btn-primary btn-sm' href='/createIV/"+data+"' >สร้างใบวางบิล</a>";
            //                     }
            //                     return data
            //                 }},
            //             ],
            });
        });
    </script>

@stop