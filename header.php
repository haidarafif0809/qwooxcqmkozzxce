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

	<style>
	body {
		background: #f1f1f1;
		color: #999;
		font-family:arial;
		font-size:12px
	}
		#preview {
		height: auto;
		min-height:100px;
		margin: 10px;
		padding:10px;
		background: #fff;
	}
		#preview img, #imageform{
		width:100px;
		height: 100px;
		display: inline-block
	}
		#notip {
		font-family: "Source Code Pro",Menlo,Consolas,Monaco,monospace;
		color: #00E000;
		background:#000;
		margin:10px;
		padding: 15px
	}
	.loader {
    border: 16px solid #f3f3f3; /* Light grey */
    border-top: 16px solid #3498db; /* Blue */
    border-radius: 50%;
    width: 90px;
    height: 90px;
    animation: spin 2s linear infinite;
}

@keyframes spin {
    0% { transform: rotate(0deg); }
    100% { transform: rotate(360deg); }
}
</style>

		<meta charset="utf-8">
		<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
		<meta http-equiv="x-ua-compatible" content="ie=edge">
		<!-- Bootstrap core CSS -->
		<link href="css/bootstrap4.min.css" rel="stylesheet">
		<!-- Font Awesome -->
		<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.6.0/css/font-awesome.min.css">
		<!-- Material Design Bootstrap -->
		<link href="css/mdb.min.css" rel="stylesheet">

		
		<link rel="stylesheet" href="datatables/dataTables.bootstrap.css">

		<link rel="icon" href="save_picture/Andaglos-UKM.jpg" type="image/x-icon">


		<link rel="stylesheet" href="jquery-ui/jquery-ui.css">
		<link rel="stylesheet" href="chosen/chosen.css">
		<link rel="stylesheet" href="pos.css">
		
		<link rel="stylesheet" type="text/css" href="//fonts.googleapis.com/css?family=Quicksand" />


    	<script type="text/javascript" src="js/jquery-2.2.3.min.js"></script>		<script src="my.js"></script>
		<script src="https://cdn.datatables.net/1.10.12/js/jquery.dataTables.min.js"></script>
		<script src="https://cdn.datatables.net/1.10.12/js/dataTables.bootstrap4.min.js"></script>
		<script type="text/javascript" src="jquery.ui.timepicker.js?v=0.3.3"></script>
		
		

		<script src="chosen/chosen.jquery.js"></script>

		<script src="jquery-ui/jquery-ui.js"></script>

         <script src="bootstrap-master/dist/bootstrap-wysihtml5-0.0.2.js"></script>
       <script src="bootstrap-master/lib/js/wysihtml5-0.3.0.js"></script>
       <script src="bootstrap-master/src/bootstrap3-wysihtml5.js"></script>
       
             <link rel="stylesheet" href="bootstrap-master/src/bootstrap-wysihtml5.css" >
             <link rel="stylesheet" href="bootstrap-master/lib/css/bootstrap3-wysiwyg5.css" >
          <link rel="stylesheet" href="bootstrap-master/dist/bootstrap-wysihtml5-0.0.2.css" >


		<link rel="stylesheet" href="css/selectize.bootstrap3.css">

		<link rel="stylesheet" href="css/selectize.css">

		<script src="js/selectize.js"></script>
		
		

		<script src="ckeditor/ckeditor.js"></script>
		<script src='jquery.elevatezoom.js'></script>
		<!-- untuk operasi indexeddb -->
		 <script src="https://unpkg.com/dexie@latest/dist/dexie.js"></script>

		   <script src="js/printThis.js" type="text/javascript"></script>

               
</head>
<body class="hidden-sn blue-skin" >



