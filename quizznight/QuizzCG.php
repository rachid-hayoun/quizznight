<?php
class bdd{
    private $hôte = 'localhost'; 
    private $nombdd = 'quizz night';  
    private $identifiant = 'root';   
    private $motdepasse = '';       
    private $pdo;                 
    
    public function __construct() {
        $this->pdo = new PDO("mysql:host={$this->hôte};dbname={$this->nombdd}",  $this->identifiant, $this->motdepasse);
        $this->pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    }
    // Classe pour la bdd 
    public function questions() {
        $sqlQuery = 'SELECT * FROM questions WHERE idquizz = 3 ORDER BY id ASC';
        $questionsStatement = $this->pdo->prepare($sqlQuery);
        $questionsStatement->execute();
        return $questionsStatement->fetchAll(PDO::FETCH_ASSOC);
    }
    // Fonction pour récuperer les questions de la table ordonné de manière croissante par id 
    public function reponses() {
        $sqlQuery = 'SELECT * FROM reponses ORDER BY id ASC';
        $questionsStatement = $this->pdo->prepare($sqlQuery);
        $questionsStatement->execute();
        return $questionsStatement->fetchAll(PDO::FETCH_ASSOC);
    }
    //  Fonction pour récuperer les réponses de la table ordonné de manière croissante par id
}   // Il faut changer la requiste SQL selon ce qu'on veut récupérer dans la base de données.

$bdd = new bdd();
$questions = $bdd->questions();
$reponses = $bdd->reponses();
// Instanciation des objets
?>

<form action="resultatcg.php" method="POST">
<!-- Maintenant lorsque le formulaire de type POST sera valider avec le bouton submit et renverra vers resultat.php --> 
    <table border="0" cellpadding="5" cellspacing="0">
        <?php
        foreach ($questions as $question):
            echo '<tr><th>' . $question['question'] . '</th></tr>';
            // Affichage des questions provenant de la table
            foreach ($reponses as $reponse):
                if ($reponse['questionid'] == $question['ID']):
            // Affichage des reponses trier par les id des questions
                    ?>
                    <tr>
                        <td>
                            <input type="checkbox" name="q<?php echo $question['ID']; ?>" value="<?php echo $reponse['ID']; ?>">
        <!-- On affiche les questions par leur ID et leurs reponses par leur ID en guise de valeur-->
                            <?php echo $reponse['reponse']; ?>
                        </td>
                    </tr>
                    <?php
                endif;
            endforeach;
        endforeach;
        //  On arrete les boucles
        ?>
    </table>
    <button type="submit" name="valider">Valider</button>
</form>
