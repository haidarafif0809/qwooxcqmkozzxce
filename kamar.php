<?php include 'session_login.php';
include 'header.php';
include 'navbar.php';
include 'db.php';
include_once 'sanitasi.php';




?>


<div class="container">

<!-- Modal Untuk Confirm Delete-->
<div id="modale-delete" class="modal" role="dialog">
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
     <button type="button" class="btn btn-info" data-toggle="modal" id="kamar-tambah" data-target="#modal"><i class="fa fa-plus"> </i> KAMAR </button>
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
         <th style='background-color: #4CAF50; color: white; '>Ruangan</th>
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
  <div class="modal" id="modal-tambah" role="dialog">
    <div class="modal-dialog">
      <!-- Modal content-->
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal">&times;</button>
          <h4 class="modal-title">Form Tambah Kamar</h4>
        </div>
        <div class="modal-body">

          <form >


<div class="form-group">
  <label for="sel1">Kelas</label>
  <select class="form-control" id="kelas" name="kelas" autocomplete="off" >
          <?php 
          // menampilkan seluruh data yang ada pada tabel suplier
          $query = $db->query("SELECT id,nama FROM kelas_kamar ORDER BY id");
          
          // menyimpan data sementara yang ada pada $query
          while($data = mysqli_fetch_array($query))
          {
          
          echo "<option value='".$data['id'] ."'>".$data['nama'] ."</option>";
          }
          
          
          ?>
          </select>
</div>

<div class="form-group">
  <label for="sel1">Ruangan</label>
  <select class="form-control" id="ruangan" name="ruangan" autocomplete="off" >
          <?php 
          // menampilkan seluruh data yang ada pada tabel suplier
          $query = $db->query("SELECT id,nama_ruangan FROM ruangan ORDER BY id ASC");
          
          // menyimpan data sementara yang ada pada $query
          while($data = mysqli_fetch_array($query))
          {
          
          echo "<option value='".$data['id'] ."'>".$data['nama_ruangan'] ."</option>";
          }
          
          
          ?>
          </select>
</div>

<div class="form-group">
  <label for="sel1">Kode Kamar</label>
  <input type="text" class="form-control" style="height: 20px" id="nama_kamar" name="nama_kamar"  autocomplete="off">
</div>

<div class="form-group">
  <label for="sel1">Nama Kamar</label>
  <input type="text"  class="form-control" style="height: 20px" id="grup_kamar" name="grup_kamar"  autocomplete="off">
 </div>


<div class="form-group">
  <label for="sel1">Harga 1</label>
  <input type="text" class="form-control" style="height: 20px" id="tarif" name="tarif"  autocomplete="off">
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
  <input type="text" class="form-control" style="height: 20px" id="fasilitas" name="fasilitas"  autocomplete="off">
</div>

<div class="form-group">
  <label for="sel1">Jumlah Bed</label>
  <input type="number" class="form-control" style="height: 20px" id="jumlah_bed" name="jumlah_bed"  autocomplete="off">
</div>

<button type="submit" class="btn btn-info" id="submit_tambah"><span class="glyphicon glyphicon-plus"></span> Tambah</button>
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
  $(document).ready(function(){
// memunculkan modal tambah
    $(document).on('click','#kamar-tambah',function(e){
      $("#modal-tambah").modal('show');
    });

// submit tambah masuk ke table
    $("#submit_tambah").click(function(){

      var kelas = $("#kelas").val();
      var ruangan = $("#ruangan").val();
      var nama_kamar = $("#nama_kamar").val();
      var grup_kamar = $("#grup_kamar").val();
      var tarif = $("#tarif").val();
      var tarif_2 = $("#tarif_2").val();
      var tarif_3 = $("#tarif_3").val();
      var tarif_4 = $("#tarif_4").val();
      var tarif_5 = $("#tarif_5").val();
      var tarif_6 = $("#tarif_6").val();
      var tarif_7 = $("#tarif_7").val();
      var fasilitas = $("#fasilitas").val();
      var jumlah_bed = $("#jumlah_bed").val();

      if (kelas == ''){
        alert("Silakan isi kolom kelas terlebih dahulu.");
        $("#kelas").focus();
      }
      else if (ruangan == ''){
        alert("Silakan isi kolom ruangan terlebih dahulu.");
        $("#ruangan").focus();
      }
      else if (nama_kamar == ''){
        alert("Silakan isi kolom nama kamar terlebih dahulu.");
        $("#nama_kamar").focus();
      }
      else if (grup_kamar == ''){
        alert("Silakan isi kolom group kamar terlebih dahulu.");
        $("#grup_kamar").focus();
      }
      else if (tarif == ''){
        alert("Silakan isi kolom tarif terlebih dahulu.");
        $("#tarif").focus();
      }
      else if (tarif_2 == ''){
        alert("Silakan isi kolom tarif 2 terlebih dahulu.");
        $("#tarif_2").focus();
      }
      else if (fasilitas == ''){
        alert("Silakan isi kolom fasilitas terlebih dahulu.");
        $("#fasilitas").focus();
      }
      else if (jumlah_bed == ''){
        alert("Silakan isi kolom jumlah bed terlebih dahulu.");
        $("#jumlah_bed").focus();
      }
      else
      {

        $("#modal-tambah").modal('hide');
        $.post("proses_bed.php",{kelas:kelas,ruangan:ruangan,nama_kamar:nama_kamar,grup_kamar:grup_kamar,tarif:tarif,tarif_2:tarif_2,tarif_3:tarif_3,tarif_4:tarif_4,tarif_5:tarif_5,tarif_6:tarif_6,tarif_7:tarif_7,fasilitas:fasilitas,jumlah_bed:jumlah_bed},function(info) {

          $('#table_kamar').DataTable().destroy();
                  
                  var dataTable = $('#table_kamar').DataTable( {
                    "processing": true,
                    "serverSide": true,
                    "ajax":{
                      url :"datatable_kamar.php", // json datasource
                      type: "post",  // method  , by default get
                      error: function(){  // error handling
                        $(".tbody").html("");
                        $("#table_kamar").append('<tbody class="tbody"><tr ><td colspan="3">No data found in the server</td></tr></tbody>');
                        $("#table_ri_processing").css("display","none");
                        
                      }
                    },

                     "fnCreatedRow": function( nRow, aData, iDataIndex ) {
                        $(nRow).attr('class','tr-id-'+aData[16]+'');
                },
                });

            $("#kelas").val('');
            $("#ruangan").val('');
            $("#nama_kamar").val('');
            $("#grup_kamar").val('');
            $("#tarif").val('');
            $("#tarif_2").val('');
            $("#tarif_3").val('');
            $("#tarif_4").val('');
            $("#tarif_5").val('');
            $("#tarif_6").val('');
            $("#tarif_7").val('');
            $("#fasilitas").val('');
            $("#jumlah_bed").val('');

          }); //end info
      } //end else
      $("form").submit(function(){
      return false;
      }); 

    });// end $("#tambh_ruangan").click(function()
  });// end $(document).ready(function()

// /submit tambah masuk ke tbs
</script>
<!--=====AKHIR TAMBAH-->

<script type="text/javascript">
$("#nama_kamar").blur(function(){

var nama = $("#nama_kamar").val();
var ruangan = $("#ruangan").val();
// cek namanya
 $.post('cek_kode_kamar.php',{nama:nama,ruangan:ruangan}, function(data){

        if(data == 1){
          alert('Kode Kamar Sudah Ada Di Ruangan ini!');
          $("#nama_kamar").val('');
          $("#nama_kamar").focus();
        }
        else if (data == 2){
          alert('Kode kamar yang anda masukan tidak boleh sama dengan kode barang!');
          $("#nama_kamar").val('');
          $("#nama_kamar").focus();

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

      $("#modale-delete").modal('hide');
$.post('delete_kamar.php',{id:id},function(data){
          $('#table_kamar').DataTable().destroy();
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
                $(nRow).attr('class','tr-id-'+aData[16]+'');
            },
        });

    });

});
</script>
<!--  end modal confirmasi delete lanjutan  -->

<!--DATA TABLE MENGGUNAKAN AJAX-->
<script type="text/javascript" language="javascript" >
      $(document).ready(function() {
          $('#table_kamar').DataTable().destroy();
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
                $(nRow).attr('class','tr-id-'+aData[16]+'');
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