<?php include 'session_login.php';
include 'db.php';
include 'sanitasi.php';

// storing  request (ie, get/post) global array to a variable  
$requestData= $_REQUEST;

$columns = array( 
// datatable column index  => database column name
	0 => 'text_hasil', 
	1 => 'nama_pemeriksaan',
	2 => 'kelompok_pemeriksaan',
	3 => 'model_hitung',
  4 => 'sub_lab',
  5 => 'kategori_index',
	6 => 'text_reference',
	7 => 'nomral_lk',
	8 => 'normal_pr',
  9 => 'detail',
	10 => 'metode',
	11 => 'edit',
	12 => 'hapus',
	13 => 'id'

);

// getting total number records without any search
$sql = "SELECT sh.sub_hasil_lab,sh.normal_lk2,sh.normal_pr2,sh.kategori_index,sh.nama_sub,jl.nama AS namanya ,bl.nama,sh.id,sh.nama_pemeriksaan,sh.kelompok_pemeriksaan,sh.model_hitung,sh.text_reference,sh.normal_lk,sh.normal_pr,sh.metode,sh.kategori_index,sh.text_hasil,sh.satuan_nilai_normal ";
$sql.= "FROM setup_hasil sh LEFT JOIN bidang_lab bl ON sh.kelompok_pemeriksaan = bl.id LEFT JOIN jasa_lab jl ON jl.id = sh.nama_pemeriksaan WHERE sub_hasil_lab = '0'";

$query=mysqli_query($conn, $sql) or die("1.php: get employees");
$totalData = mysqli_num_rows($query);
$totalFiltered = $totalData;  // when there is no search parameter then total number rows = total number filtered rows.

$sql = "SELECT sh.sub_hasil_lab,sh.normal_lk2,sh.normal_pr2,sh.kategori_index,sh.nama_sub,jl.nama AS namanya,bl.nama,sh.id,sh.nama_pemeriksaan,sh.kelompok_pemeriksaan,sh.model_hitung,sh.text_reference,sh.normal_lk,sh.normal_pr,sh.metode,sh.kategori_index,sh.text_hasil,sh.satuan_nilai_normal ";
$sql.= "FROM setup_hasil sh LEFT JOIN bidang_lab bl ON sh.kelompok_pemeriksaan = bl.id LEFT JOIN jasa_lab jl ON jl.id = sh.nama_pemeriksaan ";
$sql.=" WHERE sub_hasil_lab = '0'";

if( !empty($requestData['search']['value']) ) {   // if there is a search parameter, $requestData['search']['value'] contains search parameter
	$sql.=" AND ( jl.nama LIKE '".$requestData['search']['value']."%' "; 
	$sql.=" OR bl.nama LIKE '".$requestData['search']['value']."%' )";
}

$query=mysqli_query($conn, $sql) or die("2.php: get employees");
$totalFiltered = mysqli_num_rows($query); // when there is a search parameter then we have to modify total number filtered rows as per search result. 
$sql.=" ORDER BY id ".$requestData['order'][0]['dir']." LIMIT ".$requestData['start']." ,".$requestData['length']."";
/* $requestData['order'][0]['column'] contains colmun index, $requestData['order'][0]['dir'] contains order such as asc/desc  */	
$query=mysqli_query($conn, $sql) or die("3.php: get employees");

$data = array();
while( $row=mysqli_fetch_array($query) ) {  // preparing an array
	$nestedData=array(); 

// start tampilkan data
	 
if ($row['model_hitung'] == 'Text')
    {


      if ($row['kategori_index'] == 'Detail')
      {
         $nestedData[] = $row['text_hasil'];
      }
      else
      {
       $nestedData[] = $row['text_hasil'];
      }
     
      $nestedData[] = $row['namanya'];
      $nestedData[] = $row['nama'];

      $nestedData[] = $row['nama_sub'];
      $nestedData[] = $row['kategori_index'];

      $nestedData[] = $row['model_hitung'];
      $nestedData[] = $row['text_reference'];
      $nestedData[] = $row['normal_lk'];
      $nestedData[] = $row['normal_pr'];
      $nestedData[] = $row['metode'];


   if($row['kategori_index'] == 'Header')
     {
      $nestedData[] = "<button class='btn btn-floating  btn-info detail-set-up' data-id='".$row['id']."' data-sub='".$row['sub_hasil_lab']."' ><i class='fa fa-list'></i></button>";
    }
    else
    {
      $nestedData[] = "<p style='color:red'>Data Detail</p>";
    }

    if($row['kategori_index'] == 'Header')
    {
      $nestedData[] = "<p style='color:red'>Header Tidak Bisa Edit</p>";
    }
    else
    {
      $nestedData[] = "<a href='edit_setup_hasil.php?id=".$row['id']."'class='btn btn-warning'> <i class='fa fa-edit'></i> </a>";
    }
      $nestedData[] = " <button data-id='".$row['id']."' class='btn btn-danger delete'> <i class='fa fa-trash'></i> </button>
      ";

        }

else
{
	 
      if ($row['kategori_index'] == 'Detail')
      {
         $nestedData[] = $row['text_hasil'];
      }
      else
      {
         $nestedData[] = $row['text_hasil'];

      }
     
      $nestedData[] = $row['namanya'];
      $nestedData[] = $row['nama'];

      $nestedData[] = $row['nama_sub'];
      $nestedData[] = $row['kategori_index'];

      $nestedData[] = $row['model_hitung'];
      $nestedData[] = $row['text_reference'];

      $model_hitung = $row['model_hitung'];

switch ($model_hitung) {
    case "Lebih Kecil Dari":
        $nestedData[] = "&lt;&nbsp; ". $row['normal_lk']."&nbsp;". $row['satuan_nilai_normal']."";
        $nestedData[] = "&lt;&nbsp; ".$row['normal_pr']."&nbsp;". $row['satuan_nilai_normal']."";
        
        break;

    case "Lebih Kecil Sama Dengan":
        $nestedData[] = "&lt;=&nbsp; ". $row['normal_lk']."&nbsp;". $row['satuan_nilai_normal']."";  
        $nestedData[] = " &lt;=&nbsp; ". $row['normal_pr']."&nbsp;". $row['satuan_nilai_normal']."";
        break;

    case "Lebih Besar Dari":
        $nestedData[] = "&gt;&nbsp; ". $row['normal_lk']."&nbsp;". $row['satuan_nilai_normal']."";
        $nestedData[] = "&gt;&nbsp; ". $row['normal_pr']."&nbsp;". $row['satuan_nilai_normal']."";
        break;

    case "Lebih Besar Sama Dengan":
        $nestedData[] = "&gt;=&nbsp; ". $row['normal_lk']."&nbsp;". $row['satuan_nilai_normal']."";
        $nestedData[] = "&gt;=&nbsp; ". $row['normal_pr']."&nbsp;". $row['satuan_nilai_normal']."";
        break;
    
    case "Antara Sama Dengan":
        $nestedData[] = "". $row['normal_lk']."&nbsp;-&nbsp; ". $row['normal_lk2']."&nbsp;". $row['satuan_nilai_normal']."";
        $nestedData[] = "". $row['normal_pr']."&nbsp;-&nbsp; ". $row['normal_pr2']."&nbsp;". $row['satuan_nilai_normal']."";
        break;
	} 

     $nestedData[] = $row['metode'];

     if($row['kategori_index'] == 'Header')
     {
      $nestedData[] = "<button class='btn btn-floating  btn-info detail-set-up' data-id='".$row['id']."' data-sub='".$row['sub_hasil_lab']."' ><i class='fa fa-list'></i></button>";
    }
    else
    {
      $nestedData[] = "<p style='color:red'>Data Detail</p>";
    }

    if($row['kategori_index'] == 'Header')
    {
      $nestedData[] = "<p style='color:red'>Header Tidak Bisa Edit</p>";
    }
    else
    {
      $nestedData[] = "<a href='edit_setup_hasil.php?id=".$row['id']."'class='btn btn-warning'> <i class='fa fa-edit'></i>  </a>";
    }
      $nestedData[] = "<button data-id='".$row['id']."' class='btn btn-danger delete'><i class='fa fa-trash'></i>  </button>";

}
// end tampilkan data
	
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