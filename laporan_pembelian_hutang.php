<?php include 'session_login.php';


//memasukkan file session login, header, navbar, db.php
include 'header.php';
include 'navbar.php';
include 'sanitasi.php';
include 'db.php';


 ?>

     <script>
    $(function() {
    $( "#dari_tanggal" ).datepicker({dateFormat: "yy-mm-dd"});
        $( "#sampai_tanggal" ).datepicker({dateFormat: "yy-mm-dd"});
    $( "#dari_tanggal2" ).datepicker({dateFormat: "yy-mm-dd"});
        $( "#sampai_tanggal2" ).datepicker({dateFormat: "yy-mm-dd"});

    });
    </script>




 <div class="container">

<h3> LAPORAN HUTANG </h3><hr>


<div class="row">
<div class="col-sm-4">
				<button type="button" class="btn btn-primary" id="per_konsumen" style="width:98%;" align="left">Rekap Periode /Suplier </button> 
</div>	
<div class="col-sm-4">
      	<button type="button" class="btn btn-primary" id="non_konsumen" style="width:98%;" align="left">Rekap Periode </button>
</div>

</div> 


<span id="rekap_non_suplier" style="display:none">
<form class="form-inline" role="form">
				
				  <div class="form-group"> 

                  <input type="text" name="dari_tanggal" id="dari_tanggal" class="form-control" placeholder="Dari Tanggal" required="">
                  </div>

                  <div class="form-group"> 

                  <input type="text" name="sampai_tanggal" id="sampai_tanggal" class="form-control" placeholder="Sampai Tanggal" required="">
                  </div>

                  <button type="submit" name="submit" id="submit_non" class="btn btn-primary" > <i class="fa fa-eye"></i> Tampil </button>

</form>
</span>

<span id="rekap_suplier" style="display:none">
<form class="form-inline" role="form">
				
			<div class="form-group"> 
 				<select name="suplier" id="suplier" class="form-control chosen" required="" >
              <option value='semua' >Semua Suplier</option>
				  <?php 
				    
				    //untuk menampilkan semua data pada tabel pelanggan dalam DB
				    $query = $db->query("SELECT id, nama FROM suplier");

				    //untuk menyimpan data sementara yang ada pada $query
				    while($data = mysqli_fetch_array($query))
				    {				          

				    			echo "<option value='".$data['id'] ."' >".$data['nama'] ."</option>";

				    }
				    
				    
				    ?>
   				 </select>
			</div>


				  <div class="form-group"> 

                  <input type="text" name="dari_tanggal2" id="dari_tanggal2" class="form-control" placeholder="Dari Tanggal" required="">
                  </div>

                  <div class="form-group"> 

                  <input type="text" name="sampai_tanggal2" id="sampai_tanggal2" class="form-control" placeholder="Sampai Tanggal" required="">
                  </div>

                  <button type="submit" name="submit" id="submit_true" class="btn btn-primary" > <i class="fa fa-eye"></i> Tampil </button>

</form>
</span>


 <br>
 <div class="table-responsive" id="respon" ><!--membuat agar ada garis pada tabel disetiap kolom-->
<table id="tableuser" class="table table-bordered table-sm">
		<thead>

			<th style="background-color: #4CAF50; color: white;"> Nomor Faktur </th>
      <th style="background-color: #4CAF50; color: white;"> Suplier </th>
      <th style="background-color: #4CAF50; color: white;"> Tgl. Transaksi</th>
      <th style="background-color: #4CAF50; color: white;"> Tgl. Jatuh Tempo</th>
      <th style="background-color: #4CAF50; color: white;"> Umur Hutang </th>
      <th style="background-color: #4CAF50; color: white;"> Nilai Faktur </th>
			<th style="background-color: #4CAF50; color: white;"> Dibayar </th>
			<th style="background-color: #4CAF50; color: white;"> Hutang </th>
						
		</thead>

	</table>
</div> <!--/ responsive-->


       <a href='cetak_laporan_pembelian_hutang.php' style="display: none" class='btn btn-success'  id="cetak_non" target='blank'><i class='fa fa-print'> </i> Cetak Penjualan hutang</a>  

       <a href='download_lap_pembelian_hutang.php' style="display: none" type='submit' target="blank" id="btn-download-non" class='btn btn-purple'><i class="fa fa-download"> </i> Download Excel</a>


       <a href='cetak_laporan_pembelian_hutang_konsumen.php' style="display: none" class='btn btn-success' id="cetak_true" target='blank'><i class='fa fa-print'> </i> Cetak Penjualan hutang</a>  

       <a href='download_lap_pembelian_hutang_konsumen.php' style="display: none" type='submit' target="blank" id="btn-download-true" class='btn btn-purple'><i class="fa fa-download"> </i> Download Excel</a>

</div> <!--/ container-->


<script type="text/javascript">
		$("#submit_non").click(function(){
		
		var dari_tanggal = $("#dari_tanggal").val();
		var sampai_tanggal = $("#sampai_tanggal").val();
		    
      $("#respon").show();
			$('#tableuser').DataTable().destroy();

		  var dataTable = $('#tableuser').DataTable( {
                "processing": true,
                "serverSide": true,
                "info":     true,
                "language": {
              "emptyTable":   "My Custom Message On Empty Table"
          },
                "ajax":{
                  url :"proses_lap_pembelian_hutang.php", // json datasource
                   "data": function ( d ) {
                      d.dari_tanggal = $("#dari_tanggal").val();
                      d.sampai_tanggal = $("#sampai_tanggal").val();
                      // d.custom = $('#myInput').val();
                      // etc
                  },
                      type: "post",  // method  , by default get
                  error: function(){  // error handling
                    $(".tbody").html("");
                    $("#tableuser").append('<tbody class="tbody"><tr><th colspan="3"></th></tr></tbody>');
                    $("#tableuser_processing").css("display","none");
                    
                  }
                }
          
              });
		
    $("#cetak_non").show();
    $("#btn-download-non").show();
     $("#cetak_non").attr("href", "cetak_laporan_pembelian_hutang.php?dari_tanggal="+dari_tanggal+"&sampai_tanggal="+sampai_tanggal+"");
	 $("#btn-download-non").attr("href", "download_lap_pembelian_hutang.php?dari_tanggal="+dari_tanggal+"&sampai_tanggal="+sampai_tanggal+"");
	$("#cetak_true").hide();
    $("#btn-download-true").hide();


		
		});      
		$("form").submit(function(){
		
		return false;
		
		});
		
		</script>

<script type="text/javascript">
		$("#submit_true").click(function(){
		
		var dari_tanggal = $("#dari_tanggal2").val();
		var sampai_tanggal = $("#sampai_tanggal2").val();
		var suplier = $("#suplier").val();
    
      $("#respon").show();
			$('#tableuser').DataTable().destroy();

		  var dataTable = $('#tableuser').DataTable( {
                "processing": true,
                "serverSide": true,
                "info":     true,
                "language": {
              "emptyTable":   "My Custom Message On Empty Table"
          },
                "ajax":{
                  url :"proses_lap_pembelian_hutang_persuplier.php", // json datasource
                   "data": function ( d ) {
                      d.dari_tanggal = $("#dari_tanggal2").val();
                      d.sampai_tanggal = $("#sampai_tanggal2").val();
                      d.suplier = $("#suplier").val();
                      // d.custom = $('#myInput').val();
                      // etc
                  },
                      type: "post",  // method  , by default get
                  error: function(){  // error handling
                    $(".tbody").html("");
                    $("#tableuser").append('<tbody class="tbody"><tr><th colspan="3"></th></tr></tbody>');
                    $("#tableuser_processing").css("display","none");
                    
                  }
                }
          
              });
		
    $("#cetak_true").show();
    $("#btn-download-true").show();
     $("#cetak_true").attr("href", "cetak_laporan_pembelian_hutang_konsumen.php?dari_tanggal="+dari_tanggal+"&sampai_tanggal="+sampai_tanggal+"&suplier="+suplier+"");
	 $("#btn-download-true").attr("href", "download_lap_pembelian_hutang_konsumen.php?dari_tanggal="+dari_tanggal+"&sampai_tanggal="+sampai_tanggal+"&suplier="+suplier+"");
	$("#cetak_non").hide();
    $("#btn-download-non").hide();


		
		});      
		$("form").submit(function(){
		
		return false;
		
		});
		
		</script>



     

<script type="text/javascript">
$(document).ready(function(){


    $("#per_konsumen").click(function(){    

    $("#suplier").chosen("destroy");
    $("#sales").chosen("destroy");
    $("#rekap_suplier").show();
    $("#rekap_non_suplier").hide();
    $("#respon").hide();
    $("#cetak_non").hide();
    $("#btn-download-non").hide();
    $("#cetak_true").hide();
    $("#btn-download-true").hide();

      $(".chosen").chosen({no_results_text: "Maaf, Data Tidak Ada!",search_contains:true});   


    });

   $("#non_konsumen").click(function(){  
  
    $("#rekap_suplier").hide();
    $("#rekap_non_suplier").show();
    $("#respon").hide();
    $("#cetak_non").hide();
    $("#btn-download-non").hide();
    $("#cetak_true").hide();
    $("#btn-download-true").hide();

    });



});
</script>	

<?php 
include 'footer.php';
 ?>