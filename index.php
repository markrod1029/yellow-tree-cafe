<?php
session_start();
if (isset($_SESSION['admin'])) {
    header('location:admin/index.php');
}

if (isset($_SESSION['staff'])) {
    header('location:staff/index.php');
}

?>
<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>Yellow Tree Cafe Sales and Inventory management system</title>

    <!-- Custom fonts for this template-->
    <link href="plugin/vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
    <link
        href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i"
        rel="stylesheet">

    <!-- Custom styles for this template-->
    <link href="plugin/css/sb-admin-2.min.css" rel="stylesheet">

</head>

<body class="bg-gradient-default  d-flex align-items-center justify-content-center vh-100">
    <div class="container">
        <!-- Outer Row -->
        <div class="row justify-content-center">
            <div class="col-xl-10 col-lg-12 col-md-9">
                <div class="card o-hidden border-0 shadow-lg my-5">
                    <div class="card-body p-0">
                        <!-- Nested Row within Card Body -->
                        <div class="row">
                            <!-- Image on Left -->
                            <div class="col-lg-6 d-flex align-items-center justify-content-center">
                                <img src="plugin/img/logo.jpg" alt="Login Image" class="img-fluid rounded">
                            </div>
                            <!-- Login Form on Right -->
                            <div class="col-lg-6 align-items-center justify-content-center">
                                <div class="p-5">
                                    <div class="text-center">
                                        <h1 class="h4 text-gray-900 mb-4">Welcome Back!</h1>
                                    </div>

                                    <?php
                                    if (isset($_SESSION['error'])) {
                                        echo "<div class='alert alert-danger text-center'>" . $_SESSION['error'] . "</div>";
                                        unset($_SESSION['error']); // Clear error after displaying
                                    }
                                    ?>
                                    <form class="user" action="app/action/login.php" method="POST">
                                        <div class="form-group">
                                            <input type="email" class="form-control form-control-user"
                                                id="exampleInputEmail" aria-describedby="emailHelp" name="email"
                                                placeholder="Enter Email Address...">
                                        </div>
                                        <div class="form-group">
                                            <input type="password" class="form-control form-control-user"
                                                id="exampleInputPassword" name="password" placeholder="Password">
                                        </div>
                                        <div class="form-group">

                                        </div>
                                        <button type="submit" name="login" class="btn btn-primary btn-user btn-block">
                                            Login
                                        </button>
                                    </form>
                                </div>
                            </div>
                        </div> <!-- End Row -->
                    </div>
                </div>
            </div>
        </div>
    </div>


    <script src="plugin/vendor/jquery/jquery.min.js"></script>
    <script src="plugin/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>

    <script src="plugin/vendor/jquery-easing/jquery.easing.min.js"></script>

    <script src="plugin/js/sb-admin-2.min.js"></script>

</body>

</html>