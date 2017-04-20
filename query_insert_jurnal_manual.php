<?php 
 include 'db.php';
 include 'sanitasi.php';

$nomor_jurnal = "".no_jurnal()."";
 $query_jurnal = $db->query("SELECT no_faktur_jurnal,waktu_input FROM nomor_faktur_jurnal");
 while ($data_jurnal = mysqli_fetch_array($query_jurnal)) {

		 	$query_cek_jurnal = $db->query("SELECT COUNT(*) AS jumlah_jurnal FROM jurnal_trans WHERE no_faktur = '$data_jurnal[no_faktur_jurnal]' ");
		 	$data_cek_jurnal = mysqli_fetch_array($query_cek_jurnal);

		 	// cek datajurnal
		 	if ($data_cek_jurnal['jumlah_jurnal'] < 2) {
			// jika data jurnal kurang dari 2
		 		// maka akan di insert ke jurnal

		 		// deleete jurnal nya
		 		$delete_jurnal = $db->query("DELETE FROM jurnal_trans WHERE no_faktur = '$data_jurnal[no_faktur_jurnal]'  ");

		 		      $insert_jurnal = "INSERT INTO jurnal_trans(nomor_jurnal,waktu_jurnal,keterangan_jurnal,kode_akun_jurnal,debit,kredit,jenis_transaksi,no_faktur,approved,user_buat) SELECT '$nomor_jurnal',CONCAT(tanggal,' ',jam), CONCAT('Jurnal Manual -',keterangan), kode_akun_jurnal, debit, kredit, 'Jurnal Manual', no_faktur, '1', user_input  FROM history_input_tbs_jurnal  WHERE no_faktur = '$data_jurnal[no_faktur_jurnal]' AND waktu_input = '$data_jurnal[waktu_input]' ";

		 		           if ($db->query($insert_jurnal) === TRUE) {
		 		           	echo "success";
						        } 

						      else {
						        echo "Error: " . $insert_jurnal . "<br>" . $db->error;
						        }

		 		}




 		
 }

 ?>

 