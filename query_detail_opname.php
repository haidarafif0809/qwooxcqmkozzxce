<?php 
include 'db.php';

$select = $db-> query("SELECT kode_barang FROM detail_stok_opname");
while($out = mysqli_fetch_array($select))
{
	$kode_barang = $out['kode_barang'];

	$query1 = $db->query("SELECT SUM(jumlah_barang) AS masuk FROM detail_pembelian WHERE kode_barang = '$kode_barang'");
        $hasil1 = mysqli_fetch_array($query1);
        $jumlah_masuk_pembelian = $hasil1['masuk'];


        $query3 = $db->query("SELECT SUM(jumlah) AS masuk FROM detail_item_masuk WHERE kode_barang = '$kode_barang'");
        $hasil2 = mysqli_fetch_array($query3);
        $jumlah_masuk_item_masuk = $hasil2['masuk'];



        $hasil_masuk = $jumlah_masuk_pembelian + $jumlah_masuk_item_masuk;
        if ($hasil_masuk == '')
        {
        	$hasil_masuk = 0;
        }


        $query4 = $db->query("SELECT SUM(jumlah_barang) AS keluar FROM detail_penjualan WHERE kode_barang = '$kode_barang'");
        $hasil3 = mysqli_fetch_array($query4);
        $jumlah_keluar_penjualan = $hasil3['keluar'];


        $query5 = $db->query("SELECT SUM(jumlah) AS keluar FROM detail_item_keluar WHERE kode_barang = '$kode_barang'");
        $hasil4 = mysqli_fetch_array($query5);
        $jumlah_keluar_item_keluar = $hasil4['keluar'];

        $hasil_keluar = $jumlah_keluar_penjualan + $jumlah_keluar_item_keluar;
    if ($hasil_keluar == '')
        {
        	$hasil_keluar = 0;
        }


        $cek = $db->query("SELECT * FROM stok_awal WHERE kode_barang = '$kode_barang' ");
        $data = mysqli_fetch_array($cek);
        $num = mysqli_num_rows($cek);

        if ($num > 0 )
        {
                  $stok_awal = $data['jumlah_awal'];

        }
        else {
          $stok_awal = 0;
        }

        $update = $db->query("UPDATE detail_stok_opname SET awal = '$stok_awal', masuk = '$hasil_masuk', keluar = '$hasil_keluar' WHERE kode_barang = '$kode_barang'");

	
}

?>
