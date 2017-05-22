<?php include 'session_login.php';

include 'sanitasi.php';
include 'db.php';

$no_faktur = $_POST['no_faktur'];
$no_reg = $_POST['no_reg'];

$select = $db->query("SELECT no_faktur,no_rm,no_reg,nama_pasien,petugas_analis,dokter,tanggal FROM hasil_lab WHERE no_faktur = '$no_faktur' AND status = 'Selesai'");
$out = mysqli_fetch_array($select);

$select_bio = $db->query("SELECT jenis_kelamin,umur_pasien,alamat_pasien FROM registrasi WHERE no_rm = '$out[no_rm]' AND no_reg = '$out[no_reg]'");
$show_bio = mysqli_fetch_array($select_bio);
$umur = $show_bio['umur_pasien'];
$alamat = $show_bio['alamat_pasien'];
$jenis_kelamin = $show_bio['jenis_kelamin'];

?>

<div class="container">       
  <div class="table-responsive"> 
    <table id="tabel-lab" class="table table-hover table-sm">
      <thead>

        <th> Nama Pemeriksaan </th>
        <th> Hasil Pemeriksaan </th>
        <th> Nilai Normal  </th>
        <th> Status Rawat </th>
           
      </thead>
        
      <tbody>
<?php

$selectui = $db->query("SELECT id_sub_header FROM hasil_lab WHERE no_faktur = '$no_faktur' AND status = 'Selesai' AND (id_sub_header != 0 OR id_sub_header != '') GROUP BY id_sub_header");
while($trace = mysqli_fetch_array($selectui)){

  $select = $db->query("SELECT id,nama_pemeriksaan FROM setup_hasil WHERE id = '$trace[id_sub_header]' AND kategori_index = 'Header'");
  $drop = mysqli_fetch_array($select);
  $face_drop = mysqli_num_rows($select);

  $id_set_up = $drop['nama_pemeriksaan'];
  $id_get = $drop['id'];

  $get_name = $db->query("SELECT nama FROM jasa_lab WHERE id = '$id_set_up' GROUP BY id");
  $get = mysqli_fetch_array($get_name);
  $name_sub_header = $get['nama'];
                //menampilkan data
    
  $show = $db->query("SELECT * FROM hasil_lab WHERE no_faktur = '$no_faktur' AND status = 'Selesai' AND (id_sub_header != 0 OR id_sub_header != '')");
  $drop_show = mysqli_fetch_array($show);

  if($face_drop >= 1){

    $hitung_baris = 0;
    echo "
    <tr>";

    if($hitung_baris != 0){
          $name_sub_header = '';
    }
      $hitung_baris++;

    echo "<td><b>".$name_sub_header."</b></td>
          <td><center>-</center></td>
          <td><center>-</center></td>
          <td><center>-</center></td>";

    echo " </tr>";

    $query_hasil_lab = $db->query("SELECT id, nama_pemeriksaan, hasil_pemeriksaan, model_hitung, nilai_normal_lk2, nilai_normal_lk, nilai_normal_pr2, nilai_normal_pr, satuan_nilai_normal, status_pasien FROM hasil_lab WHERE no_faktur = '$no_faktur' AND status = 'Selesai' AND id_sub_header = '$id_get' AND (id_sub_header != 0 OR id_sub_header != '')");
            //menyimpan data sementara yang ada pada $perintah
      while ($data_hasil_lab = mysqli_fetch_array($query_hasil_lab)){

      echo "<tr>";
      echo "<td>  <li> ". $data_hasil_lab['nama_pemeriksaan'] ."</li></td>";
      echo "<td class='edit-nama' data-id='".$data_hasil_lab['id']."'><span id='text-nama-".$data_hasil_lab['id']."'>". $data_hasil_lab['hasil_pemeriksaan'] ."</span> <input type='hidden' id='input-nama-".$data_hasil_lab['id']."' value='".$data_hasil_lab['hasil_pemeriksaan']."' class='input_nama' data-id='".$data_hasil_lab['id']."' data-nama='".$data_hasil_lab['hasil_pemeriksaan']."' autofocus=''> </td>";

        $model_hitung = $data_hasil_lab['model_hitung']; 
        if($model_hitung == ''){
            echo "
            <td>&nbsp; ". '-' ." </td>
            ";
        }
        else{

          if($jenis_kelamin == 'laki-laki'){
            switch ($model_hitung) {

            case "Lebih Kecil Dari":
            echo "<td>&lt;&nbsp; ". $data_hasil_lab['nilai_normal_lk']."&nbsp;". $data_hasil_lab['satuan_nilai_normal']." </td>";
              break;

            case "Lebih Kecil Sama Dengan":
            echo "<td>&lt;=&nbsp; ". $data_hasil_lab['nilai_normal_lk']."&nbsp;". $data_hasil_lab['satuan_nilai_normal']." </td>";
            break;

            case "Lebih Besar Dari":
            echo "<td>&gt;&nbsp; ". $data_hasil_lab['nilai_normal_lk']."&nbsp;". $data_hasil_lab['satuan_nilai_normal']." </td>";
            break;
          
            case "Lebih Besar Sama Dengan":
            echo "<td>&gt;=&nbsp; ". $data_hasil_lab['nilai_normal_lk']."&nbsp;". $data_hasil_lab['satuan_nilai_normal']." </td>";
            break;
          
            case "Antara Sama Dengan":
            echo "<td>". $data_hasil_lab['nilai_normal_lk']."&nbsp;-&nbsp; ". $data_hasil_lab['nilai_normal_lk2']."&nbsp;". $data_hasil_lab['satuan_nilai_normal']." </td>";
            break;

            //Text
            case "Text":
            echo "<td>&nbsp; ". $data_hasil_lab['nilai_normal_lk']."&nbsp;". $data_hasil_lab['satuan_nilai_normal']." </td>
            ";
            break;
            //End Text
            } 
          }
          else{
            switch ($model_hitung) {

              case "Lebih Kecil Dari":
              echo "
              <td>&lt;&nbsp; ". $data_hasil_lab['nilai_normal_pr']."&nbsp;". $data_hasil_lab['satuan_nilai_normal']." </td>";
              break;

              case "Lebih Kecil Sama Dengan":
              echo "
              <td>&lt;=&nbsp; ". $data_hasil_lab['nilai_normal_pr']."&nbsp;". $data_hasil_lab['satuan_nilai_normal']." </td>";
              break;

              case "Lebih Besar Dari":
              echo "
              <td>&gt;&nbsp; ". $data_hasil_lab['nilai_normal_pr']."&nbsp;". $data_hasil_lab['satuan_nilai_normal']." </td>";
              break;
                    
              case "Lebih Besar Sama Dengan":
              echo "
              <td>&gt;=&nbsp; ". $data_hasil_lab['nilai_normal_pr']."&nbsp;". $data_hasil_lab['satuan_nilai_normal']." </td>";
              break;
              
              case "Antara Sama Dengan":
              echo "
              <td>". $data_hasil_lab['nilai_normal_pr']."&nbsp;-&nbsp; ". $data_hasil_lab['nilai_normal_pr2']."&nbsp;". $data_hasil_lab['satuan_nilai_normal']." </td>";
              break;

              //Text
              case "Text":
              echo "
              <td>&nbsp; ". $data_hasil_lab['nilai_normal_pr']."&nbsp;". $data_hasil_lab['satuan_nilai_normal']." </td>";
              break;
              //End Text

            } 
          }
        }  

        echo " <td>". $data_hasil_lab['status_pasien'] ."</td>
        </tr>";

      } //END WHILE $data_hasil_lab
  } //END IF UNTUK DATA LABORATORIUM YANG ADA HEADER / INDUX
} //WHILE $trace


//start untuk yang sendirian / yang tidak ber HEADER/INDUX
$query_hasil_lab_tunggal = $db->query("SELECT id, nama_pemeriksaan, hasil_pemeriksaan, model_hitung, nilai_normal_lk2, nilai_normal_lk, nilai_normal_pr2, nilai_normal_pr, satuan_nilai_normal, status_pasien FROM hasil_lab WHERE no_faktur = '$no_faktur' AND status = 'Selesai' AND (id_sub_header = 0 OR id_sub_header IS NULL)");
            //menyimpan data sementara yang ada pada $perintah
  
while ($data_hasil_lab_tunggal = mysqli_fetch_array($query_hasil_lab_tunggal)){
  echo "<tr>";
  echo "<td><b> ".$data_hasil_lab_tunggal['nama_pemeriksaan']."</b></td>";

  echo"<td class='edit-nama' data-id='".$data_hasil_lab_tunggal['id']."'><span id='text-nama-".$data_hasil_lab_tunggal['id']."'>". $data_hasil_lab_tunggal['hasil_pemeriksaan'] ."</span> <input type='hidden' id='input-nama-".$data_hasil_lab_tunggal['id']."' value='".$data_hasil_lab_tunggal['hasil_pemeriksaan']."' class='input_nama' data-id='".$data_hasil_lab_tunggal['id']."' data-nama='".$data_hasil_lab_tunggal['hasil_pemeriksaan']."' autofocus=''> </td>";


  $model_hitung = $data_hasil_lab_tunggal['model_hitung']; 
  if($model_hitung == ''){
    echo "<td>&nbsp; ". '-' ." </td>";
  }
  else{
    
    if($jenis_kelamin == 'laki-laki'){
      switch ($model_hitung) {
        case "Lebih Kecil Dari":
        echo "<td>&lt;&nbsp; ". $data_hasil_lab_tunggal['nilai_normal_lk']."&nbsp;". $data_hasil_lab_tunggal['satuan_nilai_normal']." </td>";
        break;

        case "Lebih Kecil Sama Dengan":
        echo "<td>&lt;=&nbsp; ". $data_hasil_lab_tunggal['nilai_normal_lk']."&nbsp;". $data_hasil_lab_tunggal['satuan_nilai_normal']." </td>";
        break;

        case "Lebih Besar Dari":
        echo "<td>&gt;&nbsp; ". $data_hasil_lab_tunggal['nilai_normal_lk']."&nbsp;". $data_hasil_lab_tunggal['satuan_nilai_normal']." </td>";
        break;
          
        case "Lebih Besar Sama Dengan":
        echo "<td>&gt;=&nbsp; ". $data_hasil_lab_tunggal['nilai_normal_lk']."&nbsp;". $data_hasil_lab_tunggal['satuan_nilai_normal']." </td>";
        break;
          
        case "Antara Sama Dengan":
        echo "<td>". $data_hasil_lab_tunggal['nilai_normal_lk']."&nbsp;-&nbsp; ". $data_hasil_lab_tunggal['nilai_normal_lk2']."&nbsp;". $data_hasil_lab_tunggal['satuan_nilai_normal']." </td>";
        break;

        //Text
        case "Text":
        echo "<td>&nbsp; ". $data_hasil_lab_tunggal['nilai_normal_lk']."&nbsp;". $data_hasil_lab_tunggal['satuan_nilai_normal']." </td>";
        break;
        //End Text
        } 
    }
    else{
      switch ($model_hitung) {
        case "Lebih Kecil Dari":
        echo "
        <td>&lt;&nbsp; ". $data_hasil_lab_tunggal['nilai_normal_pr']."&nbsp;". $data_hasil_lab_tunggal['satuan_nilai_normal']." </td>";
        break;

        case "Lebih Kecil Sama Dengan":
        echo "
        <td>&lt;=&nbsp; ". $data_hasil_lab_tunggal['nilai_normal_pr']."&nbsp;". $data_hasil_lab_tunggal['satuan_nilai_normal']." </td>";
        break;

        case "Lebih Besar Dari":
        echo "
        <td>&gt;&nbsp; ". $data_hasil_lab_tunggal['nilai_normal_pr']."&nbsp;". $data_hasil_lab_tunggal['satuan_nilai_normal']." </td>";
        break;
                  
        case "Lebih Besar Sama Dengan":
        echo "
        <td>&gt;=&nbsp; ". $data_hasil_lab_tunggal['nilai_normal_pr']."&nbsp;". $data_hasil_lab_tunggal['satuan_nilai_normal']." </td>";
        break;
            
        case "Antara Sama Dengan":
        echo "
        <td>". $data_hasil_lab_tunggal['nilai_normal_pr']."&nbsp;-&nbsp; ". $data_hasil_lab_tunggal['nilai_normal_pr2']."&nbsp;". $data_hasil_lab_tunggal['satuan_nilai_normal']." </td>";
        break;

        //Text
        case "Text":
        echo "
        <td>&nbsp; ". $data_hasil_lab_tunggal['nilai_normal_pr']."&nbsp;". $data_hasil_lab_tunggal['satuan_nilai_normal']." </td>";
        break;
        //End Text

      } 
    }
  }  
      echo " 
      <td>". $data_hasil_lab_tunggal['status_pasien'] ."</td>
      </tr>";
} //END WHILE $data_hasil_lab_tunggal
//ending untuk yang sendirian / yang tidak ber HEADER/INDUX

mysqli_close($db); 
?>
      </tbody>
    </table>
  </div>
</div>

<script type="text/javascript">
  $(document).ready(function(){
    $('#tabel-lab').DataTable(
      {"ordering": false});
  });
</script>