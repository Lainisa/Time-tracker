<?php

$p = $_GET['var'];
echo $p;

//get the date from when you hit the start-button
$d = date("Y/m/d H:i");

//Send it back together with the ID $p

// redirect to index.php
header("Location: index.php?start_time=$d&var=$p");
