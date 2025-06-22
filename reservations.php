<?php
require 'includes/db.php';
include 'includes/header.php';

$error = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['add_reservation'])) {
    $client_id = (int)$_POST['client_id'];
    $room_id = (int)$_POST['room_id'];
    $start_date = $_POST['start_date'];
    $end_date = $_POST['end_date'];

    $sql_check = "SELECT * FROM reservations WHERE room_id = $room_id
                  AND NOT (end_date < '$start_date' OR start_date > '$end_date')";
    $result_check = $conn->query($sql_check);

    if ($result_check->num_rows > 0) {
        $error = "La chambre est déjà réservée pour ces dates.";
    } else {
        $conn->query("INSERT INTO reservations (client_id, room_id, start_date, end_date) VALUES ($client_id, $room_id, '$start_date', '$end_date')");
        header('Location: reservations.php');
        exit();
    }
}

if (isset($_GET['delete'])) {
    $id = (int)$_GET['delete'];
    $conn->query("DELETE FROM reservations WHERE id = $id");
    header('Location: reservations.php');
    exit();
}

$clients = $conn->query("SELECT * FROM clients");
$rooms = $conn->query("SELECT * FROM rooms");
$reservations = $conn->query("SELECT r.id, c.name AS client_name, rm.number AS room_number, r.start_date, r.end_date
                              FROM reservations r
                              JOIN clients c ON r.client_id = c.id
                              JOIN rooms rm ON r.room_id = rm.id
                              ORDER BY r.start_date DESC");
?>

<h2>Gestion des réservations</h2>

<?php if ($error): ?>
<p style="color:red;"><?= $error ?></p>
<?php endif; ?>

<table border="1" cellpadding="5" cellspacing="0">
<tr><th>ID</th><th>Client</th><th>Chambre</th><th>Date début</th><th>Date fin</th><th>Actions</th></tr>
<?php while ($row = $reservations->fetch_assoc()): ?>
<tr>
    <td><?= $row['id'] ?></td>
    <td><?= $row['client_name'] ?></td>
    <td><?= $row['room_number'] ?></td>
    <td><?= $row['start_date'] ?></td>
    <td><?= $row['end_date'] ?></td>
    <td><a href="reservations.php?delete=<?= $row['id'] ?>" onclick="return confirm('Supprimer cette réservation ?')">Supprimer</a></td>
</tr>
<?php endwhile; ?>
</table>

<h3>Ajouter une réservation</h3>
<form method="post" action="">
    <label>Client :
        <select name="client_id" required>
            <option value="">-- Choisir un client --</option>
            <?php while ($client = $clients->fetch_assoc()): ?>
                <option value="<?= $client['id'] ?>"><?= $client['name'] ?></option>
            <?php endwhile; ?>
        </select>
    </label><br>

    <label>Chambre :
        <select name="room_id" required>
            <option value="">-- Choisir une chambre --</option>
            <?php while ($room = $rooms->fetch_assoc()): ?>
                <option value="<?= $room['id'] ?>"><?= $room['number'] ?></option>
            <?php endwhile; ?>
        </select>
    </label><br>

    <label>Date début : <input type="date" name="start_date" required></label><br>
    <label>Date fin : <input type="date" name="end_date" required></label><br>

    <button type="submit" name="add_reservation">Ajouter</button>
</form>

<?php include 'includes/footer.php'; ?>
