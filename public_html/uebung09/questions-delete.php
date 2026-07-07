<?php
require_once __DIR__ . "private/db.php";
$db = db();

$stmt = $db->prepare("DELETE FROM questions WHERE id = ?");
$stmt->bind_param("i", $_POST["id"]);
$stmt->execute();

header("Location: questions-show.php");
exit;
?>