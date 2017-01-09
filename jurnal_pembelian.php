<?php session_start();

    include 'sanitasi.php';
    include 'db.php';


$tahun_sekarang = date('Y');
$bulan_sekarang = date('m');
$tanggal_sekarang = date('Y-m-d');
$jam_sekarang = date('H:i:s');
$tahun_terakhir = substr($tahun_sekarang, 2);
$waktu = date('Y-m-d H:i:s');

$query = $db->query("SELECT * FROM pembelian WHERE tanggal >= '2017-01-01' AND tanggal <= '$tanggal_sekarang'  ");
while ($data = mysqli_fetch_array($query)) {
	
$delete = $db->query("DELETE FROM jurnal_trans WHERE no_faktur = '$data[no_faktur]' ");	

$select_setting_akun = $db->query("SELECT * FROM setting_akun");
$ambil_setting = mysqli_fetch_array($select_setting_akun);

$ambil_detail = $db->query("SELECT SUM(subtotal) AS subtotal FROM detail_pembelian WHERE no_faktur = '$data[no_faktur]' ");
$data_detail = mysqli_fetch_array($ambil_detail);

$ambil_suplier = $db->query("SELECT nama FROM suplier WHERE id = '$data[suplier]' ");
$ss = mysqli_fetch_array($ambil_suplier);


$sum_tax_tbs = $db->query("SELECT SUM(tax) AS total_tax FROM detail_pembelian WHERE no_faktur = '$data[no_faktur]'");
$jumlah_tax = mysqli_fetch_array($sum_tax_tbs);
$total_tax = $jumlah_tax['total_tax'];


if ($data['status'] == 'Lunas') 
{
	
	


				 if ($total_tax > 0) {
				 	echo "include";
				//ppn == Include

				  $persediaan = $data_detail['subtotal'] - $total_tax;
				  $total_akhir = $data['total'];
				  $pajak = $total_tax;

				  //PERSEDIAAN    
				        $insert_jurnal = $db->query("INSERT INTO jurnal_trans (nomor_jurnal,waktu_jurnal,keterangan_jurnal,kode_akun_jurnal,debit,kredit,jenis_transaksi,no_faktur,approved,user_buat) VALUES ('".no_jurnal()."', '$tanggal_sekarang $jam_sekarang', 'Pembelian Tunai - $ss[nama]', '$ambil_setting[persediaan]', '$persediaan', '0', 'Pembelian', '$data[no_faktur]','1', '$data[user]')");

				if ($pajak != "" || $pajak != 0) {
				//PAJAK
				        $insert_juranl = $db->query("INSERT INTO jurnal_trans (nomor_jurnal,waktu_jurnal,keterangan_jurnal,kode_akun_jurnal,debit,kredit,jenis_transaksi,no_faktur,approved,user_buat) VALUES ('".no_jurnal()."', '$tanggal_sekarang $jam_sekarang', 'Pembelian Tunai - $ss[nama]', '$ambil_setting[pajak]', '$pajak', '0', 'Pembelian', '$data[no_faktur]','1', '$data[user]')");
				}

				}


				elseif($data['tax'] > 0) {
					echo "exclude";

				//ppn == Exclude
				    $persediaan = $data_detail['subtotal'];
				    $total_akhir = $data['total'];
				  $pajak = $data['tax'];

				  //PERSEDIAAN    
							        $insert_jurnal = $db->query("INSERT INTO jurnal_trans (nomor_jurnal,waktu_jurnal,keterangan_jurnal,kode_akun_jurnal,debit,kredit,jenis_transaksi,no_faktur,approved,user_buat) VALUES ('".no_jurnal()."', '$tanggal_sekarang $jam_sekarang', 'Pembelian Tunai - $ss[nama]', '$ambil_setting[persediaan]', '$persediaan', '0', 'Pembelian', '$data[no_faktur]','1', '$data[user]')");

							if ($pajak != "" || $pajak != 0) {
							//PAJAK
							        $insert_juranl = $db->query("INSERT INTO jurnal_trans (nomor_jurnal,waktu_jurnal,keterangan_jurnal,kode_akun_jurnal,debit,kredit,jenis_transaksi,no_faktur,approved,user_buat) VALUES ('".no_jurnal()."', '$tanggal_sekarang $jam_sekarang', 'Pembelian Tunai - $ss[nama]', '$ambil_setting[pajak]', '$pajak', '0', 'Pembelian', '$data[no_faktur]','1', '$data[user]')");
							}

				}
				else
				{
echo "non";
				    $persediaan = $data_detail['subtotal'];
				    $total_akhir = $data['total'];


				  //PERSEDIAAN    
				        $insert_jurnal = $db->query("INSERT INTO jurnal_trans (nomor_jurnal,waktu_jurnal,keterangan_jurnal,kode_akun_jurnal,debit,kredit,jenis_transaksi,no_faktur,approved,user_buat) VALUES ('".no_jurnal()."', '$tanggal_sekarang $jam_sekarang', 'Pembelian Tunai - $ss[nama]', '$ambil_setting[persediaan]', '$persediaan', '0', 'Pembelian', '$data[no_faktur]','1', '$data[user]')");
				
				}



				//KAS
				        $insert_juranl = $db->query("INSERT INTO jurnal_trans (nomor_jurnal,waktu_jurnal,keterangan_jurnal,kode_akun_jurnal,debit,kredit,jenis_transaksi,no_faktur,approved,user_buat) VALUES ('".no_jurnal()."', '$tanggal_sekarang $jam_sekarang', 'Pembelian Tunai - $ss[nama]', '$data[cara_bayar]', '0', '$total_akhir', 'Pembelian', '$data[no_faktur]','1', '$data[user]')");

				if ($data['potongan'] != "" || $data['potongan'] != 0 ) {
				//POTONGAN
				        $insert_juranl = $db->query("INSERT INTO jurnal_trans (nomor_jurnal,waktu_jurnal,keterangan_jurnal,kode_akun_jurnal,debit,kredit,jenis_transaksi,no_faktur,approved,user_buat) VALUES ('".no_jurnal()."', '$tanggal_sekarang $jam_sekarang', 'Pembelian Tunai - $ss[nama]', '$ambil_setting[potongan]', '0', '$data[potongan]', 'Pembelian', '$data[no_faktur]','1', '$data[user]')");
				}






}
else
{


				if ($total_tax > 0) {
				//ppn == Include
								
echo "include";
				  $persediaan = $data_detail['subtotal'] - $total_tax;
				  $total_akhir = $data['total'];
				  $pajak = $total_tax;


				//PERSEDIAAN    
				        $insert_jurnal = $db->query("INSERT INTO jurnal_trans (nomor_jurnal,waktu_jurnal,keterangan_jurnal,kode_akun_jurnal,debit,kredit,jenis_transaksi,no_faktur,approved,user_buat) VALUES ('".no_jurnal()."', '$tanggal_sekarang $jam_sekarang', 'Pembelian Hutang - $ss[nama]', '$ambil_setting[persediaan]', '$persediaan', '0', 'Pembelian', '$data[no_faktur]','1', '$data[user]')");


							if ($pajak != "" || $pajak != 0) {
							//PAJAK
							        $insert_juranl = $db->query("INSERT INTO jurnal_trans (nomor_jurnal,waktu_jurnal,keterangan_jurnal,kode_akun_jurnal,debit,kredit,jenis_transaksi,no_faktur,approved,user_buat) VALUES ('".no_jurnal()."', '$tanggal_sekarang $jam_sekarang', 'Pembelian Hutang - $ss[nama]', '$ambil_setting[pajak]', '$pajak', '0', 'Pembelian', '$data[no_faktur]','1', '$data[user]')");
							      }


				}

				elseif($data['tax'] > 0) {
	echo "exclude";
				//ppn == Exclude
								    $persediaan = $data_detail['subtotal'];
								    $total_akhir = $data['total'];
				  $pajak = $data['tax'];

						//PERSEDIAAN    
						        $insert_jurnal = $db->query("INSERT INTO jurnal_trans (nomor_jurnal,waktu_jurnal,keterangan_jurnal,kode_akun_jurnal,debit,kredit,jenis_transaksi,no_faktur,approved,user_buat) VALUES ('".no_jurnal()."', '$tanggal_sekarang $jam_sekarang', 'Pembelian Hutang - $ss[nama]', '$ambil_setting[persediaan]', '$persediaan', '0', 'Pembelian', '$data[no_faktur]','1', '$data[user]')");
						if ($pajak != "" || $pajak != 0) {
						//PAJAK
						        $insert_juranl = $db->query("INSERT INTO jurnal_trans (nomor_jurnal,waktu_jurnal,keterangan_jurnal,kode_akun_jurnal,debit,kredit,jenis_transaksi,no_faktur,approved,user_buat) VALUES ('".no_jurnal()."', '$tanggal_sekarang $jam_sekarang', 'Pembelian Hutang - $ss[nama]', '$ambil_setting[pajak]', '$pajak', '0', 'Pembelian', '$data[no_faktur]','1', '$data[user]')");
						      }


				}
				else
				{

					echo "non";
								    $persediaan = $data_detail['subtotal'];
								    $total_akhir = $data['total'];

				      //PERSEDIAAN    
								    
				        $insert_jurnal = $db->query("INSERT INTO jurnal_trans (nomor_jurnal,waktu_jurnal,keterangan_jurnal,kode_akun_jurnal,debit,kredit,jenis_transaksi,no_faktur,approved,user_buat) VALUES ('".no_jurnal()."', '$tanggal_sekarang $jam_sekarang', 'Pembelian Hutang - $ss[nama]', '$ambil_setting[persediaan]', '$persediaan', '0', 'Pembelian', '$data[no_faktur]','1', '$data[user]')");
				}




				//HUTANG    
				        $insert_jurnal = $db->query("INSERT INTO jurnal_trans (nomor_jurnal,waktu_jurnal,keterangan_jurnal,kode_akun_jurnal,debit,kredit,jenis_transaksi,no_faktur,approved,user_buat) VALUES ('".no_jurnal()."', '$tanggal_sekarang $jam_sekarang', 'Pembelian Hutang - $ss[nama]', '$ambil_setting[hutang]', '0', '$data[kredit]', 'Pembelian', '$data[no_faktur]','1', '$data[user]')");

				     if ($data['tunai'] > 0 ) 
				     
				        {
				//KAS
				        $insert_juranl = $db->query("INSERT INTO jurnal_trans (nomor_jurnal,waktu_jurnal,keterangan_jurnal,kode_akun_jurnal,debit,kredit,jenis_transaksi,no_faktur,approved,user_buat) VALUES ('".no_jurnal()."', '$tanggal_sekarang $jam_sekarang', 'Pembelian Hutang - $ss[nama]', '$data[cara_bayar]', '0', '$data[tunai]', 'Pembelian', '$data[no_faktur]','1', '$data[user]')");
				        }


				if ($data['potongan'] != "" || $data['potongan'] != 0 ) {
				//POTONGAN
				        $insert_juranl = $db->query("INSERT INTO jurnal_trans (nomor_jurnal,waktu_jurnal,keterangan_jurnal,kode_akun_jurnal,debit,kredit,jenis_transaksi,no_faktur,approved,user_buat) VALUES ('".no_jurnal()."', '$tanggal_sekarang $jam_sekarang', 'Pembelian Tunai - $ss[nama]', '$ambil_setting[potongan]', '0', '$data[potongan]', 'Pembelian', '$data[no_faktur]','1', '$data[user]')");
				}



}

echo "sukses";


	}


 ?>