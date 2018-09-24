@extends('admin')
@section('content')
@section('css')
@stop
<div class="container-fluid col-12">
    <div class="row">
        <div class="form-group">
            <a href="/materialseller/create" style="margin-left: 20px;"><i class="fa fa-user-plus"></i> เพิ่มข้อมูลผู้ขายวัตถุดิบ</a>
        </div>
    </div>
    <div class="row">
        <div class="col-sm-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">ข้อมูลผู้ขายวัตถุดิบ</h3>
                </div>
                <div class="card-body">
                    <table id="user-table" class="table table-hover table-bordered dt-responsive nowrap" style="width:100%">
                        <thead>
                            <tr>
                                <th>รหัสผู้ขาย</th>
                                <th>ชื่อผู้ขาย</th>
                                <th>ที่อยู่</th>
                                <th>อีเมล์</th>
                                <th>เบอร์โทร</th>
                                <th style="width: 10px"></th>
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
    })

</script>
@stop