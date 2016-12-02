<?php include 'session_login.php';
include 'header.php';
include 'navbar.php';
include 'db.php';
include_once 'sanitasi.php';

$no_reg = stringdoang($_GET['no_reg']);

$query2 = $db->query("SELECT * FROM rekam_medik INNER JOIN penjualan ON rekam_medik.no_reg = penjualan.no_reg  WHERE rekam_medik.no_reg = '$no_reg'");
$baris = mysqli_num_rows($query2);

if ($baris > 0){

  $query = $db->query("SELECT * FROM rekam_medik INNER JOIN penjualan ON rekam_medik.no_reg = penjualan.no_reg  WHERE rekam_medik.no_reg = '$no_reg'");
  $data = mysqli_fetch_array($query);
  $perawat = $data['perawat'];
  $apoteker = $data['apoteker'];

}

else{

   $query = $db->query("SELECT * FROM rekam_medik WHERE no_reg = '$no_reg'");
  $data = mysqli_fetch_array($query);
  $apoteker = '';
  $perawat = '';
}




$f2 = $db->query("SELECT * FROM detail_penjualan WHERE no_reg = '$data[no_reg]'");
$h2 = mysqli_fetch_array($f2);


 ?>



<!-- Modal Untuk Confirm SELESAI-->
<div id="modal-selesai" class="modal fade" role="dialog">
  <div class="modal-dialog">
    <!-- Modal content-->
    <div class="modal-content">
    <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>       
    </div>
    <div class="modal-body">

      <center><h4>Anda Yakin Ingin Menyelesaikan Data Rekam Medik Ini ?</h4></center>
    
      <input style="height: 20px;" type="hidden" id="reg2" name="reg2">
      
    </div>
    <div class="modal-footer">
        <a href="selesai_rj.php?no_reg=<?php echo $no_reg;?>" class="btn btn-success" id="yesss" >Yes</a>
        <button type="button" class="btn btn-danger" data-dismiss="modal">No</button>
    </div>
    </div>
  </div>
</div>
<!--modal end Confirm SELESAI-->



 <div class="container">


 <!-- menu rekam medik -->
 <h3>INPUT REKAM MEDIK R.JALAN</h3><hr>


<ul class="nav nav-tabs md-pills pills-ins" role="tablist">
      <li class="nav-item"><a class="nav-link " href="rekam_medik_raja.php"> Pencarian Rekam Medik </a></li>
        <li class="nav-item"><a class="nav-link active" href="input_rekammedik_raja.php?no_reg=<?php echo $no_reg;?>&tgl=<?php echo $data['tanggal_periksa'];?>&jam=<?php echo $data['jam'];?>" >Data Pemeriksaan</a></li>
         <li class="nav-item"><a class="nav-link" href="obat_rawat_jalan.php?reg=<?php echo $data['no_reg']; ?>&tgl=<?php echo $data['tanggal_periksa'];?>&jam=<?php echo $data['jam'];?>" >Obat-Obatan</a></li>
          <li class="nav-item"><a class="nav-link" href="tindakan_rawat_jalan.php?reg=<?php echo $data['no_reg']; ?>&tgl=<?php echo $data['tanggal_periksa'];?>&jam=<?php echo $data['jam'];?>" >Tindakan</a></li>
</ul>

<br>
  <div class="card card-block" style="width:700px">
<h3>
<div class="row">

<div class="col-sm-6">
      <table>
      <tr><td>No RM</td><td>&nbsp;:&nbsp;</td><td><?php echo $data['no_rm']; ?></td></tr>
      <tr><td>Nama Pasien</td><td>&nbsp;:&nbsp;</td><td><?php echo $data['nama']; ?></td></tr>
</table>
</div>

<div class="col-sm-6">
      <table>
    <tr><td>Tanggal / Jam</td><td>&nbsp;:&nbsp;</td><td><?php echo $data['tanggal_periksa']; ?> / <?php echo $data['jam'];?></td></tr>
      <tr><td>Alamat</td><td>&nbsp;:&nbsp;</td><td><?php echo $data['alamat']; ?></td></tr>
</table>
</div>

</div> 
</h3>
</div>


<?php 
$select_penjualan = $db->query("SELECT status FROM penjualan WHERE no_reg = '$no_reg'");
$out_jual = mysqli_fetch_array($select_penjualan);
$jualan = $out_jual['status'];

if ($jualan == 'Lunas' OR $jualan == 'Piutang' OR $jualan == 'Piutang Apotek')
{
  echo "


<button data-no-reg='".$no_reg."' style='background-color:#80deea;' class='btn btn-default selesai'><span class='glyphicon glyphicon-send'></span> Selesai </button>

<br><br>";


}
?>

<br>


<div class="row">

<div class="col-sm-3"> <!--   OPEN COL SM 1  -->

<div class="card card-block"><!--div class="card card-block"-->

<form  role="form" action="proses_rm_rj.php" method="POST">
        <div class="form-group">
          <div class="row">

                <div class="col-sm-3">
                 		<b><label >Poli</label></b>
                </div>

                <div class="col-sm-9">
                	  <input style="height: 20px;" type="text" class="form-control" id="poli" name="poli" value="<?php echo $data['poli']; ?>"  readonly="" >
                </div>
          </div> <!--   END COLL SM 1  -->
        </div><!-- akhir row input -->

        <div class="form-group">
            <div class="row">

             	<div class="col-sm-3">
             		 <b><label >Dokter</label></b>
             	</div>

        	  	<div class="col-sm-9">
         	      <input style="height: 20px;" type="text" class="form-control" id="dokter" name="dokter" value="<?php echo $data['dokter']; ?>" readonly="" > 
              </div>
            </div>
        </div><!-- akhir row input -->




         <div class="form-group">
            <div class="row">

              <div class="col-sm-3">
                 <b><label >Petugas Paramedik</label></b>
              </div>

              <div class="col-sm-9">
                <input style="height: 20px;" type="text" class="form-control" id="perawat" name="perawat" value="<?php echo $perawat; ?>" readonly="" > 
             </div>

            </div>
        </div><!-- akhir row input -->


     <div class="form-group">
        <div class="row">
      
          <div class="col-sm-3">
             <b><label >Petugas Farmasi</label></b>
          </div>

          <div class="col-sm-9">
            <input style="height: 20px;" type="text" class="form-control" id="apoteker" name="apoteker" value="<?php echo $apoteker; ?>" readonly="" > 
          </div>

        </div>
     </div><!-- akhir row input -->


      <div class="form-group">
          <div class="row">

         	  <div class="col-sm-3">
         		 <b><label >No. RM</label></b>
            </div>

            <div class="col-sm-9">
              <input style="height: 20px;" type="text" class="form-control" id="no_rm" name="no_rm" value="<?php echo $data['no_rm']; ?>" readonly=""> 
            </div>

          </div>
      </div><!-- akhir row input -->


  <input style="height: 20px;" type="hidden" name="tanggal_periksa" value="<?php echo $data['tanggal_periksa']; ?>" >

  <input style="height: 20px;" type="hidden" name="jam" value="<?php echo $data['jam'];?>" >

<div class="form-group">
    <div class="row">

 	      <div class="col-sm-3">
 		    <b><label >No. Reg</label></b>
 	      </div>

    	  <div class="col-sm-9">
          <input style="height: 20px;" type="text" class="form-control" id="no_reg" name="no_reg" value="<?php echo $data['no_reg']; ?>" readonly="" > 
        </div>
    </div>
</div><!-- akhir row input -->
 	
 <div class="form-group">
    <div class="row">

 	    <div class="col-sm-3">
 		     <b><label >Nama</label></b>
 	    </div>

  	  <div class="col-sm-9">
        <input style="height: 20px;" type="text" class="form-control" id="nama" name="nama" value="<?php echo $data['nama']; ?>" readonly="" > 
      </div>

    </div>
</div><!-- akhir row input -->
 	
<div class="form-group">
 	 <div class="row">
 	    
      <div class="col-sm-3">
 		    <b><label >Alamat</label></b>
 	    </div>

  	 <div class="col-sm-9">
        <input style="height: 20px;" type="text" class="form-control" id="alamat" name="alamat" value="<?php echo $data['alamat']; ?>" readonly="" > 
    </div>

   </div>
</div><!-- akhir row input -->
 	
 	
 <div class="form-group">
 	  <div class="row">

         <div class="col-sm-3">
   		       <b><label >Umur</label></b>
 	       </div>

    	  <div class="col-sm-9">
            <input style="height: 20px;" type="text" class="form-control" id="umur" name="umur" value="<?php echo $data['umur']; ?>" readonly="" > 
        </div>

    </div>
</div><!-- akhir row input -->
 	
<div class="form-group">
   <div class="row">

      <div class="col-sm-3">	
        <b><label >Jenis Kelamin</label></b>
      </div>

	  	<div class="col-sm-9">
        <input style="height: 20px;" type="text" class="form-control" id="jenis_kelamin" name="jenis_kelamin" value="<?php echo $data['jenis_kelamin']; ?>" readonly="" > 
      </div>

   </div>
</div><!-- akhir row input -->
 	
<div class="form-group">
    <div class="row">

       	<div class="col-sm-3">
     	  <b><label >Kondisi</label></b>
     	  </div>

        <div class="col-sm-9">
        <input style="height: 20px;" type="text" class="form-control" id="kondisi" name="kondisi" value="<?php echo $data['kondisi']; ?>" readonly="" > 
       </div>

     </div>
</div><!-- akhir row input -->
 	
<div class="form-group">
    <div class="row">
       	<div class="col-sm-3">
            <b><label >Rujukan</label></b>
       	</div>

  	  	<div class="col-sm-9">
   	    <input style="height: 20px;" type="text" class="form-control" id="rujukan" name="rujukan" value="<?php echo $data['rujukan']; ?>" readonly="" > 
       </div>

    </div><!-- akhir COL SM -->  
</div><!-- akhir row input -->	


</div><!--end <div class="card card-block">-->
</div><!-- akhir div col-sm-3 form data pasien -->



<div class="col-sm-9">

<div class="card card-block">

<div class="row"> <!--   ROW 01  -->

<div class="form-group col-sm-6">
 <b><label >Sistole /Diastole (mmHg)</label></b>
   <input style="height: 20px;" type="text" class="form-control" id="sistole_distole"  autocomplete="off" name="sistole_distole" value="<?php echo $data['sistole_distole']; ?>" > 
</div>

<div class="form-group col-sm-6">
  <b><label >Frekuensi Pernapasan (kali/menit)</label></b>
 	 <input style="height: 20px;" type="text" class="form-control" id="respiratory_rate" autocomplete="off" name="respiratory_rate" value="<?php echo $data['respiratory']; ?>" > 
</div>
</div> <!--  END ROW 02   -->


<div class="row"> <!--   ROW O3  -->
   <div class="form-group col-sm-6">
  <b><label >Suhu  (°C)</label></b>
 	 <input style="height: 20px;" type="text" class="form-control" id="suhu" name="suhu" autocomplete="off" value="<?php echo $data['suhu']; ?>" > 
</div>

<div class="form-group col-sm-6">
   <b><label >Nadi (kali/menit)</label></b>
 	  <input style="height: 20px;" type="text" class="form-control" id="nadi" name="nadi" autocomplete="off" value="<?php echo $data['nadi']; ?>" > 
</div>
</div><!--   END ROW 03  -->

<div class="row">
  <div class="form-group col-sm-6">
  <b><label >Berat Badan (kg)</label></b>
 	<input style="height: 20px;" type="text" class="form-control" id="berat_badan" name="berat_badan" autocomplete="off" value="<?php echo $data['berat_badan']; ?>" > 
</div>

<div class="form-group col-sm-6">
  <b><label >Tinggi Badan (cm)</label></b>
 	  <input style="height: 20px;" type="text" class="form-control" id="tinggi_badan" name="tinggi_badan" autocomplete="off" value="<?php echo $data['tinggi_badan']; ?>"> 
    </div>
</div>

<div class="row">
    <div class="form-group col-sm-6">
    <b><label >Anamnesa</label></b>
 	  <textarea class="form-control" id="anamnesa" name="anamnesa" autocomplete="off" ><?php echo $data['anamnesa']; ?></textarea>
</div>

<div class="form-group col-sm-6">
    <b><label >Pemeriksaan Fisik</label></b>
 	  <textarea class="form-control" id="pemeriksaan_fisik" name="pemeriksaan_fisik" autocomplete="off" ><?php echo $data['pemeriksaan_fisik']; ?></textarea> 
</div>
</div>

<div class="row">
    <div class="form-group col-sm-6">
     <b><label >keadaan Umum</label></b>
<select class="form-control" id="keadaan_umum" name="keadaan_umum" required="" autocomplete="off" >
    <option value="<?php echo $data['keadaan_umum']; ?>"><?php echo $data['keadaan_umum']; ?></option>
    <option value="Tampak Normal">Tampak Normal</option>
    <option value="Pucat dan Lemas">Pucat dan Lemas</option>
    <option value="Sadar dan Cidera">Sadar dan Cidera</option>
    <option value="Pingsan / Tidak Sadar">Pingsan / Tidak Sadar</option>
    <option value="Meninggal Sebelum Tiba">Meninggal Sebelum Tiba</option>
  </select>
</div>

<div class="form-group col-sm-6">
    <b><label >kesadaran</label></b>
 	  <select class="form-control" id="kesadaran" name="kesadaran">
 		   <option value="<?php echo $data['kesadaran'];?>"><?php echo $data['kesadaran']; ?></option>
 		   <option value="Compos Mentis">Compos Mentis</option>
       <option value="Apatis">Apatis</option>
       <option value="Somnolent">Somnolent</option>
       <option value="Sopor">Sopor</option>
       <option value="Sopora Coma">Sopora Coma</option>
 		   <option value="Coma">Coma</option> 
 	  </select>
 </div>
 </div>

<div class="row">	
<div class="col-sm-2">
	    <b><label>Diagnosis Utama</label></b>
</div>

<div class="col-sm-10">
 	<input style="height: 20px;" type="text" class="form-control "  list="icd" id="diagnosis_utama" autocomplete="off" placeholder="Ketikkan Diagnosis Utama" name="diagnosis_utama" value="<?php echo $data['icd_utama']; ?>">
 

</div>
</div>

<div class="row">
      <div class="col-sm-2">
	    <b><label>Diagnosis Penyerta</label></b>
</div>


<div class="col-sm-10">
 	  <input style="height: 20px;" type="text" class="form-control" list="icd"  autocomplete="off" placeholder=" Ketikkan Diagnosis Penyerta" id="diagnosis_penyerta" value="<?php echo $data['icd_penyerta']; ?>" name="diagnosis_penyerta" >
</div>
</div>
  
<div class="row">
<div class="col-sm-2">
    <b><label>Diagnosis Penyerta Tambahan</label></b>
</div>


<div class="col-sm-10">
  <input style="height: 20px;" type="text" class="form-control" list="icd" autocomplete="off" placeholder=" Ketikkan Diagnosis Penyerta Tambahan" id="diagnosis_penyerta_tambahan" value="<?php echo $data['icd_penyerta_tambahan']; ?>" name="diagnosis_penyerta_tambahan" >
</div>
</div>
  
<div class="row">
<div class="col-sm-2">
	 <b><label>Komplikasi</label></b>
</div>

<div class="col-sm-10">
 	<input style="height: 20px;" type="text" class="form-control" list="icd" autocomplete="off" placeholder=" Ketikkan Komplikasi" id="komplikasi" name="komplikasi" value="<?php echo $data['icd_komplikasi']; ?>">     
</div>
</div>

<div class="row">
 <div class="form-group col-sm-12">
 	<select class="form-control" name="kondisi_keluar" autocomplete="off" id="kondisi_keluar" >
 		<option value="<?php echo $data['kondisi_keluar']; ?>"><?php echo $data['kondisi_keluar']; ?></option>
 		<option value="Sehat / Sembuh">Sehat / Sembuh</option>
 		<option value="Pulang dan Proses Penyembuhan">Pulang dan Proses Penyembuhan</option>
 		<option value="Masuk Rawat Inap / ICU/OK">Masuk Rawat Inap / ICU/OK</option>
 		<option value="Dirujuk dengan pertolongan Pertama">Dirujuk dengan pertolongan Pertama</option>
 		<option value="Dirujuk tanpa pertolongan pertama">Dirujuk tanpa pertolongan pertama</option>
 		<option value="Meninggal Dunia">Meninggal Dunia</option>
 		<option value="Tidak diketahui kondisinya">Tidak diketahui kondisinya</option>
 	</select>
  </div>
 <button type="submit" class="btn btn-info col-sm-2"><i class="fa fa-pencil-square "></i> Update</button>
</div>
</form>

</div><!-- akhir div car card block -->
</div><!-- akhir div col-sm-9 data rm -->
</div><!-- akhir div row form -->
</div><!-- akhir div layout form rm jalan -->

<!--   icd utama  -->
 <script type="text/javascript">

$("#diagnosis_utama").change(function()
{

var diagnosis_utama = $("#diagnosis_utama").val();

$.post("cek_icd_utama.php",{diagnosis_utama:diagnosis_utama},function(data){
$("#kode_diagnosis_utama").val(data);

});


});

</script>
<!--   end icd utama  -->

<!--  diagnosis penyerta   -->
<script type="text/javascript">

$("#diagnosis_penyerta").change(function()
{

var diagnosis_utama = $("#diagnosis_penyerta").val();

$.post("cek_icd_utama.php",{diagnosis_utama:diagnosis_utama},function(data){
$("#kode_diagnosis_penyerta").val(data);

});


});
</script>
<!--  end diagnosis penyerta   -->

<!--  open akselarasi Kepala nAV   -->
<script type="text/javascript">
$(document).ready(function(){
  $("#tmpl-form").load('rm_rawat_jalan.php');

$("#nav-1").click(function(){

  $("#tmpl-form").load('rm_rawat_jalan.php');
  $("#nav-1").attr("class" , "active");
  $("#nav-2").attr("class" , "non");
  $("#nav-3").attr("class" , "non");
  $("#nav-4").attr("class" , "non");v
  $("#nav-5").attr("class" , "non");
});

$("#nav-2").click(function(){

  $("#tmpl-form").load('rekam_medik_rawat_jalan.php');
  $("#nav-1").attr("class" , "non");
  $("#nav-2").attr("class" , "active");
  $("#nav-3").attr("class" , "non");
  $("#nav-4").attr("class" , "non");
  $("#nav-5").attr("class" , "non");
});

$("#nav-3").click(function(){

  $("#tmpl-form").load('#');
  $("#nav-1").attr("class" , "non");
  $("#nav-2").attr("class" , "non");
  $("#nav-3").attr("class" , "active");
  $("#nav-4").attr("class" , "non");
  $("#nav-5").attr("class" , "non");
});

$("#nav-4").click(function(){

  $("#tmpl-form").load('obat_rawat_jalan.php?reg=<?php echo $data['no_reg']; ?>');
  $("#nav-1").attr("class" , "non");
  $("#nav-2").attr("class" , "non");
  $("#nav-3").attr("class" , "non");
  $("#nav-4").attr("class" , "active");
  $("#nav-5").attr("class" , "non");
});

$("#nav-5").click(function(){

  $("#tmpl-form").load('tindakan_rawat_jalan.php?reg=<?php echo $data['no_reg']; ?>');
  $("#nav-1").attr("class" , "non");
  $("#nav-2").attr("class" , "non");
  $("#nav-3").attr("class" , "non");
  $("#nav-4").attr("class" , "non");
  $("#nav-5").attr("class" , "active");

});

});

</script>
<!--  END AKSELARASI    -->
<!--

  DIAGNOSIS TAMABAHAN  
<script type="text/javascript">

      $("#diagnosis_penyerta_tambahan").change(function()
       {

       var diagnosis_utama = $("#diagnosis_penyerta_tambahan").val();

       $.post("cek_icd_utama.php",{diagnosis_utama:diagnosis_utama},function(data){
      $("#kode_diagnosis_penyerta_tambahan").val(data);

      });

      });
</script>
 END DIAGNOSIS TAMBAHAN   

 DIAGNOSIS UTAMA   
<script type="text/javascript">

$("#diagnosis_utama").change(function()
{

var diagnosis_utama = $("#diagnosis_utama").val();

$.post("cek_icd_utama.php",{diagnosis_utama:diagnosis_utama},function(data){
$("#kode_diagnosis_utama").val(data);

});


});


</script>
   DIAGNOSIS UTAMA END  

 KOMPLIKASI OPEN   
<script type="text/javascript">

$("#komplikasi").change(function()
{

var diagnosis_utama = $("#komplikasi").val();

$.post("cek_icd_utama.php",{diagnosis_utama:diagnosis_utama},function(data){
$("#kode_komplikasi").val(data);

});

});

</script>
 END KOMPLIKASI  

-->

<!--   script modal confirmasi SELESAI -->
<script type="text/javascript">
$(".selesai").click(function(){

  var reg = $(this).attr('data-no-reg');


$("#modal-selesai").modal('show');
$("#reg2").val(reg);


});


</script>
<!--   end script modal confiormasi SELESAI -->


<script>
$(function() {
    $( "#diagnosis_utama" ).autocomplete({
        source: 'cek_icd_utama.php'
    });
});
</script>

<script>
$(function() {
    $( "#diagnosis_penyerta" ).autocomplete({
        source: 'cek_icd_utama.php'
    });
});
</script>

<script>
$(function() {
    $( "#diagnosis_penyerta_tambahan" ).autocomplete({
        source: 'cek_icd_utama.php'
    });
});
</script>

<script>
$(function() {
    $( "#komplikasi" ).autocomplete({
        source: 'cek_icd_utama.php'
    });
});
</script>



<?php 
include 'footer.php';
?>