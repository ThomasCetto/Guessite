<?php

session_set_cookie_params(30 * 24 * 60 * 60);
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
include "../scripts/db_connection.php";
include "../scripts/userFunctions.php";
include "../scripts/clubFunctions.php";

// to refresh the css everytime (Altervista doesn't do it otherwise)
$timestamp = time();

?>
    <!DOCTYPE html>
    <html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Utenti</title>
        <!-- Bootstrap CSS -->
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet"
              integrity="sha384-KK94CHFLLe+nY2dmCWGMq91rCGa5gtU4mk92HdvYe+M/SXH301p5ILy+dN9+nJOZ"
              crossorigin="anonymous">
        <link rel="stylesheet" href="/css/style.css?v=<?php echo $timestamp; ?>">
        <link rel="stylesheet" href="/css/users.css?v=<?php echo $timestamp; ?>"> <!-- css is the same as users.php -->
    </head>



    <body>
    <?php
    include "../components/navbar.php";
    ?>

    <div id="pageContent">
        <div class="col-md-6" id="left-container">
            <h1>Classifica</h1>
            <?php printClubsLeaderboard($db_conn, 5); ?>
        </div>

        <div class="vertical-line"></div>

        <?php
        $hasSearched = isset($_POST["clubName"]);
        $isLogged = isset($_SESSION["username"]);
        $userClub = getClubName($db_conn, $_SESSION["username"]);
        $isInClub = $userClub == null;
        ?>

        <div class="col-md-6" id="right-container">

            <h1><?php echo $hasSearched ? "Risultato ricerca" : ($isLogged ? ($isInClub ? "Il tuo club" : "Non fai parte di nessun club :(") : "Accedi per vedere la posizione del tuo club");?></h1>

            <table class="table table-striped tab mx-auto" id="gridRight">
                <thead>
                <tr>
                    <th>#</th>
                    <th>Nome</th>
                    <th>Livello</th>
                    <th>Punteggio</th>
                    <th>Leader</th>
                    <th>Numero membri</th>
                </tr>
                </thead>
                <tbody>
                <tr>
                    <?php
                    $nameToSearchFor = $hasSearched ? htmlspecialchars($_POST["clubName"]) :
                        ($isLogged && $isInClub ? $userClub : "");

                    $row = getClubFromLeaderboard($db_conn, $nameToSearchFor)
                    ?>
                    <td><?php echo $row["pos"];?></td>
                    <td><?php echo $row["name"];?></td>
                    <td><?php echo $row["level"];?></td>
                    <td><?php echo $row["totalScore"];?></td>
                    <td><?php echo $row["owner"];?></td>
                    <td><?php echo $row["people"] . "/" . $row["level"]*5;?></td>
                </tr>
                </tbody>
            </table>

            <div id="search-container">
                <form action="#" method="POST">
                    <label>
                        Cerca club&nbsp&nbsp&nbsp
                        <input type="text" placeholder="Nome club..." name="clubName">
                    </label>
                    <button type="submit" id="searchButton" class="btn btn-primary border border-primary rounded-3 px-2 py-1">Cerca</button>
                </form>
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
    </body>
    </html>


<?php

