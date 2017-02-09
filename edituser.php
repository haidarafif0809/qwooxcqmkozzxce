<?php include 'session_login.php';


// memasukan file session login, db,header dan navbar.php
 include 'db.php';
 include 'header.php';
 include 'navbar.php';

// mengirim data $id menggunakan metode GET
 $id = $_GET['id'];
 
 // menampilkan seluruh data dari tabel user berdasarkan id
 $query = $db->query("SELECT u.username, u.nama, u.alamat, u.jabatan, u.otoritas, u.tipe, u.status_sales, u.id, j.nama AS nama_jabatan FROM user u INNER JOIN jabatan j ON u.jabatan = j.id WHERE u.id = '$id'");
 
 // menyimpan data sementara yang ada pada $query
 $data = mysqli_fetch_array($query);
 ?>



<!-- membuat form prosesedit -->
<form action="prosesedit.php" method="post">

<!-- agar tampilan form terlihat rapih dalam satu tempat -->
<div class="container">

					<!--membuat form group-->
					<div class="form-group">
					<label>User name </label><br>
					<input type="text" name="username" value="<?php echo $data['username']; ?>" class="form-control" required="" autocomplete="off">
					</div>


					<div class="form-group">
					<label>Nama Lengkap </label><br>
					<input type="text" name="nama" value="<?php echo $data['nama']; ?>" class="form-control" required="" autocomplete="off">
					</div>

					<div class="form-group">
					<label>Alamat </label><br>

					<input value="<?php echo $data['alamat']; ?>" name="alamat" class="form-control" required=""autocomplete="off"></input>

					</div>


					<div class="form-group">
					<label>Jabatan </label><br>
					<select type="text" name="jabatan" class="form-control" required="" >
					<option value="<?php echo $data['jabatan']; ?>"><?php echo $data['nama_jabatan']; ?></option>

<?php 

	// memasukan file db.php
    include 'db.php';
    
    // menampilkan seluruh data yang ada di tabel satuan
    $query = $db->query("SELECT * FROM jabatan ");

    // menyimpan data sementara yang ada pada $query
    while($data002 = mysqli_fetch_array($query))
    {
    
    echo "<option value='".$data002['id']."'>".$data002['nama'] ."</option>";
    }
    
    
    ?>

    				</select>
					</div>
					

					<div class="form-group">
					<label>Otoritas</label><br>
					<select type="text" name="otoritas" id="otoritas" class="form-control" required="" >
					<option value="<?php echo $data['otoritas']; ?>"><?php echo $data['otoritas']; ?></option>
<?php 

$ambil_otoritas = $db->query("SELECT * FROM hak_otoritas");

    while($data_otoritas = mysqli_fetch_array($ambil_otoritas))
    {
    
    echo "<option>".$data_otoritas['nama'] ."</option>";

    }
    
//Untuk Memutuskan Koneksi Ke Database

mysqli_close($db); 
 ?>
					</select>
					</div>

					<div class="form-group">
					<label>Tipe User</label><br>
					<select type="text" name="tipe" id="tipe" class="form-control" required="" >

					<?php if ($data['tipe'] == '1'): ?>
					<option value="<?php echo $data['tipe']; ?>">Dokter</option>
					
					<?php elseif ($data['tipe'] == '2'): ?>
					<option value="<?php echo $data['tipe']; ?>">Paramedik</option>
				
					<?php elseif ($data['tipe'] == '3'): ?>
					<option value="<?php echo $data['tipe']; ?>">Farmasi</option>
					
					<?php elseif ($data['tipe'] == '4'): ?>
					<option value="<?php echo $data['tipe']; ?>">Admin</option>

					<?php elseif ($data['tipe'] == '5'): ?>
					<option value="<?php echo $data['tipe']; ?>">Lain - lain</option>
						
					<?php elseif ($data['tipe'] == '6'): ?>
					<option value="<?php echo $data['tipe']; ?>">Analis</option>
					
					<?php endif ?>
					
					<option value="4">Admin</option>
					<option value="1">Dokter</option>
					<option value="2" >Paramedik</option>
					<option value="3">Farmasi</option>
					<option value="5">Lain - lain</option>
					<option value="6">Analis</option>
					</select>
					</div>

					<div class="form-group">
					<label> Status </label><br>
					<select type="text" name="status" class="form-control" required="" >
					<option>aktif</option>
					<option>tidak aktif</option>
					</select>
					</div>

					<div class="form-group">
					<label> Status Sales</label><br>
					<select type="text" name="status_sales" id="status_sales" class="form-control" required="" >
					<option value="<?php echo $data['status_sales']; ?>"><?php echo $data['status_sales']; ?></option>
					<option value="Iya">Iya</option>
					<option value="Tidak">Tidak</option>
					</select>
					</div>


					<!-- memasukan data id namun disembunyikan -->
					<input type="hidden" name="id" value="<?php echo $id; ?>">

					<!-- membuat tombol submit -->
					<button type="submit" class="btn btn-info"><i class="fa fa-save"></i> Simpan</button>
</div> <!-- tag penutup div class container -->
</form> <!-- tag penutup form -->


<?php include 'footer.php'; ?>