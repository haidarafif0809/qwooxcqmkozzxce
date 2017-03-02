<?php include_once 'session_login.php';

//memasukkan file session login, header, navbar, db.php
include 'header.php';
include 'navbar.php';
include 'sanitasi.php';
include 'db.php';

//menampilkan seluruh data yang ada pada tabel penjualan

$perintah = $db->query("SELECT * FROM penjualan  ORDER BY id DESC");

$jumlah_total_bersih = $db->query("SELECT SUM(total) AS total_bersih FROM penjualan");
$ambil = mysqli_fetch_array($jumlah_total_bersih);

$sub_total_bersih = $ambil['total_bersih'];


$jumlah_total_kotor = $db->query("SELECT SUM(subtotal) AS total_kotor FROM detail_penjualan");
$ambil_kotor = mysqli_fetch_array($jumlah_total_kotor);

$sub_total_kotor = $ambil_kotor['total_kotor'];

$jumlah_potongan = $db->query("SELECT SUM(potongan) AS total_potongan FROM penjualan");
$ambil_potongan = mysqli_fetch_array($jumlah_potongan);

$sub_total_potongan = $ambil_potongan['total_potongan'];

$jumlah_total_tax = $db->query("SELECT SUM(tax) AS total_tax FROM penjualan");
$ambil_tax = mysqli_fetch_array($jumlah_total_tax);

$sub_total_tax = $ambil_tax['total_tax'];

$pilih_akses_penjualan = $db->query("SELECT penjualan_lihat, penjualan_tambah, penjualan_edit, penjualan_hapus FROM otoritas_penjualan WHERE id_otoritas = '$_SESSION[otoritas_id]'");
$penjualan = mysqli_fetch_array($pilih_akses_penjualan);

 ?>

<style>

tr:nth-child(even){background-color: #f2f2f2}

</style>

<div class="container">

 <h3><b>DAFTAR DATA PENJUALAN</b></h3><hr>

<div id="modal_detail" class="modal fade" role="dialog">
  <div class="modal-dialog modal-lg">

    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title"><center><b>Detail Penjualan</b></center></h4>
      </div>

      <div class="modal-body">
      <div class="table-responsive">
      <span id="modal-detail"> </span>
      </div>

     </div>

      <div class="modal-footer">
        
  <center> <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button></center> 
      </div>
    </div>

  </div>
</div>


<div id="modal_alert" class="modal fade" role="dialog">
  <div class="modal-dialog">

    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h3 style="color:orange" class="modal-title"><span class="glyphicon glyphicon-info-sign">Info</span></h3>
        
      </div>

      <div class="modal-body">
      <div class="table-responsive">
      <span id="modal-alert">
       </span>
      </div>

     </div>

      <div class="modal-footer">
        <h6 style="text-align: left"><i> * jika ingin menghapus atau mengedit data,<br>
        silahkan hapus terlebih dahulu Transaksi Yang Di Atas !!</h6>
        <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
      </div>
    </div>

  </div>
</div>


<!-- Modal Hapus data -->
<div id="modal_hapus" class="modal fade" role="dialog">
  <div class="modal-dialog">

    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title">Konfirmsi Hapus Data Penjualan</h4>
      </div>

      <div class="modal-body">
   
   <p>Apakah Anda yakin Ingin Menghapus Data ini ?</p>
   <form >
    <div class="form-group">
    <label>Kode Pelanggan :</label>
     <input type="text" id="kode_pelanggan" class="form-control" readonly=""> 
     <input type="hidden" id="id_hapus" class="form-control" readonly=""> 
     <input type="hidden" id="kode_meja" class="form-control" readonly=""> 
     <input type="hidden" id="faktur_hapus" class="form-control" readonly=""> 
    </div>
   
   </form>
   
  <div class="alert alert-success" style="display:none">
   <strong>Berhasil!</strong> Data berhasil Di Edit
  </div>
 

     </div>

      <div class="modal-footer">
        <button type="button" data-id="" class="btn btn-info" id="btn_jadi_hapus">Ya</button>
        <button type="button" class="btn btn-warning" data-dismiss="modal">Batal</button>
      </div>
    </div>

  </div>
</div><!-- end of modal hapus data  -->


<div class="row">

<div class="col-sm-2">
<div class="dropdown">
             <button class="btn btn-primary dropdown-toggle" type="button" data-toggle="dropdown" style="width:150px"> Jenis Laporan <span class="caret"></span></button>

            <ul class="dropdown-menu dropdown-ins">
      			<li><a class="dropdown-item" href="lap_penjualan_rekap.php"> Laporan Penjualan Rekap </a></li> 
      			<li><a class="dropdown-item" href="lap_penjualan_detail.php"> Laporan Penjualan Detail </a></li>
      			<li><a class="dropdown-item" href="lap_penjualan_harian.php"> Laporan Penjualan Harian </a></li>
            <li><a class="dropdown-item" href="lap_operasi.php"> Laporan Operasi </a></li>
            <li><a class="dropdown-item" href="lap_detail_operasi.php"> Laporan Detail Operasi </a></li>
            <li><a class="dropdown-item" href="lap_penjualan_per_golongan.php"> Laporan Penjualan / Golongan </a></li>

				<!--
				
				<li><a href="lap_pelanggan_rekap.php"> Laporan Jual Per Pelanggan Rekap </a></li>
				<li><a href="lap_sales_detail.php"> Laporan Jual Per Sales Detail </a></li>
				<li><a href="lap_sales_rekap.php"> Laporan Jual Per Sales Rekap </a></li>
				-->

             </ul>
</div> <!--/ dropdown-->
</div>

<div class="col-sm-3">
<!--Dropdown kategori (tenant)-->
<div class="dropdown">

    <!--Trigger-->
    <button class="btn btn-secondary dropdown-toggle" type="button" id="dropdownMenu4" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Cari Berdasarkan Kategori</button>

    <!--Menu-->
    <div class="dropdown-menu dropdown-secondary" aria-labelledby="dropdownMenu4" data-dropdown-in="fadeIn" data-dropdown-out="fadeOut">
        <a class="dropdown-item" id="nav_faktur" href="#">Rekap (Per Kategori)</a>
        <a class="dropdown-item" id="nav_detail" href="#">Detail (Per Kategori)</a>
        <a class="dropdown-item" id="nav_all" href="#">Rekap Seluruh</a>
    </div>
</div>
<!--/Dropdown untuk search kategori (tenant)-->
</div>
  
</div>

<!--span untuk cari bersarkan TANEN / KATEGORI Rekap-->
<span id="show_faktur">
<form class="form-inline" role="form" id="form_no_faktur" >

<div class="form-group ">
<br>
    <select class="form-control " id="tenant_faktur" style="width:170px" name="tenant_faktur" required="">
    <option value="">Pilih Kategori</option>
      <?php 
      $query = $db->query("SELECT nama_kategori FROM kategori");
      while ( $icd = mysqli_fetch_array($query))
      {
      echo "<option value='".$icd['nama_kategori']."'>".$icd['nama_kategori']."</option>";
      }
      ?>
    </select>
</div>

<div class="form-group"> 
  <input type="text" name="dari_tanggal_faktur" id="dari_tanggal_faktur" autocomplete="off" class="form-control tanggal_cari" placeholder="Dari Tanggal">
</div>

<div class="form-group"> 
  <input type="text" name="sampai_tanggal_faktur" id="sampai_tanggal_faktur" autocomplete="off" value="<?php echo date("Y-m-d"); ?>" class="form-control tanggal_cari" placeholder="Sampai Tanggal">
</div>

<button type="submit" name="submit" id="lihat_faktur" class="btn btn-default " style="background-color:#0277bd"><i class="fa fa-eye"> </i> Lihat Per Faktur </button>
</form>
</span>
<!--Akhir span untuk cari bersarkan TANEN / KATEGORI Rekap-->

<!--span untuk cari bersarkan TANEN / KATEGORI  detail-->
<span id="show_detail">
<form class="form-inline" role="form" id="form_no_faktur" >

<div class="form-group ">
    <select class="form-control " id="tenant_detail" style="width:170px" name="tenant_detail" required="">
    <option value="">Pilih Kategori</option>
      <?php 
      $query = $db->query("SELECT nama_kategori FROM kategori");
      while ( $icd = mysqli_fetch_array($query))
      {
      echo "<option value='".$icd['nama_kategori']."'>".$icd['nama_kategori']."</option>";
      }
      ?>
    </select>
</div>


<div class="form-group"> 
  <input type="text" name="dari_tanggal_detail" id="dari_tanggal_detail" autocomplete="off" class="form-control tanggal_cari" placeholder="Dari Tanggal">
</div>

<div class="form-group"> 
  <input type="text" name="sampai_tanggal_detail" id="sampai_tanggal_detail" autocomplete="off" value="<?php echo date("Y-m-d"); ?>" class="form-control tanggal_cari" placeholder="Sampai Tanggal">
</div>


<button type="submit" name="submit" id="lihat_detail" class="btn btn-default " style="background-color:#0277bd"><i class="fa fa-eye"> </i> Lihat Detail </button>
</form>
</span>
<!--Akhir span untuk cari bersarkan TANEN / KATEGORI detail-->

<!--span untuk cari bersarkan tanggal-->
<span id="show_all">
<form class="form-inline" role="form" id="form_all">
<div class="form-group"> 
	<input type="text" name="dari_tanggal" id="dari_tanggal" autocomplete="off" class="form-control tanggal_cari" placeholder="Dari Tanggal">
</div>

<div class="form-group"> 
	<input type="text" name="sampai_tanggal" id="sampai_tanggal" autocomplete="off" value="<?php echo date("Y-m-d"); ?>" class="form-control tanggal_cari" placeholder="Sampai Tanggal">
</div>

<button type="submit" name="submit" id="lihat_all" class="btn btn-default" style="background-color:#0277bd"><i class="fa fa-eye"> </i> Lihat </button>
</form>
</span>
<!--Akhir span untuk cari bersarkan tanggal-->

<br>

<span id="table-tenant">
 <div class="table-responsive"><!--membuat agar ada garis pada tabel disetiap kolom-->
<span id="table-baru">
<table id="tableuser" class="table table-bordered table-sm">
		<thead>

       <th style="background-color: #4CAF50; color: white;"> Edit  </th>

        <?php 

        $pilih_akses_penjualan_hapus = $db->query("SELECT penjualan_hapus FROM otoritas_penjualan WHERE id_otoritas = '$_SESSION[otoritas_id]' AND penjualan_hapus = '1'");
        $penjualan_hapus = mysqli_num_rows($pilih_akses_penjualan_hapus);


            if ($penjualan_hapus > 0){

              echo "<th style='background-color: #4CAF50; color:white'> Hapus </th>";

            }
        ?>

      <th style="background-color: #4CAF50; color: white;"> Detail  </th>
      <th style="background-color: #4CAF50; color: white;"> Cetak Tunai </th>
      <th style="background-color: #4CAF50; color: white;"> Cetak Piutang </th>
			<th style="background-color: #4CAF50; color: white;"> No. Faktur </th>
			<th style="background-color: #4CAF50; color: white;"> No. RM</th>
			<th style="background-color: #4CAF50; color: white;"> No. REG </th>
      <th style="background-color: #4CAF50; color: white;"> Nama </th>
      <th style="background-color: #4CAF50; color: white;"> Dokter </th>
			<th style="background-color: #4CAF50; color: white;"> Penjamin </th>
      <th style="background-color: #4CAF50; color: white;"> Tanggal </th>
      <th style="background-color: #4CAF50; color: white;"> Jam </th>
			<th style="background-color: #4CAF50; color: white;"> Petugas </th>
			<th style="background-color: #4CAF50; color: white;"> Total Penjualan </th>
      <th style="background-color: #4CAF50; color: white;"> Total Disc.(Rp) </th>
      <th style="background-color: #4CAF50; color: white;"> Jenis Penjualan </th>
      <th style="background-color: #4CAF50; color: white;"> Status </th>

      
		</thead>
		
		<tbody>
		
		</tbody>

	</table>
</span>
</div> <!--/ responsive-->

<!--
<h3><i> Sub. Total Bersih : <b>Rp. <?php echo rp($sub_total_bersih); ?></b> Sub. Total Kotor : <b>Rp. <?php echo rp($sub_total_kotor); ?></b></i></h3> 
<h3><i> Total Potongan : <b>Rp. <?php echo rp($sub_total_potongan); ?></b> Total Pajak : <b>Rp. <?php echo rp($sub_total_tax); ?></b></i></h3> 
</div> --> <!--/ container-->
</span>

<script type="text/javascript" language="javascript" >

      $(document).ready(function() {
        var dataTable = $('#tableuser').DataTable( {
          "processing": true,
          "serverSide": true,
          "ordering": false,
          "ajax":{
            url :"show_data_penjualan.php", // json datasource
            type: "post",  // method  , by default get
            error: function(){  // error handling
              $(".tbody").html("");

             $("#tableuser").append('<tbody class="tbody"><tr><th colspan="3">Tidak Ada Data Yang Ditemukan</th></tr></tbody>');

              $("#tableuser_processing").css("display","none");
              
            }
          },
              "fnCreatedRow": function( nRow, aData, iDataIndex ) {
              $(nRow).attr('class','tr-id-'+aData[17]+'');
            },

        } );
      } );
    </script>
		<!--menampilkan detail penjualan-->
	
<script type="text/javascript">
   $(document).ready(function(){
      $("#show_faktur").hide();
      $("#show_detail").hide();
      $("#show_all").hide();

  });
</script>

<script type="text/javascript">
$(document).ready(function(){
    $("#nav_faktur").click(function(){    
    $("#show_faktur").show();
    $("#show_detail").hide();
    $("#show_all").hide();  
    });

    $("#nav_detail").click(function(){    
    $("#show_detail").show();  
    $("#show_faktur").hide();
    $("#show_all").hide();  

    });

    $("#nav_all").click(function(){    
    $("#show_all").show();  
    $("#show_faktur").hide();
    $("#show_detail").hide();
    $("#table-baru").html(info); 
    });

});
</script>	

		<script type="text/javascript">
		
    $(document).ready(function () {
    $(document).on('click', '.detail-penjualan', function (e) {

		var no_faktur = $(this).attr('data-faktur');
		var no_reg = $(this).attr('data-reg');

		
		$("#modal_detail").modal('show');
		
		$.post('proses_detail_penjualan.php',{no_reg:no_reg,no_faktur:no_faktur},function(info) {
		
		$("#modal-detail").html(info);
		
		
		});
		
		});
		});
		</script>

<script>
  $(function() {
  $( ".tanggal_cari" ).pickadate({ selectYears: 100, format: 'yyyy-mm-dd'});
  });
  </script>


<!--Start 3 proses tenan (kategori)-->
<script type="text/javascript">
//berdasrkan Faktur
        $("#lihat_faktur").click(function(){

        var tenant_faktur = $("#tenant_faktur").val();        
        var dari_tanggal = $("#dari_tanggal_faktur").val();        
        var sampai_tanggal = $("#sampai_tanggal_faktur").val(); 

if(dari_tanggal == '')
{
  alert("Isi Dahulu Kolom Dari Tanggal !!");
  $("#dari_tanggal_faktur").focus(); 
}
else if (sampai_tanggal == '')
{
 alert("Isi Dahulu Kolom Sampai Tanggal !!");
  $("#sampai_tanggal_faktur").focus(); 
}
else
{

$.post("show_kategori_faktur.php", {tenant_faktur:tenant_faktur,dari_tanggal:dari_tanggal,
sampai_tanggal:sampai_tanggal},function(info){
        
        $("#table-tenant").html(info);

        });
        
        }
        });      
        $("form").submit(function(){
        
        return false;
        
        });
        
</script>

<script type="text/javascript">
//berdasrkan Detail
        $("#lihat_detail").click(function(){
        var tenant_detail = $("#tenant_detail").val();        
        var dari_tanggal = $("#dari_tanggal_detail").val();        
        var sampai_tanggal = $("#sampai_tanggal_detail").val(); 

if(dari_tanggal == '')
{
  alert("Isi Dahulu Kolom Dari Tanggal !!");
  $("#dari_tanggal_detail").focus(); 
}
else if (sampai_tanggal == '')
{
 alert("Isi Dahulu Kolom Sampai Tanggal !!");
  $("#sampai_tanggal_detail").focus(); 
}
else
{
        $.post("show_kategori_detail.php", {tenant_detail:tenant_detail,dari_tanggal:dari_tanggal,sampai_tanggal:sampai_tanggal},function(info){
        
        $("#table-tenant").html(info);

        });
        }
        
        });      
        $("form").submit(function(){
        
        return false;
        
        });
        
</script>

<script type="text/javascript">
//berdasrkan Detail
        $("#lihat_all").click(function(){
        var dari_tanggal = $("#dari_tanggal").val();        
        var sampai_tanggal = $("#sampai_tanggal").val();        
        $.post("show_kategori_all.php", {dari_tanggal:dari_tanggal,sampai_tanggal:sampai_tanggal},function(info){
        
        $("#table-tenant").html(info);

        });
        
        
        });      
        $("form").submit(function(){
        
        return false;
        
        });
        
</script>
<!--end 3 proses tenan (kategori)-->

<!--Hapus untuk penjualan (cek untuk retur)-->
<script type="text/javascript">
  
    $(document).on('click', '.btn-alert', function (e) {
    var no_faktur = $(this).attr("data-faktur");

    $.post('modal_retur_piutang.php',{no_faktur:no_faktur},function(data){


    $("#modal_alert").modal('show');
    $("#modal-alert").html(data);

    });

    
    });

</script>
<!--cek untuk return-->

<!--Hapus pemberitahuan dan fungsi-->
<script type="text/javascript">
      $(document).ready(function(){
//fungsi hapus data

    $(document).on('click', '.btn-hapus', function (e) {
    var kode_pelanggan = $(this).attr("data-pelanggan");
    var id = $(this).attr("data-id");
    var no_faktur = $(this).attr("data-faktur");
    var kode_meja = $(this).attr("kode_meja");
    $("#kode_pelanggan").val(kode_pelanggan);
    $("#id_hapus").val(id);
    $("#faktur_hapus").val(no_faktur);
    $("#kode_meja").val(kode_meja);
    $("#modal_hapus").modal('show');
    
    
    });
    
    $("#btn_jadi_hapus").click(function(){
    
    
    var id = $("#id_hapus").val();
    var no_faktur = $("#faktur_hapus").val();
    var kode_meja = $("#kode_meja").val();
    $.post("hapus_data_penjualan.php",{id:id,no_faktur:no_faktur,kode_meja:kode_meja},function(data){
    if (data != '') {

    
    $("#modal_hapus").modal('hide');
    $(".tr-id-"+id).remove();
    
    }
    
    });
    
    
    });




            $('form').submit(function(){
            
            return false;
            });
});

    </script>
<!--Ending Hapus pemberitahuan dan fungsi-->

<?php include 'footer.php'; ?>