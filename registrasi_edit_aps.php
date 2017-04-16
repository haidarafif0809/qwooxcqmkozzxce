<?php include 'session_login.php';
include 'header.php';
include 'navbar.php';
include_once'db.php';
include_once 'sanitasi.php';

$no_reg = stringdoang($_GET['no_reg']);

$select_registrasi = $db->query("SELECT no_rm,nama_pasien,jenis_kelamin,hp_pasien,aps_periksa FROM registrasi WHERE no_reg = '$no_reg' AND jenis_pasien = 'APS' ");
$data_registrasi = mysqli_fetch_array($select_registrasi);
$no_rm = $data_registrasi['no_rm'];
$nama_pasien = $data_registrasi['nama_pasien'];
$jenis_kelamin = $data_registrasi['jenis_kelamin'];
$hp_pasien = $data_registrasi['hp_pasien'];
$aps_periksa = $data_registrasi['aps_periksa'];//1 = Lab, 2 = Radiologi

$select_pelanggan = $db_pasien->query("SELECT tgl_lahir,alamat_sekarang FROM pelanggan WHERE kode_pelanggan = '$no_rm'");
$data_pelanggan = mysqli_fetch_array($select_pelanggan);
$tanggal_lahir = $data_pelanggan['tgl_lahir'];
$alamat = $data_pelanggan['alamat_sekarang'];

$query_petugas = $db->query("SELECT nama_dokter,nama_paramedik,nama_farmasi FROM penetapan_petugas ");
$data_petugas = mysqli_fetch_array($query_petugas);
$dokter = $data_petugas['nama_dokter'];

 ?>

<div class="container">
<h3>Edit Data Pasien APS Laboratorium / Radiologi</h3><hr>


<form role="form" >
  <!--Mulai Row Pertama-->
  <div class="row">
    <!--Mulai Col SM Awal-->
    <div class="col-sm-4">
      <!--Mulai Card Blok-->
      <div class="card card-block">
        <div class="form-group">
          <label for="no_rm">No RM</label>
          <input style="height: 20px;" type="text" class="form-control disable1" readonly="" value="<?php echo $no_rm ?>" id="no_rm" name="no_rm">
        </div>

        <div class="form-group">
            <label for="nama_lengkap">Nama Lengkap Pasien:</label>
            <input style="height: 20px;" type="text" class="form-control" value="<?php echo $nama_pasien ?>" id="nama_lengkap" name="nama_lengkap" required="" autocomplete="off">
        </div>
      
        <div class="form-group">
          <label for="sel1">Jenis Kelamin</label>
          <select class="form-control" id="jenis_kelamin" name="jenis_kelamin" required="" autocomplete="off">
          	<?php 
          	if($jenis_kelamin == 'laki-laki'){
          		echo '
          		<option selected value="laki-laki">Laki-Laki</option>
          		<option  value="perempuan">Perempuan</option>';
          	}
          	else{
          		echo '
          		<option  value="laki-laki">Laki-Laki</option>
          		<option selected value="perempuan">Perempuan</option>';
          	}
           	?>
          </select>
        </div>

        <div class="form-group">
            <label for="tanggal_lahir">Tanggal Lahir:</label>
            <input style="height: 20px;" type="text" class="form-control" value="<?php echo $tanggal_lahir ?>" id="tanggal_lahir" data-format="dd-mm-yyyy" name="tanggal_lahir" required="" autocomplete="off">
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
            <textarea class="form-control" id="alamat" name="alamat" required="" autocomplete="off"><?php echo $alamat ?></textarea>
        </div>

        <div class="form-group">
            <label for="no_telepon">No Telpon / HP:</label>
            <input style="height:20px;" value="<?php echo $hp_pasien ?>" onkeypress="return isNumberKey(event)" type="text" class="form-control" id="no_telepon" name="no_telepon"  autocomplete="off">
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
                $query = $db->query("SELECT nama FROM user WHERE tipe = '1' ");
                while ( $data = mysqli_fetch_array($query)) 
                {
                  echo "<option value='".$data['nama']."'>".$data['nama']."</option>";
                }
                ?>
            </select>
        </div>

        <div class="form-group">
          <label for="sel1">Pemeriksaan</label>
            <select class="form-control" id="periksa" name="periksa" autocomplete="off">
            <?php 
          		if($aps_periksa == '1'){
          		echo '
		            <option selected value="1">Laboratorium</option>
		            <option value="2">Radiologi</option>';
          		}
          		else{
          			echo '
		            <option value="1">Laboratorium</option>
		            <option selected value="2">Radiologi</option>';
          		}
           	?>
          </select>
        </div>

      <br><!--agar panjang cardbkok sesuai dg pertama-->

        <!--Tombol-->
        <center><button type="submit" id="edit_registrasi" accesskey="d" class="btn btn-success hug"> <i class="fa fa-edit">
        </i> Edit </button></center>


      <!--Mulai Card Ketiga-->
      </div>
    <!--Mulai Col SM Ketiga-->
    </div>
  <!--Akhir Row Pertama-->
  </div>
<!--Akhir Form-->
</form>
<!--Akhir Container-->
</div>


<script type="text/javascript">
//Fungsi untuk umur, langsung isi tanggal lahir otomatis
$("#umur").blur(function(){
    var umur = $("#umur").val();
    var tanggal_lahir = $("#tanggal_lahir").val();

 	if (umur != ''){

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
	else{
    $("#tanggal_lahir").val('');
	}
});
</script>


<script type="text/javascript">
//fungsi tanggal lahir, umur langsung hitung otomatis
$(document).ready(function() {

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
		if (agemonth < 0){
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
	      $("#gol_darah").focus();

	    }
	    else if (tanggal_lahir == ''){
	    
	    }
	    else{
	    $("#umur").val(umur);
	    $("#gol_darah").focus();
	    }
	}
	else{
		$("#umur").val('');
	}

});
</script>

<!--Proses Daftar Laboratorium/Radiologi (APS)-->
<script type="text/javascript">
$(document).on('click', '#edit_registrasi', function (e) {

  var no_rm = $("#no_rm").val();
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

  if (nama_lengkap == ""){
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
    $("#umur").focus();
  }
  else if (gol_darah == ""){
    alert("Kolom Golongan Darah Harus Disi");
    $("#gol_darah").focus();
  }
  else if (dokter == ""){
    alert("Kolom Dokter Jaga Harus Disi");
    $("#dokter").focus();
  }
  else{


  $.post("proses_edit_aps.php",{no_rm:no_rm,nama_lengkap:nama_lengkap,jenis_kelamin:jenis_kelamin,tanggal_lahir:tanggal_lahir,umur:umur,gol_darah:gol_darah,no_telepon:no_telepon,alamat:alamat,alergi:alergi,kondisi:kondisi,agama:agama,dokter:dokter,periksa:periksa},function(data){

    window.location.href="registrasi_laboratorium.php";

    $("#no_rm").val('');
    $("#nama_pasien").val('');
    $("#no_hp").val('');
    $("#tanggal_lahir").val('');
    $("#alamat").val('');
    $("#jenis_kelamin").val('');
    $("#penjamin").val('');
    $("#gol_darah").val('');
    $("#umur").val('');

    }); //End Proses

  } //End Else
      $("form").submit(function(){
        return false;
      });


}); //End Function
</script>

<!--footer-->
<?php include 'footer.php'; ?>