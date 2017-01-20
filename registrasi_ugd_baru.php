<?php include 'session_login.php';
include 'header.php';
include 'navbar.php';
include_once'db.php';
 

$no_reg = $db->query("SELECT * FROM registrasi ORDER BY id DESC limit 1");
$tampil2= mysqli_fetch_array($no_reg);

$no_reg_terakhir = 1 + $tampil2['id'];


$qertu= $db->query("SELECT nama_dokter,nama_paramedik,nama_farmasi FROM penetapan_petugas ");
$ss = mysqli_fetch_array($qertu);


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
        
        <button type="button" accesskey="d" class="btn btn-danger" data-dismiss="modal">Close<u>d</u></button>
    </div>
    </div>
  </div>
</div>
<!--modal end Layanan Perusahaan-->


<div class="container">
<h3>REGISTRASI PASIEN BARU UGD</h3><hr>
 
<table id="pasien_baru" class="display table-sm table-bordered" width="100%">
          <thead>
            <tr>
              <th style='background-color: #4CAF50; color: white' >No. RM Lama </th>
              <th style='background-color: #4CAF50; color: white' >Nama Lengkap</th>
              <th style='background-color: #4CAF50; color: white' >Jenis Kelamin</th>
              <th style='background-color: #4CAF50; color: white' >Alamat Sekarang </th>
              <th style='background-color: #4CAF50; color: white' >Tanggal Lahir </th>
              <th style='background-color: #4CAF50; color: white' >No. Telp </th>
            </tr>
          </thead>
</table>


<span id="hasil_migrasi"></span>
<br><br>
<div class="row"> <!--  open ROW  -->
  <div class="col-sm-3"> <!--  open col 1   -->

    <form role="form" action="proses_ugd_pasien_baru.php" method="POST">



<div class="card card-block">

<div class="form-group">
    <label for="sel1">Perujuk</label>
    <select class="form-control" id="rujukan" name="rujukan" required="" autocomplete="off">  
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
    <select class="form-control" id="penjamin" name="penjamin" required="" autocomplete="off">
          <?php 
          $query = $db->query("SELECT nama FROM penjamin ORDER BY id asc ");
          while ( $data = mysqli_fetch_array($query))
          {
          echo "<option value='".$data['nama']."'>".$data['nama']."</option>";
          }
          ?>
    </select>
</div>

<button class="btn btn-success" accesskey="l" id="lay" type="button"><i class="fa fa-list"></i> Lihat <u>L</u>ayanan </button>
     
      <br>
  <br>

<div class="form-group">
    <input style="height: 20px;" type="hidden" class="form-control" id="no_rm_lama" name="no_rm_lama" readonly="">
</div>

<div class="form-group">
    <label for="nama_lengkap">Nama Lengkap Pasien:</label>
    <input style="height: 20px;" type="text" class="form-control" id="nama_lengkap" name="nama_lengkap" required="" autocomplete="off">
</div>


<div class="form-group">
  <label for="sel1">Jenis Kelamin</label>
  <select class="form-control" id="jenis_kelamin" name="jenis_kelamin" required="" autocomplete="off">
    <option value="">Silahkan Pilih</option>
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
    <input style="height: 20px;" type="text" class="form-control" id="tanggal_lahir" data-format="dd-mm-yyyy" name="tanggal_lahir" required="" autocomplete="off">
</div>


<div class="form-group">
    <label for="umur">Umur:</label>
    <input style="height: 20px;" type="text" required="" class="form-control" id="umur" name="umur" autocomplete="off">
</div>

<div class="form-group">
  <label for="sel1">Golongan Darah</label>
  <select class="form-control" id="gol_darah" name="gol_darah" autocomplete="off">
  <option value="-">-</option>
    <option value="A">A</option>
    <option value="B">B</option>
    <option value="O">O</option>
    <option value="AB">AB</option>
    
  </select>
</div>


</div>
</div> <!-- closed row no 1-->

<div class="col-sm-3"> <!--  Open SM 2  -->

<div class="card card-block">

<div class="form-group">
    <label for="alamat_sekarang">Alamat Sekarang:</label>
    <textarea class="form-control" id="alamat_sekarang" name="alamat_sekarang" required="" autocomplete="off"></textarea>
</div>

 
<div class="form-group">
    <label for="no_telepon">No Telpon / HP:</label>
    <input style="height: 20px;" onkeypress="return isNumberKey(event)" type="text" class="form-control" id="no_telepon" name="no_telepon"  autocomplete="off">
</div>


<div class="form-group">
    <label for="no_ktp">No Keluarga:</label>
    <input style="height: 20px;" onkeypress="return isNumberKey(event)" type="text" class="form-control" id="no_kk" name="no_kk" autocomplete="off">
  </div>

  <div class="form-group">
    <label for="no_ktp">Nama KK:</label>
    <input style="height: 20px;" type="text" class="form-control" id="nama_kk" name="nama_kk" autocomplete="off">
  </div>
<div class="form-group">
    <label for="no_ktp">No KTP:</label>
    <input style="height: 20px;" onkeypress="return isNumberKey(event)" type="text" class="form-control" id="no_ktp" name="no_ktp"  autocomplete="off">
</div>

<div class="form-group">
    <label for="alamat_ktp">Alamat KTP:</label>
    <textarea style="height: 85px;" class="form-control" id="alamat_ktp" name="alamat_ktp"  autocomplete="off"></textarea>
</div>




<div class="form-group">
  <label for="sel1">Status Perkawinan</label>
  <select class="form-control" id="status_kawin" name="status_kawin" autocomplete="off">
          <option value="-">-</option>
 <option value="belum menikah">Belum Menikah</option>
    <option value="menikah">Menikah</option>
    
    <option value="cerai">Cerai</option>
  </select>
</div>


<div class="form-group">
  <label for="sel1">Pendidikan Terakhir</label>
  <select class="form-control" id="pendidikan_terakhir" name="pendidikan_terakhir" autocomplete="off">
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



</div>


  </div><!--penutup div cols 2-->




  
<div class="col-sm-3"> <!--  Open COL 3  -->
<div class="card card-block">


<div class="form-group">
  <label for="sel1">Agama</label>
  <select class="form-control" id="agama" name="agama" autocomplete="off">
  <option value="">Silahkan Pilih</option>
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
    <label for="alamat_penanggung">Alamat Penanggung Jawab:</label>
    <textarea style="height: 115px;" class="form-control" id="alamat_penanggung" name="alamat_penanggung" autocomplete="off"></textarea>
</div>

<div class="form-group">
    <label for="pekerjaan_pasien">Pekerjaan Pasien/Ortu :</label>
    <input style="height: 20px;" type="text" class="form-control" id="pekerjaan_pasien" name="pekerjaan_pasien"  autocomplete="off">
</div>

<div class="form-group" >
  <label for="umur">Pengantar</label>
  <select id="pengantar" class="form-control " name="pengantar" required="" autocomplete="off">
      <option value="Datang Sendiri">Datang Sendiri</option>
      <option value="Diantar Keluarga/Family">Diantar Keluarga/Family</option>
     <option value="Diantar Orang Lain">Diantar Orang Lain</option>
      <option value="Diantar Polisi">Diantar Polisi</option>
 </select>  
</div> 


<div class="form-group">
  <label for="umur">Hubungan Dengan Pasien</label>
  <select id="hubungan_dengan_pasien" class="form-control " name="hubungan_dengan_pasien" autocomplete="off">
 <option value="">Silakan Pilih</option>
 <option value="Orang Tua">Orang Tua</option>
     <option value="Suami/Istri">Suami/Istri</option>
      <option value="Anak">Anak</option>
      <option value="Saudara">Saudara</option>
      <option value="Saudara Ipar">Saudara Ipar</option>

  </select>  
</div>


<div class="form-group" >
   <label for="umur">Nama Pengantar</label>
   <input style="height: 20px;" type="text" class="form-control " id="nama_pengantar" name="nama_pengantar" autocomplete="off">
</div> 

<div class="form-group" >
  <label for="umur">No Telphone / HP Pengantar</label>
  <input style="height: 20px;" onkeypress="return isNumberKey(event)" type="text" class="form-control" id="hp_pengantar" name="hp_pengantar" autocomplete="off">
</div>

</div>

</div> <!-- penutup col sm ke 3 -->

 

<div class="col-sm-3"> <!--  Open COL SM ke 4  -->


<div class="card card-block">

<div class="form-group">
    <label for="alamat">Alamat Pengantar</label>
    <textarea class="form-control " id="alamat_pengantar" name="alamat_pengantar"  autocomplete="off"></textarea>
</div>

<div class="form-group" >
  <label for="umur">Keterangan</label>
  <input style="height: 20px;" type="text" class="form-control " id="keterangan" name="keterangan" autocomplete="off">
</div>

<div class="form-group ">
  <label ><u>A</u>lergi Obat *</label>
  <input style="height: 20px;" type="text" class="form-control" accesskey="a" id="alergi" name="alergi" value="Tidak Ada" required="" placeholder="Wajib Isi" autocomplete="off"> 
</div>

<div class="form-group">
  <label for="sel1">Keadaan Umum Pasien</label>
  <select class="form-control" id="kondisi" name="kondisi" required="" autocomplete="off">
    <option value="Tampak Normal">Tampak Normal</option>
    <option value="Pucat dan Lemas">Pucat dan Lemas</option>
    <option value="Sadar dan Cidera">Sadar dan Cidera</option>
    <option value="Pingsan / Tidak Sadar">Pingsan / Tidak Sadar</option>
    <option value="Meninggal Sebelum Tiba">Meninggal Sebelum Tiba</option>
  </select>
</div>

<div class="form-group">
    <label for="sel1">Dokter Jaga</label>
    <select class="form-control" id="dokter_jaga" name="dokter_jaga" required="" autocomplete="off">
      <option value="<?php echo $ss['nama_dokter'];?>"><?php echo $ss['nama_dokter'];?></option>
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
  <center><h4>Glassgow Coma Scale (GCS)</h4></center>

<div class="form-group">
  <label for="sel1">Respon Mata (Eye)</label>
  <select class="form-control" id="eye" name="eye" required="" autocomplete="off">
    <option value="Tidak ada Respon (Meski Dicubit)">Tidak ada Respon (Meski Dicubit)</option>
     <option value="Respon Terhadap nyeri (Dicubit)">Respon Terhadap nyeri (Dicubit)</option>
      <option value="Respon Terhadap suara (Suruh Buka Mata)">Respon Terhadap suara (Suruh Buka Mata)</option>
       <option value="Respon Spontan (Tanpa Stimulus / Rangsang)">Respon Spontan (Tanpa Stimulus / Rangsang)</option>
  </select>
</div>


<div class="form-group">
  <label for="sel1">Respon Ucapan (Verbal)</label>
  <select class="form-control" id="verbal" name="verbal" required="" autocomplete="off">
    <option value="Tidak ada Suara">Tidak ada Suara</option>
     <option value="Suara Tidak Jelas (Tanpa Arti, Mengeranga)">Suara Tidak Jelas (Tanpa Arti, Mengeranga)</option>
      <option value="Ucapan Jelas, Subtansi Tidak Jelas/Non-kalimat (Aduh, Ibu)">Ucapan Jelas, Subtansi Tidak Jelas/Non-kalimat (Aduh, Ibu)</option>
       <option value="Berbicara Mengacau (Bingung)">Berbicara Mengacau (Bingung)</option>
        <option value="Berorientasi Baik">Berorientasi Baik</option>   
  </select>
</div>


<div class="form-group">
  <label for="sel1">Respon Gerak (Motorik)</label>
  <select class="form-control" id="motorik" name="motorik" required="" autocomplete="off">
    <option value="Tidak Ada (flasid)">Tidak Ada (flasid)</option>
     <option value="Exstensi Abnormal">Exstensi Abnormal</option>
      <option value="Fleksi Abnormal">Fleksi Abnormal</option>
       <option value="Fleksi Normal (Menarik Anggota yang Dirangsang)">Fleksi Normal (Menarik Anggota yang Dirangsang)</option>
        <option value="Melokalisir Nyeri (Menjauhkan Saat Diberi Rangsang Nyeri)">Melokalisir Nyeri (Menjauhkan Saat Diberi Rangsang Nyeri)</option>
         <option value="Ikut Perintah">Ikut Perintah</option>  
  </select>
</div>

  <input style="height: 20px;" type="hidden" class="form-control" id="token" name="token" value="Kosasih" autocomplete="off"> 

<button type="submit" id="daftar_ugd" accesskey="d" class="btn btn-info hug"> <i class="fa fa-plus"></i> <u>D</u>aftar UGD</button>

</div>





</div> <!-- PANEL UNTUK GCS -->
</div><!-- nutup sm-->

</div> <!-- row no 2-->
</form>
</div> <!--row utama-->
</div> <!--container-->


<!--script chossen
<script>
$("select").chosen({no_results_text: "Oops, Tidak Ada !"});
</script>
script end chossen-->


<script type="text/javascript">
          $("#daftar_ugd").click(function(){
         var jenis_kelamin = $("#jenis_kelamin").val();
          if (jenis_kelamin == '')
          {
            alert("Pilih Dahulu Jenis Kelamin");
          }    
        });
</script>



<!--script disable hubungan pasien-->
<script type="text/javascript">
$(document).ready(function(){
var pengantar = $("#pengantar").val();


if (pengantar == 'Datang Sendiri')
{
  $("#hubungan_dengan_pasien").attr("readonly", true);
  $("#nama_pengantar").attr("readonly", true);
    $("#alamat_pengantar").attr("readonly", true);
  $("#hp_pengantar").attr("readonly", true);

  $("#hubungan_dengan_pasien").val('');
  $("#nama_pengantar").val('');
  $("#alamat_pengantar").val('');
  $("#hp_pengantar").val('');


}

$("#pengantar").change(function(){

var pengantar = $("#pengantar").val();




if (pengantar == 'Datang Sendiri')
{
 $("#hubungan_dengan_pasien").attr("readonly", true);
  $("#nama_pengantar").attr("readonly", true);
    $("#alamat_pengantar").attr("readonly", true);
  $("#hp_pengantar").attr("readonly", true);

    $("#hubungan_dengan_pasien").val('');
  $("#nama_pengantar").val('');
  $("#alamat_pengantar").val('');
  $("#hp_pengantar").val('');
}

else if (pengantar == 'Diantar Keluarga/Family')
{
$("#hubungan_dengan_pasien").attr("readonly", false);
  $("#nama_pengantar").attr("readonly", false);
    $("#alamat_pengantar").attr("readonly", false);
  $("#hp_pengantar").attr("readonly", false);


    $("#hubungan_dengan_pasien").val('');
  $("#nama_pengantar").val('');
  $("#alamat_pengantar").val('');
  $("#hp_pengantar").val('');
}

else{
  $("#hubungan_dengan_pasien").val('');
$("#hubungan_dengan_pasien").attr("readonly", true);
  $("#nama_pengantar").attr("readonly", false);
    $("#alamat_pengantar").attr("readonly", false);
  $("#hp_pengantar").attr("readonly", false);
}

});


});
</script>
<!--script disable hubungan pasien-->



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
//tabel lookup mahasiswa         
</script>
<!--  end script untuk akhir detail layanan PERUSAHAAN -->



<!--script ambil data pasien lama modal-->
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
              $("#rujukan").focus();
// untuk update umur ketika sudah beda bulan dan tahun
var tanggal_lahir = $("#tanggal_lahir").val();
    
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
if (nowDay < dobDay) {
      agemonth--;
      ageday = 30 + ageday;
      }


if (ageyear <= 0) {
 var val = agemonth + "Bulan";
}
else {

 var val = ageyear + "Tahun";
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


<script type="text/javascript">
  
  $("#umur").blur(function(){
    var umur = $("#umur").val();
    var tanggal_lahir = $("#tanggal_lahir").val();

 if (umur != '')
{

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
}
else
{
    $("#tanggal_lahir").val('');
}

  });
</script>



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

if (tanggal_lahir != '')
{

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
}

else
{
    $("#umur").val('');

}

});
</script>



<!-- DATATABLE AJAX PASIEN LAMA-->
    <script type="text/javascript" language="javascript" >
      $(document).ready(function() {
        var dataTable = $('#pasien_baru').DataTable( {
          "processing": true,
          "serverSide": true,
          "ajax":{
            url :"cek_pasien_migrasi_ugd.php", // json datasource
            type: "post",  // method  , by default get
            error: function(){  // error handling
              $(".employee-grid-error").html("");
              $("#pasien_baru").append('<tbody class="employee-grid-error"><tr><th colspan="3">No data found in the server</th></tr></tbody>');
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

<!--  footer  -->
<?php 
include 'footer.php';
?>
<!--  end footer  -->

