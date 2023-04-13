<?php
session_start();
include "../default.php";

$username = $_SESSION['session_user_lele_planner_0425'];
$nome = $_SESSION['session_nome_lele_planner_0425'];
$cognome = $_SESSION['session_cognome_lele_planner_0425'];
$ao = $_SESSION['session_ao_lele_planner_0425'];
$nome_societa = $_SESSION['session_nome-societa_lele_planner_0425'];
$logo = $_SESSION['session_logo_lele_planner_0425'];


if ($logo == " " || $logo == "") {
    $logo = "logos/baseline_account_circle_black_24dp.png";
}

if ($ao == "a") {
    $genere = "femmina";
} else {
    $genere = "maschio";
}
?>
<!DOCTYPE html>
<html lang="it">
    <head>
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <!-- Icone -->
        <link rel="apple-touch-icon" sizes="180x180" href="../img/icon/apple-touch-icon.png">
        <link rel="icon" type="image/png" sizes="32x32" href="../img/icon/favicon-32x32.png">
        <link rel="icon" type="image/png" sizes="16x16" href="../img/icon/favicon-16x16.png">
        <link rel="manifest" href="../img/icon/site.webmanifest">
        <!-- Titolo -->
        <title>Il tuo account | <?php echo $nome_app; ?></title>
        <!-- CSS -->
        <link rel="stylesheet" href="../css/default.css" type="text/css">
        <link rel="stylesheet" href="https://fonts.googleapis.com/icon?family=Material+Icons">
        <style>
            #message {
                padding: 20px;
                margin-top: 10px;
            }

            #message p {
                padding: 1px 35px;
                font-size: 16px;
            }

            .valid {
                color: #1acc00;
            }

            .valid:before {
                position: relative;
                left: -35px;
                content: "✔";
            }
            
            .invalid {
                color: #ff6554;
            }

            .invalid:before {
                position: relative;
                left: -35px;
                content: "✖";
            }

            /* Pulsanti di invio e reset */

            input[type=submit] {
            cursor: pointer;
            border: none;
            transition: 0.4s;
            font-size: 18px;
            width: 160px;
            margin-top: 30px;
            padding: 5px;
            background-color: #29b429;
            color: #ffffff;
            }
            body {
                min-height: 100vh !IMPORTANT;
                display: flex !IMPORTANT;
                flex-direction: column !IMPORTANT;
            }

            footer {
                margin-top: auto !IMPORTANT;
            }
            
            input[type=submit]:disabled {
                opacity: 0.7;
                cursor: not-allowed;
            }

            input[type=submit]:disabled:hover {
                background-color: #29b429;
            }

            input[type=submit]:focus, input[type=submit]:active, input[type=submit]:hover {
            border: none;
            background-color: #208f20;
            }
        </style>
    </head>
    <body>
        <!-- Header -->
        <header>
            <div class="logo"><a href="../"><img src="../img/logo.png"></a></div>  
            <?php
            if (isset($_SESSION['session_id_lele_planner_0425'])) {
            ?>
            <div class="header-scritte">
                Benvenut<?php echo $ao; ?>, <div class="evidenziato user_name"><?php echo $nome." ".$cognome; ?>
                    <div class="user_actions">
                        <?php
                        if ($_SESSION['session_user_lele_planner_0425'] == "lele_administrator_admin" || $_SESSION['session_user_lele_planner_0425'] == "maintenance") {
                        ?>
                        <a href="../settings/"><i class="material-icons">settings</i> Impostazioni</a>
                        <hr>
                        <?php
                        }
                        ?>
                        <a href="../login/logout.php"><i class="material-icons">logout</i> Esci</a>
                    </div>
                </div>
            </div>

            <div class="logout">
                <div class="tooltip"><a href="../login/logout.php" class="material-icons headerbutton">logout</a>
                    <span class="tooltiptext">Logout</span>
                </div>
            </div>
            <?php
            } else {
            ?>
            <div class="header-scritte"><a href="login" class="evidenziato">Accedi</a> per inserire nuovi eventi</div>
            <div class="logout">
                <div class="tooltip">
                    <a href="../login" class="material-icons headerbutton">login</a>
                    <span class="tooltiptext">Login</span>
                </div>
            </div>
            <?php
            }
            ?>
        </header>
        <?php
        if (isset($_SESSION['session_id_lele_planner_0425'])) {
        ?>
        <div class="container">
            <h1>Il tuo account</h1>
            <table>
                <tr><td><b>Nome</b></td><td><?php echo $nome; ?></td></tr>
                <tr><td><b>Cognome</b></td><td><?php echo $cognome; ?></td></tr>
                <tr><td><b>Genere</b></td><td><?php echo $genere; ?></td></tr>
                <tr><td><b>Username</b></td><td><?php echo $username; ?></td></tr>
                <tr><td><b>Nome societ&agrave;</b></td><td><?php echo $nome_societa; ?></td></tr>
                <tr><td><b>Logo societ&agrave;</b></td><td><img src="../settings/gestione-utenti/nuovo/<?php echo $logo; ?>" alt="logo societa" height="40"></td></tr>
                <tr><td><b>Cambia password</b></td><td><button onclick="cambia()" id="cambia">Cambia</button></td></tr>
            </table>
            <script>
            function cambia() {
                var cambia = document.getElementById("cambia-psw");
                if (cambia.style.display == "block") {
                    cambia.style.opacity = "0";
                    cambia.style.display = "none";
                } else {
                    cambia.style.opacity = "1";
                    cambia.style.display = "block";
                    document.getElementById("check").focus();
                }
            }
            </script>
            <?php
            if (isset($_POST['submit']) && $_POST['submit']=="Cambia password")
            {
                include '../config.php';
                $username = cripta($username, "encrypt");
                $db = 'users';
                $conn = mysqli_connect($host,$user,$pass, $db) or die (mysqli_error());
                $query = mysqli_query($conn,"SELECT password FROM users WHERE username = '$username'") or die (mysqli_error($conn));
                $fetch = mysqli_fetch_array($query);
                $password = stripslashes($fetch['password']);
                $password1 = addslashes($_POST['password1']);
                $password2 = addslashes($_POST['password2']);
                $check = stripslashes($_POST['check']);
                $utilizzatore_content = stripslashes($_POST['utilizzatore_content']);
                
                if ($user == "admin") {
                    $utilizzatore = $utilizzatore_content;
                } else {
                    $utilizzatore = $user;
                }
                
                if (password_verify($check, $password) === true && $password1 == $password2) {
                    $new_password = password_hash($password1, PASSWORD_BCRYPT);
                    $sql = "UPDATE users SET password='$new_password' WHERE username = '$username'";

                    $myconn = mysqli_connect('localhost','root','mysql', 'accesses') or die (mysqli_error());
                    $timestamp = cripta(date('d/m/Y H:i:s', strtotime("now")), "encrypt");
                    $action = cripta("Password modificata correttamente", "encrypt");
                    $ip = cripta($_SERVER['REMOTE_ADDR'], "encrypt");
                    $uname = cripta($username, "encrypt");
                    $name = cripta($nome, "encrypt");
                    $cog = cripta($cognome, "encrypt");
                    $societa = cripta($nome_societa, "encrypt");
                    $mysql = "INSERT INTO accesses (username,nome,cognome,nome_societa,ip,azione,timestamp,validity) VALUES ('$uname', '$name','$cog','$societa','$ip','$action','$timestamp','$dataValidity')";

                    if (mysqli_query($conn,$sql) or die (mysqli_error($conn))) {
                        if($rressultt = mysqli_query($myconn,$mysql) or die (mysqli_error($myconn))) {
                            echo "<p>La password &egrave; stata modificata correttamente.</p>";
                        }
                    }
                } else if ($password1 != $password2) {
                    echo "Le due nuove password non corrispondono!";
                } else if ($password != $password_hash) {
                    echo "La password vecchia &egrave; errata!";
                } else {
                    echo "Errore nella procedura";
                }
            } else {
            ?>
            <!-- Sezione per cambiare password -->
            <section id="cambia-psw" style="display: none;">
                <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post"><br><br>
                    <!-- Password vecchia -->
                    <div class="input-container">
                        <input
                            type="password"
                            id="check"
                            name="check"
                            autocomplete="current-password"
                            value=""
                            aria-labelledby="label-check"
                            oninput="manageTextInputStyle('check')"
                            required
                        />
                        <label class="label" for="check" id="label-check">
                            <div class="text">Inserisci la password vecchia</div>
                        </label>
                    </div>
                    <br>
                    <!-- Password nuova -->
                    <div class="input-container">
                        <input
                            type="password"
                            id="password1"
                            name="password1"
                            value=""
                            aria-labelledby="label-password1"
                            oninput="manageTextInputStyle('password1')"
                            required
                        />
                        <label class="label" for="password1" id="label-password1">
                            <div class="text">Inserisci la password nuova</div>
                        </label>
                    </div>
                    <br>
                    <!-- Ripeti password nuova -->
                    <div class="input-container">
                        <input
                            type="password"
                            id="password2"
                            name="password2"
                            value=""
                            aria-labelledby="label-password2"
                            oninput="manageTextInputStyle('password2')"
                            required
                        />
                        <label class="label" for="password2" id="label-password2">
                            <div class="text">Ripeti la password nuova</div>
                        </label>
                    </div>
                    <input type="submit" name="submit" id="submit" value="Cambia password" disabled>
                </form>
                <div id="message">
                    <h3>La password deve contenere:</h3>
                    <p id="letter" class="invalid">Una lettera <b>minuscola</b></p>
                    <p id="capital" class="invalid">Una lettera <b>maiuscola</b></p>
                    <p id="number" class="invalid">Un <b>numero</b></p>
                    <p id="length" class="invalid">Almeno <b>8 caratteri</b></p>
                </div>
            </section>

            <!-- Far funzionare i campi di input -->
            <script>
            function manageTextInputStyle(id) {
                const input = document.getElementById(id);
                input.setAttribute('value', input.value);
            }
            </script>

            <script>
            var myInput = document.getElementById("password1");
            var letter = document.getElementById("letter");
            var capital = document.getElementById("capital");
            var number = document.getElementById("number");
            var length = document.getElementById("length");

            // When the user starts to type something inside the password field
            myInput.onkeyup = function() {
            // Validate lowercase letters
            var lowerCaseLetters = /[a-z]/g;
            if(myInput.value.match(lowerCaseLetters)) {  
                letter.classList.remove("invalid");
                letter.classList.add("valid");
            } else {
                letter.classList.remove("valid");
                letter.classList.add("invalid");
            }
            
            // Validate capital letters
            var upperCaseLetters = /[A-Z]/g;
            if(myInput.value.match(upperCaseLetters)) {  
                capital.classList.remove("invalid");
                capital.classList.add("valid");
            } else {
                capital.classList.remove("valid");
                capital.classList.add("invalid");
            }

            // Validate numbers
            var numbers = /[0-9]/g;
            if(myInput.value.match(numbers)) {  
                number.classList.remove("invalid");
                number.classList.add("valid");
            } else {
                number.classList.remove("valid");
                number.classList.add("invalid");
            }
            
            // Validate length
            if(myInput.value.length >= 8) {
                length.classList.remove("invalid");
                length.classList.add("valid");
            } else {
                length.classList.remove("valid");
                length.classList.add("invalid");
            }

            if (letter.className == "valid" && capital.className == "valid") {
                if (number.className == "valid" && length.className == "valid") {
                    document.getElementById("submit").removeAttribute("disabled");
                } else {
                    document.getElementById("submit").setAttribute("disabled", "");
                }
            } else {
                document.getElementById("submit").setAttribute("disabled", "");
            }
            }
            </script>
            <?php
            }
            ?>
            <?php
            } else {
                echo "<script type=\"text/javascript\">location.replace(\"../login\");</script>";
            }
            ?>
        </div>
            <br><br><br><br><br><br><br><br>
            <footer id="footer">
        <div class="footer-container">
            <div class="footer-row">
            <div class="footer-col">
                Realizzato da Albertin Emanuele e Paun Catalin-Adrian per conto di<br>
                <img alt="Logo I.I.S PRIMO LEVI di Badia Polesine" src="../img/logo_primo_levi.png" height="80">
            </div>
            <div class="footer-col">
                Progetto "Comunità inclusiva ed accogliente" in collaborazione con <img src="../img/logo_uni_pop.png" height="100" alt="Logo dell'Università Popolare del Tempo Libero di Castelmassa, Castelnovo Bariano, Ceneselli, Calto" title="Università Popolare del Tempo Libero di Castelmassa, Castelnovo Bariano, Ceneselli, Calto">
                <img alt="Logo Comune di Castelmassa" src="../img/logo_com_cast.png" height="80">
            </div>
            </div>
            <p class="copyright">A. P. Planner - ver. <?php echo $version; ?></p>
        </div>
        </footer>

        <script>
             document.addEventListener("DOMContentLoaded", function() {
            document.querySelector("#footer").style.opacity = 1;
            });
        </script>
    </body>
</html>
