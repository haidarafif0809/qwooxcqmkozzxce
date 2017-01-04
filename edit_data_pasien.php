<?php include 'session_login.php';
include 'header.php';
include 'navbar.php';
include 'db.php';
include_once 'sanitasi.php';

$id = angkadoang($_GET['id']);

$query = $db_pasien->query("SELECT * FROM pelanggan WHERE id ='$id'");
$data = $query->fetch_object();


 ?>



<div class="container">

  <h3> FORM EDIT DATA PASIEN </h3><br>

<div class="card card-block">


<form role="form" action="update_data_pasien.php" method="POST">

<div class="row"> <!-- Open Row 1 -->
<div class="col-sm-4"> <!-- Col SM 1 -->

<div class="form-group">
  <label for="sel1">Nama Pasien</label>
  <input style="height: 20px" type="text" class="form-control" id="nama_lengkap" name="nama_lengkap" autocomplete="off" value="<?php echo $data->nama_pelanggan;?>" >
</div>

<div class="form-group">
  <label for="sel1">Jenis Kelamin</label>
  <select class="form-control" id="sel1" name="jenis_kelamin" required="" autocomplete="off">
  <option value="<?php echo $data->jenis_kelamin;?>"><?php echo $data->jenis_kelamin;?></option>
    <option value="laki-laki">Laki-Laki</option>
    <option value="perempuan">Perempuan</option> 
  </select>
</div>

<div class="form-group">
    <label for="tanggal_lahir">Tanggal Lahir:</label>
    <input style="height: 20px" type="text" class="form-control" id="tanggal_lahir" name="tanggal_lahir" autocomplete="off" value="<?php echo $data->tgl_lahir;?>">
</div>

<div class="form-group">
    <label for="umur">Umur:</label>
    <input style="height: 20px" type="text" class="form-control" id="umur" name="umur" readonly="" autocomplete="off" value="<?php echo $data->umur;?>">
</div>


<div class="form-group">
    <label for="tempat_lahir">Tempat Lahir:</label>
    <input style="height: 20px" type="text" class="form-control" id="tempat_lahir" name="tempat_lahir"  autocomplete="off" value="<?php echo $data->tempat_lahir;?>">
  </div>

  <div class="form-group">
  <label for="sel1">Golongan Darah</label>
  <select class="form-control ss" id="gol_darah" name="gol_darah"  autocomplete="off" >
        <option value="<?php echo $data->gol_darah;?>"><?php echo $data->gol_darah;?></option>
        <option value="-">-</option>
        <option value="A">A</option>
        <option value="B">B</option>
        <option value="O">O</option>
        <option value="AB">AB</option> 
  </select>
</div>

<div class="form-group">
  <label for="sel1">Alamat Pasien</label>
  <input style="height: 20px" type="text" class="form-control" id="alamat_sekarang" name="alamat_sekarang"  autocomplete="off" value="<?php echo $data->alamat_sekarang;?>">
</div>





</div>  <!-- Div Class COL sm 1 -->



<div class="col-sm-4"> <!-- Col SM 2 -->

<div class="form-group">
  <label for="sel1">No KTP</label>
  <input style="height: 20px" type="text" class="form-control" id="no_ktp" name="no_ktp" autocomplete="off" value="<?php echo $data->no_ktp;?>">
</div>

<div class="form-group">
  <label for="sel1">Alamat KTP</label>
  <input style="height: 20px" type="text" class="form-control" id="alamat_ktp" name="alamat_ktp" autocomplete="off" value="<?php echo $data->alamat_ktp;?>" >
</div>





<div class="form-group">
  <label for="sel1">No HP</label>
  <input style="height: 20px" type="text" class="form-control" id="no_hp" name="no_hp" autocomplete="off" value="<?php echo $data->no_telp;?>">
</div>

<div class="form-group">
  <label for="sel1">Status Perkawinan</label>
  <select class="form-control" id="sel1" name="status_kawin" autocomplete="off">
  <option value="<?php echo $data->status_kawin;?>"><?php echo $data->status_kawin;?></option>
    <option value="menikah">Menikah</option>
    <option value="belum menikah">Belum Menikah</option>
    <option value="cerai">Cerai</option>
  </select>
</div>


<div class="form-group">
  <label for="sel1">Pendidikan Terakhir</label>
  <select class="form-control" id="sel1" name="pendidikan_terakhir" autocomplete="off">
  
      <option value="<?php echo $data->pendidikan_terakhir;?>"><?php echo $data->pendidikan_terakhir;?></option>
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
  <select class="form-control" id="sel1" name="agama"  autocomplete="off">
  	<option value="<?php echo $data->agama;?>"><?php echo $data->agama;?></option>
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
    <input style="height: 20px" type="text" class="form-control" id="nama_kk" name="nama_kk" value="<?php echo $data->nama_kk;?>" autocomplete="off" >
</div>





</div> <!-- Div Class COL sm 2 -->


<div class="col-sm-4"> <!-- Col SM 3 -->

<div class="form-group">
    <label for="nama_suamiortu">No Keluarga :</label>
    <input style="height: 20px" type="text" class="form-control" id="no_kk" name="no_kk" value="<?php echo $data->no_kk;?>" autocomplete="off">
</div>

<div class="form-group">
    <label for="nama_suamiortu">Nama Suami / Orangtua :</label>
    <input style="height: 20px" type="text" class="form-control" id="nama_suamiortu" name="nama_suamiortu" autocomplete="off" value="<?php echo $data->nama_suamiortu;?>">
</div>

<div class="form-group">
    <label for="pekerjaan_pasien">Pekerjaan Pasien/Ortu :</label>
    <input style="height: 20px" type="text" class="form-control" id="pekerjaan_suamiortu" name="pekerjaan_suamiortu" autocomplete="off" value="<?php echo $data->pekerjaan_suamiortu;?>">
</div>

<div class="form-group">
    <label for="pekerjaan_pasien">Nama Penganggung Jawab :</label>
    <input style="height: 20px" type="text" class="form-control" id="nama_penanggungjawab" name="nama_penanggungjawab" autocomplete="off" value="<?php echo $data->nama_penanggungjawab;?>">
</div>


  <div class="form-group" >
  <label for="umur">Hubungan Dengan Pasien</label>
  <select id="hubungan_dengan_pasien" class="form-control " name="hubungan_dengan_pasien" autocomplete="off">
  	<option value="<?php echo $data->hubungan_dengan_pasien;?>"><?php echo $data->hubungan_dengan_pasien;?></option>}
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
    <input style="height: 20px" type="text" class="form-control" id="no_hp_penanggung" name="no_hp_penanggung" autocomplete="off" value="<?php echo $data->no_hp_penanggung;?>">
</div>

<div class="form-group">
    <label for="alamat_penanggung">Alamat Penanggung Jawab:</label>
    <textarea class="form-control" id="alamat_penanggung" name="alamat_penanggung" autocomplete="off"><?php echo $data->alamat_penanggung;?></textarea>
</div>

<input style="height: 20px" type="hidden" id="id" name="id" value="<?php echo $data->id; ?>">

<button type="submit" class="btn btn-info"><i class='fa fa-save'></i> Simpan</button>

</div>  <!-- Div Class COL sm 3 --> 
</div>  <!-- Div Class ROW 1 -->
</form>

  
</div> <!-- END card-block -->
</div> <!-- Div Closed Container -->


 <script>
        
        window.onload=function(){
            $('#tanggal_lahir').on('change', function() {
                var dob = new Date(this.value);
                var today = new Date();
                var age = Math.floor((today-dob) / (365.25 * 24 * 60 * 60 * 1000));
                $('#umur').val(age);
            });
        }
 
    </script>

<!--script datepicker-->

<script>
  $(function() {
  $( "#tanggal_lahir" ).pickadate({ selectYears: 100, format: 'yyyy-mm-dd'});
  });
  </script>
<!--end script datepicker-->


<!--footer-->
<?php 
include 'footer.php';
?>
<!--end footer-->
