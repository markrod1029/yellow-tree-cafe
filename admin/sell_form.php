<?php
// Fetch all products
$product_query = "SELECT * FROM products";
$product_result = mysqli_query($conn, $product_query);

function generateInvoiceNumber() {
    return 'INV-' . date('Ymd') . '-' . strtoupper(substr(uniqid(), -6));
}

// Display success/error messages
if (isset($_SESSION['success_message'])) {
    echo '<script>alert("' . $_SESSION['success_message'] . '");</script>';
    unset($_SESSION['success_message']);
}

if (isset($_SESSION['error_message'])) {
    echo '<script>alert("Error: ' . $_SESSION['error_message'] . '");</script>';
    unset($_SESSION['error_message']);
}
?>

<style>
    .sales-container {
        max-width: 1000px;
        margin: 0 auto;
        padding: 20px;
    }
    .product-card {
        border: 1px solid #e0e0e0;
        border-radius: 8px;
        padding: 15px;
        margin-bottom: 15px;
        transition: all 0.3s ease;
    }
    .product-card:hover {
        box-shadow: 0 4px 8px rgba(0,0,0,0.1);
    }
    .product-grid {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(200px, 1fr));
        gap: 15px;
        margin-bottom: 20px;
    }
    .sales-table th {
        background-color: #4e73df;
        color: white;
    }
    .totals-panel {
        background-color: #f8f9fc;
        border-radius: 8px;
        padding: 20px;
        margin-top: 20px;
    }
    .center-container {
        display: flex;
        justify-content: center;
        margin-top: 20px;
    }
    #productSearch {
        margin-bottom: 20px;
        padding: 10px;
        border-radius: 4px;
        border: 1px solid #ddd;
        width: 100%;
    }
    .product-select-btn {
        background-color: #4e73df;
        color: white;
        border: none;
        padding: 5px 10px;
        border-radius: 4px;
        cursor: pointer;
    }
    .product-select-btn:hover {
        background-color: #2e59d9;
    }
</style>

<div class="sales-container">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2 class="mb-0">New Sale</h2>
        <div>
            <span class="badge badge-primary p-2"><?php echo date('F j, Y'); ?></span>
        </div>
    </div>

    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">Sale Details</h6>
        </div>
        <div class="card-body">
            <form id="sellForm" method="POST" action="../app/action/process_sell.php" onsubmit="return validateForm()">
                <div class="row mb-4">
                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="orderdate">Order Date</label>
                            <input type="text" class="form-control" name="orderdate" id="orderdate" 
                                   value="<?php echo date('Y-m-d'); ?>" readonly>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="invoiceNumber">Invoice #</label>
                            <input type="text" class="form-control" name="invoiceNumber" id="invoiceNumber" 
                                   value="<?php echo generateInvoiceNumber(); ?>" readonly>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="customer">Customer</label>
                            <input type="text" class="form-control" name="customer" id="customer" 
                                   placeholder="Walk-in Customer">
                        </div>
                    </div>
                </div>

                <h5 class="mb-3">Available Products</h5>
                <input type="text" id="productSearch" placeholder="Search products..." class="form-control mb-3">
                
                <div class="product-grid">
                    <?php while ($product = mysqli_fetch_assoc($product_result)) : ?>
                        <div class="product-card">
                            <h6><?php echo htmlspecialchars($product['product_name']); ?></h6>
                            <p class="text-muted mb-1"><?php echo htmlspecialchars($product['brand_name']); ?></p>
                            <p class="font-weight-bold">₱<?php echo number_format($product['sell_price'], 2); ?></p>
                            <p>Available: <?php echo $product['quantity']; ?></p>
                            <button type="button" class="product-select-btn"
                                    data-id="<?php echo $product['id']; ?>"
                                    data-name="<?php echo htmlspecialchars($product['product_name']); ?>"
                                    data-price="<?php echo $product['sell_price']; ?>"
                                    data-quantity="<?php echo $product['quantity']; ?>">
                                Add to Sale
                            </button>
                        </div>
                    <?php endwhile; ?>
                </div>

                <h5 class="mt-4 mb-3">Current Sale Items</h5>
                <div class="table-responsive">
                    <table class="table table-bordered sales-table">
                        <thead>
                            <tr>
                                <th width="5%">#</th>
                                <th width="35%">Product</th>
                                <th width="15%">Available</th>
                                <th width="15%">Price</th>
                                <th width="15%">Quantity</th>
                                <th width="15%">Total</th>
                                <th width="5%">Action</th>
                            </tr>
                        </thead>
                        <tbody id="invoiceItem"></tbody>
                    </table>
                </div>

                <div class="totals-panel">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="notes">Notes</label>
                                <textarea class="form-control" name="notes" id="notes" rows="2"></textarea>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group row">
                                <label for="subtotal" class="col-sm-4 col-form-label">Subtotal:</label>
                                <div class="col-sm-8">
                                    <input type="number" class="form-control text-right font-weight-bold" 
                                           name="subtotal" id="subtotal" value="0.00" readonly>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="totalPayment" class="col-sm-4 col-form-label">Amount Paid:</label>
                                <div class="col-sm-8">
                                    <input type="number" class="form-control text-right" name="totalPayment" 
                                           id="totalPayment" value="0.00" min="0" step="0.01" required>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="change" class="col-sm-4 col-form-label">Change:</label>
                                <div class="col-sm-8">
                                    <input type="number" class="form-control text-right font-weight-bold" 
                                           name="change" id="change" value="0.00" readonly>
                                    <input type="hidden" name="user_id" value="<?php echo $user['id']; ?>">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="center-container">
                    <button type="submit" class="btn btn-success btn-lg mr-3">
                        <i class="fas fa-cash-register"></i> Complete Sale
                    </button>
                    <button type="reset" class="btn btn-secondary btn-lg">
                        <i class="fas fa-redo"></i> Reset
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
$(document).ready(function() {
    let count = 0;

    // Product search functionality
    $('#productSearch').keyup(function() {
        const searchText = $(this).val().toLowerCase();
        $('.product-card').each(function() {
            const productText = $(this).text().toLowerCase();
            $(this).toggle(productText.includes(searchText));
        });
    });

    // Add product to sale
    $(document).on('click', '.product-select-btn', function() {
        const id = $(this).data('id');
        const name = $(this).data('name');
        const price = parseFloat($(this).data('price'));
        const quantity = parseInt($(this).data('quantity'));

        // Check if product already exists in the table
        let exists = false;
        $('#invoiceItem tr').each(function() {
            const existingId = $(this).find('input[name="product_id[]"]').val();
            if (existingId == id) {
                exists = true;
                return false; // break the loop
            }
        });

        if (!exists) {
            count++;
            const row = `
                <tr id="row${count}">
                    <td>${count}</td>
                    <td>
                        ${name} 
                        <input type="hidden" name="product_id[]" value="${id}">
                    </td>
                    <td class="text-center">${quantity}</td>
                    <td>
                        <input type="number" class="form-control productPrice text-right" 
                               name="price[]" value="${price.toFixed(2)}" 
                               step="0.01" min="0" readonly>
                    </td>
                    <td>
                        <input type="number" class="form-control orderQuantity text-right" 
                               name="order_quantity[]" min="1" max="${quantity}" 
                               value="1" required>
                    </td>
                    <td class="totalPrice text-right">${price.toFixed(2)}</td>
                    <td class="text-center">
                        <button type="button" class="btn btn-danger btn-sm removeRow" 
                                data-id="row${count}" title="Remove">
                            <i class="fas fa-trash"></i>
                        </button>
                    </td>
                </tr>`;
            
            $('#invoiceItem').append(row);
            updateTotals();
        } else {
            alert('This product is already in the sale');
        }
    });

    // Real-time calculations
    $(document).on('input', '.orderQuantity, .productPrice', function() {
        updateRowTotal($(this).closest('tr'));
        updateTotals();
    });

    // Remove row
    $(document).on('click', '.removeRow', function() {
        $('#' + $(this).data('id')).remove();
        // Renumber rows
        $('#invoiceItem tr').each(function(index) {
            $(this).find('td:first').text(index + 1);
        });
        count = $('#invoiceItem tr').length;
        updateTotals();
    });

    // Payment amount change
    $('#totalPayment').on('input', function() {
        updateChange();
    });

    function updateRowTotal(row) {
        const qty = parseFloat(row.find('.orderQuantity').val()) || 0;
        const price = parseFloat(row.find('.productPrice').val()) || 0;
        const total = qty * price;
        row.find('.totalPrice').text(total.toFixed(2));
    }

    function updateTotals() {
        let subtotal = 0;
        $('.totalPrice').each(function() {
            subtotal += parseFloat($(this).text());
        });
        
        $('#subtotal').val(subtotal.toFixed(2));
        updateChange();
    }

    function updateChange() {
        const subtotal = parseFloat($('#subtotal').val()) || 0;
        const totalPayment = parseFloat($('#totalPayment').val()) || 0;
        const change = totalPayment - subtotal;
        
        $('#change').val(change.toFixed(2));
        if (change >= 0) {
            $('#change').removeClass('text-danger').addClass('text-success');
        } else {
            $('#change').removeClass('text-success').addClass('text-danger');
        }
    }
});

function validateForm() {
    // Check if there are products in the sale
    if ($('#invoiceItem tr').length === 0) {
        alert('Error: Please add at least one product to the sale');
        return false;
    }
    
    // Validate payment amount
    const subtotal = parseFloat($('#subtotal').val()) || 0;
    const totalPayment = parseFloat($('#totalPayment').val()) || 0;
    
    if (totalPayment < subtotal) {
        alert('Error: Payment amount cannot be less than the subtotal');
        return false;
    }
    
    return true;
}
</script>