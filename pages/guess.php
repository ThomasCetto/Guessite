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
    ?>
    <h3>Devi accedere per poter provare le sfide! <br><a href="login.php">Accedi qui!</a></h3>

    <?php
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

    // TODO: somway make an animation that tells how many points you got
}

include "../components/navbar.php";
?>

<div id="pageContent">
    <div class="row">

        <!-- left -->
        <div class="col-md-6" id="left-container">
            <div class="container border border-primary border-2 rounded p-3" id="imageContainer">
                <img id="imageToGuess" src="../dataset/images/<?php echo $indexChosen;?>.png" alt="image to guess">


            </div>
        </div>

        <!-- right -->
        <div id="right-container" class="col-md-6">
            <p>Scegli la difficolta:</p>
            <div class="btn-group" role="group" aria-label="Button group">
                <input onclick=setDifficulty(0) type="radio" class="btn-check" name="options" id="option1" autocomplete="off" checked>
                <label class="btn btn-primary" for="option1">Facile</label>
                <input onclick=setDifficulty(1) type="radio" class="btn-check" name="options" id="option2" autocomplete="off">
                <label class="btn btn-primary" for="option2">Random</label>
                <input onclick=setDifficulty(2) type="radio" class="btn-check" name="options" id="option3" autocomplete="off">
                <label class="btn btn-primary" for="option3">Difficile</label>
            </div>

            <div id="numbers">
                <form action="#" method="POST">
                    <input type="text" style="display: none" name="guessValue" id="guessInput">
                    <input type="text" style="display: none" name="modelValue" id="modelInput">
                    <input type="text" style="display: none" name="imageIndex" id="imageIndex" value="<?php echo $indexChosen;?>">
                    <input type="text" style="display: none" name="imageValue" id="imageValue" value="<?php echo $_SESSION["labels"][$indexChosen];?>">
                    <input type="text" style="display: none" name="difficulty" id="difficulty">


                    <input type="submit" value="0" onclick=guess(0)>
                    <input type="submit" value="1" onclick=guess(1)>
                    <input type="submit" value="2" onclick=guess(2)>
                    <input type="submit" value="3" onclick=guess(3)>
                    <input type="submit" value="4" onclick=guess(4)>
                    <input type="submit" value="5" onclick=guess(5)>
                    <input type="submit" value="6" onclick=guess(6)>
                    <input type="submit" value="7" onclick=guess(7)>
                    <input type="submit" value="8" onclick=guess(8)>
                    <input type="submit" value="9" onclick=guess(9)>
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
