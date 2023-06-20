<?php
include '../default.php';
session_start();
$username = $_SESSION['session_user_lele_planner_0425'];
$nome = $_SESSION['session_nome_lele_planner_0425'];
$cognome = $_SESSION['session_cognome_lele_planner_0425'];
$ao = $_SESSION['session_ao_lele_planner_0425'];

$id_evento = $_GET['id'];

$str_data = $_GET['day'];
$data = date("d/m/Y", $str_data);

// Url condiviso sui social network per vedere l'evento dal planner
if (isset($id_evento) && $id_evento != "") {
    $url = $_SERVER["SERVER_NAME"].$_SERVER['PHP_SELF']."?id=".$id_evento;
} else {
    $url = $_SERVER["SERVER_NAME"].$_SERVER['PHP_SELF']."?day=".$str_data;
}

include '../config.php';
$db = 'planner';
$conn = mysqli_connect($host,$user,$pass, $db) or die (mysqli_error());
?>
<!DOCTYPE html>
<html lang="it">
    <head>
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">
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
        <!-- JavaScript -->
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.4/jquery.min.js"></script>
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
            <?php
            if (isset($id_evento) && is_numeric($id_evento)) {

            ?>
            <?php
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
                        // Parte per il calcolo della data e dell'ora di fine dell'evento per l'app Android
                        $end = explode(" ", $durata);
                        if (strpos($durata, " or") == null) {
                            if (strlen($end[0]) == 1) {
                                $end[0] = "0".$end[0];
                            }
                            $endTime = date("Ymd", $data)."00:".$end[0];
                        } else {
                            if (strlen($end[0]) == 1) {
                                $end[0] = "0".$end[0];
                            }
                            if (strlen($end[3]) == 1) {
                                $end[3] = "0".$end[3];
                            }
                            $endTime = date("Ymd", $data).$end[0].":".$end[3];
                        }

                        echo "<div class=\"informazioni\">";
                        echo "<h2 class=\"titolo\">".$titolo."</h2>\n";
                        echo "<i class=\"material-symbols-outlined\">calendar_today</i> <b>Data:</b> ".date("d/m/Y", $data)."<br>\n";
                        echo "<i class=\"material-symbols-outlined\">schedule</i> <b>Ora di inizio:</b> ".$ora."<br>\n";
                        echo "<i class=\"material-symbols-outlined\">timelapse</i> <b>Durata:</b> ".$durata."<br>\n";

                        echo getGoogleMapsLink($luogo, true);
                        
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
                        echo "<div id=\"descrizioneBtn\"><div id=\"dots\" style=\"float: right; position: relative; right: 15px; background: #ffffcc; padding-left: 4px;\">...</div><p class=\"descrizione\" id=\"descrizione\" style=\"height: auto;\"><b>".$tipo."</b>".$descrizione."</p></div>\n";
                        ?>
                        <script type="text/javascript">  
                            $(document).ready(function(){
                                if ($("#descrizione").height() > 50) {
                                    $("#descrizioneBtn").show();
                                    $("#dots").show();
                                    $("#descrizione").css("height","35px");
                                } else {
                                    $("#descrizioneBtn").hide();
                                    $("#dots").hide();
                                }
                            });
                            $("#descrizioneBtn").click(function(){
                                if ($("#descrizione").height() > 35) {
                                    $("#descrizione").css("height","35px");
                                    $("#dots").show();
                                    $("#descrizione").css("text-overflow","ellipsis");
                                } else {
                                    $("#descrizione").css("height","auto");
                                    $("#dots").hide();
                                    $("#descrizione").css("text-overflow","clip");
                                }
                            });
                        </script> 

                        <?php
                        if ($link_foto_video != "" && $link_foto_video != "locandina_default.png")
                            echo "<p><a href='showLocandina.php?url=".$link_foto_video."'><i class='material-symbols-outlined'>draft</i>Vedi locandina</a></p>";
                        
                        echo "<p><a onclick=\"addToAndroidCalendar('".$titolo."', '".$descrizione."', '".$luogo."', '".date("Ymd", $data).$ora."', '".$endTime."')\"><i class=\"material-symbols-outlined\">event</i> Aggiungi al calendario</a></p>";
                        echo "<p><a onclick=\"sharerEvent('".$titolo."','".$url."')\"><i class=\"material-symbols-outlined\">share</i> Condividi</a></p>";


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

                    echo "<div class=\"informazioni\">";
                    echo "<h2 class=\"titolo\">".$titolo."</h2>\n";
                    echo "<i class=\"material-symbols-outlined\">schedule</i> <b>Ora di inizio:</b> ".$ora."<br>\n";
                    echo "<i class=\"material-symbols-outlined\">timelapse</i> <b>Durata:</b> ".$durata."<br>\n";

                    echo getGoogleMapsLink($luogo, true);
                    
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
                    echo "<div id=\"descrizioneBtn".$id."\"><span id=\"dots".$id."\" style=\"float: right; position: relative; right: 15px; background: #ffffcc; padding-left: 4px;\">...</span><p class=\"descrizione\" id=\"descrizione".$id."\"><b>".$tipo."</b>".$descrizione."</p></div>\n";
                    ?>
                    <script type="text/javascript">  
                        $(document).ready(function(){
                            if ($("#descrizione<?php echo $id; ?>").height() > 50) {
                                $("#descrizioneBtn<?php echo $id; ?>").show();
                                $("#dots<?php echo $id; ?>").show();
                                $("#descrizione<?php echo $id; ?>").css("height","32px");
                            } else {
                                $("#descrizioneBtn<?php echo $id; ?>").hide();
                                $("#dots<?php echo $id; ?>").hide();
                            }
                        });
                        $("#descrizioneBtn<?php echo $id; ?>").click(function(){
                            if ($("#descrizione<?php echo $id; ?>").height() > 35) {
                                $("#descrizione<?php echo $id; ?>").css("height","32px");
                                $("#dots<?php echo $id; ?>").show();
                                $("#descrizione<?php echo $id; ?>").css("text-overflow","ellipsis");
                            } else {
                                $("#descrizione<?php echo $id; ?>").css("height","auto");
                                $("#dots<?php echo $id; ?>").hide();
                                $("#descrizione<?php echo $id; ?>").css("text-overflow","clip");
                            }
                        });
                    </script> 
                    <?php
                    echo "<img style='margin-top: 40px; width: 60px; margin-bottom: 30px;' alt='logo organizzatore' src='../settings/gestione-utenti/nuovo/".cripta($fetch2['logo'],"decrypt")."'><br>\n";
                    
                    if ($link_foto_video != "" && $link_foto_video != "locandina_default.png") {
                        echo "<hr>";
                        echo "<p><a href='showLocandina.php?url=".$link_foto_video."'><i class='material-symbols-outlined'>draft</i>Vedi locandina</a></p>";
                    }

                        // Parte per il calcolo della data e dell'ora di fine dell'evento per l'app Android
                        $end = explode(" ", $durata);
                        if (strpos($durata, " or") == null) {
                            if (strlen($end[0]) == 1) {
                                $end[0] = "0".$end[0];
                            }
                            $endTime = date("Ymd", $data)."00:".$end[0];
                        } else {
                            if (strlen($end[0]) == 1) {
                                $end[0] = "0".$end[0];
                            }
                            if (strlen($end[3]) == 1) {
                                $end[3] = "0".$end[3];
                            }
                            $endTime = date("Ymd", $data).$end[0].":".$end[3];
                        }
                        
                    echo "<hr>";
                    echo "<p><a onclick=\"addToAndroidCalendar('".$titolo."', '".$descrizione."', '".$luogo."', '".date("Ymd", $data).$ora."', '".$endTime."')\"><i class=\"material-symbols-outlined\">event</i> Aggiungi al calendario</a></p>";
                    echo "<hr>";
                    echo "<p><a onclick=\"sharerEvent('".$titolo."', '".$url."')\"><i class=\"material-symbols-outlined\">share</i> Condividi</a></p>";
                    echo "</div>";

                    if ($link_prenotazione != null || $link_prenotazione != "") {
                        echo "<a href=\"".$link_prenotazione."\" target=\"_blank\" title=\"Prenota evento\"><button class=\"prenotaBtn\"><i class=\"material-symbols-outlined\">book_online</i> Iscriviti all&apos;evento</button></a>";
                    }
                }
            }
        }

        echo "<script>
        // Funzione per aggiungere l'evento al calendario
        function addToAndroidCalendar(titolo, descrizione, luogo, dataInizio, dataFine) {
            APPlanner.addToCalendar(titolo, descrizione, luogo, dataInizio, dataFine);  /*'".$titolo."', '".$descrizione."', '".$luogo."', '".date("Ymd", $data).$ora."', '".$endTime."');*/
        }

        // Funzione per condividere l'evento con altre persone
        function sharerEvent(titolo, url) {
            APPlanner.shareEvent(titolo, url);
        }
    </script>";
            ?>
        </div>
    </body>
</html>
