<?php
$host = 'localhost';
$dbname = 'rejestracja';
$user = 'root';
$pass = '';

try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8mb4", $user, $pass, [
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION
    ]);

    if ($_SERVER["REQUEST_METHOD"] === "POST") {
        $login = $_POST['login'] ?? '';
        $password = $_POST['password'] ?? '';
        $description = $_POST['description'] ?? '';

        if (!empty($login) && !empty($password)) {
            $salt = bin2hex(random_bytes(16));
            $saltedPassword = $salt . $password;
            $hashedPassword = password_hash($saltedPassword, PASSWORD_BCRYPT);

            $stmt = $pdo->prepare("INSERT INTO users (login, password, description) VALUES (:login, :password, :description)");
            $stmt->execute([
                ':login' => $login,
                ':password' => $hashedPassword,
                ':description' => $description
            ]);

            header("Location: " . $_SERVER['HTTP_REFERER']);
            exit;
        } else {
            echo "Login i hasło są wymagane!";
        }
    }
} catch (PDOException $e) {
    die("Błąd połączenia: " . $e->getMessage());
}
