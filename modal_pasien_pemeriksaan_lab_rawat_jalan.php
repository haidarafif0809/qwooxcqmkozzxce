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


$cek_setting = $db->query("SELECT nama FROM setting_laboratorium WHERE jenis_lab = 'Rawat Jalan'");
$data_setting = mysqli_fetch_array($cek_setting);
$hasil_setting = $data_setting['nama']; //jika hasil 1 maka = input hasil baru bayar, jika 0 maka = bayar dulu baru input hasil

if($hasil_setting == '1'){

  // getting total number records without any search
  $sql = "SELECT COUNT(*) AS jumlah_data ";
  $sql.=" FROM registrasi";
  $sql.=" WHERE registrasi.jenis_pasien = 'Rawat Jalan' AND registrasi.status_lab = '2' AND (registrasi.status = 'Proses' OR registrasi.status = 'Rujuk Keluar Ditangani')";

  $query = mysqli_query($conn, $sql) or die("Eror Sql 1: get employees");
  $query_data = mysqli_fetch_array($query);
  $totalData = $query_data['jumlah_data'];
  $totalFiltered = $totalData;  // when there is no search parameter then total number rows = total number filtered rows.

  //Query Rawat Jalan, INNER JOIN KE TBS APS PENJUALAN UNTUK CEK DATA NYA ADA TIDAK , JANGAN DI BUANG !
  $sql = "SELECT reg.no_reg, reg.no_rm, reg.nama_pasien, reg.jenis_pasien, reg.tanggal, pj.no_faktur, reg.id";
  $sql.=" FROM registrasi reg LEFT JOIN penjualan pj ON reg.no_reg = pj.no_reg ";
  $sql.=" WHERE (reg.status = 'Proses' OR reg.status = 'Rujuk Keluar Ditangani') AND reg.jenis_pasien = 'Rawat Jalan' AND reg.status_lab = '2' AND pj.no_faktur IS NULL GROUP BY reg.no_reg";
  
}
else{

  // getting total number records without any search
  $sql = "SELECT COUNT(*) AS jumlah_data ";
  $sql.=" FROM registrasi";
  $sql.=" WHERE registrasi.jenis_pasien = 'Rawat Jalan' AND registrasi.status = 'Sudah Pulang' AND registrasi.status_lab = '2' ";

  $query = mysqli_query($conn, $sql) or die("Eror Sql 2: get employees");
  $query_data = mysqli_fetch_array($query);
  $totalData = $query_data['jumlah_data'];
  $totalFiltered = $totalData;  // when there is no search parameter then total number rows = total number filtered rows.

  //Query Rawat Jalan, INNER JOIN KE TBS APS PENJUALAN UNTUK CEK DATA NYA ADA TIDAK , JANGAN DI BUANG !
  $sql = "SELECT reg.no_reg, reg.no_rm, reg.nama_pasien, reg.jenis_pasien, reg.tanggal, pj.no_faktur, reg.id";
  $sql.=" FROM registrasi reg LEFT JOIN penjualan pj ON reg.no_reg = pj.no_reg";
  $sql.=" WHERE reg.jenis_pasien = 'Rawat Jalan' AND reg.status = 'Sudah Pulang' AND reg.status_lab = '2' AND pj.no_faktur != '' GROUP BY reg.no_reg";

}


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