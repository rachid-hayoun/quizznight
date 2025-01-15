<?php
function estPremier($n) {
    if ($n <= 1) {
        return false; 
    }
    for ($i = 2; $i <= sqrt($n); $i++) {
        if ($n % $i == 0) {
            return false; 
        }
    }
    return true; 
}

for ($i = 2; $i <= 1000; $i++) {
    if (estPremier($i)) {
        echo $i . "<br>";
    }
}
?>
