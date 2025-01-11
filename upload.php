<?php 
	if(isset($_POST['upload']))
	{
		if ($_FILES['foto']['name']!="")
		{
			$no_surat = $_POST['no_surat'];
			$ext = pathinfo($_FILES['foto']['name'], PATHINFO_EXTENSION);
			$foto = $_FILES['foto'];
			if (isset($_GET['idm']))
			{
				move_uploaded_file($foto['tmp_name'],"surat_io/m".$no_surat.".".$ext);
				$sql = "update tb_masuk set foto = 'm$no_surat.$ext' where no_surat='$no_surat'";
			}else {
				move_uploaded_file($foto['tmp_name'],"surat_io/k".$no_surat.".".$ext);
				$sql = "update tb_keluar set foto = 'k$no_surat.$ext' where no_surat='$no_surat'";
			}
			mysqli_query($koneksi,$sql);
		}
		if (isset($_GET['idm']))
		{?>
			<script> window.location.assign("index.php?pages=l_masuk");</script>
<?php	
		}else
		{?>
			<script> window.location.assign("index.php?pages=l_keluar");</script>
<?php	
		exit;
		}
	}
	if (isset($_GET['idm']))
	{
		$id_surat = $_GET['idm'];
		$sql = "select * from tb_masuk where id_surat = '$id_surat'";
	}
	else if (isset($_GET['idk']))
	{
		$id_surat = $_GET['idk'];
		$sql = "select * from tb_keluar where id_surat = '$id_surat'";
	}
	$row = mysqli_fetch_assoc(mysqli_query($koneksi,$sql));
	$no_surat = $row['no_surat'];
	$namafile = $row['foto'];
?>
<style>
	.preview {
		max-width: 400px;
		max-height: 400px;
	}
</style>
<script>
	function previewImage(event) {
		var reader = new FileReader();
		reader.onload = function() {
			var output = document.getElementById('preview');
			output.src = reader.result;
		};
		reader.readAsDataURL(event.target.files[0]);
	}
</script>
<div class="card shadow mb-4">
	<div
		class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
		<h6 class="m-0 font-weight-bold text-primary">Upload Surat</h6>
	</div>
	<div class="card-body">
<?php 
	if ($namafile<>"" and isImageFile($namafile))
	{?>	
        <img src="surat_io/<?php echo $namafile;?>" width="120px">
<?php	
	}
	else if ($namafile<>'')
	{?>
        <img src="surat_io/pdf.jpg" width="120px"><br>
		<?php echo $namafile;?>
<?php
	}
	if (isset($_GET['idm']))
	{?>
        <form action="index.php?pages=upload&idm=<?php echo $id_surat;?>" method="post" enctype="multipart/form-data">
			<input type="hidden" name="jenis" value="masuk">
<?php
	}else{?>		
        <form action="index.php?pages=upload&idk=<?php echo $id_surat;?>" method="post" enctype="multipart/form-data">
			<input type="hidden" name="jenis" value="keluar">
<?php
	}?>
            <input type="file" name="foto" accept="image/jpeg,image/gif,image/png,application/pdf,image/x-eps" onchange="previewImage(event)" >
            <input type="hidden" name="no_surat" value="<?php echo $no_surat;?>">
            <br>
			<img id="preview" class="preview" src="#" >
            <br>
            <input type="submit" value="Upload" name="upload">
        </form>
	</div>
</div>
<?php
function isImageFile($file) {
    $info = pathinfo($file);
    return in_array(strtolower($info['extension']), 
                    array("jpg", "jpeg", "gif", "png", "bmp"));
}?>