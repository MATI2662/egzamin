<?php
    $con = mysqli_connect("localhost", "root", "", "portal");
    if(!$con){
        die("Connection failed: " . mysqli_connect_error());
    }
?>

<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <title>Portal społecznościowy</title>
        <link rel="stylesheet" href="styl5.css">
    </head>
    <body>
        <header id = "headerL">
            <h2>Nasze osiedle</h2>
        </header>

        <header id = "headerP">
            <?php
                $sql = "SELECT COUNT(*) FROM dane";
                $result = mysqli_query($con, $sql);
                $row = mysqli_fetch_array($result);
                echo "<h5>Liczba użytkowników portalu: " . $row[0] . "</h5>";
            ?>
        </header>

        <div id = "lewy">
            <h3>Logowanie</h3>
            <form action="uzytkownicy.php" method="post">
                <label>Login</label> <br>
                <input type="text" name="login"> <br>
                <label>Hasło</label> <br>
                <input type="password" name="haslo"> <br>
                <input type="submit" value="Zaloguj">
            </form>
        </div>

        <div id = "prawy">
            <h3>Wizytówka</h3>
            <div id = "wizytowka">
                <?php
                    if(isset($_POST['login']) && isset($_POST['haslo'])){
                        $sql = "SELECT haslo FROM uzytkownicy WHERE login = '" . $_POST['login'] . "'";
                        $result = mysqli_query($con, $sql);
                        $row = mysqli_fetch_array($result);
                        if(!$row){
                            echo "login nie istnieje";
                        }
                        else{
                            if($row[0] == sha1($_POST['haslo'])){
                                $sql = "SELECT login, rok_urodz, przyjaciol, hobby, zdjecie FROM uzytkownicy INNER JOIN dane ON uzytkownicy.id = dane.id WHERE login = '" . $_POST['login'] . "'";
                                $result = mysqli_query($con, $sql);
                                $row = mysqli_fetch_array($result);
                                echo '<img src = "./' . $row[4] . '" alt = "osoba">';
                                echo "<h4>Login: " . $row[0] . "(" . date("Y") - $row[1] . ")</h4>";
                                echo "<p>Hobby:" . $row[3] . "</p>";
                                echo "<h1><img src = './icon-on.png'>" . $row[2] . "</h1>";
                                echo "<a href = 'dane.html'><button id = 'wizytowka_btn'>Więcej informacji</button></a>";

                            }
                            else{
                                echo "hasło nieprawidłowe";
                            }
                        }
                    }
                ?>
            </div>
        </div>

        <footer id = "footer">Stronę wykonał: PESEL</footer>
    </body>
</html>