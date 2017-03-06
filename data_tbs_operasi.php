<?php include 'session_login.php';
/* Database connection start */
include 'sanitasi.php';
include 'db.php';

/* Database connection end */

$no_reg = stringdoang($_POST['no_reg']);

$pilih_akses_tombol = $db->query("SELECT * FROM otoritas_penjualan_inap WHERE id_otoritas = '$_SESSION[otoritas_id]' ");
$otoritas_tombol = mysqli_fetch_array($pilih_akses_tombol);
// storing  request (ie, get/post) global array to a variable  
$requestData= $_REQUEST;



$columns = array( 
// datatable column index  => database column name

    0=>'operasi', 
    1=>'no_reg',
    2=>'harga_jual',
    3=>'petugas_input',
    4=>'waktu',
    5=>'id',
    6=>'sub_operasi'


);

// getting total number records without any search
$sql =" SELECT td.operasi, td.no_reg, td.harga_jual,td.petugas_input,td.waktu,td.id,td.sub_operasi,u.nama, op.nama_operasi";
$sql.=" FROM tbs_operasi td INNER JOIN user u ON td.petugas_input = u.id INNER JOIN operasi op ON td.operasi = op.id_operasi ";
$sql.=" WHERE td.no_reg = '$no_reg'";

$query = mysqli_query($conn, $sql) or die("eror 1");
$totalData = mysqli_num_rows($query);
$totalFiltered = $totalData;  // when there is no search parameter then total number rows = total number filtered rows.

if( !empty($requestData['search']['value']) ) {   // if there is a search parameter, $requestData['search']['value'] contains search parameter
$sql =" SELECT td.operasi, td.no_reg, td.harga_jual,td.petugas_input,td.waktu,td.id,td.sub_operasi,u.nama, op.nama_operasi";
$sql.=" FROM tbs_operasi td INNER JOIN user u ON td.petugas_input = u.id INNER JOIN operasi op ON td.operasi = op.id_operasi ";
$sql.=" WHERE td.no_reg = '$no_reg'";

    $sql.=" AND (nama_operasi LIKE '".$requestData['search']['value']."%'";  
    $sql.=" OR waktu LIKE '".$requestData['search']['value']."%' )";

}


$query=mysqli_query($conn, $sql) or die("eror 2");
$totalFiltered = mysqli_num_rows($query); // when there is a search parameter then we have to modify total number filtered rows as per search result. 
        
$sql.=" ORDER BY id ".$requestData['order'][0]['dir']."  LIMIT ".$requestData['start']." ,".$requestData['length']."   ";

/* $requestData['order'][0]['column'] contains colmun index, $requestData['order'][0]['dir'] contains order such as asc/desc  */    
$query=mysqli_query($conn, $sql) or die("eror 3");


$data = array();
while( $row=mysqli_fetch_array($query) ) {  // preparing an array
  $nestedData=array(); 


      $nestedData[] = $row["no_reg"];
      $nestedData[] = $row["nama_operasi"];
      $nestedData[] = rp($row["harga_jual"]);
      $nestedData[] = $row["nama"];

      //START untuk EDIT WAKTU PADA OPERASI 
     
      if ($otoritas_tombol['edit_tanggal_inap'] > 0){

     

         $nestedData[] = "<p style='font-size:15px' align='right' class='edit-waktu-or' data-id='".$row['id']."' > <span id='text-waktu-".$row['id']."'> ".$row['waktu']." </span> <input type='hidden' id='input-waktu-".$row['id']."' value='".$row['waktu']."' class='input_waktu_or' data-id='".$row['id']."' autofocus='' data-id='".$row['id']."'> </p>";
     }
    else
    {
        $nestedData[] = "<p style='font-size:15px' align='right' class='gk_bisa_edit_tanggal'> ".$row['waktu']." </p>";
    }
    //ENDING untuk EDIT WAKTU PADA OPERASI 


      $nestedData[] = "<a href='proses_registrasi_operasi.php?id=".$row["id"]."&no_reg=".$row["no_reg"]."&sub_operasi=".$row["sub_operasi"]."&operasi=".$row["operasi"]."' class='btn btn-sm btn-success' target='blank'>Input Detail </a>";

      $nestedData[] = "<button data-id='".$row['id']."' data-subtotal-ops='".$row['harga_jual']."'  id='hapus-ops-".$row['id']."' data-operasi='".$row['operasi']."' data-sub='".$row['sub_operasi']."' class='btn btn-danger btn-sm delete'><span class='glyphicon glyphicon-trash'></span> Hapus </button>";

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