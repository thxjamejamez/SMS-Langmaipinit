@extends('admin')
@section('content')
@section('css')
@stop
<div class="container-fluid col-12">
    <div class="row">
        <div class="form-group">
            <a href="/requireorder/create" style="margin-left: 20px;"><i class="fa fa-plus-circle"></i> เพิ่มการสั่งซื้อ</a>
        </div>
    </div>
    <div class="row">
        <div class="col-sm-12">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">คำสั่งซื้อ</h3>
            </div>
            <div class="card-body">
                <select class="selectpicker" data-live-search="true" multiple data-actions-box="true" id="orsts" name="orsts[]">
                    @foreach($orstses as $r)
                    <option value="{{ $r->id }}" >{{ $r->sts_name }}</option>
                    @endforeach
                </select>
                <table id="reorder-table" class="table table-hover table-bordered dt-responsive nowrap" style="width:100%">
                    <thead>
                        <tr>
                            <th>เลขที่การสั่งซื้อ</th>
                            <th>วันที่สั่งซื้อ</th>
                            <th class="ordersts-filter">สถานะการสั่งซื้อ</th>                           
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
        $(".text-dark").append('การสั่งซื้อ');
        var usertable = $('#reorder-table').DataTable({
            processing: true,
            ajax: {
                    type: 'GET',
                    url: '{{ url("/getrequirorderlist") }}',
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
                                    data = moment(data).format('DD-MM-YYYY');
                                }
                                return data;
                            }},
                            {data: 'sts_name', name: 'sts_name'},
                            {data: 'order_no', render: function(data, type ,row, meta){
                                if(type === 'display'){
                                    if(row.status == 6){
                                        data = "<a class='btn btn-block btn-danger btn-sm' href='/requireorder/"+data+"/edit'><i class='fa fa-search' aria-hidden='true'></i> เรียกดู</a>";
                                    }else{
                                        data = "<a class='btn btn-block btn-warning btn-sm' href='/requireorder/"+data+"/edit'><i class='fa fa-search' aria-hidden='true'></i> เรียกดู</a>";
                                    }
                                }
                                return data;
                            }},
                        ],
                initComplete: function(){
                this.api().columns('.ordersts-filter').every( function() {
                    var column = this
                    @if($orsts)
                    var srests = '{{ $orsts }}';
                    var scarray = srests.split(",");
                    $('#orsts').selectpicker('val', scarray);
                    @else
                    $('#orsts').selectpicker('selectAll');
                    @endif
                    $('#orsts').on('hide.bs.select', function(e){
                        var Totaloption = $('#orsts').find('option').length;
                        var TotaloptionSelected = $('#orsts').find('option:selected').length;
                        var val ='';
                        $('#orsts option:selected').each(function () {
                        if (Totaloption != TotaloptionSelected){
                            $('#orsts option:selected').each(function () {
                                if(val){
                                    val += '|';
                                }
                                val += '^' + $(this).text() + '$';
                            });
                        }
                        $("#reorder-table").DataTable().search( '' )
                                .columns('.ordersts-filter').search( '' )
                                .draw();
                        column
                            .search( val ? val : '', true, false )
                            .draw();
                        });
                    });
                })
            }
        });
    });

</script>
@stop