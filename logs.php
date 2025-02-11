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
    public function register($nom, $prenom, $mail, $numero, $identifiant, $mdp, $mdp2) {
        if ($mdp !== $mdp2) {
            return "Les mots de passe ne correspondent pas.";
        }

        $mdpHash = password_hash($mdp, PASSWORD_DEFAULT);
        $mdp2Hash = password_hash($mdp2, PASSWORD_DEFAULT);
        try {
            $query = 'INSERT INTO logs (nom, prenom, mail, numero, utilisateur, creermotdepasse, confmotdepasse) 
                      VALUES (?, ?, ?, ?, ?, ?, ?)';
            $stmt = $this->db->prepare($query);
            $stmt->execute([$nom, $prenom, $mail, $numero, $identifiant, $mdpHash, $mdp2Hash]);
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
        $mdp2 = $_POST['confmotdepasse'];

        $result = $user->register($nom, $prenom, $mail, $numero, $identifiant, $mdp, $mdp2);

        if ($result === true) {
            header('Location: accueil.php');
            exit();
        } else {
            echo $result;  
        }
    }
    if (isset($_POST['connexion'])) {
        $identifiant = $_POST['identifiant_connexion'];
        $mdp = $_POST['motdepasse_connexion'];

        $result = $user->login($identifiant, $mdp);

        if ($result === true) {
            header('Location: accueil.php');
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
    <link rel="stylesheet" href="style.css">
    <title>Page d'Inscription / Connexion</title>
</head>
<body>
            <h2>Inscription</h2>
            <form action="" method="post">
                <label for="nom">Nom :</label><br>
                <input type="text" id="nom" name="nom" required><br><br>

                <label for="prenom">Prénom :</label><br>
                <input type="text" id="prenom" name="prenom" required><br><br>

                <label for="mail">Email :</label><br>
                <input type="email" id="mail" name="mail" required><br><br>

                <label for="numero">Numéro :</label><br>
                <input type="text" id="numero" name="numero"><br><br>

                <label for="identifiant">Identifiant :</label><br>
                <input type="text" id="identifiant" name="identifiant" required><br><br>

                <label for="creermotdepasse">Mot de passe :</label><br>
                <input type="password" id="creermotdepasse" name="creermotdepasse" required><br><br>

                <label for="confmotdepasse">Confirmer le mot de passe :</label><br>
                <input type="password" id="confmotdepasse" name="confmotdepasse" required><br><br>

                <input type="submit" name="inscription" value="S'inscrire">
            </form>
            <h2>Connexion</h2>
            <form action="" method="post">
                <label for="identifiant_connexion">Identifiant :</label><br>
                <input type="text" id="identifiant_connexion" name="identifiant_connexion" required><br><br>

                <label for="motdepasse_connexion">Mot de passe :</label><br>
                <input type="password" id="motdepasse_connexion" name="motdepasse_connexion" required><br><br>

                <input type="submit" name="connexion" value="Se connecter">
            </form>
</body>
</html>
