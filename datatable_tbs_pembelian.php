<?php include 'session_login.php';
/* Database connection start */
include 'sanitasi.php';
include 'db.php';

/* Database connection end */

$session_id = session_id();

// storing  request (ie, get/post) global array to a variable  
$requestData= $_REQUEST;


 
$columns = array( 
// datatable column index  => database column name

    0=>'kode_barang',
    1=>'nama_barang',
    2=>'jumlah_barang',
    3=>'satuan',
    4=>'harga',
    5=>'subtotal',
    6=>'potongan',
    7=>'tax',
    8=>'hapus',
    9=>'id'


);

// getting total number records without any search
$sql =" SELECT tp.id, tp.no_faktur, tp.session_id, tp.kode_barang, tp.nama_barang, tp.jumlah_barang, tp.satuan, tp.harga, tp.subtotal, tp.potongan, tp.tax, s.nama  ";
$sql.=" FROM tbs_pembelian tp INNER JOIN satuan s ON tp.satuan = s.id ";
$sql.=" WHERE tp.session_id = '$session_id' ";

$query = mysqli_query($conn, $sql) or die("eror 1");
$totalData = mysqli_num_rows($query);
$totalFiltered = $totalData;  // when there is no search parameter then total number rows = total number filtered rows.

if( !empty($requestData['search']['value']) ) {   // if there is a search parameter, $requestData['search']['value'] contains search parameter
$sql =" SELECT tp.id, tp.no_faktur, tp.session_id, tp.kode_barang, tp.nama_barang, tp.jumlah_barang, tp.satuan, tp.harga, tp.subtotal, tp.potongan, tp.tax, s.nama  ";
$sql.=" FROM tbs_pembelian tp INNER JOIN satuan s ON tp.satuan = s.id ";
$sql.=" WHERE tp.session_id = '$session_id' ";

    $sql.=" AND (tp.no_faktur LIKE '".$requestData['search']['value']."%'";  
    $sql.=" OR tp.kode_barang LIKE '".$requestData['search']['value']."%' )";

    $query=mysqli_query($conn, $sql) or die("eror 2");

    $totalFiltered = mysqli_num_rows($query);

}


 // when there is a search parameter then we have to modify total number filtered rows as per search result. 
        
$sql.=" ORDER BY tp.id DESC LIMIT ".$requestData['start']." ,".$requestData['length']."   ";

/* $requestData['order'][0]['column'] contains colmun index, $requestData['order'][0]['dir'] contains order such as asc/desc  */    
$query=mysqli_query($conn, $sql) or die("eror 3");


$data = array();

while( $row = mysqli_fetch_array($query) ) {  // preparing an array
  $nestedData = array();   


      $nestedData[] = $row["kode_barang"];
      $nestedData[] = $row["nama_barang"];
      $nestedData[] = "<p class='edit-jumlah' data-id='".$row['id']."' data-faktur='".$row['no_faktur']."' data-kode='".$row['kode_barang']."'><span id='text-jumlah-".$row['id']."'>". $row['jumlah_barang'] ."</span> <input type='hidden' id='input-jumlah-".$row['id']."' value='".$row['jumlah_barang']."' class='input_jumlah' data-id='".$row['id']."' autofocus='' data-kode='".$row['kode_barang']."' data-harga='".$row['harga']."' > </p>";
      //TBS FEE

      $nestedData[] = $row["nama"];
      $nestedData[] = koma($row["harga"],2);
      $nestedData[] = "<span id='text-subtotal-".$row['id']."'>". koma($row['subtotal'],2) ."</span>";
      $nestedData[] = "<span id='text-potongan-".$row['id']."'>". koma($row['potongan'],2) ."</span>";
      $nestedData[] = "<span id='text-tax-".$row['id']."'>". koma($row['tax'],2) ."</span>";
      
      $nestedData[] = "<button class='btn btn-danger btn-sm btn-hapus-tbs' id='hapus-tbs-".$row['id']."' data-id='". $row['id'] ."' data-subtotal='".$row['subtotal']."' data-barang='". $row['nama_barang'] ."'><span class='glyphicon glyphicon-trash'> </span> Hapus </button>";
      
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