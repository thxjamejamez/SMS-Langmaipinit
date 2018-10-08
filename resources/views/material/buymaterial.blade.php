@extends('admin')
@section('content')
@section('css')
@stop
<div class="container-fluid col-12">
    <div class="row">
        <div class="col-sm-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">ข้อมูลการสั่งซื้อวัตถุดิบ</h3>
                </div>
                <div class="card-body">
                    <table id="buymaterial-table" class="table table-hover table-bordered dt-responsive nowrap" style="width:100%">
                        <thead>
                            <tr>
                                <th>ชื่อวัตถุดิบ</th>
                                <th>ประเภทวัตถุดิบ</th>
                                <th>จำนวนที่สั่งซื้อ</th>
                                <th>ราคาต่อหน่วย</th>
                                <th>รวม</th>
                                <th>ผู้ขายวัตถุดิบ</th>
                                <th>ผู้ทำรายการ</th>
                            </tr>
                        </thead>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
@stop
@section('script')
<script type="text/javascript">
    $(document).ready(function () {
        var materialtable = $('#buymaterial-table').DataTable({
            
            processing: true,
            ajax: {
                    type: 'GET',
                    url: '/getbuymateriallist',
                },
                dom: 'Bfrtip',
                buttons:['print'],
            columnDefs: [
                            { className: "text-right", "targets": [3,4] }
                        ],
            columns:    [
                            {data: 'material_name', name: 'material_name'},
                            {data: 'type_name', name: 'type_name'},
                            {data: 'unit_purchase', name: 'unit_purchase'},
                            {data: 'price_perunit', render: function(data, type ,row, meta){
                                if(type === 'display'){
                                    data = accounting.formatNumber(data, 2);
                                }
                                return data
                            }},
                            {data: 'price_perunit', render: function(data, type ,row, meta){
                                if(type === 'display'){
                                    data = accounting.formatNumber((data * row.unit_purchase), 2);
                                }
                                return data
                            }},
                            {data: 'sup_name', name: 'sup_name'},
                            {data: 'nickname', name: 'nickname'},
                        ],
        });
    });


</script>
@stop