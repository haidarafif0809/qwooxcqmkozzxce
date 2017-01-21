<?php include 'session_login.php';


//memasukkan file session login, header, navbar, db.php
include 'header.php';
include 'navbar.php';
include 'sanitasi.php';
include 'db.php';


 ?>


<!-- js untuk tombol shortcut -->
 <script src="shortcut.js"></script>
<!-- js untuk tombol shortcut -->

<div class="container">


<!--tampilan modal-->
<div id="myModal" class="modal fade" role="dialog">
  <div class="modal-dialog">

    <!-- isi modal-->
    <div class="modal-content">

      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title"><center><b>Data Barang</b></center></h4>
      </div>
      <div class="modal-body">


<center>
      <div class="table-resposive">
           <table id="table_kartu_stok" class="table table-bordered table-sm">
           <thead> <!-- untuk memberikan nama pada kolom tabel -->
                              
            <th> Kode Barang </th>
            <th> Nama Barang </th>
            <th> Jumlah Barang </th>
            <th> Satuan </th>
            <th> Kategori </th>
            <th> Status </th>
                              
           </thead> <!-- tag penutup tabel -->
           </table>
      </div>
</center>

</div> <!-- tag penutup modal-body-->
      <div class="modal-footer">
        <center><b><button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
      </div></b></center>
    </div>

  </div>
</div>
<!-- end of modal data barang  -->



<h1>Kartu Stok</h1> 

<button type="button" id="cari_produk_penjualan" class="btn btn-info " data-toggle="modal" data-target="#myModal"><i class='fa  fa-search'> Cari (F1)</i>  </button> 
<br><br>
<form class="form-inline" role="form" id="form_tanggal">

<div class="form-group">
    <label> Kode Barang </label><br>
    <input type="text" style="width:225px" name="kode_barang" id="kode_barang" required="" placeholder="Ketikkan Kode / Nama (Barang)" autocomplete="off" class="form-control" >
</div>

<!-- Start Input Hidden-->
<div class="form-group">
<input type="hidden" class="form-control" name="nama_barang" autocomplete="off" id="nama_barang" placeholder="nama">
<input type="hidden" id="id_produk" name="id_produk" class="form-control" value="" required="">  
</div>
<!-- Ending Input Hidden-->


<div class="form-group">
          <label> Bulan </label><br>
          <select type="text" name="bulan" id="bulan" class="form-control" required="">
            <option value=""> --SILAKAN PILIH-- </option>
            <option value="1"> Januari </option>
            <option value="2"> Februari </option>
            <option value="3"> Maret </option>
            <option value="4"> April </option>
            <option value="5"> Mei </option>
            <option value="6"> Juni </option>
            <option value="7"> Juli </option>
            <option value="8"> Agustus </option>
            <option value="9"> September </option>
            <option value="10"> Oktober </option>
            <option value="11"> November </option>
            <option value="12"> Desember </option>
          </select> 
</div>


<div class="form-group">
          <label> Tahun </label><br>
          <select type="text" name="tahun" id="tahun" class="form-control" required="">
          <option value=""> --SILAKAN PILIH-- </option>
            <option value="2016"> 2016 </option>
            <option value="2017"> 2017 </option>
            <option value="2018"> 2018 </option>
            <option value="2019"> 2019 </option>
            <option value="2020"> 2020 </option>
          </select> 
          </div>


<button type="submit" name="submit" id="lihat_kartu_stok" class="btn btn-default" style="background-color:#0277bd"><i class="fa fa-eye"> </i> Lihat </button>
</form>


<div class="table-responsive">
    
    <table id="table-kartustok" class="table table-bordered table-sm">

        <thead>

      <th style='background-color: #4CAF50; color:white'> No Faktur </th>
      <th style='background-color: #4CAF50; color:white'> Jenis Transaksi </th>
      <th style='background-color: #4CAF50; color:white'> Tanggal </th>
      <th style='background-color: #4CAF50; color:white'> Jumlah Masuk</th>
      <th style='background-color: #4CAF50; color:white'> Jumlah Keluar</th>
      <th style='background-color: #4CAF50; color:white'> Saldo</th>
            
           </thead>

     </table>

</div>
<a href='export_kartu_stok.php' type='submit' id="btn-export" class='btn btn-default' style="display: none;"><i class="fa fa-download"> Download Excel</i></a>

</div><!--Div Container-->


 <script type="text/javascript" language="javascript" >
      $(document).ready(function() {
$(document).on('click','#lihat_kartu_stok',function(e) {

        var kode_barang = $("#kode_barang").val();
        var kode_barang = kode_barang.substr(0, kode_barang.indexOf('('));       
        var nama_barang = $("#nama_barang").val();   
        var id_produk = $("#id_produk").val();        
        var bulan = $("#bulan").val();        
        var tahun = $("#tahun").val();

        $("#btn-export").attr('href','export_kartu_stok.php?id_produk='+id_produk+'&kode_barang='+kode_barang+'&nama_barang='+nama_barang+'&bulan='+bulan+'&tahun='+tahun+'');
$("#btn-export").show();

     $('#table-kartustok').DataTable().destroy();

          var dataTable = $('#table-kartustok').DataTable( {
          "processing": true,
          "serverSide": true,
          "info":     false,
          "language": {
        "emptyTable":     "My Custom Message On Empty Table"
    },
          "ajax":{
            url :"show_kartu_stok.php", // json datasource
             "data": function ( d ) {
                var kode_barang = $("#kode_barang").val();
                d.kode_barang = kode_barang.substr(0, kode_barang.indexOf('('));       
                d.nama_barang = $("#nama_barang").val();   
                d.id_produk = $("#id_produk").val();        
                d.bulan = $("#bulan").val();        
                d.tahun = $("#tahun").val();
                // d.custom = $('#myInput').val();
                // etc
            },
                type: "post",  // method  , by default get
            error: function(){  // error handling
              $(".tbody").html("");
              $("#table-kartustok").append('<tbody class="tbody"><tr><th colspan="3"></th></tr></tbody>');
              $("#table-kartustok_processing").css("display","none");
              
            }
          }
    


        } );
          $("#result").show()

   } );  

  $("form").submit(function(){
      return false;
  });

  } );
    </script>

<!--

<script type="text/javascript">
//berdasarkan rm dan tanggal
        $("#lihat_kartu_stok").click(function(){

        var kode_barang = $("#kode_barang").val();
        var kode_barang = kode_barang.substr(0, kode_barang.indexOf('('));       
        var nama_barang = $("#nama_barang").val();   
        var id_produk = $("#id_produk").val();        
        var bulan = $("#bulan").val();        
        var tahun = $("#tahun").val();

        if(kode_barang == '')
        {
          alert("Masukan Kode Barang Terlebih Dahulu!");
          $("#kode_barang").focus();

        }
        else if(bulan == '')
        {
          alert("Pilih Bulan Yang Akan di Tampilkan!!");
          $("#bulan").focus();
        }
        else if(tahun == '')
        {
          alert("Pilih Tahun Yang Akan di Tampilkan!!");
          $("#tahun").focus();
        }
        else
        {

        $.post("show_kartu_stok.php", {kode_barang:kode_barang,nama_barang:nama_barang,id_produk:id_produk,bulan:bulan,tahun:tahun},function(info){
        
        $("#result").html(info);

        });
            }  
        });
           
        $("form").submit(function(){
        
        return false;
        
        });
        
</script>


-->
<script>
// untuk memunculkan data tabel 
$(document).ready(function() {
        $('#table-kartustok').DataTable({"ordering":false});
    });

</script>

<script type="text/javascript">
  $("#cari_produk_penjualan").click(function() {

      //menyembunyikan notif berhasil
      $("#alert_berhasil").hide();
      
      /* Act on the event */
      });

</script>

<script type="text/javascript">
  $(document).ready(function(){
    var kode_pelanggan = $("#kd_pelanggan").val();
    $("#table_kartu_stok").DataTable().destroy();
          var dataTable = $('#table_kartu_stok').DataTable( {
          "processing": true,
          "serverSide": true,
          "ajax":{
            url :"modal_kartu_stok_baru.php", // json datasource
            type: "post",  // method  , by default get
            error: function(){  // error handling
              $(".employee-grid-error").html("");
              $("#table_kartu_stok").append('<tbody class="employee-grid-error"><tr><th colspan="3">Data Tidak Ditemukan.. !!</th></tr></tbody>');
              $("#employee-grid_processing").css("display","none");
              
            }
          },

          "fnCreatedRow": function( nRow, aData, iDataIndex ) {

              $(nRow).attr('class', "pilih");
              $(nRow).attr('data-kode', aData[0]+"("+aData[1]+")");
              $(nRow).attr('nama-barang', aData[1]);
              $(nRow).attr('id-barang', aData[6]);


          }

        }); 
});
</script>



<script type="text/javascript">
   shortcut.add("f1", function() {
        // Do something

        $("#cari_produk_penjualan").click();

    });
</script>

<script>
$(function() {
    $( "#kode_barang" ).autocomplete({
        source: 'kode_barang_autocomplete.php'
    });
});
</script>


<!--untuk memasukkan perintah java script-->
<script type="text/javascript">
// jika dipilih, nim akan masuk ke input dan modal di tutup
  $(document).on('click', '.pilih', function (e) {

  document.getElementById("kode_barang").value = $(this).attr('data-kode');
  document.getElementById("nama_barang").value = $(this).attr('nama-barang');
  document.getElementById("id_produk").value = $(this).attr('id-barang');

  $('#myModal').modal('hide');

});

  </script>




<?php include 'footer.php'; ?>
