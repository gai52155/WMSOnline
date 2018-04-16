@extends('admin.layouts.template')
@section('content')
<div class="row">
  <div class="col-md-12">
    <div class="card">
      <div class="card-header">
        <i class="fa fa-table"></i> ค้นหาใบเสนอราคา
      </div>
      <div class="card-body">
        <form class="form-horizontal" role="form" method="POST" action="{{ url('order_search') }}">
        <input type="hidden" name="_token" value="{{ csrf_token() }}">
          <div class="form-group">
            <div class="form-row">
              <div class="col-md-3">
                <select class="form-control" id="searchSel" name="searchSel">
                  <option value="order_id">รหัสใบเสนอราคา</option>
                  <option value="customer_name">ชื่อผู้สั่งซื้อ</option>
                </select>
              </div>
              <div class="col-md-5">
                <input type="text" class="form-control" id="searchTxt" name="searchTxt" placeholder="ค้นหาใบเสนอราคา">
              </div>

              <div class="col-md-2">
                <select class="form-control" id="searchPayType" name="searchPayType">
                  <option value="0">ยังไม่ชำระเงิน</option>
                  <option value="1">ชำระเงินแล้ว</option>
                  <option value="99" hidden>-</option>
                </select>
              </div>

              <div class="col-md-2">
                <button type="submit" class="btn btn-success">
                  <i class="fa fa-search">ค้นหาใบเสนอราคา</i></button>
                  <a href="{{url('goods_search')}}" style="visibility: hidden"><i class="fa fa-user-md"></i>New User</a>
              </div>
            </div>
          </div>
        </form>
      </div>
    </div>

    <div class="card" style="margin-top: 1%">
      <div class="card-header">
        <div class="row">
        <div class="col-md-6">
          <i class="fa fa-table"></i> ข้อมูลใบเสนอราคา
        </div>
        <div class="col-md-6 text-right">
          <a class="btn btn-sm btn-success" href="{{url('/order')}}" title="ย้อนกลับ" style="display:{{$search ? '' : 'none;'}}"><i class="fa fa-arrow-left"></i> back</a>
          <a class="btn btn-sm btn-success" href="{{url('/order_form')}}" title="เพิ่มการสั่งซื้อ"><i class="fa fa-plus-square"></i> สร้างใบเสนอราคา</a>
        </div>
      </div>
      </div>
      <div class="card-body">
        <div class="table-responsive">
          <table class="table table-striped table-bordered table-sm table-hover">
            <thead>
              <tr>
                <th class="text-center">No.</th>
                <th class="text-center">ผู้สั่งซื้อ</th>
                <th class="text-center">ยอดรวม</th>
                <th class="text-center">วันที่สั่งซื้อ</th>
                <th class="text-center">ประเภทการจ่ายเงิน</th>
                <th class="text-center">อายุการสั่งสินค้า</th>
                <th class="text-center">สถานะการชำระเงิน</th>
                <th class="text-center">สถานะการส่งสินค้า</th>
                <th class="text-center">ผู้รับ ORDER</th>

                <th class="text-center">Action</th>
              </tr>
            </thead>
            <tbody>
              @foreach($order as $u)
              <tr>
                <td class="text-center"><a href="{{url('order/'.$u->order_id)}}">{{$u->order_id}}</a></td>
                <td class="text-center">{{$u->customer_namelastname}}</td>
                <td class="text-center">{{number_format($u->order_summary)}}</td>
                <td class="text-center">{{$u->order_date}}</td>
                <td class="text-center">@if($u->order_payment_type == 0) {{ 'ชำระเงินปลายทาง' }} @else {{ 'ชำระผ่านบัตรเครดิต' }} @endif</td>
                <td class="text-center">{{$u->order_payment_term}}</td>
                <td class="text-center">@if($u->order_payment_status == 0)
                      <center><a href="{{url('order/confirm/'.$u->order_id)}}" title="" class="btn btn-sm btn-success"><i class="fa fa-check-circle"> ยินยันการชำระเงิน</i></a></center>
                    @else 
                        {{ 'ชำระเงินแล้ว' }}
                    @endif
                </td>
                <td class="text-center">@if($u->order_delivery_status == 0)
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
                <td class="text-center">{{$u->emp_name}}</td>

                <td class="text-center">
                  <a href="{{url('print_order/'.$u->order_id)}}" title="" class="del"><i class="fa fa-file-pdf-o"></i></a>
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
<script>
  $(document).ready(function() {
    $("#searchSel").val('order_id');
    $("#searchTxt").val('');
    $("#searchPayType").val('99');
    $('#searchPayType').prop('disabled', true);

    $('#searchSel').on('change', function() {
      var typeSearch = $('#searchSel').find(":selected").val();
      if(typeSearch == 'customer_name'){
        $("#searchPayType").val('0');
        $('#searchPayType').prop('disabled', false);
      }
      else{
        $("#searchPayType").val('99');
        $('#searchPayType').prop('disabled', true);
      }
    });
  });
</script>
@stop
