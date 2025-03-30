<?php

// Fetch categories
$category_query = "SELECT id, name FROM category";
$category_result = mysqli_query($conn, $category_query);

$categories = [];
if ($category_result) {
  while ($row = mysqli_fetch_assoc($category_result)) {
    $categories[] = $row;
  }
}

// Check if editing a product
$product_id = isset($_GET['edit_id']) ? intval($_GET['edit_id']) : 0;
$product = null;

if ($product_id > 0) {
  $query = "SELECT * FROM products WHERE id = ?";
  $stmt = mysqli_prepare($conn, $query);
  mysqli_stmt_bind_param($stmt, "i", $product_id);
  mysqli_stmt_execute($stmt);
  $result = mysqli_stmt_get_result($stmt);

  if ($result && mysqli_num_rows($result) > 0) {
    $product = mysqli_fetch_assoc($result);
  }
  mysqli_stmt_close($stmt);
}
?>

<!-- Content Wrapper -->
<div class="content-wrapper">
  <!-- Begin Page Content -->
  <div class="container-fluid">
    <!-- Page Heading -->
    <h1 class="h3 mb-2 text-gray-800 "><?= $product_id ? "Edit Product" : "Add Product" ?></h1>

    <div class="card shadow mb-4">
      <div class="card-header py-3">
        <h6 class="m-0 font-weight-bold text-primary"><?= $product_id ? "Update this Product" : "Register New Product" ?></h6>
      </div>
      <div class="card-body">
        <!-- Success & Error Messages -->
        <?php if (isset($_GET['success'])): ?>
          <div class="alert alert-success">Product saved successfully!</div>
        <?php elseif (isset($_GET['error'])): ?>
          <div class="alert alert-danger">Error processing request!</div>
        <?php endif; ?>

        <form action="../app/action/product_process.php" method="POST">
          <input type="hidden" name="product_id" value="<?= $product ? $product['id'] : '' ?>">

          <div class="row">
            <div class="col-md-6">
              <div class="form-group">
                <label for="product_name">Product Name * :</label>
                <input type="text" class="form-control" id="product_name" name="product_name" value="<?= $product ? htmlspecialchars($product['product_name']) : '' ?>" placeholder="Product name" required>
              </div>
            </div>
            <div class="col-md-6">
              <div class="form-group">
                <label for="brand">Brand Name * :</label>
                <input type="text" class="form-control" id="brand" name="brand" value="<?= $product ? htmlspecialchars($product['brand_name']) : '' ?>" placeholder="Brand name" required>
              </div>
            </div>
          </div>

          <div class="row">
            <div class="col-md-6">
              <div class="form-group">
                <label for="p_category">Product Category * :</label>
                <select name="p_category" id="p_category" class="form-control select2" required>
                  <option disabled <?= !$product ? 'selected' : '' ?>>Select a category</option>
                  <?php
                  foreach ($categories as $category) {
                    $selected = ($product && $product['category_id'] == $category['id']) ? 'selected' : '';
                    echo '<option value="' . htmlspecialchars($category['id']) . '" ' . $selected . '>' . htmlspecialchars($category['name']) . '</option>';
                  }
                  ?>
                </select>
              </div>
            </div>

            
          </div>

          

          <div class="form-group text-center">
            <button type="submit" class="btn btn-success btn-lg px-4" name="submit">

              <?= $product ? 'Update Product' : 'Add Product' ?></button>
          </div>
      </div>
      </form>
    </div>
  </div>
</div>
</div>

<?php mysqli_close($conn); ?>