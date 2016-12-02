<?php 
session_start();
//memasukkan file session login, header, navbar, db.php
include 'header.php';
include 'navbar.php';
include 'sanitasi.php';
include 'db.php';


$dari_tanggal = stringdoang($_POST['dari_tanggal']);
$sampai_tanggal = stringdoang($_POST['sampai_tanggal']);



$detail = $db->query("SELECT dim.id,dim.no_faktur,dim.kode_barang,dim.tanggal,dim.nama_barang,dim.jumlah,dim.harga,dim.subtotal,s.nama FROM detail_item_masuk dim INNER JOIN  satuan s ON dim.satuan = s.id WHERE  dim.tanggal >= '$dari_tanggal' AND dim.tanggal <= '$sampai_tanggal'");

$pilih_akses_item_masuk = $db->query("SELECT * FROM otoritas_item_masuk WHERE id_otoritas = '$_SESSION[otoritas_id]'");
$item_masuk = mysqli_fetch_array($pilih_akses_item_masuk);


 ?>
<div class="container">
<h3><b><center> Data Detail Item Masuk Dari <?php echo $dari_tanggal; ?> s/d <?php echo $sampai_tanggal; ?></center></b></h3><hr>
	<?php 
	if ($item_masuk['item_masuk_tambah'] > 0) {

echo '<a href="form_item_masuk.php" id="tambah_item" class="btn btn-info"> <i class="fa fa-plus"> </i> ITEM MASUK</a>';

}
 ?>
<br>
<button type="submit" name="submit" id="filter_1" class="btn btn-primary" > Filter Faktur </button>
<button type="submit" name="submit" id="filter_2" class="btn btn-primary" > Filter Detail </button>
<br>

<!--START FILTER FAKTUR-->
<span id="fil_faktur">
<form class="form-inline" action="show_filter_item_masuk.php" method="post" role="form">
          
          <div class="form-group"> 
          
          <input type="text" name="dari_tanggal" id="dari_tanggal" class="form-control" placeholder="Dari Tanggal" required="">
          </div>
          
          <div class="form-group"> 
          
          <input type="text" name="sampai_tanggal" id="sampai_tanggal" class="form-control" placeholder="Sampai Tanggal" value="<?php echo date("Y-m-d"); ?>" required="">
          </div>
          
          <button type="submit" name="submit" id="submit_filter_1" class="btn btn-success" ><i class="fa fa-eye"> </i> Lihat Faktur </button>

          
</form>
<span id="result"></span>  
</span>
<!--END FILTER FAKTUR-->

<!--START FILTER DETAIl-->
<span id="fil_detail">
<form class="form-inline" action="show_filter_item_masuk_detail.php" method="post" role="form">
          
          <div class="form-group"> 
          
          <input type="text" name="dari_tanggal" id="dari_tanggal2" class="form-control" placeholder="Dari Tanggal" required="">
          </div>
          
          <div class="form-group"> 
          
          <input type="text" name="sampai_tanggal" id="sampai_tanggal2" class="form-control" placeholder="Sampai Tanggal" value="<?php echo date("Y-m-d"); ?>" required="">
          </div>
          
          <button type="submit" name="submit" id="submit_filter_2" class="btn btn-success" ><i class="fa fa-eye"> </i> Lihat Detail </button>

          
</form>
<span id="result"></span>  
</span>
<!--END FILTER DETAIl-->

 <style>
tr:nth-child(even){background-color: #f2f2f2}
</style>

<div class="table-responsive">      
<table id="tableuser" class="table table-bordered">
		<thead>
			<th style='background-color: #4CAF50; color:white'> Nomor Faktur </th>
			<th style='background-color: #4CAF50; color:white'> Tanggal</th>
			<th style='background-color: #4CAF50; color:white'> Kode Barang </th>
			<th style='background-color: #4CAF50; color:white'> Nama Barang </th>
			<th style='background-color: #4CAF50; color:white'> Jumlah </th>
			<th style='background-color: #4CAF50; color:white'> Satuan </th>
			<th style='background-color: #4CAF50; color:white'> Harga </th>
			<th style='background-color: #4CAF50; color:white'> Subtotal </th>

			
		</thead>
		
		<tbody>
		<?php

			//menyimpan data sementara yang ada pada $perintah
			while($data1 = mysqli_fetch_array($detail))
			{
				

				//menampilkan data
			echo "<tr>
			<td>". $data1['no_faktur'] ."</td>
			<td>". $data1['tanggal'] ."</td>
			<td>". $data1['kode_barang'] ."</td>
			<td>". $data1['nama_barang'] ."</td>
			<td>". rp($data1['jumlah']) ."</td>
			<td>". $data1['nama'] ."</td>
			<td>". rp($data1['harga']) ."</td>
			<td>". rp($data1['subtotal']) ."</td>

			</tr>";
			}

//Untuk Memutuskan Koneksi Ke Database

mysqli_close($db); 			
		?>
		</tbody>

	</table>
</div> 
<br>
<a href='expor_excel_item_masuk_detail.php?dari_tanggal=<?php echo $dari_tanggal; ?>&sampai_tanggal=<?php echo $sampai_tanggal; ?>' type='submit' class='btn btn-warning btn-lg'>Download Excel</a>

</div>

<script type="text/javascript">
	$(document).ready(function(){
		$('table').DataTable();
		});
</script>

<script>
    $(function() {
    $( "#dari_tanggal" ).datepicker({dateFormat: "yy-mm-dd"});
    });
    </script>


    <script>
    $(function() {
    $( "#sampai_tanggal" ).datepicker({dateFormat: "yy-mm-dd"});
    });
    </script>

    <script>
    $(function() {
    $( "#dari_tanggal2" ).datepicker({dateFormat: "yy-mm-dd"});
    });
    </script>


    <script>
    $(function() {
    $( "#sampai_tanggal2" ).datepicker({dateFormat: "yy-mm-dd"});
    });
    </script>


<script type="text/javascript">
//fil FAKTUR
$("#submit_filter_1").click(function() {
$.post($("#formtanggal").attr("action"), $("#formtanggal :input").serializeArray(), function(info) { $("#dataabsen").html(info); });
    
});

$("#formtanggal").submit(function(){
    return false;
});

function clearInput(){
    $("#formtanggal :input").each(function(){
        $(this).val('');
    });
};

</script>

<script type="text/javascript">
//fill DETAIL
$("#submit_filter_2").click(function() {
$.post($("#formtanggal").attr("action"), $("#formtanggal :input").serializeArray(), function(info) { $("#dataabsen").html(info); });
    
});

$("#formtanggal").submit(function(){
    return false;
});

function clearInput(){
    $("#formtanggal :input").each(function(){
        $(this).val('');
    });
};
</script>

<script type="text/javascript">
    $(document).ready(function(){
      $("#fil_faktur").hide();
      $("#fil_detail").hide();
  });
</script>


<script type="text/javascript">
    $(document).ready(function(){
        $("#filter_1").click(function(){    
      $("#fil_faktur").show();
      $("#filter_2").show();
      $("#filter_1").hide();  
      $("#fil_detail").hide();
      });

        $("#filter_2").click(function(){    
      $("#fil_detail").show();  
      $("#fil_faktur").hide();
      $("#filter_2").hide();
      $("#filter_1").show();
      });

  });

</script>

<?php include 'footer.php' ?>
