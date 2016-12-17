<?php include 'session_login.php';
include 'header.php';
include 'navbar.php';
include 'db.php';
include 'sanitasi.php';

$pilih_akses_operasi = $db->query("SELECT operasi_tambah, operasi_edit, operasi_hapus, sub_operasi_lihat FROM otoritas_master_data WHERE id_otoritas = '$_SESSION[otoritas_id]'");
$operasi = mysqli_fetch_array($pilih_akses_operasi);


?>

<style>

tr:nth-child(even){background-color: #f2f2f2}

</style>

  <div class="container">



<!-- Modal Tambah Operasi -->
  <div class="modal fade" id="modal" role="dialog">
    <div class="modal-dialog">
    <!-- Modal content-->
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal">&times;</button>
          <h4 class="modal-title">Form Tambah Operasi</h4>
        </div>
        <div class="modal-body">

          <form role="form" method="POST">

<div class="form-group">
  <label for="sel1">Kode Operasi</label>
  <input type="text" style="height: 20px;" class="form-control" id="kode" name="kode" autocomplete="off">
</div>

<div class="form-group">
  <label for="sel1">Nama Operasi</label>
  <input type="text" style="height: 20px;" class="form-control" id="nama" name="nama" autocomplete="off">
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
    </div>
    <div class="modal-body">
      <center><h4>Apakah Anda Yakin Ingin Menghapus Data Ini ?</h4></center>

<div class="form-group">
        <label for="sel1">Kode Operasi</label>
        <input type="text" style="height: 20px;" class="form-control" id="kode_hapus" name="kode_hapus" autocomplete="off">
      </div>

      <div class="form-group">
        <label for="sel1">Nama Operasi</label>
        <input type="text" style="height: 20px;" class="form-control" id="nama_hapus" name="nama_hapus" autocomplete="off">
      </div>

      <input type="hidden" id="id_hapus" name="id2">

    </div>
    <div class="modal-footer">
        <button type="submit" data-id="" class="btn btn-success" id="yesss" >Yes</button>
        <button type="button" class="btn btn-danger" data-dismiss="modal">No</button>
    </div>
    </div>
  </div>
</div>
<!--modal end Confirm Delete-->

<h3><b> Data Operasi </b></h3> <hr>
<?php if ($operasi['operasi_tambah'] > 0): ?>
  <button type="button" class="btn btn-info" data-toggle="modal" data-target="#modal"><i class="fa fa-plus"> </i> Operasi </button>
<br>
<br>
<?php endif ?>
  


<span id="table_baru">  
<div class="table-responsive">
  <table id="table-pelamar" class="table table-bordered table-sm">
 
    <thead>
      <tr>
          <th style='background-color: #4CAF50; color: white; width: 50%'>Kode Operasi </th>
          <th style='background-color: #4CAF50; color: white; width: 50%'>Nama Operasi </th>
          <th style='background-color: #4CAF50; color: white; width: 50%'>Sub Operasi </th>
          <th style='background-color: #4CAF50; color: white'>Hapus</th>

    </tr>
    </thead>
    <tbody id="tbody">
    
   <?php 
   $query = $db->query("SELECT * FROM operasi ORDER BY id_operasi DESC");
   while($data = mysqli_fetch_array($query))      
      {
      echo "<tr class='tr-id-".$data['id_operasi']."'>";

     echo "<td class='edit-kode' data-id='".$data['id_operasi']."'>
      <span id='text-nama-".$data['id_operasi']."'>". $data['kode_operasi'] ."</span>
      <input type='hidden' id='input-kode-".$data['id_operasi']."' value='".$data['kode_operasi']."' class='input_kode' data-kode='".$data['kode_operasi']."' data-id='".$data['id_operasi']."' autofocus=''> </td>";


      if ($operasi['operasi_edit'] > 0) {
        echo "<td class='edit-nama' data-id='".$data['id_operasi']."'>
      <span id='text-nama-".$data['id_operasi']."'>". $data['nama_operasi'] ."</span>
      <input type='hidden' id='input-nama-".$data['id_operasi']."' value='".$data['nama_operasi']."' class='input_nama' data-id='".$data['id_operasi']."' autofocus=''> </td>";
      }
      else{
        echo "<td>". $data['nama_operasi'] ." </td>";
      }

      if ($operasi['sub_operasi_lihat'] > 0) {
      echo "<td><a style='width:84px;' href='sub_operasi.php?id=".$data["id_operasi"]."&nama=".$data["nama_operasi"]."' class='btn btn-success'>Sub Operasi </a></td>";
    }
    else{
      echo "<td> </td>";
    }

     if ($operasi['operasi_hapus'] > 0) {
       echo "<td><button data-id='".$data['id_operasi']."' data-nama='".$data['nama_operasi']."' data-kode='".$data['kode_operasi']."' class='btn btn-danger delete'><span class='glyphicon glyphicon-trash'></span> Hapus </button>
      </td>";
     }
     else{
      echo "<td> </td>";
     }


      

      echo "</tr>";
      }
    ?>
  </tbody>
 </table>
 </div>
</span>

<h6 style="text-align: left ; color: red"><i> * Klik 2x pada kolom Nama jika ingin mengedit.</i></h6>

  </div><!--counteiner-->

<script type="text/javascript">
  $(document).ready(function(){
      $("#kode").blur(function(){
      var kode = $("#kode").val();

      $.post('cek_kodnam_operasi.php',{kode:$(this).val()}, function(data){

        if(data == 1){
          alert('Kode operasi yang anda masukkan sudah ada.');
           $("#kode").val('');
          $("#kode").focus();
        }
        else{
        }
      });
    });
  });
    
</script>

<!--Start Script Tambah-->
<script type="text/javascript">
  $("#submit_tmbh").click(function(){
  var nama = $("#nama").val();
  var kode = $("#kode").val();
    if (kode == '') {
      alert('Kode operasi belum terisi');
    }
    else if(nama == ''){
      alert('Nama Operasi belum terisi');
    }
    else{
    $("#modal").modal('hide');
    $.post('proses_operasi.php',{nama:nama,kode:kode},function(data)
    {
    
    $("#tbody").prepend(data);
    $("#kode").val('');
    $("#nama").val('');
    });
    }
});
            
   $('form').submit(function(){
    return false;
    });

</script>
<!--Ending Script Tambah-->


<!--   script modal confirmasi delete -->
<script type="text/javascript">
$(".delete").click(function(){

  var id = $(this).attr('data-id');
    var nama = $(this).attr('data-nama');
    var kode = $(this).attr('data-kode');

  $("#modale-delete").modal('show');
  $("#id_hapus").val(id);  
  $("#nama_hapus").val(nama);  
  $("#kode_hapus").val(kode); 

});


</script>
<!--   end script modal confiormasi dellete -->


<!--  script modal  lanjkutan confiormasi delete -->
<script type="text/javascript">
$("#yesss").click(function(){

var id = $("#id_hapus").val();

$.post('delete_operasi.php',{id:id},function(data){
    
      $("#modale-delete").modal('hide');
      $(".tr-id-"+id+"").remove();
  

    });

});
</script>
<!--  end modal confirmasi delete lanjutan  -->

<!--EDIT KODE START-->
<script type="text/javascript">      
$(document).on('dblclick','.edit-kode',function(e){

    var id = $(this).attr("data-id");

   $("#text-nama-"+id+"").hide();
   $("#input-kode-"+id+"").attr("type", "text");

});

$(document).on('blur','.input_kode',function(e){

var id = $(this).attr("data-id");
var input_kode = $(this).val();
var kode_lama = $(this).attr("data-kode");

$.post("cek_kode_operasi_edit.php",{input_kode:input_kode},function(data){

  if(data == 1)
  {
      alert('Kode operasi yang anda masukkan sudah ada.');
     
        $("#input-kode-"+id).attr("data-kode", kode_lama);
        $("#text-nama-"+id+"").show();
        $("#text-nama-"+id+"").text(kode_lama);
        $("#input-kode-"+id+"").attr("type", "hidden");
        $("#input-kode-"+id+"").val(kode_lama); 
                                        
  }
  else
  {

    $.post("update_kode_operasi.php",{id:id, input_kode:input_kode,jenis_edit:"kode_operasi"},function(data){

      $("#text-nama-"+id+"").show();
      $("#text-nama-"+id+"").text(input_kode);
      $("#input-kode-"+id+"").attr("type", "hidden");           

          });
  }         

});


});

</script>
<!--EDIT KODE -->

<script type="text/javascript">      
$(document).on('dblclick','.edit-nama',function(e){

    var id = $(this).attr("data-id");

   $("#text-nama-"+id+"").hide();
   $("#input-nama-"+id+"").attr("type", "text");

});

$(document).on('blur','.input_nama',function(e){

var id = $(this).attr("data-id");

var input_nama = $(this).val();

$.post("update_operasi.php",{id:id, input_nama:input_nama,jenis_edit:"nama_operasi"},function(data){

  $("#text-nama-"+id+"").show();
  $("#text-nama-"+id+"").text(input_nama);
  $("#input-nama-"+id+"").attr("type", "hidden");           

});
});

</script>

<script>

$(document).ready(function(){
    $('.table').DataTable();
});

</script>

  <?php include 'footer.php'; ?>