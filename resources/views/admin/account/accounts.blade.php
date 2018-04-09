@extends('admin.layouts.template') @section('content')
<div class="row">
  <div class="col-md-12">
    <div class="card">
      <div class="card-header">
        <i class="fa fa-table"></i> ค้นหาพนักงาน
      </div>
      <div class="card-body">
        <form class="form-horizontal" role="form" method="POST" action="{{ url('account_search') }}">
        <input type="hidden" name="_token" value="{{ csrf_token() }}">
          <div class="form-group">
            <div class="form-row">
              <div class="col-md-6">
                <select class="form-control" name="searchSel">
                  <option value="emp_id">รหัส USER</option>
                  <option value="emp_name">ชื่อ - สกุล</option>
                  <option value="emp_position">ตำแหน่ง</option>
                  <option value="emp_tel">เบอร์โทรศัพท์</option>
                </select>
              </div>
              <div class="col-md-4">
                <input type="text" class="form-control" name="searchTxt" placeholder="ค้นหาพนักงาน">
              </div>
              <div class="col-md-2">
                <button type="submit" class="btn btn-success">
                  <i class="fa fa-search"> ค้นหาพนักงาน</i></button>
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
          <i class="fa fa-table"></i> {{$search ? 'ผลการค้นหาพนักงาน : '.$search : 'ข้อมูลพนักงาน'}}
        </div>
        <div class="col-md-6 text-right">
          <a class="btn btn-sm btn-success" href="{{url('account')}}" title="ย้อนกลับ" style="display:{{$search ? '' : 'none;'}}"><i class="fa fa-arrow-left"></i> back</a>
          <a class="btn btn-sm btn-success" href="{{url('account_form')}}" title="เพิ่มพนักงาน"><i class="fa fa-plus-square"></i> เพิ่ม USER</a>
        </div>
      </div>
      </div>
      <div class="card-body">
        <div class="table-responsive">
          <table class="table table-striped table-bordered table-sm table-hover" id="dataTable" width="100%" cellspacing="0">
            <thead>
              <tr>
                <th>No.</th>
                <th>ชื่อ - สกุล</th>
                <th>ตำแหน่ง</th>
                <th>USERNAME</th>
                <th>PASSWORD</th>
                <th>tel no.</th>
                <th>STATUS</th>
                <th>LAST_LOGIN</th>
                <th>Action</th>
              </tr>
            </thead>
            <tbody>
              @foreach($emp as $u)
              <tr>
                <td>{{$u->emp_id}}</td>
                <td>{{$u->emp_name}}</td>
                <td>{{$u->emp_position}}</td>
                <td>{{$u->emp_username}}</td>
                <td>{{$u->emp_password}}</td>
                <td>{{$u->emp_tel}}</td>
                <td>
                  @if($u->emp_status == 1) {{ 'อยู่ในระบบ' }} @else {{ 'ไม่อยู่ในระบบ' }} @endif
                </td>
                <td>{{$u->emp_last_login}}</td>
                <td class="text-center">
                  <a href="{{url('account_form/'.$u->emp_id)}}" title="" class="edit"><i class="fa fa-edit"></i></a>
                  <a href="{{url('delete/'.$u->emp_id)}}" title="" class="del"><i class="glyphicon glyphicon-remove"></i></a>
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
