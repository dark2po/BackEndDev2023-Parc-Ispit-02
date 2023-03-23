<?php
// PHP dio aplikacije
// deklariranje funkcije koja broji suglasnike i samoglasnike
function consonants_vowels($word)
{
    $word = strtolower($word);
    $consonants = $vowels = 0;
    $allVowelLetters = ["a", "e", "i", "o", "u"];
    for ($i = 0; $i < strlen($word); $i++) {
        if (in_array($word[$i], $allVowelLetters)) {
            $vowels++;
        } elseif ($word[$i] >= 'a' && $word[$i] <= 'z') {
            $consonants++;
        }
    }
    return [$consonants, $vowels];
}
// čitanje podataka iz JSON datoteke u niz
$wordsJson = file_get_contents('words.json');
$words = json_decode($wordsJson, true);
$_SESSION['header_text'] = 'Upišite željenu riječ!';
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // ako je napravljen submit
    // dohvaćanje stringa iz forme POST metodom
    $word = $_POST['word'];
    $noCharacters = strlen($word);
    [$noConsonants, $noVowels] = consonants_vowels($word);


    if ($noCharacters == 0) {
        $_SESSION['header_text'] = 'Polje ne smije biti prazno!';
    } elseif ($noCharacters > $noConsonants + $noVowels) {
        $_SESSION['header_text'] = 'Koristite nedozvoljene znakove!<br>Koristite samo slova engleske abecede.';
    } else {
        $words[] = [
            'word' => $word,
            'noLetters' => $noCharacters,
            'noConsonants' => $noConsonants,
            'noVowels' => $noVowels
        ];
        // spremanje novih podataka tj izmjenjenog niza nazad u JSON
        $wordsJson = json_encode($words, JSON_PRETTY_PRINT);
        file_put_contents('words.json', $wordsJson);
    }
}
// Ispod je HTML dio aplikacije
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Parcijalni 02</title>
    <style>
        .flex-container {
            display: flex;
            align-items: center;
        }

        .flex-container>div {
            margin: 10px;
            padding: 20px;

        }

        .center {
            margin: auto;
            width: 75%;
            padding: 10px;
        }
    </style>
</head>

<body>
    <div class="center">
        <?php
        //if ($_SESSION['header_text'] == NULL) {
        //    echo '<div><h1>Upišite željenu riječ!</h1></div>';
        //} elseif ($_SESSION['header_text'] == 'Empty') {
        //    echo '<div><h1>Polje ne smije biti prazno!</h1></div>';
        //} elseif ($_SESSION['header_text'] == 'NonLetterUsed') {
        //    echo '<div><h1>Koristite nedozvoljene znakove!<br>Koristite samo slova.</h1></div>';
        //}
        echo '<div><h1>' . $_SESSION['header_text'] . '</h1></div>';
        ?>
    </div>
    <div class="flex-container">
        <div>
            <form action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>" method="post">
                <label>Upišite riječ:</label>
                <br>
                <input type="text" name="word">
                <br><br>
                <input type="submit" value="pošalji">
            </form>

        </div>
        <div>
            <table border="1" , cellpadding="5">
                <tr>
                    <th>Riječ</th>
                    <th>Broj slova</th>
                    <th>Broj suglasnika</th>
                    <th>Broj samoglasnika</th>
                </tr>
            <?php
                foreach ($words as $word) {
                    echo    "<tr>";
                    echo        "<td>$word[word]</td>";
                    echo        "<td>$word[noLetters]</td>";
                    echo        "<td>$word[noConsonants]</td>";
                    echo        "<td>$word[noVowels]</td>";
                    echo    "</tr>";
                }

            echo '</table>';
            ?>
        </div>
    </div>
</body>

</html>