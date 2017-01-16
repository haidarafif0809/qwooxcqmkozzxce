<?php
include 'db.php';
include_once 'sanitasi.php';


$mulai = $_GET['mulai'];

//Mengambil data penjualan berdasarkan trtansaksi yang sudah '#LUNAS'
$pilih_penjualan_tunai = $db->query("SELECT ppn, biaya_admin, user, tanggal, jam, cara_bayar, potongan, status, kredit, total, no_faktur, no_reg, kode_pelanggan FROM penjualan WHERE tanggal >= '2017-01-01' LIMIT $mulai,2");
while ($data_penj = mysqli_fetch_array($pilih_penjualan_tunai)) { //START while ($data_penj) {



  $no_faktur = $data_penj['no_faktur'];
  $ppn_input = $data_penj['ppn'];
  $biaya_admin = $data_penj['biaya_admin'];
  $nama_petugas = $data_penj['user'];
  $tanggal_sekarang = $data_penj['tanggal'];
  $jam_sekarang = $data_penj['jam'];
  $cara_bayar = $data_penj['cara_bayar'];
  $potongan = $data_penj['potongan'];
  $status = $data_penj['status'];
  $kredit = $data_penj['kredit'];
  $total = $data_penj['total'];
  $nilai_pembayaran = $total - $kredit;

  if ($nilai_pembayaran <= 0) {
      $pembayaran = 0;
  }
  else{
    $pembayaran = $nilai_pembayaran;
  }


    $select_setting_akun = $db->query("SELECT persediaan, hpp_penjualan, pembayaran_kredit, total_penjualan, pajak_jual, potongan_jual FROM setting_akun");
    $ambil_setting = mysqli_fetch_array($select_setting_akun);


    $select = $db->query("SELECT SUM(total_nilai) AS total_hpp FROM hpp_keluar WHERE no_faktur = '$data_penj[no_faktur]'");
    $ambil = mysqli_fetch_array($select);
    $total_hpp = $ambil['total_hpp'];

    $sum_tax_tbs = $db->query("SELECT SUM(tax) AS total_tax, SUM(subtotal) AS sub_total FROM detail_penjualan WHERE no_faktur = '$data_penj[no_faktur]' ");
    $jumlah_tax = mysqli_fetch_array($sum_tax_tbs);
    $total_tax = $jumlah_tax['total_tax'];
    $total2 = $jumlah_tax['sub_total'];

    $select_kode_pelanggan = $db_pasien->query("SELECT nama_pelanggan FROM pelanggan WHERE kode_pelanggan = '$data_penj[kode_pelanggan]'");
    $ambil_kode_pelanggan = mysqli_fetch_array($select_kode_pelanggan);

    $jenis_penjualan = $db->query("SELECT jenis_penjualan FROM penjualan WHERE no_faktur = '$data_penj[no_faktur]'");
    $data_jenis_penj = mysqli_fetch_array($jenis_penjualan);
    $keterangan_jurnal = $data_jenis_penj['jenis_penjualan'];

// START INSERT JURNAL PENJUALAN TUNAI // START INSERT JURNAL PENJUALAN TUNAI // START INSERT JURNAL PENJUALAN TUNAI 
    $status = $pembayaran - $total;

    if ($status >= 0) { // START if ($status == 'Lunas') {      
    echo "LUNAS"; echo "<br>";

          //PERSEDIAAN    
                  $insert_jurnal = $db->query("INSERT INTO jurnal_trans (nomor_jurnal,waktu_jurnal,keterangan_jurnal,kode_akun_jurnal,debit,kredit,jenis_transaksi,no_faktur,approved,user_buat) VALUES ('".no_jurnal()."', '$tanggal_sekarang $jam_sekarang', 'Penjualan ".$keterangan_jurnal." Tunai - $ambil_kode_pelanggan[nama_pelanggan]', '$ambil_setting[persediaan]', '0', '$total_hpp', 'Penjualan', '$no_faktur','1', '$nama_petugas')");
                  

          //HPP    
                $insert_jurnal = $db->query("INSERT INTO jurnal_trans (nomor_jurnal,waktu_jurnal,keterangan_jurnal,kode_akun_jurnal,debit,kredit,jenis_transaksi,no_faktur,approved,user_buat) VALUES ('".no_jurnal()."', '$tanggal_sekarang $jam_sekarang', 'Penjualan ".$keterangan_jurnal." Tunai - $ambil_kode_pelanggan[nama_pelanggan]', '$ambil_setting[hpp_penjualan]', '$total_hpp', '0', 'Penjualan', '$no_faktur','1', '$nama_petugas')");

           //KAS
                  $insert_juranl = $db->query("INSERT INTO jurnal_trans (nomor_jurnal,waktu_jurnal,keterangan_jurnal,kode_akun_jurnal,debit,kredit,jenis_transaksi,no_faktur,approved,user_buat) VALUES ('".no_jurnal()."', '$tanggal_sekarang $jam_sekarang', 'Penjualan ".$keterangan_jurnal." Tunai - $ambil_kode_pelanggan[nama_pelanggan]', '$cara_bayar', '$total', '0', 'Penjualan', '$no_faktur','1', '$nama_petugas')");



          if ($ppn_input == "Non") {

              $total_penjualan = $total2 + $biaya_admin;


            //Total Penjualan
                  $insert_juranl = $db->query("INSERT INTO jurnal_trans (nomor_jurnal,waktu_jurnal,keterangan_jurnal,kode_akun_jurnal,debit,kredit,jenis_transaksi,no_faktur,approved,user_buat) VALUES ('".no_jurnal()."', '$tanggal_sekarang $jam_sekarang', 'Penjualan ".$keterangan_jurnal." Tunai - $ambil_kode_pelanggan[nama_pelanggan]', '$ambil_setting[total_penjualan]', '0', '$total_penjualan', 'Penjualan', '$no_faktur','1', '$nama_petugas')");

          } 


          else if ($ppn_input == "Include") {
          //ppn == Include

            $total_penjualan = ($total2 + $biaya_admin) - $total_tax;
            $pajak = $total_tax;

           //Total Penjualan
                  $insert_juranl = $db->query("INSERT INTO jurnal_trans (nomor_jurnal,waktu_jurnal,keterangan_jurnal,kode_akun_jurnal,debit,kredit,jenis_transaksi,no_faktur,approved,user_buat) VALUES ('".no_jurnal()."', '$tanggal_sekarang $jam_sekarang', 'Penjualan ".$keterangan_jurnal." Tunai - $ambil_kode_pelanggan[nama_pelanggan]', '$ambil_setting[total_penjualan]', '0', '$total_penjualan', 'Penjualan', '$no_faktur','1', '$nama_petugas')");

          if ($pajak != "" || $pajak != 0 ) {
            //PAJAK
                  $insert_juranl = $db->query("INSERT INTO jurnal_trans (nomor_jurnal,waktu_jurnal,keterangan_jurnal,kode_akun_jurnal,debit,kredit,jenis_transaksi,no_faktur,approved,user_buat) VALUES ('".no_jurnal()."', '$tanggal_sekarang $jam_sekarang', 'Penjualan ".$keterangan_jurnal." Tunai - $ambil_kode_pelanggan[nama_pelanggan]', '$ambil_setting[pajak_jual]', '0', '$pajak', 'Penjualan', '$no_faktur','1', '$nama_petugas')");
                }
                

            }

          else {
            //ppn == Exclude
            $total_penjualan = ($total2 - $total_tax) + $biaya_admin;
            $pajak = $total_tax;

           //Total Penjualan
                  $insert_juranl = $db->query("INSERT INTO jurnal_trans (nomor_jurnal,waktu_jurnal,keterangan_jurnal,kode_akun_jurnal,debit,kredit,jenis_transaksi,no_faktur,approved,user_buat) VALUES ('".no_jurnal()."', '$tanggal_sekarang $jam_sekarang', 'Penjualan ".$keterangan_jurnal." Tunai - $ambil_kode_pelanggan[nama_pelanggan]', '$ambil_setting[total_penjualan]', '0', '$total_penjualan', 'Penjualan', '$no_faktur','1', '$nama_petugas')");


          if ($pajak != "" || $pajak != 0) {
          //PAJAK
                  $insert_juranl = $db->query("INSERT INTO jurnal_trans (nomor_jurnal,waktu_jurnal,keterangan_jurnal,kode_akun_jurnal,debit,kredit,jenis_transaksi,no_faktur,approved,user_buat) VALUES ('".no_jurnal()."', '$tanggal_sekarang $jam_sekarang', 'Penjualan ".$keterangan_jurnal." Tunai - $ambil_kode_pelanggan[nama_pelanggan]', '$ambil_setting[pajak_jual]', '0', '$pajak', 'Penjualan', '$no_faktur','1', '$nama_petugas')");
          }

          }


          if ($potongan != "" || $potongan != 0 ) {
          //POTONGAN
                  $insert_juranl = $db->query("INSERT INTO jurnal_trans (nomor_jurnal,waktu_jurnal,keterangan_jurnal,kode_akun_jurnal,debit,kredit,jenis_transaksi,no_faktur,approved,user_buat) VALUES ('".no_jurnal()."', '$tanggal_sekarang $jam_sekarang', 'Penjualan ".$keterangan_jurnal." Tunai - $ambil_kode_pelanggan[nama_pelanggan]', '$ambil_setting[potongan_jual]', '$potongan', '0', 'Penjualan', '$no_faktur','1', '$nama_petugas')");
          }


    } // END if ($status == 'Lunas') {

// END INSERT JURNAL PENJUALAN TUNAI // END INSERT JURNAL PENJUALAN TUNAI // END INSERT JURNAL PENJUALAN TUNAI 


// START INSERT JURNAL PENJUALAN PIUTANG // START INSERT JURNAL PENJUALAN PIUTANG // START INSERT JURNAL PENJUALAN PIUTANG 

    else if ($status < 0) { // Start else piutang

echo "PIUTANG"; echo "<br>";
          //PERSEDIAAN    
                  $insert_jurnal = $db->query("INSERT INTO jurnal_trans (nomor_jurnal,waktu_jurnal,keterangan_jurnal,kode_akun_jurnal,debit,kredit,jenis_transaksi,no_faktur,approved,user_buat) VALUES ('".no_jurnal()."', '$tanggal_sekarang $jam_sekarang', 'Penjualan ".$keterangan_jurnal." Piutang - $ambil_kode_pelanggan[nama_pelanggan]', '$ambil_setting[persediaan]', '0', '$total_hpp', 'Penjualan', '$no_faktur','1', '$nama_petugas')");
                  

          //HPP    
                $insert_jurnal = $db->query("INSERT INTO jurnal_trans (nomor_jurnal,waktu_jurnal,keterangan_jurnal,kode_akun_jurnal,debit,kredit,jenis_transaksi,no_faktur,approved,user_buat) VALUES ('".no_jurnal()."', '$tanggal_sekarang $jam_sekarang', 'Penjualan ".$keterangan_jurnal." Piutang - $ambil_kode_pelanggan[nama_pelanggan]', '$ambil_setting[hpp_penjualan]', '$total_hpp', '0', 'Penjualan', '$no_faktur','1', '$nama_petugas')");

           //KAS
                  $insert_juranl = $db->query("INSERT INTO jurnal_trans (nomor_jurnal,waktu_jurnal,keterangan_jurnal,kode_akun_jurnal,debit,kredit,jenis_transaksi,no_faktur,approved,user_buat) VALUES ('".no_jurnal()."', '$tanggal_sekarang $jam_sekarang', 'Penjualan ".$keterangan_jurnal." Piutang - $ambil_kode_pelanggan[nama_pelanggan]', '$cara_bayar', '$pembayaran', '0', 'Penjualan', '$no_faktur','1', '$nama_petugas')");

           //PIUTANG
                  $insert_juranl = $db->query("INSERT INTO jurnal_trans (nomor_jurnal,waktu_jurnal,keterangan_jurnal,kode_akun_jurnal,debit,kredit,jenis_transaksi,no_faktur,approved,user_buat) VALUES ('".no_jurnal()."', '$tanggal_sekarang $jam_sekarang', 'Penjualan ".$keterangan_jurnal." Piutang - $ambil_kode_pelanggan[nama_pelanggan]', '$ambil_setting[pembayaran_kredit]', '$kredit', '0', 'Penjualan', '$no_faktur','1', '$nama_petugas')");


          if ($ppn_input == "Non") {

              $total_penjualan = $total2 + $biaya_admin;

           $ppn_input;
            //Total Penjualan
                  $insert_juranl = $db->query("INSERT INTO jurnal_trans (nomor_jurnal,waktu_jurnal,keterangan_jurnal,kode_akun_jurnal,debit,kredit,jenis_transaksi,no_faktur,approved,user_buat) VALUES ('".no_jurnal()."', '$tanggal_sekarang $jam_sekarang', 'Penjualan ".$keterangan_jurnal." Piutang - $ambil_kode_pelanggan[nama_pelanggan]', '$ambil_setting[total_penjualan]', '0', '$total_penjualan', 'Penjualan', '$no_faktur','1', '$nama_petugas')");

          } 


          else if ($ppn_input == "Include") {
          //ppn == Include
          $ppn_input;
            $total_penjualan = ($total2 + $biaya_admin) - $total_tax;
            $pajak = $total_tax;

           //Total Penjualan
                  $insert_juranl = $db->query("INSERT INTO jurnal_trans (nomor_jurnal,waktu_jurnal,keterangan_jurnal,kode_akun_jurnal,debit,kredit,jenis_transaksi,no_faktur,approved,user_buat) VALUES ('".no_jurnal()."', '$tanggal_sekarang $jam_sekarang', 'Penjualan ".$keterangan_jurnal." Piutang - $ambil_kode_pelanggan[nama_pelanggan]', '$ambil_setting[total_penjualan]', '0', '$total_penjualan', 'Penjualan', '$no_faktur','1', '$nama_petugas')");

          if ($pajak != "" || $pajak != 0) {
            //PAJAK
                  $insert_juranl = $db->query("INSERT INTO jurnal_trans (nomor_jurnal,waktu_jurnal,keterangan_jurnal,kode_akun_jurnal,debit,kredit,jenis_transaksi,no_faktur,approved,user_buat) VALUES ('".no_jurnal()."', '$tanggal_sekarang $jam_sekarang', 'Penjualan ".$keterangan_jurnal." Piutang - $ambil_kode_pelanggan[nama_pelanggan]', '$ambil_setting[pajak_jual]', '0', '$pajak', 'Penjualan', '$no_faktur','1', '$nama_petugas')");
            }


            }

          else {
            //ppn == Exclude
            $total_penjualan = ($total2 - $total_tax) + $biaya_admin;
            $pajak = $total_tax;
          $ppn_input;
           //Total Penjualan
                  $insert_juranl = $db->query("INSERT INTO jurnal_trans (nomor_jurnal,waktu_jurnal,keterangan_jurnal,kode_akun_jurnal,debit,kredit,jenis_transaksi,no_faktur,approved,user_buat) VALUES ('".no_jurnal()."', '$tanggal_sekarang $jam_sekarang', 'Penjualan ".$keterangan_jurnal." Piutang - $ambil_kode_pelanggan[nama_pelanggan]', '$ambil_setting[total_penjualan]', '0', '$total_penjualan', 'Penjualan', '$no_faktur','1', '$nama_petugas')");


          if ($pajak != "" || $pajak != 0) {
          //PAJAK
                  $insert_juranl = $db->query("INSERT INTO jurnal_trans (nomor_jurnal,waktu_jurnal,keterangan_jurnal,kode_akun_jurnal,debit,kredit,jenis_transaksi,no_faktur,approved,user_buat) VALUES ('".no_jurnal()."', '$tanggal_sekarang $jam_sekarang', 'Penjualan ".$keterangan_jurnal." Piutang - $ambil_kode_pelanggan[nama_pelanggan]', '$ambil_setting[pajak_jual]', '0', '$pajak', 'Penjualan', '$no_faktur','1', '$nama_petugas')");
          }

          }


          if ($potongan != "" || $potongan != 0 ) {
          //POTONGAN
                  $insert_juranl = $db->query("INSERT INTO jurnal_trans (nomor_jurnal,waktu_jurnal,keterangan_jurnal,kode_akun_jurnal,debit,kredit,jenis_transaksi,no_faktur,approved,user_buat) VALUES ('".no_jurnal()."', '$tanggal_sekarang $jam_sekarang', 'Penjualan ".$keterangan_jurnal." Piutang - $ambil_kode_pelanggan[nama_pelanggan]', '$ambil_setting[potongan_jual]', '$potongan', '0', 'Penjualan', '$no_faktur','1', '$nama_petugas')");
          }

    }// end else piutang



} //END while ($data_penj) {

?>