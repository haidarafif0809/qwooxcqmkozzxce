<?php include 'session_login.php';
/* Database connection start */
include 'sanitasi.php';
include 'db.php';

/* Database connection end */

// storing  request (ie, get/post) global array to a variable  
$requestData= $_REQUEST;



$columns = array( 
// datatable column index  => database column name

    0=>'kode_pemeriksaan', 
    1=>'nama_pemeriksaan',
    2=>'harga_1',
    3=>'harga_2',
    4=>'harga_3',
    5=>'harga_4',
    6=>'harga_5',
    7=>'harga_6',
    8=>'harga_7',
    9=>'kontras',
    10=>'id'

);

// getting total number records without any search
$sql =" SELECT kode_pemeriksaan, nama_pemeriksaan, harga_1, harga_2, harga_3, harga_4, harga_5, harga_6, harga_7, kontras, no_urut, id ";
$sql.=" FROM pemeriksaan_radiologi";

$query = mysqli_query($conn, $sql) or die("eror 1");
$totalData = mysqli_num_rows($query);
$totalFiltered = $totalData;  // when there is no search parameter then total number rows = total number filtered rows.

if( !empty($requestData['search']['value']) ) {   // if there is a search parameter, $requestData['search']['value'] contains search parameter
$sql =" SELECT kode_pemeriksaan, nama_pemeriksaan, harga_1, harga_2, harga_3, harga_4, harga_5, harga_6, harga_7, kontras, no_urut, id ";
$sql.=" FROM pemeriksaan_radiologi";

    $sql.=" WHERE kode_pemeriksaan LIKE '".$requestData['search']['value']."%'";  
    $sql.=" OR nama_pemeriksaan LIKE '".$requestData['search']['value']."%'";

}

$query=mysqli_query($conn, $sql) or die("eror 2");
$totalFiltered = mysqli_num_rows($query); // when there is a search parameter then we have to modify total number filtered rows as per search result. 
        
$sql.=" ORDER BY no_urut ASC LIMIT ".$requestData['start']." ,".$requestData['length']."   ";


/* $requestData['order'][0]['column'] contains colmun index, $requestData['order'][0]['dir'] contains order such as asc/desc  */    
$query=mysqli_query($conn, $sql) or die("eror 3");


$data = array();
while( $row=mysqli_fetch_array($query) ) {  // preparing an array
  $nestedData=array(); 


      $nestedData[] = $row["kode_pemeriksaan"];

      $nestedData[] = "<p style='font-size:15px' class='edit-nama' data-id='".$row['id']."'> <span id='text-nama-".$row['id']."'>".$row["nama_pemeriksaan"]."</span> <input type='hidden' id='input-nama-".$row['id']."' value='".$row['nama_pemeriksaan']."' class='input_nama' data-id='".$row['id']."' autofocus='' data-kode='".$row['kode_pemeriksaan']."' data-nama='".$row['nama_pemeriksaan']."'> </p>";

      if ($row["kontras"] == '1') {
        $nestedData[] = "<p class='edit-kontras'  data-kode='".$row['kode_pemeriksaan']."' data-id='".$row['id']."'><span id='text-kontras-".$row['id']."'>Pakai Kontras</span>
            <select style='display:none' id='select-kontras-".$row['id']."' value='".$row['kontras']."' class='select-kontras' data-id='".$row['id']."' autofocus=''>
                <option value = '1'> Pakai Kontras </option>
                <option value = '0'> Tidak Pakai Kontras </option>
            </select>
          </p>";
       }
      else{
        $nestedData[] = "<p class='edit-kontras'  data-kode='".$row['kode_pemeriksaan']."' data-id='".$row['id']."'><span id='text-kontras-".$row['id']."'>Tidak Pakai Kontras</span>
            <select style='display:none' id='select-kontras-".$row['id']."' value='".$row['kontras']."' class='select-kontras' data-id='".$row['id']."' autofocus=''>
                <option value = '0'> Tidak Pakai Kontras </option>
                <option value = '1'> Pakai Kontras </option>
            </select>
          </p>";
      }


      $nestedData[] = "<p style='font-size:15px' class='edit-harga-1' data-id='".$row['id']."' align='right'> <span id='text-harga-1-".$row['id']."'>".rp($row["harga_1"])."</span> <input type='hidden' id='input-harga-1-".$row['id']."' value='".$row['harga_1']."' class='input_harga_1' data-id='".$row['id']."' autofocus='' data-kode='".$row['kode_pemeriksaan']."' data-harga-1='".$row['harga_1']."'> </p>";
/*
      $nestedData[] = "<p style='font-size:15px' class='edit-harga-2' data-id='".$row['id']."' align='right'> <span id='text-harga-2-".$row['id']."'>".rp($row["harga_2"])."</span> <input type='hidden' id='input-harga-2-".$row['id']."' value='".$row['harga_2']."' class='input_harga_2' data-id='".$row['id']."' autofocus='' data-kode='".$row['kode_pemeriksaan']."' data-harga-2='".$row['harga_2']."'> </p>";

      $nestedData[] = "<p style='font-size:15px' class='edit-harga-3' data-id='".$row['id']."' align='right'> <span id='text-harga-3-".$row['id']."'>".rp($row["harga_3"])."</span> <input type='hidden' id='input-harga-3-".$row['id']."' value='".$row['harga_3']."' class='input_harga_3' data-id='".$row['id']."' autofocus='' data-kode='".$row['kode_pemeriksaan']."' data-harga-3='".$row['harga_3']."'> </p>";

      $nestedData[] = "<p style='font-size:15px' class='edit-harga-4' data-id='".$row['id']."' align='right'> <span id='text-harga-4-".$row['id']."'>".rp($row["harga_4"])."</span> <input type='hidden' id='input-harga-4-".$row['id']."' value='".$row['harga_4']."' class='input_harga_4' data-id='".$row['id']."' autofocus='' data-kode='".$row['kode_pemeriksaan']."' data-harga-4='".$row['harga_4']."'> </p>";

      $nestedData[] = "<p style='font-size:15px' class='edit-harga-5' data-id='".$row['id']."' align='right'> <span id='text-harga-5-".$row['id']."'>".rp($row["harga_5"])."</span> <input type='hidden' id='input-harga-5-".$row['id']."' value='".$row['harga_5']."' class='input_harga_5' data-id='".$row['id']."' autofocus='' data-kode='".$row['kode_pemeriksaan']."' data-harga-5='".$row['harga_5']."'> </p>";

      $nestedData[] = "<p style='font-size:15px' class='edit-harga-6' data-id='".$row['id']."' align='right'> <span id='text-harga-6-".$row['id']."'>".rp($row["harga_6"])."</span> <input type='hidden' id='input-harga-6-".$row['id']."' value='".$row['harga_6']."' class='input_harga_6' data-id='".$row['id']."' autofocus='' data-kode='".$row['kode_pemeriksaan']."' data-harga-6='".$row['harga_6']."'> </p>";

      $nestedData[] = "<p style='font-size:15px' class='edit-harga-7' data-id='".$row['id']."' align='right'> <span id='text-harga-7-".$row['id']."'>".rp($row["harga_7"])."</span> <input type='hidden' id='input-harga-7-".$row['id']."' value='".$row['harga_7']."' class='input_harga_7' data-id='".$row['id']."' autofocus='' data-kode='".$row['kode_pemeriksaan']."' data-harga-7='".$row['harga_7']."'> </p>";

*/

      $nestedData[] = "<p style='font-size:15px' class='edit-urutan' data-id='".$row['id']."' align='right'> <span id='text-urutan-".$row['id']."'>".rp($row["no_urut"])."</span> <input type='hidden' id='input-urutan-".$row['id']."' value='".$row['no_urut']."' class='input_urutan' data-id='".$row['id']."' autofocus='' data-kode='".$row['kode_pemeriksaan']."' data-urutan='".$row['no_urut']."'> </p>";


      $nestedData[] = "<button class='btn btn-danger btn-sm btn-hapus' id='hapus-tbs-".$row['id']."' data-id='". $row['id'] ."' data-kode-pemeriksaan='". $row['kode_pemeriksaan'] ."' data-pemeriksaan='". $row['nama_pemeriksaan'] ."'>Hapus</button>";

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