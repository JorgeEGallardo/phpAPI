<?php
require("config.php"); //All server config
require_once('lib/nusoap.php'); //Api functionality lib
function SQLJson($ID) //main function
{
	$ids=$ID[0];
	require("config.php");
    $con = new mysqli($SERVER, $USER, $PASSWORD, $DB); //Connection build
    mysqli_set_charset($con,'utf8'); //Special character friendly
	$sql    = "SELECT * FROM `USUARIOS` WHERE `IDENTIFICADOR` = ?"; //get users by identificador
	$stmt   = $con->prepare($sql);
	$stmt->bind_param('i',$ids);  //bind parameters [?]
	$stmt->execute(); //Execute
    $result = $stmt->get_result(); 
    $JsonOb=new stdClass; //Object to Json parse
	while($row = $result->fetch_array()) //Fetch query every row can be printed with print_r($row)
	{
		$JsonOb->Nombres=$row['NOMBRE'];
		$JsonOb->Apellidos=$row['APELLIDOS'];
        $JsonOb->Telefono=$row['TELEFONO'];
    }
    
            $Jsone=json_encode($JsonOb); //Auto phpObj->json format 
            return $Jsone;
}
$server = new soap_server(); //new server
$ns=$NSERVER;
$server->configurewsdl('ApplicationServices',$ns);
$server->wsdl->schematargetnamespace=$ns;
$server->register( //Here we may register all functions in order to be consumed
	'SQLJson',
	array('ID' => 'xsd:string'), //parameters
	array('return' => 'xsd:string'), //returns
	$ns);
if (isset($HTTP_RAW_POST_DATA)){
	$input = $HTTP_RAW_POST_DATA;
}
else{$input = implode("\r\n", file('php://input'));}
$server->service($input);
exit;