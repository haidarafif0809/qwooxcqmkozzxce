<?php 
include 'db.php';
include 'sanitasi.php';

include_once 'cache.class.php';

$printer = stringdoang($_POST['printer']);
$status = stringdoang($_POST['status']);

$update ="UPDATE setting_printer SET nama_print = '$printer', status_print = '$status' ";

if ($db->query($update) === TRUE) {
    
} else {
    echo "Error: " . $update . "<br>" . $db->error;
}



 	$c = new Cache();

	$c->setCache('setting_printer');

    $c->store('data',array('nama_print' => $printer,'status_print' => $status));
         


echo '<META HTTP-EQUIV="Refresh" Content="0; URL=setting_printer.php">';

 ?>
