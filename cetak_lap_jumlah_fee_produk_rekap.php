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
    $total_fee = rp($cek0['total_fee']);
    
 ?>

<div style="padding-right: 5%; padding-left: 5%;">
    
                 <h3> <b> <center>BUKTI KOMISI REKAP PRODUK / PETUGAS </center></b></h3><hr>
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

<table id="table-pelamar" class="table table-bordered table-sm">
 
    <thead>
      <tr>
        <th>Nomor</th>
        <th>Nama Produk</th>
        <th>Jumlah Produk</th>
        <th>Jumlah Komisi</th>

    </tr>
    </thead>
    <tbody>
  
     
   <?php 
$nomor = 0;
$total_udah_kelar = 0;
 $query10 = $db->query("SELECT lfp.nama_petugas,lfp.no_faktur,lfp.kode_produk,lfp.nama_produk,lfp.jumlah_fee,lfp.tanggal,lfp.jam ,u.nama FROM laporan_fee_produk lfp INNER JOIN user u ON lfp.nama_petugas = u.id  WHERE lfp.nama_petugas = '$nama_petugas' AND lfp.waktu >= '$waktu_dari' AND lfp.waktu <= '$waktu_sampai' GROUP BY lfp.kode_produk ");
   while($data = mysqli_fetch_array($query10))
      
            {
$nomor = $nomor + 1; 
              $num_row = $db->query("SELECT nama_produk FROM laporan_fee_produk WHERE  nama_petugas = '$nama_petugas' AND waktu >= '$waktu_dari' AND waktu <= '$waktu_sampai' AND kode_produk = '$data[kode_produk]' ");
                $kel = mysqli_num_rows($num_row);

               $SS = $db->query("SELECT SUM(jumlah_fee) AS jumlah FROM laporan_fee_produk WHERE nama_petugas = '$nama_petugas' AND waktu >= '$waktu_dari' AND waktu <= '$waktu_sampai' AND kode_produk = '$data[kode_produk]'");
                $kel2 = mysqli_fetch_array($SS); 
                $jumlah = $kel2['jumlah'];

$total_udah_kelar = $total_udah_kelar + $jumlah;

            echo "<tr>
            <td>".$nomor."</td>
            <td>". $data['nama_produk']."</td>
            <td>". $kel."</td>
            <td>". rp($jumlah)."</td>
          
                      
            </tr>";
      
      }
    ?>
  </tbody>
 </table>
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

      <tr><td width="75%"><b>Jumlah Komisi Petugas</b></td> <td> &nbsp;:&nbsp;</td> <td> <?php echo $total_fee; ?> </td></tr>

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