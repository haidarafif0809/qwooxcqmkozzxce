<?php include 'session_login.php';
include 'db.php';
include_once 'sanitasi.php';

//Data yang di kirimkan
$session_id = session_id();
$user = $_SESSION['nama'];
$id_user_edit = $_SESSION['id'];

    $no_faktur = stringdoang($_POST['no_faktur']);
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
    $tanggal = stringdoang($_POST['tanggal']);
    
    $no_jurnal = no_jurnal();
    $jenis_penjualan = 'APS';
    $jam = date('H:i:s');
    $waktu_edit = date('Y-m-d H:i:s');

//Ambil Nama Pelanggan
$query_pelanggan = $db_pasien->query("SELECT nama_pelanggan FROM pelanggan WHERE kode_pelanggan = 
  '$no_rm'");
$data_pelanggan = mysqli_fetch_array($query_pelanggan); 

//Cek total pada TBS APS apakah sesuai dengan total akhir
$query_jumlah_harga = $db->query("SELECT SUM(harga) AS total_harga FROM tbs_aps_penjualan WHERE  no_reg = '$no_reg'");
$data_jumlah_harga = mysqli_fetch_array($query_jumlah_harga);
$total_harga_tbs = $data_jumlah_harga['total_harga'];

$total_tbs = ($total_harga_tbs - $diskon_rupiah) + $biaya_admin;

  if ($total != $total_tbs){ 
    echo 1;
  }
  else{

    //Hapus Jurnal
    $query_hapus_jurnal = $db->query("DELETE FROM jurnal_trans WHERE no_faktur = '$no_faktur'");

    //Hapus Laporan Fee
    $query_hapus_fee = $db->query("DELETE FROM laporan_fee_faktur WHERE no_reg = '$no_reg' AND no_faktur = '$no_faktur'");

    //Hapus Detail Penjualan
    $query_hapus_fee = $db->query("DELETE FROM detail_penjualan WHERE no_reg = '$no_reg' AND no_faktur = '$no_faktur'");

          //INSERT DARI TBS APS KE DETAIL PENJUALAN
          $query_insert_detail_penjualan = "INSERT INTO detail_penjualan (no_faktur,no_rm,no_reg,
          kode_barang,nama_barang,jumlah_barang,harga,subtotal,sisa,tipe_produk,tanggal,jam)
          SELECT '$no_faktur','$no_rm',no_reg, kode_jasa, nama_jasa, '1', harga, harga, '1',
          'Jasa', tanggal, jam FROM tbs_aps_penjualan WHERE no_reg = '$no_reg' AND 
          no_faktur = '$no_faktur'";
              if ($db->query($query_insert_detail_penjualan) === TRUE) {
            
              }
              else{
              echo "Error: " . $query_insert_detail_penjualan . "<br>" . $db->error;
              }
          //INSERT DARI TBS APS KE DETAIL PENJUALAN

            //MULAI Penjualan Lunas!!
          $nilai_penjualan = $pembayaran_penjualan - $total;
          if ($nilai_penjualan >= 0){

            $ket_jurnal = "Penjualan ".$jenis_penjualan." Lunas ".$data_pelanggan['nama_pelanggan']."";
            $status = 'Lunas';
            $kredit = '0';
            $nilai_kredit = '0';
            $status_jual_awal = 'Tunai';

            $query_update_penjualan_lunas = $db->prepare("UPDATE penjualan SET total = ?, 
              biaya_admin = ?, tanggal = ?, jam = ?, status = ?, potongan = ?, sisa = ?,
              kredit = ?, nilai_kredit = ?, cara_bayar = ?, tunai = ?, status_jual_awal = ?,
              petugas_edit = ?, waktu_edit = ?, no_faktur_jurnal = ?, keterangan_jurnal = ? 
              WHERE no_faktur = ?");

            $query_update_penjualan_lunas->bind_param("iisssiiiisissssss",$total,$biaya_admin,
            $tanggal,$jam,$status,$diskon_rupiah,$sisa_pembayaran,$kredit,$nilai_kredit,$cara_bayar,
            $pembayaran_penjualan,$status_jual_awal,$id_user_edit,$waktu_edit,$no_jurnal,
            $keterangan_jurnal,$no_faktur);
                    
            $query_update_penjualan_lunas->execute();

              if (!$query_update_penjualan_lunas){
              die('Query Error : '.$db->errno.' - '.$db->error);
              }
              else{
                      
              }
            //Akhir Penjualan Lunas

          } //Else IF dari pembayaran LUNAS ATAU PIUTANG
          else{
            //Mulai Penjualan Piutang

           $ket_jurnal = "Penjualan ".$jenis_penjualan." Piutang ".$data_pelanggan['nama_pelanggan']."";
            $status = 'Piutang';
            $kredit = $total - $pembayaran_penjualan;
            $status_jual_awal = 'Kredit';

            $query_update_penjualan_piutang = $db->prepare("UPDATE penjualan SET total = ?, 
              biaya_admin = ?, tanggal = ?, jam = ?, status = ?, potongan = ?, sisa = ?,
              kredit = ?, nilai_kredit = ?, cara_bayar = ?, tunai = ?, status_jual_awal = ?,
              petugas_edit = ?, waktu_edit = ?, no_faktur_jurnal = ?, keterangan_jurnal = ? 
              WHERE no_faktur = ?");

            $query_update_penjualan_piutang->bind_param("iisssiiiisissssss",$total,$biaya_admin,
            $tanggal,$jam,$status,$diskon_rupiah,$sisa_pembayaran,$kredit,$kredit,$cara_bayar,
            $pembayaran_penjualan,$status_jual_awal,$id_user_edit,$waktu_edit,$no_jurnal,
            $keterangan_jurnal,$no_faktur);
                    
            $query_update_penjualan_piutang->execute();

              if (!$query_update_penjualan_piutang){
              die('Query Error : '.$db->errno.' - '.$db->error);
              }
              else{
                      
              }


            //Mulai Penjualan Piutang

          } //Else IF dari pembayaran LUNAS ATAU PIUTANG


    //Hapus TBS APS Penjualan
    $query_hapus_tbs_aps = $db->query("DELETE FROM tbs_aps_penjualan WHERE no_reg = '$no_reg' AND no_faktur = '$no_faktur'");

  }//Breket Else dari Cek Subtotal

mysqli_close($db);  //Untuk Memutuskan Koneksi Ke Database 
?>