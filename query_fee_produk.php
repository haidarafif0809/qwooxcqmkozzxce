<?php 
include 'sanitasi.php';
include 'db.php';
    

    $select = $db->query("SELECT * FROM penjualan WHERE tanggal = '2017-01-27'");
    while ($data = mysqli_fetch_array($select)) { 

    $select_user = $db->query("SELECT id FROM user WHERE nama = '$data[user]'");
    $dataa = mysqli_fetch_array($select);

          $dokter = $data['dokter'];
          $apoteker = $data['apoteker'];
          $perawat = $data['perawat'];
          $petugas_lain = $data['petugas_lain'];
          $id_user = $dataa['id'];
       // START PERHITUNGAN FEE HARGA 1 INSERT

        $select = $db->query("SELECT * FROM detail_penjualan WHERE tanggal = '2017-01-27'");
        while ($data_det = mysqli_fetch_array($select)) {

          $subtotaljadi = $data_det['subtotal'];
          $jumlah = $data_det['jumlah_barang']

        // PERHITUNGAN UNTUK FEE DOKTER
        $ceking = $db->query("SELECT * FROM fee_produk WHERE nama_petugas = '$dokter' AND kode_produk = '$data_det[kode_barang]'");
        $cek_fee_dokter1 = mysqli_num_rows($ceking);
        $dataui = mysqli_fetch_array($ceking);

        if ($cek_fee_dokter1 > 0){
        if ($dataui['jumlah_prosentase'] != 0 AND $dataui['jumlah_uang'] == 0 )

        {      



        $hasil_hitung_fee_persen = $subtotaljadi * $dataui['jumlah_prosentase'] / 100;

        $insert1 = "INSERT INTO tbs_fee_produk (no_faktur,no_reg,no_rm,nama_petugas,kode_produk,nama_produk,jumlah_fee,tanggal,jam) VALUES ('$data_det[no_faktur]','$data_det[no_reg]','$data_det[no_rm]','$dokter','$data_det[kode_barang]','$data_det[nama_barang]','$hasil_hitung_fee_persen','$data_det[tanggal]','$data_det[jam]')";

            
            if ($db->query($insert1) === TRUE) {
            
            } 
            
            else {
            echo "Error: " . $insert1 . "<br>" . $db->error;
            }

        }



        else
        {

        $hasil_hitung_fee_nominal = $dataui['jumlah_uang'] * $jumlah;

        $insert2 = "INSERT INTO tbs_fee_produk (no_faktur,no_reg,no_rm,nama_petugas,kode_produk,nama_produk,jumlah_fee,tanggal,jam) VALUES ('$data_det[no_faktur]','$data_det[no_reg]','$data_det[no_rm]','$dokter','$data_det[kode_barang]','$data_det[nama_barang]','$hasil_hitung_fee_nominal','$data_det[tanggal]','$data_det[jam]')";

            
            if ($db->query($insert2) === TRUE) {
            
            } 
            else {
            echo "Error: " . $insert2 . "<br>" . $db->error;
            }

          }
        } // if penutup if dokter di harga1 > 0
        // ENDING PERHITUNGAN UNTUK FEE DOKTER


        // PERHITUNGAN UNTUK FEE APOTEKER
        $cek_apoteker = $db->query("SELECT * FROM fee_produk WHERE nama_petugas = '$apoteker' AND kode_produk = '$data_det[kode_barang]'");
        $cek_fee_apoteker1 = mysqli_num_rows($cek_apoteker);
        $dataui_apoteker = mysqli_fetch_array($cek_apoteker);

        if ($cek_fee_apoteker1 > 0){

        if ($dataui_apoteker['jumlah_prosentase'] != 0 AND $dataui_apoteker['jumlah_uang'] == 0 )

        {  

        $hasil_hitung_fee_persen_apoteker = $subtotaljadi * $dataui_apoteker['jumlah_prosentase'] / 100;

        $insert_apoteker = "INSERT INTO tbs_fee_produk (no_faktur,no_reg,no_rm,nama_petugas,kode_produk,nama_produk,jumlah_fee,tanggal,jam) VALUES ('$data_det[no_faktur]','$data_det[no_reg]','$data_det[no_rm]','$apoteker','$data_det[kode_barang]','$data_det[nama_barang]','$hasil_hitung_fee_persen_apoteker','$data_det[tanggal]','$data_det[jam]')";
              
              if ($db->query($insert_apoteker) === TRUE) {
              
              } 
              else 
              {
              echo "Error: " . $insert_apoteker . "<br>" . $db->error;
              }

          }

        else

        {

        $hasil_hitung_fee_nominal_apoteker = $dataui_apoteker['jumlah_uang'] * $jumlah;


        $insert2_apoteker = "INSERT INTO tbs_fee_produk (no_faktur,no_reg,no_rm,nama_petugas,kode_produk,nama_produk,jumlah_fee,tanggal,jam) VALUES ('$data_det[no_faktur]','$data_det[no_reg]','$data_det[no_rm]','$apoteker','$data_det[kode_barang]','$data_det[nama_barang]','$hasil_hitung_fee_nominal_apoteker','$data_det[tanggal]','$data_det[jam]')";
              
              if ($db->query($insert2_apoteker) === TRUE) {
              
              } 
              else
              {
              echo "Error: " . $insert2_apoteker . "<br>" . $db->error;
              }
          }
        } // penutup if apoteker di harga1 > 0
        // ENDING PERHITUNGAN UNTUK FEE APOTEKER


        // PERHITUNGAN UNTUK FEE PERAWAT
        $cek_perawat = $db->query("SELECT * FROM fee_produk WHERE nama_petugas = '$perawat' AND kode_produk = '$data_det[kode_barang]'");
        $cek_fee_perawat1 = mysqli_num_rows($cek_perawat);
        $dataui_perawat = mysqli_fetch_array($cek_perawat);

        if ($cek_fee_perawat1 > 0){
        if ($dataui_perawat['jumlah_prosentase'] != 0 AND $dataui_perawat['jumlah_uang'] == 0 )

        {  

        $hasil_hitung_fee_persen_perawat = $subtotaljadi * $dataui_perawat['jumlah_prosentase'] / 100;

        $insert_perawat = "INSERT INTO tbs_fee_produk (no_faktur,no_reg,no_rm,nama_petugas,kode_produk,nama_produk,jumlah_fee,tanggal,jam) VALUES ('$data_det[no_faktur]','$data_det[no_reg]','$data_det[no_rm]','$perawat','$data_det[kode_barang]','$data_det[nama_barang]','$hasil_hitung_fee_persen_perawat','$data_det[tanggal]','$data_det[jam]')";
                
                if ($db->query($insert_perawat) === TRUE) {
                
                } 
                else 
                {
                echo "Error: " . $insert_perawat . "<br>" . $db->error;
                }
        }

        else

        {

        $hasil_hitung_fee_nominal_perawat = $dataui_perawat['jumlah_uang'] * $jumlah;

        $insert2_perawat = "INSERT INTO tbs_fee_produk (no_faktur,no_reg,no_rm,nama_petugas,kode_produk,nama_produk,jumlah_fee,tanggal,jam) VALUES ('$data_det[no_faktur]','$data_det[no_reg]','$data_det[no_rm]','$perawat','$data_det[kode_barang]','$data_det[nama_barang]','$hasil_hitung_fee_nominal_perawat','$data_det[tanggal]','$data_det[jam]')";
            
            if ($db->query($insert2_perawat) === TRUE) {
            
            } 
            else
            {
            echo "Error: " . $insert2_perawat . "<br>" . $db->error;
            }

          }
        } // breaket penutup if di perawat di harga1 > 0
        // ENDING PERHITUNGAN UNTUK FEE PERAWAT




        // PERHITUNGAN UNTUK FEE PETUGAS LAIN (INSERT)
        $cek_petugas_lain = $db->query("SELECT * FROM fee_produk WHERE nama_petugas = '$petugas_lain' AND kode_produk = '$data_det[kode_barang]'");
        $cek_fee_petugas_lain1 = mysqli_num_rows($cek_petugas_lain);
        $dataui_petugas_lain = mysqli_fetch_array($cek_petugas_lain);

        if ($cek_fee_petugas_lain1 > 0){
        if ($dataui_petugas_lain['jumlah_prosentase'] != 0 AND $dataui_petugas_lain['jumlah_uang'] == 0 )

        {  

        $hasil_hitung_fee_persen_petugas_lain = $subtotaljadi * $dataui_petugas_lain['jumlah_prosentase'] / 100;

        $insert_petugas_lain = "INSERT INTO tbs_fee_produk (no_faktur,no_reg,no_rm,nama_petugas,kode_produk,nama_produk,jumlah_fee,tanggal,jam) VALUES ('$data_det[no_faktur]','$data_det[no_reg]','$data_det[no_rm]','$petugas_lain','$data_det[kode_barang]','$data_det[nama_barang]','$hasil_hitung_fee_persen_petugas_lain','$data_det[tanggal]','$data_det[jam]')";
                
                if ($db->query($insert_petugas_lain) === TRUE) {
                
                } 
                else 
                {
                echo "Error: " . $insert_petugas_lain . "<br>" . $db->error;
                }
        }

        else

        {

        $hasil_hitung_fee_nominal_petugas_lain = $dataui_petugas_lain['jumlah_uang'] * $jumlah;

        $insert1_petugas_lain = "INSERT INTO tbs_fee_produk (no_faktur,no_reg,no_rm,nama_petugas,kode_produk,nama_produk,jumlah_fee,tanggal,jam) VALUES ('$data_det[no_faktur]','$data_det[no_reg]','$data_det[no_rm]','$petugas_lain','$data_det[kode_barang]','$data_det[nama_barang]','$hasil_hitung_fee_nominal_petugas_lain','$data_det[tanggal]','$data_det[jam]')";
            
            if ($db->query($insert1_petugas_lain) === TRUE) {
            
            } 
            else
            {
            echo "Error: " . $insert1_petugas_lain . "<br>" . $db->error;
            }

          }
        } // breaket penutup if di PETUGAS LAIN di harga1 > 0
        // ENDING PERHITUNGAN UNTUK FPETUGAS LAIN




        // PERHITUNGAN UNTUK FEE PETUGAS
        $cek_petugas = $db->query("SELECT * FROM fee_produk WHERE nama_petugas = '$id_user' AND kode_produk = '$data_det[kode_barang]'");
        $cek_fee_petugas1 = mysqli_num_rows($cek_petugas);
        $dataui_petugas = mysqli_fetch_array($cek_petugas);

        if ($cek_fee_petugas1 > 0) {
        if ($dataui_petugas['jumlah_prosentase'] != 0 AND $dataui_petugas['jumlah_uang'] == 0 )

        {  

        $hasil_hitung_fee_persen_petugas = $subtotaljadi * $dataui_petugas['jumlah_prosentase'] / 100;

        $insert1_petugas = "INSERT INTO tbs_fee_produk (no_faktur,no_reg,no_rm,nama_petugas,kode_produk,nama_produk,jumlah_fee,tanggal,jam) VALUES ('$data_det[no_faktur]','$data_det[no_reg]','$data_det[no_rm]','$id_user','$data_det[kode_barang]','$data_det[nama_barang]','$hasil_hitung_fee_persen_petugas','$data_det[tanggal]','$data_det[jam]')";

                if ($db->query($insert1_petugas) === TRUE) 
                {
                
                } 
                else 
                {
                echo "Error: " . $insert1_petugas . "<br>" . $db->error;
                }

        }

        else
        {

        $hasil_hitung_fee_nominal_petugas = $dataui_petugas['jumlah_uang'] * $jumlah;


        $insert2_petugas = "INSERT INTO tbs_fee_produk (no_faktur,no_reg,no_rm,nama_petugas,kode_produk,nama_produk,jumlah_fee,tanggal,jam) VALUES ('$data_det[no_faktur]','$data_det[no_reg]','$data_det[no_rm]','$id_user','$data_det[kode_barang]','$data_det[nama_barang]','$hasil_hitung_fee_nominal_petugas','$data_det[tanggal]','$data_det[jam]')";
            if ($db->query($insert2_petugas) === TRUE) 
            {
            
            } 
            else 
            {
            echo "Error: " . $insert2_petugas . "<br>" . $db->error;
            }

        }

        } // penutup if petugas di harga 1 > 0
        // ENDING PERHITUNGAN UNTUK FEE PETUGAS



        }
     
    }



    ?>