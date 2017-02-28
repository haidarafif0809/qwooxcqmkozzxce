<?php include 'session_login.php';
/* Database connection start */
include 'db.php';
include 'sanitasi.php';

$dari_tanggal = stringdoang($_POST['dari_tanggal']);
$sampai_tanggal = stringdoang($_POST['sampai_tanggal']);

$query011 = $db->query("SELECT SUM(potongan) AS total_potongan, SUM(tax) AS total_tax, SUM(jumlah_barang) AS total_barang, SUM(subtotal) AS total_subtotal FROM detail_penjualan WHERE tanggal >= '$dari_tanggal' AND tanggal <= '$sampai_tanggal'");
$cek011 = mysqli_fetch_array($query011);
$total_potongan = $cek011['total_potongan'];
$total_tax = $cek011['total_tax'];
$total_barang = $cek011['total_barang'];
$total_subtotal = $cek011['total_subtotal'];


// storing  request (ie, get/post) global array to a variable  
$requestData= $_REQUEST;

$columns = array( 
// datatable column index  => database column name
	0 =>'no_faktur', 
	1 => 'kode_barang',
	2 => 'nama_barang',
	3 => 'jumlah_barang',
	4 => 'satuan',
	5 => 'harga',
	6 => 'subtotal',
	7 => 'potongan',
	8 => 'tax',
	9 => 'hpp',
	10 => 'sisa'
);

// getting total number records without any search
$sql =" SELECT s.nama,dp.no_faktur,dp.kode_barang,dp.nama_barang,dp.jumlah_barang,dp.satuan,dp.harga,dp.subtotal,dp.potongan,dp.tax,dp.hpp,dp.sisa ";
$sql.=" FROM detail_penjualan dp LEFT JOIN satuan s ON dp.satuan = s.id ";
$sql.=" WHERE dp.tanggal >= '$dari_tanggal' AND dp.tanggal <= '$sampai_tanggal' ";
$query=mysqli_query($conn, $sql) or die("eror.php: get employees");
$totalData = mysqli_num_rows($query);
$totalFiltered = $totalData;  // when there is no search parameter then total number rows = total number filtered rows.


$sql =" SELECT s.nama,dp.no_faktur,dp.kode_barang,dp.nama_barang,dp.jumlah_barang,dp.satuan,dp.harga,dp.subtotal,dp.potongan,dp.tax,dp.hpp,dp.sisa ";
$sql.=" FROM detail_penjualan dp LEFT JOIN satuan s ON dp.satuan = s.id ";
$sql.=" WHERE dp.tanggal >= '$dari_tanggal' AND dp.tanggal <= '$sampai_tanggal' ";
if( !empty($requestData['search']['value']) ) {   // if there is a search parameter, $requestData['search']['value'] contains search parameter


	$sql.=" AND ( dp.no_faktur LIKE '".$requestData['search']['value']."%' "; 
	$sql.=" OR dp.kode_barang LIKE '".$requestData['search']['value']."%' ";    
	$sql.=" OR dp.nama_barang LIKE '".$requestData['search']['value']."%' ";     
	$sql.=" OR s.nama LIKE '".$requestData['search']['value']."%' )";

}
$query=mysqli_query($conn, $sql) or die("eror.php2: get employees");
$totalFiltered = mysqli_num_rows($query); // when there is a search parameter then we have to modify total number filtered rows as per search result. 


$sql.= " ORDER BY CONCAT(tanggal,' ',jam) DESC LIMIT ".$requestData['start']." ,".$requestData['length']."   ";

/* $requestData['order'][0]['column'] contains colmun index, $requestData['order'][0]['dir'] contains order such as asc/desc  */	
$query=mysqli_query($conn, $sql) or die("employee-grid-data.php: get employees");

$data = array();
while( $row=mysqli_fetch_array($query) ) {  // preparing an array
	$nestedData=array();      
	$hpp_keluar = $db->query("SELECT SUM(sisa_barang) AS sisa_barang FROM hpp_keluar WHERE kode_barang = '$row[kode_barang]' AND no_faktur = '$row[no_faktur]'");
    $cek_awal_keluar = mysqli_fetch_array($hpp_keluar);
    $nilai_sisa = $cek_awal_keluar['sisa_barang'];

      $nestedData[] = $row['no_faktur'];
      $nestedData[] = $row['kode_barang'];
      $nestedData[] = $row['nama_barang'];
      $nestedData[] = $row['jumlah_barang'];

  if ($row['nama'] != "") {
      $nestedData[] = $row['nama'];
   }
   else{
   	  $nestedData[] = "-";
   }

      $nestedData[] = rp($row['harga']);
      $nestedData[] = rp($row['subtotal']);
      $nestedData[] = rp($row['potongan']);
      $nestedData[] = rp($row['tax']);

  if ($_SESSION['otoritas'] == 'Pimpinan' || $_SESSION['otoritas'] == 'Admin'){
      $nestedData[] = $row['hpp'];
  }

  if ($nilai_sisa != "") {
  	$nestedData[] = $nilai_sisa;
  }
  else{
      $nestedData[] = "-";
  }
	
	$data[] = $nestedData;
}


	$nestedData=array();      




      $nestedData[] = "<p style='color:red'> TOTAL </p>";
      $nestedData[] = "<p style='color:red'> - </p>";
      $nestedData[] = "<p style='color:red'> - </p>";
      $nestedData[] = "<p style='color:red'> ".rp($total_barang)." </p>";
      $nestedData[] = "<p style='color:red'> - </p>";
      $nestedData[] = "<p style='color:red'> - </p>";
      $nestedData[] = "<p style='color:red'> ".rp($total_subtotal)." </p>";
      $nestedData[] = "<p style='color:red'> ".rp($total_potongan)." </p>";
      $nestedData[] = "<p style='color:red'> ".rp($total_tax)." </p>";
      $nestedData[] = "<p style='color:red'> - </p>";
      $nestedData[] = "<p style='color:red'> - </p>";
	
	$data[] = $nestedData;

$json_data = array(
			"draw"            => intval( $requestData['draw'] ),   // for every request/draw by clientside , they send a number as a parameter, when they recieve a response/data they first check the draw number, so we are sending same number in draw. 
			"recordsTotal"    => intval( $totalData ),  // total number of records
			"recordsFiltered" => intval( $totalFiltered ), // total number of records after searching, if there is no searching then totalFiltered = totalData
			"data"            => $data   // total data array
			);

echo json_encode($json_data);  // send data as json format

?>