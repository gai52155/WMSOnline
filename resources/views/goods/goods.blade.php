@extends('admin.layouts.template') @section('content')
<div class="row">
  <div class="col-md-12">
    <div class="card">
      <div class="card-header">
        <i class="fa fa-table"></i> ค้นหาสินค้า
      </div>
      <div class="card-body">
        <form class="form-horizontal" role="form" method="POST" action="{{ url('goods_search') }}">
        <input type="hidden" name="_token" value="{{ csrf_token() }}">
          <div class="form-group">
            <div class="form-row">
              <div class="col-md-5">
                <select class="form-control" name="searchSel">
                  <option value="goods_id">รหัสสินค้า</option>
                  <option value="goods_name">ชื่อสินค้า</option>
                </select>
              </div>
              <div class="col-md-5">
                <input type="text" class="form-control" name="searchTxt" placeholder="ค้นหาสินค้า">
              </div>
              <div class="col-md-2">
                <button type="submit" class="btn btn-success">
                  <i class="fa fa-search">ค้นหาสินค้า</i></button>
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
          <i class="fa fa-table"></i> {{$search ? 'ผลการค้นหา : '.$search : 'ข้อมูลสินค้า'}}
        </div>
        <div class="col-md-6 text-right">
          <a class="btn btn-sm btn-success" href="{{url('goods')}}" title="Add new User" style="display:{{$search ? '' : 'none;'}}"><i class="fa fa-arrow-left"></i> back</a>
          <a class="btn btn-sm btn-success" href="{{url('goods_form')}}" title="Add new User"><i class="fa fa-plus-square"></i> เพิ่มสินค้า</a>
        </div>
      </div>
      </div>
      <div class="card-body">
        <div class="table-responsive">
          <table class="table table-striped table-bordered table-sm table-hover">
            <thead>
              <tr>
                <th>No.</th>
                <th>ชื่อสินค้า</th>
                <th>สินค้าเหลือทั้งหมด</th>
                <th>ราคาสินค้า</th>
                <th>ราคาเดิม</th>
                <th>จำนวนที่ถูกสั่งจอง</th>
                <th>Action</th>
              </tr>
            </thead>
            <tbody>
              @foreach($goods as $u)
              <tr>
                <td><a href="{{url('goods_detail/'.$u->goods_id)}}">{{$u->goods_id}}</a></td>
                <td>{{$u->goods_name}}</td>
                <td>@if ($u->goods_amount == 0)
                      สินค้าหมดแล้ว
                  @elseif($u->goods_amount < $u->goods_limit)
                    <a style="color:red;">{{ $u->goods_amount }} *สินค้าใกล้หมดแล้ว</a>
                  @else
                    {{number_format($u->goods_amount)}}
                  @endif
                </td>
                <td>{{number_format($u->goods_price)}}</td>
                <td>{{number_format($u->goods_oldprice)}}</td>
                <td>{{$u->goods_booked}}</td>
                <td class="text-center">
                  <a href="{{url('goods_edit/'.$u->goods_id)}}" title="" class="edit"><i class="fa fa-edit"></i></a>
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
  $('th, td').addClass('text-center');
</script>
@stop
