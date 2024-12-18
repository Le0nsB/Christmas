<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gifts</title>
    <link rel="stylesheet" href="style_gifts.css">
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

echo "<div class='cont'>";
echo "<ul>";

// Funkcija, kas aprēķina bērnu pieprasījumu katrai dāvanai
function calculateRequestedGifts($letters, $gifts) {
    $requestedCounts = [];
    foreach ($gifts as $gift) {
        $requestedCounts[$gift["name"]] = 0; // Sākotnēji pieprasījumu nav
    }
    foreach ($letters as $letter) {
        foreach ($gifts as $gift) {
            if (stripos($letter["letter_text"], $gift["name"]) !== false) {
                $requestedCounts[$gift["name"]]++;
            }
        }
    }
    return $requestedCounts;
}

// Saskaitām, cik katru dāvanu pieprasa
$requestedCounts = calculateRequestedGifts($letters, $gifts);

// Izvadām informāciju par dāvanām
foreach ($gifts as $gift) {
    $giftName = htmlspecialchars($gift["name"]);
    $countAvailable = (int)$gift["count_available"];
    $countRequested = $requestedCounts[$giftName] ?? 0;

    // Nosakām, vai pietiek dāvanu
    $status = ($countAvailable >= $countRequested) ? "Pietiek" : "Trūkst";

    echo "<li>";
    echo "<p><strong>Manta:</strong> $giftName</p>";
    echo "<p><strong>Pieejami:</strong> $countAvailable</p>";
    echo "<p><strong>Bērnu vēlmes:</strong> $countRequested</p>";
    echo "<p><strong>Statuss:</strong> $status</p>";
    echo "</li>";
}

echo "</ul>";
echo "</div>";
?>

