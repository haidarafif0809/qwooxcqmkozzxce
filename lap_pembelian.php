<?php include 'session_login.php';

//memasukkan file session login, header, navbar, db.php
include 'header.php';
include 'navbar.php';
include 'sanitasi.php';
include 'db.php';


 ?>

<div class="container">

 <h3><b>DAFTAR DATA PEMBELIAN </b></h3><hr>


<div class="dropdown">
    <button class="btn btn-primary dropdown-toggle" type="button" data-toggle="dropdown" style="width:150px"> Jenis Laporan <span class="caret"></span></button>

             <ul class="dropdown-menu dropdown-ins">
		<li><a class="dropdown-item" href="lap_pembelian_rekap.php"> Laporan Pembelian Rekap </a></li> 
		<li><a class="dropdown-item" href="lap_pembelian_detail.php"> Laporan Pembelian Detail </a></li>
		<li><a class="dropdown-item" href="lap_pembelian_harian.php"> Laporan Pembelian Harian </a></li>
				<!--
				<li><a href="lap_pelanggan_detail.php"> Laporan Jual Per Pelanggan Detail </a></li>
				<li><a href="lap_pelanggan_rekap.php"> Laporan Jual Per Pelanggan Rekap </a></li>
				<li><a href="lap_sales_detail.php"> Laporan Jual Per Sales Detail </a></li>
				<li><a href="lap_sales_rekap.php"> Laporan Jual Per Sales Rekap </a></li>
				-->

             </ul>
</div> <!--/ dropdown-->


<br>
 <div class="table-responsive"><!--membuat agar ada garis pada tabel disetiap kolom-->
<span id="table-baru">
<table id="show_table" class="table table-bordered">
		<thead>
			<th style="background-color: #4CAF50; color: white;"> Nomor Faktur </th>
			<th style="background-color: #4CAF50; color: white;"> Nama Suplier </th>
			<th style="background-color: #4CAF50; color: white;"> Total </th>
			<th style="background-color: #4CAF50; color: white;"> Tanggal </th>
			<th style="background-color: #4CAF50; color: white;"> Jam </th>
			<th style="background-color: #4CAF50; color: white;"> User </th>
			<th style="background-color: #4CAF50; color: white;"> Status </th>
			<th style="background-color: #4CAF50; color: white;"> Potongan </th>
			<th style="background-color: #4CAF50; color: white;"> Tax </th>
			<th style="background-color: #4CAF50; color: white;"> Kembalian </th>
			<th style="background-color: #4CAF50; color: white;"> Kredit </th>

			
			
		</thead>
		
		<tbody>
		
		</tbody>

	</table>
</span>
</div> <!--/ responsive-->
</div> <!--/ container-->


<script type="text/javascript" language="javascript" >

      $(document).ready(function() {
        var dataTable = $('#show_table').DataTable( {
          "processing": true,
          "serverSide": true,
          "ajax":{
            url :"show_data_pembelian.php", // json datasource
            type: "post",  // method  , by default get
            error: function(){  // error handling
              $(".tbody").html("");

             $("#show_table").append('<tbody class="tbody"><tr><th colspan="3">Tidak Ada Data Yang Ditemukan</th></tr></tbody>');

              $("#show_table_processing").css("display","none");
              
            }
          }

        } );
      } );
    </script>
		<!--menampilkan detail penjualan-->


<?php include 'footer.php'; ?>