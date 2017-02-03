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


<div id="modal_detail" class="modal fade" role="dialog">
  <div class="modal-dialog modal-lg">

    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title"><center><b>Detail Hasil Laboratorium</b></center></h4>
      </div>

      <div class="modal-body">
      <div class="table-responsive">
      <span id="modal-detail"> </span>
      </div>

     </div>

      <div class="modal-footer">
        
  <center> <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button></center> 
      </div>
    </div>

  </div>
</div>


<div class="table-responsive"><!--membuat agar ada garis pada tabel disetiap kolom-->
<span id="result">
<table id="table_lab" class="table table-bordered table-sm">
		<thead>
			<th style="background-color: #4CAF50; color: white;"> Input Hasil</th>
			<th style="background-color: #4CAF50; color: white;"> Cetak</th>
			<th style="background-color: #4CAF50; color: white;"> No RM</th>
			<th style="background-color: #4CAF50; color: white;"> No REG</th>
			<th style="background-color: #4CAF50; color: white;"> No Faktur</th>
			<th style="background-color: #4CAF50; color: white;"> Pasien</th>
			<th style="background-color: #4CAF50; color: white;"> Dokter</th>
			<th style="background-color: #4CAF50; color: white;"> Analis</th>
			<th style="background-color: #4CAF50; color: white;"> Status Rawat </th>
			<th style="background-color: #4CAF50; color: white;"> Tanggal </th>
			<th style="background-color: #4CAF50; color: white;"> Detail </th>
		</thead>
		<tbody>
			

		</tbody>

	</table>
</span>
 <h6 style="text-align: left ; color: red"><i>* Bisa Cetak Jika Input Hasil Sudah Selesai dan Penjualan Sudah Selesai ( No Faktur Tidak Kosong ) !!</i></h6>
 <h6 style="text-align: left ; color: red"><i>* Detail Laboratorium Akan Tampil Jika Sudah Melakukan Penjualan !!</i></h6>
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
              $(nRow).attr('class','tr-id-'+aData[11]+'');
            },
        } );
      } );
    </script>
<!--end ajax datatable-->


<script type="text/javascript">
$(document).ready(function () {
$(document).on('click', '.detail-lab', function (e) {

		var no_faktur = $(this).attr('data-faktur');

		
		$("#modal_detail").modal('show');
		
		$.post('show_hasil_lab.php',{no_faktur:no_faktur},function(info) {
		
		$("#modal-detail").html(info);
		
		
		});
		
		});
		});
</script>


<?php include 'footer.php'; ?>