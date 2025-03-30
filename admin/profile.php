<?php

$user_id = $user['id'];

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $fname = mysqli_real_escape_string($conn, trim($_POST['fname']));
    $mname = mysqli_real_escape_string($conn, trim($_POST['mname']));
    $lname = mysqli_real_escape_string($conn, trim($_POST['lname']));
    $contact = mysqli_real_escape_string($conn, trim($_POST['contact']));
    $email = mysqli_real_escape_string($conn, trim($_POST['email']));
    $password = trim($_POST['password']);

    $update_fields = "fname='$fname', mname='$mname', lname='$lname', contact='$contact', email='$email'";

    // Profile Image Upload (Optional)
    if (!empty($_FILES['profileImage']['name'])) {
        $target_dir = __DIR__ . "/../plugin/img/";

        if (!file_exists($target_dir)) {
            mkdir($target_dir, 0777, true);
        }

        $image_name = time() . "_" . str_replace(' ', '_', basename($_FILES['profileImage']['name']));
        $target_file = $target_dir . $image_name;
        $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));
        $allowed_extensions = ['jpg', 'jpeg', 'png'];

        if (in_array($imageFileType, $allowed_extensions)) {
            if (move_uploaded_file($_FILES['profileImage']['tmp_name'], $target_file)) {
                $update_fields .= ", photo='$image_name'";

                // Delete old profile pic (except default.png)
                if (!empty($user['photo']) && $user['photo'] != 'default.png' && file_exists($target_dir . $user['photo'])) {
                    unlink($target_dir . $user['photo']);
                }

                $_SESSION['user']['photo'] = $image_name;
            } else {
                $_SESSION['error'] = "Error uploading image. Please try again.";
                header("Location: index.php?page=profile");
                exit();
            }
        } else {
            $_SESSION['error'] = "Invalid file type. Only JPG, JPEG, and PNG allowed.";
            header("Location: index.php?page=profile");
            exit();
        }
    }

    // Password Update (Only if provided)
    if (!empty($password)) {
        $hashed_password = password_hash($password, PASSWORD_DEFAULT);
        $update_fields .= ", password='$hashed_password'";
    }

    // Update User Data
    $query = "UPDATE users SET $update_fields WHERE id=$user_id";
    if (mysqli_query($conn, $query)) {
        $_SESSION['success'] = "Profile updated successfully!";
    } else {
        $_SESSION['error'] = "Error updating profile: " . mysqli_error($conn);
    }

    // Redirect with JavaScript alert
    echo "<script>
        alert('Profile updated successfully!');
        window.location.href = 'index.php?page=profile';
    </script>";
    exit();
}

    ?>


<div class="container-fluid">
    <div class="row justify-content-center">
        <div class="col-xl-10 col-lg-12 col-md-9">
            <div class="card o-hidden border-0 shadow-lg my-5">
                <div class="card-body p-0">
                    <div class="row">
                        <div class="col-lg-6 d-flex align-items-center justify-content-center">
                            <?php
                            $photo = !empty($user['photo']) ? "../plugin/img/" . $user['photo'] : "../plugin/img/default.png";
                            ?>
                            <img src="<?php echo $photo; ?>" alt="Profile Image" class="img-fluid rounded">
                        </div>
                        <div class="col-lg-6 align-items-center justify-content-center">
                            <div class="p-5">
                                <div class="text-center">
                                    <h1 class="h4 text-gray-900 mb-4"><?php echo htmlspecialchars($user['fname'] . ' ' . $user['mname'] . ' ' . $user['lname']); ?></h1>
                                </div>

                                <!-- Alert Messages -->
                                <?php if (isset($_SESSION['success'])): ?>
                                    <div class="alert alert-success text-center">
                                        <?php echo $_SESSION['success']; unset($_SESSION['success']); ?>
                                    </div>
                                <?php endif; ?>

                                <?php if (isset($_SESSION['error'])): ?>
                                    <div class="alert alert-danger text-center">
                                        <?php echo $_SESSION['error']; unset($_SESSION['error']); ?>
                                    </div>
                                <?php endif; ?>

                                <form class="user" action="" method="POST" enctype="multipart/form-data">
                                    <div class="form-group">
                                        <label for="fname">First Name</label>
                                        <input type="text" name="fname" class="form-control" value="<?php echo htmlspecialchars($user['fname']); ?>" required>
                                    </div>

                                    <div class="form-group">
                                        <label for="mname">Middle Name</label>
                                        <input type="text" name="mname" class="form-control" value="<?php echo htmlspecialchars($user['mname']); ?>">
                                    </div>

                                    <div class="form-group">
                                        <label for="lname">Last Name</label>
                                        <input type="text" name="lname" class="form-control" value="<?php echo htmlspecialchars($user['lname']); ?>" required>
                                    </div>

                                    <div class="form-group">
                                        <label for="contact">Contact</label>
                                        <input type="text" name="contact" class="form-control" value="<?php echo htmlspecialchars($user['contact']); ?>">
                                    </div>

                                    <div class="form-group">
                                        <label for="email">Email</label>
                                        <input type="email" name="email" class="form-control" value="<?php echo htmlspecialchars($user['email']); ?>">
                                    </div>

                                    <div class="form-group">
                                        <label for="password">Password</label>
                                        <input type="password" name="password" class="form-control" placeholder="New password">
                                        <small class="text-danger">Leave blank to keep current password</small>
                                    </div>

                                    <div class="form-group">
                                        <label for="profileImage">Profile Image</label>
                                        <input type="file" name="profileImage" class="form-control" onchange="previewImage(event)">
                                        <small class="text-danger">Leave blank to keep current profile image</small>
                                    </div>

                                    <button type="submit" name="update_profile" class="btn btn-primary btn-user btn-block">
                                        Save
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div> 
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    function previewImage(event) {
        const input = event.target;
        const preview = document.getElementById('profileImagePreview');

        if (input.files && input.files[0]) {
            const reader = new FileReader();

            reader.onload = function(e) {
                preview.src = e.target.result;
            };

            reader.readAsDataURL(input.files[0]);
        }
    }
</script>
