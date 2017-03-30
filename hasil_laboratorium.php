<?php include_once 'session_login.php';
// memasukan file session login,  header, navbar, db.php,
include 'header.php';
include 'navbar.php';
include 'db.php';
include 'sanitasi.php';

$nama = stringdoang($_GET['nama']);
$no_rm = stringdoang($_GET['no_rm']);
$no_reg = stringdoang($_GET['no_reg']);
$jenis_penjualan = stringdoang($_GET['jenis_penjualan']);

$take_gander = $db->query("SELECT jenis_kelamin FROM registrasi WHERE no_rm = '$no_rm' AND no_reg = '$no_reg'");
$out_gander = mysqli_fetch_array($take_gander);
$jenis_kelamin = $out_gander['jenis_kelamin'];

?>
<div class="container">
<h3>FORM HASIL LABORATORIUM</h3><hr>



 <table>
  <tbody>

    <tr><td width="50%"><font class="satu">No RM</font></td> <td> :&nbsp;</td> <td><font class="satu"> <?php echo $no_rm; ?> </font></tr>

    <tr><td width="50%"><font class="satu">No REG</font></td> <td> :&nbsp;</td> <td><font class="satu"> <?php echo $no_reg; ?> </font></tr>

    <tr><td width="50%"><font class="satu">Nama</font></td> <td> :&nbsp;</td> <td><font class="satu"> <?php echo $nama; ?> </font></tr>

	<tr><td width="50%"><font class="satu">Jenis Penjualan</font></td> <td> :&nbsp;</td> <td><font class="satu"> <?php echo $jenis_penjualan; ?> </font></tr>

  </tbody>
</table>
<br>

<form  role="form" >

<input style="height: 20px" type="hidden"  class="form-control" id="no_rm" value="<?php echo $no_rm; ?>"  autocomplete="off">
<input style="height: 20px" type="hidden"  class="form-control" id="no_reg" value="<?php echo $no_reg; ?>"  autocomplete="off">
<input style="height: 20px" type="hidden"  class="form-control" id="nama" value="<?php echo $nama; ?>"  autocomplete="off">
<input style="height: 20px" type="hidden"  class="form-control" id="jenis_penjualan" value="<?php echo $jenis_penjualan; ?>"  autocomplete="off">

<div class="row">
  
<span id="petugasnya">
<div class="form-group col-xs-3">
       <label for="penjamin"><b>Petugas Analis</b></label><br>
         <select type="text" class="form-control chosen" id="analis" autocomplete="off">        

         <?php 
         $query09 = $db->query("SELECT nama,id FROM user WHERE tipe = '2' ");
         while ( $data09 = mysqli_fetch_array($query09)) {

          echo "<option value='".$data09['id'] ."'>".$data09['nama'] ."</option>";

         }
         ?>

      
        </select> 
</div>


<div class="col-xs-3">
          <label> <b>Dokter </b></label><br>
          
          <select name="dokter" id="dokter" class="form-control chosen" required="" >
          <?php 
        //untuk menampilkan semua data pada tabel pelanggan dalam DB
    $query01 = $db->query("SELECT nama,id FROM user WHERE tipe = '1'");

    //untuk menyimpan data sementara yang ada pada $query
    while($data01 = mysqli_fetch_array($query01))
    {
    

    if ($data01['nama'] == $dokter) {
     echo "<option selected value='".$data01['id'] ."'>".$data01['nama'] ."</option>";
    }
    else{
      echo "<option value='".$data01['id'] ."'>".$data01['nama'] ."</option>";
    }

    
    }
?>
  </select>
</div>
</span>
</div><!--div close row-->

</form>

<span id="result">
<div class="table-responsive">
  <table id="table-baru" class="table table-bordered table-sm">

    <thead>
      <tr>

        <th style='background-color: #4CAF50; color: white;' >Nama Pemeriksaan</th>
        <th style='background-color: #4CAF50; color: white;' >Hasil Pemeriksaan</th>
        <th style='background-color: #4CAF50; color: white;' >Nilai Normal</th>
          <!--<th style='background-color: #4CAF50; color: white;' >Nilai Wanita</th>
          <th style='background-color: #4CAF50; color: white;' >Normal / Tidak Normal</th>-->

    </tr>
    </thead>
    <tbody id="tbody">
    
   <?php 
$query = $db->query("SELECT * FROM tbs_hasil_lab WHERE no_reg = '$no_reg' AND no_rm = '$no_rm' ORDER BY id ASC");
   while($data = mysqli_fetch_array($query))      
      {

      echo "<tr class='tr-id-".$data['id']."'>";

     echo "<td>". $data['nama_pemeriksaan'] ." </td>";

    if ($data['hasil_pemeriksaan'] == '')
      {
      echo "<td style='background-color:#90caf9;cursor:pointer;' class='edit-nama' data-id='".$data['id']."'><span id='text-nama-".$data['id']."'>". $data['hasil_pemeriksaan'] ."</span> <input type='text' id='input-nama-".$data['id']."' value='".$data['hasil_pemeriksaan']."' style='background-color:white;' class='input_nama' data-id='".$data['id']."' data-nama='".$data['hasil_pemeriksaan']."' autofocus=''> </td>";
    }
    else
      {
          echo "<td style='background-color:#90caf9;cursor:pointer;' class='edit-nama' data-id='".$data['id']."'><span id='text-nama-".$data['id']."'>". $data['hasil_pemeriksaan'] ."</span> <input type='hidden' id='input-nama-".$data['id']."' value='".$data['hasil_pemeriksaan']."' class='input_nama' data-id='".$data['id']."' data-nama='".$data['hasil_pemeriksaan']."' autofocus=''> </td>";
      }

$model_hitung = $data['model_hitung']; 
if($model_hitung == '')
{
  echo "<td>&nbsp; ". '-' ." </td>
       
        ";
}
else
{
  if($jenis_kelamin == 'laki-laki'){
    switch ($model_hitung) {
    case "Lebih Kecil Dari":
        echo "<td>&lt;&nbsp; ". $data['nilai_normal_lk']."&nbsp;". $data['satuan_nilai_normal']." </td>
        ";
        break;
    case "Lebih Kecil Sama Dengan":
        echo "<td>&lt;=&nbsp; ". $data['nilai_normal_lk']."&nbsp;". $data['satuan_nilai_normal']." </td>
        ";
        break;
    case "Lebih Besar Dari":
        echo "<td>&gt;&nbsp; ". $data['nilai_normal_lk']."&nbsp;". $data['satuan_nilai_normal']." </td>
        ";
        break;
          case "Lebih Besar Sama Dengan":
        echo "<td>&gt;=&nbsp; ". $data['nilai_normal_lk']."&nbsp;". $data['satuan_nilai_normal']." </td>
        ";
        break;
          case "Antara Sama Dengan":
        echo "<td>". $data['nilai_normal_lk']."&nbsp;-&nbsp; ". $data['normal_lk2']."&nbsp;". $data['satuan_nilai_normal']." </td>
        ";
        break;

        //Text
        case "Text":
        echo "<td>&nbsp; ". $data['nilai_normal_lk']."&nbsp;". $data['satuan_nilai_normal']." </td>
        ";
        break;
        //End Text
    } 
  }
  else{
    switch ($model_hitung) {
    case "Lebih Kecil Dari":
        echo "
        <td>&lt;&nbsp; ". $data['nilai_normal_pr']."&nbsp;". $data['satuan_nilai_normal']." </td>
        ";
        break;
    case "Lebih Kecil Sama Dengan":
        echo "
        <td>&lt;=&nbsp; ". $data['nilai_normal_pr']."&nbsp;". $data['satuan_nilai_normal']." </td>
        ";
        break;
    case "Lebih Besar Dari":
        echo "
        <td>&gt;&nbsp; ". $data['nilai_normal_pr']."&nbsp;". $data['satuan_nilai_normal']." </td>
        ";
        break;
          case "Lebih Besar Sama Dengan":
        echo "
        <td>&gt;=&nbsp; ". $data['nilai_normal_pr']."&nbsp;". $data['satuan_nilai_normal']." </td>
        ";
        break;
          case "Antara Sama Dengan":
        echo "
        <td>". $data['nilai_normal_pr']."&nbsp;-&nbsp; ". $data['normal_pr2']."&nbsp;". $data['satuan_nilai_normal']." </td>
        ";
        break;

        //Text
        case "Text":
        echo "
        <td>&nbsp; ". $data['nilai_normal_pr']."&nbsp;". $data['satuan_nilai_normal']." </td>
        ";
        break;
        //End Text
    } 
  }

}
        /*echo "<td style='background-color: #33b5e5;' class='edit-status' data-id='".$data['id']."'><span id='text-status-".$data['id']."'>". $data['status_abnormal'] ."</span> <input type='hidden' id='input-status-".$data['id']."' value='".$data['status_abnormal']."' class='input_status' data-id='".$data['id']."' data-status='".$data['status_abnormal']."' autofocus=''> </td>";*/


   echo "</tr>";
      
  
}
    ?>
  </tbody>
 </table>
 <h6 style="text-align: left ; color: red"><i> * Klik 2x pada kolom yang berwarna Biru untuk Input Hasil Laboratorium!!</i></h6>
 </div>
</span>

<?php 

 ?>
<button type="submit" id="selesai" class="btn btn-success" style="font-size:15px;">Selesai</button>

<a href='cetak_hasil_lab.php' id="cetak" style="display: none;" class="btn btn-warning" target="blank"><i class="fa fa-print"></i> Cetak </a>

<?php if ($jenis_penjualan == 'Rawat Jalan'): ?>
  <button class="btn btn-danger" style="display: none;" id="kembali"> <i class="fa fa-reply-all"></i> Kembali  </button> 
<?php endif ?>

<?php if ($jenis_penjualan == 'UGD'): ?>
  <button class="btn btn-danger" style="display: none;" id="kembali_ugd"> <i class="fa fa-reply-all"></i> Kembali  </button>
<?php endif ?>

<div class="alert alert-success" id="alert_berhasil" style="display:none">
          <strong>Success!</strong> Input Hasil Laboratorium Berhasil !!
          </div>
</div>
          

<script type="text/javascript">
$(document).on('click','#kembali',function(e){
    window.location.href="pasien_sudah_masuk.php";
});

$(document).on('click','#kembali_ugd',function(e){
    window.location.href="registrasi_ugd.php";
});  
</script>



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
$.post("update_data_laboratorium.php",{id:id, input_nama:input_nama},function(data){

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


<!--<script type="text/javascript">

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
      alert('Status Ab-Normal Harus di Isi Dahulu !!');

    $("#input-status-"+id+"").val(nama_lama);
    $("#text-status-"+id+"").text(nama_lama);
    $("#text-status-"+id+"").show();
    $("#input-status-"+id+"").attr("type", "hidden");

    }
    else
    {

// Start Proses
$.post("update_status_abnormal_lab.php",{id:id, input_nama:input_nama},function(data){

$("#text-status-"+id+"").show();
$("#text-status-"+id+"").text(input_nama);
$("#input-status-"+id+"").attr("type", "hidden");           
$("#input-status-"+id+"").val(input_nama);
$("#input-status-"+id+"").attr("data-status",input_nama);


});
        }
});
</script>-->

      <script type="text/javascript">
      
      $(".chosen").chosen({no_results_text: "Maaf, Data Tidak Ada!"});  
      
      </script>

<script>
   //perintah javascript yang diambil dari form proses_bayar_beli.php dengan id=form_beli
  $("#selesai").click(function(){
        var no_rm = $("#no_rm").val();
        var no_reg = $("#no_reg").val();
        var nama = $("#nama").val();
        var jenis_penjualan = $("#jenis_penjualan").val();
        var dokter = $("#dokter").val();
        var analis = $("#analis").val();

$.post("cek_pemeriksaan_sementara.php",{no_reg:no_reg},function(data) {
if(data == 1){
  alert("Data Hasil Laboratorium Tidak Boleh Kosong, Silahkan Anda Isi Terlebih Dahulu !!");
}
else
{

 $.post("proses_selesai_lab.php",{no_rm:no_rm,no_reg:no_reg,nama:nama,jenis_penjualan:jenis_penjualan,dokter:dokter,analis:analis},function(info) {


     //$("#table-baru").html(info);
     var no_reg = info;
     $("#cetak").show();
     $("#cetak").attr('href', 'cetak_hasil_lab.php?no_reg='+no_reg+'');

     $("#alert_berhasil").show();

     $("#no_rm").val('');
     
     $("#nama").val('');
     
      $("#kembali_ugd").show();
    if(jenis_penjualan == 'UGD')
    {
      $("#kembali_ugd").show();
    }else{
      $("#kembali").show();
    }
    
    

     $("#selesai").hide();
     $("#result").hide();
     $("#petugasnya").hide();
   });

}
}); 

$("form").submit(function(){
   return false;
});

});
</script>

<?php include 'footer.php'; ?>