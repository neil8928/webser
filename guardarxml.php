<?php
include_once("conexion.php");

require_once "vendor/econea/nusoap/src/nusoap.php";

$namespace = "soapRecibirXML.com";
$server = new soap_server();

function auth_basic($username, $password) {
  // Check if the username and password are valid.
  if ($username == "admin" && $password == "password") {
    return true;
  } else {
    return false;
  }
}

$server->configureWSDL("PruebaSoapRecibirXML",$namespace);
$server->wsdl->schemaTargetNamespace = $namespace;

$server->wsdl->addComplexType(
    'ArchivoXML',
    'complexType',
    'struct',
    'all',
    '',
    array(
        'Codigo' => array('name' => 'Codigo', 'type'=>'xsd:string'),
        'Ruc' => array('name' => 'Ruc', 'type'=>'xsd:string'),
        'Tipo' => array('name' => 'Tipo', 'type'=>'xsd:string'),
        'Serie' => array('name' => 'Serie', 'type'=>'xsd:decimal'),
        'FileB64' => array('name' => 'FileB64', 'type'=>'xsd:string')
    )
);

$server->wsdl->addComplexType(
    'response',
    'complexType',
    'struct',
    'all',
    '',
    array(
        'Descripcion' => array('name'=>'Descripcion', 'type'=>'xsd:string'),
        'Resultado' => array('name' => 'Resultado', 'type' => 'xsd:boolean')
    )
);

$server->register(
    'guardarArchivoXML',
    array('name' => 'tns:ArchivoXML'),
    array('name' => 'tns:response'),
    $namespace,
    false,
    'rpc',
    'encoded',
    'Recibe un archivo  y regresa un número de autorización'
);

function guardarArchivoXML($request){
    if(isset($request['FileB64']) && !empty($request['FileB64'])){

        // $conexion = ConexionSQL::ConexionBD();

        // ConexionSQL::ConexionBD();
        // echo('bolaa');
        return array(
            "Descripcion" => "La orden de compra ".$request["FileB64"]." ha sido autorizada con el número ". rand(10000, 100000),
            "Resultado" => true
        );    
    }
    else{
        return array(
            "Descripcion" => "No ha cargado ningun archivo",
            "Resultado" => false
        );   
    }

    
}



$POST_DATA = file_get_contents("php://input");
$server->service($POST_DATA);
exit();