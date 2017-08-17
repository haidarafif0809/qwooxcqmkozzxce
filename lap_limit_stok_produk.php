<?php include 'session_login.php';
include 'header.php';
include 'navbar.php';
include 'db.php';

?>


<div class="container">

<h3> LAPORAN LIMIT STOK PRODUK </h3><hr>
<br>
<form id="perhari" class="form" role="form">

<div class="col-sm-2">
<select name="status_stok" id="status_stok" autocomplete="off" class="form-control chosen" required="">
<option value="" style="display: none">Status Stok</option>
  <optgroup label="Status Stok">
    <option value="0">SEMUA</option>
    <option value="1">CUKUP</option>
    <option value="2">LIMIT STOK</option>
    <option value="3">OVER STOK</option>
  </optgroup>
</select>
</div>

<div class="col-sm-2"> 
    <input style="height: 17px" type="text" name="sampai_tanggal" id="sampai_tanggal" autocomplete="off" class="form-control tanggal_cari" placeholder="Sampai Tanggal"  required="">
</div>

<button type="submit" name="submit" id="btntgl" class="btn btn-default" style="background-color:blue"><i class='fa fa-list'></i> Lihat </button>

</form>

<style>

tr:nth-child(even){background-color: #f2f2f2}

</style>

<span id="result" style="display: none">
 <div class="card card-block">
 <div class="table-responsive">
    <table id="table_lap" class="table table-bordered table-sm">
 
    <thead>
      <tr>
         <th style="background-color: #4CAF50; color: white;"> Kode Produk</th>
         <th style="background-color: #4CAF50; color: white;"> Nama Produk</th>        
         <th style="background-color: #4CAF50; color: white;"> Jumlah Produk</th>
         <th style="background-color: #4CAF50; color: white;"> Status Stok</th>        
         <th style="background-color: #4CAF50; color: white;"> LImit Stok </th>     
         <th style="background-color: #4CAF50; color: white;"> Over Stok </th>
         <th style="background-color: #4CAF50; color: white;"> Status </th>
    </tr>
    </thead>
    <tbody>
    
  
  </tbody>
 </table>
</div> <!--  end table responsive  -->

</div>

</span>
<span id="cetak" style="display: none;">
  <a href='cetak_lap_limit_produk.php' target="blank" id="cetak_lap" class='btn btn-danger'><i class='fa fa-print'> </i> Cetak Penjualan / Golongan</a>
  <a href='export_lap_limit_produk.php' target="blank" id="export_lap" class='btn btn-primary'><i class='fa fa-download'> </i> Export Excel</a>
</span>

</div>

<!--  date and time picker  -->
<script>
  $(function() {
    $( ".tanggal_cari" ).pickadate({ selectYears: 100, format: 'yyyy-mm-dd'});
  });


</script>



<!--  end date and time picker  -->

<script type="text/javascript">
// FEE PRODUK per PETUGAS DATATABLE MENGGUNAKAN AJAX
  $(document).ready(function() {
  $(document).on('click','#btntgl',function(e) {

        $('#table_lap').DataTable().destroy();
        var status_stok = $("#status_stok").val();
        var sampai_tanggal = $("#sampai_tanggal").val();


          if (status_stok == '') {
            alert("Silakan Pilih Status Penjualan terlebih dahulu.");
            $("#status_stok").trigger('chosen:open');
          }  
          else if (sampai_tanggal == '') {
            alert("Silakan sampai tanggal diisi terlebih dahulu.");
            $("#sampai_tanggal").focus();
          }
            else{ 
              //TABLE KOMISI PRODUK
              var dataTable = $('#table_lap').DataTable( {
                "processing": true,
                "serverSide": true,
                "info":     true,
                "language": {
              "emptyTable":   "My Custom Message On Empty Table"
          },
                "ajax":{
                  url :"proses_lap_limit_produk.php", // json datasource
                   "data": function ( d ) {
                      d.status_stok = $("#status_stok").val();
                      d.sampai_tanggal = $("#sampai_tanggal").val();
                      // d.custom = $('#myInput').val();
                      // etc
                  },
                      type: "post",  // method  , by default get
                  error: function(){  // error handling
                    $(".tbody").html("");
                    $("#table_lap").append('<tbody class="tbody"><tr><th colspan="3"></th></tr></tbody>');
                    $("#tableuser_processing").css("display","none");
                    
                  }
                }
          
              });
    

          $("#cetak").show();
        $("#cetak_lap").attr("href", "cetak_lap_limit_produk.php?status_stok="+status_stok+"&sampai_tanggal="+sampai_tanggal+"");

        $("#export_lap").attr("href", "export_lap_limit_produk.php?status_stok="+status_stok+"&sampai_tanggal="+sampai_tanggal+"");
      
      }//end else

        $("#result").show();

        });
        $("form").submit(function(){
        
        return false;
        
        });  
   });  
   // /FEE PRODUK per PETUGAS DATATABLE MENGGUNAKAN AJAX
</script>

<script type="text/javascript">
  $(".chosen").chosen({no_results_text: "Maaf, Data Tidak Ada!",search_contains:true}); 
</script>

<?php 
include 'footer.php';
 ?>