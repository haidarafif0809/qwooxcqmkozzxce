<?php
  
    include 'db.php';

    
    //get search term
    $searchTerm = $_GET['term'];
    
    //get matched data from skills table
    $query = $db_pasien->query("SELECT kode_pelanggan, nama_pelanggan FROM pelanggan WHERE nama_pelanggan LIKE '%".$searchTerm."%' OR kode_pelanggan LIKE '%".$searchTerm."%' ORDER BY nama_pelanggan ASC");
    while ($row = $query->fetch_assoc()) {
        $data[] = $row['kode_pelanggan']."(".$row['nama_pelanggan'].")";
    }
    
    //return json data
    echo json_encode($data);
?>