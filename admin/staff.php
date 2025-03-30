<?php

// Fetch all staff members
$query = "SELECT * FROM users WHERE role = 'staff' ORDER BY id DESC";
$result = mysqli_query($conn, $query);

$staffMembers = [];
if ($result) {
  while ($row = mysqli_fetch_assoc($result)) {
    $staffMembers[] = $row;
  }
}
?>

<!-- Content Wrapper -->
<div class="content-wxrapper">
  <!-- Content Header -->
  <!-- Begin Page Content -->
  <div class="container-fluid">

    <!-- Page Heading -->
    <h1 class="h3 mb-2 text-gray-800">User List</h1>
    <!-- DataTales Example -->
    <div class="card shadow mb-4">
      <div class="card-header py-3">
        <h6 class="m-0 font-weight-bold text-primary">Users</h6>
      </div>
      <div class="card-body">
        <div class="table-responsive">

          <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
            <thead>
              <tr>
                <th>ID</th>
                <th>Name</th>
                <th>Contact</th>
                <th>Email</th>
                <th>Address</th>
                <th>Action</th>
              </tr>
            </thead>
            <tbody>
              <?php foreach ($staffMembers as $staff): ?>
                <tr>
                  <td><?= htmlspecialchars($staff['id']) ?></td>
                  <td>
                    <?= htmlspecialchars($staff['fname']) . " " .
                      htmlspecialchars($staff['mname']) . " " .
                      htmlspecialchars($staff['lname']) ?>
                  </td>
                  <td><?= htmlspecialchars($staff['contact']) ?></td>
                  <td><?= htmlspecialchars($staff['email']) ?></td>
                  <td><?= htmlspecialchars($staff['address']) ?></td>
                  <td>
                    <div class="btn-group">
                      <a href="index.php?page=staff_form&id=<?= htmlspecialchars($staff['id']) ?>"
                        class="btn btn-secondary btn-sm rounded-0">
                        <i class="fas fa-edit"></i>
                      </a>

                      <form action="../app/action/staff_process.php" method="POST" style="display:inline;">
                        <input type="hidden" name="action" value="delete">
                        <input type="hidden" name="id" value="<?= htmlspecialchars($staff['id']) ?>">
                        <button type="submit" class="btn btn-danger btn-sm rounded-0 ml-2"
                          onclick="return confirm('Are you sure you want to delete this staff member?')">
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