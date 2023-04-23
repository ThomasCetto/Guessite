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
        <title>Profilo</title>
        <!-- Bootstrap CSS -->
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet"
              integrity="sha384-KK94CHFLLe+nY2dmCWGMq91rCGa5gtU4mk92HdvYe+M/SXH301p5ILy+dN9+nJOZ"
              crossorigin="anonymous">
        <link rel="stylesheet" href="/css/style.css?v=<?php echo $timestamp; ?>">
        <link rel="stylesheet" href="/css/administrator.css?v=<?php echo $timestamp; ?>">
    </head>



    <body>
    <?php
    include "../components/navbar.php";
    ?>

    <?php

    if(!isset($_SESSION["username"]) || !$_SESSION["username"] == "admin"){
        header("Refresh:0; url=../index.php");
        return;
    }
    ?>

    <div id="pageContent">
        <?php
        if(isset($_POST["username"])){
            deleteUser($db_conn, $_POST["username"]);
        }
        printLeaderboard($db_conn, 1000000000, true);

        ?>
    </div>



    <?php
    include "../components/footer.php";
    ?>



    <script>

        function toggleDelete(button){
            if (button.value === "Elimina") {
                button.value = "Confermi?";
                button.style.backgroundColor = "orange";

            } else {
                button.type = "submit";
            }
        }

    </script>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js"
            integrity="sha384-ENjdO4Dr2bkBIFxQpeoTz1HIcje39Wm4jDKdf19U8gI4ddQ3GYNS7NTKfAdVQSZe"
            crossorigin="anonymous"></script>
    </body>
    </html>


<?php

