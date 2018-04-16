@extends('admin.layouts.template')
@section('content')
<div class="row">
  <div class="col-md-12">
    <div class="card">
      <div class="card-header">
        <i class="fa fa-table"></i> ค้นหาคลังสินค้า
      </div>
      <div class="card-body">
        <form class="form-horizontal" role="form" method="POST" action="{{ url('warehouse_search') }}">
        <input type="hidden" name="_token" value="{{ csrf_token() }}">
          <div class="form-group">
            <div class="form-row">
              <div class="col-md-10">
                <input type="text" class="form-control" name="searchTxt" placeholder="ระบุรหัสคลังสินค้าที่ต้องการค้นหา">
              </div>
              <div class="col-md-2">
                <button type="submit" class="btn btn-success">
                  <i class="fa fa-search">ค้นหาคลังสินค้า</i></button>
                  <a href="{{url('account_search')}}" style="visibility: hidden"><i class="fa fa-user-md"></i>New User</a>
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
          <i class="fa fa-table"></i> {{$search ? 'ผลการค้นหา : '.$search : 'ข้อมูลคลังสินค้า'}}
        </div>
        <div class="col-md-6 text-right">
          <a class="btn btn-sm btn-success" href="{{url('warehouse')}}" title="Add new User" style="display:{{$search ? '' : 'none;'}}"><i class="fa fa-arrow-left"></i> back</a>
          <a class="btn btn-sm btn-success" href="{{url('warehouse_form')}}" title="Add new User"><i class="fa fa-plus-square"></i> เพิ่มคลังสินค้า</a>
        </div>
      </div>
      </div>
      <div class="card-body">
        <div class="table-responsive">
          <table class="table table-striped table-bordered table-sm table-hover">
            <thead>
              <tr>
                <th>No.</th>
                <th>วันที่เข้าใช้งานล่าสุด</th>
                <th>สถานะคลังสินค้า</th>
                <th>จำนวนชั้นวางสินค้า</th>
                <th>จำนวนชั้น</th>
                <th>จำนวนช่องเก็บของ</th>
                <th>Action</th>
              </tr>
            </thead>
            <tbody>
              @foreach($storage as $u)
              <tr>
                <td><a href="{{url('warehouse_detail/'.$u->warehouse_id)}}">{{$u->warehouse_id}}</a></td>
                <td>{{$u->warehouse_access_date}}</td>
                <td>
                  @if($u->warehose_status == 1) {{ 'คลังสินค้านี้เต็มแล้ว' }} @else {{ 'ยังมีทีพื้นที่คลังว่าง' }} @endif
                </td>
                <td>{{$u->warehouse_storageCount}}</td>
                <td>{{$u->warehouse_floorCount}}</td>
                <td>{{$u->warehouse_slotCount}}</td>
                <td class="text-center">
                  <a href="{{url('warehouse_form/'.$u->warehouse_id)}}" title="" class="edit"><i class="fa fa-edit"></i></a>
                  <a href="{{url('admin/user/delete/'.$u->id)}}" title="" class="del"><i class="fa fa-remove"></i></a>
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
