<?php include 'session_login.php';
include 'header.php';
include 'navbar.php';
include 'db.php';
include 'sanitasi.php';

$id_operasi = stringdoang($_GET['id']);
$nama_operasi = stringdoang($_GET['nama']);

$pilih_akses_sub_operasi = $db->query("SELECT sub_operasi_tambah, sub_operasi_edit, sub_operasi_hapus, sub_operasi_lihat, detail_sub_operasi_lihat FROM otoritas_master_data WHERE id_otoritas = '$_SESSION[otoritas_id]'");
$sub_operasi = mysqli_fetch_array($pilih_akses_sub_operasi);       
          
 ?>
  <div class="container">


<!-- Modal Tambah Operasi -->
  <div class="modal fade" id="modal" role="dialog">
    <div class="modal-dialog">
    <!-- Modal content-->
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal">&times;</button>
          <h4 class="modal-title">Form Tambah Sub Operasi</h4>
        </div>
        <div class="modal-body">

          <form role="form" method="POST">

<div class="form-group">
  <label for="sel1">Nama Operasi</label>
  <input type="text" style="height: 20px;" value="<?php echo $nama_operasi; ?>" readonly=""class="form-control" id="nama_operasi" name="nama_operasi" autocomplete="off">

  <input type="hidden" style="height: 20px;" value="<?php echo $id_operasi; ?>" readonly=""class="form-control" id="id_operasi" name="id_operasi" autocomplete="off">
</div>

<div class="form-group">
  <label for="sel1">Nama Kelas Kamar</label>
  <select class="form-control" id="kelas_kamar" name="kelas_kamar" autocomplete="off" required="">
          <?php 
          // menampilkan seluruh data yang ada pada tabel suplier
          $query = $db->query("SELECT * FROM kelas_kamar");
          
          // menyimpan data sementara yang ada pada $query
          while($data = mysqli_fetch_array($query))
          {
          
          echo "<option value='".$data['id'] ."'>".$data['nama'] ."</option>";
          }
          
          
          ?>
          </select>
</div>

<div class="form-group">
  <label for="sel1">Nama Cito</label>
<select class="form-control" id="kelas_citu" name="kelas_citu" autocomplete="off" required="">
          <?php 
          // menampilkan seluruh data yang ada pada tabel suplier
          $query = $db->query("SELECT * FROM cito");
          
          // menyimpan data sementara yang ada pada $query
          while($data = mysqli_fetch_array($query))
          {
          echo "<option value='".$data['id'] ."'>".$data['nama'] ."</option>";
          }
          ?>
          </select>
</div>


<div class="form-group">
  <label for="sel1">Harga Jual</label>
  <input type="text" style="height: 20px;" class="form-control" id="harga_jual" name="harga_jual" autocomplete="off" onkeydown="return numbersonly(this, event);" onkeyup="javascript:tandaPemisahTitik(this);">
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

<!-- Modal edit data -->
<div id="modal_edit" class="modal fade" role="dialog">
  <div class="modal-dialog">

    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title">Edit Sub Operasi</h4>
      </div>
      <div class="modal-body">
  <form role="form">

   <div class="form-group">
    <label for="email">Nama Operasi:</label>
     <input type="text" class="form-control" id="op_edit" autocomplete="off" readonly="">
     <input type="hidden" class="form-control" id="sub_edit">
   </div>
   
<div class="form-group">
    <label for="email">Nama Kelas Kamar:</label>
     <select type="text" class="form-control" id="kelas_edit" autocomplete="off">
     <?php 
          // menampilkan seluruh data yang ada pada tabel suplier
          $query = $db->query("SELECT * FROM kelas_kamar");
          
          // menyimpan data sementara yang ada pada $query
          while($data = mysqli_fetch_array($query))
          {
          
          echo "<option value='".$data['id'] ."'>".$data['nama'] ."</option>";
          }
          
          
          ?>
          </select>
   </div>

   <div class="form-group">
    <label for="email">Nama Cito:</label>
     <select type="text" class="form-control" id="cito_edit" autocomplete="off">
       <?php 
          // menampilkan seluruh data yang ada pada tabel suplier
          $query = $db->query("SELECT * FROM cito");
          
          // menyimpan data sementara yang ada pada $query
          while($data = mysqli_fetch_array($query))
          {
          echo "<option value='".$data['id'] ."'>".$data['nama'] ."</option>";
          }
          ?>
          </select>
   </div>


<div class="form-group">
  <label for="sel1">Harga Jual</label>
  <input type="text" style="height: 20px;" class="form-control" id="harga_jual_edit" name="harga_jual_edit" autocomplete="off">
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
        <label>Nama Operasi</label>
        <input type="text" id="nama_operasi_delete" name="nama_cito_delete">

        <label>Kelas Kamar</label>
        <input type="text" id="kelas_delete" name="harga_jual_delete">

        <label>Nama Cito</label>
        <input type="text" id="nama_cito_delete" name="nama_cito_delete">
        <input type="hidden" id="id_delete" name="id2">

    </div>
    <div class="modal-footer">
        <button type="submit" data-id="" class="btn btn-success" id="yesss" >Yes</button>
        <button type="button" class="btn btn-danger" data-dismiss="modal">No</button>
    </div>
    </div>
  </div>
</div>
<!--modal end Confirm Delete-->

<h3><b> Data Sub Operasi </b></h3> (Nama Operasi : <?php echo $nama_operasi ?>) <hr>
<?php if ($sub_operasi['sub_operasi_tambah'] > 0): ?>
    <button type="button" class="btn btn-info" data-toggle="modal" data-target="#modal"><i class="fa fa-plus"> </i> Sub Operasi </button>
<br>
<br>
<?php endif ?>



<span id="table_baru">  
<div class="table-responsive">
  <table id="table-pelamar" class="table table-bordered table-sm">
 
    <thead>
      <tr>
          <th style='background-color: #4CAF50; color: white; width: 50%'>Nama Operasi </th>
          <th style='background-color: #4CAF50; color: white; width: 50%'>Nama Kelas Kamar </th>
          <th style='background-color: #4CAF50; color: white; width: 50%'>Nama Cito </th>
          <th style='background-color: #4CAF50; color: white; width: 50%'>Harga Jual </th>
          <th style='background-color: #4CAF50; color: white'>Detail Operasi</th>
          <th style='background-color: #4CAF50; color: white'>Edit</th>
          <th style='background-color: #4CAF50; color: white'>Hapus</th>

    </tr>
    </thead>
    <tbody id="tbody">
    
   <?php 
   $query = $db->query("SELECT * FROM sub_operasi WHERE id_operasi = '$id_operasi' ORDER BY id_operasi DESC");
   while($data = mysqli_fetch_array($query))      
      {

      	$seelect_op = $db->query("SELECT id_operasi,nama_operasi FROM operasi");
        while($out_op = mysqli_fetch_array($seelect_op))
        {
          if($data['id_operasi'] == $out_op['id_operasi'])
          {
            $nama_operasi = $out_op['nama_operasi'];
          }
        }

      	$select_kelas = $db->query("SELECT id,nama FROM kelas_kamar");
        while($out_kelas = mysqli_fetch_array($select_kelas))
        {
          if($data['id_kelas_kamar'] == $out_kelas['id'])
          {
            $kelas = $out_kelas['nama'];
          }
        }

$select_cito = $db->query("SELECT id,nama FROM cito");
        while($out_cito = mysqli_fetch_array($select_cito))
        {
          if($data['id_cito'] == $out_cito['id'])
          {
            $cito = $out_cito['nama'];
          }
        }

      echo "<tr class='tr-id-".$data['id_sub_operasi']."'>

            <td>". $nama_operasi ."</td>
            <td>". $kelas ."</td>
            <td>". $cito ."</td>
            <td> ". rp($data['harga_jual']) ."</td>";

if ($sub_operasi['detail_sub_operasi_lihat'] > 0) {
  echo "<td><a style='width:99px;' href='detail_operasi.php?id=".$data["id_sub_operasi"]."&nama_operasi=".$nama_operasi."&kelas=".$kelas."&cito=".$cito."&harga_jual=".$data["harga_jual"]."&id_operasi=".$data["id_operasi"]."' class='btn btn-success'>Detail Operasi </a></td>";
}
else{
  echo "<td> </td>";
}

if ($sub_operasi['sub_operasi_edit'] > 0) {
  echo "<td> <button class='btn btn-warning btn-edit' data-id-sub='". $data['id_sub_operasi'] ."' data-id-op='". $nama_operasi ."' data-id-kelas='". $data['id_kelas_kamar'] ."' data-id-cito='". $data['id_cito'] ."' data-harga='". $data['harga_jual'] ."'><span class='glyphicon glyphicon-edit'> </span> Edit </button> </td>";
}
else{
    echo "<td>  </td>";
}

if ($sub_operasi['sub_operasi_hapus'] > 0) {
  echo " <td> <button class='btn btn-danger delete' data-id='". $data['id_sub_operasi'] ."' data-kelas='". $kelas ."' data-namacit='". $cito ."' data-namaoper='". $nama_operasi ."'> <span class='glyphicon glyphicon-trash'> </span> Hapus </button> </td>";
}
else{
   echo " <td> </td>";
}

echo "</tr>";
      }
    ?>
  </tbody>
 </table>
 </div>
</span>
  </div><!--counteiner-->


<!--Start Script Tambah-->
<script type="text/javascript">
  $("#submit_tmbh").click(function(){
  var id_operasi = $("#id_operasi").val();
  var kelas_kamar = $("#kelas_kamar").val();
  var kelas_citu = $("#kelas_citu").val();
  var harga_jual = bersihPemisah(bersihPemisah(bersihPemisah(bersihPemisah($("#harga_jual").val()))));

  if(harga_jual == '')
  {
    alert("Harga jual harus anda isi !!");
    $("#harga_jual").focus();
  }
  else
  {


  $("#modal").modal('hide');
  $.post('proses_sub_operasi.php',{id_operasi:id_operasi,kelas_kamar:kelas_kamar,kelas_citu:kelas_citu,harga_jual:harga_jual},function(data){

      $("#harga_jual").val('');
  

  $("#tbody").prepend(data);
  $("#nama").val('');
  
  });
  }
});
            
   $('form').submit(function(){
    return false;
    });

</script>
<!--Ending Script Tambah-->

<!-- Start Script Edit-->
<script type="text/javascript">
	$(".btn-edit").click(function(){
		
		$("#modal_edit").modal('show');

		var sub = $(this).attr("data-id-sub"); 
		var op  = $(this).attr("data-id-op");
		var kelas  = $(this).attr("data-id-kelas");
		var cito  = $(this).attr("data-id-cito");
    var harga  = $(this).attr("data-harga");

		$("#sub_edit").val(sub);
		$("#op_edit").val(op);
		$("#kelas_edit").val(kelas);
		$("#cito_edit").val(cito);
    $("#harga_jual_edit").val(harga);
		
		
		});
		
		$("#submit_edit").click(function(){

		var sub = $("#sub_edit").val();
		var kelas = $("#kelas_edit").val();
		var cito = $("#cito_edit").val();
    var harga = $("#harga_jual_edit").val();
		
		$.post("update_sub_operasi.php",{sub:sub,kelas:kelas,cito:cito,harga:harga},function(data){
		if(data != '') 
		{

    $("#modal_edit").modal("hide");
		$(".alert").show('fast');
		$("#table_baru").load('show_sub_operasi.php');
		setTimeout(tutupalert, 2000);

		}
		
		
		});
	
									

		function tutupmodal() {
		
		}	
		});
</script>
<!--Ending Script Edit-->



<!--   script modal confirmasi delete -->
<script type="text/javascript">
$(".delete").click(function(){

  var id = $(this).attr('data-id');
  var nama = $(this).attr('data-namacit');
  var kelas = $(this).attr('data-kelas');
  var namaoper = $(this).attr('data-namaoper');


  $("#modale-delete").modal('show');
  $("#id_delete").val(id);
  $("#nama_cito_delete").val(nama);
  $("#kelas_delete").val(kelas);
  $("#nama_operasi_delete").val(namaoper);

});


</script>
<!--   end script modal confiormasi dellete -->


<!--  script modal  lanjkutan confiormasi delete -->
<script type="text/javascript">
$("#yesss").click(function(){

var id = $("#id_delete").val();

$.post('delete_sub_operasi.php',{id:id},function(data){
    
      $("#modale-delete").modal('hide');
      $(".tr-id-"+id+"").remove();
  
    });

});
</script>

<script>

$(document).ready(function(){
    $('.table').DataTable();
});

</script>

<!--  end modal confirmasi delete lanjutan  -->


<script>

$(document).ready(function(){
    $('.table').DataTable();
});

</script>

  <?php include 'footer.php'; ?>