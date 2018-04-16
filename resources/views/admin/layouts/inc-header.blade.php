<b><a class="navbar-brand" href="{{ url('/dashboard') }}">WMSOnline System</a></b>
    <button class="navbar-toggler navbar-toggler-right" type="button" data-toggle="collapse" data-target="#navbarResponsive" aria-controls="navbarResponsive" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarResponsive">
      <ul class="navbar-nav navbar-sidenav" id="exampleAccordion">
        <li class="nav-item" data-toggle="tooltip" data-placement="right" title="Dashboard">
          <a class="nav-link" href="{{ url('dashboard') }}">
            <i class="fa fa-fw fa-dashboard"></i>
            <span class="nav-link-text">Dashboard</span>
          </a>
        </li>
        <li class="nav-item" data-toggle="tooltip" data-placement="right" title="Charts">
          <a class="nav-link" href="{{ url('account') }}">
            <i class="fa fa-user fa-fw"></i>
            <span class="nav-link-text">ข้อมูลพนักงาน</span>
          </a>
        </li>
        <li class="nav-item" data-toggle="tooltip" data-placement="right" title="Tables">
          <a class="nav-link" href="{{ url('customer') }}">
            <i class="fa fa-user fa-fw"></i>
            <span class="nav-link-text">ข้อมูลลูกค้า</span>
          </a>
        </li>
        <li class="nav-item" data-toggle="tooltip" data-placement="right" title="Tables">
          <a class="nav-link" href="{{ url('warehouse') }}">
            <i class="fa fa-building-o fa-fw"></i>
            <span class="nav-link-text">ข้อมูลคลังสินค้า</span>
          </a>
        </li>
        <li class="nav-item" data-toggle="tooltip" data-placement="right" title="Tables">
          <a class="nav-link" href="{{ url('goods') }}">
            <i class="fa fa-cube fa-fw"></i>
            <span class="nav-link-text">ข้อมูลสินค้า</span>
          </a>
        </li>
        <li class="nav-item" data-toggle="tooltip" data-placement="right" title="Tables">
          <a class="nav-link" href="{{ url('order') }}">
            <i class="fa fa-table fa-fw"></i>
            <span class="nav-link-text">ข้อมูลรายการขาย</span>
          </a>
        </li>

        <li class="nav-item" data-toggle="tooltip" data-placement="right" title="Example Pages">
          <a class="nav-link nav-link-collapse collapsed" data-toggle="collapse" href="#collapseExamplePages" data-parent="#exampleAccordion">
            <i class="fa fa-fw fa-file"></i>
            <span class="nav-link-text">รายงาน</span>
          </a>
          <ul class="sidenav-second-level collapse" id="collapseExamplePages">
            <li>
              <a href="login.html">Login Page</a>
            </li>
            <li>
              <a href="register.html">Registration Page</a>
            </li>
            <li>
              <a href="forgot-password.html">Forgot Password Page</a>
            </li>
            <li>
              <a href="blank.html">Blank Page</a>
            </li>
          </ul>
        </li>
      </ul>

      <ul class="navbar-nav ml-auto">
        <li class="nav-item">
        	<a class="nav-link">
        		USERNAME : {{ Session::get('nameLogin') }}
        	</a>
        </li>
        <li class="nav-item" title="LOGOUT">
        	<a class="nav-link" data-toggle="modal" data-target="#exampleModal">
        		<i class="fa fa-sign-out fa-fw"></i>
        	</a>
        </li>
      </ul>
    </div>
    