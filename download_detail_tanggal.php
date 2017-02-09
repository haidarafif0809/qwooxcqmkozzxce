<?php // Fungsi header dengan mengirimkan raw data excel
header("Content-type: application/vnd-ms-excel");
 
// Mendefinisikan nama file ekspor "hasil-export.xls"
header("Content-Disposition: attachment; filename=cashflow_detail_pertanggal.xls");

include 'db.php';
include 'sanitasi.php';

$kas = stringdoang($_GET['kasnya']);
$tanggal = stringdoang($_GET['tanggalnya']);



$select_nama_kas = $db->query("SELECT nama_daftar_akun FROM daftar_akun WHERE kode_daftar_akun = '$kas'");
$out_kas = mysqli_fetch_array($select_nama_kas);


//QUERY MASUK
$query_masuk = $db->query("SELECT SUM(js.debit) AS masuk,js.jenis_transaksi,js.id,da.nama_daftar_akun,js.keterangan_jurnal,js.no_faktur,js.user_buat,js.user_edit,js.waktu_jurnal FROM jurnal_trans js LEFT JOIN daftar_akun da ON js.kode_akun_jurnal = da.kode_daftar_akun WHERE DATE(js.waktu_jurnal) = '$tanggal' AND js.kode_akun_jurnal = '$kas' AND js.debit != '0' GROUP BY js.no_faktur");

$jumlah_data_masuk = $db->query("SELECT SUM(debit) AS jumlah_masuk FROM jurnal_trans WHERE DATE(waktu_jurnal) = '$tanggal' AND kode_akun_jurnal = '$kas' AND debit != '0' AND jenis_transaksi != 'Kas Mutasi'");
$data_masuk = mysqli_fetch_array($jumlah_data_masuk);
$masuk = $data_masuk['jumlah_masuk'];
//QUERY MASUK


//QUERY KELUAR
$query_keluar = $db->query("SELECT SUM(js.kredit) AS keluar,js.jenis_transaksi,js.id,da.nama_daftar_akun,js.keterangan_jurnal,js.no_faktur,js.user_buat,js.user_edit,js.waktu_jurnal FROM jurnal_trans js LEFT JOIN daftar_akun da ON js.kode_akun_jurnal = da.kode_daftar_akun WHERE DATE(js.waktu_jurnal) = '$tanggal' AND js.kode_akun_jurnal = '$kas' AND js.kredit != '0' AND jenis_transaksi != 'Kas Mutasi' GROUP BY js.no_faktur");

$data_jumlah_keluar = $db->query("SELECT SUM(kredit) AS jumlah_keluar FROM jurnal_trans WHERE DATE(waktu_jurnal) = '$tanggal' AND kode_akun_jurnal = '$kas' AND kredit != '0' AND jenis_transaksi != 'Kas Mutasi'");
$data_keluar = mysqli_fetch_array($data_jumlah_keluar);
$keluar = $data_keluar['jumlah_keluar'];
//QUERY KELUAR


//QUERY MUTASI MASUK
$query_mutasi_masuk = $db->query("SELECT SUM(js.debit) AS mutasi_masuk,js.jenis_transaksi,js.id,da.nama_daftar_akun,js.keterangan_jurnal,js.no_faktur,js.user_buat,js.user_edit,js.waktu_jurnal FROM jurnal_trans js LEFT JOIN daftar_akun da ON js.kode_akun_jurnal = da.kode_daftar_akun WHERE DATE(js.waktu_jurnal) = '$tanggal' AND js.kode_akun_jurnal = '$kas' AND js.debit != '0' AND jenis_transaksi = 'Kas Mutasi' GROUP BY js.no_faktur");

$data_jumlah_mutasi_masuk = $db->query("SELECT SUM(debit) AS jumlah_mutasi_masuk FROM jurnal_trans 
	WHERE DATE(waktu_jurnal) = '$tanggal' AND kode_akun_jurnal = '$kas' AND debit != '0' AND jenis_transaksi = 'Kas Mutasi'");
$data_mutasi_masuk = mysqli_fetch_array($data_jumlah_mutasi_masuk);
$mutasi_masuk = $data_mutasi_masuk['jumlah_mutasi_masuk'];
//QUERY MUTASI MASUK


//QUERY MUTASI KELUAR
$query_mutasi_keluar = $db->query("SELECT SUM(js.kredit) AS mutasi_keluar,js.jenis_transaksi,js.id,da.nama_daftar_akun,js.keterangan_jurnal,js.no_faktur,js.user_buat,js.user_edit,js.waktu_jurnal FROM jurnal_trans js LEFT JOIN daftar_akun da ON js.kode_akun_jurnal = da.kode_daftar_akun WHERE DATE(js.waktu_jurnal) = '$tanggal' AND js.kode_akun_jurnal = '$kas' AND js.kredit != '0' AND jenis_transaksi = 'Kas Mutasi' GROUP BY js.no_faktur");

$data_jumlah_mutasi_keluar = $db->query("SELECT SUM(kredit) AS mutasi_keluar FROM jurnal_trans 
	WHERE DATE(waktu_jurnal) = '$tanggal' AND kode_akun_jurnal = '$kas' AND kredit != '0' 
	AND jenis_transaksi = 'Kas Mutasi'");
$data_mutasi_keluar = mysqli_fetch_array($data_jumlah_mutasi_keluar);
$mutasi_keluar = $data_mutasi_keluar['mutasi_keluar'];
//QUERY MUTASI KELUAR

        $sum_saldo1 = $db->query("SELECT SUM(debit) AS saldo1 FROM jurnal_trans WHERE DATE(waktu_jurnal) < '$tanggal' AND kode_akun_jurnal = '$kas'");
        $cek_saldo1 = mysqli_fetch_array($sum_saldo1);
        $saldo1 = $cek_saldo1['saldo1'];

        $sum_saldo2 = $db->query("SELECT SUM(kredit) AS saldo2 FROM jurnal_trans WHERE DATE(waktu_jurnal) < '$tanggal' AND kode_akun_jurnal = '$kas'");
        $cek_saldo2 = mysqli_fetch_array($sum_saldo2);
        $saldo2 = $cek_saldo2['saldo2'];

        $saldo = $saldo1 - $saldo2;

$total_keluar = $keluar + $mutasi_keluar;
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

if($mutasi_keluar == 0 OR $mutasi_keluar == '')
{
	$mutasi_keluar = 0;
}

if($mutasi_masuk == 0 OR $mutasi_masuk == '')
{
    $mutasi_masuk = 0;
}

 ?>

<div class="container"><!--DIV CONTAINER OPEN TABLE-->

<!--open table masuk-->
<div class="table-responsive"><!--membuat agar ada garis pada tabel disetiap kolom-->
<h4><b>Kas Masuk <u>Rp. <?php echo rp($masuk) ?></u> </b></h4>
<table id="detail_masuk" class="table table-hover table-sm">
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
            while ($out_masuk = mysqli_fetch_array($query_masuk))
            {

            $select_one = $db->query("SELECT da.nama_daftar_akun FROM jurnal_trans js LEFT JOIN daftar_akun da ON js.kode_akun_jurnal = da.kode_daftar_akun WHERE DATE(js.waktu_jurnal) = '$tanggal' 
				AND js.no_faktur = '$out_masuk[no_faktur]' AND js.kredit != '0'");
			$out_one = mysqli_fetch_array($select_one);

            echo "<tr>
                <td>". $out_masuk['no_faktur'] ."</td>
                <td>". $out_masuk['keterangan_jurnal'] ."</td>
                <td>". $out_one['nama_daftar_akun'] ."</td>
                <td>". $out_masuk['nama_daftar_akun'] ."</td>
                <td>". rp($out_masuk['masuk']) ."</td>
                <td>". $out_masuk['user_buat'] ."</td>
                <td>". $out_masuk['user_edit'] ."</td>
                <td>". $tanggal ."</td>
            <tr>";

            }
			?>

    </tbody>

  </table>
</div> <!--/ responsive-->
<hr><!--Closed table masuk-->


<!--open table KELUAR-->
<div class="table-responsive"><!--membuat agar ada garis pada tabel disetiap kolom-->
<h4><b>Kas Keluar <u>Rp. <?php echo rp($keluar) ?></u></b> </h4>
<table id="detail_keluar" class="table table-hover table-sm">
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
            while ($out_keluar = mysqli_fetch_array($query_keluar))
            {

	$select_two = $db->query("SELECT da.nama_daftar_akun FROM jurnal_trans js LEFT JOIN daftar_akun da ON js.kode_akun_jurnal = da.kode_daftar_akun WHERE DATE(js.waktu_jurnal) = '$tanggal' 
		AND js.no_faktur = '$out_keluar[no_faktur]' AND js.debit != '0'");
	$out_two = mysqli_fetch_array($select_two);

      echo "<tr>
                <td>". $out_keluar['no_faktur'] ."</td>
                <td>". $out_keluar['keterangan_jurnal'] ."</td>
                <td>". $out_two['nama_daftar_akun'] ."</td>
                <td>". $out_keluar['nama_daftar_akun'] ."</td>
                <td>". rp($out_keluar['keluar']) ."</td>
                <td>". $out_keluar['user_buat'] ."</td>
                <td>". $out_keluar['user_edit'] ."</td>
                <td>". $tanggal ."</td>

            <tr>";

            }
			?>
    </tbody>
  </table>
</div> <!--/ responsive-->
<hr><!--Closed table KELUAR-->


<!--open table MUTASI MASUK-->
<div class="table-responsive"><!--membuat agar ada garis pada tabel disetiap kolom-->
<h4><b>Kas Mutasi (Masuk) <u>Rp. <?php echo rp($mutasi_masuk) ?></u> </b></h4>
<table id="detail_mutasi_masuk" class="table table-hover table-sm">
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
    <tbody class="tbody_mutasi_in">

      <?php
            //menyimpan data sementara yang ada pada $perintah
            while ($out_mutasi = mysqli_fetch_array($query_mutasi_masuk))
            {

		$select_three = $db->query("SELECT da.nama_daftar_akun FROM jurnal_trans js LEFT JOIN daftar_akun da ON js.kode_akun_jurnal = da.kode_daftar_akun WHERE DATE(js.waktu_jurnal) = '$tanggal' 
		AND js.no_faktur = '$out_mutasi[no_faktur]' AND js.kredit != '0'");
	$out_three = mysqli_fetch_array($select_three);

      echo "<tr>
                <td>". $out_mutasi['no_faktur'] ."</td>
                <td>". $out_mutasi['keterangan_jurnal'] ."</td>
                <td>". $out_two['nama_daftar_akun'] ."</td>
                <td>". $out_mutasi['nama_daftar_akun'] ."</td>
                <td>". rp($out_three['mutasi_masuk']) ."</td>
                <td>". $out_mutasi['user_buat'] ."</td>
                <td>". $out_mutasi['user_edit'] ."</td>
                <td>". $tanggal ."</td>

            <tr>";

            }
			?>

    </tbody>

  </table>
</div> <!--/ responsive-->
<hr><!--Closed table MUTASI MASUK-->


<!--open table MUTASI KELUAR-->
<div class="table-responsive"><!--membuat agar ada garis pada tabel disetiap kolom-->
<h4><b>Kas Mutasi (Keluar)<u>Rp. <?php echo rp($mutasi_keluar) ?></u> </b></h4>
<table id="detail_mutasi" class="table table-hover table-sm">
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
    <tbody class="tbody_mutasi">

      <?php
            //menyimpan data sementara yang ada pada $perintah
            while ($out_mutasi_keluar = mysqli_fetch_array($query_mutasi_keluar))
            {

			$select_four = $db->query("SELECT da.nama_daftar_akun FROM jurnal_trans js LEFT JOIN daftar_akun da ON js.kode_akun_jurnal = da.kode_daftar_akun WHERE DATE(js.waktu_jurnal) = '$tanggal' 
				AND js.no_faktur = '$out_mutasi_keluar[no_faktur]' AND js.debit != '0'");
			$out_four = mysqli_fetch_array($select_four);


      echo "<tr>
                <td>". $out_mutasi_keluar['no_faktur'] ."</td>
                <td>". $out_mutasi_keluar['keterangan_jurnal'] ."</td>
                <td>". $out_mutasi_keluar['nama_daftar_akun'] ."</td>
                <td>". $out_four['nama_daftar_akun'] ."</td>
                <td>". rp($out_mutasi_keluar['mutasi_keluar']) ."</td>
                <td>". $out_mutasi_keluar['user_buat'] ."</td>
                <td>". $out_mutasi_keluar['user_edit'] ."</td>
                <td>". $tanggal ."</td>

            <tr>";

            }
			?>

    </tbody>

  </table>
</div> <!--/ responsive-->
<hr><!--Closed table MUTASI KELUAR-->

<div class="row">
<div class="col-sm-8">
		
<table style="font-size: 25">
<h3><b>Total Cashflow </b></h3>
<h3>
  <h4><tr> <td> Saldo Awal</td>   <td >:</td>  <td>Rp.</td> <td> <?php echo rp($saldo) ?></td> </tr>  </h4>
 <h4> <tr> <td> Perubahan Saldo</td><td>:</td> <td>Rp.</td> <td> <?php echo rp($perubahan_saldo) ?></td></tr></h4>
  <h4><tr> <td> Saldo Akhir</td>  <td>:</td>  <td>Rp.</td> <td> <?php echo rp($saldo_akhir) ?></td> </tr></h4>

</table>

</div><!--SM 8-->

<div class="col-sm-1">
</div>

<div class="col-sm-3">
</div>

</div>

</div><!--DIV CLOSED CONTAINER OPEN TABLE-->