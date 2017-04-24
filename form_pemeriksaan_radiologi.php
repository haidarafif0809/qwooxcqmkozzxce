<?php include 'session_login.php';
// memasukan file session login,  header, navbar, db.php,
include 'header.php';
include 'navbar.php';
include 'db.php';
include 'sanitasi.php';


$session_id = session_id();

$user = $_SESSION['nama'];

if (isset($_GET['no_reg']))
{

$nama = stringdoang($_GET['nama']);
$no_rm = stringdoang($_GET['no_rm']);
$no_reg = stringdoang($_GET['no_reg']);
$dokter_pengirim = stringdoang($_GET['dokter']);
$jenis_penjualan = stringdoang($_GET['jenis_penjualan']);
$rujukan = stringdoang($_GET['rujukan']);
$penjamin = stringdoang($_GET['penjamin']);
}

else if (isset($_GET['no_rm']))
{
$nama = stringdoang($_GET['nama']);
$no_rm = stringdoang($_GET['no_rm']);
$no_reg = "";
$dokter_pengirim = "";
$jenis_penjualan = "";
$rujukan = "";
$penjamin = "";
}
else
{
$nama = 'Umum';
$no_rm = "Umum";
$no_reg = "";
$dokter_pengirim = "";
$jenis_penjualan = "";
$rujukan = "";
$penjamin = "";
}


//HITUNG TOTAL HRGA PRODUK YANG ADA DI R> JALAN / INPA dan OPERASI JIKA ADA
$sum_rj_ri = $db->query("SELECT SUM(subtotal) AS total_rj_ri FROM tbs_penjualan WHERE no_reg = '$no_reg' AND no_reg != '' AND radiologi IS NULL ");
$data_rj_ri = mysqli_fetch_array($sum_rj_ri);

$sql_ops = $db->query("SELECT SUM(harga_jual) AS total_ops FROM tbs_operasi WHERE no_reg = '$no_reg'");
$data_ops = mysqli_fetch_array($sql_ops);
//HITUNG TOTAL HRGA PRODUK YANG ADA DI R> JALAN / INPA dan OPERASI JIKA ADA

//DATA YANG DIBUTUHKAN UNTK KEMBALI KE FORM R> JALAN / INAP
$select_reg = $db->query("SELECT poli, bed, group_bed FROM registrasi WHERE no_reg = '$no_reg' ");
$data_reg = mysqli_fetch_array($select_reg);
//DATA YANG DIBUTUHKAN UNTK KEMBALI KE FORM R> JALAN / INAP


 ?>

<!-- js untuk tombol shortcut -->
 <script src="shortcut.js"></script>
<!-- js untuk tombol shortcut -->


<style type="text/css">
  .disabled {
    opacity: 0.6;
    cursor: not-allowed;
    disabled: true;
}
</style>

<style>
  tr:nth-child(even){background-color: #f2f2f2}
</style>



<script>
  $(function() {
    $( "#tanggal_jt" ).datepicker({dateFormat: "yy-mm-dd"});
  });
  </script>


 <!-- Modal Untuk Confirm LAYANAN PERUSAHAAN-->
<div id="detail" class="modal fade" role="dialog">
  <div class="modal-dialog modal-lg">
    <!-- Modal content-->
    <div class="modal-content">
    <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>       
    </div>
    <div class="modal-body">

      <span id="tampil_layanan">
      </span>
    </div>
    <div class="modal-footer">
        
        <button type="button" class="btn btn-danger" accesskey="d" data-dismiss="modal"> Close<u>d</u></button>
    </div>
    </div>
  </div>
</div>
<!--modal end Layanan Perusahaan-->
<!--untuk membuat agar tampilan form terlihat rapih dalam satu tempat -->

 <div style="padding-left: 5%; padding-right: 5%">

 <?php if ($rujukan == 'Rujuk Rawat Inap'): ?>
  <h3> FORM INPUT PEMERIKSAAN RADIOLOGI - R. INAP</h3><hr>
 <?php endif ?>

 <?php if ($rujukan == 'Rujuk Rawat Jalan'): ?>
  <h3> FORM INPUT PEMERIKSAAN RADIOLOGI - R. JALAN</h3><hr>
 <?php endif ?>

 <?php if ($rujukan == 'Rujuk UGD'): ?>
  <h3> FORM INPUT PEMERIKSAAN RADIOLOGI - UGD</h3><hr>
 <?php endif ?>

 <?php if ($rujukan == ''): ?>
  <h3> FORM INPUT PEMERIKSAAN RADIOLOGI</h3><hr>
 <?php endif ?>
  
<div class="row">

<div class="col-xs-8">


 <!-- membuat form menjadi beberpa bagian -->
  <form enctype="multipart/form-data" role="form" action="formpenjualan.php" method="post ">
        
  <!--membuat teks dengan ukuran h3-->

        <input type="hidden" name="session_id" id="session_id" class="form-control" value="<?php echo session_id(); ?>" readonly="">


<div class="row">

<?php if ($no_reg  != ""): ?>
  <div class="col-xs-2">
  <label> No. Reg </label><br>
    <input  name="no_reg" style="height: 15px" type="text" id="no_reg" class="form-control" required="" autofocus="" value="<?php echo $no_reg ?>" readonly="">
  </div>
<?php else: ?>

  <div class="col-xs-2" style="display: none">
  <label> No. Reg </label><br>
    <input  name="no_reg" style="height: 15px" type="text" id="no_reg" class="form-control" required="" autofocus="" value="<?php echo $no_reg ?>" readonly="">
  </div>
<?php endif ?>


<div class="col-xs-2 form-group"> 
    <label> Nama Pasien </label><br>
  <input  name="kode_pelanggan" type="hidden" style="height:15px;" id="kd_pelanggan" class="form-control" required="" autofocus="" >
  <input  name="nama_pelanggan" type="text" style="height:15px;" id="nama_pelanggan" class="form-control" required="" autofocus="" value="<?php echo $nama ?>">
<input  name="kode_pelanggan1" type="hidden" style="height:15px;" id="kd_pelanggan1" class="form-control" required="" autofocus="" value="<?php echo $no_rm ?>">
</div>

<!-- DATA YANG DIUBUTHKAN UNTUK KEMABLI KE FORM PENJUALAN R. JALAN / INAP -->
<input  name="asal_poli" type="hidden" style="height:15px;" id="asal_poli" class="form-control" required="" autofocus="" value="<?php echo $data_reg['poli']; ?>" >
<input  name="bed" type="hidden" style="height:15px;" id="bed" class="form-control" required="" autofocus="" value="<?php echo $data_reg['bed']; ?>" >
<input  name="kamar" type="hidden" style="height:15px;" id="kamar" class="form-control" required="" autofocus="" value="<?php echo $data_reg['group_bed']; ?>" >
<!-- DATA YANG DIUBUTHKAN UNTUK KEMABLI KE FORM PENJUALAN R. JALAN / INAP -->


  <div class="form-group col-xs-2" style="display: none">
    <label for="email">Penjamin:</label>
    <select class="form-control chosen" id="penjamin" name="penjamin" required="">
    <option value="<?php echo $penjamin ?>"><?php echo $penjamin ?></option>
      <?php 
      $query = $db->query("SELECT nama FROM penjamin");
      while ( $icd = mysqli_fetch_array($query))
      {
             echo "<option value='".$icd['nama']."'>".$icd['nama']."</option>";

      }
      ?>
    </select>
</div>


<div class="col-xs-2" style="display: none" >
  <label> Level Harga </label><br>

  <select style="font-size:15px; height:35px" type="text" name="level_harga" id="level_harga" class="form-control chosen" required="" >
  <option value="harga_1">Level 1</option>
  <option value="harga_2">Level 2</option>
  <option value="harga_3">Level 3</option>
  <option value="harga_4">Level 4</option>
  <option value="harga_5">Level 5</option>
  <option value="harga_6">Level 6</option>
  <option value="harga_7">Level 7</option>

    </select>
    </div>


<div class="col-xs-2" style="display: none">
          <label>PPN</label>
          <select style="font-size:15px; height:35px" name="ppn" id="ppn" class="form-control">

            <option value="Include">Include</option>  
            <option value="Exclude">Exclude</option>
            <option value="Non">Non</option>          
          </select>
</div>


<?php if ($no_reg == ""): ?>
    <div class="col-xs-3">
       <label> Dokter Pengirim </label><br>
              
        <select name="dokter" id="dokter" class="form-control chosen" required="" >

      <?php 
            //untuk menampilkan semua data pada tabel pelanggan dalam DB
        $query01 = $db->query("SELECT nama,id FROM user WHERE tipe = '1'");

        //untuk menyimpan data sementara yang ada pada $query
        while($data01 = mysqli_fetch_array($query01))
        {    

          if ($data01['id'] == $dokter_pengirim) {
           echo "<option selected value='".$data01['id'] ."'>".$data01['nama'] ."</option>";
          }
          else{
            echo "<option value='".$data01['id'] ."'>".$data01['nama'] ."</option>";
          }

        
        }
    ?>
      </select>
    </div>

    <div class="col-xs-3" style="display: none;">
     <label> Dokter Pemeriksa </label><br>

            
      <select name="dokter" id="dokter_pemeriksa" class="form-control chosen" required="" >
      
    <?php 
          //untuk menampilkan semua data pada tabel pelanggan dalam DB
      $query01 = $db->query("SELECT nama,id FROM user WHERE tipe = '1'");

      //untuk menyimpan data sementara yang ada pada $query
      while($data01 = mysqli_fetch_array($query01))    {

          echo "<option value='".$data01['id'] ."'>".$data01['nama'] ."</option>";
      
      }
  ?>
    </select>
  </div>

    <div class="col-xs-3">
   <label> Petugas Radiologi </label><br>
          
    <select name="petugas" id="petugas_radiologi" class="form-control chosen" required="" >

  <?php 
        //untuk menampilkan semua data pada tabel pelanggan dalam DB
    $query01 = $db->query("SELECT nama,id FROM user WHERE tipe = '5'");

    //untuk menyimpan data sementara yang ada pada $query
    while($data01 = mysqli_fetch_array($query01))    {

        echo "<option value='".$data01['id'] ."'>".$data01['nama'] ."</option>";
    
    }
?>
  </select>
</div>

<?php else: ?>

  <div class="col-xs-2">
   <label> Dokter Pengirim </label><br>
          
    <select name="dokter" id="dokter" class="form-control chosen" required="" >

  <?php 
        //untuk menampilkan semua data pada tabel pelanggan dalam DB
    $query01 = $db->query("SELECT nama,id FROM user WHERE tipe = '1'");

    //untuk menyimpan data sementara yang ada pada $query
    while($data01 = mysqli_fetch_array($query01))
    {    

      if ($data01['id'] == $dokter_pengirim) {
       echo "<option selected value='".$data01['id'] ."'>".$data01['nama'] ."</option>";
      }
      else{
        echo "<option value='".$data01['id'] ."'>".$data01['nama'] ."</option>";
      }

    
    }
?>
  </select>
</div>

  <div class="col-xs-2" style="display: none;">
   <label> Dokter Pemeriksa </label><br>

          
    <select name="dokter" id="dokter_pemeriksa" class="form-control chosen" required="" >
    
  <?php 
        //untuk menampilkan semua data pada tabel pelanggan dalam DB
    $query01 = $db->query("SELECT nama,id FROM user WHERE tipe = '1'");

    //untuk menyimpan data sementara yang ada pada $query
    while($data01 = mysqli_fetch_array($query01))    {

        echo "<option value='".$data01['id'] ."'>".$data01['nama'] ."</option>";
    
    }
?>
  </select>
</div>

    <div class="col-xs-2">
   <label> Petugas Radiologi </label><br>
          
    <select name="petugas" id="petugas_radiologi" class="form-control chosen" required="" >

  <?php 
        //untuk menampilkan semua data pada tabel pelanggan dalam DB
    $query01 = $db->query("SELECT nama,id FROM user WHERE tipe = '5'");

    //untuk menyimpan data sementara yang ada pada $query
    while($data01 = mysqli_fetch_array($query01))    {

        echo "<option value='".$data01['id'] ."'>".$data01['nama'] ."</option>";
    
    }
?>
  </select>
</div>

<?php endif ?>

</div>

<div class="row">


<?php if ($no_reg == ""): ?>


  <div class="col-xs-8">

  <button type="button" id="cari_produk_radiologi" class="btn btn-info " data-toggle="modal" data-target="#myModal"><i class='fa fa-search'></i> Cari (F1) </button> 

    <?php if ($no_reg == ""): ?>

          <a href="form_pendaftaran_pasien_radiologi.php" class="btn btn-default"> <i class="fa fa-plus"></i> Pasien Baru</a>  
          <button type="button" class="btn btn-default" id="btnRefreshsubtotal"> <i class='fa fa-refresh'></i> Refresh Subtotal</button>
          <button type="button" id="lay" class="btn btn-warning" ><i class='fa  fa-list'></i> Layanan  </button> 

    <?php endif ?>  

  </div>


<?php else: ?>

  <div class="col-xs-10">

  <button type="button" id="cari_produk_radiologi" class="btn btn-info " data-toggle="modal" data-target="#myModal"><i class='fa fa-search'></i> Cari (F1) </button> 

    <?php if ($no_reg == ""): ?>

          <a href="form_pendaftaran_pasien_radiologi.php" class="btn btn-default"> <i class="fa fa-plus"></i> Pasien Baru</a> 
          <button type="button" class="btn btn-default" id="btnRefreshsubtotal"> <i class='fa fa-refresh'></i> Refresh Subtotal</button> 
          <button type="button" id="lay" class="btn btn-warning" ><i class='fa  fa-list'></i> Layanan  </button>
          
    <?php endif ?>  

  </div>


<?php endif ?>


</div>




  </form><!--tag penutup form-->

<!--tampilan modal-->
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
                      
                          echo '<input type="checkbox" class="cekcbox-1 filled-in" id="pemeriksaan-'.$data_kontras['id'].'" name="pakai_kontras" value="'.$data_kontras['kode_pemeriksaan'].'" checked="true" disabled="true" >
                          <label for="pemeriksaan-'.$data_kontras['id'].'"
                          data-id="'.$data_kontras['id'].'"
                          data-kode="'.$data_kontras['kode_pemeriksaan'].'"
                          data-nama="'.$data_kontras['nama_pemeriksaan'].'"
                          data-kontras="'.$data_kontras['kontras'].'"
                          data-harga="'.$data_kontras['harga_1'].'" class="insert-tbs" data-toogle="1" id="label-'.$data_kontras['id'].'"
                           checked="true" disabled="true" >'.$data_kontras['nama_pemeriksaan'].'</label> <br>';

                      }
                      else{
                      
                          echo '<input type="checkbox" class="cekcbox-1 filled-in" id="pemeriksaan-'.$data_kontras['id'].'" name="pakai_kontras" value="'.$data_kontras['kode_pemeriksaan'].'">
                          <label for="pemeriksaan-'.$data_kontras['id'].'"
                          data-id="'.$data_kontras['id'].'"
                          data-kode="'.$data_kontras['kode_pemeriksaan'].'"
                          data-nama="'.$data_kontras['nama_pemeriksaan'].'"
                          data-kontras="'.$data_kontras['kontras'].'"
                          data-harga="'.$data_kontras['harga_1'].'" class="insert-tbs" data-toogle="0" id="label-'.$data_kontras['id'].'"
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
                            id="pemeriksaan-'.$data_tanpa_kontras['id'].'" value="'.$data_tanpa_kontras['kode_pemeriksaan'].'" checked="true" disabled="true" > 
                            <label for="pemeriksaan-'.$data_tanpa_kontras['id'].'"
                            data-id="'.$data_tanpa_kontras['id'].'"
                            data-kode="'.$data_tanpa_kontras['kode_pemeriksaan'].'"
                            data-nama="'.$data_tanpa_kontras['nama_pemeriksaan'].'"
                            data-kontras="'.$data_tanpa_kontras['kontras'].'"
                            data-harga="'.$data_tanpa_kontras['harga_1'].'" class="insert-tbs" data-toogle="1" id="label-'.$data_tanpa_kontras['id'].'"
                             checked="true" disabled="true" >'.$data_tanpa_kontras['nama_pemeriksaan'].'</label> <br>';
                        }
                        else{

                            echo '<input type="checkbox" class="cekcbox-2 filled-in" name="tanpa_kontras" 
                            id="pemeriksaan-'.$data_tanpa_kontras['id'].'" value="'.$data_tanpa_kontras['kode_pemeriksaan'].'"> 
                            <label for="pemeriksaan-'.$data_tanpa_kontras['id'].'"
                            data-id="'.$data_tanpa_kontras['id'].'"
                            data-kode="'.$data_tanpa_kontras['kode_pemeriksaan'].'"
                            data-nama="'.$data_tanpa_kontras['nama_pemeriksaan'].'"
                            data-kontras="'.$data_tanpa_kontras['kontras'].'"
                            data-harga="'.$data_tanpa_kontras['harga_1'].'" class="insert-tbs" data-toogle="0" id="label-'.$data_tanpa_kontras['id'].'"
                            >'.$data_tanpa_kontras['nama_pemeriksaan'].'</label> <br>';
                        }


                    }


                    
                  ?>

              </div> <!-- /  -->

            </div>
        </form>
      
      </div>

      <div class="modal-footer">
        <button type="button" class="btn btn-warning" id="btnSubmit"> <i class='fa fa-plus'></i> Submit</button>
        <button type="button" accesskey="e" class="btn btn-danger" data-dismiss="modal"><i class='fa fa-close'></i> Cancel</button>
      </div>
    </div>

  </div>
</div><!-- end of modal data barang  -->



<!-- Modal Hapus data -->
<div id="modal_hapus" class="modal fade" role="dialog">
  <div class="modal-dialog">

    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title">Konfirmsi Hapus Data Tbs Penjualan</h4>
      </div>
      <div class="modal-body">
   <p>Apakah Anda yakin Ingin Menghapus Data ini ?</p>
   <form >
    <div class="form-group">
     <input type="text" id="nama-barang" class="form-control" readonly=""> 
     <input type="hidden" id="id_hapus" class="form-control" >
     <input type="hidden" id="kode_hapus" class="form-control" >
    </div>
   
   </form>
   
  <div class="alert alert-success" style="display:none">
   <strong>Berhasil!</strong> Data berhasil Di Hapus
  </div>
 

      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-info" id="btn_jadi_hapus"> <span class='glyphicon glyphicon-ok-sign'> </span> Ya</button>
        <button type="button" class="btn btn-warning" data-dismiss="modal"> <span class='glyphicon glyphicon-remove-sign'> </span>Batal</button>
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
        <h4 class="modal-title">Edit Data Penjualan Barang</h4>
      </div>
      <div class="modal-body">
  <form role="form">
   <div class="form-group">
    <label for="email">Jumlah Baru:</label>
     <input type="text" class="form-control" autocomplete="off" id="barang_edit"><br>
     <label for="email">Jumlah Lama:</label>
     <input type="text" class="form-control" id="barang_lama" readonly="">
     <input type="hidden" class="form-control" id="harga_edit" readonly="">
     <input type="hidden" class="form-control" id="kode_edit">     
     <input type="hidden" class="form-control" id="potongan_edit" readonly="">
     <input type="hidden" class="form-control" id="tax_edit" readonly="">
     <input type="hidden" class="form-control" id="id_edit">
    
   </div>
   
   
   <button type="submit" id="submit_edit" class="btn btn-default">Submit</button>
  </form>
  <span id="alert"> </span>
  <div class="alert-edit alert-success" style="display:none">
   <strong>Berhasil!</strong> Data berhasil Di Edit
  </div>
 

      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-primary" data-dismiss="modal">Close</button>
      </div>
    </div>

  </div>
</div><!-- end of modal edit data  -->

<!-- membuat form prosestbspenjual -->

<form class="form"  role="form" id="formtambahproduk">
<br>
<div class="row">

  <div class="col-xs-3">

    <select type="text" style="height:15px" class="form-control chosen" name="kode_barang" autocomplete="off" id="kode_barang" placeholder="Kode Lab" >
  <option value="">SILAKAN PILIH</option>
  <?php 

        include 'cache.class.php';
          $c = new Cache();
          $c->setCache('produk_radiologi');
          $data_c = $c->retrieveAll();

          foreach ($data_c as $key) {
            echo '<option id="opt-produk-'.$key['kode_pemeriksaan'].'" value="'.$key['kode_pemeriksaan'].'" 
            data-kode="'.$key['kode_pemeriksaan'].'" 
            nama_pemeriksaan="'.$key['nama_pemeriksaan'].'" 
            harga_1="'.$key['harga_1'].'" 
            harga_2="'.$key['harga_2'].'" 
            harga_3="'.$key['harga_3'].'" 
            harga_4="'.$key['harga_4'].'" 
            harga_5="'.$key['harga_5'].'" 
            harga_6="'.$key['harga_6'].'"
            harga_7="'.$key['harga_7'].'" 
            kontras="'.$key['kontras'].'" 
            id-barang="'.$key['id'].'" > '. $key['kode_pemeriksaan'].' ( '.$key['nama_pemeriksaan'].' ) </option>';
          }

  ?>
        </select>
  </div>

    <input type="hidden" class="form-control" name="nama_barang" autocomplete="off" id="nama_barang" placeholder="nama" >

  <div class="col-xs-2" style="display: none">
    <input style="height:15px;" type="text" class="form-control" name="jumlah_barang" autocomplete="off" id="jumlah_barang" placeholder="Jumlah" >
  </div>

   <div class="col-xs-2" style="display: none">
    <input style="height:15px;" type="text" class="form-control" name="potongan" autocomplete="off" id="potongan1" data-toggle="tooltip" data-placement="top" title="Jika Ingin Potongan Dalam Bentuk Persen (%), input : 10%" placeholder="Potongan">
  </div>

   <div class="col-xs-1" style="display: none">
    <input style="height:15px;" type="text" class="form-control" name="tax" autocomplete="off" id="tax1" placeholder="Tax%" >
  </div>


  <button type="submit" id="submit_produk" class="btn btn-success" > <i class="fa fa-send"></i> Submit (F3)</button>

</div>

    <input type="hidden" class="form-control" name="kontras" id="kontras" placeholder="Kontras" >
    <input type="hidden" id="harga_penjamin" name="harga_penjamin" class="form-control" value="" placeholder="harga penjamin"> 
    <input type="hidden" id="harga_produk" name="harga_produk" class="form-control" value="" placeholder="harga produk"> 
    <input type="hidden" id="harga_baru" name="harga_baru" class="form-control" value="" placeholder="baru harga"> 
    <input type="hidden" id="id_radiologi" name="id_radiologi" class="form-control" value="" placeholder="ida jasa"> 
    <input type="hidden" class="form-control" name="ber_stok" id="ber_stok" value="Jasa"  >



</form> <!-- tag penutup form -->



                <span id="span_tbs">            
                
                  <div class="table-responsive">
                    <table id="tabel_tbs_radiologi" class="table table-bordered table-sm">
                          <thead> <!-- untuk memberikan nama pada kolom tabel -->
                              
                              <th style='background-color: #4CAF50; color: white'> Kode  </th>
                              <th style='background-color: #4CAF50; color: white'> Nama </th>
                              <th style='background-color: #4CAF50; color: white'> Dokter Pengirim </th>
                          <!--
                              <th style='background-color: #4CAF50; color: white'; text-align: right" > Jumlah </th>
                              <th style='background-color: #4CAF50; color: white'; text-align: right" > Harga </th>
                              <th style='background-color: #4CAF50; color: white'; text-align: right" > Subtotal </th>
                              <th style='background-color: #4CAF50; color: white'; text-align: right" > Potongan </th>
                              <th style='background-color: #4CAF50; color: white'; text-align: right" > Pajak </th>

                              -->

                              <th style='background-color: #4CAF50; color: white'> Hapus </th>
                          
                          </thead> <!-- tag penutup tabel -->
                    </table>
                  </div>

                </span>                

<?php if ($no_reg != ""): ?>

  <button class="btn btn-primary" type="button" data-toggle="collapse" data-target="#collapseExample" aria-expanded="false" aria-controls="collapseExample" id="rawat"><i class='fa fa-wheelchair-alt'> </i> Rawat Jalan / Inap / UGD</button>

       <?php if ($jenis_penjualan == 'Rawat Inap'): ?>

        <button class="btn btn-primary" type="button" id="btnOperasi" data-toggle="collapse" data-target="#collapseExampleops" aria-expanded="false" aria-controls="collapseExample"><i class='fa fa-plus-circle'> </i>
      Operasi  </button>
      <?php endif ?>

<?php endif ?>


 <div class="collapse" id="collapseExample">

                <table id="table-rawat" class="table table-sm">
                <thead>
                <th> Kode  </th>
                <th> Nama </th>
                <th> Nama Petugas </th>
                <th> Jumlah </th>
                <th> Satuan </th>
                <th> Dosis </th>
                <th align="right"> Harga </th>
                <th align="right"> Subtotal </th>
                <th align="right"> Potongan </th>
                <th align="right"> Pajak </th>
                
                </thead>
              
                
                </table>
               
 </div>

                <h6 style="text-align: left; color: red"><i><b> * Short Key (F2) untuk mencari Kode Produk atau Nama Produk.</b></i></h6>

  
</div> <!-- / END COL SM 6 (1)-->



<div class="col-xs-4">



<form action="proses_bayar_jual.php" id="form_jual" method="POST" >
    
    <style type="text/css">
    .disabled {
    opacity: 0.6;
    cursor: not-allowed;
    disabled: false;
    }
    </style>

  <div class="form-group">
    <div class="card card-block">
        <?php if ($no_reg == ""): ?>


      <div class="row">
      
        <div class="col-xs-6">          
           <label style="font-size:15px"> <b> Subtotal </b></label><br>
           <input style="height:25px;font-size:15px" type="text" name="total" id="total2" class="form-control" placeholder="Total" readonly="" >
        </div>

                  <?php
                  $ambil_diskon_tax = $db->query("SELECT diskon_nominal, diskon_persen, tax FROM setting_diskon_tax");
                  $data_diskon = mysqli_fetch_array($ambil_diskon_tax);

                  ?>

        <div class="col-xs-6">
            <label>Biaya Admin </label><br>
              <select class="form-control chosen" id="biaya_admin_select" name="biaya_admin_select" >
              <option value="0"> Silahkan Pilih </option>
                <?php 
                $query_biaya_admin = $db->query("SELECT persentase, nama FROM biaya_admin");
                while ( $data_biaya_admin = mysqli_fetch_array($query_biaya_admin))
                {
                echo "<option value='".$data_biaya_admin['persentase']."'>".$data_biaya_admin['nama']."</option>";
                }
                ?>
              </select>
        </div>
          
      </div>
      
      <div class="row">

          <div class="col-xs-6">          
            <label>Biaya Admin (Rp)</label>
            <input type="text" name="biaya_admin_rupiah" style="height:15px;font-size:15px" id="biaya_admin" class="form-control" placeholder="Biaya Admin Rp" autocomplete="off" onkeydown="return numbersonly(this, event);" onkeyup="javascript:tandaPemisahTitik(this);">
           </div>

          <div class="col-xs-6">
            <label>Biaya Admin (%)</label>
            <input type="text" name="biaya_admin_persen" style="height:15px;font-size:15px" id="biaya_admin_persen" class="form-control" placeholder="Biaya Admin %" autocomplete="off" >
          </div>

    </div> 
          
          <div class="row">

            <div class="col-xs-6">
          <label> Diskon ( Rp )</label><br>
          <input type="text" name="potongan" style="height:25px;font-size:15px" id="potongan_penjualan" value="<?php echo $data_diskon['diskon_nominal']; ?>" class="form-control" placeholder="" autocomplete="off"  onkeydown="return numbersonly(this, event);" onkeyup="javascript:tandaPemisahTitik(this);">
            
          </div>

          <div class="col-xs-6">
            <label> Diskon ( % )</label><br>
          <input type="text" name="potongan_persen" style="height:25px;font-size:15px" id="potongan_persen" value="<?php echo $data_diskon['diskon_persen']; ?>" class="form-control" placeholder="" autocomplete="off" >
          </div>

            <div class="col-xs-4" style="display: none;">
           <label> Pajak (%)</label>
           <input type="text" name="tax" id="tax" style="height:25px;font-size:15px" value="<?php echo $data_diskon['tax']; ?>" style="height:25px;font-size:15px" class="form-control" autocomplete="off" >

           </div>

          </div>
          

          <div class="row">

           <input type="hidden" name="tax_rp" id="tax_rp" class="form-control"  autocomplete="off" >
           
           <label style="display: none"> Adm Bank  (%)</label>
           <input type="hidden" name="adm_bank" id="adm_bank"  value="" class="form-control" >
           
           <div class="col-xs-6">
           <label> Tanggal</label>
           <input type="text" name="tanggal_jt" id="tanggal_jt"  value="" style="height:25px;font-size:15px" placeholder="Tanggal JT" class="form-control" >

           </div>

        <div class="col-xs-6">
            <label style="font-size:15px"> <b> Cara Bayar (F4) </b> </label><br>
                      <select type="text" name="cara_bayar" id="carabayar1" class="form-control chosen" required=""  style="font-size: 15px" >
                      <option value=""> Silahkan Pilih </option>
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

           </div>

    
           
           

      <div class="row">
       
        <div class="col-xs-6">

           <label style="font-size:15px"> <b> Total Akhir </b></label><br>
           <b><input type="text" name="total" id="total1" class="form-control" style="height: 25px; width:90%; font-size:20px;" placeholder="Total" readonly="" ></b>
          
        </div>
 
            <div class="col-xs-6">
              
           <label style="font-size:15px">  <b> Pembayaran (F7)</b> </label><br>
           <b><input type="text" name="pembayaran" id="pembayaran_penjualan" style="height: 20px; width:90%; font-size:20px;" autocomplete="off" class="form-control"   style="font-size: 20px"  onkeydown="return numbersonly(this, event);" onkeyup="javascript:tandaPemisahTitik(this);"></b>

            </div>
      </div>
           
           
          <div class="row">
            <div class="col-xs-6">
              
           <label> Kembalian </label><br>
           <b><input type="text" name="sisa_pembayaran"  id="sisa_pembayaran_penjualan"  style="height:25px;font-size:15px" class="form-control"  readonly="" required=""></b>
            </div>

            <div class="col-xs-6">
              
          <label> Kredit </label><br>
          <b><input type="text" name="kredit" id="kredit" class="form-control"  style="height:25px;font-size:15px"  readonly="" required="" ></b>
            </div>
          </div> 
          


           
           <label> Keterangan </label><br>
           <textarea style="height:40px;font-size:15px" type="text" name="keterangan" id="keterangan" class="form-control"> 
           </textarea>



          
          
          <?php 
          
          if ($_SESSION['otoritas'] == 'Pimpinan') {
          echo '<label style="display:none"> Total Hpp </label><br>
          <input type="hidden" name="total_hpp" id="total_hpp" style="height: 50px; width:90%; font-size:25px;" class="form-control" placeholder="" readonly="" required="">';
          }
          
          
          //Untuk Memutuskan Koneksi Ke Database
          mysqli_close($db);   
          ?>

        <?php else: ?>
          <div class="row">
            <div class="col-xs-6">          
              <label style="font-size:15px"> <b> Subtotal Keseluruhan</b></label><br>
              <input style="height:25px;font-size:15px" type="text" name="total" id="total2" class="form-control" placeholder="Subtotal Keseluruhan" readonly="" >
            </div>

            <div class="col-xs-6">
              <label style="font-size:15px"> <b> Subtotal Radiologi</b></label><br>
              <input style="height:25px;font-size:15px" type="text" name="total" id="sub_radiologi" class="form-control" placeholder="Subtotal Radiologi" readonly="" >
            </div>
          </div>

          <?php
                  $ambil_diskon_tax = $db->query("SELECT diskon_nominal, diskon_persen, tax FROM setting_diskon_tax");
                  $data_diskon = mysqli_fetch_array($ambil_diskon_tax);

                  ?>

          <div class="col-xs-6" style="display: none">
            <label>Biaya Admin </label><br>
              <select class="form-control chosen" id="biaya_admin_select" name="biaya_admin_select" >
              <option value="0"> Silahkan Pilih </option>
                <?php 
                $query_biaya_admin = $db->query("SELECT persentase, nama FROM biaya_admin");
                while ( $data_biaya_admin = mysqli_fetch_array($query_biaya_admin))
                {
                echo "<option value='".$data_biaya_admin['persentase']."'>".$data_biaya_admin['nama']."</option>";
                }
                ?>
              </select>
        </div>

      </div>
      
      <div class="row">

          <div class="col-xs-6" style="display: none">          
            <label>Biaya Admin (Rp)</label>
            <input type="text" name="biaya_admin_rupiah" style="height:15px;font-size:15px" id="biaya_admin" class="form-control" placeholder="Biaya Admin Rp" autocomplete="off" onkeydown="return numbersonly(this, event);" onkeyup="javascript:tandaPemisahTitik(this);">
           </div>

          <div class="col-xs-6" style="display: none">
            <label>Biaya Admin (%)</label>
            <input type="text" name="biaya_admin_persen" style="height:15px;font-size:15px" id="biaya_admin_persen" class="form-control" placeholder="Biaya Admin %" autocomplete="off" >
          </div>

      </div> 
          
          <div class="row">

            <div style="display: none" class="col-xs-4">
          <label> Diskon ( Rp )</label><br>
          <input type="text" name="potongan" style="height:25px;font-size:15px" id="potongan_penjualan" value="<?php echo $data_diskon['diskon_nominal']; ?>" class="form-control" placeholder="" autocomplete="off"  onkeydown="return numbersonly(this, event);" onkeyup="javascript:tandaPemisahTitik(this);">
            
          </div>

          <div style="display: none" class="col-xs-4">
            <label> Diskon ( % )</label><br>
          <input type="text" name="potongan_persen" style="height:25px;font-size:15px" id="potongan_persen" value="<?php echo $data_diskon['diskon_persen']; ?>" class="form-control" placeholder="" autocomplete="off" >
          </div>

          <div style="display: none;" class="col-xs-4">
           <label> Pajak (%)</label>
           <input type="text" name="tax" id="tax" style="height:25px;font-size:15px" value="<?php echo $data_diskon['tax']; ?>" style="height:25px;font-size:15px" class="form-control" autocomplete="off" >
          </div>


          </div>
          

          <div class="row">

           <input type="hidden" name="tax_rp" id="tax_rp" class="form-control"  autocomplete="off" >
           
           <label style="display: none"> Adm Bank  (%)</label>
           <input type="hidden" name="adm_bank" id="adm_bank"  value="" class="form-control" >
           
           <div style="display: none" class="col-xs-6">
           <label> Tanggal</label>
           <input type="text" name="tanggal_jt" id="tanggal_jt"  value="" style="height:25px;font-size:15px" placeholder="Tanggal JT" class="form-control" >

           </div>

        <div style="display: none" class="col-xs-6">
            <label style="font-size:15px"> <b> Cara Bayar (F4) </b> </label><br>
                      <select type="text" name="cara_bayar" id="carabayar1" class="form-control" required=""  style="font-size: 15px" >
                      <option value=""> Silahkan Pilih </option>
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

           </div>

    
           
           
      <div class="form-group">
      <div class="row">
       
        <div style="display: none" class="col-xs-6">

           <label style="font-size:15px"> <b> Total Akhir </b></label><br>
           <b><input type="text" name="total" id="total1" class="form-control" style="height: 25px; width:90%; font-size:20px;" placeholder="Total" readonly="" ></b>
          
        </div>
 
            <div style="display: none" class="col-xs-6">
              
           <label style="font-size:15px">  <b> Pembayaran (F7)</b> </label><br>
           <b><input type="text" name="pembayaran" id="pembayaran_penjualan" style="height: 20px; width:90%; font-size:20px;" autocomplete="off" class="form-control"   style="font-size: 20px"  onkeydown="return numbersonly(this, event);" onkeyup="javascript:tandaPemisahTitik(this);"></b>

            </div>
      </div>
           
           
          <div class="row">
            <div style="display: none" class="col-xs-6">
              
           <label> Kembalian </label><br>
           <b><input type="text" name="sisa_pembayaran"  id="sisa_pembayaran_penjualan"  style="height:25px;font-size:15px" class="form-control"  readonly="" required=""></b>
            </div>

            <div style="display: none" class="col-xs-6">
              
          <label> Kredit </label><br>
          <b><input type="text" name="kredit" id="kredit" class="form-control"  style="height:25px;font-size:15px"  readonly="" required="" ></b>
            </div>
          </div> 
          


           <div style="display: none" class="col-xs-12">
           <label> Keterangan </label><br>
           <textarea style="height:40px;font-size:15px" type="text" name="keterangan" id="keterangan" class="form-control"> 
           </textarea>
           </div>

        <?php endif ?>
    </div><!-- END card-block -->
  </div>

        <?php if ($no_reg == ""): ?>
          
          <input style="height:15px" type="hidden" name="jumlah" id="jumlah1" class="form-control" placeholder="jumlah">
          
          
          <!-- memasukan teks pada kolom kode pelanggan, dan nomor faktur penjualan namun disembunyikan -->

          
          <input type="hidden" name="kode_pelanggan" id="k_pelanggan" class="form-control" required="" >
          <input type="hidden" name="ppn_input" id="ppn_input" value="Include" class="form-control" placeholder="ppn input">

      

          <div class="row"> 

               
                <button type="submit" id="penjualan" class="btn btn-info" style="font-size:15px">Bayar (F8)</button>

                <button type="submit" id="transaksi_baru" style="display: none" class="btn btn-info" style="font-size:15px;"> Transaksi Baru </button>
                <button type="submit" id="piutang" class="btn btn-warning" style="font-size:15px">Piutang (F9)</button>

                <a href='cetak_penjualan_piutang.php' id="cetak_piutang" style="display: none;" class="btn btn-success" target="blank">Cetak Piutang  </a>     
                <a href='cetak_penjualan_tunai.php' id="cetak_tunai" style="display: none;" class="btn btn-primary" target="blank"> Cetak Tunai  </a>
                <button type="submit" id="batal_penjualan" class="btn btn-danger" style="font-size:15px">  Batal (Ctrl + B)</button>

                <button type="submit" id="cetak_langsung" target="blank" class="btn btn-success" style="font-size:15px"> Bayar / Cetak (Ctrl + K) </button>

                <a href='cetak_penjualan_tunai_besar.php' id="cetak_tunai_besar" style="display: none;" class="btn btn-warning" target="blank"> Cetak Tunai  Besar </a> 

            

          </div> <!--row 3-->
        <?php else: ?>


              <?php if ($jenis_penjualan == 'Rawat Jalan'): ?>
                  <button class="btn btn-warning" id="raja"> <i class="fa fa-reply-all"></i> Kembali Rawat Jalan </button>
              <?php endif ?>

              <?php if ($jenis_penjualan == 'Rawat Inap'): ?>
                  <button class="btn btn-warning" id="ranap"> <i class="fa fa-reply-all"></i> Kembali Rawat Inap </button>
              <?php endif ?>

              <?php if ($jenis_penjualan == 'UGD'): ?>
                  <button class="btn btn-warning" id="ugd"> <i class="fa fa-reply-all"></i> Kembali UGD </button>
              <?php endif ?>

        <?php endif ?>


          <input  name="total_rj_ri" type="hidden" style="height:15px;" id="total_rj_ri" class="form-control" required="" autofocus="" value="<?php echo $data_rj_ri['total_rj_ri']; ?>" >
          
          <input  name="total_ops" type="hidden" style="height:15px;" id="total_ops" class="form-control" required="" autofocus="" value="<?php echo $data_ops['total_ops']; ?>" >

          
          <div class="alert alert-success" id="alert_berhasil" style="display:none">
          <strong>Success!</strong> Pembayaran Berhasil
          </div>
     

    </form>


</div><!-- / END COL SM 6 (2)-->


</div><!-- end of row -->

</div><!-- end of container -->


    
<script>
//untuk menampilkan data tabel
$(document).ready(function(){
    $("#kode_barang").trigger('chosen:open');

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
              url :"data_tbs_penjualan_radiologi.php", // json datasource
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

// END DATATABLE AJAX END DATATABLE AJAX END DATATABLE AJAX END DATATABLE AJAX END DATATABLE AJAX END DATATABLE AJAX

  });
</script>

<script type="text/javascript">

$(document).ready(function(){
  //Hitung Biaya Admin

  $("#biaya_admin_select").change(function(){
  
  var biaya_admin = $("#biaya_admin_select").val();  
  var total2 = bersihPemisah(bersihPemisah(bersihPemisah(bersihPemisah($("#total2").val()))));
  var total1 = bersihPemisah(bersihPemisah(bersihPemisah(bersihPemisah($("#total1").val()))));
  var diskon = bersihPemisah(bersihPemisah(bersihPemisah(bersihPemisah($("#potongan_penjualan").val()))));
      if(diskon == '')
      {
      diskon = 0
      }

  var data_admin = biaya_admin;

  if (biaya_admin == 0) {
      var hasilnya = parseInt(total2,10) - parseInt(diskon,10);
      $("#total1").val(tandaPemisahTitik(hasilnya));
      $("#biaya_admin").val(0);
      $("#biaya_admin_persen").val(data_admin);

  }
  else if (biaya_admin > 0) {

      var hitung_biaya = parseInt(total2,10) * parseInt(data_admin,10) / 100;
       if (total2 == "" || total2 == 0) {
       hitung_biaya = 0;
       }

      $("#biaya_admin").val(Math.round(hitung_biaya));
      var biaya_admin = bersihPemisah(bersihPemisah(bersihPemisah(bersihPemisah($("#biaya_admin").val()))));      
      var hasilnya = parseInt(total2,10) + parseInt(biaya_admin,10) - parseInt(diskon,10);

        if (total2 == "" || total2 == 0) {
        hasilnya = 0;
        }

      $("#total1").val(tandaPemisahTitik(hasilnya));
      $("#biaya_admin_persen").val(data_admin);
      


  }
      
    });
});
//end Hitu8ng Biaya Admin
</script>

<!--
<script type="text/javascript" language="javascript" >

$(document).ready(function() {

          var dataTable = $('#table-radioogi').DataTable( {
          "processing": true,
          "serverSide": true,
          "info": true,
          "ajax":{
            url :"modal_jual_baru_radiologi.php", // json datasource
            type: "post",  // method  , by default get
            error: function(){  // error handling
              $(".tbody").html("");
              $("#table-radioogi").append('<tbody class="tbody"><tr><th colspan="3">No data found in the server</th></tr></tbody>');
              $("#table-radioogi_processing").css("display","none");
              
            }
          },
              "fnCreatedRow": function( nRow, aData, iDataIndex ) {
              $(nRow).attr('class','pilih');
              $(nRow).attr('data-kode',aData[0]);
              $(nRow).attr('id-barang',aData[11]);
              $(nRow).attr('data-nama',aData[1]);
              $(nRow).attr('data-kontras',aData[12]);
              $(nRow).attr('data-1',aData[3]);
              $(nRow).attr('data-2',aData[4]);
              $(nRow).attr('data-3',aData[5]);
              $(nRow).attr('data-4',aData[6]);
              $(nRow).attr('data-5',aData[7]);
              $(nRow).attr('data-6',aData[8]);
              $(nRow).attr('data-7',aData[9]);

    },
 } );
   } );        
         
</script>
-->



<!--untuk memasukkan perintah java script-->
<script type="text/javascript">

// jika dipilih, nim akan masuk ke input dan modal di tutup
  $(document).on('click', '.pilih', function (e) {


  document.getElementById("kode_barang").value = $(this).attr('data-kode');
  $("#kode_barang").trigger('chosen:updated');
  document.getElementById("nama_barang").value = $(this).attr('data-nama');
  document.getElementById("kontras").value = $(this).attr('data-kontras');
  document.getElementById("id_radiologi").value = $(this).attr('id-barang');


    var session_id = $("#session_id").val();
    var kode_barang = $("#kode_barang").val();
    var no_reg = $("#no_reg").val();
 $.post('cek_tbs_penjualan_radiologi.php',{kode_barang:kode_barang,session_id:session_id,no_reg:no_reg}, function(data){
  
  if(data == 1){
    alert("Anda Tidak Bisa Menambahkan Barang Yang Sudah Ada, Silakan Edit atau Pilih Barang Yang Lain !");
    $("#kode_barang").trigger('chosen:open');
    $("#kode_barang").val('');
    $("#nama_barang").val('');
   }//penutup if

    });////penutup function(data)


var level_harga = $("#level_harga").val();

var harga_level_1 = $(this).attr('data-1');
var harga_level_2 = $(this).attr('data-2');  
var harga_level_3 = $(this).attr('data-3');
var harga_level_4 = $(this).attr('data-4');
var harga_level_5 = $(this).attr('data-5');  
var harga_level_6 = $(this).attr('data-6');
var harga_level_7 = $(this).attr('data-7');

if (level_harga == "harga_1") {
  $("#harga_produk").val(harga_level_1);
    $("#harga_baru").val(harga_level_1);
  $("#harga_penjamin").val(harga_level_1);
}

else if (level_harga == "harga_2") {
  $("#harga_produk").val(harga_level_2);
    $("#harga_baru").val(harga_level_2);
  $("#harga_penjamin").val(harga_level_2);
}

else if (level_harga == "harga_3") {
  $("#harga_produk").val(harga_level_3);
    $("#harga_baru").val(harga_level_3);
  $("#harga_penjamin").val(harga_level_3);
}

else if (level_harga == "harga_4") {
  $("#harga_produk").val(harga_level_4);
    $("#harga_baru").val(harga_level_4);
  $("#harga_penjamin").val(harga_level_4);
}

else if (level_harga == "harga_5") {
  $("#harga_produk").val(harga_level_5);
    $("#harga_baru").val(harga_level_5);
  $("#harga_penjamin").val(harga_level_5);
}

else if (level_harga == "harga_6") {
  $("#harga_produk").val(harga_level_6);
    $("#harga_baru").val(harga_level_6);
  $("#harga_penjamin").val(harga_level_6);
}

else if (level_harga == "harga_7") {
  $("#harga_produk").val(harga_level_7);
    $("#harga_baru").val(harga_level_7);
  $("#harga_penjamin").val(harga_level_7);
}


  $('#myModal').modal('hide'); 
  $("#jumlah_barang").focus();


});

  </script>

<!--<script type="text/javascript">

    $("#kode_barang").blur(function(){

          var kode_barang = $(this).val();

          var kode_barang = kode_barang.substr(0, kode_barang.indexOf('('));
          var level_harga = $("#level_harga").val();
          var session_id = $("#session_id").val();
          
         var penjamin = $("#penjamin").val();

          var no_reg = $("#no_reg").val();
         $.post('cek_tbs_penjualan_radiologi.php',{kode_barang:kode_barang, session_id:session_id,no_reg:no_reg}, function(data){
          
          if(data == 1){
            alert("Anda Tidak Bisa Menambahkan Barang Yang Sudah Ada, Silakan Edit atau Pilih Barang Yang Lain !");
            $("#kode_barang").trigger('chosen:open');
            $("#kode_barang").val('');
            $("#nama_barang").val('');
           }//penutup if

            });////penutup function(data)

      $.getJSON('lihat_nama_jasa_lab.php',{kode_barang:kode_barang}, function(json){
      
      if (json == null)
      {
        
        $('#nama_barang').val('');
        $('#bidang').val('');
        $('#harga_produk').val('');
        $('#harga_baru').val('');
        $('#id_radiologi').val('');
        $('#ber_stok').val('');

      }

      else 
      {
         if (level_harga == "harga_1") {
          $("#harga_produk").val(json.harga_1);
            $("#harga_baru").val(json.harga_1);
          $("#harga_penjamin").val(json.harga_1);
        }
        else if (level_harga == "harga_2") {
          $("#harga_produk").val(json.harga_2);
            $("#harga_baru").val(json.harga_2);
          $("#harga_penjamin").val(json.harga_2);
        }

        else if (level_harga == "harga_3") {
          $("#harga_produk").val(json.harga_3);
            $("#harga_baru").val(json.harga_3);
          $("#harga_penjamin").val(json.harga_3);
        }

        else if (level_harga == "harga_4") {
          $("#harga_produk").val(json.harga_4);
            $("#harga_baru").val(json.harga_4);
          $("#harga_penjamin").val(json.harga_4);
        }

        else if (level_harga == "harga_5") {
          $("#harga_produk").val(json.harga_5);
            $("#harga_baru").val(json.harga_5);
          $("#harga_penjamin").val(json.harga_5);
        }

        else if (level_harga == "harga_6") {
          $("#harga_produk").val(json.harga_6);
            $("#harga_baru").val(json.harga_6);
          $("#harga_penjamin").val(json.harga_6);
        }

        else if (level_harga == "harga_7") {
          $("#harga_produk").val(json.harga_7);
            $("#harga_baru").val(json.harga_7);
          $("#harga_penjamin").val(json.harga_7);
        }

        $('#persiapan').val(json.persiapan);
        $('#nama_barang').val(json.nama);
        $('#id_radiologi').val(json.id);
        $('#bidang').val(json.bidang);
      }
                                              
        });
        
        });
// /KODE BARANG BLUR
  });
</script>-->


<script type="text/javascript">
  
  $(document).ready(function(){
  $("#kode_barang").change(function(){

    var kode_barang = $(this).val();
    var nama_barang = $('#opt-produk-'+kode_barang).attr("nama_pemeriksaan");
    var harga1 = $('#opt-produk-'+kode_barang).attr("harga_1");
    var harga2 = $('#opt-produk-'+kode_barang).attr('harga_2');  
    var harga3 = $('#opt-produk-'+kode_barang).attr('harga_3');
    var harga4 = $('#opt-produk-'+kode_barang).attr('harga_4');
    var harga5 = $('#opt-produk-'+kode_barang).attr('harga_5');  
    var harga6 = $('#opt-produk-'+kode_barang).attr('harga_6');
    var harga7 = $('#opt-produk-'+kode_barang).attr('harga_7');
    var id_radiologi = $('#opt-produk-'+kode_barang).attr("id-barang");
    var kontras = $('#opt-produk-'+kode_barang).attr("kontras");
    
    var level_harga = $("#level_harga").val();
    var session_id = $("#session_id").val();
    var no_reg = $("#no_reg").val();



    if (level_harga == "harga_1") {

        $('#harga_produk').val(harga1);
        $('#harga_baru').val(harga1);
        $('#harga_penjamin').val(harga1);
        $('#kolom_cek_harga').val('1');

        }
    else if (level_harga == "harga_2") {

        $('#harga_produk').val(harga2);
        $('#harga_baru').val(harga2);
        $('#harga_penjamin').val(harga2);
        $('#kolom_cek_harga').val('1');

        }
    else if (level_harga == "harga_3") {

        $('#harga_produk').val(harga3);
        $('#harga_baru').val(harga3);
        $('#harga_penjamin').val(harga3);
        $('#kolom_cek_harga').val('1');

        }
    else if (level_harga == "harga_4") {

        $('#harga_produk').val(harga4);
        $('#harga_baru').val(harga4);
        $('#harga_penjamin').val(harga4);
         $('#kolom_cek_harga').val('1');

        }
    else if (level_harga == "harga_5") {

        $('#harga_produk').val(harga5);
        $('#harga_baru').val(harga5);
        $('#harga_penjamin').val(harga5);
        $('#kolom_cek_harga').val('1');

        }
    else if (level_harga == "harga_6") {

        $('#harga_produk').val(harga6);
        $('#harga_baru').val(harga6);
        $('#harga_penjamin').val(harga6);
        $('#kolom_cek_harga').val('1');

        }
    else if (level_harga == "harga_7") {

        $('#harga_produk').val(harga7);
        $('#harga_baru').val(harga7);
        $('#harga_penjamin').val(harga7);
        $('#kolom_cek_harga').val('1');

        }


        $('#nama_barang').val(nama_barang);
        $('#id_radiologi').val(id_radiologi);
        $('#kontras').val(kontras);


 $.post('cek_tbs_penjualan_radiologi.php',{kode_barang:kode_barang,session_id:session_id,no_reg:no_reg}, function(data){
          
          if(data == 1){
            alert("Anda Tidak Bisa Menambahkan Barang Yang Sudah Ada, Silakan Edit atau Pilih Barang Yang Lain !");
            $("#kode_barang").val('');
            $("#kode_barang").trigger('chosen:updated');
            $("#kode_barang").trigger('chosen:open');
            $("#nama_barang").val('');
           }//penutup if   


  });
  });
  });
</script>



<script type="text/javascript">
$(document).ready(function(){
  //end cek level harga
  $("#level_harga").change(function(){
    
  var id_produk = $("#id_radiologi").val();
  var level_harga = $("#level_harga").val();
  var jumlah_barang = $("#jumlah_barang").val();

$.post("cek_level_harga_radiologi.php", {id_produk:id_produk,level_harga:level_harga,jumlah_barang:jumlah_barang},function(data){
data = data.replace(/\s+/g, '');
          $("#harga_produk").val(data);
          $("#harga_baru").val(data);
          $("#harga_penjamin").val(data);
          $('#kolom_cek_harga').val('1');
        });
    });
});
//end cek level harga
</script>






      <script type="text/javascript">
      
      $(".chosen").chosen({no_results_text: "Maaf, Data Tidak Ada!",search_contains:true});  
      
      </script>

   <script>
   //untuk menampilkan data yang diambil pada form tbs penjualan berdasarkan id=formtambahproduk
$(document).on('click','#submit_produk',function(e){
    var no_rm = $("#kd_pelanggan1").val();
    var level_harga = $("#level_harga").val();
    var kode_barang = $("#kode_barang").val();
    var nama_barang = $("#nama_barang").val();
    var no_reg = $("#no_reg").val();
    var kontras = $("#kontras").val();
    var petugas_radiologi = $("#petugas_radiologi").val();
    var dokter_pemeriksa = $("#dokter_pemeriksa").val();
    var jumlah_barang = 1;
    var harga = bersihPemisah(bersihPemisah(bersihPemisah(bersihPemisah($("#harga_produk").val()))));



    if (harga == '') {
      harga = 0;
    }

    var potongan = bersihPemisah(bersihPemisah(bersihPemisah(bersihPemisah($("#potongan1").val()))));
        if (potongan == '') {
      potongan = 0;
    }
   
      var tax = bersihPemisah(bersihPemisah(bersihPemisah(bersihPemisah($("#tax1").val()))));
        if (tax == '') {
      tax = 0;
    }
    
    var ber_stok = $("#ber_stok").val();
    var ppn = $("#ppn").val();
    
    var dokter = $("#dokter").val();
    var penjamin = $("#penjamin").val();
    var tax_faktur = bersihPemisah(bersihPemisah(bersihPemisah(bersihPemisah($("#tax").val()))));



    var hargaa = bersihPemisah(bersihPemisah(bersihPemisah(bersihPemisah($("#harga_penjamin").val()))));

    var subtotal = bersihPemisah(bersihPemisah(bersihPemisah(bersihPemisah($("#total2").val()))));

    var data_admin = bersihPemisah(bersihPemisah(bersihPemisah(bersihPemisah($("#biaya_admin_persen").val()))));
    if (data_admin == '') {
      data_admin = 0;
    }

    var pot_fakt_per = bersihPemisah(bersihPemisah(bersihPemisah(bersihPemisah($("#potongan_persen").val()))));
    if (biaya_admin == '') {
      biaya_admin = 0;
    }

    var pot_fakt_rp = bersihPemisah(bersihPemisah(bersihPemisah(bersihPemisah($("#potongan_penjualan").val()))));
     if (subtotal == "") {
        subtotal = 0;
      };
if (ppn == 'Exclude') {
  
       
      var total1 = parseInt(jumlah_barang,10) * parseInt(hargaa,10) - parseInt(potongan,10);

         var total_tax_exclude = parseInt(total1,10) * parseInt(tax,10) / 100;

         
          var total = parseInt(total1,10) + parseInt(Math.round(total_tax_exclude,10));


    }
    else
    {
        var total = parseInt(jumlah_barang,10) * parseInt(hargaa,10) - parseInt(potongan,10);
    }

    var total_akhir1 = parseInt(subtotal,10) + parseInt(total,10);
    var biaya_admin = parseInt(total_akhir1,10) * parseInt(data_admin,10) / 100;


    if (pot_fakt_per == 0) {
      var potongaaan = pot_fakt_rp;

      var pot_fakt_per = parseInt(potongaaan,10) / parseInt(total_akhir1,10) * 100;

    var total_akhier = parseInt(total_akhir1,10) - parseInt(pot_fakt_rp,10);


         //Hitung pajak
        /*if (tax_faktur != 0 ) {
        var hasil_tax = parseInt(total_akhier,10) * parseInt(tax_faktur,10) / 100;

        }
        else
        {
        var hasil_tax = 0;
        }*/
    //end hitung pajak
    var total_akhir = parseInt(total_akhier,10) + parseInt(biaya_admin,10)


    }
    else if(pot_fakt_rp == 0)
    {
      var potongaaan = pot_fakt_per;
      var pos = potongaaan.search("%");
      var potongan_persen = bersihPemisah(bersihPemisah(bersihPemisah(bersihPemisah(potongaaan))));
          potongan_persen = potongan_persen.replace("%","");
      potongaaan = total_akhir1 * potongan_persen / 100;

        var total_akhier = parseInt(total_akhir1,10) - parseInt(potongaaan,10);


         //Hitung pajak
        /*if (tax_faktur != 0) {
        var hasil_tax = parseInt(total_akhier,10) * parseInt(tax_faktur,10) / 100;

        }
        else
        {
        var hasil_tax = 0;
        }*/
    //end hitung pajak
   var total_akhir = parseInt(total_akhier,10) + parseInt(biaya_admin,10)

    }
     else if(pot_fakt_rp != 0 && pot_fakt_per != 0)
    {
      var potongaaan = pot_fakt_per;
      var pos = potongaaan.search("%");
      var potongan_persen = bersihPemisah(bersihPemisah(bersihPemisah(bersihPemisah(potongaaan))));
          potongan_persen = potongan_persen.replace("%","");
      potongaaan = total_akhir1 * potongan_persen / 100;

     
       var total_akhier = parseInt(total_akhir1,10) - parseInt(potongaaan,10);


         //Hitung pajak
        /*if (tax_faktur != 0) {
        var hasil_tax = parseInt(total_akhier,10) * parseInt(tax_faktur,10) / 100;

        }
        else
        {
        var hasil_tax = 0;
        }*/
    //end hitung pajak

    var total_akhir = parseInt(total_akhier,10) + parseInt(biaya_admin,10)


    }

    if (no_reg != '') {

          var sub_radiologi = bersihPemisah(bersihPemisah(bersihPemisah(bersihPemisah($("#sub_radiologi").val()))));
          if (sub_radiologi == '') {
            sub_radiologi = 0;
          }

          var total1 = parseInt(jumlah_barang,10) * parseInt(hargaa,10) - parseInt(potongan,10);
          var hitung_lab = parseInt(total1,10) + parseInt(sub_radiologi,10);

    }

  if (kode_barang == '') {
      alert("Masukkan Dahulu Kode Barang ")
      $("#kode_barang").trigger('chosen:open');
    }
    else if (harga == 0) {

      alert("Harga barang ini Rp.0");
      $("#kode_barang").val('');          
      $("#kode_barang").trigger('chosen:updated');    
      $("#kode_barang").trigger('chosen:open');          
      $("#jumlah_barang").val('');

    }


else if (dokter_pemeriksa == ''){
  alert("Silakan Pilih Dokter Pemeriksa");
       $("#dokter_pemeriksa").trigger('chosen:open');
  }

else if (petugas_radiologi == ''){
  alert("Silakan Pilih Petugas Radiologi");
       $("#petugas_radiologi").trigger('chosen:open');
  }

  else 
  {

      $("#potongan_persen").val(Math.round(pot_fakt_per));
      $("#total1").val(tandaPemisahTitik(total_akhir));
      $("#potongan_penjualan").val(Math.round(potongaaan));
      $("#total2").val(tandaPemisahTitik(total_akhir1));
      if (no_reg != '') {
      $("#sub_radiologi").val(tandaPemisahTitik(hitung_lab));
      }
      $("#biaya_admin").val(Math.round(biaya_admin));

          $.post("proses_tbs_radiologi.php",{nama_barang:nama_barang,jumlah_barang:jumlah_barang,harga:harga,potongan:potongan,tax:tax,tipe_barang:ber_stok,no_rm:no_rm,penjamin:penjamin,hargaa:hargaa,ppn:ppn, kode_barang:kode_barang,no_reg:no_reg,dokter:dokter, kontras:kontras, dokter_pemeriksa:dokter_pemeriksa, petugas_radiologi:petugas_radiologi},function(data){ 
     

                   
                   
                 $("#ppn").attr("disabled", true);        
                 $("#kode_barang").val('');
                 $("#kode_barang").trigger('chosen:updated').trigger('chosen:open');
                 $("#nama_barang").val('');
                 $("#jumlah_barang").val('');
                 $("#potongan1").val(''); 
                 $("#tax1").val('');
                 $("#tipe_barang").val('');             
                 $("#harga_penjamin").val('');
                 $("#sisa_pembayaran_penjualan").val('');
                 $("#kredit").val('');
                 
                 });

      $('#tabel_tbs_radiologi').DataTable().destroy();
            var dataTable = $('#tabel_tbs_radiologi').DataTable( {
            "processing": true,
            "serverSide": true,
            "info":     false,
            "language": { "emptyTable":     "Tidak Ada Data" },
            "ajax":{
              url :"data_tbs_penjualan_radiologi.php", // json datasource
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
  
  } 


      
 });

    $("form").submit(function(){
    return false;
    
    });





   </script>


<!--   script untuk detail layanan PERUSAHAAN PENJAMIN-->
<script type="text/javascript">
     $("#lay").click(function() 
{   
    var penjamin = $("#penjamin").val();

                $.post("detail_layanan_perusahaan2.php",{penjamin:penjamin},function(data){
                    $("#tampil_layanan").html(data);
               $("#detail").modal('show');
          
                });
            });
//            tabel lookup mahasiswa         
</script>



<script>
   //perintah javascript yang diambil dari form proses_bayar_beli.php dengan id=form_beli
  $("#penjualan").click(function(){
        var dokter = $("#dokter").val()
        var penjamin = $("#penjamin").val()
        var sisa_pembayaran = bersihPemisah(bersihPemisah(bersihPemisah(bersihPemisah($("#sisa_pembayaran_penjualan").val()))));
        var kredit = bersihPemisah(bersihPemisah(bersihPemisah(bersihPemisah($("#kredit").val())))); 
        var kode_pelanggan = $("#kd_pelanggan1").val();  
        var tanggal_jt = $("#tanggal_jt").val();
        var total = bersihPemisah(bersihPemisah(bersihPemisah(bersihPemisah($("#total1").val())))); 
        var total2 = bersihPemisah(bersihPemisah(bersihPemisah(bersihPemisah( $("#total2").val() )))); 
        var potongan =  bersihPemisah(bersihPemisah(bersihPemisah(bersihPemisah($("#potongan_penjualan").val()))));
        var potongan_persen = $("#potongan_persen").val();
        var tax = bersihPemisah(bersihPemisah(bersihPemisah(bersihPemisah($("#tax_rp").val()))));
        var cara_bayar = $("#carabayar1").val();
        var pembayaran = bersihPemisah(bersihPemisah(bersihPemisah(bersihPemisah($("#pembayaran_penjualan").val()))));
        var total_hpp = $("#total_hpp").val();
        var harga = $("#harga_produk").val();
        var keterangan = $("#keterangan").val();
        var ber_stok = $("#ber_stok").val();
        var nama_pelanggan = $("#nama_pelanggan").val();
        var ppn_input = $("#ppn_input").val();
        var ppn = $("#ppn").val();
        var session_id = $("#session_id").val();
        var petugas_radiologi = $("#petugas_radiologi").val();
        var biaya_admin = bersihPemisah(bersihPemisah(bersihPemisah(bersihPemisah($("#biaya_admin").val()))));

        
        var sisa = pembayaran - total;
        
        var sisa_kredit = total - pembayaran;

 if (sisa_pembayaran < 0)
 {

  alert("Jumlah Pembayaran Tidak Mencukupi");

 }


else if (pembayaran == "") 
 {

alert("Pembayaran Harus Di Isi");

 }


 else if ( sisa < 0) 
 {

alert("Silakan Bayar Piutang");

 }
                else if (total ==  0 || total == "") 
        {
        
        alert("Anda Belum Melakukan Pemesanan");
        
        }

 else

 {

  $("#penjualan").hide();
  $("#cetak_langsung").hide();
  $("#batal_penjualan").hide();
  $("#piutang").hide();
  $("#transaksi_baru").show();


 $.post("cek_subtotal_radiologi.php",{total:total,potongan:potongan,tax:tax,biaya_admin:biaya_admin},function(data) {

  if (data == 1) {


 $.post("proses_bayar_jual_radiologi.php",{biaya_admin:biaya_admin,total2:total2,sisa_pembayaran:sisa_pembayaran,kredit:kredit,kode_pelanggan:kode_pelanggan,tanggal_jt:tanggal_jt,total:total,potongan:potongan,potongan_persen:potongan_persen,tax:tax,cara_bayar:cara_bayar,pembayaran:pembayaran,sisa:sisa,sisa_kredit:sisa_kredit,total_hpp:total_hpp,harga:harga,keterangan:keterangan,ber_stok:ber_stok,ppn_input:ppn_input,dokter:dokter,penjamin:penjamin, nama_pelanggan:nama_pelanggan, petugas_radiologi:petugas_radiologi},function(info) {

     var no_faktur = info;
     var kode_pelanggan = $('#kd_pelanggan').val();
     $("#cetak_tunai").attr('href', 'cetak_penjualan_tunai.php?no_faktur='+no_faktur+'');
     $("#cetak_tunai_besar").attr('href', 'cetak_besar_radiologi.php?no_faktur='+no_faktur+'');
     $("#alert_berhasil").show();
     $("#pembayaran_penjualan").val('');
     $("#sisa_pembayaran_penjualan").val('');
     $("#kredit").val('');
     $("#apoteker").val('')
     $("#no_resep_dokter").val('')
     $("#resep_dokter").val('')
     $("#penjamin").val('')
     $("#apoteker").val('')
     $("#kd_pelanggan").val('')
     $("#no_resep_dokter").val('')
     $("#resep_dokter").val('')
     $("#penjamin").val('')
     $("#cetak_tunai").show();
     $("#cetak_tunai_besar").show('');
    
       
   });

                      $('#tabel_tbs_radiologi').DataTable().destroy();

                          var dataTable = $('#tabel_tbs_radiologi').DataTable( {
                            "processing": true,
                            "serverSide": true,
                            "ajax":{
                              url :"data_tbs_penjualan_radiologi.php", // json datasource
                              "data": function ( d ) {
                                d.no_reg = $("#no_reg").val();
                                // d.custom = $('#myInput').val();
                                // etc
                              },
                              type: "post",  // method  , by default get
                              error: function(){  // error handling
                                $(".employee-grid-error").html("");
                                $("#tabel_tbs_radiologi").append('<tbody class="employee-grid-error"><tr><th colspan="3">No data found in the server</th></tr></tbody>');
                                $("#employee-grid_processing").css("display","none");
                                }
                            },
                               "fnCreatedRow": function( nRow, aData, iDataIndex ) {

                                $(nRow).attr('class','tr-id-'+aData[8]+'');         

                            }
                          });
                      $("#span_tbs").show();

}
  else{
    alert("Maaf Subtotal Penjualan Tidak Sesuai, Silakan Tunggu Sebentar!");       
        window.location.href="form_pemeriksaan_radiologi.php";
  }



  
 });

 $("form").submit(function(){
    return false;

});
}
});


      
  </script>

  <script>
   //perintah javascript yang diambil dari form proses_bayar_beli.php dengan id=form_beli
  $("#cetak_langsung").click(function(){

        var petugas_radiologi = $("#petugas_radiologi").val()
        var penjamin = $("#penjamin").val()
        var sisa_pembayaran = bersihPemisah(bersihPemisah(bersihPemisah(bersihPemisah($("#sisa_pembayaran_penjualan").val()))));
        var kredit = bersihPemisah(bersihPemisah(bersihPemisah(bersihPemisah($("#kredit").val())))); 
        var kode_pelanggan = $("#kd_pelanggan1").val(); 
        var tanggal_jt = $("#tanggal_jt").val();
        var total = bersihPemisah(bersihPemisah(bersihPemisah(bersihPemisah($("#total1").val())))); 
        var total2 = bersihPemisah(bersihPemisah(bersihPemisah(bersihPemisah( $("#total2").val() )))); 
        var potongan =  bersihPemisah(bersihPemisah(bersihPemisah(bersihPemisah($("#potongan_penjualan").val()))));
        var potongan_persen = $("#potongan_persen").val();
        var tax = bersihPemisah(bersihPemisah(bersihPemisah(bersihPemisah($("#tax_rp").val()))));
        var cara_bayar = $("#carabayar1").val();
        var pembayaran = bersihPemisah(bersihPemisah(bersihPemisah(bersihPemisah($("#pembayaran_penjualan").val()))));
        var total_hpp = $("#total_hpp").val();
        var harga = $("#harga_produk").val();
        var keterangan = $("#keterangan").val();
        var ber_stok = $("#ber_stok").val();
        var nama_pelanggan = $("#nama_pelanggan").val();
        var ppn_input = $("#ppn_input").val();
        var ppn = $("#ppn").val();
        var session_id = $("#session_id").val();
        var dokter = $("#dokter_pengirim").val();
        var biaya_admin = bersihPemisah(bersihPemisah(bersihPemisah(bersihPemisah($("#biaya_admin").val()))));

        
        var sisa = pembayaran - total;
        
        var sisa_kredit = total - pembayaran;

 if (sisa_pembayaran < 0)
 {

  alert("Jumlah Pembayaran Tidak Mencukupi");

 }


else if (pembayaran == "") 
 {

alert("Pembayaran Harus Di Isi");

 }


 else if ( sisa < 0) 
 {

alert("Silakan Bayar Piutang");

 }
                else if (total ==  0 || total == "") 
        {
        
        alert("Anda Belum Melakukan Pemesanan");
        
        }

 else

 {

  $("#penjualan").hide();
  $("#cetak_langsung").hide();
  $("#batal_penjualan").hide();
  $("#piutang").hide();
  $("#transaksi_baru").show();


 $.post("cek_subtotal_radiologi.php",{total:total,potongan:potongan,tax:tax,biaya_admin:biaya_admin},function(data) {

  if (data == 1) {

   $.post("proses_bayar_tunai_cetak_langsung_radiologi.php",{biaya_admin:biaya_admin,total2:total2,sisa_pembayaran:sisa_pembayaran,kredit:kredit,kode_pelanggan:kode_pelanggan,tanggal_jt:tanggal_jt,total:total,potongan:potongan,potongan_persen:potongan_persen,tax:tax,cara_bayar:cara_bayar,pembayaran:pembayaran,sisa:sisa,sisa_kredit:sisa_kredit,total_hpp:total_hpp,harga:harga,keterangan:keterangan,ber_stok:ber_stok,ppn_input:ppn_input,petugas_radiologi:petugas_radiologi,penjamin:penjamin, nama_pelanggan:nama_pelanggan, dokter:dokter},function(info) {


     var no_faktur = info;

     $("#alert_berhasil").show();
     $("#pembayaran_penjualan").val('');
     $("#sisa_pembayaran_penjualan").val('');
     $("#kredit").val('');
    
    var win = window.open('cetak_penjualan_tunai.php?no_faktur='+no_faktur+'');
     if (win) { 
    
    win.focus(); 
  } else { 
    
    alert('Mohon Izinkan PopUps Pada Website Ini !'); }    
    
       
   });

                         $('#tabel_tbs_radiologi').DataTable().destroy();

                          var dataTable = $('#tabel_tbs_radiologi').DataTable( {
                            "processing": true,
                            "serverSide": true,
                            "ajax":{
                              url :"data_tbs_penjualan_radiologi.php", // json datasource
                              "data": function ( d ) {
                                d.no_reg = $("#no_reg").val();
                                // d.custom = $('#myInput').val();
                                // etc
                              },
                              type: "post",  // method  , by default get
                              error: function(){  // error handling
                                $(".employee-grid-error").html("");
                                $("#tabel_tbs_radiologi").append('<tbody class="employee-grid-error"><tr><th colspan="3">No data found in the server</th></tr></tbody>');
                                $("#employee-grid_processing").css("display","none");
                                }
                            },
                               "fnCreatedRow": function( nRow, aData, iDataIndex ) {

                                $(nRow).attr('class','tr-id-'+aData[8]+'');         

                            }
                          });
                      $("#span_tbs").show();
  

  }
  else{
    alert("Maaf Subtotal Penjualan Tidak Sesuai, Silakan Tunggu Sebentar!");       
        window.location.href="form_pemeriksaan_radiologi.php";
  }

 });



 }

 $("form").submit(function(){
    return false;
 
});

});

   
      
  </script>
  
     <script>
       //perintah javascript yang diambil dari form proses_bayar_beli.php dengan id=form_beli
       $("#piutang").click(function(){

        var biaya_admin = bersihPemisah(bersihPemisah(bersihPemisah(bersihPemisah($("#biaya_admin").val()))));
        
        var penjamin = $("#penjamin").val();
        var dokter = $("#dokter_pengirim").val();
        var sisa_pembayaran = bersihPemisah(bersihPemisah(bersihPemisah(bersihPemisah($("#sisa_pembayaran_penjualan").val()))));
        var kredit = bersihPemisah(bersihPemisah(bersihPemisah(bersihPemisah($("#kredit").val() )))); 
        var tanggal_jt = $("#tanggal_jt").val();
        var total = bersihPemisah(bersihPemisah(bersihPemisah(bersihPemisah($("#total1").val())))); 
        var total2 = bersihPemisah(bersihPemisah(bersihPemisah(bersihPemisah($("#total2").val())))); 
        var potongan =  bersihPemisah(bersihPemisah(bersihPemisah(bersihPemisah($("#potongan_penjualan").val()))));
        var potongan_persen = $("#potongan_persen").val();
        var nama_pelanggan = $("#nama_pelanggan").val();
        var tax = bersihPemisah(bersihPemisah(bersihPemisah(bersihPemisah($("#tax_rp").val()))));
        var cara_bayar = $("#carabayar1").val();
        var biaya_admin = $("#biaya_admin").val();
        var petugas_radiologi = $("#petugas_radiologi").val();
        var pembayaran = bersihPemisah(bersihPemisah(bersihPemisah(bersihPemisah($("#pembayaran_penjualan").val()))));
        if (pembayaran == '') {
          pembayaran = 0;
        }
        var session_id = $("#session_id").val(); 
        var total_hpp = $("#total_hpp").val();     
        var keterangan = $("#keterangan").val();   
        var ber_stok = $("#ber_stok").val();
        var ppn_input = $("#ppn_input").val();
       
       var sisa =  pembayaran - total; 

       var sisa_kredit = total - pembayaran;
       var kode_pelanggan = $("#kd_pelanggan1").val();

       if (tanggal_jt == "")
       {

        alert ("Tanggal Jatuh Tempo Harus Di Isi");
        $("#tanggal_jt").focus();
         
       }
         else if ( total == "") 
         {
         
         alert("Anda Belum Melakukan Pesanan");
         
         }
         
       else
       {


        $("#piutang").hide();
        $("#batal_penjualan").hide();
        $("#penjualan").hide();
        $("#cetak_langsung").hide();
        $("#transaksi_baru").show();
        

 $.post("cek_subtotal_radiologi.php",{total:total,potongan:potongan,tax:tax,biaya_admin:biaya_admin},function(data) {


  if (data == 1) 
  {


       $.post("proses_bayar_jual_radiologi.php",{biaya_admin:biaya_admin,total2:total2,sisa_pembayaran:sisa_pembayaran,kredit:kredit,kode_pelanggan:kode_pelanggan,tanggal_jt:tanggal_jt,total:total,potongan:potongan,potongan_persen:potongan_persen,tax:tax,cara_bayar:cara_bayar,pembayaran:pembayaran,sisa:sisa,sisa_kredit:sisa_kredit,total_hpp:total_hpp,keterangan:keterangan,ber_stok:ber_stok,ppn_input:ppn_input,penjamin:penjamin,dokter:dokter, nama_pelanggan:nama_pelanggan, petugas_radiologi:petugas_radiologi},function(info) {

            var no_faktur = info;
            $("#cetak_piutang").attr('href','cetak_penjualan_piutang.php?no_faktur='+no_faktur+'');
            $("#table-baru").html(info);
            $("#alert_berhasil").show();
            $("#kd_pelanggan").val('');
            $("#pembayaran_penjualan").val('');
            $("#sisa_pembayaran_penjualan").val('');
            $("#kredit").val('');
            $("#potongan_penjualan").val('');
            $("#potongan_persen").val('');
            $("#tanggal_jt").val('');
            $("#cetak_piutang").show();
            $("#tax").val('');
            
       
       
       });

                             $('#tabel_tbs_radiologi').DataTable().destroy();

                          var dataTable = $('#tabel_tbs_radiologi').DataTable( {
                            "processing": true,
                            "serverSide": true,
                            "ajax":{
                              url :"data_tbs_penjualan_radiologi.php", // json datasource
                              "data": function ( d ) {
                                d.no_reg = $("#no_reg").val();
                                // d.custom = $('#myInput').val();
                                // etc
                              },
                              type: "post",  // method  , by default get
                              error: function(){  // error handling
                                $(".employee-grid-error").html("");
                                $("#tabel_tbs_radiologi").append('<tbody class="employee-grid-error"><tr><th colspan="3">No data found in the server</th></tr></tbody>');
                                $("#employee-grid_processing").css("display","none");
                                }
                            },
                               "fnCreatedRow": function( nRow, aData, iDataIndex ) {

                                $(nRow).attr('class','tr-id-'+aData[8]+'');         

                            }
                          });
                      $("#span_tbs").show();

  }
  else{
    alert("Maaf Subtotal Penjualan Tidak Sesuai, Silakan Tunggu Sebentar!");       
        window.location.href="form_pemeriksaan_radiologi.php";
  }

 });


       
       }  
       //mengambil no_faktur pembelian agar berurutan

       });
 $("form").submit(function(){
       return false;
       });

          

</script>



<script type="text/javascript">
        $(document).ready(function(){
        
    $("#potongan_persen").keyup(function(){

        var potongan_persen = bersihPemisah(bersihPemisah(bersihPemisah(bersihPemisah($("#potongan_persen").val()))));
        var pembayaran = bersihPemisah(bersihPemisah(bersihPemisah(bersihPemisah($("#pembayaran_penjualan").val()))));
        if (pembayaran == '') {
          pembayaran = 0;
        }
        var total = bersihPemisah(bersihPemisah(bersihPemisah(bersihPemisah( $("#total2").val() ))));
        var potongan_penjualan = ((total * potongan_persen) / 100);
        var tax = $("#tax").val();
        var tax_rp = bersihPemisah(bersihPemisah(bersihPemisah(bersihPemisah($("#tax_rp").val()))));
       var biaya_admin = bersihPemisah(bersihPemisah(bersihPemisah(bersihPemisah($("#biaya_admin").val()))));
        if (biaya_admin == '')
        {
          biaya_admin = 0;
        }

        if (tax == "") {
        tax = 0;
      }

      
        var sisa_potongan = parseInt(total,10) - parseInt(Math.round(potongan_penjualan,10));


             var t_tax = ((parseInt(sisa_potongan,10) * parseInt(tax,10)) / 100);
             var hasil_akhir = parseInt(sisa_potongan, 10) + parseInt(Math.round(t_tax,10)) + parseInt(biaya_admin,10);

            // hitungan jika potongan lebih dari 100 % 
          var taxxx = ((parseInt(total,10) * parseInt(tax,10)) / 100); 
          var toto = parseInt(total, 10) + parseInt(biaya_admin,10) + parseInt(Math.round(taxxx,10));       
         // end hitungan jika potongan lebih dari 100 %

         // hitung kembalian dan kredit


        if (potongan_persen > 100) {
          
          var sisa = pembayaran - Math.round(toto);
          var sisa_kredit = Math.round(toto) - pembayaran; 
        
              if (sisa < 0 )
              {
              $("#kredit").val( tandaPemisahTitik(sisa_kredit));
              $("#sisa_pembayaran_penjualan").val('0');
              $("#tanggal_jt").attr("disabled", false);
              
              }
              
              else  
              {
              
              $("#sisa_pembayaran_penjualan").val(tandaPemisahTitik(sisa));
              $("#kredit").val('0');
              $("#tanggal_jt").attr("disabled", true);
              
              } 
         // end hitung kembalian dan kredit
          alert ("Potongan %, Tidak Boleh Lebih Dari 100%");
          $("#potongan_persen").val('')
          $("#potongan_penjualan").val('')
          $("#total1").val(tandaPemisahTitik(Math.round(toto)));
          $("#tax_rp").val(Math.round(taxxx));
          $("#potongan_persen").focus()

        }
        else{

        var sisa = pembayaran - Math.round(hasil_akhir);
        var sisa_kredit = Math.round(hasil_akhir) - pembayaran; 
        
        if (sisa < 0 )
        {
        $("#kredit").val( tandaPemisahTitik(sisa_kredit));
        $("#sisa_pembayaran_penjualan").val('0');
        $("#tanggal_jt").attr("disabled", false);
        
        }
        
        else  
        {
        
        $("#sisa_pembayaran_penjualan").val(tandaPemisahTitik(sisa));
        $("#kredit").val('0');
        $("#tanggal_jt").attr("disabled", true);
        
        } 
         // end hitung kembalian dan kredit

                  $("#total1").val(tandaPemisahTitik(Math.round(hasil_akhir)));
                  $("#potongan_penjualan").val(tandaPemisahTitik(Math.round(potongan_penjualan)));
                  $("#tax_rp").val(Math.round(t_tax));
        }



      });





        $("#potongan_penjualan").keyup(function(){

        var potongan_penjualan =  bersihPemisah(bersihPemisah(bersihPemisah(bersihPemisah( $("#potongan_penjualan").val() ))));
        var biaya_admin = bersihPemisah(bersihPemisah(bersihPemisah(bersihPemisah($("#biaya_admin").val()))));
        if (biaya_admin == '') {
          biaya_admin = 0;
        }
        var pembayaran = bersihPemisah(bersihPemisah(bersihPemisah(bersihPemisah($("#pembayaran_penjualan").val()))));
         if (pembayaran == '') {
          pembayaran = 0;
        }

        var total1 = bersihPemisah(bersihPemisah(bersihPemisah(bersihPemisah( $("#total1").val() ))));
        var total = bersihPemisah(bersihPemisah(bersihPemisah(bersihPemisah($("#total2").val()))));
        var potongan_persen = ((potongan_penjualan / total) * 100);
        var tax = $("#tax").val();
        var tax_rp = bersihPemisah(bersihPemisah(bersihPemisah(bersihPemisah($("#tax_rp").val()))));

        if (tax == "") {
        tax = 0;
      }


        var sisa_potongan = total - Math.round(potongan_penjualan);
        
             var t_tax = ((parseInt(sisa_potongan,10) * parseInt(tax,10)) / 100);
             var hasil_akhir = parseInt(sisa_potongan, 10) + parseInt(Math.round(t_tax,10)) + parseInt(biaya_admin,10);

            // hitungan jika potongan lebih dari 100 %
          var taxxx = ((parseInt(total,10) * parseInt(tax,10)) / 100);
          var toto = parseInt(total, 10) + parseInt(biaya_admin,10) + parseInt(Math.round(taxxx,10));

            // end hitungan jika potongan lebih dari 100 % 


         if (potongan_persen > 100) {

          var sisa = pembayaran - Math.round(toto);
          var sisa_kredit = Math.round(toto) - pembayaran; 
        
              if (sisa < 0 )
              {
              $("#kredit").val( tandaPemisahTitik(sisa_kredit));
              $("#sisa_pembayaran_penjualan").val('0');
              $("#tanggal_jt").attr("disabled", false);
              
              }
              
              else  
              {
              
              $("#sisa_pembayaran_penjualan").val(tandaPemisahTitik(sisa));
              $("#kredit").val('0');
              $("#tanggal_jt").attr("disabled", true);
              
              } 

        alert ("Potongan %, Tidak Boleh Lebih Dari 100%");
            $("#potongan_persen").val('');
            $("#potongan_penjualan").val('');
            $("#total1").val(tandaPemisahTitik(Math.round(toto)));
            $("#tax_rp").val(Math.round(taxxx))
         }    
        else
        {

          var sisa = pembayaran - Math.round(hasil_akhir);
          var sisa_kredit = Math.round(hasil_akhir) - pembayaran; 
        
              if (sisa < 0 )
              {
              $("#kredit").val( tandaPemisahTitik(sisa_kredit));
              $("#sisa_pembayaran_penjualan").val('0');
              $("#tanggal_jt").attr("disabled", false);
              
              }
              
              else  
              {
              
              $("#sisa_pembayaran_penjualan").val(tandaPemisahTitik(sisa));
              $("#kredit").val('0');
              $("#tanggal_jt").attr("disabled", true);
              
              } 
        $("#total1").val(Math.round(hasil_akhir));
        $("#potongan_persen").val(Math.round(potongan_persen));
        $("#tax_rp").val(Math.round(t_tax))
        }

        
      });

        });
        
        </script>



<script type="text/javascript">
  $(document).ready(function(){
    
  //START KEYUP BIAYA ADMIN RUPIAH

    $("#biaya_admin").keyup(function(){
      var biaya_adm = bersihPemisah(bersihPemisah(bersihPemisah(bersihPemisah($("#biaya_admin").val()))));
      if (biaya_adm == '') {
        biaya_adm = 0;
      }
      var subtotal = bersihPemisah(bersihPemisah(bersihPemisah(bersihPemisah($("#total2").val()))));
      if (subtotal == '') {
        subtotal = 0;
      }
      var potongan = bersihPemisah(bersihPemisah(bersihPemisah(bersihPemisah($("#potongan_penjualan").val()))));
      if (potongan == '') {
        potongan = 0;
      }
      var pembayaran = bersihPemisah(bersihPemisah(bersihPemisah(bersihPemisah($("#pembayaran_penjualan").val()))));
      if (pembayaran == '') {
        pembayaran = 0;
      }  
      /*    
      var tax = bersihPemisah(bersihPemisah(bersihPemisah(bersihPemisah($("#tax").val()))));
      if (tax == '') {
        tax = 0;
      }*/

      var t_total = parseInt(subtotal,10) - parseInt(potongan,10);
      var biaya_admin_persen = parseInt(biaya_adm,10) / parseInt(subtotal,10) * 100;
      /*
      var t_tax = parseInt(t_total,10) * parseInt(tax,10) / 100;
      var total_akhir1 = parseInt(t_total,10) + Math.round(parseInt(t_tax,10));
      */

      var total_akhir = parseInt(t_total,10) + parseInt(Math.round(biaya_adm,10));


      $("#total1").val(tandaPemisahTitik(total_akhir));
      $("#biaya_admin_persen").val(Math.round(biaya_admin_persen));

      if (biaya_admin_persen > 100) {
            

            var total_akhir = parseInt(subtotal,10) - parseInt(potongan,10);
            alert ("Biaya Amin %, Tidak Boleh Lebih Dari 100%");
            $("#biaya_admin_persen").val('');
            $("#biaya_admin_select").val('0');            
            $("#biaya_admin_select").trigger('chosen:updated');
            $("#biaya_admin").val('');
            $("#biaya_admin").val('');
            $("#total1").val(tandaPemisahTitik(total_akhir));
          }
          
        else
          {
          }

    });

  //END KEYUP BIAYA ADMIN RUPIAH

  //START KEYUP BIAYA ADMIN PERSEN

    $("#biaya_admin_persen").keyup(function(){
      var biaya_admin_persen = bersihPemisah(bersihPemisah(bersihPemisah(bersihPemisah($("#biaya_admin_persen").val()))));
      if (biaya_admin_persen == '') {
        biaya_admin_persen = 0;
      }
      var subtotal = bersihPemisah(bersihPemisah(bersihPemisah(bersihPemisah($("#total2").val()))));
      if (subtotal == '') {
        subtotal = 0;
      }
      var potongan = bersihPemisah(bersihPemisah(bersihPemisah(bersihPemisah($("#potongan_penjualan").val()))));
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

      $("#total1").val(tandaPemisahTitik(total_akhir));
      $("#biaya_admin").val(Math.round(biaya_admin_rupiah));

      if (biaya_admin_persen > 100) {
            

            var total_akhir = parseInt(subtotal,10) - parseInt(potongan,10);
            alert ("Biaya Amin %, Tidak Boleh Lebih Dari 100%");
            $("#biaya_admin_persen").val('');
            $("#biaya_admin_select").val('0');            
            $("#biaya_admin_select").trigger('chosen:updated');
            $("#biaya_admin").val('');
            $("#total1").val(tandaPemisahTitik(total_akhir));
          }
          
        else
          {
          }

    });

  //END KEYUP BIAYA ADMIN PERSEN
  });
  
</script>



<!--
 PEMBAYARAN FOCUS
<script type="text/javascript">
        $(document).ready(function(){
        
        $("#pembayaran_penjualan").focus(function(){

        var potongan_persen = $("#potongan_persen").val();
        var total = bersihPemisah(bersihPemisah(bersihPemisah(bersihPemisah( $("#total2").val() ))));
        var potongan_penjualan = ((total * potongan_persen) / 100);
        var sisa_potongan = total - potongan_penjualan;
        
        if (potongan_persen > 100) {
          alert ("Potongan %, Tidak Boleh Lebih Dari 100%");
        }

        
        
        $("#total1").val(tandaPemisahTitik(parseInt(sisa_potongan)));
        $("#potongan_penjualan").val(tandaPemisahTitik(parseInt(potongan_penjualan)));

      

        var potongan_penjualan =  bersihPemisah(bersihPemisah(bersihPemisah(bersihPemisah( $("#potongan_penjualan").val() ))));
        var total = bersihPemisah(bersihPemisah(bersihPemisah(bersihPemisah($("#total2").val()))));
        var potongan_persen = ((potongan_penjualan / total) * 100);
        var sisa_potongan = total - potongan_penjualan;
        

        
        $("#total1").val(tandaPemisahTitik(parseInt(sisa_potongan)));
        $("#potongan_persen").val(parseInt(potongan_persen));



        var potongan = bersihPemisah(bersihPemisah(bersihPemisah(bersihPemisah($("#potongan_penjualan").val() ))));
        var potongan_persen = $("#potongan_persen").val();
        var total = bersihPemisah(bersihPemisah(bersihPemisah(bersihPemisah($("#total2").val() ))));
       
              var cara_bayar = $("#carabayar1").val();
              var tax = $("#tax").val();
              var t_total = total - potongan;

              if (tax == "") {
                tax = 0;
              }
              else if (cara_bayar == "") {
                alert ("Kolom Cara Bayar Masih Kosong");
                 $("#tax").val('');
                 $("#potongan_penjualan").val('');
                 $("#potongan_persen").val('');
              }
              
              var t_tax = ((parseInt(bersihPemisah(bersihPemisah(bersihPemisah(bersihPemisah(t_total,10))))) * parseInt(bersihPemisah(bersihPemisah(bersihPemisah(bersihPemisah(tax,10)))))) / 100);

              var total_akhir = parseInt(bersihPemisah(bersihPemisah(bersihPemisah(bersihPemisah(t_total,10))))) + Math.round(parseInt(t_tax,10));
              
              
              $("#total1").val(tandaPemisahTitik(total_akhir));

              if (tax > 100) {
                alert ('Jumlah Tax Tidak Boleh Lebih Dari 100%');
                 $("#tax").val('');

              }
        

        $("#tax_rp").val(parseInt(t_tax));


        });
        });
        
        </script>


-->




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


            $.get("cek_total_hpp.php",function(data){
            $("#total_hpp"). val(data);
            });
        
    });
});
</script>

        <script>
        
        //untuk menampilkan sisa penjualan secara otomatis
        $(document).ready(function(){
        $("#pembayaran_penjualan").keyup(function(){
        var pembayaran = bersihPemisah(bersihPemisah(bersihPemisah(bersihPemisah( $("#pembayaran_penjualan").val() ))));
        var total =  bersihPemisah(bersihPemisah(bersihPemisah(bersihPemisah( $("#total1").val() ))));
        var sisa = pembayaran - total;
        var sisa_kredit = total - pembayaran; 
        
        if (sisa < 0 )
        {
        $("#kredit").val( tandaPemisahTitik(sisa_kredit));  
        $("#sisa_pembayaran_penjualan").val('0');
        $("#tanggal_jt").attr("disabled", false);
        
        }
        
        else  
        {
        
        
        
        $("#sisa_pembayaran_penjualan").val(tandaPemisahTitik(sisa));
        $("#kredit").val('0');
        $("#tanggal_jt").attr("disabled", true);
        
        } 
        
        
        });
        
        
        });
        </script>

<!--
<script type="text/javascript">
  $("#potongan_persen").keyup(function(){

      var potongan_persen = $("#potongan_persen").val();
      if (potongan_persen == "")
      {
        potongan_persen = 0;
      }
      if (potongan_persen > 100){
              alert("Potongan Tidak Boleh Lebih Dari 100%")
              $("#potongan_persen").val('');
              $("#potongan_persen").focus();
             }
  });


    $(document).ready(function(){
    $("#potongan_penjualan").keyup(function(){
             var potongan_penjualan =  bersihPemisah(bersihPemisah(bersihPemisah(bersihPemisah( $("#potongan_penjualan").val() ))));
             var total = bersihPemisah(bersihPemisah(bersihPemisah(bersihPemisah($("#total2").val()))));
              var biaya_admin = bersihPemisah(bersihPemisah(bersihPemisah(bersihPemisah($("#biaya_admin").val()))));
              if (biaya_admin == "")
        {
          biaya_admin = 0;
        }
             var pembayaran = bersihPemisah(bersihPemisah(bersihPemisah(bersihPemisah($("#pembayaran_penjualan").val()))));
             var tax = $("#tax").val();

     
             var potongan_persen = ((potongan_penjualan / total) * 100);
             var hasil_admin = parseInt(total, 10) + parseInt(biaya_admin, 10)
             var sisa_potongan = hasil_admin - potongan_penjualan;
             var kredit = parseInt(sisa_potongan, 10) - parseInt(pembayaran,10);
             var kembalian = parseInt(pembayaran,10) - parseInt(sisa_potongan, 10);
             var t_tax = ((parseInt(sisa_potongan,10) * parseInt(tax,10)) / 100);
             var hasil_akhir = parseInt(sisa_potongan, 10) + parseInt(t_tax,10);
      
             
      if (kembalian < 0) {
      $("#kredit").val(kredit);
      $("#sisa_pembayaran_penjualan").val('0');
      }
      if (kredit < 0) {
      $("#kredit").val('0');
      $("#sisa_pembayaran_penjualan").val(kembalian);
      }


        
        $("#total1").val(tandaPemisahTitik(parseInt(hasil_akhir)));
        $("#potongan_persen").val(parseInt(potongan_persen));
        });
        });
</script>

-->

<script type="text/javascript">
      
      $(document).ready(function(){

        $("#tax").keyup(function(){

        var potongan = bersihPemisah(bersihPemisah(bersihPemisah(bersihPemisah($("#potongan_penjualan").val() ))));
        var pembayaran = bersihPemisah(bersihPemisah(bersihPemisah(bersihPemisah($("#pembayaran_penjualan").val() ))));
        if (pembayaran == '') {
          pembayaran = 0;
        }
        var potongan_persen = ((total / potongan_persen) * 100);
        var total = bersihPemisah(bersihPemisah(bersihPemisah(bersihPemisah($("#total2").val() ))));
        var biaya_admin = bersihPemisah(bersihPemisah(bersihPemisah(bersihPemisah($("#biaya_admin").val()))));
        if (biaya_admin == '')
        {
          biaya_admin = 0;
        }
              var cara_bayar = $("#carabayar1").val();
              var tax = $("#tax").val();
              var t_total = total - potongan;
              var t_balik = parseInt(t_total,10) + parseInt(biaya_admin,10);
              if (tax == "") {
                tax = 0;
              }
              else if (cara_bayar == "") {
                alert ("Kolom Cara Bayar Masih Kosong");
                 $("#tax").val('');
                 $("#potongan_penjualan").val('');
                 $("#potongan_persen").val('');
              }

  var t_tax = ((parseInt(bersihPemisah(bersihPemisah(bersihPemisah(bersihPemisah(t_total,10))))) * parseInt(bersihPemisah(bersihPemisah(bersihPemisah(bersihPemisah(tax,10)))))) / 100);


              var total_akhir = parseInt(bersihPemisah(bersihPemisah(bersihPemisah(bersihPemisah(t_total,10))))) + parseInt(Math.round(t_tax,10)) + parseInt(biaya_admin,10);
            
              if (tax > 100) {

            var sisa = pembayaran - t_balik;
            var sisa_kredit = t_balik - pembayaran; 
        
              if (sisa < 0 )
              {
              $("#kredit").val( tandaPemisahTitik(sisa_kredit));
              $("#sisa_pembayaran_penjualan").val('0');
              $("#tanggal_jt").attr("disabled", false);
              
              }
              
              else  
              {
              
              $("#sisa_pembayaran_penjualan").val(tandaPemisahTitik(sisa));
              $("#kredit").val('0');
              $("#tanggal_jt").attr("disabled", true);
              
              } 

                alert ('Jumlah Tax Tidak Boleh Lebih Dari 100%');
                 $("#tax").val('');
                 $("#tax_rp").val('');
                 $("#total1").val(tandaPemisahTitik(t_balik));

              }
              else
              {
                  var sisa = pembayaran - Math.round(total_akhir);
                  var sisa_kredit = Math.round(total_akhir) - pembayaran; 
        
              if (sisa < 0 )
              {
              $("#kredit").val( tandaPemisahTitik(sisa_kredit));
              $("#sisa_pembayaran_penjualan").val('0');
              $("#tanggal_jt").attr("disabled", false);
              
              }
              
              else  
              {
              
              $("#sisa_pembayaran_penjualan").val(tandaPemisahTitik(sisa));
              $("#kredit").val('0');
              $("#tanggal_jt").attr("disabled", true);
              
              } 
                $("#tax_rp").val(Math.round(t_tax));
                 $("#total1").val(tandaPemisahTitik(Math.round(total_akhir)));
              }
        
          });
    });
      
</script>







<script type="text/javascript">
$(document).ready(function(){
      
//fungsi hapus data 
$(document).on('click','.btn-hapus-tbs',function(e){
    var no_reg = $("#no_reg").val();
    var kode_pelanggan = $("#kd_pelanggan1").val();
    var nama_barang = $(this).attr("data-barang");
    var id = $(this).attr("data-id");
    var kode_barang = $(this).attr("data-kode-barang");
    var subtotal = $(this).attr("data-subtotal");
    var data_admin = bersihPemisah(bersihPemisah(bersihPemisah(bersihPemisah($("#biaya_admin_persen").val()))));
      if (data_admin == '') {
        data_admin = 0;
      }

    var tax_faktur = bersihPemisah(bersihPemisah(bersihPemisah(bersihPemisah($("#tax").val()))));
        if (tax_faktur == '') {
      tax_faktur = 0;
    };

    var subtotal_tbs = bersihPemisah(bersihPemisah(bersihPemisah(bersihPemisah($("#total2").val()))));
    
    var pot_fakt_per = bersihPemisah(bersihPemisah(bersihPemisah(bersihPemisah($("#potongan_persen").val()))));

    var pot_fakt_rp = bersihPemisah(bersihPemisah(bersihPemisah(bersihPemisah($("#potongan_penjualan").val()))));
    var total_akhir1 = parseInt(subtotal_tbs,10) - parseInt(subtotal,10);
    var biaya_adm = parseInt(total_akhir1,10) * parseInt(data_admin,10) / 100;

   if (pot_fakt_per == 0) {
      var potongaaan = pot_fakt_rp;

      var potongaaan_per = parseInt(potongaaan,10) / parseInt(total_akhir1,10) * 100;
      var potongaaan = pot_fakt_rp;
      var hitung_tax = parseInt(total_akhir1,10) - parseInt(pot_fakt_rp,10);
      var tax_bener = parseInt(hitung_tax,10) * parseInt(tax_faktur,10) / 100;

      var total_akhir = parseInt(total_akhir1,10) - parseInt(pot_fakt_rp,10) + parseInt(biaya_adm,10) + parseInt(Math.round(tax_bener,10));


    }
    else if(pot_fakt_rp == 0)
    {
      var potongaaan = pot_fakt_per;
      var pos = potongaaan.search("%");
      var potongan_persen = bersihPemisah(bersihPemisah(bersihPemisah(bersihPemisah(potongaaan))));
          potongan_persen = potongan_persen.replace("%","");
      potongaaan = total_akhir1 * potongan_persen / 100;
      
      var potongaaan_per = pot_fakt_per;
      var hitung_tax = parseInt(total_akhir1,10) - parseInt(potongaaan,10);
      var tax_bener = parseInt(hitung_tax,10) * parseInt(tax_faktur,10) / 100;

     var total_akhir = parseInt(total_akhir1,10) - parseInt(potongaaan,10) + parseInt(biaya_adm,10) + parseInt(Math.round(tax_bener,10));

    }
     else if(pot_fakt_rp != 0 && pot_fakt_rp != 0)
    {
      var potongaaan = pot_fakt_per;
      var pos = potongaaan.search("%");
      var potongan_persen = bersihPemisah(bersihPemisah(bersihPemisah(bersihPemisah(potongaaan))));
          potongan_persen = potongan_persen.replace("%","");
      potongaaan = total_akhir1 * potongan_persen / 100;
      
      var potongaaan_per = pot_fakt_per;
      var hitung_tax = parseInt(total_akhir1,10) - parseInt(potongaaan,10);
      var tax_bener = parseInt(hitung_tax,10) * parseInt(tax_faktur,10) / 100;

      var total_akhir = parseInt(total_akhir1,10) - parseInt(potongaaan,10) + parseInt(biaya_adm,10) + parseInt(Math.round(tax_bener,10));

    
    }






var pesan_alert = confirm("Apakah Anda Yakin Ingin Menghapus "+nama_barang+""+ "?");
if (pesan_alert == true) {

    $(".tr-id-"+id+"").remove();
        if (no_reg != '') {

        var sub_radiologi = bersihPemisah(bersihPemisah(bersihPemisah(bersihPemisah($("#sub_radiologi").val()))));
            if (sub_radiologi == '') {
               sub_radiologi = 0;
                }

        var hitung_lab = parseInt(sub_radiologi,10) - parseInt(subtotal,10);
         $("#sub_radiologi").val(tandaPemisahTitik(hitung_lab)); 
        } 



         $("#total2").val(tandaPemisahTitik(total_akhir1));  
         $("#total1").val(tandaPemisahTitik(total_akhir));      
         $("#potongan_penjualan").val(Math.round(potongaaan));
         $("#biaya_admin").val(Math.round(biaya_adm));         
         $("#pembayaran_penjualan").val('');
         $("#sisa_pembayaran_penjualan").val('');
         $("#kredit").val('');
         
         if (total_akhir1 == '0') {
         
         $("#potongan_persen").val('0');
         }
         else{
         
         $("#potongan_persen").val(Math.round(potongaaan_per));
         }
         $("#tax_rp").val(Math.round(tax_bener));
         $("#kode_barang").trigger('chosen:open');    

          $.post("hapus_tbs_penjualan_radiologi.php",{id:id},function(data){

        });
}
else{

}


        $('#tabel_tbs_radiologi').DataTable().destroy();
            var dataTable = $('#tabel_tbs_radiologi').DataTable( {
            "processing": true,
            "serverSide": true,
            "info":     true,
            "language": { "emptyTable":     "Tidak Ada Data" },
            "ajax":{
              url :"data_tbs_penjualan_radiologi.php", // json datasource
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
                
              },
                             "fnCreatedRow": function( nRow, aData, iDataIndex ) {

                              $(nRow).attr('class','tr-id-'+aData[8]+'');         

                          }
            }   

      });
        
        $("#span_tbs").show()

  });
            $('form').submit(function(){
              
              return false;
            });


});
  
//end fungsi hapus data
</script>



<!-- AUTOCOMPLETE Pelanggan/pasien-->

<script>
$(function() {
    $( "#nama_pelanggan" ).autocomplete({
        source: 'nama_pelanggan_autocomplete.php'
    });
});
</script>
<!-- AUTOCOMPLETE -->


<script type="text/javascript">
  $("#nama_pelanggan").blur(function(){
    var nama_pelanggan = $("#nama_pelanggan").val();

    $.post("kode_pelanggan.php",{nama_pelanggan:nama_pelanggan},function(data){
      if (data != "") {
        $("#kd_pelanggan1").val(data);
      }
      else{
        $("#kd_pelanggan1").val(nama_pelanggan);
      }
    
    });



  });
</script>




<script type="text/javascript">
  $(document).ready(function(){

  $(document).on('click','#btnRefreshsubtotal',function(e){

    var no_reg = $("#no_reg").val();
    var total_rj_ri = bersihPemisah(bersihPemisah(bersihPemisah(bersihPemisah($("#total_rj_ri").val()))));
    var total_ops = bersihPemisah(bersihPemisah(bersihPemisah(bersihPemisah($("#total_ops").val()))));
    if (total_ops == '') {
    total_ops = 0;
    }
    
    if (total_rj_ri == "") {
    total_rj_ri = 0;
    }

      $.post("proses_refresh_subtotal_radiologi.php",{no_reg:no_reg},function(data){
    var total_sebenarnya = parseInt(total_rj_ri,10) + parseInt(total_ops,10) + parseInt(data,10);

        if (total_sebenarnya == '') {
          total_sebenarnya = 0
        }

            var biaya_admin = $("#biaya_admin_select").val();
            var hitung_biaya = parseInt(biaya_admin,10) * parseInt(total_sebenarnya,10) / 100;

            $("#biaya_adm").val(tandaPemisahTitik(Math.round(hitung_biaya)));

            var diskon = bersihPemisah(bersihPemisah(bersihPemisah(bersihPemisah($("#potongan_penjualan").val()))));
            if(diskon == '')
            {
              diskon = 0
            }
           var hasilnya = parseInt(total_sebenarnya,10) + parseInt(Math.round(hitung_biaya),10) - parseInt(diskon,10);

            $("#total1").val(tandaPemisahTitik(hasilnya));
            $("#total2").val(tandaPemisahTitik(total_sebenarnya));

      });
    

  });

});
</script>



<script>
/* Membuat Tombol Shortcut */

function myFunction(event) {
    var x = event.which || event.keyCode;

    if(x == 112){


     $("#myModal").modal();

    }

    else if(x == 113){


     $("#pembayaran_penjualan").focus();

    }

   else if(x == 115){


     $("#penjualan").focus();

    }
  }
</script>


                  <script type="text/javascript">
                                 
                                  $(document).on('dblclick','.edit-jumlah',function(e){

                                    var id = $(this).attr("data-id");

                                    $("#text-jumlah-"+id+"").hide();

                                    $("#input-jumlah-"+id+"").attr("type", "text");

                                 });


                                  $(document).on('blur','.input_jumlah',function(e){

                                    var no_reg = $("#no_reg").val();
                                    var id = $(this).attr("data-id");
                                    var jumlah_baru = $(this).val();
                                    if (jumlah_baru == '') {
                                      jumlah_baru = '0';
                                    }
                                    var kode_barang = $(this).attr("data-kode");
                                    var harga = $(this).attr("data-harga");
                                    var jumlah_lama = $("#text-jumlah-"+id+"").text();
                                    var satuan_konversi = $(this).attr("data-satuan");
                                    var tipe = $(this).attr("data-tipe");    
                                    var kode_pelanggan = $("#kd_pelanggan1").val();

                                    var data_admin = bersihPemisah(bersihPemisah(bersihPemisah(bersihPemisah($("#biaya_admin_persen").val()))));
                                      if (data_admin == '') {
                                        data_admin = 0;
                                      }
                                   

                                    var subtotal_lama = bersihPemisah(bersihPemisah(bersihPemisah(bersihPemisah($("#text-subtotal-"+id+"").text()))));
                                    var potongan = bersihPemisah(bersihPemisah(bersihPemisah(bersihPemisah($("#text-potongan-"+id+"").text()))));

                                    var tax = bersihPemisah(bersihPemisah(bersihPemisah(bersihPemisah($("#text-tax-"+id+"").text()))));
                                   
                                    var subtotal = harga * jumlah_baru - potongan;

                                    var subtotal_penjualan = bersihPemisah(bersihPemisah(bersihPemisah(bersihPemisah($("#total2").val()))));

                                    subtotal_penjualan = subtotal_penjualan - subtotal_lama + subtotal;

                                    var biaya_admin = parseInt(subtotal_penjualan,10) * data_admin / 100;

                                    var pot_fakt_per = bersihPemisah(bersihPemisah(bersihPemisah(bersihPemisah($("#potongan_persen").val()))));
                                    var potongaaan = pot_fakt_per;
                                    var pos = potongaaan.search("%");
                                    var potongan_persen = bersihPemisah(bersihPemisah(bersihPemisah(bersihPemisah(potongaaan))));
                                        potongan_persen = potongan_persen.replace("%","");
                                        potongaaan = subtotal_penjualan * potongan_persen / 100;
                                    $("#potongan_penjualan").val(potongaaan);
                                    
                                    
                                          var tax_faktur = $("#tax").val();
                                            if(tax_faktur == '')
                                            {
                                              tax_faktur = 0;
                                            }

                                    var sub_akhir = parseInt(subtotal_penjualan,10) - parseInt(potongaaan,10);

                                    var t_tax = ((parseInt(bersihPemisah(bersihPemisah(bersihPemisah(bersihPemisah(sub_akhir,10))))) * parseInt(bersihPemisah(bersihPemisah(bersihPemisah(bersihPemisah(tax_faktur)))))) / 100);

                                    //perhitungan total pembayaran terakhir
                                    var tot_akhr = parseInt(sub_akhir,10) + parseInt(biaya_admin,10) + parseInt(Math.round(t_tax,10));
                                    //perhitungan total pembayaran terakhir

                                        if (no_reg != '') {

                                            var sub_radiologi = bersihPemisah(bersihPemisah(bersihPemisah(bersihPemisah($("#sub_radiologi").val()))));
                                            if (sub_radiologi == '') {
                                              sub_radiologi = 0;
                                            }

                                            var total_baru = parseInt(jumlah_baru,10) * parseInt(harga,10) - parseInt(potongan,10);

                                            var hitung_lab = parseInt(sub_radiologi,10)  - parseInt(subtotal_lama,10) + parseInt(total_baru,10); 

                                      }




                                    var tax_tbs = tax / subtotal_lama * 100;
                                    var jumlah_tax = Math.round(tax_tbs) * subtotal / 100;


                                        if (jumlah_baru == 0) {
                                          alert("Jumlah Tidak Boleh Kosong atau Nol");
                                          $("#input-jumlah-"+id+"").val(jumlah_lama);
                                          $("#text-jumlah-"+id+"").text(jumlah_lama);
                                          $("#text-jumlah-"+id+"").show();
                                          $("#input-jumlah-"+id+"").attr("type", "hidden");

                                        }
                                        else
                                        {

                                            if (tipe == 'Jasa' || tipe == 'BHP') {


                                                      $("#text-jumlah-"+id+"").show();
                                                        $("#text-jumlah-"+id+"").text(jumlah_baru);

                                                        if (no_reg != '') {
                                                          $("#sub_radiologi").val(tandaPemisahTitik(hitung_lab));
                                                        }

                                                        $("#text-subtotal-"+id+"").text(tandaPemisahTitik(subtotal));
                                                        $("#btn-hapus-id-"+id+"").attr("data-subtotal",subtotal);
                                                        $("#text-tax-"+id+"").text(Math.round(jumlah_tax));
                                                        $("#input-jumlah-"+id+"").attr("type", "hidden"); 
                                                        $("#total2").val(tandaPemisahTitik(subtotal_penjualan));
                                                        $("#potongan_penjualan").val(Math.round(potongaaan));
                                                        $("#total1").val(tandaPemisahTitik(tot_akhr));
                                                        $("#tax_rp").val(tandaPemisahTitik(Math.round(t_tax)));
                                                        $("#biaya_admin").val(Math.round(biaya_admin));
                                                        $("#pembayaran_penjualan").val('');
                                                        $("#sisa_pembayaran_penjualan").val('');
                                                        $("#kredit").val('');
                                                       
                                                         $.post("update_tbs_radiologi.php",{jumlah_lama:jumlah_lama,tax:tax,id:id,jumlah_baru:jumlah_baru,kode_barang:kode_barang,potongan:potongan,harga:harga,jumlah_tax:jumlah_tax,subtotal:subtotal,kode_pelanggan:kode_pelanggan},function(info){
                                                         });  

                                            }
                                            else{

                                              $.post("cek_stok_pesanan_barang.php",{kode_barang:kode_barang,jumlah_baru:jumlah_baru,satuan_konversi:satuan_konversi},function(data){

                                                     if (data < 0) {

                                                     alert ("Jumlah Yang Di Masukan Melebihi Stok !");

                                                      $("#input-jumlah-"+id+"").val(jumlah_lama);
                                                      $("#text-jumlah-"+id+"").text(jumlah_lama);
                                                      $("#text-jumlah-"+id+"").show();
                                                      $("#input-jumlah-"+id+"").attr("type", "hidden");
                                                  
                                                      }

                                                    else{

                                                        if (no_reg != '') {
                                                          $("#sub_radiologi").val(tandaPemisahTitik(hitung_lab));
                                                        }

                                                      $("#text-jumlah-"+id+"").show();
                                                        $("#text-jumlah-"+id+"").text(jumlah_baru);

                                                        $("#text-subtotal-"+id+"").text(tandaPemisahTitik(subtotal));
                                                        $("#btn-hapus-id-"+id+"").attr("data-subtotal",subtotal);
                                                        $("#text-tax-"+id+"").text(Math.round(jumlah_tax));
                                                        $("#input-jumlah-"+id+"").attr("type", "hidden"); 
                                                        $("#total2").val(tandaPemisahTitik(subtotal_penjualan));
                                                        $("#potongan_penjualan").val(Math.round(potongaaan));
                                                        $("#total1").val(tandaPemisahTitik(tot_akhr));
                                                        $("#tax_rp").val(tandaPemisahTitik(Math.round(t_tax)));
                                                        $("#biaya_admin").val(Math.round(biaya_admin));
                                                        $("#pembayaran_penjualan").val('');
                                                        $("#sisa_pembayaran_penjualan").val('');
                                                        $("#kredit").val('');

                                                         $.post("update_tbs_radiologi.php",{jumlah_lama:jumlah_lama,tax:tax,id:id,jumlah_baru:jumlah_baru,kode_barang:kode_barang,potongan:potongan,harga:harga,jumlah_tax:jumlah_tax,subtotal:subtotal,kode_pelanggan:kode_pelanggan},function(info){

                                                        });

                                                      }

                                                 });

                                            }
                                            
                                            }

                                    $("#kode_barang").trigger('chosen:open');
                                    
                    });


                             </script>



<script type="text/javascript">

  $(document).ready(function(){
    $(document).on('click','#transaksi_baru',function(e){

                      $('#tabel_tbs_radiologi').DataTable().destroy();

                          var dataTable = $('#tabel_tbs_radiologi').DataTable( {
                            "processing": true,
                            "serverSide": true,
                            "ajax":{
                              url :"data_tbs_penjualan_radiologi.php", // json datasource
                              "data": function ( d ) {
                                d.no_reg = $("#no_reg").val();
                                // d.custom = $('#myInput').val();
                                // etc
                              },
                              type: "post",  // method  , by default get
                              error: function(){  // error handling
                                $(".employee-grid-error").html("");
                                $("#tabel_tbs_radiologi").append('<tbody class="employee-grid-error"><tr><th colspan="3">No data found in the server</th></tr></tbody>');
                                $("#employee-grid_processing").css("display","none");
                                }
                            },
                               "fnCreatedRow": function( nRow, aData, iDataIndex ) {

                                $(nRow).attr('class','tr-id-'+aData[8]+'');         

                            }
                          });
                      $("#span_tbs").show();

            $("#pembayaran_penjualan").val('');
            $("#sisa_pembayaran_penjualan").val('');
            $("#kredit").val('');
            $("#potongan_penjualan").val('');
            $("#potongan_persen").val('');
            $("#tanggal_jt").val('');
            $("#total2").val('');
            $("#total1").val('');
            $("#biaya_admin_select").val('0');
            $("#biaya_admin_select").trigger("chosen:updated");
            $("#biaya_admin_persen").val('');
            $("#biaya_adm").val('');
            $("#no_rm").val('');
            $("#nama_pelanggan").val('Umum');
            $("#kd_pelanggan1").val('Umum');
            $("#no_reg").val('');
            $("#asal_poli").val('');
            $("#penjamin").val('');
            $("#ppn").val('Include');
            $("#ppn").trigger("chosen:updated");
            $("#penjamin").val('');
            $("#penjamin").trigger("chosen:updated");
            $("#level_harga").val('');
            $("#level_harga").trigger("chosen:updated");
            $("#dokter_radiologi").val('');
            $("#dokter_radiologi").trigger("chosen:updated");
            $("#keterangan").val('');
            $("#penjualan").show();
            $("#cetak_langsung").show();
            $("#piutang").show();
            $("#batal_penjualan").show(); 
            $("#transaksi_baru").hide();
            $("#alert_berhasil").hide();
            $("#cetak_tunai").hide();
            $("#cetak_tunai_besar").hide();
            $("#cetak_piutang").hide();
            $("#dokter").val('');
            $("#dokter").trigger("chosen:updated");
            $("#dokter_pemeriksa").val('');
            $("#dokter_pemeriksa").trigger("chosen:updated");
            $("#petugas_radiologi").val('');
            $("#petugas_radiologi").trigger("chosen:updated");
            $("#ppn").attr("disabled", false);

            var url = window.location.href;
             url = getPathFromUrl(url);
            history.pushState('', 'Sim Klinik',  url);

            function getPathFromUrl(url) {
              return url.split("?")[0];
            }

    });
  });

</script>



<script type="text/javascript">
$(document).ready(function(){
  $("#batal_penjualan").click(function(){
    var session_id = $("#session_id").val()

    var pesan_alert = confirm("Apakah Anda Yakin Ingin Membatalkan Transaksi Ini ?");
    if (pesan_alert == true) {
        
        $.get("batal_penjualan_radiologi.php",{session_id:session_id},function(data){
              $('#tabel_tbs_radiologi').DataTable().destroy();

                          var dataTable = $('#tabel_tbs_radiologi').DataTable( {
                            "processing": true,
                            "serverSide": true,
                            "ajax":{
                              url :"data_tbs_penjualan_radiologi.php", // json datasource
                              "data": function ( d ) {
                                d.no_reg = $("#no_reg").val();
                                // d.custom = $('#myInput').val();
                                // etc
                              },
                              type: "post",  // method  , by default get
                              error: function(){  // error handling
                                $(".employee-grid-error").html("");
                                $("#tabel_tbs_radiologi").append('<tbody class="employee-grid-error"><tr><th colspan="3">No data found in the server</th></tr></tbody>');
                                $("#employee-grid_processing").css("display","none");
                                }
                            },
                               "fnCreatedRow": function( nRow, aData, iDataIndex ) {

                                $(nRow).attr('class','tr-id-'+aData[8]+'');         

                            }
                          });

              
              $("#span_tbs").show()

        });
    } 

    else {
    
    }

  });
  });
</script>

<!-- SHORTCUT -->

<script> 
    shortcut.add("f2", function() {
        // Do something

        $("#kode_barang").trigger('chosen:open');

    });

    
    shortcut.add("f1", function() {
        // Do something

        $("#cari_produk_radiologi").click();

    }); 

    
    shortcut.add("f3", function() {
        // Do something

        $("#submit_produk").click();

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

    
    shortcut.add("ctrl+b", function() {
        // Do something


        window.location.href="batal_penjualan_lab.php";


    }); 

    shortcut.add("ctrl+k", function() {
        // Do something


        window.location.href="cetak_penjualan_tunai.php";


    }); 
</script>

<!-- SHORTCUT -->


<script type="text/javascript">
  $(document).ready(function(){
var pot_fakt_per = bersihPemisah(bersihPemisah(bersihPemisah(bersihPemisah($("#potongan_persen").val()))));
var pot_fakt_rp = bersihPemisah(bersihPemisah(bersihPemisah(bersihPemisah($("#potongan_penjualan").val()))));
var total_rj_ri = bersihPemisah(bersihPemisah(bersihPemisah(bersihPemisah($("#total_rj_ri").val()))));
var total_ops = bersihPemisah(bersihPemisah(bersihPemisah(bersihPemisah($("#total_ops").val()))));
if (total_ops == '') {
  total_ops = 0;
}

if (total_rj_ri == "") {
  total_rj_ri = 0;
}
var no_reg = $("#no_reg").val();


if (no_reg == '')
{

    $.get("cek_total_radiologi.php",{no_reg:no_reg},function(data1){


        if (data1 == 1) {
                 $.get("cek_total_tbs_form_radiologi.php",{no_reg:no_reg},function(data){
                  data = data.replace(/\s+/g, '');
                  if (data == "") {
                    data = 0;
                  }
                var sum = parseInt(data,10);
                

                  $("#total2").val(tandaPemisahTitik(sum));


                  if (pot_fakt_per == '0%') {
                  var potongaaan = pot_fakt_rp;
                  var potongaaan = parseInt(potongaaan,10) / parseInt(data,10) * 100;
                  $("#potongan_persen").val(Math.round(potongaaan));

                 var total = parseInt(data,10) - parseInt(pot_fakt_rp,10);

                  $("#total1").val(tandaPemisahTitik(total));

                }
                    else if(pot_fakt_rp == 0)
                    {
                          var potongaaan = pot_fakt_per;
                          var pos = potongaaan.search("%");
                          var potongan_persen = bersihPemisah(bersihPemisah(bersihPemisah(bersihPemisah(potongaaan))));
                          potongan_persen = potongan_persen.replace("%","");
                          potongaaan = data * potongan_persen / 100;
                          $("#potongan_penjualan").val(potongaaan);

                          var total = parseInt(data,10) - parseInt(potongaaan,10);

                          $("#total1").val(tandaPemisahTitik(total))

                    }

                });
        }

            else
            {

            }
});

}
  else {


$.get("cek_total_tbs_form_radiologi.php",{no_reg:no_reg},function(data){
  data = data.replace(/\s+/g, '');
                  if (data == "") {
                    data = 0;
                  }

                var sum = parseInt(data,10) + parseInt(total_rj_ri,10) + parseInt(total_ops,10);

                  $("#total2").val(tandaPemisahTitik(sum));
                  $("#sub_radiologi").val(tandaPemisahTitik(data));


            if (pot_fakt_per == '0%') {
              var potongaaan = pot_fakt_rp;
              var potongaaan = parseInt(potongaaan,10) / parseInt(data,10) * 100;
              $("#potongan_persen").val(Math.round(potongaaan));

             var total = parseInt(data,10) - parseInt(pot_fakt_rp,10);

              $("#total1").val(tandaPemisahTitik(total));

            }
            else if(pot_fakt_rp == 0)
            {
                  var potongaaan = pot_fakt_per;
                  var pos = potongaaan.search("%");
                  var potongan_persen = bersihPemisah(bersihPemisah(bersihPemisah(bersihPemisah(potongaaan))));
                  potongan_persen = potongan_persen.replace("%","");
                  potongaaan = data * potongan_persen / 100;
                  $("#potongan_penjualan").val(potongaaan);

                  var total = parseInt(data,10) - parseInt(potongaaan,10);

                  $("#total1").val(tandaPemisahTitik(total))

            }

                });



}



     

  });

</script>


<script type="text/javascript">
    $(document).ready(function(){

      // $("#tax").attr("disabled", true);

// cek ppn exclude 
    var total2 = $("#total2").val();
    var no_reg = $("#no_reg").val();
    $.get("cek_ppn_radiologi.php",{no_reg:no_reg},function(data){
      if (data == 1) {

         $("#ppn").val('Exclude');
         $("#ppn").trigger('chosen:updated');
         
         $("#ppn").attr("disabled", true);

      }
      else if(data == 2){

        $("#ppn").val('Include');
        $("#ppn").trigger('chosen:updated');
        
        $("#ppn").attr("disabled", true);

      }
      else
      {

        $("#ppn").val('Include');
        $("#ppn").trigger('chosen:updated');

      }

    });

    $("#ppn").change(function(){

    var ppn = $("#ppn").val();
    $("#ppn_input").val(ppn);

  if (ppn == "Include"){
      $("#tax1").attr("disabled", false);
  }

  else if (ppn == "Exclude") {
    $("#tax1").attr("disabled", false);
  }
  else{

    $("#tax1").attr("disabled", true);
  }


  });
  });
</script>



<script type="text/javascript" language="javascript" >

  $(document).ready(function() {
    $(document).on('click', '#rawat', function (e) {
      $('#table-rawat').DataTable().destroy();
            var dataTable = $('#table-rawat').DataTable( {
            "processing": true,
            "serverSide": true,
            "info":     false,
            "language": { "emptyTable":     "My Custom Message On Empty Table" },
            "ajax":{
              url :"table_rawat_rujuk_radiologi.php", // json datasource
               "data": function ( d ) {
                  d.no_reg = $("#no_reg").val();
                  // d.custom = $('#myInput').val();
                  // etc
              },
                  type: "post",  // method  , by default get
              error: function(){  // error handling
                $(".tbody").html("");
                $("#table-rawat").append('<tbody class="tbody"><tr><th colspan="3"></th></tr></tbody>');
                $("#table-rawat_processing").css("display","none");
                
              }
            }   

      });


    });


  });

</script>

<script type="text/javascript">
  // Rawat jalan
  $(document).on('click','#raja',function(e){

  /*
    var no_reg = $("#no_reg").val();
    var nama_pasien = $("#nama_pelanggan").val();
    var no_rm = $("#kd_pelanggan1").val();
    var penjamin = $("#penjamin").val();
    var dokter = $("#dokter").val();
    var level_harga = $("#level_harga").val();
    var poli = $("#asal_poli").val();
    var petugas_radiologi = $("#petugas_radiologi").val();
    var dokter_pemeriksa = $("#dokter_pemeriksa").val();

    if (dokter_pemeriksa == "") {
      alert("Silakan Pilih Dokter Pemeriksa");
      $("#dokter_pemeriksa").trigger('chosen:open');
    }
    else if(petugas_radiologi == ""){

      alert("Silakan Pilih Petugas Radiologi");
      $("#petugas_radiologi").trigger('chosen:open');
    }
    else{

    window.location.href="form_penjualan_kasir.php?no_reg="+no_reg+"&nama_pasien="+nama_pasien+"&no_rm="+no_rm+"&penjamin="+penjamin+"&dokter="+dokter+"&level_harga="+level_harga+"&poli="+poli+"&petugas_radiologi="+petugas_radiologi+"";
    }
    */
   
    window.location.href="pasien_sudah_masuk.php";


  });

  //Rawat Inap
   $(document).on('click','#ranap',function(e){

    /*
     var no_reg = $("#no_reg").val();
    var nama_pasien = $("#nama_pelanggan").val();
    var no_rm = $("#no_rm").val();
    var penjamin = $("#penjamin").val();
    var dokter = $("#dokter").val();
    var level_harga = $("#level_harga").val();
    var poli = $("#asal_poli").val();
    var dokter_pj = $("#dokter_pj").val();
    var bed = $("#bed").val();
    var kamar = $("#kamar").val();
    var petugas_radiologi = $("#petugas_radiologi").val();

    window.location.href="form_penjualan_kasir_ranap.php?no_reg="+no_reg+"&nama_pasien="+nama_pasien+"&no_rm="+no_rm+"&penjamin="+penjamin+"&dokter="+dokter+"&level_harga="+level_harga+"&poli="+poli+"&bed="+bed+"&kamar="+kamar+"&petugas_radiologi="+petugas_radiologi+"&petugas_radiologi="+petugas_radiologi+"";

    */
   
   window.location.href="rawat_inap.php";

  });

  $(document).on('click','#ugd',function(e){

   
    window.location.href="registrasi_ugd.php";


  });

</script>


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

<!--INSERT SATU SATU -->

<script>

$(document).on('click','.insert-tbs',function(e){

    var data_toggle = $(this).attr('data-toogle');

    var kode_barang = $(this).attr('data-kode');
    var nama_barang = $(this).attr('data-nama');
    var kontras = $(this).attr('data-kontras');
    var harga = $(this).attr('data-harga');
    var id = $(this).attr('data-id');

    var no_reg = $("#no_reg").val();
    var petugas_radiologi = $("#petugas_radiologi").val();
    var dokter_pemeriksa = $("#dokter_pemeriksa").val();
    var dokter = $("#dokter").val();
    var jumlah_barang = 1;
    var tipe_barang ="Jasa";

    $('#kode_barang').trigger('chosen:update');
    $('#kode_barang').val(kode_barang);

    $('#nama_barang').val(nama_barang);
    $('#id_radiologi').val(id);
    $('#kontras').val(kontras);
    $('#harga_produk').val(harga);
    $('#kolom_cek_harga').val('1');

    var nama_barang = $("#nama_barang").val();
    var id = $("#id_radiologi").val();
    var kontras = $("#kontras").val();
    var harga = $("#harga_produk").val();
    var kolom_cek_harga = $("#kolom_cek_harga").val();
    var kode_barang = $("#kode_barang").val();


    if (data_toggle == 0) {
        
       
        $.post('cek_tbs_penjualan_radiologi.php',{kode_barang:kode_barang,no_reg:no_reg}, function(data){


          if(data == 1){

              $('#label-'+id+'').attr("data-toogle", 0);

              alert("Pemeriksaan '"+nama_barang+"' Sudah Ada, Silakan Pilih Pemeriksaan Yang Lain !");        

           }
           else{
              
              $('#label-'+id+'').attr("data-toogle", 1);
              console.log(data_toggle);

              $.post("proses_insert_tbs_radiologi.php",{nama_barang:nama_barang,jumlah_barang:jumlah_barang,harga:harga,tipe_barang:tipe_barang,kode_barang:kode_barang,no_reg:no_reg,dokter:dokter,kontras:kontras,dokter_pemeriksa:dokter_pemeriksa,petugas_radiologi:petugas_radiologi},function(data){


            });

           }

        });


    }
    else{
                  
        $('#label-'+id+'').attr("data-toogle", 0);

        $.post("hapus_radiologi.php",{no_reg:no_reg, kode_barang:kode_barang},function(data){

        });
    }
    


    $("form").submit(function(){
      return false;    
    });
});
</script>

<!--INSERT SEMUANYA (PILIH SEMUA KONTRAS)-->

<script>

$(document).on('click','.pilih-semua-kontras',function(e){

    var data_toggle = $(this).attr('data-toogle');

    var no_reg = $("#no_reg").val();
    var petugas_radiologi = $("#petugas_radiologi").val();
    var dokter_pemeriksa = $("#dokter_pemeriksa").val();
    var dokter = $("#dokter").val();
    var jumlah_barang = 1;
    var tipe_barang ="Jasa";

    $('#kolom_cek_harga').val('1');

    var kolom_cek_harga = $("#kolom_cek_harga").val();

    if (data_toggle == 0) {
              
        $(this).attr("data-toogle", 1);

        $.post("proses_insert_tbs_radiologi_semua_kontras.php",{tipe_barang:tipe_barang,no_reg:no_reg,dokter:dokter,dokter_pemeriksa:dokter_pemeriksa,petugas_radiologi:petugas_radiologi},function(data){
              
        });


    }
    else{
                  
        $(this).attr("data-toogle", 0);

        $.post("hapus_radiologi_semua_kontras.php",{no_reg:no_reg},function(data){

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
    var petugas_radiologi = $("#petugas_radiologi").val();
    var dokter_pemeriksa = $("#dokter_pemeriksa").val();
    var dokter = $("#dokter").val();
    var jumlah_barang = 1;
    var tipe_barang ="Jasa";

    $('#kolom_cek_harga').val('1');

    var kolom_cek_harga = $("#kolom_cek_harga").val();

    if (data_toggle == 0) {
              
        $(this).attr("data-toogle", 1);

        $.post("proses_insert_tbs_radiologi_semua_tanpa_kontras.php",{tipe_barang:tipe_barang,no_reg:no_reg,dokter:dokter,dokter_pemeriksa:dokter_pemeriksa,petugas_radiologi:petugas_radiologi},function(data){
              
        });


    }
    else{
                  
        $(this).attr("data-toogle", 0);

        $.post("hapus_radiologi_semua_tanpa_kontras.php",{no_reg:no_reg},function(data){

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
              url :"data_tbs_penjualan_radiologi.php", // json datasource
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

// END DATATABLE AJAX END DATATABLE AJAX END DATATABLE AJAX END DATATABLE AJAX END DATATABLE AJAX END DATATABLE AJAX



var pot_fakt_per = bersihPemisah(bersihPemisah(bersihPemisah(bersihPemisah($("#potongan_persen").val()))));
var pot_fakt_rp = bersihPemisah(bersihPemisah(bersihPemisah(bersihPemisah($("#potongan_penjualan").val()))));
var total_rj_ri = bersihPemisah(bersihPemisah(bersihPemisah(bersihPemisah($("#total_rj_ri").val()))));
var total_ops = bersihPemisah(bersihPemisah(bersihPemisah(bersihPemisah($("#total_ops").val()))));
if (total_ops == '') {
  total_ops = 0;
}

if (total_rj_ri == "") {
  total_rj_ri = 0;
}
var no_reg = $("#no_reg").val();


if (no_reg == '')
{

    $.get("cek_total_radiologi.php",{no_reg:no_reg},function(data1){


        if (data1 == 1) {
                 $.get("cek_total_tbs_form_radiologi.php",{no_reg:no_reg},function(data){
                  data = data.replace(/\s+/g, '');
                  if (data == "") {
                    data = 0;
                  }
                var sum = parseInt(data,10);
                

                  $("#total2").val(tandaPemisahTitik(sum));


                  if (pot_fakt_per == '0%') {
                  var potongaaan = pot_fakt_rp;
                  var potongaaan = parseInt(potongaaan,10) / parseInt(data,10) * 100;
                  $("#potongan_persen").val(Math.round(potongaaan));

                 var total = parseInt(data,10) - parseInt(pot_fakt_rp,10);

                  $("#total1").val(tandaPemisahTitik(total));

                }
                    else if(pot_fakt_rp == 0)
                    {
                          var potongaaan = pot_fakt_per;
                          var pos = potongaaan.search("%");
                          var potongan_persen = bersihPemisah(bersihPemisah(bersihPemisah(bersihPemisah(potongaaan))));
                          potongan_persen = potongan_persen.replace("%","");
                          potongaaan = data * potongan_persen / 100;
                          $("#potongan_penjualan").val(potongaaan);

                          var total = parseInt(data,10) - parseInt(potongaaan,10);

                          $("#total1").val(tandaPemisahTitik(total))

                    }

                });
        }

            else
            {

            }
});

}
  else {


$.get("cek_total_tbs_form_radiologi.php",{no_reg:no_reg},function(data){
  data = data.replace(/\s+/g, '');
                  if (data == "") {
                    data = 0;
                  }

                var sum = parseInt(data,10) + parseInt(total_rj_ri,10) + parseInt(total_ops,10);

                  $("#total2").val(tandaPemisahTitik(sum));
                  $("#sub_radiologi").val(tandaPemisahTitik(data));


            if (pot_fakt_per == '0%') {
              var potongaaan = pot_fakt_rp;
              var potongaaan = parseInt(potongaaan,10) / parseInt(data,10) * 100;
              $("#potongan_persen").val(Math.round(potongaaan));

             var total = parseInt(data,10) - parseInt(pot_fakt_rp,10);

              $("#total1").val(tandaPemisahTitik(total));

            }
            else if(pot_fakt_rp == 0)
            {
                  var potongaaan = pot_fakt_per;
                  var pos = potongaaan.search("%");
                  var potongan_persen = bersihPemisah(bersihPemisah(bersihPemisah(bersihPemisah(potongaaan))));
                  potongan_persen = potongan_persen.replace("%","");
                  potongaaan = data * potongan_persen / 100;
                  $("#potongan_penjualan").val(potongaaan);

                  var total = parseInt(data,10) - parseInt(potongaaan,10);

                  $("#total1").val(tandaPemisahTitik(total))

            }

                });



}

    });
  });
</script>

<!-- memasukan file footer.php -->
<?php include 'footer.php'; ?>