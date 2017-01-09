<?php
include 'db.php';
include_once 'sanitasi.php';


//Mengambil data penjualan berdasarkan trtansaksi yang sudah 
$pilih_retur_pembelian = $db->query("SELECT * FROM retur_pembelian WHERE tanggal >= '2017-01-01'");
while ($data_opname = mysqli_fetch_array($pilih_retur_pembelian)) { //START while ($data_opname) {

	$no_faktur_retur = $data_opname['no_faktur_retur'];
	$tanggal_sekarang = $data_opname['tanggal'];
	$jam_sekarang = $data_opname['jam'];
	$user_buat = $data_opname['user_buat'];
	$nama_suplier = $data_opname['nama_suplier'];		
	$ppn_input = $data_opname['ppn'];
	$cara_bayar = $data_opname['cara_bayar'];
	$total = $data_opname['total'];
	$potongan = $data_opname['potongan'];
	$tax_jadi = $data_opname['tax'];
		
		$select_suplier = $db->query("SELECT id,nama FROM suplier WHERE id = '$nama_suplier'");
		$ambil_suplier = mysqli_fetch_array($select_suplier);
		    
		$select_setting_akun = $db->query("SELECT * FROM setting_akun");
		$ambil_setting = mysqli_fetch_array($select_setting_akun);

		$sum_tax_tbs = $db->query("SELECT SUM(tax) AS total_tax, SUM(subtotal) AS subtotal FROM detail_retur_pembelian WHERE no_faktur_retur = '$no_faktur_retur'");
		$jumlah_tax = mysqli_fetch_array($sum_tax_tbs);
		$total_tax = $jumlah_tax['total_tax'];
		$subtotal = $jumlah_tax['subtotal'];



		$sum_hpp_keluar = $db->query("SELECT SUM(total_nilai) AS total FROM hpp_keluar WHERE no_faktur = '$no_faktur_retur'");
		$ambil_sum = mysqli_fetch_array($sum_hpp_keluar);
		$total_hpp = $ambil_sum['total'];


		        if ($ppn_input == "Non") {  
		                    
		                    $persediaan = $total_hpp ;
		                    $total_akhir = $total;
		                    
		                    
		                    //PERSEDIAAN    
		                    $insert_jurnal = $db->query("INSERT INTO jurnal_trans (nomor_jurnal,waktu_jurnal,keterangan_jurnal,kode_akun_jurnal,debit,kredit,jenis_transaksi,no_faktur,approved,user_buat,user_edit) VALUES ('".no_jurnal()."', '$tanggal_sekarang $jam_sekarang', 'Retur Pembelian - $ambil_suplier[nama]', '$ambil_setting[persediaan]', '0', '$persediaan', 'Retur Pembelian', '$no_faktur_retur','1', '$user_buat','')");
		                    } 
		                    
		        else if ($ppn_input == "Include") {
		                    //ppn == Include
		                    
		                    $pajak = $total_tax;
		                    $persediaan = $total_hpp;
		                    $total_akhir = $total;
		                    
		                    
		                    //PERSEDIAAN    
		                    $insert_jurnal = $db->query("INSERT INTO jurnal_trans (nomor_jurnal,waktu_jurnal,keterangan_jurnal,kode_akun_jurnal,debit,kredit,jenis_transaksi,no_faktur,approved,user_buat,user_edit) VALUES ('".no_jurnal()."', '$tanggal_sekarang $jam_sekarang', 'Retur Pembelian - $ambil_suplier[nama]', '$ambil_setting[persediaan]', '0', '$persediaan', 'Retur Pembelian', '$no_faktur_retur','1', '$user_buat','')");
		                    
		                    if ($pajak != "" || $pajak != 0 ) {
		                    //PAJAK
		                    $insert_juranl = $db->query("INSERT INTO jurnal_trans (nomor_jurnal,waktu_jurnal,keterangan_jurnal,kode_akun_jurnal,debit,kredit,jenis_transaksi,no_faktur,approved,user_buat,user_edit) VALUES ('".no_jurnal()."', '$tanggal_sekarang $jam_sekarang', 'Retur Pembelian - $ambil_suplier[nama]', '$ambil_setting[pajak_retur_beli]', '0', '$pajak', 'Retur Pembelian', '$no_faktur_retur','1', '$user_buat','')");
		                    }
		                    
		                    
		                    }
		                    
		        else {
		                    
		                    //ppn == Exclude
		                    $pajak = $tax_jadi;
		                    $persediaan = $total_hpp;                
		                    $total_akhir = $total;
		                    
		                    
		                    //PERSEDIAAN    
		                    $insert_jurnal = $db->query("INSERT INTO jurnal_trans (nomor_jurnal,waktu_jurnal,keterangan_jurnal,kode_akun_jurnal,debit,kredit,jenis_transaksi,no_faktur,approved,user_buat,user_edit) VALUES ('".no_jurnal()."', '$tanggal_sekarang $jam_sekarang', 'Retur Pembelian - $ambil_suplier[nama]', '$ambil_setting[persediaan]', '0', '$persediaan', 'Retur Pembelian', '$no_faktur_retur','1', '$user_buat','')");
		                    
		                    if ($pajak != "" || $pajak != 0 ) {
		                    //PAJAK
		                    $insert_juranl = $db->query("INSERT INTO jurnal_trans (nomor_jurnal,waktu_jurnal,keterangan_jurnal,kode_akun_jurnal,debit,kredit,jenis_transaksi,no_faktur,approved,user_buat,user_edit) VALUES ('".no_jurnal()."', '$tanggal_sekarang $jam_sekarang', 'Retur Pembelian - $ambil_suplier[nama]', '$ambil_setting[pajak_retur_beli]', '0', '$pajak', 'Retur Pembelian', '$no_faktur_retur','1', '$user_buat','')");
		                    }
		                    
		            }





					 //KAS
					        $insert_juranl = $db->query("INSERT INTO jurnal_trans (nomor_jurnal,waktu_jurnal,keterangan_jurnal,kode_akun_jurnal,debit,kredit,jenis_transaksi,no_faktur,approved,user_buat,user_edit) VALUES ('".no_jurnal()."', '$tanggal_sekarang $jam_sekarang', 'Retur Pembelian - $ambil_suplier[nama]', '$cara_bayar', '$total_akhir', '0', 'Retur Pembelian', '$no_faktur_retur','1', '$user_buat','')");

					 
					if ($potongan != "" || $potongan != 0 ) {
					//POTONGAN
					        $insert_juranl = $db->query("INSERT INTO jurnal_trans (nomor_jurnal,waktu_jurnal,keterangan_jurnal,kode_akun_jurnal,debit,kredit,jenis_transaksi,no_faktur,approved,user_buat,user_edit) VALUES ('".no_jurnal()."', '$tanggal_sekarang $jam_sekarang', 'Retur Pembelian - $ambil_suplier[nama]', '$ambil_setting[potongan_retur_beli]', '$potongan', '0', 'Retur Pembelian', '$no_faktur_retur','1', '$user_buat','')");
		}

						$sum_debit_kredit = $db->query("SELECT SUM(debit) AS jumlah_debit, SUM(kredit) AS jumlah_kredit FROM jurnal_trans WHERE no_faktur = '$no_faktur_retur'");
						$data_debit_kredit = mysqli_fetch_array($sum_debit_kredit);
						$jumlah_debit = $data_debit_kredit['jumlah_debit'];
						$jumlah_kredit = $data_debit_kredit['jumlah_kredit'];

						if ($jumlah_kredit > $jumlah_debit) {
						    $labarugi = $jumlah_kredit - $jumlah_debit;

						    	$insert_juranl = $db->query("INSERT INTO jurnal_trans (nomor_jurnal,waktu_jurnal,keterangan_jurnal,kode_akun_jurnal,debit,kredit,jenis_transaksi,no_faktur,approved,user_buat,user_edit) VALUES ('".no_jurnal()."', '$tanggal_sekarang $jam_sekarang', 'Retur Pembelian - $ambil_suplier[nama]', '701-004', '$labarugi', '0', 'Retur Pembelian', '$no_faktur_retur','1', '$user_buat','')");
						}

						elseif ($jumlah_debit > $jumlah_kredit) {
						    $labarugi = $jumlah_debit - $jumlah_kredit;

						     	$insert_juranl = $db->query("INSERT INTO jurnal_trans (nomor_jurnal,waktu_jurnal,keterangan_jurnal,kode_akun_jurnal,debit,kredit,jenis_transaksi,no_faktur,approved,user_buat,user_edit)VALUES ('".no_jurnal()."', '$tanggal_sekarang $jam_sekarang', 'Retur Pembelian - $ambil_suplier[nama]', '701-004', '0', '$labarugi', 'Retur Pembelian', '$no_faktur_retur','1', '$user_buat','')");
						    
						}
		else{

		}



} //END while ($data_opname) {

?>