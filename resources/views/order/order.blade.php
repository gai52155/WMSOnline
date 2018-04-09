@extends('admin.layouts.template')
@section('content')
<div class="row">
  <div class="col-md-12">
    <div class="card" style="margin-top: 1%">
      <div class="card-header">
        <div class="row">
        <div class="col-md-6">
          <i class="fa fa-table"></i> ข้อมูลใบเสนอราคา
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
                <th>No.</th>
                <th>ผู้สั่งซื้อ</th>
                <th>ยอดรวม</th>
                <th>วันที่สุ่งซื้อ</th>
                <th>ประเภทการจ่ายเงิน</th>
                <th>อายุการสั่งสินค้า</th>
                <th>สถานะการชำระเงิน</th>
                <th>สถานะการส่งสินค้า</th>
                <th>ผู้รับ ORDER</th>

                <th>Action</th>
              </tr>
            </thead>
            <tbody>
              @foreach($order as $u)
              <tr>
                <td><a href="{{url('order/'.$u->order_id)}}">{{$u->order_id}}</a></td>
                <td>{{$u->customer_namelastname}}</td>
                <td>{{$u->order_summary}}</td>
                <td>{{$u->order_date}}</td>
                <td>@if($u->order_payment_type == 0) {{ 'ชำระเงินปลายทาง' }} @else {{ 'ชำระผ่านบัตรเครดิต' }} @endif</td>
                <td>{{$u->order_payment_term}}</td>
                <td>@if($u->order_payment_status == 0)
                      <center><a href="{{url('order/confirm/'.$u->order_id)}}" title="" class="btn btn-sm btn-success"><i class="fa fa-check-circle"> ยินยันการชำระเงิน</i></a></center>
                    @else 
                        {{ 'ชำระเงินแล้ว' }}
                    @endif
                </td>
                <td>@if($u->order_delivery_status == 0)
                      @if($u->order_payment_status == 1)
                        <center><a href="{{url('order_delivery/confirm/'.$u->order_id)}}" title="" class="btn btn-sm btn-success"><i class="fa fa-check-circle"> ยินยันการจัดส่ง</i></a></center>
                      @else
                        {{ 'ยังไม่ได้จัดส่ง' }} 
                      @endif
                    @elseif($u->order_delivery_status == 1) 
                      {{ 'จัดส่งเรียบร้อยแล้ว' }}
                    @else {{ 'รับสินค้าด้วยตนเอง' }}
                  @endif
                </td>
                <td>{{$u->emp_name}}</td>

                <td class="text-center">
                  <a href="" title="" class="del"><i class="fa fa-file-pdf-o"></i></a>
                  @if($u->order_payment_status == 0)
                  <a href="{{url('order/delete/'.$u->order_id)}}" title="" class="del"><i class="fa fa-times"></i></a>
                  @endif
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
