<?php include_once 'session_login.php';
include 'header.php';
include 'db.php';
include 'sanitasi.php';

$kas = stringdoang($_GET['kas_detail']);
$dari_tanggal = stringdoang($_GET['dari_tanggal']);
$sampai_tanggal = stringdoang($_GET['sampai_tanggal']);


$select_comp = $db->query("SELECT * FROM perusahaan ");
$out_comp = mysqli_fetch_array($select_comp);

$select_nama_kas = $db->query("SELECT nama_daftar_akun FROM daftar_akun WHERE kode_daftar_akun = '$kas'");
$out_kas = mysqli_fetch_array($select_nama_kas);

//SUM SALDO AWAL 
        $sum_saldo1 = $db->query("SELECT SUM(debit) AS saldo1 FROM jurnal_trans WHERE DATE(waktu_jurnal) < '$dari_tanggal' AND kode_akun_jurnal = '$kas'");
        $cek_saldo1 = mysqli_fetch_array($sum_saldo1);
        $saldo1 = $cek_saldo1['saldo1'];

        $sum_saldo2 = $db->query("SELECT SUM(kredit) AS saldo2 FROM jurnal_trans WHERE DATE(waktu_jurnal) < '$dari_tanggal' AND kode_akun_jurnal = '$kas'");
        $cek_saldo2 = mysqli_fetch_array($sum_saldo2);
        $saldo2 = $cek_saldo2['saldo2'];



        $select_masuk = $db->query("SELECT SUM(debit) AS masuk FROM jurnal_trans WHERE DATE(waktu_jurnal) >= '$dari_tanggal' AND  DATE(waktu_jurnal) <= '$sampai_tanggal' AND kode_akun_jurnal = '$kas' AND debit != '0'  AND jenis_transaksi != 'Kas Mutasi' ");
         $outone = mysqli_fetch_array($select_masuk);
         $masuk = $outone['masuk'];

        $select_keluar = $db->query("SELECT SUM(kredit) AS keluar FROM jurnal_trans WHERE DATE(waktu_jurnal) >= '$dari_tanggal' AND  DATE(waktu_jurnal) <= '$sampai_tanggal' AND kode_akun_jurnal = '$kas' AND kredit != '0' AND jenis_transaksi != 'Kas Mutasi'");
         $outtwo = mysqli_fetch_array($select_keluar);
         $keluar = $outtwo['keluar'];

        $select_mutasi = $db->query("SELECT SUM(kredit) AS mutasi FROM jurnal_trans WHERE DATE(waktu_jurnal) >= '$dari_tanggal' AND  DATE(waktu_jurnal) <= '$sampai_tanggal' AND kode_akun_jurnal = '$kas' AND kredit != '0' AND jenis_transaksi = 'Kas Mutasi'");
         $outthree = mysqli_fetch_array($select_mutasi);
         $mutasi = $outthree['mutasi']; //MUTASI KELUARNYA

        $select_mutasi_masuk = $db->query("SELECT SUM(debit) AS mutasi FROM jurnal_trans WHERE DATE(waktu_jurnal) >= '$dari_tanggal' AND  DATE(waktu_jurnal) <= '$sampai_tanggal' AND kode_akun_jurnal = '$kas' AND debit != '0' AND jenis_transaksi = 'Kas Mutasi'");
         $outfour = mysqli_fetch_array($select_mutasi_masuk);
         $mutasi_masuk = $outfour['mutasi']; //MUTASI MASUKNY


        $total_keluar = $keluar + $mutasi;
        $total_masuk = $masuk + $mutasi_masuk;

        $saldo = $saldo1 - $saldo2;

        $saldo_akhir = $saldo + $total_masuk - $total_keluar;
        
        $perubahan_saldo = $saldo + $saldo_akhir - $saldo - $saldo;
        
        if($saldo_akhir == 0 OR $saldo_akhir == '')
        {
        $perubahan_saldo = 0;
        }

//END SALDO AWAL



//QUERY KAS MASUK
$select_masuk = $db->query("SELECT SUM(js.debit) AS masuk,js.jenis_transaksi,js.id,da.nama_daftar_akun,js.keterangan_jurnal,js.no_faktur,js.user_buat,js.user_edit,js.waktu_jurnal FROM jurnal_trans js LEFT JOIN daftar_akun da ON js.kode_akun_jurnal = da.kode_daftar_akun WHERE DATE(js.waktu_jurnal) >= '$dari_tanggal' AND DATE(js.waktu_jurnal) <= '$sampai_tanggal' AND js.kode_akun_jurnal = '$kas' AND js.debit != '0' AND jenis_transaksi != 'Kas Mutasi' GROUP BY js.no_faktur ORDER BY js.id ASC");

$select_masuk_jumlah = $db->query("SELECT SUM(debit) AS masuk_jumlah FROM jurnal_trans WHERE DATE(waktu_jurnal) >= '$dari_tanggal' AND DATE(waktu_jurnal) <= '$sampai_tanggal' AND kode_akun_jurnal = '$kas' AND debit != '0' AND jenis_transaksi != 'Kas Mutasi'");
$out_masuk_jumlah = mysqli_fetch_array($select_masuk_jumlah);
//END QUERY MASUK


//START QUERY KELUAR
$select_keluar = $db->query("SELECT SUM(js.kredit) AS keluar,js.jenis_transaksi,js.id,da.nama_daftar_akun,js.keterangan_jurnal,js.no_faktur,js.user_buat,js.user_edit,js.waktu_jurnal FROM jurnal_trans js LEFT JOIN daftar_akun da ON js.kode_akun_jurnal = da.kode_daftar_akun WHERE DATE(js.waktu_jurnal) >= '$dari_tanggal' AND DATE(js.waktu_jurnal) <= '$sampai_tanggal' AND js.kode_akun_jurnal = '$kas' AND js.kredit != '0' AND jenis_transaksi != 'Kas Mutasi' GROUP BY js.no_faktur");

$select_keluar_jumlah = $db->query("SELECT SUM(kredit) AS keluar_jumlah FROM jurnal_trans WHERE DATE(waktu_jurnal) >= '$dari_tanggal' AND DATE(waktu_jurnal) <= '$sampai_tanggal' AND kode_akun_jurnal = '$kas' AND kredit != '0' AND jenis_transaksi != 'Kas Mutasi'");
$out_keluar_jumlah = mysqli_fetch_array($select_keluar_jumlah);
// END QUERY KELUAR


//START QUERY MUTASI MASUK
$select_mutasi_masuk = $db->query("SELECT SUM(js.debit) AS mutasi_masuk,js.jenis_transaksi,js.id,da.nama_daftar_akun,js.keterangan_jurnal,js.no_faktur,js.user_buat,js.user_edit,js.waktu_jurnal FROM jurnal_trans js LEFT JOIN daftar_akun da ON js.kode_akun_jurnal = da.kode_daftar_akun WHERE DATE(js.waktu_jurnal) >= '$dari_tanggal' AND DATE(js.waktu_jurnal) <= '$sampai_tanggal' AND js.kode_akun_jurnal = '$kas' AND js.debit != '0' AND jenis_transaksi = 'Kas Mutasi' GROUP BY js.no_faktur ");

$select_mutasi_masuk_jumlah = $db->query("SELECT SUM(debit) AS mutasi_masuk_jumlah FROM jurnal_trans WHERE DATE(waktu_jurnal) >= '$dari_tanggal' AND DATE(waktu_jurnal) <= '$sampai_tanggal' AND kode_akun_jurnal = '$kas' AND debit != '0' AND jenis_transaksi = 'Kas Mutasi'");
$out_mutasi_masuk_jumlah = mysqli_fetch_array($select_mutasi_masuk_jumlah);
// END QUERY MUTASI MASUK


//START QUERY MUTASI MASUK
$select_mutasi_keluar = $db->query("SELECT SUM(js.kredit) AS keluar,js.jenis_transaksi,js.id,da.nama_daftar_akun,js.keterangan_jurnal,js.no_faktur,js.user_buat,js.user_edit,js.waktu_jurnal FROM jurnal_trans js LEFT JOIN daftar_akun da ON js.kode_akun_jurnal = da.kode_daftar_akun WHERE DATE(js.waktu_jurnal) >= '$dari_tanggal' AND DATE(js.waktu_jurnal) <= '$sampai_tanggal' AND js.kode_akun_jurnal = '$kas' AND js.kredit != '0' AND jenis_transaksi = 'Kas Mutasi' GROUP BY js.no_faktur ");


$select_mutasi_keluar_jumlah = $db->query("SELECT SUM(kredit) AS mutasi_keluar_jumlah FROM jurnal_trans WHERE DATE(waktu_jurnal) >= '$dari_tanggal' AND DATE(waktu_jurnal) <= '$sampai_tanggal' AND kode_akun_jurnal = '$kas' AND kredit != '0' AND jenis_transaksi = 'Kas Mutasi'");
$out_mutasi_keluar_jumlah = mysqli_fetch_array($select_mutasi_keluar_jumlah);
// END QUERY MUTASI MASUK




?>


<div class="container">
    <h3> <center><b> CASHFLOW DETAIL PERPERIODE</b></center></h3><hr>
    <div class="row"><!--row1-->
        <div class="col-sm-2">
                <img src='save_picture/<?php echo $out_comp['foto']; ?>' class='img-rounded' alt='Cinque Terre' width='160' height='140`'> 
        </div><!--penutup colsm2-->

        <div class="col-sm-6">
                 <h4> <b> <?php echo $out_comp['nama_perusahaan']; ?> </b> </h4> 
                 <p> <?php echo $out_comp['alamat_perusahaan']; ?> <br>
                  No.Telp:<?php echo $out_comp['no_telp']; ?> </p> 
                 
        </div><!--penutup colsm4-->

        <div class="col-sm-4">
        <br>
            <table>
              <tbody>

               <tr><td> Kas <td>:&nbsp;</td><td><?php echo $out_kas['nama_daftar_akun']; ?></td></td></tr>
               <tr><td> Tanggal <td>:&nbsp;</td><td><?php echo tanggal($dari_tanggal);?> - <?php echo tanggal($sampai_tanggal);?></td></td></tr>
               <tr><td> Petugas <td>:&nbsp;</td><td><?php echo $_SESSION['nama']; ?></td></td></tr>
               
              </tbody>
            </table>            
        </div><!--penutup colsm4-->

        <div class="col-sm-2">
  
        </div><!--penutup colsm4-->


        
    </div><!--penutup row1-->
    <hr>





<div class="table-responsive"><!--membuat agar ada garis pada tabel disetiap kolom-->
<h4><b>Kas Masuk <u>Rp. <?php echo rp($out_masuk_jumlah['masuk_jumlah']) ?></u></b> </h4>
<table id="table_masuk" class="table table-bordered table-sm">
    <thead>
      
      <th> No Faktur </th>
      <th> Keterangan </th>
      <th> Dari Akun </th>
      <th> Ke Akun </th>
      <th> Total </th>
      <th> Petugas </th>
      <th> Petugas Edit </th>
      <th> Waktu</th>
            
    </thead>
    <tbody class="tbody_masuk">
       <?php
            //menyimpan data sementara yang ada pada $perintah
            while ($out_masuk = mysqli_fetch_array($select_masuk))
            {

                //$select = $db->query("SELECT da.nama_daftar_akun FROM jurnal_trans js LEFT JOIN daftar_akun da ON js.kode_akun_jurnal = da.kode_daftar_akun WHERE DATE(js.waktu_jurnal) >= '$dari_tanggal' AND DATE(js.waktu_jurnal) <= '$sampai_tanggal' AND js.no_faktur = '$out_masuk[no_faktur]' AND js.kredit != '0'");
                //$out = mysqli_fetch_array($select);

            echo "<tr>
                <td>". $out_masuk['no_faktur'] ."</td>
                <td>". $out_masuk['keterangan_jurnal'] ."</td>
                <td>". $out_masuk['jenis_transaksi'] ."</td>
                <td>". $out_masuk['nama_daftar_akun'] ."</td>
                <td>". $out_masuk['masuk'] ."</td>
                <td>". $out_masuk['user_buat'] ."</td>
                <td>". $out_masuk['user_edit'] ."</td>
                <td>". $out_masuk['waktu_jurnal'] ."</td>
            <tr>";

            }
      ?>
    </tbody>

  </table>
</div> <!--/ responsive-->
<hr>

<!--Table Kas Keluar-->
<div class="table-responsive"><!--membuat agar ada garis pada tabel disetiap kolom-->
<h4><b>Kas Keluar <u>Rp. <?php echo rp($out_keluar_jumlah['keluar_jumlah']) ?></u> </b></h4>
<table id="table_keluar" class="table table-bordered table-sm">
    <thead>

      <th> No Faktur </th>
      <th> Keterangan </th>
      <th> Dari Akun </th>
      <th> Ke Akun </th>
      <th> Total </th>
      <th> Petugas </th>
      <th> Petugas Edit </th>
      <th> Waktu</th>
            
    </thead>
    <tbody class="tbody_keluar">
       <?php
            //menyimpan data sementara yang ada pada $perintah
            while ($out_keluar = mysqli_fetch_array($select_keluar))
            {

                //$select = $db->query("SELECT da.nama_daftar_akun FROM jurnal_trans js LEFT JOIN daftar_akun da ON js.kode_akun_jurnal = da.kode_daftar_akun WHERE DATE(js.waktu_jurnal) >= '$dari_tanggal' AND DATE(js.waktu_jurnal) <= '$sampai_tanggal' AND js.no_faktur = '$out_keluar[no_faktur]' AND js.debit != '0'");
               // $out = mysqli_fetch_array($select);

            echo "<tr>
                <td>". $out_keluar['no_faktur'] ."</td>
                <td>". $out_keluar['keterangan_jurnal'] ."</td>
                <td>". $out_keluar['nama_daftar_akun'] ."</td>
                <td>". $out_keluar['jenis_transaksi'] ."</td>
                <td>". $out_keluar['keluar'] ."</td>
                <td>". $out_keluar['user_buat'] ."</td>
                <td>". $out_keluar['user_edit'] ."</td>
                <td>". $out_keluar['waktu_jurnal'] ."</td>
            <tr>";

            }
      ?>

    </tbody>

  </table>
</div> <!--/ responsive-->
<hr>

<!--Table Mutasi Kas Masuk-->
<div class="table-responsive"><!--membuat agar ada garis pada tabel disetiap kolom-->
<h4><b>Kas Mutasi (Masuk) <u>Rp. <?php echo rp($out_mutasi_masuk_jumlah['mutasi_masuk_jumlah']) ?></u> </b></h4>
<table id="table_keluar" class="table table-bordered table-sm">
    <thead>

      <th> No Faktur </th>
      <th> Keterangan </th>
      <th> Dari Akun </th>
      <th> Ke Akun </th>
      <th> Total </th>
      <th> Petugas </th>
      <th> Petugas Edit </th>
      <th> Waktu</th>
            
    </thead>
    <tbody class="tbody_keluar">
       <?php
            //menyimpan data sementara yang ada pada $perintah
            while ($out_keluar = mysqli_fetch_array($select_mutasi_masuk))
            {

                $select = $db->query("SELECT da.nama_daftar_akun FROM jurnal_trans js LEFT JOIN daftar_akun da ON js.kode_akun_jurnal = da.kode_daftar_akun WHERE DATE(js.waktu_jurnal) >= '$dari_tanggal' AND DATE(js.waktu_jurnal) <= '$sampai_tanggal' AND js.no_faktur = '$out_keluar[no_faktur]' AND js.kredit != '0'");
                $out = mysqli_fetch_array($select);

            echo "<tr>
                <td>". $out_keluar['no_faktur'] ."</td>
                <td>". $out_keluar['keterangan_jurnal'] ."</td>
                <td>". $out['nama_daftar_akun'] ."</td>
                <td>". $out_keluar['nama_daftar_akun'] ."</td>
                <td>". $out_keluar['mutasi_masuk'] ."</td>
                <td>". $out_keluar['user_buat'] ."</td>
                <td>". $out_keluar['user_edit'] ."</td>
                <td>". $out_keluar['waktu_jurnal'] ."</td>
            <tr>";

            }
      ?>

    </tbody>

  </table>
</div> <!--/ responsive-->
<hr>

<!--Table Mutasi Kas Masuk-->
<div class="table-responsive"><!--membuat agar ada garis pada tabel disetiap kolom-->
<h4><b>Kas Mutasi (Keluar) <u>Rp. <?php echo rp($out_mutasi_keluar_jumlah['mutasi_keluar_jumlah']) ?></u> </b></h4>
<table id="table_keluar" class="table table-bordered table-sm">
    <thead>

      <th> No Faktur </th>
      <th> Keterangan </th>
      <th> Dari Akun </th>
      <th> Ke Akun </th>
      <th> Total </th>
      <th> Petugas </th>
      <th> Petugas Edit </th>
      <th> Waktu</th>
    </thead>
    <tbody class="tbody_keluar">
       <?php
            //menyimpan data sementara yang ada pada $perintah
            while ($out_keluar = mysqli_fetch_array($select_mutasi_keluar))
            {
                $select = $db->query("SELECT da.nama_daftar_akun FROM jurnal_trans js LEFT JOIN daftar_akun da ON js.kode_akun_jurnal = da.kode_daftar_akun WHERE DATE(js.waktu_jurnal) >= '$dari_tanggal' AND DATE(js.waktu_jurnal) <= '$sampai_tanggal' AND js.no_faktur = '$out_keluar[no_faktur]' AND js.debit != '0'");
                $out = mysqli_fetch_array($select);

            echo "<tr>
                <td>". $out_keluar['no_faktur'] ."</td>
                <td>". $out_keluar['keterangan_jurnal'] ."</td>
                <td>". $out_keluar['nama_daftar_akun'] ."</td>
                <td>". $out['nama_daftar_akun'] ."</td>
                <td>". $out_keluar['keluar'] ."</td>
                <td>". $out_keluar['user_buat'] ."</td>
                <td>". $out_keluar['user_edit'] ."</td>
                <td>". $out_keluar['waktu_jurnal'] ."</td>
            <tr>";

            }
      ?>

    </tbody>

  </table>
</div> <!--/ responsive-->
<hr>

<div class="col-sm-8">
    
    <table style="font-size: 25">
    <h4><b>Total Cashflow </b></h4>

     <tr><td width="50%"><font class="satu">Saldo Awal</font></td> <td> :&nbsp;</td> <td><font class="satu"> <?php echo rp($saldo); ?> </font></tr>
     <tr><td width="50%"><font class="satu">Perubahan Saldo</font></td> <td> :&nbsp;</td> <td><font class="satu"> <?php echo rp($perubahan_saldo); ?></font> </tr>
        <tr><td width="50%"><font class="satu">Saldo Akhir</font></td> <td> :&nbsp;</td> <td><font class="satu"> <?php echo rp($saldo_akhir); ?></font> </tr>

    </table>

</div>

<div class="col-sm-2">
</div>

<div class="col-sm-2">
    Petugas<br>
            <br>
            <br>
            <br>

<?php echo $_SESSION['nama'] ?><b><br>
</div>
  
</div><!--end container table-->



<style type="text/css">
/*unTUK mengatur ukuran font*/
   .satu {
   font-size: 20px;
   }
</style>

<script>
$(document).ready(function(){
  window.print();
});
</script>





<?php include 'footer.php'; ?>