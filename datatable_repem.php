<?php include 'session_login.php';
/* Database connection start */
include 'db.php';
/* Database connection end */
include 'sanitasi.php';

$pilih_akses_pembelian = $db->query("SELECT * FROM otoritas_pembelian WHERE id_otoritas = '$_SESSION[otoritas_id]'");
$pembelian = mysqli_fetch_array($pilih_akses_pembelian);


// storing  request (ie, get/post) global array to a variable  
$requestData= $_REQUEST;


$columns = array( 
// datatable column index  => database column name
	0 =>'no_faktur_retur', 
	1 => 'nama',
	2 => 'total',
	3 => 'potongan',
	4 => 'tax',
	5 => 'tanggal',
  6 => 'jam',
  7 => 'user_buat',
  8 => 'user_edit',
  9 => 'tanggal_edit',
  10 => 'tunai',
  11 => 'sisa',
  12 => 'id'
);

// getting total number records without any search
$sql = "SELECT p.id,p.no_faktur_retur,p.keterangan,p.total,p.nama_suplier,p.tanggal,p.tanggal_edit,p.jam,p.user_buat,p.user_edit,p.potongan,p.tax,p.tunai,p.sisa,p.cara_bayar,s.nama  ";
$sql.=" FROM retur_pembelian p INNER JOIN suplier s ON p.nama_suplier = s.id";
$query=mysqli_query($conn, $sql) or die("datatable_repem.php: get employees");
$totalData = mysqli_num_rows($query);
$totalFiltered = $totalData;  // when there is no search parameter then total number rows = total number filtered rows.


$sql = "SELECT p.id,p.no_faktur_retur,p.keterangan,p.total,p.nama_suplier,p.tanggal,p.tanggal_edit,p.jam,p.user_buat,p.user_edit,p.potongan,p.tax,p.tunai,p.sisa,p.cara_bayar,s.nama  ";
$sql.=" FROM retur_pembelian p INNER JOIN suplier s ON p.nama_suplier = s.id WHERE 1=1";
if( !empty($requestData['search']['value']) ) {   // if there is a search parameter, $requestData['search']['value'] contains search parameter
	$sql.=" AND ( no_faktur_retur LIKE '".$requestData['search']['value']."%' ";    
	$sql.=" OR nama_suplier LIKE '".$requestData['search']['value']."%' ";
  $sql.=" OR tanggal LIKE '".$requestData['search']['value']."%' )";
}
$query=mysqli_query($conn, $sql) or die("datatable_repem.php: get employees");
$totalFiltered = mysqli_num_rows($query); // when there is a search parameter then we have to modify total number filtered rows as per search result. 
$sql.=" ORDER BY ". $columns[$requestData['order'][0]['column']]."   ".$requestData['order'][0]['dir']."  LIMIT ".$requestData['start']." ,".$requestData['length']."   ";
/* $requestData['order'][0]['column'] contains colmun index, $requestData['order'][0]['dir'] contains order such as asc/desc  */	
$query=mysqli_query($conn, $sql) or die("employee-grid-data.php: get employees");

$data = array();
while( $row=mysqli_fetch_array($query) ) {  // preparing an array
	$nestedData=array(); 

        //menampilkan data
      $nestedData[] = "<button class='btn btn-info detail' no_faktur_retur='". $row['no_faktur_retur'] ."' ><span class='glyphicon glyphicon-th-list'></span> Detail </button>";

        if ($pembelian['retur_pembelian_edit'] > 0) {

              $nestedData[] = "<a href='proses_edit_retur_pembelian.php?no_faktur_retur=". $row['no_faktur_retur']."&nama=". $row['nama']."&cara_bayar=".$row['cara_bayar']."' class='btn btn-success'> <span class='glyphicon glyphicon-edit'></span> Edit </a>";
            }

        if ($pembelian['retur_pembelian_hapus'] > 0) {

              $nestedData[] = "<button class='btn btn-danger btn-hapus' data-id='". $row['id'] ."' data-faktur='". $row['no_faktur_retur'] ."' data-suplier='". $row['nama'] ."'> <span class='glyphicon glyphicon-trash'> </span> Hapus </button>";
            } 
              
      $nestedData[] = "<a href='cetak_lap_retur_pembelian.php?no_faktur_retur=".$row['no_faktur_retur']."&nama_suplier=".$row['nama']."' class='btn btn-primary' target='blank'><span class='glyphicon glyphicon-print'> </span> Cetak Retur</a>";
      $nestedData[] = $row['no_faktur_retur'];
      $nestedData[] = $row['nama'];
      $nestedData[] = rp($row['total']);
      $nestedData[] = rp($row['potongan']);
      $nestedData[] = rp($row['tax']);
      $nestedData[] = $row['tanggal'];
      $nestedData[] = $row['jam'];
      $nestedData[] = $row['user_buat'];
      $nestedData[] = $row['user_edit'];
      $nestedData[] = $row['tanggal_edit'];
      $nestedData[] = rp($row['tunai']);
      $nestedData[] = rp($row['sisa']);
    
		
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
