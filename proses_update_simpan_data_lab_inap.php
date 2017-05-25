<?php session_start();
include 'db.php';
include 'sanitasi.php';

$pemeriksaan_keberapa = stringdoang($_POST['pemeriksaan_keberapa']);
$nama = stringdoang($_POST['nama_pasien']);
$no_rm = stringdoang($_POST['no_rm']);
$no_reg = stringdoang($_POST['no_reg']);
$tanggal = stringdoang($_POST['tanggal']);
$jam =  date('H:i:s');
$user = $_SESSION['id'];
$waktu = $tanggal.' '. $jam;

$query_hapus_hasil_lab = $db->query("DELETE FROM hasil_lab WHERE no_reg = '$no_reg'");
$query_hapus_tbs_penjualan = $db->query("DELETE FROM tbs_penjualan WHERE no_reg = '$no_reg' AND lab_ke_berapa = '$pemeriksaan_keberapa'");

//UPDATE PEMERIKSAANNYA
$query_update_pemeriksaan = "UPDATE pemeriksaan_lab_inap SET status = '1', waktu = '$waktu', user_edit = '$user' WHERE no_reg = '$no_reg'";
if ($db->query($query_update_pemeriksaan) === TRUE) {
    
}
else {
    echo "Error: " . $query_update_pemeriksaan . "<br>" . $db->error;
}

//insert ke tbs penjualan
/*$select_tbs_aps = $db->quewry("SELECT kode_jasa,nama_jasa,harga,dokter,analis,no_periksa_lab,tanggal,jam FROM tbs_aps_penjualan WHERE no_reg = '$no_reg' AND no_periksa_lab_inap = '$pemeriksaan_keberapa'");
while($data_tbs_aps = mysqli_fetch_array($select_tbs_aps)){

$query_insert_tbs_penjualan = $db->query("INSERT INTO tbs_penjualan (no_reg,kode_barang,nama_barang,harga,lab_ke_berapa,tanggal,jam,jumlah_barang, tipe_barang,lab,status_lab,dokter,analis) VALUES ('$no_reg','$data_tbs_aps[kode_jasa]','$data_tbs_aps[nama_jasa]','$data_tbs_aps[harga]','$pemeriksaan_keberapa','$data_tbs_aps[tanggal]','$data_tbs_aps[jam]','1','jasa',
      'Laboratorium','Unfinish','$data_tbs_aps[dokter]','$data_tbs_aps[analis]')");
}*/


   //MULAI INSERT KE HASIL LAB DARI TBS HASIL LAB
          $query_insert_hasil_lab = "INSERT INTO hasil_lab (id_pemeriksaan, nama_pemeriksaan, hasil_pemeriksaan, nilai_normal_lk, nilai_normal_pr, status_pasien, no_rm, no_reg,nama_pasien, tanggal, jam, dokter, petugas_analis, model_hitung, satuan_nilai_normal, id_sub_header, nilai_normal_lk2, nilai_normal_pr2, kode_barang, id_setup_hasil,status) SELECT id_pemeriksaan, nama_pemeriksaan, hasil_pemeriksaan, nilai_normal_lk, nilai_normal_pr, status_pasien, no_rm, no_reg, '$nama', tanggal, jam, dokter, analis, model_hitung, satuan_nilai_normal, id_sub_header, normal_lk2, normal_pr2, kode_barang, id_setup_hasil,'1' FROM tbs_hasil_lab WHERE no_reg = '$no_reg'";

              if ($db->query($query_insert_hasil_lab) === TRUE) {
              	echo 1;
              }
              else{
                  echo "Error: " . $query_insert_hasil_lab . "<br>" . $db->error;
              }

//Untuk Memutuskan Koneksi Ke Database
mysqli_close($db);      
?>