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
    <link rel="stylesheet" href="/style.css?v=<?php echo $timestamp; ?>">
    <link rel="stylesheet" href="/css/draw.css?v=<?php echo $timestamp; ?>">

    <script src="https://cdn.jsdelivr.net/npm/onnxruntime-web/dist/ort.min.js"></script>

</head>



<body>
<?php
include "../components/navbar.php";
?>

<div id="pageContent">
    <div class="grid-container">
        <h4 id="title">Disegna qui!</h4>
        <h6>Tasto sinistro per il colore, destro per la gomma</h6>

        <!-- Slider -->
        <div id="brushContainer">
            <label id="brushLabel" for="brush-size-slider">Dimensione pennello: &nbsp&nbsp&nbsp</label>
            <input type="range" min="1" max="5" value="3" step="2"
                   class="slider" id="brush-size-slider" oninput="changeBrushSize()">
            <span style="margin-left: 10px;" id="brush-size-label">3</span>
        </div>

        <table>
            <?php
            for ($row = 0; $row < 28; $row++) {
            ?>
            <tr>
                <?php
                for ($col = 0; $col < 28; $col++) { // echo $row . " " . $col
                    ?>
                    <td class="cell" id="cell-<?php echo $row . "-" . $col?>" style="background-color: white"></td>

                    <?php
                }
                }
                ?>

            </tr>
        </table>
        <button id="resetButton" class="btn btn-primary" onclick=clearCells()>Pulisci</button>

    </div>

    <div id="results">
        <p>Predizione del modello: </p>
        <div class="predictions">
            <div class="prediction-col" id="prediction-0">
                <div class="prediction-bar-container">
                    <div class="prediction-bar"></div>
                </div>
                <div class="prediction-number">0</div>
            </div>

            <div class="prediction-col" id="prediction-1">
                <div class="prediction-bar-container">
                    <div class="prediction-bar"></div>
                </div>
                <div class="prediction-number">1</div>
            </div>

            <div class="prediction-col" id="prediction-2">
                <div class="prediction-bar-container">
                    <div class="prediction-bar"></div>
                </div>
                <div class="prediction-number">2</div>
            </div>

            <div class="prediction-col" id="prediction-3">
                <div class="prediction-bar-container">
                    <div class="prediction-bar"></div>
                </div>
                <div class="prediction-number">3</div>
            </div>

            <div class="prediction-col" id="prediction-4">
                <div class="prediction-bar-container">
                    <div class="prediction-bar"></div>
                </div>
                <div class="prediction-number">4</div>
            </div>

            <div class="prediction-col" id="prediction-5">
                <div class="prediction-bar-container">
                    <div class="prediction-bar"></div>
                </div>
                <div class="prediction-number">5</div>
            </div>

            <div class="prediction-col" id="prediction-6">
                <div class="prediction-bar-container">
                    <div class="prediction-bar"></div>
                </div>
                <div class="prediction-number">6</div>
            </div>

            <div class="prediction-col" id="prediction-7">
                <div class="prediction-bar-container">
                    <div class="prediction-bar"></div>
                </div>
                <div class="prediction-number">7</div>
            </div>

            <div class="prediction-col" id="prediction-8">
                <div class="prediction-bar-container">
                    <div class="prediction-bar"></div>
                </div>
                <div class="prediction-number">8</div>
            </div>

            <div class="prediction-col" id="prediction-9">
                <div class="prediction-bar-container">
                    <div class="prediction-bar"></div>
                </div>
                <div class="prediction-number">9</div>
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

<script src="../js/draw.js?v=<?php echo $timestamp;?>"></script>
</body>


</html>
