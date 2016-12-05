<?php include 'session_login.php';
include 'header.php';
include 'navbar.php';
include 'db.php';
include 'sanitasi.php';


$query = $db->query("SELECT * FROM jenis ORDER BY id DESC ");

$pilih_akses_jenis_obat = $db->query("SELECT jenis_obat_tambah, jenis_obat_edit, jenis_obat_hapus FROM otoritas_master_data WHERE id_otoritas = '$_SESSION[otoritas_id]'");
$jenis_obat = mysqli_fetch_array($pilih_akses_jenis_obat);

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



<h3><b>Jenis Obat</b></h3><hr>
<?php if ($jenis_obat['jenis_obat_tambah'] > 0): ?>
  <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#modal"><i class="fa fa-plus"></i> Tambah</button>
 <br>
<br>
<?php endif ?>



<span id="table_baru">
<div class="table-responsive">  
  <table id="table-pelamar" class="table table-bordered table-sm">
    <thead>
    <tr>
      <th style='background-color: #4CAF50; color: white'>Nama Jenis Obat</th>
      <th style='background-color: #4CAF50; color: white' >Hapus</th>
    </tr>
    </thead>
  <tbody>

 <style>

tr:nth-child(even){background-color: #f2f2f2}

</style>  
   <?php while($data = mysqli_fetch_array($query))
      {
      echo 
      "<tr class='tr-id-".$data['id']."'>";
      if ($jenis_obat['jenis_obat_edit'] > 0) {
        echo "<td class='edit-jual' data-id='".$data['id']."' ><span id='text-jual-".$data['id']."'>". $data['nama'] ."</span> <input type='hidden' id='input-jual-".$data['id']."' value='".$data['nama']."' class='input_jual' data-id='".$data['id']."' autofocus=''></td>";
      }
      else{
        echo "<td>". $data['nama'] ."</td>";
      }

      if ($jenis_obat['jenis_obat_hapus'] > 0) {
        echo "<td><button data-id='".$data['id']."' class='btn btn-danger delete'><span class='glyphicon glyphicon-trash'></span> Hapus </button>
      </td>";
      }
      else{
        echo "<td> </td>";
      }

      

      echo"
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
          <h4 class="modal-title">Form Tambah Jenis Obat </h4>
        </div>
        <div class="modal-body">
          <form role="form" action="proses_tambah_jenis_obat.php" method="POST">
<div class="form-group">
  <label for="sel1">Nama Jenis Obat</label>
  <input type="text" class="form-control" id="jenis" name="jenis">
</div>

<br>
<button type="submit" class="btn btn-info"><span class="glyphicon glyphicon-plus"></span> Tambah</button>
</form>
</div>
      <div class="modal-footer">
          <button type="button" class="btn btn-warning" data-dismiss="modal">Close</button>
        </div>
      </div>
    </div>
  </div>

</div><!--div container-->




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


    $(".tr-id-"+id+"").remove();

$.post('delete_jenis_obat.php',{id:id},function(data){
    
      $("#modale-delete").modal('hide');

    });

});
</script>
<!--  end modal confirmasi delete lanjutan  -->


<!--datatable-->
<script type="text/javascript">
  $(function () {
  $("table").dataTable({"ordering": false});
  }); 
</script>
<!--end datatable--> 



              <script type="text/javascript">
                                 //edit harga jual 1
                                 $(".edit-jual").dblclick(function(){

                                    var id = $(this).attr("data-id");

                                    $("#text-jual-"+id+"").hide();

                                    $("#input-jual-"+id+"").attr("type", "text");

                                 });
</script>

          <script type="text/javascript">
                                 $(".input_jual").blur(function(){

                                    var id = $(this).attr("data-id");

                                    var nama = $(this).val();


                                    $.post("update_jenis_obat.php",{id:id,nama:nama},function(data){

                                    $("#text-jual-"+id+"").show();
                                    $("#text-jual-"+id+"").text(nama);

                                    $("#input-jual-"+id+"").attr("type", "hidden");           

                                    });
                                 });

                             </script>
<!--DATA TABLE MENGGUNAKAN AJAX
<script type="text/javascript" language="javascript" >
      $(document).ready(function() {

          var dataTable = $('#table_jenis').DataTable( {
          "processing": true,
          "serverSide": true,
          "ajax":{
            url :"datatable_jenis_obat.php", // json datasource
           
            type: "post",  // method  , by default get
            error: function(){  // error handling
              $(".employee-grid-error").html("");
              $("#table_jenis").append('<tbody class="employee-grid-error"><tr><th colspan="3">No data found in the server</th></tr></tbody>');
              $("#employee-grid_processing").css("display","none");
            }
        },
            
            "fnCreatedRow": function( nRow, aData, iDataIndex ) {
                $(nRow).attr('class','tr-id-'+aData[2]+'');
            },
        });

        $("#form").submit(function(){
        return false;
        });
        

      } );
    </script>
/DATA TABLE MENGGUNAKAN AJAX-->

<!--footer-->
<?php 
include 'footer.php';
?>
<!--end footer-->
