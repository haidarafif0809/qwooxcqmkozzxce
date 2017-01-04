<?php date_default_timezone_set("Asia/Jakarta");

$servername = "localhost";
$username = "root";
$password = "";
$dbname = "aplikasi_simklinik";

$conn = mysqli_connect($servername, $username, $password, $dbname) or die("Connection failed: " . mysqli_connect_error());

// perintah untuk mengkoneksikan php ke database mysql
$db = new mysqli('localhost','root','','aplikasi_simklinik');


// Check connection
if ($db->connect_error) {
    die("Connection failed: " . $db->connect_error);
}


$servername_pasien = "localhost";
$username_pasien = "root";
$password_pasien = "";
$dbname_pasien = "db_pasien";

$conn_pasien = mysqli_connect($servername_pasien, $username_pasien, $password_pasien, $dbname_pasien) or die("Connection failed: " . mysqli_connect_error());

// perintah untuk mengkoneksikan php ke database mysql
$db_pasien = new mysqli('localhost','root','','db_pasien');


// Check connection
if ($db_pasien->connect_error) {
    die("Connection failed: " . $db_pasien->connect_error);
}

?>