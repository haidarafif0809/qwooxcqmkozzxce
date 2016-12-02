<?php 
include 'header.php';
include 'sanitasi.php';
include 'db.php';


$dari_tanggal = stringdoang($_GET['dari_tanggal']);
$sampai_tanggal = stringdoang($_GET['sampai_tanggal']);

    $query1 = $db->query("SELECT * FROM perusahaan ");
    $data1 = mysqli_fetch_array($query1);

//menampilkan seluruh data yang ada pada tabel pembayaran_piutang
$perintah = $db->query("SELECT dpp.id, dpp.no_faktur_pembayaran, dpp.no_faktur_penjualan, dpp.tanggal, dpp.tanggal_jt, dpp.kredit, dpp.potongan, dpp.total, dpp.jumlah_bayar, dpp.kode_pelanggan, p.nama_pelanggan, pp.dari_kas, pp.total, da.nama_daftar_akun FROM detail_pembayaran_piutang dpp INNER JOIN pelanggan p ON dpp.kode_pelanggan = p.kode_pelanggan INNER JOIN pembayaran_piutang pp ON dpp.no_faktur_pembayaran = pp.no_faktur_pembayaran INNER JOIN daftar_akun da ON pp.dari_kas = da.kode_daftar_akun WHERE dpp.tanggal >= '$dari_tanggal' AND dpp.tanggal <= '$sampai_tanggal'");


//menampilkan seluruh data yang ada pada tabel pembayaran_piutang




$query01 = $db->query("SELECT SUM(potongan) AS total_potongan FROM detail_pembayaran_piutang WHERE tanggal >= '$dari_tanggal' AND tanggal <= '$sampai_tanggal'");
$cek01 = mysqli_fetch_array($query01);
$total_potongan = $cek01['total_potongan'];


$query02 = $db->query("SELECT SUM(total) AS total_akhir FROM pembayaran_piutang WHERE tanggal >= '$dari_tanggal' AND tanggal <= '$sampai_tanggal'");
$cek02 = mysqli_fetch_array($query02);
$total_akhir = $cek02['total_akhir'];



 ?>
<div class="container">
 <div class="row"><!--row1-->
        <div class="col-sm-2">
        <br><br>
                <img src='save_picture/<?php echo $data1['foto']; ?>' class='img-rounded' alt='Cinque Terre' width='160' height='140`'> 
        </div><!--penutup colsm2-->

        <div class="col-sm-6">
                 <h3> <b> LAPORAN PEMBAYARAN PIUTANG REKAP </b></h3>
                 <hr>
                 <h4> <b> <?php echo $data1['nama_perusahaan']; ?> </b> </h4> 
                 <p> <?php echo $data1['alamat_perusahaan']; ?> </p> 
                 <p> No.Telp:<?php echo $data1['no_telp']; ?> </p> 
                 
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


        
    </div><!--penutup row1-->
    <br>
    <br>
    <br>


<table id="tableuser" class="table table-bordered table-sm">
    <thead>
      <th> Nomor Faktur Pembayaran</th>
      <th> Nomor Faktur Penjualan</th>
      <th> Tanggal </th>
      <th> Kode Pelanggan </th>
      <th> Cara Bayar </th>
      <th> Potongan </th>
      <th> Jumlah Bayar </th>
      
      
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

      </table>
      <hr>
</div>
</div>


<div class="col-sm-9">
</div>


<div class="col-sm-3">
<h4><b>Total :</b> <?php echo rp($total_akhir); ?></h4>
</div>

 <script>
$(document).ready(function(){
  window.print();
});
</script>

<?php include 'footer.php'; ?>