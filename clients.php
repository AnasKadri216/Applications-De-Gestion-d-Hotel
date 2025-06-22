<?php
require 'includes/db.php';
include 'includes/header.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['add_client'])) {
    $name = $_POST['name'];
    $phone = $_POST['phone'];
    $conn->query("INSERT INTO clients (name, phone) VALUES ('$name', '$phone')");
    header('Location: clients.php');
    exit();
}

if (isset($_GET['delete'])) {
    $id = (int)$_GET['delete'];
    $conn->query("DELETE FROM clients WHERE id = $id");
    header('Location: clients.php');
    exit();
}

$result = $conn->query("SELECT * FROM clients");
?>

<h2>Gestion des clients</h2>
<table border="1" cellpadding="5" cellspacing="0">
<tr><th>ID</th><th>Nom</th><th>Téléphone</th><th>Actions</th></tr>
<?php while ($row = $result->fetch_assoc()): ?>
<tr>
    <td><?= $row['id'] ?></td>
    <td><?= $row['name'] ?></td>
    <td><?= $row['phone'] ?></td>
    <td><a href="clients.php?delete=<?= $row['id'] ?>" onclick="return confirm('Supprimer ce client ?')">Supprimer</a></td>
</tr>
<?php endwhile; ?>
</table>

<h3>Ajouter un client</h3>
<form method="post" action="">
    <label>Nom : <input type="text" name="name" required></label><br>
    <label>Téléphone : <input type="text" name="phone" required></label><br>
    <button type="submit" name="add_client">Ajouter</button>
</form>

<?php include 'includes/footer.php'; ?>
