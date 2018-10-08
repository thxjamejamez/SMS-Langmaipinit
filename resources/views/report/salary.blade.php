@extends('admin')
@section('content')
@section('css')
@stop
    <div id="Salary-report" style="display: inline-block;width:100%;">
        <h2 class="thsarabunnew hidden-xs" style="text-align: center;color: #1f2d3d">
			<b>ข้อมูลเงินเดือนของพนักงาน</b>
        </h2>
        <div class="report-detail form-group">
            <data-table
                :key="0"
                :data="dt.data"
                :columns="dt.column">
            </data-table>
        </div>
    </div>
@stop
@section('script')
    <legend x-data-table hidden>@include('report.helper.x-data-table')</legend>
    <script src="/js/report/salary/app.js?v={{ filemtime('js/report/salary/app.js') }}"></script>
@stop