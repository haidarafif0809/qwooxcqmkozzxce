<?php session_start();
include 'header.php';
include 'sanitasi.php';
include 'db.php';


$dari_tanggal = stringdoang($_GET['dari_tanggal']);
$sampai_tanggal = stringdoang($_GET['sampai_tanggal']);
$suplier = stringdoang($_GET['suplier']);
$jumlah_bayar_hutang = 0;


if ($suplier == "semua") {

// LOGIKA UNTUK AMBIL BERDASARKAN KONSUMEN DAN SALES (QUERY TAMPIL AWAL)
  $query_sum_dari_pembelian = $db->query("SELECT SUM(tunai) AS tunai_pembelian,SUM(total) AS total_akhir, SUM(kredit) AS total_kredit FROM pembelian WHERE tanggal >= '$dari_tanggal' AND tanggal <= '$sampai_tanggal' AND kredit != 0 ");
  $data_sum_dari_pembelian = mysqli_fetch_array($query_sum_dari_pembelian);

  $query_faktur_pembelian = $db->query("SELECT no_faktur FROM pembelian WHERE tanggal >= '$dari_tanggal' AND tanggal <= '$sampai_tanggal' AND kredit != 0 ");
  while ($data_faktur_pembelian = mysqli_fetch_array($query_faktur_pembelian)) {
    $query_sum_dari_detail_pembayaran_hutang = $db->query("SELECT SUM(jumlah_bayar) + SUM(potongan) AS ambil_total_bayar FROM detail_pembayaran_hutang WHERE no_faktur_pembelian = '$data_faktur_pembelian[no_faktur]' ");
    $data_sum_dari_detail_pembayaran_hutang = mysqli_fetch_array($query_sum_dari_detail_pembayaran_hutang);
    $jumlah_bayar_hutang = $jumlah_bayar_hutang + $data_sum_dari_detail_pembayaran_hutang['ambil_total_bayar'];
  }
// LOGIKA UNTUK  UNTUK AMBIL  BERDASARKAN KONSUMEN DAN SALES (QUERY TAMPIL AWAL)

}
else{

// LOGIKA UNTUK AMBIL BERDASARKAN KONSUMEN DAN SALES (QUERY TAMPIL AWAL)
  $query_sum_dari_pembelian = $db->query("SELECT SUM(tunai) AS tunai_pembelian,SUM(total) AS total_akhir, SUM(kredit) AS total_kredit FROM pembelian WHERE tanggal >= '$dari_tanggal' AND tanggal <= '$sampai_tanggal' AND kredit != 0 AND suplier = '$suplier' ");
  $data_sum_dari_pembelian = mysqli_fetch_array($query_sum_dari_pembelian);

  $query_faktur_pembelian = $db->query("SELECT no_faktur FROM pembelian WHERE tanggal >= '$dari_tanggal' AND tanggal <= '$sampai_tanggal' AND kredit != 0 AND suplier = '$suplier' ");
  while ($data_faktur_pembelian = mysqli_fetch_array($query_faktur_pembelian)) {
    $query_sum_dari_detail_pembayaran_hutang = $db->query("SELECT SUM(jumlah_bayar) + SUM(potongan) AS ambil_total_bayar FROM detail_pembayaran_hutang WHERE no_faktur_pembelian = '$data_faktur_pembelian[no_faktur]' ");
    $data_sum_dari_detail_pembayaran_hutang = mysqli_fetch_array($query_sum_dari_detail_pembayaran_hutang);
    $jumlah_bayar_hutang = $jumlah_bayar_hutang + $data_sum_dari_detail_pembayaran_hutang['ambil_total_bayar'];
  }
// LOGIKA UNTUK  UNTUK AMBIL  BERDASARKAN KONSUMEN DAN SALES (QUERY TAMPIL AWAL)

}

$total_akhir = $data_sum_dari_pembelian['total_akhir'];
$total_kredit = $data_sum_dari_pembelian['total_kredit'];
$total_bayar = $data_sum_dari_pembelian['tunai_pembelian'] +  $jumlah_bayar_hutang;

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
                 <h3> <b> LAPORAN PEMBELIAN HUTANG /SUPLIER </b></h3>
                 <hr>
                 <h4> <b> <?php echo $data_perusahaan['nama_perusahaan']; ?> </b> </h4> 
                 <p> <?php echo $data_perusahaan['alamat_perusahaan']; ?> </p> 
                 <p> No.Telp:<?php echo $data_perusahaan['no_telp']; ?> </p> 
                 
        </div><!--penutup colsm4-->

        <div class="col-sm-4">
         <br><br>                 
          <table>
            <tbody>

                <tr><td  width="20%">PERIODE</td> <td> &nbsp;:&nbsp; </td> <td> <?php echo tanggal($dari_tanggal); ?> s/d <?php echo tanggal($sampai_tanggal); ?></td>
                </tr>
                      
            </tbody>
          </table>           
                 
        </div><!--penutup colsm4-->

</div><!--penutup row-->
<hr>

 <table id="tableuser" class="table table-bordered table-sm">
  <thead>
    <th style="background-color: #4CAF50; color: white;"> Nomor Faktur </th>
    <th style="background-color: #4CAF50; color: white;"> Suplier </th>
    <th style="background-color: #4CAF50; color: white;"> Tgl. Transaksi</th>
    <th style="background-color: #4CAF50; color: white;"> Tgl. Jatuh Tempo</th>
    <th style="background-color: #4CAF50; color: white;"> Umur Hutang </th>
    <th style="background-color: #4CAF50; color: white;"> Nilai Faktur </th>
    <th style="background-color: #4CAF50; color: white;"> Dibayar </th>
    <th style="background-color: #4CAF50; color: white;"> Hutang </th>
  </thead>
  <tbody>

  <?php

  if ($suplier == "semua") {

    $query_pembelian = $db->query("SELECT p.id,s.nama,p.tanggal,p.tanggal_jt, DATEDIFF(DATE(NOW()), p.tanggal) AS usia_hutang ,p.no_faktur,p.suplier,p.total,p.jam,p.status,p.potongan,p.tax,p.sisa,p.kredit ,p.nilai_kredit FROM pembelian p INNER JOIN suplier s ON p.suplier = s.id WHERE p.tanggal >= '$dari_tanggal' AND p.tanggal <= '$sampai_tanggal' AND p.kredit != 0 ORDER BY p.waktu_input DESC");

  }
  else{

    $query_pembelian = $db->query("SELECT p.id,s.nama,p.tanggal,p.tanggal_jt, DATEDIFF(DATE(NOW()), p.tanggal) AS usia_hutang ,p.no_faktur,p.suplier,p.total,p.jam,p.status,p.potongan,p.tax,p.sisa,p.kredit ,p.nilai_kredit FROM pembelian p INNER JOIN suplier s ON p.suplier = s.id WHERE p.tanggal >= '$dari_tanggal' AND p.tanggal <= '$sampai_tanggal' AND p.kredit != 0 AND p.suplier = '$suplier' ORDER BY p.waktu_input DESC");

  }

    while ($data_pembelian = mysqli_fetch_array($query_pembelian)){
      
      $query_nilai_bayar_hutang = $db->query("SELECT SUM(jumlah_bayar) + SUM(potongan) AS total_bayar FROM detail_pembayaran_hutang WHERE no_faktur_pembelian = '$data_pembelian[no_faktur]' ");
      $data_nilai_bayar_hutang = mysqli_fetch_array($query_nilai_bayar_hutang);
      
      $query_sum_tunai_pembelian = $db->query("SELECT SUM(tunai) AS tunai_pembelian FROM pembelian WHERE no_faktur = '$data_pembelian[no_faktur]' ");
      $data_sum_tunai_pembelian = mysqli_fetch_array($query_sum_tunai_pembelian);
      
      $jumlah_bayar_awal = $data_sum_tunai_pembelian['tunai_pembelian'];
      
      $jumlah_nilai_bayar_hutang = mysqli_num_rows($query_nilai_bayar_hutang);
      
      $tot_bayar = $data_nilai_bayar_hutang['total_bayar'] + $jumlah_bayar_awal;
      $sisa_kredit = $data_pembelian['nilai_kredit'] - $data_nilai_bayar_hutang['total_bayar'];

        echo "<tr>

          <td>". $data_pembelian['no_faktur'] ."</td>
          <td>". $data_pembelian['nama'] ."</td>
          <td>". $data_pembelian['tanggal'] ."</td>
          <td>". $data_pembelian['tanggal_jt'] ."</td>
          <td align='right'>". rp ($data_pembelian['usia_hutang']) ." Hari</td>
          <td align='right'>". rp ($data_pembelian['total']) ."</td>";
        
        if ($jumlah_nilai_bayar_hutang > 0 ){
          echo "<td align='right'>". rp($tot_bayar) ."</td>";
        }
        else{ 
          echo "<td align='right'>0</td>";         
        }

        if ($sisa_kredit < 0 ){
          echo "<td align='right'>0</td>";
        }
        else{ 
          echo "<td align='right'>". rp($sisa_kredit) ."</td>";
        }

        echo "</tr>";
    }


        echo "<tr>

          <td style='color:red'>TOTAL</td>
          <td style='color:red'>-</td>
          <td style='color:red'>-</td>
          <td style='color:red'>-</td>
          <td style='color:red' align='right'>-</td>
          <td style='color:red' align='right'>".rp($total_akhir)."</td>
          <td style='color:red' align='right'>".rp($total_bayar)."</td>
          <td style='color:red' align='right'>".rp($total_kredit)."</td>

        </tr>";

   //Untuk Memutuskan Koneksi Ke Database
   mysqli_close($db);

  ?>
  </tbody>
</table>

<hr>
<div class="row">  
    <div class="col-sm-2">
    <font class="satu"><b>Petugas <br><br><br> <font class="satu"><?php echo $_SESSION['nama']; ?></font></b></font>
    </div> <!--/ col-sm-6-->
</div>

</div> <!-- / CONTAINER -->


<script>
$(document).ready(function(){
  window.print();
});
</script>


<?php include 'footer.php'; ?>