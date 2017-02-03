<?php 
include 'db.php';
include_once 'sanitasi.php';

session_start();
 
 $kode = stringdoang($_POST['kode_produk']);
 $nama = stringdoang($_POST['nama_produk']);
 $jumlah = stringdoang($_POST['jumlah_produk']);
 $stok = stringdoang($_POST['stok']);
 $jenis = stringdoang($_POST['tipe_produk']);
 $no_reg = stringdoang($_POST['no_reg2']);
 $no_faktur = stringdoang($_POST['no_faktur2']);
 $diskon = stringdoang($_POST['potongan']);
 $pajak = stringdoang($_POST['pajak']);
 $dokterpenanggungjawab = stringdoang($_POST['dokter_penanggungjawab2']);
 $apoteker = stringdoang($_POST['apoteker2']);
 $perawat = stringdoang($_POST['perawat2']);
 $petugas_lain = stringdoang($_POST['p_lain2']);
 $no_rm = stringdoang($_POST['no_rm_hiid']);
 $petugas = stringdoang($_POST['petugas2']);
$penjamin = stringdoang($_POST['penjamin2']);

$jam_real =  stringdoang($_POST['jam2']);
$tanggal_sekarang = stringdoang($_POST['tanggal2']);
$waktu_sekerang = stringdoang($_POST['waktu2']);

 $tax_f = stringdoang($_POST['tax_f']);
 $diskon_f = stringdoang($_POST['diskon_f']);
$biaya_admin = stringdoang($_POST['biaya_admin_f']);


$waktu = date('Y-m-d H:i:s');
$jam = date('H:i:s');


$hpp =$db->query("SELECT  AVG(harga_barang) AS subtotal FROM  hpp_barang WHERE kode_barang = '$kode'");
$muncul = mysqli_fetch_array($hpp); 

$subtotalin = $muncul['subtotal'];
$jumlah_hpp = $jumlah * $subtotalin;


$query0 = $db->query("SELECT no_faktur FROM tbs_penjualan WHERE kode_produk = '$kode' AND no_faktur='$no_faktur'  ");
$cek = mysqli_num_rows($query0);


$query2 = $db->query(" SELECT * FROM penjamin WHERE nama = '$penjamin'");
$data2 = mysqli_fetch_array($query2);

 $level_harga = $data2['harga'];
$query3 = $db->query("SELECT * FROM produk WHERE kode_produk = '$kode'");
$harga = mysqli_fetch_array($query3);


$sdd = $db->query("SELECT kode_produk,no_faktur,jam,tanggal FROM tbs_penjualan WHERE kode_produk = '$kode' 
  AND no_faktur = '$no_faktur' ORDER BY id DESC LIMIT 1");

$my2 = mysqli_fetch_array($sdd);

$jam3 = $my2['jam'];
$tanggal = $my2['tanggal'];
$waktus = $tanggal." ".$jam3;




$query65 = $db->query("SELECT HOUR(TIMEDIFF('$waktu' , '$waktus')) AS waktu_selisih ");
$my22 = mysqli_fetch_array($query65);
$waktu_selisih = $my22['waktu_selisih'];

                       // AWAL DARI PERHITUNGAN HARGA 1 UNTUK PERSONAL 

if ($level_harga == 'harga_1')

{

if ($waktu_selisih < 1 AND $cek > 0 )
  //hitung persentase dokter update harga 1
{
   "tes1";
$harga_1 = $harga['harga_jual_1'];
$subtotal = $harga_1 * $jumlah;
$subtotal_d =  $subtotal - $diskon;
$subtotal_p = $subtotal_d + $pajak;
$subtotaljadi = $subtotal_p;


$query687 = " INSERT INTO tbs_penjualan
(no_faktur,no_reg,kode_produk,nama_produk,jumlah_produk,harga_produk,subtotal,tipe_produk,tanggal,jam,hpp,diskon,tax)
 VALUES ('$no_faktur','$no_reg','$kode','$nama','$jumlah','$harga_1','$subtotaljadi','$jenis','$tanggal_sekarang','$jam','$jumlah_hpp','$diskon','$pajak')";
if ($db->query($query687) === TRUE) {
  
} 
else 
      {
    echo "Error: " . $query687 . "<br>" . $db->error;
      }


if ($jenis == 'Jasa' ){


}

else if ($jenis == 'BHP')
{


}
else{

  $query_persen_dok2 = $db->query("UPDATE produk SET stok_produk = stok_produk - '$jumlah' WHERE kode_produk = '$kode'  ");


}

$cek_persen_dokter1 = $db->query("SELECT * FROM fee_produk WHERE nama_petugas = '$dokterpenanggungjawab' AND kode_produk = '$kode'");
$data_persen_dokter1 = mysqli_fetch_array($cek_persen_dokter1);

if ($data_persen_dokter1['jumlah_prosentase'] != 0 AND $data_persen_dokter1['jumlah_uang'] == 0 )
{
$hasil_hitung_fee_persen_harga1 = $subtotaljadi * $data_persen_dokter1['jumlah_prosentase'] / 100;
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

$hasil_hitung_fee_persen_apoteker_harga1 = $subtotaljadi * $data_persen_apoteker1['jumlah_prosentase'] / 100;
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

$hasil_hitung_fee_persen_perawat_harga1 = $subtotaljadi * $data_persen_perawat_harga1['jumlah_prosentase'] / 100;
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

$hasil_hitung_fee_persen_pet_lain_harga1 = $subtotaljadi * $data_persen_pet_lain1['jumlah_prosentase'] / 100;
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

$hasil_hitung_fee_persen_petugas_harga1 = $subtotaljadi * $data_persen_petugas_harga1['jumlah_prosentase'] / 100;
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





else

 {

  
  "tes2";
$harga_1 = $harga['harga_jual_1'];
$subtotal = $harga_1 * $jumlah;
$subtotal_d =  $subtotal - $diskon;
$subtotal_p = $subtotal_d + $pajak;
$subtotaljadi = $subtotal_p;


                             // START PERHITUNGAN FEE HARGA 1 INSERT

// PERHITUNGAN UNTUK FEE DOKTER
$ceking = $db->query("SELECT * FROM fee_produk WHERE nama_petugas = '$dokterpenanggungjawab' AND kode_produk = '$kode'");
$cek_fee_dokter1 = mysqli_num_rows($ceking);
$dataui = mysqli_fetch_array($ceking);

if ($cek_fee_dokter1 > 0){
if ($dataui['jumlah_prosentase'] != 0 AND $dataui['jumlah_uang'] == 0 )

{  
$hasil_hitung_fee_persen = $subtotaljadi * $dataui['jumlah_prosentase'] / 100;

$insert1 = "INSERT INTO tbs_fee_produk 
(no_reg,no_rm,no_faktur,nama_petugas,kode_produk,nama_produk,jumlah_fee,tanggal,jam,waktu) VALUES 
('$no_reg','$no_rm','$no_faktur','$dokterpenanggungjawab','$kode','$nama','$hasil_hitung_fee_persen','$tanggal_sekarang','$jam','$waktu')";
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
(no_reg,no_rm,no_faktur,nama_petugas,kode_produk,nama_produk,jumlah_fee,tanggal,jam,waktu) VALUES 
('$no_reg','$no_rm','$no_faktur','$dokterpenanggungjawab','$kode','$nama','$hasil_hitung_fee_nominal','$tanggal_sekarang','$jam','$waktu')";
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
$hasil_hitung_fee_persen_apoteker = $subtotaljadi * $dataui_apoteker['jumlah_prosentase'] / 100;

$insert_apoteker = "INSERT INTO tbs_fee_produk 
(no_reg,no_rm,no_faktur,nama_petugas,kode_produk,nama_produk,jumlah_fee,tanggal,jam,waktu) VALUES 
('$no_reg','$no_rm','$no_faktur','$apoteker','$kode','$nama','$hasil_hitung_fee_persen_apoteker','$tanggal_sekarang','$jam','$waktu')";
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
(no_reg,no_rm,no_faktur,nama_petugas,kode_produk,nama_produk,jumlah_fee,tanggal,jam,waktu) VALUES 
('$no_reg','$no_rm','$no_faktur','$apoteker','$kode','$nama','$hasil_hitung_fee_nominal_apoteker','$tanggal_sekarang','$jam','$waktu')";
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
$hasil_hitung_fee_persen_perawat = $subtotaljadi * $dataui_perawat['jumlah_prosentase'] / 100;

$insert_perawat = "INSERT INTO tbs_fee_produk 
(no_reg,no_rm,no_faktur,nama_petugas,kode_produk,nama_produk,jumlah_fee,tanggal,jam,waktu) VALUES 
('$no_reg','$no_rm','$no_faktur','$perawat','$kode','$nama','$hasil_hitung_fee_persen_perawat','$tanggal_sekarang','$jam','$waktu')";
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
(no_reg,no_rm,no_faktur,nama_petugas,kode_produk,nama_produk,jumlah_fee,tanggal,jam,waktu) VALUES 
('$no_reg','$no_rm','$no_faktur','$perawat','$kode','$nama','$hasil_hitung_fee_nominal_perawat','$tanggal_sekarang','$jam','$waktu')";
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
$hasil_hitung_fee_persen_petugas_lain = $subtotaljadi * $dataui_petugas_lain['jumlah_prosentase'] / 100;

$insert_petugas_lain = "INSERT INTO tbs_fee_produk 
(no_reg,no_rm,no_faktur,nama_petugas,kode_produk,nama_produk,jumlah_fee,tanggal,jam,waktu) VALUES 
('$no_reg','$no_rm','$no_faktur','$petugas_lain','$kode','$nama','$hasil_hitung_fee_persen_petugas_lain','$tanggal_sekarang','$jam','$waktu')";
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
(no_reg,no_rm,no_faktur,nama_petugas,kode_produk,nama_produk,jumlah_fee,tanggal,jam,waktu) VALUES 
('$no_reg','$no_rm','$no_faktur','$petugas_lain','$kode','$nama','$hasil_hitung_fee_nominal_petugas_lain','$tanggal_sekarang','$jam','$waktu')";
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
$hasil_hitung_fee_persen_petugas = $subtotaljadi * $dataui_petugas['jumlah_prosentase'] / 100;

$insert1_petugas = "INSERT INTO tbs_fee_produk 
(no_reg,no_rm,no_faktur,nama_petugas,kode_produk,nama_produk,jumlah_fee,tanggal,jam,waktu) VALUES 
('$no_reg','$no_rm','$no_faktur','$petugas','$kode','$nama','$hasil_hitung_fee_persen_petugas','$tanggal_sekarang','$jam','$waktu')";
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
(no_reg,no_rm,no_faktur,nama_petugas,kode_produk,nama_produk,jumlah_fee,tanggal,jam,waktu) VALUES 
('$no_reg','$no_rm','$no_faktur','$petugas','$kode','$nama','$hasil_hitung_fee_nominal_petugas','$tanggal_sekarang','$jam','$waktu')";
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
(no_faktur,no_reg,kode_produk,nama_produk,jumlah_produk,harga_produk,subtotal,tipe_produk,tanggal,jam,hpp,diskon,tax)
 VALUES ('$no_faktur','$no_reg','$kode','$nama','$jumlah','$harga_1','$subtotaljadi','$jenis','$tanggal_sekarang','$jam','$jumlah_hpp','$diskon','$pajak')";
if ($db->query($query6) === TRUE) {
  
} 
else 
      {
    echo "Error: " . $query6 . "<br>" . $db->error;
      }


if ($jenis == 'Jasa' ){


}

else if ($jenis == 'BHP'){

}

else{

  $query7 = $db->query("UPDATE produk SET stok_produk = stok_produk - '$jumlah' WHERE kode_produk = '$kode' ");


}


}

}
//  AKHIR INSERT TBS_PENJUALAN DAN PERHITUNGAN AKHIR DARI FEE PRODUK HARGA 1 DAN SUDAH UPDATENYA JUGA !!!



                    // AWAL PEMBUKAAAN HARGA KE 2 UNTUK PERUSAHAAN


elseif ($level_harga == 'harga_2')

{

  if ( $cek > 0 )
{
   $harga_2 = $harga['harga_jual_2'];
   $subtotal2 = $harga_2 * $jumlah;
   $subtotal2_d2 =  $subtotal2 - $diskon;
   $subtotal2_p2 = $subtotal2_d2 + $pajak;
   $subtotaljadi2 = $subtotal2_p2;


$query6786 = " INSERT INTO tbs_penjualan
(no_faktur,no_reg,kode_produk,nama_produk,jumlah_produk,harga_produk,subtotal,tipe_produk,tanggal,jam,hpp,diskon,tax)
 VALUES ('$no_faktur','$no_reg','$kode','$nama','$jumlah','$harga_2','$subtotaljadi2','$jenis','$tanggal_sekarang','$jam','$jumlah_hpp','$diskon','$pajak')";
if ($db->query($query6786) === TRUE) {
  
} 
else 
      {
    echo "Error: " . $query6786 . "<br>" . $db->error;
      }


if ($jenis == 'Jasa' ){


}

else if ($jenis == 'BHP')
{


}
else{

  $query_persen_dok2 = $db->query("UPDATE produk SET stok_produk = stok_produk - '$jumlah' WHERE kode_produk = '$kode'  ");


}



$cek_persen_dokter2 = $db->query("SELECT * FROM fee_produk WHERE nama_petugas = '$dokterpenanggungjawab' AND kode_produk = '$kode'");
$data_persen_dokter2 = mysqli_fetch_array($cek_persen_dokter2);

if ($data_persen_dokter2['jumlah_prosentase'] != 0 AND $data_persen_dokter2['jumlah_uang'] == 0 )
{
$hasil_hitung_fee_persen_harga2 = $subtotaljadi2 * $data_persen_dokter2['jumlah_prosentase'] / 100;
$query_persen_dokter_harga_ke2 = $db->query("UPDATE tbs_fee_produk SET nama_petugas= '$dokterpenanggungjawab' , jumlah_fee = jumlah_fee + '$hasil_hitung_fee_persen_harga2' WHERE nama_petugas = '$dokterpenanggungjawab' AND kode_produk = '$kode'");

}
// END hitung persentase dokter update harga 2

else

// Hitung Nominal dokter update harga 2
{

$hasil_hitung_fee_nominal_dokter_harga2 = $data_persen_dokter2['jumlah_uang'] * $jumlah;
$query_nominal_dokter_harga_ke2 = $db->query("UPDATE tbs_fee_produk SET nama_petugas= '$dokterpenanggungjawab' , jumlah_fee = jumlah_fee + '$hasil_hitung_fee_nominal_dokter_harga2' WHERE nama_petugas = '$dokterpenanggungjawab' AND kode_produk = '$kode'");

}
// END Hitung Nominal dokter update harga 2


// MULAI PERSENTASE APOTEKER HARGA 2

$cek_persen_apoteker2 = $db->query("SELECT * FROM fee_produk WHERE nama_petugas = '$apoteker' AND kode_produk = '$kode'");
$data_persen_apoteker2 = mysqli_fetch_array($cek_persen_apoteker2);

if ($data_persen_apoteker2['jumlah_prosentase'] != 0 AND $data_persen_apoteker2['jumlah_uang'] == 0 )
{

$hasil_hitung_fee_persen_apoteker_harga2 = $subtotaljadi2 * $data_persen_apoteker2['jumlah_prosentase'] / 100;
$query_persen_apoteker_harga_ke2 = $db->query("UPDATE tbs_fee_produk SET nama_petugas= '$apoteker' , jumlah_fee = jumlah_fee + '$hasil_hitung_fee_persen_apoteker_harga2' WHERE nama_petugas = '$apoteker' AND kode_produk = '$kode'");

}
// AKHIR PSERSENTASE APOTEKER HARGA 2

else

// HITUNGAN NOMINAL APOTEKER HARGA 2
{

$hasil_hitung_fee_nominal_apoteker_harga2 = $data_persen_apoteker2['jumlah_uang'] * $jumlah;
$query_nominal_apoteker_harga_ke2 = $db->query("UPDATE tbs_fee_produk SET nama_petugas= '$apoteker' , jumlah_fee = jumlah_fee + '$hasil_hitung_fee_nominal_apoteker_harga2' WHERE nama_petugas = '$apoteker' AND kode_produk = '$kode'");

}
// ENDING NOMINAL APOTEKER HARGA 2

// mulai persentase perawat harga 2
$cek_persen_perawat_harga2 = $db->query("SELECT * FROM fee_produk WHERE nama_petugas = '$perawat' AND kode_produk = '$kode'");
$data_persen_perawat_harga2 = mysqli_fetch_array($cek_persen_perawat_harga2);

if ($data_persen_perawat_harga2['jumlah_prosentase'] != 0 AND $data_persen_perawat_harga2['jumlah_uang'] == 0 )
{

$hasil_hitung_fee_persen_perawat_harga2 = $subtotaljadi2 * $data_persen_perawat_harga2['jumlah_prosentase'] / 100;
$query_persen_perawat_harga_ke2 = $db->query("UPDATE tbs_fee_produk SET nama_petugas= '$perawat' , jumlah_fee = jumlah_fee + '$hasil_hitung_fee_persen_perawat_harga2' WHERE nama_petugas = '$perawat' AND kode_produk = '$kode'");

}
// akhir persentase perawat harga 2

else

// nominal perawat harga 2
{

$hasil_hitung_fee_nominal_perawat_harga2 = $data_persen_perawat_harga2['jumlah_uang'] * $jumlah;
$query_nominal_perawat_harga_ke2 = $db->query("UPDATE tbs_fee_produk SET nama_petugas= '$perawat' , jumlah_fee = jumlah_fee + '$hasil_hitung_fee_nominal_perawat_harga2' WHERE nama_petugas = '$perawat' AND  kode_produk = '$kode'");

}
// akhir nominal perawat harga 2



// mulai persentase perawat harga 2
$cek_persen_petugas_lain_harga2 = $db->query("SELECT * FROM fee_produk WHERE nama_petugas = '$petugas_lain' AND kode_produk = '$kode'");
$data_persen_petugas_lain_harga2 = mysqli_fetch_array($cek_persen_petugas_lain_harga2);

if ($data_persen_petugas_lain_harga2['jumlah_prosentase'] != 0 AND $data_persen_petugas_lain_harga2['jumlah_uang'] == 0 )
{

$hasil_hitung_fee_persen_pet_lain_harga2 = $subtotaljadi2 * $data_persen_petugas_lain_harga2['jumlah_prosentase'] / 100;
$query_persen_pet_lain_harga_ke2 = $db->query("UPDATE tbs_fee_produk SET nama_petugas= '$petugas_lain' , jumlah_fee = jumlah_fee + '$hasil_hitung_fee_persen_pet_lain_harga2' WHERE nama_petugas = '$petugas_lain' AND kode_produk = '$kode'");

}
// akhir persentase perawat harga 2

else

// nominal perawat harga 2
{

$hasil_hitung_fee_nominal_petugas_lain_harga2 = $data_persen_petugas_lain_harga2['jumlah_uang'] * $jumlah;
$query_nominal_pet_lain_harga_ke2 = $db->query("UPDATE tbs_fee_produk SET nama_petugas= '$petugas_lain' , jumlah_fee = jumlah_fee + '$hasil_hitung_fee_nominal_petugas_lain_harga2' WHERE nama_petugas = '$petugas_lain' AND  kode_produk = '$kode'");

}
// akhir nominal perawat harga 2



// MULAI PERSENTASE UNTUK PETUGAS 2
$cek_persen_petugas_harga2 = $db->query("SELECT * FROM fee_produk WHERE nama_petugas = '$petugas' AND kode_produk = '$kode'");
$data_persen_petugas_harga2 = mysqli_fetch_array($cek_persen_petugas_harga2);

if ($data_persen_petugas_harga2['jumlah_prosentase'] != 0 AND $data_persen_petugas_harga2['jumlah_uang'] == 0 )
{

$hasil_hitung_fee_persen_petugas_harga2 = $subtotaljadi2 * $data_persen_petugas_harga2['jumlah_prosentase'] / 100;
$query_persen_petugas_harga2 = $db->query("UPDATE tbs_fee_produk SET nama_petugas= '$petugas' , jumlah_fee = jumlah_fee + '$hasil_hitung_fee_persen_petugas_harga2' WHERE nama_petugas = '$petugas' AND kode_produk = '$kode'");

}
// AKHIR PERSENTASE UNTUK PETUGAS 2

else

// START NOMINAL UNTUK PETUGAS 2
{

$hasil_hitung_fee_nominal_petugas_harga2 = $data_persen_petugas_harga2['jumlah_uang'] * $jumlah;
$query_nominal_petugas_harga2 = $db->query("UPDATE tbs_fee_produk SET nama_petugas= '$petugas' , jumlah_fee = jumlah_fee + '$hasil_hitung_fee_nominal_petugas_harga2' WHERE nama_petugas = '$petugas' AND  kode_produk = '$kode'");

}
// ENDING UNTUK PETUGAS 2

// SELESAI UNTUK UPDATE DOKTER,PERAWAT, APOTEKER DAN PETUGAS (PERSENTASE DAN NOMINIL) UNTUK HARGA 2


} // WARNING DO NOT ANYTING ABOUT THIS BREAKET !!!


else 
{
$harga_2 = $harga['harga_jual_2'];
$subtotal2 = $harga_2 * $jumlah;
$subtotal2_d2 =  $subtotal2 - $diskon;
$subtotal2_p2 = $subtotal2_d2 + $pajak;
$subtotaljadi2 = $subtotal2_p2;



// START PERHITUNGAN FEE HARGA 2 INSERT 

// PERHITUNGAN UNTUK FEE DOKTER 2
$ceking_dokter_harga2 = $db->query("SELECT * FROM fee_produk WHERE nama_petugas = '$dokterpenanggungjawab' AND kode_produk = '$kode'");
$cek_fee_dokter2 = mysqli_num_rows($ceking_dokter_harga2);
$data_fee_dokter_harga2 = mysqli_fetch_array($ceking_dokter_harga2);

if ($cek_fee_dokter2 > 0){
if ($data_fee_dokter_harga2['jumlah_prosentase'] != 0 AND $data_fee_dokter_harga2['jumlah_uang'] == 0 )

{  
$hasil_hitung_fee_persen_harga2 = $subtotaljadi2 * $data_fee_dokter_harga2['jumlah_prosentase'] / 100;

$insert_harga2_persen = "INSERT INTO tbs_fee_produk 
(no_reg,no_rm,no_faktur,nama_petugas,kode_produk,nama_produk,jumlah_fee,tanggal,jam,waktu) VALUES 
('$no_reg','$no_rm','$no_faktur','$dokterpenanggungjawab','$kode','$nama','$hasil_hitung_fee_persen_harga2','$tanggal_sekarang','$jam','$waktu')";
if ($db->query($insert_harga2_persen) === TRUE) 
{
  
} 
else 
      {
    echo "Error: " . $insert_harga2_persen . "<br>" . $db->error;
      }

}


else
{
$hasil_hitung_fee_nominal_harga2 = $data_fee_dokter_harga2['jumlah_uang'] * $jumlah;

$insert_harga2_nominal = "INSERT INTO tbs_fee_produk 
(no_reg,no_rm,no_faktur,nama_petugas,kode_produk,nama_produk,jumlah_fee,tanggal,jam,waktu) VALUES 
('$no_reg','$no_rm','$no_faktur','$dokterpenanggungjawab','$kode','$nama','$hasil_hitung_fee_nominal_harga2','$tanggal_sekarang','$jam','$waktu')";
if ($db->query($insert_harga2_nominal) === TRUE) {
  
}
else
    {
    echo "Error: " . $insert_harga2_nominal . "<br>" . $db->error;
    }

}

} // penutup fee dokter2 > 0
// ENDING PERHITUNGAN UNTUK FEE DOKTER 2


// PERHITUNGAN UNTUK FEE APOTEKER 2
$cek_apoteker_harga2 = $db->query("SELECT * FROM fee_produk WHERE nama_petugas = '$apoteker' AND kode_produk = '$kode'");
$cek_fee_apoteker2 = mysqli_num_rows($cek_apoteker_harga2);
$dataui_apoteker_harga2 = mysqli_fetch_array($cek_apoteker_harga2);

if ($cek_fee_apoteker2 > 0){
if ($dataui_apoteker_harga2['jumlah_prosentase'] != 0 AND $dataui_apoteker_harga2['jumlah_uang'] == 0 )

{  
$hasil_hitung_fee_persen_apoteker_harga2 = $subtotaljadi2 * $dataui_apoteker_harga2['jumlah_prosentase'] / 100;

$insert_apoteker_persen_harga2 = "INSERT INTO tbs_fee_produk 
(no_reg,no_rm,no_faktur,nama_petugas,kode_produk,nama_produk,jumlah_fee,tanggal,jam,waktu) VALUES 
('$no_reg','$no_rm','$no_faktur','$apoteker','$kode','$nama','$hasil_hitung_fee_persen_apoteker_harga2','$tanggal_sekarang','$jam','$waktu')";
if ($db->query($insert_apoteker_persen_harga2) === TRUE) {
  
} 
else 
      {
    echo "Error: " . $insert_apoteker_persen_harga2 . "<br>" . $db->error;
      }

}

else

{

$hasil_hitung_fee_nominal_apoteker_harga2 = $dataui_apoteker_harga2['jumlah_uang'] * $jumlah;

$insert2_apoteker_nominal_harga2 = "INSERT INTO tbs_fee_produk 
(no_reg,no_rm,no_faktur,nama_petugas,kode_produk,nama_produk,jumlah_fee,tanggal,jam,waktu) VALUES 
('$no_reg','$no_rm','$no_faktur','$apoteker','$kode','$nama','$hasil_hitung_fee_nominal_apoteker_harga2','$tanggal_sekarang','$jam','$waktu')";
if ($db->query($insert2_apoteker_nominal_harga2) === TRUE) {
  
}
else
      {
    echo "Error: " . $insert2_apoteker_nominal_harga2 . "<br>" . $db->error;
      }

}

} // penutup if apoteker2 > 0
// ENDING PERHITUNGAN UNTUK FEE APOTEKER 2


// PERHITUNGAN UNTUK FEE PERAWAT INSERTT 2
$cek_perawat_harga2 = $db->query("SELECT * FROM fee_produk WHERE nama_petugas = '$perawat' AND kode_produk = '$kode'");
$cek_fee_perawat2 = mysqli_num_rows($cek_perawat_harga2);
$dataui_perawat_harga2 = mysqli_fetch_array($cek_perawat_harga2);

if ($cek_fee_perawat2 > 0) {
if ($dataui_perawat_harga2['jumlah_prosentase'] != 0 AND $dataui_perawat_harga2['jumlah_uang'] == 0 )

{  
$hasil_hitung_fee_persen_perawat_harga2 = $subtotaljadi2 * $dataui_perawat_harga2['jumlah_prosentase'] / 100;

$insert_perawat_persen_harga2 = "INSERT INTO tbs_fee_produk 
(no_reg,no_rm,no_faktur,nama_petugas,kode_produk,nama_produk,jumlah_fee,tanggal,jam,waktu) VALUES 
('$no_reg','$no_rm','$no_faktur','$perawat','$kode','$nama','$hasil_hitung_fee_persen_perawat_harga2','$tanggal_sekarang','$jam','$waktu')";
if ($db->query($insert_perawat_persen_harga2) === TRUE) {
  
} 
else 
      {
    echo "Error: " . $insert_perawat_persen_harga2 . "<br>" . $db->error;
      }


}

else

{
$hasil_hitung_fee_nominal_perawat_harga2 = $dataui_perawat_harga2['jumlah_uang'] * $jumlah;

$insert2_perawat_nominal_harga2 = "INSERT INTO tbs_fee_produk 
(no_reg,no_rm,no_faktur,nama_petugas,kode_produk,nama_produk,jumlah_fee,tanggal,jam,waktu) VALUES 
('$no_reg','$no_rm','$no_faktur','$perawat','$kode','$nama','$hasil_hitung_fee_nominal_perawat_harga2','$tanggal_sekarang','$jam','$waktu')";
if ($db->query($insert2_perawat_nominal_harga2) === TRUE) {
} 
else
    {
    echo "Error: " . $insert2_perawat_nominal_harga2 . "<br>" . $db->error;
    }

}

} // penutup fee perawat2 > 0

// ENDING PERHITUNGAN UNTUK FEE PERAWAT 2




// PERHITUNGAN UNTUK FEE PERAWAT INSERTT 2
$cek_petugas_lain_harga2 = $db->query("SELECT * FROM fee_produk WHERE nama_petugas = '$petugas_lain' AND kode_produk = '$kode'");
$cek_fee_petugas_lain2 = mysqli_num_rows($cek_petugas_lain_harga2);
$dataui_pet_lain_harga2 = mysqli_fetch_array($cek_petugas_lain_harga2);

if ($cek_fee_petugas_lain2 > 0) {
if ($dataui_pet_lain_harga2['jumlah_prosentase'] != 0 AND $dataui_pet_lain_harga2['jumlah_uang'] == 0 )

{  
$hasil_hitung_fee_persen_petugas_lain_harga2 = $subtotaljadi2 * $dataui_pet_lain_harga2['jumlah_prosentase'] / 100;

$insert_petugas_lain_persen_harga2 = "INSERT INTO tbs_fee_produk 
(no_reg,no_rm,no_faktur,nama_petugas,kode_produk,nama_produk,jumlah_fee,tanggal,jam,waktu) VALUES 
('$no_reg','$no_rm','$no_faktur','$petugas_lain','$kode','$nama','$hasil_hitung_fee_persen_petugas_lain_harga2','$tanggal_sekarang','$jam','$waktu')";
if ($db->query($insert_petugas_lain_persen_harga2) === TRUE) {
  
} 
else 
      {
    echo "Error: " . $insert_petugas_lain_persen_harga2 . "<br>" . $db->error;
      }


}

else

{
$hasil_hitung_fee_nominal_petugas_lain_harga2 = $dataui_pet_lain_harga2['jumlah_uang'] * $jumlah;

$insert2_pet_lain_nominal_harga2 = "INSERT INTO tbs_fee_produk 
(no_reg,no_rm,no_faktur,nama_petugas,kode_produk,nama_produk,jumlah_fee,tanggal,jam,waktu) VALUES 
('$no_reg','$no_rm','$no_faktur','$petugas_lain','$kode','$nama','$hasil_hitung_fee_nominal_petugas_lain_harga2','$tanggal_sekarang','$jam',
  '$waktu')";
if ($db->query($insert2_pet_lain_nominal_harga2) === TRUE) {
} 
else
    {
    echo "Error: " . $insert2_pet_lain_nominal_harga2 . "<br>" . $db->error;
    }

}

} // penutup fee perawat2 > 0

// ENDING PERHITUNGAN UNTUK FEE PERAWAT INSERT 2


// start untuk petugas 2
$cek_petugas_harga2 = $db->query("SELECT * FROM fee_produk WHERE nama_petugas = '$petugas' AND kode_produk = '$kode'");
$cek_fee_petugas2 = mysqli_num_rows($cek_petugas_harga2);
$dataui_petugas_harga2 = mysqli_fetch_array($cek_petugas_harga2);

if ($cek_fee_petugas2 > 0){
if ($dataui_petugas_harga2['jumlah_prosentase'] != 0 AND $dataui_petugas_harga2['jumlah_uang'] == 0 )

{  
$hasil_hitung_fee_persen_petugas_harga2 = $subtotaljadi2 * $dataui_petugas_harga2['jumlah_prosentase'] / 100;

$insert_petugas_harga2 = "INSERT INTO tbs_fee_produk 
(no_reg,no_rm,no_faktur,nama_petugas,kode_produk,nama_produk,jumlah_fee,tanggal,jam,waktu) VALUES 
('$no_reg','$no_rm','$no_faktur','$petugas','$kode','$nama','$hasil_hitung_fee_persen_petugas_harga2','$tanggal_sekarang','$jam','$waktu')";
if ($db->query($insert_petugas_harga2) === TRUE) 
{
  
} 
else
     {
    echo "Error: " . $insert_petugas_harga2 . "<br>" . $db->error;
      }

}

else

{
$hitung_fee_nominal_petugas_harga2 = $dataui_petugas_harga2['jumlah_uang'] * $jumlah;

$insert2_petugas_harga2 = "INSERT INTO tbs_fee_produk 
(no_reg,no_rm,no_faktur,nama_petugas,kode_produk,nama_produk,jumlah_fee,tanggal,jam,waktu) VALUES 
('$no_reg','$no_rm','$no_faktur','$petugas','$kode','$nama','$hitung_fee_nominal_petugas_harga2','$tanggal_sekarang','$jam','$waktu')";
if ($db->query($insert2_petugas_harga2) === TRUE){
  
} 
else 
      {
    echo "Error: " . $insert2_petugas_harga2 . "<br>" . $db->error;
      }
  
}

} // penutup if untuk petugas2 > 0

// ENDING perhitungan untuk petugas 2

                         // AKHIR PERHITUNGAN FEE HARGA 2


// INSERT TBS UNTUK HARGA 2
$query10 = $db->query("INSERT INTO tbs_penjualan (no_faktur,no_reg,kode_produk,nama_produk,jumlah_produk,
  harga_produk,subtotal,tipe_produk,tanggal,jam,hpp,diskon,tax) VALUES ('$no_faktur','$no_reg','$kode',
  '$nama','$jumlah','$harga_2','$subtotaljadi2','$jenis','$tanggal_sekarang','$jam','$jumlah_hpp','$diskon','$pajak')");



if ($jenis == 'Jasa' ){


}

else if ($jenis == 'BHP'){

}

else{

  $query7 = $db->query("UPDATE produk SET stok_produk = stok_produk - '$jumlah' WHERE kode_produk = '$kode' ");


}

}

}
            // AKHIR TOTAL SEMUA DARI UPDATE, FEE DAN INSERT TBS 


                                  // START HARGA 3

elseif ($level_harga == 'harga_3' )

{

if ($cek > 0 )
{
  $harga_3 = $harga['harga_jual_3'];
  $subtotal3 = $harga_3 * $jumlah;
  $subtotal3_d3 =  $subtotal3 - $diskon;
  $subtotal3_p3 = $subtotal3_d3 + $pajak;
  $subtotaljadi3 = $subtotal3_p3;

$query12 = $db->query("INSERT INTO tbs_penjualan (no_faktur,no_reg,kode_produk,nama_produk,jumlah_produk,harga_produk,subtotal,tipe_produk,tanggal,jam,hpp,diskon,tax) VALUES ('$no_faktur','$no_reg
  ','$kode','$nama','$jumlah','$harga_3','$subtotaljadi3','$jenis','$tanggal_sekarang','$jam','$jumlah_hpp','$diskon','$pajak')");

if ($jenis == 'Jasa' ){

}

else if ($jenis == 'BHP')
{

}
else{

  $query_persen_dok2 = $db->query("UPDATE produk SET stok_produk = stok_produk - '$jumlah' WHERE kode_produk = '$kode'  ");

}

$cek_persen_dokter3 = $db->query("SELECT * FROM fee_produk WHERE nama_petugas = '$dokterpenanggungjawab' AND kode_produk = '$kode'");
$data_persen_dokter3 = mysqli_fetch_array($cek_persen_dokter3);

if ($data_persen_dokter3['jumlah_prosentase'] != 0 AND $data_persen_dokter3['jumlah_uang'] == 0 )
{
$hasil_hitung_fee_persen_harga3 = $subtotaljadi3 * $data_persen_dokter3['jumlah_prosentase'] / 100;
$query_persen_dokter_harga_ke3 = $db->query("UPDATE tbs_fee_produk SET nama_petugas= '$dokterpenanggungjawab' , jumlah_fee = jumlah_fee + '$hasil_hitung_fee_persen_harga3' WHERE  nama_petugas = '$dokterpenanggungjawab' AND  kode_produk = '$kode'");

}
// END hitung persentase dokter update harga 3

else

// Hitung Nominal dokter update harga 3
{

$hasil_hitung_fee_nominal_dokter_harga3 = $data_persen_dokter3['jumlah_uang'] * $jumlah;
$query_nominal_dokter_harga_ke3 = $db->query("UPDATE tbs_fee_produk SET  nama_petugas= '$dokterpenanggungjawab' , jumlah_fee = jumlah_fee + '$hasil_hitung_fee_nominal_dokter_harga3' WHERE  nama_petugas = '$dokterpenanggungjawab' AND  kode_produk = '$kode'");

}
// END Hitung Nominal dokter update harga 3



// MULAI PERSENTASE APOTEKER HARGA 3

$cek_persen_apoteker3 = $db->query("SELECT * FROM fee_produk WHERE nama_petugas = '$apoteker' AND kode_produk = '$kode'");
$data_persen_apoteker3 = mysqli_fetch_array($cek_persen_apoteker3);

if ($data_persen_apoteker3['jumlah_prosentase'] != 0 AND $data_persen_apoteker3['jumlah_uang'] == 0 )
{

$hasil_hitung_fee_persen_apoteker_harga3 = $subtotaljadi3 * $data_persen_apoteker3['jumlah_prosentase'] / 100;
$query_persen_apoteker_harga_ke3 = $db->query("UPDATE tbs_fee_produk SET nama_petugas= '$apoteker' , jumlah_fee = jumlah_fee + '$hasil_hitung_fee_persen_apoteker_harga3' WHERE  nama_petugas = '$apoteker' AND kode_produk = '$kode'");

}
// AKHIR PSERSENTASE APOTEKER HARGA 3

else

// HITUNGAN NOMINAL APOTEKER HARGA 3
{

$hasil_hitung_fee_nominal_apoteker_harga3 = $data_persen_apoteker3['jumlah_uang'] * $jumlah;
$query_nominal_apoteker_harga_ke3 = $db->query("UPDATE tbs_fee_produk SET nama_petugas= '$apoteker' , jumlah_fee = jumlah_fee + '$hasil_hitung_fee_nominal_apoteker_harga3' WHERE  nama_petugas = '$apoteker' AND kode_produk = '$kode'");

}
// ENDING NOMINAL APOTEKER HARGA 3

// mulai persentase perawat harga 3
$cek_persen_perawat_harga3 = $db->query("SELECT * FROM fee_produk WHERE nama_petugas = '$perawat' AND kode_produk = '$kode'");
$data_persen_perawat_harga3 = mysqli_fetch_array($cek_persen_perawat_harga3);

if ($data_persen_perawat_harga3['jumlah_prosentase'] != 0 AND $data_persen_perawat_harga3['jumlah_uang'] == 0 )
{

$hasil_hitung_fee_persen_perawat_harga3 = $subtotaljadi3 * $data_persen_perawat_harga3['jumlah_prosentase'] / 100;
$query_persen_perawat_harga_ke3 = $db->query("UPDATE tbs_fee_produk SET nama_petugas= '$perawat' , jumlah_fee = jumlah_fee + '$hasil_hitung_fee_persen_perawat_harga3' WHERE nama_petugas = '$perawat' AND  kode_produk = '$kode'");

}
// akhir persentase perawat harga 3

else

// nominal perawat harga 3
{

$hasil_hitung_fee_nominal_perawat_harga3 = $data_persen_perawat_harga3['jumlah_uang'] * $jumlah;
$query_nominal_perawat_harga_ke3 = $db->query("UPDATE tbs_fee_produk SET nama_petugas= '$perawat' , jumlah_fee = jumlah_fee + '$hasil_hitung_fee_nominal_perawat_harga3' WHERE nama_petugas = '$perawat' AND  kode_produk = '$kode'");

}
// akhir nominal perawat harga 3



// mulai persentase perawat harga 3
$cek_persen_petugas_lain_harga3 = $db->query("SELECT * FROM fee_produk WHERE nama_petugas = '$petugas_lain' AND kode_produk = '$kode'");
$data_persen_pet_lain_harga3 = mysqli_fetch_array($cek_persen_petugas_lain_harga3);

if ($data_persen_pet_lain_harga3['jumlah_prosentase'] != 0 AND $data_persen_pet_lain_harga3['jumlah_uang'] == 0 )
{

$hasil_hitung_fee_persen_petugas_lain_harga3 = $subtotaljadi3 * $data_persen_pet_lain_harga3['jumlah_prosentase'] / 100;
$query_persen_petugas_other_harga_ke3 = $db->query("UPDATE tbs_fee_produk SET nama_petugas= '$petugas_lain' , jumlah_fee = jumlah_fee + '$hasil_hitung_fee_persen_petugas_lain_harga3' WHERE nama_petugas = '$petugas_lain' AND kode_produk = '$kode'");

}
// akhir persentase perawat harga 3

else

// nominal perawat harga 3
{

$hasil_hitung_fee_nominal_pet_lain_harga3 = $data_persen_pet_lain_harga3['jumlah_uang'] * $jumlah;
$query_nominal_other_petugas_harga_ke3 = $db->query("UPDATE tbs_fee_produk SET nama_petugas= '$petugas_lain' , jumlah_fee = jumlah_fee + '$hasil_hitung_fee_nominal_pet_lain_harga3' WHERE nama_petugas = '$petugas_lain' AND kode_produk = '$kode'");

}
// akhir nominal perawat harga 3




// MULAI PERSENTASE UNTUK PETUGAS 3
$cek_persen_petugas_harga3 = $db->query("SELECT * FROM fee_produk WHERE nama_petugas = '$petugas' AND kode_produk = '$kode'");
$data_persen_petugas_harga3 = mysqli_fetch_array($cek_persen_petugas_harga3);

if ($data_persen_petugas_harga3['jumlah_prosentase'] != 0 AND $data_persen_petugas_harga3['jumlah_uang'] == 0 )
{

$hasil_hitung_fee_persen_petugas_harga3 = $subtotaljadi3 * $data_persen_petugas_harga3['jumlah_prosentase'] / 100;
$query_persen_petugas_harga3 = $db->query("UPDATE tbs_fee_produk SET nama_petugas= '$petugas' , jumlah_fee = jumlah_fee + '$hasil_hitung_fee_persen_petugas_harga3' WHERE nama_petugas = '$petugas' AND kode_produk = '$kode'");

}
// AKHIR PERSENTASE UNTUK PETUGAS 3

else

// START NOMINAL UNTUK PETUGAS 3
{

$hasil_hitung_fee_nominal_petugas_harga3 = $data_persen_petugas_harga3['jumlah_uang'] * $jumlah;
$query_nominal_petugas_harga3 = $db->query("UPDATE tbs_fee_produk SET nama_petugas= '$petugas' , jumlah_fee = jumlah_fee + '$hasil_hitung_fee_nominal_petugas_harga3' WHERE nama_petugas = '$petugas' AND kode_produk = '$kode'");

}
// ENDING UNTUK PETUGAS 3

// SELESAI UNTUK UPDATE DOKTER,PERAWAT, APOTEKER DAN PETUGAS (PERSENTASE DAN NOMINAL) UNTUK HARGA 3


} // WARNING DO NOT ANYTING ABOUT THIS BREAKET !!!

else 

{

$harga_3 = $harga['harga_jual_3'];
$subtotal3 = $harga_3 * $jumlah;
 $subtotal3_d3 =  $subtotal3 - $diskon;
$subtotal3_p3 = $subtotal3_d3 + $pajak;
$subtotaljadi3 = $subtotal3_p3;



                 // START PERHITUNGAN FEE HARGA 3 INSERT 

// PERHITUNGAN UNTUK FEE DOKTER 3
$ceking_dokter_harga3 = $db->query("SELECT * FROM fee_produk WHERE nama_petugas = '$dokterpenanggungjawab' AND kode_produk = '$kode'");
$cek_fee_dokter3 = mysqli_num_rows($ceking_dokter_harga3);
$data_fee_dokter_harga3 = mysqli_fetch_array($ceking_dokter_harga3);

if ($cek_fee_dokter3 > 0){
if ($data_fee_dokter_harga3['jumlah_prosentase'] != 0 AND $data_fee_dokter_harga3['jumlah_uang'] == 0 )

{  
$hasil_hitung_fee_persen_harga3 = $subtotaljadi3 * $data_fee_dokter_harga3['jumlah_prosentase'] / 100;

$insert_harga3_persen = "INSERT INTO tbs_fee_produk 
(no_reg,no_rm,no_faktur,nama_petugas,kode_produk,nama_produk,jumlah_fee,tanggal,jam,waktu) VALUES 
('$no_reg','$no_rm','$no_faktur','$dokterpenanggungjawab','$kode','$nama','$hasil_hitung_fee_persen_harga3','$tanggal_sekarang','$jam','$waktu')";
if ($db->query($insert_harga3_persen) === TRUE) {
  
} 

else 
      {
    echo "Error: " . $insert_harga3_persen . "<br>" . $db->error;
      }

}

else

{
$hasil_hitung_fee_nominal_harga3 = $data_fee_dokter_harga3['jumlah_uang'] * $jumlah;

$insert_harga3_nominal = "INSERT INTO tbs_fee_produk 
(no_reg,no_rm,no_faktur,nama_petugas,kode_produk,nama_produk,jumlah_fee,tanggal,jam,waktu) VALUES 
('$no_reg','$no_rm','$no_faktur','$dokterpenanggungjawab','$kode','$nama','$hasil_hitung_fee_nominal_harga3','$tanggal_sekarang','$jam','$waktu')";
if ($db->query($insert_harga3_nominal) === TRUE) {
  
}

else
    {
    echo "Error: " . $insert_harga3_nominal . "<br>" . $db->error;
    }

}

} // penutup if dokter3 > 0

// ENDING PERHITUNGAN UNTUK FEE DOKTER 3


// PERHITUNGAN UNTUK FEE APOTEKER 3
$cek_apoteker_harga3 = $db->query("SELECT * FROM fee_produk WHERE nama_petugas = '$apoteker' AND kode_produk = '$kode'");
$cek_fee_apoteker3 = mysqli_num_rows($cek_apoteker_harga3);
$dataui_apoteker_harga3 = mysqli_fetch_array($cek_apoteker_harga3);

if ($cek_fee_apoteker3 > 0){
if ($dataui_apoteker_harga3['jumlah_prosentase'] != 0 AND $dataui_apoteker_harga3['jumlah_uang'] == 0 )

{  
$hasil_hitung_fee_persen_apoteker_harga3 = $subtotaljadi3 * $dataui_apoteker_harga3['jumlah_prosentase'] / 100;

$insert_apoteker_persen_harga3 = "INSERT INTO tbs_fee_produk 
(no_reg,no_rm,no_faktur,nama_petugas,kode_produk,nama_produk,jumlah_fee,tanggal,jam,waktu) VALUES 
('$no_reg','$no_rm','$no_faktur','$apoteker','$kode','$nama','$hasil_hitung_fee_persen_apoteker_harga3','$tanggal_sekarang','$jam','$waktu')";
if ($db->query($insert_apoteker_persen_harga3) === TRUE) {
  
} 

else 
    {
    echo "Error: " . $insert_apoteker_persen_harga3 . "<br>" . $db->error;
    }

}

else

{

$hasil_hitung_fee_nominal_apoteker_harga3 = $dataui_apoteker_harga3['jumlah_uang'] * $jumlah;

$insert_apoteker_nominal_harga3 = "INSERT INTO tbs_fee_produk 
(no_reg,no_rm,no_faktur,nama_petugas,kode_produk,nama_produk,jumlah_fee,tanggal,jam,waktu) VALUES 
('$no_reg','$no_rm','$no_faktur','$apoteker','$kode','$nama','$hasil_hitung_fee_nominal_apoteker_harga3','$tanggal_sekarang','$jam','$waktu')";
if ($db->query($insert_apoteker_nominal_harga3) === TRUE) { 
} 

else
    {
    echo "Error: " . $insert_apoteker_nominal_harga3 . "<br>" . $db->error;
    }

}

} // penutup if apoteker 3 > 0

// ENDING PERHITUNGAN UNTUK FEE APOTEKER 3


// PERHITUNGAN UNTUK FEE PERAWAT 3
$cek_perawat_harga3 = $db->query("SELECT * FROM fee_produk WHERE nama_petugas = '$perawat' AND kode_produk = '$kode'");
$cek_fee_perawat3 = mysqli_num_rows($cek_perawat_harga3);
$dataui_perawat_harga3 = mysqli_fetch_array($cek_perawat_harga3);

if ($cek_fee_apoteker3 > 0){
if ($dataui_perawat_harga3['jumlah_prosentase'] != 0 AND $dataui_perawat_harga3['jumlah_uang'] == 0 )

{  
$hasil_hitung_fee_persen_perawat_harga3 = $subtotaljadi3 * $dataui_perawat_harga3['jumlah_prosentase'] / 100;

$insert_perawat_persen_harga3 = "INSERT INTO tbs_fee_produk 
(no_reg,no_rm,no_faktur,nama_petugas,kode_produk,nama_produk,jumlah_fee,tanggal,jam,waktu) VALUES 
('$no_reg','$no_rm','$no_faktur','$perawat','$kode','$nama','$hasil_hitung_fee_persen_perawat_harga3','$tanggal_sekarang','$jam','$waktu')";
  if ($db->query($insert_perawat_persen_harga3) === TRUE) {
  

} 
else 
      {
    echo "Error: " . $insert_perawat_persen_harga3 . "<br>" . $db->error;
      }

}

else

{
$hasil_hitung_fee_nominal_perawat_harga3 = $dataui_perawat_harga3['jumlah_uang'] * $jumlah;

$insert_perawat_nominal_harga3 = "INSERT INTO tbs_fee_produk 
(no_reg,no_rm,no_faktur,nama_petugas,kode_produk,nama_produk,jumlah_fee,tanggal,jam,waktu) VALUES 
('$no_reg','$no_rm','$no_faktur','$perawat','$kode','$nama','$hasil_hitung_fee_nominal_perawat_harga3','$tanggal_sekarang','$jam','$waktu')";
if ($db->query($insert_perawat_nominal_harga3) === TRUE) {
  
} 

else
    {
    echo "Error: " . $insert_perawat_nominal_harga3 . "<br>" . $db->error;
    }

}

} // penutup if perawat3 > 0

// ENDING PERHITUNGAN UNTUK FEE PERAWAT 3




// PERHITUNGAN UNTUK FEE PERAWAT 3
$cek_petugas_lain_harga3 = $db->query("SELECT * FROM fee_produk WHERE nama_petugas = '$petugas_lain' AND kode_produk = '$kode'");
$cek_fee_petugas_lain3 = mysqli_num_rows($cek_petugas_lain_harga3);
$dataui_petugas_lain_harga3 = mysqli_fetch_array($cek_petugas_lain_harga3);

if ($cek_fee_petugas_lain3 > 0){
if ($dataui_petugas_lain_harga3['jumlah_prosentase'] != 0 AND $dataui_petugas_lain_harga3['jumlah_uang'] == 0 )

{  
$hasil_hitung_fee_persen_petugas_lain_harga3 = $subtotaljadi3 * $dataui_petugas_lain_harga3['jumlah_prosentase'] / 100;

$insert_petugas_lain_persen_harga3 = "INSERT INTO tbs_fee_produk 
(no_reg,no_rm,no_faktur,nama_petugas,kode_produk,nama_produk,jumlah_fee,tanggal,jam,waktu) VALUES 
('$no_reg','$no_rm','$no_faktur','$petugas_lain','$kode','$nama','$hasil_hitung_fee_persen_petugas_lain_harga3','$tanggal_sekarang','$jam',
  '$waktu')";
  if ($db->query($insert_petugas_lain_persen_harga3) === TRUE) {
  

} 
else 
      {
    echo "Error: " . $insert_petugas_lain_persen_harga3 . "<br>" . $db->error;
      }

}

else

{
$hasil_hitung_fee_nominal_petugas_lain_harga3 = $dataui_petugas_lain_harga3['jumlah_uang'] * $jumlah;

$insert_petugas_lain_nominal_harga3 = "INSERT INTO tbs_fee_produk 
(no_reg,no_rm,no_faktur,nama_petugas,kode_produk,nama_produk,jumlah_fee,tanggal,jam,waktu) VALUES 
('$no_reg','$no_rm','$no_faktur','$petugas_lain','$kode','$nama','$hasil_hitung_fee_nominal_petugas_lain_harga3','$tanggal_sekarang','$jam',
  '$waktu')";
if ($db->query($insert_petugas_lain_nominal_harga3) === TRUE) {
  
} 

else
    {
    echo "Error: " . $insert_petugas_lain_nominal_harga3 . "<br>" . $db->error;
    }

}

} // penutup if perawat3 > 0

// ENDING PERHITUNGAN UNTUK FEE PERAWAT 3


// start untuk petugas 3
$cek_petugas_harga3 = $db->query("SELECT * FROM fee_produk WHERE nama_petugas = '$petugas' AND kode_produk = '$kode'");
$cek_fee_petugas3 = mysqli_num_rows($cek_petugas_harga3);
$dataui_petugas_harga3 = mysqli_fetch_array($cek_petugas_harga3);

if ($cek_fee_petugas3 > 0){
if ($dataui_petugas_harga3['jumlah_prosentase'] != 0 AND $dataui_petugas_harga3['jumlah_uang'] == 0 )

{  
$hasil_hitung_fee_persen_petugas_harga3 = $subtotaljadi3 * $dataui_petugas_harga3['jumlah_prosentase'] / 100;

$insert_petugas_harga3 = "INSERT INTO tbs_fee_produk 
(no_reg,no_rm,no_faktur,nama_petugas,kode_produk,nama_produk,jumlah_fee,tanggal,jam,waktu) VALUES 
('$no_reg','$no_rm','$no_faktur','$petugas','$kode','$nama','$hasil_hitung_fee_persen_petugas_harga3','$tanggal_sekarang','$jam','$waktu')";
if ($db->query($insert_petugas_harga3) === TRUE) 
{
  
} 
else 
      {
    echo "Error: " . $insert_petugas_harga3 . "<br>" . $db->error;
      }

}


else
{
$hitung_fee_nominal_petugas_harga3 = $dataui_petugas_harga3['jumlah_uang'] * $jumlah;

$insert2_petugas_harga3 = "INSERT INTO tbs_fee_produk 
(no_reg,no_rm,no_faktur,nama_petugas,kode_produk,nama_produk,jumlah_fee,tanggal,jam,waktu) VALUES 
('$no_reg','$no_rm','$no_faktur','$petugas','$kode','$nama','$hitung_fee_nominal_petugas_harga3','$tanggal_sekarang','$jam','$waktu')";
if ($db->query($insert2_petugas_harga3) === TRUE){
  
}
else 
      {
    echo "Error: " . $insert2_petugas_harga3 . "<br>" . $db->error;
      }

}
} // if penututp petugas3 > 0

// ENDING perhitungan untuk petugas 3
                         // AKHIR PERHITUNGAN FEE HARGA 3


$query14 = $db->query("INSERT INTO tbs_penjualan (no_faktur,no_reg,kode_produk,nama_produk,jumlah_produk,harga_produk,subtotal,tipe_produk,tanggal,jam,hpp,diskon,tax) VALUES ('$no_faktur','$no_reg
  ','$kode','$nama','$jumlah','$harga_3','$subtotaljadi3','$jenis','$tanggal_sekarang','$jam','$jumlah_hpp','$diskon','$pajak')");


if ($jenis == 'Jasa' ){


}

else if ($jenis == 'BHP'){

}

else{

  $query7 = $db->query("UPDATE produk SET stok_produk = stok_produk - '$jumlah' WHERE kode_produk = '$kode' ");


}


} 

}



 ?>
<div class="table-responsive">
<table id="tbs_penjualan" class="table table-bordered">
 
    <thead>
      <tr>
         <th>Kode  </th>
         <th>Nama  </th>
         <th>Jumlah  </th>
         <th>Harga </th>
         <th>Subtotal</th>
         <th>Diskon </th>
         <th>Pajak</th>
         <th>Waktu</th>
         <th>Petugas</th>
         <th>Tools</th>

    </tr>
    </thead>
    <tbody>
    
   <?php
  $query5 = $db->query("SELECT * FROM tbs_penjualan WHERE no_faktur = '$no_faktur' ORDER BY id DESC");
  while($data = mysqli_fetch_array($query5))
         
         {
         
           $rp = number_format($data['harga_produk'],0,',','.');
           $rp_sub = number_format($data['subtotal'],0,',','.');
           $rp_diskon = number_format($data['diskon'],0,',','.');
           $rp_tax = number_format($data['tax'],0,',','.');

         echo 
         "<tr class='tr-id-".$data['id']."'>
         <td>". $data['kode_produk']."</td>
         <td>". $data['nama_produk']."</td>

        <td style='background-color:#90caf9;' class='edit-jumlah' data-id='".$data['id']."' ><span id='id-jumlah-".$data['id']."'  >". $data['jumlah_produk']."</span><input type='text' autofocus='' value='".$data['jumlah_produk']."'  data-id='".$data['id']."' data-diskon='".$data['diskon']."' data-tax='".$data['tax']."' data-harga='".$data['harga_produk']."' data-tipe='".$data['tipe_produk']."' data-kode='".$data['kode_produk']."' class='input-jumlah' id='input-jumlah-id-".$data['id']."' style='display:none;' ></td>  
             
         <td>Rp. ". $rp."</td>
         <td>Rp. <span id='subtotal-id-".$data['id']."'>". $rp_sub."</span></td>
         <td>Rp. ". $rp_diskon."</td>
         <td>Rp. ". $rp_tax."</td>
         <td>". $data['tanggal']." ".$data['jam']."</td>";


 $kd = $db->query("SELECT nama_petugas FROM tbs_fee_produk WHERE kode_produk='$data[kode_produk]' AND no_faktur = '$data[no_faktur]' AND jam = '$data[jam]' ");
  $kdD = $db->query("SELECT nama_petugas FROM tbs_fee_produk WHERE kode_produk='$data[kode_produk]' AND no_faktur = '$data[no_faktur]' AND jam = '$data[jam]' ");
 $nu = mysqli_fetch_array($kd);

if ($nu['nama_petugas'] != '')
{

echo "<td>";
 while($nur = mysqli_fetch_array($kdD))
{
  echo $nur['nama_petugas']." ,";
}
 echo "</td>";

}
else
{
  echo "<td></td>";
}


     echo "<td><button type='button' accesskey='t' class='btn btn-danger pilih' data-tipe='".$data['tipe_produk']."' data-kode='".$data['kode_produk']."' data-faktur='". $data['no_faktur']."' data-id='". $data['id']. "' ><span class='glyphicon glyphicon-remove-sign'></span> Ba<u>t</u>al</button></td>
         
         </tr>";       
      }
    ?>
  </tbody>
 </table>
 </div>

<!--datatable-->
<script type="text/javascript">
  $(function () {
  $("#tbs_penjualan").dataTable({ordering : false});
  });  
</script>
<!--end datatable-->


 <script type="text/javascript">
$(".edit-jumlah").dblclick(function(){

var id = $(this).attr('data-id');

$("#id-jumlah-"+id).hide();
$("#input-jumlah-id-"+id).show();




});    

  </script>

<script type="text/javascript">
$(".input-jumlah").blur(function(){

var id = $(this).attr('data-id');
var kode = $(this).attr('data-kode');
var jumlah_baru = $(this).val();
var jumlah_lama = $('#id-jumlah'+id).text();
var diskon = $(this).attr('data-diskon');
var tax = $(this).attr('data-tax');
var harga = $(this).attr('data-harga');
var no_fak = "<?php echo $no_faktur;?>";
var tipe = $(this).attr('data-tipe');
var apoteker = "<?php echo $apoteker;?>";
var dokter = "<?php echo $dokterpenanggungjawab;?>";
var perawat = "<?php echo $perawat;?>";
var petugas = "<?php echo $petugas;?>";
var no_reg = "<?php echo $no_reg;?>";

var subtotal_lama = bersihPemisah(bersihPemisah(bersihPemisah(bersihPemisah($("#subtotal-id-"+id).text()))));
var subtotal = jumlah_baru * harga - diskon + parseInt(tax,10);
var subtotal_id = bersihPemisah(bersihPemisah(bersihPemisah(bersihPemisah($("#subtotal").val()))));
subtotal_id = subtotal_id - subtotal_lama;
subtotal_id = subtotal_id + subtotal;

   var diskon_f = bersihPemisah(bersihPemisah(bersihPemisah(bersihPemisah("<?php echo $diskon_f;?>"))));
                     if (diskon_f == '')
                      {
                        diskon_f = '0';
                      }
                      var tax_f = bersihPemisah(bersihPemisah(bersihPemisah(bersihPemisah("<?php echo $tax_f;?>"))));
                       if (tax_f == '')
                      {
                        tax_f = '0';
                      }
                      var biaya_admin = bersihPemisah(bersihPemisah(bersihPemisah(bersihPemisah("<?php echo $biaya_admin;?>"))));
                       if (biaya_admin == '')
                      {
                        biaya_admin = '0';
                      }

var total_asli = subtotal_id - diskon_f + parseInt(tax_f,10) +  parseInt(biaya_admin,10);


if (jumlah_baru == 0)
{
        alert("Jumlah Tidak Boleh 0");
        $(this).val($("#id-jumlah-"+id).text());
        $(this).focus();
}

else if (tipe == 'Jasa')
{


$("#id-jumlah-"+id).show();
$("#input-jumlah-id-"+id).hide();
$("#id-jumlah-"+id).text(jumlah_baru);
$("#subtotal-id-"+id).text(tandaPemisahTitik(subtotal));
$("#subtotal").val(tandaPemisahTitik(subtotal_id));
$("#total").val(tandaPemisahTitik(total_asli));

$.post("update_jumlah_kasir_penjualan.php",{id:id,no_fak:no_fak,harga:harga,apoteker:apoteker,
  dokter:dokter,perawat:perawat,petugas:petugas,kode:kode,diskon:diskon,no_reg:no_reg,jumlah_lama:jumlah_lama,jumlah_baru:jumlah_baru,tax:tax},function(data){


});

}


else if (tipe == 'Laboratorium')
{


$("#id-jumlah-"+id).show();
$("#input-jumlah-id-"+id).hide();
$("#id-jumlah-"+id).text(jumlah_baru);
$("#subtotal-id-"+id).text(tandaPemisahTitik(subtotal));
$("#subtotal").val(tandaPemisahTitik(subtotal_id));
$("#total").val(tandaPemisahTitik(total_asli));

$.post("update_jumlah_kasir_penjualan.php",{id:id,no_fak:no_fak,harga:harga,apoteker:apoteker,
  dokter:dokter,perawat:perawat,petugas:petugas,kode:kode,diskon:diskon,no_reg:no_reg,jumlah_lama:jumlah_lama,jumlah_baru:jumlah_baru,tax:tax},function(data){
});

}



else if (tipe == 'Laundry')
{


$("#id-jumlah-"+id).show();
$("#input-jumlah-id-"+id).hide();
$("#id-jumlah-"+id).text(jumlah_baru);
$("#subtotal-id-"+id).text(tandaPemisahTitik(subtotal));
$("#subtotal").val(tandaPemisahTitik(subtotal_id));
$("#total").val(tandaPemisahTitik(total_asli));

$.post("update_jumlah_kasir_penjualan.php",{id:id,no_fak:no_fak,harga:harga,apoteker:apoteker,
  dokter:dokter,perawat:perawat,petugas:petugas,kode:kode,diskon:diskon,no_reg:no_reg,jumlah_lama:jumlah_lama,jumlah_baru:jumlah_baru,tax:tax},function(data){
});

}


else if (tipe == 'BHP')
{


$("#id-jumlah-"+id).show();
$("#input-jumlah-id-"+id).hide();
$("#id-jumlah-"+id).text(jumlah_baru);
$("#subtotal-id-"+id).text(tandaPemisahTitik(subtotal));
$("#subtotal").val(tandaPemisahTitik(subtotal_id));
$("#total").val(tandaPemisahTitik(total_asli));

$.post("update_jumlah_kasir_penjualan.php",{id:id,no_fak:no_fak,harga:harga,apoteker:apoteker,
  dokter:dokter,perawat:perawat,petugas:petugas,kode:kode,diskon:diskon,no_reg:no_reg,jumlah_lama:jumlah_lama,jumlah_baru:jumlah_baru,tax:tax},function(data){
});

}

else if (tipe == 'Obat Obatan')
{

$.post("cek_jumlah_terbaru_stok.php",{kode:kode,jumlah_lama:jumlah_lama,no_faktur:no_fak,jumlah_baru:jumlah_baru},
  function(data){
    if (data == 'ya')
    {
       alert("Stok Produk Tidak Mencukupi");
       $(".input-jumlah").val(jumlah_lama);
       $(".input-jumlah").focus();
    }

else
  {

$("#id-jumlah-"+id).show();
$("#input-jumlah-id-"+id).hide();
$("#id-jumlah-"+id).text(jumlah_baru);
$("#subtotal-id-"+id).text(tandaPemisahTitik(subtotal));
$("#subtotal").val(tandaPemisahTitik(subtotal_id));
$("#total").val(tandaPemisahTitik(total_asli));

    $.post("update_jumlah_kasir_penjualan.php",{id:id,no_fak:no_fak,harga:harga,apoteker:apoteker,
  dokter:dokter,perawat:perawat,petugas:petugas,kode:kode,diskon:diskon,no_reg:no_reg,jumlah_lama:jumlah_lama,jumlah_baru:jumlah_baru,tax:tax},function(data){

    });

}


});
}  
});
</script>  