<?php 
include 'db.php';
include_once 'sanitasi.php';
	
		$kelas = stringdoang($_POST['kelas']);
		$nama = stringdoang($_POST['nama_kamar']);
		$group_bed = stringdoang($_POST['grup_kamar']);
		$tarif = angkadoang($_POST['tarif']);
		$tarif_2 = angkadoang($_POST['tarif_2']);
		$tarif_3 = angkadoang($_POST['tarif_3']);
		$tarif_4 = angkadoang($_POST['tarif_4']);
		$tarif_5 = angkadoang($_POST['tarif_5']);
		$tarif_6 = angkadoang($_POST['tarif_6']);
		$tarif_7 = angkadoang($_POST['tarif_7']);
		$jumlah_bed = angkadoang($_POST['jumlah_bed']);
		$fasilitas = stringdoang($_POST['fasilitas']);


$query = $db->prepare("INSERT INTO bed (kelas,nama_kamar,group_bed,tarif,fasilitas,tarif_2,tarif_3,tarif_4,tarif_5,tarif_6,tarif_7,jumlah_bed,sisa_bed) VALUES (?,?,?,?,?,?,?,?,?,?,?,?,?) ");

$query->bind_param("sssisiiiiiiii",$kelas,$nama,$group_bed,$tarif,$fasilitas,$tarif_2,$tarif_3,$tarif_4,$tarif_5,$tarif_6,$tarif_7,$jumlah_bed,$jumlah_bed);

$query->execute();

    if (!$query) 
    {
    die('Query Error : '.$db->errno.
    ' - '.$db->error);
    }
	    else{
	    	echo '<META HTTP-EQUIV="Refresh" Content="0; URL=kamar.php">';
	 }


	?>