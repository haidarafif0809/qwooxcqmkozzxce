<?php session_start();
include 'db.php'; 
include 'sanitasi.php';


$dari_tanggal = stringdoang($_GET['dari_tanggal']);
$sampai_tanggal = stringdoang($_GET['sampai_tanggal']);

$jam_sekarang = date('H:i:s');

    $query = $db->query("SELECT * FROM item_keluar WHERE tanggal >= '$dari_tanggal' AND tanggal <= '$sampai_tanggal' ");
    while ($data = mysqli_fetch_array($query))
    {
            
    	$tanggal_sekarang = $data['tanggal'];
    	$user = $data['user'];

		$sum_hpp_keluar = $db->query("SELECT SUM(total_nilai) AS total FROM hpp_keluar WHERE no_faktur = '$data[no_faktur]'");
		$ambil_sum = mysqli_fetch_array($sum_hpp_keluar);
		echo$total = $ambil_sum['total'];

		$select_setting_akun = $db->query("SELECT persediaan , item_keluar FROM setting_akun");
		$ambil_setting = mysqli_fetch_array($select_setting_akun);

			
			$query_cek_jurnal = $db->query("SELECT COUNT(*) AS jumlah_jurnal, SUM(debit) AS debit, SUM(kredit) AS kredit FROM jurnal_trans WHERE no_faktur = '$data[no_faktur]' ");
		 	$data_cek_jurnal = mysqli_fetch_array($query_cek_jurnal);
		 	
			if ($data_cek_jurnal['jumlah_jurnal'] < 2) {				

				$delete_jurnal = $db->query("DELETE FROM jurnal_trans WHERE no_faktur = '$data[no_faktur]'  ");

					  //PERSEDIAAN    
		        $insert_jurnal = $db->query("INSERT INTO jurnal_trans (nomor_jurnal,waktu_jurnal,keterangan_jurnal,kode_akun_jurnal,debit,kredit,jenis_transaksi,no_faktur,approved,user_buat) VALUES ('".no_jurnal()."', '$tanggal_sekarang $jam_sekarang', 'Persediaan -', '$ambil_setting[persediaan]', '0', '$total', 'Item Keluar', '$data[no_faktur]','1', '$user')");

		  //ITEM KELUAR    
		        $insert_jurnal = $db->query("INSERT INTO jurnal_trans (nomor_jurnal,waktu_jurnal,keterangan_jurnal,kode_akun_jurnal,debit,kredit,jenis_transaksi,no_faktur,approved,user_buat) VALUES ('".no_jurnal()."', '$tanggal_sekarang $jam_sekarang', 'Item Keluar -', '$ambil_setting[item_keluar]', '$total', '0', 'Item Keluar', '$data[no_faktur]','1', '$user')");


			}
			elseif ($data_cek_jurnal['debit'] == 0 AND $data_cek_jurnal['kredit'] == 0) {
				echo "$data[no_faktur]";
				$delete_jurnal = $db->query("DELETE FROM jurnal_trans WHERE no_faktur = '$data[no_faktur]'  ");

					  //PERSEDIAAN    
		        $insert_jurnal = $db->query("INSERT INTO jurnal_trans (nomor_jurnal,waktu_jurnal,keterangan_jurnal,kode_akun_jurnal,debit,kredit,jenis_transaksi,no_faktur,approved,user_buat) VALUES ('".no_jurnal()."', '$tanggal_sekarang $jam_sekarang', 'Persediaan -', '$ambil_setting[persediaan]', '0', '$total', 'Item Keluar', '$data[no_faktur]','1', '$user')");

		  //ITEM KELUAR    
		        $insert_jurnal = $db->query("INSERT INTO jurnal_trans (nomor_jurnal,waktu_jurnal,keterangan_jurnal,kode_akun_jurnal,debit,kredit,jenis_transaksi,no_faktur,approved,user_buat) VALUES ('".no_jurnal()."', '$tanggal_sekarang $jam_sekarang', 'Item Keluar -', '$ambil_setting[item_keluar]', '$total', '0', 'Item Keluar', '$data[no_faktur]','1', '$user')");

			}

}



 ?>