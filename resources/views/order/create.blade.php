@extends('admin')
@section('content')
@section('css')
    <link rel="stylesheet" href="/plugins/datepicker/datepicker3.css">
    <link rel="stylesheet" href="/css/requireorder/app.css">
@stop
<div class="container-fluid" id="app">
    <div class="row">
        <div class="col-lg-8">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title"><i class="fa fa-cart-arrow-down"></i>&nbsp;&nbsp;สินค้าที่สั่งซื้อ</h3>
                </div>
                <div class="card-body">
                    <div class="card-body p-0">
                        <table class="table table-condensed">
                            <tr>
                                <th style="width: 10px">#</th>
                                <th>ประเภทสินค้า</th>
                                <th>ชื่อสินค้า</th>
                                <th>ขนาดสินค้า</th>
                                <th class="text-right">ราคาต่อหน่วย</th>
                                <th class="text-center">จำนวนที่สั่งซื้อ</th>
                                <th class="text-right">ราคารวม</th>
                                <th style="width: 10px"></th>
                            </tr>
                            <tr v-for="(obj, key) in form">
                                <td>@{{ key+1 }}</td>
                                <td>@{{ obj.type_name }}</td>
                                <td>@{{ obj.product_name }}</td>
                                <td>@{{ obj.product_size }}</td>
                                <td class="text-right">@{{ obj.price | formatP }}</td>
                                <td class="text-center"><input type="number" min="1" v-model.number="form[key].qty" @change="sumpd()" @click="sumpd()" class="text-center" style="width: 70px"></td>
                                <td class="text-right">@{{ (obj.price*obj.qty) | formatP }}</td> 
                                <td><div class="btn btn-block btn-danger btn-sm" @click="delinCart(obj)"><i class="fa fa-trash"></i></div></td>                      
                            </tr>
                            <tr style="background-color: #E0E0E0">
                                <td colspan="6"><b>รวมทั้งสิ้น</b></td>
                                <td class="text-right"><b>@{{ sum | formatP }}</b></td>
                                <td><b>บาท</b></td>
                            </tr>
                        </table>
                      </div>
                </div>
            </div>
        </div>
        <div class="col-lg-4">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title"><i class="fa fa-dropbox"></i>&nbsp;&nbsp;รายการสินค้า</h3>
                </div>
                <div class="card-body scroll-x">
                    <div id="product" 
                        v-for="(obj, key) in dt">
                        <div class="boxx" v-on:click="addtoCart(obj)">
                            <div class="pd">
                                <i class="ion-cube"></i>
                                (@{{ obj.type_name }}) @{{ obj.product_name }}, @{{ obj.product_size }}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title"><i class="fa fa-info-circle"></i>&nbsp;&nbsp;รายละเอียดการสั่งซื้อ</h3>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="form-group col-6">
                            <label>หมายเหตุ</label>
                            <textarea class="form-control" name="re_detail" rows="3" placeholder="" v-model="order_detail"></textarea>
                        </div>
                        <div class="form-group col-3">
                            <label for="file">ไฟล์แนบ</label>
                            <div class="input-group">
                                <input type="file" class="form-control-file" name="orderfile" ref="myFiles" @change="previewFiles">
                            </div>
                        </div>
                        <div class="form-group col-2">
                            <label>วันที่ส่งสินค้า</label>
                            <div class="input-group">
                                <div class="input-group-prepend">
                                    <span class="input-group-text"><i class="fa fa-calendar"></i></span>
                                </div>
                                <input id="senddate" type="text" name="senddate" class="form-control" v-model="senddate">
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card-footer">
                    <div class="row">
                        <div class="col-1">
                            <button @click="onSave()" class="btn btn-block btn-outline-primary btn-sm">บันทึก</button>
                        </div>
                        <div class="col-1">
                            <button type="reset" class="btn btn-block btn-outline-danger btn-sm">ยกเลิก</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@stop
@section('script')
<script src="/js/requireorder/app.js?v=<?php echo filemtime('js/requireorder/app.js')?>"></script>
@stop