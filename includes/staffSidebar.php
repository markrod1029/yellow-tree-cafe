<?php $page = isset($_GET['page']) ? $_GET['page'] : 'index'; ?>

<!-- Sidebar -->
<ul class="navbar-nav bg-gradient-warning sidebar sidebar-dark accordion" id="accordionSidebar">

    <!-- Sidebar - Brand -->
    <a class="sidebar-brand d-flex align-items-center justify-content-center" href="index.php">
        <div class="sidebar-brand-icon rotate-n-15"></div>
        <div class="sidebar-brand-text mx-3">Yellow Tree Cafe</div>
    </a>

    <!-- Divider -->
    <hr class="sidebar-divider my-0">

    <!-- Nav Item - Dashboard -->
    <li class="nav-item <?= $page == 'index' ? 'active' : '' ?>">
        <a class="nav-link" href="index.php">
            <i class="fas fa-fw fa-tachometer-alt"></i>
            <span>Dashboard</span>
        </a>
    </li>

    <!-- Heading -->
    <div class="sidebar-heading">Manage</div>

       <!-- Products -->
       <li class="nav-item <?= $page == 'products' ? 'active' : '' ?>">
        <a class="nav-link" href="index.php?page=products">
            <i class="fas fa-box"></i>
            <span>Products</span>
        </a>
    </li>


    
    <!-- Sales -->
    <li class="nav-item <?= $page == 'sell_form' ? 'active' : '' ?>">
        <a class="nav-link" href="index.php?page=sell_form">
            <i class="fas fa-shopping-cart"></i>
            <span>Sell Product</span>
        </a>
    </li>

    <li class="nav-item <?= $page == 'sales_report' ? 'active' : '' ?>">
        <a class="nav-link" href="index.php?page=sales_report">
            <i class="fas fa-chart-line"></i>
            <span>Sales Report</span>
        </a>
    </li>

</ul>
