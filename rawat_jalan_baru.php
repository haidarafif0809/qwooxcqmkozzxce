<?php include 'session_login.php';
include 'header.php';
include 'navbar.php';
include 'db.php';
 include 'sanitasi.php';
$q_penetapan = $db->query("SELECT * FROM penetapan_petugas");
$v_penetapan = mysqli_fetch_array($q_penetapan);
$nama_dokter  = $v_penetapan['nama_dokter'];

$settt = $db->query("SELECT tampil_ttv FROM setting_registrasi");
$datasett = mysqli_fetch_array($settt);

?>
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
        
        <button type="button" class="btn btn-danger" data-dismiss="modal">Closed</button>
    </div>
    </div>
  </div>
</div>
<!--modal end Layanan Perusahaan-->


<div class="container">
   <h3><b>REGISTRASI RAWAT JALAN BARU</b></h3> <hr>

<button class="btn btn-primary" id="submit_cari" type="button" data-toggle="collapse" data-target="#collapseExample" aria-expanded="false" aria-controls="collapseExample"><i class='fa fa-search'> </i> Cari</button>
</p>


 <div class="collapse" id="collapseExample">
  <table id="pasien_migrasi" class="display table-sm table-bordered" width="100%">
          <thead>
            <tr>
              <th style='background-color: #4CAF50; color: white' >No. RM Lama </th>
              <th style='background-color: #4CAF50; color: white' >Nama Lengkap</th>
              <th style='background-color: #4CAF50; color: white' >Jenis Kelamin</th>
              <th style='background-color: #4CAF50; color: white' >Alamat Sekarang </th>
              <th style='background-color: #4CAF50; color: white' >Tanggal Lahir </th>
            </tr>
          </thead>
</table>

 </div> 

<div class="row">
  <div class="col-sm-3">
  	
  <div class="card card-block">


 <form role="form" id="formku" action="proses_pendaftaran.php" method="POST" >

  <input style="height: 20px;" type="hidden" class="form-control" id="token" name="token" value="Kosasih" autocomplete="off"> 


<div class="form-group">
    <input style="height: 20px;" type="hidden" class="form-control" id="no_rm_lama" name="no_rm_lama" readonly="">
</div>


<div class="form-group">
  <label for="sel1">Perujuk </label>
  <select class="form-control ss" id="rujukan" name="rujukan" required=""  autocomplete="off">
   
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
  <label for="sel1">Penjamin *</label>
  <select class="form-control ss" id="penjamin" name="penjamin" required="" autocomplete="off">

 <?php 
  $query = $db->query("SELECT nama FROM penjamin ORDER BY id ASC");
  while ( $data = mysqli_fetch_array($query)) 
  {
  echo "<option value='".$data['nama']."'>".$data['nama']."</option>";
  }
 ?>
  </select>
</div>

<button class="btn btn-warning" id="lay"><i class="fa fa-list"></i> Lihat Layanan </button>
     
   <br>
   <br>
  <div class="form-group">
    <label for="nama_lengkap">Nama Lengkap Pasien:</label>
    <input style="height: 20px;" type="text" class="form-control" id="nama_lengkap" name="nama_lengkap" required="" autocomplete="off">
  </div>


<div class="form-group">
  <label for="sel1">Jenis Kelamin</label>
  <select class="form-control ss" name="jenis_kelamin" id="jenis_kelamin" required="" autocomplete="off">
    <option value="laki-laki">Laki-Laki</option>
    <option value="perempuan">Perempuan</option> 
  </select>
</div>


<div class="form-group">
    <label for="tempat_lahir">Tempat Lahir:</label>
    <input style="height: 20px;" type="text" class="form-control" id="tempat_lahir" name="tempat_lahir" required="" autocomplete="off">
  </div>

<div class="form-group">
    <label for="tanggal_lahir">Tanggal Lahir:</label>
    <input style="height: 20px;" type="text" required="" class="form-control" id="tanggal_lahir" name="tanggal_lahir" autocomplete="off">
</div>

<div class="form-group">
    <label for="umur">Umur:</label>
    <input style="height: 20px;" type="text" required="" class="form-control" id="umur" name="umur" autocomplete="off">
</div>


<div class="form-group">
  <label for="sel1">Golongan Darah</label>
  <select class="form-control ss" id="gol_darah" name="gol_darah" autocomplete="off">
    <option value="-">-</option>
    <option value="A">A</option>
    <option value="B">B</option>
    <option value="O">O</option>
    <option value="AB">AB</option>
   
  </select>
</div>


<div class="form-group">
    <label for="alamat_sekarang">Alamat Sekarang:</label>
    <textarea class="form-control" id="alamat_sekarang" name="alamat_sekarang" required="" autocomplete="off"></textarea>
</div>


</div><!--penutup div card-block-->
</div> <!--col no 1-->


<div class="col-sm-3">


  <div class="card card-block">


<div class="form-group">
    <label for="no_telepon">No Telpon / HP:</label>
    <input style="height: 20px;" type="text"  class="form-control" id="no_telepon" name="no_telepon" autocomplete="off">
</div>



<div class="form-group">
    <label for="no_ktp">No Keluarga:</label>
    <input style="height: 20px;" type="text" class="form-control" id="no_kk" name="no_kk" autocomplete="off">
  </div>

  <div class="form-group">
    <label for="no_ktp">Nama KK:</label>
    <input style="height: 20px;" type="text" class="form-control" id="nama_kk" name="nama_kk" autocomplete="off">
  </div>


<div class="form-group">
    <label for="no_ktp">No KTP:</label>
    <input style="height: 20px;" type="text"  class="form-control" id="no_ktp" name="no_ktp" autocomplete="off">
  </div>



<div class="form-group">
    <label for="alamat_ktp">Alamat KTP:</label>
    <textarea class="form-control" id="alamat_ktp" name="alamat_ktp" autocomplete="off"></textarea>
</div>

  <div class="form-group">
  <label for="sel1">Status Perkawinan</label>
  <select class="form-control ss" id="sel1" name="status_kawin" autocomplete="off">
     <option value="-">-</option>
   <option value="belum menikah">Belum Menikah</option>
    <option value="menikah">Menikah</option>
    <option value="cerai">Cerai</option>
  </select>
</div>


<div class="form-group">
  <label for="sel1">Pendidikan Terakhir</label>
  <select class="form-control ss" id="sel1" name="pendidikan_terakhir" autocomplete="off">
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
  <select class="form-control ss" id="sel1" name="agama"  autocomplete="off">
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
    <label for="nama_suamiortu">Nama Suami / Orangtua :</label>
    <input style="height: 20px;" type="text" class="form-control" id="nama_suamiortu" name="nama_suamiortu" autocomplete="off">
</div>


<div class="form-group">
    <label for="pekerjaan_pasien">Pekerjaan Pasien/Ortu :</label>
    <input style="height: 20px;" type="text" class="form-control" id="pekerjaan_pasien" name="pekerjaan_pasien" autocomplete="off">
</div>

  </div><!--penutup div colsm2-->

</div>
  
<div class="col-sm-3">


  <div class="card card-block">

<div class="form-group">
    <label for="pekerjaan_pasien">Nama Penganggung Jawab :</label>
    <input style="height: 20px;" type="text" class="form-control" id="nama_penanggungjawab" name="nama_penanggungjawab" autocomplete="off">
</div>


  <div class="form-group" >
  <label for="umur">Hubungan Dengan Pasien</label>
  <select id="hubungan_dengan_pasien" class="form-control ss" name="hubungan_dengan_pasien" autocomplete="off">
      <option value="-">-</option>
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
    <input style="height: 20px;" type="text" onkeypress="return isNumberKey(event)" class="form-control" id="no_hp_penanggung" name="no_hp_penanggung" autocomplete="off">
</div>

<div class="form-group">
    <label for="alamat_penanggung">Alamat Penanggung Jawab:</label>
    <textarea class="form-control" id="alamat_penanggung" name="alamat_penanggung" autocomplete="off"></textarea>
</div>

  
<div class="form-group">
  <label for="sel1"><u>K</u>eadaan Umum Pasien</label>
  <select class="form-control" accesskey="k"id="kondisi" name="kondisi" required="" autocomplete="off">
    <option value="Tampak Normal">Tampak Normal</option>
    <option value="Pucat dan Lemas">Pucat dan Lemas</option>
    <option value="Sadar dan Cidera">Sadar dan Cidera</option>
    <option value="Pingsan / Tidak Sadar">Pingsan / Tidak Sadar</option>
    <option value="Meninggal Sebelum Tiba">Meninggal Sebelum Tiba</option>
  </select>
</div>

<div class="form-group ">
  <label >Alergi Obat *</label>
  <input style="height: 20px;" type="text" class="form-control" id="alergi" name="alergi" required="" value="Tidak Ada" placeholder="Wajib Isi" autocomplete="off"> 
</div>


</div> <!-- penutup CARD-BLOCK -->

<div class="card card-block">

<div class="form-group">
  <label for="sel1">Poli / Penunjang Medik</label>
  <select class="form-control ss" id="sel1" name="poli" required="" autocomplete="off">
  
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
  <label for="sel1">Dokter</label>
  <select class="form-control ss" id="sel1" name="dokter" required="" autocomplete="off">
    <option value="<?php echo $nama_dokter; ?>"><?php echo $nama_dokter; ?></option>
        <option value="Tidak Ada">Tidak Ada</option>
 <?php 
  $query = $db->query("SELECT nama FROM user WHERE tipe = '1' "); 
 while ( $data = mysqli_fetch_array($query))
  {
  echo "<option value='".$data['nama']."'>".$data['nama']."</option>";
  }
  ?>
  </select>
</div>





</div><!-- end class="card card-block"-->

 <?php if ($datasett['tampil_ttv'] == 0): ?>
    <button accesskey="d" type="submit" id="submit_daftar" class="btn btn-info hug"> <i class="fa fa-plus"> </i> <u> D</u>aftar Rawat Jalan</button>
  <?php endif ?>

</div><!--penutup col sm 3-->
 

<div class="col-sm-3">
 <?php if ($datasett['tampil_ttv'] == 1): ?>
   <div class="card card-block">

<center><h4>Tanda Tanda Vital</h4></center>
<div class="form-group">
 <label >Sistole / Diastole (mmHg)</label>
  <input style="height: 20px;" type="text"  class="form-control" id="sistole_distole" name="sistole_distole" autocomplete="off"> 
</div>


<div class="form-group ">
  <label >Frekuensi Pernapasan (kali/menit)</label>
  <input style="height: 20px;" type="text"  class="form-control" id="respiratory_rate" name="respiratory_rate" autocomplete="off"> 
</div>
 

<div class="form-group">
  <label >Suhu (°C)</label>
  <input style="height: 20px;" type="text"  class="form-control" id="suhu" name="suhu" autocomplete="off"> 
</div>
  

<div class="form-group ">
   <label >Nadi (kali/menit)</label>
  <input style="height: 20px;" type="text"  class="form-control" id="nadi" name="nadi" autocomplete="off"> 
</div>


<div class="form-group ">
  <label >Berat Badan (kg)</label>
  <input style="height: 20px;" type="text"  class="form-control" id="berat_badan" name="berat_badan" autocomplete="off"> 
</div>

<div class="form-group ">
  <label >Tinggi Badan (cm)</label>
  <input style="height: 20px;" type="text"  class="form-control" id="tinggi_badan" name="tinggi_badan" autocomplete="off"> 
</div>



</div> <!-- nutup sm-->

  <button accesskey="d" type="submit" id="submit_daftar" class="btn btn-info hug"><i class="fa fa-plus"></i> <u> D</u>aftar Rawat Jalan</button>

<?php endif ?>
</div><!--panel body-->

</form>

</div> <!--row utama--> 
</div> <!--container-->





<!--script chossen
<script>
$(".ss").chosen({no_results_text: "Oops, Tidak Ada !"});
</script>
script end chossen-->



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

  
function hitung_umur(tanggal_input){

var now = new Date(); //Todays Date   
var birthday = tanggal_input;
birthday=birthday.split("-");   

var dobMonth= birthday[0]; 
var dobDay= birthday[1];
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
if (nowDay < dobDay) {
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


<script type="text/javascript">
// TANGGAL LAHIR UNTUK MENAMPILKAN UMUR
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


<!-- DATATABLE AJAX PASIEN MIGRASI-->
    <script type="text/javascript" language="javascript" >
      $(document).ready(function() {

        var dataTable = $('#pasien_migrasi').DataTable( {
          "processing": true,
          "serverSide": true,
          "ajax":{
            url :"cek_pasien_migrasi.php", // json datasource
            type: "post",  // method  , by default get
            error: function(){  // error handling
              $(".employee-grid-error").html("");
              $("#pasien_migrasi").append('<tbody class="employee-grid-error"><tr><th colspan="3">No data found in the server</th></tr></tbody>');
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
              $(nRow).attr('data-hp', aData[5]);


          }

        });


      });
    </script>
<!-- / DATATABLE AJAX PASIEN MIGRASI-->



<!--footer-->
<?php 
include 'footer.php';
?>
<!--end footer-->



