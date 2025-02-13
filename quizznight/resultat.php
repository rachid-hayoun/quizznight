<?php
include('QuizzPHP.php');
 // Inclure la classe de la base de données
$bdd = new bdd();
$reponses = $bdd->reponses();  // Récupérer toutes les réponses possibles

$bonnesReponses = 0;

if (isset($_POST['valider'])) {  
    for ($i = 1; $i <= 5; $i++) {
        if (isset($_POST["q$i"])) {
            $reponseSelectionneeId = $_POST["q$i"];
            
            // Vérifier la réponse correspondante dans la base de données
            foreach ($reponses as $reponse) {
                if ($reponse['ID'] == $reponseSelectionneeId && $reponse['vrai'] == 1) {
                    $bonnesReponses++; // Incrémenter si la réponse est correcte
                    break;
                }
            }
        }
    }

    // Afficher le résultat
    echo "Vous avez " . $bonnesReponses . " /5.";
} else {
    echo "Veuillez valider votre réponse.";
}
?>