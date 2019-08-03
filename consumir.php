<pre>
<?php
require("config.php"); //Allserver config
ini_set('soap.wsdl_cache_enabled', '0');  //server soap
require_once('./lib/nusoap.php');

$oSoap = new nusoap_client($NSERVER.'?wsdl'); //Client setup
$err = $oSoap->getError();
if ($err){echo '<p><b>Error: '. $err .'</b></p>';}
$dato = $oSoap->call( //Api consume
    'SQLJson',
    array('ID' => array(15)),
    $NSERVER);

if ($oSoap->fault){ //Api catch
    echo "Error al llamar el metodo<br/>".$oSoap->getError();
}
else {print_r($dato);} //Api get
?>
</pre>