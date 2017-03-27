<?php include 'session_login.php';
/* Database connection start */
include 'db.php';
include 'sanitasi.php';

/* Database connection end */
$jam =  date("H:i:s");
$tanggal_sekarang = date("Y-m-d");
$waktu = date("Y-m-d H:i:s");
$bulan_php = date('m');
$tahun_php = date('Y');


$pilih_akses_registrasi_ri = $db->query("SELECT registrasi_ri_lihat, registrasi_ri_tambah, registrasi_ri_edit, registrasi_ri_hapus FROM otoritas_registrasi WHERE id_otoritas = '$_SESSION[otoritas_id]'");
$registrasi_ri = mysqli_fetch_array($pilih_akses_registrasi_ri);

$pilih_akses_penjualan = $db->query("SELECT penjualan_tambah FROM otoritas_penjualan WHERE id_otoritas = '$_SESSION[otoritas_id]'");
$penjualan = mysqli_fetch_array($pilih_akses_penjualan);

$pilih_akses_rekam_medik = $db->query("SELECT rekam_medik_ri_lihat FROM otoritas_rekam_medik WHERE id_otoritas = '$_SESSION[otoritas_id]'");
$rekam_medik = mysqli_fetch_array($pilih_akses_rekam_medik);

// storing  request (ie, get/post) global array to a variable  
$requestData= $_REQUEST;

$columns = array( 
// datatable column index  => database column name

	 
	0 =>'batal', 
	1 => 'transaksi_penjualan',
	2=> 'pindah_kamar',
	3 => 'operasi',
	4=> 'rujuk_lab',
	5=> 'rekam_medik',
	6 => 'no_rm',
	7=> 'no_reg',
	8=> 'status',
	9 => 'nama',
	10=> 'jam',
	11 => 'asal_poli',
	12=> 'dokter_pengirim',
	13=> 'dokter_pelaksana',
	14=> 'bed',
	15=> 'kamar',
	16=> 'tanggal_masuk',
	17=> 'penanggung_jawab',
	18=> 'umur',
	19 =>'id'				 		 										

);

// getting total number records without any search
$sql = "SELECT reg.no_rm, reg.no_reg, reg.status, reg.nama_pasien, reg.jam, reg.penjamin, reg.poli, reg.dokter_pengirim, reg.dokter, reg.bed, reg.group_bed, reg.tanggal_masuk, reg.penanggung_jawab, reg.umur_pasien, reg.id, rek.tanggal_periksa,rek.id AS id_rek ";
$sql.=" FROM registrasi reg LEFT JOIN rekam_medik_inap rek ON reg.no_reg = rek.no_reg WHERE reg.jenis_pasien = 'Rawat Inap' AND reg.status = 'menginap' AND reg.status != 'Batal Rawat Inap' AND TO_DAYS(NOW()) - TO_DAYS(reg.tanggal) <= 7 ";



$query = mysqli_query($conn, $sql) or die("query 1: get employees");
$totalData = mysqli_num_rows($query);
$totalFiltered = $totalData;  // when there is no search parameter then total number rows = total number filtered rows.


$sql = "SELECT reg.no_rm, reg.no_reg, reg.status, reg.nama_pasien, reg.jam, reg.penjamin, reg.poli, reg.dokter_pengirim, reg.dokter, reg.bed, reg.group_bed, reg.tanggal_masuk, reg.penanggung_jawab, reg.umur_pasien, reg.id, rek.tanggal_periksa,rek.id AS id_rek ";
$sql.=" FROM registrasi reg LEFT JOIN rekam_medik_inap rek ON reg.no_reg = rek.no_reg WHERE reg.jenis_pasien = 'Rawat Inap' AND reg.status = 'menginap' AND reg.status != 'Batal Rawat Inap' ";
if( !empty($requestData['search']['value']) ) {   // if there is a search parameter, $requestData['search']['value'] contains search parameter
	$sql.=" AND ( reg.no_reg LIKE '".$requestData['search']['value']."%' ";    
	$sql.=" OR reg.no_rm LIKE '".$requestData['search']['value']."%' ";
	$sql.=" OR reg.status LIKE '".$requestData['search']['value']."%' ";
	$sql.=" OR reg.nama_pasien LIKE '".$requestData['search']['value']."%' ";
	$sql.=" OR reg.penjamin LIKE '".$requestData['search']['value']."%' ";
	$sql.=" OR reg.poli LIKE '".$requestData['search']['value']."%' ";
	$sql.=" OR reg.dokter LIKE '".$requestData['search']['value']."%' ";
	$sql.=" OR reg.dokter_pengirim LIKE '".$requestData['search']['value']."%' ";
	$sql.=" OR reg.group_bed LIKE '".$requestData['search']['value']."%' )";
}


$query= mysqli_query($conn, $sql) or die("query 2: get employees");
$totalFiltered = mysqli_num_rows($query); // when there is a search parameter then we have to modify total number filtered rows as per search result. 

$sql.=" ORDER BY id   ".$requestData['order'][0]['dir']."  LIMIT ".$requestData['start']." ,".$requestData['length']."   ";
/* $requestData['order'][0]['column'] contains colmun index, $requestData['order'][0]['dir'] contains order such as asc/desc  */	
$query=mysqli_query($conn, $sql) or die("query 3: get employees");



$data = array();
while( $row=mysqli_fetch_array($query) ) {  // preparing an array
	$nestedData=array(); 

$penjual = $db->query("SELECT status FROM penjualan WHERE no_reg = '$row[no_reg]' ");
$sttus = mysqli_num_rows($penjual);


  if ($registrasi_ri['registrasi_ri_hapus'])
  	{

		if ($sttus == 0) {
         $nestedData[] = "<button  class='btn btn-floating btn-small btn-info batal_ranap' data-reg='". $row['no_reg']. "' data-id='". $row['id']. "'><i class='fa fa-remove'></i> </button>";
		}
		else {
			$nestedData[] = "";
		}
	}	


if ($registrasi_ri['registrasi_ri_edit'])
  	{

		if ($sttus == 0) {
         $nestedData[] = "<a href='edit_registrasi_rawat_inap.php?no_reg=". $row['no_reg']."' class='btn btn-floating btn-small btn-info' ><i class='fa fa-edit'></i> </a>";
		}
		else {
			$nestedData[] = "";
		}
	}	



$query_z = $db->query("SELECT status,no_faktur,nama,kode_gudang FROM penjualan WHERE no_reg = '$row[no_reg]' ");
$data_z = mysqli_fetch_array($query_z);

        if ($penjualan['penjualan_tambah'] > 0) {                
             
                 
                 if ($data_z['status'] == 'Simpan Sementara') {
                 
                 		$nestedData[] =  "<a href='proses_pesanan_barang_ranap.php?no_faktur=".$data_z['no_faktur']."&no_reg=".$row['no_reg']."&kode_pelanggan=".$row['no_rm']."&nama_pelanggan=".$data_z['nama']."&kode_gudang=".$data_z['kode_gudang']."' class='btn btn-floating btn-small btn btn-danger'><i class='fa fa-credit-card'></i></a>"; 
                 }
                 
                 else {
                		$nestedData[] =  ""; 
                 }

        }
        else{

          if ($data_z['status'] == 'Simpan Sementara') {
                 
                 		$nestedData[] =  ""; 
                 }
                 
                 else {
                 		$nestedData[] =  "";
                 }
        }

        if ($registrasi_ri['registrasi_ri_lihat']) {

 $query_z = $db->query("SELECT status,no_faktur,nama,kode_gudang FROM penjualan WHERE no_reg = '$row[no_reg]' ");
       $data_z = mysqli_fetch_array($query_z);

          $nestedData[] = "<button type='button' data-reg='".$row['no_reg']."' data-bed='".$row['bed']."' data-group-bed='".$row['group_bed']."' data-id='".$row['id']."' data-reg='".$row['no_reg']."'  class='btn btn-floating btn-small btn-info pindah'><i class='fa fa-reply'></i></button>";

           $nestedData[] = "<a href='registrasi_operasi.php?no_reg=".$row['no_reg']."&no_rm=".$row['no_rm']."&bed=".$row['bed']."&kamar=".$row['group_bed']."' class='btn btn-floating btn-small btn-danger'><i class='fa fa-plus-circle'></i></a>";


if ($data_z['status'] == 'Simpan Sementara') {

          $nestedData[] = "<a href='form_simpan_rj_penjualan_lab.php?no_rm=".$row['no_rm']."&nama=".$row['nama_pasien']."&no_reg=".$row['no_reg']."&dokter=".$row['dokter']."&jenis_penjualan=Simpan Rawat Inap' class='btn btn-floating btn-small btn-info'><i class='fa fa-stethoscope'></i></a>
		   ";
}

else {

	 $nestedData[] = "<button  class='btn btn-floating btn-small btn-info pemeriksaan_lab_inap' data-kamar=".$row['group_bed']." data-bed=".$row['bed']." data-rm=".$row['no_rm']." data-nama=".$row['nama_pasien']." data-reg=".$row['no_reg']." data-id=".$row['id']." '><i class='fa fa-stethoscope'></i></button>
		   ";
		
}


// untuk input hasil lab
/*$show = $db->query("SELECT * FROM tbs_penjualan WHERE no_reg = '$row[no_reg]' AND lab = 'Laboratorium' ");
$take = mysqli_num_rows($show);
	if ($take > 0)
	{
		$nestedData[] = "<a href='cek_input_hasil_lab_inap.php?no_rm=".$row['no_rm']."&nama=".$row['nama_pasien']."&no_reg=".$row['no_reg']."&jenis_penjualan=Rawat Inap' class='btn btn-floating btn-small btn-info'><i class='fa fa-pencil'></i></a>";
	}
	else
	{
	  $nestedData[] = "<p style='color:red'>Input Laboratorium</p>";

	}*/
// end untuk input hasil lab


        }
        

        if ($rekam_medik['rekam_medik_ri_lihat']) 
        {
           $nestedData[] =  "<a href='input_rekam_medik_ranap.php?no_reg=".$row['no_reg']."&tgl=".$row['tanggal_periksa']."&jam=".$row['jam']."&id=".$row['id_rek']."' class='btn-floating btn-info btn-small'><i class='fa fa-medkit '></i></a>";
        }


	$nestedData[] = $row["no_rm"];
	$nestedData[] = $row["no_reg"];
	$nestedData[] = $row["status"];
	$nestedData[] = "<span id='name-tag-".$row['id']."'>".$row["nama_pasien"]."</span>";
	$nestedData[] = $row["jam"];
	$nestedData[] = $row["penjamin"];	
	$nestedData[] = $row["poli"];
	$nestedData[] = $row["dokter_pengirim"];
	$nestedData[] = $row["dokter"];
	$nestedData[] = $row["bed"];
	$nestedData[] = $row["group_bed"];
	$nestedData[] = tanggal($row["tanggal_masuk"]);	
	$nestedData[] = $row["penanggung_jawab"]; 
	$nestedData[] = $row["umur_pasien"];
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


