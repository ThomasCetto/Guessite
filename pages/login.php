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
        <title>Login</title>
        <!-- Bootstrap CSS -->
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet"
              integrity="sha384-KK94CHFLLe+nY2dmCWGMq91rCGa5gtU4mk92HdvYe+M/SXH301p5ILy+dN9+nJOZ"
              crossorigin="anonymous">
        <link rel="stylesheet" href="/style.css?v=<?php echo $timestamp; ?>">
    </head>

    <?php
    include "../components/navbar.php";
    ?>

    <body>
    <?php
    $usError = "";
    $pwError = "";
    $username = "";
    $pw = "";


    if (isset($_SESSION["username"])) {
        echo "Hai già effettuato l'accesso!";
    } else if (isset($_POST["username"])) {
        $username = htmlspecialchars(trim($_POST["username"]));
        $pw = htmlspecialchars(trim($_POST["password"]));

        $type = (strpos($username, "@") !== false) ? "email" : "username";

        if (strcmp($type, "email") === 0) {
            if (!emailExists($db_conn, $username)) {
                $usError = "Questa email non è ancora stata registrata";
                renderForm($usError, $pwError, $username, $pw);
            } else {
                if (checkLogin($db_conn, $type, $username, $pw)) {
                    $_SESSION["username"] = getUsernameFromEmail($db_conn, $username);
                    echo "Hai eseguito l'accesso correttamente!";
                    header("Refresh:0; url=./profile.php");
                } else {
                    $pwError = "Le credenziali non sono corrette...";
                    renderForm($usError, $pwError, $username, $pw);
                }
            }
        } else {
            if (!userExists($db_conn, $username)) {
                $usError = "Questo utente non esiste";
                renderForm($usError, $pwError, $username, $pw);
            } else {
                if (checkLogin($db_conn, $type, $username, $pw)) {
                    $_SESSION["username"] = $username;
                    echo "Hai eseguito l'accesso correttamente!";
                    header("Refresh:0; url=./profile.php");
                } else {
                    $pwError = "Le credenziali non sono corrette...";
                    renderForm($usError, $pwError, $username, $pw);
                }
            }
        }
    } else {
        renderForm($usError, $pwError, $username, $pw);
    }


    ?>


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
function renderForm($usError, $pwError, $username, $pw): void
{
    ?>
    <div class="container h-100" style="margin-top: 30px; margin-bottom: 30px;">
        <div class="row d-flex justify-content-center align-items-center h-100">
            <div class="col-lg-12 col-xl-11">
                <div class="card text-black" style="border-radius: 25px;">
                    <div class="card-body p-md-5">
                        <div class="row justify-content-center">
                            <div class="col-md-10 col-lg-6 col-xl-5 order-2 order-lg-1">

                                <p class="text-center h1 fw-bold mb-5 mx-1 mx-md-4 mt-4">Accedi</p>

                                <form class="mx-1 mx-md-4" method="POST" action="#">

                                    <div class="d-flex flex-row align-items-center mb-4">
                                        <i class="fas fa-user fa-lg me-3 fa-fw"></i>
                                        <div class="form-outline flex-fill mb-0">
                                            <input type="text" value="<?php echo $username; ?>" id="form3Example1c"
                                                   class="form-control" name="username" required/>
                                            <label class="form-label" for="form3Example1c"
                                                   style="color: red;"><?php echo $usError; ?></label>
                                            <label class="form-label" for="form3Example1c">Username o email</label>

                                        </div>
                                    </div>

                                    <div class="d-flex flex-row align-items-center mb-4">
                                        <i class="fas fa-lock fa-lg me-3 fa-fw"></i>
                                        <div class="form-outline flex-fill mb-0">
                                            <input type="password" id="form3Example4c" class="form-control"
                                                   name="password" required/>
                                            <label class="form-label" for="form3Example4cd"
                                                   style="color: red;"><?php echo $pwError; ?></label>
                                            <label class="form-label" for="form3Example4c">Password</label>

                                        </div>
                                    </div>

                                    <div class="d-flex justify-content-center mx-4 mb-3 mb-lg-4">
                                        <input type="submit" class="btn btn-primary btn-lg" value="Accedi"></input>
                                    </div>

                                </form>

                            </div>
                            <div class="col-md-10 col-lg-6 col-xl-7 d-flex align-items-center order-1 order-lg-2">

                                <img
                                    src="../img/login.png"
                                    class="img-fluid" alt="Sample image"
                                    style="width: 550px; height: 400px;"
                                >

                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <?php
}