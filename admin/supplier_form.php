<?php

$edit_mode = false;
$supplier = [
  'id' => '',
  'fname' => '',
  'mname' => '',
  'lname' => '',
  'company' => '',
  'contact' => '',
  'email' => '',
  'address' => ''
];

// Kung may `edit_id`, kukunin natin ang data ng supplier
if (isset($_GET['edit_id'])) {
  $edit_id = intval($_GET['edit_id']);
  $sql = "SELECT * FROM suppliers WHERE id = ?";
  $stmt = mysqli_prepare($conn, $sql);
  mysqli_stmt_bind_param($stmt, "i", $edit_id);
  mysqli_stmt_execute($stmt);
  $result = mysqli_stmt_get_result($stmt);

  if ($row = mysqli_fetch_assoc($result)) {
    $supplier = $row;
    $edit_mode = true;
  } else {
    $_SESSION['message'] = "Supplier not found!";
    $_SESSION['message_type'] = "error";
    header("Location: index.php?page=suppliers");
    exit();
  }
  mysqli_stmt_close($stmt);
}
?>

<!-- Content Wrapper -->
<div class="content-wrapper">
  <!-- Begin Page Content -->
  <div class="container-fluid">
    <!-- Page Heading -->
    <h1 class="h3 mb-2 text-gray-800 "><?= $edit_mode ? "Edit Supplier" : "Add Supplier" ?></h1>

    <div class="card shadow mb-4">
      <div class="card-header py-3">
        <h6 class="m-0 font-weight-bold text-primary"><?= $edit_mode ? "Update this Supplier" : "Register New Supplier" ?></h6>
      </div>
      <div class="card-body">
        <!-- Success & Error Messages -->
        <?php if (isset($_GET['success'])): ?>
          <div class="alert alert-success">Supplier saved successfully!</div>
        <?php elseif (isset($_GET['error'])): ?>
          <div class="alert alert-danger">Error processing request!</div>
        <?php endif; ?>

        <form action="../app/action/supplier_process.php" method="POST">
          <input type="hidden" name="id" value="<?= $edit_mode ? $supplier['id'] : '' ?>">

          <div class="row">
            <div class="col-md-6">
              <div class="form-group">
                <label for="fname">First Name *:</label>
                <input type="text" class="form-control" id="fname" name="fname"
                  value="<?= htmlspecialchars($supplier['fname']) ?>" required>
              </div>
            </div>

            <div class="col-md-6">
              <div class="form-group">
                <label for="mname">Middle Name:</label>
                <input type="text" class="form-control" id="mname" name="mname" placeholder="Optional"
                  value="<?= htmlspecialchars($supplier['mname']) ?>">
              </div>
            </div>
          </div>

          <div class="row">
            <div class="col-md-6">
              <div class="form-group">
                <label for="lname">Last Name *:</label>
                <input type="text" class="form-control" id="lname" name="lname"
                  value="<?= htmlspecialchars($supplier['lname']) ?>" required>
              </div>
            </div>

            <div class="col-md-6">
              <div class="form-group">
                <label for="company">Company *:</label>
                <input type="text" class="form-control" id="company" name="company" 
                  value="<?= htmlspecialchars($supplier['company']) ?>" required>
              </div>
            </div>
          </div>

          <div class="row">
            <div class="col-md-6">
              <div class="form-group">
                <label for="contact">Contact Number *:</label>
                <input type="text" class="form-control" id="contact" name="contact"
                  value="<?= htmlspecialchars($supplier['contact']) ?>" required>
              </div>
            </div>

            <div class="col-md-6">
              <div class="form-group">
                <label for="email">Email:</label>
                <input type="email" class="form-control" id="email" name="email"
                  value="<?= htmlspecialchars($supplier['email']) ?>">
              </div>
            </div>
          </div>

          <div class="form-group">
            <label for="address">Address:</label>
            <textarea rows="3" class="form-control" id="address" name="address"><?= htmlspecialchars($supplier['address']) ?></textarea>
          </div>

          <div class="form-group text-center">
            <button type="submit" class="btn btn-success btn-lg px-4" name="submit">
              <?= $edit_mode ? "Update Supplier" : "Add Supplier" ?>
            </button>
          </div>

        </form>
      </div>
    </div>
  </div>
</div>

<?php mysqli_close($conn); ?>
