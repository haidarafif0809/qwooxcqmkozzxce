<?php include_once 'session_login.php';
// memasukan file session login,  header, navbar, db.php,
include 'header.php';
include 'navbar.php';
include 'db.php';
include 'sanitasi.php';

$session_id = session_id();
$user = $_SESSION['nama'];
$id_user = $_SESSION['id'];

$pilih_akses_tombol = $db->query("SELECT tombol_submit, tombol_bayar, tombol_piutang, tombol_simpan, tombol_batal, hapus_produk FROM otoritas_penjualan_rj WHERE id_otoritas = '$_SESSION[otoritas_id]' ");
$otoritas_tombol = mysqli_fetch_array($pilih_akses_tombol);

?>

<!--Mulai Padding layar-->
<div style="padding-left: 5%; padding-right: 5%">
  <!--Judul-->
    <h3><b>PENJUALAN APS</b></h3>
    <!--Garis-->
    <hr>


<!--Mulai Form and Proses-->
<form role="form" >
  <!--Mulai Row Pertama-->
    <div class="row">

      	<!--Mulai Col SM Awal-->
      	<div class="col-sm-8">

          <div class="col-xs-2">
	        <label> No. RM | Pasien </label><br>
	        <input style="height:15px" type="text" class="form-control"  id="no_rm" name="no_rm" value="" readonly="" >
	        <input style="height:15px" type="hidden" class="form-control"  id="nama_pasien" name="nama_pasien" value="" readonly="" > 
          </div>

          <div class="col-xs-2">
          	<label>No. REG </label>
          	<input style="height:15px" type="text" class="form-control"  id="no_reg" name="no_reg" value="" readonly="">
          </div>

          <div class="col-xs-2">
            <label>Jenis Pasien </label>
            <input style="height:15px" type="text" class="form-control"  id="aps_periksa" name="aps_periksa" value="" readonly="">
          </div>

          <div class="col-xs-3">
          	<label>Kasir</label>
          	<input style="height:15px;" type="text" class="form-control"  id="petugas_kasir" name="petugas_kasir" value="<?php echo $user; ?>" readonly="">  
          </div>


					<!--(MULAI TOMBOL DAN TABLE TBS APS PENJUALAN)-->
						<!--Mulai Col SM Kedua-->
				      	<div class="col-sm-8">

							<button type="button" class="btn btn-warning" id="cari_pasien" data-toggle="modal" data-target="#modal_reg"><i class="fa fa-user"></i> Cari Pasien (F1)</button>

							<button type="button" style="display:none" class="btn btn-default" id="btnRefreshsubtotal"> <i class='fa fa-refresh'></i> Refresh Subtotal</button>

					    <!--Akhir Col SM Kedua-->
					    </div>
						<br><br>

						<!--Mulai Col SM Ketiga-->
						<div class="col-sm-12">
							<span id="span_tbs_aps">            
							  <div class="table-responsive">
							    <table id="table_aps" class="table table-bordered table-sm">
							    <thead> <!-- untuk memberikan nama pada kolom tabel -->
							                              
							      <th style='background-color: #4CAF50; color: white'> Kode </th>
							      <th style='background-color: #4CAF50; color: white'> Nama </th>
							      <th style='background-color: #4CAF50; color: white'> Harga</th>
                    <th style='background-color: #4CAF50; color: white'> Komisi</th>
							      <th style='background-color: #4CAF50; color: white'> Dokter</th>
							      <th style='background-color: #4CAF50; color: white'> Analis</th>
							      <th style='background-color: #4CAF50; color: white'> Tanggal</th>
							      <th style='background-color: #4CAF50; color: white'> Jam</th>

                    <?php if ($otoritas_tombol['hapus_produk'] > 0): ?>
                    <th style='background-color: #4CAF50; color: white'> Hapus </th>                
                    <?php endif ?>
							                          
							    </thead> <!-- tag penutup tabel -->
							    <tbody class="tbody">
							      
							    </tbody>
							    </table>
							  </div>
							</span>  

						<!--Akhir Col SM Ketiga-->
						</div>
					<!--(MULAI TOMBOL DAN TABLE TBS APS PENJUALAN)-->

  		<!--Mulai Col SM Awal-->  
      	</div>


      	<!--Mulai Col 2 SM Awal (untuk nilai Penjualan)-->
      	<div class="col-sm-4">
      		<!--Card Block Data Penjualan-->
        	<div class="card card-block">
		      <!--Awal Row 1 Dari Nilai Penjualan-->
		      <div class="row">

		          <div class="col-xs-6">
		           
		              <label style="font-size:15px"> <b> Subtotal </b></label><br>
		              <input style="height:15px;font-size:15px" type="text" name="subtotal" id="subtotal" class="form-control" placeholder="Total" readonly="" >
		           
		          </div>

		          <div class="col-xs-6">
		              <label>Biaya Admin </label><br>
		              <select class="form-control chosen" id="biaya_admin_select" name="biaya_admin_select" >
		              <option value="0" selected=""> Silahkan Pilih </option>
		                <?php 
		                $get_biaya_admin = $db->query("SELECT persentase, nama FROM biaya_admin");
		                while ( $take_admin = mysqli_fetch_array($get_biaya_admin))
		                {
		                echo "<option value='".$take_admin['persentase']."'>".$take_admin['nama']." ".$take_admin['persentase']."%</option>";
		                }
		                ?>
		              </select>
		          </div>

		      <!--Akhir Row 1 Dari Nilai Penjualan-->
		      </div>


		      <!--Awal Row 2 Dari Nilai Penjualan-->
		      <div class="row">
		      		<div class="col-xs-6">          
	              		<label>Biaya Admin (Rp)</label>
	              		<input type="text" name="biaya_admin_rupiah" style="height:15px;font-size:15px" id="biaya_adm" class="form-control" placeholder="Biaya Admin Rp" autocomplete="off" onkeydown="return numbersonly(this, event);" onkeyup="javascript:tandaPemisahTitik(this);">
	           		</div>

		           	<div class="col-xs-6">
		            	<label>Biaya Admin (%)</label>
		            	<input type="text" name="biaya_admin_persen" style="height:15px;font-size:15px" id="biaya_admin_persen" class="form-control" placeholder="Biaya Admin %" autocomplete="off" >
		           	</div>
		      <!--Akhir Row 2 Dari Nilai Penjualan-->
		      </div>

		      <!--Awal Row 3 Dari Nilai Penjualan-->
		      <div class="row">
		            <?php
		            	$ambil_diskon_tax = $db->query("SELECT diskon_nominal, diskon_persen FROM setting_diskon_tax");
		            	$data_diskon = mysqli_fetch_array($ambil_diskon_tax);
		            ?>

		          <div class="col-xs-6">
		              <label> Diskon ( Rp )</label><br>
		              <input type="text" name="potongan" style="height:15px;font-size:15px" id="diskon_rupiah" value="<?php echo $data_diskon['diskon_nominal']; ?>" class="form-control" placeholder="Diskon Rp" autocomplete="off"  onkeydown="return numbersonly(this, event);" onkeyup="javascript:tandaPemisahTitik(this);">
		          </div>


		          <div class="col-xs-6">
		 
		          		<label> Diskon ( % )</label><br>
		          		<input type="text" name="potongan_persen" style="height:15px;font-size:15px" id="diskon_persen" value="<?php echo $data_diskon['diskon_persen']; ?>%" class="form-control" placeholder="Diskon %" autocomplete="off" onkeydown="return numbersonly(this, event);" >
		          </div>

		      <!--Akhir Row 3 Dari Nilai Penjualan-->
		      </div>


		      <!--Awal Row 4 Dari Nilai Penjualan-->
		      <div class="row">
		      		<div class="col-xs-6">
		      			<label> Tanggal Jatuh Tempo</label>
		      			<input type="text" name="tanggal_jt" id="tanggal_jt"  value="" style="height:15px;font-size:15px" placeholder="Tanggal JT" class="form-control" >
		      		</div>


		      		<div class="col-xs-6">
            			<label style="font-size:15px"> <b> Cara Bayar (F4) </b> </label><br>
                      		<select type="text" name="cara_bayar" id="cara_bayar" class="form-control chosen"  style="font-size: 15px" >
                      		<option value=""> Silahkan Pilih </option>
                         	<?php
                         		$sett_akun = $db->query("SELECT sa.kas, da.nama_daftar_akun FROM setting_akun sa INNER JOIN daftar_akun da ON sa.kas = da.kode_daftar_akun");
                         		$data_sett = mysqli_fetch_array($sett_akun);
                         		echo "<option selected value='".$data_sett['kas']."'>".$data_sett['nama_daftar_akun'] ."</option>";

                         		$query = $db->query("SELECT nama_daftar_akun, kode_daftar_akun FROM daftar_akun WHERE tipe_akun = 'Kas & Bank'");
                         		while($data = mysqli_fetch_array($query)){
                         			echo "<option value='".$data['kode_daftar_akun']."'>".$data['nama_daftar_akun'] ."</option>";
                         			}
                         		?>
                         	</select>
            		</div>
		      <!--Akhir Row 4 Dari Nilai Penjualan-->
		      </div>

		      <!--Awal Row 5 Dari Nilai Penjualan-->
		      <div class="row">
		      		  <div class="col-xs-6">
		      		  	<label style="font-size:15px"> <b> Total Akhir </b></label><br>
		      		  	<b><input type="text" name="total" id="total" class="form-control" style="height: 25px; width:90%; font-size:20px;" placeholder="Total" readonly="" ></b>
		      		  </div>

		      		  <div class="col-xs-6">
		      		  	<label style="font-size:15px">  <b> Pembayaran (F7)</b> </label><br>
		      		  	<b><input type="text" name="pembayaran" id="pembayaran_penjualan" style="height: 20px; width:90%; font-size:20px;" autocomplete="off" class="form-control"   style="font-size: 20px"  onkeydown="return numbersonly(this, event);" onkeyup="javascript:tandaPemisahTitik(this);"></b>
		      		  </div>

		      <!--Akhir Row 5 Dari Nilai Penjualan-->
		      </div>


		      <!--Awal Row 6 Dari Nilai Penjualan-->
		      <div class="row">
		      	<div class="col-xs-6">
		      		<label> Kembalian </label><br>
		      		<b><input type="text" name="sisa_pembayaran"  id="sisa_pembayaran_penjualan"  style="height:15px;font-size:15px" class="form-control"  readonly=""></b>
            	</div>
            	<div class="col-xs-6">
            		<label> Kredit </label><br>
            		<b><input type="text" name="kredit" id="kredit" class="form-control"  style="height:15px;font-size:15px"  readonly="" ></b>
            	</div>
		      <!--Akhir Row 6 Dari Nilai Penjualan-->
		      </div>

		      <!--Awal Row 7 Dari Nilai Penjualan-->
		      <div class="row">
		      	<div class="col-xs-12">
		      	 	<label> Keterangan </label><br>
           			<textarea style="height:40px;font-size:15px" type="text" name="keterangan" id="keterangan" class="form-control"> 
           			</textarea>
           		</div>
		      <!--Akhir Row 7 Dari Nilai Penjualan-->
		      </div>

      		<!--Akhir Card Block Data Penjualan-->
        	</div>

      	<!--ALERT BERHASIL-->
      	<div class="alert alert-success" id="alert_berhasil" style="display:none">
          <strong>Sukses!</strong> Pembayaran Berhasil !!
        </div>

	<!-- BUTTON -->
	<?php if ($otoritas_tombol['tombol_bayar'] > 0):?>              
        <button style="display:none" type="submit" id="penjualan" class="btn btn-info" style="font-size:15px;">Bayar (F8)</button>
        
        <button type="submit" id="transaksi_baru" style="display: none" class="btn btn-info" style="font-size:15px;"> Transaksi Baru (Ctrl + M)</button>

        <a class="btn btn-info" href="pasien_sudah_masuk.php" id="transaksi_baru" style="display: none">  Transaksi Baru (Ctrl + M)</a>
   	<?php endif;?>

    <?php if ($otoritas_tombol['tombol_bayar'] > 0):?>
    	<button style="display:none" type="submit" id="cetak_langsung" target="blank" class="btn btn-success" style="font-size:15px"> Bayar / Cetak (Ctrl + K) </button>
    <?php endif;?>

   	<?php if ($otoritas_tombol['tombol_piutang'] > 0):?>  
        <button style="display:none" type="submit" id="piutang" class="btn btn-warning" style="font-size:15px">Piutang (F9)</button>
    <?php endif;?>

    	<a href='cetak_penjualan_piutang_aps.php' id="cetak_piutang" style="display: none;" class="btn btn-success" target="blank">Cetak Piutang  </a>

    	<a href='cetak_penjualan_tunai_aps.php' id="cetak_tunai" style="display: none;" class="btn btn-primary" target="blank"> Cetak Tunai  </a>

        <a href='cetak_penjualan_tunai_besar_aps.php' id="cetak_tunai_besar" style="display: none;" class="btn btn-warning" target="blank"> Cetak Tunai  Besar </a>

    <?php if ($otoritas_tombol['tombol_batal'] > 0):?>
        <button style="display:none" type="submit" id="batal_penjualan" class="btn btn-danger" style="font-size:15px">  Batal (Ctrl + B)</button>
    <?php endif;?>
        
	<!-- BUTTON -->

      	<!--Mulai Col 2 SM Awal (untuk nilai Penjualan)-->
      	</div>
    <!--Akhir Row Pertama-->
    </div>
      	
<!--Akhir From-->
</form>


<!-- Modal cari registrasi pasien-->
<div id="modal_reg" class="modal fade" role="dialog">
  <div class="modal-dialog">

    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
               
        <center><h4 class="modal-title"><b>Cari Pasien</b></h4></center>
      </div>
      <div class="modal-body">

            <center>
            <table id="tabel_cari_pasien" class="table table-bordered table-sm">
                  <thead> <!-- untuk memberikan nama pada kolom tabel -->
                  
                      <th style="width:50">No. REG</th>
                      <th style="width:70">No. RM</th>
                      <th style="width:150">Nama Pasien</th>
                      <th>Jenis Pasien</th>
                      <th>Tanggal</th>
                  
                  </thead> <!-- tag penutup tabel -->
            </table>
            </center>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-warning" id="btnRefreshPasien"> <i class='fa fa-refresh'></i> Refresh Pasien</button>
        <button type="button" accesskey="e" class="btn btn-danger" data-dismiss="modal"><i class='fa fa-close'></i> Close</button>
      </div>
    </div>

  </div>
</div>

<!-- Modal cari registrasi pasien-->


<!--End Padding-->
</div>

<!-- js untuk tombol shortcut -->
<script src="shortcut.js"></script>
<!-- js untuk tombol shortcut -->

<!--MULAI REFRESH SUBTOTAL -->
<script type="text/javascript">
$(document).ready(function(){
	$(document).on('click','#btnRefreshsubtotal',function(e){
		var no_reg = $("#no_reg").val();
		if (no_reg == '') {
			alert("Anda belum memilih pasien!");
		}
		else{

			$.post("refresh_subtotal_aps.php",{no_reg:no_reg},function(data){
				if (data == '') {
					data = 0;
				}

            var biaya_admin = $("#biaya_admin_select").val();
            var hitung_biaya = parseInt(biaya_admin,10) * parseInt(data,10) / 100;

            $("#biaya_adm").val(tandaPemisahTitik(Math.round(hitung_biaya)));
            var diskon = bersihPemisah(bersihPemisah(bersihPemisah(bersihPemisah($("#diskon_rupiah").val()))));
            	if(diskon == ''){
              		diskon = 0
              	}
           	var hasilnya = parseInt(data,10) + parseInt(Math.round(hitung_biaya),10) - parseInt(diskon,10);

            $("#total").val(tandaPemisahTitik(hasilnya));
            $("#subtotal").val(tandaPemisahTitik(data));

      		});
    	}
  	});
});
</script>
<!--AKHIR REFRESH SUBTOTAL -->

 <script type="text/javascript">
   $(document).on('click', '.pilih-reg', function (e) {
            document.getElementById("no_reg").value = $(this).attr('no_reg');
            document.getElementById("no_rm").value = $(this).attr('no_rm');
            document.getElementById("nama_pasien").value = $(this).attr('nama_pasien');
            document.getElementById("aps_periksa").value = $(this).attr('aps_periksa');

            $('#modal_reg').modal('hide'); 

  // DATATABE AJAX TABLE_APS
      $('#table_aps').DataTable().destroy();
            var dataTable = $('#table_aps').DataTable( {
            "processing": true,
            "serverSide": true,
            "info":     true,
            "language": { "emptyTable":     "My Custom Message On Empty Table" },
            "ajax":{
              url :"datatable_tbs_aps.php", // json datasource
               "data": function ( d ) {
                  d.no_reg = $("#no_reg").val();
                  d.aps_periksa = $("#aps_periksa").val();
                  // d.custom = $('#myInput').val();
                  // etc
              },
                  type: "post",  // method  , by default get
              error: function(){  // error handling
                $(".tbody").html("");
                $("#table_aps").append('<tbody class="tbody"><tr><th colspan="3"></th></tr></tbody>');
                $("#tableuser_processing").css("display","none");
                
              }
            }   

      });





$("#batal_penjualan").show();
$("#btnRefreshsubtotal").show();
$("#span_tbs_aps").show('fast');
 // DATATABE AJAX TABLE_APS

//START SUBTOTAL DAN TOTAL
var no_reg = $("#no_reg").val();
var aps_periksa = $("#aps_periksa").val();
var diskon_persen = bersihPemisah(bersihPemisah(bersihPemisah(bersihPemisah($("#diskon_persen").val()))));
var diskon_rupiah = bersihPemisah(bersihPemisah(bersihPemisah(bersihPemisah($("#diskon_rupiah").val()))));

$.post("cek_subtotal_aps.php",{no_reg:no_reg,aps_periksa:aps_periksa},function(data){
    data = data.replace(/\s+/g, '');
    if (data == ""){
    	data = 0;
    }

    var sum = parseInt(data,10);
    //Input Subtotal
    $("#subtotal").val(tandaPemisahTitik(sum))

 	if (diskon_persen == '0%'){

 		var potongan = diskon_rupiah;
 		var hasil_potongan = parseInt(potongan,10) / parseInt(data,10) * 100;

        if (data == ""){
            data = 0;
            $("#diskon_persen").val(Math.round('0'));
        }
        else{
            $("#diskon_persen").val(Math.round(hasil_potongan));
        }
	    
	    var total_akhir = parseInt(data,10) - parseInt(diskon_rupiah,10);
	    //Input Total dari subtotal - diskon rupiah
	    $("#total").val(tandaPemisahTitik(total_akhir))

    }
    else if(diskon_rupiah == 0){
        
        if (data == ""){
            data = 0;
        }
        var potongan = diskon_persen;
        var pos = potongan.search("%");
        var potongan_persen = bersihPemisah(bersihPemisah(bersihPemisah(bersihPemisah(potongan))));
        potongan_persen = potongan_persen.replace("%","");
        hasil_potongan = data * potongan_persen / 100;
        //Input diskon rupiahnya jika diskon rupiah 0
        $("#diskon_rupiah").val(Math.round(hasil_potongan));


      	var total_akhir = parseInt(data,10) - parseInt(hasil_potongan,10);
      	$("#total").val(tandaPemisahTitik(total_akhir))

    }
});
//CEK SUBTOTAL + TOTAL

	 	//START Cek Hasil Laboratorium
        var pasien = $("#nama_pasien").val();
        var no_reg = $("#no_reg").val();
        var aps_periksa = $("#aps_periksa").val();

        if(aps_periksa == 'Laboratorium'){
        //Start Setting Laboratorium
        $.post("setting_laboratorium_aps.php",{no_reg:no_reg},function(data){
	        if(data == 1){
	                
	        $("#batal_penjualan").show(); 
	        alert("Pasien atas nama ("+pasien+") Hasil laboratorium belum di isi!");

	                $("#span_tbs_aps").hide();
	                $("#biaya_adm").val('');
	                $("#diskon_rupiah").val('');
	                $("#subtotal").val('');
	                $("#total").val('');
	                $("#no_reg").val('');
	                $("#no_rm").val('');
	                $("#penjualan").hide();
	                $("#simpan_sementara").hide();
	                $("#cetak_langsung").hide();
	                $("#piutang").hide();
	        }
            else
            {
                 //$("#penjualan").show();
                 //$("#batal_penjualan").show(); 
                 //$("#cetak_langsung").show();
                 //$("#piutang").show();
            }
        });
        //Akhir Setting Laboratorium

    	}
       /* else{
        //Start Hasil Radiologi
        $.post("cek_status_aps_hasil_radiologi.php",{no_reg:no_reg},function(data){
	        if(data == 1){
	                
	        $("#batal_penjualan").show(); 
	        alert("Pasien atas nama ("+pasien+") Hasil Radiologi belum ada!");

	                $("#span_tbs_aps").hide();
	                $("#biaya_adm").val('');
	                $("#diskon_rupiah").val('');
	                $("#subtotal").val('');
	                $("#total").val('');
	                $("#no_reg").val('');
	                $("#no_rm").val('');
	                $("#penjualan").hide();
	                $("#simpan_sementara").hide();
	                $("#cetak_langsung").hide();
	                $("#piutang").hide();
	        }
            else
            {
                 //$("#penjualan").show();
                 //$("#batal_penjualan").show(); 
                 //$("#cetak_langsung").show();
                 //$("#piutang").show();
            }
        });
        //Akhir Hasil Radiologi
        }*/

      	//End Cek Hasil Laboratorium

        });

</script>

<!-- DATATABLE CARI PASIEN APS -->
<script type="text/javascript" language="javascript" >
   $(document).ready(function() {
        var dataTable = $('#tabel_cari_pasien').DataTable( {
          "processing": true,
          "serverSide": true,
          "ajax":{
            url :"modal_pasien_penjualan_aps.php", // json datasource
            type: "post",  // method  , by default get
            error: function(){  // error handling
              $(".employee-grid-error").html("");
              $("#tabel_cari_pasien").append('<tbody class="employee-grid-error"><tr><th colspan="3">Data Tidak Ditemukan.. !!</th></tr></tbody>');
              $("#employee-grid_processing").css("display","none");
              
            }
          },

          "fnCreatedRow": function( nRow, aData, iDataIndex ) {

              $(nRow).attr('class', "pilih-reg");
              $(nRow).attr('no_reg', aData[0]);
              $(nRow).attr('no_rm', aData[1]+" | "+aData[2]+"");
              $(nRow).attr('nama_pasien', aData[2]);
              //$(nRow).attr('penjamin', aData[5]);
              $(nRow).attr('aps_periksa', aData[3]);
              $(nRow).attr('dokter', aData[7]);
              $(nRow).attr('level_harga', aData[8]);


          }

        });    
     
  });
 
 </script>
<!-- / DATATABLE CARI PASIEN APS -->

<!-- / DATATABLE DRAW -->
<script type="text/javascript">
    $(document).on('click','#btnRefreshPasien',function(e){

       var table_pasien = $('#tabel_cari_pasien').DataTable();
       table_pasien.draw();

    }); 
</script>
<!-- / DATATABLE DRAW -->


<!-- PENJUALAN BAYAR -->
<script type="text/javascript">
	$(document).on('click', '#penjualan', function(){
      var id_user = '<?php echo $id_user; ?>';
      var no_reg = $("#no_reg").val();
      var no_rm = $("#no_rm").val();
      var no_rm = no_rm.substr(0, no_rm.indexOf(' |'));
      var biaya_adm = bersihPemisah(bersihPemisah(bersihPemisah(bersihPemisah($("#biaya_adm").val()))));
      if(biaya_adm == ''){
      	biaya_adm = 0;
      }
      var diskon_rupiah = bersihPemisah(bersihPemisah(bersihPemisah(bersihPemisah($("#diskon_rupiah").val()))));
      if(diskon_rupiah == ''){
      	diskon_rupiah = 0;
      }
      var cara_bayar = $("#cara_bayar").val();
      var subtotal = bersihPemisah(bersihPemisah(bersihPemisah(bersihPemisah( $("#subtotal").val()))));
      var total = bersihPemisah(bersihPemisah(bersihPemisah(bersihPemisah( $("#total").val()))));
      var pembayaran_penjualan = bersihPemisah(bersihPemisah(bersihPemisah(bersihPemisah( $("#pembayaran_penjualan").val()))));
      var sisa_pembayaran = bersihPemisah(bersihPemisah(bersihPemisah(bersihPemisah( $("#sisa_pembayaran_penjualan").val() ))));
      var keterangan = $("#keterangan").val();
      var tanggal_jt = $("#tanggal_jt").val();
      var nama_pasien = $("#nama_pasien").val();
      var petugas_kasir = $("#petugas_kasir").val();
      var aps_periksa = $("#aps_periksa").val();

      if (no_reg == '') {
		    alert ('Maaf Anda Belum Memilih Pasien, Silakan Pilih Pasien.');
		    $("#modal_reg").modal('show');
      }
      else if (no_rm == '') {
		    alert ('Maaf Anda Belum Memilih Pasien, Silakan Pilih Pasien.');
		    $("#modal_reg").modal('show');
      }
      else{

      	var pesan_alert = confirm("Anda Yakin Melakukan Penjualan Lunas? ");
      	if (pesan_alert == true) {

      		$.post("cek_subtotal_penjualan_aps.php",{total:total,no_reg:no_reg,diskon_rupiah:diskon_rupiah,biaya_adm:biaya_adm},function(data) {

//LOGIKA CEK SUBTOTAL ANTARA TBS DAN KOLOM SUBTOTAL
      			if (data == 1) {

	      			$.post("proses_bayar_jual_aps.php",{aps_periksa:aps_periksa,id_user:id_user,
                no_reg:no_reg,no_rm:no_rm,
	      				biaya_adm:biaya_adm,diskon_rupiah:diskon_rupiah,cara_bayar:cara_bayar,
	      				subtotal:subtotal,total:total,pembayaran_penjualan:pembayaran_penjualan,
	      				sisa_pembayaran:sisa_pembayaran,tanggal_jt:tanggal_jt,keterangan:keterangan,
	      				petugas_kasir:petugas_kasir,nama_pasien:nama_pasien},function(info){
	      				// Start Cetak
	      				$("#cetak_tunai").attr('href', 'cetak_penjualan_aps_tunai.php?no_reg='+no_reg+'&sisa='+sisa_pembayaran+'&tunai='+pembayaran_penjualan+'&total='+total+'&biaya_admin='+biaya_adm+'&diskon='+diskon_rupiah+'&no_rm='+no_rm+'&nama_pasien='+nama_pasien+'');

	      				$("#cetak_tunai_besar").attr('href', 'cetak_besar_penjualan_aps_tunai.php?no_reg='+no_reg+'&sisa='+sisa_pembayaran+'&tunai='+pembayaran_penjualan+'&total='+total+'&biaya_admin='+biaya_adm+'&diskon='+diskon_rupiah+'&no_rm='+no_rm+'&nama_pasien='+nama_pasien+'&keterangan='+keterangan+'&cara_bayar='+cara_bayar+'');

	      				$("#cetak_tunai").show();
	      				$("#cetak_tunai_besar").show();
	      				// Akhir Cetak

	      				$("#penjualan").hide();
						$("#simpan_sementara").hide();
						$("#cetak_langsung").hide();
						$("#batal_penjualan").hide(); 
						$("#piutang").hide();
						$("#span_tbs_aps").hide();
						$("#transaksi_baru").show();
						$("#alert_berhasil").show();

	      			});

	      		}
	      		else{
	      			alert("Maaf Subtotal Penjualan Tidak Sesuai, Silakan Tunggu Sebentar! ");       
                	window.location.href="form_penjualan_aps.php";
	      		}
// END LOGIKA CEK SUBTOTAL ANTARA TBS DAN KOLOM SUBTOTAL

      		});
      	}
      	else{

      	}

      }
      	 $("form").submit(function(){
      	 	return false;
      	 });

	});

</script>
<!-- / PENJUALAN BAYAR-->

<!-- PENJUALAN PIUTANG -->
<script type="text/javascript">
	$(document).on('click', '#piutang', function(){
      var id_user = '<?php echo $id_user; ?>';
      var no_reg = $("#no_reg").val();
      var no_rm = $("#no_rm").val();
      var no_rm = no_rm.substr(0, no_rm.indexOf(' |'));
      var biaya_adm = bersihPemisah(bersihPemisah(bersihPemisah(bersihPemisah($("#biaya_adm").val()))));
      if(biaya_adm == ''){
      	biaya_adm = 0;
      }
      var diskon_rupiah = bersihPemisah(bersihPemisah(bersihPemisah(bersihPemisah($("#diskon_rupiah").val()))));
      if(diskon_rupiah == ''){
      	diskon_rupiah = 0;
      }
      var cara_bayar = $("#cara_bayar").val();
      var subtotal = bersihPemisah(bersihPemisah(bersihPemisah(bersihPemisah( $("#subtotal").val()))));
      var total = bersihPemisah(bersihPemisah(bersihPemisah(bersihPemisah( $("#total").val()))));
      var pembayaran_penjualan = bersihPemisah(bersihPemisah(bersihPemisah(bersihPemisah( $("#pembayaran_penjualan").val()))));
      var sisa_pembayaran = bersihPemisah(bersihPemisah(bersihPemisah(bersihPemisah( $("#sisa_pembayaran_penjualan").val() ))));
      var keterangan = $("#keterangan").val();
      var tanggal_jt = $("#tanggal_jt").val();
      var nama_pasien = $("#nama_pasien").val();
      var petugas_kasir = $("#petugas_kasir").val();
      var aps_periksa = $("#aps_periksa").val();

      if (no_reg == '') {
    		alert ('Maaf Anda Belum Memilih Pasien, Silakan Pilih Pasien.');
    		$("#modal_reg").modal('show');
      }
      else if (no_rm == '') {
  		  alert ('Maaf Anda Belum Memilih Pasien, Silakan Pilih Pasien.');
  		  $("#modal_reg").modal('show');
      }
      else{

      	var pesan_alert = confirm("Anda Yakin Melakukan Transaksi Piutang ? ");
      	if (pesan_alert == true) {

      		$.post("cek_subtotal_penjualan_aps.php",{total:total,no_reg:no_reg,diskon_rupiah:diskon_rupiah,biaya_adm:biaya_adm},function(data) {

//LOGIKA CEK SUBTOTAL ANTARA TBS DAN KOLOM SUBTOTAL
      			if (data == 1) {

	      			$.post("proses_bayar_jual_aps.php",{aps_periksa:aps_periksa,id_user:id_user,
                no_reg:no_reg,no_rm:no_rm,
	      				biaya_adm:biaya_adm,diskon_rupiah:diskon_rupiah,cara_bayar:cara_bayar,
	      				subtotal:subtotal,total:total,pembayaran_penjualan:pembayaran_penjualan,
	      				sisa_pembayaran:sisa_pembayaran,tanggal_jt:tanggal_jt,keterangan:keterangan,
	      				petugas_kasir:petugas_kasir,nama_pasien:nama_pasien},function(info){

                		var no_faktur = info;
                		$("#cetak_piutang").attr('href', 'cetak_penjualan_aps_piutang.php?no_faktur='+no_faktur+'');
                		$("#cetak_piutang").show();

	      				$("#penjualan").hide();
						$("#simpan_sementara").hide();
						$("#cetak_langsung").hide();
						$("#batal_penjualan").hide(); 
						$("#piutang").hide();
						$("#span_tbs_aps").hide();
						$("#transaksi_baru").show();
						$("#alert_berhasil").show();

	      			});

	      		}
	      		else{
	      			alert("Maaf Subtotal Penjualan Tidak Sesuai, Silakan Tunggu Sebentar! ");       
                	window.location.href="form_penjualan_aps.php";
	      		}
// END LOGIKA CEK SUBTOTAL ANTARA TBS DAN KOLOM SUBTOTAL

      		});
      	}
      	else{

      	}

      }
      	 $("form").submit(function(){
      	 	return false;
      	 });

	});

</script>
<!-- / PENJUALAN PIUTANG-->


<!-- PENJUALAN BAYAR + CETAK -->
<script type="text/javascript">
	$(document).on('click', '#cetak_langsung', function(){
      var id_user = '<?php echo $id_user; ?>';
      var no_reg = $("#no_reg").val();
      var no_rm = $("#no_rm").val();
      var no_rm = no_rm.substr(0, no_rm.indexOf(' |'));
      var biaya_adm = bersihPemisah(bersihPemisah(bersihPemisah(bersihPemisah($("#biaya_adm").val()))));
      if(biaya_adm == ''){
      	biaya_adm = 0;
      }
      var diskon_rupiah = bersihPemisah(bersihPemisah(bersihPemisah(bersihPemisah($("#diskon_rupiah").val()))));
      if(diskon_rupiah == ''){
      	diskon_rupiah = 0;
      }
      var cara_bayar = $("#cara_bayar").val();
      var subtotal = bersihPemisah(bersihPemisah(bersihPemisah(bersihPemisah( $("#subtotal").val()))));
      var total = bersihPemisah(bersihPemisah(bersihPemisah(bersihPemisah( $("#total").val()))));
      var pembayaran_penjualan = bersihPemisah(bersihPemisah(bersihPemisah(bersihPemisah( $("#pembayaran_penjualan").val()))));
      var sisa_pembayaran = bersihPemisah(bersihPemisah(bersihPemisah(bersihPemisah( $("#sisa_pembayaran_penjualan").val() ))));
      var keterangan = $("#keterangan").val();
      var tanggal_jt = $("#tanggal_jt").val();
      var nama_pasien = $("#nama_pasien").val();
      var petugas_kasir = $("#petugas_kasir").val();

      if (no_reg == '') {
		alert ('Maaf Anda Belum Memilih Pasien, Silakan Pilih Pasien.');
		$("#modal_reg").modal('show');
      }
      else if (no_rm == '') {
		alert ('Maaf Anda Belum Memilih Pasien, Silakan Pilih Pasien.');
		$("#modal_reg").modal('show');
      }
      else{

      	var pesan_alert = confirm("Anda Yakin Melakukan Transaksi Piutang ? ");
      	if (pesan_alert == true) {

      		$.post("cek_subtotal_penjualan_aps.php",{total:total,no_reg:no_reg,diskon_rupiah:diskon_rupiah,biaya_adm:biaya_adm},function(data) {

//LOGIKA CEK SUBTOTAL ANTARA TBS DAN KOLOM SUBTOTAL
      			if (data == 1) {

	      			$.post("proses_bayar_jual_aps.php",{id_user:id_user,no_reg:no_reg,no_rm:no_rm,
	      				biaya_adm:biaya_adm,diskon_rupiah:diskon_rupiah,cara_bayar:cara_bayar,
	      				subtotal:subtotal,total:total,pembayaran_penjualan:pembayaran_penjualan,
	      				sisa_pembayaran:sisa_pembayaran,tanggal_jt:tanggal_jt,keterangan:keterangan,
	      				petugas_kasir:petugas_kasir,nama_pasien:nama_pasien},function(info){

	      				// Start Cetak
	      				$("#cetak_tunai").attr('href', 'cetak_penjualan_aps_tunai.php?no_reg='+no_reg+'&sisa='+sisa_pembayaran+'&tunai='+pembayaran_penjualan+'&total='+total+'&biaya_admin='+biaya_adm+'&diskon='+diskon_rupiah+'&no_rm='+no_rm+'&nama_pasien='+nama_pasien+'');

	      				$("#cetak_tunai_besar").attr('href', 'cetak_besar_penjualan_aps_tunai.php?no_reg='+no_reg+'&sisa='+sisa_pembayaran+'&tunai='+pembayaran_penjualan+'&total='+total+'&biaya_admin='+biaya_adm+'&diskon='+diskon_rupiah+'&no_rm='+no_rm+'&nama_pasien='+nama_pasien+'&keterangan='+keterangan+'&cara_bayar='+cara_bayar+'');
	      				
	      				var win = window.open('cetak_penjualan_aps_tunai.php?no_reg='+no_reg+'&sisa='+sisa_pembayaran+'&tunai='+pembayaran_penjualan+'&total='+total+'&biaya_admin='+biaya_adm+'&diskon='+diskon_rupiah+'&no_rm='+no_rm+'&nama_pasien='+nama_pasien+'');
	      					if (win) {    
					          win.focus(); 
					        } 
					      	else {    
					          alert('Mohon Izinkan PopUps Pada Website Ini !'); 
					        }

	      				$("#cetak_tunai").show();
	      				$("#cetak_tunai_besar").show();
	      				// Akhir Cetak

	      				$("#penjualan").hide();
						$("#simpan_sementara").hide();
						$("#cetak_langsung").hide();
						$("#batal_penjualan").hide(); 
						$("#piutang").hide();
						$("#span_tbs_aps").hide();
						$("#transaksi_baru").show();
						$("#alert_berhasil").show();

	      			});

	      		}
	      		else{
	      			alert("Maaf Subtotal Penjualan Tidak Sesuai, Silakan Tunggu Sebentar! ");       
                	window.location.href="form_penjualan_aps.php";
	      		}
// END LOGIKA CEK SUBTOTAL ANTARA TBS DAN KOLOM SUBTOTAL

      		});
      	}
      	else{

      	}

      }
      	 $("form").submit(function(){
      	 	return false;
      	 });

	});

</script><!-- / PENJUALAN BAYAR + CETAK -->

<!--Mulai Script Proses Hapus TBS -->
<script type="text/javascript">
  $(document).on('click','.btn-hapus-tbs',function(e){

    var id = $(this).attr("data-id");
    var kode_jasa = $(this).attr("data-kode");
    var nama_jasa = $(this).attr("data-barang");
    var no_reg = $("#no_reg").val();

    var pesan_alert = confirm("Apakah Anda Yakin Ingin Menghapus "+nama_jasa+""+ "?");

    if (pesan_alert == true) {
      $(".tr-id-"+id+"").remove();

        $.post("hapus_tbs_aps_penjualan.php",{kode_jasa:kode_jasa,no_reg:no_reg,id:id},function(data){

			    // DATATABE AJAX TABLE_APS
			    $('#table_aps').DataTable().destroy();
			            var dataTable = $('#table_aps').DataTable( {
			            "processing": true,
			            "serverSide": true,
			            "info":     false,
			            "language": { "emptyTable":     "My Custom Message On Empty Table" },
			            "ajax":{
			              url :"datatable_tbs_aps.php", // json datasource
			               "data": function ( d ) {
			                  d.no_reg = $("#no_reg").val();
                        d.aps_periksa = $("#aps_periksa").val();
			                  // d.custom = $('#myInput').val();
			                  // etc
			              },
			                  type: "post",  // method  , by default get
			              error: function(){  // error handling
			                $(".tbody").html("");
			                $("#table_aps").append('<tbody class="tbody"><tr><th colspan="3"></th></tr></tbody>');
			                $("#tableuser_processing").css("display","none");
			                
			              }
			            }   

			    });// DATATABE AJAX TABLE_APS

			    $("#span_tbs_aps").show('fast');

        });

    }
    else{

    }
    $('form').submit(function(){       
      return false;
    });

  });
</script>
<!--Mulai Script Proses Hapus TBS-->


<script type="text/javascript">
$(document).ready(function(){
  //Mulai Hitung Biaya Admin Select
  $("#biaya_admin_select").change(function(){
  
	var biaya_admin = $("#biaya_admin_select").val();  
	var diskon = bersihPemisah(bersihPemisah(bersihPemisah(bersihPemisah($("#diskon_rupiah").val()))));
	var subtotal = bersihPemisah(bersihPemisah(bersihPemisah(bersihPemisah($("#subtotal").val()))));
	var total = bersihPemisah(bersihPemisah(bersihPemisah(bersihPemisah($("#total").val()))));
    
    if(diskon == ''){
      diskon = 0
    }

    var biaya_admin_persen = biaya_admin;

  	if (biaya_admin == 0) {

      var hasilnya = parseInt(subtotal,10) - parseInt(diskon,10);
      $("#total").val(tandaPemisahTitik(hasilnya));
      $("#biaya_adm").val(0);
      $("#biaya_admin_persen").val(biaya_admin_persen);

  	}
  	else if (biaya_admin > 0) {

  		var hitung_biaya = parseInt(subtotal,10) * parseInt(biaya_admin_persen,10) / 100;
  		if (subtotal == "" || subtotal == 0) {
  			hitung_biaya = 0;
  		}

  		$("#biaya_adm").val(tandaPemisahTitik(Math.round(hitung_biaya)));
  		var biaya_admin = bersihPemisah(bersihPemisah(bersihPemisah(bersihPemisah($("#biaya_adm").val()))));
  		var hasilnya = parseInt(subtotal,10) + parseInt(biaya_admin,10) - parseInt(diskon,10);

        if (subtotal == "" || subtotal == 0) {
        	hasilnya = 0;
        }

      $("#total").val(tandaPemisahTitik(hasilnya));
      $("#biaya_admin_persen").val(biaya_admin_persen);
      
  	}
      
  });
});
//Akhir Biaya Admin Select
</script>


<script type="text/javascript">
$(document).ready(function(){
  //START KEYUP BIAYA ADMIN RUPIAH

    $("#biaya_adm").keyup(function(){
      var biaya_adm = bersihPemisah(bersihPemisah(bersihPemisah(bersihPemisah($("#biaya_adm").val()))));
      if (biaya_adm == '') {
        biaya_adm = 0;
      }
      var subtotal = bersihPemisah(bersihPemisah(bersihPemisah(bersihPemisah($("#subtotal").val()))));
      if (subtotal == '') {
        subtotal = 0;
      }
      var potongan = bersihPemisah(bersihPemisah(bersihPemisah(bersihPemisah($("#diskon_rupiah").val()))));
      if (potongan == '') {
        potongan = 0;
      }
      var pembayaran = bersihPemisah(bersihPemisah(bersihPemisah(bersihPemisah($("#pembayaran_penjualan").val()))));
      if (pembayaran == '') {
        pembayaran = 0;
      }  
      /*    
      var tax = bersihPemisah(bersihPemisah(bersihPemisah(bersihPemisah($("#tax").val()))));
      if (tax == '') {
        tax = 0;
      }*/

      var t_total = parseInt(subtotal,10) - parseInt(potongan,10);
      var biaya_admin_persen = parseInt(biaya_adm,10) / parseInt(subtotal,10) * 100;
      /*
      var t_tax = parseInt(t_total,10) * parseInt(tax,10) / 100;
      var total_akhir1 = parseInt(t_total,10) + Math.round(parseInt(t_tax,10));
      */

      var total_akhir = parseInt(t_total,10) + parseInt(Math.round(biaya_adm,10));


      $("#total").val(tandaPemisahTitik(total_akhir));
      $("#biaya_admin_persen").val(Math.round(biaya_admin_persen));

      if (biaya_admin_persen > 100) {
            

            var total_akhir = parseInt(subtotal,10) - parseInt(potongan,10);
            alert ("Biaya Amin %, Tidak Boleh Lebih Dari 100%");
            $("#biaya_admin_persen").val('');
            $("#biaya_admin_select").val('0');            
            $("#biaya_admin_select").trigger('chosen:updated');
            $("#biaya_adm").val('');
            $("#biaya_adm").val('');
            $("#total").val(tandaPemisahTitik(total_akhir));
          }
          
        else
          {
          }

    });

  //END KEYUP BIAYA ADMIN RUPIAH

  //START KEYUP BIAYA ADMIN PERSEN

    $("#biaya_admin_persen").keyup(function(){
      var biaya_admin_persen = bersihPemisah(bersihPemisah(bersihPemisah(bersihPemisah($("#biaya_admin_persen").val()))));
      if (biaya_admin_persen == '') {
        biaya_admin_persen = 0;
      }
      var subtotal = bersihPemisah(bersihPemisah(bersihPemisah(bersihPemisah($("#subtotal").val()))));
      if (subtotal == '') {
        subtotal = 0;
      }
      var potongan = bersihPemisah(bersihPemisah(bersihPemisah(bersihPemisah($("#diskon_rupiah").val()))));
      if (potongan == '') {
        potongan = 0;
      }
      var pembayaran = bersihPemisah(bersihPemisah(bersihPemisah(bersihPemisah($("#pembayaran_penjualan").val()))));
      if (pembayaran == '') {
        pembayaran = 0;
      }  


      var t_total = parseInt(subtotal,10) - parseInt(potongan,10);
      var biaya_admin_rupiah = parseInt(biaya_admin_persen,10) * parseInt(subtotal,10) / 100;
 

      var total_akhir = parseInt(t_total,10) + parseInt(Math.round(biaya_admin_rupiah,10));

      $("#total").val(tandaPemisahTitik(total_akhir));
      $("#biaya_adm").val(tandaPemisahTitik(Math.round(biaya_admin_rupiah)));

      if (biaya_admin_persen > 100) {
            

            var total_akhir = parseInt(subtotal,10) - parseInt(potongan,10);
            alert ("Biaya Amin %, Tidak Boleh Lebih Dari 100%");
            $("#biaya_admin_persen").val('');
            $("#biaya_admin_select").val('0');            
            $("#biaya_admin_select").trigger('chosen:updated');
            $("#biaya_adm").val('');
            $("#total").val(tandaPemisahTitik(total_akhir));
          }
          
        else
          {
          }

    });

  //END KEYUP BIAYA ADMIN PERSEN
  });
</script>


<script type="text/javascript">
$(document).ready(function(){
  //Key Up Diskon Persen
  $("#diskon_persen").keyup(function(){

  var diskon_persen = bersihPemisah(bersihPemisah(bersihPemisah(bersihPemisah($("#diskon_persen").val()))));
  var total = bersihPemisah(bersihPemisah(bersihPemisah(bersihPemisah( $("#subtotal").val() ))));
  var diskon_rupiah = ((total * diskon_persen) / 100);

  var biaya_adm = bersihPemisah(bersihPemisah(bersihPemisah(bersihPemisah($("#biaya_adm").val()))));
  
  if (biaya_adm == ''){
    biaya_adm = 0;
  }
  
  var pembayaran = bersihPemisah(bersihPemisah(bersihPemisah(bersihPemisah($("#pembayaran_penjualan").val()))));
  if (pembayaran == ''){
    pembayaran = 0;
  }

  var sisa_potongan = parseInt(total,10) - parseInt(Math.round(diskon_rupiah,10));
  var hasil_akhir = parseInt(sisa_potongan, 10) + parseInt(biaya_adm,10);
  var toto = parseInt(total, 10) + parseInt(biaya_adm,10) 

  if (diskon_persen > 100) {
        var sisa = pembayaran - Math.round(toto);
        var sisa_kredit = Math.round(toto) - pembayaran; 
            
      if (sisa < 0 ){
        $("#kredit").val( tandaPemisahTitik(sisa_kredit));
        $("#sisa_pembayaran_penjualan").val('0');
        $("#tanggal_jt").attr("disabled", false);           
      }
      else{
        $("#sisa_pembayaran_penjualan").val(tandaPemisahTitik(sisa));
        $("#kredit").val('0');
        $("#tanggal_jt").attr("disabled", true);
      } 
      
      alert ("Potongan %, Tidak Boleh Lebih Dari 100%");
      $("#diskon_persen").val('')
      $("#diskon_rupiah").val('')
      $("#total").val(tandaPemisahTitik(Math.round(toto)));
      
      $("#diskon_persen").focus()

  }
  else{

    var sisa = pembayaran - Math.round(hasil_akhir);
    var sisa_kredit = Math.round(hasil_akhir) - pembayaran; 
        
    if (sisa < 0 ){
      $("#kredit").val( tandaPemisahTitik(sisa_kredit));
      $("#sisa_pembayaran_penjualan").val('0');
      $("#tanggal_jt").attr("disabled", false);
    }
    else{
      $("#sisa_pembayaran_penjualan").val(tandaPemisahTitik(sisa));
      $("#kredit").val('0');
      $("#tanggal_jt").attr("disabled", true);
    } 

    $("#total").val(tandaPemisahTitik(Math.round(hasil_akhir)));
    $("#diskon_rupiah").val(tandaPemisahTitik(Math.round(diskon_rupiah)));
  }

  }); //Akhir Keyup Diskon Persen

  //Mulai Keyup Diskon Rupiah
  $("#diskon_rupiah").keyup(function(){

  var diskon_rupiah =  bersihPemisah(bersihPemisah(bersihPemisah(bersihPemisah( $("#diskon_rupiah").val()))));
  var biaya_adm = bersihPemisah(bersihPemisah(bersihPemisah(bersihPemisah($("#biaya_adm").val()))));
  if (biaya_adm == ''){
      biaya_adm = 0;
  }
    
  var pembayaran = bersihPemisah(bersihPemisah(bersihPemisah(bersihPemisah($("#pembayaran_penjualan").val()))));
  if (pembayaran == '') {
      pembayaran = 0;
  }
  var total = bersihPemisah(bersihPemisah(bersihPemisah(bersihPemisah( $("#total").val() ))));
  var total = bersihPemisah(bersihPemisah(bersihPemisah(bersihPemisah($("#subtotal").val()))));
  var diskon_persen = ((diskon_rupiah / total) * 100);
  var sisa_potongan = total - Math.round(diskon_rupiah);
  var hasil_akhir = parseInt(sisa_potongan, 10) + parseInt(biaya_adm,10);
  var toto = parseInt(total, 10) + parseInt(biaya_adm,10);

  if (diskon_persen > 100) {
    var sisa = pembayaran - Math.round(toto);
    var sisa_kredit = Math.round(toto) - pembayaran; 
        
    if (sisa < 0 ){
      $("#kredit").val(tandaPemisahTitik(sisa_kredit));
      $("#sisa_pembayaran_penjualan").val('0');
      $("#tanggal_jt").attr("disabled", false);
              
    }
    else{
      $("#sisa_pembayaran_penjualan").val(tandaPemisahTitik(sisa));
      $("#kredit").val('0');
      $("#tanggal_jt").attr("disabled", true);
              
    } 
        alert ("Potongan %, Tidak Boleh Lebih Dari 100%");
            $("#diskon_persen").val('');
            $("#diskon_rupiah").val('');
            $("#total").val(tandaPemisahTitik(toto));
            $("#tax_rp").val(Math.round(taxxx))
  }
  else{
    var sisa = pembayaran - Math.round(hasil_akhir);
    var sisa_kredit = Math.round(hasil_akhir) - pembayaran; 
        
    if (sisa < 0 ){
      $("#kredit").val( tandaPemisahTitik(sisa_kredit));
      $("#sisa_pembayaran_penjualan").val('0');
      $("#tanggal_jt").attr("disabled", false);       
    }
    else{
      $("#sisa_pembayaran_penjualan").val(tandaPemisahTitik(sisa));
      $("#kredit").val('0');
      $("#tanggal_jt").attr("disabled", true);
              
    }
    $("#total").val(tandaPemisahTitik(Math.round(hasil_akhir)));
    $("#diskon_persen").val(Math.round(diskon_persen));
  }
  }); //Akhir Keyup Diskon Persen
}); //Akhir Doc Ready       
</script>


<!--CLASS CHOSEN -->
<script type="text/javascript">
	$(".chosen").chosen({no_results_text: "Maaf, Data Tidak Ada!",search_contains:true});
</script>
<!-- / CLASS CHOSEN -->

<!-- SHORTCUT -->
<script> 
    
    shortcut.add("f1", function() {
        // Do something

        $("#cari_pasien").click();

    }); 

    shortcut.add("f4", function() {
        // Do something

        $("#carabayar1").trigger('chosen:open');

    }); 

    
    shortcut.add("f7", function() {
        // Do something

        $("#pembayaran_penjualan").focus();

    }); 

    
    shortcut.add("f8", function() {
        // Do something

        $("#penjualan").click();

    }); 

    
    shortcut.add("f9", function() {
        // Do something

        $("#piutang").click();

    }); 

        shortcut.add("ctrl+m", function() {

        // Do something
        $("#transaksi_baru").click();

    }); 

    
    shortcut.add("ctrl+b", function() {
        // Do something

        $("#batal_penjualan").click();

    }); 

     shortcut.add("ctrl+k", function() {
        // Do something

        $("#cetak_langsung").click();


    }); 
</script>
<!-- SHORTCUT -->

<script>
$(document).ready(function(){
	//Keyup Ketika Ketik Pembayaran
    $("#pembayaran_penjualan").keyup(function(){
        var pembayaran = bersihPemisah(bersihPemisah(bersihPemisah(bersihPemisah( $("#pembayaran_penjualan").val() ))));
        var total =  bersihPemisah(bersihPemisah(bersihPemisah(bersihPemisah( $("#total").val() ))));
        var sisa = pembayaran - total;
        var sisa_kredit = total - pembayaran; 
        
        if (sisa < 0 ){
            $("#kredit").val( tandaPemisahTitik(sisa_kredit));
            $("#sisa_pembayaran_penjualan").val('0');
            $("#tanggal_jt").attr("disabled", false);

            $("#penjualan").hide();
            $("#cetak_langsung").hide();
            $("#piutang").show();
        }
        else{
            $("#sisa_pembayaran_penjualan").val(tandaPemisahTitik(sisa));
            $("#kredit").val('0');
            $("#tanggal_jt").attr("disabled", true);

            $("#penjualan").show();
            $("#cetak_langsung").show();
            $("#piutang").hide();
        } 
    });
});
</script>

<script type="text/javascript">
$(document).ready(function(){
// Mulai Transaksi Baru
    $(document).on('click','#transaksi_baru',function(e){
       $('#tabel_cari_pasien').DataTable().destroy();
        var dataTable = $('#tabel_cari_pasien').DataTable( {
          "processing": true,
          "serverSide": true,
          "ajax":{
            url :"modal_pasien_penjualan_aps.php", // json datasource
            type: "post",  // method  , by default get
            error: function(){  // error handling
              $(".employee-grid-error").html("");
              $("#tabel_cari_pasien").append('<tbody class="employee-grid-error"><tr><th colspan="3">Data Tidak Ditemukan.. !!</th></tr></tbody>');
              $("#employee-grid_processing").css("display","none");
              
            }
          },

          "fnCreatedRow": function( nRow, aData, iDataIndex ) {

              $(nRow).attr('class', "pilih-reg");
              $(nRow).attr('no_reg', aData[0]);
              $(nRow).attr('no_rm', aData[1]+" | "+aData[2]+"");
              $(nRow).attr('nama_pasien', aData[2]);
              $(nRow).attr('penjamin', aData[5]);
              $(nRow).attr('aps_periksa', aData[6]);
              $(nRow).attr('dokter', aData[7]);
              $(nRow).attr('level_harga', aData[8]);


          }

        });  
        	//DATA
            $("#pembayaran_penjualan").val('');
            $("#sisa_pembayaran_penjualan").val('');
            $("#kredit").val('');
            $("#potongan_penjualan").val('');
            $("#diskon_persen").val('');
            $("#tanggal_jt").val('');
            $("#subtotal").val('');
            $("#total").val('');
            $("#biaya_admin_select").val('0');
            $("#biaya_admin_select").trigger("chosen:updated");
            $("#biaya_admin_persen").val('');
            $("#biaya_adm").val('');
            $("#no_rm").val('');
            $("#no_reg").val('');
            $("#keterangan").val('');
            //SHOW
            $("#batal_penjualan").show();
            //HIDE
            $("#penjualan").hide();
            $("#cetak_langsung").hide();
            $("#piutang").hide();
            $("#transaksi_baru").hide();
            $("#alert_berhasil").hide();
            $("#cetak_tunai").hide();
            $("#cetak_tunai_besar").hide();
            $("#cetak_piutang").hide();  
            $("#btnRefreshsubtotal").hide();  

            var url = window.location.href;
             url = getPathFromUrl(url);
            history.pushState('', 'Sim Klinik',  url);

            function getPathFromUrl(url) {
              return url.split("?")[0];
            }


    });
  });
// Akhir Transaksi Baru
</script>

<!--Footer-->
<?php include 'footer.php'; ?>