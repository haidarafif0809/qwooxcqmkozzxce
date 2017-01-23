<?php include_once 'session_login.php';
 

// memasukan file session login,  header, navbar, db.php,
include 'header.php';
include 'navbar.php';
include 'db.php';
include 'sanitasi.php';

 
// menampilkan seluruh data yang ada pada tabel penjualan yang terdapt pada DB
$perintah = $db->query("SELECT * FROM penjualan");

$pilih_akses_tombol = $db->query("SELECT * FROM otoritas_penjualan_apotek WHERE id_otoritas = '$_SESSION[otoritas_id]' ");
$otoritas_tombol = mysqli_fetch_array($pilih_akses_tombol);

$session_id = session_id();

$user = $_SESSION['nama'];



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
  <h3> FORM PENJUALAN APOTEK</h3>
<div class="row">

<div class="col-xs-8">


 <!-- membuat form menjadi beberpa bagian -->
  <form enctype="multipart/form-data" role="form" action="formpenjualan.php" method="post ">
        
  <!--membuat teks dengan ukuran h3-->      


        <div class="form-group">
        <input type="hidden" name="session_id" id="session_id" class="form-control" value="<?php echo session_id(); ?>" readonly="">
        </div>

<div class="row">

<div class="col-xs-2 form-group">
    <label> No. RM / Pasien </label><br>
  <input style="height: 20px;" name="kode_pelanggan" type="text" style="height:15px;" id="kd_pelanggan" class="form-control" required="" autofocus="" value="Umum" >
</div>


<div class="col-xs-2 form-group">
    <label> Petugas Kasir </label><br>
  <input style="height: 20px;" name="kode_pelanggan" type="text" style="height:15px;" id="petugas_kasir" class="form-control" required="" autofocus="" value="<?php echo $user; ?>" readonly="">
</div>

    <div class="form-group col-xs-3">
       <label for="penjamin">Petugas Farmasi </label><br>
         <select type="text" class="form-control chosen" id="apoteker" autocomplete="off">
        

         <?php 
         $query09 = $db->query("SELECT nama,id FROM user WHERE tipe = '3' OR tipe = '2' ");
         while ( $data09 = mysqli_fetch_array($query09)) {
         
         $petugas = $db->query("SELECT nama_farmasi FROM penetapan_petugas WHERE nama_farmasi = '$data01[nama]'");
         $data_petugas = mysqli_fetch_array($petugas);

            if ($data09['nama'] == $data_petugas['nama_farmasi']) {
             echo "<option selected value='".$data09['id'] ."'>".$data09['nama'] ."</option>";
            }
            else{
              echo "<option value='".$data09['id'] ."'>".$data09['nama'] ."</option>";
            }

         }
         ?>

      
        </select> 
  </div>

    

<div class="col-xs-2">
          <label> Gudang </label><br>
          
          <select name="kode_gudang" id="kode_gudang" class="form-control chosen" required="" >
          <?php 
          
          // menampilkan seluruh data yang ada pada tabel suplier
          $query = $db->query("SELECT * FROM gudang");
          
          // menyimpan data sementara yang ada pada $query
          while($data = mysqli_fetch_array($query))
          {

            if ($data['default_sett'] == '1') {

                echo "<option selected value='".$data['kode_gudang'] ."'>".$data['nama_gudang'] ."</option>";
              
            }

            else{

                echo "<option value='".$data['kode_gudang'] ."'>".$data['nama_gudang'] ."</option>";

            }
          
          }
          
          
          ?>
          </select>
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


</div>  <!-- END ROW dari kode pelanggan - ppn -->

<div class="row">


<div class="col-xs-2 form-group">
    <label> No.Resep Dokter </label><br>
  <input style="height: 20px;" name="no_resep_dokter" type="text" style="height:15px;" id="no_resep_dokter" class="form-control" >
</div>

<div class="col-xs-2 form-group">
    <label>Resep Dokter </label><br>
  <input style="height: 20px;" name="resep_dokter" type="text" style="height:15px;" id="resep_dokter" class="form-control" >
</div>

<div class="col-xs-2">
    <label> Level Harga </label><br>
  <select style="font-size:15px; height:35px" type="text" name="level_harga" id="level_harga" class="form-control" required="" >
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
          <label>PPN</label>
          <select style="font-size:15px; height:35px" name="ppn" id="ppn" class="form-control">
            <option value="Include">Include</option>  
            <option value="Exclude">Exclude</option>
            <option value="Non">Non</option>          
          </select>
</div>



<div class="col-xs-3">
<br>
  <button type="button" id="lay" class="btn btn-primary" ><i class='fa  fa-list'></i>&nbsp;Lihat Layanan  </button> 
</div>

</div>

  </form><!--tag penutup form-->

<button type="button" id="cari_produk_penjualan" class="btn btn-info " data-toggle="modal" data-target="#myModal"><i class='fa  fa-search'> </i>Cari (F1)  </button> 


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

<div class="table-resposive">
<span class="modal_baru">
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
</span>
  </div>
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

<!-- membuat form prosestbspenjual -->



<?php if ($otoritas_tombol['tombol_submit_apotek'] > 0):?>  


<form class="form"  role="form" id="formtambahproduk">
<br>
<div class="row">

  <div class="col-xs-3">

    <select type="text" style="height:15px" class="form-control chosen" name="kode_barang" autocomplete="off" id="kode_barang" data-placeholder="SILAKAN PILIH " >
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
    <input style="height:15px;" type="text" class="form-control" name="jumlah_barang" autocomplete="off" id="jumlah_barang" placeholder="Jumlah" >
  </div>

  <div class="col-xs-2">
          
          <select style="font-size:15px; height:35px" type="text" name="satuan_konversi" id="satuan_konversi" class="form-control"  required="">
          
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
    <input type="hidden" class="form-control" name="harga_lama" id="harga_lama">
    <input type="hidden" class="form-control" name="harga_baru" id="harga_baru">
    <input type="hidden" class="form-control" name="jumlahbarang" id="jumlahbarang">
    <input type="hidden" id="satuan_produk" name="satuan" class="form-control" value="" required="">
    <input type="hidden" id="harga_produk" name="harga" class="form-control" value="" required="">
    <input type="hidden" id="id_produk" name="id_produk" class="form-control" value="" required="">  
    <input type="hidden" id="tipe_barang" name="tipe_barang" class="form-control" value="" required="">    
    <input type="hidden" id="harga_penjamin" name="harga_penjamin" class="form-control" value="" required="">    


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
                <th> Nama Petugas</th>
                <th> Jumlah </th>
                <th> Satuan </th>
                <th> Harga </th>
                <th> Subtotal </th>
                <th> Potongan </th>
                <th> Pajak </th>
                <th> Hapus </th>
                
                </thead>
                
                <tbody id="tbody">
                <?php
                
                //menampilkan semua data yang ada pada tabel tbs penjualan dalam DB
                $perintah = $db->query("SELECT tp.id,tp.kode_barang,tp.satuan,tp.nama_barang,tp.jumlah_barang,tp.harga,tp.subtotal,tp.potongan,tp.tax,tp.jam,tp.tipe_barang,s.nama FROM tbs_penjualan tp INNER JOIN satuan s ON tp.satuan = s.id WHERE tp.session_id = '$session_id' AND tp.no_reg = '' ");
                
                //menyimpan data sementara yang ada pada $perintah
                
                while ($data1 = mysqli_fetch_array($perintah))
                {
                //menampilkan data
                echo "<tr class='tr-kode-". $data1['kode_barang'] ." tr-id-". $data1['id'] ."' data-kode-barang='".$data1['kode_barang']."'>
                <td style='font-size:15px'>". $data1['kode_barang'] ."</td>
                <td style='font-size:15px;'>". $data1['nama_barang'] ."</td>";

                 $kd = $db->query("SELECT f.nama_petugas, u.nama FROM tbs_fee_produk f INNER JOIN user u ON f.nama_petugas = u.id WHERE f.kode_produk = '$data1[kode_barang]' AND f.no_reg is NULL ");
                
                $kdD = $db->query("SELECT f.nama_petugas, u.nama FROM tbs_fee_produk f INNER JOIN user u ON f.nama_petugas = u.id WHERE f.kode_produk = '$data1[kode_barang]' AND f.no_reg is NULL ");
                    
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

              if ($otoritas_tombol['edit_produk_apotek'] > 0) {

                echo"<td style='font-size:15px' align='right' class='edit-jumlah' data-id='".$data1['id']."'><span id='text-jumlah-".$data1['id']."'>". $data1['jumlah_barang'] ."</span> <input type='hidden' id='input-jumlah-".$data1['id']."' value='".$data1['jumlah_barang']."' class='input_jumlah' data-id='".$data1['id']."' autofocus='' data-kode='".$data1['kode_barang']."' data-tipe='".$data1['tipe_barang']."' data-harga='".$data1['harga']."' data-satuan='".$data1['satuan']."' data-tipe='".$data1['tipe_barang']."' > </td>";
              }
              else{
                echo"<td style='font-size:15px' align='right' class='tidak_punya_otoritas' data-id='".$data1['id']."'><span id='text-jumlah-".$data1['id']."'>". $data1['jumlah_barang'] ."</span> <input type='hidden' id='input-jumlah-".$data1['id']."' value='".$data1['jumlah_barang']."' class='input_jumlah' data-id='".$data1['id']."' autofocus='' data-kode='".$data1['kode_barang']."' data-tipe='".$data1['tipe_barang']."' data-harga='".$data1['harga']."' data-satuan='".$data1['satuan']."' data-tipe='".$data1['tipe_barang']."' > </td>";
              }


                echo "<td style='font-size:15px'>". $data1['nama'] ."</td>
                <td style='font-size:15px' align='right'>". rp($data1['harga']) ."</td>
                <td style='font-size:15px' align='right'><span id='text-subtotal-".$data1['id']."'>". rp($data1['subtotal']) ."</span></td>
                <td style='font-size:15px' align='right'><span id='text-potongan-".$data1['id']."'>". rp($data1['potongan']) ."</span></td>
                <td style='font-size:15px' align='right'><span id='text-tax-".$data1['id']."'>". rp($data1['tax']) ."</span></td>";

              if ($otoritas_tombol['hapus_produk_apotek'] > 0) {

                echo "<td style='font-size:15px'> <button class='btn btn-danger btn-sm btn-hapus-tbs' id='btn-hapus-id-".$data1['id']."' data-id='". $data1['id'] ."' data-kode-barang='". $data1['kode_barang'] ."' data-barang='". $data1['nama_barang'] ."' data-subtotal='". $data1['subtotal'] ."'>Hapus</button> </td>";
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
      

      <div class="row">
        <div class="col-xs-6">
          
           <label style="font-size:15px"> <b> Subtotal </b></label><br>
      <input style="height:25px;font-size:15px" type="text" name="total" id="total2" class="form-control" placeholder="Total" readonly="">

        </div>

                  <?php
                  $ambil_diskon_tax = $db->query("SELECT * FROM setting_diskon_tax");
                  $data_diskon = mysqli_fetch_array($ambil_diskon_tax);

                  ?>

            <div class="col-xs-6">
            <label>Biaya Admin </label><br>
            <input style="height:25px;font-size:15px" name="biaya_admin" type="text" id="biaya_admin"  placeholder="Biaya Admin" onkeydown="return numbersonly(this, event);" onkeyup="javascript:tandaPemisahTitik(this);" autocomplate="off" class="form-control">
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


           <input type="text" name="tax" id="tax" style="height:25px;font-size:15px;display: none" value="<?php echo $data_diskon['tax']; ?>" style="height:25px;font-size:15px" class="form-control" autocomplete="off" >


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
                      <select type="text" name="cara_bayar" id="carabayar1" class="form-control" required=""  style="font-size: 15px" >
                      <option value=""> Silahkan Pilih </option>
                         <?php 
                         
                         
                         $sett_akun = $db->query("SELECT sa.kas, da.nama_daftar_akun FROM setting_akun sa INNER JOIN daftar_akun da ON sa.kas = da.kode_daftar_akun");
                         $data_sett = mysqli_fetch_array($sett_akun);
                         
                         
                         
                         
                         $query = $db->query("SELECT nama_daftar_akun, kode_daftar_akun FROM daftar_akun WHERE tipe_akun = 'Kas & Bank'");
                         while($data = mysqli_fetch_array($query))
                         {
                         
                         
                         
                    if($data_sett['kas'] == $data['kode_daftar_akun'])
                         {
                          echo "<option selected value='".$data_sett['kas']."'>".$data_sett['nama_daftar_akun'] ."</option>";
                         }
                         else
                         {
                         echo "<option value='".$data['kode_daftar_akun']."'>".$data['nama_daftar_akun'] ."</option>";
                         }
                         
                         
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



      </div><!-- END card-block -->

       </div>

          
          
          <input style="height:15px" type="hidden" name="jumlah" id="jumlah1" class="form-control" placeholder="jumlah">
          
          
          <!-- memasukan teks pada kolom kode pelanggan, dan nomor faktur penjualan namun disembunyikan -->

          
          <input type="hidden" name="kode_pelanggan" id="k_pelanggan" class="form-control" required="" >
          <input type="hidden" name="ppn_input" id="ppn_input" value="Include" class="form-control" placeholder="ppn input">  
      

          <div class="row">
 
        <?php if ($otoritas_tombol['tombol_bayar_apotek'] > 0):?>  

          <button type="submit" id="penjualan" class="btn btn-info" style="font-size:15px">Bayar (F8)</button>
          <a class="btn btn-info" href="form_penjualan_kasir_apotek.php" id="transaksi_baru" style="display: none">  Transaksi Baru </a>

        <?php endif ?>
          
        <?php if ($otoritas_tombol['tombol_piutang_apotek'] > 0) :?>          
            
          <button type="submit" id="piutang" class="btn btn-warning" style="font-size:15px">Piutang (F9)</button>

        <?php endif ?>

          <a href='cetak_penjualan_piutang.php' id="cetak_piutang" style="display: none;" class="btn btn-success" target="blank">Cetak Piutang  </a>

     
          <a href='cetak_penjualan_tunai.php' id="cetak_tunai" style="display: none;" class="btn btn-primary" target="blank"> Cetak Tunai  </a>

         <?php if ($otoritas_tombol['tombol_batal_apotek'] > 0) :?> 

          <button type="submit" id="batal_penjualan" class="btn btn-danger" style="font-size:15px">  Batal (Ctrl + B)</button>

        <?php endif ?>

          <a href='cetak_penjualan_tunai_besar.php' id="cetak_tunai_besar" style="display: none;" class="btn btn-warning" target="blank"> Cetak Tunai  Besar </a>
          
     
    
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
  $(document).on('click', '.tidak_punya_otoritas', function (e) {
    alert("Anda Tidak Punya Otoritas Untuk Edit Jumlah Produk !!");
  });
</script>


<!--untuk memasukkan perintah java script-->
<script type="text/javascript">

// jika dipilih, nim akan masuk ke input dan modal di tutup
  $(document).on('click', '.pilih', function (e) {


  document.getElementById("kode_barang").value = $(this).attr('data-kode');
  document.getElementById("nama_barang").value = $(this).attr('nama-barang');
  document.getElementById("limit_stok").value = $(this).attr('limit_stok');
  document.getElementById("satuan_produk").value = $(this).attr('satuan');
  document.getElementById("ber_stok").value = $(this).attr('ber-stok');
  document.getElementById("harga_lama").value = $(this).attr('harga');
  document.getElementById("harga_baru").value = $(this).attr('harga');
  document.getElementById("satuan_konversi").value = $(this).attr('satuan');
  document.getElementById("id_produk").value = $(this).attr('id-barang');



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
  $("#harga_penjamin").val(harga_level_1);
}

else if (level_harga == "harga_2") {
  $("#harga_produk").val(harga_level_2);
  $("#harga_baru").val(harga_level_2);
  $("#harga_lama").val(harga_level_2);
  $("#harga_penjamin").val(harga_level_2);
}

else if (level_harga == "harga_3") {
  $("#harga_produk").val(harga_level_3);
  $("#harga_lama").val(harga_level_3);
  $("#harga_baru").val(harga_level_3);
  $("#harga_penjamin").val(harga_level_3);
}

else if (level_harga == "harga_4") {
  $("#harga_produk").val(harga_level_4);
  $("#harga_lama").val(harga_level_4);
  $("#harga_baru").val(harga_level_4);
  $("#harga_penjamin").val(harga_level_4);
}

else if (level_harga == "harga_5") {
  $("#harga_produk").val(harga_level_5);
  $("#harga_lama").val(harga_level_5);
  $("#harga_baru").val(harga_level_5);
  $("#harga_penjamin").val(harga_level_5);
}

else if (level_harga == "harga_6") {
  $("#harga_produk").val(harga_level_6);
  $("#harga_lama").val(harga_level_6);
  $("#harga_baru").val(harga_level_6);
  $("#harga_penjamin").val(harga_level_6);
}

else if (level_harga == "harga_7") {
  $("#harga_produk").val(harga_level_7);
  $("#harga_lama").val(harga_level_7);
  $("#harga_baru").val(harga_level_7);  
  $("#harga_penjamin").val(harga_level_7);
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
  var kode_barang = kode_barang.substr(0, kode_barang.indexOf('('));
  var satuan_konversi = $("#satuan_konversi").val();
  var jumlah_barang = $("#jumlah_barang").val();
  var id_produk = $("#id_produk").val();
$('#kolom_cek_harga').val('0');
$.post("cek_level_harga_barang.php", {level_harga:level_harga, kode_barang:kode_barang,jumlah_barang:jumlah_barang,id_produk:id_produk,satuan_konversi:satuan_konversi},function(data){

          $("#harga_produk").val(data);
          $("#harga_baru").val(data);
          $("#harga_penjamin").val(data);
          $('#kolom_cek_harga').val('1');
        });
    });
});
//end cek level harga
</script>



<!-- cek stok satuan konversi change-->
<script type="text/javascript">
  $(document).ready(function(){
    $("#satuan_konversi").change(function(){
      var jumlah_barang = $("#jumlah_barang").val();
      var satuan_konversi = $("#satuan_konversi").val();
      var kode_barang = $("#kode_barang").val();
      
  var kode_barang = kode_barang.substr(0, kode_barang.indexOf('('));
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
      var kode_barang = kode_barang.substr(0, kode_barang.indexOf('('));
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



<!--cek jatuh tempo keyup-->
<script type="text/javascript">
  $(document).ready(function(){
    $("#penjamin").change(function(){
      
      var penjamin = $("#penjamin").val();

      $.post("cek_jatuh_tempo.php",
        {penjamin:penjamin},function(data){

if (data != '1970-01-01' )
    {
      $("#tanggal_jt").val(data);
    }
    else
    {
     $("#tanggal_jt").val('');
    }

      });
    });
  });
</script>
<!--end cek jatuh tempo keyup-->


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


  var kode_barang = kode_barang.substr(0, kode_barang.indexOf('('));
      

      

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

   <script>
   //untuk menampilkan data yang diambil pada form tbs penjualan berdasarkan id=formtambahproduk
  $("#submit_produk").click(function(){

    var no_rm = $("#kd_pelanggan").val();
    if (no_rm != 'Umum') {
      var no_rm = no_rm.substr(0, no_rm.indexOf('('));
    }
    else
    {
        var no_rm = $("#kd_pelanggan").val();
    }
    
    var kode_barang = $("#kode_barang").val();
    var nama_barang = $("#nama_barang").val();

    var limit_stok = $("#limit_stok").val();

    var jumlah_barang = bersihPemisah(bersihPemisah(bersihPemisah(bersihPemisah($("#jumlah_barang").val()))));
    var harga = bersihPemisah(bersihPemisah(bersihPemisah(bersihPemisah($("#harga_produk").val()))));
    var potongan = bersihPemisah(bersihPemisah(bersihPemisah(bersihPemisah($("#potongan1").val()))));

    if (potongan == '') {
      potongan = 0;
    };

    var tax = bersihPemisah(bersihPemisah(bersihPemisah(bersihPemisah($("#tax1").val()))));
        if (tax == '') {
      tax = 0;
    };

    var jumlahbarang = bersihPemisah(bersihPemisah(bersihPemisah(bersihPemisah($("#jumlahbarang").val()))));
    var satuan = $("#satuan_konversi").val();
    
    var a = $(".tr-kode-"+kode_barang+"").attr("data-kode-barang");    
    var ber_stok = $("#ber_stok").val();
    var ppn = $("#ppn").val();
    var apoteker = $("#apoteker").val();
    var penjamin = $("#penjamin").val();
    var tax_faktur = bersihPemisah(bersihPemisah(bersihPemisah(bersihPemisah($("#tax").val()))));

    var stok = parseInt(jumlahbarang,10) - parseInt(jumlah_barang,10);






    var hargaa = bersihPemisah(bersihPemisah(bersihPemisah(bersihPemisah($("#harga_penjamin").val()))));

    var subtotal = bersihPemisah(bersihPemisah(bersihPemisah(bersihPemisah($("#total2").val()))));

    var biaya_admin = bersihPemisah(bersihPemisah(bersihPemisah(bersihPemisah($("#biaya_admin").val()))));

    var pot_fakt_per = bersihPemisah(bersihPemisah(bersihPemisah(bersihPemisah($("#potongan_persen").val()))));
    if (biaya_admin == '') {
      biaya_admin = 0;
    }

    var pot_fakt_rp = bersihPemisah(bersihPemisah(bersihPemisah(bersihPemisah($("#potongan_penjualan").val()))));

     if (subtotal == "") {
        subtotal = 0;
      };


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


    if (pot_fakt_per == 0) {
      var potongaaan = pot_fakt_rp;

      var pot_fakt_per = parseInt(potongaaan,10) / parseInt(total_akhir1,10) * 100;

    var total_akhier = parseInt(total_akhir1,10) - parseInt(pot_fakt_rp,10);


         //Hitung pajak
       /* if (tax_faktur != 0 ) {
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
      /*  if (tax_faktur != 0) {
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
       /* if (tax_faktur != 0) {
        var hasil_tax = parseInt(total_akhier,10) * parseInt(tax_faktur,10) / 100;

        }
        else
        {
        var hasil_tax = 0;
        }*/
    //end hitung pajak

    var total_akhir = parseInt(total_akhier,10) + parseInt(biaya_admin,10)


    }







if (jumlah_barang == ''){
  alert("Jumlah Barang Harus Diisi");
       $("#jumlah_barang").focus();
  }
else if (kode_barang == a) {
alert("Barang yang anda masukan sudah ada, silahkan pilih barang lain");
$("#kode_barang").val('');
      $("#kode_barang").trigger('chosen:open');
}


  else if (ber_stok == 'Jasa' || ber_stok == 'BHP')
  {

     $("#pembayaran_penjualan").val('');
     $("#sisa_pembayaran_penjualan").val('');
     $("#kredit").val('');

      $("#potongan_persen").val(Math.round(pot_fakt_per));
      $("#total1").val(tandaPemisahTitik(total_akhir));
      $("#potongan_penjualan").val(Math.round(potongaaan));
      $("#total2").val(tandaPemisahTitik(total_akhir1));
      /*$("#tax_rp").val(Math.round(hasil_tax));*/


          $.post("proses_tbs_apotek.php",{kode_barang:kode_barang,nama_barang:nama_barang,jumlah_barang:jumlah_barang,harga:harga,potongan:potongan,tax:tax,satuan:satuan,tipe_barang:ber_stok,no_rm:no_rm,apoteker:apoteker,penjamin:penjamin,tax:tax,hargaa:hargaa,ppn:ppn},function(data){ 
     

              $("#kode_barang").val('');
              $("#kode_barang").trigger("chosen:updated");

                 $("#ppn").attr("disabled", true);
                 $("#tbody").prepend(data);
                 $("#nama_barang").val('');
                 $("#jumlah_barang").val('');
                 $("#potongan1").val('');
                 $("#tax1").val('');
                 $("#tipe_barang").val('');
                 $("#harga_penjamin").val('');
                $(".chosen").chosen({no_results_text: "Maaf, Data Tidak Ada!"}); 
              $("#kode_barang").trigger('chosen:open');

                 
                 });


  
  } 


  else{


    if (stok < 0 && ber_stok == 'Barang') {

    alert ("Jumlah Melebihi Stok Barang !");
    $("#jumlah_barang").val('');
    $("#jumlah_barang").focus();
  }


else{

    $("#pembayaran_penjualan").val('');
     $("#sisa_pembayaran_penjualan").val('');
     $("#kredit").val('');

       $("#potongan_persen").val(Math.round(pot_fakt_per));
      $("#total1").val(tandaPemisahTitik(total_akhir));
      $("#potongan_penjualan").val(Math.round(potongaaan));
      $("#total2").val(tandaPemisahTitik(total_akhir1));
     /* $("#tax_rp").val(Math.round(hasil_tax));*/


      if (limit_stok > stok)
        {
          alert("Persediaan Barang Ini Sudah Mencapai Batas Limit Stok, Segera Lakukan Pembelian !");
        }

    $.post("proses_tbs_apotek.php",{kode_barang:kode_barang,nama_barang:nama_barang,jumlah_barang:jumlah_barang,harga:harga,potongan:potongan,tax:tax,satuan:satuan,tipe_barang:ber_stok,no_rm:no_rm,apoteker:apoteker,penjamin:penjamin,hargaa:hargaa,ppn:ppn},function(data){
     

     $("#ppn").attr("disabled", true);
     $("#tbody").prepend(data);
     $("#nama_barang").val('');
     $("#jumlah_barang").val('');
     $("#potongan1").val('');
     $("#tax1").val('');
     $("#tipe_barang").val('');
     $("#kode_barang").val('');
     $("#kode_barang").trigger('chosen:open');

     $("#harga_penjamin").val('');

     
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
<!--  end script untuk akhir detail layanan PERUSAHAAN -->


<script type="text/javascript">


//menampilkan no urut faktur setelah tombol click di pilih
      $("#cari_produk_penjualan").click(function() {

      
      $.get('no_faktur_jl.php', function(data) {
      /*optional stuff to do after getScript */ 
      $("#nomor_faktur_penjualan").val(data);
      });
      //menyembunyikan notif berhasil
      $("#alert_berhasil").hide();
      $("#cetak_tunai").hide('');
      $("#cetak_tunai_besar").hide('');
      $("#cetak_piutang").hide('');
      });
     

   </script>




<script>
   //perintah javascript yang diambil dari form proses_bayar_beli.php dengan id=form_beli
  $("#penjualan").click(function(){

        var apoteker = $("#apoteker").val()
        var no_resep_dokter = $("#no_resep_dokter").val()
        var resep_dokter = $("#resep_dokter").val()
        var penjamin = $("#penjamin").val()
        var sisa_pembayaran = bersihPemisah(bersihPemisah(bersihPemisah(bersihPemisah($("#sisa_pembayaran_penjualan").val()))));
        var kredit = bersihPemisah(bersihPemisah(bersihPemisah(bersihPemisah($("#kredit").val())))); 
        var kode_pelanggan = $("#kd_pelanggan").val();
        if (kode_pelanggan == 'Umum')
        {
           var kode_pelanggan = $("#kd_pelanggan").val();
        }
        else
        {
            var kode_pelanggan = kode_pelanggan.substr(0, kode_pelanggan.indexOf('('));
        }
        var tanggal_jt = $("#tanggal_jt").val();
        var total = bersihPemisah(bersihPemisah(bersihPemisah(bersihPemisah($("#total1").val())))); 
        var total2 = bersihPemisah(bersihPemisah(bersihPemisah(bersihPemisah( $("#total2").val() )))); 
        var potongan =  bersihPemisah(bersihPemisah(bersihPemisah(bersihPemisah($("#potongan_penjualan").val()))));
        var potongan_persen = $("#potongan_persen").val();
       /* var tax = bersihPemisah(bersihPemisah(bersihPemisah(bersihPemisah($("#tax_rp").val()))));*/
        var cara_bayar = $("#carabayar1").val();
        var pembayaran = bersihPemisah(bersihPemisah(bersihPemisah(bersihPemisah($("#pembayaran_penjualan").val()))));
        var total_hpp = $("#total_hpp").val();
        var harga = $("#harga_produk").val();
        var kode_gudang = $("#kode_gudang").val();
        var keterangan = $("#keterangan").val();
        var ber_stok = $("#ber_stok").val();
        var ppn_input = $("#ppn_input").val();
        var ppn = $("#ppn").val();
        var biaya_admin = bersihPemisah(bersihPemisah(bersihPemisah(bersihPemisah($("#biaya_admin").val()))));


        
        var sisa = pembayaran - total;
        
        var sisa_kredit = total - pembayaran;

 if (sisa_pembayaran < 0)
 {

  alert("Jumlah Pembayaran Tidak Mencukupi");

 }
  else if (kode_pelanggan == ''){
  alert("Kode Pelanggan Harus Dipilih");
         $("#kd_pelanggan").val(kode_pelanggan);

  }

   else if (kode_gudang == "")
 {

alert(" Kode Gudang Harus Diisi ");

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
  $("#batal_penjualan").hide();
  $("#piutang").hide();
  $("#transaksi_baru").show();



 $.post("cek_subtotal_apotek.php",{total:total,biaya_admin:biaya_admin,potongan:potongan/*,tax:tax*/},function(data) {

  if (data == 1) {


 $.post("proses_bayar_jual_apotek.php",{biaya_admin:biaya_admin,total2:total2,sisa_pembayaran:sisa_pembayaran,kredit:kredit,kode_pelanggan:kode_pelanggan,tanggal_jt:tanggal_jt,total:total,potongan:potongan,potongan_persen:potongan_persen,cara_bayar:cara_bayar,pembayaran:pembayaran,sisa:sisa,sisa_kredit:sisa_kredit,total_hpp:total_hpp,harga:harga,kode_gudang:kode_gudang,keterangan:keterangan,ber_stok:ber_stok,ppn_input:ppn_input,apoteker:apoteker,no_resep_dokter:no_resep_dokter,resep_dokter:resep_dokter,penjamin:penjamin},function(info) {

if (info == 1)
{

   alert("Maaf Subtotal Penjualan Tidak Sesuai, Silakan Tunggu Sebentar! (2) ");       
        window.location.href="form_penjualan_kasir_apotek.php";

}

else{
     $("#table-baru").html(info);
     var no_faktur = info;
     var kode_pelanggan = $('#kd_pelanggan').val();
     var kode_pelanggan = kode_pelanggan.substr(0, kode_pelanggan.indexOf('('));
     $("#cetak_tunai").attr('href', 'cetak_penjualan_tunai.php?no_faktur='+no_faktur+'');
     $("#cetak_tunai_besar").attr('href', 'cetak_besar_apotek.php?no_faktur='+no_faktur+'');
     $("#alert_berhasil").show();
     $("#pembayaran_penjualan").val('');
     $("#sisa_pembayaran_penjualan").val('');
     $("#kredit").val('');
     $("#apoteker").val('')
     $("#no_resep_dokter").val('')
     $("#resep_dokter").val('')
     $("#penjamin").val('')
     $("#apoteker").val('')
     $("#no_resep_dokter").val('')
     $("#resep_dokter").val('')
     $("#penjamin").val('')
     $("#cetak_tunai").show();
     $("#cetak_tunai_besar").show('');
    }
       
   });
}
  else{



    alert("Maaf Subtotal Penjualan Tidak Sesuai, Silakan Tunggu Sebentar! (1) ");       
        window.location.href="form_penjualan_kasir_apotek.php";
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

        var biaya_admin = bersihPemisah(bersihPemisah(bersihPemisah(bersihPemisah($("#biaya_admin").val()))));
        var apoteker = $("#apoteker").val();
        var no_resep_dokter = $("#no_resep_dokter").val();
        var resep_dokter = $("#resep_dokter").val();
        var penjamin = $("#penjamin").val();
        var sisa_pembayaran = bersihPemisah(bersihPemisah(bersihPemisah(bersihPemisah($("#sisa_pembayaran_penjualan").val()))));
        var kredit = bersihPemisah(bersihPemisah(bersihPemisah(bersihPemisah($("#kredit").val() )))); 
        var kode_pelanggan = $("#kd_pelanggan").val();
        var tanggal_jt = $("#tanggal_jt").val();
        var total = bersihPemisah(bersihPemisah(bersihPemisah(bersihPemisah($("#total1").val())))); 
        var total2 = bersihPemisah(bersihPemisah(bersihPemisah(bersihPemisah($("#total2").val())))); 
        var potongan =  bersihPemisah(bersihPemisah(bersihPemisah(bersihPemisah($("#potongan_penjualan").val()))));
        var potongan_persen = $("#potongan_persen").val();
        var tax = bersihPemisah(bersihPemisah(bersihPemisah(bersihPemisah($("#tax_rp").val()))));
        var cara_bayar = $("#carabayar1").val();
        var pembayaran = bersihPemisah(bersihPemisah(bersihPemisah(bersihPemisah($("#pembayaran_penjualan").val()))));
        if (pembayaran == '') {
          pembayaran = 0;
        }
        var total_hpp = $("#total_hpp").val();
        var kode_gudang = $("#kode_gudang").val();
        
        var keterangan = $("#keterangan").val();   
        var ber_stok = $("#ber_stok").val();
        var ppn_input = $("#ppn_input").val();
       
       var sisa =  pembayaran - total; 

       var sisa_kredit = total - pembayaran;
      
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
        $("#transaksi_baru").show();
     
 $.post("cek_subtotal_apotek.php",{total:total,biaya_admin:biaya_admin,potongan:potongan/*,tax:tax*/},function(data) {

  if (data == 1) {

$.post("proses_bayar_jual_apotek.php",{biaya_admin:biaya_admin,total2:total2,sisa_pembayaran:sisa_pembayaran,kredit:kredit,kode_pelanggan:kode_pelanggan,tanggal_jt:tanggal_jt,total:total,potongan:potongan,potongan_persen:potongan_persen,tax:tax,cara_bayar:cara_bayar,pembayaran:pembayaran,sisa:sisa,sisa_kredit:sisa_kredit,total_hpp:total_hpp,kode_gudang:kode_gudang,keterangan:keterangan,ber_stok:ber_stok,ppn_input:ppn_input,apoteker:apoteker,no_resep_dokter:no_resep_dokter,resep_dokter:resep_dokter,penjamin:penjamin},function(info) {

     $("#table-baru").html(info);
            var no_faktur = info;
            $("#cetak_piutang").attr('href','cetak_penjualan_piutang.php?no_faktur='+no_faktur+'');
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
            
       
       
       });

  }
  else{
    alert("Maaf Subtotal Penjualan Tidak Sesuai, Silakan Tunggu Sebentar!");       
        window.location.href="form_penjualan_kasir_apotek.php";
  }

 });


}  
       //mengambil no_faktur pembelian agar berurutan

       });
 $("form").submit(function(){
       return false;
       });

              $("#piutang").mouseleave(function(){
               
              
               var kode_pelanggan = $("#kd_pelanggan").val();
               if (kode_pelanggan == ""){
               $("#kd_pelanggan").attr("disabled", false);
               }
               
               });
  </script>   


  <script type="text/javascript">
//berfunsi untuk mencekal username ganda
 $(document).ready(function(){
  $(document).on('click', '.pilih', function (e) {
    var session_id = $("#session_id").val();
    var kode_barang = $("#kode_barang").val();
    var kode_barang = kode_barang.substr(0, kode_barang.indexOf('('));
 $.post('cek_tbs_penjualan_apotek.php',{kode_barang:kode_barang, session_id:session_id}, function(data){
  
  if(data == 1){
    alert("Anda Tidak Bisa Menambahkan Barang Yang Sudah Ada, Silakan Edit atau Pilih Barang Yang Lain !");
    $("#kode_barang").trigger('chosen:open');
    $("#kode_barang").val('');
    $("#nama_barang").val('');
   }//penutup if

    });////penutup function(data)

    });//penutup click(function()
  });//penutup ready(function()
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
      /*  var tax = $("#tax").val();
        var tax_rp = bersihPemisah(bersihPemisah(bersihPemisah(bersihPemisah($("#tax_rp").val()))));*/

       var biaya_admin = bersihPemisah(bersihPemisah(bersihPemisah(bersihPemisah($("#biaya_admin").val()))));
        if (biaya_admin == '')
        {
          biaya_admin = 0;
        }

    /*     if (tax == "") {
        tax = 0;
      }*/

      
        var sisa_potongan = parseInt(total,10) - parseInt(Math.round(potongan_penjualan,10));


           /*  var t_tax = ((parseInt(sisa_potongan,10) * parseInt(tax,10)) / 100);*/

             var hasil_akhir = parseInt(sisa_potongan, 10) + parseInt(biaya_admin,10);

            // hitungan jika potongan lebih dari 100 % 
        /*  var taxxx = ((parseInt(total,10) * parseInt(tax,10)) / 100); */

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
          $("#potongan_persen").val('')
          $("#potongan_penjualan").val('')
          $("#total1").val(tandaPemisahTitik(Math.round(toto)));
        /*  $("#tax_rp").val(Math.round(taxxx));*/

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
               /*   $("#tax_rp").val(Math.round(t_tax)); */
        }

      });

        $("#potongan_penjualan").keyup(function(){

        var potongan_penjualan = bersihPemisah(bersihPemisah(bersihPemisah(bersihPemisah( $("#potongan_penjualan").val() ))));
    
        var pembayaran = bersihPemisah(bersihPemisah(bersihPemisah(bersihPemisah($("#pembayaran_penjualan").val()))));
        if (pembayaran == '') {
          pembayaran = 0;
        }
        var total1 = bersihPemisah(bersihPemisah(bersihPemisah(bersihPemisah( $("#total1").val() ))));
        var total = bersihPemisah(bersihPemisah(bersihPemisah(bersihPemisah($("#total2").val()))));
        var potongan_persen = ((potongan_penjualan / total) * 100);
      /*  var tax = $("#tax").val();
        var tax_rp = bersihPemisah(bersihPemisah(bersihPemisah(bersihPemisah($("#tax_rp").val()))));

        if (tax == "") {
        tax = 0;
      }*/
       var biaya_admin = bersihPemisah(bersihPemisah(bersihPemisah(bersihPemisah($("#biaya_admin").val()))));
        if (biaya_admin == '')
        {
          biaya_admin = 0;
        }

        var sisa_potongan = total - Math.round(potongan_penjualan);
       /* var t_tax = ((parseInt(sisa_potongan,10) * parseInt(tax,10)) / 100); */
        var hasil_akhir = parseInt(sisa_potongan, 10) + parseInt(biaya_admin,10);
        
             

            // hitungan jika potongan lebih dari 100 %
           /* var taxxx = ((parseInt(total,10) * parseInt(tax,10)) / 100); */
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
            /*$("#tax_rp").val(Math.round(taxxx))*/
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
        /*$("#tax_rp").val(Math.round(t_tax))*/
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


        });
        
        </script>

  <script type="text/javascript">
  $(document).ready(function(){ 

      $("#biaya_admin").keyup(function(){

        var potongan = bersihPemisah(bersihPemisah(bersihPemisah(bersihPemisah($("#potongan_penjualan").val() ))));
        var potongan_persen = $("#potongan_persen").val();
        var total = bersihPemisah(bersihPemisah(bersihPemisah(bersihPemisah($("#total2").val() ))));
        var biaya_admin = bersihPemisah(bersihPemisah(bersihPemisah(bersihPemisah($("#biaya_admin").val()))));
        var tax = $("#tax_rp").val();
        if (tax == "") {
          tax = 0;
        }
        var pembayaran = bersihPemisah(bersihPemisah(bersihPemisah(bersihPemisah($("#pembayaran_penjualan").val()))));
        if (pembayaran == "") {
          pembayaran = 0;
        }
        var cara_bayar = $("#carabayar1").val();
        var t_total = parseInt(total,10)  - potongan;

              if (biaya_admin == "") {
                biaya_admin = 0;
              }
              else if (cara_bayar == "") {
                alert ("Kolom Cara Bayar Masih Kosong");
                 $("#biaya_admin").val('');
                 $("#potongan_penjualan").val('');
                 $("#potongan_persen").val('');
              }
              

              var total_akhir = parseInt(bersihPemisah(bersihPemisah(bersihPemisah(bersihPemisah(t_total,10))))) + parseInt(biaya_admin,10);

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
              
              
              $("#total1").val(tandaPemisahTitik(total_akhir));


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




    <script type="text/javascript">
    $(document).ready(function(){
      
//fungsi hapus data 
$(document).on('click','.btn-hapus-tbs',function(e){

      var no_reg = $("#no_reg").val();
      var nama_barang = $(this).attr("data-barang");
      var id = $(this).attr("data-id");
      var kode_barang = $(this).attr("data-kode-barang");
      var subtotal = $(this).attr("data-subtotal");
      var biaya_adm = bersihPemisah(bersihPemisah(bersihPemisah(bersihPemisah($("#biaya_admin").val()))));

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
    $.post("hapustbs_penjualan_apotek.php",{id:id,kode_barang:kode_barang,no_reg:no_reg},function(data){



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



<!-- AUTOCOMPLETE Pelanggan/pasien-->

<script>
$(function() {
    $( "#kd_pelanggan" ).autocomplete({
        source: 'kode_pelanggan_autocomplete.php'
    });
});
</script>
<!-- AUTOCOMPLETE -->

<script type="text/javascript">
  $("#penjamin").change(function(){

    var penjamin = $(this).val();
    var kode_barang = $("#kode_barang").val();
    var kode_barang = kode_barang.substr(0, kode_barang.indexOf('('));

    $.post("cek_harga_penjamin.php",{penjamin:penjamin,kode_barang:kode_barang},function(data){
          $("#harga_produk").val(data);
          $("#harga_baru").val(data);
          $("#harga_penjamin").val(data);
    });
  });
  </script>

<!--
    $("#jumlah_barang").focus(function(){
    var penjamin = $("#penjamin").val();
    var kode_barang = $("#kode_barang").val();
    var kode_barang = kode_barang.substr(0, kode_barang.indexOf('('));

    $.post("cek_harga_penjamin.php",{penjamin:penjamin,kode_barang:kode_barang},function(data){
      $("#harga_penjamin").val(data);
    });

  });
*//
-->

<!--
<script type="text/javascript">
        $(document).ready(function(){
        $("#kode_barang").blur(function(){

          var kode_barang = $(this).val();

          var kode_barang = kode_barang.substr(0, kode_barang.indexOf('('));
          var level_harga = $("#level_harga").val();
          var session_id = $("#session_id").val();
          
         var penjamin = $("#penjamin").val();
/*
          $.post("cek_harga_penjamin.php",{penjamin:penjamin,kode_barang:kode_barang},function(data){
            $("#harga_penjamin").val(data);
          });
          */

             $.post('cek_kode_barang_tbs_penjualan_apotek.php',{kode_barang:kode_barang,session_id:session_id}, function(data){
          
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
        $("#harga_penjamin").val(json.harga_jual)
        }
        else if (level_harga == "harga_2") {

        $('#harga_produk').val(json.harga_jual2);
        $('#harga_baru').val(json.harga_jual2);
        $('#harga_lama').val(json.harga_jual2);
        $("#harga_penjamin").val(json.harga_jual2)
        }
        else if (level_harga == "harga_3") {

        $('#harga_produk').val(json.harga_jual3);
        $('#harga_baru').val(json.harga_jual3);
        $('#harga_lama').val(json.harga_jual3);
        $("#harga_penjamin").val(json.harga_jual3)
        }
        else if (level_harga == "harga_4") {

        $('#harga_produk').val(json.harga_jual4);
        $('#harga_baru').val(json.harga_jual4);
        $('#harga_lama').val(json.harga_jual4);
        $("#harga_penjamin").val(json.harga_jual4)
        }
        else if (level_harga == "harga_5") {

        $('#harga_produk').val(json.harga_jual5);
        $('#harga_baru').val(json.harga_jual5);
        $('#harga_lama').val(json.harga_jual5);
        $("#harga_penjamin").val(json.harga_jual5)
        }
        else if (level_harga == "harga_6") {

        $('#harga_produk').val(json.harga_jual6);
        $('#harga_baru').val(json.harga_jual6);
        $('#harga_lama').val(json.harga_jual6);
        $("#harga_penjamin").val(json.harga_jual6)
        }
        else if (level_harga == "harga_7") {

        $('#harga_produk').val(json.harga_jual7);
        $('#harga_baru').val(json.harga_jual7);
        $('#harga_lama').val(json.harga_jual7);
        $("#harga_penjamin").val(json.harga_jual7)
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

  });                                              
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

    $.post('ambil_jumlah_produk.php',{kode_barang:kode_barang}, function(data){
      if (data == "") {
        data = 0;
      }
      $("#jumlahbarang").val(data);
    });


$.post('cek_kode_barang_tbs_penjualan_apotek.php',{kode_barang:kode_barang}, function(data){
          
  if(data == 1){
          alert("Anda Tidak Bisa Menambahkan Barang Yang Sudah Ada, Silakan Edit atau Pilih Barang Yang Lain !");

          $("#kode_barang").chosen("destroy");
          $("#kode_barang").val('');
          $("#nama_barang").val('');
          $("#kode_barang").trigger('chosen:open');
          $(".chosen").chosen({no_results_text: "Maaf, Data Tidak Ada!"}); 
   }//penutup if     

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




  });
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

<!--
     <script>
       //perintah javascript yang diambil dari form proses_bayar_beli.php dengan id=form_beli
       $("#simpan_sementara").click(function(){
       
        var session_id = $("#session_id").val();
        var no_faktur = $("#nomor_faktur_penjualan").val();
        var sisa_pembayaran = bersihPemisah(bersihPemisah(bersihPemisah(bersihPemisah( $("#sisa_pembayaran_penjualan").val() ))));
        var kredit = bersihPemisah(bersihPemisah(bersihPemisah(bersihPemisah( $("#kredit").val() )))); 
        var kode_pelanggan = $("#kd_pelanggan").val();
        var tanggal_jt = $("#tanggal_jt").val();
        var total = bersihPemisah(bersihPemisah(bersihPemisah(bersihPemisah( $("#total1").val() )))); 
        var total2 = bersihPemisah(bersihPemisah(bersihPemisah(bersihPemisah( $("#total2").val() )))); 
        var potongan =  bersihPemisah(bersihPemisah(bersihPemisah(bersihPemisah( $("#potongan_penjualan").val() ))));
        var potongan_persen = $("#potongan_persen").val();
        var tax = $("#tax_rp").val();
        var cara_bayar = $("#carabayar1").val();
        var pembayaran = bersihPemisah(bersihPemisah(bersihPemisah(bersihPemisah( $("#pembayaran_penjualan").val() ))));
        var total_hpp = $("#total_hpp").val();
        var kode_gudang = $("#kode_gudang").val();
        
        var keterangan = $("#keterangan").val();   
        var ber_stok = $("#ber_stok").val();
        var ppn_input = $("#ppn_input").val();
       
       var sisa =  pembayaran - total; 

       var sisa_kredit = total - pembayaran;


       
  if (kode_pelanggan == "") 
       {
       
       alert("Kode Pelanggan Harus Di Isi");
       
       }

         else if ( total == "") 
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

       $.post("proses_simpan_barang.php",{total2:total2,session_id:session_id,no_faktur:no_faktur,sisa_pembayaran:sisa_pembayaran,kredit:kredit,kode_pelanggan:kode_pelanggan,tanggal_jt:tanggal_jt,total:total,potongan:potongan,potongan_persen:potongan_persen,tax:tax,cara_bayar:cara_bayar,pembayaran:pembayaran,sisa:sisa,sisa_kredit:sisa_kredit,total_hpp:total_hpp,sales:sales,kode_gudang:kode_gudang,keterangan:keterangan,ber_stok:ber_stok,ppn_input:ppn_input},function(info) {

        
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
               
               $("#nomor_faktur_penjualan").val(data);
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
                                    if (jumlah_baru == '') {
                                      jumlah_baru = '0';
                                    }
                                    var kode_barang = $(this).attr("data-kode");
                                    var harga = $(this).attr("data-harga");
                                    var jumlah_lama = $("#text-jumlah-"+id+"").text();
                                    var satuan_konversi = $(this).attr("data-satuan");
                                    var tipe = $(this).attr("data-tipe");
                                    var ppn = $("#ppn").val();

                                    var subtotal_lama = bersihPemisah(bersihPemisah(bersihPemisah(bersihPemisah($("#text-subtotal-"+id+"").text()))));
                                    var potongan = bersihPemisah(bersihPemisah(bersihPemisah(bersihPemisah($("#text-potongan-"+id+"").text()))));

                                    var tax = bersihPemisah(bersihPemisah(bersihPemisah(bersihPemisah($("#text-tax-"+id+"").text()))));
                                   
                                    var subtotal = harga * jumlah_baru - potongan;

                                    var subtotal_penjualan = bersihPemisah(bersihPemisah(bersihPemisah(bersihPemisah($("#total2").val()))));

                                    subtotal_penjualan = subtotal_penjualan - subtotal_lama + subtotal;


                                    var pot_fakt_rp = bersihPemisah(bersihPemisah(bersihPemisah(bersihPemisah($("#potongan_penjualan").val()))));

                                    var pot_fakt_per = bersihPemisah(bersihPemisah(bersihPemisah(bersihPemisah($("#potongan_persen").val()))));
                                    var potongaaan = pot_fakt_per;
                                          var pos = potongaaan.search("%");
                                          var potongan_persen = bersihPemisah(bersihPemisah(bersihPemisah(bersihPemisah(potongaaan))));
                                              potongan_persen = potongan_persen.replace("%","");
                                          potongaaan = subtotal_penjualan * potongan_persen / 100;
                                          $("#potongan_penjualan").val(potongaaan);
                                    
                                          var biaya_admin = bersihPemisah(bersihPemisah(bersihPemisah(bersihPemisah($("#biaya_admin").val()))));
                                          if (biaya_admin == '')
                                          {
                                            biaya_admin = 0;
                                          }
                                         /* var tax_faktur = $("#tax").val();
                                            if(tax_faktur == '')
                                            {
                                              tax_faktur = 0;
                                            }*/

                                    var sub_akhir = parseInt(subtotal_penjualan,10) - parseInt(potongaaan,10) + parseInt(biaya_admin,10) ;



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
                                     /*var t_tax = ((parseInt(bersihPemisah(bersihPemisah(bersihPemisah(bersihPemisah(sub_akhir,10))))) * parseInt(bersihPemisah(bersihPemisah(bersihPemisah(bersihPemisah(tax_faktur)))))) / 100);*/

                         

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

                                                        $("#text-subtotal-"+id+"").text(tandaPemisahTitik(subtotal));
                                                        $("#btn-hapus-id-"+id+"").attr("data-subtotal",subtotal);
                                                        $("#text-tax-"+id+"").text(Math.round(jumlah_tax));
                                                        $("#input-jumlah-"+id+"").attr("type", "hidden"); 
                                                        $("#total2").val(tandaPemisahTitik(subtotal_penjualan));
                                                        $("#potongan_penjualan").val(Math.round(potongaaan));
                                                        $("#total1").val(tandaPemisahTitik(total_akhir));
                                                      /* $("#tax_rp").val(tandaPemisahTitik(Math.round(t_tax))); */
                                                       $("#pembayaran_penjualan").val('');
                                                       $("#sisa_pembayaran_penjualan").val('');
                                                       $("#kredit").val('');
                                                       
                                                         $.post("update_pesanan_barang_apotek.php",{jumlah_lama:jumlah_lama,tax:tax,id:id,jumlah_baru:jumlah_baru,kode_barang:kode_barang,potongan:potongan,harga:harga,jumlah_tax:jumlah_tax,subtotal:subtotal},function(info){
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
                                                        $("#btn-hapus-id-"+id+"").attr("data-subtotal",subtotal);
                                                        $("#text-tax-"+id+"").text(Math.round(jumlah_tax));
                                                        $("#input-jumlah-"+id+"").attr("type", "hidden"); 
                                                        $("#total2").val(tandaPemisahTitik(subtotal_penjualan));
                                                        $("#potongan_penjualan").val(Math.round(potongaaan));
                                                        $("#total1").val(tandaPemisahTitik(total_akhir));
                                                        /*$("#tax_rp").val(tandaPemisahTitik(Math.round(t_tax)));*/
                                                       $("#pembayaran_penjualan").val('');
                                                       $("#sisa_pembayaran_penjualan").val('');
                                                       $("#kredit").val('');

                                                         $.post("update_pesanan_barang_apotek.php",{jumlah_lama:jumlah_lama,tax:tax,id:id,jumlah_baru:jumlah_baru,kode_barang:kode_barang,potongan:potongan,harga:harga,jumlah_tax:jumlah_tax,subtotal:subtotal},function(info){

                                                        
                                                        



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
    $.get("cek_ppn_ex_apotek.php",function(data){
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
        window.location.href="batal_penjualan_apotek.php";

  })
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


        window.location.href="batal_penjualan_apotek.php";


    }); 
</script>

<!-- SHORTCUT -->


<script type="text/javascript">
  $(document).ready(function(){
var pot_fakt_per = bersihPemisah(bersihPemisah(bersihPemisah(bersihPemisah($("#potongan_persen").val()))));
var pot_fakt_rp = bersihPemisah(bersihPemisah(bersihPemisah(bersihPemisah($("#potongan_penjualan").val()))));

    $.get("cek_total_seluruh_apotek.php",function(data1){

        if (data1 == 1) {
                 $.get("cek_coba.php",function(data){
                data = data.replace(/\s+/g, '');
                  $("#total2").val(tandaPemisahTitik(data))

              if (pot_fakt_per == '0%') {
              var potongaaan = pot_fakt_rp;
              var potongaaan = parseInt(potongaaan,10) / parseInt(data,10) * 100;
              $("#potongan_persen").val(Math.round(potongaaan));

             var total = parseInt(data,10) - parseInt(pot_fakt_rp,10)

              $("#total1").val(tandaPemisahTitik(total))

            }
            else if(pot_fakt_rp == 0)
            {
                  var potongaaan = pot_fakt_per;
                  var pos = potongaaan.search("%");
                  var potongan_persen = bersihPemisah(bersihPemisah(bersihPemisah(bersihPemisah(potongaaan))));
                  potongan_persen = potongan_persen.replace("%","");
                  potongaaan = data * potongan_persen / 100;
                  $("#potongan_penjualan").val(potongaaan);

                  var total = parseInt(data,10) - parseInt(potongaaan,10)

                  $("#total1").val(tandaPemisahTitik(total))

            }

                });
        }

        else
        {

        }




      });

  });

</script>

<script type="text/javascript">
$(document).ready(function(){
  //end cek level harga
  $("#level_harga").change(function(){
  
  var level_harga = $("#level_harga").val();
  var kode_barang = $("#kode_barang").val();
  var kode_barang = kode_barang.substr(0, kode_barang.indexOf('('));


$.post("cek_level_harga_apotek.php", {level_harga:level_harga,kode_barang:kode_barang},function(data){

          $("#harga_produk").val(data);
          $("#harga_baru").val(data);
          $("#harga_penjamin").val(data);
        });
    });
});
//end cek level harga
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
              $(nRow).attr('data-kode', aData[0]+"("+aData[1]+")");
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

 
<!-- memasukan file footer.php -->
<?php include 'footer.php'; ?>