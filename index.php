<?php
// to refresh the css everytime (altervista doesn't refresh it otherwise)
$timestamp = time()
?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Bootstrap Header and Footer</title>
        <!-- Bootstrap CSS -->
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-KK94CHFLLe+nY2dmCWGMq91rCGa5gtU4mk92HdvYe+M/SXH301p5ILy+dN9+nJOZ" crossorigin="anonymous">
        <link rel="stylesheet" href="style.css?v=<?php echo $timestamp?>">
    </head>

    <body>
    <nav class="navbar navbar-bg  navbar-expand-lg bg-body-tertiary sticky-top">
        <div class="container-fluid">
            <a class="navbar-brand" href="#">
                <img src="/img/logo.png" alt="Logo" class="logo d-inline-block align-text-top">
            </a>
            <button class="navbar-toggler collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="navbar-collapse collapse" id="navbarSupportedContent" style="">
                <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                    <li class="nav-item">
                        <a class="fs-3 nav-link" aria-current="page" href="/index.php">Home  |  </a>
                    </li>
                    <li class="nav-item">
                        <a class="fs-3 nav-link" href="/pages/notes.php">Notes  |  </a>
                    </li>
                    <li class="nav-item">
                        <a class="fs-3 nav-link" href="/pages/shared.php">Shared  </a>
                    </li>
                </ul>
                <ul class="navbar-nav ms-auto mb-2 mb-lg-0">
                    <li class="nav-item">
                        <a class="fs-4 nav-link" href="/pages/about.php">About | </a>
                    </li>
                    <li class="nav-item">
                        <a class="fs-4 nav-link" href="/pages/login.php">Login | </a>
                    </li>
                    <li class="nav-item">
                        <a class="fs-4 nav-link" href="/pages/register.php">Register</a>
                    </li>
                </ul>

            </div>
        </div>
    </nav>

        <!-- Content -->
        <div class="container">
            <h1>Welcome to my website!</h1>
            <p>This is some sample content.</p>
        </div>


        <!-- Footer -->
        <footer class="footer footer-bg">
            <div class="text-center p-3"">
                © 2023 Copyright:
                <a class="text-dark" href="https://github.com/ThomasCetto">Thomas Cetto</a>
            </div>
        </footer>

        <!-- Bootstrap JS -->
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ENjdO4Dr2bkBIFxQpeoTz1HIcje39Wm4jDKdf19U8gI4ddQ3GYNS7NTKfAdVQSZe" crossorigin="anonymous"></script>
    </body>
</html>
