<?php include 'session_login.php';


 include 'db.php';
 include 'sanitasi.php';
 include 'header.php';
 include 'navbar.php';
 

  $query = $db->query("SELECT * FROM fee_produk");

 ?>




 <div class="container">
 	<div class="row">



<h1> FORM KOMISI PRODUK / PETUGAS </h1>



<br><br>
        <!-- membuat tombol agar menampilkan modal -->
        <button type="button" class="btn btn-danger btn-md" id="cari_petugas" data-toggle="modal" data-target="#myModal"><i class="fa fa-search"> </i> Cari Petugas</button>
        <br><br>
        <!-- Tampilan Modal -->
        <div id="myModal" class="modal fade" role="dialog">
        <div class="modal-dialog modal-lg">
        
        <!-- Isi Modal-->
        <div class="modal-content">
        <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title">Data User</h4>
        </div>
        <div class="modal-body"> <!--membuat kerangka untuk tempat tabel -->
        
        <!--perintah agar modal update-->
<span class="modal_baru">
 <div class="table-responsive">       
<table id="tableuser" class="table table-bordered">
    <thead>
      <th> Username </th></th>
      <th> Nama Lengkap </th>
      <th> Alamat </th>
      <th> Jabatan </th>
      <th> Otoritas </th>
      <th> Status </th>

      
    </thead>
    
  

  </table>
</div>
</span>
          
</div> <!-- tag penutup modal body -->
        
        <!-- tag pembuka modal footer -->
        <div class="modal-footer">
       
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
        </div> <!--tag penutup moal footer -->
        </div>
        
        </div>
        </div>

<form action="proses_fee_produk.php" method="post">
          <div class="form-group">
          <label> Nama Petugas </label><br>
          <input type="text" name="nama_petugas" id="nama_petugas" placeholder="Nama Petugas" class="form-control" readonly="">
          <input type="hidden" name="id_user" id="id_user" class="form-control" readonly="">
          </div>

</form>

<br><br>
        <!-- membuat tombol agar menampilkan modal -->
        <button type="button" class="btn btn-warning btn-md" id="cari_produk" data-toggle="modal" data-target="#my_Modal"><i class="fa fa-search"> </i> Cari Produk</button>
        <button type="button" class="btn btn-info btn-md" id="jasa_lab" data-toggle="modal" data-target="#modal_lab"><i class="fa fa-stethoscope"> </i> Jasa Laboratorium</button>
        <br><br>
        <!-- Tampilan Modal -->
        <div id="my_Modal" class="modal fade" role="dialog">
        <div class="modal-dialog modal-lg">
        
        <!-- Isi Modal-->
        <div class="modal-content">
        <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title">Data Barang</h4>
        </div>
        <div class="modal-body"> <!--membuat kerangka untuk tempat tabel -->
        
        <!--perintah agar modal update-->



        <span class="modal_baru">
          <div class="table-responsive">                             <!-- membuat agar ada garis pada tabel, disetiap kolom-->
        <table id="table-barang" class="table table-bordered">

        <thead> <!-- untuk memberikan nama pada kolom tabel -->
        
            <th> Kode Barang </th>
            <th> Nama Barang </th>
            <th> Harga Beli </th>
            <th> Harga Jual </th>
            <th> Jumlah Barang </th>
            <th> Satuan </th>
            <th> Kategori </th>
            <th> Status </th>
            <th> Suplier </th>
        
        </thead> <!-- tag penutup tabel -->
       
        </table> <!-- tag penutup table-->

        </div>
</span>
        	
</div> <!-- tag penutup modal body -->
        
        <!-- tag pembuka modal footer -->
        <div class="modal-footer">
       
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
        </div> <!--tag penutup moal footer -->
        </div>
        
        </div>
        </div>



       <!-- Tampilan Modal -->
        <div id="modal_lab" class="modal fade" role="dialog">
        <div class="modal-dialog modal-lg">
        
        <!-- Isi Modal-->
        <div class="modal-content">
        <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title">Data Jasa Laboratorium</h4>
        </div>
        <div class="modal-body"> <!--membuat kerangka untuk tempat tabel -->
        
        <!--perintah agar modal update-->



        <span class="modal_baru">
          <div class="table-responsive">                             <!-- membuat agar ada garis pada tabel, disetiap kolom-->
        <table id="table-lab" class="table table-bordered">

        <thead> <!-- untuk memberikan nama pada kolom tabel -->
        
        <th>Kode Jasa </th>
        <th>Nama Pemeriksaan </th>
        <th>Kelompok Pemeriksaan</th>
        <th>Persiapan</th>
        <th>Metode</th>
        <th>Harga 1</th>
        <th>Harga 2</th>
        <th>Harga 3</th>
        <th>Harga 4</th>
        <th>Harga 5</th>
        <th>Harga 6</th>   
        <th>Harga 7</th>
        
        </thead> <!-- tag penutup tabel -->
       
        </table> <!-- tag penutup table-->

        </div>
</span>
          
</div> <!-- tag penutup modal body -->
        
        <!-- tag pembuka modal footer -->
        <div class="modal-footer">
       
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
        </div> <!--tag penutup moal footer -->
        </div>
        
        </div>
        </div>

<form action="proses_fee_produk.php" method="post">
<div class="form-group">
					<div class="form-group">
					<label> Nama Produk </label><br>
					<input type="text" name="nama_produk" id="nama_produk" placeholder="Nama Produk" class="form-control" readonly="">
					</div>

					<div class="form-group">
					<label> Kode Produk </label><br>
					<input type="text" name="kode_produk" id="kode_produk" placeholder="Kode Produk " class="form-control" readonly="">
					</div>
<span id="prosentase">
					<div class="form-group">
					<label> Jumlah Prosentase ( % ) </label><br>
					<input type="text" name="jumlah_prosentase" placeholder="Jumlah Prosentase" id="jumlah_prosentase" class="form-control" autocomplete="off">
					</div>
</span>
<span id="nominal">
					<div class="form-group">
					<label> Jumlah Nominal ( Rp )</label><br>
					<input type="text" name="jumlah_uang" id="jumlah_nominal" placeholder="Jumlah Nominal" class="form-control" autocomplete="off">
					</div>
</span>
					<button type="submit" id="tambah_fee" class="btn btn-info"><span class="glyphicon glyphicon-plus"> </span> Tambah</button>

</div>
</form>


<span id="alert">
  

</span>

</div><!-- end row -->
<br>
<br>
<label> User : <?php echo $_SESSION['user_name']; ?> </label> 



<span id="demo"> </span>
</div><!-- end container -->



      <script type="text/javascript" language="javascript" >
      $(document).ready(function() {

          var dataTable = $('#table-barang').DataTable( {
          "processing": true,
          "serverSide": true,
          "ajax":{
            url :"proses_table_fee_barang.php", // json datasource
                type: "post",  // method  , by default get
            error: function(){  // error handling
              $(".tbody").html("");
              $("#table-barang").append('<tbody class="tbody"><tr><th colspan="3">No data found in the server</th></tr></tbody>');
              $("#table-barang_processing").css("display","none");
              
            }
          },
              "fnCreatedRow": function( nRow, aData, iDataIndex ) {
              $(nRow).attr('class','pilih_barang');
              $(nRow).attr('data-kode',aData[0]);
              $(nRow).attr('nama-barang',aData[1]);
              $(nRow).attr('satuan',aData[5]);
              $(nRow).attr('harga',aData[2]);
              $(nRow).attr('jumlah-barang',aData[4]);
    },
 } );
          } );
    </script>



           <script type="text/javascript" language="javascript" >
      $(document).ready(function() {

          var dataTable = $('#table-lab').DataTable( {
          "processing": true,
          "serverSide": true,
          "ajax":{
            url :"proses_table_fee_jasa_lab.php", // json datasource
                type: "post",  // method  , by default get
            error: function(){  // error handling
              $(".tbody").html("");
              $("#table-lab").append('<tbody class="tbody"><tr><th colspan="3">No data found in the server</th></tr></tbody>');
              $("#table-lab_processing").css("display","none");
              
            }
          },
              "fnCreatedRow": function( nRow, aData, iDataIndex ) {
              $(nRow).attr('class','pilih_lab');
              $(nRow).attr('data-kode',aData[0]);
              $(nRow).attr('nama-barang',aData[1]);
    },
 } );


          var dataTable = $('#tableuser').DataTable( {
          "processing": true,
          "serverSide": true,
          "ajax":{
            url :"proses_table_fee_produk.php", // json datasource
                type: "post",  // method  , by default get
            error: function(){  // error handling
              $(".tbody").html("");
              $("#tableuser").append('<tbody class="tbody"><tr><th colspan="3">No data found in the server</th></tr></tbody>');
              $("#tableuser_processing").css("display","none");
              
            }
          },
              "fnCreatedRow": function( nRow, aData, iDataIndex ) {
              $(nRow).attr('class','pilih');
              $(nRow).attr('data-petugas',aData[1]);
              $(nRow).attr('data-id_petugas',aData[6]);
    },
 } );





          } );
    </script>




<script type="text/javascript">

// jika dipilih, nim akan masuk ke input dan modal di tutup
  $(document).on('click', '.pilih', function (e) {
  document.getElementById("id_user").value = $(this).attr('data-id_petugas');

  document.getElementById("nama_petugas").value = $(this).attr('data-petugas');

  $('#myModal').modal('hide');
  });
   
   
  </script> <!--tag penutup perintah java script-->


<!-- untuk memasukan perintah javascript -->
<script type="text/javascript">

// jika dipilih, nim akan masuk ke input dan modal di tutup
  $(document).on('click', '.pilih_barang', function (e) {
  document.getElementById("kode_produk").value = $(this).attr('data-kode');
  document.getElementById("nama_produk").value = $(this).attr('nama-barang');

  
  $('#my_Modal').modal('hide');
  });
   
   
  </script> <!--tag penutup perintah java script-->

  <!-- untuk memasukan perintah javascript -->
<script type="text/javascript">

// jika dipilih, nim akan masuk ke input dan modal di tutup
  $(document).on('click', '.pilih_lab', function (e) {
  document.getElementById("kode_produk").value = $(this).attr('data-kode');
  document.getElementById("nama_produk").value = $(this).attr('nama-barang');

  
  $('#modal_lab').modal('hide');
  });
   
   
  </script> <!--tag penutup perintah java script-->

<script type="text/javascript">
   $("#cari_petugas").click(function(){

       $("#alert_berhasil").hide('fast');
       $("#alert_gagal").hide('fast');

   });
</script>

   <script>
   //perintah javascript yang diambil dari form proses_bayar_beli.php dengan id=form_beli
  $("#tambah_fee").click(function(){

       var nama_petugas = $("#id_user").val();      
       var petugas = $("#nama_petugas").val();     
       var nama_produk = $("#nama_produk").val();
       var kode_produk = $("#kode_produk").val();
       var jumlah_prosentase = $("#jumlah_prosentase").val();
       var jumlah_nominal = $("#jumlah_nominal").val();
       
       

 if (jumlah_prosentase > 100)
 {

  alert("Jumlah Prosentase Melebihi 100% ");

 }

 else if (nama_petugas == "") {

  alert ("Silahkan Isi Nama Petugas")
 }

 else if (nama_produk == "") {

  alert ("Silahkan Isi Nama Produk")
 }

 else

 {

 	$.post("proses_tambah_fee_produk_petugas.php",{nama_petugas:nama_petugas,nama_produk:nama_produk,kode_produk:kode_produk,jumlah_prosentase:jumlah_prosentase,jumlah_uang:jumlah_nominal},function(info){

$("#alert").html(info);

    $("#alert_berhasil").show('fast');
    $("#alert_gagal").show('fast');
     $("#nama_produk").val('');
     $("#kode_produk").val('');
     $("#jumlah_prosentase").val('');
     $("#jumlah_nominal").val('');
     $("#nama_petugas").val('');

    
       
   });



 }


 $("form").submit(function(){
    return false;
});

    

  });
        
  </script>

  <script type="text/javascript">
  
      $("#jumlah_prosentase").keyup(function(){
      var jumlah_prosentase = $("#jumlah_prosentase").val();
      var jumlah_nominal = $("#jumlah_nominal").val();
      
      if (jumlah_prosentase > 100)
      {

          alert("Jumlah Prosentase Melebihi ??");
          $("#jumlah_prosentase").val('');
      }

      else if (jumlah_prosentase == "") 
      {
        $("#nominal").show();
      }

      else
      {
            $("#nominal").hide();
      }


    
      });


              $("#jumlah_nominal").keyup(function(){
              var jumlah_nominal = $("#jumlah_nominal").val();
              var jumlah_prosentase = $("#jumlah_prosentase").val();
              
              if (jumlah_nominal == "") 
              {
              $("#prosentase").show();
              }
              
              else
              {
              $("#prosentase").hide();
              }
              
              
              
              });

                  $("#cari_petugas").click(function(){
                    $("#alert").hide(fast);
                  });
     

  </script>


<?php include 'footer.php'; ?>