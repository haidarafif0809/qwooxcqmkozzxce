<?php 
include 'db.php';
include 'sanitasi.php';

$penjamin = stringdoang($_POST['penjamin']);

?>
<span class="span-hapus-option">

<select type="text" name="kode_pelanggan" id="kd_pelanggan" class="form-control chosen" required="">
  <option value="">--SILAKAN PILIH--</option>
          <?php 
            $query_pelanggan = $db->query("SELECT kode_pelanggan,nama FROM penjualan WHERE status = 'Piutang' AND penjamin = '$penjamin' GROUP BY kode_pelanggan");
              while($data_pelanggan = mysqli_fetch_array($query_pelanggan)){                
                  echo "<option value='".$data_pelanggan['kode_pelanggan'] ."'> ".$data_pelanggan['kode_pelanggan'] ." || ".$data_pelanggan['nama'] ." </option>";
              }
          ?>
</select>  

</span>