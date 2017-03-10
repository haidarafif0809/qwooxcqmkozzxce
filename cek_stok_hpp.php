   <?php      
include 'db.php';
include 'sanitasi.php';

$no_faktur = stringdoang($_POST['no_faktur']);
$kode_barang = stringdoang($_POST['kode_barang']);
$jumlah_barang = stringdoang($_POST['jumlah_barang']);


   $hpp_masuk_pembelian = $db->query ("SELECT no_faktur_hpp_masuk FROM hpp_keluar WHERE no_faktur_hpp_masuk = '$data1[no_faktur]' AND kode_barang = '$data1[kode_barang]'");
       $row_hpp_keluar = mysqli_num_rows($hpp_masuk_pembelian);


      $pilih = $db->query("SELECT no_faktur_pembelian FROM detail_pembayaran_hutang WHERE no_faktur_pembelian = '$data1[no_faktur]'");
      $row_hutang = mysqli_num_rows($pilih);

      if ($row_hutang > 0 || $row_hpp_keluar > 0 ) {


      	?>