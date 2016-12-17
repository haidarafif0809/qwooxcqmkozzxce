<?php include 'session_login.php';


//memasukkan file session login, header, navbar, db.php
include 'header.php';
include 'navbar.php';
include 'sanitasi.php';
include 'db.php';

//menampilkan seluruh data yang ada pada tabel retur_pembelian
$perintah = $db->query("SELECT pel.nama_pelanggan,p.no_faktur_retur,p.tanggal,p.kode_pelanggan,p.total,p.potongan,p.tax,p.tunai FROM retur_penjualan p INNER JOIN pelanggan pel ON p.kode_pelanggan = pel.kode_pelanggan ");

 ?>

<div class="container">

 <h3><b>DAFTAR DATA RETUR PENJUALAN</b></h3><hr>

<div class="btn-group">
   <button class="btn btn-primary dropdown-toggle" type="button" id="myDropdown" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
        Jenis Laporan
    </button>
    <div class="dropdown-menu">
        <a class="dropdown-item" id="lap_repen_rekap" href="#">Laporan Rekap Retur Penjualan</a>
        <a class="dropdown-item" id="lap_repen_detail" href="#">Laporan Detail Retur Penjualan</a>
    </div>
</div>

<span id="show_rekap" style="display: none;"><!--span untuk cari bersarkan Rekap-->
<form class="form-inline" role="form" id="form_tanggal" >
  <div class="form-group"> 
  <input type="text" name="dari_tanggal" id="dari_tanggal_rekap" autocomplete="off" class="form-control tanggal_cari" placeholder="Dari Tanggal">
</div>

<div class="form-group"> 
  <input type="text" name="sampai_tanggal" id="sampai_tanggal_rekap" autocomplete="off" value="<?php echo date("Y-m-d"); ?>" class="form-control tanggal_cari" placeholder="Sampai Tanggal">
</div>

<button type="submit" name="submit" id="lihat_rekap" class="btn btn-default" style="background-color:#0277bd"><i class="fa fa-eye"> </i> Lihat Rekap</button>
</form>
</span><!--Akhir span untuk cari bersarkan rekap-->

<span id="show_detail" style="display: none;"><!--span untuk cari bersarkan detail-->
<form class="form-inline" role="form" id="form_tanggal">
<div class="form-group"> 
  <input type="text" name="dari_tanggal" id="dari_tanggal" autocomplete="off" class="form-control tanggal_cari" placeholder="Dari Tanggal">
</div>

<div class="form-group"> 
  <input type="text" name="sampai_tanggal" id="sampai_tanggal" autocomplete="off" value="<?php echo date("Y-m-d"); ?>" class="form-control tanggal_cari" placeholder="Sampai Tanggal">
</div>

<button type="submit" name="submit" id="lihat_detail" class="btn btn-default" style="background-color:#0277bd"><i class="fa fa-eye"> </i> Lihat Detail</button>
</form>
</span><!--Akhir span untuk cari bersarkan detail-->

<!--<div class="dropdown">
             <button class="btn btn-primary dropdown-toggle" type="button" data-toggle="dropdown" style="width:150px"> Jenis Laporan <span class="caret"></span></button>

             <ul class="dropdown-menu dropdown-ins">
		
		<li><a class="dropdown-item" href="lap_retur_penjualan_rekap.php"> Laporan Retur Penjualan Rekap </a></li> 
		
		<li><a class="dropdown-item"href="lap_retur_penjualan_detail.php"> Laporan Retur Penjualan Detail </a></li>-->
				<!--
				<li><a href="lap_retur_penjualan_harian.php"> Laporan Retur Penjualan Harian </a></li>
				<li><a href="lap_pelanggan_detail.php"> Laporan Jual Per Pelanggan Detail </a></li>
				<li><a href="lap_pelanggan_rekap.php"> Laporan Jual Per Pelanggan Rekap </a></li>
				<li><a href="lap_sales_detail.php"> Laporan Jual Per Sales Detail </a></li>
				<li><a href="lap_sales_rekap.php"> Laporan Jual Per Sales Rekap </a></li>
				-->


             <!--</ul>
</div> / dropdown-->



<br>
 <div class="table-responsive"><!--membuat agar ada garis pada tabel disetiap kolom-->
<span id="table_rekap">
<table id="table_lap_repen" class="table table-bordered">
		<thead>
			<th style="background-color: #4CAF50; color: white;"> Nomor Faktur Retur </th>
			<th style="background-color: #4CAF50; color: white;"> Tanggal </th>
			<th style="background-color: #4CAF50; color: white;"> Kode Pelanggan </th>
			<th style="background-color: #4CAF50; color: white;"> Jumlah Retur </th>
			<th style="background-color: #4CAF50; color: white;"> Total </th>
			<th style="background-color: #4CAF50; color: white;"> Potongan </th>
			<th style="background-color: #4CAF50; color: white;"> Tax </th>
			<th style="background-color: #4CAF50; color: white;"> Tunai </th>
		</thead>
</table>
</span>
</div> <!--/ responsive-->

<div class="table-responsive"><!--membuat agar ada garis pada tabel disetiap kolom-->
<span id="table_detail" style="display: none;">
<table id="table_lap_repen_detail" class="table table-bordered">
    <thead>
      <th style="background-color: #4CAF50; color: white;"> Nomor Faktur </th>
      <th style="background-color: #4CAF50; color: white;"> Tanggal </th>         
      <th style="background-color: #4CAF50; color: white;"> Kode Barang </th>
      <th style="background-color: #4CAF50; color: white;"> Nama Barang </th>
      <th style="background-color: #4CAF50; color: white;"> Jumlah Retur </th>
      <th style="background-color: #4CAF50; color: white;"> Satuan </th>
      <th style="background-color: #4CAF50; color: white;"> Harga </th>
      <th style="background-color: #4CAF50; color: white;"> Potongan </th>
      <th style="background-color: #4CAF50; color: white;"> Subtotal </th>
    </thead>
</table>
</span>
</div> <!--/ responsive-->

<span id="cetak_excell"  style='display: none;'>
	<a href='cetak_lap_retur_penjualan_rekap.php' id='btn-rekap' target='blank' class='btn btn-success'><i class='fa fa-print'> </i> Cetak Rekap Retur Penjualan </a>
</span>

<span id="cetak_excell_detail"  style='display: none;'>
	<a href='cetak_lap_retur_penjualan_detail.php' id='btn-detail' class='btn btn-success' target='blank' ><i class='fa fa-print'> </i> Cetak Detail Retur Penjualan</a>
</span>
</div> <!--/ container-->



<script type="text/javascript">
//PICKERDATE
  $(function() {
  $( ".tanggal_cari" ).pickadate({ selectYears: 100, format: 'yyyy-mm-dd'});
  });
  // /PICKERDATE
</script>


<script type="text/javascript">
// BUTTON LAPORAN
$(document).ready(function(){
    $("#lap_repen_rekap").click(function(){    
    $("#show_rekap").show();
    $("#show_detail").hide();
    });

    $("#lap_repen_detail").click(function(){    
    $("#show_detail").show();  
    $("#show_rekap").hide();
    });
});
// /BUTTON LAPORAN.
</script>



<script type="text/javascript">
// LIHAT REKAP
	$(document).ready(function() {
	$(document).on('click','#lihat_rekap',function(e) {
        
         $('#table_lap_repen').DataTable().destroy();

        var dari_tanggal = $("#dari_tanggal_rekap").val();        
        var sampai_tanggal = $("#sampai_tanggal_rekap").val(); 


          var dataTable = $('#table_lap_repen').DataTable( {
          "processing": true,
          "serverSide": true,
          "info":     false,
          "language": {
        "emptyTable":   "My Custom Message On Empty Table"
    },
          "ajax":{
            url :"datatable_lap_repen_rekap.php", // json datasource
             "data": function ( d ) {
                d.dari_tanggal = $("#dari_tanggal_rekap").val();
                d.sampai_tanggal = $("#sampai_tanggal_rekap").val();
                // d.custom = $('#myInput').val();
                // etc
            },
                type: "post",  // method  , by default get
            error: function(){  // error handling
              $(".tbody").html("");
              $("#table_lap_repen").append('<tbody class="tbody"><tr><th colspan="3"></th></tr></tbody>');
              $("#tableuser_processing").css("display","none");
              
            }
          }
    
        });

    $("#cetak_excell").show();
    $("#table_rekap").show();
    $("#table_detail").hide();
    $("#cetak_excell_detail").hide();
  $("#btn-rekap").attr("href", "cetak_lap_retur_penjualan_rekap.php?dari_tanggal="+dari_tanggal+"&sampai_tanggal="+sampai_tanggal+"");

        });
        $("form").submit(function(){
        
        return false;
        
        });  
   });  
   // / LIHAT REKAP 
</script>

<script type="text/javascript">
// LIHAT DETAIL
	$(document).ready(function() {
	$(document).on('click','#lihat_detail',function(e) {
        
         $('#table_lap_repen_detail').DataTable().destroy();

        var dari_tanggal = $("#dari_tanggal").val();        
        var sampai_tanggal = $("#sampai_tanggal").val(); 


          var dataTable = $('#table_lap_repen_detail').DataTable( {
          "processing": true,
          "serverSide": true,
          "info":     false,
          "language": {
        "emptyTable":   "My Custom Message On Empty Table"
    },
          "ajax":{
            url :"datatable_lap_repen_detail.php", // json datasource
             "data": function ( d ) {
                d.dari_tanggal = $("#dari_tanggal").val();
                d.sampai_tanggal = $("#sampai_tanggal").val();
                // d.custom = $('#myInput').val();
                // etc
            },
                type: "post",  // method  , by default get
            error: function(){  // error handling
              $(".tbody").html("");
              $("#table_lap_repen_detail").append('<tbody class="tbody"><tr><th colspan="3"></th></tr></tbody>');
              $("#tableuser_processing").css("display","none");
              
            }
          }
    
        });

    $("#cetak_excell_detail").show();
    $("#table_detail").show();
    $("#table_rekap").hide();
    $("#cetak_excell").hide();
  $("#btn-detail").attr("href", "cetak_lap_retur_penjualan_detail.php?dari_tanggal="+dari_tanggal+"&sampai_tanggal="+sampai_tanggal+"");

        });
        $("form").submit(function(){
        
        return false;
        
        });  
   });  
   // / LIHAT DETAIL 
</script>


<!--DATA TABLE MENGGUNAKAN AJAX TANPA CARI BERDASARKAN-->
<script type="text/javascript" language="javascript" >
      $(document).ready(function() {

          var dataTable = $('#table_lap_repen').DataTable( {
          "processing": true,
          "serverSide": true,
          "ajax":{
            url :"datatable_lap_repen.php", // json datasource
           
            type: "post",  // method  , by default get
            error: function(){  // error handling
              $(".employee-grid-error").html("");
              $("#table_lap_repen").append('<tbody class="employee-grid-error"><tr><th colspan="3">No data found in the server</th></tr></tbody>');
              $("#employee-grid_processing").css("display","none");
            }
        },
            
            "fnCreatedRow": function( nRow, aData, iDataIndex ) {
                $(nRow).attr('class','tr-id-'+aData[8]+'');
            },
        });

        $("#form").submit(function(){
        return false;
        });
        

      } );
    </script>
<!--/DATA TABLE MENGGUNAKAN AJAX-->

<?php include 'footer.php'; ?>