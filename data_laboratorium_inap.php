<?php include 'session_login.php';
include 'header.php';
include 'navbar.php';
include 'db.php';
include_once 'sanitasi.php';


$reg = stringdoang($_GET['no_reg']);
$nama = stringdoang($_GET['nama']);
$rm = stringdoang($_GET['no_rm']);
$bed = stringdoang($_GET['bed']);
$kamar = stringdoang($_GET['kamar']);

$otoritas_laboratorium = $db->query("SELECT input_jasa_lab, input_hasil_lab FROM otoritas_laboratorium WHERE id_otoritas = '$_SESSION[otoritas_id]'");
$take_lab = mysqli_fetch_array($otoritas_laboratorium);
$input_jasa_lab = $take_lab['input_jasa_lab'];
$input_hasil_lab = $take_lab['input_hasil_lab'];

?>

<div class="container">

<!--Mulai Modal detail laboratorium-->

<div id="modal_detail" class="modal fade" role="dialog">
  <div class="modal-dialog modal-lg">

    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title"><center><b>Detail Laboratorium</b></center></h4>
      </div>

      <div class="modal-body">
      <span id="modal-detail">
        
      </span>
          <table id="table_detail" class="table table-bordered table-sm">
        <thead>
           <th> Nama Pemeriksaan </th>
           <th> Hasil Pemeriksaan </th>
           <th> Nilai Normal </th>
           <th> Status Rawat </th>
           
            
        </thead>
        
        <tbody id="data_detail">
        </tbody>
        </table>

     </div>

      <div class="modal-footer">

<h6 style="text-align: left ; color: red"><i>* Jika ingin Edit Silahkan Klik 2x Pada Hasil Pemeriksaan !!</i></h6>
     
  <center> <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button></center> 
      </div>
    </div>

  </div>
</div>
<!--Akhir Modal detail laboratorium-->

<h3><b>Data Laboratorium</b></h3>
<br>


<form>
  <div class="form-group">
    <div class="card card-block">

      <div class="row">

          <div class="col-sm-2">
              <label>No REG</label>		
              <input type="text" value="<?php echo $reg ?>" class="form-control" name="no_reg" autocomplete="off" id="no_reg" readonly="" placeholder="No REG">
	       </div>

	       <div class="col-sm-2">
              <label>No RM</label>
              <input type="text" value="<?php echo $rm ?>" class="form-control" name="no_rm" autocomplete="off" id="no_rm" readonly="" placeholder="No RM">
          </div>

	       <div class="col-sm-3">
		          <label>Nama Pasien</label>
              <input type="text" value="<?php echo $nama ?>" class="form-control" name="nama" autocomplete="off" id="nama" readonly="" placeholder="Nama">
	       </div>

        <div class="col-sm-2">
            <label>Kode Kamar</label>
            <input type="text" value="<?php echo $bed ?>" class="form-control" name="bed" autocomplete="off" id="bed" readonly="" placeholder="Bed">
        </div>

        <div class="col-sm-3">
            <label>Nama Kamar</label>
            <input type="text" value="<?php echo $kamar ?>" class="form-control" name="kamar" autocomplete="off" id="kamar" readonly="" placeholder="Kamar">
        </div>

      </div>


 <input type="hidden" class="form-control" name="no_reg_hidden" autocomplete="off" id="no_reg_hidden" readonly="" placeholder="Kamar">

 <input type="hidden"  class="form-control" name="no_periksa_hidden" autocomplete="off" id="no_periksa_hidden" readonly="" placeholder="Kamar">


    </div>
  </div>
</form>

<?php if ($input_jasa_lab): ?>  
<a href="form_penjualan_lab_inap.php?no_rm=<?php echo $rm ?>&nama=<?php echo $nama ?>&no_reg=<?php echo $reg ?>&jenis_penjualan=Rawat Inap&rujukan=Rujuk Rawat Inap" accesskey="b" class="btn btn-info"><i class="fa fa-plus"></i> Tambah Pemeriksaan</a>
<?php endif?>

<div class="table-responsive"><!--membuat agar ada garis pada tabel disetiap kolom-->
<span id="result">
<table id="table_lab" class="table table-bordered table-sm">
		<thead>
    
<?php if ($input_hasil_lab): ?> 
<th style="background-color: #4CAF50; color: white;"> Input Hasil</th>
<?php endif?>
<th style="background-color: #4CAF50; color: white;"> Cetak</th>
<th style="background-color: #4CAF50; color: white;"> No Periksa</th>
<th style="background-color: #4CAF50; color: white;"> No REG</th>
<th style="background-color: #4CAF50; color: white;"> No RM</th>
<th style="background-color: #4CAF50; color: white;"> Nama Pasien</th>
<th style="background-color: #4CAF50; color: white;"> Dokter</th>
<th style="background-color: #4CAF50; color: white;"> Analis</th>
<th style="background-color: #4CAF50; color: white;"> Status</th>
<th style="background-color: #4CAF50; color: white;"> Waktu </th>
<th style="background-color: #4CAF50; color: white;"> Detail </th>

		</thead>
		<tbody>
			
		</tbody>

	</table>
</span>


 <h6 style="text-align: left ; color: red"><i>* Bisa Cetak Jika Sudah Input Hasil !!</i></h6>
 <h6 style="text-align: left ; color: red"><i>* Detail Laboratorium Akan Tampil Jika Sudah Melakukan Input Hasil!!</i></h6>
</div> <!--/ responsive-->


</div><!-- container  -->

<!--start ajax datatable-->
<script type="text/javascript" language="javascript" >
      $(document).ready(function() {
        var dataTable = $('#table_lab').DataTable( {
          "processing": true,
          "serverSide": true,
          "ajax":{
            url :"show_data_hasil_lab_inap.php", // json datasource
             "data": function ( d ) {   
                d.no_rm = $("#no_rm").val(); 
                d.no_reg = $("#no_reg").val(); 
            },
            type: "post",  // method  , by default get

            error: function(){  // error handling
              $(".tbody").html("");

             $("#table_lab").append('<tbody class="tbody"><tr><th colspan="3">Tidak Ada Data Yang Ditemukan</th></tr></tbody>');

              $("#table_lab_processing").css("display","none");
              
            }
          },
              "fnCreatedRow": function( nRow, aData, iDataIndex ) {
              $(nRow).attr('class','tr-id-'+aData[12]+'');
            },
        } );
      } );
    </script>
<!--end ajax datatable-->



<!--<script type="text/javascript">
$(document).ready(function () {
$(document).on('click', '.detail-lab-inap', function (e) {

		var no_reg = $(this).attr('data-reg');
    var no_periksa = $(this).attr('data-periksa');
		

		
		$.post('show_lab_pemeriksaan_inap.php',{no_reg:no_reg,no_periksa:no_periksa},function(info) {
		    $("#modal_detail").modal('show');
		$("#modal-detail").html(info);
		
		
		});
		
		});
		});
</script>-->



<!--Script mulai untuk tombol detail-->
<script type="text/javascript">
$(document).on('click', '.detail-lab-inap', function (e) {

    var no_reg = $(this).attr('data-reg');
    var no_periksa = $(this).attr('data-periksa');
    $("#no_reg_hidden").val(no_reg);
    $("#no_periksa_hidden").val(no_periksa);
 //ajax
      $('#table_detail').DataTable().destroy();
            var dataTable = $('#table_detail').DataTable( {
            "processing": true,
            "serverSide": true,
            "info":     false,
            "language": { "emptyTable":     "My Custom Message On Empty Table" },
            "ajax":{
              url :"show_lab_pemeriksaan_inap.php", // json datasource
               "data": function ( d ) {
                  d.no_reg = $("#no_reg_hidden").val();
                  d.no_periksa = $("#no_periksa_hidden").val();
                  // d.custom = $('#myInput').val();
                  // etc
              },
                  type: "post",  // method  , by default get
              error: function(){  // error handling
                $("#data_detail").html("");
                $("#table_detail").append('<tbody class="tbody"><tr><th colspan="3"></th></tr></tbody>');
                $("#table_detail_processing").css("display","none");
                
              }
            },
              "fnCreatedRow": function( nRow, aData, iDataIndex ) {
              $(nRow).attr('class','tr-id-'+aData[4]+'');
            },  

      });
      // ajax end
    
        $("#modal_detail").modal('show');
    
    });

</script>
<!--Script akhir untuk tombol detail-->



<script type="text/javascript">
// untuk update hasil pemeriksaaan
$(document).on('dblclick','.edit-nama',function(e){
  
var id = $(this).attr("data-id");
$("#text-nama-"+id+"").hide();
 $("#input-nama-"+id+"").attr("type", "text");

 });

$(document).on('blur','.input_nama',function(e){
var nama_lama = $(this).attr("data-nama");
var id = $(this).attr("data-id");
var input_nama = $(this).val();

if (input_nama == '') {
      alert('Hasil Tidak Boleh Kosong !!');

    $("#input-nama-"+id+"").val(nama_lama);
    $("#text-nama-"+id+"").text(nama_lama);
    $("#text-nama-"+id+"").show();
    $("#input-nama-"+id+"").attr("type", "hidden");

    }
    else
    {

// Start Proses
$.post("update_hasil_laboratorium_registrasi.php",{id:id, input_nama:input_nama},function(data){

$("#text-nama-"+id+"").show();
$("#text-nama-"+id+"").text(input_nama);
$("#input-nama-"+id+"").attr("type", "hidden");           
$("#input-nama-"+id+"").val(input_nama);
$("#input-nama-"+id+"").attr("data-nama",input_nama);


});
// Finish Proses
        }
});
// ending untuk update hasil pemeriksaaan
</script>


<!-- footer  -->
<?php include 'footer.php'; ?>
<!-- end footer  -->