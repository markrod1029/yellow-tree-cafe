<?php
require_once(__DIR__ . '/../init.php'); // Database connection
ob_start(); // Start output buffering

$successMsg = "";
$errorMsg = "";

// Check if action is set
$action = isset($_POST['action']) ? $_POST['action'] : '';

if ($action === 'delete') {
    // Delete staff
    $staff_id = isset($_POST['id']) ? intval($_POST['id']) : null;
    
    if ($staff_id) {
        $query = "DELETE FROM users WHERE id = $staff_id AND role = 'staff'";
        if (mysqli_query($conn, $query)) {
            $successMsg = "User deleted successfully!";
        } else {
            $errorMsg = "Error deleting staff: " . mysqli_error($conn);
        }
    } else {
        $errorMsg = "Invalid staff ID.";
    }
} elseif ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Handle add/update
    $staff_id = isset($_POST['id']) ? intval($_POST['id']) : null;
    $fname = trim($_POST['fname']);
    $mname = trim($_POST['mname']);
    $lname = trim($_POST['lname']);
    $email = trim($_POST['email']);
    $password = trim($_POST['password']);
    $contact = trim($_POST['contact']);
    $address = trim($_POST['address']);

    // Validation
    if (empty($fname) || empty($lname) || empty($contact) || empty($address)) {
        $errorMsg = "All fields marked with * are required.";
    } else {
        $passwordQuery = "";
        if (!$staff_id && !empty($password)) {
            $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
            $passwordQuery = ", password = '$hashedPassword'";
        }

        if ($staff_id) {
            // Update existing staff
            $query = "UPDATE users SET 
                        fname = '$fname',
                        mname = '$mname',
                        lname = '$lname',
                        email = '$email',
                        contact = '$contact',
                        address = '$address',
                        role = 'staff',
                        updated_at = NOW()
                        $passwordQuery
                      WHERE id = $staff_id";
        } else {
            // Insert new staff
            $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
            $query = "INSERT INTO users (fname, mname, lname, email, password, contact, address, role, created_at, updated_at) 
                      VALUES ('$fname', '$mname', '$lname', '$email', '$hashedPassword', '$contact', '$address', 'staff', NOW(), NOW())";
        }

        if (mysqli_query($conn, $query)) {
            $successMsg = $staff_id ? "User updated successfully!" : "User added successfully!";
        } else {
            $errorMsg = "Database error: " . mysqli_error($conn);
        }
    }
}

mysqli_close($conn);
ob_end_flush(); // Send output buffer
?>

<script>
    document.addEventListener("DOMContentLoaded", function() {
        <?php if (!empty($successMsg)): ?>
            alert("<?= addslashes($successMsg) ?>");
            window.location.href = "../../admin/index.php?page=staff";
        <?php elseif (!empty($errorMsg)): ?>
            alert("<?= addslashes($errorMsg) ?>");
        <?php endif; ?>
    });
</script>
