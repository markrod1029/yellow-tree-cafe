<?php

// Fetch all products from the database
$sql = "SELECT *, category.name AS category_name, products.id AS prod_id FROM products
  LEFT JOIN category  ON products.category_id = category.id
";


$result = mysqli_query($conn, $sql);
$products = mysqli_fetch_all($result, MYSQLI_ASSOC);
mysqli_free_result($result);
?>

<!-- Content Wrapper -->
<div class="content-wxrapper">
  <!-- Content Header -->
  <!-- Begin Page Content -->
  <div class="container-fluid">

    <!-- Page Heading -->
    <h1 class="h3 mb-2 text-gray-800">Product Lists</h1>
    <!-- DataTales Example -->
    <div class="card shadow mb-4">
      <div class="card-header py-3">
        <h6 class="m-0 font-weight-bold text-primary">Products</h6>
      </div>
      <div class="card-body">
        <div class="table-responsive">

          <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
            <thead>
              <tr>
                <th>Product Name</th>
                <th>Brand</th>
                <th>Category</th>
                <th>Quantity</th>
                <th>Selling Price</th>
                <th>Action</th>
              </tr>
            </thead>
            <tbody>
              <?php foreach ($products as $product) : ?>
                <tr>
                  <td><?= htmlspecialchars($product['product_name']) ?></td>
                  <td><?= htmlspecialchars($product['brand_name']) ?></td>
                  <td><?= htmlspecialchars($product['category_name']) ?></td>
                  <td><?= htmlspecialchars($product['quantity']) ?></td>
                  <td><?= number_format($product['sell_price'], 2) ?></td>
                  <td>
                    <div class="btn-group">
                      <a href="index.php?page=product_form&edit_id=<?= htmlspecialchars($product['prod_id']) ?>" class="btn btn-secondary btn-sm rounded-0">
                        <i class="fas fa-edit"></i>
                      </a>
                      <form action="../../app/action/product_process.php" method="POST" style="display:inline;">
                        <input type="hidden" name="action" value="delete">
                        <input type="hidden" name="id" value="<?= htmlspecialchars($product['prod_id']) ?>">
                        <button type="submit" class="btn btn-danger btn-sm rounded-0 ml-2" onclick="return confirm('Are you sure you want to delete this Product?')">
                          <i class="fas fa-trash-alt"></i>
                        </button>
                      </form>
                    </div>
                  </td>
                </tr>
              <?php endforeach; ?>

            </tbody>
          </table>
        </div>
      </div>
    </div>

  </div>

  <!-- /.card -->
</div>
</div>

<?php mysqli_close($conn); ?>