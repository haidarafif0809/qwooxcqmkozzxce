<?php include 'session_login.php';
/* Database connection start */
include 'sanitasi.php';
include 'db.php';

/* Database connection end */

// storing  request (ie, get/post) global array to a variable  
$requestData= $_REQUEST;



$columns = array( 
// datatable column index  => database column name

    0=>'no_reg', 
    1=>'no_rm',
    2=>'nama_pasien',
    3=>'aps_periksa',
    4=>'tanggal',
    5=>'penjamin',
    6=>'poli',
    7=>'dokter',
    8=>'id'    

);

// getting total number records without any search
$sql = "SELECT r.aps_periksa,r.no_reg, r.no_rm, r.nama_pasien, r.jenis_pasien, r.tanggal, r.penjamin, r.poli, r.dokter, r.id, u.id  AS id_dokter, p.harga AS level_harga";
$sql.=" FROM registrasi r LEFT JOIN user u ON r.dokter = u.nama LEFT JOIN penjamin p ON r.penjamin = p.nama LEFT JOIN penjualan penj ON r.no_reg = penj.no_reg ";
$sql.=" WHERE r.jenis_pasien = 'APS' AND r.status = 'aps_masuk' AND penj.no_faktur IS NULL ";

$query = mysqli_query($conn, $sql) or die("eror 1");
$totalData = mysqli_num_rows($query);
$totalFiltered = $totalData;  // when there is no search parameter then total number rows = total number filtered rows.

if( !empty($requestData['search']['value']) ) {   // if there is a search parameter, $requestData['search']['value'] contains search parameter

$cek_tanggal =   validateDate($requestData['search']['value']);

if ($cek_tanggal == true) {
  # code...

   $tanggal_cari = tanggal_mysql($requestData['search']['value']);


}
else {
   $tanggal_cari = $requestData['search']['value'];
}


    $sql.=" AND (r.no_reg = '".$requestData['search']['value']."'";  
    $sql.=" OR r.no_rm = '".$requestData['search']['value']."' ";
    $sql.=" OR r.nama_pasien LIKE '".$requestData['search']['value']."%'";   
    $sql.=" OR r.tanggal = '".$tanggal_cari."' )";

}


$query=mysqli_query($conn, $sql) or die("eror 2");
$totalFiltered = mysqli_num_rows($query); // when there is a search parameter then we have to modify total number filtered rows as per search result. 
        
$sql.=" ORDER BY id ".$requestData['order'][0]['dir']."  LIMIT ".$requestData['start']." ,".$requestData['length']."   ";

/* $requestData['order'][0]['column'] contains colmun index, $requestData['order'][0]['dir'] contains order such as asc/desc  */    
$query=mysqli_query($conn, $sql) or die("eror 3");


$data = array();
while( $row=mysqli_fetch_array($query) ) {  // preparing an array
  $nestedData=array(); 

      //$nestedData[] = '<p style="width:150">'.$row["nama_pasien"].'</p>';
      $nestedData[] = $row["no_reg"];
      $nestedData[] = $row["no_rm"];
      $nestedData[] = $row["nama_pasien"];

      $status_rawat = $row["aps_periksa"];
        $lab = 'Laboratorium';
        $radio = 'Radiologi';
      if($status_rawat == 1){
        $nestedData[] = $lab;
      }
      else{
        $nestedData[] = $radio;
      }

      $nestedData[] = $row["tanggal"];
      $nestedData[] = $row["penjamin"];
      $nestedData[] = $row["poli"];
      $nestedData[] = $row["id_dokter"];
      $nestedData[] = $row["level_harga"];
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