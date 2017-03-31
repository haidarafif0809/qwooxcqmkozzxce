<?php include_once 'session_login.php';
// memasukan file session login,  header, navbar, db.php,
include 'header.php';
include 'navbar.php';
include 'db.php';
include 'sanitasi.php';

// menampilkan seluruh data yang ada pada tabel penjualan yang terdapt pada DB

if (isset($_GET['analis'])) {
 $analis = stringdoang($_GET['analis']);
}
else
{
  $analis = '';
};

if (isset($_GET['petugas_radiologi'])) {
 $petugas_radiologi = stringdoang($_GET['petugas_radiologi']);
}
else
{
  $petugas_radiologi = '';
}

$session_id = session_id();
$user = $_SESSION['nama'];
$id_user = $_SESSION['id'];

$pilih_akses_tombol = $db->query("SELECT * FROM otoritas_penjualan_rj WHERE id_otoritas = '$_SESSION[otoritas_id]' ");
$otoritas_tombol = mysqli_fetch_array($pilih_akses_tombol);

$pilih_akses_produk = $db->query("SELECT tipe_barang, tipe_jasa, tipe_alat, tipe_bhp, tipe_obat FROM otoritas_tipe_produk WHERE id_otoritas = '$_SESSION[otoritas_id]' ");
$otoritas_produk = mysqli_fetch_array($pilih_akses_produk);
$barang = $otoritas_produk['tipe_barang'];
$jasa = $otoritas_produk['tipe_jasa'];
$alat = $otoritas_produk['tipe_alat'];
$bhp = $otoritas_produk['tipe_bhp'];
$obat = $otoritas_produk['tipe_obat'];


 ?>

    <style type="text/css">
    .disabled {
    opacity: 0.6;
    cursor: not-allowed;
    disabled: false;
    }
    </style>

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


<script>
  $(function() {
    $( "#tanggal_jt" ).datepicker({dateFormat: "yy-mm-dd"});
  });
  </script>

<!--untuk membuat agar tampilan form terlihat rapih dalam satu tempat -->
 <div style="padding-left: 5%; padding-right: 5%">
  <h3> FORM PENJUALAN RAWAT JALAN </h3>

<div class="row">

<div class="col-xs-8">

 <!-- membuat form menjadi beberpa bagian -->
  <form enctype="multipart/form-data" role="form" action="formpenjualan.php" method="post ">
        
  <!--membuat teks dengan ukuran h3-->      


        <div class="form-group">
        <input type="hidden" name="session_id" id="session_id" class="form-control" value="<?php echo session_id(); ?>" readonly="">
        </div>

          

<div class="row">


<div class="col-xs-3">
  
  <label> No. RM | Pasien </label><br>

  <input style="height:15px" type="text" class="form-control"  id="no_rm" name="no_rm" value="" readonly="" > 
      

  <input style="height:15px" type="hidden" class="form-control"  id="nama_pasien" name="nama_pasien" value="" readonly="" > 

</div>
    

<div class="col-xs-2">
          <label> Gudang </label><br>
          
          <select name="kode_gudang" id="kode_gudang" class="form-control chosen" >
          <?php 
          
          // menampilkan seluruh data yang ada pada tabel suplier
          $query = $db->query("SELECT * FROM gudang");
          
          // menyimpan data sementara yang ada pada $query
          while($data = mysqli_fetch_array($query))
          {

            if ($data['default_set'] == '1') {

                echo "<option selected value='".$data['kode_gudang'] ."'>".$data['nama_gudang'] ."</option>";
              
            }

            else{

                echo "<option value='".$data['kode_gudang'] ."'>".$data['nama_gudang'] ."</option>";

            }
          
          }
          
          
          ?>
          </select>
</div>



<div class="col-xs-2">
          <label>PPN</label>
          <select style="font-size:15px; height:40px" name="ppn" id="ppn" class="form-control chosen">
            <option value="Include">Include</option>  
            <option value="Exclude">Exclude</option>
            <option value="Non">Non</option>          
          </select>
</div>




<div class="col-xs-2">
<label>Kasir</label>
<input style="height:15px;" type="text" class="form-control"  id="petugas_kasir" name="petugas_kasir" value="<?php echo $user; ?>" readonly="">   
</div>

<input style="height:15px;" type="hidden" class="form-control"  id="id_user" name="id_user" value="<?php echo $id_user; ?>" readonly="">   


<div class="col-xs-3">
<label>Dokter Pelaksana</label>
<select style="font-size:15px; height:35px" name="dokter" id="dokter" class="form-control chosen">

 <?php 

    
    //untuk menampilkan semua data pada tabel pelanggan dalam DB
    $query01 = $db->query("SELECT nama,id FROM user WHERE tipe = '1' ");

    //untuk menyimpan data sementara yang ada pada $query
    while($data01 = mysqli_fetch_array($query01))
    {
      echo "<option value='".$data01['id'] ."'>".$data01['nama'] ."</option>";
    
    }
    
    
  ?>

</select>
</div>



<div class="col-xs-3">
<label>Petugas Paramedik</label>
<select style="font-size:15px; height:35px" name="petugas_paramedik" id="petugas_paramedik" class="form-control chosen">
<option value="">Cari Petugas</option>
 <?php 
    
    //untuk menampilkan semua data pada tabel pelanggan dalam DB
    $query01 = $db->query("SELECT nama,id FROM user WHERE tipe = '2' ");

        $petugas_paramedik = $db->query("SELECT nama_paramedik FROM penetapan_petugas ");
        $data_petugas = mysqli_fetch_array($petugas_paramedik);

    //untuk menyimpan data sementara yang ada pada $query
    while($data01 = mysqli_fetch_array($query01))
    {
    
       
    if ($data01['nama'] == $data_petugas['nama_paramedik']) {
     echo "<option selected value='".$data01['id'] ."'>".$data01['nama'] ."</option>";
    }
    else{
      echo "<option value='".$data01['id'] ."'>".$data01['nama'] ."</option>";
    }

    
    }
    
    
    ?>

</select>
</div>  




</div>  <!-- END ROW dari kode pelanggan - ppn -->


<div class="row">

  <div class="col-xs-3">
    <label>No. REG :</label>
    <input style="height:15px" type="text" class="form-control"  id="no_reg" name="no_reg" value="" readonly="">   
</div>


  <div class="form-group col-xs-2">
    <label for="email">Penjamin:</label>
    <select class="form-control chosen" id="penjamin" name="penjamin" required="">
      <?php    
     
      $query = $db->query("SELECT nama FROM penjamin");
      while ( $icd = mysqli_fetch_array($query))
      {
      echo "<option value='".$icd['nama']."'>".$icd['nama']."</option>";
      }
      ?>
    </select>
</div>

<div class="col-xs-2">
    <label> Level Harga </label><br>
  <select style="font-size:15px; height:40px" type="text" name="level_harga" id="level_harga" class="form-control chosen" >

  <option value="harga_1">Level 1</option>
  <option value="harga_2">Level 2</option>
  <option value="harga_3">Level 3</option>
  <option value="harga_4">Level 4</option>
  <option value="harga_5">Level 5</option>
  <option value="harga_6">Level 6</option>
  <option value="harga_7">Level 7</option>


    </select>
</div>



 <div class="col-xs-2">
    <label> Asal Poli :</label>
    <input style="height:15px;" readonly="" type="text" class="form-control"  id="asal_poli" name="asal_poli" placeholder="Isi Poli" autocomplete="off" value="">   
</div>


<div class="col-xs-3">
<label>Petugas Farmasi</label>
<select style="font-size:15px; height:35px" name="petugas_farmasi" id="petugas_farmasi" class="form-control chosen">
<option value="">Cari Petugas</option>
  <?php 
    
    //untuk menampilkan semua data pada tabel pelanggan dalam DB
    $query01 = $db->query("SELECT nama,id FROM user WHERE tipe = '3'");

    //untuk menyimpan data sementara yang ada pada $query
      $petugas_farmasi = $db->query("SELECT nama_farmasi FROM penetapan_petugas ");

        $data_petugas = mysqli_fetch_array($petugas_farmasi);

    while($data01 = mysqli_fetch_array($query01))
    {
    
  
    if ($data01['nama'] == $data_petugas['nama_farmasi']) {
     echo "<option selected value='".$data01['id'] ."'>".$data01['nama'] ."</option>";
    }
    else{
      echo "<option value='".$data01['id'] ."'>".$data01['nama'] ."</option>";
    }

    
    }
    
    
    ?>

</select>
</div>  


<div class="col-xs-3">
<label>Petugas Lain</label>
<select style="font-size:15px; height:35px" name="petugas_lain" id="petugas_lain" class="form-control chosen" >
<option value="">Cari Petugas</option>
  <?php 
    
    //untuk menampilkan semua data pada tabel pelanggan dalam DB
    $query01 = $db->query("SELECT nama,id FROM user WHERE tipe != '5'");

    //untuk menyimpan data sementara yang ada pada $query
    while($data01 = mysqli_fetch_array($query01))
    {

    echo "<option value='".$data01['id'] ."'>".$data01['nama'] ."</option>"; 

    }
    
    
    ?>

</select>
</div>


</div>

  </form><!--tag penutup form-->


<button type="button" id="cari_produk_penjualan" class="btn btn-info " data-toggle="modal" data-target="#myModal"><i class='fa  fa-search'> Cari (F1)</i>  </button> 

<button type="button" class="btn btn-warning" id="cari_pasien" data-toggle="modal" data-target="#modal_reg"><i class="fa fa-user"></i> Cari Pasien (Alt + P)</button>

<a href="form_penjualan_lab.php" id="btnRujukLab" class="btn btn-purple" style="display: none"> <i class="fa fa-flask"></i> Rujuk Lab</a>  
<a href="form_pemeriksaan_radiologi.php" id="btnRujukRadiologi" class="btn btn-purple" style="display: none"> <i class="fa fa-universal-access"></i> Rujuk Radiologi</a>  
  
<button type="button" class="btn btn-default" id="btnRefreshsubtotal"> <i class='fa fa-refresh'></i> Refresh Subtotal</button>

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

<div class="table-responsive">

  <table id="tabel_cari" class="table table-bordered table-sm">
        <thead> <!-- untuk memberikan nama pada kolom tabel -->
        
            <th> Kode Barang </th>
            <th> Nama Barang </th>
            <th> Harga Jual Level 1</th>
            <th> Harga Jual Level 2</th>
            <th> Harga Jual Level 3</th>
            <th> Harga Jual Level 4 </th>
            <th> Harga Jual Level 5</th>
            <th> Harga Jual Level 6</th>
            <th> Harga Jual Level 7</th>
            <th> Jumlah Barang </th>
            <th> Satuan </th>
            <th> Kategori </th>
            <th> Suplier </th>
        
        </thead> <!-- tag penutup tabel -->
  </table>

</div>
</div> <!-- tag penutup modal-body-->
      <div class="modal-footer">
       <center> <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button></center>
      </div>
    </div>

  </div>
</div><!-- end of modal data barang  -->


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



<!-- / modal barang yang tidak bisa di jual -- >

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
<div id="modal_barang_tidak_bisa_dijual" class="modal " role="dialog">
  <div class="modal-dialog">

    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title">Produk Yang Tidak Bisa Di Jual</h4>
      </div>
      <div class="modal-body">
            <center>
            <table class="table table-bordered table-sm">
                  <thead> <!-- untuk memberikan nama pada kolom tabel -->
                  
                      <th>Kode Produk</th>
                      <th>Nama Produk</th>
                      <th>Jumlah Yang Akan Di Jual</th>
                      <th>Stok Saat Ini</th>
                  
                  
                  </thead> <!-- tag penutup tabel -->
                  <tbody id="tbody-barang-jual">
                    
                  </tbody>
            </table>
            </center>

      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-primary" data-dismiss="modal">Close</button>
      </div>
    </div>

  </div>
</div><!-- end of modal edit data  -->

<!-- membuat form prosestbspenjual -->


<?php if ($otoritas_tombol['tombol_submit'] > 0):?>  


<form class="form"  role="form" id="formtambahproduk">
<br>
<div class="row">

  <div class="col-xs-3">

    <select style="font-size:15px; height:20px" type="text" name="kode_barang" id="kode_barang" class="form-control chosen" data-placeholder="SILAKAN PILIH...">
    <option value="">SILAKAN PILIH...</option>
       <?php 

        include 'cache.class.php';
          $c = new Cache();
          $c->setCache('produk');
          $data_c = $c->retrieveAll();

          foreach ($data_c as $key) {
            echo '<option id="opt-produk-'.$key['kode_barang'].'" value="'.$key['kode_barang'].'" data-kode="'.$key['kode_barang'].'" nama-barang="'.$key['nama_barang'].'" harga="'.$key['harga_jual'].'" harga_jual_2="'.$key['harga_jual2'].'" harga_jual_3="'.$key['harga_jual3'].'" harga_jual_4="'.$key['harga_jual4'].'" harga_jual_5="'.$key['harga_jual5'].'" harga_jual_6="'.$key['harga_jual6'].'" harga_jual_7="'.$key['harga_jual7'].'" satuan="'.$key['satuan'].'" kategori="'.$key['kategori'].'" status="'.$key['status'].'" suplier="'.$key['suplier'].'" limit_stok="'.$key['limit_stok'].'" ber-stok="'.$key['berkaitan_dgn_stok'].'" tipe_barang="'.$key['tipe_barang'].'" id-barang="'.$key['id'].'" > '. $key['kode_barang'].' ( '.$key['nama_barang'].' ) </option>';
          }

        ?>
    </select>

 </div>


    <input type="hidden" class="form-control" name="nama_barang" autocomplete="off" id="nama_barang" placeholder="nama" >

  <div class="col-xs-2">
    <input style="height:15px;" type="text" class="form-control" name="jumlah_barang" autocomplete="off" id="jumlah_barang" placeholder="Jumlah">
  </div>



    <input style="height:15px;" type="hidden" class="form-control" name="kolom_cek_harga" autocomplete="off" id="`" placeholder="Jumlah" value="0" >

  <div class="col-xs-1" id="col_dosis" style="display: none">
    <input style="height:15px;" type="text" class="form-control" name="dosis_obat" autocomplete="off" id="dosis_obat" placeholder="Dosis">
  </div>

  <div class="col-xs-2">
          
          <select style="font-size:15px; height:40px" type="text" name="satuan_konversi" id="satuan_konversi" class="form-control" >
          
          <?php 
          
          
          $query = $db->query("SELECT id, nama  FROM satuan");
          while($data = mysqli_fetch_array($query))
          {
          
          echo "<option value='".$data['id']."'>".$data['nama'] ."</option>";
          }
                      
          ?>
          
          </select>

</div>


   <div class="col-xs-1">
    <input style="height:15px;" type="text" class="form-control" name="potongan" autocomplete="off" id="potongan1" data-toggle="tooltip" data-placement="top" title="Jika Ingin Potongan Dalam Bentuk Persen (%), input : 10%" placeholder="Diskon">
  </div>

   <div class="col-xs-1">
    <input style="height:15px;" type="text" class="form-control" name="tax" autocomplete="off" id="tax1" placeholder="Tax%" >
  </div>

<div class="col-xs-2">
  <button type="submit" id="submit_produk" class="btn btn-success" style="font-size:15px" > <i class="fa fa-plus"></i>Submit(F3)</button>

</div>

</div>
<?php endif ?>
<input type="hidden" class="form-control" name="subt_tbs" autocomplete="off" id="subt_tbs" placeholder="SUBTOTAL TBS" >
<input type="hidden" class="form-control" name="disc_tbs" autocomplete="off" id="disc_tbs" placeholder="DISKON TBS" >
    <input type="hidden" class="form-control" name="limit_stok" autocomplete="off" id="limit_stok" placeholder="Limit Stok" >
    <input type="hidden" class="form-control" name="ber_stok" id="ber_stok" placeholder="Ber Stok" >
    <input type="hidden" class="form-control" name="harga_lama" id="harga_lama" placeholder="harga lama">
    <input type="hidden" class="form-control" name="harga_baru" id="harga_baru" placeholder="harga baru">
    <input type="hidden" class="form-control" name="jumlahbarang" id="jumlahbarang" placeholder="stok">
    <input type="hidden" id="satuan_produk" name="satuan" class="form-control" value="" placeholder="Satuan">
    <input type="hidden" id="harga_produk" name="harga" class="form-control" value="" placeholder="Harga Jual">
    <input type="hidden" id="id_produk" name="id_produk" class="form-control" value="" placeholder="Id barang"> 
    <input type="hidden" id="level_hidden" name="level_hidden" class="form-control" value="">   
    <input type="hidden" id="analis" name="analis" class="form-control" value="<?php echo $analis;?>">     
    <input type="hidden" id="petugas_radiologi" name="petugas_radiologi" class="form-control" value="<?php echo $petugas_radiologi;?>">     

    <input type="hidden" id="tipe_produk" name="tipe_produk" class="form-control" value="" placeholder="Tipe Produk">    

    <input type="hidden" id="otoritas_tipe_barang" name="otoritas_tipe_barang" class="form-control" placeholder="Otoritas Tipe Produk" value="<?php echo $barang; ?>">    
    <input type="hidden" id="otoritas_tipe_jasa" name="otoritas_tipe_jasa" class="form-control" placeholder="Otoritas Tipe Jasa" value="<?php echo $jasa; ?>">    
    <input type="hidden" id="otoritas_tipe_alat" name="otoritas_tipe_alat" class="form-control" placeholder="Otoritas Tipe Alat" value="<?php echo $alat; ?>">    
    <input type="hidden" id="otoritas_tipe_bhp" name="otoritas_tipe_bhp" class="form-control" placeholder="Otoritas Tipe Bhp" value="<?php echo $bhp; ?>">    
    <input type="hidden" id="otoritas_tipe_obat" name="otoritas_tipe_produk" class="form-control" placeholder="Otoritas Tipe Obat" value="<?php echo $obat; ?>">    

</form> <!-- tag penutup form -->






                <!--untuk mendefinisikan sebuah bagian dalam dokumen-->  
                <span id="span_tbs">            
                
                  <div class="table-responsive">
                    <table id="tabel_tbs_penjualan" class="table table-bordered table-sm">
                          <thead> <!-- untuk memberikan nama pada kolom tabel -->
                              
                              <th> Kode  </th>
                              <th> Nama </th>
                              <th> Nama Pelaksana </th>
                              <th> Jumlah </th>
                              <th> Satuan </th>
                              <th> Dosis </th>
                              <th> Harga </th>
                              <th> Subtotal </th>
                              <th> Potongan </th>
                              <th> Pajak </th>
                              <th> Hapus </th>
                          
                          </thead> <!-- tag penutup tabel -->
                    </table>
                  </div>

                </span>

<button class="btn btn-primary" id="btnLab" type="button" data-toggle="collapse" data-target="#collapseExample" aria-expanded="false" aria-controls="collapseExample"><i class='fa fa-stethoscope'> </i>
Laboratorium  </button>


<button class="btn btn-primary" id="btnRadiologi" type="button" data-toggle="collapse" data-target="#collapseExampleRadiologi" aria-expanded="false" aria-controls="collapseExample"><i class='fa fa-universal-access'> </i>
Radiologi  </button>



            <div class="collapse" id="collapseExample">
              <span id="span_lab">
                  <div class="table-responsive">
                    <table id="tabel_tbs_lab" class="table table-bordered table-sm">
                          <thead> <!-- untuk memberikan nama pada kolom tabel -->
                              
                              <th> Kode  </th>
                              <th> Nama </th>
                              <th> Nama Petugas</th>
                              <th> Jumlah </th>
                              <th> Harga </th>
                              <th> Subtotal </th>
                              <th> Potongan </th>
                              <th> Pajak </th>
                          
                          </thead> <!-- tag penutup tabel -->
                    </table>
                  </div>
              </span>
            </div>





            <div class="collapse" id="collapseExampleRadiologi">
              <span id="span_radiologi">
                  <div class="table-responsive">
                    <table id="tabel_tbs_radiologi" class="table table-bordered table-sm">
                          <thead> <!-- untuk memberikan nama pada kolom tabel -->
                              
                              <th> Kode  </th>
                              <th> Nama </th>
                              <th> Dokter Pengirim </th>
                              <th style="text-align: right" > Jumlah </th>
                              <th style="text-align: right" > Harga </th>
                              <!--
                              <th style="text-align: right" > Potongan </th>
                              <th style="text-align: right" > Pajak </th>
                              -->
                              <th style="text-align: right" > Subtotal </th>
                          
                          </thead> <!-- tag penutup tabel -->
                    </table>
                  </div>
              </span>
            </div>


                <h6 style="text-align: left ; color: red"><i> * Klik 2x pada kolom jumlah barang jika ingin mengedit.</i></h6>
                <h6 style="text-align: left ;"><i><b> * Short Key (F2) untuk mencari Kode Produk atau Nama Produk.</b></i></h6>

  
</div> <!-- / END COL SM 6 (1)-->



<div class="col-xs-4">



<form action="proses_bayar_jual_kasir.php" id="form_jual" method="POST" >
    

  <div class="form-group">
    <div class="card card-block">
      

      <div class="row">
          <div class="col-xs-6">
           
              <label style="font-size:15px"> <b> Subtotal </b></label><br>
              <input style="height:15px;font-size:15px" type="text" name="total" id="total2" class="form-control" placeholder="Total" readonly="" >
           
          </div>

          <div class="col-xs-6">
              <label>Biaya Admin </label><br>
              <select class="form-control chosen" id="biaya_admin_select" name="biaya_admin_select" >
              <option value="0" selected=""> Silahkan Pilih </option>
                <?php 
                $get_biaya_admin = $db->query("SELECT * FROM biaya_admin");
                while ( $take_admin = mysqli_fetch_array($get_biaya_admin))
                {
                echo "<option value='".$take_admin['persentase']."'>".$take_admin['nama']." ".$take_admin['persentase']."%</option>";
                }
                ?>
              </select>
          </div>

     </div>

     <div class="row">

           <div class="col-xs-6">          
              <label>Biaya Admin (Rp)</label>
              <input type="text" name="biaya_admin_rupiah" style="height:15px;font-size:15px" id="biaya_adm" class="form-control" placeholder="Biaya Admin Rp" autocomplete="off" onkeydown="return numbersonly(this, event);" onkeyup="javascript:tandaPemisahTitik(this);">
           </div>

           <div class="col-xs-6">
              <label>Biaya Admin (%)</label>
              <input type="text" name="biaya_admin_persen" style="height:15px;font-size:15px" id="biaya_admin_persen" class="form-control" placeholder="Biaya Admin %" autocomplete="off" >
           </div>

      </div> 
      
      <div class="row">

                  <?php
                  $ambil_diskon_tax = $db->query("SELECT * FROM setting_diskon_tax");
                  $data_diskon = mysqli_fetch_array($ambil_diskon_tax);

                  ?>

          <div class="col-xs-6">
                <label> Diskon ( Rp )</label><br>
              <input type="text" name="potongan" style="height:15px;font-size:15px" id="potongan_penjualan" value="<?php echo $data_diskon['diskon_nominal']; ?>" class="form-control" placeholder="Diskon Rp" autocomplete="off"  onkeydown="return numbersonly(this, event);" onkeyup="javascript:tandaPemisahTitik(this);">
          </div>


          <div class="col-xs-6">
 
          <label> Diskon ( % )</label><br>
          <input type="text" name="potongan_persen" style="height:15px;font-size:15px" id="potongan_persen" value="<?php echo $data_diskon['diskon_persen']; ?>%" class="form-control" placeholder="Diskon %" autocomplete="off" onkeydown="return numbersonly(this, event);" >
          </div>
<!--
          <div class="col-xs-4">
            
           <label> Pajak (%)</label>
           <input type="text" name="tax" id="tax" style="height:15px;font-size:15px" value="<?php echo $data_diskon['tax']; ?>" style="height:15px;font-size:15px" class="form-control" autocomplete="off" >

           </div>-->

          </div>
          

          <div class="row">
            <!--
           <input type="hidden" name="tax_rp" id="tax_rp" class="form-control"  autocomplete="off" >-->
           
           <label style="display: none"> Adm Bank  (%)</label>
           <input type="hidden" name="adm_bank" id="adm_bank"  value="" class="form-control" >
           
           <div class="col-xs-6">
             
           <label> Tanggal Jatuh Tempo</label>
           <input type="text" name="tanggal_jt" id="tanggal_jt"  value="" style="height:15px;font-size:15px" placeholder="Tanggal JT" class="form-control" >

           </div>


        <div class="col-xs-6">
            <label style="font-size:15px"> <b> Cara Bayar (F4) </b> </label><br>
                      <select type="text" name="cara_bayar" id="carabayar1" class="form-control"  style="font-size: 15px" >
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
           <b><input type="text" name="sisa_pembayaran"  id="sisa_pembayaran_penjualan"  style="height:15px;font-size:15px" class="form-control"  readonly=""></b>
            </div>

            <div class="col-xs-6">
              
          <label> Kredit </label><br>
          <b><input type="text" name="kredit" id="kredit" class="form-control"  style="height:15px;font-size:15px"  readonly="" ></b>
            </div>
          </div> 
          


           
           <label> Keterangan </label><br>
           <textarea style="height:40px;font-size:15px" type="text" name="keterangan" id="keterangan" class="form-control"> 
           </textarea>


          
          
          <?php 
          
          if ($_SESSION['otoritas'] == 'Pimpinan') {
          echo '<label style="display:none"> Total Hpp </label><br>
          <input type="hidden" name="total_hpp" id="total_hpp" style="height: 50px; width:90%; font-size:25px;" class="form-control" placeholder="" readonly="">';
          }
          
          
          //Untuk Memutuskan Koneksi Ke Database
          mysqli_close($db);   
          ?>



      </div><!-- END card-block -->

       </div>

          

         
          <input style="height:15px" type="hidden" name="jumlah" id="jumlah1" class="form-control" placeholder="jumlah">
          
          
          <!-- memasukan teks pada kolom kode pelanggan, dan nomor faktur penjualan namun disembunyikan -->

          
          <input type="hidden" name="kode_pelanggan" id="k_pelanggan" class="form-control" >
          <input type="hidden" name="ppn_input" id="ppn_input" value="Include" class="form-control" placeholder="ppn input">  
      

          <div class="row">
 
           <?php if ($otoritas_tombol['tombol_bayar'] > 0):?>              
          <button type="submit" id="penjualan" class="btn btn-info" style="font-size:15px;">Bayar (F8)</button>
          <button type="submit" id="transaksi_baru" style="display: none" class="btn btn-info" style="font-size:15px;"> Transaksi Baru (Ctrl + M)</button>
          <a class="btn btn-info" href="pasien_sudah_masuk.php" id="transaksi_baru" style="display: none">  Transaksi Baru (Ctrl + M)</a>

          <?php endif;?>
        
          
          <?php if ($otoritas_tombol['tombol_piutang'] > 0):?>  
          <button type="submit" id="piutang" class="btn btn-warning" style="font-size:15px">Piutang (F9)</button>
          <?php endif;?>

          <a href='cetak_penjualan_piutang.php' id="cetak_piutang" style="display: none;" class="btn btn-success" target="blank">Cetak Piutang  </a>

          <?php if ($otoritas_tombol['tombol_simpan'] > 0):?>  

          <button type="submit" id="simpan_sementara" class="btn btn-primary" style="font-size:15px">  Simpan (F10)</button>

          <?php endif;?>

          <a href='cetak_penjualan_tunai_rj.php' id="cetak_tunai" style="display: none;" class="btn btn-primary" target="blank"> Cetak Tunai  </a>

           <?php if ($otoritas_tombol['tombol_bayar'] > 0):?>              

          <button type="submit" id="cetak_langsung" target="blank" class="btn btn-success" style="font-size:15px"> Bayar / Cetak (Ctrl + K) </button>

          <?php endif;?>

           <a href='cetak_penjualan_tunai_kategori_rj.php' id="cetak_tunai_kategori" style="display: none;" class="btn btn-warning" target="blank"> Cetak Tunai/Kategori  </a>

           <?php if ($otoritas_tombol['tombol_batal'] > 0):?>
              <button type="submit" id="batal_penjualan" class="btn btn-danger" style="font-size:15px">  Batal (Ctrl + B)</button>
           <?php endif;?>

         

          <a href='cetak_penjualan_tunai_besar_rj.php' id="cetak_tunai_besar" style="display: none;" class="btn btn-warning" target="blank"> Cetak Tunai  Besar </a>
          
     
    
          <br>
          </div> <!--row 3-->
          
          <div class="alert alert-success" id="alert_berhasil" style="display:none">
          <strong>Sukses!</strong> Pembayaran Berhasil
          </div>
          
          <div class="alert alert-success" id="alert_simpan_berhasil" style="display:none">
          <strong>Sukses!</strong> Simpan Berhasil
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
  $(document).on('click', '.tidak_punya_otoritas', function (e) {
    alert("Anda Tidak Punya Otoritas Untuk Edit Jumlah Produk !!");
  });
</script>

<script type="text/javascript">
  $(document).ready(function(){

  $(document).on('click','#btnRefreshsubtotal',function(e){

    var no_reg = $("#no_reg").val();


    if (no_reg == '') {
      alert("Anda belum memilih pasien!");
    }
    else
    {
      $.post("proses_refresh_subtotal.php",{no_reg:no_reg},function(data){

        if (data == '') {
          data = 0;
        }

            var biaya_admin = $("#biaya_admin_select").val();
            var hitung_biaya = parseInt(biaya_admin,10) * parseInt(data,10) / 100;

            $("#biaya_adm").val(tandaPemisahTitik(Math.round(hitung_biaya)));

            var diskon = bersihPemisah(bersihPemisah(bersihPemisah(bersihPemisah($("#potongan_penjualan").val()))));
            if(diskon == '')
            {
              diskon = 0
            }
           var hasilnya = parseInt(data,10) + parseInt(Math.round(hitung_biaya),10) - parseInt(diskon,10);

            $("#total1").val(tandaPemisahTitik(hasilnya));
            $("#total2").val(tandaPemisahTitik(data));

      });
    }

  });

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
      $("#biaya_adm").val(0);
      $("#biaya_admin_persen").val(data_admin);

  }
  else if (biaya_admin > 0) {

      var hitung_biaya = parseInt(total2,10) * parseInt(data_admin,10) / 100;
       if (total2 == "" || total2 == 0) {
       hitung_biaya = 0;
       }

      $("#biaya_adm").val(Math.round(hitung_biaya));
      var biaya_admin = bersihPemisah(bersihPemisah(bersihPemisah(bersihPemisah($("#biaya_adm").val()))));      
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




<script type="text/javascript" language="javascript" >
   $(document).ready(function() {
        var dataTable = $('#tabel_cari').DataTable( {
          "processing": true,
          "serverSide": true,
          "ajax":{
            url :"modal_jual_baru.php", // json datasource
            type: "post",  // method  , by default get
            error: function(){  // error handling
              $(".employee-grid-error").html("");
              $("#tabel_cari").append('<tbody class="employee-grid-error"><tr><th colspan="3">Data Tidak Ditemukan.. !!</th></tr></tbody>');
              $("#employee-grid_processing").css("display","none");
              
            }
          },

          "fnCreatedRow": function( nRow, aData, iDataIndex ) {

              $(nRow).attr('class', "pilih");
              $(nRow).attr('data-kode', aData[0]);
              $(nRow).attr('nama-barang', aData[1]);
              $(nRow).attr('harga', aData[2]);
              $(nRow).attr('harga_level_2', aData[3]);
              $(nRow).attr('harga_level_3', aData[4]);
              $(nRow).attr('harga_level_4', aData[5]);
              $(nRow).attr('harga_level_5', aData[6]);
              $(nRow).attr('harga_level_6', aData[7]);
              $(nRow).attr('harga_level_7', aData[8]);
              $(nRow).attr('jumlah-barang', aData[9]);
              $(nRow).attr('satuan', aData[17]);
              $(nRow).attr('kategori', aData[11]);
              $(nRow).attr('status', aData[16]);
              $(nRow).attr('suplier', aData[12]);
              $(nRow).attr('limit_stok', aData[13]);
              $(nRow).attr('ber-stok', aData[14]);
              $(nRow).attr('tipe_barang', aData[15]);
              $(nRow).attr('id-barang', aData[18]);



          }

        });    
     
  });
 
 </script>

<script type="text/javascript" language="javascript" >
   $(document).ready(function() {
        var dataTable = $('#tabel_cari_pasien').DataTable( {
          "processing": true,
          "serverSide": true,
          "ajax":{
            url :"modal_pasien_penjualan.php", // json datasource
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
              $(nRow).attr('no_rm', aData[1]+" | "+aData[2]+"");
              $(nRow).attr('nama_pasien', aData[2]);
              $(nRow).attr('penjamin', aData[5]);
              $(nRow).attr('poli', aData[6]);
              $(nRow).attr('dokter', aData[7]);
              $(nRow).attr('level_harga', aData[8]);


          }

        });    
     
  });
 
 </script>




 <script type="text/javascript">
   $(document).on('click', '.pilih-reg', function (e) {                
            document.getElementById("no_reg").value = $(this).attr('no_reg');
            document.getElementById("no_rm").value = $(this).attr('no_rm');
            document.getElementById("nama_pasien").value = $(this).attr('nama_pasien');
            document.getElementById("level_hidden").value = $(this).attr('level_harga');
            document.getElementById("asal_poli").value = $(this).attr('poli');

            document.getElementById("penjamin").value = $(this).attr('penjamin');
            $("#penjamin").trigger('chosen:updated');

            document.getElementById("dokter").value = $(this).attr('dokter');
            $("#dokter").trigger('chosen:updated');

            document.getElementById("level_harga").value = $(this).attr('level_harga');
            $("#level_harga").trigger('chosen:updated');

            $('#modal_reg').modal('hide'); 

// START DATATABLE AJAX START DATATABLE AJAX START DATATABLE AJAX START DATATABLE AJAX START DATATABLE AJAX START DATATABLE AJAX
      $('#tabel_tbs_penjualan').DataTable().destroy();
            var dataTable = $('#tabel_tbs_penjualan').DataTable( {
            "processing": true,
            "serverSide": true,
            "info":     false,
            "language": { "emptyTable":     "My Custom Message On Empty Table" },
            "ajax":{
              url :"data_tbs_penjualan.php", // json datasource
               "data": function ( d ) {
                  d.no_reg = $("#no_reg").val();
                  // d.custom = $('#myInput').val();
                  // etc
              },
                  type: "post",  // method  , by default get
              error: function(){  // error handling
                $(".tbody").html("");
                $("#tabel_tbs_penjualan").append('<tbody class="tbody"><tr><th colspan="3"></th></tr></tbody>');
                $("#tableuser_processing").css("display","none");
                
              }
            }   

      });
        
        $("#span_tbs").show()
        $("#btnRujukLab").show()
        $("#btnRujukRadiologi").show()
        $('#pembayaran_penjualan').val('');
        $('#biaya_adm').val('');
        $('#biaya_admin_select').val('0');
        $("#biaya_admin_select").trigger('chosen:updated');
        $('#potongan_penjualan').val('');
        $('#potongan_persen').val('');

        //End Cek Hasil Laboratorium
            var pasien = $("#nama_pasien").val();
            var no_reg = $("#no_reg").val();
            $.post("cek_setting_laboratorium.php",{no_reg:no_reg},function(data){
              if(data == 1){
                $("#penjualan").hide();
                 $("#simpan_sementara").hide();
                 $("#batal_penjualan").hide(); 
                 $("#cetak_langsung").hide();
                 $("#piutang").hide();
                alert("Pasien atas nama ("+pasien+") Hasil laboratorium belum di isi!");

              }
              else
              {
                 $("#penjualan").show();
                 $("#simpan_sementara").show();
                 $("#batal_penjualan").show(); 
                 $("#cetak_langsung").show();
                 $("#piutang").show();
              }
            });
      //End Cek Hasil Laboratorium

// END DATATABLE AJAX END DATATABLE AJAX END DATATABLE AJAX END DATATABLE AJAX END DATATABLE AJAX END DATATABLE AJAX


// CEK TOTAL CEK TOTAL CEK TOTAL CEK TOTAL CEK TOTAL CEK TOTAL CEK TOTAL CEK TOTAL CEK TOTAL CEK TOTAL CEK TOTAL CEK TOTAL CEK TOTAL

    var no_reg = $("#no_reg").val();
    var pot_fakt_per = bersihPemisah(bersihPemisah(bersihPemisah(bersihPemisah($("#potongan_persen").val()))));
    var pot_fakt_rp = bersihPemisah(bersihPemisah(bersihPemisah(bersihPemisah($("#potongan_penjualan").val()))));


     //digunakan untuk mengecek sama tidaknya jumlah disc dg total_subtotal di tbs
  $.getJSON("cek_jumlah_disc_dg_total_sub_tbs.php",{no_reg:no_reg},function(oke){
       
          $("#subt_tbs").val(oke.totale);
        $("#disc_tbs").val(oke.potongane);

      });


    $.post("cek_total_seluruh_raja.php",{no_reg:no_reg},function(data1){
  
        if (data1 == 1) {
                 $.post("cek_total_seluruh.php",{no_reg:no_reg},function(data){
                data = data.replace(/\s+/g, '');
                if (data == "") {
                    data = 0;
                  }

                var sum = parseInt(data,10);

                  $("#total2").val(tandaPemisahTitik(sum))

      if (pot_fakt_per == '0%') {
         
          var potongann = pot_fakt_rp;
          var potongaaan = parseInt(potongann,10) / parseInt(data,10) * 100;
          if (data == "") {
              data = 0;
              $("#potongan_persen").val(Math.round('0'));
          }
          else{
            $("#potongan_persen").val(Math.round(potongaaan));
          }
    
              
              


      var total = parseInt(data,10) - parseInt(pot_fakt_rp,10);
                  $("#total1").val(tandaPemisahTitik(total))

            }
            else if(pot_fakt_rp == 0)
            {
               if (data == "") {
                    data = 0;
                }

                  var potongaaan = pot_fakt_per;
                  var pos = potongaaan.search("%");
                  var potongan_persen = bersihPemisah(bersihPemisah(bersihPemisah(bersihPemisah(potongaaan))));
                  potongan_persen = potongan_persen.replace("%","");
                  potongaaan = data * potongan_persen / 100;
                  $("#potongan_penjualan").val(Math.round(potongaaan));
                  $("#potongan1").val(potongaaan);


      var total = parseInt(data,10) - parseInt(potongaaan,10);
                  $("#total1").val(tandaPemisahTitik(total))
            }
      

                });
        }
        else
        {
          $("#total1").val('0')
          $("#total2").val('0')
        }


      });

    // END CEK TOTAL END CEK TOTAL END CEK TOTAL END CEK TOTAL END CEK TOTAL END CEK TOTAL END CEK TOTAL END CEK TOTAL END CEK TOTAL END CEK TOTAL

// CEK JATUH TEMPO
var penjamin = $("#penjamin").val();
  $.getJSON('jatuh_tempo_json.php',{penjamin:penjamin}, function(json){
      
      if (json == null)
      {        
        $('#tanggal_jt').val('');
      }
      else 
      {        
        $('#tanggal_jt').val(json.harga);
      }
  });
// END JATUH TEMPO


});
 </script>



<script type="text/javascript" language="javascript" >

  $(document).ready(function() {
    $(document).on('click', '#btnLab', function (e) {
      $('#tabel_tbs_lab').DataTable().destroy();
            var dataTable = $('#tabel_tbs_lab').DataTable( {
            "processing": true,
            "serverSide": true,
            "info":     false,
            "language": { "emptyTable":     "My Custom Message On Empty Table" },
            "ajax":{
              url :"data_tbs_lab.php", // json datasource
               "data": function ( d ) {
                  d.no_reg = $("#no_reg").val();
                  // d.custom = $('#myInput').val();
                  // etc
              },
                  type: "post",  // method  , by default get
              error: function(){  // error handling
                $(".tbody").html("");
                $("#tabel_tbs_lab").append('<tbody class="tbody"><tr><th colspan="3"></th></tr></tbody>');
                $("#tableuser_processing").css("display","none");
                
              }
            }   

      });
        
        $("#span_lab").show()

    });

  });

</script>



<script type="text/javascript" language="javascript" >

  $(document).ready(function() {
    $(document).on('click', '#btnRadiologi', function (e) {
      $('#tabel_tbs_radiologi').DataTable().destroy();
            var dataTable = $('#tabel_tbs_radiologi').DataTable( {
            "processing": true,
            "serverSide": true,
            "info":     false,
            "language": { "emptyTable":     "My Custom Message On Empty Table" },
            "ajax":{
              url :"data_tbs_radiologi.php", // json datasource
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
        
        $("#span_radiologi").show()

    });

  });

</script>


<script type="text/javascript">
    $(document).on('click', '#btnRujukLab', function (e) {

    var no_reg = $("#no_reg").val();
    var no_rm = $("#no_rm").val();
    var no_rm = no_rm.substr(0, no_rm.indexOf(' |'));
    var nama = $("#nama_pasien").val();
    var dokter = $("#dokter").val();
    var jenis_penjualan = 'Rawat Jalan';
    var rujukan = 'Rujuk Rawat Jalan';

        $("#btnRujukLab").attr('href', 'form_penjualan_lab.php?no_rm='+no_rm+'&nama='+nama+'&no_reg='+no_reg+'&dokter='+dokter+'&jenis_penjualan='+jenis_penjualan+'&rujukan='+rujukan+'');

    });
</script>

<script type="text/javascript">
    $(document).on('click', '#btnRujukRadiologi', function (e) {

    var no_reg = $("#no_reg").val();
    var no_rm = $("#no_rm").val();
    var no_rm = no_rm.substr(0, no_rm.indexOf(' |'));
    var nama = $("#nama_pasien").val();
    var dokter = $("#dokter").val();
    var penjamin = $("#penjamin").val();
    var jenis_penjualan = 'Rawat Jalan';
    var rujukan = 'Rujuk Rawat Jalan';

        $("#btnRujukRadiologi").attr('href', 'form_pemeriksaan_radiologi.php?no_rm='+no_rm+'&nama='+nama+'&no_reg='+no_reg+'&dokter='+dokter+'&jenis_penjualan='+jenis_penjualan+'&rujukan='+rujukan+'&penjamin='+penjamin+'');

    });
</script>


<!--untuk memasukkan perintah java script-->
<script type="text/javascript">

// jika dipilih, nim akan masuk ke input dan modal di tutup
  $(document).on('click', '.pilih', function (e) {


  document.getElementById("kode_barang").value = $(this).attr('data-kode');
    $("#kode_barang").trigger('chosen:updated');

  document.getElementById("nama_barang").value = $(this).attr('nama-barang');
  document.getElementById("limit_stok").value = $(this).attr('limit_stok');
  document.getElementById("satuan_produk").value = $(this).attr('satuan');
  document.getElementById("ber_stok").value = $(this).attr('ber-stok');
  document.getElementById("harga_lama").value = $(this).attr('harga');
  document.getElementById("harga_baru").value = $(this).attr('harga');
  document.getElementById("satuan_konversi").value = $(this).attr('satuan');
  document.getElementById("id_produk").value = $(this).attr('id-barang');
  document.getElementById("tipe_produk").value = $(this).attr('tipe_barang');

    var session_id = $("#session_id").val();
    var no_reg = $("#no_reg").val();
    var kode_barang = $("#kode_barang").val();

 $.post('cek_kode_barang_tbs_penjualan.php',{kode_barang:kode_barang,session_id:session_id,no_reg:no_reg}, function(data){
  
  if(data == 1){
    alert("Anda Tidak Bisa Menambahkan Barang Yang Sudah Ada, Silakan Edit atau Pilih Barang Yang Lain !");
    $("#kode_barang").val('');
    $("#kode_barang").trigger('chosen:updated');
    $("#kode_barang").trigger('chosen:open');
    $("#nama_barang").val('');
   }//penutup if

    });////penutup function(data)

var tipe_produk = $("#tipe_produk").val();

if (tipe_produk == 'Obat Obatan') {
      $("#col_dosis").show();
    }
   else{
      $("#col_dosis").hide();
    }  


var nama_barang = $("#nama_barang").val();
var otoritas_tipe_barang = $("#otoritas_tipe_barang").val();
var otoritas_tipe_jasa = $("#otoritas_tipe_jasa").val();
var otoritas_tipe_alat = $("#otoritas_tipe_alat").val();
var otoritas_tipe_bhp = $("#otoritas_tipe_bhp").val();
var otoritas_tipe_obat = $("#otoritas_tipe_obat").val();

  if (no_reg == ""){
         alert("No. Reg Tidak Boleh Kosong !");
         $("#jumlah_barang").val('');
         $("#nama_barang").val('');
         $("#kode_barang").val('');
         $("#dosis_obat").val('');
         $("#col_dosis").hide();
         $("#kode_barang").trigger('chosen:updated');
         $("#cari_pasien").click();
        
    }

  else if(tipe_produk == 'Barang' && otoritas_tipe_barang < 1){
          alert("Anda Tidak Mempunyai Akses Menambahkan "+nama_barang+" !");

          $("#kode_barang").val('');
          $("#tipe_produk").val('');
          $("#nama_barang").val('');
          $("#kode_barang").trigger('chosen:updated');
          $("#kode_barang").trigger('chosen:open');
          $(".chosen").chosen({no_results_text: "Maaf, Data Tidak Ada!",search_contains:true}); 
   }//penutup if     

  else if(tipe_produk == 'Jasa' && otoritas_tipe_jasa < 1){
          alert("Anda Tidak Mempunyai Akses Menambahkan "+nama_barang+" !");

          $("#kode_barang").val('');
          $("#tipe_produk").val('');
          $("#nama_barang").val('');
          $("#kode_barang").trigger('chosen:updated');
          $("#kode_barang").trigger('chosen:open');
          $(".chosen").chosen({no_results_text: "Maaf, Data Tidak Ada!",search_contains:true}); 
   }//penutup if     

  else if(tipe_produk == 'Alat' && otoritas_tipe_alat < 1){
          alert("Anda Tidak Mempunyai Akses Menambahkan "+nama_barang+" !");

          $("#kode_barang").val('');
          $("#tipe_produk").val('');
          $("#nama_barang").val('');
          $("#kode_barang").trigger('chosen:updated');
          $("#kode_barang").trigger('chosen:open');
          $(".chosen").chosen({no_results_text: "Maaf, Data Tidak Ada!",search_contains:true}); 
   }//penutup if     

  else if(tipe_produk == 'BHP' && otoritas_tipe_bhp < 1){
          alert("Anda Tidak Mempunyai Akses Menambahkan "+nama_barang+" !");

          $("#kode_barang").val('');
          $("#tipe_produk").val('');
          $("#nama_barang").val('');
          $("#kode_barang").trigger('chosen:updated');
          $("#kode_barang").trigger('chosen:open');
          $(".chosen").chosen({no_results_text: "Maaf, Data Tidak Ada!",search_contains:true}); 
   }//penutup if     

  else if(tipe_produk == 'Obat Obatan' && otoritas_tipe_obat < 1){
          alert("Anda Tidak Mempunyai Akses Menambahkan "+nama_barang+" !");

          $("#kode_barang").val('');
          $("#tipe_produk").val('');
          $("#nama_barang").val('');
          $("#kode_barang").trigger('chosen:updated');
          $("#kode_barang").trigger('chosen:open');
          $(".chosen").chosen({no_results_text: "Maaf, Data Tidak Ada!",search_contains:true}); 
          $("#col_dosis").hide();
   }//penutup if   

var level_harga = $("#level_harga").val();

var harga_level_1 = $(this).attr('harga');
var harga_level_2 = $(this).attr('harga_level_2');  
var harga_level_3 = $(this).attr('harga_level_3');
var harga_level_4 = $(this).attr('harga_level_4');
var harga_level_5 = $(this).attr('harga_level_5');  
var harga_level_6 = $(this).attr('harga_level_6');
var harga_level_7 = $(this).attr('harga_level_7');

if (level_harga == "harga_1") {
  $("#harga_produk").val(harga_level_1);
  $("#harga_lama").val(harga_level_1);
  $("#harga_baru").val(harga_level_1);
  $('#kolom_cek_harga').val('1');
}

else if (level_harga == "harga_2") {
  $("#harga_produk").val(harga_level_2);
  $("#harga_baru").val(harga_level_2);
  $("#harga_lama").val(harga_level_2);
  $('#kolom_cek_harga').val('1');
}

else if (level_harga == "harga_3") {
  $("#harga_produk").val(harga_level_3);
  $("#harga_lama").val(harga_level_3);
  $("#harga_baru").val(harga_level_3);
  $('#kolom_cek_harga').val('1');
}

else if (level_harga == "harga_4") {
  $("#harga_produk").val(harga_level_4);
  $("#harga_lama").val(harga_level_4);
  $("#harga_baru").val(harga_level_4);
  $('#kolom_cek_harga').val('1');
}

else if (level_harga == "harga_5") {
  $("#harga_produk").val(harga_level_5);
  $("#harga_lama").val(harga_level_5);
  $("#harga_baru").val(harga_level_5);
  $('#kolom_cek_harga').val('1');
}

else if (level_harga == "harga_6") {
  $("#harga_produk").val(harga_level_6);
  $("#harga_lama").val(harga_level_6);
  $("#harga_baru").val(harga_level_6);
  $('#kolom_cek_harga').val('1');
}

else if (level_harga == "harga_7") {
  $("#harga_produk").val(harga_level_7);
  $("#harga_lama").val(harga_level_7);
  $("#harga_baru").val(harga_level_7);
  $('#kolom_cek_harga').val('1');
}

  document.getElementById("jumlahbarang").value = $(this).attr('jumlah-barang');


  $('#myModal').modal('hide'); 
  $("#jumlah_barang").focus();


});

  </script>


<script type="text/javascript">
$(document).ready(function(){
  //end cek level harga
  $("#level_harga").change(function(){
  
  var level_harga = $("#level_harga").val();
  var kode_barang = $("#kode_barang").val()
  var satuan_konversi = $("#satuan_konversi").val();
  var jumlah_barang = bersihPemisah(bersihPemisah(bersihPemisah(bersihPemisah($("#jumlah_barang").val()))));
  var level_hidden = $("#level_hidden").val();

  var id_produk = $("#id_produk").val();

  $('#kolom_cek_harga').val('0');

  if (jumlah_barang == "") {
    alert ("Jumlah Barang Harus Diisi !");
    $("#level_harga").val(level_hidden);
  }
  else{
    $.post("cek_level_harga_barang.php", {level_harga:level_harga, kode_barang:kode_barang,jumlah_barang:jumlah_barang,id_produk:id_produk,satuan_konversi:satuan_konversi},function(data){

          $("#harga_produk").val(data);
          $("#harga_baru").val(data);
          $('#kolom_cek_harga').val('1');
        });
  }


    });
});
//end cek level harga
</script>




<!-- cek stok satuan konversi id=_change-->
<script type="text/javascript">
  $(document).ready(function(){
    $("#satuan_konversi").change(function(){
      var jumlah_barang = bersihPemisah(bersihPemisah(bersihPemisah(bersihPemisah($("#jumlah_barang").val()))));
      var satuan_konversi = $("#satuan_konversi").val();
      var kode_barang = $("#kode_barang").val();
 
      var id_produk = $("#id_produk").val();
      var prev = $("#satuan_produk").val();
      var ber_stok = $("#ber_stok").val();
      


      $.post("cek_stok_konversi_penjualan.php", {jumlah_barang:jumlah_barang,satuan_konversi:satuan_konversi,kode_barang:kode_barang,id_produk:id_produk},function(data){

      

      if (stok < 0 && ber_stok == 'Barang' ) {
				alert("Jumlah Melebihi Stok");
				$("#jumlah_barang").val('');
				$("#satuan_konversi").val(prev);
			}
			else{

			}


      });
    });
  });
</script>
<!-- end cek stok satuan konversi change-->


<script>
$(document).ready(function(){
    $("#satuan_konversi").change(function(){

      var prev = $("#satuan_produk").val();
      var harga_lama = $("#harga_lama").val();
      var satuan_konversi = $("#satuan_konversi").val();
      var id_produk = $("#id_produk").val();
      var harga_produk = $("#harga_lama").val();
      var jumlah_barang = bersihPemisah(bersihPemisah(bersihPemisah(bersihPemisah($("#jumlah_barang").val()))));
      var kode_barang = $("#kode_barang").val();
 

      

      $.getJSON("cek_konversi_penjualan.php",{kode_barang:kode_barang,satuan_konversi:satuan_konversi,id_produk:id_produk,harga_produk:harga_produk,jumlah_barang:jumlah_barang},function(info){



        if (satuan_konversi == prev) {

          $("#harga_produk").val(harga_lama);
          $("#harga_baru").val(harga_lama);

        }

        else if (info.jumlah_total == 0) {
          alert('Satuan Yang Anda Pilih Tidak Tersedia Untuk Produk Ini !');
          $("#satuan_konversi").val(prev);
          $("#harga_produk").val(harga_lama);
          $("#harga_baru").val(harga_lama);

        }

        else{
 
          $("#harga_produk").val(info.harga_pokok);
          $("#harga_baru").val(info.harga_pokok);
        }

      });

        
    });

});
</script>




      <script type="text/javascript">
      
      $(".chosen").chosen({no_results_text: "Maaf, Data Tidak Ada!",search_contains:true});  
      
      </script>

<script type="text/javascript">

  $(document).ready(function(){
    $(document).on('click','.edit-jumlah',function(e){
      var kode_barang = $(this).attr("data-kode-barang-input");
      var tipe_produk = $('#opt-produk-'+kode_barang).attr("tipe_barang");
      
      $("#tipe_produk").val(tipe_produk);
    });
  });

</script>

<script type="text/javascript">

  $(document).ready(function(){
    $(document).on('click','#transaksi_baru',function(e){

       $('#tabel_cari_pasien').DataTable().destroy();
        var dataTable = $('#tabel_cari_pasien').DataTable( {
          "processing": true,
          "serverSide": true,
          "ajax":{
            url :"modal_pasien_penjualan.php", // json datasource
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
              $(nRow).attr('no_rm', aData[1]+" | "+aData[2]+"");
              $(nRow).attr('nama_pasien', aData[2]);
              $(nRow).attr('penjamin', aData[5]);
              $(nRow).attr('poli', aData[6]);
              $(nRow).attr('dokter', aData[7]);
              $(nRow).attr('level_harga', aData[8]);


          }

        });  

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
            $("#no_reg").val('');
            $("#asal_poli").val('');
            $("#penjamin").val('');
            $("#level_harga").val('');
            $("#keterangan").val('');
            $("#penjualan").show();
            $("#cetak_langsung").show();
            $("#simpan_sementara").show();
            $("#piutang").show();
            $("#batal_penjualan").show(); 
            $("#transaksi_baru").hide();
            $("#alert_berhasil").hide();
            $("#alert_simpan_berhasil").hide();
            $("#cetak_tunai").hide();
            $("#cetak_tunai_besar").hide();
            $("#cetak_piutang").hide();
            $("#cetak_tunai_kategori").hide(); 
            $("#btnRujukLab").hide();   
            $("#btnRujukRadiologi").hide();    
            $('#span_tbs').hide();
            $('#span_lab').hide();

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
   //untuk menampilkan data yang diambil pada form tbs penjualan berdasarkan id=formtambahproduk
   $(document).ready(function(){
  $("#submit_produk").click(function(){
    var id_user = $("#id_user").val(); 
    var no_reg = $("#no_reg").val();
    var no_rm = $("#no_rm").val();
    var no_rm = no_rm.substr(0, no_rm.indexOf(' |'));
    var dokter = $("#dokter").val();
    var penjamin = $("#penjamin").val();
    var asal_poli = $("#asal_poli").val();
    var level_harga = $("#level_harga").val();
    var petugas_kasir = $("#petugas_kasir").val();   
    var petugas_paramedik = $("#petugas_paramedik").val();
    var petugas_farmasi = $("#petugas_farmasi").val();
    var petugas_lain = $("#petugas_lain").val();
    var kode_barang = $("#kode_barang").val();
    var nama_barang = $("#nama_barang").val();
    var limit_stok = $("#limit_stok").val();
    var dosis_obat = $("#dosis_obat").val();

    var kolom_cek_harga = $("#kolom_cek_harga").val();
    
    var jumlah_barang = bersihPemisah(bersihPemisah(bersihPemisah(bersihPemisah($("#jumlah_barang").val()))));
    if (jumlahbarang == '')
    {
      jumlahbarang = 0;
    }
    var harga = bersihPemisah(bersihPemisah(bersihPemisah(bersihPemisah($("#harga_produk").val()))));
    if (harga == '')
    {
      harga = 0;
    }

    var potongan = $("#potongan1").val();
    var tax = $("#tax1").val();

    var data_admin = bersihPemisah(bersihPemisah(bersihPemisah(bersihPemisah($("#biaya_admin_select").val()))));                            
      if (data_admin == '') {
         data_admin = 0;
      }

//potongan
    if (potongan == '') {
      potongan = 0;
    }
     else
          {
            var pos = potongan.search("%");
           if (pos > 0) 
            {
               var potongan_persen = bersihPemisah(bersihPemisah(bersihPemisah(bersihPemisah($("#potongan1").val()))));
               potongan_persen = potongan_persen.replace("%","");
               potongan = jumlah_barang * harga * potongan_persen / 100 ;
            };
          }
//potongan

    var tax = bersihPemisah(bersihPemisah(bersihPemisah(bersihPemisah($("#tax1").val()))));
        if (tax == '') {
      tax = 0;
    };
      /*
    var tax_faktur = bersihPemisah(bersihPemisah(bersihPemisah(bersihPemisah($("#tax").val()))));
        if (tax_faktur == '') {
      tax_faktur = 0;
    };*/

    var jumlahbarang = $("#jumlahbarang").val();
    var satuan = $("#satuan_konversi").val();
    var a = $(".tr-kode-"+kode_barang+"").attr("data-kode-barang");    
    var ber_stok = $("#ber_stok").val();
    var ppn = $("#ppn").val();
    var stok = parseInt(jumlahbarang,10) - parseInt(jumlah_barang,10);

    var subtotal = bersihPemisah(bersihPemisah(bersihPemisah(bersihPemisah($("#total2").val()))));

    var pot_fakt_per = bersihPemisah(bersihPemisah(bersihPemisah(bersihPemisah($("#potongan_persen").val()))));

    var pot_fakt_rp = bersihPemisah(bersihPemisah(bersihPemisah(bersihPemisah($("#potongan_penjualan").val()))));

     if (subtotal == "") {
        subtotal = 0;
      };

if (kode_barang != '')
{


    if (ppn == 'Exclude') {
  
         var total1 = parseInt(jumlah_barang,10) * parseInt(harga,10) - parseInt(potongan,10);

         var total_tax_exclude = parseInt(total1,10) * parseInt(tax,10) / 100;

         
          var total = parseInt(total1,10) + parseInt(Math.round(total_tax_exclude,10));

    }
    else
    {
        var total = parseInt(jumlah_barang,10) * parseInt(harga,10) - parseInt(potongan,10);
    }
   


 
      var total_akhir1 = parseInt(subtotal,10) + parseInt(total,10);
    
     var biaya_adm = parseInt(total_akhir1,10) * data_admin /100;



   if (pot_fakt_per == '0%') {
      var potongaaan = pot_fakt_rp;

      var potongaaan = parseInt(potongaaan,10) / parseInt(total_akhir1,10) * 100;

  /*
      var hitung_tax = parseInt(total_akhir1,10) - parseInt(pot_fakt_rp,10);*/

      var pot_pers = parseInt(pot_fakt_rp,10) / parseInt(total_akhir1,10) * 100; 

        var total_akhir = parseInt(total_akhir1,10) - parseInt(pot_fakt_rp,10) + parseInt(Math.round(biaya_adm,10));


    }
    else if(pot_fakt_rp == 0)
    {
      var potongaaan = pot_fakt_per;
      var pos = potongaaan.search("%");
      var potongan_persen = bersihPemisah(bersihPemisah(bersihPemisah(bersihPemisah(potongaaan))));
          potongan_persen = potongan_persen.replace("%","");

      potongaaan = total_akhir1 * potongan_persen / 100;


     var total_akhir = parseInt(total_akhir1,10) - parseInt(Math.round(potongaaan,10)) + parseInt(Math.round(biaya_adm,10));
     var pot_pers = parseInt(potongaaan,10) / parseInt(total_akhir1,10) * 100; 

    }
     else if(pot_fakt_rp != 0 && pot_fakt_rp != 0)
    {
      var potongaaan = pot_fakt_per;
      var pos = potongaaan.search("%");
      var potongan_persen = bersihPemisah(bersihPemisah(bersihPemisah(bersihPemisah(potongaaan))));
          potongan_persen = potongan_persen.replace("%","");
          if(potongan_persen != 0 )
          {
          potongaaan = total_akhir1 * potongan_persen / 100;

          }
          else
          {
            potongaaan = 0;
          }


      var total_akhir = parseInt(total_akhir1,10) - parseInt(Math.round(potongaaan,10)) + parseInt(biaya_adm,10)    ;
      var pot_pers = parseInt(potongaaan,10) / parseInt(total_akhir1,10) * 100; 

    }



if (kolom_cek_harga == '0') {
  alert ("Harga Tidak Sesuai, Tunggu Sebentar !");  

}
else if (a > 0){
  alert("Anda Tidak Bisa Menambahkan Barang Yang Sudah Ada, Silakan Edit atau Pilih Barang Yang Lain !");
       $("#kode_barang").trigger('chosen:open');
  }

  else if (jumlah_barang == ''){
  alert("Jumlah Barang Harus Diisi");
       $("#jumlah_barang").focus();


  }
  else if (jumlah_barang == 0){
  alert("Jumlah Barang Tidak boleh 0");
       $("#jumlah_barang").focus();

  }
 else if (harga == 0 || harga == ""){
       alert("Harga "+nama_barang+" = 0, Anda Tidak Dapat Melakukan Penjualan, Silakan Pilih Produk atau Level Harga Yang Lain !");
       $("#jumlah_barang").val('');
       $("#nama_barang").val('');
       $("#kode_barang").val('');
       $("#dosis_obat").val('');
       $("#col_dosis").hide();
       $("#kode_barang").trigger('chosen:updated');

  }

  else if (ber_stok == 'Jasa' || ber_stok == 'BHP' ){


    $("#potongan_penjualan").val(Math.round(potongaaan));
    $("#potongan_persen").val(Math.round(pot_pers));
    $("#total1").val(tandaPemisahTitik(Math.round(total_akhir)));
    $("#total2").val(tandaPemisahTitik(total_akhir1));
    $("#biaya_adm").val(tandaPemisahTitik(biaya_adm));
    $("#biaya_admin_persen").val(data_admin);
   



 $.post("proses_tbs_penjualan_raja.php",{id_user:id_user,penjamin:penjamin,asal_poli:asal_poli,level_harga:level_harga,petugas_paramedik:petugas_paramedik,petugas_farmasi:petugas_farmasi,petugas_lain:petugas_lain,no_reg:no_reg,no_rm:no_rm,dokter:dokter,petugas_kasir:petugas_kasir,kode_barang:kode_barang,nama_barang:nama_barang,jumlah_barang:jumlah_barang,harga:harga,potongan:potongan,tax:tax,satuan:satuan, ber_stok:ber_stok,ppn:ppn},function(data){
     
  
       //digunakan untuk mengecek sama tidaknya jumlah disc dg total_subtotal di tbs
  $.getJSON("cek_jumlah_disc_dg_total_sub_tbs.php",{no_reg:no_reg},function(oke){
       
          $("#subt_tbs").val(oke.totale);
        $("#disc_tbs").val(oke.potongane);

      });

     $("#ppn").attr("disabled", true);
      var tabel_tbs_penjualan = $('#tabel_tbs_penjualan').DataTable();
      tabel_tbs_penjualan.draw();
           
        
     $("#span_tbs").show()
     $("#kode_barang").val('').trigger("chosen:updated");
     $("#kode_barang").trigger('chosen:open');
     $("#nama_barang").val('');
     $("#jumlah_barang").val('');
     $("#potongan1").val('');
     $("#tax1").val('');
     $("#sisa_pembayaran_penjualan").val('');
     $("#kredit").val('');
     $("#kolom_cek_harga").val('0');
     $("#harga_baru").val('');
     $("#harga_produk").val('');
     $("#harga_lama").val('');
     $("#potongan1").val('');
     $("#tax1").val('');
     $("#dosis_obat").val('');
     $("#col_dosis").hide();

     });


  
  } 


else if (stok < 0 && ber_stok == 'Barang' ) {

    alert ("Jumlah Melebihi Stok Barang !");
    $("#jumlah_barang").val('');
    $("#jumlah_barang").focus();

  }

  else{

 
    $("#potongan_penjualan").val(Math.round(potongaaan,10));
    $("#potongan_persen").val(Math.round(pot_pers));
    $("#total1").val(tandaPemisahTitik(Math.round(total_akhir)));
    $("#total2").val(tandaPemisahTitik(total_akhir1));
    $("#biaya_adm").val(tandaPemisahTitik(biaya_adm));
    $("#biaya_admin_persen").val(data_admin);
   
if (limit_stok > stok)
        {
          alert("Persediaan Barang Ini Sudah Mencapai Batas Limit Stok, Segera Lakukan Pembelian !");
        }

   $.post("proses_tbs_penjualan_raja.php",{id_user:id_user,penjamin:penjamin,asal_poli:asal_poli,level_harga:level_harga,petugas_paramedik:petugas_paramedik,petugas_farmasi:petugas_farmasi,petugas_lain:petugas_lain,no_reg:no_reg,no_rm:no_rm,dokter:dokter,petugas_kasir:petugas_kasir,kode_barang:kode_barang,nama_barang:nama_barang,jumlah_barang:jumlah_barang,harga:harga,potongan:potongan,tax:tax,satuan:satuan,ber_stok:ber_stok,ppn:ppn, dosis_obat:dosis_obat},function(data){
     
 
       //digunakan untuk mengecek sama tidaknya jumlah disc dg total_subtotal di tbs
  $.getJSON("cek_jumlah_disc_dg_total_sub_tbs.php",{no_reg:no_reg},function(oke){
        $("#subt_tbs").val(oke.totale);
        $("#disc_tbs").val(oke.potongane);
      });


      $("#ppn").attr("disabled", true);

         var tabel_tbs_penjualan = $('#tabel_tbs_penjualan').DataTable();
            tabel_tbs_penjualan.draw();
        
        $("#span_tbs").show()
     $("#kode_barang").val('').trigger("chosen:updated").trigger("chosen:open");
     $("#nama_barang").val('');
     $("#jumlah_barang").val('');
     $("#potongan1").val('');
     $("#tax1").val('');
     $("#sisa_pembayaran_penjualan").val('');
     $("#kredit").val('');

    $("#sisa_pembayaran_penjualan").val('');
    $("#kolom_cek_harga").val('0');

       $("#dosis_obat").val('');
       $("#col_dosis").hide();

     
     });
}
    

      
 }

 else {

alert("Kode barang harus terisi");
    $("#kode_barang").trigger('chosen:open');


 }     


       
        
        $("#span_tbs").show()

  });/// braket penutup submit_produk
});

    $("#formtambahproduk").submit(function(){
    return false;
    
    });




//menampilkan no urut faktur setelah tombol click di pilih
      $("#cari_produk_penjualan").click(function() {      
 
      //menyembunyikan notif berhasil
      $("#alert_berhasil").hide();     
      $("#cetak_tunai").hide('');
      $("#cetak_tunai_besar").hide('');
      $("#cetak_piutang").hide('');
      
      /* Act on the event */
      });




   </script>



<!--cetak langsung disini-->
<script>
   //perintah javascript yang diambil dari form proses_bayar_beli.php dengan id=form_beli
  $("#cetak_langsung").click(function(){
        var id_user = $("#id_user").val();
        var sisa_pembayaran = bersihPemisah(bersihPemisah(bersihPemisah(bersihPemisah( $("#sisa_pembayaran_penjualan").val() ))));
        var kredit = bersihPemisah(bersihPemisah(bersihPemisah(bersihPemisah( $("#kredit").val() )))); 
        var no_rm = $("#no_rm").val();
        var no_rm = no_rm.substr(0, no_rm.indexOf(' |'));
        var no_reg = $("#no_reg").val();
        var tanggal_jt = $("#tanggal_jt").val();
        var total = bersihPemisah(bersihPemisah(bersihPemisah(bersihPemisah( $("#total1").val() )))); 
        var total2 = bersihPemisah(bersihPemisah(bersihPemisah(bersihPemisah( $("#total2").val() )))); 
        var potongan_jual =  bersihPemisah(bersihPemisah(bersihPemisah(bersihPemisah( $("#potongan_penjualan").val() ))));
        var potongan = Math.round(potongan_jual);
        var potongan_persen = $("#potongan_persen").val();
  /*
        var tax = $("#tax_rp").val();
        */
        var cara_bayar = $("#carabayar1").val();
        var pembayaran = bersihPemisah(bersihPemisah(bersihPemisah(bersihPemisah( $("#pembayaran_penjualan").val() ))));
        var biaya_adm = bersihPemisah(bersihPemisah(bersihPemisah(bersihPemisah( $("#biaya_adm").val() ))));
        if (biaya_adm == '') {
          biaya_adm = 0;
        }
        var total_hpp = $("#total_hpp").val();
        var harga = $("#harga_produk").val();
        var kode_gudang = $("#kode_gudang").val();
        var dokter = $("#dokter").val();
        var petugas_kasir = $("#petugas_kasir").val();   
        var petugas_paramedik = $("#petugas_paramedik").val();
        var petugas_farmasi = $("#petugas_farmasi").val();
        var petugas_lain = $("#petugas_lain").val();
        var keterangan = $("#keterangan").val();   
        var ber_stok = $("#ber_stok").val();   
        var ppn_input = $("#ppn_input").val();
        var ppn = $("#ppn").val();
        var penjamin = $("#penjamin").val();
        var nama_pasien = $("#nama_pasien").val();
        var analis = $("#analis").val();
        var petugas_radiologi = $("#petugas_radiologi").val();
        var jenis_penjualan = 'Rawat Jalan';
        var disc_tbs = $("#disc_tbs").val();
        if (disc_tbs == '') {
          disc_tbs = 0;
        }
        
        var sisa = pembayaran - total;
        
        var sisa_kredit = total - pembayaran;


 if (sisa_pembayaran < 0)
 {

  alert("Jumlah Pembayaran Tidak Mencukupi");

 }


else if ((total2 != "" || total2 != 0) && pembayaran == "" && potongan_persen != '100' && disc_tbs == 0)
 {

alert("Pembayaran Harus Di Isi");
$("#pembayaran_penjualan").focus()

 }

   else if (kode_gudang == "")
 {

alert(" Kode Gudang Harus Diisi ");
$("#kode_gudang").focus()


 }
 
 else if ( sisa < 0) 
 {

alert("Silakan Isi Kolom Pembayaran  atau lakukan Bayar Piutang");

 }
    else if ((total2 ==  0 || total2 ==  "") && (total ==  0 || total == "")  && potongan_persen != 100 && (pembayaran == 0 || pembayaran == "") && (disc_tbs == 0))  
        {
        
        alert("Anda Belum Melakukan Pemesanan");
        
        }

 else

 {

  $("#penjualan").hide();
  $("#cetak_langsung").hide();
  $("#simpan_sementara").hide();
  $("#batal_penjualan").hide(); 
  $("#piutang").hide();
  $("#transaksi_baru").show();

 $.post("cek_subtotal_penjualan.php",{total:total,no_reg:no_reg,potongan:potongan  /*,tax:tax*/,biaya_adm:biaya_adm},function(data) {

if (data == 1) {


 $.getJSON("cek_status_stok_penjualan.php?no_reg="+no_reg, function(result){

        if (result.status == 0) {


     $("#cetak_tunai").attr('href', 'cetak_penjualan_tunai_rj.php?no_reg='+no_reg+'&sisa='+sisa_pembayaran+'&tunai='+pembayaran+'&total='+total+'&biaya_admin='+biaya_adm+'&potongan='+potongan+'&no_rm='+no_rm+'&nama_pasien='+nama_pasien+'');

     $("#cetak_tunai_besar").attr('href', 'cetak_penjualan_tunai_besar_rj.php?no_reg='+no_reg+'&sisa='+sisa_pembayaran+'&kredit='+sisa_kredit+'&tunai='+pembayaran+'&total='+total+'&biaya_admin='+biaya_adm+'&potongan='+potongan+'&no_rm='+no_rm+'&nama_pasien='+nama_pasien+'&keterangan='+keterangan+'&cara_bayar='+cara_bayar+'');

     $("#cetak_tunai_kategori").attr('href','cetak_penjualan_tunai_kategori_rj.php?no_reg='+no_reg+'&sisa='+sisa_pembayaran+'&tunai='+pembayaran+'&total='+total+'&biaya_admin='+biaya_adm+'&potongan='+potongan+'&no_rm='+no_rm+'&nama_pasien='+nama_pasien+'');

     var win = window.open('cetak_penjualan_tunai_rj.php?no_reg='+no_reg+'&sisa='+sisa_pembayaran+'&tunai='+pembayaran+'&total='+total+'&biaya_admin='+biaya_adm+'&potongan='+potongan+'&no_rm='+no_rm+'&nama_pasien='+nama_pasien+'');
      if (win) {    
          win.focus(); 
        } 
      else {    
          alert('Mohon Izinkan PopUps Pada Website Ini !'); 
        }

        
     $("#cetak_tunai").show();
     $("#cetak_tunai_kategori").show();
     $("#cetak_tunai_besar").show('');

 $.post("proses_bayar_jual_kasir.php",{id_user:id_user,sisa_pembayaran:sisa_pembayaran, kredit:kredit,no_rm:no_rm,no_reg:no_reg,tanggal_jt:tanggal_jt,total:total,total2:total2,potongan:potongan,potongan_persen:potongan_persen,/*tax:tax,*/cara_bayar:cara_bayar,pembayaran:pembayaran,total_hpp:total_hpp,harga:harga,kode_gudang:kode_gudang,dokter:dokter,petugas_kasir:petugas_kasir,petugas_paramedik:petugas_paramedik,petugas_farmasi:petugas_farmasi,petugas_lain:petugas_lain,keterangan:keterangan,ber_stok:ber_stok,ppn_input:ppn_input,sisa:sisa,ppn:ppn,penjamin:penjamin,nama_pasien:nama_pasien,jenis_penjualan:jenis_penjualan,biaya_adm:biaya_adm,analis:analis,petugas_radiologi:petugas_radiologi},function(info) {

        if (info == 1)
        {
            alert("Maaf Subtotal Penjualan Tidak Sesuai, Silakan Tunggu Sebentar!");       
                window.location.href="form_penjualan_kasir.php";
        } 
        else
        {
        	info = info.replace(/\s/g, '');
             $("#table-baru").html(info);
             var no_faktur = info;
             $("#alert_berhasil").show();
             $("#pembayaran_penjualan").val('');
             $("#sisa_pembayaran_penjualan").val('');
             $("#kredit").val('');
             $("#disc_tbs").val('');
             $("#span_tbs").hide('');
             $('#span_lab').hide();
             $("#dosis_obat").val('');
             $("#col_dosis").hide();

          
        }

      }); //end post proses_bayar_jual_kasir

  }
  else {


  $("#penjualan").show();
  $("#simpan_sementara").show();
  $("#cetak_langsung").show();
  $("#batal_penjualan").show(); 
  $("#piutang").show();
  $("#transaksi_baru").hide();

     alert("Tidak Bisa Di Jual, ada stok yang habis");
     
$("#tbody-barang-jual").find("tr").remove();

   $.each(result.barang, function(i, item) {

 
    var tr_barang = "<tr><td>"+ result.barang[i].kode_barang+"</td><td>"+ result.barang[i].nama_barang+"</td><td>"+ result.barang[i].jumlah_jual+"</td><td>"+ result.barang[i].stok+"</td></tr>"
     $("#tbody-barang-jual").prepend(tr_barang);

   });

   $("#modal_barang_tidak_bisa_dijual").modal('show');

  }


});

  }

  else{
    alert("Maaf Subtotal Penjualan Tidak Sesuai, Silakan Tunggu Sebentar!");       
        window.location.href="form_penjualan_kasir.php";
  }

 }); // end post cek_subtotal_penjualan


 $('#tabel_tbs_penjualan').DataTable().clear();
$('#tabel_tbs_lab').DataTable().clear();


 }

 $("form").submit(function(){
    return false;
 
});

});

               $("#penjualan").mouseleave(function(){

               var kode_pelanggan = $("#kd_pelanggan").val();
               if (kode_pelanggan == ""){
               $("#kd_pelanggan").attr("disabled", false);
               }
               
               });
      
  </script>

   <!--cetak langsung dsini-->



<!--
    <script>
       //perintah javascript yang diambil dari form proses_bayar_beli.php dengan id=form_beli
       $("#simpan_sementara").click(function(){
        var id_user = $("#id_user").val();
        var sisa_pembayaran = bersihPemisah(bersihPemisah(bersihPemisah(bersihPemisah( $("#sisa_pembayaran_penjualan").val() ))));
        var kredit = bersihPemisah(bersihPemisah(bersihPemisah(bersihPemisah( $("#kredit").val() )))); 
        var no_rm = $("#no_rm").val();
        var no_rm = no_rm.substr(0, no_rm.indexOf(' |'));
        var no_reg = $("#no_reg").val();
        var total = bersihPemisah(bersihPemisah(bersihPemisah(bersihPemisah( $("#total1").val() )))); 
        var total2 = bersihPemisah(bersihPemisah(bersihPemisah(bersihPemisah( $("#total2").val() )))); 
        var potongan_jual =  bersihPemisah(bersihPemisah(bersihPemisah(bersihPemisah( $("#potongan_penjualan").val() ))));
        var potongan = Math.round(potongan_jual);
        var potongan_persen = $("#potongan_persen").val();
          /*var tax = $("#tax_rp").val();
*/
        var cara_bayar = $("#carabayar1").val();
        var pembayaran = bersihPemisah(bersihPemisah(bersihPemisah(bersihPemisah( $("#pembayaran_penjualan").val() ))));
        if (pembayaran == '') {
          pembayaran = 0;
        }
        var total_hpp = $("#total_hpp").val();
        var kode_gudang = $("#kode_gudang").val();
        var sales = $("#sales").val();
        var keterangan = $("#keterangan").val();   
        var ber_stok = $("#ber_stok").val();
        var ppn_input = $("#ppn_input").val();       
       var sisa =  pembayaran - total; 
        var biaya_adm = bersihPemisah(bersihPemisah(bersihPemisah(bersihPemisah( $("#biaya_adm").val() ))));
        if (biaya_adm == '') {
          biaya_adm = 0;
        }
        var dokter = $("#dokter").val();
        var petugas_kasir = $("#petugas_kasir").val();   
        var petugas_paramedik = $("#petugas_paramedik").val();
        var petugas_farmasi = $("#petugas_farmasi").val();
        var petugas_lain = $("#petugas_lain").val
        var ber_stok = $("#ber_stok").val();   
        var penjamin = $("#penjamin").val();
        var nama_pasien = $("#nama_pasien").val();
        var analis = $("#analis").val();
        var jenis_penjualan = 'Rawat Jalan';

       var sisa_kredit = total - pembayaran;


       
          if (no_rm == "") 
       {
       
       alert("No Rm Harus Di Isi");
       
       }

         else if ( total == "") 
         {
         
         alert("Anda Belum Melakukan Pesanan");
         
         }
                 
         
       else
       {


        $("#piutang").hide();
        $("#simpan_sementara").hide();
        $("#batal_penjualan").hide();
        $("#penjualan").hide();
        $("#transaksi_baru").show();

 $.post("cek_subtotal_penjualan.php",{total:total,no_reg:no_reg,potongan:potongan,/*tax:tax,*/biaya_adm:biaya_adm},function(data) {

  if (data == 1) {

    $.post("proses_simpan_barang_raja.php",{id_user:id_user,total2:total2,sisa_pembayaran:sisa_pembayaran,kredit:kredit,no_rm:no_rm,total:total,potongan:potongan,potongan_persen:potongan_persen,/*tax:tax,*/cara_bayar:cara_bayar,pembayaran:pembayaran,sisa:sisa,sisa_kredit:sisa_kredit,total_hpp:total_hpp,sales:sales,kode_gudang:kode_gudang,keterangan:keterangan,ber_stok:ber_stok,ppn_input:ppn_input,biaya_adm:biaya_adm,dokter:dokter,petugas_kasir:petugas_kasir,petugas_paramedik:petugas_paramedik,petugas_farmasi:petugas_farmasi,petugas_lain:petugas_lain,penjamin:penjamin,nama_pasien:nama_pasien,jenis_penjualan:jenis_penjualan,no_reg:no_reg,analis:analis},function(info) {

        
            $("#table-baru").html(info);
            $("#alert_berhasil").show();
            $("#pembayaran_penjualan").val('');
            $("#sisa_pembayaran_penjualan").val('');
            $("#kredit").val('');
            $("#potongan_penjualan").val('');
            $("#potongan_persen").val('');
            $("#tanggal_jt").val('');
            
            $("#total1").val('');
            $("#pembayaran_penjualan").val('');
            $("#sisa_pembayaran_penjualan").val('');
            $("#kredit").val('');
            $("#span_tbs").hide('');
            $('#span_lab').hide();
            $("#dosis_obat").val('');
            $("#col_dosis").hide();
            /*
            $("#tax").val('');*/
    });


    $('#tabel_tbs_penjualan').DataTable().clear();
    $('#tabel_tbs_lab').DataTable().clear();


  }
  else{
    alert("Maaf Subtotal Penjualan Tidak Sesuai, Silakan Tunggu Sebentar!");       
        window.location.href="form_penjualan_kasir.php";
  }

 });
       
       }  




       //mengambil no_faktur pembelian agar berurutan
});
       $("form").submit(function(){
       return false;
       });

              $("#simpan_sementara").mouseleave(function(){
               

               var kode_pelanggan = $("#kd_pelanggan").val();
               if (kode_pelanggan == ""){
               $("#kd_pelanggan").attr("disabled", false);
               }
               
               });
  </script>  

-->


<script type="text/javascript">

  $(document).ready(function(){
    $(document).on('click','#simpan_sementara',function(e){

       $('#tabel_cari_pasien').DataTable().destroy();
        var dataTable = $('#tabel_cari_pasien').DataTable( {
          "processing": true,
          "serverSide": true,
          "ajax":{
            url :"modal_pasien_penjualan.php", // json datasource
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
              $(nRow).attr('no_rm', aData[1]+" | "+aData[2]+"");
              $(nRow).attr('nama_pasien', aData[2]);
              $(nRow).attr('penjamin', aData[5]);
              $(nRow).attr('poli', aData[6]);
              $(nRow).attr('dokter', aData[7]);
              $(nRow).attr('level_harga', aData[8]);


          }

            });  
            $("#piutang").hide();
            $("#simpan_sementara").hide();
            $("#batal_penjualan").hide();
            $("#penjualan").hide();
            $("#transaksi_baru").show();
            $("#pembayaran_penjualan").val('');
            $("#sisa_pembayaran_penjualan").val('');
            $("#kredit").val('');
            $("#potongan_penjualan").val('');
            $("#potongan_persen").val('');
            $("#tanggal_jt").val('');
            $("#total2").val('');
            $("#total1").val('');
            $("#biaya_admin_select").val('');
            $("#biaya_adm").val('');
            $("#no_rm").val('');
            $("#no_reg").val('');
            $("#asal_poli").val('');
            $("#penjamin").val('');
            $("#level_harga").val('');
            $("#keterangan").val('');
            $("#cetak_langsung").hide();
            $("#transaksi_baru").show();
            $("#cetak_tunai").hide();
            $("#cetak_tunai_besar").hide();
            $("#cetak_piutang").hide();
            $("#cetak_tunai_kategori").hide(); 
            $("#btnRujukLab").hide();   
            $("#btnRujukRadiologi").hide();    
            $('#span_tbs').hide();
            $('#span_lab').hide();

            var url = window.location.href;
             url = getPathFromUrl(url);
            history.pushState('', 'Sim Klinik',  url);

            function getPathFromUrl(url) {
              return url.split("?")[0];
            }


            $("#alert_simpan_berhasil").show();


    });
  });

</script>


<script type="text/javascript">
   //perintah javascript yang diambil dari form proses_bayar_beli.php dengan id=form_beli
  $("#penjualan").click(function(){
        var id_user = $("#id_user").val();
        var sisa_pembayaran = bersihPemisah(bersihPemisah(bersihPemisah(bersihPemisah( $("#sisa_pembayaran_penjualan").val() ))));
        var kredit = bersihPemisah(bersihPemisah(bersihPemisah(bersihPemisah( $("#kredit").val() )))); 
        var no_rm = $("#no_rm").val();
        var no_rm = no_rm.substr(0, no_rm.indexOf(' |'));
        var no_reg = $("#no_reg").val();
        var tanggal_jt = $("#tanggal_jt").val();
        var total = bersihPemisah(bersihPemisah(bersihPemisah(bersihPemisah( $("#total1").val() )))); 
        var total2 = bersihPemisah(bersihPemisah(bersihPemisah(bersihPemisah( $("#total2").val() )))); 
        var potongan_jual =  bersihPemisah(bersihPemisah(bersihPemisah(bersihPemisah( $("#potongan_penjualan").val() ))));
        var potongan = Math.round(potongan_jual);
        var potongan_persen = $("#potongan_persen").val();
  /*
        var tax = $("#tax_rp").val();
        */
        var cara_bayar = $("#carabayar1").val();
        var pembayaran = bersihPemisah(bersihPemisah(bersihPemisah(bersihPemisah( $("#pembayaran_penjualan").val() ))));
        var biaya_adm = bersihPemisah(bersihPemisah(bersihPemisah(bersihPemisah( $("#biaya_adm").val() ))));
        if (biaya_adm == '') {
          biaya_adm = 0;
        }
        var total_hpp = $("#total_hpp").val();
        var harga = $("#harga_produk").val();
        var kode_gudang = $("#kode_gudang").val();
        var dokter = $("#dokter").val();
        var petugas_kasir = $("#petugas_kasir").val();   
        var petugas_paramedik = $("#petugas_paramedik").val();
        var petugas_farmasi = $("#petugas_farmasi").val();
        var petugas_lain = $("#petugas_lain").val();
        var keterangan = $("#keterangan").val();   
        var ber_stok = $("#ber_stok").val();   
        var ppn_input = $("#ppn_input").val();
        var ppn = $("#ppn").val();
        var penjamin = $("#penjamin").val();
        var nama_pasien = $("#nama_pasien").val();
        var analis = $("#analis").val();
        var petugas_radiologi = $("#petugas_radiologi").val();
        var jenis_penjualan = 'Rawat Jalan';
        var disc_tbs = $("#disc_tbs").val();
        if (disc_tbs == '') {
          disc_tbs = 0;
        }
        
        var sisa = pembayaran - total;
        
        var sisa_kredit = total - pembayaran;


 if (sisa_pembayaran < 0)
 {

  alert("Jumlah Pembayaran Tidak Mencukupi");

 }


else if ((total2 != "" || total2 != 0) && pembayaran == "" && potongan_persen != '100' && disc_tbs == 0)
 {

alert("Pembayaran Harus Di Isi");
$("#pembayaran_penjualan").focus()

 }

   else if (kode_gudang == "")
 {

alert(" Kode Gudang Harus Diisi ");
$("#kode_gudang").focus()


 }
 
 else if ( sisa < 0) 
 {

alert("Silakan Bayar Piutang");

 }
  else if ((total2 ==  0 || total2 ==  "") && (total ==  0 || total2 ==  "") && potongan_persen != 100 && (pembayaran == 0 || pembayaran == "") && disc_tbs == 0)
        {
        
        alert("Anda Belum Melakukan Pemesanan");
        
        }

 else

 {

  $("#penjualan").hide();
  $("#simpan_sementara").hide();
  $("#cetak_langsung").hide();
  $("#batal_penjualan").hide(); 
  $("#piutang").hide();
  $("#transaksi_baru").show();



 $.post("cek_subtotal_penjualan.php",{total:total,no_reg:no_reg,potongan:potongan  /*,tax:tax*/,biaya_adm:biaya_adm},function(data) {

  if (data == 1) { 

    $.getJSON("cek_status_stok_penjualan.php?no_reg="+no_reg, function(result){

        if (result.status == 0) {

     $("#cetak_tunai").attr('href', 'cetak_penjualan_tunai_rj.php?no_reg='+no_reg+'&sisa='+sisa_pembayaran+'&tunai='+pembayaran+'&total='+total+'&biaya_admin='+biaya_adm+'&potongan='+potongan+'&no_rm='+no_rm+'&nama_pasien='+nama_pasien+'');

     $("#cetak_tunai_besar").attr('href', 'cetak_penjualan_tunai_besar_rj.php?no_reg='+no_reg+'&sisa='+sisa_pembayaran+'&kredit='+sisa_kredit+'&tunai='+pembayaran+'&total='+total+'&biaya_admin='+biaya_adm+'&potongan='+potongan+'&no_rm='+no_rm+'&nama_pasien='+nama_pasien+'&keterangan='+keterangan+'&cara_bayar='+cara_bayar+'');

     $("#cetak_tunai_kategori").attr('href','cetak_penjualan_tunai_kategori_rj.php?no_reg='+no_reg+'&sisa='+sisa_pembayaran+'&tunai='+pembayaran+'&total='+total+'&biaya_admin='+biaya_adm+'&potongan='+potongan+'&no_rm='+no_rm+'&nama_pasien='+nama_pasien+'');


     $("#cetak_tunai").show();
     $("#cetak_tunai_kategori").show();
     $("#cetak_tunai_besar").show();

      $.post("proses_bayar_jual_kasir.php",{id_user:id_user,sisa_pembayaran:sisa_pembayaran, kredit:kredit,no_rm:no_rm,no_reg:no_reg,tanggal_jt:tanggal_jt,total:total,total2:total2,potongan:potongan,potongan_persen:potongan_persen,/*tax:tax,*/cara_bayar:cara_bayar,pembayaran:pembayaran,total_hpp:total_hpp,harga:harga,kode_gudang:kode_gudang,dokter:dokter,petugas_kasir:petugas_kasir,petugas_paramedik:petugas_paramedik,petugas_farmasi:petugas_farmasi,petugas_lain:petugas_lain,keterangan:keterangan,ber_stok:ber_stok,ppn_input:ppn_input,sisa:sisa,ppn:ppn,penjamin:penjamin,nama_pasien:nama_pasien,jenis_penjualan:jenis_penjualan,biaya_adm:biaya_adm,analis:analis},function(info) {

        if (info == 1) {
           alert("Maaf Subtotal Penjualan Tidak Sesuai, Silakan Tunggu Sebentar! (2) ");       
                window.location.href="form_penjualan_kasir.php";
        }
        else {
             $("#table-baru").html(info);
             var no_faktur = info;
             $("#alert_berhasil").show();
             $("#pembayaran_penjualan").val('');
             $("#sisa_pembayaran_penjualan").val('');
             $("#kredit").val('');
             $("#disc_tbs").val('');
             $("#span_tbs").hide('');
             $('#span_lab').hide();
             $("#dosis_obat").val('');
             $("#col_dosis").hide();
        } //end if cek subtotal penjualan kedua 


     }); //end post pembayaran penjualan
  }//end if status stok penjualan == 0

  else {


  $("#penjualan").show();
  $("#simpan_sementara").show();
  $("#cetak_langsung").show();
  $("#batal_penjualan").show(); 
  $("#piutang").show();
  $("#transaksi_baru").hide();

     alert("Tidak Bisa Di Jual, ada stok yang habis");

$("#tbody-barang-jual").find("tr").remove();
   $.each(result.barang, function(i, item) {

 
    var tr_barang = "<tr><td>"+ result.barang[i].kode_barang+"</td><td>"+ result.barang[i].nama_barang+"</td><td>"+ result.barang[i].jumlah_jual+"</td><td>"+ result.barang[i].stok+"</td></tr>"
     $("#tbody-barang-jual").prepend(tr_barang);

   });

   $("#modal_barang_tidak_bisa_dijual").modal('show');


  


  
   
  }

});// end get json cek status stok penjualan 

  } //end if cek subtotal penjualan pertama 

  else{
    alert("Maaf Subtotal Penjualan Tidak Sesuai, Silakan Tunggu Sebentar! (1) ");     
        window.location.href="form_penjualan_kasir.php";
  }//end else cek subtotal penjualan pertama 

 }); // end post cek subtotal penjualan


 }



    $('#tabel_tbs_penjualan').DataTable().clear();
    $('#tabel_tbs_lab').DataTable().clear();
    
    $("form").submit(function(){
      return false;
    
    });

});

               $("#penjualan").mouseleave(function(){

               var kode_pelanggan = $("#kd_pelanggan").val();
               if (kode_pelanggan == ""){
               $("#kd_pelanggan").attr("disabled", false);
               }
               
               });
      
  </script>
  
    <script>
   //perintah javascript yang diambil dari form proses_bayar_beli.php dengan id=form_beli
  $("#piutang").click(function(){
        var id_user = $("#id_user").val();
        var sisa_pembayaran = bersihPemisah(bersihPemisah(bersihPemisah(bersihPemisah( $("#sisa_pembayaran_penjualan").val() ))));
        var kredit = bersihPemisah(bersihPemisah(bersihPemisah(bersihPemisah( $("#kredit").val() )))); 
        var no_rm = $("#no_rm").val();
        var no_rm = no_rm.substr(0, no_rm.indexOf(' |'));
        var no_reg = $("#no_reg").val();
        var tanggal_jt = $("#tanggal_jt").val();
        var total = bersihPemisah(bersihPemisah(bersihPemisah(bersihPemisah( $("#total1").val() )))); 
        var total2 = bersihPemisah(bersihPemisah(bersihPemisah(bersihPemisah( $("#total2").val() )))); 
        var potongan_jual =  bersihPemisah(bersihPemisah(bersihPemisah(bersihPemisah( $("#potongan_penjualan").val() ))));
        var potongan = Math.round(potongan_jual);
        var potongan_persen = $("#potongan_persen").val();
        /*
        var tax = $("#tax_rp").val();*/
        var cara_bayar = $("#carabayar1").val();
        var pembayaran = bersihPemisah(bersihPemisah(bersihPemisah(bersihPemisah( $("#pembayaran_penjualan").val() ))));
        var total_hpp = $("#total_hpp").val();
        var harga = $("#harga_produk").val();
        var kode_gudang = $("#kode_gudang").val();
        var dokter = $("#dokter").val();
        var petugas_kasir = $("#petugas_kasir").val();   
        var petugas_paramedik = $("#petugas_paramedik").val();
        var petugas_farmasi = $("#petugas_farmasi").val();
        var petugas_lain = $("#petugas_lain").val();
        var keterangan = $("#keterangan").val();   
        var ber_stok = $("#ber_stok").val();   
        var ppn_input = $("#ppn_input").val();
        var biaya_adm = bersihPemisah(bersihPemisah(bersihPemisah(bersihPemisah( $("#biaya_adm").val() ))));
        if (biaya_adm == '') {
          biaya_adm = 0;
        }
        var ppn = $("#ppn").val();
        var penjamin = $("#penjamin").val();
        var nama_pasien = $("#nama_pasien").val();
        var analis = $("#analis").val();
        var petugas_radiologi = $("#petugas_radiologi").val();
        var jenis_penjualan = 'Rawat Jalan';
        
        var sisa = pembayaran - total;
        
        var sisa_kredit = total - pembayaran;


     $("#pembayaran_penjualan").val('');
     $("#sisa_pembayaran_penjualan").val('');
     $("#kredit").val('');



       
       if (tanggal_jt == "" && (total2 != "" || total2 != 0) && potongan_persen != '100')
       {

        alert ("Tanggal Jatuh Tempo Harus Di Isi");
        $("#tanggal_jt").focus();
         
       }
       else if (potongan_persen == '100' && (total2 != "" || total2 != 0) && (total == "" || total == 0)) {
        alert("Silakan klik tombol *Bayar* atau klik tombol *Bayar/Cetak*");
       }
         else if (total == "" && (total2 == "" || total2 == 0)) 
         {
         
         alert("Anda Belum Melakukan Pesanan");
         
         }
      else if (tanggal_jt != "" && (total2 != "" || total2 != 0) && potongan_persen != '100' && pembayaran >= total)
       {

        alert ("Silakan klik tombol *Bayar* atau klik tombol *Bayar/Cetak*.");
         
       }

 else

 {

  $("#penjualan").hide();
  $("#cetak_langsung").hide();
  $("#simpan_sementara").hide();
  $("#batal_penjualan").hide(); 
  $("#piutang").hide();
  $("#transaksi_baru").show();
  
 $.post("cek_subtotal_penjualan.php",{total:total,no_reg:no_reg,potongan:potongan,/*tax:tax,*/biaya_adm:biaya_adm},function(data) {



  if (data == 1) {


    $.getJSON("cek_status_stok_penjualan.php?no_reg="+no_reg , function(result){

        if (result.status == 0) {

     $.post("proses_bayar_jual_kasir.php",{id_user:id_user,sisa_pembayaran:sisa_pembayaran, kredit:kredit,no_rm:no_rm,no_reg:no_reg,tanggal_jt:tanggal_jt,total:total,total2:total2,potongan:potongan,potongan_persen:potongan_persen,/*tax:tax,*/cara_bayar:cara_bayar,pembayaran:pembayaran,total_hpp:total_hpp,harga:harga,kode_gudang:kode_gudang,dokter:dokter,petugas_kasir:petugas_kasir,petugas_paramedik:petugas_paramedik,petugas_farmasi:petugas_farmasi,petugas_lain:petugas_lain,keterangan:keterangan,ber_stok:ber_stok,ppn_input:ppn_input,sisa:sisa,ppn:ppn,penjamin:penjamin,nama_pasien:nama_pasien,jenis_penjualan:jenis_penjualan,biaya_adm:biaya_adm,analis:analis},function(info) {

    if (info == 1)
    {
       alert("Maaf Subtotal Penjualan Tidak Sesuai, Silakan Tunggu Sebentar! (2) ");       
            window.location.href="form_penjualan_kasir.php";
    }
    else
    {


                $("#table-baru").html(info);
                var no_faktur = info;
                $("#cetak_piutang").attr('href', 'cetak_penjualan_piutang.php?no_faktur='+no_faktur+'');
                  $("#cetak_piutang").show();
                $("#table-baru").html(info);
                $("#alert_berhasil").show();
                $("#pembayaran_penjualan").val('');
                $("#sisa_pembayaran_penjualan").val('');
                $("#kredit").val('');
                $("#potongan_penjualan").val('');
                $("#potongan_persen").val('');
                $("#tanggal_jt").val('');
                $("#disc_tbs").val('');
                $("#span_tbs").hide('');
                $('#span_lab').hide();
                /*
                $("#tax").val('');*/
     }         
       
      }); //end post pembayaran jual kasir
  } // end if result cek_status_stok_penjualan
  else{


  $("#penjualan").show();
  $("#simpan_sementara").show();
  $("#cetak_langsung").show();
  $("#batal_penjualan").show(); 
  $("#piutang").show();
  $("#transaksi_baru").hide();

     alert("Tidak Bisa Di Jual, ada stok yang habis");

$("#tbody-barang-jual").find("tr").remove();
   $.each(result.barang, function(i, item) {

 
    var tr_barang = "<tr><td>"+ result.barang[i].kode_barang+"</td><td>"+ result.barang[i].nama_barang+"</td><td>"+ result.barang[i].jumlah_jual+"</td><td>"+ result.barang[i].stok+"</td></tr>"
     $("#tbody-barang-jual").prepend(tr_barang);

   });

   $("#modal_barang_tidak_bisa_dijual").modal('show');

  }

}); // end get json cek_status_stok_penjualan

  }
  else {
    alert("Maaf Subtotal Penjualan Tidak Sesuai, Silakan Tunggu Sebentar! (1) ");       
        window.location.href="form_penjualan_kasir.php";
  } // end if cek subtotal

}); // end cek subtotal


 }


    $('#tabel_tbs_penjualan').DataTable().clear();
    $('#tabel_tbs_lab').DataTable().clear();



 $("form").submit(function(){
    return false;
 
});

});

               $("#piutang").mouseleave(function(){
               

               var kode_pelanggan = $("#kd_pelanggan").val();
               if (kode_pelanggan == ""){
               $("#kd_pelanggan").attr("disabled", false);
               }
               
               });
      
  </script>


<!--
<script type="text/javascript">
$(document).ready(function(){
$("#cari_produk_penjualan").click(function(){
  var no_reg = $("#no_reg").val();

  $.post("cek_tbs_penjualan.php",{no_reg:no_reg},function(data){
    $("#keterangan").val(data)
        if (data != "1") {


             $("#ppn").attr("disabled", false);

        }
    });

});
});
</script>-->


<script type="text/javascript">
  $(document).ready(function(){
    
  //START KEYUP BIAYA ADMIN RUPIAH

    $("#biaya_adm").keyup(function(){
      var biaya_adm = bersihPemisah(bersihPemisah(bersihPemisah(bersihPemisah($("#biaya_adm").val()))));
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
            $("#biaya_adm").val('');
            $("#biaya_adm").val('');
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
      $("#biaya_adm").val(Math.round(biaya_admin_rupiah));

      if (biaya_admin_persen > 100) {
            

            var total_akhir = parseInt(subtotal,10) - parseInt(potongan,10);
            alert ("Biaya Amin %, Tidak Boleh Lebih Dari 100%");
            $("#biaya_admin_persen").val('');
            $("#biaya_admin_select").val('0');            
            $("#biaya_admin_select").trigger('chosen:updated');
            $("#biaya_adm").val('');
            $("#total1").val(tandaPemisahTitik(total_akhir));
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
        
        $("#potongan_persen").keyup(function(){

        var potongan_persen = bersihPemisah(bersihPemisah(bersihPemisah(bersihPemisah($("#potongan_persen").val()))));
        var total = bersihPemisah(bersihPemisah(bersihPemisah(bersihPemisah( $("#total2").val() ))));
        var potongan_penjualan = ((total * potongan_persen) / 100);
/*
        var tax = $("#tax").val();
        var tax_rp = bersihPemisah(bersihPemisah(bersihPemisah(bersihPemisah($("#tax_rp").val()))));
        */
       var biaya_adm = bersihPemisah(bersihPemisah(bersihPemisah(bersihPemisah($("#biaya_adm").val()))));
        if (biaya_adm == '')
        {
          biaya_adm = 0;
        }
/*
        if (tax == "") {
        tax = 0;
      }*/
       var pembayaran = bersihPemisah(bersihPemisah(bersihPemisah(bersihPemisah($("#pembayaran_penjualan").val()))));
        if (pembayaran == '')
        {
          pembayaran = 0;
        }

      
        var sisa_potongan = parseInt(total,10) - parseInt(Math.round(potongan_penjualan,10));


            /* var t_tax = ((parseInt(sisa_potongan,10) * parseInt(tax,10)) / 100);*/
             var hasil_akhir = parseInt(sisa_potongan, 10) /*+ parseInt(Math.round(t_tax,10)) */+ parseInt(biaya_adm,10);
        // hitugan jika potongan lebih dari 100 % 
        /*
          var taxxx = ((parseInt(total,10) * parseInt(tax,10)) / 100); */

          var toto = parseInt(total, 10) + parseInt(biaya_adm,10) /*+ parseInt(Math.round(taxxx,10))*/;
        // end hitugan jika potongan lebih dari 100 % 

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
          $("#potongan_persen").val('')
          $("#potongan_penjualan").val('')
          $("#total1").val(tandaPemisahTitik(Math.round(toto)));
            /*
          $("#tax_rp").val(Math.round(taxxx));
*/
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

                  $("#total1").val(tandaPemisahTitik(Math.round(hasil_akhir)));
                  $("#potongan_penjualan").val(tandaPemisahTitik(Math.round(potongan_penjualan)));/*
                  $("#tax_rp").val(Math.round(t_tax));*/
        }

      });


     $("#potongan_penjualan").keyup(function(){

        var potongan_penjualan =  bersihPemisah(bersihPemisah(bersihPemisah(bersihPemisah( $("#potongan_penjualan").val() ))));
        var biaya_adm = bersihPemisah(bersihPemisah(bersihPemisah(bersihPemisah($("#biaya_adm").val()))));
        if (biaya_adm == '') {
          biaya_adm = 0;
        }
        var pembayaran = bersihPemisah(bersihPemisah(bersihPemisah(bersihPemisah($("#pembayaran_penjualan").val()))));
        if (pembayaran == '') {
          pembayaran = 0;
        }
        var total1 = bersihPemisah(bersihPemisah(bersihPemisah(bersihPemisah( $("#total1").val() ))));
        var total = bersihPemisah(bersihPemisah(bersihPemisah(bersihPemisah($("#total2").val()))));
        var potongan_persen = ((potongan_penjualan / total) * 100);
        /*
        var tax = $("#tax").val();
        var tax_rp = bersihPemisah(bersihPemisah(bersihPemisah(bersihPemisah($("#tax_rp").val()))));

        if (tax == "") {
        tax = 0;
      }*/


        var sisa_potongan = total - Math.round(potongan_penjualan);
        
            /* var t_tax = ((parseInt(sisa_potongan,10) * parseInt(tax,10)) / 100);*/
             var hasil_akhir = parseInt(sisa_potongan, 10) /*+ parseInt(Math.round(t_tax,10))*/ + parseInt(biaya_adm,10);

            // hitugan jika potongan lebih dari 100 % 
            /*
          var taxxx = ((parseInt(total,10) * parseInt(tax,10)) / 100);*/
          var toto = parseInt(total, 10) + parseInt(biaya_adm,10) /*+ parseInt(Math.round(taxxx,10))*/;

            // end hitugan jika potongan lebih dari 100 %  

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
            $("#total1").val(tandaPemisahTitik(toto));
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
        /*
        $("#tax_rp").val(Math.round(t_tax))*/
        }

        
      });

      $("#tax1").keyup(function(){
          var jumlahtax = $(this).val();
          if (jumlahtax > 100) {
            alert("Tax tidak boleh lebih dari 100%");
            $("#tax1").val('');
            $("#tax1").focus();
          }
      });
        
        /*

      $("#tax").keyup(function(){

        var potongan = bersihPemisah(bersihPemisah(bersihPemisah(bersihPemisah($("#potongan_penjualan").val() ))));
        var potongan_persen = ((total / potongan_persen) * 100);
        var total = bersihPemisah(bersihPemisah(bersihPemisah(bersihPemisah($("#total2").val() ))));
        var biaya_adm = bersihPemisah(bersihPemisah(bersihPemisah(bersihPemisah($("#biaya_adm").val()))));
        if (biaya_adm == '')
        {
          biaya_adm = 0;
        }
       var pembayaran = bersihPemisah(bersihPemisah(bersihPemisah(bersihPemisah($("#pembayaran_penjualan").val()))));
        if (pembayaran == '') {
          pembayaran = 0;
        }

              var cara_bayar = $("#carabayar1").val();
              var tax = $("#tax").val();
              var t_total = total - potongan;
              var t_balik = parseInt(t_total,10) + parseInt(biaya_adm,10);
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


              var total_akhir = parseInt(bersihPemisah(bersihPemisah(bersihPemisah(bersihPemisah(t_total,10))))) + parseInt(Math.round(t_tax,10)) + parseInt(biaya_adm,10);
            
              if (tax > 100) {

              var sisa = pembayaran - Math.round(t_balik);
              var sisa_kredit = Math.round(t_balik) - pembayaran; 
        
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

        */
        });
        
        </script>




<!-- cek stok  blur-->
<script type="text/javascript">
  $(document).ready(function(){
    $("#jumlah_barang").blur(function(){
      var jumlah_barang = bersihPemisah(bersihPemisah(bersihPemisah(bersihPemisah($("#jumlah_barang").val()))));
      var jumlahbarang = bersihPemisah(bersihPemisah(bersihPemisah(bersihPemisah($("#jumlahbarang").val()))));

      var kolom_cek_harga = $("#kolom_cek_harga").val();
      var satuan_konversi = $("#satuan_konversi").val();
      var kode_barang = $("#kode_barang").val();
 
      var id_produk = $("#id_produk").val();
      var prev = $("#satuan_produk").val();
      var limit_stok = $("#limit_stok").val();
      var ber_stok = $("#ber_stok").val();
      var stok = jumlahbarang - jumlah_barang;

	if (kolom_cek_harga == '0') {
	     alert ("Klik TOmbol OK!");
	}
  else{

      if (stok < 0 && ber_stok == 'Barang' ) {
        
        alert("Jumlah Melebihi Stok");
        $("#jumlah_barang").val('');
        $("#satuan_konversi").val(prev);
        
        
      }

  }



    });
  });
</script>
<!-- cek stok blur-->





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

  var session_id = $("#session_id").val();

            $.post("cek_total_hpp.php",
            {
            session_id: session_id
            },
            function(data){
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



<script type="text/javascript">
$(document).ready(function(){
      
//fungsi hapus data 
$(document).on('click','.btn-hapus-tbs',function(e){

      var no_reg = $("#no_reg").val();
      var nama_barang = $(this).attr("data-barang");
      var id = $(this).attr("data-id");
      var kode_barang = $(this).attr("data-kode-barang");
      var subtotal = $(this).attr("data-subtotal");
      var biaya_admin_persen = bersihPemisah(bersihPemisah(bersihPemisah(bersihPemisah($("#biaya_admin_persen").val()))));

    if (biaya_admin_persen == '') {
      biaya_admin_persen = 0;
    }
    /*
    var tax_faktur = bersihPemisah(bersihPemisah(bersihPemisah(bersihPemisah($("#tax").val()))));
        if (tax_faktur == '') {
      tax_faktur = 0;
    };*/

    var subtotal_tbs = bersihPemisah(bersihPemisah(bersihPemisah(bersihPemisah($("#total2").val()))));
    
    var pot_fakt_per = bersihPemisah(bersihPemisah(bersihPemisah(bersihPemisah($("#potongan_persen").val()))));

    var pot_fakt_rp = bersihPemisah(bersihPemisah(bersihPemisah(bersihPemisah($("#potongan_penjualan").val()))));

    

    var total_akhir1 = parseInt(subtotal_tbs,10) - parseInt(subtotal,10);
    var biaya_adm = parseInt(biaya_admin_persen,10) * parseInt(total_akhir1,10) / 100;

    

// START IF OTORITAS TIPE PRODUK START IF OTORITAS TIPE PRODUK START IF OTORITAS TIPE PRODUK START IF OTORITAS TIPE PRODUK START IF OTORITAS TIPE PRODUK
var tipe_produk = $('#opt-produk-'+kode_barang).attr("tipe_barang");      
$("#tipe_produk").val(tipe_produk);

var tipe_produk = $("#tipe_produk").val();
var otoritas_tipe_barang = $("#otoritas_tipe_barang").val();
var otoritas_tipe_jasa = $("#otoritas_tipe_jasa").val();
var otoritas_tipe_alat = $("#otoritas_tipe_alat").val();
var otoritas_tipe_bhp = $("#otoritas_tipe_bhp").val();
var otoritas_tipe_obat = $("#otoritas_tipe_obat").val();


 if(tipe_produk == 'Barang' && otoritas_tipe_barang < 1){
        alert("Anda Tidak Mempunyai Akses Menghapus "+nama_barang+" !");
 }//penutup if     

 else if(tipe_produk == 'Jasa' && otoritas_tipe_jasa < 1){
        alert("Anda Tidak Mempunyai Akses Menghapus "+nama_barang+" !");
 }//penutup if     

 else if(tipe_produk == 'Alat' && otoritas_tipe_alat < 1){
        alert("Anda Tidak Mempunyai Akses Menghapus "+nama_barang+" !");
 }//penutup if     

 else if(tipe_produk == 'BHP' && otoritas_tipe_bhp < 1){
        alert("Anda Tidak Mempunyai Akses Menghapus "+nama_barang+" !");
 }//penutup if     

 else if(tipe_produk == 'Obat Obatan' && otoritas_tipe_obat < 1){
        alert("Anda Tidak Mempunyai Akses Menghapus "+nama_barang+" !");
 }//penutup if 

 else{


     if (pot_fakt_per == 0) {
      var potongaaan = pot_fakt_rp;

      var potongaaan_per = parseInt(potongaaan,10) / parseInt(total_akhir1,10) * 100;
      var potongaaan = pot_fakt_rp;
      /*
      var hitung_tax = parseInt(total_akhir1,10) - parseInt(pot_fakt_rp,10);
      var tax_bener = parseInt(hitung_tax,10) * parseInt(tax_faktur,10) / 100; */

      var total_akhir = parseInt(total_akhir1,10) - parseInt(pot_fakt_rp,10) + parseInt(biaya_adm,10); /*  + parseInt(Math.round(tax_bener,10)); */


    }
    else if(pot_fakt_rp == 0)
    {
      var potongaaan = pot_fakt_per;
      var pos = potongaaan.search("%");
      var potongan_persen = bersihPemisah(bersihPemisah(bersihPemisah(bersihPemisah(potongaaan))));
          potongan_persen = potongan_persen.replace("%","");
      potongaaan = total_akhir1 * potongan_persen / 100;
      
      var potongaaan_per = pot_fakt_per;
      /*
      var hitung_tax = parseInt(total_akhir1,10) - parseInt(potongaaan,10);
      var tax_bener = parseInt(hitung_tax,10) * parseInt(tax_faktur,10) / 100;*/

     var total_akhir = parseInt(total_akhir1,10) - parseInt(potongaaan,10) + parseInt(biaya_adm,10); /*+ parseInt(Math.round(tax_bener,10));*/

    }
     else if(pot_fakt_rp != 0 && pot_fakt_rp != 0)
    {
      var potongaaan = pot_fakt_per;
      var pos = potongaaan.search("%");
      var potongan_persen = bersihPemisah(bersihPemisah(bersihPemisah(bersihPemisah(potongaaan))));
          potongan_persen = potongan_persen.replace("%","");
      potongaaan = total_akhir1 * potongan_persen / 100;
      
      var potongaaan_per = pot_fakt_per;
      /*

      var hitung_tax = parseInt(total_akhir1,10) - parseInt(potongaaan,10);
      var tax_bener = parseInt(hitung_tax,10) * parseInt(tax_faktur,10) / 100;
*/

      var total_akhir = parseInt(total_akhir1,10) - parseInt(potongaaan,10) + parseInt(biaya_adm,10); /* + parseInt(Math.round(tax_bener,10));*/

    
    }


var pesan_alert = confirm("Apakah Anda Yakin Ingin Menghapus "+nama_barang+""+ "?");
if (pesan_alert == true) {


        $("#total2").val(tandaPemisahTitik(total_akhir1));  
        $("#total1").val(tandaPemisahTitik(Math.round(total_akhir)));      
        $("#potongan_penjualan").val(Math.round(potongaaan));
        $("#biaya_adm").val(Math.round(biaya_adm));
        $("#pembayaran_penjualan").val('');
        $("#kredit").val('');
        $("#sisa_pembayaran_penjualan").val('');
        $.post("hapustbs_penjualan.php",{id:id,kode_barang:kode_barang,no_reg:no_reg},function(data){
          
         var tabel_tbs_penjualan = $('#tabel_tbs_penjualan').DataTable();
        
        tabel_tbs_penjualan.draw();
                      

            if (total_akhir1 == 0) {
              
            $("#potongan_persen").val('0');
                 $("#ppn").val('Non');
                 $("#ppn").attr('disabled',false);
             $("#tax1").attr("disabled", true);

            }
            else{

            $("#potongan_persen").val(Math.round(potongaaan_per));
            }
            /*
            $("#tax_rp").val(Math.round(tax_bener));*/
            $("#kode_barang").trigger('chosen:open');    


        });
}
else {    
    }


 } 

// END IF OTORITAS TIPE PRODUK END IF OTORITAS TIPE PRODUK END IF OTORITAS TIPE PRODUK END IF OTORITAS TIPE PRODUK END IF OTORITAS TIPE PRODUK


});
            $('form').submit(function(){
              
              return false;
          });


});
  
//end fungsi hapus data
</script>




<!-- AUTOCOMPLETE

<script>
$(function() {
    $( "#kode_barang" ).autocomplete({
        source: 'kode_barang_autocomplete.php'
    });
});
</script>

AUTOCOMPLETE -->

<!--

<script type="text/javascript">
  
        $(document).ready(function(){
        $("#kode_barang").blur(function(){

          var kode_barang = $(this).val();
          var level_harga = $("#level_harga").val();
          var session_id = $("#session_id").val();
          var no_reg = $("#no_reg").val();
     
        
          $.post('cek_kode_barang_tbs_penjualan.php',{kode_barang:kode_barang,no_reg:no_reg}, function(data){
          
          if(data == 1){
          alert("Anda Tidak Bisa Menambahkan Barang Yang Sudah Ada, Silakan Edit atau Pilih Barang Yang Lain !");

          $("#kode_barang").val('');
          $("#nama_barang").val('');
          $("#kode_barang").trigger('chosen:open');
          }//penutup if
          
else
{
      $.getJSON('lihat_nama_barang.php',{kode_barang:kode_barang}, function(json){
      
      if (json == null)
      {
        
        $('#nama_barang').val('');
        $('#limit_stok').val('');
        $('#harga_produk').val('');
        $('#harga_lama').val('');
        $('#harga_baru').val('');
        $('#satuan_produk').val('');
        $('#satuan_konversi').val('');
        $('#id_produk').val('');
        $('#ber_stok').val('');
        $('#jumlahbarang').val('');


      }

      else 
      {
        if (level_harga == "harga_1") {

        $('#harga_produk').val(json.harga_jual);
        $('#harga_baru').val(json.harga_jual);
        $('#harga_lama').val(json.harga_jual);
        $('#kolom_cek_harga').val('1');
        }
        else if (level_harga == "harga_2") {

        $('#harga_produk').val(json.harga_jual2);
        $('#harga_baru').val(json.harga_jual2);
        $('#harga_lama').val(json.harga_jual2);
        $('#kolom_cek_harga').val('1');
        }
        else if (level_harga == "harga_3") {

        $('#harga_produk').val(json.harga_jual3);
        $('#harga_baru').val(json.harga_jual3);
        $('#harga_lama').val(json.harga_jual3);
        $('#kolom_cek_harga').val('1');
        }
        else if (level_harga == "harga_4") {

        $('#harga_produk').val(json.harga_jual4);
        $('#harga_baru').val(json.harga_jual4);
        $('#harga_lama').val(json.harga_jual4);
        $('#kolom_cek_harga').val('1');
        }
        else if (level_harga == "harga_5") {

        $('#harga_produk').val(json.harga_jual5);
        $('#harga_baru').val(json.harga_jual5);
        $('#harga_lama').val(json.harga_jual5);
        $('#kolom_cek_harga').val('1');
        }
        else if (level_harga == "harga_6") {

        $('#harga_produk').val(json.harga_jual6);
        $('#harga_baru').val(json.harga_jual6);
        $('#harga_lama').val(json.harga_jual6);
        $('#kolom_cek_harga').val('1');
        }
        else if (level_harga == "harga_7") {

        $('#harga_produk').val(json.harga_jual7);
        $('#harga_baru').val(json.harga_jual7);
        $('#harga_lama').val(json.harga_jual7);
        $('#kolom_cek_harga').val('1');
        }

        $('#nama_barang').val(json.nama_barang);
        $('#limit_stok').val(json.limit_stok);
        $('#satuan_produk').val(json.satuan);
        $('#satuan_konversi').val(json.satuan);
        $('#id_produk').val(json.id);
        $('#ber_stok').val(json.berkaitan_dgn_stok);
        $('#jumlahbarang').val(json.foto);

      }
                                              
        });
  }/// else untuk cek data barang     
});////penutup function(data)


        });
        });

      
      
</script>

-->


<script type="text/javascript">
  
  $(document).ready(function(){
  $("#kode_barang").change(function(){

    var kode_barang = $(this).val();
    var nama_barang = $('#opt-produk-'+kode_barang).attr("nama-barang");
    var harga_jual = $('#opt-produk-'+kode_barang).attr("harga");
    var harga_jual2 = $('#opt-produk-'+kode_barang).attr('harga_jual_2');  
    var harga_jual3 = $('#opt-produk-'+kode_barang).attr('harga_jual_3');
    var harga_jual4 = $('#opt-produk-'+kode_barang).attr('harga_jual_4');
    var harga_jual5 = $('#opt-produk-'+kode_barang).attr('harga_jual_5');  
    var harga_jual6 = $('#opt-produk-'+kode_barang).attr('harga_jual_6');
    var harga_jual7 = $('#opt-produk-'+kode_barang).attr('harga_jual_7');
    var jumlah_barang = $('#opt-produk-'+kode_barang).attr("jumlah-barang");
    var satuan = $('#opt-produk-'+kode_barang).attr("satuan");
    var kategori = $('#opt-produk-'+kode_barang).attr("kategori");
    var status = $('#opt-produk-'+kode_barang).attr("status");
    var suplier = $('#opt-produk-'+kode_barang).attr("suplier");
    var limit_stok = $('#opt-produk-'+kode_barang).attr("limit_stok");
    var ber_stok = $('#opt-produk-'+kode_barang).attr("ber-stok");
    var tipe_produk = $('#opt-produk-'+kode_barang).attr("tipe_barang");
    var id_barang = $('#opt-produk-'+kode_barang).attr("id-barang");
    var level_harga = $("#level_harga").val();
    var no_reg = $("#no_reg").val();

  if (no_reg == ""){
         alert("No. Reg Tidak Boleh Kosong !");
         $("#jumlah_barang").val('');
         $("#nama_barang").val('');
         $("#kode_barang").val('');
         $("#dosis_obat").val('');
         $("#col_dosis").hide();
         $("#kode_barang").trigger('chosen:updated');
         $("#cari_pasien").click();
        
    }

    else if (level_harga == "harga_1") {

        $('#harga_produk').val(harga_jual);
        $('#harga_baru').val(harga_jual);
        $('#harga_lama').val(harga_jual);
        $('#kolom_cek_harga').val('1');
        }
    else if (level_harga == "harga_2") {

        $('#harga_produk').val(harga_jual2);
        $('#harga_baru').val(harga_jual2);
        $('#harga_lama').val(harga_jual2);
        $('#kolom_cek_harga').val('1');
        }
    else if (level_harga == "harga_3") {

        $('#harga_produk').val(harga_jual3);
        $('#harga_baru').val(harga_jual3);
        $('#harga_lama').val(harga_jual3);
        $('#kolom_cek_harga').val('1');
        }
    else if (level_harga == "harga_4") {

        $('#harga_produk').val(harga_jual4);
        $('#harga_baru').val(harga_jual4);
        $('#harga_lama').val(harga_jual4);
        $('#kolom_cek_harga').val('1');
        }
    else if (level_harga == "harga_5") {

        $('#harga_produk').val(harga_jual5);
        $('#harga_baru').val(harga_jual5);
        $('#harga_lama').val(harga_jual5);
        $('#kolom_cek_harga').val('1');
        }
    else if (level_harga == "harga_6") {

        $('#harga_produk').val(harga_jual6);
        $('#harga_baru').val(harga_jual6);
        $('#harga_lama').val(harga_jual6);
        $('#kolom_cek_harga').val('1');
        }
    else if (level_harga == "harga_7") {

        $('#harga_produk').val(harga_jual7);
        $('#harga_baru').val(harga_jual7);
        $('#harga_lama').val(harga_jual7);
        $('#kolom_cek_harga').val('1');
        }



    $("#tipe_produk").val(tipe_produk);
    $("#kode_barang").val(kode_barang);
    $("#nama_barang").val(nama_barang);
    $("#jumlah_barang").val(jumlah_barang);
    $("#satuan_produk").val(satuan);
    $("#satuan_konversi").val(satuan);
    $("#limit_stok").val(limit_stok);
    $("#ber_stok").val(ber_stok);
    $("#id_produk").val(id_barang);

if (ber_stok == 'Barang') {

    $.post('ambil_jumlah_produk.php',{kode_barang:kode_barang}, function(data){
      if (data == "") {
        data = 0;
      }
      $("#jumlahbarang").val(data);
      $('#kolom_cek_harga').val('1');
    });

}


$.post('cek_kode_barang_tbs_penjualan.php',{kode_barang:kode_barang,no_reg:no_reg}, function(data){
          
  if(data == 1){
          alert("Anda Tidak Bisa Menambahkan Barang Yang Sudah Ada, Silakan Edit atau Pilih Barang Yang Lain !");

          $("#kode_barang").chosen("destroy");
          $("#kode_barang").val('');
          $("#nama_barang").val('');
          $("#kode_barang").trigger('chosen:open');
          $(".chosen").chosen({no_results_text: "Maaf, Data Tidak Ada!",search_contains:true}); 
   }//penutup if     



  });


var tipe_produk = $("#tipe_produk").val();

if (tipe_produk == 'Obat Obatan') {
      $("#col_dosis").show();
    }
   else{
      $("#col_dosis").hide();
    }  

var nama_barang = $("#nama_barang").val();
var otoritas_tipe_barang = $("#otoritas_tipe_barang").val();
var otoritas_tipe_jasa = $("#otoritas_tipe_jasa").val();
var otoritas_tipe_alat = $("#otoritas_tipe_alat").val();
var otoritas_tipe_bhp = $("#otoritas_tipe_bhp").val();
var otoritas_tipe_obat = $("#otoritas_tipe_obat").val();


  if(tipe_produk == 'Barang' && otoritas_tipe_barang < 1){
          alert("Anda Tidak Mempunyai Akses Menambahkan "+nama_barang+" !");

          $("#kode_barang").val('');
          $("#tipe_produk").val('');
          $("#nama_barang").val('');
          $("#kode_barang").trigger('chosen:updated');
          $("#kode_barang").trigger('chosen:open');
          $(".chosen").chosen({no_results_text: "Maaf, Data Tidak Ada!",search_contains:true}); 
   }//penutup if     

  else if(tipe_produk == 'Jasa' && otoritas_tipe_jasa < 1){
          alert("Anda Tidak Mempunyai Akses Menambahkan "+nama_barang+" !");

          $("#kode_barang").val('');
          $("#tipe_produk").val('');
          $("#nama_barang").val('');
          $("#kode_barang").trigger('chosen:updated');
          $("#kode_barang").trigger('chosen:open');
          $(".chosen").chosen({no_results_text: "Maaf, Data Tidak Ada!",search_contains:true}); 
   }//penutup if     

  else if(tipe_produk == 'Alat' && otoritas_tipe_alat < 1){
          alert("Anda Tidak Mempunyai Akses Menambahkan "+nama_barang+" !");

          $("#kode_barang").val('');
          $("#tipe_produk").val('');
          $("#nama_barang").val('');
          $("#kode_barang").trigger('chosen:updated');
          $("#kode_barang").trigger('chosen:open');
          $(".chosen").chosen({no_results_text: "Maaf, Data Tidak Ada!",search_contains:true}); 
   }//penutup if     

  else if(tipe_produk == 'BHP' && otoritas_tipe_bhp < 1){
          alert("Anda Tidak Mempunyai Akses Menambahkan "+nama_barang+" !");

          $("#kode_barang").val('');
          $("#tipe_produk").val('');
          $("#nama_barang").val('');
          $("#kode_barang").trigger('chosen:updated');
          $("#kode_barang").trigger('chosen:open');
          $(".chosen").chosen({no_results_text: "Maaf, Data Tidak Ada!",search_contains:true}); 
   }//penutup if     

  else if(tipe_produk == 'Obat Obatan' && otoritas_tipe_obat < 1){
          alert("Anda Tidak Mempunyai Akses Menambahkan "+nama_barang+" !");

          $("#kode_barang").val('');
          $("#tipe_produk").val('');
          $("#nama_barang").val('');
          $("#kode_barang").trigger('chosen:updated');
          $("#kode_barang").trigger('chosen:open');
          $(".chosen").chosen({no_results_text: "Maaf, Data Tidak Ada!",search_contains:true}); 
          $("#col_dosis").hide();
   }//penutup if  
    

  });
  });

      
      
</script>

<script> 
    shortcut.add("f2", function() {
        // Do something

        $("#kode_barang").trigger('chosen:open');


    });

    
    shortcut.add("f1", function() {
        // Do something

        $("#cari_produk_penjualan").click();

    }); 

    
    shortcut.add("alt+p", function() {
        // Do something

        $("#cari_pasien").click();

    }); 

    
    shortcut.add("f3", function() {
        // Do something

        $("#submit_produk").click();

    }); 

    
    shortcut.add("f4", function() {
        // Do something

        $("#carabayar1").focus();

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

    
    shortcut.add("f10", function() {

        // Do something

        $("#simpan_sementara").click();

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




   



        <script type="text/javascript">

$(document).ready(function(){

    $("#kd_pelanggan").change(function(){
        var kode_pelanggan = $("#kd_pelanggan").val();
        
        var level_harga = $(".opt-pelanggan-"+kode_pelanggan+"").attr("data-level");
        
        
        
        if(kode_pelanggan == 'Umum')
        {
           $("#level_harga").val('Level 1');
        }
        else 
        {
           $("#level_harga").val(level_harga);
        
        }
        
        
    });
});

          
        </script>



                            <script type="text/javascript">
                                 
                                  $(document).on('dblclick','.edit-jumlah',function(e){

                                    var id = $(this).attr("data-id");

                                    $("#text-jumlah-"+id+"").hide();
                                    $("#input-jumlah-"+id+"").attr("type", "text");



                                    

                                 });


                                     $(document).on('blur','.input_jumlah',function(e){

                                    var id = $(this).attr("data-id");
                                    var jumlah_baru = $(this).val();
                                    if (jumlah_baru == '') {
                                      jumlah_baru = 0;
                                    }
                                    var kode_barang = $(this).attr("data-kode");                                    
                                    var nama_barang = $(this).attr("data-nama-barang");
                                    var harga = $(this).attr("data-harga");
                                    var jumlah_lama = $("#text-jumlah-"+id+"").text();
                                    var satuan_konversi = $(this).attr("data-satuan");
                                    var tipe_barang = $(this).attr("data-tipe");
                                    var data_admin = bersihPemisah(bersihPemisah(bersihPemisah(bersihPemisah($("#biaya_admin_persen").val()))));
                            
                                    if (data_admin == '') {
                                      data_admin = 0;
                                    }
                                    var ppn = $("#ppn").val();
                                    /*
                                    var tax_faktur = bersihPemisah(bersihPemisah(bersihPemisah(bersihPemisah($("#tax").val()))));
                                        if (tax_faktur == '') {
                                      tax_faktur = 0;
                                    };*/
                                    var pot_fakt_rp = bersihPemisah(bersihPemisah(bersihPemisah(bersihPemisah($("#potongan_penjualan").val()))));

                                    var pot_fakt_per = bersihPemisah(bersihPemisah(bersihPemisah(bersihPemisah($("#potongan_persen").val()))));
                                    var subtotal_lama = bersihPemisah(bersihPemisah(bersihPemisah(bersihPemisah($("#text-subtotal-"+id+"").text()))));
                                    var potongan = bersihPemisah(bersihPemisah(bersihPemisah(bersihPemisah($("#text-potongan-"+id+"").text()))));

                                    var tax = bersihPemisah(bersihPemisah(bersihPemisah(bersihPemisah($("#text-tax-"+id+"").text()))));
                                   



                                    
                                    if (ppn == 'Exclude') {

                                   var subtotal1 = harga * jumlah_baru - potongan;

                                    var subtotal_penjualan = bersihPemisah(bersihPemisah(bersihPemisah(bersihPemisah($("#total2").val()))));

                                    var subtotal_ex = parseInt(subtotal_lama,10) - parseInt(tax,10);

                                    var cari_tax = (parseInt(tax,10) * 100) / parseInt(subtotal_ex,10);


                                    var cari_tax1 = parseInt(subtotal1,10) * parseInt(cari_tax,10) / 100;

                                    var jumlah_tax = Math.round(cari_tax1);

                                    var subtotal = parseInt(subtotal1,10) + parseInt(jumlah_tax,10);

                                     var subtotal_penjualan = subtotal_penjualan - subtotal_lama + subtotal;
                                    }
                                    else
                                    {

                                   var subtotal1 = harga * jumlah_baru - potongan;

                                    var subtotal_penjualan = bersihPemisah(bersihPemisah(bersihPemisah(bersihPemisah($("#total2").val()))));

                                      var cari_tax = parseInt(subtotal_lama,10) - parseInt(tax,10);
                                    var cari_tax1 = parseInt(subtotal_lama,10) / parseInt(cari_tax,10);

                                    var tax_ex = cari_tax1.toFixed(2);

                                    var subtotal = subtotal1;
                                    var tax_ex1 = parseInt(subtotal,10) / tax_ex;
                                    var tax_ex2 = parseInt(subtotal,10) - parseInt(Math.round(tax_ex1));
                                    var jumlah_tax = Math.round(tax_ex2);
                                    

                                       var subtotal_penjualan = subtotal_penjualan - subtotal_lama + subtotal;

                                    }

                                    var biaya_adm = parseInt(subtotal_penjualan,10) * data_admin /100;

                                    if (pot_fakt_per == 0) {
                                      var potongaaan = pot_fakt_rp;

                                      var potongaaan_per = parseInt(potongaaan,10) / parseInt(subtotal_penjualan,10) * 100;
                                      var potongaaan = pot_fakt_rp;
                                  /*
                                      var hitung_tax = parseInt(subtotal_penjualan,10) - parseInt(pot_fakt_rp,10);
                                      var tax_bener = parseInt(hitung_tax,10) * parseInt(tax_faktur,10) / 100;*/

                                      var total_akhir = parseInt(subtotal_penjualan,10) - parseInt(pot_fakt_rp,10) + parseInt(biaya_adm,10);


                                    }
                                    else if(pot_fakt_rp == 0)
                                    {
                                      var potongaaan = pot_fakt_per;
                                      var pos = potongaaan.search("%");
                                      var potongan_persen = bersihPemisah(bersihPemisah(bersihPemisah(bersihPemisah(potongaaan))));
                                          potongan_persen = potongan_persen.replace("%","");
                                      potongaaan = subtotal_penjualan * potongan_persen / 100;
                                      
                                      var potongaaan_per = pot_fakt_per;  /*
                                      var hitung_tax = parseInt(subtotal_penjualan,10) - parseInt(potongaaan,10);
                                      var tax_bener = parseInt(hitung_tax,10) * parseInt(tax_faktur,10) / 100;*/

                                     var total_akhir = parseInt(subtotal_penjualan,10) - parseInt(potongaaan,10) + parseInt(biaya_adm,10);

                                    }
                                     else if(pot_fakt_rp != 0 && pot_fakt_rp != 0)
                                    {
                                      var potongaaan = pot_fakt_per;
                                      var pos = potongaaan.search("%");
                                      var potongan_persen = bersihPemisah(bersihPemisah(bersihPemisah(bersihPemisah(potongaaan))));
                                          potongan_persen = potongan_persen.replace("%","");
                                      potongaaan = subtotal_penjualan * potongan_persen / 100;
                                      
                                      var potongaaan_per = pot_fakt_per;
                                      /*
                                      var hitung_tax = parseInt(subtotal_penjualan,10) - parseInt(potongaaan,10);
                                      var tax_bener = parseInt(hitung_tax,10) * parseInt(tax_faktur,10) / 100;*/
                                 
                                      var total_akhir = parseInt(subtotal_penjualan,10) - parseInt(potongaaan,10) + parseInt(biaya_adm,10);

                                    
                                    }


// MULAI IF OTORITAS TIPE PRODUK MULAI IF OTORITAS TIPE PRODUK MULAI IF OTORITAS TIPE PRODUK MULAI IF OTORITAS TIPE PRODUK MULAI IF OTORITAS TIPE PRODUK

                                    var tipe_produk = $('#opt-produk-'+kode_barang).attr("tipe_barang");      
                                    $("#tipe_produk").val(tipe_produk);

                                    
                                    var tipe_produk = $("#tipe_produk").val();
                                    var otoritas_tipe_barang = $("#otoritas_tipe_barang").val();
                                    var otoritas_tipe_jasa = $("#otoritas_tipe_jasa").val();
                                    var otoritas_tipe_alat = $("#otoritas_tipe_alat").val();
                                    var otoritas_tipe_bhp = $("#otoritas_tipe_bhp").val();
                                    var otoritas_tipe_obat = $("#otoritas_tipe_obat").val();


                                if(tipe_produk == 'Barang' && otoritas_tipe_barang < 1){
                                        alert("Anda Tidak Mempunyai Akses Mengedit "+nama_barang+" !");

                                                $("#input-jumlah-"+id+"").val(jumlah_lama);
                                                $("#text-jumlah-"+id+"").text(jumlah_lama);
                                                $("#text-jumlah-"+id+"").show();
                                                $("#input-jumlah-"+id+"").attr("type", "hidden");
                                 }//penutup if     

                                else if(tipe_produk == 'Jasa' && otoritas_tipe_jasa < 1){
                                        alert("Anda Tidak Mempunyai Akses Mengedit "+nama_barang+" !");

                                                $("#input-jumlah-"+id+"").val(jumlah_lama);
                                                $("#text-jumlah-"+id+"").text(jumlah_lama);
                                                $("#text-jumlah-"+id+"").show();
                                                $("#input-jumlah-"+id+"").attr("type", "hidden");
                                 }//penutup if     

                                else if(tipe_produk == 'Alat' && otoritas_tipe_alat < 1){
                                        alert("Anda Tidak Mempunyai Akses Mengedit "+nama_barang+" !");

                                                $("#input-jumlah-"+id+"").val(jumlah_lama);
                                                $("#text-jumlah-"+id+"").text(jumlah_lama);
                                                $("#text-jumlah-"+id+"").show();
                                                $("#input-jumlah-"+id+"").attr("type", "hidden");
                                 }//penutup if     

                                else if(tipe_produk == 'BHP' && otoritas_tipe_bhp < 1){
                                        alert("Anda Tidak Mempunyai Akses Mengedit "+nama_barang+" !");

                                                $("#input-jumlah-"+id+"").val(jumlah_lama);
                                                $("#text-jumlah-"+id+"").text(jumlah_lama);
                                                $("#text-jumlah-"+id+"").show();
                                                $("#input-jumlah-"+id+"").attr("type", "hidden");
                                 }//penutup if     

                                else if(tipe_produk == 'Obat Obatan' && otoritas_tipe_obat < 1){
                                        alert("Anda Tidak Mempunyai Akses Mengedit "+nama_barang+" !");

                                                $("#input-jumlah-"+id+"").val(jumlah_lama);
                                                $("#text-jumlah-"+id+"").text(jumlah_lama);
                                                $("#text-jumlah-"+id+"").show();
                                                $("#input-jumlah-"+id+"").attr("type", "hidden");
                                 }//penutup if  

// END IF OTORITAS TIPE PRODUK END IF OTORITAS TIPE PRODUK END IF OTORITAS TIPE PRODUK END IF OTORITAS TIPE PRODUK END IF OTORITAS TIPE PRODUK END IF OTORITAS TIPE PRODUK

// MULAI ELSE OTORITAS TIPE PRODUK MULAI ELSE OTORITAS TIPE PRODUK MULAI ELSE OTORITAS TIPE PRODUK MULAI ELSE OTORITAS TIPE PRODUK MULAI ELSE OTORITAS TIPE PRODUK

                                 else{


                                    if (jumlah_baru == 0) {
                                        alert("Jumlah barang tidak boleh nol atau kosong");

                                          $("#input-jumlah-"+id+"").val(jumlah_lama);
                                          $("#text-jumlah-"+id+"").text(jumlah_lama);
                                          $("#text-jumlah-"+id+"").show();
                                          $("#input-jumlah-"+id+"").attr("type", "hidden");
                                   }
                                   else
                                   {

                                    if (tipe_barang == 'Jasa' || tipe_barang == 'BHP' ) {
                                      
                                                $("#text-jumlah-"+id+"").show();
                                                $("#text-jumlah-"+id+"").text(jumlah_baru);
                                                
                                                $("#text-subtotal-"+id+"").text(tandaPemisahTitik(subtotal));
                                                $("#hapus-tbs-"+id+"").attr('data-subtotal', subtotal);
                                                $("#text-tax-"+id+"").text(Math.round(jumlah_tax));
                                                $("#input-jumlah-"+id+"").attr("type", "hidden"); 
                                                $("#total2").val(tandaPemisahTitik(subtotal_penjualan));  
                                                $("#total1").val(tandaPemisahTitik(Math.round(total_akhir)));      
                                                $("#potongan_penjualan").val(Math.round(potongaaan));
                                                $("#potongan_persen").val(Math.round(potongaaan_per));
                                                /*
                                                $("#tax_rp").val(Math.round(tax_bener));*/
                                                $("#pembayaran_penjualan").val('');
                                                $("#sisa_pembayaran_penjualan").val('');
                                                $("#kredit").val('');
                                                $("#biaya_adm").val(biaya_adm);

                                                $.post("update_pesanan_barang.php",{jumlah_lama:jumlah_lama,tax:tax,id:id,jumlah_baru:jumlah_baru,kode_barang:kode_barang,potongan:potongan,harga:harga,jumlah_tax:jumlah_tax,subtotal:subtotal},function(data){
                                                

                                                });

                                    }

                                    else{

                                                $.post("cek_stok_pesanan_barang.php",{kode_barang:kode_barang, jumlah_baru:jumlah_baru,satuan_konversi:satuan_konversi},function(data){
                                                
                                                if (data < 0) {
                                                
                                                alert ("Jumlah Yang Di Masukan Melebihi Stok !");
                                                
                                                $("#input-jumlah-"+id+"").val(jumlah_lama);
                                                $("#text-jumlah-"+id+"").text(jumlah_lama);
                                                $("#text-jumlah-"+id+"").show();
                                                $("#input-jumlah-"+id+"").attr("type", "hidden");
                                                
                                                }
                                                
                                                else{
                                                
                                                
                                                
                                                $("#text-jumlah-"+id+"").show();
                                                $("#text-jumlah-"+id+"").text(jumlah_baru);
                                                
                                                $("#text-subtotal-"+id+"").text(tandaPemisahTitik(subtotal));
                                                $("#hapus-tbs-"+id+"").attr('data-subtotal', subtotal);
                                                $("#text-tax-"+id+"").text(Math.round(jumlah_tax));
                                                $("#input-jumlah-"+id+"").attr("type", "hidden"); 
                                                $("#total2").val(tandaPemisahTitik(subtotal_penjualan));  
                                                $("#total1").val(tandaPemisahTitik(Math.round(total_akhir)));      
                                                $("#potongan_penjualan").val(Math.round(potongaaan));
                                                $("#potongan_persen").val(Math.round(potongaaan_per)); 
                                                /* $("#tax_rp").val(Math.round(tax_bener)); */ 
                                                $("#pembayaran_penjualan").val('');
                                                $("#sisa_pembayaran_penjualan").val('');
                                                $("#kredit").val('');
                                                $("#biaya_adm").val(biaya_adm);
                                                
                                                $.post("update_pesanan_barang.php",{jumlah_lama:jumlah_lama,tax:tax,id:id,jumlah_baru:jumlah_baru,kode_barang:kode_barang,potongan:potongan,harga:harga,jumlah_tax:jumlah_tax,subtotal:subtotal},function(){
                                                
                                                
                                                
                                                
                                                
                                                });
                                                
                                                }
                                                
                                                });

                                            }
                                          }


                                 }

// END ELSE OTORITAS TIPE PRODUK END ELSE OTORITAS TIPE PRODUK END ELSE OTORITAS TIPE PRODUK END ELSE OTORITAS TIPE PRODUK END ELSE OTORITAS TIPE PRODUK
       
                                    $("#kode_barang").trigger('chosen:open');
                                    

                                 });

                             </script>


<!-- EDIT DOSIS OBAT -->

<script type="text/javascript">
                                 
      $(document).on('dblclick','.edit-dosis',function(){

        var id = $(this).attr("data-id");

          $("#text-dosis-"+id+"").hide();
          $("#input-dosis-"+id+"").attr("type", "text");
        
      });

      $(document).on('blur','.input_dosis',function(){

        var id = $(this).attr("data-id");
        var input_dosis = $(this).val();


        $.post("update_dosis_obat.php",{id:id, input_dosis:input_dosis},function(data){

        $("#text-dosis-"+id+"").show();
        $("#text-dosis-"+id+"").text(input_dosis);
        $("#input-dosis-"+id+"").attr("type", "hidden");           

        });
      });


</script>

<!-- END EDIT DOSIS OBAT -->


<script type="text/javascript">
    $(document).ready(function(){


      /*$("#tax").attr("disabled", true);*/

    // cek ppn exclude 
    var no_reg = $("#no_reg").val();
    $.get("cek_ppn_ex.php",{no_reg:no_reg},function(data){
      if (data == 1) {
          $("#ppn").val('Exclude');
     $("#ppn").attr("disabled", true);
     $("#tax1").attr("disabled", false);
      }
      else if(data == 2){

      $("#ppn").val('Include');
     $("#ppn").attr("disabled", true);
       $("#tax1").attr("disabled", false);
      }
      else
      {

     $("#ppn").val('Non');
     $("#tax1").attr("disabled", true);

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

<script type="text/javascript">
$(document).ready(function(){
  $("#batal_penjualan").click(function(){
    var no_reg = $("#no_reg").val()

    var pesan_alert = confirm("Apakah Anda Yakin Ingin Membatalkan Transaksi "+no_reg+""+ "?");
    if (pesan_alert == true) {
        
        $.get("batal_penjualan_raja.php",{no_reg:no_reg},function(data){
              $('#tabel_tbs_penjualan').DataTable().destroy();

                          var dataTable = $('#tabel_tbs_penjualan').DataTable( {
                            "processing": true,
                            "serverSide": true,
                            "ajax":{
                              url :"data_tbs_penjualan.php", // json datasource
                               "data": function ( d ) {
                                  d.no_reg = $("#no_reg").val();
                                  // d.custom = $('#myInput').val();
                                  // etc
                              },
                               
                                type: "post",  // method  , by default get
                              error: function(){  // error handling
                                $(".employee-grid-error").html("");
                                $("#tabel_tbs_penjualan").append('<tbody class="employee-grid-error"><tr><th colspan="3">No data found in the server</th></tr></tbody>');
                                $("#employee-grid_processing").css("display","none");
                                }
                            },
                               "fnCreatedRow": function( nRow, aData, iDataIndex ) {

                                $(nRow).attr('class','tr-id-'+aData[11]+'');         

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



<!-- SCRIPT MENCARI DATA PASIEN -->
<script type="text/javascript">
            $(document).ready(function(){
                $('#no_rm').change(function()
                    {
                          var no_rm = $("#no_rm").val();

                          var no_rm = no_rm.substr(0, no_rm.indexOf(' |'));
                          
                    if (no_rm == '')
                    {
                          $('#no_reg').val('');
                          $('#dokter').val('');
                          $('#asal_poli').val('');
                          $('#penjamin').val('');
                          $('#no_faktur').val('');
                          $('#total2').val('');
                          $('#total1').val('');
                          $('#level_harga').val('');

                         $('#table-baru').html('');

                    }
                    else
                    {
                          $.getJSON('lihat_data_kasir.php',{no_rm:$(this).val()}, function(json){
                        if (json == null)
                          {
                          $('#no_reg').val('');
                          $('#dokter').val('');
                          $('#asal_poli').val('');
                          $('#penjamin').val('');
                          $('#total2').val('');
                          $('#total1').val('');
                          $('#level_harga').val('');

                          $('#table-baru').html('');
                          }

                        else 
                          {

                          $("#dokter").chosen("destroy");
                          $('#no_rm').val(json.no_rm);

                          $('#no_reg').val(json.no_reg);

                          $('#dokter').val(json.dokter);
                          $('#asal_poli').val(json.poli);
                          $('#penjamin').val(json.penjamin);
                          $('#no_reg').val(json.no_reg);
                          $('#level_harga').val(json.provinsi);
                          $(".chosen").chosen({no_results_text: "Maaf, Data Tidak Ada!",search_contains:true}); 

                          $("#total").val(tandaPemisahTitik(json.petugas));              
                          $("#subtotal").val(tandaPemisahTitik(json.keterangan));  


                          var penjamin = $("#penjamin").val();

                            $(".ss").trigger("chosen:updated");

                            $.post("cek_tempo.php",{penjamin:penjamin},function(data){

                               if (data != '1970-01-01' ){

                                  $("#jatuh_tempo").val(data);
                               }

                               else{
                                  $("#jatuh_tempo").val('');

                                
                               }

                            });

                          }
                                              
                        });
                      }
                });
            });
</script>
<!--END SCRIPT CARI DATA PASIEN -->



<!-- AMBIL DATAT -->
<script type="text/javascript">
$(document).ready(function(){

function getUrl(sParam) {
      var sPageURL = window.location.search.substring(1);
    var sURLVariables = sPageURL.split('&');

    for (var i = 0; i < sURLVariables.length; i++)
    {
        var sParameterName = sURLVariables[i].split('=');
        if (sParameterName[0] == sParam)
        {
            return decodeURIComponent(sParameterName[1]);
        }
    }
}

var no_reg = getUrl('no_reg');
var rm_pasien = getUrl('no_rm');
var nama_pasien = getUrl('nama_pasien');
var no_rm = rm_pasien+""+" | "+""+nama_pasien+"";
var penjamin = getUrl('penjamin');
var dokter = getUrl('dokter');
var level_harga = getUrl('level_harga');
var poli = getUrl('poli');


if (no_rm == 'undefined | undefined') {

            $("#no_reg").val();
            $("#no_rm").val('');
            $("#level_hidden").val('');
            $("#nama_pasien").val('');
            $("#asal_poli").val('');
            $("#penjamin").val('');
            $("#penjamin").trigger('chosen:updated');
            $("#dokter").val('');
            $("#dokter").trigger('chosen:updated');
            $("#level_harga").val('');
            $("#level_harga").trigger('chosen:updated');
}
else{
            $("#no_reg").val(no_reg);
            $("#no_rm").val(no_rm);
            $("#level_hidden").val(level_harga);
            $("#nama_pasien").val(nama_pasien);
            $("#asal_poli").val(poli);
            $("#penjamin").val(penjamin);
            $("#penjamin").trigger('chosen:updated');
            $("#dokter").val(dokter);
            $("#dokter").trigger('chosen:updated');
            $("#level_harga").val(level_harga);
            $("#level_harga").trigger('chosen:updated');
            





            $('#modal_reg').modal('hide'); 

// START DATATABLE AJAX START DATATABLE AJAX START DATATABLE AJAX START DATATABLE AJAX START DATATABLE AJAX START DATATABLE AJAX
      $('#tabel_tbs_penjualan').DataTable().destroy();
            var dataTable = $('#tabel_tbs_penjualan').DataTable( {
            "processing": true,
            "serverSide": true,
            "info":     false,
            "language": { "emptyTable":     "My Custom Message On Empty Table" },
            "ajax":{
              url :"data_tbs_penjualan.php", // json datasource
               "data": function ( d ) {
                  d.no_reg = $("#no_reg").val();
                  // d.custom = $('#myInput').val();
                  // etc
              },
                  type: "post",  // method  , by default get
              error: function(){  // error handling
                $(".tbody").html("");
                $("#tabel_tbs_penjualan").append('<tbody class="tbody"><tr><th colspan="3"></th></tr></tbody>');
                $("#tableuser_processing").css("display","none");
                
              }
            }   

      });
        
        $("#span_tbs").show()
        $("#btnRujukLab").show()
        $("#btnRujukRadiologi").show()
        $('#pembayaran_penjualan').val('');
        $('#biaya_adm').val('');
        $('#biaya_admin_select').val('0');
        $("#biaya_admin_select").trigger('chosen:updated');
        $('#potongan_penjualan').val('');
        $('#potongan_persen').val('');

// END DATATABLE AJAX END DATATABLE AJAX END DATATABLE AJAX END DATATABLE AJAX END DATATABLE AJAX END DATATABLE AJAX


// CEK TOTAL CEK TOTAL CEK TOTAL CEK TOTAL CEK TOTAL CEK TOTAL CEK TOTAL CEK TOTAL CEK TOTAL CEK TOTAL CEK TOTAL CEK TOTAL CEK TOTAL

    var no_reg = $("#no_reg").val();
    var pot_fakt_per = bersihPemisah(bersihPemisah(bersihPemisah(bersihPemisah($("#potongan_persen").val()))));
    var pot_fakt_rp = bersihPemisah(bersihPemisah(bersihPemisah(bersihPemisah($("#potongan_penjualan").val()))));




if (no_reg == "") {

    }
    else{
      
       
          $.post("cek_total_seluruh_raja.php",{no_reg:no_reg},function(data1){
        
              if (data1 == 1) {

                       $.post("cek_total_seluruh.php",{no_reg:no_reg},function(data){
                      data = data.replace(/\s+/g, '');
                      if (data == "") {
                          data = 0;
                        }

                      var sum = parseInt(data,10);

                        $("#total2").val(tandaPemisahTitik(sum))

            if (pot_fakt_per == '0%') {
               
                var potongann = pot_fakt_rp;
                var potongaaan = parseInt(potongann,10) / parseInt(data,10) * 100;
                if (data == "") {
                    data = 0;
                    $("#potongan_persen").val(Math.round('0'));
                }
                else{
                  $("#potongan_persen").val(Math.round(potongaaan));
                }
          
                    
                    


            var total = parseInt(data,10) - parseInt(pot_fakt_rp,10);
                        $("#total1").val(tandaPemisahTitik(total))

                  }
                  else if(pot_fakt_rp == 0)
                  {
                     if (data == "") {
                          data = 0;
                      }

                        var potongaaan = pot_fakt_per;
                        var pos = potongaaan.search("%");
                        var potongan_persen = bersihPemisah(bersihPemisah(bersihPemisah(bersihPemisah(potongaaan))));
                        potongan_persen = potongan_persen.replace("%","");
                        potongaaan = data * potongan_persen / 100;
                        $("#potongan_penjualan").val(Math.round(potongaaan));
                        $("#potongan1").val(potongaaan);


            var total = parseInt(data,10) - parseInt(potongaaan,10);
                        $("#total1").val(tandaPemisahTitik(total))
                  }
            

                      });
              }


            });

          // END CEK TOTAL END CEK TOTAL END CEK TOTAL END CEK TOTAL END CEK TOTAL END CEK TOTAL END CEK TOTAL END CEK TOTAL END CEK TOTAL END CEK TOTAL

}

// CEK JATUH TEMPO
var penjamin = $("#penjamin").val();
  $.getJSON('jatuh_tempo_json.php',{penjamin:penjamin}, function(json){
      
      if (json == null)
      {        
        $('#tanggal_jt').val('');
      }
      else 
      {        
        $('#tanggal_jt').val(json.harga);
      }
  });
// END JATUH TEMPO


}

});
</script>

<script type="text/javascript">
  $(document).ready(function(){
     var no_reg = $("#no_reg").val();
       //digunakan untuk mengecek sama tidaknya jumlah disc dg total_subtotal di tbs
  $.getJSON("cek_jumlah_disc_dg_total_sub_tbs.php",{no_reg:no_reg},function(oke){
        $("#subt_tbs").val(oke.totale);
        $("#disc_tbs").val(oke.potongane);
      });
});
</script>

<script type="text/javascript">

//add  to select element
  $('#kode_barangg').selectize({
    create: true,
    sortField: 'text'
  });

</script>

<script type="text/javascript">
  $(window).bind('beforeunload', function(){
  return 'Apakah Yakin Ingin Meninggalkan Halaman Ini ? Karena Akan Membutuhkan Beberapa Waktu Untuk Membuka Kembali Halaman Ini!';
});
</script>


<script type="text/javascript">
    $(document).on('click','#btnRefreshPasien',function(e){

       var table_pasien = $('#tabel_cari_pasien').DataTable();
       table_pasien.draw();

    }); 
</script>



<?php include 'footer.php'; ?>