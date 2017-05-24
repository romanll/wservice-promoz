<?php
/**
 * Created by PhpStorm.
 * User: Sistemas
 * Date: 17/05/2017
 * Time: 13:28
 * las funciones en el archivo de redaccion
 */


function consultarPrueba($token,$identificador,$tipo){
    //code
    return
        array(
            array(
                'id'=>123456,
                'fecha'=>'2017-01-01',
                'folio'=>'A123',
                'id_agencia'=>20,
                'id_usuario'=>415,
                'id_modelo'=>158,
                'id_paquete'=>5,
                'monto_paquete'=>400.00,
                'km'=>15000.00,
                'servicios'=>'Paquete X',
                'nota'=>'ASDFGH',
                'imagen'=>'aqui que?',
                'id_cliente'=>2568,
                //'id_cliente_nuevo'=>null,
                'id_vehiculo'=>3522,
                //'id_vehiculo_nuevo'=>null
            )
        );
}

//asignacion de valores
$id=20;
$tipo='AGENCIA';
$token=sha1( '2aBxyz3'. date('Ymd') .$identificador.$tipo );

//asignacion de los valores en arrelo 'parametros'
$parametros=array(
    'token'=>$token,
    'identificador'=>$identificador,
    'tipo'=>$tipo
);

//llamar al metodo, enviando como parametro el arreglo datos
$result=$cliente->call('listarPreordenes',array('datos'=>$parametros));


//'id', 'fecha', 'folio', 'id_agencia', 'id_usuario', 'id_modelo', 'id_paquete', 'monto_paquete', 'km', 'servicios', 'nota', 'imagen', 'id_cliente', 'id_vehiculo'


//identificador de preorden y token
$identificador=555;
$token=sha1( 'abc123A'. date('Ymd') .$identificador );

//asignacion de los valores en arrelo 'parametros'
$parametros=array(
    'token'=>$token,
    'identificador'=>$identificador
);

//llamar al metodo, enviando como parametro el arreglo datos
$result=$cliente->call('detallePreorden',array('datos'=>$parametros));

array(
    'id'=>123456,
    'fecha'=>'2017-01-01',
    'folio'=>'A123',
    'id_agencia'=>20,
    'id_usuario'=>415,
    'id_modelo'=>158,
    'id_paquete'=>5,
    'monto_paquete'=>400.00,
    'km'=>15000.00,
    'servicios'=>'Paquete X',
    'nota'=>'ASDFGH',
    'imagen'=>'www.dominio.com/imagenes/A1245.jpg',
    'id_cliente'=>null,
    'id_cliente_nuevo'=>3333,
    'cliente_nuevo'=>array(
        'id'=>3333,
        'nombre'=>'Jose',
        'paterno'=>'Perez',
        'materno'=>'Garcia',
        'calle'=>'Av. falsa',
        'numero_exterior'=>'2020',
        'numero_interior'=>'B5',
        'colonia'=>'Villas 8',
        'cp'=>'22800',
        'estado'=>'Baja California',
        'ciudad'=>'Ensenada',
        'fecha_nacimiento'=>'1985-02-12',
        'telefono_casa'=>'6461234567',
        'telefono_oficina'=>'',
        'celular'=>'6462144444',
        'correo'=>'prueba@gmail.com',
        'fac_rfc'=>'GAPJ850212AAA',
        'fac_razon_social'=>'Jose Perez Garcia',
        'fac_estado'=>'Baja California',
        'fac_ciudad'=>'Ensenada',
        'fac_calle'=>'Av. falsa',
        'fac_numero_exterior'=>'2020',
        'fac_numero_interior'=>'B5',
        'fac_colonia'=>'Villas 8',
        'fac_cp'=>'22800'
    ),
    'id_vehiculo'=>null,
    'id_vehiculo_nuevo'=>58745,
    'vehiculo_nuevo'=>array(
        'id'=>58745,
        'ano'=>2016,
        'fecha_compra'=>'2016-05-12',
        'marca'=>15,
        'modelo'=>10,
        'placas'=>'ABC123CD',
        'vin'=>'XYZ'
    ),
    'inventario'=>array(
        'id_preorden'=>123456,
        'id_inventario'=>6698,
        'estado'=>2
    ),
    'inspeccion'=>array(
        'id_preorden'=>123456,
        'id_inspeccion'=>7854,
        'estado'=>1
    ),
    'llantas'=>array(
        'id_preorden'=>123456,
        'profundidad'=>1,
        'presion'=>25,
        'estado'=>1,
        'lado'=>'X'
    ),
    'frenos'=>array(
        'id_preorden'=>123456,
        'porcentaje'=>20,
        'mm'=>3,
        'estado'=>3,
        'lado'=>'Y'
    )
);

/*
<llantas xsi:type="SOAP-ENC:Array" SOAP-ENC:arrayType=":[2]">
    <item xsi:type="xsd:">
        <id_preorden xsi:type="xsd:string">1</id_preorden>
        <profundidad xsi:type="xsd:string">5</profundidad>
        <presion xsi:type="xsd:string">15</presion>
        <estado xsi:type="xsd:string">3</estado>
        <lado xsi:type="xsd:string">A</lado>
    </item>
    <item xsi:type="xsd:">
        <id_preorden xsi:type="xsd:string">1</id_preorden>
        <profundidad xsi:type="xsd:string">101</profundidad>
        <presion xsi:type="xsd:string">10</presion>
        <estado xsi:type="xsd:string">10</estado>
        <lado xsi:type="xsd:string">B</lado>
    </item>
</llantas>
*/