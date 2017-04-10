<?php include 'session_login.php';
include 'db.php';
include 'sanitasi.php';

 $reg = stringdoang($_POST['reg_before']); 
 $bed_before = stringdoang($_POST['bed_before']); 
 $group_bed_before = stringdoang($_POST['group_bed_before']); 
 $group_bed2 = stringdoang($_POST['group_bed2']); 
 $bed2 = stringdoang($_POST['bed2']); 
 $id = angkadoang($_POST['id']);
 $lama_inap = angkadoang($_POST['lama_inap']);
 $ruangan = angkadoang($_POST['ruangan']);
 $id_ruangan2 = angkadoang($_POST['id_ruangan2']);

$jam =  date("H:i:s");
$tanggal_sekarang = date("Y-m-d");
$waktu = date("Y-m-d H:i:s");


$pilih_akses_penjualan = $db->query("SELECT penjualan_tambah FROM otoritas_penjualan WHERE id_otoritas = '$_SESSION[otoritas_id]'");
$penjualan = mysqli_fetch_array($pilih_akses_penjualan);

$pilih_akses_rekam_medik = $db->query("SELECT rekam_medik_ri_lihat FROM otoritas_rekam_medik WHERE id_otoritas = '$_SESSION[otoritas_id]'");
$rekam_medik = mysqli_fetch_array($pilih_akses_rekam_medik);


$update_reg = $db->query("UPDATE registrasi SET ruangan = '$id_ruangan2', bed = '$bed2', group_bed = '$group_bed2' WHERE no_reg = '$reg'");

$update_kamar = $db->query("UPDATE bed SET sisa_bed = sisa_bed + 1 WHERE nama_kamar = '$bed_before' AND group_bed = '$group_bed_before' AND ruangan = '$ruangan' ");

$up_bed = $db->query("UPDATE bed SET sisa_bed = sisa_bed - 1 WHERE nama_kamar = '$bed2' AND group_bed = '$group_bed2'AND ruangan = '$id_ruangan2'");


// ambil penjamin dari registrasi
$query_registrasi = $db->query("SELECT penjamin, tanggal FROM registrasi WHERE no_reg = '$reg' ");
$data_registrasi = mysqli_fetch_array($query_registrasi);
// ambil penjamin dari registrasi


// ambil bahan untuk kamar 
$query_penjamin = $db->query(" SELECT harga FROM penjamin WHERE nama = '$data_registrasi[penjamin]'");
$data_penjamin  = mysqli_fetch_array($query_penjamin);
$level_harga = $data_penjamin['harga'];


$cari_harga_kamar = $db->query("SELECT tarif,tarif_2,tarif_3,tarif_4,tarif_5,tarif_6,tarif_7 FROM bed WHERE nama_kamar = '$bed2' AND group_bed = '$group_bed2' AND ruangan = '$id_ruangan2'");
$kamar_luar = mysqli_fetch_array($cari_harga_kamar);
$harga_kamar1 = $kamar_luar['tarif'];
$harga_kamar2 = $kamar_luar['tarif_2'];
$harga_kamar3 = $kamar_luar['tarif_3'];
$harga_kamar4 = $kamar_luar['tarif_4'];
$harga_kamar5 = $kamar_luar['tarif_5'];
$harga_kamar6 = $kamar_luar['tarif_6'];
$harga_kamar7 = $kamar_luar['tarif_7'];


// HARGA KAMAR
if ($level_harga == 'harga_1') {
$subtotal = 1 * $harga_kamar1;
}
else if ($level_harga == 'harga_2') {
$subtotal = 1 * $harga_kamar2;
}
else if ($level_harga == 'harga_3') {
$subtotal = 1 * $harga_kamar3;
}
else if ($level_harga == 'harga_4') {
$subtotal = 1 * $harga_kamar4;
}
else if ($level_harga == 'harga_5') {
$subtotal = 1 * $harga_kamar5;
}
else if ($level_harga == 'harga_6') {
$subtotal = 1 * $harga_kamar6;
}
else {
$subtotal = 1 * $harga_kamar7;
}

//end bahan untuk kamar

$ambil_satuan = $db->query("SELECT id FROM satuan WHERE nama = 'BED'");
$b = mysqli_fetch_array($ambil_satuan);
$satuan_bed = $b['id'];


if($data_registrasi['tanggal'] == $tanggal_sekarang)
{
$delete_bed_lama = $db->query("DELETE FROM tbs_penjualan WHERE kode_barang = '$bed_before' AND no_reg = '$reg' ");
}
else
{
  $update_tbs_kamr = $db->query("UPDATE tbs_penjualan SET jumlah_barang = '$lama_inap' WHERE kode_barang = '$bed_before' AND no_reg = '$reg'");
}



$query_insert_tbs_penjualan = "INSERT INTO tbs_penjualan (no_reg,kode_barang,nama_barang,jumlah_barang,harga,subtotal,tipe_barang,potongan,tax,tanggal,jam,satuan,ruangan)
 VALUES ('$reg','$bed2','$group_bed2','1','$harga_kamar1','$subtotal','Bed','0','0','$tanggal_sekarang','$jam','$satuan_bed','$id_ruangan2')";
      if ($db->query($query_insert_tbs_penjualan) === TRUE) 
      {
  
      } 
        else 
      {
    echo "Error: " . $query_insert_tbs_penjualan . "<br>" . $db->error;
      }


?>