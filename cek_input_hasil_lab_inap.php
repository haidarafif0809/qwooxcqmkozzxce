<?php 
include 'sanitasi.php';
include 'db.php';

$nama = stringdoang($_GET['nama']);
$no_rm = stringdoang($_GET['no_rm']);
$no_reg = stringdoang($_GET['no_reg']);
$jenis_penjualan = stringdoang($_GET['jenis_penjualan']);
$no_periksa = stringdoang($_GET['no_periksa']);


$perintah3 = $db->query("SELECT * FROM tbs_hasil_lab WHERE no_reg = '$no_reg' ");
$data1 = mysqli_num_rows($perintah3);

if ($data1 > 0)
{
      $perintah2 = $db->query("DELETE FROM tbs_hasil_lab WHERE no_reg = '$no_reg' AND hasil_pemeriksaan IS NULL");
}



$perintah = $db->query("SELECT lab_ke_berapa,kode_barang,nama_barang FROM tbs_penjualan WHERE no_reg = '$no_reg' AND lab_ke_berapa = '$no_periksa' AND lab = 'Laboratorium' AND status_lab IS NULL");
while ($data = mysqli_fetch_array($perintah)){

$lab_ke_berapa = $data['lab_ke_berapa'];
$kode_barang = $data['kode_barang'];
$nama_barang = $data['nama_barang'];

$cek_id_pemeriksaan = $db->query("SELECT id FROM jasa_lab WHERE kode_lab = '$kode_barang'");
$out = mysqli_fetch_array($cek_id_pemeriksaan);
 $id_pemeriksaan = $out['id'];


//SELECT UNTUK CEK JASA INDUX, JIKA JASA INDUX JANGAN DI INSERT KE HASIL !!
$cek_indux_or_no = $db->query("SELECT nama_pemeriksaan FROM setup_hasil WHERE nama_pemeriksaan = '$id_pemeriksaan' AND kategori_index = 'Header'");
$out_bukan_indux = mysqli_fetch_array($cek_indux_or_no);
$id_indux = $out_bukan_indux['nama_pemeriksaan'];

if($id_indux == $id_pemeriksaan)
{

}
else
{
$cek_hasil = $db->query("SELECT id,normal_lk2,normal_pr2,
	normal_lk,normal_pr,model_hitung,satuan_nilai_normal FROM setup_hasil WHERE nama_pemeriksaan = '$id_pemeriksaan'");
$out_hasil = mysqli_fetch_array($cek_hasil);
$hasil_pria = $out_hasil['normal_lk'];
$hasil_wanita = $out_hasil['normal_pr'];
$model_hitung = $out_hasil['model_hitung'];
$satuan_nilai_normal = $out_hasil['satuan_nilai_normal'];
$id_subnya = $out_hasil['id'];


$hasil_pria2 = $out_hasil['normal_lk2'];
$hasil_wanita2 = $out_hasil['normal_pr2'];
//Select untuk Data yang sudah di input kan hasilnya tidak di insert dan tidak di DELETE (TIDAK DI DELETE SUDAH ADA DI ATAS)
$get_data = $db->query("SELECT id_pemeriksaan FROM tbs_hasil_lab WHERE id_pemeriksaan = '$id_pemeriksaan' AND hasil_pemeriksaan != '' AND no_reg = '$no_reg'");
$out_data = mysqli_num_rows($get_data);
$out_data_id = mysqli_fetch_array($get_data);

$datanya = $out_data_id['id_pemeriksaan'];

if($out_data > 0 AND $datanya != '')
	{

	}
else
  	{

//Proses untuk Input Jasanya jika bukan Header Laboratorium
$query6 = "INSERT INTO tbs_hasil_lab (satuan_nilai_normal,model_hitung,
no_rm,no_reg,id_pemeriksaan,nilai_normal_lk,nilai_normal_pr,
status_pasien,nama_pemeriksaan,normal_lk2,normal_pr2,lab_ke_berapa,kode_barang) VALUES ('$satuan_nilai_normal','$model_hitung','$no_rm','$no_reg',
'$id_pemeriksaan','$hasil_pria','$hasil_wanita','$jenis_penjualan',
'$nama_barang','$hasil_pria2','$hasil_wanita2','$lab_ke_berapa','$kode_barang')";

	      if ($db->query($query6) === TRUE)
	      {
	      
	      } 
	      else 
	      {
	      echo "Error: " . $query6 . "<br>" . $db->error;
	      }
  	}
  }
}// end while awal!!
// end while cek hasil lab

//NOTE* BAGIAN ATAS INSERT DARI TBS , DAN BAGIAN BAWAH INSERT DETAIL YANG INDUX (HEADER)-NYA ADA DI TBS PENJUALAN !!

//START Proses untuk input Header and Detail Jasa Laboratorium
//Ambil setup hasil yang nama pemeriksaaannya (id) sama dengan id di jasa_lab dan di setup hasilnya Header (Indux)
$perintah = $db->query("SELECT lab_ke_berapa,kode_barang FROM tbs_penjualan WHERE no_reg = '$no_reg' AND lab_ke_berapa = '$no_periksa' AND lab = 'Laboratorium' AND status_lab IS NULL ");
while($data = mysqli_fetch_array($perintah)){

$kode_barang = $data['kode_barang'];

$cek_id_pemeriksaan = $db->query("SELECT id FROM jasa_lab WHERE kode_lab = '$kode_barang'");
$out = mysqli_fetch_array($cek_id_pemeriksaan);
$id_jasa_lab = $out['id'];

$cek_ibu_header = $db->query("SELECT id FROM setup_hasil WHERE nama_pemeriksaan = '$id_jasa_lab'");
while($out_mother = mysqli_fetch_array($cek_ibu_header))
{
$id_mother = $out_mother['id'];

//DI EDIT YANG WHILE INI QUERY SALAH !!!!!!
$select_detail_anaknya = $db->query("SELECT * FROM setup_hasil WHERE sub_hasil_lab = '$id_mother'");
while($drop = mysqli_fetch_array($select_detail_anaknya))
{
$ambil_nama_jasa = $db->query("SELECT nama FROM jasa_lab WHERE id = '$drop[nama_pemeriksaan]'");
$get = mysqli_fetch_array($ambil_nama_jasa);
$nama_jasa_anak = $get['nama'];
	
//Select untuk Data yang sudah di input kan hasilnya tidak di insert dan tidak di DELETE (TIDAK DI DELETE SUDAH ADA DI ATAS)
$get_data = $db->query("SELECT id_pemeriksaan FROM tbs_hasil_lab WHERE id_pemeriksaan = '$drop[nama_pemeriksaan]' AND hasil_pemeriksaan != '' AND no_reg = '$no_reg'");
$out_data = mysqli_num_rows($get_data);
$out_data_id = mysqli_fetch_array($get_data);

$datanya = $out_data_id['id_pemeriksaan'];

if($out_data > 0 AND $datanya != '')
	{

	}
else
  	{

	$insert_anaknya = "INSERT INTO tbs_hasil_lab (satuan_nilai_normal,
	model_hitung,no_rm,no_reg,id_pemeriksaan,nilai_normal_lk,nilai_normal_pr,status_pasien,nama_pemeriksaan,id_sub_header,normal_lk2,normal_pr2,
	lab_ke_berapa,kode_barang) VALUES ('$drop[satuan_nilai_normal]',
	'$drop[model_hitung]','$no_rm','$no_reg','$drop[nama_pemeriksaan]',
	'$drop[normal_lk]','$drop[normal_pr]','$jenis_penjualan',
	'$nama_jasa_anak','$id_mother','$drop[normal_lk2]',
	'$drop[normal_pr2]','$data[lab_ke_berapa]','$kode_barang')";

      if ($db->query($insert_anaknya) === TRUE)
      {
      
      } 
      else 
      {
      echo "Error: " . $insert_anaknya . "<br>" . $db->error;
      }
  	}
  	//under while 3x
  }
 }
}
//Ending Proses untuk input Header and Detail Jasa Laboratorium


echo '<META HTTP-EQUIV="Refresh" Content="0; URL=hasil_laboratorium_inap.php?no_rm='.$no_rm.'&no_reg='.$no_reg.'&nama='.$nama.'&jenis_penjualan='.$jenis_penjualan.'&no_periksa='.$no_periksa.'">';
//Untuk Memutuskan Koneksi Ke Database
mysqli_close($db);   

 ?>