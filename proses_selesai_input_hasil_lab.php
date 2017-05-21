<?php 
include 'db.php';
include 'sanitasi.php';

$nama = stringdoang($_POST['nama']);
$no_rm = stringdoang($_POST['no_rm']);
$no_faktur = stringdoang($_POST['no_faktur']);
echo $no_reg = stringdoang($_POST['no_reg']);
$jenis_penjualan = stringdoang($_POST['jenis_penjualan']);

$tanggal = date('Y-m-d');
$jam = date('H:m:s');

$query_cek_hasil = $db->query("SELECT no_reg FROM hasil_lab WHERE no_reg = '$no_reg' ");
$data_cek_hasil = mysqli_num_rows($query_cek_hasil);

if ($data_cek_hasil > 0){
    
    $perintah2 = $db->query("DELETE FROM hasil_lab WHERE no_reg = '$no_reg' AND no_faktur IS NULL");
}

$query_update_status = $db->query("UPDATE pemeriksaan_laboratorium SET status = '1' WHERE no_reg = '$no_reg'");

$query_select_tbs_hasil = $db->query("SELECT * FROM tbs_hasil_lab WHERE no_reg = '$no_reg' AND no_rm = '$no_rm'");
while($data_tbs = mysqli_fetch_array($query_select_tbs_hasil)){

	$input = "INSERT INTO hasil_lab (no_faktur,id_pemeriksaan, nama_pemeriksaan, hasil_pemeriksaan, nilai_normal_lk, nilai_normal_pr, status_abnormal, status_pasien, status, no_rm, no_reg,nama_pasien,tanggal,jam,model_hitung,
		satuan_nilai_normal,id_sub_header,nilai_normal_lk2,
		nilai_normal_pr2,kode_barang,dokter,petugas_analis,
		id_setup_hasil) VALUES ('$no_faktur','$data_tbs[id_pemeriksaan]',
		'$data_tbs[nama_pemeriksaan]','$data_tbs[hasil_pemeriksaan]',
		'$data_tbs[nilai_normal_lk]','$data_tbs[nilai_normal_pr]',
		'$data_tbs[status_abnormal]','$jenis_penjualan','Selesai',
		'$no_rm','$no_reg','$nama','$tanggal','$jam',
		'$data_tbs[model_hitung]','$data_tbs[satuan_nilai_normal]',
		'$data_tbs[id_sub_header]','$data_tbs[normal_lk2]',
		'$data_tbs[normal_pr2]','$data_tbs[kode_barang]',
		'$data_tbs[dokter]','$data_tbs[analis]',
		'$data_tbs[id_setup_hasil]')";
	if ($db->query($input) === TRUE){
      
      } 
      else {
      echo "Error: " . $input . "<br>" . $db->error;
      }

}

$cek_setting = $db->query("SELECT nama FROM setting_laboratorium");
$get = mysqli_fetch_array($cek_setting);
$hasil = $get['nama'];
if($hasil == 0){
$query_hapus_tbs_aps = $db->query("DELETE FROM tbs_aps_penjualan WHERE no_reg = '$no_reg' ");
}
else{

}
$query_hapus_tbs_hasil = $db->query("DELETE FROM tbs_hasil_lab WHERE no_reg = '$no_reg'");
?>