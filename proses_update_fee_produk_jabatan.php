<?php session_start();
 
    include 'sanitasi.php';
    include 'db.php';



$jabatan = stringdoang($_POST['jabatan']);
$kode_produk = stringdoang($_POST['kode_produk']);


$querdo = $db->query("SELECT fee_produk.kode_produk , fee_produk.nama_produk ,fee_produk.jumlah_prosentase ,fee_produk.jumlah_uang ,user.jabatan ,user.id FROM fee_produk INNER JOIN user ON fee_produk.nama_petugas = user.id WHERE user.jabatan = '$jabatan' AND  fee_produk.kode_produk = '$kode_produk'");
$og = mysqli_num_rows($querdo);
if ($og > 0 )
{

while($sd = mysqli_fetch_array($querdo))
    {
        $perintah = $db->prepare("UPDATE fee_produk SET jumlah_prosentase = ?, jumlah_uang = ?, user_edit = ? WHERE kode_produk = ? AND nama_petugas = ?");
        

        $perintah->bind_param("sssss",
        $jumlah_prosentase, $jumlah_nominal, $user, $sd['kode_produk'], $sd['id']);

        $jumlah_prosentase = angkadecimal($_POST['jumlah_prosentase']);
        $jumlah_nominal = angkadoang($_POST['jumlah_uang']);
        $user = $_SESSION['user_name'];

        
        $perintah->execute();
        
        if (!$perintah) {
        die('Query Error : '.$db->errno.
        ' - '.$db->error);
        }
        else 
        
        {
        echo '<div class="alert alert-success" id="alert_berhasil" style="display:none">
        <strong>Sukses!</strong> Edit Berhasil
        </div>';
        }
    }
}
else
{
    echo '<div class="alert alert-danger" id="alert_berhasil" style="display:none">
        <strong>Gagal!</strong> Produk Belum Ada Di Komisi Produk !
        </div>';
}



//Untuk Memutuskan Koneksi Ke Database
mysqli_close($db);   


?>