<?php session_start();
include 'db.php';
include_once 'sanitasi.php';


$tanggal = stringdoang($_POST['tanggal']);
$jam = stringdoang($_POST['jam']);
$session_id = session_id();
$tahun_sekarang = date('Y');
$bulan_sekarang = date('m');
$tanggal_sekarang = $tanggal;
$jam_sekarang = $jam;
$tahun_terakhir = substr($tahun_sekarang, 2);

$petugas_edit = $_SESSION['id'];
$waktu = $tahun_sekarang." ".$jam_sekarang;

try {
    // First of all, let's begin a transaction
$db->begin_transaction();
    // A set of queries; if one fails, an exception should be thrown


$total = angkadoang($_POST['total']);
$potongan = angkadoang($_POST['potongan']);
$biaya_admin = angkadoang($_POST['biaya_admin']);
$no_faktur = stringdoang($_POST['no_faktur']);


// menampilakn hasil penjumlah subtotal ALIAS total penjualan dari tabel tbs_penjualan berdasarkan data no faktur
 $query = $db->query("SELECT SUM(subtotal) AS total_penjualan FROM tbs_penjualan WHERE no_faktur = '$no_faktur' AND no_reg = '' AND lab IS NULL AND session_id IS NULL ");
 $data = mysqli_fetch_array($query);

 $total_ss = $data['total_penjualan'];
 $total_tbs = ($total_ss - $potongan) + $biaya_admin;


if ($total != $total_tbs) {

    echo 1;

  }
else{


      echo $no_faktur = stringdoang($_POST['no_faktur']);
      $no_rm = stringdoang($_POST['kode_pelanggan']);
      $apoteker = stringdoang($_POST['apoteker']);
      $nama_petugas = stringdoang($_SESSION['nama']);
      $resep_dokter = stringdoang($_POST['resep_dokter']);
      $no_resep = stringdoang($_POST['no_resep_dokter']);
      $kode_gudang = stringdoang($_POST['kode_gudang']);
      $ppn_input = stringdoang($_POST['ppn_input']);
      $penjamin = stringdoang($_POST['penjamin']);
      $user = $_SESSION['nama'];
      $keterangan = stringdoang($_POST['keterangan']);
      $total = angkadoang($_POST['total']);
      $total2 = angkadoang($_POST['total2']);
      $potongan = angkadoang($_POST['potongan']);
      /*$tax = angkadoang($_POST['tax']);*/
      $biaya_admin = angkadoang($_POST['biaya_admin']);
      $sisa_pembayaran = angkadoang($_POST['sisa_pembayaran']);
      $sisa = angkadoang($_POST['sisa']);
      $cara_bayar = stringdoang($_POST['cara_bayar']);
      $pembayaran = angkadoang($_POST['pembayaran']);
      $petugas_kasir = angkadoang($_POST['id_kasir']);
      $tanggal_jt = stringdoang($_POST['tanggal_jt']);
      $jenis_penjualan = 'Apotek';

      $tanggal_jt = tanggal_mysql($tanggal_jt);
      $no_jurnal = no_jurnal();

      $id_userr = $db->query("SELECT id FROM user WHERE nama = '$user'");
      $data_id = mysqli_fetch_array($id_userr);
      $id_kasir = $data_id['id'];

          $select_kode_pelanggan = $db->query("SELECT nama_pelanggan FROM pelanggan WHERE kode_pelanggan = '$no_rm'");
          $ambil_kode_pelanggan = mysqli_fetch_array($select_kode_pelanggan);

          
          $perintah0 = $db->query("SELECT * FROM fee_faktur WHERE nama_petugas = '$id_kasir'");
          $cek = mysqli_fetch_array($perintah0);
          $nominal = $cek['jumlah_uang'];
          $prosentase = $cek['jumlah_prosentase'];



          $quersad = $db->query("DELETE  FROM jurnal_trans WHERE no_faktur = '$no_faktur' ");


          $query3 = $db->query("DELETE  FROM laporan_fee_faktur WHERE no_faktur = '$no_faktur' ");

          if ($nominal != 0) {
            
            $perintah01 = $db->query("INSERT INTO laporan_fee_faktur (nama_petugas, no_faktur, jumlah_fee, tanggal, jam, status_bayar) VALUES ('$cek[nama_petugas]', '$no_faktur', '$nominal', '$tanggal_sekarang', '$jam_sekarang', '')");

          }

          elseif ($prosentase != 0) {


           
            $fee_prosentase = $prosentase * $total / 100;
            
            $perintah01 = $db->query("INSERT INTO laporan_fee_faktur (nama_petugas, no_faktur, jumlah_fee, tanggal, jam) VALUES ('$cek[nama_petugas]', '$no_faktur', '$fee_prosentase', '$tanggal_sekarang', '$jam_sekarang')");
            
          }

          $perintah00 = $db->query("SELECT * FROM fee_faktur WHERE nama_petugas = '$apoteker'");
          $cek = mysqli_fetch_array($perintah00);
          $nominal = $cek['jumlah_uang'];
          $prosentase = $cek['jumlah_prosentase'];

          if ($nominal != 0) {
            
            $perintah011 = $db->query("INSERT INTO laporan_fee_faktur (nama_petugas, no_faktur, jumlah_fee, tanggal, jam, status_bayar) VALUES ('$cek[nama_petugas]', '$no_faktur', '$nominal', '$tanggal_sekarang', '$jam_sekarang', '')");

          }

          elseif ($prosentase != 0) {


           
            $fee_prosentase = $prosentase * $total / 100;
            
            $perintah011 = $db->query("INSERT INTO laporan_fee_faktur (nama_petugas, no_faktur, jumlah_fee, tanggal, jam) VALUES ('$cek[nama_petugas]', '$no_faktur', '$fee_prosentase', '$tanggal_sekarang', '$jam_sekarang')");
            
          }



          $query3 = $db->query("DELETE  FROM laporan_fee_produk WHERE no_faktur = '$no_faktur' ");

        $query0 = $db->query("SELECT * FROM tbs_fee_produk WHERE no_faktur = '$no_faktur' ");
         while  ($cek0 = mysqli_fetch_array($query0)){



                $query10 = $db->query("INSERT INTO laporan_fee_produk (nama_petugas, no_faktur, kode_produk, nama_produk, jumlah_fee, tanggal, jam,waktu) VALUES ('$cek0[nama_petugas]', '$no_faktur', '$cek0[kode_produk]', '$cek0[nama_produk]', '$cek0[jumlah_fee]', '$tanggal_sekarang', '$jam_sekarang','$waktu')");


          }
      


          $query12 = $db->query("DELETE  FROM detail_penjualan WHERE no_faktur = '$no_faktur' ");

          $query = $db->query("SELECT * FROM tbs_penjualan WHERE no_faktur = '$no_faktur' ");
          while ($data = mysqli_fetch_array($query))
            {

            $pilih_konversi = $db->query("SELECT  sk.konversi * $data[jumlah_barang] AS jumlah_konversi, $data[subtotal] / ($data[jumlah_barang] * sk.konversi) AS harga_konversi, sk.id_satuan, b.satuan FROM satuan_konversi sk INNER JOIN barang b ON sk.id_produk = b.id  WHERE sk.id_satuan = '$data[satuan]' AND sk.kode_produk = '$data[kode_barang]'");
            $data_konversi = mysqli_fetch_array($pilih_konversi);

            if ($data_konversi['harga_konversi'] != 0 || $data_konversi['harga_konversi'] != "") {
              $harga = $data_konversi['harga_konversi'];
              $jumlah_barang = $data_konversi['jumlah_konversi'];
              $satuan = $data_konversi['satuan'];
            }
            else{
              $harga = $data['harga'];
              $jumlah_barang = $data['jumlah_barang'];
              $satuan = $data['satuan'];
            }
              
          
              $query2 = "INSERT INTO detail_penjualan (no_faktur,no_rm, tanggal, jam, kode_barang, nama_barang, jumlah_barang, asal_satuan,satuan, harga, subtotal, potongan, tax, sisa,tipe_produk,waktu) VALUES ('$no_faktur','$no_rm', '$tanggal_sekarang', '$jam_sekarang', '$data[kode_barang]','$data[nama_barang]','$jumlah_barang','$satuan','$data[satuan]','$harga','$data[subtotal]','$data[potongan]','$data[tax]', '$jumlah_barang','$data[tipe_barang]','$waktu')";

              if ($db->query($query2) === TRUE) {
              } 

              else {
              echo "Error: " . $query2 . "<br>" . $db->error;
              }
              
            }



          $sisa = angkadoang($_POST['sisa']);
          $sisa_kredit = angkadoang($_POST['kredit']);
            $pembayaran = angkadoang($_POST['pembayaran']);
                  $total = stringdoang($_POST['total']);
                  $tunai_i = $pembayaran - $total;

                    if ($tunai_i >= 0 ) 

                  {
                    
                   $ket_jurnal = "Penjualan ".$jenis_penjualan." Lunas ".$ambil_kode_pelanggan['nama_pelanggan']." ";
                  // buat prepared statements
                  $stmt = $db->prepare("UPDATE penjualan SET penjamin = ?, apoteker = ?, kode_gudang = ?, total = ?, tanggal = ?, jam = ?, user = ?, sales = ?, status = 'Lunas', potongan = ?,  sisa = ?, cara_bayar = ?, tunai = ?, status_jual_awal = 'Tunai', keterangan = ?, ppn = ?,jenis_penjualan = ?,biaya_admin = ?, petugas_edit = ?, waktu_edit = ?, no_resep = ?, resep_dokter = ?, no_faktur_jurnal = ?, keterangan_jurnal = ? WHERE no_faktur = ?");
                  
                  
                  // hubungkan "data" dengan prepared statements
                  $stmt->bind_param("sssissssiisisssisssssss", 
                  $penjamin,$apoteker, $kode_gudang, $total, $tanggal_sekarang, $jam_sekarang, $id_kasir, $petugas_kasir, $potongan, $sisa, $cara_bayar, $pembayaran, $keterangan, $ppn_input,$jenis_penjualan,$biaya_admin,$petugas_edit,$waktu,$no_resep,$resep_dokter,$no_jurnal,$ket_jurnal,$no_faktur);

                  
                    $pj_total = $total - $potongan;


                    $_SESSION['no_faktur']=$no_faktur;
                    
          // jalankan query
                    $stmt->execute();
                    
                    
          // UPDATE KAS 
                    $stmt1 = $db->prepare("UPDATE kas SET jumlah = jumlah + ? WHERE nama = ?");
                    
                    $stmt1->bind_param("is", 
                    $total, $cara_bayar);
                    
                    // siapkan "data" query
                    
                    $total = angkadoang($_POST['total']);
                    $cara_bayar = stringdoang($_POST['cara_bayar']);
                    
                    // jalankan query
                    $stmt1->execute();


      $select_setting_akun = $db->query("SELECT * FROM setting_akun");
      $ambil_setting = mysqli_fetch_array($select_setting_akun);

      $select = $db->query("SELECT SUM(total_nilai) AS total_hpp FROM hpp_keluar WHERE no_faktur = '$no_faktur'");
      $ambil = mysqli_fetch_array($select);
      $total_hpp = $ambil['total_hpp'];


      $sum_tax_tbs = $db->query("SELECT SUM(tax) AS total_tax FROM tbs_penjualan WHERE no_faktur = '$no_faktur'");
      $jumlah_tax = mysqli_fetch_array($sum_tax_tbs);
      $total_tax = $jumlah_tax['total_tax'];

          $ppn_input = stringdoang($_POST['ppn_input']);
          $select_kode_pelanggan = $db->query("SELECT nama_pelanggan FROM pelanggan WHERE kode_pelanggan = '$no_rm'");
          $ambil_kode_pelanggan = mysqli_fetch_array($select_kode_pelanggan);

/*

      //PERSEDIAAN    
              $insert_jurnal = $db->query("INSERT INTO jurnal_trans (nomor_jurnal,waktu_jurnal,keterangan_jurnal,kode_akun_jurnal,debit,kredit,jenis_transaksi,no_faktur,approved,user_buat) VALUES ('".no_jurnal()."', '$tanggal_sekarang $jam_sekarang', 'Penjualan Apotek Tunai - $ambil_kode_pelanggan[nama_pelanggan]', '$ambil_setting[persediaan]', '0', '$total_hpp', 'Penjualan', '$no_faktur','1', '$user')");
              

      //HPP    
            $insert_jurnal = $db->query("INSERT INTO jurnal_trans (nomor_jurnal,waktu_jurnal,keterangan_jurnal,kode_akun_jurnal,debit,kredit,jenis_transaksi,no_faktur,approved,user_buat) VALUES ('".no_jurnal()."', '$tanggal_sekarang $jam_sekarang', 'Penjualan Apotek Tunai - $ambil_kode_pelanggan[nama_pelanggan]', '$ambil_setting[hpp_penjualan]', '$total_hpp', '0', 'Penjualan', '$no_faktur','1', '$user')");

       //KAS
              $insert_juranl = $db->query("INSERT INTO jurnal_trans (nomor_jurnal,waktu_jurnal,keterangan_jurnal,kode_akun_jurnal,debit,kredit,jenis_transaksi,no_faktur,approved,user_buat) VALUES ('".no_jurnal()."', '$tanggal_sekarang $jam_sekarang', 'Penjualan Apotek Tunai - $ambil_kode_pelanggan[nama_pelanggan]', '$cara_bayar', '$total', '0', 'Penjualan', '$no_faktur','1', '$user')");



      if ($ppn_input == "Non") {

          $total_penjualan = $total2 + $biaya_admin;


        //Total Penjualan
              $insert_juranl = $db->query("INSERT INTO jurnal_trans (nomor_jurnal,waktu_jurnal,keterangan_jurnal,kode_akun_jurnal,debit,kredit,jenis_transaksi,no_faktur,approved,user_buat) VALUES ('".no_jurnal()."', '$tanggal_sekarang $jam_sekarang', 'Penjualan Apotek Tunai - $ambil_kode_pelanggan[nama_pelanggan]', '$ambil_setting[total_penjualan]', '0', '$total_penjualan', 'Penjualan', '$no_faktur','1', '$user')");

      } 


      else if ($ppn_input == "Include") {
      //ppn == Include

        $total_penjualan = ($total2 + $biaya_admin) - $total_tax;
        $pajak = $total_tax;

       //Total Penjualan
              $insert_juranl = $db->query("INSERT INTO jurnal_trans (nomor_jurnal,waktu_jurnal,keterangan_jurnal,kode_akun_jurnal,debit,kredit,jenis_transaksi,no_faktur,approved,user_buat) VALUES ('".no_jurnal()."', '$tanggal_sekarang $jam_sekarang', 'Penjualan Apotek Tunai - $ambil_kode_pelanggan[nama_pelanggan]', '$ambil_setting[total_penjualan]', '0', '$total_penjualan', 'Penjualan', '$no_faktur','1', '$user')");

      if ($pajak != "" || $pajak != 0 ) {
        //PAJAK
              $insert_juranl = $db->query("INSERT INTO jurnal_trans (nomor_jurnal,waktu_jurnal,keterangan_jurnal,kode_akun_jurnal,debit,kredit,jenis_transaksi,no_faktur,approved,user_buat) VALUES ('".no_jurnal()."', '$tanggal_sekarang $jam_sekarang', 'Penjualan Apotek Tunai - $ambil_kode_pelanggan[nama_pelanggan]', '$ambil_setting[pajak_jual]', '0', '$pajak', 'Penjualan', '$no_faktur','1', '$user')");
            }
            

        }

      else {
        //ppn == Exclude
        $total_penjualan = ($total2 - $total_tax) + $biaya_admin;
        $pajak = $total_tax;

       //Total Penjualan
              $insert_juranl = $db->query("INSERT INTO jurnal_trans (nomor_jurnal,waktu_jurnal,keterangan_jurnal,kode_akun_jurnal,debit,kredit,jenis_transaksi,no_faktur,approved,user_buat) VALUES ('".no_jurnal()."', '$tanggal_sekarang $jam_sekarang', 'Penjualan Apotek Tunai - $ambil_kode_pelanggan[nama_pelanggan]', '$ambil_setting[total_penjualan]', '0', '$total_penjualan', 'Penjualan', '$no_faktur','1', '$user')");


      if ($pajak != "" || $pajak != 0) {
      //PAJAK
              $insert_juranl = $db->query("INSERT INTO jurnal_trans (nomor_jurnal,waktu_jurnal,keterangan_jurnal,kode_akun_jurnal,debit,kredit,jenis_transaksi,no_faktur,approved,user_buat) VALUES ('".no_jurnal()."', '$tanggal_sekarang $jam_sekarang', 'Penjualan Apotek Tunai - $ambil_kode_pelanggan[nama_pelanggan]', '$ambil_setting[pajak_jual]', '0', '$pajak', 'Penjualan', '$no_faktur','1', '$user')");
      }

      }


      if ($potongan != "" || $potongan != 0 ) {
      //POTONGAN
              $insert_juranl = $db->query("INSERT INTO jurnal_trans (nomor_jurnal,waktu_jurnal,keterangan_jurnal,kode_akun_jurnal,debit,kredit,jenis_transaksi,no_faktur,approved,user_buat) VALUES ('".no_jurnal()."', '$tanggal_sekarang $jam_sekarang', 'Penjualan Apotek Tunai - $ambil_kode_pelanggan[nama_pelanggan]', '$ambil_setting[potongan_jual]', '$potongan', '0', 'Penjualan', '$no_faktur','1', '$user')");
      }

   */               
                    
       }
                    



                    else if ($tunai_i != 0)
                    
                  {

                $ket_jurnal = "Penjualan ".$jenis_penjualan." Piutang ".$ambil_kode_pelanggan['nama_pelanggan']." ";

                    $stmt2 = $db->prepare("UPDATE penjualan SET penjamin = ?, apoteker = ?, kode_gudang = ?,total = ?, tanggal = ?, jam = ?,  user = ?, sales = ?, status = 'Piutang', potongan = ?, kredit = ?, cara_bayar = ?, tunai = ?, status_jual_awal = 'Kredit', keterangan = ?, ppn = ?,jenis_penjualan = ?,tanggal_jt = ?,biaya_admin = ?, petugas_edit = ?, waktu_edit = ?, no_resep = ?, resep_dokter = ?, no_faktur_jurnal = ?, keterangan_jurnal = ?  WHERE no_faktur = ?");

                  
                  
                  // hubungkan "data" dengan prepared statements
                  $stmt2->bind_param("sssissssiisissssisssssss", 
                  $penjamin,$apoteker, $kode_gudang, $total, $tanggal_sekarang, $jam_sekarang, $id_kasir, $petugas_kasir, $potongan, $sisa_kredit, $cara_bayar, $pembayaran, $keterangan, $ppn_input,$jenis_penjualan,$tanggal_jt,$biaya_admin,$petugas_edit,$waktu,$no_resep,$resep_dokter,$no_jurnal,$ket_jurnal,$no_faktur);

                  

                    $pj_total = $total - $potongan;

                    $_SESSION['no_faktur']=$no_faktur;
                    
                    // jalankan query
                    $stmt2->execute();

                        // cek query
      if (!$stmt2) 
            {
              die('Query Error : '.$db->errno.
                ' - '.$db->error);
            }

      else 
            {
          
            }
                    
                    
                    
      $select_setting_akun = $db->query("SELECT * FROM setting_akun");
      $ambil_setting = mysqli_fetch_array($select_setting_akun);

      $select = $db->query("SELECT SUM(total_nilai) AS total_hpp FROM hpp_keluar WHERE no_faktur = '$no_faktur'");
      $ambil = mysqli_fetch_array($select);

      $total_hpp = $ambil['total_hpp'];


      $sum_tax_tbs = $db->query("SELECT SUM(tax) AS total_tax FROM tbs_penjualan WHERE no_faktur = '$no_faktur'");
      $jumlah_tax = mysqli_fetch_array($sum_tax_tbs);
      $total_tax = $jumlah_tax['total_tax'];

          $ppn_input = stringdoang($_POST['ppn_input']);
          $select_kode_pelanggan = $db->query("SELECT nama_pelanggan FROM pelanggan WHERE kode_pelanggan = '$no_rm'");
          $ambil_kode_pelanggan = mysqli_fetch_array($select_kode_pelanggan);


                  $piutang_1 = $total - $pembayaran;
/*

      //PERSEDIAAN    
              $insert_jurnal = $db->query("INSERT INTO jurnal_trans (nomor_jurnal,waktu_jurnal,keterangan_jurnal,kode_akun_jurnal,debit,kredit,jenis_transaksi,no_faktur,approved,user_buat) VALUES ('".no_jurnal()."', '$tanggal_sekarang $jam_sekarang', 'Penjualan Apotek Piutang - $ambil_kode_pelanggan[nama_pelanggan]', '$ambil_setting[persediaan]', '0', '$total_hpp', 'Penjualan', '$no_faktur','1', '$user')");
              

      //HPP    
            $insert_jurnal = $db->query("INSERT INTO jurnal_trans (nomor_jurnal,waktu_jurnal,keterangan_jurnal,kode_akun_jurnal,debit,kredit,jenis_transaksi,no_faktur,approved,user_buat) VALUES ('".no_jurnal()."', '$tanggal_sekarang $jam_sekarang', 'Penjualan Apotek Piutang - $ambil_kode_pelanggan[nama_pelanggan]', '$ambil_setting[hpp_penjualan]', '$total_hpp', '0', 'Penjualan', '$no_faktur','1', '$user')");

       //KAS
              $insert_juranl = $db->query("INSERT INTO jurnal_trans (nomor_jurnal,waktu_jurnal,keterangan_jurnal,kode_akun_jurnal,debit,kredit,jenis_transaksi,no_faktur,approved,user_buat) VALUES ('".no_jurnal()."', '$tanggal_sekarang $jam_sekarang', 'Penjualan Apotek Piutang - $ambil_kode_pelanggan[nama_pelanggan]', '$cara_bayar', '$pembayaran', '0', 'Penjualan', '$no_faktur','1', '$user')");

       //PIUTANG
              $insert_juranl = $db->query("INSERT INTO jurnal_trans (nomor_jurnal,waktu_jurnal,keterangan_jurnal,kode_akun_jurnal,debit,kredit,jenis_transaksi,no_faktur,approved,user_buat) VALUES ('".no_jurnal()."', '$tanggal_sekarang $jam_sekarang', 'Penjualan Apotek Piutang - $ambil_kode_pelanggan[nama_pelanggan]', '$ambil_setting[pembayaran_kredit]', '$piutang_1', '0', 'Penjualan', '$no_faktur','1', '$user')");


      if ($ppn_input == "Non") {
      // ppn == NON
          $total_penjualan = $total2 + $biaya_admin;

       $ppn_input;
        //Total Penjualan
              $insert_juranl = $db->query("INSERT INTO jurnal_trans (nomor_jurnal,waktu_jurnal,keterangan_jurnal,kode_akun_jurnal,debit,kredit,jenis_transaksi,no_faktur,approved,user_buat) VALUES ('".no_jurnal()."', '$tanggal_sekarang $jam_sekarang', 'Penjualan Apotek Piutang - $ambil_kode_pelanggan[nama_pelanggan]', '$ambil_setting[total_penjualan]', '0', '$total_penjualan', 'Penjualan', '$no_faktur','1', '$user')");

      } 


      else if ($ppn_input == "Include") {
      //ppn == Include
      $ppn_input;
        $total_penjualan = ($total2 + $biaya_admin) - $total_tax;
        $pajak = $total_tax;

       //Total Penjualan
              $insert_juranl = $db->query("INSERT INTO jurnal_trans (nomor_jurnal,waktu_jurnal,keterangan_jurnal,kode_akun_jurnal,debit,kredit,jenis_transaksi,no_faktur,approved,user_buat) VALUES ('".no_jurnal()."', '$tanggal_sekarang $jam_sekarang', 'Penjualan Apotek Piutang - $ambil_kode_pelanggan[nama_pelanggan]', '$ambil_setting[total_penjualan]', '0', '$total_penjualan', 'Penjualan', '$no_faktur','1', '$user')");

      if ($pajak != "" || $pajak != 0) {
        //PAJAK
              $insert_juranl = $db->query("INSERT INTO jurnal_trans (nomor_jurnal,waktu_jurnal,keterangan_jurnal,kode_akun_jurnal,debit,kredit,jenis_transaksi,no_faktur,approved,user_buat) VALUES ('".no_jurnal()."', '$tanggal_sekarang $jam_sekarang', 'Penjualan Apotek Piutang - $ambil_kode_pelanggan[nama_pelanggan]', '$ambil_setting[pajak_jual]', '0', '$pajak', 'Penjualan', '$no_faktur','1', '$user')");
      }


        }

      else {

        //ppn == Exclude
        $total_penjualan = ($total2 - $total_tax) + $biaya_admin;
        $pajak = $total_tax;
      $ppn_input;
       //Total Penjualan
              $insert_juranl = $db->query("INSERT INTO jurnal_trans (nomor_jurnal,waktu_jurnal,keterangan_jurnal,kode_akun_jurnal,debit,kredit,jenis_transaksi,no_faktur,approved,user_buat) VALUES ('".no_jurnal()."', '$tanggal_sekarang $jam_sekarang', 'Penjualan Apotek Piutang - $ambil_kode_pelanggan[nama_pelanggan]', '$ambil_setting[total_penjualan]', '0', '$total_penjualan', 'Penjualan', '$no_faktur','1', '$user')");


      if ($pajak != "" || $pajak != 0) {
      //PAJAK
              $insert_juranl = $db->query("INSERT INTO jurnal_trans (nomor_jurnal,waktu_jurnal,keterangan_jurnal,kode_akun_jurnal,debit,kredit,jenis_transaksi,no_faktur,approved,user_buat) VALUES ('".no_jurnal()."', '$tanggal_sekarang $jam_sekarang', 'Penjualan Apotek Piutang - $ambil_kode_pelanggan[nama_pelanggan]', '$ambil_setting[pajak_jual]', '0', '$pajak', 'Penjualan', '$no_faktur','1', '$user')");
      }

      }


      if ($potongan != "" || $potongan != 0 ) {
      //POTONGAN
              $insert_juranl = $db->query("INSERT INTO jurnal_trans (nomor_jurnal,waktu_jurnal,keterangan_jurnal,kode_akun_jurnal,debit,kredit,jenis_transaksi,no_faktur,approved,user_buat) VALUES ('".no_jurnal()."', '$tanggal_sekarang $jam_sekarang', 'Penjualan Apotek Piutang - $ambil_kode_pelanggan[nama_pelanggan]', '$ambil_setting[potongan_jual]', '$potongan', '0', 'Penjualan', '$no_faktur','1', '$user')");
      }

*/
         
      }




      // BOT STAR AUTO      

                    $total = angkadoang($_POST['total']);
      /*
                          
            $url = "https://api.telegram.org/bot233675698:AAEbTKDcPH446F-bje4XIf1YJ0kcmoUGffA/sendMessage?chat_id=-129639785&text=";
            $text = urlencode("No Faktur : ".$no_faktur."\n");
            $pesanan_jadi = "";
            $ambil_tbs1 = $db->query("SELECT * FROM tbs_penjualan WHERE session_id = '$session_id' ORDER BY id ASC");
            
       while ($data12 = mysqli_fetch_array($ambil_tbs1))

       {
                  $pesanan =  $data12['nama_barang']." - ".$data12['jumlah_barang']." - ".$data12['harga']."\n";
            $pesanan_jadi = $pesanan_jadi.$pesanan;
            
            $ambil_tbs2 = $db->query("SELECT kode_barang FROM tbs_penjualan WHERE session_id = '$session_id' ORDER BY id DESC Limit 1");
            $ambil_tbs3 = mysqli_fetch_array($ambil_tbs2);
            $data_terakhir = $ambil_tbs3['kode_barang'];
            
            if ($data12['kode_barang'] == $data_terakhir ) 
            {
            $pesanan_jadi = $pesanan_jadi."Subtotal : ".$total;
            $pesanan_terakhir =  urlencode($pesanan_jadi);
            $url = $url.$text.$pesanan_terakhir;
            
            $url = str_replace(" ", "%20", $url);
            

            
            }


           
           
      }
      */

          $query3 = $db->query("DELETE  FROM tbs_penjualan WHERE no_faktur = '$no_faktur' ");
          $query30 = $db->query("DELETE  FROM tbs_fee_produk WHERE no_faktur = '$no_faktur'");


}

    // If we arrive here, it means that no exception was thrown
    // i.e. no query has failed, and we can commit the transaction
    $db->commit();
} catch (Exception $e) {
    // An exception has been thrown
    // We must rollback the transaction
    $db->rollback();
}

//Untuk Memutuskan Koneksi Ke Database
mysqli_close($db);   
    
    ?>


