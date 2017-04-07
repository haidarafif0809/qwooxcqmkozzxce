<?php session_start();


include 'header.php';
include 'sanitasi.php';
include 'db.php';


  $no_faktur = stringdoang($_GET['no_faktur']);

    $query0 = $db->query("SELECT p.nama AS nama_asli,p.penjamin ,p.no_reg,p.biaya_admin,p.id,p.no_faktur,p.total,p.kode_pelanggan,p.keterangan,p.cara_bayar,p.tanggal,p.tanggal_jt,p.jam,p.user,p.sales,p.kode_meja,p.status,p.potongan,p.tax,p.sisa,p.kredit,p.kode_gudang,p.tunai,pl.nama_pelanggan,pl.wilayah,dp.satuan,dp.jumlah_barang,dp.subtotal,dp.nama_barang,dp.harga, da.nama_daftar_akun, s.nama, pl.alamat_sekarang AS alamat, s.nama AS nama_satuan FROM penjualan p LEFT JOIN detail_penjualan dp ON p.no_faktur = dp.no_faktur LEFT JOIN pelanggan pl ON p.kode_pelanggan = pl.kode_pelanggan LEFT JOIN daftar_akun da ON p.cara_bayar = da.kode_daftar_akun LEFT JOIN satuan s ON dp.satuan = s.id WHERE p.no_faktur = '$no_faktur' ORDER BY p.id DESC");
     $data_inner = mysqli_fetch_array($query0);



    $query1 = $db->query("SELECT foto, nama_perusahaan, alamat_perusahaan, no_telp FROM perusahaan ");
    $data1 = mysqli_fetch_array($query1);

    $query3 = $db->query("SELECT SUM(jumlah_barang) as total_item FROM detail_penjualan WHERE no_faktur = '$no_faktur'");
    $data3 = mysqli_fetch_array($query3);
    $total_item = $data3['total_item'];

    $query04 = $db->query("SELECT SUM(kredit) as total_kredit FROM penjualan WHERE no_faktur = '$no_faktur'");
    $data04 = mysqli_fetch_array($query04);
    $total_kredit = $data04['total_kredit'];

    $query05 = $db->query("SELECT SUM(subtotal) as t_subtotal FROM detail_penjualan WHERE no_faktur = '$no_faktur'");
    $data05 = mysqli_fetch_array($query05);
    $t_awal_subtotal = $data05['t_subtotal'];

    $query_orp = $db->query("SELECT SUM(harga_jual) as t_operasi FROM hasil_operasi WHERE no_reg = '$data_inner[no_reg]'");
    $data_or = mysqli_fetch_array($query_orp);
    $t_operasi = $data_or['t_operasi'];


    $sum_hasil_radiologi = $db->query("SELECT  SUM(subtotal) as sub_radiologi FROM hasil_pemeriksaan_radiologi WHERE no_reg = '$data_inner[no_reg]' AND no_faktur = '$no_faktur' ");
    $data_radiologi = mysqli_fetch_array($sum_hasil_radiologi);
    $t_radiologi = $data_radiologi['sub_radiologi'];


    $t_subtotal = $t_awal_subtotal + $t_operasi + $t_radiologi;

    $setting_bahasa0 = $db->query("SELECT kata_ubah FROM setting_bahasa WHERE kata_asal = 'Pelanggan' ");
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





  <div class="row">
    <div class="col-sm-9">
        

 <table>
  <tbody>
      <tr><td width="25%"><font class="satu">No Faktur</font></td> <td> :&nbsp;</td> <td><font class="satu"><?php echo $data_inner['no_faktur']; ?></font> </tr>

            <tr><td width="25%"><font class="satu">No RM</font></td> <td> :&nbsp;</td> <td><font class="satu"><?php echo $data_inner['kode_pelanggan']; ?></font> </tr>

      <tr><td  width="25%"><font class="satu"><?php echo $data200['kata_ubah']; ?></font></td> <td> :&nbsp;</td> <td> <font class="satu"><?php echo $data_inner['nama_asli']; ?></font> </td></tr>
      <tr><td  width="25%"><font class="satu">Alamat</font></td> <td> :&nbsp;</td> <td><font class="satu"> <?php echo $data_inner['alamat']; ?> </font></td></tr>
      <tr><td  width="25%"><font class="satu">Ket.</font></td> <td> :&nbsp;</td> <td><font class="satu"> <?php echo $data_inner['keterangan']; ?> </font></td></tr>

            

  </tbody>
</table>


    </div>

    <div class="col-sm-3">
 <table>
  <tbody>
      <tr><td  width="25%"><font class="satu">Penjamin</font></td> <td> :&nbsp;</td> <td><font class="satu"> <?php echo $data_inner['penjamin']; ?> </font></td></tr>
       <tr><td width="50%"><font class="satu"> Tanggal</td> <td> :&nbsp;&nbsp;</td> <td><?php echo tanggal($data_inner['tanggal']);?></font> </td></tr> 
       <tr><td width="50%"><font class="satu"> Tanggal JT</td> <td> :&nbsp;&nbsp;</td> <td>-</font> </td></tr> 
       <tr><td width="50%"><font class="satu"> Kasir</td> <td> :&nbsp;&nbsp;</td> <td><?php echo $_SESSION['nama']; ?></font></td></tr> 
       <tr><td width="50%"><font class="satu"> Status </td> <td> :&nbsp;&nbsp;</td> <td><?php echo $data_inner['status']; ?></font></td></tr> 

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

  <?php 

        # query untuk ngecek apakh ada  Obat Obatan / Alkes di detail penjualan
    $query_obat = $db->query("SELECT dp.nama_barang, dp.no_faktur, dp.kode_barang, dp.jumlah_barang, dp.lab, dp.harga, dp.potongan, dp.tax, dp.subtotal, s.nama FROM detail_penjualan dp LEFT JOIN satuan s ON dp.satuan = s.id WHERE dp.no_reg = '$data_inner[no_reg]' AND dp.tipe_produk = 'Barang' AND (dp.lab IS NULL OR dp.lab = '') ");
    $cek_obat = mysqli_num_rows($query_obat);

        if ($cek_obat > 0){ #<!-- JIKA ADA Laboratorium maka akan ditampilkan -->

     ?>

<!-- OBAT OBATAN / ALKES (BARANG) -->
<h5><b><u>Obat Obatan / Alkes</u></b></h5>
  <table id="tabel_obat" class="table table-bordered table-sm">
        <thead>
            <th class="table1" style="width: 3%"> <center> No. </center> </th>
            <th class="table1" style="width: 35%"> <center> Nama Produk </center> </th>
            <th class="table1" style="width: 40%"> <center> Petugas </center> </th>
            <th class="table1" style="width: 5%"> <center> Qty </center> </th>
            <th class="table1" style="width: 5%"> <center> Satuan </center> </th>
            <th class="table1" style="width: 15%"> <center> Harga </center> </th>
            <th class="table1" style="width: 5%"> <center> Disc. </center> </th>
            <th class="table1" style="width: 5%"> <center> Pajak </center> </th>
            <th class="table1" style="width: 12%"> <center> Subtotal </center> </th>
        
            
        </thead>
        <tbody>
        <?php

        $no_urut = 0;

            //menyimpan data sementara yang ada pada $perintah
            while ($data5 = mysqli_fetch_array($query_obat))
            {

              $no_urut ++;


           echo "<tr>";

           echo "

           <td class='table1' align='center'>".$no_urut."</td>
           <td class='table1'>". $data5['nama_barang'] ."</td>";

  
             $kd = $db->query("SELECT f.nama_petugas, u.nama FROM laporan_fee_produk f INNER JOIN user u ON f.nama_petugas = u.id  WHERE f.kode_produk = '$data5[kode_barang]' AND f.no_faktur = '$data5[no_faktur]' ");

             $kdD = $db->query("SELECT f.nama_petugas, u.nama FROM laporan_fee_produk f INNER JOIN user u ON f.nama_petugas = u.id  WHERE f.kode_produk = '$data5[kode_barang]' AND f.no_faktur = '$data5[no_faktur]' GROUP BY f.nama_petugas");
             
             $nu = mysqli_fetch_array($kd);
             
             if ($nu['nama_petugas'] != '')
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
             
            echo "<td class='table1' align='center'>". rp($data5['jumlah_barang']) ."</td>";

            if ($data5['lab'] == 'Laboratorium') {
              echo "<td class='table1'>Lab</td>";
            }
            else{
              echo "<td class='table1'>". $data5['nama'] ."</td>";              
            }
            echo "
            <td class='table1' align='right'>". rp($data5['harga']) ."</td>
            <td class='table1' align='right'>". rp($data5['potongan']) ."</td>
            <td class='table1' align='right'>". rp($data5['tax']) ."</td>
            <td class='table1' align='right'>". rp($data5['subtotal']) ."</td>
            </tr>";

            
            }

          $query_total_detail_barang = $db->query("SELECT SUM(subtotal) AS subtotal FROM detail_penjualan WHERE no_faktur = '$no_faktur' AND no_reg = '$data_inner[no_reg]' AND tipe_produk = 'Barang' AND ( lab = '' OR lab IS NULL ) ");

          $data_total_detail_barang = mysqli_fetch_array($query_total_detail_barang);

          echo "<tr>
            <td class='table1' align='right'></td>
            <td class='table1' style='color:red'>TOTAL</td>
            <td class='table1' align='right'></td>
            <td class='table1' align='right'></td>
            <td class='table1' align='right'></td>
            <td class='table1' align='right'></td>
            <td class='table1' align='right'></td>
            <td class='table1' align='right'></td>
            <td class='table1' align='right' style='color:red'>". rp($data_total_detail_barang['subtotal']) ."</td>
            </tr>";
          

        ?>
        </tbody>

    </table>
    <br>


  <?php }  # END <!-- JIKA ADA Laboratorium maka akan ditampilkan -->

        # query untuk ngecek apakh ada  Jasa / Tindakan  di detail penjualan
    $query_jasa = $db->query("SELECT dp.nama_barang, dp.no_faktur, dp.kode_barang, dp.jumlah_barang, dp.lab, dp.harga, dp.potongan, dp.tax, dp.subtotal, s.nama FROM detail_penjualan dp INNER JOIN satuan s ON dp.satuan = s.id WHERE dp.no_reg = '$data_inner[no_reg]' AND dp.tipe_produk = 'Jasa' AND (dp.lab IS NULL OR dp.lab = '') ");
    $cek_jasa = mysqli_num_rows($query_jasa);

        if ($cek_jasa > 0){ #<!-- JIKA ADA Jasa / Tindakan  maka akan ditampilkan -->

     ?>

<!-- TINDAKAN (JASA) -->
<h5><b><u>Jasa / Tindakan </u></b></h5>
  <table id="tabel_jasa" class="table table-bordered table-sm">
        <thead>
            <th class="table1" style="width: 3%"> <center> No. </center> </th>
            <th class="table1" style="width: 35%"> <center> Nama Produk </center> </th>
            <th class="table1" style="width: 40%"> <center> Petugas </center> </th>
            <th class="table1" style="width: 5%"> <center> Qty </center> </th>
            <th class="table1" style="width: 5%"> <center> Satuan </center> </th>
            <th class="table1" style="width: 15%"> <center> Harga </center> </th>
            <th class="table1" style="width: 5%"> <center> Disc. </center> </th>
            <th class="table1" style="width: 5%"> <center> Pajak </center> </th>
            <th class="table1" style="width: 12%"> <center> Subtotal </center> </th>
        
            
        </thead>
        <tbody>
        <?php

        $no_urut = 0;


            //menyimpan data sementara yang ada pada $perintah
            while ($data5 = mysqli_fetch_array($query_jasa))
            {

              $no_urut ++;


           echo "<tr>";

           echo "

           <td class='table1' align='center'>".$no_urut."</td>
           <td class='table1'>". $data5['nama_barang'] ."</td>";

  
             $kd = $db->query("SELECT f.nama_petugas, u.nama FROM laporan_fee_produk f INNER JOIN user u ON f.nama_petugas = u.id  WHERE f.kode_produk = '$data5[kode_barang]' AND f.no_faktur = '$data5[no_faktur]' ");

             $kdD = $db->query("SELECT f.nama_petugas, u.nama FROM laporan_fee_produk f INNER JOIN user u ON f.nama_petugas = u.id  WHERE f.kode_produk = '$data5[kode_barang]' AND f.no_faktur = '$data5[no_faktur]' GROUP BY f.nama_petugas");
             
             $nu = mysqli_fetch_array($kd);
             
             if ($nu['nama_petugas'] != '')
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
             
            echo "<td class='table1' align='center'>". rp($data5['jumlah_barang']) ."</td>";

            if ($data5['lab'] == 'Laboratorium') {
              echo "<td class='table1'>Lab</td>";
            }
            else{
              echo "<td class='table1'>". $data5['nama'] ."</td>";              
            }
            echo "
            <td class='table1' align='right'>". rp($data5['harga']) ."</td>
            <td class='table1' align='right'>". rp($data5['potongan']) ."</td>
            <td class='table1' align='right'>". rp($data5['tax']) ."</td>
            <td class='table1' align='right'>". rp($data5['subtotal']) ."</td>
            </tr>";

            
            }

          $query_total_detail_jasa = $db->query("SELECT SUM(subtotal) AS subtotal_jasa FROM detail_penjualan WHERE no_faktur = '$no_faktur' AND no_reg = '$data_inner[no_reg]' AND tipe_produk = 'Jasa' AND ( lab = '' OR lab IS NULL ) ");

          $data_total_detail_jasa = mysqli_fetch_array($query_total_detail_jasa);


          echo "<tr>
            <td class='table1' align='right'></td>
            <td class='table1' style='color:red'>TOTAL</td>
            <td class='table1' align='right'></td>
            <td class='table1' align='right'></td>
            <td class='table1' align='right'></td>
            <td class='table1' align='right'></td>
            <td class='table1' align='right'></td>
            <td class='table1' align='right'></td>
            <td class='table1' align='right' style='color:red'>". rp($data_total_detail_jasa['subtotal_jasa']) ."</td>
            </tr>";

        ?>
        </tbody>
    </table>
    <br>


  <?php }  # END <!-- JIKA  LABORATORIUM maka akan ditampilkan -->

    $query_lab = $db->query("SELECT nama_barang, no_faktur, kode_barang, jumlah_barang, lab, harga, potongan, tax, subtotal FROM detail_penjualan WHERE no_reg = '$data_inner[no_reg]' AND tipe_produk = 'Jasa' AND lab = 'Laboratorium' ");
    $cek_lab = mysqli_num_rows($query_lab);

    if ($cek_lab > 0){ #<!-- JIKA LABORATORIUM  maka akan ditampilkan -->

     ?>

<!-- LABORATORIUM -->
<h5><b><u>Laboratorium </u></b></h5>

  <table id="tabel_jasa" class="table table-bordered table-sm">
        <thead>
            <th class="table1" style="width: 3%"> <center> No. </center> </th>
            <th class="table1" style="width: 35%"> <center> Nama Produk </center> </th>
            <th class="table1" style="width: 40%"> <center> Petugas </center> </th>
            <th class="table1" style="width: 5%"> <center> Qty </center> </th>
            <th class="table1" style="width: 5%"> <center> Satuan </center> </th>
            <th class="table1" style="width: 15%"> <center> Harga </center> </th>
            <th class="table1" style="width: 5%"> <center> Disc. </center> </th>
            <th class="table1" style="width: 5%"> <center> Pajak </center> </th>
            <th class="table1" style="width: 12%"> <center> Subtotal </center> </th>
        
            
        </thead>
        <tbody>
        <?php

        $no_urut = 0;


            //menyimpan data sementara yang ada pada $perintah
            while ($data5 = mysqli_fetch_array($query_lab))
            {

              $no_urut ++;


           echo "<tr>";

           echo "

           <td class='table1' align='center'>".$no_urut."</td>
           <td class='table1'>". $data5['nama_barang'] ."</td>";

  
             $kd = $db->query("SELECT f.nama_petugas, u.nama FROM laporan_fee_produk f INNER JOIN user u ON f.nama_petugas = u.id  WHERE f.kode_produk = '$data5[kode_barang]' AND f.no_faktur = '$data5[no_faktur]' ");

             $kdD = $db->query("SELECT f.nama_petugas, u.nama FROM laporan_fee_produk f INNER JOIN user u ON f.nama_petugas = u.id  WHERE f.kode_produk = '$data5[kode_barang]' AND f.no_faktur = '$data5[no_faktur]' GROUP BY f.nama_petugas");
             
             $nu = mysqli_fetch_array($kd);
             
             if ($nu['nama_petugas'] != '')
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
             
            echo "<td class='table1' align='center'>". rp($data5['jumlah_barang']) ."</td>
            <td class='table1'>Lab</td>
            <td class='table1' align='right'>". rp($data5['harga']) ."</td>
            <td class='table1' align='right'>". rp($data5['potongan']) ."</td>
            <td class='table1' align='right'>". rp($data5['tax']) ."</td>
            <td class='table1' align='right'>". rp($data5['subtotal']) ."</td>
            </tr>";

            
            }

          $query_total_detail_lab = $db->query("SELECT SUM(subtotal) AS subtotal_lab FROM detail_penjualan WHERE no_faktur = '$no_faktur' AND no_reg = '$data_inner[no_reg]' AND tipe_produk = 'Jasa' AND lab = 'Laboratorium' ");

          $data_total_detail_lab = mysqli_fetch_array($query_total_detail_lab);

          echo "<tr>
            <td class='table1' align='right'></td>
            <td class='table1' style='color:red'>TOTAL</td>
            <td class='table1' align='right'></td>
            <td class='table1' align='right'></td>
            <td class='table1' align='right'></td>
            <td class='table1' align='right'></td>
            <td class='table1' align='right'></td>
            <td class='table1' align='right'></td>
            <td class='table1' align='right' style='color:red'>". rp($data_total_detail_lab['subtotal_lab']) ."</td>
            </tr>";

        ?>
        </tbody>

    </table>
    <br>

<!-- LABORATORIUM -->

  <?php }  # END <!-- JIKA  Radiologi maka akan ditampilkan -->

    $query_radiologi = $db->query("SELECT nama_barang, jumlah_barang, harga, potongan, tax, subtotal FROM hasil_pemeriksaan_radiologi WHERE no_reg = '$data_inner[no_reg]'");
    $cek_radiologi = mysqli_num_rows($query_radiologi);

    if ($cek_radiologi > 0) { #<!-- JIKA Radiologi  maka akan ditampilkan -->

     ?>
<h5><b><u>Radiologi </u></b></h5>
  <table id="tabel_jasa" class="table table-bordered table-sm">
        <thead>
            <th class="table1" style="width: 3%"> <center> No. </center> </th>
            <th class="table1" style="width: 35%"> <center> Nama Produk </center> </th>
            <th class="table1" style="width: 40%"> <center> Petugas </center> </th>
            <th class="table1" style="width: 5%"> <center> Qty </center> </th>
            <th class="table1" style="width: 5%"> <center> Satuan </center> </th>
            <th class="table1" style="width: 15%"> <center> Harga </center> </th>
            <th class="table1" style="width: 5%"> <center> Disc. </center> </th>
            <th class="table1" style="width: 5%"> <center> Pajak </center> </th>
            <th class="table1" style="width: 12%"> <center> Subtotal </center> </th>
        
            
        </thead>
        <tbody>
        <?php 


           $nomor_radiologi = 0;

              while($data_hasil = mysqli_fetch_array($query_radiologi))
                {
                 
                 $nomor_radiologi++;

                  echo"<tr>
                              
                      <td class='table1' align='center'>".$nomor_radiologi."</td>   
                      <td class='table1'>".$data_hasil['nama_barang']."</td> 
                      <td class='table1' align='center'>-</td>            
                      <td class='table1' align='center'>".$data_hasil['jumlah_barang']."</td>
                      <td class='table1' align='center'>Radiologi</td>
                      <td class='table1' align='right'>". rp($data_hasil['harga']) ."</td>
                      <td class='table1' align='right'>". rp($data_hasil['potongan']) ."</td>
                      <td class='table1' align='right'>". rp($data_hasil['tax']) ."</td>
                      <td class='table1' align='right'>". rp($data_hasil['subtotal']) ."</td>
                </tr>";

                              
                            
              }

          $query_total_detail_radiologi = $db->query("SELECT SUM(subtotal) AS subtotal_radiologi FROM hasil_pemeriksaan_radiologi WHERE no_faktur = '$no_faktur' AND no_reg = '$data_inner[no_reg]' ");

          $data_total_detail_radiologi = mysqli_fetch_array($query_total_detail_radiologi);

          echo "<tr>
            <td class='table1' align='right'></td>
            <td class='table1' style='color:red'>TOTAL</td>
            <td class='table1' align='right'></td>
            <td class='table1' align='right'></td>
            <td class='table1' align='right'></td>
            <td class='table1' align='right'></td>
            <td class='table1' align='right'></td>
            <td class='table1' align='right'></td>
            <td class='table1' align='right' style='color:red'>". rp($data_total_detail_radiologi['subtotal_radiologi']) ."</td>
            </tr>";


//Untuk Memutuskan Koneksi Ke Database
mysqli_close($db); 

        ?>
        </tbody>

    </table>

<?php } ?>
<br>
        <div class="col-sm-6">
            
            <i><b><font class="satu">Terbilang :</font></b> <?php echo kekata($data_inner['total']); ?> </i> <br>
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
      <tr><td width="50%"><font class="satu">Diskon</font></td> <td> :&nbsp;</td> <td><font class="satu"> <?php echo rp($data_inner['potongan']); ?></font> </tr>
      <tr><td width="50%"><font class="satu">Biaya Admin</font></td> <td> :&nbsp;</td> <td><font class="satu"> <?php echo rp($data_inner['biaya_admin']); ?></font> </tr>
      <tr><td  width="50%"><font class="satu">Tax</font></td> <td> :&nbsp;</td> <td><font class="satu"> <?php echo rp($data_inner['tax']); ?> </font></td></tr>
      <tr><td  width="50%"><font class="satu">Total Akhir</font></td> <td> :&nbsp;</td> <td><font class="satu"> <?php echo rp($data_inner['total']); ?></font>  </td></tr>

  </tbody>
</table>

        </div>

        <div class="col-sm-3">

 <table>
  <tbody>

      <tr><td  width="40%"><font class="satu">Bayar</font></td> <td> :&nbsp;</td> <td><font class="satu"> <?php echo rp($data_inner['tunai']); ?></font> </td></tr>
      <tr><td  width="40%"><font class="satu">Kembali</font></td> <td> :&nbsp;</td> <td><font class="satu"> <?php echo rp($data_inner['sisa']); ?></font> </td></tr>
      <tr><td  width="40%"><font class="satu">Jenis Bayar</font></td> <td> :&nbsp;</td> <td><font class="satu"> <?php echo $data_inner['nama_daftar_akun']; ?></font> </td></tr>   

  </tbody>
</table>

        </div>


    <div class="col-sm-9">
    
    <font class="satu"><b>Nama <?php echo $data200['kata_ubah']; ?> <br><br><br> <font class="satu"><?php echo $data_inner['nama_pelanggan']; ?></font> </b></font>
    
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