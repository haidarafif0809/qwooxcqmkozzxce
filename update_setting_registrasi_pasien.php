<?php
	// memasukan file db.php
    include 'sanitasi.php';
    include 'db.php';
    // mengrim data dengan menggunakan metode POST
    $id = angkadoang($_POST['id']);
    $jenis_edit = $_POST['jenis_edit'];

if ($jenis_edit == 'url_cari') {

    $input_cari = $_POST['input_cari'];

    $query =$db->prepare("UPDATE setting_registrasi_pasien SET url_cari_pasien = ? WHERE id = ?");
    $query->bind_param("si",
        $input_cari, $id);

    $query->execute();

    if (!$query) {
     die('Query Error : '.$db->errno.
     ' - '.$db->error);
    }
    else {

    }
}

if ($jenis_edit == 'url_data') {

    $input_data = $_POST['input_data'];

    $query =$db->prepare("UPDATE setting_registrasi_pasien SET url_data_pasien = ? WHERE id = ?");
    $query->bind_param("si",
        $input_data, $id);

    $query->execute();

    if (!$query) {
     die('Query Error : '.$db->errno.
     ' - '.$db->error);
    }
    else {

    }
}
?>