<?php
// Start session (only if not already started)
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

/*
|--------------------------------------------------------------------------
| DATABASE CONFIGURATION
|--------------------------------------------------------------------------
*/
define("DB_HOST", "localhost");
define("DB_USER", "root");
define("DB_PASS", "");
define("DB_NAME", "odl_lhp");

/*
|--------------------------------------------------------------------------
| MYSQLi CONNECTION (PROCEDURAL + OBJECT RETURN)
|--------------------------------------------------------------------------
*/
$mysqli = mysqli_connect(DB_HOST, DB_USER, DB_PASS, DB_NAME);

if (!$mysqli) {
    die("MySQLi Connection failed: " . mysqli_connect_error());
}

/*
|--------------------------------------------------------------------------
| PDO CONNECTION
|--------------------------------------------------------------------------
*/
try {
    $pdo = new PDO(
        "mysql:host=" . DB_HOST . ";dbname=" . DB_NAME,
        DB_USER,
        DB_PASS,
        [
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
            PDO::ATTR_PERSISTENT => false
        ]
    );
} catch (PDOException $e) {
    die("PDO Connection failed: " . $e->getMessage());
}

/*
|--------------------------------------------------------------------------
| OPTIONAL: DATABASE HELPER CLASS (same as DBController)
|--------------------------------------------------------------------------
*/
class DB
{
    private $conn;

    public function __construct()
    {
        // Create mysqli object connection
        $this->conn = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);

        if ($this->conn->connect_error) {
            die("DB Class Connection Failed: " . $this->conn->connect_error);
        }
    }

    public function runQuery($query)
    {
        $result = $this->conn->query($query);
        $data = [];

        if ($result && $result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                $data[] = $row;
            }
        }

        return $data;
    }

    public function numRows($query)
    {
        $result = $this->conn->query($query);
        return $result ? $result->num_rows : 0;
    }
}
?>
