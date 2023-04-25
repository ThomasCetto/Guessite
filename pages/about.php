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
    <title>About</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/5.0.0-beta2/css/bootstrap.min.css">
    <link rel="stylesheet" href="/css/style.css?v=<?php echo $timestamp;?>">
    <style>
        .container {
            width: 80%;
            margin: 0 auto;
            padding: 20px;
            background-color: #fff;
            border-radius: 5px;
            box-shadow: 0 0 5px rgba(0, 0, 0, 0.1);
        }

        h1 {
            text-align: center;
            color: black;
        }

        h3 {
            font-size: 24px;
            text-align: center;
            color: black;
        }

        p {
            text-align: center;
        }

        a {
            display: inline-block;
            margin-top: 20px;
            padding: 10px 20px;
            background-color: #007bff;
            color: #fff;
            text-decoration: none;
            border-radius: 5px;
            transition: background-color 0.3s ease;
        }

        a:hover {
            background-color: #0056b3;
        }
    </style>
</head>
<body>
<div class="container mt-5">
    <h1>About Page</h1>
    <div class="row mt-4">
        <div class="col-md-6 offset-md-3">
            <h3>Sito creato da Thomas Cetto</h3>
            <p>Profilo GitHub: <a href="https://github.com/ThomasCetto">qui</a></p>
        </div>
    </div>
    <div class="row mt-3">
        <div class="col-md-6 offset-md-3 text-center">
            <a href="../index.php">Torna alla home</a>
        </div>
    </div>
</div>
</body>
</html>
