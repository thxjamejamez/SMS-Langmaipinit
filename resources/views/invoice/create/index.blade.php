@extends('admin')
@section('content')
@section('css')
@stop
<div class="container-fluid col-12">
    <div class="row">
        <div class="col-sm-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">รายชื่อค้างจ่าย</h3>
                </div>
                <div class="card-body">
                    <table id="creinvoice-table" class="table table-hover table-bordered dt-responsive nowrap" style="width:100%">
                        <thead>
                            <tr>
                                <th>รหัสลูกค้า</th>
                                <th>ชื่อลูกค้า</th>
                                <th>ชื่อบริษัท</th>
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
<script  type="text/javascript">
    $(document).ready(function () {
        var materialtable = $('#creinvoice-table').DataTable({
            processing: true,
            ajax: {
                    type: 'GET',
                    url: '/getlistForIv',
                },
            columns:    [
                            {data: 'users_id', render: function(data, type ,row, meta){
                                if(type === 'display'){
                                    data = 'U'+numeral(data).format('000000');
                                }
                                return data
                            }},
                            {data: 'first_name', render: function(data, type ,row, meta){
                                if(type === 'display'){
                                    data = data + '&nbsp;&nbsp;' + row.last_name
                                }
                                return data
                            }},
                            {data: 'company_name', name: 'company_name'},
                            {data: 'users_id', render: function(data, type ,row, meta){
                                if(type === 'display'){
                                    data = "<a class='btn btn-block btn-primary btn-sm' href='/createIV/"+data+"' >สร้างใบวางบิล</a>";
                                }
                                return data
                            }},
                        ],
        });
    });
</script>
@stop