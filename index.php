<?php
session_start();
include "default.php";
$username = $_SESSION['session_user_lele_planner_0425'];
$nome = $_SESSION['session_nome_lele_planner_0425'];
$cognome = $_SESSION['session_cognome_lele_planner_0425'];
$ao = $_SESSION['session_ao_lele_planner_0425'];

// Valore usato dall'app AP Planner per mostrare solo gli eventi di una determinata associazione
$plannerID = $_GET['planner-id'];

// L'app passa il valore "appView", quindi la mando alla pagina ottimizzata
if ($_GET['appView'] == "true") {
    echo "<script>location.replace('app/index.php?plannerID=".$plannerID."');</script>\n";
}
?>
<!DOCTYPE html>
<html lang="it">
    <head>
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta name="robots" content="all" />
        <meta name="revisit-after" content="8" />
        <meta name="author" content="Albertin Emanuele, Paun Catalin-Adrian">
        <meta name="title" content="AP Planner - Planner associazioni">
        <meta name="description" content="Planner delle associazioni di volontariato dell'Alto Polesine.">
        <meta name="keywords" content="planner, castelmassa, associazioni, eventi Castelmassa, calto, ceneselli, castelnovo bariano, università popolare">
        <!-- Open Graph / Facebook -->
        <meta property="og:type" content="website">
        <meta property="og:url" content="<?php echo $_SERVER['SERVER_NAME'].$_SERVER['PHP_SELF']; ?>">
        <meta property="og:title" content="AP Planner - Planner associazioni">
        <meta property="og:description" content="Planner delle associazioni di volontariato dell'Alto Polesine.">
        <meta property="og:image" content="img/icon/apple-touch-icon.png">
        <!-- Twitter -->
        <meta property="twitter:card" content="summary_large_image">
        <meta property="twitter:url" content="<?php echo $_SERVER['SERVER_NAME'].$_SERVER['PHP_SELF']; ?>">
        <meta property="twitter:title" content="AP Planner - Planner associazioni">
        <meta property="twitter:description" content="Planner delle associazioni di volontariato dell'Alto Polesine.">
        <meta property="twitter:image" content="img/icon/apple-touch-icon.png">
        <!-- Icone -->
        <link rel="apple-touch-icon" sizes="180x180" href="img/icon/apple-touch-icon.png">
        <link rel="icon" type="image/png" sizes="32x32" href="img/icon/favicon-32x32.png">
        <link rel="icon" type="image/png" sizes="16x16" href="img/icon/favicon-16x16.png">
        <link rel="manifest" href="img/icon/site.webmanifest">
        <!-- Titolo -->
        <title>Planner | <?php echo $nome_app; ?></title>
        <!-- CSS -->
        <link rel="stylesheet" href="css/default.css" type="text/css">
        <link rel="stylesheet" href="css/style.css" type="text/css">
        <link rel="stylesheet" href="https://fonts.googleapis.com/icon?family=Material+Icons">
    </head>
    <body>
        <!-- Header -->
        <header>
            <div class="logo"><a href=""><img src="img\logo.png"></a></div>  
            <?php
            if (isset($_SESSION['session_id_lele_planner_0425'])) {
            ?>
            <div class="header-scritte">
                Benvenut<?php echo $ao; ?>, <div class="evidenziato user_name"><?php echo $nome." ".$cognome; ?>
                    <div class="user_actions">
                        <a href="account/"><i class="material-icons">manage_accounts</i> Gestisci il tuo account</a>
                        <?php
                        if ($_SESSION['session_user_lele_planner_0425'] == "lele_administrator_admin" || $_SESSION['session_user_lele_planner_0425'] == "maintenance") {
                        ?>
                        <hr>
                        <a href="settings/"><i class="material-icons">settings</i> Impostazioni</a>
                        <?php
                        }
                        ?>
                        <hr>
                        <a href="login/logout.php"><i class="material-icons">logout</i> Esci</a>
                    </div>
                </div>
            </div>

            <div class="logout">
                <div class="tooltip"><a href="login/logout.php" class="material-icons headerbutton">logout</a>
                    <span class="tooltiptext">Logout</span>
                </div>
            </div>
            <?php
            } else {
            ?>
            <div class="header-scritte"><a href="login" class="evidenziato">Accedi</a> per inserire nuovi eventi</div>
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
        <center>
            <?php
            // Se è la prima volta che si accede alla piattaforma, vengono mostrate delle informazioni utitli per l'uso della piattaforma
            if (!isset($_COOKIE['session_timestamp2_lele_planner_0425']) && isset($_SESSION['session_user_lele_planner_0425'])) {
                setcookie('session_timestamp2_lele_planner_0425','true', time() + (86400 * 30),'/');
                echo '<style>.guide {background: white; color: #333; min-width: 300px; width: 500px; padding-left: 30px; padding-right: 30px; padding: 20px; text-align: left; position: fixed; top: 45%; left: 42%; z-index: 15; box-shadow: 0 0 30px #333; z-index:50;}
                .guide h3 {margin-top: 0;} .guide .material-icons {font-size: 16px;}
                #bgblack {width: 100%; height: 100%; background: rgba(0,0,0,0.6); position: fixed; top:0; left:0; z-index:50;}</style>';
                echo '<div id="bgblack" style="display: block;"></div>';
                echo '<div class="guide" id="guide1" style="display: block;">';
                echo '<h3>Inserire un nuovo evento</h3>';
                echo 'Clicca su una casella del calendario per aggiungere un evento in quel giorno.<br><b>N.B.:</b> puoi farlo solo se prima hai eseguito l\'accesso all\'account.';
                echo '<p><button onclick="nextSlide(1)">OK (1/4)</button></p>';
                echo '</div>';
                echo '<div class="guide" id="guide2" style="display: none;">';
                echo '<h3>Visualizzare un evento</h3>';
                echo 'Clicca sull\'evento che desideri visualizzare.<br><b>N.B.:</b> puoi farlo anche se prima non hai eseguito l\'accesso all\'account.';
                echo '<p><button onclick="nextSlide(2)">OK (2/4)</button></p>';
                echo '</div>';
                echo '<div class="guide" id="guide3" style="display: none;">';
                echo '<h3>Visualizzare gli eventi del mese precedente/successivo</h3>';
                echo 'Per visualizzare gli eventi del mese precedente o di quello successivo, clicca sulle frecce ai lati del mese (sotto la scritta <i>'.$nome_app.'</i>).<br>Con <span class="material-icons">arrow_back_ios</span> torni al mese precedente, mentre con <span class="material-icons">arrow_forward_ios</span> passi al mese successivo';
                echo '<p><button onclick="nextSlide(3)">OK (3/4)</button></p>';
                echo '</div>';
                echo '<div class="guide" id="guide4" style="display: none;">';
                echo '<h3>Visualizzare le informazioni dell\'account e cambiare la password</h3>';
                echo 'Per visualizzare le informazioni dell\'account o per modificare la password, cliccare su <span class="material-icons">manage_accounts</span> <b>Gestisci il tuo account</b> che compare quando si passa con il mouse sul proprio nome (colorato di rosa).';
                echo '<p><button onclick="closeAll();nextSlide(4)">OK (4/4)</button></p>';
                echo '</div>';
                echo '<script>function nextSlide(slide) {document.getElementById("guide"+slide).style.display="none"; document.getElementById("guide"+(slide+1)).style.display="block";}';
                echo 'function closeAll() {document.getElementById("bgblack").style.display = "none";}</script>';
            }
            ?>
            <h1><?php echo $nome_app; ?></h1>
            <p class="small_devices"><< ---------- Scorri lateralmente ---------- >></p>
            <div class="tabel">
                <?php
                function ShowCalendar($m,$y)
                {
                    if ((!isset($_GET['d']))||($_GET['d'] == ""))
                    {
                        $m = date('n');
                        $y = date('Y');
                    } else {
                        $m = (int)strftime( "%m" ,(int)$_GET['d']);
                        $y = (int)strftime( "%Y" ,(int)$_GET['d']);
                        $m = $m;
                        $y = $y;
                    }

                    $precedente = mktime(0, 0, 0, $m -1, 1, $y);
                    $successivo = mktime(0, 0, 0, $m +1, 1, $y);

                    $nomi_mesi = array(
                        "Gennaio",
                        "Febbraio",
                        "Marzo",
                        "Aprile",
                        "Maggio",
                        "Giugno", 
                        "Luglio",
                        "Agosto",
                        "Settembre",
                        "Ottobre",
                        "Novembre",
                        "Dicembre"
                    );
                    $nomi_giorni = array(
                        "Lunedì",
                        "Martedì",
                        "Mercoledì",
                        "Giovedì",
                        "Venerdì",
                        "Sabato",
                        "Domenica"
                    );

                    $cols = 7;
                    $days = date("t",mktime(0, 0, 0, $m, 1, $y)); 
                    $lunedi= date("w",mktime(0, 0, 0, $m, 1, $y));
                    if($lunedi==0) $lunedi = 7;
                    echo "<table>\n"; 
                    echo "<tr>\n
                    <th class=\"mese\" colspan=\"2\">\n
                    <a class=\"cambia_mese material-icons\" title=\"Mese precedente\" style=\"padding-left: 10px; padding-right: 0;\" href=\"?d=" . $precedente . "\">arrow_back_ios</a>\n
                    </th>\n
                    <th class=\"mese\" colspan=\"3\">\n
                    " . $nomi_mesi[$m-1] . " " . $y . "
                    </th>\n
                    <th class=\"mese\" colspan=\"2\">
                    <a class=\"cambia_mese material-icons\" title=\"Mese successivo\" href=\"?d=" . $successivo . "\">arrow_forward_ios</a>\n
                    </th>\n
                    </tr>\n";
                    foreach($nomi_giorni as $v)
                    {
                        echo "<th>".$v."</th>\n";
                    }
                    echo "</tr>";

                    for($j = 1; $j<$days+$lunedi; $j++)
                    {
                        if($j%$cols+1==0)
                        {
                            echo "<tr>\n";
                        }
                        
                        // Se il mese non inizia il lunedi', si aggiungono altre celle per riempire i buchi
                        if($j<$lunedi)
                        {
                            echo "<td class=\"extra_day\"> </td>\n";
                        } else {
                            $day= $j-($lunedi-1);
                            $data = strtotime(date($y."-".$m."-".$day));
                            $oggi = strtotime(date("Y-m-d"));
                            $contenuto = " ";
                            include 'config.php';
                            
                            $db = 'planner';
                            $conn = mysqli_connect($host,$user,$pass, $db) or die (mysqli_error());
                            
                            $result = mysqli_query($conn,"SELECT data FROM planner") or die (mysqli_error($conn));

                            if(mysqli_num_rows($result) > 0)
                            {
                                while($fetch = mysqli_fetch_array($result))
                                {
                                    $str_data = $fetch['data'];
                                    if ($str_data == $data)
                                    {
                                        if (isset($plannerID)) {
                                            $sql = "SELECT * FROM planner WHERE data=$str_data, organizzatore='$plannerID'";
                                        } else {
                                            $sql = "SELECT * FROM planner WHERE data=$str_data";
                                        }
                                        $result = mysqli_query($conn,$sql) or die (mysqli_error($conn));
                                        
                                        if(mysqli_num_rows($result) == 1)
                                        {
                                            while($fetch = mysqli_fetch_array($result))
                                            {
                                                $id = stripslashes($fetch['id']);
                                                $titolo = stripslashes($fetch['titolo']);
                                                $data_evento = date("d-m-Y", $fetch['data']);
                                                $ora = stripslashes($fetch['ora']);
                                                $luogo = stripslashes($fetch['luogo']);
                                                $type = stripslashes($fetch['tipo']);
                                                $filenameDelete = stripslashes($fetch['link_foto_video']);
                                                $link_prenotazione = stripslashes($fetch['link_prenotazione']);
                                                $validity = stripslashes($fetch['validity']);
                                            }

                                            // Elimino le locandine degli eventi salvati da 2 o piu' anni
                                            if ($validity <= date('Ymd') - 20000) {
                                                unlink("evento/locandine/$filenameDelete");
                                            }
                            
                                            // Elimino record salvati da + di 2 anni
                                            $deleteSQL = mysqli_query($conn,"DELETE from planner WHERE validity <= CURDATE() - 20000") or die (mysqli_error($conn));


                                            if ($link_prenotazione != null || $link_prenotazione != "")
                                            {
                                                $bottone_prenotazione = "<a href=\"".$link_prenotazione."\" title=\"Prenota evento\" class=\"prenotaBtn\">Prenota evento</a>";
                                            } else {
                                                $bottone_prenotazione = "";
                                            }
                                        
                                            $contenuto = "<div class=\"nota\">
                                                            <a href=\"evento/?id=$id\">
                                                            <p class=\"title\" title=\"".$titolo."\">".$titolo."</p>
                                                            <p class=\"info_nota\">
                                                            <span title=\"".$ora."\"><i class=\"material-icons\">schedule</i>".$ora."</span><br>
                                                            <span title=\"".$luogo."\"><i class=\"material-icons\">place</i>".$luogo."</span>
                                                            </p>".$bottone_prenotazione."
                                                            </a>
                                                            </div>";
                                        }
                                        $num_rows = mysqli_num_rows($result);
                                        if($num_rows > 1)
                                            {
                                                while($fetch = mysqli_fetch_array($result))
                                                {
                                                    $id = stripslashes($fetch['id']);
                                                    $titolo = stripslashes($fetch['titolo']);
                                                    $data_evento = date("d-m-Y", $fetch['data']);
                                                }
                                            
                                                $contenuto = "<a href=\"evento/?day=$str_data\" title=\"Vedi tutti\"><div class=\"nota multipla\">Sono presenti ".$num_rows." eventi...</div></a>";
                                        }
                                    
                                    
                                    }
                                }
                            }

                            if($data == $oggi)
                            {
                                echo "<td class=\"oggi\" onclick=\"newEvent(".$data.")\"><span class=\"data\">".$day."</span>".$contenuto."</td>";
                            } else {
                                echo "<td onclick=\"newEvent(".$data.")\"><span class=\"data\">".$day."</span>".$contenuto."</td>";
                            }
                        }

                        if($j%$cols==0)
                        {
                        echo "</tr>";
                        }
                    }

                    // Se le celle dell'ultima riga sono meno di 7, se ne aggiungono altre
                    if ($j<42) {
                        // 36 = (7 colonne * 5 righe) + 1 perche' i e' minore, quindi deve arrivare fino a 35
                        // 36 - $day = dal numero massimo di giorni possibili (35 + 1 di prima) tolgo i giorni del mese in corso
                        // 36 - $day - $lunedi = dai giorni restanti tolgo quelli del mese prima e ottengo quelli del mese successivo
                        // (giorni totali - giorni mese attuale - giorni mese precedente = giorni mese successivo)
                        for($i=0; $i<36-$day-$lunedi;$i++) {
                            echo "<td class=\"extra_day\"></td>";
                        }
                    }
                    echo "</table>";
                }
                
                // Richiamo la funzione del calendario
                ShowCalendar(date("m"),date("Y"));
                ?>
            </div>
        </center>
        <script>
            function newEvent(data) {
                location.href = "nuovo?data=" + data;
            }
        </script>
        
        <br><br><br>

        <footer id="footer">
        <div class="footer-container">
            <div class="footer-row">
            <div class="footer-col">
                Realizzato da Albertin Emanuele e Paun Catalin-Adrian per conto di<br>
                <img alt="Logo I.I.S PRIMO LEVI di Badia Polesine" title="I.I.S PRIMO LEVI di Badia Polesine" src="img/logo_primo_levi.png" height="80">
            </div>
            <div class="footer-col">
                Progetto "Comunità inclusiva ed accogliente" in collaborazione con <img src="img/logo_uni_pop.png" height="100" alt="Logo dell'Università Popolare del Tempo Libero di Castelmassa, Castelnovo Bariano, Ceneselli, Calto" title="Università Popolare del Tempo Libero di Castelmassa, Castelnovo Bariano, Ceneselli, Calto">
                <img alt="Logo Comune di Castelmassa" title="Comune di Castelmassa" src="img/logo_com_cast.png" height="80">
            </div>
            </div>
            <p class="copyright">A. P. Planner - ver. <?php echo $version; ?></p>
        </div>
        <a href="https://forms.gle/kHUfzDRse281sreo7" target="_blank" style="text-align: left; text-decoration: underline; float: left; margin-left: 40px;">Consigliaci un miglioramento</a>
        </footer>

        <script>
             document.addEventListener("DOMContentLoaded", function() {
            document.querySelector("#footer").style.opacity = 1;
            });
        </script>
    </body>
</html>
