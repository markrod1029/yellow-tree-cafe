<?php

// Fetch all categories from the database
$sql = "SELECT * FROM category ";
$result = mysqli_query($conn, $sql);
$categories = mysqli_fetch_all($result, MYSQLI_ASSOC);
mysqli_free_result($result);
?>


<!-- Content Wrapper -->
<div class="content-wxrapper">
    <!-- Content Header -->
    <!-- Begin Page Content -->
    <div class="container-fluid">

        <!-- Page Heading -->
        <h1 class="h3 mb-2 text-gray-800">Category Lists</h1>
        <!-- DataTales Example -->
        <div class="card shadow mb-4">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-primary">Categories</h6>
            </div>
            <div class="card-body">
                <div class="table-responsive">

                    <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                        <thead>
                            <tr>
                                <th>Category Name</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                                <?php foreach ($categories as $category) : ?>
                                    <tr>
                                        <td><?= htmlspecialchars($category['name']) ?></td>
                                        <td>
                                            <div class="btn-group">
                                                <a href="index.php?page=category_form&&edit_id=<?= $category['id'] ?>" class="btn btn-secondary btn-sm rounded-0"><i class="fas fa-edit"></i></a>
                                                <form action="../app/action/category_process.php" method="POST" style="display:inline;">
                                                    <input type="hidden" name="action" value="delete">
                                                    <input type="hidden" name="id" value="<?= htmlspecialchars($category['id']) ?>">
                                                    <button type="submit" class="btn btn-danger btn-sm rounded-0 ml-2" onclick="return confirm('Are you sure you want to delete this Category?')">
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