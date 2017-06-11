<?php include 'session_login.php';
include 'sanitasi.php';
include 'db.php';

$requestData= $_REQUEST;

$columns = array( 
// datatable column index  => database column name
    0=>'no_reg',
    1=>'no_rm',
    2=>'nama_pasien',
    3=>'jenis_pasien',
    4=>'no_periksa',
    5=>'tanggal',
    6=>'id'    
);

//Query Rawat Inap
$sql = "SELECT pem.no_periksa, reg.no_reg, reg.no_rm, reg.nama_pasien, reg.jenis_pasien, reg.tanggal, reg.dokter, reg.jenis_kelamin, pj.no_faktur, reg.id";
$sql.=" FROM registrasi reg INNER JOIN pemeriksaan_lab_inap pem ON reg.no_reg = pem.no_reg LEFT JOIN penjualan pj ON reg.no_reg = pj.no_reg ";
$sql.=" WHERE pem.status = '0' AND reg.jenis_pasien = 'Rawat Inap' AND reg.status = 'menginap' AND reg.status != 'Batal Rawat Inap' AND pj.no_faktur IS NULL ";


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


    $sql.=" AND (reg.no_reg = '".$requestData['search']['value']."'";  
    $sql.=" OR reg.no_rm = '".$requestData['search']['value']."' ";
    $sql.=" OR reg.nama_pasien LIKE '".$requestData['search']['value']."%'";   
    $sql.=" OR reg.tanggal = '".$tanggal_cari."' )";

}


$query=mysqli_query($conn, $sql) or die("eror 2");
$totalFiltered = mysqli_num_rows($query); // when there is a search parameter then we have to modify total number filtered rows as per search result. 
        
$sql.=" ORDER BY reg.no_reg, pem.no_periksa ASC  LIMIT ".$requestData['start']." ,".$requestData['length']."   ";

/* $requestData['order'][0]['column'] contains colmun index, $requestData['order'][0]['dir'] contains order such as asc/desc  */    
$query=mysqli_query($conn, $sql) or die("eror 3");


$data = array();
while( $row=mysqli_fetch_array($query) ) {  // preparing an array
  $nestedData=array(); 

$cek_setting = $db->query("SELECT nama FROM setting_laboratorium");
$data_setting = mysqli_fetch_array($cek_setting);
$hasil_setting = $data_setting['nama'];
  if($hasil_setting == 0){
      $nestedData[] = $row["no_reg"];
      $nestedData[] = $row["no_rm"];
      $nestedData[] = $row["nama_pasien"];
      $nestedData[] = $row["jenis_pasien"];
      $nestedData[] = $row["no_periksa"];
      $nestedData[] = $row["tanggal"];
      $nestedData[] = $row["id"];
  }
  else{
      $nestedData[] = $row["no_reg"];
      $nestedData[] = $row["no_rm"];
      $nestedData[] = $row["nama_pasien"];
      $nestedData[] = $row["jenis_pasien"];
      $nestedData[] = $row["no_periksa"];
      $nestedData[] = $row["tanggal"];
      $nestedData[] = $row["id"];
  }


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