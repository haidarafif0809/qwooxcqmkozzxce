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

<h3> LAPORAN PEMBELIAN HARIAN </h3><hr>

<form class="form-inline" role="form">
				
				  <div class="form-group"> 

                  <input type="text" name="dari_tanggal" id="dari_tanggal" class="form-control" placeholder="Dari Tanggal" required="">
                  </div>

                  <div class="form-group"> 

                  <input type="text" name="sampai_tanggal" id="sampai_tanggal" class="form-control" placeholder="Sampai Tanggal" value="<?php echo date("Y/m/d"); ?>" required="">
                  </div>

                  <button type="submit" name="submit" id="submit" class="btn btn-primary" > <i class="fa fa-eye"></i> Tampil </button>

</form>

 <br>
 <div class="table-responsive"><!--membuat agar ada garis pada tabel disetiap kolom-->
<span id="result">
<table id="tableuser" class="table table-bordered">
					<thead>
					<th style="background-color: #4CAF50; color: white;"> Tanggal </th>
					<th style="background-color: #4CAF50; color: white;"> Jumlah Transaksi </th>
					<th style="background-color: #4CAF50; color: white;"> Total Transaksi </th>
					<th style="background-color: #4CAF50; color: white;"> Jumlah Bayar Tunai </th>
					<th style="background-color: #4CAF50; color: white;"> Jumlah Bayar Kredit </th>

					
					</thead>
					
					<tbody>

					</tbody>
					
					</table>
</span>
</div> <!--/ responsive-->
<span id="cetak" style="display: none;">
	<a href='cetak_lap_pembelian_harian.php' id="cetak_lap" target="blank" class='btn btn-success'><i class='fa fa-print'> </i> Cetak Pembelian </a>
</span>
</div> <!--/ container-->

		
<script type="text/javascript">
		$("#submit").click(function(){
		
		var dari_tanggal = $("#dari_tanggal").val();
		var sampai_tanggal = $("#sampai_tanggal").val();
		
		  if (dari_tanggal == '') {
		  	alert("Silakan Isi dari tanggal terlebih dahulu.");
		  	$("#dari_tanggal").focus();
		  }
		  else if (sampai_tanggal == '') {
		  	alert("Silakan isikan sampai tanggal terlebih dahulu.");
		  	$("#sampai_tanggal").focus();
		  }
		 else{
		 	$('#cetak').show();
		 	 $('#tableuser').DataTable().destroy();

		  var dataTable = $('#tableuser').DataTable( {
                "processing": true,
                "serverSide": true,
                "info":     true,
                "language": {
              "emptyTable":   "My Custom Message On Empty Table"
          },
                "ajax":{
                  url :"datatable_lap_pembelian_harian.php", // json datasource
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
        $("#cetak_lap").attr("href", "cetak_lap_pembelian_harian.php?dari_tanggal="+dari_tanggal+"&sampai_tanggal="+sampai_tanggal+"");
		 }
		
		});
		
		
	      
		$("form").submit(function(){
		
		return false;
		
		});
		
		</script>
		
		<!--script type="text/javascript">
		$("#submit").click(function(){
		
		var dari_tanggal = $("#dari_tanggal").val();
		var sampai_tanggal = $("#sampai_tanggal").val();
		
		
		$.post("proses_lap_pembelian_harian.php", {dari_tanggal:dari_tanggal,sampai_tanggal:sampai_tanggal},function(info){
		
		$("#result").html(info);
		
		});
		
		
		});      
		$("form").submit(function(){
		
		return false;
		
		});
		
		</script-->




<?php 
include 'footer.php';
 ?>