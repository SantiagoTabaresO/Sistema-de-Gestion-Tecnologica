<?php
/* 
TAKEN FORM: https://github.com/oscaruhp/empleados
AUTHOR: Oscar Uh

MODIFIED AND ADAPTED BY: 
Santiago Tabares
Daniel Tamayo
Paulina Arias

*/
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Headers: access");
header("Access-Control-Allow-Methods: GET,POST");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

/*  Conecta con la base de datos en el servidor local 
	usando las credenciales de usuario y contraseña */
$servidor = "localhost"; 
$usuario = "root"; 
$passwd = ""; 
$nombreBaseDatos = "sist_gestion";
$conexionBD = new mysqli($servidor, $usuario, $passwd, $nombreBaseDatos);

/**
 * Escapes a string for safe use in SQL queries.
 */
function esc($conn, $str) {
    return mysqli_real_escape_string($conn, $str);
}

// ---------------- UBICACIONES ----------------
if (isset($_GET["resource"]) && $_GET["resource"] === "ubicaciones") {

    // CONSULTAR UNO
    if (isset($_GET["consultar"])) {
        $id = intval($_GET["consultar"]);
        $sql = mysqli_query($conexionBD, "SELECT * FROM ubicaciones WHERE id=$id");
        if (mysqli_num_rows($sql) > 0) {
            echo json_encode(mysqli_fetch_assoc($sql));
        } else {
            echo json_encode(["success" => 0]);
        }
        exit();
    }

    // ELIMINAR
    if (isset($_GET["borrar"])) {
        $id = intval($_GET["borrar"]);
        $sql = mysqli_query($conexionBD, "DELETE FROM ubicaciones WHERE id=$id");
        echo json_encode(["success" => $sql ? 1 : 0]);
        exit();
    }

    // INSERTAR
    if (isset($_GET["insertar"])) {
        $data = json_decode(file_get_contents("php://input"));
        $codigo = esc($conexionBD, $data->codigo_asignado);
        $nombre = esc($conexionBD, $data->nombre_ubicacion);
        $ubic = esc($conexionBD, $data->ubicacion);
        $tel = esc($conexionBD, $data->telefono);

        $sql = mysqli_query($conexionBD, "INSERT INTO ubicaciones (codigo_asignado,nombre_ubicacion,ubicacion,telefono)
        VALUES ('$codigo','$nombre','$ubic','$tel')");
        echo json_encode(["success" => $sql ? 1 : 0]);
        exit();
    }

    // ACTUALIZAR
    if (isset($_GET["actualizar"])) {
        $id = intval($_GET["actualizar"]);
        $data = json_decode(file_get_contents("php://input"));
        $codigo = esc($conexionBD, $data->codigo_asignado);
        $nombre = esc($conexionBD, $data->nombre_ubicacion);
        $ubic = esc($conexionBD, $data->ubicacion);
        $tel = esc($conexionBD, $data->telefono);

        $sql = mysqli_query($conexionBD, "UPDATE ubicaciones 
            SET codigo_asignado='$codigo',nombre_ubicacion='$nombre',ubicacion='$ubic',telefono='$tel' WHERE id=$id");
        echo json_encode(["success" => $sql ? 1 : 0]);
        exit();
    }

    // LISTAR TODOS
    $sql = mysqli_query($conexionBD, "SELECT * FROM ubicaciones");
    echo json_encode(mysqli_fetch_all($sql, MYSQLI_ASSOC));
    exit();
}

// ---------------- RESPONSABLES ----------------
if (isset($_GET["resource"]) && $_GET["resource"] === "responsables") {

    if (isset($_GET["consultar"])) {
        $id = intval($_GET["consultar"]);
        $sql = mysqli_query($conexionBD, "SELECT * FROM responsables WHERE id=$id");
        echo json_encode(mysqli_num_rows($sql) ? mysqli_fetch_assoc($sql) : ["success" => 0]);
        exit();
    }

    if (isset($_GET["borrar"])) {
        $id = intval($_GET["borrar"]);
        $sql = mysqli_query($conexionBD, "DELETE FROM responsables WHERE id=$id");
        echo json_encode(["success" => $sql ? 1 : 0]);
        exit();
    }

    if (isset($_GET["insertar"])) {
        $data = json_decode(file_get_contents("php://input"));
        $codigo = esc($conexionBD, $data->codigo_asignado);
        $doc = esc($conexionBD, $data->documento_identidad);
        $nombre = esc($conexionBD, $data->nombre_apellidos);
        $cargo = esc($conexionBD, $data->cargo);
        $tel = esc($conexionBD, $data->telefono);

        $sql = mysqli_query($conexionBD, "INSERT INTO responsables (codigo_asignado,documento_identidad,nombre_apellidos,cargo,telefono)
        VALUES ('$codigo','$doc','$nombre','$cargo','$tel')");
        echo json_encode(["success" => $sql ? 1 : 0]);
        exit();
    }

    if (isset($_GET["actualizar"])) {
        $id = intval($_GET["actualizar"]);
        $data = json_decode(file_get_contents("php://input"));
        $codigo = esc($conexionBD, $data->codigo_asignado);
        $doc = esc($conexionBD, $data->documento_identidad);
        $nombre = esc($conexionBD, $data->nombre_apellidos);
        $cargo = esc($conexionBD, $data->cargo);
        $tel = esc($conexionBD, $data->telefono);

        $sql = mysqli_query($conexionBD, "UPDATE responsables SET 
          codigo_asignado='$codigo',documento_identidad='$doc',nombre_apellidos='$nombre',cargo='$cargo',telefono='$tel' WHERE id=$id");
        echo json_encode(["success" => $sql ? 1 : 0]);
        exit();
    }

    $sql = mysqli_query($conexionBD, "SELECT * FROM responsables");
    echo json_encode(mysqli_fetch_all($sql, MYSQLI_ASSOC));
    exit();
}

// ---------------- EQUIPOS MÉDICOS ----------------
if (isset($_GET["resource"]) && $_GET["resource"] === "equipos_medicos") {

    if (isset($_GET["consultar"])) {
        $id = intval($_GET["consultar"]);
        $sql = mysqli_query($conexionBD, "SELECT * FROM equipos_medicos WHERE id=$id");
        echo json_encode(mysqli_num_rows($sql) ? mysqli_fetch_assoc($sql) : ["success" => 0]);
        exit();
    }

    if (isset($_GET["borrar"])) {
        $id = intval($_GET["borrar"]);
        $sql = mysqli_query($conexionBD, "DELETE FROM equipos_medicos WHERE id=$id");
        echo json_encode(["success" => $sql ? 1 : 0]);
        exit();
    }

    if (isset($_GET["insertar"])) {
        $data = json_decode(file_get_contents("php://input"));
        $num = esc($conexionBD, $data->numero_activo);
        $marca = esc($conexionBD, $data->marca);
        $modelo = esc($conexionBD, $data->modelo);
        $codUb = esc($conexionBD, $data->codigo_ubicacion);
        $codResp = esc($conexionBD, $data->codigo_responsable);

        $sql = mysqli_query($conexionBD, "INSERT INTO equipos_medicos (numero_activo,marca,modelo,codigo_ubicacion,codigo_responsable)
        VALUES ('$num','$marca','$modelo','$codUb','$codResp')");
        echo json_encode(["success" => $sql ? 1 : 0]);
        exit();
    }

    if (isset($_GET["actualizar"])) {
        $id = intval($_GET["actualizar"]);
        $data = json_decode(file_get_contents("php://input"));
        $num = esc($conexionBD, $data->numero_activo);
        $marca = esc($conexionBD, $data->marca);
        $modelo = esc($conexionBD, $data->modelo);
        $codUb = esc($conexionBD, $data->codigo_ubicacion);
        $codResp = esc($conexionBD, $data->codigo_responsable);

        $sql = mysqli_query($conexionBD, "UPDATE equipos_medicos SET 
          numero_activo='$num',marca='$marca',modelo='$modelo',codigo_ubicacion='$codUb',codigo_responsable='$codResp' WHERE id=$id");
        echo json_encode(["success" => $sql ? 1 : 0]);
        exit();
    }

    $sql = mysqli_query($conexionBD, "SELECT * FROM equipos_medicos");
    echo json_encode(mysqli_fetch_all($sql, MYSQLI_ASSOC));
    exit();
}

else{ echo json_encode([["success"=>0]]); }
?>