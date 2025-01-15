<?php

$str = ["I'm sorry Dave I'm afraid I can't do that"];
$voy = ['A', 'E', 'I', 'O', 'U', 'Y', 'a', 'e', 'i', 'o', 'u', 'y'];

for ($i = 0; $i < strlen($str[0]); $i++) {
    // $i pour commencer au premier index de la liste
    //$i < strlen signifie que si la liste de caractères dépassent le nombre de charactère alors tout s'arrêtent
    // strlen($str[0]) calcule le nom de caractères de la liste $str en commencant par l'index 0cela fixe une limite pour pas que la boucle 
    // continue.
    if (in_array($str[0][$i], $voy)) {
    // in_array($str[0]) vérifie que chaque caractere de $str est aussi dans $voy pour qu'il l'affiche
    // $i est un curseur qu'on positionne dans la liste comme point de départ
        echo $str[0][$i];
    }
}