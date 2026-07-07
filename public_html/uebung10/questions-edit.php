<?php
require_once __DIR__ . "../../private/db.php";
$db = db();

$stmt = $db->prepare("SELECT * FROM questions WHERE id = ?");
$stmt->bind_param("i", $_GET["id"]);
$stmt->execute();
$q = $stmt->get_result()->fetch_assoc();

if (!$q) {
    die("Keine Frage bzw. ID wurde übergeben!");
}
?>
<!DOCTYPE html>
<html>
<head>
<meta charset="UTF-8">
<title>Frage bearbeiten</title>
<style>
body {
    font-family: sans-serif;
    text-align: center;
    background-color: #fff;
}

h1 {
    margin-top: 1em;
}

form {
    max-width: 30em;
    margin: 2em auto;
    text-align: left;
}

textarea, input[type="text"] {
    width: 100%;
    padding: 0.75em;
    margin-bottom: 1em;
    border: 1px solid #ccc;
    border-radius: 0.4em;
    box-sizing: border-box;
}

label {
    font-weight: bold;
    display: block;
    margin-bottom: 0.5em;
}

.answer-box {
    display: flex;
    align-items: center;
    margin-bottom: 1em;
}

.answer-box input[type="radio"] {
    margin-right: 0.5em;
}

button {
    background-color: #fff;
    border: 1px solid #888;
    padding: 0.6em 1em;
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

<h1>Frage bearbeiten</h1>

<form method="POST" action="questions-update.php">
    <input type="hidden" name="id" value="<?= $q["id"] ?>">

    <label>Frage:</label>
    <textarea name="question" required><?= htmlspecialchars($q["question"]) ?></textarea>

    <div class="answer-box">
        <input type="radio" name="solution" value="0" <?= $q["solution"] == 0 ? "checked" : "" ?>>
        <input type="text" name="answer0" value="<?= htmlspecialchars($q["answer0"]) ?>" required>
    </div>

    <div class="answer-box">
        <input type="radio" name="solution" value="1" <?= $q["solution"] == 1 ? "checked" : "" ?>>
        <input type="text" name="answer1" value="<?= htmlspecialchars($q["answer1"]) ?>" required>
    </div>

    <div class="answer-box">
        <input type="radio" name="solution" value="2" <?= $q["solution"] == 2 ? "checked" : "" ?>>
        <input type="text" name="answer2" value="<?= htmlspecialchars($q["answer2"]) ?>" required>
    </div>

    <button type="submit">Speichern</button>
</form>

</body>
</html>