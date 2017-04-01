<?php include 'session_login.php';


//memasukkan file session login, header, navbar, db.php
include 'header.php';
include 'navbar.php';
include 'sanitasi.php';
include 'db.php';


$pilih_akses = $db->query("SELECT ruangan_tambah, ruangan_edit, ruangan_hapus FROM otoritas_master_data WHERE id_otoritas = '$_SESSION[otoritas_id]'");
$ruangan = mysqli_fetch_array($pilih_akses);


 ?>

<div class="container">

 <span id="judul">
   <h3><b>Form Tambah Ruangan </b></h3><hr>
 </span>
 <span id="judul_edit" style="display: none;">
   <h3><b>Form Edit Ruangan</b></h3><hr>
 </span>

<button style="display: none;" class="btn btn-primary" data-toggle="tooltip" accesskey="k" id="kembali" class="btn btn-primary" data-placement='top' title='Klik untuk kembali ke sebelumnya.'><i class="fa fa-reply"></i> <u>K</u>embali</button>

<?php 
if ($ruangan['ruangan_tambah'] != 0) {
  echo '<button type="submit" id="tambah_ruangan" class="btn btn-success" style="background-color:#0277bd"><i class="fa fa-plus"> </i> Tambah</button>';
}
?>

<span id="tambh_ruangan" style="display: none;"><!--span untuk TAMBAH-->
          <form class="form-inline" role="form" id="formruangan">
          <div class="row armun"><!--div class="row armun"-->

            <div class="col-sm-5"><!--/div class="col-sm-5 armun"-->
                <input type="text" name="nama_ruangan" id="nama_ruangan" autocomplete="off" class="form-control" style="height: 5%; width: 95%;"   placeholder="Nama Ruangan">
            </div><!--div class="col-sm-5 armun"-->

            <div class="col-sm-2"><!--/div class="col-sm-2 armun"-->
              <button type="submit" id="submit_tambah" class="btn btn-primary" style="background-color:#0277bd"><i class="fa fa-plus"> </i> Submit</button>
            </div><!--div class="col-sm-2 armun"-->
          </div><!--/div class="row armun"-->
   
          </form>
</span><!--Akhir span untuk TAMBAH-->

        <!--span untuk EDIT-->
        <span id="edit_ruangan" style="display: none;"><!--span untuk EDIT-->
          <form class="form-inline" role="form" id="formprogramedit">
              <div class="row armun"><!--div class="row armun"-->
            
            <div class="col-sm-5"><!--/div class="col-sm-5 armun"-->
                <input type="text" name="nama_ruangan_edit" id="nama_ruangan_edit" autocomplete="off" class="form-control" style="height: 5%; width: 95%;"   placeholder="Nama Ruangan">
            </div><!--div class="col-sm-5 armun"-->

            <div class="col-sm-2"><!--/div class="col-sm-2 armun"-->
              <button type="submit" id="submit_edit" class="btn btn-warning" style="background-color:#0277bd"><i class="fa fa-edit"> </i> Edit</button>
            </div><!--div class="col-sm-2 armun"-->

                <input type="hidden" name="id_edit" id="id_edit" autocomplete="off" class="form-control" style="height: 5%; width: 95%;" placeholder="id">
            </div><!--div class="row armun"-->
   
          </form>
        </span><!--Akhir span untuk EDIT-->

<!-- Modal Hapus data -->
<div id="modal_hapus" class="modal" role="dialog">
  <div class="modal-dialog">

    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title">Konfirmsi Hapus Data</h4>
      </div>

      <div class="modal-body">
   
   <p>Apakah Anda yakin Ingin Menghapus Data ini ?</p>
   <form >
    <div class="form-group">
    <label> Nama Ruangan :</label>
     <input type="text" id="nama_ruangan_hapus" class="form-control" readonly=""> 
    
     <input type="hidden" id="id_hapus" class="form-control" > 
    </div>
   
   </form> 

     </div>

      <div class="modal-footer">
        <button type="button" class="btn btn-info" id="btn_jadi_hapus"><span class='glyphicon glyphicon-ok-sign'> </span> Ya</button>
        <button type="button" class="btn btn-warning" data-dismiss="modal"><span class='glyphicon glyphicon-remove-sign'> </span> Batal</button>
      </div>
    </div>

  </div>
</div><!-- end of modal hapus data  -->

<br>
<span id="span_table_ruangan">
<div class="table-responsive"><!--membuat agar ada garis pada tabel disetiap kolom-->
  <table id="table_ruangan" class="table table-bordered table-sm">
    <thead>
      <th style="background-color: #4CAF50; color: white;"> Nama Ruangan </th>
      <?php 
      if ($ruangan['ruangan_edit'] != 0) {
        echo '<th style="background-color: #4CAF50; color: white;"> Edit </th>';
      }

      if ($ruangan['ruangan_hapus'] != 0) {
        echo '<th style="background-color: #4CAF50; color: white;"> hapus </th>';
      }
    ?>
    </thead>
  </table>
</div> <!--/ responsive-->
</span>


<!--DATA TABLE MENGGUNAKAN AJAX-->
<script type="text/javascript" language="javascript" >
      $(document).ready(function() {

          var dataTable = $('#table_ruangan').DataTable( {
          "processing": true,
          "serverSide": true,
          "ajax":{
            url :"datatable_ruangan.php", // json datasource
           
            type: "post",  // method  , by default get
            error: function(){  // error handling
              $(".employee-grid-error").html("");
              $("#table_ruangan").append('<tbody class="employee-grid-error"><tr><th colspan="3">No data found in the server</th></tr></tbody>');
              $("#employee-grid_processing").css("display","none");
            }
        },
            
            "fnCreatedRow": function( nRow, aData, iDataIndex ) {
                $(nRow).attr('class','tr-id-'+aData[3]+'');
            },
        });

        $("form").submit(function(){
        return false;
        });
        

      } );
</script>

<!--====== AWAL TAMBAH========-->
<script type="text/javascript">
// MENAMPILKAN FORM
  $(document).ready(function(){
    $("#tambah_ruangan").click(function(){
      $("#tambh_ruangan").show();
      $("#tambah_ruangan").hide();
      $("#span_table_ruangan").hide();
    });
  });
// /MENAMPILKAN FORM
</script>

<script type="text/javascript">
//pencegah nam ruangan yang sama saat tambah
        $(document).ready(function(){
      // nama ruangan blur
        $("#nama_ruangan").blur(function(){

          var nama_ruangan = $('#nama_ruangan').val();          

                $.post('cek_nama_ruangan.php',{nama_ruangan:nama_ruangan}, function(data){
            
              if(data == 1){
              alert("Nama Ruangan Sudah Ada, Silakan Gunakan Nama Yang lain !");
              $("#nama_ruangan").val('');
              $("#nama_ruangan").focus();
              }//penutup if
              
              });////penutup function(data)

        }); //end Nama ruangan blur

        // Nama ruangan mouseleave 
        $("#nama_ruangan").mouseleave(function(){

          var nama_ruangan = $('#nama_ruangan').val();          

                $.post('cek_nama_ruangan.php',{nama_ruangan:nama_ruangan}, function(data){
            
              if(data == 1){
              alert("Nama Ruangan Sudah Ada, Silakan Gunakan Nama Yang lain !");
              $("#nama_ruangan").val('');
              $("#nama_ruangan").focus();
              }//penutup if
              
              });////penutup function(data)

        });//end Nama ruangan mouseleave

        });//end ready    
</script>

<script type="text/javascript">
// MENAMPILKAN FORM EDIT
  $(document).ready(function(){
    $(document).on('click', '.edit', function (e) {
      
     var nama_ruangan_edit = $(this).attr("data-nama");
     var id_edit = $(this).attr("data-id");

     $("#nama_ruangan_edit").val(nama_ruangan_edit);
     $("#id_edit").val(id_edit);

      $("#kembali").show();
      $("#edit_ruangan").show();
      $("#judul_edit").show();
      $("#tambh_ruangan").hide();
      $("#judul").hide();
      $("#span_table_ruangan").hide();
      $("#tambah_ruangan").hide();

    });
//==========
    $("#submit_edit").click(function(){

     var nama_ruangan = $("#nama_ruangan_edit").val();
     var id = $("#id_edit").val();
      if (nama_ruangan == '') {
        alert("Silakan isi kolom nama ruangan terlebih dahulu.");
        $("#nama_ruangan_edit").focus();
      }
      else
      {
        $.post("proses_edit_ruangan.php",{id:id,nama_ruangan:nama_ruangan},function(info) {
          $("#tambh_ruangan").hide();
          $("#tambah_ruangan").show();
          $("#span_table_ruangan").show();
          $("#kembali").hide();
          $("#judul_edit").hide();
          $("#edit_ruangan").hide();
          $("#judul").show();

          $('#table_ruangan').DataTable().destroy();
                  
                  var dataTable = $('#table_ruangan').DataTable( {
                    "processing": true,
                    "serverSide": true,
                    "ajax":{
                      url :"datatable_ruangan.php", // json datasource
                      type: "post",  // method  , by default get
                      error: function(){  // error handling
                        $(".tbody").html("");
                        $("#table_ruangan").append('<tbody class="tbody"><tr ><td colspan="3">No data found in the server</td></tr></tbody>');
                        $("#table_ri_processing").css("display","none");
                        
                      }
                    },

                     "fnCreatedRow": function( nRow, aData, iDataIndex ) {
                        $(nRow).attr('class','tr-id-'+aData[3]+'');
                },
                });

       $("#nama_ruangan_edit").val('');
       });
      }
      $("#formruanganedit").submit(function(){
      return false;
      }); 

    });// end $("#tambh_ruangan").click(function()
  });// end $(document).ready(function()
// /MENAMPILKAN FORM EDIT
</script>
<!--=====AKHIR EDIT =====-->

<script type="text/javascript">
  //fungsi hapus data 
$(document).on('click', '.delete', function (e) {
    var nama = $(this).attr("data-nama");
    var id = $(this).attr("data-id");
    $("#nama_ruangan_hapus").val(nama);
    $("#id_hapus").val(id);
    $("#modal_hapus").modal('show');
    
    $(document).on('click', '#btn_jadi_hapus', function (e) {
    
        var id = $("#id_hapus").val();
        $.post("proses_hapus_ruangan.php",{id:id},function(data){
          console.log(data)
        if (data == 1) {
        
        $("#modal_hapus").modal('hide');

            $('#table_ruangan').DataTable().destroy();
            
            var dataTable = $('#table_ruangan').DataTable( {
              "processing": true,
              "serverSide": true,
              "ajax":{
                url :"datatable_ruangan.php", // json datasource
                type: "post",  // method  , by default get
                error: function(){  // error handling
                  $(".tbody").html("");
                  $("#table_ruangan").append('<tbody class="tbody"><tr ><td colspan="3">No data found in the server</td></tr></tbody>');
                  $("#table_ri_processing").css("display","none");
                  
                }
              },

               "fnCreatedRow": function( nRow, aData, iDataIndex ) {
                  $(nRow).attr('class','tr-id-'+aData[3]+'');
          },
           });
        }

        });
    
    });

    });
</script>

<script type="text/javascript">
        $(document).ready(function(){
        $("#kembali").click(function(){

          $("#kembali").hide();
          $("#edit_ruangan").hide();
          $("#judul_edit").hide();
          $("#tambh_ruangan").hide();
          $("#judul").show();
          $("#span_table_ruangan").show();
          $("#tambah_ruangan").show();
        });
        });     
</script>

<script type="text/javascript">
// submit tambah masuk ke tbs
  $(document).ready(function(){
    $("#submit_tambah").click(function(){

     var nama_ruangan = $("#nama_ruangan").val();
      if (nama_ruangan == '') {
        alert("Silakan isi kolom nama ruangan terlebih dahulu.");
        $("#nama_ruangan").focus();
      }
      else
      {

        $.post("proses_tambah_ruangan.php",{nama_ruangan:nama_ruangan},function(info) {
          $("#tambh_ruangan").hide();
          $("#tambah_ruangan").show();
          $("#span_table_ruangan").show();

          $('#table_ruangan').DataTable().destroy();
                  
                  var dataTable = $('#table_ruangan').DataTable( {
                    "processing": true,
                    "serverSide": true,
                    "ajax":{
                      url :"datatable_ruangan.php", // json datasource
                      type: "post",  // method  , by default get
                      error: function(){  // error handling
                        $(".tbody").html("");
                        $("#table_ruangan").append('<tbody class="tbody"><tr ><td colspan="3">No data found in the server</td></tr></tbody>');
                        $("#table_ri_processing").css("display","none");
                        
                      }
                    },

                     "fnCreatedRow": function( nRow, aData, iDataIndex ) {
                        $(nRow).attr('class','tr-id-'+aData[3]+'');
                },
                });

                 $("#nama_ruangan").val('');
       });
      }
      $("#formprogram").submit(function(){
      return false;
      }); 

    });// end $("#tambh_ruangan").click(function()
  });// end $(document).ready(function()

// /submit tambah masuk ke tbs
</script>
<!--=====AKHIR TAMBAH-->
<?php include 'footer.php'; ?>