<?php

// Function to count total records in a table
function total_count($conn, $table)
{
    $query = "SELECT COUNT(*) FROM $table";
    $result = mysqli_query($conn, $query);
    return mysqli_fetch_array($result)[0] ?? 0;
}

// Function to sum a column with optional filters
function getTotalSales($conn, $year = null, $month = null)
{
    $query = "SELECT SUM(subtotal) FROM sales WHERE 1";

    if ($year) {
        $query .= " AND YEAR(order_date) = $year";
    }
    if ($month) {
        $query .= " AND MONTH(order_date) = $month";
    }

    $result = mysqli_query($conn, $query);
    return mysqli_fetch_array($result)[0] ?? 0;
}

// Function to get today's earnings
function getEarningsToday($conn)
{
    $query = "SELECT SUM(subtotal) FROM sales WHERE DATE(order_date) = CURDATE()";
    $result = mysqli_query($conn, $query);
    return mysqli_fetch_array($result)[0] ?? 0;
}

// Get filters from dropdown selection
$selected_year = $_GET['year'] ?? date('Y');
$selected_month = $_GET['month'] ?? date('m');

// Fetching totals
$total_products = total_count($conn, 'products');
$total_sales = getTotalSales($conn, $selected_year, $selected_month);
$earnings_today = getEarningsToday($conn);
?>

<!-- Begin Page Content -->
<div class="container-fluid">
    <!-- Page Heading -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Dashboard</h1>
       
    </div>

    <!-- Content Row -->
    <div class="row">

        <!-- Total Products -->
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-info shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-info text-uppercase mb-1">Total Products</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800"><?= $total_products ?></div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-clipboard-list fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Earnings (Monthly) -->
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-primary shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">Earnings (Monthly)</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">₱<?= number_format($total_sales, 2) ?></div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-calendar fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Earnings (Annual) -->
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-success shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-success text-uppercase mb-1">Earnings (Annual)</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">₱<?= number_format(getTotalSales($conn, $selected_year), 2) ?></div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-dollar-sign fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Earnings Today -->
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-warning shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-warning text-uppercase mb-1">Earnings Today</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">₱<?= number_format($earnings_today, 2) ?></div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-coins fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>
</div>
</div>
<!-- /.container-fluid -->
