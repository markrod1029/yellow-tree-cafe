<?php
require_once(__DIR__ . '/../app/session/adminSession.php');
require_once '../includes/header.php';
require_once(__DIR__ . '/../app/init.php'); // Database connection

?>

<body id="page-top">

  <!-- Page Wrapper -->
  <div id="wrapper">

    <?php require_once '../includes/sidebar.php'; ?>

    <!-- Content Wrapper -->
    <div id="content-wrapper" class="d-flex flex-column">

      <!-- Main Content -->
      <div id="content">

        <?php
        require_once '../includes/menubar.php';

        // Dynamic page loading
        $page = isset($_GET['page']) ? $_GET['page'] : 'dashboard';

        $pages = [
          'dashboard' => 'dashboard.php',
          'suppliers' => 'supplier.php',
          'supplier_form' => 'supplier_form.php',
          'category' => 'category.php',
          'category_form' => 'category_form.php',
          'products' => 'product.php',
          'product_form' => 'product_form.php',
          'inventory' => 'inventory.php',
          'inventory_form' => 'inventory_form.php',
          'staff' => 'staff.php',
          'staff_form' => 'staff_form.php',
          'sell_form' => 'sell_form.php',
          'quantity_form' => 'quantity_form.php',
          'quantity' => 'quantity.php',
          'sales_report' => 'sales_report.php',
          'info_sales' => 'info_sales.php',
          'profile' => 'profile.php',
        ];

        // Check if the requested page exists in the array
        if (array_key_exists($page, $pages)) {
          require_once $pages[$page];
        } else {
          require_once 'notfound.php';
        }
        ?>
        <?php require_once '../includes/footer.php'; ?>

      </div>
    </div>

</body>

</html>
<?php require_once '../includes/script.php'; ?>