@extends('admin')
@section('css')
@stop
@section('content')
@stop

@section('script')
<script type="text/javascript">
    $(document).ready(function () {
        var chk = '{{ isset($chk->require_no) }}';
        var permission_id = '{{ $chkpm->permission_id }}';
        if(chk == '' && permission_id == 6){
            $('#helpmodal').modal('show');
        }
    });
</script>
@stop