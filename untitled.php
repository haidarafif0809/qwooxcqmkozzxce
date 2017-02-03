<?php 
include 'login_session.php';
include 'header.php';
include 'navbar.php';
include 'db.php';
include_once'sanitasi.php';

$jadi = 3;

$username = stringdoang($_SESSION['nama']);

$query = $db->query("SELECT * FROM registrasi ");
$data3 = mysqli_fetch_array($query);

$tgl= date('d-m-Y');
$jam= date('H:i:s');
$waktu= date('Y-m-d H:i:s');

             
$q_penetapan = $db->query("SELECT * FROM penetapan_petugas");
$v_penetapan = mysqli_fetch_array($q_penetapan);
$nama_dokter = $v_penetapan['nama_dokter'];
$nama_perawat = $v_penetapan['nama_paramedik'];
$nama_farmasi = $v_penetapan['nama_farmasi'];
         
 ?>

<div class="container">
<br>


<!-- Modal Kembalian  bAYAR-->
<div id="modal" class="modal fade" role="dialog">
  <div class="modal-dialog">
    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>       
      </div>
      <div class="modal-body">
          <span id="kembalian"></span>
      </div>
      <div class="modal-footer">
        <a  accesskey="z" href="form_penjualan_kasir_ranap.php" class="btn btn-danger">Close (Z)</a>
        <a accesskey="p" id="cetak_tunai" class="btn btn-success"><span class="glyphicon glyphicon-print"></span> Print (P)</a>      
              <a accesskey="p" id="cetak_kategori" class="btn btn-info"><span class="glyphicon glyphicon-print"></span> Print Kategori (P)</a>      

      </div>
    </div>
  </div>
</div>
<!--modal end kembalian bAYAR-->



<!-- Modal Kembalian Piutang-->
<div id="modal_piutang" class="modal fade" role="dialog">
  <div class="modal-dialog">
    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>       
      </div>
      <div class="modal-body">
          <span id="kembalian2"></span>
      </div>
      <div class="modal-footer">
        <a  accesskey="x" href="form_penjualan_kasir_ranap.php" class="btn btn-danger">Close (X)</a>
        <a accesskey="h" href="cetak_penjualan_kasir_piutang.php?tgl=<?php echo $tgl;?>"  class="btn btn-success"><span class="glyphicon glyphicon-print"></span> Print Piutang (H)</a>      
      
      </div>
    </div>
  </div>
</div>
<!--modal end kembalian PIUTANG-->


<!-- Modal EDIT TBS-->
<div id="modal_edit" class="modal fade" role="dialog">
  <div class="modal-dialog">
    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>       
      </div>
      <div class="modal-body">
        <div class="form-group">
          <form class="form-horizontal" role="form"  method="POST"> <!-- OPEN FORM 1-->
    <label for="penjamin">Jumlah Lama :</label>
    <input type="text" class="form-control" id="jumlah_lama" name="jumlah_lama"  readonly="">
</div>

<div class="form-group">
    <label for="penjamin"><u>J</u>umlah Baru :</label>
    <input type="text" accesskey="j" class="form-control" id="jumlah_baru" nama="jumlah_baru" autocomplete="off" >
</div>

    <input type="hidden" class="form-control" id="id_2" name="id_2"  >
    <input type="hidden" class="form-control" id="no_fak" name="no_fak"  >
    <input type="hidden" class="form-control" id="harga_2" name="harga_2"  >
    <input type="hidden" class="form-control" id="apoteker_ganti" name="apoteker_ganti"  >
    <input type="hidden" class="form-control" id="dokter_penanggungjawab_ganti" name="dokter_penanggungjawab_ganti"  >
    <input type="hidden" class="form-control" id="perawat_ganti" name="perawat_ganti"  >
    <input type="hidden" class="form-control" id="kode_ganti" name="kode_ganti"  >
    <input type="hidden" class="form-control" id="nama_ganti" name="nama_ganti"  >

    <input type="hidden" class="form-control" id="diskon_ganti" name="diskon_ganti"  >
    <input type="hidden" class="form-control" id="tax_ganti" name="tax_ganti"  >
    <input type="hidden" class="form-control" id="tanya" name="tanya"  >

<button type="button" class="btn btn-success" id="edit_jumlah_baru" ><span class='glyphicon glyphicon-wrench'></span> Edit </button>
      </form>
      </div>
      <div class="modal-footer">
        <button type="button" accesskey="l" class="btn btn-danger" data-dismiss="modal">C<u>l</u>ose</button>
      </div>
    </div>
  </div>
</div>
<!--modal end EDIT JUMLAH-->


<!-- Modal Cari Produk -->
<div id="myModal2" class="modal fade" role="dialog" >
  <div class="modal-dialog">
    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal">&times;</button>
          <h4 class="modal-title">Cari Produk</h4>
      </div>
      <div class="modal-body">
          <span id="table-produk">
              </span> 
            </div> <!--  clsoed modal body  -->
          <div class="modal-footer">
        <button type="button" class="btn btn-warning" data-dismiss="modal">Close</button>
      </div>
    </div>
  </div>
</div>
  
<!-- akhir modal Cari Produk-->


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
        <?php 
 $q_registrasi = $db->query("SELECT no_rm,no_reg,nama_pasien,jenis_pasien,tanggal FROM registrasi WHERE (jenis_pasien = 'Rawat Inap') AND status != 'Sudah Pulang' AND  status != 'Batal Rawat Inap'"); 
         
         ?>

        <table  class="table">
          <thead>
            <tr>
              <th>No REG</th>
              <th>NO RM</th>
              <th>Nama Pasien</th>
              <th>Jenis Pasien</th>
              <th>Tanggal</th>
            </tr>
          </thead>
          <tbody>
            <?php 
            while ($f_registrasi = mysqli_fetch_array($q_registrasi)) {
              # code...
              echo "<tr class='pilih-reg' no_rm='".$f_registrasi['no_reg']."'>
              <td>".$f_registrasi['no_reg']."</td>
              <td>".$f_registrasi['no_rm']."</td>
              <td>".$f_registrasi['nama_pasien']."</td>
              <td>".$f_registrasi['jenis_pasien']."</td>
              <td>".$f_registrasi['tanggal']."</td></tr>";
            }
             ?>
          
          </tbody>
        </table>
      </div>
      <div class="modal-footer">
        <button type="button" accesskey="e" class="btn btn-danger" data-dismiss="modal">Clos<u>e</u></button>
      </div>
    </div>

  </div>
</div>


 
<h1>Transaksi Kasir Rawat Inap</h1>
<div class="row">
<div class="col-sm-2"> <!-- COOL 1 -->
<form class="form-horizontal" role="form"> <!-- OPEN FORM 1-->

    <!-- Trigger the modal with a button -->
<button type="button" accesskey="s" class="btn btn-success " data-toggle="modal" data-target="#modal_reg"><span class="glyphicon glyphicon-search"></span> Cari Pa<u>s</u>ien</button>

<div class="form-group">
    <label for="penjamin"><u>N</u>o RM:</label>
    <input type="text" accesskey="n" list="regi" class="form-control" autocomplete="off" id="no_rm" name="no_rm" placeholder="No RM Pasien"  >
    <datalist id="regi">
    <?php 
    $query55 = $db->query("SELECT no_rm,no_reg,nama_pasien,jenis_pasien,tanggal FROM registrasi WHERE (jenis_pasien = 'Rawat Inap')  AND status != 'Sudah Pulang' AND  status != 'Batal Rawat Inap'"); 
    while ( $data55 = mysqli_fetch_array($query55)) {
    echo "<option value='".$data55['no_reg']."'>".$data55['no_rm']." </option>";
    }
    ?>
    </datalist>
</div>

<div class="form-group">
    <label for="penjamin">No REG :</label>
    <input type="text" class="form-control"  id="no_reg" name="no_reg" placeholder="Isi Terlebih Dahulu" autocomplete="off" >   
</div>


<div class="form-group">
    <label for="penjamin">Nama Pasien:</label>
    <input type="text" class="form-control" id="nama_pasien" name="nama_pasien" placeholder="Nama Pasien" readonly="" >
</div>

<div class="form-group">
    <label for="penjamin">Penjamin:</label>
    <input type="text" class="form-control" id="penjamin" name="penjamin" placeholder="Penjamin Pasien" readonly="" >
</div>



</div> <!-- END COOL 1 -->

<div class="col-sm-3"> <!-- COOL 2 -->
<div class="form-group">
    <label for="penjamin">No Faktur:</label>
    <input type="text" class="form-control" id="no_faktur" name="no_faktur" placeholder="No Faktur"  readonly="">
</div>

<div class="form-group">
    <label for="penjamin">Tanggal:</label>
    <input type="text" class="form-control" id="tanggal" nama="tanggal" value="<?php echo $tgl;?>" placeholder="tanggal" readonly="">
</div>




<div class="form-group">
    <label for="penjamin">Jatuh Tempo:</label>
    <input type="text" class="form-control" id="jatuh_tempo" name="jatuh_tempo" placeholder="Tanggal Jatuh Tempo"  >
</div>

<div class="form-group">
    <label for="penjamin">Jenis Pasien:</label>
    <input type="text" class="form-control" id="jenis_pasien" name="jenis_pasien" placeholder="Jenis Pasien" readonly="" >
</div>


</div> <!-- END COOL 2 -->

 
<div class="col-sm-3"> <!-- COOL 3 -->
  <div class="form-group">
    <label for="penjamin">Kamar:</label>
    <input type="text" class="form-control" id="group_bed" placeholder="Isi Group Kamar" readonly="" >
</div>

<div class="form-group">
    <label for="penjamin">Bed:</label>
    <input type="text" class="form-control" id="bed" placeholder="Isi Kamar" readonly="" >
</div>


<div class="form-group">
  <label for="sel1">Keterangan</label>
  <textarea type="text" class="form-control" id="keterangan" name="keterangan" autocomplete="off"></textarea>
</div>
<div class="form-group">
     <label for="penjamin">Asal Poli:</label>
     <input type="text" class="form-control" id="asal_poli" placeholder="Isi Poli" readonly="" >
</div>

<div class="form-group">
    <label for="penjamin">Dokter Penanggung Jawab:</label>
    <select class="form-control ss" id="dokter_pengirim" name="dokter_pengirim" placeholder="Isi Dokter Pengirim">
      <option value="Tidak Ada">Tidak Ada</option>
      <?php 
      $query99 = $db->query("SELECT nama FROM user WHERE otoritas = 'Dokter' ");
      while ( $data99 = mysqli_fetch_array($query99)) {
      echo "<option value='".$data99['nama']."'>".$data99['nama']."</option>";
      }
      ?>
    </select> 
</div>


</div> <!-- COOL 3 -->


<div class="col-sm-4"> <!-- COOL 4 -->

<div class="form-group">
    <label for="penjamin">Petugas Kasir:</label>
    <input type="text" class="form-control" id="petugas" placeholder="Petugas" readonly="" value="<?php echo $username; ?>" >
</div>


<div class="form-group">
     <label for="penjamin">Dokter Pelaksana:</label>
     <select class="form-control ss" id="dokter_penanggungjawab" required="" name="dokter_penanggungjawab" placeholder="Isi Dokter Penanggung Jawab">
      <option value="<?php echo $nama_dokter; ?>"><?php echo $nama_dokter; ?></option>
      <option value="Tidak Ada">Tidak Ada</option>
      <?php 
      $query99 = $db->query("SELECT nama FROM user WHERE otoritas = 'Dokter' ");
      while ( $data99 = mysqli_fetch_array($query99)) {
      echo "<option value='".$data99['nama']."'>".$data99['nama']."</option>";
      }
      ?>
    </select> 
</div>


<div class="form-group">
     <label for="penjamin">Petugas Paramedik:</label>
     <select  type="text" class="form-control ss" id="perawat" required="" placeholder="Isi Perawat" autocomplete="off">
       <option value="<?php echo $nama_perawat; ?>"><?php echo $nama_perawat; ?></option>
    <option value="Tidak Ada">Tidak Ada </option>
    <?php 
    $query99 = $db->query("SELECT nama FROM user WHERE otoritas = 'Petugas Paramedik' ");
    while ( $data99 = mysqli_fetch_array($query99)) {
    echo "<option value='".$data99['nama']."'>".$data99['nama']."</option>";
    }
    ?>
    </select> 
</div>

<div class="form-group">
     <label for="penjamin">Petugas Farmasi :</label>
     <select  type="text" class="form-control ss" id="apoteker" required="" placeholder="Isi Apoteker" autocomplete="off">
     <option value="<?php echo $nama_farmasi; ?>"><?php echo $nama_farmasi; ?></option>
     <option value="Tidak Ada">Tidak Ada</option>
     <?php 
     $query09 = $db->query("SELECT nama FROM user WHERE otoritas = 'Petugas Farmasi' ");
     while ( $data09 = mysqli_fetch_array($query09)) {
     echo "<option value='".$data09['nama']."'>".$data09['nama']."</option>";
     }
     ?>
    </select>
</div>


<div class="form-group">
     <label for="penjamin">Petugas Lain :</label>
     <select  type="text" class="form-control ss" id="p_lain" name="p_lain" placeholder="isi petugas lain" autocomplete="off">
     <option value="">Silakan Pilih </option>
     <?php 
     $query09 = $db->query("SELECT nama FROM user ");
     while ( $data09 = mysqli_fetch_array($query09)) {
     echo "<option value='".$data09['nama']."'>".$data09['nama']."</option>";
     }
     ?>
    </select>
</div>

<button title="" id="simpan_sem" class="btn btn-success">
<span class="glyphicon glyphicon-save"></span>Simpan Sementara</button>


</form> <!-- AKHIR FORM 1-->

</div> <!-- COOL 4 -->
</div><!--penutup div ROW-->

<!-- OPEN FORM CARI PRODUK -->
<button type="button" accesskey="c" id="cari_produk" class="btn btn-info" data-target="#myModal2" data-toggle="modal"><span class="gli"></span> <span class="glyphicon glyphicon-search"></span> <u>C</u>ari Produk</button>
<br>
<br>
<form class="form-inline" role="form" id="formnya" action="proses_tbs_penjualan_rawat_inap.php"  method="POST">

<div class="form-group">  
    <input type="text" list="produk" accesskey="q" style="width:400px" class="form-control" id="nama_produk" autocomplete="off" name="nama_produk" placeholder="Nama Produk" >
<datalist id="produk">
   <?php 
    $query_produk = $db->query("SELECT nama_produk,kode_produk,tipe_produk FROM produk   "); 
    while ( $f_produk = mysqli_fetch_array($query_produk)) {

      $nama_produk = str_replace(" ", "-", $f_produk['nama_produk']);
      $nama_produk = str_replace("/", "-", $nama_produk);
      $nama_produk = str_replace("(", "-", $nama_produk);
      $nama_produk = str_replace(")", "-", $nama_produk);
      $nama_produk = str_replace("%", "-", $nama_produk);
      $nama_produk = str_replace(".", "-", $nama_produk);
      $nama_produk = str_replace(",", "-", $nama_produk);
      $nama_produk = str_replace("&", "-", $nama_produk);
      $nama_produk = str_replace("<", "-", $nama_produk);
      $nama_produk = str_replace(">", "-", $nama_produk);
      $nama_produk = str_replace("+", "-", $nama_produk);

          echo "<option value='".$f_produk['nama_produk']."' id='opt-nama-".$nama_produk."' data-kode='".$f_produk['kode_produk']."' data-tipe='".$f_produk['tipe_produk']."'>".$f_produk['nama_produk']."</option>";
    }
    ?>
    </datalist>
</div>
  

<div class="form-group">    
    <input type="text" class="form-control" id="kode_produk" style="width:150px"  name="kode_produk" placeholder="Kode Produk" readonly=""  >
</div>
    

<div class="form-group"> 
    <input type="text" class="form-control" id="jumlah_produk" name="jumlah_produk" style="width:100px" placeholder="Jumlah " autocomplete="off">
</div>


<div class="form-group"> 
  <input type="text" class="form-control" id="potongan" name="potongan" placeholder=" Diskon " style="width:100px" autocomplete="off">
</div>


<div class="form-group"> 
     <input type="text" class="form-control" id="pajak" name="pajak" placeholder="Isi Pajak Per item " autocomplete="off">
</div>


<!-- YANG DI HIDDEN DI PRODUK -->
<input type="hidden" id="stok" name="stok">
<input type="hidden" id="tipe_produk" name="tipe_produk">
<input type="hidden" id="no_reg2" name="no_reg2" >
<input type="hidden" id="no_faktur2" name="no_faktur2">
<input type="hidden" id="dokter_penanggungjawab2" name="dokter_penanggungjawab2">
<input type="hidden" id="perawat2" name="perawat2">
<input type="hidden" id="apoteker2" name="apoteker2">
<input type="hidden" id="p_lain2" name="p_lain2">
<input type="hidden" id="tanggal2" name="tanggal2" value="<?php echo tanggal_mysql($tgl);?>">
<input type="hidden" id="jam2" name="jam2" value="<?php echo $jam;?>">
<input type="hidden" id="waktu2" name="waktu2" value="<?php echo $waktu;?>">


<input type="hidden" id="tax_f" name="tax_f" >
<input type="hidden" id="diskon_f" name="diskon_f">
<input type="hidden" id="biaya_admin_f" name="biaya_admin_f">


<input type="hidden" id="no_rm_hid" name="no_rm_hiid">
<input type="hidden" id="petugas2" name="petugas2">
<input type="hidden" id="penjamin2" name="penjamin2">

<!-- AKHIR YANG DI HIDDEN DI PRODUK -->


<button type="submit" class="btn btn-primary" id="submit_produk">Tambah <span class="glyphicon glyphicon-plus"></span> </button>

</form> <!-- AKHIR FORM PRODUK -->


<br>

<!-- hiden alone limit stok -->
<input type="hidden" id="limit_stok" name="limit_stok" >
<!-- END hiden alone limit stok -->


<div class="row">
  <div class="col-sm-8"> <!-- Cari Produk -->
      <span id="result">
    <div class="table-responsive">
    <table id="tbs_penjualan" class="table table-bordered">
      <thead>
      <tr>
         <th>Kode  </th>
         <th>Nama  </th>
         <th>Jumlah  </th>
         <th>Harga </th>
         <th>Subtotal</th>
         <th>Diskon </th>
         <th>Pajak </th>
         <th>Waktu</th>
         <th>Petugas</th>
         <th>Tools</th>
      </tr>
      </thead>
     
    
    </table>


    </div> <!--  closed table responsive  -->
  </span>
  <br>

<p>Mozilla* SHIFT + ALT + Q (Untuk Short Key Nama Produk)
    <br>
    Crome* ALT + Q (Untuk Short Key Nama Produk)
    </p>  

</div>  <!-- END Cari Produk -->

  <div class="col-sm-4">  <!-- TBS Produk -->
 <div class="panel panel-info">
<div class="panel-body">

<form class="form-horizontal" role="form" id="kecil" > <!-- OPEN FORM BAYAR -->
<div class="form-group">
      <label class="control-label col-sm-3" for="pwd">Subtotal:</label>
      <div class="col-sm-9"> <b>
      <input type="text" class="form-control" id="subtotal" style="height:50px;font-size:25px" name="subtotal" placeholder="Subtotal" readonly=""></b>
      </div>
</div>


<div class="form-group">
    <label class="control-label col-sm-3" for="pwd"><u>M</u>asuk Akun:</label>
    <div class="col-sm-9"> 
    <select class="form-control" id="cara_bayar" accesskey="m" name="cara_bayar"  >
          <?php 
          $query00 = $db->query("SELECT nama FROM kas ");
          while ( $data00 = mysqli_fetch_array($query00)) {
          echo "<option value='".$data00['nama']."'>".$data00['nama']."</option>";
          }
          ?>
    </select> 
    </div>
</div>


<div class="form-group">
      <label class="control-label col-sm-3" for="pwd">Diskon:</label>
      <div class="col-sm-9"> 
      <input type="text" class="form-control"  onkeydown="return numbersonly(this, event);" onkeyup="javascript:tandaPemisahTitik(this);" 
      id="diskon" name="diskon" placeholder="Isi Diskon" autocomplete="off">
      </div>
</div>

<div class="form-group">
    <label class="control-label col-sm-3" for="pwd">Tax:</label>
    <div class="col-sm-9"> 
    <input type="text" class="form-control"  onkeydown="return numbersonly(this, event);" onkeyup="javascript:tandaPemisahTitik(this);" 
    id="tax" name="tax" placeholder="Isi Tax" autocomplete="off">
    </div>
</div>

<div class="form-group">
    <label class="control-label col-sm-3" for="pwd">Biaya Admin:</label>
    <div class="col-sm-9"> 
    <input type="text" class="form-control"  onkeydown="return numbersonly(this, event);" onkeyup="javascript:tandaPemisahTitik(this);" 
    id="biaya_admin" name="biaya_admin" placeholder="Biaya Admin" autocomplete="off">
    </div>
</div>

<div class="form-group">
    <label class="control-label col-sm-3" for="email">Total Bayar:</label>
    <div class="col-sm-9"> <b>
    <input type="text" class="form-control" id="total" style="height:50px;font-size:25px" name="total" placeholder="Total Pembayaran" readonly="">
    </b>
    </div>
</div>
 
<div class="form-group">
      <label class="control-label col-sm-3" for="pwd">Bayar:</label>
      <div class="col-sm-9"> <b>
      <input type="text"  class="form-control"  style="height:50px;font-size:25px" onkeydown="return numbersonly(this, event);"
      onkeyup="javascript:tandaPemisahTitik(this);" id="bayar" name="bayar" placeholder="Isi Pembayaran" autocomplete="off"></b>
      </div>
</div>

<div class="form-group">
      <label class="control-label col-sm-3" for="pwd">Sisa:</label>
      <div class="col-sm-9"> 
      <b>
      <input type="text" class="form-control" id="sisa"  style="height:50px;font-size:25px" name="sisa" placeholder="Sisa Pembayaran" readonly="">
      </b>

      <!-- HIDDEN DI SISA -->
      <input type="hidden" id="no_faktur3" name="no_faktur3">
      <input type="hidden" id="no_reg3" name="no_reg3">
      <!-- AKHIR HIDDEN DI SISA-->
      </div>
</div>


  
<div class="form-group"> 
    <div class="col-sm-offset-3 col-sm-10">
      <!-- TOMBOL DI FORM BAYAR -->
      <button type="submit" accesskey="b" id="submit_bayar" class="btn btn-success" style="width:80px"><u>B</u>ayar <span class="glyphicon glyphicon-shopping-cart"></span></button>

      <button type="submit" id="piutang" accesskey="u" class="btn btn-warning" style="width:80px"> Pi<u>u</u>tang <span class="glyphicon glyphicon-credit-card"></span></button>

      <button  id="batal_bayar" accesskey="a" class="btn btn-danger batal-bayar" style="width:80px" data-faktur="">B<u>a</u>tal <span class="glyphicon glyphicon-remove-sign"></span></button>


      <!-- TOMBOL DI FORM BAYAR -->
    </div>
</div>

</form> <!-- AKHIR FORM BAYAR -->

        <!-- PERINGATAN SUCCES BAYAR -->
        <div class="alert alert-success" style="display:none" id="success">
        <strong>Success!</strong> Pembayaran Berhasil 
        </div>
<!-- AKHIR TABLE SEMENTARA --> 
  </div> <!-- END TBS Produk -->
  </div>
</div>


</div> <!-- ROW CARI PRODUK + TBS -->

<!-- TABLE SEMENTARA -->

  
</div><!--penutup div container-->



<!--SCRIPT DATATABLE--> 
<script type="text/javascript">
  $(function () {
  $("table").dataTable();
  });
</script> 
  <!--END DATATABLE-->



<script type="text/javascript">
$("#simpan_sem").click(function(){
                  var no_faktur = $("#no_faktur3").val();
                  var diskon = bersihPemisah(bersihPemisah(bersihPemisah(bersihPemisah($("#diskon").val()))));
                var tax = bersihPemisah(bersihPemisah(bersihPemisah(bersihPemisah($("#tax").val()))));
              var biaya_admin = bersihPemisah(bersihPemisah(bersihPemisah(bersihPemisah($("#biaya_admin").val()))));

 $.post("simpan_sementara.php",{no_faktur:no_faktur,diskon:diskon,tax:tax,biaya_admin:biaya_admin},function(data){
                  
                });
});
  </script>


<!-- SCRIPT MENCARI DATA PASIEN -->
<script type="text/javascript">
            $(document).ready(function(){
                $('#no_rm').change(function()
                    {
                    var no_rm = $("#no_rm").val();
                          
                    if (no_rm == '')
                    {
                          $('#no_reg').val('');
                          $('#bed').val('');
                          $('#group_bed').val('');
                          $('#dokter_pengirim').val('');
                          $('#asal_poli').val('');
                          $('#nama_pasien').val('');
                          $('#penjamin').val('');
                          $('#jenis_pasien').val('');
                          $('#no_faktur').val('');
                          $('#subtotal').val('');
                          $('#total').val('');
                         $('#result').html('');

                    }
                    else
                    {
                          $.getJSON('lihat_data_kasir.php',{no_rm:$(this).val()}, function(json){
                          if (json == null)
                          {
                          $('#no_reg').val('');
                          $('#bed').val('');
                          $('#group_bed').val('');
                          $('#dokter_pengirim').val('');
                          $('#asal_poli').val('');
                          $('#nama_pasien').val('');
                          $('#penjamin').val('');
                          $('#jenis_pasien').val('');
                          $('#no_faktur').val('');
                          $('#subtotal').val('');
                          $('#total').val('');
                          $('#result').html('');
                          }

            else 
                {


                          $('#no_rm').val(json.no_rm);
                          $('#no_rm_hid').val(json.no_rm);
                          $('#bed').val(json.bed);
                          $('#group_bed').val(json.group_bed);
                          $('#dokter_pengirim').val(json.dokter_pengirim);
                          $('#dokter_penanggungjawab').val(json.dokter);
                          $('#dokter_penanggungjawab2').val(json.dokter);
                          $('#asal_poli').val(json.poli);
                          $('#nama_pasien').val(json.nama_pasien);
                          $('#penjamin').val(json.penjamin);
                          $('#no_reg3').val(json.no_reg);
                          $('#no_reg2').val(json.no_reg);
                          $('#jenis_pasien').val(json.jenis_pasien);
                          $('#no_reg').val(json.no_reg);

                           $('#tax').val(json.kabupaten);
                          $('#diskon').val(json.kecamatan);
                          $('#biaya_admin').val(json.kelurahan);

                          $('#tax_f').val(json.kabupaten);
                          $('#diskon_f').val(json.kecamatan);
                          $('#biaya_admin_f').val(json.kelurahan);

                          $("#batal_bayar").attr("data-faktur",json.kondisi);
                        $("#no_faktur").val(json.kondisi);
                       $("#no_faktur2").val(json.kondisi);
                       $("#no_faktur3").val(json.kondisi);


                  $("#total").val(tandaPemisahTitik(json.petugas));              
                  $("#subtotal").val(tandaPemisahTitik(json.keterangan));  


                           var penjamin = $("#penjamin").val();
                           var penjamin2 = $("#penjamin2").val(penjamin);

                          $(".ss").trigger("chosen:updated");
                          var penjamin =  $('#penjamin').val();

                      $.post("cek_tempo.php",{penjamin:penjamin},function(data){

                         if (data != '1970-01-01' ){

                            $("#jatuh_tempo").val(data);
                         }

                         else{
                            $("#jatuh_tempo").val('');

                          
                         }

                         });
                     
                        // untuk edit double klick
      
          var no_reg = $("#no_reg").val();
          var perawat = $("#perawat2").val();
          var apoteker = $("#apoteker2").val();
          var petugas_lain = $("#p_lain2").val();
          var petugas = $("#petugas2").val();
          var dokter_penanggungjawab = $("#dokter_penanggungjawab2").val();


          $.post("cek_table_baru_tbs_penjualan_ranap.php",{no_reg:no_reg,perawat:perawat,apoteker:apoteker,petugas_lain:petugas_lain,petugas:petugas,dokter_penanggungjawab:dokter_penanggungjawab},function(data){

                       $("#result").html(data);
                       $("#nama_produk").focus();
                               
                  });
   }
                                              
                      });
                   }
                });
            });
</script>
<!--END SCRIPT CARI DATA PASIEN -->

<script type="text/javascript">

    $(document).on('click', '.pilih-reg', function (e) {
                
            document.getElementById("no_rm").value = $(this).attr('no_rm');
          
            var no_rm = $(this).attr('no_rm');

    $('#modal_reg').modal('hide');

        $.getJSON('lihat_data_kasir.php',{no_rm:no_rm}, function(json){
                          if (json == null)
                          {
                          $('#no_reg').val('');
                          $('#bed').val('');
                          $('#group_bed').val('');
                          $('#dokter_pengirim').val('');
                          $('#asal_poli').val('');
                          $('#nama_pasien').val('');
                          $('#penjamin').val('');
                          $('#jenis_pasien').val('');
                          $('#no_faktur').val('');


                          }

                  else 
                   {
                          $('#no_rm').val(json.no_rm);
                          $('#no_rm_hid').val(json.no_rm);
                          $('#bed').val(json.bed);
                          $('#group_bed').val(json.group_bed);
                          $('#dokter_pengirim').val(json.dokter_pengirim);
                          $('#dokter_penanggungjawab').val(json.dokter);
                          $('#dokter_penanggungjawab2').val(json.dokter);
                          $('#asal_poli').val(json.poli);
                          $('#nama_pasien').val(json.nama_pasien);
                          $('#penjamin').val(json.penjamin);
                          $('#no_reg3').val(json.no_reg);
                          $('#no_reg2').val(json.no_reg);
                          $('#jenis_pasien').val(json.jenis_pasien);
                          $('#no_reg').val(json.no_reg);


                           $('#tax').val(json.kabupaten);
                          $('#diskon').val(json.kecamatan);
                          $('#biaya_admin').val(json.kelurahan);

                          $('#tax_f').val(json.kabupaten);
                          $('#diskon_f').val(json.kecamatan);
                          $('#biaya_admin_f').val(json.kelurahan);
                        
                        $("#no_faktur").val(json.kondisi);
                       $("#no_faktur2").val(json.kondisi);
                       $("#no_faktur3").val(json.kondisi);


                  $("#total").val(tandaPemisahTitik(json.petugas));              
                  $("#subtotal").val(tandaPemisahTitik(json.keterangan));  

                           var penjamin = $("#penjamin").val();
                            var penjamin2 = $("#penjamin2").val(penjamin);

                          var penjamin =  $('#penjamin').val();
                          $(".ss").trigger("chosen:updated");

                      $.post("cek_tempo.php",{penjamin:penjamin},function(data){

                         if (data != '1970-01-01' ){

                            $("#jatuh_tempo").val(data);
                         }

                         else{
                            $("#jatuh_tempo").val('');

                          
                         }

                         });// end cek jatuh tempo
                      
      
          var no_reg = $("#no_reg").val();
          var perawat = $("#perawat2").val();
          var apoteker = $("#apoteker2").val();
          var petugas_lain = $("#p_lain2").val();
          var petugas = $("#petugas2").val();
          var dokter_penanggungjawab = $("#dokter_penanggungjawab2").val();


          $.post("cek_table_baru_tbs_penjualan_ranap.php",{no_reg:no_reg,perawat:perawat,apoteker:apoteker,petugas_lain:petugas_lain,petugas:petugas,dokter_penanggungjawab:dokter_penanggungjawab},function(data){
            

                  $("#result").html(data);                     
                  $("#nama_produk").focus();
                       
                  }); //end cek tabel tbs penjualan
   }
                                              
                        });//end get json
});// end klik data 
     
//            tabel lookup mahasiswa
  
</script>



<!-- SCRIPT AMBIL DATA FORM PRODUK -->
<script type="text/javascript">

    $(document).on('click', '.pilih2', function (e) {
                
            document.getElementById("kode_produk").value = $(this).attr('data-kode-produk');
            document.getElementById("nama_produk").value = $(this).attr('data-nama-produk');
            document.getElementById("stok").value = $(this).attr('data-stok');
            document.getElementById("tipe_produk").value = $(this).attr('data-tipe');
            document.getElementById("limit_stok").value = $(this).attr('data-limitstok');
          

    $('#myModal2').modal('hide');

// untuk cek produk agar tidak double produk di TBS nya
        var kode = $("#kode_produk").val();
        var no_faktur = $("#no_faktur").val();

        $.post("cek_masuk_produk.php",{kode:kode,no_faktur:no_faktur},function(data){

          if(data == 'ya')
            {

            alert("Produk Yang Anda Pilih Sudah Ada");
            $('#nama_produk').val('');
            $('#kode_produk').val('');
            $('#nama_produk').focus();
             }
        });
// AKHIR cek produk agar tidak double produk di TBS nya

});
     
//            tabel lookup mahasiswa
  
</script>
<!--END AMBIL DATA FORM PRODUK -->


<!-- SCRIPT OPEN UNTUK APOTEKER DAN PERAWAT -->
<script>
$(document).ready(function(){

              var perawat = $("#perawat").val();
              var perawat2 = $("#perawat2").val(perawat);
              var apoteker = $("#apoteker").val();
              var apoteker2 = $("#apoteker2").val(apoteker);
              var petugas_lain = $("#p_lain").val();
              var petugas_lain2 = $("#p_lain2").val(petugas_lain);
               var petugas = $("#petugas").val();
               var petugas2 = $("#petugas2").val(petugas);
              
              var dokter_penanggungjawab = $("#dokter_penanggungjawab").val();
              var dokter_penanggungjawab2 = $("#dokter_penanggungjawab2").val(dokter_penanggungjawab);


$("#dokter_penanggungjawab").change(function(){
            var dokter_penanggungjawab = $("#dokter_penanggungjawab").val();
            var dokter_penanggungjawab2 = $("#dokter_penanggungjawab2").val(dokter_penanggungjawab);
 
      });  

      $("#perawat").change(function(){
            var perawat = $("#perawat").val();
            var perawat2 = $("#perawat2").val(perawat);
 
      });

         $("#penjamin").change(function(){
            var penjamin = $("#penjamin").val();
            var penjamin2 = $("#penjamin2").val(penjamin);
 
      });

      $("#apoteker").change(function(){
            var apoteker = $("#apoteker").val();
            var apoteker2 = $("#apoteker2").val(apoteker);
 
      });
        $("#p_lain").change(function(){
            var petugas_lain = $("#p_lain").val();
            var petugas_lain2 = $("#p_lain2").val(petugas_lain);
 
      });
      });
</script>
<!-- SCRIPT OPEN UNTUK APOTEKER DAN PERAWAT -->

<!-- Script langsung FOCUS jumlah produk  -->                          
 <script type="text/javascript">
      $("#kode_produk").focus(function()
      {

            $("#jumlah_produk").focus();
        
      }); 
</script>
<!-- Akhir Script FOCUS jumlah produk -->

<!-- SCRIPT UNTUK MENJALANKAN LIMIT STOK -->
<script>
    $("#jumlah_produk").keyup(function() {
          var jumlah = $("#jumlah_produk").val();
          var stok= $("#stok").val();
          var sisa = stok - jumlah;
          var limit = $("#limit_stok").val();
          var tipe = $("#tipe_produk").val();


    if (tipe == 'Jasa')
    {


    }
    else if (tipe == 'Laboratorium')
    {


    }
     else if (tipe == 'Laundry')
    {


    }

    else if (tipe == 'BHP')
    {

    }

    else if (sisa < limit){
    window.alert("Produk yang anda masukan sudah limit stok ,segera lakukan pembelian");
    }
   

    });

</script>
<!-- END SCRIPT UNTUK MENJALANKAN LIMIT STOK -->
  

<!— SCRIPT TAMBAH PRODUK TBS —>
<script type="text/javascript">
      $("#submit_produk").click(function() {
                var kode =  $("#kode_produk").val();
                var nama =  $("#nama_produk").val();
                var jumlah = $("#jumlah_produk").val();
                var stok=$("#stok").val();
                var sisa = stok-jumlah;
                var no_faktur = $("#no_faktur2").val();
                var tipe = $("#tipe_produk").val();
                var diskon = $("#diskon").val();
                var tax = $("#tax").val();
     

       if (kode == ''){
        window.alert("Kode Barang Harus Terisi");} 



      else if(nama == ''){ 
        window.alert("Nama Barang Harus Terisi");}

      else if(jumlah == ''){
        window.alert("Jumlah Yang akan dibeli Harus Terisi");}

      else if(jumlah == 0){
        window.alert("Jumlah Yang akan dibeli Tidak boleh 0 ");}
    
      else if (tipe == 'Jasa' )
       {


       
   $.post("cek_produk_rawat_inap.php",{kode:kode,no_faktur:no_faktur},function(data){

          if(data == 'ya'){

            alert("Produk Yang Anda Pilih Sudah Ada");
            $('#nama_produk').val('');
            $('#kode_produk').val('');
            $('#jumlah_produk').val('');
            $('#nama_produk').focus();


          }


  else
  {
    $.post($("#formnya").attr("action"), $("#formnya :input").serializeArray(), function(info) { 
    $("#result").html(info);


  
              var diskon_f = bersihPemisah(bersihPemisah(bersihPemisah(bersihPemisah($("#diskon").val()))));
                     if (diskon_f == '')
                      {
                        diskon_f = '0';
                      }
                      var tax_f = bersihPemisah(bersihPemisah(bersihPemisah(bersihPemisah($("#tax").val()))));
                       if (tax_f == '')
                      {
                        tax_f = '0';
                      }
                      var biaya_admin = bersihPemisah(bersihPemisah(bersihPemisah(bersihPemisah($("#biaya_admin").val()))));
                       if (biaya_admin == '')
                      {
                        biaya_admin = '0';
                      }
    $.post("cek_total_bayar.php",{no_faktur:no_faktur,diskon:diskon,tax:tax},function(data){

                      var total_asli = data - diskon_f + parseInt(tax_f,10) +  parseInt(biaya_admin,10);

      $("#total").val(tandaPemisahTitik(total_asli));
    $("#subtotal").val(tandaPemisahTitik(data));

    });

    });
 clearInput();


}

});
         
   }


else if (tipe == 'Laboratorium' )
       {


       
   $.post("cek_produk_rawat_inap.php",{kode:kode,no_faktur:no_faktur},function(data){

          if(data == 'ya'){

            alert("Produk Yang Anda Pilih Sudah Ada");
            $('#nama_produk').val('');
            $('#kode_produk').val('');
            $('#jumlah_produk').val('');
            $('#nama_produk').focus();


          }


  else
  {
    $.post($("#formnya").attr("action"), $("#formnya :input").serializeArray(), function(info) { 
    $("#result").html(info);


    var diskon_f = bersihPemisah(bersihPemisah(bersihPemisah(bersihPemisah($("#diskon").val()))));
                     if (diskon_f == '')
                      {
                        diskon_f = '0';
                      }
                      var tax_f = bersihPemisah(bersihPemisah(bersihPemisah(bersihPemisah($("#tax").val()))));
                       if (tax_f == '')
                      {
                        tax_f = '0';
                      }
                      var biaya_admin = bersihPemisah(bersihPemisah(bersihPemisah(bersihPemisah($("#biaya_admin").val()))));
                       if (biaya_admin == '')
                      {
                        biaya_admin = '0';
                      }

    $.post("cek_total_bayar.php",{no_faktur:no_faktur,diskon:diskon,tax:tax},function(data){

                      var total_asli = data - diskon_f + parseInt(tax_f,10) +  parseInt(biaya_admin,10);
 $("#total").val(tandaPemisahTitik(total_asli));
    $("#subtotal").val(tandaPemisahTitik(data));

    });

    });
 clearInput();


}

});
         
   }


else if (tipe == 'Laundry' )
       {


       
   $.post("cek_produk_rawat_inap.php",{kode:kode,no_faktur:no_faktur},function(data){

          if(data == 'ya'){

            alert("Produk Yang Anda Pilih Sudah Ada");
            $('#nama_produk').val('');
            $('#kode_produk').val('');
            $('#jumlah_produk').val('');
            $('#nama_produk').focus();


          }


  else
  {
    $.post($("#formnya").attr("action"), $("#formnya :input").serializeArray(), function(info) { 
    $("#result").html(info);

 var diskon_f = bersihPemisah(bersihPemisah(bersihPemisah(bersihPemisah($("#diskon").val()))));
                     if (diskon_f == '')
                      {
                        diskon_f = '0';
                      }
                      var tax_f = bersihPemisah(bersihPemisah(bersihPemisah(bersihPemisah($("#tax").val()))));
                       if (tax_f == '')
                      {
                        tax_f = '0';
                      }
                      var biaya_admin = bersihPemisah(bersihPemisah(bersihPemisah(bersihPemisah($("#biaya_admin").val()))));
                       if (biaya_admin == '')
                      {
                        biaya_admin = '0';
                      }

    $.post("cek_total_bayar.php",{no_faktur:no_faktur,diskon:diskon,tax:tax},function(data){

                      var total_asli = data - diskon_f + parseInt(tax_f,10) +  parseInt(biaya_admin,10);

      $("#total").val(tandaPemisahTitik(total_asli));
    $("#subtotal").val(tandaPemisahTitik(data));

    });

    });
 clearInput();


}

});
         
   }


       else if (tipe == 'BHP' ) 
       {


 $.post("cek_produk_rawat_inap.php",{kode:kode,no_faktur:no_faktur},function(data){

          if(data == 'ya')
                  {

            alert("Produk Yang Anda Pilih Sudah Ada");
            $('#nama_produk').val('');
            $('#kode_produk').val('');
            $('#jumlah_produk').val('');
            $('#nama_produk').focus();
                 }


else{


$.post($("#formnya").attr("action"), $("#formnya :input").serializeArray(), function(info) { 
    $("#result").html(info);

   var diskon_f = bersihPemisah(bersihPemisah(bersihPemisah(bersihPemisah($("#diskon").val()))));
                     if (diskon_f == '')
                      {
                        diskon_f = '0';
                      }
                      var tax_f = bersihPemisah(bersihPemisah(bersihPemisah(bersihPemisah($("#tax").val()))));
                       if (tax_f == '')
                      {
                        tax_f = '0';
                      }
                      var biaya_admin = bersihPemisah(bersihPemisah(bersihPemisah(bersihPemisah($("#biaya_admin").val()))));
                       if (biaya_admin == '')
                      {
                        biaya_admin = '0';
                      }

    $.post("cek_total_bayar.php",{no_faktur:no_faktur,diskon:diskon,tax:tax},function(data){

                      var total_asli = data - diskon_f + parseInt(tax_f,10) +  parseInt(biaya_admin,10);

      $("#total").val(tandaPemisahTitik(total_asli));
    $("#subtotal").val(tandaPemisahTitik(data));

    });

    });
 clearInput();
                       
   
}

});

       }

      else if ( sisa < 0  )
      {
        window.alert("Stok tidak mencukupi");
      }

      else 
      {

 $.post("cek_produk_rawat_inap.php",{kode:kode,no_faktur:no_faktur},function(data){

          if(data == 'ya')
                  {

            alert("Produk Yang Anda Pilih Sudah Ada");
            $('#nama_produk').val('');
            $('#kode_produk').val('');
            $('#jumlah_produk').val('');
            $('#nama_produk').focus();
                 }



else
{


    $.post($("#formnya").attr("action"), $("#formnya :input").serializeArray(), function(info) { 
    $("#result").html(info);
 var diskon_f = bersihPemisah(bersihPemisah(bersihPemisah(bersihPemisah($("#diskon").val()))));
                     if (diskon_f == '')
                      {
                        diskon_f = '0';
                      }
                      var tax_f = bersihPemisah(bersihPemisah(bersihPemisah(bersihPemisah($("#tax").val()))));
                       if (tax_f == '')
                      {
                        tax_f = '0';
                      }
                      var biaya_admin = bersihPemisah(bersihPemisah(bersihPemisah(bersihPemisah($("#biaya_admin").val()))));
                       if (biaya_admin == '')
                      {
                        biaya_admin = '0';
                      }
                      
    $.post("cek_total_bayar.php",{no_faktur:no_faktur,diskon:diskon,tax:tax},function(data){

                      var total_asli = data - diskon_f + parseInt(tax_f,10) +  parseInt(biaya_admin,10);

      $("#total").val(tandaPemisahTitik(total_asli));
    $("#subtotal").val(tandaPemisahTitik(data));

    });
 
    });

    clearInput();

    }

 });

}
    });


    $("#formnya").submit(function(){

      return false;
    });

            function clearInput(){ 
            $("#kode_produk").val('');
            $("#jumlah_produk").val('');
            $("#stok").val('');
            $("#potongan").val('');
            $("#pajak").val('');
            $("#nama_produk").val('');
            $("#nama_produk").focus();



            };

</script>
<!--END SCRIPT TAMBAH PRODUK TBS —>
 



<!-- SKRIP BAYAR -->
<script type="text/javascript">
      $("#bayar").keyup(function()
      {
          var total =  bersihPemisah(bersihPemisah(bersihPemisah(bersihPemisah($("#total").val()))));
          var bayar = bersihPemisah(bersihPemisah(bersihPemisah(bersihPemisah($("#bayar").val()))));
          var sisa = bayar - total;

      $("#sisa").val(tandaPemisahTitik(sisa));

      });
</script>
<!-- END SKRIP BAYAR -->


<!--Script Open Bayar -->
<script type="text/javascript">
      $("#submit_bayar").click(function()
      {
            var reg = $("#no_reg").val();
            var total =  bersihPemisah(bersihPemisah(bersihPemisah(bersihPemisah($("#total").val()))));
            var bayar = bersihPemisah(bersihPemisah(bersihPemisah(bersihPemisah($("#bayar").val()))));
            var no_faktur = $("#no_faktur3").val();
            var no_reg = $("#no_reg3").val();
            var sisa = bayar - total;
            var cara = $("#cara_bayar").val();
            var keadaan = $("#keadaan_pulang").val();
            var diskon = bersihPemisah(bersihPemisah(bersihPemisah(bersihPemisah($("#diskon").val()))));
            var tax = bersihPemisah(bersihPemisah(bersihPemisah(bersihPemisah($("#tax").val()))));
            var biaya_admin = bersihPemisah(bersihPemisah(bersihPemisah(bersihPemisah($("#biaya_admin").val()))));
            var petugas = $("#petugas").val();
            var keterangan = $("#keterangan").val();
            var dokter = $("#dokter_penanggungjawab2").val();
            var dokter_pengirim = $("#dokter_pengirim").val();
            var apoteker = $("#apoteker").val();
            var perawat = $("#perawat").val();
            var petugas_lain = $("#p_lain").val();
             var tanggal = $("#tanggal2").val();
            var jam = $("#jam2").val();
            var waktu = $("#waktu2").val();
           


      if (sisa < 0 ){window.alert("MAAF PEMBAYARAN ANDA TIDAK MENCUKUPI");} 
      else if (reg == ''){window.alert("Isi Dahulu No REG");}
      else if (total == ''){window.alert("Total Bayar Harus Terisi");}
      else if (cara == ''){window.alert("Isi Dahulu Cara Bayar Anda");}
      else if (bayar == ''){window.alert("Pembayaran Harus Di Isi");}

      else {
      $.post("proses_bayar_jual_inap.php",
      {dokter_pengirim:dokter_pengirim,tanggal:tanggal,jam:jam,waktu:waktu,petugas_lain:petugas_lain,sisa:sisa,no_faktur:no_faktur,total:total,bayar:bayar,no_reg:no_reg,cara:cara,keadaan:keadaan,diskon:diskon,tax:tax,petugas:petugas,dokter:dokter,apoteker:apoteker,perawat:perawat,keterangan:keterangan,biaya_admin:biaya_admin},function(data){

    $("#success").show();
    $("#kembalian").html(data);
    $("#modal").modal('show');
    $("#result").html('');
    $("#total").val('');
    $("#bayar").val('');                      
    $("#sisa").val('');
    $("#subtotal").val('');
    $("#diskon").val('');
    $("#tax").val('');
    $("#result").html('');
    $("#penjamin").val('');
    $("#no_rm").val('');   
    $('#bed').val('');
    $('#group_bed').val('');
    $('#dokter_pengirim').val('');
    $('#dokter_penanggungjawab').val('');
    $('#asal_poli').val('');
    $('#nama_pasien').val('');
    $('#penjamin').val('');
    $('#no_reg3').val('');
    $('#no_reg2').val('');
    $('#no_reg').val('');
        $("#cetak_tunai").attr('href', 'cetak_penjualan_kasir_eppos.php?no_faktur='+no_faktur+'');
        $("#cetak_kategori").attr('href', 'cetak_penjualan_kasir_kategori.php?no_faktur='+no_faktur+'');

    $("#no_reg").attr("disabled", false);
    $(document).bind("keydown", disable_f5, false);
    


        });

        }

        });
    $("#kecil").submit(function(){
    return false;
    });
</script>
<!-- Akhir Script Open Bayar -->



<!--script chossen-->
<script>
$(".ss").chosen({no_results_text: "Oops, Tidak Ada !"});
</script>
<!--script end chossen-->



<!--SCRIPT PIUTANG -->
<script type="text/javascript">
      $("#piutang").click(function()
      {
            var no_reg = $("#no_reg").val();
            var total =   bersihPemisah(bersihPemisah(bersihPemisah(bersihPemisah($("#total").val()))));
            var bayar =  bersihPemisah(bersihPemisah(bersihPemisah(bersihPemisah($("#bayar").val()))));
            var no_faktur = $("#no_faktur3").val();
            var no_reg = $("#no_reg3").val();
            if (bayar == ''){
              bayar = 0;
            }
            var sisa = bayar - total;
            var cara = $("#cara_bayar").val();
            var jatuh_tempo = $("#jatuh_tempo").val();
            var dp = total - bayar;
            var dokter = $("#dokter_penanggungjawab2").val();
             var dokter_pengirim = $("#dokter_pengirim").val();           
            var apoteker = $("#apoteker").val();
            var perawat = $("#perawat").val();
            var diskon =  bersihPemisah(bersihPemisah(bersihPemisah(bersihPemisah($("#diskon").val()))));
            var tax =  bersihPemisah(bersihPemisah(bersihPemisah(bersihPemisah($("#tax").val()))));
            var biaya_admin = bersihPemisah(bersihPemisah(bersihPemisah(bersihPemisah($("#biaya_admin").val()))));
            var keterangan = $("#keterangan").val();
            var petugas_lain = $("#p_lain").val();
            var tanggal = $("#tanggal2").val();
            var jam = $("#jam2").val();
            var waktu = $("#waktu2").val();
           

      if (no_reg == ''){window.alert("Mohon di isi No reg");}
      else if (jatuh_tempo == ''){window.alert("Tolong Isikan Tanggal Jatuh Tempo Terlebih Dahulu");
              $("#jatuh_tempo").focus();
      } 

      else{

      $.post("proses_piutang_penjualan_inap.php",{dokter_pengirim:dokter_pengirim,tanggal:tanggal,jam:jam,waktu:waktu,petugas_lain:petugas_lain,keterangan:keterangan,sisa:sisa,no_faktur:no_faktur,total:total,bayar:bayar,no_reg:no_reg,cara:cara,jatuh_tempo:jatuh_tempo,dp:dp,dokter:dokter,perawat:perawat,apoteker:apoteker,tax:tax,diskon:diskon,biaya_admin:biaya_admin},function(data){

                           $("#success").show();
                           $("#kembalian2").html(data);
                           $("#modal_piutang").modal('show');
                           $("#result").html('');
                           $("#total").val('');
                           $("#bayar").val('');                      
                           $("#sisa").val('');
                           $("#subtotal").val('');
                           $("#diskon").val('');
                           $("#tax").val('');
                           $("#result").html('');
                           $("#penjamin").val('');
                           $("#no_rm").val('');
                           
                           
                           
                           $('#bed').val('');
                           $('#group_bed').val('');
                           $('#dokter_pengirim').val('');
                           $('#dokter_penanggungjawab').val('');
                           $('#asal_poli').val('');
                           $('#nama_pasien').val('');
                           $('#penjamin').val('');
                           $('#no_reg3').val('');
                           $('#no_reg2').val('');
                           $('#perawat').val('');
                           $('#apoteker').val('');
                           $("#no_reg").attr("disabled", false);
                           $(document).bind("keydown", disable_f5, false);
        });
        }


        });
        $("#kecil").submit(function(){
        return false;
        });
</script>
<!-- END Script pIUTANG-->


<!--SCRIPT BATAL PERITEM TBS-->
<script type="text/javascript">

// jika dipilih, nim akan masuk ke input dan modal di tutup
      $(document).on('click', '.pilih', function (e) {
            var id = $(this).attr('data-id');
            var no_faktur = $(this).attr('data-faktur');
            var kode_produk = $(this).attr('data-kode');
            var tipe_produk = $(this).attr('data-tipe');

   $(".tr-id-"+id).remove();

      $.post("batal_detail_penjualan_ranap.php",{id:id,no_faktur:no_faktur,kode_produk:kode_produk,tipe_produk:tipe_produk},function(data){

            $("#kode_produk").val('');
            $("#nama_produk").val('');
            $("#jumlah_produk").val('');
            $("#potongan").val('');
            $("#pajak").val('');




             var diskon = bersihPemisah(bersihPemisah(bersihPemisah(bersihPemisah($("#diskon").val()))));
                     if (diskon == '')
                      {
                        diskon = '0';
                      }
                      var tax = bersihPemisah(bersihPemisah(bersihPemisah(bersihPemisah($("#tax").val()))));
                       if (tax == '')
                      {
                        tax = '0';
                      }
                      var biaya_admin = bersihPemisah(bersihPemisah(bersihPemisah(bersihPemisah($("#biaya_admin").val()))));
                       if (biaya_admin == '')
                      {
                        biaya_admin = '0';
                      }

    $.post("cek_total_bayar.php",{no_faktur:no_faktur,diskon:diskon,tax:tax},function(data){

                      var total_asli = data - diskon + parseInt(tax,10) +  parseInt(biaya_admin,10);

      $("#total").val(tandaPemisahTitik(total_asli));
    $("#subtotal").val(tandaPemisahTitik(data));
  $("#no_reg").attr("disabled", true);

    }); 
            
            });        
            });
      

// tabel lookup mahasiswa
         
</script>
<!--END SCRIPT BATAL PERITEM TBS -->


<!-- Script pembuka batal bayar penjualan -->
<script type="text/javascript">

// jika di, nim akan masuk ke input dan modal di tutup
    $(document).on('click', '.batal-bayar', function (e) {
              
        var no_faktur = $(this).attr('data-faktur');
               
    $.post("batal_bayar_penjualan.php",{no_faktur:no_faktur},function(data){
          $("#total").val('');
          $("#bayar").val(''); 
                                                    
          $("#sisa").val('');
          $("#result").html(data);                                               
          $("#no_reg").val('');
          $("#no_rm").val('');
          $("#nama_pasien").val('');
          $("#penjamin").val('');
          $("#bed").val('');
          $("#group_bed").val('');
          $("#dokter").val('');
          $("#dokter_pengirim").val('');
          $("#subtotal").val('');
          $("#diskon").val('');
          $("#tax").val('');                          
          $("#asal_poli").val('');
          $('#dokter_penanggungjawab').val('');
          $("#jenis_pasien").val('');
          $("#no_reg").attr("disabled", false);
                          
                          
      });       
      });
      

//  tabel lookup mahasiswa
            
          
</script>
<!-- Script penutup batal bayar penjualan -->


<!-- SCRIPT CEK TABLE PRODUK-->
<script type="text/javascript">
    $("#cari_produk").click(function()

      {
        var no_reg = $("#no_reg").val();
        var no_faktur = $("#no_faktur3").val();
 if (no_reg == '')
 {
        window.alert("No REG Harus Terisi");
      } 
        else {


    $.post("cek_table_produk_penjualan.php",{no_reg:no_reg,no_faktur:no_faktur},function(data){
    
    $("#table-produk").html(data);

      });

    }
      });
</script>
<!--END SCRIPT TABLE PRODUK-->


<!-- SCRIPT DISABLE F5-->
<script>
    function disable_f5(e)
    {
    if ((e.which || e.keyCode) == 116)
    {
    e.preventDefault();
      }
      }
                    
    $("#cari_produk").click(function(){
    $(document).bind("keydown", disable_f5);    
    });
</script>
<!-- END SCRIPT DISABLE F5-->


<!-- Script Input Diskon  -->
<script type="text/javascript">
    $("#diskon").keyup(function() 
    {
         var potongan = bersihPemisah(bersihPemisah(bersihPemisah(bersihPemisah($("#diskon").val()))));
          var taxx = bersihPemisah(bersihPemisah(bersihPemisah(bersihPemisah($("#tax").val()))));
          var biaya_adminn = bersihPemisah(bersihPemisah(bersihPemisah(bersihPemisah($("#biaya_admin").val()))));

            if (taxx == '')
            {
              taxx = 0;
            }

            if (biaya_adminn == '')
            {
              biaya_adminn = 0;
            }

            if (potongan == '')
            {
              potongan = 0;
            }
          var subtotal = bersihPemisah(bersihPemisah(bersihPemisah(bersihPemisah($("#subtotal").val()))));
          var total = parseInt(subtotal,10) - parseInt(potongan,10);
          var hasil_pot1 = parseInt(total,10) + parseInt(taxx,10) + parseInt(biaya_adminn,10);

    $("#total").val(tandaPemisahTitik(hasil_pot1)); 
      }); 
                           
</script>
<!--END Script Input Diskon -->    


<!-- Script Input tAX  -->                          
 <script type="text/javascript">
      $("#tax").keyup(function()
      {
         var potongan = bersihPemisah(bersihPemisah(bersihPemisah(bersihPemisah($("#diskon").val()))));
          var taxx = bersihPemisah(bersihPemisah(bersihPemisah(bersihPemisah($("#tax").val()))));
          var biaya_adminn = bersihPemisah(bersihPemisah(bersihPemisah(bersihPemisah($("#biaya_admin").val()))));

            if (taxx == '')
            {
              taxx = 0;
            }
             if (biaya_adminn == '')
            {
              biaya_adminn = 0;
            }

            if (potongan == '')
            {
              potongan = 0;
            }
          var subtotal = bersihPemisah(bersihPemisah(bersihPemisah(bersihPemisah($("#subtotal").val()))));
          var total = parseInt(subtotal,10) - parseInt(potongan,10);
          var hasil_pot1 = parseInt(total,10) + parseInt(taxx,10) + parseInt(biaya_adminn,10);

    $("#total").val(tandaPemisahTitik(hasil_pot1)); 
      }); 
</script>
<!-- Akhir Script Input  Tax -->

<!-- Script Input tAX  -->                          
 <script type="text/javascript">
      $("#biaya_admin").keyup(function()
      {
         var potongan = bersihPemisah(bersihPemisah(bersihPemisah(bersihPemisah($("#diskon").val()))));
          var taxx = bersihPemisah(bersihPemisah(bersihPemisah(bersihPemisah($("#tax").val()))));
          var biaya_adminn = bersihPemisah(bersihPemisah(bersihPemisah(bersihPemisah($("#biaya_admin").val()))));

            if (taxx == '')
            {
              taxx = 0;
            }
             if (biaya_adminn == '')
            {
              biaya_adminn = 0;
            }
            
            if (potongan == '')
            {
              potongan = 0;
            }
          var subtotal = bersihPemisah(bersihPemisah(bersihPemisah(bersihPemisah($("#subtotal").val()))));
          var total = parseInt(subtotal,10) - parseInt(potongan,10);
          var hasil_pot1 = parseInt(total,10) + parseInt(taxx,10) + parseInt(biaya_adminn,10);

    $("#total").val(tandaPemisahTitik(hasil_pot1)); 
      }); 
</script>
<!-- Akhir Script Input  Tax -->

<!-- Script Datalist Produk -->
 <script type="text/javascript">
          $("#nama_produk").blur(function(){
              var nama_produk  = $("#nama_produk").val();      
              var nama = nama_produk.replace(/ /g,"-");
                  nama =  nama.replace("/","-");
                  nama =  nama.replace("/","-");
                  nama =  nama.replace("/","-");
                  nama =  nama.replace("/","-");
                  nama =  nama.replace("(","-");
                  nama =  nama.replace("(","-");
                  nama =  nama.replace("(","-");
                  nama =  nama.replace("(","-");
                  nama =  nama.replace(")","-");
                  nama =  nama.replace(")","-");
                  nama =  nama.replace(")","-");
                  nama =  nama.replace(")","-");
                  nama =  nama.replace("%","-");
                  nama =  nama.replace("%","-");
                  nama =  nama.replace("%","-");
                  nama =  nama.replace("%","-");
                   nama =  nama.replace(".","-");
                   nama =  nama.replace(".","-");
                  nama =  nama.replace(".","-");
                  nama =  nama.replace("+","-");
                  nama =  nama.replace("+","-")
                  nama =  nama.replace(/,/g,"-");
                  nama =  nama.replace("&","-");
                  nama =  nama.replace(/</g,"-");
                  nama =  nama.replace(/>/g,"-");
              var no_faktur = $("#no_faktur3").val();
              var kode_produk = $("#opt-nama-"+nama).attr('data-kode');
              var tipe_produk = $("#opt-nama-"+nama).attr('data-tipe');
            

      if (kode_produk == null)
      {
        $('#nama_produk').val('');
        $('#kode_produk').val('');
        $('#stok').val('');
        $('#tipe_produk').val('');
      }

      else
      {
        $('#kode_produk').val(kode_produk);
        $('#tipe_produk').val(tipe_produk);

// untuk masukin PRODUK ke TBS produk agar tidak DOUBLE
        var kode = kode_produk;

         $.post('hitung_stok_update_inap.php',{nama:nama_produk,no_faktur:no_faktur},function(data){ 
           $('#stok').val(data); }); 

// Akhir untuk masukin PRODUK ke TBS Produk Agar Tidak DOUBLE

      }

    });

</script>
<!-- Akhir Script Datalist Produk -->


<!--  DATE PICKER -->
<script type="text/javascript">
 $(function() {
   
$( "#jatuh_tempo" ).datepicker({
  dateFormat: "yy-mm-dd", changeYear: true,  yearRange: "1800:2500"


});
});
</script>
<!--  END DATE PICKER -->

<!-- AKHIR SCRIPT  -->

<!-- FOOTER  -->
<?php 
include 'footer.php' ;
?>
<!-- END FOOTER  -->