<?php
class bdd {
    private $hôte = 'localhost'; 
    private $nombdd = 'quizz night';  
    private $identifiant = 'root';   
    private $motdepasse = '';       
    private $pdo;                 
    
    public function __construct() {
        $this->pdo = new PDO("mysql:host={$this->hôte};dbname={$this->nombdd}",  $this->identifiant, $this->motdepasse);
        $this->pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    }

    public function questions() {
        $sqlQuery = 'SELECT * FROM questions WHERE idquizz = 3 ORDER BY id ASC';
        $questionsStatement = $this->pdo->prepare($sqlQuery);
        $questionsStatement->execute();
        return $questionsStatement->fetchAll(PDO::FETCH_ASSOC);
    }

    public function reponses() {
        $sqlQuery = 'SELECT * FROM reponses ORDER BY id ASC';
        $questionsStatement = $this->pdo->prepare($sqlQuery);
        $questionsStatement->execute();
        return $questionsStatement->fetchAll(PDO::FETCH_ASSOC);
    }
}

$bdd = new bdd();
$questions = $bdd->questions();
$reponses = $bdd->reponses();
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="quizz1.css">
    <title>Quizz Night</title>
</head>
<body>
    <div class="container">
        <header>
            <h1>Quizz Night</h1>
        </header>
        <section class="form-section">
            <h2>Répondez aux questions</h2>
            <form action="resultatcg.php" method="POST">
                <table border="0" cellpadding="5" cellspacing="0">
                    <?php
                    foreach ($questions as $question):
                        echo '<tr><th>' . $question['question'] . '</th></tr>';
                        foreach ($reponses as $reponse):
                            if ($reponse['questionid'] == $question['ID']):
                                ?>
                                <tr>
                                    <td>
                                        <input type="checkbox" name="q<?php echo $question['ID']; ?>" value="<?php echo $reponse['ID']; ?>">
                                        <?php echo $reponse['reponse']; ?>
                                    </td>
                                </tr>
                                <?php
                            endif;
                        endforeach;
                    endforeach;
                    ?>
                </table>
                <button type="submit" name="valider" class="submit-btn">Valider</button>
            </form>
        </section>
    </div>
</body>
</html>
