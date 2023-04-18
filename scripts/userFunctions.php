<?php
function userExists($db_conn, $username): bool
{
    $query = "SELECT COUNT(*) as count 
              FROM account 
              WHERE username = '" . $username . "'";
    try {
        $data = mysqli_query($db_conn, $query);
        $row = mysqli_fetch_assoc($data);

        return $row["count"] == 1;

    } catch (Exception $e) {
        echo "Errore in userExists " . $e->getMessage();
    }
    return True;
}

function emailExists($db_conn, $email): bool
{
    $query = "SELECT COUNT(*) as count 
              FROM account 
              WHERE email = '" . $email . "'";
    try {
        $data = mysqli_query($db_conn, $query);
        $row = mysqli_fetch_assoc($data);
        return $row["count"] == 1;

    } catch (Exception $e) {
        echo "Errore in userExists " . $e->getMessage();
    }
    return True;
}

function insertUser($db_conn, $username, $email, $pw)
{
    $pw = md5($pw);
    $query1 = "INSERT INTO accountStats(`username`) VALUES ('$username');";
    $query2 = "INSERT INTO account (`username`, `pw`, `email`, `stats`) VALUES ('$username', '$pw', '$email', '$username');";

    try {
        mysqli_query($db_conn, $query1);
        mysqli_query($db_conn, $query2);
    } catch (Exception $e) {
        echo "Errore in insertUser -> " . $e->getMessage();
    }
}

function getUsernameFromEmail($db_conn, $email)
{
    $query = "
        SELECT username
        FROM account
        WHERE email = '" . $email . "';  
    ";
    try {
        $data = mysqli_query($db_conn, $query);

        // read the first row, and check if the password is correct
        $row = mysqli_fetch_assoc($data);
        return $row["username"];

    } catch (Exception $e) {
        echo "Errore in getUsernameFromEmail -> " . $e->getMessage();
    }
    return "Unknown";
}

function checkLogin($db_conn, $field, $value, $pw): bool
{
    $pwInDatabase = getPassword($db_conn, $field, $value);
    return strcmp($pwInDatabase, md5($pw)) === 0;
}

function getEmailFromUsername($db_conn, $username){
    $query = "SELECT email 
              FROM account 
              WHERE username = '" . $username . "';";

    try {
        $data = mysqli_query($db_conn, $query);
        $row = mysqli_fetch_assoc($data);
        return $row["email"];
    } catch (Exception $e) {
        echo "Errore in getEmailFromUsername -> " . $e->getMessage();
    }
    return "Error";
}

function deleteUser($db_conn, $username){
    $query = "DELETE FROM account WHERE username = '" . $username . "';";

    try {
        $data = mysqli_query($db_conn, $query);
        $row = mysqli_fetch_assoc($data);
        echo "Fatto bruh";
    } catch (Exception $e) {
        echo "Errore in deleteUser " . $e->getMessage();
    }
}
function getLeaderboard($db_conn, $howMany){
    $query = "
        SELECT ROW_NUMBER() OVER (ORDER BY s.score DESC) AS pos, 
           a.username, 
           s.score, 
           s.tries, 
           s.guessed
        FROM account AS a, accountStats AS s
        WHERE a.stats = s.username 
        ORDER BY s.score DESC LIMIT 0, $howMany;
";
    try {
        return mysqli_query($db_conn, $query);
    } catch (Exception $e) {
        echo "Errore in getLeaderboard() " . $e->getMessage();
    }
    return null;
}

function getUserFromLeaderboard($db_conn, $username){
    $query = "
        SELECT pos, username, score, tries, guessed
        FROM (
            SELECT ROW_NUMBER() OVER (ORDER BY s.score DESC) AS pos, 
                a.username,   
                s.score, 
                s.tries, 
                s.guessed
            FROM account AS a, accountStats AS s
            WHERE a.stats = s.username 
            ORDER BY s.score DESC
        ) as tab
        WHERE username = '" . $username . "';
    ";

    try {
        $result = mysqli_query($db_conn, $query);
        return mysqli_fetch_assoc($result);
    } catch (Exception $e) {
        echo "Errore in getUserFromLeaderboard " . $e->getMessage();
    }
    return null;
}

function changePassword($db_conn, $username, $old, $new): bool
{
    if(strlen($new) <= 1) return false;

    $pwInDatabase = getPassword($db_conn, "username", $username);
    // if the user inputs the old password wrong it doesn't do anything
    if(strcmp($pwInDatabase, md5($old)) !== 0) return false;

    $query = "
        UPDATE account
        SET pw = '" . md5($new) . "' 
        WHERE username = '" . $username . "';
    ";

    try {
        mysqli_query($db_conn, $query);
        return true;

    } catch (Exception $e) {
        echo "Errore in changePassword -> " . $e->getMessage();
    }
    return false;
}

function getPassword($db_conn, $field, $value){
    $query = "SELECT * 
              FROM account 
              WHERE " . $field . " = '" . $value . "';";

    try {
        $data = mysqli_query($db_conn, $query);
        $row = mysqli_fetch_assoc($data);
        return $row["pw"];

    } catch (Exception $e) {
        echo "Errore in getPassword -> " . $e->getMessage();
    }
    return null;
}

function addPoints($db_conn, $amount){
    // amount:
    // > 1 -> + guessed + tried
    // < 0 -> + tried
    $addGuessed = $amount > 0 ? 1 : 0;

    $query = "
        UPDATE accountStats
        SET score = score + $amount, guessed = guessed + $addGuessed, tries = tries + 1
        WHERE username = '" . $_SESSION["username"] . "';
    ";

    try {
        mysqli_query($db_conn, $query);
    } catch (Exception $e) {
        echo "Errore in addPoints -> " . $e->getMessage();
    }
}