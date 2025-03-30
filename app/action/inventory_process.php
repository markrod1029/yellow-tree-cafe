<?php
require_once(__DIR__ . '/../init.php'); // Database connection

$action = isset($_POST['action']) ? $_POST['action'] : '';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if ($action === 'delete') {
        // Handle inventory deletion
        $inventory_id = isset($_POST['id']) ? intval($_POST['id']) : null;

        if ($inventory_id) {
            $query = "DELETE FROM inventory WHERE id = ?";
            $stmt = mysqli_prepare($conn, $query);

            if ($stmt) {
                mysqli_stmt_bind_param($stmt, "i", $inventory_id);
                mysqli_stmt_execute($stmt);
                mysqli_stmt_close($stmt);
                $message = "Inventory deleted successfully!";
            } else {
                $message = "Error preparing statement: " . mysqli_error($conn);
            }
        } else {
            $message = "Invalid inventory ID.";
        }

        mysqli_close($conn);
        echo "<script>alert('$message'); window.location.href = '../../admin/index.php?page=inventory';</script>";
        exit();
    } else {
        // Handle inventory add/update
        $inventory_id = isset($_POST['inventory_id']) ? intval($_POST['inventory_id']) : null;
        $product_name = isset($_POST['item_name']) ? mysqli_real_escape_string($conn, trim($_POST['item_name'])) : '';
        $supplier_id = isset($_POST['supplier_id']) ? intval($_POST['supplier_id']) : 0;
        $quantity = isset($_POST['quantity']) ? intval($_POST['quantity']) : 0;
        $buy_price = isset($_POST['buy_price']) ? floatval($_POST['buy_price']) : 0.00;

        // Validation
        if (empty($product_name) || $supplier_id <= 0  || $buy_price <= 0) {
            echo "<script>alert('All fields are required and must be valid.'); window.location.href = '../../admin/index.php?page=inventory_form';</script>";
            exit();
        }

        if ($inventory_id) {
            // Update existing inventory
            $query = "UPDATE inventory SET product_name = ?, supplier_id = ?, quantity = ?, buy_price = ?, updated_at = NOW() WHERE id = ?";
            $stmt = mysqli_prepare($conn, $query);

            if ($stmt) {
                mysqli_stmt_bind_param($stmt, "siidi", $product_name, $supplier_id, $quantity, $buy_price, $inventory_id);
                mysqli_stmt_execute($stmt);
                mysqli_stmt_close($stmt);
                $message = "Inventory updated successfully!";
            } else {
                $message = "Error preparing statement: " . mysqli_error($conn);
            }
        } else {
            // Insert new inventory
            $query = "INSERT INTO inventory (product_name, supplier_id, quantity, buy_price, created_at, updated_at) 
                      VALUES (?, ?, ?, ?, NOW(), NOW())";
            $stmt = mysqli_prepare($conn, $query);

            if ($stmt) {
                mysqli_stmt_bind_param($stmt, "siid", $product_name, $supplier_id, $quantity, $buy_price);
                mysqli_stmt_execute($stmt);
                mysqli_stmt_close($stmt);
                $message = "Inventory added successfully!";
            } else {
                $message = "Error preparing statement: " . mysqli_error($conn);
            }
        }

        mysqli_close($conn);
        echo "<script>alert('$message'); window.location.href = '../../admin/index.php?page=inventory';</script>";
        exit();
    }
}

// If no valid action was provided
echo "<script>alert('Invalid action.'); window.location.href = '../../admin/index.php?page=inventory';</script>";
exit();
?>
