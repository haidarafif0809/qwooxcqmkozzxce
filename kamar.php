<?php include 'session_login.php';
include 'header.php';
include 'navbar.php';
include 'db.php';
include_once 'sanitasi.php';




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

<h3><b> DATA KAMAR </b></h3> <hr>
<?php 
$pilih_akses_kamar_tambah = $db->query("SELECT kamar_tambah FROM otoritas_master_data WHERE id_otoritas = '$_SESSION[otoritas_id]' AND kamar_tambah = '1'");
$kamar_tambah = mysqli_num_rows($pilih_akses_kamar_tambah);
 ?>

 <?php if ($kamar_tambah > 0): ?>
     <button type="button" class="btn btn-info" data-toggle="modal" data-target="#modal"><i class="fa fa-plus"> </i> KAMAR </button>
<br>
<br>
 <?php endif ?>



<br>

<style>

tr:nth-child(even){background-color: #f2f2f2}

</style>

<span id="table_baru">
<div class="table-responsive"> 
<table id="table_kamar" class="table table-bordered table-sm">
    <thead>
      <tr>
         <th style='background-color: #4CAF50; color: white; '>Kelas</th>
         <th style='background-color: #4CAF50; color: white; '>Kode Kamar</th>
         <th style='background-color: #4CAF50; color: white; '>Nama Kamar </th>
         <th style='background-color: #4CAF50; color: white; '>Harga 1</th>
         <th style='background-color: #4CAF50; color: white; '>Harga 2</th>
         <th style='background-color: #4CAF50; color: white; '>Harga 3</th>
         <th style='background-color: #4CAF50; color: white; '>Harga 4</th>
         <th style='background-color: #4CAF50; color: white; '>Harga 5</th>
         <th style='background-color: #4CAF50; color: white; '>Harga 6</th>
         <th style='background-color: #4CAF50; color: white; '>Harga 7</th>
         <th style='background-color: #4CAF50; color: white; '>Fasilitas</th>
         <th style='background-color: #4CAF50; color: white; '>Jumlah Bed</th>
         <th style='background-color: #4CAF50; color: white; '>Sisa Bed</th>
         <th style='background-color: #4CAF50; color: white; '>Edit</th>
         <th style='background-color: #4CAF50; color: white; '>Hapus</th>
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
          <h4 class="modal-title">Form Tambah Kamar</h4>
        </div>
        <div class="modal-body">

          <form role="form" action="proses_bed.php" method="POST">


<div class="form-group">
  <label for="sel1">Kelas</label>
  <select class="form-control" id="kelas" name="kelas" autocomplete="off" required="">
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
  <label for="sel1">Kode Kamar</label>
  <input type="text" class="form-control" style="height: 20px" id="nama_kamar" name="nama_kamar" required="" autocomplete="off">
</div>

<div class="form-group">
  <label for="sel1">Nama Kamar</label>
  <input type="text"  class="form-control" style="height: 20px" id="grup_kamar" name="grup_kamar" required="" autocomplete="off">
 </div>


<div class="form-group">
  <label for="sel1">Harga 1</label>
  <input type="text" class="form-control" style="height: 20px" id="tarif" name="tarif" required="" autocomplete="off">
</div>


<div class="form-group">
  <label for="sel1">Harga 2</label>
  <input type="text" class="form-control" style="height: 20px" id="tarif_2" name="tarif_2" autocomplete="off">
</div>


<div class="form-group">
  <label for="sel1">Harga 3</label>
  <input type="text" class="form-control" style="height: 20px" id="tarif_3" name="tarif_3" autocomplete="off">
</div>

<div class="form-group">
  <label for="sel1">Harga 4</label>
  <input type="text" class="form-control" style="height: 20px" id="tarif_4" name="tarif_4" autocomplete="off">
</div>

<div class="form-group">
  <label for="sel1">Harga 5</label>
  <input type="text" class="form-control" style="height: 20px" id="tarif_5" name="tarif_5" autocomplete="off">
</div>

<div class="form-group">
  <label for="sel1">Harga 6</label>
  <input type="text" class="form-control" style="height: 20px" id="tarif_6" name="tarif_6" autocomplete="off">
</div>

<div class="form-group">
  <label for="sel1">Harga 7</label> 
  <input type="text" class="form-control" style="height: 20px" id="tarif_7" name="tarif_7" autocomplete="off">
</div>

<div class="form-group">
  <label for="sel1">Fasilitas</label>
  <input type="text" class="form-control" style="height: 20px" id="fasilitas" name="fasilitas" required="" autocomplete="off">
</div>

<div class="form-group">
  <label for="sel1">Jumlah Bed</label>
  <input type="number" class="form-control" style="height: 20px" id="jumlah_bed" name="jumlah_bed" required="" autocomplete="off">
</div>

<button type="submit" class="btn btn-info"><span class="glyphicon glyphicon-plus"></span> Tambah</button>
</form>

        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
        </div>
      </div>
    </div>
  </div>


</div><!--CONTAINER-->


<script type="text/javascript">
$("#nama_kamar").blur(function(){

var nama = $("#nama_kamar").val();
// cek namanya
 $.post('cek_kode_kamar.php',{nama:nama}, function(data){

        if(data == 1){
          alert('Kode Kamar Sudah Ada!');
          $("#nama_kamar").val('');
          $("#nama_kamar").focus();
        }
        else{

// Finish Proses
        }

      }); // end post dari cek nama

});
</script>

<!--   script modal confirmasi delete -->
<script type="text/javascript">
$(document).on('click','.btn-hapus',function(e){

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

      $(".tr-id-"+id+"").remove(); // ini table baru setelah proses confirm delete (tampilan)
      $("#modale-delete").modal('hide');
$.post('delete_kamar.php',{id:id},function(data){


    });

});
</script>
<!--  end modal confirmasi delete lanjutan  -->

<!--DATA TABLE MENGGUNAKAN AJAX-->
<script type="text/javascript" language="javascript" >
      $(document).ready(function() {

          var dataTable = $('#table_kamar').DataTable( {
          "processing": true,
          "serverSide": true,
          "ajax":{
            url :"datatable_kamar.php", // json datasource
           
            type: "post",  // method  , by default get
            error: function(){  // error handling
              $(".employee-grid-error").html("");
              $("#table_kamar").append('<tbody class="employee-grid-error"><tr><th colspan="3">No data found in the server</th></tr></tbody>');
              $("#employee-grid_processing").css("display","none");
            }
        },
            
            "fnCreatedRow": function( nRow, aData, iDataIndex ) {
                $(nRow).attr('class','tr-id-'+aData[15]+'');
            },
        });

        $("#form").submit(function(){
        return false;
        });
        

      } );
    </script>

<!--FOOTER-->
<?php 
include 'footer.php';
?>
<!--END FOOTER-->