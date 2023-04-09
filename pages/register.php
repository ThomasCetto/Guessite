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
        <title>Registrazione</title>
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
    $emailError = "";
    $pwError = "";
    $termsError = "";
    $username = "";
    $email = "";
    $pw1 = "";
    $pw2 = "";
    if (isset($_POST["username"])) {
        $username = htmlspecialchars(trim($_POST["username"]));
        $email = htmlspecialchars(trim($_POST["email"]));
        $pw1 = htmlspecialchars(trim($_POST["password1"]));
        $pw2 = htmlspecialchars(trim($_POST["password2"]));
    }

    if (isset($_SESSION["username"])) {
        echo "Sei già registrato!";
    } else {
        if (isset($_POST["username"])) {
            if (userExists($db_conn, $username)) {
                $usError = "Questo username è già stato utilizzato";
                renderForm($usError, $emailError, $pwError, $termsError, $username, $email);
            } else if (emailExists($db_conn, $email)) {
                $emailError = "Questa mail è già stata utilizzata";
                renderForm($usError, $emailError, $pwError, $termsError, $username, $email);
            } else if (strlen($pw1) < 1) {  // TODO: 1 -> 8
                $pwError = "La password deve avere almeno 8 caratteri!";
                renderForm($usError, $emailError, $pwError, $termsError, $username, $email);
            } else if ($pw1 !== $pw2) {
                $pwError = "Le due password sono diverse!";
                renderForm($usError, $emailError, $pwError, $termsError, $username, $email);
            } else if (!isset($_POST["agree"])) {
                $termsError = "Devi accettare i termini di servizio";
                renderForm($usError, $emailError, $pwError, $termsError, $username, $email);
            } else {
                insertUser($db_conn, $username, $email, $pw1);
                $_SESSION["username"] = $username;
                echo "Ti sei registrato con successo!";
            }
        } else {
            renderForm($usError, $emailError, $pwError, $termsError, $username, $email);
        }
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
function renderForm($usError, $emailError, $pwError, $termsError, $username, $email)
{
    ?>
    <div class="container h-100" style="margin-top: 30px; margin-bottom: 80px;">
        <div class="row d-flex justify-content-center align-items-center h-100">
            <div class="col-lg-12 col-xl-11">
                <div class="card text-black" style="border-radius: 25px;">
                    <div class="card-body p-md-5">
                        <div class="row justify-content-center">
                            <div class="col-md-10 col-lg-6 col-xl-5 order-2 order-lg-1">

                                <p class="text-center h1 fw-bold mb-5 mx-1 mx-md-4 mt-4">Registrati</p>

                                <form class="mx-1 mx-md-4" method="POST" action="#">

                                    <div class="d-flex flex-row align-items-center mb-4">
                                        <i class="fas fa-user fa-lg me-3 fa-fw"></i>
                                        <div class="form-outline flex-fill mb-0">
                                            <input type="text" value="<?php echo $username; ?>" id="form3Example1c"
                                                   class="form-control" name="username" required/>
                                            <label class="form-label" for="form3Example1c"
                                                   style="color: red;"><?php echo $usError; ?></label>
                                            <label class="form-label" for="form3Example1c">Username</label>

                                        </div>
                                    </div>

                                    <div class="d-flex flex-row align-items-center mb-4">
                                        <i class="fas fa-envelope fa-lg me-3 fa-fw"></i>
                                        <div class="form-outline flex-fill mb-0">
                                            <input type="email" value="<?php echo $email; ?>" id="form3Example3c"
                                                   class="form-control" name="email" required/>
                                            <label class="form-label" for="form3Example3c"
                                                   style="color: red;"><?php echo $emailError; ?></label>
                                            <label class="form-label" for="form3Example3c">Your Email</label>
                                        </div>
                                    </div>

                                    <div class="d-flex flex-row align-items-center mb-4">
                                        <i class="fas fa-lock fa-lg me-3 fa-fw"></i>
                                        <div class="form-outline flex-fill mb-0">
                                            <input type="password" id="form3Example4c" class="form-control"
                                                   name="password1" required/>
                                            <label class="form-label" for="form3Example4c">Password</label>
                                        </div>
                                    </div>

                                    <div class="d-flex flex-row align-items-center mb-4">
                                        <i class="fas fa-key fa-lg me-3 fa-fw"></i>
                                        <div class="form-outline flex-fill mb-0">
                                            <input type="password" id="form3Example4cd" class="form-control"
                                                   name="password2" required/>
                                            <label class="form-label" for="form3Example4cd"
                                                   style="color: red;"><?php echo $pwError; ?></label>
                                            <label class="form-label" for="form3Example4cd">Repeat your password</label>
                                        </div>
                                    </div>

                                    <div class="form-check d-flex justify-content-center mb-5">
                                        <input class="form-check-input me-2" type="checkbox" value="yes"
                                               id="form2Example3c" name="agree"/>
                                        <label class="form-check-label" for="form2Example3">
                                            <label class="form-label" for="form3Example4cd"
                                                   style="color: red;"><?php echo $termsError; ?></label>
                                            <label class="form-label" for="form3Example4cd">Agree to our terms and
                                                services</label>
                                        </label>
                                    </div>

                                    <div class="d-flex justify-content-center mx-4 mb-3 mb-lg-4">
                                        <input type="submit" class="btn btn-primary btn-lg" value="Registrati"></input>
                                    </div>

                                </form>

                            </div>
                            <div class="col-md-10 col-lg-6 col-xl-7 d-flex align-items-center order-1 order-lg-2">

                                <img
                                    src="https://mdbcdn.b-cdn.net/img/Photos/new-templates/bootstrap-registration/draw1.webp"
                                    class="img-fluid" alt="Sample image">

                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <?php
}