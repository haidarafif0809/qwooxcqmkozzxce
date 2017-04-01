<?php include 'session_login.php';
/* Database connection start */
include 'db.php';
include 'sanitasi.php';
/* Database connection end */


// storing  request (ie, get/post) global array to a variable  
$requestData= $_REQUEST;

$columns = array( 
// datatable column index  => database column name
	0 =>'kelas', 
	1 => 'nama_kamar',
	2 => 'sisa_bed',
	3 => 'group_bed',
	4 => 'tarif',
	5 => 'tarif_2',
	6 => 'tarif_3',
	7 => 'tarif_4',
	8 => 'tarif_5',
	9 => 'tarif_6',
	10 => 'tarif_7',
	11 => 'fasilitas',
	12 => 'jumlah_bed',
	13 => 'kode_kamar',
	14 => 'ruangam',
	15 => 'id'
);

// getting total number records without any search
$sql = "SELECT b.id,kk.nama ,b.nama_kamar,b.group_bed,b.tarif,b.tarif_2,b.tarif_3,b.tarif_4,b.tarif_5,b.tarif_6,b.tarif_7,b.fasilitas,b.jumlah_bed,b.sisa_bed,r.nama_ruangan ";
$sql.=" FROM bed b LEFT JOIN kelas_kamar kk ON b.kelas = kk.id LEFT JOIN ruangan r ON b.ruangan = r.id";
$query=mysqli_query($conn, $sql) or die("datatable_kamar.php: get employees");
$totalData = mysqli_num_rows($query);
$totalFiltered = $totalData;  // when there is no search parameter then total number rows = total number filtered rows.


$sql = "SELECT b.id,kk.nama ,b.nama_kamar,b.group_bed,b.tarif,b.tarif_2,b.tarif_3,b.tarif_4,b.tarif_5,b.tarif_6,b.tarif_7,b.fasilitas,b.jumlah_bed,b.sisa_bed,r.nama_ruangan ";
$sql.=" FROM bed b LEFT JOIN kelas_kamar kk ON b.kelas = kk.id LEFT JOIN ruangan r ON b.ruangan = r.id WHERE 1=1";
if( !empty($requestData['search']['value']) ) {   // if there is a search parameter, $requestData['search']['value'] contains search parameter
	$sql.=" AND ( nama_kamar LIKE '".$requestData['search']['value']."%' ";
	$sql.=" OR group_bed LIKE '".$requestData['search']['value']."%' ";
	$sql.=" OR kelas LIKE '".$requestData['search']['value']."%' )";
}
$query=mysqli_query($conn, $sql) or die("datatableee_kamar.php: get employees");
$totalFiltered = mysqli_num_rows($query); // when there is a search parameter then we have to modify total number filtered rows as per search result. 
$sql.=" ORDER BY id DESC  LIMIT ".$requestData['start']." ,".$requestData['length']."   ";
/* $requestData['order'][0]['column'] contains colmun index, $requestData['order'][0]['dir'] contains order such as asc/desc  */	
$query=mysqli_query($conn, $sql) or die("employee-grid-data.php: get employees");

$data = array();
while( $row=mysqli_fetch_array($query) ) {  // preparing an array
	$nestedData=array(); 

	$nestedData[] = $row["nama"];
	$nestedData[] = $row["nama_ruangan"];
	$nestedData[] = $row["nama_kamar"];
	$nestedData[] = $row["group_bed"];
	$nestedData[] = $row["tarif"];
	$nestedData[] = $row["tarif_2"];
	$nestedData[] = $row["tarif_3"];
	$nestedData[] = $row["tarif_4"];
	$nestedData[] = $row["tarif_5"];
	$nestedData[] = $row["tarif_6"];
	$nestedData[] = $row["tarif_7"];
	$nestedData[] = $row["fasilitas"];
	$nestedData[] = $row["jumlah_bed"];
	$nestedData[] = $row["sisa_bed"];
	
	//edit
	$pilih_akses_kamar_edit = $db->query("SELECT kamar_edit FROM otoritas_master_data WHERE id_otoritas = '$_SESSION[otoritas_id]' AND kamar_edit = '1' ");
	$kamar_edit = mysqli_num_rows($pilih_akses_kamar_edit);

          if ($kamar_edit > 0){

            if ($row['jumlah_bed'] == $row['sisa_bed'])
	          {
	            $nestedData[] = "<a href='edit_kamar.php?id=".$row['id']."' class='btn btn-warning'><span class='glyphicon glyphicon-wrench'></span> Edit </a>";
	          }
	          else
	          {
	            $nestedData[] = "Tidak ada akses";
	          }
	      }
	      //hapus
	    $pilih_akses_kamar_hapus = $db->query("SELECT kamar_hapus FROM otoritas_master_data WHERE id_otoritas = '$_SESSION[otoritas_id]' AND kamar_hapus = '1'");
		$kamar_hapus = mysqli_num_rows($pilih_akses_kamar_hapus);

          if ($kamar_hapus > 0){

            if ($row['jumlah_bed'] == $row['sisa_bed'])
	          {
	            $nestedData[] = '<button class="btn btn-danger btn-hapus" data-id="'.$row['id'].'">
	            <span class="glyphicon glyphicon-trash"> </span> Hapus </button>';
	          }
	          else
	          {
	            $nestedData[] = "Tidak ada akses";
	          }
	      }
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


