<?php 
include 'db.php';
include_once 'sanitasi.php';

$id = stringdoang($_POST['id']);
$nama = stringdoang($_POST['nama']);

$query = $db->query("UPDATE bidang_lab SET nama='$nama'  WHERE id = '$id' ");


 ?>

   <?php 

$query = $db->query("SELECT * FROM bidang_lab  WHERE id = '$id' ORDER BY id DESC LIMIT 1");
   $data = mysqli_fetch_array($query);

      echo "
      <tr class='tr-id-".$data['id']."'>

      <td>". $data['nama']."</td>
    
      <td><button data-id='".$data['id']."' data-nama='".$data['nama']."' class='btn btn-success edited'><i class='fa fa-edit'></i>  Edit</button> </td>
      <td><button data-id='".$data['id']."' class='btn btn-danger delete'><i class='fa fa-trash'></i>  Hapus</button></td>
      </tr>";
      

    ?>
