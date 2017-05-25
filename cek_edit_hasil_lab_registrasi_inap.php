<?php include 'session_login.php';
// memasukan file session login,  header, navbar, db.php,
include 'header.php';
include 'navbar.php';
include 'db.php';
include 'sanitasi.php';

$hasil_no_periksa = stringdoang($_GET['no_periksa']);
$no_rm = stringdoang($_GET['no_rm']);
$nama_pasien = stringdoang($_GET['nama_pasien']);
$no_reg = stringdoang($_GET['no_reg']);
$dokter = stringdoang($_GET['dokter']);
$jenis_kelamin = stringdoang($_GET['jenis_kelamin']);
$tanggal = stringdoang($_GET['tanggal']);
$jenis_penjualan = 'Rawat Inap';
$rujukan = 'Rujuk Rawat Inap';

$query_hapus_tbs_hasil = $db->query("DELETE FROM tbs_hasil_lab WHERE no_reg = '$no_reg'");
//$query_hapus_tbs_hasil = $db->query("DELETE FROM tbs_aps_penjualan WHERE no_reg = '$no_reg' AND no_periksa_lab_inap = '$hasil_no_periksa'");

//INSERT KE TBS APS PENJUALAN (UNTUK EDIT)
/*$select_tbs_penjualan = $db->query("SELECT no_reg,kode_barang,nama_barang,harga,lab_ke_berapa,tanggal,jam,dokter,analis FROM tbs_penjualan WHERE no_reg = '$no_reg' AND lab_ke_berapa = '$hasil_no_periksa'");
while($data_tbs_jual = mysqli_fetch_array($select_tbs_penjualan)){

$query_insert_tbs_penjualan = $db->query("INSERT INTO tbs_aps_penjualan 
	(no_reg,kode_jasa,nama_jasa,harga,dokter,analis,no_periksa_lab_inap,tanggal,jam) VALUES ('$no_reg','$data_tbs_jual[kode_barang]',
	'$data_tbs_jual[nama_barang]','$data_tbs_jual[harga]','$data_tbs_jual[dokter]','$data_tbs_jual[analis]','$hasil_no_periksa','$data_tbs_jual[tanggal]','$data_tbs_jual[jam]')");

}*/


$query_cek_data_hasil_lab = $db->query("SELECT no_reg FROM hasil_lab WHERE lab_ke_berapa = '$hasil_no_periksa'");
$data_jumlah = mysqli_num_rows($query_cek_data_hasil_lab);
if($data_jumlah > 0){

//INSERT DARI LAPORAN HASIL -> TBS HASIL 
$query_hasil_lab = "INSERT INTO tbs_hasil_lab (id_pemeriksaan, hasil_pemeriksaan, no_faktur,
no_reg, no_rm, status_pasien, nilai_normal_lk, nilai_normal_pr, normal_lk2, normal_pr2, nama_pemeriksaan,
model_hitung, satuan_nilai_normal, id_sub_header, kode_barang, id_setup_hasil, tanggal, jam, dokter,
analis) SELECT id_pemeriksaan,hasil_pemeriksaan, no_faktur, no_reg, no_rm, status_pasien, nilai_normal_lk, nilai_normal_pr, nilai_normal_lk2, nilai_normal_pr2, nama_pemeriksaan, model_hitung, satuan_nilai_normal, id_sub_header, kode_barang, id_setup_hasil, tanggal, jam, dokter, petugas_analis FROM hasil_lab WHERE no_reg = '$no_reg'";
      if ($db->query($query_hasil_lab) === TRUE) {
      }
      else{
            echo "Error: " . $query_hasil_lab . "<br>" . $db->error;
      }
}

//INSERT DARI LAPORAN HASIL -> TBS HASIL
echo '<META HTTP-EQUIV="Refresh" Content="0; URL=form_edit_jasa_reg_rawat_inap.php?hasil_no_periksa='.$hasil_no_periksa.'&no_rm='.$no_rm.'&nama_pasien='.$nama_pasien.'&no_reg='.$no_reg.'&dokter='.$dokter.'&jenis_kelamin='.$jenis_kelamin.'&tanggal='.$tanggal.'">';  

 ?>