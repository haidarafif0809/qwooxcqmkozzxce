<?php include_once 'session_login.php';
//memasukkan file session login, header, navbar, db.php
include 'header.php';
include 'navbar.php';
include 'sanitasi.php';
include 'db.php';



?>

<div class="container">
<h3><b>Laporan Hasil Laboratorium</b></h3>
<br>

<div class="table-responsive"><!--membuat agar ada garis pada tabel disetiap kolom-->
<span id="result">
<table id="table_lab" class="table table-bordered">
		<thead>
			<th style="background-color: #4CAF50; color: white;"> Input Hasil</th>
			<th style="background-color: #4CAF50; color: white;"> Cetak</th>
			<th style="background-color: #4CAF50; color: white;"> No RM</th>
			<th style="background-color: #4CAF50; color: white;"> No REG</th>
			<th style="background-color: #4CAF50; color: white;"> No Faktur</th>
			<th style="background-color: #4CAF50; color: white;"> Pasien</th>
			<th style="background-color: #4CAF50; color: white;"> Dokter</th>
			<th style="background-color: #4CAF50; color: white;"> Analis</th>
			<th style="background-color: #4CAF50; color: white;"> Pemeriksaan</th>
			<th style="background-color: #4CAF50; color: white;"> Hasil Pemeriksaan</th>
			<th style="background-color: #4CAF50; color: white;"> Normal Pria </th>
			<th style="background-color: #4CAF50; color: white;"> Normal Wanita </th>
			<th style="background-color: #4CAF50; color: white;"> Normal / Tidak Normal </th>
			<th style="background-color: #4CAF50; color: white;"> Status Rawat </th>
			<th style="background-color: #4CAF50; color: white;"> Tanggal </th>
		</thead>
		<tbody>
			

		</tbody>

	</table>
</span>
 <h6 style="text-align: left ; color: blue"><i> Note * Bisa Cetak Jika Input Hasil Sudah Selesai dan Penjualan Sudah Selesai ( No Faktur Tidak Kosong ) !!</i></h6>

</div> <!--/ responsive-->

</div>



<!--start ajax datatable-->
<script type="text/javascript" language="javascript" >
      $(document).ready(function() {
        var dataTable = $('#table_lab').DataTable( {
          "processing": true,
          "serverSide": true,
          "ajax":{
            url :"show_data_hasil_lab.php", // json datasource
            type: "post",  // method  , by default get
            error: function(){  // error handling
              $(".tbody").html("");

             $("#table_lab").append('<tbody class="tbody"><tr><th colspan="3">Tidak Ada Data Yang Ditemukan</th></tr></tbody>');

              $("#table_lab_processing").css("display","none");
              
            }
          },
              "fnCreatedRow": function( nRow, aData, iDataIndex ) {
              $(nRow).attr('class','tr-id-'+aData[13]+'');
            },
        } );
      } );
    </script>
<!--end ajax datatable-->





<?php include 'footer.php'; ?>