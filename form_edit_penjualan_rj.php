<?php include 'session_login.php';


// memasukan file session login,  header, navbar, db.php,
include 'header.php';
include 'navbar.php';
include 'db.php';
include 'sanitasi.php';


// menampilkan seluruh data yang ada pada tabel penjualan yang terdapt pada DB

$user = $_SESSION['nama'];
$no_faktur = stringdoang($_GET['no_faktur']);
$no_rm = stringdoang($_GET['no_rm']);
$kode_gudang = stringdoang($_GET['kode_gudang']);
$nama_pasien = stringdoang($_GET['nama_pasien']);
$no_reg = stringdoang($_GET['no_reg']);



$id_user = $_SESSION['id'];

$qu = $db->query("SELECT nama_gudang FROM gudang WHERE kode_gudang = '$kode_gudang' ");
$da = mysqli_fetch_array($qu);
$nama_gudang = $da['nama_gudang'];

$qu = $db->query("SELECT poli FROM registrasi WHERE no_reg = '$no_reg' ");
$da = mysqli_fetch_array($qu);
$poli = $da['poli'];

    $perintah = $db->query("SELECT tanggal, tunai, nilai_kredit, total,tax,potongan,dokter,penjamin,biaya_admin,tunai,jam,perawat,apoteker,petugas_lain FROM penjualan WHERE no_faktur = '$no_faktur' AND no_reg = '$no_reg'");
    $ambil_tanggal = mysqli_fetch_array($perintah);

$perintah_detail = $db->query("SELECT SUM(subtotal) AS total_detail FROM detail_penjualan WHERE no_faktur = '$no_faktur' AND no_reg = '$no_reg'");
    $data_detail = mysqli_fetch_array($perintah_detail);


    $dp = $ambil_tanggal['tunai'];
    $nilai_kredit = $ambil_tanggal['nilai_kredit'];
    
    $tax = $ambil_tanggal['tax']; 
    $potongan_p = $ambil_tanggal['potongan']; 
    $dokter = $ambil_tanggal['dokter']; 
    $apoteker = $ambil_tanggal['apoteker']; 
    $perawat = $ambil_tanggal['perawat'];
    $petugas_lain = $ambil_tanggal['petugas_lain'];

    $penjamin = $ambil_tanggal['penjamin']; 
    $biaya_adm = $ambil_tanggal['biaya_admin']; 

    $biaya_admi = ($biaya_adm *  $data_detail['total_detail']) / 100;
    $biaya_admin = round($biaya_admi);


    $pembayaran_awal = $ambil_tanggal['tunai'];
    $total_akhir = $ambil_tanggal['total'];

    $queryselect = $db->query("SELECT SUM(subtotal) AS subtotal FROM tbs_penjualan WHERE no_faktur = '$no_faktur' AND no_reg = '$no_reg'");
    $data_j = mysqli_fetch_array($queryselect);
    $subtotal = $data_j['subtotal'];    


if ($tax != 0) {

          $total = $total_akhir - $tax - $biaya_adm; 
          $pajak = $tax / $total * 100; 

            $total1 = $subtotal - $potongan_p;  
            $totalpajak = $total1 * $pajak / 100; 

        }
        else 
        {
          $pajak = 0;
         $totalpajak = 0;

        }

     

        $level_harga = $db->query("SELECT harga FROM penjamin WHERE nama = '$penjamin' ");
        $data_level = mysqli_fetch_array($level_harga);
        $level_harga = $data_level['harga'];

$pilih_akses_tombol = $db->query("SELECT * FROM otoritas_penjualan_rj WHERE id_otoritas = '$_SESSION[otoritas_id]' ");
$otoritas_tombol = mysqli_fetch_array($pilih_akses_tombol);


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


<script>
  $(function() {
    $( ".tanggal" ).datepicker({dateFormat: "yy-mm-dd"});
  });
   $(function() {
    $( "#tanggal_tmpl" ).datepicker({dateFormat: "yy-mm-dd"});
  });
  </script>


<script type="text/javascript">
            $(document).ready(function() {
                $('.jam_cari').timepicker({
                    showPeriodLabels: false
                });
              });
</script>

<!--untuk membuat agar tampilan form terlihat rapih dalam satu tempat -->
 <div style="padding-left: 5%; padding-right: 5%">


  <!--membuat teks dengan ukuran h3-->      
  <h3>EDIT PENJUALAN RAWAT JALAN : <?php echo $no_faktur;?></h3><hr><br>


<!--membuat agar tabel berada dalam baris tertentu-->
 <div class="row">
<div class="col-xs-8">
  

<!-- membuat form menjadi beberpa bagian -->
  <form enctype="multipart/form-data" role="form" action="formpenjualan.php" method="post ">
        

<div class="row"><!--div class="row"-->

      <div style="display: none" class="form-group col-xs-2">
          <label> No. Faktur </label>
          <input type="text" style="height:20px;" name="no_faktur" id="nomor_faktur_penjualan" class="form-control" readonly="" value="<?php echo $no_faktur; ?>" required="" >

            <input type="hidden" name="tanggal" id="tanggal"  value="<?php echo $ambil_tanggal['tanggal']; ?>" class="form-control tanggal" >
      </div>


      <div class="form-group col-xs-2">
         <label> No. RM / Pasien </label>
        <input type="text" name="no_rm" style="height:20px;" id="no_rm" class="form-control" value="<?php echo $no_rm; ?>(<?php echo $nama_pasien; ?>)">
       <input type="hidden" name="nama_pasien" id="nama_pasien" class="form-control" autofocus="" readonly="" value="<?php echo $nama_pasien; ?>">
      </div>



      <div class="col-xs-2">
      <label>Kasir</label>
      <input style="height:20px;" type="text" class="form-control"  id="petugas_kasir" name="petugas_kasir" value="<?php echo $user; ?>" readonly="">   
      </div>
      <input style="height:20px;" type="hidden" class="form-control"  id="id_user" name="id_user" value="<?php echo $id_user; ?>" readonly="">   





    <div class="col-xs-2">
      <label>No. REG :</label>
      <input style="height:20px" type="text" class="form-control"  id="no_reg" name="no_reg" value="<?php echo $no_reg; ?>" readonly="">   
</div>


 
      <div class="form-group  col-xs-2">
          <label> Gudang </label>
          
          <select name="kode_gudang" id="kode_gudang" class="form-control " required="" >
          <option value=<?php echo $kode_gudang; ?>><?php echo $nama_gudang; ?></option>
          <?php 
          
          // menampilkan seluruh data yang ada pada tabel suplier
          $query = $db->query("SELECT kode_gudang,nama_gudang FROM gudang");
          
          // menyimpan data sementara yang ada pada $query
          while($data = mysqli_fetch_array($query))
          {
          
          echo "<option value='".$data['kode_gudang'] ."'>".$data['nama_gudang'] ."</option>";
          }
          
          
          ?>
          </select>
      </div>

      <div class="form-group  col-xs-2">
          <label>PPN</label>
          <select name="ppn" id="ppn" class="form-control">
            <option value="Include">Include</option>  
            <option value="Exclude">Exclude</option>
            <option value="Non">Non</option>          
          </select>
      </div>

      <?php 

      $ses = $db->query("SELECT nama FROM user WHERE id = '$dokter'");
      $kel = mysqli_fetch_array($ses);
      $ses2 = $db->query("SELECT nama FROM user WHERE id = '$apoteker'");
      $kel2 = mysqli_fetch_array($ses2);
      $ses3 = $db->query("SELECT nama FROM user WHERE id = '$perawat'");
      $kel3 = mysqli_fetch_array($ses3);
      $ses4 = $db->query("SELECT nama FROM user WHERE id = '$petugas_lain'");
      $kel4 = mysqli_fetch_array($ses4);
      ?>

      <div class="col-xs-2">
      <label>Dokter Pelaksana</label>
      <select style="font-size:15px; height:35px" name="dokter" id="dokter" class="form-control chosen">
        <option value="<?php echo $dokter;?>"><?php echo $kel['nama'];?></option>

         <?php 
            
            //untuk menampilkan semua data pada tabel pelanggan dalam DB
            $query01 = $db->query("SELECT nama,id FROM user WHERE otoritas = 'Dokter'");

            //untuk menyimpan data sementara yang ada pada $query
            while($data01 = mysqli_fetch_array($query01))
            {
            

            if ($dokter == '') {
             echo "<option selected value='".$data01['id'] ."'>".$data01['nama'] ."</option>";
            }
            else{
              echo "<option value='".$data01['id'] ."'>".$data01['nama'] ."</option>";
            }

            
            }
            
            
            ?>

        </select>
      </div>

  <div class="col-xs-2">
        <label>Petugas Paramedik</label>
        <select style="font-size:15px; height:35px" name="petugas_paramedik" id="petugas_paramedik" class="form-control chosen">
                 <option value="<?php echo $paramedik;?>"><?php echo $kel3['nama'];?></option>

         <?php 
            
            //untuk menampilkan semua data pada tabel pelanggan dalam DB
            $query01 = $db->query("SELECT nama,id FROM user WHERE otoritas = 'Petugas Paramedik'");

            //untuk menyimpan data sementara yang ada pada $query
            while($data01 = mysqli_fetch_array($query01))
            {


            if ($paramedik == '') {
             echo "<option selected value='".$data01['id'] ."'>".$data01['nama'] ."</option>";
            }
            else{
              echo "<option value='".$data01['id'] ."'>".$data01['nama'] ."</option>";
            }

            
            }
            
            
            ?>

        </select>
      </div>  

</div><!--div class="row"-->


<div class="row"><!--div class="row"-->


<div class="col-xs-2">
    <label> Tanggal  :</label>
    <input style="height:20px;" type="text" class="form-control"  id="tanggal_tmpl" name="tanggal_tmpl" placeholder="Isi Poli" autocomplete="off" value="<?php echo $ambil_tanggal['tanggal'];  ?>">   
 </div>



 <div class="col-xs-2">
<label> Jam :</label>
    <input style="height:20px;" type="text" class="form-control jam_cari"  id="jam" name="jam" placeholder="Isi Poli" autocomplete="off" value="<?php echo $ambil_tanggal['jam']; ?>" readonly="" > 
</div>


   <div class="col-xs-2">
      <label> Asal Poli :</label>
      <input style="height:20px;" type="text" class="form-control"  id="asal_poli" name="asal_poli" placeholder="Isi Poli" autocomplete="off" value="<?php echo $poli; ?>">   
  </div>




    <div class="form-group col-xs-2">
    <label for="email">Penjamin:</label>
    <select class="form-control" id="penjamin" name="penjamin" required="">
    <option value='<?php  echo$penjamin; ?>'><?php  echo $penjamin;  ?></option>
      <?php    
     
      $query = $db->query("SELECT nama FROM penjamin");
      while ( $icd = mysqli_fetch_array($query))
      {
      echo "<option value='".$icd['nama']."'>".$icd['nama']."</option>";
      }
      ?>
    </select>
</div>



    <div class="form-group col-xs-2">
   <label> Level Harga </label>
     <select style="font-size:15px; height:40px" type="text" name="level_harga" id="level_harga" class="form-control" >
        <option value="<?php echo $level_harga;?>"> 
      <?php if ($level_harga == 'harga_1' )
      {?>
      Level 1
      <?php } elseif ($level_harga == 'harga_2' ){?>
      Level 2
      <?php }elseif ($level_harga == 'harga_3' ){?>
      Level 3
      <?php }elseif ($level_harga == 'harga_4' ){?>
      Level 4
      <?php }elseif ($level_harga == 'harga_5' ){?>
      Level 5
      <?php }elseif ($level_harga == 'harga_6' ){?>
      Level 6
      <?php }elseif ($level_harga == 'harga_7' ){?>
      Level 7
      <?php }?>
  </option>
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
  <label>Petugas Farmasi</label>
  <select style="font-size:15px; height:35px" name="petugas_farmasi" id="petugas_farmasi" class="form-control chosen">
        <option value="<?php echo $apoteker;?>"><?php echo $kel2['nama'];?></option>
    <?php 
      
      //untuk menampilkan semua data pada tabel pelanggan dalam DB
      $query01 = $db->query("SELECT nama,id FROM user WHERE otoritas = 'Petugas Farmasi'");

      //untuk menyimpan data sementara yang ada pada $query
      while($data01 = mysqli_fetch_array($query01))
      {
      
      if ($apoteker == '') {
       echo "<option selected value='".$data01['id'] ."'>".$data01['nama'] ."</option>";
      }
      else{
        echo "<option value='".$data01['id'] ."'>".$data01['nama'] ."</option>";
      }

      
      }
      
      
      ?>

  </select> 
</div>  




<div class="col-xs-2">
<label>Petugas Lain</label>
<select style="font-size:15px; height:35px" name="petugas_lain" id="petugas_lain" class="form-control chosen">
        <option value="<?php echo $petugas_lain;?>"><?php echo $kel4['nama'];?></option>
  <?php 
    
    //untuk menampilkan semua data pada tabel pelanggan dalam DB
    $query01 = $db->query("SELECT nama,id FROM user WHERE otoritas = 'Petugas Lain'");

    //untuk menyimpan data sementara yang ada pada $query
    while($data01 = mysqli_fetch_array($query01))
    {
    
    
    echo "<option value='".$data01['id'] ."'>".$data01['nama'] ."</option>";

    
    }
    
    
    ?>

</select>
</div>


</div><!--div class="row"-->

<input type="hidden" name="ppn_input" id="ppn_input" value="Include" class="form-control" placeholder="ppn input">


<!--
    <label style="display: none"> Kode Meja </label><br>
    <input type="hidden" name="kode_meja" id="kode_meja" class="form-control" readonly="" value="<?php // echo $kode_meja; ?>" required="" >
-->
        

  </form><!--tag penutup form-->


<button type="button" id="cari_produk_penjualan" class="btn btn-info" data-toggle="modal" data-target="#myModal"><i class='fa fa-search'> </i> Cari (F1)</button>



<!--tampilan modal-->
<div id="myModal" class="modal fade" role="dialog">
  <div class="modal-dialog modal-lg">

    <!-- isi modal-->
    <div class="modal-content">

      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title">Data Barang</h4>
      </div>
      <div class="modal-body">


<span class="modal_baru">
  <div class="table-resposive">
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
</span>
</div> <!-- tag penutup modal-body-->
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
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
        <h4 class="modal-title">Konfirmsi Hapus Data Edit Pembelian</h4>
      </div>
      <div class="modal-body">
   <p>Apakah Anda yakin Ingin Menghapus Data ini ?</p>
   <form >
    <div class="form-group">
     <input type="text" id="nama-barang" class="form-control" readonly=""> 
     <input type="text" id="kode-barang" class="form-control" readonly=""> 
     <input type="hidden" id="id_hapus" class="form-control" >

    </div>
   
   </form>
   
  <div class="alert alert-success" style="display:none">
   <strong>Berhasil!</strong> Data berhasil Di Hapus
  </div>
 

      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-info" id="btn_jadi_hapus">Ya</button>
        <button type="button" class="btn btn-warning" data-dismiss="modal">Batal</button>
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
    <label for="email">Jumlah Baru:</label>
     <input type="text" class="form-control" autocomplete="off" id="barang_edit"><br>
    <label for="email">Jumlah Lama:</label>
     <input type="text" class="form-control" id="barang_lama" readonly="">
     <input type="hidden" class="form-control" id="harga_edit" readonly="">
     <input type="hidden" class="form-control" id="faktur_edit" readonly="">
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
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
      </div>
    </div>

  </div>
</div><!-- end of modal edit data  -->


<div id="modal_alert" class="modal fade" role="dialog">
  <div class="modal-dialog">

    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h3 style="color:orange" class="modal-title"><span class="glyphicon glyphicon-info-sign">Info!</span></h3>
        <h4>Maaf No Transaksi <strong><?php echo $no_faktur
; ?></strong> tidak dapat dihapus atau di edit, karena telah terdapat Transaksi Pembayaran Piutang atau Retur Penjualan. Dengan daftar sebagai berikut :</h4>
      </div>

      <div class="modal-body">
      <span id="modal-alert">
       </span>


     </div>

      <div class="modal-footer">
        <h6 style="text-align: left"><i> * jika ingin menghapus atau mengedit data,<br>
        silahkan hapus terlebih dahulu Transaksi Pembayaran Piutang atau Retur Penjualan</i></h6>
        <button type="button" class="btn btn-warning btn-close" data-dismiss="modal">Close</button>
      </div>
    </div>

  </div>
</div>



<?php if ($otoritas_tombol['tombol_submit'] > 0):?>  

<!-- membuat form prosestbspenjual -->
<form class="form" action="proses_tambah_edit_penjualan.php" role="form" id="formtambahproduk">

<div class="row 1">

<br>
  <div class="col-xs-3">
    <div class="form-group">
    <select class="form-control chosen" style="height:15px;" name="kode_barang" id="kode_barang" autocomplete="off" accesskey="k" placeholder="Kode Produk">
     <option value="">SILAKAN PILIH</option>
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

    <input type="hidden" class="form-control" name="nama_barang" id="nama_barang" placeholder="Nama Barang" readonly="">
    </div>

  </div>


  <div class="col-xs-2">
      <div class="form-group">
    <input type="text" style="height:15px;" class="form-control" name="jumlah_barang" autocomplete="off" id="jumlah_barang" placeholder="Jumlah ">
      </div>
  </div>

  <div class="col-xs-2">
    <select type="text" style="font-size:15px; height:40px" name="satuan_konversi" id="satuan_konversi" class="form-control"  required="" >
          
          <?php 
          
          
          $query = $db->query("SELECT id, nama  FROM satuan");
          while($data = mysqli_fetch_array($query))
          {
          
          echo "<option value='".$data['id']."'>".$data['nama'] ."</option>";
          }
                      
          ?>
          
        </select>
  </div>


   <div class="form-group col-xs-2">
    <input type="text" style="height:15px;" class="form-control" name="potongan" autocomplete="off" id="potongan1" data-toggle="tooltip" data-placement="top" title="Jika Ingin Potongan Dalam Bentuk Persen (%), input : 10%" placeholder="Potongan" >
  </div>


      <div class="form-group col-xs-1">
      <input type="text" style="height:15px;"  class="form-control" name="tax" autocomplete="off" id="tax1"  placeholder="Tax (%)" >
      </div>



  <input type="hidden" class="form-control" name="jumlah_barang_tbs" id="jumlah_barang_tbs">


<input type="hidden" class="form-control" name="limit_stok" id="limit_stok">

  <input type="hidden" placeholder="Stok" class="form-control" name="jumlahbarang" id="jumlahbarang">

  <input type="hidden" class="form-control" name="ber_stok" id="ber_stok" placeholder="Ber Stok" >

  <input type="hidden" class="form-control" name="harga_lama" id="harga_lama">

  <input type="hidden" class="form-control" name="harga_baru" id="harga_baru">


  <input type="hidden" id="harga_produk" placeholder="Harga / Level" name="harga" class="form-control" value="" required="">

  <input type="hidden" id="satuan_produk" name="satuan" class="form-control" value="" required="">

  <input type="hidden" id="id_produk" name="id_produk" placeholder="id_produk" class="form-control" value="" required="">  

  
    <input type="hidden" id="level_hidden" name="level_hidden" class="form-control" value="<?php echo $level_harga;?>">        


<button type="submit" id="submit_produk" class="btn btn-success" data-faktur="<?php echo $no_faktur; ?>"> <i class='fa fa-plus'> </i>Tambah(F3)</button>



</div><!--end div row potngan,tax,tombol submit Tambah--> 

</form> <!-- tag penutup form -->
<?php endif;?>
                <!--untuk mendefinisikan sebuah bagian dalam dokumen-->  
     <input type="hidden" name="no_faktur" id="no_faktur0" class="form-control" value="<?php echo $no_faktur; ?>" required="" >
            
                
                <div class="table-responsive"> <!--tag untuk membuat garis pada tabel-->  
                <span id="table-baru">  
                <table id="tableuser"  class="table table-sm">
                <thead>
                <th> Kode Barang </th>
                <th> Nama Barang </th>
                <th> Nama Pelaksana </th>
                <th> Jumlah Barang </th>
                <th> Satuan </th>
                <th align="right"> Harga </th>
                <th align="right"> Potongan </th>
                <th align="right"> Pajak </th>
                <th align="right"> Subtotal </th>
                <th> Hapus </th>
                
                </thead>
                
                <tbody id="tbody">
                <?php
                
                //menampilkan semua data yang ada pada tabel tbs penjualan dalam DB
                $perintah = $db->query("SELECT tp.id,tp.no_faktur,tp.kode_barang,tp.satuan,tp.nama_barang,tp.jumlah_barang,tp.harga,tp.subtotal,tp.potongan,tp.tax,tp.jam,tp.tipe_barang,s.nama FROM tbs_penjualan tp INNER JOIN satuan s ON tp.satuan = s.id WHERE tp.no_faktur = '$no_faktur' AND no_reg = '$no_reg' ");
                
                //menyimpan data sementara yang ada pada $perintah
                
                while ($data1 = mysqli_fetch_array($perintah))
                {
                //menampilkan data
                echo "<tr class='tr-id-". $data1['id'] ." tr-kode-". $data1['kode_barang'] ."'>
                <td>". $data1['kode_barang'] ."</td>
                <td>". $data1['nama_barang'] ."</td>";


                $kd = $db->query("SELECT f.nama_petugas, u.nama FROM tbs_fee_produk f INNER JOIN user u ON f.nama_petugas = u.id WHERE f.kode_produk = '$data1[kode_barang]' AND f.no_reg = '$no_reg' ");
                
                $kdD = $db->query("SELECT f.nama_petugas, u.nama FROM tbs_fee_produk f INNER JOIN user u ON f.nama_petugas = u.id WHERE f.kode_produk = '$data1[kode_barang]' AND f.no_reg = '$no_reg' ");
                    
                $nu = mysqli_fetch_array($kd);

                  if ($nu['nama'] != '')
                  {

                  echo "<td style='font-size:15px;'>";
                   while($nur = mysqli_fetch_array($kdD))
                  {
                    echo $nur['nama']." ,";
                  }
                   echo "</td>";

                  }
                  else
                  {
                    echo "<td></td>";
                  }


$pilih = $db->query("SELECT no_faktur_penjualan FROM detail_retur_penjualan WHERE no_faktur_penjualan = '$data1[no_faktur]' AND kode_barang = '$data1[kode_barang]'");
$row_retur = mysqli_num_rows($pilih);

$pilih = $db->query("SELECT no_faktur_penjualan FROM detail_pembayaran_piutang WHERE no_faktur_penjualan = '$data1[no_faktur]'");
$row_piutang = mysqli_num_rows($pilih);

if ($row_retur > 0 || $row_piutang > 0) {

                echo"<td class='edit-jumlah-alert' data-id='".$data1['id']."' data-faktur='".$data1['no_faktur']."'  data-kode='".$data1['kode_barang']."'><span id='text-jumlah-".$data1['id']."'>". $data1['jumlah_barang'] ."</span> <input type='hidden' id='input-jumlah-".$data1['id']."' value='".$data1['jumlah_barang']."' class='input_jumlah' data-id='".$data1['id']."' autofocus='' data-kode='".$data1['kode_barang']."' data-satuan='".$data1['satuan']."' data-harga='".$data1['harga']."' data-tipe='".$data1['tipe_barang']."'> </td>";  

}
else {

 if ($otoritas_tombol['edit_produk'] > 0){ 

  echo"<td class='edit-jumlah' data-id='".$data1['id']."' data-faktur='".$data1['no_faktur']."'  data-kode='".$data1['kode_barang']."'><span id='text-jumlah-".$data1['id']."'>". $data1['jumlah_barang'] ."</span> <input type='hidden' id='input-jumlah-".$data1['id']."' value='".$data1['jumlah_barang']."' class='input_jumlah' data-id='".$data1['id']."' autofocus='' data-kode='".$data1['kode_barang']."' data-satuan='".$data1['satuan']."' data-harga='".$data1['harga']."' data-tipe='".$data1['tipe_barang']."'> </td>";  
}
else
{
  echo "<td style='font-size:15px' align='right' class='tidak_punya_otoritas' data-id='".$data1['id']."'><span id='text-jumlah-".$data1['id']."'>". $data1['jumlah_barang'] ."</span> </td>";
   }

}

                echo"<td>". $data1['nama'] ."</td>
                <td>". rp($data1['harga']) ."</td>
                <td><span id='text-potongan-".$data1['id']."'>". rp($data1['potongan']) ."</span></td>
                <td><span id='text-tax-".$data1['id']."'>". rp($data1['tax']) ."</span></td>
                <td><span id='text-subtotal-".$data1['id']."'>". rp($data1['subtotal']) ."</span></td>";




if ($row_retur > 0 || $row_piutang > 0) {

      echo "<td> <button class='btn btn-danger btn-sm btn-alert-hapus' id='btn-hapus-".$data1['id']."' data-id='".$data1['id']."' data-subtotal='".$data1['subtotal']."' data-faktur='".$data1['no_faktur']."' data-kode='".$data1['kode_barang']."'><span class='glyphicon glyphicon-trash'></span> Hapus </button></td>";

} 

else{

  if ($otoritas_tombol['hapus_produk'] > 0) {

      echo "<td> <button class='btn btn-danger btn-sm btn-hapus-tbs' id='btn-hapus-".$data1['id']."' data-id='". $data1['id'] ."' data-subtotal='".$data1['subtotal']."' data-kode-barang='". $data1['kode_barang'] ."' data-barang='". $data1['nama_barang'] ."'><span class='glyphicon glyphicon-trash'> </span> Hapus </button> </td>";

    }
else
{
   echo "<td style='font-size:12px; color:red'> Tidak Ada Otoritas </td>";
}

}

               

                
                echo"</tr>";


                }

                ?>
                </tbody>
                
                </table>

                </span>
                </div>

<button class="btn btn-primary" type="button" data-toggle="collapse" data-target="#collapseExample" aria-expanded="false" aria-controls="collapseExample"><i class='fa fa-stethoscope'> </i>
Laboratorium  </button>
</p>


 <div class="collapse" id="collapseExample">
<span id="tabel-lab">
<div class="table-responsive">
<table id="tableuser" class="table table-sm">
 
  <thead>
    <tr>

                <th> Kode  </th>
                <th> Nama </th>
                <th style="text-align: right" > Jumlah </th>
                <th style="text-align: right" > Harga </th>
                <th style="text-align: right" > Subtotal </th>
                <th style="text-align: right" > Potongan </th>
                <th style="text-align: right" > Pajak </th>

  </tr>
  </thead>
  <tbody id="tbody">
  
   <?php 
   $utama = $db->query("SELECT * FROM tbs_penjualan WHERE no_faktur = '$no_faktur' AND no_reg = '$no_reg' AND lab = 'Laboratorium'");
   while($data1 = mysqli_fetch_array($utama))      
    {
      
    echo "<tr class='tr-kode-". $data1['kode_barang'] ." tr-id-". $data1['id'] ."' data-kode-barang='".$data1['kode_barang']."'>
                <td style='font-size:15px'>". $data1['kode_barang'] ."</td>
                <td style='font-size:15px;'>". $data1['nama_barang'] ."</td>
                <td style='font-size:15px' align='right' class='edit-jumlah' data-id='".$data1['id']."'><span id='text-jumlah-".$data1['id']."'>". $data1['jumlah_barang'] ."</span> <input type='hidden' id='input-jumlah-".$data1['id']."' value='".$data1['jumlah_barang']."' class='input_jumlah' data-id='".$data1['id']."' autofocus='' data-kode='".$data1['kode_barang']."' data-tipe='".$data1['tipe_barang']."' data-harga='".$data1['harga']."' data-satuan='".$data1['satuan']."' data-tipe='".$data1['tipe_barang']."' > </td>
                <td style='font-size:15px' align='right'>". rp($data1['harga']) ."</td>
                <td style='font-size:15px' align='right'><span id='text-subtotal-".$data1['id']."'>". rp($data1['subtotal']) ."</span></td>
                <td style='font-size:15px' align='right'><span id='text-potongan-".$data1['id']."'>". rp($data1['potongan']) ."</span></td>
                <td style='font-size:15px' align='right'><span id='text-tax-".$data1['id']."'>". rp($data1['tax']) ."</span></td>

                </tr>";
    }


  ?>
  </tbody>
 </table>
 </div>
</span>
 </div>

 
                <h6 style="text-align: left ; color: red"><i> * Klik 2x pada kolom jumlah barang jika ingin mengedit.</i></h6>
                <h6 style="text-align: left ;"><i><b> * Short Key (F2) untuk mencari Kode Produk atau Nama Produk.</b></i></h6>

</div>



<div class="col-xs-4">
 
<div class="card card-block">

 <form action="proses_bayar_edit_jual.php" id="form_jual" method="POST" >
    
    <style type="text/css">
    .disabled {
    opacity: 0.6;
    cursor: not-allowed;
    disabled: false;
    }
    </style>

          <br>

        <div class="row">
            <div class="col-xs-6">
           
           <label style="font-size:15px"> <b> Subtotal </b></label><br>
           <input style="height:15px;font-size:15px" type="text" name="total" id="total2" class="form-control" placeholder="Total" readonly="" >
           
           </div>

          <div class="col-xs-6">
              <label>Biaya Admin </label><br>
            <select class="form-control chosen" id="biaya_admin_select" name="biaya_admin_select" data-admin="" >
            <option value="0"> Silahkan Pilih </option>
              <?php 
              $get_biaya_admin = $db->query("SELECT * FROM biaya_admin");
              while ( $take_admin = mysqli_fetch_array($get_biaya_admin))
              {
                if ($biaya_admin == $take_admin['persentase']) {
                    echo "<option selected value='".$take_admin['persentase']."'>".$take_admin['nama']." ".$take_admin['persentase']."%</option>";
                }
                else{
                    echo "<option value='".$take_admin['persentase']."'>".$take_admin['nama']." ".$take_admin['persentase']."%</option>";
                }

              }
              ?>
            </select>            
          </div>

                    <input type="hidden" name="biaya_adm" style="height:15px;font-size:15px" id="biaya_adm"  >


<div class="col-xs-6">
 </div>

          <div class="col-xs-6">
          <br>
          <label>Biaya Admin %</label>
          <input type="text" name="biaya_admin_persen" style="height:15px;font-size:15px" id="biaya_admin_persen" class="form-control" placeholder="Biaya Admin %" autocomplete="off" >
          </div>
</div>

<div class="row">
  
          <?php

          $ambil_diskon_tax = $db->query("SELECT * FROM setting_diskon_tax");
          $data_diskon = mysqli_fetch_array($ambil_diskon_tax);

        if ($data_diskon['diskon_nominal'] != 0 AND $data_diskon['diskon_persen'] == 0) 
        {// first if ($data_diskon['diskon_nominal'] != 0 AND $data_diskon['diskon_persen'] == 0) 

             $diskon = $data_diskon['diskon_nominal'];
                   if ($subtotal == 0) {
                        $diskon_p = 0;
                        $diskon_n = $diskon;
                    }
                    else{
                        $diskon_p = $diskon * 100 / $subtotal;
                        $diskon_n = $diskon;
                        }
        
         } // end if ($data_diskon['diskon_nominal'] != 0 AND $data_diskon['diskon_persen'] == 0) 

         else
         {

            $diskon = $data_diskon['diskon_persen'];

            $diskon_n = $subtotal /  100 * $diskon;
            $diskon_p = $diskon;

        }

          if ($potongan_p != 0) {
          $totaljum = $total_akhir - $tax - $biaya_adm + $potongan_p; 
          $potongan = $potongan_p / $totaljum * 100;

         $total_potongan = $subtotal * round($potongan) / 100;

        }
        else
        {
          $potongan = $diskon_p;
          $total_potongan = $diskon_n;
        }

         $hitung_total = $subtotal - $total_potongan; 
         $hitung_tax = $hitung_total * round($pajak) / 100;
         $total_akhir1 = $hitung_total + round($hitung_tax) + $biaya_adm;

            ?>
          <div class="col-xs-6">
            <label> Diskon ( Rp )</label><br>
            <input style="height:15px;font-size:15px" type="text" name="potongan" id="potongan_penjualan" value="<?php echo rp($total_potongan); ?>" class="form-control" placeholder="" autocomplete="off"  onkeydown="return numbersonly(this, event);" onkeyup="javascript:tandaPemisahTitik(this);">

          </div>

          <div class="col-xs-6">
            
          <label> Diskon ( % )</label><br>
          <input style="height:15px;font-size:15px" type="text" name="potongan_persen" id="potongan_persen" value="<?php echo round($potongan) ;?>" class="form-control" placeholder="" autocomplete="off" >

          </div>

          <!--
          <div class="form-group col-xs-4">
           <label> Pajak </label><br>
          <input style="height:15px;font-size:15px" type="text" name="tax" id="tax" value=""  class="form-control"  autocomplete="off" >

                    <input type="hidden" name="tax_rp" id="tax_rp" class="form-control"  autocomplete="off" value="">
          </div>-->

</div>


          
<div class="row">

          <div class="form-group col-xs-6">
          <label> Tanggal Jatuh Tempo </label><br>
          <input type="text" name="tanggal_jt" id="tanggal_jt" style="height:15px;font-size:15px"  value="" class="form-control tanggal" >
          </div>

          <div class="form-group  col-xs-6">
        <label style="font-size:15px"> <b> Cara Bayar (F4) </b> </label><br>
          <select type="text" name="cara_bayar" id="carabayar1" class="form-control" required=""  style="font-size: 16px" >
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



           <label style="display: none"> Adm Bank  (%)</label>
          <input type="hidden" name="adm_bank" id="adm_bank"  value="" class="form-control" >
          
    <div class="row">

     <div class="form-group  col-xs-6">  

          <label style="font-size:15px"> <b> Total Akhir </b></label><br>
           <b><input type="text" name="total" id="total1" class="form-control" style="height: 25px; width:90%; font-size:20px;" placeholder="Total" readonly="" value="<?php echo rp($total_akhir1); ?>"></b> 
     </div> 

      <div class="form-group  col-xs-6">

     <label style="font-size:15px">  <b> Pembayaran (F7)</b> </label><br>
           <b><input type="text" name="pembayaran" id="pembayaran_penjualan" style="height: 20px; width:90%; font-size:20px;" autocomplete="off" class="form-control"   style="font-size: 20px"  onkeydown="return numbersonly(this, event);" onkeyup="javascript:tandaPemisahTitik(this);"></b>
      </div>

    </div>

          




<div class="row">

        <div class="col-xs-6">

          <label> Pembayaran Awal </label><br>
          <input type="text" name="pembayaran" id="pembayaran_awal" style="height: 15px; width:90%;" autocomplete="off" class="form-control" readonly="" value="<?php echo rp($pembayaran_awal); ?>">

        </div>

          <div class="col-xs-6">
          <label> Kembalian </label><br>
          <b><input type="text" name="sisa_pembayaran" id="sisa_pembayaran_penjualan" style="height:15px;font-size:15px" class="form-control"  readonly="" required=""  style="font-size: 20px" ></b>
          </div>

</div>


<div class="row">
          

          
          <div class="col-xs-6">
          <label> Kredit </label><br>
          <b><input type="text" name="kredit" id="kredit" value="<?php echo rp($nilai_kredit); ?>" class="form-control" style="height:15px;font-size:15px"  readonly="" required="" ></b>
          </div>

          <div class="col-xs-6">
          <label> Keterangan </label><br>
          <textarea type="text" name="keterangan" id="keterangan" class="form-control"> 
          </textarea>
          </div>
</div>

          <b><input type="hidden" name="zxzx" id="zxzx" class="form-control" style="height: 50px; width:90%; font-size:25px;"  readonly="" required="" ></b>


          <b><input type="hidden" name="jumlah_bayar_lama" id="jumlah_bayar_lama" value="" class="form-control" style="height: 50px; width:90%; font-size:25px;"  readonly=""></b>

<?php 

if ($_SESSION['otoritas'] == 'Pimpinan') {
 echo '<label style="display:none"> Total Hpp </label><br>
          <input type="hidden" name="total_hpp" id="total_hpp" style="height: 50px; width:90%; font-size:25px;" class="form-control" placeholder="" readonly="" required="">';
}

         mysqli_close($db); 


 ?>

          <input type="hidden" name="jumlah" id="jumlah1" class="form-control" placeholder="jumlah">   <br> 
          
          
          <!-- memasukan teks pada kolom kode pelanggan, dan nomor faktur penjualan namun disembunyikan -->
          <input type="hidden" name="no_faktur" id="nofaktur" class="form-control" value="<?php echo $no_faktur
; ?>" required="" >
          
          <input type="hidden" name="kode_pelanggan" id="k_pelanggan" class="form-control" required="" >

</div>


 <?php if ($otoritas_tombol['tombol_bayar'] > 0):?>              
    <button type="submit" id="penjualan" class="btn btn-info" data-faktur='<?php echo $no_faktur?>'>Bayar(F8)</button>
<?php endif;?>


 <?php if ($otoritas_tombol['tombol_piutang'] > 0):?>              
  <button type="submit" id="piutang" class="btn btn-warning" data-faktur='<?php echo $no_faktur; ?>'>Piutang(F9)</button> 
<?php endif;?>




 <?php if ($otoritas_tombol['tombol_bayar'] > 0):?>              
     <button type="submit" id="cetak_langsung" target="blank" class="btn btn-success" style="font-size:15px"> Bayar / Cetak (Ctrl + K) </button>
<?php endif;?>
          

    <a href="lap_penjualan.php" id="transaksi_baru" class="btn btn-primary"  style="display: none;">Kembali</a>

    <a href='cetak_penjualan_tunai.php?no_faktur=<?php echo $no_faktur; ?>' id="cetak_tunai"  style="display: none;" class="btn btn-success" target="blank">Cetak Tunai </a>


    <a href='cetak_penjualan_tunai_besar.php?no_faktur=<?php echo $no_faktur; ?>' id="cetak_tunai_besar" style="display: none;"  class="btn btn-info" target="blank">Cetak Tunai Besar</a>

   <a href='cetak_penjualan_tunai_kategori.php' id="cetak_tunai_kategori" style="display: none;" class="btn btn-warning" target="blank"> Cetak Tunai/Kategori  </a>


  <?php if ($otoritas_tombol['tombol_batal'] > 0):?>              
 <button type="submit" id="batal_penjualan" class="btn btn-danger" style="font-size:15px">  Batal (Ctrl + B)</button>
<?php endif;?>


    <a href='cetak_penjualan_piutang.php?no_faktur=<?php echo $no_faktur ?>' id="cetak_piutang"  style="display: none;" class="btn btn-warning" target="blank"> <span class="  glyphicon glyphicon-print"> </span> Cetak Piutang </a>


     
</div>

          
          
 
    </form>
</div>




</div>
 
                

</div><!-- end of row -->   
          
          <br>
          <div class="alert alert-success" id="alert_berhasil" style="display:none">
          <strong>Success!</strong> Pembayaran Berhasil
          </div>

    

    </div><!-- end of container -->


<!-- AUTOCOMPLETE Pelanggan/pasien-->

<script>
$(function() {
    $( "#no_rm" ).autocomplete({
        source: 'kode_pelanggan_autocomplete.php'
    });
});
</script>
<!-- AUTOCOMPLETE --> 

<script type="text/javascript">
  $(document).ready(function(){
    $(document).on('change','#no_rm', function(e){

      var no_rm = $(this).val();
    var no_rm = no_rm.substr(0, no_rm.indexOf('('));

      $.getJSON("update_registrasi_pasien.php",{no_rm:no_rm},function(data){
        $("#asal_poli").val(data.poli);
        $("#penjamin").val(data.penjamin);
           

      });


    });
  })

</script>


<script type="text/javascript">
  $(document).on('click', '.tidak_punya_otoritas', function (e) {
    alert("Anda Tidak Punya Otoritas Untuk Edit Jumlah Produk !!");
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

    var no_faktur = $("#nomor_faktur_penjualan").val();
    var kode_barang = $("#kode_barang").val();
    
 $.post('cek_kode_barang_edit_tbs_penjualan.php',{kode_barang:kode_barang,no_faktur:no_faktur}, function(data){
  
  if(data == 1){
    alert("Anda Tidak Bisa Menambahkan Barang Yang Sudah Ada, Silakan Edit atau Pilih Barang Yang Lain !");
    $("#kode_barang").val('');
    $("#nama_barang").val('');
   }//penutup if

 });

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
}

else if (level_harga == "harga_2") {
  $("#harga_produk").val(harga_level_2);
  $("#harga_baru").val(harga_level_2);
  $("#harga_lama").val(harga_level_2);
}

else if (level_harga == "harga_3") {
  $("#harga_produk").val(harga_level_3);
  $("#harga_lama").val(harga_level_3);
  $("#harga_baru").val(harga_level_3);
}

else if (level_harga == "harga_4") {
  $("#harga_produk").val(harga_level_4);
  $("#harga_lama").val(harga_level_4);
  $("#harga_baru").val(harga_level_4);
}

else if (level_harga == "harga_5") {
  $("#harga_produk").val(harga_level_5);
  $("#harga_lama").val(harga_level_5);
  $("#harga_baru").val(harga_level_5);
}

else if (level_harga == "harga_6") {
  $("#harga_produk").val(harga_level_6);
  $("#harga_lama").val(harga_level_6);
  $("#harga_baru").val(harga_level_6);
}

else if (level_harga == "harga_7") {
  $("#harga_produk").val(harga_level_7);
  $("#harga_lama").val(harga_level_7);
  $("#harga_baru").val(harga_level_7);
}

  document.getElementById("jumlahbarang").value = $(this).attr('jumlah-barang');


  $('#myModal').modal('hide'); 
  $("#jumlah_barang").focus();


});

  </script>

<script>
//untuk menampilkan data tabel
$(document).ready(function(){
    $("#kode_barang").trigger('chosen:open');

});

</script>

<!-- cek stok  blur-->
<script type="text/javascript">
  $(document).ready(function(){
    $("#jumlah_barang").blur(function(){
      var jumlah_barang = bersihPemisah(bersihPemisah(bersihPemisah(bersihPemisah($("#jumlah_barang").val()))));
      var jumlahbarang = bersihPemisah(bersihPemisah(bersihPemisah(bersihPemisah($("#jumlahbarang").val()))));

      var satuan_konversi = $("#satuan_konversi").val();
      var kode_barang = $("#kode_barang").val();
      
      var id_produk = $("#id_produk").val();
      var prev = $("#satuan_produk").val();
      var limit_stok = $("#limit_stok").val();
      var ber_stok = $("#ber_stok").val();
      var stok = jumlahbarang - jumlah_barang;

        if (ber_stok == 'Jasa') {

          }

       else if (stok < 0) {

            alert("Jumlah Melebihi Stok");
            $("#jumlah_barang").val('');
          $("#satuan_konversi").val(prev);
          }// cek stok barang       

      else{

        }

    });
  });
</script>
<!-- cek stok blur-->




<!-- cek stok satuan konversi change-->
<script type="text/javascript">
  $(document).ready(function(){
    $("#satuan_konversi").change(function(){
      var jumlah_barang = bersihPemisah(bersihPemisah(bersihPemisah(bersihPemisah($("#jumlah_barang").val()))));;
      var satuan_konversi = $("#satuan_konversi").val();
      var kode_barang = $("#kode_barang").val();
      
      var no_faktur = $("#no_faktur0").val();
      var id_produk = $("#id_produk").val();
      var prev = $("#satuan_produk").val();

      $.post("cek_stok_konversi_edit_penjualan.php",
        {jumlah_barang:jumlah_barang,satuan_konversi:satuan_konversi,kode_barang:kode_barang,id_produk:id_produk,no_faktur:no_faktur},function(data){

          if (data < 0) {
            alert("Jumlah Melebihi Stok");
            $("#jumlah_barang").val('');
          $("#satuan_konversi").val(prev);

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
      var jumlah_barang = bersihPemisah(bersihPemisah(bersihPemisah(bersihPemisah($("#jumlah_barang").val()))));;
      var kode_barang = $("#kode_barang").val();
      
      

      $.getJSON("cek_konversi_penjualan.php",{kode_barang:kode_barang,satuan_konversi:satuan_konversi, id_produk:id_produk,harga_produk:harga_produk,jumlah_barang:jumlah_barang},function(info){

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

    $("#kd_pelanggan").change(function(){
      var kode_pelanggan = $("#kd_pelanggan").val();

      var level_harga = $(".opt-pelanggan-"+kode_pelanggan+"").attr("data-level");

    $("#level_harga").val(level_harga);

      });
          
        </script>




   <script>
   //untuk menampilkan data yang diambil pada form tbs penjualan berdasarkan id=formtambahproduk
  $("#submit_produk").click(function(){

    var no_faktur = $(this).attr("data-faktur");
    var no_reg = $("#no_reg").val();
    var no_rm = $("#no_rm").val();
    var no_rm = no_rm.substr(0, no_rm.indexOf('('));
    var dokter = $("#dokter").val();
    var penjamin = $("#penjamin").val();
    var asal_poli = $("#asal_poli").val();
    var level_harga = $("#level_harga").val();
    var petugas_kasir = $("#id_user").val(); 

    var limit_stok = $("#limit_stok").val(); 
 
    var petugas_paramedik = $("#petugas_paramedik").val();
    var petugas_farmasi = $("#petugas_farmasi").val();
    var petugas_lain = $("#petugas_lain").val();
    var kode_barang = $("#kode_barang").val();
    
    var tanggal = $("#tanggal_tmpl").val();
    var jam = $("#jam").val();

    var nama_barang = $("#nama_barang").val();
    var jumlah_barang = bersihPemisah(bersihPemisah(bersihPemisah(bersihPemisah($("#jumlah_barang").val()))));
    var harga = bersihPemisah(bersihPemisah(bersihPemisah(bersihPemisah($("#harga_produk").val()))));
    var potongan = $("#potongan1").val();

    var biaya_adm = bersihPemisah(bersihPemisah(bersihPemisah(bersihPemisah($("#biaya_adm").val()))));
    if (biaya_adm == '') {
      biaya_adm = 0;
    }

    if (potongan == '') {
      potongan = 0;
    };

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

      if (ppn == "Exclude") {

        var caritotal = parseInt(jumlah_barang,10) * parseInt(harga,10) - parseInt(potongan,10);

        var tax_ex = parseInt(caritotal,10) * parseInt(tax,10) / 100;

        var total = parseInt(caritotal,10) + parseInt(tax_ex,10);



      }
      else
      {
        var total = parseInt(jumlah_barang,10) * parseInt(harga,10) - parseInt(potongan,10);
      }

    

    var total_akhir1 = parseInt(subtotal,10) + parseInt(total,10);



    if (pot_fakt_per == 0) {
      var potongaaan = pot_fakt_rp;

      var potongaaan = parseInt(potongaaan,10) / parseInt(total_akhir1,10) * 100;
      /*
      var hitung_tax = parseInt(total_akhir1,10) - parseInt(pot_fakt_rp,10);
      var tax_bener = parseInt(hitung_tax,10) * parseInt(tax_faktur,10) / 100;*/

        var total_akhir = parseInt(total_akhir1,10) - parseInt(pot_fakt_rp,10) + parseInt(biaya_adm,10); /* + parseInt(Math.round(tax_bener,10));*/


    }
    else if(pot_fakt_rp == 0)
    {
      var potongaaan = pot_fakt_per;
      var pos = potongaaan.search("%");
      var potongan_persen = bersihPemisah(bersihPemisah(bersihPemisah(bersihPemisah(potongaaan))));
          potongan_persen = potongan_persen.replace("%","");
      potongaaan = total_akhir1 * potongan_persen / 100;
       /*
      var hitung_tax = parseInt(total_akhir1,10) - parseInt(Math.round(potongaaan,10));
      var tax_bener = parseInt(hitung_tax,10) * parseInt(tax_faktur,10) / 100; */

     var total_akhir = parseInt(total_akhir1,10) - parseInt(Math.round(potongaaan,10)) + parseInt(biaya_adm,10); /* + parseInt(Math.round(tax_bener,10))*/


    }
     else if(pot_fakt_rp != 0 && pot_fakt_rp != 0)
    {
      var potongaaan = pot_fakt_per;
      var pos = potongaaan.search("%");
      var potongan_persen = bersihPemisah(bersihPemisah(bersihPemisah(bersihPemisah(potongaaan))));
          potongan_persen = potongan_persen.replace("%","");
      potongaaan = total_akhir1 * potongan_persen / 100;
       /*
      var hitung_tax = parseInt(total_akhir1,10) - parseInt(Math.round(potongaaan,10));
      var tax_bener = parseInt(hitung_tax,10) * parseInt(tax_faktur,10) / 100;*/

          var total_akhir = parseInt(total_akhir1,10) - parseInt(Math.round(potongaaan,10)) + parseInt(biaya_adm,10); /* + parseInt(Math.round(tax_bener,10));*/


    }

    

     /*
    $("#tax_rp").val(Math.round(tax_bener));*/

     
  if (a > 0){
  alert("Anda Tidak Bisa Menambahkan Barang Yang Sudah Ada, Silakan Edit atau Pilih Barang Yang Lain !");
       $("#kode_barang").trigger('chosen:open');
  }
  else if (jumlah_barang == ''){
  alert("Jumlah Barang Harus Diisi");
       $("#jumlah_barang").focus();
}
  else if (jumlah_barang == 0){
  alert("Jumlah Barang Tidak Boleh 0");
       $("#jumlah_barang").focus();


  }
  else if (ber_stok == 'Jasa' ){

 $.post("proses_tbs_pesanan_barang_raja.php",{penjamin:penjamin,asal_poli:asal_poli,level_harga:level_harga,petugas_paramedik:petugas_paramedik,petugas_farmasi:petugas_farmasi,petugas_lain:petugas_lain,no_reg:no_reg,no_rm:no_rm,dokter:dokter,petugas_kasir:petugas_kasir,kode_barang:kode_barang,nama_barang:nama_barang,jumlah_barang:jumlah_barang,harga:harga,potongan:potongan,tax:tax,satuan:satuan, ber_stok:ber_stok,no_faktur:no_faktur,ppn:ppn,tanggal:tanggal,jam:jam},function(data){
     
    $("#potongan_persen").val(Math.round(potongaaan));
    $("#total1").val(Math.round(total_akhir));
    $("#total2").val(tandaPemisahTitik(total_akhir1));

     $("#ppn").attr("disabled", true);
     $("#tbody").prepend(data);
     $("#kode_barang").val('');
     $("#kode_barang").trigger('chosen:updated');
     $("#kode_barang").trigger('chosen:open');

     $("#nama_barang").val('');
     $("#jumlah_barang").val('');
     $("#potongan1").val('');
     $("#tax1").val('');
     $("#pembayaran_penjualan").val('');
     
     });


  
  } 

  else if (stok < 0 && ber_stok == 'Barang' ) {

            alert("Jumlah Melebihi Stok");
            $("#jumlah_barang").val('');
  }

  else{

  if (limit_stok > stok)
        {
          alert("Persediaan Barang Ini Sudah Mencapai Batas Limit Stok, Segera Lakukan Pembelian !");
        }

   $.post("proses_tbs_pesanan_barang_raja.php",{penjamin:penjamin,asal_poli:asal_poli,level_harga:level_harga,petugas_paramedik:petugas_paramedik,petugas_farmasi:petugas_farmasi,petugas_lain:petugas_lain,no_reg:no_reg,no_rm:no_rm,dokter:dokter,petugas_kasir:petugas_kasir,kode_barang:kode_barang,nama_barang:nama_barang,jumlah_barang:jumlah_barang,harga:harga,potongan:potongan,tax:tax,satuan:satuan,ber_stok:ber_stok,no_faktur:no_faktur,ppn:ppn,tanggal:tanggal,jam:jam},function(data){
     
    $("#potongan_persen").val(Math.round(potongaaan));
    $("#total1").val(Math.round(total_akhir));
    $("#total2").val(tandaPemisahTitik(total_akhir1));

      $("#ppn").attr("disabled", true);
     $("#tbody").prepend(data);
     $("#kode_barang").val('');
     $("#kode_barang").trigger('chosen:updated');
     $("#kode_barang").trigger('chosen:open');

     $("#nama_barang").val('');
     $("#jumlah_barang").val('');
     $("#potongan1").val('');
     $("#tax1").val('');
     $("#pembayaran_penjualan").val('');
     
     });
}
    

        
      
      
  });

    $("#formtambahproduk").submit(function(){
    return false;
    
    });


   </script>

<!--
 <script type="text/javascript">
  $(document).ready(function(){
$("#cari_produk_penjualan").click(function(){
  var no_faktur = $("#nomor_faktur_penjualan").val();

  $.post("cek_tbs_penjualan_pesanan.php",{no_faktur: "<?php echo $no_faktur; ?>"},function(data){
        if (data != "1") {


             $("#ppn").attr("disabled", false);

        }
    });

});
});
</script>-->



                        <script type="text/javascript">
                                 
                                $(document).on('dblclick','.edit-jumlah',function(){
                                

                                    var id = $(this).attr("data-id");

                                    $("#text-jumlah-"+id+"").hide();

                                    $("#input-jumlah-"+id+"").attr("type", "text");

                                 });


                                $(document).on('blur','.input_jumlah',function(){

                                    var id = $(this).attr("data-id");
                                    var jumlah_baru = $(this).val();
                                    var kode_barang = $(this).attr("data-kode");
                                    var harga = $(this).attr("data-harga");
                                    var tipe = $(this).attr("data-tipe");
                                    var jumlah_lama = $("#text-jumlah-"+id+"").text();

                                    if (jumlah_lama == "") {
                                      jumlah_lama = 0;
                                      }

                                    var biaya_adm = bersihPemisah(bersihPemisah(bersihPemisah(bersihPemisah($("#biaya_adm").val()))));
                                    if (biaya_adm == '') {
                                      biaya_adm = 0;
                                    }
                                    var ppn = $("#ppn").val();
                                    /*
                                    var tax_faktur = bersihPemisah(bersihPemisah(bersihPemisah(bersihPemisah($("#tax").val()))));
                                        if (tax_faktur == '') {
                                      tax_faktur = 0;
                                    };*/

                                    var pot_fakt_rp = bersihPemisah(bersihPemisah(bersihPemisah(bersihPemisah($("#potongan_penjualan").val()))));

                                    var pot_fakt_per = bersihPemisah(bersihPemisah(bersihPemisah(bersihPemisah($("#potongan_persen").val()))));

                                    var satuan_konversi = $(this).attr("data-satuan");
                                     var no_faktur = $("#no_faktur0").val();
                                    var subtotal_lama = bersihPemisah(bersihPemisah(bersihPemisah(bersihPemisah($("#text-subtotal-"+id+"").text()))));
                                    var potongan = bersihPemisah(bersihPemisah(bersihPemisah(bersihPemisah($("#text-potongan-"+id+"").text()))));

                                    var tax = bersihPemisah(bersihPemisah(bersihPemisah(bersihPemisah($("#text-tax-"+id+"").text()))));

                                   
                                     if (ppn == 'Exclude') {

                                   var subtotal1 = harga * jumlah_baru - potongan;

                                    var subtotal_penjualan = bersihPemisah(bersihPemisah(bersihPemisah(bersihPemisah($("#total2").val()))));

                                    //cari jumlah pajak sebelumnya
                                    var subtotal_ex = parseInt(subtotal_lama,10) - parseInt(tax,10);

                                    var cari_tax = (parseInt(tax,10) * 100) / parseInt(subtotal_ex,10);
                                     //end cari jumlah pajak sebelumnya

                                    var cari_tax1 = parseInt(subtotal1,10) * parseInt(cari_tax,10) / 100;

                                    var jumlah_tax = Math.round(cari_tax1);

                                    var subtotal = parseInt(subtotal1,10) + parseInt(jumlah_tax,10);

                                     var subtotal_penjualan = subtotal_penjualan - subtotal_lama + subtotal;
                                    }
                                    else
                                    {

                                   var subtotal1 = harga * jumlah_baru - potongan;

                                    var subtotal_penjualan = bersihPemisah(bersihPemisah(bersihPemisah(bersihPemisah($("#total2").val()))));

                                    //cari jumlah pajak sebelumnya
                                    var cari_tax = parseInt(subtotal_lama,10) - parseInt(tax,10);
                                    var cari_tax1 = parseInt(subtotal_lama,10) / parseInt(cari_tax,10);
                                    //end cari jumlah pajak sebelumnya

                                    //pajaknya
                                    var tax_ex = cari_tax1.toFixed(2);//ambil 2 angka dibelakang koma

                                    var subtotal = subtotal1;

                                    var tax_ex1 = parseInt(subtotal,10) / tax_ex;
                                    var tax_ex2 = parseInt(subtotal,10) - parseInt(Math.round(tax_ex1));
                                    var jumlah_tax = Math.round(tax_ex2);
                                    

                                       var subtotal_penjualan = subtotal_penjualan - subtotal_lama + subtotal;

                                    }
   
    if (pot_fakt_per == 0) {
      var potongaaan = pot_fakt_rp;

      var potongaaan_per = parseInt(potongaaan,10) / parseInt(subtotal_penjualan,10) * 100;
      var potongaaan = pot_fakt_rp;
      /*
      var hitung_tax = parseInt(subtotal_penjualan,10) - parseInt(pot_fakt_rp,10);
      var tax_bener = parseInt(hitung_tax,10) * parseInt(tax_faktur,10) / 100;*/

      var total_akhir = parseInt(subtotal_penjualan,10) - parseInt(pot_fakt_rp,10) + parseInt(biaya_adm,10);/* + parseInt(Math.round(tax_bener,10));*/


    }
    else if(pot_fakt_rp == 0)
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

     var total_akhir = parseInt(subtotal_penjualan,10) - parseInt(potongaaan,10) + parseInt(biaya_adm,10);/* + parseInt(Math.round(tax_bener,10));*/

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

      var total_akhir = parseInt(subtotal_penjualan,10) - parseInt(potongaaan,10) + parseInt(biaya_adm,10);/* + parseInt(Math.round(tax_bener,10));*/

    
    }

                

                                    if (jumlah_baru == 0) {
                                      alert ("Jumlah Barang Tidak Boleh 0!");

                                      $("#input-jumlah-"+id+"").val(jumlah_lama);
                                       $("#text-jumlah-"+id+"").text(jumlah_lama);
                                       $("#text-jumlah-"+id+"").show();
                                       $("#input-jumlah-"+id+"").attr("type", "hidden");
                                    }
                                    else if (tipe == 'Jasa') 
                                    {

                                           $.post("update_pesanan_barang.php",{jumlah_lama:jumlah_lama,jumlah_tax:jumlah_tax,id:id,jumlah_baru:jumlah_baru,kode_barang:kode_barang, potongan:potongan,harga:harga,subtotal:subtotal},function(info){
  
                                              $("#text-jumlah-"+id+"").show();
                                              $("#text-jumlah-"+id+"").text(jumlah_baru);
                                              $("#text-subtotal-"+id+"").text(tandaPemisahTitik(subtotal));
                                              $("#btn-hapus-"+id+"").attr("data-subtotal",subtotal);
                                              $("#text-tax-"+id+"").text(jumlah_tax);
                                              $("#input-jumlah-"+id+"").attr("type", "hidden"); 
                                              $("#total2").val(tandaPemisahTitik(subtotal_penjualan));  
                                              $("#total1").val(tandaPemisahTitik(total_akhir));      
                                              $("#potongan_penjualan").val(Math.round(potongaaan));
                                              $("#potongan_persen").val(Math.round(potongaaan_per));
                                              /*
                                               $("#tax_rp").val(Math.round(tax_bener));*/


                                          });

                                    }

                                    else{

                                                $.post("cek_stok_edit_penjualan.php",{kode_barang:kode_barang, jumlah_baru:jumlah_baru,satuan_konversi:satuan_konversi,no_faktur:no_faktur},function(data){
                                                 if (data < 0) {

                                                 alert ("Jumlah Yang Di Masukan Melebihi Stok !");

                                                 $("#input-jumlah-"+id+"").val(jumlah_lama);
                                                 $("#text-jumlah-"+id+"").text(jumlah_lama);
                                                 $("#text-jumlah-"+id+"").show();
                                                 $("#input-jumlah-"+id+"").attr("type", "hidden");

                                               }
                                               else
                                               {
                                                     $.post("update_pesanan_barang.php",{jumlah_lama:jumlah_lama,jumlah_tax:jumlah_tax,id:id,jumlah_baru:jumlah_baru,kode_barang:kode_barang, potongan:potongan,harga:harga,subtotal:subtotal},function(info){
      
                                                  $("#text-jumlah-"+id+"").show();
                                                  $("#text-jumlah-"+id+"").text(jumlah_baru);
                                                  $("#text-subtotal-"+id+"").text(tandaPemisahTitik(subtotal));
                                                  $("#btn-hapus-"+id+"").attr("data-subtotal",subtotal);
                                                  $("#text-tax-"+id+"").text(tandaPemisahTitik(jumlah_tax));
                                                  $("#input-jumlah-"+id+"").attr("type", "hidden"); 
                                                  $("#total2").val(tandaPemisahTitik(subtotal_penjualan));  
                                                  $("#total1").val(tandaPemisahTitik(total_akhir));      
                                                  $("#potongan_penjualan").val(Math.round(potongaaan));
                                                  $("#potongan_persen").val(Math.round(potongaaan_per));
                                                  /*$("#tax_rp").val(Math.round(tax_bener));*/

                                          });
                                               }

       
                                        });

                                    }

                                  


       
                                    $("#kode_barang").trigger('chosen:open');

                                 });

                             </script>

       <script type="text/javascript">
       
//fungsi hapus data 
     $(document).on('click','.btn-hapus-tbs',function(){

    var nama_barang = $(this).attr("data-barang");
    var id = $(this).attr("data-id");
    var kode_barang = $(this).attr("data-kode-barang");
    var subtotal = $(this).attr("data-subtotal");

    var biaya_adm = bersihPemisah(bersihPemisah(bersihPemisah(bersihPemisah($("#biaya_adm").val()))));
    if (biaya_adm == '') {
      biaya_adm = 0;
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

   if (pot_fakt_per == 0) {
      var potongaaan = pot_fakt_rp;

      var potongaaan_per = parseInt(potongaaan,10) / parseInt(total_akhir1,10) * 100;
      var potongaaan = pot_fakt_rp;
      /*
      var hitung_tax = parseInt(total_akhir1,10) - parseInt(pot_fakt_rp,10);
      var tax_bener = parseInt(hitung_tax,10) * parseInt(tax_faktur,10) / 100;*/

      var total_akhir = parseInt(total_akhir1,10) - parseInt(pot_fakt_rp,10) + parseInt(biaya_adm,10);/* + parseInt(Math.round(tax_bener,10));*/


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

     var total_akhir = parseInt(total_akhir1,10) - parseInt(potongaaan,10) + parseInt(biaya_adm,10);/* + parseInt(Math.round(tax_bener,10));*/

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
      var tax_bener = parseInt(hitung_tax,10) * parseInt(tax_faktur,10) / 100;*/

      var total_akhir = parseInt(total_akhir1,10) - parseInt(potongaaan,10) + parseInt(biaya_adm,10);/* + parseInt(Math.round(tax_bener,10));*/

    
    }

    

    $("#total2").val(tandaPemisahTitik(total_akhir1));  
    $("#total1").val(tandaPemisahTitik(total_akhir));      
    $("#potongan_penjualan").val(Math.round(potongaaan));
        if (total_akhir1 == 0)
    {
          $("#potongan_persen").val('0');
          $("#ppn").attr("disabled", false);
    }
    else
    {
        $("#potongan_persen").val(Math.round(potongaaan_per));
    }
   /* $("#tax_rp").val(Math.round(tax_bener));*/
    $("#pembayaran_penjualan").val('');
    $("#kode_barang").trigger('chosen:open');

    $(".tr-id-"+id+"").remove();
    $.post("hapus_pesanan_barang.php",{id:id,kode_barang:kode_barang},function(data){
    


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

<script type="text/javascript">


//menampilkan no urut faktur setelah tombol click di pilih
      $("#cari_produk_penjualan").click(function() {

      
   
      //menyembunyikan notif berhasil
      $("#alert_berhasil").hide();
      
      var no_faktur = $("#no_faktur0").val();
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

        var no_faktur = $("#nomor_faktur_penjualan").val();
        var sisa_pembayaran = bersihPemisah(bersihPemisah(bersihPemisah(bersihPemisah( $("#sisa_pembayaran_penjualan").val() ))));
        var kredit = bersihPemisah(bersihPemisah(bersihPemisah(bersihPemisah( $("#kredit").val() )))); 
        var no_rm = $("#no_rm").val();
        var no_rm = no_rm.substr(0, no_rm.indexOf('('));
        var no_reg = $("#no_reg").val();
        var tanggal_jt = $("#tanggal_jt").val();
        var total = bersihPemisah(bersihPemisah(bersihPemisah(bersihPemisah( $("#total1").val() )))); 
        var total2 = bersihPemisah(bersihPemisah(bersihPemisah(bersihPemisah( $("#total2").val() )))); 
        var potongan_jual =  bersihPemisah(bersihPemisah(bersihPemisah(bersihPemisah( $("#potongan_penjualan").val() ))));
        var potongan = Math.round(potongan_jual);
        var potongan_persen = $("#potongan_persen").val();
        /* var tax = $("#tax_rp").val();*/
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
        var petugas_kasir = $("#id_user").val();   
        var petugas_paramedik = $("#petugas_paramedik").val();
        var petugas_farmasi = $("#petugas_farmasi").val();
        var petugas_lain = $("#petugas_lain").val();
        var keterangan = $("#keterangan").val();   
        var ber_stok = $("#ber_stok").val();   
        var ppn_input = $("#ppn_input").val();
        var ppn = $("#ppn").val();
        var penjamin = $("#penjamin").val();
        var nama_pasien = $("#nama_pasien").val();
        var jenis_penjualan = 'Rawat Jalan';
        var tanggal = $("#tanggal_tmpl").val();  
        var jam = $("#jam").val();  

        var sisa = pembayaran - total;
        
        var sisa_kredit = total - pembayaran;

 
 if (sisa_pembayaran < 0)
 {

  alert("Jumlah Pembayaran Tidak Mencukupi");

 }


 else if (no_rm == "") 
 {

alert("No RM Harus Di Isi");
$("#no_rm").focus()

 }
else if (pembayaran == "") 
 {

alert("Pembayaran Harus Di Isi");
$("#pembayaran_penjualan").focus()

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

 $.post("cek_simpan_subtotal_penjualan.php",{total:total,no_reg:no_reg,no_faktur:no_faktur/*,tax:tax*/,potongan:potongan,biaya_adm:biaya_adm},function(data) {

  if (data == 1) {
            
 $.post("proses_bayar_edit_jual_raja.php",{no_faktur:no_faktur,sisa_pembayaran:sisa_pembayaran, kredit:kredit,no_rm:no_rm,no_reg:no_reg,tanggal_jt:tanggal_jt,total:total,total2:total2,potongan:potongan,potongan_persen:potongan_persen,/*/tax:tax,/*/cara_bayar:cara_bayar,pembayaran:pembayaran,total_hpp:total_hpp,harga:harga,kode_gudang:kode_gudang,dokter:dokter,petugas_kasir:petugas_kasir,petugas_paramedik:petugas_paramedik,petugas_farmasi:petugas_farmasi,petugas_lain:petugas_lain,keterangan:keterangan,ber_stok:ber_stok,ppn_input:ppn_input,sisa:sisa,ppn:ppn,penjamin:penjamin,nama_pasien:nama_pasien,jenis_penjualan:jenis_penjualan,biaya_adm:biaya_adm,sisa_kredit:sisa_kredit,tanggal:tanggal,jam:jam},function(info) {

if (info == 1)
{
   alert("Maaf Subtotal Penjualan Tidak Sesuai, Silakan Tunggu Sebentar! (2) "); 
        window.location.href="form_edit_penjualan_rj.php?no_reg="+no_reg+"&no_rm="+no_rm+"&kode_gudang="+kode_gudang+"&nama_pasien="+nama_pasien+"&no_faktur="+no_faktur+"";
}
 else
 { 

      $("#demo").html(info);

     var no_faktur = info;
     $("#cetak_tunai").attr('href', 'cetak_penjualan_tunai.php?no_faktur='+no_faktur+'');
     $("#cetak_tunai_besar").attr('href', 'cetak_penjualan_tunai_besar.php?no_faktur='+no_faktur+'');
     $("#cetak_tunai_kategori").attr('href','cetak_penjualan_tunai_kategori.php?no_faktur='+no_faktur+'');
     $("#table-baru").html(info);
     $("#alert_berhasil").show();
     $("#pembayaran_penjualan").val('');
     $("#sisa_pembayaran_penjualan").val('');
     $("#kredit").val('');

      $("#transaksi_baru").show();
      $("#cetak_langsung").hide();
      $("#cetak_tunai").show();
      $("#cetak_tunai_besar").show();
      $("#cetak_tunai_kategori").show();
      $("#penjualan").hide();
      $("#piutang").hide();
     
                 var win = window.open('cetak_penjualan_tunai.php?no_faktur='+no_faktur+'');
               if (win) { 
              
              win.focus(); 
               } else { 
              
              alert('Mohon Izinkan PopUps Pada Website Ini !'); }   

}
       
   });

}
  else{
    alert("Maaf Subtotal Penjualan Tidak Sesuai, Silakan Tunggu Sebentar! (1) "); 
        window.location.href="form_edit_penjualan_rj.php?no_reg="+no_reg+"&no_rm="+no_rm+"&kode_gudang="+kode_gudang+"&nama_pasien="+nama_pasien+"&no_faktur="+no_faktur+"";
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
  $("#penjualan").click(function(){

        var no_faktur = $("#nomor_faktur_penjualan").val();
        var sisa_pembayaran = bersihPemisah(bersihPemisah(bersihPemisah(bersihPemisah( $("#sisa_pembayaran_penjualan").val() ))));
        var kredit = bersihPemisah(bersihPemisah(bersihPemisah(bersihPemisah( $("#kredit").val() )))); 
        var no_rm = $("#no_rm").val();
        var no_rm = no_rm.substr(0, no_rm.indexOf('('));
        var no_reg = $("#no_reg").val();
        var tanggal_jt = $("#tanggal_jt").val();
        var total = bersihPemisah(bersihPemisah(bersihPemisah(bersihPemisah( $("#total1").val() )))); 
        var total2 = bersihPemisah(bersihPemisah(bersihPemisah(bersihPemisah( $("#total2").val() )))); 
        var potongan_jual =  bersihPemisah(bersihPemisah(bersihPemisah(bersihPemisah( $("#potongan_penjualan").val() ))));
        var potongan = Math.round(potongan_jual);
        var potongan_persen = $("#potongan_persen").val();
        /* var tax = $("#tax_rp").val();*/
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
        var petugas_kasir = $("#id_user").val();   
        var petugas_paramedik = $("#petugas_paramedik").val();
        var petugas_farmasi = $("#petugas_farmasi").val();
        var petugas_lain = $("#petugas_lain").val();
        var keterangan = $("#keterangan").val();   
        var ber_stok = $("#ber_stok").val();   
        var ppn_input = $("#ppn_input").val();
        var ppn = $("#ppn").val();
        var penjamin = $("#penjamin").val();
        var nama_pasien = $("#nama_pasien").val();
        var tanggal = $("#tanggal_tmpl").val();
        var jam = $("#jam").val();
        var jenis_penjualan = 'Rawat Jalan';
        
        var sisa = pembayaran - total;
        
        var sisa_kredit = total - pembayaran;

 
 if (sisa_pembayaran < 0)
 {

  alert("Jumlah Pembayaran Tidak Mencukupi");

 }


 else if (no_rm == "") 
 {

alert("No RM Harus Di Isi");
$("#no_rm").focus()

 }
else if (pembayaran == "") 
 {

alert("Pembayaran Harus Di Isi");
$("#pembayaran_penjualan").focus()

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

 $.post("cek_simpan_subtotal_penjualan.php",{total:total,no_reg:no_reg,no_faktur:no_faktur/*,tax:tax*/,potongan:potongan,biaya_adm:biaya_adm},function(data) {

  if (data == 1) {

            
 $.post("proses_bayar_edit_jual_raja.php",{no_faktur:no_faktur,sisa_pembayaran:sisa_pembayaran, kredit:kredit,no_rm:no_rm,no_reg:no_reg,tanggal_jt:tanggal_jt,total:total,total2:total2,potongan:potongan,potongan_persen:potongan_persen,/*/tax:tax,/*/cara_bayar:cara_bayar,pembayaran:pembayaran,total_hpp:total_hpp,harga:harga,kode_gudang:kode_gudang,dokter:dokter,petugas_kasir:petugas_kasir,petugas_paramedik:petugas_paramedik,petugas_farmasi:petugas_farmasi,petugas_lain:petugas_lain,keterangan:keterangan,ber_stok:ber_stok,ppn_input:ppn_input,sisa:sisa,ppn:ppn,penjamin:penjamin,nama_pasien:nama_pasien,jenis_penjualan:jenis_penjualan,biaya_adm:biaya_adm,sisa_kredit:sisa_kredit,tanggal:tanggal,jam:jam},function(info) {

if (info == 1)
{

        alert("Maaf Subtotal Penjualan Tidak Sesuai, Silakan Tunggu Sebentar! (2) "); 
        window.location.href="form_edit_penjualan_rj.php?no_reg="+no_reg+"&no_rm="+no_rm+"&kode_gudang="+kode_gudang+"&nama_pasien="+nama_pasien+"&no_faktur="+no_faktur+"";

}

else {
            
  $("#demo").html(info);

     var no_faktur = info;
     $("#cetak_tunai").attr('href', 'cetak_penjualan_tunai.php?no_faktur='+no_faktur+'');
     $("#cetak_tunai_besar").attr('href', 'cetak_penjualan_tunai_besar.php?no_faktur='+no_faktur+'');
     $("#cetak_tunai_kategori").attr('href','cetak_penjualan_tunai_kategori.php?no_faktur='+no_faktur+'');
     $("#table-baru").html(info);
     $("#alert_berhasil").show();
     $("#pembayaran_penjualan").val('');
     $("#sisa_pembayaran_penjualan").val('');
     $("#kredit").val('');
     $("#transaksi_baru").show();
     
      $("#cetak_langsung").hide();
      $("#cetak_tunai").show();
      $("#cetak_tunai_besar").show();
      $("#cetak_tunai_kategori").show();
      $("#penjualan").hide();
      $("#piutang").hide();
}
       
   });

}
  else{
    alert("Maaf Subtotal Penjualan Tidak Sesuai, Silakan Tunggu Sebentar! (1) "); 
        window.location.href="form_edit_penjualan_rj.php?no_reg="+no_reg+"&no_rm="+no_rm+"&kode_gudang="+kode_gudang+"&nama_pasien="+nama_pasien+"&no_faktur="+no_faktur+"";
  }

 });

 }

 $("form").submit(function(){
    return false;
 
});

});
  
  </script>
  

<!--<script type="text/javascript">
  $(document).ready(function(){
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
      /*/
      var tax = bersihPemisah(bersihPemisah(bersihPemisah(bersihPemisah($("#tax").val()))));
      if (tax == '') {
        tax = 0;
      }/*/

      var t_total = parseInt(subtotal,10) - parseInt(potongan,10);

      /*/
      var t_tax = parseInt(t_total,10) * parseInt(tax,10) / 100;
      /*/

      var total_akhir1 = t_total;// + Math.round(parseInt(t_tax,10));//

      var total_akhir = parseInt(total_akhir1,10) + parseInt(biaya_adm,10);
      $("#total1").val(tandaPemisahTitik(total_akhir));


    });
  });
  
</script>-->



<script type="text/javascript">
$(document).ready(function(){
  //Hitung Biaya Admin

  
  var biaya_admin = $("#biaya_admin_select").val();
  var total1 = bersihPemisah(bersihPemisah(bersihPemisah(bersihPemisah($("#total1").val()))));
  var diskon = bersihPemisah(bersihPemisah(bersihPemisah(bersihPemisah($("#potongan_penjualan").val()))));

  var no_faktur = $("#nomor_faktur_penjualan").val();
  var no_reg = $("#no_reg").val();

  if(diskon == '')
      {
      diskon = 0
      }

        $.post("cek_total_bayar_pesanan_barang.php",
        {
        no_faktur: no_faktur,no_reg:no_reg
        },
        function(data){
          data = data.replace(/\s+/g, '');

          if (biaya_admin == "" || biaya_admin == 0) {
          var data_admin = '<?php echo $biaya_admin; ?>';
          }
          else{
            var data_admin = biaya_admin;
          }
          
          if (data_admin == 0) {
          var hasilnya = parseInt(data,10) - parseInt(diskon,10);
          $("#total1").val(tandaPemisahTitik(hasilnya));          
          $("#biaya_adm").val(0);
          $("#biaya_admin_persen").val(0);
          
          }
          else if (data_admin > 0) {
          
          var hitung_biaya = parseInt(data,10) * parseInt(data_admin,10) / 100;          
          var hasilnya = parseInt(data,10) + parseInt(hitung_biaya,10) - parseInt(diskon,10);
          
          $("#total1").val(tandaPemisahTitik(hasilnya));
          $("#biaya_adm").val(hitung_biaya);
          $("#biaya_admin_persen").val(data_admin);
          
          
          
          }

        });


});
//end Hitu8ng Biaya Admin
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
      
      $("#biaya_adm").val(Math.round(hitung_biaya));
      var biaya_admin = bersihPemisah(bersihPemisah(bersihPemisah(bersihPemisah($("#biaya_adm").val()))));      
      var hasilnya = parseInt(total2,10) + parseInt(biaya_admin,10) - parseInt(diskon,10);
      
      $("#total1").val(tandaPemisahTitik(hasilnya));
      $("#biaya_admin_persen").val(data_admin);
      


  }
      
    });
});
//end Hitu8ng Biaya Admin
</script>


<script type="text/javascript">
  $(document).ready(function(){
    $("#biaya_admin_persen").keyup(function(){
      var biaya_adm = bersihPemisah(bersihPemisah(bersihPemisah(bersihPemisah($("#biaya_admin_persen").val()))));
      var biaya_admin_rp = bersihPemisah(bersihPemisah(bersihPemisah(bersihPemisah($("#biaya_adm").val()))));
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
      /*/
      var tax = bersihPemisah(bersihPemisah(bersihPemisah(bersihPemisah($("#tax").val()))));
      if (tax == '') {
        tax = 0;
      }/*/

      if (biaya_adm > 100) {

      var t_total = parseInt(subtotal,10) - parseInt(potongan,10);

        alert ("Biaya Admin Tidak Boleh Lebih Dari 100% !");
         $("#biaya_admin_persen").val('');
         $("#biaya_adm").val('');
         $("#total1").val(tandaPemisahTitik(t_total));

      }
      else{


      var t_total = parseInt(subtotal,10) - parseInt(potongan,10);
      var data_admin = parseInt(t_total,10) * parseInt(biaya_adm,10) / 100;

      /*/
      var t_tax = parseInt(t_total,10) * parseInt(tax,10) / 100;
      /*/

      var total_akhir1 = t_total;// + Math.round(parseInt(t_tax,10));//

      var total_akhir = parseInt(total_akhir1,10) + parseInt(data_admin,10);
      $("#total1").val(tandaPemisahTitik(total_akhir));
      $("#biaya_adm").val(data_admin);

      }


    });
  });
  
</script>



 <script>
   //perintah javascript yang diambil dari form proses_bayar_beli.php dengan id=form_beli
  $("#piutang").click(function(){

        var no_faktur = $("#nomor_faktur_penjualan").val();
        var sisa_pembayaran = bersihPemisah(bersihPemisah(bersihPemisah(bersihPemisah( $("#sisa_pembayaran_penjualan").val() ))));
        var kredit = bersihPemisah(bersihPemisah(bersihPemisah(bersihPemisah( $("#kredit").val() )))); 
        var no_rm = $("#no_rm").val();
        var no_rm = no_rm.substr(0, no_rm.indexOf('('));
        var no_reg = $("#no_reg").val();
        var tanggal_jt = $("#tanggal_jt").val();
        var total = bersihPemisah(bersihPemisah(bersihPemisah(bersihPemisah( $("#total1").val() )))); 
        var total2 = bersihPemisah(bersihPemisah(bersihPemisah(bersihPemisah( $("#total2").val() )))); 
        var potongan_jual =  bersihPemisah(bersihPemisah(bersihPemisah(bersihPemisah( $("#potongan_penjualan").val() ))));
        var potongan = Math.round(potongan_jual);
        var potongan_persen = $("#potongan_persen").val();
        /*/
        var tax = $("#tax_rp").val();/*/
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
        if (pembayaran == '')
        {
          pembayaran = 0;
        }
        var penjamin = $("#penjamin").val();
        var nama_pasien = $("#nama_pasien").val();
        var jenis_penjualan = 'Rawat Jalan';
        var tanggal = $("#tanggal_tmpl").val();
        var jam = $("#jam").val();

        
        var sisa = pembayaran - total;
        
        var sisa_kredit = total - pembayaran;


     $("#pembayaran_penjualan").val('');
     $("#sisa_pembayaran_penjualan").val('');
     $("#kredit").val(sisa_kredit);



       
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


 $.post("cek_simpan_subtotal_penjualan.php",{total:total,no_reg:no_reg,no_faktur:no_faktur/*/,tax:tax/*/,potongan:potongan,biaya_adm:biaya_adm},function(data) {

  if (data == 1) {

  $("#penjualan").hide();
  $("#batal_penjualan").hide(); 
  $("#cetak_langsung").hide();
  $("#piutang").hide();
  $("#transaksi_baru").show();

 $.post("proses_bayar_edit_jual_raja.php",{no_faktur:no_faktur,sisa_pembayaran:sisa_pembayaran, kredit:kredit,no_rm:no_rm,no_reg:no_reg,tanggal_jt:tanggal_jt,total:total,total2:total2,potongan:potongan,potongan_persen:potongan_persen,/*/tax:tax,/*/cara_bayar:cara_bayar,pembayaran:pembayaran,total_hpp:total_hpp,harga:harga,kode_gudang:kode_gudang,dokter:dokter,petugas_kasir:petugas_kasir,petugas_paramedik:petugas_paramedik,petugas_farmasi:petugas_farmasi,petugas_lain:petugas_lain,keterangan:keterangan,ber_stok:ber_stok,ppn_input:ppn_input,sisa:sisa,ppn:ppn,penjamin:penjamin,nama_pasien:nama_pasien,jenis_penjualan:jenis_penjualan,biaya_adm:biaya_adm,sisa_kredit:sisa_kredit,tanggal:tanggal,jam:jam},function(info) {

if (info == 1)
{

alert("Maaf Subtotal Penjualan Tidak Sesuai, Silakan Tunggu Sebentar! (2) ");       
       window.location.href="form_edit_penjualan_rj.php?no_reg="+no_reg+"&no_rm="+no_rm+"&kode_gudang="+kode_gudang+"&nama_pasien="+nama_pasien+"&no_faktur="+no_faktur+"";

}
else
{


            $("#demo").html(info);
            var no_faktur = info;
            $("#cetak_piutang").attr('href', 'cetak_penjualan_piutang.php?no_faktur='+no_faktur+'');
            $("#table-baru").html(info);
            $("#alert_berhasil").show();
            $("#pembayaran_penjualan").val('');
            $("#sisa_pembayaran_penjualan").val('');
            $("#potongan_penjualan").val('');
            $("#potongan_persen").val('');
            $("#tanggal_jt").val('');
            $("#cetak_piutang").show();
            $("#tax").val('');
            
             $("#penjualan").hide();
            $("#batal_penjualan").hide(); 
            $("#cetak_langsung").hide();
            $("#piutang").hide();
            $("#transaksi_baru").show();

}
       
   });


}
  else{
    alert("Maaf Subtotal Penjualan Tidak Sesuai, Silakan Tunggu Sebentar! (1) ");       
       window.location.href="form_edit_penjualan_rj.php?no_reg="+no_reg+"&no_rm="+no_rm+"&kode_gudang="+kode_gudang+"&nama_pasien="+nama_pasien+"&no_faktur="+no_faktur+"";
  }



 });


 }

 $("form").submit(function(){
    return false;
 
});

});

  </script>   

<script type="text/javascript">
$(document).ready(function(){
  $("#batal_penjualan").click(function(){
    var no_reg = $("#no_reg").val()
        window.location.href="batal_penjualan_edit_raja.php?no_reg="+no_reg+"";

  })
  });
</script>


  <script type="text/javascript">
  $(document).ready(function() {

        var no_faktur = $("#nomor_faktur_penjualan").val();
        var no_reg = $("#no_reg").val();

        $.post("cek_total_bayar_pesanan_barang.php",
        {
        no_faktur: no_faktur,no_reg:no_reg
        },
        function(data){
          data = data.replace(/\s+/g, '');
        $("#total2").val(data);

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
        
        $("#potongan_persen").keyup(function(){

        var potongan_persen = $("#potongan_persen").val();
         var biaya_adm = bersihPemisah(bersihPemisah(bersihPemisah(bersihPemisah($("#biaya_adm").val()))));
        if (biaya_adm == '') {
          biaya_adm = 0;
        }
        var total = bersihPemisah(bersihPemisah(bersihPemisah(bersihPemisah( $("#total2").val() ))));
        var total1 = bersihPemisah(bersihPemisah(bersihPemisah(bersihPemisah( $("#total1").val() ))));
        var potongan_penjualan = ((total * potongan_persen) / 100);
       /*/ var tax = $("#tax").val();

        if (tax == "") {
        tax = 0;
      }/*/

      
        var sisa_potongan = total - Math.round(potongan_penjualan);


             //var t_tax = ((parseInt(sisa_potongan,10) * parseInt(tax,10)) / 100);//

             var hasil_akhir = parseInt(sisa_potongan, 10) +/*/ parseInt(Math.round(t_tax,10)) + /*/parseInt(biaya_adm,10);

        
        if (potongan_persen > 100) 
        {
          alert ("Potongan %, Tidak Boleh Lebih Dari 100%");
          $("#potongan_persen").val('');
           $("#potongan_penjualan").val('');
           $("#total1").val(tandaPemisahTitik(total1));

        }
        else{
         $("#total1").val(Math.round(hasil_akhir));
        $("#potongan_penjualan").val(tandaPemisahTitik(Math.round(potongan_penjualan)));
        }

        /*/
        $("#tax_rp").val(Math.round(t_tax))/*/


      });

        $("#potongan_penjualan").keyup(function(){

        var potongan_penjualan =  bersihPemisah(bersihPemisah(bersihPemisah(bersihPemisah( $("#potongan_penjualan").val() ))));
        var biaya_adm = bersihPemisah(bersihPemisah(bersihPemisah(bersihPemisah($("#biaya_adm").val()))));
        if (biaya_adm == '') {
          biaya_adm = 0;
        }

        var total1 = bersihPemisah(bersihPemisah(bersihPemisah(bersihPemisah( $("#total1").val() ))));
        var total = bersihPemisah(bersihPemisah(bersihPemisah(bersihPemisah($("#total2").val()))));
        var potongan_persen = ((potongan_penjualan / total) * 100);
        /*/var tax = $("#tax").val();

        if (tax == "") {
        tax = 0;
      }/*/


        var sisa_potongan = total - Math.round(potongan_penjualan);
        
             //var t_tax = ((parseInt(sisa_potongan,10) * parseInt(tax,10)) / 100);//

             var hasil_akhir = parseInt(sisa_potongan, 10) + /*/parseInt(Math.round(t_tax,10)) +/*/ parseInt(biaya_adm,10);

         if (potongan_persen > 100) {
        alert ("Potongan %, Tidak Boleh Lebih Dari 100%");
          $("#potongan_persen").val('');
           $("#potongan_penjualan").val('');
           $("#total1").val(tandaPemisahTitik(total1));
         }    
        else
        {
        $("#total1").val(Math.round(hasil_akhir));
        $("#potongan_persen").val(Math.round(potongan_persen));

        }

         //$("#tax_rp").val(Math.round(t_tax))//
      });
        

         $("#tax1").keyup(function(){
          var tax = $(this).val();
          if (tax > 100) {
            alert("Pajak tidak boleh dari 100 %");
            $(this).val('');
            $(this).focus();
            
          }

         });

  /*      $("#tax").keyup(function(){

        var potongan = bersihPemisah(bersihPemisah(bersihPemisah(bersihPemisah($("#potongan_penjualan").val() ))));
        var potongan_persen = $("#potongan_persen").val();
        var biaya_adm = bersihPemisah(bersihPemisah(bersihPemisah(bersihPemisah($("#biaya_adm").val()))));
        if (biaya_adm == '') {
          biaya_adm = 0;
        }
        var total1 = bersihPemisah(bersihPemisah(bersihPemisah(bersihPemisah( $("#total1").val() ))));
        var total = bersihPemisah(bersihPemisah(bersihPemisah(bersihPemisah($("#total2").val() ))));
       
              var cara_bayar = $("#carabayar1").val();
              var tax = $("#tax").val();
              var t_total = total - Math.round(potongan);

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

              var total_akhir = parseInt(bersihPemisah(bersihPemisah(bersihPemisah(bersihPemisah(t_total,10))))) + Math.round(parseInt(t_tax,10)) + parseInt(biaya_adm,10);
              
              
              

              if (tax > 100) {
                alert ('Jumlah Tax Tidak Boleh Lebih Dari 100%');
                 $("#tax").val('');
                 $("#total1").val(tandaPemisahTitik(total));

              }
              else
              {
                $("#total1").val(Math.round(total_akhir));
              }
        

       $("#tax_rp").val(Math.round(t_tax))


        });*/


        });
        
        </script>

      <script type="text/javascript">
        
      $(".chosen").chosen({no_results_text: "Maaf, Data Tidak Ada!"});  
      
      </script>


<!--<script type="text/javascript">
  
        $(document).ready(function(){
        $("#kode_barang").blur(function(){

          var no_faktur = $("#nomor_faktur_penjualan").val();
          var kode_barang = $(this).val();
          
          var level_harga = $("#level_harga").val();
          
       $.post('cek_kode_barang_edit_tbs_penjualan.php',{kode_barang:kode_barang,no_faktur:no_faktur}, function(data){
          
          if(data == 1){
          alert("Anda Tidak Bisa Menambahkan Barang Yang Sudah Ada, Silakan Edit atau Pilih Barang Yang Lain");
          $("#kode_barang").val('');
          $("#nama_barang").val('');
          $("#kode_barang").trigger('chosen:open');
          }//penutup if
  
else {          
        
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
        }
        else if (level_harga == "harga_2") {

        $('#harga_produk').val(json.harga_jual2);
        $('#harga_baru').val(json.harga_jual2);
        $('#harga_lama').val(json.harga_jual2);
        }
        else if (level_harga == "harga_3") {

        $('#harga_produk').val(json.harga_jual3);
        $('#harga_baru').val(json.harga_jual3);
        $('#harga_lama').val(json.harga_jual3);
        }
        else if (level_harga == "harga_4") {

        $('#harga_produk').val(json.harga_jual4);
        $('#harga_baru').val(json.harga_jual4);
        $('#harga_lama').val(json.harga_jual4);
        }
        else if (level_harga == "harga_5") {

        $('#harga_produk').val(json.harga_jual5);
        $('#harga_baru').val(json.harga_jual5);
        $('#harga_lama').val(json.harga_jual5);
        }
        else if (level_harga == "harga_6") {

        $('#harga_produk').val(json.harga_jual6);
        $('#harga_baru').val(json.harga_jual6);
        $('#harga_lama').val(json.harga_jual6);
        }
        else if (level_harga == "harga_7") {

        $('#harga_produk').val(json.harga_jual7);
        $('#harga_baru').val(json.harga_jual7);
        $('#harga_lama').val(json.harga_jual7);
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

}//else cek data barang 

   });////penutup function(data)  


        });
 });   
</script>-->


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
    var tipe_barang = $('#opt-produk-'+kode_barang).attr("tipe_barang");
    var id_barang = $('#opt-produk-'+kode_barang).attr("id-barang");
    var level_harga = $("#level_harga").val();
    var no_reg = $("#no_reg").val();
     var no_faktur = $("#nomor_faktur_penjualan").val();



    if (level_harga == "harga_1") {

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



    $("#kode_barang").val(kode_barang);
    $("#nama_barang").val(nama_barang);
    $("#jumlah_barang").val(jumlah_barang);
    $("#satuan_produk").val(satuan);
    $("#satuan_konversi").val(satuan);
    $("#limit_stok").val(limit_stok);
    $("#ber_stok").val(ber_stok);
    $("#id_produk").val(id_barang);


    $.post('ambil_jumlah_produk.php',{kode_barang:kode_barang}, function(data){
      if (data == "") {
        data = 0;
      }
      $("#jumlahbarang").val(data);
    });

$.post('cek_kode_barang_edit_tbs_penjualan.php',{kode_barang:kode_barang,no_faktur:no_faktur}, function(data){
          
          if(data == 1){
          alert("Anda Tidak Bisa Menambahkan Barang Yang Sudah Ada, Silakan Edit atau Pilih Barang Yang Lain");
          $("#kode_barang").val('');
          $("#nama_barang").val('');
          $("#kode_barang").trigger('chosen:open');
          }//penutup if
     


  });
  });
  });

    
      
</script>


<script type="text/javascript">
 
$(".btn-alert-hapus").click(function(){
     var no_faktur = $(this).attr("data-faktur");
    var kode_barang = $(this).attr("data-kode");    
 
    $("#modal_alert").modal('show');

    $.post('alert_edit_penjualan.php',{no_faktur:no_faktur, kode_barang:kode_barang},function(data){

    $("#modal-alert").html(data); 

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
$(document).ready(function(){
  //end cek level harga
  $("#level_harga").change(function(){
  
  var level_harga = $("#level_harga").val();
  var kode_barang = $("#kode_barang").val();
  
  var satuan_konversi = $("#satuan_konversi").val();
  var jumlah_barang = bersihPemisah(bersihPemisah(bersihPemisah(bersihPemisah($("#jumlah_barang").val()))));;
  var level_hidden = $("#level_hidden").val();

  var id_produk = $("#id_produk").val();

  if (jumlah_barang == "") {
    alert ("Jumlah Barang Harus Diisi !");
    $("#level_harga").val(level_hidden);
  }
  else{
    $.post("cek_level_harga_barang.php", {level_harga:level_harga, kode_barang:kode_barang,jumlah_barang:jumlah_barang,id_produk:id_produk,satuan_konversi:satuan_konversi},function(data){

          $("#harga_produk").val(data);
          $("#harga_baru").val(data);
        });
  }


    });
});
//end cek level harga
</script>

<script type="text/javascript">
          $(document).ready(function(){
          var no_faktur = $("#nomor_faktur_penjualan").val();
          var no_reg = $("#no_reg").val();
        
        $.post("cek_total_bayar_pesanan_barang.php",
        {
        no_faktur: no_faktur,no_reg:no_reg
        },
        function(data){
          data = data.replace(/\s+/g, '');
        $("#total2").val(data);


        });

      });


</script>





<script type="text/javascript">
    $(document).ready(function(){
/*
      $("#tax").attr("disabled", true);*/



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
  
                                      $(".edit-jumlah-alert").dblclick(function(){

                                      var no_faktur = $(this).attr("data-faktur");
                                      var kode_barang = $(this).attr("data-kode");
                                      
                                      $.post('alert_edit_penjualan.php',{no_faktur:no_faktur, kode_barang:kode_barang},function(data){
                                      
                                        $("#modal_alert").modal('show');
                                        $("#modal-alert").html(data);
              
                                      });
                                    });
</script>





<script type="text/javascript">
$(document).ready(function(){ //UNTUK MENETUKAN APAKAH PPN NYA  INCLUDE ATAU EXCLUDE MAUPUN NON
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

    

    
    shortcut.add("ctrl+b", function() {
        // Do something


        window.location.href="batal_edit_penjualan_rj.php?no_faktur=<?php echo $no_faktur;?>";


    }); 

     shortcut.add("ctrl+k", function() {
        // Do something

        $("#cetak_langsung").click();


    }); 
</script>



<script type="text/javascript" language="javascript" >
   $(document).ready(function() {
        var dataTable = $('#tabel_cari').DataTable( {
          "processing": true,
          "serverSide": true,
          "ajax":{
            url :"modal_edit_penjualan.php", // json datasource
            "data": function ( d ) {
                d.no_faktur = $("#no_faktur0").val();
                // d.custom = $('#myInput').val();
                // etc
            },
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
              $(nRow).attr('harga_level_7f', aData[8]);
              $(nRow).attr('jumlah-barang', aData[9]);
              $(nRow).attr('satuan', aData[15]);
              $(nRow).attr('kategori', aData[11]);
              $(nRow).attr('status', aData[17]);
              $(nRow).attr('suplier', aData[12]);
              $(nRow).attr('limit_stok', aData[13]);
              $(nRow).attr('ber-stok', aData[14]);
              $(nRow).attr('tipe_barang', aData[16]);
              $(nRow).attr('id-barang', aData[18]);



          }

        });    
     
  });
 
 </script>

<!-- memasukan file footer.php -->
<?php include 'footer.php'; ?>