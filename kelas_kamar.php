<?php include 'session_login.php';


//memasukkan file session login, header, navbar, db.php
include 'header.php';
include 'navbar.php';
include 'db.php';

//menampilkan seluruh data yang ada pada tabel jabatan
$query = $db->query("SELECT * FROM kelas_kamar");

$pilih_akses_kelas_kamar = $db->query("SELECT kelas_kamar_tambah, kelas_kamar_edit, kelas_kamar_hapus FROM otoritas_master_data WHERE id_otoritas = '$_SESSION[otoritas_id]'");
$kelas_kamar = mysqli_fetch_array($pilih_akses_kelas_kamar);

 ?>
<div class="container">

 <h3><b> Data Kelas Kamar</b></h3> <hr>
<?php if ($kelas_kamar['kelas_kamar_tambah'] > 0): ?>
	<button type="button" class="btn btn-info" data-toggle="modal" data-target="#myModal"> <i class="fa fa-plus"> </i> Tambah Data </button>
<br><br>
<?php endif ?>


<!-- Modal tambah data -->
<div id="myModal" class="modal fade" role="dialog">
  	<div class="modal-dialog">

    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title"><center><b>Tambah Kelas Kamar</b></center></h4>
      </div>
    <div class="modal-body">
<form role="form">
					<div class="form-group">
					<label> Nama Kelas </label><br>
					<input type="text" name="nama" id="nama" class="form-control" autocomplete="off" required="" >
					</div>
					
					
					<button type="submit" id="submit_tambah" class="btn btn-success">Submit</button>
</form>

				
					<div class="alert alert-success" style="display:none">
					<strong>Berhasil!</strong> Data berhasil Di Tambah
					</div>

 	</div><!-- end of modal body -->

					<div class ="modal-footer">
					<button type ="button"  class="btn btn-default" data-dismiss="modal">Close</button>
					</div>
	</div>
	</div>

</div>
<!-- end of modal Tambah data  -->


<!-- Modal Hapus data -->
<div id="modal_hapus" class="modal fade" role="dialog">
  <div class="modal-dialog">



<!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title"><b><center>Konfirmsi Hapus Data Kelas Kamar</center></b></h4>
      </div>

      <div class="modal-body">
   
   <p>Apakah Anda yakin Ingin Menghapus Data ini ?</p>
   <form >
    <div class="form-group">
    <label> Nama Kelas Kamar :</label>
     <input type="text" id="nama_hapus" class="form-control" readonly=""> 
     <input type="hidden" id="id_hapus" class="form-control" > 
    </div>
   
   </form>
   
  <div class="alert alert-success" style="display:none">
   <strong>Berhasil!</strong> Data berhasil Di Hapus
  </div>
 

     </div>

      <div class="modal-footer">
        <button type="button" class="btn btn-info" id="btn_jadi_hapus"> <span class='glyphicon glyphicon-ok-sign'> </span> Ya</button>
        <button type="button" class="btn btn-warning" data-dismiss="modal"> <span class='glyphicon glyphicon-remove-sign'> </span> Batal</button>
      </div>
    </div>

  </div>
</div>
<!-- end of modal hapus data  -->


<!-- Modal edit data -->
<div id="modal_edit" class="modal fade" role="dialog">
  <div class="modal-dialog">

    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title">Edit Kelas Kamar</h4>
      </div>
      <div class="modal-body">
  <form role="form">
   <div class="form-group">
    <label for="email">Nama Kelas Kamar:</label>
     <input type="text" class="form-control" id="nama_edit" autocomplete="off">
     <input type="hidden" class="form-control" id="id_edit">
    
   </div>
   
   
   <button type="submit" id="submit_edit" data-nama="" class="btn btn-success">Submit</button>
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

<div class="table-responsive"><!-- membuat agar ada garis pada tabel, disetiap kolom -->
<span id="table_baru">
<table id="tableuser" class="table table-bordered table-sm">
		<thead> 
			
			<th style='background-color: #4CAF50; color: white'> Nama Kelas </th>
			<th style='background-color: #4CAF50; color: white'> Hapus </th>
			<th style='background-color: #4CAF50; color: white'> Edit </th>
		</thead>
		
		<tbody id="tbody">
		<?php
		// menyimpan data sementara yang ada pada $query
			while ($data = mysqli_fetch_array($query))
			{

$selcted = $db->query("SELECT kelas FROM bed WHERE kelas = '$data[id]' ");
$cancel = mysqli_num_rows($selcted);

			//menampilkan data
			echo "<tr class='tr-id-".$data['id']."'>

			<td>". $data['nama'] ."</td>";

if ($cancel == 0)
{



			if ($kelas_kamar['kelas_kamar_hapus'] > 0) {
				echo "<td> <button class='btn btn-danger btn-hapus ' data-id='". $data['id'] ."' data-nama='". $data['nama'] ."'>Hapus </button> </td>";
			}

			else{
				echo "<td> </td>";
			}

			if ($kelas_kamar['kelas_kamar_edit'] > 0) {
				echo "<td> <button class='btn btn-info btn-edit ' data-nama='". $data['nama'] ."' data-id='". $data['id'] ."'>  Edit </button> </td>";
			}
			else{
				echo "<td> </td>";
			}
}
else
{
	echo "<td> </td>
		  <td> </td>";

}

			echo "</tr>";
			}
	

	//Untuk Memutuskan Koneksi Ke Database
mysqli_close($db);   
		?>
		</tbody>

	</table>
</span>

</div><!--div responsive-->

</div><!--div counteiner-->

							
<script>
    $(document).ready(function(){

//fungsi untuk menambahkan data
	$(document).on('click','#submit_tambah',function(e){

		var nama = $("#nama").val();

		if (nama == "")
		{
			alert("Nama Harus Diisi");
		}
		else 
		{
// cek namanya
 $.post('cek_nama_kelas.php',{nama:nama}, function(data){

        if(data == 1){
          alert('Nama Kelas Sudah Ada!');
          $("#nama").val('');
          $("#nama").focus();
        }
        else{

// Start Proses
	$.post('proses_kelas_kamar.php',{nama:nama},function(data){

		if (data != '') {
		$("#nama").val('');

		$(".alert").show('fast');
		      $("#tbody").prepend(data);

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

		var nama = $(this).attr("data-nama");
		var id = $(this).attr("data-id");

		$("#nama_hapus").val(nama);
		$("#id_hapus").val(id);

		$("#modal_hapus").modal('show');
		
		
		});


		$("#btn_jadi_hapus").click(function(){
		
		var id = $("#id_hapus").val();

		$(".tr-id-"+id).remove();
		$.post("delete_kelas_kamar.php",{id:id},function(data){

		$("#modal_hapus").modal('hide');
		 


		
		});
		
		});
// end fungsi hapus data

//fungsi edit data 

		$(document).on('click','.btn-edit',function(e){

		$("#modal_edit").modal('show');
		var nama = $(this).attr("data-nama"); 
		var id  = $(this).attr("data-id");
		$("#nama_edit").val(nama);
		$("#id_edit").val(id);
		$("#submit_edit").attr("data-nama",nama);

		
		});
		
		$("#submit_edit").click(function(){
		var nama = $("#nama_edit").val();
		var id = $("#id_edit").val();
   		var as = $(this).attr("data-nama"); 

		if (nama == ""){
			alert("Nama Harus Diisi");
		}
		else {
			
// cek nama jika ada yang sama
		$.post('cek_nama_kelas.php',{nama:nama}, function(data){
        if(data == 1){
          alert('Nama Kelas Yang Anda Input Sudah Ada!');
          $("#nama_edit").val(as); // menampilkan NAMA yang sebelumnya
          $("#nama_edit").focus();
        }
        else{

// mulai proses edit
		$.post("update_kelas_kamar.php",{id:id,nama:nama},function(data){
		if (data != '') {
		$(".alert").show('fast');
		           window.location.href="kelas_kamar.php";

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

<script type="text/javascript">
	
  $(function () {
  $(".table").dataTable({ordering :false });
  });

</script>

<?php include 'footer.php' ?>