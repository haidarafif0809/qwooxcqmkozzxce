 <?php 
/* Database connection start */
include 'db.php';
/* Database connection end */
include 'sanitasi.php';

$dari_tanggal = stringdoang($_POST['dari_tanggal']);
$sampai_tanggal = stringdoang($_POST['sampai_tanggal']);
$golongan = stringdoang($_POST['golongan']);


$sum_detail_penjualan = $db->query("SELECT SUM(jumlah_barang) AS jumlah, SUM(subtotal) AS total FROM detail_penjualan WHERE tipe_produk = '$golongan' AND tanggal >= '$dari_tanggal' AND tanggal <= '$sampai_tanggal'");
$data_detail_penjualan = mysqli_fetch_array($sum_detail_penjualan);


$total_nilai = $data_detail_penjualan['total'];
$jumlah_produk = $data_detail_penjualan['jumlah'];


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
$sql =" SELECT SUM(jumlah_barang) AS jumlah, SUM(subtotal) AS total, nama_barang ";
$sql.=" FROM detail_penjualan WHERE tipe_produk = '$golongan' AND tanggal >= '$dari_tanggal' AND tanggal <= '$sampai_tanggal' GROUP BY kode_barang ";

$query=mysqli_query($conn, $sql) or die("eror 1");
$totalData = mysqli_num_rows($query);
$totalFiltered = $totalData;  // when there is no search parameter then total number rows = total number filtered rows.


$sql =" SELECT SUM(jumlah_barang) AS jumlah, SUM(subtotal) AS total, nama_barang ";
$sql.=" FROM detail_penjualan WHERE tipe_produk = '$golongan' AND tanggal >= '$dari_tanggal' AND tanggal <= '$sampai_tanggal' ";

if( !empty($requestData['search']['value']) ) {   // if there is a search parameter, $requestData['search']['value'] contains search parameter
$sql.=" AND ( nama_barang LIKE '".$requestData['search']['value']."%' )";
}

$query=mysqli_query($conn, $sql) or die("eror 2");
$totalFiltered = mysqli_num_rows($query); // when there is a search parameter then we have to modify total number filtered rows as per search result. 
$sql.=" GROUP BY kode_barang ORDER BY kode_barang ".$requestData['order'][0]['dir']."  LIMIT ".$requestData['start']." ,".$requestData['length']." ";
/* $requestData['order'][0]['column'] contains colmun index, $requestData['order'][0]['dir'] contains order such as asc/desc  */  

$query=mysqli_query($conn, $sql) or die("eror 3");



$data = array();
while( $row=mysqli_fetch_array($query) ) {  // preparing an array
  $nestedData=array(); 
      
      $nestedData[] = $row['nama_barang'];
      $nestedData[] = "<p align='right'> ".rp($row['jumlah'])." <p>";
      $nestedData[] = "<p align='right'> ".rp($row['total'])." <p>";

  $data[] = $nestedData;
}
  $nestedData=array(); 

      $nestedData[] = "<p style='color:red'> TOTAL <p>";
      $nestedData[] = "<p style='color:red' align='right'> ".rp($jumlah_produk)." <p>";
      $nestedData[] = "<p style='color:red' align='right'> ".rp($total_nilai)." <p>";

  $data[] = $nestedData;

  
$json_data = array(
      "draw"            => intval( $requestData['draw'] ),   // for every request/draw by clientside , they send a number as a parameter, when they recieve a response/data they first check the draw number, so we are sending same number in draw. 
      "recordsTotal"    => intval( $totalData ),  // total number of records
      "recordsFiltered" => intval( $totalData ), // total number of records after searching, if there is no searching then totalFiltered = totalData
      "data"            => $data   // total data array
      );

echo json_encode($json_data);  // send data as json format

?>






