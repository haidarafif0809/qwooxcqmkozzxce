<?php session_start();

    include 'sanitasi.php';
    include 'db.php';

$tahun_sekarang = date('Y');
$bulan_sekarang = date('m');
$tanggal_sekarang = date('Y-m-d');
$jam_sekarang = date('H:i:s');
$tahun_terakhir = substr($tahun_sekarang, 2);

$tanggal = stringdoang($_POST['tanggal']);
$waktu = $tanggal." ".$jam_sekarang;
$suplier = stringdoang($_POST['suplier']);

$select_suplier = $db->query("SELECT id,nama FROM suplier WHERE id = '$suplier'");
$ambil_suplier = mysqli_fetch_array($select_suplier);


            
// siapkan "data" query dari post form edit pembelian
            $sisa_kredit = stringdoang($_POST['kredit']);
            if ($sisa_kredit == '' ) {
                $sisa_kredit = 0;
              }
            $nomor_faktur = stringdoang($_POST['no_faktur']);
            $suplier = stringdoang($_POST['suplier']);
            $total = stringdoang($_POST['total']);
            $total = str_replace(',','.',$total);
              if ($total == '') {
                $total = 0;
              }
            $total_1 = stringdoang($_POST['total_1']);
            $total_1 = str_replace(',','.',$total_1);
              if ($total_1 == '') {
                $total_1 = 0;
              }
            $potongan = stringdoang($_POST['potongan']);
            $potongan = str_replace(',','.',$potongan);
              if ($potongan == '') {
                $potongan = 0;
              }
            $tax = stringdoang($_POST['tax']);
            $tax = str_replace(',','.',$tax);
              if ($tax == '') {
                $tax = 0;
              }

            $ppn_input = stringdoang($_POST['ppn_input']);

            $sisa_pembayaran = stringdoang($_POST['sisa_pembayaran']);
            $sisa_pembayaran = str_replace(',','.',$sisa_pembayaran);
              if ($sisa_pembayaran == '') {
                $sisa_pembayaran = 0;
              }

            $cara_bayar = stringdoang($_POST['cara_bayar']);

            $pembayaran = stringdoang($_POST['pembayaran']);
            $pembayaran = str_replace(',','.',$pembayaran);
             if ($pembayaran == '') {
                $pembayaran = 0;
              }

            $tanggal = stringdoang($_POST['tanggal']);
            $user = $_SESSION['user_name'];
            $no_faktur_suplier = stringdoang($_POST['no_faktur_suplier']);
            $tanggal_jt = stringdoang($_POST['tanggal_jt']);
            

            $sisa = stringdoang($_POST['sisa']);
           $sisa = str_replace(',','.',$sisa);
              if ($sisa == '') {
                $sisa = 0;
              }



            $t_total = $total_1 - $potongan;

            $a = $total_1 - $potongan;
            $tax_persen = $tax * $a / 100;
           
            $_SESSION['no_faktur']=$nomor_faktur;

// end siapkan "data" query dari post form edit pembelian




//query delete jurnal 
            $delete_jurnal = $db->query("DELETE FROM jurnal_trans WHERE no_faktur = '$nomor_faktur'");
//query delete jurnal 



// query untuk menghapus barang di detail yang sudah terhapus di tbs karena pembelian tidak boleh langsung menghapus detail semua (warning)
            $select_detail_pem = $db->query("SELECT kode_barang FROM detail_pembelian WHERE no_faktur = '$nomor_faktur' ");
            while($for_det = mysqli_fetch_array($select_detail_pem))
            {

                $select_tbs_pem = $db->query("SELECT no_faktur FROM tbs_pembelian WHERE no_faktur = '$nomor_faktur' AND kode_barang = '$for_det[kode_barang]' ");
                $num_roows = mysqli_num_rows($select_tbs_pem);

                if ($num_roows == 0 )
                {
                    $delettte = $db->query("DELETE FROM detail_pembelian WHERE no_faktur = '$nomor_faktur' AND kode_barang = '$for_det[kode_barang]' ");
                } 

            }
// query untuk menghapus barang di detail yang sudah terhapus di tbs karena pembelian tidak boleh langsung menghapus detail semua (warning)
 



// query untuk memindahkan data dari tbs -> detail pembelian dengan perubahan data di tbs akan dicek terlebih dahulu di hpp keluar & hpp masuk silakan diamati
            $query12 = $db->query("SELECT * FROM tbs_pembelian WHERE no_faktur = '$nomor_faktur' ");
            while ($data = mysqli_fetch_array($query12))
            {

            $select_hpp_keluar = $db->query("SELECT SUM(jumlah_kuantitas) as jum FROM hpp_keluar WHERE no_faktur_hpp_masuk = '$nomor_faktur' AND kode_barang = '$data[kode_barang]'");
            $data_hpp_keluar = mysqli_fetch_array($select_hpp_keluar);
            $jumlah_keluar = $data_hpp_keluar['jum'];

            $select_hpp_masuk = $db->query("SELECT IFNULL(SUM(jumlah_kuantitas),0) as sum_hpp FROM hpp_keluar WHERE no_faktur_hpp_masuk = '$nomor_faktur' AND kode_barang = '$data[kode_barang]' ");
            $kel_hpp_kel = mysqli_fetch_array($select_hpp_masuk);


              $select_hpp_keluar2 = $db->query("SELECT COUNT(*) FROM hpp_keluar WHERE no_faktur_hpp_masuk = '$nomor_faktur' AND kode_barang = '$data[kode_barang]'");
                $cek_hpp_kel2 = mysqli_num_rows($select_hpp_keluar2);


            if ($kel_hpp_kel['sum_hpp'] < $data['jumlah_barang'] AND $cek_hpp_kel2 > 0) {


            $delete_detail_pembelian = $db->query("DELETE FROM detail_pembelian WHERE no_faktur = '$nomor_faktur' AND kode_barang = '$data[kode_barang]'");
            
            $pilih_konversi = $db->query("SELECT  sk.konversi * $data[jumlah_barang] AS jumlah_konversi, sk.harga_pokok * $data[jumlah_barang] / sk.konversi AS harga_konversi, sk.id_satuan, b.satuan FROM satuan_konversi sk INNER JOIN barang b ON sk.id_produk = b.id  WHERE sk.id_satuan = '$data[satuan]' AND kode_produk = '$data[kode_barang]'");
            $data_konversi = mysqli_fetch_array($pilih_konversi);
            
            if ($data_konversi['harga_konversi'] != 0 || $data_konversi['harga_konversi'] != "") {
            $harga = $data_konversi['harga_konversi'];
            $jumlah_barang = $data_konversi['jumlah_konversi'];
            $satuan = $data_konversi['satuan'];
            $sisa_barang = $jumlah_barang - $jumlah_keluar;
            }
            else{
            $harga = $data['harga'];
            $jumlah_barang = $data['jumlah_barang'];
            $satuan = $data['satuan'];
            $sisa_barang = $jumlah_barang - $jumlah_keluar;
            }

            $query2 = "INSERT INTO detail_pembelian (no_faktur, tanggal, jam, waktu, kode_barang, nama_barang, jumlah_barang, asal_satuan, satuan, harga, subtotal, potongan, tax, sisa) 
            VALUES ('$nomor_faktur','$tanggal','$jam_sekarang','$waktu','$data[kode_barang]','$data[nama_barang]','$jumlah_barang', '$satuan','$data[satuan]','$harga','$data[subtotal]','$data[potongan]','$data[tax]','$sisa_barang')";


                       if ($db->query($query2) === TRUE) {
                       } 
                       
                       else {
                       echo "Error: " . $query2 . "<br>" . $db->error;
                       }
            
            }

            $total_sub = $data['harga'] * $jumlah_barang;

        $ambil_har_unit = $db->query("SELECT harga_unit,jumlah_kuantitas FROM hpp_keluar WHERE no_faktur_hpp_masuk = '$nomor_faktur' AND kode_barang = '$data[kode_barang]' ");
            $kel_harga_unnit = mysqli_fetch_array($ambil_har_unit);

                if ($kel_harga_unnit['harga_unit'] != $harga ) 
                {

                    $sub_akhir = $kel_harga_unnit['jumlah_kuantitas'] *  $harga;

               $updattte = $db->query(" UPDATE hpp_keluar SET harga_unit = '$harga' , total_nilai = '$sub_akhir' WHERE  no_faktur_hpp_masuk = '$nomor_faktur' AND kode_barang = '$data[kode_barang]' ");

                }

 
        }
// query untuk memindahkan data dari tbs -> detail pembelian dengan perubahan data di tbs akan dicek terlebih dahulu di hpp keluar & hpp masuk silakan diamati




// BAHAN UNTUK JURNAL PENGAMBILAN SETTING AKUN DAN TOTAL TAX DARI DETAIL PEMBELIAN
$select_setting_akun = $db->query("SELECT persediaan,pajak,hutang,potongan,kas FROM setting_akun");
$ambil_setting = mysqli_fetch_array($select_setting_akun);


$sum_tax_tbs = $db->query("SELECT SUM(tax) AS total_tax FROM detail_pembelian WHERE no_faktur = '$nomor_faktur'");
$jumlah_tax = mysqli_fetch_array($sum_tax_tbs);
$total_tax = $jumlah_tax['total_tax'];
// BAHAN UNTUK JURNAL PENGAMBILAN SETTING AKUN DAN TOTAL TAX DARI DETAIL PEMBELIAN




//START PROSES UNTUK INSERT PEMBELIAN & JURNAL DENGAN PEMBAYARAN LUNAS
            if ($sisa_kredit == 0 ) 
            {
// START QUERY PEMBELIAN LUNAS

// buat prepared statements
            $stmt2 = $db->prepare("UPDATE pembelian SET no_faktur = ?, suplier = ?, total = ?, tanggal = ?, jam = ?, user = ?, status = 'Lunas', potongan = ?, tax = ?, sisa = ?, kredit = ?, cara_bayar = ?, tunai = ?, status_beli_awal = 'Tunai', ppn = ?, no_faktur_suplier = ? WHERE no_faktur = ? ");
            
            
            // hubungkan "data" dengan prepared statements
            $stmt2->bind_param("sssssssssssssss", 
            $nomor_faktur, $suplier, $total , $tanggal, $jam_sekarang, $user, $potongan, $tax_persen, $sisa, $sisa_kredit, $cara_bayar, $pembayaran, $ppn_input,$no_faktur_suplier, $nomor_faktur);
            
             $sisa_kredit = 0;


            
// jalankan query
 $stmt2->execute();

// cek query statment
if (!$stmt2) {
   die('Query Error : '.$db->errno.
   ' - '.$db->error);
}
else {
    echo "Success";

}
// cek query statment


// END QUERY PEMBELIAN LUNAS

if ($ppn_input == "Non") {
echo $ppn_input;
    $persediaan = $total_1;
    $total_akhir = $total;


  //PERSEDIAAN    
        $insert_jurnal = $db->query("INSERT INTO jurnal_trans (nomor_jurnal,waktu_jurnal,keterangan_jurnal,kode_akun_jurnal,debit,kredit,jenis_transaksi,no_faktur,approved,user_buat) VALUES ('".no_jurnal()."', '$tanggal $jam_sekarang', 'Pembelian Tunai - $ambil_suplier[nama]', '$ambil_setting[persediaan]', '$persediaan', '0', 'Pembelian', '$nomor_faktur','1', '$user')");
} 

else if ($ppn_input == "Include") {
//ppn == Include
echo $ppn_input;
  $persediaan = $total_1 - $total_tax;
  $total_akhir = $total;
  $pajak = $total_tax;

  //PERSEDIAAN    
        $insert_jurnal = $db->query("INSERT INTO jurnal_trans (nomor_jurnal,waktu_jurnal,keterangan_jurnal,kode_akun_jurnal,debit,kredit,jenis_transaksi,no_faktur,approved,user_buat) VALUES ('".no_jurnal()."', '$tanggal $jam_sekarang', 'Pembelian Tunai - $ambil_suplier[nama]', '$ambil_setting[persediaan]', '$persediaan', '0', 'Pembelian', '$nomor_faktur','1', '$user')");

if ($pajak != "" || $pajak != 0) {
//PAJAK
        $insert_juranl = $db->query("INSERT INTO jurnal_trans (nomor_jurnal,waktu_jurnal,keterangan_jurnal,kode_akun_jurnal,debit,kredit,jenis_transaksi,no_faktur,approved,user_buat) VALUES ('".no_jurnal()."', '$tanggal $jam_sekarang', 'Pembelian Tunai - $ambil_suplier[nama]', '$ambil_setting[pajak]', '$pajak', '0', 'Pembelian', '$nomor_faktur','1', '$user')");
}

}

else {
    echo $ppn_input;

//ppn == Exclude
  $persediaan = $total_1;
  $total_akhir = $total;
  $pajak = $tax_persen;

  //PERSEDIAAN    
        $insert_jurnal = $db->query("INSERT INTO jurnal_trans (nomor_jurnal,waktu_jurnal,keterangan_jurnal,kode_akun_jurnal,debit,kredit,jenis_transaksi,no_faktur,approved,user_buat) VALUES ('".no_jurnal()."', '$tanggal $jam_sekarang', 'Pembelian Tunai - $ambil_suplier[nama]', '$ambil_setting[persediaan]', '$persediaan', '0', 'Pembelian', '$nomor_faktur','1', '$user')");

if ($pajak != "" || $pajak != 0) {
//PAJAK
        $insert_juranl = $db->query("INSERT INTO jurnal_trans (nomor_jurnal,waktu_jurnal,keterangan_jurnal,kode_akun_jurnal,debit,kredit,jenis_transaksi,no_faktur,approved,user_buat) VALUES ('".no_jurnal()."', '$tanggal $jam_sekarang', 'Pembelian Tunai - $ambil_suplier[nama]', '$ambil_setting[pajak]', '$pajak', '0', 'Pembelian', '$nomor_faktur','1', '$user')");
}

}



//KAS
        $insert_juranl = $db->query("INSERT INTO jurnal_trans (nomor_jurnal,waktu_jurnal,keterangan_jurnal,kode_akun_jurnal,debit,kredit,jenis_transaksi,no_faktur,approved,user_buat) VALUES ('".no_jurnal()."', '$tanggal $jam_sekarang', 'Pembelian Tunai - $ambil_suplier[nama]', '$cara_bayar', '0', '$total_akhir', 'Pembelian', '$nomor_faktur','1', '$user')");

if ($potongan != "" || $potongan != 0 ) {
//POTONGAN
        $insert_juranl = $db->query("INSERT INTO jurnal_trans (nomor_jurnal,waktu_jurnal,keterangan_jurnal,kode_akun_jurnal,debit,kredit,jenis_transaksi,no_faktur,approved,user_buat) VALUES ('".no_jurnal()."', '$tanggal $jam_sekarang', 'Pembelian Tunai - $ambil_suplier[nama]', '$ambil_setting[potongan]', '0', '$potongan', 'Pembelian', '$nomor_faktur','1', '$user')");
}
// END QUERY JURNAL PEMBELIAN LUNAS


}
//END  PROSES UNTUK INSERT PEMBELIAN & JURNAL DENGAN PEMBAYARAN LUNAS


//START PROSES UNTUK INSERT PEMBELIAN & JURNAL DENGAN PEMBAYARAN HUTANG         
         if ($sisa_kredit != 0 ) 

            {
 // START QUERY PEMBELIAN PEMBAYARAN HUTANG                  
            $stmt2 = $db->prepare("UPDATE pembelian SET no_faktur = ?, suplier = ?, total = ?, tanggal = ?, jam = ?, tanggal_jt = ?, user = ?, status = 'Hutang', potongan = ?, tax = ?, sisa = ?, kredit = ?, cara_bayar = ?, tunai = ?, status_beli_awal = 'Kredit', ppn = ? , no_faktur_suplier = ? WHERE no_faktur = ?");
            
            
            // hubungkan "data" dengan prepared statements
            $stmt2->bind_param("ssssssssssssssss", 
            $nomor_faktur, $suplier, $total , $tanggal, $jam_sekarang, $tanggal_jt, $user, $potongan, $tax, $sisa, $sisa_kredit, $cara_bayar, $pembayaran, $ppn_input,$no_faktur_suplier, $nomor_faktur);

// jalankan query
      $stmt2->execute(); 

// cek query statment
if (!$stmt2) {
   die('Query Error : '.$db->errno.
   ' - '.$db->error);
}
else {
    echo "Success";

}
// cek query statment

// END QUERY PEMBELIAN PEMBAYARAN HUTANG



// QUERY JURNAL PEMBELIAN HUTANG
if ($ppn_input == "Non") {
echo $ppn_input;
    $persediaan = $total_1;
    $total_akhir = $total;

      //PERSEDIAAN    
        $insert_jurnal = $db->query("INSERT INTO jurnal_trans (nomor_jurnal,waktu_jurnal,keterangan_jurnal,kode_akun_jurnal,debit,kredit,jenis_transaksi,no_faktur,approved,user_buat) VALUES ('".no_jurnal()."', '$tanggal $jam_sekarang', 'Pembelian Hutang - $ambil_suplier[nama]', '$ambil_setting[persediaan]', '$persediaan', '0', 'Pembelian', '$nomor_faktur','1', '$user')");

    }

else if ($ppn_input == "Include") {
//ppn == Include
echo $ppn_input;
  $persediaan = $total_1 - $total_tax;
  $total_akhir = $total;
  $pajak = $total_tax;


//PERSEDIAAN    
        $insert_jurnal = $db->query("INSERT INTO jurnal_trans (nomor_jurnal,waktu_jurnal,keterangan_jurnal,kode_akun_jurnal,debit,kredit,jenis_transaksi,no_faktur,approved,user_buat) VALUES ('".no_jurnal()."', '$tanggal $jam_sekarang', 'Pembelian Hutang - $ambil_suplier[nama]', '$ambil_setting[persediaan]', '$persediaan', '0', 'Pembelian', '$nomor_faktur','1', '$user')");


if ($pajak != "" || $pajak != 0) {
//PAJAK
        $insert_juranl = $db->query("INSERT INTO jurnal_trans (nomor_jurnal,waktu_jurnal,keterangan_jurnal,kode_akun_jurnal,debit,kredit,jenis_transaksi,no_faktur,approved,user_buat) VALUES ('".no_jurnal()."', '$tanggal $jam_sekarang', 'Pembelian Hutang - $ambil_suplier[nama]', '$ambil_setting[pajak]', '$pajak', '0', 'Pembelian', '$nomor_faktur','1', '$user')");
      }


}

else {
echo $ppn_input;
//ppn == Exclude
  $persediaan = $total_1;
  $total_akhir = $total;
  $pajak = $tax_persen;

//PERSEDIAAN    
        $insert_jurnal = $db->query("INSERT INTO jurnal_trans (nomor_jurnal,waktu_jurnal,keterangan_jurnal,kode_akun_jurnal,debit,kredit,jenis_transaksi,no_faktur,approved,user_buat) VALUES ('".no_jurnal()."', '$tanggal $jam_sekarang', 'Pembelian Hutang - $ambil_suplier[nama]', '$ambil_setting[persediaan]', '$persediaan', '0', 'Pembelian', '$nomor_faktur','1', '$user')");

if ($pajak != "" || $pajak != 0) {
//PAJAK
        $insert_juranl = $db->query("INSERT INTO jurnal_trans (nomor_jurnal,waktu_jurnal,keterangan_jurnal,kode_akun_jurnal,debit,kredit,jenis_transaksi,no_faktur,approved,user_buat) VALUES ('".no_jurnal()."', '$tanggal $jam_sekarang', 'Pembelian Hutang - $ambil_suplier[nama]', '$ambil_setting[pajak]', '$pajak', '0', 'Pembelian', '$nomor_faktur','1', '$user')");
      }


}

//HUTANG    
        $insert_jurnal = $db->query("INSERT INTO jurnal_trans (nomor_jurnal,waktu_jurnal,keterangan_jurnal,kode_akun_jurnal,debit,kredit,jenis_transaksi,no_faktur,approved,user_buat) VALUES ('".no_jurnal()."', '$tanggal $jam_sekarang', 'Pembelian Hutang - $ambil_suplier[nama]', '$ambil_setting[hutang]', '0', '$sisa_kredit', 'Pembelian', '$nomor_faktur','1', '$user')");

     if ($pembayaran > 0 ) 
     
        {
//KAS
        $insert_juranl = $db->query("INSERT INTO jurnal_trans (nomor_jurnal,waktu_jurnal,keterangan_jurnal,kode_akun_jurnal,debit,kredit,jenis_transaksi,no_faktur,approved,user_buat) VALUES ('".no_jurnal()."', '$tanggal $jam_sekarang', 'Pembelian Hutang - $ambil_suplier[nama]', '$ambil_setting[kas]', '0', '$pembayaran', 'Pembelian', '$nomor_faktur','1', '$user')");
        }


if ($potongan != "" || $potongan != 0 ) {
//POTONGAN
        $insert_juranl = $db->query("INSERT INTO jurnal_trans (nomor_jurnal,waktu_jurnal,keterangan_jurnal,kode_akun_jurnal,debit,kredit,jenis_transaksi,no_faktur,approved,user_buat) VALUES ('".no_jurnal()."', '$tanggal $jam_sekarang', 'Pembelian - $ambil_suplier[nama]', '$ambil_setting[potongan]', '0', '$potongan', 'Pembelian', '$nomor_faktur','1', '$user')");
}

}
//END  PROSES UNTUK INSERT PEMBELIAN & JURNAL DENGAN PEMBAYARAN LUNAS

// memasukan history edit tbs pembelian   
$history_tbs_pembelian = $db->query("INSERT INTO history_edit_tbs_pembelian (session_id,no_faktur,kode_barang,nama_barang,jumlah_barang,satuan,harga,subtotal,potongan,tax) SELECT session_id,no_faktur,kode_barang,nama_barang,jumlah_barang,satuan,harga,subtotal,potongan,tax FROM tbs_pembelian  WHERE no_faktur = '$nomor_faktur' ");
// end memasukan history edit tbs pembelian   


$perintah2 = $db->query("DELETE FROM tbs_pembelian WHERE no_faktur = '$nomor_faktur'");




//Untuk Memutuskan Koneksi Ke Database
mysqli_close($db);   
?>