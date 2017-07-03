<?php session_start();
include 'db.php';
include 'sanitasi.php';


$kode_barang = stringdoang($_POST['kode_barang']);
$barang_tujuan = stringdoang($_POST['barang_tujuan']);
$session_id = session_id();

	if (isset($_POST['no_faktur'])) {
		
		$no_faktur = stringdoang($_POST['no_faktur']);


		$query = $db->query("SELECT kode_barang FROM tbs_transfer_stok WHERE (kode_barang = '$kode_barang' AND kode_barang_tujuan = '$barang_tujuan'  OR kode_barang = '$barang_tujuan')
		AND (session_id  = '' OR session_id IS NULL) AND no_faktur = '$no_faktur' ");

	}
	else{

		$query = $db->query("SELECT kode_barang FROM tbs_transfer_stok WHERE  (kode_barang = '$kode_barang' AND kode_barang_tujuan = '$barang_tujuan'  OR kode_barang = '$barang_tujuan')
		AND (no_faktur  = '' OR no_faktur IS NULL) AND session_id = '$session_id' ");

	}

		$jumlah = mysqli_num_rows($query);

		if ($jumlah > 0){

		  echo 1;
		}
		else {

		}
        //Untuk Memutuskan Koneksi Ke Database

        mysqli_close($db); 

 ?>

