<?php date_default_timezone_set("Asia/Jakarta");

$servername = "localhost";
$username = "klinikko";
$password = "a9%nReXGbw";
$dbname = "sim_teluk";

$conn = mysqli_connect($servername, $username, $password, $dbname) or die("Connection failed: " . mysqli_connect_error());

// perintah untuk mengkoneksikan php ke database mysql
$db = new mysqli('localhost','klinikko','a9%nReXGbw','sim_teluk');


// Check connection
if ($db->connect_error) {
    die("Connection failed: " . $db->connect_error);
}


$servername_pasien = "localhost";
$username_pasien = "klinikko";
$password_pasien = "a9%nReXGbw";
$dbname_pasien = "pasien_kosasih";

$conn_pasien = mysqli_connect($servername_pasien, $username_pasien, $password_pasien, $dbname_pasien) or die("Connection failed: " . mysqli_connect_error());

// perintah untuk mengkoneksikan php ke database mysql
$db_pasien = new mysqli('localhost','klinikko','a9%nReXGbw','pasien_kosasih');


// Check connection
if ($db_pasien->connect_error) {
    die("Connection failed: " . $db_pasien->connect_error);
}

?>