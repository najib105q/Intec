<?php
session_name("zxojf48u08");
session_start();
require_once 'hangman_lib.php';
$words = getAllWords();
?>
<!DOCTYPE html>
<html lang="de">
<head>
    <meta charset="UTF-8">
    <title>Alle Wörter</title>
    <style>
        body {
            font-family: sans-serif;
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
            margin: 0;
            background: #f5f5f5;
            text-align: center;
        }
        table {
            border-collapse: collapse;
            width: 600px;
            margin-top: 20px;
        }
        th, td {
            border: 1px solid #ccc;
            padding: 8px;
            text-align: left;
        }
        th {
            background-color: #f2f2f2;
        }
        h1 {
            font-family: 'Times New Roman', Times, serif;
        }
    </style>
</head>
<body>

<h1>Alle Wörter</h1>
<table>
    <tr>
        <th>Wort</th>
        <th>Zu raten</th>
        <th>Maske</th>
    </tr>
    <?php
    foreach ($words as $originalWord) {
        $t = transformWord($originalWord);
        $m = implode(' ', maskWord($t));
        echo "<tr>
                <td>".htmlspecialchars($originalWord)."</td>
                <td>".htmlspecialchars($t)."</td>
                <td>".htmlspecialchars($m)."</td>
              </tr>";
    }
    ?>
</table>

</body>
</html>
