<?php
class Database {
    private $host = 'localhost';
    private $dbname = 'quizz night';
    private $username = 'root';
    private $password = '';
    private $charset = 'utf8';
    private $pdo;
    public function connect() {
        if ($this->pdo === null) {
            try {
                $dsn = "mysql:host=$this->host;dbname=$this->dbname;charset=$this->charset";
                $this->pdo = new PDO($dsn, $this->username, $this->password);
                $this->pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
                
            } catch (PDOException $e) {
                die('Erreur de connexion à la base de données : ' . $e->getMessage());
            }
        }
        return $this->pdo;
    }
}
$db = new Database();
$mysqlClient = $db->connect();
class User {
    private $db;

    public function __construct($db) {
        $this->db = $db;
    }
    public function register($nom, $prenom, $mail, $numero, $identifiant, $mdp) {
        $mdpHash = password_hash($mdp, PASSWORD_DEFAULT);
        try {
            $query = 'INSERT INTO logs (nom, prenom, mail, numero, utilisateur, creermotdepasse) 
                      VALUES (?, ?, ?, ?, ?, ?)';
            $stmt = $this->db->prepare($query);
            $stmt->execute([$nom, $prenom, $mail, $numero, $identifiant, $mdpHash]);
            return true;
        } catch (Exception $e) {
            return 'Erreur lors de l\'inscription : ' . $e->getMessage();
        }
    }
    public function login($identifiant, $mdp) {
        try {
            $query = 'SELECT * FROM logs WHERE utilisateur = ?';
            $stmt = $this->db->prepare($query);
            $stmt->execute([$identifiant]);
            $user = $stmt->fetch();

            if ($user && password_verify($mdp, $user['creermotdepasse'])) {
                return true;
            } else {
                return "";
            }
        } catch (Exception $e) {
            return 'Erreur lors de la connexion : ' . $e->getMessage();
        }
    }
}
$user = new User($mysqlClient);
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (isset($_POST['inscription'])) {
        $nom = $_POST['nom'];
        $prenom = $_POST['prenom'];
        $mail = $_POST['mail'];
        $numero = $_POST['numero'];
        $identifiant = $_POST['identifiant'];
        $mdp = $_POST['creermotdepasse'];
        $result = $user->register($nom, $prenom, $mail, $numero, $identifiant, $mdp);

        if ($result === true) {
            header('Location: connexion.php');
            exit();
        } else {
            echo $result;  
        }
    }
}
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="accueil2.css">
    <title>Page d'Inscription / Connexion</title>
</head>
<body>
    <div class="container">
        <header>
            <h1>Inscription à Quizz Night</h1>
        </header>
        <section class="form-section">
            <h2>Créez un compte</h2>
            <form action="" method="post" class="registration-form">
                <label for="nom">Nom :</label>
                <input type="text" id="nom" name="nom" required>

                <label for="prenom">Prénom :</label>
                <input type="text" id="prenom" name="prenom" required>

                <label for="mail">Email :</label>
                <input type="email" id="mail" name="mail" required>

                <label for="numero">Numéro :</label>
                <input type="tel" id="numero" name="numero">

                <label for="identifiant">Identifiant :</label>
                <input type="text" id="identifiant" name="identifiant" required>

                <label for="creermotdepasse">Mot de passe :</label>
                <input type="password" id="creermotdepasse" name="creermotdepasse" required>

                <input type="submit" name="inscription" value="S'inscrire">
            </form>
        </section>
    </div>
</body>
</html>
