<?php include 'session_login.php';
include 'header.php';
include 'navbar.php';
include 'db.php';
include_once 'sanitasi.php';

 ?>



<div class="container">

	<h3> FORM TAMBAH DATA PASIEN </h3><br>


<div class="card card-block">
  

<form role="form" action="proses_data_pasien.php" method="POST">

<div class="row"> <!-- Open Row 1 -->
<div class="col-sm-4"> <!-- Col SM 1 -->

<div class="form-group">
  <label for="sel1">Penjamin *</label>
  <select class="form-control ss" id="penjamin" name="penjamin" required="" autocomplete="off">

 <?php 
  $query = $db->query("SELECT nama FROM penjamin ");
  while ( $data = mysqli_fetch_array($query)) 
  {
  echo "<option value='".$data['nama']."'>".$data['nama']."</option>";
  }
 ?>
  </select>
</div>


<div class="form-group">
  <label for="sel1">Nama Pasien</label>
  <input style="height: 20px" type="text" class="form-control" id="nama_lengkap" name="nama_lengkap" autocomplete="off"  style="height: 20px" required="">
</div>

<div class="form-group">
  <label for="sel1">Jenis Kelamin</label>
  <select class="form-control" id="sel1" name="jenis_kelamin" required="" autocomplete="off">
    <option>Laki - Laki</option>
    <option>Perempuan</option> 
  </select>
</div>

<div class="form-group">
    <label for="tanggal_lahir">Tanggal Lahir:</label>
    <input style="height: 20px" type="text" class="form-control" id="tanggal_lahir" name="tanggal_lahir" autocomplete="off" required="">
</div>

<div class="form-group">
    <label for="umur">Umur:</label>
    <input style="height: 20px" type="text" class="form-control" id="umur" name="umur" readonly="" autocomplete="off" required="">
</div>


<div class="form-group">
    <label for="tempat_lahir">Tempat Lahir:</label>
  <input style="height: 20px" type="text" class="form-control" id="tempat_lahir" name="tempat_lahir" required="">
  </div>

<div class="form-group">
  <label for="sel1">Golongan Darah</label>
  <select class="form-control ss" id="gol_darah" name="gol_darah" autocomplete="off" required="">
    <option value="-">-</option>
    <option value="A">A</option>
    <option value="B">B</option>
    <option value="O">O</option>
    <option value="AB">AB</option>
   
  </select>
</div>

<div class="form-group">
  <label for="sel1">Alamat Pasien</label>
  <input style="height: 20px" type="text" class="form-control" id="alamat_sekarang" name="alamat_sekarang" autocomplete="off" required="">
</div>


</div>  <!-- Div Class COL sm 1 -->



<div class="col-sm-4"> <!-- Col SM 2 -->


<div class="form-group">
  <label for="sel1">No KTP</label>
  <input style="height: 20px" type="text" class="form-control" id="no_ktp" name="no_ktp" autocomplete="off" required="">
</div>

<div class="form-group">
  <label for="sel1">Alamat KTP</label>
  <input style="height: 20px" type="text" class="form-control" id="alamat_ktp" name="alamat_ktp" autocomplete="off" required="">
</div>

<div class="form-group">
  <label for="sel1">No HP</label>
  <input style="height: 20px" type="text" class="form-control" id="no_hp" name="no_hp" autocomplete="off" required="">
</div>

<div class="form-group">
  <label for="sel1">Status Perkawinan</label>
  <select class="form-control" id="sel1" name="status_kawin" autocomplete="off" required="">
    <option value="-">-</option>
    <option value="menikah">Menikah</option>
    <option value="belum menikah">Belum Menikah</option>
    <option value="cerai">Cerai</option>
  </select>
</div>


<div class="form-group">
  <label for="sel1">Pendidikan Terakhir</label>
  <select class="form-control" id="sel1" name="pendidikan_terakhir" autocomplete="off" required="">
   <option value="-">-</option>
    <option value="sd">SD</option>
    <option value="smp">SMP</option>
    <option value="sma">SMA / SMK</option>
    <option value="d1">D1</option>
    <option value="d2">D2</option>
    <option value="d3">D3</option>
    <option value="s1">S1</option>
    <option value="s2">S2</option>
   <option value="s3">S3</option>
  </select>
</div>

<div class="form-group">
  <label for="sel1">Agama</label>
  <select class="form-control" id="sel1" name="agama"  autocomplete="off" required="">
  <option value="-">-</option>
    <option value="islam">Islam</option>
    <option value="khatolik">Khatolik</option>
    <option value="kristen">Kristen</option>
    <option value="hindu">Hindu</option>
    <option value="budha">Budha</option>
    <option value="khonghucu">Khonghucu</option>
    <option value="lain - lain">Lain - Lain</option>
  </select>
</div>

<div class="form-group">
    <label for="nama_suamiortu">Nama KK :</label>
    <input style="height: 20px" type="text" class="form-control" id="nama_kk" name="nama_kk" autocomplete="off" required="">
</div>

<div class="form-group">
    <label for="nama_suamiortu">No Keluarga :</label>
    <input style="height: 20px" type="text" class="form-control" id="no_kk" name="no_kk" autocomplete="off" required="">
</div>


</div> <!-- Div Class COL sm 2 -->


<div class="col-sm-4"> <!-- Col SM 3 -->

<div class="form-group">
    <label for="nama_suamiortu">Nama Suami / Orangtua :</label>
    <input style="height: 20px" type="text" class="form-control" id="nama_suamiortu" name="nama_suamiortu" autocomplete="off" >
</div>

<div class="form-group">
    <label for="pekerjaan_pasien">Pekerjaan Pasien/Ortu :</label>
    <input style="height: 20px" type="text" class="form-control" id="pekerjaan_suamiortu" name="pekerjaan_suamiortu" autocomplete="off" required="">
</div>

<div class="form-group">
    <label for="pekerjaan_pasien">Nama Penganggung Jawab :</label>
    <input style="height: 20px" type="text" class="form-control" id="nama_penanggungjawab" name="nama_penanggungjawab" autocomplete="off" required="">
</div>


  <div class="form-group" >
  <label for="umur">Hubungan Dengan Pasien</label>
  <select id="hubungan_dengan_pasien" class="form-control " name="hubungan_dengan_pasien" autocomplete="off" required="">
  <option value="Orang Tua">Orang Tua</option>
  <option value="Suami/Istri">Suami/Istri</option>
  <option value="Anak">Anak</option>
  <option value="Keluarga">Keluarga</option>
  <option value="Teman">Teman</option>
  <option value="Lain - Lain">Lain - Lain</option>  
  </select>  
  </div> 


<div class="form-group">
    <label for="no_hp_penanggung">No Hp Penganggung Jawab :</label>
    <input style="height: 20px" type="text" class="form-control" id="no_hp_penanggung" name="no_hp_penanggung" autocomplete="off" required="">
</div>

<div class="form-group">
    <label for="alamat_penanggung">Alamat Penanggung Jawab:</label>
    <textarea class="form-control" id="alamat_penanggung" name="alamat_penanggung" autocomplete="off" required=""></textarea>
</div>


<button type="submit" class="btn btn-info"><i class='fa fa-plus'></i> Tambah</button>

</div>  <!-- Div Class COL sm 3 --> 
</div>  <!-- Div Class ROW 1 -->
</form>


</div> <!-- END CARD _ BLOCK -->
</div> <!-- Div Closed Container -->


<!--script datepicker-->
<!--script datepicker-->
<script>
  $(function() {
  $( "#tanggal_lahir" ).pickadate({ selectYears: 100, format: 'dd-mm-yyyy'});
  });
  </script>

<!--end script datepicker-->

<!--script cek umur -->


<script type="text/javascript">
$("#tanggal_lahir").change(function(){

function hitung_umur(tanggal_input){

var now = new Date(); //Todays Date   
var birthday = tanggal_input;
birthday=birthday.split("-");   

var dobDay= birthday[0]; 
var dobMonth= birthday[1];
var dobYear= birthday[2];

var nowDay= now.getDate();
var nowMonth = now.getMonth() + 1;  //jan=0 so month+1
var nowYear= now.getFullYear();

var ageyear = nowYear- dobYear;
var agemonth = nowMonth - dobMonth;
var ageday = nowDay- dobDay;
if (agemonth < 0) {
       ageyear--;
       agemonth = (12 + agemonth);
        }
if (nowDay< dobDay) {
      agemonth--;
      ageday = 30 + ageday;
      }


if (ageyear <= 0) {
 var val = agemonth + " Bulan";
}
else {

 var val = ageyear + " Tahun";
}
return val;
}


    var tanggal_lahir = $("#tanggal_lahir").val();
    var umur = hitung_umur(tanggal_lahir);
if (tanggal_lahir == '')
{

}
else
{
  $("#umur").val(umur);
}

  });

</script>


<!--footer-->
<?php 
include 'footer.php';
?>
<!--end footer-->
