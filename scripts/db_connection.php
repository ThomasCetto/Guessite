<?php

$db_host = "localhost";
$db_user = "cetto5inc2022";
$db_pass = "";
$db_name = "my_cetto5inc2022";

global $db_conn;
try{
    $db_conn = @mysqli_connect($db_host, $db_user, $db_pass, $db_name);

    if ($db_conn==null)
        throw new exception (mysqli_connect_error(). ' Error n.'. mysqli_connect_errno());
} catch (Exception $e){
    $error_message = $e->getMessage();
}
