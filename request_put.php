<? 

require_once '../ws_config.php';
$ci = curl_init();

$fields = array(
    "email" => "55@gmail.com",
    "senha" => "1231as",
    "idade" =>  123,
    "nome" => "444 nome"
);

$fields = (is_array($fields)?http_build_query($fields):$fields);
curl_setopt($ci, CURLOPT_URL, "http://localhost/prog20_ws/ws5/user/22");
curl_setopt($ci, CURLOPT_CUSTOMREQUEST, 'PUT');
curl_setopt($ci, CURLOPT_POSTFIELDS, $fields);
curl_setopt($ci, CURLOPT_HEADER, false);
curl_setopt($ci, CURLOPT_RETURNTRANSFER, 1);
$result = curl_exec($ci);
$_r = json_decode($result, true);
__output_header__(true, null, $_r);

?>