<?php include 'session_login.php';
include 'header.php';
include 'navbar.php';
include 'db.php';
include_once 'sanitasi.php';


$no_reg = stringdoang($_GET['no_reg']);
$nama = stringdoang($_GET['nama']);
$no_rm = stringdoang($_GET['no_rm']);
$bed = stringdoang($_GET['bed']);
$kamar = stringdoang($_GET['kamar']);
$dokter = stringdoang($_GET['dokter']);
$jenis_penjualan = stringdoang($_GET['jenis_penjualan']);
$rujukan = stringdoang($_GET['rujukan']);
$penjamin = stringdoang($_GET['penjamin']);
$bed = stringdoang($_GET['bed']);
$kamar = stringdoang($_GET['kamar']);


?>

<div class="container">


<!--Mulai Modal detail laboratorium-->
<div id="modal_detail" class="modal fade" role="dialog">
  <div class="modal-dialog modal-lg">

    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title"><center><b>Detail Radiologi</b></center></h4>
      </div>

      <div class="modal-body">
      <span id="modal-detail">
        
      </span>
          <table id="table_detail" class="table table-bordered table-sm">
        
        </table>

     </div>

      <div class="modal-footer">
     
  <center> <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button></center> 
      </div>
    </div>

  </div>
</div>
<!--Akhir Modal detail laboratorium-->




<form>
	
<input type="hidden" value="<?php echo $no_reg ?>" class="form-control" name="no_reg" readonly="" autocomplete="off" id="no_reg">

<input type="hidden" value="<?php echo $no_rm ?>" class="form-control" name="no_rm" readonly="" autocomplete="off" id="no_rm" >

<input type="hidden" value="<?php echo $nama ?>" class="form-control" name="nama" readonly="" autocomplete="off" id="nama">

<input type="hidden" value="<?php echo $bed ?>" class="form-control" name="bed" readonly="" autocomplete="off" id="bed" >

<input type="hidden" value="<?php echo $kamar ?>" class="form-control" name="kamar" readonly="" autocomplete="off" id="kamar">

<input type="hidden" value="<?php echo $penjamin ?>" class="form-control" name="penjamin" readonly="" autocomplete="off" id="penjamin" >

<input type="hidden" value="<?php echo $dokter ?>" class="form-control" name="dokter" readonly="" autocomplete="off" id="dokter" >

</form>

<h3><b>Data Radiologi</b></h3>
<br>

<a href="form_pemeriksaan_radiologi_inap.php?no_rm=<?php echo $no_rm ?>&nama=<?php echo $nama ?>&no_reg=<?php echo $no_reg ?>&penjamin=<?php echo $penjamin ?>&dokter=<?php echo $dokter?>&bed=<?php echo $bed ?>&kamar=<?php echo $kamar ?>&jenis_penjualan=Rawat Inap&rujukan=Rujuk Rawat Inap" accesskey="b" class="btn btn-info"><i class="fa fa-plus"></i> Tambah Pemeriksaan</a>


<div class="table-responsive"><!--membuat agar ada garis pada tabel disetiap kolom-->
<span id="result">
<table id="table_radiologi" class="table table-bordered table-sm">
		<thead>
    
<th style="background-color:#4CAF50; color:white; width:10%"><center>Pemeriksaan</center></th>
<th style="background-color: #4CAF50; color: white; width:10%"> No REG</th>
<th style="background-color: #4CAF50; color: white;"><center>No RM</center></th>
<th style="background-color: #4CAF50; color: white; width:20%"> Nama Pasien</th>
<th style="background-color: #4CAF50; color: white;"> Penjamin</th>
<th style="background-color: #4CAF50; color: white;"> Bed</th>
<th style="background-color: #4CAF50; color: white;"> Kamar</th>
<th style="background-color: #4CAF50; color: white;"> Edit Jasa </th>
<th style="background-color: #4CAF50; color: white;"> Detail</th>

		</thead>
		<tbody>
			
		</tbody>

	</table>
</span>


 <!--<h6 style="text-align: left ; color: red"><i>* Bisa Cetak Jika Sudah Input Hasil !!</i></h6>
 <h6 style="text-align: left ; color: red"><i>* Detail Laboratorium Akan Tampil Jika Sudah Melakukan Input Hasil!!</i></h6>-->
</div> <!--/ responsive-->


</div>


<!--start ajax datatable-->
<script type="text/javascript" language="javascript" >
      $(document).ready(function() {
        var dataTable = $('#table_radiologi').DataTable( {
          "processing": true,
          "serverSide": true,
          "ajax":{
            url :"datatable_pemeriksaan_radiologi.php", // json datasource
             "data": function ( d ) {   
                d.no_rm = $("#no_rm").val(); 
                d.no_reg = $("#no_reg").val(); 
                d.nama = $("#nama").val(); 
                d.bed = $("#bed").val(); 
                d.kamar = $("#kamar").val(); 
                d.penjamin = $("#penjamin").val(); 
                d.dokter = $("#dokter").val();
            },
            type: "post",  // method  , by default get

            error: function(){  // error handling
              $(".tbody").html("");

             $("#table_radiologi").append('<tbody class="tbody"><tr><th colspan="3">Tidak Ada Data Yang Ditemukan</th></tr></tbody>');

              $("#table_radiologi_processing").css("display","none");
              
            }
          },
              "fnCreatedRow": function( nRow, aData, iDataIndex ) {
              $(nRow).attr('class','tr-id-'+aData[12]+'');
            },
        } );
      } );
    </script>
<!--end ajax datatable-->



<script type="text/javascript">
$(document).ready(function () {
$(document).on('click', '.detail-radiologi-inap', function (e) {

    var no_reg = $(this).attr('data-reg');
    var no_periksa = $(this).attr('data-periksa');
    
    $.post('table_detail_radiologi_pemeriksaan_inap.php',{no_reg:no_reg,no_periksa:no_periksa},function(info) {
    $("#modal_detail").modal('show');
    $("#modal-detail").html(info);
    
    
    });
    
    });
    });
</script>


<!-- footer  -->
<?php include 'footer.php'; ?>
<!-- end footer  -->