<?php session_start();


include 'header.php';
include 'sanitasi.php';
include 'db.php';


  $no_faktur = $_GET['no_faktur'];

    $query0 = $db->query("SELECT p.penjamin, p.no_reg,p.biaya_admin,p.id,p.no_faktur,p.total,p.kode_pelanggan,p.keterangan,p.cara_bayar,p.tanggal,p.tanggal_jt,p.jam,p.user,p.sales,p.kode_meja,p.status,p.potongan,p.tax,p.sisa,p.kredit,p.kode_gudang,p.tunai,pl.nama_pelanggan,pl.wilayah,dp.jumlah_barang,dp.subtotal,dp.nama_barang,dp.harga, da.nama_daftar_akun, pl.alamat_sekarang FROM penjualan p LEFT JOIN detail_penjualan dp ON p.no_faktur = dp.no_faktur LEFT JOIN pelanggan pl ON p.kode_pelanggan = pl.kode_pelanggan LEFT JOIN daftar_akun da ON p.cara_bayar = da.kode_daftar_akun WHERE p.no_faktur = '$no_faktur' ORDER BY p.id DESC");
     $data0 = mysqli_fetch_array($query0);


    $select_pasien = $db_pasien->query("SELECT nama_pelanggan, alamat_sekarang FROM pelanggan WHERE kode_pelanggan = '$data0[kode_pelanggan]' ORDER BY id DESC");
     $data_pasien = mysqli_fetch_array($select_pasien); 

    $query1 = $db->query("SELECT * FROM perusahaan ");
    $data1 = mysqli_fetch_array($query1);

    $query2 = $db->query("SELECT * FROM detail_penjualan WHERE no_faktur = '$no_faktur' ");
    $data2 = mysqli_fetch_array($query2);

    $query3 = $db->query("SELECT SUM(jumlah_barang) as total_item FROM detail_penjualan WHERE no_faktur = '$no_faktur'");
    $data3 = mysqli_fetch_array($query3);
    $total_item = $data3['total_item'];

    $query04 = $db->query("SELECT SUM(kredit) as total_kredit FROM penjualan WHERE no_faktur = '$no_faktur'");
    $data04 = mysqli_fetch_array($query04);
    $total_kredit = $data04['total_kredit'];

    $query05 = $db->query("SELECT SUM(subtotal) as t_subtotal FROM detail_penjualan WHERE no_faktur = '$no_faktur'");
    $data05 = mysqli_fetch_array($query05);
    $t_subtotal = $data05['t_subtotal'];

    $setting_bahasa = $db->query("SELECT * FROM setting_bahasa WHERE kata_asal = 'Sales' ");
    $data20 = mysqli_fetch_array($setting_bahasa);

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
        <tbody>
        <?php

        $no_urut = 0;

            $query5 = $db->query("SELECT * FROM detail_penjualan WHERE no_faktur = '$no_faktur' ");
            //menyimpan data sementara yang ada pada $perintah
            while ($data5 = mysqli_fetch_array($query5))
            {

              $no_urut ++;
            
      $kode = $db->query("SELECT dp.satuan, s.nama FROM detail_penjualan dp INNER JOIN satuan s ON dp.satuan = s.id  WHERE dp.kode_barang = '$data5[kode_barang]' ");
              $satuan_b = mysqli_fetch_array($kode);
              $satuan = $satuan_b['nama'];

            echo "<tr>
            <td class='table1' align='center'>".$no_urut."</td>
            <td class='table1'>". $data5['nama_barang'] ."</td>
            <td class='table1' align='right'>". rp($data5['jumlah_barang']) ."</td>";
          if ($data5['lab'] == 'Laboratorium') {
            echo "1";
            echo "<td class='table1'>Lab</td>";
          }
          else{        
            echo "<td class='table1'>". $satuan ."</td>";
          }
            echo "<td class='table1' align='right'>". rp($data5['harga']) ."</td>
            <td class='table1' align='right'>". rp($data5['potongan']) ."</td>
            <td class='table1' align='right'>". rp($data5['subtotal']) ."</td>
            <tr>";

            }

// OPERASI TABLE
 $take_data_or = $db->query("SELECT * FROM hasil_operasi WHERE no_reg = '$data0[no_reg]'");

    while($out_operasi = mysqli_fetch_array($take_data_or))
      {
                   
        $select_or = $db->query("SELECT id_operasi,nama_operasi FROM operasi WHERE id_operasi = '$out_operasi[operasi]'");
        $outin = mysqli_fetch_array($select_or);
        
        $nomor = $no_urut +1;

        echo"<tr>
                    
            <td class='table1' align='center'>".$nomor."</td>";

            if($out_operasi['operasi'] == $outin['id_operasi'])
            {
              echo"<td class='table1' align='left'>". $outin['nama_operasi'] ."</td>";
            }
            else{
              echo "<td> </td>";
            }
            

            echo " 
            <td class='table1' align='center'>-</td>
            <td class='table1' align='center'>-</td>
            <td class='table1' align='right'>". rp($out_operasi['harga_jual']) ."</td>
            <td class='table1' align='right'>-</td>
            <td class='table1' align='right'>". rp($out_operasi['harga_jual']) ."</td>
      </tr>";

                    
                  
    }
//Untuk Memutuskan Koneksi Ke Database
mysqli_close($db); 


        ?>
        </tbody>

    </table>

<br>

        <div class="col-sm-6">
            
            <i><b><font class="satu">Terbilang :</font></b> <?php echo kekata($data0['total']); ?> </i> <br>
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