<?php include 'session_login.php';
include 'header.php';
include 'navbar.php';
include 'db.php';
include 'sanitasi.php';




?>

<style>

tr:nth-child(even){background-color: #f2f2f2}

</style>

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
        <button type="submit" data-id="" class="btn btn-success" id="yesss" >Yes</button>
        <button type="button" class="btn btn-danger" data-dismiss="modal">No</button>
    </div>
    </div>
  </div>
</div>
<!--modal end Confirm Delete-->

<?php 

$pilih_akses_poli_tambah = $db->query("SELECT poli_tambah FROM otoritas_master_data WHERE id_otoritas = '$_SESSION[otoritas_id]' AND poli_tambah = '1'");
$poli_tambah = mysqli_num_rows($pilih_akses_poli_tambah);


 ?>

<h3><b> DATA POLI </b></h3>
<?php if ($poli_tambah > 0): ?>
  <button type="button" class="btn btn-info" data-toggle="modal" data-target="#modal"><i class="fa fa-plus"> </i> POLI </button>
<br>
<br>
<?php endif ?>



<span id="table_baru">  
<div class="table-responsive">
  <table id="table-pelamar" class="table table-bordered table-sm">

    <thead>
      <tr>

          <th style='background-color: #4CAF50; color: white; width: 50%'>Nama </th>
          <th style='background-color: #4CAF50; color: white'>Hapus</th>

    </tr>
    </thead>
    <tbody id="tbody">
    
   <?php 
   $query = $db->query("SELECT * FROM poli ");
   while($data = mysqli_fetch_array($query))      
      {
      echo "<tr class='tr-id-".$data['id']."'>";
  $pilih_akses_poli_edit = $db->query("SELECT poli_edit FROM otoritas_master_data WHERE id_otoritas = '$_SESSION[otoritas_id]' AND poli_edit = '1'");
$poli_edit = mysqli_num_rows($pilih_akses_poli_edit);
  if ($poli_edit > 0) {
      
      echo "<td class='edit-nama' data-id='".$data['id']."'><span id='text-nama-".$data['id']."'>". $data['nama'] ."</span> <input type='hidden' id='input-nama-".$data['id']."' value='".$data['nama']."' class='input_nama' data-id='".$data['id']."' data-nama='".$data['nama']."' autofocus=''> </td>";
}
else{

  echo "<td>". $data['nama'] ." </td>";

}

$pilih_akses_poli_hapus = $db->query("SELECT poli_hapus FROM otoritas_master_data WHERE id_otoritas = '$_SESSION[otoritas_id]' AND poli_hapus = '1'");
$poli_hapus = mysqli_num_rows($pilih_akses_poli_hapus);
  if ($poli_hapus > 0) {

    echo "<td><button data-id='".$data['id']."' class='btn btn-danger delete'><span class='glyphicon glyphicon-trash'></span> Hapus </button></td>";
    
  }
  else{

    echo "<td> </td>";

  }
      echo "
      </tr>";
      }
    ?>
  </tbody>
 </table>
 </div>
</span>

<h6 style="text-align: left ; color: red"><i> * Klik 2x pada kolom Nama jika ingin mengedit.</i></h6>



<!-- Modal -->
  <div class="modal fade" id="modal" role="dialog">
    <div class="modal-dialog">
    <!-- Modal content-->
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal">&times;</button>
          <h4 class="modal-title">Form Tambah Poli</h4>
        </div>
        <div class="modal-body">

          <form role="form" method="POST">

<div class="form-group">
  <label for="sel1">Nama Poli</label>
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



</div><!--CONTAINER-->



<!--   script modal confirmasi delete -->
<script type="text/javascript">
$(".delete").click(function(){

  var id = $(this).attr('data-id');
  
  $("#modale-delete").modal('show');
  $("#id2").val(id);  

});


</script>
<!--   end script modal confiormasi dellete -->

<!--  script modal  lanjkutan confiormasi delete -->
<script type="text/javascript">
$("#yesss").click(function(){

var id = $("#id2").val();


$.post('hapus_data_poli.php',{id:id},function(data){
    
      $("#modale-delete").modal('hide');
      $(".tr-id-"+id+"").remove();
  

    });

});
</script>
<!--  end modal confirmasi delete lanjutan  -->

<!-- cari untuk pegy natio -->
<script type="text/javascript">
  $("#cari").keyup(function(){
var q = $(this).val();

$.post('table_baru_poli.php',{q:q},function(data)
{
  $("#table_baru").html(data);
  
});
});
</script>
<!-- END script cari untuk pegy natio -->


<!-- cari untuk pegy natio -->
<script type="text/javascript">
  $(document).on('click','#submit_tmbh',function(e){

  var nama = $("#nama").val();
  

 if (nama == '') {

      alert('Nama Belum Terisi');
    }
    
    else{

// cek namanya
 $.post('cek_nama_poli.php',{nama:nama}, function(data){

        if(data == 1){
          alert('Nama Poli yang anda masukkan sudah ada!');
          $("#nama").val('');
          $("#nama").focus();
        }
        else{

// Start Proses
     $("#modal").modal('hide');
  $.post('proses_tambah_poli.php',{nama:nama},function(data)
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
<!-- END script cari untuk pegy natio -->


<script>

$(document).ready(function(){
    $('.table').DataTable();
});

</script>



<script type="text/javascript">
$(document).on('dblclick','.edit-nama',function(e){
  
var id = $(this).attr("data-id");
$("#text-nama-"+id+"").hide();
 $("#input-nama-"+id+"").attr("type", "text");

 });

$(document).on('blur','.input_nama',function(e){
var nama_lama = $(this).attr("data-nama");
var id = $(this).attr("data-id");
var input_nama = $(this).val();

if (input_nama == '') {
      alert('Nama Tidak Boleh Kosong !!');

    }
    
    else{

// cek namanya
 $.post('cek_nama_poli.php',{nama:input_nama}, function(data){

        if(data == 1){
          alert('Nama Poli anda masukkan sudah ada!');
$("#text-nama-"+id+"").show();
$("#text-nama-"+id+"").text(nama_lama);
$("#input-nama-"+id+"").attr("type", "hidden");
$("#input-nama-"+id+"").val(nama_lama);
$("#input-nama-"+id+"").attr("data-nama",nama_lama);

        }
        else{

// Start Proses
$.post("update_data_poli.php",{id:id, input_nama:input_nama,jenis_edit:"nama_poli"},function(data){

$("#text-nama-"+id+"").show();
$("#text-nama-"+id+"").text(input_nama);
$("#input-nama-"+id+"").attr("type", "hidden");           
$("#input-nama-"+id+"").val(input_nama);
$("#input-nama-"+id+"").attr("data-nama",input_nama);


});
// Finish Proses
        }

      }); // end post dari cek nama

    } // end else breket


});

</script>

<!--FOOTER-->
<?php 
  include 'footer.php';
?>
<!--END FOOTER-->


  