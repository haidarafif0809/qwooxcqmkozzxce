<?php include 'session_login.php';
include 'sanitasi.php';
include 'db.php';


$pilih_akses_sub_operasi = $db->query("SELECT sub_operasi_tambah, sub_operasi_edit, sub_operasi_hapus, sub_operasi_lihat, detail_sub_operasi_lihat FROM otoritas_master_data WHERE id_otoritas = '$_SESSION[otoritas_id]'");
$sub_operasi = mysqli_fetch_array($pilih_akses_sub_operasi);     

$query = $db->prepare("UPDATE sub_operasi SET id_kelas_kamar = ?, id_cito = ?, harga_jual = ?
WHERE id_sub_operasi = ?");

$query->bind_param("ssii", $kelas, $cito, $harga, $sub);
	
	$kelas = stringdoang($_POST['kelas']);
	$cito = stringdoang($_POST['cito']);
    $harga = angkadoang($_POST['harga']);
	$sub = angkadoang($_POST['sub']);
    $id_operasi = angkadoang($_POST['id_operasi_edit']);

$query->execute();


    if (!$query) 
    {
    die('Query Error : '.$db->errno.
    ' - '.$db->error);
    }

  $sadsa = $db->query("SELECT * FROM sub_operasi WHERE id_operasi = '$id_operasi' AND id_sub_operasi = '$sub' ORDER BY id_operasi DESC LIMIT 1 ");
  $data = mysqli_fetch_array($sadsa);


        $seelect_op = $db->query("SELECT id_operasi,nama_operasi FROM operasi WHERE id_operasi = '$data[id_operasi]' ");
        $out_op = mysqli_fetch_array($seelect_op);

        $nama_operasi = $out_op['nama_operasi'];


        $select_kelas = $db->query("SELECT id,nama FROM kelas_kamar WHERE id = '$data[id_kelas_kamar]' ");
        $out_kelas = mysqli_fetch_array($select_kelas);
          
            $kelas = $out_kelas['nama'];


        $select_cito = $db->query("SELECT id,nama FROM cito WHERE id = '$data[id_cito]' ");
        $out_cito = mysqli_fetch_array($select_cito);

            $cito = $out_cito['nama'];
       

      echo "<tr class='tr-id-".$data['id_sub_operasi']."'>

            <td>". $nama_operasi ."</td>
            <td>". $kelas ."</td>
            <td>". $cito ."</td>
            <td> ". rp($data['harga_jual']) ."</td>";

if ($sub_operasi['detail_sub_operasi_lihat'] > 0) {
  echo "<td><a style='width:99px;' href='detail_operasi.php?id=".$data["id_sub_operasi"]."&nama_operasi=".$nama_operasi."&kelas=".$kelas."&cito=".$cito."&harga_jual=".$data["harga_jual"]."&id_operasi=".$data["id_operasi"]."' class='btn btn-success'>Detail Operasi </a></td>";
}
else{
  echo "<td> </td>";
}

if ($sub_operasi['sub_operasi_edit'] > 0) {
  echo "<td> <button class='btn btn-warning btn-edit' data-id-sub='". $data['id_sub_operasi'] ."' data-id-op='". $nama_operasi ."' data-id-kelas='". $data['id_kelas_kamar'] ."' data-id-cito='". $data['id_cito'] ."' data-harga='". $data['harga_jual'] ."'><span class='glyphicon glyphicon-edit'> </span> Edit </button> </td>";
}
else{
    echo "<td>  </td>";
}

if ($sub_operasi['sub_operasi_hapus'] > 0) {
  echo " <td> <button class='btn btn-danger delete' data-id='". $data['id_sub_operasi'] ."' data-kelas='". $kelas ."' data-namacit='". $cito ."' data-namaoper='". $nama_operasi ."'> <span class='glyphicon glyphicon-trash'> </span> Hapus </button> </td>";
}
else{
   echo " <td> </td>";
}

echo "</tr>";

?>