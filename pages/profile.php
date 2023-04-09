<?php
session_set_cookie_params(30 * 24 * 60 * 60);
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

echo "profile page";
echo $_SESSION["username"];

?>
<form action="#" method="POST">
    <input name="sent" style="display:none;">
    <input type="submit" value="logout">
</form>

<?php
if(isset($_POST["sent"])){
    $_SESSION["username"] = null;
}
