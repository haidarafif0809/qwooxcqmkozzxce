<?php include 'session_login.php';
include 'header.php';
include 'navbar.php';
include 'db.php';
include 'sanitasi.php';

$id_sub_operasi = stringdoang($_GET['id']);
       
$nama = stringdoang($_GET['nama_operasi']);
$kelas = stringdoang($_GET['kelas']);
$cito = stringdoang($_GET['cito']);
$harga = stringdoang($_GET['harga_jual']);
$id_operasi = stringdoang($_GET['id_operasi']);


$pilih_akses_detail_sub_operasi = $db->query("SELECT detail_sub_operasi_tambah, detail_sub_operasi_edit, detail_sub_operasi_hapus, detail_sub_operasi_lihat FROM otoritas_master_data WHERE id_otoritas = '$_SESSION[otoritas_id]'");
$detail_sub_operasi = mysqli_fetch_array($pilih_akses_detail_sub_operasi); 

 ?>
 <div class="container">
 	


<!-- Modal Tambah Operasi -->
  <div class="modal fade" id="modal" role="dialog">
    <div class="modal-dialog">
    <!-- Modal content-->
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal">&times;</button>
          <h4 class="modal-title">Form Tambah Detail Operasi</h4>
        </div>
        <div class="modal-body">

          <form role="form" method="POST">

<div class="form-group">
  <label for="sel1">Nama Detail Operasi</label>
  <input type="text" style="height: 20px;" class="form-control" id="nama_operasi" name="nama_operasi" autocomplete="off">

  <input type="hidden" style="height: 20px;" value="<?php echo $id_sub_operasi; ?>" readonly=""class="form-control" id="id_sub_operasi" name="id_sub_operasi" autocomplete="off">

    <input type="hidden" style="height: 20px;" value="<?php echo $id_operasi; ?>" readonly=""class="form-control" id="id_operasi" name="id_sub_operasi" autocomplete="off">

</div>

<div class="form-group">
  <label for="sel1">Nama Jabatan</label>
  <select class="form-control" id="jabatan" name="jabatan" autocomplete="off" required="">
          <?php 
          // menampilkan seluruh data yang ada pada tabel suplier
          $query = $db->query("SELECT id,nama FROM jabatan");
          
          // menyimpan data sementara yang ada pada $query
          while($data = mysqli_fetch_array($query))
          {
          echo "<option value='".$data['id'] ."'>".$data['nama'] ."</option>";
          }
          ?>
          </select>
</div>

<div class="form-group">
  <label for="sel1">Jumlah Persentase</label>
  <input type="text" style="height: 20px;" class="form-control" id="persentase" name="persentase" autocomplete="off">
</div>


<button id="submit_tmbh" class="btn btn-info"><i class="fa fa-plus"></i> Tambah</button>
</form>

</div>
    <div class="modal-footer">
        <button type="button" class="btn btn-warning" data-dismiss="modal">Close</button>
        </div>
      </div>
    </div>
  </div>
<!--End Modal Tambah Operasi-->


<!-- Modal Untuk Confirm Delete-->
<div id="modale-delete" class="modal fade" role="dialog">
  <div class="modal-dialog">
    <!-- Modal content-->
    <div class="modal-content">
    <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button> 
              <center><h3><b>Anda Yakin Ingin Menghapus Data Ini ?</b></h3></center> 
    </div>
    <div class="modal-body">

<div class="form-group">
  <label for="sel1">Nama Detail Operasi</label>
  <input type="text" style="height: 20px;" class="form-control" readonly="" id="nama_delete" name="nama_delete" autocomplete="off">
</div>

      <input type="hidden" id="id_delete" name="id_delete">

    </div>
    <div class="modal-footer">
        <button type="submit" data-id="" class="btn btn-success" id="yesss" >Yes</button>
        <button type="button" class="btn btn-danger" data-dismiss="modal">No</button>
    </div>
    </div>
  </div>
</div>
<!--modal end Confirm Delete-->





<!-- Modal edit data -->
<div id="modal_edit" class="modal fade" role="dialog">
  <div class="modal-dialog">

    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title"><center><b>Edit Detail Operasi</b></center></h4>
      </div>
      <div class="modal-body">
  <form role="form">

   <div class="form-group">
    <label for="email">Nama Detail Operasi:</label>
     <input type="text" class="form-control" id="nama_edit" autocomplete="off" >
     <input type="hidden" class="form-control" id="id_edit" readonly="">
   </div>
   
<div class="form-group">
    <label for="email">Jabatan:</label>
     <select type="text" class="form-control" id="jabatan_edit" autocomplete="off">
    <?php 
          // menampilkan seluruh data yang ada pada tabel suplier
          $jabatannya = $db->query("SELECT id,nama FROM jabatan");
          
          // menyimpan data sementara yang ada pada $query
          while($out_jabatan = mysqli_fetch_array($jabatannya))
          {
          echo "<option value='".$out_jabatan['id'] ."'>".$out_jabatan['nama'] ."</option>";
          }
          ?>
          </select>
   </div>

 
   <div class="form-group">
    <label for="email">Persentase :</label>
     <input type="text" class="form-control" id="persentase_edit" autocomplete="off" >
   </div>

   <button type="submit" id="submit_edit" class="btn btn-success">Submit</button>
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
</div>
<!-- end of modal edit data  -->


<h3><b> Data Detail Operasi </b></h3> 

<table>
  <tr><td>Nama Operasi</td><td>:</td><td><?php echo $nama; ?></td></tr>
  <tr><td>Kelas Kamar</td><td>:</td><td><?php echo $kelas; ?></td></tr>
  <tr><td>Nama Cito</td><td>:</td><td><?php echo $cito; ?></td></tr>
  <tr><td>Harga Jual</td><td>:</td><td>Rp. <?php echo rp($harga); ?>,-</td></tr>

</table>


<hr>
<?php if ($detail_sub_operasi['detail_sub_operasi_tambah'] > 0): ?>
    <button type="button" class="btn btn-info" data-toggle="modal" data-target="#modal"><i class="fa fa-plus"> </i> Detail Operasi </button>
<br>
<br>
<?php endif ?>



<span id="table_baru">  
<div class="table-responsive">
  <table id="table-pelamar" class="table table-bordered table-sm">
 
    <thead>
      <tr>
          <th style='background-color: #4CAF50; color: white; width: 50%'>Nama Detail Operasi </th>
          <th style='background-color: #4CAF50; color: white; width: 50%'>Jabatan </th>
          <th style='background-color: #4CAF50; color: white; width: 50%'>Jumlah Persentase </th>
          <th style='background-color: #4CAF50; color: white'>Edit</th>
          <th style='background-color: #4CAF50; color: white'>Hapus</th>

    </tr>
    </thead>
    <tbody id="tbody">
    
   <?php 
   $query = $db->query("SELECT * FROM detail_operasi WHERE id_sub_operasi = '$id_sub_operasi'");
   while($data = mysqli_fetch_array($query))      
      {

      	 $seelect_op = $db->query("SELECT id,nama FROM jabatan");
        while($out_op = mysqli_fetch_array($seelect_op))
        {
          if($data['id_jabatan'] == $out_op['id'])
          {
            $jabatan = $out_op['nama'];
          }
          else
          {

          }
        }
        
      echo "<tr class='tr-id-".$data['id_detail_operasi']."'>

            <td>". $data['nama_detail_operasi'] ."</td>
            <td>". $jabatan ."</td>
            <td>". $data['jumlah_persentase'] ." %</td>";

if ($detail_sub_operasi['detail_sub_operasi_edit'] > 0) {
  echo "<td> <button class='btn btn-warning btn-edit' data-id='". $data['id_detail_operasi'] ."'
  data-nama='". $data['nama_detail_operasi'] ."' data-jabatan='". $data['id_jabatan'] ."' 
  data-persentase='". $data['jumlah_persentase'] ."'>
  <span class='glyphicon glyphicon-edit'> </span> Edit </button> </td>";
}
else{
  echo "<td> </td>";
}

if ($detail_sub_operasi['detail_sub_operasi_hapus'] > 0) {
  echo "<td> <button class='btn btn-danger delete' data-id='". $data['id_detail_operasi'] ."'
     data-nama='". $data['nama_detail_operasi'] ."'> <span class='glyphicon glyphicon-trash'> </span> Hapus </button> </td>";
}
     
echo "</tr>";
      }
    ?>
  </tbody>
 </table>
 </div>
</span>

 </div><!--div closed countainer-->




<!--Start Script Tambah-->
<script type="text/javascript">
    $(document).on('click','#submit_tmbh',function(e){

  var id_operasi = $("#id_operasi").val();
  var nama_operasi = $("#nama_operasi").val();
  var id_sub_operasi = $("#id_sub_operasi").val();
  var jabatan = $("#jabatan").val();
  var persentase = $("#persentase").val();
if(nama_operasi == '')
{
  alert("Nama Detail Operasi Harus Di isi");
  $("#nama_operasi").val('');
  $("#nama_operasi").focus();
}
else if(persentase == '')
{
  alert("persentase Harus Di isi");
  $("#persentase").val('');
  $("#persentase").focus();

}
else
{
  $("#modal").modal('hide');
  $.post('proses_detail_operasi.php',{id_operasi:id_operasi,persentase:persentase,jabatan:jabatan,nama_operasi:nama_operasi,id_sub_operasi:id_sub_operasi},function(data)
  {
    $("#nama_operasi").val('');
    $("#persentase").val('');
  
  $("#tbody").append(data);
  
  });
}

});
            
   $('form').submit(function(){
    return false;
    });

</script>
<!--Ending Script Tambah-->

<script>

$(document).ready(function(){
    $('.table').DataTable();
});

</script>


<script type="text/javascript">
$(document).ready(function(){
 $("#persentase").keyup(function(){

   var persentase = $("#persentase").val();
   if (persentase > 100)
   {
   	alert("Persentase tidak boleh lebih dari 100%");
   	$("#persentase").val('');
   	$("#persentase").focus();
   }
             


});
});
        
</script>



<script type="text/javascript">
$(document).ready(function(){
 $("#persentase_edit").keyup(function(){

   var persentase = $("#persentase_edit").val();
   if (persentase > 100)
   {
    alert("Persentase tidak boleh lebih dari 100%");
    $("#persentase_edit").val('');
    $("#persentase_edit").focus();
   }
             


});
});
        
</script>

<!--   script modal confirmasi delete -->
<script type="text/javascript">
    $(document).on('click','.delete',function(e){

  var id = $(this).attr('data-id');
  var nama = $(this).attr('data-nama');

  $("#modale-delete").modal('show');
  $("#id_delete").val(id);
  $("#nama_delete").val(nama);

});


</script>
<!--   end script modal confiormasi dellete -->


<!--  script modal  lanjkutan confiormasi delete -->
<script type="text/javascript">
 $(document).on('click','#yesss',function(e){
var id = $("#id_delete").val();

$.post('delete_detail_operasi.php',{id:id},function(data){
    
      $("#modale-delete").modal('hide');
      $(".tr-id-"+id+"").remove();
  
    });

});
</script>

<!-- Start Script Edit-->
<script type="text/javascript">
    $(document).on('click','.btn-edit',function(e){
		
		$("#modal_edit").modal('show');

		var id = $(this).attr("data-id"); 
		var nama  = $(this).attr("data-nama");
		var jabatan  = $(this).attr("data-jabatan");
		var persentase  = $(this).attr("data-persentase");

		$("#id_edit").val(id);
		$("#nama_edit").val(nama);
		$("#jabatan_edit").val(jabatan);
		$("#persentase_edit").val(persentase);
		
		
		});
		
    $(document).on('click','#submit_edit',function(e){

		var id = $("#id_edit").val();
		var nama = $("#nama_edit").val();
		var jabatan = $("#jabatan_edit").val();
		var persentase = $("#persentase_edit").val();
    var id_sub_operasi = '<?php echo $id_sub_operasi ?>';
		if (nama == '')
    {
      alert("Nama Detail Operasi Harus Di isi");
      $("#nama_edit").val('');
      $("#nama_edit").focus();
    }
    else if(persentase == '')
    {
      alert("persentase Harus Di isi");
      $("#persentase").val('');
      $("#persentase").focus();
    }
    else if(jabatan == '' || jabatan == '0')
    {
      alert("jabatan Harus Di Pilih Terlebih Dahulu");
      $("#jabatan_edit").focus();
    }
    else
    {
      $(".tr-id-"+id+"").remove()
    $("#modal_edit").modal("hide");
      
  		$.post("update_detail_operasi.php",{id:id,nama:nama,jabatan:jabatan,persentase:persentase,id_sub_operasi:id_sub_operasi},function(data){

      $("#tbody").prepend(data);
  			
  		
  		});
		}						

		function tutupmodal() {
		
		}	
		});
</script>
<!--Ending Script Edit-->

 <?php include 'footer.php'; ?>