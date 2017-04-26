<?php
include 'db.php';
include 'sanitasi.php';

$dari_tanggal = stringdoang($_GET['dari_tanggal']);
$sampai_tanggal = stringdoang($_GET['sampai_tanggal']);


$query_jurnal_persediaan = $db->query("SELECT no_faktur,debit,kredit ,waktu_jurnal FROM jurnal_trans WHERE kode_akun_jurnal = '1-1301' AND jenis_transaksi = 'Penjualan' AND DATE(waktu_jurnal) >= '$dari_tanggal' AND DATE(waktu_jurnal) <= '$sampai_tanggal' GROUP BY no_faktur ");


while ($data_jurnal_persediaan = mysqli_fetch_array($query_jurnal_persediaan)) {
# code...

# code...
$query_hpp_masuk = $db->query("SELECT SUM(total_nilai) AS total_nilai FROM hpp_keluar WHERE no_faktur = '$data_jurnal_persediaan[no_faktur]'");
$data_hpp_masuk = mysqli_fetch_array($query_hpp_masuk);

$nilai_persediaan_asli = $data_hpp_masuk['total_nilai'];

$nilai_persediaan_jurnal = $data_jurnal_persediaan['debit'];


	if ($nilai_persediaan_asli != $nilai_persediaan_jurnal ){

	$update_persediaan = $db->query("UPDATE jurnal_trans SET kredit = '$nilai_persediaan_asli' , debit = '0' WHERE kode_akun_jurnal = '1-1301' AND no_faktur = '$data_jurnal_persediaan[no_faktur]'");

	$update_persediaan2 = $db->query("UPDATE jurnal_trans SET debit = '$nilai_persediaan_asli', kredit = '0' WHERE kode_akun_jurnal = '5-1100' AND no_faktur = '$data_jurnal_persediaan[no_faktur]'");

	}

}

echo "selesai";
?>