@extends('admin.layouts.template')
@section('content')
<div class="row page-header">
  <div class="col-sm-6 padding-top-20">
    <a class="btn btn-default" href="{{url('account')}}" title="ข้อมูลพนักงาน"><i class="fa fa-arrow-left" ></i> Back</a>
  </div>
  <!-- /.col-lg-12 -->
</div>
<!-- /.row -->
<div class="col-md-8 mx-auto">
<div class="card">
  <div class="card-header">
          <i class="fa fa-edit"></i> {{$emp_id != null ? 'แก้ไขข้อมูล' : 'เพิ่มข้อมูล'}}พนักงาน
      </div>
      <div class="card-body">
    <form class="form-horizontal" role="form" method="POST" action="{{ url('account_form_submit') }}">
      <input type="hidden" name="_token" value="{{ csrf_token() }}">

      <div class="form-group" {{ $user ? 'hidden' : '' }}>
        <div class="form-row">
          <div class="col-md-12">
            <label for="emp_id">ID(เลข 5 หลัก)</label>
            <input type="number" class="form-control" name="emp_id" value="{{ $user ? $user->emp_id : old('emp_id') }}">
            {!!$errors->first('emp_id', '<span class="control-label" style="color:red" for="emp_id">*:message</span>')!!}
          </div>
      </div>
      </div>

      <div class="form-group">
        <div class="form-row">
          <div class="col-md-6">
            <label for="emp_username">Username</label>
            <input type="text" class="form-control" name="emp_username" value="{{ $user ? $user->emp_username : old('emp_username') }}">
            {!!$errors->first('emp_username', '<span class="control-label" style="color:red" for="emp_username">*:message</span>')!!}
          </div>
          <div class="col-md-6">
            <label for="emp_password">Password</label>
            <input type="password" class="form-control" name="emp_password" value="{{ $user ? $user->emp_password : old('emp_password') }}">
            {!!$errors->first('emp_password', '<span class="control-label" style="color:red" for="emp_password">*:message</span>')!!}
          </div>
        </div>
      </div>

      <div class="form-group">
        <div class="form-row">
          <div class="col-md-4">
            <label for="emp_name">ชื่อ</label>
            <input type="text" class="form-control" name="emp_name" value="{{ $user ? $user->emp_name : old('emp_name') }}">
            {!!$errors->first('emp_name', '<span class="control-label" style="color:red" for="emp_name">*:message</span>')!!}
          </div>
          <div class="col-md-4">
            <label for="emp_lastname">นามสกุล</label>
            <input type="text" class="form-control" name="emp_lastname" value="{{ $user ? $user->emp_lastname : old('emp_lastname') }}">
            {!!$errors->first('emp_lastname', '<span class="control-label" style="color:red" for="emp_lastname">*:message</span>')!!}
          </div>
          <div class="col-md-4">
            <label for="emp_tel">Tel.</label>
            <input type="text" class="form-control" name="emp_tel" value="{{ $user ? $user->emp_tel : old('emp_tel') }}">
            {!!$errors->first('emp_tel', '<span class="control-label" style="color:red" for="emp_tel">*:message</span>')!!}
        </div>
      </div>

      <div class="form-group" style="margin-top: 1%">
        <center><label class="control-label">ตำแหน่ง</label>
        <div class="col-md-6">
          <label class="radio-inline">
            <input type="radio" name="emp_position" value="Admin" {{ $user ? $user->emp_position == 'Admin' ? 'checked' : '' : '' }}>Admin
          </label> |
          <label class="radio-inline">
            <input type="radio" name="emp_position" value="Sale" {{ $user ? $user->emp_position == 'Sale' ? 'checked' : '' : '' }}>Sale
          </label> |
          <label class="radio-inline">
            <input type="radio" name="emp_position" value="Manager" {{ $user ? $user->emp_position == 'Manager' ? 'checked' : '' : '' }}>Manager
          </label>
          {!!$errors->first('emp_position', '<span class="control-label" style="color:red" for="emp_position">*:message</span>')!!}
        </div>
        </center>
      </div>

      <div class="form-group">
        <div class="col-md-12">
          <button type="submit" class="btn btn-block btn-success">
            <i class="fa fa-save"></i>{{$emp_id == 0 ? ' เพิ่ม USER':' แก้ไข USER'}}</button>
          <a href="{{url('account_form_submit')}}" style="visibility: hidden"><i class="fa fa-user-md"></i>New User</a>
        </div>
      </div>

    </form>
  </div>
  </div>
</div>
</div>
@stop
