<?php
define("REMOTE","http://scanner.grangerhub.com/");
$context  = stream_context_create(array('http' => array('user_agent' => 'Acidtu.be Tracker')));
$cat = $_GET["cat"];
$callback = $_GET["callback"];
$template = $_GET["tpl"];
unset($_GET["cat"]);
unset($_GET["callback"]);
unset($_GET["tpl"]);
$string = http_build_query($_GET);
$jsonstr = file_get_contents(REMOTE . "/" . $cat . "/" . "?" . $string, false, $context);
$json = json_decode($jsonstr);
$ret = array();
if($json) {
    $ret["data"] = $json;
}
$ret["html"] = file_get_contents(__DIR__."/../htm/".$template.".htm");
$array = json_encode($ret);
//echo $array; exit;
ob_start();
print_r($callback."($array);");
echo ob_get_clean();
