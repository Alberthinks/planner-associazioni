<?php
session_start();
include "../default.php";

$str_data = $_GET['data'];
$data = date("d/m/Y", $str_data);

$id = $_GET['id'];
$organizzatore = $_GET['organizzatore'];

$username = $_SESSION['session_user_lele_planner_0425'];
$nome = $_SESSION['session_nome_lele_planner_0425'];
$cognome = $_SESSION['session_cognome_lele_planner_0425'];
$ao = $_SESSION['session_ao_lele_planner_0425'];
$nome_societa = $_SESSION['session_nome-societa_lele_planner_0425'];
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
        <title>Elimina evento | <?php echo $nome_app; ?></title>
        <!-- CSS -->
        <link rel="stylesheet" href="../css/default.css" type="text/css">
        <link rel="stylesheet" href="https://fonts.googleapis.com/icon?family=Material+Icons">
        <style>
            input[type=submit], input[type=reset] {cursor: pointer; border: none; transition: 0.4s; font-size: 18px; width: 160px; margin-top: 30px; padding: 5px; border-radius: 4px; box-sizing: border-box;}
            input[type=submit] {
                background-color: white;
                color: #29b429;
            }

            input[type=submit]:focus, input[type=submit]:active, input[type=submit]:hover {
                border: none;
                background-color: #29b429;
                color: white;
            }

            input[type=reset] {
                color: white;
                background-color: red;
            }

            input[type=reset]:focus, input[type=reset]:active, input[type=reset]:hover {
                background-color: #ad0000;
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
                        <a href="../account/"><i class="material-icons">manage_accounts</i> Gestisci il tuo account</a>
                        <?php
                        if ($_SESSION['session_user_lele_planner_0425'] == "lele_administrator_admin" || $_SESSION['session_user_lele_planner_0425'] == "maintenance") {
                        ?>
                        <hr>
                        <a href="../settings/"><i class="material-icons">settings</i> Impostazioni</a>
                        <?php
                        }
                        ?>
                        <hr>
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
            <div class="header-scritte"><a href="../login" class="evidenziato">Accedi</a> per inserire nuovi eventi</div>
            <div class="logout">
                <div class="tooltip">
                    <a href="login" class="material-icons headerbutton">login</a>
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
        <!-- Container -->
        <div class="container">
            <?php
            if ($_SESSION['session_user_lele_planner_0425'] == "lele_administrator_admin" || $_SESSION['session_nome-societa_lele_planner_0425'] == $organizzatore) {
                
                include '../config.php';
                $db = 'planner';
                $conn = mysqli_connect($host,$user,$pass, $db) or die (mysqli_error());

                if ($_POST['si'] = "Sì" && isset($_POST['del_id2'])) {
                    
                    $del_id2 = $_POST[del_id2];
                    $filenameDelete = $_POST['filenameDelete'];
                    
                    $myconn = mysqli_connect('localhost','root','mysql', 'accesses') or die (mysqli_error());
                    $timestamp = cripta(date('d/m/Y H:i:s', strtotime("now")), "encrypt");
                    $action = cripta("Eliminazione dell'evento (id: $del_id2)", "encrypt");
                    $ip = cripta($_SERVER['REMOTE_ADDR'], "encrypt");
                    $uname = cripta($username, "encrypt");
                    $name = cripta($nome, "encrypt");
                    $cog = cripta($cognome, "encrypt");
                    $societa = cripta($nome_societa, "encrypt");
                    $mysql = "INSERT INTO accesses (username,nome,cognome,nome_societa,ip,azione,timestamp,validity) VALUES ('$uname', '$name','$cog','$societa','$ip','$action','$timestamp','$dataValidity')";

                    if (mysqli_query($conn,"DELETE FROM planner WHERE id = '$del_id2'")or die(mysqli_error($conn))) {
                        if($rressultt = mysqli_query($myconn,$mysql) or die (mysqli_error($myconn))) {
                            if ($filenameDelete != "locandina_default.png") {
                                unlink("../evento/locandine/$filenameDelete");
                            }
                            echo "<script type=\"text/javascript\">location.replace(\"../\");</script>";
                        }
                    }
                }

                $query = mysqli_query($conn,"SELECT * FROM planner WHERE id = $id") or die (mysqli_error($conn));
                $fetch = mysqli_fetch_array($query) or die (mysqli_error());
                
                $titolo = stripslashes($fetch['titolo']);
                $data = date("d/m/Y", stripslashes($fetch['data']));
                $ora = stripslashes($fetch['ora']);
                $durata = stripslashes($fetch['durata']);
                $luogo = stripslashes($fetch['luogo']);
                $tipo = stripslashes($fetch['tipo']);
                $fileName = stripslashes($fetch['link_foto_video']);
                
                date_default_timezone_set('Europe/Rome');
            ?>
            <h1>Eliminazione dell'evento</h1>
            <p>L'eliminazione di questo evento è <b>definitiva</b>, perciò non potrà più essere annullata. Continuare?</p>
            <div>
                <h3>Dettagli dell'evento:</h3>
                <p>
                    <b>Titolo evento:</b> <?php echo $titolo; ?><br>
                    <b>Data evento:</b> <?php echo $data; ?><br>
                    <b>Ora di inizio evento:</b> <?php echo $ora; ?><br>
                    <b>Durata evento:</b> <?php echo $durata; ?><br>
                    <b>Luogo evento:</b> <?php echo $luogo; ?><br>
                    <b>Tipo evento:</b> <?php echo $tipo; ?>
                </p>
            </div>
            <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"])."?organizzatore=".$organizzatore; ?>">
                <input type="hidden" value="<?php echo $id; ?>" name="del_id2">
                <input type="hidden" value="<?php echo $fileName; ?>" name="filenameDelete">
                <input type="submit" value="Sì" name="si">
                <input type="reset" value="No" name="no" onclick="history.back();">
            </form>
            <?php
            }

        } else {
            echo "<script type=\"text/javascript\">location.replace(\"../\");</script>";
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
