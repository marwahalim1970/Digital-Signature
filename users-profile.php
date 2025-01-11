<?php
	$username = $_SESSION['username'];
	$password = $_SESSION['password'];
	$passlama = md5($password);
	$pesan = '';
	if (isset($_POST['update']))
	{
		if (md5($_POST['old_pass']) <> $passlama)
		{
			$pesan = 'Password lama tidak seperti yang ada....';			
		}
		else if ($_POST['passbaru']=="")
		{
			$pesan = 'Password baru harus berisi kode yang sulit ditebak....';			
		}
		else if (strcmp($_POST['passbaru'], $_POST['passulang']) !== 0)
		{
			$pesan = 'Password baru harus mirip dengan password yang diulang....';
		}
		else
		{
			$passbaru = md5($_POST['passbaru']);
			$nama_user = $_POST['nama_user'];
			$id_user = $_POST['id_user'];
			$sql = "update tb_admin set password = '$passbaru', nama_user='$nama_user' where id_user = '$id_user'";
			mysqli_query($koneksi,$sql);
			echo "<script> window.location.href = 'logout.php'; </script>";
			exit;
		}
	}
	$sql = "select * from tb_admin where username='$username' and password = '$passlama'";
	$data = mysqli_query($koneksi,$sql) or die($sql);
	if (mysqli_num_rows($data) > 0)
	{
		$row = mysqli_fetch_assoc($data);
		$id_user = $row['id_user'];
		$nama_user = $row['nama_user'];
	}
	else
	{
		echo $sql;
		$pesan = 'Password lama tidak sama dengan yang tersimpan....';
	}
?>
<script>	
	$(document).ready(function(){
    $('#old_pass').attr('autocomplete','off');
    $('#passbaru').attr('autocomplete','off');
    $('#passulang').attr('autocomplete','off');
    });
</script>
<?php 
	if ($pesan<>"")
	{?>
		<div class="row">
			<div class="col-lg-12">
				<div class="border-left-danger bg-gradient-success text-gray-100">
					<br>
					<?php echo "<b>&nbsp;&nbsp;&nbsp;$pesan</b>";?>
					<br><br>
				</div>
			</div>
		</div>
<?php
	}?>	
<div class="row">
	<div class="col-lg-5">
		<div class="p-5">
			<div class="text-center">
				<h1 class="h4 text-gray-900 mb-4"><b>Profile Pemakai</b></h1>
			</div>
			<form class="user" action="index.php?pages=profile" method="post">
				User Name
				<div class="form-group">
					<input type="text" name="username" class="form-control form-control-user" value="<?php echo $_SESSION['username'];?>" readonly>
					<input type="hidden" name="id_user" value="<?php echo $id_user;?>">
				</div>
				Nama Pemakai
				<div class="form-group">
					<input type="text" name="nama_user" class="form-control form-control-user" value="<?php echo $_SESSION['nama_user'];?>">
				</div>
				Password Lama
				<div class="form-group">
					<input type="text" name="old_pass" id="old_pass" class="form-control form-control-user" >
				</div>
				<div class="form-group row">
					<div class="col-sm-6 mb-3 mb-sm-0">
						Password baru
						<input type="text" name="passbaru" id="passbaru" class="form-control form-control-user">
					</div>
					<div class="col-sm-6">
						Ulangi Password baru
						<input type="text" name="passulang" id="passulang" class="form-control form-control-user">
					</div>
				</div>
				<input type="submit" name="update" class="btn btn-primary btn-user btn-block" value="U P D A T E">
			</form>
		</div>
	</div>
</div>
