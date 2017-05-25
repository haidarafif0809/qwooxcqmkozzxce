<!doctype html>
<html>
  <head>


  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
      <!-- Include Dexie -->
      <script src="https://unpkg.com/dexie@latest/dist/dexie.js"></script>

      <script>
          //
          // Define your database
          //
          var db = new Dexie("database_barang");

          db.version(2).stores({
             
            barang : 'id,kode_barang,nama_barang,harga_jual,harga_jual2,harga_jual3,harga_jual4,harga_jual5,harga_jual6,harga_jual7,satuan,kategori,status,suplier,limit_stok,berkaitan_dgn_stok,tipe_barang'  
          });


            $.get('data_barang.php',function(data){

               var data_barang = [];
    
 
              
                $.each(data.result, function(i, item) {

               
                  data_barang.push({id: data.result[i].id, kode_barang: data.result[i].kode_barang,nama_barang : data.result[i].nama_barang,harga_jual:  data.result[i].harga_jual,harga_jual2:  data.result[i].harga_jual2,harga_jual3:  data.result[i].harga_jual3,harga_jual4:  data.result[i].harga_jual4,harga_jual5:  data.result[i].harga_jual5,harga_jual6:  data.result[i].harga_jual6,harga_jual7:  data.result[i].harga_jual7,satuan:  data.result[i].satuan,kategori:  data.result[i].kategori,status:  data.result[i].status,suplier:  data.result[i].suplier,limit_stok:  data.result[i].limit_stok,berkaitan_dgn_stok:  data.result[i].berkaitan_dgn_stok,tipe_barang:  data.result[i].tipe_barang  });



                 });

                 db.barang.bulkPut(data_barang).then(function(lastKey) {

                  console.log("Done putting 100,000 raindrops all over the place");
                  console.log("Last raindrop's id was: " + lastKey); // Will be 100000.
                  
                  $("#berhasil").html("<h2>Berhasil Cache</h2>");

                  }).catch(Dexie.BulkError, function (e) {
                      // Explicitely catching the bulkAdd() operation makes those successful
                      // additions commit despite that there were errors.
                      console.error ("Some raindrops did not succeed. However, " +
                         100000-e.failures.length + " raindrops was added successfully");
                  });

            });
          


  
      </script>
  </head>

  <span id="berhasil">
    
  </span>
 
</html>