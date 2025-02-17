<?php
// Connexion à la base de données et gestion des utilisateurs
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
                return false;
            }
        } catch (Exception $e) {
            return 'Erreur lors de la connexion : ' . $e->getMessage();
        }
    }
}

$user = new User($mysqlClient);

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (isset($_POST['connexion'])) {
        $identifiant_connexion = $_POST['identifiant_connexion'];
        $motdepasse_connexion = $_POST['motdepasse_connexion'];

        $result = $user->login($identifiant_connexion, $motdepasse_connexion);

        if ($result) {
            header('Location: crud.php');
            exit();
        } else {
            echo "<p style='color:red;'>Identifiant ou mot de passe incorrect.</p>";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="connexion.css">
    <title>Connexion à Quizz Night</title>
</head>
<body>
    <div class="container">
        <header>
            <h1>Connexion à Quizz Night</h1>
        </header>
        <section class="form-section">
            <h2>Se connecter</h2>
            <form action="" method="post" class="registration-form">
                <label for="identifiant_connexion">Identifiant :</label>
                <input type="text" id="identifiant_connexion" name="identifiant_connexion" required>

                <label for="motdepasse_connexion">Mot de passe :</label>
                <input type="password" id="motdepasse_connexion" name="motdepasse_connexion" required>

                <input type="submit" name="connexion" value="Se connecter">
            </form>
        </section>
    </div>
</body>
</html>
