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
?>

<!DOCTYPE html>
<html lang="sv">
    <head>
        <link rel="stylesheet" href="style/style.css">
        <meta charset="UTF-8">

    </head>

    <body>
        <main>
        <form method="post" class="form" action="post.php">
            <fieldset>
                <legend> Creat a new time tracker for a project </legend>
                    <div>
                        <label for="project">Project name</label>
                            <input required id="project" type="text" name="project" maxlength="100" minlength="3">
                            </input>
                    </div>
                    <div>
                        <label for="about">About</label>
                                <input required class="area" id="about" type="text" name="about" maxlength="500" minlength="3">
                                </input>
                    </div>
                    <div>
                        <input type="submit" value="Submit" class="button"></input>
                    </div>
            </fieldset>
        </form>

        <div class="list">
            <table>
                <thead>
                    <tr>
                        <?php foreach ($arr as $title):?>
                            <td>
                                <?php if ($title === 'active_time') : ?>
                                <?php $title = 'Active time'; ?>
                                <?php endif; ?>
                                <?= $title; ?> </td>
                        <?php endforeach; ?>
                            <td> Finish </td>
                        <td> Delete </td>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($res as $row): array_map('htmlentities', $row); ?>
                        <tr>
                            <td> <?= implode('</td><td>', $row); ?></td>
                            <td> <a href="complete.php?id=<?= $row['id'] ?>&fin=yes">&#10003;</a>
                            </td>
                            <td> <a href="delete.php?var=<?= $row['id'] ?>">&#128465;</a>
                            </td>
                            <?php if (!$_GET) : ?>
                                <td> <a href="start.php?var=<?= $row['id'] ?>">Start</a>
                                </td>
                            <?php endif; ?>
                            <!-- now i show the stop button on all when there is a getvariable, maybe i shall set to show only with same ID -->
                                <?php if ($_GET && $row['id'] === $v) : ?>
                                <td>
                                    <a href="stop.php?start_time=<?= $t ?>&var=<?= $v ?>">Stop</a>
                                </td>
                            <?php endif; ?>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
    </div>

    </body>
    <footer>
        &copy; Lina Gullsved 2020
    </footer>
    <script type="text/javascript" src="js/main.js">
    </script>
</main>
</html>
