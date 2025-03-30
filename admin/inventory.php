<?php

// Fetch all products from the database
$sql = "SELECT *, inventory.id AS inven_id FROM inventory
  LEFT JOIN suppliers  ON inventory.supplier_id = suppliers.id
";


$result = mysqli_query($conn, $sql);
$items = mysqli_fetch_all($result, MYSQLI_ASSOC);
mysqli_free_result($result);
?>

<!-- Content Wrapper -->
<div class="content-wxrapper">
  <!-- Content Header -->
  <!-- Begin Page Content -->
  <div class="container-fluid">

    <!-- Page Heading -->
    <h1 class="h3 mb-2 text-gray-800">Inventory Lists</h1>
    <!-- DataTales Example -->
    <div class="card shadow mb-4">
      <div class="card-header py-3">
        <h6 class="m-0 font-weight-bold text-primary">Inventory</h6>
      </div>
      <div class="card-body">
        <div class="table-responsive">

          <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
            <thead>
              <tr>
                <th>Supplier Name</th>
                <th>Product Name</th>
                <th>quantity</th>
                <th>Buying Price</th>
                <th>Action</th>
              </tr>
            </thead>
            <tbody>
              <?php foreach ($items as $item) : ?>
                <tr>
                  <td><?= htmlspecialchars($item['fname']. ' '.$item['mname']. ' '.$item['lname']) ?></td>
                  <td><?= htmlspecialchars($item['product_name']) ?></td>
                  <td><?= htmlspecialchars($item['quantity']) ?></td>
                  <td><?= number_format($item['buy_price'], 2) ?></td>
                  <td>
                    <div class="btn-group">
                      <a href="index.php?page=inventory_form&edit_id=<?= htmlspecialchars($item['inven_id']) ?>" class="btn btn-secondary btn-sm rounded-0">
                        <i class="fas fa-edit"></i>
                      </a>
                      <form action="../app/action/inventory_process.php" method="POST" style="display:inline;">
                        <input type="hidden" name="action" value="delete">
                        <input type="hidden" name="id" value="<?= htmlspecialchars($item['inven_id']) ?>">
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