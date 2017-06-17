<?php include 'session_login.php';

include 'sanitasi.php';
include 'db.php';

$no_reg = stringdoang($_POST['no_reg']);

$pilih_akses_tombol = $db->query("SELECT input_jasa_lab FROM otoritas_laboratorium WHERE id_otoritas = '$_SESSION[otoritas_id]' ");
$otoritas_tombol = mysqli_fetch_array($pilih_akses_tombol);


$requestData= $_REQUEST;

$columns = array( 
    
    0=>'kode_jasa',
    1=>'nama_jasa',
    2=>'komisi',
    3=>'dokter',
    4=>'analis',
    5=>'tanggal',
    6=>'jam',
    7=>'hapus',
    8=>'id'
);

$sql =" SELECT tbs.kode_jasa,tbs.nama_jasa,u.nama AS dokter,us.nama AS analis,tbs.harga,tbs.tanggal,tbs.jam,tbs.id";
$sql.=" FROM tbs_aps_penjualan tbs LEFT JOIN user u ON tbs.dokter = u.id LEFT JOIN user us ON tbs.analis = us.id";
$sql.=" WHERE tbs.no_reg = '$no_reg' AND (tbs.no_faktur IS NULL OR tbs.no_faktur = '')";

$query = mysqli_query($conn, $sql) or die("eror 1");
$totalData = mysqli_num_rows($query);
$totalFiltered = $totalData;  // when there is no search parameter then total number rows = total number filtered rows.

if( !empty($requestData['search']['value']) ) {   // if there is a search parameter, $requestData['search']['value'] contains search parameter
$sql =" SELECT tbs.kode_jasa,tbs.nama_jasa,u.nama AS dokter,us.nama AS analis,tbs.harga,tbs.tanggal,tbs.jam,tbs.id";
$sql.=" FROM tbs_aps_penjualan tbs LEFT JOIN user u ON tbs.dokter = u.id LEFT JOIN user us ON tbs.analis = us.id";
$sql.=" WHERE tbs.no_reg = '$no_reg' AND (tbs.no_faktur IS NULL OR tbs.no_faktur = '')";

  $sql.=" AND (tbs.kode_jasa LIKE '".$requestData['search']['value']."%'";  
  $sql.=" OR dokter LIKE '".$requestData['search']['value']."%' ";
  $sql.=" OR analis LIKE '".$requestData['search']['value']."%' ";
  $sql.=" OR tbs.nama_jasa LIKE '".$requestData['search']['value']."%' )";

    $query=mysqli_query($conn, $sql) or die("eror 2");

    $totalFiltered = mysqli_num_rows($query);

}


 // when there is a search parameter then we have to modify total number filtered rows as per search result. 
        
$sql.=" ORDER BY tbs.id DESC LIMIT ".$requestData['start']." ,".$requestData['length']."   ";

/* $requestData['order'][0]['column'] contains colmun index, $requestData['order'][0]['dir'] contains order such as asc/desc  */    
$query=mysqli_query($conn, $sql) or die("eror 3");


$data = array();

while( $row = mysqli_fetch_array($query) ) {  // preparing an array
  $nestedData = array(); 


      $nestedData[] = $row["kode_jasa"];
      $nestedData[] = $row["nama_jasa"];

      //TBS FEE
      $query_tbs_fee = $db->query("SELECT f.nama_petugas, u.nama FROM tbs_fee_produk f LEFT JOIN user u ON f.nama_petugas = u.id WHERE f.kode_produk = '$row[kode_jasa]' AND f.jam = '$row[jam]' ");

      $nama_fee = "<p style='font-size:15px;'> ";
      while($data_fee = mysqli_fetch_array($query_tbs_fee))
        {
          $nama_fee .= "".$data_fee["nama"].", ";
        }
        $nama_fee .= "</p>";
      //END TBS FEE
      $nestedData[] = $nama_fee; //Tampilan TBS FEE
      $nestedData[] = $row["dokter"];
      $nestedData[] = $row["analis"];
      $nestedData[] = $row["tanggal"];
      $nestedData[] = $row["jam"];

      if ($otoritas_tombol['input_jasa_lab'] > 0) {

          $nestedData[] = "<button class='btn btn-danger btn-sm btn-hapus-tbs' id='hapus-tbs-". $row['id'] ."' data-id='". $row['id'] ."' data-kode='". $row['kode_jasa'] ."' data-barang='". $row['nama_jasa'] ."'>Hapus</button>";
      }

      
      $nestedData[] = $row["id"];

  $data[] = $nestedData;
}



$json_data = array(
            "draw"            => intval( $requestData['draw'] ),   // for every request/draw by clientside , they send a number as a parameter, when they recieve a response/data they first check the draw number, so we are sending same number in draw. 
            "recordsTotal"    => intval( $totalData ),  // total number of records
            "recordsFiltered" => intval( $totalFiltered ), // total number of records after searching, if there is no searching then totalFiltered = totalData
            "data"            => $data   // total data array
            );

echo json_encode($json_data);  // send data as json format

 ?>