<?php include_once 'session_login.php';
// memasukan file session login,  header, navbar, db.php,
include 'header.php';
include 'navbar.php';
include 'db.php';
include 'sanitasi.php';

$session_id = session_id();
$user = $_SESSION['nama'];
$id_user = $_SESSION['id'];

$pilih_akses_tombol = $db->query("SELECT tombol_submit, tombol_bayar, tombol_piutang, tombol_simpan, tombol_batal, hapus_produk FROM otoritas_penjualan_rj WHERE id_otoritas = '$_SESSION[otoritas_id]' ");
$otoritas_tombol = mysqli_fetch_array($pilih_akses_tombol);

?>
<!-- js untuk tombol shortcut -->
<script src="shortcut.js"></script>
<!-- js untuk tombol shortcut -->

<!-- Modal cari registrasi pasien-->
<div id="modal_reg" class="modal fade" role="dialog">
  <div class="modal-dialog">

    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
               
              <h4 class="modal-title">Cari Pasien</h4>
      </div>
      <div class="modal-body">

            <center>
            <table id="tabel_cari_pasien" class="table table-bordered table-sm">
                  <thead> <!-- untuk memberikan nama pada kolom tabel -->
                      <th>No. Faktur</th>
                      <th>No. REG</th>
                      <th>No. RM</th>
                      <th>Nama Pasien</th>
                      <th>Jenis Pasien</th>
                      <th>Tanggal</th>
                  
                  </thead> <!-- tag penutup tabel -->
            </table>
            </center>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-warning" id="btnRefreshPasien"> <i class='fa fa-refresh'></i> Refresh Pasien</button>
        <button type="button" accesskey="e" class="btn btn-danger" data-dismiss="modal"><i class='fa fa-close'></i> Close</button>
      </div>
    </div>

  </div>
</div>

<!-- Modal cari registrasi pasien-->



<!--Mulai Padding layar-->
<div style="padding-left: 5%; padding-right: 5%">
<h3><b>Input Hasil Laboratorium</b></h3>
<form role="form" >
  <!--Mulai Row Pertama-->
    <div class="row">

        <!--Mulai Col SM Awal-->
        <div class="col-sm-8">

          <div class="col-xs-2">
          <label> No. RM | Pasien </label><br>
          <input style="height:15px" type="text" class="form-control"  id="no_rm" name="no_rm" value="" readonly="" >
          <input style="height:15px" type="hidden" class="form-control"  id="nama_pasien" name="nama_pasien" value="" readonly="" > 
          </div>

          <div class="col-xs-2">
            <label>No. REG </label>
            <input style="height:15px" type="text" class="form-control"  id="no_reg" name="no_reg" value="" readonly="">
          </div>

          <div class="col-xs-2">
            <label>Petugas</label>
            <input style="height:15px;" type="text" class="form-control"  id="petugas_kasir" name="petugas_kasir" value="<?php echo $user; ?>" readonly="">  
          </div>

          <!--HIDDEN-->

      <input style="height:15px" type="hidden" class="form-control"  id="no_faktur" placeholder="No Faktur" readonly="">

      <input style="height:15px" type="hidden" class="form-control"  id="no_rm_hidden" placeholder="RM Pasien" readonly="">

      <input style="height:15px" type="hidden" class="form-control"  id="status_pasien" placeholder="Status Pasien"  readonly="">


          <!--(MULAI TOMBOL DAN TABLE TBS APS PENJUALAN)-->
            <!--Mulai Col SM Kedua-->
                <div class="col-sm-8">

              <button type="button" class="btn btn-warning" id="cari_pasien" data-toggle="modal" data-target="#modal_reg"><i class="fa fa-user"></i> Cari Pasien (F1)</button>

              <button type="submit" id="selesai" style="display: none" class="btn btn-success" style="font-size:15px;">
              <i class="fa fa-save"></i> Selesai</button>



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


<!-- DATATABLE CARI PASIEN APS -->
<script type="text/javascript" language="javascript" >
   $(document).ready(function() {
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
              $(nRow).attr('no_faktur', aData[0]);
              $(nRow).attr('no_reg', aData[1]);
              $(nRow).attr('no_rm_hidden', aData[2]);
              $(nRow).attr('no_rm', aData[2]+" | "+aData[3]+"");
              $(nRow).attr('nama_pasien', aData[3]);
              $(nRow).attr('status_pasien', aData[4]);


          }

        });    
     
  });
 
 </script>
<!-- / DATATABLE CARI PASIEN APS -->

<!-- SHORTCUT -->
<script>   
shortcut.add("f1", function() {
// Do something
  $("#cari_pasien").click();
}); 
</script>

 <script type="text/javascript">
   $(document).on('click', '.pilih-reg', function (e) {
            document.getElementById("no_reg").value = $(this).attr('no_reg');
            document.getElementById("no_rm").value = $(this).attr('no_rm');
            document.getElementById("nama_pasien").value = $(this).attr('nama_pasien');
            document.getElementById("status_pasien").value = $(this).attr('status_pasien');
            document.getElementById("no_rm_hidden").value = $(this).attr('no_rm_hidden');
            document.getElementById("no_faktur").value = $(this).attr('no_faktur');

            $('#modal_reg').modal('hide'); 
            $("#selesai").show();
            $("#alert_berhasil").hide();
            $("#cetak").hide();
var no_reg = $("#no_reg").val();
var no_rm = $("#no_rm_hidden").val();
var nama_pasien = $("#nama_pasien").val();
var status_pasien = $("#status_pasien").val();

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
    }
  }); // akhir post proses input hasil lab
});
 // DATATABE AJAX TABLE_APS
</script>



<script type="text/javascript">
// untuk update hasil pemeriksaaan
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
  var jenis_penjualan = $("#status_pasien").val();

    $.post("cek_pemeriksaan_sementara.php",{no_reg:no_reg},function(data){
      if(data == 1){
        alert("Data Hasil Laboratorium Tidak Boleh Kosong, Silahkan Anda Isi Terlebih Dahulu !!");
      }
      else{

      $.post("proses_selesai_input_hasil_lab.php",{no_rm:no_rm,no_reg:no_reg,nama:nama,jenis_penjualan:jenis_penjualan},function(info){

       //$("#table-baru").html(info);
      
      $("#cetak").show();
      $("#cetak").attr('href', 'cetak_hasil_lab.php?no_reg='+no_reg+'');
      $("#alert_berhasil").show();
      $("#no_rm").val('');
      $("#nama").val('');
      $("#kembali_ugd").show();

     
      
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