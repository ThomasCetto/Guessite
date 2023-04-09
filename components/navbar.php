<style>
    .navbar-bg {
        background: rgb(0, 212, 255);
        background: linear-gradient(270deg, rgba(0, 212, 255, 1) 0%, rgba(123, 123, 255, 1) 100%);
    }

    .logo {
        height: 50px;
        width: 40px;
        margin-left: 15px;
    }
</style>

<nav class="navbar navbar-bg  navbar-expand-lg bg-body-tertiary sticky-top">
    <div class="container-fluid">
        <a class="navbar-brand" href="#">
            <img src="/img/logo.png" alt="Logo" class="logo d-inline-block align-text-top">
        </a>
        <button class="navbar-toggler collapsed" type="button" data-bs-toggle="collapse"
                data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false"
                aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="navbar-collapse collapse" id="navbarSupportedContent" style="">
            <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                <li class="nav-item">
                    <a class="fs-3 nav-link" aria-current="page" href="/index.php">Home | </a>
                </li>
                <li class="nav-item">
                    <a class="fs-3 nav-link" href="/pages/about.php">Immagini | </a>
                </li>
                <li class="nav-item">
                    <a class="fs-3 nav-link" href="/pages/about.php">Utenti </a>
                </li>
            </ul>
            <ul class="navbar-nav ms-auto mb-2 mb-lg-0">
                <li class="nav-item">
                    <a class="fs-4 nav-link" href="/pages/about.php">About | </a>
                </li>
                <?php
                if (isset($_SESSION["username"])) {
                    ?>
                    <li class="nav-item">
                        <a class="fs-4 nav-link" href="/pages/profile.php"><?php echo $_SESSION["username"]?></a>
                    </li>
                    <?php
                } else {
                    ?>
                    <li class="nav-item">
                        <a class="fs-4 nav-link" href="/pages/login.php">Accedi | </a>
                    </li>
                    <li class="nav-item">
                        <a class="fs-4 nav-link" href="/pages/register.php">Registrati</a>
                    </li>
                    <?php
                }
                ?>
            </ul>
        </div>
    </div>
</nav>
