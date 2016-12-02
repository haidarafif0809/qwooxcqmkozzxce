<?php 
include 'db.php';
include 'sanitasi.php';

$kelompok = angkadoang($_POST['kelompok']);

 ?>

<div class="form-group">
  <label for="sel1">Nama Pemeriksaan</label>
  <select class="form-control" id="pemeriksaan" name="pemeriksaan" required="">  
  <?php 
  $query2 = $db->query("SELECT nama FROM jasa_lab WHERE bidang = '$kelompok' ");
while ( $data2 = mysqli_fetch_array($query2))
 {
  echo "<option value='".$data2['nama']."'>".$data2['nama']."</option>";
}
?>
  </select>
</div>