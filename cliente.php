<?php

include_once 'nusoap-0.9.5/lib/nusoap.php';

$nusoap=new nusoap_client("http://localhost:8080/ws/index.php?wsdl",true);

$error=$nusoap->getError();


if($error){
    var_dump($error);
}

//$result=$nusoap->call('listarPreordenes',array('datos'=>array('token'=>'TOKEN123','identificador'=>7,'tipo'=>'AGENCIA')));

$result=$nusoap->call('detallePreorden',array('datos'=>array('token'=>'TOKEN123','identificador'=>3)));


if($nusoap->fault){
    echo $nusoap->fault;
}
else{
    if($nusoap->getError()){
        echo $nusoap->getError();
    }
    else{
        print_r($result);
    }
}
/*
echo "<pre>" . htmlspecialchars($nusoap->request, ENT_QUOTES) . "</pre>";
echo "<h2>Response</h2>";
echo "<pre>" . htmlspecialchars($nusoap->response, ENT_QUOTES) . "</pre>";
*/
//echo $nusoap->response;

?>