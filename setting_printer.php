 <?php include 'session_login.php';
include 'header.php'; 
include 'navbar.php';
include 'db.php';
include 'sanitasi.php';


$query7 = $db->query("SELECT nama_print,status_print FROM setting_printer WHERE nama_print = 'Printer Struk' OR nama_print = 'Printer Besar' ");


  ?>

<div class="container">
	<h1>Setting Printer</h1>
  <button data-toggle="collapse" data-target="#demo" class="btn btn-success"><i class="fa fa-screenshot"></i>Edit Printer</button>
  <br>
  <br>


  <div id="demo" class="collapse">
 <form role="form" action="update_printer.php" method="POST">

<div class="form-group">
  <label for="sel1">Printer</label>
  <select  class="form-control" list="dok" id="printer" name="printer"  required="" autocomplete="off">
        <option value="Printer Struk">Printer Struk</option>
    <option value="Printer Besar">Printer Besar</option>

</select>
</div>


<div class="form-group">
  <label for="sel1">Jenis / Tipe</label>
  <select class="form-control"   list="par" id="status" name="status"  required="" autocomplete="off">
    <option value="Detail">Detail</option>
      <option value="Rekap">Rekap</option>
</select>
</div>


<button type="submit" class="btn btn-info"><i class="fa fa-wrench"></i> Edit</button>
</form>
	</div>

 <style>

tr:nth-child(even){background-color: #f2f2f2}

</style> 
  
<div class="table-responsive">
<table id="table_rawat_jalan" class="table table-bordered table-sm">
    <thead>
      <tr>
          <th style='background-color: #4CAF50; color: white'>Printer</th>
          <th style='background-color: #4CAF50; color: white'>Status Print</th> 
    </tr>
    </thead>
    <tbody>
    
   <?php
    while($data = mysqli_fetch_array($query7))
      
      {
      echo "<tr  class=''  >
          <td>". $data['nama_print']."</td>
          <td>". $data['status_print']."</td>

</tr> ";
?>

<?php
}
?>

  </tbody>
 </table>
</div><!--div responsive-->
</div>



<!--datatable-->
<script type="text/javascript">
  $(function(){
  $("table").dataTable({"ordering": false});
  }); 
</script>
<!--end datatable-->


<?php 
include 'footer.php';

 ?>
