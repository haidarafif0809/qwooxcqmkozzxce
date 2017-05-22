<?php session_start();


include 'header.php';
include 'sanitasi.php';
include 'db.php';



$no_reg = stringdoang($_GET['no_reg']);
$nama_pasien = stringdoang($_GET['nama_pasien']);


   
$row = $db->query("SELECT no_reg FROM tbs_penjualan WHERE no_reg = '$no_reg' ");
$data_row = mysqli_num_rows($row);
if ($data_row > 0) {


    $query0 = $db->query("SELECT r.id, r.no_rm, r.nama_pasien AS nama_asli, SUM(tp.subtotal) AS total_subtotal, alamat_pasien AS alamat, s.nama AS nama_satuan, r.penjamin, SUM(tp.jumlah_barang) as total_item,  SUM(tp.tax) as pajak FROM registrasi r INNER JOIN tbs_penjualan tp on r.no_reg = tp.no_reg INNER JOIN satuan s ON tp.satuan = s.id WHERE r.no_reg = '$no_reg' ");
    $data_inner = mysqli_fetch_array($query0);

    $keterangan = $_GET['keterangan'];
    $tanggal = date('Y-m-d');
    $total = $_GET['total'];
    $potongan = $_GET['diskon'];
    $biaya_admin = $_GET['biaya_admin'];
    $tunai = $_GET['tunai'];
    $sisa = $_GET['sisa'];
    $cara_bayar = $_GET['cara_bayar'];
    $no_rm = $_GET['no_rm'];

    $select_akun = $db->query("SELECT nama_daftar_akun FROM daftar_akun WHERE kode_daftar_akun = '$cara_bayar'");
    $data = mysqli_fetch_array($select_akun);
    $nama_daftar_akun = $data['nama_daftar_akun'];

    $query1 = $db->query("SELECT foto, nama_perusahaan, alamat_perusahaan, no_telp FROM perusahaan ");
    $data1 = mysqli_fetch_array($query1);


    $query3 = $db->query("SELECT SUM(jumlah_barang) as total_item FROM tbs_penjualan WHERE no_reg = '$no_reg'");
    $data3 = mysqli_fetch_array($query3);
    $total_item = $data3['total_item'];


    $query05 = $db->query("SELECT SUM(subtotal) as t_subtotal FROM tbs_penjualan WHERE no_reg = '$no_reg'");
    $data05 = mysqli_fetch_array($query05);
    $t_awal_subtotal = $data05['t_subtotal'];

    $query_orp = $db->query("SELECT SUM(harga_jual) as t_operasi FROM hasil_operasi WHERE no_reg = '$no_reg'");
    $data_or = mysqli_fetch_array($query_orp);
    $t_operasi = $data_or['t_operasi'];

    $t_subtotal = $t_awal_subtotal + $t_operasi;

    $setting_bahasa0 = $db->query("SELECT kata_ubah FROM setting_bahasa WHERE kata_asal = 'Pelanggan' ");
    $data200 = mysqli_fetch_array($setting_bahasa0); 
}

else{
    $query0 = $db->query("SELECT p.nama AS nama_asli,p.penjamin ,p.no_reg,p.biaya_admin,p.id,p.no_faktur,p.total,p.kode_pelanggan,p.keterangan,p.cara_bayar,p.tanggal,p.tanggal_jt,p.jam,p.user,p.sales,p.kode_meja,p.status,p.potongan,p.tax,p.sisa,p.kredit,p.kode_gudang,p.tunai,pl.nama_pelanggan,pl.wilayah,dp.satuan,dp.jumlah_barang,dp.subtotal,dp.nama_barang,dp.harga, da.nama_daftar_akun, s.nama, pl.alamat_sekarang AS alamat, s.nama AS nama_satuan FROM penjualan p LEFT JOIN detail_penjualan dp ON p.no_faktur = dp.no_faktur LEFT JOIN pelanggan pl ON p.kode_pelanggan = pl.kode_pelanggan LEFT JOIN daftar_akun da ON p.cara_bayar = da.kode_daftar_akun LEFT JOIN satuan s ON dp.satuan = s.id WHERE p.no_reg = '$no_reg' ORDER BY p.id DESC");
     $data_inner = mysqli_fetch_array($query0);

     $keterangan = $data_inner['keterangan'];
     $tanggal = $data_inner['tanggal'];
     $total = $data_inner['total'];
     $potongan = $data_inner['potongan'];
     $biaya_admin = $data_inner['biaya_admin'];
     $tunai = $data_inner['tunai'];
     $sisa = $data_inner['sisa'];
     $nama_daftar_akun = $data_inner['nama_daftar_akun'];
     $no_rm = $data_inner['kode_pelanggan'];



    $query1 = $db->query("SELECT foto, nama_perusahaan, alamat_perusahaan, no_telp FROM perusahaan ");
    $data1 = mysqli_fetch_array($query1);

    $query3 = $db->query("SELECT SUM(jumlah_barang) as total_item FROM detail_penjualan WHERE no_reg = '$no_reg'");
    $data3 = mysqli_fetch_array($query3);
    $total_item = $data3['total_item'];

    $query04 = $db->query("SELECT SUM(kredit) as total_kredit FROM penjualan WHERE no_reg = '$no_reg'");
    $data04 = mysqli_fetch_array($query04);
    $total_kredit = $data04['total_kredit'];

    $query05 = $db->query("SELECT SUM(subtotal) as t_subtotal FROM detail_penjualan WHERE no_reg = '$no_reg'");
    $data05 = mysqli_fetch_array($query05);
    $t_awal_subtotal = $data05['t_subtotal'];

    $query_orp = $db->query("SELECT SUM(harga_jual) as t_operasi FROM hasil_operasi WHERE no_reg = '$no_reg'");
    $data_or = mysqli_fetch_array($query_orp);
    $t_operasi = $data_or['t_operasi'];

    $t_subtotal = $t_awal_subtotal + $t_operasi;

    $setting_bahasa0 = $db->query("SELECT kata_ubah FROM setting_bahasa WHERE kata_asal = 'Pelanggan' ");
    $data200 = mysqli_fetch_array($setting_bahasa0);
}


    


 ?>

<style type="text/css">
/*unTUK mengatur ukuran font*/
   .satu {
   font-size: 15px;
   font: verdana;
   }
</style>


<div class="container">
    
    <div class="row"><!--row1-->
        <div class="col-sm-2">
                <img src='save_picture/<?php echo $data1['foto']; ?>' class='img-rounded' alt='Cinque Terre' width='80' height='80`'> 
        </div><!--penutup colsm2-->

        <div class="col-sm-8">
                 <center> <h4> <b> <?php echo $data1['nama_perusahaan']; ?> </b> </h4> 
                 <p> <?php echo $data1['alamat_perusahaan']; ?><br>
                  No.Telp:<?php echo $data1['no_telp']; ?> </p> </center>
                 
        </div><!--penutup colsm5-->
        
    </div><!--penutup row1-->





  <div class="row">
    <div class="col-sm-9">
        

 <table>
  <tbody>
  <?php if ($data_row > 0): ?>
    <tr><td width="25%"><font class="satu">No REG</font></td> <td> :&nbsp;</td> <td><font class="satu"><?php echo $no_reg; ?></font> </tr>
  <?php else: ?>
    <tr><td width="25%"><font class="satu">No Faktur</font></td> <td> :&nbsp;</td> <td><font class="satu"><?php echo $data_inner['no_faktur']; ?></font> </tr>
  <?php endif ?>
      

      <tr><td width="25%"><font class="satu">No RM</font></td> <td> :&nbsp;</td> <td><font class="satu"><?php echo $no_rm; ?></font> </tr>
      <tr><td  width="25%"><font class="satu"><?php echo $data200['kata_ubah']; ?></font></td> <td> :&nbsp;</td> <td> <font class="satu"><?php echo $data_inner['nama_asli']; ?></font> </td></tr>
      <tr><td  width="25%"><font class="satu">Alamat</font></td> <td> :&nbsp;</td> <td><font class="satu"> <?php echo $data_inner['alamat']; ?> </font></td></tr>
      <tr><td  width="25%"><font class="satu">Keterangan</font></td> <td> :&nbsp;</td> <td><font class="satu"> <?php echo $keterangan; ?> </font></td></tr>

            

  </tbody>
</table>


    </div>

    <div class="col-sm-3">
 <table>
  <tbody>
       <tr><td width="50%"><font class="satu"> Tanggal</td> <td> :&nbsp;&nbsp;</td> <td><?php echo tanggal($tanggal);?></font> </td></tr> 
       <tr><td width="50%"><font class="satu"> Tanggal JT</td> <td> :&nbsp;&nbsp;</td> <td>-</font> </td></tr> 
       <tr><td width="50%"><font class="satu"> Kasir</td> <td> :&nbsp;&nbsp;</td> <td><?php echo $_SESSION['nama']; ?></font></td></tr> 
       <tr><td width="50%"><font class="satu"> Status </td> <td> :&nbsp;&nbsp;</td> <td>Lunas</font></td></tr> 

      </tbody>
</table>

    </div> <!--end col-sm-2-->
   </div> <!--end row-->  




<style type="text/css">
  th,td{
    padding: 1px;
  }


.table1, .th, .td {
    border: 1px solid black;
    font-size: 15px;
    font: verdana;
}


</style>

  <table id="tableuser" class="table table-bordered table-sm">
        <thead>
            <th class="table1" style="width: 3%"> <center> No. </center> </th>
            <th class="table1" style="width: 10%"> <center> Kode Jasa </center> </th>
            <th class="table1" style="width: 35%"> <center> Nama Jasa </center> </th>
            <th class="table1" style="width: 20%"> <center> Dokter </center> </th>
            <th class="table1" style="width: 20%"> <center> Analis </center> </th>
            <th class="table1" style="width: 40%"> <center> Harga </center> </th>
        
            
        </thead>
        <tbody>
        <?php

        $no_urut = 1;


// RADIOLOGI TABLE
 $select_hasil_radiologi = $db->query("SELECT kode_barang,nama_barang,harga,jumlah_barang FROM detail_penjualan WHERE no_reg = '$no_reg' ");


    while($data_hasil = mysqli_fetch_array($select_hasil_radiologi))
      {
        $query_ambil_petugas = $db->query("SELECT u.nama AS dokter, us.nama AS analis FROM hasil_lab lab INNER JOIN user u ON lab.dokter = u.id INNER JOIN user us ON lab.petugas_analis = us.id WHERE lab.kode_barang = '$data_hasil[kode_barang]'");
         $data_petugas = mysqli_fetch_array($query_ambil_petugas);
      
        $nomor = $no_urut ++;

        echo"<tr>
                    
            <td class='table1' align='center'>".$nomor."</td>   
            <td class='table1'>".$data_hasil['kode_barang']."</td> 
            <td class='table1'>".$data_hasil['nama_barang']."</td>
            <td class='table1'>".$data_petugas['dokter']."</td> 
            <td class='table1'>".$data_petugas['analis']."</td>  
            <td class='table1' align='right'>".rp($data_hasil['harga'])."</td>
      </tr>";

                  
                  
    }
//Untuk Memutuskan Koneksi Ke Database
mysqli_close($db); 

        ?>
        </tbody>

    </table>


<br>
        <div class="col-sm-6">
            
            <i><b><font class="satu">Terbilang :</font></b> <?php echo kekata($total); ?> </i> <br>
            <!DOCTYPE html>

<style>
div.dotted {border-style: dotted;}
div.dashed {border-style: dashed;}
div.solid {border-style: solid;}
div.double {border-style: double;}
div.groove {border-style: groove;}
div.ridge {border-style: ridge;}
div.inset {border-style: inset;}
div.outset {border-style: outset;}
div.none {border-style: none;}
div.hidden {border-style: hidden;}
div.mix {border-style: dotted dashed solid double;}
</style>



</div>
 <div class="col-sm-3">

 <table>
  <tbody>

      <tr><td width="50%"><font class="satu">Sub Total</font></td> <td> :&nbsp;</td> <td><font class="satu"> <?php echo rp($t_subtotal); ?> </font></tr>
      <tr><td width="50%"><font class="satu">Diskon</font></td> <td> :&nbsp;</td> <td><font class="satu"> <?php echo rp($potongan); ?></font> </tr>
      <tr><td width="50%"><font class="satu">Biaya Admin</font></td> <td> :&nbsp;</td> <td><font class="satu"> <?php echo rp($biaya_admin); ?></font> </tr>
      <tr><td  width="50%"><font class="satu">Total Akhir</font></td> <td> :&nbsp;</td> <td><font class="satu"> <?php echo rp($total); ?></font>  </td></tr>

  </tbody>
</table>

        </div>

        <div class="col-sm-3">

 <table>
  <tbody>

      <tr><td  width="40%"><font class="satu">Bayar</font></td> <td> :&nbsp;</td> <td><font class="satu"> <?php echo rp($tunai); ?></font> </td></tr>
      <tr><td  width="40%"><font class="satu">Kembali</font></td> <td> :&nbsp;</td> <td><font class="satu"> <?php echo rp($sisa); ?></font> </td></tr>
      <tr><td  width="40%"><font class="satu">Jenis Bayar</font></td> <td> :&nbsp;</td> <td><font class="satu"> <?php echo $nama_daftar_akun; ?></font> </td></tr>   

  </tbody>
</table>

        </div>


    <div class="col-sm-9">
    
    <font class="satu"><b>Nama <?php echo $data200['kata_ubah']; ?> <br><br><br> <font class="satu"><?php echo $data_inner['nama_asli']; ?></font> </b></font>
    
    </div> <!--/ col-sm-6-->
    
    <div class="col-sm-3">
    
    <font class="satu"><b>Petugas <br><br><br> <font class="satu"><?php echo $_SESSION['nama']; ?></font></b></font>

    </div> <!--/ col-sm-6-->




</div> <!--/container-->


 <script>
$(document).ready(function(){
  window.print();
});
</script>

<?php include 'footer.php'; ?>