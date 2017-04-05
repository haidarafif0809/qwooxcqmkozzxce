<?php include_once 'session_login.php';
 
include 'header.php';
include 'navbar.php';
include 'db.php';
include 'sanitasi.php';


$pilih_akses_tombol = $db->query("SELECT status_hasil, foto_hasil, keterangan_hasil, simpan_hasil_radiologi FROM otoritas_radiologi WHERE id_otoritas = '$_SESSION[otoritas_id]' ");
$otoritas_tombol = mysqli_fetch_array($pilih_akses_tombol);

?>

<div style="padding-left: 5%; padding-right: 5%">
	<h3> FORM HASIL PEMERIKSAAN RADIOLOGI </h3><hr>

	<div class="row">


		<div class="col-xs-2">
	  		<label>No. REG :</label>
	  		<input style="height:15px" type="text" class="form-control"  id="no_reg" name="no_reg" value="" readonly="">   
		</div>

		<div class="col-xs-2">  
		  <label> No. RM | Pasien </label><br>
		  <input style="height:15px" type="text" class="form-control"  id="no_rm" name="no_rm" value="" readonly="" >    
		  <input style="height:15px" type="hidden" class="form-control"  id="nama_pasien" name="nama_pasien" value="" readonly="" > 
		</div>

		<div class="col-xs-2">
			<label>Jenis Pasien</label>
			<input style="height:15px" type="text" class="form-control"  id="jenis_pasien" name="jenis_pasien" value="" readonly="">   
		</div>

		<div class="col-xs-2">
			<label>Petugas Radiologi</label>
			<input style="height:15px" type="text" class="form-control"  id="petugas_radiologi" name="petugas_radiologi" value="<?php echo $_SESSION['nama'] ?>" readonly="">   
		</div>

		<div class="form-group col-xs-2" style="display: none">
		    <label for="email">Penjamin:</label>
		    <select class="form-control chosen" id="penjamin" name="penjamin" required="">
		      <?php    
		     
		      $query = $db->query("SELECT nama FROM penjamin");
		      while ( $icd = mysqli_fetch_array($query))
		      {
		      echo "<option value='".$icd['nama']."'>".$icd['nama']."</option>";
		      }
		      ?>
		    </select>
		</div>

    <div class="col-xs-2">
       <label> Dokter Pengirim </label><br>
          
          <select name="dokter" id="dokter" class="form-control chosen" required="" >
          <option value="">--SILAKAN PILIH--</option>
            <?php 
                  //untuk menampilkan semua data pada tabel pelanggan dalam DB
              $query01 = $db->query("SELECT nama,id FROM user WHERE tipe = '1'");

              //untuk menyimpan data sementara yang ada pada $query
              while($data01 = mysqli_fetch_array($query01))
              {    
                  echo "<option value='".$data01['id'] ."'>".$data01['nama'] ."</option>";
              
              }
             ?>
           </select>
     </div>

    <div class="col-xs-2">
       <label> Dokter Sp. Radiologi </label><br>
                
          <select name="dokter_radiologi" id="dokter_radiologi" class="form-control chosen" required="" >
          <option value="">--SILAKAN PILIH--</option>
            <?php 
                  //untuk menampilkan semua data pada tabel pelanggan dalam DB
              $query01 = $db->query("SELECT nama,id FROM user WHERE tipe = '1'");

              //untuk menyimpan data sementara yang ada pada $query
              while($data01 = mysqli_fetch_array($query01))
              {    
                  echo "<option value='".$data01['id'] ."'>".$data01['nama'] ."</option>";
              
              }
             ?>
           </select>
     </div>


		<div class="col-xs-2" style="display: none;">
			<input style="height:15px" type="text" class="form-control"  id="data_foto" name="data_foto" value="" >   
		</div>

<div class="col-xs-12" >
      <button type="button" class="btn btn-warning" id="cari_pasien" data-toggle="modal" data-target="#modal_pasien"><i class="fa fa-user"></i> Pasien R. Jalan (Alt + P)</button>

      <button type="button" class="btn btn-primary" id="cari_pasien" data-toggle="modal" data-target="#modal_pasien"><i class="fa fa-user"></i> Pasien UGD (Alt + P)</button>


<?php if ($otoritas_tombol['simpan_hasil_radiologi'] > 0): ?>
        <button type="button" class="btn btn-success" id="simpan_pemeriksaan" style="display: none"><i class="fa fa-save"></i> Simpan Pemeriksaan</button>
<?php endif ?>


      <a href='cetak_hasil_radiologi.php' id="cetak_radiologi" style="display: none;" class="btn btn-purple" target="blank"> <i class="fa fa-print"></i> Cetak Radiologi  </a>          

      <button type="button" class="btn btn-primary" id="transaksi_baru" style="display: none"><i class="fa fa-refresh"></i> Transaksi Baru</button>
      <br>


      <div class="alert alert-success" id="alert_berhasil" style="display:none">
          <strong>Sukses!</strong> Simpan Pemeriksaan Berhasil
      </div>
</div>



	</div><!-- / ROW -->

<!-- Modal upload foto-->
<div id="modal_upload_foto" class="modal fade" role="dialog">
  <div class="modal-dialog">

    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
               
              <h4 class="modal-title">Upload Foto</h4>
      </div>
      <div class="modal-body">
		
		<div class="col-xs-12">
			<form id="imageform" method="post" enctype="multipart/form-data" action='ajax_upload_foto_radiologi.php'>
				<input type="file" name="photoimg" id="photoimg"/>
				<input type="hidden" name="reg" id="reg"/>
				<input type="hidden" name="kode_barang" id="kode_barang"/>
        
			</form>
    

    </div>
		<div class="col-xs-12">
      <span id='preview'></span>
      <span id='loading-id'></span>
		</div>		

      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-warning" id="save"> <i class='fa fa-save'></i> Simpan</button>
        <button type="button" accesskey="e" class="btn btn-danger" data-dismiss="modal"><i class='fa fa-close'></i> Close</button>
      </div>
    </div>

  </div>
</div>

<!-- Modal upload foto-->

<!-- Modal cari registrasi pasien-->
<div id="modal_pasien" class="modal fade" role="dialog">
  <div class="modal-dialog">

    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
               
              <h4 class="modal-title">Pasien Radiologi</h4>
      </div>
      <div class="modal-body">

            <center>
            <table id="tabel_cari_pasien" class="table table-bordered table-sm">
                  <thead> <!-- untuk memberikan nama pada kolom tabel -->
                  
                      <th>No. REG</th>
                      <th>No. RM</th>
                      <th>Nama Pasien</th>
                      <th>Jenis Pasien</th>
                      <th>Tanggal</th>
                      <th>Keterangan</th>
                  
                  </thead> <!-- tag penutup tabel -->                
            </table>
            </center>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-warning" id="btnRefreshPasien"> <i class='fa fa-refresh'></i> Refresh Pasien</button>
        <button type="button" accesskey="e" class="btn btn-danger" data-dismiss="modal"><i class='fa fa-close'></i> Close</button>
      </div>
    </div>

  </div>
</div>

<!-- Modal cari registrasi pasien-->


<!-- Modal nput Data Hasil Expertise Dokter Spesialis Radiologi -->
<div id="modal_tampil_ket" class="modal fade" role="dialog">
  <div class="modal-dialog">

    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
               
              <h5 class="modal-title">Hasil Expertise Dokter Spesialis Radiologi</h5>
      </div>
      <div class="modal-body">
    

              <div class="form-group">
              <label for="keterangan_tampil">Hasil Baca Radiografer</label><br>

              <span id="span_ket" ></span>
              <textarea class="form-control edit-keterangan" style="height: 300px; display: none" id="keterangan_tampil" name="keterangan_tampil" autocomplete="off" >                
              </textarea>

              <input type="hidden" name="no_reg_tampil" id="no_reg_tampil" >
              <input type="hidden" name="kode_tampil" id="kode_tampil" >
              </div>

      </div>
      <h6 style="text-align: left ; color: red"><i> <b>* Klik 2x Pada Kolom Jika Ingin Mengedit.</b></i></h6>

      <div class="modal-footer">
        <button type="button" class="btn btn-warning" id="btnSimpanUpdate"> <i class='fa fa-save'></i> Simpan</button>
        <button type="button" accesskey="e" class="btn btn-danger" data-dismiss="modal"><i class='fa fa-close'></i> Close</button>
      </div>
    </div>

  </div>
</div>
<!-- Modal nput Data Hasil Expertise Dokter Spesialis Radiologi-->


<!-- Modal nput Data Hasil Expertise Dokter Spesialis Radiologi -->
<div id="modal_input_ket" class="modal fade" role="dialog">
  <div class="modal-dialog">

    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
               
              <h5 class="modal-title">Input Data Hasil Expertise Dokter Spesialis Radiologi</h5>
      </div>
      <div class="modal-body">
    
          <form class="form" method="post">

              <div class="form-group">
              <label for="keterangan">Hasil Baca Radiografer</label><br>
              <textarea class="form-control" style="height: 300px" id="keterangan" name="keterangan" autocomplete="off" ></textarea>

              <input type="text" name="cek_ket">

              <input type="hidden" name="no_reg_ket" id="no_reg_ket" >
              <input type="hidden" name="kode_ket" id="kode_ket" >
              </div>
            
          </form>

      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-warning" id="btnSimpanKet"> <i class='fa fa-save'></i> Simpan</button>
        <button type="button" accesskey="e" class="btn btn-danger" data-dismiss="modal"><i class='fa fa-close'></i> Close</button>
      </div>
    </div>

  </div>
</div>
<!-- Modal nput Data Hasil Expertise Dokter Spesialis Radiologi-->

<style>
tr:nth-child(even){background-color: #f2f2f2}
</style>

<div class="col-sm-5">
	            <span id="span_tbs">            
                
                  <div class="table-responsive">
                    <table id="tabel_tbs_radiologi" class="table table-bordered table-sm">
                          <thead> <!-- untuk memberikan nama pada kolom tabel -->
                              
                              <th style='background-color: #4CAF50; color:white'> No.  </th>
                              <th style='background-color: #4CAF50; color:white'> Kode  </th>
                              <th style='background-color: #4CAF50; color:white'> Nama </th>
                              <th style='background-color: #4CAF50; color:white'> Dokter Pengirim </th>

                          <?php if ($otoritas_tombol['status_hasil']): ?>
                            <th style='background-color: #4CAF50; color:white'> Status Periksa </th>
                          <?php endif ?>

                          <?php if ($otoritas_tombol['foto_hasil']): ?>
                             <th style='background-color: #4CAF50; color:white'> Foto </th>
                          <?php endif ?>

                          <?php if ($otoritas_tombol['keterangan_hasil']): ?>
                              <th style='background-color: #4CAF50; color:white'> Keterangan </th>
                          <?php endif ?>

                          </thead> <!-- tag penutup tabel -->
                    </table>
                  </div>

                <?php if ($otoritas_tombol['status_hasil'] > 0): ?>
                  <h6 style="text-align: left ; color: red"><i><b> * Klik 2x Pada Kolom Status Periksa Untuk Merubah Status. </b></i></h6>
                <?php endif ?>

                </span>  
                
</div>

<!-- STYLE UNUTK PENUNJANG FOTO -->
<style>
img {
    border: 1px solid #ddd;
    border-radius: 8px;
    padding: 5px;
}

img:hover {
    box-shadow: 0 0 2px 1px rgba(0, 140, 186, 0.5);
}
</style>
<!-- STYLE UNUTK PENUNJANG FOTO -->

<div class="col-sm-7 tampil_col" style="display: none">
<br><br><br>
    <div class="row">
      <span id="span_foto"> </span>

    </div>
</div>

</div><!-- / CONTAINER -->

<script type="text/javascript">
	$(".chosen").chosen({no_results_text: "Maaf, Data Tidak Ada!",search_contains:true});
</script>

<script type="text/javascript" language="javascript" >
   $(document).ready(function() {
        var dataTable = $('#tabel_cari_pasien').DataTable( {
          "processing": true,
          "serverSide": true,
          "ajax":{
            url :"pasien_rujuk_radiologi.php", // json datasource
            type: "post",  // method  , by default get
            error: function(){  // error handling
              $(".employee-grid-error").html("");
              $("#tabel_cari_pasien").append('<tbody class="employee-grid-error"><tr><th colspan="3">Data Tidak Ditemukan.. !!</th></tr></tbody>');
              $("#employee-grid_processing").css("display","none");
              
            }
          },

          "fnCreatedRow": function( nRow, aData, iDataIndex ) {

              $(nRow).attr('class', "pilih-reg");
              $(nRow).attr('no_reg', aData[0]);
              $(nRow).attr('no_rm', aData[1]+" | "+aData[2]+"");
              $(nRow).attr('nama_pasien', aData[2]);
              $(nRow).attr('penjamin', aData[6]);
              $(nRow).attr('dokter', aData[7]);
              $(nRow).attr('jenis_pasien', aData[3]);
              $(nRow).attr('dokter_radiologi', aData[8]);



          }

        });    
     
  });
 
 </script>

 <script type="text/javascript">
 	$(document).ready(function() {
    // START DATATABLE AJAX START DATATABLE AJAX START DATATABLE AJAX START DATATABLE AJAX START DATATABLE AJAX START DATATABLE AJAX
      $('#tabel_tbs_radiologi').DataTable().destroy();
            var dataTable = $('#tabel_tbs_radiologi').DataTable( {
            "processing": true,
            "serverSide": true,
            "info":     true,
            "language": { "emptyTable":     "Tidak Ada Data" },
            "ajax":{
              url :"data_input_radiologi.php", // json datasource
                              "data": function ( d ) {
                                d.no_reg = $("#no_reg").val();
                                // d.custom = $('#myInput').val();
                                // etc
                              },
                              type: "post",  // method  , by default get
              error: function(){  // error handling
                $(".tbody").html("");
                $("#tabel_tbs_radiologi").append('<tbody class="tbody"><tr><th colspan="3"></th></tr></tbody>');
                $("#tableuser_processing").css("display","none");
                
              }
            }   

      });
        
        $("#span_tbs").show()
  });
 </script>

  <script type="text/javascript">
   $(document).on('click', '.pilih-reg', function (e) {               
            document.getElementById("no_reg").value = $(this).attr('no_reg');
            document.getElementById("no_rm").value = $(this).attr('no_rm');
            document.getElementById("nama_pasien").value = $(this).attr('nama_pasien');
            document.getElementById("jenis_pasien").value = $(this).attr('jenis_pasien');

            document.getElementById("penjamin").value = $(this).attr('penjamin');
            $("#penjamin").trigger('chosen:updated');

            document.getElementById("dokter").value = $(this).attr('dokter');
            $("#dokter").trigger('chosen:updated');

            document.getElementById("dokter_radiologi").value = $(this).attr('dokter_radiologi');
            $("#dokter_radiologi").trigger('chosen:updated');

            $('#modal_pasien').modal('hide');
            $('.tampil_col').hide();


    // START DATATABLE AJAX START DATATABLE AJAX START DATATABLE AJAX START DATATABLE AJAX START DATATABLE AJAX START DATATABLE AJAX
      $('#tabel_tbs_radiologi').DataTable().destroy();
            var dataTable = $('#tabel_tbs_radiologi').DataTable( {
            "processing": true,
            "serverSide": true,
            "info":     true,
            "language": { "emptyTable":     "Tidak Ada Data" },
            "ajax":{
              url :"data_input_radiologi.php", // json datasource
                              "data": function ( d ) {
                                d.no_reg = $("#no_reg").val();
                                // d.custom = $('#myInput').val();
                                // etc
                              },
                              type: "post",  // method  , by default get
              error: function(){  // error handling
                $(".tbody").html("");
                $("#tabel_tbs_radiologi").append('<tbody class="tbody"><tr><th colspan="3"></th></tr></tbody>');
                $("#tableuser_processing").css("display","none");
                
              }
            }   

      });
        
        $("#span_tbs").show()
        $("#simpan_pemeriksaan").show()

// END DATATABLE AJAX END DATATABLE AJAX END DATATABLE AJAX END DATATABLE AJAX END DATATABLE AJAX END DATATABLE AJAX



});
 </script>

<!--TOMBOL BROWSE DI TABEL U/ UPLOAD FOTO -->

		<script type="text/javascript" >
		$(document).ready(function() { 

			$(document).on('click','.btn-upload',function(){				

			var kode = $(this).attr("data-kode");
			var reg = $(this).attr("data-reg");

			$("#modal_upload_foto").modal('show');

      $("#preview").show();
			$("#kode_barang").val(kode);
			$("#reg").val(reg);


			});
			
		});
		</script>

<!--TOMBOL BROWSE DI TABEL U/ UPLOAD FOTO -->

<!--FUNCTION UNTUK TAMBAH DAN LIHAT FOTO -->

		<script type="text/javascript" src="jquery.form.js"></script>

		<script type="text/javascript">

			function tambah(image){
        $("#loading-id").html('');
				$("#preview").prepend(image);
				var preview = $("#preview").text();
				$("#data_foto").val(preview);
			}
		</script>


		<script type="text/javascript" >
			$(document).ready(function() { 
				$('#photoimg').change(function() {
          $("#loading-id").html('Mohon Tunggu...');

					$("#imageform").ajaxForm(function(data){
						tambah(data);
					}).submit();

				});
			}); 
		</script>

<!--FUNCTION UNTUK TAMBAH DAN LIHAT FOTO -->

<!--UNTUK HAPUS FOTO -->

		<script type="text/javascript">
			$(document).on('click','.hapus',function(){
        var gambar = $(this).attr('src');
        var nama = $(this).attr('data-nama');
        var kode = $(this).attr('data-kode');

        var pesan_alert = confirm("Anda Yakin Ingin Menghapus Foto Ini ?");
        if (pesan_alert == true) {
        
        $.post("hapus_foto_radiologi.php",{hapus:gambar, kode:kode, nama:nama},function(data){

        });

        $("#span-hapus").remove();



    $('#tabel_tbs_radiologi').DataTable().destroy();
            var dataTable = $('#tabel_tbs_radiologi').DataTable( {
            "processing": true,
            "serverSide": true,
            "info":     true,
            "language": { "emptyTable":     "Tidak Ada Data" },
            "ajax":{
              url :"data_input_radiologi.php", // json datasource
                "data": function ( d ) {
                d.no_reg = $("#no_reg").val();
                                // d.custom = $('#myInput').val();
                                // etc
                },
                type: "post",  // method  , by default get
              error: function(){  // error handling
                $(".tbody").html("");
                $("#tabel_tbs_radiologi").append('<tbody class="tbody"><tr><th colspan="3"></th></tr></tbody>');
                $("#tableuser_processing").css("display","none");
                
              }
            }   

      });
        
        $("#span_tbs").show() 

                return false;   
	   }
    else{

    }
						 
			});
		</script>

<!--UNTUK HAPUS FOTO -->

<!--SIMPAN FOTO -->
		<script type="text/javascript" >
		$(document).ready(function() { 

			$(document).on('click','#save',function(){

			var foto = $("#photoimg").val();

			if (foto == "") {
				alert ("Silakan Masukan Foto !")
			}
			else{				

			

			var no_reg = $("#reg").val();
			var kode = $("#kode_barang").val();
			var data_foto = $("#data_foto").val();

			$.post("upload_foto_radiologi.php",{no_reg:no_reg, kode:kode, data_foto:data_foto},function(data){
			});

			$("#modal_upload_foto").modal('hide');		
			$('.hapus').each(function(index, value) { 				
			});
      $("#photoimg").val('');
      $("#data_foto").val('');
			$("#preview").hide();
      $("#preview").text('');
			

			

		$('#tabel_tbs_radiologi').DataTable().destroy();
            var dataTable = $('#tabel_tbs_radiologi').DataTable( {
            "processing": true,
            "serverSide": true,
            "info":     true,
            "language": { "emptyTable":     "Tidak Ada Data" },
            "ajax":{
              url :"data_input_radiologi.php", // json datasource
                "data": function ( d ) {
                  d.no_reg = $("#no_reg").val();
                                // d.custom = $('#myInput').val();
                                // etc
                },
                type: "post",  // method  , by default get
              error: function(){  // error handling
                $(".tbody").html("");
                $("#tabel_tbs_radiologi").append('<tbody class="tbody"><tr><th colspan="3"></th></tr></tbody>');
                $("#tableuser_processing").css("display","none");
                
              }
            }   

      });
        
        $("#span_tbs").show()
			}


		


			});

				return false;
			
		});
		</script>

<!--SIMPAN FOTO -->

<!--MELIHAT FOTO YANG TERSIMPAN -->
<script type="text/javascript">
$(document).ready(function() { 
	$(document).on('click','.tampil_foto',function(){
		var no_reg = $(this).attr('data-reg');
    var kode = $(this).attr('data-kode');
    var nama = $(this).attr('data-nama');

    $(".tampil_col").show();
		$.post("tampil_foto.php",{no_reg:no_reg, kode:kode},function(data){

        var jumlah_foto = JSON.parse(data);

        $("#span-hapus").remove();
//PERULANGAN JIKA ADA LEBIH DARI 1 (SATU) DATA YANG DIAMBIL (SEPERTI WHILE)
        for (var foto = 0; foto < jumlah_foto.length; foto++) {
        var nama_foto = jumlah_foto[foto];
        if (nama_foto != "") {

//MENAMPILKAN FOTO

          
          $("#span_foto").prepend('<span id="span-hapus"> <img src="save_picture/'+nama_foto+'" data-zoom-image="save_picture/'+nama_foto+'" class="zoom_foto" id="id-'+kode+'-'+nama_foto+'" height="250px" width="350px"> '+' <button class="btn btn-danger btn-floating hapus" src="save_picture/'+nama_foto+'" data-kode="'+kode+'" data-nama="'+nama+'" data-reg="'+no_reg+'" style="font-size:15px"><i class="fa fa-trash"></i></button> </span>');        

          }

        }



//PERULANGAN JIKA ADA LEBIH DARI 1 (SATU) DATA YANG DIAMBIL (SEPERTI WHILE)

//UNTUK MEMPERBESAR FOTO 
            $('.zoom_foto').elevateZoom({
            zoomType: "inner",
            cursor: "crosshair",
            zoomWindowFadeIn: 500,
            zoomWindowFadeOut: 750
            }); 
//UNTUK MEMPERBESAR FOTO 

		});


	});
});
</script>
<!--MELIHAT FOTO YANG TERSIMPAN -->



<!-- EDIT STATUS PERIKSA -->
<script type="text/javascript">
                                 
$(document).on('dblclick','.edit-status',function(e){

  var id = $(this).attr("data-id");

  $("#text-status-"+id+"").hide();
  $("#select-status-"+id+"").show();

});

$(document).on('change','.select-status',function(e){

  var id = $(this).attr("data-id");
  var no_reg = $(this).attr("data-reg");
  var select_status = $(this).val();
  var foto = $(this).attr("data-foto");
  var nama_pemeriksaan = $(this).attr("data-nama");
  var keterangan = $(this).attr("data-ket");
  var status_lama = $("#text-status-"+id+"").text();

//LOGIKA UNUTK MENAMPILKAN PERINGATN JIKA FOTO TIDAK DIISI

if (foto == "" && keterangan == "") {

    var pesan_alert = confirm("Pemeriksaan '"+nama_pemeriksaan+"' Tanpa Foto dan Keterangan, Tetap Lanjutkan ?");
    if (pesan_alert == true) {

        $.post("update_status_periksa_radiologi.php",{id:id, no_reg:no_reg, select_status:select_status},function(data){
          if (select_status == 1) {
            select_status = 'Diperiksa';
          }
          else{
            select_status = 'Tidak Diperiksa';
          }
          $("#text-status-"+id+"").show();
          $("#text-status-"+id+"").text(select_status);
          $("#select-status-"+id+"").hide();

        });

    }

    else{

          $("#select-status-"+id+"").val(status_lama);
          $("#text-status"+id+"").text(status_lama);
          $("#text-status-"+id+"").show();
          $("#select-status-"+id+"").hide();
    }

} // END (foto == "" AND keterangan == "") {

else if (foto == "") {

    var pesan_alert = confirm("Pemeriksaan '"+nama_pemeriksaan+"' Tanpa Foto, Tetap Lanjutkan ?");
    if (pesan_alert == true) {

        $.post("update_status_periksa_radiologi.php",{id:id, no_reg:no_reg, select_status:select_status},function(data){
          if (select_status == 1) {
            select_status = 'Diperiksa';
          }
          else{
            select_status = 'Tidak Diperiksa';
          }
          $("#text-status-"+id+"").show();
          $("#text-status-"+id+"").text(select_status);
          $("#select-status-"+id+"").hide();

        });

    }

    else{

          $("#select-status-"+id+"").val(status_lama);
          $("#text-status"+id+"").text(status_lama);
          $("#text-status-"+id+"").show();
          $("#select-status-"+id+"").hide();
    }

} // END (foto == "" || foto IS NULL) {

else if (keterangan == "") {

    var pesan_alert = confirm("Pemeriksaan '"+nama_pemeriksaan+"' Tanpa Keterangan, Tetap Lanjutkan ?");
    if (pesan_alert == true) {

        $.post("update_status_periksa_radiologi.php",{id:id, no_reg:no_reg, select_status:select_status},function(data){
          if (select_status == 1) {
            select_status = 'Diperiksa';
          }
          else{
            select_status = 'Tidak Diperiksa';
          }
          $("#text-status-"+id+"").show();
          $("#text-status-"+id+"").text(select_status);
          $("#select-status-"+id+"").hide();

        });

    }

    else{

          $("#select-status-"+id+"").val(status_lama);
          $("#text-status"+id+"").text(status_lama);
          $("#text-status-"+id+"").show();
          $("#select-status-"+id+"").hide();
    }

} // END (foto == "" || keterngan IS NULL) {

else{
        $.post("update_status_periksa_radiologi.php",{id:id, no_reg:no_reg, select_status:select_status},function(data){
          if (select_status == 1) {
            select_status = 'Diperiksa';
          }
          else{
            select_status = 'Tidak Diperiksa';
          }
          $("#text-status-"+id+"").show();
          $("#text-status-"+id+"").text(select_status);
          $("#select-status-"+id+"").hide();

        });
}


//LOGIKA UNUTK MENAMPILKAN PERINGATN JIKA FOTO TIDAK DIISI

});

</script>
<!-- /EDIT STATUS PERIKSA -->


<script type="text/javascript">
  $(document).ready(function(){
    $(document).on('click','#btnSimpanKet',function(){
      var no_reg_ket = $("#no_reg_ket").val();
      var kode_ket = $("#kode_ket").val();
      var keterangan = CKEDITOR.instances.keterangan.getData();

      console.log(keterangan);

      $("#modal_input_ket").modal('hide');

      $.post("input_keterangan_hasil_radiologi.php",{keterangan:keterangan, no_reg_ket:no_reg_ket, kode_ket:kode_ket},function(data){

          $('#tabel_tbs_radiologi').DataTable().destroy();
              var dataTable = $('#tabel_tbs_radiologi').DataTable( {
              "processing": true,
              "serverSide": true,
              "info":     true,
              "language": { "emptyTable":     "Tidak Ada Data" },
              "ajax":{
                url :"data_input_radiologi.php", // json datasource
                "data": function ( d ) {
                d.no_reg = $("#no_reg").val();
                // d.custom = $('#myInput').val();
                // // etc                
                },
                type: "post",  // method  , by default get
                error: function(){  // error handling
                  $(".tbody").html("");
                  $("#tabel_tbs_radiologi").append('<tbody class="tbody"><tr><th colspan="3"></th></tr></tbody>');
                  $("#tableuser_processing").css("display","none");
                  
                }
              }   

        });
        
        $("#span_tbs").show()

      });
    });
  });
</script>


<!-- PERINTAH SAAT KLIK TOMBOL REFRESH PASIEN -->
<script type="text/javascript">
    $(document).on('click','#btnRefreshPasien',function(e){

       $('#tabel_cari_pasien').DataTable().destroy();
        var dataTable = $('#tabel_cari_pasien').DataTable( {
          "processing": true,
          "serverSide": true,
          "ajax":{
            url :"pasien_rujuk_radiologi.php", // json datasource
            type: "post",  // method  , by default get
            error: function(){  // error handling
              $(".employee-grid-error").html("");
              $("#tabel_cari_pasien").append('<tbody class="employee-grid-error"><tr><th colspan="3">Data Tidak Ditemukan.. !!</th></tr></tbody>');
              $("#employee-grid_processing").css("display","none");
              
            }
          },

          "fnCreatedRow": function( nRow, aData, iDataIndex ) {

              $(nRow).attr('class', "pilih-reg");
              $(nRow).attr('no_reg', aData[0]);
              $(nRow).attr('no_rm', aData[1]+" | "+aData[2]+"");
              $(nRow).attr('nama_pasien', aData[2]);
              $(nRow).attr('penjamin', aData[6]);
              $(nRow).attr('dokter', aData[7]);
              $(nRow).attr('jenis_pasien', aData[3]);
              $(nRow).attr('dokter_radiologi', aData[8]);


          }

        }); 

    }); 
</script>
<!-- PERINTAH SAAT KLIK TOMBOL REFRESH PASIEN -->

<!-- PERINTAH SAAT KLIK TOMBOL SIMPAN PEMERIKSAAN -->
<script type="text/javascript">
$(document).ready(function() {

    $(document).on('click','#simpan_pemeriksaan',function(e){

      var no_reg = $("#no_reg").val();
      var nama_pasien = $("#nama_pasien").val();
      var dokter_radiologi = $("#dokter_radiologi").val();

      if (dokter_radiologi == "") {
        alert("Silakan Pilih Dokter Spesialis Radiologi");
        $("#dokter_radiologi").trigger('chosen:open');
      }
      else{
        $.post("cek_satus_pemriksaan.php",{no_reg:no_reg},function(data){

                if (data == 0) {
                  alert("Anda Belum Melakukan Pemeriksaan Pada Pasien '"+nama_pasien+"'. Silakan Cek Kembali Status Pemeriksaan !");
                }
                else{

                  $.post("simpan_pemeriksaan_radiologi.php",{no_reg:no_reg, dokter_radiologi:dokter_radiologi},function(data){
                     $('#tabel_tbs_radiologi').DataTable().clear();
                     $("#span_tbs").hide()
                     $("#alert_berhasil").show()
                     $("#transaksi_baru").show()
                     $("#cetak_radiologi").show()
                     $("#simpan_pemeriksaan").hide('fast')
                  });

                }

        });

        $("#cetak_radiologi").attr('href', 'cetak_hasil_radiologi.php?no_reg='+no_reg+'');
        $(".tampil_col").hide('fast');
      }

      
    });

});
</script>
<!-- PERINTAH SAAT KLIK TOMBOL SIMPAN PEMERIKSAAN -->

<!-- PERINTAH SAAT KLIK TOMBOL TRANSAKSI BARU -->
<script type="text/javascript">

  $(document).ready(function(){
    $(document).on('click','#transaksi_baru',function(e){


        $("#no_reg").val('');
        $("#no_rm").val('');
        $("#nama_pasien").val('');
        $("#jenis_pasien").val('');
        $("#dokter_radiologi").val('');
        $("#dokter_radiologi").trigger('chosen:updated');
        $("#alert_berhasil").hide('fast');
        $("#transaksi_baru").hide('fast');
        $("#cetak_radiologi").hide('fast');
        $("#tampil_col").hide();

       $('#tabel_cari_pasien').DataTable().destroy();
        var dataTable = $('#tabel_cari_pasien').DataTable( {
          "processing": true,
          "serverSide": true,
          "ajax":{
            url :"pasien_rujuk_radiologi.php", // json datasource
            type: "post",  // method  , by default get
            error: function(){  // error handling
              $(".employee-grid-error").html("");
              $("#tabel_cari_pasien").append('<tbody class="employee-grid-error"><tr><th colspan="3">Data Tidak Ditemukan.. !!</th></tr></tbody>');
              $("#employee-grid_processing").css("display","none");
              
            }
          },

          "fnCreatedRow": function( nRow, aData, iDataIndex ) {

              $(nRow).attr('class', "pilih-reg");
              $(nRow).attr('no_reg', aData[0]);
              $(nRow).attr('no_rm', aData[1]+" | "+aData[2]+"");
              $(nRow).attr('nama_pasien', aData[2]);
              $(nRow).attr('penjamin', aData[6]);
              $(nRow).attr('dokter', aData[7]);
              $(nRow).attr('jenis_pasien', aData[3]);
              $(nRow).attr('dokter_radiologi', aData[8]);



          }

        }); 




        $('#tabel_tbs_radiologi').DataTable().destroy();
              var dataTable = $('#tabel_tbs_radiologi').DataTable( {
              "processing": true,
              "serverSide": true,
              "info":     true,
              "language": { "emptyTable":     "Tidak Ada Data" },
              "ajax":{
                url :"data_input_radiologi.php", // json datasource
                "data": function ( d ) {
                d.no_reg = $("#no_reg").val();
                // d.custom = $('#myInput').val();
                // // etc                
                },
                type: "post",  // method  , by default get
                error: function(){  // error handling
                  $(".tbody").html("");
                  $("#tabel_tbs_radiologi").append('<tbody class="tbody"><tr><th colspan="3"></th></tr></tbody>');
                  $("#tableuser_processing").css("display","none");
                  
                }
              }   

        });
        
        $("#span_tbs").show()

    });
  });

</script>
<!-- PERINTAH SAAT KLIK TOMBOL TRANSAKSI BARU -->

<script type="text/javascript">
$(document).on('click','.lihat_hasil_expertise',function(e){
  var keterangan = $(this).attr('data-ket');
  var reg = $(this).attr('data-reg');
  var kode = $(this).attr('data-kode');

  $("#modal_tampil_ket").modal('show');
  $("#span_ket").html(keterangan);
  $("#keterangan_tampil").val(keterangan);
  $("#no_reg_tampil").val(reg);
  $("#kode_tampil").val(kode);
});
</script>


<script type="text/javascript">
                                 
$(document).on('dblclick','#span_ket',function(e){

  $("#span_ket").hide();
  $(".edit-keterangan").show();

  CKEDITOR.replace('keterangan_tampil');

});

$(document).on('click','#btnSimpanUpdate',function(e){

  var no_reg_ket = $("#no_reg_tampil").val();
  var kode_ket = $("#kode_tampil").val();
  var keterangan = CKEDITOR.instances.keterangan_tampil.getData();

          $("#span_ket").show();
          $("#span_ket").html(keterangan);

          CKEDITOR.instances.keterangan_tampil.destroy();
          
          $(".edit-keterangan").hide();

      $.post("input_keterangan_hasil_radiologi.php",{keterangan:keterangan, no_reg_ket:no_reg_ket, kode_ket:kode_ket},function(data){

          $('#tabel_tbs_radiologi').DataTable().destroy();
            var dataTable = $('#tabel_tbs_radiologi').DataTable( {
            "processing": true,
            "serverSide": true,
            "info":     true,
            "language": { "emptyTable":     "Tidak Ada Data" },
            "ajax":{
              url :"data_input_radiologi.php", // json datasource
                              "data": function ( d ) {
                                d.no_reg = $("#no_reg").val();
                                // d.custom = $('#myInput').val();
                                // etc
                              },
                              type: "post",  // method  , by default get
              error: function(){  // error handling
                $(".tbody").html("");
                $("#tabel_tbs_radiologi").append('<tbody class="tbody"><tr><th colspan="3"></th></tr></tbody>');
                $("#tableuser_processing").css("display","none");
                
              }
            }   

      });
        
        $("#span_tbs").show()

      });

});

</script>

<script type="text/javascript">
$(document).on('click','.tambah_ket',function(e){
  var no_reg = $(this).attr('data-reg');
  var kode = $(this).attr('data-kode');
      $("#modal_input_ket").modal('show');
      $("#no_reg_ket").val(no_reg);
      $("#kode_ket").val(kode);
});
</script>


<script type="text/javascript">
$(document).on('click','#cari_pasien',function(e){
      $("#alert_berhasil").hide('fast');
      $("#transaksi_baru").hide('fast');
      $("#cetak_radiologi").hide('fast');
});
</script>

<script>
// Replace the <textarea id="editor1"> with a CKEditor
// // instance, using default configuration.
  CKEDITOR.replace('keterangan');
</script>



<?php include 'footer.php'; ?>