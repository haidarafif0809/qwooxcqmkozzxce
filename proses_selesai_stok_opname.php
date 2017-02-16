<?php session_start();

        include 'sanitasi.php';
        include 'db.php';

$tahun_sekarang = date('Y');
$bulan_sekarang = date('m');
$tanggal_sekarang = date('Y-m-d');
$jam_sekarang = date('H:i:s');
$tahun_terakhir = substr($tahun_sekarang, 2);


                $query2 = $db->prepare("INSERT INTO stok_opname (no_faktur,tanggal,jam,status, total_selisih,user) 
                VALUES (?,?,?,'ya',?,?)");
                
                $query2->bind_param("sssis",
                $no_faktur,$tanggal_sekarang,$jam_sekarang,$selisih_harga,$user);
                
                $no_faktur = stringdoang($_POST['no_faktur']);
                $total_selisih_harga = angkadoang($_POST['total_selisih_harga']);
                $selisih_harga = $total_selisih_harga;
                $user = $_SESSION['user_name'];
                
                $query2->execute();



        $query1 = $db->query("SELECT * FROM tbs_stok_opname WHERE no_faktur = '$no_faktur' ");
        while ($data = mysqli_fetch_array($query1))
        {


            
            $query = $db->query("UPDATE barang SET stok_opname = '' WHERE kode_barang = '$data[kode_barang]'");

            $query4 = "INSERT INTO detail_stok_opname (no_faktur, tanggal, jam, kode_barang, nama_barang, awal, masuk, keluar, stok_sekarang, fisik, selisih_fisik, selisih_harga, harga, hpp) 
            VALUES ('$data[no_faktur]', '$tanggal_sekarang', '$jam_sekarang', '$data[kode_barang]', '$data[nama_barang]', '$data[awal]', '$data[masuk]', '$data[keluar]', '$data[stok_sekarang]', '$data[fisik]', '$data[selisih_fisik]', '$data[selisih_harga]', '$data[harga]', '$data[hpp]')";
            
            if ($db->query($query4) === TRUE) {
                
            } else {
            echo "Error: " . $query4 . "<br>" . $db->error;
            }
            
            
        
        }


//JURNAL TRANSAKSI
$ambil_tbs = $db->query("SELECT SUM(selisih_harga) AS total FROM tbs_stok_opname WHERE no_faktur = '$no_faktur'");
$data_tbs = mysqli_fetch_array($ambil_tbs);
$total_tbs = $data_tbs['total'];


$sum_hpp_keluar = $db->query("SELECT SUM(total_nilai) AS total FROM hpp_keluar WHERE no_faktur = '$no_faktur'");
$ambil_sum = mysqli_fetch_array($sum_hpp_keluar);
$total = $ambil_sum['total'];


$sum_hpp_masuk = $db->query("SELECT SUM(total_nilai) AS total FROM hpp_masuk WHERE no_faktur = '$no_faktur'");
$ambil_sum_masuk = mysqli_fetch_array($sum_hpp_keluar);
$total_masuk = $ambil_sum_masuk['total'];

$select_setting_akun = $db->query("SELECT * FROM setting_akun");
$ambil_setting = mysqli_fetch_array($select_setting_akun);

if ($total_tbs < 0) {
    $total0 = $total;



 //PERSEDIAAN    
        $insert_jurnal = "INSERT INTO jurnal_trans (nomor_jurnal,waktu_jurnal,keterangan_jurnal,kode_akun_jurnal,debit,kredit,jenis_transaksi,no_faktur,approved,user_buat) VALUES ('".no_jurnal()."', '$tanggal_sekarang $jam_sekarang', 'Stok Opname -', '$ambil_setting[persediaan]', '0', '$total0', 'Stok Opname', '$no_faktur','1', '$user')";
if ($db->query($insert_jurnal) === TRUE) {
                
            } else {
            echo "Error: " . $insert_jurnal . "<br>" . $db->error;
            }



  //STOK OPNAME    
        $insert_jurnal2 = "INSERT INTO jurnal_trans (nomor_jurnal,waktu_jurnal,keterangan_jurnal,kode_akun_jurnal,debit,kredit,jenis_transaksi,no_faktur,approved,user_buat) VALUES ('".no_jurnal()."', '$tanggal_sekarang $jam_sekarang', 'Stok Opname -', '$ambil_setting[pengaturan_stok]', '$total0', '0', 'Stok Opname', '$no_faktur','1', '$user')";
        if ($db->query($insert_jurnal2) === TRUE) {
                
            } else {
            echo "Error: " . $insert_jurnal2 . "<br>" . $db->error;
            }

} 

else {
    $totals = $total_masuk;



      //PERSEDIAAN    
        $insert_jurnal3 = "INSERT INTO jurnal_trans (nomor_jurnal,waktu_jurnal,keterangan_jurnal,kode_akun_jurnal,debit,kredit,jenis_transaksi,no_faktur,approved,user_buat) VALUES ('".no_jurnal()."', '$tanggal_sekarang $jam_sekarang', 'Stok Opname -', '$ambil_setting[persediaan]', '$total_tbs', '0', 'Stok Opname', '$no_faktur','1', '$user')";
        
        if ($db->query($insert_jurnal3) === TRUE) {
                
            } else {
            echo "Error: " . $insert_jurnal3 . "<br>" . $db->error;
            }

  //STOK OPNAME    
        $insert_jurnal4 = "INSERT INTO jurnal_trans (nomor_jurnal,waktu_jurnal,keterangan_jurnal,kode_akun_jurnal,debit,kredit,jenis_transaksi,no_faktur,approved,user_buat) VALUES ('".no_jurnal()."', '$tanggal_sekarang $jam_sekarang', 'Stok Opname -', '$ambil_setting[pengaturan_stok]', '0', '$total_tbs', 'Stok Opname', '$no_faktur','1', '$user')";
        if ($db->query($insert_jurnal4) === TRUE) {
                
            } else {
            echo "Error: " . $insert_jurnal4 . "<br>" . $db->error;
            }
}



$queryhtso = "INSERT INTO history_tbs_stok_opname(session_id, no_faktur, kode_barang, nama_barang, satuan, awal, masuk, keluar, stok_sekarang, fisik, selisih_fisik, selisih_harga, harga, hpp) SELECT session_id, no_faktur, kode_barang, nama_barang, satuan, awal, masuk, keluar, stok_sekarang, fisik, selisih_fisik, selisih_harga, harga, hpp FROM tbs_stok_opname WHERE no_faktur = '$no_faktur'";
            
            if ($db->query($queryhtso) === TRUE) {
                
            } else {
            echo "Error: " . $queryhtso . "<br>" . $db->error;
            }
//</>END JURNAL TRANSAKSI


        $query5 = $db->query("DELETE FROM tbs_stok_opname WHERE no_faktur = '$no_faktur'  ");
        
        

//Untuk Memutuskan Koneksi Ke Database
mysqli_close($db);   

    ?>