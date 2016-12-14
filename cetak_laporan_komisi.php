<?php session_start();

include 'header.php';
include 'sanitasi.php';
include 'db.php';



$nama_petugas = $_GET['nama_petugas'];
$dari_tanggal = $_GET['dari_tanggal'];
$sampai_tanggal = $_GET['sampai_tanggal'];

    $query0 = $db->query("SELECT u.nama,lff.id,lff.tanggal FROM laporan_fee_faktur lff INNER JOIN user u ON lff.nama_petugas = u.id WHERE nama_petugas = '$nama_petugas' AND tanggal >= '$dari_tanggal' AND tanggal <= '$sampai_tanggal'");
    $data0 = mysqli_fetch_array($query0);

    $query1 = $db->query("SELECT * FROM perusahaan ");
    $data1 = mysqli_fetch_array($query1);

    $query13 = $db->query("SELECT SUM(jumlah_fee) AS total_fee FROM laporan_fee_produk WHERE nama_petugas = '$nama_petugas' AND tanggal >= '$dari_tanggal' AND tanggal <= '$sampai_tanggal'");
    $cek3 = mysqli_fetch_array($query13);
    $total_fee1 = $cek3['total_fee'];

    $query10 = $db->query("SELECT SUM(jumlah_fee) AS total_fee FROM laporan_fee_faktur WHERE nama_petugas = '$nama_petugas' AND tanggal >= '$dari_tanggal' AND tanggal <= '$sampai_tanggal'");
    $cek0 = mysqli_fetch_array($query10);
    $total_fee2 = $cek0['total_fee'];

    $total_fee = $total_fee1 + $total_fee2;
    
 ?>

<div style="padding-right: 5%; padding-left: 5%;">
    
                 <h3> <b><center> BUKTI TOTAL KOMISI</center> </b></h3><hr>
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
      <tr><td  width="40%">Periode</td> <td> :&nbsp;</td> <td> <?php echo tanggal($dari_tanggal); ?> s/d <?php echo tanggal($sampai_tanggal); ?> </td></tr>
      <tr><td  width="40%">User</td> <td> :&nbsp;</td> <td> <?php echo $_SESSION['user_name']; ?> </td></tr>
   
            
  </tbody>
</table>          
                 
        </div><!--penutup colsm4-->
      
    </div><!--penutup row1-->



<br>
<h4><b><center>Tabel Komisi Produk</center></b></h4><br>
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
                $query10 = $db->query("SELECT u.nama,lfp.nama_petugas,lfp.no_faktur,lfp.kode_produk,lfp.nama_produk,lfp.jumlah_fee,lfp.tanggal,lfp.jam FROM laporan_fee_produk lfp INNER JOIN user u ON lfp.nama_petugas = u.id WHERE nama_petugas = '$nama_petugas' ");
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
      <br>
<h4><b><center>Tabel Komisi Faktur</center></b></h4><br>
<table id="tableuser" class="table table-bordered table-sm">
            <thead>
                 <th> Nama Petugas </th>
                  <th> Nomor Faktur </th>
                  <th> Jumlah Komisi </th>
                  <th> Tanggal </th>
                  <th> Jam </th>

            </thead>
            
            <tbody>
            <?php
                $query13 = $db->query("SELECT u.nama,lff.nama_petugas,lff.no_faktur,lff.jumlah_fee,lff.tanggal,lff.jam FROM laporan_fee_faktur lff INNER JOIN user u ON lff.nama_petugas = u.id WHERE nama_petugas = '$nama_petugas' ");
                while ($data13 = mysqli_fetch_array($query13))
                {
                  
                  echo "<tr>
                  <td>". $data13['nama'] ."</td>
                  <td>". $data13['no_faktur'] ."</td>
                  <td>". $data13['jumlah_fee'] ."</td>
                  <td>". tanggal($data13['tanggal']) ."</td>
                  <td>". $data13['jam'] ."</td>
                  </tr>";
                }
                mysqli_close($db); 
            ?>
            </tbody>

      </table>

      <br>
      <div class="row">
      <div class="col-sm-8">
        
 <table>
  <tbody>

      <tr><td><i> <b> Terbilang </b></td> <td> &nbsp;:&nbsp;</td> <td> <?php echo kekata($total_fee); ?> </i> </td></tr>

  </tbody>
  </table>

</div>
     <div class="col-sm-4">
        
 <table>
  <tbody>
      <tr><td width="75%"><b>Jumlah Komisi / Produk</b></td> <td> &nbsp;:&nbsp;</td> <td> <?php echo rp($total_fee1); ?> </td></tr>

      <tr><td width="75%"><b>Jumlah Komisi / Faktur</b></td> <td> &nbsp;:&nbsp;</td> <td> <?php echo rp($total_fee2); ?> </td></tr>

      <tr><td width="75%"><b>Total Komisi</b></td> <td> &nbsp;:&nbsp;</td> <td> <?php echo rp($total_fee); ?> </td></tr>


  </tbody>
  </table>

     </div>
<br>

</div>
<hr>

 <div class="row">
     
     <div class="col-sm-9"><b>&nbsp;&nbsp;&nbsp;Hormat Kami<br><br><br><br>( ...................... )</b></div>
     <div class="col-sm-2"><b>&nbsp;&nbsp;&nbsp;&nbsp;Penerima<br><br><br><br>( ................... )</b></div>

     


</div>
        

</div> <!--end container-->





 <script>
$(document).ready(function(){
  window.print();
});
</script>




<?php include 'footer.php'; ?>