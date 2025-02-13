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
                return false; // Si l'identifiant ou le mot de passe est incorrect
            }
        } catch (Exception $e) {
            return 'Erreur lors de la connexion : ' . $e->getMessage();
        }
    }
}

$user = new User($mysqlClient);

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Vérifier si le formulaire de connexion est soumis
    if (isset($_POST['connexion'])) {
        $identifiant_connexion = $_POST['identifiant_connexion'];
        $motdepasse_connexion = $_POST['motdepasse_connexion'];

        // Appeler la méthode de connexion de l'utilisateur
        $result = $user->login($identifiant_connexion, $motdepasse_connexion);

        // Si la connexion réussit, rediriger vers la page accueil.php
        if ($result) {
            header('Location: accueil.php');
            exit();
        } else {

        }
    }
}
?>
<link rel="stylesheet" href="style.css">
<h2>Connexion</h2>
<form action="" method="post">
    <label for="identifiant_connexion">Identifiant :</label><br>
    <input type="text" id="identifiant_connexion" name="identifiant_connexion" required><br><br>

    <label for="motdepasse_connexion">Mot de passe :</label><br>
    <input type="password" id="motdepasse_connexion" name="motdepasse_connexion" required><br><br>

    <input type="submit" name="connexion" value="Se connecter">
</form>
