<?php session_start();
 
    //memasukkan file db.php
    include 'sanitasi.php';
    include 'db.php';

    $session_id = session_id();


    $kode_barang = stringdoang($_POST['kode_barang']);   
        $nama_barang = stringdoang($_POST['nama_barang']);
        $satuan = stringdoang($_POST['satuan']);
        $harga = angkadoang($_POST['harga']);
        $jumlah = angkadoang($_POST['jumlah_barang']);
        $kode_barang = stringdoang($_POST['kode_barang']);
        


      $hpp_item_masuk = angkadoang($_POST['hpp_item_masuk']);

      if ($hpp_item_masuk == "") {

        $subtotal = $harga * $jumlah;
        $perintah = $db->prepare("INSERT INTO tbs_item_masuk (session_id,kode_barang,nama_barang,jumlah,satuan,harga,subtotal) VALUES (?,?,?,?,?,?,?)");

        $perintah->bind_param("sssisii",
          $session_id, $kode_barang, $nama_barang, $jumlah, $satuan, $harga, $subtotal);

        $perintah->execute();

           if (!$perintah) {
            die('Query Error : '.$db->errno.
            ' - '.$db->error);
            }
            else {
            
            }


      }

      else{

        $subtotal = $hpp_item_masuk * $jumlah;

        $perintah = $db->prepare("INSERT INTO tbs_item_masuk (session_id,kode_barang,nama_barang,jumlah,satuan,harga,subtotal) VALUES (?,?,?,?,?,?,?)");

        $perintah->bind_param("sssisii",
          $session_id, $kode_barang, $nama_barang, $jumlah, $satuan, $hpp_item_masuk, $subtotal);
        
          
        $perintah->execute();

           if (!$perintah) {
            die('Query Error : '.$db->errno.
            ' - '.$db->error);
            }
            else {
            
            }

      }


   

    ?>

    <?php
                              
                              //menampilkan semua data yang ada pada tabel tbs penjualan dalam DB
                              $perintah = $db->query("SELECT tim.id,tim.kode_barang,tim.nama_barang,tim.jumlah,tim.harga,tim.subtotal,s.nama FROM tbs_item_masuk tim INNER JOIN satuan s ON tim.satuan = s.id WHERE tim.session_id = '$session_id' AND kode_barang = '$kode_barang' ORDER BY tim.id DESC LIMIT 1");
                              
                              //menyimpan data sementara yang ada pada $perintah
                              
                              $data1 = mysqli_fetch_array($perintah);
                              //menampilkan data
                              echo "<tr class='tr-id-".$data1['id']." tr-kode-".$data1['kode_barang']."' kode_barang='".$data1['kode_barang']."'>
                              <td>". $data1['kode_barang'] ."</td>
                              <td>". $data1['nama_barang'] ."</td>

                             <td class='edit-jumlah' data-id='".$data1['id']."'><span id='text-jumlah-".$data1['id']."'>". $data1['jumlah'] ."</span> <input type='hidden' id='input-jumlah-".$data1['id']."' value='".$data1['jumlah']."' class='input_jumlah' data-id='".$data1['id']."' autofocus='' data-subtotal='".$data1['subtotal']."' data-harga='".$data1['harga']."' data-kode='".$data1['kode_barang']."' > </td>
                             

                              <td>". $data1['nama'] ."</td>
                              <td>". rp($data1['harga']) ."</td>
                              <td><span id='text-subtotal-".$data1['id']."'>". rp($data1['subtotal']) ."</span></td>
                              
                              <td> <button class='btn btn-danger btn-sm btn-hapus' id='btn-hapus-".$data1['id']."' data-id='". $data1['id'] ."' data-nama-barang='". $data1['nama_barang'] ."' data-subtotal='". $data1['subtotal'] ."' > <span class='glyphicon glyphicon-trash'> </span> Hapus </button> </td> 
                              </tr>";
                             

                              //Untuk Memutuskan Koneksi Ke Database
                              
                              mysqli_close($db); 
                              ?>



                              



                                    
                                    <script type="text/javascript">
                                    
                                    $(".edit-jumlah").dblclick(function(){
                                    
                                    var id = $(this).attr("data-id");
                                    
                                    $("#text-jumlah-"+id+"").hide();
                                    
                                    $("#input-jumlah-"+id+"").attr("type", "text");
                                    
                                    });
                                    
                                    
                                    $(".input_jumlah").blur(function(){
                                    
                                    var id = $(this).attr("data-id");
                                    var jumlah_baru = $(this).val();
                                    var harga = $(this).attr("data-harga");
                                    var subtotal_lama = bersihPemisah(bersihPemisah(bersihPemisah(bersihPemisah($(this).attr("data-subtotal")))));
                                    var subtotal = harga * jumlah_baru;
                                    var subtotal_penjualan = bersihPemisah(bersihPemisah(bersihPemisah(bersihPemisah($("#total_item_masuk").val()))));
                                    
                                    var total_akhir = parseInt(subtotal_penjualan) - parseInt(subtotal_lama) + parseInt(subtotal);
                                    
                                    $("#total_item_masuk").val(tandaPemisahTitik(total_akhir));
                                    $("#input-jumlah-"+id).attr("data-subtotal", subtotal);
                                    $("#btn-hapus-"+id).attr("data-subtotal", subtotal);
                                    
                                    $.post("update_jumlah_barang_tbs_item_masuk.php",{id:id,jumlah_baru:jumlah_baru,subtotal:subtotal},function(info){
                                    

                                    
                                    $("#text-jumlah-"+id+"").show();
                                    $("#text-jumlah-"+id+"").text(jumlah_baru);
                                    $("#text-subtotal-"+id+"").text(tandaPemisahTitik(subtotal));
                                    $("#input-jumlah-"+id+"").attr("type", "hidden"); 
                                    
                                    
                                    });
                                    
                                    $("#kode_barang").focus();
                                    
                                    });
                                    
                                    </script>     
