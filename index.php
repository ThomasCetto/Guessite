<?php
// to refresh the css everytime (Altervista doesn't refresh it otherwise)
$timestamp = time();
session_set_cookie_params(30 * 24 * 60 * 60);
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Home</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet"
          integrity="sha384-KK94CHFLLe+nY2dmCWGMq91rCGa5gtU4mk92HdvYe+M/SXH301p5ILy+dN9+nJOZ" crossorigin="anonymous">
    <link rel="stylesheet" href="css/style.css?v=<?php echo $timestamp;?>">
    <link rel="stylesheet" href="css/home.css?v=<?php echo $timestamp;?>">

</head>

<body>
<?php
include "components/navbar.php";
?>


<div id="pageContent">
    <div class="row" id="titleRow">
        <h1 class="col text-center" id="title">Modalità</h1>
    </div>
    <div class="row">
        <div class="col-md-6" id="left-container">
            <h2>Disegno</h2>
            <div class="container border border-primary border-2 rounded p-3">
                <p>Sfida l'Intelligenza Artificiale!</p>
                <img src="img/numberGrid.png" alt="number grid">
                <img src="img/numberGuess.png" alt="number guess">
            </div>

            <a href="./pages/draw.php">
                <button class="redir btn btn-primary border border-primary rounded-2 px-4 py-2">Vai!</button>
            </a>
        </div>

        <div class="col-md-6" id="right-container">
            <h2>Sfida</h2>
            <div class="container border border-primary rounded border-2 p-3">


                <p>Coming soon...</p>
            </div>

        </div>
    </div>
</div>






<?php
include "components/footer.php";
?>



<!-- Bootstrap JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-ENjdO4Dr2bkBIFxQpeoTz1HIcje39Wm4jDKdf19U8gI4ddQ3GYNS7NTKfAdVQSZe"
        crossorigin="anonymous"></script>
</body>
</html>
