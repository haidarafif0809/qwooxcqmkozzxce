<?php 
include 'db.php';
include 'sanitasi.php';

          
 ?>
  <div class="container">

<span id="table_baru">  
<div class="table-responsive">
  <table id="table-pelamar" class="table table-bordered table-sm">
 
    <thead>
      <tr>
          <th style='background-color: #4CAF50; color: white; width: 50%'>Nama Operasi </th>
          <th style='background-color: #4CAF50; color: white; width: 50%'>Nama Kelas Kamar </th>
          <th style='background-color: #4CAF50; color: white; width: 50%'>Nama Cito </th>
          <th style='background-color: #4CAF50; color: white; width: 50%'>Harga Jual </th>
          <th style='background-color: #4CAF50; color: white'>Detail Operasi</th>
          <th style='background-color: #4CAF50; color: white'>Edit</th>
          <th style='background-color: #4CAF50; color: white'>Hapus</th>

    </tr>
    </thead>
    <tbody id="tbody">
    
   <?php 
   $query = $db->query("SELECT * FROM sub_operasi ");
   while($data = mysqli_fetch_array($query))      
      {

      	$seelect_op = $db->query("SELECT id_operasi,nama_operasi FROM operasi");
        while($out_op = mysqli_fetch_array($seelect_op))
        {
          if($data['id_operasi'] == $out_op['id_operasi'])
          {
            $nama_operasi = $out_op['nama_operasi'];
          }
        }

      	$select_kelas = $db->query("SELECT id,nama FROM kelas_kamar");
        while($out_kelas = mysqli_fetch_array($select_kelas))
        {
          if($data['id_kelas_kamar'] == $out_kelas['id'])
          {
            $kelas = $out_kelas['nama'];
          }
        }

$select_cito = $db->query("SELECT id,nama FROM cito");
        while($out_cito = mysqli_fetch_array($select_cito))
        {
          if($data['id_cito'] == $out_cito['id'])
          {
            $cito = $out_cito['nama'];
          }
        }

      echo "<tr class='tr-id-".$data['id_operasi']."'>

            <td>". $nama_operasi ."</td>
            <td>". $kelas ."</td>
            <td>". $cito ."</td>
            <td>Rp. ". rp($data['harga_jual']) ."</td>

<td><a href='detail_operasi.php?id=".$data["id_sub_operasi"]."' class='btn btn-success'>Detail Operasi </a></td>


<td> <button class='btn btn-warning btn-edit' data-id-sub='". $data['id_sub_operasi'] ."' data-id-op='". $nama_operasi ."' data-id-kelas='". $data['id_kelas_kamar'] ."' data-id-cito='". $data['id_cito'] ."'><span class='glyphicon glyphicon-edit'> </span> Edit </button> </td>

     <td> <button class='btn btn-danger delete' data-id='". $data['id_sub_operasi'] ."'> <span class='glyphicon glyphicon-trash'> </span> Hapus </button> </td>

      </tr>";
      }
    ?>
  </tbody>
 </table>
 </div>
</span>
  </div><!--counteiner-->

<!-- Start Script Edit-->
<script type="text/javascript">
  $(".btn-edit").click(function(){
    
    $("#modal_edit").modal('show');

    var sub = $(this).attr("data-id-sub"); 
    var op  = $(this).attr("data-id-op");
    var kelas  = $(this).attr("data-id-kelas");
    var cito  = $(this).attr("data-id-cito");
    var harga  = $(this).attr("data-harga");

    $("#sub_edit").val(sub);
    $("#op_edit").val(op);
    $("#kelas_edit").val(kelas);
    $("#cito_edit").val(cito);
    $("#harga_jual_edit").val(harga);
    
    
    });
    
    $("#submit_edit").click(function(){

    var sub = $("#sub_edit").val();
    var kelas = $("#kelas_edit").val();
    var cito = $("#cito_edit").val();
    var harga = bersihPemisah(bersihPemisah(bersihPemisah(bersihPemisah($("#harga_jual_edit").val()))));
    
    $.post("update_sub_operasi.php",{sub:sub,kelas:kelas,cito:cito,harga:harga},function(data){

    if (data != '') 
    {

    $(".alert").show('fast');
    $("#table_baru").load('show_sub_operasi.php');
    setTimeout(tutupalert, 2000);
    $(".modal").modal("hide");

    }
    
    
    });
  
                  

    function tutupmodal() {
    
    } 
    });
</script>
<!--Ending Script Edit-->



<!--   script modal confirmasi delete -->
<script type="text/javascript">
$(".delete").click(function(){

  var id = $(this).attr('data-id');

  $("#modale-delete").modal('show');
  $("#id_delete").val(id);

});


</script>
<!--   end script modal confiormasi dellete -->


<!--  script modal  lanjkutan confiormasi delete -->
<script type="text/javascript">
$("#yesss").click(function(){

var id = $("#id_delete").val();

$.post('delete_sub_operasi.php',{id:id},function(data){
    
      $("#modale-delete").modal('hide');
      $(".tr-id-"+id+"").remove();
  
    });

});
</script>

<script>

$(document).ready(function(){
    $('.table').DataTable();
});

</script>

<!--  end modal confirmasi delete lanjutan  -->




<script>

$(document).ready(function(){
    $('.table').DataTable();
});

</script>

  <?php include 'footer.php'; ?>