<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Children</title>
    <link rel="stylesheet" href="styles_children.css">
</head>
<body> 
<?php

require("Database.php");
$config = require("config.php");

try {
    $db = new Database($config["database"]);
    $children = $db->query("SELECT * FROM children")->fetchAll();
    $letters = $db->query("SELECT * FROM letters")->fetchAll();
    $gifts = $db->query("SELECT * FROM gifts")->fetchAll();
} catch (Exception $e) {
    die("Datubāzes kļūda: " . $e->getMessage());
}

echo "<div class='cont'>";

foreach ($children as $child) {
    foreach ($letters as $letter) {
        if ($letter["sender_id"] == $child["id"]) {
            // Izveido karti bērnam
            echo "<div class='card'>"
                . "<h4><b>"
                . htmlspecialchars($child["firstname"]) . " "
                . htmlspecialchars($child["middlename"]) . " "
                . htmlspecialchars($child["surname"]) . " "
                . htmlspecialchars($child["age"])
                . "</b></h4>"
                . "<p>" . highlightGifts($letter["letter_text"], $gifts) . "</p>" // Izcel dāvanas
                . "</div>";

            // Atrod vēlamās dāvanas un izvadi tās atsevišķi zem vēstules
            $childGifts = getChildGifts($letter["letter_text"], $gifts);
            echo "<div class='gift-list'>";
            if (!empty($childGifts)) {
                echo "<strong>Vēlamās dāvanas:</strong> " . implode(", ", $childGifts);
            } else {
                echo "<strong>Nav atrastas vēlmes.</strong>";
            }
            echo "</div>";
        }
    }
}
echo "</div>";

// Funkcija, kas izceļ dāvanas no vēstules teksta
function highlightGifts($letterText, $gifts) {
    foreach ($gifts as $gift) {
        $giftName = $gift["name"];
        // Izcel dāvanu, ja tā ir atrasta tekstā
        $letterText = preg_replace('/\b' . preg_quote($giftName, '/') . '\b/i', "<strong>$giftName</strong>", $letterText);
    }
    return htmlspecialchars_decode($letterText); // Atgriež tekstu ar izceltām dāvanām
}

// Funkcija, kas atrod dāvanas vēstulē
function getChildGifts($letterText, $gifts) {
    $childGifts = [];
    foreach ($gifts as $gift) {
        $giftName = $gift["name"];
        // Ja dāvana ir atrasta tekstā, pievieno sarakstam
        if (stripos($letterText, $giftName) !== false) {
            $childGifts[] = $giftName;
        }
    }
    return $childGifts; // Atgriež sarakstu ar atrastajām dāvanām
}
?>

<div class="cont_bottom">
    <img src="reindeer.png" class="bottom">
</div>

</body>
</html>