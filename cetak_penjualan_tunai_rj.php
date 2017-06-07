<?php session_start();


include 'header.php';
include 'sanitasi.php';
include 'db.php';



$no_reg = $_GET['no_reg'];
$potongan = $_GET['potongan'];
$biaya_admin = $_GET['biaya_admin'];
$total = $_GET['total'];
$tunai = $_GET['tunai'];
$sisa = $_GET['sisa'];
$no_rm = $_GET['no_rm'];
$nama_pasien = $_GET['nama_pasien'];
$tanggal = date('Y-m-d');

$row = $db->query("SELECT * FROM tbs_penjualan WHERE no_reg = '$no_reg' ");
$data_row = mysqli_num_rows($row);
if ($data_row > 0) {
        $query0 = $db->query("SELECT r.id, r.no_rm, r.nama_pasien, SUM(tp.subtotal) AS total_subtotal, SUM(tp.jumlah_barang) as total_item,  SUM(tp.tax) as pajak FROM registrasi r INNER JOIN tbs_penjualan tp on r.no_reg = tp.no_reg WHERE r.no_reg = '$no_reg' ");
        $data0 = mysqli_fetch_array($query0);
        
        $query1 = $db->query("SELECT * FROM perusahaan ");
        $data1 = mysqli_fetch_array($query1);

        
      
        
        $select_operasi = $db->query("SELECT * FROM hasil_operasi WHERE no_reg = '$no_reg'");
        
        $query4 = $db->query("SELECT status_print FROM setting_printer WHERE nama_print = 'Printer Struk' OR nama_print = 'Printer Besar'");
        $datas = mysqli_fetch_array($query4);
        $status_print = $datas['status_print'];
}
else{
        $query0 = $db->query("SELECT p.id, p.potongan,p.kode_pelanggan,p.nama,p.no_faktur,p.potongan,p.biaya_admin,p.total,p.tunai,p.sisa,p.tanggal,p.no_reg,dp.id as iddp, sum(dp.subtotal) as total_subtotal, SUM(dp.jumlah_barang) as total_item, SUM(dp.tax) as pajak FROM penjualan p inner join detail_penjualan dp on p.no_reg = dp.no_reg WHERE p.no_reg = '$no_reg' ");
        $data0 = mysqli_fetch_array($query0);

        $query1 = $db->query("SELECT * FROM perusahaan ");
        $data1 = mysqli_fetch_array($query1);


       
        $select_operasi = $db->query("SELECT * FROM hasil_operasi WHERE no_reg = '$data0[no_reg]'");

        $query4 = $db->query("SELECT status_print FROM setting_printer WHERE nama_print = 'Printer Struk' OR nama_print = 'Printer Besar'");
        $datas = mysqli_fetch_array($query4);
        $status_print = $datas['status_print'];
}




    
 ?>
 <script type="text/javascript" src="js/jquery-2.2.3.min.js"></script>  
 <script src="https://unpkg.com/dexie@latest/dist/dexie.js"></script>

  <?php echo $data1['nama_perusahaan']; ?><br>
  <?php echo $data1['alamat_perusahaan']; ?><br><br>

===================<br>
  <table>
  <tbody>
    <tr>
<td>No RM </td><td>&nbsp;:&nbsp;</td><td> <?php echo $no_rm;?></td></tr><tr>
<?php if ($nama_pasien == ""): ?> 
  <td>Nama Pasien </td><td>&nbsp;:&nbsp;</td><td> <?php echo $no_rm;?></td>
<?php else: ?>  
  <td>Nama Pasien </td><td>&nbsp;:&nbsp;</td><td> <?php echo $nama_pasien;?></td>
<?php endif ?>
    </tr>
  </tbody>
</table>
===================<br>
 <table>
  <tbody>
    <tr>
<?php if ($data_row > 0): ?>
  <td>No. REG</td><td>&nbsp;:&nbsp;</td><td> <?php echo $no_reg; ?></td></tr><tr>  
<?php else: ?>
  <td>No. Faktur</td><td>&nbsp;:&nbsp;</td><td> <?php echo $data0['no_faktur']; ?></td></tr><tr>
<?php endif ?>

<td>Kasir </td><td>&nbsp;:&nbsp;</td><td> <?php echo $_SESSION['nama']; ?></td>
    </tr>
  </tbody>
</table>
===================<br>
 <table>

  <tbody id="tbody-detail">

<?php 
           while ($out_operasi = mysqli_fetch_array($select_operasi))
           {

              $select_or = $db->query("SELECT id_operasi,nama_operasi FROM operasi");
              $outin = mysqli_fetch_array($select_or);
                 
              echo '<tr>';

              if($out_operasi['operasi'] == $outin['id_operasi'])
              {
                  echo' <td width:"50%"> '. $outin['nama_operasi'] .' </td> ';
              }
                  echo' <td style="padding:3px"> </td> 
                        <td style="padding:3px"></td>
                        <td style="padding:3px"> '. rp($out_operasi['harga_jual']) .'</td> 

              </tr>';

           }
//Untuk Memutuskan Koneksi Ke Database

mysqli_close($db);            
           
           ?> 
           
 </tbody>
</table>
    ===================<br>
 <table>
  <tbody>
      <tr><td  width="50%">Total Item</td> <td> :</td> <td> <?php echo rp($data0['total_item']); ?> </td></tr>
      <tr><td width="50%">Subtotal</td> <td> :</td> <td><?php echo rp($data0['total_subtotal']);?> </tr>
      <tr><td width="50%">Diskon</td> <td> :</td> <td><?php echo rp($potongan);?> </tr>
      <tr><td  width="50%">Pajak</td> <td> :</td> <td> <?php echo rp($data0['pajak']);?> </td></tr>
      <tr><td  width="50%">Biaya Admin</td> <td> :</td> <td> <?php echo rp($biaya_admin);?> </td></tr>
      <tr><td width="50%">Total Penjualan</td> <td> :</td> <td><?php echo rp($total) ?> </tr>
      <tr><td  width="50%">Tunai</td> <td> :</td> <td> <?php echo rp($tunai); ?> </td></tr>
      <tr><td  width="50%">Kembalian</td> <td> :</td> <td> <?php echo rp($sisa); ?>  </td></tr>
            

  </tbody>
</table>
    ===================<br>
    ===================<br>
    Tanggal : <?php echo tanggal($tanggal);?><br>
    ===================<br><br>
    Terima Kasih<br>
    Semoga Lekas Sembuh...<br>
    Telp. <?php echo $data1['no_telp']; ?><br>


 <script>
$(document).ready(function(){
 


   var db = new Dexie("database_penjualan");
    
       db.version(1).stores({
         
        detail_penjualan : 'id,no_reg,kode_barang,nama_barang,jumlah_barang,harga,subtotal,satuan,potongan'  
      });

       var no_reg = '<?php echo $no_reg ?>';
       var status_print = '<?php echo $status_print ?>';

       db.detail_penjualan.where('no_reg').equals(no_reg).each(function(data,i){
            
        var data_detail_penjualan = '<tr><td width:"50%"> '+ data.nama_barang+' </td><td style="padding:3px"> '+ data.jumlah_barang +'</td><td style="padding:3px"> '+ data.harga +'</td><td style="padding:3px"> '+ data.subtotal + ' </td></tr>';
        if (status_print == 'Detail') {
            $("#tbody-detail").append(data_detail_penjualan);
        }
      
                
        });
           


});
</script>

 </body>
 </html>
