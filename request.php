<?

//require_once '../ws_config.php';
require_once './json.php';

$ci = curl_init();
$tb = $_GET['tb'];
curl_setopt($ci, CURLOPT_URL, "http://localhost/prog20_ws/ws6_me/".$tb."/");
curl_setopt($ci, CURLOPT_POST, true);
curl_setopt($ci, CURLOPT_POSTFIELDS, array(
    'email' => "popo@adm.pt",
    'senha' => "popo",
    'idade' => 1233,
    'nome' => "popo"
));

curl_setopt($ci, CURLOPT_HEADER, false);
curl_setopt($ci, CURLOPT_RETURNTRANSFER, 1); //ESPERA PELO RETORNO, do lado ws_5

$result = curl_exec($ci);
//$_r = json_decode($result, true);
//__output_header__(true, null, $_r);

$json = new JSON($result);

?>