<?php 
    // memasukan file yang ada pada db.php
    include 'db.php';
    include 'sanitasi.php';
    // mengirim data sesuai variabel yang ada dengan menggunakan metode POST
    $no_faktur = stringdoang($_POST['no_faktur']);
    $kode_barang = stringdoang($_POST['kode_barang']);
    $nama_barang = stringdoang($_POST['nama_barang']);
    $jumlah_barang = stringdoang($_POST['jumlah_barang']);
    $harga_update = stringdoang($_POST['harga_baru']);
    $harga_baru = str_replace(",",".",$harga_update);
    $satuan = stringdoang($_POST['satuan']);
    $harga = stringdoang($_POST['harga']);
    $potongan = stringdoang($_POST['potongan']);
    $tax = stringdoang($_POST['tax']);
    $satu = 1;

     if ( $harga != $harga_baru) {

      $query00 = $db->query("UPDATE barang SET harga_beli = '$harga_baru' WHERE kode_barang = '$kode_barang'");
      $harga = $harga_baru;
    }



    $a = $harga * $jumlah_barang;

    $x = $a - $potongan;

    $hasil_tax = $satu + ($tax / 100);

    $hasil_tax2 = $x / $hasil_tax;

    $tax1 = $x - $hasil_tax2;

    $tax = round($tax1);
    
    $subtotal = $harga * $jumlah_barang - $potongan;



    // menampilkan data yang ada dari tabel tbs_pembelian berdasarkan kode barang
    $cek = $db->query("SELECT * FROM tbs_pembelian WHERE kode_barang = '$kode_barang' AND no_faktur = '$no_faktur'");

    // menyimpan data sementara berupa baris yang dijalankan dari $cek
    $jumlah = mysqli_num_rows($cek);
    
    // jika $jumlah >0 maka akan menjalakan perintah $query1 jika tidak maka akan menjalankan perintah $perintah
    
    if ($jumlah > 0)
    {
        # code...
        $query1 = $db->query("UPDATE tbs_pembelian SET jumlah_barang = jumlah_barang + '$jumlah_barang', subtotal = subtotal + '$subtotal' WHERE kode_barang = '$kode_barang' AND no_faktur = '$no_faktur'");

    }

    else

    {
        $perintah = "INSERT INTO tbs_pembelian (no_faktur,kode_barang,nama_barang,jumlah_barang,satuan,harga,subtotal,potongan,tax)VALUES ('$no_faktur','$kode_barang','$nama_barang','$jumlah_barang','$satuan','$harga','$subtotal','$potongan','$tax')";
        
        if ($db->query($perintah) === TRUE)
        {
        }
        else
        {
            echo "Error: " . $perintah . "<br>" . $db->error;
        }

    }

    ?>