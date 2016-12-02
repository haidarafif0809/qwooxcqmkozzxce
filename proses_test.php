<?php
include 'db.php';
    
    //get search term
    $searchTerm = $_GET['term'];
    
    //get matched data from skills table
    $query = $db->query("SELECT * FROM user WHERE nama LIKE '%".$searchTerm."%' ORDER BY nama ASC");
    while ($row = $query->fetch_assoc()) {
        $data[] = $row['nama'];
    }
    
    //return json data
    echo json_encode($data);
?>