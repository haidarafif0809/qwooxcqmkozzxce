<?php session_start();
include 'db.php';
include_once 'sanitasi.php';


$session_id = session_id();
$tahun_sekarang = date('Y');
$bulan_sekarang = date('m');
$tanggal_sekarang = date('Y-m-d');
$jam_sekarang = date('H:i:sa');
$tahun_terakhir = substr($tahun_sekarang, 2);


try {
    // First of all, let's begin a transaction
$db->begin_transaction();
    // A set of queries; if one fails, an exception should be thrown

//mengecek jumlah karakter dari bulan sekarang
$cek_jumlah_bulan = strlen($bulan_sekarang);

//jika jumlah karakter dari bulannya sama dengan 1 maka di tambah 0 di depannya
if ($cek_jumlah_bulan == 1) {
  # code...
  $data_bulan_terakhir = "0".$bulan_sekarang;
 }
 else
 {
  $data_bulan_terakhir = $bulan_sekarang;

 }
//ambil bulan dari tanggal penjualan terakhir

 $bulan_terakhir = $db->query("SELECT MONTH(tanggal) as bulan FROM penjualan ORDER BY id DESC LIMIT 1");
 $v_bulan_terakhir = mysqli_fetch_array($bulan_terakhir);

//ambil nomor  dari penjualan terakhir
$no_terakhir = $db->query("SELECT no_faktur FROM penjualan ORDER BY id DESC LIMIT 1");
 $v_no_terakhir = mysqli_fetch_array($no_terakhir);
$ambil_nomor = substr($v_no_terakhir['no_faktur'],0,-8);

/*jika bulan terakhir dari penjualan tidak sama dengan bulan sekarang, 
maka nomor nya kembali mulai dari 1 ,
jika tidak maka nomor terakhir ditambah dengan 1
 
 */
 if ($v_bulan_terakhir['bulan'] != $bulan_sekarang) {
  # code...
echo $no_faktur = "1/JL/".$data_bulan_terakhir."/".$tahun_terakhir;

 }

 else
 {

$nomor = 1 + $ambil_nomor ;

echo $no_faktur = $nomor."/JL/".$data_bulan_terakhir."/".$tahun_terakhir;


 }



$no_rm = stringdoang($_POST['kode_pelanggan']);
$nama_pelanggan = stringdoang($_POST['nama_pelanggan']);


if ($no_rm == "" || $nama_pelanggan == "") {

$no_rm = "Umum";
$nama_pelanggan = "Umum";

}
else{

$no_rm = stringdoang($_POST['kode_pelanggan']);
$nama_pelanggan = stringdoang($_POST['nama_pelanggan']);

}

$petugas_radiologi = stringdoang($_POST['petugas_radiologi']);
$nama_petugas = stringdoang($_SESSION['nama']);
$petugas = $_SESSION['id'];
$ppn_input = stringdoang($_POST['ppn_input']);
$penjamin = stringdoang($_POST['penjamin']);
$user = $_SESSION['nama'];
$keterangan = stringdoang($_POST['keterangan']);
$total = angkadoang($_POST['total']);
$total2 = angkadoang($_POST['total2']);
$potongan = angkadoang($_POST['potongan']);
$tax = angkadoang($_POST['tax']);
$biaya_admin = angkadoang($_POST['biaya_admin']);
$sisa_pembayaran = angkadoang($_POST['sisa_pembayaran']);
$sisa = angkadoang($_POST['sisa']);
$cara_bayar = stringdoang($_POST['cara_bayar']);
$pembayaran = angkadoang($_POST['pembayaran']);
$tanggal_jt = stringdoang($_POST['tanggal_jt']);
$dokter_pengirim = stringdoang($_POST['dokter']);
$tanggal_jt = tanggal_mysql($tanggal_jt);
$no_jurnal = no_jurnal();

$id_userr = $db->query("SELECT id FROM user WHERE nama = '$user'");
$data_id = mysqli_fetch_array($id_userr);
$id_kasir = $data_id['id'];

    $select_kode_pelanggan = $db->query("SELECT nama_pelanggan FROM pelanggan WHERE kode_pelanggan = '$no_rm'");
    $ambil_kode_pelanggan = mysqli_fetch_array($select_kode_pelanggan);


    $query = $db->query("SELECT * FROM tbs_penjualan_radiologi WHERE session_id = '$session_id' AND no_reg = '' ");
    while ($data = mysqli_fetch_array($query))
      {
        
    
        $query2 = "INSERT INTO detail_penjualan (no_faktur,no_rm, tanggal, jam, kode_barang, nama_barang, jumlah_barang, harga, subtotal, potongan, tax, sisa,tipe_produk,radiologi) VALUES ('$no_faktur','$no_rm', '$tanggal_sekarang', '$jam_sekarang', '$data[kode_barang]','$data[nama_barang]','$data[jumlah_barang]','$data[harga]','$data[subtotal]','$data[potongan]','$data[tax]', '$data[jumlah_barang]','$data[tipe_barang]','$data[radiologi]')";

        if ($db->query($query2) === TRUE) {
        } 

        else {
        echo "Error: " . $query2 . "<br>" . $db->error;
        }
        
      }



    $sisa = angkadoang($_POST['sisa']);    
    $pembayaran = stringdoang($_POST['pembayaran']);
    $total = stringdoang($_POST['total']);
    $tunai_i = $pembayaran - $total;

          if ($tunai_i >= 0) 

            {

              $ket_jurnal = "Penjualan Radiologi Lunas ".$ambil_kode_pelanggan['nama_pelanggan']." ";
              
              $stmt1 = $db->prepare("INSERT INTO penjualan (nama, no_faktur, penjamin, petugas_radiologi, kode_pelanggan, total, tanggal, jam, user, sales, status, potongan, tax, sisa, cara_bayar, tunai, status_jual_awal, keterangan, ppn,jenis_penjualan,biaya_admin, no_faktur_jurnal, keterangan_jurnal, dokter) VALUES (?,?,?,?,?,?,?,?,?,?,'Lunas',?,?,?,?,?,'Tunai',?,?,'Radiologi',?,?,?,?)");
              
    // hubungkan "data" dengan prepared statements
              $stmt1->bind_param("sssssissssiiisississs",
              $nama_pelanggan, $no_faktur, $penjamin, $petugas_radiologi, $no_rm, $total, $tanggal_sekarang, $jam_sekarang, $user, $id_kasir, $potongan, $tax, $sisa, $cara_bayar, $pembayaran, $keterangan, $ppn_input,$biaya_admin,$no_jurnal,$ket_jurnal,$dokter_pengirim);
    // jalankan query
              $stmt1->execute();




    // cek query
if (!$stmt1) 
      {
        die('Query Error : '.$db->errno.
          ' - '.$db->error);
      }

else 
      {
    
      }

            
              
 }
              


            else if ($tunai_i < 0)
              
            {
              
             $pembayaran = stringdoang($_POST['pembayaran']);
    $total = stringdoang($_POST['total']);
    $piutang_1 = $total - $pembayaran;
     
              $ket_jurnal = "Penjualan Radiologi Piutang ".$ambil_kode_pelanggan['nama_pelanggan']." ";

              
              $stmt = $db->prepare("INSERT INTO penjualan (nama, no_faktur, penjamin, petugas_radiologi, kode_pelanggan, total, tanggal, tanggal_jt, jam, user, sales, status, potongan, tax, kredit, nilai_kredit, cara_bayar, tunai, status_jual_awal, keterangan, ppn,jenis_penjualan,biaya_admin, no_faktur_jurnal, keterangan_jurnal,dokter) VALUES (?,?,?,?,?,?,?,?,?,?,?,'Piutang',?,?,?,?,?,?,'Kredit',?,?,'Radiologi',?,?,?,?)");
              

              $stmt->bind_param("sssssisssssiiiisisiisss",
              $nama_pelanggan, $no_faktur, $penjamin, $petugas_radiologi, $no_rm, $total , $tanggal_sekarang, $tanggal_jt, $jam_sekarang, $user, $id_kasir, $potongan, $tax, $piutang_1, $piutang_1, $cara_bayar, $pembayaran, $keterangan, $ppn_input,$biaya_admin,$no_jurnal,$ket_jurnal,$dokter_pengirim);


              
              // jalankan query
              $stmt->execute();
              
              


    // cek query
if (!$stmt) 
      {
        die('Query Error : '.$db->errno.
          ' - '.$db->error);
      }

else 
      {
    
      }



   
}




    $query3 = $db->query("DELETE  FROM tbs_penjualan_radiologi WHERE session_id = '$session_id'");


    // If we arrive here, it means that no exception was thrown
    // i.e. no query has failed, and we can commit the transaction
    $db->commit();
} catch (Exception $e) {
    // An exception has been thrown
    // We must rollback the transaction
    $db->rollback();
}

//Untuk Memutuskan Koneksi Ke Database
mysqli_close($db);   
    
    ?>
