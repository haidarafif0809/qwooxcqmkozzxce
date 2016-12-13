<?php include 'session_login.php';


//memasukkan file session login, header, navbar, db.php
include 'header.php';
include 'navbar.php';
include 'sanitasi.php';
include 'db.php';



 ?>

<div class="container">

 <h3><b>DAFTAR DATA PEMBAYARAN HUTANG</b></h3><hr>

<div class="btn-group">
   <button class="btn btn-primary dropdown-toggle" type="button" id="myDropdown" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
        Jenis Laporan
    </button>
    <div class="dropdown-menu">
        <a class="dropdown-item" id="lap_repembayaran_hutang" href="#">Laporan Rekap Pembayaran Hutang</a>
    </div>
</div>

<span id="show_rekap" style="display: none;"><!--span untuk cari bersarkan Rekap-->
<form class="form-inline" role="form" id="form_tanggal" >
  <div class="form-group"> 
  <input type="text" name="dari_tanggal" id="dari_tanggal_rekap" autocomplete="off" class="form-control tanggal_cari" placeholder="Dari Tanggal">
</div>

<div class="form-group"> 
  <input type="text" name="sampai_tanggal" id="sampai_tanggal_rekap" autocomplete="off" class="form-control tanggal_cari" value="<?php echo date("Y-m-d"); ?>" placeholder="Sampai Tanggal">
</div>

<button type="submit" id="lihat_rekap" class="btn btn-default" style="background-color:#0277bd"><i class="fa fa-eye"> </i> Lihat Rekap</button>
</form>
</span><!--Akhir span untuk cari bersarkan rekap-->


<br>
 <div class="table-responsive"><!--membuat agar ada garis pada tabel disetiap kolom-->
<span id="table_biasa">
<table id="table_lap_pemhut" class="table table-bordered">
		<thead>
			<th style="background-color: #4CAF50; color: white;"> Nomor Faktur </th>
			<th style="background-color: #4CAF50; color: white;"> Tanggal </th>
			<th style="background-color: #4CAF50; color: white;"> Cara Bayar </th>
			<th style="background-color: #4CAF50; color: white;"> Potongan </th>
			<th style="background-color: #4CAF50; color: white;"> Jumlah Bayar </th>

		</thead>
</table>
</span>
</div> <!--/ responsive-->

<div class="card card-block">
<div class="table-responsive"><!--membuat agar ada garis pada tabel disetiap kolom-->
<span id="table_rekap" style="display: none;">
	<table id="table_lap_pemhut_rekap" class="table table-bordered table-sm">
		<thead>
			<th style="background-color: #4CAF50; color: white;"> No Faktur Bayar</th>
			<th style="background-color: #4CAF50; color: white;"> No Faktur Beli</th>
			<th style="background-color: #4CAF50; color: white;"> Suplier </th>
			<th style="background-color: #4CAF50; color: white;"> Tanggal </th>
			<th style="background-color: #4CAF50; color: white;"> Jatuh Tempo </th>
			<th style="background-color: #4CAF50; color: white;"> Kredit </th>
			<th style="background-color: #4CAF50; color: white;"> Potongan </th>
			<th style="background-color: #4CAF50; color: white;"> Total Hutang </th>
			<th style="background-color: #4CAF50; color: white;"> Jumlah Bayar </th>
		</thead>
	</table>
</span>
</div> <!--/ responsive-->

	<span id="cedown" style="display: none;">
		<a href='cetak_lap_pembayaran_hutang_rekap.php' id="cetak_rekap" target="blank" class='btn btn-success'><i class='fa fa-print'> </i> Cetak Pembayaran Hutang </a>

		<a href='export_lap_pembayaran_hutang.php' id="download_excell" class='btn btn-primary'><i class='fa fa-download'> </i> Download Excel </a>
	</span>

</div>
</div> <!--/ container-->

<script type="text/javascript">
// MENAMPILKAN FORM DARI TANGGAL SAMPAI TANGGAL
	$(document).ready(function(){
		$("#lap_repembayaran_hutang").click(function(){
			$("#show_rekap").show();
		});
	});
// /MENAMPILKAN FORM DARI TANGGAL SAMPAI TANGGAL
</script>

<script type="text/javascript">
//PICKERDATE
  $(function() {
  $( ".tanggal_cari" ).pickadate({ selectYears: 100, format: 'yyyy-mm-dd'});
  });
  // /PICKERDATE
</script>

<!--DATA TABLE MENGGUNAKAN AJAX-->
<script type="text/javascript" language="javascript" >
      $(document).ready(function() {

          var dataTable = $('#table_lap_pemhut').DataTable( {
          "processing": true,
          "serverSide": true,
          "ajax":{
            url :"datatable_lap_pemhut.php", // json datasource
           
            type: "post",  // method  , by default get
            error: function(){  // error handling
              $(".employee-grid-error").html("");
              $("#table_lap_pemhut").append('<tbody class="employee-grid-error"><tr><th colspan="3">No data found in the server</th></tr></tbody>');
              $("#employee-grid_processing").css("display","none");
            }
        },
            
            "fnCreatedRow": function( nRow, aData, iDataIndex ) {
                $(nRow).attr('class','tr-id-'+aData[5]+'');
            },
        });

        $("#form").submit(function(){
        return false;
        });
        

      } );
</script>
<!--/DATA TABLE MENGGUNAKAN AJAX-->

<script type="text/javascript">
// LIHAT REKAP
	$(document).ready(function() {
	$(document).on('click','#lihat_rekap',function(e) {

         $('#table_lap_pemhut_rekap').DataTable().destroy();

        var dari_tanggal = $("#dari_tanggal_rekap").val();        
        var sampai_tanggal = $("#sampai_tanggal_rekap").val(); 
        	if (dari_tanggal == '') {
        		alert("Silakan dari tanggal diisi terlebih dahulu.");
        		$("#dari_tanggal_rekap").focus();
        	}
          	else{	
          		var dataTable = $('#table_lap_pemhut_rekap').DataTable( {
			          "processing": true,
			          "serverSide": true,
			          "info":     false,
			          "language": {
			        "emptyTable":   "My Custom Message On Empty Table"
			    },
			          "ajax":{
			            url :"datatable_lap_pemhut_rekap.php", // json datasource
			             "data": function ( d ) {
			                d.dari_tanggal = $("#dari_tanggal_rekap").val();
			                d.sampai_tanggal = $("#sampai_tanggal_rekap").val();
			                // d.custom = $('#myInput').val();
			                // etc
			            },
			                type: "post",  // method  , by default get
			            error: function(){  // error handling
			              $(".tbody").html("");
			              $("#table_lap_pemhut_rekap").append('<tbody class="tbody"><tr><th colspan="3"></th></tr></tbody>');
			              $("#tableuser_processing").css("display","none");
			              
			            }
			          }
			    
			        });

    $("#table_lap_pemhut_rekap").show();
    $("#table_rekap").show();
    $("#cedown").show();
    $("#table_biasa").hide();
  	$("#cetak_rekap").attr("href", "cetak_lap_pembayaran_hutang_rekap.php?dari_tanggal="+dari_tanggal+"&sampai_tanggal="+sampai_tanggal+"");

	$("#download_excell").attr("href", "export_lap_pembayaran_hutang.php?dari_tanggal="+dari_tanggal+"&sampai_tanggal="+sampai_tanggal+"");
}//end else
        });
        $("form").submit(function(){
        
        return false;
        
        });  
   });  
   // / LIHAT REKAP 
</script>

<?php include 'footer.php'; ?>