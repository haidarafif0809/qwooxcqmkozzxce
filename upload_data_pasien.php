<?php 
include 'db.php';
include 'sanitasi.php';

$target_dir = "csv_user/";
$target_file = $target_dir . basename($_FILES["csv_pasien"]["name"]);
$uploadOk = 1;
$imageFileType = pathinfo($target_file,PATHINFO_EXTENSION);

if($imageFileType != "csv") {
    echo "<center><h2>Maaf, hanya file berekstensi csv yang boleh di upload</h2></center>";
   
}

else {

    if (is_uploaded_file($_FILES['csv_pasien']['tmp_name'])) {
            echo "<center><h1>" . "File ". $_FILES['csv_pasien']['name'] ." Berhasil di Import ke Database" . "</h1><br>
            
            <h2><a href='pasien.php'>Kembali Ke Halaman Sebelumnya</a></h2></center>";      
        }
        //Import uploaded file to Database, Letakan dibawah sini..
        $handle = fopen($_FILES['csv_pasien']['tmp_name'], "r"); //Membuka file dan membacanya
        while (($data = fgetcsv($handle, 4142374, ",")) !== FALSE) {
               
               
                
            $import = "INSERT INTO pelanggan (no_rm_lama,nama_pelanggan,tgl_lahir,alamat_sekarang,no_telp,jenis_kelamin) 

            VALUES ('$data[0]','$data[1]','$data[2]','$data[3]','$data[4]','$data[5]')"; //data array sesuaikan dengan jumlah kolom pada CSV anda mulai dari “0” bukan “1”
            //Melakukan Import
            if ($db_pasien->query($import) === TRUE)  
            {
            } 
            else 
            {
            echo "Error: " . $import . "<br>" . $db_pasien->error;
            }

        }
        fclose($handle); //Menutup CSV file
        echo "<h2><center><br><strong>Import data selesai.</strong></center><h2>";
    }



 ?>
