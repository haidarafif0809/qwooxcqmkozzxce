<?php include 'session_login.php';
/* Database connection start */
include 'sanitasi.php';
include 'db.php';

/* Database connection end */

$no_reg = stringdoang($_POST['no_reg']);

// storing  request (ie, get/post) global array to a variable  
$requestData= $_REQUEST;



$columns = array( 
// datatable column index  => database column name

    0=>'kode_barang', 
    1=>'nama_barang',
    2=>'jumlah_barang',
    3=>'harga',
    4=>'subtotal',
    5=>'potongan',
    6=>'tax',
    7=>'jam',
    8=>'id'    

);

// getting total number records without any search
$sql =" SELECT kode_barang, nama_barang, jumlah_barang, harga, subtotal, potongan, tax, jam, id";
$sql.=" FROM tbs_penjualan ";
$sql.=" WHERE no_reg = '$no_reg' AND lab = 'Laboratorium' AND no_faktur IS NULL";

$query = mysqli_query($conn, $sql) or die("eror 1");
$totalData = mysqli_num_rows($query);
$totalFiltered = $totalData;  // when there is no search parameter then total number rows = total number filtered rows.

if( !empty($requestData['search']['value']) ) {   // if there is a search parameter, $requestData['search']['value'] contains search parameter
$sql =" SELECT kode_barang, nama_barang, jumlah_barang, harga, subtotal, potongan, tax, jam, id";
$sql.=" FROM tbs_penjualan ";
$sql.=" WHERE no_reg = '$no_reg' AND lab = 'Laboratorium' AND no_faktur IS NULL";

    $sql.=" AND (kode_barang LIKE '".$requestData['search']['value']."%'";  
    $sql.=" OR nama_barang LIKE '".$requestData['search']['value']."%' )";

}


$query=mysqli_query($conn, $sql) or die("eror 2");
$totalFiltered = mysqli_num_rows($query); // when there is a search parameter then we have to modify total number filtered rows as per search result. 
        
$sql.=" ORDER BY kode_barang ".$requestData['order'][0]['dir']."  LIMIT ".$requestData['start']." ,".$requestData['length']."   ";

/* $requestData['order'][0]['column'] contains colmun index, $requestData['order'][0]['dir'] contains order such as asc/desc  */    
$query=mysqli_query($conn, $sql) or die("eror 3");


$data = array();
while( $row=mysqli_fetch_array($query) ) {  // preparing an array
  $nestedData=array(); 

      $nestedData[] = $row["kode_barang"];
      $nestedData[] = $row["nama_barang"];

      $kd = $db->query("SELECT f.nama_petugas, u.nama FROM tbs_fee_produk f LEFT JOIN user u ON f.nama_petugas = u.id WHERE f.kode_produk = '$row[kode_barang]' AND f.jam = '$row[jam]' ");

      $kdD = $db->query("SELECT f.nama_petugas, u.nama FROM tbs_fee_produk f LEFT JOIN user u ON f.nama_petugas = u.id WHERE f.kode_produk = '$row[kode_barang]' AND f.jam = '$row[jam]' ");

      $nu = mysqli_fetch_array($kd);

        if ($nu['nama'] != '')
        {

          while($nur = mysqli_fetch_array($kdD))
          {
            $nestedData[] = $nur["nama"]." ,";
          }

        }

        else
        {
           $nestedData[] = "";
        }

      $nestedData[] = $row["jumlah_barang"];
      $nestedData[] = $row["harga"];
      $nestedData[] = $row["subtotal"];
      $nestedData[] = $row["potongan"];
      $nestedData[] = $row["tax"];

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