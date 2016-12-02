<?php include 'session_login.php';
include 'header.php';
include 'navbar.php';
include 'db.php';
include 'sanitasi.php';


$user_input = $_SESSION['id'];
$no_reg = stringdoang($_GET['no_reg']);
$no_rm = stringdoang($_GET['no_rm']);
$bed = stringdoang($_GET['bed']);
$group_bed = stringdoang($_GET['kamar']);
$session_id = session_id();

$select = $db->query("SELECT nama_pelanggan FROM pelanggan WHERE kode_pelanggan = '$no_rm'");
$out = mysqli_fetch_array($select);


// start urusan kelas dan bed
$select_kelas = $db->query("SELECT kelas FROM bed WHERE nama_kamar = '$bed'");
$out_kelas = mysqli_fetch_array($select_kelas);
  // menampilkan seluruh data yang ada pada tabel suplier
          $query = $db->query("SELECT * FROM kelas_kamar");
          // menyimpan data sementara yang ada pada $query
          while($data = mysqli_fetch_array($query))
          {
         	if($out_kelas['kelas'] == $data['id'])
         	{
         		$namanya = $data['nama'];
         	}
          }
// End untuk urusan kelas dan bed



 ?>
<div class="container">

<!-- Modal Untuk Confirm Delete-->
<div id="modale-delete" class="modal fade" role="dialog">
  <div class="modal-dialog">
    <!-- Modal content-->
    <div class="modal-content">
    <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>       
    </div>
    <div class="modal-body">
      <center><h4>Apakah Anda Yakin Ingin Menghapus Data Ini ?</h4></center>

      <input type="hidden" id="id_edit" name="id_edit">
      <input type="hidden" id="or_edit" name="or_edit">
      <input type="hidden" id="sub_edit" name="sub_edit">

    </div>
    <div class="modal-footer">
        <button type="submit" data-id="" class="btn btn-success" id="yesss" >Yes</button>
        <button type="button" class="btn btn-danger" data-dismiss="modal">No</button>
    </div>
    </div>
  </div>
</div>
<!--modal end Confirm Delete-->

<h3><b>Registrasi Operasi</b></h3>

<br>
<form role="form">
<div class="row">

	<div class="col-sm-3"><!--col-sm-1-->
		<div class="form-group">
    <label for="no_rm">No RM</label>
    <input style="height: 20px;" type="text" value="<?php echo $no_rm; ?>" class="form-control" id="no_rm" name="no_rm"  readonly="" >
	</div>


<div class="form-group">
      <label for="sel1">Operasi</label><br>
    <select class="form-control chosen" id="operasi" name="operasi" autocomplete="off" required="">
          <?php 
          // menampilkan seluruh data yang ada pada tabel suplier
          $query = $db->query("SELECT * FROM operasi");
          
          // menyimpan data sementara yang ada pada $query
          while($data = mysqli_fetch_array($query))
          {
          echo "<option value='".$data['id_operasi'] ."'>".$data['nama_operasi'] ."</option>";
          }
          ?>
          </select>
          </div>

</div>
<div class="col-sm-3"><!--col-sm-2-->

	<div class="form-group">
    <label for="no_rm">No REG</label>
    <input style="height: 20px;" type="text" value="<?php echo $no_reg; ?>" class="form-control" id="no_reg" name="no_reg"  readonly="" >
	</div>

 <div class="form-group">
       <label for="sel1">Kelas Kamar</label>
    <select class="form-control chosen" id="kelas_kamar" name="kelas_kamar" autocomplete="off" required="">
    <option value="<?php echo $out_kelas['kelas'] ?>"> <?php echo $namanya; ?> </option>
          <?php 
          // menampilkan seluruh data yang ada pada tabel suplier
          $query = $db->query("SELECT * FROM kelas_kamar");
          
          // menyimpan data sementara yang ada pada $query
          while($data = mysqli_fetch_array($query))
          {
          echo "<option value='".$data['id'] ."'>".$data['nama'] ."</option>";
          }
          ?>
          </select>
          </div>


	</div><!--END col-sm-1-->

	<div class="col-sm-3"><!--col-sm-2-->

  <div class="form-group">
    <label for="no_rm">Nama Pasien</label>
    <input style="height: 20px;" type="text" value="<?php echo $out['nama_pelanggan']; ?>" class="form-control" id="nama_pasien" name="nama_pasien"  readonly="" >
  </div>


     
  <div class="form-group">
  <label for="sel1">Nama Cito</label>
<select class="form-control chosen" id="cito" name="cito" autocomplete="off" required="">
    <option value=""> Silakan Pilih Cito</option>
          <?php 
          // menampilkan seluruh data yang ada pada tabel suplier
          $query = $db->query("SELECT * FROM cito");
          
          // menyimpan data sementara yang ada pada $query
          while($data = mysqli_fetch_array($query))
          {
          echo "<option value='".$data['id'] ."'>".$data['nama'] ."</option>";
          }
          ?>
          </select>
          </div>

     
</div>


<div class="col-sm-3"><!--col-sm-2-->


<div class="form-group">
    <label for="no_rm">Kamar</label>
    <input style="height: 20px;" type="text" value="<?php echo $group_bed; ?>" class="form-control" id="kamar" name="kamar"  readonly="" >
  </div>


<!--UNTUK HIDDEN YANG SUDAH MASUK KE TBS AWAL OPERASI-->
<input type="hidden" class="form-control" name="session_id" id="session_id" value="<?php echo $session_id; ?>" readonly="">
<input type="hidden" class="form-control" name="petugas_input" id="petugas_input" value="<?php echo $user_input;?>" readonly="">

<input type="hidden" class="form-control" name="show_id_sub" id="show_id_sub" readonly="">

<!--UNTUK HIDDEN YANG SUDAH MASUK KE TBS AWAL OPERASI-->

<button id="submit_tambah" class="btn btn-info"><i class="fa fa-plus"></i> Input</button>

	</div><!--END col-sm-2-->
<br>

</div> <!--END row-->

</form>

<!--Start Table Operasi UTAMA-->
<div class="card card-block">
<h3><b><center>Data Operasi</center></b></h3>
<span id="table_baru">  
<div class="table-responsive">
  <table id="table-pelamar" class="table table-bordered table-sm">
 
  <thead>
    <tr>

      <th style='background-color: #4CAF50; color: white'>No REG</th>
      <th style='background-color: #4CAF50; color: white'>Operasi</th>
      <th style='background-color: #4CAF50; color: white'>Harga Jual</th>
      <th style='background-color: #4CAF50; color: white'>Petugas Input</th>
      <th style='background-color: #4CAF50; color: white'>Waktu</th>
      <th style='background-color: #4CAF50; color: white'>Detail</th>
      <th style='background-color: #4CAF50; color: white'>Hapus</th>

  </tr>
  </thead>
  <tbody id="tbody">
  
   <?php 
   $utama = $db->query("SELECT * FROM tbs_operasi WHERE no_reg = '$no_reg'");
   while($next = mysqli_fetch_array($utama))      
    {
       // ambil nama operasi
      $select_op = $db->query("SELECT nama_operasi,id_operasi FROM operasi ");
      while($get_nama = mysqli_fetch_array($select_op))
      {
        if ($next['operasi'] == $get_nama['id_operasi'])
        {
          $nama_operasinya = $get_nama['nama_operasi'];
        }
      }

      // ambil nama user

      $select_user = $db->query("SELECT nama,id FROM user ");
      while($use = mysqli_fetch_array($select_user))
      {
        if ($next['petugas_input'] == $use['id'])
        {
        $nama_user = $use['nama'];
        }
      }
    echo "<tr class='tr-id-".$next['id']."'>

        <td>". $next['no_reg']."</td>
        <td>". $nama_operasinya."</td>
        <td>Rp. ". rp($next['harga_jual'])."</td>
        <td>". $nama_user."</td>
        <td>". $next['waktu']."</td>";

// cek data di detail agar sama 
$cek_detail = $db->query("SELECT * FROM tbs_detail_operasi WHERE (no_reg = '$no_reg' AND id_tbs_operasi = '$next[id]') OR (no_reg = '$no_reg' AND id_tbs_operasi = '$next[id_tbs_lama]') ");
$out_detail = mysqli_num_rows($cek_detail);

if($out_detail > 0)
{

echo "<td><a href='proses_registrasi_operasi.php?id=".$next["id"]."&no_reg=".$next["no_reg"]."&sub_operasi=".$next["sub_operasi"]."&operasi=".$next["operasi"]."' class='btn btn-warning'><i class='fa fa-plus'></i> </a></td>";

}
else
{

echo "<td><a href='proses_registrasi_operasi.php?id=".$next["id"]."&no_reg=".$next["no_reg"]."&sub_operasi=".$next["sub_operasi"]."&operasi=".$next["operasi"]."' class='btn btn-success'><i class='fa fa-chevron-right'></i> </a></td>";
}
   echo" <td><button data-id='".$next['id']."' data-operasi='".$next['operasi']."' data-sub-operasi='".$next['sub_operasi']."'  class='btn btn-danger delete'><i class='fa fa-trash'></i> </button>
    </td>
    </tr>";
    }


  ?>
  </tbody>
 </table>
 </div>
</span>
</div>

<!--Ending Table Operasi UTAMA-->
<h6 style="text-align: left ; color: blue"><i> * (>) Untuk meng-input detail </i></h6>
<h6 style="text-align: left ; color: red"><i> * (+) Untuk menambah detail </i></h6>



</div><!--div class container closed-->

<!--Start Script CHANGE-->
<script type="text/javascript">
$(document).ready(function(){
  $("#cito").change(function(){

// in form
  var operasi = $("#operasi").val();
  var kelas_kamar = $("#kelas_kamar").val();
  var cito = $("#cito").val();
// post proses
  $.post('cek_operasi.php',{operasi:operasi,cito:cito,kelas_kamar:kelas_kamar},function(info)

  {
   info = info.replace(/\s+/g, '');
  $("#show_id_sub").val(info);
   
  if(info == '')
  {
    alert("Data Operasi Tidak ada!");
    $("#submit_tambah").hide();

    $("#cito").chosen("destroy");
    $("#cito").val("");
    $("#cito").chosen();

  }
  else
  {
    $("#submit_tambah").show();

  }


  });

});
 });           
   $('form').submit(function(){
    return false;
    });

</script>
<!--Ending Script CHANGE-->


<!--Start Script Tambah-->
<script type="text/javascript">
  $("#submit_tambah").click(function(){

// in form
  var no_reg = $("#no_reg").val();
  var operasi = $("#operasi").val();
  var kelas_kamar = $("#kelas_kamar").val();
  var petugas_input = $("#petugas_input").val();
  var session_id = $("#session_id").val();
  var cito = $("#cito").val();

$.post('cek_operasi.php',{operasi:operasi,cito:cito,kelas_kamar:kelas_kamar},function(info)
  {
   info = info.replace(/\s+/g, '');
  $("#show_id_sub").val(info);
   
  if(info == '')
  {
    alert("Data Operasi Tidak ada!");
    $("#cito").chosen("destroy");
    $("#cito").val("");
    $("#cito").chosen();

  }
  else
  {

 $.post('proses_awal_operasi.php',{session_id:session_id,operasi:operasi,cito:cito,kelas_kamar:kelas_kamar,petugas_input:petugas_input,no_reg:no_reg},function(data){
  $("#tbody").prepend(data);

  });

  }
// post proses
 

});
 });           
   $('form').submit(function(){
    return false;
    });

</script>
<!--Ending Script Tambah-->



      <script type="text/javascript">
      
      $(".chosen").chosen({no_results_text: "Maaf, Data Tidak Ada!"});  
      
      </script>



<!--   script modal confirmasi delete -->
<script type="text/javascript">
$(".delete").click(function(){

  var id = $(this).attr('data-id');
  var operasi = $(this).attr('data-operasi');
  var sub = $(this).attr('data-sub-operasi');

  $("#modale-delete").modal('show');
  $("#id_edit").val(id);
  $("#or_edit").val(operasi);  
  $("#sub_edit").val(sub);  

});


</script>
<!--   end script modal confiormasi dellete -->


<!--  script modal  lanjkutan confiormasi delete -->
<script type="text/javascript">
$("#yesss").click(function(){

var id = $("#id_edit").val();
var or = $("#or_edit").val();
var sub = $("#sub_edit").val();

$.post('delete_registrasi_operasi.php',{id:id,or:or,sub:sub},function(data){
    
      $("#modale-delete").modal('hide');
      $(".tr-id-"+id+"").remove();
  

    });

});
</script>
<!--  end modal confirmasi delete lanjutan  -->

<script>

$(document).ready(function(){
    $('.table').DataTable();
});

</script>

<?php include 'footer.php'; ?>