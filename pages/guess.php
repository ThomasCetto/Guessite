<?php

session_set_cookie_params(30 * 24 * 60 * 60);
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
include "../scripts/db_connection.php";
include "../scripts/userFunctions.php";

// to refresh the css everytime (Altervista doesn't do it otherwise)
$timestamp = time();

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Disegno</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet"
          integrity="sha384-KK94CHFLLe+nY2dmCWGMq91rCGa5gtU4mk92HdvYe+M/SXH301p5ILy+dN9+nJOZ"
          crossorigin="anonymous">
    <link rel="stylesheet" href="/css/style.css?v=<?php echo $timestamp; ?>">
    <link rel="stylesheet" href="/css/guess.css?v=<?php echo $timestamp; ?>">

    <script src="https://cdn.jsdelivr.net/npm/onnxruntime-web/dist/ort.min.js"></script>

</head>



<body>
<?php

if(!isset($_SESSION["username"])){
    header("Location: /pages/notLoggedIn.php");
    return;
}

// image of the current page
$indexChosen = rand(0, 10000);
$points = -5;


// TODO: change image selection and points when difficulty is higher



// loads the labels if didn't already
if(!isset($_SESSION["labels"])){
    $file_contents = file('../dataset/labels.txt');
    $numbers_array = [];
    foreach ($file_contents as $line) {
        $numbers_array[] = trim($line);
    }
    $_SESSION["labels"] = $numbers_array;
}

// the user chose a number before
if(isset($_POST["guessValue"])){
    //if the user guessed right
    if(htmlspecialchars($_POST["guessValue"]) === htmlspecialchars($_POST["imageValue"])){
        $points += 10;
    }
    // if the model guessed right
    if(htmlspecialchars($_POST["modelValue"]) === htmlspecialchars($_POST["imageValue"])){
        $points -= 3;
    }
    addPoints($db_conn, $points);

    // TODO: someway make an animation that tells how many points the user got
}

include "../components/navbar.php";
?>

<div id="pageContent">
    <div class="row" id="rowContainer">
        <!-- left -->
        <div class="col-md-6" id="left-container">
            <div class="container border border-primary border-2 rounded p-3" id="imageContainer">
                <img id="imageToGuess" src="../dataset/images/<?php echo $indexChosen;?>.png" alt="image to guess">
            </div>

        </div>

        <!-- right -->
        <div id="right-container" class="col-md-6">
            <p>Difficolta:</p>
            <div class="btn-group" role="group" aria-label="Button group">
                <input onclick=setDifficulty(0) type="radio" class="btn-check" name="options" id="option1" autocomplete="off" checked>
                <label class="btn btn-primary" for="option1">Facile</label>
                <input onclick=setDifficulty(1) type="radio" class="btn-check" name="options" id="option2" autocomplete="off">
                <label class="btn btn-primary" for="option2">Random</label>
                <input onclick=setDifficulty(2) type="radio" class="btn-check" name="options" id="option3" autocomplete="off">
                <label class="btn btn-primary" for="option3">Difficile</label>
            </div>

            <br><br>

            <table class="table table-striped tab mx-auto" id="gridRight">
                <thead>
                <tr>
                    <th>#</th>
                    <th>Username</th>
                    <th>Punteggio</th>
                    <th>Tentativi</th>
                    <th>Indovinati</th>
                </tr>
                </thead>
                <tbody>
                <tr>
                    <?php
                    $nameToSearchFor = $_SESSION["username"];
                    $row = getUserFromLeaderboard($db_conn, $nameToSearchFor);

                    $tellDifference = isset($_POST["guessValue"]);
                    $previousScore = $row["score"] - $points;
                    $currentScore = $row["score"];
                    $pointsToPrint = $points >= 0 ? "+" . $points : $points;

                    ?>
                    <td><?php echo $row["pos"];?></td>
                    <td><?php echo $row["username"];?></td>
                    <td><?php echo $tellDifference ? $previousScore . " (" . $pointsToPrint . ")" . " -> " . $currentScore : $currentScore;?></td>
                    <td><?php echo $row["tries"];?></td>
                    <td><?php echo $row["guessed"];?></td>
                </tr>
                </tbody>
            </table>

            <br><br>
            <p>Che numero vedi?</p>
            <div id="numbersContainer">
                <form action="#" method="POST">
                    <input type="text" style="display: none" name="guessValue" id="guessInput">
                    <input type="text" style="display: none" name="modelValue" id="modelInput">
                    <input type="text" style="display: none" name="imageIndex" id="imageIndex" value="<?php echo $indexChosen;?>">
                    <input type="text" style="display: none" name="imageValue" id="imageValue" value="<?php echo $_SESSION["labels"][$indexChosen];?>">
                    <input type="text" style="display: none" name="difficulty" id="difficulty">

                    <div class="container">
                        <div class="row">
                            <div class="col">
                                <button class="btn btn-primary w-100" onclick="guess(1)">1</button>
                            </div>
                            <div class="col">
                                <button class="btn btn-primary w-100" onclick="guess(2)">2</button>
                            </div>
                            <div class="col">
                                <button class="btn btn-primary w-100" onclick="guess(3)">3</button>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col">
                                <button class="btn btn-primary w-100" onclick="guess(4)">4</button>
                            </div>
                            <div class="col">
                                <button class="btn btn-primary w-100" onclick="guess(5)">5</button>
                            </div>
                            <div class="col">
                                <button class="btn btn-primary w-100" onclick="guess(6)">6</button>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col">
                                <button class="btn btn-primary w-100" onclick="guess(7)">7</button>
                            </div>
                            <div class="col">
                                <button class="btn btn-primary w-100" onclick="guess(8)">8</button>
                            </div>
                            <div class="col">
                                <button class="btn btn-primary w-100" onclick="guess(9)">9</button>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col">
                                <button class="btn btn-primary w-100" onclick="guess(0)">0</button>
                            </div>
                        </div>
                    </div>

                </form>
            </div>
        </div>
    </div>
</div>


<?php
include "../components/footer.php";
?>



<!-- Bootstrap JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-ENjdO4Dr2bkBIFxQpeoTz1HIcje39Wm4jDKdf19U8gI4ddQ3GYNS7NTKfAdVQSZe"
        crossorigin="anonymous"></script>

<script src="../js/guess.js?v=<?php echo $timestamp;?>"></script>
</body>


</html>
