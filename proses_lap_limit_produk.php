 <?php 
/* Database connection start */
include 'db.php';
include 'sanitasi.php';
include 'persediaan.function.php';

$sampai_tanggal = stringdoang($_POST['sampai_tanggal']);
$status_stok = stringdoang($_POST['status_stok']);

// storing  request (ie, get/post) global array to a variable  
$requestData= $_REQUEST;


$columns = array( 
// datatable column index  => database column name
  0 => 'id', 
  1 => 'kode_barang',
  2 => 'nama_barang',
  3 => 'jumlah_barang',
  4 => 'limit_stok',
  5 => 'over_stok',
  6 => 'status'
);

$array = array();
// getting total number records without any search

$sql ="SELECT kode_barang, nama_barang, limit_stok, over_stok, status ";
$sql.="FROM barang WHERE berkaitan_dgn_stok = 'Barang' ";
$query=mysqli_query($conn, $sql) or die("datatable_satuan.php: get employees");
$totalData = mysqli_num_rows($query);
$totalFiltered = $totalData;  // when there is no search parameter then total number rows = total number filtered rows.

if( !empty($requestData['search']['value']) ) {   // if there is a search parameter, $requestData['search']['value'] contains search parameter

  $sql ="SELECT kode_barang, nama_barang, limit_stok, over_stok, status ";
  $sql.="FROM barang WHERE berkaitan_dgn_stok = 'Barang' ";
  $sql.=" AND ( nama_barang LIKE '".$requestData['search']['value']."%' "; 
  $sql.=" OR kode_barang LIKE '".$requestData['search']['value']."%' )";

  $query=mysqli_query($conn, $sql) or die("datatable_satuan.phpppp: get employees");
  $totalFiltered = mysqli_num_rows($query); // when there is a search parameter then we have to modify total number filtered rows as per search result. 
}

$sql.= " ORDER BY id DESC LIMIT ".$requestData['start']." ,".$requestData['length']." ";

while ($data_barang = mysqli_fetch_array($query)) {
  $stok_barang = cekStokPertanggal($data_barang['kode_barang'],$sampai_tanggal);

  if ($status_stok == '0') {
    # code...semua
    array_push($array, ['kode_barang'=>$data_barang['kode_barang'],'nama_barang'=>$data_barang['nama_barang'],'limit_stok'=>$data_barang['limit_stok'],'over_stok'=>$data_barang['over_stok'],'status'=>$data_barang['status'], 'stok_barang'=>$stok_barang]);
  }
  else if ($status_stok == '1') {
    # code...cukup
    if ($stok_barang > $data_barang['limit_stok']) {
      array_push($array, ['kode_barang'=>$data_barang['kode_barang'],'nama_barang'=>$data_barang['nama_barang'],'limit_stok'=>$data_barang['limit_stok'],'over_stok'=>$data_barang['over_stok'],'status'=>$data_barang['status'], 'stok_barang'=>$stok_barang]);
    }

  }
  else if ($status_stok == '2') {
    # code...limit
    if ($stok_barang <= $data_barang['limit_stok']) {
      array_push($array, ['kode_barang'=>$data_barang['kode_barang'],'nama_barang'=>$data_barang['nama_barang'],'limit_stok'=>$data_barang['limit_stok'],'over_stok'=>$data_barang['over_stok'],'status'=>$data_barang['status'], 'stok_barang'=>$stok_barang]);
    }
  }
  else if ($status_stok == '3') {
    # code...over
    if ($stok_barang >= $data_barang['over_stok']) {
      array_push($array, ['kode_barang'=>$data_barang['kode_barang'],'nama_barang'=>$data_barang['nama_barang'],'limit_stok'=>$data_barang['limit_stok'],'over_stok'=>$data_barang['over_stok'],'status'=>$data_barang['status'], 'stok_barang'=>$stok_barang]);
    }
  }

}

$data = array();
foreach ($array as $arrays) {

        $nestedData = array();

        $nestedData[] = $arrays['kode_barang'];
        $nestedData[] = $arrays['nama_barang'];
        $nestedData[] = rp($arrays['stok_barang']);
        if ($status_stok == '0') {
          $status_stok = 'SEMUA';
        }
        else if ($status_stok == '1') {
          $status_stok = 'CUKUP';
        }
        else if ($status_stok == '2') {
          $status_stok = 'LIMIT';
        }
        else if ($status_stok == '3') {
          $status_stok = 'OVER STOK';
        }
        $nestedData[] = $status_stok;
        $nestedData[] = $arrays['limit_stok'];
        $nestedData[] = $arrays['over_stok'];
        $nestedData[] = $arrays['status']; 

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