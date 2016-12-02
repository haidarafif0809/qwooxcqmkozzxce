<?php include 'session_login.php';

include 'header.php';
include 'navbar.php';
include 'db.php';
include 'sanitasi.php';

$pilih_akses_perujuk = $db->query("SELECT perujuk_tambah, perujuk_edit, perujuk_hapus FROM otoritas_master_data WHERE id_otoritas = '$_SESSION[otoritas_id]'");
$perujuk = mysqli_fetch_array($pilih_akses_perujuk);


// AKHIR untuk FEGY NATION
?>
<div class="container">
<style>

tr:nth-child(even){background-color: #f2f2f2}

</style>

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


<h3><b> DATA PERUJUK </b></h3> <hr>

<?php if ($perujuk['perujuk_tambah'] > 0): ?>
     <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#modal"><i class="fa fa-plus"></i> PERUJUK </button>
 <br>
<br>
<?php endif ?>



<span id="table_baru"> 
<div class="table-responsive">

<table id="table_perujuk" class="table table-bordered table-sm">
    <thead>
      <tr class='tr-idp'>
         <th style="background-color: #4CAF50; color: white;" >Nama </th>
         <th style="background-color: #4CAF50; color: white;" >Alamat</th>
         <th style="background-color: #4CAF50; color: white;" >No Telp</th>
         <th style="background-color: #4CAF50; color: white;" >Edit</th>
         <th style="background-color: #4CAF50; color: white;" >Hapus</th>
    </tr>
    </thead>
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
          <h4 class="modal-title">Form Tambah Perujuk</h4>
        </div>
        <div class="modal-body">

          <form role="form" action="proses_perujuk.php" method="POST">

<div class="form-group">
  <label for="sel1">Nama </label>
  <input type="text" class="form-control" id="nama" name="nama" autocomplete="off">
</div>

<div class="form-group">
  <label for="sel1">Alamat</label>
  <input type="text" class="form-control" id="alamat" name="alamat" autocomplete="off">
</div>


<div class="form-group">
  <label for="sel1">No Telp</label>
  <input type="decimal" class="form-control" id="no_telp" name="no_telp" autocomplete="off">
</div>

<button type="submit" class="btn btn-info"><i class="fa fa-plus"></i> Tambah</button>
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
$(document).on('click','.delete',function(){

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

$(".tr-id-"+id+"").remove();
$("#modale-delete").modal('hide');
$.post('delete_perujuk.php',{id:id},function(data){
      
    });
});
</script>
<!--  end modal confirmasi delete lanjutan  -->

<!--DATA TABLE MENGGUNAKAN AJAX-->
<script type="text/javascript" language="javascript" >
      $(document).ready(function() {

          var dataTable = $('#table_perujuk').DataTable( {
          "processing": true,
          "serverSide": true,
          "ajax":{
            url :"datatable_perujuk.php", // json datasource
           
            type: "post",  // method  , by default get
            error: function(){  // error handling
              $(".employee-grid-error").html("");
              $("#table_perujuk").append('<tbody class="employee-grid-error"><tr><th colspan="3">No data found in the server</th></tr></tbody>');
              $("#employee-grid_processing").css("display","none");
            }
        },
            
            "fnCreatedRow": function( nRow, aData, iDataIndex ) {
                $(nRow).attr('class','tr-id-'+aData[5]+'');
            },
        });

        $("#form").submit(function(){
        return false;
        });
        

      } );
    </script>


<?php 
include 'footer.php';
?>