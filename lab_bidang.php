<?php include 'session_login.php';
include 'header.php';
include 'navbar.php';
include 'db.php';
include 'sanitasi.php';

$query = $db->query("SELECT * FROM bidang_lab ORDER BY id DESC ");

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
      <input type="hidden" id="id2" name="id2">
    </div>
    <div class="modal-footer">
        <button type="submit" class="btn btn-success" id="yesss" >Yes</button>
        <button type="button" class="btn btn-danger" data-dismiss="modal">No</button>
    </div>
    </div>
  </div>
</div>
<!--modal end Confirm Delete-->



<h3>KELOMPOK PEMERIKSAAN </h3><hr>
<button type="button" class="btn btn-primary" data-toggle="modal" data-target="#modal"><i class="fa fa-plus"></i> Tambah</button>

<br>
<br>

<style>

tr:nth-child(even){background-color: #f2f2f2}

</style>


<span id="table_baru">
<div class="table-responsive">
  <table id="table-bidang" class="table table-sm table-bordered">
    <thead>
      <tr>
       <th style='background-color: #4CAF50; color: white'>Nama Kelompok Pemeriksaan</th>
       <th style='background-color: #4CAF50; color: white'>Edit</th>
       <th style='background-color: #4CAF50; color: white'>Hapus</th>
    </tr>
    </thead>
    <tbody id="tbody">    
   <?php while($data = mysqli_fetch_array($query))
      
      {
      echo 
      "<tr class='tr-id-".$data['id']."'>
      <td>". $data['nama']."</td>
    
      <td><button data-id='".$data['id']."' data-nama='".$data['nama']."' class='btn btn-success edited'><i class='fa fa-edit'></i>  Edit</button> </td>
      <td><button data-id='".$data['id']."' class='btn btn-danger delete'><i class='fa fa-trash'></i>  Hapus</button></td>
      </tr>";
      
      }
    ?>
  </tbody>
 </table>
</div>


</span>
<!-- Modal -->
  <div class="modal fade" id="modal" role="dialog">
    <div class="modal-dialog">
    
      <!-- Modal content-->
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal">&times;</button>
          <h4 class="modal-title">Form Tambah Kelompok Pemriksaan </h4>
        </div>
        <div class="modal-body">

          <form role="form" method="POST">

<div class="form-group">
  <label for="sel1">Nama Kelompok Pemeriksaan</label>
  <input type="text" class="form-control" id="nama" name="nama" autocomplete="off">
</div>

    <button type="submit" id="tambah_data" class="btn btn-info"><span class="glyphicon glyphicon-plus"></span> Tambah</button>
        </form>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-warning" data-dismiss="modal">Close</button>
        </div>
      </div>      
    </div>
  </div>

    <div class="modal fade" id="modal_edit" role="dialog">
    <div class="modal-dialog">
    
      <!-- Modal content-->
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal">&times;</button>
          <h4 class="modal-title">Edit Kelompok Pemriksaan </h4>
        </div>
        <div class="modal-body">

          <form role="form" method="POST">

<div class="form-group">
  <label for="sel1">Nama Kelompok Pemeriksaan</label>
  <input type="text" class="form-control" id="nama_edit" name="nama_edit" autocomplete="off">
  <input type="hidden" class="form-control" id="id_edit">
</div>

    <button type="submit" id="saved" data-nama="" class="btn btn-info"><i class="fa fa-save"></i> Simpan</button>
        </form>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-warning" data-dismiss="modal">Close</button>
        </div>
      </div>      
    </div>
  </div>


 </div><!-- / container -->


<!--Start Script Tambah-->
<script type="text/javascript">
  $(document).on('click','#tambah_data',function(e){
  var nama = $("#nama").val();
    if (nama == '') {

      alert('Nama Belum Terisi');
    }
    
    else{

// cek namanya
 $.post('cek_nama_bidang_lab.php',{nama:nama}, function(data){

        if(data == 1){
          alert('Nama Bidang Laboratorium yang anda masukkan sudah ada!');
          $("#nama").val('');
          $("#nama").focus();
        }
        else{

// Start Proses
     $("#modal").modal('hide');
    $.post('proses_lab_bidang.php',{nama:nama},function(data)
    {
    $("#tbody").prepend(data);
    $("#nama").val('');
    });
// Finish Proses
        }

      }); // end post dari cek nama

    } // end else breket

});
            
   $('form').submit(function(){
    return false;
    });

</script>
<!--Ending Script Tambah-->


<!--script modal confirmasi delete -->
<script type="text/javascript">
$(document).on('click','.delete',function(e){
  var id = $(this).attr('data-id');

$("#modale-delete").modal('show');
$("#id2").val(id);  

});


</script>
<!--   end script modal confiormasi dellete -->


<!--  script modal  lanjkutan confiormasi delete -->
<script type="text/javascript">
$(document).on('click','#yesss',function(e){

var id = $("#id2").val();

  $("#modale-delete").modal('hide');
  $(".tr-id-"+id+"").remove();

$.post('delete_lab_bidang.php',{id:id},function(data){

    });

});
</script>
<!--  end modal confirmasi delete lanjutan  -->


<script type="text/javascript">
  //fungsi edit data 
    $(document).on('click','.edited',function(e){

    $("#modal_edit").modal('show');
    var nama = $(this).attr("data-nama"); 
    var id  = $(this).attr("data-id");
    $("#nama_edit").val(nama);
    $("#id_edit").val(id);
    $("#saved").attr("data-nama",nama);

    });
    
    $(document).on('click','#saved',function(e){

    var nama = $("#nama_edit").val();
    var id = $("#id_edit").val();
    var as = $(this).attr("data-nama"); 

// cek namanya
 $.post('cek_nama_bidang_lab.php',{nama:nama}, function(data){
        if(data == 1){
          alert('Nama Bidang Laboratorium yang anda masukkan sudah ada!');
          $("#nama_edit").val(as); // menampilkan NAMA yang sebelumnya
          $("#nama_edit").focus();
        }
        else{

// mulai proses edit
      $("#modal_edit").modal('hide');
      $(".tr-id-"+id+"").remove();
      // proses edit
      $.post("edit_lab_bidang.php",{id:id,nama:nama},function(data){
    
      $("#tbody").prepend(data);
      
      });
// end proses edit

        }

      }); // end post dari cek nama

    });
</script>


<!-- cari untuk pegy natio -->
<script type="text/javascript">
  $("#cari").keyup(function(){
var q = $(this).val();

$.post('table_baru_lab_bidang.php',{q:q},function(data)
{
  $("#table_baru").html(data);
  
});
});
</script>
<!-- END script cari untuk pegy natio -->

    <script>
    
    $(document).ready(function(){
    $('#table-bidang').DataTable({"ordering":false});
    });
    </script>

  <?php 
  include 'footer.php';
   ?>