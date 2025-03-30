<?php
require_once(__DIR__ . '/../init.php'); // Database connection
ob_start(); // Start output buffering

$successMsg = "";
$errorMsg = "";

// Check if action is set
$action = isset($_POST['action']) ? $_POST['action'] : '';

if ($action === 'delete') {
    // Delete supplier
    $supplier_id = isset($_POST['id']) ? intval($_POST['id']) : null;
    
    if ($supplier_id) {
        $query = "DELETE FROM suppliers WHERE id = $supplier_id";
        if (mysqli_query($conn, $query)) {
            $successMsg = "Supplier deleted successfully!";
        } else {
            $errorMsg = "Error deleting supplier: " . mysqli_error($conn);
        }
    } else {
        $errorMsg = "Invalid supplier ID.";
    }
} elseif ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Handle add/update
    $supplier_id = isset($_POST['id']) ? intval($_POST['id']) : null;
    $fname = trim($_POST['fname']);
    $mname = trim($_POST['mname']);
    $lname = trim($_POST['lname']);
    $company = trim($_POST['company']);
    $contact = trim($_POST['contact']);
    $email = trim($_POST['email']);
    $address = trim($_POST['address']);

    // Validation
    if (empty($fname) || empty($lname) || empty($company) || empty($contact) || empty($address)) {
        $errorMsg = "All fields marked with * are required.";
    } else {
        if ($supplier_id) {
            // Update existing supplier
            $query = "UPDATE suppliers SET 
                        fname = '$fname',
                        mname = '$mname',
                        lname = '$lname',
                        company = '$company',
                        contact = '$contact',
                        email = '$email',
                        address = '$address',
                        updated_at = NOW()
                      WHERE id = $supplier_id";
        } else {
            // Insert new supplier
            $query = "INSERT INTO suppliers (fname, mname, lname, company, contact, email, address, created_at, updated_at) 
                      VALUES ('$fname', '$mname', '$lname', '$company', '$contact', '$email', '$address', NOW(), NOW())";
        }

        if (mysqli_query($conn, $query)) {
            $successMsg = $supplier_id ? "Supplier updated successfully!" : "Supplier added successfully!";
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
            window.location.href = "../../admin/index.php?page=suppliers";
        <?php elseif (!empty($errorMsg)): ?>
            alert("<?= addslashes($errorMsg) ?>");
        <?php endif; ?>
    });
</script>
