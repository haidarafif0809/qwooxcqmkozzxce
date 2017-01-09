<?php include 'session_login.php';
/* Database connection start */
include 'db.php';

/* Database connection end */


$pilih_akses_rekam_medik = $db->query("SELECT rekam_medik_ri_lihat, rekam_medik_ri_tambah, rekam_medik_ri_edit, rekam_medik_ri_hapus FROM otoritas_rekam_medik WHERE id_otoritas = '$_SESSION[otoritas_id]'");
$rekam_medik = mysqli_fetch_array($pilih_akses_rekam_medik);


// storing  request (ie, get/post) global array to a variable  
$requestData= $_REQUEST;

$columns = array( 
// datatable column index  => database column name
	0 =>'no_reg', 
	1 => 'no_rm',
	2=> 'nama',
	3 => 'alamat',
	4=> 'umur',
	5 => 'jenis_kelamin',
	6=> 'poli',
	7=> 'dokter',
	8 => 'dokter_penanggung_jawab',
	9=> 'bed',
	10 => 'group_bed',
	11=> 'jam',
	12=> 'tanggal_periksa',
	13=> 'aksi',
	14=> 'selesai'


);

// getting total number records without any search
$sql = "SELECT rekam_medik_inap.jam,rekam_medik_inap.no_reg,rekam_medik_inap.no_rm,rekam_medik_inap.nama,
rekam_medik_inap.alamat,rekam_medik_inap.umur,rekam_medik_inap.jenis_kelamin,rekam_medik_inap.poli,rekam_medik_inap.dokter,
rekam_medik_inap.dokter_penanggung_jawab,rekam_medik_inap.bed,rekam_medik_inap.group_bed,rekam_medik_inap.tanggal_periksa,rekam_medik_inap.id";
$sql.="  FROM rekam_medik_inap INNER JOIN registrasi ON rekam_medik_inap.no_reg = registrasi.no_reg";
$sql.=" WHERE registrasi.status != 'Batal Rawat Inap' AND rekam_medik_inap.status IS NULL ";
$sql.=" ORDER BY rekam_medik_inap.id DESC ";

$query = mysqli_query($conn, $sql) or die("proses_table_rekam_medik_ranap.php: get employees 1");
$totalData = mysqli_num_rows($query);
$totalFiltered = $totalData;  // when there is no search parameter then total number rows = total number filtered rows.


$sql = "SELECT rekam_medik_inap.jam,rekam_medik_inap.no_reg,rekam_medik_inap.no_rm,rekam_medik_inap.nama,
rekam_medik_inap.alamat,rekam_medik_inap.umur,rekam_medik_inap.jenis_kelamin,rekam_medik_inap.poli,rekam_medik_inap.dokter,
rekam_medik_inap.dokter_penanggung_jawab,rekam_medik_inap.bed,rekam_medik_inap.group_bed,rekam_medik_inap.tanggal_periksa,rekam_medik_inap.id";
$sql.=" FROM rekam_medik_inap INNER JOIN registrasi ON rekam_medik_inap.no_reg = registrasi.no_reg";
$sql.=" WHERE 1=1 ";
$sql.=" AND registrasi.status != 'Batal Rawat Inap' ";
$sql.=" AND rekam_medik_inap.status IS NULL ";

if( !empty($requestData['search']['value']) ) {   // if there is a search parameter, $requestData['search']['value'] contains search parameter
	$sql.=" AND ( rekam_medik_inap.no_reg LIKE '".$requestData['search']['value']."%' ";    
	$sql.=" OR rekam_medik_inap.no_rm LIKE '".$requestData['search']['value']."%' ";
	$sql.=" OR rekam_medik_inap.nama LIKE '".$requestData['search']['value']."%' ";
	$sql.=" OR rekam_medik_inap.dokter LIKE '".$requestData['search']['value']."%' ";
	$sql.=" OR rekam_medik_inap.jam LIKE '".$requestData['search']['value']."%' ";
	$sql.=" OR rekam_medik_inap.tanggal_periksa LIKE '".$requestData['search']['value']."%' )";
}


$query=mysqli_query($conn, $sql) or die("proses_table_rekam_medik_ranap.php: get employees 2");
$totalFiltered = mysqli_num_rows($query); // when there is a search parameter then we have to modify total number filtered rows as per search result. 
$sql.=" ORDER BY rekam_medik_inap.id  DESC ";
/* $requestData['order'][0]['column'] contains colmun index, $requestData['order'][0]['dir'] contains order such as asc/desc  */		
$query=mysqli_query($conn, $sql) or die("proses_table_rekam_medik_ranap.php: get employees 3");

$data = array();
while( $row=mysqli_fetch_array($query) ) {  // preparing an array
	$nestedData=array(); 

	$nestedData[] = $row["no_reg"];
	$nestedData[] = $row["no_rm"];
	$nestedData[] = $row["nama"];
	$nestedData[] = $row["alamat"];
	$nestedData[] = $row["umur"];
	$nestedData[] = $row["jenis_kelamin"];	
	$nestedData[] = $row["poli"];
	$nestedData[] = $row["dokter"];
	$nestedData[] = $row["dokter_penanggung_jawab"];
	$nestedData[] = $row["bed"];
	$nestedData[] = $row["group_bed"];
	$nestedData[] = $row["jam"];	
	$nestedData[] = $row["tanggal_periksa"];

 if ($rekam_medik['rekam_medik_ri_lihat'] > 0) 

 	{//if ($rekam_medik['rekam_medik_rj_lihat'] > 0) 
	      $nestedData[] = "<a href='input_rekam_medik_ranap.php?no_reg=".$row['no_reg']."&tgl=".$row['tanggal_periksa']."&jam=".$row['jam']."&id=".$row['id']."' class='btn-floating btn-info btn-small'><i class='fa fa-medkit '></i></a>";
	            
        $table23 = $db->query("SELECT status FROM penjualan WHERE no_reg = '$row[no_reg]' ");
        $dataki = mysqli_fetch_array($table23);

		$ambil_dosis = $db->query("SELECT dp.dosis FROM detail_penjualan dp  LEFT JOIN barang b ON dp.kode_barang = b.kode_barang  WHERE dp.no_reg ='$row[no_reg]' AND b.tipe_barang = 'Obat Obatan'");		
		$data_dosis = mysqli_fetch_array($ambil_dosis);

        if ( ($dataki['status'] == 'Lunas' OR $dataki['status'] == 'Piutang'  OR  $dataki['status'] == 'Piutang Apotek') AND $data_dosis['dosis'] != "" )
        {
        	$nestedData[] = "<a href ='selesai_ri.php?no_reg=".$row['no_reg']."&id=".$row['id']."' class='btn-floating btn-info btn-small'><i class='fa fa-check'></i>  </a>";
        }
         else
        {
          $nestedData[] = "";
        }
        
	}//if ($rekam_medik['rekam_medik_rj_lihat'] > 0) 
	else{
       $nestedData[] = "";
       $nestedData[] = "";
      }


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
