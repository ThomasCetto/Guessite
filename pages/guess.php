<?php

session_set_cookie_params(30 * 24 * 60 * 60);
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
include "../scripts/db_connection.php";

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
include "../components/navbar.php";
?>

<div id="pageContent">
    <div id="left-container">

    </div>

    <div id="right-container">
        <p>Scegli la difficolta:</p>
        <div class="btn-group" role="group" aria-label="Button group">
            <input onclick=setDifficulty(0) type="radio" class="btn-check" name="options" id="option1" autocomplete="off" checked>
            <label class="btn btn-primary" for="option1">Facile</label>
            <input onclick=setDifficulty(1) type="radio" class="btn-check" name="options" id="option2" autocomplete="off">
            <label class="btn btn-primary" for="option2">Random</label>
            <input onclick=setDifficulty(2) type="radio" class="btn-check" name="options" id="option2" autocomplete="off">
            <label class="btn btn-primary" for="option2">Difficile</label>
        </div>

        <div id="numbers">



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
