<?php include 'session_login.php';
include 'header.php';
include 'navbar.php';
include 'db.php';
include_once 'sanitasi.php';

$jam =  date("H:i:s");
$tanggal_sekarang = date("Y-m-d");
$waktu = date("Y-m-d H:i:s");
$bulan_php = date('m');
$tahun_php = date('Y');

$no_reg = stringdoang($_GET['no_reg']);



$query7 = $db->query("SELECT * FROM registrasi WHERE no_reg = '$no_reg' ");
$regis = mysqli_fetch_array($query7);


$query8 = $db->query("SELECT * FROM pelanggan WHERE kode_pelanggan = '$regis[no_rm]' ");
$pelanggan = mysqli_fetch_array($query8);


$query9 = $db->query("SELECT * FROM rekam_medik_inap WHERE no_reg = '$no_reg' ");
$rekam = mysqli_fetch_array($query9);

$qertu= $db->query("SELECT nama_dokter,nama_paramedik,nama_farmasi FROM penetapan_petugas ");
$ss = mysqli_fetch_array($qertu);

$q_penetapan = $db->query("SELECT * FROM penetapan_petugas");
$v_penetapan = mysqli_fetch_array($q_penetapan);
$nama_dokter  = $v_penetapan['nama_dokter'];

$q = $db->query("SELECT tampil_ttv,tampil_data_pasien_umum FROM setting_registrasi");
$dq = mysqli_fetch_array($q);

?>
<style>
  .disable5{
    background-color: #cccccc;
    opacity: 0.9;
    cursor: not-allowed;
}


</style>

<script type="text/javascript">
  function isNumberKey(evt)
      {
         var charCode = (evt.which) ? evt.which : event.keyCode
         if (charCode > 31 && (charCode < 48 || charCode > 57))
            return false;

         return true;
      }
</script>

<!-- Modalkamar -->
<div id="myModal1" class="modal fade" role="dialog">
  <div class="modal-dialog">

    <!-- Modal content2 -->
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title">Pencarian Kamar Pasien </h4>
      </div>
      <div class="modal-body">
      <div class="table-responsive">
        <table id="siswa1" class="table table-bordered table-hover table-striped">
          <thead>
          <tr>
          <th>Kelas</th>
          <th>Kode Kamar</th>
          <th>Nama Kamar</th>
          <th>Fasilitas</th>
          <th>Jumlah Bed </th>
          <th> Sisa Bed </th>                         
          </tr>
          </thead>
          <tbody>
          <?php
          //Data mentah yang ditampilkan ke tabel    
          include 'db.php';
          $hasil = $db->query("SELECT * FROM bed WHERE sisa_bed != 0 ");
                                        
          while ($data =  $hasil->fetch_assoc()) {
             $select_kelas = $db->query("SELECT id,nama FROM kelas_kamar");
        while($out_kelas = mysqli_fetch_array($select_kelas))
        {
          if($data['kelas'] == $out_kelas['id'])
          {
            $kelas = $out_kelas['nama'];
          }
        }
          ?>
          <tr class="pilih2" 
          data-nama="<?php echo $data['nama_kamar']; ?>" 
          data-group-bed="<?php echo $data['group_bed']; ?>" >
          <td><?php echo $kelas; ?></td>
          <td><?php echo $data['nama_kamar']; ?></td>
          <td><?php echo $data['group_bed']; ?></td>
          <td><?php echo $data['fasilitas']; ?></td>
        <td><?php echo $data['jumlah_bed']; ?></td>         
          <td><?php echo $data['sisa_bed']; ?></td>
                                        
          </tr>
          <?php
          }
          ?>
          </tbody>
          </table>  
       </div> <!-- table responsive  -->
        </div>
        <div class="modal-footer">
        <button type="button" accesskey="o" class="btn btn-danger" data-dismiss="modal">Cl<u>o</u>se</button>
        </div>
        </div>
        
        </div>
        </div> 
<!-- akhir modal Kamar-->

 

<!-- Modal Untuk Confirm LAYANAN PERUSAHAAN-->
<div id="detail" class="modal fade" role="dialog">
  <div class="modal-dialog modal-lg">
    <!-- Modal content-->
    <div class="modal-content">
    <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>       
    </div>
    <div class="modal-body">

      <span id="tampil_layanan">
      </span>
    </div>
    <div class="modal-footer">
        
        <button type="button" class="btn btn-danger" data-dismiss="modal">Closed</button>
    </div>
    </div>
  </div>
</div>
<!--modal end Layanan Perusahaan-->




<div style="padding-left:5%; padding-right:5%;">
  <h3>REGISTRASI PASIEN BARU RAWAT INAP</h3><hr>


  <a href="rawat_inap.php" class="btn btn-primary" data-toggle='tooltip' data-placement='top' title='Klik untuk kembali ke utama.'><i class="fa fa-reply"></i>Kembali</a>

<button id="coba" type="submit" class="btn btn-danger" data-toggle="collapse" data-target="#demo" accesskey="r" ><i class='fa fa-search'> </i>&nbsp;Cari Pasien</button>



<div id="demo" class="collapse">

<table id="pasien_inap_baru" class="display table-sm table-bordered" width="100%">
          <thead>
            <tr>
              <th style='background-color: #4CAF50; color: white' >No. RM </th>
              <th style='background-color: #4CAF50; color: white' >Nama Lengkap</th>
              <th style='background-color: #4CAF50; color: white' >Jenis Kelamin</th>
              <th style='background-color: #4CAF50; color: white' >Alamat Sekarang </th>
              <th style='background-color: #4CAF50; color: white' >Tanggal Lahir </th>
              <th style='background-color: #4CAF50; color: white' >No HP</th>
              <th style='background-color: #4CAF50; color: white' >Tanggal Terdaftar </th>
            
            </tr>
          </thead>
</table>
</div>

<span id="hasil_migrasi"></span>

<div class="row">
  <div class="col-sm-3">
  	
 <form role="form" id="formku" action="proses_edit_rawat_inap.php" method="POST" >

<div class="form-group">
    <input style="height: 20px;" type="hidden" value="<?php echo $regis['no_rm'];?>"  class="form-control" id="no_rm_lama" name="no_rm_lama" readonly="">
</div>


  <input style="height: 20px;" type="hidden" class="form-control" value="<?php echo $regis['bed'];?>" id="group_bed_lama" name="group_bed_lama" autocomplete="off">

  <input style="height: 20px;" type="hidden" class="form-control" id="bed_lama" value="<?php echo $regis['group_bed'];?>" name="bed_lama" autocomplete="off">



<button type="button" accesskey="c" class="btn btn-warning" data-toggle="modal" data-target="#myModal1"> <i class="fa fa-search"></i> <u>C</u>ari kamar</button> 


 <br><br>

<div class="card card-block">

<input style="height: 20px;" type="hidden" class="form-control" id="token" name="token" value="Kosasih" autocomplete="off"> 
 
<div class="form-group" >
  <label for="bed">Kamar:</label>
  <input style="height: 20px;" type="text" class="form-control disable5" value="<?php echo $regis['bed'];?>" id="group_bed" name="group_bed" autocomplete="off" required="" >
</div>


<div class="form-group" >
  <label for="bed">Bed:</label>
  <input style="height: 20px;" type="text" class="form-control disable5" id="bed" value="<?php echo $regis['group_bed'];?>" name="bed" autocomplete="off"  required=""  >
</div>
</div><!--<div card card-block kamar-->



<div class="card card-block">

<div class="form-group">
  <label for="sel1">Perujuk </label>
  <select class="form-control ss" id="rujukan" name="rujukan" required=""  autocomplete="off">
   <option value="<?php echo $regis['rujukan'];?>"><?php echo $regis['rujukan'];?></option>
   <option value="Non Rujukan">Non Rujukan</option>
 <?php 
  $query = $db->query("SELECT nama FROM perujuk "); 
  while ( $data = mysqli_fetch_array($query)) 
  {
  echo "<option value='".$data['nama']."'>".$data['nama']."</option>";
  }
?>
  </select>
</div>

<div class="form-group">
  <label for="sel1">Penjamin </label>
  <select class="form-control ss" id="penjamin" name="penjamin" required="" autocomplete="off">
   <option value="<?php echo $regis['penjamin'];?>"><?php echo $regis['penjamin'];?></option>
 <?php 
  $query = $db->query("SELECT nama FROM penjamin ORDER BY id ASC");
  while ( $data = mysqli_fetch_array($query)) 
  {
  echo "<option value='".$data['nama']."'>".$data['nama']."</option>";
  }
 ?>
  </select>
</div>
<br>

<button class="btn btn-success" id="lay"><i class="fa fa-list"></i> Lihat Layanan </button>
     
      <br>
  <br>
  <div class="form-group">
    <label for="nama_lengkap">Nama Lengkap Pasien:</label>
    <input style="height: 20px;" type="text" class="form-control" id="nama_lengkap" name="nama_lengkap" value="<?php echo $regis['nama_pasien'];?>" required="" autocomplete="off">
  </div>


<div class="form-group">
  <label for="sel1">Jenis Kelamin</label>
  <select class="form-control ss" name="jenis_kelamin" id="jenis_kelamin" required="" value="<?php echo $regis['jenis_kelamin'];?>" autocomplete="off">
    <option value="laki-laki">Laki-Laki</option>
    <option value="perempuan">Perempuan</option> 
  </select>
</div>


<div class="form-group">
    <label for="tempat_lahir">Tempat Lahir:</label>
    <input style="height: 20px;" type="text" class="form-control" id="tempat_lahir" value="<?php echo $regis['nama_pasien'];?>" name="tempat_lahir" required="" autocomplete="off">
  </div>

<div class="form-group">
    <label for="tanggal_lahir">Tanggal Lahir:</label>
    <input style="height: 20px;" type="text" class="form-control" id="tanggal_lahir" name="tanggal_lahir" value="<?php echo $pelanggan['tgl_lahir'];?>" required="" autocomplete="off">
</div>

<div class="form-group">
    <label for="umur">Umur:</label>
    <input style="height: 20px;" type="text" required="" class="form-control" id="umur" name="umur" value="<?php echo $pelanggan['umur'];?>" autocomplete="off">
</div>


<div class="form-group">
  <label for="sel1">Golongan Darah</label>
  <select class="form-control ss" id="gol_darah" name="gol_darah" value="<?php echo $regis['gol_darah'];?>"autocomplete="off">
    <option value="-">-</option>
    <option value="A">A</option>
    <option value="B">B</option>
    <option value="O">O</option>
    <option value="AB">AB</option>
   
  </select>
</div>


<div class="form-group">
    <label for="alamat_sekarang">Alamat Sekarang:</label>
    <textarea class="form-control" id="alamat_sekarang" name="alamat_sekarang" value="<?php echo $regis['alamat_pasien'];?>" required="" autocomplete="off"></textarea>
</div>

</div>


</div> <!--row no 1-->


<div class="col-sm-3">


<br><br><br>
<div class="card card-block">

<div class="form-group">
    <label for="no_telepon">No Telpon / HP:</label>
    <input style="height: 20px;" type="text" required=""  class="form-control" id="no_telepon" value="<?php echo $regis['hp_pasien'];?>" name="no_telepon" autocomplete="off">
</div>



<div class="form-group" >
  <label for="umur">Perkiraan Menginap:</label>
  <input style="height: 20px;" type="text" onkeypress="return isNumberKey(event)" class="form-control" id="perkiraan_menginap" value="<?php echo $regis['menginap'];?>"  name="perkiraan_menginap" required=""  autocomplete="off">
</div>

<div class="form-group" >
    <label for="umur">Surat Jaminan:</label>
    <input style="height: 20px;" type="text" class="form-control" id="surat_jaminan"  name="surat_jaminan" value="<?php echo $regis['surat_jaminan'];?>"  required="" autocomplete="off">
</div>


</div>



<div class="card card-block">


<div class="form-group">
  <label for="sel1"><u>K</u>eadaan Umum Pasien</label>
  <select class="form-control" accesskey="k"id="kondisi" name="kondisi" value="<?php echo $regis['kondisi'];?>" required="" autocomplete="off">
    <option value="Tampak Normal">Tampak Normal</option>
    <option value="Pucat dan Lemas">Pucat dan Lemas</option>
    <option value="Sadar dan Cidera">Sadar dan Cidera</option>
    <option value="Pingsan / Tidak Sadar">Pingsan / Tidak Sadar</option>
    <option value="Meninggal Sebelum Tiba">Meninggal Sebelum Tiba</option>
  </select>
</div>

<div class="form-group">
  <label for="sel1">Poli / Penunjang Medik</label>
  <select class="form-control ss" id="sel1" name="poli" required="" value="<?php echo $regis['poli'];?>" autocomplete="off">
  
 <?php 
  $query = $db->query("SELECT nama FROM poli ");
  while ( $data = mysqli_fetch_array($query)) 
  {
  echo "<option value='".$data['nama']."'>".$data['nama']."</option>";
  }
  ?>
  </select>
</div>


<div class="form-group">
  <label for="sel1">Dokter Pelaksana</label>
  <select class="form-control ss" id="dokter" name="dokter" required="" autocomplete="off">
      <option value="<?php echo $regis['dokter']; ?>"><?php echo $regis['dokter']; ?></option>
    <option value="<?php echo $nama_dokter; ?>"><?php echo $nama_dokter; ?></option>
 <?php 
  $query = $db->query("SELECT nama FROM user WHERE tipe = '1'  "); 
 while ( $data = mysqli_fetch_array($query))
  {
  echo "<option value='".$data['nama']."'>".$data['nama']."</option>";
  }
  ?>
  </select>
</div>

<div class="form-group">
    <label for="alamat">Dokter Penanggung Jawab </label>
    <select class="form-control ss" id="dokter_penanggung_jawab" name="dokter_penanggung_jawab" required="" autocomplete="off">
          <option value="<?php echo $regis['dokter']; ?>"><?php echo $regis['dokter']; ?></option>
    <option value="<?php echo $nama_dokter; ?>"><?php echo $nama_dokter; ?></option>
    <?php 
    $query = $db->query("SELECT nama FROM user WHERE tipe = '1' ");
    while ( $data = mysqli_fetch_array($query)) {
    echo "<option value='".$data['nama']."'>".$data['nama']."</option>";
    }
    ?>
  </select>
</div>

<div class="form-group ">
  <label >Alergi Obat *</label>
  <input style="height: 20px;" type="text" class="form-control" id="alergi" name="alergi"  required="" value="<?php echo $regis['alergi'];?>" placeholder="Wajib Isi" autocomplete="off"> 
</div>


<?php if ($dq['tampil_ttv'] == 0 AND $dq['tampil_data_pasien_umum'] == 0 ): ?>
  

<center><button accesskey="d" type="submit" id="submit_daftar" class="btn btn-info hug"><i class="fa fa-plus"></i> <u>D</u>aftar Rawat Inap</button></center>


<?php endif ?>


</div><!--panel body-->
   
  </div><!--penutup div colsm2-->



  <?php if ($dq['tampil_data_pasien_umum'] == 1): ?>

<div class="col-sm-3">


<br><br><br>

<div class="card card-block">


  


<div class="form-group">
    <label for="no_ktp">No Keluarga:</label>
    <input style="height: 20px;" type="text" onkeypress="return isNumberKey(event)" class="form-control" id="no_kk" value="<?php echo $regis['no_kk'];?>" name="no_kk" autocomplete="off">
  </div>

  <div class="form-group">
    <label for="no_ktp">Nama KK:</label>
    <input style="height: 20px;" type="text" class="form-control" id="nama_kk" name="nama_kk" value="<?php echo $regis['nama_kk'];?>" autocomplete="off">
  </div>


<div class="form-group">
    <label for="no_ktp">No KTP:</label>
    <input style="height: 20px;" type="text" onkeypress="return isNumberKey(event)" value="<?php echo $pelanggan['no_ktp'];?>" class="form-control" id="no_ktp" name="no_ktp" autocomplete="off">
  </div>



<div class="form-group">
    <label for="alamat_ktp">Alamat KTP:</label>
    <textarea class="form-control" id="alamat_ktp" name="alamat_ktp" value="<?php echo $pelanggan['alamat_ktp'];?>" autocomplete="off"></textarea>
</div>
  <div class="form-group">
  <label for="sel1">Status Perkawinan</label>
  <select class="form-control ss" id="sel1" name="status_kawin" value="<?php echo $regis['status_nikah'];?>" autocomplete="off">
            <option value="-">-</option>
   <option value="belum menikah">Belum Menikah</option>
    <option value="menikah">Menikah</option>
    <option value="cerai">Cerai</option>
  </select>
</div>


<div class="form-group">
  <label for="sel1">Pendidikan Terakhir</label>
  <select class="form-control ss" id="sel1" name="pendidikan_terakhir" value="<?php echo $pelanggan['pendidikan'];?>" autocomplete="off">
    <option value="-">-</option>
    <option value="tidak sekolah">Tidak Sekolah</option>
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
  <select class="form-control ss" id="sel1" name="agama" value="<?php echo $pelanggan['agama'];?>" autocomplete="off">
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
    <label for="pekerjaan_pasien">Nama Penganggung Jawab :</label>
    <input style="height: 20px;" value="<?php echo $regis['penanggung_jawab'];?>" type="text" class="form-control" id="nama_penanggungjawab" name="nama_penanggungjawab" autocomplete="off">
</div>


  <div class="form-group" >
  <label for="umur">Hubungan Dengan Pasien</label>
  <select id="hubungan_dengan_pasien" class="form-control ss"  name="hubungan_dengan_pasien" autocomplete="off">
    <option value="<?php echo $regis['hubungan_dengan_pasien'];?>"><?php echo $regis['hubungan_dengan_pasien'];?></option>
  <option value="Orang Tua">Orang Tua</option>
  <option value="Suami/Istri">Suami/Istri</option>
  <option value="Anak">Anak</option>
  <option value="Keluarga">Keluarga</option>
  <option value="Teman">Teman</option>
  <option value="Lain - Lain">Lain - Lain</option>  
  </select>  
  </div> 

<div class="form-group">
    <label for="pekerjaan_pasien">Pekerjaan Penanggung Jawab :</label>
    <input style="height: 20px;" type="text" class="form-control" value="<?php echo $regis['pekerjaan_penanggung_jawab'];?>"" id="pekerjaan_penanggung" name="pekerjaan_penanggung" autocomplete="off">
</div>

<div class="form-group">
    <label for="no_hp_penanggung">No Hp Penganggung Jawab :</label>
    <input style="height: 20px;" type="text" onkeypress="return isNumberKey(event)" value="<?php echo $regis['hp_penanggung_jawab'];?>" class="form-control" id="no_hp_penanggung" name="no_hp_penanggung" autocomplete="off">
</div>

<div class="form-group">
    <label for="alamat_penanggung">Alamat Penanggung Jawab:</label>
    <textarea class="form-control" id="alamat_penanggung" name="alamat_penanggung" autocomplete="off"><?php echo $regis['alamat_penanggung_jawab'];?> </textarea>
</div>



<?php if ($dq['tampil_ttv'] == 0 ): ?>
  

<center><button accesskey="d" type="submit" id="submit_daftar" class="btn btn-info hug"><i class="fa fa-plus"></i> <u>D</u>aftar Rawat Inap</button></center>


<?php endif ?>


</div><!--end div card block umum-->



</div> <!-- penutup col sm ke 3 -->
<?php endif ?>
 

<div class="col-sm-3">

<?php if ($dq['tampil_ttv'] == 1): ?>  


<br><br><br>
<div class="card card-block">

<center><h4>Tanda Tanda Vital</h4></center>
<div class="form-group">
 <label >Sistole / Diastole (mmHg)</label>
  <input style="height: 20px;" type="text"  class="form-control" id="sistole_distole" value="<?php echo $rekam['sistole_distole'];?>" name="sistole_distole" autocomplete="off"> 
</div>


<div class="form-group ">
  <label >Frekuensi Pernapasan (kali/menit)</label>
  <input style="height: 20px;" type="text"  class="form-control" id="respiratory_rate" value="<?php echo $rekam['respiratory'];?>" name="respiratory_rate" autocomplete="off"> 
</div>
 

<div class="form-group">
  <label >Suhu (°C)</label>
  <input style="height: 20px;" type="text"  class="form-control" id="suhu" name="suhu" value="<?php echo $rekam['suhu'];?>" autocomplete="off"> 
</div>
  

<div class="form-group ">
   <label >Nadi (kali/menit)</label>
  <input style="height: 20px;" type="text"  class="form-control" id="nadi" name="nadi" value="<?php echo $rekam['nadi'];?>" autocomplete="off"> 
</div>


<div class="form-group ">
  <label >Berat Badan (kg)</label>
  <input style="height: 20px;" type="text"  class="form-control" id="berat_badan" value="<?php echo $rekam['berat_badan'];?>" name="berat_badan" autocomplete="off"> 
</div>

<div class="form-group ">
  <label >Tinggi Badan (cm)</label>
  <input style="height: 20px;" type="text"  class="form-control" id="tinggi_badan" value="<?php echo $rekam['tinggi_badan'];?>" name="tinggi_badan" autocomplete="off"> 
</div>


  <input style="height: 20px;" type="hidden"  class="form-control" id="no_reg" value="<?php echo $no_reg;?>" name="no_reg" autocomplete="off"> 

<center><button accesskey="d" type="submit" id="submit_daftar" class="btn btn-info hug"><i class="fa fa-plus"></i> <u>D</u>aftar Rawat Inap</button></center>

</div>

<?php endif ?>


</div><!-- nutup sm-->


</div> <!-- row no 2-->
</form>

</div> <!--row utama--> 
</div> <!--container-->

<!--script chossen
<script>
$(".ss").chosen({no_results_text: "Oops, Tidak Ada !"});
</script>
script end chossen-->




<script type="text/javascript">
    $(document).ready(function(){
    // Tooltips Initialization
    $(function () {
    $('[data-toggle="tooltip"]').tooltip()
    });
    });
</script>

<!--script ambil data pasien modal-->
<script type="text/javascript">
//jika dipilih, nim akan masuk ke input dan modal di tutup
            $(document).on('click', '.pilih', function (e) {
              document.getElementById("no_rm_lama").value = $(this).attr('data-no');
              document.getElementById("nama_lengkap").value = $(this).attr('data-nama');
              document.getElementById("tanggal_lahir").value = $(this).attr('data-lahir');
              document.getElementById("alamat_sekarang").value = $(this).attr('data-alamat');
              document.getElementById("jenis_kelamin").value = $(this).attr('data-jenis-kelamin');
              document.getElementById("no_telepon").value = $(this).attr('data-hp');
              $('#hasil_migrasi').html(''); 
              $("#nama_lengkap").focus();
// untuk update umur ketika sudah beda bulan dan tahun
    var tanggal_lahir = $("#tanggal_lahir").val();
   
 
function hitung_umur(tanggal_input){

var now = new Date(); //Todays Date   
var birthday = tanggal_input;
birthday=birthday.split("-");   

var dobDay = birthday[0]; 
var dobMonth = birthday[1];
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
// tabel lookup mahasiswa
</script>
<!--end script ambil data pasien modal-->




<!-- modal ambil data dari table RI  -->
<script type="text/javascript">

//            jika dipilih, nim akan masuk ke input dan modal di tutup
  $(document).on('click', '.pilih2', function (e) {
            document.getElementById("bed").value = $(this).attr('data-nama');
            document.getElementById("group_bed").value = $(this).attr('data-group-bed');
                
  $('#myModal1').modal('hide');


  });
        
</script>
<!-- end ambil data RI  -->

<script type="text/javascript">

$("#tanggal_lahir").blur(function(){

function hitung_umur(tanggal_input){

var now = new Date(); //Todays Date   
var birthday = tanggal_input;
birthday=birthday.split("-");   

var dobDay = birthday[0]; 
var dobMonth = birthday[1];
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
    var date = new Date(tanggal_lahir);
    var tanggal = (date.getMonth() + 1) + '-' + date.getDate() + '-' +  date.getFullYear();

    var umur = hitung_umur(tanggal);
    if (umur == "NaN Tahun" || umur == "NaN Bulan") {
      var tanggal_lahir = $("#tanggal_lahir").val();
      var umur = hitung_umur(tanggal_lahir);
      $("#umur").val(umur);
    }
    else if (tanggal_lahir == '')
    {
    
    }
    else
    {
    $("#umur").val(umur);
    }

});
</script>

<script type="text/javascript">
  
  $("#umur").blur(function(){
    var umur = $("#umur").val();
    var tahun = new Date();
    var tahun_sekarang = tahun.getFullYear();
    var hari_sekarang = tahun.getDate();
    var bulan_sekarang = tahun.getMonth() + 1;

    var tahun_lahir = parseInt(tahun_sekarang,10) - parseInt(umur,10);
    if (hari_sekarang < 10) {
      var hari_sekarang = '0' + hari_sekarang;
    }
    if (bulan_sekarang < 10) {
      var bulan_sekarang = '0' + bulan_sekarang;
    }
    var tanggal_lahir = hari_sekarang + '-' + bulan_sekarang + '-' +  tahun_lahir;
    $("#tanggal_lahir").val(tanggal_lahir);

  });

</script>

<!--   script untuk detail layanan PERUSAHAAN PENJAMIN-->
<script type="text/javascript">
     $("#lay").click(function() 
{   
    var penjamin = $("#penjamin").val();

                $.post("detail_layanan_perusahaan2.php",{penjamin:penjamin},function(data){
                    $("#tampil_layanan").html(data);
               $("#detail").modal('show');
          
                });
            });
//            tabel lookup mahasiswa         
</script>
<!--  end script untuk akhir detail layanan PERUSAHAAN -->


<script type="text/javascript">
      $(document).ready(function(){

        $('#pasien_inap_baru').DataTable().destroy();

          var dataTable = $('#pasien_inap_baru').DataTable( {
          "processing": true,
          "serverSide": true,
          "info":     false,
          "language": {
        "emptyTable":     "My Custom Message On Empty Table"
    },
          "ajax":{
            url :"show_data_pasien_edit.php", // json datasource
                type: "post",  // method  , by default get
            error: function(){  // error handling
              $(".tbody").html("");
              $("#pasien_inap_baru").append('<tbody class="tbody"><tr><th colspan="3"></th></tr></tbody>');
              $("#pasien_lama_processing").css("display","none");
              
            }
          },
              "fnCreatedRow": function( nRow, aData, iDataIndex ) {

              $(nRow).attr('class', "pilih tr-id-"+aData[9]+"");
              $(nRow).attr('data-no', aData[0]);
              $(nRow).attr('data-nama', aData[1]);
              $(nRow).attr('data-jenis-kelamin', aData[2]);
              $(nRow).attr('data-alamat', aData[3]);
              $(nRow).attr('data-lahir', aData[4]);
              $(nRow).attr('data-darah', aData[7]);
              $(nRow).attr('data-hp', aData[5]);
              $(nRow).attr('data-penjamin', aData[8]);

          } 

        } );
   

  });
  </script>


<!--footer-->
<?php 
include 'footer.php';
?>
<!--end footer-->



