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

    <!-- Users -->
    <li class="nav-item <?= in_array($page, ['staff', 'staff_form']) ? 'active' : '' ?>">
        <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseOne"
            aria-expanded="true" aria-controls="collapseOne">
            <i class="fas fa-user"></i>
            <span>Users</span>
        </a>
        <div id="collapseOne" class="collapse <?= in_array($page, ['staff', 'staff_form']) ? 'show' : '' ?>" data-parent="#accordionSidebar">
            <div class="bg-warning py-2 collapse-inner rounded">
                <h6 class="collapse-header text-white">Users</h6>
                <a class="collapse-item <?= $page == 'staff' ? 'active' : '' ?>" href="index.php?page=staff">User Lists</a>
                <a class="collapse-item <?= $page == 'staff_form' ? 'active' : '' ?>" href="index.php?page=staff_form">Add User</a>
            </div>
        </div>
    </li>

    <!-- Suppliers -->
    <li class="nav-item <?= in_array($page, ['suppliers', 'supplier_form']) ? 'active' : '' ?>">
        <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseTwo"
            aria-expanded="true" aria-controls="collapseTwo">
            <i class="fas fa-truck"></i>
            <span>Suppliers</span>
        </a>
        <div id="collapseTwo" class="collapse <?= in_array($page, ['suppliers', 'supplier_form']) ? 'show' : '' ?>" data-parent="#accordionSidebar">
            <div class="bg-warning py-2 collapse-inner rounded">
                <h6 class="collapse-header text-white">Suppliers</h6>
                <a class="collapse-item <?= $page == 'suppliers' ? 'active' : '' ?>" href="index.php?page=suppliers">Supplier Lists</a>
                <a class="collapse-item <?= $page == 'supplier_form' ? 'active' : '' ?>" href="index.php?page=supplier_form">Add Supplier</a>
            </div>
        </div>
    </li>

    <!-- Categories -->
    <li class="nav-item <?= in_array($page, ['category', 'category_form']) ? 'active' : '' ?>">
        <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseTree"
            aria-expanded="true" aria-controls="collapseTree">
            <i class="fas fa-tags"></i>
            <span>Categories</span>
        </a>
        <div id="collapseTree" class="collapse <?= in_array($page, ['category', 'category_form']) ? 'show' : '' ?>" data-parent="#accordionSidebar">
            <div class="bg-warning py-2 collapse-inner rounded">
                <h6 class="collapse-header text-white">Categories</h6>
                <a class="collapse-item <?= $page == 'category' ? 'active' : '' ?>" href="index.php?page=category">Category Lists</a>
                <a class="collapse-item <?= $page == 'category_form' ? 'active' : '' ?>" href="index.php?page=category_form">Add Category</a>
            </div>
        </div>
    </li>

    <!-- Products -->
    <li class="nav-item <?= in_array($page, ['products', 'product_form']) ? 'active' : '' ?>">
        <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseFour"
            aria-expanded="true" aria-controls="collapseFour">
            <i class="fas fa-box"></i>
            <span>Products</span>
        </a>
        <div id="collapseFour" class="collapse <?= in_array($page, ['products', 'product_form']) ? 'show' : '' ?>" data-parent="#accordionSidebar">
            <div class="bg-warning py-2 collapse-inner rounded">
                <h6 class="collapse-header text-white">Products</h6>
                <a class="collapse-item <?= $page == 'products' ? 'active' : '' ?>" href="index.php?page=products">Product Lists</a>
                <a class="collapse-item <?= $page == 'product_form' ? 'active' : '' ?>" href="index.php?page=product_form">Add Product</a>
            </div>
        </div>
    </li>

    <!-- Inventory -->
    <li class="nav-item <?= in_array($page, ['inventory', 'inventory_form']) ? 'active' : '' ?>">
        <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseFive"
            aria-expanded="true" aria-controls="collapseFive">
            <i class="fas fa-warehouse"></i>
            <span>Inventory</span>
        </a>
        <div id="collapseFive" class="collapse <?= in_array($page, ['inventory', 'inventory_form']) ? 'show' : '' ?>" data-parent="#accordionSidebar">
            <div class="bg-warning py-2 collapse-inner rounded">
                <h6 class="collapse-header text-white">Inventory</h6>
                <a class="collapse-item <?= $page == 'inventory' ? 'active' : '' ?>" href="index.php?page=inventory">Inventory Lists</a>
                <a class="collapse-item <?= $page == 'inventory_form' ? 'active' : '' ?>" href="index.php?page=inventory_form">Add Inventory</a>
            </div>
        </div>
    </li>

    <!-- Quantity -->
    <li class="nav-item <?= in_array($page, ['quantity', 'quantity_form']) ? 'active' : '' ?>">
        <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapsesix"
            aria-expanded="true" aria-controls="collapsesix">
            <i class="fas fa-sort-amount-up"></i>
            <span>Quantity</span>
        </a>
        <div id="collapsesix" class="collapse <?= in_array($page, ['quantity', 'quantity_form']) ? 'show' : '' ?>" data-parent="#accordionSidebar">
            <div class="bg-warning py-2 collapse-inner rounded">
                <h6 class="collapse-header text-white">Quantity</h6>
                <a class="collapse-item <?= $page == 'quantity' ? 'active' : '' ?>" href="index.php?page=quantity">Quantity Lists</a>
                <a class="collapse-item <?= $page == 'quantity_form' ? 'active' : '' ?>" href="index.php?page=quantity_form">Add Quantity</a>
            </div>
        </div>
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
