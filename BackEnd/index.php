<?php

include 'bd/BD.php';

header("Access-Control-Allow-Origin: http://localhost:3000");
header('Content-Type: application/json');

$uri = $_SERVER['REQUEST_URI'];


function getMigrate()
{
    try {
        $pdo = new PDO("mysql:host=localhost;dbname=CRUD", "root", "davidandres10!");
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        $query = "CREATE TABLE IF NOT EXISTS frameworks (
            id INT AUTO_INCREMENT PRIMARY KEY,
            nombre VARCHAR(255) NOT NULL,
            lanzamiento VARCHAR(255) NOT NULL,
            desarrollador VARCHAR(255) NOT NULL
        )";
        $pdo->exec($query);
        echo "Migración ejecutada: Tabla 'frameworks' lista.<br>";

        $stmt = $pdo->query("SELECT COUNT(*) as total FROM frameworks");
        $row = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($row['total'] == 0) {
            $insert = "INSERT INTO frameworks (nombre, lanzamiento, desarrollador) VALUES
                ('Laravel', '2011', 'Taylor Otwell'),
                ('Symfony', '2005', 'Fabien Potencier'),
                ('CodeIgniter', '2006', 'EllisLab'),
                ('Zend Framework', '2006', 'Zend Technologies')";
            $pdo->exec($insert);
            echo "Datos insertados correctamente.<br>";
        } else {
            echo "La tabla ya contiene datos, no se insertaron duplicados.<br>";
        }

    } catch (PDOException $e) {
        echo "Error al migrar: " . $e->getMessage();
    }
}

if ($_SERVER['REQUEST_METHOD'] == 'POST' && $uri === '/migracion') {
    try {
        getMigrate();
        echo json_encode(["message" => "Migración ejecutada correctamente."]);
    } catch (Exception $e) {
        http_response_code(500);
        echo json_encode(["error" => "Error al ejecutar la migración: " . $e->getMessage()]);
    }
    return;
}


if ($_SERVER['REQUEST_METHOD'] == 'GET') {
    if (isset($_GET['id'])) {
        $query = "SELECT * FROM frameworks WHERE id=" . $_GET['id'];
        $resultado = metodoGet($query);
        echo json_encode($resultado->fetch(PDO::FETCH_ASSOC));
    } else {
        $query = "SELECT * FROM frameworks";
        $resultado = metodoGet($query);
        echo json_encode($resultado->fetchAll());
    }
    return;
}

if ($_POST['METHOD'] == 'POST') {
    unset($_POST['METHOD']);
    $nombre = $_POST['nombre'];
    $lanzamiento = $_POST['lanzamiento'];
    $desarrollador = $_POST['desarrollador'];

    $query = "INSERT INTO frameworks(nombre, lanzamiento, desarrollador) VALUES ('$nombre', '$lanzamiento', '$desarrollador')";
    $queryAutoIncrement = "SELECT MAX(id) as id FROM frameworks";
    $resultado = metodoPost($query, $queryAutoIncrement);

    echo json_encode($resultado);
    return;
}

if ($_POST['METHOD'] == 'PUT') {
    unset($_POST['METHOD']);
    $id = $_GET['id'];
    $nombre = $_POST['nombre'];
    $lanzamiento = $_POST['lanzamiento'];
    $desarrollador = $_POST['desarrollador'];

    $query = "UPDATE frameworks SET nombre='$nombre', lanzamiento='$lanzamiento', desarrollador='$desarrollador' WHERE id='$id'";
    $resultado = metodoPut($query);

    echo json_encode($resultado);
    return;
}

if ($_POST['METHOD'] == 'DELETE') {
    unset($_POST['METHOD']);
    $id = $_GET['id'];
    $query = "DELETE FROM frameworks WHERE id='$id'";
    $resultado = metodoDelete($query);

    echo json_encode($resultado);
    return;
}

http_response_code(400);
echo json_encode(["error" => "Bad Request"]);

?>