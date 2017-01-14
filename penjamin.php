<?php include 'session_login.php';
include 'header.php';
include 'navbar.php';
include 'db.php';
include_once 'sanitasi.php';


// AKHIR untuk FEGY NATION

?>
<div class="container">

<style>

tr:nth-child(even){background-color: #f2f2f2}

</style>

<!-- Modal Untuk Confirm LAYANAN PERUSAHAAN-->
<div id="detail" class="modal fade" role="dialog">
  <div class="modal-dialog modal-lg">
    <!-- Modal content-->
    <div class="modal-content">
    <div class="modal-header">

    <h3><center><b>Data Layanan</b></center></h3>
        <button type="button" class="close" data-dismiss="modal">&times;</button>       
    </div>
    <div class="modal-body">
      <span id="tampil_layanan">
      </span>
    </div>
    <div class="modal-footer">
        
        <button type="button" class="btn btn-danger" data-dismiss="modal">Closed</button>
    </div>
    </div>
  </div>
</div>
<!--modal end Layanan Perusahaan-->


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
        <button type="submit" class="btn btn-success" id="yessss" >Yes</button>
        <button type="button" class="btn btn-danger" data-dismiss="modal">No</button>
    </div>
    </div>
  </div>
</div>
<!--modal end Confirm Delete-->


<h3><b> DATA PENJAMIN </b></h3> <hr>
<?php 

$pilih_akses_penjamin_tambah = $db->query("SELECT penjamin_tambah FROM otoritas_master_data WHERE id_otoritas = '$_SESSION[otoritas_id]' AND penjamin_tambah = '1'");
$penjamin_tambah = mysqli_num_rows($pilih_akses_penjamin_tambah);

 ?>

 <?php if ($penjamin_tambah > 0): ?>
   <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#modal"><span class="fa fa-plus"></span> Penjamin </button>
<br>
<br>
 <?php endif ?>



<span id="table_baru">
<div class="table-responsive">  
<table id="table_penjamin" class="table table-bordered table-sm">
    <thead>
      <tr>

        <th style='background-color: #4CAF50; color: white; '>Nama </th>    
        <th style='background-color: #4CAF50; color: white; '>Alamat</th>
        <th style='background-color: #4CAF50; color: white; '>No Telp</th>
        <th style='background-color: #4CAF50; color: white; '>Level Harga</th>
        <th style='background-color: #4CAF50; color: white; '>Jatuh Tempo (Hari)</th>
        <th style='background-color: #4CAF50; color: white; '>Lihat Cakupan Layanan</th>
        <th style='background-color: #4CAF50; color: white; '>Edit</th>
        <th style='background-color: #4CAF50; color: white; '>Hapus</th>

    </tr>
    </thead>

 </table>
</div> <!-- DIV TABLE RESPONSIVE  -->
</span>
</div>

<!-- Modal tam,bnah penjamin-->
  <div class="modal fade" id="modal" role="dialog">
    <div class="modal-dialog modal-lg">
    
      <!-- Modal content-->
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal">&times;</button>
          <h1 class="modal-title">Form Tambah Penjamin</h1>
        </div>
      <div class="modal-body">

<form role="form" action="proses_tambah_penjamin.php" method="POST">

<div class="form-group">
  <label for="sel1">Nama Penjamin</label>
  <input type="text" class="form-control" id="nama" name="nama"  required="" autocomplete="off">
</div>

<div class="form-group">
  <label for="sel1">Alamat Penjamin</label>
  <textarea class="form-control" id="alamat" name="alamat" required="" autocomplete="off"></textarea>
</div>

<div class="form-group">
  <label for="sel1">No Telpon</label>
  <input type="text" style="height: 20px" class="form-control" id="no_telp" name="no_telp" required="" autocomplete="off">
</div>


<div class="form-group">
  <label for="sel1">Level Harga</label>
  <select class="form-control" id="level_harga" required="" name="level_harga" autocomplete="off">
        <option value="">Silakan Pilih</option> 
        <option value="harga_1">Level 1</option> 
        <option value="harga_2">Level 2</option> 
        <option value="harga_3">Level 3</option> 
        <option value="harga_4">Level 4</option> 
        <option value="harga_5">Level 5</option> 
        <option value="harga_6">Level 6</option> 
        <option value="harga_7">Level 7</option> 

</select>
</div>


<div class="form-group">
    <label for="penjamin">Jatuh Tempo:</label>
    <input type="number" class="form-control" id="jatuh_tempo" name="jatuh_tempo" placeholder="Isi Jika ada Perjanjian Tanggal Jatuh Tempo" autocomplete="off">
</div>

<div class="form-group">
  <label for="sel1">Cakupan Layanan</label>
  <textarea class="form-control" id="layanan" name="layanan" style="height:500px"></textarea>
</div>

<button type="submit" class="btn btn-info"><span class="glyphicon glyphicon-plus"></span> Tambah</button>
</form>

        </div>
        <div class="modal-footer">
      <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
    </div>
  </div>    
</div>
</div>
</div>  <!-- container  -->


      <script>
                // Replace the <textarea id="editor1"> with a CKEditor
                // instance, using default configuration.
                CKEDITOR.replace( 'layanan' );
            </script>

<script type="text/javascript">
$("#nama").blur(function(){

var nama = $("#nama").val();
// cek namanya
 $.post('cek_penjamin.php',{nama:nama}, function(data){

        if(data == 1){
          alert('Nama Penjamin sudah ada!');
          $("#nama").val('');
          $("#nama").focus();
        }
        else{

// Finish Proses
        }

      }); // end post dari cek nama

});
</script>

<!--   script untuk detail layanan -->
<script type="text/javascript">

//            jika dipilih, nim akan masuk ke input dan modal di tutup
            $(document).on('click', '.detaili', function (e) {
              
               
                var id = $(this).attr('data-id');
               
                $.post("detail_layanan_perusahaan.php",{id:id},function(data){
                    $("#tampil_layanan").html(data);
               $("#detail").modal('show');
          
                });

               
            });
      

//            tabel lookup mahasiswa
            
          
</script>
<!--  end script untuk akhir detail layanan  -->


<!--   script modal confirmasi delete -->
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
$(document).on('click','#yessss',function(e){

var id = $("#id2").val();

 $(".tr-id-"+id+"").remove();
 $("#modale-delete").modal('hide');
$.post('delete_penjamin.php',{id:id},function(data){
     
    });

});
</script>
<!--  end modal confirmasi delete lanjutan  -->

<!--DATA TABLE MENGGUNAKAN AJAX-->
<script type="text/javascript" language="javascript" >
      $(document).ready(function() {

          var dataTable = $('#table_penjamin').DataTable( {
          "processing": true,
          "serverSide": true,
          "ajax":{
            url :"datatable_penjamin.php", // json datasource
           
            type: "post",  // method  , by default get
            error: function(){  // error handling
              $(".employee-grid-error").html("");
              $("#table_penjamin").append('<tbody class="employee-grid-error"><tr><th colspan="3">No data found in the server</th></tr></tbody>');
              $("#employee-grid_processing").css("display","none");
            }
        },
            
            "fnCreatedRow": function( nRow, aData, iDataIndex ) {
                $(nRow).attr('class','tr-id-'+aData[8]+'');
            },
        });

        $("#form").submit(function(){
        return false;
        });
        

      } );
    </script>
<!--/DATA TABLE MENGGUNAKAN AJAX-->




<!--FOOTER-->
<?php 
include 'footer.php';
?>
<!--END FOOTER-->