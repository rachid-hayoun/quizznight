<?php
for ($i = 0; $i <= 100; $i++) {

    if ($i == 42) {
        echo "La Plateforme_<br>";
    }

    else if ($i >= 0 && $i <= 20) {
        echo "<i>$i</i><br>";
    }
    else if ($i >= 25 && $i <= 50) {
        echo "<u>$i</u><br>";
    }

    else {
        echo $i . "<br>";
    }
}
?>
