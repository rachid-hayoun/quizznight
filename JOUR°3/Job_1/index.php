<?php
$recipes = [200, 204, 178, 98, 171, 404, 459, 173, 171, 459];

for ($i = 0; $i < count($recipes); $i++) {
    if ($recipes[$i] % 2 === 0) {
        echo $recipes[$i] . " est pair<br>";
    } else {
        echo $recipes[$i] . " est impair<br>";
    }
}