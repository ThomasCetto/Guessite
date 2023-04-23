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
        <title>Area amministratore</title>
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

    //if not logged in or not admin, redirect to homepage
    if(!isset($_SESSION["username"]) || $_SESSION["username"] != "admin"){
        header("Refresh:0; url=../index.php");
        return;
    }
    ?>

    <div id="pageContent">
        <?php
        if(isset($_POST["usernameToDelete"]) && $_POST["usernameToDelete"] != ""){
            deleteUser($db_conn, $_POST["usernameToDelete"]);
        }else if(isset($_POST["usernameToModify"])){
            $oldUsername = $_POST["usernameToModify"];
            $newUsername = htmlspecialchars(trim($_POST["newUsername"]));
            $newScore = htmlspecialchars(trim($_POST["newScore"]));
            $newTries = htmlspecialchars(trim($_POST["newTries"]));
            $newGuessed = htmlspecialchars(trim($_POST["newGuessed"]));

            modifyUser($db_conn, $oldUsername, $newUsername, $newScore, $newTries, $newGuessed);
        }

        printLeaderboardForAdmin($db_conn, 1000000000);
        ?>
    </div>



    <?php
    include "../components/footer.php";
    ?>



    <script src="/js/administrator.js?v=<?php echo $timestamp;?>"></script>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js"
            integrity="sha384-ENjdO4Dr2bkBIFxQpeoTz1HIcje39Wm4jDKdf19U8gI4ddQ3GYNS7NTKfAdVQSZe"
            crossorigin="anonymous"></script>
    </body>
    </html>


<?php

