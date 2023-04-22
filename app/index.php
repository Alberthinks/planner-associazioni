<?php
session_start();
include "../default.php";
$username = $_SESSION['session_user_lele_planner_0425'];
$nome = $_SESSION['session_nome_lele_planner_0425'];
$cognome = $_SESSION['session_cognome_lele_planner_0425'];
$ao = $_SESSION['session_ao_lele_planner_0425'];
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
        <title>Planner | <?php echo $nome_app; ?></title>
        <!-- CSS -->
        <link rel="stylesheet" href="../css/default_phone.css" type="text/css">
        <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@48,400,0,0">
    </head>
    <body style="overflow: hidden;">
        <center>
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
                        "Lun",
                        "Mar",
                        "Mer",
                        "Gio",
                        "Ven",
                        "Sab",
                        "Dom"
                    );

                    // Valore usato dall'app AP Planner per mostrare solo gli eventi di una determinata associazione
                    $plannerIDnumber = $_GET['plannerID'];
                    switch ($plannerIDnumber) {
                        case 0:
                            $plannerID = "I.I.S. Primo Levi - Badia Polesine";
                            break;
                        case 1:
                            $plannerID = "G.S.D. TOR";
                            break;
                        case 2:
                            $plannerID = "I.I.S. Primo Levi - Badia Polesine";
                            break;
                        default:
                            $plannerID = "";
                    }

                    $cols = 7;
                    $days = date("t",mktime(0, 0, 0, $m, 1, $y)); 
                    $lunedi= date("w",mktime(0, 0, 0, $m, 1, $y));
                    if($lunedi==0) $lunedi = 7;
                    echo "<table>\n"; 
                    echo "<tr>\n
                    <th class=\"mese\" colspan=\"2\">\n
                    <a class=\"cambia_mese material-symbols-outlined\" style=\"padding-left: 10px; padding-right: 0;\" href=\"?plannerID=".$plannerIDnumber."&d=" . $precedente . "\">arrow_back_ios</a>\n
                    </th>\n
                    <th class=\"mese\" colspan=\"3\">\n
                    " . $nomi_mesi[$m-1] . " " . $y . "
                    </th>\n
                    <th class=\"mese\" colspan=\"2\">
                    <a class=\"cambia_mese material-symbols-outlined\" href=\"?plannerID=".$plannerIDnumber."&d=" . $successivo . "\">arrow_forward_ios</a>\n
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
                            include '../config.php';
                            
                            $db = 'planner';
                            $conn = mysqli_connect($host,$user,$pass, $db) or die (mysqli_error());
                            
                            $result = mysqli_query($conn,"SELECT data FROM planner") or die (mysqli_error($conn));
                            
                            // Elimino record salvati da + di 2 anni
                            $deleteSQL = mysqli_query($conn,"DELETE from planner WHERE validity <= CURDATE() - 20000") or die (mysqli_error($conn));

                            if(mysqli_num_rows($result) > 0)
                            {
                                while($fetch = mysqli_fetch_array($result))
                                {
                                    $str_data = $fetch['data'];
                                    if ($str_data == $data)
                                    {
                                        $sql = "SELECT * FROM planner WHERE data=$str_data AND organizzatore='$plannerID'";
                                        //$sql = "SELECT * FROM planner WHERE data=$str_data";
                                        $result = mysqli_query($conn,$sql) or die (mysqli_error($conn));
                                        
                                        if(mysqli_num_rows($result) == 1)
                                        {
                                            while($fetch = mysqli_fetch_array($result))
                                            {
                                                $id = stripslashes($fetch['id']);
                                                $titolo = stripslashes($fetch['titolo']);
                                                $data_evento = date("d-m-Y", $fetch['data']);
                                            }
                                        
                                            $contenuto = "<div class=\"nota\" onclick=\"openEvent(".$id.", 'null')\">
                                                            <p class=\"title\">".$titolo."</p>
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
                                            
                                                $contenuto = "<a onclick=\"openEvent(".$str_data.", '".date("d/m/Y", $str_data)."')\"><div class=\"nota multipla\">".$num_rows." eventi...</div></a>";
                                        }
                                    }
                                }
                            }

                            if($data == $oggi)
                            {
                                echo "<td class=\"oggi\"><span class=\"data\">".$day."</span>".$contenuto."</td>";
                            } else {
                                echo "<td><span class=\"data\">".$day."</span>".$contenuto."</td>";
                            }
                        }

                        if($j%$cols==0)
                        {
                        echo "</tr>";
                        }
                    }

                    echo "<script>
                            // Funzione per aggiungere l'evento al calendario
                            function openEvent(id, date) {
                                APPlanner.eventDetails(id, date);
                            }
                        </script>";

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
    </body>
</html>
