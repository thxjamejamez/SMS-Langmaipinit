@extends('admin')
@section('content')
@section('css')
<style>
.select2-container--default .select2-selection--single {
    height: 38px;
    padding: 9px 12px;
    background-color: #fff;
    border: 1px solid #aaa;
    border-radius: 4px; }
</style>
<link rel="stylesheet" href="/plugins/datepicker/datepicker3.css">

@stop
<div class="container-fluid">
    @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif
    @if(isset($edituser))
        <form role="form" style="margin:15px" action="/employee/{{ $edituser->id }}" method="post" accept-charset="utf-8">
            <input type="hidden" name="_method" value="PUT">
    @else
        <form action="/employee" method="POST" accept-charset="utf-8">
    @endif
    {{ csrf_field() }}
    <div class="card card-default">
        <div class="card-header">
            <h3 class="card-title">จัดการข้อมูลผู้ใช้</h3>
        </div>
        <div class="card-body">
            <div class="row">
                <div class="form-group col-2">
                    <label for="username">ชื่อผู้ใช้</label>
                    <input id="username" type="text" class="form-control" name="username" required @if(isset($edituser->username)) value="{{$edituser->username}}" @endif>
                </div>
                <div class="form-group col-2">
                    <label for="password">รหัสผ่าน</label>
                    <input id="password" type="password" class="form-control" name="password" @if(!isset($edituser->username)) required @endif>
                </div>
                <div class="form-group col-2">
                    <label for="nickname">ชื่อเล่น</label>
                    <input id="nickname" type="text" class="form-control" name="nickname" required @if(isset($edituser->nickname)) value="{{$edituser->nickname}}" @endif>
                </div>
                <div class="form-group col-2">
                    <label>สิทธิ์ในการเข้าถึง</label>
                    <select id="permission" class="form-control" name="permission" @if($permission->permission_id != 1) disabled @endif>
                        @foreach($group_permission as $group_permissions)
                        <option value="{{ $group_permissions->id }}" @if(isset($editUserPermission->permission_id) && $group_permissions->id == $editUserPermission->permission_id) selected @endif >{{ $group_permissions->permission_name }}</option>
                        @endforeach
                    </select>
                </div>
            </div>
        </div>
    </div>


    <div class="card card-default">
        <div class="card-header">
            <h3 class="card-title">จัดการข้อมูลส่วนตัว</h3>
        </div>
            <div class="card-body">
                <div class="row">
                    <div class="form-group col-2">
                        <label>คำนำหน้านาม</label>
                        <select class="form-control" name="title">
                            @foreach($title as $titles)
                            <option value="{{ $titles->title_id }}" @if(isset($editprofile->title_id) && $titles->title_id == $editprofile->title_id) selected @endif>{{ $titles->title_name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group col-3">
                        <label for="firstname">ชื่อ</label>
                        <input id="firstname" type="text" class="form-control" name="firstname" @if(isset($editprofile->first_name)) value="{{$editprofile->first_name}}" @endif>
                    </div>
                    <div class="form-group col-3">
                        <label for="firstname">นามสกุล</label>
                        <input type="text" class="form-control" name="lastname" @if(isset($editprofile->last_name)) value="{{$editprofile->last_name}}" @endif>
                    </div>
                </div>
                <div class="row">
                    <div class="form-group col-5">
                        <label>ที่อยู่</label>
                        <textarea class="form-control" rows="1" name="address"> @if(isset($editprofile->address)) {{$editprofile->address}} @endif </textarea>
                    </div>

                    <div class="form-group col-3">
                        <label>จังหวัด</label>
                        <select id="province" name="province" class="form-control select2" style="width: 100%;" onchange="setprovice(this.value, '#district')">
                            @foreach($province as $provinces)
                            <option value="{{ $provinces->province_id }}" @if(isset($editprofile->province_id) && $provinces->province_id == $editprofile->province_id) selected @endif>{{ $provinces->province_name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group col-3">
                        <label>อำเภอ</label>
                        <select id="district" name="district" class="form-control select2" style="width: 100%;">
                            @foreach($district as $districts)
                            <option value="{{ $districts->city_id }}" province="{{ $districts->province_id }}" @if(isset($editprofile->district_id) && $districts->city_id == $editprofile->district_id) selected @endif>{{ $districts->city_name }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="row">
                    <div class="form-group col-2">
                        <label>เบอร์โทรศัพท์</label>
                            <div class="input-group">
                            <div class="input-group-prepend">
                                <span class="input-group-text"><i class="fa fa-phone"></i></span>
                            </div>
                            <input type="text" name="tel" class="form-control" data-inputmask='"mask": "(999) 999-9999"' data-mask @if(isset($editprofile->tel)) value="{{$editprofile->tel}}" @endif>
                        </div>
                    </div>
                    <div class="form-group col-3">
                        <label>อีเมล์</label>
                        <div class="input-group mb-3">
                            <div class="input-group-prepend">
                                <span class="input-group-text"><i class="fa fa-envelope"></i></span>
                            </div>
                            <input type="email" name="email" class="form-control" placeholder="example@hotmail.com" required @if(isset($editprofile->email)) value="{{$editprofile->email}}" @endif>
                        </div>
                    </div>
                    <div class="form-group col-2">
                        <label>วัน/เดือน/ปีเกิด</label>
                        <div class="input-group">
                            <div class="input-group-prepend">
                            <span class="input-group-text"><i class="fa fa-calendar"></i></span>
                            </div>
                            <input id="birthday" type="text" name="birthdate" class="form-control" @if(isset($editprofile->birthdate)) value="{{  date("d-m-Y", strtotime($editprofile->birthdate)) }}" @endif>
                        </div>
                    </div>
                    <div class="form-group col-2">
                        <label>เงินเดือน</label>
                        <div class="input-group">
                            <div class="input-group-prepend">
                                <span class="input-group-text">$</span>
                            </div>
                            <input type="text" class="form-control" name="salary" @if(isset($editprofile->salary)) value="{{ $editprofile->salary }}" @endif @if($pmedit->permission_id != 1) readonly @endif>
                            <div class="input-group-append text-right">
                                <span class="input-group-text">.00</span>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="form-group col-2">
                        <label>วันที่เริ่มต้นทำงาน</label>
                        <div class="input-group">
                            <div class="input-group-prepend">
                                <span class="input-group-text"><i class="fa fa-calendar"></i></span>
                            </div>
                            <input id="startdate" type="text" name="startdate" class="form-control" @if(isset($editprofile->start_date)) value="{{  date("d-m-Y", strtotime($editprofile->start_date)) }}" @endif >
                        </div>
                    </div>
                    <div class="form-group col-2">
                        <label>วันที่ลาออก</label>
                        <div class="input-group">
                            <div class="input-group-prepend">
                                <span class="input-group-text"><i class="fa fa-calendar"></i></span>
                            </div>
                            <input id="enddate" type="text" name="enddate" class="form-control" @if(isset($editprofile->end_date)) value="{{  date("d-m-Y", strtotime($editprofile->end_date)) }}" @endif>
                        </div>
                    </div>
                </div>
            </div>
            <div class="card-footer">
                <div class="row">
                    <div class="col-1">
                        <button type="submit" class="btn btn-block btn-outline-primary btn-sm">บันทึก</button>
                    </div>
                    <div class="col-1">
                        <a class="btn btn-block btn-outline-danger btn-sm" href="/apanel">ยกเลิก</a>
                    </div>
                </div>
            </div>
        </form> 
</div>


@stop


@section('script')
<script type="text/javascript">
    $(document).ready(function () {
        
        $('.select2').select2()
        $(".text-dark").append('ข้อมูลผู้ใช้');
        $('[data-mask]').inputmask()
        $('#birthday').datepicker({
            endDate: 'today',
            format: 'dd-mm-yyyy',
            autoclose: true,
        });
        $('#startdate').datepicker({
            format: 'dd-mm-yyyy',
            autoclose: true
        });
        $('#enddate').datepicker({
            format: 'dd-mm-yyyy',
            autoclose: true
        });
    });

    function setprovice(val, id) {
        $(id+" option").each(function(){
            var p = $(this).attr('province');
            if(parseInt(p) == parseInt(val)){
            $(this).prop('disabled', false);
            $(this).show();
            }else{
            $(this).prop('disabled', true);
            $(this).hide();
            }
        });
        $(id).val($(id+" option[province = "+ val +"]:first").val());
    $(".select2").select2();
    }
    

</script>
@stop