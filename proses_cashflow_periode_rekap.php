<?php 
include 'sanitasi.php';
include 'db.php';

$daftar_akun = stringdoang($_GET['kas_detail']);
$dari_tanggal = stringdoang($_GET['dari_tanggal']);
$sampai_tanggal = stringdoang($_GET['sampai_tanggal']);

        $sum_saldo1 = $db->query("SELECT SUM(debit) AS saldo1 FROM jurnal_trans WHERE DATE(waktu_jurnal) < '$dari_tanggal' AND kode_akun_jurnal = '$daftar_akun'");
        $cek_saldo1 = mysqli_fetch_array($sum_saldo1);
        $saldo1 = $cek_saldo1['saldo1'];

        $sum_saldo2 = $db->query("SELECT SUM(kredit) AS saldo2 FROM jurnal_trans WHERE DATE(waktu_jurnal) < '$dari_tanggal' AND kode_akun_jurnal = '$daftar_akun'");
        $cek_saldo2 = mysqli_fetch_array($sum_saldo2);
        $saldo2 = $cek_saldo2['saldo2'];

        $saldo = $saldo1 - $saldo2;


$select_masuk = $db->query("SELECT SUM(debit) AS masuk FROM jurnal_trans WHERE DATE(waktu_jurnal) >= '$dari_tanggal' AND  DATE(waktu_jurnal) <= '$sampai_tanggal' AND kode_akun_jurnal = '$daftar_akun' AND debit != '0' ");
 $outone = mysqli_fetch_array($select_masuk);
 $masuk = $outone['masuk'];

$select_keluar = $db->query("SELECT SUM(kredit) AS keluar FROM jurnal_trans WHERE DATE(waktu_jurnal) >= '$dari_tanggal' AND  DATE(waktu_jurnal) <= '$sampai_tanggal' AND kode_akun_jurnal = '$daftar_akun' AND kredit != '0' AND jenis_transaksi != 'Kas Mutasi' GROUP BY no_faktur");
 $outtwo = mysqli_fetch_array($select_keluar);
 $keluar = $outtwo['keluar'];

$select_mutasi = $db->query("SELECT SUM(debit) AS mutasi FROM jurnal_trans WHERE DATE(waktu_jurnal) >= '$dari_tanggal' AND  DATE(waktu_jurnal) <= '$sampai_tanggal' AND kode_akun_jurnal = '$daftar_akun' AND kredit != '0' AND jenis_transaksi = 'Kas Mutasi'");
 $outthree = mysqli_fetch_array($select_mutasi);
 $mutasi = $outthree['mutasi'];


$saldo_akhir = $masuk - $keluar - $mutasi;

$perubahan_saldo = $masuk - $keluar - $mutasi - $saldo;

if($saldo_akhir == 0 OR $saldo_akhir == '')
{
	$perubahan_saldo = 0;
}


$result = $db->query("SELECT keterangan,petugas,provinsi FROM registrasi ");
$row = mysqli_fetch_array($result);

$row['keterangan'] = $saldo;
$row['provinsi'] = $perubahan_saldo;
$row['petugas'] = $saldo_akhir;

 echo json_encode($row);
    exit;
 ?>