<?php 
include 'db.php';
include_once 'sanitasi.php';

session_start();
 
 $session_id = session_id();
 $kode = stringdoang($_POST['kode_barang']);
 $nama = stringdoang($_POST['nama_barang']);
 $jumlah = stringdoang($_POST['jumlah_barang']);
 $no_reg = stringdoang($_POST['no_reg']);
 $diskon = stringdoang($_POST['potongan']);
 $pajak = stringdoang($_POST['tax']); 
 $apoteker = stringdoang($_POST['petugas_farmasi']);
 $perawat = stringdoang($_POST['petugas_paramedik']);
 $petugas_lain = stringdoang($_POST['petugas_lain']);
 $no_rm = stringdoang($_POST['no_rm']);
 $petugas = stringdoang($_POST['petugas_kasir']);
 $penjamin = stringdoang($_POST['penjamin']);
 $asal_poli = stringdoang($_POST['asal_poli']);
 $satuan = stringdoang($_POST['satuan']);
 $harga = stringdoang($_POST['harga']);
 $dokter = stringdoang($_POST['dokter']);
 $tipe_produk = stringdoang($_POST['ber_stok']);


$tanggal_sekarang = date('Y-m-d');
$jam = date('H:i:sa');


$tbs_penjualan = $db->query("SELECT * FROM tbs_penjualan WHERE kode_barang = '$kode' AND session_id='$session_id'");
$cek = mysqli_num_rows($tbs_penjualan);

$query3 = $db->query("SELECT * FROM barang WHERE kode_barang = '$kode'");
$harga = mysqli_fetch_array($query3);
	

                       // AWAL DARI PERHITUNGAN HARGA 1 UNTUK PERSONAL 

if ($cek > 0 )
  //hitung persentase dokter update harga 1
{

$harga = stringdoang($_POST['harga']);
$subtotal = $harga * $jumlah;
$subtotal_d =  $subtotal - $diskon;
$subtotal_p = $subtotal_d + $pajak;
$subtotaljadi = $subtotal_p;

$query_persen_dok1 = $db->query("UPDATE tbs_penjualan SET jumlah_barang = jumlah_barang + '$jumlah', subtotal = subtotal + '$subtotaljadi',  diskon = diskon + '$diskon' , tax = tax + '$pajak' WHERE kode_barang = '$kode' AND session_id='$session_id'");



$cek_persen_dokter1 = $db->query("SELECT * FROM fee_produk WHERE nama_petugas = '$dokter' AND kode_produk = '$kode'");
$data_persen_dokter1 = mysqli_fetch_array($cek_persen_dokter1);

if ($data_persen_dokter1['jumlah_prosentase'] != 0 AND $data_persen_dokter1['jumlah_uang'] == 0 )
{
$hasil_hitung_fee_persen_harga1 = $subtotaljadi * $data_persen_dokter1['jumlah_prosentase'] / 100;
$query_persen_dok3 = $db->query("UPDATE tbs_fee_produk SET nama_petugas= '$dokter' , jumlah_fee = jumlah_fee + '$hasil_hitung_fee_persen_harga1' WHERE nama_petugas = '$dokter' AND kode_produk = '$kode'");

} 

// END hitung persentase dokter update harga 1

else

// Hitung Nominal dokter update harga 1

{

$hasil_hitung_fee_nominal_dokter_harga1 = $data_persen_dokter1['jumlah_uang'] * $jumlah;
$query_nominal_dok3 = $db->query("UPDATE tbs_fee_produk SET nama_petugas= '$dokter' , jumlah_fee = jumlah_fee + '$hasil_hitung_fee_nominal_dokter_harga1'  WHERE nama_petugas = '$dokter' AND kode_produk = '$kode'");

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



$harga = stringdoang($_POST['harga']);
$subtotal = $harga * $jumlah;
$subtotal_d =  $subtotal - $diskon;
$subtotal_p = $subtotal_d + $pajak;
$subtotaljadi = $subtotal_p;


                             // START PERHITUNGAN FEE HARGA 1 INSERT

// PERHITUNGAN UNTUK FEE DOKTER
$ceking = $db->query("SELECT * FROM fee_produk WHERE nama_petugas = '$dokter' AND kode_produk = '$kode'");
$cek_fee_dokter1 = mysqli_num_rows($ceking);
$dataui = mysqli_fetch_array($ceking);

if ($cek_fee_dokter1 > 0){
if ($dataui['jumlah_prosentase'] != 0 AND $dataui['jumlah_uang'] == 0 )

{ 

$hasil_hitung_fee_persen = $subtotaljadi * $dataui['jumlah_prosentase'] / 100;

$insert1 = "INSERT INTO tbs_fee_produk (no_reg,session_id,no_rm,nama_petugas,kode_produk,nama_produk,jumlah_fee,tanggal,jam) VALUES ('$no_reg','$session_id','$no_rm','$dokter','$kode','$nama','$hasil_hitung_fee_persen','$tanggal_sekarang','$jam')";
    
    if ($db->query($insert1) === TRUE) {
    
    } 
    
    else {
    echo "Error: " . $insert1 . "<br>" . $db->error;
    }

}



else
{

$hasil_hitung_fee_nominal = $dataui['jumlah_uang'] * $jumlah;

$insert2 = "INSERT INTO tbs_fee_produk (no_reg,session_id,no_rm,nama_petugas,kode_produk,nama_produk,jumlah_fee,tanggal,jam) VALUES ('$no_reg','$session_id','$no_rm','$dokter','$kode','$nama','$hasil_hitung_fee_nominal','$tanggal_sekarang','$jam')";
    
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

$insert_apoteker = "INSERT INTO tbs_fee_produk (no_reg,session_id,no_rm,nama_petugas,kode_produk,nama_produk,jumlah_fee,tanggal,jam) VALUES ('$no_reg','$no_rm','$apoteker','$kode','$nama','$hasil_hitung_fee_persen_apoteker','$tanggal_sekarang','$jam')";
      
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


$insert2_apoteker = "INSERT INTO tbs_fee_produk (no_reg,session_id,no_rm,nama_petugas,kode_produk,nama_produk,jumlah_fee,tanggal,jam) VALUES ('$no_reg','$no_rm','$apoteker','$kode','$nama','$hasil_hitung_fee_nominal_apoteker','$tanggal_sekarang','$jam')";
      
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

$insert_perawat = "INSERT INTO tbs_fee_produk (no_reg,session_id,no_rm,nama_petugas,kode_produk,nama_produk,jumlah_fee,tanggal,jam) VALUES ('$no_reg','$session_id','$no_rm','$perawat','$kode','$nama','$hasil_hitung_fee_persen_perawat','$tanggal_sekarang','$jam')";
        
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

$insert2_perawat = "INSERT INTO tbs_fee_produk (no_reg,session_id,no_rm,nama_petugas,kode_produk,nama_produk,jumlah_fee,tanggal,jam) VALUES ('$no_reg','$session_id','$no_rm','$perawat','$kode','$nama','$hasil_hitung_fee_nominal_perawat','$tanggal_sekarang','$jam')";
    
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

$insert_petugas_lain = "INSERT INTO tbs_fee_produk (no_reg,session_id,no_rm,nama_petugas,kode_produk,nama_produk,jumlah_fee,tanggal,jam) VALUES ('$no_reg','$session_id','$no_rm','$petugas_lain','$kode','$nama','$hasil_hitung_fee_persen_petugas_lain','$tanggal_sekarang','$jam')";
        
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

$insert1_petugas_lain = "INSERT INTO tbs_fee_produk (no_reg,session_id,no_rm,nama_petugas,kode_produk,nama_produk,jumlah_fee,tanggal,jam) VALUES ('$no_reg','$session_id','$no_rm','$petugas_lain','$kode','$nama','$hasil_hitung_fee_nominal_petugas_lain','$tanggal_sekarang','$jam')";
    
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

$insert1_petugas = "INSERT INTO tbs_fee_produk (no_reg,session_id,no_rm,nama_petugas,kode_produk,nama_produk,jumlah_fee,tanggal,jam) VALUES ('$no_reg','$session_id','$no_rm','$petugas','$kode','$nama','$hasil_hitung_fee_persen_petugas','$tanggal_sekarang','$jam')";

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


$insert2_petugas = "INSERT INTO tbs_fee_produk (no_reg,session_id,no_rm,nama_petugas,kode_produk,nama_produk,jumlah_fee,tanggal,jam) VALUES ('$no_reg','$session_id','$no_rm','$petugas','$kode','$nama','$hasil_hitung_fee_nominal_petugas','$tanggal_sekarang','$jam')";
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
 
 $query6 = "INSERT INTO tbs_penjualan (session_id, no_reg,kode_barang,nama_barang,jumlah_barang,satuan,harga,subtotal,tipe_barang,tanggal,jam,potongan,tax) VALUES ('$session_id','$no_reg','$kode','$nama','$jumlah','$satuan','$harga','$subtotaljadi','$tipe_produk','$tanggal_sekarang','$jam','$diskon','$pajak')";

      if ($db->query($query6) === TRUE) {
      
      } 
      else 
      {
      echo "Error: " . $query6 . "<br>" . $db->error;
      }


//  AKHIR INSERT TBS_PENJUALAN DAN PERHITUNGAN AKHIR DARI FEE PRODUK HARGA 1 DAN SUDAH UPDATENYA JUGA !!!





 ?>
 
  <?php
                
                //menampilkan semua data yang ada pada tabel tbs penjualan dalam DB
                $perintah = $db->query("SELECT tp.jam,tp.id,tp.tipe_barang,tp.kode_barang,tp.satuan,tp.nama_barang,tp.jumlah_barang,tp.harga,tp.subtotal,tp.potongan,tp.tax,s.nama FROM tbs_penjualan tp INNER JOIN satuan s ON tp.satuan = s.id WHERE tp.session_id = '$session_id' AND tp.no_reg = '$no_reg' ORDER BY tp.id DESC");
                
                //menyimpan data sementara yang ada pada $perintah
                
                $data1 = mysqli_fetch_array($perintah);
                //menampilkan data
                echo "<tr class='tr-kode-". $data1['kode_barang'] ." tr-id-". $data1['id'] ."' data-kode-barang='".$data1['kode_barang']."'>
                <td style='font-size:15px'>". $data1['kode_barang'] ."</td>
                <td style='font-size:15px;'>". $data1['nama_barang'] ."</td>";

                $kd = $db->query("SELECT nama_petugas FROM tbs_fee_produk WHERE kode_produk='$data1[kode_barang]' AND jam = '$data1[jam]' ");
                
                $kdD = $db->query("SELECT nama_petugas FROM tbs_fee_produk WHERE kode_produk='$data1[kode_barang]' AND jam = '$data1[jam]' ");
                    
                $nu = mysqli_fetch_array($kd);

                  if ($nu['nama_petugas'] != '')
                  {

                  echo "<td style='font-size:15px;'>";
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


                echo "<td style='font-size:15px' align='right' class='edit-jumlah' data-id='".$data1['id']."'><span id='text-jumlah-".$data1['id']."'>". $data1['jumlah_barang'] ."</span> <input type='hidden' id='input-jumlah-".$data1['id']."' value='".$data1['jumlah_barang']."' class='input_jumlah' data-id='".$data1['id']."' autofocus='' data-kode='".$data1['kode_barang']."' data-harga='".$data1['harga']."' data-tipe='".$data1['tipe_barang']."' data-satuan='".$data1['satuan']."' > </td>
                <td style='font-size:15px'>". $data1['nama'] ."</td>

                <td style='font-size:15px' align='right'>". rp($data1['harga']) ."</td>
                <td style='font-size:15px' align='right'><span id='text-subtotal-".$data1['id']."'>". rp($data1['subtotal']) ."</span></td>
                <td style='font-size:15px' align='right'><span id='text-potongan-".$data1['id']."'>". rp($data1['potongan']) ."</span></td>
                <td style='font-size:15px' align='right'><span id='text-tax-".$data1['id']."'>". rp($data1['tax']) ."</span></td>";

               echo "<td style='font-size:15px'> <button class='btn btn-danger btn-hapus-tbs' id='hapus-tbs-".$data1['id']."' data-id='". $data1['id'] ."' data-kode-barang='". $data1['kode_barang'] ."' data-barang='". $data1['nama_barang'] ."' data-subtotal='". $data1['subtotal'] ."'>Hapus</button> </td> 

                </tr>";

                 //Untuk Memutuskan Koneksi Ke Database
          mysqli_close($db); 

                ?>


<!--datatable-->
<script type="text/javascript">
  $(function () {
  $("#tbs_penjualan").dataTable({ordering : false});
  });  
</script>
<!--end datatable-->




                            <script type="text/javascript">
                                 
                                 $(".edit-jumlah").dblclick(function(){

                                    var id = $(this).attr("data-id");

                                    $("#text-jumlah-"+id+"").hide();

                                    $("#input-jumlah-"+id+"").attr("type", "text");

                                 });


                                 $(".input_jumlah").blur(function(){

                                    var id = $(this).attr("data-id");
                                    var jumlah_baru = $(this).val();
                                    var kode_barang = $(this).attr("data-kode");
                                    var harga = $(this).attr("data-harga");
                                    var jumlah_lama = $("#text-jumlah-"+id+"").text();
                                    var satuan_konversi = $(this).attr("data-satuan");
                                    var tipe_barang = $(this).attr("data-tipe");


                                    var subtotal_lama = bersihPemisah(bersihPemisah(bersihPemisah(bersihPemisah($("#text-subtotal-"+id+"").text()))));
                                    var potongan = bersihPemisah(bersihPemisah(bersihPemisah(bersihPemisah($("#text-potongan-"+id+"").text()))));

                                    var tax = bersihPemisah(bersihPemisah(bersihPemisah(bersihPemisah($("#text-tax-"+id+"").text()))));
                                   
                                    var subtotal = harga * jumlah_baru - potongan;

                                    var subtotal_penjualan = bersihPemisah(bersihPemisah(bersihPemisah(bersihPemisah($("#total2").val()))));

                                    subtotal_penjualan = subtotal_penjualan - subtotal_lama + subtotal;

                                    var pot_fakt_per = bersihPemisah(bersihPemisah(bersihPemisah(bersihPemisah($("#potongan_persen").val()))));
                                    var potongaaan = pot_fakt_per;
                                          var pos = potongaaan.search("%");
                                          var potongan_persen = bersihPemisah(bersihPemisah(bersihPemisah(bersihPemisah(potongaaan))));
                                              potongan_persen = potongan_persen.replace("%","");
                                          potongaaan = subtotal_penjualan * potongan_persen / 100;
                                          $("#potongan_penjualan").val(potongaaan);
                                    
                                    var sub_akhir = parseInt(subtotal_penjualan,10) - parseInt(potongaaan,10)
                                    
                                    var tax_tbs = tax / subtotal_lama * 100;
                                    var jumlah_tax = Math.round(tax_tbs) * subtotal / 100;

                                    if (tipe_barang == 'Jasa') {
                                      
                                      $("#text-jumlah-"+id+"").show();
                                      $("#text-jumlah-"+id+"").text(jumlah_baru);
                                      
                                      $("#text-subtotal-"+id+"").text(tandaPemisahTitik(subtotal));
                                      $("#hapus-tbs-"+id+"").attr('data-subtotal', subtotal);
                                      $("#text-tax-"+id+"").text(Math.round(jumlah_tax));
                                      $("#input-jumlah-"+id+"").attr("type", "hidden"); 
                                      $("#total2").val(tandaPemisahTitik(subtotal_penjualan));
                                      $("#potongan_penjualan").val(tandaPemisahTitik(potongaaan));         
                                      $("#total1").val(tandaPemisahTitik(sub_akhir)); 

                                      $.post("update_pesanan_barang.php",{jumlah_lama:jumlah_lama,tax:tax,id:id,jumlah_baru:jumlah_baru,kode_barang:kode_barang,potongan:potongan,harga:harga,jumlah_tax:jumlah_tax,subtotal:subtotal},function(){
                                      
                                      
                                      
                                      
                                      });

                                    }

                                    else{

                                      $.post("cek_stok_pesanan_barang.php",{kode_barang:kode_barang, jumlah_baru:jumlah_baru,satuan_konversi:satuan_konversi},function(data){

                                       if (data < 0) {

                                       alert ("Jumlah Yang Di Masukan Melebihi Stok !");

                                    $("#input-jumlah-"+id+"").val(jumlah_lama);
                                    $("#text-jumlah-"+id+"").text(jumlah_lama);
                                    $("#text-jumlah-"+id+"").show();
                                    $("#input-jumlah-"+id+"").attr("type", "hidden");
                                    
                                     }

                                      else{


                                    
                                    $("#text-jumlah-"+id+"").show();
                                    $("#text-jumlah-"+id+"").text(jumlah_baru);

                                    $("#text-subtotal-"+id+"").text(tandaPemisahTitik(subtotal));
                                    $("#hapus-tbs-"+id+"").attr('data-subtotal', subtotal);
                                    $("#text-tax-"+id+"").text(Math.round(jumlah_tax));
                                    $("#input-jumlah-"+id+"").attr("type", "hidden"); 
                                    $("#total2").val(tandaPemisahTitik(subtotal_penjualan)); 
                                    $("#potongan_penjualan").val(tandaPemisahTitik(potongaaan));
                                    $("#total1").val(tandaPemisahTitik(sub_akhir));   


                                     $.post("update_pesanan_barang.php",{jumlah_lama:jumlah_lama,tax:tax,id:id,jumlah_baru:jumlah_baru,kode_barang:kode_barang,potongan:potongan,harga:harga,jumlah_tax:jumlah_tax,subtotal:subtotal},function(){


                                    
  

                                    });

                                   }

                                 });

                                    }


       
                                    $("#kode_barang").focus();
                                    

                                 });

                             </script>
