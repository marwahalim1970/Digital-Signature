<?php
	$id_pejabat 	= "";
	$nama			= '';
	$jabatan 		= '';
	$tanda_tangan 	= '';
	if (isset($_GET['del']))
	{
		$sql = "delete from tb_pejabat where id_pejabat = '$_GET[id]'";
		$row = mysqli_query($koneksi,$sql);
		$nama			= '';
		$jabatan		= '';
		$tanda_tangan	= '';
	}
	if (isset($_GET['edit']))
	{
		$sql = "select * from tb_pejabat where id_pejabat = '$_GET[id]'";
		$row = mysqli_fetch_assoc(mysqli_query($koneksi,$sql));
		$edit = true;
		$id_pejabat		= $row['id_pejabat'];
		$nama			= $row['nama'];
		$jabatan		= $row['jabatan'];
		$tanda_tangan	= $row['tanda_tangan'];
	}
	if (isset($_POST['update']))
	{
		$nama 			= $_POST['nama'];
		$jabatan 		= $_POST['jabatan'];
		$tanda_tangan 	= "$nama-$jabatan.jpg";
		$id_pejabat 	= $_POST['id_pejabat'];
		if ($_FILES['fotouser']['name']!="")
		{
			$foto = $_FILES['fotouser'];
			move_uploaded_file($foto['tmp_name'],'dokumen/'.$tanda_tangan);
		}
		$sql = "update tb_pejabat set nama 			= '$nama',
									  jabatan 		= '$jabatan',
									  tanda_tangan	= '$tanda_tangan' 
				where id_pejabat = '$id_pejabat'";
		mysqli_query($koneksi,$sql);
		$nama 			= '';
		$jabatan 		= '';
		$tanda_tangan 	= '';
		$id_pejabat 	= 0;
		
	}
	if (isset($_POST['simpan']))
	{
		$nama 			= $_POST['nama'];
		$jabatan 		= $_POST['jabatan'];
		$tanda_tangan 	= "$nama-$jabatan.jpg";
		$id_pejabat 	= $_POST['id_pejabat'];
		if ($_FILES['fotouser']['name']!="")
		{
			$foto = $_FILES['fotouser'];
			move_uploaded_file($foto['tmp_name'],'dokumen/'.$tanda_tangan);
		}
		$sql = "insert into tb_pejabat set nama 		= '$nama',
										   jabatan 		= '$jabatan',
										   tanda_tangan	= '$tanda_tangan'";
		mysqli_query($koneksi,$sql);
		$nama 			= '';
		$jabatan 		= '';
		$tanda_tangan 	= '';
		$id_pejabat 	= '';
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
		<h6 class="m-0 font-weight-bold text-primary">Enter Officer Data</h6>
	</div>	
	<div class="card-body">
		<form action="index.php?pages=so" method="POST" enctype="multipart/form-data">
			<input type="hidden" name="id_pejabat" value="<?php echo $id_pejabat;?>">
			<table width="100%">
				<tr>
					<td width="200px">Name of Official</td>
					<td colspan="3"><input name="nama" size="50" maxlength="100" type="text" value="<?php echo $nama;?>" autofocus></td>
				</tr>
				<tr>
					<td width="200px">Position in the Organization</td>
					<td colspan="3"><input name="jabatan" size="75" maxlength="200" type="text" value="<?php echo $jabatan;?>"></td>
				</tr>
				<tr>
					<td width="200px">Signature</td>
					<td colspan="3"><input type="file" name="fotouser" accept="image/*" onchange="previewImage(event)"></td>
				</tr>
				<tr valign="top">
					<td width="200px">&nbsp;</td>
					<td width="250px">Foto tersimpan : <br>
						<img src="dokumen/<?php echo $tanda_tangan;?>" width="200px">
					</td>
					<td>
					    Foto Baru : <br>
						<img id="preview" class="preview" src="#" alt="Preview Image">
					</td>
				</tr>
			</table>
<?php	
			if (!isset($_GET['edit']))
			{?>
				<button type="submit" name="simpan" class="btn btn-primary btn-icon-split">
					<span class="icon text-white-50">
						<i class="fas fa-compact-disc"></i>
					</span>
					<span class="text">Save</span>
				</button>
<?php
			}
			else
			{?>
				<button type="submit" name="update" class="btn btn-primary btn-icon-split">
					<span class="icon text-white-50">
						<i class="fas fa-compact-disc"></i>
					</span>
					<span class="text">Update</span>
				</button>
<?php
			}?>		
		</form>
	</div>
</div>
<div class="card shadow mb-4">
	<div
		class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
		<h6 class="m-0 font-weight-bold text-primary">List Officer Data</h6>
		
	</div>
	<div class="card-body">
		<div class="table-responsive">
			<table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
				<thead>
					<tr>
						<th>No</th>
						<th>Name</th>
						<th>Position</th>
						<th>Signature</th>
						<th>Action</th>
					</tr>
				</thead>
				<tbody>
<?php
				$sql = "select * from tb_pejabat order by nama";
				$data = mysqli_query($koneksi,$sql);
				$i=1;
				while ($row = mysqli_fetch_assoc($data))
				{?>
					<tr>
						<td><?php echo $i;?></td>
						<td><?php echo $row['nama'];?></td>
						<td><?php echo $row['jabatan'];?></td>
						<td><img src="dokumen/<?php echo $row['tanda_tangan'];?>" width="100px" ></td>
						<td align="center"><a href="index.php?pages=so&edit=&<?php echo "id=$row[id_pejabat]";?>" class="btn btn-success btn-circle btn-sm" title="Edit Officer Data">
								<i class="fas fa-edit"></i>
							</a>
<?php
			if ($_SESSION['status']=="BAAK" or $_SESSION['status']=="Admin")
			{?>
							<a href="index.php?pages=so&del=&<?php echo "id=$row[id_pejabat]";?>" class="btn btn-success btn-circle btn-sm" title="Delete Officer Data" onclick="return confirm('The Officer Data data will be deleted from the database.?');">
								<i class="fas fa-trash"></i>
							</a>
<?php
			}?>
					</tr>
<?php
					$i++;
				}?>
				</tbody>
			</table>
		</div>
	</div>
</div>
