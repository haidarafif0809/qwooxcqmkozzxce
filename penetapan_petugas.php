<?php include 'session_login.php';


//memasukkan file session login, header, navbar, db.php
include 'header.php';
include 'navbar.php';
include 'sanitasi.php';
include 'db.php';



 ?>


  <style>


tr:nth-child(even){background-color: #f2f2f2}


</style>

<div class="container">

<h3><b> DATA PENETAPAN PETUGAS </b></h3><hr>
<div class="table-responsive">
<span id="tabel_baru">
<table id="tableuser" class="table table-bordered">
		<thead>
			<th style='background-color: #4CAF50; color: white'>Nama Dokter</th>
			<th style='background-color: #4CAF50; color: white'>Nama Petugas Paramedik</th>
			<th style='background-color: #4CAF50; color: white'>Nama Petugas Farmasi</th>
			
		</thead>
		
		<tbody>
		<?php
			//menampilkan seluruh data yang ada pada tabel penjualan
			$perintah = $db->query("SELECT * FROM penetapan_petugas");
			while ($data = mysqli_fetch_array($perintah))
			{

				

				//menampilkan data
			echo "<tr>";
			echo "<td class='edit-dokter' data-id='".$data['id']."'><span id='text-dokter-".$data['id']."'>". $data['nama_dokter'] ."</span>
			<select style='display:none' id='select-dokter-".$data['id']."' value='".$data['nama_dokter']."' class='select-dokter' data-id='".$data['id']."' autofocus=''>";

			echo '<option>'. $data['nama_dokter'] .'</option>';
			echo '<option>-</option>';
			
			
			$query2 = $db->query("SELECT nama FROM user WHERE tipe = '1' ");

			while($data2 = mysqli_fetch_array($query2))
			{
			
			echo ' <option>'.$data2["nama"] .'</option>';
			}
			
			
			echo  '</select>
			</td>';

			echo "<td class='edit-paramedik' data-id='".$data['id']."'><span id='text-paramedik-".$data['id']."'>".$data['nama_paramedik']."</span><select style='display:none' id='select-paramedik-".$data['id']."' value='".$data['nama_paramedik']."' class='select-paramedik' data-id='".$data['id']."' autofocus=''>";

			echo '<option>'. $data['nama_paramedik'] .'</option>';
			echo '<option>-</option>';
			
			
			$query2 = $db->query("SELECT nama FROM user WHERE tipe = '2'");

			while($data2 = mysqli_fetch_array($query2))
			{
			
			echo ' <option>'.$data2["nama"] .'</option>';
			}
			
			
			echo  '</select>
			</td>';


			echo "<td class='edit-farmasi' data-id='".$data['id']."'><span id='text-farmasi-".$data['id']."'>".$data['nama_farmasi']."</span><select style='display:none' id='select-farmasi-".$data['id']."' value='".$data['nama_farmasi']."' class='select-farmasi' data-id='".$data['id']."' autofocus=''>";

			echo '<option>'. $data['nama_farmasi'] .'</option>';
			echo '<option>-</option>';
			
			
			$query2 = $db->query("SELECT nama FROM user WHERE tipe = '3'");

			while($data2 = mysqli_fetch_array($query2))
			{
			
			echo ' <option>'.$data2["nama"] .'</option>';
			}
			
			
			echo  '</select>
			</td>';


			echo "</tr>";
			}
	
	//Untuk Memutuskan Koneksi Ke Database
	mysqli_close($db);   
		?>

		</tbody>

	</table>
	</span>


</div>
</div>
		<script>
		
		$(document).ready(function(){
		$('#tableuser').dataTable();
		});
		</script>




		<script type="text/javascript">
			//fungsi edit data 
		$(".btn-edit").click(function(){
		
		$("#modal_edit").modal('show');
		var nominal = $(this).attr("data-nominal"); 
		var persen  = $(this).attr("data-persen");
		var tax = $(this).attr("data-tax"); 
		var id  = $(this).attr("data-id");
		

		$("#tax_edit").val(tax);
		$("#id_edit").val(id);
		
		
		});
		
		$("#submit_edit").click(function(){
		var nominal = $("#nominal_edit").val();
		var persen = $("#persen_edit").val();
		var tax = $("#tax_edit").val();
		var id = $("#id_edit").val();



		if (nominal < 0){
			alert("Diskon Nominal Harus Diisi");
		}
		else if (persen < 0 || persen > 100){
			alert("Diskon Persen Belum Diisi atau Melebihi 100%");
		}
		else if (tax < 0 || tax > 100){
			alert("Pajak Belum Diisi atau Melebihi 100%");
		}
		else {

		$.post("proses_edit_diskon_tax.php",{id:id,diskon_nominal:nominal,diskon_persen:persen,tax:tax},function(data){


		
		$("#tabel_baru").load('tabel-diskon-tax.php');
		$(".modal").modal("hide");
		
		
		});
		}

		});

		</script>

		<script type="text/javascript">
  
      $("#persen_edit").keyup(function(){
      var persen = $("#persen_edit").val();
      var nominal = $("#nominal_edit").val();
      
      if (persen > 100)
      {

          alert("Jumlah Persen Tidak Boleh Lebih dari 100%");
          $("#persen_edit").val('');
      }

      else if (persen == "") 
      {
        $("#nominal").show();
      }

      else
      {
            $("#nominal").hide();
      }


    
      });


              $("#nominal_edit").keyup(function(){
              var nominal = $("#nominal_edit").val();
              var persen = $("#persen_edit").val();
              
              if (nominal == "") 
              {
              $("#persen").show();
              }
              
              else
              {
              $("#persen").hide();
              }
              
              
              
              });


     

  </script>

 <script type="text/javascript">
 	$(".edit-dokter").dblclick(function(){

        var id = $(this).attr("data-id");

        $("#text-dokter-"+id+"").hide();
        $("#select-dokter-"+id+"").show();

    });

    $(".select-dokter").blur(function(){

       var id = $(this).attr("data-id");

        var select_dokter = $(this).val();


        $.post("update_penetapan_petugas.php",{id:id, select_dokter:select_dokter,jenis_select:"nama_dokter"},function(data){

        $("#text-dokter-"+id+"").show();
        $("#text-dokter-"+id+"").text(select_dokter);

        $("#select-dokter-"+id+"").hide();           

        });
     });

 </script>

 <script type="text/javascript">
 	$(".edit-paramedik").dblclick(function(){

        var id = $(this).attr("data-id");

        $("#text-paramedik-"+id+"").hide();
        $("#select-paramedik-"+id+"").show();

    });

    $(".select-paramedik").blur(function(){

        var id = $(this).attr("data-id");

        var select_paramedik = $(this).val();


        $.post("update_penetapan_petugas.php",{id:id, select_paramedik:select_paramedik,jenis_select:"nama_paramedik"},function(data){

        $("#text-paramedik-"+id+"").show();
        $("#text-paramedik-"+id+"").text(select_paramedik);

        $("#select-paramedik-"+id+"").hide();           

        });
     });

 </script>

 <script type="text/javascript">
 	$(".edit-farmasi").dblclick(function(){

        var id = $(this).attr("data-id");

        $("#text-farmasi-"+id+"").hide();
        $("#select-farmasi-"+id+"").show();

    });

    $(".select-farmasi").blur(function(){

        var id = $(this).attr("data-id");

        var select_farmasi = $(this).val();


        $.post("update_penetapan_petugas.php",{id:id, select_farmasi:select_farmasi,jenis_select:"nama_farmasi"},function(data){

        $("#text-farmasi-"+id+"").show();
        $("#text-farmasi-"+id+"").text(select_farmasi);

        $("#select-farmasi-"+id+"").hide();           

        });
     });

 </script>

  <?php 
  include 'footer.php';
   ?>