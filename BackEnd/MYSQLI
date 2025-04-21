<?php
// php -S localhost:8000

$mysqli = null;
$host = "localhost";
$user = "root";
$password = "davidandres10!";
$bd = "CRUD";

function conectar()
{
    global $mysqli, $host, $user, $password, $bd;

    $mysqli = new mysqli($host, $user, $password, $bd);

    if ($mysqli->connect_error) {
        die("Error de conexión: " . $mysqli->connect_error);
    }
}

function desconectar()
{
    global $mysqli;
    if ($mysqli) {
        $mysqli->close();
    }
}

function metodoGet($query)
{
    global $mysqli;
    try {
        conectar();
        $result = $mysqli->query($query);
        desconectar();
        return $result;
    } catch (Exception $e) {
        die("Error: " . $e->getMessage());
    }
}

function metodoPost($query, $queryAutoIncrement)
{
    global $mysqli;
    try {
        conectar();
        $mysqli->query($query);

        $result = $mysqli->query($queryAutoIncrement);
        $idAutoIncrement = $result->fetch_assoc();

        $resultado = array_merge($idAutoIncrement, $_POST);
        desconectar();
        return $resultado;
    } catch (Exception $e) {
        die("Error: " . $e->getMessage());
    }
}

function metodoPut($query)
{
    global $mysqli;
    try {
        conectar();
        $mysqli->query($query);
        $resultado = array_merge($_GET, $_POST);
        desconectar();
        return $resultado;
    } catch (Exception $e) {
        die("Error: " . $e->getMessage());
    }
}

function metodoDelete($query)
{
    global $mysqli;
    try {
        conectar();
        $mysqli->query($query);
        desconectar();
        return $_GET['id'];
    } catch (Exception $e) {
        die("Error: " . $e->getMessage());
    }
}

function getMigrate()
{
    global $host, $user, $password, $bd;

    $mysqli = new mysqli($host, $user, $password, $bd);
    if ($mysqli->connect_error) {
        die("Error al conectar: " . $mysqli->connect_error);
    }

    $query = "CREATE TABLE IF NOT EXISTS frameworks (
        id INT AUTO_INCREMENT PRIMARY KEY,
        nombre VARCHAR(255) NOT NULL,
        lanzamiento VARCHAR(255) NOT NULL,
        desarrollador VARCHAR(255) NOT NULL
    )";
    $mysqli->query($query);
    echo "Migración ejecutada: Tabla 'frameworks' lista.<br>";

    $stmt = $mysqli->query("SELECT COUNT(*) as total FROM frameworks");
    $row = $stmt->fetch_assoc();

    if ($row['total'] == 0) {
        $insert = "INSERT INTO frameworks (nombre, lanzamiento, desarrollador) VALUES
            ('Laravel', '2011', 'Taylor Otwell'),
            ('Symfony', '2005', 'Fabien Potencier'),
            ('CodeIgniter', '2006', 'EllisLab'),
            ('Zend Framework', '2006', 'Zend Technologies')";
        $mysqli->query($insert);
        echo "Datos insertados correctamente.<br>";
    } else {
        echo "La tabla ya contiene datos, no se insertaron duplicados.<br>";
    }

    $mysqli->close();
}

?>
