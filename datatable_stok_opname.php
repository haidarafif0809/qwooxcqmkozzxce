<?php include 'session_login.php';
/* Database connection start */
include 'db.php';
/* Database connection end */
include 'sanitasi.php';

$pilih_akses_stok_opname = $db->query("SELECT stok_opname_edit,
stok_opname_hapus FROM otoritas_stok_opname WHERE id_otoritas = '$_SESSION[otoritas_id]'");
$stok_opname = mysqli_fetch_array($pilih_akses_stok_opname);

// storing  request (ie, get/post) global array to a variable  
$requestData= $_REQUEST;


$columns = array( 
// datatable column index  => database column name
	0 =>'no_faktur', 
	1 => 'tanggal',
	2 => 'jam',
	3 => 'status',
	4 => 'total_selisih',
  	5 => 'user',
  	5 => 'keterangan',
	6 => 'id'
);

// getting total number records without any search
$sql = "SELECT COUNT(*) AS jumlah_data ";
$sql.=" FROM stok_opname";
$query=mysqli_query($conn, $sql) or die("datatable_stok_opname.php: get employees");
$query_data = mysqli_fetch_array($query);
$totalData = $query_data['jumlah_data'];
$totalFiltered = $totalData;  // when there is no search parameter then total number rows = total number filtered rows.


$sql = "SELECT no_faktur,
tanggal,
jam,
status,
total_selisih,
user,id,
keterangan ";
$sql.=" FROM stok_opname WHERE 1=1";
if( !empty($requestData['search']['value']) ) {   // if there is a search parameter, $requestData['search']['value'] contains search parameter
	$sql.=" AND ( no_faktur LIKE '".$requestData['search']['value']."%' ";    
	$sql.=" OR tanggal LIKE '".$requestData['search']['value']."%' )";
}
$query=mysqli_query($conn, $sql) or die("datatable_stok_opname.php: get employees");
$totalFiltered = mysqli_num_rows($query); // when there is a search parameter then we have to modify total number filtered rows as per search result. 
$sql.= " ORDER BY tanggal DESC LIMIT ".$requestData['start']." ,".$requestData['length']."   ";
/* $requestData['order'][0]['column'] contains colmun index, $requestData['order'][0]['dir'] contains order such as asc/desc  */	
$query=mysqli_query($conn, $sql) or die("employee-grid-data.php: get employees");

$data = array();
while( $row=mysqli_fetch_array($query) ) {  // preparing an array
	$nestedData=array(); 

	$nestedData[] = $row["no_faktur"];
	$nestedData[] = $row["tanggal"];
	$nestedData[] = $row["jam"];
	$nestedData[] = $row["status"];
	$nestedData[] = $row["total_selisih"];
	$nestedData[] = $row["user"];
	$nestedData[] = $row["keterangan"];

  $nestedData[] = "<button class='btn btn-info detail' no_faktur='". $row['no_faktur'] ."' ><i class='fa fa-list'></i>  </button>";

  if ($stok_opname['stok_opname_edit'] > 0) {
      $nestedData[] = "<a href='proses_edit_stok_opname.php?no_faktur=". $row['no_faktur']."&tanggal=". $row['tanggal']."' class='btn btn-success'> <i class='fa fa-edit'></i>  </a>";
  }

  if ($stok_opname['stok_opname_hapus'] > 0) {

      $hpp_keluar_stok_opname = $db->query("SELECT no_faktur_hpp_masuk FROM hpp_keluar WHERE no_faktur_hpp_masuk = '$row[no_faktur]' ");

      $jumlah_hpp_keluar_stok_opname = mysqli_num_rows($hpp_keluar_stok_opname);

        //jika hpp keluar stok opname nya lebih dari 0 maka stok opname tidak bisa di hapus
        if ($jumlah_hpp_keluar_stok_opname > 0) {

        $nestedData[] = "<button class='btn btn-danger btn-alert' data-id='". $row['id'] ."' data-faktur='". $row['no_faktur'] ."'> <i class='fa fa-trash'></i> </button>";
        } 
        else {
          $nestedData[] = "<button class='btn btn-danger btn-hapus' data-id='". $row['id'] ."'  data-faktur='". $row['no_faktur'] ."'><i class='fa fa-trash'></i></button>";
        }
  }

 $nestedData[] = "<a href='download_stok_opname.php?no_faktur=". $row['no_faktur']."' class='btn btn-success'> <i class='fa fa-download'> </i> </a>";
		
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

