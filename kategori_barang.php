<?php include 'session_login.php';

	include 'header.php';
	include 'navbar.php';
	include 'sanitasi.php';
	include 'db.php';

	$query = $db->query("SELECT * FROM kategori");
	
?>

<style>
tr:nth-child(even){background-color: #f2f2f2}
</style>

<div class="container">
<!-- Modal tambah data -->


<div id="myModal" class="modal fade" role="dialog">
  <div class="modal-dialog">

    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title">Tambah Kategori Item </h4>
      </div>
      <div class="modal-body">
<form role="form">

					<div class="form-group">
					<label> Nama Kategori </label><br>
					<input type="text" name="nama_kategori" id="nama_kategori" class="form-control" autocomplete="off" required="" >
					</div>

   
   
   					<button type="Tambah" id="submit_tambah" class="btn btn-success"><span class='glyphicon glyphicon-plus'> </span> Tambah</button>
</form>
				
				<div class="alert alert-success" style="display:none">
				<strong>Berhasil!</strong> Data berhasil Di Tambah
				</div>
  </div>
				<div class ="modal-footer">
				<button type ="button"  class="btn btn-default" data-dismiss="modal">Close</button>
				</div>
  </div>

  </div>
</div><!-- end of modal buat data  -->


<!-- Modal Hapus data -->
<div id="modal_hapus" class="modal fade" role="dialog">
  <div class="modal-dialog">



    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title">Konfirmasi Hapus Kategori Item</h4>
      </div>

      <div class="modal-body">
   
   <p>Apakah Anda yakin Ingin Menghapus Data ini ?</p>
   <form >
    <div class="form-group">
    <label> Nama Kategori Item :</label>
     <input type="text" id="data_kategori" class="form-control" readonly=""> 
     <input type="hidden" id="id_hapus" class="form-control" > 
    </div>
   
   </form>
   
  <div class="alert alert-success" style="display:none">
   <strong>Berhasil!</strong> Data berhasil Di Hapus
  </div>
 

     </div>

      <div class="modal-footer">
        <button type="button" class="btn btn-info" id="btn_jadi_hapus"> <span class='glyphicon glyphicon-ok-sign'> </span>Ya</button>
        <button type="button" class="btn btn-warning" data-dismiss="modal"><span class='glyphicon glyphicon-remove-sign'> </span>Batal</button>
      </div>
    </div>

  </div>
</div><!-- end of modal hapus data  -->




<!-- Modal edit data -->
<div id="modal_edit" class="modal fade" role="dialog">
  <div class="modal-dialog">

    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title">Edit Nama Kategori Item</h4>
      </div>
      <div class="modal-body">
  <form role="form">
   <div class="form-group">
    <label for="email">Nama Kategori Item:</label>
     <input type="text" class="form-control" id="kategori_edit" autocomplete="off">
     <input type="hidden" class="form-control" id="id_edit">
    
   </div>
   
   
   <button type="submit" id="submit_edit" data-nama="" class="btn btn-primary">Submit</button>
  </form>
  <div class="alert alert-success" style="display:none">
   <strong>Berhasil!</strong> Data Berhasil Di Edit
  </div>
 

      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
      </div>
    </div>

  </div>
</div><!-- end of modal edit data  -->

<h3><b>DATA KATEGORI</b></h3><hr>

<?php
include 'db.php';

$pilih_akses_otoritas = $db->query("SELECT kategori_tambah FROM otoritas_master_data WHERE id_otoritas = '$_SESSION[otoritas_id]' AND kategori_tambah = '1'");
$otoritas = mysqli_num_rows($pilih_akses_otoritas);

    if ($otoritas > 0) {
echo '<button type="button" class="btn btn-info " data-toggle="modal" data-target="#myModal"><i class="fa fa-plus"> </i> KATEGORI</button>';

}
?>
<br><br>


<div class="table-responsive"><!-- membuat agar ada garis pada tabel, disetiap kolom -->
<span id="table_baru">
<table id="table_kategori" class="table table-bordered table-sm">
		<thead> 
			
			<th style="background-color: #4CAF50; color: white"> Nama Kategori </th>
			<th style="background-color: #4CAF50; color: white"> Hapus </th>
			<th style="background-color: #4CAF50; color: white"> Edit </th>		
			
		</thead>
		
	</table>
</span>
</div>

</div>




<script>
    $(document).ready(function(){

//fungsi untuk menambahkan data
 $(document).on('click','#submit_tambah',function(e){

		var nama = $("#nama_kategori").val();

		if (nama == ""){
			alert("Nama Harus Diisi");
		}
		
		else {
		
		// cek namanya
 $.post('cek_nama_kategori_barang.php',{nama:nama}, function(data){

        if(data == 1){
          alert('Nama Yang Anda Masukkan Sudah Ada!');
          $("#nama_kategori").val('');
          $("#nama_kategori").focus();
        }
        else{

// Start Proses
   $.post('proses_tambah_kategori.php',{nama:nama},function(data){

		if (data != '') {
		$("#nama_kategori").val('');

		$(".alert").show('fast');
 var table_kategori = $('#table_kategori').DataTable();
        table_kategori.draw();
		
		setTimeout(tutupalert, 2000);
		$(".modal").modal("hide");
		}
		
		
		});
// Finish Proses
        }

      }); // end post dari cek nama


	}

		function tutupmodal() {
		
		}		
		
		});

// end fungsi tambah data


	
//fungsi hapus data 
		$(document).on('click','.btn-hapus',function(e){
		var nama = $(this).attr("data-kategori");
		var id = $(this).attr("data-id");
		$("#data_kategori").val(nama);
		$("#id_hapus").val(id);
		$("#modal_hapus").modal('show');
		
		
		});


		$("#btn_jadi_hapus").click(function(){
		
		var id = $("#id_hapus").val();
		$(".tr-id-"+id).remove();
		$("#modal_hapus").modal('hide');
		$.post("hapus_kategori.php",{id:id},function(data){

		});
		
		});
// end fungsi hapus data

//fungsi edit data 
    $(document).on('click','.btn-edit',function(e){

		$("#modal_edit").modal('show');
		var nama = $(this).attr("data-kategori"); 
		var id  = $(this).attr("data-id");
		$("#kategori_edit").val(nama);
		$("#id_edit").val(id);
		$("#submit_edit").attr("data-nama",nama);

		
		});
		
		$("#submit_edit").click(function(){
		var nama = $("#kategori_edit").val();
		var id = $("#id_edit").val();
    	var show_name = $(this).attr("data-nama"); 

		if (nama == ""){
			alert("Nama Harus Diisi");
		}
		else {
// cek namanya
 $.post('cek_nama_kategori_barang.php',{nama:nama}, function(data){
        if(data == 1){
          alert('Nama yang anda masukan sudah ada!');
          $("#kategori_edit").val(show_name); // menampilkan NAMA yang sebelumnya
          $("#kategori_edit").focus();
        }
        else{

// mulai proses edit
$.post("update_kategori.php",{id:id,nama:nama},function(data){
		if (data == 1) {
		$(".alert").show('fast');
 var table_kategori = $('#table_kategori').DataTable();
        table_kategori.draw();
		
		setTimeout(tutupalert, 2000);
		$(".modal").modal("hide");
		}
		
		
		});
// end proses edit

        }

      }); // end post dari cek nama
		

		}
									

		function tutupmodal() {
		
		}	
		});
		


//end function edit data

		$('form').submit(function(){
		
		return false;
		});
		
		});
		
		
		

		function tutupalert() {
		$(".alert").hide("fast")
		}
</script>

<!--datatable menggunakan  ajax-->
<script type="text/javascript" language="javascript" >
      $(document).ready(function() {
        var dataTable = $('#table_kategori').DataTable( {
          "processing": true,
          "serverSide": true,
          "ajax":{
            url :"datatable_kategori_barang.php", // json datasource
            type: "post",  // method  , by default get
            error: function(){  // error handling
              $(".tbody").html("");
              $("#table_kategori").append('<tbody class="tbody"><tr ><td colspan="3">No data found in the server</td></tr></tbody>');
              $("#table_ri_processing").css("display","none");
              
            }
          },

           "fnCreatedRow": function( nRow, aData, iDataIndex ) {
              $(nRow).attr('class','tr-id-'+aData[3]+'');

},
        } );
      } );
    </script>

<?php include 'footer.php'; ?>
