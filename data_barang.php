<?php 


header('Content-Type: application/json');

        include 'cache.class.php';
          $c = new Cache();
          $c->setCache('produk');
          $data_c = $c->retrieveAll();

           $result = array();

          foreach ($data_c as $key) {
 

            	array_push($result,array(
				 "id" => $key['id'],
				 "kode_barang"=>$key['kode_barang'],
				 "nama_barang"=>$key['nama_barang'],

				 "harga_jual" =>$key['harga_jual'],
				"harga_jual2" =>$key['harga_jual2'],
				"harga_jual3" =>$key['harga_jual3'],
				"harga_jual4" =>$key['harga_jual4'],
				"harga_jual5" =>$key['harga_jual5'],
				"harga_jual6" =>$key['harga_jual6'],
				"harga_jual7" =>$key['harga_jual7'],

				 "harga_jual_inap" =>$key['harga_jual_inap'],
				"harga_jual_inap2" =>$key['harga_jual_inap2'],
				"harga_jual_inap3" =>$key['harga_jual_inap3'],
				"harga_jual_inap4" =>$key['harga_jual_inap4'],
				"harga_jual_inap5" =>$key['harga_jual_inap5'],
				"harga_jual_inap6" =>$key['harga_jual_inap6'],
				"harga_jual_inap7" =>$key['harga_jual_inap7'],

				"satuan" =>$key['satuan'],
				"kategori" =>$key['kategori'],
				"status" =>$key['status'],
				"suplier" =>$key['suplier'],
				"limit_stok" =>$key['limit_stok'],
				"berkaitan_dgn_stok" =>$key['berkaitan_dgn_stok'],
				"tipe_barang" =>$key['tipe_barang'],
				
				 ));

          }
           echo json_encode(array('result'=>$result));
 

        ?>