<?php
require_once('conexion.php');

header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");

$method = $_SERVER['REQUEST_METHOD'];

switch ($method) {
    case 'POST': // Crear
        $data = json_decode(file_get_contents("php://input"), true);
        if (isset($data['nomb_usuario']) && isset($data['ape_usuario']) && isset($data['user_usuario']) && isset($data['pass_usuario']) && isset($data['telefono_usuario']) && isset($data['estado_usuario']) && isset($data['cod_hacienda'])) {
            $nomb_usuario = $mysqli->real_escape_string($data['nomb_usuario']);
            $ape_usuario = $mysqli->real_escape_string($data['ape_usuario']);
            $user_usuario = $mysqli->real_escape_string($data['user_usuario']);
            $pass_usuario = $mysqli->real_escape_string($data['pass_usuario']);
            $telefono_usuario = intval($data['telefono_usuario']);
            $estado_usuario = $mysqli->real_escape_string($data['estado_usuario']);
            $cod_hacienda = intval($data['cod_hacienda']);

            $query = "INSERT INTO usuarios (nomb_usuario, ape_usuario, user_usuario, pass_usuario, telefono_usuario, estado_usuario, cod_hacienda) VALUES ('$nomb_usuario', '$ape_usuario', '$user_usuario', '$pass_usuario', $telefono_usuario, '$estado_usuario', $cod_hacienda)";
            $result = $mysqli->query($query);

            if ($result) {
                echo json_encode(array("success" => true, "message" => "Usuario creado correctamente"));
            } else {
                echo json_encode(array("error" => true, "message" => "Error al crear el usuario: " . $mysqli->error));
            }
        } else {
            echo json_encode(array("error" => true, "message" => "Datos incompletos para crear el usuario"));
        }
        break;

    case 'GET': // Leer
        $query = "SELECT * FROM usuarios";
        $result = $mysqli->query($query);

        if ($result) {
            $usuarios = array();
            while ($row = $result->fetch_assoc()) {
                $usuario = array(
                    "cod_usuario" => $row['cod_usuario'],
                    "nomb_usuario" => $row['nomb_usuario'],
                    "ape_usuario" => $row['ape_usuario'],
                    "user_usuario" => $row['user_usuario'],
                    "telefono_usuario" => $row['telefono_usuario'],
                    "estado_usuario" => $row['estado_usuario'],
                    "cod_hacienda" => $row['cod_hacienda']
                );
                $usuarios[] = $usuario;
            }
            echo json_encode($usuarios);
        } else {
            echo json_encode(array("error" => true, "message" => "Error al obtener usuarios: " . $mysqli->error));
        }
        break;

    case 'PUT': // Actualizar (activar)
        $data = json_decode(file_get_contents("php://input"), true);
        if (isset($data['cod_usuario'])) {
            $cod_usuario = intval($data['cod_usuario']);
            $query = "UPDATE usuarios SET estado_usuario='activo' WHERE cod_usuario=$cod_usuario";
            $result = $mysqli->query($query);
            if ($result) {
                echo json_encode(array("success" => true, "message" => "Usuario activado correctamente"));
            } else {
                echo json_encode(array("error" => true, "message" => "Error al activar el usuario: " . $mysqli->error));
            }
        } else {
            echo json_encode(array("error" => true, "message" => "Datos incompletos para activar el usuario"));
        }
        break;

    case 'PATCH': // Actualizar
        $data = json_decode(file_get_contents("php://input"), true);
        if (isset($data['cod_usuario']) && isset($data['nomb_usuario']) && isset($data['ape_usuario']) && isset($data['user_usuario']) && isset($data['telefono_usuario']) && isset($data['estado_usuario']) && isset($data['cod_hacienda'])) {
            $cod_usuario = intval($data['cod_usuario']);
            $nomb_usuario = $mysqli->real_escape_string($data['nomb_usuario']);
            $ape_usuario = $mysqli->real_escape_string($data['ape_usuario']);
            $user_usuario = $mysqli->real_escape_string($data['user_usuario']);
            $telefono_usuario = intval($data['telefono_usuario']);
            $estado_usuario = $mysqli->real_escape_string($data['estado_usuario']);
            $cod_hacienda = intval($data['cod_hacienda']);

            $query = "UPDATE usuarios SET nomb_usuario='$nomb_usuario', ape_usuario='$ape_usuario', user_usuario='$user_usuario', telefono_usuario=$telefono_usuario, estado_usuario='$estado_usuario', cod_hacienda=$cod_hacienda WHERE cod_usuario=$cod_usuario";
            $result = $mysqli->query($query);

            if ($result) {
                echo json_encode(array("success" => true, "message" => "Usuario actualizado correctamente"));
            } else {
                echo json_encode(array("error" => true, "message" => "Error al actualizar el usuario: " . $mysqli->error));
            }
        } else {
            echo json_encode(array("error" => true, "message" => "Datos incompletos para actualizar el usuario"));
        }
        break;

    case 'DELETE': // Eliminar
        $data = json_decode(file_get_contents("php://input"), true);
        if (isset($data['cod_usuario'])) {
            $cod_usuario = intval($data['cod_usuario']);
            $query = "DELETE FROM usuarios WHERE cod_usuario=$cod_usuario";
            $result = $mysqli->query($query);
            if ($result) {
                echo json_encode(array("success" => true, "message" => "Usuario eliminado correctamente"));
            } else {
                echo json_encode(array("error" => true, "message" => "Error al eliminar el usuario: " . $mysqli->error));
            }
        } else {
            echo json_encode(array("error" => true, "message" => "Datos incompletos para eliminar el usuario"));
        }
        break;

    default:
        echo json_encode(array("error" => true, "message" => "Método no válido"));
        break;
}

$mysqli->close();
?>
