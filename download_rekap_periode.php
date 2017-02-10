<?php 
// Fungsi header dengan mengirimkan raw data excel
header("Content-type: application/vnd-ms-excel");
 
// Mendefinisikan nama file ekspor "hasil-export.xls"
header("Content-Disposition: attachment; filename=CashflowRekapPeriode.xls");

include 'db.php';
include 'sanitasi.php';

$kas = stringdoang($_GET['kas_rekap']);
$dari_tanggal = stringdoang($_GET['dari_tanggal']);
$sampai_tanggal = stringdoang($_GET['sampai_tanggal']);



//SUM SALDO AWAL 
        $sum_saldo1 = $db->query("SELECT SUM(debit) AS saldo1 FROM jurnal_trans WHERE DATE(waktu_jurnal) < '$dari_tanggal' AND kode_akun_jurnal = '$kas'");
        $cek_saldo1 = mysqli_fetch_array($sum_saldo1);
        $saldo1 = $cek_saldo1['saldo1'];

        $sum_saldo2 = $db->query("SELECT SUM(kredit) AS saldo2 FROM jurnal_trans WHERE DATE(waktu_jurnal) < '$dari_tanggal' AND kode_akun_jurnal = '$kas'");
        $cek_saldo2 = mysqli_fetch_array($sum_saldo2);
        $saldo2 = $cek_saldo2['saldo2'];

        $saldo = $saldo1 - $saldo2;

//END SALDO AWAL



//QUERY KAS MASUK
$select_masuk = $db->query("SELECT SUM(js.debit) AS masuk,js.jenis_transaksi,js.id,da.nama_daftar_akun,DATE(js.waktu_jurnal) AS tanggal,js.no_faktur FROM jurnal_trans js LEFT JOIN daftar_akun da ON js.kode_akun_jurnal = da.kode_daftar_akun WHERE DATE(js.waktu_jurnal) >= '$dari_tanggal' AND DATE(js.waktu_jurnal) <= '$sampai_tanggal' AND js.kode_akun_jurnal = '$kas' AND js.debit != '0' AND js.jenis_transaksi != 'Kas Mutasi' GROUP BY DATE(js.waktu_jurnal)");

$select_masuk_jumlah = $db->query("SELECT SUM(debit) AS masuk_jumlah FROM jurnal_trans WHERE DATE(waktu_jurnal) >= '$dari_tanggal' AND DATE(waktu_jurnal) <= '$sampai_tanggal' AND kode_akun_jurnal = '$kas' AND debit != '0' AND jenis_transaksi != 'Kas Mutasi' ");
$out_masuk_jumlah = mysqli_fetch_array($select_masuk_jumlah);
$masuk = $out_masuk_jumlah['masuk_jumlah'];
//END QUERY MASUK


//START QUERY KELUAR
$select_keluar = $db->query("SELECT SUM(js.kredit) AS keluar,js.jenis_transaksi,js.id,da.nama_daftar_akun,DATE(js.waktu_jurnal) AS tanggal,js.no_faktur FROM jurnal_trans js LEFT JOIN daftar_akun da ON js.kode_akun_jurnal = da.kode_daftar_akun WHERE DATE(js.waktu_jurnal) >= '$dari_tanggal' AND DATE(js.waktu_jurnal) <= '$sampai_tanggal' AND js.kode_akun_jurnal = '$kas' AND js.kredit != '0' AND jenis_transaksi != 'Kas Mutasi' GROUP BY DATE(js.waktu_jurnal)");

$select_keluar_jumlah = $db->query("SELECT SUM(kredit) AS keluar_jumlah FROM jurnal_trans WHERE DATE(waktu_jurnal) >= '$dari_tanggal' AND DATE(waktu_jurnal) <= '$sampai_tanggal' AND kode_akun_jurnal = '$kas' AND kredit != '0' AND jenis_transaksi != 'Kas Mutasi'");
$out_keluar_jumlah = mysqli_fetch_array($select_keluar_jumlah);
$keluar = $out_keluar_jumlah['keluar_jumlah'];
// END QUERY KELUAR


//START QUERY MUTASI MASUK
$select_mutasi_masuk = $db->query("SELECT SUM(js.debit) AS mutasi_masuk,js.jenis_transaksi,js.id,da.nama_daftar_akun,DATE(js.waktu_jurnal) AS tanggal,js.no_faktur FROM jurnal_trans js LEFT JOIN daftar_akun da ON js.kode_akun_jurnal = da.kode_daftar_akun WHERE DATE(js.waktu_jurnal) >= '$dari_tanggal' AND DATE(js.waktu_jurnal) <= '$sampai_tanggal' AND js.kode_akun_jurnal = '$kas' AND js.debit != '0' AND jenis_transaksi = 'Kas Mutasi' GROUP BY DATE(js.waktu_jurnal)");

$select_mutasi_masuk_jumlah = $db->query("SELECT SUM(debit) AS mutasi_masuk_jumlah FROM jurnal_trans WHERE DATE(waktu_jurnal) >= '$dari_tanggal' AND DATE(waktu_jurnal) <= '$sampai_tanggal' AND kode_akun_jurnal = '$kas' AND debit != '0' AND jenis_transaksi = 'Kas Mutasi'");
$out_mutasi_masuk_jumlah = mysqli_fetch_array($select_mutasi_masuk_jumlah);
$mutasi_masuk = $out_mutasi_masuk_jumlah['mutasi_masuk_jumlah'];
// END QUERY MUTASI MASUK


//START QUERY MUTASI KELUAR
$select_mutasi_keluar = $db->query("SELECT SUM(js.kredit) AS keluar,js.jenis_transaksi,js.id,da.nama_daftar_akun,DATE(js.waktu_jurnal) AS tanggal,js.no_faktur FROM jurnal_trans js LEFT JOIN daftar_akun da ON js.kode_akun_jurnal = da.kode_daftar_akun WHERE DATE(js.waktu_jurnal) >= '$dari_tanggal' AND DATE(js.waktu_jurnal) <= '$sampai_tanggal' AND js.kode_akun_jurnal = '$kas' AND js.kredit != '0' AND jenis_transaksi = 'Kas Mutasi' GROUP BY DATE(js.waktu_jurnal)");

$select_mutasi_keluar_jumlah = $db->query("SELECT SUM(kredit) AS mutasi_keluar_jumlah FROM jurnal_trans WHERE DATE(waktu_jurnal) >= '$dari_tanggal' AND DATE(waktu_jurnal) <= '$sampai_tanggal' AND kode_akun_jurnal = '$kas' AND kredit != '0' AND jenis_transaksi = 'Kas Mutasi'");
$out_mutasi_keluar_jumlah = mysqli_fetch_array($select_mutasi_keluar_jumlah);
$mutasi = $out_mutasi_keluar_jumlah['mutasi_keluar_jumlah'];
// END QUERY MUTASI KELUAR


$total_keluar = $keluar + $mutasi;
$total_masuk = $masuk + $mutasi_masuk;

$saldo_akhir = $saldo + $total_masuk - $total_keluar;

$perubahan_saldo = $saldo + $saldo_akhir - $saldo - $saldo;
if($saldo_akhir == 0 OR $saldo_akhir == '')
{
  $perubahan_saldo = 0;
}
if($masuk == 0 OR $masuk == '')
{
  $masuk = 0;
}

if($keluar == 0 OR $keluar == '')
{
  $keluar = 0;
}

if($mutasi == 0 OR $mutasi == '')
{
  $mutasi = 0;
}

if($mutasi_masuk == 0 OR $mutasi_masuk == '')
{
  $mutasi_masuk = 0;
}



 ?>


<div class="container">
<center><h3>Cashflow Detail Periode <?php echo tanggal($dari_tanggal); ?> - <?php echo tanggal($sampai_tanggal); ?></h3></center>




<div class="table-responsive"><!--membuat agar ada garis pada tabel disetiap kolom-->
<h4><b>Kas Masuk <u>Rp. <?php echo rp($masuk) ?></u></b> </h4>
<table id="table_masuk" class="table table-bordered table-sm">
    <thead>
      
            <th style="background-color: #4CAF50; color: white;"> Waktu </th>
            <th style="background-color: #4CAF50; color: white;"> Dari Akun </th>
            <th style="background-color: #4CAF50; color: white;"> Ke Akun </th>
            <th style="background-color: #4CAF50; color: white;"> Total </th>            
    </thead>
    <tbody class="tbody_masuk">
       <?php
            //menyimpan data sementara yang ada pada $perintah
            while ($out_masuk = mysqli_fetch_array($select_masuk))
            {

                $select = $db->query("SELECT da.nama_daftar_akun FROM jurnal_trans js LEFT JOIN daftar_akun da ON js.kode_akun_jurnal = da.kode_daftar_akun WHERE DATE(js.waktu_jurnal) >= '$dari_tanggal' AND DATE(js.waktu_jurnal) <= '$sampai_tanggal' AND js.no_faktur = '$out_masuk[no_faktur]' AND js.kredit != '0'");
                $out = mysqli_fetch_array($select);

                $select_setting_akun = $db->query("SELECT sa.total_penjualan, da.nama_daftar_akun FROM setting_akun sa INNER JOIN daftar_akun da ON sa.total_penjualan = da.kode_daftar_akun");
                $ambil_setting = mysqli_fetch_array($select_setting_akun);
            echo "<tr>
                <td>". $out_masuk['tanggal'] ."</td>";
                
                 
                if ($out_masuk['jenis_transaksi'] == 'Penjualan') {
                      echo "<td>". $ambil_setting['nama_daftar_akun'] ."</td>";
                  }
                  elseif ($out_masuk['jenis_transaksi'] == 'Kas Masuk') {
                    echo "<td>Kas Masuk</td>";
                  }

                echo "<td>". $out_masuk['nama_daftar_akun'] ."</td>
                <td>". $out_masuk['masuk'] ."</td>
            <tr>";

            }
      ?>
    </tbody>

  </table>
</div> <!--/ responsive-->
<!--Table Kas Keluar-->
<div class="table-responsive"><!--membuat agar ada garis pada tabel disetiap kolom-->
<h4><b>Kas Keluar <u>Rp. <?php echo rp($keluar) ?></u> </b></h4>
<table id="table_keluar" class="table table-bordered table-sm">
    <thead>

            <th style="background-color: #4CAF50; color: white;"> Waktu </th>
            <th style="background-color: #4CAF50; color: white;"> Dari Akun </th>
            <th style="background-color: #4CAF50; color: white;"> Ke Akun </th>
            <th style="background-color: #4CAF50; color: white;"> Total </th>
            
    </thead>
    <tbody class="tbody_keluar">
       <?php
            //menyimpan data sementara yang ada pada $perintah
            while ($out_keluar = mysqli_fetch_array($select_keluar))
            {

                $select = $db->query("SELECT da.nama_daftar_akun FROM jurnal_trans js LEFT JOIN daftar_akun da ON js.kode_akun_jurnal = da.kode_daftar_akun WHERE DATE(js.waktu_jurnal) >= '$dari_tanggal' AND DATE(js.waktu_jurnal) <= '$sampai_tanggal' AND js.no_faktur = '$out_keluar[no_faktur]' AND js.debit != '0'");
                $out = mysqli_fetch_array($select);

            echo "<tr>
                <td>". $out_keluar['tanggal'] ."</td>
                <td>". $out_keluar['nama_daftar_akun'] ."</td>
                <td>". $out['nama_daftar_akun'] ."</td>
                <td>". $out_keluar['keluar'] ."</td>
                </tr>";

            }
      ?>

    </tbody>

  </table>
</div> <!--/ responsive-->

<!--Table Mutasi Kas Masuk-->
<div class="table-responsive"><!--membuat agar ada garis pada tabel disetiap kolom-->
<h4><b>Kas Mutasi (Masuk) <u>Rp. <?php echo rp($mutasi_masuk) ?></u> </b></h4>
<table id="table_keluar" class="table table-bordered table-sm">
    <thead>
            
            <th style="background-color: #4CAF50; color: white;"> Waktu </th>
            <th style="background-color: #4CAF50; color: white;"> Dari Akun </th>
            <th style="background-color: #4CAF50; color: white;"> Ke Akun </th>
            <th style="background-color: #4CAF50; color: white;"> Total </th>
            
    </thead>
    <tbody class="tbody_keluar">
       <?php
            //menyimpan data sementara yang ada pada $perintah
            while ($out_keluar = mysqli_fetch_array($select_mutasi_masuk))
            {

                $select = $db->query("SELECT da.nama_daftar_akun FROM jurnal_trans js LEFT JOIN daftar_akun da ON js.kode_akun_jurnal = da.kode_daftar_akun WHERE DATE(js.waktu_jurnal) >= '$dari_tanggal' AND DATE(js.waktu_jurnal) <= '$sampai_tanggal' AND js.no_faktur = '$out_keluar[no_faktur]' AND js.kredit != '0'");
                $out = mysqli_fetch_array($select);

            echo "<tr>
                <td>". $out_keluar['tanggal'] ."</td>
                <td>". $out['nama_daftar_akun'] ."</td>
                <td>". $out_keluar['nama_daftar_akun'] ."</td>
                <td>". $out_keluar['mutasi_masuk'] ."</td>
            <tr>";

            }
      ?>

    </tbody>

  </table>
</div> <!--/ responsive-->

<!--Table Mutasi Kas Masuk-->
<div class="table-responsive"><!--membuat agar ada garis pada tabel disetiap kolom-->
<h4><b>Kas Mutasi (Keluar) <u>Rp. <?php echo rp($mutasi) ?></u> </b></h4>
<table id="table_keluar" class="table table-bordered table-sm">
    <thead>

            <th style="background-color: #4CAF50; color: white;"> Waktu </th>
            <th style="background-color: #4CAF50; color: white;"> Dari Akun </th>
            <th style="background-color: #4CAF50; color: white;"> Ke Akun </th>
            <th style="background-color: #4CAF50; color: white;"> Total </th>
    </thead>
    <tbody class="tbody_keluar">
       <?php
            //menyimpan data sementara yang ada pada $perintah
            while ($out_keluar = mysqli_fetch_array($select_mutasi_keluar))
            {
                $select = $db->query("SELECT da.nama_daftar_akun FROM jurnal_trans js LEFT JOIN daftar_akun da ON js.kode_akun_jurnal = da.kode_daftar_akun WHERE DATE(js.waktu_jurnal) >= '$dari_tanggal' AND DATE(js.waktu_jurnal) <= '$sampai_tanggal' AND js.no_faktur = '$out_keluar[no_faktur]' AND js.debit != '0'");
                $out = mysqli_fetch_array($select);

            echo "<tr>
                <td>". $out_keluar['tanggal'] ."</td>
                <td>". $out_keluar['nama_daftar_akun'] ."</td>
                <td>". $out['nama_daftar_akun'] ."</td>
                <td>". $out_keluar['keluar'] ."</td>
            <tr>";

            }
      ?>

    </tbody>

  </table>
</div> <!--/ responsive-->

    <table style="font-size: 25">
     <tr><td width="50%"><font class="satu">Total Cashflow</font></td>  </font></tr>

     <tr><td width="50%"><font class="satu">Saldo Awal</font></td> <td> :&nbsp;</td> <td><font class="satu"> <?php echo rp($saldo); ?> </font></tr>
     <tr><td width="50%"><font class="satu">Perubahan Saldo</font></td> <td> :&nbsp;</td> <td><font class="satu"> <?php echo rp($perubahan_saldo); ?></font> </tr>
        <tr><td width="50%"><font class="satu">Saldo Akhir</font></td> <td> :&nbsp;</td> <td><font class="satu"> <?php echo rp($saldo_akhir); ?></font> </tr>

    </table>

</div> <!--Closed Container-->