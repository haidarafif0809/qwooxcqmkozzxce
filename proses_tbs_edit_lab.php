<?php 
include 'db.php';
include_once 'sanitasi.php';

session_start();
$session_id = session_id();
$tipe = stringdoang($_POST['tipe_barang']);
$penjamin = stringdoang($_POST['penjamin']);
$analis = stringdoang($_POST['apoteker']);
$no_rm  = stringdoang($_POST['no_rm']);
$no_faktur  = stringdoang($_POST['no_faktur']);
$petugas = $_SESSION['id'];
$waktu = date("Y-m-d H:i:sa");
$bulan_php = date('m');
$tahun_php = date('Y');
  
      $kode = stringdoang($_POST['kode_barang']);
      $harga = angkadoang($_POST['harga']);
      $jumlah = angkadoang($_POST['jumlah_barang']);
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
      $jam_sekarang = date('H:i:sa');
      $tahun_terakhir = substr($tahun_sekarang, 2);


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
                         

          $query0 = $db->query("SELECT * FROM tbs_penjualan WHERE kode_barang = '$kode' AND no_faktur = '$no_faktur'");
          $cek    = mysqli_num_rows($query0);
                                  // STARETTO HARGA BELI 1

          if ($cek > 0 )

          {

  
                  $xml = $db->prepare("UPDATE tbs_penjualan SET jumlah_barang = jumlah_barang + ?, subtotal = subtotal + ?, potongan = ? WHERE kode_barang = ? AND no_faktur = ?");

                  $xml->bind_param("iiss",
                      $jumlah, $potongan_tampil, $kode, $no_faktur);

                  $xml->execute();


          }//dont touch me 

          else
                         
          {
                          

          $query6 = " INSERT INTO tbs_penjualan (kode_barang,nama_barang,jumlah_barang,harga,subtotal,tipe_barang,potongan,tax,tanggal,jam,lab,no_faktur) VALUES 
          ('$kode','$nama','$jumlah','$hargaa','$subtotal','$tipe','$potongan_tampil','$tax_persen','$tanggal_sekarang','$jam_sekarang','Laboratorium','$no_faktur')";

          if ($db->query($query6) === TRUE)
          { 
                         
          } 
          else 
          {

          echo "Error: " . $query6 . "<br>" . $db->error;

          }


          }                     
               

               //FEE PETUGAS ANALIS
    $query9 = $db->query("SELECT jumlah_prosentase,jumlah_uang FROM fee_produk WHERE nama_petugas = '$analis' AND kode_produk = '$kode'");
    $cek9 = mysqli_fetch_array($query9);
    $prosentase = $cek9['jumlah_prosentase'];
    $nominal = $cek9['jumlah_uang'];


    if ($prosentase != 0){
   
          $subtotal_prosentase = $harga * $jumlah;
          
          $fee_prosentase_produk = $prosentase * $subtotal_prosentase / 100;

          $query10 = "INSERT INTO tbs_fee_produk (nama_petugas, no_faktur, kode_produk, nama_produk, jumlah_fee, tanggal, jam,waktu,no_rm) VALUES ('$analis', '$no_faktur', '$kode','$nama', '$fee_prosentase_produk', '$tanggal_sekarang', '$jam_sekarang','$waktu','$no_rm')";

            if ($db->query($query10) === TRUE) 
                {
                
              } 
            else 
                {
                echo "Error: " . $query10 . "<br>" . $db->error;
                } 

    }

    elseif ($nominal != 0) {

      $fee_nominal_produk = $nominal * $jumlah;

      $query100 = $db->query("INSERT INTO tbs_fee_produk (nama_petugas, no_faktur, kode_produk, nama_produk, jumlah_fee, tanggal, jam,waktu,no_rm) VALUES ('$analis', '$no_faktur', '$kode', '$nama', '$fee_nominal_produk', '$tanggal_sekarang', '$jam_sekarang','$waktu','$no_rm')");
              if ($db->query($query100) === TRUE) 
                {
                
              } 
            else 
                {
                echo "Error: " . $query100. "<br>" . $db->error;
                } 

    }// END PETUGAS ANALIS
                         

//FEE PETUGAS KASIR
    $query9 = $db->query("SELECT * FROM fee_produk WHERE nama_petugas = '$petugas' AND kode_produk = '$kode'");
    $cek9 = mysqli_fetch_array($query9);
    $prosentase = $cek9['jumlah_prosentase'];
    $nominal = $cek9['jumlah_uang'];


    if ($prosentase != 0){
   
          $subtotal_prosentase = $harga * $jumlah;
          
          $fee_prosentase_produk = $prosentase * $subtotal_prosentase / 100;

          $query10 = "INSERT INTO tbs_fee_produk (nama_petugas, no_faktur, kode_produk, nama_produk, jumlah_fee, tanggal, jam,waktu,no_rm) VALUES ('$petugas', '$no_faktur', '$kode','$nama', '$fee_prosentase_produk', '$tanggal_sekarang', '$jam_sekarang','$waktu','$no_rm')";

                if ($db->query($query10) === TRUE) 
                {
                
              } 
            else 
                {
                echo "Error: " . $query10. "<br>" . $db->error;
                } 

    }

    elseif ($nominal != 0) {

      $fee_nominal_produk = $nominal * $jumlah;

      $query10 = "INSERT INTO tbs_fee_produk (nama_petugas, no_faktur, kode_produk, nama_produk, jumlah_fee, tanggal, jam,waktu,no_rm) VALUES ('$petugas', '$no_faktur', '$kode', '$nama', '$fee_nominal_produk', '$tanggal_sekarang', '$jam_sekarang','$waktu','$no_rm')";
      
              if ($db->query($query10) === TRUE) 
                {
                
              } 
            else 
                {
                echo "Error: " . $query10. "<br>" . $db->error;
                } 
    }// END PETUGAS ANALIS

 
 
?>
<?php
  //menampilkan semua data yang ada pada tabel tbs penjualan dalam DB
                $perintah = $db->query("SELECT * FROM tbs_penjualan WHERE no_faktur = '$no_faktur' AND lab = 'Laboratorium' ORDER BY id DESC LIMIT 1 ");
                
                //menyimpan data sementara yang ada pada $perintah
                
                $data1 = mysqli_fetch_array($perintah);
                echo "<tr class='tr-kode-". $data1['kode_barang'] ." tr-id-". $data1['id'] ."' data-kode-barang='".$data1['kode_barang']."'>
                <td style='font-size:15px'>". $data1['kode_barang'] ."</td>
                <td style='font-size:15px;'>". $data1['nama_barang'] ."</td>";

               $kd = $db->query("SELECT f.nama_petugas, u.nama FROM tbs_fee_produk f INNER JOIN user u ON f.nama_petugas = u.id WHERE f.kode_produk = '$data1[kode_barang]' AND f.jam = '$data1[jam]' ");
                
                $kdD = $db->query("SELECT f.nama_petugas, u.nama FROM tbs_fee_produk f INNER JOIN user u ON f.nama_petugas = u.id WHERE f.kode_produk = '$data1[kode_barang]' AND f.jam = '$data1[jam]' ");
                    
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

                echo"<td style='font-size:15px' align='right' class='edit-jumlah' data-id='".$data1['id']."'><span id='text-jumlah-".$data1['id']."'>". $data1['jumlah_barang'] ."</span> <input type='hidden' id='input-jumlah-".$data1['id']."' value='".$data1['jumlah_barang']."' class='input_jumlah' data-id='".$data1['id']."' autofocus='' data-kode='".$data1['kode_barang']."' data-tipe='".$data1['tipe_barang']."' data-harga='".$data1['harga']."' data-satuan='".$data1['satuan']."' data-tipe='".$data1['tipe_barang']."' > </td>
                <td style='font-size:15px' align='right'>". rp($data1['harga']) ."</td>
                <td style='font-size:15px' align='right'><span id='text-subtotal-".$data1['id']."'>". rp($data1['subtotal']) ."</span></td>
                <td style='font-size:15px' align='right'><span id='text-potongan-".$data1['id']."'>". rp($data1['potongan']) ."</span></td>
                <td style='font-size:15px' align='right'><span id='text-tax-".$data1['id']."'>". rp($data1['tax']) ."</span></td>";

               echo "<td style='font-size:15px' align='right'> <button class='btn btn-danger btn-sm btn-hapus-tbs' id='btn-hapus-id-".$data1['id']."' data-id='". $data1['id'] ."' data-kode-barang='". $data1['kode_barang'] ."' data-barang='". $data1['nama_barang'] ."' data-subtotal='". $data1['subtotal'] ."'>Hapus</button> </td> 

                </tr>";


//Untuk Memutuskan Koneksi Ke Database
mysqli_close($db);   
    ?>

   