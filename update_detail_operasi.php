<?php include 'session_login.php';  
include 'sanitasi.php';
include 'db.php';

$pilih_akses_detail_sub_operasi = $db->query("SELECT detail_sub_operasi_tambah, detail_sub_operasi_edit, detail_sub_operasi_hapus, detail_sub_operasi_lihat FROM otoritas_master_data WHERE id_otoritas = '$_SESSION[otoritas_id]'");
$detail_sub_operasi = mysqli_fetch_array($pilih_akses_detail_sub_operasi); 

$query = $db->prepare("UPDATE detail_operasi SET nama_detail_operasi = ?, id_jabatan = ?, jumlah_persentase = ? WHERE id_detail_operasi = ?");

$query->bind_param("ssss",  $nama, $jabatan, $persentase, $id);
	
	$nama = stringdoang($_POST['nama']);
	$jabatan = stringdoang($_POST['jabatan']);
    $persentase = stringdoang($_POST['persentase']);
    $id = stringdoang($_POST['id']);
    $id_sub_operasi = stringdoang($_POST['id_sub_operasi']);

$query->execute();


    if (!$query) 
    {
    die('Query Error : '.$db->errno.
    ' - '.$db->error);
    }


   $query = $db->query("SELECT * FROM detail_operasi WHERE id_sub_operasi = '$id_sub_operasi' AND id_detail_operasi = '$id' ");
   $data = mysqli_fetch_array($query);      
      

         $seelect_op = $db->query("SELECT id,nama FROM jabatan");
        while($out_op = mysqli_fetch_array($seelect_op))
        {
          if($data['id_jabatan'] == $out_op['id'])
          {
            $jabatan = $out_op['nama'];
          }
          else
          {

          }
        }
        
      echo "<tr class='tr-id-".$data['id_detail_operasi']."'>

            <td>". $data['nama_detail_operasi'] ."</td>
            <td>". $jabatan ."</td>
            <td>". $data['jumlah_persentase'] ." %</td>";

if ($detail_sub_operasi['detail_sub_operasi_edit'] > 0) {
  echo "<td> <button class='btn btn-warning btn-edit' data-id='". $data['id_detail_operasi'] ."'
  data-nama='". $data['nama_detail_operasi'] ."' data-jabatan='". $data['id_jabatan'] ."' 
  data-persentase='". $data['jumlah_persentase'] ."'>
  <span class='glyphicon glyphicon-edit'> </span> Edit </button> </td>";
}
else{
  echo "<td> </td>";
}

if ($detail_sub_operasi['detail_sub_operasi_hapus'] > 0) {
  echo "<td> <button class='btn btn-danger delete' data-id='". $data['id_detail_operasi'] ."'
     data-nama='". $data['nama_detail_operasi'] ."'> <span class='glyphicon glyphicon-trash'> </span> Hapus </button> </td>";
}
     
echo "</tr>";
      

    //Untuk Memutuskan Koneksi Ke Database
mysqli_close($db);   
?>