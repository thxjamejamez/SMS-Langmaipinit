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
@stop
<div class="container-fluid">
    <form action="/user" method="POST" accept-charset="utf-8">
    {{ csrf_field() }}
    <div class="card card-default">
        <div class="card-header">
            <h3 class="card-title">จัดการข้อมูลผู้ใช้</h3>
        </div>
        <div class="card-body">
            <div class="row">
                <div class="form-group col-2">
                    <label for="username">ชื่อผู้ใช้</label>
                    <input id="username" type="text" class="form-control" name="username" required>
                </div>
                <div class="form-group col-2">
                    <label for="password">รหัสผ่าน</label>
                    <input id="password" type="password" class="form-control" name="password" required>
                </div>
                <div class="form-group col-2">
                    <label>สิทธิ์ในการเข้าถึง</label>
                    <select id="permission" class="form-control" name="permission" disabled>
                        @foreach($group_permission as $group_permissions)
                        <option value="{{ $group_permissions->id }}">{{ $group_permissions->permission_name }}</option>
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
                            <option value="{{ $titles->title_id }}">{{ $titles->title_name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group col-3">
                        <label for="firstname">ชื่อ</label>
                        <input id="firstname" type="text" class="form-control" name="firstname">
                    </div>
                    <div class="form-group col-3">
                        <label for="firstname">นามสกุล</label>
                        <input type="text" class="form-control" name="lastname">
                    </div>
                </div>
                <div class="row">
                    <div class="form-group col-5">
                        <label>ที่อยู่</label>
                        <textarea class="form-control" rows="1" name="address"></textarea>
                    </div>

                    <div class="form-group col-3">
                        <label>จังหวัด</label>
                        <select id="province" name="province" class="form-control select2" style="width: 100%;" onchange="setprovice(this.value, '#district')">
                            @foreach($province as $provinces)
                            <option value="{{ $provinces->province_id }}">{{ $provinces->province_name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group col-3">
                        <label>อำเภอ</label>
                        <select id="district" name="district" class="form-control select2" style="width: 100%;">
                            @foreach($district as $districts)
                            <option value="{{ $districts->city_id }}" province="{{ $districts->province_id }}">{{ $districts->city_name }}</option>
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
                            <input type="text" name="tel" class="form-control" data-inputmask='"mask": "(999) 999-9999"' data-mask>
                        </div>
                    </div>
                    <div class="form-group col-3">
                        <label>อีเมล์</label>
                        <div class="input-group mb-3">
                            <div class="input-group-prepend">
                                <span class="input-group-text"><i class="fa fa-envelope"></i></span>
                            </div>
                            <input type="email" name="email" class="form-control" placeholder="example@hotmail.com" required>
                        </div>
                    </div>
                    <div class="form-group col-2">
                        <label>วัน/เดือน/ปีเกิด</label>
                        <div class="input-group">
                            <div class="input-group-prepend">
                            <span class="input-group-text"><i class="fa fa-calendar"></i></span>
                            </div>
                            <input id="birthday" type="text" name="birthdate" class="form-control">
                        </div>
                    </div>
                </div>
            <div class="row">
                <div class="form-group col-2">
                <label>
                    <input type="checkbox" class="flat-red" id="company" name="company" value="1">
                    บริษัท
                </label>
                </div>
            </div>
            <div id="companydetail">
                <div class="row">
                    <div class="form-group col-4">
                        <label for="companyname">ชื่อบริษัท</label>
                        <input id="companyname" type="text" class="form-control" name="companyname">
                    </div>
                    <div class="form-group col-1">
                        <label for="creditcompany">เครดิต</label>
                        <input id="creditcompany" type="text" class="form-control" name="creditcompany">
                    </div>
                </div>
                <div class="row">
                    <div class="form-group col-5">
                        <label>ที่อยู่ในการจัดส่งสินค้า</label>
                        <textarea class="form-control" rows="1" name="address_company"></textarea>
                    </div>
                    <div class="form-group col-3">
                        <label>จังหวัด</label>
                        <select id="province_company" name="province_company" class="form-control select2" style="width: 100%;" onchange="setprovice_company(this.value, '#district_company')">
                            @foreach($province as $provinces)
                            <option value="{{ $provinces->province_id }}">{{ $provinces->province_name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group col-3">
                        <label>อำเภอ</label>
                        <select id="district_company" name="district_company" class="form-control select2" style="width: 100%;">
                            @foreach($district as $districts)
                            <option value="{{ $districts->city_id }}" provincecompany="{{ $districts->province_id }}">{{ $districts->city_name }}</option>
                            @endforeach
                        </select>
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
                        <button type="reset" class="btn btn-block btn-outline-danger btn-sm">ยกเลิก</button>
                    </div>
                </div>
            </div>
        </form> 
</div>


@stop


@section('script')
<script type="text/javascript">
    $(document).ready(function () {
        $('input[type="checkbox"].flat-red, input[type="radio"].flat-red').iCheck({
            checkboxClass: 'icheckbox_flat-green',
            radioClass   : 'iradio_flat-green'
        })
        $('#permission').val(6);
        $('.select2').select2()
        $(".text-dark").append('ข้อมูลผู้ใช้');
        $('[data-mask]').inputmask()
        $('#birthday').datepicker({
            format: 'dd-mm-yyyy',
            autoclose: true
        });
        $('#startdate').datepicker({
            format: 'dd-mm-yyyy',
            autoclose: true
        });
        $('#enddate').datepicker({
            format: 'dd-mm-yyyy',
            autoclose: true
        });
        $('#companydetail').hide();
    });

    $('#company').on('ifChanged', function(event){
        if ($(this).prop('checked')) {
            $('#companydetail').show();
        }else{
            $('#companydetail').hide();
        }
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

    function setprovice_company(val, id) {
        $(id+" option").each(function(){
            var p = $(this).attr('provincecompany');
            if(parseInt(p) == parseInt(val)){
            $(this).prop('disabled', false);
            $(this).show();
            }else{
            $(this).prop('disabled', true);
            $(this).hide();
            }
        });
        $(id).val($(id+" option[provincecompany = "+ val +"]:first").val());
        $(".select2").select2();
    }

    

</script>
@stop