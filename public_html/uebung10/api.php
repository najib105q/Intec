<?php
require_once __DIR__ . "private/db.php";
$db = db();

$n = isset($_GET["n"]) ? intval($_GET["n"]) : 10;

header("Content-Type: application/json");

$stmt = $db->prepare("SELECT * FROM questions ORDER BY RAND() LIMIT ?");
$stmt->bind_param("i", $n);
$stmt->execute();
$res = $stmt->get_result();

$questions = [];

while ($row = $res->fetch_assoc()) {
    $questions[] = [
        "id" => (int)$row["id"],
        "question" => $row["question"],
        "answers" => [
            $row["answer0"],
            $row["answer1"],
            $row["answer2"]
        ],
        "solution" => (int)$row["solution"]
    ];
}

echo json_encode($questions);