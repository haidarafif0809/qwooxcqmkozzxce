<?php include 'session_login.php';
include 'header.php';
include 'navbar.php';
include 'db.php';
include_once 'sanitasi.php';

$tanggal = date("Y-m-d");



$sett_registrasi= $db->query("SELECT * FROM setting_registrasi ");
$data_sett = mysqli_fetch_array($sett_registrasi);

$pilih_akses_registrasi_rj = $db->query("SELECT registrasi_rj_lihat, registrasi_rj_tambah, registrasi_rj_edit, registrasi_rj_hapus FROM otoritas_registrasi WHERE id_otoritas = '$_SESSION[otoritas_id]'");
$registrasi_rj = mysqli_fetch_array($pilih_akses_registrasi_rj);

?>


<style>
.disable1{
background-color:#cccccc;
opacity: 0.9;
    cursor: not-allowed;
}
.disable2{
background-color: #cccccc;
opacity: 0.9;
    cursor: not-allowed;
}
.disable3{
background-color: #cccccc;
opacity: 0.9;
    cursor: not-allowed;
}
.disable4{
background-color: #cccccc;
opacity: 0.9;
    cursor: not-allowed;
}
.disable5{
background-color: #cccccc;
opacity: 0.9;
    cursor: not-allowed;
}
.disable6{
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

<!-- Modal Hapus data -->
<div id="modal_no_urut" class="modal fade" role="dialog">
  <div class="modal-dialog">

    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title">Konfirmasi Pemanggilan Pasien</h4>
      </div>

      <div class="modal-body">
   
   <p>Apakah Anda yakin ingin memanggil pasien ini ?</p>


     </div>

      <div class="modal-footer">
        <h6 style="text-align: left"><i> * Perhatikan no urut, Panggil berdasarkan no urut.</i></h6>
        <button type="button" data-id="" class="btn btn-info" id="btn_jadi_panggil" data-id="" data-status="">Ya</button>
        <button type="button" class="btn btn-warning" data-dismiss="modal">Batal</button>
      </div>
    </div>

  </div>
</div><!-- end of modal hapus data  -->

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


<!-- Modal Untuk Confirm LAYANAN PERUSAHAAN-->
<div id="detail2" class="modal fade" role="dialog">
  <div class="modal-dialog modal-lg">
    <!-- Modal content-->
    <div class="modal-content">
    <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>       
    </div>
    <div class="modal-body">

      <span id="tampil_layanan">

      <h1>Keterangan Batal Rawat Jalan</h1>
<form role="form" action="proses_keterangan_batal.php" method="POST">
<div class="form-group">
  <label for="sel1">Keterangan Batal </label>
  <textarea type="text" class="form-control" id="keterangan" name="keterangan"></textarea>
</div>

<input style="height: 20px;" type="hidden" class="form-control" id="no_reg" name="no_reg" >

<button type="submit" id="batal_raja" data-id="" class="btn btn-info">Input Keterangan</button>
</form>

      </span>
    </div>
    <div class="modal-footer">
        
        <button type="button" accesskey="e" class="btn btn-danger" data-dismiss="modal">Clos<u>e</u>d</button>
    </div>
    </div>
  </div>
</div>
<!--modal end Layanan Perusahaan-->



<div style="padding-left:5%; padding-right:5%;">

<?php 
if ($registrasi_rj['registrasi_rj_lihat'] > 0) {

  echo "<h3>DATA PASIEN REGISTRASI RAWAT JALAN</h3><hr>";

}
else
{
    echo "<h3>DATA PENJUALAN RAWAT JALAN</h3><hr>";

}
?>
<!-- Nav tabs -->

<ul class="nav nav-tabs yellow darken-4" role="tablist">
<?php 
if ($registrasi_rj['registrasi_rj_lihat'] > 0) {
        echo "<li class='nav-item'><a class='nav-link active' href='registrasi_raja.php'> Antrian Pasien R. Jalan </a></li>";
        echo "<li class='nav-item'><a class='nav-link' href='pasien_sudah_panggil.php' > Pasien Dipanggil </a></li>";
      }
      else{
      echo "<li></li>";
      echo "<li></li>";
      }
 ?> 
       <li class="nav-item"><a class="nav-link" href='pasien_sudah_masuk.php' > Pasien Masuk R.Dokter </a></li>

 <?php 
if ($registrasi_rj['registrasi_rj_lihat'] > 0) {
        echo "<li class='nav-item'><a class='nav-link' href='pasien_batal_rujuk.php' > Pasien Batal / Rujuk Ke Luar </a></li>
        <li class='nav-item'><a class='nav-link' href='pasien_registrasi_rj_belum_selesai.php' >Pasien Belum Selesai Registrasi </a></li>";
}
      else{
      echo "<li></li>";
      echo "<li></li>";
      }
        ?>
</ul>
<br><br>

<?php if ($registrasi_rj['registrasi_rj_tambah'] > 0): ?>
  <button id="coba" type="submit" class="btn btn-primary" data-toggle="collapse" accesskey="r" ><i class='fa fa-plus'> </i>&nbsp;Daftar Rawat Jalan</button>

  <button id="kembali" style="display:none" data-toggle="collapse" accesskey="k"  class="btn btn-default"><i class="fa fa-reply"></i> <u>K</u>embali</button>

  <a href="rawat_jalan_baru.php" accesskey="b" class="btn btn-info"><i class="fa fa-plus"></i> Pasien <u>B</u>aru</a>
  
<span id="tombol_span_filter" style="display: none">
  <button class="btn btn-primary" type="button" data-toggle="collapse" data-target="#collapseExample" aria-expanded="false" aria-controls="collapseExample"><i class='fa fa-filter'> </i>
  Filter Pencarian  </button>
</span>

<span id="tombol_span_filter_2" style="display: none">
  <button class="btn btn-primary" type="button" data-toggle="collapse" data-target="#collapseExample" aria-expanded="false" aria-controls="collapseExample"><i class='fa fa-filter'> </i>
  Filter Pencarian  </button>
</span>

  <br>
 <br>
<?php endif ?>





<div id="demo" class="collapse">


 <div class="collapse" id="collapseExample">

    <div class="row">
      <div class="col-sm-2">
        <label>Nama Lengkap Pasien </label>
        <input style="height: 20px;" type="text" class="form-control" id="nama_lengkap_pasien" name="nama_lengkap_pasien" autocomplete="off"  >
      </div>
      <div class="col-sm-3">
        <label>Alamat Pasien </label>
        <input style="height: 20px;" type="text" class="form-control" id="alamat_pasien" name="alamat_pasien" autocomplete="off"  >
      </div> 
    <label><br><br><br></label>
        <button id="filter_cari" type="submit" class="btn btn-success"><i class='fa fa-search'> </i>&nbsp;Cari</button>

    </div>

 </div> <!--END collapseExample -->

<span id="span_pasien_lama">
<table id="pasien_lama" class="display table-sm table-bordered" width="100%">
          <thead>
            <tr>
              <th style='background-color: #4CAF50; color: white' >No. RM </th>
              <th style='background-color: #4CAF50; color: white' >Nama Lengkap</th>
              <th style='background-color: #4CAF50; color: white' >Jenis Kelamin</th>
              <th style='background-color: #4CAF50; color: white' >Alamat Sekarang </th>
              <th style='background-color: #4CAF50; color: white' >Tanggal Lahir </th>
            </tr>
          </thead>
</table>
</span>

<span id="span_filter_pasien_lama" style="display: none">
<table id="filter_pasien_lama" class="display table-sm table-bordered" width="100%">
          <thead>
            <tr>
              <th style='background-color: #4CAF50; color: white' >No. RM </th>
              <th style='background-color: #4CAF50; color: white' >Nama Lengkap</th>
              <th style='background-color: #4CAF50; color: white' >Jenis Kelamin</th>
              <th style='background-color: #4CAF50; color: white' >Alamat Sekarang </th>
              <th style='background-color: #4CAF50; color: white' >Tanggal Lahir </th>
            </tr>
          </thead>
</table>
</span>

<span id="hasil_migrasi"></span>
<br>


<div class="row">
  <div class="col-sm-4">
  <div class="card card-block">


<form role="form" action="proses_rawat_jalan.php" id="sending" method="POST">


<input style="height: 20px;" type="hidden" class="form-control" id="token" name="token" value="Kosasih" autocomplete="off"> 


<div class="form-group">
  <label for="no_rm">No RM:</label>
  <input style="height: 20px;" type="text" class="form-control" id="no_rm" name="no_rm"  readonly="" autocomplete="off" >
</div>

<div class="form-group">
  <label for="sel1">Perujuk</label>
  <select class="form-control" id="rujukan" name="rujukan" autocomplete="off">  
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
  <label for="sel1">Penjamin</label>
  <select class="form-control" id="penjamin" name="penjamin"  autocomplete="off">
  <?php 
  $query = $db->query("SELECT nama FROM penjamin ORDER BY id ASC ");
  while ( $data = mysqli_fetch_array($query)) 
  {
  echo "<option value='".$data['nama']."'>".$data['nama']."</option>";
  }
  ?>

  </select>
</div>

<button type="button" accesskey="l" class="btn btn-warning" id="lay"><i class="fa fa-list"></i> Lihat <u>L</u>ayanan </button>
     <br>
      <br>
<div class="form-group">
  <label for="nama_lengkap">Nama Lengkap Pasien:</label>
  <input style="height: 20px;" type="text" class="form-control disable5" id="nama_lengkap" name="nama_lengkap" readonly="" autocomplete="off"  >
</div>

<div class="form-group">
  <label for="alamat">Alamat Sekarang</label>
  <textarea class="form-control" id="alamat" name="alamat" autocomplete="off"></textarea>
</div>
   
<div class="form-group">
    <label for="alamat">Tanggal Lahir</label>
    <input style="height: 20px;" type="text" class="form-control" id="tanggal_lahir" name="tanggal_lahir"  autocomplete="off">
</div>

<div class="form-group" >
  <label for="umur">Umur</label>
  <input style="height: 20px;" type="text" class="form-control disable5" id="umur" readonly="" name="umur"  autocomplete="off">
</div>

</div>
</div> <!--col-sm-4-->

<div class="col-sm-4">



<div class="card card-block">

<div class="form-group">
  <label for="sel1">Jenis Kelamin</label>

  <input class="form-control disable6" id="jenis_kelamin" name="jenis_kelamin"  readonly="" autocomplete="off">

</div>

<div class="form-group" >
  <label for="umur">No Telp</label>
  <input style="height: 20px;" type="text"  class="form-control " id="hp" name="hp" autocomplete="off">
</div>

</div>

<div class="card card-block">


<div class="form-group">
<label> Dokter </label>
<select style="font-size:15px; height:35px" name="petugas_dokter" id="petugas_dokter" class="form-control" >
 <?php 
    
    //untuk menampilkan semua data pada tabel pelanggan dalam DB
    $query01 = $db->query("SELECT nama FROM user WHERE tipe = '1'");
    
      $petugas = $db->query("SELECT nama_dokter FROM penetapan_petugas");
        $data_petugas = mysqli_fetch_array($petugas);

    //untuk menyimpan data sementara yang ada pada $query
    while($data01 = mysqli_fetch_array($query01))
    {
    
      

    if ($data01['nama'] == $data_petugas['nama_dokter']) {
     echo "<option selected value='".$data01['nama'] ."'>".$data01['nama'] ."</option>";
    }
    else{
      echo "<option value='".$data01['nama'] ."'>".$data01['nama'] ."</option>";
    }

    
    }
    
    
    ?>

</select>
</div> 
<div class="form-group">
  <label for="sel1">Poli / Penunjang Medik</label>
  <select class="form-control" id="poli" name="poli"  autocomplete="off">
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
  <label for="sel1">Keadaan Umum Pasien</label>
  <select class="form-control" id="kondisi" name="kondisi"  autocomplete="off">
    <option value="Tampak Normal">Tampak Normal</option>
    <option value="Pucat dan Lemas">Pucat dan Lemas</option>
    <option value="Sadar dan Cidera">Sadar dan Cidera</option>
    <option value="Pingsan / Tidak Sadar">Pingsan / Tidak Sadar</option>
    <option value="Meninggal Sebelum Tiba">Meninggal Sebelum Tiba</option>
  </select>
</div>

<div class="form-group ">
  <label >Alergi Obat *</label>
  <input style="height: 20px;" type="text" class="form-control" id="alergi" name="alergi" value="Tidak Ada"  autocomplete="off"> 
</div>



</div>

<?php if ($data_sett['tampil_ttv'] == 0): ?>

  <button type="submit" accesskey="d" id="submit_daftar" class="btn btn-info hug"><i class="fa fa-plus"></i> <u>D</u>aftar Rawat Jalan</button> 
  
<?php endif ?>

</div> <!--  CLOSE col sm 4 -->


<?php if ($data_sett['tampil_ttv'] == 1): ?>

<div class="col-sm-4">

<div class="card card-block">


<center><h4>Tanda Tanda Vital</h4></center>
<div class="form-group">

  <label >Sistole / Diastole (mmHg)</label>
  <input style="height: 20px;" type="text"  class="form-control" id="sistole_distole" name="sistole_distole"  autocomplete="off"> 
</div>

<div class="form-group">
  <label >Frekuensi Pernapasan (kali/menit)</label>
  <input style="height: 20px;" type="text"  class="form-control" id="respiratory_rate" name="respiratory_rate"  autocomplete="off"> 
</div>

<div class="form-group">
  <label >Suhu (°C)</label>
  <input style="height: 20px;" type="text"  class="form-control" id="suhu" name="suhu" autocomplete="off"> 
</div>

<div class="form-group ">
   <label >Nadi (kali/menit)</label>
   <input style="height: 20px;" type="text"  class="form-control" id="nadi" name="nadi"  autocomplete="off"> 
</div>

<div class="form-group ">
  <label >Berat Badan (kg)</label>
  <input style="height: 20px;" type="text"  class="form-control" id="berat_badan" name="berat_badan"  autocomplete="off"> 
</div>

<div class="form-group ">
  <label >Tinggi Badan (cm)</label>
  <input style="height: 20px;" type="text"  sclass="form-control" id="tinggi_badan" name="tinggi_badan"  autocomplete="off"> 
</div>



</div> <!--card-block-->


  <button type="submit" accesskey="d" id="submit_daftar" class="btn btn-info hug"><i class="fa fa-plus"></i> <u>D</u>aftar Rawat Jalan</button> 

</div> <!-- col-sm-4-->
  
<?php endif ?>





</form>



 </div> <!--row utama-->
 </div><!-- penutup collapse -->


<!-- PEMBUKA DATA TABLE -->
<style>

tr:nth-child(even){background-color: #f2f2f2}

</style>

<span id="tabel-jalan">
<div class="table-responsive">
<table id="table_rawat_jalan" class="display table table-bordered table-sm">
    <thead>
      <tr>
             <th style='background-color: #4CAF50; color: white'>Aksi</th>
             <th style='background-color: #4CAF50; color: white'>Edit</th>
             <th style='background-color: #4CAF50; color: white'>Batal </th>
             <th style='background-color: #4CAF50; color: white'>No REG</th>
             <th style='background-color: #4CAF50; color: white'>No RM </th>
             <th style='background-color: #4CAF50; color: white'>Tanggal</th>       
             <th style='background-color: #4CAF50; color: white'>Nama Pasien</th>
             <th style='background-color: #4CAF50; color: white'>Penjamin</th>
             <th style='background-color: #4CAF50; color: white'>Umur</th>
             <th style='background-color: #4CAF50; color: white'>Jenis Kelamin</th>
             <th style='background-color: #4CAF50; color: white'>Dokter</th>
             <th style='background-color: #4CAF50; color: white'>Poli</th>               
             <th style='background-color: #4CAF50; color: white'>No Urut</th> 
    </tr>
    </thead>

 </table>
</div><!--div responsive-->
 <!-- AKHIR TABLE -->

</span>

   
 

</div> <!--container-->




<!--   script untuk Batal-->
<script type="text/javascript">
     $(document).on('click', '.pilih2', function (e) {  
               var reg = $(this).attr('data-reg');
               var id = $(this).attr('data-id');

               $("#batal_raja").attr('data-id',id);
               $("#detail2").modal('show');
               $("#no_reg").val(reg);


               
     });
//            tabel lookup mahasiswa         
</script>

<script type="text/javascript">
     $(document).on('click', '#batal_raja', function (e) {    
                    var reg = $("#no_reg").val();
                    var keterangan = $("#keterangan").val();
                    var id = $(this).attr("data-id");
                    
                    
                    $("#detail2").modal('hide');
                    
                    $.post("proses_keterangan_batal.php",{reg:reg, keterangan:keterangan},function(data){
                      $('#table_rawat_jalan').DataTable().destroy();
     
                  var dataTable = $('#table_rawat_jalan').DataTable( {
                      "processing": true,
                      "serverSide": true,
                      "ajax":{
                        url :"datatable_registrasi_rawat_jalan.php", // json datasource
                        type: "post",  // method  , by default get
                        error: function(){  // error handling
                          $(".employee-grid-error").html("");
                          $("#table_rawat_jalan").append('<tbody class="employee-grid-error"><tr><th colspan="3">No data found in the server</th></tr></tbody>');
                          $("#employee-grid_processing").css("display","none");
                          }
                      },
                         "fnCreatedRow": function( nRow, aData, iDataIndex ) {

                          $(nRow).attr('class','tr-id-'+aData[12]+'');         

                      }
                    });
                    });

                    
        }); 

     
</script>
<!--  end script untuk batal-->

<!--script ambil data pasien modal-->
<script type="text/javascript">
//jika dipilih, nim akan masuk ke input dan modal di tutup
            $(document).on('click', '.pilih', function (e) {


              document.getElementById("no_rm").value = $(this).attr('data-no');
              document.getElementById("nama_lengkap").value = $(this).attr('data-nama');
              document.getElementById("tanggal_lahir").value = $(this).attr('data-lahir');
              document.getElementById("alamat").value = $(this).attr('data-alamat');
              document.getElementById("jenis_kelamin").value = $(this).attr('data-jenis-kelamin');
              document.getElementById("hp").value = $(this).attr('data-hp');
              document.getElementById("penjamin").value = $(this).attr('data-penjamin');
              $('#hasil_migrasi').html('');
              $("#no_rm").focus();

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


   <script>
   //untuk menampilkan data yang diambil pada form tbs penjualan berdasarkan id=formtambahproduk
  $("#submit_daftar").click(function(){

    var no_rm = $("#no_rm").val();
    var nama_lengkap = $("#nama_lengkap").val();
    var alamat = $("#alamat").val();
    var jenis_kelamin = $("#jenis_kelamin").val();
    var hp = $("#hp").val();
    var kondisi = $("#kondisi").val();
    var penjamin = $("#penjamin").val();
    if (penjamin == '')
    {
      penjamin = 'PERSONAL';
    }
    var petugas_dokter = $("#petugas_dokter").val();
    var rujukan = $("#rujukan").val();
    var poli = $("#poli").val();
    var umur = $("#umur").val();
    var sistole_distole = $("#sistole_distole").val();
    var respiratory_rate = $("#respiratory_rate").val();
    var suhu = $("#suhu").val();
    var nadi = $("#nadi").val();
    var berat_badan = $("#berat_badan").val();
    var tinggi_badan = $("#tinggi_badan").val();
    var alergi = $("#alergi").val();
    var tanggal_lahir = $("#tanggal_lahir").val();
    var token = $("#token").val();


              if ( no_rm == ""){
              alert("Pasien Belum Ada!");
              $("#cari_migrasi").focus();
              }
              else if(penjamin == ""){
              
              alert("Kolom Penjamin Harus Disi");
              $("#penjamin").focus();
              
              }
              else if (rujukan == ""){
              
              alert("Kolom Rujukan Harus Disi");
              $("#rujukan").val();
              
              }
              
              else if (nama_lengkap == ""){
              
              alert("Kolom Nama Pasien Harus Disi");
              $("#nama_lengkap").focus();
              
              }
              else if (jenis_kelamin == ""){
              
              alert("Kolom Jenis Kelamin Harus Disi");
              $("#jenis_kelamin").focus();
              
              }
              else if (tanggal_lahir== ""){
              
              alert("Kolom Tanggal Lahir Harus Disi");
              $("#tanggal_lahir").focus();
              }
              else if (umur == ""){
              
              alert("Kolom Umur Harus Disi");
              
              }
              else if (poli == ""){
              
              alert("Kolom Poli Harus Disi");
              $("#poli").focus();
              }
              else if (kondisi == ""){
              
              alert("Kolom Kondisi Harus Disi");
              $("#verbal").focus();
              }
              else if (alergi == ""){
              
              alert("Alergi Obat Harus Disi");
              $("#alergi").focus();
              }
              else if (petugas_dokter == ""){
              
              alert("Kolom Dokter Harus Disi");
              $("#petugas_dokter").focus();
              }

else{

  $("#kembali").hide();
   $("#coba").show();
   $("#demo").hide();
 $.post("proses_rawat_jalan.php",{no_rm:no_rm,nama_lengkap:nama_lengkap,alamat:alamat,jenis_kelamin:jenis_kelamin,hp:hp,kondisi:kondisi,penjamin:penjamin,rujukan:rujukan,poli:poli,umur:umur,sistole_distole:sistole_distole,respiratory_rate:respiratory_rate,suhu:suhu,nadi:nadi,berat_badan:berat_badan,tinggi_badan:tinggi_badan,alergi:alergi,tanggal_lahir:tanggal_lahir, token:token, petugas_dokter:petugas_dokter},function(data){
     
     $('#table_rawat_jalan').DataTable().destroy();
     
      var dataTable = $('#table_rawat_jalan').DataTable( {
          "processing": true,
          "serverSide": true,
          "ajax":{
            url :"datatable_registrasi_rawat_jalan.php", // json datasource
            type: "post",  // method  , by default get
            error: function(){  // error handling
              $(".employee-grid-error").html("");
              $("#table_rawat_jalan").append('<tbody class="employee-grid-error"><tr><th colspan="3">No data found in the server</th></tr></tbody>');
              $("#employee-grid_processing").css("display","none");
              }
          },
             "fnCreatedRow": function( nRow, aData, iDataIndex ) {

              $(nRow).attr('class','tr-id-'+aData[12]+'');         

          }
        });

     $("#no_rm").val('');
     $("#nama_lengkap").val('');
     $("#alamat").val('');
     $("#jenis_kelamin").val('');
     $("#hp").val('');
     $("#kondisi").val('');
     $("#rujukan").val('');

     $("#umur").val('');
     $("#sistole_distole").val('');
     $("#respiratory_rate").val('');
     $("#suhu").val('');
     $("#nadi").val('');
     $("#berat_badan").val('');
     $("#tinggi_badan").val('');
     $("#alergi").val('');
     $("#tanggal_lahir").val('');
     
     });


} // end else {}
      
  });



    $("form").submit(function(){
    return false;
    
    });


   </script>


<!--script panggil pasien-->
<script type="text/javascript">
//jika dipilih, nim akan masuk ke input dan modal di tutup
            $(document).on('click', '.pilih1', function (e) {
                var id = $(this).attr('data-id');
                var status = $(this).attr('data-status');
                var no_urut = $(this).attr('data-urut');
                var poli = $(this).attr('data-poli');

                $.post("cek_no_urut_panggil.php",{id:id,no_urut:no_urut,poli:poli},function(data)
                {
                  if (data == 1) 
                    {
                        $.post("panggil_pasien.php",{id:id,status:status},function(data)
                        {
                        });
                        $("#panggil-"+id+"").hide();
                        $("#proses-"+id+"").show();
                        }
                        else
                        {
                           $("#btn_jadi_panggil").attr("data-id",id);
                           $("#btn_jadi_panggil").attr("data-status",status);
                           $("#modal_no_urut").modal('show');
                        
                        }
                });



            });

      $(document).on('click', '#btn_jadi_panggil', function (e) {

        var id = $(this).attr('data-id');
        var status = $(this).attr('data-status');

        $.post("panggil_pasien.php",{id:id,status:status},function(data)
         {
         });
         $("#panggil-"+id+"").hide();
         $("#proses-"+id+"").show();
         $("#modal_no_urut").modal('hide');
      });

</script>
<!--end script panggil pasien-->


<!--script panggil pasien-->
<script type="text/javascript">
//jika dipilih, nim akan masuk ke input dan modal di tutup
            $(document).on('click', '.pilih00', function (e) {
                var id = $(this).attr('data-id');
                var status = $(this).attr('data-status');
                var no_urut = $(this).attr('data-urut');

              
                $(".tr-id-"+id+"").remove();
                $.post("panggil_pasien.php",{id:id,status:status,no_urut:no_urut},function(data){

                  });


      var table = $('#table_rawat_jalan').DataTable(); 
         table.row( $(this).parents('tr') ).remove().draw();

            });


//tabel lookup mahasiswa



</script>
<!--end script panggil pasien-->


<!--<script type="text/javascript">
//tanggal_lahir
 $(function() {
   
$( "#tanggal_lahir" ).datepicker({
  dateFormat: "dd-mm-yy", changeYear: true ,  yearRange: "1800:2500"
});
});
//end tanggal_LAHIR
</script>

<script>
//tanggal_lahir
  $(function() {
  $( "#tanggal_lahir" ).pickadate({ selectYears: 100, format: 'dd-mm-yyyy'});
  });
  </script>-->

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

$("#submit_cari").click(function(){

  var cari = $("#cari_migrasi").val();
  if (cari == '') {

$("#hasil_migrasi").html('');

  }
  else
  {
    $("#hasil_migrasi").html('Loading..');
 $.post("cek_pasien_lama_reg.php",{cari:cari},function(data){
    $("#hasil_migrasi").html(data);

  });

  }
 

});

$("#form_cari").submit(function(){
  return false;
});
</script>


<script type="text/javascript">
//berfunsi untuk mencekal username ganda
 $(document).ready(function(){
  $(document).on('click', '.pilih', function (e) {
    var no_rm = $("#no_rm").val();
    var nama_pasien = $("#nama_lengkap").val();

 $.post('cek_data_pasien_raja.php',{no_rm:no_rm,nama_pasien:nama_pasien}, function(data){
  
  if(data == 1){
    alert("Anda Tidak Bisa Menambahkan Pasien Yang Sudah Ada!");
    $("#no_rm").val('');
    $("#nama_pasien").val('');
    $("#no_hp").val('');
    $("#tanggal_lahir").val('');
    $("#alamat").val('');
    $("#jenis_kelamin").val('');
    $("#penjamin").val('');
    $("#gol_darah").val('');
    $("#umur").val('');

   }//penutup if

    });////penutup function(data)

    });//penutup click(function()
  });//penutup ready(function()
</script>

<!--script disable hubungan pasien-->
<script type="text/javascript">
  $("#coba").click(function(){
  $("#demo").show();
  $("#kembali").show();
  $("#tombol_span_filter").show();
   $("#coba").hide();
  });
    
  $("#kembali").click(function(){
  $("#demo").hide();
  $("#coba").show();
  $("#kembali").hide();
  $("#tombol_span_filter").hide();

  });

</script>

<script type="text/javascript">
  $("#tombol_span_filter").click(function(){
  $("#tombol_span_filter").hide();
  $("#tombol_span_filter_2").show();
  $("#span_pasien_lama").hide();
  });
    
  $("#tombol_span_filter_2").click(function(){  
  $("#tombol_span_filter_2").hide();
  $("#tombol_span_filter").show();
  $("#span_pasien_lama").show();

  });

</script>

<script type="text/javascript">
//berfunsi untuk mencekal username ganda
 $(document).ready(function(){
  $(document).on('click', '.pilih', function (e) {
    var no_rm = $("#no_rm").val();
    var nama_pasien = $("#nama_pasien").val();

 $.post('cek_data_pasien_rawat_jalan.php',{no_rm:no_rm,nama_pasien:nama_pasien}, function(data){
  
  if(data == 1){
    alert("Anda Tidak Bisa Menambahkan Pasien Yang Sudah Ada!");
    $("#no_rm").val('');
    $("#nama_pasien").val('');
    $("#no_hp").val('');
    $("#tanggal_lahir").val('');
    $("#alamat").val('');
    $("#jenis_kelamin").val('');
    $("#penjamin").val('');
    $("#gol_darah").val('');
    $("#umur").val('');

   }//penutup if

    });////penutup function(data)

    });//penutup click(function()
  });//penutup ready(function()
</script>

<!-- DATATABLE AJAX PASIEN LAMA-->
    <script type="text/javascript" language="javascript" >
      $(document).ready(function() {
        var dataTable = $('#pasien_lama').DataTable( {
          "processing": true,
          "serverSide": true,
          "ajax":{
            url :"cek_pasien_lama_reg.php", // json datasource
            type: "post",  // method  , by default get
            error: function(){  // error handling
              $(".employee-grid-error").html("");
              $("#pasien_lama").append('<tbody class="employee-grid-error"><tr><th colspan="3">No data found in the server</th></tr></tbody>');
              $("#employee-grid_processing").css("display","none");
              
            }
          },

          "fnCreatedRow": function( nRow, aData, iDataIndex ) {

              $(nRow).attr('class', "pilih");
              $(nRow).attr('data-no', aData[0]);
              $(nRow).attr('data-nama', aData[1]);
              $(nRow).attr('data-jenis-kelamin', aData[2]);
              $(nRow).attr('data-alamat', aData[3]);
              $(nRow).attr('data-lahir', aData[4]);
              $(nRow).attr('data-darah', aData[5]);
              $(nRow).attr('data-hp', aData[6]);
              $(nRow).attr('data-penjamin', aData[7]);

          }

        });
      });
    </script>
<!-- / DATATABLE AJAX PASIEN LAMA-->

<!-- START DATATABLE AJAX PASIEN LAMA / FILTER PASIEN-->
    <script type="text/javascript" language="javascript" >
      $(document).ready(function() {        
        $(document).on('click','#filter_cari',function(e){          
        $('#filter_pasien_lama').DataTable().destroy();
        var dataTable = $('#filter_pasien_lama').DataTable( {
          "processing": true,
          "serverSide": true,
          "ajax":{
            url :"filter_pencarian_pasien_lama.php", // json datasource
            "data": function ( d ) {
                d.nama_lengkap_pasien = $("#nama_lengkap_pasien").val();
                d.alamat_pasien = $("#alamat_pasien").val();
                // d.custom = $('#myInput').val();
                // etc
            },
            type: "post",  // method  , by default get
            error: function(){  // error handling
              $(".employee-grid-error").html("");
              $("#filter_pasien_lama").append('<tbody class="employee-grid-error"><tr><th colspan="3">No data found in the server</th></tr></tbody>');
              $("#employee-grid_processing").css("display","none");
              
            }
          },

          "fnCreatedRow": function( nRow, aData, iDataIndex ) {

              $(nRow).attr('class', "pilih");
              $(nRow).attr('data-no', aData[0]);
              $(nRow).attr('data-nama', aData[1]);
              $(nRow).attr('data-jenis-kelamin', aData[2]);
              $(nRow).attr('data-alamat', aData[3]);
              $(nRow).attr('data-lahir', aData[4]);
              $(nRow).attr('data-darah', aData[5]);
              $(nRow).attr('data-hp', aData[6]);
              $(nRow).attr('data-penjamin', aData[7]);

          }

          });

        $("#span_pasien_lama").hide();
        $("#span_filter_pasien_lama").show();

        });
      });
    </script>

<!-- / DATATABLE AJAX PASIEN LAMA / FILTER PASIEN-->


<!-- DATATABLE AJAX DAFTAR PASIEN-->
    <script type="text/javascript" language="javascript" >
      $(document).ready(function() {
        var dataTable = $('#table_rawat_jalan').DataTable( {
          "processing": true,
          "serverSide": true,
          "ajax":{
            url :"datatable_registrasi_rawat_jalan.php", // json datasource
            type: "post",  // method  , by default get
            error: function(){  // error handling
              $(".employee-grid-error").html("");
              $("#table_rawat_jalan").append('<tbody class="employee-grid-error"><tr><th colspan="3">No data found in the server</th></tr></tbody>');
              $("#employee-grid_processing").css("display","none");
              
            }
          },
             "fnCreatedRow": function( nRow, aData, iDataIndex ) {

              $(nRow).attr('class','tr-id-'+aData[12]+'');         

          }
        });
      });
    </script>
<!-- / DATATABLE AJAX DAFTAR PASIEN-->

<!--footer -->
<?php
 include 'footer.php';
?>
<!--end footer-->