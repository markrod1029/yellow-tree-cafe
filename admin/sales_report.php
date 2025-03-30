<!-- Content Wrapper -->
<div class="content-wxrapper">
  <!-- Content Header -->
  <!-- Begin Page Content -->
  <div class="container-fluid">

    <!-- Page Heading -->
    <h1 class="h3 mb-2 text-gray-800">Sales Report</h1>
    <!-- DataTales Example -->
    <div class="card shadow mb-4">
      <div class="card-header py-3">
        <h6 class="m-0 font-weight-bold text-primary">Sales</h6>
      </div>
      <div class="card-body">
        <div class="table-responsive">

          <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
            <thead>
              <tr>
              <th>date</th>
                <th>invoice No</th>
                <th>Customer Name</th>
                <th>Sub Total</th>
                <th>Change</th>
                <th>total Payment</th>
              </tr>
            </thead>
            <tbody>
              <?php
              $query = "SELECT * FROM sales ORDER BY sales.id DESC";
              $result = mysqli_query($conn, $query);

              while ($row = mysqli_fetch_assoc($result)) { ?>

                <tr>
                <td><?php echo date("F d, Y", strtotime($row['order_date'])); ?></td>
                  <td><?php echo $row['invoice_number'] ?></td>
                  <td><?php echo $row['customer_name'] ?></td>
                  <td><?php echo number_format($row['subtotal'], 2) ?></td>
                  <td><?php echo number_format($row['change_amount'], 2) ?></td>
                  <td><?php echo number_format($row['total_payment'], 2) ?></td>

                </tr>
              <?php  }

              ?>
            </tbody>
          </table>

        </div>
      </div>
    </div>

  </div>

  <!-- /.card -->
</div>
</div>