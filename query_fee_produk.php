<?php 
include 'sanitasi.php';
include 'db.php';
    

    $select = $db->query("SELECT * FROM penjualan WHERE tanggal = '2017-01-27'");
    while ($data = mysqli_fetch_array($select)) {


          $dokter = $data['dokter'];
          $apoteker = $data['apoteker'];
          $perawat = $data['perawat'];
          $petugas_lain = $data['petugas_lain'];

       // START PERHITUNGAN FEE HARGA 1 INSERT

        $select = $db->query("SELECT * FROM detail_penjualan WHERE tanggal = '2017-01-27'");
        while ($data_det = mysqli_fetch_array($select)) {


                echo $jumlah = $data_det['jumlah_barang'];


                // PERHITUNGAN UNTUK FEE DOKTER
                $ceking = $db->query("SELECT * FROM fee_produk WHERE nama_petugas = '$dokter' AND kode_produk = '$data_det[kode_barang]'");
                $cek_fee_dokter1 = mysqli_num_rows($ceking);
                $dataui = mysqli_fetch_array($ceking);

                if ($cek_fee_dokter1 > 0){
                if ($dataui['jumlah_prosentase'] != 0 AND $dataui['jumlah_uang'] == 0 )

             

                $hasil_hitung_fee_nominal = $dataui['jumlah_uang'] * $jumlah;

                 $query10 = $db->query("INSERT INTO laporan_fee_produk (nama_petugas, no_faktur, kode_produk, nama_produk, jumlah_fee, tanggal, jam, no_rm, no_reg) VALUES ('$dokter', '$data_det[no_faktur]', '$data_det[kode_barang]', '$data_det[nama_barang]', '$hasil_hitung_fee_nominal', '$data[tanggal]', '$data[jam]', '$data[no_rm]', '$data[no_reg]')");

                } // if penutup if dokter di harga1 > 0
                // ENDING PERHITUNGAN UNTUK FEE DOKTER


                // PERHITUNGAN UNTUK FEE APOTEKER
                $cek_apoteker = $db->query("SELECT * FROM fee_produk WHERE nama_petugas = '$apoteker' AND kode_produk = '$data_det[kode_barang]'");
                $cek_fee_apoteker1 = mysqli_num_rows($cek_apoteker);
                $dataui_apoteker = mysqli_fetch_array($cek_apoteker);

                if ($cek_fee_apoteker1 > 0){

                

                $hasil_hitung_fee_nominal_apoteker = $dataui_apoteker['jumlah_uang'] * $jumlah;


                $query10 = $db->query("INSERT INTO laporan_fee_produk (nama_petugas, no_faktur, kode_produk, nama_produk, jumlah_fee, tanggal, jam, no_rm, no_reg) VALUES ('$apoteker', '$data_det[no_faktur]', '$data_det[kode_barang]', '$data_det[nama_barang]', '$hasil_hitung_fee_nominal_apoteker', '$data[tanggal]', '$data[jam]', '$data[no_rm]', '$data[no_reg]')");
                      
                      
                } // penutup if apoteker di harga1 > 0
                // ENDING PERHITUNGAN UNTUK FEE APOTEKER


                // PERHITUNGAN UNTUK FEE PERAWAT
                $cek_perawat = $db->query("SELECT * FROM fee_produk WHERE nama_petugas = '$perawat' AND kode_produk = '$data_det[kode_barang]'");
                $cek_fee_perawat1 = mysqli_num_rows($cek_perawat);
                $dataui_perawat = mysqli_fetch_array($cek_perawat);

                if ($cek_fee_perawat1 > 0){


                $hasil_hitung_fee_nominal_perawat = $dataui_perawat['jumlah_uang'] * $jumlah;

                $query10 = $db->query("INSERT INTO laporan_fee_produk (nama_petugas, no_faktur, kode_produk, nama_produk, jumlah_fee, tanggal, jam, no_rm, no_reg) VALUES ('$perawat', '$data_det[no_faktur]', '$data_det[kode_barang]', '$data_det[nama_barang]', '$hasil_hitung_fee_nominal_perawat', '$data[tanggal]', '$data[jam]', '$data[no_rm]', '$data[no_reg]')");


                } // breaket penutup if di perawat di harga1 > 0
                // ENDING PERHITUNGAN UNTUK FEE PERAWAT




                // PERHITUNGAN UNTUK FEE PETUGAS LAIN (INSERT)
                $cek_petugas_lain = $db->query("SELECT * FROM fee_produk WHERE nama_petugas = '$petugas_lain' AND kode_produk = '$data_det[kode_barang]'");
                $cek_fee_petugas_lain1 = mysqli_num_rows($cek_petugas_lain);
                $dataui_petugas_lain = mysqli_fetch_array($cek_petugas_lain);

                if ($cek_fee_petugas_lain1 > 0){
                

                $hasil_hitung_fee_nominal_petugas_lain = $dataui_petugas_lain['jumlah_uang'] * $jumlah;

                $query10 = $db->query("INSERT INTO laporan_fee_produk (nama_petugas, no_faktur, kode_produk, nama_produk, jumlah_fee, tanggal, jam, no_rm, no_reg) VALUES ('$petugas_lain', '$data_det[no_faktur]', '$data_det[kode_barang]', '$data_det[nama_barang]', '$hasil_hitung_fee_nominal_petugas_lain', '$data[tanggal]', '$data[jam]', '$data[no_rm]', '$data[no_reg]')");
          
                } // breaket penutup if di PETUGAS LAIN di harga1 > 0
                // ENDING PERHITUNGAN UNTUK FPETUGAS LAIN



        }

        echo "OKE";
     
    }



    ?>