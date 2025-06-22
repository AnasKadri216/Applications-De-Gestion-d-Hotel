<?php
session_start();
if (isset($_SESSION['username'])) {
    header('Location: dashboard.php');
    exit();
}
require 'includes/db.php';

$error = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = $_POST['username'] ?? '';
    $password = $_POST['password'] ?? '';

    $result = $conn->query("SELECT * FROM users WHERE username = '$username' AND password = '$password'");

    if ($result && $result->num_rows > 0) {
        $_SESSION['username'] = $username;
        header('Location: dashboard.php');
        exit();
    } else {
        $error = "Identifiants incorrects";
    }
}
?>

<?php include 'includes/header.php'; ?>
<h2>Connexion</h2>
<?php if ($error): ?>
<p style="color:red;"><?= $error ?></p>
<?php endif; ?>
<form method="post" action="">
    <label>Utilisateur : <input type="text" name="username" required></label><br>
    <label>Mot de passe : <input type="password" name="password" required></label><br>
    <button type="submit">Se connecter</button>
</form>
<?php include 'includes/footer.php'; ?>
