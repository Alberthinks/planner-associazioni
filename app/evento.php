<?php
include '../default.php';
session_start();
$username = $_SESSION['session_user_lele_planner_0425'];
$nome = $_SESSION['session_nome_lele_planner_0425'];
$cognome = $_SESSION['session_cognome_lele_planner_0425'];
$ao = $_SESSION['session_ao_lele_planner_0425'];

$id_evento = $_GET['id'];

// Url condiviso sui social network per vedere l'evento dal planner
$url = "http://192.168.1.7".$_SERVER['PHP_SELF']."?id=".$id_evento;

$str_data = $_GET['day'];
$data = date("d/m/Y", $str_data);

include '../config.php';
$db = 'planner';
$conn = mysqli_connect($host,$user,$pass, $db) or die (mysqli_error());
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
        <title>Eventi | <?php echo $nome_app; ?></title>
        <!-- CSS -->
        <!--<link rel="stylesheet" href="../evento/css/style.css" type="text/css">-->
        <link rel="stylesheet" href="../css/default_phone.css" type="text/css">
        <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@48,400,0,0" />
        <?php
        
        if (isset($id_evento) && is_numeric($id_evento)) {
            $sql = "SELECT * FROM planner WHERE id=$id_evento";
                $result = mysqli_query($conn,$sql) or die (mysqli_error($conn));

                if(mysqli_num_rows($result) > 0) {
                    while($fetch = mysqli_fetch_array($result)) {
                        $titolo = stripslashes($fetch['titolo']);
                        $descrizione = stripslashes($fetch['descrizione']);
                    }
                }
        ?>
        <!-- Social meta tags -->
        <meta property="og:title" content="<?php echo $titolo; ?>">
        <meta property="og:type" content="article" />
        <meta property="og:description" content="<?php echo $descrizione; ?>">
        <meta property="og:image" content="../img/Logo.png">
        <meta property="og:url" content="<?php echo $url; ?>">
        <meta name="twitter:card" content="summary_large_image">
        <?php
        }
        ?>
    </head>
    <body style="overflow-y: auto;">
        <div class="container">
            <header>
                <a class="material-symbols-outlined" onclick="history.back()">arrow_back</a>
                <a class="material-symbols-outlined" onclick="addToCalendar()">event</a>
                <a class="material-symbols-outlined" onclick="shareEvent()" style="float: right;">share</a>
            </header>
            <?php
            if (isset($id_evento) && is_numeric($id_evento)) {

                $sql = "SELECT * FROM planner WHERE id=$id_evento";
                $result = mysqli_query($conn,$sql) or die (mysqli_error($conn));

                if(mysqli_num_rows($result) > 0) {
                    while($fetch = mysqli_fetch_array($result)) {
                        $id = stripslashes($fetch['id']);
                        $titolo = stripslashes($fetch['titolo']);
                        $descrizione = stripslashes($fetch['descrizione']);
                        $data = stripslashes($fetch['data']);
                        $ora = stripslashes($fetch['ora']);
                        $durata = stripslashes($fetch['durata']);
                        $organizzatore = stripslashes($fetch['organizzatore']);
                        $luogo = stripslashes($fetch['luogo']);
                        $tipo = stripslashes($fetch['tipo']);
                        $link_prenotazione = stripslashes($fetch['link_prenotazione']);
                        $link_foto_video = stripslashes($fetch['link_foto_video']);
                        $data_modifica = stripslashes($fetch['data_modifica']);

                        // Se e' stata caricata un'immagine come locandina, si mostra l'immagine; altrimenti non si mostra niente

                        if ($link_foto_video == "") {
                            $link_foto_video = "locandina_default.png";
                        }

                        switch ($luogo) {
                            case "Area di sosta per camper - via Argine Po":
                                $plusCode = "2876%2BH9 Castelmassa, Provincia di Rovigo";
                                break;
                            case "Black Coffee Arena (parcheggio bar Nerocaffè)":
                                $plusCode = "2887%2BR4 Castelmassa, Provincia di Rovigo";
                                break;
                            case 'Biblioteca comunale "E. Fornasari"':
                                $plusCode = "2886%2b66 Castelmassa, Provincia di Rovigo";
                                break;
                            case 'Centro sociale':
                                $plusCode = "2878%2BG2 Castelmassa, Provincia di Rovigo";
                                break;
                            case 'Crispo':
                                $plusCode = "28CC%2BG23 Castelmassa, Provincia di Rovigo";
                                break;
                            case 'Centro giovanile pastorale di Castelmassa':
                                $plusCode = "2885%2BXR4 Castelmassa, Provincia di Rovigo";
                                break;
                            case 'Kayak Club':
                                $plusCode = "2884%2BM3V Castelmassa, Provincia di Rovigo";
                                break;
                            case 'Mercato coperto':
                                $plusCode = "2886%2B3V Castelmassa, Provincia di Rovigo";
                                break;
                            case 'Piazza della Libertà':
                                $plusCode = "2885%2BJ95 Castelmassa, Provincia di Rovigo";
                                break;
                            case 'Piazza della Repubblica':
                                $plusCode = "2897%2B6PC Castelmassa, Provincia di Rovigo";
                                break;
                            case 'Piazzetta A. Ragazzi':
                                $plusCode = "2886%2BJ7G Castelmassa, Provincia di Rovigo";
                                break;
                            case 'Palestra comunale di Castelmassa':
                                $plusCode = "2895%2B772 Castelmassa, Provincia di Rovigo";
                                break;
                            case 'Piscine di Castelmassa':
                                $plusCode = "28C3%2BMW Masina, Provincia di Rovigo";
                                break;
                            case 'Sala polivalente':
                                $plusCode = "2895%2B3XV Castelmassa, Provincia di Rovigo";
                                break;
                            case 'Scuola primaria di I grado "E. Panzacchi"':
                                $plusCode = "2895%2B54 Castelmassa, Provincia di Rovigo";
                                break;
                            case 'Scuola secondaria di I grado "G. Sani"':
                                $plusCode = "2897%2BG9 Castelmassa, Provincia di Rovigo";
                                break;
                            case 'Scuola secondaria di II grado "B. Munari"':
                                $plusCode = "2895%2BG4 Castelmassa, Provincia di Rovigo";
                                break;
                            case 'Sede A.V.P.':
                                $plusCode = "2894%2BV8 Castelmassa, Provincia di Rovigo";
                                break;
                            case 'Sede BIG RIVER MOTOCLUB':
                                $plusCode = "28C6%2BM2 Castelmassa, Provincia di Rovigo";
                                break;
                            case 'Teatro Cotogni':
                                $plusCode = "2886%2BR5 Castelmassa, Provincia di Rovigo";
                                break;
                            default:
                                $plusCode = "2896%2b234 Castelmassa, Provincia di Rovigo";
                        }

                        // Parte per il calcolo della data e dell'ora di fine dell'evento per l'app Android
                        $end = explode(" ", $durata);
                        if (strpos($durata, " or") == null) {
                            $endTime = date("Ymd", $data)."00:".$end[0];
                        } else {
                            $endTime = date("Ymd", $data).$end[0].":".$end[3];
                        }

                        echo "<script>
                            // Funzione per aggiungere l'evento al calendario
                            function addToCalendar() {
                                APPlanner.addToCalendar(\"".$titolo."\", \"".$descrizione."\", \"".$luogo."\", \"".date("Ymd", $data).$ora."\", \"".$endTime."\");
                            }

                            // Funzione per condividere l'evento con altre persone
                            function shareEvent() {
                                APPlanner.shareEvent(\"".$titolo."\",\"".$url."\");
                            }
                        </script>";

                        echo "<div class=\"informazioni\">";
                        echo "<h2 class=\"titolo\">".$titolo."</h2>\n";
                        echo "<i class=\"material-symbols-outlined\">calendar_today</i> <b>Data:</b> ".date("d/m/Y", $data)."<br>\n";
                        echo "<i class=\"material-symbols-outlined\">schedule</i> <b>Ora di inizio:</b> ".$ora."<br>\n";
                        echo "<i class=\"material-symbols-outlined\">timelapse</i> <b>Durata:</b> ".$durata."<br>\n";

                        if ($plusCode == "2896%2b234 Castelmassa, Provincia di Rovigo") {
                            echo "<i class=\"material-symbols-outlined\">location_on</i> <b>Luogo:</b> ".$luogo."<br>\n";
                        } else {
                            echo "<i class=\"material-symbols-outlined\">location_on</i> <b>Luogo:</b> <a href=\"https://www.google.com/maps/place/".$plusCode."\" target=\"_blank\">".$luogo." <i class=\"material-symbols-outlined\" style=\"font-size: 16px !important;\">open_in_new</i></a><br>\n";
                        }
                        
                        // Ottenere il logo dell'organizzatore
                        $db2 = 'users';
                        $conn2 = mysqli_connect($host,$user,$pass, $db2) or die (mysqli_error());
                        $organizzatoreCriptato = cripta($organizzatore, "encrypt");
                        $result2 = mysqli_query($conn2,"SELECT * FROM users WHERE nome_societa='$organizzatoreCriptato'") or die (mysqli_error($conn2));
                        $fetch2 = mysqli_fetch_array($result2);

                        if ($descrizione != "") {
                            $descrizione = ": ".$descrizione;
                        }

                        // Descrizione dell'evento
                        echo "<p class='descrizione'><b>".$tipo."</b>".$descrizione."</p>\n";

                        if ($link_foto_video != "" && $link_foto_video != "locandina_default.png")
                        echo "<p><a href='showLocandina.php?url=".$link_foto_video."'><i class='material-symbols-outlined'>draft</i>Vedi locandina</a></p>";

                        echo "<img style='margin-top: 40px; width: 60px;' alt='logo organizzatore' src='../settings/gestione-utenti/nuovo/".cripta($fetch2['logo'],"decrypt")."'><br>\n";
                        echo "</div>";


                        echo "<div class=\"right_content\">";
                        echo '<img src="../evento/locandine/'.$link_foto_video.'" alt="locandina dell\'evento" id="locandina">';

                        if ($link_prenotazione != null || $link_prenotazione != "") {
                            echo "<a href=\"".$link_prenotazione."\" target=\"_blank\" title=\"Prenota evento\"><button class=\"prenotaBtn\"><i class=\"material-symbols-outlined\">book_online</i> Iscriviti all&apos;evento</button></a>";
                        }
                    }
                }
            } elseif (isset($str_data) && is_numeric($str_data)) {
                $sql = "SELECT * FROM planner WHERE data=$str_data";
                $result = mysqli_query($conn,$sql) or die (mysqli_error($conn));
            ?>
            <h1>Eventi del <?php echo $data; ?></h1>
            <?php
            if(mysqli_num_rows($result) > 0) {
                while($fetch = mysqli_fetch_array($result)) {
                    $id = stripslashes($fetch['id']);
                    $titolo = stripslashes($fetch['titolo']);
                    $descrizione = stripslashes($fetch['descrizione']);
                    $data = stripslashes($fetch['data']);
                    $ora = stripslashes($fetch['ora']);
                    $durata = stripslashes($fetch['durata']);
                    $organizzatore = stripslashes($fetch['organizzatore']);
                    $luogo = stripslashes($fetch['luogo']);
                    $tipo = stripslashes($fetch['tipo']);
                    $link_prenotazione = stripslashes($fetch['link_prenotazione']);
                    $link_foto_video = stripslashes($fetch['link_foto_video']);
                    $data_modifica = stripslashes($fetch['data_modifica']);

                    echo '<div class="singola_nota">';
                    echo "<h2>".$titolo."</h2>\n";
                    echo "<p>".$descrizione."</p>\n";

                    echo '<div class="singola_nota_right">';
                    if ($link_prenotazione != null || $link_prenotazione != "") {
                        echo "<a href=\"".$link_prenotazione."\" target=\"_blank\" title=\"Prenota evento\" class=\"prenotaBtn\">Prenota evento</a>";
                    }
                    echo "<div class=\"share\" style=\"background-color: transparent; width: auto;\"><a title=\"Condividi su WhatsApp\" href=\"https://api.whatsapp.com/send/?text=".$titolo.$_SERVER['SERVER_NAME'].$_SERVER['PHP_SELF']."%3Fid%3D".$id."\"><img src=\"../img/icons8-whatsapp.svg\"></a>";
                    echo '<a target="_blank" title="Condividi su Facebook" href="https://www.facebook.com/sharer/sharer.php?u='.$_SERVER["SERVER_NAME"].$_SERVER["PHP_SELF"].'%3Fid%3D'.$id.'" class="fb-xfbml-parse-ignore"><img src="../img/icons8-facebook-nuovo.svg"></a>';
                    echo '<a target="_blank" title="Condividi su Twitter" href="https://twitter.com/intent/tweet?text='.$titolo.'&url='.$_SERVER["SERVER_NAME"].$_SERVER["PHP_SELF"].'%3Fid%3D'.$id.'"><img src="../img/icons8-twitter-cerchiato.svg"></a>';
                    echo '<a target="_blank" title="Condividi su LinkedIn" href="https://www.linkedin.com/shareArticle?title='.$titolo.'&url='.$_SERVER["SERVER_NAME"].$_SERVER["PHP_SELF"].'%3Fid%3D'.$id.'"><img src="../img/icons8-linkedin-cerchiato.svg"></a>';
                    echo '<a title="Copia link" href="javascript:copyUrl(\''.$_SERVER["SERVER_NAME"].$_SERVER["PHP_SELF"].'%3Fid%3D'.$id.'\')"><img src="../img/icons8-link-48.png"></a></div></div>';
                    
                    echo '<script>function copyUrl(url) {navigator.clipboard.writeText(url);alert("Link copiato negli appunti");}</script>';

                    switch ($luogo) {
                        case "Area di sosta per camper - via Argine Po":
                            $plusCode = "2876%2BH9 Castelmassa, Provincia di Rovigo";
                            break;
                        case "Black Coffee Arena (parcheggio bar Nerocaffè)":
                            $plusCode = "2887%2BR4 Castelmassa, Provincia di Rovigo";
                            break;
                        case 'Biblioteca comunale "E. Fornasari"':
                            $plusCode = "2886%2b66 Castelmassa, Provincia di Rovigo";
                            break;
                        case 'Centro sociale':
                            $plusCode = "2878%2BG2 Castelmassa, Provincia di Rovigo";
                            break;
                        case 'Crispo':
                            $plusCode = "28CC%2BG23 Castelmassa, Provincia di Rovigo";
                            break;
                        case 'Centro giovanile pastorale di Castelmassa':
                            $plusCode = "2885%2BXR4 Castelmassa, Provincia di Rovigo";
                            break;
                        case 'Kayak Club':
                            $plusCode = "2884%2BM3V Castelmassa, Provincia di Rovigo";
                            break;
                        case 'Mercato coperto':
                            $plusCode = "2886%2B3V Castelmassa, Provincia di Rovigo";
                            break;
                        case 'Piazza della Libertà':
                            $plusCode = "2885%2BJ95 Castelmassa, Provincia di Rovigo";
                            break;
                        case 'Piazza della Repubblica':
                            $plusCode = "2897%2B6PC Castelmassa, Provincia di Rovigo";
                            break;
                        case 'Piazzetta A. Ragazzi':
                            $plusCode = "2886%2BJ7G Castelmassa, Provincia di Rovigo";
                            break;
                        case 'Palestra comunale di Castelmassa':
                            $plusCode = "2895%2B772 Castelmassa, Provincia di Rovigo";
                            break;
                        case 'Piscine di Castelmassa':
                            $plusCode = "28C3%2BMW Masina, Provincia di Rovigo";
                            break;
                        case 'Sala polivalente':
                            $plusCode = "2895%2B3XV Castelmassa, Provincia di Rovigo";
                            break;
                        case 'Scuola primaria di I grado "E. Panzacchi"':
                            $plusCode = "2895%2B54 Castelmassa, Provincia di Rovigo";
                            break;
                        case 'Scuola secondaria di I grado "G. Sani"':
                            $plusCode = "2897%2BG9 Castelmassa, Provincia di Rovigo";
                            break;
                        case 'Scuola secondaria di II grado "B. Munari"':
                            $plusCode = "2895%2BG4 Castelmassa, Provincia di Rovigo";
                            break;
                        case 'Sede A.V.P.':
                            $plusCode = "2894%2BV8 Castelmassa, Provincia di Rovigo";
                            break;
                        case 'Sede BIG RIVER MOTOCLUB':
                            $plusCode = "28C6%2BM2 Castelmassa, Provincia di Rovigo";
                            break;
                        case 'Teatro Cotogni':
                            $plusCode = "2886%2BR5 Castelmassa, Provincia di Rovigo";
                            break;
                        default:
                            $plusCode = "2896%2b234 Castelmassa, Provincia di Rovigo";
                    }

                    echo '<div class="singola_nota_left">';
                    echo "<i class=\"material-symbols-outlined\">schedule</i> <b>Ora di inizio:</b> ".$ora."<br>\n";
                    echo "<i class=\"material-symbols-outlined\">timelapse</i> <b>Durata:</b> ".$durata."<br>\n";

                    if ($plusCode == "2896%2b234 Castelmassa, Provincia di Rovigo") {
                        echo "<i class=\"material-symbols-outlined\">location_on</i> <b>Luogo:</b> ".$luogo."<br>\n";
                    } else {
                        echo "<i class=\"material-symbols-outlined\">location_on</i> <b>Luogo:</b> <a href=\"https://www.google.com/maps/place/".$plusCode."\" target=\"_blank\">".$luogo." <i class=\"material-symbols-outlined\" style=\"font-size: 16px;\">open_in_new</i></a><br>\n";
                    }
                    
                    echo "<i class=\"material-symbols-outlined\">event</i> <b>Tipo:</b> ".$tipo."<br>\n";
                    echo "<i class=\"material-symbols-outlined\">business</i> <b>Organizzatore:</b> ".$organizzatore."<br>\n";

                    if ($_SESSION['session_user_lele_planner_0425'] == "lele_administrator_admin" || $_SESSION['session_nome-societa_lele_planner_0425'] == $organizzatore) {
                        echo "<p><a href=\"../modifica/?id=$id\" class=\"changeBtn\">Modifica</a>&nbsp;&nbsp;&nbsp;|&nbsp;&nbsp;&nbsp;<a href=\"../elimina/?id=$id&organizzatore=$organizzatore&data=$str_data\" class=\"changeBtn\">Elimina</a></p>";
                        echo "<b>Ultima modifica:</b> ".$data_modifica;
                    }

                    echo '</div></div>';
                }
            }
        }
            ?>
        </div>

        <?php
        echo '<a class="material-symbols-outlined info" onclick="toggleDisplay()">info</a>';
        echo '<div id="credits" style="display: none;">';
        echo '<a target="_blank" href="https://icons8.com/icon/16713/whatsapp">WhatsApp</a> icon by <a target="_blank" href="https://icons8.com">Icons8</a><br>';
        echo '<a target="_blank" href="https://icons8.com/icon/114450/twitter-cerchiato">Twitter cerchiato</a> icon by <a target="_blank" href="https://icons8.com">Icons8</a><br>';
        echo '<a target="_blank" href="https://icons8.com/icon/uLWV5A9vXIPu/facebook-nuovo">Facebook Nuovo</a> icon by <a target="_blank" href="https://icons8.com">Icons8</a><br>';
        echo '<a target="_blank" href="https://icons8.com/icon/114445/linkedin-cerchiato">LinkedIn cerchiato</a> icon by <a target="_blank" href="https://icons8.com">Icons8</a><br>';
        echo '<a target="_blank" href="https://icons8.com/icon/kktvCbkDLbNb/link">Link</a> icon by <a target="_blank" href="https://icons8.com">Icons8</a>';
        echo '<!--Foto (sfondo) di <a href="https://unsplash.com/@antenna?utm_source=unsplash&utm_medium=referral&utm_content=creditCopyText">Antenna</a> su <a href="https://unsplash.com/it/s/foto/evento-sportivo?utm_source=unsplash&utm_medium=referral&utm_content=creditCopyText">Unsplash</a>-->';
        echo '</div>';
        echo '<script>function toggleDisplay() {if(document.getElementById("credits").style.display == "none"){document.getElementById("credits").style.display = "block"} else {document.getElementById("credits").style.display = "none"}}</script>';
        ?>
    </body>
</html>
