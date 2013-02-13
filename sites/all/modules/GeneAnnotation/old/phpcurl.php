<?php
function download_page($path){
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $path);
        curl_setopt($ch, CURLOPT_FAILONERROR,1);
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION,1);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER,1);
        curl_setopt($ch, CURLOPT_TIMEOUT, 15);
        curl_setopt($ch, CURLOPT_PROXY, "www-proxy.ebi.ac.uk");
        curl_setopt($ch, CURLOPT_PROXYPORT, 3128);
        $retValue = curl_exec($ch);                      
        curl_close($ch);
        return $retValue;
}

