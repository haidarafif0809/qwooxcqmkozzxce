<?php  session_start();
include 'db.php';
include 'sanitasi.php';


$session_id = session_id();
$tipe = stringdoang($_POST['tipe_barang']);
$penjamin = stringdoang($_POST['penjamin']);
$dokter_pengirim = stringdoang($_POST['dokter']);
$no_rm  = stringdoang($_POST['no_rm']);
$no_reg  = stringdoang($_POST['no_reg']);
$petugas = $_SESSION['id'];
$waktu = date("Y-m-d H:i:s");
$bulan_php = date('m');
$tahun_php = date('Y');
  
      $kode = stringdoang($_POST['kode_barang']);
      $harga = angkadoang($_POST['harga']);
      $jumlah = angkadoang($_POST['jumlah_barang']);
      $kontras = angkadoang($_POST['kontras']);
      $nama = stringdoang($_POST['nama_barang']);
      $user = $_SESSION['nama'];
      $potongan = angkadoang($_POST['potongan']);
      $a = $harga * $jumlah;
     
      $ppn = stringdoang($_POST['ppn']);
      $tax = angkadoang($_POST['tax']);
      $hargaa  = angkadoang($_POST['hargaa']);

      $tahun_sekarang = date('Y');
      $bulan_sekarang = date('m');
      $tanggal_sekarang = date('Y-m-d');

      $waktu = date('Y-m-d H:i:s');
      $jam_sekarang = date('H:i:s');
      $tahun_terakhir = substr($tahun_sekarang, 2);

$select_produk = $db->query("SELECT nama FROM jasa_lab WHERE kode_lab = '$kode' ");
$data_produk = mysqli_fetch_array($select_produk);

if ($nama == "") {
  $nama = $data_produk['nama_barang'];
}
else{  
  $nama = stringdoang($_POST['nama_barang']);
}

$id_userr = $db->query("SELECT id FROM user WHERE nama = '$user'");
$data_id = mysqli_fetch_array($id_userr);
$id_kasir = $data_id['id'];

          if(strpos($potongan, "%") !== false)
          {
              $potongan_jadi = $a * $potongan / 100;
              $potongan_tampil = $potongan_jadi;
          }
          else{

             $potongan_jadi = $potongan;
             $potongan_tampil = $potongan;
          }


  
              

               
// MENGHITUNG PERSEN
if ($ppn == 'Exclude')
{

 $a = $harga * $jumlah;

 $x = $a - $potongan_tampil;

   $tax_persen = $x * $tax / 100;

}
elseif ($ppn == 'Include') 
{

          $a = $harga * $jumlah;

            $satu = 1;

              $x = $a - $potongan_tampil;

              $hasil_tax = $satu + ($tax / 100);

              $hasil_tax2 = $x / $hasil_tax;

              $tax_persen = $x - $hasil_tax2;

}
else
{
  $tax_persen = 0;
}


// MENGHITUNG SUBTOTAL 
if ($ppn == 'Exclude') {
              $subtotal1 = $harga * $jumlah;
              $xyz = $subtotal1 - $potongan_jadi;

              $cari_pajak = $xyz * $tax / 100;

              $subtotal = $subtotal1 - $potongan_jadi + round($cari_pajak); 


}

else

{

$subtotal = $harga * $jumlah - $potongan_jadi; 

} 
                          

          $query6 = "INSERT INTO tbs_penjualan_radiologi (session_id, kode_barang, nama_barang, jumlah_barang, harga, subtotal, tipe_barang, potongan, tax, tanggal, jam, radiologi, no_reg, kontras, dokter_pengirim) VALUES ('$session_id','$kode','$nama','$jumlah','$hargaa','$subtotal','$tipe','$potongan_tampil','$tax_persen','$tanggal_sekarang','$jam_sekarang','Radiologi','$no_reg', '$kontras', '$dokter_pengirim')";

          if ($db->query($query6) === TRUE)
          { 
                         
          } 
          else 
          {

          echo "Error: " . $query6 . "<br>" . $db->error;

          }


 
 
?>

      