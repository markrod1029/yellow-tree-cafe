<?php 

// Check if `view_id` is set
if (isset($_GET['view_id'])) {
    $view_id = $_GET['view_id'];

    // Get Sell Total
    $sell_query = "SELECT * FROM invoice WHERE id = $view_id";
    $sell_result = mysqli_query($conn, $sell_query);
    $sell_total = mysqli_fetch_assoc($sell_result);

    if ($sell_total) {
        // Get Customer Details
        $customer_id = $sell_total['customer_id'];
        $customer_query = "SELECT * FROM member WHERE id = $customer_id";
        $customer_result = mysqli_query($conn, $customer_query);
        $customer = mysqli_fetch_assoc($customer_result);
    }
}
?>

<style>
@page {
    margin-top: 150px;
    margin-bottom: 100px;
}

@media print {
    body {
        font-size: 12px;
    }

    .view_sell_payment_info,
    .view_sell_button-area,
    footer.main-footer {
        display: none;
    }

    .card.view_sell_page_info {
        margin-top: 100px;
    }
}
</style>

<!-- Content Wrapper -->
<div class="content-wrapper">
    <!-- Main content -->
    <section class="content mt-5">
        <div class="container-fluid">
            <div class="card view_sell_page_info">
                <div class="card-header">
                    Sell Information
                </div>
                <div class="card-body">
                    <?php if (!empty($sell_total) && !empty($customer)) { ?>
                        <div class="row">
                            <div class="col-md-4 col-lg-4">
                                <div class="purchase-suppliar-info">
                                    <p><i><b>Customer</b></i></p>
                                    <p><b>Name: <?php echo $customer['name']; ?></b></p>
                                    <p>Company: <?php echo $customer['company']; ?></p>
                                    <p>Address: <?php echo $customer['address']; ?></p>
                                    <p>Phone: <?php echo $customer['con_num']; ?></p>
                                    <p>Email: <?php echo $customer['email']; ?></p>
                                    <p>Supplier ID: <?php echo $customer['member_id']; ?></p>
                                </div>
                            </div>
                            <div class="col-md-4 col-lg-4"></div>
                            <div class="col-md-4 col-lg-4">
                                <p>Purchase Date: <?php echo $sell_total['order_date']; ?></p>
                                <p>Invoice No: <?php echo $sell_total['invoice_number']; ?></p>
                            </div>
                        </div>

                        <table class="display dataTable text-center mt-4">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Product Name</th>
                                    <th>Brand Name</th>
                                    <th>Quantity</th>
                                    <th>Unit Price</th>
                                    <th>Total Price</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php 
                                $invoice_id = $sell_total['id'];
                                $product_query = "SELECT * FROM invoice_details WHERE invoice_no = $invoice_id";
                                $product_result = mysqli_query($conn, $product_query);
                                $i = 0;

                                while ($product = mysqli_fetch_assoc($product_result)) {
                                    $i++;
                                    $pid = $product['pid'];
                                    $brand_query = "SELECT brand_name FROM products WHERE id = $pid";
                                    $brand_result = mysqli_query($conn, $brand_query);
                                    $brand = mysqli_fetch_assoc($brand_result);
                                    ?>
                                    <tr>
                                        <td><?php echo $i; ?></td>
                                        <td><?php echo $product['product_name']; ?></td>
                                        <td><?php echo $brand['brand_name']; ?></td>
                                        <td><?php echo $product['quantity']; ?></td>
                                        <td><?php echo $product['price'] / $product['quantity']; ?></td>
                                        <td><?php echo $product['price']; ?></td>
                                    </tr>
                                <?php } ?>
                            </tbody>
                        </table>

                        <hr>
                        <div class="row">
                            <div class="col-md-8 col-lg-8">
                                <div class="view_sell_payment_info">
                                    <h4 class="mt-4">Payments Information:</h4>
                                    <table class="table table-bordered text-center">
                                        <thead class="bg-info">
                                            <tr>
                                                <th>#</th>
                                                <th>Date</th>
                                                <th>Payment Type</th>
                                                <th>Payment Note</th>
                                                <th>Payment Amount</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php 
                                            $payment_query = "SELECT * FROM sell_payment WHERE customer_id = $customer_id";
                                            $payment_result = mysqli_query($conn, $payment_query);
                                            $i = 0;

                                            while ($payment = mysqli_fetch_assoc($payment_result)) {
                                                $i++;
                                                ?>
                                                <tr>
                                                    <th><?php echo $i; ?></th>
                                                    <th><?php echo $payment['payment_date']; ?></th>
                                                    <th><?php echo $payment['payment_type']; ?></th>
                                                    <th><?php echo $payment['pay_description']; ?></th>
                                                    <th><?php echo $payment['payment_amount']; ?></th>
                                                </tr>
                                            <?php } ?>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                            <div class="col-md-4 col-lg-4">
                                <div class="pruchase-view-description">
                                    <table class="table">
                                        <tr>
                                            <td>Subtotal</td>
                                            <td>:</td>
                                            <td><?php echo $sell_total['sub_total']; ?></td>
                                        </tr>
                                        <tr>
                                            <td>Previous Due</td>
                                            <td>:</td>
                                            <td><?php echo $sell_total['pre_cus_due']; ?></td>
                                        </tr>
                                        <tr>
                                            <td>Net Total</td>
                                            <td>:</td>
                                            <td><?php echo $sell_total['net_total']; ?></td>
                                        </tr>
                                        <tr>
                                            <td>Paid Amount</td>
                                            <td>:</td>
                                            <td><?php echo $sell_total['paid_amount']; ?></td>
                                        </tr>
                                        <tr>
                                            <td>Due Amount</td>
                                            <td>:</td>
                                            <td><?php echo $sell_total['due_amount']; ?></td>
                                        </tr>
                                    </table>
                                </div>
                            </div>
                        </div>

                        <div class="view_sell_button-area">
                            <div class="btn-group" role="group">
                                <a href="index.php?page=return_sell&&reurn_id=<?php echo $sell_total['id']; ?>" class="btn btn-info rounded-0 ml-2"><i class="fas fa-reply-all"></i> Return Sell</a>
                                <a href="index.php?page=edit_sell&&edit_id=<?php echo $sell_total['id']; ?>" class="btn btn-success rounded-0 ml-2"><i class="fas fa-edit"></i> Edit Sell</a>
                                <button type="button" onclick="window.print()" class="btn btn-primary ml-2"><i class="fas fa-file-pdf"></i> Print</button>
                            </div>
                        </div>
                    <?php } ?>
                </div>
            </div>
        </div>
    </section>
</div>
