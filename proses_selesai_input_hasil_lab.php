<?php 
include 'db.php';
include 'sanitasi.php';

$nama = stringdoang($_POST['nama']);
$no_rm = stringdoang($_POST['no_rm']);
echo $no_reg = stringdoang($_POST['no_reg']);
$jenis_penjualan = stringdoang($_POST['jenis_penjualan']);
$no_periksa = stringdoang($_POST['pemeriksaan']);
if($no_periksa == ''){
	$no_periksa = '0';
}

$tanggal = date('Y-m-d');
$jam = date('H:m:s');
$waktu = date("Y-m-d H:i:s");

if ($jenis_penjualan != 'Rawat Inap'){ 
	$query_cek_hasil = $db->query("SELECT no_reg FROM hasil_lab WHERE no_reg = '$no_reg' ");
	$data_cek_hasil = mysqli_num_rows($query_cek_hasil);

	if ($data_cek_hasil > 0){

    	$perintah2 = $db->query("DELETE FROM hasil_lab WHERE no_reg = '$no_reg' AND no_faktur IS NULL");
	}
}
else{
	$query_cek_hasil_inap = $db->query("SELECT no_reg FROM hasil_lab WHERE no_reg = '$no_reg' AND lab_ke_berapa = '$no_periksa' ");
	$data_cek_hasil = mysqli_num_rows($query_cek_hasil_inap);

	if ($data_cek_hasil > 0){

    	$perintah2 = $db->query("DELETE FROM hasil_lab WHERE no_reg = '$no_reg' AND lab_ke_berapa = '$no_periksa' AND no_faktur IS NULL");
	}

}


$cek_setting = $db->query("SELECT nama FROM setting_laboratorium WHERE jenis_lab = '$jenis_penjualan'");
$data_setting = mysqli_fetch_array($cek_setting);
$hasil_setting = $data_setting['nama']; //jika hasil 1 maka = input hasil baru bayar, jika 0 maka = bayar dulu baru input hasil

if($hasil_setting == '1'){
	//Update and Input pemeriksaan Laboratorium sebelum penjualan
	if($jenis_penjualan == 'APS'){
		$query_update_status = $db->query("UPDATE pemeriksaan_laboratorium SET status = '1' WHERE no_reg = '$no_reg'");
	}
	else if ($jenis_penjualan == 'Rawat Inap'){

		$query_update_periksa_lab_inap = $db->query("UPDATE pemeriksaan_lab_inap SET status = '1' WHERE no_reg = '$no_reg' AND no_periksa = '$no_periksa'");

	}
	else{
		$insert_pemeriksaan_laboratorium = $db->query("INSERT INTO pemeriksaan_laboratorium (no_reg,no_rm,status,nama_pasien,status_pasien,waktu) VALUES ('$no_reg',
			'$no_rm','1','$nama','$jenis_penjualan','$waktu')");
	}

	if($jenis_penjualan != 'Rawat Inap'){
		$query_update_registrasi_status_lab = $db->query("UPDATE registrasi SET status_lab = '1' WHERE no_reg = '$no_reg' AND no_rm = '$no_rm'");
	}

	//Input ke Hasil Lab (Data Detail Hasil Lab)
	$query_select_tbs_hasil = $db->query("SELECT * FROM tbs_hasil_lab WHERE no_reg = '$no_reg' AND no_rm = '$no_rm'");
	while($data_tbs = mysqli_fetch_array($query_select_tbs_hasil)){

	$input = "INSERT INTO hasil_lab (id_pemeriksaan, nama_pemeriksaan, hasil_pemeriksaan, nilai_normal_lk, nilai_normal_pr, status_abnormal, status_pasien, status, no_rm, no_reg,nama_pasien,tanggal,jam,model_hitung,
		satuan_nilai_normal,id_sub_header,nilai_normal_lk2,
		nilai_normal_pr2,kode_barang,dokter,petugas_analis,
		id_setup_hasil,lab_ke_berapa) VALUES ('$data_tbs[id_pemeriksaan]',
		'$data_tbs[nama_pemeriksaan]','$data_tbs[hasil_pemeriksaan]',
		'$data_tbs[nilai_normal_lk]','$data_tbs[nilai_normal_pr]',
		'$data_tbs[status_abnormal]','$jenis_penjualan','1',
		'$no_rm','$no_reg','$nama','$tanggal','$jam',
		'$data_tbs[model_hitung]','$data_tbs[satuan_nilai_normal]',
		'$data_tbs[id_sub_header]','$data_tbs[normal_lk2]',
		'$data_tbs[normal_pr2]','$data_tbs[kode_barang]',
		'$data_tbs[dokter]','$data_tbs[analis]',
		'$data_tbs[id_setup_hasil]','$no_periksa')";

		if ($db->query($input) === TRUE){
	      
	    } 
	    else {
	      echo "Error: " . $input . "<br>" . $db->error;
	    }
  	}

}
else{
	//Update and Input pemeriksaan Laboratorium sesudah penjualan
	$select_faktur = $db->query("SELECT no_faktur FROM penjualan WHERE no_reg = '$no_reg'");
	$data_faktur = mysqli_fetch_array($select_faktur);
	$no_faktur = $data_faktur['no_faktur'];

	if($jenis_penjualan == 'APS'){
		$query_update_status = $db->query("UPDATE pemeriksaan_laboratorium SET status = '1', no_faktur = '$no_faktur' WHERE no_reg = '$no_reg'");

	}
	else if ($jenis_penjualan == 'Rawat Inap'){

		$query_update_periksa_lab_inap = $db->query("UPDATE pemeriksaan_lab_inap SET status = '1' WHERE no_reg = '$no_reg' AND no_periksa = '$no_periksa'");

		//cek dulu data untuk update registrasi
		$select_data_periksa_lab_inap = $db->query("SELECT no_reg FROM pemeriksaan_lab_inap WHERE no_reg = '$no_reg'");
		$tampilkan_data = mysqli_num_rows($select_data_periksa_lab_inap);
		if($tampilkan_data <= 0){

			$query_update_registrasi_status_lab_inap = $db->query("UPDATE registrasi SET status_lab = '1' WHERE no_reg = '$no_reg' AND no_rm = '$no_rm'");

		}



	}
	else{
		$insert_pemeriksaan_laboratorium = $db->query("INSERT INTO pemeriksaan_laboratorium (no_faktur,no_reg,no_rm,status,nama_pasien,status_pasien,waktu) VALUES ('$no_faktur',
			'$no_reg','$no_rm','1','$nama','$jenis_penjualan','$waktu')");
		
		$query_update_registrasi_status_lab = $db->query("UPDATE registrasi SET status_lab = '1' WHERE no_reg = '$no_reg' AND no_rm = '$no_rm'");

	}


	//Input ke Hasil Lab (Data Detail Hasil Lab)
	$query_select_tbs_hasil = $db->query("SELECT * FROM tbs_hasil_lab WHERE no_reg = '$no_reg' AND no_rm = '$no_rm'");
	while($data_tbs = mysqli_fetch_array($query_select_tbs_hasil)){

	$input = "INSERT INTO hasil_lab (no_faktur,id_pemeriksaan, nama_pemeriksaan, hasil_pemeriksaan, nilai_normal_lk, nilai_normal_pr, status_abnormal, status_pasien, status, no_rm, no_reg,nama_pasien,tanggal,jam,model_hitung,
		satuan_nilai_normal,id_sub_header,nilai_normal_lk2,
		nilai_normal_pr2,kode_barang,dokter,petugas_analis,
		id_setup_hasil,lab_ke_berapa) VALUES ('$no_faktur','$data_tbs[id_pemeriksaan]',
		'$data_tbs[nama_pemeriksaan]','$data_tbs[hasil_pemeriksaan]',
		'$data_tbs[nilai_normal_lk]','$data_tbs[nilai_normal_pr]',
		'$data_tbs[status_abnormal]','$jenis_penjualan','1',
		'$no_rm','$no_reg','$nama','$tanggal','$jam',
		'$data_tbs[model_hitung]','$data_tbs[satuan_nilai_normal]',
		'$data_tbs[id_sub_header]','$data_tbs[normal_lk2]',
		'$data_tbs[normal_pr2]','$data_tbs[kode_barang]',
		'$data_tbs[dokter]','$data_tbs[analis]',
		'$data_tbs[id_setup_hasil]','$no_periksa')";

		if ($db->query($input) === TRUE){
	      
	      } 
	      else {
	      echo "Error: " . $input . "<br>" . $db->error;
	      }
  	}


  if ($jenis_penjualan != 'Rawat Inap'){ 
  	$query_hapus_tbs_aps = $db->query("DELETE FROM tbs_aps_penjualan WHERE no_reg = '$no_reg' ");
  }
  else{
  	$query_hapus_tbs_aps_inap = $db->query("DELETE FROM tbs_aps_penjualan WHERE no_reg = '$no_reg' AND no_periksa_lab_inap = '$no_periksa' ");

  }

}

$query_hapus_tbs_hasil = $db->query("DELETE FROM tbs_hasil_lab WHERE no_reg = '$no_reg'");

?>