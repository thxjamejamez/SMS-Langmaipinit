@extends('admin')
@section('content')
@section('css')
@stop
<div class="container-fluid col-12">
    <div class="row">
        <div class="form-group">
            <a href="/requirequotation/create" style="margin-left: 20px;"><i class="fa fa-plus-circle"></i> เพิ่มคำขอใบเสนอราคา</a>
        </div>
    </div>
    <div class="row">
        <div class="col-sm-12">
            <div class="card">
            <div class="card-header">
                <h3 class="card-title">คำขอใบเสนอราคา</h3>
            </div>
            <!-- /.card-header -->
            <div class="card-body">
                <div class="col-lg-2 col-md-4 col-sm-12 col-xs-12" style="margin:5px 0px 5px 0px;min-width: 200px;max-width: 220px;">
                    <select class="selectpicker" data-live-search="true" multiple data-actions-box="true" id="rests" name="rests[]" onchange="getVal('#rests','#srests');">
                        @foreach($restses as $r)
                        <option value="{{ $r->id }}" >{{ $r->sts_name }}</option>
                        @endforeach
                    </select>
                    <input type="hidden" id="srests" name="srests" value="{{ $rests }}">
                </div>
                <table id="requotataion-table" class="table table-hover table-bordered dt-responsive nowrap" style="width:100%">
                    <thead>
                        <tr>
                            <th>รหัสคำขอใบเสนอราคา</th>
                            <th class="rests-filter">สถานะคำขอ</th>
                            <th style="width: 10px;"></th>
                            <th style="width: 10px;"></th>
                        </tr>
                    </thead>
                </table>
            </div>
            <!-- /.card-body -->
        </div>
        </div>
    </div>
</div>
@stop

@section('script')
<script type="text/javascript">
    $(document).ready(function () {
        $(".text-dark").append('คำขอใบเสนอราคา');
        var usertable = $('#requotataion-table').DataTable({
            processing: true,
            ajax: {
                    type: 'GET',
                    url: '{{ url("/getrequirequotationlist") }}',
                },
            columns:    [
                            {data: 'require_no', render: function(data, type ,row, meta){
                                if(type === 'display'){
                                    data = 'RE'+numeral(data).format('000000');
                                }
                                return data;
                            }},
                            {data: 'sts_name', name: 'sts_name'},
                            {data: 'require_no', render: function(data, type ,row, meta){
                                if(type === 'display'){
                                    if(row.sts_id == 2){
                                        data = '<a class="btn btn-block btn-warning btn-sm" href=requirequotation/'+ data +'/edit><i class="fa fa-search"></i> เรียกดู</a>';
                                    }else{
                                        data = '<button class="btn btn-block btn-warning btn-sm" disabled><i class="fa fa-search"></i> เรียกดู</button>' ;
                                    }
                                }
                                return data;
                            }},
                            {data: 'require_no', render: function(data, type ,row, meta){
                                if(type === 'display'){
                                    if(row.sts_id == 1){
                                        data = '<button class="btn btn-block btn-danger btn-sm" onclick="del('+data+')"><i class="fa fa-trash" aria-hidden="true"></i> ลบ</button>';
                                    }else{
                                        data = '<button class="btn btn-block btn-danger btn-sm disabled" onclick="del('+data+')"><i class="fa fa-trash" aria-hidden="true"></i> ลบ</button>';
                                    }
                                }
                                return data;
                            }},
                        ],
                initComplete: function(){
                this.api().columns('.rests-filter').every( function() {
                    var column = this
                    @if($rests)
                    var srests = '{{ $rests }}';
                    var scarray = srests.split(",");
                    $('#rests').selectpicker('val', scarray);
                    @else
                    $('#rests').selectpicker('selectAll');
                    @endif
                    $('#rests').on('hide.bs.select', function(e){
                        var Totaloption = $('#rests').find('option').length;
                        var TotaloptionSelected = $('#rests').find('option:selected').length;
                        var val ='';
                        $('#rests option:selected').each(function () {
                        if (Totaloption != TotaloptionSelected){
                            $('#rests option:selected').each(function () {
                                if(val){
                                    val += '|';
                                }
                                val += '^' + $(this).text() + '$';
                            });
                        }
                        $("#requotation-table").DataTable().search( '' )
                                .columns('.rests-filter').search( '' )
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

    function del (type_no){
        const swalWithBootstrapButtons = swal.mixin({
            confirmButtonClass: 'btn btn-success',
            cancelButtonClass: 'btn btn-danger',
            buttonsStyling: false,
            })
        swalWithBootstrapButtons({
            title: 'แน่ใจหรือ?',
            text: "คุณต้องการลบข้อมูลคำขอใบเสนอราคา",
            type: 'warning',
            showCancelButton: true,
            confirmButtonText: 'ใช่',
            cancelButtonText: 'ไม่ใช่',
            reverseButtons: true
        }).then((result) => {
            if (result.value) {
                $.ajax({
                    type: 'DELETE',
                    url: '/requirequotation/'+type_no
                }).done(function (data){
                    if(data == 'success'){
                        swalWithBootstrapButtons(
                            'ลบข้อมูลคำขอใบเสนอราคาเรียบร้อยแล้ว',
                            '',
                            'success'
                        )
                        $('#requotataion-table').DataTable().ajax.reload();
                    }
                })
            } else if (
                result.dismiss === swal.DismissReason.cancel
            ) {
                swalWithBootstrapButtons(
                'ยกเลิก',
                'ยกเลิกการลบข้อมูลใบเสนอราคาแล้ว',
                'error'
                )
            }
        })
    }

</script>
@stop