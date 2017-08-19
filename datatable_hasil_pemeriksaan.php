<?php include 'session_login.php';
/* Database connection start */
include 'sanitasi.php';
include 'db.php';

/* Database connection end */

$no_reg = stringdoang($_POST['no_reg']);
$no_rm = stringdoang($_POST['no_rm']);

$query_jenis_kelamin = $db->query("SELECT jenis_kelamin FROM registrasi WHERE no_rm = '$no_rm' AND no_reg = '$no_reg'");
$data_jenis_kelamin = mysqli_fetch_array($query_jenis_kelamin);
$jenis_kelamin = $data_jenis_kelamin['jenis_kelamin'];

// stori
 ?>

<span id="result">
<div class="table-responsive">
  <table id="table-baru" class="table table-bordered table-sm">

    <thead>
      <tr>

    <th style='background-color: #4CAF50; color: white;' >Nama Pemeriksaan</th>
    <th style='background-color: #4CAF50; color: white;' >Hasil Pemeriksaan</th>
    <th style='background-color: #4CAF50; color: white;' >Nilai Normal</th>
    <th style='background-color: #4CAF50; color: white;' >Dokter</th>
    <th style='background-color: #4CAF50; color: white;' >Analis</th>
  

    </tr>
    </thead>
    <tbody id="tbody">
    
   <?php 
  $query = $db->query("SELECT th.normal_lk2, th.normal_pr2, th.id_sub_header AS nama_header,th.no_rm,th.harga,th.no_reg,th.kode_barang,th.dokter AS id_dokter,th.analis AS id_analis,th.id,th.nama_pemeriksaan,th.hasil_pemeriksaan,th.model_hitung,th.nilai_normal_lk,th.satuan_nilai_normal,th.nilai_normal_pr,u.nama AS dokter,us.nama AS analis FROM tbs_hasil_lab th LEFT JOIN user u ON 
    th.dokter = u.id LEFT JOIN user us ON th.analis = us.id WHERE 
    no_reg = '$no_reg' AND no_rm = '$no_rm' ORDER BY id ASC");
   while($data = mysqli_fetch_array($query)){

    echo "<tr class='tr-id-".$data['id']."'>";

    echo "<td>". $data['nama_pemeriksaan'] ." </td>";

    if ($data['hasil_pemeriksaan'] == ''){

      echo "<td style='background-color:#90caf9;cursor:pointer;' class='edit-nama' data-id='".$data['id']."'><span id='text-nama-".$data['id']."'>". $data['hasil_pemeriksaan'] ."</span> <input type='text' id='input-nama-".$data['id']."' value='".$data['hasil_pemeriksaan']."' style='background-color:white;' class='input_nama' data-id='".$data['id']."' data-nama='".$data['hasil_pemeriksaan']."' autofocus=''> </td>";
    }
    else{
          echo "<td style='background-color:#90caf9;cursor:pointer;' class='edit-nama' data-id='".$data['id']."'><span id='text-nama-".$data['id']."'>". $data['hasil_pemeriksaan'] ."</span> <input type='hidden' id='input-nama-".$data['id']."' value='".$data['hasil_pemeriksaan']."' class='input_nama' data-id='".$data['id']."' data-nama='".$data['hasil_pemeriksaan']."' autofocus=''> </td>";
      }

$model_hitung = $data['model_hitung']; 
if($model_hitung == ''){
  echo "<td>&nbsp; ". '-' ." </td>
       
        ";
}
else{
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
       
    //Start Dokter
    /*
    echo "<td class='edit-dokter' data-id='".$data['id']."'>
    <span id='text-dokter-".$data['id']."'>". $data['dokter'] ."</span>
    <select style='display:none' id='input-dokter-".$data['id']."' value='".$data['dokter']."' class='input_dokter' data-id='".$data['id']."' data-nama='".$data['dokter']."' autofocus=''>";



    $query01 = $db->query("SELECT nama,id FROM user WHERE tipe = '1'");
    while($data01 = mysqli_fetch_array($query01)){
      if ($data01['nama'] == $data['id_dokter']) {
        echo "<option selected value='".$data01['id'] ."'>".$data01['nama'] ."</option>";
      }
      else{
      echo "<option value='".$data01['id'] ."'>".$data01['nama'] ."</option>";
      }    
    }
        
    echo  '
    </select>
    </td>';
        */
    //End Dokter
    
    
    echo "<td>". $data['dokter'] ."</td>";

    //Start Analis
    echo "<td class='edit-analis' data-id='".$data['id']."'>
    <span id='text-analis-".$data['id']."'>". $data['analis'] ."</span>
    <select style='display:none' id='input-analis-".$data['id']."' value='".$data['analis']."' class='input_analis' data-id='".$data['id']."' data-nama='".$data['analis']."' data-rm='".$data['no_rm']."' data-reg='".$data['no_reg']."' data-kode='".$data['kode_barang']."' data-harga='".$data['harga']."' data-nama-pemeriksaan='".$data['nama_pemeriksaan']."' data-nama-header='".$data['nama_header']."' data-analis='".$data['id_analis']."' data- autofocus=''>";

    $query01 = $db->query("SELECT nama,id FROM user WHERE tipe = '6'");
    while($data01 = mysqli_fetch_array($query01)){
      if ($data01['nama'] == $data['id_analis']) {
        echo "<option selected value='".$data01['id'] ."'>".$data01['nama'] ."</option>";
      }
      else{
      echo "<option value='".$data01['id'] ."'>".$data01['nama'] ."</option>";
      }    
    }
        
    echo  '
    </select>
    </td>';//End Analis



   echo "</tr>";
      
  
}
    ?>
  </tbody>
 </table>
 <h6 style="text-align: left ; color: red"><i> * Klik 2x pada kolom yang berwarna Biru untuk Input Hasil Laboratorium!!</i></h6>
 </div>
</span>

<script type="text/javascript">
  $(document).ready(function(){
    $('#table-baru').DataTable(
      {"ordering": false});
  });
</script>

