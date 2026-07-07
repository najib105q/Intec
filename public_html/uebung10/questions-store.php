<?php
require_once __DIR__ . "../../private/db.php";
$db = db();

$required = ["question", "answer0", "answer1", "answer2", "solution"];
foreach ($required as $field) {
    if (!isset($_POST[$field]) || trim($_POST[$field]) === "") {
        die("Fehler: Feld '$field' fehlt oder ist leer.");
    }
}

$stmt = $db->prepare(
    "INSERT INTO questions (question, answer0, answer1, answer2, solution)
     VALUES (?, ?, ?, ?, ?)"
);

$stmt->bind_param(
    "ssssi",
    $_POST["question"],
    $_POST["answer0"],
    $_POST["answer1"],
    $_POST["answer2"],
    $_POST["solution"]
);

$stmt->execute();

header("Location: questions-show.php");
exit;
?>