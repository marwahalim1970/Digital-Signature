<?php
	include ('../koneksidb.php');
	if (isset($_GET['id']))
	{
		$sql = "SELECT * FROM `tb_instansi`";
    	$row = mysqli_fetch_assoc(mysqli_query($koneksi,$sql));
		$nama_ins = $row['nama_instansi'];
    	$id = $_GET['id'];
    	$sql = "select * from tb_surat a
    	        left join tb_pejabat b on a.id_pejabat = b.id_pejabat 
    	        where a.file_qr = '$id.png'";
    	if (mysqli_num_rows(mysqli_query($koneksi,$sql))==0)
    	{
    	    $pesan = "This QR code is not registered in the STMIK Methodist Binjai system";
    	}
    	else
    	{
    	    $pesan="";
        	$row = mysqli_fetch_assoc(mysqli_query($koneksi,$sql));
        	$no_surat = $row['no_surat'];
        	$tanggal = $row['tanggal'];
        	$kepada = $row['kepada'];
        	$nama_pejabat = $row['nama'];
        	$hal_surat = $row['hal_surat'];
    	}
	}
	else
	{
	    $pesan = "This QR code is not registered in the STMIK Methodist Binjai system";
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

    <title>Digital Signature</title>
    <!-- Favicon -->
    <link rel="icon" type="image/x-icon" href="../img/logo.png" />

    <!-- Custom fonts for this template-->
    <link href="../vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
    <link
        href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i"
        rel="stylesheet">

    <!-- Custom styles for this template-->
    <link href="../css/sb-admin-2.min.css" rel="stylesheet">
    <link href="../vendor/datatables/dataTables.bootstrap4.min.css" rel="stylesheet">
	<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />

</head>

<body id="page-top">
    <div id="wrapper">
        <div id="content-wrapper" class="d-flex flex-column">
            <!-- Main Content -->
            <div id="content">
				<div class="card shadow mb-4">
					<div class="card-header align-items-center">
						<h1 class="h5 mb-1 text-gray-900">Digital Signature</h1></br>
						<h1 class="h6 mb-1 text-gray-900"><?php echo $nama_ins;?></h1>
					</div>
				</div>
                <div class="container-fluid">
                    <div class="row">
                        <div class="col-xl-12 col-lg-12">
<?php
                    if ($pesan=='')
                    {?>
                        <!-- Area Chart -->
						<table width="100%" cellpadding=0 cellspacing=0>
							<tr>
								<td width="110px">Doc. Number</td>
								<td><?php echo $no_surat;?></td>
							</tr>
							<tr>
								<td>Doc. Date</td>
								<td><?php echo $tanggal;?></td>
							</tr>
							<tr>
								<td>Subject</td>
								<td><?php echo $hal_surat;?></td>
							</tr>
							<tr>
								<td>Signed by</td>
								<td><?php echo $nama_pejabat;?></td>
							</tr>
							<tr>
								<td>To</td>
								<td><?php echo $kepada;?></td>
							</tr>
						</table>
<?php
                        }
                        else
                        {?>
                            <div class="card border-left-danger">
                    			<div class="card-body" style="color:#ff0000;font-weight:bold;">
                    				<?php echo $pesan;?>
                    			</div>
                    		</div>
<?php
                        }?>
                        </div>
                    </div>
                </div>
                <!-- /.container-fluid -->
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

    <!-- Page level plugins -->
    <script src="vendor/chart.js/Chart.min.js"></script>
    <script src="vendor/datatables/jquery.dataTables.min.js"></script>
    <script src="vendor/datatables/dataTables.bootstrap4.min.js"></script>

    <!-- Page level custom scripts -->
    <script src="js/demo/chart-area-demo.js"></script>
    <script src="js/demo/chart-pie-demo.js"></script>
    <script src="js/demo/datatables-demo.js"></script>
	<script src="https://code.jquery.com/jquery-3.4.1.js"></script>
	<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

</body>

</html>
