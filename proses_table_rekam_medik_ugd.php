<?php include 'session_login.php';
/* Database connection start */
include 'db.php';

/* Database connection end */

$pilih_akses_rekam_medik = $db->query("SELECT rekam_medik_ugd_lihat, rekam_medik_ugd_tambah, rekam_medik_ugd_edit, rekam_medik_ugd_hapus FROM otoritas_rekam_medik WHERE id_otoritas = '$_SESSION[otoritas_id]'");
$rekam_medik = mysqli_fetch_array($pilih_akses_rekam_medik);


// storing  request (ie, get/post) global array to a variable  
$requestData= $_REQUEST;

$columns = array( 
// datatable column index  => database column name
	0 =>'no_reg', 
	1 => 'no_rm',
	2=> 'nama',
	3 => 'alamat',
	4=> 'umur',
	5 => 'jenis_kelamin',
	6=> 'alergi',
	7=> 'dokter',
	8 => 'jam',
	9=> 'tanggal',
	10=> 'aksi',
	11=> 'selesai'


);

// getting total number records without any search
$sql = "SELECT rekam_medik_ugd.no_reg, rekam_medik_ugd.no_rm, rekam_medik_ugd.nama, rekam_medik_ugd.alamat,
rekam_medik_ugd.umur, rekam_medik_ugd.jenis_kelamin, rekam_medik_ugd.alergi, rekam_medik_ugd.dokter, rekam_medik_ugd.jam, rekam_medik_ugd.tanggal, rekam_medik_ugd.id ";
$sql.=" FROM rekam_medik_ugd INNER JOIN registrasi ON rekam_medik_ugd.no_reg = registrasi.no_reg";
$sql.=" WHERE registrasi.status != 'Batal UGD' AND rekam_medik_ugd.status IS NULL";
$sql.=" ORDER BY rekam_medik_ugd.id DESC ";
$query = mysqli_query($conn, $sql) or die("proses_table_rekam_medik_ugd.php: get employees");
$totalData = mysqli_num_rows($query);
$totalFiltered = $totalData;  // when there is no search parameter then total number rows = total number filtered rows.


$sql = "SELECT rekam_medik_ugd.no_reg, rekam_medik_ugd.no_rm, rekam_medik_ugd.nama, rekam_medik_ugd.alamat,
rekam_medik_ugd.umur, rekam_medik_ugd.jenis_kelamin, rekam_medik_ugd.alergi, rekam_medik_ugd.dokter, rekam_medik_ugd.jam, rekam_medik_ugd.tanggal, rekam_medik_ugd.id";
$sql.=" FROM rekam_medik_ugd INNER JOIN registrasi ON rekam_medik_ugd.no_reg = registrasi.no_reg";
$sql.=" WHERE 1=1 ";
$sql.=" AND registrasi.status != 'Batal UGD' ";
$sql.=" AND rekam_medik_ugd.status IS NULL ";
if( !empty($requestData['search']['value']) ) {   // if there is a search parameter, $requestData['search']['value'] contains search parameter
	$sql.=" AND ( rekam_medik_ugd.no_reg LIKE '".$requestData['search']['value']."%' ";    
	$sql.=" OR rekam_medik_ugd.no_rm LIKE '".$requestData['search']['value']."%' ";
	$sql.=" OR rekam_medik_ugd.nama LIKE '".$requestData['search']['value']."%' ";
	$sql.=" OR rekam_medik_ugd.dokter LIKE '".$requestData['search']['value']."%' ";
	$sql.=" OR rekam_medik_ugd.jam LIKE '".$requestData['search']['value']."%' ";
	$sql.=" OR rekam_medik_ugd.tanggal LIKE '".$requestData['search']['value']."%' )";
}

$query=mysqli_query($conn, $sql) or die("proses_table_rekam_medik_ugd.php: get employees");
$totalFiltered = mysqli_num_rows($query); // when there is a search parameter then we have to modify total number filtered rows as per search result. 
$sql.=" ORDER BY ". $columns[$requestData['order'][0]['column']]."   ".$requestData['order'][0]['dir']."  LIMIT ".$requestData['start']." ,".$requestData['length']."   ";
/* $requestData['order'][0]['column'] contains colmun index, $requestData['order'][0]['dir'] contains order such as asc/desc  */		
$query=mysqli_query($conn, $sql) or die("proses_table_rekam_medik_ugd.php: get employees");

$data = array();
while( $row=mysqli_fetch_array($query) ) {  // preparing an array
	$nestedData=array(); 

	$nestedData[] = $row["no_reg"];
	$nestedData[] = $row["no_rm"];
	$nestedData[] = $row["nama"];
	$nestedData[] = $row["alamat"];
	$nestedData[] = $row["umur"];
	$nestedData[] = $row["jenis_kelamin"];	
	$nestedData[] = $row["alergi"];
	$nestedData[] = $row["dokter"];
	$nestedData[] = $row["jam"];	
	$nestedData[] = $row["tanggal"];

 if ($rekam_medik['rekam_medik_ugd_lihat'] > 0) 

 	{//if ($rekam_medik['rekam_medik_rj_lihat'] > 0) 
	      $nestedData[] = "<a href='input_rekam_medik_ugd.php?no_reg=".$row['no_reg']."&tgl=".$row['tanggal']."&id=".$row['id']."&jam=".$row['jam']."' class='btn-floating btn-info btn-small' ><i class='fa fa-medkit '></i></a>";

        $table23 = $db->query("SELECT status FROM penjualan WHERE no_reg = '$row[no_reg]' ");
        $dataki = mysqli_fetch_array($table23);

    if ($dataki['status'] == 'Lunas' OR  $dataki['status'] == 'Piutang'  OR  $dataki['status'] == 'Piutang Apotek'  )
        {
        	$nestedData[] = "<a href='selesai_ugd.php?no_reg=".$row['no_reg']."&id=".$row['id']."' class='btn-floating btn-info btn-small'><i class='fa  fa-check'></i> </a>";
        }
         else
        {
          $nestedData[] = "";
        }
        
	}//if ($rekam_medik['rekam_medik_rj_lihat'] > 0) 
	else{
       $nestedData[] = "";
       $nestedData[] = "";
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
