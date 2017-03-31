<?php 
    // memasukan file yang ada pada db.php
    include 'db.php';
    include 'sanitasi.php';
    // mengirim data sesuai variabel yang ada dengan menggunakan metode POST
    $no_faktur = stringdoang($_POST['no_faktur']);
    $kode_barang = stringdoang($_POST['kode_barang']);
    $nama_barang = stringdoang($_POST['nama_barang']);
    $jumlah_barang = angkadoang($_POST['jumlah_barang']);
    $harga_baru = angkadoang($_POST['harga_baru']);

    $satuan = stringdoang($_POST['satuan']);
    $harga = angkadoang($_POST['harga']);
    $potongan = angkadoang($_POST['potongan']);
    $tax = angkadoang($_POST['tax']);
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

    <?php

              //untuk menampilkan semua data yang ada pada tabel tbs pembelian dalam DB
          $perintah = $db->query("SELECT tp.id, tp.no_faktur, tp.session_id, tp.kode_barang, tp.nama_barang, tp.jumlah_barang, tp.satuan, tp.harga, tp.subtotal, tp.potongan, tp.tax, s.nama FROM tbs_pembelian tp INNER JOIN satuan s ON tp.satuan = s.id WHERE tp.no_faktur = '$no_faktur' ORDER BY tp.id DESC LIMIT 1");

          //menyimpan data sementara yang ada pada $perintah
           $data1 = mysqli_fetch_array($perintah);
            

              // menampilkan data
            echo "<tr class='tr-id-". $data1['id'] ."'>
            <td>". $data1['no_faktur'] ."</td>
            <td>". $data1['kode_barang'] ."</td>
            <td>". $data1['nama_barang'] ."</td>";

      $pilih = $db->query("SELECT no_faktur_pembelian FROM detail_retur_pembelian WHERE no_faktur_pembelian = '$data1[no_faktur]' AND kode_barang = '$data1[kode_barang]'");
      $row_retur = mysqli_num_rows($pilih);

       $hpp_masuk_pembelian = $db->query ("SELECT no_faktur FROM hpp_masuk WHERE no_faktur = '$no_faktur' AND sisa != jumlah_kuantitas AND kode_barang = '$data1[kode_barang]'");
       $row_hpp_masuk = mysqli_num_rows($hpp_masuk_pembelian);


      $pilih = $db->query("SELECT no_faktur_pembelian FROM detail_pembayaran_hutang WHERE no_faktur_pembelian = '$data1[no_faktur]'");
      $row_hutang = mysqli_num_rows($pilih);

      if ($row_retur > 0 || $row_hutang > 0 || $row_hpp_masuk > 0 ) {


              echo"<td class='edit-jumlah-alert' data-faktur='".$data1['no_faktur']."' data-kode='".$data1['kode_barang']."'><span id='text-jumlah-".$data1['id']."'>". $data1['jumlah_barang'] ."</span> <input type='hidden' id='input-jumlah-".$data1['id']."' value='".$data1['jumlah_barang']."' class='input_jumlah' data-id='".$data1['id']."' autofocus='' data-kode='".$data1['kode_barang']."' data-harga='".$data1['harga']."' > </td>"; 

      } 

      else {


      echo"<td class='edit-jumlah' data-id='".$data1['id']."' data-faktur='".$data1['no_faktur']."' data-kode='".$data1['kode_barang']."'><span id='text-jumlah-".$data1['id']."'>". $data1['jumlah_barang'] ."</span> <input type='hidden' id='input-jumlah-".$data1['id']."' value='".$data1['jumlah_barang']."' class='input_jumlah' data-id='".$data1['id']."' autofocus='' data-kode='".$data1['kode_barang']."' data-harga='".$data1['harga']."' > </td>"; 

      }

            echo"<td>". $data1['nama'] ."</td>
            <td>". rp($data1['harga']) ."</td>
            <td><span id='text-subtotal-".$data1['id']."'>". $data1['subtotal'] ."</span></td>
            <td><span id='text-potongan-".$data1['id']."'>". $data1['potongan'] ."</span></td>
            <td><span id='text-tax-".$data1['id']."'>". $data1['tax'] ."</span></td>";

      if ($row_retur > 0 || $row_hutang > 0 || $row_hpp_masuk > 0 ) {

            echo "<td> <button class='btn btn-danger btn-alert-hapus' data-id='".$data1['id']."' data-faktur='".$data1['no_faktur']."' data-kode='".$data1['kode_barang']."'><span class='glyphicon glyphicon-trash'></span> Hapus </button></td>";

      } 

      else
      {
            echo "<td> <button class='btn btn-danger btn-sm btn-hapus-tbs' id='hapus-tbs-".$data1['id']."' data-id='". $data1['id'] ."' data-subtotal='".$data1['subtotal']."' data-kode-barang='". $data1['kode_barang'] ."' data-barang='". $data1['nama_barang'] ."'><span class='glyphicon glyphicon-trash'> </span> Hapus </button> </td>";
      }

      echo "</tr>";


//Untuk Memutuskan Koneksi Ke Database
          mysqli_close($db); 
    ?>
