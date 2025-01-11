<?php
	$username='';
	$password='';
	$status='';
	$nama_user='';
	$pesan = '';
	if (isset($_GET['del']))
	{
		$sql = "delete from tb_admin where id_user = '$_GET[id]'";
		$row = mysqli_query($koneksi,$sql);
		$username	= '';
		$password	= '';
		$status		= '';
		$nama_user	= '';
	}
	if (isset($_GET['edit']))
	{
		$sql = "select * from tb_admin where id_user = '$_GET[id]'";
		$row = mysqli_fetch_assoc(mysqli_query($koneksi,$sql));
		$edit = true;
		$username	= $row['username'];
		$password	= $row['password'];
		$status		= $row['status'];
		$nama_user	= $row['nama_user'];
	}
	if (isset($_POST['simpan']))
	{
		$sql = "select * from tb_admin where username = '$username'";
		if (mysqli_num_rows(mysqli_query($koneksi,$sql)) > 0 )
		{
			$pesan = $pesan."This username is already taken, please check again... <br>";
		}
		if ($pesan == '')
		{
			$sql = "insert into tb_admin set username 	= '$_POST[username]',
											 password 	= '$_POST[password]',
											 status 	= '$_POST[status]',
											 nama_user  = '$_POST[nama_user]'";
			mysqli_query($koneksi,$sql) or die ($sql); 
			$username  = '';
			$password  = '';
			$status    = '';
			$nama_user = '';
		}
		else {
			$username	= $row['username'];
			$password	= $row['password'];
			$status		= $row['status'];
			$nama_user	= $row['nama_user'];
		}
	}
	if (isset($_POST['update']))
	{
		$password = md5($_POST['password']);
		$sql = "update tb_admin set password 	= '$password',
									status 		= '$_POST[status]',
									nama_user  	= '$_POST[nama_user]'
								where username 	= '$_POST[username]'";
		mysqli_query($koneksi,$sql) or die ($sql);
		$username  = '';
		$password  = '';
		$status    = '';
		$nama_user = '';
	}	
	?>
<div class="card shadow mb-4">
	<div
		class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
		<h6 class="m-0 font-weight-bold text-primary">Application User Data</h6>
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
		<form action="index.php?pages=au" method="post">
			<table width="100%">
				<tr>
					<td width="150px">User name</td>
					<td><input name="username" size="30" maxlength="30" type="text" placeholder="Username" value="<?php echo $username;?>" <?php if (isset($edit)) echo "readonly";?> autofocus></td>
				</tr>
				<tr>
					<td width="150px">Account Name</td>
					<td><input name="nama_user" size="50" maxlength="50" type="text" placeholder="Account Name" value="<?php echo $nama_user;?>"></td>
				</tr>
				<tr>
					<td width="150px">Password</td>
					<td><input name="password" size="30" maxlength="30" type="text" placeholder="Password" value="<?php echo $password;?>"></td>
				</tr>
				<tr>
					<td width="150px">Status</td>
					<td><select name="status">
							<option value="Admin" <?php if ($status=="Admin") echo "selected";?>>Admin</option>
							<option value="User" <?php if ($status=="User") echo "selected";?>>User</option>
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
					<span class="text">Save</span>
				</button>
<?php				
			}?>
		</form>
	</div>
</div>

<div class="card shadow mb-4">
	<div
		class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
		<h6 class="m-0 font-weight-bold text-primary">List User Data</h6>
		
	</div>
	<div class="card-body">
		<div class="table-responsive">
			<table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
				<thead>
					<tr>
						<th>Username</th>
						<th>Account Name</th>
						<th>Status</th>
						<th>Aksi</th>
					</tr>
				</thead>
				<tbody>
<?php
				$sql = "select * from tb_admin order by username";
				$data = mysqli_query($koneksi,$sql);
				while ($row = mysqli_fetch_assoc($data))
				{?>
					<tr>
						<td><?php echo $row['username'];?></td>
						<td><?php echo $row['nama_user'];?></td>
						<td><?php echo $row['status'];?></td>
						<td align="center"><a href="index.php?pages=au&edit=&<?php echo "id=$row[id_user]";?>" class="btn btn-success btn-circle btn-sm" title="Edit user account">
								<i class="fas fa-edit"></i>
							</a>
<?php
			if ($_SESSION['status']=="BAAK" or $_SESSION['status']=="Admin")
			{?>
							<a href="index.php?pages=au&del=&<?php echo "id=$row[id_user]";?>" class="btn btn-success btn-circle btn-sm" title="Delete user account" onclick="return confirm('The user's account data will be deleted from the database.?');">
								<i class="fas fa-trash"></i>
							</a>
<?php
			}?>
					</tr>
<?php
				}?>
				</tbody>
			</table>
		</div>
	</div>
</div>
