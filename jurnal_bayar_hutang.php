<?php session_start();

    include 'sanitasi.php';
    include 'db.php';


$tahun_sekarang = date('Y');
$bulan_sekarang = date('m');
$tanggal_sekarang = date('Y-m-d');
$jam_sekarang = date('H:i:s');
$tahun_terakhir = substr($tahun_sekarang, 2);
$waktu = date('Y-m-d H:i:s');

$query = $db->query("SELECT * FROM pembayaran_hutang WHERE tanggal >= '2017-01-01' AND tanggal <= '$tanggal_sekarang'  ");
while ($data = mysqli_fetch_array($query)) {

$delete = $db->query("DELETE FROM jurnal_trans WHERE no_faktur = '$data[no_faktur_pembayaran]' ");	

$ambil_suplier = $db->query("SELECT nama FROM suplier WHERE id = '$data[nama_suplier]' ");
$ss = mysqli_fetch_array($ambil_suplier);

$select_setting_akun = $db->query("SELECT * FROM setting_akun");
$ambil_setting = mysqli_fetch_array($select_setting_akun);


$tbs_hutang = $db->query("SELECT SUM(potongan) AS potongan FROM detail_pembayaran_hutang WHERE no_faktur_pembayaran = '$data[no_faktur_pembayaran]'");
$data_tbs_pot = mysqli_fetch_array($tbs_hutang);

$potongan = $data_tbs_pot['potongan'];
$hutang = $data['total'] + $potongan;

	        //HUTANG    
        $insert_jurnal = $db->query("INSERT INTO jurnal_trans (nomor_jurnal,waktu_jurnal,keterangan_jurnal,kode_akun_jurnal,debit,kredit,jenis_transaksi,no_faktur,approved,user_buat) VALUES ('".no_jurnal()."', '$tanggal_sekarang $jam_sekarang', 'Pembayaran Hutang - $ss[nama]', '$ambil_setting[hutang]', '$hutang', '0', 'Pembayaran Hutang', '$data[no_faktur_pembayaran]','1', '$data[user_buat]')");

        //KAS
        $insert_juranl = $db->query("INSERT INTO jurnal_trans (nomor_jurnal,waktu_jurnal,keterangan_jurnal,kode_akun_jurnal,debit,kredit,jenis_transaksi,no_faktur,approved,user_buat) VALUES ('".no_jurnal()."', '$tanggal_sekarang $jam_sekarang', 'Pembayaran Hutang - $ss[nama]', '$data[dari_kas]', '0', '$data[total]', 'Pembayaran Hutang', '$data[no_faktur_pembayaran]','1', '$data[user_buat]')");



				if ($potongan != "" || $potongan != '0') {
				     //POTONGAN HUTANG    
				        $insert_jurnal = $db->query("INSERT INTO jurnal_trans (nomor_jurnal,waktu_jurnal,keterangan_jurnal,kode_akun_jurnal,debit,kredit,jenis_transaksi,no_faktur,approved,user_buat) VALUES ('".no_jurnal()."', '$tanggal_sekarang $jam_sekarang', 'Pembayaran Hutang - $ss[nama]', '$ambil_setting[potongan_hutang]', '0', '$potongan', 'Pembayaran Hutang', '$data[no_faktur_pembayaran]','1', '$data[user_buat]')");
				}
   echo "sukses";
	

	}


?>