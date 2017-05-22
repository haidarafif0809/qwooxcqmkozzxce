<?php include 'session_login.php';
include 'db.php';
include_once 'sanitasi.php';

$tahun_sekarang = date('Y');
$bulan_sekarang = date('m');
$tanggal_sekarang = date('Y-m-d');
$jam_sekarang = date('H:i:s');
$tahun_terakhir = substr($tahun_sekarang, 2);

try {

  $no_reg = stringdoang($_POST['no_reg']);
  $biaya_admin = angkadoang($_POST['biaya_adm']);
  $diskon_rupiah = angkadoang($_POST['diskon_rupiah']);
  $total = angkadoang($_POST['total']);

// menampilakn hasil penjumlah subtotal ALIAS total penjualan dari tabel tbs_penjualan berdasarkan data no faktur
  $query_jumlah_harga = $db->query("SELECT SUM(harga) AS total_harga FROM tbs_aps_penjualan WHERE  no_reg = '$no_reg'");
  $data_jumlah_harga = mysqli_fetch_array($query_jumlah_harga);
  $total_harga_tbs = $data_jumlah_harga['total_harga'];


  $total_tbs = ($total_harga_tbs - $diskon_rupiah) + $biaya_admin;

  if ($total != $total_tbs) { 
    echo 1;
  }
  else{
      $db->begin_transaction(); //First of all, let's begin a transaction
      $cek_jumlah_bulan = strlen($bulan_sekarang);//mengecek jumlah karakter dari bulan sekarang

      //jika jumlah karakter dari bulannya sama dengan 1 maka di tambah 0 di depannya
      if ($cek_jumlah_bulan == 1) {
        $data_bulan_terakhir = "0".$bulan_sekarang;
      }
      else{
        $data_bulan_terakhir = $bulan_sekarang;
      }
      //ambil bulan dari tanggal penjualan terakhir

      $bulan_terakhir = $db->query("SELECT MONTH(waktu_input) as bulan FROM penjualan ORDER BY id DESC LIMIT 1");
      $v_bulan_terakhir = mysqli_fetch_array($bulan_terakhir);

      //ambil nomor  dari penjualan terakhir
      $no_terakhir = $db->query("SELECT no_faktur FROM penjualan ORDER BY id DESC LIMIT 1");
      $v_no_terakhir = mysqli_fetch_array($no_terakhir);
      $ambil_nomor = substr($v_no_terakhir['no_faktur'],0,-8);

      /*jika bulan terakhir dari penjualan tidak sama dengan bulan sekarang, 
      maka nomor nya kembali mulai dari 1 ,
      jika tidak maka nomor terakhir ditambah dengan 1*/

      if ($v_bulan_terakhir['bulan'] != $bulan_sekarang) {
      echo $no_faktur = "1/JL/".$data_bulan_terakhir."/".$tahun_terakhir;
      }
      else{
        $nomor = 1 + $ambil_nomor ;
        echo $no_faktur = $nomor."/JL/".$data_bulan_terakhir."/".$tahun_terakhir;
      }

      

    $session_id = session_id();


    $id_user = stringdoang($_POST['id_user']);
    $no_reg = stringdoang($_POST['no_reg']);
    $no_rm = stringdoang($_POST['no_rm']);
    $biaya_admin = stringdoang($_POST['biaya_adm']);
    $diskon_rupiah = stringdoang($_POST['diskon_rupiah']);
    $cara_bayar = angkadoang($_POST['cara_bayar']);
    $subtotal = angkadoang($_POST['subtotal']);
    $total = angkadoang($_POST['total']);
    $pembayaran_penjualan = angkadoang($_POST['pembayaran_penjualan']);
    $sisa = angkadoang($_POST['sisa_pembayaran']);
    $tanggal_jt = stringdoang($_POST['tanggal_jt']);
    $keterangan = stringdoang($_POST['keterangan']);
    $petugas_kasir = stringdoang($_POST['petugas_kasir']);
    $nama_pasien = stringdoang($_POST['nama_pasien']);
    $jenis_penjualan = "APS";
    $no_jurnal = no_jurnal();

    $query_pelanggan = $db_pasien->query("SELECT nama_pelanggan FROM pelanggan WHERE kode_pelanggan = '$no_rm'");
    $data_pelanggan = mysqli_fetch_array($query_pelanggan);    



    //INSERT DARI TBS FEE KE LAPORAN FEE PRODUK
            $insert_lap_fee_produk = "INSERT INTO laporan_fee_produk (nama_petugas,no_faktur, kode_produk,nama_produk,
            jumlah_fee, tanggal, jam, no_rm, no_reg) SELECT nama_petugas, '$no_faktur', kode_produk, nama_produk, jumlah_fee, tanggal, jam, no_rm, no_reg FROM tbs_fee_produk WHERE no_reg = '$no_reg'";

              if ($db->query($insert_lap_fee_produk) === TRUE) {
              
              }
              else{
                  echo "Error: " . $insert_lap_fee_produk . "<br>" . $db->error;
              }
    //INSERT DARI TBS FEE KE LAPORAN FEE PRODUK
    
    $query_hapus_detail = $db->query("DELETE FROM detail_penjualan WHERE no_faktur = '$no_faktur' ");

    //INSERT DARI TBS APS KE DETAIL PENJUALAN
            $insert_detail_penjualan = "INSERT INTO detail_penjualan (no_faktur,no_rm, no_reg,kode_barang,
            nama_barang, jumlah_barang, harga, subtotal, sisa,tipe_produk,tanggal, jam) SELECT '$no_faktur',
            '$no_rm',no_reg, kode_jasa, nama_jasa, '1', harga, harga, '1', 'Jasa', tanggal, jam FROM
            tbs_aps_penjualan WHERE no_reg = '$no_reg' AND no_faktur IS NULL";

              if ($db->query($insert_detail_penjualan) === TRUE) {
              
              }
              else{
                  echo "Error: " . $insert_detail_penjualan . "<br>" . $db->error;
              }
    //INSERT DARI TBS APS KE DETAIL PENJUALAN

//INSERT DARI TBS PENJUALAN RADIOLOGI KE HASIL PEMERIKSAAN RADIOLOGI
      $insert_hasil_radiologi = "INSERT INTO hasil_pemeriksaan_radiologi (no_faktur, no_reg, kode_barang, nama_barang, jumlah_barang, harga, subtotal, potongan, tax, foto, tipe_barang, tanggal, jam, radiologi, kontras, dokter_pengirim, dokter_pelaksana, dokter_periksa, status_periksa, status_simpan, keterangan) SELECT '$no_faktur', no_reg, kode_barang, nama_barang, jumlah_barang, harga, subtotal, potongan, tax, foto, tipe_barang, tanggal, jam, radiologi, kontras, dokter_pengirim, dokter_pelaksana, dokter_periksa, status_periksa, status_simpan, keterangan FROM tbs_penjualan_radiologi WHERE no_reg = '$no_reg' ";

        if ($db->query($insert_hasil_radiologi) === TRUE) {
          
        }
        else{
          echo "Error: " . $insert_hasil_radiologi . "<br>" . $db->error;
        }

//INSERT DARI TBS PENJUALAN RADIOLOGI KE HASIL PEMERIKSAAN RADIOLOGI

    // START INSERT KE HASIL LABORATORIUM
    // update no_faktur di hasil_lab and insert ke hasil lab
    $cek_lab = $db->query("SELECT no_reg FROM hasil_lab WHERE no_reg = '$no_reg'");
    $out_lab = mysqli_num_rows($cek_lab);
    if($out_lab > 0 ){

      $update_hasilnya = $db->query("UPDATE hasil_lab SET no_faktur = '$no_faktur' WHERE no_reg = '$no_reg'");

      $query_update_pemeriksaan = $db->query("UPDATE pemeriksaan_laboratorium SET no_faktur = '$no_faktur', status = '1' WHERE no_reg = '$no_reg'");

      $query_hapus_tbs_aps = $db->query("DELETE FROM tbs_aps_penjualan WHERE no_reg = '$no_reg' ");

        
    }
    else{
        // Cek dulu setting, jika tidak di hubungkan akan jalankan ini
        $cek_setting = $db->query("SELECT nama FROM setting_laboratorium");
        $get = mysqli_fetch_array($cek_setting);
        $hasil = $get['nama'];

        if($hasil == 0){


        $query_update_pemeriksaan = $db->query("UPDATE pemeriksaan_laboratorium SET no_faktur = '$no_faktur' WHERE no_reg = '$no_reg'");

          /*$waktu = date('Y-m-d H:i:s');

          $query_insert_data_periksa = "INSERT INTO pemeriksaan_laboratorium 
          (no_faktur,no_reg,no_rm,waktu,status,nama_pasien,
          status_pasien) VALUES ('$no_faktur','$no_reg','$no_rm','$waktu',
          '0','$nama_pasien','APS')";

            if ($db->query($query_insert_data_periksa) === TRUE){
            
            } 
            else{
            echo "Error: " . $query_insert_data_periksa . "<br>" . $db->error;
            }*/

        }
    } //breaket IF

    //Hapus TBS HASIL LAB
    $query_hapus_tbs_hasil_lab = $db->query("DELETE FROM tbs_hasil_lab WHERE no_reg = '$no_reg'");
       


    //START UNTUK PENJUALAN YANG LUNAS !!
    $nilai_penjualan = $pembayaran_penjualan - $total;

    if ($nilai_penjualan >= 0){

        $ket_jurnal = "Penjualan ".$jenis_penjualan." Lunas ".$data_pelanggan['nama_pelanggan']." ";

        $stmt = $db->prepare("INSERT INTO penjualan (no_faktur,no_reg,kode_pelanggan,total,tanggal,
          jam,user,sales, status,potongan,sisa,cara_bayar,tunai,status_jual_awal,keterangan,ppn,jenis_penjualan,
          nama,biaya_admin, no_faktur_jurnal, keterangan_jurnal,kredit,nilai_kredit) VALUES (?,?,?,?,?,?,?,?,
          'Lunas',?,?,?,?,'Tunai',?,'Include',?,?,?,?,?,'0','0')");
        $stmt->bind_param("sssissssiisisssiss",$no_faktur,$no_reg,$no_rm,$total,$tanggal_sekarang,
        $jam_sekarang, $petugas_kasir,$petugas_kasir,$diskon_rupiah, $sisa, $cara_bayar,
        $pembayaran_penjualan,$keterangan,$jenis_penjualan,$nama_pasien,$biaya_admin,$no_jurnal,$ket_jurnal);

        $_SESSION['no_faktur']=$no_faktur;
                    
        $stmt->execute();

        if (!$stmt){
          die('Query Error : '.$db->errno.' - '.$db->error);
        }
        else{
                      
        }
                         
    }
    else if ($nilai_penjualan != 0){

        $kredit = $total - $pembayaran_penjualan;
        $ket_jurnal = "Penjualan ".$jenis_penjualan." Piutang ".$data_pelanggan['nama_pelanggan']." ";
                    
                    
        $stmt = $db->prepare("INSERT INTO penjualan (no_faktur,no_reg,kode_pelanggan,total,tanggal,jam,user,
          sales, status, potongan,sisa,cara_bayar,tunai,status_jual_awal,keterangan,ppn,jenis_penjualan,
          nama,biaya_admin,no_faktur_jurnal, keterangan_jurnal,kredit,nilai_kredit) VALUES (?,?,?,?,?,?,?,?,
          'Piutang',?,?,?,?,'Kredit',?,'Include',?,?,?,?,?,?,?)");
        $stmt->bind_param("sssissssiisisssissii",
        $no_faktur, $no_reg, $no_rm, $total, $tanggal_sekarang, $jam_sekarang, $petugas_kasir,
        $petugas_kasir,$diskon_rupiah, $sisa, $cara_bayar, $pembayaran_penjualan, $keterangan,$jenis_penjualan,
        $nama_pasien,$biaya_admin,$no_jurnal,$ket_jurnal,$kredit,$kredit);
     
        $_SESSION['no_faktur']=$no_faktur;
                  
        // jalankan query
        $stmt->execute();
          if (!$stmt) {
            die('Query Error : '.$db->errno.' - '.$db->error);
          }
          else{

          }
                   
    }

      $query_ubah_status_registrasi = $db->query("UPDATE registrasi SET status = 'Sudah Pulang' WHERE no_reg ='$no_reg'");

      $query_history_tbs_aps = $db->query("INSERT INTO history_tbs_aps_penjualan (no_reg,no_faktur,kode_jasa,
        nama_jasa,harga,subtotal,dokter,analis,tanggal,jam) SELECT no_reg, no_faktur,kode_jasa,nama_jasa,harga, subtotal,dokter,analis,tanggal,jam FROM tbs_aps_penjualan  WHERE no_reg = '$no_reg' ");


      $query_hapus_fee_produk = $db->query("DELETE FROM tbs_fee_produk WHERE no_reg = '$no_reg' ");


  }// braket if cek subtotal penjualan

    $db->commit();// If we arrive here, it means that no exception was thrown

} //AKHIR DARI BREAKET TRY 

    catch (Exception $e) {
        // We must rollback the transaction
        $db->rollback();
    }


mysqli_close($db);  //Untuk Memutuskan Koneksi Ke Database 
?>