<?php include 'session_login.php';
include 'header.php';
include 'navbar.php';
include 'db.php';
include 'sanitasi.php';


$waktu = date('Y-m-d H:i:s');
$user_input = $_SESSION['nama'];
$session_id = session_id();
$no_reg = stringdoang($_GET['no_reg']);
$sub_or_before = stringdoang($_GET['sub_operasi']);
$or_utama = stringdoang($_GET['operasi']);
$id = stringdoang($_GET['id']);


?>

<div class="container">


<!-- Modal Untuk Confirm Delete-->
<div id="modale-delete" class="modal fade" role="dialog">
  <div class="modal-dialog">
    <!-- Modal content-->
    <div class="modal-content">
    <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>       
    </div>
    <div class="modal-body">
      <center><h4>Apakah Anda Yakin Ingin Menghapus Data Ini ?</h4></center>

      <input type="hidden" id="id_edit" name="id_edit">

    </div>
    <div class="modal-footer">
        <button type="submit" data-id="" class="btn btn-success" id="yesss" >Yes</button>
        <button type="button" class="btn btn-danger" data-dismiss="modal">No</button>
    </div>
    </div>
  </div>
</div>
<!--modal end Confirm Delete-->


<h3><b>Pengisian Petugas Operasi</b></h3>	

<form role="form" method="POST">
<div class="row">

<div class="col-sm-4"><!--col-sm-1-->

 <div class="form-group">
	<label for="sel1">Detail Operasi</label>
	<select class="form-control chosen" id="detail_operasi" name="detail_operasi" autocomplete="off" required="">
		  <option value="">Pilih Detail Operasi</option>
		  <?php 
		  // menampilkan seluruh data yang ada pada tabel suplier
		  $query_awal = $db->query("SELECT * FROM detail_operasi WHERE id_sub_operasi = '$sub_or_before'");
		  
		  // menyimpan data sementara yang ada pada $query
		  while($data_awal = mysqli_fetch_array($query_awal))
		  {
		  echo "<option value='".$data_awal['id_detail_operasi'] ."'>".$data_awal['nama_detail_operasi'] ."</option>";
		  }
		  ?>
	</select>
</div>


</div><!--col-sm-1-->

<div class="col-sm-4"><!--col-sm-2-->
<div class="form-group">
		 <label for="sel1">Petugas</label>
		<select class="form-control chosen" id="petugas" name="petugas" autocomplete="off" required="">
		  <?php 
		  // menampilkan seluruh data yang ada pada tabel suplier
		  $query = $db->query("SELECT * FROM user");
		  
		  // menyimpan data sementara yang ada pada $query
		  while($data = mysqli_fetch_array($query))
		  {
		  echo "<option value='".$data['id'] ."'>".$data['nama'] ."</option>";
		  }
		  ?>
		  </select>
		  </div>
</div><!--col-sm-2-->


</div><!--closed row-->
<button id="submit_tmbh" class="btn btn-info"><i class="fa fa-plus"></i> Tambah</button>

<!--hiddden-->
<div class="form-group">
<input type="hidden" class="form-control" name="session_id" id="session_id" value="<?php echo $session_id ?>" readonly="">
<input type="hidden" class="form-control" name="no_reg" id="no_reg" value="<?php echo $no_reg ?>" readonly="">
<input type="hidden" class="form-control" name="sub_opr_before" id="sub_opr_before" value="<?php echo $sub_or_before ?>" readonly="">

<input type="hidden" class="form-control" name="id_before" id="id_before" value="<?php echo $id ?>" readonly="">
<input type="hidden" class="form-control" name="or_utama" id="or_utama" value="<?php echo $or_utama ?>" readonly="">

</div>
<!-- end hidden-->


</form>



<!--Start Table Detail Operasi-->
<div class="card card-block">
<h3><b><center>Data Detail Operasi</center></b></h3>
<span id="table_baru">  
<div class="table-responsive">
  <table id="table-pelamar" class="table table-bordered table-sm">
 
	<thead>
	  <tr>

		  <th style='background-color: #4CAF50; color: white'>No REG </th>
		  <th style='background-color: #4CAF50; color: white'>Operasi</th>
		  <th style='background-color: #4CAF50; color: white'>Petugas Operasi</th>
		  <th style='background-color: #4CAF50; color: white'>Petugas Input</th>
		  <th style='background-color: #4CAF50; color: white'>Waktu</th>
		  <th style='background-color: #4CAF50; color: white'>Hapus</th>

	</tr>
	</thead>
	<tbody id="tbody">
	
   <?php 
   $query = $db->query("SELECT * FROM tbs_detail_operasi WHERE (no_reg = '$no_reg' AND id_sub_operasi = '$sub_or_before' AND id_tbs_operasi = '$id') OR (no_reg = '$no_reg' AND id_sub_operasi = '$sub_or_before' )");
   while($data = mysqli_fetch_array($query))      
	  {
       // menampilkan seluruh data yang ada pada tabel suplier
		  $show_nama_detail_operasi = $db->query("SELECT * FROM detail_operasi WHERE id_detail_operasi = '$data[id_detail_operasi]'");
		  
		  // menyimpan data sementara yang ada pada $query
		  while($show_nama = mysqli_fetch_array($show_nama_detail_operasi))
		  {
		  	$namanya = $show_nama['nama_detail_operasi'];
		  }

		  // nama user
		   $select_user = $db->query("SELECT nama,id FROM user ");
      	while($use = mysqli_fetch_array($select_user))
      	{
        if ($data['petugas_input'] == $use['id'])
        {
        $nama_user = $use['nama'];
        }
      	}

	// nama user operasi
	 $petugs = $db->query("SELECT nama,id FROM user ");
      while($use_pt = mysqli_fetch_array($petugs))
      {
        if ($data['id_user'] == $use_pt['id'])
        {
        $nama_pt_or = $use_pt['nama'];
        }
      }

	  echo "<tr class='tr-id-".$data['id']."'>

				<td>". $data['no_reg']."</td>
				<td>". $namanya."</td>
				<td>". $nama_pt_or."</td>
				<td>". $nama_user."</td>
				<td>". $data['waktu']."</td>

	  <td><button data-id='".$data['id']."' class='btn btn-danger delete'><i class='fa fa-trash'></i>  </button>
	  </td>
	  </tr>";
	  }

mysqli_close($db); 

	?>
  </tbody>
 </table>
 </div>
</span>
</div>
<!--Ending Table Detail Operasi-->
<h6 style="text-align: left ; color: red"><i> * Jika Detail Operasi Kosong, Silahkan Cek Detail Master Data Operasi Tersebut !!</i></h6>

</div><!-- div closed container-->



<!--Start Script Tambah-->
<script type="text/javascript">
  $("#submit_tmbh").click(function(){

// in form
  var detail_operasi = $("#detail_operasi").val();
  var petugas = $("#petugas").val();

// in hidden
  var id_before = $("#id_before").val();
  var sub_before = $("#sub_opr_before").val();
  var no_reg = $("#no_reg").val();
  var session_id = $("#session_id").val();
  var or_utama = $("#or_utama").val();
// post proses

if (detail_operasi == '')
{
	alert("Detail Operasi Anda Kosong, Cek Detail Operasi Tersebut di Master Data !!");
}
else
{
  $.post('registrasi_tbs_operasi.php',{or_utama:or_utama,id_before:id_before,session_id:session_id,detail_operasi:detail_operasi,petugas:petugas,no_reg:no_reg,sub_before:sub_before},function(data)
  {
  
  $("#tbody").prepend(data);
  
  });

}
});
            
   $('form').submit(function(){
    return false;
    });

</script>
<!--Ending Script Tambah-->


    <script type="text/javascript">
      
      $(".chosen").chosen({no_results_text: "Maaf, Data Tidak Ada!"});  
      
      </script>

<script>

$(document).ready(function(){
    $('.table').DataTable();
});

</script>


<!--   script modal confirmasi delete -->
<script type="text/javascript">
$(".delete").click(function(){

  var id = $(this).attr('data-id');

  $("#modale-delete").modal('show');
  $("#id_edit").val(id);  

});


</script>
<!--   end script modal confiormasi dellete -->


<!--  script modal  lanjkutan confiormasi delete -->
<script type="text/javascript">
$("#yesss").click(function(){

var id = $("#id_edit").val();

$.post('delete_reg_detail_operasi.php',{id:id},function(data){
    
      $("#modale-delete").modal('hide');
      $(".tr-id-"+id+"").remove();
  

    });

});
</script>
<!--  end modal confirmasi delete lanjutan  -->




<?php include 'footer.php'; ?>


