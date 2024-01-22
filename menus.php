  <!-- ======= Header ======= -->
  <header id="header" class="header fixed-top d-flex align-items-center">

    <div class="d-flex align-items-center justify-content-between">
      <a href="dashboard.php" class="logo d-flex align-items-center">
        <img src="assets/img/logoo.png" alt="">
        <span class="d-none d-lg-block">BlueHouse Fitness</span>
      </a>
      <i class="bi bi-list toggle-sidebar-btn"></i>
    </div><!-- End Logo -->

    <div class="search-bar">
      <form class="search-form d-flex align-items-center" method="POST" action="#">
        <input type="text" name="query" placeholder="Search" title="Enter search keyword">
        <button type="submit" title="Search"><i class="bi bi-search"></i></button>
      </form>
    </div><!-- End Search Bar -->

    <nav class="header-nav ms-auto">
      <ul class="d-flex align-items-center">

        <li class="nav-item d-block d-lg-none">
          <a class="nav-link nav-icon search-bar-toggle " href="#">
            <i class="bi bi-search"></i>
          </a>
        </li><!-- End Search Icon-->

        <li class="nav-item dropdown pe-3">

          <a class="nav-link nav-profile d-flex align-items-center pe-0" href="#" data-bs-toggle="dropdown">
            <img src="assets/img/logoo.png" alt="Profile" class="rounded-circle">
            <span class="d-none d-md-block dropdown-toggle ps-2">BlueHouse . F</span>
          </a><!-- End Profile Iamge Icon -->

          <ul class="dropdown-menu dropdown-menu-end dropdown-menu-arrow profile">

            <li>
              <hr class="dropdown-divider">
            </li>

            <li>
              <a class="dropdown-item d-flex align-items-center" id="logoutButton" href="logout.php">
                <i class="bi bi-box-arrow-right"></i>
                <span>Sign Out</span>
              </a>
            </li>

          </ul><!-- End Profile Dropdown Items -->
        </li><!-- End Profile Nav -->

      </ul>
    </nav><!-- End Icons Navigation -->

  </header><!-- End Header -->

  <!-- ======= Sidebar ======= -->
    <aside id="sidebar" class="sidebar">

    <ul class="sidebar-nav" id="sidebar-nav">

      <li class="nav-item">
        <a class="nav-link " href="dashboard.php">
          <i class="bi bi-grid"></i>
          <span>Dashboard</span>
        </a>
      </li><!-- End Dashboard Nav -->

      <li class="nav-item">
        <a class="nav-link collapsed" data-bs-target="#setting-nav" data-bs-toggle="collapse" href="#">
          <i class="bi bi-gear"></i><span>Settings</span><i class="bi bi-chevron-down ms-auto"></i>
        </a>
        <ul id="setting-nav" class="nav-content collapse " data-bs-parent="#sidebar-nav">
          <li>
            <a href="entrance.php">
              <i style="font-size:medium" class="bi bi-cash-stack"></i><span>Entrance Fees</span>
            </a>
          </li>
        </ul>
      </li>


      <li class="nav-item">
        <a class="nav-link collapsed" data-bs-target="#record-nav" data-bs-toggle="collapse" href="#">
          <i class="bi bi-archive"></i><span>Record Center</span><i class="bi bi-chevron-down ms-auto"></i>
        </a>
        <ul id="record-nav" class="nav-content collapse " data-bs-parent="#sidebar-nav">
          <li>
            <a href="add-customer.php">
              <i style="font-size:medium" class="bi bi-person-plus"></i><span>Record new Customer</span>
            </a>
          </li>
          <li>
            <a href="add-subscription.php">
              <i style="font-size:medium" class="bi bi-file-earmark-check"></i><span>Customer Subcriptions</span>
            </a>
          </li>

        </ul>
      </li>


      <li class="nav-item">
        <a class="nav-link collapsed" data-bs-target="#operation-nav" data-bs-toggle="collapse" href="#">
          <i class="bi bi-gear-wide-connected"></i><span>Operations Center</span><i class="bi bi-chevron-down ms-auto"></i>
        </a>
        <ul id="operation-nav" class="nav-content collapse " data-bs-parent="#sidebar-nav">
          <li>
            <a href="entrance-record.php">
              <i style="font-size:medium" class="bi bi-door-open"></i><span>Entrance</span>
            </a>
          </li>
          <li>
            <a href="expenses.php">
              <i style="font-size:medium" class="bi bi-cash"></i><span>Expenses</span>
            </a>
          </li>

        </ul>
      </li>



      <li class="nav-item">
        <a class="nav-link collapsed" data-bs-target="#reports-nav" data-bs-toggle="collapse" href="#">
          <i class="bi bi-file-earmark-text"></i><span>Reports Center</span><i class="bi bi-chevron-down ms-auto"></i>
        </a>
        <ul id="reports-nav" class="nav-content collapse " data-bs-parent="#sidebar-nav">
          <li>
            <a href="report-entrance.php">
              <i style="font-size:medium" class="bi bi-door-closed"></i><span>Entrance report</span>
            </a>
          </li>
          <li>
            <a href="report-customers.php">
              <i style="font-size:medium" class="bi bi-person-lines-fill"></i><span>Customers Reports</span>
            </a>
          </li>
          <li>
            <a href="expense-report.php">
              <i style="font-size:medium" class="bi bi-alarm"></i><span>Expense Report</span>
            </a>
          </li>
          <li>
            <a href="report-subscription.php">
              <i style="font-size:medium" class="bi bi-archive"></i><span>All Subscriptions</span>
            </a>
          </li>
          <li>
            <a href="report-active-subscription.php">
              <i style="font-size:medium" class="bi bi-check-circle"></i><span>Active subscriptions</span>
            </a>
          </li>
          <li>
            <a href="report-expired-subscription.php">
              <i style="font-size:medium" class="bi bi-alarm"></i><span>Expired subscriptions</span>
            </a>
          </li>

        </ul>
      </li>

      <li class="nav-item">
        <a class="nav-link collapsed" data-bs-target="#reports-sales-nav" data-bs-toggle="collapse" href="#">
          <i class="bi bi-graph-up"></i><span>Sales Reports</span><i class="bi bi-chevron-down ms-auto"></i>
        </a>
        <ul id="reports-sales-nav" class="nav-content collapse" data-bs-parent="#sidebar-nav">
          <li>
            <a href="report-sales-sub.php">
              <i style="font-size: medium" class="bi bi-check-circle"></i><span>Subscribed Sales</span>
            </a>
          </li>
          <li>
            <a href="report-sales-non.php">
              <i style="font-size: medium" class="bi bi-x-circle"></i><span>Non-Subscribed Sales</span>
            </a>
          </li>
          <li>
            <a href="report-sales-all.php">
              <i style="font-size: medium" class="bi bi-list"></i><span>All Sales</span>
            </a>
          </li>
        </ul>
      </li>





    </ul>

  </aside><!-- End Sidebar-->