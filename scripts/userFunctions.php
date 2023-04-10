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
    $query = "SELECT * 
              FROM account 
              WHERE " . $field . " = '" . $value . "';";

    try {
        $data = mysqli_query($db_conn, $query);

        // read the first row, and check if the password is correct
        $row = mysqli_fetch_assoc($data);
        return strcmp($row["pw"], md5($pw)) === 0;

    } catch (Exception $e) {
        echo "Errore in checkLogin -> " . $e->getMessage();
    }
    return False;
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
        echo "Errore in checkLogin -> " . $e->getMessage();
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
        echo "Errore in userExists " . $e->getMessage();
    }
}

function getDBConnection(){
    $db_host = "localhost";
    $db_user = "cetto5inc2022";
    $db_pass = "";
    $db_name = "my_cetto5inc2022";

    global $db_conn;
    try{
        $db_conn = @mysqli_connect($db_host, $db_user, $db_pass, $db_name);

        if ($db_conn==null)
            throw new exception (mysqli_connect_error(). ' Error n.'. mysqli_connect_errno());
    } catch (Exception $e) {
        $error_message = $e->getMessage();
        echo "Errore nella connessione con il database";
    }
    return $db_conn;
}