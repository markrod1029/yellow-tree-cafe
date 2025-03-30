<?php

$category_id = isset($_GET['edit_id']) ? intval($_GET['edit_id']) : null;
$name = "";

if ($category_id) {
  $query = "SELECT * FROM category WHERE id = ?";
  $stmt = mysqli_prepare($conn, $query);
  mysqli_stmt_bind_param($stmt, "i", $category_id);
  mysqli_stmt_execute($stmt);
  $result = mysqli_stmt_get_result($stmt);

  if ($row = mysqli_fetch_assoc($result)) {
    $name = $row['name'];
  }
}

mysqli_close($conn);
?>

<!-- Content Wrapper -->
<div class="content-wrapper">
  <!-- Begin Page Content -->
  <div class="container-fluid">
    <!-- Page Heading -->
    <h1 class="h3 mb-2 text-gray-800 "><?= $category_id ? "Edit Category" : "Add Category" ?></h1>

    <div class="card shadow mb-4">
      <div class="card-header py-3">
        <h6 class="m-0 font-weight-bold text-primary"><?= $category_id ? "Update this Category" : "Register New Category" ?></h6>
      </div>
      <div class="card-body">
        <!-- Success & Error Messages -->
        <?php if (isset($_GET['success'])): ?>
          <div class="alert alert-success">Category saved successfully!</div>
        <?php elseif (isset($_GET['error'])): ?>
          <div class="alert alert-danger">Error processing request!</div>
        <?php endif; ?>

        <form action="../app/action/category_process.php" method="POST">
          <input type="hidden" name="id" value="<?= $category_id ?>"> <!-- Hidden ID -->
          <div class="form-group">
            <label for="name">Category Name</label>
            <input type="text" class="form-control" id="name" name="name" value="<?= htmlspecialchars($name) ?>" required>
          </div>
          <div class="form-group text-center">
            <button type="submit" class="btn btn-success btn-lg px-4" name="submit">
              <?= $category_id ? "Update Category" : "Add Category" ?>
            </button>
          </div>

         
        </form>
      </div>
    </div>
  </div>
</div>
</div>