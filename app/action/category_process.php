<?php
require_once(__DIR__ . '/../init.php'); // Database connection
ob_start(); // Start output buffering

$successMsg = "";
$errorMsg = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $category_id = isset($_POST['id']) ? intval($_POST['id']) : null;
    $name = trim($_POST['name']);

    // Validation
    if (empty($name)) {
        $errorMsg = "Category name is required.";
    } else {
        if ($category_id) {
            // Update existing category
            $query = "UPDATE category SET name = ?, updated_at = NOW() WHERE id = ?";
            $stmt = mysqli_prepare($conn, $query);
            if ($stmt) {
                mysqli_stmt_bind_param($stmt, "si", $name, $category_id);
                if (mysqli_stmt_execute($stmt)) {
                    $successMsg = "Category updated successfully!";
                } else {
                    $errorMsg = "Database error: " . mysqli_error($conn);
                }
            } else {
                $errorMsg = "Database preparation error: " . mysqli_error($conn);
            }
        } else {
            // Insert new category
            $query = "INSERT INTO category (name, created_at, updated_at) VALUES (?, NOW(), NOW())";
            $stmt = mysqli_prepare($conn, $query);
            if ($stmt) {
                mysqli_stmt_bind_param($stmt, "s", $name);
                if (mysqli_stmt_execute($stmt)) {
                    $successMsg = "Category added successfully!";
                } else {
                    $errorMsg = "Database error: " . mysqli_error($conn);
                }
            } else {
                $errorMsg = "Database preparation error: " . mysqli_error($conn);
            }
        }
    }
}

// Handle category deletion
if (isset($_POST['action']) && $_POST['action'] === 'delete') {
    $category_id = isset($_POST['id']) ? intval($_POST['id']) : null;

    if ($category_id) {
        $query = "DELETE FROM category WHERE id = ?";
        $stmt = mysqli_prepare($conn, $query);
        if ($stmt) {
            mysqli_stmt_bind_param($stmt, "i", $category_id);
            if (mysqli_stmt_execute($stmt)) {
                $successMsg = "Category deleted successfully!";
            } else {
                $errorMsg = "Error deleting category: " . mysqli_error($conn);
            }
        } else {
            $errorMsg = "Database preparation error: " . mysqli_error($conn);
        }
    } else {
        $errorMsg = "Invalid category ID.";
    }
}

mysqli_close($conn);
ob_end_flush();
?>

<script>
    document.addEventListener("DOMContentLoaded", function() {
        let successMsg = "<?= addslashes($successMsg) ?>";
        let errorMsg = "<?= addslashes($errorMsg) ?>";

        if (successMsg) {
            alert(successMsg);
            window.location.href = "../../admin/index.php?page=category";
        } else if (errorMsg) {
            alert(errorMsg);
        }
    });
</script>
