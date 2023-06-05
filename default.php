<?php
$default_servername = "localhost";
$default_username = "lele_superuser";
$default_password = "9kQuc(F[D3G0!c9leeeeE41gr4r4gf5df55we38";
$default_dbname = "accesses";

// Nasconde gli errori agli utenti
ini_set("display_errors", false);

// Create connection
$default_conn = mysqli_connect($default_servername, $default_username, $default_password, $default_dbname);
$default_query = mysqli_query($default_conn,"SELECT * FROM systems") or die (mysqli_error($default_conn));
$default_fetch = mysqli_fetch_array($default_query) or die (mysqli_error());

// Nome della piattaforma
$nome_app = $default_fetch['appName'];
// LicenseKey usata per l'attivazione
$licenseKey = $default_fetch['licenseKey'];
// Versione della piattaforma
$version = $default_fetch['version'];

$dataValidity = date('Ymd');
// Stato della modalita' manutenzione (ATTIVATA/DISATTIVATA)
$maintenance = $default_fetch['maintenance'];

// Controllo sulla validita' della LicenseKey
if (!isset($licenseKey) || !is_numeric($licenseKey)) {
    header('Location: /planner-main/settings/error/error.php?status=err5801x24-License-Key');
}

// Controllo se la modalita' manutenzione e' attiva o no
if ($maintenance == "true") {
    // Verifico se l'utente e' il tecnico di manutenzione o l'admin per lasciargli la possibilita' di vedere la piattaforma anche in fase di manutenzione
    if ($_SESSION['session_user_lele_planner_0425'] != "maintenance" && $_SESSION['session_user_lele_planner_0425'] != "lele_administrator_admin") {
        header('Location: /planner-main/settings/error/error.php?status=err5077x26-Maintenance');
    }
    echo "<script>alert('Sei in modalità manutenzione!');</script>";
}

function writeRecord($data) {
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
}

function cripta($string, $method) {
    $secretKey = "fdgjgtn544h1th1gb1ff";
    $secretIv = "fg4g4g1t11gfcfss";

    $algorithm = "AES-256-CBC";
    $key = hash("sha256", $secretKey);
    $iv = substr(hash('sha256', $secretIv), 0, 16);

    if ($method == "encrypt") {
        $output = base64_encode(openssl_encrypt($string, $algorithm, $key, 0, $iv));
    }

    if ($method == "decrypt") {
        $output = stripslashes(openssl_decrypt(base64_decode($string), $algorithm, $key, 0, $iv));
    }

    return $output;
}

// Funzione per mostrare link di Google Maps per i luoghi piu' conosciuti (usato in evento/index.php e app/evento.php)
function getGoogleMapsLink($luogo, $materialSimbols) {
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
        case 'Piazza Giuseppe Garibaldi':
            $plusCode = "2895%2B2W Castelmassa, Provincia di Rovigo";
            break;
        case 'Piazza Vittorio Veneto':
            $plusCode = "2886%2BX4 Castelmassa, Provincia di Rovigo";
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


    if ($materialSimbols == true) {
        if ($plusCode == "2896%2b234 Castelmassa, Provincia di Rovigo") {
            return "<i class=\"material-symbols-outlined\">place</i> <b>Luogo:</b> ".$luogo."<br>\n";
        } else {
            return "<i class=\"material-symbols-outlined\">place</i> <b>Luogo:</b> <a href=\"https://www.google.com/maps/place/".$plusCode."\" target=\"_blank\">".$luogo." <i class=\"material-symbols-outlined\" style=\"font-size: 16px;\">launch</i></a><br>\n";
        }
    } else {
        if ($plusCode == "2896%2b234 Castelmassa, Provincia di Rovigo") {
            return "<i class=\"material-icons\">place</i> <b>Luogo:</b> ".$luogo."<br>\n";
        } else {
            return "<i class=\"material-icons\">place</i> <b>Luogo:</b> <a href=\"https://www.google.com/maps/place/".$plusCode."\" target=\"_blank\">".$luogo." <i class=\"material-icons\" style=\"font-size: 16px;\">launch</i></a><br>\n";
        }
    }
}
?>
