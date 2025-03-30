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
<div class="content-wrapper">
  <div class="content-header">
    <div class="container-fluid">
      <div class="row mb-2">
        <div class="col-sm-6">
          <h1 class="m-0 text-dark">Product List</h1>
        </div>
        <div class="col-sm-6">
          <ol class="breadcrumb float-sm-right">
            <li class="breadcrumb-item"><a href="index.php?page=dashboard">Home</a></li>
            <li class="breadcrumb-item active">Products</li>
          </ol>
        </div>
      </div>
    </div>
  </div>

  <section class="content">
    <div class="container-fluid">
      <div class="card">
        <div class="card-header">
          <h3 class="card-title"><b>Product List</b></h3>
         
        </div>
        
        <div class="card-body">
          <div class="table-responsive">
            <table id="data" class="table table-bordered text-center">
              <thead>
                <tr>
                  <th>Product Name</th>
                  <th>Brand</th>
                  <th>Category</th>
                  <th>Source</th>
                  <th>Quantity</th>
                  <th>Buying Price</th>
                  <th>Selling Price</th>
                  <th>Action</th>
                </tr>
              </thead>
              <tbody>
                <?php if (!empty($products)) : ?>
                  <?php foreach ($products as $product) : ?>
                    <tr>
                      <td><?= htmlspecialchars($product['product_name']) ?></td>
                      <td><?= htmlspecialchars($product['brand_name']) ?></td>
                      <td><?= htmlspecialchars($product['category_name']) ?></td>
                      <td><?= htmlspecialchars($product['product_source']) ?></td>
                      <td><?= htmlspecialchars($product['quantity']) ?></td>
                      <td><?= number_format($product['buy_price'], 2) ?></td>
                      <td><?= number_format($product['sell_price'], 2) ?></td>
                      <td>
                        <div class="btn-group">
                          <a href="index.php?page=product_form&edit_id=<?= htmlspecialchars($product['prod_id']) ?>" class="btn btn-secondary btn-sm rounded-0">
                            <i class="fas fa-edit"></i>
                          </a>
                          <form action="../../app/action/product_process.php" method="POST" style="display:inline;">
                            <input type="hidden" name="action" value="delete">
                            <input type="hidden" name="id" value="<?= htmlspecialchars($product['prod_id']) ?>">
                            <button type="submit" class="btn btn-danger btn-sm rounded-0" onclick="return confirm('Are you sure you want to delete this Product?')">
                              <i class="fas fa-trash-alt"></i>
                            </button>
                          </form>
                        </div>
                      </td>
                    </tr>
                  <?php endforeach; ?>
                <?php else : ?>
                  <tr>
                    <td colspan="9">No products found.</td>
                  </tr>
                <?php endif; ?>
              </tbody>
            </table>
          </div>
        </div>
      </div>
    </div>
  </section>
</div>

<!-- DataTables Initialization -->

