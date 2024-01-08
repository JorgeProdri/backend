<?php
require_once('conexion.php');

header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");

$method = $_SERVER['REQUEST_METHOD'];

switch ($method) {
    case 'POST': // Crear
        $data = json_decode(file_get_contents("php://input"), true);
        if (isset($data['nombre']) && isset($data['direccion']) && isset($data['contacto'])) {
            $nombre = $mysqli->real_escape_string($data['nombre']);
            $direccion = $mysqli->real_escape_string($data['direccion']);
            $contacto = intval($data['contacto']);

            $query = "INSERT INTO hacienda (nomb_hacienda, direccion_hacienda, contac_hacienda) VALUES ('$nombre', '$direccion', $contacto)";
            $result = $mysqli->query($query);

            if ($result) {
                echo json_encode(array("success" => true, "message" => "Hacienda creada correctamente"));
            } else {
                echo json_encode(array("error" => true, "message" => "Error al crear la hacienda: " . $mysqli->error));
            }
        } else {
            echo json_encode(array("error" => true, "message" => "Datos incompletos para crear la hacienda"));
        }
        break;

    case 'GET': // Leer
        $query = "SELECT * FROM hacienda";
        $result = $mysqli->query($query);

        if ($result) {
            $haciendas = array();
            while ($row = $result->fetch_assoc()) {
                $hacienda = array(
                    "cod_hacienda" => $row['cod_hacienda'],
                    "nomb_hacienda" => $row['nomb_hacienda'],
                    "direccion_hacienda" => $row['direccion_hacienda'],
                    "contac_hacienda" => $row['contac_hacienda']
                );
                $haciendas[] = $hacienda;
            }
            echo json_encode($haciendas);
        } else {
            echo json_encode(array("error" => true, "message" => "Error al obtener las haciendas: " . $mysqli->error));
        }
        break;

    case 'PUT': // Actualizar (activar)
        $data = json_decode(file_get_contents("php://input"), true);
        if (isset($data['cod_hacienda'])) {
            $cod_hacienda = intval($data['cod_hacienda']);
            $query = "UPDATE hacienda SET estado_hacienda=1 WHERE cod_hacienda=$cod_hacienda";
            $result = $mysqli->query($query);
            if ($result) {
                echo json_encode(array("success" => true, "message" => "Hacienda activada correctamente"));
            } else {
                echo json_encode(array("error" => true, "message" => "Error al activar la hacienda: " . $mysqli->error));
            }
        } else {
            echo json_encode(array("error" => true, "message" => "Datos incompletos para activar la hacienda"));
        }
        break;

    case 'PATCH': // Actualizar
        $data = json_decode(file_get_contents("php://input"), true);
        if (isset($data['cod_hacienda']) && isset($data['nomb_hacienda']) && isset($data['direccion_hacienda']) && isset($data['contac_hacienda'])) {
            $cod_hacienda = intval($data['cod_hacienda']);
            $nomb_hacienda = $mysqli->real_escape_string($data['nomb_hacienda']);
            $direccion_hacienda = $mysqli->real_escape_string($data['direccion_hacienda']);
            $contac_hacienda = intval($data['contac_hacienda']);

            $query = "UPDATE hacienda SET nomb_hacienda='$nomb_hacienda', direccion_hacienda='$direccion_hacienda', contac_hacienda=$contac_hacienda WHERE cod_hacienda=$cod_hacienda";
            $result = $mysqli->query($query);

            if ($result) {
                echo json_encode(array("success" => true, "message" => "Hacienda actualizada correctamente"));
            } else {
                echo json_encode(array("error" => true, "message" => "Error al actualizar la hacienda: " . $mysqli->error));
            }
        } else {
            echo json_encode(array("error" => true, "message" => "Datos incompletos para actualizar la hacienda"));
        }
        break;

    case 'DELETE': // Eliminar
        $data = json_decode(file_get_contents("php://input"), true);
        if (isset($data['cod_hacienda'])) {
            $cod_hacienda = intval($data['cod_hacienda']);
            $query = "DELETE FROM hacienda WHERE cod_hacienda=$cod_hacienda";
            $result = $mysqli->query($query);
            if ($result) {
                echo json_encode(array("success" => true, "message" => "Hacienda eliminada correctamente"));
            } else {
                echo json_encode(array("error" => true, "message" => "Error al eliminar la hacienda: " . $mysqli->error));
            }
        } else {
            echo json_encode(array("error" => true, "message" => "Datos incompletos para eliminar la hacienda"));
        }
        break;

    default:
        echo json_encode(array("error" => true, "message" => "Método no válido"));
        break;
}

$mysqli->close();
?>
