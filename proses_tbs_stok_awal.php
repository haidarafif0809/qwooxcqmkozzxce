<?php 
        // memasukan file yang ada pada db.php
        include 'sanitasi.php';
        include 'db.php';

        // mengirim data sesuai variabel yang ada dengan menggunakan metode POST
        
        $kode_barang = stringdoang($_POST['kode_barang']);
        $hpp = stringdoang($_POST['hpp']);
        $tahun_sekarang = date('Y');
        $bulan_sekarang = date('m');
        $tanggal_sekarang = date('Y-m-d');
        $jam_sekarang = date('H:i:s');
        $tahun_terakhir = substr($tahun_sekarang, 2);


if ($hpp == "") {
  
      $select2 = $db->query("SELECT harga FROM detail_pembelian WHERE kode_barang = '$kode_barang' ORDER BY id DESC LIMIT 1");
      $num_rows = mysqli_num_rows($select2);
      $fetc_array = mysqli_fetch_array($select2);

      $select3 = $db->query("SELECT harga_beli FROM barang WHERE kode_barang = '$kode_barang' ORDER BY id DESC LIMIT 1");
      $ambil_barang = mysqli_fetch_array($select3);

      if ($num_rows == 0) {

        $harga = $ambil_barang['harga_beli'];

      } 

      else {

        $harga = $fetc_array['harga'];

      }


}

else{

  $harga = $hpp;
}


            
            $perintah = $db->prepare("INSERT INTO tbs_stok_awal (session_id, kode_barang, nama_barang, jumlah_awal, satuan, harga, total, jam, tanggal) 
            VALUES (?,?,?,?,?,?,?,?,?)");
            
            $perintah->bind_param("sssisiiss",
              $session_id, $kode_barang, $nama_barang, $jumlah_awal, $satuan, $harga, $total, $jam_sekarang, $tanggal_sekarang);

            $kode_barang = stringdoang($_POST['kode_barang']);
            $nama_barang = stringdoang($_POST['nama_barang']);
            $jumlah_awal = angkadoang($_POST['jumlah_awal']);
            $session_id = stringdoang($_POST['session_id']);
            $satuan = stringdoang($_POST['satuan']);
            $total = $harga * $jumlah_awal;

       
          
            $perintah->execute();

            if (!$perintah) {
            die('Query Error : '.$db->errno.
            ' - '.$db->error);
            }
            else {
            
            }
  
    ?>
 <table id="tableuser" class="table table-bordered">
    <thead>
     
      <th> Kode Barang </th>
      <th> Nama Barang </th>
      <th> Jumlah Awal </th>
      <th> Satuan </th>
      <th> Harga </th>
      <th> Total </th>
  
      <th> Hapus </th>
      <th> Edit </th>
    </thead>
    <tbody>
    <?php
  // menampilkan data pada tabel tbs pembelian berdasarkan no_faktur
    $perintah = $db->query("SELECT * FROM tbs_stok_awal");
    //menyimpan data sementara berdasarkan perintah $perintah
    while ($data1 = mysqli_fetch_array($perintah))
    {
        //menampilkan data
        echo "<tr>
      
      <td>". $data1['kode_barang'] ."</td>
      <td>". $data1['nama_barang'] ."</td>
      <td>". $data1['jumlah_awal'] ."</td>
      <td>". $data1['satuan'] ."</td>
      <td>". $data1['harga'] ."</td>
      <td>". $data1['total'] ."</td>

      <!-- membuat link hapus yang akan menuju ke hapususer.php -->
      <td> <button class='btn btn-danger btn-hapus' data-id='". $data1['id'] ."' data-kode-barang='". $data1['kode_barang'] ."' data-nama-barang='". $data1['nama_barang'] ."'> Hapus </button> </td> 
      
      <!-- membuat link edit yang akan menuju ke edit user.php -->
      <td> <button class='btn btn-info btn-edit' data-id='". $data1['id'] ."' data-kode-barang='". $data1['kode_barang'] ."' data-jumlah-lama='". $data1['jumlah_awal'] ."' data-harga='". $data1['harga'] ."'> Edit </button> </td>
      </tr>";
    }

//Untuk Memutuskan Koneksi Ke Database
mysqli_close($db);   

    ?>
    </tbody>
  </table>