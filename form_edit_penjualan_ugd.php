<?php include_once 'session_login.php';
 

// memasukan file session login,  header, navbar, db.php,
include 'header.php';
include 'navbar.php';
include 'db.php';
include 'sanitasi.php';

 
// menampilkan seluruh data yang ada pada tabel penjualan yang terdapt pada DB

$pilih_akses_tombol = $db->query("SELECT * FROM otoritas_penjualan_ugd WHERE id_otoritas = '$_SESSION[otoritas_id]' ");
$otoritas_tombol = mysqli_fetch_array($pilih_akses_tombol);

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

//TOTAL TBS PENJUALAN
 $total = $db->query("SELECT SUM(subtotal) AS total_penjualan FROM tbs_penjualan WHERE  no_reg = '$no_reg' ");
 $data_total = mysqli_fetch_array($total);
  $subtotal = $data_total['total_penjualan'];    

 //TOTAL TBS PENJUALAN

// SELECT DATA PENJUALAN
$penjualan = $db->query("SELECT * FROM penjualan WHERE no_reg = '$no_reg'");
$data_penj = mysqli_fetch_array($penjualan);
// SELECT DATA PENJUALAN

// SELECT USER UNTUK KASIUR
$user = $db->query("SELECT nama FROM user WHERE id = '$data_penj[sales]'");
$out_user = mysqli_fetch_array($user);

// END SELECT USER KASIR

// SELECT DATA REGISTRASI
$registrasi = $db->query("SELECT * FROM registrasi WHERE no_reg = '$no_reg' ");
$data_reg = mysqli_fetch_array($registrasi);
// SELECT DATA REGISTRASI

$dokter = $db->query("SELECT id FROM user WHERE nama = '$data_reg[dokter]'");
$data_dokter = mysqli_fetch_array($dokter);
$id_dokter = $data_dokter['id'];


$level_harga = $db->query("SELECT harga FROM penjamin WHERE nama = '$data_reg[penjamin]' ");
$data_level = mysqli_fetch_array($level_harga);
$level_harga = $data_level['harga'];

$session_id = session_id();
$user = $_SESSION['nama'];
$id_user = $_SESSION['id'];


    $perintah = $db->query("SELECT tanggal, tunai, nilai_kredit, total,tax,potongan,biaya_admin,tunai FROM penjualan WHERE no_faktur = '$no_faktur' AND no_reg = '$no_reg'");
    $ambil_tanggal = mysqli_fetch_array($perintah);



    $perintah_detail = $db->query("SELECT SUM(subtotal) AS total_detail FROM detail_penjualan WHERE no_faktur = '$no_faktur' AND no_reg = '$no_reg'");
    $data_detail = mysqli_fetch_array($perintah_detail);

    $biaya_adm = ( $ambil_tanggal['biaya_admin'] / $data_detail['total_detail'] ) * 100;
    $biaya_admin = round($biaya_adm);

    $dp = $ambil_tanggal['tunai'];
    $nilai_kredit = $ambil_tanggal['nilai_kredit'];
    $total_akhir = $ambil_tanggal['total']; 
    $tax = $ambil_tanggal['tax']; 
    $potongan_p = $ambil_tanggal['potongan']; 
    $biaya_adm = $ambil_tanggal['biaya_admin']; 
    $pembayaran_awal = $ambil_tanggal['tunai'];


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

      $ses = $db->query("SELECT nama FROM user WHERE id = '$data_penj[dokter]'");
      $kel = mysqli_fetch_array($ses);

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
    $( "#tanggal_jt" ).datepicker({dateFormat: "yy-mm-dd"});
  });

    $(function() {
    $( "#tanggal" ).datepicker({dateFormat: "yy-mm-dd"});
  });
  </script>


<script type="text/javascript">
            $(document).ready(function() {
                $('.jam_cari').timepicker({
                    showPeriodLabels: false
                });
              });
</script>

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


<!--untuk membuat agar tampilan form terlihat rapih dalam satu tempat -->
 <div style="padding-left: 5%; padding-right: 5%">
  <h3> EDIT PENJUALAN UGD : <?php echo $no_faktur; ?></h3><hr>

<div class="row">

<div class="col-xs-8">

 <!-- membuat form menjadi beberpa bagian -->
  <form enctype="multipart/form-data" role="form" action="formpenjualan.php" method="post ">
        
  <!--membuat teks dengan ukuran h3-->      


        <div class="form-group">
        <input type="hidden" name="session_id" id="session_id" class="form-control" value="<?php echo session_id(); ?>" readonly="">
        </div>

          

<div class="row">



<div class="col-xs-2">
  
  <label> No. RM | Pasien </label><br>

  <input style="height:20px" type="text" class="form-control"  id="no_rm_tampil" name="no_rm" value="<?php echo $data_reg['no_rm']; ?> | <?php echo $data_reg['nama_pasien']; ?>" > 
  <input style="height:20px" type="hidden" class="form-control"  id="no_rm" name="no_rm" value="<?php echo $data_reg['no_rm']; ?>" > 
    <input style="height:20px" type="hidden" class="form-control"  id="nama_pasien" name="nama_pasien" value="<?php echo $data_reg['nama_pasien']; ?>" readonly="" > 

</div>
    



<div class="col-xs-2">
    <label>No. REG :</label>
    <input style="height:20px" type="text" class="form-control"  id="no_reg" name="no_reg" value="<?php echo $no_reg; ?>" readonly="">   

    <input style="height:20px; display: none" type="text" class="form-control"  id="no_faktur" name="no_faktur" value="<?php echo $no_faktur; ?>" readonly="">   
</div>



<div class="col-xs-2">
<label>Kasir</label>
<input style="height:20px; font-size:15px; display: none" type="text" class="form-control"  id="petugas_kasir" name="petugas_kasir" value="<?php echo $data_penj['sales']; ?>" readonly="">   
<input style="height:20px; font-size:15px; " type="text" class="form-control"  id="nama_kasir_tampil" name="nama_kasir_tampil" value="<?php echo $out_user['nama']; ?>" readonly="">   
</div>

<input style="height:20px;" type="hidden" class="form-control"  id="id_user" name="id_user" value="<?php echo $id_user; ?>" readonly="">  


<div class="col-xs-2">
          <label> Gudang </label><br>
          
          <select style="font-size:10px; height:35px" name="kode_gudang" id="kode_gudang" class="form-control chosen">
          <?php 
          
          // menampilkan seluruh data yang ada pada tabel suplier
          $query = $db->query("SELECT * FROM gudang");
          
          // menyimpan data sementara yang ada pada $query
          while($data = mysqli_fetch_array($query))
          {

            if ($data_penj['kode_gudang'] == $data['kode_gudang']) {

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
          <select style="font-size:15px; height:35px; " name="ppn" id="ppn" class="form-control">
          <option value="<?php echo $data_penj['ppn'] ?>"> <?php echo $data_penj['ppn']; ?> </option>
            <option value="Include">Include</option>  
            <option value="Exclude">Exclude</option>
            <option value="Non">Non</option>          
          </select>
</div>

<input style="height:17px" type="hidden" class="form-control"  id="id_dokter" name="id_dokter" value="<?php echo $id_dokter; ?>"readonly=""> 

<div class="col-xs-2">
<label>Petugas Paramedik</label><br>
<select style="font-size:15px; height:35px" name="petugas_paramedik" id="petugas_paramedik" class="form-control chosen" >

 <?php 
    
    //untuk menampilkan semua data pada tabel pelanggan dalam DB
    $query01 = $db->query("SELECT nama, id FROM user WHERE tipe = '2'");

    //untuk menyimpan data sementara yang ada pada $query
    while($data01 = mysqli_fetch_array($query01))
    {


    if ($data01['id'] == $data_penj['perawat']) {
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
      <label>Dokter Pelaksana</label><br>
      <select style="font-size:15px; height:35px" name="dokter" id="dokter" class="form-control chosen">
        <option value="<?php echo $data_penj['dokter'];?>"><?php echo $kel['nama'];?></option>

         <?php 
            
            //untuk menampilkan semua data pada tabel pelanggan dalam DB
            $query01 = $db->query("SELECT nama,id FROM user WHERE tipe = '1'");

            //untuk menyimpan data sementara yang ada pada $query
            while($data01 = mysqli_fetch_array($query01))
            {
            

            if ($data01['nama'] == $data_penj['nama_dokter']) {
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



<div class="col-xs-2">
<label> Tanggal :</label>
    <input style="height:20px;" type="text" class="form-control"  id="tanggal" name="tanggal" placeholder="Isi Poli" autocomplete="off" value="<?php echo $data_penj['tanggal']; ?>" readonly="" > 
</div>

<div class="col-xs-2">
<label> Jam :</label>
    <input style="height:20px;" type="text" class="form-control jam_cari"  id="jam" name="jam" placeholder="Isi Poli" autocomplete="off" value="<?php echo $data_penj['jam']; ?>" readonly="" > 
</div>

 <div class="col-xs-2">
    <label> Asal Poli :</label>
    <input style="height:20px;" type="text" class="form-control"  id="asal_poli" name="asal_poli" placeholder="Isi Poli" autocomplete="off" value="<?php echo $data_reg['poli']; ?>" readonly="" >   
</div>


 <div class="col-xs-2">
    <label> Penjamin :</label>
    <select class="form-control chosen" id="penjamin" name="penjamin" required="">
          <?php    
         
          $query = $db->query("SELECT nama FROM penjamin");
          while ( $icd = mysqli_fetch_array($query))
          {
            if ($data_penj['penjamin'] == $icd['nama']) {
             echo "<option selected value='".$icd['nama']."'>".$icd['nama']."</option>";
            }
            else{
              echo "<option value='".$icd['nama']."'>".$icd['nama']."</option>";
            }
          
          }
          ?>
        </select>
</div>


<div class="col-xs-2">
    <label> Level Harga </label><br>
  <select style="font-size:15px; height:35px" type="text" name="level_harga" id="level_harga" class="form-control">
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

<div class="col-xs-1"></div>

<div class="col-xs-2">
<label>Petugas Farmasi</label>
<select style="font-size:15px; height:35px" name="petugas_farmasi" id="petugas_farmasi" class="form-control chosen" >
<option value="">Cari Petugas</option>
  <?php 
    
    //untuk menampilkan semua data pada tabel pelanggan dalam DB
    $query01 = $db->query("SELECT nama, id FROM user WHERE tipe = '3'");

    //untuk menyimpan data sementara yang ada pada $query
    while($data01 = mysqli_fetch_array($query01))
    {
    

    if ($data01['id'] == $data_penj['apoteker']) {
     echo "<option selected value='".$data01['id'] ."'>".$data01['nama'] ."</option>";
    }
    else{
      echo "<option value='".$data01['id'] ."'>".$data01['nama'] ."</option>";
    }

    
    }
    
    
    ?>

</select>
</div>  

<div class="col-xs-1"></div>

<div class="col-xs-2">
<label>Petugas Lain</label>
<select style="font-size:15px; height:35px" name="petugas_lain" id="petugas_lain" class="form-control chosen" >
<option value="">Cari Petugas</option>
  <?php 
    
    //untuk menampilkan semua data pada tabel pelanggan dalam DB
    $query01 = $db->query("SELECT nama, id FROM user WHERE tipe = '5'");

    //untuk menyimpan data sementara yang ada pada $query
    while($data01 = mysqli_fetch_array($query01))
    {
    
    
    if ($data01['id'] == $data_penj['petugas_lain']) {
     echo "<option selected value='".$data01['id'] ."'>".$data01['nama'] ."</option>";
    }
    else{
      echo "<option value='".$data01['id'] ."'>".$data01['nama'] ."</option>";
    }

    
    }
    
    
    ?>

</select>
</div>




</div>




  </form><!--tag penutup form-->

<button type="button" id="cari_produk_penjualan" class="btn btn-info " data-toggle="modal" data-target="#myModal"><i class='fa  fa-search'> Cari (F1)</i>  </button> 

<button type="button" class="btn btn-default" id="btnRefreshsubtotal"> <i class='fa fa-refresh'></i> Refresh Subtotal</button>

<!-- membuat form prosestbspenjual -->
<?php if ($otoritas_tombol['tombol_submit_ugd'] > 0):?>

<form class="form"  role="form" id="formtambahproduk">
<br>
<div class="row">

  <div class="col-xs-3">

  <select type="text" style="height:15px" class="form-control chosen" name="kode_barang" autocomplete="off" id="kode_barang" data-placeholder="SILAKAN PILIH " >
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
  </div>


    <input type="hidden" class="form-control" name="nama_barang" autocomplete="off" id="nama_barang" placeholder="nama" >

  <div class="col-xs-2">
    <input style="height:15px;" type="text" class="form-control" name="jumlah_barang" autocomplete="off" id="jumlah_barang" placeholder="Jumlah" onkeydown="return numbersonly(this, event);">
  </div>

  <div class="col-xs-2">
          
          <select style="font-size:15px; height:35px" type="text" name="satuan_konversi" id="satuan_konversi" class="form-control"  >
          
          <?php 
          
          
          $query = $db->query("SELECT id, nama  FROM satuan");
          while($data = mysqli_fetch_array($query))
          {
          
          echo "<option value='".$data['id']."'>".$data['nama'] ."</option>";
          }
                      
          ?>
          
          </select>

  </div>


   <div class="col-xs-2">
    <input style="height:15px;" type="text" class="form-control" name="potongan" autocomplete="off" id="potongan1" data-toggle="tooltip" data-placement="top" title="Jika Ingin Potongan Dalam Bentuk Persen (%), input : 10%" placeholder="Potongan">
  </div>

   <div class="col-xs-1">
    <input style="height:15px;" type="text" class="form-control" name="tax" autocomplete="off" id="tax1" placeholder="Tax%" >
  </div>


  <button type="submit" id="submit_produk" class="btn btn-success" style="font-size:15px" >Submit (F3)</button>

</div>

    <input type="hidden" class="form-control" name="limit_stok" autocomplete="off" id="limit_stok" placeholder="Limit Stok" >
    <input type="hidden" class="form-control" name="ber_stok" id="ber_stok" placeholder="Ber Stok" >
    <input type="hidden" class="form-control" name="harga_lama" id="harga_lama" placeholder="hargama">
    <input type="hidden" class="form-control" name="harga_baru" id="harga_baru" placeholder="hargaru">
    <input type="hidden" class="form-control" name="jumlahbarang" id="jumlahbarang">
    <input type="hidden" id="satuan_produk" name="satuan" class="form-control">
    <input type="hidden" id="harga_produk" name="harga" class="form-control" placeholder="harga">
    <input type="hidden" id="id_produk" name="id_produk" class="form-control">        

</form> <!-- tag penutup form -->

<?php endif ?>




                <!--untuk mendefinisikan sebuah bagian dalam dokumen-->  
                <span id='tes'></span>            
                
                <div class="table-responsive"> <!--tag untuk membuat garis pada tabel-->  
                <span id="table-baru">  
                <table id="tableuser" class="table table-sm">
                <thead>
                <th> Kode  </th>
                <th> Nama </th>
                <th> Nama Pelaksana </th>
                <th> Jumlah </th>
                <th> Satuan </th>
                <th align="right"> Harga </th>
                <th align="right"> Subtotal </th>
                <th align="right"> Potongan </th>
                <th align="right"> Pajak </th>
                <th> Hapus </th>
                
                </thead>
                
                <tbody id="tbody">
                <?php
                
                //menampilkan semua data yang ada pada tabel tbs penjualan dalam DB
                $perintah = $db->query("SELECT tp.jam,tp.id,tp.tipe_barang,tp.kode_barang,tp.satuan,tp.nama_barang,tp.jumlah_barang,tp.harga,tp.subtotal,tp.potongan,tp.tax,s.nama,tp.no_faktur FROM tbs_penjualan tp INNER JOIN satuan s ON tp.satuan = s.id WHERE tp.no_reg = '$no_reg' ");
                
                //menyimpan data sementara yang ada pada $perintah
                
                while ($data1 = mysqli_fetch_array($perintah))
                {

                  

                //menampilkan data
                echo "<tr class='tr-kode-". $data1['kode_barang'] ." tr-id-". $data1['id'] ."' data-kode-barang='".$data1['kode_barang']."'>
                <td style='font-size:15px'>". $data1['kode_barang'] ."</td>
                <td style='font-size:15px;'>". $data1['nama_barang'] ."</td>";

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

              $pilih3 = $db->query("SELECT no_faktur_penjualan FROM detail_pembayaran_piutang WHERE no_faktur_penjualan = '$data1[no_faktur]'");
              $row_piutang = mysqli_num_rows($pilih3);

if ($otoritas_tombol['edit_produk_ugd'] > 0) {

              if ($row_retur > 0 || $row_piutang > 0) {

                echo"<td class='edit-jumlah-alert' data-id='".$data1['id']."' data-faktur='".$data1['no_faktur']."'  data-kode='".$data1['kode_barang']."'><span id='text-jumlah-".$data1['id']."'>". $data1['jumlah_barang'] ."</span> <input type='hidden' id='input-jumlah-".$data1['id']."' value='".$data1['jumlah_barang']."' class='input_jumlah' data-id='".$data1['id']."' autofocus='' data-kode='".$data1['kode_barang']."' data-satuan='".$data1['satuan']."' data-harga='".$data1['harga']."' data-tipe='".$data1['tipe_barang']."'> </td>";  

              }
              else {


                echo "<td style='font-size:15px' align='right' class='edit-jumlah' data-id='".$data1['id']."'><span id='text-jumlah-".$data1['id']."'>". $data1['jumlah_barang'] ."</span> <input type='hidden' id='input-jumlah-".$data1['id']."' value='".$data1['jumlah_barang']."' class='input_jumlah' data-id='".$data1['id']."' autofocus='' data-kode='".$data1['kode_barang']."' data-harga='".$data1['harga']."' data-tipe='".$data1['tipe_barang']."' data-satuan='".$data1['satuan']."' > </td>";
              }

}
else{
            echo "<td style='font-size:15px' align='right' class='tidak_punya_otoritas' data-id='".$data1['id']."'><span id='text-jumlah-".$data1['id']."'>". $data1['jumlah_barang'] ."</span> <input type='hidden' id='input-jumlah-".$data1['id']."' value='".$data1['jumlah_barang']."' class='input_jumlah' data-id='".$data1['id']."' autofocus='' data-kode='".$data1['kode_barang']."' data-harga='".$data1['harga']."' data-tipe='".$data1['tipe_barang']."' data-satuan='".$data1['satuan']."' > </td>";
}

              echo   "<td style='font-size:15px'>". $data1['nama'] ."</td>

              <td style='font-size:15px' align='right'>". rp($data1['harga']) ."</td>
                <td style='font-size:15px' align='right'><span id='text-subtotal-".$data1['id']."'>". rp($data1['subtotal']) ."</span></td>
                <td style='font-size:15px' align='right'><span id='text-potongan-".$data1['id']."'>". rp($data1['potongan']) ."</span></td>
                <td style='font-size:15px' align='right'><span id='text-tax-".$data1['id']."'>". rp($data1['tax']) ."</span></td>";

if ($otoritas_tombol['hapus_produk_ugd'] > 0) {

              if ($row_retur > 0 || $row_piutang > 0) {

                    echo "<td> <button class='btn btn-danger btn-sm btn-alert-hapus' id='btn-hapus-".$data1['id']."' data-id='".$data1['id']."' data-subtotal='".$data1['subtotal']."' data-faktur='".$data1['no_faktur']."' data-kode='".$data1['kode_barang']."'><span class='glyphicon glyphicon-trash'></span> Hapus </button></td>";

              } 

              else{
                    echo "<td style='font-size:15px'> <button class='btn btn-danger btn-hapus-tbs btn-sm' id='hapus-tbs-". $data1['id'] ."' data-id='". $data1['id'] ."' data-kode-barang='". $data1['kode_barang'] ."' data-barang='". $data1['nama_barang'] ."' data-subtotal='". $data1['subtotal'] ."'>Hapus</button> </td>";

              }

}
else{
  echo "<td style='font-size:15px; color:red'> Tidak Ada Otoritas </td>";
}

              echo "</tr>";

            }

                ?>
                </tbody>
                
                </table>
                </span>
                </div>
                <h6 style="text-align: left ; color: red"><i> * Klik 2x pada kolom jumlah barang jika ingin mengedit.</i></h6>
                <h6 style="text-align: left ;"><i><b> * Short Key (F2) untuk mencari Kode Produk atau Nama Produk.</b></i></h6>

  
</div> <!-- / END COL SM 6 (1)-->



<div class="col-xs-4">



<form action="proses_bayar_jual_kasir.php" id="form_jual" method="POST" >
    
    <style type="text/css">
    .disabled {
    opacity: 0.6;
    cursor: not-allowed;
    disabled: false;
    }
    </style>

  <div class="form-group">
    <div class="card card-block">
      
      <div class="row">
        <div class="col-xs-6">
           
           <label style="font-size:15px"> <b> Subtotal </b></label><br>
           <input style="height:20px;font-size:15px" type="text" name="total" id="total2" class="form-control" placeholder="Total" readonly=""  value="<?php echo rp($data_total['total_penjualan']); ?>">
           
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

          <input type="hidden" name="biaya_adm" style="height:15px;font-size:15px" id="biaya_adm" class="form-control" placeholder="Biaya Admin %" autocomplete="off" >


      </div>

                <div class="row">
            
               <div class="col-xs-6">
                  <label>Biaya Admin %</label>
                  <input type="text" name="biaya_admin_persen" style="height:15px;font-size:15px" id="biaya_admin_persen" class="form-control" placeholder="Biaya Admin %" autocomplete="off" >
                </div>

                <div class="col-xs-6">
                   <label> Biaya Admin (Rp) </label>
                   <input type="text" name="biaya_admin" id="biaya_admin" style="height:15px;font-size:15px"  style="height:15px;font-size:15px" class="form-control" autocomplete="off" onkeydown="return numbersonly(this, event);" onkeyup="javascript:tandaPemisahTitik(this);" value="<?php echo rp($data_penj['biaya_admin']); ?>" >
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
          $total_potongan = round($diskon_n);
        }

         $hitung_total = $subtotal - $total_potongan; 
         $hitung_tax = $hitung_total * round($pajak) / 100;
         $total_akhir1 = $hitung_total + round($hitung_tax) + $biaya_adm;

            ?>


         <div class="col-xs-6">

          <label> Diskon ( Rp )</label><br>
          <input type="text" name="potongan" style="height:20px;font-size:15px" id="potongan_penjualan" value="<?php echo round($total_potongan); ?>" class="form-control" placeholder="" autocomplete="off"  onkeydown="return numbersonly(this, event);" onkeyup="javascript:tandaPemisahTitik(this);">
            
          </div>

        

          <div class="col-xs-6">
          <label> Diskon ( % )</label><br>
          <input type="text" name="potongan_persen" style="height:20px;font-size:15px" id="potongan_persen" value="<?php echo round($potongan); ?>%" class="form-control" placeholder="" autocomplete="off" >
          </div>



           <input type="text" name="tax" id="tax" style="height:20px;font-size:15px;display: none;" value="<?php echo round($pajak); ?>"  class="form-control" autocomplete="off" >


          </div>
          

          <div class="row">
    
           <input type="hidden" name="tax_rp" id="tax_rp" class="form-control" value="<?php echo round($hitung_tax); ?>"  autocomplete="off" >
           
           <label style="display: none"> Adm Bank  (%)</label>
           <input type="hidden" name="adm_bank" id="adm_bank"  value="" class="form-control" >
           
           <div class="col-xs-6">
            
           <label> Tanggal</label>
            <input type="text" name="tanggal_jt" id="tanggal_jt" style="height:20px;font-size:15px" placeholder="Tanggal JT" class="form-control" value="" >
        
           

           </div>


        <div class="col-xs-6">
            <label style="font-size:15px"> <b> Cara Bayar (F4) </b> </label><br>
                      <select type="text" name="cara_bayar" id="carabayar1" class="form-control" style="font-size: 15px" >
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
           <b><input type="text" name="total" id="total1" class="form-control" style="height: 25px; width:90%; font-size:20px;" placeholder="Total" readonly=""  value="<?php echo rp($total_akhir1); ?>"></b>
          
        </div>
 
            <div class="col-xs-6">
              
           <label style="font-size:15px">  <b> Pembayaran (F7)</b> </label><br>
           <b><input type="text" name="pembayaran" id="pembayaran_penjualan" style="height: 20px; width:90%; font-size:20px;" autocomplete="off" class="form-control"   style="font-size: 20px"  onkeydown="return numbersonly(this, event);" onkeyup="javascript:tandaPemisahTitik(this);" ></b>

            </div>
      </div>
           
           
          <div class="row">

          <div class="col-xs-6">
            <label> Pembayaran Awal </label><br>
            <input type="text" name="pembayaran" id="pembayaran_awal" style="height: 15px; width:90%;" autocomplete="off" class="form-control" readonly="" value="<?php echo rp($data_penj['tunai']); ?>">
          </div>

            <div class="col-xs-6">
              
              <?php  
              $x = $data_penj['tunai'] - $total_akhir;

              if ($x < 0) {
                $kembalian = '0';
              }
              else{
                $kembalian = $data_penj['tunai'] - $total_akhir;
              }
              ?>

           <label> Kembalian </label><br>
           <b><input type="text" name="sisa_pembayaran"  id="sisa_pembayaran_penjualan"  style="height:20px;font-size:15px" class="form-control"  readonly="" value="<?php echo rp($kembalian); ?>"></b>
            </div>


            
          </div> 
          
          <div class="row">
                  <div class="col-xs-6">
                        
                        <?php  
                        $x = $total_akhir - $data_penj['tunai'];

                        if ($x < 0) {
                          $kredit = '0';
                        }
                        else{
                          $kredit = $total_akhir - $data_penj['tunai'];
                        }
                        ?>

                    <label> Kredit </label><br>
                    <b><input type="text" name="kredit" id="kredit" class="form-control"  style="height:20px;font-size:15px"  readonly="" ></b>
                  </div>
            

                      
                  <div class="col-xs-6">           
                     <label> Keterangan </label><br>
                     <textarea style="height:40px;font-size:15px" type="text" name="keterangan" id="keterangan" class="form-control"  > <?php echo $data_penj['keterangan']; ?>
                     </textarea>
                  </div>


          </div>


          
          
          <?php 
          
          if ($_SESSION['otoritas'] == 'Pimpinan') {
          echo '<label style="display:none"> Total Hpp </label><br>
          <input type="hidden" name="total_hpp" id="total_hpp" style="height: 50px; width:90%; font-size:25px;" class="form-control" placeholder="" readonly="" >';
          }
          
          
          //Untuk Memutuskan Koneksi Ke Database
          mysqli_close($db);   
          ?>



      </div><!-- END card-block -->

       </div>

          
          
          <input style="height:15px" type="hidden" name="jumlah" id="jumlah1" class="form-control" placeholder="jumlah">
          
          
          <!-- memasukan teks pada kolom kode pelanggan, dan nomor faktur penjualan namun disembunyikan -->

          
          <input type="hidden" name="kode_pelanggan" id="k_pelanggan" class="form-control">
          <input type="hidden" name="ppn_input" id="ppn_input" value="<?php echo $data_penj['ppn']; ?>" class="form-control" placeholder="ppn input">  
      

          <div class="row">
 
        <?php if ($otoritas_tombol['tombol_bayar_ugd'] > 0):?>
          <button type="submit" id="penjualan" class="btn btn-info" style="font-size:15px;">Bayar (F8)</button>
        <?php endif ?>

          <a class="btn btn-info" href="lap_penjualan.php" id="transaksi_baru" style="display: none"> Kembali </a>
          
        <?php if ($otoritas_tombol['tombol_piutang_ugd'] > 0):?>
          <button type="submit" id="piutang" class="btn btn-warning" style="font-size:15px">Piutang (F9)</button>
        <?php endif ?>

          <a href='cetak_penjualan_tunai_kategori.php?no_faktur=<?php echo $no_faktur; ?>' id="cetak_tunai_kategori" style="display: none;" class="btn btn-primary" target="blank"> Cetak Tunai/Kategori  </a>

          <a href='cetak_penjualan_piutang.php?no_faktur=<?php echo $no_faktur; ?>' id="cetak_piutang" style="display: none;" class="btn btn-success" target="blank">Cetak Piutang  </a>
   
<!--
          <button type="submit" id="simpan_sementara" class="btn btn-primary" style="font-size:15px">  Simpan (F10)</button>
          -->
          <a href='cetak_penjualan_tunai.php?no_faktur=<?php echo $no_faktur; ?>' id="cetak_tunai" style="display: none;" class="btn btn-success" target="blank"> Cetak Tunai  </a>

        <?php if ($otoritas_tombol['tombol_bayar_ugd'] > 0):?>
          <button type="submit" id="cetak_langsung" target="blank" class="btn btn-success" style="font-size:15px"> Bayar / Cetak (Ctrl + K) </button>
        <?php endif ?>

        <?php if ($otoritas_tombol['tombol_batal_ugd'] > 0):?>
          <button type="submit" id="batal_penjualan" class="btn btn-danger" style="font-size:15px">  Batal (Ctrl + B)</button>
        <?php endif ?>


          <a href='cetak_penjualan_tunai_besar.php?no_faktur=<?php echo $no_faktur; ?>' id="cetak_tunai_besar" style="display: none;" class="btn btn-warning" target="blank"> Cetak Tunai  Besar </a>
          
     
    
          <br>
          </div> <!--row 3-->
          
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

  $(document).on('click','#btnRefreshsubtotal',function(e){

    var no_reg = $("#no_reg").val();
    var no_faktur = $("#no_faktur").val();

    if (no_reg == '') {
      alert("Anda belum memilih pasien!");
    }
    else
    {
      $.post("proses_refresh_subtotal_edit_ugd.php",{no_reg:no_reg,no_faktur:no_faktur},function(data){

        if (data == '') {
          data = 0;
        }

            var biaya_admin = bersihPemisah(bersihPemisah(bersihPemisah(bersihPemisah($("#biaya_admin").val()))));
            if (biaya_admin == '') {
              biaya_admin = 0;
            }

            var diskon = bersihPemisah(bersihPemisah(bersihPemisah(bersihPemisah($("#potongan_penjualan").val()))));
            if(diskon == '')
            {
              diskon = 0
            }
           var hasilnya = parseInt(data,10) + parseInt(biaya_admin,10) - parseInt(diskon,10);

            $("#total1").val(tandaPemisahTitik(hasilnya));
            $("#total2").val(tandaPemisahTitik(data));

      });
    }

  });

});
</script>


<!--untuk memasukkan perintah java script-->
<script type="text/javascript">

// jika dipilih, nim akan masuk ke input dan modal di tutup
  $(document).on('click', '.pilih', function (e) {


  document.getElementById("kode_barang").value = $(this).attr('data-kode');
  $("#kode_barang").trigger("chosen:updated");
  document.getElementById("nama_barang").value = $(this).attr('nama-barang');
  document.getElementById("limit_stok").value = $(this).attr('limit_stok');
  document.getElementById("satuan_produk").value = $(this).attr('satuan');
  document.getElementById("ber_stok").value = $(this).attr('ber-stok');
  document.getElementById("harga_lama").value = $(this).attr('harga');
  document.getElementById("harga_baru").value = $(this).attr('harga');
  document.getElementById("satuan_konversi").value = $(this).attr('satuan');
  document.getElementById("id_produk").value = $(this).attr('id-barang');

    var kode_barang = $("#kode_barang").val();
    var no_reg = $("#no_reg").val();
    
    $.post('cek_kode_barang_tbs_edit.php',{kode_barang:kode_barang,no_reg:no_reg}, function(data){
      
      if(data == 1){
        alert("Anda Tidak Bisa Menambahkan Barang Yang Sudah Ada, Silakan Edit atau Pilih Barang Yang Lain !");
          $("#kode_barang").val('');
          $("#kode_barang").trigger('chosen:updated');
          $("#kode_barang").trigger('chosen:open');
          $("#nama_barang").val('');
       }//penutup if

    });////penutup function(data)

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


<script type="text/javascript">
$(document).ready(function(){
  //end cek level harga
  $("#level_harga").change(function(){
  
  var level_harga = $("#level_harga").val();
  var kode_barang = $("#kode_barang").val();
  
  var satuan_konversi = $("#satuan_konversi").val();
  var jumlah_barang = $("#jumlah_barang").val();
  var id_produk = $("#id_produk").val();

$.post("cek_level_harga_barang.php", {level_harga:level_harga, kode_barang:kode_barang,jumlah_barang:jumlah_barang,id_produk:id_produk,satuan_konversi:satuan_konversi},function(data){

          $("#harga_produk").val(data);
          $("#harga_baru").val(data);
        });
    });
});
//end cek level harga
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

<!-- cek stok satuan konversi id=_change-->
<script type="text/javascript">
  $(document).ready(function(){
    $("#satuan_konversi").change(function(){
      var jumlah_barang = $("#jumlah_barang").val();
      var satuan_konversi = $("#satuan_konversi").val();
      var kode_barang = $("#kode_barang").val();
      
      var id_produk = $("#id_produk").val();
      var prev = $("#satuan_produk").val();
      


      $.post("cek_stok_konversi_penjualan.php", {jumlah_barang:jumlah_barang,satuan_konversi:satuan_konversi,kode_barang:kode_barang,id_produk:id_produk},function(data){

      

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

        if (ber_stok == 'Jasa' || ber_stok == 'BHP') {

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


<script>
$(document).ready(function(){
    $("#satuan_konversi").change(function(){

      var prev = $("#satuan_produk").val();
      var harga_lama = $("#harga_lama").val();
      var satuan_konversi = $("#satuan_konversi").val();
      var id_produk = $("#id_produk").val();
      var harga_produk = $("#harga_lama").val();
      var jumlah_barang = $("#jumlah_barang").val();
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
      
      $(".chosen").chosen({no_results_text: "Maaf, Data Tidak Ada!"});  
      
      </script>

   
   <script type="text/javascript">
  $(document).on('click', '.tidak_punya_otoritas', function (e) {
    alert("Anda Tidak Punya Otoritas Untuk Edit Jumlah Produk !!");
  });
</script>
   


   <script>
   //untuk menampilkan data yang diambil pada form tbs penjualan berdasarkan id=formtambahproduk
  $("#submit_produk").click(function(){

    var no_faktur = $("#no_faktur").val();
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


    var jumlah_barang = bersihPemisah(bersihPemisah(bersihPemisah(bersihPemisah($("#jumlah_barang").val()))));
    var harga = bersihPemisah(bersihPemisah(bersihPemisah(bersihPemisah($("#harga_produk").val()))));
    var potongan = bersihPemisah(bersihPemisah(bersihPemisah(bersihPemisah($("#potongan1").val()))));
    var biaya_admin = bersihPemisah(bersihPemisah(bersihPemisah(bersihPemisah($("#biaya_admin").val()))));
    var tax = bersihPemisah(bersihPemisah(bersihPemisah(bersihPemisah($("#tax1").val()))));
   
    var tax = $("#tax1").val();
    if (tax == '') {
      tax = 0;
    }
// potongan 
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
   
        if (tax == '') {
      tax = 0;
    };

    if (subtotal == "") {
        subtotal = 0;
      };


    if (kode_barang == "") {
      alert("Kode Barang Harus Diisi !!");
      $("#kode_barang").trigger('chosen:open');
    }

    else{




    var jumlahbarang = $("#jumlahbarang").val();
    var satuan = $("#satuan_konversi").val();
    var a = $(".tr-kode-"+kode_barang+"").attr("data-kode-barang");    
    var ber_stok = $("#ber_stok").val();
    var ppn = $("#ppn").val();
    var stok = parseInt(jumlahbarang,10) - parseInt(jumlah_barang,10);

    /*var tax_faktur = bersihPemisah(bersihPemisah(bersihPemisah(bersihPemisah($("#tax").val()))));*/

    var subtotal = bersihPemisah(bersihPemisah(bersihPemisah(bersihPemisah($("#total2").val()))));

    var pot_fakt_per = bersihPemisah(bersihPemisah(bersihPemisah(bersihPemisah($("#potongan_persen").val()))));

    var pot_fakt_rp = bersihPemisah(bersihPemisah(bersihPemisah(bersihPemisah($("#potongan_penjualan").val()))));

    


     
  if (a > 0){
  alert("Anda Tidak Bisa Menambahkan Barang Yang Sudah Ada, Silakan Edit atau Pilih Barang Yang Lain !");
       $("#kode_barang").trigger('chosen:open');
  }
  else if (jumlah_barang == ''){
  alert("Jumlah Barang Harus Diisi");
  $("#jumlah_barang").focus();

  }
  else if (ber_stok == 'Jasa' || ber_stok == 'BHP' )
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


    if (pot_fakt_per == '0%') {
      var potongaaan = pot_fakt_rp;

      var potongaaan = parseInt(potongaaan,10) / parseInt(total_akhir1,10) * 100;
      $("#potongan_persen").val(Math.round(potongaaan));

    var total_akhier = parseInt(total_akhir1,10) - parseInt(pot_fakt_rp,10);


       /*  //Hitung pajak
        if (tax_faktur != 0) {
        var hasil_tax = parseInt(total_akhier,10) * parseInt(tax_faktur,10) / 100;

        }
        else
        {
        var hasil_tax = 0;
        }*/

    //end hitung pajak
    var total_akhir = parseInt(total_akhier,10) + parseInt(biaya_admin,10);

    $("#total1").val(tandaPemisahTitik(total_akhir));

    }
    else if(pot_fakt_rp == 0)
    {
      var potongaaan = pot_fakt_per;
      var pos = potongaaan.search("%");
      var potongan_persen = bersihPemisah(bersihPemisah(bersihPemisah(bersihPemisah(potongaaan))));
          potongan_persen = potongan_persen.replace("%","");
      potongaaan = total_akhir1 * potongan_persen / 100;
      $("#potongan_penjualan").val(potongaaan);

        var total_akhier = parseInt(total_akhir1,10) - parseInt(potongaaan,10);


         /* //Hitung pajak
        if (tax_faktur != 0) {
        var hasil_tax = parseInt(total_akhier,10) * parseInt(tax_faktur,10) / 100;

        }
        else
        {
        var hasil_tax = 0;
        }*/

    //end hitung pajak
    var total_akhir = parseInt(total_akhier,10) + parseInt(biaya_admin,10);

    $("#total1").val(tandaPemisahTitik(total_akhir));
    }
     else if(pot_fakt_rp != 0 && pot_fakt_per != '0%')
    {
      var potongaaan = pot_fakt_per;
      var pos = potongaaan.search("%");
      var potongan_persen = bersihPemisah(bersihPemisah(bersihPemisah(bersihPemisah(potongaaan))));
          potongan_persen = potongan_persen.replace("%","");
      potongaaan = total_akhir1 * potongan_persen / 100;
      $("#potongan_penjualan").val(potongaaan);

     
       var total_akhier = parseInt(total_akhir1,10) - parseInt(potongaaan,10);


         /*//Hitung pajak
        if (tax_faktur != 0) {
        var hasil_tax = parseInt(total_akhier,10) * parseInt(tax_faktur,10) / 100;

        }
        else
        {
        var hasil_tax = 0;
        }*/
    //end hitung pajak

    var total_akhir = parseInt(total_akhier,10) + parseInt(biaya_admin,10);

    $("#total1").val(tandaPemisahTitik(total_akhir));

    }



    $("#total2").val(tandaPemisahTitik(total_akhir1));
    /*$("#tax_rp").val(Math.round(hasil_tax));*/

 $.post("proses_tbs_edit_ugd.php",{no_faktur:no_faktur, penjamin:penjamin,asal_poli:asal_poli,level_harga:level_harga,petugas_paramedik:petugas_paramedik,petugas_farmasi:petugas_farmasi,petugas_lain:petugas_lain,no_reg:no_reg,no_rm:no_rm,dokter:dokter,petugas_kasir:petugas_kasir,kode_barang:kode_barang,nama_barang:nama_barang,jumlah_barang:jumlah_barang,harga:harga,potongan:potongan,tax:tax,satuan:satuan, ber_stok:ber_stok,ppn:ppn},function(data){
     
  

      $("#kode_barang").trigger('chosen:updated');
      $("#kode_barang").trigger('chosen:open');
     $("#ppn").attr("disabled", true);
     $("#tbody").prepend(data);
     $("#kode_barang").val('');
     $("#nama_barang").val('');
     $("#jumlah_barang").val('');
     $("#potongan1").val('');
     $("#tax1").val('');
     $("#pembayaran_penjualan").val('');
     $("#kredit").val('');
      $("#sisa_pembayaran_penjualan").val('');
     $("#kode_barang").trigger('chosen:open');

     });


  
  } 

  else if (stok < 0 && ber_stok == 'Barang') {

          alert("Jumlah Melebihi Stok");
            $("#jumlah_barang").val('');
  }

  else{    

  if (limit_stok > stok)
        {
          alert("Persediaan Barang Ini Sudah Mencapai Batas Limit Stok, Segera Lakukan Pembelian !");
        }



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


    if (pot_fakt_per == '0%') {
      var potongaaan = pot_fakt_rp;

      var potongaaan = parseInt(potongaaan,10) / parseInt(total_akhir1,10) * 100;
      $("#potongan_persen").val(Math.round(potongaaan));

    var total_akhier = parseInt(total_akhir1,10) - parseInt(pot_fakt_rp,10);


       /*  //Hitung pajak
        if (tax_faktur != 0) {
        var hasil_tax = parseInt(total_akhier,10) * parseInt(tax_faktur,10) / 100;

        }
        else
        {
        var hasil_tax = 0;
        }*/

    //end hitung pajak
    var total_akhir = parseInt(total_akhier,10) + parseInt(biaya_admin,10);

    $("#total1").val(tandaPemisahTitik(total_akhir));

    }
    else if(pot_fakt_rp == 0)
    {
      var potongaaan = pot_fakt_per;
      var pos = potongaaan.search("%");
      var potongan_persen = bersihPemisah(bersihPemisah(bersihPemisah(bersihPemisah(potongaaan))));
          potongan_persen = potongan_persen.replace("%","");
      potongaaan = total_akhir1 * potongan_persen / 100;
      $("#potongan_penjualan").val(potongaaan);

        var total_akhier = parseInt(total_akhir1,10) - parseInt(potongaaan,10);


         /* //Hitung pajak
        if (tax_faktur != 0) {
        var hasil_tax = parseInt(total_akhier,10) * parseInt(tax_faktur,10) / 100;

        }
        else
        {
        var hasil_tax = 0;
        }*/

    //end hitung pajak
    var total_akhir = parseInt(total_akhier,10) + parseInt(biaya_admin,10);

    $("#total1").val(tandaPemisahTitik(total_akhir));
    }
     else if(pot_fakt_rp != 0 && pot_fakt_per != '0%')
    {
      var potongaaan = pot_fakt_per;
      var pos = potongaaan.search("%");
      var potongan_persen = bersihPemisah(bersihPemisah(bersihPemisah(bersihPemisah(potongaaan))));
          potongan_persen = potongan_persen.replace("%","");
      potongaaan = total_akhir1 * potongan_persen / 100;
      $("#potongan_penjualan").val(potongaaan);

     
       var total_akhier = parseInt(total_akhir1,10) - parseInt(potongaaan,10);


         /*//Hitung pajak
        if (tax_faktur != 0) {
        var hasil_tax = parseInt(total_akhier,10) * parseInt(tax_faktur,10) / 100;

        }
        else
        {
        var hasil_tax = 0;
        }*/
    //end hitung pajak

    var total_akhir = parseInt(total_akhier,10) + parseInt(biaya_admin,10);

    $("#total1").val(tandaPemisahTitik(total_akhir));

    }



    $("#total2").val(tandaPemisahTitik(total_akhir1));
    /*$("#tax_rp").val(Math.round(hasil_tax));*/

   $.post("proses_tbs_edit_ugd.php",{no_faktur:no_faktur,penjamin:penjamin,asal_poli:asal_poli,level_harga:level_harga,petugas_paramedik:petugas_paramedik,petugas_farmasi:petugas_farmasi,petugas_lain:petugas_lain,no_reg:no_reg,no_rm:no_rm,dokter:dokter,petugas_kasir:petugas_kasir,kode_barang:kode_barang,nama_barang:nama_barang,jumlah_barang:jumlah_barang,harga:harga,potongan:potongan,tax:tax,satuan:satuan,ber_stok:ber_stok,ppn:ppn},function(data){
     

      $("#kode_barang").trigger('chosen:updated');
      $("#kode_barang").trigger('chosen:open');
      $("#ppn").attr("disabled", true);
     $("#tbody").prepend(data);
     $("#kode_barang").val('');
     $("#nama_barang").val('');
     $("#jumlah_barang").val('');
     $("#potongan1").val('');
     $("#tax1").val('');
     $("#pembayaran_penjualan").val('');
     $("#kredit").val('');
     $("#sisa_pembayaran_penjualan").val('')
     $("#kode_barang").trigger('chosen:open');
     
     });
}



    }


      
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



<script type="text/javascript">




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




<script>
   //perintah javascript yang diambil dari form proses_bayar_beli.php dengan id=form_beli
  $("#penjualan").click(function(){

        
        var sisa_pembayaran = bersihPemisah(bersihPemisah(bersihPemisah(bersihPemisah( $("#sisa_pembayaran_penjualan").val() ))));
        var kredit = bersihPemisah(bersihPemisah(bersihPemisah(bersihPemisah( $("#kredit").val() )))); 
        var no_faktur = $("#no_faktur").val();
        var no_rm = $("#no_rm").val();
        var no_rm = no_rm.substr(0, no_rm.indexOf(' |'));
        var nama_pasien = $("#nama_pasien").val();
        var no_reg = $("#no_reg").val();
        var tanggal_jt = $("#tanggal_jt").val();
        var total = bersihPemisah(bersihPemisah(bersihPemisah(bersihPemisah( $("#total1").val() )))); 
        var total2 = bersihPemisah(bersihPemisah(bersihPemisah(bersihPemisah( $("#total2").val() )))); 
        var potongan =  bersihPemisah(bersihPemisah(bersihPemisah(bersihPemisah( $("#potongan_penjualan").val() ))));
        potongan = Math.round(potongan);
        var potongan_persen = $("#potongan_persen").val();
        /*var tax = bersihPemisah(bersihPemisah(bersihPemisah(bersihPemisah($("#tax_rp").val()))));*/
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
        var ppn = $("#ppn").val();
        var penjamin = $("#penjamin").val();
        var biaya_adm = bersihPemisah(bersihPemisah(bersihPemisah(bersihPemisah($("#biaya_admin").val()))));
        var tanggal  = $("#tanggal").val();
        var jam  = $("#jam").val();
        if (biaya_adm == "") {
          biaya_adm = 0
        }

        var jenis_penjualan = 'UGD';
        
        var sisa = pembayaran - total;
        
        var sisa_kredit = parseInt(total, 10) - parseInt(pembayaran, 10);

 
 if (sisa_pembayaran < 0)
 {

  alert("Jumlah Pembayaran Tidak Mencukupi");

 }


else if (pembayaran == "") 
 {

alert("Pembayaran Harus Di Isi");

 }

   else if (kode_gudang == "")
 {

alert(" Kode Gudang Harus Diisi ");

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


 $.post("cek_simpan_subtotal_penjualan.php",{total:total,no_reg:no_reg,no_faktur:no_faktur,potongan:potongan,biaya_adm:biaya_adm},function(data) {

  if (data == 1) {


 $.post("proses_bayar_edit_ugd.php",{no_faktur:no_faktur,sisa_pembayaran:sisa_pembayaran,kredit:kredit,no_rm:no_rm,no_reg:no_reg,tanggal_jt:tanggal_jt,total:total,total2:total2,potongan:potongan,potongan_persen:potongan_persen,cara_bayar:cara_bayar,pembayaran:pembayaran,total_hpp:total_hpp,harga:harga,kode_gudang:kode_gudang,dokter:dokter,petugas_kasir:petugas_kasir,petugas_paramedik:petugas_paramedik,petugas_farmasi:petugas_farmasi,petugas_lain:petugas_lain,keterangan:keterangan,ber_stok:ber_stok,ppn_input:ppn_input,sisa:sisa,ppn:ppn,penjamin:penjamin,nama_pasien:nama_pasien,jenis_penjualan:jenis_penjualan,biaya_adm:biaya_adm,sisa_kredit:sisa_kredit,tanggal:tanggal,jam:jam},function(info) {

if (info == 1)
{

          alert("Maaf Subtotal Penjualan Tidak Sesuai, Silakan Tunggu Sebentar! (2) ");       
        window.location.href="form_edit_penjualan_ugd.php?no_reg="+no_reg+"&no_rm="+no_rm+"&kode_gudang="+kode_gudang+"&nama_pasien="+nama_pasien+"&no_faktur="+no_faktur+"";

} 
else
{
     $("#table-baru").html(info);
     var no_faktur = info;
     $("#cetak_tunai").attr('href', 'cetak_penjualan_tunai.php?no_faktur='+no_faktur+'');
     $("#cetak_tunai_besar").attr('href', 'cetak_penjualan_tunai_besar.php?no_faktur='+no_faktur+'');
     $("#cetak_tunai_kategori").attr('href','cetak_penjualan_tunai_kategori.php?no_faktur='+no_faktur+'');

     $("#alert_berhasil").show();
     $("#pembayaran_penjualan").val('');
     $("#sisa_pembayaran_penjualan").val('');
     $("#kredit").val('');
     $("#cetak_tunai").show();
     $("#cetak_tunai_kategori").show('');
     $("#cetak_tunai_besar").show('');
    
    $("#penjualan").hide();
    $("#simpan_sementara").hide();
    $("#batal_penjualan").hide();
    $("#cetak_langsung").hide(); 
    $("#piutang").hide();
    $("#transaksi_baru").show(); 

}

   });
}

  else
  {
      alert("Maaf Subtotal Penjualan Tidak Sesuai, Silakan Tunggu Sebentar! (1) ");       
        window.location.href="form_edit_penjualan_ugd.php?no_reg="+no_reg+"&no_rm="+no_rm+"&kode_gudang="+kode_gudang+"&nama_pasien="+nama_pasien+"&no_faktur="+no_faktur+"";
  }

 });


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
  
    <script>
   //perintah javascript yang diambil dari form proses_bayar_beli.php dengan id=form_beli
  $("#piutang").click(function(){

        var no_faktur = $("#no_faktur").val();
        var sisa_pembayaran = bersihPemisah(bersihPemisah(bersihPemisah(bersihPemisah( $("#sisa_pembayaran_penjualan").val() ))));
        var kredit = bersihPemisah(bersihPemisah(bersihPemisah(bersihPemisah( $("#kredit").val() )))); 
        var no_rm = $("#no_rm").val();
        var no_rm = no_rm.substr(0, no_rm.indexOf(' |'));
        var no_reg = $("#no_reg").val();
        var nama_pasien = $("#nama_pasien").val();
        var tanggal_jt = $("#tanggal_jt").val();
        var total = bersihPemisah(bersihPemisah(bersihPemisah(bersihPemisah( $("#total1").val() )))); 
        var total2 = bersihPemisah(bersihPemisah(bersihPemisah(bersihPemisah( $("#total2").val() )))); 
        var potongan =  bersihPemisah(bersihPemisah(bersihPemisah(bersihPemisah( $("#potongan_penjualan").val() ))));
        potongan = Math.round(potongan);
        var potongan_persen = $("#potongan_persen").val();
        /*var tax = bersihPemisah(bersihPemisah(bersihPemisah(bersihPemisah($("#tax_rp").val()))));*/
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
        var ppn = $("#ppn").val();
        var penjamin = $("#penjamin").val();
        var tanggal = $("#tanggal").val();
        var jam = $("#jam").val();
        var jenis_penjualan = 'UGD';
        var biaya_adm = bersihPemisah(bersihPemisah(bersihPemisah(bersihPemisah($("#biaya_admin").val()))));

        if (biaya_adm == "") {
          biaya_adm = 0
        }
        
        var sisa = pembayaran - total;
        
        var sisa_kredit = total - pembayaran;


     $("#pembayaran_penjualan").val('');
     $("#sisa_pembayaran_penjualan").val('');
     $("#kredit").val('');


       
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

 $.post("cek_simpan_subtotal_penjualan.php",{total:total,no_reg:no_reg,no_faktur:no_faktur,potongan:potongan,biaya_adm:biaya_adm},function(data) {

  if (data == 1) {

 $.post("proses_bayar_edit_ugd.php",{no_faktur:no_faktur,sisa_pembayaran:sisa_pembayaran, kredit:kredit,no_rm:no_rm,no_reg:no_reg,tanggal_jt:tanggal_jt,total:total,total2:total2,potongan:potongan,potongan_persen:potongan_persen,cara_bayar:cara_bayar,pembayaran:pembayaran,total_hpp:total_hpp,harga:harga,kode_gudang:kode_gudang,dokter:dokter,petugas_kasir:petugas_kasir,petugas_paramedik:petugas_paramedik,petugas_farmasi:petugas_farmasi,petugas_lain:petugas_lain,keterangan:keterangan,ber_stok:ber_stok,ppn_input:ppn_input,sisa:sisa,ppn:ppn,penjamin:penjamin,nama_pasien:nama_pasien,jenis_penjualan:jenis_penjualan, biaya_adm:biaya_adm,sisa_kredit:sisa_kredit,tanggal:tanggal,jam:jam},function(info) {

if (info == 1)
{

        alert("Maaf Subtotal Penjualan Tidak Sesuai, Silakan Tunggu Sebentar! (2) ");       
        window.location.href="form_edit_penjualan_ugd.php?no_reg="+no_reg+"&no_rm="+no_rm+"&kode_gudang="+kode_gudang+"&nama_pasien="+nama_pasien+"&no_faktur="+no_faktur+"";

}
else
{        
            $("#table-baru").html(info);
            var no_faktur = info;
            $("#cetak_piutang").attr('href', 'cetak_penjualan_piutang.php?no_faktur='+no_faktur+'');
            $("#table-baru").html(info);
            $("#alert_berhasil").show();
            $("#pembayaran_penjualan").val('');
            $("#sisa_pembayaran_penjualan").val('');
            $("#kredit").val('');
            $("#potongan_penjualan").val('');
            $("#potongan_persen").val('');
            $("#tanggal_jt").val('');
            $("#cetak_piutang").show();
            $("#tax").val('');
            
              $("#penjualan").hide();
              $("#simpan_sementara").hide();
              $("#cetak_langsung").hide();
              $("#batal_penjualan").hide(); 
              $("#piutang").hide();
              $("#transaksi_baru").show();
 }

   });


}
  else{
    alert("Maaf Subtotal Penjualan Tidak Sesuai, Silakan Tunggu Sebentar! (1) ");       
        window.location.href="form_edit_penjualan_ugd.php?no_reg="+no_reg+"&no_rm="+no_rm+"&kode_gudang="+kode_gudang+"&nama_pasien="+nama_pasien+"&no_faktur="+no_faktur+"";
  }



 });

 }

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


<script>
   //perintah javascript yang diambil dari form proses_bayar_beli.php dengan id=form_beli
  $("#cetak_langsung").click(function(){

        
        var sisa_pembayaran = bersihPemisah(bersihPemisah(bersihPemisah(bersihPemisah( $("#sisa_pembayaran_penjualan").val() ))));
        var kredit = bersihPemisah(bersihPemisah(bersihPemisah(bersihPemisah( $("#kredit").val() )))); 
        var no_faktur = $("#no_faktur").val();
        var no_rm = $("#no_rm").val();
        var no_rm = no_rm.substr(0, no_rm.indexOf(' |'));
        var nama_pasien = $("#nama_pasien").val();
        var no_reg = $("#no_reg").val();
        var tanggal_jt = $("#tanggal_jt").val();
        var total = bersihPemisah(bersihPemisah(bersihPemisah(bersihPemisah( $("#total1").val() )))); 
        var total2 = bersihPemisah(bersihPemisah(bersihPemisah(bersihPemisah( $("#total2").val() )))); 
        var potongan =  bersihPemisah(bersihPemisah(bersihPemisah(bersihPemisah( $("#potongan_penjualan").val() ))));
        potongan = Math.round(potongan);
        var potongan_persen = $("#potongan_persen").val();
        /*var tax = bersihPemisah(bersihPemisah(bersihPemisah(bersihPemisah($("#tax_rp").val()))));*/
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
        var ppn = $("#ppn").val();
        var penjamin = $("#penjamin").val();
        var biaya_adm = bersihPemisah(bersihPemisah(bersihPemisah(bersihPemisah($("#biaya_admin").val()))));
        var tanggal  = $("#tanggal").val();
        var jam = $("#jam").val();
        if (biaya_adm == "") {
          biaya_adm = 0
        }

        var jenis_penjualan = 'UGD';
        
        var sisa = pembayaran - total;
        
        var sisa_kredit = parseInt(total, 10) - parseInt(pembayaran, 10);




 
 if (sisa_pembayaran < 0)
 {

  alert("Jumlah Pembayaran Tidak Mencukupi");

 }


else if (pembayaran == "") 
 {

alert("Pembayaran Harus Di Isi");

 }

   else if (kode_gudang == "")
 {

alert(" Kode Gudang Harus Diisi ");

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


 $.post("cek_simpan_subtotal_penjualan.php",{total:total,no_reg:no_reg,no_faktur:no_faktur,potongan:potongan,biaya_adm:biaya_adm},function(data) {

  if (data == 1) {


 $.post("proses_bayar_edit_ugd.php",{no_faktur:no_faktur,sisa_pembayaran:sisa_pembayaran,kredit:kredit,no_rm:no_rm,no_reg:no_reg,tanggal_jt:tanggal_jt,total:total,total2:total2,potongan:potongan,potongan_persen:potongan_persen,cara_bayar:cara_bayar,pembayaran:pembayaran,total_hpp:total_hpp,harga:harga,kode_gudang:kode_gudang,dokter:dokter,petugas_kasir:petugas_kasir,petugas_paramedik:petugas_paramedik,petugas_farmasi:petugas_farmasi,petugas_lain:petugas_lain,keterangan:keterangan,ber_stok:ber_stok,ppn_input:ppn_input,sisa:sisa,ppn:ppn,penjamin:penjamin,nama_pasien:nama_pasien,jenis_penjualan:jenis_penjualan,biaya_adm:biaya_adm,sisa_kredit:sisa_kredit,tanggal:tanggal,jam:jam},function(info) {

if (info == 1)
{

          alert("Maaf Subtotal Penjualan Tidak Sesuai, Silakan Tunggu Sebentar! (2) ");       
           window.location.href="form_edit_penjualan_ugd.php?no_reg="+no_reg+"&no_rm="+no_rm+"&kode_gudang="+kode_gudang+"&nama_pasien="+nama_pasien+"&no_faktur="+no_faktur+"";

} 
else
{
     $("#table-baru").html(info);
     var no_faktur = info;
     $("#cetak_tunai").attr('href', 'cetak_penjualan_tunai.php?no_faktur='+no_faktur+'');
     $("#cetak_tunai_besar").attr('href', 'cetak_penjualan_tunai_besar.php?no_faktur='+no_faktur+'');
     $("#cetak_tunai_kategori").attr('href','cetak_penjualan_tunai_kategori.php?no_faktur='+no_faktur+'');

     $("#alert_berhasil").show();
     $("#pembayaran_penjualan").val('');
     $("#sisa_pembayaran_penjualan").val('');
     $("#kredit").val('');

    $("#penjualan").hide();
    $("#simpan_sementara").hide();
    $("#batal_penjualan").hide();
    $("#cetak_langsung").hide(); 
    $("#piutang").hide();
    $("#transaksi_baru").show(); 

      var win = window.open('cetak_penjualan_tunai.php?no_faktur='+no_faktur+'');
      if (win) { 
    
    win.focus(); 

      } 
      else 
      { 
        alert('Mohon Izinkan PopUps Pada Website Ini !');
     }  


}

   });
}

  else{
    alert("Maaf Subtotal Penjualan Tidak Sesuai, Silakan Tunggu Sebentar! (1)");       
        window.location.href="form_edit_penjualan_ugd.php?no_reg="+no_reg+"&no_rm="+no_rm+"&kode_gudang="+kode_gudang+"&nama_pasien="+nama_pasien+"&no_faktur="+no_faktur+"";
  }



 });


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


<script type="text/javascript">
 
$(".btn-alert-hapus").click(function(){
     var no_faktur = $(this).attr("data-faktur");
    var kode_barang = $(this).attr("data-kode");

    $.post('alert_edit_penjualan.php',{no_faktur:no_faktur, kode_barang:kode_barang},function(data){
    
 
    $("#modal_alert").modal('show');
    $("#modal-alert").html(data); 

});

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
        /*var tax = $("#tax").val();*/
       /* var tax_rp = bersihPemisah(bersihPemisah(bersihPemisah(bersihPemisah($("#tax_rp").val()))));*/
       var biaya_admin = bersihPemisah(bersihPemisah(bersihPemisah(bersihPemisah($("#biaya_admin").val()))));
        if (biaya_admin == '')
        {
          biaya_admin = 0;
        }

        /*if (tax == "") {
        tax = 0;
      }*/

      
        var sisa_potongan = parseInt(total,10) - parseInt(Math.round(potongan_penjualan,10));


            /* var t_tax = ((parseInt(sisa_potongan,10) * parseInt(tax,10)) / 100);*/
             var hasil_akhir = parseInt(sisa_potongan, 10) + parseInt(biaya_admin,10);

            // hitungan jika potongan lebih dari 100 % 
          /* var taxxx = ((parseInt(total,10) * parseInt(tax,10)) / 100); */

          var toto = parseInt(total, 10) + parseInt(biaya_admin,10) ;       
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
          $("#potongan_persen").val('')
          $("#potongan_penjualan").val('')
          $("#total1").val(tandaPemisahTitik(Math.round(toto)));
          /*$("#tax_rp").val(Math.round(taxxx));*/
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
                  $("#potongan_penjualan").val(tandaPemisahTitik(Math.round(potongan_penjualan)));
                 /* $("#tax_rp").val(Math.round(t_tax));*/
        }

      });
      });
</script>

<script type="text/javascript">

$(document).ready(function(){

      $("#potongan_penjualan").keyup(function(){

        var potongan_penjualan = bersihPemisah(bersihPemisah(bersihPemisah(bersihPemisah( $("#potongan_penjualan").val() ))));
    
        var pembayaran = bersihPemisah(bersihPemisah(bersihPemisah(bersihPemisah($("#pembayaran_penjualan").val()))));
        if (pembayaran == '') {
          pembayaran = 0;
        }
        var total1 = bersihPemisah(bersihPemisah(bersihPemisah(bersihPemisah( $("#total1").val() ))));
        var total = bersihPemisah(bersihPemisah(bersihPemisah(bersihPemisah($("#total2").val()))));
        var potongan_persen = ((potongan_penjualan / total) * 100);
       /* var tax = $("#tax").val();
        var tax_rp = bersihPemisah(bersihPemisah(bersihPemisah(bersihPemisah($("#tax_rp").val()))));*/


       var biaya_admin = bersihPemisah(bersihPemisah(bersihPemisah(bersihPemisah($("#biaya_admin").val()))));
        if (biaya_admin == '')
        {
          biaya_admin = 0;
        }

        var sisa_potongan = total - Math.round(potongan_penjualan);
       /* var t_tax = ((parseInt(sisa_potongan,10) * parseInt(tax,10)) / 100);*/
        var hasil_akhir = parseInt(sisa_potongan, 10) + parseInt(biaya_admin,10);
        
             

            // hitungan jika potongan lebih dari 100 %
          /* var taxxx = ((parseInt(total,10) * parseInt(tax,10)) / 100);*/
          var toto = parseInt(total, 10) + parseInt(biaya_admin,10);

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
            $("#total1").val(tandaPemisahTitik(toto));
           /* $("#tax_rp").val(Math.round(taxxx))*/
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
       /* $("#tax_rp").val(Math.round(t_tax))*/
        }

        
      });
      });

</script>

<!--<script type="text/javascript">
   $(document).ready(function(){   

       $("#tax").keyup(function(){

        var potongan = bersihPemisah(bersihPemisah(bersihPemisah(bersihPemisah($("#potongan_penjualan").val() ))));
        var potongan_persen = ((total / potongan_persen) * 100);
        var total = bersihPemisah(bersihPemisah(bersihPemisah(bersihPemisah($("#total2").val() ))));
        var biaya_admin = bersihPemisah(bersihPemisah(bersihPemisah(bersihPemisah($("#biaya_admin").val()))));
        if (biaya_admin == '')
        {
          biaya_admin = 0;
        }
        var pembayaran = bersihPemisah(bersihPemisah(bersihPemisah(bersihPemisah($("#pembayaran_penjualan").val()))));
        if (pembayaran == '')
        {
          pembayaran = 0;
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
      });
  </script>-->


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
         $("#biaya_admin").val('');
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
      $("#biaya_admin").val(data_admin);

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
      $("#biaya_admin").val(0);
      $("#biaya_admin_persen").val(data_admin);

  }
  else if (biaya_admin > 0) {

      var hitung_biaya = parseInt(total2,10) * parseInt(data_admin,10) / 100;
      
      $("#biaya_adm").val(Math.round(hitung_biaya));
      $("#biaya_admin").val(Math.round(hitung_biaya));
      var biaya_admin = bersihPemisah(bersihPemisah(bersihPemisah(bersihPemisah($("#biaya_adm").val()))));      
      var hasilnya = parseInt(total2,10) + parseInt(biaya_admin,10) - parseInt(diskon,10);
      
      $("#total1").val(tandaPemisahTitik(hasilnya));
      $("#biaya_admin_persen").val(data_admin);
      


  }
      
    });
});
//end Hitu8ng Biaya Admin
</script>


<!--

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
   $("#biaya_admin").keyup(function(){

        var potongan = bersihPemisah(bersihPemisah(bersihPemisah(bersihPemisah($("#potongan_penjualan").val()))));
        var potongan_persen = $("#potongan_persen").val();
        var total = bersihPemisah(bersihPemisah(bersihPemisah(bersihPemisah($("#total2").val() ))));

        var biaya_admin = bersihPemisah(bersihPemisah(bersihPemisah(bersihPemisah($("#biaya_admin").val()))));
          if (biaya_admin == '')
          {
           biaya_admin = 0;
          }

          if (biaya_admin == 0) {
          $("#biaya_admin_persen").val(0);
          }
          else
          {
            var hitung_persen = (parseInt(biaya_admin,10) / parseInt(total,10)) * 100;

              $("#biaya_admin_persen").val(Math.round(hitung_persen));

                  if (hitung_persen > 100) {
                    alert ("Biaya Admin Tidak Boleh Lebih Dari 100% !");
                    var total1 = parseInt(total,10) -  parseInt(potongan,10);
                    $("#total1").val(tandaPemisahTitik(total1));

                     $("#biaya_admin_persen").val('');
                     $("#biaya_admin").val('');
                      $("#biaya_admin").focus();



                  }
                  else
                  {
    

                            var cara_bayar = $("#carabayar1").val();
                            
                            //var tax = $("#tax").val();///

                            var t_total = total - potongan;

                        
                       // if (tax == "")                          tax = 0;                            }                           else  ///
                       if (cara_bayar == "") {
                              alert ("Kolom Cara Bayar Masih Kosong");
                               ///$("#tax").val('');//
                               $("#potongan_penjualan").val('');
                               $("#potongan_persen").val('');
                            }
               

                           /// var t_tax = ((parseInt(bersihPemisah(bersihPemisah(bersihPemisah(bersihPemisah(t_total,10))))) * parseInt(bersihPemisah(bersihPemisah(bersihPemisah(bersihPemisah(tax,10)))))) / 100);

                            var total_akhir = parseInt(bersihPemisah(bersihPemisah(bersihPemisah(bersihPemisah(t_total,10))))) /*+ Math.round(parseInt(t_tax,10)) */ + parseInt(biaya_admin,10);
                            
                            
                            $("#total1").val(tandaPemisahTitik(total_akhir));

                              //                            if (tax > 100) {                   alert ('Jumlah Tax Tidak Boleh $("#tax").val('');}//
                      

                              //$("#tax_rp").val(Math.round(t_tax));//
                    }


          }
 

        });

});

</script>
<!--
<script type="text/javascript">
  $("#potongan_persen").keyup(function(){

      var potongan_persen = $("#potongan_persen").val();

            if (potongan_persen > 100){
              alert("Potongan Tidak Boleh Lebih Dari 100%")
             }
  });


          $(document).ready(function(){
        $("#potongan_penjualan").keyup(function(){
             var potongan_penjualan =  bersihPemisah(bersihPemisah(bersihPemisah(bersihPemisah( $("#potongan_penjualan").val() ))));
             var total = bersihPemisah(bersihPemisah(bersihPemisah(bersihPemisah($("#total2").val()))));
             var pembayaran = bersihPemisah(bersihPemisah(bersihPemisah(bersihPemisah($("#pembayaran_penjualan").val()))));
             var biaya_admin = bersihPemisah(bersihPemisah(bersihPemisah(bersihPemisah($("#biaya_admin").val()))));
             var tax = $("#tax").val();

             var potongan_persen = ((potongan_penjualan / total) * 100);
             var sisa_potongan = total - potongan_penjualan;
             var kredit = parseInt(sisa_potongan, 10) - parseInt(pembayaran,10);
             var kembalian = parseInt(pembayaran,10) - parseInt(sisa_potongan, 10);
             var t_tax = ((parseInt(sisa_potongan,10) * parseInt(tax,10)) / 100);
             var hasil_akhir = parseInt(sisa_potongan, 10) + parseInt(t_tax,10) + parseInt(biaya_admin, 10);
      
             
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

<script>
$(function() {
    $( "#no_rm_tampil" ).autocomplete({
        source: 'kode_pelanggan_autocomplete.php'
    });
});
</script>

<script type="text/javascript">
  $("#no_rm_tampil").blur(function(){
    var no_rm = $("#no_rm_tampil").val();

    var no_rm = no_rm.substr(0, no_rm.indexOf(' |'));
    $("#no_rm").val(no_rm);

    $.getJSON('update_pelanggan_ugd.php',{no_rm:no_rm}, function(json){
    
      if (json == null)
      {
        
        $('#nama_pasien').val('');
        $('#penjamin').val('');
        $('#level_harga').val('');

      }

      else 
      {
        $('#nama_pasien').val(json.nama_pelanggan);
        $('#penjamin').val(json.penjamin);
        $("#penjamin").trigger("chosen:updated");
        $('#level_harga').val(json.level_harga);
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
      var data_admin = bersihPemisah(bersihPemisah(bersihPemisah(bersihPemisah($("#biaya_admin_select").val()))));
    if (data_admin == '') {
      data_admin = 0;
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

    var biaya_adm = parseInt(total_akhir1,10) * parseInt(data_admin,10) / 100;


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

  $(".tr-id-"+id+"").remove();
    $("#total2").val(tandaPemisahTitik(total_akhir1));  
    $("#total1").val(tandaPemisahTitik(Math.round(total_akhir)));      
    $("#potongan_penjualan").val(Math.round(potongaaan));

    $("#pembayaran_penjualan").val('');
    $("#kredit").val('');
    $("#sisa_pembayaran_penjualan").val('');
    $.post("hapustbs_penjualan.php",{id:id,kode_barang:kode_barang,no_reg:no_reg},function(data){

      
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

});
                  $('form').submit(function(){
              
              return false;
              });


    });
  
//end fungsi hapus data
</script>


   
<script>
//untuk menampilkan data tabel
$(document).ready(function(){
    $("#kode_barang").trigger('chosen:open');
});

</script>

<!--

<script type="text/javascript"> 
        $(document).ready(function(){
        $("#kode_barang").blur(function(){

          var kode_barang = $(this).val();
          var level_harga = $("#level_harga").val();
          var no_faktur = $("#no_faktur").val();
          
          

          $.post('cek_kode_barang_edit_tbs_penjualan.php',{kode_barang:kode_barang,no_faktur:no_faktur}, function(data){
          
          if(data == 1)
          {
          alert("Anda Tidak Bisa Menambahkan Barang Yang Sudah Ada, Silakan Edit atau Pilih Barang Yang Lain !");
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
       
});////penutup function(data)

}//penutup else cek data barang

        });//cek barang yang ada di tbs
        
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
    var tipe_barang = $('#opt-produk-'+kode_barang).attr("tipe_barang");
    var id_barang = $('#opt-produk-'+kode_barang).attr("id-barang");
    var level_harga = $("#level_harga").val();
    var no_reg = $("#no_reg").val();



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

$.post('cek_kode_barang_tbs_edit.php',{kode_barang:kode_barang,no_reg:no_reg}, function(data){
          
  if(data == 1){
          alert("Anda Tidak Bisa Menambahkan Barang Yang Sudah Ada, Silakan Edit atau Pilih Barang Yang Lain !");

          $("#kode_barang").val('');
          $("#kode_barang").trigger("chosen:updated");
          $("#nama_barang").val('');
          $("#kode_barang").trigger('chosen:open');
          $(".chosen").chosen({no_results_text: "Maaf, Data Tidak Ada!",search_contains:true}); 
   }//penutup if     


  });
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

    
    shortcut.add("f10", function() {
        // Do something

        $("#simpan_sementara").click();

    }); 

    
    shortcut.add("ctrl+b", function() {
        // Do something

    var no_reg = $("#no_reg").val()

        window.location.href="batal_edit_penjualan_ugd.php?no_reg="+no_reg+"";


    }); 

     shortcut.add("ctrl+k", function() {
        // Do something

        $("#cetak_langsung").click();


    }); 
</script>


<!--

     <script>
       //perintah javascript yang diambil dari form proses_bayar_beli.php dengan id=form_beli
       $("#simpan_sementara").click(function(){

        var sisa_pembayaran = bersihPemisah(bersihPemisah(bersihPemisah(bersihPemisah( $("#sisa_pembayaran_penjualan").val() ))));
        var no_faktur = $("#no_faktur").val();
        var kredit = bersihPemisah(bersihPemisah(bersihPemisah(bersihPemisah( $("#kredit").val() )))); 
        var no_rm = $("#no_rm").val();
        var no_rm = no_rm.substr(0, no_rm.indexOf(' |'));
        var nama_pasien = $("#nama_pasien").val();
        var no_reg = $("#no_reg").val();
        var tanggal_jt = $("#tanggal_jt").val();
        var total = bersihPemisah(bersihPemisah(bersihPemisah(bersihPemisah( $("#total1").val() )))); 
        var total2 = bersihPemisah(bersihPemisah(bersihPemisah(bersihPemisah( $("#total2").val() )))); 
        var potongan =  bersihPemisah(bersihPemisah(bersihPemisah(bersihPemisah( $("#potongan_penjualan").val() ))));
        var potongan_persen = $("#potongan_persen").val();
        var tax = bersihPemisah(bersihPemisah(bersihPemisah(bersihPemisah($("#tax_rp").val()))));
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
        var ppn = $("#ppn").val();
        var penjamin = $("#penjamin").val();
        var biaya_adm = bersihPemisah(bersihPemisah(bersihPemisah(bersihPemisah($("#biaya_admin").val()))));

        if (biaya_adm == "") {
          biaya_adm = 0
        }

        var jenis_penjualan = 'UGD';
        
        
        var sisa = pembayaran - total;
        
        var sisa_kredit = total - pembayaran;


         if ( total == "") 
         {
         
         alert("Anda Belum Melakukan Pesanan");
         
         }
         
       else
       {

        $("#pembayaran_penjualan").val('');
       $("#sisa_pembayaran_penjualan").val('');
       $("#kredit").val('');
        $("#piutang").hide();
        $("#batal_penjualan").hide();
        $("#penjualan").hide();
        $("#transaksi_baru").show();  
        $("#total1").val('');

       $.post("proses_simpan_barang_ugd.php",{sisa_pembayaran:sisa_pembayaran ,kredit:kredit ,no_rm:no_rm ,nama_pasien:nama_pasien ,no_reg:no_reg ,tanggal_jt:tanggal_jt ,total:total ,total2:total2 ,potongan:potongan ,potongan_persen:potongan_persen ,tax:tax ,cara_bayar:cara_bayar ,pembayaran:pembayaran ,total_hpp:total_hpp ,harga:harga ,kode_gudang:kode_gudang ,dokter:dokter ,petugas_kasir:petugas_kasir ,petugas_paramedik:petugas_paramedik ,petugas_farmasi:petugas_farmasi ,petugas_lain:petugas_lain ,keterangan:keterangan ,ber_stok:ber_stok ,ppn_input:ppn_input ,ppn:ppn ,penjamin:penjamin ,biaya_adm:biaya_adm ,jenis_penjualan:jenis_penjualan ,sisa:sisa ,sisa_kredit:sisa_kredit, no_faktur:no_faktur} ,function(info) {

        
            $("#table-baru").html(info);
            $("#alert_berhasil").show();
            $("#pembayaran_penjualan").val('');
            $("#sisa_pembayaran_penjualan").val('');
            $("#kredit").val('');
            $("#potongan_penjualan").val('');
            $("#potongan_persen").val('');
            $("#tanggal_jt").val('');
            $("#tax").val('');
            
       
       
       });

       
       }  
       //mengambil no_faktur pembelian agar berurutan

       });
 $("form").submit(function(){
       return false;
       });

              $("#simpan_sementara").mouseleave(function(){
               
               $.get('no_faktur_jl.php', function(data) {
               /*optional stuff to do after getScript */ 
               
               $("#no_faktur").val(data);
               $("#no_faktur0").val(data);
               
               });
               var kode_pelanggan = $("#kd_pelanggan").val();
               if (kode_pelanggan == ""){
               $("#kd_pelanggan").attr("disabled", false);
               }
               
               });
  </script>    


-->


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
                                 
                                 $(".edit-jumlah").dblclick(function(){

                                    var id = $(this).attr("data-id");

                                    $("#text-jumlah-"+id+"").hide();

                                    $("#input-jumlah-"+id+"").attr("type", "text");

                                 });


                                 $(".input_jumlah").blur(function(){

                                    var id = $(this).attr("data-id");
                                    var jumlah_baru = $(this).val();

                                    if (jumlah_baru == "") {
                                      jumlah_baru = 0;
                                    }

                                    var kode_barang = $(this).attr("data-kode");
                                    var harga = $(this).attr("data-harga");
                                    var jumlah_lama = $("#text-jumlah-"+id+"").text();
                                    var satuan_konversi = $(this).attr("data-satuan");
                                    var tipe_barang = $(this).attr("data-tipe");


                                    var pot_fakt_rp = bersihPemisah(bersihPemisah(bersihPemisah(bersihPemisah($("#potongan_penjualan").val()))));

                                    var pot_fakt_per = bersihPemisah(bersihPemisah(bersihPemisah(bersihPemisah($("#potongan_persen").val()))));

                                    var subtotal_lama = bersihPemisah(bersihPemisah(bersihPemisah(bersihPemisah($("#text-subtotal-"+id+"").text()))));
                                    var potongan = bersihPemisah(bersihPemisah(bersihPemisah(bersihPemisah($("#text-potongan-"+id+"").text()))));

                                    var tax = bersihPemisah(bersihPemisah(bersihPemisah(bersihPemisah($("#text-tax-"+id+"").text()))));

                                    /*var tax_fak = bersihPemisah(bersihPemisah(bersihPemisah(bersihPemisah($("#tax").val()))));*/

                                    var data_admin = bersihPemisah(bersihPemisah(bersihPemisah(bersihPemisah($("#biaya_admin_select").val()))));
                            
                                    if (data_admin == '') {
                                      data_admin = 0;
                                    }

                                    var ppn = $("#ppn").val();



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

                                    var biaya_admin = parseInt(subtotal_penjualan,10) * data_admin /100;


    if (pot_fakt_per == 0) {
      var potongaaan = pot_fakt_rp;

      var potongaaan_per = parseInt(potongaaan,10) / parseInt(subtotal_penjualan,10) * 100;
      var potongaaan = pot_fakt_rp;
  /*
      var hitung_tax = parseInt(subtotal_penjualan,10) - parseInt(pot_fakt_rp,10);
      var tax_bener = parseInt(hitung_tax,10) * parseInt(tax_faktur,10) / 100;*/

      var total_akhir = parseInt(subtotal_penjualan,10) - parseInt(pot_fakt_rp,10) + parseInt(biaya_admin,10);


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

     var total_akhir = parseInt(subtotal_penjualan,10) - parseInt(potongaaan,10) + parseInt(biaya_admin,10);

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
 
      var total_akhir = parseInt(subtotal_penjualan,10) - parseInt(potongaaan,10) + parseInt(biaya_admin,10);

    
    }

                                      if (jumlah_baru == 0) {

                                       alert ("Jumlah Produk Tidak Boleh 0!");
                                       
                                       $("#input-jumlah-"+id+"").val(jumlah_lama);
                                       $("#text-jumlah-"+id+"").text(jumlah_lama);
                                       $("#text-jumlah-"+id+"").show();
                                       $("#input-jumlah-"+id+"").attr("type", "hidden");
                                    }

                                    else{

                                      if (tipe_barang == 'Jasa' || tipe_barang == 'BHP') {
                                      
                                      $("#text-jumlah-"+id+"").show();
                                      $("#text-jumlah-"+id+"").text(jumlah_baru);
                                      
                                      $("#text-subtotal-"+id+"").text(tandaPemisahTitik(subtotal));
                                      $("#hapus-tbs-"+id+"").attr('data-subtotal', subtotal);
                                      $("#text-tax-"+id+"").text(Math.round(jumlah_tax));
                                      $("#input-jumlah-"+id+"").attr("type", "hidden"); 
                                      $("#total2").val(tandaPemisahTitik(subtotal_penjualan));
                                      $("#potongan_penjualan").val(Math.round(potongaaan));
                                     $("#potongan_persen").val(Math.round(potongaaan_per));

                                    /*$("#tax_rp").val(tandaPemisahTitik(pajak_faktur));*/

                                      $("#total1").val(tandaPemisahTitik(total_akhir)); 
                                   $("#pembayaran_penjualan").val('');
                                   $("#kredit").val('');
                                    $("#sisa_pembayaran_penjualan").val('')
                                      $.post("update_pesanan_barang.php",{jumlah_lama:jumlah_lama,tax:tax,id:id,jumlah_baru:jumlah_baru,kode_barang:kode_barang,potongan:potongan,harga:harga,jumlah_tax:jumlah_tax,subtotal:subtotal},function(){
                                      
                                      
                                      
                                      
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


                                    
                                    $("#text-jumlah-"+id+"").show();
                                    $("#text-jumlah-"+id+"").text(jumlah_baru);

                                    $("#text-subtotal-"+id+"").text(tandaPemisahTitik(subtotal));
                                    $("#hapus-tbs-"+id+"").attr('data-subtotal', subtotal);
                                    $("#text-tax-"+id+"").text(Math.round(jumlah_tax));
                                    $("#input-jumlah-"+id+"").attr("type", "hidden"); 
                                    $("#total2").val(tandaPemisahTitik(subtotal_penjualan)); 
                                    $("#potongan_penjualan").val(tandaPemisahTitik(potongaaan));
                                    /*$("#tax_rp").val(tandaPemisahTitik(pajak_faktur));*/
                                    $("#total1").val(tandaPemisahTitik(total_akhir));   
                                         $("#pembayaran_penjualan").val('');
                                         $("#kredit").val('');
                                          $("#sisa_pembayaran_penjualan").val('')

                                     $.post("update_pesanan_barang.php",{jumlah_lama:jumlah_lama,tax:tax,id:id,jumlah_baru:jumlah_baru,kode_barang:kode_barang,potongan:potongan,harga:harga,jumlah_tax:jumlah_tax,subtotal:subtotal},function(){


                                    
  

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


      /*$("#tax").attr("disabled", true);*/

    // cek ppn exclude 
    var no_reg = $("#no_reg").val();
    $.get("cek_ppn_ex.php",{no_reg:no_reg},function(data){
      if (data == 1) {
          $("#ppn").val('Exclude');
     $("#ppn").attr("disabled", true);
      }
      else if(data == 2){

          $("#ppn").val('Include');
     $("#ppn").attr("disabled", true);
      }
      else
      {

     $("#ppn").val('Include');

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

        window.location.href="batal_edit_penjualan_ugd.php?no_reg="+no_reg+"";

  })
  });
</script>







<script type="text/javascript">
  $(document).ready(function(){
    var no_reg = $("#no_reg").val();
    var no_faktur = $("#no_faktur").val()
    var pot_fakt_per = bersihPemisah(bersihPemisah(bersihPemisah(bersihPemisah($("#potongan_persen").val()))));
    var pot_fakt_rp = bersihPemisah(bersihPemisah(bersihPemisah(bersihPemisah($("#potongan_penjualan").val()))));
    var biaya_admin = bersihPemisah(bersihPemisah(bersihPemisah(bersihPemisah($("#biaya_admin").val()))));

    if (biaya_admin == "") {
      biaya_admin = 0;
    }

    $.post("cek_total_seluruh_raja.php",{no_reg:no_reg},function(data1){
  
        if (data1 == 1) {

                 $.post("cek_total_bayar_pesanan_barang.php",{no_reg:no_reg,no_faktur:no_faktur},function(data){
                data = data.replace(/\s+/g, '');

                  $("#total2").val(tandaPemisahTitik(data))





      if (pot_fakt_per == '0%') {
              var potongaaan = pot_fakt_rp;
              var potongaaan = parseInt(potongaaan,10) / parseInt(data,10) * 100;
              
              $("#potongan_persen").val(Math.round(potongaaan));
              


                 var total = parseInt(data,10) - parseInt(pot_fakt_rp,10) + parseInt(biaya_admin,10);

                  $("#total1").val(tandaPemisahTitik(total))

          var hasilnya = parseInt(data,10) + parseInt(biaya_admin,10) - parseInt(potongaaan,10);
          var persentase = (parseInt(biaya_admin,10) / parseInt(data,10)) * 100;

          $("#biaya_adm").val(biaya_admin);
          $("#biaya_admin_persen").val(Math.round(persentase));

            }
            else if(pot_fakt_rp == 0)
            {
                  var potongaaan = pot_fakt_per;
                  var pos = potongaaan.search("%");
                  var potongan_persen = bersihPemisah(bersihPemisah(bersihPemisah(bersihPemisah(potongaaan))));
                  potongan_persen = potongan_persen.replace("%","");
                  potongaaan = data * potongan_persen / 100;
                  $("#potongan_penjualan").val(Math.round(potongaaan));

                 var total = parseInt(data,10) - parseInt(potongaaan,10) + parseInt(biaya_admin,10);

                  $("#total1").val(tandaPemisahTitik(total));

          var hasilnya = parseInt(data,10) + parseInt(biaya_admin,10) - parseInt(potongaaan,10);
          var persentase = (parseInt(biaya_admin,10) / parseInt(data,10)) * 100;
          
          $("#biaya_adm").val(biaya_admin);
          $("#biaya_admin_persen").val(Math.round(persentase));


            }

            else{
              var akhir = (parseInt(data,10) - parseInt(pot_fakt_rp,10)) + parseInt(biaya_admin,10);
              $("#total1").val(tandaPemisahTitik(akhir));
          var hasilnya = parseInt(data,10) + parseInt(biaya_admin,10) - parseInt(pot_fakt_rp,10);
          var persentase = (parseInt(biaya_admin,10) / parseInt(data,10)) * 100;
          
          $("#biaya_adm").val(biaya_admin);
          $("#biaya_admin_persen").val(Math.round(persentase));
          
            }
      

                });
        }


      });

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
                d.no_faktur = $("#no_faktur").val();
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


<?php include 'footer.php'; ?>