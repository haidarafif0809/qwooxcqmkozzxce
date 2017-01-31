<?php session_start();
include 'header.php';
include 'sanitasi.php';
include 'db.php';


$nama_petugas = stringdoang($_GET['nama_petugas']);
$dari_tanggal = stringdoang($_GET['dari_tanggal']);
$sampai_tanggal = stringdoang($_GET['sampai_tanggal']);
$dari_jam = stringdoang($_GET['dari_jam']);
$sampai_jam = stringdoang($_GET['sampai_jam']);

$waktu_dari = $dari_tanggal." ".$dari_jam;
$waktu_sampai = $sampai_tanggal." ".$sampai_jam;
  

    $query0 = $db->query("SELECT lfp.id,lfp.tanggal,u.nama FROM laporan_fee_produk lfp INNER JOIN user u ON lfp.nama_petugas = u.id WHERE lfp.nama_petugas = '$nama_petugas' AND lfp.waktu >= '$waktu_dari' AND lfp.waktu <= '$waktu_sampai'");
    $data0 = mysqli_fetch_array($query0);

    $query1 = $db->query("SELECT * FROM perusahaan ");
    $data1 = mysqli_fetch_array($query1);

    $query10 = $db->query("SELECT SUM(jumlah_fee) AS total_fee FROM laporan_fee_produk WHERE nama_petugas = '$nama_petugas' AND waktu >= '$waktu_dari' AND waktu <= '$waktu_sampai'");
    $cek0 = mysqli_fetch_array($query10);
    $total_fee = $cek0['total_fee'];

$query11 = $db->query("SELECT SUM(tfp.jumlah_fee) AS total_fee FROM tbs_fee_produk tfp LEFT JOIN registrasi r ON tfp.no_reg = r.no_reg WHERE tfp.nama_petugas = '$nama_petugas' AND (tfp.waktu >= '$waktu_dari' AND tfp.waktu <= '$waktu_sampai') AND r.jenis_pasien = 'Rawat Inap' ");
    $cek1 = mysqli_fetch_array($query11);
    $total_fee_no_closing = $cek1['total_fee'];
    
$total_seluruh = $total_fee + $total_fee_no_closing;


 ?>

<div style="padding-right: 5%; padding-left: 5%;">
    
                 <h3> <b> <center>BUKTI KOMISI PRODUK / PETUGAS </center></b></h3><hr>
    <div class="row"><!--row1-->
        <div class="col-sm-2">
                <img src='save_picture/<?php echo $data1['foto']; ?>' class='img-rounded' alt='Cinque Terre' width='160' height='140`'> 
        </div><!--penutup colsm2-->

        <div class="col-sm-4">
                 <h4> <b> <?php echo $data1['nama_perusahaan']; ?> </b> </h4> 
                 <p> <?php echo $data1['alamat_perusahaan']; ?> </p> 
                 <p> No.Telp:<?php echo $data1['no_telp']; ?> </p> 
                 
        </div><!--penutup colsm4-->

        <div class="col-sm-5">
<table>
  <tbody>
  
      <tr><td  width="40%">Nama Petugas</td> <td> :&nbsp;</td> <td> <?php echo $data0['nama']; ?></td></tr>
      <tr><td  width="40%">Tanggal</td> <td> :&nbsp;</td> <td> <?php echo tanggal($data0['tanggal']); ?> </td>
      </tr>
      <tr><td  width="40%">Periode</td> <td> :&nbsp;</td> <td> <?php echo $waktu_dari; ?> s/d <?php echo $waktu_sampai; ?> </td></tr>
      <tr><td  width="40%">User</td> <td> :&nbsp;</td> <td> <?php echo $_SESSION['user_name']; ?> </td></tr>
   
            
  </tbody>
</table>          
                 
        </div><!--penutup colsm4-->
      
    </div><!--penutup row1-->
</div> <!-- end of container-->


<br>
<div class="container">
<center><h4>Komisi Sudah Closing</h4></center>
<table id="tableuser" class="table table-bordered table-sm">
            <thead>
                  <th> Nama Petugas </th>
                  <th> Nomor Faktur </th>
                  <th> Kode Produk </th>
                  <th> Nama Produk </th>
                  <th> Jumlah Komisi </th>
                  <th> Tanggal </th>
                  <th> Jam </th>


            </thead>
            
            <tbody>
            <?php
                $query10 = $db->query("SELECT lfp.nama_petugas,lfp.no_faktur,lfp.kode_produk,lfp.nama_produk,lfp.jumlah_fee,lfp.tanggal,lfp.jam ,u.nama FROM laporan_fee_produk lfp LEFT JOIN user u ON lfp.nama_petugas = u.id  WHERE lfp.nama_petugas = '$nama_petugas' AND (lfp.waktu >= '$waktu_dari' AND lfp.waktu <= '$waktu_sampai' ) ");
                while ($data10 = mysqli_fetch_array($query10))
                {
                  
                  echo "<tr>
                  <td>". $data10['nama'] ."</td>
                  <td>". $data10['no_faktur'] ."</td>
                  <td>". $data10['kode_produk'] ."</td>
                  <td>". $data10['nama_produk'] ."</td>
                  <td>". rp($data10['jumlah_fee']) ."</td>
                  <td>". tanggal($data10['tanggal']) ."</td>
                  <td>". $data10['jam'] ."</td>
                  </tr>";
                }

                        //Untuk Memutuskan Koneksi Ke Database
                              

        
            ?>
            </tbody>

      </table>

<center><h4>Komisi Belum Closing</h4></center>
<table id="tableuser" class="table table-bordered table-sm">
            <thead>
                  <th> Nama Petugas </th>
                  <th> Nomor Faktur </th>
                  <th> Kode Produk </th>
                  <th> Nama Produk </th>
                  <th> Jumlah Komisi </th>
                  <th> Tanggal </th>
                  <th> Jam </th>


            </thead>
            
            <tbody>
            <?php
                $query100 = $db->query("SELECT lfp.nama_petugas,lfp.no_faktur,lfp.kode_produk,lfp.nama_produk,lfp.jumlah_fee,lfp.tanggal,lfp.jam ,u.nama FROM tbs_fee_produk lfp LEFT JOIN user u ON lfp.nama_petugas = u.id  LEFT JOIN registrasi r ON lfp.no_reg = r.no_reg WHERE lfp.nama_petugas = '$nama_petugas' AND (lfp.waktu >= '$waktu_dari' AND lfp.waktu <= '$waktu_sampai') AND r.jenis_pasien = 'Rawat Inap'   ");
                while ($data100 = mysqli_fetch_array($query100))
                {
                  
                  echo "<tr>
                  <td>". $data100['nama'] ."</td>
                  <td>". $data100['no_faktur'] ."</td>
                  <td>". $data100['kode_produk'] ."</td>
                  <td>". $data100['nama_produk'] ."</td>
                  <td>". rp($data100['jumlah_fee']) ."</td>
                  <td>". tanggal($data100['tanggal']) ."</td>
                  <td>". $data100['jam'] ."</td>
                  </tr>";
                }

                        //Untuk Memutuskan Koneksi Ke Database
                        
                        mysqli_close($db); 
        

        
            ?>
            </tbody>

      </table>
      <br>
      <div class="row">
      <div class="col-sm-8">
        
 <table>
  <tbody>

      <tr><td><i> <b> Terbilang </b></td> <td> &nbsp;:&nbsp;</td> <td> <?php echo kekata($total_seluruh); ?> rupiah </i> </td></tr>

  </tbody>
  </table>


     </div>

     <div class="col-sm-4">
        
 <table>
  <tbody>

      <tr><td width="75%"><b>Total Komisi Sudah Closing</b></td> <td> &nbsp;:&nbsp;</td> <td> <?php echo rp($total_fee); ?> </td></tr>
      <tr><td width="75%"><b>Total Komisi Sudah Closing</b></td> <td> &nbsp;:&nbsp;</td> <td> <?php echo rp($total_fee_no_closing); ?> </td></tr>
      <tr><td width="75%"><b>Total Komisi </b></td> <td> &nbsp;:&nbsp;</td> <td> <b><?php echo rp($total_seluruh); ?> </b></td></tr>

  </tbody>
  </table>

     </div>
<br>
<hr>
</div>

 <div class="row">
     <div class="col-sm-1">
</div>
     <div class="col-sm-8"><b>&nbsp;&nbsp;&nbsp;Hormat Kami<br><br><br><br>( ...................... )</b></div>
     <div class="col-sm-3"><b>&nbsp;&nbsp;&nbsp;&nbsp;Penerima<br><br><br><br>( ................... )</b></div>

     


</div>
        

</div> <!--end container-->



 <script>
$(document).ready(function(){
  window.print();
});
</script>






<?php include 'footer.php'; ?>