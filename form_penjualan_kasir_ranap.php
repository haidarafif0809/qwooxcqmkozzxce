<?php include_once 'session_login.php';
 

// memasukan file session login,  header, navbar, db.php,
include 'header.php';
include 'navbar.php';
include 'db.php';
include 'sanitasi.php';


$no_reg = stringdoang($_GET['no_reg']);

if (isset($_GET['analis'])) {
  
$analis = stringdoang($_GET['analis']);
}
else
{
  $analis = '';
}


$ambil_data = $db->query("SELECT * FROM registrasi WHERE no_reg = '$no_reg'");
$aray = mysqli_fetch_array($ambil_data);



$ss = $db->query("SELECT harga,jatuh_tempo FROM penjamin WHERE nama = '$aray[penjamin]' ");
$data_level = mysqli_fetch_array($ss);
$level_harga = $data_level['harga'];

$hari = $data_level['jatuh_tempo'];
$now = strtotime(date("Y-m-d"));

$take_jt = date('Y-m-d', strtotime('+ '.$hari.' day', $now));
      if ($take_jt == '1970-01-01' )
      {
        $take_jt = "";
      }


$sum_op = $db->query("SELECT SUM(harga_jual) AS total_operasi FROM tbs_operasi WHERE no_reg = '$no_reg' ");
$data_op = mysqli_fetch_array($sum_op);


// menampilkan seluruh data yang ada pada tabel penjualan yang terdapt pada DB
 $perintah = $db->query("SELECT * FROM penjualan");


$session_id = session_id();
$user = $_SESSION['nama'];
$id_user = $_SESSION['id'];

 
$sum_lab = $db->query("SELECT SUM(subtotal) AS total_lab FROM tbs_penjualan WHERE lab = 'Laboratorium' AND no_reg = '$no_reg' ");
$data_lab = mysqli_fetch_array($sum_lab);


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

.padding {

padding-left: 5%;
padding-right: 5%;


}

</style>


<script>
  $(function() {
    $( "#tanggal_jt" ).datepicker({dateFormat: "yy-mm-dd"});
  });
  </script>

<!--untuk membuat agar tampilan form terlihat rapih dalam satu tempat -->

<div class="padding" >

  <h3> FORM PENJUALAN RAWAT INAP</h3>


<div class="row">

<div class="col-sm-8">


 <!-- membuat form menjadi beberpa bagian -->
  <form enctype="multipart/form-data" role="form" action="formpenjualan.php" method="post ">
        
  <!--membuat teks dengan ukuran h3-->      

        <div class="form-group">
      <input type="hidden" name="session_id" id="session_id" class="form-control" value="<?php echo session_id(); ?>" readonly="">
        </div>

<div class="row">

<div class="col-sm-2">
    <label>No RM Pasien</label><br>
  <input type="text" name="no_rm" style="height:15px;" id="no_rm" class="form-control" value="<?php echo $aray['no_rm'] ?> | <?php echo $aray['nama_pasien'] ?>" readonly="" autofocus="">  
   <input type="hidden" name="nama_pasien" style="height:15px;" id="nama_pasien" class="form-control" value="<?php echo $aray['nama_pasien'] ?>" readonly="" autofocus="">  
</div>

    <input type="hidden" readonly="" style="font-size:15px; height:15px" name="total_lab" id="total_lab" value="<?php echo $data_lab['total_lab']; ?>" class="form-control" >

<div class="col-sm-2">
          <label> Gudang </label><br>
          
          <select name="kode_gudang" id="kode_gudang" class="form-control chosen"  >
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


<div class="col-sm-2">
          <label>PPN</label>
          <select style="font-size:15px; height:35px" name="ppn" id="ppn" class="form-control">
            <option value="Include">Include</option>  
            <option value="Exclude">Exclude</option>
            <option value="Non">Non</option>          
          </select>
</div>

<div class="col-sm-1">
<label>Kasir  </label>
<input type="text" readonly="" style="font-size:15px; height:15px" name="sales" id="sales" value="<?php echo $user; ?>" class="form-control" >
</div>


<input type="hidden" readonly="" style="font-size:15px; height:15px" name="id_sales" id="id_sales" value="<?php echo $id_user; ?>" class="form-control" >

<input type="hidden" readonly="" style="font-size:15px; height:15px" name="total_operasi" id="total_operasi" value="<?php echo $data_op['total_operasi']; ?>" class="form-control" >

<div class="col-sm-2">
<label>Bed  </label>
<input type="text" readonly="" style="font-size:15px; height:15px" name="bed" id="bed"  value="<?php echo $aray['bed'];?>" class="form-control" >
</div>


<div class="col-sm-3">
<label>Dokter Pelaksana</label>
<select style="font-size:15px; height:35px" name="dokter" id="dokter" class="form-control chosen" >

  <?php 

    
    //untuk menampilkan semua data pada tabel pelanggan dalam DB
    $query01 = $db->query("SELECT nama,id FROM user WHERE tipe = '1' ");

    //untuk menyimpan data sementara yang ada pada $query
    while($data01 = mysqli_fetch_array($query01))
    {
    
      
    if ($data01['nama'] == $aray['dokter']) {
     echo "<option selected value='".$data01['id'] ."'>".$data01['nama'] ."</option>";
    }
    else{
      echo "<option value='".$data01['id'] ."'>".$data01['nama'] ."</option>";
    }

    
    }
    
    
    ?>

</select>
</div>



<div class="col-sm-3">
<label>Petugas Paramedik</label>
<select style="font-size:15px; height:35px" name="petugas_paramedik" id="petugas_paramedik" class="form-control chosen" >
<option value="">Cari Petugas</option>
     <?php 
    
    //untuk menampilkan semua data pada tabel pelanggan dalam DB
    $queri_para = $db->query("SELECT nama,id FROM user WHERE tipe_user = '2'");

    //untuk menyimpan data sementara yang ada pada $query
    while($data_paramedik = mysqli_fetch_array($queri_para))
    {
    
    $petugas = $db->query("SELECT nama_paramedik FROM penetapan_petugas WHERE nama_paramedik = '$data_paramedik[nama]'");
        $data_petugas = mysqli_fetch_array($petugas);

    if ($data_paramedik['nama'] == $data_petugas['nama_paramedik']) {
     echo "<option selected value='".$data_paramedik['id'] ."'>".$data_paramedik['nama'] ."</option>";
    }
    else{
      echo "<option value='".$data_paramedik['id'] ."'>".$data_paramedik['nama'] ."</option>";
    }

    
    }
    
    
    ?>

</select>
</div> 

 <div class="col-sm-9">
  </div>

<div class="col-sm-3">
<label>Dokter Penanggung Jawab</label>
<select style="font-size:15px; height:35px" name="dokter_pj" id="dokter_pj" class="form-control chosen" >
 <?php 

    
    //untuk menampilkan semua data pada tabel pelanggan dalam DB
    $query01 = $db->query("SELECT nama,id FROM user WHERE tipe = '1' ");

    //untuk menyimpan data sementara yang ada pada $query
    while($data01 = mysqli_fetch_array($query01))
    {
    
      
    if ($data01['nama'] == $aray['dokter_pengirim']) {
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

  <div class="col-sm-2">
    <label>No REG :</label>
    <input style="height:20px" readonly="" type="text" class="form-control" value="<?php echo $no_reg;?>" id="no_reg" name="no_reg" placeholder="No reg" autocomplete="off" >   
</div>

    <div class="form-group col-sm-2">
    <label for="email">Penjamin:</label>
    <select class="form-control" id="penjamin" name="penjamin" required="">
    <option value='<?php echo $aray['penjamin'];?>'><?php echo $aray['penjamin'];?></option>
      <?php    
     
      $query = $db->query("SELECT nama FROM penjamin");
      while ( $icd = mysqli_fetch_array($query))
      {
      echo "<option value='".$icd['nama']."'>".$icd['nama']."</option>";
      }
      ?>
    </select>
</div>


 <div class="col-sm-1">
    <label> Poli :</label>
    <input style="height:20px;" readonly="" type="text" class="form-control"  value="<?php echo $aray['poli'];?>" id="asal_poli" name="asal_poli" placeholder="Isi Poli" autocomplete="off" >   
</div>


<div class="col-sm-2">
    <label> Level Harga : </label><br>
  <select style="font-size:15px; height:35px" type="text" name="level_harga" id="level_harga" class="form-control"  >
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


 <div class="col-sm-2">
    <label> Kamar :</label>
    <input style="height:20px;" readonly="" type="text" class="form-control" value="<?php echo $aray['group_bed'];?>" id="kamar" name="kamar" placeholder="Isi Poli" autocomplete="off" >   
</div>


<div class="col-sm-3">
<label>Petugas Farmasi</label>
<select style="font-size:15px; height:35px" name="petugas_farmasi" id="petugas_farmasi" class="form-control chosen" >
<option value="">Cari Petugas</option>
  <?php 
    
    //untuk menampilkan semua data pada tabel pelanggan dalam DB
    $query01 = $db->query("SELECT nama,id FROM user WHERE tipe_user = '3'");

    //untuk menyimpan data sementara yang ada pada $query
    while($data01 = mysqli_fetch_array($query01))
    {
    
    $petugas = $db->query("SELECT nama_farmasi FROM penetapan_petugas WHERE nama_farmasi = '$data01[nama]'");
        $data_petugas = mysqli_fetch_array($petugas);

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


<div class="col-sm-3">
<label>Petugas Lain</label>
<select style="font-size:15px; height:35px" name="petugas_lain" id="petugas_lain" class="form-control chosen" >
<option value="">Cari Petugas</option>
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






</div>



  </form><!--tag penutup form-->

<button type="button" id="cari_produk_penjualan" class="btn btn-info " data-toggle="modal" data-target="#myModal"><i class='fa  fa-search'> Cari (F1)</i>  </button> 
<a href="form_penjualan_lab.php?no_rm=<?php echo $aray['no_rm'];?>&nama=<?php echo $aray['nama_pasien'];?>&no_reg=<?php echo $no_reg;?>&dokter=<?php echo $aray['dokter'];?>&jenis_penjualan=Rawat Inap" class="btn btn-default"> <i class="fa fa-flask"></i> Rujuk Lab</a> 

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

<div class="table-responsive">
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

<form class="form"  role="form" id="formtambahproduk">
<br>
<div class="row">

  <div class="col-sm-3">

  <input type="text" style="height:15px" class="form-control" name="kode_barang" autocomplete="off" id="kode_barang" placeholder="Kode Barang" >

  </div>

  <input type="hidden" class="form-control" name="nama_barang" autocomplete="off" id="nama_barang" placeholder="nama" >

  <div class="col-sm-2">
    <input style="height:15px;" type="text" class="form-control" name="jumlah_barang" autocomplete="off" id="jumlah_barang" placeholder="Jumlah">
  </div>

  <div class="col-sm-2">
          
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


   <div class="col-sm-2">
    <input style="height:15px;" type="text" class="form-control" name="potongan" autocomplete="off" id="potongan1" data-toggle="tooltip" data-placement="top" title="Jika Ingin Potongan Dalam Bentuk Persen (%), input : 10%" placeholder="Potongan">
  </div>

   <div class="col-sm-1">
    <input style="height:15px;" type="text" class="form-control" name="tax" autocomplete="off" id="tax1" placeholder="Tax%" >
  </div>


  <button type="submit" id="submit_produk" class="btn btn-success" style="font-size:15px" >Submit (F3)</button>

</div>

    <input type="hidden" class="form-control" name="limit_stok" autocomplete="off" id="limit_stok" placeholder="Limit Stok" >
    <input type="hidden" class="form-control" name="ber_stok" id="ber_stok" placeholder="Ber Stok" >
    <input type="hidden" class="form-control" name="harga_lama" id="harga_lama">
    <input type="hidden" class="form-control" name="harga_baru" id="harga_baru">
    <input type="hidden" class="form-control" name="jumlahbarang" id="jumlahbarang">
    <input type="hidden" id="satuan_produk" name="satuan" class="form-control" value="" >
    <input type="hidden" id="harga_produk" name="harga" class="form-control" value="" >
    <input type="hidden" id="id_produk" name="id_produk" class="form-control" value="" >   
    <input type="hidden" id="analis" name="analis" class="form-control" value="<?php echo $analis; ?>" >        

</form> <!-- tag penutup form -->





                <!--untuk mendefinisikan sebuah bagian dalam dokumen-->  
                <span id='tes'></span>            
                
                <div class="table-responsive"> <!--tag untuk membuat garis pada tabel-->  
                <span id="table-baru">  
                <table id="tableuser" class="table table-sm">
                <thead>
                <th> Kode  </th>
                <th > Nama </th>
                 <th >Fee Petugas</th>
                <th> Jumlah </th>
                <th> Satuan </th>
                <th align="right"> Harga </th>
                <th align="right"> Subtotal </th>
                <th align="right"> Potongan </th>
                <th align="right"> Pajak </th>
                <th align="right">Waktu</th>
               
                
                <th> Hapus </th>
                
                </thead>
                
                <tbody id="tbody">
                <?php
                
                //menampilkan semua data yang ada pada tabel tbs penjualan dalam DB
                $perintah = $db->query("SELECT tp.id,tp.kode_barang,tp.satuan,tp.nama_barang,tp.jumlah_barang,tp.harga,tp.subtotal,tp.potongan,tp.tax,s.nama,tp.tanggal,tp.jam,tp.no_reg,tp.tipe_barang FROM tbs_penjualan tp LEFT JOIN satuan s ON tp.satuan = s.id WHERE tp.no_reg = '$no_reg' AND tp.lab IS NULL ");
                
                //menyimpan data sementara yang ada pada $perintah
                
                while ($data1 = mysqli_fetch_array($perintah))
                {
                //menampilkan data
                echo "<tr class='tr-kode-". $data1['kode_barang'] ." tr-id-". $data1['id'] ."' data-kode-barang='".$data1['kode_barang']."'>
                <td style='font-size:15px'>". $data1['kode_barang'] ."</td>
                <td style='font-size:15px;'>". $data1['nama_barang'] ."</td>";

 $kd = $db->query("SELECT f.nama_petugas,u.nama FROM tbs_fee_produk f INNER JOIN user u ON f.nama_petugas = u.id WHERE f.kode_produk = '$data1[kode_barang]'  AND f.jam = '$data1[jam]' ");
  $kdD = $db->query("SELECT f.nama_petugas,u.nama FROM tbs_fee_produk f INNER JOIN user u ON f.nama_petugas = u.id WHERE f.kode_produk = '$data1[kode_barang]' AND  f.jam = '$data1[jam]' ");
  
 $nu = mysqli_fetch_array($kd);

if ($nu['nama'] != '')
{

echo "<td>";
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


                echo "<td style='font-size:15px' align='right' class='edit-jumlah' data-id='".$data1['id']."'><span id='text-jumlah-".$data1['id']."'>". $data1['jumlah_barang'] ."</span> <input type='hidden' id='input-jumlah-".$data1['id']."' value='".$data1['jumlah_barang']."' class='input_jumlah' data-id='".$data1['id']."' autofocus='' data-kode='".$data1['kode_barang']."' data-harga='".$data1['harga']."' data-tipe='".$data1['tipe_barang']."' data-satuan='".$data1['satuan']."' > </td>

                <td style='font-size:15px'>". $data1['nama'] ."</td>
                <td style='font-size:15px' align='right'>". rp($data1['harga']) ."</td>
                <td style='font-size:15px' align='right'><span id='text-subtotal-".$data1['id']."'>". rp($data1['subtotal']) ."</span></td>
                <td style='font-size:15px' align='right'><span id='text-potongan-".$data1['id']."'>". rp($data1['potongan']) ."</span></td>
                <td style='font-size:15px' align='right'><span id='text-tax-".$data1['id']."'>". rp($data1['tax']) ."</span></td>
          <td>". $data1['tanggal']." ".$data1['jam']."</td>";



               echo "<td style='font-size:15px'> <button class='btn btn-danger btn-sm btn-hapus-tbs' id='hapus-tbs-".$data1['id']."' data-id='". $data1['id'] ."' data-kode-barang='". $data1['kode_barang'] ."' data-barang='". $data1['nama_barang'] ."' data-subtotal='". $data1['subtotal'] ."'>Hapus</button> </td> 

                </tr>";


                }

                ?>
                </tbody>
                
                </table>
                </span>
                </div>

<div class="row">

<button class="btn btn-primary" type="button" data-toggle="collapse" data-target="#collapseExample" aria-expanded="false" aria-controls="collapseExample"><i class='fa fa-plus-circle'> </i>
Operasi  </button>


<button class="btn btn-primary" type="button" data-toggle="collapse" data-target="#collapseExampleLab" aria-expanded="false" aria-controls="collapseExampleLab"><i class='fa fa-stethoscope'> </i>
Laboratorium  </button>


</div>


 <div class="collapse" id="collapseExample">
<span id="tabel-operasi">
<div class="table-responsive">
<table id="tableuser" class="table table-bordered table-sm">
 
  <thead>
    <tr>

      <th >No REG</th>
      <th >Operasi</th>
      <th >Harga Jual</th>
      <th >Petugas Input</th> 
      <th >Waktu</th>    
      <th >Detail</th>
      <th >Hapus</th>

  </tr>
  </thead>
  <tbody >
  
   <?php 
   $utama = $db->query("SELECT td.operasi, td.no_reg, td.harga_jual,td.petugas_input,td.waktu,td.id,td.sub_operasi,u.nama FROM tbs_operasi td INNER JOIN user u ON td.petugas_input = u.id WHERE td.no_reg = '$no_reg'");
   while($next = mysqli_fetch_array($utama))      
    {
       // ambil nama operasi
      $select_op = $db->query("SELECT nama_operasi,id_operasi FROM operasi ");
      while($get_nama = mysqli_fetch_array($select_op))
      {
        if ($next['operasi'] == $get_nama['id_operasi'])
        {
          $nama_operasinya = $get_nama['nama_operasi'];
        }
      }
    echo "<tr class='tro-id-".$next['id']."'>

        <td>". $next['no_reg']."</td>
        <td>". $nama_operasinya."</td>
        <td>Rp. ". rp($next['harga_jual'])."</td>
        <td>". $next['nama']."</td>
        <td>". $next['waktu']."</td>

    <td><a href='proses_registrasi_operasi.php?id=".$next["id"]."&no_reg=".$next["no_reg"]."&sub_operasi=".$next["sub_operasi"]."&operasi=".$next["operasi"]."' class='btn btn-sm btn-success' target='blank'>Input Detail </a></td>

    <td><button data-id='".$next['id']."' data-subtotal-ops='".$next['harga_jual']."'  id='hapus-ops-".$data['id']."' data-operasi='".$next['operasi']."' data-sub='".$next['sub_operasi']."' class='btn btn-danger btn-sm delete'><span class='glyphicon glyphicon-trash'></span> Hapus </button>
    </td>
    </tr>";
    }


  ?>
  </tbody>
 </table>
 </div>
</span>
 </div>

<hr>
<hr>

 <div class="collapse" id="collapseExampleLab">
<span id="tabel-lab">
<div class="table-responsive">
<table id="tableuser" class="table table-bordered table-sm">
 
  <thead>
    <tr>

                <th> Kode  </th>
                <th> Nama </th>
                <th> Nama Petugas</th>
                <th style="text-align: right" > Jumlah </th>
                <th style="text-align: right" > Harga </th>
                <th style="text-align: right" > Subtotal </th>
                <th style="text-align: right" > Potongan </th>
                <th style="text-align: right" > Pajak </th>

  </tr>
  </thead>
  <tbody >
  
   <?php 
   $utama = $db->query("SELECT * FROM tbs_penjualan  WHERE no_reg = '$no_reg' AND lab = 'Laboratorium'");
   while($data1 = mysqli_fetch_array($utama))      
    {
      
    echo "<tr class='tr-kode-". $data1['kode_barang'] ." tr-id-". $data1['id'] ."' data-kode-barang='".$data1['kode_barang']."'>
                <td style='font-size:15px'>". $data1['kode_barang'] ."</td>
                <td style='font-size:15px;'>". $data1['nama_barang'] ."</td>";

                 $kd = $db->query("SELECT f.nama_petugas,u.nama FROM tbs_fee_produk f INNER JOIN user u ON f.nama_petugas = u.id WHERE f.kode_produk = '$data1[kode_barang]'  AND f.jam = '$data1[jam]' ");
                    $kdD = $db->query("SELECT f.nama_petugas,u.nama FROM tbs_fee_produk f INNER JOIN user u ON f.nama_petugas = u.id WHERE f.kode_produk = '$data1[kode_barang]' AND  f.jam = '$data1[jam]' ");
                    
                   $nu = mysqli_fetch_array($kd);

                  if ($nu['nama'] != '')
                  {

                  echo "<td>";
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
                echo"<td style='font-size:15px' align='right' class='edit-jumlah' data-id='".$data1['id']."'><span id='text-jumlah-".$data1['id']."'>". $data1['jumlah_barang'] ."</span> <input type='hidden' id='input-jumlah-".$data1['id']."' value='".$data1['jumlah_barang']."' class='input_jumlah' data-id='".$data1['id']."' autofocus='' data-kode='".$data1['kode_barang']."' data-tipe='".$data1['tipe_barang']."' data-harga='".$data1['harga']."' data-satuan='".$data1['satuan']."' data-tipe='".$data1['tipe_barang']."' > </td>
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

                <h6 style="text-align: left ; color: red"><i> * Klik 2x pada kolom jumlah jika ingin mengedit.</i></h6>
                <h6 style="text-align: left ;"><i><b> * Short Key (F2) untuk mencari Kode Produk atau Nama Produk.</b></i></h6>

  
</div> <!-- / END COL SM 6 (1)-->



<div class="col-sm-4">



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
        <div class="col-sm-6">
          
           <label style="font-size:15px"> <b> Subtotal </b></label><br>
      <input style="height:10px;font-size:15px" type="text" name="total" id="total2" class="form-control" placeholder="Total" readonly="" >

        </div>

  

        <div class="col-sm-6">
           <label> Biaya Admin (Rp) </label>
           <input type="text" name="biaya_admin" id="biaya_admin" style="height:10px;font-size:15px"  style="height:10px;font-size:15px" class="form-control" autocomplete="off" onkeydown="return numbersonly(this, event);" onkeyup="javascript:tandaPemisahTitik(this);" >
           </div>

      </div>
      

           <?php
                  $ambil_diskon_tax = $db->query("SELECT * FROM setting_diskon_tax");
                  $data_diskon = mysqli_fetch_array($ambil_diskon_tax);

                  ?>

          <div class="row">

          <div class="col-sm-4">
           <label> Diskon ( Rp )</label><br>
          <input type="text" name="potongan" style="height:10px;font-size:15px" id="potongan_penjualan" v class="form-control" placeholder="" autocomplete="off" value="<?php echo $data_diskon['diskon_nominal']; ?>" onkeydown="return numbersonly(this, event);" onkeyup="javascript:tandaPemisahTitik(this);">
          </div>

          <div class="col-sm-4">
            <label> Diskon ( % )</label><br>
          <input type="text" name="potongan_persen" style="height:10px;font-size:15px" id="potongan_persen"  class="form-control" placeholder="" value="<?php echo $data_diskon['diskon_persen']; ?>%" autocomplete="off" >
          </div>

            <div class="col-sm-4">
           <label> Pajak (%)</label>
           <input type="text" name="tax" id="tax" style="height:10px;font-size:15px"  style="height:10px;font-size:15px" class="form-control" autocomplete="off" >
           </div>

             

          </div>
          

          <div class="row">

           <input type="hidden" name="tax_rp" id="tax_rp" class="form-control"  autocomplete="off" >
           
           <label style="display: none"> Adm Bank  (%)</label>
           <input type="hidden" name="adm_bank" id="adm_bank"  value="" class="form-control" >
           
           <div class="col-sm-6">
             
           <label> Tanggal Jatuh Tempo</label>
           <input type="text" name="tanggal_jt" id="tanggal_jt"  value="<?php echo $take_jt ?>" style="height:10px;font-size:15px" placeholder="Tanggal JT" class="form-control" >
           </div>

        <div class="col-sm-6">
            <label style="font-size:15px"> <b> Cara Bayar (F4) </b> </label><br>
                <select type="text" name="cara_bayar" id="carabayar1" class="form-control"   style="font-size: 15px" >
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
       
        <div class="col-sm-6">

           <label style="font-size:15px"> <b> Total Akhir </b></label><br>
           <b><input type="text" name="total" id="total1" class="form-control" style="height: 25px; width:90%; font-size:20px;" placeholder="Total" readonly="" ></b>
          
        </div>
 
            <div class="col-sm-6">
              
           <label style="font-size:15px">  <b> Pembayaran (F7)</b> </label><br>
           <b><input type="text" name="pembayaran" id="pembayaran_penjualan" style="height: 20px; width:90%; font-size:20px;" autocomplete="off" class="form-control"   style="font-size: 20px"  onkeydown="return numbersonly(this, event);" onkeyup="javascript:tandaPemisahTitik(this);"></b>

            </div>
      </div>
           
           
          <div class="row">
            <div class="col-sm-6">
              
           <label> Kembalian </label><br>
           <b><input type="text" name="sisa_pembayaran"  id="sisa_pembayaran_penjualan"  style="height:10px;font-size:15px" class="form-control"  readonly="" ></b>
            </div>

            <div class="col-sm-6">
              
          <label> Kredit </label><br>
          <b><input type="text" name="kredit" id="kredit" class="form-control"  style="height:10px;font-size:15px"  readonly=""  ></b>
            </div>
          </div> 
          

           <label> Keterangan </label><br>
           <textarea style="height:40px;font-size:15px" type="text" name="keterangan" id="keterangan" class="form-control"> 
           </textarea>


          
          
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

          
          <input type="hidden" name="kode_pelanggan" id="k_pelanggan" class="form-control"  >
          <input type="hidden" name="ppn_input" id="ppn_input" value="Include" class="form-control" placeholder="ppn input">  
      

          <div class="row">
 
            
          <button type="submit" id="penjualan" class="btn btn-info" style="font-size:15px">Bayar (F8)</button>
          <a class="btn btn-info" href="rawat_inap.php" id="transaksi_baru" style="display: none">  Transaksi Baru </a>
          
        

          
            
          <button type="submit" id="piutang" class="btn btn-warning" style="font-size:15px">Piutang (F9)</button>

          <a href='cetak_penjualan_piutang.php' id="cetak_piutang" style="display: none;" class="btn btn-success sls" target="blank">Cetak Piutang  </a>

     

            
        <button type="submit" id="simpan_sementara" class="btn btn-primary " style="font-size:15px">  Simpan (F10)</button>
          <a href='cetak_penjualan_tunai.php' id="cetak_tunai" style="display: none;" class="btn btn-primary" target="blank"> Cetak Tunai  </a>
          <a href='cetak_penjualan_tunai_kategori.php' id="cetak_tunai_kategori" style="display: none;" class="btn btn-primary" target="blank"> Cetak Tunai / Kategori   </a>

          <button type="submit" id="batal_penjualan" class="btn btn-danger" style="font-size:15px">  Batal (Ctrl + B)</button>


          <a href='cetak_penjualan_tunai_besar.php' id="cetak_tunai_besar" style="display: none;" class="btn btn-warning" target="blank"> Cetak Tunai  Besar </a>
          
     
    
          <br>
          </div> <!--row 3-->
          
          <div class="alert alert-success" id="alert_berhasil" style="display:none">
          <strong>Success!</strong> Pembayaran Berhasil
          </div>
     

    </form>


</div><!-- / END COL SM 6 (2)-->


</div><!-- end of row -->

</div>

<script>
//untuk menampilkan data tabel
$(document).ready(function(){
    $("#kode_barang").focus();

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
  var kode_barang = kode_barang.substr(0, kode_barang.indexOf('('));
  var satuan_konversi = $("#satuan_konversi").val();
  var jumlah_barang = $("#jumlah_barang").val();
  var id_produk = $("#id_produk").val();

$.post("cek_level_harga_barang.php",
        {level_harga:level_harga,kode_barang:kode_barang,jumlah_barang:jumlah_barang,id_produk:id_produk,satuan_konversi:satuan_konversi},function(data){

          $("#harga_produk").val(data);
          $("#harga_baru").val(data);
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


<!-- cek stok satuan konversi keyup-->
<script type="text/javascript">
  $(document).ready(function(){
    $("#jumlah_barang").keyup(function(){
      var jumlah_barang = $("#jumlah_barang").val();
      var satuan_konversi = $("#satuan_konversi").val();
      var kode_barang = $("#kode_barang").val();
      var kode_barang = kode_barang.substr(0, kode_barang.indexOf('('));
      var id_produk = $("#id_produk").val();
      var prev = $("#satuan_produk").val();

      $.post("cek_stok_konversi_penjualan.php",
        {jumlah_barang:jumlah_barang,satuan_konversi:satuan_konversi,kode_barang:kode_barang,
        id_produk:id_produk},function(data){

          if (data < 0) {
            alert("Jumlah Melebihi Stok");
            $("#jumlah_barang").val('');
          $("#satuan_konversi").val(prev);

          }

      });
    });
  });
</script>
<!-- cek stok satuan konversi keyup-->

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
      /* Act on the event */
      });

   </script>



<script>
   //perintah javascript yang diambil dari form proses_bayar_beli.php dengan id=form_beli
  $("#penjualan").click(function(){

        var sisa_pembayaran = bersihPemisah(bersihPemisah(bersihPemisah(bersihPemisah( $("#sisa_pembayaran_penjualan").val() ))));
        var kredit = bersihPemisah(bersihPemisah(bersihPemisah(bersihPemisah( $("#kredit").val() )))); 
        var no_rm = $("#no_rm").val();
        var no_rm = no_rm.substr(0, no_rm.indexOf(' |'));
        var no_reg = $("#no_reg").val();
        var tanggal_jt = $("#tanggal_jt").val();
        var total = bersihPemisah(bersihPemisah(bersihPemisah(bersihPemisah( $("#total1").val() )))); 
        var total2 = bersihPemisah(bersihPemisah(bersihPemisah(bersihPemisah( $("#total2").val() )))); 
        var potongan =  bersihPemisah(bersihPemisah(bersihPemisah(bersihPemisah( $("#potongan_penjualan").val() ))));
        var potongan_persen = $("#potongan_persen").val();
        var tax1 = bersihPemisah(bersihPemisah(bersihPemisah(bersihPemisah($("#tax_rp").val()))));
        var tax = Math.round(tax1);
        var cara_bayar = $("#carabayar1").val();
        var pembayaran = bersihPemisah(bersihPemisah(bersihPemisah(bersihPemisah( $("#pembayaran_penjualan").val() ))));        
        var total_hpp = $("#total_hpp").val();
        var harga = $("#harga_produk").val();
        var kode_gudang = $("#kode_gudang").val();
        var sales = $("#id_sales").val();
        var keterangan = $("#keterangan").val();   
        var ber_stok = $("#ber_stok").val();   
        var ppn_input = $("#ppn_input").val();
        var ppn = $("#ppn").val();
        var dokter = $("#dokter").val();
        var petugas_kasir = $("#id_sales").val();   
        var petugas_paramedik = $("#petugas_paramedik").val();
        var petugas_farmasi = $("#petugas_farmasi").val();
        var petugas_lain = $("#petugas_lain").val();
        var bed = $("#bed").val();
        var group_bed = $("#kamar").val();
        var penjamin = $("#penjamin").val();
        var poli = $("#asal_poli").val();
        var nama_pasien = $("#nama_pasien").val();
        var analis = $("#analis").val();
        var biaya_adm = bersihPemisah(bersihPemisah(bersihPemisah(bersihPemisah($("#biaya_admin").val()))));
        if (biaya_adm == '')
        {
          biaya_adm = 0;
        }
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

  $("#tabel-operasi").hide();
  $("#tabel-lab").hide();
  $("#penjualan").hide();
  $("#simpan_sementara").hide();
  $("#batal_penjualan").hide();
  $("#piutang").hide();
  $("#transaksi_baru").show();


 $.post("cek_subtotal_penjualan.php",{total:total,no_reg:no_reg,potongan:potongan,tax:tax,biaya_adm:biaya_adm},function(data) {

  if (data == "Oke") {

 $.post("proses_bayar_kasir_ranap.php",{total2:total2,sisa_pembayaran:sisa_pembayaran,kredit:kredit,no_rm:no_rm,tanggal_jt:tanggal_jt,total:total,potongan:potongan,potongan_persen:potongan_persen,tax:tax,cara_bayar:cara_bayar,pembayaran:pembayaran,sisa:sisa,sisa_kredit:sisa_kredit,total_hpp:total_hpp,harga:harga,sales:sales,kode_gudang:kode_gudang,keterangan:keterangan,ber_stok:ber_stok,ppn_input:ppn_input,nama_pasien:nama_pasien,no_reg:no_reg,dokter:dokter,petugas_paramedik:petugas_paramedik,petugas_farmasi:petugas_farmasi,petugas_lain:petugas_lain,penjamin:penjamin,bed:bed,group_bed:group_bed,biaya_adm:biaya_adm,analis:analis},function(info) {


     $("#table-baru").html(info);
     $("#tabel-lab").html("");
     var no_faktur = info;
     $("#cetak_tunai").attr('href', 'cetak_penjualan_tunai.php?no_faktur='+no_faktur+'');
     $("#cetak_tunai_kategori").attr('href', 'cetak_penjualan_tunai_kategori.php?no_faktur='+no_faktur+'');
     $("#cetak_tunai_besar").attr('href', 'cetak_penjualan_tunai_besar.php?no_faktur='+no_faktur+'');
     $("#alert_berhasil").show();
     $("#pembayaran_penjualan").val('');
     $("#sisa_pembayaran_penjualan").val('');
     $("#kredit").val('');
     $("#cetak_tunai").show();
     $("#cetak_tunai_kategori").show();
     $("#cetak_tunai_besar").show();
    
       
   });

  }
  else{
    alert("Maaf Subtotal Penjualan Tidak Sesuai, Silakan Tunggu Sebentar!");       
        window.location.href="form_penjualan_kasir_ranap.php?no_reg="+no_reg+"";
  }

 });

 }

 $("form").submit(function(){
    return false;
 
});

});

               $("#penjualan").mouseleave(function(){
               
               $.get('no_faktur_jl.php', function(data) {
               /*optional stuff to do after getScript */ 
               
               $("#nomor_faktur_penjualan").val(data);
               $("#no_faktur0").val(data);
               
               });
               var kode_pelanggan = $("#no_rm").val();
               if (kode_pelanggan == ""){
               $("#no_rm").attr("disabled", false);
               }
               
               });
      
  </script>




   <script>
   //untuk menampilkan data yang diambil pada form tbs penjualan berdasarkan id=formtambahproduk
  $("#submit_produk").click(function(){

     var no_reg            = $("#no_reg").val();
     var dokter            = $("#dokter").val();
     var dokter_pj         = $("#dokter_pj").val();
     var penjamin          = $("#penjamin").val();
     var asal_poli         = $("#asal_poli").val();
     var level_harga       = $("#level_harga").val();
     var petugas_kasir     = $("#id_sales").val();
     var petugas_paramedik = $("#petugas_paramedik").val();
     var petugas_farmasi   = $("#petugas_farmasi").val();
     var petugas_lain      = $("#petugas_lain").val();
     var no_rm = $("#no_rm").val();
     var no_rm = no_rm.substr(0, no_rm.indexOf(' |'));     
     var kode_barang = $("#kode_barang").val();
     var kode_barang = kode_barang.substr(0, kode_barang.indexOf('('));
     var nama_barang = $("#nama_barang").val();
     var jumlah_barang = bersihPemisah(bersihPemisah(bersihPemisah(bersihPemisah($("#jumlah_barang").val()))));
     var harga = bersihPemisah(bersihPemisah(bersihPemisah(bersihPemisah($("#harga_produk").val()))));
     var potongan = bersihPemisah(bersihPemisah(bersihPemisah(bersihPemisah($("#potongan1").val()))));
     if (potongan == '') {
      potongan = 0;
     };
     var tax = bersihPemisah(bersihPemisah(bersihPemisah(bersihPemisah($("#tax1").val()))));
     if (tax == '') {
      tax = 0;
     }
     var jumlahbarang = $("#jumlahbarang").val();
     var satuan = $("#satuan_konversi").val();
     var sales = $("#sales").val();
     var a = $(".tr-kode-"+kode_barang+"").attr("data-kode-barang");    
     var ber_stok = $("#ber_stok").val();
     var ppn = $("#ppn").val();
     var stok = parseInt(jumlahbarang,10) - parseInt(jumlah_barang,10);
     var tax_faktur = bersihPemisah(bersihPemisah(bersihPemisah(bersihPemisah($("#tax").val()))));
         var subtotal = bersihPemisah(bersihPemisah(bersihPemisah(bersihPemisah($("#total2").val()))));
     if (subtotal == "") {
        subtotal = 0;
      };
    var pot_fakt_per = bersihPemisah(bersihPemisah(bersihPemisah(bersihPemisah($("#potongan_persen").val()))));

    var pot_fakt_rp = bersihPemisah(bersihPemisah(bersihPemisah(bersihPemisah($("#potongan_penjualan").val()))));
    if (pot_fakt_rp == '')
    {
      pot_fakt_rp = 0;
    }
     var biaya_admin = bersihPemisah(bersihPemisah(bersihPemisah(bersihPemisah($("#biaya_admin").val()))));
if (biaya_admin == '')
{
  biaya_admin = 0;
}


    var total = parseInt(jumlah_barang,10) * parseInt(harga,10) - parseInt(potongan,10);


    var total_akhir1 = parseInt(subtotal,10) + parseInt(total,10);


    if (pot_fakt_per == '0%') {
      var potongaaan = pot_fakt_rp;

    var total_akhier = parseInt(total_akhir1,10) - parseInt(pot_fakt_rp,10);


         //Hitung pajak
        if (tax_faktur != 0) {
        var hasil_tax = parseInt(total_akhier,10) * parseInt(Math.round(tax_faktur,10)) / 100;

        }
        else
        {
        var hasil_tax = 0;
        }

    //end hitung pajak

    var pot_pers = parseInt(pot_fakt_rp,10) / parseInt(total_akhir1,10) * 100; 
    var total_akhir = parseInt(total_akhier,10) + parseInt(Math.round(hasil_tax,10)) + parseInt(biaya_admin,10);

    

    }
    else if(pot_fakt_rp == 0)
    {
      var potongaaan = pot_fakt_per;
      var pos = potongaaan.search("%");
      var potongan_persen = bersihPemisah(bersihPemisah(bersihPemisah(bersihPemisah(potongaaan))));
          potongan_persen = potongan_persen.replace("%","");
      potongaaan = total_akhir1 * potongan_persen / 100;



        var total_akhier = parseInt(total_akhir1,10) - parseInt(Math.round(potongaaan,10));


         //Hitung pajak
        if (tax_faktur != 0) {
        var hasil_tax = parseInt(total_akhier,10) * parseInt(Math.round(tax_faktur,10)) / 100;

        }
        else
        {
        var hasil_tax = 0;
        }
    //end hitung pajak

    var pot_pers = parseInt(potongaaan,10) / parseInt(total_akhir1,10) * 100; 
    var total_akhir = parseInt(total_akhier,10) + parseInt(Math.round(hasil_tax,10)) + parseInt(biaya_admin,10);

    }
     else if(pot_fakt_rp != 0 && pot_fakt_per != '0%')
    {
      var potongaaan = pot_fakt_per;
      var pos = potongaaan.search("%");
      var potongan_persen = bersihPemisah(bersihPemisah(bersihPemisah(bersihPemisah(potongaaan))));
          potongan_persen = potongan_persen.replace("%","");
          if (potongan_persen != 0)
          {
               var potongaaan = total_akhir1 * potongan_persen / 100;

          }

          else
          {
               var potongaaan = 0;

          }

     
       var total_akhier = parseInt(total_akhir1,10) - parseInt(Math.round(potongaaan,10));


         //Hitung pajak
        if (tax_faktur != 0) {
        var hasil_tax = parseInt(total_akhier,10) * parseInt(Math.round(tax_faktur,10)) / 100;

        }
        else
        {
        var hasil_tax = 0;
        }
    //end hitung pajak
    var pot_pers = parseInt(potongaaan,10) / parseInt(total_akhir1,10) * 100; 
    var total_akhir = parseInt(total_akhier,10) + parseInt(Math.round(hasil_tax,10)) + parseInt(biaya_admin,10);

  

    }



   

     $("#harga_baru").val('');
     $("#harga_produk").val('');
     $("#harga_lama").val('');
     $("#jumlah_barang").val('');
     $("#potongan1").val('');
     $("#tax1").val('');
     
  if (a > 0){
  alert("Anda Tidak Bisa Menambahkan Barang Yang Sudah Ada, Silakan Edit atau Pilih Barang Yang Lain !");
  }
  else if (jumlah_barang == ''){
  alert("Jumlah Barang Harus Diisi");
       $("#jumlah_barang").focus();


  }

  else if (ber_stok == 'Jasa' || ber_stok == 'BHP' ){

      $("#kode_barang").val('');

      $("#potongan_persen").val(Math.round(pot_pers));  
      $("#potongan_penjualan").val(Math.round(potongaaan));
      $("#tax_rp").val(Math.round(hasil_tax));
     $("#total2").val(tandaPemisahTitik(total_akhir1));
     $("#total1").val(tandaPemisahTitik(Math.round(total_akhir)));
     $("#kode_barang").focus();

  $.post("proses_tbs_penjualan_ranap.php",{
kode_barang:kode_barang,nama_barang:nama_barang,jumlah_barang:jumlah_barang,harga:harga,tax:tax,potongan:potongan,no_rm:no_rm,satuan:satuan,ber_stok:ber_stok,no_reg:no_reg,dokter:dokter,dokter_pj:dokter_pj,penjamin:penjamin,asal_poli:asal_poli,level_harga:level_harga,petugas_kasir:petugas_kasir,petugas_paramedik:petugas_paramedik,petugas_farmasi:petugas_farmasi,petugas_lain:petugas_lain},function(data){
     
  

     $("#ppn").attr("disabled", true);
     $("#tbody").prepend(data);
     $("#kode_barang").val('');
     $("#nama_barang").val('');
     $("#jumlah_barang").val('');
     $("#potongan1").val('');
     $("#tax1").val('');
     $("#pembayaran_penjualan").val('');
     $("#sisa_pembayaran_penjualan").val('');
     $("#kredit").val('');
     
     });


  
  } 
  else if (stok < 0) {

    alert ("Jumlah Melebihi Stok Barang !");

  }

  else{
        $("#kode_barang").val('');
      $("#potongan_persen").val(Math.round(pot_pers));  
      $("#potongan_penjualan").val(Math.round(potongaaan));
      $("#tax_rp").val(Math.round(hasil_tax));
      $("#total2").val(tandaPemisahTitik(total_akhir1));
      $("#total1").val(tandaPemisahTitik(Math.round(total_akhir)));
     $("#kode_barang").focus();
    $.post("proses_tbs_penjualan_ranap.php",{kode_barang:kode_barang,nama_barang:nama_barang,jumlah_barang:jumlah_barang,harga:harga,tax:tax,potongan:potongan,no_rm:no_rm,satuan:satuan,ber_stok:ber_stok,no_reg:no_reg,dokter:dokter,dokter_pj:dokter_pj,penjamin:penjamin,asal_poli:asal_poli,level_harga:level_harga,petugas_kasir:petugas_kasir,petugas_paramedik:petugas_paramedik,petugas_farmasi:petugas_farmasi,petugas_lain:petugas_lain},function(data){
     

      $("#ppn").attr("disabled", true);
     $("#tbody").prepend(data);
     
     $("#kode_barang").val('');
     $("#nama_barang").val('');
     $("#jumlah_barang").val('');
     $("#potongan1").val('');
     $("#tax1").val('');
         $("#pembayaran_penjualan").val('');
     $("#sisa_pembayaran_penjualan").val('');
     $("#kredit").val('');

     
     });
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





 <script>
       //perintah javascript yang diambil dari form proses_bayar_beli.php dengan id=form_beli
       $("#piutang").click(function(){


        var sisa_pembayaran = bersihPemisah(bersihPemisah(bersihPemisah(bersihPemisah( $("#sisa_pembayaran_penjualan").val() ))));
        var kredit = bersihPemisah(bersihPemisah(bersihPemisah(bersihPemisah( $("#kredit").val() )))); 
        var no_rm = $("#no_rm").val();
        var no_rm = no_rm.substr(0, no_rm.indexOf(' |')); 
        var no_reg = $("#no_reg").val();
        var tanggal_jt = $("#tanggal_jt").val();
        var total = bersihPemisah(bersihPemisah(bersihPemisah(bersihPemisah( $("#total1").val() )))); 
        var total2 = bersihPemisah(bersihPemisah(bersihPemisah(bersihPemisah( $("#total2").val() )))); 
        var potongan =  bersihPemisah(bersihPemisah(bersihPemisah(bersihPemisah( $("#potongan_penjualan").val() ))));
        var potongan_persen = $("#potongan_persen").val();
        var tax1 = $("#tax_rp").val();
        var tax = Math.round(tax1);
        var cara_bayar = $("#carabayar1").val();
        var pembayaran = bersihPemisah(bersihPemisah(bersihPemisah(bersihPemisah( $("#pembayaran_penjualan").val() ))));
        var total_hpp = $("#total_hpp").val();
        var kode_gudang = $("#kode_gudang").val();
        var sales = $("#id_sales").val();
        var keterangan = $("#keterangan").val();   
        var ber_stok = $("#ber_stok").val();   
        var ppn_input = $("#ppn_input").val();
        var ppn = $("#ppn").val();
        var dokter = $("#dokter").val();
        var petugas_kasir = $("#id_sales").val();   
        var petugas_paramedik = $("#petugas_paramedik").val();
        var petugas_farmasi = $("#petugas_farmasi").val();
        var petugas_lain = $("#petugas_lain").val();
        var bed = $("#bed").val();
        var group_bed = $("#kamar").val();
        var penjamin = $("#penjamin").val();
        var poli = $("#asal_poli").val();
        var analis = $("#analis").val();
        var nama_pasien = $("#nama_pasien").val();
        var biaya_adm = $("#biaya_admin").val();
        if (biaya_adm == '')
        {
          biaya_adm = 0;
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


        $("#piutang").hide();
        $("#tabel-operasi").hide();
  $("#tabel-lab").hide();
        $("#simpan_sementara").hide();
        $("#batal_penjualan").hide();
        $("#penjualan").hide();
        $("#transaksi_baru").show();
        


 $.post("cek_subtotal_penjualan.php",{total:total,no_reg:no_reg,potongan:potongan,tax:tax,biaya_adm:biaya_adm},function(data) {

  if (data == "Oke") {

$.post("proses_bayar_kasir_ranap.php",{total2:total2,sisa_pembayaran:sisa_pembayaran,kredit:kredit,no_rm:no_rm,tanggal_jt:tanggal_jt,total:total,potongan:potongan,potongan_persen:potongan_persen,tax:tax,cara_bayar:cara_bayar,pembayaran:pembayaran,sisa:sisa,sisa_kredit:sisa_kredit,total_hpp:total_hpp,sales:sales,kode_gudang:kode_gudang,keterangan:keterangan,ber_stok:ber_stok,ppn_input:ppn_input,nama_pasien:nama_pasien,no_reg:no_reg,dokter:dokter,petugas_paramedik:petugas_paramedik,petugas_farmasi:petugas_farmasi,petugas_lain:petugas_lain,penjamin:penjamin,bed:bed,group_bed:group_bed,biaya_adm:biaya_adm,analis:analis},function(info) {

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
            
       
       
  });

  }
  else{
    alert("Maaf Subtotal Penjualan Tidak Sesuai, Silakan Tunggu Sebentar!");       
        window.location.href="form_penjualan_kasir_ranap.php?no_reg="+no_reg+"";
  }

 });


}  
       //mengambil no_faktur pembelian agar berurutan

       });
 $("form").submit(function(){
       return false;
       });

              $("#piutang").mouseleave(function(){
               
               $.get('no_faktur_jl.php', function(data) {
               /*optional stuff to do after getScript */ 
               
               $("#nomor_faktur_penjualan").val(data);
               $("#no_faktur0").val(data);
               
               });
               var kode_pelanggan = $("#no_rm").val();
               if (kode_pelanggan == ""){
               $("#no_rm").attr("disabled", false);
               }
               
               });
  </script>  


  <script type="text/javascript">
//berfunsi untuk mencekal username ganda
 $(document).ready(function(){
  $(document).on('click', '.pilih', function (e) {
    var session_id = $("#session_id").val();
     var no_reg = $("#no_reg").val();
    var kode_barang = $("#kode_barang").val();
    var kode_barang = kode_barang.substr(0, kode_barang.indexOf('('));
 $.post('cek_kode_barang_tbs_ranap.php',{kode_barang:kode_barang,session_id:session_id,no_reg:no_reg}, function(data){
  
  if(data == 1){
    alert("Anda Tidak Bisa Menambahkan Barang Yang Sudah Ada, Silakan Edit atau Pilih Barang Yang Lain !");
    $("#kode_barang").val('');
    $("#nama_barang").val('');
   }//penutup if

    });////penutup function(data)

    });//penutup click(function()
  });//penutup ready(function()
</script>

<script type="text/javascript">
$(document).ready(function(){
$("#cari_produk_penjualan").click(function(){
  var session_id = $("#session_id").val();

  $.post("cek_tbs_penjualan.php",{session_id: "<?php echo $session_id; ?>"},function(data){
        if (data != "1") {


             $("#ppn").attr("disabled", false);

        }
    });

});
});
</script>



<script type="text/javascript">
        $(document).ready(function(){
        
        $("#potongan_persen").keyup(function(){

        var potongan_persen = bersihPemisah(bersihPemisah(bersihPemisah(bersihPemisah($("#potongan_persen").val()))));
        var total = bersihPemisah(bersihPemisah(bersihPemisah(bersihPemisah( $("#total2").val() ))));
        var potongan_penjualan = ((total * potongan_persen) / 100);
        var tax = $("#tax").val();
        var tax_rp = bersihPemisah(bersihPemisah(bersihPemisah(bersihPemisah($("#tax_rp").val()))));
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
              $("#total1").val(tandaPemisahTitik(Math.round(hasil_akhir)));
                  $("#potongan_penjualan").val(tandaPemisahTitik(Math.round(potongan_penjualan)));
                  $("#tax_rp").val(Math.round(t_tax));
        }

      });

       
        
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
        
        </script>




<script type="text/javascript">

$(document).ready(function(){
        $("#potongan_penjualan").keyup(function(){

        var potongan_penjualan =  bersihPemisah(bersihPemisah(bersihPemisah(bersihPemisah( $("#potongan_penjualan").val() ))));
        var biaya_admin = bersihPemisah(bersihPemisah(bersihPemisah(bersihPemisah($("#biaya_admin").val()))));
        if (biaya_admin == '') {
          biaya_admin = 0;
        }
       var pembayaran = bersihPemisah(bersihPemisah(bersihPemisah(bersihPemisah($("#pembayaran_penjualan").val()))));
        if (pembayaran == '')
        {
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
        $("#tax_rp").val(Math.round(t_tax))
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
        var pembayaran = bersihPemisah(bersihPemisah(bersihPemisah(bersihPemisah($("#pembayaran_penjualan").val()))));
          if (pembayaran == '')
          {
           pembayaran = 0;
          }
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

              var total_akhir = parseInt(bersihPemisah(bersihPemisah(bersihPemisah(bersihPemisah(t_total,10))))) + Math.round(parseInt(t_tax,10)) + parseInt(biaya_admin,10);

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

              if (tax > 100) {

                alert ('Jumlah Tax Tidak Boleh Lebih Dari 100%');
                 $("#tax").val('');

              }
        

        $("#tax_rp").val(Math.round(t_tax));


        });

});

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

//untuk menampilkan sisa penjualan secara otomatis
  $(document).ready(function(){

  $("#jumlah_barang").keyup(function(){
     var jumlah_barang = $("#jumlah_barang").val();
     var jumlahbarang = $("#jumlahbarang").val();
     var limit_stok = $("#limit_stok").val();
     var ber_stok = $("#ber_stok").val();
     var stok = jumlahbarang - jumlah_barang;



if (stok < 0 )

  {

       if (ber_stok == 'Jasa' || ber_stok == 'BHP') {
       
       }
       
       else{
       alert ("Jumlah Melebihi Stok!");
       $("#jumlah_barang").val('');
       }


    }

    else if( limit_stok > stok  ){

      alert ("Persediaan Barang Ini Sudah Mencapai Batas Limit Stok, Segera Lakukan Pembelian !");
    }
  });
})

</script>


<script>

$(document).ready(function(){

        var cara_bayar = $("#carabayar1").val();
        
        //metode POST untuk mengirim dari file cek_jumlah_kas.php ke dalam variabel "dari akun"
        $.post('cek_jumlah_kas1.php', {cara_bayar:cara_bayar},function(data) {
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
      
//fungsi hapus data 
$(document).on('click','.btn-hapus-tbs',function(e){


          var nama_barang = $(this).attr("data-barang");
          var id = $(this).attr("data-id");
          var kode_barang = $(this).attr("data-kode-barang");
          var no_reg = $("#no_reg").val();
          var subtotal_tbs = bersihPemisah(bersihPemisah(bersihPemisah(bersihPemisah($(this).attr("data-subtotal")))));
          var tax = $("#tax").val();
          var total = bersihPemisah(bersihPemisah(bersihPemisah(bersihPemisah($("#total2").val()))));
          if (total == '') 
          {
          total = 0;
          }
          
          var total_akhir = parseInt(total,10) - parseInt(subtotal_tbs,10)
          
          var potongan_persen =  $("#potongan_persen").val();
          var potongan_penjualan = ((parseInt(total_akhir,10) * parseInt(potongan_persen,10)) / 100);
          
          var biaya_admin = bersihPemisah(bersihPemisah(bersihPemisah(bersihPemisah($("#biaya_admin").val()))));
          if (biaya_admin == '') {
          biaya_admin = 0;
          }
          var sisa_potongan = parseInt(total_akhir,10) - parseInt(Math.round(potongan_penjualan,10));
          if (tax == '')
          {
            var t_tax = 0;
          }
          else
          {
          var t_tax = ((parseInt(sisa_potongan,10) * parseInt(tax,10)) / 100);
          }
          var hasil_akhir = parseInt(sisa_potongan,10) + parseInt(Math.round(t_tax,10)) + parseInt(biaya_admin,10) ;
          $("#potongan_penjualan").val(Math.round(potongan_penjualan));


      $("#tax_rp").val(Math.round(t_tax));

      $("#total1").val(tandaPemisahTitik(Math.round(hasil_akhir)));
      $("#total2").val(tandaPemisahTitik(total_akhir));


    $(".tr-id-"+id+"").remove();

     $("#pembayaran_penjualan").val('');
     $("#sisa_pembayaran_penjualan").val('');
     $("#kredit").val('');
    $.post("hapustbs_penjualan.php",{id:id,kode_barang:kode_barang,no_reg:no_reg},function(data){

    });

});
                  $('form').submit(function(){
              
              return false;
              });


    });
  
//end fungsi hapus data
</script>

  <script type="text/javascript">
    $(document).ready(function(){
      
//fungsi hapus data 
$(document).on('click','.delete',function(e){

          var subtotal_tbs = bersihPemisah(bersihPemisah(bersihPemisah(bersihPemisah($(this).attr("data-subtotal-ops")))));
          var nama_barang = $(this).attr("data-barang");
          var or = $(this).attr('data-operasi');
          var sub = $(this).attr('data-sub');
          var id = $(this).attr("data-id");
          var kode_barang = $(this).attr("data-kode-barang");
          var no_reg = $("#no_reg").val();
          var tax = $("#tax").val();
          var total = bersihPemisah(bersihPemisah(bersihPemisah(bersihPemisah($("#total2").val()))));
          if (total == '') 
          {
          total = 0;
          }
          
          var total_akhir = parseInt(total,10) - parseInt(subtotal_tbs,10)
          
          var potongan_persen =  $("#potongan_persen").val();
          var potongan_penjualan = ((parseInt(total_akhir,10) * parseInt(potongan_persen,10)) / 100);
          var total_operasi = bersihPemisah(bersihPemisah(bersihPemisah(bersihPemisah($("#total_operasi").val()))));
          var biaya_admin = bersihPemisah(bersihPemisah(bersihPemisah(bersihPemisah($("#biaya_admin").val()))));
          if (biaya_admin == '') {
          biaya_admin = 0;
          }
          var sisa_potongan = parseInt(total_akhir,10) - parseInt(Math.round(potongan_penjualan,10));
          if (tax == '')
          {
            var t_tax = 0;
          }
          else
          {
          var t_tax = ((parseInt(sisa_potongan,10) * parseInt(tax,10)) / 100);
          }
          var hasil_akhir = parseInt(sisa_potongan,10) + parseInt(Math.round(t_tax,10)) + parseInt(biaya_admin,10) ;
          $("#potongan_penjualan").val(Math.round(potongan_penjualan));


      $("#tax_rp").val(Math.round(t_tax));

      $("#total1").val(tandaPemisahTitik(Math.round(hasil_akhir)));
      $("#total2").val(tandaPemisahTitik(total_akhir));


    $(".tro-id-"+id+"").remove();


    $.post("delete_registrasi_operasi.php",{id:id,or:or,sub:sub},function(data){
    if (data == 'sukses') {

    $("#pembayaran_penjualan").val('');

    
    }
    });

});
                  $('form').submit(function(){
              
              return false;
              });


    });
  
//end fungsi hapus data
</script>



<!-- AUTOCOMPLETE -->

<script>
$(function() {
    $( "#kode_barang" ).autocomplete({
        source: 'kode_barang_autocomplete.php'
    });
});
</script>

<!-- AUTOCOMPLETE -->



<script type="text/javascript">
  
        $(document).ready(function(){
        $("#kode_barang").blur(function(){

          var kode_barang = $(this).val();
          var level_harga = $("#level_harga").val();
          var session_id = $("#session_id").val();
          var no_reg = $("#no_reg").val();
          var kode_barang = kode_barang.substr(0, kode_barang.indexOf('('));
          
         
          $.post("cek_barang_penjualan.php",{kode_barang: kode_barang}, function(data){
          $("#jumlahbarang").val(data);
          });

          $.post('cek_kode_barang_tbs_ranap.php',{kode_barang:kode_barang,session_id:session_id,no_reg:no_reg}, function(data){
          
          if(data == 1){
          alert("Anda Tidak Bisa Menambahkan Barang Yang Sudah Ada, Silakan Edit atau Pilih Barang Yang Lain !");

          $("#kode_barang").val('');
          $("#nama_barang").val('');
          }//penutup if
          
          });////penutup function(data)

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
        $('#ber_stok').val(json.tipe_barang);

      }
                                              
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




     <script>
       //perintah javascript yang diambil dari form proses_bayar_beli.php dengan id=form_beli
       $("#simpan_sementara").click(function(){
       


        var sisa_pembayaran = bersihPemisah(bersihPemisah(bersihPemisah(bersihPemisah( $("#sisa_pembayaran_penjualan").val() ))));
        var kredit = bersihPemisah(bersihPemisah(bersihPemisah(bersihPemisah( $("#kredit").val() )))); 
        var no_rm = $("#no_rm").val();
        var no_rm = no_rm.substr(0, no_rm.indexOf(' |')); 
        var no_reg = $("#no_reg").val();
        var tanggal_jt = $("#tanggal_jt").val();
        var total = bersihPemisah(bersihPemisah(bersihPemisah(bersihPemisah( $("#total1").val() )))); 
        var total2 = bersihPemisah(bersihPemisah(bersihPemisah(bersihPemisah( $("#total2").val() )))); 
        var potongan =  bersihPemisah(bersihPemisah(bersihPemisah(bersihPemisah( $("#potongan_penjualan").val() ))));
        var potongan_persen = $("#potongan_persen").val();
        var tax1 = $("#tax_rp").val();
        var tax = Math.round(tax1);
        var cara_bayar = $("#carabayar1").val();
        var pembayaran = bersihPemisah(bersihPemisah(bersihPemisah(bersihPemisah( $("#pembayaran_penjualan").val() ))));
        var total_hpp = $("#total_hpp").val();
        var kode_gudang = $("#kode_gudang").val();
        var sales = $("#id_sales").val();
        var keterangan = $("#keterangan").val();   
        var ber_stok = $("#ber_stok").val();   
        var ppn_input = $("#ppn_input").val();
        var ppn = $("#ppn").val();
        var dokter_pj = $("#dokter_pj").val();
        var dokter = $("#dokter").val();
        var petugas_kasir = $("#petugas_kasir").val();   
        var petugas_paramedik = $("#petugas_paramedik").val();
        var petugas_farmasi = $("#petugas_farmasi").val();
        var petugas_lain = $("#petugas_lain").val();
        var bed = $("#bed").val();
        var group_bed = $("#group_bed").val();
        var penjamin = $("#penjamin").val();
        var poli = $("#asal_poli").val();
        var nama_pasien = $("#nama_pasien").val();
        var analis = $("#analis").val();
        var biaya_adm = $("#biaya_admin").val();

        if (biaya_adm == '')
        {
          biaya_adm = 0;
        }

        var sisa = pembayaran - total;
        
        var sisa_kredit = total - pembayaran;

  if ( total == "") 
         {
         
         alert("Anda Belum Melakukan Transaksi");
         
         }
         
       else
       {

        $("#pembayaran_penjualan").val('');
        $("#tabel-operasi").hide();
        $("#simpan_sementara").hide();
        $("#tabel-lab").hide();
        $("#sisa_pembayaran_penjualan").val('');
        $("#kredit").val('');
        $("#piutang").hide();
        $("#batal_penjualan").hide();
        $("#penjualan").hide();
        $("#transaksi_baru").show();
        $("#total1").val('');

 $.post("cek_subtotal_penjualan.php",{total:total,no_reg:no_reg,potongan:potongan,tax:tax,biaya_adm:biaya_adm},function(data) {

  if (data == "Oke") {

       $.post("proses_simpan_barang_ranap.php",{total2:total2,sisa_pembayaran:sisa_pembayaran,kredit:kredit,no_rm:no_rm,tanggal_jt:tanggal_jt,total:total,potongan:potongan,potongan_persen:potongan_persen,tax:tax,cara_bayar:cara_bayar,pembayaran:pembayaran,sisa:sisa,sisa_kredit:sisa_kredit,total_hpp:total_hpp,sales:sales,kode_gudang:kode_gudang,keterangan:keterangan,ber_stok:ber_stok,ppn_input:ppn_input,nama_pasien:nama_pasien,no_reg:no_reg,dokter:dokter,petugas_paramedik:petugas_paramedik,petugas_farmasi:petugas_farmasi,petugas_lain:petugas_lain,penjamin:penjamin,biaya_adm:biaya_adm,dokter_pj:dokter_pj,analis:analis},function(info) {

        
            $("#table-baru").html(info);
            $("#alert_berhasil").show();
            $("#pembayaran_penjualan").val('');
            $("#sisa_pembayaran_penjualan").val('');
            $("#kredit").val('');
            $("#simpan_sementara").hide();
            $("#potongan_penjualan").val('');
            $("#potongan_persen").val('');
            $("#tanggal_jt").val('');
            $("#tax").val('');
            
       
       
       });

  }
  else{
    alert("Maaf Subtotal Penjualan Tidak Sesuai, Silakan Tunggu Sebentar!");       
        window.location.href="form_penjualan_kasir_ranap.php?no_reg="+no_reg+"";
  }

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
               var kode_pelanggan = $("#no_rm").val();
               if (kode_pelanggan == ""){
               $("#no_rm").attr("disabled", false);
               }
               
               });
  </script>    



        <script type="text/javascript">

$(document).ready(function(){

    $("#no_rm").change(function(){
        var kode_pelanggan = $("#no_rm").val();
        
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
                                    var kode_barang = $(this).attr("data-kode");
                                    var harga = $(this).attr("data-harga");
                                    var jumlah_lama = $("#text-jumlah-"+id+"").text();
                                    var satuan_konversi = $(this).attr("data-satuan");
                                    var tipe_barang = $(this).attr("data-tipe");
                
                                    var subtotal_lama = bersihPemisah(bersihPemisah(bersihPemisah(bersihPemisah($("#text-subtotal-"+id+"").text()))));
                                    var potongan = bersihPemisah(bersihPemisah(bersihPemisah(bersihPemisah($("#text-potongan-"+id+"").text()))));

                                    var tax = bersihPemisah(bersihPemisah(bersihPemisah(bersihPemisah($("#text-tax-"+id+"").text()))));
                                   
                                    var subtotal = harga * jumlah_baru - potongan;

                                    var subtotal_penjualan = bersihPemisah(bersihPemisah(bersihPemisah(bersihPemisah($("#total2").val()))));

                                    subtotal_penjualan = subtotal_penjualan - subtotal_lama + subtotal;
                                    
                                  var pot_fakt_per = bersihPemisah(bersihPemisah(bersihPemisah(bersihPemisah($("#potongan_persen").val()))));


                                    var potongaaan = pot_fakt_per;
                                          var pos = potongaaan.search("%");
                                          var potongan_persen = bersihPemisah(bersihPemisah(bersihPemisah(bersihPemisah(potongaaan))));
                                              potongan_persen = potongan_persen.replace("%","");

                                          potongaaan = subtotal_penjualan * potongan_persen / 100;
                                          $("#potongan_penjualan").val(Math.round(potongaaan));

                                          var biaya_admin = bersihPemisah(bersihPemisah(bersihPemisah(bersihPemisah($("#biaya_admin").val()))));
                                          if (biaya_admin == '')
                                            {biaya_admin = 0}


                                            var tax_faktur =  bersihPemisah(bersihPemisah(bersihPemisah(bersihPemisah($("#tax").val()))));
                                            if(tax_faktur == '')
                                            {
                                              tax_faktur = 0;
                                            }

                                            var sub_akhir = parseInt(subtotal_penjualan,10) - parseInt(Math.round(potongaaan,10)); 


                        var t_tax = ((parseInt(bersihPemisah(bersihPemisah(bersihPemisah(bersihPemisah(sub_akhir,10))))) * parseInt(bersihPemisah(bersihPemisah(bersihPemisah(bersihPemisah(tax_faktur)))))) / 100);

                                    //perhitungan total pembayaran terakhir
                                    var tot_akhr = parseInt(sub_akhir,10) + parseInt(biaya_admin,10);
                                    //perhitungan total pembayaran terakhir

                            

                                    var tax_tbs = tax / subtotal_lama * 100;
                                    var jumlah_tax = Math.round(tax_tbs) * subtotal / 100;

                                    if (tipe_barang == 'Jasa' || tipe_barang == 'BHP' || tipe_barang == 'Bed') {
                                      
                                    $("#text-jumlah-"+id+"").show();
                                    $("#text-jumlah-"+id+"").text(jumlah_baru);

                                    $("#text-subtotal-"+id+"").text(tandaPemisahTitik(subtotal));
                                    $("#hapus-tbs-"+id+"").attr('data-subtotal', subtotal);
                                    $("#text-tax-"+id+"").text(Math.round(jumlah_tax));
                                    $("#input-jumlah-"+id+"").attr("type", "hidden"); 
                                    $("#total2").val(tandaPemisahTitik(subtotal_penjualan));         
                                    $("#potongan_penjualan").val(Math.round(potongaaan));
                                    $("#total1").val(tandaPemisahTitik(Math.round(tot_akhr)));                                    
                                    $("#tax_rp").val(Math.round(t_tax)); 
                                    $("#pembayaran_penjualan").val('');
                                     $("#sisa_pembayaran_penjualan").val('');
                                     $("#kredit").val('');



                                      $.post("update_pesanan_barang.php",{jumlah_lama:jumlah_lama,tax:tax,id:id,jumlah_baru:jumlah_baru,kode_barang:kode_barang,potongan:potongan,harga:harga,jumlah_tax:jumlah_tax,subtotal:subtotal},function(){
                                      
                                      
                                      
                                      
                                      });

                                    }

                                    else {
                                    $.post("cek_stok_pesanan_barang.php",{kode_barang:kode_barang, jumlah_baru:jumlah_baru,satuan_konversi:satuan_konversi},function(data){

                                       if (data < 0) {

                                       alert ("Jumlah Yang Di Masukan Melebihi Stok !");

                                    $("#input-jumlah-"+id+"").val(jumlah_lama);
                                    $("#text-jumlah-"+id+"").text(jumlah_lama);
                                    $("#text-jumlah-"+id+"").show();
                                    $("#input-jumlah-"+id+"").attr("type", "hidden");
                                    
                                     }

                                      else{

                                     $.post("update_pesanan_barang.php",{jumlah_lama:jumlah_lama,tax:tax,id:id,jumlah_baru:jumlah_baru,kode_barang:kode_barang,potongan:potongan,harga:harga,jumlah_tax:jumlah_tax,subtotal:subtotal},function(info){


                                    
                                    
                                    $("#text-jumlah-"+id+"").show();
                                    $("#text-jumlah-"+id+"").text(jumlah_baru);

                                    $("#text-subtotal-"+id+"").text(tandaPemisahTitik(subtotal));
                                    $("#hapus-tbs-"+id+"").attr('data-subtotal', subtotal);
                                    $("#text-tax-"+id+"").text(Math.round(jumlah_tax));
                                    $("#input-jumlah-"+id+"").attr("type", "hidden"); 
                                    $("#total2").val(tandaPemisahTitik(subtotal_penjualan));         
                                    $("#potongan_penjualan").val(Math.round(potongaaan));
                                    $("#total1").val(tandaPemisahTitik(Math.round(tot_akhr)));   
                                    $("#tax_rp").val(Math.round(t_tax)); 
                                    $("#pembayaran_penjualan").val('');
                                     $("#sisa_pembayaran_penjualan").val('');
                                     $("#kredit").val('');

                                    });

                                   }

                                 });

                            }
       
                                    $("#kode_barang").focus();
                                    

                                 });

                             </script>

<script type="text/javascript">
    $(document).ready(function(){

      $("#tax").attr("disabled", true);


    $("#ppn").change(function(){

    var ppn = $("#ppn").val();
    $("#ppn_input").val(ppn);

  if (ppn == "Include"){

      $("#tax").attr("disabled", true);
      $("#tax1").attr("disabled", false);
  }

  else if (ppn == "Exclude") {
    $("#tax1").attr("disabled", true);
      $("#tax").attr("disabled", false);
  }
  else{

    $("#tax1").attr("disabled", true);
      $("#tax").attr("disabled", true);
  
  }


  });
  });
</script>

<script type="text/javascript">
$(document).ready(function(){
  $("#batal_penjualan").click(function(){
    var no_reg = $("#no_reg").val()
     
        window.location.href="batal_penjualan_ranap.php?no_reg="+no_reg+"";

  })
  });
</script>

<!-- SHORTCUT -->

<script> 
    shortcut.add("f2", function() {
        // Do something

        $("#kode_barang").focus();

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

        window.location.href="batal_penjualan_ranap.php?no_reg="+no_reg+"";


    }); 
</script>

<!-- SHORTCUT -->


<!-- SCRIPT MENCARI DATA PASIEN -->
<script type="text/javascript">
            $(document).ready(function(){
                $('#no_rm').change(function()
                    {
                    var no_rm = $("#no_rm").val();
                          
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
                          $(".chosen").chosen({no_results_text: "Maaf, Data Tidak Ada!"}); 


                }
                                              
                        });
                      }
                });
            });
</script>
<!--END SCRIPT CARI DATA PASIEN -->



<script type="text/javascript">
  $(document).ready(function(){
    var no_reg = $("#no_reg").val();
    var pot_fakt_per = bersihPemisah(bersihPemisah(bersihPemisah(bersihPemisah($("#potongan_persen").val()))));
    var pot_fakt_rp = bersihPemisah(bersihPemisah(bersihPemisah(bersihPemisah($("#potongan_penjualan").val()))));
    var total_operasi = bersihPemisah(bersihPemisah(bersihPemisah(bersihPemisah($("#total_operasi").val()))));
    if (total_operasi == '') {
      total_operasi = 0;
    }
    var total_lab = bersihPemisah(bersihPemisah(bersihPemisah(bersihPemisah($("#total_lab").val()))));
    if (total_lab == "") {
      total_lab = 0;
    }

    $.post("cek_total_seluruh_ranap.php",{no_reg:no_reg},function(data1){
  
        if (data1 == 1) {
                 $.post("cek_total_seluruh.php",{no_reg:no_reg},function(data){
                   if (data == "") {
                    data = 0;
                    $("#potongan_persen").val('0');
            
                  }

                  var sum = parseInt(data,10) + parseInt(total_operasi,10) + parseInt(total_lab,10);
                  data = data.replace(/\s+/g, '');
               

                  $("#total2").val(tandaPemisahTitik(sum))
                  
                  

      if (pot_fakt_per == '0%') {

               var potongann = pot_fakt_rp;
               var potongaaan = parseInt(potongann,10) / parseInt(data,10) * 100;

          if (data == '0') {
              
              $("#potongan_persen").val(Math.round('0'));
             
          }
          else{
            $("#potongan_persen").val(Math.round(potongaaan));
            
          }
                 


      var total = parseInt(data,10) - parseInt(pot_fakt_rp,10) + parseInt(total_operasi,10) + parseInt(total_lab,10);
                  $("#total1").val(tandaPemisahTitik(total))

            }
            else if(pot_fakt_rp == 0)
            {

                  var potongaaan = pot_fakt_per;
                  var pos = potongaaan.search("%");
                  var potongan_persen = bersihPemisah(bersihPemisah(bersihPemisah(bersihPemisah(potongaaan))));
                  potongan_persen = potongan_persen.replace("%","");
                  potongaaan = data * potongan_persen / 100;
                  $("#potongan_penjualan").val(Math.round(potongaaan));
                  $("#potongan1").val(potongaaan);


      var total = parseInt(data,10) - parseInt(potongaaan,10) + parseInt(total_operasi,10) + parseInt(total_lab,10);
                  $("#total1").val(tandaPemisahTitik(total))
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
              $(nRow).attr('status', aData[12]);
              $(nRow).attr('suplier', aData[13]);
              $(nRow).attr('limit_stok', aData[14]);
              $(nRow).attr('ber-stok', aData[15]);
              $(nRow).attr('tipe_barang', aData[16]);
              $(nRow).attr('id-barang', aData[18]);



          }

        });    
     
  });
 
 </script>

<!-- memasukan file footer.php -->
<?php include 'footer.php'; ?>