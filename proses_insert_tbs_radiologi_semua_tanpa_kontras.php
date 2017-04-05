<?php  session_start();
include 'db.php';
include 'sanitasi.php';


$session_id = session_id();

$tipe_barang = stringdoang($_POST['tipe_barang']);
$tanggal_sekarang = date('Y-m-d');
$jam_sekarang = date('H:i:s');
$no_reg  = stringdoang($_POST['no_reg']);
$kontras = 0;
$dokter_pengirim = stringdoang($_POST['dokter']);
$dokter_periksa = stringdoang($_POST['dokter_pemeriksa']);
$petugas_radiologi = stringdoang($_POST['petugas_radiologi']);

$jumlah_barang = 1;

//INSERT SELURUH PRODUK RADIOLOGI (KONTRAS) KE TBS RADIOLOGI

$query_pemeriksaan_radiologi = $db->query("SELECT kode_pemeriksaan, nama_pemeriksaan, harga_1, kontras FROM pemeriksaan_radiologi WHERE kontras = '0'");
    while ($data_pemeriksaan_radiologi = mysqli_fetch_array($query_pemeriksaan_radiologi))
      {
      	$subtotal = $data_pemeriksaan_radiologi['harga_1'] * $jumlah_barang;
      	$query_tbs_radiologi = $db->query("SELECT kode_barang FROM tbs_penjualan_radiologi WHERE kode_barang = '$data_pemeriksaan_radiologi[kode_pemeriksaan]' AND no_reg = '$no_reg'");
		$data_tbs_radiologi = mysqli_fetch_array($query_tbs_radiologi);

      	if ($data_pemeriksaan_radiologi['kode_pemeriksaan'] == $data_tbs_radiologi['kode_barang']) {
      		//TIDAK MELAKUKAN PROSES APAPUN KARENA PRODUK (JASA) SUDAH DIINPUT SEBELUMNYA
      	}
      	else{

			$insert_tbs = "INSERT INTO tbs_penjualan_radiologi (session_id, kode_barang, nama_barang, jumlah_barang, harga, subtotal, tipe_barang, tanggal, jam, no_reg, kontras, dokter_pengirim, dokter_pelaksana, radiologi, status_pilih) VALUES ('$session_id', '$data_pemeriksaan_radiologi[kode_pemeriksaan]', '$data_pemeriksaan_radiologi[nama_pemeriksaan]', '$jumlah_barang', $data_pemeriksaan_radiologi[harga_1], $subtotal, '$tipe_barang', '$tanggal_sekarang', '$jam_sekarang', '$no_reg', '$data_pemeriksaan_radiologi[kontras]', '$dokter_pengirim', '$petugas_radiologi', 'Radiologi', 'Pilih Semua' )";

			    if ($db->query($insert_tbs) === TRUE){                        
			    } 
			    else{
			      echo "Error: " . $insert_tbs . "<br>" . $db->error;
			    }

		}

	  }

?>