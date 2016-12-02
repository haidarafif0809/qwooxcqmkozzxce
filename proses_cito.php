<?php session_start();
    // memasukan file yang ada pada db.php
    include 'sanitasi.php';
    include 'db.php';
 
    // mengirim data menggunakan metode POST

$pilih_akses_cito = $db->query("SELECT cito_tambah, cito_edit, cito_hapus FROM otoritas_master_data WHERE id_otoritas = '$_SESSION[otoritas_id]'");
$cito = mysqli_fetch_array($pilih_akses_cito);

    $perintah = $db->prepare("INSERT INTO cito (nama) VALUES (?)");

    $perintah->bind_param("s",
        $nama);
        
        $nama = stringdoang($_POST['nama']); 
    
    $perintah->execute();



if (!$perintah) 
{
 die('Query Error : '.$db->errno.
 ' - '.$db->error);
}
else 
{
}


// UNTUK MENAMPILKAN DATA (BERHUBUNGAN DENGAN JS PREPAND DI FORM)
$query = $db->query("SELECT * FROM cito ORDER BY id DESC LIMIT 1");
$data = mysqli_fetch_array($query);

                //menampilkan data
            echo "<tr class='tr-id-".$data['id']."'>
            
            <td>". $data['nama'] ."</td>";


if ($cito['cito_hapus']) {
    echo "<td> <button class='btn btn-danger btn-hapus' data-id='". $data['id'] ."' data-nama='". $data['nama'] ."'> <i class='fa fa-trash'> </i> Hapus </button> </td>";
}
else {
    echo "<td>  </td>";
}


if ($cito['cito_edit']) {
    echo "<td> <button class='btn btn-info btn-edit' data-nama='". $data['nama'] ."' data-id='". $data['id'] ."'> <i class='fa fa-edit'> </i> Edit </button> </td>";
}
else {
    echo "<td>  </td>";
}


            echo "</tr>";
            
//Untuk Memutuskan Koneksi Ke Database
mysqli_close($db);   

    ?>

