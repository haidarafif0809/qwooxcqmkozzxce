<?php include 'session_login.php';

include 'header.php';
include 'navbar.php';
include 'db.php';
include_once 'sanitasi.php';

$id = angkadoang($_GET['id']);

$cek = $db->query("SELECT * FROM perujuk WHERE id = '$id' ");
$data = mysqli_fetch_array($cek);


 ?>

<div class="container">
<h3><b>EDIT DATA PERUJUK </b></h3> <hr>

<form role="form" action="update_perujuk.php" method="POST">

<div class="form-group">
  <label for="sel1">Nama </label>
  <input type="text" class="form-control" required="" id="nama" name="nama" value="<?php echo $data['nama']; ?>">
</div>

<div class="form-group">
  <label for="sel1">Alamat</label>
  <input type="text" class="form-control" required="" id="alamat" name="alamat" value="<?php echo $data['alamat']; ?>">
</div>

<div class="form-group">
  <label for="sel1">No Telp</label>
  <input type="text" class="form-control" required="" id="no_telp" name="no_telp" value="<?php echo $data['no_telp']; ?>">
</div>

<!--  open hidden  -->
<input type="hidden" id="id" name="id" value="<?php echo $data['id']; ?>">
<!--  closed hidden  -->

<button type="submit" class="btn btn-info"><i class='fa fa-save'></i> Simpan</button>

</form>
</div> <!--  closed container  -->

<!--  footer  -->
<?php 
include'footer.php';
?>
<!--  closed footer  -->