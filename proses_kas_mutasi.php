<?php session_start();

    include 'sanitasi.php';
    include 'db.php';

$tahun_sekarang = date('Y');
$bulan_sekarang = date('m');
$tanggal_sekarang = date('Y-m-d');
$jam_sekarang = date('H:i:sa');
$waktu = date('Y-m-d H:i:sa');


 //ambil 2 angka terakhir dari tahun sekarang 
$tahun = $db->query("SELECT YEAR(NOW()) as tahun");
$v_tahun = mysqli_fetch_array($tahun);
 $tahun_terakhir = substr($v_tahun['tahun'], 2);
//ambil bulan sekarang
$bulan = $db->query("SELECT MONTH(NOW()) as bulan");
$v_bulan = mysqli_fetch_array($bulan);
$v_bulan['bulan'];


//mengecek jumlah karakter dari bulan sekarang
$cek_jumlah_bulan = strlen($v_bulan['bulan']);

//jika jumlah karakter dari bulannya sama dengan 1 maka di tambah 0 di depannya
if ($cek_jumlah_bulan == 1) {
  # code...
  $data_bulan_terakhir = "0".$v_bulan['bulan'];
 }
 else
 {
  $data_bulan_terakhir = $v_bulan['bulan'];

 }
//ambil bulan dari tanggal penjualan terakhir

 $bulan_terakhir = $db->query("SELECT MONTH(waktu_input) as bulan FROM kas_mutasi ORDER BY id DESC LIMIT 1");
 $v_bulan_terakhir = mysqli_fetch_array($bulan_terakhir);

//ambil nomor  dari penjualan terakhir
$no_terakhir = $db->query("SELECT no_faktur FROM kas_mutasi ORDER BY id DESC LIMIT 1");
 $v_no_terakhir = mysqli_fetch_array($no_terakhir);
$ambil_nomor = substr($v_no_terakhir['no_faktur'],0,-8);

/*jika bulan terakhir dari penjualan tidak sama dengan bulan sekarang, 
maka nomor nya kembali mulai dari 1 ,
jika tidak maka nomor terakhir ditambah dengan 1
 
 */
 if ($v_bulan_terakhir['bulan'] != $v_bulan['bulan']) {
  # code...
$no_faktur = "1/KMT/".$data_bulan_terakhir."/".$tahun_terakhir;

 }

 else
 {

$nomor = 1 + $ambil_nomor ;

$no_faktur = $nomor."/KMT/".$data_bulan_terakhir."/".$tahun_terakhir;


 }



    $perintah = $db->prepare("INSERT INTO kas_mutasi (no_faktur,keterangan,dari_akun,ke_akun,jumlah,tanggal,jam,user)
			VALUES (?,?,?,?,?,?,?,?) ");

    $perintah->bind_param("ssssisss",
        $no_faktur, $keterangan, $dari_akun, $ke_akun, $jumlah, $tanggal_sekarang, $jam_sekarang, $user);

    $keterangan = stringdoang($_POST['keterangan']);
    $dari_akun = stringdoang($_POST['dari_akun']);
    $ke_akun = stringdoang($_POST['ke_akun']);
    $tanggal = stringdoang($_POST['tanggal']);
    $jumlah = angkadoang($_POST['jumlah']);
    $user = $_SESSION['user_name'];

    $perintah->execute();



if (!$perintah) {
   die('Query Error : '.$db->errno.
   ' - '.$db->error);
}
else {
    header ('location:kas_mutasi.php');

}


//jurnal

    $dari_akun = stringdoang($_POST['dari_akun']);
    $ke_akun = stringdoang($_POST['ke_akun']);


    $ambil_tbs = $db->query("SELECT * FROM kas_mutasi WHERE no_faktur = '$no_faktur'");
    while ($ambil = mysqli_fetch_array($ambil_tbs))

{


      $insert_jurnal = $db->query("INSERT INTO jurnal_trans (nomor_jurnal,waktu_jurnal,keterangan_jurnal,kode_akun_jurnal,debit,kredit,jenis_transaksi,no_faktur,approved,user_buat) VALUES ('".no_jurnal()."', '$waktu', 'Transaksi Kas Mutasi  - $ambil[keterangan]','$ambil[ke_akun]', '$ambil[jumlah]', '0', 'Kas Mutasi', '$no_faktur','1', '$user')");


      $insert_jurnal2 = $db->query("INSERT INTO jurnal_trans (nomor_jurnal,waktu_jurnal,keterangan_jurnal,kode_akun_jurnal,debit,kredit,jenis_transaksi,no_faktur,approved,user_buat) VALUES ('".no_jurnal()."', '$waktu', 'Transaksi Kas Mutasi  - $ambil[keterangan]','$ambil[dari_akun]', '0', '$ambil[jumlah]', 'Kas Mutasi', '$no_faktur','1', '$user')");

}


//Untuk Memutuskan Koneksi Ke Database
mysqli_close($db);   

    ?>