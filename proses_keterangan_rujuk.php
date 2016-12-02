<?php 
include 'db.php';
include 'sanitasi.php';

$no_reg = stringdoang($_POST['reg']);
$keterangan = stringdoang($_POST['keterangan']);

$query = $db->query("UPDATE registrasi SET status = 'Rujuk Keluar Ditangani' , keterangan = '$keterangan' WHERE no_reg = '$no_reg' AND jenis_pasien = 'Rawat Jalan' ");  



 ?>



    <?php 

    $query7 = $db->query("SELECT * FROM registrasi WHERE (jenis_pasien = 'Rawat Jalan' AND  status = 'Proses') OR status = 'Rujuk Keluar Ditangani' ORDER BY id DESC LIMIT 1");

    $data = mysqli_fetch_array($query7);

      echo "<tr  class='tr-id-".$data['id']."'>";

      $query_z = $db->query("SELECT p.status,p.no_faktur,p.nama,p.kode_gudang,g.nama_gudang FROM penjualan p INNER JOIN gudang g ON p.kode_gudang = g.kode_gudang WHERE p.no_reg = '$data[no_reg]' ");
      $data_z = mysqli_fetch_array($query_z);

      if ($data_z['status'] == 'Simpan Sementara') {

       echo "<td> <a href='proses_pesanan_barang_raja.php?no_faktur=".$data_z['no_faktur']."&no_reg=".$data['no_reg']."&no_rm=".$data['no_rm']."&nama_pasien=".$data_z['nama']."&kode_gudang=".$data_z['kode_gudang']."&nama_gudang=".$data_z['nama_gudang']."'class='btn btn-floating btn-small btn btn-info'><i class='fa fa-credit-card'></i></a> </td>"; 
      }
      else
      {
      echo"<td> <a href='form_penjualan_kasir.php?no_reg=". $data['no_reg']."' class='btn btn-floating btn-small btn-info penjualan' ><i class='fa fa-shopping-cart'></i></a></td>";

      }
  ?>
  <?php
  if ($data['status'] == 'Rujuk Keluar Ditangani')
  {
    echo "<td style='color:red;'>Silakan Transaksi Penjualan</td>";
  } 
  else
  {
    echo "<td><button class='btn btn-floating btn-small btn-info pilih1' data-reg='". $data['no_reg']."' data-id='". $data['id']."' ><i class='fa fa-bus '></button></td>";
  }
  ?>
  <?php
  echo "
 <td><button class='btn btn-floating btn-small btn-info pilih12' data-reg='". $data['no_reg']."' data-id='". $data['id']."'><i class='fa fa-cab'></button></td>

  <td> <button class='btn btn-floating btn-small btn-info rujuk_ri' data-reg='".$data['no_reg']."'><i class='fa fa-hotel'></button></td>

  <td><button class='btn btn-floating btn-small btn-info pilih2' data-id='". $data['id']."' data-reg='".$data['no_reg']."'><b> X </b></button></td>
  
          <td>". $data['no_urut']."</td>
          <td>". $data['poli']."</td>
          <td>". $data['dokter']."</td>
          <td>". $data['no_reg']."</td>
          <td>". $data['no_rm']."</td>
          <td>". tanggal($data['tanggal'])."</td>              
          <td>". $data['nama_pasien']."</td>
          <td>". $data['penjamin']."</td>
          <td>". $data['umur_pasien']."</td>
          <td>". $data['jenis_kelamin']."</td>
          <td>". $data['keterangan']."</td>
          </tr>";

    ?>


<!--   script untuk detail layanan PERUSAHAAN PENJAMIN-->
<script type="text/javascript">

     $(".pilih12").click(function(){   

    var id = $(this).attr('data-id');
    var reg = $(this).attr('data-reg');

          $("#rujuk_non_penanganan").modal('show');
          $("#submit_rujuk_non_penanganan").attr("data-id",id);
          $("#submit_rujuk_non_penanganan").attr("data-reg",reg);

  });

  </script>