<?php 

include 'sanitasi.php';
include 'db.php';

// Fungsi header dengan mengirimkan raw data excel
header("Content-type: application/vnd-ms-excel");
 
// Mendefinisikan nama file ekspor "hasil-export.xls"
header("Content-Disposition: attachment; filename=data_laporan_pembayaran_piutang.xls");


$dari_tanggal = stringdoang($_GET['dari_tanggal']);
$sampai_tanggal = stringdoang($_GET['sampai_tanggal']);


//menampilkan seluruh data yang ada pada tabel penjualan
$perintah = $db->query("SELECT dpp.id, dpp.no_faktur_pembayaran, dpp.no_faktur_penjualan, dpp.tanggal, dpp.tanggal_jt, dpp.kredit, dpp.potongan, dpp.total, dpp.jumlah_bayar, dpp.kode_pelanggan, p.nama_pelanggan, pp.dari_kas, pp.total, da.nama_daftar_akun FROM detail_pembayaran_piutang dpp INNER JOIN pelanggan p ON dpp.kode_pelanggan = p.kode_pelanggan INNER JOIN pembayaran_piutang pp ON dpp.no_faktur_pembayaran = pp.no_faktur_pembayaran INNER JOIN daftar_akun da ON pp.dari_kas = da.kode_daftar_akun WHERE dpp.tanggal >= '$dari_tanggal' AND dpp.tanggal <= '$sampai_tanggal'");



 ?>
  <style>
  
  tr:nth-child(even){background-color: #f2f2f2}
  
  </style>
<table id="tableuser" class="table table-bordered table-sm">
    <thead>
      <th style="background-color: #4CAF50; color: white;"> Nomor Faktur Pembayaran</th>
      <th style="background-color: #4CAF50; color: white;"> Nomor Faktur Penjualan</th>
      <th style="background-color: #4CAF50; color: white;"> Tanggal </th>
      <th style="background-color: #4CAF50; color: white;"> Kode Pelanggan </th>
      <th style="background-color: #4CAF50; color: white;"> Cara Bayar </th>
      <th style="background-color: #4CAF50; color: white;"> Potongan </th>
      <th style="background-color: #4CAF50; color: white;"> Jumlah Bayar </th>
      
      
    </thead>
    
    <tbody>
    <?php

      //menyimpan data sementara yang ada pada $perintah
      while ($data1 = mysqli_fetch_array($perintah))
      {
        
      echo "<tr>
      <td>". $data1['no_faktur_pembayaran'] ."</td>
      <td>". $data1['no_faktur_penjualan'] ."</td>
      <td>". $data1['tanggal'] ."</td>
      <td> ". $data1['kode_pelanggan'] ." - ". $data1['nama_pelanggan'] ."</td>
      <td>". $data1['nama_daftar_akun'] ."</td>
      <td>". $data1['potongan'] ."</td>
      <td>". rp($data1['jumlah_bayar']) ."</td>

      
      </tr>";
      }

      //Untuk Memutuskan Koneksi Ke Database
      mysqli_close($db);   
    ?>
    </tbody>

  </table>







 <script>
$(document).ready(function(){
  window.print();
});
</script>

<?php include 'footer.php'; ?>