<?php include 'session_login.php';
include 'header.php';
include 'navbar.php';
include 'db.php';

?>


<div class="container">

<h3> LAPORAN PENJUALAN REKAP PER GOLONGAN BARANG </h3><hr>
<br><br><br>
<form id="perhari" class="form" role="form">

<div class="col-sm-2"> 
<select name="golongan" id="golongan" autocomplete="off" class="form-control" placeholder="Golongan" required="">
<option value="Barang">Barang</option>
<option value="Jasa">Jasa</option>
</select>
</div>

<div class="col-sm-2"> 
    <input style="height: 17px" type="text" name="dari_tanggal" id="dari_tanggal" autocomplete="off" class="form-control tanggal_cari" placeholder="Dari Tanggal" required="">
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
         <th style="background-color: #4CAF50; color: white;">Nama Produk</th>
         <th style="background-color: #4CAF50; color: white;"> Total Produk</th>        
         <th style="background-color: #4CAF50; color: white;"> Total Nilai </th>

    </tr>
    </thead>
    <tbody>
    
  
  </tbody>
 </table>
</div> <!--  end table responsive  -->
<h4>
<td>Total Seluruh </td><br> 
<td>Total Produk : <span id="total_produk"></span></td><br> 
<td>Total Nilai &nbsp;&nbsp;&nbsp;  : <span id="total_nilai"></span></td><br> 
</h4>
</div>

</span>
<span id="cetak" style="display: none;">
  <a href='cetak_penjualan_rekap_golongan.php' target="blank" id="cetak_lap" class='btn btn-danger'><i class='fa fa-print'> </i> Cetak Penjualan / Golongan</a>
  <a href='export_lap_penjualan_golongan.php' target="blank" id="export_lap" class='btn btn-primary'><i class='fa fa-print'> </i> Export Excel</a>
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
        var golongan = $("#golongan").val();
        var dari_tanggal = $("#dari_tanggal").val();        
        var sampai_tanggal = $("#sampai_tanggal").val();




    $.getJSON('ambil_total_seluruh.php',{golongan:golongan,dari_tanggal:dari_tanggal,sampai_tanggal:sampai_tanggal},function(json){

      if (golongan == 'Jasa') 
      {

              $.getJSON('ambil_total_seluruh_lab.php',{golongan:golongan,dari_tanggal:dari_tanggal,sampai_tanggal:sampai_tanggal},function(data){

                if (data.total == null) { 
                  data.total = 0;
                }

                if (data.jumlah == null) {
                  data.jumlah = 0;
                }

                var total_nilai = parseInt(json.total,10) + parseInt(data.total,10);
                var total_produk = parseInt(json.jumlah,10) + parseInt(data.jumlah,10);

                $("#total_nilai").html(tandaPemisahTitik(total_nilai));
                $("#total_produk").html(tandaPemisahTitik(total_produk));

            });

      }
      else{
      $("#total_nilai").html(tandaPemisahTitik(json.total));
      $("#total_produk").html(tandaPemisahTitik(json.jumlah));
      }


  });

          if (golongan == '') {
            alert("Silakan Pilih Golongan terlebih dahulu.");
            $("#golongan").focus();
          } 
          else if (dari_tanggal == '') {
            alert("Silakan dari tanggal diisi terlebih dahulu.");
            $("#dari_tanggal").focus();
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
                  url :"proses_lap_golongan_barang_rekap.php", // json datasource
                   "data": function ( d ) {
                      d.golongan = $("#golongan").val();
                      d.dari_tanggal = $("#dari_tanggal").val();
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
        $("#cetak_lap").attr("href", "cetak_penjualan_rekap_golongan.php?golongan="+golongan+"&dari_tanggal="+dari_tanggal+"&sampai_tanggal="+sampai_tanggal+"");

        $("#export_lap").attr("href", "export_lap_penjualan_golongan.php?golongan="+golongan+"&dari_tanggal="+dari_tanggal+"&sampai_tanggal="+sampai_tanggal+"");
      
      }//end else

                $("#result").show();

        });
        $("form").submit(function(){
        
        return false;
        
        });  
   });  
   // /FEE PRODUK per PETUGAS DATATABLE MENGGUNAKAN AJAX
</script>

<?php 
include 'footer.php';
 ?>