<div class="page-main-header">
        <div class="main-header-right row">
          <div class="main-header-left d-lg-none">
            <div class="logo-wrapper"><a href="dashboard.php"><img src="assets/images/logo.jpg" alt=""></a></div>
          </div>
          <div class="mobile-sidebar d-block">
            <div class="media-body text-right switch-sm">
              <label class="switch"><a href="#"><i id="sidebar-toggle" data-feather="align-left"></i></a></label>
            </div>
          </div>
          <div class="nav-right col p-0">
            <ul class="nav-menus">
              <li>
                
              </li>
              <li class="onhover-dropdown">
                  <h6><b><?php echo $_SESSION['user']?></b></h6>
              </li>
              <li class="onhover-dropdown">
                <div class="media align-items-center"><a href="logout.php"><img class="align-self-center pull-right rounded-circle" src="assets/images/cerrar-sesion.png" width="25px" alt="header-user"></a>
                </div>
              </li>
            </ul>
            <div class="d-lg-none mobile-toggle pull-right"><i data-feather="more-horizontal"></i></div>
          </div>
        </div>
      </div>