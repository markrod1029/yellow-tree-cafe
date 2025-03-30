<?php
// Fetch all products
$product_query = "SELECT * FROM products";
$product_result = mysqli_query($conn, $product_query);

// Handle form submission
$message = ""; // Para sa JavaScript alert
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['submit'])) {
    $product_id = isset($_POST['p_product_name']) ? intval($_POST['p_product_name']) : null;
    $sell_price = isset($_POST['p_p_sell_price']) ? floatval($_POST['p_p_sell_price']) : null;
    $purchase_quantity = isset($_POST['p_pn_quantity']) ? intval($_POST['p_pn_quantity']) : 0;
    $created_at = date('Y-m-d H:i:s');

    if ($product_id && $sell_price) {
        // INSERT new quantity record
        $query = "INSERT INTO quantity (product_id, sell_price, new_quantity, created_at) 
                  VALUES ('$product_id', '$sell_price', '$purchase_quantity', '$created_at')";

        if (mysqli_query($conn, $query)) {
            // UPDATE `products.quantity` (add purchase quantity)
            $update_query = "UPDATE products 
                             SET quantity = quantity + $purchase_quantity, 
                                 sell_price = '$sell_price'  
                             WHERE id = '$product_id'";

            if (mysqli_query($conn, $update_query)) {
                $message = "Quantity recorded successfully! Stock updated.";
            } else {
                $message = "Quantity saved but stock update failed: " . mysqli_error($conn);
            }
        } else {
            $message = "Error saving purchase: " . mysqli_error($conn);
        }
    } else {
        $message = "All fields are required.";
    }

    // Redirect with alert
    echo "<script>
            alert('$message');
            window.location.href = '" . $_SERVER['PHP_SELF'] . "?page=quantity';
          </script>";
    exit();
}
?>

<!-- Content Wrapper -->
<div class="content-wrapper">
    <div class="container-fluid">
        <h1 class="h3 mb-2 text-gray-800">New Quantity</h1>

        <div class="card shadow mb-4">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-primary">Register New Quantity</h6>
            </div>
            <div class="card-body">
                <form id="addByproductForm" method="POST">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="product_name">Product Name * :</label>
                                <select name="p_product_name" id="p_product_name" class="form-control select2">
                                    <option selected disabled>Select a product</option>
                                    <?php while ($product = mysqli_fetch_assoc($product_result)) : ?>
                                        <option value="<?= $product['id']; ?>" 
                                            data-stock="<?= $product['quantity']; ?>" 
                                            data-sell_price="<?= $product['sell_price']; ?>">
                                            <?= $product['product_name']; ?> (<?= $product['brand_name']; ?>)
                                        </option>
                                    <?php endwhile; ?>
                                </select>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="puchar_date">Purchase Date</label>
                                <input type="text" class="form-control datepicker" name="puchar_date" id="puchar_date" value="<?= date('Y-m-d'); ?>" readonly>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="p_p_sell_price">Sell Price</label>
                                <input type="number" class="form-control" id="p_p_sell_price" value="0" name="p_p_sell_price">
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="p_p_quantity">Stock Product Quantity</label>
                                <input type="number" class="form-control" id="p_p_quantity"  name="p_p_quantity" readonly>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="p_pn_quantity">New Quantity</label>
                                <input type="number" class="form-control" id="p_pn_quantity" value="0" name="p_pn_quantity">
                            </div>
                        </div>
                    </div>

                    <div class="form-group text-center">
                        <button type="submit" class="btn btn-success btn-lg px-4" name="submit">Submit Quantity</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    </div>
</div>

<!-- JavaScript to Update Stock Quantity Without AJAX -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
    $(document).ready(function() {
        // Auto-set today's date in the purchase date field
        let today = new Date().toISOString().split('T')[0];
        $("#puchar_date").val(today);

        // When a product is selected, update the stock quantity and sell price fields
        $("#p_product_name").change(function() {
            var stockQuantity = $(this).find(":selected").data("stock");
            var sellPrice = $(this).find(":selected").data("sell_price");

            $("#p_p_quantity").val(stockQuantity);
            $("#p_p_sell_price").val(sellPrice);
        });
    });
</script>

<?php mysqli_close($conn); ?>
