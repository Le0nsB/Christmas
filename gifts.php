<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    
</body>
</html>
<?php

require("Database.php");
$config = require("config.php");

$db = new Database($config["database"]);
$gifts = $db->query("SELECT * FROM gifts")->fetchAll();
$letters = $db->query("SELECT * FROM letters")->fetchAll();

echo "<div>";
echo "<ul>";
foreach($gifts as $gift){

  echo "<p>" ."Manta: ". $gift["name"] ." Pieejami: ". $gift["count_available"] . "</p>";


}
echo "</ul>";
echo "</div>";