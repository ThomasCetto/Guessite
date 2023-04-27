<?php

session_set_cookie_params(30 * 24 * 60 * 60);
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
include "../scripts/db_connection.php";
include "../scripts/userFunctions.php";
include "../scripts/clubFunctions.php";

// to refresh the css everytime (Altervista doesn't do it otherwise)
$timestamp = time();

echo "aaaa";

printClubMembers($db_conn, "GuessiteOfficial", 10);