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
    3=>'status_pasien',
    4=>'waktu',
    5=>'id'    
);

$cek_setting = $db->query("SELECT nama FROM setting_laboratorium WHERE jenis_lab = 'APS'");
$data_setting = mysqli_fetch_array($cek_setting);
$hasil_setting = $data_setting['nama']; //jika hasil 1 maka = input hasil baru bayar, jika 0 maka = bayar dulu baru input hasil

if($hasil_setting == '1'){
//Query Rawat APS
$sql = "SELECT pl.no_faktur,pl.no_reg,pl.no_rm,pl.nama_pasien,pl.status_pasien,DATE(pl.waktu) AS tanggal ,pl.id";
$sql.=" FROM pemeriksaan_laboratorium pl INNER JOIN registrasi reg ON pl.no_reg = reg.no_reg";
$sql.=" WHERE pl.status = '0' AND reg.status = 'aps_masuk' AND reg.jenis_pasien = 'APS'";
}
else{
$sql = "SELECT pl.no_faktur,pl.no_reg,pl.no_rm,pl.nama_pasien,pl.status_pasien,DATE(pl.waktu) AS tanggal ,pl.id";
$sql.=" FROM pemeriksaan_laboratorium pl INNER JOIN registrasi reg ON pl.no_reg = reg.no_reg";
$sql.=" WHERE pl.status = '0' AND reg.status = 'Sudah Pulang' AND reg.jenis_pasien = 'APS'";
}

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


    $sql.=" AND (no_reg = '".$requestData['search']['value']."'";  
    $sql.=" OR no_rm = '".$requestData['search']['value']."' ";
    $sql.=" OR nama_pasien LIKE '".$requestData['search']['value']."%'";   
    $sql.=" OR waktu = '".$tanggal_cari."' )";

}


$query=mysqli_query($conn, $sql) or die("eror 2");
$totalFiltered = mysqli_num_rows($query); // when there is a search parameter then we have to modify total number filtered rows as per search result. 
        
$sql.=" ORDER BY id ".$requestData['order'][0]['dir']."  LIMIT ".$requestData['start']." ,".$requestData['length']."   ";

/* $requestData['order'][0]['column'] contains colmun index, $requestData['order'][0]['dir'] contains order such as asc/desc  */    
$query=mysqli_query($conn, $sql) or die("eror 3");


$data = array();
while( $row=mysqli_fetch_array($query) ) {  // preparing an array
  $nestedData=array(); 

      $nestedData[] = $row["no_reg"];
      $nestedData[] = $row["no_rm"];
      $nestedData[] = $row["nama_pasien"];
      $nestedData[] = $row["status_pasien"];
      $nestedData[] = $row["tanggal"];
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