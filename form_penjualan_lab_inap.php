<?php include 'session_login.php';
// memasukan file session login,  header, navbar, db.php,
include 'header.php';
include 'navbar.php';
include 'db.php';
include 'sanitasi.php';

$no_rm = stringdoang($_GET['no_rm']);
$nama = stringdoang($_GET['nama']);
$no_reg = stringdoang($_GET['no_reg']);
$dokter = stringdoang($_GET['dokter']);
$bed = stringdoang($_GET['bed']);
$kamar = stringdoang($_GET['kamar']);
$jenis_kelamin = stringdoang($_GET['jenis_kelamin']);
$jenis_penjualan = stringdoang($_GET['jenis_penjualan']);
$rujukan = stringdoang($_GET['rujukan']);
 // jika 1 Laboratorium, jika 2 Radiologi

$query_data_pemeriksaan = $db->query("SELECT no_periksa FROM pemeriksaan_lab_inap WHERE no_rm = '$no_rm' AND no_reg = '$no_reg' ORDER BY no_periksa DESC");
$data_periksa = mysqli_fetch_array($query_data_pemeriksaan);

$no_periksa = $data_periksa['no_periksa'];

if ($no_periksa == ''){
  $hasil_no_periksa = 1; 
}
else{
  $hasil_no_periksa = $no_periksa + 1;
}

?>
<!--Mulai Modal Data Laboratorium-->
<div id="modal_lab" class="modal fade" role="dialog">
  <!--Modal Dialog-->
  <div class="modal-dialog modal-lg">
    <!-- Modal content-->
    <div class="modal-content">
      <!--Modal Header LAB-->
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
       <center>
        <h4 class="modal-title">
          <b>Daftar Pemeriksaan Laboratorium</b>
        </h4>
       </center>
      </div>
        <!--Awal Modal Body-->
        <div class="modal-body">
          <form class="form"  role="form" id="formtambahprodukcari">
            <div class="table-responsive">
              
<div class="form-group col-xs-6"> <!-- /  -->

<!--MULAI TAMPILAN DATA HEADER & DETAILNYA-->
<?php 
$query_header = $db->query("SELECT id,nama_pemeriksaan,nama_sub,sub_hasil_lab FROM setup_hasil WHERE kategori_index = 'Header' ORDER BY id ASC ");
while ($data_header = mysqli_fetch_array($query_header)){ //WHILE SATU

  $query_jasa = $db->query("SELECT id,kode_lab,nama AS nama_jasa,harga_1 FROM jasa_lab WHERE id = '$data_header[nama_pemeriksaan]'");
  while($data_jasa = mysqli_fetch_array($query_jasa)){ // WHILE DUA

    $query_tbs_data_periksa = $db->query("SELECT kode_jasa FROM tbs_aps_penjualan WHERE kode_jasa = '$data_jasa[kode_lab]' AND no_reg = '$no_reg' AND no_periksa_lab_inap = '$hasil_no_periksa'");

    $jumlah_data_periksa = mysqli_num_rows($query_tbs_data_periksa);

    if ($jumlah_data_periksa > 0) {

      echo '
      <div class="row">
        <div class="col-sm-8">';  

        echo '<input type="checkbox" class="pilih-header-input filled-in" id="pemeriksaan-'.$data_header['id'].'" data-id-kepala="'.$data_header['id'].'" data-kode-jasa="'.$data_jasa['kode_lab'].'" data-toogle="11" name="header" class="pilih-header" value="'.$data_jasa['nama_jasa'].'" checked="true" >

        <label for="pemeriksaan-'.$data_header['id'].'" data-id="'.$data_header['id'].'" data-kode="'.$data_header['nama_pemeriksaan'].'" data-nama="'.$data_header['nama_sub'].'" data-kode-jasa="'.$data_jasa['kode_lab'].'" class="pilih-header" data-toogle="11" id="label-'.$data_header['id'].'">
        <b>'.$data_jasa['nama_jasa'].'</b></label> <br>'; //nama yang tampil

      echo '
        </div>
      </div>';
    
      //UNDER DETAIL dari HEADER
      echo '
      <div class="row">
        <div class="col-sm-1">
        </div>

        <div class="col-sm-11">';

        $query_detail = $db->query("SELECT id,nama_pemeriksaan,nama_sub,sub_hasil_lab FROM setup_hasil WHERE kategori_index = 'Detail' AND sub_hasil_lab = '$data_header[id]' ORDER BY id ASC ");
        while ($data_detail = mysqli_fetch_array($query_detail)) {

          $query_jasa = $db->query("SELECT id,kode_lab,nama AS nama_jasa,harga_1 FROM jasa_lab WHERE id = '$data_detail[nama_pemeriksaan]'");
          while($data_jasa = mysqli_fetch_array($query_jasa)){

       echo '<input type="checkbox" class="pilih-detail-dari-kepala-'.$data_header['id'].' filled-in" data-headernya="'.$data_header['id'].'"  id="pemeriksaan-'.$data_detail['id'].'" style="padding-right: 50%;" data-toogle="22" data-id="'.$data_detail['id'].'"  name="detail_header" data-kode-jasa="'.$data_jasa['kode_lab'].'" value="'.$data_jasa['nama_jasa'].'" checked="true">

              <label for="pemeriksaan-'.$data_detail['id'].'" data-id="'.$data_detail['id'].'" data-head="'.$data_header['id'].'" data-kode="'.$data_detail['nama_pemeriksaan'].'" data-nama="'.$data_detail['nama_sub'].'" data-kode-jasa="'.$data_jasa['kode_lab'].'" class="pilih-detail-dari-header head-'.$data_header['id'].'" data-toogle="22">
              '.$data_jasa['nama_jasa'].'</label> <br>'; //nama yang tampil
            
          }
        }

      echo '
        </div>
      </div>';
         // DETAIL dari HEADER END
    }
    else{
      echo '
      <div class="row">
        <div class="col-sm-8">';  

          echo '
          <input type="checkbox" class="pilih-header-input filled-in" id="pemeriksaan-'.$data_header['id'].'" data-id-kepala="'.$data_header['id'].'" data-kode-jasa="'.$data_jasa['kode_lab'].'" data-toogle="1" name="header" class="pilih-header" value="'.$data_jasa['nama_jasa'].'">

          <label for="pemeriksaan-'.$data_header['id'].'" data-id="'.$data_header['id'].'" data-kode="'.$data_header['nama_pemeriksaan'].'" data-nama="'.$data_header['nama_sub'].'" data-kode-jasa="'.$data_jasa['kode_lab'].'" class="pilih-header" data-toogle="1" id="label-'.$data_header['id'].'">
          <b>'.$data_jasa['nama_jasa'].'</b></label> <br>'; //nama yang tampil

      echo '
        </div>
      </div>';
      
    
      //UNDER DETAIL dari HEADER
      echo '
      <div class="row">
        <div class="col-sm-1">
        </div>

        <div class="col-sm-11">';

        $query_detail = $db->query("SELECT id,nama_pemeriksaan,nama_sub,sub_hasil_lab FROM setup_hasil WHERE kategori_index = 'Detail' AND sub_hasil_lab = '$data_header[id]' ORDER BY id ASC ");
        while ($data_detail = mysqli_fetch_array($query_detail)) {

        $query_jasa = $db->query("SELECT id,kode_lab,nama AS nama_jasa,harga_1 FROM jasa_lab WHERE id = '$data_detail[nama_pemeriksaan]'");
        while($data_jasa = mysqli_fetch_array($query_jasa)){

          $query_tbs_data_periksa = $db->query("SELECT kode_jasa FROM tbs_aps_penjualan WHERE kode_jasa = '$data_jasa[kode_lab]' AND no_reg = '$no_reg' AND no_periksa_lab_inap = '$hasil_no_periksa'");

          $jumlah_data_periksa = mysqli_num_rows($query_tbs_data_periksa);

            if ($jumlah_data_periksa > 0) {

            echo '<input type="checkbox" class="pilih-detail-dari-kepala-'.$data_header['id'].' filled-in" data-headernya="'.$data_header['id'].'"  id="pemeriksaan-'.$data_detail['id'].'" style="padding-right: 50%;" data-toogle="22" data-id="'.$data_detail['id'].'"  name="detail_header" data-kode-jasa="'.$data_jasa['kode_lab'].'" value="'.$data_jasa['nama_jasa'].'" checked="true">

            <label for="pemeriksaan-'.$data_detail['id'].'" data-id="'.$data_detail['id'].'" data-head="'.$data_header['id'].'" data-kode="'.$data_detail['nama_pemeriksaan'].'" data-nama="'.$data_detail['nama_sub'].'" data-kode-jasa="'.$data_jasa['kode_lab'].'" class="pilih-detail-dari-header head-'.$data_header['id'].'" data-toogle="22">'.$data_jasa['nama_jasa'].'</label> <br>'; //nama yang tampil
            }
            else{
              echo '<input type="checkbox" class="pilih-detail-dari-kepala-'.$data_header['id'].' filled-in" data-headernya="'.$data_header['id'].'"  id="pemeriksaan-'.$data_detail['id'].'" style="padding-right: 50%;" data-toogle="2" data-id="'.$data_detail['id'].'"  name="detail_header" data-kode-jasa="'.$data_jasa['kode_lab'].'" value="'.$data_jasa['nama_jasa'].'">

              <label for="pemeriksaan-'.$data_detail['id'].'" data-id="'.$data_detail['id'].'" data-head="'.$data_header['id'].'" data-kode="'.$data_detail['nama_pemeriksaan'].'" data-nama="'.$data_detail['nama_sub'].'" data-kode-jasa="'.$data_jasa['kode_lab'].'" class="pilih-detail-dari-header head-'.$data_header['id'].'" data-toogle="2">'.$data_jasa['nama_jasa'].'</label> <br>'; //nama yang tampil

            }
      }
      }
      //ENDING UNDER DETAIL dari HEADER
    echo '
      </div>
    </div>';
     // DETAIL dari HEADER END 
    }
  } // END WHILE AWAL
} // END WHILE AKHIR                
?>
<!--AKHIR TAMPILAN DATA HEADER & DETAILNYA-->
 </div> <!-- /  -->

<div class="form-group col-xs-6"> <!-- /  -->

<!--MULAI TAMPILAN DATA SENDIRIAN-->
<?php 
$query_header = $db->query("SELECT id,nama_pemeriksaan,nama_sub,sub_hasil_lab FROM setup_hasil WHERE kategori_index = 'Detail' AND sub_hasil_lab = '0' ORDER BY id ASC ");
while ($data_header = mysqli_fetch_array($query_header)) {

$query_jasa = $db->query("SELECT id,kode_lab,nama AS nama_jasa,harga_1 FROM jasa_lab WHERE id = '$data_header[nama_pemeriksaan]'");
while($data_jasa = mysqli_fetch_array($query_jasa)){

 $query_tbs_data_periksa = $db->query("SELECT kode_jasa FROM tbs_aps_penjualan WHERE kode_jasa = '$data_jasa[kode_lab]' AND no_reg = '$no_reg' AND no_periksa_lab_inap = '$hasil_no_periksa'");

  $jumlah_data_periksa = mysqli_num_rows($query_tbs_data_periksa);

  if ($jumlah_data_periksa > 0) {

echo '
<div class="row">
  <div class="col-sm-8">';  

  echo '<input type="checkbox" class="cekcbox-3 filled-in" id="pemeriksaan-'.$data_header['id'].'" data-id="'.$data_header['id'].'" data-toogle="33" data-kode-jasa="'.$data_jasa['kode_lab'].'" name="detail_solo" value="'.$data_jasa['nama_jasa'].'" checked="true">

  <label for="pemeriksaan-'.$data_header['id'].'" data-id="'.$data_header['id'].'" data-kode="'.$data_header['nama_pemeriksaan'].'" data-nama="'.$data_header['nama_sub'].'" data-kode-jasa="'.$data_jasa['kode_lab'].'" class="set-sendirian" data-toogle="33" id="label-'.$data_header['id'].'">
  <b>'.$data_jasa['nama_jasa'].'</b></label> <br>'; //nama yang tampil

echo '
  </div>
</div>';

}
else{

echo '
<div class="row">
  <div class="col-sm-8">';  

  echo '<input type="checkbox" class="cekcbox-3 filled-in" id="pemeriksaan-'.$data_header['id'].'" data-id="'.$data_header['id'].'" data-toogle="3" data-kode-jasa="'.$data_jasa['kode_lab'].'" name="detail_solo" value="'.$data_jasa['nama_jasa'].'">

  <label for="pemeriksaan-'.$data_header['id'].'" data-id="'.$data_header['id'].'" data-kode="'.$data_header['nama_pemeriksaan'].'" data-nama="'.$data_header['nama_sub'].'" data-kode-jasa="'.$data_jasa['kode_lab'].'" class="set-sendirian" data-toogle="3" id="label-'.$data_header['id'].'">
  <b>'.$data_jasa['nama_jasa'].'</b></label> <br>'; //nama yang tampil

echo '
  </div>
</div>';

  }
}
}  

?>
<!--AKHIR TAMPILAN DATA SENDIRIAN-->

</div> <!-- /  -->

             

            </div>

        </form>
      <!--Akhir Modal Body-->
      </div>

      <div class="modal-footer">
      <center>
        <button type="button" class="btn btn-warning" id="simpan_data"> <i class='fa fa-save'></i> Save</button>
        <button type="button" accesskey="e" class="btn btn-danger" data-dismiss="modal"><i class='fa fa-close'></i> Close</button>
        </center>
      </div>

    <!--Akhir Div Modal Header LAB-->
    </div>
  <!--Akhir Div Modal Dialog-->
  </div>
<!--Akhir Modal Data Laboratorium-->
</div>



<!--Mulai Padding layar-->
<div style="padding-left: 5%; padding-right: 5%">
  <!--Judul-->
    <h3><b>FORM INPUT JASA LABORATOIUM</b></h3>
    <!--Garis-->
    <hr>

<!--Mulai Form and Proses-->
<form role="form" >
  <!--Mulai Row Pertama-->
    <div class="row">
      <!--Mulai Col SM Awal-->
      <div class="col-sm-10">

        <div class="col-xs-1">
            <label for="no_rm">No RM</label>
            <input style="height: 20px;" value="<?php echo $no_rm ?>" type="text" class="form-control disable1" readonly="" id="no_rm" name="no_rm"    >
          </div>

          <div class="col-xs-2">
            <label for="no_rm">No REG</label>
            <input style="height: 20px;" value="<?php echo $no_reg ?>" type="text" class="form-control disable1" readonly="" id="no_reg" name="no_reg"    >
          </div>

          <div class="col-xs-3">
            <label for="no_rm">Pasien</label>
            <input style="height: 20px;" value="<?php echo $nama ?>" type="text" class="form-control disable1" readonly="" id="nama_pasien" name="nama_pasien"    >
          </div>

          <div class="col-xs-2">
            <label> Dokter Pengirim </label><br>
            <select style="height: 20px;" name="dokter" id="dokter" class="form-control chosen" required="" >
            <?php 
            $query_dokter = $db->query("SELECT nama,id FROM user WHERE tipe = '1'");
            while($data_dokter = mysqli_fetch_array($query_dokter)){
              if ($data_dokter['id'] == $dokter) {
                echo "<option selected value='".$data_dokter['id'] ."'>".$data_dokter['nama'] ."</option>";
              }
              else{
                echo "<option value='".$data_dokter['id'] ."'>".$data_dokter['nama'] ."</option>";
              }
            }
            ?>
            </select>
        </div>

        <div class="form-group col-xs-2">
          <label for="penjamin">Petugas Analis
            
            </label><br>
            <select type="text" class="form-control chosen" id="analis" autocomplete="off">
            <?php

              $query_analis = $db->query("SELECT nama,id FROM user WHERE tipe = '6' ");
              while ( $data_analis = mysqli_fetch_array($query_analis)) {
              echo "<option value='".$data_analis['id'] ."'>
              ".$data_analis['nama'] ."</option>";
              }

            ?>
            </select>
        </div>

        <div class="col-xs-1">
          <label> Periksa Ke</label><br> 
          <input  name="pemeriksaan_keberapa" type="text" style="height:15px;" id="pemeriksaan_keberapa" readonly="" value="<?php echo $hasil_no_periksa ?>" class="form-control" required="">
        </div>

      <!--Mulai Col SM Awal-->  
      </div>

      <!--Mulai Col 2 SM Awal (untuk nilai Penjualan)-->
      <div class="col-sm-2">

      <!--Mulai Col 2 SM Awal (untuk nilai Penjualan)-->
      </div>

      <!--Mulai Col SM Kedua-->
      <div class="col-sm-8">

          <a type="button" class="btn btn-warning" href="pasien_sudah_masuk.php"><i class="fa fa-reply-all"></i> Kembali</a>
          
      
        <button type="button" id="cari_jasa_laboratorium" class="btn btn-info " data-toggle="modal" data-target="#modal_lab"><i class='fa fa-search'></i> Cari Laboratorium (F1) </button> 

        <button class="btn btn-success" style="display:none"  id="simpan_lab_inap"> <i class="fa fa-save"></i> Simpan Data </button>

      <!--Akhir Col SM Kedua-->
      </div>

<br><br>

<!--Mulai Col SM Ketiga-->
<div class="col-sm-12">

<!--TABLE LABORATORIUM-->
<span id="span_tbs_laboratorium">            
  <div class="table-responsive">
    <table id="table_tbs_laboratorium" class="table table-bordered table-sm">
    <thead> <!-- untuk memberikan nama pada kolom tabel -->
                              
      <th style='background-color: #4CAF50; color: white'> Kode </th>
      <th style='background-color: #4CAF50; color: white'> Nama </th>
      <th style='background-color: #4CAF50; color: white'> Komisi </th>
      <th style='background-color: #4CAF50; color: white'> Dokter</th>
      <th style='background-color: #4CAF50; color: white'> Analis</th>
      <th style='background-color: #4CAF50; color: white'> Tanggal</th>
      <th style='background-color: #4CAF50; color: white'> Jam</th>
      <th style='background-color: #4CAF50; color: white'> Hapus </th>
                          
    </thead> <!-- tag penutup tabel -->
    <tbody class="tbody">
      
    </tbody>
    </table>
  </div>
</span> 

<!--Akhir Col SM Ketiga-->
</div>

        <!--Mulai Input Hidden-->
        <input  name="" type="hidden" style="height:15px;" id="bed" class="form-control" required="" autofocus="" value="<?php echo $bed; ?>" >
        <input  name="" type="hidden" style="height:15px;" id="kamar" class="form-control" required="" autofocus="" value="<?php echo $kamar; ?>" >

        <input style="height: 20px;" value="<?php echo $jenis_penjualan ?>" type="hidden" class="form-control disable1" readonly="" id="jenis_penjualan" name="jenis_penjualan">

        <input style="height: 20px;" value="<?php echo $rujukan ?>" type="hidden" class="form-control disable1" readonly="" id="rujukan" name="rujukan">

        <input style="height: 20px;" type="hidden" class="form-control disable1" readonly="" id="kolom_cek_harga" name="kolom_cek_harga">
        <!--Akhir Input Hidden-->

    <!--Mulai Input Hidden RADIOLOGI-->
    <input type="hidden" id="id_radiologi" name="id_radiologi" class="form-control" placeholder="Id Radiologi"> 
    <input type="hidden" id="nama_barang" name="nama_barang" class="form-control" placeholder="Nama Barang"> 
    <input type="hidden" id="kontras" name="kontras" class="form-control" placeholder="Kontras"> 
    <input type="hidden" id="harga_produk" name="harga_produk" class="form-control" placeholder="Harga Produk"> 

    <!--Akhir Row Pertama-->
    </div>


      


<!--Akhir Form and Proses-->
</form>
<!--Akhir Padding layar-->
</div>

<!-- js untuk tombol shortcut -->
<script src="shortcut.js"></script>
<script type="text/javascript">
//short cut keyboard
shortcut.add("f1", function() {
    $("#cari_jasa_laboratorium").click();
}); 
</script>

<script type="text/javascript">
//chosen selected
$(".chosen").chosen({no_results_text: "Maaf, Data Tidak Ada!",
  search_contains:true});  
</script>


<script type="text/javascript">
//Fungsi Header
$(function() {
$('.pilih-header-input').click(function() {

//data togle dari modal
    var id_periksa = $(this).attr('data-id-kepala');
    //console.log(id_periksa);
$('.pilih-detail-dari-kepala-'+id_periksa+'').prop('checked', this.checked);
    });
 });
</script>

<!--Mulai Script Proses untuk Header-->
<script>
$(document).on('click','.pilih-header',function(e){
//data togle dari modal
    var data_toggle = $(this).attr('data-toogle');
    var id_periksa = $(this).attr('data-id');
    var kode_jasa_lab = $(this).attr('data-kode-jasa');

// ambil dari form yang tampil
    var no_rm = $("#no_rm").val();
    var no_reg = $("#no_reg").val();
    var analis = $("#analis").val();
    var dokter = $("#dokter").val();
    var nama_pasien = $("#nama_pasien").val();
    var tipe_barang = "Jasa";

//ambil dari form yang hidden
    var jenis_penjualan = $("#jenis_penjualan").val();
    var jenis_kelamin = $("#jenis_kelamin").val();

    var pemeriksaan_keberapa = $("#pemeriksaan_keberapa").val();
    $('#kolom_cek_harga').val('1');
    var kolom_cek_harga = $("#kolom_cek_harga").val();

    if (data_toggle == 1) {
              
      $(this).attr("data-toogle", 11);

      $.post("proses_input_data_header_inap.php",{id_periksa:id_periksa,kode_jasa_lab:kode_jasa_lab,no_rm:no_rm,no_reg:no_reg,analis:analis,dokter:dokter,nama_pasien:nama_pasien,tipe_barang:tipe_barang,jenis_penjualan:jenis_penjualan,jenis_kelamin:jenis_kelamin,pemeriksaan_keberapa:pemeriksaan_keberapa},function(data){
 

      });
    }
    else{
      $(this).attr("data-toogle", 1);

      $.post("hapus_data_header.php",{kode_jasa_lab:kode_jasa_lab,no_reg:no_reg,pemeriksaan_keberapa:pemeriksaan_keberapa},function(data){

      });
    }
  
  $("form").submit(function(){
      return false;    
  });
});
</script>
<!--Akhir Script Proses untuk Header-->

<!--Mulai Script Proses untuk Detail-->
<script>
$(document).on('click','.pilih-detail-dari-header',function(e){
//data togle dari modal
    var data_toggle = $(this).attr('data-toogle');
    var id_periksa = $(this).attr('data-id');
    var kode_jasa_lab = $(this).attr('data-kode-jasa');

// ambil dari form yang tampil
    var no_rm = $("#no_rm").val();
    var no_reg = $("#no_reg").val();
    var analis = $("#analis").val();
    var dokter = $("#dokter").val();
    var nama_pasien = $("#nama_pasien").val();
    var tipe_barang = "Jasa";

//ambil dari form yang hidden
    var jenis_penjualan = $("#jenis_penjualan").val();
    var jenis_kelamin = $("#jenis_kelamin").val();

    var pemeriksaan_keberapa = $("#pemeriksaan_keberapa").val();

    if (data_toggle == 2) {
              
      $(this).attr("data-toogle", 22);

      $.post("proses_input_data_detail_inap.php",{id_periksa:id_periksa,kode_jasa_lab:kode_jasa_lab,no_rm:no_rm,no_reg:no_reg,analis:analis,dokter:dokter,nama_pasien:nama_pasien,tipe_barang:tipe_barang,jenis_penjualan:jenis_penjualan,jenis_kelamin:jenis_kelamin,pemeriksaan_keberapa:pemeriksaan_keberapa},function(data){
 

      });
    }
    else{
      $(this).attr("data-toogle", 2);

      $.post("hapus_data_detail.php",{kode_jasa_lab:kode_jasa_lab,no_reg:no_reg,pemeriksaan_keberapa:pemeriksaan_keberapa},function(data){

      });
    }
  
  $("form").submit(function(){
      return false;    
  });
});
</script>
<!--Akhir Script Proses untuk Detail-->

<!--Mulai Script Proses untuk SENDIRIAN-->
<script>
$(document).on('click','.set-sendirian',function(e){
//data togle dari modal
    var data_toggle = $(this).attr('data-toogle');
    var id_periksa = $(this).attr('data-id');
    var kode_jasa_lab = $(this).attr('data-kode-jasa');

// ambil dari form yang tampil
    var no_rm = $("#no_rm").val();
    var no_reg = $("#no_reg").val();
    var analis = $("#analis").val();
    var dokter = $("#dokter").val();
    var nama_pasien = $("#nama_pasien").val();
    var tipe_barang = "Jasa";

//ambil dari form yang hidden
    var jenis_penjualan = $("#jenis_penjualan").val();
    var jenis_kelamin = $("#jenis_kelamin").val();

    var pemeriksaan_keberapa = $("#pemeriksaan_keberapa").val();

    if (data_toggle == 3) {
              
      $(this).attr("data-toogle", 33);

      $.post("proses_input_data_detail_sendirian_inap.php",{id_periksa:id_periksa,kode_jasa_lab:kode_jasa_lab,no_rm:no_rm,no_reg:no_reg,analis:analis,dokter:dokter,nama_pasien:nama_pasien,tipe_barang:tipe_barang,jenis_penjualan:jenis_penjualan,jenis_kelamin:jenis_kelamin,pemeriksaan_keberapa:pemeriksaan_keberapa},function(data){
 

      });
    }
    else{

      $(this).attr("data-toogle", 3);

      $.post("hapus_data_detail_sendirian.php",{kode_jasa_lab:kode_jasa_lab,no_reg:no_reg,pemeriksaan_keberapa:pemeriksaan_keberapa},function(data){

      });
    }
  
  $("form").submit(function(){
      return false;    
  });
});
</script>
<!--Akhir Script Proses untuk SENDIRIAN-->



<!--Start Tampilan Awal DataTable Ajax-->
<script type="text/javascript">
  $(document).ready(function(){

      $('#table_tbs_laboratorium').DataTable().destroy();
        var dataTable = $('#table_tbs_laboratorium').DataTable( {
          "processing": true,
          "serverSide": true,
          "info":     true,
          "language": { "emptyTable":     "Tidak Ada Data" },
          "ajax":{
            
            url :"data_tbs_aps_laboratorium_inap.php", // json datasource
            
            "data": function ( d ) {
              d.no_reg = $("#no_reg").val();
              d.pemeriksaan_keberapa = $("#pemeriksaan_keberapa").val();
            
            },

            type: "post",  // method  , by default get
            error: function(){  // error handling
              $(".tbody").html("");
              $("#table_tbs_laboratorium").append('<tbody class="tbody"><tr><th colspan="3"></th></tr></tbody>');
              $("#table_tbs_laboratorium_processing").css("display","none"); 
            }
          }   
        });
      $("#span_tbs").show()
  });
</script>
<!--Akhir Tampilan Awal DataTable Ajax-->

<!--Mulai Script Proses Save Pada Modal-->
<script type="text/javascript">
  $(document).ready(function(){
    $(document).on('click','#simpan_data',function(e){

    //TABLE AJAX TBS
    $('#table_tbs_laboratorium').DataTable().destroy();
        var dataTable = $('#table_tbs_laboratorium').DataTable( {
          "processing": true,
          "serverSide": true,
          "info":     true,
          "language": { "emptyTable":     "Tidak Ada Data" },
          "ajax":{
            
            url :"data_tbs_aps_laboratorium_inap.php", // json datasource
            
            "data": function ( d ) {
              d.no_reg = $("#no_reg").val();
              d.pemeriksaan_keberapa = $("#pemeriksaan_keberapa").val();
            
            },

            type: "post",  // method  , by default get
            error: function(){  // error handling
              $(".tbody").html("");
              $("#table_tbs_laboratorium").append('<tbody class="tbody"><tr><th colspan="3"></th></tr></tbody>');
              $("#table_tbs_laboratorium_processing").css("display","none"); 
            }
          }   
        });

      $("#simpan_lab_inap").show();
      $("#span_tbs").show();
      $("#modal_lab").modal('hide');
    //TABLE AJAX TBS
    });
  });
</script>
<!--Akhir Script Proses Save Pada Modal-->

<!--Mulai Script Proses Hapus TBS -->
<script type="text/javascript">
  $(document).on('click','.btn-hapus-tbs',function(e){

    var id = $(this).attr("data-id");
    var kode_jasa = $(this).attr("data-kode");
    var nama_jasa = $(this).attr("data-barang");
    var no_reg = $("#no_reg").val();

    var pesan_alert = confirm("Apakah Anda Yakin Ingin Menghapus "+nama_jasa+""+ "?");

    if (pesan_alert == true) {

        $.post("hapus_data_tbs_aps.php",{kode_jasa:kode_jasa,no_reg:no_reg,id:id},function(data){

          //TABLE AJAX TBS
          $('#table_tbs_laboratorium').DataTable().destroy();
              var dataTable = $('#table_tbs_laboratorium').DataTable( {
                "processing": true,
                "serverSide": true,
                "info":     true,
                "language": { "emptyTable":     "Tidak Ada Data" },
                "ajax":{
                  
                  url :"data_tbs_aps_laboratorium_inap.php", // json datasource
                  
                  "data": function ( d ) {
                    d.no_reg = $("#no_reg").val();
                    d.pemeriksaan_keberapa = $("#pemeriksaan_keberapa").val();
                  
                  },

                  type: "post",  // method  , by default get
                  error: function(){  // error handling
                    $(".tbody").html("");
                    $("#table_tbs_laboratorium").append('<tbody class="tbody"><tr><th colspan="3"></th></tr></tbody>');
                    $("#table_tbs_laboratorium_processing").css("display","none"); 
                  }
                }   
          });
          //TABLE AJAX TBS

        });

    }
    else{

    }
    $('form').submit(function(){       
      return false;
    });

  });
</script>
<!--Mulai Script Proses Hapus TBS-->

<!--start PROSES SIMPAN-->
<script type="text/javascript">
$(document).on('click', '#simpan_lab_inap', function (e) {

    var nama_pasien = $("#nama_pasien").val();
    var no_rm = $("#no_rm").val();
    var no_reg = $("#no_reg").val();
    var bed = $("#bed").val();
    var kamar = $("#kamar").val();
    var pemeriksaan_keberapa = $("#pemeriksaan_keberapa").val();
    var analis = $("#analis").val();
    var dokter = $("#dokter").val();
    var jenis_kelamin = $("#jenis_kelamin").val();
    var rujukan = $("#rujukan").val();

    $.post('proses_simpan_lab_inap.php',{no_reg:no_reg,pemeriksaan_keberapa:pemeriksaan_keberapa,no_rm:no_rm,nama_pasien:nama_pasien}, function(data){
     
      if(data == 1){
      window.location.href='data_laboratorium_inap.php?no_reg='+no_reg+'&nama='+nama_pasien+'&dokter_pengirim='+dokter+'&jenis_kelamin='+jenis_kelamin+'&bed='+bed+'&kamar='+kamar+'&rujukan='+rujukan+'&no_rm='+no_rm;

      }

    });////penutup function(data)
      $("form").submit(function(){
        return false;    
      });
});//penutup click(function()
</script>
<!--PROSES SIMPAN ENDING-->


<!--footer-->
<?php include 'footer.php'; ?>