<?php
function transformWord($word) {
    $word = str_replace(
        ['ä','ö','ü','ß','Ä','Ö','Ü'],
        ['ae','oe','ue','ss','AE','OE','UE'],
        $word
    );
    return strtoupper($word);
}

function maskWord($word) {
    return array_fill(0, strlen($word), "_");
}

function getAllWords() {
    return [
        "Abend","Abhilfe","Abtastrate","Adel","Ahndung","Amtseid","Anbau","Andenken","Anfügen",
        "Angreifer","Anstand","Ära","Arbeitsamt","Atombomber","Auerhahn","Aufhellen","Aufwertung",
        "Ausflug","Ausfluss","Auslenken","Axiom","Babel","Bächlein","Badehaus","Bärin","Basar",
        "Becken","Beethoven","Bergbau","Bespannung","Bewirtung","Bewundern","Billett","Bolivien",
        "Bruthenne","Buffet","Camembert","Dammriss","Datenanzug","Datenblatt","Diagnose","Dienstweg",
        "Dollarfall","Dorf","Dozent","Eckplatz","Edelgas","Ehezwist","Ehrengast","Einfluss","Endlauf",
        "Entzug","Enzian","Epilepsie","Equalizer","Equipment","Erbauer","Ersticken","Ethologin",
        "Fakultät","Faust","Fazit","Fechterin","Fischzug","Fixstern","Fluorid","Flusslauf","Fremdwort",
        "Fußpfad","Garn","Gedeck","Gefolge","Gegenwind","Gegner","Gehalt","Gehör","Gehweg","Geldgeber",
        "Geplärre","Gerücht","Gesäusel","Gesicht","Glieder","Glutamat","Gold","Greiferin","Grundidee",
        "Hafenbahn","Hälfte","Halunke","Haselmaus","Häuptling","Hauptwerk","Hebamme","Heck","Hirn",
        "Holzpfad","Hotelpark","Igelchen","Impfpass","Impfung","Indianer","Infarkt","Inselchen",
        "Interesse","Junikäfer","Justiziar","Kämpfer","Katakombe","Kätzchen","Kenner","Kesselchen",
        "Ketzer","Kibbuz","Kläger","Klarlack","Klebeband","Kleinod","Klerus","Klischee","Knast","Koch",
        "Köln","Komplizin","Konfident","Königtum","Konsens","Koreakrieg","Krümmung","Kühlhaus",
        "Kunstmaler","Kupon","Lastfahrer","Laube","Läufer","Lehrinhalt","Leiterin","Lenkrad",
        "Lichtkegel","Limes","Lumen","Lümmel","Mafia","Malmittel","Manöver","Mansarde","Manufaktur",
        "Markt","Marxistin","Mauritius","Meer","Meerechse","Metallbau","Minimum","Mitwelt","Mokka",
        "Mondtag","Mordsgaudi","Münchener","Muslimin","Nagel","Neckar","Nerz","Nullwert","Obdach",
        "Operand","Osthang","Paradies","Parlament","Passbild","Pfad","Pflicht","Phantom","Piercing",
        "Piratin","Pluspunkt","Politesse","Pollinie","Poster","Prediger","Querulant","Quotieren",
        "Radiologe","Rat","Rechner","Ritual","Route","Rückblick","Salafist","Saloniki","Sardinien",
        "Sarg","Schachzug","Scherin","Schlesier","Schleuser","Schund","Schüssel","Seegras","Senkgrube",
        "Sichtung","Sirius","Sittich","Sitzplatz","Slalom","Sokrates","Solvenz","Spaten","Spender",
        "Spickaal","Spielbaum","Spinat","Sportlerin","Sprachkern","Staffelei","Steigerung","Steinbau",
        "Stilart","Stockholm","Stoßzeit","Strand","Strohhalm","Sünder","Tabu","Taupunkt","Telefonat",
        "Textur","Tisch","Toleranz","Totenkopf","Transkript","Trauzeuge","Trödler","Tuchmacher",
        "Tyrann","Ulk","Umbruch","Umtrieb","Umwälzung","Unglaube","Unionist","Ventil","Verfilzen",
        "Verriss","Vielzahl","Vikar","Virologe","Vorgabe","Vorkoster","Vorstoß","Wäscher","Wecker",
        "Weintraube","Weiterflug","Wellental","Wichtel","Wortsinn","Zähheit","Zahlung","Zäpfchen",
        "Zauberhand","Zerrung","Zinnkrug","Zinssatz","Zölibat","Zugpferd","Zulieferer","Zündpunkt",
        "Zuspruch"
    ];
}

function getRandomWord() {
    $w = getAllWords();
    return $w[array_rand($w)];
}

function initGame() {
    $w = transformWord(getRandomWord());
    $_SESSION['toGuess'] = $w;
    $_SESSION['mask'] = maskWord($w);
    $_SESSION['guessedLetters'] = [];
    $_SESSION['errorCount'] = 0;
    $_SESSION['state'] = 0;
}

function guessLetter($letter) {
    $letter = strtoupper($letter);
    if (in_array($letter, $_SESSION['guessedLetters'])) return;
    $_SESSION['guessedLetters'][] = $letter;

    $word = $_SESSION['toGuess'];
    $mask = &$_SESSION['mask'];
    $found = false;

    for ($i = 0; $i < strlen($word); $i++) {
        if ($word[$i] === $letter) {
            $mask[$i] = $letter;
            $found = true;
        }
    }

    if (!$found) $_SESSION['errorCount']++;

    if ($_SESSION['errorCount'] > 8) $_SESSION['state'] = 2;
    elseif (!in_array("_", $mask)) $_SESSION['state'] = 1;
    else $_SESSION['state'] = 0;
}
?>
