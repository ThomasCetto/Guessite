<?php
function userExists($db_conn, $username){
    $query = "SELECT COUNT(*) as count 
              FROM account 
              WHERE username = '" . $username . "'";
    try{
        $data = mysqli_query($db_conn, $query);
        $row = mysqli_fetch_assoc($data);

        return $row["count"] == 1;

    }catch(Exception $e){
        echo "Errore in userExists " . $e->getMessage();
    }
    return True;
}

function emailExists($db_conn, $email){
    $query = "SELECT COUNT(*) as count 
              FROM account 
              WHERE email = '" . $email . "'";
    try{
        $data = mysqli_query($db_conn, $query);
        $row = mysqli_fetch_assoc($data);
        return $row["count"] == 1;

    }catch(Exception $e){
        echo "Errore in userExists " . $e->getMessage();
    }
    return True;
}