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

<table id="table_show_kelas" class="table table-bordered table-sm">
		<thead> 
			
			<th> Nama Kelas </th>
			<th> Hapus </th>
			<th> Edit </th>
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
					
<script>
    $(document).ready(function(){

//fungsi untuk menambahkan data
		$("#submit_tambah").click(function(){
		var nama = $("#nama").val();

		if (nama == "")
		{
			alert("Nama Harus Diisi");
		}
		else 
		{
			$.post('proses_kelas_kamar.php',{nama:nama},function(data){

		if (data != '') {
		$("#nama").val('');

		$(".alert").show('fast');
		      $("#tbody").prepend(data);

		setTimeout(tutupalert, 2000);
		$(".modal").modal("hide");
		}
		
		
		});										
									}

		function tutupmodal() {
		
		}		
		
		});

// end fungsi tambah data


	
//fungsi hapus data 
		$(".btn-hapus").click(function(){
		var nama = $(this).attr("data-nama");
		var id = $(this).attr("data-id");

		$("#nama_hapus").val(nama);
		$("#id_hapus").val(id);

		$("#modal_hapus").modal('show');
		
		
		});


		$("#btn_jadi_hapus").click(function(){
		
		var id = $("#id_hapus").val();

		$.post("delete_kelas_kamar.php",{id:id},function(data){

		if (data != "") {
		$("#modal_hapus").modal('hide');
		 $(".tr-id-"+id).remove();

		}

		
		});
		
		});
// end fungsi hapus data

//fungsi edit data 
		$(".btn-edit").click(function(){
		
		$("#modal_edit").modal('show');
		var nama = $(this).attr("data-nama"); 
		var id  = $(this).attr("data-id");
		$("#nama_edit").val(nama);
		$("#id_edit").val(id);
		
		
		});
		
		$("#submit_edit").click(function(){
		var nama = $("#nama_edit").val();
		var id = $("#id_edit").val();

		if (nama == ""){
			alert("Nama Harus Diisi");
		}
		else {

		$.post("update_kelas_kamar.php",{id:id,nama:nama},function(data){
		if (data != '') {
		$(".alert").show('fast');
		           window.location.href="kelas_kamar.php";

		setTimeout(tutupalert, 2000);
		$(".modal").modal("hide");
		}
		
		
		});
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
  $(table).dataTable({ordering :false });
  });

</script>
