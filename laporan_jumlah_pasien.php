<?php include 'session_login.php';

include 'header.php';
include 'navbar.php';
include 'sanitasi.php';
include 'db.php';

?>

<script>
 $(function(){
    $( "#dari_tanggal" ).datepicker({dateFormat: "yy-mm-dd"});
    $( "#sampai_tanggal" ).datepicker({dateFormat: "yy-mm-dd"});
 });
</script>

<style>
	tr:nth-child(even){
		background-color: #f2f2f2
	}
</style>

<div class="container">

	<h3> LAPORAN JUMLAH PASIEN </h3><hr>

		<form class="form-group" role="form">

			<div class="form-group col-sm-2">
				<input type="text" name="dari_tanggal" id="dari_tanggal" class="form-control" placeholder="Dari Tanggal" required="">
		    </div>

		    <div class="form-group col-sm-2">
		   		<input type="text" name="sampai_tanggal" id="sampai_tanggal" class="form-control" placeholder="Sampai Tanggal" value="<?php echo date("Y-m-d"); ?>" required="">
		    </div>

		    <button type="submit" name="submit" id="submit" class="btn btn-primary" ><i class="fa fa-eye"> </i> Tampil </button>

		</form>

	<div class="card card-block" id="div_pasien" style="display: none">

	<div class="table-responsive"><!--membuat agar ada garis pada tabel disetiap kolom-->
	<h4>Laporan Jumlah Pasien R. Jalan</h4>
		<table id="tabel_pasien" class="table table-bordered table-sm">
			<thead>
				<th style="background-color: #4CAF50; color: white;"> Nomor Faktur </th>	
				<th style="background-color: #4CAF50; color: white;"> Nama Pasien </th>
				<th style="background-color: #4CAF50; color: white;"> Penjamin </th>	
				<th style="background-color: #4CAF50; color: white;"> Tanggal </th>
				<th style="background-color: #4CAF50; color: white;"> Jumlah Periksa </th>	

			</thead>
		</table>
	</div> <!--/ RESPONSIVE-->

	</div><!-- / CARD-BLOCK -->

	<div class="card card-block" id="div_pasien_ranap" style="display: none">

	<div class="table-responsive"><!--membuat agar ada garis pada tabel disetiap kolom-->
	<h4>Laporan Jumlah Pasien R. Inap</h4>
		<table id="tabel_pasien_ranap" class="table table-bordered table-sm">
			<thead>
				<th style="background-color: #4CAF50; color: white;"> Nomor Faktur </th>	
				<th style="background-color: #4CAF50; color: white;"> Nama Pasien </th>
				<th style="background-color: #4CAF50; color: white;"> Penjamin </th>	
				<th style="background-color: #4CAF50; color: white;"> Tanggal Masuk </th>
				<th style="background-color: #4CAF50; color: white;"> Tanggal Keluar </th>		
				<th style="background-color: #4CAF50; color: white;"> Jumlah Periksa </th>						
			</thead>
		</table>
	</div> <!--/ RESPONSIVE-->

	</div><!-- / CARD-BLOCK -->


	<span id="span_button" style="display: none;">
		<a href="cetak_laporan_jumlah_pasien.php" target="blank" id="cetak_lap"  class="btn btn-success"><i class="fa fa-print"> </i> Cetak Laporan</a>
		<a href="export_laporan_jumlah_pasien.php" target="blank" id="export_lap"  class="btn btn-primary"><i class="fa fa-download"> </i> Download Laporan </a>
	</span>

</div> <!-- / CONTAINER-->

		
<script type="text/javascript">
	
	$(document).on('click','#submit', function(){
		
		var dari_tanggal = $("#dari_tanggal").val();
		var sampai_tanggal = $("#sampai_tanggal").val();
			if (dari_tanggal == '') {
				alert("Silakan Isi Kolom Tanggal Terlebih Dahulu.");
				$("#dari_tanggal").focus();
			}
			else if (sampai_tanggal == '') {
				alert("silakan Isi Kolom Tanggal Terlebih Dahulu.");
				$("#sampai_tanggal").focus();
			}
			else {

				//DRAW PASIEN R. JALAN

				$('#tabel_pasien').DataTable().destroy();

		          var dataTable = $('#tabel_pasien').DataTable( {
	                "processing": true,
	                "serverSide": true,
	                "info":     true,
	                "language": {
	              	"emptyTable":   "My Custom Message On Empty Table"
	          		},

	                "ajax":{
	                  url :"proses_laporan_jumlah_pasien.php", // json datasource
	                   "data": function ( d ) {
	                      d.dari_tanggal = $("#dari_tanggal").val();
	                      d.sampai_tanggal = $("#sampai_tanggal").val();
	                      // d.custom = $('#myInput').val();
	                      // etc
	                  },
	                      type: "post",  // method  , by default get
	                  error: function(){  // error handling
	                    $(".tbody").html("");
	                    $("#tabel_pasien").append('<tbody class="tbody"><tr><th colspan="3"></th></tr></tbody>');
	                    $("#tabel_pasien_processing").css("display","none");
	                    
	                  }
	                }
	          
	              });

	            //DRAW PASIEN R. INAP	            
				$('#tabel_pasien_ranap').DataTable().destroy();
			  	var dataTable = $('#tabel_pasien_ranap').DataTable({
	                "processing": true,
	                "serverSide": true,
	                "info":     true,
	                "language": {
	              	"emptyTable":   "My Custom Message On Empty Table"
	          	},
	                "ajax":{
	                  url :"proses_laporan_jumlah_pasien_ranap.php", // json datasource
	                   "data": function ( d ) {
	                      d.dari_tanggal = $("#dari_tanggal").val();
	                      d.sampai_tanggal = $("#sampai_tanggal").val();
	                      // d.custom = $('#myInput').val();
	                      // etc
	                  },
	                  type: "post",  // method  , by default get
	                  error: function(){  // error handling
	                    $(".tbody").html("");
	                    $("#tabel_pasien_ranap").append('<tbody class="tbody"><tr><th colspan="3"></th></tr></tbody>');
	                    $("#tableuser_processing").css("display","none");
	                    
	                  }
	                }
	          
	            });


			       $("#span_button").show();
			       $("#cetak_lap").attr("href", "cetak_laporan_jumlah_pasien.php?dari_tanggal="+dari_tanggal+"&sampai_tanggal="+sampai_tanggal+"");
			       $("#export_lap").attr("href", "export_laporan_jumlah_pasien.php?dari_tanggal="+dari_tanggal+"&sampai_tanggal="+sampai_tanggal+"");

			       $("#div_pasien").show();
			       $("#div_pasien_ranap").show();

			       console.loh(asd)
			}
		
	});	// END ON CLICK
		
	      
	$("form").submit(function(){		
			return false;		
	});
		
</script>




<?php 
include 'footer.php';
 ?>