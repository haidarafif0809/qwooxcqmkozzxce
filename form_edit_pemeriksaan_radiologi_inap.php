<?php include 'session_login.php';
// memasukan file session login,  header, navbar, db.php,
include 'header.php';
include 'navbar.php';
include 'db.php';
include 'sanitasi.php';

$no_pemeriksaan = stringdoang($_GET['no_pemeriksaan']);
$no_rm = stringdoang($_GET['no_rm']);
$nama = stringdoang($_GET['nama_pasien']);
$no_reg = stringdoang($_GET['no_reg']);
$penjamin = stringdoang($_GET['penjamin']);
$tanggal = stringdoang($_GET['tanggal']);
$dokter = stringdoang($_GET['dokter']);
$bed = stringdoang($_GET['bed']);
$kamar = stringdoang($_GET['kamar']);
$jenis_penjualan = 'Rawat Inap';
$rujukan = 'Rujuk Rawat Inap';


?>

<div style="padding-left: 5%; padding-right: 5%"><!--Container / Padding-->


<!--tampilan modal-->
<div id="myModal" class="modal fade" role="dialog">
  <div class="modal-dialog">

    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
               
              <h4 class="modal-title">Daftar Pemeriksaan Radiologi</h4>
      </div>
      <div class="modal-body">

        <form class="form"  role="form" id="formtambahprodukcari">
            <div class="table-responsive">
              
              <div class="form-group col-xs-6"> <!-- /  -->

                <h5><b> Pakai Kontras </b></h5><br>

                  <input type="checkbox" class="cekcbox1 filled-in" id="checkbox1">
                  <label for="checkbox1" class="pilih-semua-kontras" data-toogle="0"><b> PILIH SEMUA </b></label><br>
                  
                  <?php 
                    $select_pemriksaan_kontras = $db->query("SELECT id, kode_pemeriksaan, nama_pemeriksaan, kontras, harga_1 FROM pemeriksaan_radiologi WHERE kontras = '1' ORDER BY no_urut ASC");

                    while ($data_kontras = mysqli_fetch_array($select_pemriksaan_kontras)) {

                    $query_pemeriksaan = $db->query("SELECT kode_barang FROM tbs_penjualan_radiologi WHERE kode_barang = '$data_kontras[kode_pemeriksaan]' AND no_pemeriksaan = '$no_pemeriksaan' AND no_reg = '$no_reg'");

                    $jumlah_pemeriksaan = mysqli_num_rows($query_pemeriksaan);

                      if ($jumlah_pemeriksaan > 0) {
                      
                          echo '<input type="checkbox" class="cekcbox-1 filled-in" id="pemeriksaan-'.$data_kontras['id'].'" name="pakai_kontras" value="'.$data_kontras['kode_pemeriksaan'].'" checked="true" >
                          <label for="pemeriksaan-'.$data_kontras['id'].'"
                          data-id="'.$data_kontras['id'].'"
                          data-kode="'.$data_kontras['kode_pemeriksaan'].'"
                          data-nama="'.$data_kontras['nama_pemeriksaan'].'"
                          data-kontras="'.$data_kontras['kontras'].'"
                          data-harga="'.$data_kontras['harga_1'].'" class="insert-tbs" data-toogle="1" id="label-'.$data_kontras['id'].'"
                           checked="true" >'.$data_kontras['nama_pemeriksaan'].'</label> <br>';

                      }
                      else{
                      
                          echo '<input type="checkbox" class="cekcbox-1 filled-in" id="pemeriksaan-'.$data_kontras['id'].'" name="pakai_kontras" value="'.$data_kontras['kode_pemeriksaan'].'">
                          <label for="pemeriksaan-'.$data_kontras['id'].'"
                          data-id="'.$data_kontras['id'].'"
                          data-kode="'.$data_kontras['kode_pemeriksaan'].'"
                          data-nama="'.$data_kontras['nama_pemeriksaan'].'"
                          data-kontras="'.$data_kontras['kontras'].'"
                          data-harga="'.$data_kontras['harga_1'].'" class="insert-tbs pemeriksaan-kontras" data-toogle="0" id="label-'.$data_kontras['id'].'"
                          >'.$data_kontras['nama_pemeriksaan'].'</label> <br>';

                      }

                    }
                    
                  ?>

              </div> <!-- /  -->

              <div class="form-group col-xs-6"> <!-- /  -->

                <h5><b> Tidak Pakai Kontras </b></h5><br>

                  <input type="checkbox" class="cekcbox2 filled-in" id="checkbox2">
                  <label for="checkbox2" class="pilih-semua-tanpa-kontras" data-toogle="0"><b> PILIH SEMUA </b></label><br>

                  <?php 
                    $select_pemriksaan_tanpa_kontras = $db->query("SELECT id, kode_pemeriksaan, nama_pemeriksaan, kontras, harga_1 FROM pemeriksaan_radiologi WHERE kontras = '0' ORDER BY no_urut ASC");

                    while ($data_tanpa_kontras = mysqli_fetch_array($select_pemriksaan_tanpa_kontras)) {

                      $query_pemeriksaan = $db->query("SELECT kode_barang FROM tbs_penjualan_radiologi WHERE kode_barang = '$data_tanpa_kontras[kode_pemeriksaan]' AND no_reg = '$no_reg' AND no_pemeriksaan = '$no_pemeriksaan' ");

                      $jumlah_pemeriksaan = mysqli_num_rows($query_pemeriksaan);

                        if ($jumlah_pemeriksaan > 0) {

                            echo '<input type="checkbox" class="cekcbox-2 filled-in" name="tanpa_kontras" 
                            id="pemeriksaan-'.$data_tanpa_kontras['id'].'" value="'.$data_tanpa_kontras['kode_pemeriksaan'].'" checked="true"  > 
                            <label for="pemeriksaan-'.$data_tanpa_kontras['id'].'"
                            data-id="'.$data_tanpa_kontras['id'].'"
                            data-kode="'.$data_tanpa_kontras['kode_pemeriksaan'].'"
                            data-nama="'.$data_tanpa_kontras['nama_pemeriksaan'].'"
                            data-kontras="'.$data_tanpa_kontras['kontras'].'"
                            data-harga="'.$data_tanpa_kontras['harga_1'].'" class="insert-tbs" data-toogle="1" id="label-'.$data_tanpa_kontras['id'].'"
                             checked="true"  >'.$data_tanpa_kontras['nama_pemeriksaan'].'</label> <br>';
                        }
                        else{

                            echo '<input type="checkbox" class="cekcbox-2 filled-in" name="tanpa_kontras" 
                            id="pemeriksaan-'.$data_tanpa_kontras['id'].'" value="'.$data_tanpa_kontras['kode_pemeriksaan'].'"> 
                            <label for="pemeriksaan-'.$data_tanpa_kontras['id'].'"
                            data-id="'.$data_tanpa_kontras['id'].'"
                            data-kode="'.$data_tanpa_kontras['kode_pemeriksaan'].'"
                            data-nama="'.$data_tanpa_kontras['nama_pemeriksaan'].'"
                            data-kontras="'.$data_tanpa_kontras['kontras'].'"
                            data-harga="'.$data_tanpa_kontras['harga_1'].'" class="insert-tbs pemeriksaan-tanpa-kontras" data-toogle="0" id="label-'.$data_tanpa_kontras['id'].'"
                            >'.$data_tanpa_kontras['nama_pemeriksaan'].'</label> <br>';
                        }


                    }


                    
                  ?>

              </div> <!-- /  -->

            </div>
        </form>
      
      </div>

      <div class="modal-footer">
      <center>
        <button type="button" class="btn btn-warning" id="btnSubmit"> <i class='fa fa-plus'></i> Submit</button>
        <!--<button type="button" class="btn btn-danger" id="btnCancel"><i class='fa fa-close'></i> Cancel</button>-->

        <button type="button" accesskey="e" class="btn btn-danger" data-dismiss="modal"><i class='fa fa-close'></i> Close</button>
	</center>

      </div>
    </div>

  </div>
</div><!-- end of modal data barang  -->


<h3> FORM EDIT PEMERIKSAAN RADIOLOGI - R. INAP</h3><hr>
<br>

	<div class="row"><!--Row Atas-->

		<div class="col-xs-2">
	  		<label> No. Reg </label><br>
	    	<input  name="no_reg" style="height: 15px" type="text" id="no_reg" class="form-control" required="" autofocus="" value="<?php echo $no_reg ?>" readonly="">
	  	</div>

	  	<div class="col-xs-2 form-group"> 
    		<label> Nama Pasien </label><br>
  			<input  name="nama_pelanggan" type="text" readonly="" style="height:15px;" id="nama_pasien" class="form-control" required="" autofocus="" value="<?php echo $nama ?>">
			<input  name="no_rm" type="hidden" style="height:15px;" id="no_rm" class="form-control" required="" autofocus="" value="<?php echo $no_rm ?>">
		</div>

		<div class="col-xs-1">
      		<label> Pemeriksaan </label><br>
      		<input type="text" style="height:15px;" value="<?php echo $no_pemeriksaan ?>" class="form-control" name="no_pemeriksaan" readonly="" autocomplete="off" id="no_pemeriksaan">
    	</div>

    	<div class="col-xs-2">
   			<label> Dokter Pengirim </label><br>
    		<select name="dokter" id="dokter" class="form-control chosen" required="" >

  			<?php 
        	//untuk menampilkan semua data pada tabel pelanggan dalam DB
    		$query01 = $db->query("SELECT nama,id FROM user WHERE tipe = '1'");

    		//untuk menyimpan data sementara yang ada pada $query
    		while($data01 = mysqli_fetch_array($query01)){    

	      		if ($data01['id'] == $dokter) {
	       			echo "<option selected value='".$data01['id']."'>".$data01['nama']."</option>";
	      		}
	      		else{
	        		echo "<option value='".$data01['id'] ."'>".$data01['nama'] ."</option>";
	      		}
    		}
			?>
 			</select>
		</div>

		<div class="col-xs-2">
		   <label> Petugas Radiologi </label><br>
		   <select name="petugas" id="petugas_radiologi" class="form-control chosen" required="" >
		  	<?php 
		    $query01 = $db->query("SELECT nama,id FROM user WHERE tipe = '5'");
		    //untuk menyimpan data sementara yang ada pada $query
		    while($data01 = mysqli_fetch_array($query01))    {
		        echo "<option value='".$data01['id'] ."'>".$data01['nama'] ."</option>";
		    }
			?>
		  </select>
		</div>

		<!--HIDDEN INPUT-->
		<input  name="no_pemeriksaan" type="hidden" style="height:15px;" id="no_pemeriksaan" class="form-control" required="" autofocus="" value="<?php echo $no_pemeriksaan; ?>" >

  <!--Input Hidden-->
    <input type="hidden" class="form-control" name="nama_barang" autocomplete="off" id="nama_barang" placeholder="Nama" >
    <input type="hidden" class="form-control" name="kode_barang" autocomplete="off" id="kode_barang" placeholder="Kode" >
    <input type="hidden" id="id_radiologi" name="id_radiologi" class="form-control" value="" placeholder="ida jasa"> 
    <input type="hidden" class="form-control" name="kontras" id="kontras" placeholder="Kontras" >
    <input type="hidden" id="harga_produk" name="harga_produk" class="form-control" value="" placeholder="harga produk"> 

		<!--HIDDEN INPUT-->
	</div><!--Akhir Row Atas-->

  <button type="button" id="cari_produk_radiologi" class="btn btn-info " data-toggle="modal" data-target="#myModal"><i class='fa fa-search'></i> Cari Jasa (F1) </button> 

<button class="btn btn-default" id="simpan_ranap"> <i class="fa fa-save"></i> Simpan Pemeriksaan </button>

<span id="span_tbs">            
                
                  <div class="table-responsive">
                    <table id="tabel_tbs_radiologi" class="table table-bordered table-sm">
                          <thead> <!-- untuk memberikan nama pada kolom tabel -->
                              
                              <th style='background-color: #4CAF50; color: white'> Kode  </th>
                              <th style='background-color: #4CAF50; color: white'> Nama </th>
                              <th style='background-color: #4CAF50; color: white'> Dokter Pengirim </th>

                              <th style='background-color: #4CAF50; color: white'> Hapus </th>
                          
                          </thead> <!-- tag penutup tabel -->
                    </table>
                  </div>

                </span> 

                <h6 style="text-align: left; color: red"><i><b> * Short Key (F1s) untuk mencari Kode Produk atau Nama Produk.</b></i></h6>


</div><!--Akhir Container / Padding-->


<script type="text/javascript"> 
    $(".chosen").chosen({no_results_text: "Maaf, Data Tidak Ada!",search_contains:true});  
</script>

<!-- js untuk tombol shortcut -->
 <script src="shortcut.js"></script>
<!-- js untuk tombol shortcut -->

<script type="text/javascript">
shortcut.add("f1", function() {
	$("#cari_produk_radiologi").click();
}); 
</script>


<script type="text/javascript">
  $(document).ready(function(){
    // START DATATABLE AJAX START DATATABLE AJAX START DATATABLE AJAX START DATATABLE AJAX START DATATABLE AJAX START DATATABLE AJAX
      $('#tabel_tbs_radiologi').DataTable().destroy();
            var dataTable = $('#tabel_tbs_radiologi').DataTable( {
            "processing": true,
            "serverSide": true,
            "info":     true,
            "language": { "emptyTable":     "Tidak Ada Data" },
            "ajax":{
              url :"data_tbs_penjualan_radiologi_inap.php", // json datasource
                              "data": function ( d ) {
                                d.no_reg = $("#no_reg").val();
                                d.no_pemeriksaan = $("#no_pemeriksaan").val();
                                // d.custom = $('#myInput').val();
                                // etc
                              },
                              type: "post",  // method  , by default get
              error: function(){  // error handling
                $(".tbody").html("");
                $("#tabel_tbs_radiologi").append('<tbody class="tbody"><tr><th colspan="3"></th></tr></tbody>');
                $("#tableuser_processing").css("display","none");
                
              }
            }   

      });
        
        $("#span_tbs").show()
// END DATATABLE AJAX END DATATABLE AJAX END DATATABLE AJAX END DATATABLE AJAX END DATATABLE AJAX END DATATABLE AJAX
  });
</script>

<script type="text/javascript">
$(function() {
    $('.cekcbox1').click(function() {
        $('.cekcbox-1').prop('checked', this.checked);
    });
});
</script>
  

<script type="text/javascript">
$(function() {
    $('.cekcbox2').click(function() {
        $('.cekcbox-2').prop('checked', this.checked);
    });
});
</script>


<!--INSERT SATU SATU -->
<script>
$(document).on('click','.insert-tbs',function(e){
    var data_toggle = $(this).attr('data-toogle');
    var kode_barang = $(this).attr('data-kode');
    var nama_barang = $(this).attr('data-nama');
    var kontras = $(this).attr('data-kontras');
    var harga = $(this).attr('data-harga');
    var id = $(this).attr('data-id');

    var no_reg = $("#no_reg").val();
    var petugas_radiologi = $("#petugas_radiologi").val();
    var dokter = $("#dokter").val();
    var jumlah_barang = 1;
    var tipe_barang ="Jasa";

    $('#kode_barang').trigger('chosen:update');
    $('#kode_barang').val(kode_barang);

    $('#nama_barang').val(nama_barang);
    $('#id_radiologi').val(id);
    $('#kontras').val(kontras);
    $('#harga_produk').val(harga);
    $('#kolom_cek_harga').val('1');

    var nama_barang = $("#nama_barang").val();
    var id = $("#id_radiologi").val();
    var kontras = $("#kontras").val();
    var harga = $("#harga_produk").val();
    var kolom_cek_harga = $("#kolom_cek_harga").val();
    var kode_barang = $("#kode_barang").val();
    var no_pemeriksaan = $("#no_pemeriksaan").val();

    if (data_toggle == 0) {

        $.post('cek_tbs_penjualan_radiologi_inap.php',{no_pemeriksaan:no_pemeriksaan,kode_barang:kode_barang,no_reg:no_reg}, function(data){

        if(data == 1){

            $('#label-'+id+'').attr("data-toogle", 0);
            alert("Pemeriksaan '"+nama_barang+"' Sudah Ada, Silakan Pilih Pemeriksaan Yang Lain !");
              
        }
        else{
              
            $('#label-'+id+'').attr("data-toogle", 1);
            console.log(data_toggle);

            $.post("proses_insert_edit_tbs_radiologi_inap.php",{no_pemeriksaan:no_pemeriksaan,nama_barang:nama_barang,jumlah_barang:jumlah_barang,harga:harga,tipe_barang:tipe_barang,kode_barang:kode_barang,no_reg:no_reg,dokter:dokter,kontras:kontras,petugas_radiologi:petugas_radiologi},function(data){


            });

        }

        });
    }
    else{
                  
        $('#label-'+id+'').attr("data-toogle", 0);

        $.post("hapus_radiologi_edit_inap.php",{no_pemeriksaan:no_pemeriksaan,no_reg:no_reg, kode_barang:kode_barang},function(data){

        });
    }
    
    $("form").submit(function(){
      return false;    
    });
});
//AKHIR INSERT SOLO DATA 
</script>


<!--INSERT SEMUANYA (PILIH SEMUA KONTRAS)-->
<script>
$(document).on('click','.pilih-semua-kontras',function(e){

    var data_toggle = $(this).attr('data-toogle');
    var no_reg = $("#no_reg").val();
    var petugas_radiologi = $("#petugas_radiologi").val();
    var dokter = $("#dokter").val();
    var jumlah_barang = 1;
    var tipe_barang ="Jasa";

    $('#kolom_cek_harga').val('1');
    var kolom_cek_harga = $("#kolom_cek_harga").val();
    var no_pemeriksaan = $("#no_pemeriksaan").val();

    if (data_toggle == 0) {
              
        $(this).attr("data-toogle", 1);
        $(".pemeriksaan-kontras").attr("data-toogle", 1);

        $.post("proses_insert_tbs_radiologi_semua_kontras_edit_inap.php",{no_pemeriksaan:no_pemeriksaan,tipe_barang:tipe_barang,no_reg:no_reg,dokter:dokter,petugas_radiologi:petugas_radiologi},function(data){
              
        });


    }
    else{
                  
        $(this).attr("data-toogle", 0);
        $(".pemeriksaan-kontras").attr("data-toogle", 0);

        $.post("hapus_radiologi_semua_kontras_edit_inap.php",{no_pemeriksaan:no_pemeriksaan,no_reg:no_reg},function(data){

        });
    }
    
    $("form").submit(function(){
      return false;    
    });
});
//AKHIR INSERT SEMUANYA (PILIH SEMUA KONTRAS)
</script>



<!--INSERT SEMUANYA (PILIH SEMUA TANPA KONTRAS)-->
<script>
$(document).on('click','.pilih-semua-tanpa-kontras',function(e){

    var data_toggle = $(this).attr('data-toogle');
    var no_reg = $("#no_reg").val();
    var petugas_radiologi = $("#petugas_radiologi").val();
    var dokter = $("#dokter").val();
    var jumlah_barang = 1;
    var tipe_barang ="Jasa";

    $('#kolom_cek_harga').val('1');
    var kolom_cek_harga = $("#kolom_cek_harga").val();
    var no_pemeriksaan = $("#no_pemeriksaan").val();

    if (data_toggle == 0) {
              
        $(this).attr("data-toogle", 1);
        $(".pemeriksaan-tanpa-kontras").attr("data-toogle", 1);

        $.post("proses_insert_tbs_radiologi_semua_tanpa_kontras_edit_inap.php",{no_pemeriksaan:no_pemeriksaan,tipe_barang:tipe_barang,no_reg:no_reg,
          dokter:dokter,petugas_radiologi:petugas_radiologi},function(data){
              
        });


    }
    else{
                  
        $(this).attr("data-toogle", 0);
        $(".pemeriksaan-tanpa-kontras").attr("data-toogle", 0);

        $.post("hapus_radiologi_semua_tanpa_kontras_edit_inap.php",{no_pemeriksaan:no_pemeriksaan,no_reg:no_reg},function(data){

        });
    }

    $("form").submit(function(){
      return false;    
    });
});
//AKHIR INSERT SEMUANYA (PILIH SEMUA TANPA KONTRAS)
</script>


<script type="text/javascript">
  $(document).ready(function(){
    $(document).on('click','#btnSubmit',function(e){
    // START DATATABLE AJAX START DATATABLE AJAX START DATATABLE AJAX START DATATABLE AJAX START DATATABLE AJAX START DATATABLE AJAX
      $('#tabel_tbs_radiologi').DataTable().destroy();
            var dataTable = $('#tabel_tbs_radiologi').DataTable( {
            "processing": true,
            "serverSide": true,
            "info":     true,
            "language": { "emptyTable":     "Tidak Ada Data" },
            "ajax":{
              url :"data_tbs_penjualan_radiologi_inap.php", // json datasource
                              "data": function ( d ) {
                                d.no_reg = $("#no_reg").val();
                                d.no_pemeriksaan = $("#no_pemeriksaan").val();
                                // d.custom = $('#myInput').val();
                                // etc
                              },
                              type: "post",  // method  , by default get
              error: function(){  // error handling
                $(".tbody").html("");
                $("#tabel_tbs_radiologi").append('<tbody class="tbody"><tr><th colspan="3"></th></tr></tbody>');
                $("#tableuser_processing").css("display","none");
                
              }
            }   

      });
        
        $("#span_tbs").show();
        $("#myModal").modal('hide');
  });
});
// END DATATABLE AJAX END DATATABLE AJAX END DATATABLE AJAX END DATATABLE AJAX END DATATABLE AJAX END DATATABLE AJAX
</script>


<script type="text/javascript">
$(document).ready(function(){
      
//fungsi hapus data 
$(document).on('click','.btn-hapus-tbs',function(e){
    var no_reg = $("#no_reg").val();
    var kode_pelanggan = $("#no_rm").val();
    var nama_barang = $(this).attr("data-barang");
    var id = $(this).attr("data-id");
    var kode_barang = $(this).attr("data-kode-barang");
    var subtotal = $(this).attr("data-subtotal");
    var no_pemeriksaan = $("#no_pemeriksaan").val();

var pesan_alert = confirm("Apakah Anda Yakin Ingin Menghapus "+nama_barang+""+ "?");
if (pesan_alert == true) {

    $(".tr-id-"+id+"").remove();

    $.post("hapus_tbs_penjualan_radiologi_edit_inap.php",{id:id,no_pemeriksaan:no_pemeriksaan},function(data){

    });

}
else{

}

        $('#tabel_tbs_radiologi').DataTable().destroy();
          var dataTable = $('#tabel_tbs_radiologi').DataTable( {
            "processing": true,
            "serverSide": true,
            "info":     true,
            "language": { "emptyTable":     "Tidak Ada Data" },
            "ajax":{
              url :"data_tbs_penjualan_radiologi_inap.php", // json datasource
                              "data": function ( d ) {
                                d.no_reg = $("#no_reg").val();
                                d.no_pemeriksaan = $("#no_pemeriksaan").val();
                                // d.custom = $('#myInput').val();
                                // etc
                              },
                              type: "post",  // method  , by default get
              error: function(){  // error handling
                $(".tbody").html("");
                $("#tabel_tbs_radiologi").append('<tbody class="tbody"><tr><th colspan="3"></th></tr></tbody>');
                $("#tableuser_processing").css("display","none");
                
              }
            }   

          });
        
        $("#span_tbs").show()

  });
    
    $('form').submit(function(){     
      return false;
    });


});
  
//end fungsi hapus data
</script>


<script type="text/javascript">
//Mulai Simpan Pemeriksaan
$(document).ready(function(){
  $(document).on("click","#simpan_ranap",function(){    
    var no_reg = "<?php echo $no_reg ?>";
    var no_rm = "<?php echo $no_rm ?>";
    var nama = "<?php echo $nama ?>";
    var dokter = "<?php echo $dokter ?>";
    var penjamin = "<?php echo $penjamin ?>";
    var bed = "<?php echo $bed ?>";
    var kamar = "<?php echo $kamar ?>";

     window.location.href="data_pemeriksaan_radiologi_inap.php?no_rm="+no_rm+"&nama="+nama+"&no_reg="+no_reg+"&dokter="+no_reg+"&jenis_penjualan=Rawat Inap&rujukan=Rujuk Rawat Inap&penjamin="+penjamin+"&bed="+bed+"&kamar="+kamar+"";

  });
});
//Akhir Simpan Pemeriksaan
</script>


<!-- footer  -->
<?php include 'footer.php'; ?>
<!-- end footer  -->