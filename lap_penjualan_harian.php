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

<h3>LAPORAN PENJUALAN HARIAN </h3><hr>
<form id="perhari" class="form-inline" action="proses_lap_penjualan_harian.php" method="POST" role="form">
				
				  <div class="form-group"> 

                  <input type="text" name="dari_tanggal" id="dari_tanggal" class="form-control" placeholder="Dari Tanggal" required="">
                  </div>

                  <div class="form-group"> 

                  <input type="text" name="sampai_tanggal" id="sampai_tanggal" class="form-control" placeholder="Sampai Tanggal" value="<?php echo date("Y-m-d"); ?>" required="">
                  </div>

                  <button type="submit" name="submit" id="submit" class="btn btn-primary" > <i class="fa fa-eye"> </i> Tampil </button>

</form>

 <div class="card card-block">
			<div class="table-responsive"><!--membuat agar ada garis pada tabel disetiap kolom-->
				<span id="span_lap">
					<table id="tabel_lap" class="table table-bordered table-sm">
						<thead>
							
							<th style="background-color: #4CAF50; color: white;"> Tanggal </th>
							<th style="background-color: #4CAF50; color: white;"> Jumlah Transaksi </th>
							<th style="background-color: #4CAF50; color: white;"> Total Transaksi </th>
							<th style="background-color: #4CAF50; color: white;"> Jumlah Bayar Tunai </th>
							<th style="background-color: #4CAF50; color: white;"> Jumlah Bayar Kredit </th>					
						
						</thead>

					</table>
				</span>
			</div> <!--/ responsive-->
</div>

<span id="cetak" style="display: none;">
  <a href='cetak_lap_penjualan_harian.php' target="blank" id="cetak_lap" class='btn btn-success'><i class='fa fa-print'> </i> Cetak Laporan</a>
</span>

</div> <!--/ container-->



<script type="text/javascript">
$(document).ready(function() {
$(document).on('click','#submit',function(e){


     var sampai_tanggal = $("#sampai_tanggal").val();
     var dari_tanggal = $("#dari_tanggal").val();  

	//untuk tampilkan table kas MUTASI MASUK detail
     $('#tabel_lap').DataTable().destroy();
          var dataTable = $('#tabel_lap').DataTable( {
          "processing": true,
          "serverSide": true,
          "info":     true,
          "language": {
          "emptyTable":     "My Custom Message On Empty Table"},
          "ajax":{
            url :"proses_lap_penjualan_harian.php", // json datasource
             "data": function ( d ) {
                d.dari_tanggal = $("#dari_tanggal").val();
                d.sampai_tanggal = $("#sampai_tanggal").val();
                // d.custom = $('#myInput').val();
                // etc
            },
                type: "post",  // method  , by default get
            error: function(){  // error handling
              $(".tbody_lap").html("");
              $("#tabel_lap").append('<tbody class="tbody_lap"><tr><th colspan="3"></th></tr></tbody>');
              $("#tabel_lap_processing").css("display","none");
              
         
            }
          }
    
    });

	$("#cetak").show();
	$("#cetak_lap").attr("href", "cetak_lap_penjualan_harian.php?dari_tanggal="+dari_tanggal+"&sampai_tanggal="+sampai_tanggal+"");
});

	  $("#perhari").submit(function(){
      return false;
 	  });

	  function clearInput(){
	      $("#perhari :input").each(function(){
	          $(this).val('');
	      });
	  };

});
//Ending untuk tampilkan table kas MUTASI MASUK detail
</script>




<?php 
include 'footer.php';
 ?>