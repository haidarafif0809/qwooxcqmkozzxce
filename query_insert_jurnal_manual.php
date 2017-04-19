<?php 
 include 'db.php';
 include 'sanitasi.php';


 $query_history = $db->query("SELECT * FROM history_input_tbs_jurnal");
 while ($data_history = mysqli_fetch_array($query_history)) {

 	// cek apakah sudah ada pernah di hapus
 	$query_history_jurnal = $db->query("SELECT COUNT(*) AS jumlah_jurnal FROM history_jurnal_manual WHERE no_faktur = '$data_history[no_faktur]' ");
 	$cek_history_jurnal = mysqli_fetch_array($query_history_jurnal);

 		if ($cek_history_jurnal['jumlah_jurnal'] > 0) {
 			// jika sudah pernah di hapus maka tidak insert
 		}
 		else
 		{
 	// cek apakah sudah ada di jurnal trans\
		 	$query_cek_jurnal = $db->query("SELECT COUNT(*) AS jumlah_jurnal FROM jurnal_trans WHERE no_faktur = '$data_history[no_faktur]' ");
		 	$data_cek_jurnal = mysqli_fetch_array($query_cek_jurnal);

		 		// jika data jurnal nya kurang dari 2 data
		 	if ($data_history['tanggal'] == '0000-00-00') {
		 		$tanggal = date('Y-m-d');
		 	}
		 	else
		 	{
		 		$tanggal = $data_history['tanggal'];
		 	}

		 	if ($data_cek_jurnal['jumlah_jurnal'] < 2) {

		
		 		// maka akan di insert ke jurnal
		 		     $insert_jurnal = $db->query("INSERT INTO jurnal_trans (nomor_jurnal,waktu_jurnal,keterangan_jurnal,kode_akun_jurnal,debit,kredit,jenis_transaksi,no_faktur,approved,user_buat) VALUES ('".no_jurnal()."','$tanggal ".$data_history['jam']."','Jurnal Manual - ".$data_history['keterangan']."','$data_history[kode_akun_jurnal]','$data_history[debit]','$data_history[kredit]','Jurnal Manual','$data_history[no_faktur]','1','$data_history[user_input]')");





		 		}



 		}
 		
 }

 ?>

 