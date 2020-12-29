<?php
$key = "Your Jpesa Mobile Money API";
$DATA   =   '<?xml version="1.0" encoding="ISO-8859-1"?>
                     <g7bill>
                       <_key_>'.$key.'</_key_>
                       <cmd>account</cmd>
                       <action>credit</action>
                       <pp>mm</pp>
                       <mobile>256752718025</mobile>
                       <amount>50000</amount>
                       <callback>https://your_site.com/order/success</callback>
                     </g7bill>';
$ch 	= 	curl_init();		
curl_setopt($ch, CURLOPT_URL,"https://my.jpesa.com/api/");
curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
curl_setopt($ch, CURLOPT_POST, 1);
curl_setopt($ch, CURLOPT_POSTFIELDS,$DATA);
curl_setopt($ch, CURLOPT_HTTPHEADER,array("Content-Type: text/xml")); 
curl_setopt($ch, CURLOPT_HEADER,false);
curl_setopt($ch, CURLOPT_RETURNTRANSFER,1);
curl_setopt($ch, CURLOPT_CONNECTTIMEOUT,0);
curl_setopt($ch, CURLOPT_TIMEOUT,400);
$return 	= 	curl_exec($ch);		
curl_close($ch);
print_r(json_decode($return,true));
?>