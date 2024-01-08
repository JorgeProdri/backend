<?php
require_once('conexion.php');

header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");

$method = $_SERVER['REQUEST_METHOD'];

switch ($method) {
    case 'POST': // Crear
        $data = json_decode(file_get_contents("php://input"), true);
        if (isset($data['nomb_lote']) && isset($data['dimenx_lote']) && isset($data['dimeny_lote']) && isset($data['estado_lote']) && isset($data['cod_hacienda'])) {
            $nomb_lote = $mysqli->real_escape_string($data['nomb_lote']);
            $dimenx_lote = intval($data['dimenx_lote']);
            $dimeny_lote = intval($data['dimeny_lote']);
            $estado_lote = $mysqli->real_escape_string($data['estado_lote']);
            $cod_hacienda = intval($data['cod_hacienda']);

            $query = "INSERT INTO lote (nomb_lote, dimenx_lote, dimeny_lote, estado_lote, cod_hacienda) VALUES ('$nomb_lote', $dimenx_lote, $dimeny_lote, '$estado_lote', $cod_hacienda)";
            $result = $mysqli->query($query);

            if ($result) {
                echo json_encode(array("success" => true, "message" => "Lote creado correctamente"));
            } else {
                echo json_encode(array("error" => true, "message" => "Error al crear el lote: " . $mysqli->error));
            }
        } else {
            echo json_encode(array("error" => true, "message" => "Datos incompletos para crear el lote"));
        }
        break;

    case 'GET': // Leer
        $query = "SELECT * FROM lote";
        $result = $mysqli->query($query);

        if ($result) {
            $lotes = array();
            while ($row = $result->fetch_assoc()) {
                $lote = array(
                    "cod_lote" => $row['cod_lote'],
                    "nomb_lote" => $row['nomb_lote'],
                    "dimenx_lote" => $row['dimenx_lote'],
                    "dimeny_lote" => $row['dimeny_lote'],
                    "estado_lote" => $row['estado_lote'],
                    "cod_hacienda" => $row['cod_hacienda']
                );
                $lotes[] = $lote;
            }
            echo json_encode($lotes);
        } else {
            echo json_encode(array("error" => true, "message" => "Error al obtener los lotes: " . $mysqli->error));
        }
        break;

    case 'PUT': // Actualizar (activar)
        $data = json_decode(file_get_contents("php://input"), true);
        if (isset($data['cod_lote'])) {
            $cod_lote = intval($data['cod_lote']);
            $query = "UPDATE lote SET estado_lote='activo' WHERE cod_lote=$cod_lote";
            $result = $mysqli->query($query);
            if ($result) {
                echo json_encode(array("success" => true, "message" => "Lote activado correctamente"));
            } else {
                echo json_encode(array("error" => true, "message" => "Error al activar el lote: " . $mysqli->error));
            }
        } else {
            echo json_encode(array("error" => true, "message" => "Datos incompletos para activar el lote"));
        }
        break;

    case 'PATCH': // Actualizar
        $data = json_decode(file_get_contents("php://input"), true);
        if (isset($data['cod_lote']) && isset($data['nomb_lote']) && isset($data['dimenx_lote']) && isset($data['dimeny_lote']) && isset($data['estado_lote']) && isset($data['cod_hacienda'])) {
            $cod_lote = intval($data['cod_lote']);
            $nomb_lote = $mysqli->real_escape_string($data['nomb_lote']);
            $dimenx_lote = intval($data['dimenx_lote']);
            $dimeny_lote = intval($data['dimeny_lote']);
            $estado_lote = $mysqli->real_escape_string($data['estado_lote']);
            $cod_hacienda = intval($data['cod_hacienda']);

            $query = "UPDATE lote SET nomb_lote='$nomb_lote', dimenx_lote=$dimenx_lote, dimeny_lote=$dimeny_lote, estado_lote='$estado_lote', cod_hacienda=$cod_hacienda WHERE cod_lote=$cod_lote";
            $result = $mysqli->query($query);

            if ($result) {
                echo json_encode(array("success" => true, "message" => "Lote actualizado correctamente"));
            } else {
                echo json_encode(array("error" => true, "message" => "Error al actualizar el lote: " . $mysqli->error));
            }
        } else {
            echo json_encode(array("error" => true, "message" => "Datos incompletos para actualizar el lote"));
        }
        break;

    case 'DELETE': // Eliminar
        $data = json_decode(file_get_contents("php://input"), true);
        if (isset($data['cod_lote'])) {
            $cod_lote = intval($data['cod_lote']);
            $query = "DELETE FROM lote WHERE cod_lote=$cod_lote";
            $result = $mysqli->query($query);
            if ($result) {
                echo json_encode(array("success" => true, "message" => "Lote eliminado correctamente"));
            } else {
                echo json_encode(array("error" => true, "message" => "Error al eliminar el lote: " . $mysqli->error));
            }
        } else {
            echo json_encode(array("error" => true, "message" => "Datos incompletos para eliminar el lote"));
        }
        break;

    default:
        echo json_encode(array("error" => true, "message" => "Método no válido"));
        break;
}

$mysqli->close();
?>
