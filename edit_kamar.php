<?php include 'session_login.php';


include 'header.php';
include 'navbar.php';
include 'db.php';
include_once 'sanitasi.php';

$id = angkadoang($_GET['id']);

$dataa = $db->query("SELECT * FROM bed WHERE id = '$id' ");
$data = mysqli_fetch_array($dataa);
$nama = $data['nama_kamar'];
$group_bed = $data['group_bed'];
$tarif = $data['tarif'];
$tarif_2 = $data['tarif_2'];
$tarif_3 = $data['tarif_3'];
$tarif_4 = $data['tarif_4'];
$tarif_5 = $data['tarif_5'];
$tarif_6 = $data['tarif_6'];
$tarif_7 = $data['tarif_7'];
$fasilitas = $data['fasilitas'];
$jumlah_bed = $data['jumlah_bed'];

$select_kelas = $db->query("SELECT id,nama FROM kelas_kamar");
        while($out_kelas = mysqli_fetch_array($select_kelas))
        {
          if($data['kelas'] == $out_kelas['id'])
          {
            $kelas = $out_kelas['nama'];
            $id_kelas = $out_kelas['id'];
          }
        }



?>

<div class="container">

<h3><b>EDIT DATA KAMAR </b></h3> <hr>

<form role="form" action="proses_edit_bed.php" method="POST">

<div class="form-group">
  <label for="sel1">Kelas</label>
  <select class="form-control" id="kelas" name="kelas" autocomplete="off" required="">
    <option value="<?php echo $id_kelas ?>"> <?php echo $kelas ?> </option>
     <?php 
          // menampilkan seluruh data yang ada pada tabel suplier
          $query = $db->query("SELECT * FROM kelas_kamar");

          // menyimpan data sementara yang ada pada $query
          while($data = mysqli_fetch_array($query))
          {
          echo "<option value='".$data['id']."'>".$data['nama'] ."</option>";
          }
          ?>
  </select>
</div>


<div class="form-group">
  <label for="sel1">Kode Kamar</label>
  <input type="text" class="form-control" value="<?php echo $nama?>" style="height: 20px" id="nama_kamar" name="nama_kamar" required="" autocomplete="off">

    <input type="hidden" class="form-control" value="<?php echo $nama?>" style="height: 20px" id="kodenya" name="kodenya" required="" autocomplete="off">
</div>

<div class="form-group">
  <label for="sel1">Nama Kamar</label>
  <input type="text"  class="form-control" value="<?php echo $group_bed ?>" style="height: 20px" id="grup_kamar" name="grup_kamar" required="" autocomplete="off">
 </div>


<div class="form-group">
  <label for="sel1">Harga 1</label>
  <input type="text" class="form-control" value="<?php echo $tarif ?>" style="height: 20px" id="tarif" name="tarif" required="" autocomplete="off">
</div>


<div class="form-group">
  <label for="sel1">Harga 2</label>
  <input type="text" class="form-control" value="<?php echo $tarif_2 ?>" style="height: 20px" id="tarif_2" name="tarif_2" required="" autocomplete="off">
</div>


<div class="form-group">
  <label for="sel1">Harga 3</label>
  <input type="text" class="form-control" value="<?php echo $tarif_3 ?>" style="height: 20px" id="tarif_3" name="tarif_3" required="" autocomplete="off">
</div>

<div class="form-group">
  <label for="sel1">Harga 4</label>
  <input type="text" class="form-control" value="<?php echo $tarif_4?>" style="height: 20px" id="tarif_4" name="tarif_4" required="" autocomplete="off">
</div>

<div class="form-group">
  <label for="sel1">Harga 5</label>
  <input type="text" class="form-control" value="<?php echo $tarif_5?>" style="height: 20px" id="tarif_5" name="tarif_5" required="" autocomplete="off">
</div>

<div class="form-group">
  <label for="sel1">Harga 6</label>
  <input type="text" class="form-control" value="<?php echo $tarif_6?>" style="height: 20px" id="tarif_6" name="tarif_6" required="" autocomplete="off">
</div>

<div class="form-group">
  <label for="sel1">Harga 7</label> 
  <input type="text" class="form-control" value="<?php echo $tarif_7?>" style="height: 20px" id="tarif_7" name="tarif_7" required="" autocomplete="off">
</div>

<div class="form-group">
  <label for="sel1">Fasilitas</label>
  <input type="text" class="form-control" value="<?php echo $fasilitas?>" style="height: 20px" id="fasilitas" name="fasilitas" required="" autocomplete="off">
</div>

<div class="form-group">
  <label for="sel1">Jumlah Bed</label>
  <input type="number" class="form-control" value="<?php echo $jumlah_bed?>" style="height: 20px" id="jumlah_bed" name="jumlah_bed" required="" autocomplete="off">
</div>

<input type="hidden" class="form-control" value="<?php echo $id ?>" style="height: 20px" id="jumlah_bed" name="id" required="" autocomplete="off">
<button type="submit" class="btn btn-info"><i class="fa fa-edit"></i> Edit</button>
</form>


</div>


<script type="text/javascript">
$("#nama_kamar").blur(function(){

var nama = $("#nama_kamar").val();
var kodenya = $("#kodenya").val();

if(nama == kodenya)
{

}
else
{
// cek namanya
 $.post('cek_kode_kamar.php',{nama:nama}, function(data){

        if(data == 1){
          alert('Kode Kamar Sudah Ada!');
          $("#nama_kamar").val(kodenya);
          $("#nama_kamar").focus();
        }
        else{

// Finish Proses
        }

      }); // end post dari cek nama
}
});
</script>

<!--FOOTER-->
<?php 
include 'footer.php';
?>
<!--END FOOTER-->