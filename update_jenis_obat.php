<?php
require_once 'db.php';
require_once 'sanitasi.php';

$id = angkadoang($_POST['id']);
$nama = stringdoang($_POST['nama']);

echo $query = "UPDATE jenis SET nama = '$nama' WHERE id='$id'";
if ($db->query($query) === TRUE) 
  {


} 
else 
    {
    echo "Error: " . $query . "<br>" . $db->error;
    } 

?>