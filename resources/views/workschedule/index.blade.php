@extends('admin')
@section('content')
@section('css')
@stop
<div class="container-fluid col-12">
    <div class="row">
        <div class="col-sm-12">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">ตารางการทำงาน</h3>
            </div>
            <div class="card-body">
                <div class="col-lg-2 col-md-4 col-sm-12 col-xs-12" style="margin:5px 0px 5px 0px;min-width: 200px;max-width: 220px;">
                    <select class="selectpicker" data-live-search="true" multiple data-actions-box="true" id="worksts" name="worksts[]" onchange="getVal('#worksts','#sworksts');">
                        @foreach($workstses as $w)
                        <option value="{{ $w->id }}" >{{ $w->sts_name }}</option>
                        @endforeach
                    </select>
                    <input type="hidden" id="sworksts" name="sworksts" value="{{ $worksts }}">
                </div>
                <table id="reorder-table" class="table table-hover table-bordered dt-responsive nowrap" style="width:100%">
                    <thead>
                        <tr>
                            <th>เลขที่การสั่งซื้อ</th>
                            <th>วันที่สั่งซื้อ</th>
                            <th>วันที่ส่งสินค้า</th>
                            <th class="city-filter">สถานะการทำงาน</th>
                            <th style="width: 10px"></th>
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
        var usertable = $('#reorder-table').DataTable({
            processing: true,
            ajax: {
                    type: 'GET',
                    url: '{{ url("/getorderforwork") }}',
                },
            columns:    [
                            {data: 'order_no', render: function(data, type ,row, meta){
                                if(type === 'display'){
                                    data = 'PO'+numeral(data).format('000000');
                                }
                                return data;
                            }},
                            {data: 'order_date', render: function(data,type,row,meta){
                                if(type==='display'){
                                    data = moment(data).locale('th').format('LL');
                                }
                                return data;
                            }},
                            {data: 'send_date', render: function(data,type,row,meta){
                                if(type==='display'){
                                    data = moment(data).locale('th').format('LL');
                                }
                                return data;
                            }},
                            {data: 'sts_name', name: 'sts_name'},
                            {data: 'order_no', render: function(data, type ,row, meta){
                                if(type === 'display'){
                                    data = "<a class='btn btn-block btn-warning btn-sm' href='/requireorder/"+data+"/edit'><i class='fa fa-search' aria-hidden='true'></i> เรียกดู</a>";
                                }
                                return data;
                            }},
                        ],
            initComplete: function(){
                $('#worksts').selectpicker({
                // selectedTextFormat: 'count > 2',
                noneSelectedText: '-- ไม่มีสถานะที่เลือก --',
                selectAllText: 'เลือกทั้งหมด',
                deselectAllText: 'ไม่เลือกทั้งหมด',
                // width: '180px'
                });
                @if($worksts)
                var sworksts = '{{ $worksts }}';
                var scarray = sworksts.split(",");
                $('#worksts').selectpicker('val', scarray);
                @else
                $('#worksts').selectpicker('selectAll');
                @endif
                $('#worksts').on('hide.bs.select', function(e){
                    console.log('555');
                    
                });
            }
        });
    });

    function getVal(sobj,obj){
        if( ($(sobj+" :selected").length == $(sobj+" option").length) || ($(sobj+" :selected").length == 0) ){
            $(obj).val('');
        }else{ $(obj).val($(sobj).val()); }
    }
</script>
@stop