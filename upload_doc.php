<?php 
	if(isset($_POST['upload']))
	{
		if ($_FILES['dokumen']['name']!="")
		{
			$id_surat = $_POST['id_surat'];
//			$ext = pathinfo($_FILES['dokumen']['name'], PATHINFO_EXTENSION);
			$foto = $_FILES['dokumen'];
			move_uploaded_file($foto['tmp_name'],"dokumen/".md5($id_surat).".pdf");
		}?>
    	<script> window.location.assign("index.php?pages=cq");</script>
<?php	
		exit;
	}
	if (isset($_GET['id']))
	{
		$id_surat = kodeacak('balik',$_GET['id']);
		$sql = "select * from tb_surat where id_surat = '$id_surat'";
    	$row = mysqli_fetch_assoc(mysqli_query($koneksi,$sql));
    	$no_surat = $row['no_surat'];
    	$namafile = substr($row['file_qr'],0,32).".pdf";
	}
?>
<div class="card shadow mb-4">
	<div
		class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
		<h6 class="m-0 font-weight-bold text-primary">Upload Surat</h6>
	</div>
	<div class="card-body">
<?php 
	if ($namafile <>'' and file_exists("dokumen/".$namafile))
	{?>
        <img src="dokumen/pdf.png" width="120px"><br> 
		<?php echo $namafile;?>
<?php
	}?>	
        <form action="upload_doc.php" method="post" enctype="multipart/form-data">
            <input type="file" name="dokumen" accept=".pdf" >
            <input type="hidden" name="id_surat" value="<?php echo $id_surat;?>">
            <br>
            <input type="submit" value="Upload" name="upload">
        </form>
	</div>
</div>
