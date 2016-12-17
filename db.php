<?php date_default_timezone_set("Asia/Jakarta");

$servername = "localhost";
$username = "demoo";
$password = "asdakgnadjfbdfnkb34r3cff3";
$dbname = "rs_mputri";

$conn = mysqli_connect($servername, $username, $password, $dbname) or die("Connection failed: " . mysqli_connect_error());

// perintah untuk mengkoneksikan php ke database mysql
$db = new mysqli('localhost','demoo','asdakgnadjfbdfnkb34r3cff3','rs_mputri');


// Check connection
if ($db->connect_error) {
    die("Connection failed: " . $db->connect_error);
}


?>