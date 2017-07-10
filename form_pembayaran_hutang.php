<?php include 'session_login.php';

 include 'header.php';
 include 'navbar.php';
 include 'db.php';
 include 'sanitasi.php';

$session_id = session_id();

 
 ?>

<style type="text/css">
  .disabled {
    opacity: 0.6;
    cursor: not-allowed;
    disabled: true;
}
</style>
      
      <script type="text/javascript">
      $(function() {
      $( "#tanggal" ).datepicker({dateFormat: "yy-mm-dd"});
      });
      </script>



<!-- js untuk tombol shortcut -->
 <script src="shortcut.js"></script>
<!-- js untuk tombol shortcut -->

 <div style="padding-left: 5%; padding-right: 5%">
 
<h3> <u>FORM PEMBAYARAN HUTANG</u> </h3>

<!-- Modal Hapus data -->
<div id="modal_hapus" class="modal fade" role="dialog">
  <div class="modal-dialog">

    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title">Konfirmsi Hapus Data Pembayaran Hutang</h4>
      </div>

      <div class="modal-body">
   
   <p>Apakah Anda yakin Ingin Menghapus Data ini ?</p>
   <form >
    <div class="form-group">
    <label> Nomor Faktur Pembelian :</label>
     <input type="text" id="no_faktur_pembelian" class="form-control" readonly="">
     <input type="hidden" id="jumlah_hutang" class="form-control" readonly="">
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
        <h4 class="modal-title">Edit Data Pembayaran Hutang</h4>
      </div>
      <div class="modal-body">
  <form role="form">
   <div class="form-group">
    <label for="email">Jumlah Bayar Baru:</label>
     <input type="text" style="height: 15px" name="jumlah_baru" class="form-control" autocomplete="off" id="bayar_edit"><br>
    <label for="email">Jumlah Potongan Baru:</label>
     <input type="text" style="height: 15px" name="potongan_baru" class="form-control" autocomplete="off" id="potongan_edit"><br>

    <label for="email">Jumlah Bayar Lama:</label>
     <input type="text" style="height: 15px" name="jumlah_lama" class="form-control" id="bayar_lama" readonly="">
    <label for="email">Jumlah Potongan Lama:</label>
     <input type="text" style="height: 15px" name="potongan_lama" class="form-control" id="potongan_lama" readonly="">
     <input type="hidden" class="form-control" id="id_edit">
     <input type="hidden" class="form-control" id="kredit_edit">
     <input type="hidden" class="form-control" id="no_faktur_pembelian1">
    
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


<form action="proses_tbs_pembayaran_hutang.php" role="form" method="post" id="formtambahproduk">



<button type="button" class="btn btn-info" id="cari_produk_pembelian" data-toggle="modal" data-target="#myModal" data-placement='top' title='Pastikan anda memilih supplier terlebih dahulu sebelum klik tombol cari.'> <i class='fa fa-search'> </i> Cari (F1)</button>
<br>

<!-- Tampilan Modal -->
<div id="myModal" class="modal fade" role="dialog">
  <div class="modal-dialog modal-lg">

    <!-- Isi Modal-->
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title"><center><b>Data Pembelian</b></center></h4>
      </div>
      <div class="modal-body"> <!--membuat kerangka untuk tempat tabel -->

      <!--perintah agar modal update-->
  <span class="modal_hutang_baru">
    <div class="table-responsive">
  <table id="table_hutang" class="table table-bordered table-sm">
    <thead> <!-- untuk memberikan nama pada kolom tabel -->
      
      <th> Nomor Faktur </th>
      <th> Suplier </th>
      <th> Total Beli</th>
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
    

    <!-- membuat form -->
 <form class="form-inline" action="proses_bayar_hutang.php" role="form" id="formtambahproduk">

<br>

<div class="row">
  <div class="col-sm-9">

  <div class="form-group col-sm-2">
          <label> Suplier </label>
          <br>
          <select type="text" name="suplier" id="nama_suplier" class="form-control chosen" required="">
          <option value="">--SILAKAN PILIH--</option>
          
          <?php 

          $take = $db->query("SELECT id,nama FROM suplier");
          while($data = mysqli_fetch_array($take))
          {
          echo "<option value='".$data['id'] ."'>".$data['nama'] ."</option>";
          }
          ?>
          </select>
  </div>

<div class="form-group col-sm-2">
  <input type="text" class="form-control" name="no_faktur_pembelian" id="nomorfakturbeli" placeholder="Faktur Pembelian" readonly="">
  </div>
  
  <div class="form-group col-sm-2">
    <input type="text" class="form-control" name="kredit" id="kredit" placeholder="Nilai Hutang" readonly="">
  </div>


<div class="form-group col-sm-1">
    <input type="text" name="potongan" id="potongan_penjualan" class="form-control" placeholder="Diskon" autocomplete="off" onkeydown="return numbersonly(this, event);" onkeyup="javascript:tandaPemisahTitik(this);">
</div>

<!--div class="form-group col-sm-1">
    <input type="text" name="sisa_hutang" id="sisa_hutang" class="form-control" placeholder="Hutang" autocomplete="off" readonly="">
</div-->

  <div class="form-group col-sm-2">
    <input type="text" class="form-control" name="jumlah_bayar"  onkeydown="return numbersonly(this, event);" id="jumlah_bayar" placeholder="Jumlah Bayar" autocomplete="off">
  
    <div class="form-group">
      <input type="hidden" name="total" id="total" class="form-control" value="" required="">
    </div>

    <div class="form-group">
      <input type="hidden" name="potongan" id="potongan10" class="form-control" value="" required="">
    </div>

    <div class="form-group">
      <input type="hidden" name="tanggal_jt" id="tanggal_jt" class="form-control" value="" required="">
    </div>

    <input type="hidden" name="status" id="status" class="form-control" value="">

    <input type="hidden" name="suplier" id="n_suplier" class="form-control" required="" >
  </div>

  <div class="form-group col-sm-2">
       <button type="submit" id="submit_tambah" class="btn btn-success"> <i class='fa fa-plus'> </i> Tambah </button>
</div>





</form>
<br><br>

      <span id="result"> 
  <div class="table-responsive">

  <!--tag untuk membuat garis pada tabel-->       
  <table id="table" class="table table-bordered table-sm">
    <thead>
      <th> No Faktur Beli </th>
      <th>Suplier</th>
      <th> Tanggal </th>
      <th> Jatuh Tempo</th>
      <th> Kredit </th>
      <th> Potongan </th>
      <th> Total </th>
      <th> Jumlah Bayar </th>    
      <th> Hapus </th>
      <th> Edit </th>
      
    </thead>
    
    <tbody id="tbody">
    <?php

    //untuk menampilkan semua data yang ada pada tabel tbs pembelian dalam DB
    $perintah = $db->query("SELECT tph.id,tph.no_faktur_pembelian,s.nama AS suplier,tph.tanggal,tph.tanggal_jt,tph.kredit,tph.potongan,tph.total,tph.jumlah_bayar FROM tbs_pembayaran_hutang tph LEFT JOIN suplier s ON tph.suplier = s.id WHERE session_id = '$session_id'");

    //menyimpan data sementara yang ada pada $perintah
      while ($data1 = mysqli_fetch_array($perintah))
      {
        // menampilkan data
      echo "<tr class='tr-id-".$data1['id']."'>
      <td>". $data1['no_faktur_pembelian'] ."</td>
      <td>". $data1['suplier'] ."</td>
      <td>". $data1['tanggal'] ."</td>
      <td>". $data1['tanggal_jt'] ."</td>
      <td>". rp($data1['kredit']) ."</td>
      <td>". rp($data1['potongan']) ."</td>
      <td>". rp($data1['total']) ."</td>
      <td>". rp($data1['jumlah_bayar']) ."</td>
      

      <td> <button class='btn btn-danger btn-hapus' data-id='". $data1['id'] ."' data-no-faktur-pembelian='". $data1['no_faktur_pembelian'] ."' data-hutang='". $data1['kredit'] ."' data-jumlah-bayar='". $data1['jumlah_bayar'] ."'> <span class='glyphicon glyphicon-trash'> </span> Hapus </button> </td> 

      <td> <button class='btn btn-success btn-edit-tbs' data-id='". $data1['id'] ."' data-jumlah-bayar='". $data1['jumlah_bayar'] ."' data-no-faktur-pembelian='". $data1['no_faktur_pembelian'] ."' data-potongan='". $data1['potongan'] ."' data-kredit='". $data1['kredit'] ."'> <span class='glyphicon glyphicon-edit'> </span> Edit </button> </td>
      </tr>";
      }
    ?>
    </tbody>
  </table>

  </div>
</span> <!--tag penutup span-->


</div>


  <div class="col-sm-3">
<div class="card card-block">
  <div class="row 1">          
          <div class="form-group col-sm-6">
          <label> Tanggal </label><br>
          <input type="text" name="tanggal" id="tanggal" placeholder="Tanggal" style="height: 20px" value="<?php echo date("Y-m-d"); ?>" class="form-control" required="" >
          
          <input type="hidden" name="session_id" id="session_id" class="form-control" readonly="" value="<?php echo $session_id; ?>" required="" >
          </div>

          <input type="hidden" class="form-control" id="jumlah1" name="jumlah0" placeholder="jumlah">

</div> <!-- tag penutup div row 1-->



        <div class="row 2">

          <div class="form-group col-sm-6">
            <label> Cara Bayar </label><br>
            <select type="text" name="cara_bayar" id="carabayar1" class="form-control" >
               <?php 
               $sett_akun = $db->query("SELECT sa.kas, da.nama_daftar_akun FROM setting_akun sa INNER JOIN daftar_akun da ON sa.kas = da.kode_daftar_akun");
               $data_sett = mysqli_fetch_array($sett_akun);
                            echo "<option selected='' value='".$data_sett['kas']."'>".$data_sett['nama_daftar_akun'] ."</option>";
               
               $query = $db->query("SELECT nama_daftar_akun, kode_daftar_akun FROM daftar_akun WHERE tipe_akun = 'Kas & Bank'");
               while($data = mysqli_fetch_array($query))
               {
                 echo "<option value='".$data['kode_daftar_akun']."'>".$data['nama_daftar_akun'] ."</option>";
               }
               ?>
            </select>
          </div>
          
          <div class="form-group col-sm-6">
            <div class="form-group">
              <label> <b> Total Bayar </b> </label><br>
              <b><input style="font-size:20px" type="text" name="total_bayar" id="totalbayar" placeholder="Total Bayar" class="form-control" readonly="" required=""></b>
            </div>
          </div>

        </div><!--/div class="row 2"-->

          <input type="hidden" class="form-control" name="potongan1" id="potongan1" placeholder="Potongan 1" autocomplete="off">
          <input type="hidden" class="form-control" name="faktur" id="faktur" placeholder="Faktur" autocomplete="off">


<div class="form-group">
          <label> Keterangan </label><br>
          <textarea name="keterangan" id="keterangan" class="form-control" ></textarea>
          <br>
</div>


<button type="submit" id="pembayaran" class="btn btn-info"><i class="fa fa-send"></i> Bayar</button>

<a href="form_pembayaran_hutang.php" class="btn btn-primary" style="display: none" id="transaksi_baru"><i class="fa fa-refresh"></i> Transaksi Baru</a>


<a href='batal_hutang.php' id='batal' class='btn btn-danger'><i class="fa fa-close"></i></span> Batal </a>

<a href='cetak_pembayaran_hutang.php' target="blank" id="cetak_hutang" style="display: none;" class="btn btn-success" target="blank"><span class="glyphicon glyphicon-print"> </span> Cetak Pembayaran Hutang </a>

          
<br>
<div class="alert alert-success" id="alert_berhasil" style="display:none">
  <strong>Success!</strong> Pembayaran Berhasil
</div>
    
  </div>
</div>
</div>

<span id="demo"> </span>
</div>

</div><!-- end of container -->


    
<script>
//untuk menampilkan data tabel
$(document).ready(function(){
    $('#tableuser').dataTable();
});

</script>
<!-- untuk memasukan perintah javascript -->
<script type="text/javascript">

// jika dipilih, nim akan masuk ke input dan modal di tutup
  $(document).on('click', '.pilih', function (e) {
  document.getElementById("nomorfakturbeli").value = $(this).attr('no-faktur');
  document.getElementById("kredit").value = $(this).attr('kredit');
  document.getElementById("total").value = $(this).attr('total');
  document.getElementById("tanggal_jt").value = $(this).attr('tanggal_jt');

  
  
  $('#myModal').modal('hide');
  });
   


   
  </script> <!--tag penutup perintah java script-->

<script type="text/javascript">
    $(document).ready(function(){
    // Tooltips Initialization
    $(function () {
    $('[data-toggle="tooltip"]').tooltip()
    });
    });
</script>

<script>
   //perintah javascript yang diambil dari form tbs pembelian dengan id=form tambah produk
  $("#submit_tambah").click(function(){
      
      //var sisa_hutang = bersihPemisah(bersihPemisah(bersihPemisah(bersihPemisah($("#sisa_hutang").val()))));
      var suplier = $("#nama_suplier").val();
      var tanggal_jt = $("#tanggal_jt").val();
      var session_id = $("#session_id").val();
      var tanggal = $("#tanggal").val();
      var cara_bayar = $("#jumlah1").val();
      var total1 = bersihPemisah(bersihPemisah(bersihPemisah(bersihPemisah($("#total").val()))));
      var potongan = bersihPemisah(bersihPemisah(bersihPemisah(bersihPemisah($("#potongan_penjualan").val()))));
      var kredit = bersihPemisah(bersihPemisah(bersihPemisah(bersihPemisah($("#kredit").val()))));
      var potongan1 = bersihPemisah(bersihPemisah(bersihPemisah(bersihPemisah($("#potongan1").val()))));
      var faktur = $("#faktur").val();
      var no_faktur_pembelian= $("#nomorfakturbeli").val();
      var total = bersihPemisah(bersihPemisah(bersihPemisah(bersihPemisah($("#totalbayar").val()))));
      var jumlah_bayar = bersihPemisah(bersihPemisah(bersihPemisah(bersihPemisah($("#jumlah_bayar").val()))));

      var a = cara_bayar - jumlah_bayar;     
      var total_kredit = kredit - potongan;
      var hasil = jumlah_bayar - total_kredit; 

        
        if (total == '') 
        {
          total = 0;
        }
        else if(jumlah_bayar == '')
        {
          jumlah_bayar = 0;
        };
        var subtotal = parseInt(total,10) + parseInt(jumlah_bayar,10);

    
      if (hasil > 0){
        alert("Jumlah Bayar Anda Melebihi Sisa");

        $("#total").val('');
        $("#jumlah_bayar").val('');
        $("#potongan10").val('');
      }
      else if (jumlah_bayar == ""){
      alert("Jumlah Bayar Harus Diisi");
      }
      else if (suplier == ""){
      alert("Suplier Harus Dipilih");
      }
      else if (cara_bayar == ""){
      alert("Cara Bayar Harus Dipilih");
      }
      else if (a < 0){
      alert("Jumlah Kas Tidak Mencukupi");
      }
      else
      {

        $("#totalbayar").val(tandaPemisahTitik(subtotal))


    $.post("proses_tbs_pembayaran_hutang.php", {session_id:session_id,no_faktur_pembelian:no_faktur_pembelian,tanggal:tanggal,tanggal_jt:tanggal_jt,total:total_kredit,jumlah_bayar:jumlah_bayar,kredit:kredit,suplier:suplier,potongan:potongan,potongan1:potongan1,faktur:faktur},function(data) {


     $("#tbody").prepend(data);
     $("#nomorfakturbeli").val('');
     $("#kredit").val('');
     $("#jumlah_bayar").val('');
     $("#potongan_penjualan").val('');
     $("#sisa_hutang").val('');
     


       
   });
 
}
      $("form").submit(function(){
    return false;
});
  
});


 $("#submit_tambah").click(function(){

            var suplier = $("#nama_suplier").val();
            
            if (suplier != ""){
            $("#nama_suplier").attr("disabled", true);
            }
       });
</script>

<script type="text/javascript">
      $(document).ready(function(){
        
          var dataTable = $('#table_hutang').DataTable( {
          "processing": true,
          "serverSide": true,
          "ajax":{
            url :"modal_hutang_baru.php", // json datasource
              "data": function ( d ) {
                          d.suplier = $("#nama_suplier").val();
                          // d.custom = $('#myInput').val();
                          // etc
              },
            type: "post",  // method  , by default get
            error: function(){  // error handling
              $(".employee-grid-error").html("");
              $("#tabel_cari_pasien").append('<tbody class="employee-grid-error"><tr><th colspan="3">Data Tidak Ditemukan.. !!</th></tr></tbody>');
              $("#employee-grid_processing").css("display","none");
              
            }
          },

          "fnCreatedRow": function( nRow, aData, iDataIndex ) {

              $(nRow).attr('class', "pilih");
              $(nRow).attr('no-faktur', aData[0]);
              $(nRow).attr('kredit', aData[11]);
              $(nRow).attr('total', aData[2]);
              $(nRow).attr('tanggal_jt', aData[4]);

          }

        });   

  });
</script>


      <script type="text/javascript">
    $(document).on('click','#cari_produk_pembelian',function(e){

//menyembunyikan notif berhasil
     $("#alert_berhasil").hide();

      var suplier = $("#nama_suplier").val();
      
      if (suplier == "")
      {
        alert("Pilih Dahulu Supliernya !!");
        $("#nama_suplier").focus();
      }
      else{

       var table_hutang = $('#table_hutang').DataTable();
       table_hutang.draw();

     }

    }); 
</script>


 <script>
   //perintah javascript yang diambil dari form proses_bayar_beli.php dengan id=form_beli
  $("#pembayaran").click(function(){

   var no_faktur_pembayaran = $("#no_faktur_pembayaran").val();
   var no_faktur_pembelian = $("#nomorfakturbeli").val();
   var cara_bayar = $("#carabayar1").val();
   var suplier = $("#nama_suplier").val();
   var keterangan = $("#keterangan").val();
   var total = $("#total").val();
   var user_buat = $("#user_buat").val();
   var dari_kas = $("#dari_kas").val();
   var kredit = $("#kredit").val();
   var status = $("#status").val();
   var total_bayar = $("#totalbayar").val();
   var total_bayar1 = $("#totalbayar1").val();
   var n_suplier = $("#n_suplier").val();
   var potongan = $("#potongan_penjualan").val();
   var potongan1 = $("#potongan1").val();
   var faktur = $("#faktur").val();
   var tanggal = $("#tanggal").val();
     
    $("#totalbayar").val('');
    $("#potongan1").val(potongan);
    $("#faktur").val(no_faktur_pembelian); 


if (cara_bayar == "")
  {
  
  alert("Cara Bayar Harus Di Isi");
  
  }
  
  else if (suplier == "")
  {
  alert("Suplier Harus Di Isi");
  }

    else if (total_bayar == "" || total_bayar1 == "")
  {
  alert("Anda Belum Memasukan Data !");
  }

else

 {

$("#pembayaran").hide();
$("#batal").hide();
$("#transaksi_baru").show();


 $.post("proses_bayar_hutang.php", {no_faktur_pembayaran:no_faktur_pembayaran,no_faktur_pembelian:no_faktur_pembelian,cara_bayar:cara_bayar,suplier:suplier,keterangan:keterangan,total:total,user_buat:user_buat,dari_kas:dari_kas,kredit:kredit,status:status,total_bayar:total_bayar,potongan1:potongan1,faktur:faktur,tanggal:tanggal},function(info) {


      $("#result").html(info);
     $("#result").load('tabel-tbs-pembayaran-hutang.php');
     $("#alert_berhasil").show();
     $("#cetak_hutang").show();
     $("#nama_suplier").val('');
     $("#carabayar1").val('');
     $("#totalbayar").val('');
     $("#keterangan").val('');
    
       
   });

 }

 $("form").submit(function(){
    return false;
});


  });


          $("#pembayaran").click(function(){
          var jumlah = $("#jumlah_bayar").val();
          var jumlah_kas = $("#jumlah1").val();
          var kredit = jumlah_kas - jumlah;
          var carabayar1 = $("#carabayar1").val();
          
          if (kredit < 0 || carabayar1 == "") 
          
          {
          alert("Jumlah Kas Tidak Mencukupi Atau Kolom Cara Bayar Masih Kosong");
          
          }
          else {
          }
          
          
          });
     
  </script>



<script type="text/javascript">

$(document).ready(function(){

  var session_id = $("#session_id").val();

$.post("cek_total_pembayaran_hutang.php",
    {
        session_id: session_id
    },
    function(data){
      data = data.replace(/\s+/g, '');
        $("#totalbayar"). val(data);
    });

});


</script>


<script type="text/javascript">
   shortcut.add("f1", function() {
        // Do something

        $("#cari_produk_pembelian").click();

    });
</script>

<!--membuat menampilkan no faktur dan suplier pada tax-->
<script>

$(document).ready(function(){
    $("#nama_suplier").change(function(){
      var suplier = $("#nama_suplier").val();
      $("#n_suplier").val(suplier);
        
    });
});
</script>

<script type="text/javascript">
  
$(document).ready(function(){
      var cara_bayar = $("#carabayar1").val();
      $.post('cek_jumlah_kas1.php', {cara_bayar : cara_bayar}, function(data) {
        /*optional stuff to do after success */

      $("#jumlah1").val(data);
      });
    });

</script>

<script>


$(document).ready(function(){

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
    var kredit = $(this).attr("data-hutang");

      if (kredit < 0 || carabayar1 == "") 

      {
          $("#submit_tambah").hide();

        alert("Jumlah Kas Tidak Mencukupi Atau Kolom Cara Bayar Masih Kosong");

      }
      else {
        $("#submit_tambah").show();
      }


    });

  });
</script>


<script>
// untuk memunculkan jumlah kas secara otomatis
  $(document).ready(function(){
    $("#potongan_penjualan").keyup(function(){
      var potongan_penjualan = bersihPemisah(bersihPemisah(bersihPemisah(bersihPemisah($("#potongan_penjualan").val()))));
      var kredit = bersihPemisah(bersihPemisah(bersihPemisah(bersihPemisah($("#kredit").val()))));
      if (potongan_penjualan == "") {
        potongan_penjualan = 0;
      }
      var hutang_harus_dibayar = parseInt(kredit,10) - parseInt(potongan_penjualan,10);

      $("#sisa_hutang").val(tandaPemisahTitik(hutang_harus_dibayar));

    });

  });
</script>


      <script type="text/javascript">
      
      $(".chosen").chosen({no_results_text: "Maaf, Data Tidak Ada!"});  
      
      </script>

                             


    <script type="text/javascript">
    
    //fungsi hapus data 
    $(".btn-hapus").click(function(){
    var no_faktur_pembelian = $(this).attr("data-no-faktur-pembelian");
    var kredit = $(this).attr("data-hutang");
    var jumlah_bayar = $(this).attr("data-jumlah-bayar");
    var id = $(this).attr("data-id");
    var kredit = $(this).attr("data-hutang");
    var total = bersihPemisah(bersihPemisah(bersihPemisah(bersihPemisah($("#totalbayar").val()))));

   if (total == '') 
      
      {
        $("#nama_suplier").attr("disabled", false);
        total = 0;
      }
    
    else if(jumlah_bayar  == '')
      {
        jumlah_bayar   = 0;
      };
       
       var subtotal = parseInt(total,10) - parseInt(jumlah_bayar,10);
                                  
                                  
    if (subtotal == 0) 
      {
        subtotal = 0;
      }

      $("#totalbayar").val(tandaPemisahTitik(subtotal));

    
    $.post("hapus_tbs_pembayaran_hutang.php",{id:id, no_faktur_pembelian:no_faktur_pembelian, kredit:kredit},function(data){


    $(".tr-id-"+id).remove();    

    
    });
    
    
    });

    //fungsi edit data 
        $(".btn-edit-tbs").click(function(){
        
        $("#modal_edit").modal('show');
        var jumlah_lama = $(this).attr("data-jumlah-bayar");
        var id  = $(this).attr("data-id");
        var nofaktur1  = $(this).attr("data-no-faktur-pembelian");
        var kredit  = $(this).attr("data-kredit");
        var potongan_lama = $(this).attr("data-potongan");
        $("#potongan_lama").val(potongan_lama);
        $("#kredit_edit").val(kredit);
        $("#bayar_lama").val(jumlah_lama);
        $("#id_edit").val(id);
        $("#no_faktur_pembelian1").val(nofaktur1);

        
        
        });
        
        $("#submit_edit").click(function(){
        var jumlah_lama = $("#bayar_lama").val();
        var jumlah_baru = $("#bayar_edit").val();
        var potongan_lama = $("#potongan_lama").val();
        var potongan_baru = $("#potongan_edit").val();
        var kredit = $("#kredit_edit").val();
        var id = $("#id_edit").val();
        var nofaktur1 = $("#no_faktur_pembelian1").val();
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

        $.post("update_tbs_pembayaran_hutang.php",{id:id,jumlah_bayar:jumlah_lama,jumlah_baru:jumlah_baru,no_faktur_pembelian:nofaktur1,kredit:kredit,potongan:potongan_lama,potongan_baru:potongan_baru},function(data){

        
        $("#alert").html(data);
        $("#result").load('tabel-tbs-pembayaran-hutang.php');
        
        setTimeout(tutupmodal, 2000);
        setTimeout(tutupalert, 2000);
        
      
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
