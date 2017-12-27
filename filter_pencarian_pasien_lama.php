<?php
/* Database connection start */
include 'db.php';
include 'sanitasi.php';

$nama_lengkap_pasien  = stringdoang($_GET['nama_lengkap_pasien']);
$no_rm_pasien         = stringdoang($_GET['no_rm_pasien']);
$alamat_pasien        = stringdoang($_GET['alamat_pasien']);
$tanggal_lahir_pasien = stringdoang($_GET['tanggal_lahir_pasien']) != "" ? tanggal_mysql($_GET['tanggal_lahir_pasien']) : "";

function queryPencarian($nama_lengkap_pasien, $alamat_pasien, $tanggal_lahir_pasien, $no_rm_pasien)
{
    $sql_pencarian = "";
    if ($no_rm_pasien != "") {
        $sql_pencarian .= "kode_pelanggan LIKE '%$no_rm_pasien%'";
    }
    if ($nama_lengkap_pasien != "") {
        if ($no_rm_pasien != "") {
            $sql_pencarian .= " AND ";
        }
        $sql_pencarian .= "nama_pelanggan LIKE '%$nama_lengkap_pasien%'";
    }
    if ($alamat_pasien != "") {

        if ($nama_lengkap_pasien != "") {
            $sql_pencarian .= " AND ";
        }
        $sql_pencarian .= "alamat_sekarang LIKE '%$alamat_pasien%'";
    }

    if ($tanggal_lahir_pasien != "") {
        if ($nama_lengkap_pasien != "" or $alamat_pasien != "") {
            $sql_pencarian .= " AND ";
        }
        $sql_pencarian .= " tgl_lahir = '$tanggal_lahir_pasien'";
    }
    return $sql_pencarian;
}

// storing  request (ie, get/post) global array to a variable
$requestData = $_REQUEST;

$columns = array(
// datatable column index  => database column name
    0 => 'kode_pelanggan',
    1 => 'nama_pelanggan',
    2 => 'jenis_kelamin',
    3 => 'alamat_sekarang',
    4 => 'tgl_lahir',
    5 => 'gol_darah',
    6 => 'no_telp',
    7 => 'penjamin',

);

// getting total number records without any search
$sql = "SELECT COUNT(*) AS jumlah_pasien ";
$sql .= " FROM pelanggan WHERE kode_pelanggan != '' AND ";
$sql_pencarian = queryPencarian($nama_lengkap_pasien, $alamat_pasien, $tanggal_lahir_pasien, $no_rm_pasien);
$sql .= $sql_pencarian;
$query         = mysqli_query($conn_pasien, $sql) or die("eror 1");
$totalData     = mysqli_fetch_array($query);
$totalData     = $totalData['jumlah_pasien'];
$totalFiltered = $totalData;

$sql = "SELECT penjamin,kode_pelanggan,nama_pelanggan,jenis_kelamin,alamat_sekarang,tgl_lahir,no_telp,gol_darah ";
$sql .= " FROM pelanggan WHERE 1=1 AND kode_pelanggan != '' AND ";
$sql .= $sql_pencarian;

if (!empty(urldecode($requestData['search_value']))) {
    // if there is a search parameter, urldecode($requestData['search_value']) contains search parameter
    $sql .= " AND ( kode_pelanggan LIKE '" . urldecode($requestData['search_value']) . "%' ";
    $sql .= " OR nama_pelanggan LIKE '" . urldecode($requestData['search_value']) . "%' ";
    $sql .= " OR alamat_sekarang LIKE '" . urldecode($requestData['search_value']) . "%' ";
}
$query         = mysqli_query($conn_pasien, $sql) or die("eror 2");
$totalFiltered = mysqli_num_rows($query); // when there is a search parameter then we have to modify total number filtered rows as per search result.
$sql .= " ORDER BY id DESC LIMIT " . $requestData['start'] . " ," . $requestData['length'] . "   ";
/* $requestData['order'][0]['column'] contains colmun index, $requestData['order'][0]['dir'] contains order such as asc/desc  */
$query = mysqli_query($conn_pasien, $sql) or die("eror 3");

$data = array();
while ($row = mysqli_fetch_array($query)) {
    // preparing an array
    $nestedData = array();

    $nestedData[] = $row["kode_pelanggan"];
    $nestedData[] = $row["nama_pelanggan"];
    $nestedData[] = $row["jenis_kelamin"];
    $nestedData[] = $row["alamat_sekarang"];
    $nestedData[] = tanggal_terbalik($row["tgl_lahir"]);
    $nestedData[] = $row["gol_darah"];
    $nestedData[] = $row["no_telp"];
    $nestedData[] = $row["penjamin"];

    $data[] = $nestedData;
}

$json_data = array(
    "draw"            => intval($requestData['draw']), // for every request/draw by clientside , they send a number as a parameter, when they recieve a response/data they first check the draw number, so we are sending same number in draw.
    "recordsTotal"    => intval($totalData), // total number of records
    "recordsFiltered" => intval($totalFiltered), // total number of records after searching, if there is no searching then totalFiltered = totalData
    "data"            => $data, // total data array
);

if (isset($_GET['callback'])) {
    // Validate the JSONP to make use it is an okay Javascript function to execute
    $jsonp = preg_match('/^[$A-Z_][0-9A-Z_$]*$/i', $_GET['callback']) ?
    $_GET['callback'] :
    false;

    if ($jsonp) {
        echo $jsonp . '(' . json_encode($json_data) . ');';
    }
} else {
    echo json_encode($json_data); // send data as json format
}
