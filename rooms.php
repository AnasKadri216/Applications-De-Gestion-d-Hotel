<?php
require 'includes/db.php';
include 'includes/header.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['add_room'])) {
    $number = $_POST['number'];
    $type = $_POST['type'];
    $price = (float)$_POST['price'];
    $conn->query("INSERT INTO rooms (number, type, price) VALUES ('$number', '$type', $price)");
    header('Location: rooms.php');
    exit();
}

if (isset($_GET['delete'])) {
    $id = (int)$_GET['delete'];
    $conn->query("DELETE FROM rooms WHERE id = $id");
    header('Location: rooms.php');
    exit();
}

$result = $conn->query("SELECT * FROM rooms");
?>

<h2>Gestion des chambres</h2>
<table border="1" cellpadding="5" cellspacing="0">
<tr><th>ID</th><th>Numéro</th><th>Type</th><th>Prix (€)</th><th>Actions</th></tr>
<?php while ($row = $result->fetch_assoc()): ?>
<tr>
    <td><?= $row['id'] ?></td>
    <td><?= $row['number'] ?></td>
    <td><?= $row['type'] ?></td>
    <td><?= $row['price'] ?></td>
    <td><a href="rooms.php?delete=<?= $row['id'] ?>" onclick="return confirm('Supprimer cette chambre ?')">Supprimer</a></td>
</tr>
<?php endwhile; ?>
</table>

<h3>Ajouter une chambre</h3>
<form method="post" action="">
    <label>Numéro : <input type="text" name="number" required></label><br>
    <label>Type : <input type="text" name="type" required></label><br>
    <label>Prix (€) : <input type="number" step="0.01" name="price" required></label><br>
    <button type="submit" name="add_room">Ajouter</button>
</form>

<?php include 'includes/footer.php'; ?>
