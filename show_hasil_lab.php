<?php include 'session_login.php';

include 'sanitasi.php';
include 'db.php';

$no_faktur = stringdoang($_POST['no_faktur']);
$no_reg = stringdoang($_POST['no_reg']);

$query_jenis_kelamin = $db->query("SELECT jenis_kelamin FROM registrasi WHERE no_reg = '$no_reg'");
$data_jenis_kelamin = mysqli_fetch_array($query_jenis_kelamin);
$jenis_kelamin = $data_jenis_kelamin['jenis_kelamin'];

// storing  request (ie, get/post) global array to a variable  
$requestData= $_REQUEST;



$columns = array( 
// datatable column index  => database column name
    0 => 'nama_periksa',
    1 => 'hasil_periksa',
    2 => 'nilai_normal',
    3 => 'status_rawat',
    4 => 'id'

);

$query_sub_header = $db->query("SELECT id_sub_header FROM hasil_lab WHERE no_reg = '$no_reg' GROUP BY id_sub_header");
while($data_sub_header = mysqli_fetch_array($query_sub_header))
{
  $query_nama_setup = $db->query("SELECT id,nama_pemeriksaan FROM setup_hasil WHERE id = '$data_sub_header[id_sub_header]' AND kategori_index = 'Header'");
  $data_nama_setup = mysqli_fetch_array($query_nama_setup);
   $face_drop = mysqli_num_rows($query_nama_setup);
  $id_set_up = $data_nama_setup['nama_pemeriksaan'];
  $id_setup = $data_nama_setup['id'];

  $query_nama_jasa_lab = $db->query("SELECT nama FROM jasa_lab WHERE id = '$id_set_up' GROUP BY id");
  $data_nama_jasa = mysqli_fetch_array($query_nama_jasa_lab);
  $nama_sub_header = $data_nama_jasa['nama'];


// getting total number records without any search
$sql =" SELECT id,nama_pemeriksaan,hasil_pemeriksaan,model_hitung,nilai_normal_lk,satuan_nilai_normal,nilai_normal_pr,status_pasien  ";
$sql.=" FROM hasil_lab ";
$sql.=" WHERE no_reg = '$no_reg' AND no_faktur = '$no_faktur' AND status = 'Selesai' AND id_sub_header = '$id_setup' AND id_sub_header != '' AND id_sub_header != '0'";

$query = mysqli_query($conn, $sql) or die("eror 1");
$totalData = mysqli_num_rows($query);
$totalFiltered = $totalData;  // when there is no search parameter then total number rows = total number filtered rows.

if( !empty($requestData['search']['value']) ) {   // if there is a search parameter, $requestData['search']['value'] contains search parameter

$sql =" SELECT id,nama_pemeriksaan,hasil_pemeriksaan,model_hitung,nilai_normal_lk,satuan_nilai_normal,nilai_normal_pr,status_pasien  ";
$sql.=" FROM hasil_lab ";
$sql.=" WHERE no_reg = '$no_reg' AND no_faktur = '$no_faktur' AND status = 'Selesai' AND id_sub_header = '$id_setup' AND id_sub_header != '' AND id_sub_header != '0'";

  $sql.=" AND (nama_pemeriksaan LIKE '".$requestData['search']['value']."%'";
  $sql.=" OR status_pasien LIKE '".$requestData['search']['value']."%' ";
  $sql.=" OR hasil_pemeriksaan LIKE '".$requestData['search']['value']."%')";

}

$query=mysqli_query($conn, $sql) or die("eror 2");
$totalFiltered = mysqli_num_rows($query); // when there is a search parameter then we have to modify total number filtered rows as per search result. 
        
$sql.=" ORDER BY id DESC LIMIT ".$requestData['start']." ,".$requestData['length']."   ";

/* $requestData['order'][0]['column'] contains colmun index, $requestData['order'][0]['dir'] contains order such as asc/desc  */    
$query=mysqli_query($conn, $sql) or die("eror 3");

$data = array();

if($face_drop >= 1){

    $nestedData = array();
    $hitung_baris = 0;

    if($hitung_baris != 0){
          $nama_sub_header = '';
      }
          $hitung_baris++;

          $nestedData[] = "<b> ".$nama_sub_header."</b>";
          $nestedData[] = "-";
          $nestedData[] = "-";
          $nestedData[] = "-";
             
          $data[] = $nestedData;
}

while($row=mysqli_fetch_array($query) ) { // preparing an array
  $nestedData=array(); 



      $nestedData[] = "<li> ". $row['nama_pemeriksaan'] ."</li>";

      $nestedData[] = "<a class='edit-nama' data-id='".$row['id']."'><span id='text-nama-".$row['id']."'>". $row['hasil_pemeriksaan'] ."</span> <input type='hidden' id='input-nama-".$row['id']."' value='".$row['hasil_pemeriksaan']."' class='input_nama' data-id='".$row['id']."' data-nama='".$row['hasil_pemeriksaan']."' autofocus=''> </a>";

       $model_hitung = $row['model_hitung']; 
      if($model_hitung == ''){
             $nestedData[] = "-";
      }
      else{

          if($jenis_kelamin == 'laki-laki'){
          switch ($model_hitung) {
          case "Lebih Kecil Dari":
          $nestedData[] = "<td>&lt;&nbsp; ". $row['nilai_normal_lk']."&nbsp;". $row['satuan_nilai_normal']." </td>
              ";
              break;
          case "Lebih Kecil Sama Dengan":
           $nestedData[] = "<td>&lt;=&nbsp; ". $row['nilai_normal_lk']."&nbsp;". $row['satuan_nilai_normal']." </td>
              ";
              break;
          case "Lebih Besar Dari":
           $nestedData[] = "<td>&gt;&nbsp; ". $row['nilai_normal_lk']."&nbsp;". $row['satuan_nilai_normal']." </td>
              ";
              break;
          case "Lebih Besar Sama Dengan":
             $nestedData[] = "<td>&gt;=&nbsp; ". $row['nilai_normal_lk']."&nbsp;". $row['satuan_nilai_normal']." </td>
              ";
              break;
          case "Antara Sama Dengan":
              $nestedData[] = "<td>". $row['nilai_normal_lk']."&nbsp;-&nbsp; ". $row['normal_lk2']."&nbsp;". $row['satuan_nilai_normal']." </td>
              ";
              break;

              //Text
          case "Text":
              $nestedData[] = "<td>&nbsp; ". $row['nilai_normal_lk']."&nbsp;". $row['satuan_nilai_normal']." </td>
              ";
              break;
              //End Text
              } 
          }
          else{
          switch ($model_hitung) {
          case "Lebih Kecil Dari":
             $nestedData[] = "
              <td>&lt;&nbsp; ". $row['nilai_normal_pr']."&nbsp;". $row['satuan_nilai_normal']." </td>
              ";
              break;
          case "Lebih Kecil Sama Dengan":
            $nestedData[] = "
              <td>&lt;=&nbsp; ". $row['nilai_normal_pr']."&nbsp;". $row['satuan_nilai_normal']." </td>
              ";
              break;
          case "Lebih Besar Dari":
             $nestedData[] = "
              <td>&gt;&nbsp; ". $row['nilai_normal_pr']."&nbsp;". $row['satuan_nilai_normal']." </td>
              ";
              break;
          case "Lebih Besar Sama Dengan":
             $nestedData[] = "
              <td>&gt;=&nbsp; ". $row['nilai_normal_pr']."&nbsp;". $row['satuan_nilai_normal']." </td>
              ";
              break;
          case "Antara Sama Dengan":
             $nestedData[] = "
              <td>". $row['nilai_normal_pr']."&nbsp;-&nbsp; ". $row['normal_pr2']."&nbsp;". $row['satuan_nilai_normal']." </td>
              ";
              break;

              //Text
          case "Text":
              $nestedData[] = "
              <td>&nbsp; ". $row['nilai_normal_pr']."&nbsp;". $row['satuan_nilai_normal']." </td>
              ";
              break;
              //End Text

              } 
            }
          }


      $nestedData[] = $row["status_pasien"];
      $nestedData[] = $row["id"];
      $data[] = $nestedData;

    }
  
}//drop_master ENDING




//START HASIL DETAIL (SETUP SENDIRIAN)!!
$sql_moon = "SELECT id,nama_pemeriksaan,hasil_pemeriksaan,model_hitung,nilai_normal_lk,satuan_nilai_normal,nilai_normal_pr,status_pasien FROM hasil_lab WHERE no_reg = '$no_reg' AND status = 'Selesai' AND (id_sub_header = 0 OR id_sub_header IS NULL) ";

$query12 = mysqli_query($conn, $sql_moon) or die("eror line 1");
$totalData2 = mysqli_num_rows($query12);
$totalFiltered2 = $totalData2; 
            //menyimpan data sementara yang ada pada $perintah
    if( !empty($requestData['search']['value']) ) {   // if there is a search parameter, $requestData['search']['value'] contains search parameter

$sql_moon = "SELECT id,nama_pemeriksaan,hasil_pemeriksaan,model_hitung,nilai_normal_lk,satuan_nilai_normal,nilai_normal_pr,status_pasien FROM hasil_lab WHERE no_reg = '$no_reg' AND status = 'Selesai' AND (id_sub_header = 0 OR id_sub_header IS NULL) ";


    $sql.=" AND (nama_pemeriksaan LIKE '".$requestData['search']['value']."%'";  
    $sql.=" OR status_pasien LIKE '".$requestData['search']['value']."%' ";
    $sql.=" OR hasil_pemeriksaan LIKE '".$requestData['search']['value']."%' )";

}
$query2=mysqli_query($conn, $sql_moon) or die("eror line 2");
$totalFiltered2 = mysqli_num_rows($query2); // when there is a search parameter then we have to modify total number filtered rows as per search result. 
        
$sql_moon.=" ORDER BY id DESC LIMIT ".$requestData['start']." ,".$requestData['length']."   ";

/* $requestData['order'][0]['column'] contains colmun index, $requestData['order'][0]['dir'] contains order such as asc/desc  */    
$query2=mysqli_query($conn, $sql_moon) or die("eror 3");

$next = array();
while( $drop_two=mysqli_fetch_array($query2) ) { // preparing an array
          $nestedData=array(); 

          $nestedData[] = "<b> ". $drop_two['nama_pemeriksaan'] ."</b>";

    $nestedData[] = "<a class='edit-nama' data-id='".$drop_two['id']."'><span id='text-nama-".$drop_two['id']."'>". $drop_two['hasil_pemeriksaan'] ."</span> <input type='hidden' id='input-nama-".$drop_two['id']."' value='".$drop_two['hasil_pemeriksaan']."' class='input_nama' data-id='".$drop_two['id']."' data-nama='".$drop_two['hasil_pemeriksaan']."' autofocus=''> </a>";


           $model_hitung = $drop_two['model_hitung']; 
      if($model_hitung == ''){
             $nestedData[] = "-";
      }
      else{

          if($jenis_kelamin == 'laki-laki'){
          switch ($model_hitung) {
          case "Lebih Kecil Dari":
          $nestedData[] = "<td>&lt;&nbsp; ". $drop_two['nilai_normal_lk']."&nbsp;". $drop_two['satuan_nilai_normal']." </td>
              ";
              break;
          case "Lebih Kecil Sama Dengan":
           $nestedData[] = "<td>&lt;=&nbsp; ". $drop_two['nilai_normal_lk']."&nbsp;". $drop_two['satuan_nilai_normal']." </td>
              ";
              break;
          case "Lebih Besar Dari":
           $nestedData[] = "<td>&gt;&nbsp; ". $drop_two['nilai_normal_lk']."&nbsp;". $drop_two['satuan_nilai_normal']." </td>
              ";
              break;
          case "Lebih Besar Sama Dengan":
             $nestedData[] = "<td>&gt;=&nbsp; ". $drop_two['nilai_normal_lk']."&nbsp;". $drop_two['satuan_nilai_normal']." </td>
              ";
              break;
          case "Antara Sama Dengan":
              $nestedData[] = "<td>". $drop_two['nilai_normal_lk']."&nbsp;-&nbsp; ". $drop_two['normal_lk2']."&nbsp;". $drop_two['satuan_nilai_normal']." </td>
              ";
              break;

              //Text
          case "Text":
              $nestedData[] = "<td>&nbsp; ". $drop_two['nilai_normal_lk']."&nbsp;". $drop_two['satuan_nilai_normal']." </td>
              ";
              break;
              //End Text
              } 
          }
          else{
          switch ($model_hitung) {
          case "Lebih Kecil Dari":
             $nestedData[] = "
              <td>&lt;&nbsp; ". $drop_two['nilai_normal_pr']."&nbsp;". $drop_two['satuan_nilai_normal']." </td>
              ";
              break;
          case "Lebih Kecil Sama Dengan":
            $nestedData[] = "
              <td>&lt;=&nbsp; ". $drop_two['nilai_normal_pr']."&nbsp;". $drop_two['satuan_nilai_normal']." </td>
              ";
              break;
          case "Lebih Besar Dari":
             $nestedData[] = "
              <td>&gt;&nbsp; ". $drop_two['nilai_normal_pr']."&nbsp;". $drop_two['satuan_nilai_normal']." </td>
              ";
              break;
          case "Lebih Besar Sama Dengan":
             $nestedData[] = "
              <td>&gt;=&nbsp; ". $drop_two['nilai_normal_pr']."&nbsp;". $drop_two['satuan_nilai_normal']." </td>
              ";
              break;
          case "Antara Sama Dengan":
             $nestedData[] = "
              <td>". $drop_two['nilai_normal_pr']."&nbsp;-&nbsp; ". $drop_two['normal_pr2']."&nbsp;". $drop_two['satuan_nilai_normal']." </td>
              ";
              break;

              //Text
          case "Text":
              $nestedData[] = "
              <td>&nbsp; ". $drop_two['nilai_normal_pr']."&nbsp;". $drop_two['satuan_nilai_normal']." </td>
              ";
              break;
              //End Text

              } 
            }
          }
         
           $nestedData[] = $drop_two["status_pasien"];

          $nestedData[] = $drop_two["id"];

            $data[] = $nestedData;

          } //END WHILE
//ENDING HASIL DETAIL (SETUP SENDIRIAN)!!

$json_data = array(
            "draw"            => intval( $requestData['draw'] ),   // for every request/draw by clientside , they send a number as a parameter, when they recieve a response/data they first check the draw number, so we are sending same number in draw. 
            "recordsTotal"    => intval( $totalData ),  // total number of records
            "recordsFiltered" => intval( $totalFiltered ), // total number of records after searching, if there is no searching then totalFiltered = totalData
            "data"            => $data, $next// total data array
            );

echo json_encode($json_data);  // send data as json format



 ?>

