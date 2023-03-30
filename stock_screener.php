<?php
set_time_limit(0);

$url_info = "https://financialmodelingprep.com/api/v3/stock-screener?marketCapMoreThan=1000000000&betaMoreThan=1&volumeMoreThan=10000&sector=Technology&exchange=NASDAQ&dividendMoreThan=0&limit=100&apikey=6efc26598c705a46c16082b0640c7c0f";

$channel = curl_init();

curl_setopt($channel, CURLOPT_AUTOREFERER, TRUE);
curl_setopt($channel, CURLOPT_HEADER, 0);
curl_setopt($channel, CURLOPT_RETURNTRANSFER, 1);
curl_setopt($channel, CURLOPT_URL, $url_info);
curl_setopt($channel, CURLOPT_FOLLOWLOCATION, TRUE);
curl_setopt($channel, CURLOPT_IPRESOLVE, CURL_IPRESOLVE_V4);
curl_setopt($channel, CURLOPT_TIMEOUT, 0);
curl_setopt($channel, CURLOPT_CONNECTTIMEOUT, 0);
curl_setopt($channel, CURLOPT_SSL_VERIFYHOST, FALSE);
curl_setopt($channel, CURLOPT_SSL_VERIFYPEER, FALSE);

$output = curl_exec($channel);

if (curl_error($channel)) {
    return 'error:' . curl_error($channel);
} else {
 $outputJSON = json_decode($output);
  var_dump($outputJSON);
}

?>