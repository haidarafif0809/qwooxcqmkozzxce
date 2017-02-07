<?php session_start();
include 'header.php';
include 'sanitasi.php';
include 'db.php';

$dari_tanggal = stringdoang($_GET['dari_tanggal']);
$sampai_tanggal = stringdoang($_GET['sampai_tanggal']);
$golongan = stringdoang($_GET['golongan']);

$tanggal_sekarang = date('Y-m-d');

$jumlah_jual_awal = 0;
$jumlah_beli_awal = 0;


    $query1 = $db->query("SELECT * FROM perusahaan ");
    $data1 = mysqli_fetch_array($query1);
	$perintah = $db->query("SELECT SUM(dp.jumlah_barang) AS jumlah, SUM(dp.subtotal) AS total FROM detail_penjualan dp LEFT JOIN barang p ON dp.kode_barang = p.kode_barang  WHERE p.berkaitan_dgn_stok = '$golongan' AND dp.tanggal >= '$dari_tanggal' AND dp.tanggal <= '$sampai_tanggal'");
	$data = mysqli_fetch_array($perintah);
    
 ?>

<div class="container">
    
                 <h3> <b> <center>LAPORAN PENJUALAN / GOLONGAN </center></b></h3><hr>
    <div class="row"><!--row1-->
        <div class="col-sm-2">
                <img src='save_picture/<?php echo $data1['foto']; ?>' class='img-rounded' alt='Cinque Terre' width='160' height='140'> 
        </div><!--penutup colsm2-->

        <div class="col-sm-4">
                 <h4> <b> <?php echo $data1['nama_perusahaan']; ?> </b> </h4> 
                 <p> <?php echo $data1['alamat_perusahaan']; ?> </p> 
                 <p> No.Telp:<?php echo $data1['no_telp']; ?> </p> 
                 
        </div><!--penutup colsm4-->
<br><br>
        <div class="col-sm-5">
<table>
  <tbody>
  
      <tr><td  width="40%">Nama Petugas</td> <td> :&nbsp;</td> <td> <?php echo $_SESSION['nama']; ?></td></tr>
      <tr><td  width="40%">Tanggal</td> <td> :&nbsp;</td> <td> <?php echo tanggal($tanggal_sekarang); ?> </td>
      </tr>
      <tr><td  width="40%">Periode</td> <td> :&nbsp;</td> <td> <?php echo tanggal($dari_tanggal); ?> s/d <?php echo tanggal($sampai_tanggal); ?> </td></tr>
   
            
  </tbody>
</table>          
                 
        </div><!--penutup colsm4-->
      
    </div><!--penutup row1-->



<table id="tableuser" class="table table-bordered table-sm">
            <thead>
                  <th> Nama Produk </th>
                  <th> Jumlah Produk </th>
                  <th> Total Nilai </th>>

                  
            </thead>
            
            <tbody>
            <?php
              $perintah = $db->query("SELECT dp.nama_barang, SUM(dp.jumlah_barang) AS jumlah, SUM(dp.subtotal) AS total
              	FROM detail_penjualan dp INNER JOIN barang p ON dp.kode_barang = p.kode_barang  WHERE p.golongan_barang = '$golongan' AND dp.tanggal >= '$dari_tanggal' AND dp.tanggal <= '$sampai_tanggal' GROUP BY dp.kode_barang ORDER BY dp.id ASC ");
                while ($data10 = mysqli_fetch_array($perintah))
                {
                  
                  echo "<tr>
                  <td>". $data10['nama_barang'] ."</td>
                  <td>". $data10['jumlah'] ."</td>
                  <td>". $data10['total'] ."</td>
                  </tr>";
                }

                        //Untuk Memutuskan Koneksi Ke Database
                        
                        mysqli_close($db); 
        

        
            ?>
            </tbody>

      </table>
      <br>
      <div class="row">

      <div class="col-sm-4"><i><b>Terbilang : <?php echo kekata($data['total']); ?></b></i></div>
      <div class="col-sm-2"></div>

      <div class="col-sm-4">
      	<table>
      		<tr><td>Jumlah Produk</td><td>:</td><td><?php echo rp($data['jumlah']); ?></td></tr>
      		<tr><td><b>Total Nilai</td><td>:</td><td></b><b><?php echo rp($data['total']); ?></b></td></tr>
      	</table>
      </div>
      	
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