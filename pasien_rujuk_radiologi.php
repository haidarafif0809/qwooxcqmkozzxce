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
    3=>'jenis_pasien',
    4=>'tanggal',
    5=>'penjamin',
    6=>'poli',
    7=>'dokter',
    8=>'id'    

);

// getting total number records without any search
$sql = "SELECT r.no_reg, r.no_rm, r.nama_pasien, r.jenis_pasien, r.tanggal, r.penjamin, r.poli, r.dokter, r.id, u.id  AS id_dokter, tpr.dokter_periksa";
$sql.=" FROM registrasi r LEFT JOIN user u ON r.dokter = u.nama INNER JOIN tbs_penjualan_radiologi tpr ON r.no_reg = tpr.no_reg LEFT JOIN penjualan penj ON r.no_reg = penj.no_reg ";
$sql.=" WHERE (r.status = 'Proses' OR r.status = 'Rujuk Keluar Ditangani') AND penj.no_faktur IS NULL GROUP BY r.no_reg";

$query = mysqli_query($conn, $sql) or die("eror 1");
$totalData = mysqli_num_rows($query);


if( !empty($requestData['search']['value']) ) {   // if there is a search parameter, $requestData['search']['value'] contains search parameter
$totalFiltered = $totalData;  // when there is no search parameter then total number rows = total number filtered rows.

$sql = "SELECT r.no_reg, r.no_rm, r.nama_pasien, r.jenis_pasien, r.tanggal, r.penjamin, r.poli, r.dokter, r.id, u.id  AS id_dokter, tpr.dokter_periksa";
$sql.=" FROM registrasi r LEFT JOIN user u ON r.dokter = u.nama INNER JOIN tbs_penjualan_radiologi tpr ON r.no_reg = tpr.no_reg LEFT JOIN penjualan penj ON r.no_reg = penj.no_reg ";
$sql.=" WHERE (r.status = 'Proses' OR r.status = 'Rujuk Keluar Ditangani') AND penj.no_faktur IS NULL";
    $sql.=" AND (r.no_reg = '".$requestData['search']['value']."'";  
    $sql.=" OR r.no_rm = '".$requestData['search']['value']."' ";
    $sql.=" OR r.nama_pasien LIKE '".$requestData['search']['value']."%' )";
    $sql.=" GROUP BY r.no_reg ";

}


$query=mysqli_query($conn, $sql) or die("eror 2");
$totalFiltered = mysqli_num_rows($query); // when there is a search parameter then we have to modify total number filtered rows as per search result. 
        
$sql.=" ORDER BY id ".$requestData['order'][0]['dir']."  LIMIT ".$requestData['start']." ,".$requestData['length']."   ";

/* $requestData['order'][0]['column'] contains colmun index, $requestData['order'][0]['dir'] contains order such as asc/desc  */    
$query=mysqli_query($conn, $sql) or die("eror 3");


$data = array();
while( $row=mysqli_fetch_array($query) ) {  // preparing an array
  $nestedData= array(); 

      $select_status_simpan = $db->query("SELECT status_simpan FROM tbs_penjualan_radiologi WHERE no_reg = '$row[no_reg]'");
      $data_status = mysqli_fetch_array($select_status_simpan);

      $nestedData[] = $row["no_reg"];
      $nestedData[] = $row["no_rm"];
      $nestedData[] = $row["nama_pasien"];
      $nestedData[] = $row["jenis_pasien"];
      $nestedData[] = $row["tanggal"];

      if ($data_status['status_simpan'] == 1) {
        $nestedData[] = "<p style='color:red'><b> Selesai Diperiksa </b></p>";
      }
      else{
        $nestedData[] = "<b> Belum Diperiksa </b>";
      }

      $nestedData[] = $row["penjamin"];
      $nestedData[] = $row["id_dokter"];
      $nestedData[] = $row["dokter_periksa"];
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