<?php include 'session_login.php';

include 'header.php';
include 'navbar.php';
include 'db.php';

include_once 'sanitasi.php';

$id = angkadoang($_GET['id']);

$data = $db->query("SELECT * FROM penjamin WHERE id='$id' ");
$rows = $data->fetch_object();


 ?>

<div class="container">
<h3><b> EDIT DATA PENJAMIN </b></h3> <hr>
<br>

<form role="form" action="update_penjamin.php" method="POST">

<div class="form-group">
  <label for="sel1">Nama </label>
  <input type="text" class="form-control" autocomplete="off" id="nama" name="nama" value="<?php echo $rows->nama; ?>">
    <input type="hidden" class="form-control" id="show_name" name="show_name" value="<?php echo $rows->nama; ?>">

</div>

<div class="form-group">
  <label for="sel1">Alamat</label>
  <input type="text" class="form-control" autocomplete="off" id="alamat" name="alamat" value="<?php echo $rows->alamat; ?>">
</div>

<div class="form-group">
  <label for="sel1">No Telp</label>
  <input type="text" class="form-control" autocomplete="off" id="no_telp" name="no_telp" value="<?php echo $rows->no_telp; ?>">
</div>

<div class="form-group">
  <label for="sel1">Level Harga</label>
  <select class="form-control" id="level_harga" name="level_harga">
    <option value="<?php echo $rows->harga ; ?>"><?php echo $rows->harga; ?></option> 
    <option value="harga_1">Level 1</option> 
    <option value="harga_2">Level 2</option> 
    <option value="harga_3">Level 3</option> 
     <option value="harga_4">Level 4</option> 
    <option value="harga_5">Level 5</option> 
    <option value="harga_6">Level 6</option> 
    <option value="harga_7">Level 7</option> 

</select>
</div>


<div class="form-group">
    <label for="penjamin">Penetapan Jatuh Tempo:</label>
    <input type="number" class="form-control" autocomplete="off" id="jatuh_tempo" name="jatuh_tempo" placeholder="Isi Jika ada Perjanjian Tanggal Jatuh Tempo" autocomplete="off" value="<?php echo $rows->jatuh_tempo; ?>">
</div>

<div class="form-group">
  <label for="sel1">Cakupan Layanan</label>
  <textarea class="form-control" id="layanan" autocomplete="off" name="layanan" style="height:500px" value="<?php echo $rows->cakupan_layanan; ?>"><?php echo $rows->cakupan_layanan; ?></textarea>
</div>

<!--  open hidden  -->
<input type="hidden" id="id" name="id" value="<?php echo $rows->id; ?>">
<!--  closed hidden  -->

<button type="submit" class="btn btn-info"><span class='glyphicon glyphicon-wrench'></span> Edit</button>
</form>
</div> <!--  container  -->



<script type="text/javascript">
$("#nama").blur(function(){

var nama = $("#nama").val();
var show_name = $("#show_name").val();

// cek namanya
if (nama == show_name)
{
}
else
{
 $.post('cek_penjamin.php',{nama:nama}, function(data){

        if(data == 1){
          alert('Nama Penjamin sudah ada!');
          $("#nama").val(show_name);
          $("#nama").focus();
        }
        else
        {
        }



// Finish Proses
     }); // end post dari cek nama
}
});
</script>


<script type="text/javascript">
$(function () {
 $("#layanan").wysihtml5();

});
</script>

<!--  footer  -->
<?php 
include'footer.php';
?>
<!--  closed footer  -->

