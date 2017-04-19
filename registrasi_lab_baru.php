<?php include 'session_login.php';
include 'header.php';
include 'navbar.php';
include_once'db.php';

$query_petugas_jaga= $db->query("SELECT nama_dokter FROM penetapan_petugas ");
$data_petugas_jaga = mysqli_fetch_array($query_petugas_jaga);
$dokter = $data_petugas_jaga['nama_dokter'];


?>


<!--Mulai Container-->
<div class="container">
<!--Judul Form-->
<h3>Registrasi Pasien Baru Laboratorium / Radiologi</h3><hr>

<table id="pasien_baru" class="display table-sm table-bordered" width="100%">
  <thead>
   <tr>
     <th style='background-color: #4CAF50; color: white'>No. RM Lama</th>
     <th style='background-color: #4CAF50; color: white'>Nama Lengkap</th>
     <th style='background-color: #4CAF50; color: white'>Jenis Kelamin</th>
     <th style='background-color: #4CAF50; color: white'>Alamat Sekarang</th>
     <th style='background-color: #4CAF50; color: white' >Tanggal Lahir</th>
     <th style='background-color: #4CAF50; color: white' >No. Telp </th>
   </tr>
 </thead>
</table>
<br><br>



<!--Mulai Form and Proses-->
<form role="form" action="proses_daftar_aps_baru.php" method="POST">

	<!--Mulai Row Pertama-->
	<div class="row">
		<!--Mulai Col SM Awal-->
		<div class="col-sm-4">
			<!--Mulai Card Blok-->
			<div class="card card-block">

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
				        <?php 
				        $query = $db->query("SELECT nama FROM user WHERE tipe = '1' ");
				        while ( $data = mysqli_fetch_array($query)) 
				        {
							 if ($dokter == $data['nama']) {
	               
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
				    <option value="1">Laboratorium</option>
				    <option value="2">Radiologi</option>
				  </select>
				</div>

			<!--Data Hidden-->
  			<input style="height: 20px;" type="hidden" class="form-control" id="token" name="token" value="Kosasih" autocomplete="off"> 

  			<input style="height: 20px;" type="hidden" class="form-control" id="no_rm_lama" name="no_rm_lama" readonly="">

			<br><!--agar panjang cardbkok sesuai dg pertama-->

  			<!--Tombol-->
  			<center><button type="submit" id="daftar_lab" accesskey="d" class="btn btn-success hug"> <i class="fa fa-plus"></i> <u>D</u>aftar </button></center>


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


<!-- DATATABLE AJAX PASIEN LAMA-->
<script type="text/javascript" language="javascript" >
      $(document).ready(function() {
        var dataTable = $('#pasien_baru').DataTable( {
          "processing": true,
          "serverSide": true,
          "ajax":{
            url :"cek_pasien_migrasi_aps.php", // json datasource
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


<!--footer-->
<?php include 'footer.php'; ?>