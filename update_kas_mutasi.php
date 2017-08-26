<?php session_start();
include 'sanitasi.php';
include 'db.php';

$no_faktur = stringdoang($_POST['no_faktur']);

$tahun_sekarang = date('Y');
$bulan_sekarang = date('m');
$tanggal_sekarang = date('Y-m-d');
$jam_sekarang = date('H:i:s');
$tahun_terakhir = substr($tahun_sekarang, 2);
$tanggal = stringdoang($_POST['tanggal']);
$waktu = date('Y-m-d H:i:s');



$hapus_jurnal = $db->query("DELETE FROM jurnal_trans WHERE no_faktur = '$no_faktur'");


$query = $db->prepare("UPDATE kas_mutasi SET dari_akun= ?, ke_akun = ?, keterangan = ?, jumlah = ?, tanggal = ?, jam = ? , waktu_edit = ?, user_edit = ? WHERE id = ?");

$query->bind_param("sssissssi",
	$dari_akun, $ke_akun, $keterangan, $jumlah_baru, $tanggal, $jam_sekarang, $waktu , $user, $id);

$id = stringdoang($_POST['id']);
$keterangan = stringdoang($_POST['keterangan']);
$jumlah = angkadoang($_POST['jumlah']);
$jumlah_baru = angkadoang($_POST['jumlah_baru']);
$ke_akun = stringdoang($_POST['ke_akun']);
$dari_akun = stringdoang($_POST['dari_akun']);
$user = $_SESSION['user_name'];
$tanggal = stringdoang($_POST['tanggal']);


$query->execute();



    if (!$query) 
    {
    die('Query Error : '.$db->errno.
    ' - '.$db->error);
    }
    else 
    {
    echo "sukses";
    }


//jurnal
$no_faktur = stringdoang($_POST['no_faktur']);

    $ambil_tbs = $db->query("SELECT * FROM kas_mutasi WHERE no_faktur = '$no_faktur'");
    while ($ambil = mysqli_fetch_array($ambil_tbs))

{


      $insert_jurnal = $db->query("INSERT INTO jurnal_trans (nomor_jurnal,waktu_jurnal,keterangan_jurnal,kode_akun_jurnal,debit,kredit,jenis_transaksi,no_faktur,approved,user_buat,user_edit) VALUES ('".no_jurnal()."', '$tanggal $jam_sekarang', 'Transaksi Kas Mutasi ke $ke_akun_select[nama_daftar_akun]','$ambil[ke_akun]', '$ambil[jumlah]', '0', 'Kas Mutasi', '$no_faktur','1', '$user', '$user')");


      $insert_jurnal2 = $db->query("INSERT INTO jurnal_trans (nomor_jurnal,waktu_jurnal,keterangan_jurnal,kode_akun_jurnal,debit,kredit,jenis_transaksi,no_faktur,approved,user_buat,user_edit) VALUES ('".no_jurnal()."', '$tanggal $jam_sekarang', 'Transaksi Kas Mutasi dari $dari_akun_select[nama_daftar_akun]','$ambil[dari_akun]', '0', '$ambil[jumlah]', 'Kas Mutasi', '$no_faktur','1', '$user', '$user')");

}


    //Untuk Memutuskan Koneksi Ke Database
mysqli_close($db);   
?>