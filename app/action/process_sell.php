<?php
require_once(__DIR__ . '/../init.php');

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Validate required fields
    $requiredFields = ['user_id', 'invoiceNumber', 'orderdate', 'product_id', 'price', 'order_quantity'];
    foreach ($requiredFields as $field) {
        if (empty($_POST[$field])) {
            echo "<script>alert('Error: Missing required field - $field'); window.history.back();</script>";
            exit();
        }
    }

    // Sanitize inputs
    $orderDate = mysqli_real_escape_string($conn, $_POST['orderdate']);
    $invoiceNumber = mysqli_real_escape_string($conn, $_POST['invoiceNumber']);
    $customer = !empty($_POST['customer']) ? mysqli_real_escape_string($conn, $_POST['customer']) : 'Walk-in Customer';
    $subtotal = floatval($_POST['subtotal']);
    $totalPayment = floatval($_POST['totalPayment']);
    $change = floatval($_POST['change']);
    $notes = isset($_POST['notes']) ? mysqli_real_escape_string($conn, $_POST['notes']) : '';
    $user_id = intval($_POST['user_id']);

    // Start transaction
    mysqli_begin_transaction($conn);

    try {
        // Generate order number (next available)
        $orderNumberQuery = "SELECT COALESCE(MAX(order_number), 10000) + 1 AS next_order FROM sales";
        $orderResult = mysqli_query($conn, $orderNumberQuery);
        $orderRow = mysqli_fetch_assoc($orderResult);
        $orderNumber = $orderRow['next_order'];

        // Insert into sales table
        $salesQuery = "INSERT INTO sales (
            order_number, invoice_number, user_id, customer_name, order_date, subtotal, total_payment, change_amount, notes
        ) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)";

        $stmt = mysqli_prepare($conn, $salesQuery);
        if (!$stmt) {
            throw new Exception("Error preparing sales statement: " . mysqli_error($conn));
        }

        mysqli_stmt_bind_param($stmt, "issssdids", $orderNumber, $invoiceNumber, $user_id, $customer, $orderDate, $subtotal, $totalPayment, $change, $notes);
        mysqli_stmt_execute($stmt);
        mysqli_stmt_close($stmt);
        $sales_id = mysqli_insert_id($conn);

        // Process each product in the sale
        foreach ($_POST['product_id'] as $index => $product_id) {
            $product_id = intval($product_id);
            $price = floatval($_POST['price'][$index]);
            $order_quantity = intval($_POST['order_quantity'][$index]);
            $total_price = $price * $order_quantity;

            // Lock the product row for update
            $stockQuery = "SELECT quantity FROM products WHERE id = ? FOR UPDATE";
            $stmt = mysqli_prepare($conn, $stockQuery);
            mysqli_stmt_bind_param($stmt, "i", $product_id);
            mysqli_stmt_execute($stmt);
            $result = mysqli_stmt_get_result($stmt);
            $product = mysqli_fetch_assoc($result);
            mysqli_stmt_close($stmt);

            if (!$product) {
                throw new Exception("Error: Product with ID $product_id not found.");
            }

            if ($product['quantity'] < $order_quantity) {
                throw new Exception("Error: Insufficient stock for product ID $product_id. Available: {$product['quantity']}, Requested: $order_quantity");
            }

            // Insert into sales_products
            $salesProductQuery = "INSERT INTO sales_products (sales_id, product_id, price, order_quantity, total_price) VALUES (?, ?, ?, ?, ?)";
            $stmt = mysqli_prepare($conn, $salesProductQuery);
            mysqli_stmt_bind_param($stmt, "iidid", $sales_id, $product_id, $price, $order_quantity, $total_price);
            mysqli_stmt_execute($stmt);
            mysqli_stmt_close($stmt);

            // Update product stock
            $updateStockQuery = "UPDATE products SET quantity = quantity - ? WHERE id = ?";
            $stmt = mysqli_prepare($conn, $updateStockQuery);
            mysqli_stmt_bind_param($stmt, "ii", $order_quantity, $product_id);
            mysqli_stmt_execute($stmt);
            mysqli_stmt_close($stmt);
        }

        // Commit transaction
        mysqli_commit($conn);
        if($user_id == 1) {
            echo "<script>alert('Sale recorded successfully! Invoice #$invoiceNumber'); window.location.href = '../../admin/index.php?page=sell_form';</script>";
        } else {
            echo "<script>alert('Sale recorded successfully! Invoice #$invoiceNumber'); window.location.href = '../../staff/index.php?page=sell_form';</script>";
        }
        exit();

    } catch (Exception $e) {
        // Rollback transaction on error
        mysqli_rollback($conn);
        echo "<script>alert('Transaction failed: " . addslashes($e->getMessage()) . "'); window.history.back();</script>";
        exit();
    }
} else {
    echo "<script>alert('Invalid request method.'); window.history.back();</script>";
    exit();
}
?>
