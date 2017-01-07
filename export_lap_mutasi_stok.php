<?php 
include 'sanitasi.php';
include 'db.php';


// Fungsi header dengan mengirimkan raw data excel
header("Content-type: application/vnd-ms-excel");
 
// Mendefinisikan nama file ekspor "hasil-export.xls"
header("Content-Disposition: attachment; filename=data_laporan_mutasi_stok.xls");


$dari_tanggal = stringdoang($_GET['dari_tanggal']);
$sampai_tanggal = stringdoang($_GET['sampai_tanggal']);



$barang = $db->query("SELECT b.nama_barang, b.kode_barang, b.satuan, s.nama FROM barang b INNER JOIN satuan s ON b.satuan = s.id");



 ?>

<style>
table {
    border-collapse: collapse;
    width: 100%;
}

th, td {
    text-align: left;
    padding: 8px;
}

tr:nth-child(even){background-color: #f2f2f2}

th {
    background-color: #4CAF50;
    color: white;
}
</style>


<div class='container'>
  
<center>
<b><h3>Data Laporan Mutasi Stok <br> (<?php echo $dari_tanggal ?>) s/d (<?php echo $sampai_tanggal ?>)</h3></b>
<div class="table-responsive">
 <table id="tableuser" class="table table-bordered table-sm">
            <thead>
      <th style="text-align: center"> Kode Item </th>
      <th style="text-align: center"> Nama Item </th>
      <th style="text-align: center"> Satuan </th>
      <th style="text-align: center"> Awal </th>
      <th style="text-align: center"> Nilai Awal </th>
      <th style="text-align: center"> Masuk </th>
      <th style="text-align: center"> Nilai Masuk </th>
      <th style="text-align: center"> Keluar </th>
      <th style="text-align: center"> Nilai Keluar </th>
      <th style="text-align: center"> Akhir </th>
      <th style="text-align: center"> Nilai Akhir </th>
      
    </thead>
    
    <tbody>
    <?php


      
      $sub_nilai_akhir = 0;

      //menyimpan data sementara yang ada pada $perintah
      while ($data_barang = mysqli_fetch_array($barang))

      {
      

          $pembelian = $db->query("SELECT dp.kode_barang, SUM(p.potongan) AS diskon_faktur FROM pembelian p INNER JOIN detail_pembelian dp ON p.no_faktur = dp.no_faktur WHERE dp.kode_barang = '$data_barang[kode_barang]' AND p.tanggal >= '$dari_tanggal' AND p.tanggal <= '$sampai_tanggal'");
          $cek_pembelian = mysqli_fetch_array($pembelian);
          $diskon = $cek_pembelian['diskon_faktur'];


          $hpp_masuk = $db->query("SELECT SUM(jumlah_kuantitas) AS jumlah_kuantitas, SUM(total_nilai) AS total_hpp FROM hpp_masuk WHERE kode_barang = '$data_barang[kode_barang]' AND tanggal <'$dari_tanggal'");
          $cek_awal_masuk = mysqli_fetch_array($hpp_masuk);

          $hpp_keluar = $db->query("SELECT SUM(jumlah_kuantitas) AS jumlah_kuantitas, SUM(total_nilai) AS total_hpp FROM hpp_keluar WHERE kode_barang = '$data_barang[kode_barang]' AND tanggal <'$dari_tanggal'");
          $cek_awal_keluar = mysqli_fetch_array($hpp_keluar);

          $awal = $cek_awal_masuk['jumlah_kuantitas'] - $cek_awal_keluar['jumlah_kuantitas'];
          $nilai_awal = $cek_awal_masuk['total_hpp'] - $cek_awal_keluar['total_hpp'];

          $hpp_masuk = $db->query("SELECT SUM(jumlah_kuantitas) AS jumlah_kuantitas, SUM(total_nilai) AS total_hpp FROM hpp_masuk WHERE kode_barang = '$data_barang[kode_barang]' AND tanggal >= '$dari_tanggal' AND tanggal <= '$sampai_tanggal' ");
          $cek_hpp_masuk = mysqli_fetch_array($hpp_masuk);

          $masuk = $cek_hpp_masuk['jumlah_kuantitas'];
          $nilai_masuk = $cek_hpp_masuk['total_hpp'];
          $nilai_masuk = $nilai_masuk;

          $hpp_keluar = $db->query("SELECT SUM(jumlah_kuantitas) AS jumlah_kuantitas, SUM(total_nilai) AS total_hpp FROM hpp_keluar WHERE kode_barang = '$data_barang[kode_barang]' AND tanggal >= '$dari_tanggal' AND tanggal <= '$sampai_tanggal' ");
          $cek_hpp_keluar = mysqli_fetch_array($hpp_keluar);

          $keluar = $cek_hpp_keluar['jumlah_kuantitas'];
          $nilai_keluar = $cek_hpp_keluar['total_hpp'];

          $akhir = ($awal + $masuk) - $keluar;
          $nilai_akhir = ($nilai_awal + $nilai_masuk) - $nilai_keluar;



        //menampilkan data
          echo "<tr>";

          if ($nilai_akhir != '' OR $nilai_akhir != '0')
              {
              echo "<td>". $data_barang['kode_barang'] ."</td>
              <td>". $data_barang['nama_barang'] ."</td>
              <td>". $data_barang['nama'] ."</td>
              <td style='text-align: right'>".rp($awal)."</td>
              <td style='text-align: right'>".rp($nilai_awal)."</td>
              <td style='text-align: right'>".rp($masuk)."</td>
              <td style='text-align: right'>".rp($nilai_masuk)."</td>
              <td style='text-align: right'>".rp($keluar)."</td>
              <td style='text-align: right'>".rp($nilai_keluar)."</td>
              <td style='text-align: right'>".rp($akhir)."</td>
              <td style='text-align: right'>".rp($nilai_akhir)."</td>";
              }
          echo"</tr>";
          $sub_nilai_akhir = $sub_nilai_akhir + $nilai_akhir;

      }
          echo "<tr>
          <td style='color:red'>TOTAL :</td>
          <td></td>
          <td></td>
          <td></td>
          <td></td>
          <td></td>
          <td></td>
          <td></td>
          <td></td>
          <td></td>
          <td style='text-align: right; color:red'>".rp($sub_nilai_akhir)."</td>
          </tr>";

      //Untuk Memutuskan Koneksi Ke Database
      mysqli_close($db);   

    ?>
    </tbody>

  </table>

</div>
</center>

</div>