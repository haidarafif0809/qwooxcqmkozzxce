<?php session_start();
include 'db.php';
include_once 'sanitasi.php';

$petugas = $_SESSION['nama'];

$session_id = session_id();
 
 $kode = stringdoang($_POST['kode']);
 $nama = stringdoang($_POST['nama']);
 $jumlah = stringdoang($_POST['jumlah']);
 $stok = stringdoang($_POST['stok']);
 $jenis = stringdoang($_POST['tipe']);
 $no_reg = stringdoang($_POST['no_reg']);
 $dokterpenanggungjawab = stringdoang($_POST['dokter']);
 $apoteker = stringdoang($_POST['apoteker']);
 $perawat = stringdoang($_POST['perawat']);
 $no_rm = stringdoang($_POST['no_rm']);
 
$jam =  date("H:i:s");
$tanggal_sekarang = date("Y-m-d");
$waktu = date("Y-m-d H:i:s");
$bulan_php = date('m');
$tahun_php = date('Y');


$query0 = $db->query("SELECT * FROM tbs_penjualan WHERE kode_barang = '$kode' AND no_reg ='$no_reg' AND tipe_barang = 'Jasa' ");
$cek = mysqli_num_rows($query0);


$query = $db->query(" SELECT * FROM registrasi WHERE no_reg = '$no_reg'");
$data = mysqli_fetch_array($query);
echo$penjamin = $data['penjamin'];

  
$query2 = $db->query(" SELECT * FROM penjamin WHERE nama = '$penjamin'");
$data2 = mysqli_fetch_array($query2);
echo$level_harga = $data2['harga'];

$query3 = $db->query("SELECT * FROM barang WHERE kode_barang = '$kode'");
$harga = mysqli_fetch_array($query3);

                       // AWAL DARI PERHITUNGAN HARGA 1 UNTUK PERSONAL 

if ($level_harga == 'harga_1')

{

$harga_1 = $harga['harga_jual'];
$subtotal = $harga_1 * $jumlah;
$subtotaljadi = $subtotal;


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
(session_id,no_reg,no_rm,nama_petugas,kode_produk,nama_produk,jumlah_fee,tanggal,jam) VALUES 
('$session_id','$no_reg','$no_rm','$dokterpenanggungjawab','$kode','$nama','$hasil_hitung_fee_persen',
  '$tanggal_sekarang','$jam')";
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
(session_id,no_reg,no_rm,nama_petugas,kode_produk,nama_produk,jumlah_fee,tanggal,jam) VALUES 
('$session_id','$no_reg','$no_rm','$dokterpenanggungjawab','$kode','$nama','$hasil_hitung_fee_nominal',
  '$tanggal_sekarang','$jam')";
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
(session_id,no_reg,no_rm,nama_petugas,kode_produk,nama_produk,jumlah_fee,tanggal,jam) VALUES 
('$session_id','$no_reg','$no_rm','$apoteker','$kode','$nama','$hasil_hitung_fee_persen_apoteker','$tanggal_sekarang','$jam')";
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
(session_id,no_reg,no_rm,nama_petugas,kode_produk,nama_produk,jumlah_fee,tanggal,jam) VALUES 
('$session_id','$no_reg','$no_rm','$apoteker','$kode','$nama','$hasil_hitung_fee_nominal_apoteker','$tanggal_sekarang','$jam')";
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
(session_id,no_reg,no_rm,nama_petugas,kode_produk,nama_produk,jumlah_fee,tanggal,jam) VALUES 
('$session_id','$no_reg','$no_rm','$perawat','$kode','$nama','$hasil_hitung_fee_persen_perawat','$tanggal_sekarang','$jam')";
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
(session_id,no_reg,no_rm,nama_petugas,kode_produk,nama_produk,jumlah_fee,tanggal,jam) VALUES 
('$session_id','$no_reg','$no_rm','$perawat','$kode','$nama','$hasil_hitung_fee_nominal_perawat','$tanggal_sekarang','$jam')";
if ($db->query($insert2_perawat) === TRUE) {
  
  } 
else
    {
    echo "Error: " . $insert2_perawat . "<br>" . $db->error;
    }

  }
} // breaket penutup if di perawat di harga1 > 0
// ENDING PERHITUNGAN UNTUK FEE PERAWAT


// PERHITUNGAN UNTUK FEE PETUGAS
$cek_petugas = $db->query("SELECT * FROM fee_produk WHERE nama_petugas = '$petugas' AND kode_produk = '$kode'");
$cek_fee_petugas1 = mysqli_num_rows($cek_petugas);
$dataui_petugas = mysqli_fetch_array($cek_petugas);

if ($cek_fee_petugas1 > 0) {
if ($dataui_petugas['jumlah_prosentase'] != 0 AND $dataui_petugas['jumlah_uang'] == 0 )

{  
$hasil_hitung_fee_persen_petugas = $subtotaljadi * $dataui_petugas['jumlah_prosentase'] / 100;

$insert1_petugas = "INSERT INTO tbs_fee_produk 
(session_id,no_reg,no_rm,nama_petugas,kode_produk,nama_produk,jumlah_fee,tanggal,jam) VALUES 
('$session_id','$no_reg','$no_rm','$petugas','$kode','$nama','$hasil_hitung_fee_persen_petugas','$tanggal_sekarang','$jam')";
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
(session_id,no_reg,no_rm,nama_petugas,kode_produk,nama_produk,jumlah_fee,tanggal,jam) VALUES 
('$session_id','$no_reg','$no_rm','$petugas','$kode','$nama','$hasil_hitung_fee_nominal_petugas','$tanggal_sekarang','$jam')";
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

$query6 = " INSERT INTO tbs_penjualan (session_id, no_reg,kode_barang,nama_barang,jumlah_barang,harga,subtotal,tipe_barang,tanggal,jam,satuan) VALUES ('$session_id','$no_reg','$kode','$nama','$jumlah','$harga_1','$subtotaljadi','$jenis','$tanggal_sekarang','$jam', '$harga[satuan]')";
if ($db->query($query6) === TRUE) {
  
} 
else 
      {
    echo "Error: " . $query6 . "<br>" . $db->error;
      }


}
//  AKHIR INSERT TBS_PENJUALAN DAN PERHITUNGAN AKHIR DARI FEE PRODUK HARGA 1 DAN SUDAH UPDATENYA JUGA !!!



                    // AWAL PEMBUKAAAN HARGA KE 2 UNTUK PERUSAHAAN


elseif ($level_harga == 'harga_2')

{

$harga_2 = $harga['harga_jual2'];
$subtotal2 = $harga_2 * $jumlah;
$subtotaljadi2 = $subtotal2;



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
(session_id,no_reg,no_rm,nama_petugas,kode_produk,nama_produk,jumlah_fee,tanggal,jam) VALUES 
('$session_id','$no_reg','$no_rm','$dokterpenanggungjawab','$kode','$nama','$hasil_hitung_fee_persen_harga2',
  '$tanggal_sekarang','$jam')";
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
(session_id,no_reg,no_rm,nama_petugas,kode_produk,nama_produk,jumlah_fee,tanggal,jam) VALUES 
('$session_id','$no_reg','$no_rm','$dokterpenanggungjawab','$kode','$nama','$hasil_hitung_fee_nominal_harga2',
  '$tanggal_sekarang','$jam')";
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
(session_id,no_reg,no_rm,nama_petugas,kode_produk,nama_produk,jumlah_fee,tanggal,jam) VALUES 
('$session_id','$no_reg','$no_rm','$apoteker','$kode','$nama','$hasil_hitung_fee_persen_apoteker_harga2',
  '$tanggal_sekarang','$jam')";
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
(session_id,no_reg,no_rm,nama_petugas,kode_produk,nama_produk,jumlah_fee,tanggal,jam) VALUES 
('$session_id','$no_reg','$no_rm','$apoteker','$kode','$nama','$hasil_hitung_fee_nominal_apoteker_harga2',
  '$tanggal_sekarang','$jam')";
if ($db->query($insert2_apoteker_nominal_harga2) === TRUE) {
  
}
else
      {
    echo "Error: " . $insert2_apoteker_nominal_harga2 . "<br>" . $db->error;
      }

}

} // penutup if apoteker2 > 0
// ENDING PERHITUNGAN UNTUK FEE APOTEKER 2


// PERHITUNGAN UNTUK FEE PERAWAT 2
$cek_perawat_harga2 = $db->query("SELECT * FROM fee_produk WHERE nama_petugas = '$perawat' AND kode_produk = '$kode'");
$cek_fee_perawat2 = mysqli_num_rows($cek_perawat_harga2);
$dataui_perawat_harga2 = mysqli_fetch_array($cek_perawat_harga2);

if ($cek_fee_perawat2 > 0) {
if ($dataui_perawat_harga2['jumlah_prosentase'] != 0 AND $dataui_perawat_harga2['jumlah_uang'] == 0 )

{  
$hasil_hitung_fee_persen_perawat_harga2 = $subtotaljadi2 * $dataui_perawat_harga2['jumlah_prosentase'] / 100;

$insert_perawat_persen_harga2 = "INSERT INTO tbs_fee_produk 
(session_id,no_reg,no_rm,nama_petugas,kode_produk,nama_produk,jumlah_fee,tanggal,jam) VALUES 
('$session_id','$no_reg','$no_rm','$perawat','$kode','$nama','$hasil_hitung_fee_persen_perawat_harga2',
  '$tanggal_sekarang','$jam')";
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
(session_id,no_reg,no_rm,nama_petugas,kode_produk,nama_produk,jumlah_fee,tanggal,jam) VALUES 
('$session_id','$no_reg','$no_rm','$perawat','$kode','$nama','$hasil_hitung_fee_nominal_perawat_harga2',
  '$tanggal_sekarang','$jam')";
if ($db->query($insert2_perawat_nominal_harga2) === TRUE) {
} 
else
    {
    echo "Error: " . $insert2_perawat_nominal_harga2 . "<br>" . $db->error;
    }

}

} // penutup fee perawat2 > 0

// ENDING PERHITUNGAN UNTUK FEE PERAWAT 2

// start untuk petugas 2
$cek_petugas_harga2 = $db->query("SELECT * FROM fee_produk WHERE nama_petugas = '$petugas' AND kode_produk = '$kode'");
$cek_fee_petugas2 = mysqli_num_rows($cek_petugas_harga2);
$dataui_petugas_harga2 = mysqli_fetch_array($cek_petugas_harga2);

if ($cek_fee_petugas2 > 0){
if ($dataui_petugas_harga2['jumlah_prosentase'] != 0 AND $dataui_petugas_harga2['jumlah_uang'] == 0 )

{  
$hasil_hitung_fee_persen_petugas_harga2 = $subtotaljadi2 * $dataui_petugas_harga2['jumlah_prosentase'] / 100;

$insert_petugas_harga2 = "INSERT INTO tbs_fee_produk 
(session_id,no_reg,no_rm,nama_petugas,kode_produk,nama_produk,jumlah_fee,tanggal,jam) VALUES 
('$session_id','$no_reg','$no_rm','$petugas','$kode','$nama','$hasil_hitung_fee_persen_petugas_harga2',
  '$tanggal_sekarang','$jam')";
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
(session_id,no_reg,no_rm,nama_petugas,kode_produk,nama_produk,jumlah_fee,tanggal,jam) VALUES 
('$session_id','$no_reg','$no_rm','$petugas','$kode','$nama','$hitung_fee_nominal_petugas_harga2',
  '$tanggal_sekarang','$jam')";
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
$query10 = "INSERT INTO tbs_penjualan (session_id, no_reg,kode_barang,nama_barang,jumlah_barang,harga,subtotal,tipe_barang,tanggal,jam,satuan) VALUES ('$session_id','$no_reg','$kode','$nama','$jumlah','$harga_2','$subtotaljadi2','$jenis','$tanggal_sekarang','$jam', '$harga[satuan]')";

if ($db->query($query10) === TRUE){
  
} 
else 
      {
    echo "Error: " . $query10 . "<br>" . $db->error;
      }
  

}
            // AKHIR TOTAL SEMUA DARI UPDATE, FEE DAN INSERT TBS 


                                  // START HARGA 3

elseif ($level_harga == 'harga_3' )

{


$harga_3 = $harga['harga_jual3'];
$subtotal3 = $harga_3 * $jumlah;
$subtotaljadi3 = $subtotal3;



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
(session_id,no_reg,no_rm,nama_petugas,kode_produk,nama_produk,jumlah_fee,tanggal,jam) VALUES 
('$session_id','$no_reg','$no_rm','$dokterpenanggungjawab','$kode','$nama','$hasil_hitung_fee_persen_harga3',
  '$tanggal_sekarang','$jam')";
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
(session_id,no_reg,no_rm,nama_petugas,kode_produk,nama_produk,jumlah_fee,tanggal,jam) VALUES 
('$session_id','$no_reg','$no_rm','$dokterpenanggungjawab','$kode','$nama','$hasil_hitung_fee_nominal_harga3',
  '$tanggal_sekarang','$jam')";
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
(session_id,no_reg,no_rm,nama_petugas,kode_produk,nama_produk,jumlah_fee,tanggal,jam) VALUES 
('$session_id','$no_reg','$no_rm','$apoteker','$kode','$nama','$hasil_hitung_fee_persen_apoteker_harga3',
  '$tanggal_sekarang','$jam')";
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
(session_id,no_reg,no_rm,nama_petugas,kode_produk,nama_produk,jumlah_fee,tanggal,jam) VALUES 
('$session_id','$no_reg','$no_rm','$apoteker','$kode','$nama','$hasil_hitung_fee_nominal_apoteker_harga3',
  '$tanggal_sekarang','$jam')";
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
(session_id,no_reg,no_rm,nama_petugas,kode_produk,nama_produk,jumlah_fee,tanggal,jam) VALUES 
('$session_id','$no_reg','$no_rm','$perawat','$kode','$nama','$hasil_hitung_fee_persen_perawat_harga3',
  '$tanggal_sekarang','$jam')";
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
(session_id,no_reg,no_rm,nama_petugas,kode_produk,nama_produk,jumlah_fee,tanggal,jam) VALUES 
('$session_id','$no_reg','$no_rm','$perawat','$kode','$nama','$hasil_hitung_fee_nominal_perawat_harga3',
  '$tanggal_sekarang','$jam')";
if ($db->query($insert_perawat_nominal_harga3) === TRUE) {
  
} 

else
    {
    echo "Error: " . $insert_perawat_nominal_harga3 . "<br>" . $db->error;
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
(session_id,no_reg,no_rm,nama_petugas,kode_produk,nama_produk,jumlah_fee,tanggal,jam) VALUES 
('$session_id','$no_reg','$no_rm','$petugas','$kode','$nama','$hasil_hitung_fee_persen_petugas_harga3',
  '$tanggal_sekarang','$jam')";
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
(session_id,no_reg,no_rm,nama_petugas,kode_produk,nama_produk,jumlah_fee,tanggal,jam) VALUES 
('$session_id','$no_reg','$no_rm','$petugas','$kode','$nama','$hitung_fee_nominal_petugas_harga3','$tanggal_sekarang','$jam')";
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
$query14 = "INSERT INTO tbs_penjualan (session_id, no_reg,kode_barang,nama_barang,jumlah_barang,harga,subtotal,tipe_barang,tanggal,jam,satuan) VALUES ('$session_id','$no_reg','$kode','$nama','$jumlah','$harga_3','$subtotaljadi3','$jenis','$tanggal_sekarang','$jam', '$harga[satuan]')";
 if ($db->query($query14) === TRUE) {
} 
else 
      {
    echo "Error: " . $query14 . "<br>" . $db->error;
      }


}


elseif ($level_harga == 'harga_4')

{


$harga_4 = $harga['harga_jual4'];
$subtotal4 = $harga_4 * $jumlah;
$subtotaljadi4 = $subtotal4;



// START PERHITUNGAN FEE HARGA 4 INSERT 

// PERHITUNGAN UNTUK FEE DOKTER 4
$ceking_dokter_harga4 = $db->query("SELECT * FROM fee_produk WHERE nama_petugas = '$dokterpenanggungjawab' AND kode_produk = '$kode'");
$cek_fee_dokter4 = mysqli_num_rows($ceking_dokter_harga4);
$data_fee_dokter_harga4 = mysqli_fetch_array($ceking_dokter_harga4);

if ($cek_fee_dokter4 > 0){
if ($data_fee_dokter_harga4['jumlah_prosentase'] != 0 AND $data_fee_dokter_harga4['jumlah_uang'] == 0 )

{  
$hasil_hitung_fee_persen_harga4 = $subtotaljadi4 * $data_fee_dokter_harga4['jumlah_prosentase'] / 100;

$insert_harga4_persen = "INSERT INTO tbs_fee_produk 
(session_id,no_reg,no_rm,nama_petugas,kode_produk,nama_produk,jumlah_fee,tanggal,jam) VALUES 
('$session_id','$no_reg','$no_rm','$dokterpenanggungjawab','$kode','$nama','$hasil_hitung_fee_persen_harga4',
  '$tanggal_sekarang','$jam')";
if ($db->query($insert_harga4_persen) === TRUE) 
{
  
} 
else 
      {
    echo "Error: " . $insert_harga4_persen . "<br>" . $db->error;
      }

}


else
{
$hasil_hitung_fee_nominal_harga4 = $data_fee_dokter_harga4['jumlah_uang'] * $jumlah;

$insert_harga4_nominal = "INSERT INTO tbs_fee_produk 
(session_id,no_reg,no_rm,nama_petugas,kode_produk,nama_produk,jumlah_fee,tanggal,jam) VALUES 
('$session_id','$no_reg','$no_rm','$dokterpenanggungjawab','$kode','$nama','$hasil_hitung_fee_nominal_harga4',
  '$tanggal_sekarang','$jam')";
if ($db->query($insert_harga4_nominal) === TRUE) {
  
}
else
    {
    echo "Error: " . $insert_harga4_nominal . "<br>" . $db->error;
    }

}

} // penutup fee dokter4 > 0
// ENDING PERHITUNGAN UNTUK FEE DOKTER 4


// PERHITUNGAN UNTUK FEE APOTEKER 4
$cek_apoteker_harga4 = $db->query("SELECT * FROM fee_produk WHERE nama_petugas = '$apoteker' AND kode_produk = '$kode'");
$cek_fee_apoteker4 = mysqli_num_rows($cek_apoteker_harga4);
$dataui_apoteker_harga4 = mysqli_fetch_array($cek_apoteker_harga4);

if ($cek_fee_apoteker4 > 0){
if ($dataui_apoteker_harga4['jumlah_prosentase'] != 0 AND $dataui_apoteker_harga4['jumlah_uang'] == 0 )

{  
$hasil_hitung_fee_persen_apoteker_harga4 = $subtotaljadi4 * $dataui_apoteker_harga4['jumlah_prosentase'] / 100;

$insert_apoteker_persen_harga4 = "INSERT INTO tbs_fee_produk 
(session_id,no_reg,no_rm,nama_petugas,kode_produk,nama_produk,jumlah_fee,tanggal,jam) VALUES 
('$session_id','$no_reg','$no_rm','$apoteker','$kode','$nama','$hasil_hitung_fee_persen_apoteker_harga4',
  '$tanggal_sekarang','$jam')";
if ($db->query($insert_apoteker_persen_harga4) === TRUE) {
  
} 
else 
      {
    echo "Error: " . $insert_apoteker_persen_harga4 . "<br>" . $db->error;
      }

}

else

{

$hasil_hitung_fee_nominal_apoteker_harga4 = $dataui_apoteker_harga4['jumlah_uang'] * $jumlah;

$insert4_apoteker_nominal_harga4 = "INSERT INTO tbs_fee_produk 
(session_id,no_reg,no_rm,nama_petugas,kode_produk,nama_produk,jumlah_fee,tanggal,jam) VALUES 
('$session_id','$no_reg','$no_rm','$apoteker','$kode','$nama','$hasil_hitung_fee_nominal_apoteker_harga4',
  '$tanggal_sekarang','$jam')";
if ($db->query($insert4_apoteker_nominal_harga4) === TRUE) {
  
}
else
      {
    echo "Error: " . $insert4_apoteker_nominal_harga4 . "<br>" . $db->error;
      }

}

} // penutup if apoteker4 > 0
// ENDING PERHITUNGAN UNTUK FEE APOTEKER 4


// PERHITUNGAN UNTUK FEE PERAWAT 4
$cek_perawat_harga4 = $db->query("SELECT * FROM fee_produk WHERE nama_petugas = '$perawat' AND kode_produk = '$kode'");
$cek_fee_perawat4 = mysqli_num_rows($cek_perawat_harga4);
$dataui_perawat_harga4 = mysqli_fetch_array($cek_perawat_harga4);

if ($cek_fee_perawat4 > 0) {
if ($dataui_perawat_harga4['jumlah_prosentase'] != 0 AND $dataui_perawat_harga4['jumlah_uang'] == 0 )

{  
$hasil_hitung_fee_persen_perawat_harga4 = $subtotaljadi4 * $dataui_perawat_harga4['jumlah_prosentase'] / 100;

$insert_perawat_persen_harga4 = "INSERT INTO tbs_fee_produk 
(session_id,no_reg,no_rm,nama_petugas,kode_produk,nama_produk,jumlah_fee,tanggal,jam) VALUES 
('$session_id','$no_reg','$no_rm','$perawat','$kode','$nama','$hasil_hitung_fee_persen_perawat_harga4',
  '$tanggal_sekarang','$jam')";
if ($db->query($insert_perawat_persen_harga4) === TRUE) {
  
} 
else 
      {
    echo "Error: " . $insert_perawat_persen_harga4 . "<br>" . $db->error;
      }


}

else

{
$hasil_hitung_fee_nominal_perawat_harga4 = $dataui_perawat_harga4['jumlah_uang'] * $jumlah;

$insert4_perawat_nominal_harga4 = "INSERT INTO tbs_fee_produk 
(session_id,no_reg,no_rm,nama_petugas,kode_produk,nama_produk,jumlah_fee,tanggal,jam) VALUES 
('$session_id','$no_reg','$no_rm','$perawat','$kode','$nama','$hasil_hitung_fee_nominal_perawat_harga4',
  '$tanggal_sekarang','$jam')";
if ($db->query($insert4_perawat_nominal_harga4) === TRUE) {
} 
else
    {
    echo "Error: " . $insert4_perawat_nominal_harga4 . "<br>" . $db->error;
    }

}

} // penutup fee perawat4 > 0

// ENDING PERHITUNGAN UNTUK FEE PERAWAT 4

// start untuk petugas 4
$cek_petugas_harga4 = $db->query("SELECT * FROM fee_produk WHERE nama_petugas = '$petugas' AND kode_produk = '$kode'");
$cek_fee_petugas4 = mysqli_num_rows($cek_petugas_harga4);
$dataui_petugas_harga4 = mysqli_fetch_array($cek_petugas_harga4);

if ($cek_fee_petugas4 > 0){
if ($dataui_petugas_harga4['jumlah_prosentase'] != 0 AND $dataui_petugas_harga4['jumlah_uang'] == 0 )

{  
$hasil_hitung_fee_persen_petugas_harga4 = $subtotaljadi4 * $dataui_petugas_harga4['jumlah_prosentase'] / 100;

$insert_petugas_harga4 = "INSERT INTO tbs_fee_produk 
(session_id,no_reg,no_rm,nama_petugas,kode_produk,nama_produk,jumlah_fee,tanggal,jam) VALUES 
('$session_id','$no_reg','$no_rm','$petugas','$kode','$nama','$hasil_hitung_fee_persen_petugas_harga4',
  '$tanggal_sekarang','$jam')";
if ($db->query($insert_petugas_harga4) === TRUE) 
{
  
} 
else
     {
    echo "Error: " . $insert_petugas_harga4 . "<br>" . $db->error;
      }

}

else

{
$hitung_fee_nominal_petugas_harga4 = $dataui_petugas_harga4['jumlah_uang'] * $jumlah;

$insert4_petugas_harga4 = "INSERT INTO tbs_fee_produk 
(session_id,no_reg,no_rm,nama_petugas,kode_produk,nama_produk,jumlah_fee,tanggal,jam) VALUES 
('$session_id','$no_reg','$no_rm','$petugas','$kode','$nama','$hitung_fee_nominal_petugas_harga4',
  '$tanggal_sekarang','$jam')";
if ($db->query($insert4_petugas_harga4) === TRUE){
  
} 
else 
      {
    echo "Error: " . $insert4_petugas_harga4 . "<br>" . $db->error;
      }
  
}

} // penutup if untuk petugas4 > 0

// ENDING perhitungan untuk petugas 4

                         // AKHIR PERHITUNGAN FEE HARGA 4


// INSERT TBS UNTUK HARGA 4
$query10 = "INSERT INTO tbs_penjualan (session_id, no_reg,kode_barang,nama_barang,jumlah_barang,harga,subtotal,tipe_barang,tanggal,jam, satuan) VALUES ('$session_id','$no_reg','$kode','$nama','$jumlah','$harga_4','$subtotaljadi4','$jenis','$tanggal_sekarang','$jam', '$harga[satuan]')";

if ($db->query($query10) === TRUE){
  
} 
else 
      {
    echo "Error: " . $query10 . "<br>" . $db->error;
      }


}
            // AKHIR TOTAL SEMUA DARI UPDATE, FEE DAN INSERT TBS 


elseif ($level_harga == 'harga_5')

{

 
$harga_5 = $harga['harga_jual5'];
$subtotal5 = $harga_5 * $jumlah;
$subtotaljadi5 = $subtotal5;



// START PERHITUNGAN FEE HARGA 5 INSERT 

// PERHITUNGAN UNTUK FEE DOKTER 5
$ceking_dokter_harga5 = $db->query("SELECT * FROM fee_produk WHERE nama_petugas = '$dokterpenanggungjawab' AND kode_produk = '$kode'");
$cek_fee_dokter5 = mysqli_num_rows($ceking_dokter_harga5);
$data_fee_dokter_harga5 = mysqli_fetch_array($ceking_dokter_harga5);

if ($cek_fee_dokter5 > 0){
if ($data_fee_dokter_harga5['jumlah_prosentase'] != 0 AND $data_fee_dokter_harga5['jumlah_uang'] == 0 )

{  
$hasil_hitung_fee_persen_harga5 = $subtotaljadi5 * $data_fee_dokter_harga5['jumlah_prosentase'] / 100;

$insert_harga5_persen = "INSERT INTO tbs_fee_produk 
(session_id,no_reg,no_rm,nama_petugas,kode_produk,nama_produk,jumlah_fee,tanggal,jam) VALUES 
('$session_id','$no_reg','$no_rm','$dokterpenanggungjawab','$kode','$nama','$hasil_hitung_fee_persen_harga5',
  '$tanggal_sekarang','$jam')";
if ($db->query($insert_harga5_persen) === TRUE) 
{
  
} 
else 
      {
    echo "Error: " . $insert_harga5_persen . "<br>" . $db->error;
      }

}


else
{
$hasil_hitung_fee_nominal_harga5 = $data_fee_dokter_harga5['jumlah_uang'] * $jumlah;

$insert_harga5_nominal = "INSERT INTO tbs_fee_produk 
(session_id,no_reg,no_rm,nama_petugas,kode_produk,nama_produk,jumlah_fee,tanggal,jam) VALUES 
('$session_id','$no_reg','$no_rm','$dokterpenanggungjawab','$kode','$nama','$hasil_hitung_fee_nominal_harga5',
  '$tanggal_sekarang','$jam')";
if ($db->query($insert_harga5_nominal) === TRUE) {
  
}
else
    {
    echo "Error: " . $insert_harga5_nominal . "<br>" . $db->error;
    }

}

} // penutup fee dokter5 > 0
// ENDING PERHITUNGAN UNTUK FEE DOKTER 5


// PERHITUNGAN UNTUK FEE APOTEKER 5
$cek_apoteker_harga5 = $db->query("SELECT * FROM fee_produk WHERE nama_petugas = '$apoteker' AND kode_produk = '$kode'");
$cek_fee_apoteker5 = mysqli_num_rows($cek_apoteker_harga5);
$dataui_apoteker_harga5 = mysqli_fetch_array($cek_apoteker_harga5);

if ($cek_fee_apoteker5 > 0){
if ($dataui_apoteker_harga5['jumlah_prosentase'] != 0 AND $dataui_apoteker_harga5['jumlah_uang'] == 0 )

{  
$hasil_hitung_fee_persen_apoteker_harga5 = $subtotaljadi5 * $dataui_apoteker_harga5['jumlah_prosentase'] / 100;

$insert_apoteker_persen_harga5 = "INSERT INTO tbs_fee_produk 
(session_id,no_reg,no_rm,nama_petugas,kode_produk,nama_produk,jumlah_fee,tanggal,jam) VALUES 
('$session_id','$no_reg','$no_rm','$apoteker','$kode','$nama','$hasil_hitung_fee_persen_apoteker_harga5',
  '$tanggal_sekarang','$jam')";
if ($db->query($insert_apoteker_persen_harga5) === TRUE) {
  
} 
else 
      {
    echo "Error: " . $insert_apoteker_persen_harga5 . "<br>" . $db->error;
      }

}

else

{

$hasil_hitung_fee_nominal_apoteker_harga5 = $dataui_apoteker_harga5['jumlah_uang'] * $jumlah;

$insert5_apoteker_nominal_harga5 = "INSERT INTO tbs_fee_produk 
(session_id,no_reg,no_rm,nama_petugas,kode_produk,nama_produk,jumlah_fee,tanggal,jam) VALUES 
('$session_id','$no_reg','$no_rm','$apoteker','$kode','$nama','$hasil_hitung_fee_nominal_apoteker_harga5',
  '$tanggal_sekarang','$jam')";
if ($db->query($insert5_apoteker_nominal_harga5) === TRUE) {
  
}
else
      {
    echo "Error: " . $insert5_apoteker_nominal_harga5 . "<br>" . $db->error;
      }

}

} // penutup if apoteker5 > 0
// ENDING PERHITUNGAN UNTUK FEE APOTEKER 5


// PERHITUNGAN UNTUK FEE PERAWAT 5
$cek_perawat_harga5 = $db->query("SELECT * FROM fee_produk WHERE nama_petugas = '$perawat' AND kode_produk = '$kode'");
$cek_fee_perawat5 = mysqli_num_rows($cek_perawat_harga5);
$dataui_perawat_harga5 = mysqli_fetch_array($cek_perawat_harga5);

if ($cek_fee_perawat5 > 0) {
if ($dataui_perawat_harga5['jumlah_prosentase'] != 0 AND $dataui_perawat_harga5['jumlah_uang'] == 0 )

{  
$hasil_hitung_fee_persen_perawat_harga5 = $subtotaljadi5 * $dataui_perawat_harga5['jumlah_prosentase'] / 100;

$insert_perawat_persen_harga5 = "INSERT INTO tbs_fee_produk 
(session_id,no_reg,no_rm,nama_petugas,kode_produk,nama_produk,jumlah_fee,tanggal,jam) VALUES 
('$session_id','$no_reg','$no_rm','$perawat','$kode','$nama','$hasil_hitung_fee_persen_perawat_harga5',
  '$tanggal_sekarang','$jam')";
if ($db->query($insert_perawat_persen_harga5) === TRUE) {
  
} 
else 
      {
    echo "Error: " . $insert_perawat_persen_harga5 . "<br>" . $db->error;
      }


}

else

{
$hasil_hitung_fee_nominal_perawat_harga5 = $dataui_perawat_harga5['jumlah_uang'] * $jumlah;

$insert5_perawat_nominal_harga5 = "INSERT INTO tbs_fee_produk 
(session_id,no_reg,no_rm,nama_petugas,kode_produk,nama_produk,jumlah_fee,tanggal,jam) VALUES 
('$session_id','$no_reg','$no_rm','$perawat','$kode','$nama','$hasil_hitung_fee_nominal_perawat_harga5',
  '$tanggal_sekarang','$jam')";
if ($db->query($insert5_perawat_nominal_harga5) === TRUE) {
} 
else
    {
    echo "Error: " . $insert5_perawat_nominal_harga5 . "<br>" . $db->error;
    }

}

} // penutup fee perawat5 > 0

// ENDING PERHITUNGAN UNTUK FEE PERAWAT 5

// start untuk petugas 5
$cek_petugas_harga5 = $db->query("SELECT * FROM fee_produk WHERE nama_petugas = '$petugas' AND kode_produk = '$kode'");
$cek_fee_petugas5 = mysqli_num_rows($cek_petugas_harga5);
$dataui_petugas_harga5 = mysqli_fetch_array($cek_petugas_harga5);

if ($cek_fee_petugas5 > 0){
if ($dataui_petugas_harga5['jumlah_prosentase'] != 0 AND $dataui_petugas_harga5['jumlah_uang'] == 0 )

{  
$hasil_hitung_fee_persen_petugas_harga5 = $subtotaljadi5 * $dataui_petugas_harga5['jumlah_prosentase'] / 100;

$insert_petugas_harga5 = "INSERT INTO tbs_fee_produk 
(session_id,no_reg,no_rm,nama_petugas,kode_produk,nama_produk,jumlah_fee,tanggal,jam) VALUES 
('$session_id','$no_reg','$no_rm','$petugas','$kode','$nama','$hasil_hitung_fee_persen_petugas_harga5',
  '$tanggal_sekarang','$jam')";
if ($db->query($insert_petugas_harga5) === TRUE) 
{
  
} 
else
     {
    echo "Error: " . $insert_petugas_harga5 . "<br>" . $db->error;
      }

}

else

{
$hitung_fee_nominal_petugas_harga5 = $dataui_petugas_harga5['jumlah_uang'] * $jumlah;

$insert5_petugas_harga5 = "INSERT INTO tbs_fee_produk 
(session_id,no_reg,no_rm,nama_petugas,kode_produk,nama_produk,jumlah_fee,tanggal,jam) VALUES 
('$session_id','$no_reg','$no_rm','$petugas','$kode','$nama','$hitung_fee_nominal_petugas_harga5',
  '$tanggal_sekarang','$jam')";
if ($db->query($insert5_petugas_harga5) === TRUE){
  
} 
else 
      {
    echo "Error: " . $insert5_petugas_harga5 . "<br>" . $db->error;
      }
  
}

} // penutup if untuk petugas5 > 0

// ENDING perhitungan untuk petugas 5

                         // AKHIR PERHITUNGAN FEE HARGA 5


// INSERT TBS UNTUK HARGA 5
$query10 = "INSERT INTO tbs_penjualan (session_id, no_reg,kode_barang,nama_barang,jumlah_barang,harga,subtotal,tipe_barang,tanggal,jam,satuan) VALUES ('$session_id','$no_reg','$kode','$nama','$jumlah','$harga_5','$subtotaljadi5','$jenis','$tanggal_sekarang','$jam', '$harga[satuan]')";

if ($db->query($query10) === TRUE){
  
} 
else 
      {
    echo "Error: " . $query10 . "<br>" . $db->error;
      }
  

}
            // AKHIR TOTAL SEMUA DARI UPDATE, FEE DAN INSERT TBS 


elseif ($level_harga == 'harga_6')

{

$harga_6 = $harga['harga_jual6'];
$subtotal6 = $harga_6 * $jumlah;
$subtotaljadi6 = $subtotal6;



// START PERHITUNGAN FEE HARGA 6 INSERT 

// PERHITUNGAN UNTUK FEE DOKTER 6
$ceking_dokter_harga6 = $db->query("SELECT * FROM fee_produk WHERE nama_petugas = '$dokterpenanggungjawab' AND kode_produk = '$kode'");
$cek_fee_dokter6 = mysqli_num_rows($ceking_dokter_harga6);
$data_fee_dokter_harga6 = mysqli_fetch_array($ceking_dokter_harga6);

if ($cek_fee_dokter6 > 0){
if ($data_fee_dokter_harga6['jumlah_prosentase'] != 0 AND $data_fee_dokter_harga6['jumlah_uang'] == 0 )

{  
$hasil_hitung_fee_persen_harga6 = $subtotaljadi6 * $data_fee_dokter_harga6['jumlah_prosentase'] / 100;

$insert_harga6_persen = "INSERT INTO tbs_fee_produk 
(session_id,no_reg,no_rm,nama_petugas,kode_produk,nama_produk,jumlah_fee,tanggal,jam) VALUES 
('$session_id','$no_reg','$no_rm','$dokterpenanggungjawab','$kode','$nama','$hasil_hitung_fee_persen_harga6',
  '$tanggal_sekarang','$jam')";
if ($db->query($insert_harga6_persen) === TRUE) 
{
  
} 
else 
      {
    echo "Error: " . $insert_harga6_persen . "<br>" . $db->error;
      }

}


else
{
$hasil_hitung_fee_nominal_harga6 = $data_fee_dokter_harga6['jumlah_uang'] * $jumlah;

$insert_harga6_nominal = "INSERT INTO tbs_fee_produk 
(session_id,no_reg,no_rm,nama_petugas,kode_produk,nama_produk,jumlah_fee,tanggal,jam) VALUES 
('$session_id','$no_reg','$no_rm','$dokterpenanggungjawab','$kode','$nama','$hasil_hitung_fee_nominal_harga6',
  '$tanggal_sekarang','$jam')";
if ($db->query($insert_harga6_nominal) === TRUE) {
  
}
else
    {
    echo "Error: " . $insert_harga6_nominal . "<br>" . $db->error;
    }

}

} // penutup fee dokter6 > 0
// ENDING PERHITUNGAN UNTUK FEE DOKTER 6


// PERHITUNGAN UNTUK FEE APOTEKER 6
$cek_apoteker_harga6 = $db->query("SELECT * FROM fee_produk WHERE nama_petugas = '$apoteker' AND kode_produk = '$kode'");
$cek_fee_apoteker6 = mysqli_num_rows($cek_apoteker_harga6);
$dataui_apoteker_harga6 = mysqli_fetch_array($cek_apoteker_harga6);

if ($cek_fee_apoteker6 > 0){
if ($dataui_apoteker_harga6['jumlah_prosentase'] != 0 AND $dataui_apoteker_harga6['jumlah_uang'] == 0 )

{  
$hasil_hitung_fee_persen_apoteker_harga6 = $subtotaljadi6 * $dataui_apoteker_harga6['jumlah_prosentase'] / 100;

$insert_apoteker_persen_harga6 = "INSERT INTO tbs_fee_produk 
(session_id,no_reg,no_rm,nama_petugas,kode_produk,nama_produk,jumlah_fee,tanggal,jam) VALUES 
('$session_id','$no_reg','$no_rm','$apoteker','$kode','$nama','$hasil_hitung_fee_persen_apoteker_harga6',
  '$tanggal_sekarang','$jam')";
if ($db->query($insert_apoteker_persen_harga6) === TRUE) {
  
} 
else 
      {
    echo "Error: " . $insert_apoteker_persen_harga6 . "<br>" . $db->error;
      }

}

else

{

$hasil_hitung_fee_nominal_apoteker_harga6 = $dataui_apoteker_harga6['jumlah_uang'] * $jumlah;

$insert6_apoteker_nominal_harga6 = "INSERT INTO tbs_fee_produk 
(session_id,no_reg,no_rm,nama_petugas,kode_produk,nama_produk,jumlah_fee,tanggal,jam) VALUES 
('$session_id','$no_reg','$no_rm','$apoteker','$kode','$nama','$hasil_hitung_fee_nominal_apoteker_harga6',
  '$tanggal_sekarang','$jam')";
if ($db->query($insert6_apoteker_nominal_harga6) === TRUE) {
  
}
else
      {
    echo "Error: " . $insert6_apoteker_nominal_harga6 . "<br>" . $db->error;
      }

}

} // penutup if apoteker6 > 0
// ENDING PERHITUNGAN UNTUK FEE APOTEKER 6


// PERHITUNGAN UNTUK FEE PERAWAT 6
$cek_perawat_harga6 = $db->query("SELECT * FROM fee_produk WHERE nama_petugas = '$perawat' AND kode_produk = '$kode'");
$cek_fee_perawat6 = mysqli_num_rows($cek_perawat_harga6);
$dataui_perawat_harga6 = mysqli_fetch_array($cek_perawat_harga6);

if ($cek_fee_perawat6 > 0) {
if ($dataui_perawat_harga6['jumlah_prosentase'] != 0 AND $dataui_perawat_harga6['jumlah_uang'] == 0 )

{  
$hasil_hitung_fee_persen_perawat_harga6 = $subtotaljadi6 * $dataui_perawat_harga6['jumlah_prosentase'] / 100;

$insert_perawat_persen_harga6 = "INSERT INTO tbs_fee_produk 
(session_id,no_reg,no_rm,nama_petugas,kode_produk,nama_produk,jumlah_fee,tanggal,jam) VALUES 
('$session_id','$no_reg','$no_rm','$perawat','$kode','$nama','$hasil_hitung_fee_persen_perawat_harga6',
  '$tanggal_sekarang','$jam')";
if ($db->query($insert_perawat_persen_harga6) === TRUE) {
  
} 
else 
      {
    echo "Error: " . $insert_perawat_persen_harga6 . "<br>" . $db->error;
      }


}

else

{
$hasil_hitung_fee_nominal_perawat_harga6 = $dataui_perawat_harga6['jumlah_uang'] * $jumlah;

$insert6_perawat_nominal_harga6 = "INSERT INTO tbs_fee_produk 
(session_id,no_reg,no_rm,nama_petugas,kode_produk,nama_produk,jumlah_fee,tanggal,jam) VALUES 
('$session_id','$no_reg','$no_rm','$perawat','$kode','$nama','$hasil_hitung_fee_nominal_perawat_harga6',
  '$tanggal_sekarang','$jam')";
if ($db->query($insert6_perawat_nominal_harga6) === TRUE) {
} 
else
    {
    echo "Error: " . $insert6_perawat_nominal_harga6 . "<br>" . $db->error;
    }

}

} // penutup fee perawat6 > 0

// ENDING PERHITUNGAN UNTUK FEE PERAWAT 6

// start untuk petugas 6
$cek_petugas_harga6 = $db->query("SELECT * FROM fee_produk WHERE nama_petugas = '$petugas' AND kode_produk = '$kode'");
$cek_fee_petugas6 = mysqli_num_rows($cek_petugas_harga6);
$dataui_petugas_harga6 = mysqli_fetch_array($cek_petugas_harga6);

if ($cek_fee_petugas6 > 0){
if ($dataui_petugas_harga6['jumlah_prosentase'] != 0 AND $dataui_petugas_harga6['jumlah_uang'] == 0 )

{  
$hasil_hitung_fee_persen_petugas_harga6 = $subtotaljadi6 * $dataui_petugas_harga6['jumlah_prosentase'] / 100;

$insert_petugas_harga6 = "INSERT INTO tbs_fee_produk 
(session_id,no_reg,no_rm,nama_petugas,kode_produk,nama_produk,jumlah_fee,tanggal,jam) VALUES 
('$session_id','$no_reg','$no_rm','$petugas','$kode','$nama','$hasil_hitung_fee_persen_petugas_harga6',
  '$tanggal_sekarang','$jam')";
if ($db->query($insert_petugas_harga6) === TRUE) 
{
  
} 
else
     {
    echo "Error: " . $insert_petugas_harga6 . "<br>" . $db->error;
      }

}

else

{
$hitung_fee_nominal_petugas_harga6 = $dataui_petugas_harga6['jumlah_uang'] * $jumlah;

$insert6_petugas_harga6 = "INSERT INTO tbs_fee_produk 
(session_id,no_reg,no_rm,nama_petugas,kode_produk,nama_produk,jumlah_fee,tanggal,jam) VALUES 
('$session_id','$no_reg','$no_rm','$petugas','$kode','$nama','$hitung_fee_nominal_petugas_harga6',
  '$tanggal_sekarang','$jam')";
if ($db->query($insert6_petugas_harga6) === TRUE){
  
} 
else 
      {
    echo "Error: " . $insert6_petugas_harga6 . "<br>" . $db->error;
      }
  
}

} // penutup if untuk petugas6 > 0

// ENDING perhitungan untuk petugas 6

                         // AKHIR PERHITUNGAN FEE HARGA 6


// INSERT TBS UNTUK HARGA 6
$query10 = "INSERT INTO tbs_penjualan (session_id, no_reg,kode_barang,nama_barang,jumlah_barang,harga,subtotal,tipe_barang,tanggal,jam,satuan) VALUES ('$session_id','$no_reg','$kode','$nama','$jumlah','$harga_6','$subtotaljadi6','$jenis','$tanggal_sekarang','$jam', '$harga[satuan]')";

if ($db->query($query10) === TRUE){
  
} 
else 
      {
    echo "Error: " . $query10 . "<br>" . $db->error;
      }
  

}
            // AKHIR TOTAL SEMUA DARI UPDATE, FEE DAN INSERT TBS 


elseif ($level_harga == 'harga_7')

{

  
$harga_7 = $harga['harga_jual7'];
$subtotal7 = $harga_7 * $jumlah;
$subtotaljadi7 = $subtotal7;



// START PERHITUNGAN FEE HARGA 7 INSERT 

// PERHITUNGAN UNTUK FEE DOKTER 7
$ceking_dokter_harga7 = $db->query("SELECT * FROM fee_produk WHERE nama_petugas = '$dokterpenanggungjawab' AND kode_produk = '$kode'");
$cek_fee_dokter7 = mysqli_num_rows($ceking_dokter_harga7);
$data_fee_dokter_harga7 = mysqli_fetch_array($ceking_dokter_harga7);

if ($cek_fee_dokter7 > 0){
if ($data_fee_dokter_harga7['jumlah_prosentase'] != 0 AND $data_fee_dokter_harga7['jumlah_uang'] == 0 )

{  
$hasil_hitung_fee_persen_harga7 = $subtotaljadi7 * $data_fee_dokter_harga7['jumlah_prosentase'] / 100;

$insert_harga7_persen = "INSERT INTO tbs_fee_produk 
(session_id,no_reg,no_rm,nama_petugas,kode_produk,nama_produk,jumlah_fee,tanggal,jam) VALUES 
('$session_id','$no_reg','$no_rm','$dokterpenanggungjawab','$kode','$nama','$hasil_hitung_fee_persen_harga7',
  '$tanggal_sekarang','$jam')";
if ($db->query($insert_harga7_persen) === TRUE) 
{
  
} 
else 
      {
    echo "Error: " . $insert_harga7_persen . "<br>" . $db->error;
      }

}


else
{
$hasil_hitung_fee_nominal_harga7 = $data_fee_dokter_harga7['jumlah_uang'] * $jumlah;

$insert_harga7_nominal = "INSERT INTO tbs_fee_produk 
(session_id,no_reg,no_rm,nama_petugas,kode_produk,nama_produk,jumlah_fee,tanggal,jam) VALUES 
('$session_id','$no_reg','$no_rm','$dokterpenanggungjawab','$kode','$nama','$hasil_hitung_fee_nominal_harga7',
  '$tanggal_sekarang','$jam')";
if ($db->query($insert_harga7_nominal) === TRUE) {
  
}
else
    {
    echo "Error: " . $insert_harga7_nominal . "<br>" . $db->error;
    }

}

} // penutup fee dokter7 > 0
// ENDING PERHITUNGAN UNTUK FEE DOKTER 7


// PERHITUNGAN UNTUK FEE APOTEKER 7
$cek_apoteker_harga7 = $db->query("SELECT * FROM fee_produk WHERE nama_petugas = '$apoteker' AND kode_produk = '$kode'");
$cek_fee_apoteker7 = mysqli_num_rows($cek_apoteker_harga7);
$dataui_apoteker_harga7 = mysqli_fetch_array($cek_apoteker_harga7);

if ($cek_fee_apoteker7 > 0){
if ($dataui_apoteker_harga7['jumlah_prosentase'] != 0 AND $dataui_apoteker_harga7['jumlah_uang'] == 0 )

{  
$hasil_hitung_fee_persen_apoteker_harga7 = $subtotaljadi7 * $dataui_apoteker_harga7['jumlah_prosentase'] / 100;

$insert_apoteker_persen_harga7 = "INSERT INTO tbs_fee_produk 
(session_id,no_reg,no_rm,nama_petugas,kode_produk,nama_produk,jumlah_fee,tanggal,jam) VALUES 
('$session_id','$no_reg','$no_rm','$apoteker','$kode','$nama','$hasil_hitung_fee_persen_apoteker_harga7',
  '$tanggal_sekarang','$jam')";
if ($db->query($insert_apoteker_persen_harga7) === TRUE) {
  
} 
else 
      {
    echo "Error: " . $insert_apoteker_persen_harga7 . "<br>" . $db->error;
      }

}

else

{

$hasil_hitung_fee_nominal_apoteker_harga7 = $dataui_apoteker_harga7['jumlah_uang'] * $jumlah;

$insert7_apoteker_nominal_harga7 = "INSERT INTO tbs_fee_produk 
(session_id,no_reg,no_rm,nama_petugas,kode_produk,nama_produk,jumlah_fee,tanggal,jam) VALUES 
('$session_id','$no_reg','$no_rm','$apoteker','$kode','$nama','$hasil_hitung_fee_nominal_apoteker_harga7',
  '$tanggal_sekarang','$jam')";
if ($db->query($insert7_apoteker_nominal_harga7) === TRUE) {
  
}
else
      {
    echo "Error: " . $insert7_apoteker_nominal_harga7 . "<br>" . $db->error;
      }

}

} // penutup if apoteker7 > 0
// ENDING PERHITUNGAN UNTUK FEE APOTEKER 7


// PERHITUNGAN UNTUK FEE PERAWAT 7
$cek_perawat_harga7 = $db->query("SELECT * FROM fee_produk WHERE nama_petugas = '$perawat' AND kode_produk = '$kode'");
$cek_fee_perawat7 = mysqli_num_rows($cek_perawat_harga7);
$dataui_perawat_harga7 = mysqli_fetch_array($cek_perawat_harga7);

if ($cek_fee_perawat7 > 0) {
if ($dataui_perawat_harga7['jumlah_prosentase'] != 0 AND $dataui_perawat_harga7['jumlah_uang'] == 0 )

{  
$hasil_hitung_fee_persen_perawat_harga7 = $subtotaljadi7 * $dataui_perawat_harga7['jumlah_prosentase'] / 100;

$insert_perawat_persen_harga7 = "INSERT INTO tbs_fee_produk 
(session_id,no_reg,no_rm,nama_petugas,kode_produk,nama_produk,jumlah_fee,tanggal,jam) VALUES 
('$session_id','$no_reg','$no_rm','$perawat','$kode','$nama','$hasil_hitung_fee_persen_perawat_harga7',
  '$tanggal_sekarang','$jam')";
if ($db->query($insert_perawat_persen_harga7) === TRUE) {
  
} 
else 
      {
    echo "Error: " . $insert_perawat_persen_harga7 . "<br>" . $db->error;
      }


}

else

{
$hasil_hitung_fee_nominal_perawat_harga7 = $dataui_perawat_harga7['jumlah_uang'] * $jumlah;

$insert7_perawat_nominal_harga7 = "INSERT INTO tbs_fee_produk 
(session_id,no_reg,no_rm,nama_petugas,kode_produk,nama_produk,jumlah_fee,tanggal,jam) VALUES 
('$session_id','$no_reg','$no_rm','$perawat','$kode','$nama','$hasil_hitung_fee_nominal_perawat_harga7',
  '$tanggal_sekarang','$jam')";
if ($db->query($insert7_perawat_nominal_harga7) === TRUE) {
} 
else
    {
    echo "Error: " . $insert7_perawat_nominal_harga7 . "<br>" . $db->error;
    }

}

} // penutup fee perawat7 > 0

// ENDING PERHITUNGAN UNTUK FEE PERAWAT 7

// start untuk petugas 7
$cek_petugas_harga7 = $db->query("SELECT * FROM fee_produk WHERE nama_petugas = '$petugas' AND kode_produk = '$kode'");
$cek_fee_petugas7 = mysqli_num_rows($cek_petugas_harga7);
$dataui_petugas_harga7 = mysqli_fetch_array($cek_petugas_harga7);

if ($cek_fee_petugas7 > 0){
if ($dataui_petugas_harga7['jumlah_prosentase'] != 0 AND $dataui_petugas_harga7['jumlah_uang'] == 0 )

{  
$hasil_hitung_fee_persen_petugas_harga7 = $subtotaljadi7 * $dataui_petugas_harga7['jumlah_prosentase'] / 100;

$insert_petugas_harga7 = "INSERT INTO tbs_fee_produk 
(session_id,no_reg,no_rm,nama_petugas,kode_produk,nama_produk,jumlah_fee,tanggal,jam) VALUES 
('$session_id','$no_reg','$no_rm','$petugas','$kode','$nama','$hasil_hitung_fee_persen_petugas_harga7',
  '$tanggal_sekarang','$jam')";
if ($db->query($insert_petugas_harga7) === TRUE) 
{
  
} 
else
     {
    echo "Error: " . $insert_petugas_harga7 . "<br>" . $db->error;
      }

}

else

{
$hitung_fee_nominal_petugas_harga7 = $dataui_petugas_harga7['jumlah_uang'] * $jumlah;

$insert7_petugas_harga7 = "INSERT INTO tbs_fee_produk 
(session_id,no_reg,no_rm,nama_petugas,kode_produk,nama_produk,jumlah_fee,tanggal,jam) VALUES 
('$session_id','$no_reg','$no_rm','$petugas','$kode','$nama','$hitung_fee_nominal_petugas_harga7',
  '$tanggal_sekarang','$jam')";
if ($db->query($insert7_petugas_harga7) === TRUE){
  
} 
else 
      {
    echo "Error: " . $insert7_petugas_harga7 . "<br>" . $db->error;
      }
  
}

} // penutup if untuk petugas7 > 0

// ENDING perhitungan untuk petugas 7

                         // AKHIR PERHITUNGAN FEE HARGA 7


// INSERT TBS UNTUK HARGA 7
$query10 = "INSERT INTO tbs_penjualan (session_id, no_reg,kode_barang,nama_barang,jumlah_barang,harga,subtotal,tipe_barang,tanggal,jam, satuan) VALUES ('$session_id','$no_reg','$kode','$nama','$jumlah','$harga_7','$subtotaljadi7','$jenis','$tanggal_sekarang','$jam', '$harga[satuan]')";

if ($db->query($query10) === TRUE){
  
} 
else 
      {
    echo "Error: " . $query10 . "<br>" . $db->error;
      }
  
}
            // AKHIR TOTAL SEMUA DARI UPDATE, FEE DAN INSERT TBS 

 ?>

    
 
  
   <?php 
$query5 = $db->query("SELECT * FROM tbs_penjualan WHERE no_reg = '$no_reg' AND tipe_barang = 'Jasa' ORDER BY id DESC");
 

$ss = $db->query("SELECT * FROM detail_penjualan WHERE no_reg ='$no_reg' AND tipe_produk = 'Jasa' ORDER BY id DESC");
$asa = mysqli_num_rows($ss);
if ($asa == 0)
{

   $data = mysqli_fetch_array($query5);

     echo 
      "<tr class='tr-id-".$data['id']." tr-kode-".$data['kode_barang']."' data-kode-barang='".$data['kode_barang']."' >
      <td>". $data['no_reg']."</td>
      <td>". $data['kode_barang']."</td>
      <td>". $data['nama_barang']."</td>
      <td>". $data['jumlah_barang']."</td>
     <td>". $data['tanggal']." ".$data['jam']."</td>
      <td><button class='btn btn-danger btn-sm batal' data-id='".$data['id']."' data-reg='". $data['no_reg']."' data-kode-barang='". $data['kode_barang']."'>
      <i class='fa fa-remove'></i> Batal </button></td>
      </tr>";
       


}
else
{


   $data = mysqli_fetch_array($query5);
      echo 
      "<tr>
      <td>". $data['no_reg']."</td>
      <td>". $data['kode_barang']."</td>
      <td>". $data['nama_barang']."</td>
      <td>". $data['jumlah_barang']."</td>


      </tr>";
      
 }
      

    ?>

<style>

tr:nth-child(even){background-color: #f2f2f2}

</style>

