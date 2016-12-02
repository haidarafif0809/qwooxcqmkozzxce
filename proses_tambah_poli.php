<?php 
include 'db.php';
include_once 'sanitasi.php';
session_start();

$nama = stringdoang($_POST['nama']);


$query = $db->prepare("INSERT INTO poli (nama) VALUES (?) ");

$query->bind_param("s",$nama);

$query->execute();

    if (!$query) 
    {
    die('Query Error : '.$db->errno.
    ' - '.$db->error);
    }
	    else{

	 }



$query = $db->query("SELECT * FROM poli ORDER BY id DESC LIMIT 1 ");
   $data = mysqli_fetch_array($query);     
      
           echo "<tr class='tr-id-".$data['id']."'>";
  $pilih_akses_poli_edit = $db->query("SELECT poli_edit FROM otoritas_master_data WHERE id_otoritas = '$_SESSION[otoritas_id]' AND poli_edit = '1'");
$poli_edit = mysqli_num_rows($pilih_akses_poli_edit);
  if ($poli_edit > 0) {
      
      echo "<td class='edit-nama' data-id='".$data['id']."'><span id='text-nama-".$data['id']."'>". $data['nama'] ."</span> <input type='hidden' id='input-nama-".$data['id']."' value='".$data['nama']."' class='input_nama' data-id='".$data['id']."' autofocus=''> </td>";
}
else{

  echo "<td>". $data['nama'] ." </td>";

}

$pilih_akses_poli_hapus = $db->query("SELECT poli_hapus FROM otoritas_master_data WHERE id_otoritas = '$_SESSION[otoritas_id]' AND poli_hapus = '1'");
$poli_hapus = mysqli_num_rows($pilih_akses_poli_hapus);
  if ($poli_hapus > 0) {

    echo "<td><button data-id='".$data['id']."' class='btn btn-danger delete'><span class='glyphicon glyphicon-trash'></span> Hapus </button></td>";
    
  }
  else{

    echo "<td> </td>";

  }
      echo "
      </tr>";
    ?>

<script type="text/javascript">
$(".delete").click(function(){

  var id = $(this).attr('data-id');
  
  $("#modale-delete").modal('show');
  $("#id2").val(id);  

});


</script>
                            
     