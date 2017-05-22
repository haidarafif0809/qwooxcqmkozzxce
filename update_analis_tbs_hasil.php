<?php session_start();
	// memasukan file db.php
    include 'sanitasi.php';
    include 'db.php';
    // mengrim data dengan menggunakan metode POST
    $id = angkadoang($_POST['id']);
    $nama_lama = stringdoang($_POST['nama_lama']);
    $input_nama = stringdoang($_POST['input_nama']);
    $no_reg = stringdoang($_POST['reg']);
    $kode_jasa = stringdoang($_POST['kode']);
    $no_rm = stringdoang($_POST['rm']);
    $nama_pemeriksaan = stringdoang($_POST['nama_pemeriksaan']);
    $nama_header = stringdoang($_POST['nama_header']);
    $harga_jasa= angkadoang($_POST['harga']);
    $session_id = session_id();
    $tanggal = date('Y-m-d');
    $jam = date('H:i:s');

    if ($nama_header == NULL) {
      $nama_jasa = $nama_pemeriksaan;
    }
    else{
      $query_setup = $db->query("SELECT nama_pemeriksaan FROM setup_hasil WHERE id = '$nama_header'");
      $data_setup = mysqli_fetch_array($query_setup);

      $query_jasa_lab = $db->query("SELECT nama FROM jasa_lab WHERE id = '$data_setup[nama_pemeriksaan]'");
      $data_jasa_lab = mysqli_fetch_array($query_jasa_lab);
      $nama_jasa = $data_jasa_lab['nama'];
    }



    $query =$db->prepare("UPDATE tbs_hasil_lab SET analis = ? WHERE id = ?");

    $query->bind_param("si",
    $input_nama, $id);

    $query->execute();

        if (!$query){
         die('Query Error : '.$db->errno.
         ' - '.$db->error);
        }
        else{
        }




  // INSERT FEE ANALIS JASA LAB
    $query_fee_jasa_lab = $db->query("SELECT jumlah_prosentase, jumlah_uang FROM fee_produk WHERE nama_petugas = '$input_nama' AND kode_produk = '$kode_jasa'");
    $jumlah__fee_jasa_lab = mysqli_num_rows($query_fee_jasa_lab);
    $data_fee_jasa_lab = mysqli_fetch_array($query_fee_jasa_lab);

    if ($jumlah__fee_jasa_lab > 0){

        if ($data_fee_jasa_lab['jumlah_prosentase'] != 0 AND $data_fee_jasa_lab['jumlah_uang'] == 0 ){

            $hasil_hitung_fee_persen_analis = $harga_jasa * $data_fee_jasa_lab['jumlah_prosentase'] / 100;

            $query_tbs_fee = $db->query("SELECT nama_petugas FROM tbs_fee_produk WHERE nama_petugas = '$input_nama' AND kode_produk = '$kode_jasa' AND kode_produk = '$kode_jasa' AND no_reg = '$no_reg'");
            $jumlah_tbs_fee = mysqli_num_rows($query_tbs_fee);


            if ($jumlah_tbs_fee > 0) {

                $query_update_fee =$db->prepare("UPDATE tbs_fee_produk SET nama_petugas = ?, jumlah_fee = ? WHERE no_reg = ? AND kode_produk = ?");

                $query_update_fee->bind_param("siss",
                $input_nama, $hasil_hitung_fee_persen_analis, $no_reg, $kode_jasa);

                $query_update_fee->execute();

                if (!$query_update_fee){
                 die('Query Error : '.$db->errno.
                 ' - '.$db->error);
                }
                else{
                }

            }
            else{

                $query_hapus_fee_produk = $db->query("DELETE FROM tbs_fee_produk WHERE no_reg = '$no_reg' AND nama_petugas = '$nama_lama' AND kode_produk = '$kode_jasa' ");

                $query_insert_fee = "INSERT INTO tbs_fee_produk (no_reg,session_id,no_rm,nama_petugas,kode_produk,nama_produk,jumlah_fee,tanggal,jam) VALUES ('$no_reg','$session_id','$no_rm','$input_nama','$kode_jasa','$nama_jasa','$hasil_hitung_fee_persen_analis','$tanggal','$jam')";
                    
                    if ($db->query($query_insert_fee) === TRUE) {
                    
                    } 
                    else 
                    {
                    echo "Error: " . $query_insert_fee . "<br>" . $db->error;
                    }

            }


          }
        else{

            $hasil_hitung_fee_nominal_analis = $data_fee_jasa_lab['jumlah_uang'] * 1;

            $query_tbs_fee = $db->query("SELECT nama_petugas FROM tbs_fee_produk WHERE nama_petugas = '$input_nama' AND kode_produk = '$kode_jasa' AND no_reg = '$no_reg'");
            $jumlah_tbs_fee = mysqli_num_rows($query_tbs_fee);


            if ($jumlah_tbs_fee > 0) {

              $query_update_fee =$db->prepare("UPDATE tbs_fee_produk SET nama_petugas = ?, jumlah_fee = ? WHERE no_reg = ? AND kode_produk = ?");

              $query_update_fee->bind_param("siss",
              $input_nama, $hasil_hitung_fee_nominal_analis, $no_reg, $kode_jasa);

              $query_update_fee->execute();

              if (!$query_update_fee){
               die('Query Error : '.$db->errno.
               ' - '.$db->error);
              }
              else{
              }

            }
            else{

              $query_hapus_fee_produk = $db->query("DELETE FROM tbs_fee_produk WHERE no_reg = '$no_reg' AND nama_petugas = '$nama_lama' AND kode_produk = '$kode_jasa' ");

              $query_insert_fee = "INSERT INTO tbs_fee_produk (no_reg,session_id,no_rm,nama_petugas,kode_produk,nama_produk,jumlah_fee,tanggal,jam) VALUES ('$no_reg','$session_id','$no_rm','$input_nama','$kode_jasa','$nama_jasa','$hasil_hitung_fee_nominal_analis','$tanggal','$jam')";
                
                if ($db->query($query_insert_fee) === TRUE) {          
                } 
                else
                {
                echo "Error: " . $query_insert_fee . "<br>" . $db->error;
                }

            }

          }


    }
    else{


      $query_hapus_fee_produk = $db->query("DELETE FROM tbs_fee_produk WHERE no_reg = '$no_reg' AND nama_petugas = '$nama_lama' AND kode_produk = '$kode_jasa' ");
    }
  // END INSERT FEE ANALIS JASA LAB


  $query_ambil_nama = $db->query("SELECT nama FROM user WHERE id = '$input_nama'");
    $data_nama = mysqli_fetch_array($query_ambil_nama);
   echo $nama = $data_nama['nama'];
?>