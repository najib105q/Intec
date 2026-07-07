<?php
require_once __DIR__ . "../../private/db.php";
$db = db();

$stmt = $db->prepare(
    "UPDATE questions
     SET question=?, answer0=?, answer1=?, answer2=?, solution=?
     WHERE id=?"
);

$stmt->bind_param(
    "ssssii",
    $_POST["question"],
    $_POST["answer0"],
    $_POST["answer1"],
    $_POST["answer2"],
    $_POST["solution"],
    $_POST["id"]
);

$stmt->execute();
header("Location: questions-show.php");
exit;
?>