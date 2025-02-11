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
        $sqlQuery = 'SELECT * FROM questions ORDER BY id ASC';
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

<table border="0" cellpadding="5" cellspacing="0">
<!--  QT1 -->
    <thead>
        <tr>
            <th>Question 1</th>
        </tr>
    </thead>
    <tbody>
    <?php
    $questionId = 1;
    foreach ($questions as $question) {
    if ($question['idquizz'] == $questionId) {
        echo '<tr><td>' . $question['question'] . '</td></tr>';
        break; 
    }
    } ?>
<?php
$counter = 0; 
foreach ($reponses as $reponse):
    if ($reponse['questionid'] == $questionId) {
        ?>
        <tr>
           <td><button><?php echo $reponse['reponse']; ?></button></td>
        </tr>
        <?php
        $counter++;
    }
endforeach;
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $selectedReponseId = $_POST['reponse'];
    $message = 'f';
    foreach ($reponses as $reponse) {
        if ($reponse['ID'] == $selectedReponseId) {
            if ($reponse['vrai'] == 1) {
                $message = "Bonne réponse !";
            } else {
                $message = "Mauvaise réponse !";
            }
            break; 
        }
    }
}
?>
<!-- QT2 -->
<tr>
    <th>Question 2</th>
</tr>
</thead>
<tbody>
    <?php
    $questionId = 2;
    foreach ($questions as $question) {
    if ($question['ID'] == $questionId) {
        echo '<tr><td>' . $question['question'] . '</td></tr>';
        break; 
    }
    } ?>
<?php
$counter = 0; 
foreach ($reponses as $reponse):
    if ($reponse['questionid'] == $questionId) {
        ?>
        <tr>
           <td><button><?php echo $reponse['reponse']; ?></button></td>
        </tr>
        <?php
        $counter++;
    }
endforeach;
?>
    <tr>
        <th>Question 3</th>
    </tr>
    </thead>
    <tbody>
    <?php
    $questionId = 3;
    foreach ($questions as $question) {
    if ($question['ID'] == $questionId) {
        echo '<tr><td>' . $question['question'] . '</td></tr>';
        break; 
    }
    } ?>
<?php
$counter = 0; 
foreach ($reponses as $reponse):
    if ($reponse['questionid'] == $questionId) {
        ?>
        <tr>
           <td><button><?php echo $reponse['reponse']; ?></button></td>
        </tr>
        <?php
        $counter++;
    }
endforeach;
?> 
<tr>
    <th>Question 4</th>
</tr>
</thead>
<tbody>
<?php
$questionId = 4;
foreach ($questions as $question) {
if ($question['ID'] == $questionId) {
echo '<tr><td>' . $question['question'] . '</td></tr>';
break; 
}
} ?>
<?php
$counter = 0; 
foreach ($reponses as $reponse):
if ($reponse['questionid'] == $questionId) {

?>
<tr>
<td><button><?php echo $reponse['reponse']; ?></button></td>
</tr>
<?php
$counter++;
}
endforeach;
?>
    <tr>
        <th>Question 5</th>
    </tr>
    </thead>
    <tbody>
    <?php
    $questionId = 5;
    foreach ($questions as $question) {
    if ($question['ID'] == $questionId) {
        echo '<tr><td>' . $question['question'] . '</td></tr>';
        break; 
    }
    } ?>
<?php
$counter = 0; 
foreach ($reponses as $reponse):
    if ($reponse['questionid'] == $questionId) {
        ?>
        <tr>
           <td><button><?php echo $reponse['reponse']; ?></button></td>
        </tr>
        <?php
        $counter++;
    }
endforeach;
?>