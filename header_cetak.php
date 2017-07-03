<!doctype html>
<html>
<head>

	<title>
	<?php 
	include_once 'db.php';
	include_once 'cache.class.php';

    $c = new Cache();

    $c->setCache('data_perusahaan');
    if (!$c->isCached('data')) {
	$query1 = $db->query("SELECT * FROM perusahaan ");
	$data1 = mysqli_fetch_array($query1);

	
    $c->store('data',array('nama_perusahaan' => $data1['nama_perusahaan'],'alamat_perusahaan' => $data1['alamat_perusahaan'],'singkatan_perusahaan' => $data1['singkatan_perusahaan'],'foto' => $data1['foto'],'no_telp' => $data1['no_telp']));
    	
    }	

    $cache_printer = new Cache();


	$cache_printer->setCache('setting_printer');

	if (!$cache_printer->isCached('data')) {

		$query_printer = $db->query("SELECT nama_print,status_print FROM setting_printer ");
		$data_printer = mysqli_fetch_array($query_printer);


		  $cache_printer->store('data',array('nama_print' => $data_printer['nama_print'],'status_print' => $data_printer['status_print']));

		
	}
  
         
 	$data_setting_printer = $cache_printer->retrieve('data');

	$data_perusahaan = $c->retrieve('data');
	echo $data_perusahaan['nama_perusahaan'];


	 ?>
	</title>



		<meta charset="utf-8">
		<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
		<meta http-equiv="x-ua-compatible" content="ie=edge">
		<!-- Bootstrap core CSS -->
		<link href="css/bootstrap4.min.css" rel="stylesheet">
		<!-- Font Awesome -->
		<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.6.0/css/font-awesome.min.css">
	


	
               
</head>




