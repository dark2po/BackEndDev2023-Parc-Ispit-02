<?php
// deklariranje funkcije koja broji suglasnike i samoglasnike
function consonants_vowels($word){
    $word = strtolower($word);
    $consonants = 0;
    $vowels = 0;
    $allVowelLetters = ["a", "e", "i", "o", "u"];

    for ($i=0; $i < strlen($word); $i++) {
        if (in_array($word[$i], $allVowelLetters)) {
            $vowels++;
        } elseif ($word[$i] >= 'a' && $word[$i] <= 'z') {
            $consonants++;
        }
    }
    return [$consonants, $vowels];
}
// varijabla vraća kod grešaka u index.php kako bi se ispisalo odgovarajuće zaglavlje, definiranje pocetne vrijednosti
$_SESSION['error_message'] = NULL;

// dohvaćanje stringa iz forme POST metodom
$word = $_POST['word'];
$noCharacters = strlen($word);
[$noConsonants, $noVowels] = consonants_vowels($_POST['word']);

if ($noCharacters == 0) {
    $_SESSION['error_message'] = 'Empty';
} elseif ($noCharacters > $noConsonants + $noVowels) {
    $_SESSION['error_message'] = 'NonLetterUsed';
} else {
    $wordsJson = file_get_contents('words.json');
    $words = json_decode($wordsJson, true);
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
//var_dump($_SESSION); die;
require 'index.php';
?>