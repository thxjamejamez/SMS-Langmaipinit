@extends('admin')
@section('content')
@section('css')
@stop
<div class="container-fluid col-12">
        <div class="row">
            <div class="col-sm-12">
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">ใบวางบิล</h3>
                    </div>
                    <div class="card-body">
                        <table id="invoice-table" class="table table-hover table-bordered dt-responsive nowrap" style="width:100%">
                            <thead>
                                <tr>
                                    <th>เลขหมายใบวางบิล</th>
                                    <th>วันที่สร้างใบวางบิล</th>
                                    <th>กำหนดจ่าย</th>
                                    <th>สถานะใบวางบิล</th>
                                    <th style="width: 10px"></th>
                                    <th style="width: 10px"></th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($invlist as $iv)
                                    <tr>
                                        <td>{{ $iv->invoice_number }}</td>
                                        <td>{{ $iv->invoice_date }}</td>
                                        <td>{{ $iv->due_date }}</td>
                                        <td>{{ $iv->sts_name }}</td>
                                        <td>{{ $iv->invoice_no }}</td>
                                        <td>{{ $iv->invoice_no }}</td>
                                    </tr>
                                @endforeach    
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>

        {{-- modal --}}
        <div class="modal fade bd-example-modal-lg" id="pay_detail" tabindex="-1" role="dialog" aria-hidden="true">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">ข้อมูลการชำระเงิน</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="callout callout-warning">
                            <h5 class="name"></h5>
                            <h5 class="address"></h5>
                            <h5 class="invoicedate"></h5>
                        </div>
                    </div>

                    <div class="modal-footer">
                    </div>
                </div>
            </div>
        </div>
</div>
@stop
@section('script')
<script type="text/javascript">
    var invoicelisttable = $('#invoice-table').DataTable({
    "columnDefs": [
            { 
                "targets": 0,
                "render": function (data, type ,row) {
                    if(type === 'display'){
                        data = 'INV'+numeral(data).format('000000');
                    }
                    return data;
                },

            },
            {
                "targets": 1,
                "render": function (data, type ,row) {
                    if(type === 'display'){
                        data = moment(data).locale('th').format('LL')
                    }
                    return data;
                },
            },
            {
                "targets": 2,
                "render": function (data, type ,row) {
                    if(type === 'display'){
                        data = moment(data).locale('th').format('LL')
                    }
                    return data;
                },
            },
            {
                "targets": 4,
                "render": function (data, type ,row) {
                    if(type === 'display'){
                        data = "<a class='btn btn-block btn-primary btn-sm' href='/invoicedetail/"+data+"'><i class='fa fa-search' aria-hidden='true'></i> รายละเอียด</a>"
                    }
                    return data;
                },
            },
            {
                "targets": 5,
                "render": function (data, type ,row) {
                    if(type === 'display'){
                        data = "<a class='btn btn-block btn-warning btn-sm' href='javascript:;'><i class='fa fa-search' aria-hidden='true'></i> ตรวจสอบ</a>"
                    }
                    return data;
                },
            }
        ]
    });

</script>
@stop