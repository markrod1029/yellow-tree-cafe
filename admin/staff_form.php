<?php
$staff_id = isset($_GET['id']) ? intval($_GET['id']) : null;
$fname = $mname = $lname = $email = $password = $contact = $address = "";

// If editing, fetch staff data
if ($staff_id) {
    $query = "SELECT * FROM users WHERE id = $staff_id AND role = 'staff'";
    $result = mysqli_query($conn, $query);

    if ($result && mysqli_num_rows($result) > 0) {
        $staff = mysqli_fetch_assoc($result);
        $fname = $staff['fname'];
        $mname = $staff['mname'];
        $lname = $staff['lname'];
        $email = $staff['email'];
        $contact = $staff['contact'];
        $address = $staff['address'];
    }
}
?>

<!-- Content Wrapper -->
<div class="content-wrapper">
    <!-- Begin Page Content -->
    <div class="container-fluid">
        <!-- Page Heading -->
        <h1 class="h3 mb-2 text-gray-800 "><?= $staff_id ? "Edit User" : "Add User" ?></h1>

        <div class="card shadow mb-4">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-primary"><?= $staff_id ? "Update this User" : "Register New User" ?></h6>
            </div>
            <div class="card-body">
                <!-- Success & Error Messages -->
                <?php if (isset($_GET['success'])): ?>
                    <div class="alert alert-success">Staff saved successfully!</div>
                <?php elseif (isset($_GET['error'])): ?>
                    <div class="alert alert-danger">Error processing request!</div>
                <?php endif; ?>

                <form action="../app/action/staff_process.php" method="POST">
                    <input type="hidden" name="id" value="<?= $staff_id ?>">

                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="fname">First Name *:</label>
                                <input type="text" class="form-control" id="fname" name="fname"
                                    value="<?= htmlspecialchars($fname) ?>" required>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="mname">Middle Name:</label>
                                <input type="text" class="form-control" id="mname" name="mname" placeholder="Optional"
                                    value="<?= htmlspecialchars($mname) ?>">
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="lname">Last Name *:</label>
                                <input type="text" class="form-control" id="lname" name="lname"
                                    value="<?= htmlspecialchars($lname) ?>" required>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="email">Email:</label>
                                <input type="email" class="form-control" id="email" name="email"
                                    value="<?= htmlspecialchars($email) ?>">
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="password">Password :</label>
                                <input type="password" class="form-control" id="password" name="password" <?= $staff_id ? "" : "required" ?>>
                                <small class="text-muted"><?= $staff_id ? "Leave blank to keep current password" : "" ?></small>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="contact">Contact Number *:</label>
                                <input type="text" class="form-control" id="contact" name="contact"
                                    value="<?= htmlspecialchars($contact) ?>" required>
                            </div>
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="address">Address *:</label>
                        <textarea rows="3" class="form-control" id="address" name="address"
                            required><?= htmlspecialchars($address) ?></textarea>
                    </div>

                    <div class="form-group text-center">
                        <button type="submit" class="btn btn-success btn-lg px-4" name="submit">
                            <?= $staff_id ? "Update User" : "Add User" ?>
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<?php mysqli_close($conn); ?>
