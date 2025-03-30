<?php

$sql = "SELECT *, s.id AS sup_id FROM suppliers s";
$result = mysqli_query($conn, $sql);
$suppliers = mysqli_fetch_all($result, MYSQLI_ASSOC);

mysqli_free_result($result);
?>

<!-- Content Wrapper -->
<div class="content-wxrapper">
  <!-- Content Header -->
  <!-- Begin Page Content -->
  <div class="container-fluid">

    <!-- Page Heading -->
    <h1 class="h3 mb-2 text-gray-800">Supplier Lists</h1>
    <!-- DataTales Example -->
    <div class="card shadow mb-4">
      <div class="card-header py-3">
        <h6 class="m-0 font-weight-bold text-primary">Supplier</h6>
      </div>
      <div class="card-body">
        <div class="table-responsive">

        <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
              <thead>
                <tr>
                  <th>Name</th>
                  <th>Company</th>
                  <th>Address</th>
                  <th>Contact</th>
                  <th>Action</th>
                </tr>
              </thead>
              <tbody>
                <?php foreach ($suppliers as $supplier) : ?>
                  <tr>
                    <td><?= htmlspecialchars($supplier['fname']. ' '.$supplier['mname']. ' '. $supplier['lname']) ?></td>
                    <td><?= htmlspecialchars($supplier['company']) ?></td>
                    <td><?= htmlspecialchars($supplier['address']) ?></td>
                    <td><?= htmlspecialchars($supplier['contact']) ?></td>
                    <td>
                      <div class="btn-group">
                        <a href="index.php?page=supplier_form&&edit_id=<?= $supplier['sup_id'] ?>" class="btn btn-secondary btn-sm rounded-0"><i class="fas fa-edit"></i></a>
                        <form action="../app/action/supplier_process.php" method="POST" style="display:inline;">
                          <input type="hidden" name="action" value="delete">
                          <input type="hidden" name="id" value="<?= htmlspecialchars($supplier['sup_id']) ?>">
                          <button type="submit" class="btn btn-danger btn-sm rounded-0 ml-2" onclick="return confirm('Are you sure you want to delete this Supplier?')">
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