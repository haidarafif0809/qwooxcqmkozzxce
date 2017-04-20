<?php 
include 'header.php';
include 'sanitasi.php';
include 'db.php';


$dari_tanggal = stringdoang($_GET['dari_tanggal']);
$sampai_tanggal = stringdoang($_GET['sampai_tanggal']);

$query_perusahaan = $db->query("SELECT foto, nama_perusahaan, alamat_perusahaan, no_telp FROM perusahaan ");
$data_perusahaan = mysqli_fetch_array($query_perusahaan);

?>

<div class="container">
 <div class="row"><!--row1-->
        <div class="col-sm-2">
        <br><br>
                <img src='save_picture/<?php echo $data_perusahaan['foto']; ?>' class='img-rounded' alt='Cinque Terre' width='160' height='140`'> 
        </div><!--penutup colsm2-->

        <div class="col-sm-6">
                 <h3> <b> LAPORAN JUMLAH PASIEN </b></h3>
                 <hr>
                 <h4> <b> <?php echo $data_perusahaan['nama_perusahaan']; ?> </b> </h4> 
                 <p> <?php echo $data_perusahaan['alamat_perusahaan']; ?> </p> 
                 <p> No.Telp:<?php echo $data_perusahaan['no_telp']; ?> </p> 
                 
        </div><!--penutup colsm4-->

        <div class="col-sm-4">
         <br><br>                 
<table>
  <tbody>

      <tr><td  width="20%">PERIODE</td> <td> &nbsp;:&nbsp; </td> <td> <?php echo tanggal($dari_tanggal); ?> <b>s/d</b> <?php echo tanggal($sampai_tanggal); ?></td>
      </tr>
            
  </tbody>
</table>           
                 
        </div><!--penutup colsm4-->


        
    </div><!--penutup row1-->

<hr><h4><b>Laporan Jumlah Pasien R. Jalan</b></h4>

<table id="tableuser" class="table table-bordered table-sm">
  <thead>
    <th style="background-color: #4CAF50; color: white;"> Nomor Faktur </th>  
    <th style="background-color: #4CAF50; color: white;"> Nama Pasien </th>
    <th style="background-color: #4CAF50; color: white;"> Penjamin </th>  
    <th style="background-color: #4CAF50; color: white;"> Tanggal Masuk </th>
    <th style="background-color: #4CAF50; color: white;"> Tanggal Keluar </th>  
    <th style="background-color: #4CAF50; color: white;"> Jumlah Periksa </th>
  </thead>

  <tbody>

    <?php

      $query_pasien = $db->query("SELECT r.no_rm,r.no_reg,r.nama_pasien,r.penjamin,r.tanggal, p.no_faktur FROM registrasi r INNER JOIN penjualan p ON r.no_reg = p.no_reg WHERE r.jenis_pasien = 'Rawat Jalan' AND r.tanggal >= '$dari_tanggal' AND r.tanggal <= '$sampai_tanggal' ORDER BY CONCAT(r.tanggal,' ',r.jam) DESC");
        
        $totalData = mysqli_num_rows($query_pasien);        
        while ($data_pasien = mysqli_fetch_array($query_pasien)) {

            echo "<tr>
              <td>". $data_pasien['no_faktur'] ."</td>
              <td>". $data_pasien['nama_pasien'] ."</td>
              <td>". $data_pasien['penjamin'] ."</td>
              <td align='right'>". $data_pasien['tanggal'] ."</td>
              <td align='right'>". $data_pasien['tanggal'] ."</td>
              <td align='right'> 1 </td>
            </tr>";
        }

            echo "<tr>
                  <td style='color:red'>TOTAL PASIEN</td>
                  <td style='color:red'></td>
                  <td style='color:red'></td>
                  <td style='color:red' align='right'>-</td>
                  <td style='color:red' align='right'>-</td>
                  <td style='color:red' align='right'>". rp($totalData) ."</td>
            </tr>";


    ?>
  </tbody>
</table>

<br>
<hr><h4><b>Laporan Jumlah Pasien R. Inap</b></h4>

<table id="tableuser" class="table table-bordered table-sm">
  <thead>
    <th style="background-color: #4CAF50; color: white;"> Nomor Faktur </th>  
    <th style="background-color: #4CAF50; color: white;"> Nama Pasien </th>
    <th style="background-color: #4CAF50; color: white;"> Penjamin </th>  
    <th style="background-color: #4CAF50; color: white;"> Tanggal Masuk </th>
    <th style="background-color: #4CAF50; color: white;"> Tanggal Keluar </th>  
    <th style="background-color: #4CAF50; color: white;"> Jumlah Periksa </th>
  </thead>

  <tbody>

    <?php

      $query_pasien_inap = $db->query("SELECT r.no_rm,r.no_reg,r.nama_pasien,r.penjamin,r.tanggal_masuk, p.tanggal, p.no_faktur, DATEDIFF(DATE(p.tanggal), r.tanggal_masuk) AS jumlah_hari FROM registrasi r INNER JOIN penjualan p ON r.no_reg = p.no_reg WHERE r.jenis_pasien = 'Rawat Inap' AND r.tanggal_masuk >= '$dari_tanggal' AND r.tanggal_masuk <= '$sampai_tanggal' ORDER BY CONCAT(r.tanggal,' ',r.jam) DESC");
        
        $total_pasien_ranap = 0;

        $totalDataInap = mysqli_num_rows($query_pasien_inap);        
        while ($data_pasien_inap = mysqli_fetch_array($query_pasien_inap)) {

            echo "<tr>
              <td>". $data_pasien_inap['no_faktur'] ."</td>
              <td>". $data_pasien_inap['nama_pasien'] ."</td>
              <td>". $data_pasien_inap['penjamin'] ."</td>
              <td align='right'>". $data_pasien_inap['tanggal_masuk'] ."</td>
              <td align='right'>". $data_pasien_inap['tanggal'] ."</td>
              <td align='right'>". $data_pasien_inap['jumlah_hari'] ."</td>
            </tr>";

            $total_pasien_ranap = $total_pasien_ranap + $data_pasien_inap['jumlah_hari'];
        }

            echo "<tr>
                  <td style='color:red'>TOTAL PASIEN</td>
                  <td style='color:red'></td>
                  <td style='color:red'></td>
                  <td style='color:red' align='right'>-</td>
                  <td style='color:red' align='right'>-</td>
                  <td style='color:red' align='right'>". rp($total_pasien_ranap) ."</td>
            </tr>";

            //Untuk Memutuskan Koneksi Ke Database            
            mysqli_close($db); 

    ?>
  </tbody>
</table>

</div><!-- /CONTAINER -->

 <script>
$(document).ready(function(){
  window.print();
});
</script>

<?php include 'footer.php'; ?>