<?php include 'session_login.php';
/* Database connection start */
include 'db.php';
include 'sanitasi.php';
/* Database connection end */

$tipe = "barang_jasa";
$kategori  = "semua";

// storing  request (ie, get/post) global array to a variable  
$requestData= $_REQUEST;
$total_akhir_hpp = 0;
$columns = array( 
// datatable column index  => database column name
	0 =>'kode_barang', 
	1 => 'nama_barang',
	2 => 'suplier',
	3 => 'limit_stok',
	4 => 'over_stok',
	5 => 'status',
	6 => 'id'
);



// getting total number records without any search
if ($tipe == 'barang') {
	if ($kategori == 'semua' AND $tipe = 'barang') {

		$sql = "SELECT * ";
		$sql.=" FROM barang WHERE berkaitan_dgn_stok = '$tipe' ";


	}

	else{
		$sql = "SELECT * ";
		$sql.=" FROM barang WHERE kategori = '$kategori' AND berkaitan_dgn_stok = '$tipe' ";
    }

}

else
{
	if ($kategori == 'semua') {
    	$sql = "SELECT * ";
		$sql.=" FROM barang";
    
    }
    
    else{
    	$sql = "SELECT * ";
		$sql.=" FROM barang WHERE kategori = '$kategori' ";
    }
}
$query=mysqli_query($conn, $sql) or die("datatable_cari_barang.php: get employees");
$totalData = mysqli_num_rows($query);
$totalFiltered = $totalData;  // when there is no search parameter then total number rows = total number filtered rows.


if ($tipe == 'barang') {
	if ($kategori == 'semua' AND $tipe = 'barang') {

		$sql = "SELECT * ";
		$sql.=" FROM barang WHERE 1=1 AND berkaitan_dgn_stok = '$tipe' ";


	}

	else{
		$sql = "SELECT * ";
		$sql.=" FROM barang WHERE 1=1 AND kategori = '$kategori' AND berkaitan_dgn_stok = '$tipe' ";
    }

}

else
{
	if ($kategori == 'semua') {
    	$sql = "SELECT * ";
		$sql.=" FROM barang";
    
    }
    
    else{
    	$sql = "SELECT * ";
		$sql.=" FROM barang WHERE 1=1 AND kategori = '$kategori' ";
    }
}

if( !empty($requestData['search']['value']) ) {   // if there is a search parameter, $requestData['search']['value'] contains search parameter
	$sql.=" AND ( kode_barang LIKE '".$requestData['search']['value']."%' ";    
	$sql.=" OR nama_barang LIKE '".$requestData['search']['value']."%' )";

}
$query=mysqli_query($conn, $sql) or die("datatable_cari_barang.php: get employees");
$totalFiltered = mysqli_num_rows($query); // when there is a search parameter then we have to modify total number filtered rows as per search result. 
$sql.=" ORDER BY ". $columns[$requestData['order'][0]['column']]."   ".$requestData['order'][0]['dir']."  LIMIT ".$requestData['start']." ,".$requestData['length']."   ";
/* $requestData['order'][0]['column'] contains colmun index, $requestData['order'][0]['dir'] contains order such as asc/desc  */	
$query=mysqli_query($conn, $sql) or die("employee-grid-data.php: get employees");

$data = array();
while( $row=mysqli_fetch_array($query) ) {  // preparing an array
	$nestedData=array(); 

		$select_gudang = $db->query("SELECT nama_gudang FROM gudang WHERE kode_gudang = '$row[gudang]'");
        $ambil_gudang = mysqli_fetch_array($select_gudang);

        $select = $db->query("SELECT SUM(sisa) AS jumlah_barang FROM hpp_masuk WHERE kode_barang = '$row[kode_barang]'");
        $ambil_sisa = mysqli_fetch_array($select);
    
       // menampilkan file yang ada di masing-masing data dibawah ini

       $nestedData[] = $row['kode_barang'];
       $nestedData[] = $row['nama_barang'];
       //harusnya klik 2x untuk edit
       $nestedData[] = $row['berkaitan_dgn_stok'];
       //ini juga
        $nestedData[] = $row['suplier'];

       if ($row['foto'] == "" ){
                $nestedData[] = "<a href='unggah_foto.php?id=". $row['id']."' class='btn btn-primary'><span class='glyphicon glyphicon-upload'></span> Unggah Foto</a>";
            }
            else{
                $nestedData[] = "<img src='save_picture/". $row['foto'] ."' height='30px' width='60px' > <br><br> <a href='unggah_foto.php?id=". $row['id']."' class='btn btn-primary btn-sm'><span class='glyphicon glyphicon-upload'></span> Edit Foto</a>";
            }

		$nestedData[] = $row['limit_stok'];
       
		$nestedData[] = $row['over_stok'];
		$nestedData[] = $row['status'];

		$pilih_akses_barang_hapus = $db->query("SELECT item_hapus FROM otoritas_master_data WHERE id_otoritas = '$_SESSION[otoritas_id]' AND item_hapus = '1'");
		$barang_hapus = mysqli_num_rows($pilih_akses_barang_hapus);


		    if ($barang_hapus > 0 AND ($ambil_sisa['jumlah_barang'] == '0' OR $ambil_sisa['jumlah_barang'] == ''))        

		            {
		         
		            $nestedData[] = "<button class='btn btn-danger btn-hapus' data-id='". $row['id'] ."'  data-nama='". $row['nama_barang'] ."'> <span class='glyphicon glyphicon-trash'> </span> Hapus </button> </td>";
		        }
		        else
		        {
		            $nestedData[] = "can not be deleted";
		        }

        $pilih_akses_barang_edit = $db->query("SELECT item_edit FROM otoritas_master_data WHERE id_otoritas = '$_SESSION[otoritas_id]' AND item_edit = '1'");
		$barang_edit = mysqli_num_rows($pilih_akses_barang_edit);


		    if ($barang_edit > 0) {

		           if ($ambil_sisa['jumlah_barang'] == '0') 

		             {
		               $nestedData[] = "<a href='editbarang.php?id=". $row['id']."' class='btn btn-success'><span class='glyphicon glyphicon-edit'></span> Edit</a>";
		            
		            }

		    }

		$pilih_akses_barang_edit = $db->query("SELECT item_edit FROM otoritas_master_data WHERE id_otoritas = '$_SESSION[otoritas_id]' AND item_edit = '1'");
		$barang_edit = mysqli_num_rows($pilih_akses_barang_edit);


		    if ($barang_edit > 0 AND $ambil_sisa['jumlah_barang'] != '0')
		            {

		            $nestedData[] = "<a href='editbarang.php?id=". $row['id']."' class='btn btn-success'><span class='glyphicon glyphicon-edit'></span> Edit</a>";
		            }
		$nestedData[] = $row['id'];
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

