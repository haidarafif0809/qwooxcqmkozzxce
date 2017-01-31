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

<h3><b> DATA PENYESUAIAN STOK </b></h3> <hr>


<style>

tr:nth-child(even){background-color: #f2f2f2}

</style>

<span id="table_baru">
<div class="table-responsive"> 
<table id="table_penyesuaian" class="table table-bordered table-sm">
    <thead>
      <tr>
         <th style='background-color: #4CAF50; color: white; '>No Faktur</th>
         <th style='background-color: #4CAF50; color: white; '>Kode Kamar</th>
         <th style='background-color: #4CAF50; color: white; '>Nama Kamar </th>
         <th style='background-color: #4CAF50; color: white; '>Jenis Transaksi</th>
         <th style='background-color: #4CAF50; color: white; '>Jumlah Penyesuaian</th>
         <th style='background-color: #4CAF50; color: white; '>Harga Penyesuaian</th>
         <th style='background-color: #4CAF50; color: white; '>Total Penyesuaian </th>
         <th style='background-color: #4CAF50; color: white; '>Sisa Penyesuaian</th>
         <th style='background-color: #4CAF50; color: white; '>Tanggal </th>
         <th style='background-color: #4CAF50; color: white; '>Jam</th>
    </tr>
    </thead>

 </table>
</div>


</span>



</div><!--CONTAINER-->



<!--DATA TABLE MENGGUNAKAN AJAX-->
<script type="text/javascript" language="javascript" >
      $(document).ready(function() {

          var dataTable = $('#table_penyesuaian').DataTable( {
          "processing": true,
          "serverSide": true,
          "ajax":{
            url :"datatable_penyesuaian_stok.php", // json datasource
           
            type: "post",  // method  , by default get
            error: function(){  // error handling
              $(".employee-grid-error").html("");
              $("#table_penyesuaian").append('<tbody class="employee-grid-error"><tr><th colspan="3">No data found in the server</th></tr></tbody>');
              $("#employee-grid_processing").css("display","none");
            }
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