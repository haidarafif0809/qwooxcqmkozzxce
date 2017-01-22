 <?php session_start();
/* Database connection start */
include 'db.php';
/* Database connection end */
include 'sanitasi.php';

$dari_tanggal = stringdoang($_POST['dari_tanggal']);
$sampai_tanggal = stringdoang($_POST['sampai_tanggal']);
$dari_jam = stringdoang($_POST['dari_jam']);
$sampai_jam = stringdoang($_POST['sampai_jam']);
$golongan = stringdoang($_POST['golongan']);

$dari_waktu = $dari_tanggal." ".$dari_jam;
$sampai_waktu = $sampai_tanggal." ".$sampai_jam;

$jumlah_jual_awal = 0;
$jumlah_beli_awal = 0;


// storing  request (ie, get/post) global array to a variable  
$requestData= $_REQUEST;


$columns = array( 
// datatable column index  => database column name
  0 => 'id', 
  1 => 'nama_barang',
  2 => 'jumlah_barang',
  3 => 'subtotal'
);

 
// getting total number records without any search
$sql =" SELECT dp.kode_barang, dp.nama_barang, SUM(dp.jumlah_barang) AS jumlah, SUM(dp.subtotal) AS total ";
$sql.=" FROM detail_penjualan dp INNER JOIN barang p ON dp.kode_barang = p.kode_barang  WHERE p.golongan_barang = '$golongan' AND dp.waktu >= '$dari_waktu' AND dp.waktu <= '$sampai_waktu' GROUP BY p.kode_barang ";

$query=mysqli_query($conn, $sql) or die("eror 1");
$totalData = mysqli_num_rows($query);
$totalFiltered = $totalData;  // when there is no search parameter then total number rows = total number filtered rows.


$sql =" SELECT dp.nama_barang, SUM(dp.jumlah_barang) AS jumlah, SUM(dp.subtotal) AS total ";
$sql.=" FROM detail_penjualan dp INNER JOIN barang p ON dp.kode_barang = p.kode_barang  WHERE 1=1 AND p.golongan_barang = '$golongan' AND dp.waktu >= '$dari_waktu' AND dp.waktu <= '$sampai_waktu' ";
if( !empty($requestData['search']['value']) ) {   // if there is a search parameter, $requestData['search']['value'] contains search parameter
$sql.=" AND ( dp.nama_barang LIKE '".$requestData['search']['value']."%' )";
}
$query=mysqli_query($conn, $sql) or die("eror 2");
$totalFiltered = mysqli_num_rows($query); // when there is a search parameter then we have to modify total number filtered rows as per search result. 
$sql.=" GROUP BY dp.kode_barang ORDER BY dp.id ".$requestData['order'][0]['dir']."  LIMIT ".$requestData['start']." ,".$requestData['length']." ";
/* $requestData['order'][0]['column'] contains colmun index, $requestData['order'][0]['dir'] contains order such as asc/desc  */  
$query=mysqli_query($conn, $sql) or die("eror 3");

$data = array();
while( $row=mysqli_fetch_array($query) ) {  // preparing an array
  $nestedData=array(); 



      $jumlah_jual_awal = $row['jumlah'] + $jumlah_jual_awal;        
      $jumlah_beli_awal = $row['total'] + $jumlah_beli_awal;

      
      $nestedData[] = $row['nama_barang'];
      $nestedData[] = rp($row['jumlah']);
      $nestedData[] = rp($row['total']);

  $data[] = $nestedData;
}

$nestedData = array();
$nestedData[] = "<b style='color:red' >Total Keseluruhan:</b>";
$nestedData[] = "<b style='color:red'>". rp($jumlah_jual_awal) ."</b>";
$nestedData[] = "<b style='color:red'>". rp($jumlah_beli_awal) ."</b>";
$data[] = $nestedData;
  
$json_data = array(
      "draw"            => intval( $requestData['draw'] ),   // for every request/draw by clientside , they send a number as a parameter, when they recieve a response/data they first check the draw number, so we are sending same number in draw. 
      "recordsTotal"    => intval( $totalData ),  // total number of records
      "recordsFiltered" => intval( $totalData ), // total number of records after searching, if there is no searching then totalFiltered = totalData
      "data"            => $data   // total data array
      );

echo json_encode($json_data);  // send data as json format

?>






