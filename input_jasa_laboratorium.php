<?php include 'session_login.php';
// memasukan file session login,  header, navbar, db.php,
include 'header.php';
include 'navbar.php';
include 'db.php';
include 'sanitasi.php';


$dokter = stringdoang($_GET['dokter']);
$no_rm = stringdoang($_GET['no_rm']);
$no_reg = stringdoang($_GET['no_reg']);
$nama = stringdoang($_GET['nama']);
$jenis_penjualan = stringdoang($_GET['jenis_penjualan']);
$jenis_kelamin = stringdoang($_GET['jenis_kelamin']);
$aps_periksa = stringdoang($_GET['aps_periksa']); // jika 1 Laboratorium, jika 2 Radiologi

if($aps_periksa == 1){
  $tema = 'LABORATORIUM';
}
else{
  $tema = 'RADIOLOGI';
}

?>
<!--MODAL JASA RADIOLOGI-->
<div id="myModal" class="modal fade" role="dialog">
  <div class="modal-dialog">

    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
               
              <h4 class="modal-title">Daftar Pemeriksaan Radiologi</h4>
      </div>
      <div class="modal-body">

        <form class="form"  role="form" id="formtambahprodukcari">
            <div class="table-responsive">
              
              <div class="form-group col-xs-6"> <!-- /  -->

                <h5><b> Pakai Kontras </b></h5><br>

                  <input type="checkbox" class="cekcbox1 filled-in" id="checkbox1">
                  <label for="checkbox1" class="pilih-semua-kontras" data-toogle="0"><b> PILIH SEMUA </b></label><br>
                  
                  <?php 
                    $select_pemriksaan_kontras = $db->query("SELECT id, kode_pemeriksaan, nama_pemeriksaan, kontras, harga_1 FROM pemeriksaan_radiologi WHERE kontras = '1' ORDER BY no_urut ASC");

                    while ($data_kontras = mysqli_fetch_array($select_pemriksaan_kontras)) {

                    $query_pemeriksaan = $db->query("SELECT kode_barang FROM tbs_penjualan_radiologi WHERE kode_barang = '$data_kontras[kode_pemeriksaan]' AND no_reg = '$no_reg'");

                    $jumlah_pemeriksaan = mysqli_num_rows($query_pemeriksaan);

                      if ($jumlah_pemeriksaan > 0) {
                      
                          echo '<input type="checkbox" class="cekcbox-1 filled-in" id="pemeriksaan-'.$data_kontras['id'].'" name="pakai_kontras" value="'.$data_kontras['kode_pemeriksaan'].'" checked="true" >
                          <label for="pemeriksaan-'.$data_kontras['id'].'"
                          data-id="'.$data_kontras['id'].'"
                          data-kode="'.$data_kontras['kode_pemeriksaan'].'"
                          data-nama="'.$data_kontras['nama_pemeriksaan'].'"
                          data-kontras="'.$data_kontras['kontras'].'"
                          data-harga="'.$data_kontras['harga_1'].'" class="insert-tbs" data-toogle="1" id="label-'.$data_kontras['id'].'"
                           checked="true" >'.$data_kontras['nama_pemeriksaan'].'</label> <br>';

                      }
                      else{
                      
                          echo '<input type="checkbox" class="cekcbox-1 filled-in" id="pemeriksaan-'.$data_kontras['id'].'" name="pakai_kontras" value="'.$data_kontras['kode_pemeriksaan'].'">
                          <label for="pemeriksaan-'.$data_kontras['id'].'"
                          data-id="'.$data_kontras['id'].'"
                          data-kode="'.$data_kontras['kode_pemeriksaan'].'"
                          data-nama="'.$data_kontras['nama_pemeriksaan'].'"
                          data-kontras="'.$data_kontras['kontras'].'"
                          data-harga="'.$data_kontras['harga_1'].'" class="insert-tbs pemeriksaan-kontras" data-toogle="0" id="label-'.$data_kontras['id'].'"
                          >'.$data_kontras['nama_pemeriksaan'].'</label> <br>';

                      }

                    }
                    
                  ?>

              </div> <!-- /  -->

              <div class="form-group col-xs-6"> <!-- /  -->

                <h5><b> Tidak Pakai Kontras </b></h5><br>

                  <input type="checkbox" class="cekcbox2 filled-in" id="checkbox2">
                  <label for="checkbox2" class="pilih-semua-tanpa-kontras" data-toogle="0"><b> PILIH SEMUA </b></label><br>

                  <?php 
                    $select_pemriksaan_tanpa_kontras = $db->query("SELECT id, kode_pemeriksaan, nama_pemeriksaan, kontras, harga_1 FROM pemeriksaan_radiologi WHERE kontras = '0' ORDER BY no_urut ASC");

                    while ($data_tanpa_kontras = mysqli_fetch_array($select_pemriksaan_tanpa_kontras)) {

                      $query_pemeriksaan = $db->query("SELECT kode_barang FROM tbs_penjualan_radiologi WHERE kode_barang = '$data_tanpa_kontras[kode_pemeriksaan]' AND no_reg = '$no_reg'");

                      $jumlah_pemeriksaan = mysqli_num_rows($query_pemeriksaan);

                        if ($jumlah_pemeriksaan > 0) {

                            echo '<input type="checkbox" class="cekcbox-2 filled-in" name="tanpa_kontras" 
                            id="pemeriksaan-'.$data_tanpa_kontras['id'].'" value="'.$data_tanpa_kontras['kode_pemeriksaan'].'" checked="true"  > 
                            <label for="pemeriksaan-'.$data_tanpa_kontras['id'].'"
                            data-id="'.$data_tanpa_kontras['id'].'"
                            data-kode="'.$data_tanpa_kontras['kode_pemeriksaan'].'"
                            data-nama="'.$data_tanpa_kontras['nama_pemeriksaan'].'"
                            data-kontras="'.$data_tanpa_kontras['kontras'].'"
                            data-harga="'.$data_tanpa_kontras['harga_1'].'" class="insert-tbs" data-toogle="1" id="label-'.$data_tanpa_kontras['id'].'"
                             checked="true"  >'.$data_tanpa_kontras['nama_pemeriksaan'].'</label> <br>';
                        }
                        else{

                            echo '<input type="checkbox" class="cekcbox-2 filled-in" name="tanpa_kontras" 
                            id="pemeriksaan-'.$data_tanpa_kontras['id'].'" value="'.$data_tanpa_kontras['kode_pemeriksaan'].'"> 
                            <label for="pemeriksaan-'.$data_tanpa_kontras['id'].'"
                            data-id="'.$data_tanpa_kontras['id'].'"
                            data-kode="'.$data_tanpa_kontras['kode_pemeriksaan'].'"
                            data-nama="'.$data_tanpa_kontras['nama_pemeriksaan'].'"
                            data-kontras="'.$data_tanpa_kontras['kontras'].'"
                            data-harga="'.$data_tanpa_kontras['harga_1'].'" class="insert-tbs pemeriksaan-tanpa-kontras" data-toogle="0" id="label-'.$data_tanpa_kontras['id'].'"
                            >'.$data_tanpa_kontras['nama_pemeriksaan'].'</label> <br>';
                        }


                    }
                    
                  ?>

              </div> <!-- /  -->

            </div>
        </form>
      
      </div>

      <div class="modal-footer">
      <center>
        <button type="button" class="btn btn-warning" id="btnSubmit"> <i class='fa fa-save'></i> Save</button>
        <!--<button type="button" class="btn btn-danger" id="btnCancel"><i class='fa fa-close'></i> Cancel</button>-->

        <button type="button" accesskey="e" class="btn btn-danger" data-dismiss="modal"><i class='fa fa-close'></i> Close</button>

      </center>
      </div>
    </div>

  </div>
</div>
<!--MODAL JASA RADIOLOGI-->



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

    $query_tbs_data_periksa = $db->query("SELECT kode_jasa FROM tbs_aps_penjualan WHERE kode_jasa = '$data_jasa[kode_lab]' AND no_reg = '$no_reg'");

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

          $query_tbs_data_periksa = $db->query("SELECT kode_jasa FROM tbs_aps_penjualan WHERE kode_jasa = '$data_jasa[kode_lab]' AND no_reg = '$no_reg'");

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

 $query_tbs_data_periksa = $db->query("SELECT kode_jasa FROM tbs_aps_penjualan WHERE kode_jasa = '$data_jasa[kode_lab]' AND no_reg = '$no_reg'");

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
    <h3><b>FORM INPUT JASA <?php echo $tema ?></b></h3>
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

          <div class="col-xs-3">
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

        <div class="form-group col-xs-3">
          <label for="penjamin">Petugas 
            <?php if($aps_periksa == 1){
            echo "Analis";
            }
            else{
            echo "Radilogi";
            }
            ?>
            </label><br>
            <select type="text" class="form-control chosen" id="analis" autocomplete="off">
            <?php
            if($aps_periksa == 1){

              $query_analis = $db->query("SELECT nama,id FROM user WHERE tipe = '6' ");
              while ( $data_analis = mysqli_fetch_array($query_analis)) {
              echo "<option value='".$data_analis['id'] ."'>
              ".$data_analis['nama'] ."</option>";
              }

            }
            else{
              $query_petugas_radiologi = $db->query("SELECT nama,id FROM user WHERE tipe = '5' ");
              while ( $data_analis = mysqli_fetch_array($query_petugas_radiologi)) {
              echo "<option value='".$data_analis['id'] ."'>
              ".$data_analis['nama'] ."</option>";
              }
            }
            ?>
            </select>
        </div>

      <!--Mulai Col SM Awal-->  
      </div>

      <!--Mulai Col 2 SM Awal (untuk nilai Penjualan)-->
      <div class="col-sm-2">

      <!--Mulai Col 2 SM Awal (untuk nilai Penjualan)-->
      </div>

      <!--Mulai Col SM Kedua-->
      <div class="col-sm-8">

          <a type="button" class="btn btn-warning" href="registrasi_laboratorium.php"><i class="fa fa-reply-all"></i> Kembali</a>
          
        <?php if($aps_periksa == 1): ?>
        <button type="button" id="cari_jasa_laboratorium" class="btn btn-info " data-toggle="modal" data-target="#modal_lab"><i class='fa fa-search'></i> Cari Laboratorium (F1) </button> 
          <?php endif ?>

          <?php if($aps_periksa == 2): ?>
        <button type="button" id="cari_jasa_radiologi" class="btn btn-info " data-toggle="modal" data-target="#myModal"><i class='fa fa-search'></i> Cari Radilogi (F2) </button> 
          <?php endif ?>


      <!--Akhir Col SM Kedua-->
      </div>

<br><br>

<!--Mulai Col SM Ketiga-->
<div class="col-sm-12">

<?php 
if($aps_periksa == 1){?>
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

<?php 
}
else{
?>
<!--TABLE RADIOLOGI-->
<span id="span_tbs">            
    <div class="table-responsive">
      <table id="tabel_tbs_radiologi" class="table table-bordered table-sm">
        <thead> <!-- untuk memberikan nama pada kolom tabel -->
                            
          <th style='background-color: #4CAF50; color: white'> Kode  </th>
          <th style='background-color: #4CAF50; color: white'> Nama Pemeriksaan</th>
          <th style='background-color: #4CAF50; color: white'> Dokter Pengirim </th>
          <th style='background-color: #4CAF50; color: white'> Hapus </th>
                          
        </thead> <!-- tag penutup tabel -->
      </table>
    </div>
</span> 
<?php } ?>

<!--Akhir Col SM Ketiga-->
</div>

        <!--Mulai Input Hidden-->
        <input style="height: 20px;" value="<?php echo $jenis_penjualan ?>" type="hidden" class="form-control disable1" readonly="" id="jenis_penjualan" name="jenis_penjualan">

        <input style="height: 20px;" value="<?php echo $jenis_kelamin ?>" type="hidden" class="form-control disable1" readonly="" id="jenis_kelamin" name="jenis_kelamin">

        <input style="height: 20px;" value="<?php echo $aps_periksa ?>" type="hidden" class="form-control disable1" readonly="" id="aps_periksa" name="aps_periksa">

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
shortcut.add("f2", function() {
    $("#cari_jasa_radiologi").click();
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
    var aps_periksa = $("#aps_periksa").val();

    $('#kolom_cek_harga').val('1');
    var kolom_cek_harga = $("#kolom_cek_harga").val();

    if (data_toggle == 1) {
              
      $(this).attr("data-toogle", 11);

      $.post("proses_input_data_header.php",{id_periksa:id_periksa,kode_jasa_lab:kode_jasa_lab,no_rm:no_rm,no_reg:no_reg,analis:analis,dokter:dokter,nama_pasien:nama_pasien,tipe_barang:tipe_barang,jenis_penjualan:jenis_penjualan,jenis_kelamin:jenis_kelamin,aps_periksa:aps_periksa},function(data){
 

      });
    }
    else{
      $(this).attr("data-toogle", 1);

      $.post("hapus_data_header.php",{kode_jasa_lab:kode_jasa_lab,no_reg:no_reg},function(data){

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
    var aps_periksa = $("#aps_periksa").val();

    if (data_toggle == 2) {
              
      $(this).attr("data-toogle", 22);

      $.post("proses_input_data_detail.php",{id_periksa:id_periksa,kode_jasa_lab:kode_jasa_lab,no_rm:no_rm,no_reg:no_reg,analis:analis,dokter:dokter,nama_pasien:nama_pasien,tipe_barang:tipe_barang,jenis_penjualan:jenis_penjualan,jenis_kelamin:jenis_kelamin,aps_periksa:aps_periksa},function(data){
 

      });
    }
    else{
      $(this).attr("data-toogle", 2);

      $.post("hapus_data_detail.php",{kode_jasa_lab:kode_jasa_lab,no_reg:no_reg},function(data){

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
    var aps_periksa = $("#aps_periksa").val();

    if (data_toggle == 3) {
              
      $(this).attr("data-toogle", 33);

      $.post("proses_input_data_detail_sendirian.php",{id_periksa:id_periksa,kode_jasa_lab:kode_jasa_lab,no_rm:no_rm,no_reg:no_reg,analis:analis,dokter:dokter,nama_pasien:nama_pasien,tipe_barang:tipe_barang,jenis_penjualan:jenis_penjualan,jenis_kelamin:jenis_kelamin,aps_periksa:aps_periksa},function(data){
 

      });
    }
    else{

      $(this).attr("data-toogle", 3);

      $.post("hapus_data_detail_sendirian.php",{kode_jasa_lab:kode_jasa_lab,no_reg:no_reg},function(data){

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

    /*var no_reg = $("#no_reg").val();
    //Ambil Data Togle dari Header, Detail, dan Hasil Sendirian

    
    $.post("cek_data_tbs_aps.php",{no_reg:no_reg},function(data){

      if(data == 1){

      }
    });*/


      $('#table_tbs_laboratorium').DataTable().destroy();
        var dataTable = $('#table_tbs_laboratorium').DataTable( {
          "processing": true,
          "serverSide": true,
          "info":     true,
          "language": { "emptyTable":     "Tidak Ada Data" },
          "ajax":{
            
            url :"data_tbs_aps_laboratorium.php", // json datasource
            
            "data": function ( d ) {
              d.no_reg = $("#no_reg").val();
            
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
            
            url :"data_tbs_aps_laboratorium.php", // json datasource
            
            "data": function ( d ) {
              d.no_reg = $("#no_reg").val();
            
            },

            type: "post",  // method  , by default get
            error: function(){  // error handling
              $(".tbody").html("");
              $("#table_tbs_laboratorium").append('<tbody class="tbody"><tr><th colspan="3"></th></tr></tbody>');
              $("#table_tbs_laboratorium_processing").css("display","none"); 
            }
          }   
        });

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
                  
                  url :"data_tbs_aps_laboratorium.php", // json datasource
                  
                  "data": function ( d ) {
                    d.no_reg = $("#no_reg").val();
                  
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

<!--<script type="text/javascript">
$(document).ready(function(){
var no_reg = $("#no_reg").val();
    //Ambil Data Togle dari Header, Detail, dan Hasil Sendirian
  
  /*$("#pemeriksaan-header-35" ).prop( "checked", true );//Header35
  $(".pilih-detail-dari-kepala-59" ).prop( "checked", true );//Detail dari Header 59
  $("#pemeriksaan-sendiri-43" ).prop( "checked", true );
  $("#pemeriksaan-sendiri-61" ).prop( "checked", true );//sendirian 43+61*/
    $.getJSON("cek_data_tbs_aps.php",{no_reg:no_reg},function(info){
 
  $.each(info.id_pemeriksaan, function(i, item) {

  var id_pemeriksaan = info.id[i].id_pemeriksaan;

  $("#pemeriksaan-header-"+info.id_pemeriksaan+"" ).prop( "checked", true );//Header35
  $(".pilih-detail-dari-kepala-"+info.id_pemeriksaan+"" ).prop( "checked", true );//Detail dari Header 59
  $("#pemeriksaan-sendiri-"+info.id_pemeriksaan+"" ).prop( "checked", true );//sendirian 43+61

  //var tr_barang = 
  //"<tr><td>"+ result.barang[i].kode_barang+"</td>                      <td>"+ result.barang[i].nama_barang+"</td>                         <td>"+ result.barang[i].jumlah_jual+"</td>                         <td>"+ result.barang[i].stok+"</td></tr>"

    // $("#tbody-barang-jual").prepend(tr_barang);

  });


  });
});
</script>-->

<!--SCRIPT BAWAH TENTANG RADIOLOGI-->
<script type="text/javascript">
$(function() {
    $('.cekcbox1').click(function() {
        $('.cekcbox-1').prop('checked', this.checked);
    });
});
</script>
  

<script type="text/javascript">
$(function() {
    $('.cekcbox2').click(function() {
        $('.cekcbox-2').prop('checked', this.checked);
    });
});
</script>


<!--AWAL UNTUK SCRIPT DATA RADIOLOGI-->
<script type="text/javascript">
//SCRIPT UNTUK PILIH SEMUA KONTRAS
$(document).on('click','.pilih-semua-kontras',function(e){

    var data_toggle = $(this).attr('data-toogle');

    var no_reg = $("#no_reg").val();
    var petugas_radiologi = $("#analis").val();
    var dokter = $("#dokter").val();
    var jumlah_barang = 1;
    var tipe_barang ="Jasa";

    if (data_toggle == 0) {
              
        $(this).attr("data-toogle", 1);
        $(".pemeriksaan-kontras").attr("data-toogle", 1);

        $.post("proses_insert_tbs_aps_semua_kontras.php",{tipe_barang:tipe_barang,no_reg:no_reg,dokter:dokter,petugas_radiologi:petugas_radiologi},function(data){
              
        });


    }
    else{
                  
        $(this).attr("data-toogle", 0);
        $(".pemeriksaan-kontras").attr("data-toogle", 0);

        $.post("hapus_tbs_aps_semua_kontras.php",{no_reg:no_reg},function(data){

        });
    }
    


    $("form").submit(function(){
      return false;    
    });
});
</script>

<!--INSERT SEMUANYA (PILIH SEMUA TANPA KONTRAS)-->

<script>
$(document).on('click','.pilih-semua-tanpa-kontras',function(e){

    var data_toggle = $(this).attr('data-toogle');
    var no_reg = $("#no_reg").val();
    var petugas_radiologi = $("#analis").val();
    var dokter = $("#dokter").val();
    var jumlah_barang = 1;
    var tipe_barang ="Jasa";

    if (data_toggle == 0) {
              
        $(this).attr("data-toogle", 1);
        $(".pemeriksaan-tanpa-kontras").attr("data-toogle", 1);

        $.post("proses_insert_tbs_aps_semua_tanpa_kontras.php",{tipe_barang:tipe_barang,no_reg:no_reg,dokter:dokter,petugas_radiologi:petugas_radiologi},function(data){
              
        });
    }
    else{
                  
        $(this).attr("data-toogle", 0);
        $(".pemeriksaan-tanpa-kontras").attr("data-toogle", 0);

        $.post("hapus_tbs_aps_semua_tanpa_kontras.php",{no_reg:no_reg},function(data){

        });
    }

    $("form").submit(function(){
      return false;    
    });
});
</script>

<!--SCRIPT JASA RADILOGI (SOLO) -->
<script type="text/javascript">
$(document).on('click','.insert-tbs',function(e){
    var data_toggle = $(this).attr('data-toogle');

    var kode_barang = $(this).attr('data-kode');
    var nama_barang = $(this).attr('data-nama');
    var kontras = $(this).attr('data-kontras');
    var harga = $(this).attr('data-harga');
    var id = $(this).attr('data-id');

    var no_reg = $("#no_reg").val();
    var petugas_radiologi = $("#analis").val();
    var dokter = $("#dokter").val();
    var jumlah_barang = 1;
    var tipe_barang ="Jasa";


    $('#nama_barang').val(nama_barang);
    $('#id_radiologi').val(id);
    $('#kontras').val(kontras);
    $('#harga_produk').val(harga);

    var nama_barang = $("#nama_barang").val();
    var id = $("#id_radiologi").val();
    var kontras = $("#kontras").val();
    var harga = $("#harga_produk").val();

    if (data_toggle == 0) {

        $.post('cek_tbs_penjualan_radiologi.php',{kode_barang:kode_barang,no_reg:no_reg}, function(data){


          if(data == 1){

              $('#label-'+id+'').attr("data-toogle", 0);

              alert("Pemeriksaan '"+nama_barang+"' Sudah Ada, Silakan Pilih Pemeriksaan Yang Lain !");
              
           }
           else{
              
              $('#label-'+id+'').attr("data-toogle", 1);
              console.log(data_toggle);

              $.post("proses_insert_tbs_aps_radiologi_detail.php",{nama_barang:nama_barang,jumlah_barang:jumlah_barang,harga:harga,tipe_barang:tipe_barang,kode_barang:kode_barang,no_reg:no_reg,dokter:dokter,kontras:kontras,petugas_radiologi:petugas_radiologi},function(data){


            });

           }

        });
    }
    else{
                  
        $('#label-'+id+'').attr("data-toogle", 0);

        $.post("hapus_tbs_aps_radiologi.php",{no_reg:no_reg, kode_barang:kode_barang},function(data){

        });
    }

    $("form").submit(function(){
    return false;    
    });
});
</script>

<script type="text/javascript">
  $(document).ready(function(){
    $(document).on('click','#btnSubmit',function(e){
    // START DATATABLE AJAX START DATATABLE AJAX START DATATABLE AJAX START DATATABLE AJAX START DATATABLE AJAX START DATATABLE AJAX
      $('#tabel_tbs_radiologi').DataTable().destroy();
            var dataTable = $('#tabel_tbs_radiologi').DataTable( {
            "processing": true,
            "serverSide": true,
            "info":     true,
            "language": { "emptyTable":     "Tidak Ada Data" },
            "ajax":{
              url :"data_tbs_aps_radiologi.php", // json datasource
                              "data": function ( d ) {
                                d.no_reg = $("#no_reg").val();
                                // d.custom = $('#myInput').val();
                                // etc
                              },
                              type: "post",  // method  , by default get
              error: function(){  // error handling
                $(".tbody").html("");
                $("#tabel_tbs_radiologi").append('<tbody class="tbody"><tr><th colspan="3"></th></tr></tbody>');
                $("#tableuser_processing").css("display","none");
                
              }
            }   

      });
        
        $("#span_tbs").show();
        $("#myModal").modal('hide');
    });   
  });
</script>


<script type="text/javascript">
  $(document).ready(function(){
    // START DATATABLE AJAX START DATATABLE AJAX START DATATABLE AJAX START DATATABLE AJAX START DATATABLE AJAX START DATATABLE AJAX
      $('#tabel_tbs_radiologi').DataTable().destroy();
            var dataTable = $('#tabel_tbs_radiologi').DataTable( {
            "processing": true,
            "serverSide": true,
            "info":     true,
            "language": { "emptyTable":     "Tidak Ada Data" },
            "ajax":{
              url :"data_tbs_aps_radiologi.php", // json datasource
                              "data": function ( d ) {
                                d.no_reg = $("#no_reg").val();
                                // d.custom = $('#myInput').val();
                                // etc
                              },
                              type: "post",  // method  , by default get
              error: function(){  // error handling
                $(".tbody").html("");
                $("#tabel_tbs_radiologi").append('<tbody class="tbody"><tr><th colspan="3"></th></tr></tbody>');
                $("#tableuser_processing").css("display","none");
                
            }
          }   
      });  
    $("#span_tbs").show()
  });
</script>
<!--AKHIR SCRIPT TENTANG RADIOLOGI-->

<!--Mulai Script Proses Hapus TBS -->
<script type="text/javascript">
  $(document).on('click','.btn-hapus-tbs-radiologi',function(e){

    var id = $(this).attr("data-id");
    var kode_jasa = $(this).attr("data-kode");
    var nama_jasa = $(this).attr("data-barang");
    var no_reg = $("#no_reg").val();

    var pesan_alert = confirm("Apakah Anda Yakin Ingin Menghapus "+nama_jasa+""+ "?");

    if (pesan_alert == true) {

        $.post("hapus_data_tbs_aps_radiologi.php",{kode_jasa:kode_jasa,no_reg:no_reg,id:id},function(data){

          //TABLE AJAX TBS
            $('#tabel_tbs_radiologi').DataTable().destroy();
            var dataTable = $('#tabel_tbs_radiologi').DataTable( {
            "processing": true,
            "serverSide": true,
            "info":     true,
            "language": { "emptyTable":     "Tidak Ada Data" },
            "ajax":{
              url :"data_tbs_aps_radiologi.php", // json datasource
                              "data": function ( d ) {
                                d.no_reg = $("#no_reg").val();
                                // d.custom = $('#myInput').val();
                                // etc
                              },
                              type: "post",  // method  , by default get
              error: function(){  // error handling
                $(".tbody").html("");
                $("#tabel_tbs_radiologi").append('<tbody class="tbody"><tr><th colspan="3"></th></tr></tbody>');
                $("#tableuser_processing").css("display","none");
                
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
<!--Akhir Script Proses Hapus TBS -->

<!--footer-->
<?php include 'footer.php'; ?>