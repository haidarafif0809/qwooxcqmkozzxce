<?php 
include 'db.php';
include 'sanitasi.php';

$kelompok = angkadoang($_POST['kelompok']);
$pemeriksaan = angkadoang($_POST['pemeriksaan']);
$select = $db->query("SELECT id,nama FROM jasa_lab WHERE id = '$pemeriksaan'");
$out = mysqli_fetch_array($select);

 ?>

<div class="form-group">
  <label for="sel1">Nama Pemeriksaan</label>
  <select class="form-control" id="pemeriksaan" name="pemeriksaan" required=""> 

  <?php 
  $query2 = $db->query("SELECT id,nama FROM jasa_lab WHERE bidang = '$kelompok' ");
while ( $data2 = mysqli_fetch_array($query2))
 {	
 	if ($out['id'] == $data2['id']) {
  echo " <option selected value='".$data2['id']."'>".$data2['nama']."</option>";
 	}
 	else
 	{
 		  echo " <option value='".$data2['id']."'>".$data2['nama']."</option>";

 	}
 }
?>
  </select>
</div>
