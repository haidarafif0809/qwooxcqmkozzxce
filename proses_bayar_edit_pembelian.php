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
            $sisa_kredit = angkadoang($_POST['kredit']);
            $nomor_faktur = stringdoang($_POST['no_faktur']);
            $suplier = stringdoang($_POST['suplier']);
            $total = angkadoang($_POST['total']);
            $total_1 = angkadoang($_POST['total_1']);
            $potongan = angkadoang($_POST['potongan']);
            $tax = angkadoang($_POST['tax']);
            $ppn_input = stringdoang($_POST['ppn_input']);
            $sisa_pembayaran = angkadoang($_POST['sisa_pembayaran']);
            $cara_bayar = stringdoang($_POST['cara_bayar']);
            $pembayaran = angkadoang($_POST['pembayaran']);
            $tanggal = stringdoang($_POST['tanggal']);
            $user = $_SESSION['user_name'];
            $no_faktur_suplier = stringdoang($_POST['no_faktur_suplier']);
            $tanggal_jt = angkadoang($_POST['tanggal_jt']);
            $x = angkadoang($_POST['x']);
            $sisa = 0;

            if ($x <= $total) {
            $sisa = 0;
            } 
            
            else {
            $sisa = $x - $total;
            }

            $t_total = $total_1 - $potongan;

            $a = $total_1 - $potongan;
            $tax_persen = $tax * $a / 100;
           
            $_SESSION['no_faktur']=$nomor_faktur;

// end siapkan "data" query dari post form edit pembelian


            // setting akun
            $select_setting_akun = $db->query("SELECT hpp_penjualan,pengaturan_stok,persediaan,item_keluar FROM setting_akun");
            $ambil_setting = mysqli_fetch_array($select_setting_akun);



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


            if ($kel_hpp_kel['sum_hpp'] <= $data['jumlah_barang'] AND $cek_hpp_kel2 > 0) {


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

            //PROSES UNTUK UPDATE HARGA BELI PADA PRODUK TERSEBUT 
                  $query_barang = $db->query("SELECT harga_beli,satuan,kode_barang FROM barang WHERE kode_barang = '$data[kode_barang]' ");
                  $data_barang = mysqli_fetch_array($query_barang);


                  if($data['harga'] != $data_barang['harga_beli']){

                      //Cek apakah barang tersebut memiliki Konversi ?
                      $query_cek_satuan_konversi = $db->query("SELECT konversi FROM satuan_konversi WHERE kode_produk = '$data[kode_barang]' AND id_satuan = '$data[satuan]'");
                      $data_jumlah_konversi = mysqli_fetch_array($query_cek_satuan_konversi);
                      $data_jumlah = mysqli_num_rows($query_cek_satuan_konversi);


                      if($data_jumlah > 0){
                        $hasil_konversi = $data['harga'] / $data_jumlah_konversi['konversi'];
                        //Jika Iya maka ambil harga setelah di bagi dengan jumlah barang yang sebenarnya di konversi !!
                        $harga_beli_sebenarnya = $hasil_konversi;
                        //Update Harga Pokok pada konversi
                        $query_update_harga_konversi  = $db->query("UPDATE satuan_konversi SET harga_pokok = '$data[harga]' WHERE kode_produk = '$data[kode_barang]'");
                       
                      }
                      else{
                        //Jika Tidak ambil harga yang sebenarnya dari TBS !!
                        $harga_beli_sebenarnya = $data['harga'];
                      }


                      $query_update_harga_beli  = $db->query("UPDATE barang SET harga_beli = '$harga_beli_sebenarnya' WHERE kode_barang = '$data[kode_barang]'");


                      //UPDATE CACHE PRODUK TERSEBUT
                      include 'cache.class.php';

                          $c = new Cache();
                          
                          $c->setCache('produk_obat');

                          $c->eraseAll();


                      $query_cache = $db->query("SELECT * FROM barang WHERE kode_barang = '$data_barang[kode_barang]' ");
                      while ($data = $query_cache->fetch_array()) {
                       # code...
                          // store an array
                          $c->store($data['kode_barang'], array(
                              'kode_barang' => $data['kode_barang'],
                              'nama_barang' => $data['nama_barang'],
                              'harga_beli' => $data['harga_beli'],
                              'harga_jual' => $data['harga_jual'],
                              'harga_jual2' => $data['harga_jual2'],
                              'harga_jual3' => $data['harga_jual3'],
                              'harga_jual4' => $data['harga_jual4'],
                              'harga_jual5' => $data['harga_jual5'],
                              'harga_jual6' => $data['harga_jual6'],
                              'harga_jual7' => $data['harga_jual7'],
                              
                              
                              "harga_jual_inap" =>$data['harga_jual_inap'],
                              "harga_jual_inap2" =>$data['harga_jual_inap2'],
                              "harga_jual_inap3" =>$data['harga_jual_inap3'],
                              "harga_jual_inap4" =>$data['harga_jual_inap4'],
                              "harga_jual_inap5" =>$data['harga_jual_inap5'],
                              "harga_jual_inap6" =>$data['harga_jual_inap6'],
                              "harga_jual_inap7" =>$data['harga_jual_inap7'],
                              
                              'kategori' => $data['kategori'],
                              'suplier' => $data['suplier'],
                              'limit_stok' => $data['limit_stok'],
                              'over_stok' => $data['over_stok'],
                              'berkaitan_dgn_stok' => $data['berkaitan_dgn_stok'],
                              'tipe_barang' => $data['tipe_barang'],
                              'status' => $data['status'],
                              'satuan' => $data['satuan'],
                              'id' => $data['id'],

                          ));

                      }

                      $c->retrieveAll();
                      // AKHIR DARI UPDATE CHACHE PRODUK TERSEBUT
                  }
                  //AKHIR PROSES UNTUK UPDATE HARGA BELI PADA PRODUK TERSEBUT 

            
            }

            $ambil_har_unit = $db->query("SELECT no_faktur,harga_unit,jumlah_kuantitas, jenis_transaksi FROM hpp_keluar WHERE no_faktur_hpp_masuk = '$nomor_faktur' AND kode_barang = '$data[kode_barang]' ");
            while ($kel_harga_unnit = mysqli_fetch_array($ambil_har_unit)) {
              
               if ($kel_harga_unnit['harga_unit'] != $harga ) 
                  {



                      $updattte = $db->query("UPDATE hpp_keluar SET harga_unit = '$harga' , total_nilai = harga_unit * jumlah_kuantitas WHERE  no_faktur_hpp_masuk = '$nomor_faktur' AND kode_barang = '$data[kode_barang]' ");

                                            // ambil total nilai hpp keluar
                      $sum_hpp_keluar = $db->query("SELECT SUM(total_nilai) AS total FROM hpp_keluar WHERE no_faktur = '$kel_harga_unnit[no_faktur]'");
                      $ambil_sum = mysqli_fetch_array($sum_hpp_keluar);
                      $total_nilai_keluar = $ambil_sum['total'];
                      if ($total_nilai_keluar ==  NULL) {
                          $total_nilai_keluar = 0;
                      }

                      /// jika jenis transaksi nya penjualan
                        if ($kel_harga_unnit['jenis_transaksi'] == 'Penjualan') {
                               
                               // update persediaan di jurnal penjualan
                                                          // Item Keluar
                              $db->query("UPDATE jurnal_trans SET debit =  '$total_nilai_keluar' WHERE no_faktur = '$kel_harga_unnit[no_faktur]' AND kode_akun_jurnal = '$ambil_setting[hpp_penjualan]' ");

                              $db->query("UPDATE jurnal_trans SET kredit =  '$total_nilai_keluar' WHERE no_faktur = '$kel_harga_unnit[no_faktur]' AND kode_akun_jurnal = '$ambil_setting[persediaan]' ");
                                                      

                        }
                        elseif ($kel_harga_unnit['jenis_transaksi'] == 'Item Keluar') {

                          // Item Keluar
                              $db->query("UPDATE jurnal_trans SET debit =  '$total_nilai_keluar' WHERE no_faktur = '$kel_harga_unnit[no_faktur]' AND kode_akun_jurnal = '$ambil_setting[item_keluar]' ");

                              $db->query("UPDATE jurnal_trans SET kredit =  '$total_nilai_keluar' WHERE no_faktur = '$kel_harga_unnit[no_faktur]' AND kode_akun_jurnal = '$ambil_setting[persediaan]' ");
                                                      
                        }
                        elseif ($kel_harga_unnit['jenis_transaksi'] == 'Stok Opname') {

                              # Stok Opname
                               
                               // ambil total nilai hpp keluar
                              $sum_hpp_masuk = $db->query("SELECT SUM(total_nilai) AS total FROM hpp_masuk WHERE no_faktur = '$kel_harga_unnit[no_faktur]'");
                              $ambil_sum_masuk = mysqli_fetch_array($sum_hpp_masuk);
                              $total_nilai_masuk = $ambil_sum_masuk['total'];

                              if ($total_nilai_masuk ==  NULL) {

                                  $total_nilai_masuk = 0;
                              }

                              $total_opname = $total_nilai_masuk - $total_nilai_keluar;

                                if($total_opname < 0)
                                {
                                  $total_opname = $total_opname * -1;

                                  $update_jurnal1 = $db->query("UPDATE jurnal_trans SET kredit = '$total_opname' WHERE kode_akun_jurnal = '$ambil_setting[persediaan]' AND no_faktur = '$kel_harga_unnit[no_faktur]' ");

                                  $update_jurnal2 = $db->query("UPDATE jurnal_trans SET debit = '$total_opname'  WHERE kode_akun_jurnal = '$ambil_setting[pengaturan_stok]' AND no_faktur = '$kel_harga_unnit[no_faktur]' ");


                                }
                                else
                                {
                                  $total_opname = $total_opname;


                                  $update_jurnal1 = $db->query("UPDATE jurnal_trans SET debit = '$total_opname' WHERE kode_akun_jurnal = '$ambil_setting[persediaan]' AND no_faktur = '$kel_harga_unnit[no_faktur]' ");

                                  $update_jurnal2 = $db->query("UPDATE jurnal_trans SET kredit = '$total_opname'  WHERE kode_akun_jurnal = '$ambil_setting[pengaturan_stok]' AND no_faktur = '$kel_harga_unnit[no_faktur]' ");
                                }

                        }



                  }

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
            $stmt2->bind_param("ssisssiiiisisss", 
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
            $stmt2->bind_param("ssissssiiiisisss", 
            $nomor_faktur, $suplier, $total , $tanggal, $jam_sekarang, $tanggal_jt, $user, $potongan, $tax, $sisa, $sisa_kredit, $cara_bayar, $pembayaran, $ppn_input,$no_faktur_suplier, $nomor_faktur);
            
            $sisa_kredit = angkadoang($_POST['jumlah_kredit_baru']);

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
        $insert_juranl = $db->query("INSERT INTO jurnal_trans (nomor_jurnal,waktu_jurnal,keterangan_jurnal,kode_akun_jurnal,debit,kredit,jenis_transaksi,no_faktur,approved,user_buat) VALUES ('".no_jurnal()."', '$tanggal $jam_sekarang', 'Pembelian Tunai - $ambil_suplier[nama]', '$ambil_setting[potongan]', '0', '$potongan', 'Pembelian', '$nomor_faktur','1', '$user')");
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