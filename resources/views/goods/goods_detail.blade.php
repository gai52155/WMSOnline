@extends('admin.layouts.template')
@section('content')
<div class="row">
  <div class="col-md-12">
      <a class="btn btn-default" href="{{url('goods')}}" title="Back"><i class="fa fa-arrow-left" ></i> Back</a>

  <div class="card" style="margin-top: 1%">
      <div class="card-header">
        <div class="row">
        <div class="col-md-6">
          <i class="fa fa-table"></i> รายละเอียดสินค้าหมายเลข : {{$goods_id}}
        </div>
        <div class="col-md-6 text-right">
          <a class="btn btn-sm btn-success" href="{{url('goods_detail_form/'.$goods_id)}}" title="Add new User"><i class="fa fa-plus-square"></i> เพิ่มข้อมูลการนำเข้าสินค้า</a>
        </div>
      </div>
      </div>
  <div class="card-body">
  <div class="table-responsive">  
    <table class="table table-striped table-bordered table-hover">
      <thead>
        <tr>
          <th>No.</th>
          <th>ช่วงเวลาที่นำเข้า</th>
          <th>จำนวนที่นำเข้า</th>
          <th>จำนวนที่ไม่ได้มาตรฐาน</th>
          <th>ราคาสินค้า</th>
          <th>ผู้บันทึกการนำเข้า</th>
          <th>Action</th>
        </tr>
      </thead>
      <tbody>
        @foreach($goods as $u)
        <tr>
          <td>{{$u->goods_id}}</td>
          <td>{{$u->goods_period}}</td>
          <td>{{$u->goods_amount}}</td>
          <td>{{$u->goods_waste}}</td>
          <td>{{$u->goods_import}}</td>
          <td>{{$u->emp_name}}</td>
          <td class="text-center">
            <a href="{{url('goods_detail_edit/'.$u->goods_id.'/'.$u->goods_period)}}" title="" class="edit"><i class="fa fa-edit"></i></a>
          </td>
        </tr>
        @endforeach
      </tbody>
    </table>
  </div>
</div>
</div>
</div>
@stop
