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
    <link rel="stylesheet" href="/style.css?v=<?php echo $timestamp; ?>">
    <link rel="stylesheet" href="/css/profile.css?v=<?php echo $timestamp; ?>">
</head>



<body>
<?php
include "../components/navbar.php";
?>

<?php
if (isset($_POST["logout"])) {
    $_SESSION["username"] = null;
    header("Refresh:0; url=../index.php");
}else if(isset($_POST["delete"])){
    deleteUser($db_conn, $_SESSION["username"]);
    $_SESSION["username"] = null;
    header("Refresh:0; url=../index.php");
}


?>




<div id="pageContent">

    <div class="container border border-primary rounded p-3" id="information">
        <p id="title">Dati utente</p>
        <p class="txt"><strong>Username:</strong><?php echo $_SESSION["username"];?> </p>
        <p class="txt"><strong>Email:</strong> <?php echo getEmailFromUsername($db_conn, $_SESSION["username"])?> </p>
    </div>

    <form action="#" method="POST">
        <input name="logout" style="display:none;">
        <button type="submit" class="btn btn-primary border border-primary rounded-3 px-4 py-2">Esci dall'account</button>
    </form>

    <form action="#" method="POST">
        <input name="delete" style="display:none;">
        <button id="deleteButton" type="button" class="btn btn-danger border border-danger rounded-3 px-4 py-2" onclick="toggleDelete()">Elimina account</button>
    </form>





</div>




<?php
include "../components/footer.php";
?>



<script>
    function toggleDelete() {
        var button = document.getElementById("deleteButton");
        var input = document.getElementsByName("delete")[0];

        if (button.innerText === "Elimina account") {
            button.innerText = "Conferma eliminazione";
            button.style.backgroundColor = "orange";
        } else {
            input.value = "true";
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

