<?php
	session_start();
	include('koneksidb.php');
	if (isset($_POST['login']))
	{
		$username = addslashes($_POST['username']);
		$password = md5($_POST['password']);
		$sql = "select * from tb_admin where username='$username' and password = '$password'";
		$data = mysqli_query($koneksi,$sql) or die($sql);
		if (mysqli_num_rows($data) > 0)
		{
			$row = mysqli_fetch_assoc($data);
			$_SESSION['username'] = $row['username'];
			$_SESSION['nama_user'] = $row['nama_user'];
			$_SESSION['password'] = $_POST['password'];
			$_SESSION['status'] = $row['status'];
			header('location:index.php');
			exit;
		}
	}
?>
<!DOCTYPE html>
<html lang="en">
<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link rel="icon" type="image/x-icon" href="img/logo.png" />
    <meta name="description" content="">
    <meta name="author" content="">

    <title>Digital Signature</title>

    <!-- Custom fonts for this template-->
    <link href="vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
    <link
        href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i"
        rel="stylesheet">

    <!-- Custom styles for this template-->
    <link href="css/sb-admin-2.min.css" rel="stylesheet">

</head>

<body class="bg-gradient-primary">

    <div class="container">

        <!-- Outer Row -->
        <div class="row justify-content-center">

            <div class="col-xl-10 col-lg-12 col-md-9">

                <div class="card o-hidden border-0 shadow-lg my-5">
                    <div class="card-body p-0">
                        <!-- Nested Row within Card Body -->
                        <div class="row">
                            <div class="col-lg-6 d-none d-lg-block "><img src="img/logo.gif" width="100%"></div>
                            <div class="col-lg-6">
                                <div class="p-3">
                                    <div class="text-center">
                                        <h1 class="h4 text-gray-900 mb-4"><b>Digital Signature Information System (D-SIS)</b></h1>
                                    </div>
									<br>
                                    <form class="user" action="login.php" method="post">
                                        <div class="form-group">
                                            <input type="text" name="username" class="form-control form-control-user"  placeholder="masukkan username....." autofocus>
                                        </div>
                                        <div class="form-group">
                                            <input type="password" name="password" class="form-control form-control-user" placeholder="Password">
                                        </div>
										<input type="submit" name="login" class="btn btn-primary btn-user btn-block" value="Login">
                                        <br><br><br><br><br>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Bootstrap core JavaScript-->
    <script src="vendor/jquery/jquery.min.js"></script>
    <script src="vendor/bootstrap/js/bootstrap.bundle.min.js"></script>

    <!-- Core plugin JavaScript-->
    <script src="vendor/jquery-easing/jquery.easing.min.js"></script>

    <!-- Custom scripts for all pages-->
    <script src="js/sb-admin-2.min.js"></script>

</body>

</html>