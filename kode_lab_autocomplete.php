<?php
  
    include 'db.php';

    
    //get search term
    $searchTerm = $_GET['term'];
    
    //get matched data from skills table
    $query = $db->query("SELECT kode_lab, nama FROM jasa_lab WHERE nama LIKE '%".$searchTerm."%' OR kode_lab LIKE '%".$searchTerm."%' ORDER BY nama ASC");
    while ($row = $query->fetch_assoc()) {
        $data[] = $row['kode_lab']."(".$row['nama'].")";
    }
    
    //return json data
    echo json_encode($data);
?>