<?php
function userExists($db_conn, $username): bool
{
    $query = "SELECT COUNT(*) as count 
              FROM account 
              WHERE username = ?";
    try {
        $stmt = mysqli_prepare($db_conn, $query);
        mysqli_stmt_bind_param($stmt, "s", $username);
        mysqli_stmt_execute($stmt);
        $data = mysqli_stmt_get_result($stmt);
        $row = mysqli_fetch_assoc($data);

        return $row["count"] == 1;

    } catch (Exception $e) {
        echo "Error in userExists: " . $e->getMessage();
    }
    return true;
}

function emailExists($db_conn, $email): bool
{
    $query = "SELECT COUNT(*) as count 
              FROM account 
              WHERE email = ?";
    try {
        $stmt = mysqli_prepare($db_conn, $query);
        mysqli_stmt_bind_param($stmt, "s", $email);
        mysqli_stmt_execute($stmt);
        $data = mysqli_stmt_get_result($stmt);
        $row = mysqli_fetch_assoc($data);

        return $row["count"] == 1;

    } catch (Exception $e) {
        echo "Error in emailExists: " . $e->getMessage();
    }
    return true;
}

function insertUser($db_conn, $username, $email, $pw)
{
    $pw = md5($pw);
    $query1 = "INSERT INTO accountStats(`username`) VALUES (?);";
    $query2 = "INSERT INTO account (`username`, `pw`, `email`, `stats`) VALUES (?, ?, ?, ?);";

    try {
        $stmt1 = mysqli_prepare($db_conn, $query1);
        mysqli_stmt_bind_param($stmt1, "s", $username);
        mysqli_stmt_execute($stmt1);

        $stmt2 = mysqli_prepare($db_conn, $query2);
        mysqli_stmt_bind_param($stmt2, "ssss", $username, $pw, $email, $username);
        mysqli_stmt_execute($stmt2);

    } catch (Exception $e) {
        echo "Error in insertUser: " . $e->getMessage();
    }
}

function getUsernameFromEmail($db_conn, $email)
{
    $query = "SELECT username
              FROM account
              WHERE email = ?";
    try {
        $stmt = mysqli_prepare($db_conn, $query);
        mysqli_stmt_bind_param($stmt, "s", $email);
        mysqli_stmt_execute($stmt);
        $data = mysqli_stmt_get_result($stmt);

        // read the first row, and check if the password is correct
        $row = mysqli_fetch_assoc($data);
        return $row["username"];

    } catch (Exception $e) {
        echo "Error in getUsernameFromEmail: " . $e->getMessage();
    }
    return "Unknown";
}

function checkLogin($db_conn, $field, $value, $pw): bool
{
    $pwInDatabase = getPassword($db_conn, $field, $value);
    return strcmp($pwInDatabase, md5($pw)) === 0;
}

function getEmailFromUsername($db_conn, $username)
{
    $query = "SELECT email 
              FROM account 
              WHERE username = ?";
    try {
        $stmt = mysqli_prepare($db_conn, $query);
        mysqli_stmt_bind_param($stmt, "s", $username);
        mysqli_stmt_execute($stmt);
        mysqli_stmt_bind_result($stmt, $email);
        mysqli_stmt_fetch($stmt);
        mysqli_stmt_close($stmt);

        return $email;
    } catch (Exception $e) {
        echo "Errore in getEmailFromUsername -> " . $e->getMessage();
    }
    return "Error";
}
function deleteUser($db_conn, $username)
{
    $query1 = "DELETE FROM account WHERE username = ?";
    $query2 = "DELETE FROM accountStats WHERE username = ?";

    try {
        $stmt1 = mysqli_prepare($db_conn, $query1);
        mysqli_stmt_bind_param($stmt1, "s", $username);
        mysqli_stmt_execute($stmt1);

        $stmt2 = mysqli_prepare($db_conn, $query2);
        mysqli_stmt_bind_param($stmt2, "s", $username);
        mysqli_stmt_execute($stmt2);

    } catch (Exception $e) {
        echo "Errore in deleteUser " . $e->getMessage();
    }
}

function getLeaderboard($db_conn, $howMany)
{
    $query = "
        SELECT ROW_NUMBER() OVER (ORDER BY s.score DESC) AS pos, 
           a.username, 
           s.score, 
           s.tries, 
           s.guessed
        FROM account AS a, accountStats AS s
        WHERE a.stats = s.username 
        ORDER BY s.score DESC LIMIT 0, ?";
    try {
        $stmt = mysqli_prepare($db_conn, $query);
        mysqli_stmt_bind_param($stmt, "i", $howMany);
        mysqli_stmt_execute($stmt);
        return mysqli_stmt_get_result($stmt);
    } catch (Exception $e) {
        echo "Errore in getLeaderboard() " . $e->getMessage();
    }
    return null;
}

function getUserFromLeaderboard($db_conn, $username)
{
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
        WHERE username = ?";
    try {
        $stmt = mysqli_prepare($db_conn, $query);
        mysqli_stmt_bind_param($stmt, "s", $username);
        mysqli_stmt_execute($stmt);
        $result = mysqli_stmt_get_result($stmt);
        return mysqli_fetch_assoc($result);
    } catch (Exception $e) {
        echo "Errore in getUserFromLeaderboard " . $e->getMessage();
    }
    return null;
}


function changePassword($db_conn, $username, $old, $new): bool
{
    if (strlen($new) <= 1) return false;

    $pwInDatabase = getPassword($db_conn, "username", $username);
    // if the user inputs the old password wrong it doesn't do anything
    if (strcmp($pwInDatabase, md5($old)) !== 0) return false;

    $query = "
        UPDATE account
        SET pw = ? 
        WHERE username = ?";

    try {
        $stmt = mysqli_prepare($db_conn, $query);
        mysqli_stmt_bind_param($stmt, "ss", md5($new), $username);
        mysqli_stmt_execute($stmt);

        mysqli_stmt_close($stmt);

        return true;

    } catch (Exception $e) {
        echo "Errore in changePassword -> " . $e->getMessage();
    }
    return false;
}
function getPassword($db_conn, $field, $value)
{
    $query = "SELECT * 
              FROM account 
              WHERE " . $field . " = ?";

    try {
        $stmt = mysqli_prepare($db_conn, $query);
        mysqli_stmt_bind_param($stmt, "s", $value);
        mysqli_stmt_execute($stmt);

        $result = mysqli_stmt_get_result($stmt);
        mysqli_stmt_close($stmt);

        $row = mysqli_fetch_assoc($result);
        return $row["pw"];

    } catch (Exception $e) {
        echo "Errore in getPassword -> " . $e->getMessage();
    }
    return null;
}
function addPoints($db_conn, $amount)
{
    // amount:
    // > 1 -> + guessed + tried
    // < 0 -> + tried
    $addGuessed = $amount > 0 ? 1 : 0;
    $username = $_SESSION["username"];

    $query = "
        UPDATE accountStats
        SET score = score + ?, guessed = guessed + (?), tries = tries + 1
        WHERE username = ?;
    ";

    $stmt = mysqli_prepare($db_conn, $query);
    mysqli_stmt_bind_param($stmt, "iis", $amount, $addGuessed, $username);

    //printf(str_replace('?', '%s', $query), $amount, $addGuessed, "\"" . $username . "\"");

    mysqli_stmt_execute($stmt);
    mysqli_stmt_close($stmt);
}





function modifyUser($db_conn, $oldUsername, $newUsername, $newScore, $newTries, $newGuessed)
{
    $query1 = "
        UPDATE accountStats
        SET username = ?, score = ?, tries = ?, guessed = ?
        WHERE username = ?";

    $query2 = "
        UPDATE account
        SET username = ?, stats = ?
        WHERE username = ?";

    try {
        $stmt1 = mysqli_prepare($db_conn, $query1);
        mysqli_stmt_bind_param($stmt1, "siiis", $newUsername, $newScore, $newTries, $newGuessed, $oldUsername);
        mysqli_stmt_execute($stmt1);

        $stmt2 = mysqli_prepare($db_conn, $query2);
        mysqli_stmt_bind_param($stmt2, "sss", $newUsername, $newUsername, $oldUsername);
        mysqli_stmt_execute($stmt2);

        mysqli_stmt_close($stmt1);
        mysqli_stmt_close($stmt2);

    } catch (Exception $e) {
        echo "Errore in modifyUser -> " . $e->getMessage();
    }
}

function printLeaderboardForAdmin($db_conn, $howMany)
{
    ?>
    <form action="/pages/administrator.php" method="POST">
        <input id="usernameToModifyField" type="hidden" name="usernameToModify">
        <input id="usernameToDeleteField" type="hidden" name="usernameToDelete">

        <table class="table table-striped tab mx-auto">
            <thead>
            <tr>
                <th>#</th>
                <th>Username</th>
                <th>Punteggio</th>
                <th>Tentativi</th>
                <th>Indovinati</th>
                <th>Modifica</th>
                <th>Eliminazione</th>
            </tr>
            </thead>
            <tbody>
            <?php

            $result = getLeaderboard($db_conn, $howMany);
            // for each user, add a row
            while ($row = $result->fetch_assoc()) {
                ?>
                <tr>
                    <td><?php echo $row["pos"]; ?></td>
                    <td>
                        <div class="row<?php echo $row["pos"]; ?>"><?php echo $row["username"]; ?></div>
                    </td>
                    <td>
                        <div class="row<?php echo $row["pos"]; ?>"><?php echo $row["score"]; ?></div>
                    </td>
                    <td>
                        <div class="row<?php echo $row["pos"]; ?>"><?php echo $row["tries"]; ?></div>
                    </td>
                    <td>
                        <div class="row<?php echo $row["pos"]; ?>"><?php echo $row["guessed"]; ?></div>
                    </td>

                    <td>
                        <input type="button" class="btn btn-success modifyButton" value="Modifica"
                               onclick=toggleModify(this,<?php echo $row["pos"]; ?>,"<?php echo $row["username"];?>")>
                    </td>

                    <td>
                        <input type="button" class="btn btn-danger" value="Elimina"
                               onclick=toggleDelete(this,<?php echo $row["pos"]; ?>,"<?php echo $row["username"];?>")>
                    </td>
                </tr>
                <?php
            }
            ?>
            </tbody>
        </table>
    </form>
    <?php
}

function printLeaderboard($db_conn, $howMany)
{
    ?>
    <table class="table table-striped tab mx-auto" id="gridLeft">
        <thead>
        <tr>
            <th>#</th>
            <th>Username</th>
            <th>Punteggio</th>
            <th>Tentativi</th>
            <th>Indovinati</th>
        </tr>
        </thead>
        <tbody>
        <?php


        $result = getLeaderboard($db_conn, $howMany);
        // for each user, add a row
        while ($row = $result->fetch_assoc()) {
            ?>
            <tr>
                <td><?php echo $row["pos"]; ?></td>
                <td><?php echo $row["username"]; ?></td>
                <td><?php echo $row["score"]; ?></td>
                <td><?php echo $row["tries"]; ?></td>
                <td><?php echo $row["guessed"]; ?></td>
            </tr>
            <?php
        }
        ?>
        </tbody>
    </table>
    <?php
}





