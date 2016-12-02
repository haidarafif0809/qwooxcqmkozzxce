<?php 
include 'db.php';
include_once 'sanitasi.php';

$id = angkadoang($_POST['id']);
$dosis = stringdoang($_POST['dosis']);


$query = $db->query("UPDATE detail_penjualan SET dosis = '$dosis' WHERE id = '$id'  ");




	?>

	<!--  Script Untuk Proses Edit Dosis -->
<script type="text/javascript">
$(".input-dosis").blur(function(){

var id = $(this).attr('data-id');
var dosis = $(this).val();

if (dosis == 0)
{

}
else
  {
$.post('proses_dosis.php',{id:id,dosis:dosis},function(data){ // INI PROSES POST NYA
 
     $("#input-dosis-"+id+"").attr('type','hidden'); // di hidden dari double clicknya
       $("#text-dosis-"+id+"").show(); // text dosis tampilkan lagi
      $("#text-dosis-"+id+"").text(dosis); // untuk ubah text nya yang di masukin baru
    });
  }
});
</script>
<!--  END Script Untuk Proses Edit Dosis  -->