<?php 
    include 'sanitasi.php';
    include 'db.php';

    // mengrim data dengan menggunakan metode POST
    $no_reg = stringdoang($_POST['no_reg_ket']);       
    $kode = stringdoang($_POST['kode_ket']);       
    $keterangan = $_POST['keterangan'];
       
       $query =$db->prepare("UPDATE tbs_penjualan_radiologi SET keterangan = ?  WHERE kode_barang = ? AND no_reg = ?");

       $query->bind_param("sss",
       $keterangan, $kode, $no_reg);


       $query->execute();

		if (!$query) 
		{
		 die('Query Error : '.$db->errno.
		 ' - '.$db->error);
		}
		else 
		{

		}
 ?>