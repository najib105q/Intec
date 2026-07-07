<?php
require_once "db.php";
$db = db();

$stmt = $db->prepare("SELECT * FROM questions ORDER BY id");
$stmt->execute();
$result = $stmt->get_result();
?>
<!DOCTYPE html>
<html>
<head>
<meta charset="UTF-8">
<title>Fragen anzeigen</title>
<style>
body {
    font-family: sans-serif;
    text-align: center;
    background-color: #fff;
}

h1 {
    margin-top: 1em;
}

table {
    border-collapse: collapse;
    width: 90%;
    margin: 2em auto;
}

th, td {
    border: 1px solid #ccc;
    padding: 0.75em;
    text-align: center;
}

.correct {
    background-color: #c8f7c5;
}

.wrong {
    background-color: #f7c5c5;
}

a {
    color: #0077cc;
    font-weight: bold;
    text-decoration: none;
}

a:hover {
    text-decoration: underline;
}

button {
    background-color: #fff;
    border: 1px solid #888;
    padding: 0.4em 0.8em;
    border-radius: 0.4em;
    cursor: pointer;
    transition: background-color 0.2s ease;
}

button:hover {
    background-color: #ddd;
}
</style>
</head>
<body>

<h1>Fragen anzeigen</h1>

<table>
<tr>
    <th>Frage</th>
    <th>Antwort0</th>
    <th>Antwort1</th>
    <th>Antwort2</th>
    <th></th>
    <th></th>
</tr>

<?php while ($row = $result->fetch_assoc()): ?>
<tr>
    <td><?= htmlspecialchars($row["question"]) ?></td>

    <?php for ($i=0; $i<3; $i++):
        $class = ($row["solution"] == $i) ? "correct" : "wrong";
    ?>
        <td class="<?= $class ?>"><?= htmlspecialchars($row["answer".$i]) ?></td>
    <?php endfor; ?>

    <td>
        <form method="GET" action="questions-edit.php">
            <input type="hidden" name="id" value="<?= $row["id"] ?>">
            <button type="submit">Bearbeiten</button>
        </form>
    </td>
    <td>
        <form method="POST" action="questions-delete.php">
            <input type="hidden" name="id" value="<?= $row["id"] ?>">
            <button type="submit">Löschen</button>
        </form>
    </td>
</tr>
<?php endwhile; ?>
</table>

<p><a href="questions-create.php">Frage hinzufügen</a></p>

</body>
</html>