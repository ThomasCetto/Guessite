<?php

session_set_cookie_params(30 * 24 * 60 * 60);
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

//include "../scripts/db_connection.php";
//global $db_conn;


$db_host = "127.0.0.1";
$db_user = "cetto5inc2022";
$db_pass = "";
$db_name = "my_cetto5inc2022";

try {
    $db_conn = @mysqli_connect($db_host, $db_user, $db_pass, $db_name);

    if ($db_conn == null)
        throw new exception (mysqli_connect_error() . ' Error n.' . mysqli_connect_errno());
} catch (Exception $e) {
    $error_message = $e->getMessage();
}


// to refresh the css everytime (Altervista doesn't do it otherwise)
$timestamp = time();


?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Bootstrap Header and Footer</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-KK94CHFLLe+nY2dmCWGMq91rCGa5gtU4mk92HdvYe+M/SXH301p5ILy+dN9+nJOZ" crossorigin="anonymous">
    <link rel="stylesheet" href="/style.css?v=<?php echo $timestamp;?>">
</head>

<?php
include_once "../components/navbar.php";
?>

<body>
<?php
$usError = "";
$emailError = "";
$pwError = "";
$termsError = "";

if(isset($_SESSION["username"])){
    echo "Sei già registrato!";
}else{
    if(isset($_POST["username"])){
        if(userExists($db_conn)){
            $usError = "Questo username è già stato utilizzato";
            renderForm($usError, $emailError, $pwError, $termsError);
        }else if(emailExists($db_conn)){
            $emailError = "Questa mail è già stata utilizzata";
            renderForm($usError, $emailError, $pwError, $termsError);
        }else if(strlen($_POST["password1"]) < 8){
                $pwError = "La password deve avere almeno 8 caratteri!";
                renderForm($usError, $emailError, $pwError, $termsError);
            }
            else if($_POST["password1"] !== $_POST["password2"]){
                $pwError = "Le due password sono diverse!";
                renderForm($usError, $emailError, $pwError, $termsError);
            }else if(!isset($_POST["agree"])){
                $termsError = "Devi accettare i termini di servizio";

                renderForm($usError, $emailError, $pwError, $termsError);
            }

            else{
                insertUser($db_conn);
                echo "Ti sei registrato con successo!";
        }
    }else{
        renderForm($usError, $emailError, $pwError, $termsError);
    }
}


?>


    <?php
    include_once "../components/footer.php";
    ?>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ENjdO4Dr2bkBIFxQpeoTz1HIcje39Wm4jDKdf19U8gI4ddQ3GYNS7NTKfAdVQSZe" crossorigin="anonymous"></script>
</body>
</html>


<?php

function insertUser($db_conn){
    $username = trim($_POST["username"]);
    $password = MD5(trim($_POST["password1"]));
    $email = trim($_POST["email"]);

    $query1 = "INSERT INTO accountStats(`username`) VALUES ('$username');";
    $query2 = "INSERT INTO account (`username`, `pw`, `email`, `stats`) VALUES ('$username', '$password', '$email', '$username');";

    try{
        mysqli_query($db_conn, $query1);
        mysqli_query($db_conn, $query2);
    }catch(Exception $e){
        echo "Errore in insertUser -> " . $e->getMessage();
    }
}

function userExists($db_conn){
    $query = "SELECT COUNT(*) as count 
              FROM account 
              WHERE username = '" . $_POST['username'] . "'";
    try{
        $data = mysqli_query($db_conn, $query);
        $row = mysqli_fetch_assoc($data);
        return $row["count"] == 1;

    }catch(Exception $e){
        echo "Errore in userExists " . $e->getMessage();
    }
    return True;
}

function emailExists($db_conn){
    $query = "SELECT COUNT(*) as count 
              FROM account 
              WHERE username = '" . $_POST['email'] . "'";
    try{
        $data = mysqli_query($db_conn, $query);
        $row = mysqli_fetch_assoc($data);
        return $row["count"] == 1;

    }catch(Exception $e){
        echo "Errore in userExists " . $e->getMessage();
    }
    return True;
}

function renderForm($usError, $emailError, $pwError, $termsError){
    ?>
<div class="container h-100">
    <div class="row d-flex justify-content-center align-items-center h-100">
        <div class="col-lg-12 col-xl-11">
            <div class="card text-black" style="border-radius: 25px;">
                <div class="card-body p-md-5">
                    <div class="row justify-content-center">
                        <div class="col-md-10 col-lg-6 col-xl-5 order-2 order-lg-1">

                            <p class="text-center h1 fw-bold mb-5 mx-1 mx-md-4 mt-4">Sign up</p>

                            <form class="mx-1 mx-md-4" method="POST" action="#">

                                <div class="d-flex flex-row align-items-center mb-4">
                                    <i class="fas fa-user fa-lg me-3 fa-fw"></i>
                                    <div class="form-outline flex-fill mb-0">
                                        <input type="text" id="form3Example1c" class="form-control" name="username"/>
                                        <label class="form-label" for="form3Example1c" style="color: red;"><?php echo $usError;?></label>
                                        <label class="form-label" for="form3Example1c">Username</label>

                                    </div>
                                </div>

                                <div class="d-flex flex-row align-items-center mb-4">
                                    <i class="fas fa-envelope fa-lg me-3 fa-fw"></i>
                                    <div class="form-outline flex-fill mb-0">
                                        <input type="email" id="form3Example3c" class="form-control" name="email"/>
                                        <label class="form-label" for="form3Example3c" style="color: red;"><?php echo $emailError;?></label>
                                        <label class="form-label" for="form3Example3c">Your Email</label>
                                    </div>
                                </div>

                                <div class="d-flex flex-row align-items-center mb-4">
                                    <i class="fas fa-lock fa-lg me-3 fa-fw"></i>
                                    <div class="form-outline flex-fill mb-0">
                                        <input type="password" id="form3Example4c" class="form-control" name="password1"/>
                                        <label class="form-label" for="form3Example4c">Password</label>
                                    </div>
                                </div>

                                <div class="d-flex flex-row align-items-center mb-4">
                                    <i class="fas fa-key fa-lg me-3 fa-fw"></i>
                                    <div class="form-outline flex-fill mb-0">
                                        <input type="password" id="form3Example4cd" class="form-control" name="password2"/>
                                        <label class="form-label" for="form3Example4cd">Repeat your password</label>
                                        <label class="form-label" for="form3Example4cd" style="color: red;"><?php echo $pwError;?></label>
                                    </div>
                                </div>

                                <div class="form-check d-flex justify-content-center mb-5">
                                    <input class="form-check-input me-2" type="checkbox" value="yes" id="form2Example3c" name="agree"/>
                                    <label class="form-check-label" for="form2Example3">
                                        <label class="form-label" for="form3Example4cd">Agree to our terms and services</label>
                                        <label class="form-label" for="form3Example4cd" style="color: red;"><?php echo $termsError;?></label>

                                    </label>
                                </div>

                                <div class="d-flex justify-content-center mx-4 mb-3 mb-lg-4">
                                    <input type="submit" class="btn btn-primary btn-lg" value="Register"></input>
                                </div>

                            </form>

                        </div>
                        <div class="col-md-10 col-lg-6 col-xl-7 d-flex align-items-center order-1 order-lg-2">

                            <img src="https://mdbcdn.b-cdn.net/img/Photos/new-templates/bootstrap-registration/draw1.webp"
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