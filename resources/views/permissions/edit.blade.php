@extends('admin')
@section('content')
@section('css')
@stop
<div class="container-fluid col-12">
    @if(isset($editpermission))
        <form id="formPermission" role="form" style="margin:15px" action="/permissions/{{ $editpermission[0]->permission_id }}" method="post" accept-charset="utf-8">
            <input type="hidden" name="_method" value="PUT">
    @else
        <form id="formPermission" role="form" style="margin:15px" action="/permissions" method="post" accept-charset="utf-8">
    @endif


            <div class="card card-default">
                <div class="card-header">
                    <h3 class="card-title">จัดการสิทธิ์ในการเข้าถึงแต่ละหน้า</h3>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="form-group col-2">
                            <label for="permission_name">ชื่อสิทธิ์ในการเข้าถึง</label>
                            <input id="permission_name" type="text" class="form-control" name="permission_name" value="@if(isset($editpermission[0]->permission_name)){{ $editpermission[0]->permission_name }}@endif" required>
                        </div>
                    </div>
                    <div class="row">
                        <div class="form-group col-lg-8">
                            {{ csrf_field() }}
                            <!-- permission page -->
                            <div class="panel-group" id="accordion">
                                @foreach($permissions as $item)
                                    @if(isset($editpermission))
                                        <?php $view = 0; ?>
                                        @foreach($editpermission as $permis)
                                            <?php if($permis->menu_id == $item->menu_id){$view = $permis->view;}?>
                                        @endforeach
                                    @endif
                                    @if(isset($currenttype) && $currenttype != $item->menu_type)
                                        <h4 class="text-muted" style="padding: 5px 5px 5px 15px;background-color: #9e9e9e0d;"><i>{{ $item->menu_type }}</i></h4>
                                    @endif
                                    <?php $currenttype = $item->menu_type;  ?>
                                    @if(count($item['children']) > 0)
                                        <div class="panel panel-default">
                                            <div class="panel-heading" style="padding: 5px 10px;background-color: #e6e8e7;">
                                                <label class="panel-title col-lg-5 col-sm-5 col-xs-12" style="float: none;font-size: 14px;">
                                                        <a data-toggle="collapse" data-parent="#accordion" href="#{{ $item->menu_id }}-info">
                                                            <label style="padding-left: 0;" >
                                                                <b><u>{{ $item->menu_name }}</u></b> <span class="label label-default">{{ count($item['children']) }}</span>
                                                            </label> 
                                                        </a>
                                                </label>
                                                <label class="col-lg-6 col-sm-6 col-xs-12" style="float: none;">
                                                    <input type="hidden" id="menu_id[]" name="menu_id[]" value="{{ $item->menu_id }}">
                                                    <input id="view{{ $item->menu_id }}" name="view[]" type="checkbox" value="1" onchange="chkBox('view{{ $item->menu_id }}');autoChecked('{{ $item->menu_id }}','parent')" @if(isset( $view) && $view == 1) checked="true" @endif>View
                                                    <input id="view{{ $item->menu_id }}-hidden" name="view[]" type="hidden" value="0" @if(isset( $view) && $view == 1) disabled="true" @endif>
                                                </label>
                                            </div>
                                            <div id="{{ $item->menu_id }}-info" class="panel-collapse collapse  @if((isset( $view) && $view == 1)) in @endif">
                                                <ul class="list-group panel-body" style="padding: 0">
                                                    @foreach($item['children'] as $child)
                                                        @if(isset($editpermission))
                                                            <?php $view = 0; ?>
                                                            @foreach($editpermission as $permis)
                                                                <?php if($permis->menu_id == $child->menu_id){ $view = $permis->view;}?>
                                                            @endforeach
                                                        @endif
                                                        <li class="list-group-item" style="display: inline-block;width: 100%;padding: 5px 10px;">
                                                            <label class="col-lg-5 col-sm-5 col-xs-12" style="float: none;font-size: 14px;">
                                                                {{ $child->menu_name }}
                                                            </label>
                                                            <label class="col-lg-6 col-sm-6 col-xs-12" style="float: none;">
                                                                <input type="hidden" id="menu_id[]" name="menu_id[]" value="{{ $child->menu_id }}">
                                                                <input id="view{{ $child->menu_id }}" class="childview-{{ $item->menu_id }}" name="view[]" type="checkbox" value="1" onchange="chkBox('view{{ $child->menu_id }}');autoChecked('{{ $child->menu_id }}','child','#view{{ $item->menu_id }}');" @if(isset( $view) && $view == 1) checked="true" @endif>View
                                                                <input id="view{{ $child->menu_id }}-hidden" class="childview-{{ $item->menu_id }}-hidden" name="view[]" type="hidden" value="0" @if(isset( $view) && $view == 1) disabled="true" @endif>
                                                            </label>
                                                        </li>
                                                    @endforeach
                                                </ul>
                                            </div>
                                        </div>
                                    @else
                                        <div class="panel panel-default">
                                            <div class="panel-heading" style="padding: 5px 10px;background-color: #e6e8e7;">
                                                <label class="panel-title col-lg-5 col-sm-5 col-xs-12" style="float: none;font-size: 14px;">
                                                    {{ $item->menu_name }}</b>
                                                </label>
                                                <label class="control-label col-lg-6 col-sm-6 col-xs-12" style="float: none;">
                                                    <input type="hidden" id="menu_id[]" name="menu_id[]" value="{{ $item->menu_id }}">
                                                    <input id="view{{ $item->menu_id }}" name="view[]" type="checkbox" value="1" onchange="chkBox('view{{ $item->menu_id }}');autoChecked('{{ $item->menu_id }}');" @if(isset( $view) && $view == 1) checked="true" @endif>View
                                                    <input id="view{{ $item->menu_id }}-hidden" name="view[]" type="hidden" value="0" @if(isset( $view) && $view == 1) disabled="true" @endif>
                                                </label>
                                            </div>
                                        </div>
                                    @endif
                                @endforeach
                            </div>
                            <!-- permission page -->
                        </div>
                    </div>
                </div>
            </div>
        </form>
</div>
@stop

@section('script')
<script type="text/javascript">
    $(document).ready(function () {
        $('#formPermission').valida();
    })
    function autoChecked(ThisID,level,parent) {
    	if(level == 'parent'){
    	    if($('#view'+ThisID).prop( 'checked' )) {
    			$('.childview-'+ThisID).prop('checked', true);
    			$('.childview-'+ThisID+'-hidden').prop('disabled', true);
    			if($('#'+ThisID+'-info').hasClass("out")) {
       				actionExpand('#'+ThisID+'-info','');
       			}
    		}else if($('#view'+ThisID).prop( 'checked' ) == false) {
    			$('.childview-'+ThisID).prop('checked', false);
    			$('.childview-'+ThisID+'-hidden').prop('disabled', false);
    			if($('#'+ThisID+'-info').hasClass("in")) {
       				actionExpand('#'+ThisID+'-info','');
       			}
    		}
    	}else{
			if(level == 'child' && ( $('#view'+ThisID) .prop( 'checked' ) )){
				$(parent).prop('checked', true);
				$(parent+'-hidden').prop('disabled', true);
			}
    	}
    }
    function chkBox(chkID){
        if($('#'+chkID).prop( 'checked' )) {
            $('#'+chkID).prop('checked', true);
            $('#'+chkID+'-hidden').prop('disabled', true);
        }else{
            $('#'+chkID).prop('checked', false);
            $('#'+chkID+'-hidden').prop('disabled', false);
        }
    }
    function actionExpand(obj,img) {
        if($(obj).hasClass("out")) {
            $(obj).addClass("in");
            $(obj).removeClass("out");
            $(img).addClass("fa-sort-asc");
            $(img).removeClass("fa-sort-desc");
        } else {
            $(obj).addClass("out");
            $(obj).removeClass("in");
            $(img).addClass("fa-sort-desc");
            $(img).removeClass("fa-sort-asc");
        }
    }
</script>
@stop