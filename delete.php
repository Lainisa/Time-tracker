<?php

$p = $_GET['var'];

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

// Prepare SQL statement to DELETE a row in the table
$sql = ("DELETE FROM projects WHERE id = ?");
$stmt = $db->prepare($sql);



// Execute the SQL to INSERT within a try-catch to catch any errors.
try {
    $stmt->execute([$p]);
} catch (PDOException $e) {
    echo "<p>Failed to delete the row, dumping details for debug.</p>";
    echo "<p>Incoming \$_GET:<pre>" . print_r($_GET, true) . "</pre>";
    echo "<p>The error code: " . $stmt->errorCode();
    echo "<p>The error message:<pre>" . print_r($stmt->errorInfo(), true) . "</pre>";
    throw $e;
}
// redirect to index.php
header("Location: index.php");
