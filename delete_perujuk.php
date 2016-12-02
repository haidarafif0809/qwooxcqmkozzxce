<?php
include 'db.php';
include 'sanitasi.php';

$id = angkadoang($_POST['id']);
$query = $db->query("DELETE FROM perujuk WHERE id='$id'");
?>

<?php
$query = $db->query("SELECT * FROM perujuk ORDER BY id DESC ");

 $data = mysqli_fetch_array($query);

      echo "<tr class='tr-id-".$data['id']."'>
      <td >". $data['nama']."</td>
      <td>". $data['alamat']."</td>
      <td>". $data['no_telp']."</td>
      <td><a href='edit_perujuk.php?id=".$data['id']."'class='btn btn-warning'><span class='glyphicon glyphicon-wrench'></span> Edit </a>
      </td>
      <td><button data-id='".$data['id']."' class='btn btn-danger delete'><span class='glyphicon glyphicon-trash'></span> Hapus </button>
      </td>
      </tr>";
      
    ?>



<!--   script modal confirmasi delete -->
<script type="text/javascript">
$(".delete").click(function(){

  var id = $(this).attr('data-id');

$("#modale-delete").modal('show');
$("#id2").val(id);  

});
</script>
<!--   end script modal confiormasi dellete -->