<?php include 'session_login.php';
/* Database connection start */
include 'db.php';
include_once 'sanitasi.php';
$dari_tanggal = stringdoang($_POST['dari_tanggal']);
$sampai_tanggal = stringdoang($_POST['sampai_tanggal']);
$cari_berdasarkan = stringdoang($_POST['cari_berdasarkan']);
$pencarian = stringdoang($_POST['pencarian']);
/* Database connection end */


// storing  request (ie, get/post) global array to a variable  
$requestData= $_REQUEST;

$columns = array( 
// datatable column index  => database column name
  0 =>'no_reg', 
  1 => 'nama',
  2=> 'tanggal_periksa',
  3 => 'dokter',
  4=> 'poli',
  5=> 'id'

);

switch ($cari_berdasarkan) {
    case "nama":

// getting total number records without any search
$sql = "SELECT *";
$sql.=" FROM rekam_medik ";
$sql.=" WHERE nama LIKE '%$pencarian%' ";
$sql.=" AND tanggal_periksa >= '$dari_tanggal'";
$sql.=" AND tanggal_periksa <= '$sampai_tanggal' ";
$query = mysqli_query($conn, $sql) or die("eror 1");
$totalData = mysqli_num_rows($query);
$totalFiltered = $totalData;  // when there is no search parameter then total number rows = total number filtered rows.


$sql = "SELECT *";
$sql.=" FROM rekam_medik"; 
$sql.=" WHERE 1=1 ";
$sql.=" AND nama LIKE '%$pencarian%' ";
$sql.=" AND tanggal_periksa >= '$dari_tanggal'";
$sql.=" AND tanggal_periksa <= '$sampai_tanggal' ";

if( !empty($requestData['search']['value']) ) {   // if there is a search parameter, $requestData['search']['value'] contains search parameter
  $sql.=" AND ( no_reg LIKE '".$requestData['search']['value']."%' "; 
  $sql.=" OR no_rm LIKE '".$requestData['search']['value']."%' ";
  $sql.=" OR nama LIKE '".$requestData['search']['value']."%' ";
  $sql.=" OR poli LIKE '".$requestData['search']['value']."%' ";
  $sql.=" OR dokter LIKE '".$requestData['search']['value']."%' ";
  $sql.=" OR tanggal_periksa LIKE '".$requestData['search']['value']."%' )";
}

$query=mysqli_query($conn, $sql) or die("eror 2");
$totalFiltered = mysqli_num_rows($query); // when there is a search parameter then we have to modify total number filtered rows as per search result. 


$sql.=" ORDER BY id ".$requestData['order'][0]['dir']." LIMIT ".$requestData['start']." ,".$requestData['length']."   ";
/* $requestData['order'][0]['column'] contains colmun index, $requestData['order'][0]['dir'] contains order such as asc/desc  */  
$query=mysqli_query($conn, $sql) or die("eror 3");


      $data = array();
      while( $row=mysqli_fetch_array($query) ) {  // preparing an array
        $nestedData=array(); 


            $nestedData[] = $row["no_reg"];
            $nestedData[] = $row["nama"];
            $nestedData[] = $row["tanggal_periksa"];
            $nestedData[] = $row["dokter"]; 
            $nestedData[] = $row["poli"];
            $nestedData[] = $row["id"];    


        $data[] = $nestedData;
        }


        break;
    case "no_rm":

// getting total number records without any search
$sql = "SELECT *";
$sql.=" FROM rekam_medik ";
$sql.=" WHERE no_rm LIKE '%$pencarian%' ";
$sql.=" AND tanggal_periksa >= '$dari_tanggal'";
$sql.=" AND tanggal_periksa <= '$sampai_tanggal' ";
$query = mysqli_query($conn, $sql) or die("eror 1");
$totalData = mysqli_num_rows($query);
$totalFiltered = $totalData;  // when there is no search parameter then total number rows = total number filtered rows.


$sql = "SELECT *";
$sql.=" FROM rekam_medik"; 
$sql.=" WHERE 1=1 ";
$sql.=" AND no_rm LIKE '%$pencarian%' ";
$sql.=" AND tanggal_periksa >= '$dari_tanggal'";
$sql.=" AND tanggal_periksa <= '$sampai_tanggal' ";

if( !empty($requestData['search']['value']) ) {   // if there is a search parameter, $requestData['search']['value'] contains search parameter
  $sql.=" AND ( no_reg LIKE '".$requestData['search']['value']."%' "; 
  $sql.=" OR no_rm LIKE '".$requestData['search']['value']."%' ";
  $sql.=" OR nama LIKE '".$requestData['search']['value']."%' ";
  $sql.=" OR poli LIKE '".$requestData['search']['value']."%' ";
  $sql.=" OR dokter LIKE '".$requestData['search']['value']."%' ";
  $sql.=" OR tanggal_periksa LIKE '".$requestData['search']['value']."%' )";
}

$query=mysqli_query($conn, $sql) or die("eror 2");
$totalFiltered = mysqli_num_rows($query); // when there is a search parameter then we have to modify total number filtered rows as per search result. 


$sql.=" ORDER BY id ".$requestData['order'][0]['dir']." LIMIT ".$requestData['start']." ,".$requestData['length']."   ";
/* $requestData['order'][0]['column'] contains colmun index, $requestData['order'][0]['dir'] contains order such as asc/desc  */  
$query=mysqli_query($conn, $sql) or die("eror 3");


      $data = array();
      while( $row=mysqli_fetch_array($query) ) {  // preparing an array
        $nestedData=array(); 


            $nestedData[] = $row["no_reg"];
            $nestedData[] = $row["nama"];
            $nestedData[] = $row["tanggal_periksa"];
            $nestedData[] = $row["dokter"]; 
            $nestedData[] = $row["poli"];
            $nestedData[] = $row["id"];    


        $data[] = $nestedData;
        }    
    break;
    default:
}

$json_data = array(
      "draw"            => intval( $requestData['draw'] ),   // for every request/draw by clientside , they send a number as a parameter, when they recieve a response/data they first check the draw number, so we are sending same number in draw. 
      "recordsTotal"    => intval( $totalData ),  // total number of records
      "recordsFiltered" => intval( $totalFiltered ), // total number of records after searching, if there is no searching then totalFiltered = totalData
      "data"            => $data   // total data array
      );

echo json_encode($json_data);  // send data as json format

?>