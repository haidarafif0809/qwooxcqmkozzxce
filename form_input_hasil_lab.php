<?php include_once 'session_login.php';
// memasukan file session login,  header, navbar, db.php,
include 'header.php';
include 'navbar.php';
include 'db.php';
include 'sanitasi.php';

$session_id = session_id();
$user = $_SESSION['nama'];
$id_user = $_SESSION['id'];


$cek_setting = $db->query("SELECT nama FROM setting_laboratorium");
$data_setting = mysqli_fetch_array($cek_setting);
$hasil_setting = $data_setting['nama'];

?>
<!-- js untuk tombol shortcut -->
<script src="shortcut.js"></script>
<!-- js untuk tombol shortcut -->

<!-- Mulai Modal cari registrasi pasien Rawat Jalan-->
<div id="modal_reg_jalan" class="modal fade" role="dialog">
  <div class="modal-dialog">

    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
               
            <center><h4 class="modal-title"><b>Cari Pasien Rawat Jalan</b></h4></center>
      </div>
      <div class="modal-body">

            <center>
            <table id="tabel_cari_pasien_jalan" class="table table-bordered table-sm">
                  <thead> <!-- untuk memberikan nama pada kolom tabel -->
                  <?php
                  if($hasil_setting == 0){

                    echo "
                      <th>No. REG</th>
                      <th>No. RM</th>
                      <th>Nama Pasien</th>
                      <th>Jenis Pasien</th>
                      <th>Tanggal</th>";
                  }
                  else{
                    echo "
                      <th>No. REG</th>
                      <th>No. RM</th>
                      <th>Nama Pasien</th>
                      <th>Jenis Pasien</th>
                      <th>Tanggal</th>";

                  }
                  ?>
                  
                  </thead> <!-- tag penutup tabel -->
            </table>
            </center>
      </div>
      <div class="modal-footer">
      <center>
        <button type="button" class="btn btn-warning" id="btnRefreshPasien_jalan"> <i class='fa fa-refresh'></i> Refresh Pasien</button>
        <button type="button" accesskey="e" class="btn btn-danger" data-dismiss="modal"><i class='fa fa-close'></i> Close</button>
      </center>
      </div>
    </div>
  </div>
</div>
<!-- Akhir Modal cari registrasi pasien Rawat Jalan-->


<!-- Mulai Modal cari registrasi pasien Rawat Inap-->
<div id="modal_reg_inap" class="modal fade" role="dialog">
  <div class="modal-dialog">

    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
               
            <center><h4 class="modal-title"><b>Cari Pasien Rawat Inap</b></h4></center>
      </div>
      <div class="modal-body">

            <center>
            <table id="tabel_cari_pasien_inap" class="table table-bordered table-sm">
                  <thead> <!-- untuk memberikan nama pada kolom tabel -->
                  <?php
                  if($hasil_setting == 0){

                    echo "
                      <th>No. REG</th>
                      <th>No. RM</th>
                      <th>Nama Pasien</th>
                      <th>Jenis Pasien</th>
                      <th>Pemeriksaan</th>
                      <th>Tanggal</th>";
                  }
                  else{
                    echo "
                      <th>No. REG</th>
                      <th>No. RM</th>
                      <th>Nama Pasien</th>
                      <th>Jenis Pasien</th>
                      <th>Pemeriksaan</th>
                      <th>Tanggal</th>";

                  }
                  ?>
                  </thead> <!-- tag penutup tabel -->
            </table>
            </center>
      </div>
      <div class="modal-footer">
      <center>
        <button type="button" class="btn btn-warning" id="btnRefreshPasien_inap"> <i class='fa fa-refresh'></i> Refresh Pasien</button>
        <button type="button" accesskey="e" class="btn btn-danger" data-dismiss="modal"><i class='fa fa-close'></i> Close</button>
      </center>
      </div>
    </div>
  </div>
</div>
<!-- Akhir Modal cari registrasi pasien Rawat Inap-->

<!-- Mulai Modal cari registrasi pasien UGD-->
<div id="modal_reg_ugd" class="modal fade" role="dialog">
  <div class="modal-dialog">

    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
               
            <center><h4 class="modal-title"><b>Cari Pasien UGD</b></h4></center>
      </div>
      <div class="modal-body">

            <center>
            <table id="tabel_cari_pasien_ugd" class="table table-bordered table-sm">
                <thead> <!-- untuk memberikan nama pada kolom tabel -->
                
                <?php
                  if($hasil_setting == 0){

                    echo "
                      <th>No. REG</th>
                      <th>No. RM</th>
                      <th>Nama Pasien</th>
                      <th>Jenis Pasien</th>
                      <th>Tanggal</th>";
                  }
                  else{
                    echo "
                      <th>No. REG</th>
                      <th>No. RM</th>
                      <th>Nama Pasien</th>
                      <th>Jenis Pasien</th>
                      <th>Tanggal</th>";

                  }
                ?>
                  
                </thead> <!-- tag penutup tabel -->
            </table>
            </center>
      </div>
      <div class="modal-footer">
      <center>
        <button type="button" class="btn btn-warning" id="btnRefreshPasien_ugd"> <i class='fa fa-refresh'></i> Refresh Pasien</button>
        <button type="button" accesskey="e" class="btn btn-danger" data-dismiss="modal"><i class='fa fa-close'></i> Close</button>
      </center>
      </div>
    </div>
  </div>
</div>
<!-- Akhir Modal cari registrasi pasien UGD-->


<!-- Awal Modal cari registrasi pasien APS-->
<div id="modal_reg" class="modal fade" role="dialog">
  <div class="modal-dialog">

    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
               
              <center><h4 class="modal-title"><b>Cari Pasien APS</b></h4></center>
      </div>
      <div class="modal-body">

            <center>
            <table id="tabel_cari_pasien" class="table table-bordered table-sm">
                  <thead> <!-- untuk memberikan nama pada kolom tabel -->
                     
                  <?php 

                  if($hasil_setting == 0){
                    echo"
                      <th>No. REG</th>
                      <th>No. RM</th>
                      <th>Nama Pasien</th>
                      <th>Jenis Pasien</th>
                      <th>Tanggal</th>";

                  }
                  else{

                     echo "
                      <th>No. REG</th>
                      <th>No. RM</th>
                      <th>Nama Pasien</th>
                      <th>Jenis Pasien</th>
                      <th>Tanggal</th>";
                  }

                   ?>
                  
                  </thead> <!-- tag penutup tabel -->
            </table>
            </center>
      </div>
      <div class="modal-footer">
      <center>
        <button type="button" class="btn btn-warning" id="btnRefreshPasien"> <i class='fa fa-refresh'></i> Refresh Pasien</button>
        <button type="button" accesskey="e" class="btn btn-danger" data-dismiss="modal"><i class='fa fa-close'></i> Close</button>
      </center>
      </div>
    </div>

  </div>
</div>
<!-- Akhir Modal cari registrasi pasien APS-->

<!--Mulai Padding layar-->
<div style="padding-left: 5%; padding-right: 5%">
<h3><b>Input Hasil Laboratorium</b></h3>
<form role="form" >
  <!--Mulai Row Pertama-->
    <div class="row">

        <!--Mulai Col SM Awal-->
        <div class="col-sm-8">

          <div class="col-xs-3">
          <label> No. RM | Pasien </label><br>
          <input style="height:25px" type="text" class="form-control"  id="no_rm" name="no_rm" value="" readonly="" >
          <input style="height:25px" type="hidden" class="form-control"  id="nama_pasien" name="nama_pasien" value="" readonly="" > 
          </div>

          <div class="col-xs-3">
            <label>No. REG </label>
            <input style="height:25px" type="text" class="form-control"  id="no_reg" name="no_reg" value="" readonly="">
          </div>

          <div class="col-xs-3">
            <label>Petugas</label>
            <input style="height:25px;" type="text" class="form-control"  id="petugas_kasir" name="petugas_kasir" value="<?php echo $user; ?>" readonly="">  
          </div>

          <div id="show_pemeriksaan" style="display: none" class="col-xs-3">
            <label>Pemeriksaan</label>
            <input style="height:25px;" type="text" class="form-control" id="pemeriksaan" placeholder="Pemeriksaan"  readonly="">
          </div>
      <!--HIDDEN-->
      <input style="height:15px" type="hidden" class="form-control"  id="no_rm_hidden" placeholder="RM Pasien" readonly="">

      <input style="height:15px" type="hidden" class="form-control"  id="jenis_pasien" placeholder="Jenis Pasien"  readonly="">

      

        <!--(MULAI TOMBOL DAN TABLE TBS APS PENJUALAN)-->
        <!--Mulai Col SM Kedua-->
        <div class="col-sm-12">

          <button type="button" class="btn btn-warning" id="cari_pasien_rj" data-toggle="modal" data-target="#modal_reg_jalan"><i class="fa fa-user"></i> Pasien R.Jalan (F1)</button>

          <button type="button" class="btn btn-info" id="cari_pasien_ri" data-toggle="modal" data-target="#modal_reg_inap"><i class="fa fa-user"></i> Pasien R.Inap (F2)</button>

          <button type="button" class="btn btn-danger" id="cari_pasien_ugd" data-toggle="modal" data-target="#modal_reg_ugd"><i class="fa fa-user"></i> Pasien UGD (F3)</button>

          <button type="button" class="btn btn-default" id="cari_pasien_aps" data-toggle="modal" data-target="#modal_reg"><i class="fa fa-user"></i> Pasien APS (F4)</button>

          <button type="submit" id="selesai" style="display: none" class="btn btn-success" style="font-size:15px;"><i class="fa fa-save"></i> Selesai</button>

        <!--Akhir Col SM Kedua-->
        </div>

<br><br>

<!--Mulai Col SM Awal-->  
</div>
  <!--Mulai Col 2 SM Awal (untuk nilai Penjualan)-->
  </div>


<!--Mulai Col SM Ketiga-->
<div class="col-sm-12">
  <span id="span_tbs_aps">            
    <div class="table-responsive">
      <table id="table_aps" class="table table-bordered table-sm">
        <thead> <!-- untuk memberikan nama pada kolom tabel -->
                                                        
<th style='background-color: #4CAF50; color: white;' >Nama Pemeriksaan</th>
<th style='background-color: #4CAF50; color: white;' >Hasil Pemeriksaan</th>
<th style='background-color: #4CAF50; color: white;' >Nilai Normal</th>
<th style='background-color: #4CAF50; color: white;' >Dokter</th>
<th style='background-color: #4CAF50; color: white;' >Analis</th>
                                 
        </thead> <!-- tag penutup tabel -->
          <tbody class="tbody">
                    
          </tbody>
      </table>
    </div>
  </span>  
<!--Akhir Col SM Ketiga-->
</div>
<!--(MULAI TOMBOL DAN TABLE TBS APS PENJUALAN)-->

<div class="col-sm-4">
  <div class="alert alert-success" id="alert_berhasil" style="display:none">
    <strong>Success!</strong> Input Hasil Laboratorium Berhasil !!
  </div>

  <a href='cetak_hasil_lab.php' id="cetak" style="display: none;" class="btn btn-purple" target="blank"><i class="fa fa-print"></i> Cetak </a> 
</div>
<!--Akhir Row Pertama-->
</div>

<!--Akhir From-->
</form>


<!--Akhir Padding layar-->
</div>


<!-- DATATABLE CARI PASIEN  -->
<script type="text/javascript" language="javascript" >
   $(document).ready(function() {
    //RAWAT JALAN
        var dataTable = $('#tabel_cari_pasien_jalan').DataTable( {
          "processing": true,
          "serverSide": true,
          "ajax":{
            url :"modal_pasien_pemeriksaan_lab_rawat_jalan.php", // json datasource
            type: "post",  // method  , by default get
            error: function(){  // error handling
              $(".employee-grid-error").html("");
              $("#tabel_cari_pasien_jalan").append('<tbody class="employee-grid-error"><tr><th colspan="3">Data Tidak Ditemukan.. !!</th></tr></tbody>');
              $("#employee-grid_processing").css("display","none");
              
            }
          },

          "fnCreatedRow": function( nRow, aData, iDataIndex ) {

              $(nRow).attr('class', "pilih-reg");
              $(nRow).attr('no_reg', aData[0]);
              $(nRow).attr('no_rm_hidden', aData[1]);
              $(nRow).attr('no_rm', aData[1]+" | "+aData[2]+"");
              $(nRow).attr('nama_pasien', aData[2]);
              $(nRow).attr('jenis_pasien', aData[3]);


          }

        });  

    //RAWAT INAP
        var dataTable = $('#tabel_cari_pasien_inap').DataTable( {
          "processing": true,
          "serverSide": true,
          "ajax":{
            url :"modal_pasien_pemeriksaan_lab_rawat_inap.php", // json datasource
            type: "post",  // method  , by default get
            error: function(){  // error handling
              $(".employee-grid-error").html("");
              $("#tabel_cari_pasien_inap").append('<tbody class="employee-grid-error"><tr><th colspan="3">Data Tidak Ditemukan.. !!</th></tr></tbody>');
              $("#employee-grid_processing").css("display","none");
              
            }
          },

          "fnCreatedRow": function( nRow, aData, iDataIndex ) {

              $(nRow).attr('class', "pilih-reg");
              $(nRow).attr('no_reg', aData[0]);
              $(nRow).attr('no_rm_hidden', aData[1]);
              $(nRow).attr('no_rm', aData[1]+" | "+aData[2]+"");
              $(nRow).attr('nama_pasien', aData[2]);
              $(nRow).attr('jenis_pasien', aData[3]);
              $(nRow).attr('pemeriksaan', aData[4]);


          }

        }); 

    //UGD
        var dataTable = $('#tabel_cari_pasien_ugd').DataTable( {
          "processing": true,
          "serverSide": true,
          "ajax":{
            url :"modal_pasien_pemeriksaan_lab_ugd.php", // json datasource
            type: "post",  // method  , by default get
            error: function(){  // error handling
              $(".employee-grid-error").html("");
              $("#tabel_cari_pasien_ugd").append('<tbody class="employee-grid-error"><tr><th colspan="3">Data Tidak Ditemukan.. !!</th></tr></tbody>');
              $("#employee-grid_processing").css("display","none");
              
            }
          },

          "fnCreatedRow": function( nRow, aData, iDataIndex ) {

              $(nRow).attr('class', "pilih-reg");
              $(nRow).attr('no_reg', aData[0]);
              $(nRow).attr('no_rm_hidden', aData[1]);
              $(nRow).attr('no_rm', aData[1]+" | "+aData[2]+"");
              $(nRow).attr('nama_pasien', aData[2]);
              $(nRow).attr('jenis_pasien', aData[3]);

          }

        }); 

    //APS
        var dataTable = $('#tabel_cari_pasien').DataTable( {
          "processing": true,
          "serverSide": true,
          "ajax":{
            url :"modal_pasien_pemeriksaan_lab.php", // json datasource
            type: "post",  // method  , by default get
            error: function(){  // error handling
              $(".employee-grid-error").html("");
              $("#tabel_cari_pasien").append('<tbody class="employee-grid-error"><tr><th colspan="3">Data Tidak Ditemukan.. !!</th></tr></tbody>');
              $("#employee-grid_processing").css("display","none");
              
            }
          },

          "fnCreatedRow": function( nRow, aData, iDataIndex ) {

              $(nRow).attr('class', "pilih-reg");
              $(nRow).attr('no_reg', aData[0]);
              $(nRow).attr('no_rm_hidden', aData[1]);
              $(nRow).attr('no_rm', aData[1]+" | "+aData[2]+"");
              $(nRow).attr('nama_pasien', aData[2]);
              $(nRow).attr('jenis_pasien', aData[3]);


          }

        }); 
     
  });
</script>
<!-- / DATATABLE CARI PASIEN  -->


<!-- SHORTCUT -->
<script>   
shortcut.add("f1", function() {
// Do something
  $("#cari_pasien_rj").click();
            $('#modal_reg').modal('hide');
            $('#modal_reg_inap').modal('hide'); 
            $('#modal_reg_ugd').modal('hide'); 

}); 
shortcut.add("f2", function() {
// Do something
  $("#cari_pasien_ri").click();
            $('#modal_reg').modal('hide');
            $('#modal_reg_jalan').modal('hide'); 
            $('#modal_reg_ugd').modal('hide'); 
}); 
shortcut.add("f3", function() {
// Do something
  $("#cari_pasien_ugd").click();
            $('#modal_reg').modal('hide');
            $('#modal_reg_jalan').modal('hide'); 
            $('#modal_reg_inap').modal('hide'); 
}); 
shortcut.add("f4", function() {
// Do something
  $("#cari_pasien_aps").click();
            $('#modal_reg_jalan').modal('hide'); 
            $('#modal_reg_inap').modal('hide'); 
            $('#modal_reg_ugd').modal('hide'); 
}); 
</script>

<!--Script Pilih Pasien-->
 <script type="text/javascript">
   $(document).on('click', '.pilih-reg', function (e) {
      document.getElementById("no_reg").value = $(this).attr('no_reg');
      document.getElementById("no_rm").value = $(this).attr('no_rm');
      document.getElementById("nama_pasien").value = $(this).attr('nama_pasien');
      document.getElementById("no_rm_hidden").value = $(this).attr('no_rm_hidden');
      document.getElementById("jenis_pasien").value = $(this).attr('jenis_pasien');
      document.getElementById("pemeriksaan").value = $(this).attr('pemeriksaan');

      //Tutup Modal
      $('#modal_reg').modal('hide');
      $('#modal_reg_jalan').modal('hide'); 
      $('#modal_reg_inap').modal('hide'); 
      $('#modal_reg_ugd').modal('hide'); 

      $("#selesai").show();
      $("#alert_berhasil").hide();
      $("#cetak").hide();

  var no_reg = $("#no_reg").val();
  var no_rm = $("#no_rm_hidden").val();
  var nama_pasien = $("#nama_pasien").val();
  var status_pasien = $("#jenis_pasien").val();

if(status_pasien == 'Rawat Jalan'){
  $("#show_pemeriksaan").hide();
  $("#cari_pasien_ri").hide();
  $("#cari_pasien_ugd").hide();
  $("#cari_pasien_aps").hide();

  //Awal Proses Masuk ke TBS HASIL
  $.post("proses_input_hasil_lab.php",{no_reg:no_reg,no_rm:no_rm,nama_pasien:nama_pasien,status_pasien:status_pasien},function(data){
    if(data == 1){

    $("#span_tbs_aps").show();

    $.post("datatable_hasil_pemeriksaan.php",{no_rm:no_rm,no_reg:no_reg},function(data){
      $("#span_tbs_aps").html(data);
    });
    //$("#span_tbs_aps").show('fast');
    } //breaket if
    else{
      alert("Pasien ini tidak ada pemeriksaan !!");
      $("#selesai").hide();
      $("#span_tbs_aps").hide();

      //Tampilkkan Tombol Pencarian Pasien
      $("#cari_pasien_aps").show();
      //$("#cari_pasien_rj").show();
      $("#cari_pasien_ri").show();
      $("#cari_pasien_ugd").show();
    }
  });
//Akhir post proses input hasil lab
}
else if(status_pasien == 'Rawat Inap'){
  $("#show_pemeriksaan").show();
  $("#cari_pasien_rj").hide();
  $("#cari_pasien_ugd").hide();
  $("#cari_pasien_aps").hide();

  var pemeriksaan = $("#pemeriksaan").val();
  //Awal Proses Masuk ke TBS HASIL
  $.post("proses_input_hasil_lab_inap.php",{pemeriksaan:pemeriksaan,no_reg:no_reg,no_rm:no_rm,nama_pasien:nama_pasien,status_pasien:status_pasien},function(data){
    if(data == 1){

    $("#span_tbs_aps").show();

    $.post("datatable_hasil_pemeriksaan.php",{no_rm:no_rm,no_reg:no_reg},function(data){
      $("#span_tbs_aps").html(data);
    });
    //$("#span_tbs_aps").show('fast');
    } //breaket if
    else{
      alert("Pasien ini tidak ada pemeriksaan !!");
      $("#selesai").hide();
      $("#span_tbs_aps").hide();

      //Tampilkkan Tombol Pencarian Pasien
      $("#cari_pasien_aps").show();
      $("#cari_pasien_rj").show();
      //$("#cari_pasien_ri").show();
      $("#cari_pasien_ugd").show();
    }
  });
//Akhir post proses input hasil lab

}
else if(status_pasien == 'UGD'){
  $("#show_pemeriksaan").hide();
  $("#cari_pasien_rj").hide();
  $("#cari_pasien_ri").hide();
  $("#cari_pasien_aps").hide();

  //Awal Proses Masuk ke TBS HASIL
  $.post("proses_input_hasil_lab.php",{no_reg:no_reg,no_rm:no_rm,nama_pasien:nama_pasien,status_pasien:status_pasien},function(data){
    if(data == 1){

    $("#span_tbs_aps").show();

    $.post("datatable_hasil_pemeriksaan.php",{no_rm:no_rm,no_reg:no_reg},function(data){
      $("#span_tbs_aps").html(data);
    });
    //$("#span_tbs_aps").show('fast');
    } //breaket if
    else{
      alert("Pasien ini tidak ada pemeriksaan !!");
      $("#selesai").hide();
      $("#span_tbs_aps").hide();

      //Tampilkkan Tombol Pencarian Pasien
      $("#cari_pasien_aps").show();
      $("#cari_pasien_rj").show();
      $("#cari_pasien_ri").show();
      //$("#cari_pasien_ugd").show();
    }
  });
//Akhir post proses input hasil lab
}
else if(status_pasien == 'APS'){
  $("#show_pemeriksaan").hide();
  $("#cari_pasien_rj").hide();
  $("#cari_pasien_ri").hide();
  $("#cari_pasien_ugd").hide();

  //Awal Proses Masuk ke TBS HASIL
  $.post("proses_input_hasil_lab.php",{no_reg:no_reg,no_rm:no_rm,nama_pasien:nama_pasien,status_pasien:status_pasien},function(data){
    if(data == 1){

    $("#span_tbs_aps").show();

    $.post("datatable_hasil_pemeriksaan.php",{no_rm:no_rm,no_reg:no_reg},function(data){
      $("#span_tbs_aps").html(data);
    });
    //$("#span_tbs_aps").show('fast');
    } //breaket if
    else{
      alert("Pasien ini tidak ada pemeriksaan !!");
      $("#selesai").hide();
      $("#span_tbs_aps").hide();

      //Tampilkkan Tombol Pencarian Pasien
      //$("#cari_pasien_aps").show();
      $("#cari_pasien_rj").show();
      $("#cari_pasien_ri").show();
      $("#cari_pasien_ugd").show();

    }
  });
//Akhir post proses input hasil lab
}

});
 // DATATABE AJAX TABLE_APS
</script>

<script type="text/javascript">
// untuk update hasil pemeriksaan
$(document).on('dblclick','.edit-nama',function(e){
  
  var id = $(this).attr("data-id");
  $("#text-nama-"+id+"").hide();
  $("#input-nama-"+id+"").attr("type", "text");

});

$(document).on('blur','.input_nama',function(e){
  var nama_lama = $(this).attr("data-nama");
  var id = $(this).attr("data-id");
  var input_nama = $(this).val();

  if (input_nama == '') {
        alert('Hasil Tidak Boleh Kosong !!');

      $("#input-nama-"+id+"").val(nama_lama);
      $("#text-nama-"+id+"").text(nama_lama);
      $("#text-nama-"+id+"").show();
      $("#input-nama-"+id+"").attr("type", "hidden");

  }
  else{

    // Start Proses
    $.post("update_data_laboratorium.php",{id:id, input_nama:input_nama},function(data){

    $("#text-nama-"+id+"").show();
    $("#text-nama-"+id+"").text(input_nama);
    $("#input-nama-"+id+"").attr("type", "hidden");           
    $("#input-nama-"+id+"").val(input_nama);
    $("#input-nama-"+id+"").attr("data-nama",input_nama);


    });
    // Finish Proses
  }
});
// ending untuk update hasil pemeriksaaan
</script>

<script type="text/javascript">
   //perintah javascript yang diambil dari form proses_bayar_beli.php dengan id=form_beli
$("#selesai").click(function(){
  var no_rm = $("#no_rm_hidden").val();
  var no_reg = $("#no_reg").val();
  var nama = $("#nama_pasien").val();
  var jenis_penjualan = $("#jenis_pasien").val();
  var pemeriksaan = $("#pemeriksaan").val();
  if(pemeriksaan == ''){
    pemeriksaan = '0';
  }
    $.post("cek_pemeriksaan_sementara.php",{no_reg:no_reg},function(data){
      if(data == 1){
        alert("Data Hasil Laboratorium Tidak Boleh Kosong, Silahkan Anda Isi Terlebih Dahulu !!");
      }
      else{

      $.post("proses_selesai_input_hasil_lab.php",{no_rm:no_rm,no_reg:no_reg,nama:nama,jenis_penjualan:jenis_penjualan,pemeriksaan:pemeriksaan},function(info){

       //$("#table-baru").html(info);
      
      $("#cetak").show();
      if(jenis_penjualan == 'Rawat Inap'){

      $("#cetak").attr('href', 'cetak_hasil_input_hasil_lab_inap.php?no_reg='+no_reg+'&pemeriksaan='+pemeriksaan+'');
      }
      else{

      $("#cetak").attr('href', 'cetak_hasil_lab.php?no_reg='+no_reg+'');
      }
      $("#alert_berhasil").show();
      $("#no_rm").val('');
      $("#nama").val('');
      $("#kembali_ugd").show();

    //Tombol Show
    $("#cari_pasien_aps").show();
    $("#cari_pasien_rj").show();
    $("#cari_pasien_ri").show();
    $("#cari_pasien_ugd").show();
      
      $("#selesai").hide();
      $("#result").hide();
      $("#petugasnya").hide();
      });

      }
    }); 

        $("form").submit(function(){
           return false;
        });
});
</script>

<!-- / DATATABLE DRAW -->
<script type="text/javascript">
    $(document).on('click','#btnRefreshPasien',function(e){

       var table_pasien = $('#tabel_cari_pasien').DataTable();
       table_pasien.draw();

    }); 
</script>
<!-- / DATATABLE DRAW -->

<!-- / DATATABLE DRAW -->
<script type="text/javascript">
    $(document).on('click','#btnRefreshPasien_jalan',function(e){

       var table_pasien = $('#tabel_cari_pasien_jalan').DataTable();
       table_pasien.draw();
       
    }); 
</script>
<!-- / DATATABLE DRAW -->

<!-- / DATATABLE DRAW -->
<script type="text/javascript">
    $(document).on('click','#btnRefreshPasien_inap',function(e){

       var table_pasien = $('#tabel_cari_pasien_inap').DataTable();
       table_pasien.draw();
       
    }); 
</script>
<!-- / DATATABLE DRAW -->

<!-- / DATATABLE DRAW -->
<script type="text/javascript">
    $(document).on('click','#btnRefreshPasien_ugd',function(e){

       var table_pasien = $('#tabel_cari_pasien_ugd').DataTable();
       table_pasien.draw();
       
    }); 
</script>
<!-- / DATATABLE DRAW -->


<!--MULAI SCRIPT ANALIS-->
<script type="text/javascript">    
$(document).on('dblclick','.edit-analis',function(e){
  var id = $(this).attr("data-id");
  $("#text-analis-"+id+"").hide();
  $("#input-analis-"+id+"").show();
});

$(document).on('blur','.input_analis',function(e){
  var nama_lama = $(this).attr("data-analis");
  var reg = $(this).attr("data-reg");
  var kode = $(this).attr("data-kode");
  var harga = $(this).attr("data-harga");
  var nama_pemeriksaan = $(this).attr("data-nama-pemeriksaan");
  var nama_header = $(this).attr("data-nama-header");
  var rm = $(this).attr("data-rm");
  var id = $(this).attr("data-id");
  var input_nama = $(this).val();

  $.post("update_analis_tbs_hasil.php",{nama_lama:nama_lama,id:id,input_nama:input_nama,reg:reg,rm:rm,kode:kode,harga:harga,nama_pemeriksaan:nama_pemeriksaan,nama_header:nama_header},function(data){

    var nama = data;
    $("#input-analis-"+id+"").hide();
    $("#text-analis-"+id+"").text(nama);
    $("#text-analis-"+id+"").show(); 
    $("#input-analis-"+id+"").val(input_nama);
    $("#input-analis-"+id+"").attr("data-analis",input_nama);
  });
});
</script>
<!--AKHIR SCRIPT ANALIS-->
<!--Footer-->
<?php include 'footer.php'; ?>