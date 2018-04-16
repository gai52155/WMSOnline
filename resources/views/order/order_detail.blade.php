@extends('admin.layouts.template')
@section('content')
<div class="row">
  <div class="col-md-6 mx-auto">
    <a class="btn btn-default" href="{{url('order')}}" title="Back"><i class="fa fa-arrow-left" ></i> Back</a>
    <div class="card" style="margin-top: 1%">
      <div class="card-header">
        <div class="row">
        <div class="col-md-6">
          <i class="fa fa-table"></i> ข้อมูลในใบเสนอราคา หมายเลข : {{ $order_id }}
        </div>
        <div class="col-md-6 text-right">
          <a class="btn btn-sm btn-success" href="{{url('/order')}}" title="ย้อนกลับ"><i class="fa fa-arrow-left"></i> back</a>
        </div>
      </div>
      </div>
      <div class="card-body">
        <div class="table-responsive">
          <table class="table table-striped table-bordered table-sm table-hover">
            <thead>
              <tr>
                <th class="text-center">รหัสสินค้า</th>
                <th class="text-center">ชื่อสินค้า</th>
                <th class="text-center">จำนวนที่สั่งซื้อ</th>

                @if($chkPay == 0)
                <th class="text-center">Action</th>
                @endif
              </tr>
            </thead>
            <tbody>
              @foreach($order as $u)
              <tr>
                <td class="text-center">{{$u->goods_id}}</td>
                <td class="text-center">{{$u->goods_name}}</td>
                <td class="text-center">{{$u->goods_detail_amount}}</td>

                @if($chkPay == 0)
                <td class="text-center">
                  <a href="" class="edit" id="editOrderDetail" data-toggle="modal" data-target="#editModal" onclick="editId({{$u->goods_id}},{{$u->goods_detail_amount}})"><i class="fa fa-edit"></i></a>
                  <a href="{{url('order_detail/delete/'.$u->order_id.'/'.$u->goods_id)}}" title="" class="del"><i class="fa fa-remove"></i></a>
                </td>
                @endif
              </tr>
              @endforeach
            </tbody>
          </table>
        </div>
      </div>
    </div>
  </div>
</div>
  <!-- Modal -->
  <div class="modal fade" id="editModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
      <div class="modal-dialog" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabel">แก้ไขสินค้า : <a id=editGoodsId></a></h5>
            <button class="close" type="button" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">×</span>
            </button>
          </div>
          <div class="modal-body">
            <div class="col-md-8 mx-auto">
            <label for="productBuyCount">จำนวนที่สั่งซื้อใหม่</label>
              <form class="form-horizontal" role="form" method="POST" action="{{ url('orderDetailEditSubmit/'.$order_id) }}">
                <input type="hidden" name="_token" value="{{ csrf_token() }}">

                <input type="hidden" id="goods_id" name="goods_id" value="">

                <input type="hidden" id="oldValue" name="oldValue" value="">

                <input type="number" class="form-control" name="newValue" id="newValue" placeholder="จำนวนสั่งซื้อ">
                  {!!$errors->first('newValue', '<span class="control-label" style="color:red" for="newValue">*:message</span>')!!}
              
            </div>
          </div>
          <div class="modal-footer">
            <button class="btn btn-secondary" type="button" data-dismiss="modal">ยกเลิก</button>
            <input type="submit" class="btn btn-success" href="" value="ยืนยันการแก้ไขจำนวน">
          </div>
          </form>
        </div>
      </div>
    </div>

    <script>
      function editId(id,oldvalue){
        $('#editGoodsId').text(id);
        $('#goods_id').val(id);
        $('#oldValue').val(oldvalue);
      }
    </script>
@stop
