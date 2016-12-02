<?php include 'session_login.php';
//memasukkan file session login, header, navbar, db.php
include 'header.php';
include 'navbar.php';
include 'db.php';
include 'sanitasi.php';


$dari_tanggal = $_POST['dari_tanggal'];
$sampai_tanggal= $_POST['sampai_tanggal'];



//menampilkan seluruh data yang ada pada tabel penjualan
$perintah = $db->query("SELECT *, s.nama FROM detail_item_keluar dik INNER JOIN satuan s ON dik.satuan = s.id WHERE tanggal >= '$dari_tanggal' AND tanggal <= '$sampai_tanggal' order by tanggal asc");

?>
<div class="container"><!--start of container-->

<h3><b><center> Data Detail Item Keluar Dari Tanggal <?php echo $dari_tanggal; ?> s/d <?php echo $sampai_tanggal; ?> </center> </b></h3><hr>


<?php
include 'db.php';

$pilih_akses_item_masuk = $db->query("SELECT * FROM otoritas_item_keluar WHERE id_otoritas = '$_SESSION[otoritas_id]'");
$item_masuk = mysqli_fetch_array($pilih_akses_item_masuk);

if ($item_masuk['item_keluar_tambah'] > 0) {

echo '<a href="form_item_keluar.php" class="btn btn-info"> <i class="fa fa-plus"> </i> ITEM KELUAR</a>';

}

?>

<br>
<button type="submit" name="submit" id="filter_1" class="btn btn-primary" > Filter Faktur </button>
<button type="submit" name="submit" id="filter_2" class="btn btn-primary" > Filter Detail </button>


<!--START FILTER FAKTUR-->
<span id="fil_faktur">
<form class="form-inline" action="show_filter_item_keluar.php" method="post" role="form">
					
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
<form class="form-inline" action="show_filter_item_keluar_detail.php" method="post" role="form">
					
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

<br>
<br>

<style>
tr:nth-child(even){background-color: #f2f2f2}
</style>


<div class="table-responsive"><!--membuat agar ada garis pada tabel disetiap kolom-->
<span id="tabel_baru">
<table id="tableuser" class="table table-bordered">
		<thead>
			<th style='background-color: #4CAF50; color:white'> Nomor Faktur </th>
			<th style='background-color: #4CAF50; color:white'> Kode Barang </th>
			<th style='background-color: #4CAF50; color:white'> Nama Barang </th>
			<th style='background-color: #4CAF50; color:white'> Gudang </th>
			<th style='background-color: #4CAF50; color:white'> Jumlah </th>
			<th style='background-color: #4CAF50; color:white'> Satuan </th>
			<th style='background-color: #4CAF50; color:white'> Harga </th>
			<th style='background-color: #4CAF50; color:white'> Subotal </th>
		
		</thead>
		
		<tbody>
		<?php

			//menyimpan data sementara yang ada pada $perintah
			while ($data1 = mysqli_fetch_array($perintah))
			{

			echo "<tr class='tr-id-".$data1['id']."'>
			<td>". $data1['no_faktur'] ."</td>
			<td>". $data1['kode_barang'] ."</td>
			<td>". $data1['nama_barang'] ."</td>
			<td>". $data1['gudang_item_keluar'] ."</td>
			<td>". $data1['jumlah'] ."</td>
			<td>". $data1['nama'] ."</td>
			<td>". $data1['harga'] ."</td>
			<td>". $data1['subtotal'] ."</td>
			</tr>";
			 } 

			
			

			//Untuk Memutuskan Koneksi Ke Database
		mysqli_close($db);
		?>
		</tbody>

	</table>
</span>

</div>




<a href='expor_excel_item_keluar_detail.php?dari tanggal=<?php echo $dari_tanggal; ?>&sampai tanggal=<?php echo $sampai_tanggal; ?>' class='btn btn-warning' role='button'>Download Excel</a>


</div><!--end of container-->



<script>
		$(document).ready(function(){
		$('#tableuser').DataTable();
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

<?php 
include 'footer.php'; ?>