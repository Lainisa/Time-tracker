<?php
$t = $_GET['start_time'];
$v = $_GET['var'];

//have the start time as incoming $t and need to check time right now
$d = date("Y/m/d H:i");
//echo "<br>time right now as variable d:" . $d;

//need to compare the start and stop time to figure out how much time was spent
$q = new DateTime($t);
$w = new DateTime($d);
$result = $w->diff($q);

//get the result as DD:HH:MM
$r = $result->format("%D:%H:%I");

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
$stmt = $db->prepare("SELECT * FROM projects WHERE ID = ?");
$stmt->execute([$v]);

// Get the results as an array with column names as array keys
$res = $stmt->fetchAll(PDO::FETCH_ASSOC);
//check for earlier active time in table on that id
$ot = $res[0]["active_time"];

//if less then a minute pass then just set same time as before in active time
if ($r === '00:00:00') {
    $stmt = $db->prepare("UPDATE projects SET active_time = ? WHERE ID = ?");
    $stmt->execute([$ot, $v]);
} else {
    //if no time before in active time then set the diff-time as active time
    if (!$ot) {
        // Prepare and execute the SQL statement
        $stmt = $db->prepare("UPDATE projects SET active_time = ? WHERE ID = ?");
        $stmt->execute([$r, $v]);
    } else {
        //get the times in split them with the :
        $resTimeToAdd = explode(":", $r);
        $resSavedTime = explode(":", $ot);
        //straighten out wich one is which in the time to add
        $daysToAdd = $resTimeToAdd[0];
        $hoursToAdd = $resTimeToAdd[1];
        $minutesToAdd = $resTimeToAdd[2];
        //straighten out wich one is which in earlier saved active time
        $days = $resSavedTime[0];
        $hours = $resSavedTime[1];
        $minutes = $resSavedTime[2];
        //calculate total minutes and total hours and total days
        $totalMinutes = $minutes + $minutesToAdd;
        $totalHours = $hours + $hoursToAdd;
        $totalDays = $days + $daysToAdd;

        if ($totalMinutes >= 60) {
            //find left overs minutes after made into hours
            $newminutes = $totalMinutes % 60;
            $newhoursToSave = floor($totalMinutes / 60) + $totalHours;

            if ($newhoursToSave >= 24) {
                //find left overs hours after transformed into days
                $newhours = $newhoursToSave % 24;
                $newdays = floor($newhoursToSave / 24) + $totalDays;
            }
        } else {
            $newminutes = $totalMinutes;
            $newhours = $hoursToAdd;
            $newdays = $daysToAdd;
        }
        //to make it pretty in string format
        if ($newminutes < 10) {
            $newminutes = "0" . $newminutes;
        }
        if ($newhours < 10) {
            $newhours = "0" . $newhours;
        }
        if ($newdays < 10) {
            $newdays = "0" . $newdays;
        }
        //get new time 
        $totalTime = $newdays . ":" . $newhours . ":" . $newminutes;

        // Prepare and execute the SQL statement
        $stmt = $db->prepare("UPDATE projects SET active_time = ? WHERE id = ? ");

        $stmt->execute([$totalTime, $v]);
    }
}


// redirect to index.php
header("Location: index.php");
