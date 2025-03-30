<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action']) && $_POST['action'] === 'delete') {
  $id = mysqli_real_escape_string($conn, $_POST['id']);

  // Fetch product_id and new_quantity before deletion
  $query = "SELECT product_id, new_quantity FROM quantity WHERE id = '$id'";
  $result = mysqli_query($conn, $query);

  if ($row = mysqli_fetch_assoc($result)) {
    $product_id = $row['product_id'];
    $new_quantity = $row['new_quantity'];

    // Update total quantity in products table (subtract quantity)
    $update_query = "UPDATE products SET quantity = quantity - $new_quantity WHERE id = '$product_id'";
    mysqli_query($conn, $update_query);

    // Delete the purchase record from quantity
    $delete_query = "DELETE FROM quantity WHERE id = '$id'";
    if (mysqli_query($conn, $delete_query)) {
      echo "<script>
                    alert('Purchase deleted successfully. Product quantity updated.');
                    window.location.href = 'index.php?page=quantity';
                  </script>";
      exit;
    } else {
      echo "<script>
                    alert('Failed to delete purchase.');
                    window.location.href = 'index.php?page=quantity';
                  </script>";
      exit;
    }
  } else {
    echo "<script>
                alert('Purchase not found.');
                window.location.href = 'index.php?page=quantity';
              </script>";
    exit;
  }
}

// Fetch all factory products with related product and supplier details
$sql = "SELECT *, quantity.id AS quan_id FROM quantity
        LEFT JOIN products ON products.id = quantity.product_id";
$result = mysqli_query($conn, $sql);
$quantities = mysqli_fetch_all($result, MYSQLI_ASSOC);
mysqli_free_result($result);
?>

<!-- Content Wrapper -->
<div class="content-wrapper">
  <div class="container-fluid">
    <!-- Page Heading -->
    <h1 class="h3 mb-2 text-gray-800">Quantity Lists</h1>

    <div class="card shadow mb-4">
      <div class="card-header py-3">
        <h6 class="m-0 font-weight-bold text-primary">Quantity</h6>
      </div>
      <div class="card-body">
        <div class="table-responsive">
          <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
            <thead>
              <tr>
                <th>Product Name</th>
                <th>Brand Name</th>
                <th>Sell Price</th>
                <th>New Quantity</th>
                <th>Action</th>
              </tr>
            </thead>
            <tbody>
              <?php foreach ($quantities as $quantity) : ?>
                <tr>
                  <td><?= htmlspecialchars($quantity['product_name']) ?></td>
                  <td><?= htmlspecialchars($quantity['brand_name']) ?></td>
                  <td><?= number_format($quantity['sell_price'], 2) ?></td>
                  <td><?= intval($quantity['new_quantity']) ?></td>
                  <td>
                    <div class="btn-group">
                      <form action="index.php?page=quantity" method="POST" style="display:inline;">
                        <input type="hidden" name="action" value="delete">
                        <input type="hidden" name="id" value="<?= $quantity['quan_id'] ?>">
                        <button type="button" class="btn btn-danger btn-sm rounded-0"
                          onclick="confirmDelete(this)">
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
</div>
</div>

<script>
  function confirmDelete(button) {
    if (confirm("Are you sure you want to delete this purchase?")) {
      button.closest("form").submit();
    }
  }
</script>

<?php mysqli_close($conn); ?>