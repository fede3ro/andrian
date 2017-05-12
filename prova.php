<?php

echo "CIAO ANDRIAN";
echo "</br>";

$servername = "localhost";
$username = "root";
$password = "";
$database = "DB_MAGAZZINO";

// Create connection
$link = mysql_connect($servername, $username, $password);
if (!$link) {
    die('Not connected : ' . mysql_error());
}

// make foo the current db
$db_selected = mysql_select_db($database, $link);
if (!$db_selected) {
    die ('Can\'t use foo : ' . mysql_error());
}

$result = mysql_query("SELECT * FROM tecnico") or die("Query non valida: " . mysql_error());

while ($row = mysql_fetch_row($result)) {
   echo "<h1>$row[0]</h1>";
   echo "<h1>$row[1]</h1>";
   echo "<h1>$row[2]</h1>";
   echo "<h1>$row[3]</h1>";
}

mysql_close($link);
?> 