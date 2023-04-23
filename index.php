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
    <div class="row">
        <div id="left-container" class="col">
            <a href="/pages/draw.php">
                <div class="square">
                    <h3>Disegna</h3>

                    <div class="row">
                        <div class="col-md-6">
                            <div class="logo-holder">
                                <div id="barsContainer">
                                    <div class="bg"></div>
                                    <div class="bar"></div>
                                    <div class="bar fill1"></div>
                                    <div class="bar fill2"></div>
                                    <div class="bar fill3"></div>
                                    <div class="bar fill4"></div>
                                    <div class="bar fill1"></div>
                                    <div class="bar fill5"></div>
                                    <div class="bar fill6"></div>
                                    <div class="bar"></div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6" id="gifHolder">
                            <img id="gif" src="img/drawVideo.gif" alt="drawing gif">
                        </div>
                    </div>
                </div>
            </a>
        </div>

        <div id="right-container" class="col">
            <a href="/pages/guess.php">
                <div class="square">
                    <h3>
                        Sfida
                    </h3>

                </div>
            </a>
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
