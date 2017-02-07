<?php include 'session_login.php';


//memasukkan file session login, header, navbar, db.php
include 'header.php';
include 'navbar.php';
include 'sanitasi.php';
include 'db.php';


 ?>

    <script>
    $(function() {
    $( "#sampai_tanggal" ).datepicker({dateFormat: "yy-mm-dd"});
    });
    </script>

 <div class="container">

<h3> LAPORAN PEMBELIAN HUTANG </h3><hr>

<form id="petanggal" class="form" action="proses_lap_pembelian_hutang.php" method="POST" role="form">
				
                  <div class="form-group col-sm-2"> 

                  <input style="height: 20px" type="text" name="sampai_tanggal" id="sampai_tanggal" class="form-control" placeholder="Sampai Tanggal" value="<?php echo date("Y-m-d"); ?>" required="">
                  </div>

                  <button type="submit" name="submit" id="submit_tgl" class="btn btn-primary"> <i class="fa fa-eye"></i> Tampil </button>

</form>

 <br>
 <div class="table-responsive"><!--membuat agar ada garis pada tabel disetiap kolom-->
<span id="result">
<table id="tableuser" class="table table-hover table-sm">
		<thead>
			<th style="background-color: #4CAF50; color: white;"> Tanggal </th>
			<th style="background-color: #4CAF50; color: white;"> Tanggal JT </th>
			<th style="background-color: #4CAF50; color: white;"> Nomor Faktur </th>
			<th style="background-color: #4CAF50; color: white;"> Suplier </th>
			<th style="background-color: #4CAF50; color: white;"> Total </th>
			<th style="background-color: #4CAF50; color: white;"> Jam </th>
			<th style="background-color: #4CAF50; color: white;"> User </th>
			<th style="background-color: #4CAF50; color: white;"> Status </th>
			<th style="background-color: #4CAF50; color: white;"> Potongan </th>
			<th style="background-color: #4CAF50; color: white;"> Tax </th>
			<th style="background-color: #4CAF50; color: white;"> Kembalian</th>
			<th style="background-color: #4CAF50; color: white;"> Sisa Kredit </th>
			<th style="background-color: #4CAF50; color: white;"> Nilai Kredit </th>
						
		</thead>

		</thead>
	</table>
</span>
</div> <!--/ responsive-->
</div> <!--/ container-->

	<!--	<script>
		
		$(document).ready(function(){
		$('#tableuser').DataTable();
		});
		</script> -->

<!--		
		<script type="text/javascript">
		$("#submit_tgl").click(function(){
		
		var sampai_tanggal = $("#sampai_tanggal").val();
		
		
		$.post("proses_lap_pembelian_hutang.php", {sampai_tanggal:sampai_tanggal},function(info){
		
		$("#result").html(info);
		
		});
		
		
		});      
		$("form").submit(function(){
		
		return false;
		
		});
		
		</script>

-->



<script type="text/javascript" language="javascript" >
   $(document).ready(function() {
		$(document).on('click','#submit_tgl',function(e) {
     $('#tableuser').DataTable().destroy();

          var dataTable = $('#tableuser').DataTable( {
          "processing": true,
          "serverSide": true,
          "info":     false,
          "language": {
        "emptyTable":     "My Custom Message On Empty Table"
    },
          "ajax":{
            url :"proses_lap_pembelian_hutang.php", // json datasource
             "data": function ( d ) {
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
    


        } );
          $("#result").show()

   } );  
  $("#petanggal").submit(function(){
      return false;
  });
  function clearInput(){
      $("#petanggal :input").each(function(){
          $(this).val('');
      });
  	};
  } );
 
 </script>




<?php 
include 'footer.php';
 ?>