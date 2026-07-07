<?php
session_name("zxojf48u08");
session_start();
require_once("hangman_lib.php");

if (!isset($_SESSION['toGuess'])) {
    header("Location: hangman-init.php");
    exit;
}

$mask = $_SESSION['mask'];
$errors = $_SESSION['errorCount'];
$state = $_SESSION['state'];
$word = $_SESSION['toGuess'];
$guessed = $_SESSION['guessedLetters'];
?>
<!DOCTYPE html>
<html>
<head>
<meta charset="UTF-8">
<title>Hangman</title>
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
    button {
        margin: 3px;
        padding: 8px 12px;
        font-size: 16px;
    }
</style>
</head>
<body>

<h1>Wörter raten</h1>

<h2><?php echo implode(" ", $mask); ?></h2>

<?php if ($state === 0): ?>
<form action="hangman-guess.php" method="POST">
<?php
foreach (range('A','Z') as $c) {
    if (!in_array($c, $guessed)) {
        echo "<button type='submit' name='letter' value='$c'>$c</button> ";
    }
}
?>
</form>
<?php endif; ?>

<p>Fehlversuche: <?php echo $errors; ?> / 8</p>

<img src="img/fish-<?php echo $errors; ?>.svg" width="600">

<?php if ($state === 1): ?>
<p>Gewonnen!</p>
<p><a href="hangman-init.php">Neues Spiel</a></p>
<?php endif; ?>

<?php if ($state === 2): ?>
<p>Verloren! Das Wort war: <?php echo $word; ?></p>
<p><a href="hangman-init.php">Neues Spiel</a></p>
<?php endif; ?>

</body>
</html>
