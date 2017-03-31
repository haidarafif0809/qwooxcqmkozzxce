<?php

    include 'sanitasi.php';
    include 'db.php';

	error_reporting(0);
	
	// Format gambar yang di ijinkan untuk di upload
	$format_gambar = array("jpg", "png", "gif", "bmp");
	
	// Folder untuk menyimpan gambar
	$folder = "save_picture/";

	if(isset($_POST) and $_SERVER['REQUEST_METHOD'] == "POST")
	{
	
		// Perintah untuk menghapus gambar
		if(!empty($_POST["hapus"])){
			unlink($_POST["hapus"]);
			echo 'Menjalankan perintah:<br>unlink('.$_POST["hapus"].')';
			$query =$db->query("UPDATE tbs_penjualan_radiologi SET foto = Null  ");
			exit;
		}else{
			$name = $_FILES['photoimg']['name'];
			$size = $_FILES['photoimg']['size'];				
			if(strlen($name))
			{
	
				// Perintah untuk mengecek format gambar
				list($txt, $ext) = explode(".", $name);
				if(in_array($ext,$format_gambar))
				{
	
					// Perintah untuk mengecek size file gambar
					if($size<(1024*1024))
					{
	
						// Perintah untuk mengupload gambar dan memberi nama baru
						$gambarna = time().substr(str_replace(" ", "_", $txt), 5).".".$ext;
						$tmp = $_FILES['photoimg']['tmp_name'];
						if(move_uploaded_file($tmp, $folder.$gambarna))
						{
							$koma = ",";
							// Menentukan nama id img yang di ambil dari nama ifle gambar yang sudah terupload untuk selector hapus di jquery
							$id_gambar = explode(".", $gambarna);
							echo "<p class='hapus' id='".$id_gambar."'>".$gambarna."".$koma."</p>";

						}
						else{echo "Gagal";}
					}
					else{echo "Ukuran maksimal image 1 MB";	}				
				}
				else{echo "Format image tidak valid..";	}


			}				
			else{echo "Silahkan masukan image..!";	}			
			exit;
		}
	}
?>
