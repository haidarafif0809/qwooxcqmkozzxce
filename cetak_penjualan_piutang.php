<?php session_start();


include 'header.php';
include 'sanitasi.php';
include 'db.php';
include 'cache.class.php';

  $no_faktur = stringdoang($_GET['no_faktur']);
  $no_reg = stringdoang($_GET['no_reg']);

    $query0 = $db->query("SELECT p.penjamin, p.no_reg,p.biaya_admin,p.id,p.no_faktur,p.total,p.kode_pelanggan,p.keterangan,p.cara_bayar,p.tanggal,p.tanggal_jt,p.jam,p.user,p.sales,p.kode_meja,p.status,p.potongan,p.tax,p.sisa,p.kredit,p.kode_gudang,p.tunai,pl.nama_pelanggan,pl.wilayah,dp.jumlah_barang,dp.subtotal,dp.nama_barang,dp.harga, da.nama_daftar_akun, pl.alamat_sekarang FROM penjualan p LEFT JOIN detail_penjualan dp ON p.no_faktur = dp.no_faktur LEFT JOIN pelanggan pl ON p.kode_pelanggan = pl.kode_pelanggan LEFT JOIN daftar_akun da ON p.cara_bayar = da.kode_daftar_akun WHERE p.no_faktur = '$no_faktur' ORDER BY p.id DESC");
     $data0 = mysqli_fetch_array($query0);


    $select_pasien = $db_pasien->query("SELECT nama_pelanggan, alamat_sekarang FROM pelanggan WHERE kode_pelanggan = '$data0[kode_pelanggan]' ORDER BY id DESC");
     $data_pasien = mysqli_fetch_array($select_pasien); 

    $query1 = $db->query("SELECT * FROM perusahaan ");
    $data1 = mysqli_fetch_array($query1);

    $query04 = $db->query("SELECT SUM(kredit) as total_kredit FROM penjualan WHERE no_faktur = '$no_faktur'");
    $data04 = mysqli_fetch_array($query04);
    $total_kredit = $data04['total_kredit'];


    $setting_bahasa0 = $db->query("SELECT * FROM setting_bahasa WHERE kata_asal = 'Pelanggan' ");
    $data200 = mysqli_fetch_array($setting_bahasa0);

    


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



    <center> <h4> <b> Faktur Penjualan Piutang</b> </h4> </center>


  <div class="row">
    <div class="col-sm-9">
        

 <table>
  <tbody>
      <tr><td width="25%"><font class="satu">No Faktur</font></td> <td> :&nbsp;</td> <td><font class="satu"><?php echo $no_faktur; ?></font> </tr>
      <tr><td  width="25%"><font class="satu"><?php echo $data200['kata_ubah']; ?></font></td> <td> :&nbsp;</td> <td> <font class="satu"><?php echo $data_pasien['nama_pelanggan']; ?></font> </td></tr>
      <tr><td  width="25%"><font class="satu">Alamat</font></td> <td> :&nbsp;</td> <td><font class="satu"> <?php echo $data_pasien['alamat_sekarang']; ?> </font></td></tr>
      <tr><td  width="25%"><font class="satu">Ket.</font></td> <td> :&nbsp;</td> <td><font class="satu"> <?php echo $data0['keterangan']; ?> </font></td></tr>

            

  </tbody>
</table>


    </div>

    <div class="col-sm-3">
 <table>
  <tbody>

       <tr><td width="50%"><font class="satu"> Tanggal</td> <td> :&nbsp;&nbsp;</td> <td><?php echo tanggal($data0['tanggal']);?></font> </td></tr> 
       <tr><td width="50%"><font class="satu"> Tanggal JT</td> <td> :&nbsp;&nbsp;</td> <td><?php echo tanggal($data0['tanggal_jt']); ?></font> </td></tr> 
       <tr><td width="50%"><font class="satu"> Kasir</td> <td> :&nbsp;&nbsp;</td> <td><?php echo $_SESSION['nama']; ?></font></td></tr> 
       <tr><td width="50%"><font class="satu"> Status </td> <td> :&nbsp;&nbsp;</td> <td><?php echo $data0['status']; ?></font></td></tr> 
       <tr><td width="50%"><font class="satu"> Penjamin </td> <td> :&nbsp;&nbsp;</td> <td><?php echo $data0['penjamin']; ?></font></td></tr> 

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
<br><br>
<table id="tableuser" class="table1  table-bordered table-sm">
        <thead>
            <th class="table1" style="width: 3%"> <center> No. </center> </th>
            <th class="table1" style="width: 50%"> <center> Nama Barang </center> </th>
            <th class="table1" style="width: 5%"> <center> Qty </center> </th>
            <th class="table1" style="width: 5%"> <center> Satuan </center> </th>
            <th class="table1" style="width: 15%"> <center> Harga </center> </th>
            <th class="table1" style="width: 5%"> <center> Disc. </center> </th>
            <th class="table1" style="width: 12%"> <center> Subtotal </center> </th>
        
            
        </thead>
        <tbody id="tbody-detail">

       

        <?php 

           $c = new Cache();
          $c->setCache('detail_penjualan');
          $data_detail_penjualan = $c->retrieve($no_reg);
          $no_urut = 0;
          $subtotal = 0;
          foreach ($data_detail_penjualan as $data ) {
            $no_urut++;
            $subtotal += $data['subtotal'];
           echo  "<tr> <td class='table1' align='center'>".$no_urut."</td><td class='table1'>". $data['nama_barang']. "</td><td class='table1' align='right'>". $data['jumlah_barang']."</td>  <td class='table1'>". $data['satuan'] ."</td><td class='table1' align='right'>". $data['harga']."</td><td class='table1' align='right'>". $data['potongan'] ."</td><td class='table1' align='right'>". $data['subtotal'] ."</td> <tr>"; 
      
        }
         ?>
       
        </tbody>

    </table>

<br>

        <div class="col-sm-6">
            
            <i><b><font class="satu">Terbilang :</font></b> <?php echo kekata($data0['total']); ?> </i> <br>


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

      <tr><td width="50%"><font class="satu">Sub Total</font></td> <td> :&nbsp;</td> <td><font class="satu"> <?php echo $subtotal ?></font></tr>
      <tr><td width="50%"><font class="satu">Diskon</font></td> <td> :&nbsp;</td> <td><font class="satu"> <?php echo rp($data0['potongan']); ?></font> </tr>
            <tr><td width="50%"><font class="satu">Biaya Admin</font></td> <td> :&nbsp;</td> <td><font class="satu"> <?php echo rp($data0['biaya_admin']); ?></font> </tr>
      <tr><td  width="50%"><font class="satu">Tax</font></td> <td> :&nbsp;</td> <td><font class="satu"> <?php echo rp($data0['tax']); ?> </font></td></tr>
      <tr><td  width="50%"><font class="satu">Total Akhir</font></td> <td> :&nbsp;</td> <td><font class="satu"> <?php echo rp($data0['total']); ?></font>  </td></tr>

  </tbody>
</table>

        </div>

        <div class="col-sm-3">

 <table>
  <tbody>

      <tr><td  width="40%"><font class="satu">Bayar</font></td> <td> :&nbsp;</td> <td><font class="satu"> <?php echo rp($data0['tunai']); ?></font> </td></tr>
      <tr><td  width="40%"><font class="satu">Piutang</font></td> <td> :&nbsp;</td> <td><font class="satu"> <?php echo rp($data0['kredit']); ?></font> </td></tr>
      <tr><td  width="40%"><font class="satu">Jenis Bayar</font></td> <td> :&nbsp;</td> <td><font class="satu"> <?php echo $data0['nama_daftar_akun']; ?></font> </td></tr>   

  </tbody>
</table>

        </div>


    <div class="col-sm-5">
    
    <font class="satu"><b>Nama <?php echo $data200['kata_ubah']; ?> <br><br><br> <font class="satu"><?php echo $data0['nama_pelanggan']; ?></font> </b></font>
    
    </div> <!--/ col-sm-6-->
    
    <div class="col-sm-5">
    <font class="satu"><b>Manager <br><br><br> <font class="satu">................</font> </b></font>
    </div>

    <div class="col-sm-2">
    
    <font class="satu"><b>Petugas <br><br><br> <font class="satu"><?php echo $_SESSION['nama']; ?></font></b></font>

    </div> <!--/ col-sm-6-->




</div> <!--/container-->


 <script>
$(document).ready(function(){
       
         window.print();             
});
</script>



<?php include 'footer.php'; ?>