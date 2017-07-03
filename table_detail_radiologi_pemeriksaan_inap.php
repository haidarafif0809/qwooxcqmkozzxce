<?php
include 'sanitasi.php';
include 'db.php';

$no_reg = stringdoang($_POST['no_reg']);
$no_periksa = stringdoang($_POST['no_periksa']);

?>

<div class="container">   

  <div class="table-responsive"> 
    <table id="tabel-lab" class="table table-hover table-sm">
      <thead>

        <th> Kode Barang </th>
        <th> Nama Barang </th>
        <th> Harga  </th>
        <th> Tanggal </th>
        <th> Status Pemeriksaan </th>
           
      </thead>
        
      <tbody>
      <?php 
      $query_select_tbs_radiologi = $db->query("SELECT kode_barang, nama_barang, harga, tanggal, status_periksa FROM tbs_penjualan_radiologi WHERE no_reg = '$no_reg' AND no_pemeriksaan = '$no_periksa'");
      while($data_tbs = mysqli_fetch_array($query_select_tbs_radiologi)){

      	if($data_tbs['status_periksa'] == '1'){
      		$status = 'Sudah Diperiksa';
      	}
      	else{
      		$status = 'Belum Diperiksa';
      	}
      	echo "
      	<tr>
      	   <td>". $data_tbs['kode_barang'] ."</td>
      	   <td>". $data_tbs['nama_barang'] ."</td>
      	   <td>". $data_tbs['harga'] ."</td>
      	   <td>". $data_tbs['tanggal'] ."</td>
      	   <td>". $status ."</td>

      	</tr>
      	";

      }



      ?>
      	


      </tbody>
    </table>
  </div>

</div>

<script type="text/javascript">
  $(document).ready(function(){
    $('#tabel-lab').DataTable(
      {"ordering": false});
  });
</script>