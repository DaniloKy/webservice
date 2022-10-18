<? 

require_once '../ws_config.php';
$ci = curl_init();

curl_setopt($ci, CURLOPT_URL, "http://localhost/prog20_ws/ws5/user/20");
curl_setopt($ci, CURLOPT_CUSTOMREQUEST, 'DELETE');
curl_setopt($ci, CURLOPT_HEADER, false);
curl_setopt($ci, CURLOPT_RETURNTRANSFER, 1);
$result = curl_exec($ci);
$_r = json_decode($result, true);


?>