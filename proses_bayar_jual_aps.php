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


    // START INSERT KE HASIL LABORATORIUM
    // update no_faktur di hasil_lab and insert ke hasil lab
    $cek_lab = $db->query("SELECT no_reg FROM hasil_lab WHERE no_reg = '$no_reg'");
    $out_lab = mysqli_num_rows($cek_lab);
    if($out_lab > 0 ){

      $update_hasilnya = $db->query("UPDATE hasil_lab SET no_faktur = '$no_faktur' WHERE no_reg = '$no_reg'");
    }
    else{
      // Cek dulu setting, jika tidak di hubungkan akan jalankan ini
      $cek_setting = $db->query("SELECT nama FROM setting_laboratorium");
      $get = mysqli_fetch_array($cek_setting);
      $hasil = $get['nama'];
      if($hasil == 0){

        //ambil di tbs penjualan jasa labnya
        $taked_tbs = $db->query("SELECT kode_jasa,nama_jasa FROM tbs_aps_penjualan WHERE no_reg = '$no_reg'");
        while ($out_tbs = mysqli_fetch_array($taked_tbs)){

          //cek ID jasa laboratoriumnya
            $cek_id_pemeriksaan = $db->query("SELECT id FROM jasa_lab WHERE kode_lab = '$out_tbs[kode_jasa]'");
            $out = mysqli_fetch_array($cek_id_pemeriksaan);
            $id_pemeriksaan = $out['id'];

          //SELECT UNTUK CEK JASA INDUX, JIKA JASA INDUX JANGAN DI INSERT KE HASIL !!
            $cek_indux_or_no = $db->query("SELECT nama_pemeriksaan FROM setup_hasil WHERE nama_pemeriksaan = '$id_pemeriksaan' AND kategori_index = 'Header'");
            $out_bukan_indux = mysqli_fetch_array($cek_indux_or_no);
            $id_indux = $out_bukan_indux['nama_pemeriksaan'];

            if($id_indux == $id_pemeriksaan){

            }
            else{
            
              $cek_hasil = $db->query("SELECT id,normal_lk2,normal_pr2,normal_lk,
              normal_pr,model_hitung,satuan_nilai_normal FROM setup_hasil 
              WHERE nama_pemeriksaan = '$id_pemeriksaan'");
              $out_hasil = mysqli_fetch_array($cek_hasil);
              $hasil_pria = $out_hasil['normal_lk'];
              $hasil_wanita = $out_hasil['normal_pr'];
              $model_hitung = $out_hasil['model_hitung'];
              $satuan_nilai_normal = $out_hasil['satuan_nilai_normal'];

              $id_subnya = $out_hasil['id'];
              $hasil_pria2 = $out_hasil['normal_lk2'];
              $hasil_wanita2 = $out_hasil['normal_pr2'];
                //Select untuk Data yang sudah di input kan hasilnya tidak di insert dan tidak di DELETE (TIDAK DI DELETE SUDAH ADA DI ATAS)
              $get_data = $db->query("SELECT id_pemeriksaan FROM tbs_hasil_lab WHERE id_pemeriksaan = '$id_pemeriksaan' AND hasil_pemeriksaan != '' AND no_reg = '$no_reg'");
              $out_data = mysqli_num_rows($get_data);
              $out_data_id = mysqli_fetch_array($get_data);

              $datanya = $out_data_id['id_pemeriksaan'];

              if($out_data > 0 AND $datanya != ''){

              }
              else{
              $insert_on = $db->query("INSERT INTO hasil_lab (satuan_nilai_normal,model_hitung,no_faktur, id_pemeriksaan, nilai_normal_lk, nilai_normal_pr, status_pasien,nama_pemeriksaan, nama_pasien, status,no_rm,no_reg,kode_barang,nilai_normal_lk2,nilai_normal_pr2) VALUES 
                ('$satuan_nilai_normal','$model_hitung','$no_faktur','$id_pemeriksaan',
                '$hasil_pria','$hasil_wanita','APS','$out_tbs[nama_jasa]',
                '$nama_pasien','Unfinish','$no_rm','$no_reg','$out_tbs[kode_jasa]',
                '$hasil_pria2','$hasil_wanita2')");
            
          

              } 
            }
        } //breaket WHILE AWAL

    //selesai untuk yang tidak memiliki Header / Ibu
    //NOTE* BAGIAN ATAS INSERT DARI TBS , DAN BAGIAN BAWAH INSERT DETAIL YANG INDUX (HEADER)-NYA ADA DI TBS PENJUALAN !!

    //START Proses untuk input Header and Detail Jasa Laboratorium
    //Ambil setup hasil yang nama pemeriksaaannya (id) sama dengan id di jasa_lab dan di setup hasilnya Header (Indux)
    $perintah = $db->query("SELECT kode_jasa FROM tbs_aps_penjualan WHERE no_reg = '$no_reg'");
    while($data = mysqli_fetch_array($perintah)){

      $kode_barang = $data['kode_jasa'];

      $cek_id_pemeriksaan = $db->query("SELECT id FROM jasa_lab WHERE kode_lab = '$kode_barang'");
      $out = mysqli_fetch_array($cek_id_pemeriksaan);
      $id_jasa_lab = $out['id'];

      $cek_ibu_header = $db->query("SELECT id FROM setup_hasil WHERE nama_pemeriksaan = '$id_jasa_lab'");
      while($out_mother = mysqli_fetch_array($cek_ibu_header)){
      $id_mother = $out_mother['id'];

    //DI EDIT YANG WHILE INI QUERY SALAH !!!!!!
      $select_detail_anaknya = $db->query("SELECT * FROM setup_hasil WHERE sub_hasil_lab = '$id_mother'");
      while($drop = mysqli_fetch_array($select_detail_anaknya)){
      $ambil_nama_jasa = $db->query("SELECT nama FROM jasa_lab WHERE id = '$drop[nama_pemeriksaan]'");
      $get = mysqli_fetch_array($ambil_nama_jasa);
      $nama_jasa_anak = $get['nama'];
      
    //Select untuk Data yang sudah di input kan hasilnya tidak di insert dan tidak di DELETE (TIDAK DI DELETE SUDAH ADA DI ATAS)
      $get_data = $db->query("SELECT id_pemeriksaan FROM tbs_hasil_lab WHERE id_pemeriksaan = '$drop[nama_pemeriksaan]' AND hasil_pemeriksaan != '' AND no_reg = '$no_reg'");
      $out_data = mysqli_num_rows($get_data);
      $out_data_id = mysqli_fetch_array($get_data);

      $datanya = $out_data_id['id_pemeriksaan'];

      if($out_data > 0 AND $datanya != ''){

      }
      else{

      $insert_anaknya = "INSERT INTO hasil_lab (no_faktur,satuan_nilai_normal,
      model_hitung,no_rm,no_reg,id_pemeriksaan,nilai_normal_lk,nilai_normal_pr,status_pasien,nama_pemeriksaan,id_sub_header,nilai_normal_lk2,nilai_normal_pr2,kode_barang,status,nama_pasien) VALUES ('$no_faktur','$drop[satuan_nilai_normal]','$drop[model_hitung]',
      '$no_rm','$no_reg','$drop[nama_pemeriksaan]','$drop[normal_lk]',
      '$drop[normal_pr]','$jenis_penjualan','$nama_jasa_anak','$id_mother',
      '$drop[normal_lk2]','$drop[normal_pr2]','$kode_barang','Unfinish','$nama_pasien')";

          if ($db->query($insert_anaknya) === TRUE){
          
          } 
          else{
          echo "Error: " . $insert_anaknya . "<br>" . $db->error;
          }
        }
        //under while 3x
      }
     }
    }
       $delete_tbs_hasil_lab = $db->query("DELETE FROM tbs_hasil_lab WHERE no_reg = '$no_reg'");
       
      }// end if setting lab
    } // else jika setting nya bayar dulu baru input hasil
    //Ending Proses untuk input Header and Detail Jasa Laboratorium
    // ENDING INSERT KE HASIL LABORATORIUM


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
        $nama_pasien,$biaya_admin,$no_jurnal,$ket_jurnal,$kredit,$total);
     
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

      $query_hapus_tbs_aps = $db->query("DELETE FROM tbs_aps_penjualan WHERE no_reg = '$no_reg' ");


  }// braket if cek subtotal penjualan

    $db->commit();// If we arrive here, it means that no exception was thrown

} //AKHIR DARI BREAKET TRY 

    catch (Exception $e) {
        // We must rollback the transaction
        $db->rollback();
    }


mysqli_close($db);  //Untuk Memutuskan Koneksi Ke Database 
?>