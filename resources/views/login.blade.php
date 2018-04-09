<!DOCTYPE html>
<html lang="en">
<head>
    <!-- Standard Meta -->
    <meta charset="utf-8"/>
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1"/>
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0">

    <!-- Site Properties -->
    <title>Bootstrap 4 Login Form</title>

    <!-- Stylesheets -->
    @include('admin.layouts.inc-stylesheet') @yield('stylesheet')
</head>
<body>
<div class="col-md-4 mx-auto" style="margin-top: 10%">
	<div class="card">
  		<div class="card-header">
    		<center><i class="fa fa-edit"></i> เข้าสู่ระบบ WMSOnline</center>
  		</div>
  		<div class="card-body">
	        <form class="form-horizontal" role="form" method="POST" action="loginme">
	        	<input type="hidden" name="_token" value="{{ csrf_token() }}">
	        	<div class="form-group">
			        <div class="form-row">
			          <div class="col-md-12">
			            <label for="emp_username">Username</label>
						<input type="text" class="form-control" name="emp_username">
			          </div>
			    </div>
			    <div class="form-group">
			        <div class="form-row">
			          <div class="col-md-12">
			            <label for="emp_password">Password</label>
						<input type="password" class="form-control" name="emp_password">
			          </div>
			    </div>
			</div>
	        <button type="submit" class="btn btn-block btn-success"><i class="fa fa-sign-in"></i> Login</button>
	        </form>
	    </div>
	</div>
</body>

</html>