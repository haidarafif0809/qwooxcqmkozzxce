<?php session_start();
include 'header.php';
include 'sanitasi.php';
include 'db.php';

$dari_tanggal = stringdoang($_GET['dari_tanggal']);
$sampai_tanggal = stringdoang($_GET['sampai_tanggal']);
$penjualan_closing = stringdoang($_GET['closing']);


$tanggal_sekarang = date('Y-m-d');


$query_perusahaan = $db->query("SELECT foto, nama_perusahaan, alamat_perusahaan, no_telp FROM perusahaan ");
$data_perusahaan = mysqli_fetch_array($query_perusahaan);


if ($penjualan_closing == "sudah") {

  $query_penjualan = $db->query("SELECT SUM(potongan) AS total_potongan, SUM(tax) AS total_tax, SUM(jumlah_barang) AS total_barang, SUM(subtotal) AS total_subtotal FROM detail_penjualan WHERE tanggal >= '$dari_tanggal' AND tanggal <= '$sampai_tanggal' AND no_faktur != no_reg ");
  $data_penjualan = mysqli_fetch_array($query_penjualan);
  $total_potongan = $data_penjualan['total_potongan'];
  $total_tax = $data_penjualan['total_tax'];
  $total_barang = $data_penjualan['total_barang'];
  $total_subtotal = $data_penjualan['total_subtotal'];

}
elseif ($penjualan_closing == "belum") {

  $query_penjualan = $db->query("SELECT SUM(potongan) AS total_potongan, SUM(tax) AS total_tax, SUM(jumlah_barang) AS total_barang, SUM(subtotal) AS total_subtotal FROM detail_penjualan WHERE tanggal >= '$dari_tanggal' AND tanggal <= '$sampai_tanggal' AND no_faktur = no_reg ");
  $data_penjualan = mysqli_fetch_array($query_penjualan);
  $total_potongan = $data_penjualan['total_potongan'];
  $total_tax = $data_penjualan['total_tax'];
  $total_barang = $data_penjualan['total_barang'];
  $total_subtotal = $data_penjualan['total_subtotal'];

}
else{

  $query_penjualan = $db->query("SELECT SUM(potongan) AS total_potongan, SUM(tax) AS total_tax, SUM(jumlah_barang) AS total_barang, SUM(subtotal) AS total_subtotal FROM detail_penjualan WHERE tanggal >= '$dari_tanggal' AND tanggal <= '$sampai_tanggal'");
  $data_penjualan = mysqli_fetch_array($query_penjualan);
  $total_potongan = $data_penjualan['total_potongan'];
  $total_tax = $data_penjualan['total_tax'];
  $total_barang = $data_penjualan['total_barang'];
  $total_subtotal = $data_penjualan['total_subtotal'];

}

    
?>

<div class="container">
  <h3> <b> <center>LAPORAN PENJUALAN DETAIL </center></b></h3><hr>
  
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
        </div><!--penutup colsm5-->
      
  </div><!--penutup row1-->

<hr>

<table id="tableuser" class="table table-bordered table-sm">
            <thead>

              <th style="background-color: #4CAF50; color: white;"> Nomor Faktur </th>
              <th style="background-color: #4CAF50; color: white;"> Kode Barang </th>
              <th style="background-color: #4CAF50; color: white;"> Nama Barang </th>
              <th style="background-color: #4CAF50; color: white;"> Jumlah  </th>
              <th style="background-color: #4CAF50; color: white;"> Satuan </th>
              <th style="background-color: #4CAF50; color: white;"> Harga </th>
              <th style="background-color: #4CAF50; color: white;"> Potongan </th>
              <th style="background-color: #4CAF50; color: white;"> Tax </th>
              <th style="background-color: #4CAF50; color: white;"> Subtotal </th>
                  
            </thead>
            
            <tbody>
            <?php

              if ($penjualan_closing == "sudah") {
                
                $query_detail_penjualan = $db->query("SELECT s.nama,dp.no_faktur,dp.kode_barang,dp.nama_barang,dp.jumlah_barang,dp.satuan,dp.harga,dp.subtotal,dp.potongan,dp.tax,dp.hpp,dp.sisa FROM detail_penjualan dp LEFT JOIN satuan s ON dp.satuan = s.id WHERE dp.tanggal >= '$dari_tanggal' AND dp.tanggal <= '$sampai_tanggal' AND no_faktur != no_reg ");
              }
              elseif ($penjualan_closing == "belum") {
                
                $query_detail_penjualan = $db->query("SELECT s.nama,dp.no_faktur,dp.kode_barang,dp.nama_barang,dp.jumlah_barang,dp.satuan,dp.harga,dp.subtotal,dp.potongan,dp.tax,dp.hpp,dp.sisa FROM detail_penjualan dp LEFT JOIN satuan s ON dp.satuan = s.id WHERE dp.tanggal >= '$dari_tanggal' AND dp.tanggal <= '$sampai_tanggal' AND no_faktur = no_reg ");
              }
              else{

                $query_detail_penjualan = $db->query("SELECT s.nama,dp.no_faktur,dp.kode_barang,dp.nama_barang,dp.jumlah_barang,dp.satuan,dp.harga,dp.subtotal,dp.potongan,dp.tax,dp.hpp,dp.sisa FROM detail_penjualan dp LEFT JOIN satuan s ON dp.satuan = s.id WHERE dp.tanggal >= '$dari_tanggal' AND dp.tanggal <= '$sampai_tanggal' ");
              }
  
                  while ($data_detail_penjualan = mysqli_fetch_array($query_detail_penjualan)){
                    
                    echo "<tr>
                    <td>". $data_detail_penjualan['no_faktur'] ."</td>
                    <td>". $data_detail_penjualan['kode_barang'] ."</td>
                    <td>". $data_detail_penjualan['nama_barang'] ."</td>
                    <td align='right'>". rp($data_detail_penjualan['jumlah_barang']) ."</td>";

                  if ($data_detail_penjualan['nama'] != "") {
                    echo "<td>". $data_detail_penjualan['nama'] ."</td>";
                  }
                  else{
                    echo "<td>-</td>";
                  }

                    echo "<td align='right'>". rp($data_detail_penjualan['harga']) ."</td>
                    <td align='right'>". rp($data_detail_penjualan['potongan']) ."</td>
                    <td align='right'>". rp($data_detail_penjualan['tax']) ."</td>
                    <td align='right'>". rp($data_detail_penjualan['subtotal']) ."</td>

                    </tr>";
                  }

                    echo "<tr>
                    <td style='color:red'>TOTAL</td>
                    <td style='color:red'> </td>
                    <td style='color:red'> </td>
                    <td style='color:red' align='right'>". rp($total_barang) ."</td>
                    <td style='color:red'> </td>
                    <td style='color:red'> </td>
                    <td style='color:red' align='right'>". rp($total_potongan) ."</td>
                    <td style='color:red' align='right'>". rp($total_tax) ."</td>
                    <td style='color:red' align='right'>". rp($total_subtotal) ."</td>
                    </tr>";

                    //Untuk Memutuskan Koneksi Ke Database
                    mysqli_close($db); 
            ?>
            </tbody>

      </table>

      <br>
      <div class="col-sm-12"><i><b>Terbilang : <?php echo kekata($total_subtotal); ?></b></i></div>
          

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