<?php

include 'db.php';

include 'sanitasi.php';
$klinik = stringdoang($_GET['klinik']);
function url_get_contents ($url) {
        if (!function_exists('curl_init')){ 
        die('CURL is not installed!');
        }
       
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

        curl_setopt ($ch, CURLOPT_CAINFO, "cacert.pem");


        $output = curl_exec($ch);

        if(curl_errno($ch)){
        echo 'Curl error: ' . curl_error($ch);
        }
        curl_close($ch);

        return $output;
}


$text = "No Faktur Double di $klinik";
$query = $db->query("SELECT no_faktur,count(*) as c FROM penjualan GROUP BY no_faktur having c > 1 order by c desc");

while($data = $query->fetch_array()){
	

	$text .=  $data['no_faktur']." \n";

	
}


$url = "https://api.telegram.org/bot249938514:AAEhdf1419e00xK8hrGia0avOhW0tfhzzWQ/sendMessage?chat_id=-102784281&text=";
 $url = $url.$text;


  url_get_contents($url);



?>


