<?php

// Fetch suppliers
$supplier_query = "SELECT id, CONCAT(fname, ' ', mname, ' ', lname) AS fullname FROM suppliers";
$supplier_result = mysqli_query($conn, $supplier_query);

$suppliers = [];
if ($supplier_result) {
  while ($row = mysqli_fetch_assoc($supplier_result)) {
    $suppliers[] = $row;
  }
}

// Check if editing an inventory item
$inventory_id = isset($_GET['edit_id']) ? intval($_GET['edit_id']) : 0;
$inventory = null;

if ($inventory_id > 0) {
  $query = "SELECT * FROM inventory WHERE id = ?";
  $stmt = mysqli_prepare($conn, $query);
  mysqli_stmt_bind_param($stmt, "i", $inventory_id);
  mysqli_stmt_execute($stmt);
  $result = mysqli_stmt_get_result($stmt);

  if ($result && mysqli_num_rows($result) > 0) {
    $inventory = mysqli_fetch_assoc($result);
  }
  mysqli_stmt_close($stmt);
}
?>

<!-- Content Wrapper -->
<div class="content-wrapper">
  <div class="container-fluid">
    <h1 class="h3 mb-2 text-gray-800 "><?= $inventory_id ? "Edit Inventory" : "Add Inventory" ?></h1>

    <div class="card shadow mb-4">
      <div class="card-header py-3">
        <h6 class="m-0 font-weight-bold text-primary"><?= $inventory_id ? "Update this Inventory" : "Register New Inventory" ?></h6>
      </div>
      <div class="card-body">
        <!-- Success & Error Messages -->
        <?php if (isset($_GET['success'])): ?>
          <div class="alert alert-success">Inventory saved successfully!</div>
        <?php elseif (isset($_GET['error'])): ?>
          <div class="alert alert-danger">Error processing request!</div>
        <?php endif; ?>

        <form action="../app/action/inventory_process.php" method="POST">
          <input type="hidden" name="inventory_id" value="<?= $inventory ? $inventory['id'] : '' ?>">

          <div class="row">
            <div class="col-md-6">
              <div class="form-group">
                <label for="item_name">Item Name * :</label>
                <input type="text" class="form-control" id="item_name" name="item_name" 
                  value="<?= $inventory ? htmlspecialchars($inventory['product_name']) : '' ?>" 
                  placeholder="Enter item name" required>
              </div>
            </div>
            
            <div class="col-md-6">
              <div class="form-group">
                <label for="supplier_id">Supplier Name * :</label>
                <select name="supplier_id" id="supplier_id" class="form-control select2" required>
                  <option disabled <?= !$inventory ? 'selected' : '' ?>>Select a supplier</option>
                  <?php
                  foreach ($suppliers as $supplier) {
                    $selected = ($inventory && $inventory['supplier_id'] == $supplier['id']) ? 'selected' : '';
                    echo '<option value="' . htmlspecialchars($supplier['id']) . '" ' . $selected . '>' . htmlspecialchars($supplier['fullname']) . '</option>';
                  }
                  ?>
                </select>
              </div>
            </div>
          </div>

          <div class="row">
            <div class="col-md-6">
              <div class="form-group">
                <label for="quantity">Quantity * :</label>
                <input type="number" class="form-control" id="quantity" name="quantity" 
                  value="<?= $inventory ? htmlspecialchars($inventory['quantity']) : '' ?>" 
                  placeholder="Enter quantity" required>
              </div>
            </div>

            <div class="col-md-6">
              <div class="form-group">
                <label for="buy_price">Unit Price * :</label>
                <input type="text" class="form-control" id="buy_price" name="buy_price" 
                  value="<?= $inventory ? htmlspecialchars($inventory['buy_price']) : '' ?>" 
                  placeholder="Enter price per unit" required>
              </div>
            </div>
          </div>


           <div class="row">
            <div class="col-md-6">
              <div class="form-group">
                <label for="expDate">Expiration Date * :</label>
                <input type="date" class="form-control" id="expDate" name="expDate" 
                  value="<?= $inventory ? htmlspecialchars($inventory['expDate']) : '' ?>" 
                  placeholder="Enter Expiration Date" required>
              </div>
            </div>

           
          </div>
          

          <div class="form-group text-center">
            <button type="submit" class="btn btn-success btn-lg px-4" name="submit">
              <?= $inventory ? 'Update Inventory' : 'Add Inventory' ?>
            </button>
          </div>
        </form>
      </div>
    </div>
  </div>
</div>
</div>

<?php mysqli_close($conn); ?>
