<style>
    .navbar-bg {
        background: rgb(150, 150, 255);
        background: linear-gradient(90deg, rgba(150, 150, 255, 1) 0%, rgba(0, 212, 255, 1) 100%);
    }

    .logo {
        width: 75%;
        height: 90%;
    }

    #logoContainer {
        width: 60px;
        height: 60px;
        margin-left: 15px;
        border: 1px solid blue;
        border-radius: 4px;
        text-align: center;

        background: rgb(5,210,251);
        background: radial-gradient(circle, rgba(5,210,251,1) 0%, rgba(110,127,255,1) 81%);

    }
</style>

<nav class="navbar navbar-bg  navbar-expand-lg bg-body-tertiary sticky-top">
    <div class="container-fluid">
        <!-- Logo -->
        <a class="navbar-brand" href="/index.php">
            <div id="logoContainer">
                <img src="/img/logo.png" alt="Logo" class="logo d-inline-block align-text-top">
            </div>
        </a>

        <!-- Button to open the navbar -->
        <button class="navbar-toggler collapsed" type="button" data-bs-toggle="collapse"
                data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false"
                aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>

        <!-- Left side of the navbar -->
        <div class="navbar-collapse collapse" id="navbarSupportedContent" style="">
            <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                <li class="nav-item">
                    <a class="fs-3 nav-link" aria-current="page" href="/index.php">Home | </a>
                </li>
                <li class="nav-item">
                    <a class="fs-3 nav-link" href="/pages/draw.php">Disegna | </a>
                </li>
                <li class="nav-item">
                    <a class="fs-3 nav-link" href="/pages/guess.php">Sfida | </a>
                </li>
                <li class="nav-item">
                    <a class="fs-3 nav-link" href="/pages/users.php">Classifica </a>
                </li>
            </ul>

            <!-- Right side of the navbar -->
            <ul class="navbar-nav ms-auto mb-2 mb-lg-0">
                <li class="nav-item">
                    <a class="fs-4 nav-link" href="/pages/about.php">About | </a>
                </li>
                <?php
                if (isset($_SESSION["username"])) {
                    if ($_SESSION["username"] == "admin") {
                        ?>
                        <li class="nav-item">
                            <a class="fs-4 nav-link" href="/pages/administrator.php">Area amministratore | </a>
                        </li>
                        <?php
                    }
                    ?>

                    <li class="nav-item">
                        <a class="fs-4 nav-link" href="/pages/profile.php"><?php echo $_SESSION["username"]; ?></a>
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
