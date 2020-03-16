<?php
// Create a DSN for the database using its filename
$fileName = __DIR__ . "/db/projects.db";
$dsn = "sqlite:$fileName";

// Open the database file and catch the exception if it fails.
try {
    $db = new PDO($dsn);
    $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    echo "Failed to connect to the database using DSN:<br>$dsn<br>";
    throw $e;
}

// Prepare and execute the SQL statement
$stmt = $db->prepare("SELECT * FROM projects");
$stmt->execute();

// Get the results as an array with column names as array keys
$res = $stmt->fetchAll(PDO::FETCH_ASSOC);

$arr = array_keys($res[0]);

if ($_GET) {
    $t = $_GET['start_time'] ?? null;
    $v = $_GET['var'] ?? null;
};

include("view/header.php");
include("view/form.php");
include("view/results.php");
include("view/footer.php");
