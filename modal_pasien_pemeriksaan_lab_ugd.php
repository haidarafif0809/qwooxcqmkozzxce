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
    4=>'tanggal',
    5=>'id'     
);
$cek_setting = $db->query("SELECT nama FROM setting_laboratorium");
$data_setting = mysqli_fetch_array($cek_setting);
$hasil_setting = $data_setting['nama']; //jika hasil 1 maka = input hasil baru bayar, jika 0 maka = bayar dulu baru input hasil

if($hasil_setting == '1'){
//Query Rawat UGD
$sql = "SELECT reg.no_reg, reg.no_rm, reg.nama_pasien, reg.jenis_pasien, reg.tanggal, reg.dokter, reg.jenis_kelamin, pj.no_faktur, reg.id, us.id AS id_dokter";
$sql.=" FROM registrasi reg INNER JOIN tbs_aps_penjualan tap ON reg.no_reg = tap.no_reg LEFT JOIN penjualan pj ON reg.no_reg = pj.no_reg LEFT JOIN user us ON reg.dokter = us.nama";
$sql.=" WHERE reg.jenis_pasien = 'UGD' AND  (reg.status != 'Batal UGD' AND reg.status != 'Rujuk Rumah Sakit' AND reg.status != 'Sudah Pulang') AND reg.status_lab != '1' AND pj.no_faktur IS NULL GROUP BY reg.no_reg";
}
else{
$sql = "SELECT reg.no_reg, reg.no_rm, reg.nama_pasien, reg.jenis_pasien, reg.tanggal, reg.dokter, reg.jenis_kelamin, pj.no_faktur, reg.id, us.id AS id_dokter";
$sql.=" FROM registrasi reg INNER JOIN tbs_aps_penjualan tap ON reg.no_reg = tap.no_reg LEFT JOIN penjualan pj ON reg.no_reg = pj.no_reg LEFT JOIN user us ON reg.dokter = us.nama";
$sql.=" WHERE reg.jenis_pasien = 'UGD' AND  reg.status = 'Sudah Pulang' AND reg.status_lab != '1' AND pj.no_faktur != '' GROUP BY reg.no_reg";
}

$query = mysqli_query($conn, $sql) or die("eror 1");
$totalData = mysqli_num_rows($query);


$totalFiltered = $totalData;  // when there is no search parameter then total number rows = total number filtered rows.

if( !empty($requestData['search']['value']) ) {   // if there is a search parameter, $requestData['search']['value'] contains search parameter

        $cek_tanggal =   validateDate($requestData['search']['value']);
        if ($cek_tanggal == true) {
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
        
$sql.=" ORDER BY reg.id ".$requestData['order'][0]['dir']."  LIMIT ".$requestData['start']." ,".$requestData['length']."   ";

/* $requestData['order'][0]['column'] contains colmun index, $requestData['order'][0]['dir'] contains order such as asc/desc  */    
$query=mysqli_query($conn, $sql) or die("eror 3");


$data = array();
while( $row=mysqli_fetch_array($query) ) {  // preparing an array
  $nestedData=array(); 

  if($hasil_setting == 0){
      $nestedData[] = $row["no_reg"];
      $nestedData[] = $row["no_rm"];
      $nestedData[] = $row["nama_pasien"];
      $nestedData[] = $row["jenis_pasien"];
      $nestedData[] = $row["tanggal"];
      $nestedData[] = $row["id"];
  }
  else{
      $nestedData[] = $row["no_reg"];
      $nestedData[] = $row["no_rm"];
      $nestedData[] = $row["nama_pasien"];
      $nestedData[] = $row["jenis_pasien"];
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