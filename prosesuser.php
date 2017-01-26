<?php session_start();
    include 'db.php';
    include_once 'sanitasi.php';

    $komisi = stringdoang($_POST['komisi']);
    $jabatan= stringdoang($_POST['jabatan']);
    $nama = stringdoang($_POST['nama']);
    $username1 = $_SESSION['nama'];


$perintah = $db->prepare("INSERT INTO user (username,password,nama,alamat,jabatan,otoritas,status,status_sales,tipe) VALUES (?,?,?,?,?,?,?,?,?)");

    $perintah->bind_param("sssssssss",
        $username, $password, $nama, $alamat, $jabatan, $otoritas, $status, $status_sales,$tipe);
        
        $username = stringdoang($_POST['username']);
        $password = enkripsi($_POST['password']);
        $nama = stringdoang($_POST['nama']);
        $alamat = stringdoang($_POST['alamat']);
        $jabatan= stringdoang($_POST['jabatan']);
        $otoritas = stringdoang($_POST['otoritas']);
        $status = stringdoang($_POST['status']);
        $status_sales = stringdoang($_POST['status_sales']);
        $tipe = stringdoang($_POST['tipe']);
    
    $perintah->execute();

    if (!$perintah) 
    {
    die('Query Error : '.$db->errno.
    ' - '.$db->error);
    }
    else 
    {
    }




        if ($komisi == '1'){

            $querdo = $db->query("SELECT kode_produk ,nama_produk ,jumlah_prosentase ,jumlah_uang FROM fee_produk WHERE jabatan = '$jabatan' GROUP BY kode_produk");
            while($sd = mysqli_fetch_array($querdo)){


            $ceking5 = $db->query("SELECT nama_petugas FROM fee_produk WHERE nama_petugas = '$nama' AND kode_produk = '$sd[kode_produk]' ");
            $fee4 = mysqli_num_rows($ceking5);


            $id_u = $db->query("SELECT id FROM user WHERE nama = '$nama'");
            $data_u = mysqli_fetch_array($id_u);


                    if ($fee4['nama_petugas'] != '')
                    {

                    }

                    else
                    {
                       
                    $query = $db->query("INSERT INTO fee_produk (nama_petugas,user_buat,kode_produk,nama_produk,jumlah_prosentase,jumlah_uang,jabatan) VALUES 
                        ('$data_u[id]','$username1','$sd[kode_produk]','$sd[nama_produk]','$sd[jumlah_prosentase]','$sd[jumlah_uang]','$jabatan')");
                    }

            }


        }

                echo '<META HTTP-EQUIV="Refresh" Content="0; URL=user.php">';


//Untuk Memutuskan Koneksi Ke Database
mysqli_close($db);   

    ?>
