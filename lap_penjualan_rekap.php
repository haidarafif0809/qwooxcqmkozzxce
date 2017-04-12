<?php include 'session_login.php';


//memasukkan file session login, header, navbar, db.php
include 'header.php';
include 'navbar.php';
include 'sanitasi.php';
include 'db.php';


 ?>

     <script>
    $(function() {
    $( "#dari_tanggal" ).datepicker({dateFormat: "yy-mm-dd"});
    });
    </script>


    <script>
    $(function() {
    $( "#sampai_tanggal" ).datepicker({dateFormat: "yy-mm-dd"});
    });
    </script>

<style>

tr:nth-child(even){background-color: #f2f2f2}

</style>

 <div class="container">

<h3> LAPORAN PENJUALAN REKAP </h3><hr>

<form class="form-inline" role="form">
				
				  <div class="form-group"> 

                  <input type="text" name="dari_tanggal" id="dari_tanggal" class="form-control" placeholder="Dari Tanggal" required="">
                  </div>

                  <div class="form-group"> 

                  <input type="text" name="sampai_tanggal" id="sampai_tanggal" class="form-control" placeholder="Sampai Tanggal" value="<?php echo date("Y-m-d"); ?>" required="">
                  </div>

                  <button type="submit" name="submit" id="submit" class="btn btn-primary" ><i class="fa fa-eye"> </i> Tampil </button>

</form>

 <br>
  <div class="card card-block">

 <div class="table-responsive"><!--membuat agar ada garis pada tabel disetiap kolom-->
<span id="result">
<table id="tableuser" class="table table-bordered table-sm">
		<thead>
			<th style="background-color: #4CAF50; color: white;"> Nomor Faktur </th>
			<th style="background-color: #4CAF50; color: white;"> Kode Pelanggan</th>
			<th style="background-color: #4CAF50; color: white;"> Tanggal </th>
			<th style="background-color: #4CAF50; color: white;"> Jam </th>
			<th style="background-color: #4CAF50; color: white;"> User </th>
			<th style="background-color: #4CAF50; color: white;"> Status </th>
			<th style="background-color: #4CAF50; color: white;"> Subtotal </th>
			<th style="background-color: #4CAF50; color: white;"> Potongan </th>
			<th style="background-color: #4CAF50; color: white;"> Tax </th>
			<th style="background-color: #4CAF50; color: white;"> Biaya Admin </th>
			<th style="background-color: #4CAF50; color: white;"> Total </th>
			<th style="background-color: #4CAF50; color: white;"> Kredit </th>
						
		</thead>
		<tbody>
			

		</tbody>

	</table>
</span>
</div> <!--/ responsive-->



<span id="cetak" style="display: none;">
 <a href="cetak_lap_penjualan_rekap.php" target="blank" id="cetak_lap"  class="btn btn-success"><i class="fa fa-print"> </i> Cetak Penjualan </a>
</span>

</div> <!--/ container-->

		
		<script type="text/javascript">
		$("#submit").click(function(){
		
		var dari_tanggal = $("#dari_tanggal").val();
		var sampai_tanggal = $("#sampai_tanggal").val();
		if (dari_tanggal == '') {
			alert("Silakan isi kolom dari tanggal terlebih dahulu.");
			$("#dari_tanggal").focus();
		}
		else if (sampai_tanggal == '') {
			alert("silakan isi kolom sampai tanggal trlebih dahulu.");
			$("#sampai_tanggal").focus();
		}
		else {
			$('#tableuser').DataTable().destroy();

		  var dataTable = $('#tableuser').DataTable( {
                "processing": true,
                "serverSide": true,
                "info":     true,
                "language": {
              "emptyTable":   "My Custom Message On Empty Table"
          },
                "ajax":{
                  url :"proses_lap_penjualan_rekap.php", // json datasource
                   "data": function ( d ) {
                      d.dari_tanggal = $("#dari_tanggal").val();
                      d.sampai_tanggal = $("#sampai_tanggal").val();
                      // d.custom = $('#myInput').val();
                      // etc
                  },
                      type: "post",  // method  , by default get
                  error: function(){  // error handling
                    $(".tbody").html("");
                    $("#tableuser").append('<tbody class="tbody"><tr><th colspan="3"></th></tr></tbody>');
                    $("#tableuser_processing").css("display","none");
                    
                  }
                }
          
              });
    

          $("#cetak").show();
        $("#cetak_lap").attr("href", "cetak_penjualan_rekap.php?dari_tanggal="+dari_tanggal+"&sampai_tanggal="+sampai_tanggal+"");
		}
		
		});
		
		
	      
		$("form").submit(function(){
		
		return false;
		
		});
		
		</script>




<?php 
include 'footer.php';
 ?>