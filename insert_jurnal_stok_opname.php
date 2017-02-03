<?php
include 'db.php';
include_once 'sanitasi.php';


//Mengambil data penjualan berdasarkan trtansaksi yang sudah '#LUNAS'
$pilih_stok_opname = $db->query("SELECT * FROM stok_opname WHERE tanggal >= '2017-01-01'");
while ($data_opname = mysqli_fetch_array($pilih_stok_opname)) { //START while ($data_opname) {

	$no_faktur = $data_opname['no_faktur'];
	$tanggal_sekarang = $data_opname['tanggal'];
	$jam_sekarang = $data_opname['jam'];
	$user = $data_opname['user'];

		$ambil_detail = $db->query("SELECT SUM(selisih_harga) AS total FROM detail_stok_opname WHERE no_faktur = '$no_faktur'");
		$data_detail = mysqli_fetch_array($ambil_detail);
		$total_detail = $data_detail['total'];

		$sum_hpp_keluar = $db->query("SELECT SUM(total_nilai) AS total FROM hpp_keluar WHERE no_faktur = '$no_faktur'");
		$ambil_sum = mysqli_fetch_array($sum_hpp_keluar);
		$total = $ambil_sum['total'];

		$select_setting_akun = $db->query("SELECT * FROM setting_akun");
		$ambil_setting = mysqli_fetch_array($select_setting_akun);

		if ($total_detail < 0) {
		    $total_opname = $total;

		 //PERSEDIAAN    
		        $insert_jurnal = "INSERT INTO jurnal_trans (nomor_jurnal,waktu_jurnal,keterangan_jurnal,kode_akun_jurnal,debit,kredit,jenis_transaksi,no_faktur,approved,user_buat) VALUES ('".no_jurnal()."', '$tanggal_sekarang $jam_sekarang', 'Stok Opname -', '$ambil_setting[persediaan]', '0', '$total_opname', 'Stok Opname', '$no_faktur','1', '$user')";
					
					if ($db->query($insert_jurnal) === TRUE) {
		                
		            } else {
		            echo "Error: " . $insert_jurnal . "<br>" . $db->error;
		            }



		  //STOK OPNAME    
		        $insert_jurnal2 = "INSERT INTO jurnal_trans (nomor_jurnal,waktu_jurnal,keterangan_jurnal,kode_akun_jurnal,debit,kredit,jenis_transaksi,no_faktur,approved,user_buat) VALUES ('".no_jurnal()."', '$tanggal_sekarang $jam_sekarang', 'Stok Opname -', '$ambil_setting[pengaturan_stok]', '$total_opname', '0', 'Stok Opname', '$no_faktur','1', '$user')";
		        	
		        	if ($db->query($insert_jurnal2) === TRUE) {
		                
		            } else {
		            echo "Error: " . $insert_jurnal2 . "<br>" . $db->error;
		            }

		} 

		else {

		      //PERSEDIAAN    
		        $insert_jurnal3 = "INSERT INTO jurnal_trans (nomor_jurnal,waktu_jurnal,keterangan_jurnal,kode_akun_jurnal,debit,kredit,jenis_transaksi,no_faktur,approved,user_buat) VALUES ('".no_jurnal()."', '$tanggal_sekarang $jam_sekarang', 'Stok Opname -', '$ambil_setting[persediaan]', '$total_detail', '0', 'Stok Opname', '$no_faktur','1', '$user')";
		        
		        	if ($db->query($insert_jurnal3) === TRUE) {
		                
		            } else {
		            echo "Error: " . $insert_jurnal3 . "<br>" . $db->error;
		            }

		  //STOK OPNAME    
		        $insert_jurnal4 = "INSERT INTO jurnal_trans (nomor_jurnal,waktu_jurnal,keterangan_jurnal,kode_akun_jurnal,debit,kredit,jenis_transaksi,no_faktur,approved,user_buat) VALUES ('".no_jurnal()."', '$tanggal_sekarang $jam_sekarang', 'Stok Opname -', '$ambil_setting[pengaturan_stok]', '0', '$total_detail', 'Stok Opname', '$no_faktur','1', '$user')";
		        	
		        	if ($db->query($insert_jurnal4) === TRUE) {
		                
		            } else {
		            echo "Error: " . $insert_jurnal4 . "<br>" . $db->error;
		            }
		}



} //END while ($data_opname) {

?>