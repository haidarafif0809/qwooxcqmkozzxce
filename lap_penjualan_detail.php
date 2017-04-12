<?php include 'session_login.php';
//memasukkan file session login, header, navbar, db.php
include 'header.php';
include 'navbar.php';
include 'sanitasi.php';
include 'db.php';


 ?>

 
<style>

tr:nth-child(even){background-color: #f2f2f2}

</style>

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

 <div class="container">

<h3>LAPORAN PENJUALAN DETAIL </h3><hr>
<form id="perhari" class="form" role="form">
				
  <div class="form-group col-sm-2">
    <select name="closing" id="closing" autocomplete="off" class="form-control chosen" >
    <option value="" style="display: none">Status Penjualan</option>
      <optgroup label="Status Penjualan">
        <option value="semua">Semua</option>
        <option value="sudah">Sudah Closing</option>
        <option value="belum">Belum Closing</option>
      </optgroup>
    </select>
  </div>

  <div class="col-sm-2"> 
    <input style="height: 17px;" type="text" name="dari_tanggal" id="dari_tanggal" autocomplete="off" class="form-control tanggal_cari" placeholder="Dari Tanggal" >
  </div>

  <div class="col-sm-2"> 
      <input style="height: 17px" type="text" name="sampai_tanggal" id="sampai_tanggal" autocomplete="off" class="form-control tanggal_cari" placeholder="Sampai Tanggal" value="<?php echo date("Y-m-d"); ?>" >
  </div>

  <button type="submit" name="submit" id="submit" class="btn btn-primary" ><i class="fa fa-eye"> </i> Tampil </button>

</form>
<div class="card card-block">
			<div class="table-responsive"><!--membuat agar ada garis pada tabel disetiap kolom-->
				<span id="span_lap">
					<table id="tabel_lap" class="table table-bordered table-sm">
						<thead>
							
							<th style="background-color: #4CAF50; color: white;"> Nomor Faktur </th>
							<th style="background-color: #4CAF50; color: white;"> Kode Barang </th>
							<th style="background-color: #4CAF50; color: white;"> Nama Barang </th>
							<th style="background-color: #4CAF50; color: white;"> Jumlah  </th>
							<th style="background-color: #4CAF50; color: white;"> Satuan </th>
							<th style="background-color: #4CAF50; color: white;"> Harga </th>
							<th style="background-color: #4CAF50; color: white;"> Potongan </th>
							<th style="background-color: #4CAF50; color: white;"> Tax </th>
              <th style="background-color: #4CAF50; color: white;"> Subtotal </th>			
						
						</thead>

					</table>
				</span>
			</div> <!--/ responsive-->
</div>

<span id="cetak" style="display: none;">
  <a href='cetak_lap_penjualan_detail.php' target="blank" id="cetak_lap" class='btn btn-success'><i class='fa fa-print'> </i> Cetak Laporan</a>
</span>

</div> <!--/ container-->



<script type="text/javascript">
$(document).ready(function() {
$(document).on('click','#submit',function(e){


     var sampai_tanggal = $("#sampai_tanggal").val();
     var dari_tanggal = $("#dari_tanggal").val();  
     var closing = $("#closing").val();  

     if (closing == '') {
      alert("Silakan Isi Kolom Status Penjualan Terlebih Dahulu");
      $("#closing").trigger('chosen:open');
     }
     else if (dari_tanggal == '') {
      alert("Silakan Isi Kolom Dari Tanggal Terlebih Dahulu");
      $("#dari_tanggal").focus();
     }
     else if (sampai_tanggal == '') {
      alert("Silakan Isi Kolom Sampai Tanggal Terlebih Dahulu");
      $("#sampai_tanggal").focus();
     }
	else{
    //untuk tampilkan table kas MUTASI MASUK detail
     $('#tabel_lap').DataTable().destroy();
          var dataTable = $('#tabel_lap').DataTable( {
          "processing": true,
          "serverSide": true,
          "info":     true,
          "language": {
          "emptyTable":     "My Custom Message On Empty Table"},
          "ajax":{
            url :"proses_lap_penjualan_detail.php", // json datasource
             "data": function ( d ) {
                d.dari_tanggal = $("#dari_tanggal").val();
                d.sampai_tanggal = $("#sampai_tanggal").val();
                d.closing = $("#closing").val();
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
  $("#cetak_lap").attr("href", "cetak_lap_penjualan_detail.php?closing="+closing+"&dari_tanggal="+dari_tanggal+"&sampai_tanggal="+sampai_tanggal+"");
  }
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

<script type="text/javascript">
  $(".chosen").chosen({no_results_text: "Maaf, Data Tidak Ada!",search_contains:true}); 
</script>

<?php 
include 'footer.php';
 ?>