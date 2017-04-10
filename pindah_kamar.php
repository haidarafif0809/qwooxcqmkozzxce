<?php include 'session_login.php';
/* Database connection start */
include 'sanitasi.php';
include 'db.php';

/* Database connection end */

// storing  request (ie, get/post) global array to a variable  
$requestData= $_REQUEST;



$columns = array( 
// datatable column index  => database column name

    0=>'kelas', 
    1=>'nama_kamar',
    2=>'group_bed',
    3=>'fasilitas',
    4=>'jumlah_bed',
    5=>'sisa_bed'

 
);
//$cek = $db->query("SELECT * FROM bed WHERE sisa_bed != 0 ");

// getting total number records without any search
$sql ="SELECT b.id,b.kelas, b.nama_kamar, b.group_bed, b.fasilitas, b.jumlah_bed, b.sisa_bed, r.nama_ruangan,r.id as id_ruangan ";
$sql.=" FROM bed b LEFT JOIN ruangan r ON b.ruangan = r.id WHERE sisa_bed != 0";

$query = mysqli_query($conn, $sql) or die("eror 1");
$totalData = mysqli_num_rows($query);
$totalFiltered = $totalData;  // when there is no search parameter then total number rows = total number filtered rows.

if( !empty($requestData['search']['value']) ) {   // if there is a search parameter, $requestData['search']['value'] contains search parameter
$sql ="SELECT b.id,b.kelas, b.nama_kamar, b.group_bed, b.fasilitas, b.jumlah_bed, b.sisa_bed, r.nama_ruangan,r.id as id_ruangan ";
$sql.=" FROM bed b LEFT JOIN ruangan r ON b.ruangan = r.id WHERE sisa_bed != 0  AND 1 = 1";

    $sql.=" AND (b.nama_kamar LIKE '".$requestData['search']['value']."%'";  
    $sql.=" OR b.group_bed LIKE '".$requestData['search']['value']."%' "; 
    $sql.=" OR r.nama_ruangan LIKE '".$requestData['search']['value']."%' ";
    $sql.=" OR b.fasilitas LIKE '".$requestData['search']['value']."%' )";

}


$query=mysqli_query($conn, $sql) or die("eror 2");
$totalFiltered = mysqli_num_rows($query); // when there is a search parameter then we have to modify total number filtered rows as per search result. 
        
$sql.=" ORDER BY b.id ".$requestData['order'][0]['dir']."  LIMIT ".$requestData['start']." ,".$requestData['length']."   ";

/* $requestData['order'][0]['column'] contains colmun index, $requestData['order'][0]['dir'] contains order such as asc/desc  */    
$query=mysqli_query($conn, $sql) or die("eror 3");


$data = array();
while( $row=mysqli_fetch_array($query) ) {  // preparing an array
  $nestedData=array(); 

               $select_kelas = $db->query("SELECT id,nama FROM kelas_kamar");
        while($out_kelas = mysqli_fetch_array($select_kelas))
        {
          if($row['kelas'] == $out_kelas['id'])
          {
            $kelas = $out_kelas['nama'];
          }
        }

      $nestedData[] = $kelas;
      $nestedData[] = $row["nama_kamar"];
      $nestedData[] = $row["group_bed"];
      $nestedData[] = $row['nama_ruangan'];
      $nestedData[] = $row["fasilitas"];
      $nestedData[] = $row["jumlah_bed"];
      $nestedData[] = $row["sisa_bed"];
      $nestedData[] = $row["id_ruangan"];

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