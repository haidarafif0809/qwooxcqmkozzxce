<?php include_once 'session_login.php';
// memasukan file session login,  header, navbar, db.php,
include 'header.php';
include 'navbar.php';
include 'db.php';
include 'sanitasi.php';

$no_faktur = stringdoang($_GET['no_faktur']);

?>
<div class="container">
<h1>Form Hasil Laboratorium</h1>

<form  role="form" >

<input type="hidden" class="form-control" id="no_faktur" value="<?php echo $no_faktur;?>" autocomplete="off">

</form>

 <table>
  <tbody>

    <tr><td width="50%"><font class="satu">No Faktur</font></td> <td> :&nbsp;</td> <td><font class="satu"> <?php echo $no_faktur; ?> </font></tr>

  </tbody>
</table>
<br>
<span id="result">
<div class="table-responsive">
  <table id="table-baru" class="table table-bordered table-sm">

    <thead>
      <tr>

          <th style='background-color: #4CAF50; color: white;'>Nama Pemeriksaan</th>
          <th style='background-color: #4CAF50; color: white;'>Hasil Pemeriksaan</th>
          <th style='background-color: #4CAF50; color: white;' >Nilai Pria</th>
          <th style='background-color: #4CAF50; color: white;' >Nilai Wanita</th>
          <th style='background-color: #4CAF50; color: white'>Apakah Ab-Normal</th>

    </tr>
    </thead>
    <tbody id="tbody">
    
   <?php 
$query = $db->query("SELECT * FROM hasil_lab WHERE no_faktur = '$no_faktur'");
   while($data = mysqli_fetch_array($query))      
      {

      echo "<tr class='tr-id-".$data['id']."'>";

     echo "<td>". $data['nama_pemeriksaan'] ." </td>";

      echo "<td style='background-color: #33b5e5;' class='edit-nama' data-id='".$data['id']."'><span id='text-nama-".$data['id']."'>". $data['hasil_pemeriksaan'] ."</span> <input type='hidden' id='input-nama-".$data['id']."' value='".$data['hasil_pemeriksaan']."' class='input_nama' data-id='".$data['id']."' data-nama='".$data['hasil_pemeriksaan']."' autofocus=''> </td>";

$ambil_model = $db->query("SELECT model_hitung,satuan_nilai_normal FROM setup_hasil WHERE nama_pemeriksaan = '$data[id_pemeriksaan]'");
while($show_model = mysqli_fetch_array($ambil_model))
{

$model_hitung = $show_model['model_hitung']; 
switch ($model_hitung) {
    case "Lebih Kecil Dari":
        echo "<td>&lt;&nbsp; ". $data['nilai_normal_lk']."&nbsp;". $show_model['satuan_nilai_normal']." </td>
        <td>&lt;&nbsp; ". $data['nilai_normal_pr']."&nbsp;". $show_model['satuan_nilai_normal']." </td>
        ";
        break;
    case "Lebih Kecil Sama Dengan":
        echo "<td>&lt;=&nbsp; ". $data['nilai_normal_lk']."&nbsp;". $show_model['satuan_nilai_normal']." </td>
        <td>&lt;=&nbsp; ". $data['nilai_normal_pr']."&nbsp;". $show_model['satuan_nilai_normal']." </td>
        ";
        break;
    case "Lebih Besar Dari":
        echo "<td>&gt;&nbsp; ". $data['nilai_normal_lk']."&nbsp;". $show_model['satuan_nilai_normal']." </td>
        <td>&gt;&nbsp; ". $data['nilai_normal_pr']."&nbsp;". $show_model['satuan_nilai_normal']." </td>
        ";
        break;
          case "Lebih Besar Sama Dengan":
        echo "<td>&gt;=&nbsp; ". $data['nilai_normal_lk']."&nbsp;". $show_model['satuan_nilai_normal']." </td>
        <td>&gt;=&nbsp; ". $data['nilai_normal_pr']."&nbsp;". $show_model['satuan_nilai_normal']." </td>
        ";
        break;
          case "Antara Sama Dengan":
        echo "<td>". $data['nilai_normal_lk']."&nbsp;-&nbsp; ". $data['normal_lk2']."&nbsp;". $show_model['satuan_nilai_normal']." </td>
        <td>". $data['nilai_normal_pr']."&nbsp;-&nbsp; ". $data['normal_pr2']."&nbsp;". $show_model['satuan_nilai_normal']." </td>
        ";
        break;
		} 

        echo "<td style='background-color: #33b5e5;' class='edit-status' data-id='".$data['id']."'><span id='text-status-".$data['id']."'>". $data['status_abnormal'] ."</span> <input type='hidden' id='input-status-".$data['id']."' value='".$data['status_abnormal']."' class='input_status' data-id='".$data['id']."' data-status='".$data['status_abnormal']."' autofocus=''> </td>";


   echo "</tr>";
      }
  
}
    ?>
  </tbody>
 </table>
 <h6 style="text-align: left ; color: red"><i> * Klik 2x pada kolom yang berwarna Biru untuk Input Hasil Laboratorium!!</i></h6>
 </div>
</span>

<button type="submit" id="selesai" class="btn btn-success" style="font-size:15px;">Selesai</button>

<a href='cetak_laporan_hasil_lab.php' id="cetak" style="display: none;" class="btn btn-warning" target="blank"><i class="fa fa-print"></i> Cetak </a>

<a class="btn btn-danger" href="laporan_hasil_lab.php" id="kembali" style="display: none"><i class="fa fa-reply"></i> Kembali</a>

<div class="alert alert-success" id="alert_berhasil" style="display:none">
          <strong>Success!</strong> Input Hasil Laboratorium Berhasil !!
          </div>
</div>
          

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
$.post("update_hasil_lab_laporan.php",{id:id, input_nama:input_nama},function(data){

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


<script>
$(document).ready(function(){
    $('.table').DataTable();
});
</script>

<script type="text/javascript">
// untuk update status abnormal
$(document).on('dblclick','.edit-status',function(e){
  
var id = $(this).attr("data-id");
$("#text-status-"+id+"").hide();
 $("#input-status-"+id+"").attr("type", "text");

 });

$(document).on('blur','.input_status',function(e){
var nama_lama = $(this).attr("data-status");
var id = $(this).attr("data-id");
var input_nama = $(this).val();

if (input_nama == '') {
      alert('Status Harus di Isi Dahulu !!');

    $("#input-status-"+id+"").val(nama_lama);
    $("#text-status-"+id+"").text(nama_lama);
    $("#text-status-"+id+"").show();
    $("#input-status-"+id+"").attr("type", "hidden");

    }
    else
    {

// Start Proses
$.post("update_abnormal_lab_laporan.php",{id:id, input_nama:input_nama},function(data){

$("#text-status-"+id+"").show();
$("#text-status-"+id+"").text(input_nama);
$("#input-status-"+id+"").attr("type", "hidden");           
$("#input-status-"+id+"").val(input_nama);
$("#input-status-"+id+"").attr("data-status",input_nama);


});
// Finish Proses
        }
});
// ending untuk update status abnormal
</script>


<script>
   //perintah javascript yang diambil dari form proses_bayar_beli.php dengan id=form_beli
  $("#selesai").click(function(){
        var no_faktur = $("#no_faktur").val();
        

 $.post("proses_selesai_lab_akhir.php",{no_faktur:no_faktur},function(info) {

     $("#table-baru").html(info);
     var no_faktur = info;
     $("#cetak").show();
     $("#cetak").attr('href', 'cetak_laporan_hasil_lab.php?no_faktur='+no_faktur+'');

     $("#alert_berhasil").show();

     $("#no_faktur").val('');

     $("#kembali").show();
     $("#selesai").hide();
     $("#result").hide();
       
   });


 

$("form").submit(function(){
   return false;
});

});
</script>

<?php include 'footer.php'; ?>