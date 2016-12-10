<?php include 'session_login.php';


//memasukkan file session login, header, navbar, db.php
include 'header.php';
include 'navbar.php';
include 'sanitasi.php';
include 'db.php';

//menampilkan seluruh data yang ada pada tabel penjualan
$perintah = $db->query("SELECT p.nama_pelanggan,da.nama_daftar_akun,pp.no_faktur_pembayaran,pp.tanggal,pp.nama_suplier,pp.dari_kas,pp.total FROM pembayaran_piutang pp INNER JOIN daftar_akun da ON pp.dari_kas = da.kode_daftar_akun INNER JOIN pelanggan p ON pp.nama_suplier = p.kode_pelanggan ");

 ?>

<div class="container">

 <h3><b>DAFTAR DATA PEMBAYARAN PIUTANG</b></h3><hr>

<div class="btn-group">
   <button class="btn btn-primary dropdown-toggle" type="button" id="myDropdown" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
        Jenis Laporan
    </button>
    <div class="dropdown-menu">
        <a class="dropdown-item" id="lap_repembayaran_piutang" href="#">Laporan Rekap Pembayaran Piutang</a>
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
<!--BIASA-->
 <div class="table-responsive"><!--membuat agar ada garis pada tabel disetiap kolom-->
<span id="table_biasa">
<table id="table_lap_pempiu" class="table table-bordered">
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

<!--/BIASA-->

<!--REKAP-->
<div class="table-responsive"><!--membuat agar ada garis pada tabel disetiap kolom-->
<span id="table_rekap" style="display: none;">
<table id="table_lap_pempiu_rekap" class="table table-bordered">
		<thead>
			<th style="background-color: #4CAF50; color: white;"> Nomor Faktur Pembayaran</th>
			<th style="background-color: #4CAF50; color: white;"> Nomor Faktur Penjualan</th>
			<th style="background-color: #4CAF50; color: white;"> Tanggal </th>
			<th style="background-color: #4CAF50; color: white;"> Kode Pelanggan </th>
			<th style="background-color: #4CAF50; color: white;"> Cara Bayar </th>
			<th style="background-color: #4CAF50; color: white;"> Potongan </th>
			<th style="background-color: #4CAF50; color: white;"> Jumlah Bayar </th>
		</thead>
</table>
</span>
</div> <!--/ responsive-->

<span id="muncul" style="display: none;">
	<a href='cetak_lap_pembayaran_piutang_rekap.php' id="cetak_rekap" target="blank" class='btn btn-success'><i class='fa fa-print'> </i> Cetak Pembayaran Piutang </a>
	
		<a href='download_lap_pembayaran_piutang.php' id="download_excell" target="blank" class='btn btn-primary'><i class='fa fa-download'> </i> Download Excel </a>
</span>
</div> <!--/ container-->
<!--/REKAP-->

<script type="text/javascript">
// BUTTON LAPORAN
$(document).ready(function(){
    $("#lap_repembayaran_piutang").click(function(){    
    $("#show_rekap").show();
    });
});
// /BUTTON LAPORAN.
</script>

<script type="text/javascript">
//PICKERDATE
  $(function() {
  $( ".tanggal_cari" ).pickadate({ selectYears: 100, format: 'yyyy-mm-dd'});
  });
  // /PICKERDATE
</script>

<script type="text/javascript">
// LIHAT REKAP
	$(document).ready(function() {
	$(document).on('click','#lihat_rekap',function(e) {

         $('#table_lap_pempiu_rekap').DataTable().destroy();

        var dari_tanggal = $("#dari_tanggal_rekap").val();        
        var sampai_tanggal = $("#sampai_tanggal_rekap").val(); 
        	
          		var dataTable = $('#table_lap_pempiu_rekap').DataTable( {
			          "processing": true,
			          "serverSide": true,
			          "info":     false,
			          "language": {
			        "emptyTable":   "My Custom Message On Empty Table"
			    },
			          "ajax":{
			            url :"datatable_lap_pempiu_rekap.php", // json datasource
			             "data": function ( d ) {
			                d.dari_tanggal = $("#dari_tanggal_rekap").val();
			                d.sampai_tanggal = $("#sampai_tanggal_rekap").val();
			                // d.custom = $('#myInput').val();
			                // etc
			            },
			                type: "post",  // method  , by default get
			            error: function(){  // error handling
			              $(".tbody").html("");
			              $("#table_lap_pempiu_rekap").append('<tbody class="tbody"><tr><th colspan="3"></th></tr></tbody>');
			              $("#tableuser_processing").css("display","none");
			              
			            }
			          }
			    
			        });

    $("#table_lap_pempiu_rekap").show();
    $("#table_rekap").show();
    $("#table_biasa").hide();
  	$("#cetak_rekap").attr("href", "cetak_lap_pembayaran_piutang_rekap.php?dari_tanggal="+dari_tanggal+"&sampai_tanggal="+sampai_tanggal+"");

	$("#download_excell").attr("href", "download_lap_pembayaran_piutang.php?dari_tanggal="+dari_tanggal+"&sampai_tanggal="+sampai_tanggal+"");
        });
        $("form").submit(function(){
        
        return false;
        
        });  
   });  
   // / LIHAT REKAP 
</script>

<!--DATA TABLE MENGGUNAKAN AJAX-->
<script type="text/javascript" language="javascript" >
      $(document).ready(function() {

          var dataTable = $('#table_lap_pempiu').DataTable( {
          "processing": true,
          "serverSide": true,
          "ajax":{
            url :"datatable_lap_pempiu.php", // json datasource
           
            type: "post",  // method  , by default get
            error: function(){  // error handling
              $(".employee-grid-error").html("");
              $("#table_lap_pempiu").append('<tbody class="employee-grid-error"><tr><th colspan="3">No data found in the server</th></tr></tbody>');
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

<?php include 'footer.php'; ?>