<?php session_start();


include 'header.php';
include 'sanitasi.php';
include 'db.php';


  $no_faktur = $_GET['no_faktur'];

    $query0 = $db->query("SELECT rs.tanggal_masuk,p.no_reg,p.biaya_admin,p.id,p.no_faktur,p.total,p.kode_pelanggan,p.keterangan,p.cara_bayar,p.tanggal,p.tanggal_jt,p.jam,p.user,p.sales,p.kode_meja,p.status,p.potongan,p.tax,p.sisa,p.kredit,p.kode_gudang,p.tunai,pl.nama_pelanggan,pl.wilayah,dp.satuan,dp.jumlah_barang,dp.subtotal,dp.nama_barang,dp.harga, da.nama_daftar_akun, s.nama, pl.alamat_sekarang AS alamat, s.nama AS nama_satuan FROM penjualan p LEFT JOIN detail_penjualan dp ON p.no_faktur = dp.no_faktur LEFT JOIN pelanggan pl ON p.kode_pelanggan = pl.kode_pelanggan LEFT JOIN daftar_akun da ON p.cara_bayar = da.kode_daftar_akun LEFT JOIN satuan s ON dp.satuan = s.id LEFT JOIN registrasi rs ON rs.no_reg = p.no_reg  WHERE p.no_faktur = '$no_faktur' ORDER BY p.id DESC");
     $data_inner = mysqli_fetch_array($query0);

     $select_pasien = $db_pasien->query("SELECT nama_pelanggan, alamat_sekarang FROM pelanggan WHERE kode_pelanggan = '$data_inner[kode_pelanggan]' ORDER BY id DESC");
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
    $t_awal_subtotal = $data05['t_subtotal'];

    $query_orp = $db->query("SELECT SUM(harga_jual) as t_operasi FROM hasil_operasi WHERE no_reg = '$data_inner[no_reg]'");
    $data_or = mysqli_fetch_array($query_orp);
    $t_operasi = $data_or['t_operasi'];
    $t_subtotal = $t_awal_subtotal + $t_operasi;

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



    <center> <h4> <b> Faktur Penjualan </b> </h4> </center>


  <div class="row">
    <div class="col-sm-9">
        

 <table>
  <tbody>
      <tr><td width="25%"><font class="satu">No Faktur</font></td> <td> :&nbsp;</td> <td><font class="satu"><?php echo $data_inner['no_faktur']; ?></font> </tr>
      <tr><td  width="25%"><font class="satu"><?php echo $data200['kata_ubah']; ?></font></td> <td> :&nbsp;</td> <td> <font class="satu"><?php echo $data_pasien['nama_pelanggan']; ?></font> </td></tr>
      <tr><td  width="25%"><font class="satu">Alamat</font></td> <td> :&nbsp;</td> <td><font class="satu"> <?php echo $data_pasien['alamat_sekarang']; ?> </font></td></tr>
      <tr><td  width="25%"><font class="satu">Ket.</font></td> <td> :&nbsp;</td> <td><font class="satu"> <?php echo $data_inner['keterangan']; ?> </font></td></tr>

            

  </tbody>
</table>


    </div>

    <div class="col-sm-3">
 <table>
  <tbody>

 <tr><td width="50%"><font class="satu"> Tanggal Masuk </td> <td> :&nbsp;&nbsp;</td> <td><?php echo tanggal($data_inner['tanggal_masuk']);?></font> </td></tr> 

 <tr><td width="50%"><font class="satu"> Tanggal Keluar </td> <td> :&nbsp;&nbsp;</td> <td><?php echo tanggal($data_inner['tanggal']);?></font> </td></tr> 

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

<h6><b>Kamar</b></h6>

<table id="tableuser" class="table table-bordered table-sm">
        <thead>
            <th class="table1" style="width: 25%"> <center> Waktu  </center> </th>
            <th class="table1" style="width: 50%"> <center> Nama Produk </center> </th>
            <th class="table1" style="width: 25%"> <center> Petugas </center> </th>
            <th class="table1" style="width: 5%"> <center> Qty </center> </th>
            <th class="table1" style="width: 5%"> <center> Satuan </center> </th>
            <th class="table1" style="width: 15%"> <center> Harga </center> </th>
            <th class="table1" style="width: 5%"> <center> Disc. </center> </th>
            <th class="table1" style="width: 5%"> <center> Pajak </center> </th>
            <th class="table1" style="width: 12%"> <center> Subtotal </center> </th>
        
            
        </thead>
        <tbody>
        <?php

            $query5 = $db->query("SELECT * FROM detail_penjualan WHERE no_faktur = '$no_faktur' AND tipe_produk = 'Bed' ");
            //menyimpan data sementara yang ada pada $perintah
            while ($data5 = mysqli_fetch_array($query5))
            {

              $kode = $db->query("SELECT dp.satuan, s.nama FROM detail_penjualan dp LEFT JOIN satuan s ON dp.satuan = s.id  WHERE dp.kode_barang = '$data5[kode_barang]' ");
              $satuan_b = mysqli_fetch_array($kode);
              $satuan = $satuan_b['nama'];




           echo "<tr>";

           echo "

           <td class='table1' style='font-size:15px' >". $data5['tanggal'] ." ". $data5['jam'] ."</td>
            <td class='table1' style='font-size:15px' >". $data5['nama_barang'] ."</td>";

$kd = $db->query("SELECT f.nama_petugas, u.nama FROM laporan_fee_produk f INNER JOIN user u ON f.nama_petugas = u.id  WHERE f.kode_produk = '$data5[kode_barang]' AND f.no_faktur = '$no_faktur' ");

             $kdD = $db->query("SELECT f.nama_petugas, u.nama FROM laporan_fee_produk f INNER JOIN user u ON f.nama_petugas = u.id  WHERE f.kode_produk = '$data5[kode_barang]' AND f.no_faktur = '$no_faktur' ");
             
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

            echo "<td class='table1' style='font-size:15px' align='center'>". rp($data5['jumlah_barang']) ."</td>";


              echo "<td class='table1' style='font-size:15px' >". $satuan ."</td>";              
            
            echo "
            <td class='table1' style='font-size:15px' align='right'>". rp($data5['harga']) ."</td>
            <td class='table1' style='font-size:15px' align='right'>". rp($data5['potongan']) ."</td>
            <td class='table1' style='font-size:15px' align='right'>". rp($data5['tax']) ."</td>
            <td class='table1' style='font-size:15px' align='right'>". rp($data5['subtotal']) ."</td>
            </tr>";

            
            }

            $query_ambil_bed = $db->query("SELECT SUM(subtotal) AS sub FROM detail_penjualan WHERE no_faktur = '$no_faktur' AND tipe_produk = 'Bed' ");
            //menyimpan data sementara yang ada pada $perintah
            $data_ambil_bed = mysqli_fetch_array($query_ambil_bed);
            $subtotal_bed = $data_ambil_bed['sub'];

?>
        </tbody>
    </table>

<h6 align="right"><b>Subtotal Kamar : <?php echo rp($subtotal_bed); ?></b></h6>

<h6><b>Jasa & Tindakan </b></h6>

<table id="tableuser" class="table table-bordered table-sm">
        <thead>
            <th class="table1" style="width: 25%"> <center> Waktu  </center> </th>
            <th class="table1" style="width: 50%"> <center> Nama Produk </center> </th>
            <th class="table1" style="width: 25%"> <center> Petugas </center> </th>
            <th class="table1" style="width: 5%"> <center> Qty </center> </th>
            <th class="table1" style="width: 5%"> <center> Satuan </center> </th>
            <th class="table1" style="width: 15%"> <center> Harga </center> </th>
            <th class="table1" style="width: 5%"> <center> Disc. </center> </th>
            <th class="table1" style="width: 5%"> <center> Pajak </center> </th>
            <th class="table1" style="width: 12%"> <center> Subtotal </center> </th>
        
            
        </thead>
        <tbody>
        <?php

            $query5 = $db->query("SELECT dp.lab,dp.kode_barang,dp.tanggal,dp.jam,dp.nama_barang,dp.jumlah_barang,dp.harga,dp.potongan,dp.tax,dp.subtotal FROM detail_penjualan dp LEFT JOIN barang bb ON dp.kode_barang = bb.kode_barang  WHERE dp.no_faktur = '$no_faktur' AND bb.berkaitan_dgn_stok = 'Jasa' AND ( dp.lab = '' OR dp.lab IS NULL )");
            //menyimpan data sementara yang ada pada $perintah
            while ($data5 = mysqli_fetch_array($query5))
            {

              $kode = $db->query("SELECT dp.satuan, s.nama FROM detail_penjualan dp LEFT JOIN satuan s ON dp.satuan = s.id  WHERE dp.kode_barang = '$data5[kode_barang]' ");
              $satuan_b = mysqli_fetch_array($kode);
              $satuan = $satuan_b['nama'];




           echo "<tr>";

           echo "

           <td class='table1' style='font-size:15px' >". $data5['tanggal'] ." ". $data5['jam'] ."</td>
            <td class='table1' style='font-size:15px' >". $data5['nama_barang'] ."</td>";

$kd = $db->query("SELECT f.nama_petugas, u.nama FROM laporan_fee_produk f INNER JOIN user u ON f.nama_petugas = u.id  WHERE f.kode_produk = '$data5[kode_barang]' AND f.no_faktur = '$no_faktur' ");

             $kdD = $db->query("SELECT f.nama_petugas, u.nama FROM laporan_fee_produk f INNER JOIN user u ON f.nama_petugas = u.id  WHERE f.kode_produk = '$data5[kode_barang]' AND f.no_faktur = '$no_faktur' ");
             
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

            echo "<td class='table1' style='font-size:15px' align='center'>". rp($data5['jumlah_barang']) ."</td>";

      
              echo "<td class='table1' style='font-size:15px' >". $satuan ."</td>";              
            
            echo "
            <td class='table1' style='font-size:15px' align='right'>". rp($data5['harga']) ."</td>
            <td class='table1' style='font-size:15px' align='right'>". rp($data5['potongan']) ."</td>
            <td class='table1' style='font-size:15px' align='right'>". rp($data5['tax']) ."</td>
            <td class='table1' style='font-size:15px' align='right'>". rp($data5['subtotal']) ."</td>
            </tr>";

            
            }

            $query_ambil_jasa = $db->query("SELECT SUM(dp.subtotal) AS sub FROM detail_penjualan dp LEFT JOIN barang bb ON dp.kode_barang = bb.kode_barang  WHERE dp.no_faktur = '$no_faktur' AND bb.berkaitan_dgn_stok = 'Jasa' AND ( dp.lab = '' OR dp.lab IS NULL ) ");
            //menyimpan data sementara yang ada pada $perintah
            $data_ambil_jasa = mysqli_fetch_array($query_ambil_jasa);
            $subtotal_jasa = $data_ambil_jasa['sub'];


?>
   </tbody>
</table>

<h6 align="right"><b>Subtotal Jasa & Tindakan : <?php echo rp($subtotal_jasa); ?></b></h6>

<h6><b> Obat Obatan / Alkes </b></h6>

<table id="tableuser" class="table table-bordered table-sm">
        <thead>
            <th class="table1" style="width: 25%"> <center> Waktu  </center> </th>
            <th class="table1" style="width: 50%"> <center> Nama Produk </center> </th>
            <th class="table1" style="width: 25%"> <center> Petugas </center> </th>
            <th class="table1" style="width: 5%"> <center> Qty </center> </th>
            <th class="table1" style="width: 5%"> <center> Satuan </center> </th>
            <th class="table1" style="width: 15%"> <center> Harga </center> </th>
            <th class="table1" style="width: 5%"> <center> Disc. </center> </th>
            <th class="table1" style="width: 5%"> <center> Pajak </center> </th>
            <th class="table1" style="width: 12%"> <center> Subtotal </center> </th>
        
            
        </thead>
        <tbody>
        <?php

            $query5 = $db->query("SELECT dp.kode_barang,dp.tanggal,dp.jam,dp.nama_barang,dp.jumlah_barang,dp.harga,dp.potongan,dp.tax,dp.subtotal FROM detail_penjualan dp LEFT JOIN barang bb ON dp.kode_barang = bb.kode_barang  WHERE dp.no_faktur = '$no_faktur' AND bb.berkaitan_dgn_stok = 'Barang' AND ( dp.lab = '' OR dp.lab IS NULL ) ");
            //menyimpan data sementara yang ada pada $perintah
            while ($data5 = mysqli_fetch_array($query5))
            {

              $kode = $db->query("SELECT dp.satuan, s.nama FROM detail_penjualan dp LEFT JOIN satuan s ON dp.satuan = s.id  WHERE dp.kode_barang = '$data5[kode_barang]' ");
              $satuan_b = mysqli_fetch_array($kode);
              $satuan = $satuan_b['nama'];




           echo "<tr>";

           echo "

           <td class='table1' style='font-size:15px' >". $data5['tanggal'] ." ". $data5['jam'] ."</td>
            <td class='table1' style='font-size:15px' >". $data5['nama_barang'] ."</td>";

            $kd = $db->query("SELECT f.nama_petugas, u.nama FROM laporan_fee_produk f INNER JOIN user u ON f.nama_petugas = u.id  WHERE f.kode_produk = '$data5[kode_barang]' AND f.no_faktur = '$no_faktur' ");

             $kdD = $db->query("SELECT f.nama_petugas, u.nama FROM laporan_fee_produk f INNER JOIN user u ON f.nama_petugas = u.id  WHERE f.kode_produk = '$data5[kode_barang]' AND f.no_faktur = '$no_faktur' ");
             
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

            echo "<td class='table1' style='font-size:15px' align='center'>". rp($data5['jumlah_barang']) ."</td>";

              echo "<td class='table1' style='font-size:15px' >". $satuan ."</td>";              
          
            echo "
            <td class='table1' style='font-size:15px' align='right'>". rp($data5['harga']) ."</td>
            <td class='table1' style='font-size:15px' align='right'>". rp($data5['potongan']) ."</td>
            <td class='table1' style='font-size:15px' align='right'>". rp($data5['tax']) ."</td>
            <td class='table1' style='font-size:15px' align='right'>". rp($data5['subtotal']) ."</td>
            </tr>";

            
            }

           $query_ambil_barang = $db->query("SELECT SUM(dp.subtotal) AS sub FROM detail_penjualan dp LEFT JOIN barang bb ON dp.kode_barang = bb.kode_barang  WHERE dp.no_faktur = '$no_faktur' AND bb.berkaitan_dgn_stok = 'Barang' AND ( dp.lab = '' OR dp.lab IS NULL ) ");
            //menyimpan data sementara yang ada pada $perintah
            $data_ambil_barang = mysqli_fetch_array($query_ambil_barang);
            $subtotal_barang = $data_ambil_barang['sub'];

?>
   </tbody>
</table>

<h6 align="right"><b>Subtotal Obat Obatan / Alkes : <?php echo rp($subtotal_barang); ?></b></h6>

<h6><b>Laboratorium</b></h6>

<table id="tableuser" class="table table-bordered table-sm">
        <thead>
            <th class="table1" style="width: 25%"> <center> Waktu  </center> </th>
            <th class="table1" style="width: 50%"> <center> Nama Produk </center> </th>
            <th class="table1" style="width: 25%"> <center> Petugas </center> </th>
            <th class="table1" style="width: 5%"> <center> Qty </center> </th>
            <th class="table1" style="width: 5%"> <center> Satuan </center> </th>
            <th class="table1" style="width: 15%"> <center> Harga </center> </th>
            <th class="table1" style="width: 5%"> <center> Disc. </center> </th>
            <th class="table1" style="width: 5%"> <center> Pajak </center> </th>
            <th class="table1" style="width: 12%"> <center> Subtotal </center> </th>
        
            
        </thead>
        <tbody>
        <?php

      $query5 = $db->query("SELECT * FROM detail_penjualan WHERE no_faktur = '$no_faktur' AND lab = 'Laboratorium' ");
            //menyimpan data sementara yang ada pada $perintah
            while ($data5 = mysqli_fetch_array($query5))
            {

           echo "<tr>";

           echo "

           <td class='table1' style='font-size:15px' >". $data5['tanggal'] ." ". $data5['jam'] ."</td>
            <td class='table1' style='font-size:15px' >". $data5['nama_barang'] ."</td>";

            $kd = $db->query("SELECT f.nama_petugas, u.nama FROM laporan_fee_produk f INNER JOIN user u ON f.nama_petugas = u.id  WHERE f.kode_produk = '$data5[kode_barang]' AND f.no_faktur = '$no_faktur' ");

             $kdD = $db->query("SELECT f.nama_petugas, u.nama FROM laporan_fee_produk f INNER JOIN user u ON f.nama_petugas = u.id  WHERE f.kode_produk = '$data5[kode_barang]' AND f.no_faktur = '$no_faktur' ");
             
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

            echo "<td class='table1' style='font-size:15px' align='center'>". rp($data5['jumlah_barang']) ."</td>";


              echo "<td class='table1' style='font-size:15px' >Lab</td>";              
            
            echo "
            <td class='table1' style='font-size:15px' align='right'>". rp($data5['harga']) ."</td>
            <td class='table1' style='font-size:15px' align='right'>". rp($data5['potongan']) ."</td>
            <td class='table1' style='font-size:15px' align='right'>". rp($data5['tax']) ."</td>
            <td class='table1' style='font-size:15px' align='right'>". rp($data5['subtotal']) ."</td>
            </tr>";

            
            }

            $query_ambil_lab = $db->query("SELECT SUM(subtotal) AS sub FROM detail_penjualan WHERE no_faktur = '$no_faktur' AND lab = 'Laboratorium' ");
            //menyimpan data sementara yang ada pada $perintah
            $data_ambil_lab = mysqli_fetch_array($query_ambil_lab);
            $subtotal_lab = $data_ambil_lab['sub'];

?>
   </tbody>
</table>

<h6 align="right"><b>Subtotal Laboratorium : <?php echo rp($subtotal_lab); ?></b></h6>


<h6><b>Operasi</b></h6>

<table id="tableuser" class="table table-bordered table-sm">
        <thead>
            <th class="table1" style="width: 25%"> <center> Waktu  </center> </th>
            <th class="table1" style="width: 50%"> <center> Nama Produk </center> </th>
            <th class="table1" style="width: 25%"> <center> Petugas </center> </th>
            <th class="table1" style="width: 5%"> <center> Qty </center> </th>
            <th class="table1" style="width: 5%"> <center> Satuan </center> </th>
            <th class="table1" style="width: 15%"> <center> Harga </center> </th>
            <th class="table1" style="width: 5%"> <center> Disc. </center> </th>
            <th class="table1" style="width: 5%"> <center> Pajak </center> </th>
            <th class="table1" style="width: 12%"> <center> Subtotal </center> </th>
        
            
        </thead>
        <tbody>
<?php        
// OPERASI TABLE
 $take_data_or = $db->query("SELECT * FROM hasil_operasi WHERE no_reg = '$data_inner[no_reg]'");
        $no_urut = 0;
    while($out_operasi = mysqli_fetch_array($take_data_or))
      {
                   
        $select_or = $db->query("SELECT id_operasi,nama_operasi FROM operasi WHERE id_operasi = '$out_operasi[operasi]'");
        $outin = mysqli_fetch_array($select_or);
                   
        $select_det_or = $db->query("SELECT dop.id_user, u.nama FROM hasil_detail_operasi dop INNER JOIN user u ON dop.id_user = u.id WHERE dop.no_reg = '$out_operasi[no_reg]'");
        $data_detail_operasi = mysqli_fetch_array($select_det_or);
        
        $nomor = $no_urut +1;

        echo"<tr>
                    
            <td class='table1' style='font-size:15px' align='center'>".$out_operasi['waktu'] ."</td>";

            if($out_operasi['operasi'] == $outin['id_operasi'])
            {
              echo"<td class='table1' align='left'>". $outin['nama_operasi'] ."</td>";
            }
            else{
              echo "<td> </td>";
            }
            

            echo " 
            <td class='table1' align='center'>".$data_detail_operasi['nama']."</td>
            <td class='table1' align='center'>-</td>
            <td class='table1' align='center'>-</td>
            <td class='table1' align='right'>". rp($out_operasi['harga_jual']) ."</td>
            <td class='table1' align='right'>-</td>
            <td class='table1' align='right'>-</td>
            <td class='table1' align='right'>". rp($out_operasi['harga_jual']) ."</td>
      </tr>";

                    
                  
    }
//Untuk Memutuskan Koneksi Ke Database

           $query_ambil_operasi = $db->query("SELECT SUM(harga_jual) AS sub FROM hasil_operasi WHERE no_reg = '$data_inner[no_reg]' ");
            //menyimpan data sementara yang ada pada $perintah
            $data_ambil_operasi = mysqli_fetch_array($query_ambil_operasi);
            $subtotal_operasi = $data_ambil_operasi['sub'];


        ?>
        </tbody>
    </table>

<h6 align="right"><b>Subtotal Operasi : <?php echo rp($subtotal_operasi); ?></b></h6>


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

      <tr><td width="50%"><font class="satu">Subtotal Seluruh</font></td> <td> :&nbsp;</td> <td><font class="satu"> <?php echo rp($t_subtotal); ?> </font></tr>
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