<?php 
include 'db.php';
include 'sanitasi.php';

$reg = stringdoang($_POST['reg']);


 ?>
<center>Klik Tombol Untuk Untuk Rujuk Rawat Inap <br>
<a href="rujuk_rawat_inap.php?no_reg=<?php echo $reg;?>"class='btn btn-danger-outline btn-rounded waves-effect'>Rujuk Rawat Inap</a>
</center>