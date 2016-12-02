<?php include 'session_login.php';
include 'header.php';
include 'navbar.php';
include 'db.php';
include 'sanitasi.php';

       
          
 ?>
 <div class="container">
  

<div class="table-responsive">
  <table id="table-pelamar" class="table table-bordered table-sm">
 
    <thead>
      <tr>
          <th style='background-color: #4CAF50; color: white; width: 50%'>Nama Detail Operasi </th>
          <th style='background-color: #4CAF50; color: white; width: 50%'>Jabatan </th>
          <th style='background-color: #4CAF50; color: white; width: 50%'>Jumlah Persentase </th>
          <th style='background-color: #4CAF50; color: white'>Edit</th>
          <th style='background-color: #4CAF50; color: white'>Hapus</th>

    </tr>
    </thead>
    <tbody id="tbody">
    
  <?php 
   $query = $db->query("SELECT * FROM detail_operasi WHERE id_sub_operasi = '$id_sub_operasi'");
   while($data = mysqli_fetch_array($query))      
      {

         $seelect_op = $db->query("SELECT id,nama FROM jabatan");
        while($out_op = mysqli_fetch_array($seelect_op))
        {
          if($data['id_jabatan'] == $out_op['id'])
          {
            $jabatan = $out_op['nama'];
          }
          else
          {

          }
        }
        
      echo "<tr class='tr-id-".$data['id_detail_operasi']."'>

            <td>". $data['nama_detail_operasi'] ."</td>
            <td>". $jabatan ."</td>
            <td>". $data['jumlah_persentase'] ." %</td>";

if ($detail_sub_operasi['detail_sub_operasi_edit'] > 0) {
  echo "<td> <button class='btn btn-warning btn-edit' data-id='". $data['id_detail_operasi'] ."'
  data-nama='". $data['nama_detail_operasi'] ."' data-jabatan='". $data['id_jabatan'] ."' 
  data-persentase='". $data['jumlah_persentase'] ."'>
  <span class='glyphicon glyphicon-edit'> </span> Edit </button> </td>";
}
else{
  echo "<td> </td>";
}

if ($detail_sub_operasi['detail_sub_operasi_hapus'] > 0) {
  echo "<td> <button class='btn btn-danger delete' data-id='". $data['id_detail_operasi'] ."'
     data-nama='". $data['nama_detail_operasi'] ."'> <span class='glyphicon glyphicon-trash'> </span> Hapus </button> </td>";
}
     
echo "</tr>";
      }
    ?>
  </tbody>
 </table>
 </div>


 </div><!--div closed countainer-->



<script>

$(document).ready(function(){
    $('.table').DataTable();
});

</script>


<script type="text/javascript">
$(document).ready(function(){
 $("#persentase").keyup(function(){

   var persentase = $("#persentase").val();
   if (persentase > 100)
   {
    alert("Persentase tidak boleh lebih dari 100%");
    $("#persentase").val('');
    $("#persentase").focus();
   }
             


});
});
        
</script>



<script type="text/javascript">
$(document).ready(function(){
 $("#persentase_edit").keyup(function(){

   var persentase = $("#persentase_edit").val();
   if (persentase > 100)
   {
    alert("Persentase tidak boleh lebih dari 100%");
    $("#persentase_edit").val('');
    $("#persentase_edit").focus();
   }
             


});
});
        
</script>

<!--   script modal confirmasi delete -->
<script type="text/javascript">
$(".delete").click(function(){

  var id = $(this).attr('data-id');
  var nama = $(this).attr('data-nama');

  $("#modale-delete").modal('show');
  $("#id_delete").val(id);
  $("#nama_delete").val(nama);

});


</script>
<!--   end script modal confiormasi dellete -->


<!--  script modal  lanjkutan confiormasi delete -->
<script type="text/javascript">
$("#yesss").click(function(){

var id = $("#id_delete").val();

$.post('delete_detail_operasi.php',{id:id},function(data){
    
      $("#modale-delete").modal('hide');
      $(".tr-id-"+id+"").remove();
  
    });

});
</script>

<!-- Start Script Edit-->
<script type="text/javascript">
  $(".btn-edit").click(function(){
    
    $("#modal_edit").modal('show');

    var id = $(this).attr("data-id"); 
    var nama  = $(this).attr("data-nama");
    var jabatan  = $(this).attr("data-jabatan");
    var persentase  = $(this).attr("data-persentase");

    $("#id_edit").val(id);
    $("#nama_edit").val(nama);
    $("#jabatan_edit").val(jabatan);
    $("#persentase_edit").val(persentase);
    
    
    });
    
    $("#submit_edit").click(function(){

    var id = $("#id_edit").val();
    var nama = $("#nama_edit").val();
    var jabatan = $("#jabatan_edit").val();
    var persentase = $("#persentase_edit").val();
    if (nama == '')
    {
      alert("Nama Detail Operasi Harus Di isi");
      $("#nama_edit").val('');
      $("#nama_edit").focus();
    }
    else if(persentase == '')
    {
      alert("persentase Harus Di isi");
      $("#persentase").val('');
      $("#persentase").focus();
    }
    else if(jabatan == '' || jabatan == '0')
    {
      alert("jabatan Harus Di Pilih Terlebih Dahulu");
      $("#jabatan_edit").focus();
    }
    else
    {
    $.post("update_detail_operasi.php",{id:id,nama:nama,jabatan:jabatan,persentase:persentase},function(data){

    if (data != '') 
    {

    $("#modal_edit").modal("hide");
    $("#table_baru").load('show_detail_operasi.php');
    $(".alert").show('fast');
    setTimeout(tutupalert, 2000);
    }
    
    
    });
    }           

    function tutupmodal() {
    
    } 
    });
</script>
<!--Ending Script Edit-->

 <?php include 'footer.php'; ?>