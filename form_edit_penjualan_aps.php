<?php include_once 'session_login.php';
// memasukan file session login,  header, navbar, db.php,
include 'header.php';
include 'navbar.php';
include 'db.php';
include 'sanitasi.php';

//GET DATA
$session_id = session_id();
$user = $_SESSION['nama'];
$id_user = $_SESSION['id'];

$no_faktur = stringdoang($_GET['no_faktur']);
$no_rm = stringdoang($_GET['no_rm']);
$nama_pasien = stringdoang($_GET['nama_pasien']);
$no_reg = stringdoang($_GET['no_reg']);

//SELECT HAK AKSES
$pilih_akses_tombol = $db->query("SELECT tombol_submit, tombol_bayar, tombol_piutang, tombol_simpan, tombol_batal FROM otoritas_penjualan_rj WHERE id_otoritas = '$_SESSION[otoritas_id]' ");
$otoritas_tombol = mysqli_fetch_array($pilih_akses_tombol);

//SELECT PENJUALAN
$query_data_penjualan = $db->query("SELECT biaya_admin,potongan,cara_bayar,tunai AS bayar_sebelumnya,status_jual_awal AS status_bayar_sebelumnya,tanggal,sales FROM penjualan WHERE no_faktur = '$no_faktur' AND no_reg = '$no_reg'");
$data_penjualan = mysqli_fetch_array($query_data_penjualan);
$biaya_admin = $data_penjualan['biaya_admin'];
$diskon = $data_penjualan['potongan'];
$cara_bayar = $data_penjualan['cara_bayar'];
$bayar_sebelumnya = $data_penjualan['bayar_sebelumnya'];
$status_bayar_sebelumnya = $data_penjualan['status_bayar_sebelumnya'];
$tanggal = $data_penjualan['tanggal'];
$sales = $data_penjualan['sales'];

//SELECT PELANGGAN
$query_jenis_kelamin = $db_pasien->query("SELECT jenis_kelamin FROM pelanggan WHERE no_rm = '$no_rm'");
$data_jenis_kelamin = mysqli_fetch_array($query_jenis_kelamin);
$jenis_kelamin = $data_jenis_kelamin['jenis_kelamin'];
$jenis_penjualan = 'APS';
?>
<!--MULAI MODAL JASA LABORATORIUM-->

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

    $query_tbs_data_periksa = $db->query("SELECT kode_jasa FROM tbs_aps_penjualan WHERE kode_jasa = '$data_jasa[kode_lab]' AND no_reg = '$no_reg' AND no_faktur = '$no_faktur'");

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

          $query_tbs_data_periksa = $db->query("SELECT kode_jasa FROM tbs_aps_penjualan WHERE kode_jasa = '$data_jasa[kode_lab]' AND no_reg = '$no_reg' AND no_faktur = '$no_faktur'");

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

 $query_tbs_data_periksa = $db->query("SELECT kode_jasa FROM tbs_aps_penjualan WHERE kode_jasa = '$data_jasa[kode_lab]' AND no_reg = '$no_reg' AND no_faktur = '$no_faktur'");

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
<!--AKHIR MODAL JASA LABORATORIUM-->


<!--Mulai Padding layar-->
<div style="padding-left: 5%; padding-right: 5%">
  <!--Judul-->
    <h3><b>EDIT PENJUALAN APS</b></h3>
    <!--Garis-->
    <hr>


<!--Mulai Form and Proses-->
<form role="form" >
  <!--Mulai Row Pertama-->
    <div class="row">

        <!--Mulai Col SM Awal-->
        <div class="col-sm-8">

          <div class="col-xs-2">
            <label> No. RM | Pasien </label><br>
            <input style="height:20px" type="text" class="form-control"  id="no_rm_tampil" name="no_rm_tampil"  value="<?php echo $no_rm; ?>(<?php echo $nama_pasien; ?>)" readonly="" >
            <!--HIDDEN RM DAN NAMA PASIEN-->
            <input type="hidden" class="form-control"  id="nama_pasien" name="nama_pasien" value="" readonly="" >
            <input type="hidden" class="form-control" value="<?php echo $no_rm; ?>" id="no_rm" name="no_rm" value="" readonly="" > 
          </div>

          <div class="col-xs-2">
            <label>No. REG </label>
            <input style="height:20px" type="text" value="<?php echo $no_reg ?>" class="form-control"  id="no_reg" name="no_reg" value="" readonly="">
          </div>

          <div class="col-xs-2">
            <label>No. Faktur </label>
            <input style="height:20px" type="text" value="<?php echo $no_faktur ?>" class="form-control"  id="no_faktur" name="no_faktur" value="" readonly="">
          </div>

          <div class="col-xs-2">
            <label>Kasir</label>
            <input style="height:20px;" type="text" class="form-control"  id="petugas_kasir" name="petugas_kasir" value="<?php echo $sales; ?>" readonly="">  
          </div>

          <div class="col-xs-2">
            <label> Tanggal</label>
            <input type="text" name="tanggal" id="tanggal"  value="<?php echo $tanggal; ?>" style="height:20px;font-size:15px" placeholder="TanggaL" class="form-control" autocomplete="off">
          </div>

           <div class="col-xs-2">
            <label> Dokter Pengirim </label><br>
            <select style="height: 35px;" name="dokter" id="dokter" class="form-control chosen" required="" >
            <option>Pilih Dokter</option>
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
        <br><br>

        <div class="form-group col-xs-2">
        <br>
          <label for="penjamin">Petugas Analis</label>
            <select style="height: 35px;" type="text" class="form-control chosen" id="analis" autocomplete="off">
            <option>Pilih Analis</option>
            <?php
            $query_analis = $db->query("SELECT nama,id FROM user WHERE tipe = '6' ");
            while ( $data_analis = mysqli_fetch_array($query_analis)) {
              echo "<option value='".$data_analis['id'] ."'>
              ".$data_analis['nama'] ."</option>";
              }
            ?>
            </select>
        </div>


        <!--Mulai Input Hidden-->
        <input style="height: 20px;" value="<?php echo $jenis_penjualan ?>" type="hidden" class="form-control disable1" readonly="" id="jenis_penjualan" name="jenis_penjualan">

        <input style="height: 20px;" value="<?php echo $jenis_kelamin ?>" type="hidden" class="form-control disable1" readonly="" id="jenis_kelamin" name="jenis_kelamin">

        <input style="height: 20px;" type="hidden" class="form-control disable1" readonly="" id="kolom_cek_harga" name="kolom_cek_harga">
        <!--Akhir Input Hidden-->

                    <!--(MULAI TOMBOL DAN TABLE TBS APS PENJUALAN)-->
                        <!--Mulai Col SM Kedua-->
                        <div class="col-sm-8">

                            <button type="button" id="cari_jasa_laboratorium" class="btn btn-info " data-toggle="modal" data-target="#modal_lab"><i class='fa fa-search'></i> Cari Jasa (F1) </button> 

                            <button type="button" style="display:none" class="btn btn-default" id="btnRefreshsubtotal"> <i class='fa fa-refresh'></i> Refresh Subtotal</button>

                        <!--Akhir Col SM Kedua-->
                        </div>
                        <br><br>

                        <!--Mulai Col SM Ketiga-->
                        <div class="col-sm-12">
                            <span id="span_tbs_aps">            
                              <div class="table-responsive">
                                <table id="table_aps" class="table table-bordered table-sm">
                                <thead> <!-- untuk memberikan nama pada kolom tabel -->
                                                          
                                  <th style='background-color: #4CAF50; color: white'> Kode </th>
                                  <th style='background-color: #4CAF50; color: white'> Nama </th>
                                  <th style='background-color: #4CAF50; color: white'> Harga</th>
                                  <th style='background-color: #4CAF50; color: white'> Komisi</th>
                                  <th style='background-color: #4CAF50; color: white'> Dokter</th>
                                  <th style='background-color: #4CAF50; color: white'> Analis</th>
                                  <!--<th style='background-color: #4CAF50; color: white'> Tanggal</th>
                                  <th style='background-color: #4CAF50; color: white'> Jam</th>-->
                                  <th style='background-color: #4CAF50; color: white'> Hapus </th>
                                                      
                                </thead> <!-- tag penutup tabel -->
                                <tbody class="tbody">
                                  
                                </tbody>
                                </table>
                              </div>
                            </span>  
                        <!--Akhir Col SM Ketiga-->
                        </div>
                    <!--(MULAI TOMBOL DAN TABLE TBS APS PENJUALAN)-->

        <!--Mulai Col SM Awal-->  
        </div>


        <!--Mulai Col 2 SM Awal (untuk nilai Penjualan)-->
        <div class="col-sm-4">
            <!--Card Block Data Penjualan-->
            <div class="card card-block">
              <!--Awal Row 1 Dari Nilai Penjualan-->
              <div class="row">

                  <div class="col-xs-6">
                   
                      <label style="font-size:15px"> <b> Subtotal </b></label><br>
                      <input style="height:15px;font-size:15px" type="text" name="subtotal" id="subtotal" class="form-control" placeholder="Total" readonly="" >
                   
                  </div>

                  <div class="col-xs-6">
                      <label>Biaya Admin </label><br>
                      <select class="form-control chosen" id="biaya_admin_select" name="biaya_admin_select" >
                      <option value="0" selected=""> Silahkan Pilih </option>
                        <?php 
                        $get_biaya_admin = $db->query("SELECT persentase, nama FROM biaya_admin");
                        while ( $take_admin = mysqli_fetch_array($get_biaya_admin))
                        {
                        echo "<option value='".$take_admin['persentase']."'>".$take_admin['nama']." ".$take_admin['persentase']."%</option>";
                        }
                        ?>
                      </select>
                  </div>

              <!--Akhir Row 1 Dari Nilai Penjualan-->
              </div>


              <!--Awal Row 2 Dari Nilai Penjualan-->
              <div class="row">
                    <div class="col-xs-6">          
                        <label>Biaya Admin (Rp)</label>
                        <input type="text" name="biaya_admin_rupiah" style="height:15px;font-size:15px" id="biaya_adm" class="form-control" placeholder="Biaya Admin Rp" value="<?php echo $biaya_admin ?>" autocomplete="off" onkeydown="return numbersonly(this, event);" onkeyup="javascript:tandaPemisahTitik(this);">

                      <!--Biaya Admin Sebanarnya-->
                      <input type="hidden" name="biaya_admin_sebenarnya"  id="biaya_admin_sebenarnya" value="<?php echo $biaya_admin; ?>" class="form-control" autocomplete="off" onkeydown="return numbersonly(this, event);" onkeyup="javascript:tandaPemisahTitik(this);">
                    </div>

                    <div class="col-xs-6">
                        <label>Biaya Admin (%)</label>
                        <input type="text" name="biaya_admin_persen" style="height:15px;font-size:15px" id="biaya_admin_persen" class="form-control" placeholder="Biaya Admin %" autocomplete="off" >
                    </div>
              <!--Akhir Row 2 Dari Nilai Penjualan-->
              </div>

              <!--Awal Row 3 Dari Nilai Penjualan-->
              <div class="row">
                    <?php
                        $ambil_diskon_tax = $db->query("SELECT diskon_nominal, diskon_persen FROM setting_diskon_tax");
                        $data_diskon = mysqli_fetch_array($ambil_diskon_tax);
                    ?>

                  <div class="col-xs-6">
                      <label> Diskon ( Rp )</label><br>
                      <input type="text" name="potongan" style="height:15px;font-size:15px" id="diskon_rupiah" value="<?php echo $diskon; ?>" class="form-control" placeholder="Diskon Rp" autocomplete="off"  onkeydown="return numbersonly(this, event);" onkeyup="javascript:tandaPemisahTitik(this);">

                      <!--Diskon Sebanarnya Rupiah-->
                      <input type="hidden" name="diskon_sebenarnya"  id="diskon_sebenarnya" value="<?php echo $diskon; ?>" class="form-control" autocomplete="off" onkeydown="return numbersonly(this, event);" onkeyup="javascript:tandaPemisahTitik(this);">
                  </div>


                  <div class="col-xs-6">
         
                        <label> Diskon ( % )</label><br>
                        <input type="text" name="potongan_persen" style="height:15px;font-size:15px" id="diskon_persen" class="form-control" placeholder="Diskon %" autocomplete="off" onkeydown="return numbersonly(this, event);" >
                  </div>

              <!--Akhir Row 3 Dari Nilai Penjualan-->
              </div>


              <!--Awal Row 4 Dari Nilai Penjualan-->
              <div class="row">
                    <div class="col-xs-6">
                        <label> Tanggal Jatuh Tempo</label>
                        <input type="text" name="tanggal_jt" id="tanggal_jt"  value="" style="height:15px;font-size:15px" placeholder="Tanggal JT" class="form-control" autocomplete="off">
                    </div>


                    <div class="col-xs-6">
                        <label style="font-size:15px"> <b> Cara Bayar (F4) </b> </label><br>
                            <select type="text" name="cara_bayar" id="cara_bayar" class="form-control chosen"  style="font-size: 15px" >
                            <option value=""> Silahkan Pilih </option>
                            <?php
                                $query_data_kas = $db->query("SELECT nama_daftar_akun, kode_daftar_akun FROM daftar_akun WHERE tipe_akun = 'Kas & Bank'");
                                while($data_kas = mysqli_fetch_array($query_data_kas)){

                                    if($cara_bayar == $data_kas['kode_daftar_akun']){

                                    echo "<option selected value='".$data_kas['kode_daftar_akun']."'>".$data_kas['nama_daftar_akun'] ."</option>";
                                    }
                                    else{
                                    echo "<option  value='".$data_kas['kode_daftar_akun']."'>".$data_kas['nama_daftar_akun'] ."</option>";
                                    }
                                }
                                ?>
                            </select>
                    </div>
              <!--Akhir Row 4 Dari Nilai Penjualan-->
              </div>

              <!--Awal Row 5 Dari Nilai Penjualan-->
              <div class="row">
                      <div class="col-xs-6">
                        <label style="font-size:15px"> <b> Total Akhir </b></label><br>
                        <b><input type="text" name="total" id="total" class="form-control" style="height: 25px; width:90%; font-size:20px;" placeholder="Total" readonly="" ></b>
                      </div>

                      <div class="col-xs-6">
                        <label style="font-size:15px">  <b> Pembayaran (F7)</b> </label><br>
                        <b><input type="text" name="pembayaran" id="pembayaran_penjualan" style="height: 20px; width:90%; font-size:20px;" autocomplete="off" value="<?php echo $bayar_sebelumnya ?>" class="form-control"   style="font-size: 20px" onkeydown="return numbersonly(this, event);" onkeyup="javascript:tandaPemisahTitik(this);"></b>
                      </div>

              <!--Akhir Row 5 Dari Nilai Penjualan-->
              </div>


              <!--Awal Row 6 Dari Nilai Penjualan-->
              <div class="row">
                <div class="col-xs-6">
                    <label> Kembalian </label><br>
                    <b><input type="text" name="sisa_pembayaran"  id="sisa_pembayaran_penjualan"  style="height:15px;font-size:15px" class="form-control"  readonly=""></b>
                </div>
                <div class="col-xs-6">
                    <label> Kredit </label><br>
                    <b><input type="text" name="kredit" id="kredit" class="form-control"  style="height:15px;font-size:15px"  readonly="" ></b>
                </div>
              <!--Akhir Row 6 Dari Nilai Penjualan-->
              </div>

              <!--Awal Row 7 Dari Nilai Penjualan-->
              <div class="row">
                <div class="col-xs-12">
                    <label> Keterangan </label><br>
                    <textarea style="height:40px;font-size:15px" type="text" name="keterangan" id="keterangan" class="form-control"> 
                    </textarea>
                </div>
              <!--Akhir Row 7 Dari Nilai Penjualan-->
              </div>

            <!--Akhir Card Block Data Penjualan-->
            </div>

        <!--ALERT BERHASIL-->
        <div class="alert alert-success" id="alert_berhasil" style="display:none">
          <strong>Sukses!</strong> Pembayaran Berhasil !!
        </div>

    <!-- BUTTON -->
    <?php if ($otoritas_tombol['tombol_bayar'] > 0):?>              
        <button style="display:none" type="submit" id="penjualan" class="btn btn-info" style="font-size:15px;">Bayar (F8)</button>
        
        <button type="submit" id="transaksi_baru" style="display: none" class="btn btn-info" style="font-size:15px;"> Transaksi Baru (Ctrl + M)</button>

        <a class="btn btn-info" href="pasien_sudah_masuk.php" id="transaksi_baru" style="display: none">  Transaksi Baru (Ctrl + M)</a>
    <?php endif;?>

    <?php if ($otoritas_tombol['tombol_bayar'] > 0):?>
        <button style="display:none" type="submit" id="cetak_langsung" target="blank" class="btn btn-success" style="font-size:15px"> Bayar / Cetak (Ctrl + K) </button>
    <?php endif;?>

    <?php if ($otoritas_tombol['tombol_piutang'] > 0):?>  
        <button style="display:none" type="submit" id="piutang" class="btn btn-warning" style="font-size:15px">Piutang (F9)</button>
    <?php endif;?>

        <a href='cetak_penjualan_piutang_aps.php' id="cetak_piutang" style="display: none;" class="btn btn-success" target="blank">Cetak Piutang  </a>

        <a href='cetak_penjualan_tunai_aps.php' id="cetak_tunai" style="display: none;" class="btn btn-primary" target="blank"> Cetak Tunai  </a>

        <a href='cetak_penjualan_tunai_besar_aps.php' id="cetak_tunai_besar" style="display: none;" class="btn btn-warning" target="blank"> Cetak Tunai  Besar </a>

    <?php if ($otoritas_tombol['tombol_batal'] > 0):?>
        <button style="display:none" type="submit" id="batal_penjualan" class="btn btn-danger" style="font-size:15px">  Batal (Ctrl + B)</button>
    <?php endif;?>
        
    <!-- BUTTON -->

        <!--Mulai Col 2 SM Awal (untuk nilai Penjualan)-->
        </div>
    <!--Akhir Row Pertama-->
    </div>
        
<!--Akhir From-->
</form>


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


<!--End Padding-->
</div>

<!-- js untuk tombol shortcut -->
<script src="shortcut.js"></script>
<!-- js untuk tombol shortcut -->


<script>
  $(function() {
    //DatePicker Tanggal
    $( "#tanggal" ).datepicker({dateFormat: "yy-mm-dd"});
    $( "#tanggal_jt" ).datepicker({dateFormat: "yy-mm-dd"});
  });
</script>

<script type="text/javascript">
$(document).ready(function(){
    // DATATABE AJAX TABLE_APS
      $('#table_aps').DataTable().destroy();
            var dataTable = $('#table_aps').DataTable( {
            "processing": true,
            "serverSide": true,
            "info":     true,
            "language": { "emptyTable":     "My Custom Message On Empty Table" },
            "ajax":{
              url :"datatable_tbs_edit_aps.php", // json datasource
               "data": function ( d ) {
                  d.no_reg = $("#no_reg").val();
                  d.no_faktur = $("#no_faktur").val();
                  // d.custom = $('#myInput').val();
                  // etc
              },
                  type: "post",  // method  , by default get
              error: function(){  // error handling
                $(".tbody").html("");
                $("#table_aps").append('<tbody class="tbody"><tr><th colspan="3"></th></tr></tbody>');
                $("#tableuser_processing").css("display","none");
                
              }
            }   

      });
    //AKHIR DATATABLE AJAX
    $("#btnRefreshsubtotal").show();
    $("#batal_penjualan").show();


//TAMPILAN TOMBOL BAYAR DAN PIUTANG
//TAMPILAN TOMBOL BAYAR DAN PIUTANG


    //START SUBTOTAL DAN TOTAL
var no_reg = $("#no_reg").val();
var no_faktur = $("#no_faktur").val();
var diskon_persen = bersihPemisah(bersihPemisah(bersihPemisah(bersihPemisah($("#diskon_persen").val()))));
var diskon_rupiah = bersihPemisah(bersihPemisah(bersihPemisah(bersihPemisah($("#diskon_rupiah").val()))));

$.post("cek_subtotal_edit_aps.php",{no_reg:no_reg,no_faktur:no_faktur},function(data){
    data = data.replace(/\s+/g, '');
    if (data == ""){
        data = 0;
    }

    var sum = parseInt(data,10);
    //Input Subtotal
    $("#subtotal").val(tandaPemisahTitik(sum))

    //Mulai Proses Cek Biaya Admin
    var biaya_adm = bersihPemisah(bersihPemisah(bersihPemisah(bersihPemisah($("#biaya_adm").val()))));
      if (biaya_adm == '') {
        biaya_adm = 0;
      }

    var biaya_admin_sebenarnya = bersihPemisah(bersihPemisah(bersihPemisah(bersihPemisah($("#biaya_admin_sebenarnya").val()))));
      if (biaya_admin_sebenarnya == '') {
        biaya_admin_sebenarnya = 0;
      }

    var subtotal = bersihPemisah(bersihPemisah(bersihPemisah(bersihPemisah($("#subtotal").val()))));
      if (subtotal == '') {
        subtotal = 0;
      }

    var potongan = bersihPemisah(bersihPemisah(bersihPemisah(bersihPemisah($("#diskon_rupiah").val()))));
      if (potongan == '') {
        potongan = 0;
      }

    var pembayaran = bersihPemisah(bersihPemisah(bersihPemisah(bersihPemisah($("#pembayaran_penjualan").val()))));
      if (pembayaran == '') {
        pembayaran = 0;
      }  

      var t_total = parseInt(subtotal,10) - parseInt(potongan,10);
      var biaya_admin_persen = parseInt(biaya_adm,10) / parseInt(subtotal,10) * 100;

      var total_akhir = parseInt(t_total,10) + parseInt(Math.round(biaya_adm,10));


      var adm_persen = parseInt(biaya_admin_sebenarnya,10) / parseInt(subtotal,10) * 100;

      $("#total").val(tandaPemisahTitik(total_akhir));
      $("#biaya_admin_persen").val(Math.round(biaya_admin_persen));

        if (biaya_admin_persen > 100) {
            
            var total_akhir = parseInt(subtotal,10) - parseInt(potongan,10);
            alert ("Biaya Amin %, Tidak Boleh Lebih Dari 100%");
            $("#biaya_admin_persen").val(adm_persen);
            $("#biaya_admin_select").val('0');            
            $("#biaya_admin_select").trigger('chosen:updated');
            $("#biaya_adm").val(biaya_admin_sebenarnya);
            $("#total").val(tandaPemisahTitik(total_akhir));
        }
        else{
        }
    //Akhir Proses Cek Biaya Admin

        //Start Proses Diskon Rupiah
          var diskon_rupiah =  bersihPemisah(bersihPemisah(bersihPemisah(bersihPemisah( $("#diskon_rupiah").val()))));
          var biaya_adm = bersihPemisah(bersihPemisah(bersihPemisah(bersihPemisah($("#biaya_adm").val()))));
          if (biaya_adm == ''){
              biaya_adm = 0;
          }
            
          var pembayaran = bersihPemisah(bersihPemisah(bersihPemisah(bersihPemisah($("#pembayaran_penjualan").val()))));
          if (pembayaran == '') {
              pembayaran = 0;
          }
          var total = bersihPemisah(bersihPemisah(bersihPemisah(bersihPemisah( $("#total").val() ))));
          var subtotal = bersihPemisah(bersihPemisah(bersihPemisah(bersihPemisah($("#subtotal").val()))));
          var diskon_persen = ((diskon_rupiah / subtotal) * 100);
          var sisa_potongan = subtotal - Math.round(diskon_rupiah);
          var hasil_akhir = parseInt(sisa_potongan, 10) + parseInt(biaya_adm,10);

        if (diskon_persen > 100) {
            var sisa = pembayaran - Math.round(hasil_akhir);
            var sisa_kredit = Math.round(hasil_akhir) - pembayaran; 
                
            if (sisa < 0 ){
              $("#kredit").val(tandaPemisahTitik(sisa_kredit));
              $("#sisa_pembayaran_penjualan").val('0');
              $("#tanggal_jt").attr("disabled", false);
                      
            }
            else{
              $("#sisa_pembayaran_penjualan").val(tandaPemisahTitik(sisa));
              $("#kredit").val('0');
              $("#tanggal_jt").attr("disabled", true);
                      
            } 
                alert ("Potongan %, Tidak Boleh Lebih Dari 100%");
                    $("#diskon_persen").val('');
                    $("#diskon_rupiah").val('');
                    $("#total").val(tandaPemisahTitik(hasil_akhir));
                    
        }
        else{
                var sisa = pembayaran - Math.round(hasil_akhir);
                var sisa_kredit = Math.round(hasil_akhir) - pembayaran; 
                
                if (sisa < 0 ){
                    $("#kredit").val( tandaPemisahTitik(sisa_kredit));
                    $("#sisa_pembayaran_penjualan").val('0');
                    $("#tanggal_jt").attr("disabled", false);
                    $("#penjualan").hide();
                    $("#cetak_langsung").hide();
                    $("#piutang").show();       
                }
                else{
                    $("#sisa_pembayaran_penjualan").val(tandaPemisahTitik(sisa));
                    $("#kredit").val('0');
                    $("#tanggal_jt").attr("disabled", true);
                    $("#penjualan").show();
                    $("#cetak_langsung").show();
                    $("#piutang").hide();
                      
                }
            
            $("#total").val(tandaPemisahTitik(Math.round(hasil_akhir)));
            $("#diskon_persen").val(Math.round(diskon_persen));
        }//Akhir Proses Diskon Rupiah

      });
      //CEK SUBTOTAL + TOTAL
});
</script>

<!--MULAI REFRESH SUBTOTAL -->
<script type="text/javascript">
$(document).ready(function(){
    $(document).on('click','#btnRefreshsubtotal',function(e){
        var no_faktur = $("#no_faktur").val();
        var no_reg = $("#no_reg").val();
        if (no_faktur == '') {
            alert("Data Yang di Edit Tidak Ada!");
        }
        else{

          $.post("refresh_subtotal_edit_aps.php",{no_reg:no_reg,no_faktur:no_faktur},function(data){
          if (data == '') {
            data = 0;
          }
          var hasil_data = data;
          var biaya_admin = bersihPemisah(bersihPemisah(bersihPemisah(bersihPemisah($("#biaya_adm").val()))));
          if(biaya_admin == ''){
             biaya_admin = 0
          }

          var diskon = bersihPemisah(bersihPemisah(bersihPemisah(bersihPemisah($("#diskon_rupiah").val()))));
          if(diskon == ''){
             diskon = 0
          }
          var hasilnya = parseInt(hasil_data,10) + parseInt(Math.round(biaya_admin),10) - parseInt(diskon,10);

          $("#total").val(tandaPemisahTitik(hasilnya));
          $("#subtotal").val(tandaPemisahTitik(hasil_data));

          });
        }
    });
});
</script>
<!--AKHIR REFRESH SUBTOTAL -->


<!-- / DATATABLE DRAW -->
<script type="text/javascript">
    $(document).on('click','#btnRefreshPasien',function(e){

       var table_pasien = $('#tabel_cari_pasien').DataTable();
       table_pasien.draw();

    }); 
</script>
<!-- / DATATABLE DRAW -->

<!-- PENJUALAN BAYAR -->
<script type="text/javascript">
    $(document).on('click', '#penjualan', function(){
      var id_user = '<?php echo $id_user; ?>';
      var no_faktur = $("#no_faktur").val();
      var no_reg = $("#no_reg").val();
      var no_rm = $("#no_rm").val();
      var biaya_adm = bersihPemisah(bersihPemisah(bersihPemisah(bersihPemisah($("#biaya_adm").val()))));
      if(biaya_adm == ''){
        biaya_adm = 0;
      }
      var diskon_rupiah = bersihPemisah(bersihPemisah(bersihPemisah(bersihPemisah($("#diskon_rupiah").val()))));
      if(diskon_rupiah == ''){
        diskon_rupiah = 0;
      }
      var cara_bayar = $("#cara_bayar").val();
      var subtotal = bersihPemisah(bersihPemisah(bersihPemisah(bersihPemisah( $("#subtotal").val()))));
      var total = bersihPemisah(bersihPemisah(bersihPemisah(bersihPemisah( $("#total").val()))));
      var pembayaran_penjualan = bersihPemisah(bersihPemisah(bersihPemisah(bersihPemisah( $("#pembayaran_penjualan").val()))));
      var sisa_pembayaran = bersihPemisah(bersihPemisah(bersihPemisah(bersihPemisah( $("#sisa_pembayaran_penjualan").val() ))));
      var keterangan = $("#keterangan").val();
      var tanggal = $("#tanggal").val();
      var tanggal_jt = $("#tanggal_jt").val();
      var nama_pasien = $("#nama_pasien").val();
      var petugas_kasir = $("#petugas_kasir").val();

      if (no_faktur == '') {
        alert ('Maaf Data Penjualan Tidak Ada !');
      }
      else{

        var pesan_alert = confirm("Anda Yakin Melakukan Penjualan Lunas? ");
        if (pesan_alert == true) {

        $.post("cek_subtotal_edit_penjualan_aps.php",{no_faktur:no_faktur,total:total,no_reg:no_reg,diskon_rupiah:diskon_rupiah,biaya_adm:biaya_adm},function(data) {

//LOGIKA CEK SUBTOTAL ANTARA TBS DAN KOLOM SUBTOTAL
                if (data == 1) {

                    $.post("proses_edit_penjualan_aps.php",{no_faktur:no_faktur,id_user:id_user,
                        no_reg:no_reg,no_rm:no_rm,biaya_adm:biaya_adm,diskon_rupiah:diskon_rupiah,
                        cara_bayar:cara_bayar,subtotal:subtotal,total:total,
                        pembayaran_penjualan:pembayaran_penjualan,sisa_pembayaran:sisa_pembayaran,
                        tanggal_jt:tanggal_jt,keterangan:keterangan,petugas_kasir:petugas_kasir,
                        nama_pasien:nama_pasien,tanggal:tanggal},function(info){
                        // Start Cetak
                        $("#cetak_tunai").attr('href', 'cetak_penjualan_aps_tunai.php?no_reg='+no_reg+'&sisa='+sisa_pembayaran+'&tunai='+pembayaran_penjualan+'&total='+total+'&biaya_admin='+biaya_adm+'&diskon='+diskon_rupiah+'&no_rm='+no_rm+'&nama_pasien='+nama_pasien+'');

                        $("#cetak_tunai_besar").attr('href', 'cetak_besar_penjualan_aps_tunai.php?no_reg='+no_reg+'&sisa='+sisa_pembayaran+'&tunai='+pembayaran_penjualan+'&total='+total+'&biaya_admin='+biaya_adm+'&diskon='+diskon_rupiah+'&no_rm='+no_rm+'&nama_pasien='+nama_pasien+'&keterangan='+keterangan+'&cara_bayar='+cara_bayar+'');

                        $("#cetak_tunai").show();
                        $("#cetak_tunai_besar").show();
                        // Akhir Cetak

                        $("#penjualan").hide();
                        $("#simpan_sementara").hide();
                        $("#cetak_langsung").hide();
                        $("#batal_penjualan").hide(); 
                        $("#piutang").hide();
                        $("#span_tbs_aps").hide();
                        $("#transaksi_baru").show();
                        $("#alert_berhasil").show();

                    });

                }
                else{
                    alert("Maaf Subtotal Penjualan Tidak Sesuai, Silakan Tunggu Sebentar! ");       
                    window.location.href="form_edit_penjualan_aps.php";
                }
// END LOGIKA CEK SUBTOTAL ANTARA TBS DAN KOLOM SUBTOTAL

            });
        }
        else{

        }

      }
         $("form").submit(function(){
            return false;
         });

    });

</script>
<!-- / PENJUALAN BAYAR-->

<!-- PENJUALAN PIUTANG -->
<script type="text/javascript">
    $(document).on('click', '#piutang', function(){
      var id_user = '<?php echo $id_user; ?>';
      var no_faktur = $("#no_faktur").val();
      var no_reg = $("#no_reg").val();
      var no_rm = $("#no_rm").val();
      var biaya_adm = bersihPemisah(bersihPemisah(bersihPemisah(bersihPemisah($("#biaya_adm").val()))));
      if(biaya_adm == ''){
        biaya_adm = 0;
      }
      var diskon_rupiah = bersihPemisah(bersihPemisah(bersihPemisah(bersihPemisah($("#diskon_rupiah").val()))));
      if(diskon_rupiah == ''){
        diskon_rupiah = 0;
      }
      var cara_bayar = $("#cara_bayar").val();
      var subtotal = bersihPemisah(bersihPemisah(bersihPemisah(bersihPemisah( $("#subtotal").val()))));
      var total = bersihPemisah(bersihPemisah(bersihPemisah(bersihPemisah( $("#total").val()))));
      var pembayaran_penjualan = bersihPemisah(bersihPemisah(bersihPemisah(bersihPemisah( $("#pembayaran_penjualan").val()))));
      var sisa_pembayaran = bersihPemisah(bersihPemisah(bersihPemisah(bersihPemisah( $("#sisa_pembayaran_penjualan").val() ))));
      var keterangan = $("#keterangan").val();
      var tanggal = $("#tanggal").val();
      var tanggal_jt = $("#tanggal_jt").val();
      var nama_pasien = $("#nama_pasien").val();
      var petugas_kasir = $("#petugas_kasir").val();

      if (no_faktur == '') {
        alert ('Maaf Data Penjualan Tidak Ada !');
      }
      else{

        var pesan_alert = confirm("Anda Yakin Melakukan Transaksi Piutang ? ");
        if (pesan_alert == true) {

            $.post("cek_subtotal_edit_penjualan_aps.php",{total:total,no_reg:no_reg,diskon_rupiah:diskon_rupiah,biaya_adm:biaya_adm},function(data) {

//LOGIKA CEK SUBTOTAL ANTARA TBS DAN KOLOM SUBTOTAL
                if (data == 1) {

                    $.post("proses_edit_penjualan_aps.php",{no_faktur:no_faktur,id_user:id_user,no_reg:no_reg,no_rm:no_rm,
                        biaya_adm:biaya_adm,diskon_rupiah:diskon_rupiah,cara_bayar:cara_bayar,
                        subtotal:subtotal,total:total,pembayaran_penjualan:pembayaran_penjualan,
                        sisa_pembayaran:sisa_pembayaran,tanggal_jt:tanggal_jt,keterangan:keterangan,
                        petugas_kasir:petugas_kasir,nama_pasien:nama_pasien,tangal:tanggal},function(info){

                        var no_faktur = info;
                        $("#cetak_piutang").attr('href', 'cetak_penjualan_aps_piutang.php?no_faktur='+no_faktur+'');
                        $("#cetak_piutang").show();

                        $("#penjualan").hide();
                        $("#simpan_sementara").hide();
                        $("#cetak_langsung").hide();
                        $("#batal_penjualan").hide(); 
                        $("#piutang").hide();
                        $("#span_tbs_aps").hide();
                        $("#transaksi_baru").show();
                        $("#alert_berhasil").show();

                    });

                }
                else{
                    alert("Maaf Subtotal Penjualan Tidak Sesuai, Silakan Tunggu Sebentar! ");       
                    window.location.href="form_edit_penjualan_aps.php";
                }
// END LOGIKA CEK SUBTOTAL ANTARA TBS DAN KOLOM SUBTOTAL

            });
        }
        else{

        }

      }
         $("form").submit(function(){
            return false;
         });

    });

</script>
<!-- / PENJUALAN PIUTANG-->


<!-- PENJUALAN BAYAR + CETAK -->
<script type="text/javascript">
    $(document).on('click', '#cetak_langsung', function(){
      var id_user = '<?php echo $id_user; ?>';
      var no_faktur = $("#no_faktur").val();
      var no_reg = $("#no_reg").val();
      var no_rm = $("#no_rm").val();
      var biaya_adm = bersihPemisah(bersihPemisah(bersihPemisah(bersihPemisah($("#biaya_adm").val()))));
      if(biaya_adm == ''){
        biaya_adm = 0;
      }
      var diskon_rupiah = bersihPemisah(bersihPemisah(bersihPemisah(bersihPemisah($("#diskon_rupiah").val()))));
      if(diskon_rupiah == ''){
        diskon_rupiah = 0;
      }
      var cara_bayar = $("#cara_bayar").val();
      var subtotal = bersihPemisah(bersihPemisah(bersihPemisah(bersihPemisah( $("#subtotal").val()))));
      var total = bersihPemisah(bersihPemisah(bersihPemisah(bersihPemisah( $("#total").val()))));
      var pembayaran_penjualan = bersihPemisah(bersihPemisah(bersihPemisah(bersihPemisah( $("#pembayaran_penjualan").val()))));
      var sisa_pembayaran = bersihPemisah(bersihPemisah(bersihPemisah(bersihPemisah( $("#sisa_pembayaran_penjualan").val() ))));
      var keterangan = $("#keterangan").val();
      var tanggal = $("#tanggal").val();
      var tanggal_jt = $("#tanggal_jt").val();
      var nama_pasien = $("#nama_pasien").val();
      var petugas_kasir = $("#petugas_kasir").val();

      if (no_faktur == '') {
        alert ('Maaf Data Penjualan Tidak Ada !');
      }
      else{

        var pesan_alert = confirm("Anda Yakin Melakukan Transaksi Piutang ? ");
        if (pesan_alert == true) {

            $.post("cek_subtotal_edit_penjualan_aps.php",{total:total,no_reg:no_reg,diskon_rupiah:diskon_rupiah,biaya_adm:biaya_adm},function(data) {

//LOGIKA CEK SUBTOTAL ANTARA TBS DAN KOLOM SUBTOTAL
                if (data == 1) {

                    $.post("proses_edit_penjualan_aps.php",{no_faktur:no_faktur,id_user:id_user,no_reg:no_reg,no_rm:no_rm,
                        biaya_adm:biaya_adm,diskon_rupiah:diskon_rupiah,cara_bayar:cara_bayar,
                        subtotal:subtotal,total:total,pembayaran_penjualan:pembayaran_penjualan,
                        sisa_pembayaran:sisa_pembayaran,tanggal_jt:tanggal_jt,keterangan:keterangan,
                        petugas_kasir:petugas_kasir,nama_pasien:nama_pasien,tanggal:tanggal},function(info){

                        // Start Cetak
                        $("#cetak_tunai").attr('href', 'cetak_penjualan_aps_tunai.php?no_reg='+no_reg+'&sisa='+sisa_pembayaran+'&tunai='+pembayaran_penjualan+'&total='+total+'&biaya_admin='+biaya_adm+'&diskon='+diskon_rupiah+'&no_rm='+no_rm+'&nama_pasien='+nama_pasien+'');

                        $("#cetak_tunai_besar").attr('href', 'cetak_besar_penjualan_aps_tunai.php?no_reg='+no_reg+'&sisa='+sisa_pembayaran+'&tunai='+pembayaran_penjualan+'&total='+total+'&biaya_admin='+biaya_adm+'&diskon='+diskon_rupiah+'&no_rm='+no_rm+'&nama_pasien='+nama_pasien+'&keterangan='+keterangan+'&cara_bayar='+cara_bayar+'');
                        
                        var win = window.open('cetak_penjualan_aps_tunai.php?no_reg='+no_reg+'&sisa='+sisa_pembayaran+'&tunai='+pembayaran_penjualan+'&total='+total+'&biaya_admin='+biaya_adm+'&diskon='+diskon_rupiah+'&no_rm='+no_rm+'&nama_pasien='+nama_pasien+'');
                            if (win) {    
                              win.focus(); 
                            } 
                            else {    
                              alert('Mohon Izinkan PopUps Pada Website Ini !'); 
                            }

                        $("#cetak_tunai").show();
                        $("#cetak_tunai_besar").show();
                        // Akhir Cetak

                        $("#penjualan").hide();
                        $("#simpan_sementara").hide();
                        $("#cetak_langsung").hide();
                        $("#batal_penjualan").hide(); 
                        $("#piutang").hide();
                        $("#span_tbs_aps").hide();
                        $("#transaksi_baru").show();
                        $("#alert_berhasil").show();

                    });

                }
                else{
                    alert("Maaf Subtotal Penjualan Tidak Sesuai, Silakan Tunggu Sebentar! ");       
                    window.location.href="form_edit_penjualan_aps.php";
                }
// END LOGIKA CEK SUBTOTAL ANTARA TBS DAN KOLOM SUBTOTAL

            });
        }
        else{

        }

      }
         $("form").submit(function(){
            return false;
         });

    });

</script><!-- / PENJUALAN BAYAR + CETAK -->

<!--Mulai Script Proses Hapus TBS -->
<script type="text/javascript">
  $(document).on('click','.btn-hapus-tbs',function(e){

    var id = $(this).attr("data-id");
    var kode_jasa = $(this).attr("data-kode");
    var nama_jasa = $(this).attr("data-barang");
    var no_reg = $("#no_reg").val();
    var no_faktur = $("#no_faktur").val();

    var pesan_alert = confirm("Apakah Anda Yakin Ingin Menghapus "+nama_jasa+""+ "?");

    if (pesan_alert == true) {
      $(".tr-id-"+id+"").remove();

        $.post("hapus_tbs_edit_aps_penjualan.php",{no_faktur:no_faktur,kode_jasa:kode_jasa,no_reg:no_reg,id:id},function(data){

                // DATATABE AJAX TABLE_APS
                $('#table_aps').DataTable().destroy();
                        var dataTable = $('#table_aps').DataTable( {
                        "processing": true,
                        "serverSide": true,
                        "info":     false,
                        "language": { "emptyTable":     "My Custom Message On Empty Table" },
                        "ajax":{
                          url :"datatable_tbs_edit_aps.php", // json datasource
                           "data": function ( d ) {
                              d.no_reg = $("#no_reg").val();
                              d.no_faktur = $("#no_faktur").val();
                              // d.custom = $('#myInput').val();
                              // etc
                          },
                              type: "post",  // method  , by default get
                          error: function(){  // error handling
                            $(".tbody").html("");
                            $("#table_aps").append('<tbody class="tbody"><tr><th colspan="3"></th></tr></tbody>');
                            $("#tableuser_processing").css("display","none");
                            
                          }
                        }   

                });// DATATABE AJAX TABLE_APS

                $("#span_tbs_aps").show('fast');

        //TAMPILAN TOMBOL BAYAR DAN PIUTANG
        var pembayaran = bersihPemisah(bersihPemisah(bersihPemisah(bersihPemisah( $("#pembayaran_penjualan").val() ))));
        var total =  bersihPemisah(bersihPemisah(bersihPemisah(bersihPemisah($("#total").val()))));
        var sisa_kredit = parseInt(total, 10) - parseInt(pembayaran,10);
        var sisa = parseInt(pembayaran, 10) - parseInt(total,10);
        if (sisa < 0 ){
            $("#kredit").val( tandaPemisahTitik(sisa_kredit));
            $("#sisa_pembayaran_penjualan").val('0');
            $("#tanggal_jt").attr("disabled", false);

            $("#penjualan").hide();
            $("#cetak_langsung").hide();
            $("#piutang").show();
        }
        else{
            $("#sisa_pembayaran_penjualan").val(tandaPemisahTitik(sisa));
            $("#kredit").val('0');
            $("#tanggal_jt").attr("disabled", true);

            $("#penjualan").show();
            $("#cetak_langsung").show();
            $("#piutang").hide();
        } 
        //TAMPILAN TOMBOL BAYAR DAN PIUTANG

      //START SUBTOTAL DAN TOTAL
      var no_reg = $("#no_reg").val();
      var no_faktur = $("#no_faktur").val();
      var diskon_persen = bersihPemisah(bersihPemisah(bersihPemisah(bersihPemisah($("#diskon_persen").val()))));
      var diskon_rupiah = bersihPemisah(bersihPemisah(bersihPemisah(bersihPemisah($("#diskon_rupiah").val()))));

      $.post("cek_subtotal_edit_aps.php",{no_reg:no_reg,no_faktur:no_faktur},function(data){
      data = data.replace(/\s+/g, '');
      if (data == ""){
        data = 0;
      }

      var sum = parseInt(data,10);
      //Input Subtotal
      $("#subtotal").val(tandaPemisahTitik(sum))

      //Mulai Proses Cek Biaya Admin
      var biaya_adm = bersihPemisah(bersihPemisah(bersihPemisah(bersihPemisah($("#biaya_adm").val()))));
        if (biaya_adm == '') {
          biaya_adm = 0;
        }

      var biaya_admin_sebenarnya = bersihPemisah(bersihPemisah(bersihPemisah(bersihPemisah($("#biaya_admin_sebenarnya").val()))));
        if (biaya_admin_sebenarnya == '') {
          biaya_admin_sebenarnya = 0;
        }

      var subtotal = bersihPemisah(bersihPemisah(bersihPemisah(bersihPemisah($("#subtotal").val()))));
        if (subtotal == '') {
          subtotal = 0;
        }

      var potongan = bersihPemisah(bersihPemisah(bersihPemisah(bersihPemisah($("#diskon_rupiah").val()))));
        if (potongan == '') {
          potongan = 0;
        }

      var pembayaran = bersihPemisah(bersihPemisah(bersihPemisah(bersihPemisah($("#pembayaran_penjualan").val()))));
        if (pembayaran == '') {
          pembayaran = 0;
        }  

      var t_total = parseInt(subtotal,10) - parseInt(potongan,10);
      var biaya_admin_persen = parseInt(biaya_adm,10) / parseInt(subtotal,10) * 100;

      var total_akhir = parseInt(t_total,10) + parseInt(Math.round(biaya_adm,10));


      var adm_persen = parseInt(biaya_admin_sebenarnya,10) / parseInt(subtotal,10) * 100;

      $("#total").val(tandaPemisahTitik(total_akhir));
      $("#biaya_admin_persen").val(Math.round(biaya_admin_persen));

        if (biaya_admin_persen > 100) {
            
            var total_akhir = parseInt(subtotal,10) - parseInt(potongan,10);
            alert ("Biaya Amin %, Tidak Boleh Lebih Dari 100%");
            $("#biaya_admin_persen").val(adm_persen);
            $("#biaya_admin_select").val('0');            
            $("#biaya_admin_select").trigger('chosen:updated');
            $("#biaya_adm").val(biaya_admin_sebenarnya);
            $("#total").val(tandaPemisahTitik(total_akhir));
        }
        else{
        }
    //Akhir Proses Cek Biaya Admin

        //Start Proses Diskon Rupiah
          var diskon_rupiah =  bersihPemisah(bersihPemisah(bersihPemisah(bersihPemisah( $("#diskon_rupiah").val()))));
          var biaya_adm = bersihPemisah(bersihPemisah(bersihPemisah(bersihPemisah($("#biaya_adm").val()))));
          if (biaya_adm == ''){
              biaya_adm = 0;
          }
            
          var pembayaran = bersihPemisah(bersihPemisah(bersihPemisah(bersihPemisah($("#pembayaran_penjualan").val()))));
          if (pembayaran == '') {
              pembayaran = 0;
          }
          var total = bersihPemisah(bersihPemisah(bersihPemisah(bersihPemisah( $("#total").val() ))));
          var subtotal = bersihPemisah(bersihPemisah(bersihPemisah(bersihPemisah($("#subtotal").val()))));
          var diskon_persen = ((diskon_rupiah / subtotal) * 100);
          var sisa_potongan = subtotal - Math.round(diskon_rupiah);
          var hasil_akhir = parseInt(sisa_potongan, 10) + parseInt(biaya_adm,10);

        if (diskon_persen > 100) {
            var sisa = pembayaran - Math.round(hasil_akhir);
            var sisa_kredit = Math.round(hasil_akhir) - pembayaran; 
                
            if (sisa < 0 ){
              $("#kredit").val(tandaPemisahTitik(sisa_kredit));
              $("#sisa_pembayaran_penjualan").val('0');
              $("#tanggal_jt").attr("disabled", false);
                      
            }
            else{
              $("#sisa_pembayaran_penjualan").val(tandaPemisahTitik(sisa));
              $("#kredit").val('0');
              $("#tanggal_jt").attr("disabled", true);
                      
            } 
                alert ("Potongan %, Tidak Boleh Lebih Dari 100%");
                    $("#diskon_persen").val('');
                    $("#diskon_rupiah").val('');
                    $("#total").val(tandaPemisahTitik(hasil_akhir));
                    
        }
        else{
                var sisa = pembayaran - Math.round(hasil_akhir);
                var sisa_kredit = Math.round(hasil_akhir) - pembayaran; 
                
                if (sisa < 0 ){
                    $("#kredit").val( tandaPemisahTitik(sisa_kredit));
                    $("#sisa_pembayaran_penjualan").val('0');
                    $("#tanggal_jt").attr("disabled", false);       
                }
                else{
                    $("#sisa_pembayaran_penjualan").val(tandaPemisahTitik(sisa));
                    $("#kredit").val('0');
                    $("#tanggal_jt").attr("disabled", true);
                      
                }
            
            $("#total").val(tandaPemisahTitik(Math.round(hasil_akhir)));
            $("#diskon_persen").val(Math.round(diskon_persen));
        }//Akhir Proses Diskon Rupiah

      });
      //CEK SUBTOTAL + TOTAL

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


<script type="text/javascript">
$(document).ready(function(){
  //Mulai Hitung Biaya Admin Select
  $("#biaya_admin_select").change(function(){
  
    var biaya_admin = $("#biaya_admin_select").val();  
    var diskon = bersihPemisah(bersihPemisah(bersihPemisah(bersihPemisah($("#diskon_rupiah").val()))));
    var subtotal = bersihPemisah(bersihPemisah(bersihPemisah(bersihPemisah($("#subtotal").val()))));
    var total = bersihPemisah(bersihPemisah(bersihPemisah(bersihPemisah($("#total").val()))));
    
    if(diskon == ''){
      diskon = 0
    }

    var biaya_admin_persen = biaya_admin;

    if (biaya_admin == 0) {

      var hasilnya = parseInt(subtotal,10) - parseInt(diskon,10);
      $("#total").val(tandaPemisahTitik(hasilnya));
      $("#biaya_adm").val(0);
      $("#biaya_admin_persen").val(biaya_admin_persen);

    }
    else if (biaya_admin > 0) {

        var hitung_biaya = parseInt(subtotal,10) * parseInt(biaya_admin_persen,10) / 100;
        if (subtotal == "" || subtotal == 0) {
            hitung_biaya = 0;
        }

        $("#biaya_adm").val(tandaPemisahTitik(Math.round(hitung_biaya)));
        var biaya_admin = bersihPemisah(bersihPemisah(bersihPemisah(bersihPemisah($("#biaya_adm").val()))));
        var hasilnya = parseInt(subtotal,10) + parseInt(biaya_admin,10) - parseInt(diskon,10);

        if (subtotal == "" || subtotal == 0) {
            hasilnya = 0;
        }

      $("#total").val(tandaPemisahTitik(hasilnya));
      $("#biaya_admin_persen").val(biaya_admin_persen);
      
    }
      
  });
});
//Akhir Biaya Admin Select
</script>


<script type="text/javascript">
$(document).ready(function(){
  //START KEYUP BIAYA ADMIN RUPIAH

    $("#biaya_adm").keyup(function(){
      var biaya_adm = bersihPemisah(bersihPemisah(bersihPemisah(bersihPemisah($("#biaya_adm").val()))));
      if (biaya_adm == '') {
        biaya_adm = 0;
      }

      var biaya_admin_sebenarnya = bersihPemisah(bersihPemisah(bersihPemisah(bersihPemisah($("#biaya_admin_sebenarnya").val()))));
      if (biaya_admin_sebenarnya == '') {
        biaya_admin_sebenarnya = 0;
      }

      var subtotal = bersihPemisah(bersihPemisah(bersihPemisah(bersihPemisah($("#subtotal").val()))));
      if (subtotal == '') {
        subtotal = 0;
      }
      var potongan = bersihPemisah(bersihPemisah(bersihPemisah(bersihPemisah($("#diskon_rupiah").val()))));
      if (potongan == '') {
        potongan = 0;
      }
      var pembayaran = bersihPemisah(bersihPemisah(bersihPemisah(bersihPemisah($("#pembayaran_penjualan").val()))));
      if (pembayaran == '') {
        pembayaran = 0;
      }  

      var t_total = parseInt(subtotal,10) - parseInt(potongan,10);
      var biaya_admin_persen = parseInt(biaya_adm,10) / parseInt(subtotal,10) * 100;

      var total_akhir = parseInt(t_total,10) + parseInt(Math.round(biaya_adm,10));


      $("#total").val(tandaPemisahTitik(total_akhir));
      $("#biaya_admin_persen").val(Math.round(biaya_admin_persen));

      if (biaya_admin_persen > 100) {
            

            var total_akhir = parseInt(subtotal,10) - parseInt(potongan,10);
            alert ("Biaya Amin %, Tidak Boleh Lebih Dari 100%");

            var adm_persen = parseInt(biaya_admin_sebenarnya,10) / parseInt(Math.round(subtotal,10)) * 100;
            $("#biaya_admin_persen").val(Math.round(adm_persen));          
            $("#biaya_admin_select").trigger('chosen:updated');
            $("#biaya_adm").val(tandaPemisahTitik(biaya_admin_sebenarnya));

            var perhitungan_awal = parseInt(subtotal,10) - parseInt(potongan,10);
            var akhir_hitungan = parseInt(perhitungan_awal,10) + parseInt(Math.round(biaya_admin_sebenarnya,10));
            $("#total").val(tandaPemisahTitik(akhir_hitungan));

                
        }
          
        else{
        }

    });

  //END KEYUP BIAYA ADMIN RUPIAH

  //START KEYUP BIAYA ADMIN PERSEN

    $("#biaya_admin_persen").keyup(function(){
      var biaya_admin_persen = bersihPemisah(bersihPemisah(bersihPemisah(bersihPemisah($("#biaya_admin_persen").val()))));
      if (biaya_admin_persen == '') {
        biaya_admin_persen = 0;
      }

      var admin_rupiah = bersihPemisah(bersihPemisah(bersihPemisah(bersihPemisah($("#biaya_adm").val()))));
      if (admin_rupiah == '') {
        admin_rupiah = 0;
      }

      var biaya_admin_sebenarnya = bersihPemisah(bersihPemisah(bersihPemisah(bersihPemisah($("#biaya_admin_sebenarnya").val()))));
      if (biaya_admin_sebenarnya == '') {
        biaya_admin_sebenarnya = 0;
      }

      var subtotal = bersihPemisah(bersihPemisah(bersihPemisah(bersihPemisah($("#subtotal").val()))));
      if (subtotal == '') {
        subtotal = 0;
      }

      var potongan = bersihPemisah(bersihPemisah(bersihPemisah(bersihPemisah($("#diskon_rupiah").val()))));
      if (potongan == '') {
        potongan = 0;
      }

      var pembayaran = bersihPemisah(bersihPemisah(bersihPemisah(bersihPemisah($("#pembayaran_penjualan").val()))));
      if (pembayaran == '') {
        pembayaran = 0;
      }  


      var t_total = parseInt(subtotal,10) - parseInt(potongan,10);
      var biaya_admin_rupiah = parseInt(biaya_admin_persen,10) * parseInt(subtotal,10) / 100;
 

      var total_akhir = parseInt(t_total,10) + parseInt(Math.round(biaya_admin_rupiah,10));

      $("#total").val(tandaPemisahTitik(total_akhir));
      $("#biaya_adm").val(tandaPemisahTitik(Math.round(biaya_admin_rupiah)));

      if (biaya_admin_persen > 100) {
            
            var perhitungan_satu = parseInt(subtotal,10) - parseInt(potongan,10);
            var hasil_perhitungan_total = parseInt(perhitungan_satu,10) + parseInt(Math.round(biaya_admin_sebenarnya,10));
            var hasil_persen = parseInt(Math.round(biaya_admin_sebenarnya,10)) / parseInt(subtotal,10) * 100;

            alert ("Biaya Amin %, Tidak Boleh Lebih Dari 100%1");
            $("#biaya_admin_persen").val(Math.round(hasil_persen));           
            $("#biaya_admin_select").trigger('chosen:updated');
            $("#biaya_adm").val(tandaPemisahTitik(biaya_admin_sebenarnya));
            $("#total").val(tandaPemisahTitik(hasil_perhitungan_total));
          }
          
        else
          {
          }

    });

  //END KEYUP BIAYA ADMIN PERSEN
  });
</script>


<script type="text/javascript">
$(document).ready(function(){
  //Key Up Diskon Persen
  $("#diskon_persen").keyup(function(){

  var diskon_persen = bersihPemisah(bersihPemisah(bersihPemisah(bersihPemisah($("#diskon_persen").val()))));
  var total = bersihPemisah(bersihPemisah(bersihPemisah(bersihPemisah( $("#subtotal").val() ))));
  var diskon_rupiah = ((total * diskon_persen) / 100);

  var biaya_adm = bersihPemisah(bersihPemisah(bersihPemisah(bersihPemisah($("#biaya_adm").val()))));
  if (biaya_adm == ''){
    biaya_adm = 0;
  }
  
  var diskon_sebenarnya =  bersihPemisah(bersihPemisah(bersihPemisah(bersihPemisah( $("#diskon_sebenarnya").val()))));if (diskon_sebenarnya == ''){
      diskon_sebenarnya = 0;
  }

  var pembayaran = bersihPemisah(bersihPemisah(bersihPemisah(bersihPemisah($("#pembayaran_penjualan").val()))));
  if (pembayaran == ''){
    pembayaran = 0;
  }

  var sisa_potongan = parseInt(total,10) - parseInt(Math.round(diskon_rupiah,10));
  var hasil_akhir = parseInt(sisa_potongan, 10) + parseInt(biaya_adm,10);

  if (diskon_persen > 100) {
        var hitungan_persen_disk = parseInt(diskon_sebenarnya,10) / parseInt(total,10) * 100;
        var hitung_total = parseInt(total, 10) + parseInt(biaya_adm,10);
        var akhir_total = parseInt(hitung_total, 10) - parseInt(diskon_sebenarnya,10) 

        alert ("Potongan Tidak Boleh Lebih Dari 100%");
        $("#diskon_persen").val(Math.round(hitungan_persen_disk));
        $("#diskon_rupiah").val(diskon_sebenarnya);
        $("#total").val(tandaPemisahTitik(Math.round(akhir_total)));

        var sisa = pembayaran - Math.round(akhir_total);
        var sisa_kredit = Math.round(akhir_total) - pembayaran; 
           
          if (sisa > 0 ){
            $("#sisa_pembayaran_penjualan").val(tandaPemisahTitik(sisa));
            $("#kredit").val('0');
            $("#tanggal_jt").attr("disabled", true);          
          }
          else{
            $("#kredit").val( tandaPemisahTitik(sisa_kredit));
            $("#sisa_pembayaran_penjualan").val('0');
            $("#tanggal_jt").attr("disabled", false); 
          }

  }
  else{

    var sisa = pembayaran - Math.round(hasil_akhir);
    var sisa_kredit = Math.round(hasil_akhir) - pembayaran; 
        
    if (sisa > 0 ){
        $("#sisa_pembayaran_penjualan").val(tandaPemisahTitik(sisa));
        $("#kredit").val('0');
        $("#tanggal_jt").attr("disabled", true);          
      }
      else{
        $("#kredit").val( tandaPemisahTitik(sisa_kredit));
        $("#sisa_pembayaran_penjualan").val('0');
        $("#tanggal_jt").attr("disabled", false); 
      }

    $("#total").val(tandaPemisahTitik(Math.round(hasil_akhir)));
    $("#diskon_rupiah").val(tandaPemisahTitik(Math.round(diskon_rupiah)));
  }

  }); //Akhir Keyup Diskon Persen

  //Mulai Keyup Diskon Rupiah
  $("#diskon_rupiah").keyup(function(){

  var diskon_sebenarnya =  bersihPemisah(bersihPemisah(bersihPemisah(bersihPemisah( $("#diskon_sebenarnya").val()))));if (diskon_sebenarnya == ''){
      diskon_sebenarnya = 0;
  }

  var diskon_rupiah =  bersihPemisah(bersihPemisah(bersihPemisah(bersihPemisah( $("#diskon_rupiah").val()))));
  if (diskon_rupiah == ''){
      diskon_rupiah = 0;
  }

  var biaya_adm = bersihPemisah(bersihPemisah(bersihPemisah(bersihPemisah($("#biaya_adm").val()))));
  if (biaya_adm == ''){
      biaya_adm = 0;
  }
    
  var pembayaran = bersihPemisah(bersihPemisah(bersihPemisah(bersihPemisah($("#pembayaran_penjualan").val()))));
  if (pembayaran == '') {
      pembayaran = 0;
  }

  var subtotal = bersihPemisah(bersihPemisah(bersihPemisah(bersihPemisah($("#subtotal").val()))));
  var diskon_persen = ((diskon_rupiah / subtotal) * 100);
  var sisa_potongan = parseInt(subtotal,10) - Math.round(diskon_rupiah);
  var hasil_akhir = parseInt(sisa_potongan,10) + parseInt(biaya_adm,10);

  if (diskon_persen > 100) {
    var sisa = pembayaran - Math.round(hasil_akhir);
    var sisa_kredit = Math.round(hasil_akhir) - pembayaran; 
        
        if (sisa < 0 ){
          $("#kredit").val(tandaPemisahTitik(sisa_kredit));
          $("#sisa_pembayaran_penjualan").val('0');
          $("#tanggal_jt").attr("disabled", false);
                  
        }
        else{
          $("#sisa_pembayaran_penjualan").val(tandaPemisahTitik(sisa));
          $("#kredit").val('0');
          $("#tanggal_jt").attr("disabled", true);
                  
        } 
        alert ("Potongan Tidak Boleh Lebih Dari 100%");
            var disk_persen = ((diskon_sebenarnya / subtotal) * 100);
            $("#diskon_persen").val(Math.round(disk_persen));
            $("#diskon_rupiah").val(tandaPemisahTitik(diskon_sebenarnya));
            //Perhitungan kembali untuk ambil total sebenarnya
            var sisa_disk = parseInt(subtotal,10) - Math.round(diskon_sebenarnya);
            var real_total = parseInt(sisa_disk,10) + parseInt(biaya_adm,10);
            $("#total").val(tandaPemisahTitik(Math.round(real_total)));
            
            //Sisa Atas Pembayaran di 0 kan, dan Sisa Di Kembalikan Ke sebelumnya (Perhitungan yang sebenarnya)
                var hitung_kredit = Math.round(real_total) - pembayaran; 
                var kembalian_uang = parseInt(pembayaran,10) -  parseInt(real_total,10);
                    
                if (kembalian_uang > 0 ){
                  $("#sisa_pembayaran_penjualan").val(tandaPemisahTitik(kembalian_uang));
                  $("#kredit").val('0');
                  $("#tanggal_jt").attr("disabled", false);
                }
                else{
                  $("#kredit").val(tandaPemisahTitik(hitung_kredit));
                  $("#sisa_pembayaran_penjualan").val('0');
                  $("#tanggal_jt").attr("disabled", true);
                } 
                //perhitungan uang kembalian dan kredit
  }
  else{

    var sisa = pembayaran - Math.round(hasil_akhir);
    var sisa_kredit = Math.round(hasil_akhir) - pembayaran; 
        
    if (sisa < 0 ){
      $("#kredit").val( tandaPemisahTitik(sisa_kredit));
      $("#sisa_pembayaran_penjualan").val('0');
      $("#tanggal_jt").attr("disabled", false);       
    }
    else{
      $("#sisa_pembayaran_penjualan").val(tandaPemisahTitik(sisa));
      $("#kredit").val('0');
      $("#tanggal_jt").attr("disabled", true);
              
    }
    $("#total").val(tandaPemisahTitik(Math.round(hasil_akhir)));
    $("#diskon_persen").val(Math.round(diskon_persen));
  }
  }); //Akhir Keyup Diskon Rupiah
}); //Akhir Doc Ready       
</script>


<!--CLASS CHOSEN -->
<script type="text/javascript">
    $(".chosen").chosen({no_results_text: "Maaf, Data Tidak Ada!",search_contains:true});
</script>
<!-- / CLASS CHOSEN -->

<!-- SHORTCUT -->
<script> 
    
    shortcut.add("f1", function() {
        // Do something

    $("#cari_jasa_laboratorium").click();

    }); 

    shortcut.add("f4", function() {
        // Do something

        $("#carabayar1").trigger('chosen:open');

    }); 

    
    shortcut.add("f7", function() {
        // Do something

        $("#pembayaran_penjualan").focus();

    }); 

    
    shortcut.add("f8", function() {
        // Do something

        $("#penjualan").click();

    }); 

    
    shortcut.add("f9", function() {
        // Do something

        $("#piutang").click();

    }); 

        shortcut.add("ctrl+m", function() {

        // Do something
        $("#transaksi_baru").click();

    }); 

    
    shortcut.add("ctrl+b", function() {
        // Do something

        $("#batal_penjualan").click();

    }); 

     shortcut.add("ctrl+k", function() {
        // Do something

        $("#cetak_langsung").click();


    }); 
</script>
<!-- SHORTCUT -->

<script>
$(document).ready(function(){
    //Keyup Ketika Ketik Pembayaran
    $("#pembayaran_penjualan").keyup(function(){
        var pembayaran = bersihPemisah(bersihPemisah(bersihPemisah(bersihPemisah( $("#pembayaran_penjualan").val() ))));
        var total =  bersihPemisah(bersihPemisah(bersihPemisah(bersihPemisah( $("#total").val() ))));
        var sisa = pembayaran - total;
        var sisa_kredit = total - pembayaran; 
        
        if (sisa < 0 ){
            $("#kredit").val( tandaPemisahTitik(sisa_kredit));
            $("#sisa_pembayaran_penjualan").val('0');
            $("#tanggal_jt").attr("disabled", false);

            $("#penjualan").hide();
            $("#cetak_langsung").hide();
            $("#piutang").show();
        }
        else{
            $("#sisa_pembayaran_penjualan").val(tandaPemisahTitik(sisa));
            $("#kredit").val('0');
            $("#tanggal_jt").attr("disabled", true);

            $("#penjualan").show();
            $("#cetak_langsung").show();
            $("#piutang").hide();
        } 
    });
});
</script>



<!--Mulai Script Proses Save Pada Modal-->
<script type="text/javascript">
  $(document).ready(function(){
    $(document).on('click','#simpan_data',function(e){

     // DATATABE AJAX TABLE_APS
                $('#table_aps').DataTable().destroy();
                        var dataTable = $('#table_aps').DataTable( {
                        "processing": true,
                        "serverSide": true,
                        "info":     false,
                        "language": { "emptyTable":     "My Custom Message On Empty Table" },
                        "ajax":{
                          url :"datatable_tbs_edit_aps.php", // json datasource
                           "data": function ( d ) {
                              d.no_reg = $("#no_reg").val();
                              d.no_faktur = $("#no_faktur").val();

                          },
                              type: "post",  // method  , by default get
                          error: function(){  // error handling
                            $(".tbody").html("");
                            $("#table_aps").append('<tbody class="tbody"><tr><th colspan="3"></th></tr></tbody>');
                            $("#tableuser_processing").css("display","none");
                            
                          }
                        }   

                });// DATATABE AJAX TABLE_APS

      $("#span_tbs_aps").show();
      $("#modal_lab").modal('hide');


             //START SUBTOTAL DAN TOTAL
var no_reg = $("#no_reg").val();
var no_faktur = $("#no_faktur").val();
var diskon_persen = bersihPemisah(bersihPemisah(bersihPemisah(bersihPemisah($("#diskon_persen").val()))));
var diskon_rupiah = bersihPemisah(bersihPemisah(bersihPemisah(bersihPemisah($("#diskon_rupiah").val()))));

$.post("cek_subtotal_edit_aps.php",{no_reg:no_reg,no_faktur:no_faktur},function(data){
    data = data.replace(/\s+/g, '');
    if (data == ""){
        data = 0;
    }

    var sum = parseInt(data,10);
    //Input Subtotal
    $("#subtotal").val(tandaPemisahTitik(sum))

    //Mulai Proses Cek Biaya Admin
    var biaya_adm = bersihPemisah(bersihPemisah(bersihPemisah(bersihPemisah($("#biaya_adm").val()))));
      if (biaya_adm == '') {
        biaya_adm = 0;
      }

    var biaya_admin_sebenarnya = bersihPemisah(bersihPemisah(bersihPemisah(bersihPemisah($("#biaya_admin_sebenarnya").val()))));
      if (biaya_admin_sebenarnya == '') {
        biaya_admin_sebenarnya = 0;
      }

    var subtotal = bersihPemisah(bersihPemisah(bersihPemisah(bersihPemisah($("#subtotal").val()))));
      if (subtotal == '') {
        subtotal = 0;
      }

    var potongan = bersihPemisah(bersihPemisah(bersihPemisah(bersihPemisah($("#diskon_rupiah").val()))));
      if (potongan == '') {
        potongan = 0;
      }

    var pembayaran = bersihPemisah(bersihPemisah(bersihPemisah(bersihPemisah($("#pembayaran_penjualan").val()))));
      if (pembayaran == '') {
        pembayaran = 0;
      }  

      var t_total = parseInt(subtotal,10) - parseInt(potongan,10);
      var biaya_admin_persen = parseInt(biaya_adm,10) / parseInt(subtotal,10) * 100;

      var total_akhir = parseInt(t_total,10) + parseInt(Math.round(biaya_adm,10));


      var adm_persen = parseInt(biaya_admin_sebenarnya,10) / parseInt(subtotal,10) * 100;

      $("#total").val(tandaPemisahTitik(total_akhir));
      $("#biaya_admin_persen").val(Math.round(biaya_admin_persen));

        if (biaya_admin_persen > 100) {
            
            var total_akhir = parseInt(subtotal,10) - parseInt(potongan,10);
            alert ("Biaya Amin %, Tidak Boleh Lebih Dari 100%");
            $("#biaya_admin_persen").val(adm_persen);
            $("#biaya_admin_select").val('0');            
            $("#biaya_admin_select").trigger('chosen:updated');
            $("#biaya_adm").val(biaya_admin_sebenarnya);
            $("#total").val(tandaPemisahTitik(total_akhir));
        }
        else{
        }
    //Akhir Proses Cek Biaya Admin

        //Start Proses Diskon Rupiah
          var diskon_rupiah =  bersihPemisah(bersihPemisah(bersihPemisah(bersihPemisah( $("#diskon_rupiah").val()))));
          var biaya_adm = bersihPemisah(bersihPemisah(bersihPemisah(bersihPemisah($("#biaya_adm").val()))));
          if (biaya_adm == ''){
              biaya_adm = 0;
          }
            
          var pembayaran = bersihPemisah(bersihPemisah(bersihPemisah(bersihPemisah($("#pembayaran_penjualan").val()))));
          if (pembayaran == '') {
              pembayaran = 0;
          }
          var total = bersihPemisah(bersihPemisah(bersihPemisah(bersihPemisah( $("#total").val() ))));
          var subtotal = bersihPemisah(bersihPemisah(bersihPemisah(bersihPemisah($("#subtotal").val()))));
          var diskon_persen = ((diskon_rupiah / subtotal) * 100);
          var sisa_potongan = subtotal - Math.round(diskon_rupiah);
          var hasil_akhir = parseInt(sisa_potongan, 10) + parseInt(biaya_adm,10);

        if (diskon_persen > 100) {
            var sisa = pembayaran - Math.round(hasil_akhir);
            var sisa_kredit = Math.round(hasil_akhir) - pembayaran; 
                
            if (sisa < 0 ){
              $("#kredit").val(tandaPemisahTitik(sisa_kredit));
              $("#sisa_pembayaran_penjualan").val('0');
              $("#tanggal_jt").attr("disabled", false);

                    $("#penjualan").hide();
                    $("#cetak_langsung").hide();
                    $("#piutang").show();   
                      
            }
            else{
              $("#sisa_pembayaran_penjualan").val(tandaPemisahTitik(sisa));
              $("#kredit").val('0');
              $("#tanggal_jt").attr("disabled", true);

                    $("#penjualan").show();
                    $("#cetak_langsung").show();
                    $("#piutang").hide();   
                      
            } 
                alert ("Potongan %, Tidak Boleh Lebih Dari 100%");
                    $("#diskon_persen").val('');
                    $("#diskon_rupiah").val('');
                    $("#total").val(tandaPemisahTitik(hasil_akhir));
                    
        }
        else{
                var sisa = pembayaran - Math.round(hasil_akhir);
                var sisa_kredit = Math.round(hasil_akhir) - pembayaran; 
                
                if (sisa < 0 ){
                    $("#kredit").val( tandaPemisahTitik(sisa_kredit));
                    $("#sisa_pembayaran_penjualan").val('0');
                    $("#tanggal_jt").attr("disabled", false); 

                    $("#penjualan").hide();
                    $("#cetak_langsung").hide();
                    $("#piutang").show();         
                }
                else{

                    $("#sisa_pembayaran_penjualan").val(tandaPemisahTitik(sisa));
                    $("#kredit").val('0');
                    $("#tanggal_jt").attr("disabled", true);

                    $("#penjualan").show();
                    $("#cetak_langsung").show();
                    $("#piutang").hide();   
                      
                      
                }
            
            $("#total").val(tandaPemisahTitik(Math.round(hasil_akhir)));
            $("#diskon_persen").val(Math.round(diskon_persen));
        }//Akhir Proses Diskon Rupiah

});
//CEK SUBTOTAL + TOTAL

      });
    });
</script>
<!--Akhir Script Proses Save Pada Modal-->


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
    var tanggal = $("#tanggal").val();
    var no_faktur = $("#no_faktur").val();
    var nama_pasien = $("#nama_pasien").val();
    var tipe_barang = "Jasa";

//ambil dari form yang hidden
    var jenis_penjualan = $("#jenis_penjualan").val();
    var jenis_kelamin = $("#jenis_kelamin").val();

    $('#kolom_cek_harga').val('1');
    var kolom_cek_harga = $("#kolom_cek_harga").val();

    if (data_toggle == 1) {
              
      $(this).attr("data-toogle", 11);

      $.post("proses_input_data_header_edit_penjualan.php",{tanggal:tanggal,no_faktur:no_faktur,id_periksa:id_periksa,kode_jasa_lab:kode_jasa_lab,no_rm:no_rm,no_reg:no_reg,analis:analis,dokter:dokter,nama_pasien:nama_pasien,tipe_barang:tipe_barang,jenis_penjualan:jenis_penjualan,jenis_kelamin:jenis_kelamin},function(data){
 

      });
    }
    else{

      $(this).attr("data-toogle", 1);

      $.post("hapus_data_header_edit_penjualan.php",{no_faktur:no_faktur,kode_jasa_lab:kode_jasa_lab,no_reg:no_reg},function(data){
      
      //ubah data toogle menjadi 2 yang detail !!
      $(".pilih-detail-dari-header").attr("data-toogle", 2);

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
    var tanggal = $("#tanggal").val();
    var no_faktur = $("#no_faktur").val();
    var nama_pasien = $("#nama_pasien").val();
    var tipe_barang = "Jasa";

//ambil dari form yang hidden
    var jenis_penjualan = $("#jenis_penjualan").val();
    var jenis_kelamin = $("#jenis_kelamin").val();

    if (data_toggle == 2) {
              
      $(this).attr("data-toogle", 22);

      $.post("proses_input_data_detail_edit_penjualan.php",{tanggal:tanggal,no_faktur:no_faktur,id_periksa:id_periksa,kode_jasa_lab:kode_jasa_lab,no_rm:no_rm,no_reg:no_reg,analis:analis,dokter:dokter,nama_pasien:nama_pasien,tipe_barang:tipe_barang,jenis_penjualan:jenis_penjualan,jenis_kelamin:jenis_kelamin},function(data){
 

      });
    }
    else{
      $(this).attr("data-toogle", 2);

      $.post("hapus_data_detail_edit_penjualan.php",{no_faktur:no_faktur,kode_jasa_lab:kode_jasa_lab,no_reg:no_reg},function(data){

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
    var tanggal = $("#tanggal").val();
    var nama_pasien = $("#nama_pasien").val();
    var no_faktur = $("#no_faktur").val();
    var tipe_barang = "Jasa";

//ambil dari form yang hidden
    var jenis_penjualan = $("#jenis_penjualan").val();
    var jenis_kelamin = $("#jenis_kelamin").val();

    if (data_toggle == 3) {
              
      $(this).attr("data-toogle", 33);

      $.post("proses_input_data_detail_sendirian_edit_penjualan.php",{tanggal:tanggal,no_faktur:no_faktur,id_periksa:id_periksa,kode_jasa_lab:kode_jasa_lab,no_rm:no_rm,no_reg:no_reg,analis:analis,dokter:dokter,nama_pasien:nama_pasien,tipe_barang:tipe_barang,jenis_penjualan:jenis_penjualan,jenis_kelamin:jenis_kelamin},function(data){
 

      });
    }
    else{

      $(this).attr("data-toogle", 3);

      $.post("hapus_data_detail_sendirian_edit_penjualan.php",{no_faktur:no_faktur,kode_jasa_lab:kode_jasa_lab,no_reg:no_reg},function(data){

      });
    }
  
  $("form").submit(function(){
      return false;    
  });
});
</script>
<!--Akhir Script Proses untuk SENDIRIAN-->

<script type="text/javascript">
//Batal Penjualan
$(document).ready(function(){
  $("#batal_penjualan").click(function(){
    var no_faktur = $("#no_faktur").val()
      window.location.href="batal_edit_penjualan_aps.php?no_faktur="+no_faktur+"";
  })
});
</script>

<!--Footer-->
<?php include 'footer.php'; ?>