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
        <div class="modal fade bd-example-modal-sm" id="pay_detail" tabindex="-1" role="dialog" aria-hidden="true">
            <div class="modal-dialog modal-sm">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">ข้อมูลการชำระเงิน</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="form-group detail">
                        </div>
                        <div class="form-group">
                            <label>วัน - เวลาที่โอนเงิน</label>
                            <div class="form-group">
                                <input type="text" class="form-control pay-date" disabled>
                            </div>
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
                        data = moment(data).format('DD-MM-YYYY');
                    }
                    return data;
                },
            },
            {
                "targets": 2,
                "render": function (data, type ,row) {
                    if(type === 'display'){
                        data = moment(data).format('DD-MM-YYYY');
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
                        if(row[3] == 'รอการตรวจสอบการจ่ายเงิน'){
                            data = "<a class='btn btn-block btn-warning btn-sm' href='javascript:;' onclick='detail_pay("+data+")'><i class='fa fa-money' aria-hidden=true></i> ตรวจสอบ</a>"
                        }else{
                            data = "<a class='btn btn-block btn-warning btn-sm disabled' href='javascript:;' onclick='detail_pay("+data+")'><i class='fa fa-money' aria-hidden=true></i> ตรวจสอบ</a>"
                        }
                    }
                    return data;
                },
            }
        ]
    });

    function detail_pay (id) {
        $('#pay_detail').modal('show');
        $.ajax({
            type: 'get',
            url: '/getdetailpay/'+id
        }).done(function(data){
            $('.pay-date').val('')
            $('.detail').empty();
            $('.modal-footer').empty();
            if(data.pay_file) {
                $('.detail').append(`<a href="/slip_file/`+data.pay_file+`" class="btn btn-block btn-info btn-sm" target="_blank">
                    <i class="fa fa-file-text" aria-hidden="true"></i> ไฟล์แนบ
                </a>`) 
            }else{
                $('.detail').append(`<label>จำนวนเงินที่โอน</label>
                <div class="form-group">
                    <input type="text" class="form-control" value="`+accounting.formatNumber(data.money, 2)+`" disabled>
                </div>`) 
            }
            $('.pay-date').val(data.pay_datetime)
            $('.modal-footer').append(`<button type="button" class="btn btn-block btn-success btn-sm" style="margin-top: .5rem;" onclick="update(`+data.invoice_no+`, 3)">การชำระเงินถูกต้อง</button>
                <button type="button" class="btn btn-block btn-danger btn-sm" onclick="update(`+data.invoice_no+`, 4)">การชำระเงินไม่ถูกต้อง</button>`)
        }) 
    }

    function update (invoice_no, sts) {
        $.ajax({
            type: 'get',
            url: '/updatepay/'+invoice_no+'/'+sts
        }).done(function(data){
            if(data=='success'){
                swal({
                type: 'success',
                title: 'บันทึกสำเร็จ',
                showConfirmButton: false,
                timer: 1000
                });
                window.location.reload();
            }
        })
    }

</script>
@stop