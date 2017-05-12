<?php include 'session_login.php';

 include 'header.php';
 include 'navbar.php';
 include 'db.php';
 include 'sanitasi.php';
 
 $session_id = session_id(); 
 
 $perintah50 = $db->query("SELECT * FROM tbs_pembayaran_piutang WHERE session_id = '$session_id'");
 $data50 = mysqli_fetch_array($perintah50);
 $no_faktur_penjualan = $data50['no_faktur_penjualan']; 

 ?>

      <script>
      $(function() {
      $( "#tanggal" ).datepicker({dateFormat: "yy-mm-dd"});
      });
      </script>




 <div style="padding-left: 5%; padding-right: 5%">
<h3> <u>FORM PEMBAYARAN PIUTANG</u> </h3>
<br><br>


<!-- Modal Hapus data -->
<div id="modal_hapus" class="modal fade" role="dialog">
  <div class="modal-dialog">

    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title">Konfirmsi Hapus Data Pembayaran Piutang</h4>
      </div>

      <div class="modal-body">
   
   <p>Apakah Anda yakin Ingin Menghapus Data ini ?</p>
   <form >
    <div class="form-group">
    <label> Nomor Faktur Penjualan:</label>
     <input type="text" id="no_faktur_penjualan" class="form-control" readonly=""> 
     <input type="hidden" id="jumlah_piutang" class="form-control" readonly="">
     <input type="hidden" id="id_hapus" class="form-control" > 
    </div>
   
   </form>
   
  <div class="alert alert-success" style="display:none">
   <strong>Berhasil!</strong> Data berhasil Di Hapus
  </div>
 

     </div>

      <div class="modal-footer">
        <button type="button" class="btn btn-info" id="btn_jadi_hapus"><span class='glyphicon glyphicon-ok-sign'> </span> Ya</button>
        <button type="button" class="btn btn-warning" data-dismiss="modal"><span class='glyphicon glyphicon-remove-sign'> </span> Batal</button>
      </div>
    </div>

  </div>
</div><!-- end of modal hapus data  -->

<!-- Modal edit data -->
<div id="modal_edit" class="modal fade" role="dialog">
  <div class="modal-dialog">

    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title">Edit Data Pembelian Barang</h4>
      </div>
      <div class="modal-body">
  <form role="form">
   <div class="form-group">
    <label for="email">Jumlah Bayar Baru:</label>
     <input type="text" class="form-control" autocomplete="off" id="bayar_edit"><br>
    <label for="email">Potongan Baru:</label>
     <input type="text" class="form-control" autocomplete="off" id="potongan_edit"><br>

    <label for="email">Jumlah Bayar Lama:</label>
     <input type="text" class="form-control" id="bayar_lama" readonly="">

    <label for="email">Potongan Lama:</label>
     <input type="text" class="form-control" id="potongan_lama" readonly="">
     <input type="hidden" class="form-control" id="id_edit">
     <input type="hidden" class="form-control" id="kredit_edit">
     <input type="hidden" class="form-control" id="no_faktur_penjualan1">
    
   </div>
   
   
   <button type="submit" id="submit_edit" class="btn btn-default">Submit</button>
  </form>

  <span id="alert"></span>
  <div class="alert-edit alert-success" style="display:none">
   <strong>Berhasil!</strong> Data berhasil Di Edit
  </div>
 

      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
      </div>
    </div>

  </div>
</div><!-- end of modal edit data  -->


<form action="proses_tbs_pembayaran_piutang.php" role="form" method="post" id="formtambahproduk">

<button type="button" class="btn btn-info" id="cari_produk_penjualan" data-placement="top" data-target="#myModal" data-toggle="modal" title="Cari Penjualan Piutang"> <i class='fa fa-search'> </i> Cari Piutang</button>
<br>

<!-- Tampilan Modal -->
<div id="myModal" class="modal fade" role="dialog">
  <div class="modal-dialog modal-lg">

    <!-- Isi Modal-->
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title">Data Penjualan Piutang</h4>
      </div>
      <div class="modal-body"> <!--membuat kerangka untuk tempat tabel -->

  <div class="form-group col-sm-3">
    <label>Penjamin</label><br>
      <select type="text" name="penjamin" id="penjamin" class="form-control chosen" required="">
        <option value="">Semua Penjamin</option>
          <?php 
            $query_penjamin = $db->query("SELECT nama FROM penjamin ");
              while($data_penjamin = mysqli_fetch_array($query_penjamin)){                
                  echo "<option value='".$data_penjamin['nama'] ."'> ".$data_penjamin['nama'] ."</option>";
              }
          ?>
      </select>
  </div>

      <!--perintah agar modal update-->
<span class="modal_piutang_baru">
    <div class="table-responsive">
      <table id="table_piutang" class="table table-bordered table-sm">
        <thead> <!-- untuk memberikan nama pada kolom tabel -->
          
            <th> Nomor Faktur </th>
            <th> Kode Pelanggan</th>
            <th> Nama Pelanggan</th>
            <th> Total </th>
            <th> Tanggal </th>
            <th> Tanggal Jatuh Tempo </th>
            <th> Jam </th>
            <th> User </th>
            <th> Status </th>
            <th> Potongan </th>
            <th> Tax </th>
            <th> Sisa </th>
            <th> Kredit </th>
          
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
    

    
<form class="form-inline" role="form" id="formtambahproduk">
<div class="row">

  
<div class="col-sm-8">


  <div class="form-group col-sm-2">
    <input type="text" class="form-control" name="no_faktur_penjualan" id="nomorfakturbeli" placeholder="No Faktur" readonly="">
  </div>
    
  <div class="form-group col-sm-2">
    <input type="text" class="form-control" name="kredit" id="kredit" placeholder="Kredit" readonly="">
  </div>

  <div class="form-group col-sm-1">
    <input type="text" name="potongan" id="potongan_penjualan" class="form-control" placeholder="Disc." autocomplete="off">
  </div>

  <div class="form-group col-sm-2">
    <input type="text" class="form-control" name="jumlah_bayar" onkeydown="return numbersonly(this, event);" id="jumlah_bayar" placeholder="Jumlah Bayar" autocomplete="off">
  </div>

  <div class="form-group col-sm-2"><br>
    <button type="submit" id="submit_tambah" class="btn btn-success"> <i class='fa fa-plus'> </i> Tambah </button>
  </div>

  <div class="form-group">
    <input type="hidden" name="kode_pelanggan" id="kode_pelanggan" class="form-control" value="" required="">
  </div>

  <div class="form-group">
    <input type="hidden" name="total" id="total" class="form-control" value="" required="">
  </div>

  <div class="form-group">
    <input type="hidden" name="tanggal_jt" id="tanggal_jt" class="form-control" value="" required="">
  </div>

  <input type="hidden" name="status" id="status" class="form-control" value="">


</form>


                <span id="span_piutang" style="display:none">            
                  <div class="table-responsive">
                    <table id="tabel_daftar_piutang" class="table table-bordered table-sm">
                          <thead> <!-- untuk memberikan nama pada kolom tabel -->
                              
                            <th> Faktur Penjualan</th>
                            <th> Tanggal </th>
                            <th> Tanggal JT </th>
                            <th> Kredit </th>
                            <th> Potongan </th>
                            <th> Total</th>
                            <th> Jumlah Bayar </th>
                            <th> Hapus </th>
                            <th> Edit </th>
                          
                          </thead> <!-- tag penutup tabel -->
                    </table>
                  </div>
                  <br>

                </span>

  </div>
  
  <div class="col-sm-4">
    <div class="card card-block">
        <div class="row 1">
            
                    <div class="form-group col-sm-6">
                    <label> Tanggal </label><br>
                    <input type="text" name="tanggal" id="tanggal" placeholder="Tanggal" style="height: 20px" value="<?php echo date("Y-m-d"); ?>" class="form-control" required="" >

                    <input type="hidden" name="session_id" id="session_id" class="form-control" readonly="" value="<?php echo $session_id; ?>" required="" >
                    </div>
                    
              

                    <input type="hidden" class="form-control" id="jumlah1" name="jumlah0" placeholder="jumlah">
          </div><!--end div class="row 1"-->

          <div class="row 2">
            <div class="col-sm-6">
              <label> Cara Bayar </label><br>
              <select type="text" name="cara_bayar" id="carabayar1" class="form-control" >
              
                 <?php 
                 
                 $sett_akun = $db->query("SELECT sa.kas, da.nama_daftar_akun FROM setting_akun sa INNER JOIN daftar_akun da ON sa.kas = da.kode_daftar_akun");
                 $data_sett = mysqli_fetch_array($sett_akun);
                 
                 echo "<option selected value='".$data_sett['kas']."'>".$data_sett['nama_daftar_akun'] ."</option>";
                 
                 $query = $db->query("SELECT nama_daftar_akun, kode_daftar_akun FROM daftar_akun WHERE tipe_akun = 'Kas & Bank'");
                 while($data = mysqli_fetch_array($query))
                 {
                 echo "<option value='".$data['kode_daftar_akun']."'>".$data['nama_daftar_akun'] ."</option>";
                 }
                 
                 ?>
              </select>
            </div>

            <div class="col-sm-6">
              <div class="form-group">
                <label> <b> Total Bayar </b> </label><br>
               <b> <input type="text" name="total_bayar" style="font-size:25px" id="totalbayar" placeholder="Total Bayar" class="form-control" readonly="" required=""></b>
              </div>
            </div>
          </div><!--div class="row 2"-->

          <input type="hidden" name="potongan1" id="potongan1" placeholder="Total Bayar" class="form-control" readonly="" required="">
          <input type="hidden" name="faktur" id="faktur" placeholder="Total Bayar" class="form-control" readonly="" required="">


      <div class="form-group">
        <label> Keterangan </label><br>
        <textarea name="keterangan" id="keterangan" class="form-control" ></textarea> 
        <br>

        <button type="submit" id="pembayaran" class="btn btn-info"><i class="fa fa-send"></i> Bayar</button>
        <a href="form_pembayaran_piutang.php" class="btn btn-primary" id="transaksi_baru" style="display: none"><i class="fa fa-refresh"></i> Transaksi Baru</a>
        <a href='batal_piutang.php?no_faktur_penjualan=<?php echo $no_faktur_penjualan; ?>' id='batal' class='btn btn-danger'><i class='fa fa-close'></i> Batal </a>
        <a href='cetak_pembayaran_piutang.php' id="cetak_piutang" style="display: none;" class="btn btn-success" target="blank"><i class="fa fa-print"> </i> Cetak Pembayaran Piutang </a>
        <br>
    
        <div class="alert alert-success" id="alert_berhasil" style="display:none">
          <strong>Success!</strong> Pembayaran Berhasil
        </div>

      </div>

    </div> <!-- / card-block -->

  </div> <!-- / col-sm-4 -->
 

<span id="demo"> </span>
</div>
</div><!-- end of container -->

<!-- DOCUMENT READY -->

<script type="text/javascript" language="javascript" >
   $(document).ready(function() {
      $('#tabel_daftar_piutang').DataTable().destroy();
            var dataTable = $('#tabel_daftar_piutang').DataTable( {
            "processing": true,
            "serverSide": true,
            "info":     false,
            "language": { "emptyTable":     "Tidak Ada Data Piutang" },
            "ajax":{
              url :"data_tbs_piutang.php", // json datasource
               "data": function ( d ) {
                  d.session_id = $("#session_id").val();
                  // d.custom = $('#myInput').val();
                  // etc
              },
                  type: "post",  // method  , by default get
              error: function(){  // error handling
                $(".tbody").html("");
                $("#tabel_daftar_piutang").append('<tbody class="tbody"><tr><th colspan="3"></th></tr></tbody>');
                $("#tableuser_processing").css("display","none");
                
              }
            }   

      });

    $("#span_piutang").show();
       
  });
 
 </script>

<!-- DOCUMENT READY -->

<!-- untuk memasukan perintah javascript -->
<script type="text/javascript">

// jika dipilih, nim akan masuk ke input dan modal di tutup
  $(document).on('click', '.pilih-piutang', function (e) {
  document.getElementById("nomorfakturbeli").value = $(this).attr('no-faktur');
  document.getElementById("kredit").value = $(this).attr('kredit');
  document.getElementById("jumlah_bayar").value = $(this).attr('kredit');
  document.getElementById("total").value = $(this).attr('total');
  document.getElementById("tanggal_jt").value = $(this).attr('tanggal_jt');
  document.getElementById("kode_pelanggan").value = $(this).attr('kode-pelanggan');
  
  $('#myModal').modal('hide');
  });
   
</script> <!--tag penutup perintah java script-->


<script type="text/javascript">
   //perintah javascript yang diambil dari form tbs pembelian dengan id=form tambah produk

  
   $("#submit_tambah").click(function(){
      
      var kredit = bersihPemisah(bersihPemisah(bersihPemisah(bersihPemisah($("#kredit").val()))));
      var kode_pelanggan = $("#kode_pelanggan").val();
      var no_faktur_penjualan = $("#nomorfakturbeli").val();
      var total = $("#total").val();
      var tanggal_jt = $("#tanggal_jt").val();
      var session_id = $("#session_id").val();
      var tanggal = $("#tanggal").val();
      var cara_bayar = $("#carabayar1").val();
      var potongan = $("#potongan_penjualan").val();

      if (potongan == "") {
        potongan = 0;
      }

      var total_kredit = parseInt(kredit) - parseInt(potongan);
      var potongan1 = $("#potongan1").val();
      var faktur = $("#faktur").val();

      var total = bersihPemisah(bersihPemisah(bersihPemisah(bersihPemisah($("#totalbayar").val()))));
      var jumlah_bayar = bersihPemisah(bersihPemisah(bersihPemisah(bersihPemisah($("#jumlah_bayar").val()))));


      var hasil = parseInt(jumlah_bayar) - parseInt(total_kredit);

        
        if (total == '') 
        {
          total = 0;
        }
        else if(jumlah_bayar == '')
        {
          jumlah_bayar = 0;
        };
        var subtotal = parseInt(total,10) + parseInt(jumlah_bayar,10);
      
      
      if (hasil > 0 )
      {

      alert("Jumlah Bayar Anda Melebihi Sisa");
      $("#totalbayar").val('');
      $("#total").val('');
      $("#potongan1").val('');
      $("#faktur").val(''); 
      $("#kredit").val('');
      $("#jumlah_bayar").val('');
      $("#potongan_penjualan").val('');
      
      }
      
      else if (jumlah_bayar == ""){
      alert("Jumlah Bayar Harus Diisi");
      }
      else if (kode_pelanggan == ""){
      alert("Kode Pelanggan Harus Dipilih");
      }
      else if (cara_bayar == ""){
      alert("Cara Bayar Harus Dipilih");
      }
      else
      {

      
      $("#totalbayar").val(tandaPemisahTitik(subtotal))

    $.post("proses_tbs_pembayaran_piutang.php", {session_id:session_id,no_faktur_penjualan:no_faktur_penjualan,tanggal:tanggal,tanggal_jt:tanggal_jt,total:total_kredit,potongan:potongan,jumlah_bayar:jumlah_bayar,kredit:kredit,kode_pelanggan:kode_pelanggan,potongan1:potongan1,faktur:faktur},function(data) {


     $("#tbody").prepend(data);
     $("#nomorfakturbeli").val('');
     $("#kredit").val('');
     $("#jumlah_bayar").val('');
     $("#potongan_penjualan").val('');
     
     var tabel_daftar_piutang = $('#tabel_daftar_piutang').DataTable();
          tabel_daftar_piutang.draw();

       
   });
 
}
      $("form").submit(function(){
    return false;
});
  


  });

</script>


<!-- DOCUMENT READY -->

<script type="text/javascript" language="javascript" >
   $(document).ready(function() {
        var dataTable = $('#table_piutang').DataTable( {
          "processing": true,
          "serverSide": true,
          "ajax":{
            url :"modal_piutang_baru.php", // json datasource
            "data": function ( d ) {
                      d.penjamin = $("#penjamin").val();
                      // d.custom = $('#myInput').val();
                      // etc
            },
            type: "post",  // method  , by default get
            error: function(){  // error handling
              $(".employee-grid-error").html("");
              $("#table_piutang").append('<tbody class="employee-grid-error"><tr><th colspan="3">Data Tidak Ditemukan.. !!</th></tr></tbody>');
              $("#employee-grid_processing").css("display","none");
              
            }
          },

          "fnCreatedRow": function( nRow, aData, iDataIndex ) {

              $(nRow).attr('class', "pilih-piutang");
              $(nRow).attr('no-faktur', aData[0]);
              $(nRow).attr('kredit', aData[12]);
              $(nRow).attr('total', aData[3]);
              $(nRow).attr('tanggal_jt', aData[5]);
              $(nRow).attr('kode-pelanggan', aData[1]);


          }

        });
       
  });
 
 </script>

<!-- DOCUMENT READY -->


<!-- KETIKA MEILIH PENJAMIN -->

<script type="text/javascript" language="javascript" >
   $(document).ready(function() {
      $(document).on('change','#penjamin',function(){

        var modal_piutang = $('#table_piutang').DataTable();
        modal_piutang.draw();

        $(".chosen").chosen({no_results_text: "Maaf, Data Tidak Ada!",search_contains:true});


    });
  });
 
 </script>

<!-- KETIKA MEILIH PENJAMIN -->




<script>

$(document).ready(function(){

    var potongan = $("#potongan").val();
    var no_faktur = $("#nomorfakturbeli").val();

    $("#potongan1").val(potongan);
    $("#faktur").val(no_faktur); 
      
        
    });

</script>


 <script>
   //perintah javascript yang diambil dari form proses_bayar_beli.php dengan id=form_beli
  $("#pembayaran").click(function(){

   var no_faktur_pembayaran = $("#no_faktur_pembayaran").val();
   var no_faktur_penjualan = $("#nomorfakturbeli").val();
   var cara_bayar = $("#carabayar1").val();
   var kode_pelanggan = $("#kode_pelanggan").val();
   var keterangan = $("#keterangan").val();
   var total = $("#total").val();
   var user_buat = $("#user_buat").val();
   var dari_kas = $("#dari_kas").val();
   var kredit = $("#kredit").val();
   var status = $("#status").val();
   var total_bayar = $("#totalbayar").val();
   var potongan = $("#potongan_penjualan").val();
   var jumlah_bayar = $("#jumlah_bayar").val();
   var potongan1 = $("#potongan1").val();
   var faktur = $("#faktur").val();
   var tanggal = $("#tanggal").val();

   
     $("#carabayar1").val('');
     $("#totalbayar").val('');
     $("#potongan1").val(potongan);
     $("#faktur").val(no_faktur_penjualan); 

if (cara_bayar == ""){
  alert("Cara Bayar Harus Di Isi");  
  }
else if (total_bayar == 0 || total_bayar == ""){
  alert("Anda Belum Melakukan Input Data Piutang");
}  
else{
  $("#transaksi_baru").show();
  $("#pembayaran").hide();
  $("#batal").hide();

 $.post("proses_bayar_piutang.php", {no_faktur_pembayaran:no_faktur_pembayaran,no_faktur_penjualan:no_faktur_penjualan,cara_bayar:cara_bayar,kode_pelanggan:kode_pelanggan,keterangan:keterangan,total:total,user_buat:user_buat,dari_kas:dari_kas,kredit:kredit,status:status,total_bayar:total_bayar,potongan:potongan,jumlah_bayar:jumlah_bayar,potongan1:potongan1,faktur:faktur,tanggal:tanggal},function(info) {

     
     $("#tabel_baru").html(info);
     $("#cetak_piutang").show();
     var no_faktur_pembayaran = info;
     $("#cetak_piutang").attr('href', 'cetak_pembayaran_piutang.php?no_faktur_pembayaran='+no_faktur_pembayaran+'');
     $("#tabel_baru").load('tabel-tbs-pembayaran-piutang.php');
     $("#pembayaran").hide();
     $("#transaksi_baru").show();
     $("#alert_berhasil").show();
     $("#nama_suplier").val('');
     $("#carabayar1").val('');
     $("#totalbayar").val('');
     $("#keterangan").val('');
     
     var tabel_daftar_piutang = $('#tabel_daftar_piutang').DataTable();
          tabel_daftar_piutang.draw();
    
       
   });

//mengambil no_faktur pembelian agar berurutan


 }

 $("form").submit(function(){
    return false;
});


  });
     
  </script>





<script type="text/javascript">

$(document).ready(function(){

  var session_id = $("#session_id").val();

$.post("cek_total_pembayaran_piutang.php",
    {
        session_id: session_id
    },
    function(data){
      data = data.replace(/\s+/g, '');
        $("#totalbayar"). val(data);
    });

});


</script>


<script>

// BELUM KELAR !!!!!!
$(document).ready(function(){

        var cara_bayar = $("#carabayar1").val();

      //metode POST untuk mengirim dari file cek_jumlah_kas.php ke dalam variabel "dari akun"
      $.post('cek_jumlah_kas1.php', {cara_bayar : cara_bayar}, function(data) {
        /*optional stuff to do after success */

      $("#jumlah1").val(data);
      });


    $("#carabayar1").change(function(){
      var cara_bayar = $("#carabayar1").val();

      //metode POST untuk mengirim dari file cek_jumlah_kas.php ke dalam variabel "dari akun"
      $.post('cek_jumlah_kas1.php', {cara_bayar : cara_bayar}, function(data) {
        /*optional stuff to do after success */

      $("#jumlah1").val(data);
      });
        
    });
});
</script>





                            
<script>

// untuk memunculkan jumlah kas secara otomatis
  $(document).ready(function(){
    $("#jumlah_bayar").keyup(function(){
      var jumlah_bayar = $("#jumlah_bayar").val();
      var jumlah_kas = $("#jumlah1").val();
      var kredit = jumlah_kas - jumlah_bayar;
      var carabayar1 = $("#carabayar1").val();

      if ( carabayar1 == "") 

      {
          $("#submit_tambah").hide();

        alert("Kolom Cara Bayar Masih Kosong");

      }
      else {
        $("#submit_tambah").show();
      }


    });

  });


</script>

<script type="text/javascript">
                               
//fungsi hapus data
  $(document).on("click", ".btn-hapus", function(){

    var jumlah_bayar = $(this).attr("data-jumlah-bayar");
    var faktur = $(this).attr("data-faktur");
    var id = $(this).attr("data-id");
    var total = bersihPemisah(bersihPemisah(bersihPemisah(bersihPemisah($("#totalbayar").val()))));

      if (total == ''){
            total = 0;
          };
      if(jumlah_bayar   == ''){
            jumlah_bayar   = 0;
          };

      var subtotal = parseInt(total,10) - parseInt(jumlah_bayar  ,10);

      if (subtotal == 0){
            subtotal = 0;
          }

        var pesan_alert = confirm("Apakah Anda Yakin Ingin Menghapus Faktur "+faktur+""+ "?");
        if (pesan_alert == true) {
              $("#totalbayar").val(tandaPemisahTitik(subtotal));
              $.post("hapus_tbs_pembayaran_piutang.php",{id:id},function(data){

                var tabel_daftar_piutang = $('#tabel_daftar_piutang').DataTable();
                tabel_daftar_piutang.draw();

              });
        }
        else {

        }

  });
    
  
 //fungsi edit data 
        $(document).on("click", ".btn-edit-tbs", function(){
        
        $("#modal_edit").modal('show');
        var jumlah_lama = $(this).attr("data-jumlah-bayar");
        var potongan_lama = $(this).attr("data-potongan");
        var id  = $(this).attr("data-id");
        var nofaktur1  = $(this).attr("data-no-faktur-penjualan");

        var kredit  = $(this).attr("data-kredit");
        $("#bayar_lama").val(jumlah_lama);
        $("#potongan_lama").val(potongan_lama);
        $("#id_edit").val(id);
        $("#kredit_edit").val(kredit);
        $("#no_faktur_penjualan1").val(nofaktur1);

        
        
        });
        
        $(document).on("click", "#submit_edit", function(){
        var jumlah_lama = $("#bayar_lama").val();
        var jumlah_baru = $("#bayar_edit").val();
        var potongan_lama = $("#potongan_lama").val();
        var potongan_baru = $("#potongan_edit").val();
        var kredit = $("#kredit_edit").val();
        var id = $("#id_edit").val();
        var nofaktur1 = $("#no_faktur_penjualan1").val();
        var total = bersihPemisah(bersihPemisah(bersihPemisah(bersihPemisah($("#totalbayar").val()))));

        if (total == '') 
      
      {
        total = 0;
      }
    
    else if(jumlah_baru   == '')
      {
        jumlah_baru   = 0;
      };



      var subtotal = parseInt(total,10) - parseInt(jumlah_lama, 10) + parseInt(jumlah_baru  ,10);
                                  
                                  
    if (subtotal == 0) 
      {
        subtotal = 0;
      }

      $("#totalbayar").val(tandaPemisahTitik(subtotal));



        $.post("update_tbs_pembayaran_piutang.php",{id:id,kredit:kredit,jumlah_bayar:jumlah_lama,jumlah_baru:jumlah_baru,potongan:potongan_lama,potongan_baru:potongan_baru,no_faktur_penjualan:nofaktur1},function(data){

        
        $("#alert").html(data);
        $("#tabel_baru").load('tabel-tbs-pembayaran-piutang.php');
        setTimeout(tutupmodal, 2000);
        setTimeout(tutupalert, 2000);
        
        var tabel_daftar_piutang = $('#tabel_daftar_piutang').DataTable();
          tabel_daftar_piutang.draw();
        });
        });
//end function edit data

              $('form').submit(function(){
              
              return false;
              });
        


    function tutupalert() {
    $("#alert").html("")
    }

    function tutupmodal() {
    $("#modal_edit").modal("hide")
    }
</script>

                             
<?php 
include 'footer.php';
 ?>
