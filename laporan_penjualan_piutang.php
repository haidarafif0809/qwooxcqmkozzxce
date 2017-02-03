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

    <script>
    $(function() {
    $( "#dari_tanggal_periode" ).datepicker({dateFormat: "yy-mm-dd"});
    });
    </script>

    <script>
    $(function() {
    $( "#sampai_tanggal_periode" ).datepicker({dateFormat: "yy-mm-dd"});
    });
    </script>
 <div class="container">

<h3> LAPORAN PENJUALAN PIUTANG </h3><hr>



<div class="dropdown">

    <!--Trigger-->
    <button class="btn btn-secondary dropdown-toggle" type="button" id="dropdownMenu4" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Cari Berdasarkan</button>

    <!--Menu-->
    <div class="dropdown-menu dropdown-secondary" aria-labelledby="dropdownMenu4" data-dropdown-in="fadeIn" data-dropdown-out="fadeOut">
        <a class="dropdown-item" id="nav_periode" href="#">Periode</a>
        <a class="dropdown-item" id="nav_tanggal" href="#">Per Tanggal</a>
    </div>
</div>


<!--span untuk cari bersarkan dari tanggal kek tanggal-->
<span id="show_periode">
<form class="form-inline" role="form" id="form_periode" >


<div class="form-group"> 
  <input type="text" name="dari_tanggal_periode" id="dari_tanggal_periode" autocomplete="off" class="form-control tanggal_cari" placeholder="Dari Tanggal">
</div>

<div class="form-group"> 
  <input type="text" name="sampai_tanggal_periode" id="sampai_tanggal_periode" autocomplete="off" value="<?php echo date("Y-m-d"); ?>" class="form-control tanggal_cari" placeholder="Sampai Tanggal">
</div>

<button type="submit" name="submit" id="lihat_periode" class="btn btn-default " style="background-color:#0277bd"><i class="fa fa-eye"> </i> Lihat Periode </button>
</form>
</span>
<!--Akhir span untuk cari bersarkan TANEN / KATEGORI Rekap-->


<!-- cari untuk per tanggal jika ada piutang sebelum tanggal yang di cari-->
<span id="show_tanggal">
<form id="petanggal" class="form" role="form">

                  <div class="form-group col-sm-2"> 

                  <input style="height: 20px" type="text" name="sampai_tanggal" id="sampai_tanggal" class="form-control" placeholder="Sampai Tanggal" value="<?php echo date("Y-m-d"); ?>" required="">
                  </div>

                  <button type="submit" name="submit" id="submit_tgl" class="btn btn-primary" > <i class="fa fa-eye"></i> Lihat </button>

</form>
</span>
<!-- END cari untuk per tanggal jika ada piutang sebelum tanggal yang di cari-->

 <br>
 <div class="table-responsive"><!--membuat agar ada garis pada tabel disetiap kolom-->
<span id="result">
<table id="tableuser" class="table table-hover table-sm">
		<thead>
			<th style="background-color: #4CAF50; color: white;"> Penjamin </th>
			<th style="background-color: #4CAF50; color: white;"> Tanggal </th>
			<th style="background-color: #4CAF50; color: white;"> Tanggal JT </th>
			<th style="background-color: #4CAF50; color: white;"> Nomor Faktur </th>
			<th style="background-color: #4CAF50; color: white;"> Pelanggan</th>
			<th style="background-color: #4CAF50; color: white;"> Total </th>
			<th style="background-color: #4CAF50; color: white;"> Jam </th>
			<th style="background-color: #4CAF50; color: white;"> User </th>
			<th style="background-color: #4CAF50; color: white;"> Status </th>
			<th style="background-color: #4CAF50; color: white;"> Potongan </th>
			<th style="background-color: #4CAF50; color: white;"> Tax </th>
			<th style="background-color: #4CAF50; color: white;"> Kredit </th>
						
		</thead>
		<tbody>
			

		</tbody>

	</table>
</span>
</div> <!--/ responsive-->
</div> <!--/ container-->

<script>
		
		$(document).ready(function(){
		$('#tableuser').DataTable();
		});
		</script>
<!--
		
		
		<script type="text/javascript">
		$("#submit_tgl").click(function(){
		
		var dari_tanggal = $("#dari_tanggal").val();
		var sampai_tanggal = $("#sampai_tanggal").val();
		
		
		$.post("proses_lap_penjualan_piutang.php", {dari_tanggal:dari_tanggal,sampai_tanggal:sampai_tanggal},function(info){
		
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
		$(document).on('click','#lihat_periode',function(e) {
     $('#tableuser').DataTable().destroy();

          var dataTable = $('#tableuser').DataTable( {
          "processing": true,
          "serverSide": true,
          "info":     true,
          "language": {
        "emptyTable":     "My Custom Message On Empty Table"
    },
          "ajax":{
            url :"proses_lap_penjualan_piutang_periode.php", // json datasource
             "data": function ( d ) {
                d.dari_tanggal_periode = $("#dari_tanggal_periode").val();
                d.sampai_tanggal_periode = $("#sampai_tanggal_periode").val();
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
  $("#form_periode").submit(function(){
      return false;
  });
  function clearInput(){
      $("#form_periode :input").each(function(){
          $(this).val('');
      });
  	};
  } );
 
 </script>

 <!--SCRIPT PROSES UNTUK YANG UNDER PER TANGGAL-->
<script type="text/javascript" language="javascript" >
   $(document).ready(function() {
		$(document).on('click','#submit_tgl',function(e) {
     $('#tableuser').DataTable().destroy();

          var dataTable = $('#tableuser').DataTable( {
          "processing": true,
          "serverSide": true,
          "info":     true,
          "language": {
        "emptyTable":     "My Custom Message On Empty Table"
    },
          "ajax":{
            url :"proses_lap_penjualan_piutang.php", // json datasource
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
 <!--ENDING SCRIPT PROSES UNTUK YANG UNDER PER TANGGAL-->


<script type="text/javascript">
   $(document).ready(function(){
      $("#show_tanggal").hide();
      $("#show_periode").hide();

  });
</script>

<script type="text/javascript">
$(document).ready(function(){
    $("#nav_tanggal").click(function(){    
    $("#show_tanggal").show();
    $("#show_periode").hide();
     $("#result").hide()
    });

    $("#nav_periode").click(function(){    
    $("#show_periode").show();  
    $("#show_tanggal").hide();
 	$("#result").hide()
    });

});
</script>	

<?php 
include 'footer.php';
 ?>