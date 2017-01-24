<?php 
include 'db.php';
include_once 'sanitasi.php';

session_start();
 
 $kode = stringdoang($_POST['kode_barang']);
 $nama = stringdoang($_POST['nama_barang']);
 $jumlah = stringdoang($_POST['jumlah_barang']);
 $harga = angkadoang($_POST['harga']);
 $pajak = stringdoang($_POST['tax']);
 $diskon = stringdoang($_POST['potongan']);
 $no_rm = stringdoang($_POST['no_rm']);
 $satuan = stringdoang($_POST['satuan']);
 $tipe_produk = stringdoang($_POST['ber_stok']);
 $no_reg = stringdoang($_POST['no_reg']);
 $dokter = stringdoang($_POST['dokter']);
 $dokterpenanggungjawab = stringdoang($_POST['dokter_pj']);
 $penjamin = stringdoang($_POST['penjamin']);
 $poli = stringdoang($_POST['asal_poli']);
 $level_harga = stringdoang($_POST['level_harga']);
 $petugas = stringdoang($_POST['petugas_kasir']);
 $perawat = stringdoang($_POST['petugas_paramedik']);
 $apoteker = stringdoang($_POST['petugas_farmasi']);
 $petugas_lain = stringdoang($_POST['petugas_lain']);
 $pajak_tbs_rupiah = stringdoang($_POST['pajak_tbs_rupiah']);
 $ppn_input = stringdoang($_POST['ppn_input']);

 $session_id = session_id();

$select_produk = $db->query("SELECT nama_barang FROM barang WHERE kode_barang = '$kode' ");
$data_produk = mysqli_fetch_array($select_produk);

if ($nama == "") {
  $nama = $data_produk['nama_barang'];
}
else{  
 $nama = stringdoang($_POST['nama_barang']);
}


          $a = $harga * $jumlah;
          
 if(strpos($diskon, "%") !== false)
          {
              $potongan_jadi = $a * $diskon / 100;
              $potongan_tampil = $potongan_jadi;
          }
          else{

             $potongan_jadi = $diskon;
             $potongan_tampil = $diskon;
          }



          $satu = 1;

              $x = $a - $potongan_tampil;

              $hasil_tax = $satu + ($pajak / 100);

              $hasil_tax2 = $x / $hasil_tax;

              $pajak_persen = $x - $hasil_tax2;

    if ($ppn_input == 'Include') {
        $tax_persen = round($pajak_persen);
    }
    else{
      $tax_persen = round($pajak_tbs_rupiah);
    }


$tanggal_sekarang = date('Y-m-d');

$waktu = date('Y-m-d H:i:s');
$jam = date('H:i:s');



$query0 = $db->query("SELECT no_faktur FROM tbs_penjualan WHERE kode_barang = '$kode' AND no_reg  ='$no_reg'  ");
$cek = mysqli_num_rows($query0);


$query3 = $db->query("SELECT * FROM barang WHERE kode_barang = '$kode'");
$harga = mysqli_fetch_array($query3);


$sdd = $db->query("SELECT kode_barang,no_faktur,jam,tanggal FROM tbs_penjualan WHERE kode_barang = '$kode' 
  AND no_reg = '$no_reg' ORDER BY id DESC LIMIT 1");
$my2 = mysqli_fetch_array($sdd);

$jam3 = $my2['jam'];
$tanggal = $my2['tanggal'];
$waktus = $tanggal." ".$jam3;




$query65 = $db->query("SELECT HOUR(TIMEDIFF('$waktu' , '$waktus')) AS waktu_selisih ");
$my22 = mysqli_fetch_array($query65);
$waktu_selisih = $my22['waktu_selisih'];

                       // AWAL DARI PERHITUNGAN HARGA 1 UNTUK PERSONAL 


if ($waktu_selisih < 1 AND $cek > 0 )
  //hitung persentase dokter update harga 1
{

$harga_1 = angkadoang($_POST['harga']);
$subtotal = $harga_1 * $jumlah;
$subtotal_d =  $subtotal - $diskon;
$subtotal_p = $subtotal_d + $pajak;

$subtotal_tanpa_pajak = $harga_1 * $jumlah - $potongan_jadi; 


if ($ppn_input == 'Include') {
  $subtotal = $subtotal_tanpa_pajak;
}
else{
   $subtotal = $subtotal_tanpa_pajak + $pajak_tbs_rupiah;
}

$query687 = " INSERT INTO tbs_penjualan
(no_reg,kode_barang,nama_barang,jumlah_barang,harga,subtotal,tipe_barang,tanggal,jam,potongan,tax,session_id,satuan)
 VALUES ('$no_reg','$kode','$nama','$jumlah','$harga_1','$subtotal','$tipe_produk','$tanggal_sekarang','$jam','$potongan_tampil','$tax_persen','$session_id','$satuan')";
if ($db->query($query687) === TRUE) {
  
} 
else 
      {
    echo "Error: " . $query687 . "<br>" . $db->error;
      }




$cek_persen_dokter1 = $db->query("SELECT * FROM fee_produk WHERE nama_petugas = '$dokterpenanggungjawab' AND kode_produk = '$kode'");
$data_persen_dokter1 = mysqli_fetch_array($cek_persen_dokter1);

if ($data_persen_dokter1['jumlah_prosentase'] != 0 AND $data_persen_dokter1['jumlah_uang'] == 0 )
{
$hasil_hitung_fee_persen_harga1 = $subtotal * $data_persen_dokter1['jumlah_prosentase'] / 100;
$query_persen_dok3 = $db->query("UPDATE tbs_fee_produk SET nama_petugas= '$dokterpenanggungjawab' , jumlah_fee = jumlah_fee + '$hasil_hitung_fee_persen_harga1' WHERE nama_petugas = '$dokterpenanggungjawab' AND kode_produk = '$kode'");

} 

// END hitung persentase dokter update harga 1

else

// Hitung Nominal dokter update harga 1

{

$hasil_hitung_fee_nominal_dokter_harga1 = $data_persen_dokter1['jumlah_uang'] * $jumlah;
$query_nominal_dok3 = $db->query("UPDATE tbs_fee_produk SET nama_petugas= '$dokterpenanggungjawab' , jumlah_fee = jumlah_fee + '$hasil_hitung_fee_nominal_dokter_harga1'  WHERE nama_petugas = '$dokterpenanggungjawab' AND kode_produk = '$kode'");

}
// END Hitung Nominal dokter update harga 1


// MULAI PERSENTASE APOTEKER HARGA 1

$cek_persen_apoteker1 = $db->query("SELECT * FROM fee_produk WHERE nama_petugas = '$apoteker' AND kode_produk = '$kode'");
$data_persen_apoteker1 = mysqli_fetch_array($cek_persen_apoteker1);

if ($data_persen_apoteker1['jumlah_prosentase'] != 0 AND $data_persen_apoteker1['jumlah_uang'] == 0 )
{

$hasil_hitung_fee_persen_apoteker_harga1 = $subtotal * $data_persen_apoteker1['jumlah_prosentase'] / 100;

$query_persen_apoteker3 = $db->query("UPDATE tbs_fee_produk SET nama_petugas= '$apoteker' , jumlah_fee = jumlah_fee + '$hasil_hitung_fee_persen_apoteker_harga1' WHERE   nama_petugas = '$apoteker' AND kode_produk = '$kode'");

}
// AKHIR PSERSENTASE APOTEKER HARGA 1

else

// HITUNGAN NOMINAL APOTEKER HARGA 1
{

$hasil_hitung_fee_nominal_apoteker_harga1 = $data_persen_apoteker1['jumlah_uang'] * $jumlah;
$query_nominal_apoteker3 = $db->query("UPDATE tbs_fee_produk SET nama_petugas= '$apoteker' , jumlah_fee = jumlah_fee + '$hasil_hitung_fee_nominal_apoteker_harga1'  WHERE  nama_petugas = '$apoteker' AND  kode_produk = '$kode'");

}
// ENDING NOMINAL APOTEKER HARGA 1

// mulai persentase perawat harga 1
$cek_persen_perawat_harga1 = $db->query("SELECT * FROM fee_produk WHERE nama_petugas = '$perawat' AND kode_produk = '$kode'");
$data_persen_perawat_harga1 = mysqli_fetch_array($cek_persen_perawat_harga1);

if ($data_persen_perawat_harga1['jumlah_prosentase'] != 0 AND $data_persen_perawat_harga1['jumlah_uang'] == 0 )
{

$hasil_hitung_fee_persen_perawat_harga1 = $subtotal * $data_persen_perawat_harga1['jumlah_prosentase'] / 100;
$query_persen_perawat3 = $db->query("UPDATE tbs_fee_produk SET nama_petugas= '$perawat' , jumlah_fee = jumlah_fee + '$hasil_hitung_fee_persen_perawat_harga1' WHERE  nama_petugas = '$perawat' AND kode_produk = '$kode'");

}
// akhir persentase perawat harga 1

else

// nominal perawat harga 1
{

$hasil_hitung_fee_nominal_perawat_harga1 = $data_persen_perawat_harga1['jumlah_uang'] * $jumlah;
$query_nominal_perawat3 = $db->query("UPDATE tbs_fee_produk SET nama_petugas= '$perawat' , jumlah_fee = jumlah_fee + '$hasil_hitung_fee_nominal_perawat_harga1' WHERE nama_petugas = '$perawat' AND  kode_produk = '$kode'");

}
// akhir nominal perawat harga 1





// MULAI PERSENTASE PETUGAS LAIN HARGA 1

$cek_persen_pet_lain1 = $db->query("SELECT * FROM fee_produk WHERE nama_petugas = '$petugas_lain' AND kode_produk = '$kode'");
$data_persen_pet_lain1 = mysqli_fetch_array($cek_persen_pet_lain1);

if ($data_persen_pet_lain1['jumlah_prosentase'] != 0 AND $data_persen_pet_lain1['jumlah_uang'] == 0 )
{

$hasil_hitung_fee_persen_pet_lain_harga1 = $subtotal * $data_persen_pet_lain1['jumlah_prosentase'] / 100;
$query_persen_pet_lain_1 = $db->query("UPDATE tbs_fee_produk SET nama_petugas= '$petugas_lain' , jumlah_fee = jumlah_fee + '$hasil_hitung_fee_persen_pet_lain_harga1' WHERE nama_petugas = '$petugas_lain' AND kode_produk = '$kode'");

}
// AKHIR PSERSENTASE PETUGAS LAIN HARGA 1

else

// HITUNGAN NOMINAL PETUGAS LAIN HARGA 1
{

$hasil_hitung_fee_nominal_pet_lain_harga1 = $data_persen_pet_lain1['jumlah_uang'] * $jumlah;
$query_nominal_pet_lain_1 = $db->query("UPDATE tbs_fee_produk SET nama_petugas= '$petugas_lain' , jumlah_fee = jumlah_fee + '$hasil_hitung_fee_nominal_pet_lain_harga1' WHERE nama_petugas = '$petugas_lain' AND kode_produk = '$kode'");

}
// ENDING NOMINAL PETUGAS LAIN  HARGA 1




// MULAI PERSENTASE UNTUK PETUGAS 1
$cek_persen_petugas_harga1 = $db->query("SELECT * FROM fee_produk WHERE nama_petugas = '$petugas' AND kode_produk = '$kode'");
$data_persen_petugas_harga1 = mysqli_fetch_array($cek_persen_petugas_harga1);

if ($data_persen_petugas_harga1['jumlah_prosentase'] != 0 AND $data_persen_petugas_harga1['jumlah_uang'] == 0 )
{

$hasil_hitung_fee_persen_petugas_harga1 = $subtotal * $data_persen_petugas_harga1['jumlah_prosentase'] / 100;
$query_persen_petugas3 = $db->query("UPDATE tbs_fee_produk SET nama_petugas= '$petugas' , jumlah_fee = jumlah_fee + '$hasil_hitung_fee_persen_petugas_harga1' WHERE nama_petugas = '$petugas' AND kode_produk = '$kode'");

}
// AKHIR PERSENTASE UNTUK PETUGAS 1






else

// START NOMINAL UNTUK PETUGAS 1
{

$hasil_hitung_fee_nominal_petugas_harga1 = $data_persen_petugas_harga1['jumlah_uang'] * $jumlah;
$query_nominal_petugas3 = $db->query("UPDATE tbs_fee_produk SET nama_petugas= '$petugas' , jumlah_fee = jumlah_fee + '$hasil_hitung_fee_nominal_petugas_harga1' WHERE nama_petugas = '$petugas' AND kode_produk = '$kode'");

}
// ENDING UNTUK PETUGAS 1


// SELESAI UNTUK UPDATE DOKTER,PERAWAT DAN APOTEKER & PETUGAS UNTUK (PERSENTASE DAN NOMINAL) HARGA 1


} // WARNING DO NOT ANYTING ABOUT THIS BREAKET !!!



$harga_1 = angkadoang($_POST['harga']);
$subtotal = $harga_1 * $jumlah;
$subtotal_d =  $subtotal - $diskon;
$subtotal_p = $subtotal_d + $pajak;


$subtotal_tanpa_pajak = $harga_1 * $jumlah - $potongan_jadi; 

if ($ppn_input == 'Include') {
  $subtotal = $subtotal_tanpa_pajak;
}
else{
   $subtotal = $subtotal_tanpa_pajak + $pajak_tbs_rupiah;
}
                             // START PERHITUNGAN FEE HARGA 1 INSERT

// PERHITUNGAN UNTUK FEE DOKTER
$ceking = $db->query("SELECT * FROM fee_produk WHERE nama_petugas = '$dokter' AND kode_produk = '$kode'");
$cek_fee_dokter1 = mysqli_num_rows($ceking);
$dataui = mysqli_fetch_array($ceking);

if ($cek_fee_dokter1 > 0){
if ($dataui['jumlah_prosentase'] != 0 AND $dataui['jumlah_uang'] == 0 )

{  
$hasil_hitung_fee_persen = $subtotal * $dataui['jumlah_prosentase'] / 100;

$insert1 = "INSERT INTO tbs_fee_produk 
(no_reg,no_rm,nama_petugas,kode_produk,nama_produk,jumlah_fee,tanggal,jam,waktu,session_id) VALUES 
('$no_reg','$no_rm','$dokter','$kode','$nama','$hasil_hitung_fee_persen','$tanggal_sekarang','$jam','$waktu','$session_id')";
if ($db->query($insert1) === TRUE) {
  
  } 

else {
    echo "Error: " . $insert1 . "<br>" . $db->error;
  }

}



else
{
$hasil_hitung_fee_nominal = $dataui['jumlah_uang'] * $jumlah;

$insert2 = "INSERT INTO tbs_fee_produk 
(no_reg,no_rm,session_id,nama_petugas,kode_produk,nama_produk,jumlah_fee,tanggal,jam,waktu) VALUES 
('$no_reg','$no_rm','$session_id','$dokter','$kode','$nama','$hasil_hitung_fee_nominal','$tanggal_sekarang','$jam','$waktu')";
if ($db->query($insert2) === TRUE) {
  
    } 
else {
    echo "Error: " . $insert2 . "<br>" . $db->error;
    }

  }
} // if penutup if dokter di harga1 > 0
// ENDING PERHITUNGAN UNTUK FEE DOKTER


// PERHITUNGAN UNTUK FEE APOTEKER
$cek_apoteker = $db->query("SELECT * FROM fee_produk WHERE nama_petugas = '$apoteker' AND kode_produk = '$kode'");
$cek_fee_apoteker1 = mysqli_num_rows($cek_apoteker);
$dataui_apoteker = mysqli_fetch_array($cek_apoteker);

if ($cek_fee_apoteker1 > 0){
if ($dataui_apoteker['jumlah_prosentase'] != 0 AND $dataui_apoteker['jumlah_uang'] == 0 )

{  
$hasil_hitung_fee_persen_apoteker = $subtotal * $dataui_apoteker['jumlah_prosentase'] / 100;

$insert_apoteker = "INSERT INTO tbs_fee_produk 
(no_reg,no_rm,nama_petugas,kode_produk,nama_produk,jumlah_fee,tanggal,jam,waktu,session_id) VALUES 
('$no_reg','$no_rm','$apoteker','$kode','$nama','$hasil_hitung_fee_persen_apoteker','$tanggal_sekarang','$jam','$waktu','$session_id')";
if ($db->query($insert_apoteker) === TRUE) {

  } 
else 
      {
    echo "Error: " . $insert_apoteker . "<br>" . $db->error;
      }

  }

else

{

$hasil_hitung_fee_nominal_apoteker = $dataui_apoteker['jumlah_uang'] * $jumlah;


$insert2_apoteker = "INSERT INTO tbs_fee_produk 
(no_reg,no_rm,nama_petugas,kode_produk,nama_produk,jumlah_fee,tanggal,jam,waktu,session_id) VALUES 
('$no_reg','$no_rm','$apoteker','$kode','$nama','$hasil_hitung_fee_nominal_apoteker','$tanggal_sekarang','$jam','$waktu','$session_id')";
if ($db->query($insert2_apoteker) === TRUE) {
  
    } 
else
  {
    echo "Error: " . $insert2_apoteker . "<br>" . $db->error;
      }
  }
} // penutup if apoteker di harga1 > 0
// ENDING PERHITUNGAN UNTUK FEE APOTEKER


// PERHITUNGAN UNTUK FEE PERAWAT
$cek_perawat = $db->query("SELECT * FROM fee_produk WHERE nama_petugas = '$perawat' AND kode_produk = '$kode'");
$cek_fee_perawat1 = mysqli_num_rows($cek_perawat);
$dataui_perawat = mysqli_fetch_array($cek_perawat);

if ($cek_fee_perawat1 > 0){
if ($dataui_perawat['jumlah_prosentase'] != 0 AND $dataui_perawat['jumlah_uang'] == 0 )

{  
$hasil_hitung_fee_persen_perawat = $subtotal * $dataui_perawat['jumlah_prosentase'] / 100;

$insert_perawat = "INSERT INTO tbs_fee_produk 
(no_reg,no_rm,nama_petugas,kode_produk,nama_produk,jumlah_fee,tanggal,jam,waktu,session_id) VALUES 
('$no_reg','$no_rm','$perawat','$kode','$nama','$hasil_hitung_fee_persen_perawat','$tanggal_sekarang','$jam','$waktu','$session_id')";
if ($db->query($insert_perawat) === TRUE) {
  
} 
else 
      {
    echo "Error: " . $insert_perawat . "<br>" . $db->error;
        }
}

else

{
$hasil_hitung_fee_nominal_perawat = $dataui_perawat['jumlah_uang'] * $jumlah;

$insert2_perawat = "INSERT INTO tbs_fee_produk 
(no_reg,no_rm,nama_petugas,kode_produk,nama_produk,jumlah_fee,tanggal,jam,waktu,session_id) VALUES 
('$no_reg','$no_rm','$perawat','$kode','$nama','$hasil_hitung_fee_nominal_perawat','$tanggal_sekarang','$jam','$waktu','$session_id')";
if ($db->query($insert2_perawat) === TRUE) {
  
  } 
else
    {
    echo "Error: " . $insert2_perawat . "<br>" . $db->error;
    }

  }
} // breaket penutup if di perawat di harga1 > 0
// ENDING PERHITUNGAN UNTUK FEE PERAWAT




// PERHITUNGAN UNTUK FEE PETUGAS LAIN (INSERT)
$cek_petugas_lain = $db->query("SELECT * FROM fee_produk WHERE nama_petugas = '$petugas_lain' AND kode_produk = '$kode'");
$cek_fee_petugas_lain1 = mysqli_num_rows($cek_petugas_lain);
$dataui_petugas_lain = mysqli_fetch_array($cek_petugas_lain);

if ($cek_fee_petugas_lain1 > 0){
if ($dataui_petugas_lain['jumlah_prosentase'] != 0 AND $dataui_petugas_lain['jumlah_uang'] == 0 )

{  
$hasil_hitung_fee_persen_petugas_lain = $subtotal * $dataui_petugas_lain['jumlah_prosentase'] / 100;

$insert_petugas_lain = "INSERT INTO tbs_fee_produk 
(no_reg,no_rm,nama_petugas,kode_produk,nama_produk,jumlah_fee,tanggal,jam,waktu,session_id) VALUES 
('$no_reg','$no_rm','$petugas_lain','$kode','$nama','$hasil_hitung_fee_persen_petugas_lain','$tanggal_sekarang','$jam','$waktu','$session_id')";
if ($db->query($insert_petugas_lain) === TRUE) {
  
} 
else 
      {
    echo "Error: " . $insert_petugas_lain . "<br>" . $db->error;
        }
}

else

{
$hasil_hitung_fee_nominal_petugas_lain = $dataui_petugas_lain['jumlah_uang'] * $jumlah;

$insert1_petugas_lain = "INSERT INTO tbs_fee_produk 
(no_reg,no_rm,nama_petugas,kode_produk,nama_produk,jumlah_fee,tanggal,jam,waktu,session_id) VALUES 
('$no_reg','$no_rm','$petugas_lain','$kode','$nama','$hasil_hitung_fee_nominal_petugas_lain','$tanggal_sekarang','$jam','$waktu','$session_id')";
if ($db->query($insert1_petugas_lain) === TRUE) {
  
  } 
else
    {
    echo "Error: " . $insert1_petugas_lain . "<br>" . $db->error;
    }

  }
} // breaket penutup if di PETUGAS LAIN di harga1 > 0
// ENDING PERHITUNGAN UNTUK FPETUGAS LAIN




// PERHITUNGAN UNTUK FEE PETUGAS
$cek_petugas = $db->query("SELECT * FROM fee_produk WHERE nama_petugas = '$petugas' AND kode_produk = '$kode'");
$cek_fee_petugas1 = mysqli_num_rows($cek_petugas);
$dataui_petugas = mysqli_fetch_array($cek_petugas);

if ($cek_fee_petugas1 > 0) {
if ($dataui_petugas['jumlah_prosentase'] != 0 AND $dataui_petugas['jumlah_uang'] == 0 )

{  
$hasil_hitung_fee_persen_petugas = $subtotal * $dataui_petugas['jumlah_prosentase'] / 100;

$insert1_petugas = "INSERT INTO tbs_fee_produk 
(no_reg,no_rm,nama_petugas,kode_produk,nama_produk,jumlah_fee,tanggal,jam,waktu,session_id) VALUES 
('$no_reg','$no_rm','$petugas','$kode','$nama','$hasil_hitung_fee_persen_petugas','$tanggal_sekarang','$jam','$waktu','$session_id')";
if ($db->query($insert1_petugas) === TRUE) 
{
  
} 
else 
        {
    echo "Error: " . $insert1_petugas . "<br>" . $db->error;
        }

}

else
{
$hasil_hitung_fee_nominal_petugas = $dataui_petugas['jumlah_uang'] * $jumlah;


$insert2_petugas = "INSERT INTO tbs_fee_produk 
(no_reg,no_rm,nama_petugas,kode_produk,nama_produk,jumlah_fee,tanggal,jam,waktu,session_id) VALUES 
('$no_reg','$no_rm','$petugas','$kode','$nama','$hasil_hitung_fee_nominal_petugas','$tanggal_sekarang','$jam','$waktu','$session_id')";
if ($db->query($insert2_petugas) === TRUE) 
{
  
  } 
else 
    {
    echo "Error: " . $insert2_petugas . "<br>" . $db->error;
    }

  }
} // penutup if petugas di harga 1 > 0
// ENDING PERHITUNGAN UNTUK FEE PETUGAS


                         // AKHIR PERHITUNGAN FEE HARGA 1


// QUERY UNTUK INSERT KE TBS PENJUALAN SETELAH PERHITUNGAN SELESAI

$query6 = " INSERT INTO tbs_penjualan
(no_reg,kode_barang,nama_barang,jumlah_barang,harga,subtotal,tipe_barang,tanggal,jam,potongan,tax,session_id,satuan)
 VALUES ('$no_reg','$kode','$nama','$jumlah','$harga_1','$subtotal','$tipe_produk','$tanggal_sekarang','$jam','$potongan_tampil','$tax_persen','$session_id','$satuan')";
if ($db->query($query6) === TRUE) {
  
} 
else 
      {
    echo "Error: " . $query6 . "<br>" . $db->error;
      }


 ?>
  <?php
//menampilkan semua data yang ada pada tabel tbs penjualan dalam DB
                $perintah = $db->query("SELECT tp.id,tp.kode_barang,tp.satuan,tp.nama_barang,tp.jumlah_barang,tp.harga,tp.subtotal,tp.potongan,tp.tax,s.nama,tp.tanggal,tp.jam,tp.no_reg,tp.tipe_barang FROM tbs_penjualan tp INNER JOIN satuan s ON tp.satuan = s.id WHERE tp.no_reg = '$no_reg' AND tp.lab IS NULL ORDER BY tp.id DESC LIMIT 1");
                
$data1 = mysqli_fetch_array($perintah);
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


                echo "<td style='font-size:15px' align='right' class='edit-jumlah' data-id='".$data1['id']."'><span id='text-jumlah-".$data1['id']."'>". $data1['jumlah_barang'] ."</span> <input type='hidden' id='input-jumlah-".$data1['id']."' value='".$data1['jumlah_barang']."' class='input_jumlah' data-id='".$data1['id']."' autofocus='' data-kode='".$data1['kode_barang']."' data-harga='".$data1['harga']."' data-tipe='".$data1['tipe_barang']."' data-satuan='".$data1['satuan']."' onkeydown='return numbersonly(this, event);'> </td>

                <td style='font-size:15px'>". $data1['nama'] ."</td>
                <td style='font-size:15px' align='right'>". rp($data1['harga']) ."</td>
                <td style='font-size:15px' align='right'><span id='text-subtotal-".$data1['id']."'>". rp($data1['subtotal']) ."</span></td>
                <td style='font-size:15px' align='right'><span id='text-potongan-".$data1['id']."'>". rp($data1['potongan']) ."</span></td>
                <td style='font-size:15px' align='right'><span id='text-tax-".$data1['id']."'>". rp($data1['tax']) ."</span></td>
          <td>". $data1['tanggal']." ".$data1['jam']."</td>";



               echo "<td style='font-size:15px'> <button class='btn btn-danger btn-sm btn-hapus-tbs' id='hapus-tbs-".$data1['id']."' data-id='". $data1['id'] ."' data-kode-barang='". $data1['kode_barang'] ."' data-barang='". $data1['nama_barang'] ."' data-subtotal='". $data1['subtotal'] ."'>Hapus</button> </td> 

                </tr>";

                ?>

<!--datatable-->
<script type="text/javascript">
  $(function () {
  $("#tbs_penjualan").dataTable({ordering : false});
  });  
</script>
<!--end datatable-->

 
                