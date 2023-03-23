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
        .flex-container > div {
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
    if ($_SESSION['error_message'] == NULL) {
        echo '<div><h1>Upišite željenu riječ!</h1></div>';
    } elseif ($_SESSION['error_message'] == 'Empty') {
        echo '<div><h1>Polje ne smije biti prazno!</h1></div>';
    } elseif ($_SESSION['error_message'] == 'NonLetterUsed') {
        echo '<div><h1>Koristite nedozvoljene znakove!<br>Koristite samo slova.</h1></div>';
    }
    ?>
</div>
<div class="flex-container">
    <div>
        <form action="word_check.php" method="post">
        <label>Upišite riječ:</label>
        <br>
        <input type="text" name="word">
        <br><br>
        <input type="submit" value="pošalji">
        </form>

    </div>
    <div>
        <?php
        $wordsJson = file_get_contents('words.json');
        $words = json_decode($wordsJson, true);
        ?>
        <table border="1", cellpadding="5">
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
            ?>
        </table>
    </div>
</div>
</body>
</html>