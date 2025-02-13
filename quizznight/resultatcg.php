<?php
include('QuizzCG.php'); // On suppose que cette ligne inclut la connexion à la base de données

$bdd = new bdd();
$reponses = $bdd->reponses(); // Récupérer toutes les réponses de la base de données

$bonnesReponses = 0; // Initialiser le compteur des bonnes réponses

if (isset($_POST['valider'])) {
    // Parcourir les questions et vérifier les réponses sélectionnées
    foreach ($_POST as $questionId => $reponseSelectionneeId) {
        // Vérifier que la clé n'est pas le bouton de validation
        if ($questionId != 'valider') {
            // Récupérer l'ID de la question en enlevant le préfixe "q"
            $questionIdNum = substr($questionId, 1); // "q1" devient 1, "q2" devient 2, etc.

            // Vérifier si la réponse correspond à une bonne réponse dans la base de données
            foreach ($reponses as $reponse) {
                if ($reponse['ID'] == $reponseSelectionneeId && $reponse['vrai'] == 1 && $reponse['questionid'] == $questionIdNum) {
                    $bonnesReponses++; // Incrémenter le compteur des bonnes réponses
                    break; // Sortir de la boucle dès qu'on a trouvé une bonne réponse
                }
            }
        }
    }

    // Affichage du résultat
    echo "Vous avez " . $bonnesReponses . " /5.";
} else {
    echo "Veuillez valider votre réponse.";
}
?>
