<?php include 'session_login.php';
include 'header.php';
include 'navbar.php';
include 'db.php';
include_once 'sanitasi.php';

$otoritas_laboratorium = $db->query("SELECT input_jasa_lab, input_hasil_lab FROM otoritas_laboratorium WHERE id_otoritas = '$_SESSION[otoritas_id]'");
$take_lab = mysqli_fetch_array($otoritas_laboratorium);
$input_jasa_lab = $take_lab['input_jasa_lab'];
$input_hasil_lab = $take_lab['input_hasil_lab'];

$query_petugas_jaga= $db->query("SELECT nama_dokter,nama_paramedik,nama_farmasi FROM penetapan_petugas ");
$data_petugas_jaga = mysqli_fetch_array($query_petugas_jaga);
$dokter = $data_petugas_jaga['nama_dokter'];
?>
<!--Container-->
<div class="container">

<!--Mulai Modal Batal-->
<div id="modal_batal_aps" class="modal fade" role="dialog">
  <div class="modal-dialog modal-lg">
    <!-- Modal content-->
    <div class="modal-content">
    <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>  
        <center><h3><b>Batal Registrasi APS Laboratorium / Radiologi</b></h3></center>    
    </div>
    <div class="modal-body">

      <span id="tampil_pulang">

        <form method="POST" accept-charset="utf-8">
  
<div class="form-group">
  <label>Keterangan</label>
  <textarea class="form-control"  id="keterangan_batal" name="keterangan_batal" required="" placeholder="Keterangan Batal Wajib Diisi" autocomplete="off"></textarea> 
</div>
<input type="hidden" id="reg2" name="reg2">



  </form>
      </span>
    </div>
    <div class="modal-footer">
    <center>
      <button type="submit" class="btn btn-primary" id="batal_rawat_aps" data-id="" data-reg="" ><i class='fa fa-home'></i> Batal
      </button>
      
      <button type="button" class="btn btn-danger" data-dismiss="modal"><i class='fa fa-close'></i> Closed</button>
    </center>
    </div>
    </div>
  </div>
</div>
<!--Akhir Modal Batal-->


<h3>Data Pasien APS Laboratorium / Radiologi</h3><hr>
  <!--Tombol Daftar-->
	<button type="submit" class="btn btn-info hug" id="daftar_ugd"><i class="fa fa-plus"></i> Daftar </button>
  <!--Tombol Kembali-->
  <button id="kembali" style="display:none" data-toggle="collapse" accesskey="k"  class="btn btn-info"><i class="fa fa-reply"></i> <u>K</u>embali</button>

	<a href="registrasi_lab_baru.php" accesskey="b" class="btn btn-primary"> <i class="fa fa-plus"></i> Pasien <u>B</u>aru</a>



<span id="span_pasien_lama">
<table id="pasien_lama" class="display table-sm table-bordered" width="100%">
  <thead>
    <tr>

    <th style='background-color: #4CAF50; color: white'>No. RM</th>
    <th style='background-color: #4CAF50; color: white'>Nama Lengkap</th>
    <th style='background-color: #4CAF50; color: white'>Jenis Kelamin</th>
    <th style='background-color: #4CAF50; color: white'>Alamat Sekarang</th>
    <th style='background-color: #4CAF50; color: white'>Tanggal Lahir</th>

    </tr>
  </thead>
</table>
</span>

<!--Colapse id Demo (1)-->
<div id="form_daftar" class="collapse">
<!--Mulai Form and Proses-->
<form role="form" >

  <!--Mulai Row Pertama-->
  <div class="row">
    <!--Mulai Col SM Awal-->
    <div class="col-sm-4">
      <!--Mulai Card Blok-->
      <div class="card card-block">
        <div class="form-group">
          <label for="no_rm">No RM</label>
          <input style="height: 20px;" type="text" class="form-control disable1" readonly="" id="no_rm" name="no_rm"    >
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
            <label for="tanggal_lahir">Tanggal Lahir:</label>
            <input style="height: 20px;" type="text" class="form-control" id="tanggal_lahir" data-format="dd-mm-yyyy" name="tanggal_lahir" required="" autocomplete="off">
        </div>

        <div class="form-group">
            <label for="umur">Umur:</label>
            <input style="height: 20px;" type="text" required="" class="form-control" id="umur" name="umur" autocomplete="off">
        </div>


      <!--Akhir Card Blok-->
      </div>
    <!--Akhir Col SM Awal-->
    </div>

    <!--Mulai Col SM Kedua-->
    <div class="col-sm-4">
      <!--Mulai Card Kedua-->
      <div class="card card-block">
      
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

        <div class="form-group">
            <label for="alamat">Alamat :</label>
            <textarea class="form-control" id="alamat" name="alamat" required="" autocomplete="off"></textarea>
        </div>

        <div class="form-group">
            <label for="no_telepon">No Telpon / HP:</label>
            <input style="height: 20px;" onkeypress="return isNumberKey(event)" type="text" class="form-control" id="no_telepon" name="no_telepon"  autocomplete="off">
        </div>

        <div class="form-group">
          <label for="sel1">Agama</label>
          <select class="form-control" id="agama" name="agama" autocomplete="off">
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


      <br><br><br><!--agar panjang cardbkok sesuai dg pertama-->
      <!--Mulai Card Blok Kedua-->
      </div>
    <!--Mulai Col SM Kedua-->
    </div>

    <!--Mulai Col SM Ketiga-->
    <div class="col-sm-4">
      <!--Mulai Card Ketiga-->
      <div class="card card-block">

      

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
            <label for="sel1">Dokter </label>
            <select class="form-control" id="dokter" name="dokter" required="" autocomplete="off">
              <option value="<?php echo $dokter;?>"><?php echo $dokter;?></option>
                      <option value="Tidak Ada">Tidak Ada</option>
                <?php 
                $query = $db->query("SELECT id,nama FROM user WHERE tipe = '1' ");
                while ( $data = mysqli_fetch_array($query)) 
                {   
                      if ($dokter == $data['nama']) {
                        # code...
                          echo "<option selected value='".$data['id']."'>".$data['nama']."</option>";
                      }
                      else {
                          echo "<option value='".$data['id']."'>".$data['nama']."</option>";
                      }
                  
                }
                ?>
            </select>
        </div>

        <div class="form-group">
          <label for="sel1">Pemeriksaan</label>
            <select class="form-control" id="periksa" name="periksa" autocomplete="off">
            <option value="">-- PILIH PEMERIKSAAN --</option>
            <option value="1">Laboratorium</option>
            <option value="2">Radiologi</option>
          </select>
        </div>

      <!--Data Hidden-->
        <input style="height: 20px;" type="hidden" class="form-control" id="token" name="token" value="Kosasih" autocomplete="off"> 

        <input style="height: 20px;" type="hidden" class="form-control" id="penjamin" name="penjamin" autocomplete="off"> 

        <input style="height: 20px;" type="hidden" class="form-control" id="no_rm_lama" name="no_rm_lama" readonly="">

      <br><!--agar panjang cardbkok sesuai dg pertama-->

        <!--Tombol-->
        <center><button type="submit" id="registrasi_pasien" accesskey="d" class="btn btn-success hug"> <i class="fa fa-plus"></i> <u>D</u>aftar </button></center>


      <!--Mulai Card Ketiga-->
      </div>
    <!--Mulai Col SM Ketiga-->
    </div>

  <!--Akhir Row Pertama-->
  </div>
<!--Akhir Form-->
</form>
<!--Colapse id Demo (1)-->
</div>  



	<!--Table Registrasi Lab/Radiologi-->
	<div class="table-responsive">
		<table id="table_aps" class="table table-bordered table-sm  ">
 
    	<thead>

      	<tr>

		<th style='background-color: #4CAF50; color: white'>Batal</th>
		
		<?php if ($input_jasa_lab): ?>  
		<th style='background-color: #4CAF50; color: white' >Input Jasa</th>
		<?php endif?>

		<!--<?php //if ($input_hasil_lab): ?> 
    	<th style='background-color: #4CAF50; color: white' >Input Hasil</th> 
		<?php //endif?>-->

		<th style='background-color: #4CAF50; color: white'>Edit</th> 
      	<th style='background-color: #4CAF50; color: white'>No REG</th>
      	<th style='background-color: #4CAF50; color: white'>No RM </th>	
      	<th style='background-color: #4CAF50; color: white'>Nama Pasien</th>
      	<th style='background-color: #4CAF50; color: white'>Jenis Kelamin</th>
      	<th style='background-color: #4CAF50; color: white'>Umur</th>
      	<th style='background-color: #4CAF50; color: white'>Dokter</th>	
      	<th style='background-color: #4CAF50; color: white'>Tanggal</th>
      	<th style='background-color: #4CAF50; color: white'>Pemeriksaan</th>


   		</tr>
    	</thead>

 		</table><!-- AKHIR TABLE -->
	</div><!-- AKHIR RESPONSIVE -->
</div> <!--container-->

<!-- DATATABLE AJAX DAFTAR PASIEN REGISTRASI APS LABORATORIUM/RADIOLOGI-->
<script type="text/javascript" language="javascript" >
      $(document).ready(function() {
        var dataTable = $('#table_aps').DataTable( {
          "processing": true,
          "serverSide": true,
          "ajax":{
            url :"data_registrasi_aps.php", // json datasource
            type: "post",  // method  , by default get
            error: function(){  // error handling
              $(".employee-grid-error").html("");
              $("#table_aps").append('<tbody class="employee-grid-error"><tr><th colspan="3">No data found in the server</th></tr></tbody>');
              $("#table_aps_processing").css("display","none");
              
            }
          },
            "fnCreatedRow": function( nRow, aData, iDataIndex ) {
              $(nRow).attr('class','tr-id-'+aData[12]+'');
            },
        });
      });
</script>
<!-- / DATATABLE AJAX DAFTAR PASIEN REGISTRASI APS LABORATORIUM/RADIOLOGI-->


<!-- DATATABLE AJAX PASIEN LAMA-->
    <script type="text/javascript" language="javascript" >
      $(document).ready(function() {
        var dataTable = $('#pasien_lama').DataTable( {
          "processing": true,
          "serverSide": true,
          "ajax":{
            url :"cek_pasien_lama_reg_aps.php", // json datasource
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

<!--script ambil data dari modal pasien-->
<script type="text/javascript">
$(document).on('click', '.pilih', function (e) {

  document.getElementById("no_rm").value = $(this).attr('data-no');
  document.getElementById("no_telepon").value = $(this).attr('data-hp');
  document.getElementById("nama_lengkap").value = $(this).attr('data-nama');
  document.getElementById("tanggal_lahir").value = $(this).attr('data-lahir');
  document.getElementById("alamat").value = $(this).attr('data-alamat');
  document.getElementById("jenis_kelamin").value = $(this).attr('data-jenis-kelamin');
  document.getElementById("penjamin").value = $(this).attr('data-penjamin');
  document.getElementById("gol_darah").value = $(this).attr('data-darah');

  $("#no_rm").focus();


  var tanggal_lahir = $("#tanggal_lahir").val();

  //fungsi untuk hitung umur otomatis ketika klik pasien lama
  function hitung_umur(tanggal_input){

    var now = new Date(); //Todays Date   
    var birthday = tanggal_input;
    birthday=birthday.split("-");   

    var dobDay = birthday[0]; 
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
    if (tanggal_lahir == ''){

    }
    else{
      $("#umur").val(umur);
    }

});
</script>
<!--end script ambil data dari modal pasien-->

<script type="text/javascript">
//berfunsi untuk mencekal username ganda
 $(document).ready(function(){
  $(document).on('click', '.pilih', function (e) {
    var no_rm = $("#no_rm").val();
    var nama_pasien = $("#nama_lengkap").val();

 $.post('cek_data_pasien_masuk_aps.php',{no_rm:no_rm,nama_pasien:nama_pasien}, function(data){
  
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
//hidden saat awal masuk
  $("#span_pasien_lama").hide();
  $("#form_daftar").hide();

//ketika di klik tombol daftar
$("#daftar_ugd").click(function(){
  $("#form_daftar").show();
  $("#kembali").show();
  $("#span_pasien_lama").show();
  $("#daftar_ugd").hide();

  
});

//ketika klik tombol kembali
$("#kembali").click(function(){
  $("#form_daftar").hide();
  $("#daftar_ugd").show();
  $("#span_pasien_lama").hide();
  $("#kembali").hide();

});
</script>

<!--Proses Daftar Laboratorium/Radiologi (APS)-->
<script type="text/javascript">
$(document).on('click', '#registrasi_pasien', function (e) {
  var no_rm = $("#no_rm").val();
  var token = $("#token").val();
  var nama_lengkap = $("#nama_lengkap").val();
  var jenis_kelamin = $("#jenis_kelamin").val();
  var tanggal_lahir = $("#tanggal_lahir").val();
  var umur = $("#umur").val();
  var gol_darah = $("#gol_darah").val();
  var no_telepon = $("#no_telepon").val();
  var alamat = $("#alamat").val();
  var alergi = $("#alergi").val();
  var kondisi = $("#kondisi").val();
  var agama = $("#agama").val();
  var dokter = $("#dokter").val();
  var periksa = $("#periksa").val();

  if (no_rm == ""){
    alert("Pasien Belum Ada!");
      $("#no_rm").focus();
  }
  else if (nama_lengkap == ""){
    alert("Kolom Nama Pasien Masih Kosong");
  }
  else if (jenis_kelamin == ""){
    alert("Kolom Jenis Kelamin Harus Disi");
  }
  else if (tanggal_lahir== ""){
    alert("Kolom Tanggal Lahir Harus Disi");
    $("#tanggal_lahir").focus();
  }
  else if (umur == ""){
    alert("Kolom Umur Harus Disi");
  }
  else if (gol_darah == ""){
    alert("Kolom Golongan Darah Harus Disi");
    $("#gol_darah").focus();
  }
  else if (dokter == ""){
    alert("Kolom Dokter Jaga Harus Disi");
    $("#dokter").focus();
  }
  else if (periksa == ""){
    alert("Pilih dahulu Pemeriksaan");
    $("#periksa").focus();
  }
  else{

    //hidden 
    $("#span_pasien_lama").hide(); //Table Pasien Lama
    $("#form_daftar").hide(); //Form Pendaftaran
    $("#kembali").hide(); // Tombol Kembali


    $.post("proses_aps.php",{no_rm:no_rm,token:token,nama_lengkap:nama_lengkap,jenis_kelamin:jenis_kelamin,tanggal_lahir:tanggal_lahir,umur:umur,gol_darah:gol_darah,no_telepon:no_telepon,alamat:alamat,alergi:alergi,kondisi:kondisi,agama:agama,dokter:dokter,periksa:periksa},function(data){

      var table_aps = $('#table_aps').DataTable();
      table_aps.draw();

      $("#no_rm").val('');
      $("#nama_pasien").val('');
      $("#no_hp").val('');
      $("#tanggal_lahir").val('');
      $("#alamat").val('');
      $("#jenis_kelamin").val('');
      $("#penjamin").val('');
      $("#gol_darah").val('');
      $("#umur").val('');
      $("#daftar_ugd").show();

      }); //End Proses

  } //End Else
      
      $("form").submit(function(){
        return false;
      });



}); //End Function
</script>

<!--   script untuk detail layanan pulang-->
<script type="text/javascript">
$(document).on('click', '.batal_aps', function (e) {
            var reg = $(this).attr('data-reg');
            var id = $(this).attr('data-id');

               $("#reg2").val(reg);
               $("#batal_rawat_aps").attr('data-id',id);
               $("#modal_batal_aps").modal('show');
       });
</script>
<!--  end script untuk akhir detail pulang-->

<!--Mulai Proses Batal APS-->
<script type="text/javascript">
  $("#batal_rawat_aps").click(function() {  
    
    var reg = $("#reg2").val();
    var keterangan = $("#keterangan_batal").val();
    var id = $(this).attr("data-id");

    var table_aps = $('#table_aps').DataTable();
    table_aps.draw();

    $("#modal_batal_aps").modal('hide');
    $("#keterangan_batal").val('');

    $.post("proses_batal_aps.php",{reg:reg,keterangan:keterangan},function(data){
      
    });
                    
  }); 
</script>
<!--Akhir Proses Batal APS-->

<!--footer-->
<?php include 'footer.php'; ?>