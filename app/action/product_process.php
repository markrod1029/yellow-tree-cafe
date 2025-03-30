<?php
require_once(__DIR__ . '/../init.php'); // Database connection

$action = isset($_POST['action']) ? $_POST['action'] : '';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if ($action === 'delete') {
        // Handle product deletion
        $product_id = isset($_POST['id']) ? intval($_POST['id']) : null;

        if ($product_id) {
            $query = "DELETE FROM products WHERE id = ?";
            $stmt = mysqli_prepare($conn, $query);

            if ($stmt) {
                mysqli_stmt_bind_param($stmt, "i", $product_id);
                if (mysqli_stmt_execute($stmt)) {
                    $message = "Product deleted successfully!";
                } else {
                    $message = "Error deleting product: " . mysqli_error($conn);
                }
                mysqli_stmt_close($stmt);
            } else {
                $message = "Error preparing statement: " . mysqli_error($conn);
            }
        } else {
            $message = "Invalid product ID.";
        }

        mysqli_close($conn);
        echo "<script>alert('$message'); window.location.href = '../../pages/admin/index.php?page=products';</script>";
        exit();
    } else {
        // Handle product add/update
        $product_id = isset($_POST['product_id']) ? intval($_POST['product_id']) : null;
        $product_name = isset($_POST['product_name']) ? mysqli_real_escape_string($conn, trim($_POST['product_name'])) : '';
        $brand = isset($_POST['brand']) ? mysqli_real_escape_string($conn, trim($_POST['brand'])) : '';
        $p_category = isset($_POST['p_category']) ? intval($_POST['p_category']) : 0;

        // Validation
        if (empty($product_name) || empty($brand) || $p_category <= 0) {
            echo "<script>alert('All fields are required.'); window.location.href = '../../admin/index.php?page=products';</script>";
            exit();
        }

        if ($product_id) {
            // Update existing product
            $query = "UPDATE products SET product_name = ?, brand_name = ?, category_id = ?, updated_at = NOW() WHERE id = ?";
            $stmt = mysqli_prepare($conn, $query);

            if ($stmt) {
                mysqli_stmt_bind_param($stmt, "ssii", $product_name, $brand, $p_category, $product_id);
                if (mysqli_stmt_execute($stmt)) {
                    $message = "Product updated successfully!";
                } else {
                    $message = "Error updating product: " . mysqli_error($conn);
                }
                mysqli_stmt_close($stmt);
            } else {
                $message = "Error preparing statement: " . mysqli_error($conn);
            }
        } else {
            // Insert new product
            $query = "INSERT INTO products (product_name, brand_name, category_id, created_at, updated_at) 
                      VALUES (?, ?, ?, NOW(), NOW())";
            $stmt = mysqli_prepare($conn, $query);

            if ($stmt) {
                mysqli_stmt_bind_param($stmt, "ssi", $product_name, $brand, $p_category);
                if (mysqli_stmt_execute($stmt)) {
                    $message = "Product added successfully!";
                } else {
                    $message = "Error inserting product: " . mysqli_error($conn);
                }
                mysqli_stmt_close($stmt);
            } else {
                $message = "Error preparing statement: " . mysqli_error($conn);
            }
        }

        mysqli_close($conn);
        echo "<script>alert('$message'); window.location.href = '../../admin/index.php?page=products';</script>";
        exit();
    }
}

// If no valid action was provided
echo "<script>alert('Invalid action.'); window.location.href = '../../admin/index.php?page=products';</script>";
exit();
?>
