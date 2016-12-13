<?php date_default_timezone_set("Asia/Jakarta");

$servername = "localhost";
$username = "root";
$password = "";
$dbname = "aplikasi_sim_klinik";

$conn = mysqli_connect($servername, $username, $password, $dbname) or die("Connection failed: " . mysqli_connect_error());

// perintah untuk mengkoneksikan php ke database mysql
$db = new mysqli('localhost','root','','aplikasi_sim_klinik');


// Check connection
if ($db->connect_error) {
    die("Connection failed: " . $db->connect_error);
}


?>