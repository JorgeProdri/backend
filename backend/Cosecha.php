<?php
require_once('conexion.php');

header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");

$method = $_SERVER['REQUEST_METHOD'];

switch ($method) {
    case 'POST': // Crear
        $data = json_decode(file_get_contents("php://input"), true);
        if (isset($data['fecha_cosecha']) && isset($data['produc_cosecha']) && isset($data['estado_cosecha']) && isset($data['cod_lote'])) {
            $fecha_cosecha = $mysqli->real_escape_string($data['fecha_cosecha']);
            $produc_cosecha = floatval($data['produc_cosecha']);
            $estado_cosecha = $mysqli->real_escape_string($data['estado_cosecha']);
            $cod_lote = intval($data['cod_lote']);

            $query = "INSERT INTO cosecha (fecha_cosecha, produc_cosecha, estado_cosecha, cod_lote) VALUES ('$fecha_cosecha', $produc_cosecha, '$estado_cosecha', $cod_lote)";
            $result = $mysqli->query($query);

            if ($result) {
                echo json_encode(array("success" => true, "message" => "Cosecha creada correctamente"));
            } else {
                echo json_encode(array("error" => true, "message" => "Error al crear la cosecha: " . $mysqli->error));
            }
        } else {
            echo json_encode(array("error" => true, "message" => "Datos incompletos para crear la cosecha"));
        }
        break;

    case 'GET': // Leer
        $query = "SELECT * FROM cosecha";
        $result = $mysqli->query($query);

        if ($result) {
            $cosechas = array();
            while ($row = $result->fetch_assoc()) {
                $cosecha = array(
                    "cod_cosecha" => $row['cod_cosecha'],
                    "fecha_cosecha" => $row['fecha_cosecha'],
                    "produc_cosecha" => $row['produc_cosecha'],
                    "estado_cosecha" => $row['estado_cosecha'],
                    "cod_lote" => $row['cod_lote']
                );
                $cosechas[] = $cosecha;
            }
            echo json_encode($cosechas);
        } else {
            echo json_encode(array("error" => true, "message" => "Error al obtener las cosechas: " . $mysqli->error));
        }
        break;

    case 'PUT': // Actualizar (activar)
        $data = json_decode(file_get_contents("php://input"), true);
        if (isset($data['cod_cosecha'])) {
            $cod_cosecha = intval($data['cod_cosecha']);
            $query = "UPDATE cosecha SET estado_cosecha='activo' WHERE cod_cosecha=$cod_cosecha";
            $result = $mysqli->query($query);
            if ($result) {
                echo json_encode(array("success" => true, "message" => "Cosecha activada correctamente"));
            } else {
                echo json_encode(array("error" => true, "message" => "Error al activar la cosecha: " . $mysqli->error));
            }
        } else {
            echo json_encode(array("error" => true, "message" => "Datos incompletos para activar la cosecha"));
        }
        break;

    case 'PATCH': // Actualizar
        $data = json_decode(file_get_contents("php://input"), true);
        if (isset($data['cod_cosecha']) && isset($data['fecha_cosecha']) && isset($data['produc_cosecha']) && isset($data['estado_cosecha']) && isset($data['cod_lote'])) {
            $cod_cosecha = intval($data['cod_cosecha']);
            $fecha_cosecha = $mysqli->real_escape_string($data['fecha_cosecha']);
            $produc_cosecha = floatval($data['produc_cosecha']);
            $estado_cosecha = $mysqli->real_escape_string($data['estado_cosecha']);
            $cod_lote = intval($data['cod_lote']);

            $query = "UPDATE cosecha SET fecha_cosecha='$fecha_cosecha', produc_cosecha=$produc_cosecha, estado_cosecha='$estado_cosecha', cod_lote=$cod_lote WHERE cod_cosecha=$cod_cosecha";
            $result = $mysqli->query($query);

            if ($result) {
                echo json_encode(array("success" => true, "message" => "Cosecha actualizada correctamente"));
            } else {
                echo json_encode(array("error" => true, "message" => "Error al actualizar la cosecha: " . $mysqli->error));
            }
        } else {
            echo json_encode(array("error" => true, "message" => "Datos incompletos para actualizar la cosecha"));
        }
        break;

    case 'DELETE': // Eliminar
        $data = json_decode(file_get_contents("php://input"), true);
        if (isset($data['cod_cosecha'])) {
            $cod_cosecha = intval($data['cod_cosecha']);
            $query = "DELETE FROM cosecha WHERE cod_cosecha=$cod_cosecha";
            $result = $mysqli->query($query);
            if ($result) {
                echo json_encode(array("success" => true, "message" => "Cosecha eliminada correctamente"));
            } else {
                echo json_encode(array("error" => true, "message" => "Error al eliminar la cosecha: " . $mysqli->error));
            }
        } else {
            echo json_encode(array("error" => true, "message" => "Datos incompletos para eliminar la cosecha"));
        }
        break;

    default:
        echo json_encode(array("error" => true, "message" => "Método no válido"));
        break;
}

$mysqli->close();
?>
