<?php
	$sql= "select * from tb_instansi";
	$row = mysqli_fetch_assoc(mysqli_query($koneksi,$sql));
	if (isset($row))
	{
		$nama_instansi	= $row['nama_instansi'];
		$alamat 		= $row['alamat'];
		$kab_kota 		= $row['kab_kota'];
		$propinsi 		= $row['propinsi'];
		$telepon 		= $row['telepon'];
		$email 			= $row['email'];
		$website 		= $row['website'];
		$kodepos 		= $row['kodepos'];
		$logo_usaha 	= $row['logo_usaha'];
	}
	else
	{
		$nama_instansi	= '';
		$alamat			= '';
		$kab_kota		= '';
		$propinsi		= '';
		$telepon		= '';
		$email			= '';
		$website		= '';
		$kodepos		= '';
		$logo_usaha		= '';
	}	
	if (isset($_POST['simpan']))
	{
		if ($_FILES['fotouser']['name']!="")
		{
			$foto = $_FILES['fotouser'];
			move_uploaded_file($foto['tmp_name'],'logo.jpg');
		}

		$sql = "Select * from tb_instansi";
		$row = mysqli_num_rows(mysqli_query($koneksi,$sql));
		if ($row==0)
		{
			$sql = "insert into tb_instansi set nama_instansi 	= '$_POST[nama_instansi]',
												alamat 			= '$_POST[alamat]',
												kab_kota 		= '$_POST[kab_kota]',
												propinsi 		= '$_POST[propinsi]',
												telepon			= '$_POST[telepon]',
												email			= '$_POST[email]',
												website			= '$_POST[website]',
												kodepos			= '$_POST[kodepos]',
												logo_usaha		= 'logo.jpg'";
		}
		else
		{
			$row = mysqli_fetch_assoc(mysqli_query($koneksi,$sql));
			$id_instansi = $row['id_instansi'];
			$sql = "update tb_instansi set nama_instansi 	= '$_POST[nama_instansi]',
											alamat 			= '$_POST[alamat]',
											kab_kota 		= '$_POST[kab_kota]',
											propinsi 		= '$_POST[propinsi]',
											telepon			= '$_POST[telepon]',
											email			= '$_POST[email]',
											website			= '$_POST[website]',
											kodepos			= '$_POST[kodepos]',
											logo_usaha		= 'logo.jpg'
			where id_instansi = '$id_instansi'";
		}
		mysqli_query($koneksi,$sql) or die ($sql);
		$sql= "select * from tb_instansi";
		$row = mysqli_fetch_assoc(mysqli_query($koneksi,$sql));
		if (isset($row))
		{
			$nama_instansi	= $row['nama_instansi'];
			$alamat 		= $row['alamat'];
			$kab_kota 		= $row['kab_kota'];
			$propinsi 		= $row['propinsi'];
			$telepon 		= $row['telepon'];
			$email 			= $row['email'];
			$website 		= $row['website'];
			$kodepos 		= $row['kodepos'];
			$logo_usaha 	= $row['logo_usaha'];
		}
	}?>
<style>
	.preview {
		max-width: 200px;
		max-height: 200px;
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
		<h6 class="m-0 font-weight-bold text-primary">Enter Organization Data</h6>
	</div>	
	<div class="card-body">
		<form action="index.php?pages=or" method="POST" enctype="multipart/form-data">
			<table width="100%">
				<tr>
					<td width="200px">Organization Data</td>
					<td colspan="3"><input name="nama_instansi" size="50" maxlength="100" type="text" value="<?php echo $nama_instansi;?>" autofocus></td>
				</tr>
				<tr>
					<td width="200px">Organization Address</td>
					<td colspan="3"><input name="alamat" size="75" maxlength="200" type="text" value="<?php echo $alamat;?>"></td>
				</tr>
				<tr>
					<td width="200px">Regency/City</td>
					<td colspan="3"><input name="kab_kota" size="50" maxlength="50" type="text" value="<?php echo $kab_kota;?>"></td>
				</tr>
				<tr>
					<td width="200px">Province</td>
					<td colspan="3"><input name="propinsi" size="50" maxlength="50" type="text" value="<?php echo $propinsi;?>"></td>
				</tr>
				<tr>
					<td width="200px">Phone number</td>
					<td colspan="3"><input name="telepon" size="50" maxlength="50" type="text" value="<?php echo $telepon;?>"></td>
				</tr>
				<tr>
					<td width="200px">Email Address</td>
					<td colspan="3"><input name="email" size="100" maxlength="100" type="text" value="<?php echo $email;?>"></td>
				</tr>
				<tr>
					<td width="200px">Website</td>
					<td colspan="3"><input name="website" size="100" maxlength="100" type="text" value="<?php echo $website;?>"></td>
				</tr>
				<tr>
					<td width="200px">Postal code</td>
					<td colspan="3"><input name="kodepos" size="5" maxlength="5" type="text" value="<?php echo $kodepos;?>"></td>
				</tr>
				<tr>
					<td width="200px">Organization Logo</td>
					<td colspan="3"><input type="file" name="fotouser" accept="image/*" onchange="previewImage(event)"></td>
				</tr>
				<tr valign="top">
					<td width="200px">&nbsp;</td>
					<td width="250px">Foto tersimpan : <br>
						<img src="<?php echo $logo_usaha;?>" width="200px">
					</td>
					<td>
					    Foto Baru : <br>
						<img id="preview" class="preview" src="#">
					</td>
				</tr>
			</table>
			<button type="submit" name="simpan" class="btn btn-primary btn-icon-split">
				<span class="icon text-white-50">
					<i class="fas fa-compact-disc"></i>
				</span>
				<span class="text">Save</span>
			</button>
		</form>
	</div>
</div>
