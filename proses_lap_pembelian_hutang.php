<?php include 'session_login.php';
/* Database connection start */
include 'sanitasi.php';
include 'db.php';

/* Database connection end */

$sampai_tanggal = stringdoang($_POST['sampai_tanggal']);

// storing  request (ie, get/post) global array to a variable  
$requestData= $_REQUEST;



$columns = array( 
// datatable column index  => database column name

	0=>'tanggal', 
	1=>'tanggal_jt',
	2=>'no_faktur',
	3=>'nama',
	4=>'total',
	5=>'jam', 
	6=>'user',
	7=>'status',
	8=>'potongan',
	9=>'tax',
	10=>'sisa', 
	11=>'kredit',
	12=>'nilai_kredit',
	13=>'id'



);

// getting total number records without any search
$sql = "SELECT p.id,p.no_faktur,p.total,p.suplier,p.tanggal,p.tanggal_jt,p.jam,p.user,p.status,p.potongan,p.tax,p.sisa,p.kredit,p.nilai_kredit,s.nama,g.nama_gudang ";
$sql.=" FROM pembelian p INNER JOIN suplier s ON p.suplier = s.id INNER JOIN gudang g ON p.kode_gudang = g.kode_gudang ";
$sql.=" WHERE p.tanggal <= '$sampai_tanggal' ";
$sql.=" AND kredit != 0";
$sql.=" ";

$query = mysqli_query($conn, $sql) or die("eror 1");
$totalData = mysqli_num_rows($query);
$totalFiltered = $totalData;  // when there is no search parameter then total number rows = total number filtered rows.


if( !empty($requestData['search']['value']) ) {   // if there is a search parameter, $requestData['search']['value'] contains search parameter
$sql = "SELECT p.id,p.no_faktur,p.total,p.suplier,p.tanggal,p.tanggal_jt,p.jam,p.user,p.status,p.potongan,p.tax,p.sisa,p.kredit,p.nilai_kredit,s.nama,g.nama_gudang";
$sql.=" FROM pembelian p INNER JOIN suplier s ON p.suplier = s.id INNER JOIN gudang g ON p.kode_gudang = g.kode_gudang ";
$sql.=" WHERE p.tanggal <= '$sampai_tanggal'";
$sql.=" AND kredit != 0";

	$sql.=" AND ( no_faktur LIKE '".$requestData['search']['value']."%' ";  
	$sql.=" OR tanggal LIKE '".$requestData['search']['value']."%' ";
	$sql.=" OR tanggal_jt LIKE '".$requestData['search']['value']."%' ";   
	$sql.=" OR total LIKE '".$requestData['search']['value']."%' ";   
	$sql.=" OR nama LIKE '".$requestData['search']['value']."%' )";

}

$query=mysqli_query($conn, $sql) or die("eror 2");
$totalFiltered = mysqli_num_rows($query); // when there is a search parameter then we have to modify total number filtered rows as per search result. 
		
$sql.=" ORDER BY id ".$requestData['order'][0]['dir']."  LIMIT ".$requestData['start']." ,".$requestData['length']."   ";

/* $requestData['order'][0]['column'] contains colmun index, $requestData['order'][0]['dir'] contains order such as asc/desc  */	
$query=mysqli_query($conn, $sql) or die("eror 3");


$data = array();


while( $row=mysqli_fetch_array($query) ) {

	$nestedData=array(); 

	$nestedData[] = $row["tanggal"];
	$nestedData[] = $row["tanggal_jt"];
	$nestedData[] = $row["no_faktur"];
	$nestedData[] = $row["nama"];
	$nestedData[] = rp($row["total"]);
	$nestedData[] = $row["jam"];
	$nestedData[] = $row["user"];
	$nestedData[] = $row["status"];
	$nestedData[] = $row["potongan"];
	$nestedData[] = $row["tax"];
	$nestedData[] = rp($row["sisa"]);
	$nestedData[] = rp($row["kredit"]);
	$nestedData[] = rp($row["nilai_kredit"]);
	$nestedData[] = $row["id"];
	
	$data[] = $nestedData;
		
}

$query300 = $db->query("SELECT SUM(nilai_kredit) AS total_nilai_kredit FROM pembelian WHERE  tanggal <= '$sampai_tanggal' AND kredit != 0");
$cek300 = mysqli_fetch_array($query300);
$total_nilai_kredit = $cek300['total_nilai_kredit'];


$query30 = $db->query("SELECT SUM(kredit) AS total_kredit FROM pembelian WHERE tanggal <= '$sampai_tanggal' AND kredit != 0");
$cek30 = mysqli_fetch_array($query30);
$total_kredit = $cek30['total_kredit'];


$query02 = $db->query("SELECT SUM(total) AS total_akhir FROM pembelian WHERE tanggal <= '$sampai_tanggal' AND kredit != 0");
$cek02 = mysqli_fetch_array($query02);
$total_akhir = $cek02['total_akhir'];

$query01 = $db->query("SELECT SUM(potongan) AS total_potongan FROM pembelian WHERE tanggal <= '$sampai_tanggal' AND kredit != 0");
$cek01 = mysqli_fetch_array($query01);
$total_potongan = $cek01['total_potongan'];

$query20 = $db->query("SELECT SUM(tax) AS total_tax FROM pembelian WHERE tanggal <= '$sampai_tanggal' AND kredit != 0");
$cek20 = mysqli_fetch_array($query20);
$total_tax = $cek20['total_tax'];
		
	$nestedData = array();

	$nestedData[] = "<b style='color:red' >Total :</b>";
	$nestedData[] = "";
	$nestedData[] = "";
	$nestedData[] = "";
	$nestedData[] = "<b style='color:red'>". rp($total_akhir) ."</b>";
	$nestedData[] = "";
	$nestedData[] = "";
	$nestedData[] = "";
	$nestedData[] = "<b style='color:red'>". rp($total_potongan) ."</b>";
	$nestedData[] = "<b style='color:red'>". rp($total_tax) ."</b>";
	$nestedData[] = "";
	$nestedData[] = "<b style='color:red'>". rp($total_kredit) ."</b>";
	$nestedData[] = "<b style='color:red'>". rp($total_nilai_kredit) ."</b>";
	$nestedData[] = "";
	$nestedData[] = "";
	$nestedData[] = "";
	$nestedData[] = "";
	$nestedData[] = "";
$data[] = $nestedData;


$json_data = array(
			"draw"            => intval( $requestData['draw'] ),   // for every request/draw by clientside , they send a number as a parameter, when they recieve a response/data they first check the draw number, so we are sending same number in draw. 
			"recordsTotal"    => intval( $totalData ),  // total number of records
			"recordsFiltered" => intval( $totalFiltered ), // total number of records after searching, if there is no searching then totalFiltered = totalData
			"data"            => $data   // total data array
			);

echo json_encode($json_data);  // send data as json format

 ?>