<?php include 'session_login.php';
/* Database connection start */
include 'db.php';
include 'sanitasi.php';

$dari_tanggal = stringdoang($_POST['dari_tanggal']);
$sampai_tanggal = stringdoang($_POST['sampai_tanggal']);


// storing  request (ie, get/post) global array to a variable  
$requestData= $_REQUEST;

$columns = array( 
// datatable column index  => database column name
  0 =>'waktu', 
  1 =>'no_reg'


);

// getting total number records without any search
$sql =" SELECT p.no_faktur,u.nama AS petugas_ops,uu.nama AS petugas_input,dp.nama_detail_operasi,hdo.waktu,hdo.no_reg ";
$sql.=" FROM hasil_detail_operasi hdo INNER JOIN user u ON hdo.id_user = u.id INNER JOIN user uu ON hdo.petugas_input = uu.id INNER JOIN detail_operasi dp ON hdo.id_detail_operasi = dp.id_detail_operasi INNER JOIN penjualan p ON hdo.no_reg = p.no_reg ";
$sql.=" WHERE DATE(hdo.waktu) >= '$dari_tanggal' AND DATE(hdo.waktu) <= '$sampai_tanggal' ";
$query=mysqli_query($conn, $sql) or die("eror.php: get employees");
$totalData = mysqli_num_rows($query);
$totalFiltered = $totalData;  // when there is no search parameter then total number rows = total number filtered rows.


$sql =" SELECT p.no_faktur,u.nama AS petugas_ops,uu.nama AS petugas_input,dp.nama_detail_operasi,hdo.waktu,hdo.no_reg ";
$sql.=" FROM hasil_detail_operasi hdo INNER JOIN user u ON hdo.id_user = u.id INNER JOIN user uu ON hdo.petugas_input = uu.id INNER JOIN detail_operasi dp ON hdo.id_detail_operasi = dp.id_detail_operasi INNER JOIN penjualan p ON hdo.no_reg = p.no_reg ";
$sql.=" WHERE DATE(hdo.waktu) >= '$dari_tanggal' AND DATE(hdo.waktu) <= '$sampai_tanggal' ";

if( !empty($requestData['search']['value']) ) {   // if there is a search parameter, $requestData['search']['value'] contains search parameter


  $sql.=" AND ( p.no_faktur LIKE '".$requestData['search']['value']."%' ";  
  $sql.=" OR dp.nama_detail_operasi LIKE '".$requestData['search']['value']."%' ";  
  $sql.=" OR hdo.no_reg LIKE '".$requestData['search']['value']."%' ";  
  $sql.=" OR u.nama LIKE '".$requestData['search']['value']."%' ) ";  

}
;
 // when there is a search parameter then we have to modify total number filtered rows as per search result. 


$sql.= " ORDER BY p.no_faktur DESC LIMIT ".$requestData['start']." ,".$requestData['length']." ";
/* $requestData['order'][0]['column'] contains colmun index, $requestData['order'][0]['dir'] contains order such as asc/desc  */	

$query=mysqli_query($conn, $sql) or die("eror.php2: get employees");
$totalFiltered = mysqli_num_rows($query);

$data = array();
while( $row=mysqli_fetch_array($query) ) {  // preparing an array
	$nestedData=array();      

      $nestedData[] = $row['no_faktur'];
      $nestedData[] = $row['no_reg'];
      $nestedData[] = $row['nama_detail_operasi'];
      $nestedData[] = $row['petugas_ops'];
      $nestedData[] = $row['petugas_input'];
      $nestedData[] = $row['waktu'];


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