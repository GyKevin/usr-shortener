<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Profile</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="style.css?v=1">
    <script src="nav.js" defer></script>
    <?php
    $userID = null;
    if (isset($_COOKIE['iduser'])) {
        $userID = $_COOKIE["iduser"];
    }

    $dbc = require './../database/db.php';
    $res = $dbc->query("SELECT userid, username, email FROM user WHERE userid='{$userID}'");
    $row = $res->fetch_assoc();

    if (isset($_POST["logout"])) {
        unset($_COOKIE['iduser']);
        setcookie('iduser', null, -1, "/");
        header("Location: index.php");
    }
    ?>
</head>
<body>
<header class="primary-header flex">
        <div>
            <img src="./../img/logo.svg" class="logo">
        </div>

        <button class="mobile-nav-toggle" aria-controls="primary-navigator" aria-expanded="false"><span class="sr-only">Menu</span></button>

        <nav>
            <ul id="primary-navigator" data-visible="false" class="primary-navigation flex">
                <li class="active">
                    <a aria-hidden="true" href="./../index.php">Home</a>
                </li>
                <?php
                    if ($userID !== NULL){
                    echo "<li><a aria-hidden=\"true\" class=\"active\" href=\"#\">Profile</a></li>";
                    echo "<li><a aria-hidden=\"true\" href=\"./../my-urls\">My Urls</a></li>";
                    }

                    if ($userID !== NULL) {
                        echo "<li><form action=\"./../index.php\" method=\"post\" id=\"logout\"><input type=\"hidden\" name=\"logout\" value=\"Index\"><a href=\"javascript:{}\" onclick=\"document.getElementById('logout').submit(); return false;\">Logout</a></form></li>";
                    } else {
                        echo "<li><a aria-hidden=\"true\" href=\"./../sign-in\">Sign In</a></li>";
                    }
                    ?>
            </ul>
        </nav>
    </header>

    <form id="field" action="script.php" method="post" autocomplete="off">
        <center>
        <div class="info">
            <p class="sign-in">Profile</p>
        </div>
        <?php echo "<input type=\"text\" name=\"username\" placeholder='" . $row['username'] . "#".$row['userid']."' disabled required>" ?>
        <?php echo "<input type=\"email\" id=\"new-mail\" name=\"email\" placeholder='" . $row['email'] . "'  required>" ?>
        <br>
        <input type="submit" id="new-button" value="SAVE">
        <br>
        <?php
        session_start();
        if (isset($_SESSION['errors'])) {
            $error_output = $_SESSION['errors'];
            echo $error_output;
            unset($_SESSION['errors']);
        }
        ?>
        <br>
        <p class="no-acc">Forgot password? <a class="create-acc" href="./pass">Change password</a></p>
        </center>
    </form>
</body>
</html>