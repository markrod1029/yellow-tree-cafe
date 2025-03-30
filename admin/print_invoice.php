<?php
require_once(__DIR__ . '/../init.php');

if (!isset($_SESSION['invoice_html'])) {
    $_SESSION['error_message'] = 'No invoice data found';
    header("Location: ../../index.php");
    exit();
}

// Display any success message
if (isset($_SESSION['success_message'])) {
    echo '<script>alert("'.$_SESSION['success_message'].'");</script>';
    unset($_SESSION['success_message']);
}

// Display the invoice
echo $_SESSION['invoice_html'];
unset($_SESSION['invoice_html']);

// Add JavaScript to handle print and redirect
echo '
<script>
    window.onload = function() {
        setTimeout(function() {
            window.print();
        }, 500);
        
        // Redirect after print or after 5 seconds
        setTimeout(function() {
            window.location.href = "../../admin/index.php?page=sell_form";
        }, 5000);
    };
</script>';
?>