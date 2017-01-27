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

             

                $hasil_hitung_fee_nominal = $dataui['jumlah_uang'] * $jumlah;

                 $query10 = $db->query("INSERT INTO laporan_fee_produk (nama_petugas, no_faktur, kode_produk, nama_produk, jumlah_fee, tanggal, jam, no_rm, no_reg) VALUES ('$dokter', '$data_det[no_faktur]', '$data_det[kode_barang]', '$data_det[nama_barang]', '$hasil_hitung_fee_nominal', '$data[tanggal]', '$data[jam]', '$data[no_rm]', '$data[no_reg]')");

                } // if penutup if dokter di harga1 > 0
                // ENDING PERHITUNGAN UNTUK FEE DOKTER



        }

        echo "OKE";
     
    }



    ?>