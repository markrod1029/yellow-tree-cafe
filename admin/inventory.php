<?php

// Fetch all products from the database
$sql = "SELECT *, inventory.id AS inven_id FROM inventory
  LEFT JOIN suppliers  ON inventory.supplier_id = suppliers.id
";


$result = mysqli_query($conn, $sql);
$items = mysqli_fetch_all($result, MYSQLI_ASSOC);
mysqli_free_result($result);

function getExpiringInventoryItems($conn)
{
  $query = "SELECT product_name, expDate FROM inventory 
              WHERE expDate BETWEEN CURDATE() AND DATE_ADD(CURDATE(), INTERVAL 5 DAY)
              ORDER BY expDate ASC";
  $result = mysqli_query($conn, $query);
  $items = [];
  while ($row = mysqli_fetch_assoc($result)) {
    $items[] = $row;
  }
  return $items;
}

$expiring_items = getExpiringInventoryItems($conn);



function getOverstockedItems($conn, $threshold = 100) {
    $query = "SELECT product_name, quantity FROM inventory WHERE quantity > $threshold";
    $result = mysqli_query($conn, $query);
    $items = [];
    while ($row = mysqli_fetch_assoc($result)) {
        $items[] = $row;
    }
    return $items;
}

$overstocked_items = getOverstockedItems($conn); // Default threshold is 100


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
          <?php if (count($expiring_items) > 0): ?>
            <div class="col-xl-12 col-md-12 mb-4">
              <div class="card border-left-danger shadow h-100 py-2">
                <div class="card-body">
                  <div class="row no-gutters align-items-start">
                    <div class="col mr-2">
                      <div class="text-xs font-weight-bold text-danger text-uppercase mb-2">
                        Inventory Items Expiring Soon (within 5 days)
                      </div>
                      <ul class="mb-0 text-gray-800">
                        <?php foreach ($expiring_items as $item): ?>
                          <li>
                            <?= htmlspecialchars($item['product_name']) ?>
                            <small class="text-muted">(expires on <?= date('F j, Y', strtotime($item['expDate'])) ?>)</small>
                          </li>
                        <?php endforeach; ?>
                      </ul>
                    </div>
                    <div class="col-auto">
                      <a href="index.php?page=inventory">
                        <i class="fas fa-exclamation-triangle fa-2x text-gray-300"></i>
                      </a>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          <?php endif; ?>


          
    <?php if (count($overstocked_items) > 0): ?>
    <div class="col-xl-12 col-md-12 mb-4">
        <div class="card border-left-warning shadow h-100 py-2">
            <div class="card-body">
                <div class="row no-gutters align-items-start">
                    <div class="col mr-2">
                        <div class="text-xs font-weight-bold text-warning text-uppercase mb-2">
                            Overstocked Inventory Items
                        </div>
                        <ul class="mb-0 text-gray-800">
                            <?php foreach ($overstocked_items as $item): ?>
                                <li>
                                    <?= htmlspecialchars($item['product_name']) ?> 
                                    <small class="text-muted">(<?= $item['quantity'] ?> in stock)</small>
                                </li>
                            <?php endforeach; ?>
                        </ul>
                    </div>
                    <div class="col-auto">
                        <a href="index.php?page=inventory">
                            <i class="fas fa-boxes fa-2x text-gray-300"></i>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
<?php endif; ?>

          <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
            <thead>
              <tr>
                <th>Supplier Name</th>
                <th>Product Name</th>
                <th>quantity</th>
                <th>Buying Price</th>
                <th>Expiration Date</th>
                <th>Action</th>
              </tr>
            </thead>
            <tbody>
              <?php foreach ($items as $item) : ?>
                <tr>
                  <td><?= htmlspecialchars($item['fname'] . ' ' . $item['mname'] . ' ' . $item['lname']) ?></td>
                  <td><?= htmlspecialchars($item['product_name']) ?></td>
                  <td><?= htmlspecialchars($item['quantity']) ?></td>
                  <td><?= number_format($item['buy_price'], 2) ?></td>
                  <td><?php echo date("F d, Y", strtotime($item['expDate'])); ?></td>

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