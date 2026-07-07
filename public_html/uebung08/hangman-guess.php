<?php
session_name("zxojf48u08");
session_start();
require_once("hangman_lib.php");
if (isset($_POST['letter'])) guessLetter($_POST['letter']);
header("Location: hangman.php");
exit;
?>
