<?php
class Database {
    private $hôte = 'localhost'; 
    private $nombdd = 'quizz night';  // Correction du nom de la base de données
    private $identifiant = 'root';   
    private $motdepasse = '';       
    private $pdo;                 
    
    public function __construct() {
        // Connexion à la base de données
        $this->pdo = new PDO("mysql:host={$this->hôte};dbname={$this->nombdd}",  $this->identifiant, $this->motdepasse);
        $this->pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    }
}

class Crud extends Database {
    public function __construct() {
        parent::__construct();
    }

    // Fonction pour ajouter une question
    public function ajouterQuestion($question) {
        $sqlQuery = "INSERT INTO questions (question) VALUES (:question)";
        $questionsStatement = $this->pdo->prepare($sqlQuery);
        $questionsStatement->bindParam(':question', $question);
        $questionsStatement->execute();
        return $this->pdo->lastInsertId(); // Retourne l'ID de la question insérée
    }

    // Fonction pour ajouter des réponses à une question
    public function ajouterReponses($questionId, $reponses) {
        $sqlQuery = "INSERT INTO reponses (question_id, reponse) VALUES (:question_id, :reponse)";
        $questionsStatement = $this->pdo->prepare($sqlQuery);
        foreach ($reponses as $reponse) {
            $questionsStatement->bindParam(':question_id', $questionId);
            $questionsStatement->bindParam(':reponse', $reponse);
            $questionsStatement->execute();
        }
    }
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Récupérer les données envoyées depuis le formulaire
    $question = $_POST['question'];
    $reponses = [$_POST['reponse1'], $_POST['reponse2'], $_POST['reponse3']];

    $crud = new Crud();

    // Ajouter la question
    $questionId = $crud->ajouterQuestion($question);

    // Ajouter les réponses
    $crud->ajouterReponses($questionId, $reponses);
}
?>

<h1>Ajouter votre question et les réponses possibles</h1>
<form action="" method="post">
    <input type="text" name="question" placeholder="Question" required><br>
    <input type="text" name="reponse1" placeholder="Réponse 1" required><br>
    <input type="text" name="reponse2" placeholder="Réponse 2" required><br>
    <input type="text" name="reponse3" placeholder="Réponse 3" required><br>
    <button type="submit">Envoyer</button><br>
</form>
