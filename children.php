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
$children = $db->query("SELECT * FROM children")->fetchAll();
$letters = $db->query("SELECT * FROM letters")->fetchAll();

echo "<div class='cont'>";
foreach($children as $child){
    foreach($letters as $letter){
        if($letter["sender_id"] == $child["id"] ){
            echo "<div class='card'>". "<h4>" . "<b>" . $child["firstname"] ." ". $child["middlename"] ." ".  $child["surname"] ." ".  $child["age"] ."</b>"."</h4>". "<p>". $letter["letter_text"] ."</p>". "</div>";
        }
    }
}
echo "</div>";