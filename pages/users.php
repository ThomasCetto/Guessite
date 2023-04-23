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
        <title>Utenti</title>
        <!-- Bootstrap CSS -->
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet"
              integrity="sha384-KK94CHFLLe+nY2dmCWGMq91rCGa5gtU4mk92HdvYe+M/SXH301p5ILy+dN9+nJOZ"
              crossorigin="anonymous">
        <link rel="stylesheet" href="/css/style.css?v=<?php echo $timestamp; ?>">
        <link rel="stylesheet" href="/css/users.css?v=<?php echo $timestamp; ?>">
    </head>



    <body>
    <?php
    include "../components/navbar.php";
    ?>

    <div id="pageContent">
        <div class="col-md-6" id="left-container">
            <h1>Classifica</h1>
            <?php printLeaderboard($db_conn, 10); ?>
        </div>

        <div class="vertical-line"></div>

        <?php
        $hasSearched = isset($_POST["username"]);
        $isLogged = isset($_SESSION["username"]);
        ?>

        <div class="col-md-6" id="right-container">

            <h1><?php echo $hasSearched ? "Risultato" : ($isLogged ? "Tu" : "Accedi per vedere la tua posizione") ?></h1>

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
                        $nameToSearchFor = $hasSearched ? htmlspecialchars($_POST["username"]) :
                            ($isLogged ? $_SESSION["username"] : "");

                        $row = getUserFromLeaderboard($db_conn, $nameToSearchFor)
                        ?>
                        <td><?php echo $row["pos"];?></td>
                        <td><?php echo $row["username"];?></td>
                        <td><?php echo $row["score"];?></td>
                        <td><?php echo $row["tries"];?></td>
                        <td><?php echo $row["guessed"];?></td>
                    </tr>
                </tbody>
            </table>

            <div id="search-container">
                <form action="#" method="POST">
                    <label>
                        Cerca utente&nbsp&nbsp&nbsp
                        <input type="text" placeholder="Username..." name="username">
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

