@extends('admin.layouts.template')
@section('content')
<div class="row">
  <div class="col-md-12">
    <a class="btn btn-default" href="{{url('order')}}" title="Back"><i class="fa fa-arrow-left" ></i> Back</a>
    <div class="card" style="margin-top: 1%">
      <div class="card-header">
        <div class="row">
        <div class="col-md-6">
          <i class="fa fa-table"></i> ข้อมูลในใบเสนอราคา หมายเลข : {{ $order_id }}
        </div>
        <div class="col-md-6 text-right">
          <a class="btn btn-sm btn-success" href="{{url('order_form')}}" title="เพิ่มการสั่งซื้อ"><i class="fa fa-plus-square"></i> สร้างใบเสนอราคา</a>
        </div>
      </div>
      </div>
      <div class="card-body">
        <div class="table-responsive">
          <table class="table table-striped table-bordered table-sm table-hover">
            <thead>
              <tr>
                <th>รหัสสินค้า</th>
                <th>จำนวนที่สุ่งซื้อ</th>

                <th>Action</th>
              </tr>
            </thead>
            <tbody>
              @foreach($order as $u)
              <tr>
                <td>{{$u->goods_id}}</td>
                <td>{{$u->goods_detail_amount}}</td>

                <td class="text-center">
                  <a href="" class="edit" id="editOrderDetail"><i class="fa fa-edit"></i></a>
                  <a href="{{url('order_detail/delete/'.$u->order_id.'/'.$u->goods_id)}}" title="" class="del"><i class="glyphicon glyphicon-remove"></i></a>
                </td>
              </tr>
              @endforeach
            </tbody>
          </table>
        </div>
      </div>
    </div>
  </div>
</div>
@stop
