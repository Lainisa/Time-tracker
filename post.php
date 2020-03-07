<?php
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

//the projects name
$project = $_POST['project'] ?? null;

//about project
$about = $_POST['about'] ?? null;

//time started
$started = date('Y/m/d H:i');

// Prepare and execute the SQL statement
$stmt = $db->prepare("INSERT INTO projects (name, about, started) VALUES (?, ?, ?)");

$stmt->execute([$project, $about, $started]);
$res = $stmt->fetchAll(PDO::FETCH_ASSOC);

// redirect to index.php
header("Location: index.php");
?>
