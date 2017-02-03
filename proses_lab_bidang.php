<?php 
include 'db.php';
include 'sanitasi.php';

$nama = stringdoang($_POST['nama']);

$query = $db->query("INSERT INTO bidang_lab (nama) VALUES ('$nama') ");


$tampikan = $db->query("SELECT * FROM bidang_lab ORDER BY id DESC LIMIT 1");
$data = mysqli_fetch_array($tampikan);
      echo 
      "<tr class='tr-id-".$data['id']."'>
      <td>". $data['nama']."</td>
    
      <td><button data-id='".$data['id']."' data-nama='".$data['nama']."' class='btn btn-success edited'><i class='fa fa-edit'></i>  Edit</button> </td>
      <td><button data-id='".$data['id']."' class='btn btn-danger delete'><i class='fa fa-trash'></i>  Hapus</button></td>
      </tr>";
      
      
 ?>
