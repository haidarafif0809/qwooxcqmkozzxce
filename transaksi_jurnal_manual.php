<?php include 'session_login.php';

include 'header.php';
include 'navbar.php';
include 'db.php';

//menampilkan seluruh data yang ada pada tabel jabatan
$query = $db->query("SELECT * FROM jurnal_trans WHERE jenis_transaksi = 'Jurnal Manual'  GROUP BY no_faktur");

$session_id = session_id();

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

<div class="container"><!--tag yang digunakan untuk membuat tampilan form menjadi rapih dalam satu tempat-->

<h3><b> DATA TRANSAKSI JURNAL </b></h3> <hr>

<?php
include 'db.php';

$pilih_akses_akuntansi = $db->query("SELECT * FROM otoritas_laporan WHERE id_otoritas = '$_SESSION[otoritas_id]'");
$akuntansi = mysqli_fetch_array($pilih_akses_akuntansi);

if ($akuntansi['transaksi_jurnal_manual_tambah'] > 0) {
// Trigger the modal with a button -->
echo '<a href="form_transaksi_jurnal_manual.php" class="btn btn-info" > <i class="fa fa-plus">  </i> Jurnal Manual </a>';
}
?>

<span id="tombol_span_filter">
  <button class="btn btn-primary" type="button" data-toggle="collapse" data-target="#collapseExample" aria-expanded="false" aria-controls="collapseExample"><i class='fa fa-filter'> </i>
  Filter Pencarian  </button>
</span>

<span id="tombol_span_filter_2" style="display: none">
  <button class="btn btn-purple" type="button" data-toggle="collapse" data-target="#collapseExample" aria-expanded="false" aria-controls="collapseExample"><i class='fa fa-filter'> </i>
  Filter Pencarian  </button>
</span>
<br>
<br>

 <div class="collapse" id="collapseExample">

    <div class="row">
      <div class="col-sm-2">
        <label>Dari Tanggal</label>
        <input style="height: 15px;" type="text" class="form-control" id="dari_tanggal" name="dari_tanggal" autocomplete="off"  >
      </div>
      <div class="col-sm-2">
        <label>Sampai Tanggal</label>
        <input style="height: 15px;" type="text" class="form-control" id="sampai_tanggal" name="sampai_tanggal" autocomplete="off" value="<?php echo date("Y-m-d"); ?>" >
      </div> 
    <label><br><br><br></label>
        <button id="filter_cari" type="submit" class="btn btn-success"><i class='fa fa-search'> </i>&nbsp;Cari</button>

    </div>

 </div> <!--END collapseExample -->

<!-- Modal Hapus data -->
<div id="modal_hapus" class="modal fade" role="dialog">
  <div class="modal-dialog">



<!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title">Konfirmsi Hapus Data Jurnal Manual</h4>
      </div>

      <div class="modal-body">
   
   <p>Apakah Anda yakin Ingin Menghapus Data ini ?</p>
   <form >
    <div class="form-group">
     
     
     <label> Nomor Faktur :</label><br>
     <input type="text" id="jenis_transaksi" class="form-control" readonly="">  <br>

     <label> Jenis Transaksi :</label><br>
     <input type="text" id="no_jurnal" class="form-control" readonly="">


     <input type="hidden" id="id_hapus" class="form-control" > 
    </div>
   
   </form>
   
  <div class="alert alert-success" style="display:none">
   <strong>Berhasil!</strong> Data berhasil Di Hapus
  </div>
 

     </div>

      <div class="modal-footer">
        <button type="button" class="btn btn-info" data-id="" id="btn_jadi_hapus"> <span class='glyphicon glyphicon-ok-sign'> </span> Ya</button>
        <button type="button" class="btn btn-warning" data-dismiss="modal"> <span class='glyphicon glyphicon-remove-sign'> </span> Batal</button>
      </div>
    </div>

  </div>
</div><!-- end of modal hapus data  -->

<style>


tr:nth-child(even){background-color: #f2f2f2}

</style>

<div class="table-responsive"><!-- membuat agar ada garis pada tabel, disetiap kolom -->
<table id="table_jurnal_manual" class="table table-bordered table-sm">
		<thead> 	
    <?php if ($akuntansi['transaksi_jurnal_manual_hapus'] > 0) { ?>
			<th style='background-color: #4CAF50; color:white'> Hapus </th>
      <?php } ?>
      <?php if ($akuntansi['transaksi_jurnal_manual_edit'] > 0) { ?>
			<th style='background-color: #4CAF50; color:white'> Edit </th>	
      <?php } ?>
			<th style='background-color: #4CAF50; color:white'> Nomor Faktur </th>
			<th style='background-color: #4CAF50; color:white'> Jenis Transaksi</th>
			<th style='background-color: #4CAF50; color:white'> User Buat</th>
			<th style='background-color: #4CAF50; color:white'> User Edit</th>
			<th style='background-color: #4CAF50; color:white'> Waktu Jurnal </th>
			<th style='background-color: #4CAF50; color:white'> Keterangan Jurnal </th>

		</thead>

	</table>
</div>
</div> <!-- tag penutup cantainer -->


							
<script>
    $(document).ready(function(){

	
//fungsi hapus data 
      $(document).on('click', '.btn-hapus', function (e){
		var nomor_jurnal = $(this).attr("data-jurnal");
		var nomor_faktur = $(this).attr("data-faktur");
		var id = $(this).attr("data-id");
		$("#no_jurnal").val(nomor_jurnal);
		$("#jenis_transaksi").val(nomor_faktur);
		$("#modal_hapus").modal('show');
		$("#btn_jadi_hapus").attr("btn-id", id);
		
		
		});


      $(document).on('click', '#btn_jadi_hapus', function (e){
		
		var no_faktur = $("#jenis_transaksi").val();
		var id = $(this).attr("data-id");

		$.post("hapus_jurnal_trans.php",{id:id,no_faktur:no_faktur},function(data){

		if (data != "") {

    $('#table_jurnal_manual').DataTable().destroy();

        var dataTable = $('#table_jurnal_manual').DataTable( {
          "processing": true,
          "serverSide": true,
          "ajax":{
            url :"datatable_transaksi_jurnal_manual.php", // json datasource
            type: "post",  // method  , by default get
            error: function(){  // error handling
              $(".employee-grid-error").html("");
              $("#table_jurnal_manual").append('<tbody class="employee-grid-error"><tr><th colspan="3">Data Tidak Ditemukan.. !!</th></tr></tbody>');
              $("#employee-grid_processing").css("display","none");
              
            }
          },

          "fnCreatedRow": function( nRow, aData, iDataIndex ) {

              $(nRow).attr('class','tr-id-', aData[8]);

          }

        });    


		$("#modal_hapus").modal('hide');
		
		}

		
		});
		
		});
// end fungsi hapus data

									

		function tutupmodal() {
		
		}	
		});
		


		$('form').submit(function(){
		
		return false;
		});
		


		function tutupalert() {
		$(".alert").hide("fast")
		}
		

</script>


<script type="text/javascript" language="javascript" >
   $(document).ready(function() {
          $('#table_jurnal_manual').DataTable().destroy();

        var dataTable = $('#table_jurnal_manual').DataTable( {
          "processing": true,
          "serverSide": true,
          "ajax":{
            url :"datatable_transaksi_jurnal_manual.php", // json datasource
            type: "post",  // method  , by default get
            error: function(){  // error handling
              $(".employee-grid-error").html("");
              $("#table_jurnal_manual").append('<tbody class="employee-grid-error"><tr><th colspan="3">Data Tidak Ditemukan.. !!</th></tr></tbody>');
              $("#employee-grid_processing").css("display","none");
              
            }
          },

          "fnCreatedRow": function( nRow, aData, iDataIndex ) {

              $(nRow).attr('class','tr-id-', aData[8]);

          }

        });    
     
  });
 
 </script>


<script type="text/javascript" language="javascript" >
   $(document).ready(function() {
    $("#filter_cari").click(function(){
    
    var dari_tanggal = $("#dari_tanggal").val();
    var sampai_tanggal = $("#sampai_tanggal").val();
    if (dari_tanggal == '') {
      alert("Silakan isi kolom dari tanggal terlebih dahulu.");
      $("#dari_tanggal").focus();
    }
    else if (sampai_tanggal == '') {
      alert("silakan isi kolom sampai tanggal trlebih dahulu.");
      $("#sampai_tanggal").focus();
    }
    else {

        $('#table_jurnal_manual').DataTable().destroy();

        var dataTable = $('#table_jurnal_manual').DataTable( {
          "processing": true,
          "serverSide": true,
          "ajax":{
            url :"datatable_transaksi_jurnal_manual_periode.php", // json datasource
                   "data": function ( d ) {
                      d.dari_tanggal = $("#dari_tanggal").val();
                      d.sampai_tanggal = $("#sampai_tanggal").val();
                      // d.custom = $('#myInput').val();
                      // etc
                  },
            type: "post",  // method  , by default get
            error: function(){  // error handling
              $(".employee-grid-error").html("");
              $("#table_jurnal_manual").append('<tbody class="employee-grid-error"><tr><th colspan="3">Data Tidak Ditemukan.. !!</th></tr></tbody>');
              $("#employee-grid_processing").css("display","none");
              
            }
          },

          "fnCreatedRow": function( nRow, aData, iDataIndex ) {

              $(nRow).attr('class','tr-id-', aData[8]);

          }

        }); 
    }
   
     
  });
     
  });
 
 </script>

<script type="text/javascript">
  $("#tombol_span_filter").click(function(){
  $("#tombol_span_filter").hide();
  $("#tombol_span_filter_2").show();
  });
    
  $("#tombol_span_filter_2").click(function(){  
  $("#tombol_span_filter_2").hide();
  $("#tombol_span_filter").show();
  $("#dari_tanggal").val('');
  $("#sampai_tanggal").val('');

          $('#table_jurnal_manual').DataTable().destroy();

        var dataTable = $('#table_jurnal_manual').DataTable( {
          "processing": true,
          "serverSide": true,
          "ajax":{
            url :"datatable_transaksi_jurnal_manual.php", // json datasource
            type: "post",  // method  , by default get
            error: function(){  // error handling
              $(".employee-grid-error").html("");
              $("#table_jurnal_manual").append('<tbody class="employee-grid-error"><tr><th colspan="3">Data Tidak Ditemukan.. !!</th></tr></tbody>');
              $("#employee-grid_processing").css("display","none");
              
            }
          },

          "fnCreatedRow": function( nRow, aData, iDataIndex ) {

              $(nRow).attr('class','tr-id-', aData[8]);

          }

        });  

  });

</script>

<!-- memasukan file footer.db -->
<?php include 'footer.php'; ?>
