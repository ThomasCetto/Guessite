<?php
function userHasClub($db_conn, $username){
    $query = "
        SELECT club
        FROM account
        WHERE username = ?";

    try {
        $stmt = mysqli_prepare($db_conn, $query);
        mysqli_stmt_bind_param($stmt, "s", $username);
        mysqli_stmt_execute($stmt);
        $result = mysqli_stmt_get_result($stmt);
        $row = mysqli_fetch_assoc($result);
        mysqli_stmt_close($stmt);
        return $row["club"] != NULL;
    } catch (Exception $e) {
        return false;
    }
}

function getClubName($db_conn, $username){
    $query = "
        SELECT club
        FROM account
        WHERE username = ?";

    try {
        $stmt = mysqli_prepare($db_conn, $query);
        mysqli_stmt_bind_param($stmt, "s", $username);
        mysqli_stmt_execute($stmt);
        $result = mysqli_stmt_get_result($stmt);
        $row = mysqli_fetch_assoc($result);
        mysqli_stmt_close($stmt);
        return $row["club"];
    } catch (Exception $e) {
        return null;
    }
}


function getClubFromLeaderboard($db_conn, $clubName){
    $query = "
        SELECT pos, name, level, totalScore, owner, people
        FROM (
            SELECT ROW_NUMBER() OVER (ORDER BY SUM(s.score) DESC) AS pos, 
                c.name as name,
                c.level as level,
                SUM(s.score) as totalScore,
                c.owner as owner,
                COUNT(*) as people
            FROM club as c, account as a, accountStats as s
            WHERE c.name = a.club AND a.stats = s.username
            GROUP BY c.name
            ORDER BY totalScore DESC
        ) as tab
        WHERE name = ?;
    ";

    try {
        $stmt = mysqli_prepare($db_conn, $query);
        mysqli_stmt_bind_param($stmt, "s", $clubName);
        mysqli_stmt_execute($stmt);
        $result = mysqli_stmt_get_result($stmt);
        return mysqli_fetch_assoc($result);
    } catch (Exception $e) {
        echo "Errore in getUserFromLeaderboard " . $e->getMessage();
    }
    return null;
}



function printClubsLeaderboard($db_conn, $howMany)
{
    ?>
    <table class="table table-striped tab mx-auto" id="gridLeft">
        <thead>
        <tr>
            <th>#</th>
            <th>Nome</th>
            <th>Livello</th>
            <th>Punteggio</th>
            <th>Leader</th>
            <th>Numero membri</th>
        </tr>
        </thead>
        <tbody>

        <?php
        $result = getClubsLeaderboard($db_conn, $howMany);
        // for each user, add a row
        while ($row = $result->fetch_assoc()) {
            ?>
            <tr>
                <td><?php echo $row["pos"];?></td>
                <td><?php echo $row["name"];?></td>
                <td><?php echo $row["level"];?></td>
                <td><?php echo $row["totalScore"];?></td>
                <td><?php echo $row["owner"];?></td>
                <td><?php echo $row["people"] . "/" . $row["level"]*5;?></td>
            </tr>
            <?php
        }
        ?>

        </tbody>
    </table>
    <?php
}

function getClubsLeaderboard($db_conn, $howMany){
    $query = "
        SELECT pos, name, level, totalScore, owner, people
        FROM (
            SELECT ROW_NUMBER() OVER (ORDER BY SUM(s.score) DESC) AS pos, 
                c.name as name,
                c.level as level,
                SUM(s.score) as totalScore,
                c.owner as owner,
                COUNT(*) as people
            FROM club as c, account as a, accountStats as s
            WHERE c.name = a.club AND a.stats = s.username
            GROUP BY c.name
            ORDER BY totalScore DESC
        ) as tab
        LIMIT 0, ?;
    ";

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

function getUsersFromClub($db_conn, $clubName, $howMany){
    $query = "
        SELECT ROW_NUMBER() OVER (ORDER BY s.score DESC) AS pos,
               a.username, 
               s.score, 
               (s.guessed/s.tries) as perc
        FROM club c, account a, accountStats s
        WHERE c.name = ? AND c.name = a.club
        ORDER BY s.score
        LIMIT 0, $howMany
    ";
    try{
        $stmt = mysqli_prepare($db_conn, $query);
        mysqli_stmt_bind_param($stmt, "s", $clubName);
        mysqli_stmt_execute($stmt);
        $result = mysqli_stmt_get_result($stmt);
        mysqli_stmt_close($stmt);
        return $result;
    }catch(Exception $e){
        return null;
    }
}

function printClubMembers($db_conn, $clubName, $howMany){
    ?>
    <table class="table table-striped tab mx-auto" id="gridLeft">
        <thead>
        <tr>
            <th>#</th>
            <th>Username</th>
            <th>Punteggio</th>
            <th>Percentuale indovinati</th>
        </tr>
        </thead>
        <tbody>

        <?php
        $result = getUsersFromClub($db_conn, $howMany);
        // for each user, add a row
        while ($row = $result->fetch_assoc()) {
            ?>
            <tr>
                <td><?php echo $row["pos"];?></td>
                <td><?php echo $row["username"];?></td>
                <td><?php echo $row["score"];?></td>
                <td><?php echo $row["perc"];?></td>
            </tr>
            <?php
        }
        ?>
        </tbody>
    </table>
    <?php
}

function getClubName($db_conn, $username){
    $query = "
        SELECT club
        FROM account
        WHERE username = ?";

    try {
        $stmt = mysqli_prepare($db_conn, $query);
        mysqli_stmt_bind_param($stmt, "s", $username);
        mysqli_stmt_execute($stmt);
        $result = mysqli_stmt_get_result($stmt);
        $row = mysqli_fetch_assoc($result);
        mysqli_stmt_close($stmt);
        return $row["club"];
    } catch (Exception $e) {
        return null;
    }
}




