@extends('admin.layouts.template')
@section('content')
<div class="row">
  <div class="col-md-12">
    <div class="card">
      <div class="card-header">
        <i class="fa fa-table"></i> ค้นหาลูกค้า
      </div>
      <div class="card-body">
        <form class="form-horizontal" role="form" method="POST" action="{{ url('customer_search') }}">
        <input type="hidden" name="_token" value="{{ csrf_token() }}">
          <div class="form-group">
            <div class="form-row">
              <div class="col-md-10">
                <input type="text" class="form-control" name="searchTxt" placeholder="ระบุชื่อ - สกุล ลูกค้าที่ต้องการค้นหา">
              </div>
              <div class="col-md-2">
                <button type="submit" class="btn btn-success">
                  <i class="fa fa-search">ค้นหาลูกค้า</i></button>
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
          <i class="fa fa-table"></i> {{$search ? 'ผลการค้นหา : '.$search : 'ข้อมูลลูกค้า'}}
        </div>
        <div class="col-md-6 text-right">
          <a class="btn btn-sm btn-success" href="{{url('customer')}}" title="Add new User" style="display:{{$search ? '' : 'none;'}}"><i class="fa fa-arrow-left"></i> back</a>
          <a class="btn btn-sm btn-success" href="{{url('customer_form')}}" title="Add new User"><i class="fa fa-plus-square"></i> เพิ่มลูกค้า</a>
        </div>
      </div>
      </div>
      <div class="card-body">
        <div class="table-responsive">
          <table class="table table-striped table-bordered table-sm table-hover">
            <thead>
              <tr>
                <th>No.</th>
                <th>ชื่อ - สกุล</th>
                <th>ที่อยู่</th>
                <th>หมายเลขโทรศัพท์</th>
                <th>action</th>
              </tr>
            </thead>
            <tbody>
              @foreach($customer as $u)
              <tr>
                <td>{{$u->customer_id}}</td>
                <td>{{$u->customer_namelastname}}</td>
                <td>
                  {{$u->customer_addressno}}
                  {{$u->customer_province}} {{$u->customer_district}} {{$u->customer_subdistrict}}
                   {{$u->customer_postal}}
                </td>
                <td>{{$u->customer_tel}}</td>
                <td class="text-center">
                  <a href="{{url('customer_form/'.$u->customer_id)}}" title="" class="edit"><i class="fa fa-edit"></i></a>
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
