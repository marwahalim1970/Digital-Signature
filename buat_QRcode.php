<?php
	$no_surat	= '';
	$kepada 	= '';
	$tanggal    = '0000-00-00';
	$hal_surat	= '';
	$id_pejabat = 0;
	$alamat_link= '';
	$file_qr	= '';
	$pesan = '';
	if (isset($_GET['del']))
	{
		$sql = "delete from tb_surat where id_surat = '$_GET[id]'";
		$row = mysqli_query($koneksi,$sql);
		$no_surat	= '';
		$kepada 	= '';
		$tanggal    = '0000-00-00';
		$hal_surat	= '';
		$id_pejabat = 0;
		$alamat_link= '';
		$file_qr	= '';
	}
	if (isset($_POST['simpan']) and $_POST['no_surat']<>"")
	{
		$no_surat = $_POST['no_surat'];
		$sql = "select * from tb_surat where no_surat = '$no_surat'";
		if (mysqli_num_rows(mysqli_query($koneksi,$sql)) > 0 )
		{
			$pesan = $pesan."This Document's Number is already taken, please check again... <br>";
		}
		if ($pesan == '')
		{
			$tanggal = $_POST['tanggal'];
			$hal_surat = $_POST['hal_surat'];
			$kepada = $_POST['kepada'];
			$sql = "insert into tb_surat set no_surat 	= '$no_surat',
											 tanggal 	= '$tanggal',
											 hal_surat	= '$hal_surat',
											 id_pejabat	= '$_POST[id_pejabat]',
											 kepada		= '$_POST[kepada]',
											 alamat_link= '$ip_add/d-sis/dokumen/index.php?id=$no_surat',
											 file_qr = '$no_surat.png'";
			mysqli_query($koneksi,$sql);
			$sql = "select id_surat as kodeQR from tb_surat order by id_surat Desc";
			$row = mysqli_fetch_array(mysqli_query($koneksi,$sql));
			$kode = md5($row['kodeQR']);
			$sql = "update tb_surat set alamat_link= '$ip_add/d-sis/dokumen/index.php?id=$kode',
										file_qr = '$kode.png' where id_surat = '$row[kodeQR]'";
			mysqli_query($koneksi,$sql); 
			include 'phpqrcode/qrlib.php';
			$no_surat = $_POST['no_surat'];
			$hal_surat = $_POST['hal_surat'];
			$tanggal = $_POST['tanggal'];
			$kepada = $_POST['kepada'];
			$id_pejabat = $_POST['id_pejabat'];
			$row = mysqli_fetch_assoc(mysqli_query($koneksi,"select * from tb_pejabat where id_pejabat='$id_pejabat'"));
			$nama_pejabat = $row['nama'];
			$content = "$no_surat \n$hal_surat \n$tanggal \n$kepada \n$nama_pejabat \n$ip_add/d-sis/dokumen/index.php?id=$kode"; // Isi QR Code
			$outputPath = "dokumen/$kode.png"; // Output file
			$logoPath = 'logo.png'; // Path logo perusahaan
			generateQRCodeWithLogo($content, $outputPath, $logoPath);
			$no_surat	= '';
			$kepada 	= '';
			$tanggal    = '0000-00-00';
			$hal_surat	= '';
			$id_pejabat = 0;
			$alamat_link= '';
			$file_qr	= '';
		}
		else {
			$no_surat	= $_POST['no_surat'];
			$kepada 	= $_POST['kepada'];
			$tanggal    = $_POST['tanggal'];
			$hal_surat	= $_POST['hal_surat'];
			$id_pejabat = $_POST['id_pejabat'];
		}
	}	
	?>
<div class="card shadow mb-4">
	<div
		class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
		<h6 class="m-0 font-weight-bold text-primary">Create QR Code Document's</h6>
	</div>
<?php
	if ($pesan<>'')
	{?>
		<div class="card border-left-danger">
			<div class="card-body" style="color:#ff0000;font-weight:bold;">
				<?php echo $pesan;?>
			</div>
		</div>
<?php
	}?>		
	<div class="card-body">
		<form action="index.php?pages=cq" method="post">
			<table width="100%">
				<tr>
					<td width="75px">Document Number</td>
					<td><input name="no_surat" class="form-control form-control-user" maxlength="50" type="text" placeholder="Document number" value="<?php echo $no_surat;?>" <?php if (isset($edit)) echo "readonly";?> autofocus></td>
				</tr>
				<tr>
					<td width="75px">Date</td>
					<td><input name="tanggal" class="form-control form-control-user" type="date"  value="<?php echo $tanggal;?>"></td>
				</tr>
				<tr>
					<td width="75px">Subject</td>
					<td><input name="hal_surat" class="form-control form-control-user" maxlength="200" type="text" placeholder="Subject" value="<?php echo $hal_surat;?>"></td>
				</tr>
				<tr>
					<td width="75px">To</td>
					<td><input name="kepada" class="form-control form-control-user" maxlength="100" type="text" placeholder="To" value="<?php echo $kepada;?>"></td>
				</tr>
				<tr>
					<td width="75px">Name of Official</td>
					<td><select name="id_pejabat" id="id_pejabat" class="form-control form-control-user" >
<?php
							$sql_pejabat = "select * from tb_pejabat order by nama";
							$data = mysqli_query($koneksi,$sql_pejabat);
							while ($row = mysqli_fetch_assoc($data))
							{?>
								<option value="<?php echo $row['id_pejabat'];?>" ><?php echo $row['nama'];?></option>
				<?php
							}?>
						</select>
					</td>
				</tr>
				
			</table>
<?php 
			if (isset($edit)) 
			{?>
				<button type="submit" name="update" class="btn btn-primary btn-icon-split">
					<span class="icon text-white-50">
						<i class="fas fa-compact-disc"></i>
					</span>
					<span class="text">Update</span>
				</button>
<?php
			}
			else
			{?>
				<button type="submit" name="simpan" class="btn btn-primary btn-icon-split">
					<span class="icon text-white-50">
						<i class="fas fa-compact-disc"></i>
					</span>
					<span class="text">Create QR Code</span>
				</button>
<?php				
			}?>
		</form>
	</div>
</div>

<div class="card shadow mb-4">
	<div
		class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
		<h6 class="m-0 font-weight-bold text-primary">List QR Code Document's</h6>
		
	</div>
	<div class="card-body">
		<div class="table-responsive">
			<table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
				<thead>
					<tr>
						<th>No</th>
						<th>Doc. Number</th>
						<th>Date</th>
						<th>Subject</th>
						<th>Name of Official</th>
						<th>Document</th>
						<th>QR Code</th>
						<th>Action</th>
					</tr>
				</thead>
				<tbody>
<?php
				$sql = "select a.*,b.nama from tb_surat a 
						left join tb_pejabat b on a.id_pejabat = b.id_pejabat 
						order by a.id_surat DESC";
				$data = mysqli_query($koneksi,$sql);
				$i=1;
				while ($row = mysqli_fetch_assoc($data))
				{?>
					<tr>
						<td><?php echo $i;?></td>
						<td><?php echo $row['no_surat'];?></td>
						<td><?php echo date_format(date_create($row['tanggal']),"d-M-Y");?></td>
						<td><?php echo $row['hal_surat'];?></td>
						<td><?php echo $row['nama'];?></td>
						<td align="center"><?php
						        $file_doc = substr($row['file_qr'],0,32).".pdf";
						        if (file_exists('dokumen/'.$file_doc))
						        {?>
        						    <a href="dokumen/<?php echo $file_doc;?>" target="_blank"><img src="dokumen/pdf.png" width="50px"></a>
        				<?php
						        }?>
        			    </td>
						<td align="center"><a href="dokumen/<?php echo $row['file_qr'];?>" target="_blank"><img src="dokumen/<?php echo $row['file_qr'];?>" width="50px"></a></td>
						<td align="center">
						    <a href="index.php?pages=ud&<?php echo "id=".kodeacak('acak',$row['id_surat']);?>" class="btn btn-success btn-circle btn-sm" title="Upload Documents">
								<i class="fas fa-spinner fa-spin"></i></a>
<?php
						if ($_SESSION['status']=="BAAK" or $_SESSION['status']=="Admin")
						{?>
							<a href="index.php?pages=cq&del=&<?php echo "id=$row[id_surat]";?>" class="btn btn-success btn-circle btn-sm" title="Remove QR Code Signature" onclick="return confirm('The QR Code data will be deleted from the database.?');">
								<i class="fas fa-shopping-basket fa-spin"></i>
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
<?php
function generateQRCodeWithLogo($content, $outputPath, $logoPath) {
    // Temporary path untuk QR Code tanpa logo
    $qrTempPath = 'temp_qrcode.png';

    // Ukuran dan Error Correction Level QR Code
    $size = 10; // Ukuran QR Code
    $level = 'H'; // High error correction agar bisa menampung logo

    // Generate QR Code sementara
    QRcode::png($content, $qrTempPath, $level, $size, 2);

    // Muat gambar QR Code dan Logo
    $qrImage = imagecreatefrompng($qrTempPath);
    $logoImage = imagecreatefrompng($logoPath);

    // Dapatkan ukuran gambar
    $qrWidth = imagesx($qrImage);
    $qrHeight = imagesy($qrImage);
    $logoWidth = imagesx($logoImage);
    $logoHeight = imagesy($logoImage);

    // Tentukan ukuran logo (30% dari QR Code)
    $logoNewWidth = $qrWidth * 0.3;
    $logoNewHeight = $logoHeight * ($logoNewWidth / $logoWidth);

    // Hitung posisi untuk menempatkan logo di tengah
    $xPos = ($qrWidth - $logoNewWidth) / 2;
    $yPos = ($qrHeight - $logoNewHeight) / 2;

    // Gabungkan logo ke QR Code
    imagecopyresampled($qrImage, $logoImage, $xPos, $yPos, 0, 0, $logoNewWidth, $logoNewHeight, $logoWidth, $logoHeight);

    // Simpan QR Code dengan logo
    imagepng($qrImage, $outputPath);

    // Hapus file sementara
    unlink($qrTempPath);

    // Bersihkan memory
    imagedestroy($qrImage);
    imagedestroy($logoImage);
}
?>
