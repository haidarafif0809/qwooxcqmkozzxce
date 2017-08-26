<?php session_start();
    
    include 'sanitasi.php';
    include 'db.php';


    $no_faktur = stringdoang($_POST['no_faktur']);

$tahun_sekarang = date('Y');
$bulan_sekarang = date('m');
$tanggal_sekarang = date('Y-m-d');
$jam_sekarang = date('H:i:s');
$tahun_terakhir = substr($tahun_sekarang, 2);
$waktu = date('Y-m-d H:i:s');

$query5 = $db->query("DELETE FROM detail_kas_keluar WHERE no_faktur = '$no_faktur'");  
$hapus_jurnal = $db->query("DELETE FROM jurnal_trans WHERE no_faktur = '$no_faktur'");

// buat prepared statements
    $stmt = $db->prepare("UPDATE kas_keluar SET no_faktur = ?, dari_akun = ?, keterangan = ?, jumlah = ?, tanggal = ?, jam = ?, user_edit = ? , waktu_edit = ? WHERE no_faktur = ?");

// hubungkan "data" dengan prepared statements
        $stmt->bind_param("sssisssss", 
        $no_faktur, $dari_akun, $keterangan, $jumlah, $tanggal,  $jam, $user, $waktu, $no_faktur);

// siapkan "data" query
        $no_faktur = stringdoang($_POST['no_faktur']);
        $tanggal = stringdoang($_POST['tanggal']);
         $jam = stringdoang($_POST['jam']);
         $keterangan = stringdoang($_POST['keterangan']);
        $dari_akun = stringdoang($_POST['dari_akun']);
        $jumlah = angkadoang($_POST['jumlah']);
        $user = $_SESSION['user_name'];
        $user_buat = stringdoang($_POST['user_buat']);
        $no_faktur = stringdoang($_POST['no_faktur']);

// jalankan query
        $stmt->execute();

    

   $query1 = $db->query("SELECT * FROM tbs_kas_keluar WHERE no_faktur = '$no_faktur'");

    while ($data=mysqli_fetch_array($query1)) {

    $query2 = $db->query("INSERT INTO detail_kas_keluar (no_faktur,keterangan,dari_akun,ke_akun,jumlah,tanggal,jam,user) VALUES ('$no_faktur','$data[keterangan]','$data[dari_akun]','$data[ke_akun]','$data[jumlah]','$data[tanggal]','$data[jam]','$data[user]')");
    
    }


//jurnal



   $ambil_tbs = $db->query("SELECT * FROM detail_kas_keluar WHERE no_faktur = '$no_faktur'");
    while ($ambil = mysqli_fetch_array($ambil_tbs))

{


      $insert_jurnal = $db->query("INSERT INTO jurnal_trans (nomor_jurnal,waktu_jurnal,keterangan_jurnal,kode_akun_jurnal,debit,kredit,jenis_transaksi,no_faktur,approved,user_buat, user_edit) VALUES ('".no_jurnal()."', '$tanggal $jam', 'Transaksi Kas Keluar - $ambil[keterangan]','$ambil[dari_akun]', '0', '$ambil[jumlah]', 'Kas Keluar', '$no_faktur','1', '$user_buat', '$user')");


      $insert_jurnal2 = $db->query("INSERT INTO jurnal_trans (nomor_jurnal,waktu_jurnal,keterangan_jurnal,kode_akun_jurnal,debit,kredit,jenis_transaksi,no_faktur,approved,user_buat, user_edit) VALUES ('".no_jurnal()."', '$tanggal $jam', 'Transaksi Kas Keluar - $ambil[keterangan]','$ambil[ke_akun]', '$ambil[jumlah]', '0', 'Kas Keluar', '$no_faktur','1', '$user_buat', '$user')");

}
    $query3 = $db->query("DELETE FROM tbs_kas_keluar WHERE no_faktur = '$no_faktur'");                      
  
//Untuk Memutuskan Koneksi Ke Database
mysqli_close($db);   
    ?>