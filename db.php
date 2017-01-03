<?php date_default_timezone_set("Asia/Jakarta");




$servername = "localhost";
$username = "root";
$password = "";
$db = "local_simklinik";

$conn = mysqli_connect($servername, $username, $password, $db) or die("Connection failed: " . mysqli_connect_error());

// perintah untuk mengkoneksikan php ke database mysql

$db = new mysqli('localhost','root','','local_simklinik');


// Check connection
if ($db->connect_error) {
    die("Connection failed: " . $db->connect_error);
}



$servername_pasien = "localhost";
$username_pasien = "root";
$password_pasien = "";
$dbname_pasien = "local_simklinik";

$conn_pasien = mysqli_connect($servername_pasien, $username_pasien, $password_pasien, $dbname_pasien) or die("Connection failed: " . mysqli_connect_error());

// perintah untuk mengkoneksikan php ke database mysql

$db_pasien = new mysqli('localhost','root','','local_simklinik');


// Check connection
if ($db->connect_error) {
    die("Connection failed: " . $db_pasien->connect_error);
}


?>