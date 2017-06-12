<?php
//mugres warnings
ini_set('display_errors', 'off');

include_once 'nusoap-0.9.5/lib/nusoap.php';
include_once 'ConectionDBMysql.php';

$soapserver = new nusoap_server();
$soapserver->configureWSDL('wservice', 'urn:wservicewsdl');


//*****Obtener las preordenes(todas)*****//

//estructura de la consulta(entrada)
$soapserver->wsdl->addComplexType(
    'consulta',
    'complexType',
    'struct',
    'all',
    '',
    array(
        'token' => array('name' => 'token', 'type' => 'xsd:string'),
        'identificador' => array('name' => 'identificador', 'type' => 'xsd:integer'),
        'tipo' => array('name' => 'tipo', 'type' => 'xsd:string')
    )
);

//estructura de un elemento de la respuesta
$soapserver->wsdl->addComplexType(
    'respuestaArray',
    'complexType',
    'struct',
    'all',
    '',
    array(
        'id' => array('name' => 'id', 'type' => 'xsd:integer'),
        'fecha' => array('name' => 'fecha', 'type' => 'xsd:string'),
        'folio' => array('name' => 'folio', 'type' => 'xsd:string'),
        'id_agencia' => array('name' => 'id_agencia', 'type' => 'xsd:integer'),
        'id_usuario' => array('name' => 'id_usuario', 'type' => 'xsd:integer'),
        'id_modelo' => array('name' => 'id_modelo', 'type' => 'xsd:integer'),
        'id_paquete' => array('name' => 'id_paquete', 'type' => 'xsd:integer'),
        'monto_paquete' => array('name' => 'monto_paquete', 'type' => 'xsd:decimal'),
        'km' => array('name' => 'km', 'type' => 'xsd:decimal'),
        'servicios' => array('name' => 'servicios', 'type' => 'xsd:string'),
        'nota' => array('name' => 'nota', 'type' => 'xsd:string'),
        'imagen' => array('name' => 'imagen', 'type' => 'xsd:string'),
        'id_cliente' => array('name' => 'id_cliente', 'type' => 'xsd:integer'),
        'id_cliente_nuevo' => array('name' => 'id_cliente_nuevo', 'type' => 'xsd:integer'),
        'id_vehiculo' => array('name' => 'id_vehiculo', 'type' => 'xsd:string'),
        'id_vehiculo_nuevo' => array('name' => 'id_vehiculo_nuevo', 'type' => 'xsd:integer')
    )
);

//estructura de la respuesta con las preordenes(array de arrays)
$soapserver->wsdl->addComplexType(
    'respuesta',
    'complexType',
    'array',
    '',
    'SOAP-ENC:Array',
    array(),
    array(
        array(
            'ref' => 'SOAP-ENC:arrayType',
            'wsdl:arrayType' => 'tns:respuestaArray[]'
        )
    ),
    'tns:respuestaArray'
);

//la respuesta final, incuyendo el elemento <error>
$soapserver->wsdl->addComplexType(
    'respuestaPreordenes',
    'complexType',
    'struct',
    'all',
    '',
    array(
        'result' => array('name' => 'result', 'type' => 'tns:respuesta'),
        'error' => array('name' => 'error', 'type' => 'xsd:string')
    )
);

//registrar la funcion
$soapserver->register(
    'listarPreordenes',
    array('datos' => 'tns:consulta'),
    //array('result' => 'tns:respuesta','error'=>'xsd:string'),
    array('result' => 'tns:respuestaPreordenes'),
    'urn:wservicewsdl',
    'urn:wservicewsdl#listarPreordenes',
    'rpc',
    'encoded',
    'web service prueba'
);


//***** Obtener una preorden (detallada, con vehiculo,cliente y demas) *******//

//estructura de la peticion <consultarPreorden>
$soapserver->wsdl->addComplexType(
    'consultarPreorden',
    'complexType',
    'struct',
    'all',
    '',
    array(
        'token' => array('name' => 'token', 'type' => 'xsd:string'),
        'identificador' => array('name' => 'identificador', 'type' => 'xsd:integer')
    )
);

//retorno de arreglo cliente <estructuraCliente>
$soapserver->wsdl->addComplexType(
    'estructuraCliente',
    'complexType',
    'struct',
    'all',
    '',
    array(
        'id' => array('name' => 'id', 'type' => 'xsd:integer'),
        'nombre' => array('name' => 'nombre', 'type' => 'xsd:string'),
        'paterno' => array('name' => 'paterno', 'type' => 'xsd:string'),
        'materno' => array('name' => 'materno', 'type' => 'xsd:string'),
        'calle' => array('name' => 'calle', 'type' => 'xsd:string'),
        'numero_exterior' => array('name' => 'numero_exterior', 'type' => 'xsd:string'),
        'numero_interior' => array('name' => 'numero_interior', 'type' => 'xsd:string'),
        'colonia' => array('name' => 'colonia', 'type' => 'xsd:string'),
        'cp' => array('name' => 'cp', 'type' => 'xsd:integer'),
        'estado' => array('name' => 'estado', 'type' => 'xsd:string'),
        'ciudad' => array('name' => 'ciudad', 'type' => 'xsd:string'),
        'fecha_nacimiento' => array('name' => 'fecha_nacimiento', 'type' => 'xsd:string'),
        'telefono_casa' => array('name' => 'telefono_casa', 'type' => 'xsd:string'),
        'telefono_oficina' => array('name' => 'telefono_oficina', 'type' => 'xsd:string'),
        'celular' => array('name' => 'celular', 'type' => 'xsd:string'),
        'correo' => array('name' => 'correo', 'type' => 'xsd:string'),
        'fac_rfc' => array('name' => 'fac_rfc', 'type' => 'xsd:string'),
        'fac_razon_social' => array('name' => 'fac_razon_social', 'type' => 'xsd:string'),
        'fac_estado' => array('name' => 'fac_estado', 'type' => 'xsd:string'),
        'fac_ciudad' => array('name' => 'fac_ciudad', 'type' => 'xsd:string'),
        'fac_calle' => array('name' => 'fac_calle', 'type' => 'xsd:string'),
        'fac_numero_exterior' => array('name' => 'fac_numero_exterior', 'type' => 'xsd:string'),
        'fac_numero_interior' => array('name' => 'fac_numero_interior', 'type' => 'xsd:string'),
        'fac_colonia' => array('name' => 'fac_colonia', 'type' => 'xsd:string'),
        'fac_cp' => array('name' => 'fac_cp', 'type' => 'xsd:integer')
    )
);

//estructura vehiculo <estructuraVehiculo>
$soapserver->wsdl->addComplexType(
    'estructuraVehiculo',
    'complexType',
    'struct',
    'all',
    '',
    array(
        'id' => array('name' => 'id', 'type' => 'xsd:integer'),
        'ano' => array('name' => 'ano', 'type' => 'xsd:integer'),
        'fecha_compra' => array('name' => 'fecha_compra', 'type' => 'xsd:string'),
        'marca' => array('name' => 'marca', 'type' => 'xsd:integer'),
        'modelo' => array('name' => 'modelo', 'type' => 'xsd:integer'),
        'placas' => array('name' => 'placas', 'type' => 'xsd:string'),
        'vin' => array('name' => 'vin', 'type' => 'xsd:string'),
    )
);

//estructura inventario <estructuraInventario>
$soapserver->wsdl->addComplexType(
    'estructuraInventario',
    'complexType',
    'struct',
    'all',
    '',
    array(
        'id_preorden' => array('name' => 'id_preorden', 'type' => 'xsd:integer'),
        'id_inventario' => array('name' => 'id_inventario', 'type' => 'xsd:integer'),
        'estado' => array('name' => 'estado', 'type' => 'xsd:integer')
    )
);
$soapserver->wsdl->addComplexType(
    'arrayInventario',
    'complexType',
    'array',
    '',
    'SOAP-ENC:Array',
    array(),
    array(
        array(
            'ref' => 'SOAP-ENC:arrayType',
            'wsdl:arrayType' => 'tns:estructuraInventario[]'
        )
    ),
    'tns:estructuraInventario'
);

//esctructura de inspeccion <estructuraInspeccion>
$soapserver->wsdl->addComplexType(
    'estructuraInspeccion',
    'complexType',
    'struct',
    'all',
    '',
    array(
        'id_preorden' => array('name' => 'id_preorden', 'type' => 'xsd:integer'),
        'id_inspeccion' => array('name' => 'id_inspeccion', 'type' => 'xsd:integer'),
        'estado' => array('name' => 'estado', 'type' => 'xsd:integer')
    )
);
$soapserver->wsdl->addComplexType(
    'arrayInspeccion',
    'complexType',
    'array',
    '',
    'SOAP-ENC:Array',
    array(),
    array(
        array(
            'ref' => 'SOAP-ENC:arrayType',
            'wsdl:arrayType' => 'tns:estructuraInspeccion[]'
        )
    ),
    'tns:estructuraInspeccion'
);

//estructura llantas <estructuraLlantas>
$soapserver->wsdl->addComplexType(
    'estructuraLlantas',
    'complexType',
    'struct',
    'all',
    '',
    array(
        'id_preorden' => array('name' => 'id_preorden', 'type' => 'xsd:integer'),
        'profundidad' => array('name' => 'profundidad', 'type' => 'xsd:integer'),
        'presion' => array('name' => 'presion', 'type' => 'xsd:integer'),
        'estado' => array('name' => 'estado', 'type' => 'xsd:integer'),
        'lado' => array('name' => 'lado', 'type' => 'xsd:string')
    )
);
$soapserver->wsdl->addComplexType(
    'arrayLlantas',
    'complexType',
    'array',
    '',
    'SOAP-ENC:Array',
    array(),
    array(
        array(
            'ref' => 'SOAP-ENC:arrayType',
            'wsdl:arrayType' => 'tns:estructuraLlantas[]'
        )
    ),
    'tns:estructuraLlantas'
);

//estructura frenos <estructuraFrenos>
$soapserver->wsdl->addComplexType(
    'estructuraFrenos',
    'complexType',
    'struct',
    'all',
    '',
    array(
        'id_preorden' => array('name' => 'id_preorden', 'type' => 'xsd:integer'),
        'porcentaje' => array('name' => 'porcentaje', 'type' => 'xsd:integer'),
        'mm' => array('name' => 'mm', 'type' => 'xsd:integer'),
        'estado' => array('name' => 'estado', 'type' => 'xsd:integer'),
        'lado' => array('name' => 'lado', 'type' => 'xsd:string')
    )
);
$soapserver->wsdl->addComplexType(
    'arrayFrenos',
    'complexType',
    'array',
    '',
    'SOAP-ENC:Array',
    array(),
    array(
        array(
            'ref' => 'SOAP-ENC:arrayType',
            'wsdl:arrayType' => 'tns:estructuraFrenos[]'
        )
    ),
    'tns:estructuraFrenos'
);

//estructura de <detallePreorden>, los campos del registro
$soapserver->wsdl->addComplexType(
    'estructuraDetallePreorden',
    'complexType',
    'struct',
    'all',
    '',
    array(
        'id' => array('name' => 'id', 'type' => 'xsd:integer'),
        'fecha' => array('name' => 'fecha', 'type' => 'xsd:string'),
        'folio' => array('name' => 'folio', 'type' => 'xsd:string'),
        'id_agencia' => array('name' => 'id_agencia', 'type' => 'xsd:integer'),
        'id_usuario' => array('name' => 'id_usuario', 'type' => 'xsd:integer'),
        'id_modelo' => array('name' => 'id_modelo', 'type' => 'xsd:integer'),
        'id_paquete' => array('name' => 'id_paquete', 'type' => 'xsd:integer'),
        'monto_paquete' => array('name' => 'monto_paquete', 'type' => 'xsd:decimal'),
        'km' => array('name' => 'km', 'type' => 'xsd:decimal'),
        'servicios' => array('name' => 'servicios', 'type' => 'xsd:string'),
        'nota' => array('name' => 'nota', 'type' => 'xsd:string'),
        'imagen' => array('name' => 'imagen', 'type' => 'xsd:string'),
        'id_cliente' => array('name' => 'id_cliente', 'type' => 'xsd:integer'),
        'id_cliente_nuevo' => array('name' => 'id_cliente_nuevo', 'type' => 'xsd:integer'),
        'id_vehiculo' => array('name' => 'id_vehiculo', 'type' => 'xsd:string'),
        'id_vehiculo_nuevo' => array('name' => 'id_vehiculo_nuevo', 'type' => 'xsd:integer'),
        'cliente_nuevo' => array('name' => 'cliente_nuevo', 'type' => 'tns:estructuraCliente'),
        'vehiculo_nuevo' => array('name' => 'vehiculo_nuevo', 'type' => 'tns:estructuraVehiculo'),
        'inventario' => array('name' => 'inventario', 'type' => 'tns:arrayInventario'),
        'inspeccion' => array('name' => 'inspeccion', 'type' => 'tns:arrayInspeccion'),
        'llantas' => array('name' => 'llantas', 'type' => 'tns:arrayLlantas'),
        'frenos' => array('name' => 'frenos', 'type' => 'tns:arrayFrenos')
    )
);
//la estructura de respuesta,resultado y error en dado caso
$soapserver->wsdl->addComplexType(
    'respuestaDetallePreorden',
    'complexType',
    'struct',
    'all',
    '',
    array(
        'result' => array('name' => 'result', 'type' => 'tns:estructuraDetallePreorden'),
        'error' => array('name' => 'error', 'type' => 'xsd:string')
    )
);

//registrar la funcion <detallePreorden>
$soapserver->register(
    'detallePreorden',
    array('datos' => 'tns:consultarPreorden'),
    array('result' => 'tns:respuestaDetallePreorden'),
    'urn:wservicewsdl',
    'urn:wservicewsdl#detallePreorden',
    'rpc',
    'encoded',
    'Web service que retorna los detalles de una preorden'
);


//nada
if (!isset($HTTP_RAW_POST_DATA)) $HTTP_RAW_POST_DATA = file_get_contents('php://input');

$soapserver->service($HTTP_RAW_POST_DATA);

//******  funciones *****//
/*
 * listarPreordenes
 * Mostrar una lista de preordenes, filtrando de acuerdo a los parametros recibidos
 * Recibe un arregloq ue contiene=> token:string,identificador:int,tipo:string
 * Retorna un arreglo de arreglos(preordenes)
 */
function listarPreordenes($datos)
{

    //solo por si acaso no mando alguno de los 3 parametros permitidos
    $errorTipo = false;

    $where_tipo = 'id_agencia';
    switch ($datos['tipo']) {
        case 'AGENCIA':
            $where_tipo = 'id_agencia';
            break;
        case 'CLIENTE':
            $where_tipo = 'id_cliente';
            break;
        case 'USUARIO':
            $where_tipo = 'id_usuario';
            break;
        default:
            //no se recibio el parametro correcto
            $where_tipo = 'id_agencia';
            $errorTipo = true;
            break;
    }

    if ($errorTipo) {
        $response['error'] = "Error: No se reconoce el tipo '{$datos['tipo']}'";
        return $response;
    }

    //por si las moscas validemos el identificador
    $identificador = filter_var($datos['identificador'], FILTER_SANITIZE_NUMBER_INT);

    $sentencia = "SELECT sad_preordenes.id,fecha,folio,id_agencia,id_usuario,id_modelo,id_paquete,
    monto_paquete,km,servicios,nota,imagen,id_cliente,id_cliente_nuevo,id_vehiculo,id_vehiculo_nuevo
    FROM sad_preordenes 
    WHERE sad_preordenes.$where_tipo=$identificador";

    $db = new ConectionDBMysql();

    $error = false;
    $result = $db->executeQuery($sentencia);
    if ($result->num_rows > 0) {
        //bien
        foreach ($result as $row) {
            $resultado[] = $row;
        }
        //vamos a regresar los datos
        $response['result'] = $resultado;
    } else {
        //mal, no esta :c
        $response['error'] = 'Error, no existen registros que coincidan con la busqueda';
    }
    $db->closeConection();

    return $response;
}

/*
 * detallePreorden
 * Obtener todos los detalles relacionados a la preorden
 * Recibe un arreglo que contiene=> identificador:int,token:string
 * Retorna un arreglo con datos de preorden,cliente,vehiculo,inventario,inspeccion,llantas y frenos
 */
function detallePreorden($datos)
{
    //como saber que el usuario y el vehiculo sean nuevos?
    //obtener los datos de la preorden
    //y en cada caso hacer la consulta en caso de que sean nuevos, de otra forma solo retornar el identificador

    $idPreorden = filter_var($datos['identificador'], FILTER_SANITIZE_NUMBER_INT);

    $db = new  ConectionDBMysql();

    //Los datos de preorden
    $selectPreorden = "SELECT id,fecha,folio,id_agencia,id_usuario,id_modelo,id_paquete,
    monto_paquete,km,servicios,nota,imagen,id_cliente,id_cliente_nuevo,id_vehiculo,id_vehiculo_nuevo
    FROM sad_preordenes 
    WHERE id=$idPreorden";

    $preorden = false;
    $resultPreorden = $db->executeQuery($selectPreorden);
    //echo "error:";var_dump($db);
    if ($resultPreorden->num_rows > 0) {
        foreach ($resultPreorden as $rp) {
            $preorden = $rp;
        }
    } else {
        //retornar algun tipo de error :/
        $response['error'] = 'Error, no existe registro';
    }


    //cliente nuevo?
    if (!empty($preorden['id_cliente_nuevo'])) {
        //obtener los datos del cliente nuevo
        $selectCliente = "SELECT id,nombre,paterno,materno,calle,numero_exterior,numero_interior,colonia,
        cp,estado,ciudad,fecha_nacimiento,telefono_casa,telefono_oficina,celular,
        correo,fac_rfc,fac_razon_social,fac_estado,fac_ciudad,fac_calle,fac_numero_exterior,
        fac_numero_interior,fac_colonia,fac_cp
        FROM sad_clientes 
        WHERE id={$preorden['id_cliente_nuevo']}";
        $resultCliente = $db->executeQuery($selectCliente);
        if ($resultCliente->num_rows > 0) {
            foreach ($resultCliente as $cliente) {
                $preorden['cliente_nuevo'] = $cliente;
            }
        }
    }

    //vehiculo nuevo?
    if (!empty($preorden['id_vehiculo_nuevo'])) {
        //obtener los datos del vehiculo
        $selectVehiculo = "SELECT id,ano,fecha_compra,marca,modelo,placas,vin FROM sad_vehiculos WHERE id={$preorden['id_vehiculo_nuevo']}";
        $resultVehiculo = $db->executeQuery($selectVehiculo);
        if ($resultVehiculo->num_rows > 0) {
            foreach ($resultVehiculo as $vehiculo) {
                $preorden['vehiculo_nuevo'] = $vehiculo;
            }
        }
    }

    //inventario(s)?
    //buscarlo el id preorden en la tabla inventario :/
    $selectInventario = "SELECT id_preorden,id_inventario,estado FROM sad_cliente_inventario WHERE id_preorden=$idPreorden";
    $resultInventario = $db->executeQuery($selectInventario);
    if ($resultInventario->num_rows > 0) {
        foreach ($resultInventario as $inventario) {
            $inventarios[] = $inventario;
        }
        //agregar inventarios a $preorden
        $preorden['inventario'] = $inventarios;
    }

    //inspeccion
    $selectInspeccion = "SELECT id_preorden,id_inspeccion,estado FROM sad_cliente_inspeccion WHERE id_preorden=$idPreorden";
    $resultInspeccion = $db->executeQuery($selectInspeccion);
    if ($resultInspeccion->num_rows > 0) {
        foreach ($resultInspeccion as $inspeccion) {
            $inspecciones[] = $inspeccion;
        }
        //y agregar de nuevo
        $preorden['inspeccion'] = $inspecciones;
    }

    //llantas
    $selectLlantas = "SELECT id_preorden,profundidad,presion,estado,lado FROM sad_cliente_llantas WHERE id_preorden=$idPreorden";
    $resultLlantas = $db->executeQuery($selectLlantas);
    if ($resultLlantas->num_rows > 0) {
        foreach ($resultLlantas as $llanta) {
            $llantas[] = $llanta;
        }
        //y agregar
        $preorden['llantas'] = $llantas;
    }

    //frenos
    $selectFrenos = "SELECT id_preorden,porcentaje,mm,estado,lado FROM sad_cliente_frenos WHERE id_preorden=$idPreorden";
    $resultFrenos = $db->executeQuery($selectFrenos);
    if ($resultFrenos->num_rows > 0) {
        foreach ($resultFrenos as $freno) {
            $frenos[] = $freno;
        }
        $preorden['frenos'] = $frenos;
    }

    $db->closeConection();
    if ($preorden) {
        $response['result'] = $preorden;
    }
    return $response;

}


?>