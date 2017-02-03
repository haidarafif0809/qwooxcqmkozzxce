<?php session_start();
    // memasukan file yang ada pada db.php
    include 'sanitasi.php';
    include 'db.php';
 
    // mengirim data menggunakan metode POST
$pilih_akses_kelas_kamar = $db->query("SELECT kelas_kamar_tambah, kelas_kamar_edit, kelas_kamar_hapus FROM otoritas_master_data WHERE id_otoritas = '$_SESSION[otoritas_id]'");
$kelas_kamar = mysqli_fetch_array($pilih_akses_kelas_kamar);

    $perintah = $db->prepare("INSERT INTO kelas_kamar (nama) VALUES (?)");

    $perintah->bind_param("s",
        $nama);
        
        $nama = stringdoang($_POST['nama']); 
    
    $perintah->execute();



if (!$perintah) 
{
 die('Query Error : '.$db->errno.
 ' - '.$db->error);
}
else 
{
  
}


// UNTUK MENAMPILKAN DATA (BERHUBUNGAN DENGAN JS PREPAND DI FORM)
$query = $db->query("SELECT * FROM kelas_kamar ORDER BY id DESC LIMIT 1");

while ($data = mysqli_fetch_array($query))
            {          
          
$selcted = $db->query("SELECT kelas FROM bed WHERE kelas = '$data[id]'  ");
$cancel = mysqli_num_rows($selcted);

                //menampilkan data
            echo "<tr class='tr-id-".$data['id']."'>

            <td>". $data['nama'] ."</td>";

if ($cancel == 0)
{



            if ($kelas_kamar['kelas_kamar_hapus'] > 0) {
                echo "<td> <button class='btn btn-danger btn-hapus ' data-id='". $data['id'] ."' data-nama='". $data['nama'] ."'>Hapus </button> </td>";
            }

            else{
                echo "<td> </td>";
            }

            if ($kelas_kamar['kelas_kamar_edit'] > 0) {
                echo "<td> <button class='btn btn-info btn-edit ' data-nama='". $data['nama'] ."' data-id='". $data['id'] ."'>  Edit </button> </td>";
            }
            else{
                echo "<td> </td>";
            }
}
else
{
    echo "<td> </td>
          <td> </td>";

}

            echo "</tr>";
            
}


//Untuk Memutuskan Koneksi Ke Database
mysqli_close($db);   

    ?>


<script>
    $(document).ready(function(){
    
//fungsi hapus data 
        $(".btn-hapus").click(function(){
        var nama = $(this).attr("data-nama");
        var id = $(this).attr("data-id");

        $("#nama_hapus").val(nama);
        $("#id_hapus").val(id);

        $("#modal_hapus").modal('show');
        
        
        });


        $("#btn_jadi_hapus").click(function(){
        
        var id = $("#id_hapus").val();

        $.post("delete_kelas_kamar.php",{id:id},function(data){

        if (data != "") {
        $("#modal_hapus").modal('hide');
         $(".tr-id-"+id).remove();

        }

        
        });
        
        });
// end fungsi hapus data
//fungsi edit data 
        $(".btn-edit").click(function(){
        
        $("#modal_edit").modal('show');
        var nama = $(this).attr("data-nama"); 
        var id  = $(this).attr("data-id");
        $("#nama_edit").val(nama);
        $("#id_edit").val(id);
        
        
        });
        
        $("#submit_edit").click(function(){
        var nama = $("#nama_edit").val();
        var id = $("#id_edit").val();

        if (nama == ""){
            alert("Nama Harus Diisi");
        }
        else {

        $.post("update_kelas_kamar.php",{id:id,nama:nama},function(data){
        if (data != '') {
        $(".alert").show('fast');
           window.location.href="kelas_kamar.php";

        setTimeout(tutupalert, 2000);
        $(".modal").modal("hide");
        }
        
        
        });
        }
                                    

        function tutupmodal() {
        
        }   
        });
        


//end function edit data

        $('form').submit(function(){
        
        return false;
        });
        
        });
        
        
        

        function tutupalert() {
        $(".alert").hide("fast")
        }


        </script>
