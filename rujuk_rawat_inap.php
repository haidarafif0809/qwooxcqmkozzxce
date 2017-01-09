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


$no_reg= stringdoang($_GET['no_reg']);


$select_to = $db->query("SELECT * FROM registrasi WHERE no_reg = '$no_reg'");
$out = mysqli_fetch_array($select_to);
$take_dokter = $out['dokter'];

$select_to = $db->query("SELECT tgl_lahir FROM pelanggan WHERE kode_pelanggan = '$out[no_rm]' ");
$outing = mysqli_fetch_array($select_to);


$select_from = $db->query("SELECT * FROM rekam_medik WHERE no_reg = '$no_reg'");
$out_from = mysqli_fetch_array($select_from);


$sett_registrasi= $db->query("SELECT * FROM setting_registrasi ");
$data_sett = mysqli_fetch_array($sett_registrasi);

?>


<style>
.disable{
background-color:#cccccc;
opacity: 0.9;
    cursor: not-allowed;
}
.hug {
      background-color: white; 
    color: black; 
    border: 2px solid #f44336;
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
        
        <button type="button" accesskey="e" class="btn btn-danger" data-dismiss="modal">Clos<u>e</u>d</button>
    </div>
    </div>
  </div>
</div>
<!--modal end Layanan Perusahaan-->

<!-- Modalkamar -->
<div id="modal_kamar" class="modal fade" role="dialog">
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
          <th> Fasilitas</th>
          <th>Jumlah Bed</th>  
          <th>Sisa Bed</th>                                
          </tr>
          </thead>
          <tbody>
          <?php
          //Data mentah yang ditampilkan ke tabel    
          include 'db.php';
          $hasil = $db->query("SELECT * FROM bed WHERE sisa_bed != 0 ");
                                        
          while ($data =  $hasil->fetch_assoc()) {
          ?>
          <tr class="pilih1" 
          data-nama="<?php echo $data['nama_kamar']; ?>" 
          data-group-bed ="<?php echo $data['group_bed']; ?>" >
          
          <td><?php echo $data['kelas']; ?></td>
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
        <button type="button" accesskey="o" class="btn btn-floating btn-danger" data-dismiss="modal">Cl<u>o</u>se</button>
        </div>
        </div>
        
        </div>
        </div> 
<!-- akhir modal Kamar-->

<div class="container">

<h3>RUJUK RAWAT INAP</h3>
<hr>

<div class="row">
<div class="col-sm-4">


<form role="form" action="proses_rujuk_rawat_inap.php" method="POST">

<button type="button" accesskey="c" class="btn btn-success " data-toggle="modal" data-target="#modal_kamar"> <i class="fa fa-search"></i> <u>C</u>ari kamar</button>
 <br>
 <br>
<div class="form-group" >
  <label for="bed">Kamar:</label>
  <input style="height:20;" type="text" class="form-control" id="group_bed" name="group_bed" required="" readonly="">
</div>


<div class="form-group" >
  <label for="bed">Bed:</label>
  <input style="height:20;" type="text" class="form-control" id="bed" name="bed" required="" readonly="" >
</div>



<div class="card card-block">

   
<div class="form-group">
  <label for="sel1">Perujuk:</label>
  <select class="form-control" id="rujukan" name="rujukan" required="" autocomplete="off">
   <option value="<?php echo $out['rujukan'];?>"><?php echo $out['rujukan'];?></option>
   <option value="Non Rujukan">Non Rujukan</option>
      <?php 
      $query = $db->query("SELECT nama FROM perujuk ");
      while ( $data = mysqli_fetch_array($query)) {
      echo "<option value='".$data['nama']."'>".$data['nama']."</option>";
      }
      ?>
  </select>
</div>



<div class="form-group" >
 <label for="penjamin">Penjamin:</label>
 <select class="form-control" id="penjamin" name="penjamin" required="" autocomplete="off">
 <option value="<?php echo $out['penjamin'];?>"><?php echo $out['penjamin'];?></option>
 <?php 
  $query = $db->query("SELECT nama FROM penjamin ORDER BY id ASC");
  while ( $data = mysqli_fetch_array($query)) {
  echo "<option value='".$data['nama']."'>".$data['nama']."</option>";
  }
  ?>
  </select>
</div>
  
<button class="btn btn-warning" accesskey="l" id="lay"><i class="fa fa-list"></i> Lihat <u>L</u>ayanan </button>
     
   <br>
  <br>
<div class="form-group">
  <label for="no_rm">No RM:</label>
  <input style="height:20;" type="text" class="form-control" id="no_rm" name="no_rm" required="" readonly="" value="<?php echo $out['no_rm'];?>">
</div>

  <input style="height:20;" type="hidden" class="form-control" id="no_reg" name="no_reg" required="" readonly="" value="<?php echo $no_reg;?>">



<div class="form-group">
    <label for="nama_lengkap">Nama Lengkap Pasien:</label>
    <input style="height:20;" type="text" class="form-control" id="nama_lengkap" name="nama_lengkap" value="<?php echo $out['nama_pasien'];?>"required="" readonly="">
</div>

<div class="form-group" >
  <label for="umur">Jenis Kelamin:</label>
<input style="height:20;" type="text" class="form-control" id="jenis_kelamin" name="jenis_kelamin" value="<?php echo $out['jenis_kelamin'];?>" required="" readonly="" >
</div>

  
<div class="form-group">
    <input style="height:20;" type="text" class="form-control" id="tanggal_lahir" name="tanggal_lahir" value="<?php echo tanggal($outing['tgl_lahir']);?>" required="" autocomplete="off">
</div>

<div class="form-group">
    <label for="nama_lengkap">Umur:</label>
    <input style="height:20;" type="text" class="form-control" id="umur" name="umur" required="" >
</div>


<div class="form-group">
    <label for="alamat">Alamat:</label>
    <textarea class="form-control" id="alamat" name="alamat"required="" value="<?php echo $out['alamat_pasien'];?>"><?php echo $out['alamat_pasien'];?></textarea>
</div>



<div class="form-group">
    <label for="alamat">No Hp:</label>
    <input style="height:20;" type="text" onkeypress="return isNumberKey(event)" class="form-control" id="hp_pasien" value="<?php echo $out['hp_pasien'];?>" name="hp_pasien" required="" >
</div>


</div>
<!-- 2 DIV PANEL DATA DIRI AWAL -->
</div><!-- penutp colm 1-->


<!-- SPAN untuk PENANGGUNG-->


<div class="col-sm-4">
<div class="card card-block">

<!-- SPAN untuk TTV -->
<div class="panel panel-success">
<div class="panel-body">
<div class="form-group" >
  <label for="umur">Penanggung Jawab Pasien:</label>
  <input style="height:20;" type="text" class="form-control" id="penanggung_jawab" name="penanggung_jawab" required="" autocomplete="off">
</div>

<div class="form-group" >
  <label for="umur">Alamat Penanggung Jawab:</label>
  <input style="height:20;" type="text" class="form-control" id="alamat_penanggung" name="alamat_penanggung" required="" autocomplete="off">
</div> 

<div class="form-group" >
  <label for="umur">No Telp / HP Penanggung  :</label>
  <input style="height:20;" onkeypress="return isNumberKey(event)" type="text" class="form-control" id="no_hp_penanggung" name="no_hp_penanggung" maxlenght="12" required="" autocomplete="off">
</div>

<div class="form-group" >
 <label for="umur">Pekerjaan Penanggung Jawab:</label>
 <input style="height:20;" type="text" class="form-control" id="pekerjaan_penanggung" name="pekerjaan_penanggung" required="" autocomplete="off">
</div>



<div class="form-group" >
  <label for="umur">Hubungan Dengan Pasien:</label>
  <select id="hubungan_dengan_pasien" class="form-control" name="hubungan_dengan_pasien" value="<?php echo $out['hubungan_dengan_pasien'];?>" required="" autocomplete="off">
      
      <option value="Orang Tua">Orang Tua</option>
      <option value="Suami/Istri">Suami/Istri</option>
      <option value="Anak">Anak</option>
      <option value="Keluarga">keluarga</option>
      <option value="Teman">Teman</option>
      <option value="Lain - Lain">Lain - Lain</option>  
  </select>  
</div>

  </div>
</div>


<div class="panel panel-danger">
<div class="panel-body">

<div class="form-group" >
  <label for="umur">Perkiraan Menginap:</label>
  <input style="height:20;" type="text" onkeydown="return numbersonly(this, event);" onkeyup="javascript:tandaPemisahTitik(this);" class="form-control" id="perkiraan_menginap" name="perkiraan_menginap" required=""  autocomplete="off">
</div>

<div class="form-group" >
    <label for="umur">Surat Jaminan:</label>
    <input style="height:20;" type="text" class="form-control" id="surat_jaminan"  name="surat_jaminan" required="" autocomplete="off">
</div>


</div>
</div>

<!-- AKHIR UNTUK PANEL TTV -->



<div class="form-group">
          <label for="alamat">Dokter Penanggung Jawab:</label>
          <select class="form-control" id="dokter_pengirim" name="dokter_pengirim" required="" autocomplete="off">
                     <option value="<?php echo $take_dokter;?>"><?php echo $take_dokter;?></option>

                  <?php 
                  $query = $db->query("SELECT nama FROM user WHERE otoritas = 'Dokter' ");
                  while ( $data = mysqli_fetch_array($query)) {
                  echo "<option value='".$data['nama']."'>".$data['nama']."</option>";
                  }
                  ?>
          </select>
</div>

<div class="form-group">
    <label for="alamat">Asal Poli :</label>
    <select class="form-control" id="poli" name="poli" required="" autocomplete="off">
     <option value="<?php echo $out['poli'];?>"><?php echo $out['poli'];?></option>
          <option value="Tidak Ada">Tidak Ada</option>

          <?php 
          $query = $db->query("SELECT nama FROM poli ");
          while ( $data = mysqli_fetch_array($query)) {
          echo "<option value='".$data['nama']."'>".$data['nama']."</option>";
          }
          ?>
    </select>
</div> 


<div class="form-group">
    <label for="alamat">Dokter Pelaksana:</label>
    <select class="form-control ss" id="dokter_penanggung_jawab" name="dokter_penanggung_jawab" required="" autocomplete="off">
        
    <?php 
    $query = $db->query("SELECT nama FROM user WHERE otoritas = 'Dokter' ");
    while ( $data = mysqli_fetch_array($query)) {
    echo "<option value='".$data['nama']."'>".$data['nama']."</option>";
    }
    ?>
  </select>
</div>



  <label for="sel1">Keadaan Umum Pasien:</label>
<select class="form-control" id="kondisi" name="kondisi" required="" value="<?php echo $out['kondisi'];?>" autocomplete="off">
    <option value="Tampak Normal">Tampak Normal</option>
    <option value="Pucat dan Lemas">Pucat dan Lemas</option>
    <option value="Sadar dan Cidera">Sadar dan Cidera</option>
    <option value="Pingsan / Tidak Sadar">Pingsan / Tidak Sadar</option>
    <option value="Meninggal Sebelum Tiba">Meninggal Sebelum Tiba</option>
  </select>


  <label >Alergi Obat *</label>
  <input style="height:20;" type="text" class="form-control" id="alergi" name="alergi" value="<?php echo $out['alergi'];?>" value="Tidak Ada" required="" placeholder="Wajib Isi" autocomplete="off"> 



</div>

<?php if ($data_sett['tampil_ttv'] == 0): ?>

<button accesskey="d" style="width:100px" type="submit" class="btn btn-info"><i class="fa fa-plus"></i>  <u>D</u>aftar</button>

  
<?php endif ?>
</div>



<!-- SPAN untuk DATA DIRI LANJUTAN -->

<!-- PANEL DATA DIRI AKHIR -->

<div class="col-sm-4">
<div class="card card-block">

<?php if ($data_sett['tampil_ttv'] == 1): ?>

  <center><h4>Tanda Tanda Vital</h4></center>
<div class="form-group">
 <label >Sistole / Diastole (mmHg):</label>
 <input style="height:20;" type="text" class="form-control" id="sistole_distole" value="<?php echo $out_from['sistole_distole'];?>" onkeypress="return isNumberKey(event)" name="sistole_distole" autocomplete="off" >
</div>

<div class="form-group ">
  <label >Frekuensi Pernapasan (kali/menit):</label>
  <input style="height:20;" type="text" class="form-control" id="respiratory_rate" value="<?php echo $out_from['respiratory'];?>" onkeypress="return isNumberKey(event)" name="respiratory_rate"  autocomplete="off" > 
</div>

<div class="form-group">
  <label >Suhu  (°C):</label>
  <input style="height:20;" type="text" class="form-control" id="suhu" name="suhu" value="<?php echo $out_from['suhu'];?>" onkeypress="return isNumberKey(event)" autocomplete="off"  > 
</div>   

<div class="form-group ">
 <label >Nadi (kali/menit):</label>
 <input style="height:20;" type="text" class="form-control" id="nadi" name="nadi" value="<?php echo $out_from['nadi'];?>" onkeypress="return isNumberKey(event)" autocomplete="off"> 
</div>

<div class="form-group ">
  <label >Berat Badan (kg):</label>
  <input style="height:20;" type="text" class="form-control" id="berat_badan" value="<?php echo $out_from['berat_badan'];?>" onkeypress="return isNumberKey(event)"  name="berat_badan" autocomplete="off"> 
</div>

<div class="form-group ">
 <label >Tinggi Badan (cm):</label>
 <input style="height:20;" type="text" class="form-control" id="tinggi_badan" value="<?php echo $out_from['tinggi_badan'];?>" onkeypress="return isNumberKey(event)" name="tinggi_badan"autocomplete="off"> 
</div>



<br>
  <input style="height:20;" type="hidden" class="form-control" id="token" name="token" value="Kosasih" autocomplete="off"> 

<button accesskey="d" style="width:100px" type="submit" class="btn btn-info"><i class="fa fa-plus"></i>  <u>D</u>aftar</button>

</div>
<!-- Akhir panel untuk PENANGGUNG -->

<?php endif ?>



<!-- SPAN untuk dokter LANJUTAN -->



</form>
</div> <!-- -->
</div> <!-- row utama -->

</div> <!-- penutup container-->

<!--script chossen-->
<script>
$(".ss").chosen({no_results_text: "Oops, Tidak Ada !"});
</script>
<!--script end chossen-->

<script type="text/javascript">
  
  $("#submit_cari").click(function(){
  
    var cari = $("#cari_migrasi").val();
    if (cari == '') {
  
  $("#hasil_migrasi").html('');
  
    }
    else
    {
            $("#myModal").modal('show');
      $("#hasil_migrasi").html('Loading..');
   $.post("cek_data_pasien_lama.php",{cari:cari},function(data){
      $("#hasil_migrasi").html(data);
  
    });
  
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



<script type="text/javascript">
  $(document).ready(function(){

function hitung_umur(tanggal_input){

var now = new Date(); //Todays Date   
var birthday = tanggal_input;
birthday=birthday.split("/");   

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

    var tanggal = $("#tanggal_lahir").val();


 var umur = hitung_umur(tanggal);
    if (umur == "NaN Tahun" || umur == "NaN Bulan") {
      var tanggal_lahir = $("#tanggal_lahir").val();
       var date = new Date(tanggal);
    var tanggal_lahir = (date.getMonth() + 1) + '-' + date.getDate() + '-' +  date.getFullYear();

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

  $("#tanggal_lahir").blur(function(){

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

    var tanggal = $("#tanggal_lahir").val();



 var umur = hitung_umur(tanggal);
    if (umur == "NaN Tahun" || umur == "NaN Bulan") {
      var tanggal = $("#tanggal_lahir").val();
       var date = new Date(tanggal);
    var tanggal_lahir = (date.getMonth() + 1) + '-' + date.getDate() + '-' +  date.getFullYear();

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


<!--  data table -->
<script type="text/javascript">
  $(function () {
  $("#siswa").dataTable();
  }); 
</script>
<!--  end data table -->


<!-- modal ke rujukan lab  -->
<script type="text/javascript">

//            jika dipilih, nim akan masuk ke input dan modal di tutup
    $(document).on('click', '.rujuk-lab', function (e) {
            var id = $(this).attr('data-id');

    $.post("form-rujuk-lab-ri.php",{id:id},function(info){
    $("#rujukan_lab").html(info);

    });

    $('#Modal3').modal('show');
    
    });
           
</script>
<!-- akhir modal ke rujukan lab  -->



<!-- modal ambil data dari table RI  -->
<script type="text/javascript">

//            jika dipilih, nim akan masuk ke input dan modal di tutup
  $(document).on('click', '.pilih1', function (e) {
            document.getElementById("bed").value = $(this).attr('data-nama');
            document.getElementById("group_bed").value = $(this).attr('data-group-bed');
                
  $('#modal_kamar').modal('hide');
  });
      
  $(function () {
  $("#siswa1").dataTable();
  });
// tabel lookup mahasiswa
  $(function () {
  $("#table_rawat_inap").dataTable();
  });      
          
</script>
<!-- end ambil data RI  -->

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

<!-- footer  -->
<?php 
include 'footer.php'; 
?>
<!-- end footer  -->