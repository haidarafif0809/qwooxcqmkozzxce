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

$cek_setting = $db->query("SELECT nama FROM setting_laboratorium WHERE jenis_lab = 'Rawat Inap'");
$data_setting = mysqli_fetch_array($cek_setting);
$hasil_setting = $data_setting['nama']; //jika hasil 1 maka = input hasil baru bayar, jika 0 maka = bayar dulu baru input hasil

if($hasil_setting == '1'){
  // getting total number records without any search
  $sql = "SELECT COUNT(*) AS jumlah_data ";
  $sql.=" FROM registrasi";
  $sql.=" WHERE registrasi.status_lab = '2' AND registrasi.jenis_pasien = 'Rawat Inap' AND registrasi.status = 'menginap' AND registrasi.status != 'Batal Rawat Inap'";

  $query = mysqli_query($conn, $sql) or die("Eror Sql 1: get employees");
  $query_data = mysqli_fetch_array($query);
  $totalData = $query_data['jumlah_data'];
  $totalFiltered = $totalData;  // when there is no search parameter then total number rows = total number filtered rows.

  //Query Rawat Inap
  $sql = "SELECT pem.no_periksa, pem.no_reg, pem.no_rm, pem.nama_pasien, reg.jenis_pasien,reg.tanggal,reg.id";
  $sql.=" FROM pemeriksaan_lab_inap pem LEFT JOIN registrasi reg ON pem.no_reg = reg.no_reg LEFT JOIN penjualan pj ON pem.no_reg = pj.no_reg ";
  $sql.=" WHERE pem.status = '0' AND reg.status_lab = '2' AND reg.jenis_pasien = 'Rawat Inap' AND reg.status = 'menginap' AND reg.status != 'Batal Rawat Inap' AND pj.no_faktur IS NULL ";
}
else{
  // getting total number records without any search
  $sql = "SELECT COUNT(*) AS jumlah_data ";
  $sql.=" FROM registrasi";
  $sql.=" WHERE registrasi.status_lab = '2' AND registrasi.jenis_pasien = 'Rawat Inap' AND registrasi.status = 'Sudah Pulang'";

  $query = mysqli_query($conn, $sql) or die("Eror Sql 1: get employees");
  $query_data = mysqli_fetch_array($query);
  $totalData = $query_data['jumlah_data'];
  $totalFiltered = $totalData;  // when there is no search parameter then total number rows = total number filtered rows.

  //Query Rawat Inap
  $sql = "SELECT pem.no_periksa, pem.no_reg, pem.no_rm, pem.nama_pasien, reg.jenis_pasien,reg.tanggal,reg.id";
  $sql.=" FROM pemeriksaan_lab_inap pem LEFT JOIN registrasi reg ON pem.no_reg = reg.no_reg LEFT JOIN penjualan pj ON pem.no_reg = pj.no_reg ";
  $sql.=" WHERE pem.status = '0' AND reg.status_lab = '2' AND reg.jenis_pasien = 'Rawat Inap' AND reg.status = 'Sudah Pulang'";
}

if( !empty($requestData['search']['value']) ) {   // if there is a search parameter, $requestData['search']['value'] contains search parameter

  $cek_tanggal =   validateDate($requestData['search']['value']);
  if ($cek_tanggal == true){
    $tanggal_cari = tanggal_mysql($requestData['search']['value']);
  }
  else{
    $tanggal_cari = $requestData['search']['value'];
  }

    $sql.=" AND (pem.no_reg = '".$requestData['search']['value']."'";  
    $sql.=" OR pem.no_rm = '".$requestData['search']['value']."' ";
    $sql.=" OR pem.nama_pasien LIKE '".$requestData['search']['value']."%'";   
    $sql.=" OR reg.tanggal = '".$tanggal_cari."' )";
}

  
$sql.=" ORDER BY reg.id DESC  LIMIT ".$requestData['start']." ,".$requestData['length']."   ";
/* $requestData['order'][0]['column'] contains colmun index, $requestData['order'][0]['dir'] contains order such as asc/desc  */  
$query=mysqli_query($conn, $sql) or die("Eror Last: get employees");

$data = array();
while( $row=mysqli_fetch_array($query) ) {  // preparing an array
  $nestedData=array(); 

      $nestedData[] = $row["no_reg"];
      $nestedData[] = $row["no_rm"];
      $nestedData[] = $row["nama_pasien"];
      $nestedData[] = $row["jenis_pasien"];
      $nestedData[] = $row["no_periksa"];
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