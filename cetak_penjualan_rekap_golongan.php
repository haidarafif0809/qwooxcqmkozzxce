<?php session_start();
include 'header.php';
include 'sanitasi.php';
include 'db.php';

$dari_tanggal = stringdoang($_GET['dari_tanggal']);
$sampai_tanggal = stringdoang($_GET['sampai_tanggal']);
$golongan = stringdoang($_GET['golongan']);

$tanggal_sekarang = date('Y-m-d');


$query_perusahaan = $db->query("SELECT foto, nama_perusahaan, alamat_perusahaan, no_telp FROM perusahaan ");
$data_perusahaan = mysqli_fetch_array($query_perusahaan);

$sum_detail_penjualan = $db->query("SELECT SUM(jumlah_barang) AS jumlah, SUM(subtotal) AS total FROM detail_penjualan WHERE tipe_produk = '$golongan' AND tanggal >= '$dari_tanggal' AND tanggal <= '$sampai_tanggal'");
$data_detail_penjualan = mysqli_fetch_array($sum_detail_penjualan);


$total_nilai = $data_detail_penjualan['total'];
$jumlah_produk = $data_detail_penjualan['jumlah'];
    
 ?>

<div class="container">
    
                 <h3> <b> <center>LAPORAN PENJUALAN / GOLONGAN </center></b></h3><hr>
    <div class="row"><!--row1-->
        <div class="col-sm-2">
                <img src='save_picture/<?php echo $data_perusahaan['foto']; ?>' class='img-rounded' alt='Cinque Terre' width='160' height='140'> 
        </div><!--penutup colsm2-->

        <div class="col-sm-4">
                 <h4> <b> <?php echo $data_perusahaan['nama_perusahaan']; ?> </b> </h4> 
                 <p> <?php echo $data_perusahaan['alamat_perusahaan']; ?> </p> 
                 <p> No.Telp:<?php echo $data_perusahaan['no_telp']; ?> </p> 
                 
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

<style>

tr:nth-child(even){background-color: #f2f2f2}

</style>


<table id="tableuser" class="table table-bordered table-sm">
            <thead>
                  <th style="background-color: #4CAF50; color: white;"> Nama Produk </th>
                  <th style="background-color: #4CAF50; color: white;" align='right'> Jumlah Produk </th>
                  <th style="background-color: #4CAF50; color: white;" align='right'> Total Nilai </th>

                  
            </thead>
            
            <tbody>
            <?php
              $perintah = $db->query("SELECT SUM(jumlah_barang) AS jumlah, SUM(subtotal) AS total, nama_barang FROM detail_penjualan WHERE tipe_produk = '$golongan' AND tanggal >= '$dari_tanggal' AND tanggal <= '$sampai_tanggal' GROUP BY kode_barang  ORDER BY kode_barang ASC ");
                while ($data10 = mysqli_fetch_array($perintah))
                {
                  
                  echo "<tr>
                  <td>". $data10['nama_barang'] ."</td>
                  <td align='right'>". $data10['jumlah'] ."</td>
                  <td align='right'>". $data10['total'] ."</td>
                  </tr>";
                }

                  echo "<tr>
                  <td style=' color:red'> TOTAL </td>
                  <td style=' color:red' align='right'>".rp($jumlah_produk)."</td>
                  <td style=' color:red' align='right'>".rp($total_nilai)."</td>
                  </tr>";

                        //Untuk Memutuskan Koneksi Ke Database
                        //mysqli_close($db); 
        

        
            ?>
            </tbody>

      </table>

      <br>
      <div class="col-sm-12"><i><b>Terbilang : <?php echo kekata($total_nilai); ?></b></i></div>
        	

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